<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); head("CSC-155 semester project"); ?>

<p>Welcome to my humble abode.</p>

<?php
if (isset($_SESSION["username"])) {
	echo "<p>Logged in as: {$_SESSION["username"]}</p>";
	echo "<a href='?logout=1'>Log out</a>";
} else {
	echo "<a href='login.php'>Log in</a>";
	echo "<br>";
	echo "<a href='signup.php'>Sign up</a>";
}
?>
