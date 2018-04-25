<?php 
header('Access-Control-Allow-Origin: *');
include 'establishDBCon.php';
	
    
    $founderName = $_REQUEST["founderName"];
    $eventName = $_REQUEST["eventName"];
    $eventType = ($_REQUEST["type"] === "academic" ? 1 : 0); // int: 1->yes
    $startTime = $_REQUEST["startTime"];//in 'YYYY-MM-DD HH:MM:SS' format of MySQL
    $endTime = $_REQUEST["endTime"]; //in 'YYYY-MM-DD HH:MM:SS' format of MySQL
	$locationSelection = $_REQUEST["locationID"]; // int : ID
    // 什么格式？ID 的话：那就是取自前端的一个select menu咯？ 因为用户又不知道也不能记忆那么多id
    $briefDescription = $_REQUEST["brief"];
    $pdo = establishDatabaseConnection("localhost","comp208","aooblocc_group23","12345");

    //call creation function
    createNewEvent();

    function createNewEvent(){
    	global $pdo, $programmeName, $founderName, $eventType, $eventName, $startTime, $endTime, $locationSelection, $briefDescription;

    	// past matching test
    	
    		try{
    			$pdo->beginTransaction();

    			$insert = $pdo->prepare("INSERT INTO 
    			event(eventName, founderName, isAcademic, startTime, endTime, popularity, locationID, brief)
    			VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
	    		$insert->execute(array($eventName,$founderName, $eventType, $startTime, $endTime, 0, $locationSelection, $briefDescription));

    			$pdo->commit();
    			echo "New Event creation is done.";// return to the page 
    		}catch (PDOException $e) {
                echo " INSERT INTO 
                event(eventName, founderName, isAcademic, startTime, endTime, popularity, locationID, brief)";
    			echo $e->getMessage();
        		$pdo->rollBack();     
    		}
    }
