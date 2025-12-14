$host = "localhost";
$dbname = "bankly";
$user = "postgres";
$password = "postgres";

try {
	$pdo = new PDO(
		// data source name
		"pgsql:host=$host;dbname=$dbname",
	);
} catch {

}
