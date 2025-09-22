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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PATOLOGI ANATOMI<br></h3>
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
            <td style="font-size:13px" colspan="2">(Diisi oleh Dokter)</td>
            <td style="font-size:13px">Halaman 1 dari 1</td>
        </tr>
    
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
      
        <tr>
            <td colspan="4">
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td colspan="2">Tanggal Diterima: </td>
                        <td>Jam:</td>
                    </tr>
                    <tr>
                        <td>Nama dokter <br>Physician'a<br>name</td>
                        <td  width="30%">:</td>
                        <td>Status : <input type="checkbox">Kawin <input type="checkbox">Belum kawin <input type="checkbox">Janda <input type="checkbox">Duda</td>
                    </tr>
                    <tr>
                        <td>Rumah Sakit<br>Hospital</td>
                        <td  width="30%">:</td>
                        <td>Jumlah anak :</td>
                    </tr>
                    <tr>
                        <td>Bagian<br>Departemen</td>
                        <td  width="30%">:</td>
                        <td>Alamat :</td>
                    </tr>
                    <tr>
                        <td>Di<br>City</td>
                        <td  width="30%">:</td>
                        <td>Nomor P :</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td>Tgl Mensis Terakhir :</td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="padding-bottom: 30px;">Hasil Laboratorium: <br>Laboratory Findings</td>
                        <td rowspan="2" style="padding-bottom: 30px;">Pemeriksaan Radiologi <br>Radiological Examination</td>
                        <td style="padding-bottom: 30px;">Pemeriksaan Terdahulu <br> Examination Date</td>
                    </tr>
                    <tr>
                        <td style="padding-bottom: 30px;">No Sample :</td>
                    </tr>
                    <tr>
                        <td>Jaringan tubuh di dapat dengan :</td>
                        <td  width="30%"> <input type="checkbox">Eksis percobaan<input type="checkbox">kerokan <br><input type="checkbox">operasi <input type="checkbox">seksi</td>
                        <td style="padding-bottom: 30px;" rowspan="3">Pengobatan yang diberikan : <br>Civen Therapy</td>
                    </tr>
                    <tr>
                        <td>Lokasi jaringan yang diambil :</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Cairan Fiksasi :</td>
                        <td>Formalin 10% alkohol absolut</td>
                    </tr>
                    <tr>
                        <td colspan="3">Diagnosa klinik :<br>Clinical diagnosis 
                    </tr>
                    <tr>
                        <td colspan="3">Keterangan klinik :<br>Clinical data 
                    </tr>
                    <tr>
                        <td colspan="3">Sketsa lokalisasi :<br>Outime of location
                    </tr>
                </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang,............20</p>
                                <p style="margin: 5px 0;">Dokter yang merawat</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;">(.................)</p>
                            </div>
                        </div>
            </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.19.d/RI
                    </div>
               </div>
    </div>
</div>
</body>