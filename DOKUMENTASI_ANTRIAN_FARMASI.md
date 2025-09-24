# Dokumentasi Sistem Antrian Farmasi dengan Kolom Tracking Baru

## Perubahan Database

### Struktur `permintaan_obat` - VIEW, bukan tabel!

`permintaan_obat` adalah VIEW yang menggabungkan 3 tabel:
- `daftar_ulang_irj` - Pasien rawat jalan
- `pasien_luar` - Pasien luar/langsung
- `pasien_iri` - Pasien rawat inap

### Kolom Baru di Tabel Sumber

**Ditambah ke 3 tabel sumber:**
```sql
-- Tabel daftar_ulang_irj
ALTER TABLE daftar_ulang_irj
ADD COLUMN status_antrian_farmasi VARCHAR(20) DEFAULT 'menunggu',
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;

-- Tabel pasien_luar
ALTER TABLE pasien_luar
ADD COLUMN status_antrian_farmasi VARCHAR(20) DEFAULT 'menunggu',
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;

-- Tabel pasien_iri
ALTER TABLE pasien_iri
ADD COLUMN status_antrian_farmasi VARCHAR(20) DEFAULT 'menunggu',
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;
```

**Penjelasan Kolom:**
- `status_antrian_farmasi`: Status antrian farmasi ('menunggu', 'dipanggil', 'selesai')
- `waktu_panggil_farmasi`: Menyimpan waktu ketika antrian farmasi dipanggil
- `waktu_selesai_farmasi`: Menyimpan waktu ketika pelayanan farmasi selesai

**PENTING:** Field `farmasi` yang sudah ada tetap digunakan untuk tujuan aslinya dan tidak dimodifikasi.

## Status Tracking Flow

### 1. Status Awal (menunggu)
- `status_antrian_farmasi = 'menunggu'` (default)
- `waktu_panggil_farmasi = NULL`
- `waktu_selesai_farmasi = NULL`

### 2. Status Dipanggil
- `status_antrian_farmasi = 'dipanggil'`
- `waktu_panggil_farmasi = CURRENT_TIMESTAMP`
- `waktu_selesai_farmasi = NULL`

### 3. Status Selesai
- `status_antrian_farmasi = 'selesai'`
- `waktu_panggil_farmasi = [waktu sebelumnya]`
- `waktu_selesai_farmasi = CURRENT_TIMESTAMP`

## Fungsi-Fungsi Utama

### Model Antrol (`Mantrol.php`)

#### `panggil_antrian_farmasi($no_register, $no_antrian)`
```php
function panggil_antrian_farmasi($no_register, $no_antrian)
{
    $data = [
        'status_antrian_farmasi' => 'dipanggil',
        'waktu_panggil_farmasi' => date('Y-m-d H:i:s')
    ];
    return $this->update_source_table($no_register, $data);
}
```

#### `selesai_antrian_farmasi($no_register)`
```php
function selesai_antrian_farmasi($no_register)
{
    $data = [
        'status_antrian_farmasi' => 'selesai',
        'waktu_selesai_farmasi' => date('Y-m-d H:i:s')
    ];
    return $this->update_source_table($no_register, $data);
}
```

#### `update_source_table($no_register, $data)` - Helper Function
```php
private function update_source_table($no_register, $data)
{
    $prefix = substr($no_register, 0, 3);

    if ($prefix == 'PLF' || $prefix == 'PLL' || $prefix == 'PLR') {
        // Pasien luar (farmasi, lab, radiologi)
        return $this->db->where('no_register', $no_register)
            ->update('pasien_luar', $data);
    } else if (substr($no_register, 0, 2) == 'RI') {
        // Pasien rawat inap - key: no_ipd
        return $this->db->where('no_ipd', $no_register)
            ->update('pasien_iri', $data);
    } else {
        // Pasien rawat jalan (RJ prefix atau format lain)
        return $this->db->where('no_register', $no_register)
            ->update('daftar_ulang_irj', $data);
    }
}
```

### Query Status Tracking

```sql
SELECT
    ROW_NUMBER() OVER (ORDER BY p.tgl_kunjungan ASC, p.no_register ASC) AS noantrian,
    p.no_register, p.no_medrec, p.tgl_kunjungan, p.nama, p.kelas, p.obat, p.idrg, p.bed, p.cara_bayar,
    p.farmasi, p.wkt_telaah_obat, p.no_sep, p.tgl,
    COALESCE(dp.alamat, p.alamat, '') as alamat,
    dp.no_cm,
    (SELECT no_resep FROM resep_pasien WHERE no_register = p.no_register GROUP BY no_resep LIMIT 1) AS jml_resep,

    -- Status tracking menggunakan kolom baru
    CASE
        WHEN p.farmasi = 'dipanggil' OR p.farmasi = 'selesai' THEN '1'
        ELSE '0'
    END AS checkin,

    p.waktu_panggil_farmasi as waktu_panggil,
    p.waktu_selesai_farmasi as waktu_masuk_farmasi,

    CASE
        WHEN p.farmasi = 'selesai' THEN 'selesai'
        WHEN p.farmasi = 'dipanggil' THEN 'dipanggil'
        ELSE 'menunggu'
    END as status,

    ('F-' || LPAD(ROW_NUMBER() OVER (ORDER BY p.tgl_kunjungan ASC, p.no_register ASC)::text, 3, '0')) as no_antrian,
    p.nama as nama_pasien,
    p.waktu_panggil_farmasi as waktu_daftar
FROM
    permintaan_obat p
LEFT JOIN
    data_pasien dp ON p.no_medrec = dp.no_medrec
WHERE
    p.obat = '1'
    AND p.tgl_kunjungan = '$date'
ORDER BY
    p.tgl_kunjungan ASC, p.no_register ASC
```

## Interface Pengguna

### Button Status Logic

```php
if ($value->status == 'menunggu') {
    // Tombol hijau "Panggil"
    $antrian_buttons = "<button onclick=\"panggilAntrianFarmasi('$no_register','$antrian_number','$nama')\" class=\"btn btn-success btn-xs\">
        <i class=\"fa fa-volume-up\"></i> Panggil
    </button>";
} else if ($value->status == 'selesai') {
    // Badge abu-abu "Selesai" (disabled)
    $antrian_buttons = "<span class=\"btn btn-secondary btn-xs disabled\">
        <i class=\"fa fa-check\"></i> Selesai
    </span>";
} else if ($value->status == 'dipanggil') {
    // Tombol biru "Selesai"
    $antrian_buttons = "<button onclick=\"selesaiAntrianFarmasi('$no_register','$antrian_number','$nama')\" class=\"btn btn-info btn-xs\">
        <i class=\"fa fa-check\"></i> Selesai
    </button>";
}
```

## Keuntungan Kolom Terpisah

✅ **Data Integrity**: Kolom `wkt_telaah_obat` tetap bisa digunakan untuk fungsi aslinya
✅ **Granular Tracking**: Waktu panggil dan selesai terpisah dengan jelas
✅ **Performance**: Index khusus untuk query antrian farmasi
✅ **Maintainable**: Struktur data yang jelas dan mudah dipahami
✅ **Historical Data**: Dapat menyimpan riwayat waktu panggil dan selesai

## Migration Script

Jalankan SQL berikut untuk menerapkan perubahan:

```sql
-- File: database_migration_antrian_farmasi.sql
ALTER TABLE permintaan_obat
ADD COLUMN waktu_panggil_farmasi TIMESTAMP NULL,
ADD COLUMN waktu_selesai_farmasi TIMESTAMP NULL;

CREATE INDEX idx_permintaan_obat_farmasi_status ON permintaan_obat (farmasi, waktu_panggil_farmasi);
CREATE INDEX idx_permintaan_obat_tgl_obat ON permintaan_obat (tgl_kunjungan, obat);

COMMENT ON COLUMN permintaan_obat.waktu_panggil_farmasi IS 'Waktu ketika antrian farmasi dipanggil';
COMMENT ON COLUMN permintaan_obat.waktu_selesai_farmasi IS 'Waktu ketika pelayanan farmasi selesai';
```

## Testing

Untuk testing sistem:
1. Pastikan migration database sudah dijalankan
2. Test flow: menunggu → panggil → selesai
3. Verifikasi timestamp tersimpan dengan benar
4. Test refresh halaman untuk memastikan status persistent

## Files yang Dimodifikasi

1. `application/modules/antrol/models/Mantrol.php`
2. `application/modules/farmasi/models/Frmmdaftar.php`
3. `application/modules/farmasi/controllers/Frmcdaftar.php`
4. `application/views/farmasi/frmvdaftarpasien.php`
5. `database_migration_antrian_farmasi.sql` (file baru)