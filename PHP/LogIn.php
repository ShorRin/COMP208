<?php
/**
 * Created by PhpStorm.
 * User: aoo
 * Date: 3/31/2018
 * Time: 1:11 PM
 * Description: 简单的封装事务 b)
 */
include_once 'DatabaseHandler.php';
header('Access-Control-Allow-Origin: *');
define("STUDENT_AUTHORITY", 0);

/**********Main**********/
$databaseHandler = new DatabaseHandler();

if (empty($_REQUEST["username"]))
    $databaseHandler->badParams("USERNAME");
else if (empty($_REQUEST["password"]))
    $databaseHandler->badParams("PASSWORD");
else
    $databaseHandler->transactionAuthentication($_REQUEST["username"], $_REQUEST["password"]);
