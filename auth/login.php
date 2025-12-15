<?php
require_once "../includes/db.php";
require_once "../includes/auth.php";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);


	$stmt = $pdo->prepare("SELECT * users WHERE username = :username");

}
?>
