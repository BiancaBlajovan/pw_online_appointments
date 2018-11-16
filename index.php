<?php
// Initialize the session

session_start();

require_once ("connectdb.php");
	
$_SESSION["lastpage"]="../index.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST["submitauth"])) {
		
		// Check if username is empty
		if(empty(trim($_POST["username"]))){ 
			$username_err = "Introdu numele de ultilizator.";
		} else{
			$username = trim($_POST["username"]);
		}
	 
		// Check if password is empty
		if(empty(trim($_POST["password"]))){
			$password_err = "Introdu parola.";
		} else{
			$password = trim($_POST["password"]);
		}
		
		// Validate credentials

		if(empty($username_err) && empty($password_err)){

			$link = connectToDB();

			// Prepare a select statement
			$sql = "SELECT id, username, password, idpac, itsadmin FROM utilizatori WHERE username = ?";		
			
			if($stmt = mysqli_prepare($link, $sql)){

				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				
				// Set parameters
				$param_username = $username;
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){

					// Store result
					mysqli_stmt_store_result($stmt);
					
					// Check if username exists, if yes then verify password
					if(mysqli_stmt_num_rows($stmt) == 1){                    
					
						// Bind result variables
						mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password,$idpac,$itsadmin);
						
						if(mysqli_stmt_fetch($stmt)){
							
							if(password_verify($password, $hashed_password)){
								// Password is correct, so store data in session variables
								$_SESSION["loggedin"] = true;
								$_SESSION["id"] = $id;
								$_SESSION["username"] = $username;      
								$_SESSION["idpac"]=$idpac;
								$_SESSION["itsadmin"]=$itsadmin;
							} else{
								// Display an error message if password is not valid
								$password_err = "The password you entered was not valid.";
							}
						}
					} else{
						// Display an error message if username doesn't exist
						$username_err = "No account found with that username.";
					}
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}
				
				// Close statement
				mysqli_stmt_close($stmt);
			}
			
			// Close connection
			mysqli_close($link);		
		}
	}
}
?>


<!DOCTYPE HTML>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Cabinet Oftalmologie</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<link href="css/bootstrap-responsive.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">	
	<link rel="stylesheet" type="text/css" href="css/login.css" >
	<link href="color/default.css" rel="stylesheet">
	<link rel="shortcut icon" href="img/favicon.ico">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>	
</head>

<body>
	<!-- navbar -->
	<?php include 'navbar.php';?>
	
	<!--pop up sign up-->
	
<div id="id_form_login" class="<?php if ((!empty($username_err))||(!empty($password_err))) echo("loginmodal loginmodal-visible"); else echo("loginmodal loginmodal-hidden"); ?>">

  <form class="loginmodal-content" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
 
    <div class="imgcontainer">
      <span onclick="ascundeDivFormLogin()" class="closelogin" title="Inchide conectarea">&times;</span>
      <img src="person-icon.png" style="height:200px;width:200px"  alt="Avatar" class="avatar">
    </div>

    <div class="containerlogin">
	
	  <div>
		  <label for="username"><font color="#00b8e6" size="4" >Nume de utilizator</font></label>   
	      <input type="text" placeholder="Introdu numele de utilizator" name="username" value="<?php echo $username; ?>" onkeydown="stergeSpanUsernameErr()" required>
		  <span id="id_span_user_err" class="help-block" style="color:red"><?php if(!empty($username_err)) echo "username gresit"; ?></span>
	  </div>
	  
	  <div>
		  <label for="password"><font color="#00b8e6" size="4">Parolă</font></label>
		  <input type="password" placeholder="Introdu parola" name="password" onkeydown="stergeSpanPasswordErr()" required>
		  <span id="id_span_pass_err" class="help-block"  style="color:red"><?php if(!empty($password_err)) echo "parola gresita"; ?></span>
      </div>
			
      <button type="submit" name="submitauth" class="btn btn-info btn-rounded">Autentificare</button>
	  
	  &nbsp;
	  
	   <p>Înca nu ai un cont? <a href="regform/index.php"><u>Înregistează-te acum</u></a>.</p>
	   
	   <button type="button" style="height:40px;width:100px" class="btn btn-info btn-rounded" onclick="ascundeDivFormLogin()" >Renunță</button>
    
    </div>

  </form>
  
</div>
			
	
	<!-- Header area -->
	<div id="header-wrapper" class="header-slider">
		<header class="clearfix">
			<div class="logo">
				<img src="img/logo-image.png"  alt="" />
			</div>
			<div class="container">
				<div class="row">
					<div class="span12">
						<div id="main-flexslider" class="flexslider">
							<ul class="slides">
								<li>
									<p class="home-slide-content">
										 Ai grija de <strong>ochii tai</strong>
									</p>
								</li>
								<li>
									<p class="home-slide-content">
										Vino la un <strong>control</strong>
									</p>
								</li>
								<li>
									<p class="home-slide-content">
										Nu ezita, <strong>programează-te</strong>
									</p>
								</li>
							</ul>
						</div>
						<!-- end slider -->
					</div>
				</div>
			</div>
		</header>
	</div>
	<!-- spacer section -->
	<section class="spacer green">
		<div class="container">
			<div class="row">
				<div class="span6 alignright flyLeft">
					<blockquote class="large">
						Cât timp a trecut de când ți-ai făcut un control oftalmologic complet? Șase luni sau poate un an întreg? Poate mai mult de atât? Poate niciodată? Vizitează chiar azi cabinetul nostru și descoperă cum să ai grijă de ochii tăi! <cite>Dr. Corina Lădariu</cite>
					</blockquote>
				</div>
				<div class="span6 aligncenter flyRight">
					<i class="icon-check icon-10x"></i>
				</div>
			</div>
		</div>
	</section>
	<!-- end spacer section -->
	<!-- section: team -->
	<section id="about" class="section">
		<div class="container">
			<h4>Despre noi</h4>
			<div class="row">
				<div class="span4 offset1">
					<div>
						<p>
							
Magazinul nostru de optica medicala este primul atelier de ochelari, lupe si binocluri din Timisoara. Istoria magazinului nostru de ochelari a continuat, pana in prezent cand putem spune ca suntem unici in Romania cu aparatura de ultima generatie pentru consultatii medicale oftalmologice, servicii complete pentru ochelari de vedere, cu sau fara dioptrii, ochelari pentru medici chirurgi cu lupe speciale.
						</p>
					</div>
				</div>
				<div class="span6">
					<div class="aligncenter">
					   <br>
						<img src="img/icons/creativity.png" alt="" />
						<br>
						<h2>Peste <strong>1200 </strong>de clienți <strong>mulțumiti</strong></h2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="span2 offset1 flyIn">
					<div class="people">
						<img class="team-thumb img-circle" src="img/team/img-1.jpg" alt="" />
					</div>
				</div>
				<div class="span2 flyIn">
					<div class="people">
						<img class="team-thumb img-circle" src="img/team/img-4.jpg" alt="" />
					</div>
				</div>
				<div class="span2 flyIn">
					<div class="people">
						<img class="team-thumb img-circle" src="img/team/img-1.jpg" alt="" />
					</div>
				</div>
				<div class="span2 flyIn">
					<div class="people">
						<img class="team-thumb img-circle" src="img/team/img-4.jpg" alt="" />
					</div>
				</div>
				<div class="span2 flyIn">
					<div class="people">
						<img class="team-thumb img-circle" src="img/team/img-1.jpg" alt="" />
					</div>
				</div>
			</div>
		</div>
		<!-- /.container -->
	</section>
	<!-- end section: team -->
	<!-- section: services -->
	<section id="services" class="section orange">
		<div class="container">
			<h4>Servicii</h4>
			<!-- Four columns -->
			<div class="row">
				<div class="span3 animated-fast flyIn">
					<div class="service-box">
						<img src="img/icons/serv1.png" alt="" />
						<h2>Diagnosticare afecțiuni oftalmologice</h2>
						<p>
							
						</p>
					</div>
				</div>
				<div class="span3 animated flyIn">
					<div class="service-box">
						<img src="img/icons/serv2.png" alt="" />
						<h2>Rafractometrie computerizată / Biomicroscopie</h2>
						<p>
							
						</p>
					</div>
				</div>
				<div class="span3 animated-fast flyIn">
					<div class="service-box">
						<img src="img/icons/serv3.png" alt="" />
						<h2>Oftalmodinamometrie/ Oftalmoscopie</h2>
						<p>
							
						</p>
					</div>
				</div>
				<div class="span3 animated-slow flyIn">
					<div class="service-box">
						<img src="img/icons/serv4.png" alt="" />
						<h2>Prescripție ochelari sau lentile de contact</h2>
						<p>
							
						</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end section: services -->
	
	<!-- spacer section -->
	<section class="spacer bg3">
		<div class="container">
			<div class="row">
				<div class="span12 aligncenter flyLeft">
					<blockquote class="large">
						Unele boli de ochi, cum ar fi glaucomul și retinopatia diabetică nu prezintă simptome în stadiile lor incipiente, astfel încât este posibil să nu știm că avem o problemă, până când boala ajunge într-un stadiu mai avansat, iar acest lucru poate face tratamentul mai dificil și problema mai greu de gestionat. De aceea, consultațiile oftalmologice regulate sunt esențiale pentru a diagnostica din timp și pentru a beneficia de tratament pentru orice problemă oculară care ar putea apărea. Depistarea precoce şi tratamentul inițiat în fază incipientă pot încetini sau chiar inversa progresia anumitor boli ale ochilor.
					</blockquote>
				</div>
				<div class="span12 aligncenter flyRight">
					<i class="icon-arrow-up icon-10x"></i>
				</div>
			</div>
		</div>
	</section>
	<!-- end spacer section -->
	<!-- section: blog -->
	<section id="blog" class="section">
		<div class="container">
			<h4>Tehnologia de care dispunem</h4>
			<!-- Three columns -->
			<div class="row">
				<div class="span3">
					<div class="home-post">
						<div class="post-image">
							<img class="max-img" src="img/blog/tivato700.jpg" alt="" />
						</div>
						<div class="post-meta">
							<i class="icon-ok-sign icon-2x"></i>
							<span class="date">Zeiss Tivato 700</span>
	
						</div>
						<div class="entry-content">
							<p>
								For demanding surgical applications in ENT, Spine and P&R look no further than ZEISS TIVATO 700*, the latest Advanced Visualization System from ZEISS. Understanding your daily workload, this fully integrated visualization system enhances usability and is built on technology ahead of its time. Join us in taking the next steps towards the future of microsurgery.
							</p>
						</div>
					</div>
				</div>
				<div class="span3">
					<div class="home-post">
						<div class="post-image">
							<img class="max-img" src="img/blog/visulasgreen.jpg" alt="" />
						</div>
						<div class="post-meta">
							<i class="icon-ok-sign icon-2x"></i>
							<span class="date">Zeiss Visual Green</span>
						</div>
						<div class="entry-content">
							<p>
								oaded with over 100 innovations, the all-new Robotic Visualization System™ – KINEVO® 900 from ZEISS is designed to deliver more functionalities than any surgical microscope today. It combines optical and digital visualization modalities, offers QEVO – the unique Micro-Inspection Tool and will impress you with its Surgeon-Controlled Robotics.
							</p>
						</div>
					</div>
				</div>
				<div class="span3">
					<div class="home-post">
						<div class="post-image">
							<img class="max-img" src="img/blog/clarus500.jpg" alt="" />
						</div>
						<div class="post-meta">
							<i class="icon-ok-sign icon-2x"></i>
							<span class="date">Zeiss Clarus 500</span>

						</div>
						<div class="entry-content">
							<p>
								he advent of widefield retinal imaging has shown us that indications of disease are often located in the far periphery of the retina. CLARUSTM 500 is the next generation fundus imaging system from ZEISS that provides true color and high-resolution across an entire ultra-widefield image.
							</p>
						</div>
					</div>
				</div>
				<div class="span3">
					<div class="home-post">
						<div class="post-image">
							<img class="max-img" src="img/blog/extaro300.jpg" alt="" />
						</div>
						<div class="post-meta">
							<i class="icon-ok-sign icon-2x"></i>
							<span class="date">Zeiss Extaro 300</span>
	
						</div>
						<div class="entry-content">
							<p>
								Low-color contrast often makes it difficult to recognize critical anatomical structures. The MultiSpectral Mode of ZEISS EXTARO 300 enhances this contrast, for example to better distinguish between vasculature and tissue. Discover the Multispectral Mode and see the difference.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="blankdivider30"></div>
		</div>
	</section>

	<!-- end spacer section -->
	<!-- section: contact -->
<?php
//pt contact form
if (!isset($_POST["submitcontact"])) {
	$_SESSION["n_memo"] = "";			
	$_SESSION["e_memo"] = "";			
	$_SESSION["t_memo"] = "";			
	$_SESSION["c_memo"] = "";			
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
	// Proceseaza datele formularului, doar daca vectorul $_POST este setat (cand se da click pe butonul Trimite)
	if (isset($_POST["submitcontact"])) 
	{
		
		$link = connectToDB();

		// Pregatire si inserare inregistrare noua in tabela MESAJ. 
		// Codific caracterele speciale prin functia mysqli_real_escape_string, pentru a nu da eroare la inserare.
		$n = mysqli_real_escape_string($link, $_POST["nume"]);
		$e = mysqli_real_escape_string($link, $_POST["email"]);
		$t = mysqli_real_escape_string($link, $_POST["titlu"]);
		$c = mysqli_real_escape_string($link, $_POST["comentariu"]);

		if (($n==$_SESSION["n_memo"]) and ($e==$_SESSION["e_memo"]) and ($t==$_SESSION["t_memo"]) and ($c==$_SESSION["c_memo"])) 	
		{ 
			echo "<script>window.alert('$n :\\n\\nTransmitere blocata. Mesajul dumneavoastra a fost transmis deja !')</script>";
		} 
		else 
		{
			$query = "INSERT INTO contact VALUES (NULL,'$n','$e','$t','$c')";	

			if (!mysqli_query($link, $query)) {
				echo "<script>window.alert('$n :\\n\\nMesajul dumneavoastra nu s-a putut transmite. Reincercati !')</script>";
			} else {
				$_SESSION["n_memo"] = $n;
				$_SESSION["e_memo"] = $e;
				$_SESSION["t_memo"] = $t;
				$_SESSION["c_memo"] = $c;
				echo "<script>window.alert('$n :\\n\\nMesajul dumneavoastra a fost transmis cu succes. Va multumim !')</script>";		
			}
		}	
		//header("location: index.php");
		mysqli_close($link);
	}
}
?>


	<section id="contact" class="section green">
		<div class="container">
			<h4>Contact</h4>
			<p>
				Dacă ai vreo întrebare noi îți vom răspunde în cel mai scurt timp. Dacă doriți să vă faceți o programare accesați secțiunea PROGRAMĂRI, după ce vă autentificați.
			</p>
			<div class="blankdivider30">
			</div>
			<div class="row">
				<div class="span12">
					<div class="cform" id="contact-form">
						<div id="sendmessage">Mesajul dvs a fost trimis. Mulțumim!</div>
						<div id="errormessage"></div>
						<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
							<div class="row">
								<div class="span6">
									<div class="field your-name form-group">
										<input type="text" name="nume" class="form-control" id="name" placeholder="Nume" data-rule="minlen:4" data-msg="Introduceti cel putin 4 caractere." />
										<div class="validation"></div>
									</div>
									<div class="field your-email form-group">
										<input type="text" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Introduceti un email valid." />
										<div class="validation"></div>
									</div>
									<div class="field subject form-group">
										<input type="text" class="form-control" name="titlu" id="subject" placeholder="Subiect" data-rule="minlen:4" data-msg="Introduceti cel putin 8 caractere." />
										<div class="validation"></div>
									</div>
								</div>
								<div class="span6">
									<div class="field message form-group">
										<textarea class="form-control" name="comentariu" rows="5" data-rule="required" data-msg="Lăsați mesajul aici" placeholder="Mesaj"></textarea>
										<div class="validation"></div>
									</div>
									<button type="submit" name="submitcontact" class="btn btn-info btn-rounded">Trimite mesaj</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- ./span12 -->
			</div>
		</div>
	</section>
	<footer>
		<div class="container">
			<div class="row">
				<div class="span6 offset3">
					<ul class="social-networks">
						<li><a href="#"><i class="icon-circled icon-bgdark icon-instagram icon-2x"></i></a></li>
						<li><a href="#"><i class="icon-circled icon-bgdark icon-twitter icon-2x"></i></a></li>
						<li><a href="#"><i class="icon-circled icon-bgdark icon-dribbble icon-2x"></i></a></li>
						<li><a href="#"><i class="icon-circled icon-bgdark icon-pinterest icon-2x"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
		
		

		
		
		<!-- ./container -->
	</footer>
	
	
	<a href="#" class="scrollup"><i class="icon-angle-up icon-square icon-bgdark icon-2x"></i></a>
	
	
	
	<script src="js/jquery.js"></script>
	<script src="js/jquery.scrollTo.js"></script>
	<script src="js/jquery.nav.js"></script>
	<script src="js/jquery.localScroll.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
	<script src="js/isotope.js"></script>
	<script src="js/jquery.flexslider.js"></script>
	<script src="js/inview.js"></script>
	<script src="js/animate.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/contactform.js"></script>	
	
	<script>
		var modal = document.getElementById('id_form_login');
		// Cand se da click oriunde in afara zonei modale, aceasta se va inchide
		window.onclick = function(event) {
			if (event.target == modal) {
				 modal.className = "loginmodal loginmodal-hidden";
			}
		}
		function stergeSpanUsernameErr() {
			document.getElementById('id_span_user_err').innerText="";
		}	
		function stergeSpanPasswordErr() {
			document.getElementById('id_span_pass_err').innerText="";
		}		
		function ascundeDivFormLogin() {
			document.getElementById('id_form_login').className="loginmodal loginmodal-hidden";  // schimba clasa (numele clasei) containerului
		}
		function afiseazaDivFormLogin() {
			document.getElementById('id_form_login').className="loginmodal loginmodal-visible";  // schimba clasa (numele clasei) containerului
		}		
	</script>	
	

	
</body>

</html>
