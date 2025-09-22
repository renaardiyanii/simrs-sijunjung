<?php 
$data = isset($jatuh_neonatus->formjson)?json_decode($jatuh_neonatus->formjson):'';
// var_dump($data);die;
?>

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
                <h3>PENGKAJIAN RISIKO JATUH PADA PASIEN NEONATUS</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 1</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Tanggal : <?= isset($data->question1)?date('d/m/Y',strtotime($data->question1)):'' ?></td>
                        <td>Jam : <?= isset($data->question1)?date('h:i',strtotime($data->question1)):'' ?></td>
                    </tr>
                    <tr>
                        <td>Diagnosa : <?= isset($data->question2)?$data->question2:'' ?></td>
                        <td>Ruangan : <?= isset($data->question3)?$data->question3:'' ?></td>
                    </tr>
                </table>
                <p><b>Semua Neonatus dikategorikan berisiko jatuh</b></p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>INTERVENSI </td>
                        <td> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item1", $data->question10[0]->question4)?'checked':'':'') ?>>  Pasang gelang risiko jatuh
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item2", $data->question10[0]->question4)?'checked':'':'') ?>> Pasang tanda risiko jatuh pada box / incubator
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item3", $data->question10[0]->question4)?'checked':'':'') ?>>   Orientasi ruangan pada orang tua / keluarga
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item4", $data->question10[0]->question4)?'checked':'':'') ?>> Dekatkan box bayi dengan ibu
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item5", $data->question10[0]->question4)?'checked':'':'') ?>>Pastikan selalu ada pendamping
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item6", $data->question10[0]->question4)?'checked':'':'') ?>>Pastikan lantai dan alas kaki tidak licin
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item7", $data->question10[0]->question4)?'checked':'':'') ?>>Kontrol rutin oleh perawat / bidan
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item8", $data->question10[0]->question4)?'checked':'':'') ?>>   Bila dirawat dalam incubator, pastikan semua jendela terkunci
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question4)?in_array("item9", $data->question10[0]->question4)?'checked':'':'') ?>>   Edukasi orang tua / keluarga
                        </td>
                        <tr>
                            <td colspan="2">EDUKASI YANG DIBERIKAN
                                <br><p><input type="checkbox" <?= (isset($data->question10[0]->question5)?in_array("item1", $data->question10[0]->question5)?'checked':'':'') ?>>Tempatkan bayi pada tempat yang aman</p>
                                <p><input type="checkbox" <?= (isset($data->question10[0]->question5)?in_array("item2", $data->question10[0]->question5)?'checked':'':'') ?>>Teknik menggendong bayi</p>
                                <p><input type="checkbox" <?= (isset($data->question10[0]->question5)?in_array("item3", $data->question10[0]->question5)?'checked':'':'') ?>> Cara membungkus bayi</p>
                                <p><input type="checkbox" <?= (isset($data->question10[0]->question5)?in_array("item4", $data->question10[0]->question5)?'checked':'':'') ?>>Segera istirahat apabila merasa lelah dan tempatkan bayi pada boxnya</p>
                                <p><input type="checkbox" <?= (isset($data->question10[0]->question5)?in_array("item5", $data->question10[0]->question5)?'checked':'':'') ?>>Libatkan keluarga untuk mendampingi atau segera panggil perawat / bidan jika dibutuhkan </p>
                            </td>
                        </tr>
                    <tr>
                        <td>SASARAN EDUKASI </td>
                        <td> <input type="checkbox" <?php echo isset($data->question10[0]->question6)? $data->question10[0]->question6 == "item1" ? "checked":'':'' ?>>  Ibu
                            <br> <input type="checkbox" <?php echo isset($data->question10[0]->question6)? $data->question10[0]->question6 == "item2" ? "checked":'':'' ?>> Keluarga lain
                            <br> <input type="checkbox" <?php echo isset($data->question10[0]->question6)? $data->question10[0]->question6 == "item3" ? "checked":'':'' ?>>  Bapak
                            <br> <input type="checkbox" <?php echo isset($data->question10[0]->question6)? $data->question10[0]->question6 == "item4" ? "checked":'':'' ?>> Wali
                            <br> <input type="checkbox" <?php echo isset($data->question10[0]->question6)? $data->question10[0]->question6 == "other" ? "checked":'':'' ?>>Lainnya <?= isset($data->question10[0]->{'question6-Comment'})?$data->question10[0]->{'question6-Comment'}:'' ?>
                         </td>
                    </tr>
                    <tr>
                        <td>EVALUASI</td>
                        <td> <input type="checkbox" <?= (isset($data->question10[0]->question7)?in_array("item1", $data->question10[0]->question7)?'checked':'':'') ?>>  Memahami dan mampu menjelaskan kembali
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question7)?in_array("item2", $data->question10[0]->question7)?'checked':'':'') ?>>  Mampu mendemontrasikan
                            <br> <input type="checkbox" <?= (isset($data->question10[0]->question7)?in_array("item3", $data->question10[0]->question7)?'checked':'':'') ?>>    Perlu edukasi ulang
                         </td>
                    </tr>
                </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Keluarga</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="<?= isset($data->question8)?$data->question8:'' ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question9)?$data->question9:'' ?></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                               <p style="margin: 5px 0;">Petugas</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="" alt=""></p>
                                <p style="margin: 5px 0;">.................................</p>
                            </div>
                        </div>
            </td>
       </tr>
    </table>
    <div style="margin-left:570px; font-size:12px;">
                    Rev.I.I/2018/RM.06.j3/RI-GN
                </div>
</div>
    </div>
</body>