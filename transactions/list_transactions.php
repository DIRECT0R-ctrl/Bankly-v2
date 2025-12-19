<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

/* Fetch accounts for filter */
$accounts_stmt = $pdo->query("
    SELECT id, account_number 
    FROM accounts 
    ORDER BY account_number
");
$accounts = $accounts_stmt->fetchAll(PDO::FETCH_ASSOC);

/* Selected account */
$selected_account = $_GET['account_id'] ?? null;
$transactions = [];

if ($selected_account) {
    $stmt = $pdo->prepare("
        SELECT 
            t.amount,
            t.type,
            t.created_at,
            a.account_number
        FROM transactions t
        JOIN accounts a ON t.account_id = a.id
        WHERE t.account_id = ?
        ORDER BY t.created_at DESC
    ");
    $stmt->execute([$selected_account]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
