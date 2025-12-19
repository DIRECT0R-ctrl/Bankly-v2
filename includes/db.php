<?php
$host = "127.0.0.1";
$dbname = "bankly";
$user = "bankly_user";
$password = "bankly_pass";

try {
	$pdo = new PDO(
		// data source name
		"pgsql:host=$host;dbname=$dbname",
		$user,
		$password
	);

	$pdo->setAttribute(
		PDO::ATTR_ERRMODE, 
		PDO::ERRMODE_EXCEPTION
	);
} catch (PDOException $exception){
	die("Dtabase connection failed : " . $exception->getMessage());
}
?>
