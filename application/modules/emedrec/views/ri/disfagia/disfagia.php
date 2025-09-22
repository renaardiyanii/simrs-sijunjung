<?php

// var_dump($assesment_keperawatan_geriatri_rawat_inap);
// die();
//   var_dump(isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'');
$data = (isset($disfagia->formjson) ? json_decode($disfagia->formjson) : '');
// $jsonf = json_decode($data->question885, TRUE);
// echo '<pre>';
// var_dump($data);
// echo '</pre>';
// die();

?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
    <style>
    strong {
        font-weight: bold;
    }
    </style>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
        <center>
            <p style="font-weight:bold;font-size:14px">
                <span>PROSEDUR SKRINING DISFAGIA<br>MODIFIKASI DARI THE MASSEY BEDSIDE SWALLOWING SCREEN<br>( Massey &
                    Jedlika, 2002 )</span>
            </p>

        </center>
        <div style="margin-left:25px">
            <div style="font-size:12px">

                <table border="0" width="100%" style="font-size:12px">
                    <tr>
                        <td width="20%"><span class="">Tanggal periksa</span></td>
                        <td width="80%">
                            <?= ':' . ' ' . (isset($data->question2->text1) ? date('d-m-Y', strtotime((string)$data->question2->text1)) : '') ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%"><span class="">Unit periksa</span></td>
                        <td width="80%">
                            <?= ':' . ' ' . (isset($data->question2->text2) ? $data->question2->text2 : '') ?></td>
                    </tr>
                    <tr>
                        <td width="20%"><span class="">Pemeriksa</span></td>
                        <td width="80%">
                            <?= ':' . ' ' . (isset($data->question2->text3) ? $data->question2->text3 : '') ?></td>
                    </tr>
                </table><br>
            </div>
            <div style="font-size:12px">
                <table width="100%" border="1">
                    <tr>
                        <th rowspan="2" style="width: 5%">No.</th>
                        <th rowspan="2" style="width: 25%">OBSERVASI</th>
                        <th rowspan="2" style="width: 40%">HASIL OBSERVASI</th>
                        <th rowspan="2" style="width: 50%">HASIL OBSERVASI</th>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td>1</td>
                        <td width="10%">Kesadaran</td>
                        <td width="10%">
                            <?= isset($data->question3->{'1'}->Column2) ? ($data->question3->{'1'}->Column2 == "1" ? '<strong>Sadar</strong>' : "Sadar") . ', Lanjut No2' : "" ?>
                        <td width="10%">
                            <?= isset($data->question3->{'1'}->Column3) ? ($data->question3->{'1'}->Column3 == "1" ? '<strong>Tidak Sadar</strong>' : "Tidak Sadar") . ', Lanjut No3' : "" ?>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td width="10%">Afasia atau disartia</td>
                        <td width="10%">
                            <?= isset($data->question4->{'2'}->Column2) ? ($data->question4->{'2'}->Column2 == "2" ? '<strong>Ya</strong>' : "Ya") .',Lanjutkan langkah berikut, lanjut ke nomor 3': "" ?>
                        </td>
                        <td width="10%">
                            <?= isset($data->question4->{'2'}->Column3) ? ($data->question4->{'2'}->Column3 == "2" ? '<strong>Tidak</strong>' : "Tidak") .', lanjut ke nomor 3': "" ?>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td width="10%">Dapat merapatkan gigi, merapatkan bibir, wajah simetris, letak lidah lidah
                            di
                            tengah, uvula di tengah</td>
                        <td width="10%">
                            <?= isset($data->question5->{'3'}->Column2) ? ($data->question5->{'3'}->Column2 == "3" ? '<strong>Jika ditemukan 3 atau lebih gejala dilanjutkan ke nomor 4</strong>' : "Jika ditemukan 3 atau lebih gejala dilanjutkan ke nomor 4") .'': "" ?>
                        </td>
                        <td width="10%">
                            <?= isset($data->question5->{'3'}->Column3) ? ($data->question5->{'3'}->Column3 == "3" ? '<strong>Tidak</strong>' : "Tidak") .',lanjutkan ke nomor 4 dan kolaborasi dengan terapi wicara (dirawat
                            inap)': "" ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td width="10%">Reflex muntah ada, batuk spontan, reflex menelan baik</td>
                        <td width="10%">
                            <?= isset($data->question6->{'4'}->Column2) ? ($data->question6->{'4'}->Column2 == "4" ? '<strong>Ya</strong>' : "Ya") .'.Lanjutkan ke langkah nomor 5': "" ?>
                        </td>
                        <td width="10%"><?= isset($data->question6->{'4'}->Column3) ? ($data->question6->{'4'}->Column3 == "4" ? '<strong>Tidak</strong>' : "Tidak") .',kolabroasi dengan terapi wicara, (dirawat inap) lakukan
                            langkah
                            nomor 5': "" ?> </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td width="10%">Tes menelan air putih satu sendok teh

                        </td>
                        <td width="10%">
                            <?= isset($data->question7->{'5'}->Column2) ? ($data->question7->{'5'}->Column2 == "5" ? '<strong>Mampu menelan</strong>' : "Mampu menelan") .',lanjut ke langkah nomor 6': "" ?>
                        </td>
                        <td width="10%"><?= isset($data->question7->{'5'}->Column3) ? ($data->question7->{'5'}->Column3 == "5" ? '<strong>Tidak mampu menelan</strong>' : "Tidak mampu menelan") .', STOP tes menelan, Hasil skrining disfagia
                            positif <b>Protokol I</b>. Jangan berikan makanan/minuman peroral, pasang NGT, Rawat
                            inap
                            : kolaborasi dengan dokter, terapis wicara dan ahli gizi': "" ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td width="10%">Berikan minuman air putih bertahap mulai dari 25 ml, 50 ml, dan 100 ml
                        </td>
                        <td width="10%"><?= isset($data->question8->{'6'}->Column2) ? ($data->question8->{'6'}->Column2 == "6" ? '<strong>Pasien mampu minum ari putih 50 ml dalam waktu kurang dari 20 detik tanpa
                            tersedak</strong>' : "Pasien mampu minum ari putih 50 ml dalam waktu kurang dari 20 detik tanpa
                            tersedak") .', hasil skrining disfagia negative atau fungsi menelan normal': "" ?></td>
                        <td width="10%"><?= isset($data->question8->{'6'}->Column3) ? ($data->question8->{'6'}->Column3 == "6" ? '<strong>Tersedak / Batuk</strong>' : "Tersedak / Batuk ") .' : hasil skrining disfagia positif, pasien tidak mampu menelan cair<br><b>Protokol II</b> : berikan modifikasi diit sesuai toleransi, pasang NGT
                            bila diperlukan, untuk asupan cairan, kolaborasi dengan dokter, terapis wicara dan ahli
                            gizi': "" ?>
                        </td>
                    </tr>
                </table>
                <p>Kesimpulan :</p>
                <p>Gangguan Menelan :</p>
                <table border="0" width="100" style="font-size:12px">
                    <tr>
                        <td width="100%"><span class="">ya</span></span></td>
                        <td width="100%"><span class="">ya</span></span></td>
                        <td width="10%"><span
                                class="">(<?= isset($data->question10) ? $data->question10 == "1" ? "√" : "" : "" ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%"><span class="">tidak</span></span></td>
                        <td width="10%"><span
                                class="">(<?= isset($data->question10) ? $data->question10 == "2" ? "√" : "" : "" ?>)</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="font-size:12px">
                <div style="float: right;">
                    <p>Pemeriksa</p>
                    <div style="display: flex; justify-content: center; align-items: center;">
                        <img width="120px" height="130px" src="<?php //echo  $data->question11 ?>" alt="Image">
                    </div>
                    <span style="text-align:center; display: block;">(
                        <?= isset($data->question12) ? $data->question12 : '' ?> )</span>
                    <p style="text-align: center;">Nama jelas & tanda tangan</p>
                </div>
            </div>

            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    </div>

</body>

</html>