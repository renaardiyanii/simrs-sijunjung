<?php 
$data = isset($keselamatan_ok->formjson)?json_decode($keselamatan_ok->formjson):'';
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
                <h2>CHECK LIST  KESELAMATAN <br>PASIEN KAMAR OPERASI</h2>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 1</td>
            
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
            <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
                <tr>
                    <th style="padding: 10px;">Sebelum Induksi Anestesi <br><i>(Sign In)</i></th>
                    <th style="padding: 10px;">Sebelum Insisi <br><i>(Time Out)</i></th>
                    <th style="padding: 10px;">Sebelum Pasien Meninggalkan Ruang Operasi <br><i>(Sign Out)</i></th>
                </tr>
                <tr>
                    <td style="padding: 10px; vertical-align: top;">
                        <p>Tanggal :........</p>
                        <b>Minimal ada Perawat dan dr. Anestesi</b>
                        <br><br>
                        1. Apakah  identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada persetujuan  tindakan medis  yang akan dilakukan (Inform Concern) ?                        <br>
                        <input type="checkbox" <?php echo isset($data->question1)? $data->question1 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question1)? $data->question1 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        2. Apakah area yang akan dioperasi sudah diberi tanda?<br>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        3. Apakah mesin anestesi dan obat sudah lengkap?<br>
                        <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        4. Apakah profilaksis antibiotik sudah diberikan 1 jam sebelumnya?<br>
                        <input type="checkbox" <?php echo isset($data->question5)? $data->question5 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question5)? $data->question5 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        5. Apakah pasien memiliki  riwayat alergi?<br>
                        <input type="checkbox" <?php echo isset($data->question6)? $data->question6 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question6)? $data->question6 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        6. Apaka pasien memiliki gangguan pernapasan ?<br>
                        <input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question7)? $data->question7 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        7. Resiko perdarahan  > 500 ml (7ml/kg bagi pasien anak) <br>
                        <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question8)? $data->question8 == "other" ? "checked":'':'' ?>> Ya<br><br>
                    </td>
                    <td style="padding: 10px; vertical-align: top;">
                        <p>Tanggal :..................</p>
                        <b>Dengan Perawat, dr. Anestesi dan dr. Bedah</b>
                        <br>
                        1. Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri (nama & peran ) <br>
                        <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        2.  Memastikan dan membaca ulang nama pasien, tindakan medis dan area yang akan diinsisi .<br>
                        <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question11)? $data->question11 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        3. Apakah pasien sudah memakai pulse oksimetri dan sudah berfungsi baik?<br>
                        <input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        <b>Kejadian berisiko yang perlu<br> diantisipasi untuk dr. Bedah :</b>
                        <br>
                        1. Apakah tindakan beresiko atau tindakan tidak rutin yang akan dilakukan.<br>
                        <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        2. Berapa lama tindakan  ini akan dikerjakan <?= isset($data->question14)?$data->question14:'' ?><br>
                        <br><br>
                         3. Apakah sudah diantisipasi perdarahan.<br>
                        <input type="checkbox"> Tidak
                        <input type="checkbox"> Ya<br>
                        <b>Untuk Tim dr . Anestesi :</b>
                        <br><br>
                        Apakah ada hal khusus untuk pasien in <?= isset($data->question19)?$data->question19:'' ?><br>
                        
                        <b>Untuk Tim Perawat :</b>
                        1. Apakah ada masalah dengan peralatan atau masalah alat yang dikhawatirkan?<br>
                        <input type="checkbox" <?php echo isset($data->question15)? $data->question15 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question15)? $data->question15 == "item1" ? "checked":'':'' ?>> Ya<br><br>
                        2. Apakah hasil radiologi yang di perlukan sudah ada? 
                        <br>
                        <input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item2" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item3" ? "checked":'':'' ?>> Ya<br><br>
                        
                    </td>
                    <td style="padding: 10px; vertical-align: top;">
                        <p>Tanggal :.............</p>
                        <b>Dengan Perawat, dr. Anestesi dan dr. Bedah </b>
                        <br><br>
                        1. Secara verbal perawat memastikan nama tindakan.<br>
                        <input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item1" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item2" ? "checked":'':'' ?>> Ya<br><br>
                        2. Kelengkapan alat, jumlah kasa dan jarum/alat lain  .<br>
                        <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>> Ya<br><br>
                        3. Pelabelan spesimen (baca label spesimen dan nama pasien dengan keras)<br>
                        <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item1" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item2" ? "checked":'':'' ?>> Ya<br><br>
                        4. Apakah ada masalah dengan peralatan yang perlu disampaikan ?<br>
                        <input type="checkbox" <?php echo isset($data->question33)? $data->question33 == "item1" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question33)? $data->question33 == "item2" ? "checked":'':'' ?>> Ya<br><br>
                        <b>Untuk dr. Bedah, dr . Anestesi dan Perawat  : </b>
                        <br><br>
                        Apakah ada catatan khusus untuk proses pemulihan dan penanganan perawatan pasien ?<br>
                        <input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item1" ? "checked":'':'' ?>> Tidak
                        <input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item2" ? "checked":'':'' ?>> Ya<br><br>
                    </td>
                </tr>
            </table>
            <table border="1" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 12px;">
                    <tr>
                        <th style="padding: 4px;">TIM</th>
                        <th style="padding: 4px;">Nama</th>
                        <th style="padding: 4px;">Tanda <br>tangan</th>
                        <th style="padding: 4px;">TIM</th>
                        <th style="padding: 4px;">Nama</th>
                        <th style="padding: 4px;">Tanda <br>tangan</th>
                        <th style="padding: 4px;">TIM</th>
                        <th style="padding: 4px;">Nama</th>
                        <th style="padding: 4px;">Tanda <br>tangan</th>
                        
                    </tr>
                    <tr>
                        <td rowspan="3">Dr. Anestesi <br>/ Perawat <br>Anestesi</td>
                        <td rowspan="3"></td>
                        <td rowspan="3"></td>
                        <td rowspan="3">Perawat OK</td>
                        <td rowspan="3"></td>
                        <td rowspan="3"></td>
                        <td>Operator</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Perawat OK</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Dr. anestesi <br>perawat<br>anestesi</td>
                        <td></td>
                        <td></td>
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
                Rev.I.I/2018/RM.18.d/RI 
                   
               </div>
    </div>
  
</body>

</html>