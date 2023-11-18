<?php

$mobile = $_POST["mobile"];
$name = $_POST["name"];
$password = $_POST["password"];
$verifyPassword = $_POST["verifyPassword"];
$country = $_POST["country"];
$profile_picture_location = $_FILES["profile_picture"]["tmp_name"];

$connection = new mysqli("localhost", "root", "Disura@2005", "react_chat");

$table = $connection->query("SELECT `id` FROM `country` WHERE `name`='" . $country . "'");
$row = $table->fetch_assoc();
$country_id = $row["id"];

$connection->query("INSERT INTO `user`(`mobile`,`name`,`password`,`profile_url`,`country_id`) 
VALUES ('" . $mobile . "','" . $name . "','" . $password . "','uploads/" . $mobile . ".png','" . $country_id . "')");

move_uploaded_file($profile_picture_location, "uploads/" . $mobile . ".png");

echo ("1");