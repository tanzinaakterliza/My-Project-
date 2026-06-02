<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>UU SwiftTransit — Home</title>
  <link rel="stylesheet" href="assets/css/main.css">
  <meta name="description" content="Uttara University Bus Tracking & Scheduling System — Frontend Prototype">
</head>

<body>

  <!-- ================= NAVBAR ================= -->
  <header class="nav">
    <div class="container nav-inner">

      <a href="index.php" class="brand">
        <div class="logo-box">
          <img src="assets/img/uu-logo-transparent.png" class="logo" alt="UU Logo">
          <span class="brand-name">UU SwiftTransit</span>
        </div>
      </a>

      <button class="nav-toggle" aria-label="Toggle navigation">☰</button>

      <nav class="nav-links">

        <a href="index.php" class="active">Home</a>
        <a href="about.html">About</a>
        

        <?php if(isset($_SESSION['user_id'])): ?>
          <a href="user/dashboard.php">Dashboard</a>
        <?php else: ?>
          <a href="signup.html">Sign Up</a>
        <?php endif; ?>

        <a href="contact.html">Contact</a>
      </nav>

    </div>
  </header>


  <!-- ================= HERO ================= -->
  <section class="hero">
    <div class="hero-media" style="background-image:url('assets/img/hero.jpg')"></div>
    <div class="hero-overlay"></div>

    <div class="hero-content container">
      <h1>Uttara University Bus Tracking & Scheduling System</h1>
      <p class="lead">Real-time bus tracking • Smart scheduling • Reliable university transportation</p>

      <div class="hero-cta">
        <a href="signup.html" class="btn">Get Started</a>
       
      </div>
    </div>
  </section>

  <!-- ================= FEATURES ================= -->
  <section class="features container">

    <div class="feature">
      <h3>Real-time Tracking</h3>
      <p>See bus locations on a live map and know arrival times instantly.</p>
    </div>

    <div class="feature">
      <h3>Smart Scheduling</h3>
      <p>Easily create, edit and publish daily campus route schedules.</p>
    </div>

    <div class="feature">
      <h3>Driver Management</h3>
      <p>Assign drivers, monitor routes, and manage pickup & drop-off tasks.</p>
    </div>

  </section>

  <!-- ================= ABOUT PREVIEW ================= -->
  <section class="about-preview container">

    <div class="about-card">
      <img src="assets/img/about-illu.svg" alt="About illustration">

      <div>
        <h2>Why UU SwiftTransit?</h2>
        <p>Our system is designed to reduce waiting time, provide transparency, and make transportation inside Uttara University safer and more efficient.</p>
        <br>
        <a href="about.html" class="btn btn-ghost">Read More</a>
      </div>
    </div>

  </section>

  <!-- ================= CALLOUT ================= -->
  <section class="callout">
    <div class="container">
      <h2>Ready to manage university transport smartly?</h2><br>
      <a href="signup.html" class="btn">Create an Account</a>
    </div>
  </section>

  <!-- ================= FOOTER ================= -->
  <footer class="site-footer">

    <div class="container footer-grid">

      <div>
        <strong>UU SwiftTransit</strong>
        <p>Uttara University Bus Tracking & Scheduling System</p>
      </div>

      <div>
        <h4>Pages</h4>
        <a href="index.php" class="active">Home</a>
        <a href="about.html">About</a>
       
        <a href="signup.php">Sign Up</a>
        <a href="contact.html">Contact</a>
      </div>

      <div>
        <h4>Project</h4>
        <p>Developed by <strong>Innodata</strong></p>
        <a href="#" id="githubLink">GitHub </a>
      </div>

    </div>

    <div class="container footer-bottom">
      UU Bus Tracking & Scheduling System © 2025 | UU SwiftTransit
    </div>

  </footer>

  <script src="assets/js/script.js"></script>
</body>

</html>
