<?php 
$data = isset($monitoring_transfusi_darah->formjson)?json_decode($monitoring_transfusi_darah->formjson):'';
// var_dump($data);die();
?>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<style>
    .page {
        page-break-inside: avoid;
    }
    .sheet {
        margin-bottom: 20px;
    }
</style>
<body class="A4 landscape">
    <!-- Halaman Pertama -->
    <div class="A4 sheet padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <!-- Header dan informasi pasien -->
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
                    <h3>MONITORING TRANSFUSI DARAH</h3>
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
        </table>
        
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
            <!-- Konten monitoring transfusi darah -->
              <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                        <tr>
                            <td colspan="2">Diagnosis : <?= isset($data->question1)?$data->question1:'' ?></td>
                            <td colspan="2">Golongan Darah Pasien :  <?= isset($data->question2)?$data->question2:'' ?></td>
                        </tr>
                        
                        <tr>
                            <td><b>INTRUKSI DOKTER (Diisi oleh dokter)</b>
                                <br>Jenis darah volume yang diminta : <?= isset($data->question3)?$data->question3:'' ?>
                                <br><br><br>Alasan transfusi : <?= isset($data->question5)?$data->question5:'' ?>
                                <br><br><br>Rencana pemberian transfusi : <?= isset($data->question4)?$data->question4:'' ?>
                                <br><br><br>Pemberi Pre-medikasi : <?= isset($data->question6)?$data->question6:'' ?>
                                <br><br><br>Kecepatan pemberian transfusi : <?= isset($data->question8)?$data->question8:'' ?>
                                <br><br><br>Target pemberi transfusi : <?= isset($data->question8)?$data->question8:'' ?>
                                <br><br><br>Pemeriksaan untuk monitoring : <?= isset($data->question9)?$data->question9:'' ?>
                                <br><br><br> Laporkan segera, bila terjadi reaksi transfusi : 
                                <br><br><input type="checkbox" <?= (isset($data->question10)?in_array("item1", $data->question10)?'checked':'':'') ?>>1. Gatal
                                <br><input type="checkbox" <?= (isset($data->question10)?in_array("item2", $data->question10)?'checked':'':'') ?>>2. Perubahan tanda virtual
                                <br><input type="checkbox" <?= (isset($data->question10)?in_array("item3", $data->question10)?'checked':'':'') ?>>3. Kemerahan
                                <br><input type="checkbox" <?= (isset($data->question10)?in_array("item4", $data->question10)?'checked':'':'') ?>>4. jantung berdebar debar
                                <br><input type="checkbox" <?= (isset($data->question10)?in_array("item5", $data->question10)?'checked':'':'') ?>>5. sesak
                            </td>
                            <td><b>KANTONG DARAH : <?= isset($data->question82)?$data->question82:'' ?></b>
                                <br>Nomor STOK :  <?= isset($data->question13)?$data->question13:'' ?>
                                <br><br><br>Tgl Kadaluarsa :  <?= isset($data->question14)?$data->question14:'' ?>
                                <br><br><br>Jenis Darah :
                                <br><br><br>Gol darah kantong <br><input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>>A
                                <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>>B<input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item3" ? "checked":'':'' ?>>AB<input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item4" ? "checked":'':'' ?>>O
                                <br><br><br>Volume darah : <?= isset($data->question15)?$data->question15:'' ?> cc
                            <br><br> <b>KANTONG DARAH : <?= isset($data->question83)?$data->question83:'' ?></b>
                                <br>Nomor STOK :
                                <br><br><br>Tgl Kadaluarsa  <?= isset($data->question17)?$data->question17:'' ?>:
                                <br><br><br>Jenis Darah :
                                <br><br><br>Gol darah kantong <br><input type="checkbox" <?php echo isset($data->question18)? $data->question18 == "item1" ? "checked":'':'' ?>>A
                                <input type="checkbox" <?php echo isset($data->question18)? $data->question18 == "item2" ? "checked":'':'' ?>>B<input type="checkbox" <?php echo isset($data->question18)? $data->question23 == "item3" ? "checked":'':'' ?>>AB<input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item4" ? "checked":'':'' ?>>O
                                <br><br><br>Volume darah : <?= isset($data->question19)?$data->question19:'' ?> cc
                            
                            </td>
                            <td><b>IDENTIFIKASI</b>
                                <br><br> Identifikasi kantong : 
                                <br><input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item1" ? "checked":'':'' ?>>Sesuai
                                <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item2" ? "checked":'':'' ?>>Tidak sesuai
                                <br><br> Identifikasi pasien :
                                <br><input type="checkbox" <?php echo isset($data->question21)? $data->question21 == "item1" ? "checked":'':'' ?>>Sesuai
                                <input type="checkbox" <?php echo isset($data->question21)? $data->question21 == "item2" ? "checked":'':'' ?>>Tidak sesuai
                                <br><br> Keadaan kantong darah :
                                <br><input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item1" ? "checked":'':'' ?>>Baik
                                <input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item2" ? "checked":'':'' ?>>Tidak Baik
                                <br>Pelaksana identifikasi :
                                <br>Nama : <?= isset($data->question25->text1)?$data->question25->text1:'' ?>
                                <br><br>Tanda tangan  
                                <br><img width="60px" style="text-align:center" src="<?= isset($data->question27)?$data->question27:'' ?>" alt=""><br><br>
                                <b>IDENTIFIKASI</b>
                                <br><br> Identifikasi kantong :
                                <br><input type="checkbox"  <?php echo isset($data->question28)? $data->question28 == "item1" ? "checked":'':'' ?>>Sesuai
                                <input type="checkbox"  <?php echo isset($data->question28)? $data->question28 == "item2" ? "checked":'':'' ?>>Tidak sesuai
                                <br><br> Identifikasi pasien :
                                <br><input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item1" ? "checked":'':'' ?> >Sesuai
                                <input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item2" ? "checked":'':'' ?>>Tidak sesuai
                                <br><br> Keadaan kantong darah :
                                <br><input type="checkbox" <?php echo isset($data->question30)? $data->question30 == "item1" ? "checked":'':'' ?>>Baik
                                <input type="checkbox" <?php echo isset($data->question30)? $data->question30 == "item2" ? "checked":'':'' ?>>Tidak Baik
                                <br>Pelaksana identifikasi :
                                <br>Nama : <?= isset($data->question31->text1)?$data->question31->text1:'' ?>
                                <br><br>Tanda tangan
                                <br><img width="60px" style="text-align:center" src="<?= isset($data->question32)?$data->question32:'' ?>" alt=""><br><br>
                            </td>
                            <td>Tanggal & Jam Transfusi <?= isset($data->question33)?$data->question33:'' ?>
                                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                                    <tr>
                                        <td colspan="7"><b><center>KONTROL VITAL SIGN</center></b></td>
                                    </tr>
                                    <tr>
                                        <td>NO</td>
                                        <td>Kondisi</td>
                                        <td>Jam</td>
                                        <td>TD</td>
                                        <td>HR</td>
                                        <td>T</td>
                                        <td>Reaksi +/-</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Sebelum transfusi</td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item1->column1) ? $data->question48[0]->question34->item1->column1 : '' ?> </td>                                    </td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item1->column2) ? $data->question48[0]->question34->item1->column2 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item1->column3) ? $data->question48[0]->question34->item1->column3 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item1->column4) ? $data->question48[0]->question34->item1->column4 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item1->column5) ? $data->question48[0]->question34->item1->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>15 Menit pertama transfusi</td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item2->column1) ? $data->question48[0]->question34->item2->column1 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item2->column2) ? $data->question48[0]->question34->item2->column2 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item2->column3) ? $data->question48[0]->question34->item2->column3 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item2->column4) ? $data->question48[0]->question34->item2->column4 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item2->column5) ? $data->question48[0]->question34->item2->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>20 menit pertama transfusi</td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item3->column1) ? $data->question48[0]->question34->item3->column1 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item3->column2) ? $data->question48[0]->question34->item3->column2 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item3->column3) ? $data->question48[0]->question34->item3->column3 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item3->column4) ? $data->question48[0]->question34->item3->column4 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item3->column5) ? $data->question48[0]->question34->item3->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Setelah transfusi</td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item4->column1) ? $data->question48[0]->question34->item4->column1 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item4->column2) ? $data->question48[0]->question34->item4->column2 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item4->column3) ? $data->question48[0]->question34->item4->column3 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item4->column4) ? $data->question48[0]->question34->item4->column4 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($data->question48[0]->question34->item4->column5) ? $data->question48[0]->question34->item4->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">ket jenis reaksi transfusi : <?= isset($data->question35)?$data->question35:'' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Nama : <?= isset($data->question36)?$data->question36:'' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Tanda tangan : <img width="50" style="text-align:center" src="<?= isset($data->question37)?$data->question37:'' ?>" alt=""></td>
                                    </tr>
                                </table>
                                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                                    <tr>
                                        <td colspan="7">Tanggal & Jam transfusi : <?= isset($data->question43)?$data->question43:'' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7"><b><center>KONTROL VITAL SIGN</center></b></td>
                                    </tr>
                                    <tr>
                                        <td>NO</td>
                                        <td>Kondisi</td>
                                        <td>Jam</td>
                                        <td>TD</td>
                                        <td>HR</td>
                                        <td>T</td>
                                        <td>Reaksi +/-</td>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Sebelum transfusi</td>
                                        <td><?= isset($data->question44->item1->column1) ? $data->question44->item1->column1 : '' ?></td>
                                        <td><?= isset($data->question44->item1->column2) ? $data->question44->item1->column2 : '' ?></td>
                                        <td><?= isset($data->question44->item1->column3) ? $data->question44->item1->column3 : '' ?></td>
                                        <td><?= isset($data->question44->item1->column4) ? $data->question44->item1->column4 : '' ?></td>
                                        <td><?= isset($data->question44->item1->column5) ? $data->question44->item1->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>15 Menit pertama transfusi</td>
                                        <td><?= isset($data->question44->item2->column1) ? $data->question44->item2->column1 : '' ?></td>
                                        <td><?= isset($data->question44->item2->column2) ? $data->question44->item2->column2 : '' ?></td>
                                        <td><?= isset($data->question44->item2->column3) ? $data->question44->item2->column3 : '' ?></td>
                                        <td><?= isset($data->question44->item2->column4) ? $data->question44->item2->column4 : '' ?></td>
                                        <td><?= isset($data->question44->item2->column5) ? $data->question44->item2->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>20 menit pertama transfusi</td>
                                        <td><?= isset($data->question44->item3->column1) ? $data->question44->item3->column1 : '' ?></td>
                                        <td><?= isset($data->question44->item3->column2) ? $data->question44->item3->column2 : '' ?></td>
                                        <td><?= isset($data->question44->item3->column3) ? $data->question44->item3->column3 : '' ?></td>
                                        <td><?= isset($data->question44->item3->column4) ? $data->question44->item3->column4 : '' ?></td>
                                        <td><?= isset($data->question44->item3->column5) ? $data->question44->item3->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>Setelah transfusi</td>
                                        <td ><?= isset($data->question44->item4->column1) ? $data->question44->item4->column1 : '' ?></td>
                                        <td ><?= isset($data->question44->item4->column2) ? $data->question44->item4->column2 : '' ?></td>
                                        <td ><?= isset($data->question44->item4->column3) ? $data->question44->item4->column3 : '' ?></td>
                                        <td ><?= isset($data->question44->item4->column4) ? $data->question44->item4->column4 : '' ?></td>
                                        <td ><?= isset($data->question44->item4->column5) ? $data->question44->item4->column5 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">ket jenis reaksi transfusi : <?= isset($data->question45)?$data->question45:'' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Nama : <?= isset($data->question46)?$data->question46:'' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Tanda tangan : <img width="50" style="text-align:center" src="<?= isset($data->question47)?$data->question47:'' ?>" alt=""></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>VERIFIKASI DPJP</b>
                            <br><br>Tanggal : <?= isset($data->question12->text1)?$data->question12->text1:'' ?>
                            <br><br>Jam : <?= isset($data->question12->text2)?$data->question12->text2:'' ?>
                            </td>
                        
                            <td>Nama : <?= isset($data->question20)?$data->question20:'' ?></td>
                            <td colspan="2">Tanda tangan <br><img width="50" style="text-align:center" src="<?= isset($data->question26)?$data->question26:'' ?>" alt=""></td>
                            <p> </p>
                        </tr>
                        
                    </table>
                    
                    
                </td>
        </tr>
        </table>
    </div>

    <!-- Halaman Berikutnya -->
   <?php
if (isset($data->question49)) {
    $array_data = array_map(function($obj) {
        return (array) $obj;
    }, $data->question49);

    $data_chunk = array_chunk($array_data, 2); // 2 data per halaman

    foreach ($data_chunk as $index => $chunk) {
        // Tambahkan page break sebelum halaman baru kecuali untuk halaman pertama
        if ($index > 0) {
            echo '<div style="page-break-before: always;"></div>';
        }

        foreach ($chunk as $item) {
            ?>

    <div class="A4 sheet padding-fix-10mm">
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
                        <center><h3>MONITORING TRANSFUSI DARAH</h3></center>
                    </td>
                    <td width="30%">
                        <table border="0" width="100%" cellpadding="2px">
                            <tr>
                                <td style="font-size:13px" width="20%">No.RM</td>
                                <td style="font-size:13px" width="2%">:</td>
                                <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm) ? $data_pasien[0]->no_cm : '' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px">Nama</td>
                                <td style="font-size:13px">:</td>
                                <td style="font-size:13px"><?= isset($data_pasien[0]->nama) ? $data_pasien[0]->nama : '' ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:13px">TglLahir</td>
                                <td style="font-size:13px">:</td>
                                <td style="font-size:13px">
                                    <?= isset($data_pasien[0]->tgl_lahir) ? date('d-m-Y', strtotime($data_pasien[0]->tgl_lahir)) : '' ?>
                                    <span style="float:right">(<?= isset($data_pasien[0]->sex) ? $data_pasien[0]->sex : '' ?>)</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <!-- Tempel di sini konten lain dari template kamu, ganti semua $data-> dengan $item[''] -->
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                   <td colspan="4">
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                        <tr>
                            <td colspan="2">Diagnosis : </td>
                            <td colspan="2">Golongan Darah Pasien :  </td>
                        </tr>

                        <tr>
                            <td><b>INTRUKSI DOKTER (Diisi oleh dokter)</b>
                                <br>Jenis darah volume yang diminta : <?= isset($item['question50']) ? $item['question50'] : '' ?>
                                <br><br><br>Alasan transfusi : <?= isset($item['question51']) ? $item['question51'] : '' ?>
                                <br><br><br>Rencana pemberian transfusi : <?= isset($item['question52']) ? $item['question52'] : '' ?>
                                <br><br><br>Pemberi Pre-medikasi : <?= isset($item['question53']) ? $item['question53'] : '' ?>
                                <br><br><br>Kecepatan pemberian transfusi :  <?= isset($item['question54']) ? $item['question54'] : '' ?>
                                <br><br><br>Target pemberi transfusi :  <?= isset($item['question55']) ? $item['question55'] : '' ?>
                                <br><br><br>Pemeriksaan untuk transfusi : <?= isset($item['question56']) ? $item['question56'] : '' ?>
                                <br><br><br>Pemeriksaan untuk monitoring : <?= isset($item['question57']) ? $item['question57'] : '' ?>
                                <br><br><br> Laporkan segera, bila terjadi reaksi transfusi : 
                                <br><br><input type="checkbox" <?= (isset($item['question58']) && is_array($item['question58']) && in_array("item1", $item['question58'])) ? 'checked' : '' ?>>1. Gatal
                                <br><input type="checkbox" <?= (isset($item['question58']) && is_array($item['question58']) && in_array("item2", $item['question58'])) ? 'checked' : '' ?>>2. Perubahan tanda virtual
                                <br><input type="checkbox" <?= (isset($item['question58']) && is_array($item['question58']) && in_array("item3", $item['question58'])) ? 'checked' : '' ?>>3. Kemerahan
                                <br><input type="checkbox" <?= (isset($item['question58']) && is_array($item['question58']) && in_array("item4", $item['question58'])) ? 'checked' : '' ?>>4. jantung berdebar debar
                                <br><input type="checkbox" <?= (isset($item['question58']) && is_array($item['question58']) && in_array("item5", $item['question58'])) ? 'checked' : '' ?>>5. sesak
                            </td>
                            <td><b>KANTONG DARAH : <?= isset($item['question80']) ? $item['question80'] : '' ?></b>
                                <br>Nomor STOK :  <?= isset($item['question60']) ? $item['question60'] : '' ?>
                                <br><br><br>Tgl Kadaluarsa :  <?= isset($item['question61']) ? $item['question61'] : '' ?>
                                <br><br><br>Jenis Darah :
                                <br><br><br>Gol darah kantong <br><input type="checkbox" <?= (isset($item['question62']) && $item['question62'] == "item1") ? "checked" : "" ?>>A
                                <input type="checkbox" <?= (isset($item['question62']) && $item['question62'] == "item2") ? "checked" : "" ?>>B
                                <input type="checkbox" <?= (isset($item['question62']) && $item['question62'] == "item3") ? "checked" : "" ?>>AB
                                <input type="checkbox" <?= (isset($item['question62']) && $item['question62'] == "item4") ? "checked" : "" ?>>O
                                <br><br><br>Volume darah : <?= isset($item['question63']) ? $item['question63'] : '' ?>cc
                                <br><br> <b>KANTONG DARAH : <?= isset($item['question81']) ? $item['question81'] : '' ?></b>
                                <br>Nomor STOK :  <?= isset($item['question64']) ? $item['question64'] : '' ?>
                                <br><br><br>Tgl Kadaluarsa : <?= isset($item['question65']) ? $item['question65'] : '' ?>
                                <br><br><br>Jenis Darah :
                                <br><br><br>Gol darah kantong <br><input type="checkbox" <?= (isset($item['question66']) && $item['question66'] == "item1") ? "checked" : "" ?>>A
                                <input type="checkbox" <?= (isset($item['question66']) && $item['question66'] == "item2") ? "checked" : "" ?>>B
                                <input type="checkbox" <?= (isset($item['question66']) && $item['question66'] == "item3") ? "checked" : "" ?>>AB
                                <input type="checkbox" <?= (isset($item['question66']) && $item['question66'] == "item4") ? "checked" : "" ?>>O
                                <br><br><br>Volume darah : <?= isset($item['question67']) ? $item['question67'] : '' ?> cc
                            </td>
                            <td><b>IDENTIFIKASI</b>
                                <br><br> Identifikasi kantong : 
                                <br><input type="checkbox" <?= (isset($item['question69']) && $item['question69'] == "item1") ? "checked" : "" ?>>Sesuai
                                <input type="checkbox" <?= (isset($item['question69']) && $item['question69'] == "item2") ? "checked" : "" ?>>Tidak sesuai
                                <br><br> Identifikasi pasien :
                                <br><input type="checkbox" <?= (isset($item['question70']) && $item['question70'] == "item1") ? "checked" : "" ?>>Sesuai
                                <input type="checkbox" <?= (isset($item['question70']) && $item['question70'] == "item2") ? "checked" : "" ?>>Tidak sesuai
                                <br><br> Keadaan kantong darah :
                                <br><input type="checkbox" <?= (isset($item['question71']) && $item['question71'] == "item1") ? "checked" : "" ?>>Baik
                                <input type="checkbox" <?= (isset($item['question71']) && $item['question71'] == "item2") ? "checked" : "" ?>>Tidak Baik
                                <br>Pelaksana identifikasi :
                                <br>Nama : <?= isset($item['question72']->text1) ? $item['question72']->text1 : '' ?>
                                <br><br>Tanda tangan  
                                <br><img width="60px" style="text-align:center" src="<?= isset($item['question73']) ? $item['question73'] : '' ?>" alt=""><br><br>
                                <b>IDENTIFIKASI</b>
                                <br><br> Identifikasi kantong :
                                <br><input type="checkbox" <?= (isset($item['question74']) && $item['question74'] == "item1") ? "checked" : "" ?>>Sesuai
                                <input type="checkbox" <?= (isset($item['question74']) && $item['question74'] == "item2") ? "checked" : "" ?>>Tidak sesuai
                                <br><br> Identifikasi pasien :
                                <br><input type="checkbox" <?= (isset($item['question75']) && $item['question75'] == "item1") ? "checked" : "" ?>>Sesuai
                                <input type="checkbox" <?= (isset($item['question75']) && $item['question75'] == "item2") ? "checked" : "" ?>>Tidak sesuai
                                <br><br> Keadaan kantong darah :
                                <br><input type="checkbox" <?= (isset($item['question76']) && $item['question76'] == "item1") ? "checked" : "" ?>>Baik
                                <input type="checkbox" <?= (isset($item['question76']) && $item['question76'] == "item2") ? "checked" : "" ?>>Tidak Baik
                                <br>Pelaksana identifikasi :
                                <br>Nama : <?= isset($item['question72']->text1) ? $item['question72']->text1 : '' ?>
                                <br><br>Tanda tangan
                                <br><img width="60px" style="text-align:center" src="<?= isset($item['question78']) ? $item['question78'] : '' ?>" alt=""><br><br>
                            </td>

                            <td>Tanggal & Jam Transfusi <?= isset($data->question33) ? $data->question33 : '' ?>
                                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px;">
                                    <tr>
                                        <td colspan="7"><b><center>KONTROL VITAL SIGN</center></b></td>
                                    </tr>
                                    <tr>
                                        <td>NO</td>
                                        <td>Kondisi</td>
                                        <td>Jam</td>
                                        <td>TD</td>
                                        <td>HR</td>
                                        <td>T</td>
                                        <td>Reaksi +/-</td>
                                    </tr>
                                    <?php foreach ($data->question48 as $key => $question): ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td></td>
                                        <td style="font-size: 11px;"><?= isset($question->column1) ? $question->column1 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($question->column2) ? $question->column2 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($question->column3) ? $question->column3 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($question->column4) ? $question->column4 : '' ?></td>
                                        <td style="font-size: 11px;"><?= isset($question->column5) ? $question->column5 : '' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <tr>
                                        <td colspan="7">ket jenis reaksi transfusi : <?= isset($data->question35) ? $data->question35 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Nama : <?= isset($data->question36) ? $data->question36 : '' ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">Tanda tangan : <img width="50" style="text-align:center" src="<?= isset($data->question37) ? $data->question37 : '' ?>" alt=""></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><b>VERIFIKASI DPJP</b>
                            <br><br>Tanggal : <?= isset($data->question12->text1) ? $data->question12->text1 : '' ?>
                            <br><br>Jam : <?= isset($data->question12->text2) ? $data->question12->text2 : '' ?>
                            </td>

                            <td>Nama : <?= isset($data->question20) ? $data->question20 : '' ?></td>
                            <td colspan="2">Tanda tangan <br><img width="50" style="text-align:center" src="<?= isset($data->question26) ? $data->question26 : '' ?>" alt=""></td>
                            <p> </p>
                        </tr>
                    </table>
                </td>
                </tr>
            </table>
 </div>
            <?php
        }

        echo '</div>';
    }
}
?>
   
</body>

</html>
