<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showDzien();
//}

function showDzien(){
	global $connect;
$response = array();

$result = mysqli_query($connect,"SELECT * FROM dzien") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["dzien"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id_dzien"] = $row["id_dzien"];
            $item["data"] = $row["data"];
			$item["dzien_id_godzina_pocz"] = $row["dzien_id_godzina_pocz"];
			$item["dzien_id_godzina_kon"] = $row["dzien_id_godzina_kon"];
			       
            array_push($response["dzien"], $item);
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