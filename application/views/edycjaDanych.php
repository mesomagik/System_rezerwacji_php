<article>

<div class="container">

	<h2>Edycja strony domowej</h2>
	
	<table class="table">
	<form method="POST" action="" name="daneStrona">
	<tr>
		<td>
			Imię i nazwisko
		</td>
		<td>
			<input type="text" name="imie_nazwisko" value="<?php echo $strona_info['imie_nazwisko']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Profesja
		</td>
		<td>
			<input type="text" name="profesja" value="<?php echo $strona_info['profesja']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Miejscowość pracy
		</td>
		<td>
			<input type="text" name="miejscowosc" value="<?php echo $strona_info['miejscowosc']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Telefon
		</td>
		<td>
			<input type="text" name="telefon" value="<?php echo $strona_info['telefon']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Adres dokładny
		</td>
		<td>
			<input type="text" name="adres_dokladny" value="<?php echo $strona_info['adres_dokladny']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Opis lekarza
		</td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="opis" id="opis"  style="height:150px ;width:99%;"><?php echo $strona_info['opis']; ?></textarea></td>
	</tr>
	<tr>
		<td>
			Aby wyznaczyć współrzędne wejdź na podaną stronę.
		</td>
		<td>
			<a target="_blank" href="http://gmapsapi.com/wspolrzedne.php">Klik!</a>
		</td>
	</tr>
	<tr>
		<td>
			B
		</td>
		<td>
			<input type="number" name="mapa_y" value="<?php echo $strona_info['mapa_y']; ?>" step="0.0000001">
		</td>
	</tr>
	<tr>
		<td>
			L
		</td>
		<td>
			<input type="number" name="mapa_x" value="<?php echo $strona_info['mapa_x']; ?>" step="0.0000001">
		</td>
	</tr>
	<tr>
		<td>
			Opis markera na mapie
		</td>
		<td>
			<input type="text" name="opis_markera" value="<?php echo $strona_info['opis_markera']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			Opis aplikacji
		</td>
	</tr>
	<tr>
		<td colspan="2"><textarea name="opis_aplikacji" id="opis_aplikacji"  style="height:150px ;width:99%;"><?php echo $strona_info['opis_aplikacji']; ?></textarea></td>
	</tr>
	<tr>
		<td>
			Link do aplikacji
		</td>
		<td>
			<input type="text" name="link_aplikacji" value="<?php echo $strona_info['link_aplikacji']; ?>">
		</td>
	</tr>
	<tr>
		<td>
			<button class="btn btn-default" type="submit" name="input_button" id="input_button">Zapisz</button>
		</td>
	</tr>
	</form>
	</table>
</div>
	

</article>