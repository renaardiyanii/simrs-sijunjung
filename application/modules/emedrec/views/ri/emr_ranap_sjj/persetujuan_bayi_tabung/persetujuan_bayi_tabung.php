<?php 
$data = isset($pengantar_ranap->formjson)?json_decode($pengantar_ranap->formjson):'';
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PERSETUJUAN BAYI TABUNG</h3>
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
            <td colspan="2">(Diisi oleh Petugas)</td>
            <td >Halaman 1 dari 1</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="40%" >Ruang / Poli :</td>
                    <td width="60%" > :</td>
                    
                </tr>
                <tr>
                    <td width="40%" >Diagnosa Klinis :</td>
                    <td width="60%" > :</td>
                    
                </tr>
                <tr>
                    <td width="40%" >Rencana Tindakan    :</td>
                    <td width="60%" > :</td>
                    
                </tr>
            </table>
            <p style="font-size: 14px;"><strong>ISI INFORMASI </strong></p>
            <table border="1" width="100%" cellpadding="2">
                <tr>
                    <td rowspan="2"><b><center>NO</center></b></td>
                    <td rowspan="2"><b><center>PENJELASAN PROGRAM BAYI TABUNG</center></b></td>
                    <td rowspan="2"><b><center>JELAS</center></b></td>
                    <td colspan="2"><b><center>TANDA TANGAN & NAMA</center></b></td>
                </tr>
                <tr>
                    <td><b><center>PEMBERI INFORMASI</center></b></td>
                    <td><b><center>PENERIMA INFORMASI</center></b></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Pengertian Bayi Tabung</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Pengertian Simpan Beku Embrio</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Pengertian Simpan Beku Sperma</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Pengertian Pencairan Embrio</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Pengertian Pencairan Sperma</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Diagnosa dan Indikasi tondakan</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Komplikasi dan Prognosis</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Alternatif / Risiko</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <p style="font-size: 14px;"><strong>JENIS TINDAKAN</strong></p>
            <p style="font-size: 12px;"><input type="checkbox">Ovum Pick Up <input type="checkbox"> Simpan Beku Embrio <input type="checkbox"> Simpan Beku Sperma </p>
            <p> <input type="checkbox"> Embrio Transfer <input type="checkbox"> Pencairan Embrio <input type="checkbox"> Pencairan Sperma </p>
            <p style="font-size: 12px;">Yang bertanda tangan dibawah ini saya sebagai suami dari nama pasien tersebut diatas :</p>
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="40%" >1. Nama :</td>
                    <td width="60%" >3. Pekerjaan </td>
                </tr>
                <tr>
                    <td width="40%" >2. No KTP :</td>
                    <td width="60%" >4. Alamat :</td>
                </tr>
            </table>
            <p style="font-size: 14px;"><strong>PERSETUJUAN</strong></p>
            <p style="font-size: 12px; line-height: 1.6; margin-bottom: 10px;">
                Setelah mendapatkan penjelasan dan diskusi mengenai Teknologi Reproduksi Berbantu (Bayi Tabung), maka dengan ini saya mengerti dan memahami untuk dilakukan tindakan tersebut di atas.   Kami <b>MENYETUJUI</b> tindakan tersebut.
            </p>
            <p style="font-size: 14px;">...........................................................................................................................................</p><br><br>
            <p style="font-size: 12px; line-height: 1.6; margin-bottom: 10px;">terhadap kami, dan kami bertanggung jawab atas segala risiko dan komplikasi yang mungkin terjadi.</p>
            <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                               
                                <p style="margin: 5px 0;">Istri</p>
                                <p style="margin: 5px 0;">...............................</p>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanah badantuang,..........................</p>
                                <p style="margin: 5px 0;">Dokter</p>
                                <p style="margin: 5px 0;">...............................</p>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>
                        </div><br><br><br><br><br><br><br><br>
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Suami</p>
                                <p style="margin: 5px 0;">...............................</p>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Saksi</p>
                                <p style="margin: 5px 0;">...............................</p>
                                <p style="margin: 5px 0;">Nama lengkap</p>
                            </div>
                        </div>
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:570px; font-size:12px;">
                Rev.I.I/2018/RM.17.b6/RI-GN
                    </div>
               </div>
    </div>
</div>
</body>

</html>