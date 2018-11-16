<?php	
	echo '<div class="navbar-wrapper">';
	echo '	<div class="navbar navbar-inverse navbar-fixed-top">';
	echo '		<div class="navbar-inner">';
	echo '			<div class="container">';
	echo '				<!-- Responsive navbar -->';
	echo '				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></a>';
	echo '				<h1 class="brand"><a href="index.php"><br><br>CABINET OFTALMOLOGIE</a></h1>';
	echo '				<!-- navigation -->';
	echo '				<nav class="pull-right nav-collapse collapse">';
	echo '					<ul id="menu-main" class="nav">';
	echo '						<li><a title="team" href="index.php#about">Despre</a></li>';
	if(!(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y")) {
	echo '						<li><a title="services" href="index.php#services">Servicii</a></li>';
	//echo '						<li><a title="works" href="index.php#works">Clienți</a></li>';
	echo '						<li><a title="blog" href="index.php#blog">Tehnologie</a></li>';
	echo '						<li><a title="contact" href="index.php#contact">Contact</a></li>';
	}
	if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y") {
			echo '              <li><a id="meniumesaje" title="mesaje" href="afisaremesaje.php">Mesaje</a></li>';		//pentru admin am o pagina diferita pentru afisarea pacientilor
        }				 
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		echo '					<li><a id="meniuprogramari" title="programari" href="programari.php">Programari</a></li>';
		if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y") {
			echo '              <li><a id="meniupacienti" title="pacienti" href="pacienti.php">Pacienți</a></li>';		//pentru admin am o pagina diferita pentru afisarea pacientilor
        }				 
	}	
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){	
		if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y") {
			echo '					<li><a id="meniuprofil" style="text-transform:none">Salut ' . $_SESSION["username"] . '!</a></li>';		
		}
		else {
			echo '					<li><a id="meniuprofil" href="profil.php" style="text-transform:none">Salut ' . $_SESSION["username"] . '!</a></li>';		
		}
	}
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		echo '					<li><button type= "button" onclick="location.href=\'logout.php\';" class="btn btn-danger btn-rounded pull-left">DECONECTARE</button></li>';
	} else {
		echo '					<li><button type= "button" onclick="afiseazaDivFormLogin()"  class="btn btn-theme btn-rounded pull-left">CONECTARE</button></li>';		
	}	
	echo '						<span>&nbsp;</span>';
	echo '					</ul>';		
	echo '				</nav>';
	echo '			</div>';	
	echo '		</div>';	
	echo '	</div>';	
	echo '</div>';
?>