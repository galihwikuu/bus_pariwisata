<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); exit;
}
include '../config/koneksi.php';
$halaman_admin = 'dashboard';

$total_all       = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM booking"))['t'];
$total_pending   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM booking WHERE status='Pending'"))['t'];
$total_disetujui = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM booking WHERE status='Disetujui'"))['t'];
$total_selesai   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS t FROM booking WHERE status='Selesai'"))['t'];
$booking_terbaru = mysqli_query($conn, "SELECT * FROM booking ORDER BY created_at DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Admin Janitra Surya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body style="background:var(--abu);">
<div class="admin-layout">
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>
    <?php include 'includes/sidebar.php'; ?>

    <div class="admin-main">

        <!-- Topbar -->
        <div class="admin-topbar">
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <div>
                <h5 style="margin:0;font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:0.95rem;">
                    <i class="fas fa-tachometer-alt me-2" style="color:var(--merah);"></i>Dashboard
                </h5>
                <div style="font-size:0.75rem;color:var(--abu-teks);"><?= date('l, d F Y') ?></div>
            </div>
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="text-align:right;">
                    <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.85rem;color:var(--hitam);"><?= htmlspecialchars($_SESSION['admin_username']) ?></div>
                    <div style="font-size:0.72rem;color:var(--abu-teks);">Administrator</div>
                </div>
                <div style="width:36px;height:36px;background:var(--merah-tua);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;font-size:0.9rem;">
                    <i class="fas fa-user"></i>
                </div>
                <a href="logout.php" style="background:var(--abu);color:var(--abu-teks);padding:7px 14px;border-radius:4px;font-size:0.78rem;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;border:1px solid var(--abu-medium);transition:all 0.3s;"
                   onmouseover="this.style.background='#FEE2E2';this.style.color='var(--merah)'"
                   onmouseout="this.style.background='var(--abu)';this.style.color='var(--abu-teks)'">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>

        <!-- Content -->
        <div class="admin-content">

            <!-- Stat Cards -->
            <div class="row g-4 mb-5">
                <?php
                $stats = [
                    ['Total Booking', $total_all,       '#1E40AF', '#DBEAFE', 'fa-calendar-check'],
                    ['Menunggu',      $total_pending,   '#92400E', '#FEF3C7', 'fa-clock'],
                    ['Disetujui',     $total_disetujui, '#065F46', '#D1FAE5', 'fa-check-circle'],
                    ['Selesai',       $total_selesai,   '#5B21B6', '#EDE9FE', 'fa-flag-checkered'],
                ];
                $border_colors = ['#1E40AF','#D97706','#10B981','#8B5CF6'];
                foreach ($stats as $i => $s): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="stat-card" style="border-left-color:<?= $border_colors[$i] ?>;">
                        <div class="stat-icon" style="background:<?= $s[3] ?>;color:<?= $s[2] ?>;">
                            <i class="fas <?= $s[4] ?>"></i>
                        </div>
                        <div>
                            <h3 style="color:<?= $s[2] ?>;"><?= $s[1] ?></h3>
                            <p><?= $s[0] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Tabel Booking Terbaru -->
            <div style="background:white;border-radius:var(--radius);box-shadow:var(--shadow-card);overflow:hidden;border-top:4px solid var(--merah);">
                <div style="padding:20px 24px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #F5F5F5;">
                    <h5 style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);margin:0;text-transform:uppercase;font-size:0.88rem;">
                        <i class="fas fa-list me-2" style="color:var(--merah);"></i>Booking Terbaru
                    </h5>
                    <a href="data-booking.php" style="font-size:0.8rem;color:var(--merah);font-weight:700;text-decoration:none;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:0.5px;">
                        Lihat Semua →
                    </a>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;min-width:750px;">
                        <thead style="background:linear-gradient(135deg,var(--merah-tua),var(--merah-gelap));">
                            <tr>
                                <?php foreach(['ID Booking','Nama / Instansi','No. HP','Tanggal','Tujuan','Penumpang','Status'] as $h): ?>
                                <th style="padding:12px 16px;font-size:0.72rem;color:white;text-transform:uppercase;letter-spacing:0.8px;font-weight:700;font-family:'Montserrat',sans-serif;white-space:nowrap;">
                                    <?= $h ?>
                                </th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($booking_terbaru) === 0): ?>
                            <tr><td colspan="7" style="text-align:center;padding:48px;color:var(--abu-teks);">
                                <div style="font-size:2.5rem;margin-bottom:10px;">📋</div>Belum ada data booking.
                            </td></tr>
                            <?php else: ?>
                            <?php while ($row = mysqli_fetch_assoc($booking_terbaru)):
                                $badge = ['Pending'=>'badge-pending','Disetujui'=>'badge-disetujui','Selesai'=>'badge-selesai','Dibatalkan'=>'badge-dibatalkan'][$row['status']] ?? 'badge-pending';
                            ?>
                            <tr style="border-bottom:1px solid #F5F5F5;"
                                onmouseover="this.style.background='#FFF5F5'"
                                onmouseout="this.style.background=''">
                                <td style="padding:13px 16px;font-size:0.82rem;font-weight:900;color:var(--merah-tua);font-family:'Montserrat',sans-serif;">
                                    #JS<?= str_pad($row['id_booking'],4,'0',STR_PAD_LEFT) ?>
                                </td>
                                <td style="padding:13px 16px;font-size:0.85rem;font-weight:700;color:var(--hitam);">
                                    <?= htmlspecialchars($row['nama']) ?>
                                </td>
                                <td style="padding:13px 16px;font-size:0.82rem;color:var(--abu-teks);">
                                    <?= htmlspecialchars($row['no_hp']) ?>
                                </td>
                                <td style="padding:13px 16px;font-size:0.82rem;color:var(--abu-teks);white-space:nowrap;">
                                    <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                </td>
                                <td style="padding:13px 16px;font-size:0.82rem;color:var(--abu-teks);max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                    <?= htmlspecialchars($row['tujuan']) ?>
                                </td>
                                <td style="padding:13px 16px;font-size:0.82rem;color:var(--abu-teks);text-align:center;">
                                    <?= $row['jumlah_penumpang'] ?> org
                                </td>
                                <td style="padding:13px 16px;">
                                    <span class="<?= $badge ?>"><?= $row['status'] ?></span>
                                </td>
                            </tr>
                            <?php endwhile; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="text-align:center;margin-top:36px;color:var(--abu-teks);font-size:0.78rem;font-family:'Montserrat',sans-serif;">
                © <?= date('Y') ?> PT Janitra Surya Trans · Admin Panel v1.0
            </div>
        </div>
    </div>
</div>
<script>
function toggleSidebar(){
    document.querySelector('.admin-sidebar').classList.toggle('active');
    document.querySelector('.sidebar-overlay').classList.toggle('active');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
