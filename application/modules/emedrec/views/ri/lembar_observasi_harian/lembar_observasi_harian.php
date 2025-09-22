<?php
//$data = (isset($observasi_harian->formjson) ? json_decode($observasi_harian->formjson) : '');
// var_dump($data);
?>

<head>
    <title>Lembar Observasi Pasien Harian</title>
</head>

<style>
    .data-tbl-obs {
        margin-top: 10px;
        border-collapse: collapse;
        border: 1px solid black;
        width: 97.4%;
        font-size: 10px;
        position: relative;
        table-layout: fixed;
    }

    .data-tbl-obs tr td {
        vertical-align: middle;
        border: 1px solid black;
        font-size: 7px;
        padding: 1px;
        overflow-wrap: break-word;
    }
</style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<script src="<?php echo base_url('assets/chartjs/dist/chart.js'); ?>"></script>
<script src="<?php echo base_url('assets/chartjs/dist/chartjs-plugin-datalabels.js'); ?>"></script>

<body class="A4 landscape">
    <?php
    $page = 1;
    $totalData = isset($pemeriksaan_fisik_iri) ? count($pemeriksaan_fisik_iri) : 0;
    $limit = 15;
    $totalPages = ceil($totalData / $limit);
    $page = max($page, 1);
    $page = min($page, $totalPages);
    while ($page <= $totalPages) {
        $offset = ($page - 1) * $limit;
        if ($offset < 0) $offset = 0;
    ?>
        <div class="A4 sheet padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_landscape') ?>
            </header>

            <center>
                <h4>Lembar Observasi Pasien Harian</h4>
            </center>
            <div style="font-size:12px">
                <!-- <p>
                    Ruang Rawat / unit kerja :
                    <?= isset($data->question5) ? $data->question5 : '' ?>
                </p> -->

                <div style="position:absolute;bottom:580;right:37">
                    <div style="position:absolute;bottom:0%;right:0%;">
                        <!-- <?php
                                if (isset($data->question3)) {
                                ?>
                            <img src=" <?= $data->question3 ?>" alt="img" height="150px" width="750px">
                        <?php } ?> -->
                    </div>
                </div>
                <div style="height: 380px; width:100%">
                    <canvas id="chartObservasi<?= $page; ?>" style="padding-top: 10px"></canvas>
                </div>

                <table class="data-tbl-obs">
                    <tr>
                        <td style="width: 134px;">TANGGAL</td>
                        <?php
                        foreach (array_slice($tgl_pemeriksaan, $offset, $limit) as $item_tp) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_tp ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">WAKTU</td>
                        <?php

                        foreach (array_slice($waktu_pemeriksaan, $offset, $limit) as $item_wp) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_wp ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">FREKUENSI PERNAPASAN</td>
                        <?php
                        foreach (array_slice($frekuensi_nafas, $offset, $limit) as $item_fn) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_fn ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">SATURASI OKSIGEN</td>
                        <?php
                        foreach (array_slice($oksigen, $offset, $limit) as $item_o) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo str_replace('%', '', $item_o) ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">CVP</td>
                        <?php
                        foreach (array_slice($cvp, $offset, $limit) as $item_cvp) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_cvp ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">BERAT BADAN</td>
                        <?php
                        foreach (array_slice($bb, $offset, $limit) as $item_bb) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_bb ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">SKALA NYERI</td>
                        <?php
                        foreach (array_slice($skala_nyeri, $offset, $limit) as $item_sn) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_sn ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px;">LUKA SKALA NORTON</td>
                        <?php
                        foreach (array_slice($skala_norton, $offset, $limit) as $item_lsn) {
                        ?>
                            <td style="text-align: center;">
                                <?php echo $item_lsn ?>
                            </td>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td style="width: 134px; vertical-align: middle;">PARAF / INISIAL NAMA PERAWAT</td>
                        <?php
                        foreach (array_slice($nama_pemeriksa, $offset, $limit) as $item_ttd) {
                        ?>
                            <td style="text-align: center; vertical-align: top;">
                                <img src="<?php echo $item_ttd[1] ?>" width="25px" height="20px" alt="" style="margin-bottom: 2px;"><br>
                                <span style="font-size: 8px;">
                                    <?php echo $item_ttd[0] ?>
                                </span>
                            </td>
                        <?php } ?>
                    </tr>
                </table>

                <table width="100%" class="data-tbl-obs">
                    <tr>
                        <td width="10%" style="text-align:center">0</td>
                        <td width="10%" style="text-align:center">1</td>
                        <td width="10%" style="text-align:center">2</td>
                        <td width="10%" style="text-align:center">3</td>

                        <td width="10%" style="text-align:center">5</td>
                        <td width="10%" style="text-align:center">6</td>
                        <td width="10%" style="text-align:center">7</td>
                        <td width="10%" style="text-align:center">8</td>
                        <td width="10%" style="text-align:center">9</td>
                        <td width="10%" style="text-align:center">10</td>
                    </tr>
                </table>

            </div>
            <br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <?= ($page != 0) ? 'Hal ' . $page . ' dari ' . $totalPages : 'Hal 1 dari 1'; ?>
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document) ? $kode_document != "" ? $kode_document->tgl_rev_form . '.' . ' ' . $kode_document->kode_form : "" : ""; ?> </p>
                </div>
            </div>



        </div>
        <script type="text/javascript">
            var tekanan_darah = <?= json_encode(array_slice($tekanan_darah, $offset, $limit)) ?>;
            var suhu = <?= json_encode(array_slice($suhu, $offset, $limit)) ?>;
            var nadi = <?= json_encode(array_slice($nadi, $offset, $limit)) ?>;
            var chart_tgl = <?= json_encode(array_slice($chart_tgl, $offset, $limit)) ?>;
            var gcs_e = <?= json_encode(array_slice($gcs_e, $offset, $limit)) ?>;
            var gcs_m = <?= json_encode(array_slice($gcs_m, $offset, $limit)) ?>;
            var gcs_v = <?= json_encode(array_slice($gcs_v, $offset, $limit)) ?>;
            const ctx<?= $page; ?> = document.getElementById('chartObservasi<?= $page; ?>');
            const chartObservasi<?= $page; ?> = new Chart(ctx<?= $page; ?>, {
                data: {
                    datasets: [{
                        type: 'bar',
                        label: 'Tekanan Darah',
                        yAxisID: 'y',
                        data: tekanan_darah,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            '#6FEDD6'
                        ],
                        borderWidth: 1,
                        datalabels: {
                            display: true,
                            font: {
                                size: 9,
                                weight: 'bold'
                            }
                        },
                        borderSkipped: false
                    }, {
                        type: 'line',
                        label: 'Nadi',
                        yAxisID: 'y',
                        data: nadi,
                        backgroundColor: '#EB1D36',
                        borderColor: 'rgba(255, 99, 132, 0.2)',
                        datalabels: {
                            display: true,
                            align: 'bottom',
                            font: {
                                size: 8,
                                weight: 'bold'
                            },
                            color: '#EB1D36'
                        },
                        pointRadius: 2,
                    }, {
                        type: 'line',
                        label: 'Suhu',
                        yAxisID: 'suhuYaxis',
                        data: suhu,
                        backgroundColor: '#25316D',
                        borderColor: 'rgba(54, 162, 235, 0.2)',
                        datalabels: {
                            display: true,
                            align: 'bottom',
                            font: {
                                size: 8,
                                weight: 'bold'
                            },
                            color: '#25316D'
                        },
                        pointRadius: 2,
                    }, {
                        type: 'line',
                        label: 'GCS E',
                        yAxisID: 'gcsYaxis',
                        data: gcs_e,
                        backgroundColor: '#A4D0A4',
                        borderColor: 'rgb(164, 208, 164, 0.2)',
                        datalabels: {
                            display: true,
                            align: 'bottom',
                            font: {
                                size: 8,
                                weight: 'bold'
                            },
                            color: '#A4D0A4'
                        },
                        lineTension: 0.5,
                        pointStyle: 'rectRot',
                        pointRadius: 3,
                    }, {
                        type: 'line',
                        label: 'GCS M',
                        yAxisID: 'gcsYaxis',
                        data: gcs_m,
                        backgroundColor: '#7FB77E',
                        borderColor: 'rgb(97, 130, 100, 0.2)',
                        datalabels: {
                            display: true,
                            align: 'bottom',
                            font: {
                                size: 8,
                                weight: 'bold'
                            },
                            color: '#7FB77E'
                        },
                        lineTension: 0.5,
                        pointStyle: 'rectRot',
                        pointRadius: 3,
                    }, {
                        type: 'line',
                        label: 'GCS V',
                        yAxisID: 'gcsYaxis',
                        data: gcs_v,
                        backgroundColor: '#004225',
                        borderColor: 'rgb(0, 66, 37, 0.2)',
                        datalabels: {
                            display: true,
                            align: 'bottom',
                            font: {
                                size: 8,
                                weight: 'bold'
                            },
                            color: '#004225'
                        },
                        lineTension: 0.5,
                        pointStyle: 'rectRot',
                        pointRadius: 3,
                    }],
                    labels: chart_tgl
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'left',
                            labels: {
                                font: {
                                    size: 6,
                                    family: 'Helvetica'
                                }
                            }
                        }
                    },
                    scales: {
                        xAxes: {
                            position: 'top',
                            ticks: {
                                font: {
                                    size: 11
                                }
                            },
                        },
                        y: {
                            beginAtZero: true,
                            type: 'linear',
                            position: 'left',
                            max: 300,
                            // min: 0
                        },
                        suhuYaxis: {
                            // beginAtZero: true,
                            type: 'linear',
                            position: 'right',
                            ticks: {

                            },
                            min: 30,
                            max: 40,
                            grid: {
                                drawOnChartArea: false
                            },
                        },
                        gcsYaxis: {
                            // beginAtZero: true,
                            type: 'linear',
                            display: false,
                            position: 'right',
                            ticks: {

                            },
                            min: 0,
                            max: 30,
                            grid: {
                                drawOnChartArea: false
                            },
                        }

                    },
                },
                plugins: [ChartDataLabels]
            });
        </script>
    <?php
        $page++;
    }
    ?>
</body>

</html>