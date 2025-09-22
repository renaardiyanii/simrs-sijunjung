<?php 
$data = (isset($medis_ponek->formjson))?json_decode($medis_ponek->formjson):'';
?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
<div class="A4 sheet  padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                <h3>PENGKAJIAN MEDIS IGD / PONEK<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
       
        <table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
                <tr>
                    <td>
                         <p style="font-size:12px;font-weight:bold"><span>1. Data Subjective</span></p>
                        <p style="font-size:12px;font-weight:bold"><span>a.	Keluhan Utama</span></p>
                        <div style="min-height:5px">
                            <?= isset($data->question1)?nl2br($data->question1):'' ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="font-size:12px;font-weight:bold"><span>b.	Riwayat Penyakit Saat Ini</span></p>
                        <div style="min-height:5px">
                            <?= isset($data->question2)?nl2br($data->question2):'' ?>
                        </div>
                    </td>
                </tr>
                <tr>
                     <td>
                        <p style="font-size:12px;font-weight:bold"><span>c.	Riwayat Penyakit Dahulu</span></p>
                        <div style="min-height:5px">
                            <?= isset($data->question3)?nl2br($data->question3):'' ?>
                        </div>
                    </td>
                    
                </tr>
                 <tr>
                     <td>
                        <p style="font-size:12px;font-weight:bold"><span>d.	Riwayat Penyakit Keluarga</span></p>
                        <div style="min-height:5px">
                            <?= isset($data->question4)?nl2br($data->question4):'' ?>
                        </div>
                    </td>
                    
                </tr>
                 <tr>
                     <td>
                        <p style="font-size:12px;font-weight:bold"><span>e.	Riwayat Alergi</span></p>
                        <div style="min-height:5px">
                            <?= isset($data->question5)?nl2br($data->question5):'' ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" ><strong>2. Data Objektif</strong></td>
                </tr>
                <tr>
                    <td colspan="3"><strong>A. Pemeriksaan Umum</strong></td>
                </tr>
        </table>
            <table border="1" cellspacing="0" cellpadding="5" style="width: 100%; border-collapse: collapse;">
                
                <tr>
                    <td style="width: 30%; vertical-align: top;">
                    <strong>Sensorium</strong><br>
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item1", $data->question6) ? "checked" : "disabled"):""; ?>> CM
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item3", $data->question6) ? "checked" : "disabled"):""; ?>> Apatis<br>
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item5", $data->question6) ? "checked" : "disabled"):""; ?>> Agitasi
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item7", $data->question6) ? "checked" : "disabled"):""; ?>> Delirium<br>
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item2", $data->question6) ? "checked" : "disabled"):""; ?>> Somnolen
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item4", $data->question6) ? "checked" : "disabled"):""; ?>> Sopor<br>
                    <input type="checkbox" <?php echo isset($data->question6)?(in_array("item6", $data->question6) ? "checked" : "disabled"):""; ?>> Coma<br>
                    </td>
                    <td style="width: 30%; vertical-align: top;">
                    <strong>GCS</strong><br>
                    E: <?= isset($data->question7->text1)?nl2br($data->question7->text1):'' ?><br>
                    M: <?= isset($data->question7->text2)?nl2br($data->question7->text2):'' ?><br>
                    V: <?= isset($data->question7->text3)?nl2br($data->question7->text3):'' ?><br>
                    </td>
                    <td style="width: 40%; vertical-align: top;">
                    <strong>Vital Sign</strong><br>
                    TD :  <?= isset($data->question8->text1)?nl2br($data->question8->text1):'' ?> mmHg<br>
                    HR :  <?= isset($data->question8->text2)?nl2br($data->question8->text2):'' ?> x/menit<br>
                    RR :  <?= isset($data->question8->text3)?nl2br($data->question8->text3):'' ?> x/menit<br>
                    T &nbsp;&nbsp; :  <?= isset($data->question8->text4)?nl2br($data->question8->text4):'' ?> °C
                    </td>
                </tr>
            </table>
            <table border="0" cellspacing="0" cellpadding="4" style="width: 100%; font-family: Arial, sans-serif;">
                <tr>
                    <td colspan="2"><strong>B. Pemeriksaan Fisik</strong></td>
                </tr>
                <tr>
                    <td style="width: 10px;" valign="top">a.</td>
                    <td>
                    <strong>Kepala</strong><br>
                    Mata :  <?= isset($data->question9->text1)?nl2br($data->question9->text1):'' ?><br>
                    Telinga :  <?= isset($data->question9->text2)?nl2br($data->question9->text2):'' ?><br>
                    Hidung :  <?= isset($data->question9->text3)?nl2br($data->question9->text3):'' ?><br>
                    Mulut :  <?= isset($data->question9->text5)?nl2br($data->question9->text5):'' ?><br>
                    Tenggorokan :  <?= isset($data->question9->text4)?nl2br($data->question9->text4):'' ?><br>
                    </td>
                </tr>
                <tr>
                    <td valign="top">b.</td>
                    <td>
                    <strong>Leher</strong><br>
                    Struma : 
                    <input type="checkbox" <?php echo isset($data->question10)?(in_array("item1", $data->question10) ? "checked" : "disabled"):""; ?>> Normal 
                    <input type="checkbox" <?php echo isset($data->question10)?(in_array("item2", $data->question10) ? "checked" : "disabled"):""; ?>> Membesar<br>
                    TVJ : 
                    <input type="checkbox" <?php echo isset($data->question11)?(in_array("item1", $data->question11) ? "checked" : "disabled"):""; ?>> Normal 
                    <input type="checkbox" <?php echo isset($data->question11)?(in_array("item2", $data->question11) ? "checked" : "disabled"):""; ?>> Meningkat<br>
                    Ada kelainan : <?= isset($data->question12)?nl2br($data->question12):'' ?>
                    </td>
                </tr>
                <tr>
                    <td valign="top">c.</td>
                    <td>
                    <strong>Thorak</strong> : 
                    <input type="checkbox" <?php echo isset($data->question13)?(in_array("item1", $data->question13) ? "checked" : "disabled"):""; ?>> Simetris 
                    <input type="checkbox" <?php echo isset($data->question13)?(in_array("item2", $data->question13) ? "checked" : "disabled"):""; ?>> Asimetris 
                    <input type="checkbox" <?php echo isset($data->question13)?(in_array("item3", $data->question13) ? "checked" : "disabled"):""; ?>> Barel Chest<br>
                    Jantung : HR <?= isset($data->question15)?nl2br($data->question15):'' ?>x/menit 
                    <input type="checkbox" <?php echo isset($data->question17)?(in_array("item1", $data->question17) ? "checked" : "disabled"):""; ?>> Reguler 
                    <input type="checkbox" <?php echo isset($data->question17)?(in_array("item2", $data->question17) ? "checked" : "disabled"):""; ?>> Ireguler<br>
                    Paru :<br>
                    &nbsp;&nbsp;&nbsp;Suara Pernapasan : <?= isset($data->question18->text1)?nl2br($data->question18->text1):'' ?><br>
                    &nbsp;&nbsp;&nbsp;Suara Tambahan : <?= isset($data->question18->text2)?nl2br($data->question18->text2):'' ?><br>
                    &nbsp;&nbsp;&nbsp;Perkusi : 
                    <input type="checkbox" <?php echo isset($data->question19)?(in_array("item1", $data->question19) ? "checked" : "disabled"):""; ?>> Sonor 
                    <input type="checkbox" <?php echo isset($data->question19)?(in_array("item2", $data->question19) ? "checked" : "disabled"):""; ?>> Hipersonor 
                    <input type="checkbox" <?php echo isset($data->question19)?(in_array("item3", $data->question19) ? "checked" : "disabled"):""; ?>> Bedah
                    </td>
                </tr>
                <tr>
                    <td valign="top">d.</td>
                    <td>
                    <strong>Abdomen</strong> : 
                    <input type="checkbox"  <?php echo isset($data->question20)?(in_array("item1", $data->question20) ? "checked" : "disabled"):""; ?>> Lembut 
                    <input type="checkbox"  <?php echo isset($data->question20)?(in_array("item2", $data->question20) ? "checked" : "disabled"):""; ?>> Agak keras 
                    <input type="checkbox"  <?php echo isset($data->question20)?(in_array("item3", $data->question20) ? "checked" : "disabled"):""; ?>> Defence muscular 
                    <input type="checkbox"  <?php echo isset($data->question20)?(in_array("item4", $data->question20) ? "checked" : "disabled"):""; ?>> Distensi<br>
                    Hepar : 
                    <input type="checkbox"  <?php echo isset($data->question21)?(in_array("item1", $data->question21) ? "checked" : "disabled"):""; ?>> Tidak teraba 
                    <input type="checkbox"  <?php echo isset($data->question21)?(in_array("item2", $data->question21) ? "checked" : "disabled"):""; ?>> Teraba :<br>
                    Lien : 
                    <input type="checkbox"  <?php echo isset($data->question22)?(in_array("item1", $data->question22) ? "checked" : "disabled"):""; ?>> Tidak teraba 
                    <input type="checkbox"  <?php echo isset($data->question22)?(in_array("item1", $data->question22) ? "checked" : "disabled"):""; ?>> Teraba : ..................<br>
                    Ginjal : 
                    <input type="checkbox"  <?php echo isset($data->question23)?(in_array("item1", $data->question23) ? "checked" : "disabled"):""; ?>> Tidak teraba 
                    <input type="checkbox"  <?php echo isset($data->question23)?(in_array("item1", $data->question23) ? "checked" : "disabled"):""; ?>> Teraba : ..................<br>
                    Nyeri tekan : 
                    <input type="checkbox"  <?php echo isset($data->question24)?(in_array("item1", $data->question24) ? "checked" : "disabled"):""; ?>> Tidak 
                    <input type="checkbox"  <?php echo isset($data->question24)?(in_array("other", $data->question24) ? "checked" : "disabled"):""; ?>> Ya : ..................<br>
                    Peristaltik : 
                    <input type="checkbox"  <?php echo isset($data->question25)?(in_array("item1", $data->question25) ? "checked" : "disabled"):""; ?>> Normal 
                    <input type="checkbox"  <?php echo isset($data->question25)?(in_array("item2", $data->question25) ? "checked" : "disabled"):""; ?>> Meningkat 
                    <input type="checkbox"  <?php echo isset($data->question25)?(in_array("item3", $data->question25) ? "checked" : "disabled"):""; ?>> Melemah 
                    <input type="checkbox"  <?php echo isset($data->question25)?(in_array("item4", $data->question25) ? "checked" : "disabled"):""; ?>> Senyap<br>
                    Punggung : 
                    <input type="checkbox"  <?php echo isset($data->question26)?(in_array("item1", $data->question26) ? "checked" : "disabled"):""; ?>> Tapping : Pain (+) 
                    <input type="checkbox"  <?php echo isset($data->question26)?(in_array("item2", $data->question26) ? "checked" : "disabled"):""; ?>> Tapping : Pain (-)
                    </td>
                </tr>
                <tr>
                    <td valign="top">e.</td>
                    <td>
                    <strong>Genitalia</strong> :  <?= isset($data->question27)?nl2br($data->question27):'' ?><br>
                    </td>
                </tr>
                <tr>
                    <td valign="top">f.</td>
                    <td>
                    <strong>Ekstremitas</strong><br>
                    Ekstremitas atas : 
                    <input type="checkbox"  <?php echo isset($data->question28)?(in_array("item1", $data->question28) ? "checked" : "disabled"):""; ?>> Normal 
                    <input type="checkbox"  <?php echo isset($data->question28)?(in_array("other", $data->question28) ? "checked" : "disabled"):""; ?>> Ada kelainan : ..................<br>
                    Ekstremitas bawah : 
                    <input type="checkbox"  <?php echo isset($data->question29)?(in_array("item1", $data->question29) ? "checked" : "disabled"):""; ?>> Normal 
                    <input type="checkbox"  <?php echo isset($data->question29)?(in_array("other", $data->question29) ? "checked" : "disabled"):""; ?>> Ada kelainan : ..................
                    </td>
                </tr>
            </table>

       
     

        
    
    </div>
    <div class="A4 sheet  padding-fix-10mm">
       
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                <h3>PENGKAJIAN MEDIS IGD PONEK<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
        <table border="0" width="100%" cellpadding="5px" style="margin-top:10px">
                <tr>
                    <p style="font-size:12px;font-weight:bold">3.	Pemeriksaan Fisik Khusus</p>
                </tr>
        </table>

        <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
        <tr>
             <td>
                <p> Status Luka : (Regio, Jenis luka, Ukuran) <br>
                <p> 1 <?= isset($data->question30->text1)?nl2br($data->question30->text1):'' ?><br>
                <p> 2 <?= isset($data->question30->text2)?nl2br($data->question30->text2):'' ?><br>
                <p> 3 <?= isset($data->question30->text3)?nl2br($data->question30->text3):'' ?><br>
                <p> 4 <?= isset($data->question30->text4)?nl2br($data->question30->text4):'' ?><br>
                <p> 5 <?= isset($data->question30->text5)?nl2br($data->question30->text5):'' ?><br>
            </td>
            <td>
            <?php if (!empty($data->question32)): ?>
                <img src="<?= $data->question32 ?>" alt="Status Luka" height="150px" width="300px">
            <?php endif; ?>
            </td>
        </tr>
         <tr>
             <td>
                <p>Status Tulang/Fraktur<br>
                <p> 1 <?= isset($data->question31->text1)?nl2br($data->question31->text1):'' ?><br>
                <p> 2 <?= isset($data->question31->text2)?nl2br($data->question31->text2):'' ?><br>
                <p> 3 <?= isset($data->question31->text3)?nl2br($data->question31->text3):'' ?><br>
                <p> 4 <?= isset($data->question31->text4)?nl2br($data->question31->text4):'' ?><br>
                <p> 5 <?= isset($data->question31->text5)?nl2br($data->question31->text5):'' ?><br>
            </td>
        </tr>
        </table>
        <table border="0">
            <tr class="header-green">
                <td colspan="2">4. Pemeriksaan Khusus Ponek</td>
            </tr>
            <tr>
                <td style="width: 25%;">HPHT :</td>
                <td>G :  <?= isset($data->question33->text1)?nl2br($data->question33->text1):'' ?> &nbsp;&nbsp;&nbsp;&nbsp; P :  <?= isset($data->question33->text2)?nl2br($data->question33->text2):'' ?> &nbsp;&nbsp;&nbsp;&nbsp; A :  <?= isset($data->question33->text3)?nl2br($data->question33->text3):'' ?></td>
            </tr>
            <tr>
                <td>Pemeriksaan fisik</td>
                <td>
                Mata : <input type="checkbox"  <?php echo isset($data->question34)?(in_array("item1", $data->question34) ? "checked" : "disabled"):""; ?>> Pandangan kabur 
                <input type="checkbox"  <?php echo isset($data->question34)?(in_array("item2", $data->question34) ? "checked" : "disabled"):""; ?>> Berkunang-kunang <br>
                Konjungtiva : Anemis 
                <input type="checkbox" <?php echo isset($data->question35)?(in_array("item1", $data->question35) ? "checked" : "disabled"):""; ?>> Ya 
                <input type="checkbox" <?php echo isset($data->question35)?(in_array("item2", $data->question35) ? "checked" : "disabled"):""; ?>> Tidak <br>
                Sklera : Ikterik 
                <input type="checkbox" <?php echo isset($data->question36)?(in_array("item1", $data->question36) ? "checked" : "disabled"):""; ?>> Ya 
                <input type="checkbox" <?php echo isset($data->question36)?(in_array("item2", $data->question36) ? "checked" : "disabled"):""; ?>> Tidak <br>
                Dada & Aksila : 
                <input type="checkbox" <?php echo isset($data->question37)?(in_array("item1", $data->question37) ? "checked" : "disabled"):""; ?>> Mamae Asimetris/Simetris 
                <input type="checkbox" <?php echo isset($data->question37)?(in_array("item2", $data->question37) ? "checked" : "disabled"):""; ?>> Aerola mamae hiperpigmentasi <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" <?php echo isset($data->question37)?(in_array("item3", $data->question37) ? "checked" : "disabled"):""; ?>> Puting susu menonjol 
                <input type="checkbox" <?php echo isset($data->question37)?(in_array("item4", $data->question37) ? "checked" : "disabled"):""; ?>> Pengeluaran tumor
                </td>
            </tr>
            <tr>
                <td>Pemeriksaan Obstetric</td>
                <td>
                Infeksi : 
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item1", $data->question38) ? "checked" : "disabled"):""; ?>> Membesar dengan arah memanjang 
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item2", $data->question38) ? "checked" : "disabled"):""; ?>> Melebar 
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item3", $data->question38) ? "checked" : "disabled"):""; ?>> Pelebaran Vena 
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item4", $data->question38) ? "checked" : "disabled"):""; ?>> Line alba<br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item5", $data->question38) ? "checked" : "disabled"):""; ?>> Linea nigra 
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item6", $data->question38) ? "checked" : "disabled"):""; ?>> Stria livide 
                <input type="checkbox"  <?php echo isset($data->question38)?(in_array("item7", $data->question38) ? "checked" : "disabled"):""; ?>> Striae albicans
                </td>
            </tr>
            <tr>
                <td>Palpasi TFU</td>
                <td>: <?= isset($data->question39->text1)?nl2br($data->question39->text1):'' ?> cm</td>
            </tr>
            <tr><td>Leopold I</td><td>: <?= isset($data->question39->text2)?nl2br($data->question39->text2):'' ?></td></tr>
            <tr><td>Leopold II</td><td>: <?= isset($data->question39->text3)?nl2br($data->question39->text3):'' ?></td></tr>
            <tr><td>Leopold III</td><td>: <?= isset($data->question39->text4)?nl2br($data->question39->text4):'' ?></td></tr>
            <tr><td>Leopold IV</td><td>: <?= isset($data->question39->text5)?nl2br($data->question39->text5):'' ?></td></tr>
            </table>

            <!-- 5. Pemeriksaan Penunjang -->
            <table border="1" style="margin-top: 10px;">
                <tr >
                    <td colspan="6">5. Pemeriksaan Penunjang</td>
                </tr>
                <tr >
                    <td>Laboratorium</td>
                    <td>Radiologi</td>
                    <td>EKG</td>
                    <td>KGD Stik</td>
                    <td colspan="2">Oxymetri</td>
                </tr>
                <tr>
                    <td>
                    <?= isset($data->question41)?nl2br($data->question41):'' ?>
                    </td>
                    <td>
                    <?= isset($data->question40)?nl2br($data->question40):'' ?>
                    </td>
                    <td>
                    <input type="checkbox"  <?php echo isset($data->question42)?(in_array("item1", $data->question42) ? "checked" : "disabled"):""; ?>> Ya
                    <input type="checkbox"  <?php echo isset($data->question42)?(in_array("item2", $data->question42) ? "checked" : "disabled"):""; ?>> Tidak
                    </td>
                    <td>
                    <input type="checkbox" <?php echo isset($data->question43)?(in_array("item1", $data->question43) ? "checked" : "disabled"):""; ?>> Ya
                    <input type="checkbox" <?php echo isset($data->question43)?(in_array("item2", $data->question43) ? "checked" : "disabled"):""; ?>> Tidak<br>
                    Nilai : .......... 
                    </td>
                    <td>SPO<sub>2</sub> : <?= isset($data->question44->text1)?nl2br($data->question44->text1):'' ?> %</td>
                    <td>O<sub>2</sub> : <?= isset($data->question44->text2)?nl2br($data->question44->text2):'' ?>  l/m</td>
                </tr>
            </table>

            <!-- 6. Analisis -->
              <span>6. Analisis</span>
            <table border="0" style="margin-top: 10px;">
                
                <tr>
                    <td style="width: 60%;"><strong>a. Daftar Masalah</strong><br><?= isset($data->question45)?nl2br($data->question45):'' ?> </td>
                    
                </tr>
                <tr>
                    <td><strong>b. Diagnosis Banding</strong> <br>
                    : <?= isset($data->question46)?nl2br($data->question46):'' ?></td>
                </tr>
                <tr>
                    <td><strong>c. Diagnosis Kerja</strong><br>
                    : <?= isset($data->question47)?nl2br($data->question47):'' ?></td>
                </tr>
             </table><br>
             <span>7.	Penatalaksanaan/Perencanaan Pelayanan</span><br>
             <?= isset($data->question48)?nl2br($data->question48):'' ?>
      
    </table>
    </div>
     <div class="A4 sheet  padding-fix-10mm">
       
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                <h3>PENGKAJIAN MEDIS IGD PONEK<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:10px">
           <tr>
             <td colspan="4">8.	Catatan Perkembangan</td>
           </tr>
                <tr>
                  <td>Tanggal/Jam</td>
                   <td>Profesi</td>
                   <td>Catatan perkembangan</td>
                   <td>Nama terang & <br>Tanda tangan</td>
                </tr>
                <?php
                    if(isset($data->question49)){
                        foreach($data->question49 as $val){
                   ?>
                <tr>
                    <td><?= isset($val->column1)?$val->column1:'' ?></td>
                    <td><?= isset($val->column2)?$val->column2:'' ?></td>
                    <td><?= isset($val->column3)?$val->column3:'' ?></td>
                    <td><p style="margin: 10px 0;"> <img width="90px" src="<?= isset($val->column4)?$val->column4:'' ?>" alt=""></p></td>
                    
                </tr>
                 <?php }} else { ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                  <?php   }
                    ?>
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:10px">
           <tr>
             <td colspan="4">9.	Informasi dan Edukasi</td>
           </tr>
                <tr>
                   <td>Tanggal/Jam</td>
                   <td>Profesi</td>
                   <td>Materi</td>
                   <td>Evaluasi</td>
                    <td>Nama dan Tanda Tangan <br>Pemberi Edukasi</td>
                     <td>Nama dan Tanda Tangan<br> Penerima Edukasi</td>
                </tr>
                  <?php
                    if(isset($data->question50)){
                        foreach($data->question50 as $val){
                   ?>
                <tr>
                    <td><?= isset($val->column1)?$val->column1:'' ?></td>
                    <td><?= isset($val->column2)?$val->column2:'' ?></td>
                    <td><?= isset($val->column3)?$val->column3:'' ?></td>
                    <td><?= isset($val->column5)?$val->column5:'' ?></td>
                    <td><p style="margin: 10px 0;"> <img width="90px" src="<?= isset($val->column6)?$val->column6:'' ?>" alt=""></p></td>
                    <td><p style="margin: 10px 0;"> <img width="90px" src="<?= isset($val->column4)?$val->column4:'' ?>" alt=""></p></td>
                    
                </tr>
                 <?php }} else { ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                     <td></td>
                    <td></td>
                </tr>
                 <?php   }
                    ?>
        </table>
        
     </table>
     </div>
     <div class="A4 sheet  padding-fix-10mm">
       
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD SIJUNJUNG</h3></td>
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
                <h3>PENGKAJIAN MEDIS IGD PONEK<h3>
            </center>
        </td>

        <td width="30%">
            <table border="0" width="100%" cellpadding="7px" >
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</header>
       
       
        <table border="1" width="100%" cellpadding="5px" style="margin-top:10px">
            <!-- Bagian 10 -->
            <tr class="section-header">
                <td colspan="5">10. Tindakan Lanjutan</td>
            </tr>
            <tr>
                <td colspan="3">
                <input type="checkbox" <?php echo isset($data->question51)?(in_array("item1", $data->question51) ? "checked" : "disabled"):""; ?>> Pindah Ruangan<br>
                <input type="checkbox" <?php echo isset($data->question52)?(in_array("item1", $data->question52) ? "checked" : "disabled"):""; ?>> Kamar Operasi<br>
                <input type="checkbox" <?php echo isset($data->question52)?(in_array("item2", $data->question52) ? "checked" : "disabled"):""; ?>> Kamar Bersalin<br>
                <input type="checkbox" <?php echo isset($data->question52)?(in_array("item3", $data->question52) ? "checked" : "disabled"):""; ?>> ICU/PICU/NICU<br>
                <input type="checkbox" <?php echo isset($data->question52)?(in_array("item4", $data->question52) ? "checked" : "disabled"):""; ?>> HCU<br>
                <input type="checkbox" <?php echo isset($data->question52)?(in_array("item5", $data->question52) ? "checked" : "disabled"):""; ?>> Rawat Inap : <br>
                DPJP: <?= isset($data->question54->text1)?$data->question54->text1:'' ?> <br>
                Ruangan: <?= isset($data->question54->text2)?$data->question54->text2:'' ?>
                </td>
                <td>
                <input type="checkbox"  <?php echo isset($data->question51)?(in_array("item2", $data->question51) ? "checked" : "disabled"):""; ?>> Dirujuk<br><br>
                Alasan: <br>
                <input type="checkbox" <?php echo isset($data->question53)?(in_array("item1", $data->question53) ? "checked" : "disabled"):""; ?>> Kamar Penuh<br>
                <input type="checkbox" <?php echo isset($data->question53)?(in_array("item2", $data->question53) ? "checked" : "disabled"):""; ?>> Fasilitas tidak ada<br>
                <input type="checkbox" <?php echo isset($data->question53)?(in_array("item3", $data->question53) ? "checked" : "disabled"):""; ?>> Permintaan Pasien/Keluarga
                </td>
                <td>
                <input type="checkbox" <?php echo isset($data->question51)?(in_array("item3", $data->question51) ? "checked" : "disabled"):""; ?>> Meninggal<br>
                <input type="checkbox" <?php echo isset($data->question51)?(in_array("item4", $data->question51) ? "checked" : "disabled"):""; ?>> Observasi<br>
                <input type="checkbox" <?php echo isset($data->question51)?(in_array("item5", $data->question51) ? "checked" : "disabled"):""; ?>> Rawat Jalan<br><br>
                <span>Pukul:   <?= isset($data->question55)?$data->question55:'' ?><br><br>
                Transportasi Keluar RS:  <?= isset($data->question56)?$data->question56:'' ?><br>
                Ambulance:
                <input type="checkbox" <?php echo isset($data->question57)?(in_array("item1", $data->question57) ? "checked" : "disabled"):""; ?>> RS
                <input type="checkbox" <?php echo isset($data->question57)?(in_array("item2", $data->question57) ? "checked" : "disabled"):""; ?>> Luar
                <input type="checkbox" <?php echo isset($data->question57)?(in_array("item3", $data->question57) ? "checked" : "disabled"):""; ?>> Mayat<br>
                Kendaraan:
                <input type="checkbox" <?php echo isset($data->question58)?(in_array("item1", $data->question58) ? "checked" : "disabled"):""; ?>> Umum
                <input type="checkbox" <?php echo isset($data->question58)?(in_array("item2", $data->question58) ? "checked" : "disabled"):""; ?>> Pribadi
                </td>
            </tr>

            <!-- Bagian 11 -->
            <tr class="section-header">
                <td colspan="5">11. Kondisi Pasien saat Keluar dari IGD</td>
            </tr>
            <tr>
                <td colspan="3">
                a. VITAL SIGN   <br>
                TD: <?= isset($data->question59->text1)?$data->question59->text1:'' ?>  mmHg<br>
                HR: <?= isset($data->question59->text2)?$data->question59->text2:'' ?>  x/menit<br>
                RR: <?= isset($data->question59->text3)?$data->question59->text3:'' ?>  x/menit<br>
                T: <?= isset($data->question59->text4)?$data->question59->text4:'' ?>  °C
                </td>
                <td colspan="2">
                b. GCS<br>
                E: <?= isset($data->question60->text1)?$data->question60->text1:'' ?> <br>
                M: <?= isset($data->question60->text2)?$data->question60->text2:'' ?> <br>
                V: <?= isset($data->question60->text3)?$data->question60->text3:'' ?> 
                </td>
            </tr>

            <!-- Bagian 12 -->
            <tr class="section-header">
                <td colspan="5">12. Penkes Pasien Pulang</td>
            </tr>
            <tr>
                <td colspan="5">
                <input type="checkbox" <?php echo isset($data->question61)?(in_array("item1", $data->question61) ? "checked" : "disabled"):""; ?>> Makan/Minum Obat Teratur<br>
                <input type="checkbox" <?php echo isset($data->question61)?(in_array("item2", $data->question61) ? "checked" : "disabled"):""; ?>> Diet<br>
                <input type="checkbox" <?php echo isset($data->question61)?(in_array("item3", $data->question61) ? "checked" : "disabled"):""; ?>> Jaga Kebersihan Luka<br>
                <input type="checkbox" <?php echo isset($data->question61)?(in_array("other", $data->question61) ? "checked" : "disabled"):""; ?>> Lain-lain: .........................................
                </td>
            </tr>

            <!-- Tanda Tangan -->
            <tr>
                <td>Yang Melakukan Pengkajian</td>
                <td>Nama</td>
                <td>Jam</td>
                <td>Tanggal</td>
                <td>T. Tangan</td>
            </tr>
            <tr>
                <td>Dokter</td>
                 <td><?= isset($data->question64)?$data->question64:'' ?></td>
                <td>
                Mulai: <?= isset($data->question66) ? date('H:i', strtotime($data->question66)) : '' ?><br>
                Selesai: <?= isset($data->question68)? date('H:i', strtotime ($data->question68)) :'' ?>
                </td>
               <td><?= isset($data->question66)? date('Y-m-d', strtotime ($data->question66)) :'' ?></td>
                <td><p style="margin: 10px 0;"> <img width="90px" src="<?= isset($data->question62)?$data->question62:null;  ?>" alt=""></p></td>
            </tr>
            <tr>
                <td>Perawat/Bidan</td>
                <td><?= isset($data->question64)?$data->question64:'' ?></td>
                <td>
                Mulai: <?= isset($data->question67)?date('H:i', strtotime ($data->question67)):'' ?><br>
                Selesai: <?= isset($data->question69)?date('H:i', strtotime ($data->question69)):'' ?>
                </td>
                <td><?= isset($data->question67)? date('Y-m-d', strtotime ($data->question67)) :'' ?></td>
                <td><p style="margin: 10px 0;"> <img width="90px" src="<?= isset($data->question63)?$data->question63:null;  ?>" alt=""></p></td>
                
            </tr>
            </table>
    </table>
     </div>
</body>

</html>