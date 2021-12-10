<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));
$user_id = $_SESSION['UserID'];
if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$name = "";
	$shoe_name = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);
	
	while($data1=mysqli_fetch_assoc($shoe_name)){
	   $name .= "
			<option value='{$data1["name"]}'>{$data1['name']}</option>
	   ";
	};
	echo $name;
}

if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$color = "";
	$shoe_color = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	
	while($data2=mysqli_fetch_assoc($shoe_color)){
	   $color .= "
		  <option value='{$data2["color"]}'>{$data2['color']}</option>
	   ";
	};
	echo $color;
}

if (isset($_POST['color'])){
	$brand = $_POST['brand2'];
	$name = $_POST['name1'];
	$color = $_POST['color'];
	$material = "";
	$shoe_material = $mysqli->query("SELECT DISTINCT shoe.material AS material FROM shoe WHERE shoe.brand_id = '$brand' AND shoe.name = '$name' AND shoe.color = '$color';") or die($mysqli->error);
	
	while($data3=mysqli_fetch_assoc($shoe_material)){
	   $material .= "
		  <option value='{$data3["material"]}'>{$data3['material']}</option>
	   ";
	};
	echo $material;
}

if (isset($_POST['material'])){
	$brand = $_POST['brand3'];
	$name = $_POST['name2'];
	$color = $_POST['color1'];
	$material = $_POST['material'];
	$shoe_id = 0;
	$shoe_box = $mysqli->query("SELECT DISTINCT box.id AS boxid, box.name AS box FROM box WHERE box.brand_id = '$brand';") or die($mysqli->error);

	$box = "";
	while($sbox=mysqli_fetch_assoc($shoe_box)){
	   $box .= "
		  <option value='{$sbox["boxid"]}'>{$sbox['box']}</option>
	   ";
	};
	
	//find shoe_id	
	$shio_id = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($sid=mysqli_fetch_assoc($shio_id)){
		$shoe_id=$sid['sid'];
	}

	echo json_encode(array($box, $shoe_id));

}

if (isset($_POST['brand4'])){
	$shoe_id = $_POST['shoe_id'];
	$brand = $_POST['brand4'];
	$name = $_POST['name3'];
	$color = $_POST['color2'];
	$material = $_POST['material1'];
	$box = $_POST['box'];
	$quantity = $_POST['quantity'];
	$price = $_POST['price'];
	$purchasedate = $_POST['purchasedate'];
	$id = "test";
	$divStr = "<h5>Purchase History in " . $purchasedate . " </h5>
		<table id=\"table2\" class=\"table table-bordered table-hover\" style=\"width:96%\">
			<tr class=\"info\">
				<th>brand</th>
				<th>style</th>
				<th>color</th>
				<th>material</th>
				<th>box</th>
				<th>quantity</th>
				<th>price</th>
				<th></th>
			</tr>";
	$oldquantity=0;

	//find if row already exist in purchase, update the quantity
	$check_purchase = $mysqli->query("SELECT * FROM purchase WHERE purchase.date = '$purchasedate' AND purchase.box_id = '$box' AND purchase.shoe_id = '$shoe_id' AND unit_price = '$price';") or die($mysqli->error);
	while($purchased=mysqli_fetch_assoc($check_purchase)){
		$id = $purchased['id'];
		$oldquantity = $purchased['quantity'];
	}
	if ($id=="test"){
		$insert_purchase = $mysqli->query("INSERT INTO purchase (date, box_id, shoe_id, quantity, unit_price, employ_id) VALUES ('$purchasedate', '$box', '$shoe_id', '$quantity', '$price', '$user_id');") or die($mysqli->error);	
	} else {
		$newquantity = $oldquantity + $quantity;
		$update_purchase = $mysqli->query("UPDATE purchase SET quantity = $newquantity WHERE id = '$id';") or die($mysqli->error);
	}
	
	//display the list which is updated today;
	$hpurchase = $mysqli->query("SELECT * FROM purchase WHERE purchase.date = '$purchasedate' ORDER BY shoe_id ASC, box_id ASC, unit_price ASC;") or die($mysqli->error);
	while($p_history=mysqli_fetch_assoc($hpurchase)){
		//find quantity and price
		$hisid = $p_history['id'];
		$hisquantity = $p_history['quantity'];
		$hisprice = $p_history['unit_price'];
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
					$divStr = $divStr . "<tr><td>" . $hisbrand_name . "</td><td>" .  $his_name . "</td><td>" . $his_color . "</td><td>" . $his_material . "</td><td>" . $hisbox_name . "</td><td contenteditable=\"true\">" . $hisquantity . "</td><td contenteditable=\"true\">" . $hisprice . "</td><td>" .  $editbtn . "</td></tr>";
				}
			}
		}
    }
	$divStr = $divStr . "</table>";
	echo $divStr;
}

if (isset($_POST['brand5'])){
	$shoe_id1 = $_POST['shoe_id1'];
	$brand = $_POST['brand5'];
	$box = $_POST['box1'];
	$quantity = $_POST['quantity1'];
	$price = $_POST['price1'];
	$purchasedate = $_POST['purchasedate1'];
	$box_id1 = '';
	$brand_id1 = '';
	$res = "FAIL";

	//find brand_id	
	$brandid = $mysqli->query("SELECT DISTINCT brand.id AS brid FROM brand WHERE brand.name = '$brand';") or die($mysqli->error);
	while($br_id=mysqli_fetch_assoc($brandid)){
		$brand_id1=$br_id['brid'];
	}
	
	//find box_id	
	$boxid = $mysqli->query("SELECT DISTINCT box.id AS bid FROM box WHERE box.name = '$box' AND box.brand_id = '$brand_id1';") or die($mysqli->error);
	while($b_id=mysqli_fetch_assoc($boxid)){
		$box_id1=$b_id['bid'];
	}
	
	$update_purchased = $mysqli->query("UPDATE purchase SET quantity = '$quantity', unit_price = '$price' WHERE purchase.shoe_id = '$shoe_id1' AND purchase.box_id = '$box_id1' AND purchase.date = '$purchasedate';") or die($mysqli->error);
	if($update_purchased == true){
		$res = "UPDATE SUCCESS!!";
	}
	echo $res;
}	
?>

