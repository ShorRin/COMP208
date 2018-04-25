<?php 
header('Access-Control-Allow-Origin: *');
include 'EstablishDBCon.php';
     
    $userID = $_REQUEST["userID"];
    $userName = $_REQUEST["userName"];// userName 就是 登陆的账户名？
    $orderBy = $_REQUEST["orderBy"];
 
 
    $pdo = establishDatabaseConnection("localhost","comp208","aooblocc_group23","12345");
    showCreatedEventsList();
 
    function showCreatedEventsList(){
        global $pdo;
        global $userName, $orderBy;
        try{
        $pdo->beginTransaction();
        $sql = "SELECT eventID, eventName, founderName, startTime, endTime, popularity, isAcademic, locationID, brief FROM event WHERE founderName = '$userName' ORDER BY $orderBy";
        $set = $pdo->query($sql); 
 
        if($set->rowCount() != 0){
            $table = "<h2 align='center'>Event You Created</h2> <table border='1' class=\"hovertable\" style=\"font-size:14px;font-family:serif;\">"."<tr><td>eventID</td><td>eventName</td><td>startTime</td><td>endTime</td><td>popularity</td><td>Academic</td><td>brief</td><td>edit</td></tr>";
 
            foreach ($set as $row) {
                $table .= "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">".
                        "<td id=".$row["eventID"].">".$row["eventID"]."</td>" .
                        "<td>".$row["eventName"]."</td>" .
                        "<td id=\"startTime\">".$row["startTime"]."</td>".
                        "<td id=\"endTime\">".$row["endTime"]."</td>" .
                        "<td>".$row["popularity"]."</td>" .
                        "<td>".($row["isAcademic"] == 1 ? "Yes" : "No")."</td>" .
                        //"<td>".$row["locationID"]."</td>" .
                        "<td>".$row["brief"]."</td>" .
                        "<td> <button type='submit' class = 'deleteButton'". 
                        "onclick = 'confirm(\"Are you sure to delete it?\") ? delCreatedEvent(".$row["eventID"].") : uselessFunction();hideCreatedEventsWindow();popUpCreatedEventsWindow();getCreatedEventList()'>delete</button></td>".
                    "</tr>";
            }
 
            $table .= "</table>";
            echo $table;
         
        }else{
            echo "You have not created an event.";  
        }
            $pdo->commit();
         
 
        }catch (PDOException $e) {
            $pdo->rollBack();
             
        }
    }
 
     
 
?>