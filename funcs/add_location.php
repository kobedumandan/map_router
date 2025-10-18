<?php

require '../db_connect.php';
$dbconn = (new db_connect())->connect();

$name = $_POST['l_name'];
$lat = $_POST['loc_lat'];
$lng = $_POST['loc_lng'];

$q = $dbconn->prepare("INSERT INTO locations (loc_name, lat, lng) VALUES (:l_name, :loc_lat, :loc_lng)");
$q->bindParam(':l_name', $name, PDO::PARAM_STR);
$q->bindParam(':loc_lat', $lat);
$q->bindParam(':loc_lng', $lng);

$q->execute();

header("Location: /map_router_leafletjs/index.php");
exit();
