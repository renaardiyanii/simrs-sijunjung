# Dokumentasi Fungsi Skip Antrian Admisi

## Overview

Implementasi fungsi untuk skip antrian admisi yang terintegrasi dengan API eksternal. Antrian yang di-skip akan tetap muncul di dashboard dengan status "skip" untuk tracking.

## Files yang Dimodifikasi

### 1. Controller: `application/modules/antrol/controllers/Antrol.php`

#### Fungsi Baru: `batalantrianadmisi()`

**Endpoint:** `POST /antrol/batalantrianadmisi`

**Parameter yang diterima:**
- `id` (required): ID antrian atau kodebooking
- `loket` (optional): Nama loket (default: 'ADMISI')
- `no_antrian` (optional): Nomor antrian

**Response Format:**
```json
{
    "success": true/false,
    "message": "Pesan status",
    "data": {
        "id": "ID antrian",
        "loket": "ADMISI",
        "no_antrian": "Nomor antrian",
        "status": "skip"
    },
    "api_response": {} // Response dari API eksternal
}
```

**API Integration:**
- Endpoint eksternal: `adminantrian/v2/panggilantrian` (sama dengan panggilantrian)
- Method: POST
- Data: `{"id": "...", "loket": "ADMISI", "no_antrian": "...", "status": "skip"}`
- Status: `"skip"` untuk menandai antrian di-skip

### 2. View: `application/modules/antrol/views/index.php`

#### Fungsi JavaScript yang Dimodifikasi/Ditambah:

**1. `batalantrian(data, useAdmisiEndpoint = false)`**
- Parameter tambahan `useAdmisiEndpoint` untuk memilih endpoint
- Jika `true`: panggil `/antrol/batalantrianadmisi` (POST)
- Jika `false`: panggil `/antrol/batalantrean` (GET) - fungsi lama

**2. `batalantrianadmisi(data)` - Fungsi Baru**
- Fungsi khusus untuk skip antrian admisi
- Include konfirmasi SweetAlert sebelum eksekusi
- Langsung panggil endpoint `/antrol/batalantrianadmisi`
- Auto-refresh setelah berhasil

## Cara Penggunaan

### 1. Memanggil dari Button/Event Handler

```javascript
// Skip antrian admisi dengan konfirmasi
onclick="batalantrianadmisi(dataObject)"
```

### 2. Format Data Object

```javascript
const dataObject = {
    id: "kodebooking_atau_id_antrian",    // Required
    kodebooking: "alternative_id",        // Alternative ID field
    loket: "ADMISI",                      // Optional, default ADMISI
    no_antrian: "A001",                   // Optional
    angkaantrean: "1"                     // Alternative no_antrian field
};
```

### 3. Contoh Implementasi di HTML

```html
<button onclick="batalantrianadmisi({id: '12345', kodebooking: '12345'})"
        class="btn btn-warning">
    Skip Antrian Admisi
</button>
```

## Error Handling

### Controller Level:
- Validasi method POST
- Validasi parameter required
- Try-catch untuk API calls
- Logging untuk debugging

### JavaScript Level:
- AJAX error handling
- SweetAlert untuk user feedback
- Auto-refresh pada sukses

## Debugging

### Log Files:
- `error_log()` pada setiap step di controller
- Parameter yang diterima
- Data yang dikirim ke API
- Response dari API

### Browser Console:
- Check network tab untuk request/response
- Console.log untuk debugging JavaScript

## Testing

### Manual Testing:
1. Buka halaman antrol
2. Klik tombol "Batal Antrian" pada antrian admisi
3. Konfirmasi pada dialog
4. Verify response dan refresh data

### API Testing:
```bash
curl -X POST http://your-domain/antrol/batalantrianadmisi \
  -d "id=12345&loket=ADMISI&no_antrian=A001"
```

## Dashboard Integration

### Status "Skip" di Dashboard Admisi
- Antrian yang di-skip akan muncul di `dashboard_antrian_admisi.php`
- Status: `"skip"` untuk tracking
- Tidak akan hilang dari dashboard, hanya berubah status
- Dapat di-filter di dashboard untuk monitoring

## Notes

- Fungsi ini menggunakan endpoint API yang **SAMA** dengan `panggilantrianadmisi()`
- Endpoint API: `adminantrian/v2/panggilantrian` (sama dengan panggil antrian)
- Status yang dikirim: `"skip"` untuk menandai antrian di-skip
- Parameter `id` adalah yang paling penting, parameter lain optional
- Konfirmasi user diperlukan sebelum eksekusi untuk mencegah skip tidak sengaja
- Antrian yang di-skip akan tetap visible di dashboard dengan status berbeda