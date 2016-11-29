<?php
if($_SERVER["REQUEST_METHOD"]== "POST"){
	
include 'connection.php';
showUsers();
}

function showUsers(){
	global $connect;

	$id=$_POST['id'];
	$email=$_POST['email'];
	
	$result = mysqli_query($connect,'update user set email="'.$email.'" where id="'.$id.'"') or die(mysql_error());

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