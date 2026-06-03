<?php
// ============================================
// admin/ganti-password.php
// Halaman Ganti Password Admin - AMAN
// ============================================
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); exit;
}
include '../config/koneksi.php';
$halaman_admin = 'password';

$pesan       = '';
$tipe_pesan  = '';
$admin_id    = $_SESSION['admin_id'];

// ── Ambil data admin saat ini ──────────────────
$admin = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM admin WHERE id = $admin_id LIMIT 1")
);

// ── Proses form ganti password ─────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_lama  = $_POST['password_lama']  ?? '';
    $password_baru  = $_POST['password_baru']  ?? '';
    $konfirmasi     = $_POST['konfirmasi']      ?? '';

    // --- Validasi ---
    $errors = [];

    // 1. Cek password lama
    if (!password_verify($password_lama, $admin['password'])) {
        $errors[] = 'Password lama tidak sesuai.';
    }

    // 2. Panjang minimal
    if (strlen($password_baru) < 8) {
        $errors[] = 'Password baru minimal 8 karakter.';
    }

    // 3. Harus mengandung huruf besar
    if (!preg_match('/[A-Z]/', $password_baru)) {
        $errors[] = 'Password baru harus mengandung minimal 1 huruf kapital.';
    }

    // 4. Harus mengandung angka
    if (!preg_match('/[0-9]/', $password_baru)) {
        $errors[] = 'Password baru harus mengandung minimal 1 angka.';
    }

    // 5. Harus mengandung karakter spesial
    if (!preg_match('/[\W_]/', $password_baru)) {
        $errors[] = 'Password baru harus mengandung minimal 1 karakter spesial (!@#$%^&*).';
    }

    // 6. Konfirmasi harus sama
    if ($password_baru !== $konfirmasi) {
        $errors[] = 'Konfirmasi password tidak cocok.';
    }

    // 7. Password baru tidak boleh sama dengan lama
    if (empty($errors) && password_verify($password_baru, $admin['password'])) {
        $errors[] = 'Password baru tidak boleh sama dengan password lama.';
    }

    if (empty($errors)) {
        // Hash password baru dengan bcrypt
        $hash_baru = password_hash($password_baru, PASSWORD_BCRYPT, ['cost' => 12]);
        $sql = "UPDATE admin SET password = '$hash_baru' WHERE id = $admin_id";

        if (mysqli_query($conn, $sql)) {
            $pesan      = 'Password berhasil diubah! Silakan login ulang dengan password baru Anda.';
            $tipe_pesan = 'success';
            // Logout otomatis setelah ganti password (keamanan)
            session_destroy();
            header('refresh:3;url=login.php');
        } else {
            $pesan      = 'Gagal menyimpan password baru. Coba lagi.';
            $tipe_pesan = 'danger';
        }
    } else {
        $pesan      = implode('<br>', $errors);
        $tipe_pesan = 'danger';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password — Admin Janitra Surya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        /* Strength bar */
        .strength-bar { height: 6px; border-radius: 3px; background: #E8E8E8; margin-top: 8px; overflow: hidden; }
        .strength-fill { height: 100%; border-radius: 3px; width: 0; transition: width 0.4s ease, background 0.4s ease; }
        .strength-text { font-size: 0.75rem; font-family: 'Montserrat', sans-serif; font-weight: 700; margin-top: 5px; text-transform: uppercase; letter-spacing: 0.5px; }

        /* Rule checklist */
        .rule-item { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; padding: 4px 0; color: var(--abu-teks); font-family: 'Open Sans', sans-serif; transition: color 0.3s; }
        .rule-item .rule-icon { width: 18px; height: 18px; border-radius: 50%; background: #E8E8E8; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; flex-shrink: 0; transition: all 0.3s; }
        .rule-item.valid { color: #065F46; }
        .rule-item.valid .rule-icon { background: #10B981; color: white; }
        .rule-item.invalid .rule-icon { background: #EF4444; color: white; }

        /* Input password wrapper */
        .input-pwd-wrap { position: relative; }
        .input-pwd-wrap .toggle-eye { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--abu-teks); cursor: pointer; font-size: 0.95rem; padding: 0; }
    </style>
</head>
<body style="background:var(--abu);">
<div class="admin-layout">
    <?php include 'includes/sidebar.php'; ?>

    <div class="admin-main">
        <!-- Topbar -->
        <div class="admin-topbar">
            <div>
                <h5 style="margin:0;font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:0.95rem;">
                    <i class="fas fa-key me-2" style="color:var(--merah);"></i>Ganti Password
                </h5>
                <div style="font-size:0.75rem;color:var(--abu-teks);">Ubah password akun admin Anda</div>
            </div>
            <a href="logout.php" style="background:var(--abu);color:var(--abu-teks);padding:7px 14px;border-radius:4px;font-size:0.78rem;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;border:1px solid var(--abu-medium);">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>

        <div class="admin-content">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">

                    <!-- Notifikasi -->
                    <?php if (!empty($pesan)): ?>
                    <div style="background:<?= $tipe_pesan==='success'?'#D1FAE5':'#FEE2E2' ?>;border-left:5px solid <?= $tipe_pesan==='success'?'#10B981':'var(--merah)' ?>;border-radius:var(--radius-sm);padding:16px 20px;margin-bottom:22px;display:flex;gap:14px;align-items:flex-start;">
                        <div style="font-size:1.4rem;flex-shrink:0;"><?= $tipe_pesan==='success'?'✅':'❌' ?></div>
                        <div>
                            <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.82rem;text-transform:uppercase;color:<?= $tipe_pesan==='success'?'#065F46':'#B91C1C' ?>;margin-bottom:4px;">
                                <?= $tipe_pesan==='success'?'Password Berhasil Diubah!':'Terjadi Kesalahan' ?>
                            </div>
                            <div style="font-size:0.85rem;color:<?= $tipe_pesan==='success'?'#047857':'#B91C1C' ?>;line-height:1.65;">
                                <?= $pesan ?>
                                <?php if ($tipe_pesan === 'success'): ?>
                                <br><span style="color:var(--abu-teks);">Mengalihkan ke halaman login dalam 3 detik...</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Card Form -->
                    <div style="background:white;border-radius:var(--radius);box-shadow:var(--shadow-card);overflow:hidden;border-top:5px solid var(--merah);">
                        <!-- Header card -->
                        <div style="padding:24px 28px;border-bottom:1px solid #F5F5F5;display:flex;align-items:center;gap:14px;">
                            <div style="width:48px;height:48px;background:var(--merah-tua);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">🔐</div>
                            <div>
                                <div style="font-family:'Montserrat',sans-serif;font-weight:900;font-size:0.95rem;color:var(--hitam);text-transform:uppercase;">Ubah Password Admin</div>
                                <div style="font-size:0.8rem;color:var(--abu-teks);margin-top:2px;">
                                    Login sebagai: <strong style="color:var(--merah-tua);"><?= htmlspecialchars($admin['username']) ?></strong>
                                </div>
                            </div>
                        </div>

                        <!-- Form -->
                        <div style="padding:28px;">
                            <?php if ($tipe_pesan !== 'success'): ?>
                            <form method="POST" id="formGantiPwd">

                                <!-- Password Lama -->
                                <div style="margin-bottom:22px;">
                                    <label class="form-label">
                                        <i class="fas fa-lock me-1" style="color:var(--merah);"></i>
                                        Password Lama *
                                    </label>
                                    <div class="input-pwd-wrap">
                                        <input type="password" name="password_lama" id="pwdLama" class="form-control"
                                               placeholder="Masukkan password saat ini" required
                                               style="padding-right:44px;">
                                        <button type="button" class="toggle-eye" onclick="togglePwd('pwdLama','eyeLama')">
                                            <i class="fas fa-eye" id="eyeLama"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Password Baru -->
                                <div style="margin-bottom:10px;">
                                    <label class="form-label">
                                        <i class="fas fa-key me-1" style="color:var(--merah);"></i>
                                        Password Baru *
                                    </label>
                                    <div class="input-pwd-wrap">
                                        <input type="password" name="password_baru" id="pwdBaru" class="form-control"
                                               placeholder="Masukkan password baru" required
                                               style="padding-right:44px;"
                                               oninput="checkStrength(this.value); checkRules(this.value) ; tryEnableSubmit();">
                                        <button type="button" class="toggle-eye" onclick="togglePwd('pwdBaru','eyeBaru')">
                                            <i class="fas fa-eye" id="eyeBaru"></i>
                                        </button>
                                    </div>
                                    <!-- Strength bar -->
                                    <div class="strength-bar">
                                        <div class="strength-fill" id="strengthFill"></div>
                                    </div>
                                    <div class="strength-text" id="strengthText" style="color:var(--abu-teks);"></div>
                                </div>

                                <!-- Checklist Rules -->
                                <div style="background:var(--abu);border-radius:var(--radius-sm);padding:14px 16px;margin-bottom:22px;">
                                    <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;color:var(--hitam);margin-bottom:10px;">
                                        Syarat Password Aman:
                                    </div>
                                    <div class="rule-item" id="ruleLen">
                                        <div class="rule-icon"><i class="fas fa-check"></i></div>
                                        Minimal 8 karakter
                                    </div>
                                    <div class="rule-item" id="ruleUpper">
                                        <div class="rule-icon"><i class="fas fa-check"></i></div>
                                        Minimal 1 huruf kapital (A-Z)
                                    </div>
                                    <div class="rule-item" id="ruleNum">
                                        <div class="rule-icon"><i class="fas fa-check"></i></div>
                                        Minimal 1 angka (0-9)
                                    </div>
                                    <div class="rule-item" id="ruleSpecial">
                                        <div class="rule-icon"><i class="fas fa-check"></i></div>
                                        Minimal 1 karakter spesial (!@#$%^&*)
                                    </div>
                                </div>

                                <!-- Konfirmasi Password -->
                                <div style="margin-bottom:28px;">
                                    <label class="form-label">
                                        <i class="fas fa-check-double me-1" style="color:var(--merah);"></i>
                                        Konfirmasi Password Baru *
                                    </label>
                                    <div class="input-pwd-wrap">
                                        <input type="password" name="konfirmasi" id="pwdKonfirmasi" class="form-control"
                                               placeholder="Ulangi password baru" required
                                               style="padding-right:44px;"
                                               oninput="checkMatch(); tryEnableSubmit();">
                                        <button type="button" class="toggle-eye" onclick="togglePwd('pwdKonfirmasi','eyeKonfirmasi')">
                                            <i class="fas fa-eye" id="eyeKonfirmasi"></i>
                                        </button>
                                    </div>
                                    <div id="matchMsg" style="font-size:0.78rem;margin-top:6px;font-family:'Open Sans',sans-serif;"></div>
                                </div>

                                <!-- Tombol Submit -->
                                <button type="submit" id="btnSubmit" class="btn-submit" style="opacity:0.55;cursor:not-allowed;">
                                    <i class="fas fa-save me-2"></i>Simpan Password Baru
                                </button>

                                <!-- Info Keamanan -->
                                <div style="background:#FFF3CD;border-left:3px solid #F59E0B;border-radius:var(--radius-sm);padding:12px 16px;margin-top:18px;font-size:0.8rem;color:#92400E;line-height:1.7;">
                                    <i class="fas fa-shield-alt me-1"></i>
                                    <strong>Keamanan:</strong> Password disimpan menggunakan enkripsi
                                    <strong>bcrypt (cost 12)</strong>. Setelah berhasil, Anda akan
                                    <strong>otomatis logout</strong> dan diminta login ulang.
                                </div>
                            </form>
                            <?php else: ?>
                            <!-- Tampilkan ini jika berhasil (session sudah di-destroy) -->
                            <div style="text-align:center;padding:20px 0;">
                                <div style="font-size:3rem;margin-bottom:14px;">🎉</div>
                                <div style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;margin-bottom:8px;">Password Berhasil Diubah</div>
                                <p style="color:var(--abu-teks);font-size:0.9rem;">Anda akan diarahkan ke halaman login secara otomatis...</p>
                                <a href="login.php" style="display:inline-flex;align-items:center;gap:8px;background:var(--merah-tua);color:white;padding:12px 28px;border-radius:var(--radius-sm);font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.82rem;text-transform:uppercase;text-decoration:none;margin-top:14px;">
                                    <i class="fas fa-sign-in-alt"></i>Login Sekarang
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Tips Keamanan -->
                    <div style="background:white;border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-card);margin-top:20px;border-top:4px solid #F59E0B;">
                        <div style="font-family:'Montserrat',sans-serif;font-weight:900;font-size:0.82rem;text-transform:uppercase;color:var(--hitam);margin-bottom:14px;">
                            🛡️ Tips Keamanan Password
                        </div>
                        <?php
                        $tips = [
                            ['fas fa-check-circle','#10B981','Gunakan kombinasi huruf besar, kecil, angka, dan simbol'],
                            ['fas fa-check-circle','#10B981','Minimal 12 karakter untuk keamanan optimal'],
                            ['fas fa-check-circle','#10B981','Jangan gunakan nama, tanggal lahir, atau info pribadi'],
                            ['fas fa-check-circle','#10B981','Jangan bagikan password ke siapapun, termasuk tim'],
                            ['fas fa-check-circle','#10B981','Ganti password secara berkala setiap 3 bulan'],
                            ['fas fa-times-circle','#EF4444','Hindari password: admin123, password, 12345678'],
                        ];
                        foreach ($tips as $t): ?>
                        <div style="display:flex;gap:10px;align-items:flex-start;padding:6px 0;border-bottom:1px solid #F5F5F5;font-size:0.83rem;color:var(--abu-teks);">
                            <i class="<?= $t[0] ?>" style="color:<?= $t[1] ?>;margin-top:2px;flex-shrink:0;"></i>
                            <?= $t[2] ?>
                        </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
// ── Toggle tampilkan/sembunyikan password ──────
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// ── Cek aturan password secara real-time ───────
function checkRules(val) {
    const rules = {
        ruleLen:     val.length >= 8,
        ruleUpper:   /[A-Z]/.test(val),
        ruleNum:     /[0-9]/.test(val),
        ruleSpecial: /[\W_]/.test(val),
    };

    Object.entries(rules).forEach(function([id, valid]) {
        const el = document.getElementById(id);
        el.classList.toggle('valid',   valid);
        el.classList.toggle('invalid', val.length > 0 && !valid);
        if (val.length === 0) el.classList.remove('valid', 'invalid');
    });

    // Enable/disable tombol submit
    const allValid = Object.values(rules).every(Boolean);
    tryEnableSubmit();
    return allValid;
}

// ── Kekuatan password ─────────────────────────
function checkStrength(val) {
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    if (!val) { fill.style.width = '0'; text.textContent = ''; return; }

    let score = 0;
    if (val.length >= 8)  score++;
    if (val.length >= 12) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[\W_]/.test(val)) score++;

    const levels = [
        { pct: '20%', color: '#EF4444', label: 'Sangat Lemah' },
        { pct: '40%', color: '#F97316', label: 'Lemah' },
        { pct: '60%', color: '#F59E0B', label: 'Sedang' },
        { pct: '80%', color: '#22C55E', label: 'Kuat' },
        { pct: '100%',color: '#10B981', label: 'Sangat Kuat ✓' },
    ];

    const lvl = levels[Math.min(score, 4)];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    text.textContent      = lvl.label;
    text.style.color      = lvl.color;
}

// ── Cek kecocokan konfirmasi password ─────────
let allRulesValid = false;
function checkMatch() {
    const baru      = document.getElementById('pwdBaru').value;
    const konfirmasi= document.getElementById('pwdKonfirmasi').value;
    const msgEl     = document.getElementById('matchMsg');

    if (!konfirmasi) { msgEl.textContent = ''; tryEnableSubmit(false); return; }

    if (baru === konfirmasi) {
        msgEl.innerHTML = '<i class="fas fa-check-circle me-1" style="color:#10B981;"></i><span style="color:#065F46;">Password cocok!</span>';
        tryEnableSubmit(allRulesValid);
    } else {
        msgEl.innerHTML = '<i class="fas fa-times-circle me-1" style="color:#EF4444;"></i><span style="color:#B91C1C;">Password tidak cocok.</span>';
        tryEnableSubmit(false);
    }
}

function tryEnableSubmit() {
    const baru       = document.getElementById('pwdBaru').value;
    const konfirmasi = document.getElementById('pwdKonfirmasi').value;
    const btn        = document.getElementById('btnSubmit');

    const rulesOk =
        baru.length >= 8 &&
        /[A-Z]/.test(baru) &&
        /[0-9]/.test(baru) &&
        /[\W_]/.test(baru);

    const ready = rulesOk && baru === konfirmasi && konfirmasi.length > 0;

    btn.disabled = !ready;
    btn.style.opacity = ready ? '1' : '0.55';
    btn.style.cursor = ready ? 'pointer' : 'not-allowed';
}

// ── Konfirmasi sebelum submit ──────────────────
document.getElementById('formGantiPwd')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('btnSubmit');
    if (!confirm('Yakin ingin mengganti password? Anda akan otomatis logout setelah berhasil.')) {
        e.preventDefault(); return;
    }
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
    btn.disabled  = true;
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>