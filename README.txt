Done by: Loh Kai Ying (U1622579C)

Required Tools:
1. ganache
2. xampp 
3. visual studio code
4. phpmysql
5. Twilio (for OTP)
6. Truffle@3.0.7
7. web3@0.20.6
8. MetaMask

Steps to run the project:
1. Run ganache
2. Connect Metamask to ganache
3. Reset truffle mirgrate to update contract (cd to the project folder)
- truffle compile
- truffle migrate --reset --all
- truffle migrate --network ganacheTest --reset --all (use ganache)
- truffle migrate --network development --reset --all (use private testnet)
- truffle console --network ganacheTest (use ganache)
- truffle console --network development (use private testnet)
4. http://127.0.0.1:8887/Blockchain-Eshop-WebApp
