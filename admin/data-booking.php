<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); exit;
}

include '../config/koneksi.php';
$halaman_admin = 'booking';
$pesan = ''; $tipe = '';

// HAPUS
if (isset($_GET['hapus'])) {
    $id = intval($_GET['hapus']);
    if ($id > 0 && mysqli_query($conn, "DELETE FROM booking WHERE id_booking=$id")) {
        $pesan = "Booking #JS".str_pad($id,4,'0',STR_PAD_LEFT)." berhasil dihapus."; $tipe='success';
    } else { $pesan="Gagal menghapus data."; $tipe='danger'; }
}

// UPDATE STATUS
if (isset($_POST['update_status'])) {
    $id = intval($_POST['id_booking']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $allowed = ['Pending','Disetujui','Selesai','Dibatalkan'];
    if ($id > 0 && in_array($status, $allowed) && mysqli_query($conn,"UPDATE booking SET status='$status' WHERE id_booking=$id")) {
        $pesan = "Status booking #JS".str_pad($id,4,'0',STR_PAD_LEFT)." diubah menjadi <strong>$status</strong>."; $tipe='success';
    } else { $pesan="Gagal mengubah status."; $tipe='danger'; }
}

// FILTER & SEARCH
$filter_status = in_array($_GET['status']??'', ['Pending','Disetujui','Selesai','Dibatalkan']) ? $_GET['status'] : '';
$search = trim($_GET['cari'] ?? '');
$where = [];
if ($filter_status) $where[] = "status='".mysqli_real_escape_string($conn,$filter_status)."'";
if ($search)        $where[] = "(nama LIKE '%".mysqli_real_escape_string($conn,$search)."%' OR no_hp LIKE '%".mysqli_real_escape_string($conn,$search)."%' OR tujuan LIKE '%".mysqli_real_escape_string($conn,$search)."%')";
$where_sql = $where ? 'WHERE '.implode(' AND ', $where) : '';
$result = mysqli_query($conn, "SELECT * FROM booking $where_sql ORDER BY created_at DESC");
$total = mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Booking — Admin Janitra Surya</title>
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
                    <i class="fas fa-calendar-check me-2" style="color:var(--merah);"></i>Data Booking
                </h5>
                <div style="font-size:0.75rem;color:var(--abu-teks);">Kelola semua data pemesanan bus</div>
            </div>
            <a href="logout.php" style="background:var(--abu);color:var(--abu-teks);padding:7px 14px;border-radius:4px;font-size:0.78rem;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;border:1px solid var(--abu-medium);">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>

        <div class="admin-content">

            <!-- Notifikasi -->
            <?php if (!empty($pesan)): ?>
            <div style="background:<?= $tipe==='success'?'#D1FAE5':'#FEE2E2' ?>;border-left:4px solid <?= $tipe==='success'?'#10B981':'var(--merah)' ?>;border-radius:var(--radius-sm);padding:13px 18px;margin-bottom:22px;display:flex;align-items:center;gap:10px;font-size:0.87rem;color:<?= $tipe==='success'?'#065F46':'#B91C1C' ?>;">
                <i class="fas fa-<?= $tipe==='success'?'check-circle':'exclamation-circle' ?>"></i>
                <?= $pesan ?>
            </div>
            <?php endif; ?>

            <!-- Filter & Search -->
            <div style="background:white;border-radius:var(--radius);padding:20px 22px;box-shadow:var(--shadow-card);margin-bottom:20px;border-top:4px solid var(--merah);">
                <form method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;display:block;color:var(--hitam);">
                                🔍 Cari Booking
                            </label>
                            <input type="text" name="cari" class="form-control" placeholder="Nama, No. HP, atau Tujuan..." value="<?= htmlspecialchars($search) ?>">
                        </div>
                        <div class="col-md-3">
                            <label style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:0.72rem;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:6px;display:block;color:var(--hitam);">
                                📌 Filter Status
                            </label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <?php foreach(['Pending','Disetujui','Selesai','Dibatalkan'] as $s): ?>
                                <option value="<?= $s ?>" <?= $filter_status===$s?'selected':'' ?>><?= $s ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" style="background:var(--merah-tua);color:white;border:none;width:100%;padding:11px;border-radius:var(--radius-sm);font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.78rem;text-transform:uppercase;cursor:pointer;transition:all 0.3s;"
                                    onmouseover="this.style.background='var(--merah-gelap)'"
                                    onmouseout="this.style.background='var(--merah-tua)'">
                                <i class="fas fa-search me-1"></i>Cari
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="data-booking.php" style="background:var(--abu);color:var(--abu-teks);border:1px solid var(--abu-medium);width:100%;padding:11px;border-radius:var(--radius-sm);font-family:'Montserrat',sans-serif;font-weight:700;font-size:0.78rem;text-transform:uppercase;text-decoration:none;display:block;text-align:center;">
                                <i class="fas fa-times me-1"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Info jumlah -->
            <div style="font-size:0.82rem;color:var(--abu-teks);margin-bottom:12px;font-family:'Montserrat',sans-serif;">
                Menampilkan <strong style="color:var(--hitam);"><?= $total ?></strong> data booking
                <?= ($search || $filter_status) ? '(hasil filter)' : '' ?>
            </div>

            <!-- Tabel -->
            <div style="background:white;border-radius:var(--radius);box-shadow:var(--shadow-card);overflow:hidden;border-top:4px solid var(--merah);">
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;min-width:950px;">
                        <thead style="background:linear-gradient(135deg,var(--merah-tua),var(--merah-gelap));">
                            <tr>
                                <?php foreach(['ID','Nama / Instansi','No. HP','Tanggal','Tujuan','Penumpang','Status','Aksi'] as $h): ?>
                                <th style="padding:13px 15px;font-size:0.7rem;color:white;text-transform:uppercase;letter-spacing:0.8px;font-weight:700;font-family:'Montserrat',sans-serif;white-space:nowrap;"><?= $h ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($total === 0): ?>
                            <tr><td colspan="8" style="text-align:center;padding:60px;color:var(--abu-teks);">
                                <div style="font-size:3rem;margin-bottom:10px;">📋</div>
                                <div style="font-family:'Montserrat',sans-serif;font-weight:700;color:var(--hitam);margin-bottom:6px;text-transform:uppercase;font-size:0.85rem;">Data Tidak Ditemukan</div>
                                <div style="font-size:0.82rem;">Coba ubah kata kunci pencarian atau filter status.</div>
                            </td></tr>
                            <?php else: ?>
                            <?php while ($row = mysqli_fetch_assoc($result)):
                                $badge = ['Pending'=>'badge-pending','Disetujui'=>'badge-disetujui','Selesai'=>'badge-selesai','Dibatalkan'=>'badge-dibatalkan'][$row['status']] ?? 'badge-pending';
                            ?>
                            <tr style="border-bottom:1px solid #F5F5F5;"
                                onmouseover="this.style.background='#FFF5F5'"
                                onmouseout="this.style.background=''">
                                <!-- ID -->
                                <td style="padding:13px 15px;">
                                    <div style="font-family:'Montserrat',sans-serif;font-weight:900;font-size:0.82rem;color:var(--merah-tua);">
                                        #JS<?= str_pad($row['id_booking'],4,'0',STR_PAD_LEFT) ?>
                                    </div>
                                    <div style="font-size:0.68rem;color:var(--abu-teks);margin-top:2px;">
                                        <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
                                    </div>
                                </td>
                                <!-- Nama -->
                                <td style="padding:13px 15px;font-weight:700;font-size:0.85rem;color:var(--hitam);">
                                    <?= htmlspecialchars($row['nama']) ?>
                                </td>
                                <!-- No HP -->
                                <td style="padding:13px 15px;">
                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/','',$row['no_hp']) ?>" target="_blank"
                                       style="color:#25D366;font-size:0.82rem;text-decoration:none;font-weight:600;font-family:'Montserrat',sans-serif;">
                                        <i class="fab fa-whatsapp me-1"></i><?= htmlspecialchars($row['no_hp']) ?>
                                    </a>
                                </td>
                                <!-- Tanggal -->
                                <td style="padding:13px 15px;font-size:0.82rem;color:var(--abu-teks);white-space:nowrap;">
                                    <i class="fas fa-calendar me-1" style="color:var(--merah);"></i>
                                    <?= date('d M Y', strtotime($row['tanggal'])) ?>
                                </td>
                                <!-- Tujuan -->
                                <td style="padding:13px 15px;font-size:0.82rem;color:var(--abu-teks);max-width:190px;">
                                    <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="<?= htmlspecialchars($row['tujuan']) ?>">
                                        <i class="fas fa-map-marker-alt me-1" style="color:var(--merah);"></i>
                                        <?= htmlspecialchars($row['tujuan']) ?>
                                    </div>
                                    <?php if (!empty($row['catatan'])): ?>
                                    <div style="font-size:0.7rem;color:var(--abu-teks);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;" title="<?= htmlspecialchars($row['catatan']) ?>">
                                        📝 <?= htmlspecialchars(substr($row['catatan'],0,35)) ?>...
                                    </div>
                                    <?php endif; ?>
                                </td>
                                <!-- Penumpang -->
                                <td style="padding:13px 15px;text-align:center;">
                                    <span style="background:#EFF6FF;color:#1E40AF;padding:4px 12px;border-radius:20px;font-size:0.78rem;font-weight:700;font-family:'Montserrat',sans-serif;">
                                        👥 <?= $row['jumlah_penumpang'] ?>
                                    </span>
                                </td>
                                <!-- Status Dropdown -->
                                <td style="padding:13px 15px;">
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="id_booking" value="<?= $row['id_booking'] ?>">
                                        <select name="status" onchange="this.form.submit()"
                                                style="border:2px solid #E8E8E8;border-radius:20px;padding:4px 10px;font-size:0.75rem;font-weight:700;font-family:'Montserrat',sans-serif;cursor:pointer;background:white;outline:none;color:var(--hitam);">
                                            <?php foreach(['Pending','Disetujui','Selesai','Dibatalkan'] as $s): ?>
                                            <option value="<?= $s ?>" <?= $row['status']===$s?'selected':'' ?>><?= $s ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <input type="hidden" name="update_status" value="1">
                                    </form>
                                </td>
                                <!-- Aksi -->
                                <td style="padding:13px 15px;text-align:center;white-space:nowrap;">
                                    <button onclick='lihatDetail(<?= json_encode($row) ?>)'
                                            style="background:#EFF6FF;color:#1E40AF;border:none;border-radius:var(--radius-sm);padding:6px 11px;font-size:0.78rem;cursor:pointer;margin-right:4px;transition:all 0.2s;font-family:'Montserrat',sans-serif;font-weight:700;"
                                            title="Detail"
                                            onmouseover="this.style.background='#DBEAFE'"
                                            onmouseout="this.style.background='#EFF6FF'">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <a href="data-booking.php?hapus=<?= $row['id_booking'] ?>"
                                       onclick="return confirm('Hapus booking #JS<?= str_pad($row['id_booking'],4,'0',STR_PAD_LEFT) ?> atas nama <?= addslashes(htmlspecialchars($row['nama'])) ?>?')"
                                       style="background:#FEE2E2;color:#B91C1C;border:none;border-radius:var(--radius-sm);padding:6px 11px;font-size:0.78rem;text-decoration:none;display:inline-block;transition:all 0.2s;font-family:'Montserrat',sans-serif;font-weight:700;"
                                       title="Hapus"
                                       onmouseover="this.style.background='#FECACA'"
                                       onmouseout="this.style.background='#FEE2E2'">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div style="text-align:center;margin-top:36px;color:var(--abu-teks);font-size:0.75rem;font-family:'Montserrat',sans-serif;">
                © <?= date('Y') ?> PT Janitra Surya Trans · Admin Panel v1.0
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail -->
<div id="modalDetail" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:99999;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;border-radius:var(--radius);width:100%;max-width:480px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,0.25);">
        <div style="background:linear-gradient(135deg,var(--merah-tua),var(--merah-gelap));padding:20px 24px;display:flex;align-items:center;justify-content:space-between;">
            <h5 style="margin:0;color:white;font-family:'Montserrat',sans-serif;font-weight:900;text-transform:uppercase;font-size:0.88rem;">
                <i class="fas fa-info-circle me-2"></i>Detail Booking
            </h5>
            <button onclick="tutupModal()" style="background:rgba(255,255,255,0.15);border:none;color:white;width:30px;height:30px;border-radius:50%;cursor:pointer;font-size:1rem;">✕</button>
        </div>
        <div id="modalBody" style="padding:24px;"></div>
    </div>
</div>

<script>
function lihatDetail(data) {
    const id = 'JS' + String(data.id_booking).padStart(4,'0');
    const badgeBg   = {Pending:'#FFF3CD',Disetujui:'#D1FAE5',Selesai:'#DBEAFE',Dibatalkan:'#FEE2E2'};
    const badgeClr  = {Pending:'#856404',Disetujui:'#065F46',Selesai:'#1E40AF',Dibatalkan:'#991B1B'};
    document.getElementById('modalBody').innerHTML = `
        <div style="display:flex;align-items:center;gap:14px;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid #F5F5F5;">
            <div style="width:48px;height:48px;background:var(--merah-tua);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">🎫</div>
            <div>
                <div style="font-family:'Montserrat',sans-serif;font-weight:900;font-size:1rem;color:var(--hitam);">#${id}</div>
                <span style="background:${badgeBg[data.status]};color:${badgeClr[data.status]};padding:3px 12px;border-radius:20px;font-size:0.72rem;font-weight:700;font-family:'Montserrat',sans-serif;">${data.status}</span>
            </div>
        </div>
        <div style="display:grid;gap:12px;">
            ${[['👤 Nama',data.nama],['📱 No. HP',data.no_hp],['📅 Tanggal',new Date(data.tanggal).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'})],['📍 Tujuan',data.tujuan],['👥 Penumpang',data.jumlah_penumpang+' orang'],['📝 Catatan',data.catatan||'-'],['🕐 Dipesan',data.created_at]].map(([l,v])=>`
            <div style="display:flex;gap:10px;align-items:flex-start;">
                <div style="min-width:110px;font-size:0.8rem;color:var(--abu-teks);font-family:'Montserrat',sans-serif;">${l}</div>
                <div style="font-size:0.85rem;font-weight:700;color:var(--hitam);">: ${v||'-'}</div>
            </div>`).join('')}
        </div>
        <div style="margin-top:20px;padding-top:16px;border-top:1px solid #F5F5F5;display:flex;gap:10px;">
            <a href="https://wa.me/${data.no_hp.replace(/[^0-9]/g,'')}" target="_blank"
               style="flex:1;background:#25D366;color:white;padding:10px;border-radius:var(--radius-sm);text-align:center;text-decoration:none;font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.78rem;text-transform:uppercase;">
               <i class="fab fa-whatsapp me-1"></i>WhatsApp
            </a>
            <button onclick="tutupModal()"
                    style="flex:1;background:var(--abu);color:var(--abu-teks);border:1px solid var(--abu-medium);border-radius:var(--radius-sm);padding:10px;font-family:'Montserrat',sans-serif;font-weight:700;font-size:0.78rem;text-transform:uppercase;cursor:pointer;">
                Tutup
            </button>
        </div>`;
    document.getElementById('modalDetail').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function tutupModal() {
    document.getElementById('modalDetail').style.display = 'none';
    document.body.style.overflow = '';
}
document.getElementById('modalDetail').addEventListener('click', function(e) {
    if (e.target === this) tutupModal();
});
</script>

<script>
function toggleSidebar(){
    document.querySelector('.admin-sidebar').classList.toggle('active');
    document.querySelector('.sidebar-overlay').classList.toggle('active');
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
