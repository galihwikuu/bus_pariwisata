<?php
$base_url = isset($base_url) ? $base_url : '';
$wa_number = '6281233624797';
$wa_msg = urlencode('Halo PT Janitra Surya Trans, saya ingin menanyakan informasi sewa bus pariwisata.');
?>

<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="row g-5">

            <!-- Brand -->
            <div class="col-lg-4 col-md-6">
                <div style="display:flex;justify-content:center;align-items:center;margin-bottom:14px;">
                    <div style=border-radius:10px;padding:8px 12px;display:flex;align-items:center;gap:8px;">
                        <img src="assets/images/logo.png" class="nav-logo-footer">
                    </div>
                </div>
                <p class="footer-desc">
                    PT Janitra Surya Trans — Perusahaan layanan transportasi bus pariwisata premium berbasis di Malang.
                    Berdiri sejak 24 April 2025. Motto kami: <em style="color:rgba(255,255,255,0.7);">"Anda Puas Beritahu Relasi, Anda Kecewa Beritahu Kami."</em>
                </p>
                <div class="footer-social">
                    <a href="https://wa.me/<?= $wa_number ?>" target="_blank" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="https://www.instagram.com/sewabuspariwisatamalang/?__pwa=1" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/Buspariwisatamalangbatu" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.sewabusmalang.com/" target="_blank" title="Website"><i class="fas fa-globe"></i></a>
                </div>
            </div>

            <!-- Menu -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6>Menu</h6>
                <ul class="footer-links">
                    <li><a href="<?= $base_url ?>index.php">Beranda</a></li>
                    <li><a href="<?= $base_url ?>detail-bus.php">Detail Bus</a></li>
                    <li><a href="<?= $base_url ?>galeri.php">Galeri</a></li>
                    <li><a href="<?= $base_url ?>booking.php">Booking</a></li>
                </ul>
            </div>

            <!-- Layanan -->
            <div class="col-lg-2 col-md-6 col-6">
                <h6>Layanan</h6>
                <ul class="footer-links">
                    <li><a href="#">Wisata Keluarga</a></li>
                    <li><a href="#">Study Tour</a></li>
                    <li><a href="#">Study Kampus</a></li>
                    <li><a href="#">Ziarah Wali</a></li>
                    <li><a href="#">Gathering</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div class="col-lg-4 col-md-6">
                <h6>Kontak Kami</h6>
                <div class="footer-contact-item">
                    <div class="fci"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="fct"><a href="https://www.google.com/maps/place/Jl.+Boro+Terong+Dowo+No.29,+Ulesari,+Tirtomoyo,+Kec.+Pakis,+Kabupaten+Malang,+Jawa+Timur+65154/@-7.9244014,112.6896801,17z/data=!3m1!4b1!4m6!3m5!1s0x2dd6295d9aefc995:0x6d43802d51063c3!8m2!3d-7.9244014!4d112.692255!16s%2Fg%2F11wb1hq619?entry=ttu&g_ep=EgoyMDI2MDUzMS4wIKXMDSoASAFQAw%3D%3D" target="_blank" style="color:rgba(255,255,255,0.5);">Jl. Boro Terong Dowo No.29, Tirtomoyo Pakis, Kabupaten Malang, Jawa Timur</a> </div>
                </div>
                <div class="footer-contact-item">
                    <div class="fci"><i class="fas fa-phone"></i></div>
                    <div class="fct"><a href="tel:+6281233624797" style="color:rgba(255,255,255,0.5);">0812-3362-4797</a></div>
                </div>
                <div class="footer-contact-item">
                    <div class="fci"><i class="fab fa-whatsapp"></i></div>
                    <div class="fct"><a href="https://wa.me/<?= $wa_number ?>" target="_blank" style="color:rgba(255,255,255,0.5);">Chat WhatsApp</a></div>
                </div>
                <div class="footer-contact-item">
                    <div class="fci"><i class="fas fa-globe"></i></div>
                    <div class="fct"><a href="https://www.sewabusmalang.com/" target="_blank" style="color:rgba(255,255,255,0.5);">www.sewabusmalang.com</a></div>
                </div>
                <div class="footer-contact-item">
                    <div class="fci"><i class="fas fa-clock"></i></div>
                    <div class="fct">Senin - Minggu: 07.00 - 20.00 WIB</div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <p class="mb-0">
                © <?= date('Y') ?> <span>PT Janitra Surya Trans</span>. All Rights Reserved.
                | Powered by <span>LayananBusPariwisata</span>
            </p>
        </div>
    </div>
</footer>

<!-- WA FLOAT -->
<div class="wa-float">
    <a href="https://wa.me/<?= $wa_number ?>?text=<?= $wa_msg ?>" target="_blank" title="Chat WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $base_url ?>assets/js/main.js"></script>
</body>
</html>
