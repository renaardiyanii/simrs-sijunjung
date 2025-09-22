<?php
$data = isset($surat_rujukan->formjson)?json_decode($surat_rujukan->formjson):'';
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="70px" width="60px" style="padding-bottom: 4px;">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div>
      
        <center>
            <u><span style="font-size:14px;font-weight:bold;">SURAT RUJUKAN</span></u><br>
            <span style="font-size:10px;">Nomor :  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; /RSUD-SJJ/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; / 20</span>
            
        </center>

        <div style="font-size:12px;">
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;font-size:12px;">
                <tr>
                    <td style="font-size:12px;">Kepada Rumah Sakit</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question1->rumah_sakit)?$data->question1->rumah_sakit:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Alamat Rumah Sakit</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question1->alamat)?$data->question1->alamat:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Bagian</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question1->bagian)?$data->question1->bagian:'' ?></td>
                </tr>
               
            </table>

            <p>
            TS Yth, mohon pemeriksaan dan pengobatan lebih lanjut  </b></i> terhadapat penderita :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="font-size:12px;">Nama</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question2->nama)?$data->question2->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Umur</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question2->umur)?$data->question2->umur:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">No. Kartu</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question2->no_kartu)?$data->question2->no_kartu:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Diagnosa Sementara</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"><?= isset($data->question2->diagnosa)?$data->question2->diagnosa:'' ?></td>
                </tr>
                
            </table>
           
            <p> Atas Pertolongan TS kami ucapkan terima kasih, </b></i> mohon informasi selanjutnya.
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 5px;">
                            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan)?date('d-m-Y',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></p>
                            <p>Dokter Pengirim</p>
                            <?php 
                            $id1 =isset($surat_rujukan->id_pemeriksa)?$surat_rujukan->id_pemeriksa:null;                                    
                            $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                            <br><br>
                            <p style="margin: 10px 0;"> <img width="90px" src="<?= isset($query1->ttd)?$query1->ttd:null;  ?>" alt=""></p>
                            <span>(  <?=  isset($query1->name)?$query1->name:'' ?>  )</span>
                           
                    </div>  
            </div>
        </div>
        <br><br><br><br><br><br><br>
        <center>
            <u><span style="font-size:14px;font-weight:bold;">SURAT RUJUK BALIK</span></u><br>
            <!-- <span style="font-size:12px;">Nomor :  /  /RSUD-SJJ/ / 20</span> -->
            
        </center>
        <div style="font-size:12px;">
            <p>
            TS Yth, dikirimkan kembali penderita  </b></i> untuk tindak lanjut :
            </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="font-size:12px;">Nama</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Umur</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">Diagnosa Akhir</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr> 
            </table>
            <p> Tindak lanjut yang dianjurkan : </p>
            <table style="margin-left: 5px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="font-size:12px;">1. Pengobatan</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">2. Kontrol kembali ke Rumah sakit Tanggal</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">3. Pelayanan / Tindakan yang telah diberikan </td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
            </table>
            <table style="margin-left: 20px; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="font-size:12px;">a. Penunjang Diagnostik</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">b. Tindakan</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
                <tr>
                    <td style="font-size:12px;">c. Perawatan</td>
                    <td style="font-size:12px;"></td>
                    <td style="font-size:12px;">:</td>
                    <td style="font-size:12px;"></td>
                </tr>
            </table>
        
            <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 0px;">
                            <p>Tanah Badantung,</p>
                            <p>Dokter Pengirim</p>
                            <br><br><br>
                            <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</span><br> 
                           
                    </div>  
                </div>
        </div>
    </div>
    

    </body>
</html>