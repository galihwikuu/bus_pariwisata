<?php
include '../config/koneksi.php';

if (!$conn) {
    die("Koneksi gagal");
}

$query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");

if (!$query) {
    die(mysqli_error($conn));
}
?>

<!DOCTYPE html>

<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kelola Galeri</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    background:#f4f6f9;
    font-family:Arial, sans-serif;
    padding:30px;
}

.container{
    max-width:1200px;
    margin:auto;
}

.card{
    background:#fff;
    border-radius:15px;
    padding:25px;
    margin-bottom:25px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.card h2{
    margin-bottom:20px;
    color:#c62828;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
}

.form-control{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
}

.btn{
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
}

.btn-primary{
    background:#c62828;
    color:white;
}

.btn-primary:hover{
    background:#a61f1f;
}

.btn-edit{
    background:#f39c12;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
}

.btn-hapus{
    background:#e74c3c;
    color:white;
    padding:8px 12px;
    border-radius:6px;
    text-decoration:none;
}

.table{
    width:100%;
    border-collapse:collapse;
}

.table th{
    background:#c62828;
    color:white;
    padding:12px;
    text-align:left;
}

.table td{
    padding:12px;
    border-bottom:1px solid #eee;
    vertical-align:middle;
}

.table tr:hover{
    background:#fafafa;
}

.thumb{
    width:120px;
    height:80px;
    object-fit:cover;
    border-radius:8px;
    border:1px solid #ddd;
}

.action-buttons{
    display:flex;
    gap:8px;
}

.badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    background:#f1f1f1;
    font-size:12px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.back-btn{
    background:#444;
    color:white;
    padding:10px 15px;
    border-radius:8px;
    text-decoration:none;
}

@media(max-width:768px){
    body{
        padding:15px;
    }

    .table{
        display:block;
        overflow-x:auto;
    }
}
</style>

</head>
<body>

<div class="container">

<div class="header">
    <h1>📸 Kelola Galeri</h1>
    <a href="dashboard.php" class="back-btn">
        ← Dashboard
    </a>
</div>

<!-- FORM UPLOAD -->

<div class="card">

    <h2>Upload Foto Baru</h2>

    <form action="proses-galeri.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Judul Foto</label>
            <input
                type="text"
                name="judul"
                class="form-control"
                required>
        </div>

        <div class="form-group">
            <label>Kategori</label>

            <select
                name="kategori"
                class="form-control"
                required>

                <option value="eksterior">Foto Unit</option>
                <option value="interior">Interior</option>
                <option value="wisata">Wisata</option>
                <option value="studytour">Study Tour</option>
                <option value="ziarah">Ziarah</option>

            </select>
        </div>

        <div class="form-group">
            <label>Pilih Foto</label>

            <input
                type="file"
                name="foto"
                class="form-control"
                accept="image/*"
                required>
        </div>

        <button type="submit" class="btn btn-primary">
            Upload Foto
        </button>

    </form>

</div>

<!-- DAFTAR GALERI -->

<div class="card">

    <h2>Daftar Foto Galeri</h2>

    <table class="table">

        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>

        <?php
        $no = 1;
        while($g = mysqli_fetch_assoc($query)):
        ?>

        <tr>

            <td><?= $no++ ?></td>

            <td>
                <img
                    src="../assets/images/galeri/<?= $g['foto'] ?>"
                    class="thumb">
            </td>

            <td>
                <?= htmlspecialchars($g['judul']) ?>
            </td>

            <td>
                <span class="badge">
                    <?= ucfirst(htmlspecialchars($g['kategori'])) ?>
                </span>
            </td>

            <td>

                <div class="action-buttons">

                    <a
                        href="edit-galeri.php?id=<?= $g['id'] ?>"
                        class="btn-edit">
                        ✏ Edit
                    </a>

                    <a
                        href="hapus-galeri.php?id=<?= $g['id'] ?>"
                        class="btn-hapus"
                        onclick="return confirm('Yakin ingin menghapus foto ini?')">
                        🗑 Hapus
                    </a>

                </div>

            </td>

        </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

</div>

</body>
</html>

