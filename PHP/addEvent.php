<?php
header('Access-Control-Allow-Origin: *');
include 'EstablishDBCon.php';

    $eventID = $_REQUEST["eventID"];
    $userID = $_REQUEST["userID"];

    $userInfoPdo = establishDatabaseConnection("localhost","user_info","aooblocc_group23","12345");
    addEvent();
    increasePopularity();
    
    echo "Success! Event has been added to your list.";

    function addEvent(){
        global $userID;
        global $eventID;
        global $userInfoPdo;
        $tableName = "ID".$userID;
        $userInfoPdo->beginTransaction();
        //$sql = "UPDATE $userID SET eventList = CONCAT(eventList,$eventID,',') WHERE userID =$userID;";
        $sql = "INSERT INTO $tableName VALUES($eventID)";
        $userInfoPdo->exec($sql);
        $userInfoPdo->commit();
    }

    function increasePopularity(){
        global $eventID;
        $comp208Pdo = establishDatabaseConnection("localhost","comp208","aooblocc_group23","12345");
        $comp208Pdo->beginTransaction();
        //$sql = "UPDATE $userID SET eventList = CONCAT(eventList,$eventID,',') WHERE userID =$userID;";
        $sql = "UPDATE event SET popularity = popularity+1 WHERE eventID = ($eventID)";
        //echo $sql;
        $comp208Pdo->exec($sql);
        $comp208Pdo->commit();
    }
?>