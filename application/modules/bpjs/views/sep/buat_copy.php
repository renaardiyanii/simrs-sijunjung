<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form SEP - BPJS Kesehatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px 10px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3c72 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.05"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.05"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.03"/><circle cx="10" cy="50" r="1" fill="white" opacity="0.03"/><circle cx="90" cy="30" r="1" fill="white" opacity="0.03"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            animation: float 20s linear infinite;
            pointer-events: none;
        }

        @keyframes float {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .logo i {
            color: #2c5aa0;
            font-size: 24px;
        }

        .form-container {
            padding: 40px;
        }

        .section-title {
            color: #2c5aa0;
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 3px solid #e8f2ff;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #2c5aa0, #667eea);
            border-radius: 2px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: ' *';
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #2c5aa0;
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.1);
            transform: translateY(-1px);
        }

        .input-group {
            display: flex;
            gap: 0;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: none;
        }

        .input-group .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            white-space: nowrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3c72 100%);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .card {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-header {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #1e293b;
            padding: 15px 20px;
            margin: -20px -20px 20px -20px;
            border-radius: 10px 10px 0 0;
            font-weight: 600;
            border-bottom: 1px solid #cbd5e1;
        }

        .action-buttons {
            background: #f8fafc;
            padding: 30px 40px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .hidden {
            display: none !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 12px;
            }

            .header {
                padding: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .action-buttons {
                padding: 20px;
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .input-group {
                flex-direction: column;
            }

            .input-group .form-control {
                border-radius: 10px 10px 0 0;
                border-right: 2px solid #e5e7eb;
                border-bottom: none;
            }

            .input-group .btn {
                border-radius: 0 0 10px 10px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px 5px;
            }

            .header h1 {
                font-size: 1.75rem;
            }

            .header p {
                font-size: 1rem;
            }

            .form-container {
                padding: 15px;
            }

            .section-title {
                font-size: 1.2rem;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Hover Effects */
        .form-control:hover {
            border-color: #cbd5e1;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        /* Focus States */
        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="logo">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <h1>BPJS Kesehatan</h1>
                <p>Form Pembuatan SEP (Surat Eligibilitas Peserta)</p>
            </div>
        </div>

        <div class="form-container">
            <form id="formInsertPenanggungJawab">
                <input type="hidden" name="no_ipd" value="">
                <input type="hidden" name="no_medrec" value="">

                <div class="form-grid">
                    <!-- Left Column -->
                    <div class="left-column">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-id-card"></i> Data BPJS & SEP
                            </div>

                            <div class="form-group">
                                <label class="form-label">No. Kartu BPJS</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="Masukkan nomor kartu BPJS">
                                    <button class="btn btn-info" type="button" id="btn-cek-kartu">
                                        <i class="fas fa-search"></i> Cek Data
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tanggal SEP</label>
                                <input type="date" class="form-control" id="tgl_sep" value="">
                            </div>

                            <div class="form-group">
                                <label class="form-label">No. Telepon</label>
                                <input type="tel" class="form-control" id="no_telp_bpjs" placeholder="Contoh: 081234567890">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Tanggal Rujukan</label>
                                <input type="date" class="form-control" id="tgl_rujukan" name="tgl_rujukan" value="">
                            </div>

                            <div class="form-group hidden">
                                <label class="form-label">No. Rujukan</label>
                                <input type="text" class="form-control" name="no_rujukan" id="no_rujukan">
                            </div>

                            <div class="form-group hidden">
                                <label class="form-label">No. SEP</label>
                                <input type="text" class="form-control" name="no_sep" id="no_sep">
                            </div>

                            <div class="form-group">
                                <label class="form-label required">No. SPRI</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nosurat_skdp_sep" id="nosurat_skdp_sep" placeholder="Nomor SPRI">
                                    <button type="button" class="btn btn-success" onclick="bikinspri()">
                                        <i class="fas fa-plus"></i> Buat SPRI
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label required">DPJP Pemberi SPRI</label>
                                <select id="dpjp_skdp_sep" class="form-control" name="dpjp_skdp_sep">
                                    <option value="">-- Pilih Dokter --</option>
                                    <option value="dr1">Dr. Ahmad Fauzi, Sp.PD</option>
                                    <option value="dr2">Dr. Siti Nurhaliza, Sp.JP</option>
                                    <option value="dr3">Dr. Budi Santoso, Sp.OG</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kontraktor</label>
                                <input type="hidden" name="id_kontraktor_bpjs">
                                <select class="form-control" name="nmkontraktorbpjs" id="nmkontraktorbpjs">
                                    <option value="">Pilih Kontraktor</option>
                                    <option value="kontraktor1">PT. Kontraktor A</option>
                                    <option value="kontraktor2">PT. Kontraktor B</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Catatan SEP</label>
                                <textarea class="form-control" name="catatan" id="catatan" placeholder="Masukkan catatan jika diperlukan"></textarea>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-bed"></i> Kelas Rawat & Pembiayaan
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kelas Rawat Hak</label>
                                <input type="text" class="form-control" id="klsRawatHak" placeholder="Kelas rawat sesuai hak">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kelas Rawat Naik</label>
                                <select class="form-control" id="klsrawatnaik">
                                    <option value="">Pilih jika naik kelas</option>
                                    <option value="1">VVIP</option>
                                    <option value="2">VIP</option>
                                    <option value="3">Kelas 1</option>
                                    <option value="4">Kelas 2</option>
                                    <option value="5">Kelas 3</option>
                                    <option value="6">ICCU</option>
                                    <option value="7">ICU</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Pembiayaan</label>
                                <select class="form-control" id="pembiayaan" onchange="changePenanggungJawab(this.value)">
                                    <option value="">Pilih jenis pembiayaan</option>
                                    <option value="1-Pribadi">Pribadi</option>
                                    <option value="2-Pemberi Kerja">Pemberi Kerja</option>
                                    <option value="3-Asuransi Kesehatan Tambahan">Asuransi Kesehatan Tambahan</option>
                                </select>
                                <input type="hidden" class="form-control" id="penanggungjawab">
                            </div>

                            <div class="form-group">
                                <label class="form-label">P/I/S/A</label>
                                <select class="form-control" name="ketpembayarri">
                                    <option value="Ybs">Yang Bersangkutan</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Suami">Suami</option>
                                    <option value="Anak">Anak</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control" name="nmpembayatri" placeholder="Nama peserta BPJS">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Golongan</label>
                                <input type="text" class="form-control" name="golpembayarri" placeholder="Golongan peserta">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="right-column">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-user"></i> Data Penanggung Jawab
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Nama</label>
                                <input type="text" class="form-control" name="nmpjawabri" placeholder="Nama lengkap penanggung jawab" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenkel" id="jenkel" class="form-control">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="alamatpjawabri" placeholder="Alamat lengkap">
                            </div>

                            <div class="form-group">
                                <label class="form-label">No. Telepon / HP</label>
                                <input type="tel" class="form-control" name="notlppjawab" id="notlppjawab" placeholder="Contoh: 081234567890">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Kartu Identitas</label>
                                <div class="input-group">
                                    <select class="form-control" name="kartuidpjawab" style="flex: 0 0 120px;">
                                        <option value="KTP">KTP</option>
                                        <option value="SIM">SIM</option>
                                        <option value="PASPOR">PASPOR</option>
                                        <option value="KTM">KTM</option>
                                        <option value="NIK">NIK</option>
                                    </select>
                                    <input type="text" class="form-control" name="noidpjawab" placeholder="Nomor identitas" style="border-left: none; border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Hubungan Keluarga</label>
                                <select class="form-control" name="hubpjawabri">
                                    <option value="Suami">Suami</option>
                                    <option value="Istri">Istri</option>
                                    <option value="Ayah">Ayah</option>
                                    <option value="Ibu">Ibu</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Anak">Anak</option>
                                </select>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-users"></i> Nama Akses Tambahan
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nama Akses 1</label>
                                <input type="text" class="form-control" name="namaaksespjawabri1" placeholder="Nama orang yang berhak akses">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nama Akses 2</label>
                                <input type="text" class="form-control" name="namaaksespjawabri2" placeholder="Nama orang yang berhak akses">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Nama Akses 3</label>
                                <input type="text" class="form-control" name="namaaksespjawabri3" placeholder="Nama orang yang berhak akses">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="action-buttons">
            <button id="buatsepid" type="button" class="btn btn-info" onclick="buatsep()">
                <i class="fas fa-file-medical"></i> Buat SEP
            </button>
            <button type="button" class="btn btn-primary" onclick="document.getElementById('formInsertPenanggungJawab').submit()">
                <i class="fas fa-save"></i> Simpan Data
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // Set today's date for date inputs
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_sep').value = today;
            document.getElementById('tgl_rujukan').value = today;
        });

        // Initialize Select2 for better dropdowns
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                theme: 'default',
                width: '100%'
            });
        });

        // Modal Functions
        function showModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal(e.target.id);
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    closeModal(openModal.id);
                }
            }
        });

        // Function to get poli control (placeholder)
        function ambilpolikontrol(tanggal) {
            console.log('Mengambil data poliklinik untuk tanggal:', tanggal);
            // Here you would make an AJAX call to get poliklinik data
            // This is just a placeholder
        }

        // Function to get dokter surat kontrol (placeholder)
        function ambildoktersuratkontrol(poliId) {
            const dokterSelect = document.getElementById('dpjp_suratkontrol_bikin');
            dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
            
            // Simulate loading doctors based on poli selection
            if (poliId) {
                const doctors = {
                    'poli1': [
                        {value: 'dr1', text: 'Dr. Ahmad Fauzi, Sp.JP'},
                        {value: 'dr2', text: 'Dr. Siti Nurhaliza, Sp.JP'}
                    ],
                    'poli2': [
                        {value: 'dr3', text: 'Dr. Budi Santoso, Sp.P'},
                        {value: 'dr4', text: 'Dr. Maya Sari, Sp.P'}
                    ],
                    'poli3': [
                        {value: 'dr5', text: 'Dr. Andi Pratama, Sp.M'},
                        {value: 'dr6', text: 'Dr. Linda Wati, Sp.M'}
                    ],
                    'poli4': [
                        {value: 'dr7', text: 'Dr. Rudi Hartono, Sp.THT'},
                        {value: 'dr8', text: 'Dr. Dewi Lestari, Sp.THT'}
                    ],
                    'poli5': [
                        {value: 'dr9', text: 'Dr. Agus Setiawan, Sp.KK'},
                        {value: 'dr10', text: 'Dr. Rina Melati, Sp.KK'}
                    ]
                };
                
                if (doctors[poliId]) {
                    doctors[poliId].forEach(doctor => {
                        const option = document.createElement('option');
                        option.value = doctor.value;
                        option.textContent = doctor.text;
                        dokterSelect.appendChild(option);
                    });
                }
            }
        }

        // Function to create surat kontrol
        function buatsuratkontrol() {
            const noKartu = document.getElementById('no_sep_surat_bikin').value;
            const tanggal = document.getElementById('tgl_surat_bikin').value;
            const poli = document.getElementById('poli_suratkontrol_bikin').value;
            const dokter = document.getElementById('dpjp_suratkontrol_bikin').value;
            
            if (!noKartu || !tanggal || !poli || !dokter) {
                alert('Mohon lengkapi semua field yang diperlukan!');
                return;
            }
            
            // Add loading state
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading"></span> Membuat SPRI...';
            btn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Add new row to table
                const table = document.getElementById('listsep').getElementsByTagName('tbody')[0];
                if (table.rows[0].cells[0].getAttribute('colspan')) {
                    // Remove empty message row
                    table.innerHTML = '';
                }
                
                const newRow = table.insertRow();
                const rowCount = table.rows.length;
                
                newRow.innerHTML = `
                    <td>${rowCount}</td>
                    <td>SEP-${Date.now()}</td>
                    <td>${document.getElementById('poli_suratkontrol_bikin').options[document.getElementById('poli_suratkontrol_bikin').selectedIndex].text}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="lihatSPRI(this)">
                            <i class="fas fa-eye"></i> Lihat
                        </button>
                    </td>
                `;
                
                // Update SPRI number in main form
                const spriNumber = 'SPRI-' + Date.now().toString().substr(-8);
                document.getElementById('nosurat_skdp_sep').value = spriNumber;
                
                alert('SPRI berhasil dibuat dengan nomor: ' + spriNumber);
                closeModal('modalSpri');
            }, 2000);
        }

        // Function to view SPRI
        function lihatSPRI(btn) {
            const row = btn.closest('tr');
            const sepNumber = row.cells[1].textContent;
            alert('Menampilkan detail SPRI untuk SEP: ' + sepNumber);
        }

        // Function to change penanggung jawab
        function changePenanggungJawab(value) {
            document.getElementById('penanggungjawab').value = value;
            
            // Show/hide perusahaan fields based on selection
            const perusahaanFields = document.querySelectorAll('.form_perusahaan');
            if (value && value !== '1-Pribadi') {
                perusahaanFields.forEach(field => field.classList.remove('hidden'));
            } else {
                perusahaanFields.forEach(field => field.classList.add('hidden'));
            }
        }

        // Function to create SPRI
        function bikinspri() {
            // Add loading state
            const btn = event.target;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading"></span> Membuat SPRI...';
            btn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('SPRI berhasil dibuat!');
            }, 2000);
        }

        // Function to create SEP
        function buatsep() {
            // Add loading state
            const btn = document.getElementById('buatsepid');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="loading"></span> Membuat SEP...';
            btn.disabled = true;
            
            // Simulate API call
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                alert('SEP berhasil dibuat!');
            }, 2000);
        }

        // Form validation
        document.getElementById('formInsertPenanggungJawab').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ef4444';
                    field.focus();
                } else {
                    field.style.borderColor = '#e5e7eb';
                }
            });
            
            if (isValid) {
                alert('Form berhasil disimpan!');
                // Here you would normally submit the form
            } else {
                alert('Mohon lengkapi semua field yang wajib diisi!');
            }
        });

        // Button click animation
        document.querySelectorAll('.btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                let ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255,255,255,0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>
</html>