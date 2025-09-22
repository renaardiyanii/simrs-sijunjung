<?php
$data = (isset($sedasi->formjson)?json_decode($sedasi->formjson):'');
$result = array_chunk($sedasi, 1);
// var_dump($data);
$data_grafik = (!empty($stat_sedasi_grafik_pemantauan[0]->grafikjson) ? json_decode($stat_sedasi_grafik_pemantauan[0]->grafikjson) : '');
if (!empty($data_grafik->questiongraphic)) {
    foreach ($data_grafik->questiongraphic as $gpv) {
        $gp_tekanan_darah[] = (!empty($gpv->column2) and !empty($gpv->column3)) ? [$gpv->column2, $gpv->column3] : NULL;
        $gp_jam[] = date('H:i', strtotime($gpv->jam));
        $gp_nadi[] = (!empty($gpv->column4)) ? $gpv->column4 : NULL;
        $gp_saturasi[] = (!empty($gpv->column5)) ? $gpv->column5 : NULL;
        $gp_anestesi[] = (!empty($gpv->column6)) ? $gpv->column6 : NULL;
        $gp_operasi[] = (!empty($gpv->column7)) ? $gpv->column7 : NULL;
    }
}
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        }

        #border {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        }
        #data tr td{
            
            font-size: 10px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   <script src="<?php echo base_url('assets/chartjs/dist/chart.js'); ?>"></script>
    <script src="<?php echo base_url('assets/chartjs/dist/chartjs-plugin-datalabels.js'); ?>"></script>
    <script src="<?php echo base_url('assets/form/jquery-3.6.0.js') ?>"></script>
    <script src="<?php echo base_url('assets/form/sweetalert2@11.js') ?>"></script>
    <style>
        @media print {
            #btnAlertAutomaticTerminated {
                display: none !important;
            }
        }

        #btnAlertAutomaticTerminated span {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>
    <script>
        let swalGPTerminated = function() {
            Swal.fire({
                title: 'Feature automatically terminated!',
                text: "Apakah masih ingin menggunakan automasisasi untuk grafik pemantauan ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, refresh page',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                } else {
                    $('#btnAlertAutomaticTerminated').css('display', 'block');
                }
            });
        };
        $(document).ready(function() {
            $('#btnAlertAutomaticTerminated').on('click', function() {
                swalGPTerminated();
            });
        });
    </script>
    <body class="A4" >
    <button style="background-color: red; font-size: 20px; position: fixed; bottom: 10; right:10; display: none; border:2px solid #f44336; background-color: white; border-radius: 5px; cursor: pointer;" id="btnAlertAutomaticTerminated"><span>!</span></button>    
    <?php 
    if($result){
        for($i = 0;$i<count($result);$i++){ ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><h4>STATUS SEDASI</h4></center>
            <?php 
            // $val = $result[$i]->formjson?json_decode($result[$i]->formjson):null;
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
                //  var_dump($value);die();
            ?>
            <div style="font-size:12px">
                <table width="100%" id="data" border="1">
                        <tr>
                        <td width="25%" colspan="2">Diagnosa : <?= isset( $value->question1->diagnosa)? $value->question1->diagnosa:'' ?></td>
                        <td width="25%" colspan="2">Tindakan : <?= isset( $value->question1->tindakan)? $value->question1->tindakan:'' ?></td>
                        </tr>
                        <tr>
                        <th colspan="4">PENILAIAN PRA SEDASI</th> 
                        </tr>
                        <tr>
                        <td colspan="4">
                            <span>BB: <?= isset( $value->question2->bb)? $value->question2->bb:'' ?>  Kg </span>
                            <span style="margin-left:20px"> TB: <?= isset( $value->question2->tb)? $value->question2->tb:'' ?>    cm </span>
                            <span style="margin-left:20px"> TD:   <?= isset( $value->question2->td)? $value->question2->td:'' ?>     mmHg </span>
                            <span style="margin-left:20px"> Nadi:  <?= isset( $value->question2->nadi)? $value->question2->nadi:'' ?>    x/menit </span>
                            <span style="margin-left:20px"> Nafas: <?= isset( $value->question2->nafas)? $value->question2->nafas:'' ?>     x/menit </span> 
                            <span style="margin-left:20px"> Suhu:  <?= isset( $value->question2->suhu)? $value->question2->suhu:'' ?>  </span>
                            <span style="margin-left:20px">  SpO2: <?= isset( $value->question2->sp02)? $value->question2->sp02:'' ?>      %    </span>
                        </td> 
                        </tr>
                        <tr>
                        <td width="25%">
                            <span>Jalan Nafas</span><br><br>
                            <input type="checkbox"  <?= (isset( $value-> question3)?in_array('normal', $value->question3)?'checked':'':'') ?>>
                            <span>Normal</span><br>
                            <input type="checkbox"  <?= (isset( $value-> question3)?in_array('mulut_kecil', $value->question3)?'checked':'':'') ?>>
                            <span>Mulut Kecil</span><br>
                            <input type="checkbox"  <?= (isset( $value-> question3)?in_array('gigi', $value->question3)?'checked':'':'') ?>>
                            <span>Gigi Prominem</span><br>
                            <input type="checkbox"  <?= (isset( $value-> question3)?in_array('dagu', $value->question3)?'checked':'':'') ?>>
                            <span> Dagu Keci</span>
                        </td>
                        <td width="25%"><img   src="<?= isset( $value->question4)? $value->question4:''; ?>"  width="200px" height="100px" alt=""></td>
                        <td width="25%">
                                <span>Leher</span><br><br>
                                <input type="checkbox" value="Ureum" <?= (isset( $value->question5)?in_array('normal', $value->question5)?'checked':'':'') ?>>
                                <span>Normal </span><br>
                                <input type="checkbox" value="Ureum" <?= (isset( $value->question5)?in_array('leher', $value->question5)?'checked':'':'') ?>>
                                <span> Leher Pendek</span><br>
                                <input type="checkbox" value="Ureum" <?= (isset( $value->question5)?in_array('gerak', $value->question5)?'checked':'':'') ?>>
                                <span> Gerak Leher Terbatas</span>
                        </td>
                        <td width="25%">
                        <img   src="<?= isset( $value->question6)? $value->question6:''; ?>"  width="200px" height="100px" alt="">  
                        </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div style="display:flex">
                                    <div>
                                        <span>Riwayat Alergi</span>
                                    </div>
                                    <div style="margin-left:100px">
                                        <input type="checkbox" value="Ureum" <?php echo isset( $value->question7)?  $value->question7 == "other" ? "checked":'':'' ?>>
                                        <span> Ya, <?= isset( $value->{'question7-Comment'})? $value->{'question7-Comment'}:'' ?></span><br>
                                        <input type="checkbox" value="Ureum" <?php echo isset( $value->question7)?  $value->question7 == "tidak" ? "checked":'':'' ?>>
                                        <span> Tidak</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex">
                                    <div>
                                        <span>Puasa</span>
                                    </div>
                                    <div style="margin-left:20px">        
                                        <span> Makan: <?= isset( $value->question8->text1)? $value->question8->text1:'' ?></span><br>
                                        <span> Minum: <?= isset( $value->question8->text2)? $value->question8->text2:'' ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                </table>
                <table width="100%" id="data" border="1">
                    <tr>
                        <td width="30%">
                            <span>IV line </span>
                            <span style="margin-left:20px">Tempat   : <?= isset( $value->question9->tempat)? $value->question9->tempat:'' ?></span><br>
                            <span>&nbsp;</span>
                            <span style="margin-left:20px">Cairan     :  <?= isset( $value->question9->cairan)? $value->question9->cairan:'' ?> cc/jam</span><br>
                        </td>
                        <td width="30%">
                            <span>Laboratorium/Pemeriksaan Penunjang</span>
                            <p><?= isset( $value->question10)? $value->question10:'' ?></p>
                        </td>
                        <td width="20%" colspan="2" style="text-align:center">Tindakan</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            <span>ASA : <?= isset( $value->question12)? $value->question12:'' ?></span>
                        </td>
                        <td width="30%">
                            <span>Rencana Sedasi:</span>
                            <p><?= isset( $value->question13)? $value->question13:'' ?></p>
                        </td>
                        <td width="20%"  style="text-align:center"><?= isset( $value->question11->mulai)? $value->question11->mulai:'' ?></td>
                        <td width="20%"  style="text-align:center"><?= isset( $value->question11->selesai)? $value->question11->selesai:'' ?></td>
                    </tr>
                </table>
                <table width="100%" id="data" border="1">
                    <tr>
                        <td colspan="24" style="font-weight:bold;text-align:center">MONITORING SELAMA SEDASI</td>
                    </tr>
                    <tr>
                            <td width="25%">JAM</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->jam)? $value->question24[$x]->question14[0]->jam:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Obat-obatan</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->obat)? $value->question24[$x]->question14[0]->obat:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Pernafasan</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->pernafasan)? $value->question24[$x]->question14[0]->pernafasan:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">O2 (l/menit)</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->o2)? $value->question24[$x]->question14[0]->o2:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">SpO2</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->spO2)? $value->question24[$x]->question14[0]->spO2:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Skala Nyeri</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->skala_nyeri)? $value->question24[$x]->question14[0]->skala_nyeri:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Kesadaran</td>
                            <?php 
                            $jml_array = isset( $value->question24)?count( $value->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset( $value->question24[$x]->question14[0]->kesadaran)? $value->question24[$x]->question14[0]->kesadaran:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="24">
                            <canvas id="chartGrafikPemantauan<?= $val->id ?>" style="padding-top: 5px; height: 350px;"></canvas>
                            <script type="text/javascript">
                                let chart_jam = <?= json_encode((!empty($gp_jam)) ? $gp_jam  : []) ?>;
                                let tekanan_darah = <?= json_encode((!empty($gp_tekanan_darah)) ? $gp_tekanan_darah  : []) ?>;
                                let nadi = <?= json_encode((!empty($gp_nadi)) ? $gp_nadi : []) ?>;
                                let saturasi = <?= json_encode((!empty($gp_saturasi)) ? $gp_saturasi : []) ?>;
                                let anestesi = <?= json_encode((!empty($gp_anestesi)) ? $gp_anestesi : []) ?>;
                                let operasi = <?= json_encode((!empty($gp_operasi)) ? $gp_operasi : []) ?>;
                                const ctxGP<?= $val->id ?> = document.getElementById('chartGrafikPemantauan<?= $val->id ?>');
                                const chartGrafikPemantauan<?= $val->id ?> = new Chart(ctxGP<?= $val->id ?>, {
                                    data: {
                                        datasets: [{
                                            type: 'line',
                                            label: 'Nadi',
                                            yAxisID: 'y',
                                            data: nadi,
                                            backgroundColor: '#144272',
                                            borderColor: '#607EAA',
                                            datalabels: {
                                                display: true,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#144272'
                                            },
                                            pointStyle: 'circle',
                                            pointRadius: 2,
                                            pointBorderColor: '#144272',
                                            // tension: 0.4
                                        }, {
                                            type: 'line',
                                            label: 'Saturasi',
                                            yAxisID: 'y',
                                            data: saturasi,
                                            backgroundColor: '#89C4E1',
                                            borderColor: '#C1EFFF',
                                            datalabels: {
                                                display: true,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#89C4E1'
                                            },
                                            pointStyle: 'crossRot',
                                            pointRadius: 7,
                                            pointBorderColor: '#89C4E1',
                                            // tension: 0.4
                                        }, {
                                            type: 'line',
                                            label: 'Anestesi',
                                            yAxisID: 'y',
                                            data: anestesi,
                                            datalabels: {
                                                display: false,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#829460'
                                            },
                                            pointStyle: 'crossRot',
                                            pointBorderColor: function(context) {
                                                let getOnlyValbcGPcAnestesi = context.dataset.data;
                                                let arrbcGPcAnestesi = [];
                                                let countbcGPcAnestesi = 0;
                                                for (let bcGPcAnestesi = 0; bcGPcAnestesi < getOnlyValbcGPcAnestesi.length; bcGPcAnestesi++) {
                                                    if (getOnlyValbcGPcAnestesi[bcGPcAnestesi] !== null) {
                                                        ((countbcGPcAnestesi % 2) == 0) ? arrbcGPcAnestesi.push('green'): arrbcGPcAnestesi.push('red');
                                                        countbcGPcAnestesi++;
                                                    } else {
                                                        arrbcGPcAnestesi.push(null);
                                                    }
                                                }
                                                return arrbcGPcAnestesi;
                                            },
                                            pointRadius: 6,
                                            borderWidth: 2,
                                            hoverBorderWidth: 2
                                            // pointBorderColor: '#829460'
                                        }, {
                                            type: 'line',
                                            label: 'Operasi',
                                            yAxisID: 'y',
                                            data: operasi,
                                            datalabels: {
                                                display: false,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#252525'
                                            },
                                            pointStyle: 'circle',
                                            pointBorderColor: function(context) {
                                                let getOnlyValbcGPcOperasi = context.dataset.data;
                                                let arrbcGPcOperasi = [];
                                                let countbcGPcOperasi = 0;
                                                for (let bcGPcOperasi = 0; bcGPcOperasi < getOnlyValbcGPcOperasi.length; bcGPcOperasi++) {
                                                    if (getOnlyValbcGPcOperasi[bcGPcOperasi] !== null) {
                                                        ((countbcGPcOperasi % 2) == 0) ? arrbcGPcOperasi.push('green'): arrbcGPcOperasi.push('red');
                                                        countbcGPcOperasi++;
                                                    } else {
                                                        arrbcGPcOperasi.push(null);
                                                    }
                                                }
                                                return arrbcGPcOperasi;
                                            },
                                            pointRadius: 4,
                                            borderWidth: 2,
                                            hoverBorderWidth: 2
                                            // pointBorderColor: '#252525'
                                        }, {
                                            type: 'bar',
                                            label: 'Tekanan Darah',
                                            yAxisID: 'y',
                                            data: tekanan_darah,
                                            backgroundColor: '#FFE6E6',
                                            borderColor: '#EB455F',
                                            borderWidth: 1,
                                            datalabels: {
                                                display: true,
                                                font: {
                                                    size: 9,
                                                    weight: 'bold',
                                                    align: 'center'
                                                }
                                            },
                                            borderSkipped: false
                                        }],
                                        labels: chart_jam
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
                                                },
                                                display: false
                                            }
                                        },
                                        scales: {
                                            xAxes: {
                                                position: 'top',
                                                ticks: {
                                                    // font: {
                                                    //     size: 8
                                                    // },
                                                    autoSkip: false
                                                },
                                            },
                                            y: {
                                                beginAtZero: true,
                                                type: 'linear',
                                                position: 'left',
                                                max: 200,
                                                // min: 0,
                                                title: {
                                                    display: true,
                                                    text: 'Tekanan Darah, Nadi & Saturasi',
                                                    color: '#252525',
                                                    font: {
                                                        family: 'Times',
                                                        size: 10,
                                                        style: 'normal',
                                                        lineHeight: 1.2
                                                    },
                                                    padding: {
                                                        top: 10,
                                                        left: 0,
                                                        right: 0,
                                                        bottom: 0
                                                    },
                                                },
                                                ticks: {
                                                    stepSize: 10,
                                                    font: {
                                                        size: 8
                                                    }
                                                }
                                            }
                                        },
                                    },
                                    plugins: [ChartDataLabels]
                                });
                                let getDataNewGP = function() {
                                    $.ajax({
                                        url: "<?php echo base_url('emedrec/C_emedrec_iri/status_sedasi_grafik_pemantauan_ajax/') . $no_reg ?>",
                                        success: function(data) {
                                            let tesss = 11;
                                            let tmp_newGP<?= $val->id ?> = JSON.parse(data);
                                            for (let indNGP = 0; indNGP < tmp_newGP<?= $val->id ?>.new_total; indNGP++) {
                                                chartGrafikPemantauan<?= $val->id ?>.data.labels.splice(indNGP, 1, tmp_newGP<?= $val->id ?>.new_jam[indNGP]);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[0].data.splice(indNGP, 1, tmp_newGP<?= $val->id ?>.new_nadi[indNGP]);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[1].data.splice(indNGP, 1, tmp_newGP<?= $val->id ?>.new_oksigen[indNGP]);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[2].data.splice(indNGP, 1, tmp_newGP<?= $val->id ?>.new_anestesi[indNGP]);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[3].data.splice(indNGP, 1, tmp_newGP<?= $val->id ?>.new_operasi[indNGP]);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[4].data.splice(indNGP, 1, tmp_newGP<?= $val->id ?>.new_tekanan_darah[indNGP]);
                                            }
                                            if (chartGrafikPemantauan<?= $val->id ?>.data.datasets[0].data.length > tmp_newGP<?= $val->id ?>.new_total) {
                                                let tmp_col_surplus = chartGrafikPemantauan<?= $val->id ?>.data.datasets[0].data.length - tmp_newGP<?= $val->id ?>.new_total;
                                                chartGrafikPemantauan<?= $val->id ?>.data.labels.splice(tmp_newGP<?= $val->id ?>.new_total, tmp_col_surplus);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[0].data.splice(tmp_newGP<?= $val->id ?>.new_total, tmp_col_surplus);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[1].data.splice(tmp_newGP<?= $val->id ?>.new_total, tmp_col_surplus);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[2].data.splice(tmp_newGP<?= $val->id ?>.new_total, tmp_col_surplus);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[3].data.splice(tmp_newGP<?= $val->id ?>.new_total, tmp_col_surplus);
                                                chartGrafikPemantauan<?= $val->id ?>.data.datasets[4].data.splice(tmp_newGP<?= $val->id ?>.new_total, tmp_col_surplus);
                                            }
                                            chartGrafikPemantauan<?= $val->id ?>.update('none');
                                        }
                                    });
                                    console.log('running');
                                };
                                let int_DataNewGP = setInterval(getDataNewGP, 180000);

                                setTimeout(function() {
                                    clearInterval(int_DataNewGP);
                                    swalGPTerminated();
                                    console.log('stop');
                                }, 5400000);
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="24">
                            Catatan
                            <p><?= isset( $value->catatan)? $value->catatan:'' ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="24" style="text-align:center;font-weight:bold">
                            PENILAIAN PASCA SEDASI
                        </td>
                    </tr>
                    </table>
                    
                
                <table width="100%" id="data" border="1">
                    <tr>
                        <td width="25%" style="text-align:center;vertical-align:middle">Aldrette Score/Steward Score</td>
                        <td width="25%" style="text-align:center;vertical-align:middle"><?= isset( $value->question18)? $value->question18:'' ?></td>
                        <td colspan="2">
                            <span>Bukittinggi, <?= isset($sedasi->tgl_input)?date('d-m-y',strtotime($sedasi->tgl_input)):'' ?> jam <?= isset($sedasi->tgl_input)?date('h:i',strtotime($sedasi->tgl_input)):'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="checkbox" value="Ureum" <?php echo isset( $value->pulang)?  $value->pulang == "pulang" ? "checked":'':'' ?>>
                            <span>Boleh Pulang / Kembali Ke Ruangan </span><br>
                            <input type="checkbox" value="Ureum" <?php echo isset( $value->pulang)?  $value->pulang == "mrs" ? "checked":'':'' ?>>
                            <span>MRS</span>
                        </td>
                        <td>
                            <center>
                                <span>Dokter Anestesi</span>
                                    <?php
                                    $id = isset($sedasi->id_pemeriksa)?$sedasi->id_pemeriksa:null;
                                    //  var_dump($id);                                     
                                    $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                    if(isset($query->ttd)){
                                    ?>
                                        <center>
                                        <img style="text-align:center" width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                        <span style="text-align:center">(<?= $query->name ?>)</span>
                                    </center>
                                    <?php
                                    } else {?>
                                        <br><br><br>
                                    <?php } ?>
                            
                            </center>
                        </td>
                        <td>
                            <center>
                                <span>Penata Anestesi</span>
                                <?php
                                    $id = isset($sedasi->id_pemeriksa)?$sedasi->id_pemeriksa:null;
                                    //  var_dump($id);                                     
                                    $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                    if(isset($query->ttd)){
                                    ?>
                                        <center>
                                        <img style="text-align:center" width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                        <span style="text-align:center">(<?= $query->name ?>)</span>
                                    </center>
                                    <?php
                                    } else {?>
                                        <br><br><br>
                                    <?php } ?>
                            
                            </center>
                        </td>
                    </tr>
                </table>
            </div><br><br><br><br><br><br>
            <?php endforeach; ?>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    <?php }}else{ ?> 
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><h4>STATUS SEDASI</h4></center>
            <div style="font-size:12px">
                <table width="100%" id="data" border="1">
                        <tr>
                        <td width="25%" colspan="2">Diagnosa : <?= isset($data->question1->diagnosa)?$data->question1->diagnosa:'' ?></td>
                        <td width="25%" colspan="2">Tindakan : <?= isset($data->question1->tindakan)?$data->question1->tindakan:'' ?></td>
                        </tr>
                        <tr>
                        <th colspan="4">PENILAIAN PRA SEDASI</th> 
                        </tr>
                        <tr>
                        <td colspan="4">
                            <span>BB: <?= isset($data->question2->bb)?$data->question2->bb:'' ?>  Kg </span>
                            <span style="margin-left:20px"> TB: <?= isset($data->question2->tb)?$data->question2->tb:'' ?>    cm </span>
                            <span style="margin-left:20px"> TD:   <?= isset($data->question2->td)?$data->question2->td:'' ?>     mmHg </span>
                            <span style="margin-left:20px"> Nadi:  <?= isset($data->question2->nadi)?$data->question2->nadi:'' ?>    x/menit </span>
                            <span style="margin-left:20px"> Nafas: <?= isset($data->question2->nafas)?$data->question2->nafas:'' ?>     x/menit </span> 
                            <span style="margin-left:20px"> Suhu:  <?= isset($data->question2->suhu)?$data->question2->suhu:'' ?>  </span>
                            <span style="margin-left:20px">  SpO2: <?= isset($data->question2->sp02)?$data->question2->sp02:'' ?>      %    </span>
                        </td> 
                        </tr>
                        <tr>
                        <td width="25%">
                            <span>Jalan Nafas</span><br><br>
                            <input type="checkbox"  <?= (isset($data-> question3)?in_array('normal',$data->question3)?'checked':'':'') ?>>
                            <span>Normal</span><br>
                            <input type="checkbox"  <?= (isset($data-> question3)?in_array('mulut_kecil',$data->question3)?'checked':'':'') ?>>
                            <span>Mulut Kecil</span><br>
                            <input type="checkbox"  <?= (isset($data-> question3)?in_array('gigi',$data->question3)?'checked':'':'') ?>>
                            <span>Gigi Prominem</span><br>
                            <input type="checkbox"  <?= (isset($data-> question3)?in_array('dagu',$data->question3)?'checked':'':'') ?>>
                            <span> Dagu Keci</span>
                        </td>
                        <td width="25%"><img   src="<?= isset($data->question4)?$data->question4:''; ?>"  width="200px" height="100px" alt=""></td>
                        <td width="25%">
                                <span>Leher</span><br><br>
                                <input type="checkbox" value="Ureum" <?= (isset($data->question5)?in_array('normal',$data->question5)?'checked':'':'') ?>>
                                <span>Normal </span><br>
                                <input type="checkbox" value="Ureum" <?= (isset($data->question5)?in_array('leher',$data->question5)?'checked':'':'') ?>>
                                <span> Leher Pendek</span><br>
                                <input type="checkbox" value="Ureum" <?= (isset($data->question5)?in_array('gerak',$data->question5)?'checked':'':'') ?>>
                                <span> Gerak Leher Terbatas</span>
                        </td>
                        <td width="25%">
                        <img   src="<?= isset($data->question6)?$data->question6:''; ?>"  width="200px" height="100px" alt="">  
                        </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div style="display:flex">
                                    <div>
                                        <span>Riwayat Alergi</span>
                                    </div>
                                    <div style="margin-left:100px">
                                        <input type="checkbox" value="Ureum" <?php echo isset($data->question7)? $data->question7 == "other" ? "checked":'':'' ?>>
                                        <span> Ya, <?= isset($data->{'question7-Comment'})?$data->{'question7-Comment'}:'' ?></span><br>
                                        <input type="checkbox" value="Ureum" <?php echo isset($data->question7)? $data->question7 == "tidak" ? "checked":'':'' ?>>
                                        <span> Tidak</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display:flex">
                                    <div>
                                        <span>Puasa</span>
                                    </div>
                                    <div style="margin-left:20px">        
                                        <span> Makan: <?= isset($data->question8->text1)?$data->question8->text1:'' ?></span><br>
                                        <span> Minum: <?= isset($data->question8->text2)?$data->question8->text2:'' ?></span>
                                    </div>
                                </div>
                            </td>
                        </tr>
                </table>
                <table width="100%" id="data" border="1">
                    <tr>
                        <td width="30%">
                            <span>IV line </span>
                            <span style="margin-left:20px">Tempat   : <?= isset($data->question9->tempat)?$data->question9->tempat:'' ?></span><br>
                            <span>&nbsp;</span>
                            <span style="margin-left:20px">Cairan     :  <?= isset($data->question9->cairan)?$data->question9->cairan:'' ?> cc/jam</span><br>
                        </td>
                        <td width="30%">
                            <span>Laboratorium/Pemeriksaan Penunjang</span>
                            <p><?= isset($data->question10)?$data->question10:'' ?></p>
                        </td>
                        <td width="20%" colspan="2" style="text-align:center">Tindakan</td>
                    </tr>
                    <tr>
                        <td width="30%">
                            <span>ASA : <?= isset($data->question12)?$data->question12:'' ?></span>
                        </td>
                        <td width="30%">
                            <span>Rencana Sedasi:</span>
                            <p><?= isset($data->question13)?$data->question13:'' ?></p>
                        </td>
                        <td width="20%"  style="text-align:center"><?= isset($data->question11->mulai)?$data->question11->mulai:'' ?></td>
                        <td width="20%"  style="text-align:center"><?= isset($data->question11->selesai)?$data->question11->selesai:'' ?></td>
                    </tr>
                </table>
                <table width="100%" id="data" border="1">
                    <tr>
                        <td colspan="24" style="font-weight:bold;text-align:center">MONITORING SELAMA SEDASI</td>
                    </tr>
                    <tr>
                            <td width="25%">JAM</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->jam)?$data->question24[$x]->question14[0]->jam:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Obat-obatan</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->obat)?$data->question24[$x]->question14[0]->obat:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Pernafasan</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->pernafasan)?$data->question24[$x]->question14[0]->pernafasan:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">O2 (l/menit)</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->o2)?$data->question24[$x]->question14[0]->o2:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">SpO2</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->spO2)?$data->question24[$x]->question14[0]->spO2:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Skala Nyeri</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->skala_nyeri)?$data->question24[$x]->question14[0]->skala_nyeri:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                            <td width="25%">Kesadaran</td>
                            <?php 
                            $jml_array = isset($data->question24)?count($data->question24):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <td width="3%"><?= isset($data->question24[$x]->question14[0]->kesadaran)?$data->question24[$x]->question14[0]->kesadaran:'' ?></td>
                            <?php }
                            
                            if($jml_array<=23){
                            $jml_kurang = 23 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <th width="3%"><?= '' ?></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td colspan="24">
                            <canvas id="chartGrafikPemantauanU0" style="padding-top: 5px; height: 350px;"></canvas>

                            <script type="text/javascript">
                                let chart_jam = <?= json_encode((!empty($gp_jam)) ? $gp_jam  : []) ?>;
                                let tekanan_darah = <?= json_encode((!empty($gp_tekanan_darah)) ? $gp_tekanan_darah  : []) ?>;
                                let nadi = <?= json_encode((!empty($gp_nadi)) ? $gp_nadi : []) ?>;
                                let saturasi = <?= json_encode((!empty($gp_saturasi)) ? $gp_saturasi : []) ?>;
                                let anestesi = <?= json_encode((!empty($gp_anestesi)) ? $gp_anestesi : []) ?>;
                                let operasi = <?= json_encode((!empty($gp_operasi)) ? $gp_operasi : []) ?>;
                                const ctxGPU0 = document.getElementById('chartGrafikPemantauanU0');
                                const chartGrafikPemantauanU0 = new Chart(ctxGPU0, {
                                    data: {
                                        datasets: [{
                                            type: 'line',
                                            label: 'Nadi',
                                            yAxisID: 'y',
                                            data: nadi,
                                            backgroundColor: '#144272',
                                            borderColor: '#607EAA',
                                            datalabels: {
                                                display: true,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#144272'
                                            },
                                            pointStyle: 'circle',
                                            pointRadius: 2,
                                            pointBorderColor: '#144272',
                                            // tension: 0.4
                                        }, {
                                            type: 'line',
                                            label: 'Saturasi',
                                            yAxisID: 'y',
                                            data: saturasi,
                                            backgroundColor: '#89C4E1',
                                            borderColor: '#C1EFFF',
                                            datalabels: {
                                                display: true,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#89C4E1'
                                            },
                                            pointStyle: 'crossRot',
                                            pointRadius: 7,
                                            pointBorderColor: '#89C4E1',
                                            // tension: 0.4
                                        }, {
                                            type: 'line',
                                            label: 'Anestesi',
                                            yAxisID: 'y',
                                            data: anestesi,
                                            datalabels: {
                                                display: false,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#829460'
                                            },
                                            pointStyle: 'crossRot',
                                            pointBorderColor: function(context) {
                                                let getOnlyValbcGPcAnestesi = context.dataset.data;
                                                let arrbcGPcAnestesi = [];
                                                let countbcGPcAnestesi = 0;
                                                for (let bcGPcAnestesi = 0; bcGPcAnestesi < getOnlyValbcGPcAnestesi.length; bcGPcAnestesi++) {
                                                    if (getOnlyValbcGPcAnestesi[bcGPcAnestesi] !== null) {
                                                        ((countbcGPcAnestesi % 2) == 0) ? arrbcGPcAnestesi.push('green'): arrbcGPcAnestesi.push('red');
                                                        countbcGPcAnestesi++;
                                                    } else {
                                                        arrbcGPcAnestesi.push(null);
                                                    }
                                                }
                                                return arrbcGPcAnestesi;
                                            },
                                            pointRadius: 6,
                                            borderWidth: 2,
                                            hoverBorderWidth: 2
                                            // pointBorderColor: '#829460'
                                        }, {
                                            type: 'line',
                                            label: 'Operasi',
                                            yAxisID: 'y',
                                            data: operasi,
                                            datalabels: {
                                                display: false,
                                                align: 'bottom',
                                                font: {
                                                    size: 8,
                                                    weight: 'bold'
                                                },
                                                color: '#252525'
                                            },
                                            pointStyle: 'circle',
                                            pointBorderColor: function(context) {
                                                let getOnlyValbcGPcOperasi = context.dataset.data;
                                                let arrbcGPcOperasi = [];
                                                let countbcGPcOperasi = 0;
                                                for (let bcGPcOperasi = 0; bcGPcOperasi < getOnlyValbcGPcOperasi.length; bcGPcOperasi++) {
                                                    if (getOnlyValbcGPcOperasi[bcGPcOperasi] !== null) {
                                                        ((countbcGPcOperasi % 2) == 0) ? arrbcGPcOperasi.push('green'): arrbcGPcOperasi.push('red');
                                                        countbcGPcOperasi++;
                                                    } else {
                                                        arrbcGPcOperasi.push(null);
                                                    }
                                                }
                                                return arrbcGPcOperasi;
                                            },
                                            pointRadius: 4,
                                            borderWidth: 2,
                                            hoverBorderWidth: 2
                                            // pointBorderColor: '#252525'
                                        }, {
                                            type: 'bar',
                                            label: 'Tekanan Darah',
                                            yAxisID: 'y',
                                            data: tekanan_darah,
                                            backgroundColor: '#FFE6E6',
                                            borderColor: '#EB455F',
                                            borderWidth: 1,
                                            datalabels: {
                                                display: true,
                                                font: {
                                                    size: 9,
                                                    weight: 'bold',
                                                    align: 'center'
                                                }
                                            },
                                            borderSkipped: false
                                        }],
                                        labels: chart_jam
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
                                                },
                                                display: false
                                            }
                                        },
                                        scales: {
                                            xAxes: {
                                                position: 'top',
                                                ticks: {
                                                    // font: {
                                                    //     size: 12
                                                    // },
                                                    autoSkip: false
                                                },
                                                // type: 'realtime',
                                                // realtime: {
                                                //     duration: 20000
                                                // }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                type: 'linear',
                                                position: 'left',
                                                max: 200,
                                                // min: 0,
                                                title: {
                                                    display: true,
                                                    text: 'Tekanan Darah, Nadi & Saturasi',
                                                    color: '#252525',
                                                    font: {
                                                        family: 'Times',
                                                        // size: 10,
                                                        style: 'normal',
                                                        lineHeight: 1.2
                                                    },
                                                    padding: {
                                                        top: 10,
                                                        left: 0,
                                                        right: 0,
                                                        bottom: 0
                                                    },
                                                },
                                                ticks: {
                                                    stepSize: 10,
                                                    font: {
                                                        size: 8
                                                    }
                                                }
                                            }
                                        },
                                    },
                                    plugins: [ChartDataLabels]
                                });
                                let getDataNewGPU0 = function() {
                                    $.ajax({
                                        url: "<?php echo base_url('emedrec/C_emedrec_iri/status_sedasi_grafik_pemantauan_ajax/') . $no_reg ?>",
                                        success: function(data) {
                                            let tesss = 11;
                                            let tmp_newGPU0 = JSON.parse(data);
                                            for (let indGPU0 = 0; indGPU0 < tmp_newGPU0.new_total; indGPU0++) {
                                                chartGrafikPemantauanU0.data.labels.splice(indGPU0, 1, tmp_newGPU0.new_jam[indGPU0]);
                                                chartGrafikPemantauanU0.data.datasets[0].data.splice(indGPU0, 1, tmp_newGPU0.new_nadi[indGPU0]);
                                                chartGrafikPemantauanU0.data.datasets[1].data.splice(indGPU0, 1, tmp_newGPU0.new_oksigen[indGPU0]);
                                                chartGrafikPemantauanU0.data.datasets[2].data.splice(indGPU0, 1, tmp_newGPU0.new_anestesi[indGPU0]);
                                                chartGrafikPemantauanU0.data.datasets[3].data.splice(indGPU0, 1, tmp_newGPU0.new_operasi[indGPU0]);
                                                chartGrafikPemantauanU0.data.datasets[4].data.splice(indGPU0, 1, tmp_newGPU0.new_tekanan_darah[indGPU0]);
                                            }
                                            if (chartGrafikPemantauanU0.data.datasets[0].data.length > tmp_newGPU0.new_total) {
                                                let tmp_col_surplus = chartGrafikPemantauanU0.data.datasets[0].data.length - tmp_newGPU0.new_total;
                                                chartGrafikPemantauanU0.data.labels.splice(tmp_newGPU0.new_total, tmp_col_surplus);
                                                chartGrafikPemantauanU0.data.datasets[0].data.splice(tmp_newGPU0.new_total, tmp_col_surplus);
                                                chartGrafikPemantauanU0.data.datasets[1].data.splice(tmp_newGPU0.new_total, tmp_col_surplus);
                                                chartGrafikPemantauanU0.data.datasets[2].data.splice(tmp_newGPU0.new_total, tmp_col_surplus);
                                                chartGrafikPemantauanU0.data.datasets[3].data.splice(tmp_newGPU0.new_total, tmp_col_surplus);
                                                chartGrafikPemantauanU0.data.datasets[4].data.splice(tmp_newGPU0.new_total, tmp_col_surplus);
                                            }
                                            chartGrafikPemantauanU0.update('none');

                                        }
                                    });
                                    console.log('running');
                                };
                                let int_DataNewGPU0 = setInterval(getDataNewGPU0, 180000);

                                setTimeout(function() {
                                    clearInterval(int_DataNewGPU0);
                                    swalGPTerminated();
                                    console.log('stop');
                                }, 5400000);
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="24">
                            Catatan
                            <p><?= isset($data->catatan)?$data->catatan:'' ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="24" style="text-align:center;font-weight:bold">
                            PENILAIAN PASCA SEDASI
                        </td>
                    </tr>
                </table>
                <table width="100%" id="data" border="1">
                    <tr>
                        <td width="25%" style="text-align:center;vertical-align:middle">Aldrette Score/Steward Score</td>
                        <td width="25%" style="text-align:center;vertical-align:middle"><?= isset($data->question18)?$data->question18:'' ?></td>
                        <td colspan="2">
                            <span>Bukittinggi, <?= isset($sedasi->tgl_input)?date('d-m-y',strtotime($sedasi->tgl_input)):'' ?> jam <?= isset($sedasi->tgl_input)?date('h:i',strtotime($sedasi->tgl_input)):'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="checkbox" value="Ureum" <?php echo isset($data->pulang)? $data->pulang == "pulang" ? "checked":'':'' ?>>
                            <span>Boleh Pulang / Kembali Ke Ruangan </span><br>
                            <input type="checkbox" value="Ureum" <?php echo isset($data->pulang)? $data->pulang == "mrs" ? "checked":'':'' ?>>
                            <span>MRS</span>
                        </td>
                        <td>
                            <center>
                                <span>Dokter Anestesi</span>
                                    
                                        <br><br><br>
                                  
                            
                            </center>
                        </td>
                        <td>
                            <center>
                                <span>Penata Anestesi</span>
                               
                                        <br><br><br>
                                   
                            
                            </center>
                        </td>
                    </tr>
                </table>
            </div><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    <?php } ?>
    </body>
    </html>