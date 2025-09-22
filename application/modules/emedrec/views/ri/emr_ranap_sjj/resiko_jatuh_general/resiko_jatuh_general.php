<?php 
$data = isset($resiko_jatuh_new->formjson)?json_decode($resiko_jatuh_new->formjson):'';
// var_dump($data);die()                                  
?>

<!DOCTYPE html>
<html>

<head>
<style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            font-size: 12px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .box {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
        }
        .highlight {
            font-weight: bold;
        }
    </style>

</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
            
                <tr>
                    <td style="text-align: left;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                    </td>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RUMAH SAKIT UUMUM DAERAH AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Website : rsud.sijunjung.go.id, </label><label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
        <h3><center>PENILAIAN PENGKAJIAN PASIEN RESIKO JATUH</center></h3>
      <table border="0" width="100%" style="margin-top:0px">
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td width="15%">Nama</td>
                        <td width="35%">: <?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                        <td width="20%">Tanggal Lahir</td>
                        <td width="35%">: <?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?></td>
                    </tr>
                    <tr>
                        <td width="15%">NO RM</td>
                        <td width="35%">: <?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                        <td width="20%">Tanggal Berobat</td>
                        <td width="35%">: <?= isset($data->question6)?$data->question6:'' ?></td>
                    </tr>
                </table>
                <p>1. Pengkajian
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>No</td>
                        <td><center>Penilaian / Pengkajian</center></td>
                        <td>Ya</td>
                        <td>Tidak</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Cara berjalan pasien (salah satu atau lebih) <br> a. Tidak seimbang / sempoyongan/ limbung <br>b. Jalan dengan menggunakan alat bantu (kruk, tripot, kursi roda, orang lain)</td>
                        <td><input type="checkbox" <?php echo isset($data->question1->item1->column1)? $data->question1->item1->column1 == "item1" ? "checked":'':'' ?>></td>
                        <td><input type="checkbox" <?php echo isset($data->question1->item1->column1)? $data->question1->item1->column1 == "item2" ? "checked":'':'' ?>></td>
                    </tr>
                     <tr>
                        <td>2</td>
                        <td>Menopang saat akan duduk : tampak memegang pinggiran kursi atau meja / benda <br> lain sebagai penopang saat akan duduk</td>
                        <td><input type="checkbox"<?php echo isset($data->question1->item2->column1)? $data->question1->item2->column1 == "item1" ? "checked":'':'' ?> ></td>
                        <td><input type="checkbox"<?php echo isset($data->question1->item2->column1)? $data->question1->item2->column1 == "item2" ? "checked":'':'' ?> ></td>
                    </tr>
                 </table>
                 <p>2. Hasil</p>
                  <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>No</td>
                        <td><center>Hasil</center></td>
                        <td><center>Penilaian/Pengkajian</center></td>
                        <td>Keterangan</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tidak beresiko</td>
                        <td>Tidak ditemukan a & b</td>
                        <td><input type="checkbox"<?= (isset($data->question2->item1->column1) && in_array("item1", (array)$data->question2->item1->column1)) ? "checked" : "" ?> ></td>
                    </tr>
                     <tr>
                        <td>2</td>
                        <td>Risiko rendah</td>
                        <td>Ditemukan salah satu dari a/b</td>
                        <td><input type="checkbox"<?= (isset($data->question2->item2->column1) && in_array("item1", (array)$data->question2->item2->column1)) ? "checked" : "" ?> ></td>
                    </tr>
                     <tr>
                        <td>2</td>
                        <td>Risiko Tinggi</td>
                        <td>Ditemukan a & b</td>
                        <td><input type="checkbox"<?= (isset($data->question2->item3->column1) && in_array("item1", (array)$data->question2->item3->column1)) ? "checked" : "" ?> ></td>
                    </tr>
                 </table>
                 <p>Tindakan</p>
                 <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>No</td>
                        <td><center>Hasil Kajian</center></td>
                        <td><center>Tindakan</center></td>
                        <td>Ya / Tidak</td>
                        <td>Nama petugas </td>
                        <td>Paraf petugas </td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Tidak beresiko</td>
                        <td>Tidak ada tindakan</td>
                        <td><input type="checkbox" <?php echo isset($data->question3->item1->column1)? $data->question3->item1->column1 == "item1" ? "checked":'':'' ?>>Ya <input type="checkbox"<?php echo isset($data->question3->item1->column1)? $data->question3->item1->column1 == "item2" ? "checked":'':'' ?> >Tidak</td>
                        <td><?= isset($data->question3->item1->column2)?nl2br($data->question3->item1->column2):'' ?></td>
                        <td> <img src="<?= isset($data->question3->item1->column3) ? $data->question3->item1->column3 : '' ?>" alt="TTD Dokter" style="width:100px; height:auto;"></td>
                    </tr>
                     <tr>
                        <td>2</td>
                        <td>Tidak rendah</td>
                        <td>Edukasi</td>
                        <td><input type="checkbox" <?php echo isset($data->question3->item2->column1)? $data->question3->item2->column1 == "item1" ? "checked":'':'' ?>>Ya <input type="checkbox"<?php echo isset($data->question3->item2->column1)? $data->question3->item2->column1 == "item2" ? "checked":'':'' ?> >Tidak</td>
                        <td><?= isset($data->question3->item2->column2)?nl2br($data->question3->item2->column2):'' ?></td>
                        <td> <img src="<?= isset($data->question3->item2->column3) ? $data->question3->item2->column3 : '' ?>" alt="TTD Dokter" style="width:100px; height:auto;"></td>
                    </tr>
                     <tr>
                        <td>3</td>
                        <td>Tidak tinggi</td>
                        <td>Pasang pita kuning dan edukasi</td>
                        <td><input type="checkbox" <?php echo isset($data->question3->item3->column1)? $data->question3->item3->column1 == "item1" ? "checked":'':'' ?>>Ya <input type="checkbox"<?php echo isset($data->question3->item3->column1)? $data->question3->item3->column1 == "item2" ? "checked":'':'' ?> >Tidak</td>
                        <td><?= isset($data->question3->item3->column2)?nl2br($data->question3->item3->column2):'' ?></td>
                        <td> <img src="<?= isset($data->question3->item3->column3) ? $data->question3->item3->column3 : '' ?>" alt="TTD Dokter" style="width:100px; height:auto;"></td>
                    </tr>
                 </table>
                  <div style="width: 100%; text-align: left;">
                            <p><br></p>
                            <p>Petugas</p>
                                  <p><img width="90px" src="<?= isset($data->question4) ? $data->question4 : '' ?>"></p>
                                   <p>(<?= isset($data->question5) ? $data->question5 : '' ?>)</p>
                            </div> 
            </td>
       </tr>
       

    </div>
    </div>
    </body>
</html>