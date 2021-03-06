<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require("../includes/conn.php");
require("../includes/functions.php");

$connection = dbConnect();

if (isset($_POST['stadiumId'])) {
    $stadiumId = $_POST['stadiumId'];
}else {
    echo "Ingen tillåten post (stadiumid)";
    exit;
}

$deleteStadium = deleteStadium($connection, $stadiumId);

dbDisconnect($connection);

?>