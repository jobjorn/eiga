		<div class="container">
			<hr>

			<footer>
				<p>Jobjörn Folkesson - <a href="https://twitter.com/jobjorn">@jobjorn</a> - <a href="http://www.jobjorn.se/">jobjorn.se</a></p>
				<pre><?php

						print_r(json_decode($_COOKIE['logged_in_user']));
						var_dump($logged_in);
						print_r($_COOKIE);
						?></pre>
			</footer>
		</div> <!-- /container -->


		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


		</body>

		</html>