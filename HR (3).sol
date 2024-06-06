// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract Vakancy {
    string private vacancy;
    uint256 private balance;
    address private owner;
    uint256 private candidateCount;

    struct CandidateInfo {
        string candidate;
        string dataCandidate;
        address provider;
        uint256 id;
        string rejectionReason; // Причина отказа
    }

    enum CandidateStatus { Considered, Accepted, Rejected }

    mapping(uint256 => CandidateInfo) private consideredCandidates; // Маппинг ожидаемых кандидатов
    mapping(uint256 => CandidateInfo) private acceptedCandidates; // Маппинг принятых кандидатов
    mapping(uint256 => CandidateInfo) private rejectedCandidates; // Маппинг отклоненных кандидатов
    mapping(address => CandidateInfo[]) private candidatesByProvider;

    constructor(string memory _vacancy) payable {
        vacancy = _vacancy;
        balance = msg.value;
        owner = msg.sender;
        candidateCount = 0;
    }

    modifier onlyOwner() {
        require(msg.sender == owner, "Only contract owner can call this function");
        _;
    }

    function getVacancy() public view returns (string memory) {
        return vacancy;
    }

    function getBalance() public view returns (uint256) {
        return balance;
    }

    function submitCandidate(
        string memory _candidate,
        string memory _dataCandidate
    ) public returns (uint256) {
        candidateCount++;
        uint256 id = candidateCount;
        consideredCandidates[id] = CandidateInfo(_candidate, _dataCandidate, msg.sender, id, ""); // Updated mapping usage
        candidatesByProvider[msg.sender].push(CandidateInfo(_candidate, _dataCandidate, msg.sender, id, ""));
        return id;
    }



    function getCandidateById(uint256 _id) public view returns (string memory, string memory, address, string memory, string memory) {
    if (consideredCandidates[_id].id == _id) {
        CandidateInfo memory candidate = consideredCandidates[_id];
        return (candidate.candidate, candidate.dataCandidate, candidate.provider, "considered", "");
    } else if (acceptedCandidates[_id].id == _id) {
        CandidateInfo memory candidate = acceptedCandidates[_id];
        return (candidate.candidate, candidate.dataCandidate, candidate.provider, "accepted", "");
    } else if (rejectedCandidates[_id].id == _id) {
        CandidateInfo memory candidate = rejectedCandidates[_id];
        return (candidate.candidate, candidate.dataCandidate, candidate.provider, "rejected", candidate.rejectionReason);
    } else {
        revert("Candidate not found");
    }
}




    function acceptCandidate(uint256 _id) public payable onlyOwner {
        require(consideredCandidates[_id].id == _id, "Candidate not found in considered candidates");
        address payable provider = payable(consideredCandidates[_id].provider);
        uint256 payment = balance;
        provider.transfer(payment); // Перевод всего баланса контракта в адрес провайдера кандидата
        acceptedCandidates[_id] = consideredCandidates[_id];
        delete consideredCandidates[_id];
        balance = 0; // Обнуляем баланс контракта после перевода всех средств
    }

    function deleteCandidate(uint256 _id, string memory _rejectionReason) public onlyOwner {
        require(consideredCandidates[_id].id == _id, "Candidate not found in considered candidates");
        rejectedCandidates[_id] = consideredCandidates[_id]; // Перемещение кандидата в маппинг отклоненных
        rejectedCandidates[_id].rejectionReason = _rejectionReason; // Сохранение причины отказа
        delete consideredCandidates[_id]; // Удаление из маппинга ожидающих
    }

    function getConsideredCandidates() public view onlyOwner returns (CandidateInfo[] memory) {
    CandidateInfo[] memory considered = new CandidateInfo[](candidateCount);
    uint256 index = 0;
    for (uint256 i = 1; i <= candidateCount; i++) {
        if (consideredCandidates[i].id == i) {
            considered[index] = consideredCandidates[i];
            index++;
        }
    }
    // Создаем новый массив с правильным размером
    CandidateInfo[] memory result = new CandidateInfo[](index);
    for (uint256 j = 0; j < index; j++) {
        result[j] = considered[j];
    }
    return result;
}


}
