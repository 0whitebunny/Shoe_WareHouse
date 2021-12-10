<?php

session_start();

$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));
	
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
	$size = $_POST['size'];
	$quantity = $_POST['quantity'];
	$mixdate = $_POST['backdate'];
	$res4 = "test";//把準備回傳的變數res準備好
	$result5 = $mysqli->query("SELECT DISTINCT mix_back_date.id AS baid FROM mix_back_date WHERE mix_back_date.date = '$mixdate' AND mix_back_date.brand_id = '$brand';") or die($mysqli->error);
	
	while($data=mysqli_fetch_assoc($result5)){
        $res4=$data['baid'];
    }
	
	//find if data in mix_back_date
    if($res4=="test"){
		$result6 = $mysqli->query("INSERT INTO mix_back_date (date, brand_id) VALUES ('$mixdate', '$brand');") or die($mysqli->error);
		if($result6==true){
			$result7 = $mysqli->query("SELECT DISTINCT mix_back_date.id AS baid FROM mix_back_date WHERE mix_back_date.date = '$mixdate' AND mix_back_date.brand_id = '$brand';") or die($mysqli->error);
			while($data1=mysqli_fetch_assoc($result7)){
				$res4=$data1['baid'];
			}
		}		
		else{
			echo  "Error: " . $result6;
		};
    };
	echo $res4;
	
	//find shoe id
	$result8 = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	
	while($data2=mysqli_fetch_assoc($result8)){
        $shoe_id=$data2['sid'];
    }
	
	//insert data to mix_back, employee set 1
	$result9 = $mysqli->query("INSERT INTO mix_back (mix_id, shoe_id, size, quantity, employ_id) VALUES ('$res4', '$shoe_id', '$size', '$quantity', '1');") or die($mysqli->error);

}
?>

