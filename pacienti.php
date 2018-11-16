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
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">		
    <script src="js/jquery.tabledit.js"></script>
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
		border: 2px solid #00e6e6;
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
		border: 2px solid #00e6e6;
		}

	</style>
</head>

<body>

	<!-- navbar -->
	<?php 
		// Initialize the session
		session_start();
		
		include 'navbar.php';
		
		$_SESSION["lastpage"]="../pacienti.php";
		
		//pt tabel
		require_once ("connectdb.php");
	
		$link = connectToDB();
		
		$query = "SELECT * FROM pacienti ORDER BY idpac ASC";
		$result = mysqli_query($link, $query);
	?>
	<section id="contact" class="section green">
	<br><br><br>
	 <div class="container">  
		
		<h3 align="center"><b>Vizualizare și actualizare pacienți</b></h3>  
		<br><br><br>
			</section>
		<div class="container">
			<div class="table-wrapper">			
				
				<div class="table-title">
					<div class="row">
						<div class="col-sm-6">
							<div class="search-box">
								<div class="input-group">								
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="search" class="form-control" style="width:300px" placeholder="Cauta un pacient dupa nume">
									<span class="input-group-addon" style="width:20px"><i class="material-icons" >&#xE8B6;</i></span>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="button" value="Adauga pacient nou" style= "height:40px;width:300px" class="btn btn-info btn-rounded" onclick="document.location.href='regform/index.php'">						
								</div>
							</div>
						</div>
					</div>
				</div>
				<br>				
		
				<div class="table-responsive">  			
					<table id="editable_table" class="table table-bordered table-striped">
					 <thead>
					  <tr>
					   <th>ID</th>
					   <th>Nume</th>
					   <th>Prenume</th>
					   <th>CNP</th>
					   <th>Data nașterii</th>
					   <th>Telefon</th>
					   <th>Email</th>
					  </tr>
					 </thead>
					 <tbody>
					 <?php
					 while($row = mysqli_fetch_array($result))
					 {
					  echo '
					  <tr>
					   <td>'.$row["idpac"].'</td>
					   <td>'.$row["nume"].'</td>
					   <td>'.$row["prenume"].'</td>
					   <td>'.$row["cnp"].'</td>
					   <td>'.$row["datan"].'</td>
					   <td>'.$row["tel"].'</td>
					   <td>'.$row["email"].'</td>
					  </tr>
					  ';
					 }
					 ?>
					 </tbody>
					</table>
				</div>
			</div>
		</div>  
	</div>  

	<script>  
		$(document).ready(function(){  
			 $('#editable_table').Tabledit({
			  url:'action_pacienti.php',
			  columns:{
			   identifier:[0, "idpac"],
			   editable:[[1, 'nume'], [2, 'prenume'],[3, 'cnp'],[4, 'datan'],[5, 'tel'],[6, 'email']]
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
			$("#search").on("keyup", function() {
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
		}); 

		document.getElementById('meniupacienti').style.color = "#1bac91";
	</script>
	
</body>

</html>