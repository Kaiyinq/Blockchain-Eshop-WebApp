<?php include 'sellItem_connect.php' ?>

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
				<li class="active">Sell Item</li>
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
                            <form id="login-form" class="form" action="#" method="post" enctype="multipart/form-data">
                                <h3 class="text-center">Sell Item</h3>
                                <div class="form-group">
                                    <label for="itemname">Item Name:</label><br>
                                    <input type="text" name="itemname" id="itemname" class="input" required>
                                </div>
								<div class="form-group">
									<label for="quantity">Quantity:</label><br>
									<input type="number" id="quantity" class="form-control" min="1" value="1">
								</div>
                                <div class="form-group">
                                    <label for="price">Price:</label><br>
                                    <input type="numbers" name="price" id="price" class="input" required>
								</div>
								<div class="form-group">
                                    <label for="shipmethod">Delivery Options:</label><br>
                                    <select class="input" id="shipmethod" name="shipmethod">
										<option value="1">Saver, 11-21 days Free</option>
										<option value="2">Standard, 8-14 days SGD1.99</option>
									</select>
								</div>
								<div class="form-group">
                                    <label for="category">Categories:</label><br>
									<select class="input" id="category" name="category">
										<?php 
											if ($resultIn) {
												while ($row = $result->fetch_assoc()) {            
													$categoryid = $row["category_id"];
													$categoryname = $row["category_name"];
													echo "<option value='$categoryid'>";
													echo $categoryname;
													echo "</option>";
												}
											}
										?>
									</select>
								</div>
								<div class="form-group">
                                    <label for="desc">Description:</label><br>
                                    <input type="text" name="desc" id="desc" class="input">
								</div>
								<div class="form-group">
									<div class="input-group-prepend">
										<label class="input-group-text" >Upload:</label>
									</div>
									<div class="form-group">
										<input type="file" class="custom-file-input" name="myfile" id="myfile" accept=".jpg,.jpeg,.png" onchange="validateFileType()" required>
									</div>
								</div>
                                <div class="form-group">
                                    <button class="primary-btn pull-right btn-item" type="button" name="submitBtn" id="submitBtn">Sell Item</button>
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

	<!-- FOOTER -->
	<?php include 'footer.php'; ?>

	<!-- jQuery Plugins -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
	<script src="js/sellItem.js"></script>

</body>

</html>
