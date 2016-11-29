<?php
if($_SERVER["REQUEST_METHOD"]== "POST"){
	
include 'connection.php';
showUsers();
}

function showUsers(){
	global $connect;

	$id=$_POST['id'];
	$nazwisko=$_POST['nazwisko'];
	$imie=$_POST['imie'];
	

	$result = mysqli_query($connect,'update user set imie="'.$imie.'", nazwisko="'.$nazwisko.'" where id="'.$id.'"') or die(mysql_error());

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