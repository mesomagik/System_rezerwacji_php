<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	
	<script>
		$(document).ready(function(){
			$("#usuwanie_toggle").click(function(){
				$("#usuwanie").toggle(200);
				$("#alert_usun").slideUp();
			});
			$("#button_alert_usun").click(function(){
				$("#alert_usun").slideDown();
			});
		});
	</script>
	<div class="container" style="text-align:center">
	
		<div style="text-align:center">			
			<div >
						<form style="display:inline;" method="POST" action="../uzytkownik/<?php echo $uzytkownik->getId(); ?>">
							<?php 
							if($uzytkownik->getAktywne() == '0') 
								echo '<button class="btn btn-primary" type="submit" name="aktywuj" id="aktywj">Aktywuj konto</button>
										<input type="hidden" name="aktywne" value="1" />'; 
								else echo '<button class="btn btn-primary" type="submit" name="aktywuj" id="aktywj">Dezaktywuj konto</button>
											<input type="hidden" name="aktywne" value="0" />';							
							?>				
						</form>
					
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Opcje <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu">
						<li><a href="<?php echo base_url('ustalWizyte/'.$uzytkownik->getId().'/'.date('Y').'/'.date('m')); ?>">Dodaj wizytę</a></li>
						<li role="separator" class="divider"></li>
						<li><a id="usuwanie_toggle" >Usuwanie konta</a></li>
					  </ul>
					</div></br><br>
					
				</div>
			<div class="row" style="text-align:center">
				<div class="well well-sm" id="usuwanie" style="display:none">
					<p>Usunięcie konta jest permanentne, odzystanie informacji na jego temat będzie niemożliwe!</p>
						<button class="btn btn-primary"  name="button_alert_usun" id="button_alert_usun">Usuń konto</button>
				</div>
				<div class="alert alert-warning" role="alert" id="alert_usun" style="display:none">
						<form form method="POST" action="" >
							<p>Czy na pewno chcesz to zrobić? </p>
							<button class="btn btn-warning" type="submit" name="usun" id="usun">Usuń</button>
						</form>
					</div>
				
			</div>
			<div style="text-align:center">
				<table class="table" border="1" style="margin-left:10%; margin-right:10%; width:80%;">
					<tr>
						<td><b>Imię i nazwisko</b></td>
						<td><?php echo $uzytkownik->getImie().' '.$uzytkownik->getNazwisko(); ?></td>
					</tr>
					<tr>
						<td><b>Email</b></td>
						<td><?php echo $uzytkownik->getEmail(); ?></td>
					</tr>
					<tr>
						<td><b>Adres</b></td>
						<td><?php echo $uzytkownik->getAdres(); ?></td>
					</tr>
					<tr>
						<td><b>Telefon</b></td>
						<td><?php echo $uzytkownik->getTelefon(); ?></td>
					</tr>
					<tr>
						<td><b>Pesel</b></td>
						<td><?php echo $uzytkownik->getPesel(); ?></td>	
					</tr>
					<tr>
						<td><b>Aktywne</b></td>
						<td><?php if($uzytkownik->getAktywne() == '1') echo 'Tak'; else echo 'nie'; ?></td>
					</tr>
				</table>
			</div>
		</div>
	
		<div  style="text-align:center">
			
			<table class="table" border="1" style="margin-left:10%; margin-right:10%; width:80%;">
				<th><p>Ostatnie wizyty</p></th>
				<?php 
				for($i=0; $i<count($wizyty); $i++){
					if($i%2==1){
						$kolor = 'style="background-color:f2f2f2"'; 
					}else{
						$kolor = 'style="background-color:ff0000"'; 
					} 
					echo 
					'<tr>
						<td >
							<div><p style="display: inline"> Wizyta: </p><a style="display: inline" href="'.base_url("szczegolyDnia/".$dni[$i]['id_dzien']).'">'.$dni[$i]['data'].' - '.$godziny[$wizyty[$i]['wizyta_id_godzina']]['godzina'].'</a></div>
							<div><p style="display: inline">Zobacz </p><a style="display: inline" href="'.base_url("korespondencja/".$wizyty[$i]['id_wizyta']).'">korespondencję wizyty</a></div>
						</td>
					</tr>';								
					
				}
			?>
			</table>
		</div>

	</div>
	
</article>