<?php

include 'connection.php';
loguj();


function loguj(){
	global $connect;

$response = array();
$login=$_POST['login'];
$haslo=$_POST['haslo'];


$result_uzytkownik = mysqli_query($connect,"SELECT * from user where email ='".$login."' and haslo = '".$haslo."';") ;

if (mysqli_num_rows($result_uzytkownik) > 0) {
	
    while ($uzytkownik_pom = mysqli_fetch_array($result_uzytkownik)) {
            $uzytkownik = $uzytkownik_pom["id"];
			$aktywne = $uzytkownik_pom["aktywne"];
			break;
           }
$response["id"] = $uzytkownik;
$response["zalogowany"] = "1";
$response["aktywny"] = $aktywne;
}else {

	$response["id"] = "-1";
	$response["id"] = "-1";
	$response["zalogowany"] = "0";
	$response["aktywny"] = "-1";
}
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}
?>

