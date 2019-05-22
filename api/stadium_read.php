<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require("../includes/conn.php");
require("../includes/functions.php");

$connection = dbConnect();

if (isset($_GET['stadiumid']) && $_GET['stadiumid'] > 0) {
    $stadiumData = getStadiumData($connection, $_GET['stadiumid']);
}else {
    echo "Inget giltigt ID";
}

$output = $stadiumData;

echo json_encode($output);

dbDisconnect($connection);
?>
