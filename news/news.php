<?php
// news.php

// --- CONFIGURACIÓN DE CONEXIÓN ---
$host = "localhost";
$user = "root";
$pass = "";
$db   = "pyrathon_news";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// --- OBTENER HERO HEADER ---
$hero = null;
$sqlHero = "SELECT small_text, title, description, link, updated_at 
            FROM hero_header 
            ORDER BY updated_at DESC 
            LIMIT 1";

if ($res = $conn->query($sqlHero)) {
    if ($res->num_rows > 0) {
        $hero = $res->fetch_assoc();
    }
    $res->free();
}

// --- MOSTRAR HERO HEADER DE FORMA SEGURA ---


// --- OBTENER NOTICIAS ---
$newsItems = [];
$sqlNews = "SELECT id, title, created_at 
            FROM news 
            ORDER BY created_at DESC 
            LIMIT 5";
if ($res = $conn->query($sqlNews)) {
  while ($row = $res->fetch_assoc()) {
    $newsItems[] = $row;
  }
  $res->free();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>El Editor de Código con IA — Demo</title>
  <link rel="stylesheet" href="../styles.css">
  <link rel="stylesheet" href="style_news.css">
  <link rel="stylesheet" href="../animations.css">
  <link rel="icon" href="../favicon.svg">
  <!-- Enlace a Boxicons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    
  <!-- NAVBAR -->
  <header class="nav">
    <div class="container nav__inner">
      <a class="brand" href="../index.html">
        <img src="../favicon.svg" alt="Logo" width="26" height="26">
        <span>Pyrathon<span class="accent">Compiler</span></span>
      </a>

      <nav class="nav__links" id="navLinks">
        <a href="#">Pricing</a>
        <a href="#features">News</a>
        <a href="#enterprise">Blog</a>
        <a href="#docs">Docs</a>
        <a href="#docs">Community</a>
      </nav>

      <div class="nav__actions">
        <a class="btn btn--ghost" href="Pyrathon Lite_setup.exe">Download</a>
        <button class="hamburger" id="hamburger" aria-label="Abrir menú">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>
  </header>
<!-- HERO HEADER -->
<?php if ($hero): ?>
  <section class="hero-header">
    <small>
      <?= htmlspecialchars($hero['small_text']) ?>
      <br>
      <?= date("M. j, Y, g:i a", strtotime($hero['updated_at'])) ?>
    </small>
    <h1><?= htmlspecialchars($hero['title']) ?></h1>
    <?php if (!empty($hero['subtitle'])): ?>
      <h2><?= htmlspecialchars($hero['subtitle']) ?></h2>
    <?php endif; ?>
    <p>
      <?= nl2br(htmlspecialchars($hero['description'])) ?>
      <?php if (!empty($hero['link'])): ?>
        <a href="<?= htmlspecialchars($hero['link']) ?>">Read more</a>
      <?php endif; ?>
    </p>
  </section>
<?php endif; ?>


  <!-- CONTENT -->
  <div class="container news-layout">
    <!-- NEWS -->
    <div class="news-section">
      <h2><i class='bx bx-news'></i> Latest News</h2>
      <ul class="news-list">
        <?php if (!empty($newsItems)): ?>
          <?php foreach ($newsItems as $item): ?>
            <li>
              <a href="news_detail.php?id=<?= (int)$item['id'] ?>">
                <?= htmlspecialchars($item['title']) ?>
              </a>
              <small><?= date("M. d, Y", strtotime($item['created_at'])) ?></small>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li><em>No hay noticias todavía.</em></li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- SIDEBAR -->
    <aside class="sidebar">
      <section>
        <h3>Pyrathon Insider</h3>
        <p>Subscribe to Pyrathon Insider via:</p>
        <a href="#"><i class='bx bx-rss'></i> RSS</a><br>
        <a href="#">Also check out the Discussions on Pyrathon.org</a>
      </section>

      <section class="copyright">
        <h3>Copyright</h3>
        <p>
          Pyrathon Insider by the Pyrathon Core Team is licensed under a  
          <a href="#">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.  
          Based on a work at <a href="#">pyrathon.org</a>.
        </p>
      </section>
    </aside>
  </div>

  <!-- FOOTER -->
  <footer class="mega-footer">
    <div class="footer-top">
      <div class="footer-column">
        <h4>Platform</h4>
        <ul>
          <li><a href="#">About PyrathonCompiler</a></li>
          <li><a href="#">Supported Languages</a></li>
          <li><a href="#">Getting Started</a></li>
          <li><a href="#">FAQ</a></li>
          <li><a href="#">Privacy Policy</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Languages</h4>
        <ul>
          <li><a href="#">Python</a></li>
          <li><a href="#">JavaScript / Node.js</a></li>
          <li><a href="#">C / C++</a></li>
          <li><a href="#">Java</a></li>
          <li><a href="#">More languages...</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Resources</h4>
        <ul>
          <li><a href="#">Documentation</a></li>
          <li><a href="#">Beginner Guides</a></li>
          <li><a href="#">Tips & Tricks</a></li>
          <li><a href="#">Code Templates</a></li>
          <li><a href="#">Integration API</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Community</h4>
        <ul>
          <li><a href="#">Forum (coming soon)</a></li>
          <li><a href="#">Discord</a></li>
          <li><a href="#">User Groups</a></li>
          <li><a href="#">Online Events</a></li>
          <li><a href="#">Success Stories</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Support</h4>
        <ul>
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Contact</a></li>
          <li><a href="#">Report a Bug</a></li>
          <li><a href="#">Service Status</a></li>
        </ul>
      </div>
      <div class="footer-column">
        <h4>Contribute</h4>
        <ul>
          <li><a href="#">Developer Guide</a></li>
          <li><a href="#">GitHub Repository</a></li>
          <li><a href="#">Submit Improvements</a></li>
          <li><a href="#">Security Report</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div class="footer-links">
        <a href="#">Help Center</a>
        <a href="#">Diversity Initiatives</a>
        <a href="#">Report a Bug</a>
        <a href="#">Status <span class="status-dot"></span></a>
      </div>
      <p>© 2025 PyrathonCompiler. Multi-language compilation platform.</p>
    </div>
  </footer>

  <script src="../script.js"></script>
  <script src="script.js"></script>
</body>
</html>
