<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch();

if (!$client) {
    die("Client not found");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $stmt = $pdo->prepare(
        "UPDATE clients SET full_name = ?, email = ?, cin = ? WHERE id = ?"
    );
    $stmt->execute([
        $_POST['full_name'],
        $_POST['email'],
        $_POST['cin'],
        $id
    ]);

    header("Location: list_clients.php");
    exit;
}
?>

<h1>Edit Client</h1>

<form method="post">
    <input name="full_name" value="<?= htmlspecialchars($client['full_name']) ?>" required>
    <input name="email" type="email" value="<?= htmlspecialchars($client['email']) ?>" required>
    <input name="cin" value="<?= htmlspecialchars($client['cin']) ?>" required>
    <button>Save</button>
</form>

