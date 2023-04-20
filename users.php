<?php require("library/common.php"); require_role(ROLE_USER); head("Users"); ?>

<table>
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
