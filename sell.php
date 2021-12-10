<!DOCTYPE html> 
<html>
    <head>
        <title>Sale</title>
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
        <?php require_once 'sellprocess.php'; ?>
        
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);

        ?>
		<div class="container">
			<div class="row justify-content-center" style="padding:40px; font-size:20px">
				<?php 
					date_default_timezone_set('America/Los_Angeles');
				?>
				<label style="background-color:#ffffff" for="date"><b>Sale Date:</b></label>
				<div class = "space">   </div>   
				<input type="date" id="date" name="date" value="<?php echo date("Y-m-d") ?>" min="2018-01-01" max="2030-12-31">

			</div>
			<div>
			<div class="row justify-content-center">
				<table id="table1" class="table">
					<thead>
						<tr>
							<th>BRAND</th>
							<th>STYLE</th>
							<th>COLOR</th>
							<th>MATERIAL</th>
							<th>BOX</th>
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
		
		<div class="row justify-content-center" id="here">
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
			
			.table-hover tbody tr:hover td {
				background: #FEF878;
			}
			
			h5{
				padding-top: 30px;
				background:#ffffff;
			}
			
			#here{
				table-layout:fixed;
			}
			
			.table-hover tbody tr:hover td {
				background-color: #FEF878;
			}
			
		</style>
		
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
			$(document).on('change', '#material', function(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				
				$.ajax({
					url:"sellprocess.php",				
					method:"POST",
					data:{
						brand3:brand,
						name2:name,
						color1:color,
						material:material
					},					
					success:function(s_box){		
						s_box = "<option>-----</option>" +s_box;					
						$('#box').html(s_box);
					},
					error: function (s_box) {
						alert("Local error callback.");
					},
					complete: function (s_box) {
						//alert("Local completion callback.");
					}
				})//end ajax
			});
		</script>
		<script>
			function getInputValue(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				var box = $('#box :selected').val();
				var quantity = document.getElementById("quantity").value;
				var selldate = $('#date').val();
				
				$.ajax({
					url:"sellprocess.php",				
					method:"POST",
					data:{
						brand4:brand,
						name3:name,
						color2:color,
						material1:material,
						box:box,
						quantity:quantity,
						selldate:selldate
					},
					success:function(divStr){		
						alert("INSERT SUCCESS!!");
						document.getElementById("here").innerHTML = divStr;
					},
					error: function (divStr) {
						alert("Local error callback.");
					},
					complete: function (divStr) {
						//alert("Local completion callback.");
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
					var box=currentRow.find("td:eq(4)").text();
					var quantity=currentRow.find("td:eq(5)").text();
					var selldate = $('#date').val();
					$.ajax({
						url:"sellprocess.php",
						type:"POST",
						data:{
							brand5:brand,
							name4:name,
							color3:color,
							material2:material,
							box1:box,
							quantity1:quantity,
							selldate1:selldate
						},
						success:function(res){	
							alert(res);
						},
						error: function () {
							alert("Local error callback.");
						},
						complete: function () {
							//alert("Local completion callback.");
						}
					});
				}
			});
		</script>
    </body>
</html>
