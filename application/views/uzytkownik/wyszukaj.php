<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	
	<script>
		$(document).ready(function(){
			$("#wyszukaj").click(function(){
				if($("#imie").val().length==0 &&
					$("#nazwisko").val().length==0 &&
					$("#pesel").val().length==0 &&
					$("#telefon").val().length==0 &&
					$("#adres").val().length==0 ){
						$("#brak_kryteriow").slideDown();
						setTimeout(function(){$("#brak_kryteriow").slideUp()},3000);
						return false;
						
					}
			});
		});
	</script>
	
	<div class="container" style="margin-left:10%; margin-right:10%; width:80%;">
		<div class="row">
			<div class="col-lg-7">
				<h1>Wyniki wyszukiwania</h1>
			</div>
			<div class="col-lg-4">
				<div style="display:none; height:48px;" class="alert alert-danger" role="alert" id="brak_kryteriow"><b>Brak kryteriów wyszukiwania</b></div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-7">
			 <div class="input-group">
				
				<?php  
				
				if($pierwsze_wyszukiwanie == 1){
					echo '<div class="well">Podaj kryteria wyszukiwania</div>';
				}else if($pierwsze_wyszukiwanie==0 && count($uzytkownicy)>0){
					echo '<table class="table" border="1" >
									<th><p>nazwisko i imię</p></th>
									<th><p>Pesel</p></th>
									<th><p>Aktywne</p></th>									
									<th></th>';
					for($i=0;$i<count($uzytkownicy); $i++) {
							
						echo'<tr> ';
						echo'	<td style="width:200px;">'.$uzytkownicy[$i]->getNazwisko().' '.$uzytkownicy[$i]->getImie().' </td> ';	
						echo'	<td style="width:200px;">'.$uzytkownicy[$i]->getPesel().' </td> ';						
						echo'	<td style="width:100px;">';
						if($uzytkownicy[$i]->getAktywne() == '1') echo 'Tak'; else echo 'nie'; 
						echo'	</td>';
						echo'	<td style="width:170px;"> ';
						echo'		<form style="display:inline" method="POST" action="uzytkownik/'.$uzytkownicy[$i]->getId() .'"> ';
						echo'			<button class="btn btn-default" name="szczegoly" id="szczegoly" style="display:inline">Zobacz szczegóły</button> ';
						echo'		</form> ';
						echo'</tr> ';							
					}
						echo'</table>';	
				}else if(count($uzytkownicy)==0){
					echo '<div class="well">Brak wyników wyszukiwania</div>';
				}
				?>
				
				</div>
			</div>
			
			<div class="col-lg-5">
			 <div class="input-group">
			 
			 
				
				<form method="POST" id="form_wyszukaj" action="<?php echo base_url('wyszukaj'); ?>" >
					<table class="table"  border="1">
						<th colspan="2">Wyszukaj</th>
						<tr>				
							<td><label for="imie" ><span class="label label-primary" style="display:block; width: 80px; height:100%;">imię</span></label></td>
							<td><input name="imie" id="imie" style="width:100%" type="text" placeholder="imię" value="<?php if(isset($wyniki['imie'])) echo $wyniki['imie']; ?>" /></td>
						</tr>
						<tr>
							<td><label for="nazwisko"><span style="display:block; width: 80px; height:100%;" class="label label-primary">nazwisko</span></label></td>
							<td><input name="nazwisko" id="nazwisko" style="width:100%" type="text" placeholder="nazwisko" value="<?php if(isset($wyniki['nazwisko'])) echo $wyniki['nazwisko']; ?>" /></td>
						</tr>
						<tr>
							<td><label for="pesel"><span style="display:block; width: 80px; height:100%;" class="label label-primary">pesel</span></label></td>
							<td><input name="pesel" id="pesel" style="width:100%" type="number" placeholder="pesel" oninput="if(value.length>11)value=value.slice(0,11)" value="<?php if(isset($wyniki['pesel'])) echo $wyniki['pesel']; ?>"/></td>
						</tr>
						<tr>
							<td><label for="telefon"><span style="display:block; width: 80px; height:100%;" class="label label-primary">telefon</span></label></td>
							<td><input name="telefon" id="telefon" style="width:100%" type="number" oninput="if(value.length>9)value=value.slice(0,9)" placeholder="telefon" value="<?php if(isset($wyniki['telefon'])) echo $wyniki['telefon']; ?>"/></td>
						</tr>
						<tr>
							<td><label for="adres"><span style="display:block; width: 80px; height:100%;" class="label label-primary">adres</span></label></td>
							<td><input name="adres" id="adres" style="width:100%" type="text" placeholder="adres" value="<?php if(isset($wyniki['adres'])) echo $wyniki['adres']; ?>"/></td>
						</tr>
						<tr>
							<td><label for="nieaktywne_szukaj"><span style="display:block; width: 80px; height:100%;" class="label label-primary">nieaktywne</span></label></td>
							
							<td> 
								<input type='hidden' value='0' name='nieaktywne_szukaj' id="nieaktywne_szukaj"></input>
								<input style="display:inline;" name="nieaktywne_szukaj" id="nieaktywne_szukaj"  type="checkbox" value='1' />
							</td>
						</tr>
						<tr>
							<td colspan="2"><button style="float:right; margin-right:20px; width:100px;" class="btn btn-default" type="submit" name="wyszukaj" id="wyszukaj" >Szukaj</button></td>
						</tr>
					</table>
				</form>
			</div>
			</div>
		</div>
	</div>
			
	
</article>