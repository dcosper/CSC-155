<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); guest_only(); head("Sign up"); ?>

<?php
if (keys_exist($_POST, ["username", "email", "password", "confirm_password"])) {
	$username = $_POST["username"];
	$email = $_POST["email"];
	$password = $_POST["password"];
	$confirm_password = $_POST["confirm_password"];

	$success = true;
	if ($password != $confirm_password) {
		echo_error("Passwords don't match!");
		$success = false;
	}
	if (strlen($username) < 2) {
		echo_error("Username must be longer than 2 characters!");
		$success = false;
	}
	if (strlen($username) > 255) {
		echo_error("Username must be less than 255 characters!");
		$success = false;
	}
	if (strlen($password) < 4) {
		echo_error("Password must be longer than 4 characters!");
		$success = false;
	}

	if ($success) {
		$hashed_password = password_hash($password, PASSWORD_BCRYPT);
		if (!$hashed_password) {
			echo_error("Failed to set password!");
		} else {
			$username = sanitize_username($username);

			$conn = connect_to_db();
			$template = $conn->prepare("INSERT INTO final_users (username, email, password, item1, item2, item3, item4) VALUES (?,?,?,0,0,0,0)");
			$template->bind_param("sss", $username, $email, $hashed_password);

			if (!$template->execute()) {
				if (user_exists($conn, $username)) {
					echo_error("Username is taken!");
				} else {
					echo_error("Failed to add user to database!");
				}
			} else {
				$_SESSION["username"] = $username;
				$_SESSION["role"] = ROLE_USER;
				$_SESSION["items"] = array(0, 0, 0, 0);
				redirect("index.php");
			}
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

<a href="login.php">< Log into an existing account</a>
<br>
<br>
<form method="POST">
	<table>
		<tr>
			<td><label for="username">Username:</label>
			<td><input <?php echo_default("username") ?> type="text" maxlength="255" required autocomplete="on" id="username" name="username"></td>
		</tr>
		<tr>
			<td><label for="email">Email:</label>
			<td><input <?php echo_default("email") ?> type="email" required autocomplete="on" id="email" name="email"></td>
		</tr>
		<tr>
			<td><label for="password">Password:</label>
			<td><input <?php echo_default("password") ?> type="password" required id="password" name="password"></td>
		</tr>
		<tr>
			<td><label for="confirm_password">Confirm Password:</label>
			<td><input <?php echo_default("confirm_password") ?> type="password" required id="confirm_password" name="confirm_password"></td>
		</tr>
	</table>
	<br>
	<input type="submit" value="Sign up">
</form>
