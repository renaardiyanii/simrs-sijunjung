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
                <h3>PERNYATAAN TINDAKAN ANESTESI DAN SEDASI</h3>
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
        <td colspan="4">
            <p>Ruang : ............................................</p>
            <p>Diagnosa Klinis : ............................................</p>
            <p>Rencana Tindakan : ............................................</p>
            
            <p>JENIS ANESTESIA : ............................................</p>
            <p>PEMBERI INFORMASI : ............................................</p>
            
            <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
                <tr>
                    <td rowspan="2"><center>No.</center></td>
                    <td rowspan="2"><center>PENJELASAN ANESTESIA</center></td>
                    <td rowspan="2"><center>JELAS (√)</td>
                    <td colspan="2"><center>TANDATANGAN & NAMA</center></td>
                </tr>
                <tr>
                   
                    <td><center>PEMBERI INFORMASI</center></td>
                    <td><center>PENERIMA INFORMASI</center></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Tindakan Anestesi & Sedasi :</td>
                    <td></td>
                    <td rowspan="10"></td>
                    <td rowspan="10"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>a. Anestesi Umum</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>b. Anestesi Spinal / Epidural</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>c. Blok Perifer</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>d. Sedasi (<input type="checkbox"> Ringan <input type="checkbox"> Sedang <input type="checkbox">Berat )</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>e. Pendampingan Anestesi</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Tujuan</td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>3</td>
                    <td>Indikasi Tindakan</td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>4</td>
                    <td>Prognosis</td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td>5</td>
                    <td>Kemungkinan Komplikasi / Risiko</td>
                    <td></td>
                    
                </tr>
            </table>
            
            <p>Yang bertanda tangan di bawah ini saya sebagai WALI: <input type="checkbox"> Anak <input type="checkbox">Istri <input type="checkbox"> Suami</p>
            <p><input type="checkbox"> Lainnya: ................................ dari nama pasien tersebut di atas</p>
            <p>1. Nama : ............................................</p>
            <p>2. No. KTP : ............................................</p>
            <p>3. Pekerjaan : ............................................ <input type="checkbox"> Laki-laki <input type="checkbox"> Perempuan</p>
            <p>4. Alamat : ............................................</p>
            
            <h3 style="text-align: center;">PERNYATAAN</h3>
            <p>Setelah mendapatkan penjelasan dan diskusi mengenai tindakan anestesi / sedasi, maka dengan ini saya mengerti dan menyatakan <b style="color: black;"><input type="checkbox">  MENYETUJUI</b> , <input type="checkbox">  <b style="color: black;">MENOLAK</b> untuk dilakukan anestesi / sedasi tersebut serta segala risiko dan komplikasi yang mungkin terjadi.</p>
            <br><br><br><br><br><br>
            <p style="text-align: right;">Tanah Badantung</b>, ............................................</p>
            
            <table width="100%">
                <tr>
                    <td style="text-align: center;">Dokter<br><br><br><br>( ............................ )</td>
                    <td style="text-align: center;">Petugas / Saksi<br><br><br><br>( ............................ )</td>
                    <td style="text-align: center;">Pasien / Keluarga<br><br><br><br>( ............................ )</td>
                </tr>
            </table>
        </td>
       </tr>
       
    </table>
       </tr>
    </div>
</div>
</body>

</html>