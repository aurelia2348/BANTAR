<?php
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Fallback dummy (selalu berhasil untuk testing mockup tanpa DB)
    if (($username == 'admin' && $password == 'admin') || ($username == 'desainer' && $password == 'desainer')) {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $username;
        
        if ($username === 'desainer') {
            echo "<script>window.location.href='index.php?page=dashboard-desainer';</script>";
        } else {
            echo "<script>window.location.href='index.php?page=dashboard';</script>";
        }
        exit();
    }

    // Jika masuk kesini, block DB dipanggil jika mau terhubung database
    // mysqli_report(MYSQLI_REPORT_OFF); // Matikan error throw
    // include 'koneksi.php'; // Sementara tidak di-include jika fallback diatas terpenuhi
    $error = 'Username atau password salah!';
}
?>

<link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>">

<div class="login-body">
    <!-- Background glowing orbs -->
    <div class="login-bg-shape shape-1"></div>
    <div class="login-bg-shape shape-2"></div>
    <div class="login-bg-shape shape-3"></div>
    
    <div class="login-container">
        <div class="login-header">
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#6366f1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:1rem;">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            <h2>Welcome Back</h2>
            <p>Admin & Desainer Portal</p>
        </div>

        <?php if ($error != ''): ?>
            <div class="login-alert">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="index.php?page=login" method="POST">
            <div class="form-group">
                <label class="form-label">Username</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <input type="text" name="username" class="form-control-custom" placeholder="Enter your username" required autocomplete="off">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-wrapper">
                    <svg class="input-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>
    </div>
</div>

<style>
/* Full screen override for container */
.login-body {
    position: absolute;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    margin: 0;
    padding: 0;
    background-color: #0b0c10;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Outfit', sans-serif;
    z-index: 9999;
    overflow: hidden;
}

body.bg-dark {
    overflow-x: hidden;
}
</style>
