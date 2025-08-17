<?php
// set_hero_header.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pyrathon_news";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escapar los datos recibidos para evitar inyecciones SQL
    $small_text  = $conn->real_escape_string($_POST['small_text']);
    $title       = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $link        = $conn->real_escape_string($_POST['link']);

    // Insertar en la tabla hero_header con fecha actual
    $sql = "INSERT INTO hero_header (small_text, title, description, link, updated_at) 
            VALUES ('$small_text', '$title', '$description', '$link', NOW())";

    if ($conn->query($sql) === TRUE) {
        $message = "✅ Hero Header updated successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Set Hero Header</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f6f9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      max-width: 600px;
      width: 100%;
    }
    h2 { text-align: center; margin-bottom: 20px; }
    label { display: block; margin-top: 15px; font-weight: bold; }
    input[type="text"], textarea {
      width: 100%; padding: 10px;
      border: 1px solid #ccc; border-radius: 8px;
      margin-top: 5px;
    }
    textarea { min-height: 120px; resize: vertical; }
    button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background: #007BFF;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover { background: #0056b3; }
    .msg { text-align: center; margin-top: 10px; font-weight: bold; }
  </style>
</head>
<body>
  <div class="container">
    <h2>Set Hero Header</h2>
    <?php if ($message): ?>
      <div class="msg"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
      <label>Small Text (ej: Welcome to Pyrathon Insider + fecha)</label>
      <input type="text" name="small_text" placeholder="Welcome to the Pyrathon Insider — Aug. 14, 2025">

      <label>Title (ej: Pyrathon 3.14.0rc2 and 3.13.7 are go!)</label>
      <input type="text" name="title" placeholder="Pyrathon 3.14.0rc2 and 3.13.7 are go!">

      <label>Description / Subtitle</label>
      <textarea name="description" placeholder="🎉 Not one but two expedited releases!..."></textarea>

      <label>Link (Read more)</label>
      <input type="text" name="link" placeholder="https://example.com/read-more">

      <button type="submit">Save Hero Header</button>
    </form>
  </div>
</body>
</html>
