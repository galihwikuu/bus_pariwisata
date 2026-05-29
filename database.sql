-- ============================================
-- DATABASE: janitra_surya
-- PT Janitra Surya Trans - Bus Pariwisata
-- ============================================

CREATE DATABASE IF NOT EXISTS janitra_surya CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE janitra_surya;

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- password: admin123
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

CREATE TABLE IF NOT EXISTS booking (
    id_booking INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    tanggal DATE NOT NULL,
    tujuan VARCHAR(255) NOT NULL,
    jumlah_penumpang INT NOT NULL,
    catatan TEXT,
    status ENUM('Pending','Disetujui','Selesai','Dibatalkan') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO booking (nama, no_hp, tanggal, tujuan, jumlah_penumpang, catatan, status) VALUES
('PT Pesta Pora Abadi', '081233624797', '2025-11-27', 'Singosari - Whiz Hotel Trawas', 80, 'Gathering perusahaan 80-100 peserta, 2 hari', 'Disetujui'),
('Budi Santoso', '081234567890', '2025-06-20', 'Ziarah Wali Songo Jawa Tengah', 45, '', 'Pending'),
('SMA Negeri 1 Malang', '082345678901', '2025-07-10', 'Bali Study Tour', 50, 'Study tour 3 hari 2 malam', 'Pending');
