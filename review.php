<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>E-SHOP HTML Template</title>


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
				<li class="active">Review</li>
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
				<!-- Product -->
				<div class="col-md-12">
					<div class="order-summary clearfix">
						<div class="section-title">
							<h3 class="title">Order Review</h3>
						</div>
						<table>
							<tbody>
								<tr>
									<td class="thumb"><img src="./img/thumb-product01.jpg" alt=""></td>
									<td style="position:absolute; top:1; margin-left:25px;">
										<h3 class="product-name"></h3>
										<ul>
											<li><div id="soldBy"></div></li>
											<li><div id="orderDate"></div></li>
											<li><div id="desc"></div></li>
										</ul>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /Product -->
                <!-- Write Reviews -->
                <div class="col-md-12">
                    <h4 class="text-uppercase">Write Your Review</h4>
                    <form class="review-form">
                        <div class="form-group">
                            <textarea class="input" placeholder="Your review" id="reviewbox"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="input-rating">
                                <strong class="text-uppercase">Your Rating: </strong>
                                <div class="stars">
                                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5"></label>
                                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4"></label>
                                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3"></label>
                                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2"></label>
                                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1"></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
							<button class="primary-btn" type="button" name="submitBtn" id="submitBtn">Submit</button>
						</div>
                    </form>
                </div>
                <!-- /Write Reviews -->
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
    <script src="js/review.js"></script>

</body>

</html>
