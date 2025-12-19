<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM accounts WHERE id = ?");
$stmt->execute([$id]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    echo "Account not found.";
    exit;
}


$clients = $pdo->query("SELECT id, full_name FROM clients")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $client_id = $_POST['client_id'];
    $type = $_POST['type'];
    $balance = $_POST['balance'];

    $stmt = $pdo->prepare("UPDATE accounts SET client_id = ?, type = ?, balance = ? WHERE id = ?");
    $stmt->execute([$client_id, $type, $balance, $id]);

    header("Location: list_accounts.php");
    exit();
}
?>

<h1>Edit Account</h1>
<form method="post">
    <label>Client:</label>
    <select name="client_id" required>
        <?php foreach ($clients as $client): ?>
            <option value="<?= $client['id'] ?>" <?= $client['id'] == $account['client_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($client['full_name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br><br>

    <label>Type:</label>
    <input type="text" name="type" value="<?= htmlspecialchars($account['type']) ?>" required><br><br>

    <label>Balance:</label>
    <input type="number" name="balance" value="<?= htmlspecialchars($account['balance']) ?>" required><br><br>

    <button type="submit">Update Account</button>
</form>

