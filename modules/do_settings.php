<?php


require_once("core.php");
require_once("connection.php");

if ($logged_in) {
    $position_limits = $_POST['position-limits'];
    $settings = json_encode($position_limits);

    $sql = "UPDATE eiga_users SET settings = :settings WHERE id = :id";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(":settings", $settings);
    $statement->bindParam(":id", $logged_in_user->id);
    $statement->execute();
}

header("Location: " . $root_uri);
