<?php
include '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

        if (
            !empty($foto_lama) &&
            file_exists("../assets/images/galeri/" . $foto_lama)
        ) {
            unlink("../assets/images/galeri/" . $foto_lama);
        }
    }

    mysqli_query($conn, "
        UPDATE galeri
        SET
            judul='$judul',
            kategori='$kategori',
            foto='$foto'
        WHERE id='$id'
    ");

    header("Location: galeri.php");
    exit;
}

// Ambil data
$query = mysqli_query($conn, "SELECT * FROM galeri WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data tidak ditemukan");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Galeri</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#f5f6fa;
        }

        .card-galeri{
            max-width:700px;
            margin:40px auto;
            border:none;
            border-radius:15px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }

        .preview{
            max-width:250px;
            border-radius:10px;
            border:1px solid #ddd;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="card card-galeri">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Edit Foto Galeri</h4>
        </div>

        <div class="card-body">

            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="hidden" name="foto_lama" value="<?= $data['foto'] ?>">

                <div class="mb-3">
                    <label class="form-label">Judul Foto</label>
                    <input
                        type="text"
                        name="judul"
                        class="form-control"
                        value="<?= htmlspecialchars($data['judul']) ?>"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Kategori</label>

                    <select name="kategori" class="form-select" required>
                        <option value="eksterior" <?= $data['kategori']=='eksterior'?'selected':'' ?>>
                            Eksterior
                        </option>

                        <option value="interior" <?= $data['kategori']=='interior'?'selected':'' ?>>
                            Interior
                        </option>

                        <option value="wisata" <?= $data['kategori']=='wisata'?'selected':'' ?>>
                            Wisata
                        </option>

                        <option value="studytour" <?= $data['kategori']=='studytour'?'selected':'' ?>>
                            Study Tour
                        </option>

                        <option value="ziarah" <?= $data['kategori']=='ziarah'?'selected':'' ?>>
                            Ziarah
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Saat Ini</label>
                    <br>

                    <img
                        src="../assets/images/galeri/<?= $data['foto'] ?>"
                        class="preview">
                </div>

                <div class="mb-4">
                    <label class="form-label">
                        Ganti Foto (Opsional)
                    </label>

                    <input
                        type="file"
                        name="foto"
                        class="form-control">
                </div>

                <button type="submit" class="btn btn-danger">
                    Simpan Perubahan
                </button>

                <a href="galeri.php" class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>
    </div>

</div>

</body>
</html>