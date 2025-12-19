<?php 
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$accounts_stmt = $pdo->query("SELECT id, account_number, balance FROM accounts ORDER BY account_number");
$accounts = $accounts_stmt->fetchAll(PDO::FETCH_ASSOC);


$message = '';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$account_id = $_POST['account_id'];
	$amount = (float) $_POST['amount'];

	$type = $_POST['type']; // khrj / dkhl
	
	if (!is_numeric($amount) || $amount <= 0) {
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
		} else {
            
            		$new_balance = $type === 'deposit' ? $current_balance + $amount : $current_balance - $amount;

            		// Start transaction (DB-level)
            		$pdo->beginTransaction();

            		try {
               	 		$update = $pdo->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
                		$update->execute([$new_balance, $account_id]);

                		$insert = $pdo->prepare("INSERT INTO transactions (account_id, amount, type) VALUES (?, ?, ?)");
                		$insert->execute([$account_id, $amount, $type]);

                		$pdo->commit();
                		$message = "Transaction successful";

            		} catch (Exception $e) {
                		$pdo->rollBack();
                		$message = "Transaction failed: " . $e->getMessage();
            		}
        	}
    	}
}
?>


<?php 
require_once "../templates/header.php";
?>

<h1>Make Transaction</h1>

<?php if ($message): ?>
    <p><?= htmlspecialchars($message) ?></p>
<?php endif; ?>

<form method="post" action="make_transaction.php">
    <label>Account:</label><br>
    <select name="account_id" required>
        <option value="">-- Select Account --</option>
        <?php foreach ($accounts as $account): ?>
            <option value="<?= $account['id'] ?>">
                <?= htmlspecialchars($account['account_number']) ?> (Balance: <?= $account['balance'] ?>)
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Type:</label><br>
    <select name="type" required>
        <option value="deposit">Deposit</option>
        <option value="withdraw">Withdraw</option>
    </select><br><br>

    <label>Amount:</label><br>
    <input type="number" name="amount" step="0.01" min="0.01" required><br><br>

    <button type="submit">Submit</button>
</form>

<br>

<nav>
    <a href="/dashboard/dashboard.php">Dashboard</a> |
    <a href="/clients/list_clients.php">Clients</a> |
    <a href="/accounts/list_accounts.php">Accounts</a> |
    <a href="/transactions/make_transaction.php">make a transactions</a> |
    <a href="/auth/logout.php">Logout</a>
</nav>
<?php
require_once "../templates/footer.php";
?>

