<?php
if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showGodzina();
}

function showGodzina(){
	global $connect;
$response = array();

$result = mysqli_query($connect,"SELECT * FROM godzina") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["godzina"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id_godzina"] = $row["id_godzina"];
            $item["godzina"] = $row["godzina"];
			       
            array_push($response["godzina"], $item);
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