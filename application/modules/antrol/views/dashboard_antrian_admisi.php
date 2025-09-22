<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Admisi</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;900&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Lato', sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .header {
            margin-bottom: 1em;
        }

        .video-section {
            height: 100%;
        }

        .content-top {
            border-radius: 10px;
            background-color: #fff;
            padding: 1em;
            overflow-x: auto;
        }

        .main-section {
            font-size: 80pt;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 45vh;
        }

        .sisa {
            text-align: center;
            font-size: 32pt;
        }

        .table {
            table-layout: auto;
            width: 100%;
        }

        .table td {
            font-size: 30pt;
            text-align: center;
            vertical-align: middle;
            height: 100px;
        }

        .row-full {
            margin-top: 2em;
        }
    </style>
</head>

<body>
    <div class="container p-4">
        <!-- Header -->
        <div class="header d-flex justify-content-between align-items-center">
            <img src="<?= base_url('assets/antrian/img/logo_kemenkes.png') ?>" height="60" width="120" alt="">
            <div>
                <span id="poli" style="font-size:34pt;">Antrian Admisi</span>
            </div>
            <img src="<?= base_url('assets/images/logo.png') ?>" width="60" height="60" alt="">
        </div>

        <!-- Row with Active Queue and Video -->
        <div class="row">
            <!-- Active Queue Section -->
            <div class="col-md-8 content-top mb-4">
                <center>
                    <div class="sisa">Antrian Sedang Dilayani</div>
                    <div class="main-section" id="currentQueue">Loading...</div>
                </center>
            </div>

            <!-- Video Section -->
            <div class="col-md-4 video-section">
                <iframe width="100%" height="315" src="https://www.youtube.com/embed/nL3xlTZO4T0"
                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>

        <!-- Row with Two Tables -->
        <div class="row row-full">
            <div class="col-md-6">
                <div class="content-top">
                    <h4 class="text-center">Antrian belum dilayani</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No. Antrian</th>
                                </tr>
                            </thead>
                            <tbody id="queueTable1">
                                <!-- Dynamic content for table 1 -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="content-top">
                    <h4 class="text-center">Antrian belum dilayani</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No. Antrian</th>
                                </tr>
                            </thead>
                            <tbody id="queueTable2">
                                <!-- Dynamic content for table 2 -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        function getdata() {
            $.get('<?= base_url('antrol/get_data_dashboard_antrian_admisi/') ?>', function (data, status) {
                // Update current queue
                if (data[0] && data[0].pasiendilayani) {
                    $("#currentQueue").html(`A-${String(data[0].pasiendilayani.nourut).padStart(3, '0')}`);
                }

                // Populate tables
                let table1 = '';
                let table2 = '';

                data[0].pasien.forEach((item, index) => {
                    let formattedAntrian = `A-${String(item.nomorantrian).padStart(3, '0')}`;
                    if (index < 1) {
                        table1 += `<tr><td>${formattedAntrian}</td></tr>`;
                    } else if (index > 0 && index < 2) {
                        table2 += `<tr><td>${formattedAntrian}</td></tr>`;
                    }
                });

                $("#queueTable1").html(table1);
                $("#queueTable2").html(table2);
            });
        }

        $(function () {
            getdata();
        });

        setInterval(function () { getdata() }, 10000);
    </script>
</body>

</html>
