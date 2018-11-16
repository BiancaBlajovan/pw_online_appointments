<?php

session_start();

// Define variables and initialize with empty values
$username = $password = $confirm_password = ""; //completate in urma selectului
$username_err = $password_err = $confirm_password_err =$execute_err = "";  
 
 require_once ("../connectdb.php");
 
 $link = connectToDB();
 
 $nume="";
 $prenume="";
 $email="";
 $tel="";
 $cnp="";
 $datan="";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
	$email = trim($_POST["email"]);
	$tel = trim($_POST["tel"]);
	$cnp = trim($_POST["cnp"]);
	$datan = trim($_POST["datan"]);
 
		if(empty(trim($_POST["nume"]))){ 
			$username_err = "Introduceti numele.";
		} else{
			$nume = trim($_POST["nume"]);
		}
		
		
		if(empty(trim($_POST["prenume"]))){ 
			$username_err = "Introduceti prenumele.";
		} else{
			$prenume = trim($_POST["prenume"]);
		}

if (empty($username_err)) {

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Introduceti un nume de utilizator.";
    } else{

        // Prepare a select statement
        $sql = "SELECT id FROM utilizatori WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){ //link - leg cu tabela
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username); //stmt -statement returnat de prepare
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Acest nume de utilizator exista deja.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                $execute_err= "Oops! Something went wrong. Please try again later. SELECT FROM ULTILIZ";
            }
		 mysqli_stmt_close($stmt);
        }
    }
  
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduceti o parola.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Parola trebuie sa aiba cel putin 6 caractere.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirmati parola.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Parolele nu sunt identice.";
        }
    }
	
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($execute_err)){
		
        // Prepare an insert statement  PACIENTI
        $sql = "INSERT INTO pacienti (idpac,nume,prenume,cnp,datan,tel,email) VALUES (NULL,?,?,?,?,?,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_nume, $param_prenume,$param_cnp,$param_datan,$param_tel,$param_email);
            
            // Set parameters
           $param_nume = trim($_POST["nume"]);
		   $param_prenume = trim($_POST["prenume"]);
		   $param_cnp = trim($_POST["cnp"]);
		   $param_datan = trim($_POST["datan"]);
		   $param_tel = trim($_POST["tel"]);
		   $param_email = trim($_POST["email"]);
		  

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $idpac = mysqli_insert_id($link); //link! leg cu mysql
            } else{
                $execute_err="Something went wrong. Please try again later. INSERT IN PACIENTI";
            }
         // Close statement
        mysqli_stmt_close($stmt);
		}
		

		if(empty($execute_err)) {
			
			 // Prepare an insert statement UTILIZATORI
			$sql = "INSERT INTO utilizatori (username, password,idpac) VALUES (?,?,?)";
			 
			if($stmt = mysqli_prepare($link, $sql)){
				// Bind variables to the prepared statement as parameters
				mysqli_stmt_bind_param($stmt, "ssi", $param_username, $param_password,$param_idpac);
				
				// Set parameters
				$param_username = $username;
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
				$param_idpac = $idpac; 
				
				
				// Attempt to execute the prepared statement
				if(mysqli_stmt_execute($stmt)){

					// Redirect to welcome page
					if (isset($_SESSION["lastpage"])) {
						header("location: " . $_SESSION["lastpage"]);
					} else {					
						header("location: ../index.php");
					}				
				} else{
					$execute_err= "Something went wrong. Please try again later. INSERT IN UTILIZATORI";
				}
			 // Close statement
			mysqli_stmt_close($stmt);
			}
		}
    }
}
    // Close connection
    mysqli_close($link);
	
	if(!empty($execute_err))
		die($execute_err);
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inregistrare</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="contactForm">
                        <h2 class="form-title">Creează cont nou</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="nume" id="nume" placeholder="Nume"  value="<?php echo $nume; ?>"/>
                        </div>
						
						<div class="form-group">
                            <input type="text" class="form-input" name="prenume" id="prenume" placeholder="Prenume"  value="<?php echo $prenume; ?>"/>
                        </div>
						
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Mail"  value="<?php echo $email; ?>"/>
                        </div>
						
						 <div class="form-group">
                            <input type="text" class="form-input" name="tel" id="tel" placeholder="Telefon"  value="<?php echo $tel; ?>"/>
                        </div>
						
						<div class="form-group">
                            <input type="text" class="form-input" name="cnp" id="cnp" placeholder="CNP"  value="<?php echo $cnp; ?>"/>
                        </div>
						
						
						<div class="form-group">
                            <input type="text" class="form-input" name="datan" id="datan" placeholder="Data nașterii"  value="<?php echo $datan; ?>"/>
                        </div>
						
						
						<div class="form-group">
                            <input type="text" class="form-input" name="username" id="username" placeholder="Nume de utilizator"  value="<?php echo $password; ?>"/>
                        </div>
						
						
                        <div class="form-group  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Parola"   value="<?php echo $password; ?>" />
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password" ></span>
							<span class="help-block"><?php echo $password_err; ?></span>                       
						</div>
						
						
                        <div class="form-group   <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                            <input type="password" class="form-input" name="confirm_password" id="re_password" placeholder="Reintroducere parola"   value="<?php echo $confirm_password; ?>"  />
							<span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password" ></span>
							<span class="help-block"><?php echo $confirm_password_err; ?></span>
						</div>
						
                        <div class="form-group">
                            <input type="submit" name="Înregistrare" id="submit" class="form-submit" value="Înregistrare"/>
							  <br><br> Deja aveți un cont? <a href="../index.php" class="loginhere-link">Conectează-te aici</a>
                        </div>
                    </form>
                   
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>