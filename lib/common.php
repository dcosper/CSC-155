<?php declare(strict_types=1); ?>

<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->

<!DOCTYPE html>
<html lang='en-us'>
<head>
	<meta charset='UTF-8' />
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<link href='lib/style.css' rel='stylesheet' />

<?php
define("ROLE_GUEST", 0);
define("ROLE_USER", 1);
define("ROLE_ADMIN", 2);

function keys_exist(array $array, array $keys): bool {
	return !array_diff($keys, array_keys($array));
}

function connect_to_db(): mysqli {
    $server = "localhost";
    $username = "dcosper1";
    $password = "dcosper1";
    $dbname = "dcosper1";
    $conn = new mysqli($server, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function echo_error(string $msg): void {
	echo "<p class='error'>$msg</p>";
}

function get_user(mysqli $db, string $sanitized_username) {
	$sanitized_username = $db->escape_string($sanitized_username);

	$result = $db->query("SELECT * FROM final_users WHERE username='$sanitized_username'");
	if ($result->num_rows == 1) {
		return $result->fetch_assoc();
	} else {
		return false;
	}
}

function current_name(): ?string {
	if (isset($_SESSION["username"])) {
		if (isset($_COOKIE["nickname"])) {
			return $_COOKIE["nickname"] . " ({$_SESSION["username"]})";
		}
		return $_SESSION["username"];
	}
}

function optional_default($table, $key): string {
	if (isset($table[$key])) {
		return "value='{$table[$key]}'";
	}
	return "";
}

function delete_cookie(string $name) {
	setcookie($name, "", -1, "/");
}

function sanitize_username(string $username): string {
	return htmlentities($username);
}

function redirect(string $url) {
	header("Location: $url");
}

function refresh_page() {
	header("Refresh: 0");
}

function set_item_count(float $index, float $count) {
	$_SESSION["items"][$index] = $count;

	$index = $index + 1;
	$column = "item$index";

	$db = connect_to_db();
	$statement = $db->prepare("UPDATE final_users SET $column = ? WHERE username = ?");
	$statement->bind_param("is", $count, $_SESSION["username"]);
	if (!$statement->execute()) {
		echo_error("Failed to update database!");
	}
}

function head(string $title, string $extra="") {
	echo "\t<title>$title</title>\n";
	if (strlen($extra) > 0) {
		echo "\t$extra\n";
	}
	echo "</head>\n";
	echo "<body>\n";
	require("lib/header.php");
}

function footer() {
	readfile('lib/footer.html');
}

function require_role(int $role) {
	if ($_SESSION["role"] < $role) {
		redirect("index.php");
	}
}

function guest_only() {
	if ($_SESSION["role"] > ROLE_GUEST) {
		redirect("index.php");
	}
}

function str_ends_with(string $haystack, string $needle): bool {
	$length = strlen( $needle );
	if( !$length ) {
		return true;
	}
	return substr( $haystack, -$length ) === $needle;
}

function user_exists(mysqli $conn, string $username): bool {
	$statement = $conn->prepare("SELECT * FROM final_users WHERE username=?");
	$statement->bind_param("s", $username);
	$statement->execute();
	$result = $statement->get_result();
	
	return $result->num_rows > 0;
}

$USERNAMES = array();
function username_from_id(mysqli $db, float $id): ?string {
	global $USERNAMES;
	if (isset($USERNAMES[$id])) {
		return $USERNAMES[$id];
	}
	$result = $db->query("SELECT username FROM final_users WHERE id=$id");
	$username = $result->fetch_assoc()["username"];
	$USERNAMES[$id] = $username;
	return $username;
}

function id_from_username(mysqli $db, string $sanitized_username): ?float {
	$statement = $db->prepare("SELECT id FROM final_users WHERE username=?");
	$statement->bind_param("s", $sanitized_username);
	$statement->execute();
	$result = $statement->get_result();
	return $result->fetch_assoc()["id"];
}

function has_items_in_cart(): bool {
	for ($i = 0; $i < 4; $i++) {
		if ($_SESSION["items"][$i] > 0) {
			return true;
		}
	}
	return false;
}

function empty_cart() {
	for ($i = 0; $i < 4; $i++) {
		set_item_count($i, 0);
	}
}

function is_being_run(): bool {
	return __FILE__ == $_SERVER["SCRIPT_FILENAME"];
}
if (is_being_run()) {
	redirect("/");
}

function init_session() {
	session_start();
	$_SESSION["role"] = $_SESSION["role"] ?? ROLE_GUEST;
}
init_session();

if (isset($_GET["logout"])) {
	redirect("logout.php");
}
?>
