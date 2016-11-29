<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showUsers();
//}

function showUsers(){
	global $connect;
$response = array();
$id_uzytkownik =$_POST['id_uzytkownik'];


$result = mysqli_query($connect,'update user set aktywne=1 where id="'.$id_uzytkownik.'"') or die(mysql_error());

echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}

?>