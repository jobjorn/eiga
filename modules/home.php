<?php


include("core.php");

$active['home'] = 'class="active"';


$page_title = "Hem";
include("header.php");


?>
<div class="container">

	<?php

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

	$position = 0;
	$count = 0;

	$sql = "SELECT position, COUNT(position) AS count FROM eiga_grades WHERE user_id = :user_id GROUP BY position ORDER BY position ASC";
	$statement = $dbh->prepare($sql);

	$statement->bindParam(":user_id", $logged_in_user->id);
	$statement->execute();

	$result = $statement->fetchAll(PDO::FETCH_OBJ);
	foreach ($result as $position_count) {
		if (isset($position_limits[$position_count->position])) {
			if ($position_count->count > $position_limits[$position_count->position]) {
				$position = $position_count->position;
				$count = $position_count->count;
				break;
			}
		} else {
			break;
		}
	}

	if ($count > 1) {
	?>
		<div class="col-md-12">
			<h1>Vilken av dessa är bäst?</h1>
			<p>
				<?php
				echo "Du går igenom <strong>position " . $position . "</strong>. Där finns <strong>" . $count . " filmer</strong>, men max är <strong>" . $position_limits[$position] . "</strong>.";
				?>
			</p>
		</div>
		<?php
		$sql = "SELECT movie_id FROM eiga_grades WHERE user_id = :user_id1 AND position = :position ORDER BY (SELECT COUNT(*) FROM eiga_duels WHERE winner = eiga_grades.movie_id AND user_id = :user_id2), RAND() LIMIT 2";
		$statement = $dbh->prepare($sql);
		$statement->bindParam(":position", $position);
		$statement->bindParam(":user_id1", $logged_in_user->id);
		$statement->bindParam(":user_id2", $logged_in_user->id);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_OBJ);

		$movie1 = get_movie($result[0]->movie_id);
		$movie2 = get_movie($result[1]->movie_id);

		?>
		<div class="col-md-6">
			<?php

			echo "<h2>" . $movie1->title . " <small>(" . $movie1->year . ")</small></h2>";
			echo "<h4>" . show_grade($movie1->grade) . " / " . $movie1->vote_average . "</h4>";

			echo "<div class='effect2'><a id='left' href='" . $root_uri . "duel/" . $movie1->id . "/" . $movie2->id . "/" . latest_duel($logged_in_user->id) . "/'>";
			echo "<img src='" . $movie1->poster_large . "' title='" . htmlentities($movie1->title, ENT_QUOTES) . " (" . $movie1->year . ")' alt='" . htmlentities($movie1->title, ENT_QUOTES) . " (" . $movie1->year . ")' />";
			echo "</a></div>";
			echo "<p class='overview'>" . $movie1->overview . "</p>";
			echo "<div class='link_letterboxd'><a href='" . $movie1->letterboxd_uri . "'>Letterboxd</a></div>";
			echo "<div class='link_tmdb'><a href='https://www.themoviedb.org/movie/" . $movie1->tmdb_id . "'>TMDb</a></div>";

			?>
		</div>
		<div class="col-md-6">
			<?php

			echo "<h2>" . $movie2->title . " <small>(" . $movie2->year . ")</small></h2>";
			echo "<h4>" . show_grade($movie2->grade) . " / " . $movie2->vote_average . "</h4>";

			echo "<div class='effect2'><a id='right' href='" . $root_uri . "duel/" . $movie2->id . "/" . $movie1->id . "/" . latest_duel($logged_in_user->id) . "/'>";
			echo "<img src='" . $movie2->poster_large . "' title='" . htmlentities($movie2->title, ENT_QUOTES) . " (" . $movie2->year . ")' alt='" . htmlentities($movie2->title, ENT_QUOTES) . " (" . $movie2->year . ")' />";
			echo "</a></div>";
			echo "<p class='overview'>" . $movie2->overview . "</p>";
			echo "<div class='link_letterboxd'><a href='" . $movie2->letterboxd_uri . "'>Letterboxd</a></div>";
			echo "<div class='link_tmdb'><a href='https://www.themoviedb.org/movie/" . $movie2->tmdb_id . "'>TMDb</a></div>";

			?>
		</div>
	<?php
	} else {
	?>
		<div class="col-md-12">
			<h1>Slut!</h1>
			<p>Nu har du duellerat klart.</p>
		</div>
	<?php
	}
	?>
</div>

<script type="text/javascript">
	$(document).keydown(function(e) {
		switch (e.which) {
			case 37: // left
				var href = $('#left').attr('href');
				window.location.href = href;
				break;

			case 39: // right
				var href = $('#right').attr('href');
				window.location.href = href;
				break;
		}
		e.preventDefault();
	});
</script>


<?php

include("footer.php");
