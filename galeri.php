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
        $galeri = [
            // FOTO UNIT (dari proposal hal.4)
            ['eksterior','https://images.unsplash.com/photo-1570125909232-eb263c188f7e?w=900&q=90','Bus Janitra Surya - Tampak Samping Kanan',true],
            ['eksterior','https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=600&q=85','Tampak Depan Bus',false],
            ['eksterior','https://images.unsplash.com/photo-1494515843206-f3117d3f51b7?w=600&q=80','Bus di Area Parkir',false],
            ['eksterior','https://images.unsplash.com/photo-1464219789935-c2d9d9aba644?w=900&q=85','Bus Siap Berangkat',true],
            ['eksterior','https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=600&q=80','Bus di Perjalanan',false],
            ['eksterior','https://images.unsplash.com/photo-1524055988636-436cfa46e59e?w=600&q=80','Bus Tampak Belakang',false],
            // INTERIOR (dari proposal hal.5)
            ['interior','https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=900&q=90','Interior Kabin - Tampak Belakang',true],
            ['interior','https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?w=600&q=80','Kursi Reclining Premium',false],
            ['interior','https://images.unsplash.com/photo-1567690187548-f07b1d7bf5a9?w=600&q=80','Android TV & Hiburan',false],
            ['interior','https://images.unsplash.com/photo-1585771724684-38269d6639fd?w=600&q=80','USB Charger di Setiap Kursi',false],
            ['interior','https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600&q=80','Bantal & Selimut',false],
            // WISATA
            ['wisata','https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=900&q=85','Wisata Pegunungan Bromo',true],
            ['wisata','https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600&q=80','Wisata Pantai Malang Selatan',false],
            ['wisata','https://images.unsplash.com/photo-1537953773345-d172ccf13cf1?w=600&q=80','Wisata Candi Borobudur',false],
            ['wisata','https://images.unsplash.com/photo-1598935888738-cd2622bcd437?w=600&q=80','Wisata Alam Jawa Timur',false],
            // STUDY TOUR
            ['studytour','https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=900&q=85','Study Tour SMA — Bali',true],
            ['studytour','https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&q=80','Study Tour SD Budi Utomo',false],
            ['studytour','https://images.unsplash.com/photo-1571260899304-425eee4c7efc?w=600&q=80','Study Kampus Mahasiswa',false],
            // ZIARAH
            ['ziarah','https://images.unsplash.com/photo-1587474260584-136574528ed5?w=900&q=85','Ziarah Wali Songo Jawa',true],
            ['ziarah','https://images.unsplash.com/photo-1545127398-14699f92334b?w=600&q=80','Ziarah Makam Sunan Kudus',false],
        ];
        ?>

        <div id="galeriGrid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:8px;">
            <?php foreach ($galeri as $g): ?>
            <div class="g-item fade-in <?= $g[2] ? '' : '' ?>"
                 data-kat="<?= $g[0] ?>"
                 style="<?= $g[3] ? 'grid-column:span 2;aspect-ratio:16/9;' : 'aspect-ratio:4/3;' ?>"
                 onclick="openLightbox('<?= str_replace(['w=900','w=600'],['w=1400','w=1200'],$g[1]) ?>','<?= htmlspecialchars($g[2]) ?>')">
                <img src="<?= $g[1] ?>" alt="<?= htmlspecialchars($g[2]) ?>">
                <div class="g-overlay">
                    <div>
                        <div style="font-size:0.68rem;color:rgba(255,255,255,0.65);text-transform:uppercase;letter-spacing:1.5px;margin-bottom:4px;"><?= ucfirst($g[0]) ?></div>
                        <div class="g-caption"><?= htmlspecialchars($g[2]) ?></div>
                    </div>
                    <div style="color:white;font-size:1.1rem;margin-left:auto;"><i class="fas fa-expand-alt"></i></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA kirim foto -->
        <div class="text-center mt-5 fade-in">
            <div style="background:white;border-radius:var(--radius);padding:32px;box-shadow:var(--shadow-card);display:inline-block;max-width:520px;border-top:4px solid var(--merah);">
                <div style="font-size:1.8rem;margin-bottom:10px;">📸</div>
                <h5 style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:0.95rem;margin-bottom:8px;">Punya Foto Perjalanan Bersama Kami?</h5>
                <p style="color:var(--abu-teks);font-size:0.87rem;margin-bottom:18px;line-height:1.7;">Kirimkan foto dokumentasi perjalanan Anda bersama bus Janitra Surya dan kami akan menampilkannya di galeri ini!</p>
                <a href="https://wa.me/6281233624797" target="_blank"
                   style="display:inline-flex;align-items:center;gap:8px;background:#25D366;color:white;padding:11px 24px;border-radius:4px;font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.82rem;text-transform:uppercase;text-decoration:none;letter-spacing:0.5px;transition:all 0.3s;"
                   onmouseover="this.style.background='#128C7E'"
                   onmouseout="this.style.background='#25D366'">
                    <i class="fab fa-whatsapp"></i> Kirim via WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container" style="position:relative;z-index:1;">
        <h2>SIAP BUAT KENANGAN BERSAMA KAMI?</h2>
        <p>Pesan bus kami sekarang dan ciptakan momen tak terlupakan bersama rombongan Anda.</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="booking.php" class="btn-merah-putih"><i class="fas fa-calendar-check"></i> Booking Sekarang</a>
            <a href="https://wa.me/6281233624797" target="_blank" class="btn-outline-putih"><i class="fab fa-whatsapp"></i> Hubungi Kami</a>
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
