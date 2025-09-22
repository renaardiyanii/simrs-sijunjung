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
                <h2><center>SURAT PERINTAH TUGAS</center></h2>
                <h4><center>Nomor :.../..../RSUD-SJJ/..../20--</center></h4>
                <p>Dasar :</p>
                <p>1. Peraturan Daerah No 6 Tahun 2016 Tentang SOTK RSUD Sijunjung</p>
                <p>2. DPA-OPD RSUD Sijunjung TA 20--</p>
                <br>
                <p><center><b>MENUGASKAN</b></center></p>
                <p>Kepada :</p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td><center>NO </center></td>
                        <td><center>NAMA </center></td>
                        <td><center>NIP </center></td>
                        <td><center>PANGKAT/GOL </center></td>
                        <td><center>JABATAN </center></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        <td>&nbsp;&nbsp;</td>
                        
                    </tr>
                </table>
                <p>Untuk merujuk pasien : <input type="checkbox">Umum <input type="checkbox">JKN</p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="30%" >Nama pasien </td>
                        <td width="70%" >:</td>
                    </tr>
                    <tr>
                        <td width="30%" >Nomor Kartu</td>
                        <td width="70%" >:</td>
                    </tr>
                    <tr>
                        <td width="30%" >Hari/Tanggal </td>
                        <td width="70%" >:</td>
                    </tr>
                    <tr>
                        <td width="30%" >Jam berangkat </td>
                        <td width="70%" >:</td>
                    </tr>
                    <tr>
                        <td width="30%" >Tujuan </td>
                        <td width="70%" >:</td>
                    </tr>
                    <tr>
                        <td width="30%" >Jam sampai ditujuan </td>
                        <td width="70%" >:</td>
                    </tr>
                </table>
                <p>Demikian surat Perintah Tugas ini dibuat untuk dapat dilaksanakan dengan penuh tanggung jawab.</p><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                           
                            <div style="width: 100%; text-align: right;">
                                <p style="margin: 5px 0;">Ditetapkan di Tanah badantuang,</p>
                                <p style="margin: 5px 0;">Pada tanggal,.......................</p>
                                <p style="margin: 5px 0;">a.n Direktur RSUD Sijunjung</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;">...........................</p>
                            </div>
                        </div><br><br>
                        <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">TTD</p>
                                <p style="margin: 5px 0;">Keluarga pasien</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">TTD dan STEMPEL</p>
                                <p style="margin: 5px 0;">Pejabat berwenang faskes rujukan</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;"></p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    </div>
</body>