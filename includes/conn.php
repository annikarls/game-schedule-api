<?php

//Skapar databaskopplingen
function dbConnect(){
	$connection = mysqli_connect("localhost", "root", "", "damallsvenskan")
        or die("Could not connect");
    mysqli_select_db($connection,"damallsvenskan") or die("Could not select database");
	return $connection;
}
	
//Stänger databaskopplingen
function dbDisconnect($connection){
	mysqli_close($connection);
}
?>