<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: dashboard.php'); exit;
}
include '../config/koneksi.php';
$pesan_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';
    if (empty($username) || empty($password)) {
        $pesan_error = 'Username dan password wajib diisi.';
    } else {
        $sql = "SELECT * FROM admin WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) === 1) {
            $admin = mysqli_fetch_assoc($result);
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id']        = $admin['id'];
                $_SESSION['admin_username']  = $admin['username'];
                header('Location: dashboard.php'); exit;
            } else { $pesan_error = 'Username atau password salah.'; }
        } else { $pesan_error = 'Username atau password salah.'; }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — PT Janitra Surya Trans</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<div class="login-page">
    <!-- BG foto bus -->
    <div style="position:absolute;inset:0;">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=1920&q=70"
             alt="bg" style="width:100%;height:100%;object-fit:cover;opacity:0.08;">
    </div>
    <!-- Pola kotak -->
    <div style="position:absolute;bottom:0;right:0;opacity:0.12;background-image:repeating-linear-gradient(45deg,white 0,white 8px,transparent 8px,transparent 20px);background-size:28px 28px;width:300px;height:130px;"></div>

    <div class="login-card" style="position:relative;z-index:1;">
        <!-- Logo -->
        <div style="text-align:center;margin-bottom:28px;">
            <div style="text-align:center;margin-bottom:16px;">
                <img src="../assets/images/logo.png"
                    alt="Logo Janitra Surya"
                    style="height:100px;">
                </div>

                <div>
                    <h2 style="font-family:'Montserrat',sans-serif;font-size:1.3rem;font-weight:900;color:var(--hitam);text-transform:uppercase;margin-bottom:4px;">
                        Admin Panel
                    </h2>

                    <p style="color:var(--abu-teks);font-size:0.82rem;margin:0;">
                        Masuk untuk mengelola data booking
                    </p>
                </div>
        </div>

        <?php if (!empty($pesan_error)): ?>
        <div style="background:#FEE2E2;border-left:4px solid var(--merah);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;font-size:0.85rem;color:#B91C1C;font-family:'Open Sans',sans-serif;">
            <i class="fas fa-exclamation-circle"></i>
            <?= htmlspecialchars($pesan_error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label class="form-label"><i class="fas fa-user me-1" style="color:var(--merah);"></i> Username</label>
                <input type="text" name="username" class="form-control"
                       placeholder="Masukkan username"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                       autocomplete="username" required>
            </div>
            <div class="mb-4">
                <label class="form-label"><i class="fas fa-lock me-1" style="color:var(--merah);"></i> Password</label>
                <div style="position:relative;">
                    <input type="password" name="password" id="pwdInput" class="form-control"
                           placeholder="Masukkan password"
                           autocomplete="current-password" required
                           style="padding-right:44px;">
                    <button type="button" id="pwdToggle"
                            style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--abu-teks);cursor:pointer;font-size:0.95rem;">
                        <i class="fas fa-eye" id="eyeIco"></i>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-submit" style="border-radius:var(--radius-sm);">
                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Dashboard
            </button>
        </form>

        <div style="text-align:center;margin-top:22px;">
            <a href="../index.php" style="color:var(--abu-teks);font-size:0.82rem;text-decoration:none;font-family:'Open Sans',sans-serif;">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Website
            </a>
        </div>

        <div style="background:var(--abu);border-radius:var(--radius-sm);padding:10px 16px;margin-top:18px;text-align:center;font-size:0.75rem;color:var(--abu-teks);font-family:'Open Sans',sans-serif;">
            🔑 Default login: <strong>admin</strong> / <strong>password</strong>
        </div>
    </div>
</div>
<script>
document.getElementById('pwdToggle').addEventListener('click', function () {
    const input = document.getElementById('pwdInput');
    const icon = document.getElementById('eyeIco');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
