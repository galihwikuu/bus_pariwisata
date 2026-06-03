<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); exit;
}

include '../config/koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
$total = mysqli_num_rows($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Galeri</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>

<body style="background:var(--abu);">

<div class="admin-layout">

    <!-- SIDEBAR -->
    <?php include 'includes/sidebar.php'; ?>

    <div class="admin-main">

        <!-- TOPBAR (SAMA PERSIS DATA-BOOKING) -->
        <div class="admin-topbar">
            <div>
                <h5 style="margin:0;font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:0.95rem;">
                    <i class="fas fa-images me-2" style="color:var(--merah);"></i>Data Galeri
                </h5>
                <div style="font-size:0.75rem;color:var(--abu-teks);">
                    Kelola semua foto galeri
                </div>
            </div>
            <a href="logout.php" style="background:var(--abu);color:var(--abu-teks);padding:7px 14px;border-radius:4px;font-size:0.78rem;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;text-transform:uppercase;letter-spacing:0.5px;border:1px solid var(--abu-medium);">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
            </a>
        </div>

        <div class="admin-content">

            <!-- FORM UPLOAD (STYLE SAMA CARD BOOKING) -->
            <div style="background:white;border-radius:var(--radius);padding:20px 22px;box-shadow:var(--shadow-card);margin-bottom:20px;border-top:4px solid var(--merah);">

                <h5 style="font-family:'Montserrat',sans-serif;font-weight:900;text-transform:uppercase;font-size:0.9rem;margin-bottom:18px;">
                    Upload Foto Baru
                </h5>

                <form action="proses-galeri.php" method="POST" enctype="multipart/form-data">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Judul Foto</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="eksterior">Foto Unit</option>
                                <option value="interior">Interior</option>
                                <option value="wisata">Wisata</option>
                                <option value="studytour">Study Tour</option>
                                <option value="ziarah">Ziarah</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control" required>
                        </div>

                        <div class="col-12">
                            <button type="submit"
                                style="background:var(--merah-tua);color:white;border:none;padding:10px 16px;border-radius:var(--radius-sm);font-family:'Montserrat',sans-serif;font-weight:800;text-transform:uppercase;">
                                Upload Foto
                            </button>
                        </div>

                    </div>

                </form>
            </div>

            <!-- INFO -->
            <div style="font-size:0.82rem;color:var(--abu-teks);margin-bottom:12px;font-family:'Montserrat',sans-serif;">
                Total <strong style="color:var(--hitam);"><?= $total ?></strong> foto
            </div>

            <!-- TABLE (STYLE PERSIS DATA-BOOKING) -->
            <div style="background:white;border-radius:var(--radius);box-shadow:var(--shadow-card);overflow:hidden;border-top:4px solid var(--merah);">

                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;min-width:800px;">

                        <thead style="background:linear-gradient(135deg,var(--merah-tua),var(--merah-gelap));">
                            <tr>
                                <th style="padding:13px 15px;color:white;font-size:0.7rem;text-transform:uppercase;">No</th>
                                <th style="padding:13px 15px;color:white;font-size:0.7rem;text-transform:uppercase;">Foto</th>
                                <th style="padding:13px 15px;color:white;font-size:0.7rem;text-transform:uppercase;">Judul</th>
                                <th style="padding:13px 15px;color:white;font-size:0.7rem;text-transform:uppercase;">Kategori</th>
                                <th style="padding:13px 15px;color:white;font-size:0.7rem;text-transform:uppercase;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php $no=1; while($g=mysqli_fetch_assoc($query)): ?>
                            <tr style="border-bottom:1px solid #F5F5F5;">

                                <td style="padding:13px 15px;font-weight:700;"><?= $no++ ?></td>

                                <td style="padding:13px 15px;">
                                    <img src="../assets/images/galeri/<?= $g['foto'] ?>"
                                         style="width:90px;height:60px;object-fit:cover;border-radius:8px;">
                                </td>

                                <td style="padding:13px 15px;font-weight:700;color:var(--hitam);">
                                    <?= htmlspecialchars($g['judul']) ?>
                                </td>

                                <td style="padding:13px 15px;color:var(--abu-teks);">
                                    <?= ucfirst($g['kategori']) ?>
                                </td>

                                <td style="padding:13px 15px;">

                                    <a href="edit-galeri.php?id=<?= $g['id'] ?>"
                                       style="background:#EFF6FF;color:#1E40AF;padding:6px 10px;border-radius:6px;text-decoration:none;font-size:0.75rem;font-weight:700;">
                                        ✏ Edit
                                    </a>

                                    <a href="hapus-galeri.php?id=<?= $g['id'] ?>"
                                       onclick="return confirm('Hapus foto ini?')"
                                       style="background:#FEE2E2;color:#B91C1C;padding:6px 10px;border-radius:6px;text-decoration:none;font-size:0.75rem;font-weight:700;">
                                        🗑 Hapus
                                    </a>

                                </td>

                            </tr>
                        <?php endwhile; ?>

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>