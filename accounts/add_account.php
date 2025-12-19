<?php

require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";


$clients_stmt = $pdo->query("SELECT id, full_name FROM clients ORDER BY full_name");
$clients = $clients_stmt->fetchAll(PDO::FETCH_ASSOC);

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $client_id = $_POST['client_id'];
    $account_type = $_POST['account_type'];
    $balance = floatval($_POST['balance']);
	
    if (!is_numeric($balance)) {
    	die("Balance must be numeric");
    }    
	
    $balance = (float) $balance;

    if (abs($balance) >= 120023957483832756) {
    	die("Blance exceeds allowed limit");
    }

    $account_number = uniqid("ACC-");
    
    $stmt = $pdo->prepare("INSERT INTO accounts (client_id,account_number, type, balance) VALUES (?, ?, ?, ?)");
    $stmt->execute([
	    $client_id,
	    $account_number, 
	    $account_type, 
	    $balance]);
    
    header("Location: list_accounts.php");
    exit;
}
?>

<h1>Add Bank Account</h1>

<form method="post" action="add_account.php">
    <label>Client:</label><br>
    <select name="client_id" required>
        <option value="">-- Select Client --</option>
        <?php foreach ($clients as $client): ?>
            <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['full_name']) ?></option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Account Type:</label><br>
    <select name="account_type" required>
        <option value="savings">Savings</option>
        <option value="current">Current</option>
    </select><br><br>

    <label>Initial Balance:</label><br>
    <input type="number" name="balance" step="0.01" min="0" required><br><br>

    <button type="submit">Create Account</button>
</form>
