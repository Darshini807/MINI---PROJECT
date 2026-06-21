<?php
session_start();
require_once 'db.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit(); }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = (int)$_SESSION['user_id'];
    $service = trim($_POST['service'] ?? '');
    $provider = trim($_POST['provider'] ?? '');
    $booking_date = trim($_POST['booking_date'] ?? '');
    $booking_time = trim($_POST['booking_time'] ?? '');
    $status = 'Confirmed';
    $stmt = mysqli_prepare($conn, 'INSERT INTO bookings (user_id, service, provider, booking_date, booking_time, status) VALUES (?, ?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($stmt, 'isssss', $user_id, $service, $provider, $booking_date, $booking_time, $status);
    if (mysqli_stmt_execute($stmt)) { header('Location: dashboard.php?booked=1'); exit(); }
    $error = (mysqli_errno($conn) == 1062) ? 'This provider is already booked for the selected date and time.' : 'Booking failed. Please try again.';
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Booking | OneSlot</title><link rel="stylesheet" href="assets/css/style.css"><script defer src="assets/js/app.js"></script></head>
<body><header class="navbar"><div class="nav-head"><a class="brand" href="home.php">OneSlot</a><button class="menu-btn" data-menu>Menu</button></div><nav class="nav-links"><a href="home.php">Home</a><a href="services.php">Services</a><a class="active" href="booking.php">Booking</a><a href="dashboard.php">Dashboard</a></nav></header><main class="container"><section class="center reveal"><span class="eyebrow">Book appointment</span><h1 class="title">Confirm your perfect slot</h1><p class="subtitle">Select service, provider, date, and time. Your booking will be stored in MySQL.</p></section><?php if ($error): ?><p class="notice" style="display:block"><?php echo htmlspecialchars($error); ?></p><?php endif; ?><section class="booking-layout section"><form class="form-card" method="POST"><div class="field"><label for="service">Select Service</label><select id="service" name="service" required><option value="">Select service</option><option>Hospital</option><option>Salon</option><option>Gym</option><option>Consultant</option></select></div><div class="field"><label for="provider">Select Provider</label><select id="provider" name="provider" required><option value="">Select provider</option></select></div><div class="field"><label for="date">Select Date</label><input id="date" name="booking_date" type="date" required></div><div class="field"><label>Select Time</label><div class="time-grid"><label class="time-card"><input type="radio" name="booking_time" value="09:00 AM" required><span>09:00 AM</span></label><label class="time-card"><input type="radio" name="booking_time" value="11:00 AM"><span>11:00 AM</span></label><label class="time-card"><input type="radio" name="booking_time" value="02:00 PM"><span>02:00 PM</span></label><label class="time-card"><input type="radio" name="booking_time" value="05:00 PM"><span>05:00 PM</span></label></div></div><button class="btn full" type="submit">Confirm Booking</button></form><aside class="summary glass-card"><h2>Booking Summary</h2><p><strong>Service</strong><span data-summary="service">Not selected</span></p><p><strong>Provider</strong><span data-summary="provider">Not selected</span></p><p><strong>Date</strong><span data-summary="date">Not selected</span></p><p><strong>Time</strong><span data-summary="time">Not selected</span></p></aside></section></main></body></html>
