<?php

//$db_name = "test_gkstats";
$db_name = "db_12465";

if (isset($_POST["username"]) && !empty($_POST["username"])) { //Checks if action value exists
	error_log(print_r($_POST, true));
	$username = $_POST["username"];
//		$con = mysql_connect("localhost", "root", "");
	//$con = @mysql_connect("204.145.72.119", "db_12465", "7c3a6fb730");
	$dsn = 'mysql:host=204.145.72.119;dbname=' . $db_name;
	$uname = 'db_12465';
	$pword = '7c3a6fb730';
//	$options = array(
//		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
//	);

	$dbh = new PDO($dsn, $uname, $pword);
	//$result = mysql_query("select * from player_stats where username = '" . $username . "'");
try {
   $stmt = $dbh->query("select * from player_stats where username = '" . $username . "'");
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $ex) {
   error_log('Exception: ' . print_r($ex,true));
}	
	//error_log('results is ' . print_r($results, true));
	$data = array();
	foreach ($results as $row) {
		//error_log('row is ' . print_r($row, true));
		$data[] = $row;
	}
}
//}
//$data = array('key' => 'value');
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

