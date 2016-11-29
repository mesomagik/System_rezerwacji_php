<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showUsers();
//}

function showUsers(){
	global $connect;
$response = array();

$id=$_POST['id_zalogowanego'];

$result = mysqli_query($connect,'SELECT * FROM user where id="'.$id.'"') or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["user"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id"] = $row["id"];
            $item["imie"] = $row["imie"];
			$item["email"] = $row["email"];
			$item["nazwisko"] = $row["nazwisko"];
			$item["telefon"] = $row["telefon"];
			$item["pesel"] = $row["pesel"];
			$item["adres"] = $row["adres"];
			$item["haslo"] = $row["haslo"];			
			$item["aktywne"] = $row["aktywne"];					
    
            array_push($response["user"], $item);
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