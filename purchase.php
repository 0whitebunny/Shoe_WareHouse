<!DOCTYPE html>
<html>
    <head>
        <title>Purchase</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
	<style>
		body  {
		  background-image: url("./display_photo/bk.png");  
		}
	</style>
        <?php require_once 'purchaseprocess.php'; 
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);
        ?>
		<div class="container">
			<div class="row justify-content-center" style="padding:40px; font-size:20px">
				<?php 
					date_default_timezone_set('America/Los_Angeles');
				?>
				<label style="background-color:#ffffff" for="date"><b>Purchase Date:</b></label>
				<div class = "space">   </div>   
				<input type="date" id="date" name="date" value="<?php echo date("Y-m-d") ?>" min="2018-01-01" max="2030-12-31">
			</div>
			<div class="row justify-content-center">
				<table id="table1" class="table">
					<thead>
						<tr>
							<th>BRAND</th>
							<th>STYLE</th>
							<th>COLOR</th>
							<th>MATERIAL</th>
							<th>BOX</th>
							<th>QUANTITY | PRICE</th>
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
								<div>
									<select id='box'>
										<option>-----</option>
									</select>
								</div>
							</td>
							<td>
								<input type="number" class="col-sm-4" placeholder="Quantity" id="quantity">
								<input type="number" class="col-sm-4" placeholder="Price" id="price">
								<input type="hidden" id="shoeID" name="shoeID" value="0">
								<input type="button" class="btn btn-secondary" value="ADD" onclick="getInputValue()"> 
							</td>
						</tr>
					</div>
				</table>
			</div>
			<div class="row justify-content-center" id="here">
				
			</div>
		</div>
			
		<style>
			.space {white-space:pre}
			
			#table1 th{
				background-image: url('./display_photo/bk_btn2.jpg');
				background-size: cover;
				border: 1px solid #4D365B;
				font-size:18px;
				color: #ffffff;
			}
		
			#table1 td{
				background:#ffffff;
				border: 1px solid #4D365B;
				font-size:20px;
			}
			
			#table2 th{
				background-image: url('./display_photo/bk_btn3.jpg');
				border: 1px solid #4D365B;
				font-size:18px;
				color: #ffffff;
			}
		
			#table2 td{
				background:#ffffff;
				border: 1px solid #4D365B;
				font-size:20px;
			}
			
			.table2:hover {
			  background-color: #3e8e41;
			}
			
			h5{
				padding-top: 30px;
				background:#ffffff;
			}
			
			#here{
				table-layout:fixed;
			}
		</style>
		
        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"purchaseprocess.php",				
					method:"POST",
					data:{
						brand:brand
					},					
					success:function(name){		
					name = "<option>-----</option>" + name;
					$('#name').html(name);
					}
				})
			});
		</script>
		<script>
			$(document).on('change', '#name', function(){				
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				$.ajax({
					url:"purchaseprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name:name
					},					
					success:function(color){		
					color = "<option>-----</option>" + color;					
					$('#color').html(color);
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
					url:"purchaseprocess.php",				
					method:"POST",
					data:{
						brand2:brand,
						name1:name,
						color:color
					},					
					success:function(material){		
					material = "<option>-----</option>" + material;
					$('#material').html(material);
					}
				})
			});
		</script>
		<script>
			$(document).on('change', '#material', function(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				
				$.ajax({
					url:"purchaseprocess.php",				
					method:"POST",
					data:{
						brand3:brand,
						name2:name,
						color1:color,
						material:material
					},					
					success:function(array){	
						var result = $.parseJSON(array);
						document.getElementById("shoeID").value = result[1];
						result[0] = "<option>-----</option>" + result[0];				
						$('#box').html(result[0]);
					},
					error: function () {
						alert("Local error callback.");
					}
				})
			});
		</script>
		<script>
			function getInputValue(){
				var shoe_id = document.getElementById("shoeID").value;
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				var box = $('#box :selected').val();
				var quantity = document.getElementById("quantity").value;
				var price = document.getElementById("price").value;
				var purchasedate = $('#date').val();
				
				$.ajax({
					url:"purchaseprocess.php",				
					method:"POST",
					data:{
						shoe_id:shoe_id,
						brand4:brand,
						name3:name,
						color2:color,
						material1:material,
						box:box,
						quantity:quantity,
						price:price,
						purchasedate:purchasedate
					},
					success:function(divStr){		
						alert("INSERT SUCCESS!!");
						document.getElementById("here").innerHTML = divStr;
					},
					error: function (divStr) {
						alert("Local error callback.");
					}
				})
			}
		</script>
		<script>
				$("#here").on('click','.saveChanges',function(){
				var yes = confirm('Are you sure？');
				if (yes) {
					var shoe_id = document.getElementById("shoeID").value;
					var currentRow=$(this).closest("tr"); 
					var brand=currentRow.find("td:eq(0)").text();
					var name=currentRow.find("td:eq(1)").text();
					var color=currentRow.find("td:eq(2)").text();
					var material=currentRow.find("td:eq(3)").text();
					var box=currentRow.find("td:eq(4)").text();
					var quantity=currentRow.find("td:eq(5)").text();
					var price=currentRow.find("td:eq(6)").text();
					
					var purchasedate = $('#date').val();
					$.ajax({
						url:"purchaseprocess.php",
						type:"POST",
						data:{
							shoe_id1:shoe_id,
							brand5:brand,
							box1:box,
							quantity1:quantity,
							price1:price,
							purchasedate1:purchasedate
						},
						success:function(res){	
							alert(res);
						},
						error: function () {
							alert("Local error callback.");
						}
					});
				}
			});
		</script>
    </body>
</html>
