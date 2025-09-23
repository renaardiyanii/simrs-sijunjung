<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Admisi - RSUD Ahmad Syafii Maarif Sijunjung</title>
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
            font-size: clamp(1.5rem, 4vw, 3rem);
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
            font-size: clamp(0.9rem, 2.5vw, 1.4rem);
            color: var(--text-secondary);
            font-weight: 500;
            text-align: center;
        }

        .main-queue-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 3rem 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .main-queue-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-success);
        }

        .queue-status {
            font-size: clamp(1.2rem, 3vw, 2.2rem);
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .current-queue {
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 900;
            text-align: center;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 1rem 0;
            animation: pulse 2s infinite;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            min-height: 1.2em;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .current-queue.no-queue {
            font-size: clamp(1.5rem, 4vw, 3rem);
            animation: none;
            color: var(--text-secondary);
            background: none;
            -webkit-text-fill-color: var(--text-secondary);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .queue-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .queue-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px -5px rgba(0, 0, 0, 0.15);
        }

        .queue-card-title {
            font-size: clamp(1.1rem, 2.8vw, 1.8rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
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
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.8rem;
            text-align: center;
            font-size: clamp(1.2rem, 3vw, 1.8rem);
            font-weight: 700;
            color: var(--primary-color);
            transition: all 0.3s ease;
            animation: slideInUp 0.6s ease-out;
        }

        .queue-item:hover {
            background: rgba(99, 126, 234, 0.15);
            border-color: var(--primary-color);
            transform: scale(1.02);
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .video-section {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .video-section iframe {
            border-radius: var(--border-radius);
            filter: brightness(1.1) contrast(1.05);
        }

        .loading-spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 3px solid rgba(99, 126, 234, 0.3);
            border-radius: 50%;
            border-top-color: var(--primary-color);
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .empty-queue {
            text-align: center;
            color: var(--text-secondary);
            font-style: italic;
            padding: 2rem;
            font-size: clamp(1rem, 2.5vw, 1.4rem);
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding: 1rem;
            }

            .header {
                padding: 1rem;
            }

            .main-queue-card {
                padding: 2rem 1rem;
            }

            .queue-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 576px) {
            .current-queue {
                font-size: clamp(2rem, 10vw, 4rem);
            }

            .current-queue.no-queue {
                font-size: clamp(1rem, 3vw, 2rem);
            }

            .queue-item {
                padding: 0.8rem;
                font-size: clamp(1rem, 4vw, 1.5rem);
            }
        }

        @media (min-width: 1920px) {
            .current-queue {
                font-size: 8rem;
            }

            .current-queue.no-queue {
                font-size: 4rem;
            }

            .queue-item {
                font-size: 2rem;
                padding: 1.5rem;
            }
        }

        .loket-info {
            text-align: center;
            margin-top: 1rem;
            padding: 1rem;
            background: rgba(16, 185, 129, 0.1);
            border: 2px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            animation: slideInUp 0.6s ease-out;
        }

        .loket-text {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            font-weight: 700;
            color: var(--success-color);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .status-indicator {
            width: 12px;
            height: 12px;
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
                         style="max-height: 80px; width: auto;"
                         alt="Logo Kemenkes">
                </div>
                <div class="col-md-8 text-center">
                    <h1 class="hospital-title mb-2">Antrian Admisi</h1>
                    <p class="date-time mb-0" id="dateTime">Loading...</p>
                </div>
                <div class="col-md-2 text-center">
                    <img src="<?= base_url('assets/images/logo.png') ?>"
                         class="hospital-logo img-fluid"
                         style="max-height: 80px; width: auto;"
                         alt="Logo Rumah Sakit">
                </div>
            </div>
        </div>

        <!-- Main Content Row -->
        <div class="row g-4">
            <!-- Current Queue Section -->
            <div class="col-lg-8">
                <div class="main-queue-card">
                    <div class="queue-status">
                        <span class="status-indicator"></span>
                        <i class="fas fa-user-md me-2"></i>
                        Antrian Sedang Dilayani
                    </div>
                    <div class="current-queue" id="currentQueue">
                        <div class="loading-spinner"></div>
                    </div>
                    <div class="loket-info" id="loketInfo" style="display: none;">
                        <div class="loket-text">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span id="loketDisplay">Loket 1</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Section -->
            <div class="col-lg-4">
                <div class="video-section">
                    <iframe width="100%"
                            height="400"
                            src="https://www.youtube.com/embed/nL3xlTZO4T0?autoplay=1&mute=1&loop=1&playlist=nL3xlTZO4T0"
                            title="Informasi Kesehatan"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>
            </div>
        </div>

        <!-- Queue Lists Row -->
        <div class="row g-4 mt-2">
            <div class="col-lg-6">
                <div class="queue-card">
                    <h3 class="queue-card-title">
                        <i class="fas fa-clock me-2"></i>
                        Antrian Berikutnya
                    </h3>
                    <ul class="queue-list" id="queueList1">
                        <li class="empty-queue">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Tidak ada antrian
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="queue-card">
                    <h3 class="queue-card-title">
                        <i class="fas fa-list-ol me-2"></i>
                        Antrian Menunggu
                    </h3>
                    <ul class="queue-list" id="queueList2">
                        <li class="empty-queue">
                            <i class="fas fa-hourglass-half me-2"></i>
                            Tidak ada antrian
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        let previousCurrentQueue = null;
        let previousQueueList = [];

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

        function animateCurrentQueue(newQueue, hasQueue = true, loketNumber = null) {
            const $currentQueue = $("#currentQueue");
            const $loketInfo = $("#loketInfo");
            const $loketDisplay = $("#loketDisplay");

            if (newQueue !== previousCurrentQueue && previousCurrentQueue !== null) {
                $currentQueue.addClass('animate__animated animate__flash');
                setTimeout(() => {
                    $currentQueue.removeClass('animate__animated animate__flash');
                }, 1000);

                // Note: TTS announcement is now handled by the admin interface button
                // Dashboard only shows visual updates without sound
            }

            // Apply different styling for no queue state
            if (hasQueue) {
                $currentQueue.removeClass('no-queue');
                if (loketNumber) {
                    $loketDisplay.text(`Loket ${loketNumber}`);
                    $loketInfo.show();
                } else {
                    $loketInfo.hide();
                }
            } else {
                $currentQueue.addClass('no-queue');
                $loketInfo.hide();
            }

            $currentQueue.html(newQueue);
            previousCurrentQueue = newQueue;
        }

        // Note: TTS functionality has been moved to admin interface for better control
        // Dashboard now only handles visual updates and displays

        function createQueueItem(queueNumber, index) {
            return `
                <li class="queue-item" style="animation-delay: ${index * 0.1}s">
                    <i class="fas fa-ticket-alt me-2"></i>
                    ${queueNumber}
                </li>
            `;
        }

        function updateQueueList(listId, queueItems) {
            const $list = $(`#${listId}`);

            if (queueItems.length === 0) {
                $list.html(`
                    <li class="empty-queue">
                        <i class="fas fa-hourglass-half me-2"></i>
                        Tidak ada antrian
                    </li>
                `);
                return;
            }

            let listHtml = '';
            queueItems.forEach((item, index) => {
                listHtml += createQueueItem(item, index);
            });

            $list.html(listHtml);
        }

        function playNotificationSound() {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgZaLvt559NEAxQp+PwtmMcBjiR1/LMeSwFJHfH8N2QQAoUXrTp66hVFApGn+PqvWEaBC2Dy/PEcCMEdLzl2IhNGwdQq+PtrmAaBlSo4+1vGAExhM/1z3gnBjOByfPMeSYELIHO8slwIgM1h9X2znMpBjaEzfDRex0ALIHb9L9zKwU5hdDs0m4bCDWL1fDKeAsI');
            audio.play().catch(() => {});
        }

        function getdata() {
            $.get('<?= base_url('antrol/get_data_dashboard_antrian_admisi/') ?>', function (data, status) {
                if (!data || !data[0]) {
                    console.warn('No data received');
                    return;
                }

                const queueData = data[0];
                let currentQueueFound = false;
                let currentQueueNumber = null;
                let currentQueueLoket = null;

                // Cek apakah ada antrian yang sedang dipanggil (status = dipanggil)
                if (queueData.pasien && queueData.pasien.length > 0) {
                    // Cari antrian dengan status 'dipanggil' untuk ditampilkan sebagai sedang dilayani
                    const panggilanAntrian = queueData.pasien.find(item => item.status === 'dipanggil');

                    if (panggilanAntrian) {
                        currentQueueNumber = `A-${String(panggilanAntrian.nomorantrian).padStart(3, '0')}`;
                        currentQueueLoket = panggilanAntrian.loket || null;
                        currentQueueFound = true;
                    }
                }

                // Jika tidak ada antrian yang dipanggil, cek pasiendilayani dari backend
                if (!currentQueueFound && queueData.pasiendilayani && queueData.pasiendilayani.nourut) {
                    currentQueueNumber = `A-${String(queueData.pasiendilayani.nourut).padStart(3, '0')}`;
                    currentQueueLoket = queueData.pasiendilayani.loket || null;
                    currentQueueFound = true;
                }

                // Update current queue with animation
                if (currentQueueFound) {
                    animateCurrentQueue(currentQueueNumber, true, currentQueueLoket);

                    if (currentQueueNumber !== previousCurrentQueue && previousCurrentQueue !== null) {
                        playNotificationSound();
                    }
                } else {
                    animateCurrentQueue('Belum Ada Antrian', false, null);
                }

                // Process queue lists - filter out antrian yang sedang dipanggil
                const queueList1 = [];
                const queueList2 = [];

                if (queueData.pasien && queueData.pasien.length > 0) {
                    // Filter antrian yang belum dipanggil untuk ditampilkan di daftar antrian berikutnya
                    const waitingQueue = queueData.pasien.filter(item =>
                        item.status !== 'dipanggil' && item.status !== 'selesai'
                    );

                    waitingQueue.forEach((item, index) => {
                        const formattedAntrian = `A-${String(item.nomorantrian).padStart(3, '0')}`;

                        if (index < 3) {
                            queueList1.push(formattedAntrian);
                        } else if (index >= 3 && index < 6) {
                            queueList2.push(formattedAntrian);
                        }
                    });
                }

                updateQueueList('queueList1', queueList1);
                updateQueueList('queueList2', queueList2);

                previousQueueList = [...queueList1, ...queueList2];
            }).fail(function(xhr, status, error) {
                console.error('Error fetching queue data:', error);
                $("#currentQueue").html('Error Loading Data');
            });
        }

        function initializeDisplay() {
            updateDateTime();
            getdata();
        }

        $(document).ready(function() {
            initializeDisplay();

            // Update time every second
            setInterval(updateDateTime, 1000);

            // Update queue data every 5 seconds
            setInterval(getdata, 5000);

            // Reload page every 30 minutes to prevent memory leaks
            setTimeout(() => {
                location.reload();
            }, 30 * 60 * 1000);
        });

        // Handle visibility change to refresh when tab becomes visible
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                getdata();
            }
        });

        // Add error handling for failed requests
        $(document).ajaxError(function(event, xhr, settings, error) {
            console.error('AJAX Error:', error);
            $("#currentQueue").html('Koneksi Terputus');
        });
    </script>
</body>

</html>
