<?php
$this->load->view('irj/layout/header_form', ['hide' => true, 'redirect' => base_url()]);


$klsiri = '3';
if (isset($pasien_iri[0]->klsiri)) {
    switch ($pasien_iri[0]->klsiri) {
        case 'III':
            $klsiri = '3';
            break;
        case 'II':
            $klsiri = '2';
            break;

        case 'I':
            $klsiri = '1';
            break;
        default:
            $klsiri = '3';
    }
}

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form SEP - BPJS Kesehatan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }

            100% {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
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
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
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
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Hover Effects */
        .form-control:hover {
            border-color: #cbd5e1;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        /* Focus States */
        .btn:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(44, 90, 160, 0.3);
        }

        /* Tambahkan CSS untuk modal (masukkan ke dalam tag <style>): */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: block;
        }

        .modal-dialog {
            position: relative;
            margin: 30px auto;
            max-width: 800px;
            animation: slideDown 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #2c5aa0 0%, #1e3c72 100%);
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-header h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .modal-header .close {
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
            opacity: 0.8;
            transition: opacity 0.3s;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            background: #f8fafc;
            padding: 20px 30px;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .table-spri {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-spri th {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            padding: 12px 15px;
            font-weight: 600;
            color: #1e293b;
            border-bottom: 1px solid #cbd5e1;
        }

        .table-spri td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }

        .table-spri tr:last-child td {
            border-bottom: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <form id="formInsertPenanggungJawab">
            <input type="hidden" name="no_ipd" value="<?= $no_register ?>">
            <input type="hidden" name="no_medrec" value="<?= $datapasien->no_medrec ?>">

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
                                <input type="text" class="form-control" name="no_bpjs" id="no_bpjs"
                                    placeholder="Masukkan nomor kartu BPJS" value="<?= $datapasien->no_kartu ?>">
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
                            <input type="tel" class="form-control" id="no_telp_bpjs" placeholder="Contoh: 081234567890"
                                value="<?= $datapasien->no_hp ?>">
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
                                <input type="text" class="form-control" name="nosurat_skdp_sep" id="nosurat_skdp_sep"
                                    placeholder="Nomor SPRI"
                                    value="<?php
                                    if($spri != null){
                                        echo $spri->surat_kontrol;
                                    }
                                    ?>"
                                    >
                                <button type="button" class="btn btn-success" onclick="bikinspri()">
                                    <i class="fas fa-plus"></i> Buat SPRI
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">DPJP Pemberi SPRI</label>
                            <select id="dpjp_skdp_sep" class="form-control" name="dpjp_skdp_sep">
                            <?php
                                    if($spri != null){
                                        echo '
                                        <option value="'.$spri->kode_dpjp_bpjs.'">'.$spri->nama_dokter_bpjs.'</option>
                                        ';
                                    }else{
                                        echo '
                                        <option value="">-- Pilih Dokter --</option>
                                        ';
                                    }
                                    ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Catatan SEP</label>
                            <textarea class="form-control" name="catatan" id="catatan"
                                placeholder="Masukkan catatan jika diperlukan"></textarea>
                        </div>
                    </div>


                </div>

                <!-- Right Column -->
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-bed"></i> Kelas Rawat & Pembiayaan
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kelas Rawat Hak</label>
                        <input type="text" class="form-control" id="klsRawatHak" placeholder="Kelas rawat sesuai hak" value="<?= $klsiri ?>">
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
                        <input type="text" class="form-control" placeholder="Nama peserta BPJS"
                            value="<?= $datapasien->nama ?>">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="action-buttons">
        <button id="buatsepid" type="button" class="btn btn-info" onclick="buatsep()">
            <i class="fas fa-file-medical"></i> Buat SEP
        </button>
    </div>



    <!-- modal -->
    <div class="modal modal_suratkontrol" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div class="logo" style="width: 40px; height: 40px; margin: 0;">
                            <i class="fas fa-file-medical"></i>
                        </div>
                        <h4>Pembuatan SPRI</h4>
                    </div>
                    <button type="button" class="close" onclick="closeModal()">×</button>
                </div>
                <div class="modal-body">
                    <div class="formbuatsurkon">
                        <div class="form-group">
                            <label class="form-label">No. Kartu</label>
                            <input type="text" class="form-control" id="no_sep_surat_bikin"
                                value="<?= $datapasien->no_kartu ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tgl Rencana Ranap</label>
                            <input type="date" class="form-control" id="tgl_surat_bikin"
                                onchange="ambilpolikontrol(this.value)">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Dokter Spesialis</label>
                            <select id="poli_suratkontrol_bikin" class="form-control"
                                onchange="ambildoktersuratkontrol(this.value)">
                                <option value="">-- Pilih Poliklinik --</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Dokter SPRI</label>
                            <select id="dpjp_suratkontrol_bikin" class="form-control" name="dpjp_suratkontrol_bikin">
                                <option value="">-- Pilih Dokter --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" onclick="closeModal()">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button type="button" class="btn btn-primary" onclick="buatsuratkontrol()">
                        <i class="fas fa-plus"></i> Buat SPRI
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        // Set today's date for date inputs
        document.addEventListener('DOMContentLoaded', function () {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tgl_sep').value = today;
            document.getElementById('tgl_rujukan').value = today;
        });

        // Initialize Select2 for better dropdowns
        $(document).ready(function () {
            $('.js-example-basic-single').select2({
                theme: 'default',
                width: '100%'
            });
        });

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

        // Tambahkan function untuk close modal:
        function closeModal() {
            $('.modal_suratkontrol').removeClass('show').hide();
        }

        // Update function bikinspri():
        function bikinspri() {
            // Jika modal belum ada, buat modal baru
            if (!document.querySelector('.modal_suratkontrol')) {
                document.body.insertAdjacentHTML('beforeend', modalHTML);
            }

            $('.modal_suratkontrol').addClass('show').show();
        }

        // Tambahkan event listener untuk close modal ketika klik di luar modal:
        $(document).on('click', '.modal', function (e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal dengan ESC key:
        $(document).keyup(function (e) {
            if (e.key === "Escape") {
                closeModal();
            }
        });


        function ambilpolikontrol(tgl) {
            $.ajax({
                url: '<?= base_url('bpjs/rencanakontrol/data_poli') ?>' + `?jnskontrol=1&nomor=${$('#no_sep_surat_bikin').val().trim()}&tglrencanakontrol=${tgl}`,
                beforeSend: function () {
                    $('#poli_suratkontrol_bikin').attr('disabled', true);
                },
                success: function (data) {
                    let html = '';
                    if (data.metaData.code === '200') {
                        data.response.list.map((e) => {
                            html += `<option value="${e.kodePoli}">${e.namaPoli}</option>`;
                        })
                        $('#poli_suratkontrol_bikin').empty();
                        $('#poli_suratkontrol_bikin').append('<option value="">Silahkan Pilih Poliklinik..</option>');
                        $('#poli_suratkontrol_bikin').append(html);
                    }
                },
                error: function (xhr) { },
                complete: function () {
                    $('#poli_suratkontrol_bikin').attr('disabled', false);

                }
            });
        }



        function ambildoktersuratkontrol(kodepoli) {
            $.ajax({
                url: '<?= base_url('bpjs/rencanakontrol/data_dokter') ?>' + `?jnskontrol=1&poli=${kodepoli}&tglrencanakontrol=${$('#tgl_surat_bikin').val()}`,
                beforeSend: function () {
                    $('#dpjp_suratkontrol_bikin').attr('disabled', true);

                },
                success: function (data) {
                    let html = '';
                    if (data.metaData.code === '200') {
                        data.response.list.map((e) => {
                            html += `<option value="${e.kodeDokter}-${e.namaDokter}">${e.namaDokter}</option>`;
                        })
                        $('#dpjp_suratkontrol_bikin').empty();
                        $('#dpjp_suratkontrol_bikin').append('<option value="">Silahkan Pilih Dokter</option>');
                        $('#dpjp_suratkontrol_bikin').append(html);
                    }
                },
                error: function (xhr) { },
                complete: function () {
                    $('#dpjp_suratkontrol_bikin').attr('disabled', false);

                }
            });
        }




        function buatsuratkontrol() {
            $.ajax({
                method: 'POST',
                type: 'JSON',
                data: {
                    'noKartu': $('#no_sep_surat_bikin').val(),
                    'noSepAsal': $('#no_sep_surat_bikin').val(),
                    'kodeDokter': $('#dpjp_suratkontrol_bikin').val().split('-')[0],
                    'poliKontrol': $('#poli_suratkontrol_bikin').val(),
                    'tglRencanaKontrol': $('#tgl_surat_bikin').val(),
                    'user': 'ADMIN',
                    'nama_dokter': $('#dpjp_suratkontrol_bikin').val().split('-')[1]
                },
                url: '<?= base_url('bpjs/rencanakontrol/insert_spri') ?>',
                beforeSend: function () {

                },
                success: function (data) {
                    let html = '';
                    if (data.metaData.code === '200') {
                        $('#nosurat_skdp_sep').val(data.response.noSPRI);
                        $('#dpjp_skdp_sep').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
                        $('.modal_suratkontrol').modal('hide');
                    } else {
                        swal("Peringatan!", data.metaData.message, "warning");

                    }
                },
                error: function (xhr) {
                    swal("Peringatan!", 'Hubungi Admin IT', "warning");

                },
                complete: function () {

                }
            });
        }

        // Function to create SEP
        function buatsep() {
            const btn = document.getElementById('buatsepid');
            const originalText = btn.innerHTML;

            $.ajax({
                url: `<?= base_url('bpjs/sep/insert_sep') ?>/<?= $no_register ?? '' ?>`,
                type: 'POST',
                dataType: 'JSON',
                data: {
                    'no_kartu': $('#no_bpjs').val(),
                    'tgl_sep': $('#tgl_sep').val(),
                    'kelasrawat': $('#klsRawatHak').val(),
                    'klsrawatnaik': $('#klsrawatnaik').val(),
                    'pembiayaan': $('#pembiayaan').val().split('-')[0],
                    'penanggungjawab': $('#penanggungjawab').val().split('-')[1],
                    'no_medrec': '<?= $datapasien->no_medrec ?>',
                    'asalrujukan': '',
                    'tglrujukan': $('#tgl_rujukan').val(),
                    'norujukan': $('#no_rujukan').val() == "" ? $('#no_bpjs').val() : $('#no_rujukan').val(),
                    'ppkrujukan': '0311R001',
                    'catatan': $('#catatan').val(),
                    'diagawal': '<?= $datapasien->diagmasuk ?? "" ?>',
                    'politujuan': '',
                    'tujuankunj': '0',
                    'flagprocedure': '',
                    'kdpenunjang': '',
                    'assesmentpel': '',
                    'nosurat': $('#nosurat_skdp_sep').val(),
                    'dpjpsurat': $('#dpjp_skdp_sep').val(),
                    'dpjplayan': '',
                    'notelp': $('#no_telp_bpjs').val(),
                    'user': '<?= 'ADMIN' ?>',
                },
                beforeSend: function () {
                    btn.disabled = true;
                    btn.innerHTML = '<span class="loading"></span> Membuat SEP...';
                },
                success: function (data) {
                    if (data.metaData.code === '200') {
                        $('#no_sep').val(data.response.sep.noSep);
                        window.open('<?= base_url('bpjs/sep/cetakan_sep/') ?><?= $no_register ?? '' ?>', '_blank');
                        return;
                    }
                    new swal("Peringatan!", data.metaData.message, "warning");
                },
                error: function () {
                    new swal("Peringatan!", 'Hubungi Admin IT', "warning");
                },
                complete: function () {
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            });
        }


        // Form validation
        document.getElementById('formInsertPenanggungJawab').addEventListener('submit', function (e) {
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
            btn.addEventListener('click', function (e) {
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