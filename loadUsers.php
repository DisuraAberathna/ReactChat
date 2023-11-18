<?php

$userJSONText = $_POST["userJSONText"];
$userPHPObject = json_decode($userJSONText);

$connection = new mysqli("localhost", "root", "Disura@2005", "react_chat");
// $table_user = $connection->query("SELECT * FROM `user` WHERE `id` != '" . $userPHPObject->id . "'");

$table_user = $connection->query("SELECT * FROM `user` WHERE `id` != '" . $userPHPObject->id . "' AND `name` 
LIKE '" . $_POST["text"] . "%'");

$phpResponseArray = array();

for ($x = 0; $x < $table_user->num_rows; $x++) {

    $phpArrayItemObject = new stdClass();

    $user = $table_user->fetch_assoc();
    $phpArrayItemObject->pic = $user["profile_url"];
    $phpArrayItemObject->name = $user["name"];
    $phpArrayItemObject->id = $user["id"];

    $table_chat = $connection->query("SELECT * FROM `chat` WHERE 
   `user_from_id` = '" . $userPHPObject->id . "' AND `user_to_id` = '" . $user["id"] . "'
   OR
   `user_from_id` = '" . $user["id"] . "' AND `user_to_id` = '" . $userPHPObject->id . "'
   ORDER BY `date_time` DESC");

    if ($table_chat->num_rows == 0) {
        $phpArrayItemObject->msg = "";
        $phpArrayItemObject->time = "";
        $phpArrayItemObject->count = "0";
    } else {

        //unseen chat count
        $unseenChatCount = 0;

        //first row
        $lastChatRow = $table_chat->fetch_assoc();
        if ($lastChatRow["status_id"] == 1) {
            $unseenChatCount++;
        }

        $phpArrayItemObject->msg = $lastChatRow["message"];

        $phpDateTimeObject = strtotime($lastChatRow["date_time"]);
        $timeStr = date('h:i a', $phpDateTimeObject);
        $phpArrayItemObject->time = $timeStr;

        for ($i = 0; $i < $table_chat->num_rows - 1; $i++) {

            //other rows
            $newChatRow = $table_chat->fetch_assoc();
            if ($newChatRow["status_id"] == 1) {
                $unseenChatCount++;
            }
        }

        $phpArrayItemObject->count = $unseenChatCount;
    }

    array_push($phpResponseArray, $phpArrayItemObject);
}

$jsonResponseText = json_encode($phpResponseArray);
echo ($jsonResponseText);
