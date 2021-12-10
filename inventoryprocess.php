<?php
session_start();
$mysqli = new mysqli('localhost', 'root', '123', 'top_shoe') or die(mysqli_error($mysqli));

if (isset($_POST['brand'])){
	$brand = $_POST['brand'];
	$name = "";
	$shoe_name = $mysqli->query("SELECT DISTINCT shoe.name AS name FROM shoe WHERE shoe.brand_id = '$brand';") or die($mysqli->error);
	
	while($data=mysqli_fetch_assoc($shoe_name)){
	   $name .= "
			<option value='{$data["name"]}'>{$data['name']}</option>
	   ";
	};
	echo $name;
}
  
if (isset($_POST['name'])){
	$brand = $_POST['brand1'];
	$name = $_POST['name'];
	$color = "";
	$shoe_color = $mysqli->query("SELECT DISTINCT shoe.color AS color FROM shoe WHERE shoe.name = '$name' AND shoe.brand_id = '$brand';") or die($mysqli->error);	
	while($data1=mysqli_fetch_assoc($shoe_color)){
	   $color .= "
		  <option value='{$data1["color"]}'>{$data1['color']}</option>
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
	while($data2=mysqli_fetch_assoc($shoe_material)){
	   $material .= "
		  <option value='{$data2["material"]}'>{$data2['material']}</option>
	   ";
	};
	echo $material;
}

if (isset($_POST['brand3'])){
	$brand = $_POST['brand3'];
	$name = $_POST['name2'];
	$color = $_POST['color1'];
	$material = $_POST['material'];
	$divStr = "<h3 class=\"font-size:24px\">Inventory Summary</h3><table id=\"table2\" class=\"table table-hover table-bordered table-condensed table-striped\"><tr><th class=\"col-3\">box</th><th class=\"col-3\">quantity</th><th class=\"col-6\"></th></tr>";
	$shoe_id = 0;
	
	//find shoe id
	$shoeid = $mysqli->query("SELECT DISTINCT shoe.id AS sid FROM shoe WHERE shoe.name = '$name' AND shoe.color = '$color' AND shoe.material = '$material' AND shoe.brand_id = '$brand';") or die($mysqli->error);
	while($data3=mysqli_fetch_assoc($shoeid)){
		$shoe_id=$data3['sid'];
	}
	
	//find the quantity: purchase - sell + revise of each box
	$box = $mysqli->query("SELECT * FROM box WHERE box.brand_id = '$brand';") or die($mysqli->error);
	while ($boxes = $box->fetch_assoc()){ 
		$box_id = $boxes['id'];
		//find quantity of purchase
		$pquantity = $mysqli->query("SELECT SUM(quantity) AS psum FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$box_id';") or die($mysqli->error);
		while($pq=mysqli_fetch_assoc($pquantity)){
			//find quantity of sell
			$squantity = $mysqli->query("SELECT SUM(quantity) AS ssum FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$box_id';") or die($mysqli->error);
			while($sq=mysqli_fetch_assoc($squantity)){
				//find quantity of revise
				$rquantity = $mysqli->query("SELECT SUM(quantity) AS rsum FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$box_id';") or die($mysqli->error);
				while($rq=mysqli_fetch_assoc($rquantity)){
					$psum=$pq['psum'];
					$ssum=$sq['ssum'];
					$rsum=$rq['rsum'];
					$sum = $psum - $ssum + $rsum;
					$editbtn = "<button class=\"saveChanges\" id=\"$box_id\" onclick=\"editclick(this.id)\">UPDATE</button>";
					$detailbtn = "<input type=\"button\" value=\"VIEW\" class=\"btn btn-info\" id=\"$box_id\" onclick=\"detailclick(this.id)\">";
					if ($sum  == 0) {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td contenteditable=\"true\">" .  '0' . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					} else {
						$divStr = $divStr . "<tr><td>" . $boxes['name'] . "</td><td contenteditable=\"true\">" .  $sum . "</td><td>" .  $editbtn . $detailbtn . "</td></tr>";
					}
				}
			}
		}
	}
	$divStr = $divStr . "</table>";
	echo json_encode(array($divStr, $shoe_id));
}

//update the revise
if (isset($_POST['brand4'])){
	$shoe_id = $_POST['shoe_id'];
	$brand = $_POST['brand4'];
	$box_name = $_POST['box'];
	$content = $_POST['content'];
	$box_id = 0;
	$sum1 = 0;
	$res = "quantity doesn't change!!!";
	
	//find box id
	$boxid = $mysqli->query("SELECT DISTINCT box.id AS bid FROM box WHERE box.name = '$box_name' AND box.brand_id = '$brand';") or die($mysqli->error);
	while($bid1=mysqli_fetch_assoc($boxid)){
		$box_id=$bid1['bid'];
	}
	
	//find quantity of box
	$pquantity1 = $mysqli->query("SELECT SUM(quantity) AS psum FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$box_id';") or die($mysqli->error);
	while($pq1=mysqli_fetch_assoc($pquantity1)){
		//find quantity of sell
		$squantity1 = $mysqli->query("SELECT SUM(quantity) AS ssum FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$box_id';") or die($mysqli->error);
		while($sq1=mysqli_fetch_assoc($squantity1)){
			//find quantity of revise
			$rquantity1 = $mysqli->query("SELECT SUM(quantity) AS rsum FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$box_id';") or die($mysqli->error);
			while($rq1=mysqli_fetch_assoc($rquantity1)){
				$psum1=$pq1['psum'];
				$ssum1=$sq1['ssum'];
				$rsum1=$rq1['rsum'];
				$sum1 = $psum1 - $ssum1 + $rsum1;
			}
		}
	}
	
	//get the quantity changed
	
	$fquantity = $content - $sum1;
	if($fquantity != 0){
		//insert data to rev, employee set 1
		$resultnr = $mysqli->query("INSERT INTO inventory_revise (date, box_id, shoe_id, quantity, employ_id) VALUES (now(), '$box_id', '$shoe_id', '$fquantity', '1');") or die($mysqli->error);
					$res = "QUANTITY UPDATE SUCCESS!!";
	}
	echo $res;
}

if (isset($_POST['brand5'])){
	$shoe_id = $_POST['shoe_id1'];
	$brand = $_POST['brand5'];
	$box = $_POST['box1'];
	$boxname = "";
	//find box name
	$boxn = $mysqli->query("SELECT DISTINCT box.name AS bn FROM box WHERE box.id = '$box' AND box.brand_id = '$brand';") or die($mysqli->error);
	while($datan=mysqli_fetch_assoc($boxn)){
		$boxname=$datan['bn'];
	}
	
	////////////////PURCHASE///////////////////
	//find quantity of purchase
	$text1 = "Purchase Inventory Detail";
	$divStr = "<table id=\"table3\" class=\"table table-hover1 table-bordered  table-condensed  table-striped\"><tr><th>box</th><th>active</th><th>date</th><th>quantity</th></tr>";
	$pquantity2 = $mysqli->query("SELECT * FROM purchase WHERE purchase.shoe_id = '$shoe_id' AND purchase.box_id = '$box';") or die($mysqli->error);
	while($pq2=mysqli_fetch_assoc($pquantity2)){
		//find date
		$purdate = $pq2['date'];
		$divStr = $divStr . "<tr><td>" . $boxname . "</td><td>" . 'purchase' . "</td><td>" .  $purdate . "</td><td>" .  $pq2['quantity'] . "</td></tr>";
	}	
	$divStr = $divStr . "</table>";
	
	////////////////SELL///////////////////
	$text2 = "Sale Inventory Detail";
	$divStr1 = "<table id=\"table4\" class=\"table table-hover1 table-bordered  table-condensed  table-striped\"><tr><th>box</th><th>active</th><th>date</th><th>quantity</th></tr>";
	//find quantity of sell
	$squantity2 = $mysqli->query("SELECT * FROM sell WHERE sell.shoe_id = '$shoe_id' AND sell.box_id = '$box';") or die($mysqli->error);
	while($sq2=mysqli_fetch_assoc($squantity2)){
		//find date
		$selldate = $sq2['date'];
		$divStr1 = $divStr1 . "<tr><td>" . $boxname . "</td><td>" . 'sale' . "</td><td>" .  $selldate . "</td><td>" .  $sq2['quantity'] . "</td></tr>";
	}	
	$divStr1 = $divStr1 . "</table>";
	
	////////////////REVISE///////////////////
	$text3 = "Revise Inventory Detail";
	$divStr2 = "<table id=\"table5\" class=\"table table-hover1 table-bordered  table-condensed  table-striped\"><tr><th>box</th><th>active</th><th>date</th><th>quantity</th></tr>";
	//find revise of sell
	$rquantity2 = $mysqli->query("SELECT * FROM inventory_revise WHERE inventory_revise.shoe_id = '$shoe_id' AND inventory_revise.box_id = '$box';") or die($mysqli->error);
	while($rq2=mysqli_fetch_assoc($rquantity2)){
		//find date
		$revdate = $rq2['date'];
		$divStr2 = $divStr2 . "<tr><td>" . $boxname . "</td><td>" . 'revise' . "</td><td>" .  $revdate . "</td><td>" .  $rq2['quantity'] . "</td></tr>";
	}	
	$divStr2 = $divStr2 . "</table>";

	////////////////Detail section///////////////////
	$divStr3 = "
	<button class=\"btn btn-info\" id=\"purchase\">Purchase</button>
	<button class=\"btn btn-info\" id=\"sell\">Sell</button>
	<button class=\"btn btn-info\"  id=\"revise\">Revise</button>
	</div>";

	echo json_encode(array($divStr, $divStr1, $divStr2, $divStr3, $text1, $text2, $text3));
}
?>
