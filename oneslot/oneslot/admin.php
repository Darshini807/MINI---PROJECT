<?php
session_start();
require_once 'db.php';
require_once 'config.php';

$error = '';

if (isset($_GET['logout'])) {
    unset($_SESSION['admin_logged_in']);
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    }
    $error = 'Invalid admin credentials.';
}

if (!empty($_SESSION['admin_logged_in']) && isset($_GET['delete'])) {
    $booking_id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($conn, 'DELETE FROM bookings WHERE id = ?');
    mysqli_stmt_bind_param($stmt, 'i', $booking_id);
    mysqli_stmt_execute($stmt);
    header('Location: admin.php?deleted=1');
    exit();
}

$total_users = 0;
$total_bookings = 0;
$bookings = false;

if (!empty($_SESSION['admin_logged_in'])) {
    $users_result = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM users');
    $bookings_result = mysqli_query($conn, 'SELECT COUNT(*) AS total FROM bookings');
    $total_users = mysqli_fetch_assoc($users_result)['total'];
    $total_bookings = mysqli_fetch_assoc($bookings_result)['total'];
    $bookings = mysqli_query($conn, 'SELECT b.id, u.name, u.email, b.service, b.provider, b.booking_date, b.booking_time, b.status FROM bookings b JOIN users u ON b.user_id = u.id ORDER BY b.booking_date DESC, b.id DESC');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | OneSlot</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <script defer src="assets/js/app.js"></script>
</head>
<body>
  <header class="navbar"><div class="nav-head"><a class="brand" href="home.php">OneSlot Admin</a><button class="menu-btn" data-menu>Menu</button></div><nav class="nav-links"><a href="home.php">Home</a><a class="active" href="admin.php">Admin</a><?php if (!empty($_SESSION['admin_logged_in'])): ?><a href="admin.php?logout=1">Logout</a><?php endif; ?></nav></header>

  <?php if (empty($_SESSION['admin_logged_in'])): ?>
  <main class="form-page"><section class="form-card reveal"><span class="eyebrow">Admin access</span><h1>Admin Login</h1><p class="subtitle">Use the admin credentials from config.php.</p><?php if ($error): ?><p class="notice" style="display:block"><?php echo htmlspecialchars($error); ?></p><?php endif; ?><form class="form" method="POST"><div class="field"><label for="email">Email</label><input id="email" name="email" type="email" placeholder="admin@oneslot.com" required></div><div class="field"><label for="password">Password</label><div class="password-wrap"><input id="password" name="password" type="password" placeholder="admin123" required><button class="toggle-password" type="button" data-toggle-password="password">Show</button></div></div><button class="btn full" name="admin_login" type="submit">Login as Admin</button></form></section></main>
  <?php else: ?>
  <main class="container"><section class="center reveal"><span class="eyebrow">Admin dashboard</span><h1 class="title">Control the booking system</h1><p class="subtitle">Manage users and bookings stored in MySQL.</p></section><?php if (isset($_GET['deleted'])): ?><p class="notice" style="display:block">Booking deleted successfully.</p><?php endif; ?><section class="section grid three"><article class="stat-card"><strong><?php echo $total_users; ?></strong><span>Total users</span></article><article class="stat-card"><strong><?php echo $total_bookings; ?></strong><span>Total bookings</span></article><article class="stat-card"><strong>4</strong><span>Services</span></article></section><section class="section grid two"><article class="dashboard-card form"><h2>Add Providers</h2><p class="subtitle">Provider management UI is ready. Current database requirement stores users and bookings only.</p><div class="field"><label>Provider Name</label><input type="text" placeholder="Enter provider name"></div><div class="field"><label>Service</label><select><option>Hospital</option><option>Salon</option><option>Gym</option><option>Consultant</option></select></div><button class="btn" type="button">Add Provider</button></article><article class="dashboard-card form"><h2>Manage Slots</h2><p class="subtitle">Slot controls are ready for extension. Booked slots are protected by the bookings table.</p><div class="field"><label>Date</label><input type="date"></div><div class="field"><label>Time</label><input type="time"></div><button class="btn" type="button">Create Slot</button></article></section><section class="section"><h2>View Bookings</h2><div class="table-wrap glass-card"><table><thead><tr><th>User</th><th>Email</th><th>Service</th><th>Provider</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr></thead><tbody><?php while ($row = mysqli_fetch_assoc($bookings)): ?><tr><td><?php echo htmlspecialchars($row['name']); ?></td><td><?php echo htmlspecialchars($row['email']); ?></td><td><?php echo htmlspecialchars($row['service']); ?></td><td><?php echo htmlspecialchars($row['provider']); ?></td><td><?php echo htmlspecialchars($row['booking_date']); ?></td><td><?php echo htmlspecialchars($row['booking_time']); ?></td><td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td><td><a class="btn small-btn ghost" href="admin.php?delete=<?php echo $row['id']; ?>">Delete</a></td></tr><?php endwhile; ?></tbody></table></div><div class="actions"><a class="btn ghost" href="admin.php?logout=1">Logout</a></div></section></main>
  <?php endif; ?>
</body>
</html>
