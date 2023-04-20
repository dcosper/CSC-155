<header>
	<a href="index.php"><h1>The Coolest Site</h1></a>
	<?php
	if (isset($_SESSION["username"])) {
		echo "<p>Logged in as: {$_SESSION["username"]}</p>";
		echo "<a href='?logout=1'>Log out</a>";
	}
	?>
	<hr>
</header>
