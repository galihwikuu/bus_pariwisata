<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'janitra_surya');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$conn) {
    die('<div style="text-align:center;padding:50px;font-family:Arial;">
        <h2 style="color:red;">❌ Koneksi Database Gagal!</h2>
        <p>Pastikan MySQL sudah berjalan dan database sudah di-import.</p>
        <p>Error: ' . mysqli_connect_error() . '</p>
    </div>');
}
mysqli_set_charset($conn, 'utf8mb4');
?>
