<?php
session_start();
require_once 'db.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        $check = mysqli_prepare($conn, 'SELECT id FROM users WHERE email = ? LIMIT 1');
        mysqli_stmt_bind_param($check, 's', $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);
        if (mysqli_stmt_num_rows($check) > 0) {
            $error = 'Email already registered.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, 'INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)');
            mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $phone, $hashed);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: login.php?registered=1');
                exit();
            }
            $error = 'Registration failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Register | OneSlot</title><link rel="stylesheet" href="assets/css/style.css"><script defer src="assets/js/app.js"></script></head>
<body><header class="navbar"><div class="nav-head"><a class="brand" href="home.php">OneSlot</a><button class="menu-btn" data-menu>Menu</button></div><nav class="nav-links"><a href="home.php">Home</a><a href="services.php">Services</a><a href="login.php">Login</a><a class="active" href="register.php">Register</a></nav></header><main class="form-page"><section class="form-card reveal"><span class="eyebrow">Create account</span><h1>Register</h1><p class="subtitle">Join OneSlot and start booking appointments smoothly.</p><?php if ($error): ?><p class="notice" style="display:block"><?php echo htmlspecialchars($error); ?></p><?php endif; ?><form class="form" method="POST"><div class="field"><label for="name">Full Name</label><input id="name" name="name" type="text" placeholder="Enter full name" required></div><div class="field"><label for="email">Email</label><input id="email" name="email" type="email" placeholder="Enter email" required></div><div class="field"><label for="phone">Phone Number</label><input id="phone" name="phone" type="tel" placeholder="Enter phone number" pattern="[0-9]{10}" required></div><div class="field"><label for="password">Password</label><div class="password-wrap"><input id="password" name="password" type="password" minlength="6" placeholder="Create password" required><button class="toggle-password" type="button" data-toggle-password="password">Show</button></div></div><div class="field"><label for="confirmPassword">Confirm Password</label><div class="password-wrap"><input id="confirmPassword" name="confirm_password" type="password" minlength="6" placeholder="Confirm password" required><button class="toggle-password" type="button" data-toggle-password="confirmPassword">Show</button></div></div><button class="btn full" type="submit">Register</button><p class="center">Already have an account? <a href="login.php"><strong>Login</strong></a></p></form></section></main></body></html>
