<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));
$user_id = $_SESSION['UserID'];
	
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

if (isset($_POST['material'])){
	$brand = $_POST['brand3'];
	$name = $_POST['name2'];
	$color = $_POST['color1'];
	$material = $_POST['material'];
	$shoe_box = $mysqli->query("SELECT DISTINCT box.id AS boxid, box.name AS box FROM box WHERE box.brand_id = '$brand';") or die($mysqli->error);

	$s_box = "";//把準備回傳的變數res準備好
	while($sbox=mysqli_fetch_assoc($shoe_box)){
	   $s_box .= "
		  <option value='{$sbox["boxid"]}'>{$sbox['box']}</option>
	   ";
	};
	echo $s_box;
}

if (isset($_POST['brand4'])){
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	$box = $_POST['box'];
	$quantity = $_POST['quantity'];
	$selldate = $_POST['selldate'];
	$id = "test";
	$divStr = "<h5>Sale History in " . $selldate . " </h5>
		<table id=\"table2\" class=\"table table-bordered table-hover\" style=\"width:96%\"><tr class=\"info\"><th>brand</th><th>style</th><th>color</th><th>material</th><th>box</th><th>quantity</th><th>edit</th></tr>";
	$oldquantity=0;

	//find shoe_id	
	$shie_id = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($sid=mysqli_fetch_assoc($shie_id)){
		$shoe_id=$sid['sid'];
	}

	//find if row already exist in sell, update the quantity
	$check_sell = $mysqli->query("SELECT * FROM sell WHERE sell.date = '$selldate' AND sell.box_id = '$box' AND sell.shoe_id = '$shoe_id';") or die($mysqli->error);
	while($selld=mysqli_fetch_assoc($check_sell)){
		$id = $selld['id'];
		$oldquantity = $selld['quantity'];
	}
	if ($id=="test"){
		$insert_sell = $mysqli->query("INSERT INTO sell (date, box_id, shoe_id, quantity, employ_id) VALUES ('$selldate', '$box', '$shoe_id', '$quantity', '$user_id');") or die($mysqli->error);	
	} else {
		$newquantity = $oldquantity + $quantity;
		$update_sell = $mysqli->query("UPDATE sell SET quantity = $newquantity WHERE id = '$id';") or die($mysqli->error);
	}
	
	//display the list which is updated today;
	$hsell = $mysqli->query("SELECT * FROM sell WHERE sell.date = '$selldate' ORDER BY shoe_id ASC, box_id ASC;") or die($mysqli->error);
	while($p_history=mysqli_fetch_assoc($hsell)){
		//find quantity
		$hisid = $p_history['id'];
		$hisquantity = $p_history['quantity'];
		$hisshoe_id = $p_history['shoe_id'];
		$hisbox_id = $p_history['box_id'];
		//find shoe detail
		$shoedetail = $mysqli->query("SELECT * FROM shoe WHERE shoe.id = '$hisshoe_id';") or die($mysqli->error);
		while($shoed=mysqli_fetch_assoc($shoedetail)){
			$his_name=$shoed['name'];
			$his_color=$shoed['color'];
			$his_material=$shoed['material'];
			//find brand
			$boxnbrand = $mysqli->query("SELECT * FROM box WHERE box.id = '$hisbox_id';") or die($mysqli->error);
			while($reboxnbrand=mysqli_fetch_assoc($boxnbrand)){
				$hisbox_name = $reboxnbrand['name'];
				$brand_id = $reboxnbrand['brand_id'];
				
				$brandname = $mysqli->query("SELECT * FROM brand WHERE brand.id = '$brand_id';") or die($mysqli->error);
				while($resbrand=mysqli_fetch_assoc($brandname)){
					$hisbrand_name = $resbrand['name'];
					$editbtn = "<button class=\"saveChanges\" id=\"$hisid\" onclick=\"editclick(this.id\")\">UPDATE</button>";
					$divStr = $divStr . "<tr><td>" . $hisbrand_name . "</td><td>" .  $his_name . "</td><td>" . $his_color . "</td><td>" . $his_material . "</td><td>" . $hisbox_name . "</td><td contenteditable=\"true\">" . $hisquantity . "</td><td>" .  $editbtn . "</td></tr>";
				}
			}
		}
    }

	$divStr = $divStr . "</table>";
	echo $divStr;
	
}

if (isset($_POST['brand5'])){
	$brand = $_POST['brand5'];
	$name = $_POST['name4'];
	$color = $_POST['color3'];
	$material = $_POST['material2'];
	$box = $_POST['box1'];
	$quantity = $_POST['quantity1'];
	$selldate = $_POST['selldate1'];
	$shoe_id1 = '';
	$box_id1 = '';
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
	//find box_id	
	$boxid = $mysqli->query("SELECT DISTINCT box.id AS bid FROM box WHERE box.name = '$box' AND box.brand_id = '$brand_id1';") or die($mysqli->error);
	while($b_id=mysqli_fetch_assoc($boxid)){
		$box_id1=$b_id['bid'];
	}
	
	$update_selld = $mysqli->query("UPDATE sell SET quantity = '$quantity' WHERE sell.shoe_id = '$shoe_id1' AND sell.box_id = '$box_id1' AND sell.date = '$selldate';") or die($mysqli->error);
	if($update_selld ==true){
		$res = "UPDATE SUCCESS!!";
	}
	echo $res;
}	
?>

