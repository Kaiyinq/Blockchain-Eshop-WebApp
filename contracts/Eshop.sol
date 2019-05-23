// USES REMIX compile version: "Current version:0.5.5-nightly.2019.2.28+commit.e954d83.Emscripten.clang"
// REMIX requires buyerToEscrow(address payable _recevier) and escrowToSeller(address payable _recevier) instead

// selfdestruct(address) - sends all of the contract's current balance to address

// Contract address => escrow (use truffle to get the contract address when deployed)
// Account 0 => seller address
// Account 1 => buyer address

// convert 1 ether = 1*1e18 wei

// ALL payments in contract are made in wei
// buyerToEscrow() - receiver is escrow contractadd
// escrowToSeller() - receiver is seller contractadd

pragma solidity >= 0.4.0 < 0.6.0;

contract Users {
    
    struct Entry {
        address userAdd;
        bool used;
    }
    
    mapping (int256 => Entry) private users;
    address[] private userAccts;
    
    address private owner;
    
    constructor() public {
        owner = msg.sender;
    }

    // add user phone account and ethereum address to prevent duplicate account made
    function addUser(int256 phone_No) public {
        require(!users[phone_No].used, "This phone number is invalid for use.");
        require(!getExistingAdd(msg.sender), "This ethereum account is invalid for use.");
        users[phone_No] = Entry(msg.sender, true);
        userAccts.push(msg.sender);
    }
    
    // get the user address based on their phone number
    function getUser(int phone_No) public view returns (address) {
        return users[phone_No].userAdd;
    }
    
    // if address is added before in userAccts, then return true. otherwise, false 
    function getExistingAdd(address _address) public view returns (bool) {
        for (uint256 i = 0; i < userAccts.length; i++) {
            if (userAccts[i] == _address)
                return true;
        }
        return false;
    }
    
    // if users want to edit their linked ethereum account to another account number
    function editAdd(int256 phone_No) public {
        users[phone_No] = Entry(msg.sender, true);
    }
    
     // get constructor - whose creating the contract (seller)
    function getOwnerAdd() public view returns (address) {
        return owner;
    }
    
    // REPUTATION SYSTEM FOR SELLER
    // struct Feedback {
    //     uint score;
    //     uint date;
    //     address contractAdd;                // order contract address
    //     address submittedBy;                // buyer address
    // }
    
    mapping (address => bool) orderlists;               // ensure that its a list of correct order contract
    //mapping (address => Feedback) feedback;
    mapping (address => uint256) public totalCount;
    mapping (address => uint256) public scoreSum;
    address sellerAdd;
    
    mapping (address => uint256) public refundCount;
    mapping (address => uint256) public orderCount;
    address buyerAdd;
    
    event SubmitFeedback(address indexed _from, address indexed _to, address indexed _orderAddress, uint date, uint _score);
    
    // when buyer submit feedback - buyer phone number
    function submitFeedback(address _orderAddress, uint _score, int256 buyer_phoneNo, int256 seller_phoneNo) public {
        require(msg.sender == getUser(buyer_phoneNo), "Wrong account.");        // check that seller is using the linked ethereum account
        require(_score >= 0 && _score <= 5);
        require(!orderlists[_orderAddress], "Order address is invalid for use.");
        // require(_orderAddress != address(0));
    
        sellerAdd = getUser(seller_phoneNo);
        buyerAdd = getUser(buyer_phoneNo);
        
        // feedback[sellerAdd].date = now;
        // feedback[sellerAdd].contractAdd = _orderAddress;
        // feedback[sellerAdd].submittedBy = msg.sender;
        
        orderlists[_orderAddress] = true;
        
        totalCount[sellerAdd]++; 

        if (!getSellerRep(sellerAdd) && getBuyerRep(buyerAdd) && _score < 5) {  
            // low rep buyer grades for normal rep seller
            // feedback[sellerAdd].score = (_score + 1);
            scoreSum[sellerAdd] += (_score + 1);
        } else {
            // feedback[sellerAdd].score = _score;
            scoreSum[sellerAdd] += _score;
        }

        emit SubmitFeedback(msg.sender, sellerAdd, _orderAddress, now, _score);
        
       
    }
    
    // get average score for seller
    function getScoreAverage(address _sellerAdd) public view returns (uint) {
        uint overall;
        if (totalCount[_sellerAdd] == 0) {
            // new account; return 3 to give user a normal rep account
            return 3;
        } else {
            overall = scoreSum[_sellerAdd] / totalCount[_sellerAdd];
            if (overall < 0) {
                return 0;
            }
        }
        return overall;
    }
    
    // get the seller reputation
    function getSellerRep(address _sellerAdd) public view returns (bool) {
        if (getScoreAverage(_sellerAdd) <= 2) 
            return true;
        return false;
    }
    
    // REPUTATION SYSTEM FOR BUYER
    function addRefundCount(address _buyerAdd, bool refund) public {
        if (refund)
            refundCount[_buyerAdd]++;
        orderCount[_buyerAdd]++;
    }
    
    // get average score for user
    function getRefundAverage(address _buyerAdd) public view returns (uint) {
        uint overall;
        if (orderCount[_buyerAdd] == 0) {
            // new account; return 0 to give user a normal rep account
            return 0;
        } else {
            overall = refundCount[_buyerAdd]*100 / orderCount[_buyerAdd];
            if (overall < 0) {
                return 0;
            }
        }
        return overall;
    }
    
    // get the buyer reputation
    function getBuyerRep(address _buyerAdd) public view returns (bool) {
        if (getRefundAverage(_buyerAdd) > 50) 
            return true;
        return false;
    }
    
}

contract ItemListing {

    Users user;
    address seller;
    mapping (int256 => address) productList;
    
    constructor (address UsersContractAddress) public {
        user = Users(UsersContractAddress);
    }

    function ItemList (int256 prod_id, int256 phone_No) public {
        require(msg.sender == user.getUser(phone_No), "Wrong account.");        // check that seller is using the linked ethereum account
        productList[prod_id] = msg.sender;
    }
    
    // get constructor - whose creating the contract (seller)
    function getSellerAdd(int256 prod_id) public view returns (address) {
        return productList[prod_id];
    }

    // get constructor - the specific seller's reputation
    function getSellerRep(int256 prod_id) public view returns (bool) {
        return user.getSellerRep(getSellerAdd(prod_id));
    }
    
}

contract EscrowCon {
    uint256 private itemAmt;                                                    // the price of the item
    address payable buyer;                                                      // buyer address
    address payable seller;                                                     // seller address
    address payable owner;                                                      // owner address
    uint256 private cancelDate;                                                 // set the timestamp
    uint256 private shipDate;                                                   // set the timestamp
    uint256 private ownerCut;
    bool buyerAcceptSlip;                                                       // buyer accept shipping slip
    bool buyerCancelOrder;                                                      // buyer cancel order
    bool sellerUpdateSlip;                                                      // seller update shipping slip
    bool lowRepSeller;                                                          // seller is low reputation
    bool lowRepBuyer;                                                           // buyer is low reputation
    Users user;
    
    // maps addresses to balances e.g. hashtables
    //mapping (address => uint256) public balances;

    // events allow light clients to react to changes efficiently
    event Transfer(address indexed from, address indexed to, uint256 amount);

    // this is the constructor whose code is run only when the contract is created
    constructor (address ItemListContractAddress, address UsersContractAddress, uint256 item_Price, int256 phone_No, int256 prod_id) public {
        ItemListing iL = ItemListing(ItemListContractAddress);
        user = Users(UsersContractAddress);
        require(msg.sender == user.getUser(phone_No), "Wrong account.");        // check that user is using the linked ethereum account
        seller = address(uint160(iL.getSellerAdd(prod_id)));                    // pass the seller_add to this contract
        owner = address(uint160(user.getOwnerAdd()));
        buyer = address(uint160(msg.sender));
        itemAmt = item_Price;                                                   // set the item price (in wei)
        lowRepSeller = user.getSellerRep(seller);        
        lowRepBuyer = user.getBuyerRep(buyer);
    }

    function () external payable { }

    // payment buyer to escrow - will display to buyer escrow address so buyer  
    // SEND IT TO ESCROW instead of seller
    function buyerToEscrow() public payable {
        require(msg.value <= getAccBal(msg.sender), "Insufficient balance.");   // check buyer balance got sufficient funds
        require(msg.sender != seller, "Buyer is seller.");                      // check that seller is not buying its own item
        require(msg.sender == buyer, "Wrong account.");                         // check that buyer is using the linked ethereum account
        address(this).transfer(msg.value);                                      // send money to recevier (the contract address)
        emit Transfer(msg.sender, address(this), msg.value);
        
    }

    // escrow release funds to seller (10% to owner, rest to seller)
    function escrowToSeller() public payable {     
        //require(amt <= getContractBal(), "Error.");                           // check escrow balance got sufficient funds
        //balances[escrow] -= amt;                                              // deduct money from escrow
        //balances[seller] += amt;                                              // add money to seller
        ownerCut = address(this).balance/10;                                    // 10% cut is owner's
        owner.transfer(ownerCut);
        seller.transfer(address(this).balance - ownerCut);
        emit Transfer(address(this), seller, address(this).balance - ownerCut);
        emit Transfer(address(this), owner, ownerCut);
    }
    
    // escrow release funds to buyer (all to buyer)
    function escrowToBuyer() public payable {
        buyer.transfer(address(this).balance);
        emit Transfer(address(this), buyer, address(this).balance);
    }
    
    // OWNER REFUND
    // escrow release funds to back to buyer - need put set value like buyerToEscrow,
    // so we call getItemAmt() then set the value in javascipt as the item value
    function ownerToBuyer() public payable {    
        require(msg.value <= getAccBal(msg.sender), "Insufficient balance."); 
        buyer.transfer(msg.value);
        emit Transfer(owner, buyer, msg.value);
    }
    
    // OWNER GIVE
    // escrow send funds to back to seller - need put set value like buyerToEscrow,
    // so we call getItemAmt() then set the value in javascipt as the item value
    function ownerToSeller() public payable {    
        require(msg.value <= getAccBal(msg.sender), "Insufficient balance."); 
        seller.transfer(msg.value - (msg.value/10));
        emit Transfer(owner, seller, msg.value - (msg.value/10));
    }
    
    // BUYER - cancel order
    function cancelOrder() public {
        if (msg.sender == buyer && !sellerUpdateSlip && !buyerCancelOrder) {
            buyerCancelOrder = true;
            cancelDate = now;
        } else {
            revert();
        }
    }
    
    // SELLER - reject order
    function rejectOrder() public {
        require(msg.sender == seller, "Please use the correct account (seller).");
        
        escrowToBuyer();
        //selfdestruct(buyer);
    }
    
    // SELLER - update shipping slip
    function uploadSlip() public {
        if (msg.sender == seller) {
            buyerCancelOrder = false;
            sellerUpdateSlip = true;
            shipDate = now;                                                     //now is an alias for block.timestamp, not really "now"
        }
       
    }
    
    // BUYER - confirm shipping slip
    function acceptSlip() public {
        if (msg.sender == buyer && !buyerCancelOrder) {
            buyerAcceptSlip = true;
        } else {
            revert();
        }
    }
    
    // BUYER - cancel shipping slip
    function cancelSlip() public {
        if (msg.sender == buyer && !buyerCancelOrder) {
            buyerAcceptSlip = false;
            cancelDate = now;                                                   //now is an alias for block.timestamp, not really "now"
        } else {
            revert();
        }
    }
    
    // SELLER - accept buyer's slip cancellation 
    function acceptRejectSlip() public {
        if (msg.sender == seller && sellerUpdateSlip && !buyerAcceptSlip) {
            user.addRefundCount(buyer, false);
            escrowToBuyer();
            //selfdestruct(buyer);
        } else {
            revert();
        }
            
    }

    // SELLER - reject buyer's slip cancellation
    function cancelRejectSlip() public {
        if (msg.sender == seller && sellerUpdateSlip && !buyerAcceptSlip) {
            // if (!lowRepSeller && !lowRepBuyer) {
            //     ownerToBuyer(); do in javascipt code to call ownerToBuyer()
            // }
            user.addRefundCount(buyer, true);
            escrowToSeller();
        } else {
            revert();
        }
        
    }
    
    // BUYER - accept product
    function acceptDelivery() public {
        if (msg.sender == buyer && buyerAcceptSlip){
            user.addRefundCount(buyer, false);
            escrowToSeller();
        } else {
            revert();
        }
    }
    
    // BUYER - reject product
    function cancelDelivery() public {
        if (msg.sender == buyer && buyerAcceptSlip) {
            // payment to SELLER if buyer and seller is normal 
            // if (!lowRepSeller && !lowRepBuyer) {
            //     ownerToSeller();
            // } 
            user.addRefundCount(buyer, true);
            escrowToBuyer();
        } else {
            revert();
        }
    }
    
    // call this always at accountpage.php
    function checker() public {
        // if buyer cancel order (buyerCancelOrder)
        // check that seller has not update slip 
        // + if 1 days passed since buyer cancel order
        if (buyerCancelOrder && !sellerUpdateSlip && now > cancelDate + 1 days) {
            escrowToBuyer();
            //selfdestruct(buyer);
        }
        
        // if buyer rejects shipping slip
        // if sellerOkCancel is constantly false even after 3 days have passed since buyer cancel slip (now > cancelDate + 3 days)
        // + requireOwnerAccess is false
        if (!buyerAcceptSlip && sellerUpdateSlip && now > cancelDate + 3 days) {
            user.addRefundCount(buyer, false);
            escrowToBuyer();
            //selfdestruct(buyer);
        }

        // buyer accepts product delivery or 
        // buyer accepts shipping slip && 45 days have passed since buyer accepts shipping slip && buyer never cancel product delivery
        // SETTLED - IF NEVER BUYER NEVER ACCEPT THE DELIVERY WITHIN CERTAIN DATE THEN??? AUTO SEND OR IF GOT DEFECT THAT WHY THEY NEBER ACCEPT
        if (getContractBal() > 0 && buyerAcceptSlip && now > shipDate + 45 days){
            user.addRefundCount(buyer, false);
            escrowToSeller();
        } 
    }
    
    // get constructor - whose creating the contract (buyer)
    function getBuyerAdd() public view returns (address) {
        return buyer;
    }

    // get constructor - seller address
    function getSellerAdd() public view returns (address) {
        return seller;
    }

    // get constructor - ItemAmt
    function getItemAmt() public view returns (uint256) {
        return itemAmt;                                                    
    }

    // get constructor - balance from specific address
    function getAccBal(address _account) public view returns (uint256) {
        return _account.balance;                                                // we can convert wei to ether by dividing it with 1e18
    }

    //get constructor - balance of the contract
    function getContractBal() public view returns (uint256) {
        return address(this).balance;
    }
    
    // get constructor - reputation of seller
    function getSellerReputation() public view returns (bool) {
        return lowRepSeller;                                                    
    }
    
    // get constructor - reputation of buyer
    function getBuyerReputation() public view returns (bool) {
        return lowRepBuyer;                                                    
    }
}