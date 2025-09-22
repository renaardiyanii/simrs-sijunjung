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
                <h3>PERNYATAAN TINDAKAN RESTRAINT MEKANIK<br></h3>
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
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Diagnosa :</td>
                        <td>Pemeriksaan :</td>
                    </tr>
                </table>
                <p style="font-size: 13px;">Telah diinformasikan sebab / alasan dilakukan tindakan <i>RESTRAINT</i> (Pemasangan alat pembatas gerakan) kepada pasien / keluarga pasien sebagai berikut :</p>
               
                    <br><input type="checkbox"> Pasien membahayakan diri sendiri / orang lain / lingkungan
                    <br><input type="checkbox"> Mengupayakan pasien terhindar dari luka / jatuh / serangan dari pasien lain
                    <br><input type="checkbox"> Mengamankan pasien dari tempat / sumber stress
                    <br><input type="checkbox"> Lainnya: <span style="border-bottom: 1px solid black; width: 200px; display: inline-block;"></span>
                
                <ol>
                    <li>Selama tindakan <i>RESTRAINT</i> akan diobservasi tanda-tanda vital pasien secara intensif sambil diberikan medikasi yang optimal</li>
                    <li>Risiko dari tindakan <i>RESTRAINT</i> dapat melukai anggota gerak atas (tangan, lengan bawah), anggota gerak bawah (pergelangan kaki) bila tidak mengikuti prosedur</li>
                    <li>Selama pelaksanaan akan dipantau secara periodik sesuai dengan kondisi</li>
                </ol>
                
                <p style="font-size: 13px;">Saya yang bertanda tangan di bawah ini:</p>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%">Nama pasien / keluarga pasien </td>
                        <td width="70%">:</td>
                    </tr>
                    <tr>
                        <td width="30%">Hubungan dengan pasien  </td>
                        <td width="70%">:</td>
                    </tr>
                    <tr>
                        <td width="30%">Alamat rumah   </td>
                        <td width="70%">:</td>
                    </tr>
                </table>
                
                <p style="font-size: 13px;">Setelah membaca dan diterangkan tentang tindakan <i>RESTRAINT</i> dengan segala risiko dan komplikasinya, saya sudah memahami tindakan tersebut dan:</p>
                <input type="checkbox" name="persetujuan"> <b>SETUJU</b> &nbsp; <input type="checkbox" name="persetujuan"> <b>TIDAK SETUJU</b> dilakukan tindakan <i>RESTRAINT</i>.</p>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <p style="width: 100%; text-align: right; margin-top: 20px;">Tanah Badantuang, ................. Tgl: ................. Jam: .................</p>
                
                <table style="width: 100%; text-align: center; margin-top: 20px;">
                    <tr>
                        <td>Pasien / Keluarga Pasien</td>
                        <td>Saksi</td>
                        <td>DPJP</td>
                    </tr>
                    <tr>
                        <td style="padding-top: 40px;">(.................................)</td>
                        <td style="padding-top: 40px;">(.................................)</td>
                        <td style="padding-top: 40px;">(.................................)</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <div>
                
                <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.17.b5/RI
                    </div>
               </div>
    </div>
</div>
</body>