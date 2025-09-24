<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> - RSUD Ahmad Syafii Maarif Sijunjung</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --info-color: #0dcaf0;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --shadow-lg: 0 10px 30px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
        }

        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: var(--gradient-primary);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.03"><circle cx="30" cy="30" r="4"/></g></svg>') repeat;
            pointer-events: none;
        }

        .main-container {
            position: relative;
            z-index: 1;
            padding: 2rem 0;
        }

        .header-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
            padding: 2rem;
        }

        .hospital-title {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .hospital-subtitle {
            color: var(--secondary-color);
            font-size: 1.2rem;
            font-weight: 500;
        }

        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem;
        }

        .section-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .control-panel {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .btn-modern {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #0d6efd 0%, #0b5ed7 100%);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            color: white;
        }

        .btn-warning-modern {
            background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
            color: #000;
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, #dc3545 0%, #bb2d3b 100%);
            color: white;
        }

        .table-modern {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .table-modern thead th {
            background: linear-gradient(135deg, #495057 0%, #343a40 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table-modern tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
        }

        .table-modern tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
            transform: scale(1.01);
        }

        .checkbox-modern {
            width: 1.25rem;
            height: 1.25rem;
            cursor: pointer;
        }

        .badge-modern {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .stats-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .stats-number {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-color);
        }

        .stats-label {
            font-size: 0.875rem;
            color: var(--secondary-color);
            font-weight: 500;
        }

        .loading-spinner {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border: 3px solid rgba(13, 110, 253, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .selected-count {
            background: linear-gradient(135deg, #198754 0%, #157347 100%);
            color: white;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .hospital-title {
                font-size: 2rem;
            }

            .main-container {
                padding: 1rem 0;
            }

            .header-card, .dashboard-card {
                padding: 1.5rem;
            }
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.5rem 1rem;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="container-fluid px-4">
            <!-- Header -->
            <div class="header-card text-center">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="<?= base_url('assets/antrian/img/logo_kemenkes.png') ?>"
                             class="img-fluid" style="max-height: 80px;" alt="Logo Kemenkes">
                    </div>
                    <div class="col-md-8">
                        <h1 class="hospital-title">Dashboard Antrian Poliklinik</h1>
                        <p class="hospital-subtitle">RSUD Ahmad Syafii Maarif Sijunjung</p>
                    </div>
                    <div class="col-md-2">
                        <img src="<?= base_url('assets/images/logo.png') ?>"
                             class="img-fluid" style="max-height: 80px;" alt="Logo RS">
                    </div>
                </div>
            </div>

            <!-- Main Dashboard -->
            <div class="dashboard-card">
                <h2 class="section-title">
                    <i class="fas fa-hospital-user"></i>
                    Pilih Poliklinik untuk Dashboard
                </h2>

                <!-- Control Panel -->
                <div class="control-panel">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="form-check">
                                    <input class="form-check-input checkbox-modern" type="checkbox" id="selectAll">
                                    <label class="form-check-label fw-bold" for="selectAll">
                                        Pilih Semua
                                    </label>
                                </div>
                                <span class="selected-count" id="selectedCount">0 dipilih</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <button class="btn btn-modern btn-success-modern me-2" onclick="openSingleDashboard()">
                                <i class="fas fa-external-link-alt me-2"></i>
                                Dashboard Tunggal
                            </button>
                            <button class="btn btn-modern btn-primary-modern" onclick="openMultiDashboard()">
                                <i class="fas fa-tv me-2"></i>
                                Dashboard Multi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4" id="statsContainer">
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number" id="totalPoli">-</div>
                            <div class="stats-label">Total Poliklinik</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number" id="totalDokter">-</div>
                            <div class="stats-label">Total Dokter Aktif</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number" id="totalPasien">-</div>
                            <div class="stats-label">Total Pasien Hari Ini</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stats-card">
                            <div class="stats-number" id="selectedPoli">0</div>
                            <div class="stats-label">Poli Terpilih</div>
                        </div>
                    </div>
                </div>

                <!-- Data Table -->
                <div class="table-responsive">
                    <table id="poliklinikTable" class="table table-hover table-modern w-100">
                        <thead>
                            <tr>
                                <th width="50">
                                    <input type="checkbox" class="checkbox-modern" id="headerCheckbox">
                                </th>
                                <th>Kode Poli</th>
                                <th>Nama Poliklinik</th>
                                <th width="120">Dokter Aktif</th>
                                <th width="140">Pasien Hari Ini</th>
                                <th width="100">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data will be loaded via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <script>
        let dataTable;
        let selectedPolis = [];

        $(document).ready(function() {
            initializeDataTable();
            loadPoliklinikData();
        });

        function initializeDataTable() {
            dataTable = $('#poliklinikTable').DataTable({
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                pageLength: 25,
                order: [[2, 'asc']], // Sort by nama poliklinik
                columnDefs: [
                    { orderable: false, targets: [0, 5] }
                ]
            });
        }

        function loadPoliklinikData() {
            // Show loading state
            $('#totalPoli, #totalDokter, #totalPasien').html('<div class="loading-spinner"></div>');

            $.ajax({
                url: '<?= base_url("antrol/antrol/get_poliklinik_list") ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        populateTable(response.data);
                        updateStatistics(response.data);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Gagal memuat data poliklinik'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan: ' + error
                    });
                }
            });
        }

        function populateTable(data) {
            dataTable.clear();

            data.forEach(function(item) {
                const checkbox = `<input type="checkbox" class="checkbox-modern poli-checkbox" value="${item.id_poli}" data-nama="${item.nm_poli}">`;
                const statusBadge = getStatusBadge(item.total_pasien_hari_ini, item.total_dokter);

                dataTable.row.add([
                    checkbox,
                    `<span class="fw-bold text-primary">${item.id_poli}</span>`,
                    `<div class="fw-semibold">${item.nm_poli}</div>`,
                    `<div class="text-center">
                        <span class="badge bg-info">${item.total_dokter}</span>
                    </div>`,
                    `<div class="text-center">
                        <span class="badge bg-primary">${item.total_pasien_hari_ini}</span>
                    </div>`,
                    statusBadge
                ]).draw();
            });

            // Bind checkbox events
            bindCheckboxEvents();
        }

        function getStatusBadge(totalPasien, totalDokter) {
            if (parseInt(totalDokter) === 0) {
                return '<span class="badge badge-modern bg-secondary">Tidak Aktif</span>';
            } else if (parseInt(totalPasien) === 0) {
                return '<span class="badge badge-modern bg-warning text-dark">Siap</span>';
            } else {
                return '<span class="badge badge-modern bg-success">Aktif</span>';
            }
        }

        function updateStatistics(data) {
            const totalPoli = data.length;
            const totalDokter = data.reduce((sum, item) => sum + parseInt(item.total_dokter), 0);
            const totalPasien = data.reduce((sum, item) => sum + parseInt(item.total_pasien_hari_ini), 0);

            $('#totalPoli').text(totalPoli);
            $('#totalDokter').text(totalDokter);
            $('#totalPasien').text(totalPasien);
        }

        function bindCheckboxEvents() {
            // Individual checkbox change
            $('.poli-checkbox').off('change').on('change', function() {
                updateSelectedPolis();
            });

            // Select all checkbox
            $('#selectAll, #headerCheckbox').off('change').on('change', function() {
                const isChecked = $(this).prop('checked');
                $('.poli-checkbox').prop('checked', isChecked);
                $('#selectAll, #headerCheckbox').prop('checked', isChecked);
                updateSelectedPolis();
            });
        }

        function updateSelectedPolis() {
            selectedPolis = [];
            $('.poli-checkbox:checked').each(function() {
                selectedPolis.push({
                    id: $(this).val(),
                    nama: $(this).data('nama')
                });
            });

            const count = selectedPolis.length;
            $('#selectedCount').text(`${count} dipilih`);
            $('#selectedPoli').text(count);

            // Update select all checkbox
            const totalCheckboxes = $('.poli-checkbox').length;
            const checkedCheckboxes = $('.poli-checkbox:checked').length;

            $('#selectAll, #headerCheckbox').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
            $('#selectAll, #headerCheckbox').prop('checked', checkedCheckboxes === totalCheckboxes);
        }

        function openSingleDashboard() {
            if (selectedPolis.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Pilih minimal 1 poliklinik terlebih dahulu'
                });
                return;
            }

            if (selectedPolis.length > 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Untuk dashboard tunggal, pilih hanya 1 poliklinik'
                });
                return;
            }

            const poli = selectedPolis[0];
            const url = `<?= base_url('antrol/antrol/dashboard_antrian_poli/') ?>${poli.id}`;
            window.open(url, '_blank');
        }

        function openMultiDashboard() {
            if (selectedPolis.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Pilih minimal 1 poliklinik terlebih dahulu'
                });
                return;
            }

            if (selectedPolis.length > 5) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Maksimal 5 poliklinik yang dapat dipilih untuk dashboard multi'
                });
                return;
            }

            // Buat URL dengan parameter
            const poliIds = selectedPolis.map(p => p.id);
            let url = `<?= base_url('antrol/antrol/dashboard_antrian_multi/') ?>${poliIds.join('/')}`;

            // Konfirmasi sebelum membuka
            const poliNames = selectedPolis.map(p => p.nama).join(', ');
            Swal.fire({
                icon: 'question',
                title: 'Konfirmasi',
                html: `Buka dashboard multi untuk:<br><strong>${poliNames}</strong>`,
                showCancelButton: true,
                confirmButtonText: 'Ya, Buka',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open(url, '_blank');
                }
            });
        }
    </script>
</body>
</html>