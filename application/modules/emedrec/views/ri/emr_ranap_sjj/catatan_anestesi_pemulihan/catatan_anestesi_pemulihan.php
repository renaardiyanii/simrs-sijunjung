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
                <h3>CATATAN KAMAR PEMULIHAN <br></h3>
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
        
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                <p style="font-size: 14px;">Masuk Kamar Pulih Dasar Jam : ......................</p>
                <p style="font-size: 14px;">Pernafasan :  <input type="checkbox"> Spontan <input type="checkbox"> Dibantu</p>
                <p style="font-size: 14px;">Bila Spontan :  <input type="checkbox"> Adekuat bersuara <input type="checkbox"> Penyumbat<input type="checkbox"> Tidur dalam</p>
                <p style="font-size: 14px;">Kesadaran:  <input type="checkbox"> Sadar betul <input type="checkbox"> Belum sadar</p>
                <p style="font-size: 14px;">Skor ALDRETTE: ........................</p>
                <p style="font-size: 14px;">Aktivitas : .................Sirkulasi  : .................Pasan  : .................Kesadaran  : ...............</p>
                <p style="font-size: 14px;">Warna Kulit : ..........Total : ..........</p>
                <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td><b><center>TVS</center></b></td>
                        <td><b><center>R</center></b></td>
                        <td><b><center>N</center></b></td>
                        <td><b><center>TD</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center>25</center></b></td>
                        <td><b><center>28</center></b></td>
                        <td><b><center>180</center></b></td>
                        <td><b><center>220</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center>20</center></b></td>
                        <td><b><center>20</center></b></td>
                        <td><b><center>160</center></b></td>
                        <td><b><center>200</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center>15</center></b></td>
                        <td><b><center>16</center></b></td>
                        <td><b><center>140</center></b></td>
                        <td><b><center>180</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center>10</center></b></td>
                        <td><b><center>12</center></b></td>
                        <td><b><center>120</center></b></td>
                        <td><b><center>160</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center>5</center></b></td>
                        <td><b><center>8</center></b></td>
                        <td><b><center>100</center></b></td>
                        <td><b><center>140</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>80</center></b></td>
                        <td><b><center>120</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>60</center></b></td>
                        <td><b><center>100</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>80</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>60</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>40</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>20</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                    <tr>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center>0</center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                        <td><b><center></center></b></td>
                    </tr>
                </table>
                <table border="1" width="100%" cellpadding="2">
                    <tr>
                        <td colspan="2"><b><center>VAS</center></b></td>
                        <td width="24%"><strong>SKOR ALDRETTE</strong></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        
                    </tr>
                    <tr>
                        <td>10</td>
                        <td><center><img src="<?= base_url("assets/img/1.png"); ?>" alt="img" height="30px" width="30px";></center></td>
                        <td>Aktivitas :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td><center><img src="<?= base_url("assets/img/2.png"); ?>" alt="img" height="30px" width="30px";></center></td>
                        <td>Sirkulasi :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td><center><img src="<?= base_url("assets/img/3.png"); ?>" alt="img" height="30px" width="30px";></center></td>
                        <td>Pernapasan :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td><center><img src="<?= base_url("assets/img/4.png"); ?>" alt="img" height="30px" width="30px";></center></td>
                       <td>Kesadaran :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td><center><img src="<?= base_url("assets/img/5.png"); ?>" alt="img" height="30px" width="30px";></center></td>
                        <td>Kesadaran :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>15</td>
                        <td><center><img src="<?= base_url("assets/img/6.png"); ?>" alt="img" height="30px" width="30px";></center></td>
                       <td>Warna kulit :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td></td>
                        <td>Total :</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                <p style="font-size: 14px;">Jam Keluar Kamar Pulih : ......................</p>
                <p style="font-size: 14px;">Skor ALDRETTE : ......................</p>
                <p style="font-size: 14px;">Aktivitas : .................Sirkulasi  : .................Pasan  : .................Kesadaran  : ...............</p>
                <p style="font-size: 14px;">Warna Kulit : ..........Total : ..........</p>
                <p style="font-size: 14px;">Ke:  <input type="checkbox"> Ruang rawat <input type="checkbox">ICU <input type="checkbox"> Langsung Pulang</p>
                <p style="font-size: 14px;">Catatan Khusus Ruang Pemulihan  : ......................</p>
                
            </td>  
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.18.b1/RI
                    </div>
               </div>
    </div>
    
</div>
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
            <h3>CATATAN KAMAR PEMULIHAN <br></h3>
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
        
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
        <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="2">
                <p style="font-size: 14px;"><strong> PASCA ANESTESI SELAMA DI RUANG PEMULIHAN</strong></p>
                    <p style="font-size: 14px;">Bila kesakitan  : ......................</p>
                    <p style="font-size: 14px;">Bila mual / muntah  : ......................</p>
                    <p style="font-size: 14px;">Obat - obatan  : ......................</p>
                    <p style="font-size: 14px;">Infus : ......................</p>
                    <p style="font-size: 14px;">Pemantauan Tensi, Nadi, Napas setiap : ...............Selama :.....................</p>
                    <p style="font-size: 14px;">Lainnya..........................</p>
                
                </table><br><br><br>
                <table width="80%" align="center" style="text-align: center; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5; border-collapse: collapse;">
                    <tr>
                        <td style="width: 33%; font-weight: bold; padding: 30px;">Dokter Anestesiologi</td>
                    </tr>
                    <tr>
                         <td style="padding: 30px;"> ________________________ </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.18.b1/RI
                    </div>
               </div>
</div>
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
            <h3>CATATAN ANESTESI <br></h3>
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
        
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
        <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td>Pangkat / Gol :.................</td>
                    <td>NRP / NIP :................</td>
                </tr>
                <tr>
                    <td>Kesatuan / Alamat :.................</td>
                   
                </tr>
                
                </table><br><br><br>
                <table width="80%" align="center" style="text-align: center; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5; border-collapse: collapse;">
                    <tr>
                        <td style="width: 33%; font-weight: bold; padding: 10px;">Spesialis Anestesi</td>
                        <td style="width: 33%; font-weight: bold; padding: 10px;">Asisten Anestesi</td>
                        <td style="width: 33%; font-weight: bold; padding: 10px;">Spesialis Bedah</td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">________________________</td>
                        <td style="padding: 30px;"> ________________________</td>
                        <td style="padding: 30px;"> ________________________ </td>
                    </tr> 
                </table>
                <p style="font-size: 14px;">Diagnosa Bedah  : ......................</p><br>
                <p style="font-size: 14px;">Jenis Pembedahan  : ......................</p><br>
                <p style="font-size: 14px;">Diagnosa Pasca Bedah : ......................</p><br>
                <p style="font-size: 14px;">Teknik Anestesi :</p>
                <p><input type="checkbox"> Sedasi   <input type="checkbox"> Anestesi Umum   <input type="checkbox"> Lainnya
                <input type="checkbox"> Spinal   <input type="checkbox"> Epidural <input type="checkbox"> Kaudal  <input type="checkbox"> Blok Perifes<p> 
                <p style="font-size: 14px;">Teknik dan Alat khusus :</p>
                <p><input type="checkbox"> Hipotensi   <input type="checkbox"> TCI <input type="checkbox"> CPB
                <input type="checkbox"> Ventilasi paru paru   <input type="checkbox"> Bronchoscopi <input type="checkbox"> Glidescope  <input type="checkbox"> Stimulator Syaraf <input type="checkbox"> Lainnya...............<p> 
                <p><input type="checkbox"> EKG Lead   <input type="checkbox"> Arteri Line <input type="checkbox"> Et CO₂
                <input type="checkbox"> Stetoscope   <input type="checkbox"> NIBP </p>
                <p><input type="checkbox"> CVP  <input type="checkbox"> Cath A Pulmo <input type="checkbox">SpO₂  <input type="checkbox">Kateter Urine </p>
                <p><input type="checkbox"> NGT  <input type="checkbox"> BIS <input type="checkbox">Lainnya  </p>
                <p>STATUS FISIK  : ASA : 1 2 3 4 5 E</p>
                <p><input type="checkbox"> Alergi  <input type="checkbox"> Tidak <input type="checkbox"> Ya</p>
                <p>Penyakit Pra Anestesia : .............................</p><br>
                <p>Check List Persiapan Anestesia</p>
                <p><input type="checkbox"> Informed concent <input type="checkbox"> Obat obatan anestesia <input type="checkbox"> Tatalaksana jalan napas <input type="checkbox"> Mesin anestesia <p>
                <p><input type="checkbox"> Monitoring <input type="checkbox"> Obat obatan Emergency <input type="checkbox"> Suction Apparatus <input type="checkbox"> Monitoring <p>
                <p>Penilaian Pra Induksi </p>
                <table border="0" width="100%" cellpadding="2">
                    <tr>
                        <td width="50%" >Jam : </td>
                        <td width="50%" > TD :</td>
                    </tr>
                    <tr>
                        <td width="50%" >Kesadaran : </td>
                        <td width="50%" > Sat Oz :</td>
                    </tr>
                    <tr>
                        <td width="50%" >Suhu : </td>
                        <td width="50%" > Nadi :</td>
                    </tr>
                    <tr>
                        <td width="50%" > BB : </td>
                        <td width="50%" > TB :</td>
                    </tr>
                </table>
                <p> CATATAN :............................</p><br><br><br>
            </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.18.b2/RI
                    </div>
               </div>
</div>
</body>

</html>