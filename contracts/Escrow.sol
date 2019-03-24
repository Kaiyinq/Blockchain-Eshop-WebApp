// USES REMIX compile version: "Current version:0.5.5-nightly.2019.2.28+commit.e954d83.Emscripten.clang"
// REMIX requires buyerToEscrow(address payable _recevier) and escrowToSeller(address payable _recevier) instead

// Contract address => escrow (use truffle to get the contract address when deployed)
// Account 0 => seller address
// Account 1 => buyer address

// convert 1 ether = 1*1e18 wei

pragma solidity >= 0.4.0 < 0.6.0;

contract ItemListing {
    
    uint private itemPrice;                                                 // price of the item
    string private itemName;                                                // name of the item
    address private curr_selleradd;                                         // address of the seller selling this item
    uint private prodId;                                                    // the id of item

    constructor () public payable {
        curr_selleradd = msg.sender;
    }

    function ItemList (uint prod_id, string memory item_Name, uint item_Price) public returns (uint) {
        prodId = prod_id;
        itemName = item_Name;
        itemPrice = item_Price;                                             // price is in wei      
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
    
    //get constructor - ProdID
    function getProdID() public view returns (uint) {
        return prodId;
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
    uint private itemAmt;                                                       // the price of the item
    address private buyer;                                                      // buyer address
    address private seller;                                                     // seller address
    address payable escrowContractAdd;                                          // escrow contract address
    uint private start;                                                         // set the timestamp
    ItemListing iL;

    // maps addresses to balances e.g. hashtables
    mapping (address => uint) public balances;

    // events allow light clients to react to changes efficiently
    event Transfer(address indexed from, address indexed to, uint amount);

    // this is the constructor whose code is run only when the contract is created
    constructor (address ItemListContractAddress) public {
        iL = ItemListing(ItemListContractAddress);
        seller = iL.getSellerAdd();                                             // pass the seller_add to this contract
        itemAmt = iL.getItemPrice();                                            // set the item price (in wei)
    }

    function () external payable { }

    // payment buyer to escrow - will display to buyer escrow address so buyer  
    // SEND IT TO ESCROW instead of seller
    function buyerToEscrow(address payable _recevier) public payable returns (bool) {
        require(msg.value == getItemAmt(), "Input wrong payment amount.");      // payment made in wei
        require(msg.value <= getAccBal(msg.sender), "Insufficient balance.");   // check buyer balance got sufficient funds
        //require(msg.sender != seller, "Buyer is seller.");                      // check that seller is not buying its own item
         //escrowContractAdd = address(this);                                   // put this contract address to a payable address escrowContractAdd
        _recevier.transfer(msg.value);                                          // send money to recevier (the contract address)
        buyer = msg.sender;                                                     // when buyer click on buy, buyer will create the contract
        start = now;                                                            //now is an alias for block.timestamp, not really "now"
        emit Transfer(msg.sender, _recevier, msg.value);
        return true;
    }

    // escrow release funds to seller
    function escrowToSeller(address payable _recevier) public payable {
        uint amt = getItemAmt();       
        require(_recevier == seller, "Error during fund release.");             // check that address inputted by system is seller address
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

    // get constructor - seller address
    function getSellerAdd() public view returns (address) {
        return seller;
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
        return itemAmt;                                                    
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