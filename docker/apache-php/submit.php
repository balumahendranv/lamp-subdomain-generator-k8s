<?php
$subdomain = preg_replace('/[^a-z0-9\-]/', '', strtolower($_POST['subdomain']));
$title = htmlspecialchars($_POST['title']);
$content = htmlspecialchars($_POST['content']);

// Save to database
$conn = new mysqli("localhost", "user", "password", "yourdb");
$stmt = $conn->prepare("INSERT INTO pages (subdomain, title, content) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $subdomain, $title, $content);
$stmt->execute();
$stmt->close();
$conn->close();

// Create directory and file
$dir = "/var/www/vhosts/$subdomain";
if (!file_exists($dir)) {
    mkdir($dir, 0755, true);
    $html = "<h1>$title</h1><p>$content</p>";
    file_put_contents("$dir/index.php", $html);
}
?>
Page created! Access it at: http://<?php echo $subdomain; ?>.rootedinfra.com
