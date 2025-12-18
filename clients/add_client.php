<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);



require_once "../includes/auth.php";
require_login();

?>

<h1>Add Client</h1>
<form method='post' action='clients_store.php'>
	<input type="text" name="full_name" placeholder="Full name" required>
	<input type="email" name="email" placeholder="Email" required>
	<input type="text" name="cin" placeholder="CIN" required>
	<button type="submit"></button>
</form>
