<?php
$judul_halaman = 'Booking';
$halaman_aktif = 'booking';
$base_url = '';
include 'config/koneksi.php';

$pesan_sukses = '';
$pesan_error  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama             = trim(mysqli_real_escape_string($conn, $_POST['nama'] ?? ''));
    $no_hp            = trim(mysqli_real_escape_string($conn, $_POST['no_hp'] ?? ''));
    $tanggal          = mysqli_real_escape_string($conn, $_POST['tanggal'] ?? '');
    $tujuan           = trim(mysqli_real_escape_string($conn, $_POST['tujuan'] ?? ''));
    $jumlah_penumpang = intval($_POST['jumlah_penumpang'] ?? 0);
    $catatan          = trim(mysqli_real_escape_string($conn, $_POST['catatan'] ?? ''));

    $errors = [];
    if (empty($nama))   $errors[] = 'Nama tidak boleh kosong.';
    if (empty($no_hp))  $errors[] = 'Nomor HP tidak boleh kosong.';
    if (empty($tanggal))$errors[] = 'Tanggal keberangkatan wajib diisi.';
    if (empty($tujuan)) $errors[] = 'Tujuan perjalanan wajib diisi.';
    if ($jumlah_penumpang < 1 || $jumlah_penumpang > 50) $errors[] = 'Jumlah penumpang harus 1–50 orang.';
    if (!empty($tanggal) && strtotime($tanggal) < strtotime(date('Y-m-d'))) $errors[] = 'Tanggal tidak boleh di masa lalu.';

    if (empty($errors)) {
        $sql = "INSERT INTO booking (nama, no_hp, tanggal, tujuan, jumlah_penumpang, catatan, status)
                VALUES ('$nama','$no_hp','$tanggal','$tujuan',$jumlah_penumpang,'$catatan','Pending')";
        if (mysqli_query($conn, $sql)) {
            $id_baru = mysqli_insert_id($conn);
            $pesan_sukses = "Booking berhasil! ID Anda: <strong>#JS" . str_pad($id_baru, 4, '0', STR_PAD_LEFT) . "</strong>. Tim kami akan menghubungi Anda via WhatsApp dalam 1×24 jam.";
        } else {
            $pesan_error = 'Terjadi kesalahan teknis. Silakan coba lagi.';
        }
    } else {
        $pesan_error = implode('<br>', $errors);
    }
}
include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<section style="background:linear-gradient(135deg,var(--merah-gelap),var(--merah-tua));padding:65px 0;text-align:center;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;right:0;opacity:0.15;background-image:repeating-linear-gradient(45deg,white 0,white 8px,transparent 8px,transparent 20px);background-size:28px 28px;width:250px;height:100px;"></div>
    <div class="container" style="position:relative;z-index:1;">
        <div class="section-label" style="justify-content:center;color:rgba(255,255,255,0.5);">Reservasi Online</div>
        <h1 style="font-family:'Montserrat',sans-serif;font-size:2.5rem;font-weight:900;color:white;text-transform:uppercase;margin-bottom:12px;">Form Booking Bus</h1>
        <p style="color:rgba(255,255,255,0.75);max-width:500px;margin:0 auto 16px;">Isi form di bawah ini untuk memesan bus pariwisata PT Janitra Surya Trans.</p>
        <nav aria-label="breadcrumb"><ol class="breadcrumb justify-content-center" style="background:transparent;">
            <li class="breadcrumb-item"><a href="index.php" style="color:rgba(255,255,255,0.6);">Beranda</a></li>
            <li class="breadcrumb-item active" style="color:white;">Booking</li>
        </ol></nav>
    </div>
</section>

<!-- BOOKING SECTION -->
<section class="booking-section">
    <div class="container">
        <div class="row g-5 justify-content-center">

            <!-- FORM -->
            <div class="col-lg-7">

                <?php if (!empty($pesan_sukses)): ?>
                <div class="alert-auto" style="background:linear-gradient(135deg,#D1FAE5,#A7F3D0);border-left:5px solid #10B981;border-radius:var(--radius-sm);padding:22px 24px;margin-bottom:24px;display:flex;gap:14px;align-items:flex-start;transition:all 0.5s;">
                    <div style="width:46px;height:46px;background:#10B981;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">✅</div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;color:#065F46;font-size:0.9rem;text-transform:uppercase;margin-bottom:5px;">Booking Berhasil Diterima!</div>
                        <div style="color:#047857;font-size:0.88rem;line-height:1.65;"><?= $pesan_sukses ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if (!empty($pesan_error)): ?>
                <div class="alert-auto" style="background:#FEE2E2;border-left:5px solid var(--merah);border-radius:var(--radius-sm);padding:22px 24px;margin-bottom:24px;display:flex;gap:14px;align-items:flex-start;transition:all 0.5s;">
                    <div style="width:46px;height:46px;background:var(--merah);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;color:white;">❌</div>
                    <div>
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;color:var(--merah-tua);font-size:0.9rem;text-transform:uppercase;margin-bottom:5px;">Terjadi Kesalahan</div>
                        <div style="color:#B91C1C;font-size:0.88rem;line-height:1.65;"><?= $pesan_error ?></div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="booking-card fade-in">
                    <div style="margin-bottom:28px;">
                        <h3 style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);text-transform:uppercase;font-size:1.1rem;margin-bottom:6px;">
                            <i class="fas fa-clipboard-list me-2" style="color:var(--merah);"></i>Form Pemesanan Bus
                        </h3>
                        <p style="color:var(--abu-teks);font-size:0.85rem;margin:0;">* Kolom bertanda bintang wajib diisi. Konfirmasi via WhatsApp dalam 1×24 jam.</p>
                    </div>

                    <form id="bookingForm" method="POST" action="">
                        <div class="row g-4">

                            <!-- Nama -->
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-user me-1" style="color:var(--merah);"></i> Nama Lengkap *</label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                       placeholder="Masukkan nama lengkap / instansi"
                                       value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>" required>
                                <div class="invalid-feedback">Nama tidak boleh kosong.</div>
                            </div>

                            <!-- No HP -->
                            <div class="col-md-6">
                                <label class="form-label"><i class="fab fa-whatsapp me-1" style="color:var(--merah);"></i> No. HP / WhatsApp *</label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp"
                                       placeholder="Contoh: 081233624797"
                                       value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>" required>
                                <div class="invalid-feedback">Masukkan nomor HP yang valid.</div>
                            </div>

                            <!-- Tanggal -->
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-calendar me-1" style="color:var(--merah);"></i> Tanggal Keberangkatan *</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal"
                                       value="<?= htmlspecialchars($_POST['tanggal'] ?? '') ?>" required>
                                <div class="invalid-feedback">Pilih tanggal keberangkatan.</div>
                            </div>

                            <!-- Jumlah Penumpang -->
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-users me-1" style="color:var(--merah);"></i> Jumlah Penumpang *</label>
                                <input type="number" class="form-control" id="jumlah_penumpang" name="jumlah_penumpang"
                                       placeholder="Maks. 50 orang" min="1" max="50"
                                       value="<?= htmlspecialchars($_POST['jumlah_penumpang'] ?? '') ?>" required>
                                <div class="form-text" style="font-size:0.77rem;">Kapasitas bus: 50 kursi (konfigurasi 2-2)</div>
                                <div class="invalid-feedback">Jumlah penumpang 1–50 orang.</div>
                            </div>

                            <!-- Tujuan -->
                            <div class="col-12">
                                <label class="form-label"><i class="fas fa-map-marker-alt me-1" style="color:var(--merah);"></i> Tujuan Perjalanan *</label>
                                <input type="text" class="form-control" id="tujuan" name="tujuan"
                                       placeholder="Contoh: Singosari – Whiz Hotel Trawas"
                                       value="<?= htmlspecialchars($_POST['tujuan'] ?? '') ?>" required>
                                <div class="invalid-feedback">Masukkan tujuan perjalanan.</div>
                            </div>

                            <!-- Catatan -->
                            <div class="col-12">
                                <label class="form-label" style="font-weight:600;text-transform:none;letter-spacing:0;">
                                    <i class="fas fa-sticky-note me-1" style="color:var(--abu-teks);"></i>
                                    Catatan / Permintaan Khusus <span style="color:var(--abu-teks);font-weight:400;">(opsional)</span>
                                </label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"
                                          placeholder="Contoh: Mohon berangkat pukul 06.00, acara gathering 80 peserta, dll."><?= htmlspecialchars($_POST['catatan'] ?? '') ?></textarea>
                            </div>

                            <!-- Submit -->
                            <div class="col-12">
                                <button type="submit" class="btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan Booking
                                </button>
                                <p style="text-align:center;font-size:0.78rem;color:var(--abu-teks);margin-top:12px;">
                                    <i class="fas fa-lock me-1"></i>Data Anda aman &amp; tidak dibagikan ke pihak ketiga.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- SIDEBAR INFO -->
            <div class="col-lg-4">

                <!-- Kontak -->
                <div style="background:white;border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-card);border-top:4px solid var(--merah);margin-bottom:18px;" class="fade-in">
                    <div style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);font-size:0.85rem;text-transform:uppercase;margin-bottom:14px;">📞 Hubungi Langsung</div>
                    <p style="font-size:0.85rem;color:var(--abu-teks);margin-bottom:14px;line-height:1.7;">
                        Tim kami siap membantu 7 hari seminggu, pukul 07.00 – 20.00 WIB.
                    </p>
                    <a href="https://wa.me/6281233624797" target="_blank"
                       style="display:flex;align-items:center;gap:10px;background:#25D366;color:white;border-radius:var(--radius-sm);padding:12px 16px;text-decoration:none;font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.82rem;text-transform:uppercase;margin-bottom:10px;transition:all 0.3s;"
                       onmouseover="this.style.background='#128C7E'"
                       onmouseout="this.style.background='#25D366'">
                        <i class="fab fa-whatsapp" style="font-size:1.1rem;"></i>
                        Chat WhatsApp
                    </a>
                    <a href="tel:+6281233624797"
                       style="display:flex;align-items:center;gap:10px;background:var(--abu);color:var(--hitam);border-radius:var(--radius-sm);padding:12px 16px;text-decoration:none;font-family:'Montserrat',sans-serif;font-weight:700;font-size:0.82rem;">
                        <i class="fas fa-phone" style="color:var(--merah);"></i>
                        0812-3362-4797
                    </a>
                </div>

                <!-- Alur Booking -->
                <div style="background:white;border-radius:var(--radius);padding:24px;box-shadow:var(--shadow-card);border-top:4px solid var(--merah);" class="fade-in">
                    <div style="font-family:'Montserrat',sans-serif;font-weight:900;color:var(--hitam);font-size:0.85rem;text-transform:uppercase;margin-bottom:16px;">📋 Alur Booking</div>
                    <?php
                    $steps = [
                        ['Isi Form','Lengkapi form booking di atas dengan benar'],
                        ['Konfirmasi','Kami hubungi via WhatsApp maks. 1×24 jam'],
                        ['DP 35%','Bayar DP minimum 35% dari total sewa'],
                        ['Lunas','Pelunasan maks. 3 hari sebelum keberangkatan'],
                        ['Berangkat!','Bus siap menjemput sesuai jadwal yang disepakati'],
                    ];
                    foreach ($steps as $i => $s): ?>
                    <div style="display:flex;gap:12px;margin-bottom:14px;align-items:flex-start;">
                        <div style="width:26px;height:26px;background:var(--merah-tua);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:900;color:white;flex-shrink:0;font-family:'Montserrat',sans-serif;">
                            <?= $i+1 ?>
                        </div>
                        <div>
                            <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.82rem;color:var(--hitam);text-transform:uppercase;"><?= $s[0] ?></div>
                            <div style="font-size:0.78rem;color:var(--abu-teks);margin-top:2px;"><?= $s[1] ?></div>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Syarat ringkas -->
                    <div style="background:var(--abu);border-radius:var(--radius-sm);padding:14px;margin-top:6px;font-size:0.78rem;color:var(--abu-teks);line-height:1.75;border-left:3px solid var(--merah);">
                        ⚠️ Pembatalan min. 14 hari sebelum keberangkatan.<br>
                        Ganti rugi pembatalan: <strong>45%</strong> dari biaya sewa.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
