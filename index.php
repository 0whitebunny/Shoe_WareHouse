<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</head>
<body>
	<?php session_start(); ?>
	<?php if (isset($_SESSION['message'])): ?>
	<div class="alert alert-<?=$_SESSION['msg_type']?>">
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
			unset($_SESSION["UserID"]);
			unset($_SESSION["Username"]);
		?>
	</div>
	<?php endif ?>
	<?php
		$mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));	
	?>
	<div class="container">
		<div class="row justify-content-center">
			<div id="carouselExampleSlidesOnly" class="carousel slide center-block" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<img src="./display_photo/up2.png" class="img-responsive" alt="Snow">
					</div>
					<div class="carousel-item">
						<img src="./display_photo/up1.png" class="img-responsive" alt="Snow">
					</div>
					<div class="carousel-item">
						<img src="./display_photo/up3.png" class="img-responsive" alt="Snow">
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-center" style="border-style:double">
			<img src="./display_photo/lg_logo.png" class="img-responsive center-block">
		</div>
		<div class="row justify-content-center" style="padding-top:60px">
		<h1><b>Sign in</b><br /></h1>
		</div>
		<div class="row justify-content-center" style="padding-top:60px">
		<form action="actionlogin.php" method="POST">
			<input type="hidden" name="id" value="<?php echo $id; ?>">
				<div class="form-group">
				<h3><label><b><u>Username:</u></b><br /></label></h3>
				<input type="text" style="font-size:24px" name="username" class="form-control" 
					   value="" placeholder="Enter your name">
				</div>
				
				 <div class="form-group">
				<h3><label><b><u>Password:</u></b><br /></label></h1>
				<input type="text" style="font-size:24px" name="password" class="form-control" 
					   value="" placeholder="Enter your password">
				</div>
				<br \>
				<input type="submit" class="btn btn-primary btn-lg" name="submit" value="Login">
				<input type="hidden" name="refer" value="<?php echo (isset($_GET['refer'])) ? $_GET['refer'] : 'index.php'; ?>">
		</form>
	</div>
</body>
</html>
