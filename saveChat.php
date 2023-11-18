<?php

$requestJSON = $_POST["requestJSON"];
$requestObject = json_decode($requestJSON);

$from_id = $requestObject -> from_user_id;
$to_id = $requestObject -> to_user_id;
$message = $requestObject -> message;

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date_time = $d->format("Y-m-d H:i:s");

$connection = new mysqli("localhost","root","Disura@2005","react_chat");

$connection -> query("INSERT INTO `chat`(`user_from_id`,`user_to_id`,`message`,`date_time`,`status_id`) 
VALUES ('".$from_id."','".$to_id."','".$message."','".$date_time."','1')");


?>