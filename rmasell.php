<!DOCTYPE html>
<html>
    <head>
        <title>RMA SELL</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require_once 'rmasellprocess.php'; ?>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                <?php 
                    echo $_SESSION['message']; 
                    unset($_SESSION['message']);
                ?>
            </div>
        <?php endif ?>
        <div class="container">
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);

			$resultbox = $mysqli->query("SELECT DISTINCT box.name AS boxname FROM `box` WHERE 1") or die($mysqli->error);

        ?>
		</div>

		<div class="row justify-content-center">
			<?php 
				date_default_timezone_set('UTC');
			?>
			<label for="date">RMA SELL DATE</label>
			<input type="date" id="date" name="date" value="<?php echo date("Y-m-d") ?>" min="2018-01-01" max="2030-12-31">

		</div>
		
		<div class="row justify-content-center">
			<table class="table">
				<thead>
					<tr>
						<th>BRAND</th>
						<th>STYLE</th>
						<th>COLOR</th>
						<th>MATERIAL</th>
						<th>SIZE</th>
						<th>QUANTITY</th>
					</tr>
				</thead>
				<div class="row justify-content-center">
					<tr>
						<td>
							<div>
								<select id='brand'>
									<option>-----</option>
									<?php
									while($data=mysqli_fetch_assoc($resultbrand)){
									?>
										  <option value="<?php echo $data['brandid'];?>"><?php echo $data['brand'];?></option>
									<?php
									}
									?>
								</select>
							</div>
						</td>
						<td>
							<div>
								<select id='name'>
									<option>-----</option>
								</select>
							</div>
						</td>
						<td>
							<div>
								<select id='color'>
									<option>-----</option>
								</select>
							</div>
						</td>
						<td>
							<div>
								<select id='material'>
									<option>-----</option>
								</select>
							</div>
						</td>
						<td>
							<input type="text" placeholder="Enter size" id="size">
							<input type="text" placeholder="Enter quantity" id="quantity">
							<input type="button" value="ADD" onclick="getInputValue()"> 
						</td>
					</tr>
				</div>
			</table>
		</div>
		
		
		
		<script>
function msg() {
  alert("Hello world!");
}
</script>
        
        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();//注意:selected前面有個空格！
				$.ajax({
					url:"rmasellprocess.php",				
					method:"POST",
					data:{
						brand:brand
					},					
					success:function(res){		
					res = "<option>-----</option>" +res;
					$('#name').html(res);
					}
				})//end ajax
			});
		</script>
		
		<script>
			$(document).on('change', '#name', function(){				
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				$.ajax({
					url:"rmasellprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name:name
					},					
					success:function(res1){		
					res1 = "<option>-----</option>" +res1;					
					$('#color').html(res1);
					}
				})//end ajax
			});
		</script>
		<script>
			$(document).on('change', '#color', function(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				$.ajax({
					url:"rmasellprocess.php",				
					method:"POST",
					data:{
						brand2:brand,
						name1:name,
						color:color
					},					
					success:function(res2){		
					res2 = "<option>-----</option>" +res2;
					$('#material').html(res2);
					}
				})//end ajax
			});
		</script>
		 <script>
			function getInputValue(){
				// Selecting the input element and get its value 
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				var size = document.getElementById("size").value;
				var quantity = document.getElementById("quantity").value;
				var selldate = $('#date').val();
				alert(selldate);
				$.ajax({
					url:"rmasellprocess.php",				
					method:"POST",
					data:{
						selldate:selldate,
						brand4:brand,
						name3:name,
						color2:color,
						material1:material,
						size:size,
						quantity:quantity
					},
					//alert(selldate);
					success:function(res4){		
						alert(res4);
						alert("Local sucess callsell.");
					},
					error: function () {
						alert("Local error callsell.");
					},
					complete: function () {
						alert("Local completion callsell.");
					}
				})//end ajax
			}
		</script>
    </body>
</html>