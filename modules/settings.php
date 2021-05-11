<?php


include("core.php");

$active['settings'] = 'class="active"';


$page_title = "Settings";
include("header.php");



?>
<div class="container">
    <div class="col-md-12">
        <h1>Settings</h1>
        <pre><?php print_r($logged_in_user); ?></pre>
        <p>Enter position limits below - one per row. Suggestions below (normal distributions).</p>
        <form action="<?php echo $root_uri; ?>do_settings" method="post">
            <p><textarea name="position-limits" id="position-limits" style="width: 100%;"><?php echo json_decode($logged_in_user->settings); ?></textarea></p>
            <p><input type="submit" value="Submit"></p>
        </form>
    </div>
    <?php

    $sql = "SELECT COUNT(*) as total FROM eiga_grades WHERE user_id = :user_id";
    $statement = $dbh->prepare($sql);
    $statement->bindParam(":user_id", $logged_in_user->id);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_OBJ);
    $total = $result[0]->total;

    $maxes = array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
    $i = 0;
    foreach ($maxes as $max) {
        $i++;
        if ($i == 1) {
            echo "<table id='position-limits'><tr>";
        }
        echo "<td>";
        echo "<h3>" . $max . "</h3>";
        for ($i2 = 1; $i2 <= $max; $i2++) {
            echo distribution_count($i2, $total, $max);
            echo "<br>";
        }
        echo "</td>";
    }
    if ($i > 0) {
        echo "</tr></table>";
    }
    ?>
</div>



<?php


include("footer.php");
