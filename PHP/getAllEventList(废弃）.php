<?php
    header('Access-Control-Allow-Origin:*');
    include 'establishDBCon.php';

    $userID = $_REQUEST["userID"];
    $orderBy = $_REQUEST["orderBy"];

    $pdo = establishDatabaseConnection("localhost","comp208","root","root");
    $userInfoPdo = establishDatabaseConnection("localhost","user_info","root","root");
    showEventList();

    function showEventList(){
        global $pdo;
        global $orderBy;
        $userEventIDList = getUserEventIDList();
        $pdo->beginTransaction();
        $sql = "SELECT eventID, eventName, founderName, startTime, endTime, popularity, locationID, brief FROM event ORDER BY $orderBy";
        foreach ($pdo->query($sql) as $row) {
            if(in_array($row['eventID'],$userEventIDList)){
                continue;
            }
            echo "<tr>".
                    "<td id=".$row["eventID"].">".$row["eventID"]."</td>" .
                    "<td>".$row["eventName"]."</td>" .
                     "<td>".$row["founderName"]."</td>" .
                    "<td id=\"startTime\">".$row["startTime"]."</td>".
                    "<td id=\"endTime\">".$row["endTime"]."</td>" .
                    "<td>".$row["popularity"]."</td>" .
                    //"<td>".$row["locationID"]."</td>" .
                    "<td> <button type='button' onclick=\"showLocation(".$row["locationID"].")\">show</button></td>".
                    "<td>".$row["brief"]."</td>" .
                    "<td> <button type='button' onclick=\"addEvent(".$row["eventID"].")\">add</button></td>".
                "</tr>";
        }
        $pdo->commit();
    }
    
    function getUserEventIDList(){
        global $userInfoPdo;
        global $userID;
        $list = array();
        $tableName = "id".$userID;
        $userInfoPdo->beginTransaction();
        $sql = "SELECT eventID FROM $tableName";
        $rows = $userInfoPdo->query($sql);
        foreach ($rows as $row) {
            array_push($list,$row["eventID"]);
        }
        $userInfoPdo->commit();
        return $list;
    }
?>