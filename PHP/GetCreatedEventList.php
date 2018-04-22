<?php 
header('Access-Control-Allow-Origin: *');
include 'EstablishDBCon.php';
    
    $userID = $_REQUEST["userID"];
    $userName = $_REQUEST["userName"];// userName 就是 登陆的账户名？
    $orderBy = $_REQUEST["orderBy"];


    $pdo = establishDatabaseConnection("localhost","comp208","root","root");

    showCreatedEventsList();


    function showCreatedEventsList(){
        global $pdo;
        global $userName, $orderBy;
        
        try{
        $pdo->beginTransaction();
        $sql = "SELECT eventID, eventName, founderName, startTime, endTime, popularity, locationID, brief FROM event ORDER BY $orderBy";
        $set = $pdo->query($sql); 
        if(isset($set)){
        	foreach ($set as $row) {
            // （除去，不是该admin创建的）
            if(!($row["founderName"] == $userName)){
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
                    "<td>".$row["brief"]."</td>" .
                    // 提供 增删功能——不同的是，'增'' 是,  通过eventID删除即可
                    "<td> <button type='button' onclick=\"delCreatedEvent(".$row["eventID"].")\">delete</button></td>".
                "</tr>";
            }

        }else{
        	echo "You have not created a event.";	
        }
            $pdo->commit();
        

        }catch (PDOException $e) {
            $pdo->rollBack();
            
        }
    }

?>