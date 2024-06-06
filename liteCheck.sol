// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

import "@openzeppelin/contracts/utils/Strings.sol";

contract ParentContract {
    address private paymentContractAddress;
    address private ownerOfPaymentContract;

    event PaymentContractDeployed(address indexed paymentContractAddress, address indexed owner);

    modifier onlyNotContract() {
        require(!_isContract(msg.sender), "Contracts are not allowed to deploy PaymentContract");
        _;
    }

    function _isContract(address _addr) private view returns (bool) {
        uint256 size;
        assembly {
            size := extcodesize(_addr)
        }
        return size > 0;
    }

    function deployAndSetOwner(uint256 _targetAmount) external onlyNotContract {
        PaymentContract pc = new PaymentContract(msg.sender, _targetAmount);
        paymentContractAddress = address(pc);
        ownerOfPaymentContract = msg.sender;
        emit PaymentContractDeployed(paymentContractAddress, ownerOfPaymentContract);
    }
}

contract PaymentContract {
    address private owner;
    uint256 private requiredBalance;
    uint256 private totalReceived;
    bool private paymentSent = false;
    bool private fundsTransferBlocked;

    mapping(address => uint256) private participantBalances;

    event Transfer(address indexed _from, uint256 _value);
    event FundsReceived(address indexed _from, uint256 _amount);
    event FundsTransferBlocked();

    modifier onlyOwner() {
        require(msg.sender == owner, "Only contract owner can call this function");
        _;
    }

    function _isContract(address _addr) private view returns (bool) {
        uint256 size;
        assembly {
            size := extcodesize(_addr)
        }
        return size > 0;
    }

    constructor(address _owner, uint256 _requiredBalance) {
        require(!_isContract(_owner), "Smart contract addresses are not allowed to own PaymentContract");
        owner = _owner;
        requiredBalance = _requiredBalance;
    }

    function getTypeContracts() external pure returns (string memory) {
        return "lite";
    }

    function sendPayment() external onlyOwner {
        require(!paymentSent, "Payment already sent");
        require(totalReceived >= requiredBalance, "Required balance not reached");
        require(!fundsTransferBlocked || msg.sender == owner, "Funds transfer is blocked");
        require(address(this).balance > 0, "Contract balance is empty");

        payable(owner).transfer(address(this).balance);
        emit Transfer(owner, address(this).balance);

        fundsTransferBlocked = true;
        paymentSent = true;
        emit FundsTransferBlocked();
    }

    function getBalance() external view returns (uint256) {
        return participantBalances[msg.sender];
    }

    function checkContractBalance() external view returns (uint256) {
        return address(this).balance;
    }

    function sendFundsToContract() external payable {
        require(msg.value > 0, "No funds sent");
        require(totalReceived + msg.value <= requiredBalance, "Balance limit exceeded");
        participantBalances[msg.sender] += msg.value;
        totalReceived += msg.value;
        emit FundsReceived(msg.sender, msg.value);
    }

    function getOwner() external view returns (address) {
        return owner;
    }

    function takeMoney() external returns (uint256) {
        require(participantBalances[msg.sender] > 0, "No funds found for the sender");

        uint256 amount = participantBalances[msg.sender];
        participantBalances[msg.sender] = 0;
        totalReceived -= amount;
        
        // Update remaining balance
        uint256 remainingBalance = requiredBalance - totalReceived;

        payable(msg.sender).transfer(amount);

        return remainingBalance;
    }

    function getRequiredBalance() external view returns (uint256) {
        return requiredBalance;
    }

    function getParticipantContribution() external view returns (uint256) {
        return participantBalances[msg.sender];
    }

    function getRemainingBalanceNeeded() external view returns (uint256) {
        return requiredBalance - totalReceived;
    }

    function getContractData() external view returns (string memory) {
    string memory contractData = string(abi.encodePacked(
        "Address of the contract: ", 
        Strings.toHexString(uint160(address(this)), 20), 
        "\n",
        "Address of the owner: ", 
        Strings.toHexString(uint160(owner), 20), 
        "\n",
        "Required balance: ", 
        Strings.toString(requiredBalance), 
        "\n",
        "Total received: ", 
        Strings.toString(totalReceived)
    ));

    return contractData;
}
}
