<?php
// --- Conexión ---
$host = "localhost";
$user = "root";
$pass = "";
$db = "pyrathon_news";
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}

// --- Crear noticia ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
  $title = $conn->real_escape_string($_POST['title']);
  $summary = $conn->real_escape_string($_POST['summary']);
  $content = $conn->real_escape_string($_POST['content']);
  $image = $conn->real_escape_string($_POST['image']);

  $sql = "INSERT INTO news (title, summary, content, image, created_at)
          VALUES ('$title', '$summary', '$content', '$image', NOW())";
  $conn->query($sql);
  header("Location: news_admin.php");
  exit;
}

// --- Eliminar noticia ---
if (isset($_GET['delete'])) {
  $id = (int) $_GET['delete'];
  $conn->query("DELETE FROM news WHERE id=$id");
  header("Location: news_admin.php");
  exit;
}

// --- Listar noticias ---
$result = $conn->query("SELECT * FROM news ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Admin Noticias</title>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 20px;
      color: #333;
    }
    h1 {
      color: #1a73e8;
      text-align: center;
    }
    .form-container {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      max-width: 600px;
      margin: 20px auto;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 15px;
    }
    button {
      background: #1a73e8;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 15px;
      transition: background .3s;
    }
    button:hover {
      background: #1558b0;
    }
    .news-list {
      margin-top: 30px;
    }
    .news-item {
      background: #fff;
      padding: 15px;
      margin: 12px 0;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .news-item a {
      text-decoration: none;
      color: #1a73e8;
      font-weight: bold;
    }
    .delete {
      color: #e63946;
      text-decoration: none;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <h1><i class="bx bx-news"></i> Administrador de Noticias</h1>

  <div class="form-container">
    <form method="POST">
      <input type="text" name="title" placeholder="Título" required>
      <input type="text" name="summary" placeholder="Resumen" required>
      <textarea name="content" rows="4" placeholder="Contenido"></textarea>
      <input type="text" name="image" placeholder="URL de imagen">
      <button type="submit"><i class="bx bx-save"></i> Publicar</button>
    </form>
  </div>

  <div class="news-list">
    <h2>Noticias publicadas</h2>
    <?php while($row = $result->fetch_assoc()): ?>
      <div class="news-item">
        <span><a href="news_detail.php?id=<?php echo $row['id']; ?>"><?php echo $row['title']; ?></a></span>
        <a class="delete" href="?delete=<?php echo $row['id']; ?>"><i class="bx bx-trash"></i></a>
      </div>
    <?php endwhile; ?>
  </div>
</body>
</html>
