<?php


include("core.php");

$active['stats'] = 'class="active"';


$page_title = "Stats";
include("header.php");

?>
<div class="container">
    <div class="col-md-12">
        <h1>Stats</h1>
        <?php
        $sql = "SELECT grade, COUNT(*) AS count FROM eiga_grades WHERE user_id = :user_id GROUP BY grade ORDER BY grade DESC ";
        $statement = $dbh->prepare($sql);
        $statement->bindParam(":user_id", $logged_in_user->id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        $i = 0;
        $grades = array();
        foreach ($result as $row) {
            $i++;
            $grades[$i] = $row->count;
        }

        $sql = "SELECT position, COUNT(*) AS count FROM eiga_grades WHERE user_id = :user_id GROUP BY position ORDER BY position ASC ";
        $statement = $dbh->prepare($sql);
        $statement->bindParam(":user_id", $logged_in_user->id);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_OBJ);
        $i = 0;
        $positions = array();
        foreach ($result as $row) {
            $i++;
            $positions[$i] = $row->count;
        }

        $settings_position_limits = json_decode($logged_in_user->settings);
        $settings_position_limits = explode("\n", $settings_position_limits);
        $i = 0;
        $position_limits = array();
        foreach ($settings_position_limits as $limit) {
            if (is_numeric(trim($limit))) {
                $i++;
                $position_limits[$i] = trim($limit);
            }
        }

        if (count($position_limits) < 2) {
            $sql = "SELECT COUNT(*) as total FROM eiga_grades WHERE user_id = :user_id";
            $statement = $dbh->prepare($sql);
            $statement->bindParam(":user_id", $logged_in_user->id);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_OBJ);
            $total = $result[0]->total;

            for ($i = 1; $i <= 10; $i++) {
                $position_limits[$i] = distribution_count($i, $total, 10);
            }
        }

        $count = max(count($grades), count($positions), count($position_limits));
        $sum = array_sum($positions);

        $i = 0;
        for ($i = 1; $i <= $count; $i++) {
            if ($i == 1) {
                echo "<table class='table-striped barchart' id='list'>";
                echo "<tr><th></th><th><h2>Imported</h2></th><th><h2>Current</h2></th><th><h2>Target</h2></th></tr>";
            }
            echo "<tr>";
            echo "<th><h2>" . $i . "</h2></th>";
            if (isset($grades[$i])) {
                echo "<td><div style='width: " . $grades[$i] / max($grades) * 100 . "%;'>&nbsp;&nbsp;&nbsp;" . $grades[$i] . "</div></td>";
            } else {
                echo "<td>-</td>";
            }
            if (isset($positions[$i])) {
                echo "<td><div style='width: " . $positions[$i] / max($positions) * 100 . "%;'>&nbsp;&nbsp;&nbsp;" . $positions[$i] . "</div></td>";
            } else {
                echo "<td>-</td>";
            }
            if (isset($position_limits[$i])) {
                echo "<td><div style='width: " . $position_limits[$i] / max($position_limits) * 100 . "%;'>&nbsp;&nbsp;&nbsp;" . $position_limits[$i] . "</div></td>";
            } else {
                echo "<td>-</td>";
            }
            echo "</tr>";
        }
        if ($i > 0) {
            echo "</td></tr></table>";
        }

        ?>
    </div>
</div>



<?php

include("footer.php");
