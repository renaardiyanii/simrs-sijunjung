<?php
$data = (isset($surveilans->formjson)?json_decode($surveilans->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 12px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>


            <center><h4>SURVEILANS HAIs</h4></center>
            
            <div style="font-size:12px">
            <p style="font-weight:bold">Cara dirawat	: <?= isset($data->question5)?$data->question5:'' ?></p><hr>
            <span style="font-weight:bold">Tempat Dirawat</span>
            <table width="100%">
                <tr>
                    <td width="25%">Ruang</td>
                    <td width="2%">:</td>
                    <td><?= isset($data->question1->ruang)?$data->question1->ruang:'' ?></td>
                </tr>
                <tr>
                    <td>Tgl</td>
                    <td>:</td>
                    <td><?= isset($data->question1->tgl)?$data->question1->tgl:'' ?></td>
                </tr>
                <tr>
                    <td>Ruang</td>
                    <td>:</td>
                    <td><?= isset($data->question1->ruang1)?$data->question1->ruang1:'' ?></td>
                </tr>
                <tr>
                    <td>Tgl</td>
                    <td>:</td>
                    <td><?= isset($data->question1->tgl1)?$data->question1->tgl1:'' ?></td>
                </tr>
                <tr>
                    <td>Tgl Keluar</td>
                    <td>:</td>
                    <td><?= isset($data->question1->tgl_keluar)?$data->question1->tgl_keluar:'' ?></td>
                </tr>
                <tr>
                    <td>Sebab Keluar</td>
                    <td>:</td>
                    <td><?= isset($data->question1->sebab_keluar)?$data->question1->sebab_keluar:'' ?></td>
                </tr>
                <tr>
                    <td>Diagnosa Akhir</td>
                    <td>:</td>
                    <td><?= isset($data->question1->diagnosa_akhir)?$data->question1->diagnosa_akhir:'' ?></td>
                </tr>
            </table><hr>

            <span style="font-weight:bold">Faktor Risiko : <?= isset($data->question6)?$data->question6:'' ?></span><br>
            <span style="font-weight:bold">Operasi</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>Ahli Bedah : <?= isset($data->question2[0]->ahli_bedah)?$data->question2[0]->ahli_bedah:'' ?></span>&nbsp;&nbsp;&nbsp;
            <span>Scrub Nurse : <?= isset($data->question2[0]->scrub)?$data->question2[0]->scrub:'' ?></span>
            <table width="100%">    
                    <tr>
                        <td width="25%">jenis Operasi</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question2[0]->jenis)?$data->question2[0]->jenis:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tipe Operasi</td>
                        <td>:</td>
                        <td><?= isset($data->question2[0]->tipe_operasi)?$data->question2[0]->tipe_operasi:'' ?></td>
                    </tr>
                    <tr>
                        <td>Jenis Luka</td>
                        <td>:</td>
                        <td><?= isset($data->question2[0]->jenis_luka)?$data->question2[0]->jenis_luka:'' ?></td>
                    </tr>
                    <tr>
                        <td>Laporan Operasi</td>
                        <td>:</td>
                        <td><?= isset($data->question2[0]->laporan)?$data->question2[0]->laporan:'' ?></td>
                    </tr>
                    <tr>
                        <td>ASA Score</td>
                        <td>:</td>
                        <td><?= isset($data->question2[0]->asa)?$data->question2[0]->asa:'' ?></td>
                    </tr>
                    <tr>
                        <td>Risk Resiko	</td>
                        <td>:</td>
                        <td><?= isset($data->question2[0]->resiko)?$data->question2[0]->resiko:'' ?></td>
                    </tr>
            </table><hr>

            <span style="font-weight:bold">Pemasangan Alat</span>

            <table width="100%">
                <tr>
                    <td width="30%">Tanggal Infus Dipasang</td>
                    <td width="2%">:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra_pasang)?$data->pemasangan[0]->intra_pasang:'' ?>&nbsp;&nbsp;&nbsp;
                        <span>BB Lahir : <?= isset($data->pemasangan[0]->bb)?$data->pemasangan[0]->bb:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Infus Dilepas</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra_lepas)?$data->pemasangan[0]->intra_lepas:'' ?>&nbsp;&nbsp;&nbsp;
                        <span>BB Sekarang : <?= isset($data->pemasangan[0]->bb1)?$data->pemasangan[0]->bb1:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal CVL Dipasang</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra2_pasang)?$data->pemasangan[0]->intra2_pasang:'' ?>&nbsp;&nbsp;&nbsp;
                        <span>Status Gizi : <?= isset($data->pemasangan[0]->status_gizi)?$data->pemasangan[0]->status_gizi:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal CVL Dilepas</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra2_lepas)?$data->pemasangan[0]->intra2_lepas:'' ?>&nbsp;&nbsp;&nbsp;
                        <span>Pemakaian Antibiotika : <?= isset($data->pemasangan[0]->antibiotik)?$data->pemasangan[0]->antibiotik:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal UC Dipasang</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra3_pasang)?$data->pemasangan[0]->intra3_pasang:'' ?>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal UC Dilepas</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra3_lepas)?$data->pemasangan[0]->intra3_lepas:'' ?>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal ETT Dipasang</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra4_pasang)?$data->pemasangan[0]->intra4_pasang:'' ?>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal ETT Dilepas</td>
                    <td>:</td>
                    <td>
                        <?= isset($data->pemasangan[0]->intra4_lepas)?$data->pemasangan[0]->intra4_lepas:'' ?>
                    </td>
                </tr>
                <tr>
                    <td>Nama/Jenis Obat</td>
                    <td>:</td>
                    <td><?= isset($data->pemasangan[0]->nama)?$data->pemasangan[0]->nama:'' ?></td>
                </tr>
            </table><hr>

            <table width="100%">
                <tr>
                    <td width="30%" style="font-weight:bold">Pemeriksaan Kultur</td>
                    <td width="2%">:</td>
                    <td>
                        <?= isset($data->question3[0]->pemeriksaan)?$data->question3[0]->pemeriksaan:'' ?>&nbsp;&nbsp;&nbsp;
                        <span>Suhu : <?= isset($data->question3[0]->suhu)?$data->question3[0]->suhu:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>Hasil Kultur</td>
                    <td>:</td>
                    <td><?= isset($data->question3[0]->hasil)?$data->question3[0]->hasil:'' ?></td>
                </tr>
            </table><hr>

            <span style="font-weight:bold">Infeksi HAls Yang Terjadi</span>

            <table width="100%">
                <tr>
                    <td width="30%%">Bakteremia</td>
                    <td width="2%">:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->baktere)?  $data->question4[0]->baktere == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->baktere)?  $data->question4[0]->baktere == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td width="30%%">Sepsis</td>
                    <td width="2%">:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->sepsis)?  $data->question4[0]->sepsis == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->sepsis)?  $data->question4[0]->sepsis == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>VAP</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->vap)?  $data->question4[0]->vap == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->vap)?  $data->question4[0]->vap == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Infeksi Saluran Kemih</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->infeksi)?  $data->question4[0]->infeksi == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->infeksi)?  $data->question4[0]->infeksi == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Infeksi Luka Operasi</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->infeksi1)?  $data->question4[0]->infeksi1 == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->infeksi1)?  $data->question4[0]->infeksi1 == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Plebitis</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->plebitis)?  $data->question4[0]->plebitis == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->plebitis)?  $data->question4[0]->plebitis == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Terjadi Dekubitus</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->dekubitus)?  $data->question4[0]->dekubitus == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->dekubitus)?  $data->question4[0]->dekubitus == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Pasien Tirah Baring</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->tirah_baring)?  $data->question4[0]->tirah_baring == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->tirah_baring)?  $data->question4[0]->tirah_baring == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>:</td>
                    <td><?= isset($data->question4[0]->tirah_baring_mulai)?date("d-m-Y", strtotime($data->question4[0]->tirah_baring_mulai)):null; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Selesai</td>
                    <td>:</td>
                    <td><?= isset($data->question4[0]->tirah_baring_selesai)?date("d-m-Y", strtotime($data->question4[0]->tirah_baring_selesai)):null; ?></td>
                </tr>
                <tr>
                    <td>Pasien ditransfusi</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->transfusi)?  $data->question4[0]->transfusi == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->transfusi)?  $data->question4[0]->transfusi == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Respon</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->respon)?  $data->question4[0]->respon == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->respon)?  $data->question4[0]->respon == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
                <tr>
                    <td>Infeksi Lain</td>
                    <td>:</td>
                    <td><input type="checkbox" value="y" <?php echo isset( $data->question4[0]->lain)?  $data->question4[0]->lain == "y" ? "checked":'':'' ?>>
                        <span> Ya</span>
                        <input type="checkbox" data="t" <?php echo isset( $data->question4[0]->lain)?  $data->question4[0]->lain == "t" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                    </td>
                </tr>
            </table><br>

            </div>
            <br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    </body>
    </html>