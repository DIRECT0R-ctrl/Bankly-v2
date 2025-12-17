<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../includes/auth.php";
require_login();

require_once "../includes/db.php";

$stmt = $pdo->query("SELECT COUNT(*) FROM clients");
$total_clients = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM accounts");
$total_accounts = $stmt->fetchcolumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM transactions");
$total_transactions = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang=en>

<head>
	<meta charset="UTF-8">
	<title>DashBoard - Bankly V2</title>
	<link rel="stylesheet" href="/public/css/style.css">
</head>
<body>
	<h1>Bankly V2 Dashboard</h1>

	<p>Welcome, <Strong><?php echo htmlspecialchars($_SESSION['username']);?><Strong></p>
	
	
</body>
