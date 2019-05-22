<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require("../includes/conn.php");
require("../includes/functions.php");

$connection = dbConnect();

if (isset($_POST['gameDate'])) {
    $gameDate = $_POST['gameDate'];
}else {
    echo "Ingen tillåten post (gameDate)";
    exit;
}
if (isset($_POST['gameTime'])) {
    $gameTime = $_POST['gameTime'];
}else {
    echo "Ingen tillåten post (gameTime)";
    exit;
}
if (isset($_POST['gameStadium'])) {
    $gameStadium = $_POST['gameStadium'];
}else {
    echo "Ingen tillåten post (gameStadium)";
    exit;
}

$saveGame = addGame($connection);

if (isset($saveGame) && $saveGame > 0 ) {
    $gameData = getGameData($connection, $saveGame);
    $output = $gameData;
    echo json_encode($output);
}

dbDisconnect($connection);
?>