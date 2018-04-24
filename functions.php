<?php

	session_start();
	include_once('config/database.php');

function validate_log($login) {
	$db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	// if ($login == "")
	// {
		?>
		<!-- <script type="text/javascript">
			alert("Login field cannot be empty!");
			window.location.href = 'index.php';
		</script> -->
		<?php
	// 	return false;
	// }
	// var_dump($stmt);
	$result = $db->prepare("SELECT COUNT(login) FROM users WHERE login = :login");
	$result->execute(['login' => $login]);
	$number_of_rows = $result->fetchColumn(); 
	var_dump($number_of_rows);
	// var_dump($stmt);
	// foreach ($stmt as $post) {
	// 	echo $post['password'].'<br>';
	// }
	// // else
	return true;
}

?>