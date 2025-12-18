<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "../includes/auth.php";
require_login();

require_once "../includes/db.php";

$stmt = $pdo->query("SELECT COUNT(*) FROM clients");
$total_clients = $stmt->fetchColumn();
$stmt = $pdo->query("SELECT COUNT(*) FROM accounts");
$total_accounts = $stmt->fetchColumn();
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

	<p>Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']);?><strong></p>
	
	<hr>
	

	<h2>Quick State</h2>

	<ul>
		<li>Total Clients : <strong><?php echo $total_clients;?></strong></li>
		<li>ToTal_accounts : <strong><?php echo $total_accounts;?></strong></li>
		<li>total_transactions : <strong><?php echo $total_transactions?></strong></li>
	</ul>	


	<nav>
    		<a href="/clients/list_clients.php">Clients</a> |
    		<a href="/accounts/list_accounts.php">Accounts</a> |
    		<a href="/transactions/list_transactions.php">Transactions</a> |
    		<a href="/auth/logout.php">Logout</a>
	</nav>
</body>
