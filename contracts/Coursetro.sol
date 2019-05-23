// USES REMIX compile version: "Current version:0.4.23-nightly.2018.4.19+commit.ae834e3d.Emscripten.clang"

pragma solidity ^0.5.0;

contract Coursetro {
    string fName;
    uint age;

    function setInstructor(string memory _fName, uint _age) public {
        fName = _fName;
        age = _age;
    }

    function getInstructor() public view returns (string memory, uint) {
        return (fName, age);
    }

}
