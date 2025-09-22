<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4" style="font-family: Arial, sans-serif; margin: 20px;">
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
            <h2 style="text-align: center; text-decoration: underline;">PERMINTAAN PRIVASI</h2>
    
            <p style="font-size: 16px;">(diisi oleh pasien/keluarga)</p>
    
            <p style="font-size: 16px;">Nama Lengkap Pasien : .................................................................. No. RM : .........................</p>
            
            <p style="font-size: 16px;">Yang bertandatangan di bawah ini saya :</p>
            <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td width="30%">Nama </td>
                    <td width="70%">:</td>
                </tr>
                <tr>
                    <td width="30%">Alamat </td>
                    <td width="70%">:</td>
                </tr>
                <tr>
                    <td width="30%">No. Telp/Hp </td>
                    <td width="70%">:</td>
                </tr>
            </table>
            <p style="font-size: 16px;">Hubungan dengan pasien : diri sendiri / orang tua / anak / wali *</p>
            
            <ol>
                <li style="font-size: 16px;">
                    Dengan ini menyatakan bahwa (saya / orang tua / anak / wali *) mengizinkan/tidak mengizinkan* RSUD Sijunjung memberikan akses bagi keluarga yang bernama 
                    ......................... dan kerabat yang bernama 
                    ......................... serta orang lain yang bernama 
                    ......................... yang menengok/menemui saya.
                </li><br><br>
                <li style="font-size: 16px;">
                    Saya mengizinkan / tidak mengizinkan* privasi khusus *:
                    <ul>
                        <li style="font-size: 16px;">a. Pada saat wawancara klinis</li>
                        <li style="font-size: 16px;">b. Pada saat pemeriksaan fisik</li>
                        <li style="font-size: 16px;">c. Pada saat perawatan</li>
                    </ul>
                </li>
            </ol>
            
            <p style="margin-top: 40px; text-align: right; font-size: 16px;">Tanah Badantuang, ............20</p>
            <p style="text-align: right; font-size: 16px;">Pasien / Keluarga / Wali</p>
            
            <p style="text-align: right; margin-top: 60px; font-size: 16px;">( ____________________ )</p>
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.3f/RI
            </div>
        </div>
    </div>
    </div>
</body>