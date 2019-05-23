<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>E-SHOP</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

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
				<li class="active">Register</li>
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
                <div id="login-row" class="row justify-content-center align-items-center">
                    <div id="login-column" class="col-md-8">
                        <div id="login-box" class="col-md-12">
                            <form id="login-form" class="form" action="#" method="post">
                                <h3 class="text-center">Create your EShop Account</h3>
                                <div class="form-group">
                                    <label for="fullname">*Full Name:</label><br>
                                    <input type="text" name="fullname" id="fullname" class="input" required>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="phone">*Phone Number:</label><br>
                                        <input type="text" name="phone" id="phone" class="input" maxlength="8" required><br>
                                    </div>
                                    <div class="col">
                                        <label for="password">*Password:</label><br>
                                        <input type="password" name="password" id="password" class="input" required><br>
                                    </div>	
                                </div>
								<br>
								<div class="form-group">
                                    <label for="address">*Address:</label><br>
                                    <input type="text" name="address" id="address" class="input" required>
                                </div>
                                <div class="form-group">
                                    <label for="emailAdd">*Email:</label><br>
                                    <input type="text" name="emailAdd" id="emailAdd" class="input" required>
                                </div>
                                <div class="form-row">
                                    <div class="col">
										<label for="birthdate">*Date of Birth:</label>
										<input type="date" name="birthdate" id="birthdate" class="input" required>
									</div>
                                    <div class="col">
                                        <label for="gender">*Gender:</label><br>
                                        <select class="input" id="gender" name="gender">
											<option value="F">F</option>
											<option value="M">M</option>
										</select>
                                        <br>
                                    </div>
                                </div>
								<br>
                                <div class="form-group">
                                    <button class="primary-btn pull-right" type="button" name="submitBtn" id="submitBtn">Register</button>
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
	<script src="js/register.js"></script>

</body>

</html>
