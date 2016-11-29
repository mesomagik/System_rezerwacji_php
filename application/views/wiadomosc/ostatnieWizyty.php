<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	<script>
		$(document).ready(function(){
			$("#dodaj_wiadomosc").click(function(){
				if($("#wiadomosc").val().length<200 && $("#wiadomosc").val().length>10){
					$("#form_dodaj").append('<input type="hidden" name="id_wizyta" value="<?php echo $this->uri->segment(3); ?>" />');
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

	<div>
		<div>

			<div>
				<table>
					<?php 
					for($i=0;$i<count($lista);$i++){
						if($lista[$i]->getWiadomosc_id_user() == 1){
							echo '<tr id="'.$lista[$i]->getId_wiadomosc().'">
									<td><p>admin: </p></td>
									<td>'.$lista[$i]->getTekst().'</td>		
									<td id="div_usun" style="display:none">
										<form method="post" action="../../wiadomoscControler/delete" id="form_usun"> 
											<button type="submit" name="usun_wiadomosc" id="usun_wiadomosc">Usuń wiadomość</button>
											<input type="hidden" name="id_wiadomosc" value="'.$lista[$i]->getId_wiadomosc().'">
											<input type="hidden" name="id_wizyta" value="'.$this->uri->segment(3).'">
										</form>
									</td>
								</tr>';
						}else{
							echo '<tr id="'.$lista[$i]->getId_wiadomosc().'">
									<td></td>
									<td>'.$lista[$i]->getTekst().'</td>		
									<td id="div_usun" style="display:none">
										<form method="post" action="../../wiadomoscControler/delete" id="form_usun">
											<button type="submit" id="usun_wiadomosc">Usuń wiadomość</button>
											<input type="hidden" name="id_wiadomosc" value="'.$lista[$i]->getId_wiadomosc().'">
											<input type="hidden" name="id_wizyta" value="'.$this->uri->segment(3).'">
										</form>
									</td>
								</tr>';
						}
					} 
					?>
				</table>
			</div>
		</div>
		<div>
			<form method="POST" action="../../wiadomoscControler/insert" id="form_dodaj">
				<input type="text" placeholder="podaj wiadomość" name="wiadomosc" id="wiadomosc"></input>
				<button type="submit" name="dodaj_wiadomosc" id="dodaj_wiadomosc">Wyślij</button>
			</form>
		</div>
	</div>

</article>