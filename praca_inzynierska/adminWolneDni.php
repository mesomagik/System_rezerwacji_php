<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showDzien();
//}

function showDzien(){
	global $connect;
	
	$dni_z_bazy = array();
	$response=array();
	$response["dni"]=array();
	$response["godziny"]=array();

	$ilosc_dni=30;

	$date1 =  date('Y-m-d', strtotime("+1 days"));
	$date2 =  date('Y-m-d', strtotime("+30 days"));

	$result = mysqli_query($connect,"SELECT * FROM dzien where data>'".date("Y-m-d")."' and data< '".$date2."' order by data") or die(mysql_error());

	if (mysqli_num_rows($result) > 0) {
	  

		while ($row = mysqli_fetch_array($result)) {
				
				$item = $row["data"];
				
				array_push($dni_z_bazy, $item);
				
			}
		for($i=0;$i<$ilosc_dni;$i++){
			$j=$i+1;
			$data = date('Y-m-d', strtotime("+".$j." days"));
			if(!in_array($data,$dni_z_bazy)){
				$item = array();
				$item["data"] = $data;
				array_push($response["dni"],$item);
			}
		}
	}
	
	$result = mysqli_query($connect,"SELECT * FROM godzina") or die(mysql_error());

	if (mysqli_num_rows($result) > 0) {
	  

		while ($row = mysqli_fetch_array($result)) {
				
			$item["id_godzina"] = $row["id_godzina"];
			$item["godzina"] = $row["godzina"];
			
			array_push($response["godziny"], $item);
				
		}
		
	}
		
     
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}

