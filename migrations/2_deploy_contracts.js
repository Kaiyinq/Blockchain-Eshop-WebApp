// for constructor(...)public {...}
// let name = "Kai";
// let nric = "S99";

var EscrowCon = artifacts.require("EscrowCon");
var ItemListing = artifacts.require("ItemListing");
var Users = artifacts.require("Users");

module.exports = function(deployer) {
   //deployer.deploy(Escrow, name, nric);
   
   // deployer.deploy(Users).then(function() {
   //    return deployer.deploy(Reputation, Users.address).then(function() {
   //       return deployer.deploy(ItemListing, Users.address, Reputation.address);
   //    });
   // });

   deployer.deploy(Users).then(function() {
      return deployer.deploy(ItemListing, Users.address);
   });
   
};
