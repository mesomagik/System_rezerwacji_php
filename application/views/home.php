<article style="background: url('../images/tlo.jpg') repeat-x scroll 0px 0px;">

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAV3YVgVV0Cx1uLW4dBsoxz5GwtKcJVqp4&callback=initMap" async defer></script>
	
<script>
      function initMap() {
        // Create a map object and specify the DOM element for display.
        var map = new google.maps.Map(document.getElementById('google_map'), {
          center: {lat: <?php echo $strona_info['mapa_x']; ?>, lng: <?php echo $strona_info['mapa_y']; ?>}, 
          scrollwheel: false,
          zoom: 17
        });
		
		 var marker = new google.maps.Marker({
          position: {lat: <?php echo $strona_info['mapa_x']; ?>, lng: <?php echo $strona_info['mapa_y']; ?>},
          map: map,
          title: '<?php echo $strona_info['opis_markera']; ?>'
        });
      }
</script>
<script>
	$(document).ready(function(){
		$("#tn_o_mnie").click(function(){
			$("#o_mnie").slideDown();
			$("#aplikacja").slideUp();
			return false;
		});
		$("#tn_aplikacja").click(function(){
			$("#o_mnie").slideUp();
			$("#aplikacja").slideDown();
			return false;
		});
	});
</script>
	

		<div class="container">
			<div id="top_home" >
				<div id="personal_image">			
				</div>
				<div id="details_container">
					<div id="details_bg">
						<div id="details_text">
							<i class="fa fa-user-md fa-2x" aria-hidden="true"> <?php echo $strona_info['imie_nazwisko']; ?></i></br></br>
							<h4><i class="fa fa-medkit" aria-hidden="true"> <?php echo $strona_info['profesja']; ?></i></h4>
							<h4><i class="fa fa-map-marker" aria-hidden="true"> <?php echo $strona_info['miejscowosc']; ?></i></h4>
						</div>
					</div>
				</div>			
			</div>
		</div>
		
	<div class="row" >
	<div class="container">
		<div class="col-xs-6 col-md-3" style="text-align:center; width:50%; float:left;">
			<a href="" class="thumbnail" id="tn_o_mnie">
				<b >O mnie</b>
			</a>
		</div>
		<div class="col-xs-6 col-md-3" style="text-align:center; width:50%; float:right;">
			<a href="" class="thumbnail" id="tn_aplikacja">
				<b >Aplikacja</b>
			</a>
		</div>
	</div>	
	</div>
	
	<div id="o_mnie">
		<div id="o_mnie_tekst" class="well">
			<div>
				<b><?php echo $strona_info['imie_nazwisko']; ?></b><br><br>
			</div>
			<div>
				<p>
				<?php echo nl2br($strona_info['opis']); ?>
				</p>
			</div>
		</div>
	</div>
	
	<div id="aplikacja" >
		<div id="o_mnie_tekst" >
			<div id="aplikacja_logo">
				<b style="margin-left:30px; ">Pobierz aplikację!</b>
				 <ul class="social">
                    <li class="facebook"><a href="<?php echo 'http://'.$strona_info['link_aplikacji']; ?>"><i class="fa fa-android fa-4x"></i></a></li>
				</ul>
			</div>
			<div id="aplikacja_opis" class="well" style="min-height:200px;">
				<?php echo nl2br($strona_info['opis_aplikacji']); ?>
				
			</div>
			
		</div>
	</div>
	
	<div id="bottom_home">
		<div id="contact">
			<div id="contact_text">
				<i class="fa fa-user-md fa-2x" aria-hidden="true"> Kontakt</i></br></br>
				<h4><i class="fa fa-medkit" aria-hidden="true"> <?php echo $strona_info['profesja']; ?></i></h4>
				<h4><i class="fa fa-map-marker" aria-hidden="true"> <?php echo $strona_info['adres_dokladny']; ?></i></h4>
				<h4><i class="fa fa-mobile" aria-hidden="true"> <?php echo $strona_info['telefon']; ?></i></h4></br>
				<h3 style="color:rgba(162,202,57,1)"><i class="fa fa-android" aria-hidden="true"> Skorzystaj z aplikacji mobilnej</i></h3>
			</div>
		</div>
		<div id="google_map">
			
    
    	</div>
	</div>
	

</article>