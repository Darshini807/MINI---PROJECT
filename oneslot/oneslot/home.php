<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>OneSlot | Homepage</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script defer src="assets/js/app.js"></script>
</head>
<body>
  <header class="navbar">
    <div class="nav-head"><a class="brand" href="home.php">OneSlot</a><button class="menu-btn" data-menu>Menu</button></div>
    <nav class="nav-links"><a class="active" href="home.php">Home</a><a href="services.php">Services</a><a href="login.php">Login</a><a href="register.php">Register</a><a href="admin.php">Admin</a></nav>
  </header>
  <main class="container">
    <section class="hero reveal">
      <div><span class="eyebrow">Smart appointment platform</span><h1 class="title">Book the right slot in seconds.</h1><p class="subtitle">OneSlot is a premium multi-service appointment system for hospitals, salons, gyms, and consultants. Search, book, manage, and track every appointment from one clean dashboard.</p><form class="search-box" action="services.php" method="GET"><input type="search" name="q" placeholder="Search services, providers, or slots"><button class="btn white" type="submit">Search</button></form><div class="actions"><a class="btn white" href="register.php">Get Started</a><a class="btn ghost" href="services.php">Explore Services</a></div></div>
      <aside class="hero-card"><div class="hero-mini"><div class="mini-row"><strong>Instant discovery</strong><span>Find available services and providers quickly.</span></div><div class="mini-row"><strong>Clear booking flow</strong><span>Select service, provider, date, and time without confusion.</span></div><div class="mini-row"><strong>Smart dashboards</strong><span>Users and admins get clean, focused controls.</span></div></div></aside>
    </section>
    <section class="section"><div class="center"><span class="eyebrow">Featured services</span><h2 class="title">Services made simple</h2></div><div class="grid"><article class="service-card"><div class="icon">🏥</div><h3>Hospital</h3><p>Book doctor consultations and healthcare appointments.</p></article><article class="service-card"><div class="icon">💇</div><h3>Salon</h3><p>Reserve grooming, styling, and beauty service slots.</p></article><article class="service-card"><div class="icon">🏋️</div><h3>Gym</h3><p>Schedule trainer sessions and fitness consultations.</p></article><article class="service-card"><div class="icon">💼</div><h3>Consultant</h3><p>Book professional, career, finance, or business consulting.</p></article></div></section>
    <section class="section grid four"><article class="stat-card"><strong>4+</strong><span>Service categories</span></article><article class="stat-card"><strong>24/7</strong><span>Online access</span></article><article class="stat-card"><strong>100%</strong><span>Responsive UI</span></article><article class="stat-card"><strong>1</strong><span>Unified platform</span></article></section>
    <section class="section grid two"><article class="info-card"><span class="eyebrow">About</span><h2>Built for simple appointment management</h2><p>OneSlot helps users understand the booking journey immediately. The interface is clean, modern, and designed for a final-year engineering project with a real startup product feel.</p></article><article class="info-card"><span class="eyebrow">Contact</span><h2>Need help?</h2><p>Email: support@oneslot.com<br>Phone: +91 98765 43210<br>Location: India</p></article></section>
  </main>
  <footer class="footer"><div class="footer-grid"><strong>OneSlot</strong><span>Multi-Service Appointment Booking System</span></div></footer>
</body>
</html>
