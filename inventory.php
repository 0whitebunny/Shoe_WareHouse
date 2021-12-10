<!DOCTYPE html>
<html>
    <head>
        <title>Inventory</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </head>
    <body>
		<style>
			body  {
			  background-image: url("./display_photo/bk.png");  
			}
		</style>
        <?php 
			require_once 'inventoryprocess.php'; 
			$mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);
		?>
		<div class="container">
			<div class="row row justify-content-center">
				<h3 style="padding:20px; font-size:24px"><b> Inventory </b></h3>
			</div>
			<div style="padding-top:10px" class="row justify-content-center">
				<table id="table1" class="table">
					<thead>
						<tr>
							<th>BRAND</th>
							<th>STYLE</th>
							<th>COLOR</th>
							<th>MATERIAL</th>
							<th></th>
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
							<input type="hidden" id="shoeID" name="shoeID" value="0">
							<input type="button" class="btn btn-secondary" value="SEARCH" onclick="setdivcontent()"> 
						</td>
					</tr>
				</table>
			</div>

			<div class="row">
				<div class="col-5">
					<div id="here"></div>
				</div>
				<div class="col-7">
					<div class="row">
						<div class="col-7">
							<h3 class="font-size:24px" id ="itext"></h3>
						</div>
						<div id="viewbtn" class="col-5">
							<div id="view"></div>
						</div>
					</div>
					<div class="row">
						<div id="display"></div>
					</div>
				</div>
			</div>
		</div>
		
		<style>
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
			
			#table3 th{
				background-image: url('./display_photo/bk_btn4.jpg');
				border: 1px solid #4D365B;
				font-size:18px;
				color: #ffffff;
			}
		
			#table3 td{
				background:#ffffff;
				border: 1px solid #4D365B;
				font-size:20px;
			}
			
				
			#table4 th{
				background-image: url('./display_photo/bk_btn4.jpg');
				border: 1px solid #4D365B;
				font-size:18px;
				color: #ffffff;
			}
		
			#table4 td{
				background:#ffffff;
				border: 1px solid #4D365B;
				font-size:20px;
			}
			
				
			#table5 th{
				background-image: url('./display_photo/bk_btn4.jpg');
				border: 1px solid #4D365B;
				font-size:18px;
				color: #ffffff;
			}
		
			#table5 td{
				background:#ffffff;
				border: 1px solid #4D365B;
				font-size:20px;
			}
			
			.table{
				table-layout:fixed;
			}
			
			#viewbtn{
				display:flex; 
				align-items:flex-end;
				
			}
						
			/* Add a background color on hover */
			.view:hover {
			  background-color: #3e8e41;
			}
			
			/* Add a background color on hover */
			.btn-group button:hover {
				background-color: #5f89b9;
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
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name:name
					},					
					success:function(color){		
					color = "<option>-----</option>" +color;					
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
					url:"inventoryprocess.php",				
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
			function setdivcontent(){
				var brand = $('#brand :selected').val();
				var name = $('#name :selected').val();
				var color = $('#color :selected').val();
				var material = $('#material :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
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
						document.getElementById("here").innerHTML = result[0];
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
					var currentRow=$(this).closest("tr"); 
					var box_name=currentRow.find("td:eq(0)").text();
					var content=currentRow.find("td:eq(1)").text(); 
					var shoe_id = document.getElementById("shoeID").value;
					var brand_id = $('#brand :selected').val();
					$.ajax({
						url:"inventoryprocess.php",
						type:"POST",
						data:{
							shoe_id:shoe_id,
							brand4:brand_id,
							box:box_name,
							content:content
						},
						success:function(divStr1){	
							alert(divStr1);
						},
						error: function (divStr1) {
							alert("Local error callback.");
						}
					});
				}
			});
		</script>

		<script>
			function detailclick(clicked_id){
				var shoe_id = document.getElementById("shoeID").value;
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"inventoryprocess.php",				
					method:"POST",
					data:{
						shoe_id1:shoe_id,
						brand5:brand,
						box1:clicked_id
					},
					success:function(array){		
						var result = $.parseJSON(array);
						document.getElementById("view").innerHTML = result[3];
						itext.innerText = result[4];
						document.getElementById("display").innerHTML = result[0];
						const shoebtn = document.getElementById("purchase");
						const boxbtn = document.getElementById("sell");
						const photobtn = document.getElementById("revise");
						shoebtn.onclick = function () {
							itext.innerText = result[4];
						 	document.getElementById("display").innerHTML = result[0];
						};
						boxbtn.onclick = function () {
							itext.innerText = result[5];
							document.getElementById("display").innerHTML = result[1];
						};
						photobtn.onclick = function () {
							itext.innerText = result[6];
							document.getElementById("display").innerHTML = result[2];
						};
					},
					error: function (array) {
						alert("Local error callback.");
					}
				})
			}
		</script>
    </body>
</html>
