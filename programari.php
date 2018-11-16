<!DOCTYPE HTML>
<html lang="en">

	<head>
		<title>Cabinet Oftalmologie</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<link href="css/bootstrap.min.css" rel="stylesheet">	
		<link href="css/bootstrap-responsive.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="color/default.css" rel="stylesheet">
		<link href="css/programari.css" rel="stylesheet">		
		<link rel="shortcut icon" href="img/favicon.ico">
		<link rel="stylesheet" type="text/css" href="css/login.css" >
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">		
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		
		<script src="js/jquery.tableditprog.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">	
		
		<style>
			.button {
			padding: 0px 0px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			cursor: pointer;
			width:30px;
			height:31px;
			font-size: 1px;
			background-color: white; 
			color: black; 
			border: 2px solid #ffa366;
			}
			
			.button:hover {
			padding: 0px 0px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			cursor: pointer;
			font-size: 1px;
			background-color: #808080;
			color: white;
			border: 2px solid #ffa366;
			}
		</style>		
	</head>

<body>
	
	<script> 
		//selectez ora si anulez selectia anterioara
		//activ doar daca am selectat o data

		var memId = "0", memColor;

		<?php
			if ((isset($_GET["sort"])) && ($_GET["sort"] != "")) {
				echo "var sortare = '".$_GET["sort"]."';";
			} else {
				echo "var sortare = 'desc';";			
			}
		?>
		
		function selectHour(idd) {
			<?php  if(isset($_POST["dataprog"])) { ?>
				if( document.getElementById(idd).style.color=="green"){
						if(memId != "0") {
							   document.getElementById(memId).style.color=memColor; //se repune pe culoarea initiala
						}
						
						memId=idd;
						document.getElementById("memoOra").value=memId;
						memColor=document.getElementById(idd).style.color;
						document.getElementById(idd).style.color="orange";
				}
				else if( document.getElementById(idd).style.color=="red") {
					alert("Programare imposibilă!! Există deja o programare la ora selectată");
				}
				else 
					alert("Selectare ora imposibila! Selectati intai o data!");
			<?php } else { ?>
				alert("Selectare ora imposibila! Selectati intai o data!");
			<?php } ?>
		}
	</script>

	<!-- navbar  && the rest-->
	<?php 
		// Initialize the session
		session_start();

		require_once ("connectdb.php");
		
		include 'navbar.php';
		
		$_SESSION["afiseaza"]=0; //pentru mesaj afisare S-A SALVAT PROGRAMAREA..alert
		
		// Attempt to connect to MySQL database
		$link = connectToDB();
		
		// Processing form data when form is submitted
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			 
			// Check connection	
			if($link === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
						
			//primul buton
			
			if(isset ($_POST['veziOra'])) {
				
				
				//salvez in variabila sesiune si valoarea lui memoIdpac (val id-ului optiunii selectate)- o am din primul form
				if(isset($_POST["memoIdpac"])) {
					$_SESSION["memoIdpac"] = $_POST["memoIdpac"];
				}

				
				if(isset($_POST["dataprog"])) {
					//atentie am 2 formulare! am nevoie de dataprog si dupa primul submit
					$_SESSION["memoData"] = $_POST["dataprog"];
				}

				//implicit toate intervalele orare libere
				$ore=array("09:00"=>"0" , "09:30"=>"0" , "10:00"=>"0" , "10:30"=>"0" ,"11:00"=>"0" ,"11:30"=>"0" , "12:00"=>"0" ,"12:30"=>"0" , "13:00"=>"0" , "13:30"=>"0" , "14:00"=>"0" , "14:30"=>"0" , "15:00"=>"0" , "15:30"=>"0" , "16:00"=>"0" , "16:30"=>"0");


				// Prepare a select statement
				$sql = "SELECT ora FROM programari WHERE data = ?";		
				
				if($stmt = mysqli_prepare($link, $sql)){

					// Bind variables to the prepared statement as parameters
					mysqli_stmt_bind_param($stmt, "s", $param_data);
					
					// Set parameters
					
					$param_data= $_POST["dataprog"];
					
					// Attempt to execute the prepared statement
					if(mysqli_stmt_execute($stmt)){
						
						mysqli_stmt_store_result($stmt);
						// Check if username exists, if yes then verify password
						$nr=mysqli_stmt_num_rows($stmt);
						 if($nr > 0) {	
								mysqli_stmt_bind_result($stmt, $ora);
								while(mysqli_stmt_fetch($stmt)) {
									$ore[$ora] = "1";   //pun orele deja rezervate pe 1
								}	
						 }	
					} else{
						echo "Oops! Something went wrong. Please try again later.";
					}
					
					// Close statement
					mysqli_stmt_close($stmt);
				}
			}
			
			//al doilea buton 
			else if (isset($_POST['salveaza'])) {        
			//admin vs user
				if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y") {
					$idpacok = isset($_SESSION["memoIdpac"]) && $_SESSION["memoIdpac"] != "";	//pt admin
				}
				else {
					$idpacok = isset($_SESSION["idpac"]) && $_SESSION["idpac"] != "";		//pt user	
				}
							   
				if($idpacok && isset($_SESSION["memoData"]) && isset($_POST["memoOra"]) && $_POST["memoOra"] != "") {	
					$sql = "INSERT INTO programari (idprog,idpac,data,ora) VALUES (NULL,?,?,?)";
					 
					if($stmt = mysqli_prepare($link, $sql)){
						// Bind variables to the prepared statement as parameters
						mysqli_stmt_bind_param($stmt, "sss", $param_idpac, $param_data,$param_ora);
						
						// Set parameters
					   
						if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y") {
							$param_idpac = $_SESSION["memoIdpac"];	
						}
						else {
							$param_idpac = $_SESSION["idpac"];
						} 
					   
					    $param_data = trim($_SESSION["memoData"]);
					    $param_ora = trim($_POST["memoOra"]);
					   
						// Attempt to execute the prepared statement
						if(!mysqli_stmt_execute($stmt)){
							$_SESSION["afiseaza"]=1;
							die("Something went wrong. Please try again later. INSERT IN PACIENTI");
						}
						else {
							//daca afisez mesaj de salvare programare
							$_SESSION["afiseaza"]=1;
						}
						// Close statement
						mysqli_stmt_close($stmt);
						unset($_SESSION["memoData"]); //nu mai am nici o data memorata
					}
				}		
			}
		}
		
		//pt tabel programari-useri
		if(isset($_SESSION["idpac"]) && $_SESSION["idpac"]!=""){
			$queryUser= "AND pr.idpac='".$_SESSION["idpac"]."'";
		}
		else {
			$queryUser="";
		}
		
		if ((isset($_GET["sort"])) && ($_GET["sort"] != "")) {
			$mod_sortare = strtoupper($_GET["sort"]);
		} else {
			$mod_sortare = 'DESC';
		}
		
		$querytbl = "SELECT pr.idprog as idprog,pr.data as data,pr.ora as ora,pa.nume as nume,pa.prenume as prenume FROM programari pr,pacienti pa WHERE pr.idpac=pa.idpac ".$queryUser." ORDER BY data ".$mod_sortare.", ora ASC";
		
		$resulttbl = mysqli_query($link, $querytbl);

		if ($resulttbl==false)
			die('Eroare la selectia programarilor ! Reincarcati pagina');		
		
		// Close connection
		mysqli_close($link);			
	?>
		
	<div >
		<section id="programari" class="section orange">
			<div class="row">
			
				<div class="column">
				  <?php 
						if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y") {
								//cod pt admin, alegerea unui pacient
								echo "<h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Selectați un pacient :</h5></b>";
								$link = connectToDB();
								if (mysqli_connect_errno())
									  {
									  echo "Failed to connect to MySQL: " . mysqli_connect_error();
									  }
								$sql="SELECT idpac,nume,prenume FROM pacienti";
								$result=mysqli_query($link,$sql) or die ('Unable to execute query. '. mysqli_error($link));
								
								echo "&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select id=\"ids\" onchange='getOptionId()'>";
									echo "<option value='0'></option>";
								while($row = mysqli_fetch_array($result)) {
									echo "<option value='".$row['idpac']."'>".$row['nume']." ".$row['prenume']."</option>";
								}
								echo "</select>";
								mysqli_close($link);	
						}
					?>
					
					<h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Selectați data programării</b></h5>
					<form method="POST">
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="date" name="dataprog" style="height:40px;width:400px" ></p>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
						<input type="hidden" name="memoIdpac"  id="memoIdpac"> 
						<input type="hidden" name="memoNumePac"  id="memoNumePac"> 
						<button type="submit" name="veziOra" style= "height:40px;width:300px" class="btn btn-rounded">Vezi disponibilitate data</button>
					</form>
				</div>
							
				<div class="column">
					<h5><b>Selectați ora programării 
					<?php
					    if(isset($_SESSION["itsadmin"]) && $_SESSION["itsadmin"] == "Y" && isset($_POST["memoNumePac"]))
							echo"pentru pacientul : ".$_POST["memoNumePac"];
						if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) 
							echo", în data: ".$_POST["dataprog"];
					?> </b></h5>

					<div class="grid-container" style="cursor:pointer">
					  <div id="09:00" onClick="selectHour('09:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) { if($ore["09:00"] == "1") echo "red"; else echo "green";} ?>">09:00</div>
					  <div id="09:30" onClick="selectHour('09:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["09:30"] == "1") echo "red"; else echo "green";} ?>">09:30</div>
					  <div id="10:00" onClick="selectHour('10:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["10:00"] == "1") echo "red"; else echo "green"; }?>">10:00</div>  
					  <div id="10:30" onClick="selectHour('10:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["10:30"] == "1") echo "red"; else echo "green"; }?>">10:30</div>
					  <div id="11:00" onClick="selectHour('11:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["11:00"] == "1") echo "red"; else echo "green"; }?>">11:00</div>
					  <div id="11:30" onClick="selectHour('11:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["11:30"] == "1") echo "red"; else echo "green"; }?>">11:30</div>
					  <div id="12:00" onClick="selectHour('12:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["12:00"] == "1") echo "red"; else echo "green"; }?>">12:00</div>
					  <div id="12:30" onClick="selectHour('12:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["12:30"] == "1") echo "red"; else echo "green"; }?>">12:30</div>
					  <div id="13:00" onClick="selectHour('13:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["13:00"] == "1") echo "red"; else echo "green"; }?>">13:00</div>
					  <div id="13:30" onClick="selectHour('13:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["13:30"] == "1") echo "red"; else echo "green"; }?>">13:30</div>
					  <div id="14:00" onClick="selectHour('14:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["14:00"] == "1") echo "red"; else echo "green"; }?>">14:00</div>
					  <div id="14:30" onClick="selectHour('14:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["14:30"] == "1") echo "red"; else echo "green"; }?>">14:30</div>
					  <div id="15:00" onClick="selectHour('15:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["15:00"] == "1") echo "red"; else echo "green"; }?>">15:00</div>
					  <div id="15:30" onClick="selectHour('15:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) {if($ore["15:30"] == "1") echo "red"; else echo "green"; }?>">15:30</div>
					  <div id="16:00" onClick="selectHour('16:00')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) { if($ore["16:00"] == "1") echo "red"; else echo "green"; }?>">16:00</div>
					  <div id="16:30" onClick="selectHour('16:30')" style="color:<?php if(isset($_POST["dataprog"]) && ($_POST["dataprog"])!=0) { if($ore["16:30"] == "1") echo "red"; else echo "green"; }?>">16:30</div>
					</div>

					<br>
					<form method="POST">
						<input type="hidden" name="memoOra"  id="memoOra"> 
						<button type="submit" name="salveaza" style= "height:40px;width:300px" class="btn btn-rounded">Realizează programarea</button>
					</form>
				</div>
			</div>
			
		</section>
	
		<br>	
		<center><h4><b>Lista programarilor:</b></h4></center>
		
		
		<div class="container">
			<div class="table-wrapper">			
				
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<div class="search-box">
								<div class="input-group">								
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="text" id="searchdata" class="form-control" style="width:300px" placeholder="Cauta dupa data">
									<span class="input-group-addon" style="width:20px"><i class="material-icons" >&#xE8B6;</i></span>
									<input type="text" id="searchnume" class="form-control" style="width:300px" placeholder="Cauta dupa pacient">
									<span class="input-group-addon" style="width:20px"><i class="material-icons" >&#xE8B6;</i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
	
				<div class="table-responsive">  			
					<table id="editable_table" class="table table-bordered table-striped">
					 <thead>
					  <tr>
					   <th>ID</th>
					   
					    <th>Data programarii &nbsp;&nbsp;&nbsp;&nbsp;<i class="
						<?php			   
							if ((isset($_GET["sort"])) && ($_GET["sort"] != "")) {
								$tip_sortare = strtoupper($_GET["sort"]);
							} else {
								$tip_sortare = 'DESC';
							}	
							if ($tip_sortare == 'ASC') {
								echo "fa fa-caret-square-o-up";
							} else {
								echo "fa fa-caret-square-o-down";								
							}
						?>
					    "; style="cursor:pointer"; onclick="schimbaOrdonare()";></i></th>
					   
					   <th>Ora programarii</th>					   
					   <th>Nume</th>
					   <th>Prenume</th>
					  </tr>
					 </thead>
					 <tbody>
					 <?php
					 while($row = mysqli_fetch_array($resulttbl))
					 {
					  echo '
					  <tr>
					   <td>'.$row["idprog"].'</td>
					   <td>'.$row["data"].'</td>
					   <td>'.$row["ora"].'</td>					   
					   <td>'.$row["nume"].'</td>
					   <td>'.$row["prenume"].'</td>
					  </tr>
					  ';
					 }
					?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>  		
		
		
	<script>
		// pentru tabel cu programari
		$(document).ready(function(){  
			 $('#editable_table').Tabledit({
			  url:'action_programari.php',
			  columns:{
			   identifier:[0, "idprog"],
			   editable:[[1, 'data'], [2, 'ora'],[3, 'nume'],[4, 'prenume']]
			  },
			  restoreButton:false,
			  onSuccess:function(data, textStatus, jqXHR)
			  {
			   if(data.action == 'delete')
			   {
				$('#'+data.id).remove();
			   }
			  }
			 });
			
			// Filter table rows based on searched term
			$("#searchdata").on("keyup", function() {
				var term = $(this).val().toLowerCase();
				$("table tbody tr").each(function(){
					$row = $(this);
					var name = $row.find("td:nth-child(2)").text().toLowerCase();
					console.log(name);
					if(name.search(term) < 0){                
						$row.hide();
					} else{
						$row.show();
					}
				});
			});
			
			$("#searchnume").on("keyup", function() {
				var term = $(this).val().toLowerCase();
				$("table tbody tr").each(function(){
					$row = $(this);
					var name = $row.find("td:nth-child(4)").text().toLowerCase();
					console.log(name);
					if(name.search(term) < 0){                
						$row.hide();
					} else{
						$row.show();
					}
				});
			});
		}); 		
	</script>
	
	<script> 
		// pentru realizare programare
		function getOptionId() {
			var e = document.getElementById("ids");
			
			var idPacOpt = e.options[e.selectedIndex].value;
			var idPacOptNume = e.options[e.selectedIndex].text;
			
			//salvez in campul hidden pe rand id-urile si numele pacientilor din dropdown list
			document.getElementById("memoIdpac").value=idPacOpt;
			document.getElementById("memoNumePac").value=idPacOptNume;
		}
		
		function schimbaOrdonare() {
			if (sortare == "desc") {
				sortarenoua = "asc";
			} else {
				sortarenoua = "desc";
			}
			window.location.href = 'programari.php?sort='+sortarenoua;				
		}
		
		document.getElementById('meniuprogramari').style.color = "#1bac91";
		
		<?php 
			if (isset($_POST['salveaza']) && ($_SESSION['afiseaza']==1)) {
				echo 'alert("Programare realizata cu succes !")';
		 	}
		?>		
	</script>
	
</body>

</html>