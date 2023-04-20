<?php require("library/common.php"); head("CSC-155 semester project"); ?>

<p>Welcome to my humble abode.</p>

<table class="userlist">
	<tr>
		<th>Registered Users</th>
	</tr>
	<?php
	$db = connect_to_db();
	$result = $db->query("SELECT username FROM final_users");
	while ($row = $result->fetch_assoc()) {
		echo "\t<tr>";
		if (isset($_SESSION["username"]) && $_SESSION["username"] == $row["username"]) {
			echo "\t\t<td><b>{$row["username"]}</b></td>";
		} else {
			echo "\t\t<td>{$row["username"]}</td>";
		}
		echo "\t</tr>";
	}
	?>
</table>


<?php
if (isset($_SESSION["username"])) {
	echo "<p>Logged in as: {$_SESSION["username"]}</p>";
	echo "<a href='?logout=1'>Log out</a>";
} else {
	echo "<a href='login.php'>Log in</a>";
	echo "<br>";
	echo "<a href='signup.php'>Sign up</a>";
}

if (isset($_GET["logout"])) {
	logout();
}
?>
