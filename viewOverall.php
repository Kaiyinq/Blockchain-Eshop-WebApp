<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>E-SHOP</title>


	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Hind:400,700" rel="stylesheet">

	<!-- Bootstrap -->
	<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css" />

	<!-- Slick -->
	<link type="text/css" rel="stylesheet" href="css/slick.css" />
	<link type="text/css" rel="stylesheet" href="css/slick-theme.css" />

	<!-- nouislider -->
	<link type="text/css" rel="stylesheet" href="css/nouislider.min.css" />

	<!-- Font Awesome Icon -->
	<link rel="stylesheet" href="css/font-awesome.min.css">

	<!-- Custom stlylesheet -->
    <link type="text/css" rel="stylesheet" href="css/style.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body>
	<!-- HEADER -->
	<?php include 'header.php'; ?>

	<!-- NAVIGATION -->
	<?php include 'nav.php'; ?>

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
                <li><a href="home.php">Home</a></li>
                <li><a href="accountpage.php">Account</a></li>
				<li class="active">View Order</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<div class="section">
        <!--login-->
        <div id="login">
            <!-- container -->
            <div class="container">
                <!-- row -->
                <div id="row" class="row justify-content-center align-items-center">
                    <div class="alert alert-danger" role="alert" id="danger">
                    </div>
                    <div class="alert alert-warning" role="alert" id="warning">
				    </div>
					<div class="col-md-3 col-sm-6"></div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <h3 class="text-center">View Order</h3>
                            <!-- Buyer Details -->
                            <div class="form-group">
                                <label for="orderBy">Order By:</label><br>
                                <div id="orderBy"></div>
                            </div>
                            <div class="form-group">
                                <label for="contactNo">Contact Number:</label><br>
                                <div id="contactNo"></div>
                            </div>
                            <div class="form-group">
                                <label for="shipTo">Ship To:</label><br>
                                <div id="shipTo"></div>
                            </div>
                            <!-- /Buyer Details -->
                            <hr/>
                            <!-- Order Details -->
                            <div class="pull-right"><a id="rejectOrder">Reject Order</a></div>
                            <div class="form-group">
                                <label for="prodName">Product Name:</label><br>
                                <div id="prodName"></div>
                            </div>
                            <div class="form-group">
                                <label for="orderQuantity">Order Quantity:</label><br>
                                <div id="orderQuantity"></div>
                            </div>
                            <div class="form-group">
                                <label for="orderDate">Order Date:</label><br>
                                <div id="orderDate"></div>
                            </div>
                            <div class="form-group">
                                <label for="orderStatus">Order Status:</label><br>
                                <div id="orderStatus"></div>
                            </div>
                            <!-- /Order Details -->
                            <hr/>
                            <!-- Shipping Details -->
                            <div class="pull-right"><a id="updateSlip">Upload shipping slip</a></div>
                            <div class="form-group">
                                <label for="shippingDate">Shipping Date (time submitted by you):</label><br>
                                <div id="shippingDate"></div>
                            </div>
                            <div class="form-group">
                                <label for="shippingslip">Shipping slip provided by you:</label><br>
                                <div id="product-main-view">
                                    <img id ="orderShippingSlip" src="" />
                                </div>
                            </div>
                            <!-- /Shipping Details -->
                            <hr/>
                            <!-- Buyer's Acceptance Details on Shipping -->
                            <div class="form-group">
                                <label for="ordershipping">Buyer's Confirmation (Shipping):</label><br>
                                <div id="ordershipping"></div>
                            </div>
                            <div class="form-group">
                                <label for="orderShipConfirm">Buyer's Comment (Shipping):</label><br>
                                <div id="orderShipConfirm"></div>
                            </div>
                            <div class="form-group" id="rejection" style="display:none">
                                <label for="buyerReject">Accept buyer's rejection: **</label><br>
                                <div id="slipYesNo"></div>
                            </div>
                            <!-- /Buyer's Acceptance Details on Shipping -->
                            <hr/>
                            <!-- Buyer's Acceptance Details on Delivery -->
                            <div id="delivery" style="display:none">
                                <div class="form-group" >
                                    <label for="orderdelivery">Buyer's Confirmation (Delivery):</label><br>
                                    <div id="orderdelivery"></div>
                                </div>
                                <div class="form-group">
                                    <label for="orderDeliveryConfirm">Buyer's Comment (Delivery):</label><br>
                                    <div id="orderDeliveryConfirm"></div>
                                </div>
                                <div id="rejection2" style="display:none">
                                    <div class="form-group">
                                        <label for="orderDefect">Buyer's Evidence (Delivery):</label><br>
                                        <div id="product-main-view">
                                            <img id ="orderDefect" src="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /Buyer's Acceptance Details on Delivery -->
                        </div>
                    </div>					                
                </div>
				<!-- /row -->
            </div>
            <!-- /container -->
        </div>   
		<!--/login-->
	</div>
	<!-- /section -->
	
	<br><br><br>

	<!-- FOOTER -->
	<?php include 'footer.php'; ?>

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<!-- Connects to the contract -->
	<script src="js/web3.min.js"></script>
    <script src="js/truffle-contract.js"></script>
    <script src="js/viewOverall.js"></script>

</body>

</html>
