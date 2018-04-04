<?php
header('Access-Control-Allow-Origin: *');
include 'establishDBCon.php';

    $eventID = $_REQUEST["eventID"];
    $userID = $_REQUEST["userID"];

    $userInfoPdo = establishDatabaseConnection("localhost","user_info","root","root");
    delEvent();
    echo "Success! Event ".$eventID." has been removed from your list.";

    function delEvent(){
        global $userID;
        global $eventID;
        global $userInfoPdo;
        $tableName = "id".$userID;
        $userInfoPdo->beginTransaction();
        //$sql = "UPDATE $userID SET eventList = CONCAT(eventList,$eventID,',') WHERE userID =$userID;";
        $sql = "DELETE FROM $tableName WHERE eventID = $eventID";
        $userInfoPdo->exec($sql);
        $userInfoPdo->commit();
    }
?>