<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$stmt = $pdo->query("
    SELECT a.id, a.type, a.balance, c.full_name AS client_name
    FROM accounts a
    JOIN clients c ON a.client_id = c.id
");
$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Accounts</h1>
<a href="add_account.php">+ Add Account</a>

<table border="1">
    <tr>
        <th>Client</th>
        <th>Type</th>
        <th>Balance</th>
        <th>Actions</th>
    </tr>

    <?php foreach ($accounts as $account): ?>
        <tr>
            <td><?= htmlspecialchars($account['client_name']) ?></td>
            <td><?= htmlspecialchars($account['type']) ?></td>
            <td><?= htmlspecialchars($account['balance']) ?></td>
            <td>
                <a href="edit_account.php?id=<?= $account['id'] ?>">Edit</a> |
                <a href="delete_account.php?id=<?= $account['id'] ?>"
                   onclick="return confirm('Delete this account?')">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

