-- ============================================================
-- DATABASE: peminjaman_alat
-- Stored Procedure, Function, Trigger
-- ============================================================

-- Buat database
CREATE DATABASE IF NOT EXISTS peminjaman_alat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE peminjaman_alat;

DELIMITER $$

-- ============================================================
-- FUNCTION: hitung_denda
-- Menghitung total denda berdasarkan jumlah hari terlambat
-- ============================================================
CREATE FUNCTION IF NOT EXISTS hitung_denda(hari_terlambat INT)
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
    DECLARE tarif_per_hari DECIMAL(10,2) DEFAULT 5000.00;
    IF hari_terlambat <= 0 THEN
        RETURN 0;
    END IF;
    RETURN hari_terlambat * tarif_per_hari;
END$$

-- ============================================================
-- STORED PROCEDURE: sp_setujui_peminjaman
-- Menyetujui peminjaman dan update status alat
-- ============================================================
CREATE PROCEDURE IF NOT EXISTS sp_setujui_peminjaman(IN p_peminjaman_id INT)
BEGIN
    DECLARE v_alat_id INT;
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
        SELECT alat_id INTO v_alat_id FROM peminjaman WHERE id = p_peminjaman_id;
        UPDATE peminjaman SET status_peminjaman = 'disetujui' WHERE id = p_peminjaman_id;
        UPDATE alat SET status = 'dipinjam' WHERE id = v_alat_id;
    COMMIT;
END$$

-- ============================================================
-- STORED PROCEDURE: sp_proses_pengembalian
-- Memproses pengembalian alat dan hitung denda otomatis
-- ============================================================
CREATE PROCEDURE IF NOT EXISTS sp_proses_pengembalian(
    IN p_peminjaman_id INT,
    IN p_tgl_pengembalian DATE,
    IN p_kondisi_alat VARCHAR(50)
)
BEGIN
    DECLARE v_alat_id INT;
    DECLARE v_tgl_kembali DATE;
    DECLARE v_hari_terlambat INT DEFAULT 0;
    DECLARE v_total_denda DECIMAL(10,2) DEFAULT 0;
    DECLARE v_pengembalian_id INT;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;

    START TRANSACTION;
        SELECT alat_id, tgl_kembali INTO v_alat_id, v_tgl_kembali
        FROM peminjaman WHERE id = p_peminjaman_id;

        SET v_hari_terlambat = GREATEST(0, DATEDIFF(p_tgl_pengembalian, v_tgl_kembali));
        SET v_total_denda = hitung_denda(v_hari_terlambat);

        INSERT INTO pengembalian (peminjaman_id, tgl_pengembalian, kondisi_alat, denda, created_at, updated_at)
        VALUES (p_peminjaman_id, p_tgl_pengembalian, p_kondisi_alat, v_total_denda, NOW(), NOW());

        SET v_pengembalian_id = LAST_INSERT_ID();

        IF v_hari_terlambat > 0 THEN
            INSERT INTO denda (pengembalian_id, hari_terlambat, total_denda, created_at, updated_at)
            VALUES (v_pengembalian_id, v_hari_terlambat, v_total_denda, NOW(), NOW());
        END IF;

        UPDATE peminjaman SET status_peminjaman = 'dikembalikan' WHERE id = p_peminjaman_id;
        UPDATE alat SET status = 'tersedia', kondisi = p_kondisi_alat WHERE id = v_alat_id;
    COMMIT;
END$$

-- ============================================================
-- TRIGGER: after_peminjaman_disetujui
-- Otomatis update status alat saat peminjaman disetujui
-- ============================================================
CREATE TRIGGER IF NOT EXISTS after_peminjaman_disetujui
AFTER UPDATE ON peminjaman
FOR EACH ROW
BEGIN
    IF NEW.status_peminjaman = 'disetujui' AND OLD.status_peminjaman != 'disetujui' THEN
        UPDATE alat SET status = 'dipinjam' WHERE id = NEW.alat_id;
    END IF;

    IF NEW.status_peminjaman = 'ditolak' AND OLD.status_peminjaman = 'disetujui' THEN
        UPDATE alat SET status = 'tersedia' WHERE id = NEW.alat_id;
    END IF;
END$$

-- ============================================================
-- TRIGGER: after_pengembalian_insert
-- Otomatis update status alat saat pengembalian dicatat
-- ============================================================
CREATE TRIGGER IF NOT EXISTS after_pengembalian_insert
AFTER INSERT ON pengembalian
FOR EACH ROW
BEGIN
    DECLARE v_alat_id INT;
    DECLARE v_kondisi VARCHAR(50);

    SELECT alat_id INTO v_alat_id FROM peminjaman WHERE id = NEW.peminjaman_id;
    SET v_kondisi = NEW.kondisi_alat;

    UPDATE alat SET status = 'tersedia', kondisi = v_kondisi WHERE id = v_alat_id;
    UPDATE peminjaman SET status_peminjaman = 'dikembalikan' WHERE id = NEW.peminjaman_id;
END$$

DELIMITER ;

-- ============================================================
-- Contoh penggunaan:
-- CALL sp_setujui_peminjaman(1);
-- CALL sp_proses_pengembalian(1, '2025-02-10', 'baik');
-- SELECT hitung_denda(3); -- hasil: 15000
-- ============================================================
