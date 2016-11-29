<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showUsers();
//}

function showUsers(){
	global $connect;
$response = array();

$result = mysqli_query($connect,"SELECT * FROM user") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["users"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id_user"] = $row["id_user"];
            $item["surname"] = $row["surname"];
			$item["email"] = $row["email"];
			$item["name"] = $row["name"];
			$item["adress"] = $row["adress"];
			$item["adress_code"] = $row["adress_code"];
			$item["birth_date"] = $row["birth_date"];
			$item["active"] = $row["active"];
			$item["password"] = $row["password"];						
    
            array_push($response["users"], $item);
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