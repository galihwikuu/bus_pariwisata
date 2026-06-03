<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php'); exit;
}

include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = mysqli_query($conn, "SELECT * FROM galeri WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = (int)$_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $foto_lama = $_POST['foto_lama'];

    $foto = $foto_lama;

    if (!empty($_FILES['foto']['name'])) {

        $foto = time() . "_" . basename($_FILES['foto']['name']);

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            "../assets/images/galeri/" . $foto
        );

        if (!empty($foto_lama) && file_exists("../assets/images/galeri/" . $foto_lama)) {
            unlink("../assets/images/galeri/" . $foto_lama);
        }
    }

    mysqli_query($conn, "
        UPDATE galeri
        SET judul='$judul',
            kategori='$kategori',
            foto='$foto'
        WHERE id='$id'
    ");

    header("Location: galeri.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Galeri</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<link href="../assets/css/style.css" rel="stylesheet">
</head>

<body style="background:var(--abu);">

<div class="admin-layout">

    <!-- SIDEBAR -->
    <?php include 'includes/sidebar.php'; ?>

    <div class="admin-main">

        <!-- TOPBAR (SAMA KAYAK BOOKING) -->
        <div class="admin-topbar">
            <div>
                <h5 style="margin:0;font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:0.95rem;">
                    <i class="fas fa-pen me-2" style="color:var(--merah);"></i>Edit Galeri
                </h5>
                <div style="font-size:0.75rem;color:var(--abu-teks);">
                    Ubah data foto galeri
                </div>
            </div>

            <a href="galeri.php" style="background:var(--abu);color:var(--abu-teks);padding:7px 14px;border-radius:4px;font-size:0.78rem;font-weight:700;font-family:'Montserrat',sans-serif;text-decoration:none;">
                ← Kembali
            </a>
        </div>

        <div class="admin-content">

            <!-- FORM CARD STYLE BOOKING -->
            <div style="background:white;border-radius:var(--radius);padding:22px;box-shadow:var(--shadow-card);border-top:4px solid var(--merah);">

                <form method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="id" value="<?= $data['id'] ?>">
                    <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Judul Foto</label>
                            <input type="text" name="judul" class="form-control"
                                   value="<?= htmlspecialchars($data['judul']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kategori</label>
                            <select name="kategori" class="form-select" required>
                                <option value="eksterior" <?= $data['kategori']=='eksterior'?'selected':'' ?>>Foto Unit</option>
                                <option value="interior" <?= $data['kategori']=='interior'?'selected':'' ?>>Interior</option>
                                <option value="wisata" <?= $data['kategori']=='wisata'?'selected':'' ?>>Wisata</option>
                                <option value="studytour" <?= $data['kategori']=='studytour'?'selected':'' ?>>Study Tour</option>
                                <option value="ziarah" <?= $data['kategori']=='ziarah'?'selected':'' ?>>Ziarah</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Foto Saat Ini</label>
                            <br>
                            <img src="../assets/images/galeri/<?= $data['foto'] ?>"
                                 style="width:180px;height:120px;object-fit:cover;border-radius:10px;border:1px solid #ddd;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <div class="col-12">
                            <button type="submit"
                                style="background:var(--merah-tua);color:white;border:none;padding:10px 16px;border-radius:var(--radius-sm);font-family:'Montserrat',sans-serif;font-weight:800;text-transform:uppercase;">
                                Simpan Perubahan
                            </button>
                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

</body>
</html>