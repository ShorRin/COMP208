<?php
header('Access-Control-Allow-Origin: *');
include 'establishDBCon.php';

    $eventID = $_REQUEST["eventID"];
    $userID = $_REQUEST["userID"];

    $userInfoPdo = establishDatabaseConnection("localhost","user_info","root","root");
    addEvent();
    echo "Success! Event ".$eventID." has been added to your list.";

    function addEvent(){
        global $userID;
        global $eventID;
        global $userInfoPdo;
        $tableName = "id".$userID;
        $userInfoPdo->beginTransaction();
        //$sql = "UPDATE $userID SET eventList = CONCAT(eventList,$eventID,',') WHERE userID =$userID;";
        $sql = "INSERT INTO $tableName VALUES($eventID)";
        $userInfoPdo->exec($sql);
        $userInfoPdo->commit();
    }
?>