<?php  
	require_once ("connectdb.php");
	
	$link = connectToDB();

	$input = filter_input_array(INPUT_POST);

	$nume = mysqli_real_escape_string($link, $input["nume"]);
	$prenume = mysqli_real_escape_string($link, $input["prenume"]);
	$cnp = mysqli_real_escape_string($link, $input["cnp"]);
	$tel = mysqli_real_escape_string($link, $input["tel"]);
	$email = mysqli_real_escape_string($link, $input["email"]);

	if($input["action"] === 'edit')
	{
	 $query = "
	 UPDATE pacienti 
	 SET nume = '".$nume."', 
	 prenume = '".$prenume."',
	 cnp = '".$cnp."',
	 datan = '".$input["datan"]."',
	 tel = '".$tel."',
	 email = '".$email."'
	 WHERE idpac = '".$input["idpac"]."'
	 ";

	 mysqli_query($link, $query);

	}
	if($input["action"] === 'delete')
	{
	 $query = "
	 DELETE FROM pacienti 
	 WHERE idpac = '".$input["idpac"]."'
	 ";
	 mysqli_query($link, $query);
	 $query = "
	 DELETE FROM utilizatori
	 WHERE idpac = '".$input["idpac"]."'
	 ";
	 mysqli_query($link, $query); 
	}

	echo json_encode($input);
?>