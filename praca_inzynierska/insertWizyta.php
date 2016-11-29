<?php

include 'connection.php';
insertWizyta();


function insertWizyta(){
	global $connect;

$response = array();

$wizyta_id_uzytkownik=$_POST['wizyta_id_uzytkownik'];
$wizyta_id_data=$_POST['wizyta_id_data'];
$wizyta_id_godzina=$_POST['wizyta_id_godzina'];
$wizyta_tekst_wiadomosci=$_POST['tekst_wiadomosci'];

$result_pierwsza = mysqli_query($connect,'SELECT wizyta_id_uzytkownik from wizyta where wizyta_id_uzytkownik="'.$wizyta_id_uzytkownik.'";') or die(mysql_error());
			if (mysqli_num_rows($result_pierwsza) == 0 ){
				$pierwsza="1";
			}else{
				$pierwsza="0";
			}

$result_max_id_wiadomosc = mysqli_query($connect,"SELECT max(id_wiadomosc) FROM wiadomosc") ;
$result_max_id_wizyta = mysqli_query($connect,"SELECT max(id_wizyta) FROM wizyta") ;
if (mysqli_num_rows($result_max_id_wizyta) > 0 && mysqli_num_rows($result_max_id_wiadomosc) > 0) {
    while ($max_id_wizyta = mysqli_fetch_array($result_max_id_wizyta)) {
            $max_id_wizyta_tabela = $max_id_wizyta["max(id_wizyta)"];
			break;
           }
	$insertWizyta = mysqli_query($connect,"INSERT INTO wizyta VALUES ('".++$max_id_wizyta_tabela."','".$wizyta_id_uzytkownik."','".$wizyta_id_data."','0','".$wizyta_id_godzina."','".$pierwsza."');")  ;

	while ($max_id_wiadomosc = mysqli_fetch_array($result_max_id_wiadomosc)) {
		$max_id_wiadomosc_tabela = $max_id_wiadomosc["max(id_wiadomosc)"];
		break;
		}
		$max_id_wizyta_tabela = $max_id_wizyta["max(id_wizyta)"];
		$insertWiadomosc=mysqli_query($connect,"INSERT INTO wiadomosc VALUES ('".++$max_id_wiadomosc_tabela."','".++$max_id_wizyta_tabela ."','".$wizyta_id_uzytkownik."','".$wizyta_tekst_wiadomosci."');") ;
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