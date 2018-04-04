<?php
    header('Access-Control-Allow-Origin:*');
    include 'establishDBCon.php';

    $userID = $_REQUEST["userID"];
    
    $pdo = establishDatabaseConnection("localhost","comp208","root","root");
    checkUserId();

    function checkUserId(){
        global $pdo;
        global $userID;
        $pdo->beginTransaction();
        $sql = "SELECT userID,userName,authority,programmeID FROM user WHERE userID=$userID;";
        $rows = $pdo->query($sql);
        if($rows->rowCount()==0){
            echo "No this user";
            return;
        }else{
            echo "success;";
            foreach ($rows as $row) {
                echo "userID=".$row['userID'].";".
                        "userName=".$row['userName'].";".
                        "authority=".$row['authority'].";".
                        "programmeID=".$row['programmeID'].";";
          }
        }
        $pdo->commit();
    }
?>