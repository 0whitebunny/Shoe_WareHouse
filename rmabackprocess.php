<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));
	
if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$shoe_name = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);
	$s_name = "";
	while($sname=mysqli_fetch_assoc($shoe_name)){
	   $s_name .= "
			<option value='{$sname["name"]}'>{$sname['name']}</option>
	   ";
	};
	echo $s_name;
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$shoe_color = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	$s_color = "";
	while($scolor=mysqli_fetch_assoc($shoe_color)){
	   $s_color .= "
		  <option value='{$scolor["color"]}'>{$scolor['color']}</option>
	   ";
	};
	echo $s_color;
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$shoe_material = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);
	$s_material = "";
	while($smaterial=mysqli_fetch_assoc($shoe_material)){
	   $s_material .= "
		  <option value='{$smaterial["material"]}'>{$smaterial['material']}</option>
	   ";
	};
	echo $s_material;
}

if (isset($_POST['brand4'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	$size = $_POST['size'];
	$quantity = $_POST['quantity'];
	$rmabackdate = $_POST['rmabackdate'];
	$id = "test";
	$divStr = "<div class=\"container table table-bordered table table-hover table table-condensed table-striped\"><table class=\"table\"><tr  class=\"info\"><th>brand</th><th>style</th><th>color</th><th>material</th><th>size</th><th>quantity</th><th>edit</th></tr>";
	$oldquantity=0;

	//find shoe_id	
	$shie_id = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($sid=mysqli_fetch_assoc($shie_id)){
		$shoe_id=$sid['sid'];
	}

	//find if row already exist in rmaback, update the quantity
	$check_rmaback = $mysqli->query("SELECT * FROM rma_back WHERE rma_back.date = '$rmabackdate' AND rma_back.size = '$size' AND rma_back.shoe_id = '$shoe_id';") or die($mysqli->error);
	while($rmabackd=mysqli_fetch_assoc($check_rmaback)){
		$id = $rmabackd['id'];
		$oldquantity = $rmabackd['quantity'];
	}
	if ($id=="test"){
		$insert_rmaback = $mysqli->query("INSERT INTO rma_back (date, shoe_id, size, quantity, employ_id) VALUES ('$rmabackdate', '$shoe_id', '$size', '$quantity', '1');") or die($mysqli->error);	
	} else {
		$newquantity = $oldquantity + $quantity;
		$update_rmaback = $mysqli->query("UPDATE rma_back SET quantity = $newquantity WHERE id = '$id';") or die($mysqli->error);
	}
	
	//display the list which is updated today;
	$hrmaback = $mysqli->query("SELECT * FROM rma_back WHERE rma_back.date = '$rmabackdate' ORDER BY shoe_id ASC, size ASC;") or die($mysqli->error);
	while($p_history=mysqli_fetch_assoc($hrmaback)){
		//find quantity
		$hisid = $p_history['id'];
		$hisquantity = $p_history['quantity'];
		$hisshoe_id = $p_history['shoe_id'];
		$hissize = $p_history['size'];
		//find shoe detail
		$shoedetail = $mysqli->query("SELECT * FROM shoe WHERE shoe.id = '$hisshoe_id';") or die($mysqli->error);
		while($shoed=mysqli_fetch_assoc($shoedetail)){
			$his_name=$shoed['name'];
			$his_color=$shoed['color'];
			$his_material=$shoed['material'];
			$brand_id = $shoed['brand_id'];
				
			$brandname = $mysqli->query("SELECT * FROM brand WHERE brand.id = '$brand_id';") or die($mysqli->error);
			while($resbrand=mysqli_fetch_assoc($brandname)){
				$hisbrand_name = $resbrand['name'];
				$editbtn = "<button class=\"saveChanges\" id=\"$hisid\" onclick=\"editclick(this.id\")\">UPDATE</button>";
				$divStr = $divStr . "<tr><td>" . $hisbrand_name . "</td><td>" .  $his_name . "</td><td>" . $his_color . "</td><td>" . $his_material . "</td><td>" . $hissize . "</td><td contenteditable=\"true\">" . $hisquantity . "</td><td>" .  $editbtn . "</td></tr>";
			}

		}
    }

	$divStr = $divStr . "</table></div>";
	echo $divStr;
	
}

if (isset($_POST['brand5'])){
	$brand = $_POST['brand5'];
	$name = $_POST['name4'];
	$color = $_POST['color3'];
	$material = $_POST['material2'];
	$size = $_POST['size1'];
	$quantity = $_POST['quantity1'];
	$rmabackdate = $_POST['rmabackdate1'];
	$shoe_id1 = '';
	$brand_id1 = '';
	$res = "fail";

	//find brand_id	
	$brandid = $mysqli->query("SELECT DISTINCT brand.id AS brid FROM brand WHERE brand.name = '$brand';") or die($mysqli->error);
	while($br_id=mysqli_fetch_assoc($brandid)){
		$brand_id1=$br_id['brid'];
	}
	//find shoe_id	
	$shoeid = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand_id1';") or die($mysqli->error);
	while($s_id=mysqli_fetch_assoc($shoeid)){
		$shoe_id1=$s_id['sid'];
	}

	$update_rmabackd = $mysqli->query("UPDATE rma_back SET quantity = '$quantity' WHERE rma_back.shoe_id = '$shoe_id1' AND rma_back.size = '$size' AND rma_back.date = '$rmabackdate';") or die($mysqli->error);
	if($update_rmabackd ==true){
		$res = "update success";
	}
	echo $res;
}	
?>

