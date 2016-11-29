<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showDzien();
//}

function showDzien(){
	$response = array();
	global $connect;
	$id_wizyta = $_POST["id_wizyta"];
	$wizyta_id_data = $_POST["wizyta_id_data"];
	$wizyta_id_godzina = $_POST["wizyta_id_godzina"];
	$pierwsza =  $_POST["pierwsza"];

	$result = mysqli_query($connect,'update wizyta set wizyta_id_data="'.$wizyta_id_data.'", wizyta_id_godzina="'.$wizyta_id_godzina.'", pierwsza="'.$pierwsza.'" where id_wizyta="'.$id_wizyta.'";') or die(mysql_error());

	$response["success"] = 1;
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}



?>