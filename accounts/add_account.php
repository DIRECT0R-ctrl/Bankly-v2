<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

// Fetch clients to associate account with
$clients_stmt = $pdo->query("SELECT id, full_name FROM clients ORDER BY full_name");
$clients = $clients_stmt->fetchAll(PDO::FETCH_ASSOC);

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $client_id = $_POST['client_id'];
    $account_type = $_POST['account_type'];
    $balance = floatval($_POST['balance']);

    // Insert new account
    $stmt = $pdo->prepare("INSERT INTO accounts (client_id, type, balance) VALUES (?, ?, ?)");
    $stmt->execute([$client_id, $account_type, $balance]);

    // Redirect to account list
    header("Location: list_accounts.php");
    exit;
}
?>
