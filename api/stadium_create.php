<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require("../includes/conn.php");
require("../includes/functions.php");

$connection = dbConnect();

if (isset($_POST['stadiumName'])) {
    $stadiumName = $_POST['stadiumName'];
}else {
    echo "Ingen tillåten post (stadiumName)";
    exit;
}

$saveStadium = addStadium($connection);

if (isset($saveStadium) && $saveStadium > 0) {
    $stadiumData = getStadiumData($connection, $saveStadium);
    $output = $stadiumData;
    echo json_encode($output);
}

dbDisconnect($connection);
?>