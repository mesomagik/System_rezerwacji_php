<?php
//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showWizyta();
//}

function showWizyta(){
	global $connect;
$response = array();

$id_uzytkownik=$_POST['id_uzytkownik'];
//*****************nadchodzace********************************
$result = mysqli_query($connect,"SELECT w.* FROM wizyta w, dzien d where w.wizyta_id_uzytkownik = ".$id_uzytkownik." and d.id_dzien=w.wizyta_id_data  and d.data >= '".date("Y-m-d")."' ") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["wizyty_nadchodzace"] = array();

    while ($row = mysqli_fetch_array($result)) {
            $item = array();
            $item["id_wizyta"] = $row["id_wizyta"];
            $item["wizyta_id_uzytkownik"] = $row["wizyta_id_uzytkownik"];
			$item["wizyta_id_data"] = $row["wizyta_id_data"];
			$item["odbyta"] = $row["odbyta"];
			$item["wizyta_id_godzina"] = $row["wizyta_id_godzina"];
			$item["pierwsza"] = $row["pierwsza"];
			       
			$result1 = mysqli_query($connect,"select data from dzien where id_dzien = ".$item["wizyta_id_data"].";");
            $row = mysqli_fetch_array($result1);
			$item["dzien"] = $row["data"];
			
			$result1 = mysqli_query($connect,"select godzina from godzina where id_godzina = ".$item["wizyta_id_godzina"].";");
            $row = mysqli_fetch_array($result1);
			$item["godzina"] = $row["godzina"];
			
			
			$date = strtotime(date('Y-m-d'));
			$date2 = strtotime($item["dzien"]);
			$wynik = ($date2-$date)/86400;
			if($wynik>0 || $item["odbyta"]=="1"){
            array_push($response["wizyty_nadchodzace"], $item);
           }
     $response["success_nadchodzace"] = 1;
}
}
else {
      $response["success_nadchodzace"] = 0;
}
if (mysqli_num_rows($result) > 0){
	array_sort_by_column($response["wizyty_nadchodzace"], 'dzien');
}
//**************************odbyte*****************************
$result = mysqli_query($connect,"SELECT w.* FROM wizyta w, dzien d where w.wizyta_id_uzytkownik = ".$id_uzytkownik." and d.id_dzien=w.wizyta_id_data  and d.data < '".date("Y-m-d")."' ") or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["wizyty_odbyte"] = array();

    while ($row = mysqli_fetch_array($result)) {
		
            $item = array();
            $item["id_wizyta"] = $row["id_wizyta"];
            $item["wizyta_id_uzytkownik"] = $row["wizyta_id_uzytkownik"];
			$item["wizyta_id_data"] = $row["wizyta_id_data"];
			$item["odbyta"] = $row["odbyta"];
			$item["wizyta_id_godzina"] = $row["wizyta_id_godzina"];
			$item["pierwsza"] = $row["pierwsza"];
			       
			$result1 = mysqli_query($connect,"select data from dzien where id_dzien = ".$item["wizyta_id_data"].";");
            $row = mysqli_fetch_array($result1);
			$item["dzien"] = $row["data"];
			
			$result1 = mysqli_query($connect,"select godzina from godzina where id_godzina = ".$item["wizyta_id_godzina"].";");
            $row = mysqli_fetch_array($result1);
			$item["godzina"] = $row["godzina"];
			
			
			$date = strtotime(date('Y-m-d'));
			$date2 = strtotime($item["dzien"]);
			$wynik = ($date2-$date)/86400;
			if($wynik<0 ){
            array_push($response["wizyty_odbyte"], $item);
           }
     $response["success_odbyte"] = 1;
}
}
else {
      $response["success_odbyte"] = 0;
}
if (mysqli_num_rows($result) > 0){
	array_sort_by_column($response["wizyty_odbyte"], 'dzien');
}
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}
?>