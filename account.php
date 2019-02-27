<!-- UNDONE (NEED ADD THE CART LIST - LINK TO PRODUCTPAGE) -->

<?php  
require('config.php'); 
session_start(); //start session

if(isset($_SESSION["buyerid"])) {
    // <!-- Account -->
    echo "<li class='header-account dropdown default-dropdown'>";
    echo "<div role='button' data-toggle='dropdown' aria-expanded='true'>";
    echo "<div class='header-btns-icon'>";
    echo "<i class='fa fa-user-o'></i>";
    echo "</div>";
    echo "<strong class='text-uppercase'>My Account <i class='fa fa-caret-down'></i></strong>";
    echo "</div>";
    echo "<ul class='custom-menu'>";
    echo "<li><a href='accountpage.php'><i class='fa fa-user-o'></i> My Account</a></li>";
    echo "<li><a href='#'><i class='fa fa-heart-o'></i> My Wishlist</a></li>";
    echo "<li><a href='registerSeller.php'><i class='fa fa-user-o'></i> Sell on Eshop</a></li>";
    echo "<li><a href='#'><i class='fa fa-gear'></i> Settings</a></li>";
    echo "<li><a href='logout.php'><i class='fa fa-sign-out' id='logout'></i> Logout</a></li>";
    echo "</ul>";
    echo "</li>";
    // <!-- /Account -->
    // <!-- Cart -->
    echo "<li class='header-cart dropdown default-dropdown'>";
    echo "<a class='dropdown-toggle' data-toggle='dropdown' aria-expanded='true'>";
    echo "<div class='header-btns-icon'>";
    echo "<i class='fa fa-shopping-cart'></i>";
    echo "<span class='qty'>3</span>";
    echo "</div>";
    echo "<strong class='text-uppercase'>My Cart:</strong>";
    echo "<br>";
    echo "<span>35.20$</span>";
    echo "</a>";
    echo "<div class='custom-menu'>";
    echo "<div id='shopping-cart'>";
    echo "<div class='shopping-cart-list'>";
    // <!-- Cart List 1 -->
    echo "<div class='product product-widget'>";
    echo "<div class='product-thumb'>";
    echo "<img src='./img/thumb-product01.jpg' alt=''>";
    echo "</div>";
    echo "<div class='product-body'>";
    echo "<h3 class='product-price'>$32.50 <span class='qty'>x3</span></h3>";
    echo "<h2 class='product-name'><a href='#'>Product Name Goes Here</a></h2>";
    echo "</div>";
    echo "<button class='cancel-btn'><i class='fa fa-trash'></i></button>";
    echo "</div>";
    // <!-- /Cart List 1 -->
    echo "</div>";
    echo "<div class='shopping-cart-btns'>";
    echo "<button class='main-btn'>View Cart</button>";
    echo "<button class='primary-btn'>Checkout <i class='fa fa-arrow-circle-right'></i></button>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</li>";
    // <!-- /Cart -->

    
} 

?>