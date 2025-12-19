<?php 
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$accounts_stmt = $pdo->query("SELECT id, account_number, balance FROM accounts ORDER BY account_number");
$accounts = $accounts_stmt->fetchAll(PDO::FETCH_ASSOC);


$message = '':

if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$account_id = $_POST['account_id'];
	$amount = (float) $_POST['amount'];

	$type = $_POST['type']; // khrj / dkhl
	
	if (!is_numeric($amount)) || $amount <= 0 {
		$message = "Invalid amount";
	} else {
		$stmt = $pdo->prepare("SELECT balance FROM accounts WHERE id = ?");
		$stmt->execute([$account_id]);
		$account = $stmt->fetch(PDO::FETCH_ASSOC);

		if (!$account) {
			die("Account not found");
		}

		$currect_balance = (float) $account['balance'];

		if ($type === 'withdraw' && $amount > $current_balance) {
			$message = "Insufficient balance";
		} 
	} 
}
?>
