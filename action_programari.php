<?php
	//programari  
	require_once ("connectdb.php");
	
	$link = connectToDB();

	$input = filter_input_array(INPUT_POST);

	if($input["action"] === 'delete')
	{
	 $query = "
	 DELETE FROM programari 
	 WHERE idprog = '".$input["idprog"]."'
	 ";
	 mysqli_query($link, $query);
	}

	echo json_encode($input);
?>