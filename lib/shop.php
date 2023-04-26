<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); require_role(ROLE_USER); head($ITEM_NAME . "s"); ?>

<?php
$total = $_SESSION["items"][$ITEM_INDEX];
if (isset($_POST["action"])) {
	$action = $_POST["action"];

	$difference = 0;
	if ($action == "Add 1") {
		$difference = 1;
	} elseif ($action == "Add 10") {
		$difference = 10;
	} elseif ($action == "Remove 1") {
		$difference = -1;
	} elseif ($action == "Remove 10") {
		$difference = -10;
	}

	$total = $_SESSION["items"][$ITEM_INDEX] + $difference;
	$total = max(0, min($total, 200));
	set_item_count($ITEM_INDEX, $total);
}
?>

<?php
function disable_if_0() {
	global $total;
	if ($total <= 0) {
		echo "disabled";
	}
}
function disable_if_max() {
	global $total;
	if ($total >= 200) {
		echo "disabled";
	}
}

$maybe_s = ($total == 1) ? "" : "s";
$pluralized_name = $ITEM_NAME . $maybe_s;
?>

<div class="itemcontainer">
	<a <?php echo "href='https://wiki.factorio.com/$ITEM_ID'" ?>>
		<img class="itemimage" width=36 height=36 <?php echo "src='images/$ITEM_ID.png' alt='$ITEM_NAME'" ?>>
	</a>
	<div class="itemtext"><?php echo $total ?></div>
</div>
<p>You have <?php echo "$total $pluralized_name." ?></p>
<form method="POST">
	<input type="submit" <?php disable_if_max() ?> name="action" value="Add 1">
	<input type="submit" <?php disable_if_max() ?> name="action" value="Add 10">
	<input type="submit" <?php disable_if_0() ?> name="action" value="Remove 1">
	<input type="submit" <?php disable_if_0() ?> name="action" value="Remove 10">
</form>
