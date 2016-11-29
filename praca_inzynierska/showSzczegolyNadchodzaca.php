<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showWizyta();
//}

function showWizyta(){
	global $connect;
$response = array();
$response["wizyta"] = array();

$id_wizyta = $_POST["id_wizyta"];
$wizyta_id_data = $_POST["wizyta_id_data"];
$wizyta_id_godzina = $_POST["wizyta_id_godzina"];
			       
$result1 = mysqli_query($connect,"select data from dzien where id_dzien = ".$wizyta_id_data.";");
$row = mysqli_fetch_array($result1);
$item["dzien"] = $row["data"];

$result1 = mysqli_query($connect,"select godzina from godzina where id_godzina = ".$wizyta_id_godzina.";");
$row = mysqli_fetch_array($result1);
$item["godzina"] = $row["godzina"];

$result1 = mysqli_query($connect,'SELECT * FROM wiadomosc WHERE wiadomosc_id_wizyta='.$id_wizyta.' and id_wiadomosc=(select max(id_wiadomosc) from wiadomosc where wiadomosc_id_wizyta='.$id_wizyta.')');
$row = mysqli_fetch_array($result1);
$item["tekst"] = $row["tekst"];
$item["wiadomosc_id_user"] = $row["wiadomosc_id_user"];

array_push($response["wizyta"], $item);

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