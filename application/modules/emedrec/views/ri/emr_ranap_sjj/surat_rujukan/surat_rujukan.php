<?php 
$data = isset($sur_rujukan->formjson)?json_decode($sur_rujukan->formjson):'';
// var_dump($data);die;
?>
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
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <h3><center>SURAT RUJUKAN</center></h3>
                <h4><center>Nomor :<?= isset($data->question1->text1)?$data->question1->text1:'' ?></center></h4>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Kepada Rumah Sakit </td>
                        <td width="70%">: <?= isset($data->question1->rumah_sakit)?$data->question1->rumah_sakit:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat Rumah Sakit </td>
                        <td width="70%">: <?= isset($data->question1->alamat)?$data->question1->alamat:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Bagian</td>
                        <td width="70%">: <?= isset($data->question1->bagian)?$data->question1->bagian:'' ?></td>
                    </tr>
                </table>
                <p>TS Yth, mohon pemeriksaan dan pengobatan lebih lanjut terhadap penderita</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Nama</td>
                        <td width="70%">: <?= isset($data->question2->nama)?$data->question2->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Umur</td>
                        <td width="70%">: <?= isset($data->question2->umur)?$data->question2->umur:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Nomor kartu</td>
                        <td width="70%">: <?= isset($data->question2->no_kartu)?$data->question2->no_kartu:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Diagnosa sementara</td>
                        <td width="70%">: <?= isset($data->question2->diagnosa)?$data->question2->diagnosa:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Catatan</td>
                        <td width="70%">: <?= isset($data->question7)?$data->question7:'' ?></td>
                    </tr>
                </table>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                       <div style="width: 100%; text-align: right;">
                            <p><br></p>
                               <p style="margin: 5px 0;">Tanah badantuang, <?= isset($data->question4)?date('d-m-Y',strtotime($data->question4)):'' ?> </p>
                               <p>Dokter Pengirim</p>
                                 <?php
                                        $id_dokter = isset($data->question5) ? $data->question5 : null;
                                        $id_dokter1 = null;
                                        $dokter = null;

                                        // Pastikan $id_dokter adalah string dulu
                                        if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                            $parts = explode('-', $id_dokter);
                                            if (isset($parts[1])) {
                                                $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                                if (!empty($id_dokter1)) {
                                                    $query = $this->db->query("SELECT a.name, a.ttd 
                                                        FROM hmis_users a
                                                        JOIN dyn_user_dokter b ON a.userid = b.userid
                                                        WHERE b.id_dokter = '$id_dokter1'");
                                                    $dokter = $query->row();
                                                }
                                            }
                                        }
                                        ?>

                                  <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                                   <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                            </div> 
                </div>
                <h3><center>SURAT RUJUKAN BALIK</center></h3>
                <p>TS Yth, dikirimkan kembali penderita untuk tindak lanjut :</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Nama</td>
                        <td width="70%">:  <?= isset($data->question8->nama)?$data->question8->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Umur</td>
                        <td width="70%">: <?= isset($data->question8->umur)?$data->question8->umur:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">Diagnosa akhir</td>
                        <td width="70%">: <?= isset($data->question8->diagnosa)?$data->question8->diagnosa:'' ?></td>
                    </tr>
                </table>
                <p>Tindak lanjut yang dianjurkan</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">1. Pengobatan</td>
                        <td width="70%">: <?= isset($data->question9->nama)?$data->question9->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="30%">2. Kontrol kembali ke Rumah Sakit tanggal </td>
                        <td width="70%">: <?= isset($data->question9->umur)?$data->question9->umur:'' ?></td>
                    </tr>
                </table>
                <p>3. Pelayanan / Tindakan yang telah diberikan : <?= isset($data->question9->diagnosa)?$data->question9->diagnosa:'' ?></p>
                <p>a. Penunjang Diagnostik : <?= isset($data->question9->text1)?$data->question9->text1:'' ?></p>
                <p>b. Tindakan : <?= isset($data->question9->text2)?$data->question9->text2:'' ?></p>
                <p>c.Perawatan : <?= isset($data->question9->text3)?$data->question9->text3:'' ?></p>
                        <div style="width: 100%; text-align: right;">
                            <p><br></p>
                               <p style="margin: 5px 0;">Tanah badantuang, <?= isset($data->question11)?date('d-m-Y',strtotime($data->question11)):'' ?> </p>
                               <p>Dokter Pengirim</p>
                                 <?php
                                        $id_dokter = isset($data->question6) ? $data->question6 : null;
                                        $id_dokter1 = null;
                                        $dokter = null;

                                        // Pastikan $id_dokter adalah string dulu
                                        if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                                            $parts = explode('-', $id_dokter);
                                            if (isset($parts[1])) {
                                                $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                                if (!empty($id_dokter1)) {
                                                    $query = $this->db->query("SELECT a.name, a.ttd 
                                                        FROM hmis_users a
                                                        JOIN dyn_user_dokter b ON a.userid = b.userid
                                                        WHERE b.id_dokter = '$id_dokter1'");
                                                    $dokter = $query->row();
                                                }
                                            }
                                        }
                                        ?>

                                  <p><img width="40px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                                   <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
                            </div> 
            </td>
       </tr>
    </table>
    </div>
</body>