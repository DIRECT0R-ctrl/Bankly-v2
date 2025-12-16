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

