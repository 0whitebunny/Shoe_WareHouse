<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

$id = 0;
$update = false;
$name = '';
$brand = '';

if (isset($_GET['search'])){
    $id = $_GET['search'];
	$brand = $_GET['brand'];
	$name = $_GET['name'];
	$color = $_GET['color'];
	$update = true;
    $result = $mysqli->query("SELECT box_id AS box_id, shoe_id AS shoe_id, length AS length, width AS width, height AS height, weight AS weight FROM box_dimension WHERE 1;") or die($mysqli->error());
    while($data=mysqli_fetch_assoc($result)){
        $row = $result->fetch_array();
        $box_id = $row['box_id'];
        $shoe_id = $row['shoe_id'];
		$length = $row['length'];
		$width = $row['width'];
		$height = $row['height'];
		$weight = $row['weight'];
    };
}



	
if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$result1 = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);

	$res = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result1)){
	   $res .= "
			<option value='{$data["name"]}'>{$data['name']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res;//將型號項目丟回給ajax
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$result2 = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);

	$res1 = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result2)){
	   $res1 .= "
		  <option value='{$data["color"]}'>{$data['color']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res1;//將型號項目丟回給ajax
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$result3 = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);

	$res2 = "";//把準備回傳的變數res準備好
	while($data=mysqli_fetch_assoc($result3)){
	   $res2 .= "
		  <option value='{$data["material"]}'>{$data['material']}</option>
	   ";//將對應的型號項目遞迴列出
	};
	echo $res2;//將型號項目丟回給ajax
}

if (isset($_POST['brand4'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	
	//find shoe id
	$result10 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data2=mysqli_fetch_assoc($result10)){
        $shoe_id=$data2['sid'];
    }
	
	$sql = $mysqli->query("SELECT * FROM shoe_section WHERE shoe_section.shoe_id = '$shoe_id';") or die($mysqli->error);
	
	$divStr = "<table class=\"table\"><tr><th>section</th><th>box</th><th>quantity</th></tr>";
	
	
	
	while ($row = $sql->fetch_assoc()){ 
		//find section info
		$section_id = $row['sec_id'];
		$result11 = $mysqli->query("SELECT DISTINCT section.floor AS sfloor , section.section AS ssection FROM section WHERE section.id = '$section_id';") or die($mysqli->error);
		while($data3=mysqli_fetch_assoc($result11)){
			$floor=$data3['sfloor'];
			$section=$data3['ssection'];
		}
		
		$box_id = $row['box_id'];
		$result12 = $mysqli->query("SELECT DISTINCT box.name AS bname FROM box WHERE box.id = '$box_id';") or die($mysqli->error);
		while($data4=mysqli_fetch_assoc($result12)){
			$bname=$data4['bname'];
		}
		
		$tem = $floor . $section;
		
		$divStr = $divStr . "<tr><td>" . $tem . "</td><td>" . $bname . "</td><td>" . $row['quantity'] . "</td></tr>";
	};   
	$divStr = $divStr . "</table>";
	echo $divStr;
}





?>

