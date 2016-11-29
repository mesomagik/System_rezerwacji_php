<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	<script>
		$(document).ready(function(){
			$("#dodaj_wiadomosc").click(function(){
				if($("#wiadomosc").val().length<200 && $("#wiadomosc").val().length>10){
					$("#form_dodaj").append('<input type="hidden" name="id_wizyta" value="<?php echo $this->uri->segment(2); ?>" />');
					$('#form_dodaj').append('<input type="hidden" name="daneZgodne" value="1" />');	
				}
				else{
					alert("Zbyt długa lub krótka wiadomość - podaj 10-200 znaków");
					$('#form_dodaj').append('<input type="hidden" name="daneZgodne" value="0" />');	
					return false;
				}
			});
			$("tr").click(function(){
				$(this).find("#div_usun").toggle();	
			});
			$("#usun_wiadomosc").click(function(){
				location.reload();
			});
		});
	</script>

	<div style="margin-left:10%; margin-right:10%; width:80%;">
		<div>
			<table class="table">
				<tr><td>
					<?php echo '<b style="float:left"><a href="'.base_url('uzytkownik/'.$user['id']).'">'.$user['imie'].' '.$user['nazwisko'].'</a></b>
								<b style="float:right"><a href="'.base_url('szczegolyDnia/'.$dzien['id_dzien']).'">powrót do szczegółów dnia</a></b> ' ;?>
				</td></tr>
				<tr><td>
					<?php echo '<b style="float:left">'.$dzien['data'].' '.substr($godzina['godzina'],0,5).'</b>' ;?>
				
				</td></tr>
			</table>
		
			<div class="panel panel-default" >
				<table class="table">
					<?php 
					for($i=0;$i<count($lista);$i++){
						if($lista[$i]->getWiadomosc_id_user() == 1){
							echo '<tr style="height:70px;" id="'.$lista[$i]->getId_wiadomosc().'">
									<td style="width:70px;"><p>admin: </p></td>
									<td>'.$lista[$i]->getTekst();
									if($i!=0)echo '	
									<div id="div_usun" style="display:none; float:right;">
										<form method="post" action="../wiadomoscControler/delete" id="form_usun"> 
											<button class="btn btn-default" type="submit" name="usun_wiadomosc" id="usun_wiadomosc">Usuń wiadomość</button>
											<input type="hidden" name="id_wiadomosc" value="'.$lista[$i]->getId_wiadomosc().'">
											<input type="hidden" name="id_wizyta" value="'.$this->uri->segment(2).'">
										</form>
									</div>';
									echo '
									</td>	
								</tr>';
						}else{
							echo '<tr style="height:70px;" id="'.$lista[$i]->getId_wiadomosc().'">
									<td style="width:70px;">użytkownik:</td>
									<td>'.$lista[$i]->getTekst();
									if($i!=0) echo '	
									<div id="div_usun" style="display:none;float:right;">
										<form method="post" action="../wiadomoscControler/delete" id="form_usun">
											<button class="btn btn-default" type="submit" id="usun_wiadomosc">Usuń wiadomość</button>
											<input type="hidden" name="id_wiadomosc" value="'.$lista[$i]->getId_wiadomosc().'">
											<input type="hidden" name="id_wizyta" value="'.$this->uri->segment(2).'">
										</form>
									</div>';
									echo '
									</td>	
								</tr>';
						}
					} 
					?>
				</table>
			</div>
		</div>
		<div>
			<form method="POST" action="../wiadomoscControler/insert" id="form_dodaj">
				<input type="text" placeholder="podaj wiadomość" name="wiadomosc" id="wiadomosc"></input>
				<button type="submit" name="dodaj_wiadomosc" id="dodaj_wiadomosc">Wyślij</button>
			</form>
		</div>
	</div>

</article>