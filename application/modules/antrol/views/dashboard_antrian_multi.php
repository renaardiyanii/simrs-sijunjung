<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Poliklinik - RSUD Ahmad Syafii Maarif Sijunjung</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #1e40af;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border-radius: 16px;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --gradient-doctor: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.05"><circle cx="30" cy="30" r="4"/></g></svg>') repeat;
            pointer-events: none;
            z-index: 0;
        }

        .container-fluid {
            position: relative;
            z-index: 1;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .hospital-logo {
            transition: transform 0.3s ease;
        }

        .hospital-logo:hover {
            transform: scale(1.05);
        }

        .hospital-title {
            font-size: clamp(1.2rem, 3vw, 2.5rem);
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .date-time {
            font-size: clamp(0.8rem, 2vw, 1.2rem);
            color: var(--text-secondary);
            font-weight: 500;
            text-align: center;
        }

        .doctor-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .doctor-card.latest-call {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.95), rgba(5, 150, 105, 0.95));
            backdrop-filter: blur(30px);
            border: 2px solid rgba(16, 185, 129, 0.5);
            box-shadow: 0 25px 50px -12px rgba(16, 185, 129, 0.25);
            transform: scale(1.02);
        }

        .doctor-card.latest-call .doctor-name,
        .doctor-card.latest-call .current-patient-info,
        .doctor-card.latest-call .queue-title {
            color: white !important;
        }

        .doctor-card.latest-call .current-patient-number {
            background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .doctor-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.15);
        }

        .doctor-card.latest-call:hover {
            transform: scale(1.02) translateY(-3px);
        }

        .doctor-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-doctor);
        }

        .doctor-card.latest-call::before {
            background: rgba(255, 255, 255, 0.5);
        }

        .doctor-name {
            font-size: clamp(1rem, 2.5vw, 1.5rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .poli-name {
            font-size: clamp(0.8rem, 2vw, 1rem);
            color: var(--text-secondary);
            font-weight: 500;
            text-align: center;
            margin-bottom: 1rem;
        }

        .doctor-card.latest-call .poli-name {
            color: rgba(255, 255, 255, 0.9);
        }

        .current-patient {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .current-patient-number {
            font-size: clamp(2rem, 6vw, 4rem);
            font-weight: 900;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0.5rem 0;
            animation: pulse 2s infinite;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 1.2em;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .current-patient-number.no-patient {
            font-size: clamp(1rem, 3vw, 2rem);
            animation: none;
            color: var(--text-secondary);
            background: none;
            -webkit-text-fill-color: var(--text-secondary);
        }

        .current-patient-info {
            font-size: clamp(0.8rem, 2vw, 1.2rem);
            font-weight: 600;
            color: var(--text-primary);
            margin-top: 0.5rem;
            padding: 0.8rem;
            background: rgba(16, 185, 129, 0.1);
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
        }

        .doctor-card.latest-call .current-patient-info {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.4);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .queue-section {
            margin-top: 1rem;
        }

        .queue-title {
            font-size: clamp(0.9rem, 2.2vw, 1.4rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .queue-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .queue-item {
            background: rgba(99, 126, 234, 0.1);
            border: 2px solid rgba(99, 126, 234, 0.2);
            border-radius: 8px;
            padding: 0.8rem;
            margin-bottom: 0.5rem;
            text-align: left;
            font-size: clamp(0.8rem, 2vw, 1rem);
            font-weight: 600;
            color: var(--primary-color);
            transition: all 0.3s ease;
            animation: slideInUp 0.6s ease-out;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .doctor-card.latest-call .queue-item {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: white;
        }

        .queue-item:hover {
            background: rgba(99, 126, 234, 0.15);
            border-color: var(--primary-color);
            transform: scale(1.02);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .empty-queue {
            text-align: center;
            color: var(--text-secondary);
            font-style: italic;
            padding: 1.5rem;
            font-size: clamp(0.8rem, 2vw, 1.2rem);
        }

        .doctor-card.latest-call .empty-queue {
            color: rgba(255, 255, 255, 0.8);
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--success-color);
            animation: blink 1.5s infinite;
            display: inline-block;
            margin-right: 0.5rem;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }

        .loading-spinner {
            display: inline-block;
            width: 1.5rem;
            height: 1.5rem;
            border: 2px solid rgba(99, 126, 234, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .poli-selector {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }


        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .header, .poli-selector {
                padding: 1rem;
            }

            .doctor-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid px-4 py-3">
        <!-- Header -->
        <div class="header">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="<?= base_url('assets/antrian/img/logo_kemenkes.png') ?>"
                         class="hospital-logo img-fluid"
                         style="max-height: 60px; width: auto;"
                         alt="Logo Kemenkes">
                </div>
                <div class="col-md-8 text-center">
                    <h1 class="hospital-title mb-2" id="poli">
                        ANTRIAN POLIKLINIK
                    </h1>
                    <p class="date-time mb-0" id="dateTime">Loading...</p>
                </div>
                <div class="col-md-2 text-center">
                    <img src="<?= base_url('assets/images/logo.png') ?>"
                         class="hospital-logo img-fluid"
                         style="max-height: 60px; width: auto;"
                         alt="Logo Rumah Sakit">
                </div>
            </div>
        </div>

        
        <!-- Doctor Cards Container -->
        <div class="row g-3" id="countdokter">
            <!-- Dynamic doctor cards will be inserted here -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        let previousData = null;
        let currentPolies = '<?= $kodepolis ?>';

        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                timeZone: 'Asia/Jakarta'
            };
            const formattedDate = now.toLocaleDateString('id-ID', options);
            $("#dateTime").text(formattedDate);
        }

        function createDoctorCard(doctorData, index) {
            const hasPatient = doctorData.pasiendilayani && doctorData.pasiendilayani.nourut;
            const patientNumber = hasPatient ? doctorData.pasiendilayani.nourut : null;
            const patientName = hasPatient ? doctorData.pasiendilayani.nama : '';
            const patientNorm = hasPatient ? doctorData.pasiendilayani.norm : '';
            const isLatestCall = doctorData.is_latest_call || false;

            // Build queue list
            let queueListHtml = '';
            if (doctorData.pasien && doctorData.pasien.length > 0) {
                doctorData.pasien.slice(0, 5).forEach((patient, idx) => {
                    queueListHtml += `
                        <li class="queue-item" style="animation-delay: ${idx * 0.1}s">
                            <i class="fas fa-user me-2"></i>
                            <div>
                                <strong>${patient.nama}</strong>
                                <small class="d-block">RM: ${patient.norm}</small>
                            </div>
                        </li>
                    `;
                });
                if (doctorData.pasien.length > 5) {
                    queueListHtml += `
                        <li class="queue-item" style="opacity: 0.7;">
                            <i class="fas fa-ellipsis-h me-2"></i>
                            <div><small>Dan ${doctorData.pasien.length - 5} lainnya...</small></div>
                        </li>
                    `;
                }
            } else {
                queueListHtml = `
                    <li class="empty-queue">
                        <i class="fas fa-hourglass-half me-2"></i>
                        Tidak ada antrian
                    </li>
                `;
            }

            // Build patient info section
            let patientInfoHtml = '';
            if (hasPatient) {
                patientInfoHtml = `
                    <div class="current-patient-info">
                        <i class="fas fa-user-check me-2"></i>
                        <strong>${patientName}</strong>
                        <small class="d-block">RM: ${patientNorm}</small>
                        ${doctorData.pasiendilayani.waktu_panggil ?
                            `<small class="d-block">Dipanggil: ${new Date(doctorData.pasiendilayani.waktu_panggil).toLocaleTimeString('id-ID')}</small>`
                            : ''}
                    </div>
                `;
            }

            // Determine column size based on latest call
            const colClass = isLatestCall ? 'col-lg-6 col-xl-4' : 'col-lg-4 col-xl-3';
            const cardClass = isLatestCall ? 'doctor-card latest-call' : 'doctor-card';

            return `
                <div class="${colClass}">
                    <div class="${cardClass}" style="animation-delay: ${index * 0.1}s">
                        <div class="doctor-name">
                            <span class="status-indicator"></span>
                            <i class="fas fa-user-md me-2"></i>
                            ${doctorData.dokter}
                            ${isLatestCall ? '<i class="fas fa-star ms-1" title="Pemanggilan Terakhir"></i>' : ''}
                        </div>
                        <div class="poli-name">
                            ${doctorData.poli}
                            ${isLatestCall ? '<span class="badge bg-light text-success ms-1">Terbaru</span>' : ''}
                        </div>

                        <div class="current-patient">
                            <div class="current-patient-number ${!hasPatient ? 'no-patient' : ''}"
                                 data-doctor="${doctorData.dokter}">
                                ${hasPatient ? patientNumber : 'Belum Ada'}
                            </div>
                            ${patientInfoHtml}
                        </div>

                        <div class="queue-section">
                            <h4 class="queue-title">
                                <i class="fas fa-list-ol me-2"></i>
                                Antrian (${doctorData.pasien ? doctorData.pasien.length : 0})
                            </h4>
                            <ul class="queue-list">
                                ${queueListHtml}
                            </ul>
                        </div>
                    </div>
                </div>
            `;
        }


        function getdata() {
            if (!currentPolies) {
                console.warn('No poli codes specified');
                return;
            }

            $.get('<?= base_url('antrol/antrol/get_data_dashboard_antrian_multi/') ?>' + encodeURIComponent(currentPolies), function (data, status) {
                if (!data || data.length === 0) {
                    $("#countdokter").html(`
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Tidak ada data antrian untuk poli yang dipilih
                            </div>
                        </div>
                    `);
                    return;
                }

                // Build doctor cards
                let doctorCardsHtml = '';
                data.forEach((doctorData, index) => {
                    doctorCardsHtml += createDoctorCard(doctorData, index);
                });

                // Update content
                $("#countdokter").html(doctorCardsHtml);

                // Store current data for comparison
                previousData = [...data];

            }).fail(function(xhr, status, error) {
                console.error('Error fetching multi poli data:', error);
                $("#countdokter").html(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            Error loading data: ${error}
                        </div>
                    </div>
                `);
            });
        }

        function initializeDisplay() {
            updateDateTime();

            // Set poli info display
            if (currentPolies) {
                const poliArray = currentPolies.split(',');
                $("#poliList").text(poliArray.join(', '));
                $("#poli").text('ANTRIAN POLIKLINIK');
                getdata();
            } else {
                $("#poliList").text('Tidak ada poli yang dipilih');
                $("#poli").text('ANTRIAN POLIKLINIK');
                $("#countdokter").html(`
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Tidak ada poli yang dipilih untuk ditampilkan
                        </div>
                    </div>
                `);
            }
        }

        $(document).ready(function() {
            initializeDisplay();

            // Update time every second
            setInterval(updateDateTime, 1000);

            // Update queue data every 15 seconds if polies are loaded
            setInterval(() => {
                if (currentPolies) {
                    getdata();
                }
            }, 15000);


            // Reload page every 30 minutes to prevent memory leaks
            setTimeout(() => {
                location.reload();
            }, 30 * 60 * 1000);
        });

        // Handle visibility change to refresh when tab becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden && currentPolies) {
                getdata();
            }
        });

        // Add error handling for failed requests
        $(document).ajaxError(function(event, xhr, settings, error) {
            console.error('AJAX Error:', error);
            if (settings.url.includes('get_data_dashboard_antrian_multi')) {
                $("#countdokter").html(`
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            <i class="fas fa-wifi me-2"></i>
                            Koneksi Terputus - Mencoba menghubungkan kembali...
                        </div>
                    </div>
                `);
            }
        });
    </script>
</body>

</html>