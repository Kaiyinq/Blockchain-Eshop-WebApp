<?php include 'accountpage_connect.php' ?>

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
				<li class="active">Account</li>
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
                <div id="row">
					<!-- Buyer section -->
					<div class="account-methods">
						<div class="section-title">
							<h4 class="title">Buyer account</h4>
						</div>
						<div class="personal-info">
							<div class="row">
								<div class="col-md-3">
									<h5 class="title">Personal Info</h5>
								</div>
								<div class="col-md-3">
									<p>
										<?php echo $fullname ?> 
										<br>
										<?php echo $email ?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<h5 class="title">Address</h5>
								</div>
								<div class="col-md-3">
									<p>
										<?php echo $address ?>
									</p>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="myorders-tab">
										<ul class="tab-nav">
											<li class="active"><a data-toggle="tab" href="#tab1">To Ship</a></li>
											<li><a data-toggle="tab" href="#tab2">To Receive</a></li>
											<li><a data-toggle="tab" href="#tab3">To Review</a></li>
										</ul>
										<div class="tab-content">
											<div id="tab1" class="tab-pane fade in active">
												<table class="shopping-cart-table table">
													<thead>
														<tr>
															<th>Product</th>
															<th></th>
															<th class="text-center">Price</th>
															<th class="text-center">Quantity</th>
															<th class="text-center">Total</th>
															<th class="text-right"></th>
														</tr>
													</thead>
													<!-- TO SHIP LIST -->
													<tbody id="toShip"></tbody>
													<!-- /TO SHIP LIST -->
												</table>
											</div>
											<div id="tab2" class="tab-pane fade in">
												<table class="shopping-cart-table table">
													<thead>
														<tr>
															<th>Product</th>
															<th></th>
															<th class="text-center">Price</th>
															<th class="text-center">Quantity</th>
															<th class="text-center">Total</th>
															<th class="text-right"></th>
														</tr>
													</thead>
													<!-- TO RECEIVE LIST -->
													<tbody id="toReceive"></tbody>
													<!-- /TO RECEIVE LIST -->
												</table>
											</div>
											<div id="tab3" class="tab-pane fade in">
												<table class="shopping-cart-table table">
													<thead>
														<tr>
															<th>Product</th>
															<th></th>
															<th class="text-right"></th>
														</tr>
													</thead>
													<!-- TO REVIEW LIST -->
													<tbody id="toReview"></tbody>
													<!-- /TO REVIEW LIST -->
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Buyer -->
                </div>
				<!-- /row -->
				<!-- row -->
                <div id="row">
					<!-- Seller section -->
					<div class="account-methods" id="sellerinfo">
						
					</div>
					<!-- /Seller -->
                </div>
				<!-- /row -->
            </div>
            <!-- /container -->
        </div>   
		<!--/login-->
	</div>
	<!-- /section -->

	<!-- FOOTER -->
	<?php include 'footer.php'; ?>

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/header.js"></script>
	<script src="js/account.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- <script>
	function myFunction() {
		alert("haha");
	}
	</script> -->

</body>

</html>
