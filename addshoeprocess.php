<?php

session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

if (isset($_POST['brand'])){
    $brand = $_POST['brand'];
	$name = $_POST['name'];
	$color = $_POST['color'];
	$material = $_POST['material'];
	$search = 0;
	$shoe_exist = 0;
	//$divStr = "ERROR: item already exists in database";
	$divStr = "";

	$search_exist = $mysqli->query("SELECT DISTINCT shoe.id AS shid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data=mysqli_fetch_assoc($search_exist)){
		if($data['shid'] > 0){
			$shoe_exist = 1;
		}
	}
	
	$search_shoe = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data1=mysqli_fetch_assoc($search_shoe)){
		if ($data1['sid'] > 0) {
			$search = 1;
		}
	}
	
	//if name color material exist, return error
	if ($shoe_exist == 1) {
		$divStr = "ERROR: item already exists in database";
	} 
	//else inesrt
	else { 
		//insert
		$insert_shoe = $mysqli->query("INSERT INTO shoe(name, color, material, brand_id) VALUES('$name', '$color', '$material', '$brand');") or die($mysqli->error);
		if ($insert_shoe = true){
			//if name exist -> return success
			if ($search == 1) {
				$divStr = ("INSERT SUCCESS!");
			}
			//else return need dim
			else
			{
				$divStr = "<div class=\"container table table-bordered table table-hover table table-condensed table-striped\"><table id=\"shoedimension\" class=\"table\"><caption style=\"caption-side:top\">" . $name . " is a new style, please fill up the size dimansion table</caption><tr><th>size</th><th>length</th><th>width</th><th>height</th><th>weight</th></tr>";

				$size = 5.0;
				while ($size <= 11){
					$divStr = $divStr . "<tr><td>" . $size . "</td><td contenteditable=\"true\">0</td><td contenteditable=\"true\">0</td><td contenteditable=\"true\">0</td><td contenteditable=\"true\">0</td></tr>";

					if ($size >= 9){
						$size += 1;
					} else {
						$size += 0.5;
					}
				}
				
				$updatebtn = "<input type=\"button\" id =\"ub\" class=\"btn btn-danger\" value=\"UPDATE\" onclick=\"updateValue()\">";

				$divStr = $divStr . "</table><p>" . $updatebtn . "</p></div>";
			}
		} 
	}

	echo $divStr;
}

if (isset($_POST['brand1'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name1'];
	$color = $_POST['color1'];
	$material = $_POST['material1'];
	
	$search_shoe1 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data1=mysqli_fetch_assoc($search_shoe1)){
       $shoe_id = $data1['sid'];
    }
	echo $shoe_id;
}
	
	
if (isset($_POST['insertSQL'])){
	$insertSQL = $_POST['insertSQL'];
	
	$final1 = "UPDATED DIMENSION SUCCESS";
	
	$insert_dimension = $mysqli->query("$insertSQL") or die($mysqli->error);
	
	echo $final1;
}
?>