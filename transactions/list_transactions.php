<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";


$accounts_stmt = $pdo->query("
    SELECT id, account_number 
    FROM accounts 
    ORDER BY account_number
");
$accounts = $accounts_stmt->fetchAll(PDO::FETCH_ASSOC);


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
<?php require_once "../templates/header.php";
?>

<h1>Transaction History</h1>

<nav>
    <a href="/dashboard/dashboard.php">Dashboard</a> |
    <a href="/clients/list_clients.php">Clients</a> |
    <a href="/accounts/list_accounts.php">Accounts</a> |
    <a href="/transactions/make_transaction.php">make a transactions</a> |
    <a href="/auth/logout.php">Logout</a>
</nav>

<hr>

<form method="get">
    <label>Select Account:</label>
    <select name="account_id" required>
        <option value="">-- Choose Account --</option>
        <?php foreach ($accounts as $account): ?>
            <option value="<?= $account['id'] ?>"
                <?= ($selected_account == $account['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($account['account_number']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Filter</button>
</form>

<hr>

<?php if ($selected_account): ?>
    <?php if (count($transactions) === 0): ?>
        <p>No transactions found for this account.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Account</th>
                <th>Type</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>

            <?php foreach ($transactions as $tx): ?>
                <tr>
                    <td><?= htmlspecialchars($tx['account_number']) ?></td>
                    <td><?= htmlspecialchars($tx['type']) ?></td>
                    <td><?= htmlspecialchars($tx['amount']) ?></td>
                    <td><?= htmlspecialchars($tx['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php else: ?>
    <p>Please select an account to view transactions.</p>
<?php endif; ?>

<?phprequire_once "../templates/footer.php";
?>

