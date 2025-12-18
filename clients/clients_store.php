<?php
require_once "../includes/auth.php";
require_login();
require_once "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: list_clients.php");
    exit;
}

$name = $_POST['full_name'];
$email = $_POST['email'];
$cin = $_POST['cin'];

$stmt = $pdo->prepare(
    "INSERT INTO clients (full_name, email, cin) VALUES (?, ?, ?)"
);
$stmt->execute([$name, $email, $cin]);

header("Location: list_clients.php");
exit;


