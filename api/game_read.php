<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require("../includes/conn.php");
require("../includes/functions.php");

$connection = dbConnect();

if (isset($_GET['gameid']) && $_GET['gameid'] > 0) {
    $gameData = getGameData($connection, $_GET['gameid']);
}else {
    echo "Inget giltigt ID";
}

$output = $gameData;

echo json_encode($output);

dbDisconnect($connection);
?>