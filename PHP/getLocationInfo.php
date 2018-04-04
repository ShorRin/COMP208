<?php
    header('Access-Control-Allow-Origin:*');
    include 'establishDBCon.php';

    $locationID = $_REQUEST["locationID"];

    $pdo = establishDatabaseConnection("localhost","comp208","root","root");
    showLocationInfo();

    function showLocationInfo(){
        global $pdo;
        global $locationID;
        $pdo->beginTransaction();
        $sql = "SELECT locationName, longitude, latitude FROM location WHERE locationID = $locationID";
        foreach ($pdo->query($sql) as $row) {
            echo $row["locationName"].";".$row["longitude"].";".$row["latitude"];
        }
        $pdo->commit();
    }
?>