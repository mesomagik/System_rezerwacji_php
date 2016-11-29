<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showDzien();
//}

function showDzien(){
	$response = array();
	global $connect;
	$id_wizyta = $_POST["id_wizyta"];

	$result = mysqli_query($connect,'delete from wizyta where id_wizyta="'.$id_wizyta.'";') or die(mysql_error());

	$response["success"] = 1;
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}



?>