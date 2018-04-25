<?php
header('Access-Control-Allow-Origin: *');
include 'EstablishDBCon.php';

    $eventID = $_REQUEST["eventID"];
    // $userID = $_REQUEST["userID"];

    
    $pdo = establishDatabaseConnection("localhost","comp208","aooblocc_group23","12345");
    delCreatedEvent();
    
    function delCreatedEvent(){
        
        global $eventID, $pdo;
        
        $pdo->beginTransaction();
        //$sql = "UPDATE $userID SET eventList = CONCAT(eventList,$eventID,',') WHERE userID =$userID;";
        $sql = $pdo->prepare("DELETE FROM event WHERE eventID = $eventID;");

        
        if($sql->execute()){
                // $deletedTuple = $sql->fetch();        	   
        		echo  "Delete successfully";
        	
        }else{
            echo "Deletion fails";
        }
        $pdo->commit();
        
    }