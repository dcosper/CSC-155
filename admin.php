<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); require_role(ROLE_ADMIN); head("Top secret admin area"); ?>

<?php $db = connect_to_db(); ?>

<table>
	<tr>
		<th>Registered Users</th>
	</tr>
	<?php
	$result = $db->query("SELECT username FROM final_users");
	while ($row = $result->fetch_assoc()) {
		echo "\t<tr>";
		if ($_SESSION["username"] == $row["username"]) {
			echo "\t\t<td><b>{$row["username"]}</b></td>";
		} else {
			echo "\t\t<td>{$row["username"]}</td>";
		}
		echo "\t</tr>";
	}
	?>
</table>
<br>
<table>
	<tr>
		<th colspan=7>Orders</th>
	</tr>
	<tr>
		<th>ID</th>
		<th>User</th>
		<th>Auto. Packs</th>
		<th>Log. Packs</th>
		<th>Chem. Packs</th>
		<th>Prod. Packs</th>
		<th>Order Date</th>
	</tr>
	<?php
	$result = $db->query("SELECT * FROM final_checkout");
	while ($row = $result->fetch_assoc()) {
		$username = username_from_id($db, $row["user_id"]);
		echo "\t<tr>\n";
		echo "\t\t<td>{$row["id"]}</td>\n";
		echo "\t\t<td>$username</td>\n";
		echo "\t\t<td>{$row["item1"]}</td>\n";
		echo "\t\t<td>{$row["item2"]}</td>\n";
		echo "\t\t<td>{$row["item3"]}</td>\n";
		echo "\t\t<td>{$row["item4"]}</td>\n";
		echo "\t\t<td>{$row["checkout_date"]}</td>\n";
		echo "\t</tr>\n";
	}
	?>
</table>
