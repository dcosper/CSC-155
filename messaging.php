<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); require_role(ROLE_USER); head("Messaging"); ?>

<?php
$db = connect_to_db();

function handle_form() {
	global $db;
	if (!keys_exist($_POST, ["recipient", "message"])) {
		return;
	}

	$recipient_name = $_POST["recipient"];
	$message = htmlspecialchars($_POST["message"]);

	if (strlen($message) > 255) {
		echo_error("Message is too long!");
		return;
	}

	$recipient = get_user($db, sanitize_username($recipient_name));
	if (!$recipient) {
		echo_error("User not found!");
		return;
	}

	$statement = $db->prepare("INSERT INTO final_messages (message, from_user, to_user, send_date) VALUES (?,?,?,NOW())");
	$statement->bind_param("sii", $message, $_SESSION["id"], $recipient["id"]);
	$statement->execute();
}

handle_form();
?>

<form method="POST">
	<label for="recipient">To:</label>
	<input type="text" id="recipient" name="recipient">
	<br>
	<label for="message">Message:</label>
	<br>
	<textarea id="message" name="message" rows=5 cols=50></textarea>
	<br>
	<input type="submit" value="Send Message">
</form>
<hr>
<?php
$statement = $db->prepare("SELECT * FROM final_messages WHERE to_user=? OR from_user=?");
$statement->bind_param("ii", $_SESSION["id"], $_SESSION["id"]);
$statement->execute();
$result = $statement->get_result();
?>

<?php
while ($row = $result->fetch_assoc()):
	if ($row["from_user"] == $_SESSION["id"]):
?>

<p><b>To:</b> <?= username_from_id($db, $row["to_user"]); ?> | <?= $row["send_date"] ?></p>

<?php else: ?>

<p><b>From:</b> <?= username_from_id($db, $row["from_user"]); ?> | <?= $row["send_date"] ?></p>

<?php endif; ?>

<blockquote><?= $row["message"] ?></blockquote>
<?php endwhile; ?>
