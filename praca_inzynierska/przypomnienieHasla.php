<?php
header( 'Content-Type: text/html; charset=utf-8' );
ini_set('default_charset', 'utf-8');

require_once "PHPMailer/PHPMailerAutoload.php";

include 'connection.php';
insertDzien();


function insertDzien(){
	global $connect;


$email =  $_POST['email'];
	
$user_query = mysqli_query($connect,"select * from user where email='".$email."'") ;
if (mysqli_num_rows($user_query) > 0) {
	while ($user = mysqli_fetch_array($user_query)) {
		if($user["id"]>1){
			$email = $user["email"];
			$imie = $user["imie"];
			$nazwisko = $user["nazwisko"];
			break;
		}
	}
	
	$nowe_haslo=generateRandomString();
	
	//PHPMailer Object
	$mail = new PHPMailer;

	$mail->CharSet = 'UTF-8';
	$mail->Host = "localhost";
	//From email address and name
	$mail->From = "mesomagik@mesomagik.ugu.pl";
	$mail->FromName = "Robot";

	//To address and name
	$mail->addAddress($email,$imie.' '.$nazwisko);


	//Address to which recipient will reply
	$mail->addReplyTo("mesomagik@mesomagik.ugu.pl", "Reply");



	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = "Zmiana hasla";
	$mail->Body = 
	"<p>Pan(i) ".$imie." ".$nazwisko."</p>
	<br>
	<p>Aby zresetowac haslo nalezy kliknac na podany nizej link</p>
	<p>Jesli haslo nie powinno byc zresetowane lub otrzymana wiadomosc nie zostala wygenerowana przez Pana/Pania prosimy aby ja zignorowac.</p>
	<br>
	<p>Haslo bedzie obowiazywac dopiero po wejsciu w ponizszy link</p>
	<h2>Nowe haslo to: ".$nowe_haslo."</h2>
	<br>
	<p>www.mesomagik.ugu.pl/haslo/".dechex(74*$user["id"])."/".$nowe_haslo."</p>";
	$mail->AltBody = "";

	if(!$mail->send()) 
	{
		echo "Mailer Error: " . $mail->ErrorInfo ." ";
	} 
	else 
	{
		echo "Message has been sent successfully ";
	}
	$response["success"] = "1";
}
		   
else {

      $response["success"] = "0";
}

echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
	
}

function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}