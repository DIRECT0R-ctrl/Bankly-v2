<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: list_clients.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM clients WHERE id = ?");
$stmt->execute([$id]);

header("Location: list_clients.php");
exit;

