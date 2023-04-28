<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); guest_only(); head("Log in"); ?>

<?php
if (keys_exist($_POST, ["username", "password"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];

	$username = sanitize_username($username);

	$db = connect_to_db();
	$user = get_user($db, $username);

	if (!$user) {
		// This would make it more secure if we didn't list usernames on the homepage...
		$wasting_time = password_verify($password, "$2y$10\$OJvTjXAW5/BZK1r3rT/1s.cgBw5CzshUy4/RWkTEPlWDW/o7I4OdC");
		echo_error("Incorrect username or password!");
	} else {
		$password_matches = password_verify($password, $user["password"]);
		if ($password_matches) {
			$_SESSION["id"] = $user["id"];
			$_SESSION["username"] = $username;
			$_SESSION["role"] = $user["admin"] == 1 ? ROLE_ADMIN : ROLE_USER;
			$_SESSION["items"] = array($user["item1"], $user["item2"], $user["item3"], $user["item4"]);
			redirect("index.php");
		} else {
			echo_error("Incorrect username or password!");
		}
	}
}
?>

<?php
function echo_default(string $key) {
	if (isset($_POST[$key])) {
		echo "value='".htmlentities($_POST[$key]) . "'";
	}
}
?>

<a href="signup.php">Create an account ></a>
<br>
<br>
<form method="POST">
	<table>
		<tr>
			<td><label for="username">Username:</label>
			<td><input <?php echo_default("username") ?> type="text" maxlength="255" required autocomplete="on" id="username" name="username"></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label>
			<td><input <?php echo_default("password") ?> type="password" required id="password" name="password"></td>
		</tr>
	</table>
	<br>
	<input type="submit" value="Log in">
</form>

<img src='https://remy.parkland.edu/~kurban/csc155-spring23/19-trackingcookie/tracker.php?opt=dcosper1'>
