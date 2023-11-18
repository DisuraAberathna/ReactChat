<?php

$connection = new mysqli("localhost", "root", "Disura@2005", "react_chat");
$table_country = $connection->query("SELECT * FROM `country`");

$country_array = array();

for ($x = 0; $x < $table_country->num_rows; $x++) {
    $country = $table_country->fetch_assoc();

    array_push($country_array, $country["name"]);
}

$json = json_encode($country_array);
echo ($json);
