<?php require("library/common.php"); guest_only(); head("Log in"); ?>

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
			$_SESSION["username"] = $username;
			$_SESSION["role"] = ROLE_USER;
			redirect("index.php");
		} else {
			echo_error("Incorrect username or password!");
		}
	}
}
?>

<form method="POST">
	<table>
		<tr>
			<td><label for="username">Username:</label>
			<td><input type="text" maxlength="255" required autocomplete="on" id="username" name="username"></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label>
			<td><input type="password" required id="password" name="password"></td>
		</tr>
	</table>
	<br>
	<input type="submit" value="Log in">
</form>
