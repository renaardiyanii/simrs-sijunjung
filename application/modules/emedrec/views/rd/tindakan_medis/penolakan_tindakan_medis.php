<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
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
                <h3>PENOLAKAN TINDAKAN MEDIS</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
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
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                
                <tr>
                    <td>
                        <center>
                            <span style="font-size:17px;font-weight:bold;">PEMBERIAN INFORMASI</span><br>
                            
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:17px;"> Dokter Pelaksana Tindakan :</td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="font-size:17px;"> Pemberi Informasi :</td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="font-size:17px;"> Penerima Informasi :</td>
                    
                </tr>
        </table>
        <br>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:12px;">
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; ">No</td>
                    <td style="border: 1px solid black; padding: 8px; ">Jenis Informasi</td>
                    <td style="border: 1px solid black; padding: 8px; ">ISI Informasi</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tanda (√)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">1.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Diagnosis (WD dan DD)</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">2.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Dasar Diagnosis</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">3.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">4.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Indikasi Tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">5.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tata cara tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">6.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tujuan Tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">7.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Komplikasi</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">8.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Prognosis</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">9.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Alternatif & Risiko</td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                    <td style="border: 1px solid black; padding: 8px; "></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid black; padding: 8px; ">Dengan ini menyatakan bahwa saya telah menerangkan ha-hal diatas secara benar  dan jelas <br>serta memberi kesempatan untuk bertanya dan atau berdiskusi</td>
                    <td style="border: 1px solid black; padding: 8px; ">(Ttd Dokter)</td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid black; padding: 8px; ">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas <br>dan telah memahaminya</td>
                    <td style="border: 1px solid black; padding: 8px; ">(Ttd Pasien)</td>
                </tr>
                
        </table>
        <br>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">
                        <center>
                            <span style="font-size:17px;font-weight:bold;">PENOLAKAN</span><br>
                            
                        </center>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 5px; font-size:12px; "><p>Yang bertanda tangan dibawah ini, Nama____________________ Umur _____________________tahun<BR>
                    Alamat _______________________________________________________<br></p><br>
                    Dengan ini menyatakan <b>MENOLAK</b> untuk dilakukan tindakan__________________________<br>Terhadap saya/__________________________saya,yang bernama___________________________<br>
                    Tgl.Lahir____________________________________Alamat._________________________________.<br>Dirawat di_____________________________________________No.RM______________________________<BR>
                    <P>Saya memahami perlunya tindakan tersebut sebagaimana telah dijelaskan kepada saya, termasuk risiko dan komplikasi yang mungkin terjadi. saya juga menyadari oleh karena itu kedokteran bukanlah ilmu pasti, maka keberhasilan
                    tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan yang Maha Esa.
                    </P>
                    </td>
                </tr>
                
        </table>

        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
            <p>Tanah Badantung, <?= isset($data_daftar_ulang->tgl_kunjungan) ? date('d-m-Y', strtotime($data_daftar_ulang->tgl_kunjungan)) : '' ?></p>
                <p>Saksi</p>
                <br><br><br>
                <span>(___)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p>Yang menyatakan <br> Pasien/Wali</p>
                <br><br><br>
                <span>(___)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p>Dokter</p>
                <br><br><br>
                <span>(___)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
               
                <p>Saksi </p>
                <br><br><br>
                <span>(___)</span>
            </div>
        </div>



</div>
</body>
</html>
