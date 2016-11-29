<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showWizyta();
//}

function showWizyta(){
	global $connect;
	$id_wizyta = $_POST['id_wizyta'];
$response = array();

$result = mysqli_query($connect,'SELECT * FROM wizyta where id_wizyta="'.$id_wizyta.'"') or die(mysql_error());

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

            array_push($response["wizyta"], $item);
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