<?php
/**
 * Created by PhpStorm.
 * User: aoo
 * Date: 4/3/2018
 * Time: 1:11 PM
 * Description: 简单SMTP协议实现
 */

//必须引用！
include_once 'DatabaseHandler.php';
header('Access-Control-Allow-Origin:*');
use PHPMailer\PHPMailer\PHPMailer;

/**********Main**********/
$databaseHandler = new DatabaseHandler();

if (empty($_REQUEST["username"]))
    $databaseHandler->badParams("USERNAME");
else if (empty($_REQUEST["email"]))
    $databaseHandler->badParams("EMAIL");
else
    changeTemplePassword();


/**********Functions**********/

function changeTemplePassword(){
    global $databaseHandler;
    $tempPassword = generateTemplePassword();
    sendMail($_REQUEST["email"], "your Temple Password", "PW:\n".$tempPassword."\nBest Wishes\nCOMP 208 Group 23");
    $databaseHandler->changePassword($tempPassword, $_REQUEST["email"], $_REQUEST["username"]);
}

function generateTemplePassword(){
    return abs(crc32($_REQUEST["username"]. $_REQUEST["email"]));
}


function sendMail($to, $title, $content)
{
    require_once('./PHPMailer/SMTP.php');
    require_once('./PHPMailer/PHPMailer.php');
    $phpMailer = new PHPMailer();

    //设置为发送邮件
    $phpMailer->isSMTP();

    //邮件服务器的帐号信息
    $phpMailer->Host = 'aooblog.me';
    $phpMailer->SMTPAuth = true;
    $phpMailer->Username = 'comp208group@aooblog.me';
    $phpMailer->Password = '12345';
    $phpMailer->Port = 587;

    //邮件内容
    $phpMailer->CharSet = 'utf-8';
    $phpMailer->From = 'comp208group@COMP208Group.me';
    $phpMailer->FromName = 'COMP208Group';
    $phpMailer->Subject = $title;
    $phpMailer->Body = $content;

    $phpMailer->AddAddress($to);

    try {
        echo $phpMailer->send();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
