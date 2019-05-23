// USES REMIX compile version: "Current version:0.5.5-nightly.2019.2.28+commit.e954d83.Emscripten.clang"
// REMIX requires buyerToEscrow(address payable _recevier) and escrowToSeller(address payable _recevier) instead

// Contract address => escrow (use truffle to get the contract address when deployed)
// Account 1 => seller address
// Account 2 => buyer address

// convert uint to wei (*1e18)

pragma solidity >= 0.4.0 < 0.6.0;

contract ItemListing {
    
    uint private itemPrice;                                                 // price of the item
    string private itemName;                                                // name of the item
    address private curr_selleradd;                                         // address of the seller selling this item
    int private prodId;                                                     // the id of item

    constructor () public payable {
        curr_selleradd = msg.sender;
    }

    function ItemList (string memory item_Name, uint item_Price) public returns (uint) {
        itemName = item_Name;
        itemPrice = item_Price;
        return 1;
    }

    // get constructor - ItemPrice
    function getItemPrice() public view returns (uint) {
        return itemPrice;   
    }

    //get constructor - ItemName
    function getItemName() public view returns (string memory) {
        return itemName;
    }
    
    // get constructor - whose creating the contract (seller)
    function getSellerAdd() public view returns (address) {
        return curr_selleradd;
    }
    
    // get constructor - the contract address
    function getItemListContractAdd() public view returns (address) {
        return address(this);
    }
}

contract EscrowCon {
    uint public itemAmt;   // the price of the item
    address public buyer;   // buyer address
    address public seller;  // seller address
    uint private start;     // set the timestamp
    ItemListing iL;

    // maps addresses to balances e.g. hashtables
    mapping (address => uint) public balances;

    // events allow light clients to react to changes efficiently
    event Transfer(address indexed from, address indexed to, uint amount);

    // this is the constructor whose code is run only when the contract is created
    constructor (address ItemListContractAddress) public {
        iL = ItemListing(ItemListContractAddress);
        seller = iL.getSellerAdd();                                             // pass the seller_add to this contract
        itemAmt = iL.getItemPrice();                                            // set the item price (in ether)
    }

    function () external payable { }

    // payment buyer to escrow - will display to buyer escrow address so buyer can send it to escrow instead of seller
    function buyerToEscrow(address payable _recevier) public payable {
        require(msg.value == getItemAmt(), "Input wrong payment amount.");
        require(msg.value <= getAccBal(msg.sender), "Insufficient balance.");   // check buyer balance got sufficient funds
        _recevier.transfer(msg.value);                                          // send money to recevier (the contract address)
        buyer = msg.sender;                                                     // when buyer click on buy, buyer will create the contract
        start = now;                                                            //now is an alias for block.timestamp, not really "now"
        emit Transfer(msg.sender, _recevier, msg.value);
    }

    // escrow release funds to seller
    function escrowToSeller(address payable _recevier) public payable {
        uint amt = getItemAmt();
        require(_recevier == seller, "Error during fund release.");
        require(amt <= getContractBal(), "Error.");                             // check escrow balance got sufficient funds
        //balances[escrow] -= amt;                                              // deduct money from escrow
        //balances[seller] += amt;                                              // add money to seller
        _recevier.transfer(address(this).balance);
        //emit Transfer(escrow, seller, amt);
    }

    // get constructor - whose creating the contract (buyer)
    function getBuyerAdd() public view returns (address) {
        return buyer;
    }

    // get constructor - the amount the buyer is paying
    function getMsgValue() public payable returns (uint) {
        return msg.value;
    }

    // get constructor - the contract address
    function getEscrowContractAdd() public view returns (address) {
        return address(this);
    }

    // get constructor - ItemAmt
    function getItemAmt() public view returns (uint) {
        return itemAmt*1e18;                                                    // convert uint to wei
    }

    // get constructor - balance from specific address
    function getAccBal(address _account) public view returns (uint) {
        return _account.balance;                                                // we can convert wei to ether by dividing it with 1e18
    }

    //get constructor - balance of the contract
    function getContractBal() public view returns (uint) {
        return address(this).balance;
    }
}