<?php
require_once "../includes/auth.php";  


require_login();

echo "<h2>Dashboard Test</h2>";
echo "<p>Logged in as: " . $_SESSION['username'] . "</p>";
echo '<a href="/auth/logout.php">Logout</a>';
?>

