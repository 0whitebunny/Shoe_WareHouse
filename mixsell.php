<!DOCTYPE html>
<html>
    <head>
        <title>RMA_Sell</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require_once 'rmasellprocess.php'; ?>
        
        <div class="container">
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);

        ?>
		</div>
		<div class="container table-responsive">
			<div class="row justify-content-center">
				<?php 
					date_default_timezone_set('America/Los_Angeles');
				?>
				<label for="date">RMA SELL Date</label>
				<input type="date" id="date" name="date" value="<?php echo date("Y-m-d") ?>" min="2018-01-01" max="2030-12-31">

			</div>
			<div>
			<table class="table">
				<thead>
					<tr>
						<th>BRAND</th>
						<th>STYLE</th>
						<th>COLOR</th>
						<th>MATERIAL</th>
						<th>SIZE</th>
						<th>QUANTITY</th>
						<th></th>
					</tr>
				</thead>
				<div class="row">
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
							<div">
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
							<input type="text" class="col-md-6" placeholder="Size" id="size">
						</td>

						<td>
							<input type="text" class="col-md-6" placeholder="Quantity" id="quantity">
						</td>
						<td align="left">
							<input type="button" class="btn btn-secondary" value="ADD" onclick="getInputValue()"> 
						</td>
					</tr>
				</div>
			</table>
			</div>
		</div>
		<style>
			.table-hover tbody tr:hover td {
				sellground: #FEF878;
			}
		</style>
		<div id="here">
		</div>
		
        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand:brand
					},					
					success:function(s_name){		
					s_name = "<option>-----</option>" +s_name;
					$('#name').html(s_name);
					}
				})
			});
		</script>
		<script>
			$(document).on('change', '#name', function(){				
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name:name
					},					
					success:function(s_color){		
					s_color = "<option>-----</option>" +s_color;					
					$('#color').html(s_color);
					}
				})
			});
		</script>
		<script>
			$(document).on('change', '#color', function(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand2:brand,
						name1:name,
						color:color
					},					
					success:function(s_material){		
					s_material = "<option>-----</option>" +s_material;
					$('#material').html(s_material);
					}
				})
			});
		</script>
		<script>
			function getInputValue(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				var size = document.getElementById("size").value;
				var quantity = document.getElementById("quantity").value;
				var rmaselldate = $('#date').val();
				
				$.ajax({
					url:"rmasellprocess.php",				
					method:"POST",
					data:{
						brand4:brand,
						name3:name,
						color2:color,
						material1:material,
						size:size,
						quantity:quantity,
						rmaselldate:rmaselldate
					},
					success:function(divStr){		
						alert("insert success");
						document.getElementById("here").innerHTML = divStr;
					},
					error: function (divStr) {
						alert("Local error callsell.");
					},
					complete: function (divStr) {
						//alert("Local completion callsell.");
					}
				})
			}
		</script>
		<script>
			$("#here").on('click','.saveChanges',function(){
				var yes = confirm('Are you sure？');
				if (yes) {
					var currentRow=$(this).closest("tr"); 
					var brand=currentRow.find("td:eq(0)").text();
					var name=currentRow.find("td:eq(1)").text();
					var color=currentRow.find("td:eq(2)").text();
					var material=currentRow.find("td:eq(3)").text();
					var size=currentRow.find("td:eq(4)").text();
					var quantity=currentRow.find("td:eq(5)").text();
					var rmaselldate = $('#date').val();
					$.ajax({
						url:"rmasellprocess.php",
						type:"POST",
						data:{
							brand5:brand,
							name4:name,
							color3:color,
							material2:material,
							size1:size,
							quantity1:quantity,
							rmaselldate1:rmaselldate
						},
						success:function(res){	
							alert(res);
						},
						error: function () {
							alert("Local error callsell.");
						},
						complete: function () {
							//alert("Local completion callsell.");
						}
					});
				}
			});
		</script>
    </body>
</html>
