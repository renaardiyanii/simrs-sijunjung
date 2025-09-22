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
                <h3>PERNYATAAN PEMERIKSAAN RADIONUKLIR MENGGUNAKAN BAHAN KONTRAS / RADIOFARMAKA</h3>
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
            <td colspan="2"></td>
            <td >Halaman 1 dari 1</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
        <table border="0" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <td width="50%">Diagnosa :</td>
                <td width="50%">Pemeriksaan :</td>
            </tr>
        </table>
        <p><b>MENGGUNAKAN KONTRAS / RADIOFARMAKA JENIS :....................</b></p>
        <p><b>ISI INFORMASI :</b></p>
        <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th rowspan="2"><center>No.</center></th>
                <th rowspan="2"><center>PENJELASAN BAHAN KONTRAS</center></th>
                <th rowspan="2"><center>JENIS (√)</center></th>
                <th colspan="2"><center>TANDA TANGAN & NAMA</center></th>
            </tr>
            <tr>
                <th><center>PEMBERI INFORMASI</center></th>
                <th><center>PENERIMA INFORMASI</center></th>
            </tr>
            <tr>
                <td>1</td>
                <td>Pengertian Bahan kontras / Radiofarmaka</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Fungsi bahan kontras / radiofarmaka</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td rowspan="3">3</td>
                <td>Kemungkinana terjadi komplikasi : <br>a. komplikasi ringan</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>b. komplikasi sedang</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>c. komplikasi berat</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </table>
        
        <p>Yang bertanda tangan dibawah ini saya sebagai WALI : <input type="checkbox">Anak <input type="checkbox">istri <input type="checkbox">suami <input type="checkbox"> lainnya.................. dari nama pasien tersebut diatas </p>
        
        <table border="0" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <td>Nama :</td>
                <td>Pekerjaan :</td>
            </tr>
            <tr>
                <td>No KTP :</td>
                <td>Jenis kelamin : <input type="checkbox">Laki laki  <input type="checkbox">perempuan</td>
            </tr>
            <tr>
                <td>Alamat :</td>
                
            </tr>
        </table>
        <p style="font-size: 14px;">Setelah mendapatkan penjelasan dan diskusi mengenai pemeriksaan Radionuklir menggunakan bahan kontras / Radiofarmaka, maka dengan ini saya mengerti dan menyatakan <input type="checkbox"><b>MENYETUJUI</b><input type="checkbox"><b>MENOLAK</b> untuk dilakukan pemberian bahan kontras / Radiofarmaka tersebut serta segala resiko dan komplikasi yang mungkin terjadi</p>
        
       
        <br><br><br><br><br><br> <br><br><br><br><br><br> <br><br><br><br><br><br>
        <p style="text-align: right;">Tanah Badantung, .............................. Pukul : .......... WIB</p>
        <table width="100%">
            <tr>
                <td style="text-align: center;">Dokter<br><br><br>( ............................ )</td>
                <td style="text-align: center;">Petugas / saksi<br><br><br>( ............................ )</td>
                <td style="text-align: center;">Pasien / keluarga <br><br><br>( ............................ )</td>
                  </tr>
        </table><br><br>
          <p><b>CATATAN</p>
          <p>Beri tanda ceklis pada kolom yang dikerjakan</p>
          <p>Bila pasien tidak kompeten / tidak mau menerima informasi, maka penerima adalah wali / keluarga terdekat</p>
                       
        </td>
       </tr>
       
    </table>
                
</div>
</body>

</html>