$mysqli = new mysqli(getenv("DB_HOST"), getenv("DB_USER"), getenv("DB_PASS"), getenv("DB_NAME"));
$subdomain = preg_replace('/[^a-z0-9\-]/', '', strtolower($_POST['subdomain']));
$title = $_POST['title'];
$content = $_POST['content'];

$stmt = $mysqli->prepare("INSERT INTO pages (subdomain, title, content) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $subdomain, $title, $content);
$stmt->execute();

file_put_contents("pages/{$subdomain}.php", "<h1>$title</h1><p>$content</p>");
header("Location: http://{$subdomain}.rootedinfra.com/pages/{$subdomain}.php");