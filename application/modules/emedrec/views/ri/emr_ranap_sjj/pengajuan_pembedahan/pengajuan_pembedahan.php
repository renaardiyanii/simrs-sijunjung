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
                <h3>PENGAJUAN PEMBEDAHAN<br></h3>
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
                <td colspan="2" style="padding-bottom: 30px;">Pangkat / Gol Pasien : </td>
                <td> NRP / NIP  Pasien :</td>
        </tr>
        <tr>
            <td colspan="4">Dianosa :
                <p>Rencana Pembedahan :.....................  Tanggal :.................Jam : ...................</p>
                <p>Ahli bedah :.....................  Asisten Bedah :.............................</p>
                <p>Anestesi yang di inginkan : <input type="checkbox">Umum <input type="checkbox">Regional <input type="checkbox"> Neurolep <input type="checkbox"> Lokal</p>
                <p>Jenis kasus : <input type="checkbox">Bersih <input type="checkbox">Bersih tercemar <input type="checkbox"> Tercemar <input type="checkbox"> Kotor</p>
                <p><b>1. DATA MEDIS</b></p>
                <p>
                    TD : ........... mmHg &nbsp;&nbsp;&nbsp;&nbsp; Nadi : ............ x/menit &nbsp;&nbsp;&nbsp;&nbsp; P :................x/menit &nbsp;&nbsp;&nbsp;&nbsp; Suhu : ....................C &nbsp;&nbsp;&nbsp;&nbsp; Berat badan :.........kg
                </p>
                <p>a. Riwayat alergi: 
                    <input type="checkbox"> Tidak 
                    <input type="checkbox"> Ya, Obat: <span>...............</span> 
                    <input type="checkbox"> Makanan: <span>...............</span> 
                    <input type="checkbox"> Lainnya: <span>...............</span>
                </p>
                
                <p>b. Penyakit penyerta:</p>
                    <p><input type="checkbox"> Diabetes Melitus <input type="checkbox"> Gangguan Fungsi Hepar
                    <input type="checkbox"> Hipertensi <input type="checkbox"> Gangguan Fungsi Ginjal<br>
                    <input type="checkbox"> Dekompensasi Kordis <input type="checkbox"> Gangguan Fungsi Paru
                    <input type="checkbox"> Pasca Infark Jantung <input type="checkbox"> Gangguan Pembekuan Darah<br>
                    <input type="checkbox"> Insufisiensi Koroner <input type="checkbox"> Lainnya: <span>...........</span></p>
                <h3>2. PEMERIKSAAN TAMBAHAN</h3>
                <p>a. E.K.G (rutin 40 tahun) : <span>.............................</span></p>
                <p>b. Thorax photo : <span>.............................</span></p>
                <p>c. Tes Fungsi Paru : <span>.............................</span></p>
                <p>d. Hasil Konsultasi I KA : <span>.............................</span></p>
                <p>e. Hasil Konsultasi Kardiologi : <span>.............................</span></p>
                
                <h3>3. HASIL LABORATORIUM</h3>
                <p>a. Hasil laboratorium rutin <b>(<i>harus diperiksa</i>)</b></p>
                <p>Hb: <span>.............</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gol. Darah: <span>.............</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Gula Darah: <span>.............</span></p>
                <p>Masa perdarahan: <span>.............</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Masa pembekuan: <span>.............</span></p>
                
                <p>b. Hasil laboratorium tambahan</p>
                <p>Ureum: <span>.............</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Lab. Lain: <span>.............</span></p>
                <p>Creatinine: <span>.............</span></p>
                
                <h3>4. PENGOBATAN SAAT INI</h3>
                <p>
                    <input type="checkbox"> Obat Hipertensi
                    <input type="checkbox"> Obat Jantung
                    <input type="checkbox"> Sedatine / Hypnotik
                    <input type="checkbox"> Obat D.M
                    <input type="checkbox"> Corti Costeroid
                
                </p>
                <p><b>Persetujuan persediaan darah	:</b>
                    <input type="checkbox"> Tidak
                    <input type="checkbox"> Ya, jumlah :....................
                </p>
                <p><b>Diisi oleh petugas Anestesi / Bedah Sentral</b></p>
                <p>
                     Premedikasi :................&nbsp;&nbsp;&nbsp;&nbsp; 	Rencana Anestesi  : .................. &nbsp;&nbsp;&nbsp;&nbsp; Kamar Operasi :............................ &nbsp;&nbsp;&nbsp;&nbsp;
                </p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Persetujuan Konsulen</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Dokter yang mengajukan</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
        </tr>
        
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.19.a/RI
                    </div>
               </div>
    </div>
</div>

</body>

</html>