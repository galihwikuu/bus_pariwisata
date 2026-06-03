<?php
$judul_halaman = 'Galeri';
$halaman_aktif = 'galeri';
$base_url = '';
include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<section style="background:linear-gradient(135deg,var(--merah-gelap),var(--merah-tua));padding:65px 0;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;right:0;opacity:0.15;background-image:repeating-linear-gradient(45deg,white 0,white 8px,transparent 8px,transparent 20px);background-size:28px 28px;width:250px;height:100px;"></div>
    <div class="container" style="position:relative;z-index:1;">
        <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.5);">Foto & Dokumentasi</div>
        <h1 style="font-family:'Montserrat',sans-serif;font-size:2.5rem;font-weight:900;color:white;text-transform:uppercase;margin-bottom:12px;">Galeri Kami</h1>
        <p style="color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto 16px;">
            Foto Unit Bus & Dokumentasi Perjalanan PT Janitra Surya Trans
        </p>
        <nav aria-label="breadcrumb"><ol class="breadcrumb justify-content-center" style="background:transparent;">
            <li class="breadcrumb-item"><a href="index.php" style="color:rgba(255,255,255,0.6);">Beranda</a></li>
            <li class="breadcrumb-item active" style="color:white;">Galeri</li>
        </ol></nav>
    </div>
</section>

<!-- FILTER -->
<section style="padding:36px 0 0;background:var(--abu);">
    <div class="container">
        <div class="d-flex justify-content-center flex-wrap gap-2" id="filterWrap">
            <button class="gal-filter active" data-filter="semua">Semua Foto</button>
            <button class="gal-filter" data-filter="eksterior">🚌 Foto Unit</button>
            <button class="gal-filter" data-filter="interior">🪑 Interior</button>
            <button class="gal-filter" data-filter="wisata">🏖️ Wisata</button>
            <button class="gal-filter" data-filter="studytour">🎓 Study Tour</button>
            <button class="gal-filter" data-filter="ziarah">🕌 Ziarah</button>
        </div>
    </div>
</section>

<style>
.gal-filter {
    background: white;
    color: var(--merah-tua);
    border: 2px solid var(--merah-tua);
    padding: 8px 20px;
    border-radius: 4px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s;
}
.gal-filter:hover,
.gal-filter.active {
    background: var(--merah-tua);
    color: white;
}
</style>

<!-- GALERI GRID -->
<section style="padding:30px 0 90px;background:var(--abu);">
    <div class="container">

        <?php
        include 'config/koneksi.php';

        $query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
        ?>

        <div id="galeriGrid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:8px;">

            <?php while($g = mysqli_fetch_assoc($query)): ?>

            <div class="g-item fade-in"
                 data-kat="<?= htmlspecialchars($g['kategori']) ?>"
                 style="aspect-ratio:4/3;"
                 onclick="openLightbox(
                    'assets/images/galeri/<?= htmlspecialchars($g['foto']) ?>',
                    '<?= htmlspecialchars($g['judul']) ?>'
                 )">

                <img src="assets/images/galeri/<?= htmlspecialchars($g['foto']) ?>"
                     alt="<?= htmlspecialchars($g['judul']) ?>">

                <div class="g-overlay">
                    <div>
                        <div style="font-size:0.68rem;color:rgba(255,255,255,0.65);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:4px;">
                            <?= ucfirst(htmlspecialchars($g['kategori'])) ?>
                        </div>

                        <div class="g-caption">
                            <?= htmlspecialchars($g['judul']) ?>
                        </div>
                    </div>

                    <div style="color:white;font-size:1.1rem;margin-left:auto;">
                        <i class="fas fa-expand-alt"></i>
                    </div>
                </div>

            </div>

            <?php endwhile; ?>

        </div>

        <!-- CTA kirim foto -->
        <div class="text-center mt-5 fade-in">
            <div style="background:white;border-radius:var(--radius);padding:32px;box-shadow:var(--shadow-card);display:inline-block;max-width:520px;border-top:4px solid var(--merah);">
                <div style="font-size:1.8rem;margin-bottom:10px;">📸</div>
                <h5 style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:0.95rem;margin-bottom:8px;">
                    Punya Foto Perjalanan Bersama Kami?
                </h5>
                <p style="color:var(--abu-teks);font-size:0.87rem;margin-bottom:18px;line-height:1.7;">
                    Kirimkan foto dokumentasi perjalanan Anda bersama bus Janitra Surya dan kami akan menampilkannya di galeri ini!
                </p>

                <a href="https://wa.me/6281233624797"
                   target="_blank"
                   style="display:inline-flex;align-items:center;gap:8px;background:#25D366;color:white;padding:11px 24px;border-radius:4px;font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.82rem;text-transform:uppercase;text-decoration:none;letter-spacing:0.5px;transition:all 0.3s;">
                    <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                </a>
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btns = document.querySelectorAll('.gal-filter');
    const items = document.querySelectorAll('#galeriGrid .g-item');

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const filter = this.dataset.filter;
            btns.forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');

            items.forEach(function (item) {
                if (filter === 'semua' || item.dataset.kat === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>
