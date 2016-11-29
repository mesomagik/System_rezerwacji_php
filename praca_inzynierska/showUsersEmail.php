<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showDzien();
//}

function showDzien(){
	global $connect;

$response = array();


$result = mysqli_query($connect,"SELECT email FROM user") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["emails"] = array();

    while ($row = mysqli_fetch_array($result)) {

            $item = array();
            $item["email"] = $row["email"];
         		       
            array_push($response["emails"], $item);
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