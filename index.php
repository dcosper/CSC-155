<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); head("CSC-155 semester project"); ?>

<?php
if (isset($_POST["reset"])) {
	delete_cookie("nickname");
	redirect("index.php");
} else if (isset($_POST["nickname"])) {
	setcookie("nickname", htmlspecialchars($_POST["nickname"]), time() + (86400 * 30), "/");
	redirect("index.php");
}
?>

<p>Welcome to my humble abode.</p>

<?php
if (isset($_SESSION["username"])) {
	$name = current_name();
	$default_nickname = optional_default($_COOKIE, "nickname");
	echo "<p>Logged in as: $name | <a href='logout.php'>Log out</a></p>";
	echo "<form method='POST'>
	<input $default_nickname name='nickname' type='text'>
	<input type='submit' value='Set Nickname'>
	<input type='submit' name='reset' value='Clear Nickname'>
	</form>";
} else {
	echo "<a href='login.php'>Log in</a>";
	echo "<br>";
	echo "<a href='signup.php'>Sign up</a>";
}
?>
