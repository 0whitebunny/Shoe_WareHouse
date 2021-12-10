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

<div class="container">
	<div class="row justify-content-center">
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

	<div class="row" style="background-color:#ffffff; border-color:black; border-style:double;" >		
		<div class="col-11">
			<img src="./display_photo/logo.png" class="img-responsive center-block">
		</div>
		<div class="col-1">
			<a href="index.php">
			<span style="font-size:130%" class="glyphicon glyphicon-log-in"><u>Login </u></span> 
			</a>
		</div>
    </div>

	<div class="row" style="padding-top:60px">
		<div class="col-3">
			<div class="btn-group-vertical" role="group">
				<div class="dropdown">
					<button id="btnGroupDrop1" type="button" class="btn dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>Main Product</b></button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
						<a class="dropdown-item" style="font-size:large" href="purchase.php">Purchase</a>
						<a class="dropdown-item" style="font-size:large" href="sell.php">Sale</a>
						<a class="dropdown-item" style="font-size:large" href="inventory.php">Inventory</a>
					</div>
				</div>
				<div class="dropdown">
					<button id="btnGroupDrop2" type="button" class="btn dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>RMA</b></button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop2">
						<a class="dropdown-item" style="font-size:large" href="rmapurchase.php">RMA</a>
						<a class="dropdown-item" style="font-size:large" href="rmasell.php">MRA Sale</a>
						<a class="dropdown-item" style="font-size:large" href="rmainventory.php">RMA Inventory</a>
					</div>
				</div>
				<div class="dropdown">
					<button id="btnGroupDrop3" type="button" class="btn dropdown-toggle btn-lg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>MIX</b></button>
					<div class="dropdown-menu" aria-labelledby="btnGroupDrop3">
						<a class="dropdown-item" style="font-size:large" href="mixpurchase.php">Mix Purchase</a>
						<a class="dropdown-item" style="font-size:large" href="mixsell.php">Mix Sale</a>
						<a class="dropdown-item" style="font-size:large" href="mixinventory.php">Mix Inventory</a>
					</div>
				</div>
				<div>
					<button id="btnSingle1" type="button" class="btn btn-lg">
						<a href="shoe.php" class="text-white"><b>Products</b></a>
					</button>
				</div>
				<div>
					<button id="btnSingle2" type="button" class="btn btn-lg">
						<a href="warehouse.php" class="text-white"><b>Warehouse</b></a>
					</button>
				</div>
				<div>
					<button id="btnSingle3" type="button" class="btn btn-lg">
						<a href="brands.php" class="text-white"><b>Brands</b></a>
					</button>
				</div>
				<div>
					<button id="btnSingle4" type="button" class="btn btn-lg">
						<a href="employee.php" class="text-white"><b>Employees</b></a>
					</button>
				</div>
			</div>
		</div>
		<div class="col-7">
			<h4>Welcome to Top Shoe!</h4>
		</div>
	</div>
</div>

<style>
	.btn-group-vertical button {  
		background-image: url('./display_photo/bk_btn.jpg');
        background-size: cover;
        font-size: 2rem;
		color:white;
		border-radius: 2px; border: 2px solid #B21368;
	}
</style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
