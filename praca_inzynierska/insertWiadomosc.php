<?php
header('Content-Type: application/json;charset=utf-8;');
include 'connection.php';
insertWizyta();


function insertWizyta(){
	global $connect;

$response = array();



$id_uzytkownik=$_POST['id_uzytkownik'];
$id_wizyta=$_POST['id_wizyta'];
$tekst=$_POST['tekst'];

echo $tekst;


$result_max_id_wiadomosc = mysqli_query($connect,"SELECT max(id_wiadomosc) FROM wiadomosc") ;
if (mysqli_num_rows($result_max_id_wiadomosc) > 0) {
	while ($max_id_wiadomosc = mysqli_fetch_array($result_max_id_wiadomosc)) {
		$max_id_wiadomosc_tabela = $max_id_wiadomosc["max(id_wiadomosc)"];
		echo ($max_id_wiadomosc_tabela);
		break;
		}
		$insertWiadomosc=mysqli_query($connect,"INSERT INTO wiadomosc VALUES ('".++$max_id_wiadomosc_tabela."','".$id_wizyta."','".$id_uzytkownik."','".$tekst."');") ;
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