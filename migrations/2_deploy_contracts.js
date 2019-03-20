// for constructor(...)public {...}
// let name = "Kai";
// let nric = "S99";


var EscrowCon = artifacts.require("EscrowCon");
var ItemListing = artifacts.require("ItemListing");
var Coursetro = artifacts.require("./Coursetro.sol");
var Adoption = artifacts.require("./Adoption.sol");

module.exports = function(deployer) {
   //deployer.deploy(Escrow, name, nric);
   
   deployer.deploy(Coursetro);
   deployer.deploy(Adoption);
   deployer.deploy(ItemListing).then(function() {
      return deployer.deploy(EscrowCon, ItemListing.address);
   });
   
};
