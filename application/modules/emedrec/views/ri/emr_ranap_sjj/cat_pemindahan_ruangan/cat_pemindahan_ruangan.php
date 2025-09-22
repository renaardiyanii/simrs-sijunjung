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
                <h3>CATATAN PEMINDAHAN PASIEN <br></h3>
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
            <td colspan="2">(Diisi Perawat/Bidan)</td>
            <td >Halaman 1 dari 2</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="30%" >Tanggal  </td>
                    <td width="20%" > :</td>
                    <td width="30%" >Jam </td>
                    <td width="20%" >:</td>
                </tr>
                <tr>
                    <td width="30%" >Tiba diruangan </td>
                    <td width="20%" >:</td>
                    <td width="30%" >Dari ruangan</td>
                    <td width="20%" >:</td>
                </tr>
                <tr>
                    <td width="30%" >Diagnosa</td>
                    <td width="20%" >:</td>
                </tr>
                
            </table>
            <p style="font-size: 14px;"><strong>1. SITUASI</strong></p>
            <p style="font-size: 14px;">Dokter yang merawat 1.dr........................... 2. dr.................. </p>
            <p style="font-size: 14px;">Pasien/ keluarga sudah dijelaskan mengenai diagnosis :  <input type="checkbox"> Ya <input type="checkbox"> Tidak</p>
            <p style="font-size: 14px;">Masalah keperawatan yang utama saat ini :...............</p>
            <p style="font-size: 14px;">Prosedur pembedahan/ invasive yang akan / sudah dilakukan ....................tanggal.........................
            <p style="font-size: 14px;"><strong>2. LATAR BELAKANG</strong></p>
            <p style="font-size: 14px;">Pasien/ keluarga sudah dijelaskan mengenai diagnosis :  <input type="checkbox"> Ya <input type="checkbox"> Tidak</p>
            <p style="font-size: 14px;">Riwayat reaksi    :...............</p>
            <p style="font-size: 14px;">Intervensi medik/ keperawatan   :...............</p>
            <p style="font-size: 14px;">Hasil investigasi abnormal   :...............</p>
            <p style="font-size: 14px;">Kewaspadaan  :  <input type="checkbox"> Standar <input type="checkbox"> Contact <input type="checkbox"> Airbone <input type="checkbox"> Droplet</p>
            <p style="font-size: 14px;"><strong>3. HASIL PEMERIKSAAN</strong></p>
            <p style="font-size: 14px;">Observasi terakhir pukul   :...............</p>
            <p style="font-size: 14px;">Kesadaran   :  <input type="checkbox"> Cosposmentis  <input type="checkbox"> Apatis  <input type="checkbox"> Somnolent  <input type="checkbox"> Soporo <input type="checkbox"> Sapooscoma <input type="checkbox"> Koma </p>
            <p style="font-size: 14px;">Pupil & reaksi cahaya  : Kanan ............... Kiri  ...............</p>
            <p style="font-size: 14px;">TD :................mmHg     Nadi  :................ x/mnt    Sat O2  :................ x/mnt   Suhu :................ C Skala Nyeri :................ C</p>
            <P><input type="checkbox"> Batasan Cairan ...................cc <input type="checkbox">Diet khusus <input type="checkbox"> Puasa , mulai pukul :...........</P>
            <p style="font-size: 14px;">BAB :  <input type="checkbox">Normal <input type="checkbox">Ileustomy / Coloctomy  <input type="checkbox">  Inkontinensia alvi <input type="checkbox">Konstipasi <input type="checkbox">Meconium </p>
            <p style="font-size: 14px;">BAK :  <input type="checkbox">Normal  <input type="checkbox">Inkontinentia urin  </p>
            <P> <input type="checkbox">Kateter, jenis kateter :............ No. Kateter:.....................  Tgl pemasangan :..............</p>
            <p style="font-size: 14px;">Transfer / mobilisasi   :  <input type="checkbox">Mandiri <input type="checkbox">Dibantu sebagian <input type="checkbox">Dibantu penuh </p>
            <p style="font-size: 14px;">Mobilisasi   :  <input type="checkbox">Jalan   <input type="checkbox">Terus baring  <input type="checkbox">Duduk  <input type="checkbox"> Box bayi <p> 
            <p style="font-size: 14px;">Gangguan indera   :  <input type="checkbox">Tidak   <input type="checkbox">Ya <input type="checkbox">Pendengaran   <input type="checkbox"> Kacamata   <input type="checkbox"> Alat bantu dengar <p> 
            <p style="font-size: 14px;">Alat bantu yang digunakan   :  <input type="checkbox">Tanpa alat bantu   <input type="checkbox"> Gigi palsu <input type="checkbox">Pendengaran   <input type="checkbox"> Penciuman  <input type="checkbox"> Perabaan  <input type="checkbox"> Bicara  <p> 
            <p style="font-size: 14px;">Alat yang terpasang :</p>
            <p><input type="checkbox">Infus  Lokasi :.................. Tgl. Pemasangan :..................</p>
            <p><input type="checkbox">Drain  :.................. Tgl. Pemasangan :..................</p>
            <p><input type="checkbox">Tranfusi   :.................. Tgl. Pemasangan :..................</p>
            <p><input type="checkbox">Kateter   :.................. Tgl. Pemasangan :..................</p>
            <p><input type="checkbox">Lain- lain   :.................. Tgl. Pemasangan :..................</p>
        </td>  
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.20.a/RI
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
            <h3>CATATAN PEMINDAHAN PASIEN <br></h3>
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
            <td colspan="2">(Diisi Perawat/Bidan)</td>
            <td >Halaman 2 dari 2</td>
            
        </tr>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
        <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="2">
                    <p style="font-size: 14px;">Tindakan / kebutuhan khusus : <input type="checkbox"> Protokol risiko jatuh <input type="checkbox"> Protokol Restain <input type="checkbox"> Perawatan luka <input type="checkbox"> Hygiene</p>
                    <p style="font-size: 14px;"><strong>4. RENCANA KERJA ( diisi oleh Dokter )</strong></p>
                    <p style="font-size: 14px;">Konsultasi :..............................</p>
                    <p style="font-size: 14px;">Formulir konsul terlampir : <input type="checkbox">Tidak  <input type="checkbox">Ya 
                    <p style="font-size: 14px;">Terapi :..............................<br><br><br></p>
                    <p style="font-size: 14px;">Rencana pemeriksaan Lab / Radiologi  :..............................<br><br><br></p>
                    <p style="font-size: 14px;">Rencana tindakan lebih lanjut :.............................. <br><br><br></p>
                    <p style="font-size: 14px;">Obat, barang, dokumen yang disertakan :.............................. <br><br><br></p>
                    <p style="font-size: 14px;">Hasil / Permintaan : <input type="checkbox">Laboratorium   <input type="checkbox">Radiologi <input type="checkbox">Lain-lain </p> 
                    <p><input type="checkbox">Surat masuk perawatan   <input type="checkbox"> Berkas Rekam Medik <input type="checkbox"> Gelang Nama </p><p><input type="checkbox"> Catatan Terintegrasi yang berisi instruksi / terapi <input type="checkbox"> Surat rujukan <input type="checkbox"> Inform consent <input type="checkbox"> Jaringan PA </p><p><input type="checkbox"> Laporan operasi / Tindakan <input type="checkbox"> Lain lain
                    <input type="checkbox"> Obat - obatan ................</p>
                </tr>
                </table><br><br><br>
                <table width="80%" align="center" style="text-align: center; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5; border-collapse: collapse;">
                    <tr>
                        <td style="width: 33%; font-weight: bold; padding: 10px;">Disetujui Pasien / penanggung Jawab</td>
                        <td style="width: 33%; font-weight: bold; padding: 10px;">Perawat yang Menyerahkan</td>
                        <td style="width: 33%; font-weight: bold; padding: 10px;">Perawat Yang Menerima</td>
                    </tr>
                    <tr>
                        <td style="padding: 30px;">________________________</td>
                        <td style="padding: 30px;"> ________________________</td>
                        <td style="padding: 30px;"> ________________________ </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.20.a/RI
                    </div>
               </div>
</div>
</body>

</html>