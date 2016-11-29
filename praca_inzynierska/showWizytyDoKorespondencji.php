<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showWizyta();
//}

function showWizyta(){
	global $connect;
$response = array();

$id_uzytkownik=$_POST['id_uzytkownik'];

$result = mysqli_query($connect,"SELECT * FROM wizyta where wizyta_id_uzytkownik = ".$id_uzytkownik." ;") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["wizyta"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id_wizyta"] = $row["id_wizyta"];
            $item["wizyta_id_uzytkownik"] = $row["wizyta_id_uzytkownik"];
			$item["wizyta_id_data"] = $row["wizyta_id_data"];
			$item["odbyta"] = $row["odbyta"];
			$item["wizyta_id_godzina"] = $row["wizyta_id_godzina"];
			$item["pierwsza"] = $row["pierwsza"];
			       
			$result1 = mysqli_query($connect,"select data from dzien where id_dzien = ".$item["wizyta_id_data"].";");
            $row = mysqli_fetch_array($result1);
			$item["dzien"] = $row["data"];
			
			$result1 = mysqli_query($connect,"select godzina from godzina where id_godzina = ".$item["wizyta_id_godzina"].";");
            $row = mysqli_fetch_array($result1);
			$item["godzina"] = $row["godzina"];
			
			$result1 = mysqli_query($connect,'SELECT * FROM wiadomosc WHERE wiadomosc_id_wizyta='.$item["id_wizyta"].' and id_wiadomosc=(select max(id_wiadomosc) from wiadomosc where wiadomosc_id_wizyta='.$item["id_wizyta"].')');
            $row = mysqli_fetch_array($result1);
			$item["tekst"] = $row["tekst"];
			$item["id_wiadomosc"] = $row["id_wiadomosc"];
			$item["wiadomosc_id_user"] = $row["wiadomosc_id_user"];
			
			
            array_push($response["wizyta"], $item);
           
     $response["success"] = 1;
}
}
else {
      $response["success"] = 0;
}
array_sort_by_column($response["wizyta"], 'id_wiadomosc');
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}

function array_sort_by_column(&$arr, $col, $dir = SORT_DESC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
?>