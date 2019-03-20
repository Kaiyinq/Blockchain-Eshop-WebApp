<?php include 'productpage_connect.php' ?>

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

	<!-- For modal popup -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->


</head>

<body>
	<!-- HEADER -->
	<?php include 'header.php' ?>
	
	<!-- NAVIGATION -->
	<?php include 'nav.php' ?>

	<!-- BREADCRUMB -->
	<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="home.php">Home</a></li>
				<li><a href="products.php">Products</a></li>
				<li><a href="#">Category</a></li>
				<li class="active"><?php echo $prodName; ?></li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!--  Product Details -->
				<div class="product product-details clearfix">
					<div class="col-md-6">
						<div id="product-main-view">
							<div class="product-view">
								<?php echo '<img src="data:image/jpeg;base64,'.base64_encode($prodPic).'" />'; ?>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="product-body">
							<h2 class="product-name"><?php echo $prodName; ?></h2>
							<h3 class="product-price">$<?php echo $prodPrice; ?> <span class="product-old-price">+ $5.00 Shipping Fee</span></h3>
							<div class="product-rating">
								<?php 
									for ($i = 0; $i < $prodrating; $i++) {
										echo "<i class='fa fa-star'></i> ";
									}
									for ($i = 0; $i < (5 - $prodrating); $i++) {
										echo "<i class='fa fa-star-o empty'></i> ";
									} 
								?>
							</div>
							<p><strong>Quantity:</strong> <?php echo $prodQuantity; ?></p>
							<p><?php echo $prodDesc; ?></p>

							<div class="product-btns">
								<div class="qty-input">
									<span class="text-uppercase">QTY: </span>
									<input class="input" type="number" min="1" value="1">
								</div>
								<br><br>
								<div class="pull-right">
								<button type="button" class="primary-btn btn-buynow"> Buy Now</button>
								</div>
							</div>

							<!-- Modal -->
							<div class="modal-style">
								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<h4 class="modal-title"><?php echo $prodName; ?></h4>
									</div>
									<div class="modal-body">
										<p>To pay, send ETH to the address below</p>
										<p class="product-price">Amount</p>
										<p><?php echo $prodPrice ?></p>
										<br>
										<p>Ethereum Address</p>
										<p id="contractAddress"></p>
									</div>
								</div>
								<!-- /Modal content-->
							</div>
							<!-- /Modal -->

						</div>
					</div>
					<!-- Reviews -->
					<div class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Reviews (<?php echo $numReview; ?>)</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab2" class="tab-pane fade in active">
									<div class="row">
										<!-- Display Reviews -->
										<div class="col-md-12">
											<div class="product-reviews">
												<div class="single-review">
													<div class="review-heading">
														<div><a href="#"><i class="fa fa-user-o"></i> John</a></div>
														<div><a href="#"><i class="fa fa-clock-o"></i> 27 DEC 2017 / 8:0 PM</a></div>
														<div class="review-rating pull-right">
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star"></i>
															<i class="fa fa-star-o empty"></i>
														</div>
													</div>
													<div class="review-body">
														<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Duis aute
															irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
													</div>
												</div>

												<ul class="reviews-pages pull-right">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
												</ul>
											</div>
										</div>
										<!-- /Display Reviews -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Reviews -->
				</div>
				<!-- /Product Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
	
	<!-- FOOTER -->
	<?php include 'footer.php'; ?>
	<!-- /FOOTER -->

	<!-- jQuery Plugins -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/slick.min.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.zoom.min.js"></script>
	<script src="js/main.js"></script>	
	<script src="js/header.js"></script>
	<!-- Connects to the contract -->
	<script src="js/web3.min.js"></script>
    <script src="js/truffle-contract.js"></script> 
	<script src="js/productpage.js"></script>

</body>

</html>
