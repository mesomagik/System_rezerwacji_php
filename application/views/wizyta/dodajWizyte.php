<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>

	<script>
	$(document).ready(function(){
		$("#input_button").click(function(){
			
			$("#input_pesel").css({'background-color' : '#ffffff'});
			$("#input_telefon").css({'background-color' : '#ffffff'});
			$("#input_imie").css({'background-color' : '#ffffff'});
			$("#input_opis").css({'background-color' : '#ffffff'});
			
			if($.isNumeric($("#input_pesel").val()) &&
			$.isNumeric($("#input_telefon").val()) &&
			$("#input_pesel").val().length == 11  &&
			$("#input_telefon").val().length == 9  &&
			$("#input_imie").val().length > 0  &&
			$("#input_opis").val().length > 0 ){
				$("#input_form").append('<input type="hidden" name="id_dzien" value="<?php echo $dzien['id_dzien'] ?>" />');
			}else{
				$("#blad").slideDown();
					setTimeout(function(){$("#blad").slideUp()},3000);
					if(!$.isNumeric($("#input_pesel").val()) || $("#input_pesel").val().length != 11){
						$("#input_pesel").css({'background-color' : '#f7dddf'});
					}
					if(!$.isNumeric($("#input_telefon").val()) ||  $("#input_telefon").val().length != 9 ){
						$("#input_telefon").css({'background-color' : '#f7dddf'});
					}

					if(!$("#input_imie").val().length > 0 ){
						$("#input_imie").css({'background-color' : '#f7dddf'});
					}
					if(!$("#input_opis").val().length > 0 ){
						$("#input_opis").css({'background-color' : '#f7dddf'});
					}
					return false;
			}
		});

	});
	</script>
	
	<div class="container" id="form" style="margin-left:10%; margin-right:10%; width:80%;">
	
		<div class="alert alert-danger" role="alert" id="blad" style="display:none">Wypełnij poprawnie wszystkie pola</div>
		
		<h1 style="margin-bottom:30px;">Dodaj wizytę</h1>
	
			<form method="post" action="../WizytaControler/insertAnonim" id="input_form" name="input_form">
				<input style="width:100%;float:left;" type='hidden' value='0' name='input_pierwsza'></input>
				<table class="table">
				<tr>
					<td>
						<b style="float:left";><?php echo $dzien['data'] ?></b> 
					</td>
					<td>
						<select style="width:100%; float:left;" name="input_godzina" id="input_godzina">
							<?php 
								foreach($wolne_godziny as $row=>$item){
									echo '<option value="'.$item['id_godzina'].'">'.$item['godzina'].'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="input_imie">Imię i nazwisko:</label></td>
					<td><input style="width:100%;float:left;" type="text" name="input_imie" id="input_imie" placeholder="imię i nazwisko"></input></td>
				</tr>
				<tr>
					<td><label for="input_telefon">Numer telefonu:</label></td>
					<td><input style="width:100%;float:left;" type="tel" name="input_telefon" id="input_telefon" placeholder="telefon (9 cyfr)"></input></td>
				</tr>
				<tr>
					<td><label for="input_pesel">Pesel:</label></td>
					<td><input style="width:100%;float:left;" type="text" name="input_pesel" id="input_pesel" placeholder="pesel (11 cyfr)"></input></td>
				</tr>
						
				<tr>
					<td colspan="2"><textarea name="input_opis" id="input_opis" placeholder="opis pacjenta" style="height:50px ;width:99%;"></textarea></td>
				</tr>
				<tr>
					
					<td ><button class="btn btn-default" type="submit" name="input_button" id="input_button">Dodaj wizytę</button></td>
					<td><?php echo '<b style="float:right"><a href="'.base_url('szczegolyDnia/'.$this->uri->segment(2)).'">powrót do szczegółów dnia</a></b>'?></td>
				</tr>
				</table>
			</form>
	</div>
	
</article>