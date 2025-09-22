<?php
$data = isset($penolakan_tindakan->formjson)?json_decode($penolakan_tindakan->formjson):'';
?>
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
                    <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
                    <td colspan="2" style="font-size:14px;"> Dokter Pelaksana Tindakan : <?= isset($data->question1->dokter)?$data->question1->dokter:'' ?></td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="font-size:14px;"> Pemberi Informasi : <?= isset($data->question1->informasi)?$data->question1->informasi:'' ?></td>
                    
                </tr>
                <tr>
                    <td colspan="2" style="font-size:14px;"> Penerima Informasi : <?= isset($data->question1->penerima)?$data->question1->penerima:'' ?></td>
                    
                </tr>
        </table>
        <br>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px; font-size:10px;">
                 <tr>
                    <td style="border: 1px solid black; padding: 8px; ">No</td>
                    <td style="border: 1px solid black; padding: 8px; ">Jenis Informasi</td>
                    <td style="border: 1px solid black; padding: 8px; ">ISI Informasi</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tanda (√)</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">1.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Diagnosis (WD dan DD)</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->diagnosis->iform)?$data->question2->diagnosis->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->diagnosis->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">2.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Dasar Diagnosis</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->dasar->iform)?$data->question2->dasar->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->dasar->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">3.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->tindakan->iform)?$data->question2->tindakan->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->tindakan->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">4.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Indikasi Tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->indikasi->iform)?$data->question2->indikasi->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->indikasi->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">5.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tata cara tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->tata_cara->iform)?$data->question2->tata_cara->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->tata_cara->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">6.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Tujuan Tindakan</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->tujuan_tindakan->iform)?$data->question2->tujuan_tindakan->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->tujuan_tindakan->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">7.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Komplikasi</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->komplikasi->iform)?$data->question2->komplikasi->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->komplikasi->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">8.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Prognosis</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->prognosis->iform)?$data->question2->prognosis->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->prognosis->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; ">9.</td>
                    <td style="border: 1px solid black; padding: 8px; ">Alternatif & Risiko</td>
                    <td style="border: 1px solid black; padding: 8px; "><?= isset($data->question2->alternatif->iform)?$data->question2->alternatif->iform:'' ?></td>
                    <td style="border: 1px solid black; padding: 8px;text-align:center "><?= isset($data->question2->alternatif->ceklist)?'√':'' ?></td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid black; padding: 8px; ">Dengan ini menyatakan bahwa saya telah menerangkan ha-hal diatas secara benar  dan jelas <br>serta memberi kesempatan untuk bertanya dan atau berdiskusi</td>
                    <td style="border: 1px solid black;">
                            <img src="<?= isset($data->ttd_dokter)?$data->ttd_dokter:'' ?>" alt="img" height="50px" width="50px"><br>
                        (Ttd Dokter)
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="border: 1px solid black; padding: 8px; ">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana diatas <br>dan telah memahaminya</td>
                    <td style="border: 1px solid black; padding: 8px; ">
                        <img src="<?= isset($data->ttd_pasien)?$data->ttd_pasien:'' ?>" alt="img" height="50px" width="50px"><br>
                        (Ttd Pasien)
                    </td>
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
                    <td style="border: 1px solid black; padding: 5px; font-size:12px; "><p>Yang bertanda tangan dibawah ini, Nama &nbsp;&nbsp;<?= isset($data->bertanda_tangan->nama)?$data->bertanda_tangan->nama:'........................' ?>&nbsp;&nbsp; Umur <?= isset($data->bertanda_tangan->umur)?$data->bertanda_tangan->umur:'....................................' ?> &nbsp;&nbsp; tahun <BR>
                    Alamat&nbsp;&nbsp; <?= isset($data->bertanda_tangan->alamat)?$data->bertanda_tangan->alamat:'........................' ?> <br>
                    Dengan ini menyatakan <b>MENOLAK</b> untuk dilakukan tindakan&nbsp;&nbsp;<?= isset($data->question5->tindakan)?$data->question5->tindakan:'........................' ?><br>Terhadap saya/&nbsp;&nbsp;<?= isset($data->question5->terhadap)?$data->question5->terhadap:'........................' ?>&nbsp;&nbsp;saya,yang bernama&nbsp;&nbsp;<?= isset($data->question5->bernama)?$data->question5->bernama:'........................' ?><br>
                    Tgl.Lahir&nbsp;&nbsp;<?= isset($data->question5->tgl_lahir)?$data->question5->tgl_lahir:'........................' ?>&nbsp;&nbsp;Alamat&nbsp;&nbsp;<?= isset($data->question5->alamat)?$data->question5->alamat:'........................' ?><br>Dirawat di&nbsp;&nbsp;<?= isset($data->question5->dirawat)?$data->question5->dirawat:'........................' ?>&nbsp;&nbsp;No.RM&nbsp;&nbsp;<?= isset($data->question5->norm)?$data->question5->norm:'........................' ?><BR>
                    <P>Saya memahami perlunya tindakan tersebut sebagaimana telah dijelaskan kepada saya, termasuk risiko dan komplikasi yang mungkin terjadi. saya juga menyadari oleh karena itu kedokteran bukanlah ilmu pasti, maka keberhasilan
                    tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan yang Maha Esa.
                    </P>
                    </td>
                </tr>
                
        </table>

        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p>Tanah Badantung, <?= isset($penolakan_tindakan->tgl_input) ? date('d-m-Y', strtotime($penolakan_tindakan->tgl_input)) : '' ?> Jam <?= isset($penolakan_tindakan->tgl_input) ? date('h:i', strtotime($penolakan_tindakan->tgl_input)) : '' ?></p>
                <p>Saksi</p>
                 <img src="<?= isset($data->ttd1)?$data->ttd1:'' ?>" alt="img" height="50px" width="50px"><br>
                <span>(.............)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p><br></p>
                <p>Yang menyatakanPasien/Wali</p>
                 <img src="<?= isset($data->ttd2)?$data->ttd2:'' ?>" alt="img" height="50px" width="50px"><br>
                <span>(.............)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p><br></p>
                <p>Dokter</p>
                 <img src="<?= isset($data->ttd3)?$data->ttd3:'' ?>" alt="img" height="50px" width="50px"><br>
                <span>(.............)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p><br></p>
                <p>Saksi </p>
                 <img src="<?= isset($data->question7)?$data->question7:'' ?>" alt="img" height="50px" width="50px"><br>
                <span>(.............)</span>
            </div>
        </div>



</div>
</body>
</html>
