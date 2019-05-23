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
				<li class="active">Confirm Delivery</li>
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
					<div class="col-md-3 col-sm-6"></div>
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <form id="status-form" class="form" action="#" method="post" enctype="multipart/form-data">
                                <h3 class="text-center">Confirm Delivery</h3>
                                <div class="form-group">
                                    <label for="confirmDelivery">Confirm delivery:</label><br>
                                    <select class="input" id="confirmDelivery" name="confirmDelivery">
										<option value="1">Yes</option>
                                        <option value="0">No</option>
									</select>
								</div>
								<div id="commentgroup" style="display:none">
									<div class="form-group">
										<label for="comment">Explanation for Seller:</label><br>
										<textarea name="comment" id="comment" class="input" form="status-form" wrap="true" cols="5" rows="3" required></textarea>
									</div>
									<div class="form-group">
										<div class="input-group-prepend">
											<label class="input-group-text" >Upload:</label>
										</div>
										<div class="form-group">
											<input type="file" class="custom-file-input" name="myfile" id="myfile" accept=".jpg,.jpeg,.png" onchange="validateFileType()" required>
										</div>
									</div>
								</div>
                                <div class="form-group">
									<button class="primary-btn pull-right" type="button" name="submitBtn" id="submitBtn">Confirm</button>
								</div>
                            </form>
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
    <script src="js/confirmDelivery.js"></script>

</body>

</html>
