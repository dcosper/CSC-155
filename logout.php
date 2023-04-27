<!--  I honor Parkland's core values by affirming that I have 
followed all academic integrity guidelines for this work.
Dylan Cosper
CSC-155-001DR_2023SP -->
<?php require("lib/common.php"); head("Log out"); ?>

<?php
session_unset();
session_destroy();
delete_cookie("nickname");
?>

<script>
window.setTimeout(function() {
	window.location.href = "index.php";
}, 5000)
</script>

<p>Goodbye!</p>
<p>Please wait to be redirected...</p>
