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
	<link href="color/default.css" rel="stylesheet">
	<link rel="shortcut icon" href="img/favicon.ico">
	<link rel="stylesheet" type="text/css" href="css/login.css" >
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>

	<!-- navbar -->
	<?php 
		// Initialize the session
		session_start();
		
		include 'navbar.php';
		
		require_once ("connectdb.php");
	
		$link = connectToDB();
		
		if($_SERVER["REQUEST_METHOD"] == "POST") {
			    $_SESSION["updated"]=false;
		        $numeu=$_POST["nume"];
				$prenumeu=$_POST["prenume"];
				$cnpu=$_POST["cnp"];
				$datanu=$_POST["datan"];
				$emailu=$_POST["email"];
				$telu=$_POST["tel"];
				$idpacu=$_SESSION["idpac"];
				//$prenumeu=$cnpu=$datanu=$emailu=$telu; 
				//$sql="UPDATE pacienti SET nume=$_POST["nume"], prenume=$_POST["prenume"], cnp=$_POST["cnp"],datan=$_POST["datan"],email=$_POST["email"],tel=$_POST["tel"] WHERE idpac=$_SESSION["idpac"];"
				
				//$sql="UPDATE pacienti SET nume=\"".$numeu."\" WHERE idpac= \"".$idpacu."\"";
				 
				$sql="UPDATE pacienti SET nume=\" ".$numeu."\" ,prenume=\"".$prenumeu."\" ,cnp=\"".$cnpu."\" ,datan=\"".$datanu."\" ,email=\"".$emailu."\" ,tel=\"".$telu."\" WHERE idpac=\"".$idpacu."\"";
				
				
			if(!mysqli_query($link, $sql)) {
				echo "<script>alert(\"error updating record:\"".mysqli_error($link).")</script>";
				}
				
			else {			
				//echo "<script> alert(\"Update succesfully\"); </script>";
				$_SESSION["updated"]=true;
				//mysqli_close($link); 
				$nume=$prenume=$cnp=$datan=$email=$tel=""; 
				//header("location: profil.php");
				}
		}
		
		else {
			
		
				
			$nume=$prenume=$cnp=$datan=$email=$tel=""; 
			// Prepare a select statement
			$sql = "SELECT nume,prenume,cnp,datan,tel,email FROM pacienti WHERE idpac = ?";
			
			if($stmt = mysqli_prepare($link, $sql)){ //link - leg cu tabela
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "s", $param_idpac); //stmt -statement returnat de prepare
				
				// Set parameters
				$param_idpac = $_SESSION["idpac"];
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){
					/* store result */
					mysqli_stmt_store_result($stmt);
					
					mysqli_stmt_bind_result($stmt, $nume, $prenume, $cnp,$datan,$tel,$email); //pune in corespondenta niste variabile cu campurile rezultate din select (stmt)
						
					mysqli_stmt_fetch($stmt);  //executa aducerea datelor in variabile ($nume....)
					
				} else{
					die("Oops! Something went wrong. Please try again later. SELECT FROM pacienti");
				}
			 mysqli_stmt_close($stmt);
			}	
		}    
    // Close connection
    mysqli_close($link);
		
	?>
	
	 <section id="contact" class="section green">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div>
                    <form method="POST" id="signup-form" >
                        
					<?php
						if ((isset($_SESSION["updated"])) && ($_SESSION["updated"]==true)){ //are un continut updated si e true.. adica a intrat ultima oara pe un update 
								    echo "<h2> Datele contului au fost actualizate!</h2>";
									$_SESSION["updated"]=false;
						}
						else 
						            echo "<br><br><h2><b>Modifică datele contului :".$_SESSION["username"]."</b></h2>";
					?>
                        <div class="form-group">
                            <input type="text"   name="nume" id="nume" style="height:40px;width:400px" placeholder="nume" value="<?php echo $nume?>"/>
                        </div>
						
						<div class=" form-group">
                            <input type="text" size="30px"  name="prenume" style="height:40px;width:400px"  id="prenume" placeholder="prenume" value="<?php echo $prenume?>"/>
                        </div>
						
                        <div class="form-group">
                            <input type="text"  name="email" style="height:40px;width:400px"  id="email" placeholder="email" value="<?php echo $email?>"/>
                        </div>
						
						 <div class="form-group">
                            <input type="text"  name="tel" id="tel" style="height:40px;width:400px"  placeholder="telefon" value="<?php echo $tel?>"/>
                        </div>
						
						<div class="form-group">
                            <input type="text" name="cnp" id="cnp" style="height:40px;width:400px"  placeholder="cnp" value="<?php echo $cnp?>"/>
                        </div>
						
						
						<div class="form-group">
                            <input type="text" name="datan" id="datan" style="height:40px;width:400px" placeholder="data nasterii"  value="<?php echo $datan?>"/>
                        </div>
						
						
                        <div class="form-group">
							<br>
						   <input type="submit"  name="MODIFICARE PROFIL" style="height:40px;width:400px"  id="submit" class="btn btn-info btn-rounded" value="Salvează modificările"/>
                        </div>
                    </form>
				</div>
			</div>
			<br><br><br><br><br><br>
		</section>
	

	<script>
		document.getElementById('meniuprofil').style.color = "#1bac91";
	</script>
	
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
	<script src="contactform/contactform.js"></script>	
	
</body>

</html>