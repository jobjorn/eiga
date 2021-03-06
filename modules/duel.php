<?php


require_once("core.php");
require_once("connection.php");

if ($logged_in && is_numeric($sub1) && is_numeric($sub2) && is_numeric($sub3)) {
	if ($sub3 == latest_duel($logged_in_user->id)) {
		$insert_sql = "INSERT INTO eiga_duels (user_id, winner, loser) VALUES (:user_id, :winner, :loser)";
		$insert_statement = $dbh->prepare($insert_sql);
		$insert_statement->bindParam(":user_id", $logged_in_user->id);
		$insert_statement->bindParam(":winner", $sub1);
		$insert_statement->bindParam(":loser", $sub2);
		$insert_statement->execute();


		update_list($logged_in_user->id);
	}
}

header("Location: " . $root_uri);
