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
            <h3>FOORMULIR SERAH TERIMA <br>(HAND OVER) ANTAR SHIFT</h3>
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
                        <td><center>PAGI</center></td>
                        <td><center>SORE</center></td>
                        <td><center>MALAM</center></td>
                    </tr>
                    <tr>
                        <td>
                            <br>Situation: 
                            <br><br><br>Background :
                            <br><br>Dx Medis :
                            <br><br>DPJP : Dr.
                            <br><br>Assement :
                            <br><br>Kesadaran : &nbsp; GCS :
                            <br><br>TTV :TD ........mmhg &nbsp;Nadi :.........x/mnt
                            <br><br>Suhu : .........C &nbsp; RR : .........x/mnt &nbsp; Vas :.......
                            <br><br>Oksigen : .......L/mnt &nbsp; Infus:.........tts/mnt\
                            <br><br>Transfusi : .........tts/1 &nbsp;
                            <br><br>katheter : <input type="checkbox">Ya <input type="checkbox">TINDAKAN<br><br>
                            Makan/minum :
                           <br><br>Toileting :
                           <br><br>Aktivitas / gerak :
                           <br><br>Skore jatuh :
                           <br><br>Rekomendation :
                            <br><br><br>
                        </td>
                        <td>
                            <br>Situation: 
                            <br><br><br>Background :
                            <br><br>Dx Medis :
                            <br><br>DPJP : Dr.
                            <br><br>Assement :
                            <br><br>Kesadaran : &nbsp; GCS :
                            <br><br>TTV :TD ........mmhg &nbsp;Nadi :.........x/mnt
                            <br><br>Suhu : .........C &nbsp; RR : .........x/mnt &nbsp; Vas :.......
                            <br><br>Oksigen : .......L/mnt &nbsp; Infus:.........tts/mnt\
                            <br><br>Transfusi : .........tts/1 &nbsp;
                            <br><br>katheter : <input type="checkbox">Ya <input type="checkbox">TINDAKAN<br><br>
                            Makan/minum :
                           <br><br>Toileting :
                           <br><br>Aktivitas / gerak :
                           <br><br>Skore jatuh :
                           <br><br>Rekomendation :
                            <br><br><br>
                        </td>
                        <td>
                            <br>Situation: 
                            <br><br><br>Background :
                            <br><br>Dx Medis :
                            <br><br>DPJP : Dr.
                            <br><br>Assement :
                            <br><br>Kesadaran : &nbsp; GCS :
                            <br><br>TTV :TD ........mmhg &nbsp;Nadi :.........x/mnt
                            <br><br>Suhu : .........C &nbsp; RR : .........x/mnt &nbsp; Vas :.......
                            <br><br>Oksigen : .......L/mnt &nbsp; Infus:.........tts/mnt\
                            <br><br>Transfusi : .........tts/1 &nbsp;
                            <br><br>katheter : <input type="checkbox">Ya <input type="checkbox">TINDAKAN<br><br>
                            Makan/minum :
                           <br><br>Toileting :
                           <br><br>Aktivitas / gerak :
                           <br><br>Skore jatuh :
                           <br><br>Rekomendation :
                            <br><br><br><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td>Pemberi operan<br><br><br><br><br><br></td>
                        <td>Pemberi operan <br><br><br><br><br><br></td>
                        <td>Pemberi operan <br><br><br><br><br><br></td>
                    </tr>
                    <tr>
                        <td>Penerima operan <br><br><br><br><br><br></td>
                        <td>Penerima operan <br><br><br><br><br><br></td>
                        <td>Penerima operan <br><br><br><br><br><br></td>
                    </tr>
                   

      
    </table>
    </div>
</body>