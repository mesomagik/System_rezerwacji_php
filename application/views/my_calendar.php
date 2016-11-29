<article id="TRESC">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js">
	</script>
	
	<script>
		
	
		$(document).ready(function(){
			$(".dodajPrzycisk").click(function(){			
				$("#dodaj").show(100);
				id = $(this).find("i").text();
				$("#data_dodanie").val(id);
			});
			$("#submit_dodaj").click(function(){
				val1 = $("#dodaj_godzina_roz option:selected").val();
				if(val1<10){ val1="0"+val1};
				if(val1<$("#dodaj_godzina_zak option:selected").val()){
						$('#form_dodaj').append('<input type="hidden" name="godzinaZgodna" value="1" />');
						
					}else{
						alert("Podano niepoprawny czas pracy");
						$('#form_dodaj').append('<input type="hidden" name="godzinaZgodna" value="0" />');			
						return false;
					}
					$('#form_dodaj').append('<input type="hidden" name="year" value="<?php echo $this->uri->segment(2);?>" />');
					$('#form_dodaj').append('<input type="hidden" name="month" value="<?php echo $this->uri->segment(3);?>" />');
					
			});
		});
		
	</script>
	<div style="width:1200px; ">
		<div id="dodaj" style="display:none">
		<h>Dodaj dzień<h>
		<div style="height:100%;margin-bottom:30px;">
			<form role="form" method="POST" action="../../dzienControler/insert_form" id="form_dodaj">
				<div class="form-group">
					<label for="godzina_roz">Godzina rozpoczęcia:</label>
					<select name="dodaj_godzina_roz" id="dodaj_godzina_roz">
						<?php foreach($godziny as $row): ?>					
							<option value="<?php echo $row['id_godzina']; ?>"><?php echo substr($row['godzina'],0,5); ?></option>			
						<?php endforeach; ?>
					</select>
					<label for="godzina_zak">Godzina zakończenia:</label>
					<select name="dodaj_godzina_zak" id="dodaj_godzina_zak">
						<?php foreach($godziny as $row): ?>					
							<option value="<?php echo $row['id_godzina']; ?>"><?php echo substr($row['godzina'],0,5); ?></option>			
						<?php endforeach; ?>
					</select>
					<input readonly="readonly" id="data_dodanie" name="data1"></input>
					<button type="submit" name="submit_dodaj" id="submit_dodaj">Dodaj</button>
				</div>
			</form>
		</div>
		</div>
		
		
		
		

	<?php echo $calendar; ?>
	</div>
</article>