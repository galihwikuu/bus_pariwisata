<?php
$halaman_aktif = isset($halaman_aktif) ? $halaman_aktif : '';
$base_url = isset($base_url) ? $base_url : '';
$judul_halaman = isset($judul_halaman) ? $judul_halaman : 'Home';
$wa_number = '6281233624797';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?> — PT Janitra Surya Trans</title>
    <meta name="description" content="PT Janitra Surya Trans - Sewa Bus Pariwisata Premium Malang. Jetbus 3++ SHD, 50 Seat Reclining, AC, TV Android, Berpengalaman.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="<?= $base_url ?>assets/css/style.css" rel="stylesheet">
</head>

<body>
<!-- TOP BAR -->
<div class="navbar-topbar">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-phone me-1"></i>
                <a href="tel:+6281233624797">0812-3362-4797</a>
                &nbsp;|&nbsp;
                <i class="fas fa-map-marker-alt me-1"></i>
                Jl. Boro Terong Dowo No.29, Tirtomoyo Pakis, Kab. Malang
            </div>
            <div>
                <a href="https://www.sewabusmalang.com/" target="_blank">
                    <i class="fas fa-globe me-1"></i>sewabusmalang.com
                </a>
            </div>
        </div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar-js">
    <div class="container">
        <div class="nav-inner">
            <a class="navbar-brand-js" href="<?= $base_url ?>index.php">
                <div class="brand-logo-box">
                    <img src="assets/images/logo.png" class="nav-logo">
                </div>
            </a>

            <button class="nav-toggler" id="navToggler">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="<?= $base_url ?>index.php"       class="<?= $halaman_aktif==='home'    ? 'active' : '' ?>">Beranda</a></li>
                <li><a href="<?= $base_url ?>detail-bus.php"  class="<?= $halaman_aktif==='bus'     ? 'active' : '' ?>">Detail Bus</a></li>
                <li><a href="<?= $base_url ?>galeri.php"      class="<?= $halaman_aktif==='galeri'  ? 'active' : '' ?>">Galeri</a></li>
                <li><a href="<?= $base_url ?>booking.php"     class="<?= $halaman_aktif==='booking' ? 'active' : '' ?> nav-booking">Booking Sekarang</a></li>
            </ul>
        </div>
    </div>
</nav>
