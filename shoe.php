<!DOCTYPE html>
<html>
    <head>  
        <title>Shoe_Catalog</title>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
            $mysqli = new mysqli('localhost','root','123','top_shoe') or die(mysqli_error($mysqli));
			$resultbrand = $mysqli->query("SELECT DISTINCT brand.id AS brandid, brand.name AS brand FROM `brand` WHERE 1;") or die($mysqli->error);
        ?>
		<div class="container">
			<div class="row row justify-content-center">
				<h2> Product Catalog </h2>
			</div>
			<div class="row">
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
							<input type="hidden" id="shoe_id" name="shoe_id" value="0">
							<input type="button" value="SEARCH" onclick="setdivcontent()"> 
						</td>
					</tr>
				</table>
			</div>
			<div class="row" id="displaybtn">
			</div>
			<div class="row" id="display">
			</div>
			
			<style>
				th {background:#b8def5;}
				.table-hover tbody tr:hover td {
					background: #FEF878;
				}
				.btn-group button {
				  background-color: #7097c1; 
				  color: white; /* White text */
				  font-size: 16px;
				  border-radius: 8px;
				  padding: 8px 30px; /* Some padding */
				  cursor: pointer; /* Pointer/hand icon */
				  float: left; /* Float the buttons side by side */
				}

				.table{
					table-layout:fixed;
				}

				/* Clear floats (clearfix hack) */
				.btn-group:after {
				  content: "";
				  clear: both;
				  display: table;
				}

				.btn-group button:not(:last-child) {
				  border-right: none; /* Prevent double borders */
				}

				/* Add a background color on hover */
				.btn-group button:hover {
				  background-color: #36577c;
				}
				
				iframe.hidden{ display:none }
			</style>
		</div>
	
        <script>
			$(document).on('change', '#brand', function(){
				var brand = $('#brand :selected').val();
				$.ajax({
					url:"shoeprocess.php",				
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
					url:"shoeprocess.php",				
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
					url:"shoeprocess.php",				
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
					url:"shoeprocess.php",				
					method:"POST",
					data:{
						brand3:brand,
						name2:name,
						color1:color,
						material:material
					},
					success:function(array){
						var result = $.parseJSON(array);
						alert(result[4]);
						document.getElementById("displaybtn").innerHTML = result[4];
						document.getElementById("shoe_id").value = result[3];
						const shoebtn = document.getElementById("shoe_dim_btn");
						const boxbtn = document.getElementById("box_dim_btn");
						const photobtn = document.getElementById("photo_btn");
						document.getElementById("display").innerHTML = result[0];
						shoebtn.onclick = function () {
						 	document.getElementById("display").innerHTML = result[0];
						};
						boxbtn.onclick = function () {
							document.getElementById("display").innerHTML = result[1];
						};
						photobtn.onclick = function () {
							document.getElementById("display").innerHTML = result[2];
						};
					},
					error: function (array) {
						alert("Local error callback.");
					}
				})
			}
		</script>
		<script>
			//update shoe dimension
			$("#display").on('click','.saveChanges',function(){
				var yes = confirm('Are you sure？');
				if (yes) {
					var shoe_id = document.getElementById("shoe_id").value;
					var $currentRow=$(this).closest("tr"); 
					var size=$currentRow.find("td:eq(0)").text();
					var length=$currentRow.find("td:eq(1)").text();
					var width=$currentRow.find("td:eq(2)").text();
					var height=$currentRow.find("td:eq(3)").text();
					var weight=$currentRow.find("td:eq(4)").text();
					$.ajax({
						url:"shoeprocess.php",
						type:"POST",
						data:{
							shoe_id:shoe_id,
							size:size,
							length:length,
							width:width,
							height:height,
							weight:weight
						},
						success:function(divStr1){	
							alert(divStr1);
						},
						error: function () {
							alert("Local error callback.");
						}
					});
				}
			});
		</script>
		<script>
			$("#display").on('click','.hasChanges',function(){
				var yes = confirm('Are you sure？');
				if (yes) {
					var shoe_id = document.getElementById("shoe_id").value;
					var brand = $('#brand :selected').val();
					var $currentRow=$(this).closest("tr"); 
					var box=$currentRow.find("td:eq(0)").text();
					var length=$currentRow.find("td:eq(1)").text();
					var width=$currentRow.find("td:eq(2)").text();
					var height=$currentRow.find("td:eq(3)").text();
					var weight=$currentRow.find("td:eq(4)").text();

					$.ajax({
						url:"shoeprocess.php",
						type:"POST",
						data:{
							shoe_id1:shoe_id,
							brand4:brand,
							box:box,
							length1:length,
							width1:width,
							height1:height,
							weight1:weight
						},
						success:function(divStr2){	
							alert(divStr2);
						},
						error: function () {
							alert("Local error callback.");
						}
					});
				}
			});
		
		</script>

<?php
if(isset($_POST['upload'])){
	$filename = $_FILES['image']['name'];
	$shoe_id = $_POST['shoe_id'];
	
	// Getting file name
    $filename = $_FILES['image']['name'];
   
	$search_image_id = $mysqli->query("SELECT photo.image_id AS iid FROM photo WHERE photo.shoe_id = '$shoe_id';") or die($mysqli->error);
	while($data6=mysqli_fetch_assoc($search_image_id)){
		$image_id=$data6['iid'] + 1;
	}
	
   // Getting file name
   //$filename = $_FILES['image']['name'];
	if($filename != ""){
	   // Valid extension
	   $valid_ext = array('png','jpeg','jpg');
			
	   $photoExt1 = @end(explode('.', $filename)); // explode the image name to get the extension
	   $phototest1 = strtolower($photoExt1);
			
	   $new_profle_pic = time().'.'.$phototest1;
			
	   // Location
	   $location = "image/".$new_profle_pic;

	   // file extension
	   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
	   $file_extension = strtolower($file_extension);

	   // Check extension
	   if(in_array($file_extension,$valid_ext)){  

			// Compress Image
			compressedImage($_FILES['image']['tmp_name'],$location,60);
				
		}
		else
		{
				echo "File format is not correct.";
		}

		$sql = "INSERT INTO photo(shoe_id, image_id, image)VALUES ('" . $shoe_id . "', '" . $image_id. "', '".$new_profle_pic."')";
		if (mysqli_query($mysqli, $sql)) 
		{
			echo "New record created successfully";
		}
	} else {
		echo "PLEASE SELECTED A FILE";
	}
}	

// Compress image
function compressedImage($source, $path, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $path, $quality);

}
?>		
    </body>
</html>
