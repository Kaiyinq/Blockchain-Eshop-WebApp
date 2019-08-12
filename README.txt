Done by: Loh Kai Ying

Required Tools:
1. ganache
2. xampp 
3. visual studio code
4. phpmysql
5. Twilio Account (for OTP) 
6. Truffle@3.0.7
7. web3@0.20.6
8. MetaMask

Pre-running:
- Ensure that the project folder is inside xampp; Normally under C:\xampp\htdocs
- Ensure the phpmysql database is working

Steps to run the project:
1. Run ganache
2. Connect Metamask to ganache
3. Open powershell
4. cd to project folder
5. Truffle run to update contract
- truffle compile
- truffle migrate --reset --all
- truffle migrate --network ganacheTest --reset --all (use ganache)
- truffle migrate --network development --reset --all (use private testnet)
- truffle console --network ganacheTest (use ganache)
- truffle console --network development (use private testnet)
6. http://127.0.0.1:8887/Blockchain-Eshop-WebApp/login.php

PHPMYSQL Database
users table
- userid (primary key; auto-increment)
- username (user_phone number)
- userpass
- user_fullname
- user_address
- user_gender
- user_dob
- user_email

seller table
- seller_id (primary key; auto-increment)
- seller_shoptype (corporate/individual)
- seller_shopname
- seller_shopemail
- userid (foreign key)

products table
- prod_id (primary key; auto-increment)
- prod_name
- prod_date (date)
- prod_price (double)
- prod_quantity
- prod_shipmethod (varchar)
- prod_pic (mediumblob)
- prod_desc
- category_id
- seller_id

prodreview table
- review_id (primary key; auto-increment)
- review_date (datetime)
- review_stars (int)
- review_comment
- order_id
- prod_id

orders table
- order_id (primary key; auto-increment)
- order_status (Processing/Shipping/Delivered/Cancelled/Refunded)
- order_shipok (tinyint; default 2)
- order_shipcomment
- order_deliveryok (tinyint; default 2)
- order_deliverycomment 
- order_acceptRejectSlip (tinyint; default 2)
- order_date (datetime)
- order_quantity 
- order_refpic (mediumblob)
- order_defectrefpic (mediumblob)
- order_shippingDate (datetime)
- prod_id
- userid
- order_contractAdd (escrow contract address)

category table
- category_id (primary key; auto-increment)
- category_name
