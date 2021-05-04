<?php
include("core.php");

$active['log'] = 'class="active"';

$page_title = "Log";

include("header.php");

// echo "<pre>"; print_r($login); echo "</pre>";
?>
<div class="container">
	<div class="col-md-12">
		<h1>Latest duels</h1>
		<?php

		$position = 0;

		$sql = "SELECT * FROM eiga_duels WHERE user_id = :user_id ORDER BY timestamp DESC";
		$statement = $dbh->prepare($sql);
		$statement->bindParam(":user_id", $logged_in_user->id);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_OBJ);
		$i = 0;
		$i2 = 0;
		foreach ($result as $duel) {
			$i++;
			if ($i == 1) {
				echo "<table class='table-striped' id='log'>";
				echo "<tr>";
				echo "<th>Timestamp</th><th class='winner'>Winner</th><th>&nbsp;</th><th>Loser</th><th>&nbsp;</th>";
				echo "</tr>";
			}
			echo "<tr>";
			echo "<td>";
			echo $duel->timestamp;
			echo "</td>";
			echo "<td class='winner'>";
			$movie_details = get_movie($duel->winner);
			echo "<a href='" . $movie_details->url . "'>" . $movie_details->title . " (" . $movie_details->year . ")</a>";
			echo "</td>";
			echo "<td>&gt;</td>";
			echo "<td class='loser'>";
			$movie_details = get_movie($duel->loser);
			echo "<a href='" . $movie_details->url . "'>" . $movie_details->title . " (" . $movie_details->year . ")</a>";

			echo "</td>";
			echo "<td><a href='" . $root_uri . "do_delete/" . $duel->id . "/'>❌</a></td>";
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
