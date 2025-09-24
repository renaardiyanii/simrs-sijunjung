-- Migration untuk menambah kolom tracking antrian farmasi
-- Tanggal: 2024-09-24
-- permintaan_obat adalah VIEW, jadi perlu update tabel sumbernya

-- 1. Menambah kolom ke tabel daftar_ulang_irj
ALTER TABLE daftar_ulang_irj
ADD COLUMN status_antrian_farmasi VARCHAR(20) DEFAULT 'menunggu',
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;

-- 2. Menambah kolom ke tabel pasien_luar
ALTER TABLE pasien_luar
ADD COLUMN status_antrian_farmasi VARCHAR(20) DEFAULT 'menunggu',
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;

-- 3. Menambah kolom ke tabel pasien_iri
ALTER TABLE pasien_iri
ADD COLUMN status_antrian_farmasi VARCHAR(20) DEFAULT 'menunggu',
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;

-- 4. Update VIEW permintaan_obat untuk include kolom baru
DROP VIEW IF EXISTS permintaan_obat;
CREATE VIEW permintaan_obat AS
SELECT b.nama,
    a.no_register,
    a.no_medrec,
    b.no_cm,
    to_char(a.tgl_kunjungan, 'YYYY-MM-DD'::text) AS tgl_kunjungan,
    a.kelas_pasien AS kelas,
    a.obat,
    a.id_poli AS idrg,
    c.nm_poli AS bed,
    a.cara_bayar,
    a.farmasi,
    a.wkt_telaah_obat,
    a.no_sep,
    a.waktu_resep_dokter AS tgl,
    b.alamat,
    a.status_antrian_farmasi,
    a.waktu_panggil_farmasi,
    a.waktu_selesai_farmasi
FROM daftar_ulang_irj a
LEFT JOIN data_pasien b ON a.no_medrec = b.no_medrec
LEFT JOIN poliklinik c ON a.id_poli::text = c.id_poli::text
UNION
SELECT pasien_luar.nama,
    pasien_luar.no_register,
    pasien_luar.no_cm AS no_medrec,
    pasien_luar.no_cm::text AS no_cm,
    to_char(pasien_luar.tgl_kunjungan, 'YYYY-MM-DD'::text) AS tgl_kunjungan,
    'II'::character varying AS kelas,
    pasien_luar.obat,
    'Pasien Langsung/Luar'::character varying AS idrg,
    'Pasien Langsung/Luar'::text AS bed,
    'UMUM'::character varying AS cara_bayar,
    pasien_luar.farmasi,
    pasien_luar.wkt_telaah_obat,
    ''::character varying AS no_sep,
    pasien_luar.tgl_kunjungan AS tgl,
    pasien_luar.alamat,
    pasien_luar.status_antrian_farmasi,
    pasien_luar.waktu_panggil_farmasi,
    pasien_luar.waktu_selesai_farmasi
FROM pasien_luar
UNION
SELECT pasien_iri.nama,
    pasien_iri.no_ipd AS no_register,
    c.no_medrec,
    c.no_cm,
    to_char(pasien_iri.tgl_masuk::timestamp with time zone, 'YYYY-MM-DD'::text) AS tgl_kunjungan,
    pasien_iri.klsiri AS kelas,
    pasien_iri.obat,
    pasien_iri.idrg,
    pasien_iri.bed,
    pasien_iri.carabayar AS cara_bayar,
    pasien_iri.farmasi,
    pasien_iri.wkt_telaah_obat,
    ''::character varying AS no_sep,
    pasien_iri.tgl_masuk AS tgl,
    c.alamat,
    pasien_iri.status_antrian_farmasi,
    pasien_iri.waktu_panggil_farmasi,
    pasien_iri.waktu_selesai_farmasi
FROM pasien_iri
LEFT JOIN data_pasien c ON pasien_iri.no_medrec = c.no_medrec;

-- 5. Menambah index untuk performa query pada tabel sumber
CREATE INDEX idx_daftar_ulang_irj_antrian_farmasi ON daftar_ulang_irj (status_antrian_farmasi, waktu_panggil_farmasi);
CREATE INDEX idx_daftar_ulang_irj_tgl_obat ON daftar_ulang_irj (tgl_kunjungan, obat);

CREATE INDEX idx_pasien_luar_antrian_farmasi ON pasien_luar (status_antrian_farmasi, waktu_panggil_farmasi);
CREATE INDEX idx_pasien_luar_tgl_obat ON pasien_luar (tgl_kunjungan, obat);

CREATE INDEX idx_pasien_iri_antrian_farmasi ON pasien_iri (status_antrian_farmasi, waktu_panggil_farmasi);
CREATE INDEX idx_pasien_iri_tgl_obat ON pasien_iri (tgl_masuk, obat);

-- 6. Komentar untuk dokumentasi
COMMENT ON COLUMN daftar_ulang_irj.status_antrian_farmasi IS 'Status antrian farmasi: menunggu, dipanggil, selesai';
COMMENT ON COLUMN daftar_ulang_irj.waktu_panggil_farmasi IS 'Waktu ketika antrian farmasi dipanggil';
COMMENT ON COLUMN daftar_ulang_irj.waktu_selesai_farmasi IS 'Waktu ketika pelayanan farmasi selesai';

COMMENT ON COLUMN pasien_luar.status_antrian_farmasi IS 'Status antrian farmasi: menunggu, dipanggil, selesai';
COMMENT ON COLUMN pasien_luar.waktu_panggil_farmasi IS 'Waktu ketika antrian farmasi dipanggil';
COMMENT ON COLUMN pasien_luar.waktu_selesai_farmasi IS 'Waktu ketika pelayanan farmasi selesai';

COMMENT ON COLUMN pasien_iri.status_antrian_farmasi IS 'Status antrian farmasi: menunggu, dipanggil, selesai';
COMMENT ON COLUMN pasien_iri.waktu_panggil_farmasi IS 'Waktu ketika antrian farmasi dipanggil';
COMMENT ON COLUMN pasien_iri.waktu_selesai_farmasi IS 'Waktu ketika pelayanan farmasi selesai';