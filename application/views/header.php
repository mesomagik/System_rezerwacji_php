
<header>
<?php if(!isset($_SESSION)) { session_start(); } ?>
	<nav class="navbar navbar-default">
	
    <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url(''); ?>">Strona główna</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse" style="background:rgba(255,255,255,0.6);">
 
		  <?php if( !empty($_SESSION['admin']) && $_SESSION['admin'] == '1'){
			  echo '
			  <ul class="nav navbar-nav">
			  <li class="dropdown">
			  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Panel administracyjny<span class="caret"></span></a>
				<ul class="dropdown-menu">
					<li><a href="'.base_url('kalendarz/'.date("Y").'/'.date("m")).'"><span class="glyphicon glyphicon-th" aria-hidden="true"></span> Twój kalendarz</a></li>	
					<li><a href="'.base_url('wyszukaj').'"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Dodaj wizytę zarejestrowanego pacjenta</a></li>
					<li><a href="'.base_url('ostatnieWiadomosci').'"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Ostatnie wiadomości</a></li>
					<li><a href="'.base_url('pacjenci').'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Nowi pacjenci</a></li>		
					<li><a href="'.base_url('wyszukaj').'"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Znajdź pacjenta</a></li>	
					<li><a href="'.base_url('edycjaStrony').'"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Edytuj stronę domową</a></li>	
				</ul>
			</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="'.base_url('UzytkownikControler/logout').'">Wyloguj się</a></li>
			</ul>
			';
			
		  }else{
			  echo '
			  
			  <ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown"><b>Zaloguj się</b> <span class="caret"></span></a>
			<ul id="login-dp" class="dropdown-menu">
				<li>
					 <div class="row">
						<div class="col-md-12">';
						
						//if($this->session->flashdata('error')=='error'){ echo '<div class="alert alert-danger" role="alert">Niepoprawne dane</div>';}
						
						 echo '<form class="form" role="form" method="post" action="../UzytkownikControler/login" id="login-nav">
									<div class="form-group">
										 <label class="sr-only" for="email">Email</label>
										 <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
									</div>
									<div class="form-group">
										 <label class="sr-only" for="haslo">Hasło</label>
										 <input type="password" class="form-control" id="haslo" name="haslo" placeholder="Hasło" required>
									</div>
									<div class="form-group">
										 <button type="submit" class="btn btn-primary btn-block">Zaloguj</button>
									</div>
							</form>
						</div>
					 </div>
				</li>
			</ul>
        </li>
			  ';
		  }
			?>
         
		  
		  		  
    </div><!--/.nav-collapse -->
	</div>
	</nav>
	<div id="logo">
	
	</div>
 </header>
