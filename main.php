<!DOCTYPE html>
<html>  
<head>
	<title>Top Shoe</title>
	<div section="section">
		<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	</div>
</head>
<body>
	<style>
	body  {
	  background-image: url("./display_photo/bk.png");  
	}
	</style>
<?php session_start(); ?>
<?php if (isset($_SESSION['UserID'])): 
 unset($_SESSION['message']); ?>
<div>
	<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['UserID']; ?>">
	<input type="hidden" id="user_name" name="user_name" value="<?php echo $_SESSION['Username']; ?>">
</div>
<?php endif ?>
		
<div class="container">
	<div class="row justify-content-center">
		<div class="col-2">
			<img src="./display_photo/logo.png" class="img-responsive center-block">
		</div>
		<div class="col-10">
			<div id="carouselExampleSlidesOnly" class="carousel slide center-block" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="./display_photo/up1.png" class="img-responsive" alt="Snow">
					</div>
					<div class="carousel-item">
						<img src="./display_photo/up2.png" class="img-responsive" alt="Snow">
					</div>
					<div class="carousel-item">
						<img src="./display_photo/up3.png" class="img-responsive" alt="Snow">
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="row" style="background-color:#ffffff; border-color:black; border-style:double; display:flex; justify-content:flex-end">
		<a href="user.php">
			<div id="user_span"></div>
			<span style="font-size:130%" class="glyphicon glyphicon-user"><?php echo $_SESSION['Username']; ?></span>  
		</a>
    </div>

	<div class="row" >
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<div class="btn-group" role="group">
				<button class="btn btn-default dropdown-toggle" type="button" id="main" data-toggle="dropdown"><b>Main Product</b><span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="main">
					<li><button class="btn btn-default" type="button" id="purchase"><b>Purchase</b></button></li>
					<li><button class="btn btn-default" type="button" id="sell"><b>Sale</b></button></li>
					<li><button class="btn btn-default" type="button" id="inventory"><b>Inventory</b></button></li>
				</ul>
			</div>

			<div class="btn-group" role="group">
				<button class="btn btn-default dropdown-toggle" type="button" id="main" data-toggle="dropdown">RMA<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="main">
					<li><button class="btn btn-default" type="button" id="rmaback">RMA</button></li>
					<li><button class="btn btn-default" type="button" id="rmasell">RMA Sale</button></li>
					<li><button class="btn btn-default" type="button" id="rmainventory">RMA Inventory</button></li>
				</ul>
			</div>
			<div class="btn-group" role="group">
				<button class="btn btn-default dropdown-toggle" type="button" id="main" data-toggle="dropdown">MIX<span class="caret"></span></button>
				<ul class="dropdown-menu" role="menu" aria-labelledby="main">
					<li><button class="btn btn-default" type="button" id="mixback">MIX</button></li>
					<li><button class="btn btn-default" type="button" id="mixsell">MIX Sale</button></li>
					<li><button class="btn btn-default" type="button" id="mixinventory">MIX Inventory</button></li>
				</ul>
			</div>
			<button id="btnSingle1" value="shoe" type="button" class="btn btn-lg text-white"><b>Products</b></button>
			<button id="btnSingle2" value="warehouse" type="button" class="btn btn-lg text-white"><b>Warehouse</b></button>
			<button id="btnSingle3" value="brand" type="button" class="btn btn-lg text-white"><b>Brands</b></button>			
			<button id="btnSingle4" value="employee" type="button" class="btn btn-lg text-white"><b>Employees</b></button>
		</div>
	</div>
	
</div>
	<div id="win" style="margin:0px;padding:0px;overflow:hidden">
	</div>

<style>
	.btn-group button {  
		background-image: url('./display_photo/bk_btn.jpg');
        background-size: cover;
        font-size: 2rem;
		color:white;
		border-radius: 2px; border: 2px solid #B21368;
		width: 163px;
		height: 50px;
	}

</style>
<style>

	iframe {
		display: block;       /* iframes are inline by default */
		background: #000;
		border: none;         /* Reset default border */
		height: 100vh;        /* Viewport-relative units */
		width: 100vw;
	}
</style>
<script>
	$("#purchase").click(function() {
		win.innerHTML = "<iframe src=\"purchase.php\"></iframe>";
	})
</SCRIPT>
<script>
	$("#sell").click(function() {
		win.innerHTML = "<iframe src=\"sell.php\"></iframe>";
	})
</SCRIPT>
<script>
	$("#inventory").click(function() {
		win.innerHTML = "<iframe src=\"inventory.php\"></iframe>";
	})
</SCRIPT>

	
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
