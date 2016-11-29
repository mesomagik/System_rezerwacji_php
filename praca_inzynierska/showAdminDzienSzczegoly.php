<?php

//if($_SERVER["REQUEST_METHOD"]== "POST"){
include 'connection.php';
showDzien();
//}

function showDzien(){
	global $connect;
$response = array();
$id_dzien = $_POST['id_dzien'];

$result = mysqli_query($connect,'SELECT * FROM dzien where id_dzien="'.$id_dzien.'"') or die(mysql_error());

if (mysqli_num_rows($result) > 0) {
  
    $response["dzien"] = array();

    while ($row = mysqli_fetch_array($result)) {
		
		$item["godziny"] = get_godzina_by_id($id_dzien,$row["dzien_id_godzina_pocz"],$row["dzien_id_godzina_kon"]);
		array_push($response["dzien"], $item);
	}
	

}
header('Content-Type: application/json;charset=utf-8; ');
echo "test json_odpowiedz";
echo json_encode($response);
echo " json_odpowiedz test";
}

function get_opis_niezarejestrowany($id_wizyta){
	global $connect;
	$result = mysqli_query($connect,'SELECT * FROM wiadomosc WHERE wiadomosc_id_wizyta='.$id_wizyta) or die(mysql_error());
	
	while($row = mysqli_fetch_array($result)){
		$opis = $row['tekst'];
		 
	}
return $opis;
		
}	

function get_imie_nazwisko($id_user){

	global $connect;
	$query = mysqli_query($connect,'SELECT * FROM user WHERE id="'.$id_user.'";') or die(mysql_error());
	
	while ($row = mysqli_fetch_array($query)){
		$result= $row['imie']." ".$row['nazwisko'];			
	}
		return $result;
	}

function sprawdz_wizyte_dla_godziny($id_dzien,$id_godzina){
	
	global $connect;
	
	$result=array();
	$query = mysqli_query($connect,'SELECT * FROM wizyta where wizyta_id_data="'.$id_dzien.'" and wizyta_id_godzina="'.$id_godzina.'"') or die(mysql_error());
	
	if (mysqli_num_rows($query) > 0) {
		while ($row = mysqli_fetch_array($query)){
			
			if($row["wizyta_id_uzytkownik"]=="0"){

			
				$opis = get_opis_niezarejestrowany($row["id_wizyta"]);

				
				//$opis = substr($opis,0,strlen($opis)/2);

				array_push($result,array(
				"opis"=>$opis,
				"id_wizyta" => $row["id_wizyta"],
				"wizyta_id_uzytkownik" => $row["wizyta_id_uzytkownik"],
				"wizyta_id_data" => $row["wizyta_id_data"],
				"odbyta" => $row["odbyta"],
				"wizyta_id_godzina" => $row["wizyta_id_godzina"],
				"pierwsza" => $row["pierwsza"]));
				
			}else{	
				array_push($result,array(
				"imie_nazwisko" => get_imie_nazwisko($row["wizyta_id_uzytkownik"]),
				"id_wizyta" => $row["id_wizyta"],
				"wizyta_id_uzytkownik" => $row["wizyta_id_uzytkownik"],
				"wizyta_id_data" => $row["wizyta_id_data"],
				"odbyta" => $row["odbyta"],
				"wizyta_id_godzina" => $row["wizyta_id_godzina"],
				"pierwsza" => $row["pierwsza"]));
			}
			
		}
		return $result;
	}else {
		array_push($result,array(
			'id_wizyta'=>-1
			));
		return $result;
	}
		
}

function get_godzina_by_id($id_dzien,$pocz,$kon){
	global $connect;
		//godzina po id
		
		$result=array();
		$query = mysqli_query($connect,'SELECT * FROM godzina where id_godzina>="'.$pocz.'" and id_godzina<"'.$kon.'"') or die(mysql_error());
		
		while ($row = mysqli_fetch_array($query)){
			$id_wizyta = sprawdz_wizyte_dla_godziny($id_dzien,$row['id_godzina']);
			array_push($result,array(
			'id_godzina'=>$row['id_godzina'],
			'godzina'=>$row['godzina'],
			'wizyta'=>$id_wizyta));
			
		}
		return $result;
	}

function wolne_godziny ($dzien, $pierwsza){
		//zwraca wolne godziny wg dnia
		
		
		$wizyty_wszystkie = get_all_by_day_zarejestrowani($dzien["id_dzien"]);
		//$wizyty_dnia_niezarejestrowani = get_all_by_day_niezarejestrowani($dzien["id_dzien"]);
		//$wizyty_wszystkie = array_merge($wizyty_dnia_zarejestrowani,$wizyty_dnia_niezarejestrowani);
		//var_dump($wizyty_wszystkie);
		
		$godziny = get_free_hours_by_day($dzien["id_dzien"],$dzien['dzien_id_godzina_pocz'],$dzien['dzien_id_godzina_kon']);	
		
		//var_dump($godziny);
		
		$iterator= array_merge($wizyty_wszystkie, $godziny); //iterator - array wizyt i wolnych godzin

		array_walk($iterator, function (& $item) { //zamiana 'wizyta_id_godzina' na 'id_godzina
			if(!empty($item['id_wizyta'])){
				$item['id_godzina'] = $item['wizyta_id_godzina'];
				unset($item['wizyta_id_godzina']);
			}
		});
		
		array_sort_by_column($iterator, 'id_godzina'); //sortowanie
		
		//var_dump($iterator);
		
		$wolne_godziny = array();
		$tmp=0; //flaga pierwszej wizyty
		
		for($i=$dzien['dzien_id_godzina_pocz']-1;$i<$dzien['dzien_id_godzina_kon']-1;$i++){
			//wybranie wolnych godzin
			if(!empty($iterator[$i]['pierwsza']) && $iterator[$i]['pierwsza']=='1'){
				$tmp=1;				
			}else if(!empty($iterator[$i]['pierwsza']) && $iterator[$i]['pierwsza']=='0'){
				$tmp=0;
			}else if(!empty($iterator[$i]['id_godzina']) && $iterator[$i]['id_godzina']==$i+1 && $tmp!=1 && $iterator[$i]['id_godzina']<$dzien['dzien_id_godzina_kon'] && !empty($iterator[$i]['godzina'])){
				if($pierwsza=='1' && 	!empty($iterator[$i+1]) && empty($iterator[$i+1]['id_wizyta']) && $iterator[$i+1]['id_godzina']<$dzien['dzien_id_godzina_kon']){
					array_push($wolne_godziny, $iterator[$i]);
					$tmp=0;
				}else if($pierwsza=='0'){
					array_push($wolne_godziny, $iterator[$i]);
					$tmp=0;
				}
			}else {
				$tmp=0;
			}
			
		}
		
		return $wolne_godziny;
	}
	
	function get_all_by_day_zarejestrowani($id_dzien){
		//wizyty w danym dniu
		global $connect;
		$result = array();
		$query = mysqli_query($connect,'SELECT * FROM wizyta WHERE wizyta_id_data='.$id_dzien) or die(mysql_error());
		
		
		 while ($row = mysqli_fetch_array($query)) {
			array_push($result,array(
				'id_wizyta'=>$row['id_wizyta'],
				'wizyta_id_uzytkownik'=>$row['wizyta_id_uzytkownik'],
				'wizyta_id_data'=>$row['wizyta_id_data'],
				'odbyta'=>$row['odbyta'],
				'wizyta_id_godzina'=>$row['wizyta_id_godzina'],
				'pierwsza'=>$row['pierwsza']));
		}
		
		return $result;
	}
	

	
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}
		array_multisort($sort_col, $dir, $arr);
	}

	
	function get_free_hours_by_day($id_dzien,$godz_pocz,$godz_kon){
		
		//TODO: wykluczyć indeksy dni których nie ma w bazie i zrobić redirect
		
		global $connect;
		$result = array();
		
		$query = mysqli_query($connect,'SELECT g.*, w.id_wizyta FROM godzina g, wizyta w WHERE g.id_godzina not in 
		(select g.id_godzina from godzina g, wizyta w where w.wizyta_id_data='.$id_dzien.' and wizyta_id_godzina=id_godzina) 
		group by g.id_godzina') or die(mysql_error());
		
		while ($row = mysqli_fetch_array($query)) {
		
			array_push($result,array(
			'id_godzina'=>$row['id_godzina'],
			'godzina'=>substr($row['godzina'],0,5)));
			}

		return $result;
	}
?>