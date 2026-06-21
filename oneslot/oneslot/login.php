<?php
session_start();
require_once 'db.php';
$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = mysqli_prepare($conn, 'SELECT id, name, email, phone, password FROM users WHERE email = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_phone'] = $user['phone'];
        header('Location: dashboard.php');
        exit();
    }
    $error = 'Invalid email or password.';
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Login | OneSlot</title><link rel="stylesheet" href="assets/css/style.css"><script defer src="assets/js/app.js"></script></head>
<body><header class="navbar"><div class="nav-head"><a class="brand" href="home.php">OneSlot</a><button class="menu-btn" data-menu>Menu</button></div><nav class="nav-links"><a href="home.php">Home</a><a href="services.php">Services</a><a class="active" href="login.php">Login</a><a href="register.php">Register</a></nav></header><main class="form-page"><section class="form-card reveal"><span class="eyebrow">Welcome back</span><h1>Login</h1><p class="subtitle">Access your OneSlot dashboard and manage appointments.</p><?php if ($error): ?><p class="notice" style="display:block"><?php echo htmlspecialchars($error); ?></p><?php endif; ?><?php if (isset($_GET['registered'])): ?><p class="notice" style="display:block">Registration successful. Please login.</p><?php endif; ?><form class="form" method="POST"><div class="field"><label for="email">Email</label><input id="email" name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter email" required></div><div class="field"><label for="password">Password</label><div class="password-wrap"><input id="password" name="password" type="password" placeholder="Enter password" required><button class="toggle-password" type="button" data-toggle-password="password">Show</button></div></div><div class="form-row"><label class="check"><input name="remember" type="checkbox">Remember me</label><a href="#">Forgot password?</a></div><button class="btn full" type="submit">Login</button><p class="center">New to OneSlot? <a href="register.php"><strong>Create account</strong></a></p></form></section></main></body></html>
