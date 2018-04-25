<?php
    header('Access-Control-Allow-Origin:*');
    include 'EstablishDBCon.php';
    
    $userID = $_REQUEST["userID"];
    $orderBy = $_REQUEST["orderBy"];    //orderBy用于结果排序，一般为startTime(获取热门event时用popularity)
    $userList = $_REQUEST["userList"];  //是否为userlist，true或false，post时直接写，不要加""

    $pdo = establishDatabaseConnection("localhost","comp208","aooblocc_group23","12345");
    $userInfoPdo = establishDatabaseConnection("localhost","user_info","aooblocc_group23","12345");
    showEventList();

    function showEventList(){
        global $pdo;
        global $orderBy;
        global $userList;
        $userEventIDList = getUserEventIDList();//获取用户已经添加的event
        $pdo->beginTransaction();
        $sql = "SELECT eventID, eventName, founderName, startTime, endTime, popularity, locationID, brief, isAcademic FROM event ORDER BY $orderBy";
        foreach ($pdo->query($sql) as $row) {
            //1. 如果要显示的是uerlist,且该event不在userlist中，不显示该event
            //2. 如果要显示的不是userlist，且该event在userlist中，不显示该event
            if(($userList=="true"&&!in_array($row['eventID'],$userEventIDList))||($userList=="false"&&in_array($row['eventID'],$userEventIDList))){
                continue;
            }
            echo $row["eventID"].",".
                    $row["eventName"].",".
                    $row["founderName"].",".
                    $row["startTime"].",".
                    $row["endTime"].",".
                    $row["popularity"].",".
                    $row["locationID"].",".
                    $row["brief"].",".
                    $row["isAcademic"].";";
        }

        $pdo->commit();
    }
    
    function getUserEventIDList(){
        global $userInfoPdo;
        global $userID;
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
?>