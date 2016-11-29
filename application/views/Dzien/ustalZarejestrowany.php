<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	
	<script>
		$(document).ready(function(){
			$(".dodaj").click(function(){
				$("#dodaj").show(500);
				id = $(this).find("i").text();
				$("#data_dodanie").val(id);
				
				var phpOptions = <?php echo json_encode($godziny_do_wyboru) ?>;
		
				$('#przenies_godzina').empty();
				id_dzien = $(this).find("i").attr("id").replace("dzien","");	
				
				var optionsAsString = "";
				for(var i = 0; i < phpOptions[id_dzien].length; i++) {
					optionsAsString += "<option value='" + phpOptions[id_dzien][i]["id_godzina"] + "'>" + phpOptions[id_dzien][i]["godzina"] + "</option>";
				}
				$( 'select[name="przenies_godzina"]' ).append( optionsAsString );
			});
			$("#submit_edytuj").click(function(){		
					
				$('#form_dodaj').append('<input type="hidden" name="year" value="<?php echo $this->uri->segment(3);?>" />');
				$('#form_dodaj').append('<input type="hidden" name="month" value="<?php echo $this->uri->segment(4);?>" />');
				$('#form_dodaj').append('<input type="hidden" name="id_user" value="<?php echo $this->uri->segment(2);?>" />');
				
			});
		});
		
	</script>
		<div id="dodaj" style="display:none">
		<h1>Dodaj wizytę dla użytkownika</h1>
			<form method="POST" action="../../../wizytaControler/insertZarejestrowany" id="form_dodaj">
					<label for="godzina_roz">Godzina wizyty: </label>
					<select name="przenies_godzina" id="przenies_godzina">
					</select>
				<input readonly="readonly" id="data_dodanie" name="data1"></input>
				<button type="submit" name="submit_edytuj" id="submit_edytuj">Dodaj</button>
			</form>
		</div>
		
		

	<?php echo $calendar; ?>
</article>