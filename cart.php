<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); require_role(ROLE_USER); head("Your cart"); ?>

<?php
function handle_form() {
	if (!isset($_POST["action"])) {
		return;
	}

	$action = $_POST["action"];
	if ($action == "Empty Cart") {
		empty_cart();
	} elseif ($action == "Checkout") {
		if (!has_items_in_cart()) {
			echo_error("You don't have anything in your cart!");
			return;
		}
		$db = connect_to_db();
		$statement = $db->prepare("INSERT INTO final_checkout (user_id, item1, item2, item3, item4, checkout_date) VALUES (?,?,?,?,?,NOW())");
		$statement->bind_param("iiiii", $_SESSION["id"], $_SESSION["items"][0], $_SESSION["items"][1], $_SESSION["items"][2], $_SESSION["items"][3]);
		if (!$statement->execute()) {
			echo_error("Failed to insert order into database!");
			return;
		}
		empty_cart();
	}

	refresh_page();
}
handle_form();
?>

<form method="POST">
<table>
	<tr>
		<td><div class="itemcontainer">
			<a <?php echo "href='https://wiki.factorio.com/Automation_science_pack'" ?>>
				<img class="itemimage" width=36 height=36 <?php echo "src='images/Automation_science_pack.png' alt='Automation science pack'" ?>>
			</a>
			<div class="itemtext"><?php echo $_SESSION["items"][0] ?></div>
		</div></td>
		<td><div class="itemcontainer">
			<a <?php echo "href='https://wiki.factorio.com/Logistic_science_pack'" ?>>
				<img class="itemimage" width=36 height=36 <?php echo "src='images/Logistic_science_pack.png' alt='Logistic science pack'" ?>>
			</a>
			<div class="itemtext"><?php echo $_SESSION["items"][1] ?></div>
		</div></td>
		<td><div class="itemcontainer">
			<a <?php echo "href='https://wiki.factorio.com/Chemical_science_pack'" ?>>
				<img class="itemimage" width=36 height=36 <?php echo "src='images/Chemical_science_pack.png' alt='Chemical science pack'" ?>>
			</a>
			<div class="itemtext"><?php echo $_SESSION["items"][2] ?></div>
		</div></td>
		<td><div class="itemcontainer">
			<a <?php echo "href='https://wiki.factorio.com/Production_science_pack'" ?>>
				<img class="itemimage" width=36 height=36 <?php echo "src='images/Production_science_pack.png' alt='Production science pack'" ?>>
			</a>
			<div class="itemtext"><?php echo $_SESSION["items"][3] ?></div>
		</div></td>
	</tr>
	<tr>
		<td colspan=4 style="text-align:center;">
			<input type="submit" name="action" value="Checkout">
			<input type="submit" name="action" value="Empty Cart">
		</td>
	</tr>
</table>
</form>
