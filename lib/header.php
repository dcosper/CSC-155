<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php
function echo_navbar_page(string $url, string $title, float $role = ROLE_GUEST) {
	if ($_SESSION["role"] >= $role) {
		echo "<li><a href='$url'>$title</a></li>";
	}
}
?>

<header>
	<a href="index.php"><h1>The Coolest Site</h1></a>
	<?php
	if (isset($_SESSION["username"])) {
		echo "<p>";
		echo "Logged in as: {$_SESSION["username"]}";
		echo "<br>";
		echo "<a href='?logout=1'>Log out</a>";
		echo "</p>";
	}
	?>
	<ul class="navbar">
		<?php echo_navbar_page("index.php", "Home") ?>
		<?php echo_navbar_page("users.php", "Users", ROLE_USER) ?>
		<?php echo_navbar_page("shop1.php", "Item 1", ROLE_USER) ?>
		<?php echo_navbar_page("shop2.php", "Item 2", ROLE_USER) ?>
		<?php echo_navbar_page("shop3.php", "Item 3", ROLE_USER) ?>
		<?php echo_navbar_page("shop4.php", "Item 4", ROLE_USER) ?>
		<?php echo_navbar_page("cart.php", "Cart", ROLE_USER) ?>
	</ul>
	<hr>
</header>
