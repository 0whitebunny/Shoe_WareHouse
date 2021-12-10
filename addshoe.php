<!DOCTYPE html>
<html>
    <head>
        <title>Add New Shoe</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php require_once 'addshoeprocess.php'; ?>
       
        <div class="container">
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);
			
			
        ?>
		</div>
	
		<div class="container">
			<div  style="text-align:center;">
				<h2> Add New Shoe </h2>
			</div>
			<table id="main" class="table table-bordered">
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
							<input type="text" placeholder="Style" id="style">
						</div>
					</td>
					<td>
						<div>
							<input type="text" placeholder="Color" id="color">
						</div>
					</td>
					<td>
						<div>
							<input type="text" placeholder="Material" id="material">
						</div>
					</td>
					<td>
						<input type="button" class="btn btn-secondary" value="ADD" onclick="getInputValue()"> 
					</td>
				</tr>
			</table>
		</div>
		
		<style>
			th {background:#b8def5;}
		
			.table-hover tbody tr:hover td {
				background: #FEF878;
			}

		</style>
		<div class="container" id="here">
		</div>

	
		<script>
			function getInputValue(){
				var brand = $('#brand :selected').val();
				var name = document.getElementById('style').value;
				var color = document.getElementById('color').value;							
				var material = document.getElementById('material').value;

				$.ajax({
					url:"addshoeprocess.php",				
					method:"POST",
					data:{
						brand:brand,
						name:name,
						color:color,
						material:material
					},
					success:function(divStr){		
						if(divStr == "ERROR: item already exists in database") {
							alert(divStr);
						} else if (divStr == "Insert Success."){
							alert(divStr);
						} else {
							document.getElementById("here").innerHTML = divStr;
						}
						
					},
					error: function (divStr) {
						alert("Local error callback.");
					},
					complete: function (divStr) {
						//alert("Local completion callback.");
					}
				});
			}
		</script>
		<script>
			function updateValue(){
				var brand = $('#brand :selected').val();
				var name = document.getElementById('style').value;
				var color = document.getElementById('color').value;							
				var material = document.getElementById('material').value;
				var shoeDTable = document.getElementById('shoedimension');
				var rowLength = shoeDTable.rows.length;	
				var insertSQL = 'INSERT INTO shoe_dimension(shoe_id, size, length, width, height, weight) VALUES';

				var shoe_id = "no";
				$.ajax({
					url:"addshoeprocess.php",				
					method:"POST",
					data:{
						brand1:brand,
						name1:name,
						color1:color,
						material1:material,
					},
					success:function(shoe_idphp){		
						shoe_id = shoe_idphp;
						for (var i = 1; i < rowLength; i++) {
							//gets cells of current row
							var oCells = shoeDTable.rows.item(i).cells;
							var size = oCells.item(0).innerHTML;
							var length = oCells.item(1).innerHTML;
							var width = oCells.item(2).innerHTML;
							var height = oCells.item(3).innerHTML;
							var weight = oCells.item(4).innerHTML;
							size = size.replace(/[^\d.-]/g, '');
							length = length.replace(/[^\d.-]/g, '');
							width = width.replace(/[^\d.-]/g, '');
							height = height.replace(/[^\d.-]/g, '');
							weight = weight.replace(/[^\d.-]/g, '');
							
							insertSQL += ' (' + shoe_id + ', ' + size + ', ' + length + ', ' + width + ', ' + height + ', ' + weight + '),';
						}

						insertSQL = insertSQL.substring(0, insertSQL.length - 1);
						insertSQL += ';';
						
						$.ajax({
							url:"addshoeprocess.php",				
							method:"POST",
							data:{
								insertSQL:insertSQL
							},
							success:function(final1){		
								alert(final1);
							},
						});
					},
				});
						
				
			}
		</script>
    </body>
</html>
				