<?php declare(strict_types=1); ?>

<!DOCTYPE html>
<html lang='en-us'>
<head>
	<meta charset='UTF-8' />
	<meta name='viewport' content='width=device-width, initial-scale=1.0' />
	<link href='library/style.css' rel='stylesheet' />

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

function sanitize_username(string $username): string {
	return htmlentities($username);
}

function new_user(mysqli $db, string $username) {

}

function redirect(string $url) {
	header("Location: $url");
}

function head(string $title, string $extra="") {
	echo "\t<title>$title</title>\n";
	if (strlen($extra) > 0) {
		echo "\t$extra\n";
	}
	echo "</head>\n";
	echo "<body>\n";
	readfile("library/header.html");
}

function footer() {
	readfile('library/footer.html');
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

function user_exists(mysqli $conn, string $username): bool {
	$statement = $conn->prepare("SELECT * FROM final_users WHERE username=?");
	$statement->bind_param("s", $username);
	$statement->execute();
	$result = $statement->get_result();
	
	return $result->num_rows > 0;
}

function logout(): void {
	session_unset();
	session_destroy();
	redirect("index.php");
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
?>
