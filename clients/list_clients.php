<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$clients = $pdo->query(
    "SELECT id, full_name, email FROM clients ORDER BY id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Clients</h1>
<a href="add_client.php">+ Add Client</a>

<table border="1">
<tr>
    <th>Name</th>
    <th>Email</th>
    <th>Actions</th>
</tr>

<?php foreach ($clients as $client): ?>
<tr>
    <td><?= htmlspecialchars($client['full_name']) ?></td>
    <td><?= htmlspecialchars($client['email']) ?></td>
    <td>
        <a href="edit_client.php?id=<?= $client['id'] ?>">Edit</a> |
        <a href="delete_client.php?id=<?= $client['id'] ?>"
           onclick="return confirm('Delete this client?')">Delete</a>
    </td>
</tr>
<?php endforeach; ?>
</table>

