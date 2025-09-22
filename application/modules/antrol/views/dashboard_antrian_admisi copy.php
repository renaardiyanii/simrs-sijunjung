<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Antrian Poliklinik</title>
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
            /* background: linear-gradient(0deg, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)),url("<?= base_url('assets/antrian/img/bg_rs.jpg') ?>"); */
            /* background-repeat: no-repeat; */
            background-color: #f5f5f5;
            /* background-position: center ; */
            /* background-size:  100% 100%; */
            /* height:100vh; */
            /* background-color: rgba(255, 255, 255, 0.486); */
        }

        .header {}

        .main {
            margin-top: 1em;
            height: 80vh;
        }

        .content-top {
            min-height: 78vh;
            border-radius: 10px;
            background-color: #fff;
        }

        .content-bottom {
            height: 29vh;
            display: grid;
            grid-column-gap: 1em;
            /* grid-template-columns: repeat(6, 1fr); */

        }

        .batas {
            height: 2vh;
        }

        .section {
            width: 100%;
            padding-top: 1em;
            /* background-color:blue; */
        }

        .main-section {
            /* background-color:purple; */
            height: 70%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 50pt;
            min-height:10vh;
        }

        .sisa {
            text-align: center;
            height: auto;
            font-size: 22pt;
            /* background-color:red; */
        }

        .garis {
            margin-top: 3em;
            height: 80%;
            background-color: #BDBDBD;
            width: 5px;
        }

        .section-bawah {
            /* background:red; */
            /* border:1px solid black; */
            height: 100%;

            border-radius: 10px;
            background-color: #fff;
        }
    </style>
</head>

<body>
    <div class="p-4">
        <div class="header d-flex justify-content-between ">
            <img src="<?= base_url('assets/antrian/img/logo_kemenkes.png') ?>" height="60" width="120" alt="">
            <div style="padding-right:2em;">
                <span id="poli" style="font-size:34pt;">Loading...</span>
            </div>
            <img src="<?= base_url('assets/images/logo.png') ?>" width="60" height="60" alt="">
        </div>
        <div>
            <div class="row" id="countdokter">

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script>
        let namapoli = '';
        function getdata() {
            $.get('<?= base_url('antrol/get_data_dashboard_antrian_admisi/' ) ?>', function (data, status) {
            // handle data
            // tambahkan berapa banyak dokter
            var banyakdokter = '';
            $("#poli").html(`ANTRIAN ADMISI`);
            data.map((e) => {
                var listpasien = '';
                e.pasien.map((i) => {
                    // Tambahkan leading format A-00{no antrian}
                    var formattedAntrian = `A-${String(i.nomorantrian).padStart(3, '0')}`;
                    listpasien += `<li>${formattedAntrian}</li>`;
                });
                banyakdokter += `
                <div class="content-top col mx-2">
                    <center>
                        <div class="section">
                            <div class="sisa">Antrian Sedang Dilayani</div>
                            <div class="main-section">A-${String(e.pasiendilayani.nourut).padStart(3, '0')}</div>
                            <h4>Antrian Selanjutnya</h4>
                            <ol>
                            ${listpasien}
                            </ol>
                        </div>
                    </center>
                </div>
                `;
            });
            $("#countdokter").html(banyakdokter);
        });

        }
        $(function () {
            getdata();
        })

        setInterval(function () { getdata() }, 10000);
    </script>
</body>

</html>