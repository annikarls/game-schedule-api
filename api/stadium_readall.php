<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");

require("../includes/conn.php");
require("../includes/functions.php");

$connection = dbConnect();

$allStadiums = getStadiums($connection);
$output = $allStadiums;

echo json_encode($output);

dbDisconnect($connection);
?>