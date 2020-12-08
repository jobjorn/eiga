<?php


include("core.php");

$active['stats'] = 'class="active"';


$page_title = "Stats";
include("header.php");



?>
<div class="container">
    <div class="col-md-12">
        <h1>Stats</h1>
        <p>afgdfgdgf</p>
        <?php
        $sql = "SELECT position, COUNT(*) AS count FROM eiga_grades WHERE user_id = :user_id GROUP BY position ORDER BY position ASC ";
        $statement = $dbh->prepare($sql);
        $statement->bindParam(":user_id", $logged_in_user->id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        $i = 0;
        $i2 = 0;
        foreach ($result as $row) {
            $i++;
            if ($i == 1) {
                echo "<table class='table-striped' id='list'>";
            }
            echo "<tr>";
            echo "<th><h2>" . $row->position . "</h2></th>";
            echo "<td>" . $row->count . "</td>";
            echo "</tr>";
        }
        if ($i > 0) {
            echo "</td></tr></table>";
        }

        ?>
        <hr>
        <?php
        $max = 20;
        $total = 1000;
        for ($i = 1; $i <= $max; $i++) {

            echo distribution_count($i, $total, $max) . "<br>";
        }
        ?>
    </div>
</div>



<?php

include("footer.php");
