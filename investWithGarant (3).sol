// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

import "@openzeppelin/contracts/utils/Strings.sol";

contract ParentContract {
    // Address of the deployed PaymentContract
    address public paymentContractAddress;
    // Address of the owner of the deployed PaymentContract
    address public ownerOfPaymentContract;

    // Event emitted when PaymentContract is deployed
    event PaymentContractDeployed(address indexed paymentContractAddress, address indexed owner);

    // Function to deploy PaymentContract and set the owner
    function deployAndSetOwner(uint256 _targetAmount, address _guarantor) external {
        // Deploy the PaymentContract with the sender's address as the owner and the guarantor address
        PaymentContract pc = new PaymentContract(msg.sender, _targetAmount, _guarantor);
        // Set the paymentContractAddress
        paymentContractAddress = address(pc);
        // Set the ownerOfPaymentContract
        ownerOfPaymentContract = msg.sender;
        // Emit an event
        emit PaymentContractDeployed(paymentContractAddress, ownerOfPaymentContract);
    }
}

contract PaymentContract {
    address internal owner;
    uint256 internal requiredBalance;
    uint256 internal totalReceived;
    bool internal paymentSent = false;

    mapping(address => uint256) internal participantBalances;
    mapping(address => uint256) internal ownerPayments;
    mapping(address => bool) internal registeredWallets;
    mapping(address => bool) internal withdrawPermissions;
    address[] internal paidParticipants;
    address[] internal registeredWalletList;

    bool internal registrationClosed;
    bool internal fundsTransferBlocked;
    address internal guarantor;

    struct ContractData {
        address paymentContractAddress;
        address ownerOfPaymentContract;
        uint256 requiredBalance;
        uint256 totalReceived;
        uint256 numberOfParticipants;
        uint256 numberOfPermissions;
        bool registrationClosed;
        bool fundsTransferBlocked;
    }

    event Transfer(address indexed _from, uint256 _value);
    event WalletRegistered(address indexed _wallet);
    event FundsReceived(address indexed _from, uint256 _amount);
    event WithdrawPermissionGranted(address indexed _wallet);
    event WithdrawPermissionRevoked(address indexed _wallet);
    event RegistrationClosed();
    event FundsTransferBlocked();
    event FundsReturned(address indexed _to, uint256 _amount);
    event GuarantorPermissionGranted(address indexed _guarantor);
    event GuarantorPermissionRevoked(address indexed _guarantor);

    constructor(address _owner, uint256 _requiredBalance, address _guarantor) {
        owner = _owner;
        requiredBalance = _requiredBalance;
        guarantor = _guarantor;
    }

    modifier onlyOwner() {
        require(msg.sender == owner, "Only contract owner can call this function");
        _;
    }

    modifier onlyOwnerOrGuarantor() {
        require(msg.sender == owner || msg.sender == guarantor, "Only contract owner or guarantor can call this function");
        _;
    }

    modifier onlyOwnerExceptRegistration() {
        require(msg.sender != owner, "Owner cannot call this function");
        require(msg.sender == owner && !registrationClosed, "Only contract owner can call this function and registration should be open");
        _;
    }

    modifier onlyRegisteredWallet() {
        require(registeredWallets[msg.sender], "Only registered wallets can call this function");
        _;
    }

    function getTypeContracts() external pure returns (string memory) {
        return "invest";
    }

    function getContractData() external view returns (string memory) {
        string memory contractData = string(abi.encodePacked(
            "Address of the contract: ", 
            Strings.toHexString(uint160(address(this)), 20), 
            "\n",
            "Required balance: ", 
            Strings.toString(requiredBalance), 
            "\n",
            "Total received: ", 
            Strings.toString(totalReceived), 
            "\n",
            "Number of participants: ", 
            Strings.toString(registeredWalletList.length), 
            "\n",
            "Number of permissions: ", 
            Strings.toString(countGrantedPermissions()), 
            "\n",
            "Registration closed: ", 
            registrationClosed ? "Yes" : "No", 
            "\n",
            "Funds transfer blocked: ", 
            fundsTransferBlocked ? "Yes" : "No"
        ));

        return contractData;
    }

    function countGrantedPermissions() internal view returns (uint256) {
        uint256 count = 0;
        for (uint256 i = 0; i < registeredWalletList.length; i++) {
            if (withdrawPermissions[registeredWalletList[i]]) {
                count = count + 1;
            }
        }
        return count;
    }

    function sendPayment() external onlyOwner {
    require(!paymentSent, "Payment already sent");
    require(totalReceived >= requiredBalance, "Required balance not reached");
    require(!fundsTransferBlocked || msg.sender == owner, "Funds transfer is blocked");

    uint256 contractBalance = address(this).balance;
    require(contractBalance > 0, "Contract balance is empty");
    require(allWithdrawPermissionsGranted(), "Not all registered wallets granted withdraw permission");
    require(withdrawPermissions[guarantor], "Guarantor has not given permission");

    uint256 allowedParticipantsCount = 0;
    for (uint256 i = 0; i < registeredWalletList.length; i++) {
        if (withdrawPermissions[registeredWalletList[i]]) {
            allowedParticipantsCount = allowedParticipantsCount + 1;
        }
    }

    require(allowedParticipantsCount * 2 > registeredWalletList.length, "Less than 50% of participants allowed withdrawal");

    uint256 guarantorFee = (contractBalance * 8) / 100;
    uint256 platformFee = (contractBalance * 2) / 100;
    uint256 remainingBalance = contractBalance - guarantorFee - platformFee;

    payable(guarantor).transfer(guarantorFee);
    payable(0x9B6b79fbdE6B5972Aa11EB29a4a36bFb30D0605F).transfer(platformFee);
    payable(owner).transfer(remainingBalance);

    emit Transfer(owner, remainingBalance);
    emit FundsTransferBlocked();
    emit FundsReturned(guarantor, guarantorFee);
    emit FundsReturned(0x9B6b79fbdE6B5972Aa11EB29a4a36bFb30D0605F, platformFee);
    emit FundsReturned(owner, remainingBalance);

    fundsTransferBlocked = true;
    paymentSent = true;
}


    function getBalance() external view returns (uint256) {
        return participantBalances[msg.sender];
    }

    function registerWallet() external {
        require(msg.sender != owner, "Contract owner cannot register wallet");
        require(!registeredWallets[msg.sender], "Wallet already registered");
        require(!registrationClosed, "Registration is closed");
        require(registeredWalletList.length < requiredBalance, "Maximum number of wallets registered");
        require(totalReceived < requiredBalance, "Maximum funds limit reached, registration closed");

        registeredWallets[msg.sender] = true;
        registeredWalletList.push(msg.sender);
        emit WalletRegistered(msg.sender);

        if (registeredWalletList.length >= requiredBalance) {
            registrationClosed = true;
            emit RegistrationClosed();
        }
    }

    function grantWithdrawPermission() external  {
        require(registeredWallets[msg.sender], "Wallet not registered");
        withdrawPermissions[msg.sender] = true;
        emit WithdrawPermissionGranted(msg.sender);
    }

    function revokeWithdrawPermission() external  {
        withdrawPermissions[msg.sender] = false;
        emit WithdrawPermissionRevoked(msg.sender);
    }

    function checkBalance() external view returns (uint256) {
        require(registeredWallets[msg.sender], "Wallet not registered");
        return participantBalances[msg.sender];
    }

    function checkContractBalance() external view returns (uint256) {
        return address(this).balance;
    }

    function sendFundsToContract() external payable {
        require(msg.value > 0, "No funds sent");
        require(!fundsTransferBlocked || msg.sender == owner, "Funds transfer is blocked");
        require(registeredWallets[msg.sender] || msg.sender == owner || msg.sender == guarantor, "Sender not registered");

        if (msg.sender == owner) {
            uint256 totalContributions = 0;
            for (uint256 i = 0; i < registeredWalletList.length; i++) {
                totalContributions = totalContributions + participantBalances[registeredWalletList[i]];
            }
            
            for (uint256 i = 0; i < registeredWalletList.length; i++) {
                uint256 share = (msg.value * participantBalances[registeredWalletList[i]]) / totalContributions;
                ownerPayments[registeredWalletList[i]] = ownerPayments[registeredWalletList[i]] + share;
                emit FundsReceived(registeredWalletList[i], share);
            }
        } else {
            require(totalReceived + msg.value <= requiredBalance, "Balance limit exceeded");

            paidParticipants.push(msg.sender);
            participantBalances[msg.sender] = participantBalances[msg.sender] + msg.value;

            totalReceived = totalReceived + msg.value;
            emit FundsReceived(msg.sender, msg.value);
        }
    }

    function getPaidParticipants() external view returns (address[] memory) {
        return paidParticipants;
    }

    function getOwner() external view returns (address) {
        return owner;
    }

    function getGuarantor() external view returns (address) {
        return guarantor;
    }

    function allWithdrawPermissionsGranted() internal view returns (bool) {
        uint256 allowedParticipantsCount = 0;
        for (uint256 i = 0; i < registeredWalletList.length; i++) {
            if (withdrawPermissions[registeredWalletList[i]]) {
                allowedParticipantsCount = allowedParticipantsCount + 1;
            }
        }

        return allowedParticipantsCount * 2 > registeredWalletList.length;
    }

    function takeMoney() external returns (uint256) {
        require(registeredWallets[msg.sender], "Wallet not registered");

        uint256 amount = ownerPayments[msg.sender];
        require(amount > 0, "No funds found for the sender");

        ownerPayments[msg.sender] = 0;

        payable(msg.sender).transfer(amount);
        emit FundsReturned(msg.sender, amount);

        return amount;
    }

    function getRequiredBalance() external view returns (uint256) {
        return requiredBalance;
    }

    function getParticipantContribution() external view returns (uint256) {
        return participantBalances[msg.sender];
    }

    function getParticipantPayment() external view returns (uint256) {
        return ownerPayments[msg.sender];
    }

    function getRegisteredWallets() external view returns (address[] memory) {
        return registeredWalletList;
    }

    function getWithdrawPermissions() external view returns (address[] memory) {
        address[] memory allowedWallets = new address[](registeredWalletList.length);
        uint256 index = 0;
        for (uint256 i = 0; i < registeredWalletList.length; i++) {
            if (withdrawPermissions[registeredWalletList[i]]) {
                allowedWallets[index] = registeredWalletList[i];
                index++;
            }
        }
        return allowedWallets;
    }
}
