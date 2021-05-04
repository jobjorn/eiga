<?php


require_once("core.php");
require_once("connection.php");

if ($logged_in && is_numeric($sub1)) {
    $delete_sql = "DELETE FROM eiga_duels WHERE user_id = :user_id AND id = :id";
    $delete_statement = $dbh->prepare($delete_sql);
    $delete_statement->bindParam(":user_id", $logged_in_user->id);
    $delete_statement->bindParam(":id", $sub1);
    $delete_statement->execute();

    update_list($logged_in_user->id);
}

header("Location: " . $root_uri . "log/");
