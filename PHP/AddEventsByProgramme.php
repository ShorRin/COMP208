<?php
header('Access-Control-Allow-Origin: *');
include 'EstablishDBCon.php';
    //$comp208Pdo = establishDatabaseConnection("localhost","user_info","aooblocc_group23","12345");

    $userID = $_REQUEST["userID"];

    $userInfoPdo = establishDatabaseConnection("localhost","user_info","aooblocc_group23","12345");
    $programmeName = getProgrammeName();
    $programmeEventsList = getProgrammeEventsList();
    $userEventsList = getUserEventsIDList();
    addEventsByProgramme();

    function getProgrammeName(){
        global $userID;
        $programmeID;
        $programmeName;
        $comp208Pdo = establishDatabaseConnection("localhost","comp208","aooblocc_group23","12345");
        $comp208Pdo->beginTransaction();
        $sql = "SELECT programmeID FROM user WHERE userID = $userID";
        foreach ($comp208Pdo->query($sql) as $row) {
            $programmeID = $row["programmeID"];
        }
        $sql = "SELECT programmeName FROM program WHERE programmeID = $programmeID";
        foreach ($comp208Pdo->query($sql) as $row) {
            return $row["programmeName"];
        }

    }
    
    function getProgrammeEventsList(){
        global $programmeName;
        $list = array();
        $programmeInfoPdo = establishDatabaseConnection("localhost","programme_info","aooblocc_group23","12345");
        $programmeInfoPdo->beginTransaction();
        $sql = "SELECT eventID FROM $programmeName";
        foreach ($programmeInfoPdo->query($sql) as $row) {
            array_push($list,$row["eventID"]);
        }
        return $list;
    }

    function getUserEventsIDList(){
        global $userID;
        global $userInfoPdo;
        $list = array();
        $tableName = "ID".$userID;
        $userInfoPdo->beginTransaction();
        $sql = "SELECT eventID FROM $tableName";
        $rows = $userInfoPdo->query($sql);
        foreach ($rows as $row) {
            array_push($list,$row["eventID"]);
        }
        $userInfoPdo->commit();
        return $list;
    }

    function addEventsByProgramme(){
        global $programmeEventsList;
        global $userEventsList;
        global $userID;
        global $userInfoPdo;
        $tableName = "ID".$userID;
        foreach($programmeEventsList as $row){
            if(!in_array($row,$userEventsList)){
                $userInfoPdo->beginTransaction();
                $sql = "INSERT INTO $tableName VALUES($row)";
                $userInfoPdo->exec($sql);
                $userInfoPdo->commit();
            }
        }
    }
?>