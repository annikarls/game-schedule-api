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
if (isset($_POST['stadiumId'])) {
    $stadiumId = $_POST['stadiumId'];
}else {
    echo "Ingen tillåten post (stadiumid)";
    exit;
}

$editStadium = editStadium($connection);

$stadiumData = getStadiumData($connection, $stadiumId);
$output = $stadiumData;
echo json_encode($output);

dbDisconnect($connection);

?>