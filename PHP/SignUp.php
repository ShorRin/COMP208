<?php
/**
 * Created by PhpStorm.
 * User: aoo
 * Date: 3/31/2018
 * Time: 1:11 PM
 * Description: 简单的封装事务 a)
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
    $databaseHandler->transactionRegister(
        $_REQUEST["username"], $_REQUEST["password"],
        $_REQUEST["email"], $_REQUEST["programme"]);



/**********Functions**********/
function generateTestPage()
{
    echo <<<START_HTML
<!DOCTYPE html
        PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns = "http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
    <title>COMP208后台测试页面</title>
    <link rev="made" href="mailto:x7yx2"/>
    <link rel="stylesheet" type = "text/css" href="http://www.aooblog.info/COMP284/284.css"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1>后台测试页面
    <span>Name: Yichao Xu; ID:201299092</span>
</h1>
<form name = 'form' method='get' action='' enctype='multipart/form-data'>
    <label><span>Transaction</span>
        <input type = "text" name = "trans" size = "100" placeholder = "transaction types" Statement />
    </label>
    <label><span>Username</span>
        <input type = "text" name = "username" size = "100" placeholder = "username" />
    </label>
    <label><span>Password</span>
        <input type = "text" name = "password" size = "100" placeholder = "password" />
    </label>
    <label><span>ScheduleIDList</span>
        <input type = "text" name = "scheduleIDList" size = "100" placeholder = "ID1; ID2; ID3" />
    </label>
    <label><span>&nbsp;</span>
        <input type = "submit" name = "formSubmit" value = "Submit" class = "button"/>
        <input type = "reset" name = "formReset" value = "Reset" class = "button"/>
    </label>
</form>
</body>
</html>
START_HTML;
    exit(0);
}

