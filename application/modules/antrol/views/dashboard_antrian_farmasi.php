<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Antrian Farmasi - RSUD Ahmad Syafii Maarif Sijunjung</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        :root {
            --primary-color: #059669;
            --secondary-color: #10b981;
            --accent-color: #34d399;
            --success-color: #22c55e;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;
            --light-color: #f8fafc;
            --dark-color: #1e293b;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-500: #64748b;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gradient-primary: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            --gradient-secondary: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            --gradient-light: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            --border-radius: 16px;
            --border-radius-lg: 24px;
            --border-radius-sm: 8px;
            --shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--gradient-light);
            color: var(--gray-800);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .dashboard-container {
            min-height: 100vh;
            padding: 20px;
            background: var(--gradient-light);
            position: relative;
        }

        .dashboard-container::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(5, 150, 105, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 60%, rgba(52, 211, 153, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .header-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--gradient-primary);
            border-radius: var(--border-radius-lg) var(--border-radius-lg) 0 0;
        }

        .hospital-logo {
            width: 80px;
            height: 80px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            border: 3px solid var(--primary-color);
        }

        .header-title {
            color: var(--gray-800);
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .header-subtitle {
            color: var(--gray-500);
            font-size: 1.2rem;
            font-weight: 500;
        }

        .datetime-display {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-sm);
            font-weight: 600;
        }


        .queue-section {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            padding: 2rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-title i {
            color: var(--primary-color);
        }

        .current-queue {
            background: var(--gradient-primary);
            color: white;
            padding: 3rem 2rem;
            border-radius: var(--border-radius-lg);
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .current-queue::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(30deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(30deg); }
        }

        .current-queue-label {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            opacity: 0.9;
            font-weight: 500;
        }

        .current-queue-number {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .current-queue-counter {
            font-size: 1.5rem;
            font-weight: 600;
            opacity: 0.9;
        }

        .queue-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .queue-item {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border-radius: var(--border-radius);
            padding: 1.5rem;
            border: 2px solid transparent;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .queue-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .queue-item:hover {
            transform: translateY(-4px);
            border-color: var(--primary-color);
            box-shadow: var(--shadow-lg);
        }

        .queue-item.dipanggil {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-color: var(--info-color);
            animation: pulse 2s infinite;
        }

        .queue-item.dipanggil::before {
            background: linear-gradient(90deg, var(--info-color) 0%, #60a5fa 100%);
        }

        .queue-item.selesai {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-color: var(--success-color);
        }

        .queue-item.selesai::before {
            background: var(--gradient-secondary);
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }

        .queue-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--gray-800);
            margin-bottom: 0.5rem;
        }

        .queue-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .queue-time {
            color: var(--gray-500);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .queue-status {
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-menunggu {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            color: #92400e;
        }

        .status-dipanggil {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
        }

        .status-diproses {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: #3730a3;
        }

        .status-selesai {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            color: #166534;
        }

        .queue-patient {
            color: var(--gray-700);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .queue-counter {
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            box-shadow: var(--shadow-sm);
        }

        .no-queue {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .no-queue i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: var(--gray-300);
        }

        .no-queue h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: var(--gray-600);
        }

        .refresh-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            padding: 0.75rem 1rem;
            border-radius: 50px;
            box-shadow: var(--shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: var(--gray-600);
            z-index: 1000;
        }

        .refresh-indicator i {
            color: var(--primary-color);
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .footer-info {
            margin-top: 2rem;
            text-align: center;
            color: var(--gray-500);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .header-section {
                padding: 1.5rem;
            }

            .header-title {
                font-size: 1.8rem;
            }

            .header-subtitle {
                font-size: 1rem;
            }

            .hospital-logo {
                width: 60px;
                height: 60px;
            }

            .current-queue-number {
                font-size: 3rem;
            }

            .queue-list {
                grid-template-columns: 1fr;
            }

            .datetime-display {
                padding: 0.75rem 1rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 576px) {
            .header-title {
                font-size: 1.5rem;
            }

            .current-queue-number {
                font-size: 2.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .loading-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .loading-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid var(--gray-200);
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
    </style>
</head>
<body>
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <div class="refresh-indicator" id="refreshIndicator">
        <i class="fas fa-sync-alt"></i>
        <span>Memperbarui data...</span>
    </div>

    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="header-section animate__animated animate__fadeInDown">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo RSUD" class="hospital-logo">
                </div>
                <div class="col-md-7">
                    <h1 class="header-title">Dashboard Antrian Farmasi</h1>
                    <p class="header-subtitle">RSUD Ahmad Syafii Maarif Sijunjung</p>
                </div>
                <div class="col-md-3 text-end">
                    <div class="datetime-display">
                        <div id="currentDateTime"></div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Queue Section -->
        <div class="queue-section animate__animated animate__fadeInUp">
            <h2 class="section-title">
                <i class="fas fa-pills"></i>
                Antrian Farmasi Saat Ini
            </h2>

            <!-- Current Queue Display -->
            <div class="current-queue" id="currentQueueDisplay">
                <div class="current-queue-label">Nomor Antrian Saat Ini</div>
                <div class="current-queue-number" id="currentQueueNumber">-</div>
                <div class="current-queue-counter" id="currentQueueCounter">Menunggu antrian pertama</div>
            </div>

            <!-- Queue List -->
            <div class="queue-list" id="queueList">
                <!-- Queue items will be populated here -->
            </div>

            <!-- No Queue Message -->
            <div class="no-queue d-none" id="noQueueMessage">
                <i class="fas fa-clipboard-list"></i>
                <h3>Belum Ada Antrian</h3>
                <p>Antrian farmasi belum tersedia untuk hari ini</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-info">
            <p>&copy; <?= date('Y') ?> RSUD Ahmad Syafii Maarif Sijunjung - Sistem Informasi Antrian Farmasi</p>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize dashboard
            updateDateTime();
            loadQueueData();

            // Set up auto-refresh
            setInterval(function() {
                loadQueueData();
                updateDateTime();
            }, 5000); // Refresh every 5 seconds

            // Update date time every second
            setInterval(updateDateTime, 1000);
        });

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

            const dateTimeString = now.toLocaleDateString('id-ID', options);
            $('#currentDateTime').text(dateTimeString);
        }

        function loadQueueData() {
            $('#refreshIndicator').addClass('show');

            $.ajax({
                url: '<?= base_url("antrol/get_antrian_farmasi") ?>',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        updateCurrentQueue(response.data);
                        updateQueueList(response.data);
                    } else {
                        console.error('Failed to load queue data:', response.message);
                        showNoQueueMessage();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading queue data:', error);
                    showNoQueueMessage();
                },
                complete: function() {
                    setTimeout(function() {
                        $('#refreshIndicator').removeClass('show');
                    }, 500);
                }
            });
        }


        function updateCurrentQueue(data) {
            const currentQueue = data.find(queue =>
                queue.status === 'dipanggil' || queue.status === 'diproses'
            );

            if (currentQueue) {
                $('#currentQueueNumber').text(currentQueue.no_antrian);
                $('#currentQueueCounter').text(`Loket Farmasi ${currentQueue.loket || '1'}`);
            } else {
                const nextQueue = data.find(queue => queue.status === 'menunggu');
                if (nextQueue) {
                    $('#currentQueueNumber').text(nextQueue.no_antrian);
                    $('#currentQueueCounter').text('Menunggu pemanggilan');
                } else {
                    $('#currentQueueNumber').text('-');
                    $('#currentQueueCounter').text('Tidak ada antrian');
                }
            }
        }

        function updateQueueList(data) {
            const queueList = $('#queueList');
            queueList.empty();

            if (data.length === 0) {
                showNoQueueMessage();
                return;
            }

            $('#noQueueMessage').addClass('d-none');
            queueList.removeClass('d-none');

            // Show recent queues (last 12 items)
            const recentQueues = data.slice(-12);

            recentQueues.forEach(function(queue, index) {
                const queueItem = createQueueItem(queue);
                queueList.append(queueItem);

                // Add animation delay
                setTimeout(function() {
                    $(queueItem).addClass('animate__animated animate__fadeInUp');
                }, index * 100);
            });
        }

        function createQueueItem(queue) {
            const statusClass = getStatusClass(queue.status);
            const statusText = getStatusText(queue.status);
            const timeText = formatTime(queue.waktu_daftar);

            return `
                <div class="queue-item ${queue.status}">
                    <div class="queue-number">${queue.no_antrian}</div>
                    <div class="queue-info">
                        <span class="queue-time">
                            <i class="far fa-clock"></i> ${timeText}
                        </span>
                        <span class="queue-status ${statusClass}">${statusText}</span>
                    </div>
                    <div class="queue-patient">
                        <i class="fas fa-user"></i> ${queue.nama_pasien || 'Pasien Farmasi'}
                    </div>
                    ${queue.loket ? `<div class="queue-counter">Loket ${queue.loket}</div>` : ''}
                </div>
            `;
        }

        function getStatusClass(status) {
            const statusMap = {
                'menunggu': 'status-menunggu',
                'dipanggil': 'status-dipanggil',
                'diproses': 'status-diproses',
                'selesai': 'status-selesai'
            };
            return statusMap[status] || 'status-menunggu';
        }

        function getStatusText(status) {
            const statusMap = {
                'menunggu': 'Menunggu',
                'dipanggil': 'Dipanggil',
                'diproses': 'Diproses',
                'selesai': 'Selesai'
            };
            return statusMap[status] || 'Menunggu';
        }

        function formatTime(timeString) {
            if (!timeString) return '-';

            const time = new Date(timeString);
            return time.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                timeZone: 'Asia/Jakarta'
            });
        }

        function showNoQueueMessage() {
            $('#queueList').addClass('d-none');
            $('#noQueueMessage').removeClass('d-none');
            $('#currentQueueNumber').text('-');
            $('#currentQueueCounter').text('Tidak ada antrian');
        }

        // Hide loading overlay after page load
        $(window).on('load', function() {
            setTimeout(function() {
                $('#loadingOverlay').removeClass('show');
            }, 500);
        });

        // Error handling for images
        $('img').on('error', function() {
            $(this).attr('src', 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjgwIiBoZWlnaHQ9IjgwIiBmaWxsPSIjRTVFN0VCIi8+CjxwYXRoIGQ9Ik00MCAyMEM0Ni42Mjc0IDIwIDUyIDI1LjM3MjYgNTIgMzJDNTIgMzguNjI3NCA0Ni42Mjc0IDQ0IDQwIDQ0QzMzLjM3MjYgNDQgMjggMzguNjI3NCAyOCAzMkMyOCAyNS4zNzI2IDMzLjM3MjYgMjAgNDAgMjBaIiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yOCA1Nkw0MCA0NEw1MiA1NiIgc3Ryb2tlPSIjOUNBM0FGIiBzdHJva2Utd2lkdGg9IjIiLz4KPC9zdmc+');
        });
    </script>
</body>
</html>