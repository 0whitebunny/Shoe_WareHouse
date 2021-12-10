<?php

session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$result1 = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);

	$res = "";
	while($data=mysqli_fetch_assoc($result1)){
	   $res .= "
			<option value='{$data["name"]}'>{$data['name']}</option>
	   ";
	};
	echo $res;
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$result2 = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);

	$res1 = "";
	while($data=mysqli_fetch_assoc($result2)){
	   $res1 .= "
		  <option value='{$data["color"]}'>{$data['color']}</option>
	   ";
	};
	echo $res1;
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$result3 = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);

	$res2 = "";
	while($data=mysqli_fetch_assoc($result3)){
	   $res2 .= "
		  <option value='{$data["material"]}'>{$data['material']}</option>
	   ";
	};
	echo $res2;
}

if (isset($_POST['brand4'])){
    $brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	
	//find shose_id
	$result10 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data2=mysqli_fetch_assoc($result10)){
        $shoe_id=$data2['sid'];
    }

	$sql = $mysqli->query("SELECT * FROM box_dimension WHERE box_dimension.shoe_id = $shoe_id;") or die($mysqli->error);
	
	$divStr = "<table class=\"table\"><tr><th>box</th><th>length</th><th>width</th><th>height</th><th>weight</th></tr>";

	while ($row = $sql->fetch_assoc()){ 
		$box_id = $row['box_id'];
		$result11 = $mysqli->query("SELECT DISTINCT box.name AS bname FROM box WHERE box.id = '$box_id';") or die($mysqli->error);
		while($data3=mysqli_fetch_assoc($result11)){
			$box_name=$data3['bname'];
		}
		
		$divStr = $divStr . "<tr><td>" . $box_name . "</td><td>" . $row['length'] . "</td><td>" . $row['width'] . "</td><td>" . $row['height'] . "</td><td>" . $row['weight'] . "</td></tr>";
	};   

	$divStr = $divStr . "</table>";
	
	echo $divStr;

	//header('location: 1.php');
}

?>
