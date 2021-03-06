<?php
/**
 * Created by PhpStorm.
 * User: aoo
 * Date: 3/31/2018
 * Time: 1:16 PM
 */
define("DATABASE_COMP208", "comp208");
define("DATABASE_USER", "user_info");
define("DATABASE_PROGRAMME", "programme_info");

class DatabaseHandler
{
    private $pdoForCOMP208;
    private $pdoForUserInfo;
    private $pdoForProgrammeInfo;

    public function __construct(){
        $this->pdoForCOMP208 = DatabaseHandler::connectToDB(DATABASE_COMP208);
        $this->pdoForUserInfo = DatabaseHandler::connectToDB(DATABASE_USER);
        $this->pdoForProgrammeInfo = DatabaseHandler::connectToDB(DATABASE_PROGRAMME);
    }

    public function __destruct(){
        $this->pdoForCOMP208 = NULL;
        $this->pdoForUserInfo = NULL;
        $this->pdoForProgrammeInfo = NULL;
    }

    private static function connectToDB(String $nameOfDB){
        $db_hostname = "localhost";
        $db_database = $nameOfDB;
        $db_username = "root";
        $db_password = "root";
        $db_charset = "utf8mb4";
        $dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
        return new PDO($dsn, $db_username, $db_password, $opt);
    }

    public function transactionRegister(String $username, String $password){
        try {
            //INSERT
            $this->pdoForCOMP208->beginTransaction();

            $sql = "INSERT INTO 
                        user(userID, userName, password, authority) 
                    VALUES (?,?,?,?)";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            $newID = $this->generateID($username);
            $stmt->execute([$newID, $username, $password, 0]);

            $this->pdoForUserInfo->beginTransaction();
            $sql = "CREATE TABLE ID$newID(
                        ScheduleID int(8) NOT NULL DEFAULT 0,
                        PRIMARY KEY (ScheduleID)
                    )";
            $this->pdoForUserInfo->exec($sql);

            $this->pdoForCOMP208->commit();
            $this->pdoForUserInfo->commit();
            $this->querySuccessfully("true");
        } catch (PDOException $e) {
            $this->pdoForCOMP208->rollBack();
            $this->pdoForUserInfo->commit();
            $this->duplicatedParams("USERNAME");
        }
    }

    public function transactionAuthentication(String $username, String $password){
        try {
            $userID = $this->authentication($username, $password);
            setcookie("userID", $userID, 0, '/');
            $this->querySuccessfully($userID);
        } catch (PDOException $e) {
            $this->notAuthentication($e->getMessage());
        }
    }

    private function authentication(String $username, String $password){
        $sql = "SELECT userID, password
                FROM user
                WHERE userName = ?";
        $stmt = $this->pdoForCOMP208->prepare($sql);
        $stmt->execute([$username]);
        /*Checks if the username exist. 检查用户名是否存在。*/
        if($stmt->rowCount() == 0)
            throw new PDOException("USERNAME");
        /*Check if password is correct. 检查密码是否正确*/
        $result = $stmt->fetch();
        if ($password != $result["password"])
            throw new PDOException("PASSWORD");

        return $result["userID"];
    }

    public function changePassword(String $username, String $password, String $newPassword){
        if (empty($_COOKIE["userID"])
            && $_COOKIE["userID"] != $this->authentication($username, $password)){
            $this->notAuthentication();
            return;
        }
        try {
            $sql = "UPDATE user 
                    SET password= ? 
                    WHERE userID = ?";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            $stmt->execute([$newPassword, $_COOKIE["userID"]]);
            if ($_COOKIE["userID"] == $this->authentication($username, $newPassword)){
                $this->querySuccessfully("true");
            }else{
                $this->querySuccessfully("false");
            }
        } catch (PDOException $e) {
            $this->errorSQL();
        }
    }

    private function generateID(String $username)
    {
        $idNum = (int)abs(crc32($username. time()) / 10000);
        $id = strval(date("Y") % 100 * 1000000 + $idNum);
        $sql = "SELECT userID
                FROM user 
                WHERE userID = $id";
        $stmt = $this->pdoForCOMP208->query($sql);
        return (empty($stmt->fetch()))? $id : $this->generateID($username);
    }


    function errorSQL()
    {
        echo("400 SQL STATEMENT ERROR");
    }


    function unsupportedTransaction()
    {
        echo("401 UNSUPPORTED TRANSACTION");
    }

    function duplicatedParams(String $reason){
        echo("402 ".$reason);
    }

    function notAuthentication(String $reason)
    {
        echo("403 ".$reason);
    }


    function badParams(String $reason)
    {
        echo("404 ".$reason);
    }

    function querySuccessfully($resultStr)
    {
        echo "100 ".$resultStr;
    }
}