<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	
	<script>
	
		$(document).ready(function(){
			$("#edytuj_dzien").click(function(){
				$("#div_edytuj").toggle(200);
			});
			$("#usun_dzien").click(function(){
				$("#div_usun").toggle(200);
				$("#alert_usun").hide();
			});
			$("#button_alert_usun").click(function(){
				$("#alert_usun").slideDown();
			});
			$("#submit_edytuj").click(function(){
				val1 = $("#edytuj_godzina_roz option:selected").val();
				if(val1<10){ val1="0"+val1};
				if(val1<$("#edytuj_godzina_zak option:selected").val() && 
				val1<=<?php if (!empty($wizyty_wszystkie)) echo $wizyty_wszystkie[0]['wizyta_id_godzina']; else echo 999;?> &&
				$("#edytuj_godzina_zak option:selected").val()><?php if (!empty($wizyty_wszystkie)) echo $wizyty_wszystkie[count($wizyty_wszystkie)-1]['wizyta_id_godzina']; else echo 0;?>){
					if(<?php if (!empty($wizyty_wszystkie))echo $wizyty_wszystkie[count($wizyty_wszystkie)-1]['pierwsza']; else echo 0;?> == '1' &&
					$("#edytuj_godzina_zak option:selected").val()><?php if (!empty($wizyty_wszystkie)) echo $wizyty_wszystkie[count($wizyty_wszystkie)-1]['wizyta_id_godzina']+1; else echo 0;?>){
						$('#form_edytuj').append('<input type="hidden" name="godzinaZgodna" value="1" />');
						var id_dzien = <?php echo $dzien->getId_dzien() ?>; 					
						$('#form_edytuj').append('<input type="hidden" name="id_dzien" value="'+id_dzien+'" />');
					}else if(<?php if (!empty($wizyty_wszystkie)) echo $wizyty_wszystkie[count($wizyty_wszystkie)-1]['pierwsza']; else echo 0; ?>== '1') {
						alert("Ostatnia wizyta jest dłuższa, wybierz kolejną godzinę");
						return false;
					}else {
						$('#form_edytuj').append('<input type="hidden" name="godzinaZgodna" value="1" />');
						var id_dzien = <?php echo $dzien->getId_dzien() ?>; 					
						$('#form_edytuj').append('<input type="hidden" name="id_dzien" value="'+id_dzien+'" />');
					}
				}else{
					$("#alert_czas").slideDown();
						setTimeout(function(){$("#alert_czas").slideUp()},2000);
					var id_dzien = <?php echo $dzien->getId_dzien() ?>; 
					$('#form_edytuj').append('<input type="hidden" name="id_dzien" value="'+id_dzien+'" />');
					$('#form_edytuj').append('<input type="hidden" name="godzinaZgodna" value="0" />');		
					return false;
				}
				$('#form_edytuj').append('<input type="hidden" name="data1" value="<?php echo $dzien->getData();?>" />');
			});
			$("#submit_usun").click(function(){
				$("#form_usun").append('<input type="hidden" name="id_dzien" value="<?php echo $dzien->getId_dzien(); ?>" />');
			});
			$(".wiecej").click(function(){
				$("#"+$(this).attr("id").replace("wizyta", "")).toggle(200);

			});
		});
	
	</script>
	<div class="container" >
		<div class="row" >
			<div style="text-align:center; margin-left:10%; margin-right:10%; width:80%;" >
				<div class="well well-sm">
				<div>
					<p>Data: <?php echo $dzien->getData(); ?> </p>
					<p>Godziny pracy: <?php echo substr($godziny_pracy[0]['godzina'],0,5); ?> - <?php echo substr($godziny_pracy[1]['godzina'],0,5); ?> </p>
				</div>
				</div>
				<div style="text-align:center;float:middle;">
				<?php 
					if($dzien->getData()>date("Y-m-d")){
						echo '<div style="display:inline;">
						<p class="btn btn-default" id="edytuj_dzien">Edytuj godziny pracy</p>
						</div>';
					}
					if($dzien->getData()>date("Y-m-d")){
						echo '<div style="display:inline;"><p class="btn btn-default dropdown-toggle"" id="usun_dzien">Usuń dzień pracy</p></div>';
						echo ' <div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Dodaj wizytę <span class="caret"></span>
							  </button>
							  <ul class="dropdown-menu">
								<li><a href="'.base_url('dodajWizyte/'.$this->uri->segment(2)).'">Dodaj wizytę niezarejestrowanego pacjenta</a></li>
								<li><a href="'.base_url('wyszukaj'),'">Dodaj wizytę zarejestrowanego pacjenta</a></li>
							  </ul></div>';
					}
				?>
					<div class="alert alert-danger" role="alert" id="alert_czas" style="display:none">Podano niepoprawny czas pracy</div>
					<div class="well" id="div_edytuj" style="display:none">
						<form id="form_edytuj" action="../dzienControler/update" method="post">
						<?php 
						if(count($wizyty_wszystkie)>0){
							echo '<p>Edycja godzin możliwa jest jedynie przed pierwszą oraz po ostatniej zarejestrowanej wizycie</p>';
						}
						?>
							<label>Godzina rozpoczęcia:</label>
							<select id="edytuj_godzina_roz" name="dodaj_godzina_roz">
								<?php 
									for($i=0;$i<count($godziny_wszystkie);$i++){
										echo '<option value="'.$godziny_wszystkie[$i]['id_godzina'].'"';
										if($godziny_wszystkie[$i]['id_godzina']==$dzien->getDzien_id_godzina_pocz())
											echo ' selected ';
										echo '>'.$godziny_wszystkie[$i]['godzina'].'</option>';
									}
								?>
							<select>
							<label>Godzina zakończenia:</label>
							<select id="edytuj_godzina_zak" name="dodaj_godzina_zak">
								<?php 
									for($i=0;$i<count($godziny_wszystkie);$i++){
										echo '<option value="'.$godziny_wszystkie[$i]['id_godzina'].'"';
										if($godziny_wszystkie[$i]['id_godzina']==$dzien->getDzien_id_godzina_kon())
											echo ' selected ';
										echo '>'.$godziny_wszystkie[$i]['godzina'].'</option>';
									}
								?>
							<select>
							<button class="btn btn-primary" type="submit" name="submit_edytuj" id="submit_edytuj">Edytuj</button>
						</form>
					</div>
					<?php 
					
					?>
					<div  class="well" id="div_usun" style="display:none">			
							<p>Usunięcie dnia roboczego skutkuje usunięciem wszystkich zarezerwowanych wcześniej wizyt, przed usunięciem skontaktuj się telefonicznie z pacjentami z poniższej listy.</p>
							<p>Usunięcia dnia roboczego nie można cofnąć!</p>
							<button class="btn btn-primary" id="button_alert_usun">Usuń dzień</button>
					</div>
					<div class="alert alert-warning" role="alert" id="alert_usun" style="display:none">
						<form id="form_usun" action="../dzienControler/delete" method="post" >
							<p>Czy na pewno chcesz to zrobić? </p>
							<button class="btn btn-warning" type="submit" name="submit_usun" id="submit_usun">Usuń</button>
						</form>
					</div>
					
				</div>
			</div>	
		</div>
		
		<div style="text-align:center;margin-top:30px; margin-left:10%; margin-right:10%; width:80%;">
			<div>
				<?php 
				if($dzien->getData()>date("Y-m-d")){
					echo '<p>Przewidziane wizyty:</p>';
					
					echo '';
					
					if(count($wizyty_wszystkie)==0){
					echo '<p> Brak przewidzianych wizyt na ten dzień </p>';	
					}else{
						$j=0; //index uzytkownikow do href
						$k=0; // index niezarejestrowanych
					for($i=0;$i<count($wizyty_wszystkie);$i++){
						if($wizyty_wszystkie[$i]['wizyta_id_uzytkownik'] != '0'){
							echo '<div>';
							echo '<table class="table" border="1">';
								echo '<tr >';
									echo '<td style="width:150px;"><p>Godzina:</p></td>
											<td><p>'.$godziny_wszystkie[$wizyty_wszystkie[$i]['wizyta_id_godzina']-1]['godzina'].'</p></td>';
								echo '</tr>
										<tr>';
									echo '<td style="width:150px;"><p>Pacjent:</td>
											<td><a href="'.base_url("uzytkownik/".$uzytkownicy[$j]['id']).'">
										'.$uzytkownicy[$j]['imie'].' '.$uzytkownicy[$j]['nazwisko'].
									'</a></td>';							
								echo '</tr>
										<tr>';
									echo '<td style="width:150px;"><p>Telefon:</p></td>
											<td><p>'.$uzytkownicy[$j]['telefon'].'</p></td>';
								
								echo '</tr>';
							echo '</table></div>';
							echo '<div>';
								echo '<div class="wiecej" id="wizyta'.$wizyty_wszystkie[$i]['id_wizyta'].'"><p class="btn btn-default">więcej<p></div>';	
							echo '<div class="well" style="display:none" id="'.$wizyty_wszystkie[$i]['id_wizyta'].'">';
								echo '<table>';
								echo '<tr>';
								echo '<td>';
								echo '<a class="btn btn-primary" href="'.base_url("korespondencja/".$wizyty_zarejestrowani[$j]['id_wizyta']).'">Korespondencja</a>';
								echo '</td><td>';
								echo '
									<form method="post" action="../wizytaControler/delete/'.$wizyty_wszystkie[$i]['id_wizyta'].'">
										<button class="btn btn-primary" type="submit" name="button_usun" id="button_usun">Usuń wizytę</button>
										<input type="hidden" name="id_wizyta" value="'.$wizyty_wszystkie[$i]['id_wizyta'].'" />
										<input type="hidden" name="id_dzien" value="'.$this->uri->segment(2).'" />
									</form>';
								echo '</td><td>';
								echo '
									<form method="post" action="../przeniesWizyte/'.$wizyty_wszystkie[$i]['id_wizyta'].'/'.date("Y").'/'.date("m").'">
										<button class="btn btn-primary" type="submit" name="button_przesun" id="button_przesun">Przesuń wizytę</button>
										<input type="hidden" name="id_wizyta" value="'.$wizyty_wszystkie[$i]['id_wizyta'].'" />
										<input type="hidden" name="id_dzien" value="'.$this->uri->segment(3).'" />
									</form>';
								echo '</td>';
								echo '</table></div><br/>';
									
							$j++;
						}else{
							echo '<div><table class="table" border="1">';
							echo '<tr>';
							echo '<td style="width:150px;"><p>Godzina: </p></td><td><p>'.$godziny_wszystkie[$wizyty_wszystkie[$i]['wizyta_id_godzina']-1]['godzina'].'</p></td>';
							echo '</tr>
								  <tr>';
							for($tmp=0;$tmp<count($wizyty_wszystkie);$tmp++){
								if($opis_niezarejestrowani[$k]['wiadomosc_id_wizyta'] == $wizyty_wszystkie[$tmp]['id_wizyta']){
								echo '<td colspan="2"><p>'.nl2br($opis_niezarejestrowani[$k]['tekst']).'</p></td>';  
								break;
								}
							} 				
							echo '</tr></table ></div>';
							echo '<div>';
								echo '<div class="wiecej" id="wizyta'.$wizyty_wszystkie[$i]['id_wizyta'].'"><p class="btn btn-default">więcej</p></div></br>';	
							echo '<div class="well" style="display:none" id="'.$wizyty_wszystkie[$i]['id_wizyta'].'">';
								echo '<table>';
								echo '<tr>';
								echo '<td>';
								echo '
									<form method="post" action="../wizytaControler/delete/'.$wizyty_wszystkie[$i]['id_wizyta'].'">
										<button class="btn btn-primary" type="submit" name="button_usun" id="button_usun">Usuń wizytę</button>
										<input type="hidden" name="id_wizyta" value="'.$wizyty_wszystkie[$i]['id_wizyta'].'" />
										<input type="hidden" name="id_dzien" value="'.$this->uri->segment(2).'" />
									</form>';
								echo '</td><td>';
								echo '
									<form method="post" action="../przeniesWizyte/'.$wizyty_wszystkie[$i]['id_wizyta'].'/'.date("Y").'/'.date("m").'">
										<button class="btn btn-primary" type="submit" name="button_przesun" id="button_przesun">Przesuń wizytę</button>
										<input type="hidden" name="id_wizyta" value="'.$wizyty_wszystkie[$i]['id_wizyta'].'" />
										<input type="hidden" name="id_dzien" value="'.$this->uri->segment(3).'" />
									</form>';
								echo '</td>';
								echo '</table></div><br/>';
							$k++;
						}
					}
				}
				}
				else{
					echo 'Wizyty które się odbyły:';
					
					if(count($wizyty_wszystkie)==0){
					echo '<p>Brak wizyt w tym dniu</p>';	
					}else{
						$j=0; //index uzytkownikow do href
						$k=0; // index niezarejestrowanych
					for($i=0;$i<count($wizyty_wszystkie);$i++){
						if($wizyty_wszystkie[$i]['wizyta_id_uzytkownik'] != '0'){
							echo '<div>';
							echo '<table class="table" border="1">';
								echo '<tr>';
									echo '<td style="width:150px;"><p>Godzina:</p></td>
											<td><p>'.$godziny_wszystkie[$wizyty_wszystkie[$i]['wizyta_id_godzina']-1]['godzina'].'</p></td>';
								echo '</tr>
										<tr>';
									echo '<td style="width:150px;"><p>Pacjent:</td>
											<td><a href="'.base_url("uzytkownikControler/user/".$uzytkownicy[$j]['id']).'">
										'.$uzytkownicy[$j]['imie'].' '.$uzytkownicy[$j]['nazwisko'].
									'</a></td>';							
								echo '</tr>
										<tr>';
									echo '<td style="width:150px;"><p>Telefon:</p></td>
											<td><p>'.$uzytkownicy[$j]['telefon'].'</p></td>';
								
								echo '</tr>';
							echo '</table></div>';
							echo '<div>';
								echo '<p class="wiecej" id="wizyta'.$wizyty_wszystkie[$i]['id_wizyta'].'"><button class="btn btn-default">więcej</button></p>';	
							echo '<div class="well well-sm" style="display:none" id="'.$wizyty_wszystkie[$i]['id_wizyta'].'">';
								echo '<table>';
								echo '<tr>';
								echo '<td>';
								echo '<a class="btn btn-primary" href="'.base_url("wiadomoscControler/korespondencja/".$wizyty_zarejestrowani[$j]['id_wizyta']).'">Korespondencja</a>';
								echo '</td>';
								echo '</table></div><br/>';
									
							$j++;
						}else{
							echo '<div><table class="table" border="1">';
							echo '<tr>';
							echo '<td style="width:150px;"><p>Godzina: </p></td><td><p>'.$godziny_wszystkie[$wizyty_wszystkie[$i]['wizyta_id_godzina']-1]['godzina'].'</p></td>';
							echo '</tr>
								  <tr>';
							for($tmp=0;$tmp<count($wizyty_wszystkie);$tmp++){
								if($opis_niezarejestrowani[$k]['wiadomosc_id_wizyta'] == $wizyty_wszystkie[$tmp]['id_wizyta']){
								echo '<td colspan="2"><p>'.nl2br($opis_niezarejestrowani[$k]['tekst']).'</p></td>';  
								break;
								}
							} 	
							echo '</tr></table></div>';
							$k++;
						}
					}
				}
				}
				
				?>
			</div>
		</div>
	</div>
	</div>
	
</article>