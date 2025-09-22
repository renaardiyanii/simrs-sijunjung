<?php 
$data = isset($peng_dekubitus->formjson)?json_decode($peng_dekubitus->formjson):'';
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
                <h2>PENGKAJIAN DECUBITUS</h2>
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
            <td >Halaman 1 dari 1</td>
            
        </tr>
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                    <td style="font-size: 13px;">Tanggal Masuk RS : <?= isset($data->question1)?$data->question1:'' ?></td>
                    <td colspan="2" style="font-size: 13px;">Diagnosa Medik : <?= isset($data->question2)?$data->question2:'' ?></td>
                    <td colspan="2" style="font-size: 13px;">Ruangan : <?= isset($data->question3)?$data->question3:'' ?></td>
                     
        </tr>
       <tr>
        <td colspan="4">
             <p style="font-size: 13px;">Berikan tanda ( √ ) pada setiap kondisi pasien dibawah ini :</p>
             <table border="1" width="100%" cellpadding="1">
                <tr>
                    <td style="padding: 7px; font-size: 10px;">SKOR</td>
                    <td style="padding: 7px; font-size: 10px;">KONDISI<br> UMUM</td>
                    <td style="padding: 7px; font-size: 10px;">(√)</td>
                    <td style="padding: 7px; font-size: 10px;">KONDISI <br>MENTAL</td>
                    <td style="padding: 7px; font-size: 10px;">(√)</td>
                    <td style="padding: 7px; font-size: 10px;">AKTIVITAS</td>
                    <td style="padding: 7px; font-size: 10px;">(√)</td>
                    <td style="padding: 7px; font-size: 10px;">MOBILITAS</td>
                    <td style="padding: 7px; font-size: 10px;">(√)</td>
                    <td style="padding: 7px; font-size: 10px;">INKONTI<br>NENSIA</td>
                    <td style="padding: 7px; font-size: 10px;">(√)</td>
                    <td style="padding: 7px; font-size: 10px;">TOTAL<br> SKOR</td>
                </tr>
                <tr>
                    <td style="padding: 7px; font-size: 10px;">1</td>
                    <td style="padding: 7px; font-size: 10px;">Baik</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column1)? $data->question4[0]->column1 == "1" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Waspada</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column2)? $data->question4[0]->column2 == "1" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Ambulasi baik</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column3)? $data->question4[0]->column3 == "1" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Penuh</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column4)? $data->question4[0]->column4 == "1" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Kontinen</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column5)? $data->question4[0]->column5 == "1" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;"></td>
                </tr>
                <tr>
                    <td style="padding: 7px; font-size: 10px;">2</td>
                    <td style="padding: 7px; font-size: 10px;">Cukup</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column1)? $data->question4[0]->column1 == "2" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Apatis</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column2)? $data->question4[0]->column2 == "2" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Perlu bantuan</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column3)? $data->question4[0]->column3 == "2" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Terbatas</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column4)? $data->question4[0]->column4 == "2" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Kadang <br>inkontinen</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column5)? $data->question4[0]->column5 == "2" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;"></td>
                </tr>
                <tr>
                    <td style="padding: 7px; font-size: 10px;">3</td>
                    <td style="padding: 7px; font-size: 10px;">Lemah</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column1)? $data->question4[0]->column1 == "3" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Bingung</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column2)? $data->question4[0]->column2 == "3" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Tak bisa <br>pindah bed</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column3)? $data->question4[0]->column3 == "3" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Sangan terbatas</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column4)? $data->question4[0]->column4 == "3" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Inkontinen bak</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column5)? $data->question4[0]->column5 == "3" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;"></td>
                </tr>
                <tr>
                    <td style="padding: 7px; font-size: 10px;">4</td>
                    <td style="padding: 7px; font-size: 10px;">Sangat lemah</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column1)? $data->question4[0]->column1 == "4" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Tak sadar</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column2)? $data->question4[0]->column2 == "4" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Tak bergerak</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column3)? $data->question4[0]->column3 == "4" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Imobilisasi</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column4)? $data->question4[0]->column4 == "4" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;">Inkon<br>tinen BAB & BAK</td>
                    <td style="padding: 7px; font-size: 10px;"><?php echo isset($data->question4[0]->column5)? $data->question4[0]->column5 == "4" ? "√":'':'' ?></td>
                    <td style="padding: 7px; font-size: 10px;"><?= isset($data->question4[0]->column6)?$data->question4[0]->column6:'' ?></td>
                </tr>
            </table>
            <p style="font-size: 12px;"><strong>Keterangan</strong></p>
            <p style="font-size: 10px;">5	=	Tidak berisiko </p>
            <p style="font-size: 10px;">6 – 10	=	Risiko sedang </p>
            <p style="font-size: 10px;">11 – 15	=	Risiko tinggi</p>
            <p style="font-size: 10px;">16 – 20	=	Sangat berisiko</p>
            <div style="display: flex; justify-content: space-between; width: 100%;">
               <div style="width: 100%; text-align: right;">
                    <p style="margin: 10px 0;">Tanah Badantuang, <?= isset($data->question5)?date('d-m-Y',strtotime($data->question5)):'' ?> Jam  <?= isset($data->question5)?date('h:i',strtotime($data->question5)):'' ?></p>
                    <?php
                    $id = isset($peng_dekubitus->id_pemeriksa)?$peng_dekubitus->id_pemeriksa:null;                                 
                    $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users  where hmis_users.userid = $id")->row():null;

                    ?>
                    <p style="margin: 8px 0;">Pengkaji</p>
                    <p style="margin: 10px 0;"><img width="50px" src="<?= $query->ttd ?>" alt=""></p>
                     <p style="margin: 10px 0;"><?= isset($query->name)?$query->name:'' ?></p>
                </div>
            </div>
            <p style="font-size: 14px;"><strong>Penatalaksanaan Sesuai Derajat Risiko Decubitus</strong></p>
            <table border="1" width="100%" cellpadding="0";>
                <tr>
                    <td style="padding: 8px; text-align: center; font-size: 11px;"><strong>DERAJAT RESIKO</strong></td>
                    <td style="padding: 8px; text-align: center; font-size: 11px;"><strong>PENATALAKSANAAN</strong></td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;" rowspan="2" >Tidak Berisiko</td>
                    <td style="padding: 8px; font-size: 10px;">1. Kaji kembali setiap minggu</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">2. Kaji kembali jika ada perubahan kondisi signifikan</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;" rowspan="6">Risiko Sedang</td>
                    <td style="padding: 8px; font-size: 10px;">1. Laksanakan perubahan posisi secara berkala</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">2. KIE pasien dan keluarga untuk melaksanakan perubahan posisi 4 jam</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">3. Berikan mobilisasi maksimal</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">4. Amankan tumit</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">5. Manajemen kelembaban kulit, nutrisi adekuat serta resiko gesekan kulit</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">6. Jika memungkinkan kurangi tekanan pada bagian tubuh yang berisiko tertekan dengan alas yang lembut</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;" rowspan="6">Risiko Tinggi</td>
                    <td style="padding: 8px; font-size: 10px;">1.  Buat jadwal tertulis miring kanan dan miring kiri (perubahan posisi)</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">2.  Gunakan alas yang lembut atau bantal pada area tertekan</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">3.  KIE pasien dan keluarga untuk melaksanakan perubahan posisi 2 jam</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">4. Berikan mobilisasi maksimal</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">5.  Amankan tumit</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">6. Manejem kelembaban kulit, nutrisi adekuat serta resiko gesekan kulit.</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-size: 10px;">Sangat Berisiko</td>
                    <td style="padding: 8px; font-size: 10px;">Semua yang tertulis pada resiko tinggi + gunakan alas untuk mengurangi tekanan (kasur angin) + protein yang adekuat </td>
                
                </tr>
               
            </table>

       </tr>
       
    </table>
                <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.06.k/RI 
                    </div>
               </div>
    </div>
  
</body>

</html>