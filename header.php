<!-- HEADER -->
<header>
    <!-- top Header -->
    <div id="top-header">
        <div class="container">
            <div class="pull-left">
                <span>Welcome to E-shop!</span>
            </div>
            <div class="pull-right">
                <ul class="header-top-links">
                    <li><a href="#">Newsletter</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Track My Order</a></li>
                    <?php 
                    if (!isset($_SESSION)) {
                        session_start(); //start session
                        if(!isset($_SESSION["buyerid"]) && !isset($_SESSION["sellerid"])) { 
                            echo "<li><a href='login.php'>Login</a></li>";
                            echo" <li><a href='register.php'>Register</a></li>";
                        }  
                    }        
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- /top Header -->

    <!-- header -->
    <div id="header">
        <div class="container">
            <div class="pull-left">
                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="#">
                        <img src="./img/logo.png" alt="">
                    </a>
                </div>
                <!-- /Logo -->
            </div>
            <div class="pull-right">
                <ul class="header-btns" id="accAndCart">
                    <!-- Account -->
                    <?php include 'header-acccart.php' ?>
                    <!-- Mobile nav toggle-->
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                    </li>
                    <!-- / Mobile nav toggle -->
                </ul>
            </div>
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
<!-- /HEADER -->