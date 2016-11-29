<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	
	<div class="container" style="margin-left:10%; margin-right:10%; width:80%;">
		<h1 style="margin-bottom:30px;">Ostatnie wiadomości</h1>
		<form method="POST" action="wiadomoscControler">
			<label for="ilosc" >Ilość wyświetlanych ostatnich wiadomości </label>
			<select name="ilosc" id="ilosc">
				<?php 
				for($i=1; $i<=25;$i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
				?>
			</select>
			<button type="submit" name="submit_ilosc">Pokaż</button>
		</form>
		<?php 
		for($i=0; $i<count($ostatnie_wiadomosci); $i++){
			echo 
			'<table class="table" border="1" >
				<tr>
					<td><p style="display: inline"> Wizyta: </p><a style="display: inline" href="'.base_url("dzienControler/showDetails/".$dni[$i]['id_dzien']).'">'.$dni[$i]['data'].' - '.$godziny[$wizyty[$i]['wizyta_id_godzina']]['godzina'].'</a></td>
				</tr>
				<tr>
					<td><p style="display: inline">Pacjent: </p><a style="display: inline" href="'.base_url("uzytkownikControler/user/".$uzytkownicy[$i]['id']).'">'.$uzytkownicy[$i]['imie'].' '.$uzytkownicy[$i]['nazwisko'].'</a></td>
					
				</tr>';
				if($ostatnie_wiadomosci[$i]['wiadomosc_id_user']=='1'){
				echo 
				'<tr>
					<td>
						<p>administrator napisał:</p><p>'.$ostatnie_wiadomosci[$i]['tekst'].'</p>
					</td>
				</tr>';
				}else{
				echo 
				'<tr>
					<td>
						<p>'.$uzytkownicy[$i]['imie'].' '.$uzytkownicy[$i]['nazwisko'].' napisał(a):</p><p>'.$ostatnie_wiadomosci[$i]['tekst'].'</p>
					</td>
				</tr>';
				}			
				echo
				'<tr>
					<td><p style="display: inline">Zobacz </p><a style="display: inline" href="'.base_url("wiadomoscControler/korespondencja/".$wizyty[$i]['id_wizyta']).'">korespondencję wizyty</a></td>
				</tr>
			</table></br>';
		}
		?>
	</div>
	
</article>