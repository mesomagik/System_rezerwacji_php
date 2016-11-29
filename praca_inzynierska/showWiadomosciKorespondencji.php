<?php
header('Content-Type: application/json;charset=utf-8;');
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showWizyta();
//}

function showWizyta(){
	global $connect;
$response = array();

$id_wizyta=$_POST['id_wizyta'];

$result = mysqli_query($connect,"SELECT * FROM wiadomosc where wiadomosc_id_wizyta = ".$id_wizyta." order by id_wiadomosc desc;") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["wiadomosc"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id_wiadomosc"] = $row["id_wiadomosc"];
            $item["wiadomosc_id_wizyta"] = $row["wiadomosc_id_wizyta"];
			$item["wiadomosc_id_user"] = $row["wiadomosc_id_user"];
			$item["tekst"] = $row["tekst"];
			       
            array_push($response["wiadomosc"], $item);
           }
     $response["success"] = 1;
}
else {
      $response["success"] = 0;
}
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}
?>