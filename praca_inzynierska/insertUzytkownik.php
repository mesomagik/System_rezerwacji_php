<?php

include 'connection.php';
insertUzytkownik();


function insertUzytkownik(){
	global $connect;

$email = $_POST['email'];
$imie = $_POST['imie'];
$nazwisko =$_POST['nazwisko'];
$adres = $_POST['adres'];
$telefon = $_POST['telefon'];
$haslo = $_POST['haslo'];
$pesel = $_POST['pesel'];
	
$response = array();


$result_max_id_uzytkownik = mysqli_query($connect,"SELECT max(id) FROM user") ;
if (mysqli_num_rows($result_max_id_uzytkownik) > 0) {
	while ($max_id_uzytkownik = mysqli_fetch_array($result_max_id_uzytkownik)) {
		$max_id_uzytkownik_tabela = $max_id_uzytkownik["max(id)"];
		break;
		}
		$insertUzytkownik=mysqli_query($connect,"INSERT INTO user VALUES ('".++$max_id_uzytkownik_tabela."','".$email."','".$imie."','".$nazwisko."','".$adres."','".$telefon."','".$pesel."','".$haslo."','0');") ;
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