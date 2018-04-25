<?php
session_start();
include ("config/database.php");

if ($_POST["password"] == "" || $_POST["old"] == "" || $_POST["submit"] != "OK") {
	?>
	<script type="text/javascript">
		alert("All fields must be filled!");
		window.location.href = 'edit_profile.php';
	</script>
	<?php
}
else
{
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $result = $db->prepare("SELECT password FROM users WHERE login = :login");
	$result->execute(['login' => $_SESSION['user']]);
	$check_pass = $result->fetchColumn();
	if (hash('whirlpool', $_POST['old']) != $check_pass) {
		?>
		<script type="text/javascript">
			alert("Your passwords don't match!");
			window.location.href = 'edit_profile.php';
		</script>
	<?php
	}
	else if (hash('whirlpool', $_POST['old']) == $check_pass){
		if (preg_match("/[1-9]/", $_POST["password"]) == 0 || preg_match("/[A-Z]/", $_POST["password"]) == 0 || strlen($_POST["password"]) < 6) {
			?>
			<script type="text/javascript">
				alert("Your password must have at least one digit, one uppercase letter, and be at least 6 characters long!");
				window.location.href = 'edit_profile.php';
			</script>
			<?php
		}
		else {
			$stmt = $db->prepare("UPDATE users SET password = :password WHERE login = :login");
	        $stmt->execute(['password' => hash("whirlpool", $_POST["password"]), 'login' => $_SESSION['user']]);
	        ?>
	        <p>Your password was successfully changed. You can use your new password to log in.</p>
	        <?php session_destroy();?>
	        <script type="text/javascript">
				setTimeout("location.href = 'index.php';",2000);
			</script>
			<?php
		}
	}
}
?>