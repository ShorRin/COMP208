<?php
header('Access-Control-Allow-Origin: *');
include 'EstablishDBCon.php';
    

    $pdo = establishDatabaseConnection("localhost","comp208","root","root");
	showAllLocationID();

function showAllLocationID(){
	global $pdo;
	
	$options= '<option value="" selected disabled>'.'select a location'.'</option>';
	$sql = "SELECT locationID, locationName FROM location";
  	
  	foreach ($pdo->query($sql) as $row) {
	    # the case: mark the selected option and show it in the first place
	    $options.="<option value='".$row["locationID"]."' selected>".$row["locationID"].". ".$row["locationName"]."</option>\n";		    			
  	}
   	echo $options;
}

?>