<?php
//Registrera användare
// function addUser($conn) {
//     $email = escapeInsert($conn, $_POST['email']);
//     $password = escapeInsert($conn, $_POST['password']);
//     $passwordHash = password_hash($password, PASSWORD_DEFAULT);
//     $query = "INSERT INTO users(userEmail, userPassword) VALUES('$email', '$passwordHash')";
//     $result = mysqli_query($conn, $query) or die("Query failed: $query");
//     $insId = mysqli_insert_id($conn);
//     return $insId;
// }

//Ta bort oönskade html-tecken samt mysqli_real_escape_string motverkar SQLInjection
function escapeInsert($conn, $insert) {
    $insert = htmlspecialchars($insert);
    $insert = mysqli_real_escape_string($conn, $insert);
    return $insert;
}

//Kontrollera inloggning
// function checkUser($connection) {
//     $checkUser = mysqli_real_escape_string($connection, $_POST['email']);
//     $checkPassword = mysqli_real_escape_string($connection, $_POST['password']);
//     $query = "SELECT * FROM users WHERE userEmail = '$checkUser'";
//     $result = mysqli_query($connection, $query) or die("Query failed: $query");
//     $row =mysqli_fetch_assoc($result);
//     $count = mysqli_num_rows($result);
//     if ($count == 1) {
//         if (password_verify($checkPassword, $row["userPassword"])) {
//             $_SESSION['status'] = "ok";
//             $_SESSION['userid'] = $row['userId'];
//             header("Location: loggedin_start.php");
//         }       
//     }else {
//             echo '<p>Fel lösenord och/eller email!</p>';
//             echo '<p><a href="login_page.php">Försök igen</a></p>';
//     }
// }

//Lägga till lag
// function addTeam($conn) {
//     $teamName = escapeInsert($conn, $_POST['teamname']);
//     $query = "INSERT INTO team (teamName) VALUES('$teamName')";
//     $result = mysqli_query($conn, $query) or die("Query failed: $query");
//     $insId = mysqli_insert_id($conn);
//     return $insId;
// }

//Visa alla lag
// function getTeams($conn) {
//     $query = "SELECT * FROM team ORDER BY teamName ASC";
//     $result = mysqli_query($conn, $query) or die("Query failed: $query");
//     return $result;
// }

//Hämta ett lag
// function getTeamData($conn,$teamId){
//     $query = "SELECT * FROM team
// 			WHERE teamId=".$teamId;
//     $result = mysqli_query($conn,$query) or die("Query failed: $query");
//     $row = mysqli_fetch_assoc($result);
//     return $row;
// }

//Redigera lag
// function editTeam($conn) {
//     $teamName = escapeInsert($conn, $_POST['teamname']);
//     $editid = $_POST['updateid'];
//     $query = "UPDATE team SET teamName='$teamName' WHERE teamId=". $editid;
//     $result = mysqli_query($conn, $query) or die("Query failed: $query");
// }

//Ta bort lag
// function deleteTeam($conn, $teamId) {
//     $query = "DELETE FROM team WHERE teamId=". $teamId;
//     $result = mysqli_query($conn, $query) or die("Går ej att utföra pga att laget redan finns inlagt i spelschemat");
    
// }

//Lägga till arena
function addStadium($conn) {
    $stadiumName = escapeInsert($conn, $_POST['stadiumName']);
    $query = "INSERT INTO stadium (stadiumName) VALUES('$stadiumName')";
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
    $insId = mysqli_insert_id($conn);
    return $insId;
}

//Redigera arena
function editStadium($conn) {
    $stadiumName = escapeInsert($conn, $_POST['stadiumName']);
    $editid = $_POST['stadiumId'];
    $query = "UPDATE stadium SET stadiumName='$stadiumName' WHERE stadiumId=". $editid;
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
}

//Visa alla arenor
function getStadiums($conn) {
    $query = "SELECT * FROM stadium ORDER BY stadiumName ASC";
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
    $row = mysqli_fetch_all($result);
    return $row;
    
}

//Hämta en arena
function getStadiumData($conn, $stadiumId) {
    $query = "SELECT * FROM stadium
			WHERE stadiumId=".$stadiumId;
    $result = mysqli_query($conn,$query) or die("Query failed: $query");
    $row = mysqli_fetch_assoc($result);
    return $row;
}

//Ta bort arena
function deleteStadium($conn, $stadiumId) {
    $query = "DELETE FROM stadium WHERE stadiumId=". $stadiumId;
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
}

//Lägga till match
function saveGameTeam($conn) {
    $team1 = escapeInsert($conn, $_POST['team1']);
    $team2 = escapeInsert($conn, $_POST['team2']);
    
    // Spara match
    $gameId = addGame($conn);
    // Spara match och team i mellantabell (två gånger)
    addGameTeam($conn,$gameId,$team1);
    addGameTeam($conn,$gameId,$team2);
}

function addGame($conn) {
   
    // Spara match
    $gameDate = escapeInsert($conn, $_POST['gameDate']);
    $gameTime = escapeInsert($conn, $_POST['gameTime']);
    $gameStadium = escapeInsert($conn, $_POST['gameStadium']);
    $query = "INSERT INTO game (gameDate, gameTime, gameStadiumId) VALUES('$gameDate', '$gameTime', 
    (SELECT stadiumID FROM stadium WHERE stadiumName='$gameStadium'))";
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
    $insId = mysqli_insert_id($conn);
    return $insId;
}

function addGameTeam($conn,$gameId,$team) {

    // Spara match och team i mellantabell (två gånger)
    $query = "INSERT INTO gameTeam (gameTeamGid, gameTeamTid) VALUES('$gameId', '$team')";
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
    $insId = mysqli_insert_id($conn);
    return $insId;
}

//Visa alla matcher
function getGames($conn) {
    $query = "SELECT game.gameId, game.gameDate, game.gameTime, stadium.stadiumName
    FROM game, stadium
    WHERE stadium.stadiumId = game.gameStadiumId
    ORDER BY gameDate ASC, gameTime ASC";
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
    $row = mysqli_fetch_all($result);
    return $row;
}

function getGameTeam($conn,$gameId) {
    $query = "SELECT game.gameDate, team.teamName, game.gameTime
    FROM team 
    INNER JOIN gameTeam
    ON team.teamId = gameTeam.gameTeamTid
    INNER JOIN game 
    ON gameTeam.gameTeamGid = game.gameId
    WHERE gameTeam.gameTeamGid=" . $gameId;
    $result = mysqli_query($conn, $query) or die("Query failed: $query");
    return $result;
}

//Visar en match
function getGameData($conn, $gameId) {
    $query = "SELECT game.gameId, game.gameDate, game.gameTime, stadium.stadiumName
    FROM game, stadium
    WHERE stadium.stadiumId = game.gameStadiumId AND gameId=".$gameId;
    $result = mysqli_query($conn,$query) or die("Query failed: $query");
    $row = mysqli_fetch_all($result);
    return $row;
}

//Hämta inloggads email
function getUserEmail($conn){
    $query = "SELECT userEmail FROM users
			WHERE userId=".$_SESSION['userid'];
    $result = mysqli_query($conn,$query) or die("Query failed: $query");
    $row = mysqli_fetch_assoc($result);
    return $row['userEmail'];
}
?>