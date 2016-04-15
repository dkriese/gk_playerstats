<?php
require_once('config/config.php');

if (isset($_POST["username"]) && !empty($_POST["username"])) { //Checks if action value exists
	$username = $_POST["username"];

	$dbh = new PDO($dsn, $uname, $pword);
	try {
		$sql = "SELECT time_ingame, points_captured, highest_killstreak, kills, deaths,"
				. " cast(kills/deaths as decimal(10,2)) AS 'K/D', games_played, games_won as wins,"
				. " games_played - games_won as losses, cast(games_won/(games_played - games_won) as decimal(10,2)) AS 'W/L',  "
				. " red_team_count as red, blue_team_count as blue, "
				. " cast(red_team_count/blue_team_count as decimal(10,2)) AS 'R/B' "
				. " FROM player_stats WHERE username = :username";

		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':username', $username, PDO::PARAM_STR);
		$stmt->execute();
		$results1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $ex) {
	   error_log('Exception: ' . print_r($ex,true));
	}

//Player Info Table:
//Columns; id, uuid, lastname, rank, credits
//Query: SELECT * FROM player_info WHERE lastname=’name_given’
	try {
		$stmt = $dbh->query("select lastname as name, rank, credits from player_info where lastname = '" . $username . "'");
		$results2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $ex) {
	   error_log('Exception: ' . print_r($ex,true));
	}
	$results = array_merge($results2, $results1);

	$data = array();
	foreach ($results as $row) {
		$data[] = $row;
	}
}
echo json_encode($data);

//username
//kills
//highest_killstreak
//points_captured
//games_played
//red_team_count
//blue_team_count
//time_ingame
//games_won
//arrows_fired
//deaths

