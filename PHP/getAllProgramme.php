<?php
/**
 * Created by PhpStorm.
 * User: aoo
 * Date: 4/24/2018
 * Time: 9:47 PM
 */

include_once 'DatabaseHandler.php';
header('Access-Control-Allow-Origin: *');

/**********Mains**********/
$databaseHandler = new DatabaseHandler();
$databaseHandler->getAllProgramme();

