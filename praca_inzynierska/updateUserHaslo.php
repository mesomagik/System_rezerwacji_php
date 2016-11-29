<?php
if($_SERVER["REQUEST_METHOD"]== "POST"){
	
include 'connection.php';
showUsers();
}

function showUsers(){
	global $connect;

	$id=$_POST['id'];
	$haslo=$_POST['haslo'];
	
	$result = mysqli_query($connect,'update user set haslo="'.$haslo.'" where id="'.$id.'"') or die(mysql_error());

	if ($result) {
		 $response["success"] = 1;
	}
	else{
		  $response["success"] = 0;
	}

echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}
?>