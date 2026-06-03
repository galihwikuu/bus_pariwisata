<?php $halaman_admin = isset($halaman_admin) ? $halaman_admin : ''; ?>
<div class="admin-sidebar">
    <div class="sidebar-head">

        <div style="text-align:center;">

            <img src="../assets/images/logo.png"
                 alt="Logo Janitra Surya"
                 style="height:70px;margin-bottom:10px;filter: brightness(0) invert(1);">

            <div style="
                font-size:0.58rem;
                color:rgba(255,255,255,0.4);
                letter-spacing:2px;
                text-transform:uppercase;
                margin-top:3px;
            ">
                Admin Panel Janitra Surya
            </div>

        </div>

    </div>

    <div class="sidebar-menu">
        <div style="padding:12px 20px 4px;font-size:0.62rem;color:rgba(255,255,255,0.3);letter-spacing:2px;text-transform:uppercase;">Menu</div>
        <a href="dashboard.php" class="<?= $halaman_admin==='dashboard'?'active':'' ?>">
            <i class="fas fa-tachometer-alt" style="width:18px;text-align:center;"></i> Dashboard
        </a>
        <a href="data-booking.php" class="<?= $halaman_admin==='booking'?'active':'' ?>">
            <i class="fas fa-calendar-check" style="width:18px;text-align:center;"></i> Data Booking
        </a>
            <a href="galeri.php" class="<?= $halaman_admin==='galeri'?'active':'' ?>">
            <i class="fas fa-images" style="width:18px;text-align:center;"></i> Galeri
        </a>
        <div style="padding:12px 20px 4px;font-size:0.62rem;color:rgba(255,255,255,0.3);letter-spacing:2px;text-transform:uppercase;margin-top:8px;">Lainnya</div>
        <a href="../index.php" target="_blank">
            <i class="fas fa-external-link-alt" style="width:18px;text-align:center;"></i> Lihat Website
        </a>
        <a href="logout.php">
            <i class="fas fa-sign-out-alt" style="width:18px;text-align:center;"></i> Logout
        </a>
    </div>
</div>
