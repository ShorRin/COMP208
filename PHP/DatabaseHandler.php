<?php
/**
 * Created by PhpStorm.
 * User: aoo
 * Date: 3/31/2018
 * Time: 1:16 PM
 */
define("DATABASE_COMP208", "aooblocc_comp208");
define("DATABASE_USER", "aooblocc_user_info");
define("DATABASE_PROGRAMME", "aooblocc_programme_info");

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

    private static function connectToDB($nameOfDB){
        $db_hostname = "localhost";
        $db_database = $nameOfDB;
        $db_username = "aooblocc_group23";
        $db_password = "12345";
        $db_charset = "utf8mb4";
        $dsn = "mysql:host=$db_hostname;dbname=$db_database;charset=$db_charset";
        $opt = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
        return new PDO($dsn, $db_username, $db_password, $opt);
    }

    public function transactionRegister($username,  $password, $email, $programmeID){
        try {
            //Sub-transaction 01: INSERT new user into user table of the
            $this->pdoForCOMP208->beginTransaction();
            $this->pdoForUserInfo->beginTransaction();

            /*SQL01 Check duplicated Username*/
            $sql = "SELECT userName FROM user 
                    WHERE userName = ?";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            $stmt->execute(array($username));
            if($stmt->rowCount()!=0)
                throw new PDOException("USERNAME");
            /*SQL02 Check duplicated Email*/
            $sql = "SELECT email FROM user 
                    WHERE email = ?";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            $stmt->execute(array($email));
            if($stmt->rowCount()!=0)
                throw new PDOException("EMAIL");

            /*SQL03 Insert new user*/
            $sql = "INSERT INTO 
                        user(userID, userName, password, authority, email, programmeID) 
                    VALUES (?,?,?,?,?,?)";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            $newID = $this->generateID($username);
            $stmt->execute(array($newID, $username, $password, 0, $email, $programmeID));


            //Sub-transaction 02: Create a table for user;
            /*SQL04 Create table*/
            $sql = "CREATE TABLE ID$newID(
                        eventID int(8) NOT NULL DEFAULT 0,
                        PRIMARY KEY (eventID)
                    )";
            $this->pdoForUserInfo->exec($sql);

            $this->pdoForCOMP208->commit();
            $this->pdoForUserInfo->commit();
            $this->querySuccessfully("true");
        } catch (PDOException $e) {
            $this->duplicatedParams($e->getMessage());
            $this->pdoForCOMP208->rollBack();
            $this->pdoForUserInfo->rollBack();
        }
    }

    public function transactionAuthentication($username, $password){
        try {
            $userID = $this->authentication($username, $password);
            setcookie("userID", $userID, 0, '/');
            $this->querySuccessfully($userID);
        } catch (PDOException $e) {
            $this->notAuthentication($e->getMessage());
        }
    }

    public function getAllProgramme(){
        try {
            $sql = "SELECT programmeName, programmeID FROM program";
            $stmt = $this->pdoForCOMP208->query($sql);
            $resultArray = $stmt->fetchAll();
            echo json_encode($resultArray) ;
        } catch (PDOException $e) {
            $this->errorSQL();
        }
    }

    private function authentication($username, $password){
        /*SQL Query UserID, pw, authority*/
        $sql = "SELECT userID, password, authority
                FROM user
                WHERE userName = ?";
        $stmt = $this->pdoForCOMP208->prepare($sql);
        $stmt->execute(array($username));

        /*Checks if the username exist. 检查用户名是否存在*/
        if($stmt->rowCount() == 0)
            throw new PDOException("USERNAME");

        /*Check if password is correct. 检查密码是否正确*/
        $result = $stmt->fetch();
        if ($password != $result["password"])
            throw new PDOException("PASSWORD");

        /*Return a String includes both "authority and UserID" */
        return $result["authority"]." ".$result["userID"];
    }
    
    public function changePassword($username, $email, $newPassword){
        try {
            $sql = "SELECT email, userID
                    FROM  user 
                    WHERE userName = ?";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            $stmt->execute([$username]);
            if(!$stmt->rowCount())
                throw new PDOException("USERNAME");
            $result = $stmt->fetch();
            if($result["email"]!=$email)
                throw new PDOException("EMAIL");

            $sql = "UPDATE user SET password= ? 
                    WHERE user.userID = $result[userID]";
            $stmt = $this->pdoForCOMP208->prepare($sql);
            if($stmt->execute([$newPassword])){
                $this->querySuccessfully("TRUE");
                return true;
            }else{
                $this->querySuccessfully("FALSE");
                return false;
            }
        } catch (PDOException $e) {
            $this->badParams($e->getMessage());
            return false;
        }
    }

    private function generateID( $username)
    {
        $idNum = (int)abs(crc32($username. time()) / 10000);
        $id = strval(date("Y") % 100 * 1000000 + $idNum);
        $sql = "SELECT userID
                FROM user 
                WHERE userID = $id";
        $stmt = $this->pdoForCOMP208->query($sql);
        return ($stmt->columnCount())? $id : $this->generateID($username);
    }


    function errorSQL()
    {
        echo("400 SQL STATEMENT ERROR");
    }


    function unsupportedTransaction()
    {
        echo("401 UNSUPPORTED TRANSACTION");
    }

    function duplicatedParams( $reason){
        echo("402 ".$reason);
    }

    function notAuthentication( $reason)
    {
        echo("403 ".$reason);
    }


    function badParams( $reason)
    {
        echo("404 ".$reason);
    }

    function querySuccessfully($resultStr)
    {
        echo "100 ".$resultStr;
    }
}