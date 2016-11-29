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
				<h1>Najnowsi pacjenci</h1>
			</div>
		</div>
	
		<div class="row">
			<div class="col-lg-7">
				<ul class="pagination">
					<?php 
					  if($strona>'1'){
						  echo ' <li ><a href="'.base_url("pacjenci/") .'/'. ($strona-1) .'" aria-label="Previosu"> ';
					  }else{
						  echo ' <li class="disabled">';
					  }
					  ?>
						<span aria-hidden="true">&laquo;</span>
					  </a>
					</li>
					<?php 
					for($i=1; $i<(count($uzytkownicy)/$ilosc)+1;$i++){
						echo '<li><a href="'.base_url("pacjenci/").'/'. $i .'">'. $i .'</a></li>';
					}
					?>
					
					  
					  <?php 
					  if($strona<(count($uzytkownicy)/$ilosc)){
						  echo ' <li ><a href="'.base_url("pacjenci/") .'/'. ($strona+1) .'" aria-label="Next"> ';
					  }else{
						  echo ' <li class="disabled">';
					  }
					  ?>
					
						<span aria-hidden="true">&raquo;</span>
					  </a>
					</li>
				</ul>
			</div>
			<div class="col-lg-4">
				<div style="display:none; height:48px;;" class="alert alert-danger" role="alert" id="brak_kryteriow"><b>Brak kryteriów wyszukiwania</b></div>
			</div></br>
			
		</div>
		
		<div class="row">
			<div class="col-lg-6">
			 <div class="input-group">
				<table class="table" border="1" >
					<th><p>Nazwisko i imię</p></th>
					<th><p>Aktywne</p></th>
					<th></th>
				<?php  
				for($k=0, $i=($strona-1)*$ilosc;$i<count($uzytkownicy); $i++, $k++) {
					if($k<$ilosc){
						echo'<tr> ';
						echo'	<td style="width:200px;">'.$uzytkownicy[$i]->getNazwisko().' '.$uzytkownicy[$i]->getImie().' </td> ';		
						echo'	<td style="width:100px;">';
						if($uzytkownicy[$i]->getAktywne() == '1') echo 'Tak'; else echo 'nie'; 
						echo'	</td>';
						echo'	<td style="width:145px;"> ';
						echo'		<form style="display:inline" method="POST" action="./uzytkownik/'.$uzytkownicy[$i]->getId() .'"> ';
						echo'			<button class="btn btn-default" name="szczegoly" id="szczegoly" style="display:inline; width:135px;">Zobacz szczegóły</button> ';
						echo'		</form> ';
						echo'		<form style="display:inline" method="POST" action="pacjenci"> ';
						if($uzytkownicy[$i]->getAktywne() == '0')
						echo'			<button class="btn btn-primary" type="submit" name="aktywuj" id="aktywj" style="display:inline; width:135px;">Aktywuj konto</button> ';
						echo'			<input type="hidden" name="aktywne" value="1" /> ';
						echo'			<input type="hidden" name="id" value="'.$uzytkownicy[$i]->getId().'" />';
						echo'		</form> ';
						echo'	</td> ';
						echo'</tr> ';
					}
				}
				?>
				</table>
				</div>
			</div>
			
			<div class="col-lg-5">
			 <div class="input-group">
			 
			 
				
				<form method="POST" action="<?php echo base_url('uzytkownikControler/wyszukaj'); ?>">
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