<!DOCTYPE html>
<html>
    <head>
        <title>Warehouse</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require_once 'warehouseprocess.php'; ?>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php=$_SESSION['msg_type']?>">
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
			
			
        ?>
		</div>
		
		<div class="form-group">
			<table class="table">
				<thead>
					<tr>
						<th>BRAND</th>
						<th>STYLE</th>
						<th>COLOR</th>
						<th>MATERIAL</th>
						<th>SIZE</th>
					</tr>
				</thead>
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
						<input type="button" value="SEARCH" onclick="setdivcontent()"> 
					</td>
				</tr>
			</table>
		</div>
		
		<div id="here">
		</div>


	
        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"warehouseprocess.php",				
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
					url:"warehouseprocess.php",				
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
					url:"warehouseprocess.php",				
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
			$(document).on('change', '#material', function(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				
				$.ajax({
					url:"warehouseprocess.php",				
					method:"POST",
					data:{
						brand3:brand,
						name2:name,
						color1:color,
						material:material
					},					
					success:function(res3){		
						res3 = "<option>-----</option>" +res3;					
						$('#box').html(res3);
					},
					error: function (res3) {
						alert("Local error callback.");
					},
					complete: function (res3) {
					}
				})//end ajax
			});
		</script>
		 <script>
			function setdivcontent(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				
				$.ajax({
					url:"warehouseprocess.php",				
					method:"POST",
					data:{
						brand4:brand,
						name3:name,
						color2:color,
						material1:material
					},
					success:function(divStr){	
						document.getElementById("here").innerHTML = divStr;
					},
					error: function (divStr) {
						alert("Local error callback.");
					},
					complete: function (divStr) {
						//alert("Local completion callback.");
					}
				})//end ajax
				//window.location.reload();
			}
		</script>
    </body>
</html>