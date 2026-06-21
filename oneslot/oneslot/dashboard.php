<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
if (isset($_GET['cancel'])) {
    $booking_id = (int)$_GET['cancel'];
    $user_id = (int)$_SESSION['user_id'];
    $stmt = mysqli_prepare($conn, "UPDATE bookings SET status = 'Cancelled' WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmt, 'ii', $booking_id, $user_id);
    mysqli_stmt_execute($stmt);
    header('Location: dashboard.php?cancelled=1');
    exit();
}
$user_id = (int)$_SESSION['user_id'];
$stmt = mysqli_prepare($conn, 'SELECT id, service, provider, booking_date, booking_time, status FROM bookings WHERE user_id = ? ORDER BY booking_date DESC, id DESC');
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$bookings = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>User Dashboard | OneSlot</title><link rel="stylesheet" href="assets/css/style.css"><script defer src="assets/js/app.js"></script></head>
<body><header class="navbar"><div class="nav-head"><a class="brand" href="home.php">OneSlot</a><button class="menu-btn" data-menu>Menu</button></div><nav class="nav-links"><a href="home.php">Home</a><a href="services.php">Services</a><a href="booking.php">Booking</a><a class="active" href="dashboard.php">Dashboard</a><a href="logout.php">Logout</a></nav></header><main class="container"><section class="dashboard-top reveal"><article class="dashboard-card"><span class="eyebrow">Welcome</span><h1 class="title">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?></h1><p class="subtitle">Manage upcoming appointments, booking history, and profile details from your OneSlot dashboard.</p><div class="actions"><a class="btn white" href="booking.php">Book New Slot</a><a class="btn ghost" href="logout.php">Logout</a></div></article><article class="dashboard-card"><h2>Profile</h2><p class="subtitle">Name: <?php echo htmlspecialchars($_SESSION['user_name']); ?><br>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?><br>Phone: <?php echo htmlspecialchars($_SESSION['user_phone']); ?><br>Member Type: User</p></article></section><?php if (isset($_GET['booked'])): ?><p class="notice" style="display:block">Appointment booked successfully.</p><?php endif; ?><?php if (isset($_GET['cancelled'])): ?><p class="notice" style="display:block">Booking cancelled successfully.</p><?php endif; ?><section class="section"><h2>Upcoming Appointments & Booking History</h2><div class="table-wrap glass-card"><table><thead><tr><th>Service</th><th>Provider</th><th>Date</th><th>Time</th><th>Status</th><th>Action</th></tr></thead><tbody><?php while ($row = mysqli_fetch_assoc($bookings)): ?><tr><td><?php echo htmlspecialchars($row['service']); ?></td><td><?php echo htmlspecialchars($row['provider']); ?></td><td><?php echo htmlspecialchars($row['booking_date']); ?></td><td><?php echo htmlspecialchars($row['booking_time']); ?></td><td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo htmlspecialchars($row['status']); ?></span></td><td><?php if ($row['status'] !== 'Cancelled'): ?><a class="btn small-btn ghost" href="dashboard.php?cancel=<?php echo $row['id']; ?>">Cancel</a><?php else: ?>-<?php endif; ?></td></tr><?php endwhile; ?></tbody></table></div></section></main></body></html>
