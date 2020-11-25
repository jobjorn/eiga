<?php


require_once("core.php");
require_once("connection.php");

if ($logged_in) {
    $import_test = "Date,Name,Year,Letterboxd URI,Rating
    2019-10-06,Galaxy Quest,1999,https://boxd.it/29gq,1
    2019-10-06,Dr. Strangelove or: How I Learned to Stop Worrying and Love the Bomb,1964,https://boxd.it/29eY,5
    2019-10-06,Gridlock'd,1997,https://boxd.it/1RSQ,2
    2019-10-06,Catwoman,2004,https://boxd.it/2aBY,1";

    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    echo "<pre>" . $import_test . "</pre>";

    $imported_rows = explode("\n", $_POST['ratings']);
    foreach ($imported_rows as $row) {
        $movie = str_getcsv($row);

        echo "<pre>";
        print_r($movie);
        echo "</pre>";
    }

    /* att göra här:
    1) kontrollera om filmen redan finns i eiga_movies
        a) via letterboxd_short_url
    2) om inte, lägg till den där
    3) lägg till filmen i eiga_grades
    */

    //    header("Location: " . $root_uri);
} else {

    //    header("Location: " . $root_uri);
}
