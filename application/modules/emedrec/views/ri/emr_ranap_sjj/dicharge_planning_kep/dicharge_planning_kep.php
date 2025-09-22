<?php 
$data = isset($dicharge_planning->formjson)?json_decode($dicharge_planning->formjson):'';
// var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>RENCANA PEMULANGAN PASIEN <br>(DISCHARGE PLANNING) </h3>
            </center>
            
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 2</td>
            
        </tr>
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
            <td style="font-size: 13px;">Diagnosis Medis: <?= isset($data->question12)?$data->question12:'' ?></td>
            <td colspan="2" style="font-size: 13px;">Ruangan : <?= isset($data->question13)?$data->question13:'' ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2"><B>SAAT MASUK RUMAH SAKIT</B></td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2">Tanggal / Jam Masuk RS : <?= isset($data->tanggal_perencanaan_pemulangan)?date('d-m-Y h:i',strtotime($data->tanggal_perencanaan_pemulangan)):'' ?> </td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2">Alasan Masuk RS : <?= isset($data->question11)?$data->question11:'' ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2">Tanggal / jam dilakukan Perencanaan Pemulangan Pasien (Discharge Planning) : <?= isset($data->estimasi_tanggal)?date('d-m-Y h:i',strtotime($data->estimasi_tanggal)):'' ?>  </td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2">Estimasi tanggal pemulangan pasien : <?= isset($data->question4)?date('d-m-Y',strtotime($data->question4)):'' ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2">Nama Perawat : <?= isset($data->question14)?$data->question14:'' ?></td>
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="2"><center><b>KETERANGAN RENCANA PEMULANGAN</b></center></td>
        </tr>
       <tr>
        <td colspan="4">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">FASE</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">KEGIATAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="4">PELAKSANA</th>
                        
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="2">DILAKUKAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;"  colspan="2">TIDAK DILAKUKAN</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" ></th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" ></th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >TGL</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >PETUGAS</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >EVALUASI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >ALASAN</th>
                    </tr>
                  <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;" rowspan="10">Tahap I <br>Pasien masuk <br>(dilengkapi <br> oleh perawat <br>dalam 2x24 jam)</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">1. Pengkajian fisik dan psikososi</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item1->column1)?date('d-m-Y',strtotime($data->question1->item1->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item1->column2)?$data->question1->item1->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item1->column3)?$data->question1->item1->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item1->column4)?$data->question1->item1->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">2. Pengkajian status fungsional</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item2->column1)?date('d-m-Y',strtotime($data->question1->item2->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item2->column2)?$data->question1->item2->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item2->column3)?$data->question1->item2->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item2->column4)?$data->question1->item2->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">3. Pengkajian kebutuhan pendidikan kesehatan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item3->column1)?date('d-m-Y',strtotime($data->question1->item3->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item3->column2)?$data->question1->item3->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item3->column3)?$data->question1->item3->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item3->column4)?$data->question1->item3->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">a. Proses Penyakit</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item4->column1)?date('d-m-Y',strtotime($data->question1->item4->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item4->column2)?$data->question1->item4->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item4->column3)?$data->question1->item4->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item4->column4)?$data->question1->item4->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">b. Obat-obatan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item5->column1)?date('d-m-Y',strtotime($data->question1->item5->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item5->column2)?$data->question1->item5->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item5->column3)?$data->question1->item5->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item5->column4)?$data->question1->item5->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">c. Prosedur, cara perawatan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item6->column1)?date('d-m-Y',strtotime($data->question1->item6->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item6->column2)?$data->question1->item6->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item6->column3)?$data->question1->item6->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item6->column4)?$data->question1->item6->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">d. Pencegahan faktor risiko</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item7->column1)?date('d-m-Y',strtotime($data->question1->item7->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item7->column2)?$data->question1->item7->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item7->column3)?$data->question1->item7->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item7->column4)?$data->question1->item7->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">e. Lingkungan yang perlu dipersiapkan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item8->column1)?date('d-m-Y',strtotime($data->question1->item8->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item8->column2)?$data->question1->item8->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item8->column3)?$data->question1->item8->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item8->column4)?$data->question1->item8->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">f. Rencana tindak lanjut</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item9->column1)?date('d-m-Y',strtotime($data->question1->item9->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item9->column2)?$data->question1->item9->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item9->column3)?$data->question1->item9->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item9->column4)?$data->question1->item9->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">4. Pengkajian pemahanan pasien/keluarga terhadap penjelasan yang diberikan tim kesehatan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item10->column1)?date('d-m-Y',strtotime($data->question1->item10->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item10->column2)?$data->question1->item10->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item10->column3)?$data->question1->item10->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question1->item10->column4)?$data->question1->item10->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;" rowspan="10">Tahap I<br>Pasien masuk <br>(dilengkapi oleh<br> perawat dalam <br>2x24 jam)</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">5. Diskusi tentang proses penyakit : <br> a. Pengertian, penyebab, tanda dan gejala</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item11->column1)?date('d-m-Y',strtotime($data->question8->item11->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item11->column2)?$data->question8->item11->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item11->column3)?$data->question8->item11->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item11->column4)?$data->question8->item11->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">b. Faktor risiko</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item12->column1)?date('d-m-Y',strtotime($data->question8->item12->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item12->column2)?$data->question8->item12->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item12->column3)?$data->question8->item12->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item12->column4)?$data->question8->item12->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">c. komplikasi</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item13->column1)?date('d-m-Y',strtotime($data->question8->item13->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item13->column2)?$data->question8->item13->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item13->column3)?$data->question8->item13->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item13->column4)?$data->question8->item13->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">6. Diskusi tentang  Obat-obatan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item14->column1)?date('d-m-Y',strtotime($data->question8->item14->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item14->column2)?$data->question8->item14->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item14->column3)?$data->question8->item14->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item14->column4)?$data->question8->item14->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">7. Diskusi tentang  Pemeriksaan Diagnostik</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item15->column1)?date('d-m-Y',strtotime($data->question8->item15->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item15->column2)?$data->question8->item15->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item15->column3)?$data->question8->item15->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item15->column4)?$data->question8->item15->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">8. Diskusi tentang  Rehabilitasi</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item16->column1)?date('d-m-Y',strtotime($data->question8->item16->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item16->column2)?$data->question8->item16->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item16->column3)?$data->question8->item16->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item16->column4)?$data->question8->item16->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">9. Diskusi tentang  Perawatan kebersihan diri, <br>perubahan posisi, pencegahan jatuh, manajemen nyeri,<br> latihan ROM dan teknik relaksasi</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item17->column1)?date('d-m-Y',strtotime($data->question8->item17->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item17->column2)?$data->question8->item17->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item17->column3)?$data->question8->item17->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question8->item17->column4)?$data->question8->item17->column4:'' ?></td>
                </tr>
                </table>
        </td>
       </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.20.b/RI 
                    </div>
               </div>
    </div>
  
    <!-- halaman 2 -->
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
            <h3>RENCANA PEMULANGAN PASIEN <br>(DISCHARGE PLANNING) </h3>
            </center>
            
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        <tr>
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 2 dari 2</td>
            
        </tr>
        <tr>
            <td style="font-size: 13px;" colspan="3"><center><b>KETERANGAN RENCANA PEMULANGAN</b></center></td>
        </tr>
        <td colspan="4">
                <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">FASE</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="2">KEGIATAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="4">PELAKSANA</th>
                        
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="2">DILAKUKAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;"  colspan="2">TIDAK DILAKUKAN</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" ></th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" ></th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >TGL</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >PETUGAS</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >EVALUASI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >ALASAN</th>
                    </tr>
                  <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;" rowspan="6">Tahap I <br>Pasien masuk <br>(dilengkapi <br> oleh perawat <br>dalam 2x24 jam)</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">10. Edukasi pengaturan diet (sesuai faktor risiko)</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item18->column1)?date('d-m-Y',strtotime($data->question9->item18->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item18->column2)?$data->question9->item18->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item18->column3)?$data->question9->item18->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item18->column4)?$data->question9->item18->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">11. Edukasi tentang modifikasi gaya hidup <br>a.Aktifitas Fisik <br>b.Merokok <br>c.Penggunaan Alkohol dan Obat-obatan</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item19->column1)?date('d-m-Y',strtotime($data->question9->item19->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item19->column2)?$data->question9->item19->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item19->column3)?$data->question9->item19->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item19->column4)?$data->question9->item19->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">12. Edukasi tentang modifikasi lingkungan pasien setelah pulang dari rumah sakit</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item22->column1)?date('d-m-Y',strtotime($data->question9->item22->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item22->column2)?$data->question9->item22->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item22->column3)?$data->question9->item22->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item22->column4)?$data->question9->item22->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">13. Edukasi tentang modifikasi gaya hidup <br>a. Kebutuhan dasar <br>b. Jadwal kontrol </td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item23->column1)?date('d-m-Y',strtotime($data->question9->item23->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item23->column2)?$data->question9->item23->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item23->column3)?$data->question9->item23->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question9->item23->column4)?$data->question9->item23->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">14. Diskusi tentang pengawasan pada pasien setelah pulang tentang obat, diet, aktifitas dan peningkatan status fungsional</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item25->column1)?date('d-m-Y',strtotime($data->question10->item25->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item25->column2)?$data->question10->item25->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item25->column3)?$data->question10->item25->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item25->column4)?$data->question10->item25->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;">15. Diskusi tentang sistem dukungan keluarga, finansial, dan alat/transportasi yang akan digunakan pasien</td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item26->column1)?date('d-m-Y',strtotime($data->question10->item26->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item26->column2)?$data->question10->item26->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item26->column3)?$data->question10->item26->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question10->item26->column4)?$data->question10->item26->column4:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;" colspan="7"><center><b></b></center></td>
                 </tr>
                 <table style="width: 100%; border-collapse: collapse; font-size: 12px;">
                    <tr>
                        
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" rowspan="3">CATATAN PULANG</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="3">PELAKSANA</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >KETERANGAN</th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" colspan="2">SUDAH DIBERIKAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >BELUM DIBERIKAN</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" ></th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >TGL</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >PETUGAS</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" >EVALUASI</th>
                        <th style="border: 1px solid black; text-align: center; padding: 5px;" ></th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">1. Resep/Obat-obatan pulang</td>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item1->column1)?date('d-m-Y',strtotime($data->question2->item1->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item1->column2)?$data->question2->item1->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item1->column3)?$data->question2->item1->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item1->column4)?$data->question2->item1->column4:'' ?></td>
                   
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">2. Surat kontrol</td>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item2->column1)?date('d-m-Y',strtotime($data->question2->item2->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item2->column2)?$data->question2->item2->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item2->column3)?$data->question2->item2->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item2->column4)?$data->question2->item2->column4:'' ?></td>
                   
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">3. Rujukan Rehabilitas</td>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item3->column1)?date('d-m-Y',strtotime($data->question2->item3->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item3->column2)?$data->question2->item3->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item3->column3)?$data->question2->item3->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item3->column4)?$data->question2->item3->column4:'' ?></td>
                   
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;">4. Leaflet/Informasi <br> Kesehatan (bila ada)</td>
                        <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item4->column1)?date('d-m-Y',strtotime($data->question2->item4->column1)):'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item4->column2)?$data->question2->item4->column2:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item4->column3)?$data->question2->item4->column3:'' ?></td>
                    <td style="border: 1px solid black; text-align: left; padding: 5px;"><?= isset($data->question2->item4->column4)?$data->question2->item4->column4:'' ?></td>
                   
                    </tr>
                 </table>
                 <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 30px 0;">Perawat </p>
                                <p style="margin: 30px 0;"><img src="<?= isset($data->question3)?$data->question3:'' ?>" alt="img" height="50px" width="50px"></p>
                                <p style="margin: 30px 0;"><?= isset($data->question5)?$data->question5:'' ?></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 30px 0;">Pasien / Keluarga / Pelaku Rawat</p>
                                <p style="margin: 30px 0;"><img src="<?= isset($data->question6)?$data->question6:'' ?>" alt="img" height="50px" width="50px"></p>
                                <p style="margin: 30px 0;"><?= isset($data->question7)?$data->question7:'' ?></p>
                            </div>
                        </div>
            </table>
           
        </td>
    </table>
    <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.20.b/RI 
                    </div>
               </div>
    </div>
</body>

</html>