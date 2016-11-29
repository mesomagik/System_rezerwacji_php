<?php

include 'connection.php';
insertDzien();


function insertDzien(){
	global $connect;

$data = $_POST['data'];
$dzien_id_godzina_pocz = $_POST['dzien_id_godzina_pocz'];
$dzien_id_godzina_kon = $_POST['dzien_id_godzina_kon'];
	
$response = array();


$result_max_id_dzien = mysqli_query($connect,"SELECT max(id_dzien) FROM dzien") ;
if (mysqli_num_rows($result_max_id_dzien) > 0) {
	while ($max_id_dzien = mysqli_fetch_array($result_max_id_dzien)) {
		$max_id_dzien_tabela = $max_id_dzien["max(id_dzien)"];
		break;
		}
		$insertUzytkownik=mysqli_query($connect,"INSERT INTO dzien VALUES ('".++$max_id_dzien_tabela."','".$data."','".$dzien_id_godzina_pocz."','".$dzien_id_godzina_kon."');") ;
		$response["success"] = "1";
}
		   
else {

      $response["success"] = "0";
}

echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}
?>