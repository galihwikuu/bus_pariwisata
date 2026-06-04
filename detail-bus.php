<?php
$judul_halaman = 'Detail Bus';
$halaman_aktif = 'bus';
$base_url = '';
include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<section style="background:linear-gradient(135deg,var(--merah-gelap),var(--merah-tua));padding:65px 0;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;right:0;opacity:0.15;background-image:repeating-linear-gradient(45deg,white 0,white 8px,transparent 8px,transparent 20px);background-size:28px 28px;width:250px;height:100px;"></div>
    <div class="container" style="position:relative;z-index:1;">
        <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.5);">Armada Kami</div>
        <h1 style="font-family:'Montserrat',sans-serif;font-size:2.5rem;font-weight:900;color:white;text-transform:uppercase;margin-bottom:12px;">Detail Unit Bus</h1>
        <p style="color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto 16px;">Jetbus 3++ SHD Air Suspension — 2 Unit Bus Premium</p>
        <nav aria-label="breadcrumb"><ol class="breadcrumb justify-content-center" style="background:transparent;">
            <li class="breadcrumb-item"><a href="index.php" style="color:rgba(255,255,255,0.6);">Beranda</a></li>
            <li class="breadcrumb-item active" style="color:white;">Detail Bus</li>
        </ol></nav>
    </div>
</section>

<!-- DETAIL UTAMA -->
<section style="padding:90px 0;background:white;">
    <div class="container">
        <div class="row g-5">

            <!-- Galeri foto bus (persis seperti "FOTO UNIT" hal.4 proposal) -->
            <div class="col-lg-7 fade-in">
                <!-- Foto utama -->
                <div style="border-radius:var(--radius);overflow:hidden;margin-bottom:12px;position:relative;cursor:pointer;"
                    onclick="openLightbox('assets/images/janitra2.jpg','Bus Janitra Surya - 2 bus premium dengan fasilitas lengkap')">
                    <img id="mainBusImg"
                        src="assets/images/janitra99.jpg"
                        alt="Jetbus 3++ SHD Janitra Surya"
                        style="width:100%;height:380px;object-fit:cover;display:block;transition:transform 0.4s ease;">
                    <div style="position:absolute;top:14px;left:14px;background:var(--merah);color:white;padding:6px 16px;border-radius:4px;font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.72rem;text-transform:uppercase;letter-spacing:1px;">
                        ⭐ JETBUS 3++ SHD
                    </div>
                    <div style="position:absolute;top:14px;right:14px;background:rgba(0,0,0,0.55);color:white;padding:6px 12px;border-radius:4px;font-size:0.72rem;font-family:'Montserrat',sans-serif;">
                        <i class="fas fa-search-plus me-1"></i> Klik untuk perbesar
                    </div>
                </div>

                <!-- Grid thumbnail 6 foto (seperti "FOTO UNIT" di proposal hal.4) -->
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;">
                    <?php
                    $thumbs = [
                        ['assets/images/janitra2bus.jpg','Tampak Samping Kanan'],
                        ['assets/images/janitra_hitam.jpg','Tampak Depan'],
                        ['assets/images/janitra2.jpg','Di Lokasi Parkir'],
                        ['assets/images/interior.jpg','Interior Kabin'],
                        ['assets/images/janitra_hitam2.jpg','Di Perjalanan'],
                        ['assets/images/janitra1.jpg','Wisata'],
                    ];
                    foreach ($thumbs as $t): ?>
                    <div style="border-radius:var(--radius-sm);overflow:hidden;cursor:pointer;aspect-ratio:4/3;"
                        onclick="openLightbox('<?= str_replace('w=500','w=1200',$t[0]) ?>','<?= $t[1] ?>')">
                        <img src="<?= $t[0] ?>" alt="<?= $t[1] ?>"
                            style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s ease;display:block;"
                            onmouseover="this.style.transform='scale(1.08)'"
                            onmouseout="this.style.transform='scale(1)'">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Info & Spek -->
            <div class="col-lg-5 fade-in">
                <div style="display:inline-flex;align-items:center;gap:8px;background:#D1FAE5;color:#065F46;padding:6px 14px;border-radius:20px;font-size:0.75rem;font-weight:700;font-family:'Montserrat',sans-serif;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px;">
                    <span style="width:8px;height:8px;background:#10B981;border-radius:50%;animation:waPulse 1.5s infinite;"></span>
                    Tersedia untuk Booking
                </div>

                <h2 style="font-family:'Montserrat',sans-serif;font-size:1.8rem;font-weight:900;color:var(--hitam);text-transform:uppercase;margin-bottom:6px;">
                    Jetbus 3++ SHD
                </h2>
                <p style="color:var(--abu-teks);margin-bottom:6px;font-size:0.9rem;">Mesin: <strong>Hino RKJ8</strong> · Air Suspension System</p>
                <p style="color:var(--abu-teks);margin-bottom:6px;font-size:0.9rem;">Konfigurasi: <strong style="color:var(--merah);">2-2 · 50 Seat Reclining</strong></p>
                <div style="color:var(--merah);font-size:1rem;margin-bottom:20px;">★★★★★ <span style="font-size:0.8rem;color:var(--abu-teks);">Pelayanan Prima</span></div>

                <p style="color:var(--abu-teks);font-size:0.93rem;line-height:1.8;margin-bottom:24px; text-align: justify;">
                    Bus premium kami dilengkapi dengan Air Suspension System untuk kenyamanan maksimal.
                    Setiap detail dirancang untuk memberikan pengalaman perjalanan terbaik bagi penumpang.
                </p>

                <!-- Harga -->
                <div style="background:linear-gradient(135deg,var(--merah-tua),var(--merah-gelap));border-radius:var(--radius-sm);padding:22px;margin-bottom:20px;color:white;">
                    <div style="font-size:0.72rem;text-transform:uppercase;letter-spacing:2px;opacity:0.75;font-family:'Montserrat',sans-serif;margin-bottom:4px;">Estimasi Harga Sewa</div>
                    <div style="font-family:'Montserrat',sans-serif;font-size:1.8rem;font-weight:900;">Hubungi Kami</div>
                    <div style="font-size:0.8rem;opacity:0.8;margin-top:3px;">Harga menyesuaikan tujuan, durasi & unit</div>
                    <div style="background:rgba(255,255,255,0.1);border-radius:var(--radius-sm);padding:12px;margin-top:14px;font-size:0.8rem;opacity:0.9;line-height:1.7;">
                        ✅ Include: Jasa pengemudi + BBM<br>
                        ❌ Exclude: Tol, Parkir, Makan & tip crew
                    </div>
                </div>

                <div style="display:flex;gap:12px;">
                    <a href="booking.php" style="flex:1;background:var(--merah-tua);color:white;padding:14px;border-radius:var(--radius-sm);font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.85rem;text-transform:uppercase;text-align:center;letter-spacing:0.5px;text-decoration:none;transition:all 0.3s;"
                       onmouseover="this.style.background='var(--merah-gelap)'"
                       onmouseout="this.style.background='var(--merah-tua)'">
                        <i class="fas fa-calendar-check me-1"></i> Booking
                    </a>
                    <a href="https://wa.me/6281233624797" target="_blank"
                       style="background:#25D366;color:white;padding:14px 18px;border-radius:var(--radius-sm);font-size:1.1rem;flex-shrink:0;display:flex;align-items:center;text-decoration:none;transition:all 0.3s;"
                       onmouseover="this.style.background='#128C7E'"
                       onmouseout="this.style.background='#25D366'">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INTERIOR (seperti hal.5 proposal) -->
<section style="padding:80px 0;background:var(--abu);">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label" style="justify-content:center;">Interior Bus</div>
            <h2 class="section-title">Interior <span class="red">Premium</span></h2>
            <p class="section-subtitle mx-auto">Kursi reclining hitam-merah premium dengan desain sporty dan elegan.</p>
        </div>
        <div class="row g-3">
            <?php
            $interior_imgs = [
                ['assets/images/interior.jpg','Interior Bus',true],
                ['assets/images/kursi-belakang.jpg','Kursi Tampak Belakang',false],
                ['assets/images/interior dalam 1.jpg','Kursi Tampak Depan',false],
                ['assets/images/Usb.jpg','USB Charger',false],
                ['assets/images/Bagasi_dalam.jpg','Bagasi dalam yang luas',true],
                ['assets/images/bose.jpg','Bose Sound System',false],
            ];
            foreach ($interior_imgs as $img): ?>
            <div class="col-<?= $img[2] ? 'md-8' : 'md-4' ?>">
                <div style="border-radius:var(--radius-sm);overflow:hidden;cursor:pointer;aspect-ratio:<?= $img[2] ? '16/9' : '4/3' ?>;"
                    onclick="openLightbox('<?= str_replace(['w=700','w=500'],['w=1400','w=1200'],$img[0]) ?>','<?= $img[1] ?>')">
                    <img src="<?= $img[0] ?>" alt="<?= $img[1] ?>"
                        style="width:100%;height:100%;object-fit:cover;display:block;transition:transform 0.5s ease;"
                        onmouseover="this.style.transform='scale(1.06)'"
                        onmouseout="this.style.transform='scale(1)'">
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- FASILITAS LENGKAP (dari proposal hal.3) -->
<section style="padding:80px 0;background:white;">
    <div class="container">
        <div class="text-center mb-5">
            <div class="section-label" style="justify-content:center;">Spesifikasi Fasilitas</div>
            <h2 class="section-title">Fasilitas <span class="red">Bus</span></h2>
            <p class="section-subtitle mx-auto">Semua fasilitas sesuai dengan proposal resmi PT Janitra Surya Trans.</p>
        </div>
        <div class="row g-4">
            <?php
            $fasilitas_detail = [
                ['❄️','AC Dingin','AC berkualitas tinggi untuk kenyamanan penumpang di seluruh kabin.','#EF5350'],
                ['🛏️','Bantal & Selimut','Setiap penumpang mendapat bantal dan selimut untuk istirahat nyaman.','#E53935'],
                ['💧','Dispenser & Welcome Drink','Air minum tersedia dan welcome drink di awal perjalanan.','#C62828'],
                ['📺','Android TV','Layar Android TV besar untuk hiburan selama perjalanan.','#B71C1C'],
                ['🎤','Mic Wireless','Mic wireless untuk karaoke, presentasi, atau announcer.','#EF5350'],
                ['🔌','USB Charger Tiap Kursi','Port USB di setiap kursi agar gadget Anda selalu penuh baterai.','#E53935'],
                ['🧳','Bagasi Luas','Ruang bagasi bawah yang sangat besar untuk seluruh rombongan.','#B71C1C'],
                ['🛡️','APAR & Palu Kaca (K3)','Standar keselamatan K3 terpenuhi di setiap perjalanan.','#EF5350'],
                ['🌬️','Air Suspension System','Suspensi udara untuk perjalanan mulus meski jalan tidak rata.','#E53935'],
            ];
            foreach ($fasilitas_detail as $i => $f): ?>
            <div class="col-6 col-lg-4 col-md-4 fade-in" data-delay="<?= $i*50 ?>">
                <div class="fasilitas-item" style="background:var(--abu);border-radius:var(--radius-sm);padding:22px;display:flex;align-items:flex-start;gap:14px;border-left:4px solid <?= $f[3] ?>;transition:var(--transition);"
                     onmouseover="this.style.background='white';this.style.boxShadow='var(--shadow-card)'"
                     onmouseout="this.style.background='var(--abu)';this.style.boxShadow='none'">
                    <div style="width:44px;height:44px;background:<?= $f[3] ?>;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;"><?= $f[0] ?></div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.85rem;text-transform:uppercase;color:var(--hitam);margin-bottom:5px;"><?= $f[1] ?></div>
                        <p style="font-size:0.82rem;color:var(--abu-teks);line-height:1.65;margin:0;"><?= $f[2] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- HARGA & SYARAT (dari proposal hal.6) -->

<!-- CTA -->
<section class="cta-section">
    <div class="container" style="position:relative;z-index:1;">
        <h2>SIAP MEMESAN BUS?</h2>
        <p>Hubungi kami sekarang dan dapatkan penawaran terbaik!</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="booking.php" class="btn-merah-putih"><i class="fas fa-calendar-check"></i> Booking Online</a>
            <a href="https://wa.me/6281233624797" target="_blank" class="btn-outline-putih"><i class="fab fa-whatsapp"></i> 0812-3362-4797</a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
