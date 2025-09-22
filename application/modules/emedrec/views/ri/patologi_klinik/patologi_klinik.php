<?php
// $data = (isset($geriatri->formjson)?json_decode($geriatri->formjson):'');
$data = (isset($formulir_patologi_klinik->formjson)?json_decode($formulir_patologi_klinik->formjson) : '');
// var_dump($data);
// echo '<pre>';
// var_dump($data);
// echo '</pre>';
// die();
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<style>
#data {
    /* margin-top: 10px; */
    /* border-collapse: collapse; */
    /* border: 1px solid black;     */
    width: 100%;
    font-size: 12px;
    position: relative;


}

#data tr td {

    font-size: 12px;
    font-family: arial;

}

#data th {

    font-size: 12px;
    font-family: arial;

}

#noborder td {
    font-family: arial;
    font-size: 12px;
}
</style>

</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            FORMULIR PATOLOGI ANATOMI
        </p>
        <div style="margin-left:25px">
            <div>
                <table border="0" width="200" style="font-size:12px">
                    <tr>
                        <td width="50%"><span class="">Nama Dokter</span></td>
                        <td width="50%"><span
                                class="">:<?php echo isset($data->question2->{'text1'}) ? $data->question2->{'text1'} : ''; ?>
                            </span></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%"><span class="">Ruangan</span></span></td>
                        <td width="50%"><span
                                class="">:<?php echo isset($data->question2->{'text2'}) ? $data->question2->{'text2'} : ''; ?>
                            </span></span>
                        </td>
                    </tr>
                </table><br><br>
            </div>
            <table border="0" width="100%" style="font-size:12px">
                <tr>
                    <td width="30%"><span class="">Jaringan tubuh di dapat dengan</span></span></td>
                    <td width="2%"><span class="">:</span></span>
                    </td>
                    <td width="50%">
                        <span class="">
                            <?= isset($data->question3) ? ($data->question3 == "item1" ? '<strong>Eksisi percobaan</strong>' : 'Eksisi percobaan/') : 'Eksisi percobaan' ?>
                        </span>
                        <span class="">
                            <?= isset($data->question3) ? ($data->question3 == "item2" ? '<strong>Kerokan</strong>' : 'Kerokan/') : 'Kerokan' ?>
                        </span>
                        <span class="">
                            <?= isset($data->question3) ? ($data->question3 == "item3" ? '<strong>Operasi</strong>' : '/Operasi') : 'Operasi' ?>
                        </span>
                        <span class="">
                            <?= isset($data->question3) ? ($data->question3 == "item4" ? '<strong>Seksi</strong>' : '/Seksi') : 'Seksi' ?>
                        </span>
                    </td>


                </tr>

            </table><br>
            <table border="0" width="510" style=" font-size:12px">
                <tr>
                    <td width="50%"><span class="">Jaringan yang diambil</span></span></td>
                    <td width="50%"><span class="">:
                            <?= isset($data->question4->item1->column1) ? $data->question4->item1->column1 : '' ?>
                            <span class=""></span></span></td>
                </tr>
            </table><br>
            <table border="0" width="510" style="font-size:12px">
                <tr>
                    <td width="50%"><span class="">Cairan Fiksasi</span></span></td>
                    <td width="50%">:
                        <input type="checkbox"
                            <?php echo isset($data->question1[0])? $data->question1[0] == "item1" ? "checked":'':'' ?>>
                        </span>Formalin 10 %</span>
                    </td>

            </table><br>
            <table border="0" width="510" style="font-size:12px">
                <tr>
                    <td width="50%"><span class="">Diagnosa Klinik</span></span></td>
                    <td width="50%"><span class="">:
                            <?php echo isset($data->question6->{'text1'}) ? $data->question6->{'text1'} : ''; ?>
                    </td>
                </tr>
            </table><br>
            <table border="0" width="510" style="font-size:12px">
                <tr>
                    <td width="50%"><span class="">Keterangan Klinik</span></span></td>
                    <td width="50%"><span class="">:
                            <?php echo isset($data->question6->{'text2'}) ? $data->question6->{'text2'} : ''; ?>
                    </td>
                </tr>
            </table><br>
            <table border="0" width="510" style="font-size:12px">
                <tr>
                    <td width="50%"><span class="">Hasil Laboratorium</span></span></td>
                    <td width="50%"><span class="">:
                            <?php echo isset($data->question6->{'text3'}) ? $data->question6->{'text3'} : ''; ?></span></span>
                    </td>
                </tr>
            </table><br>
            <table border="0" width="510" style="font-size:12px">
                <tr>
                    <td width="50%"><span class="">Pemeriksaan Radiologi</span></span></td>
                    <td width="50%"><span class="">:
                            <?php echo isset($data->question6->{'text4'}) ? $data->question6->{'text4'} : ''; ?>
                    </td>
                </tr>
            </table><br>
            <table border="0" width="510" style="font-size:12px">
                <tr>
                    <td width="50%"><span class="">Ongkos Pembayaran</span></span></td>
                    <td width="50%"><span class="">:
                            <?php echo isset($data->question6->{'text5'}) ? $data->question6->{'text5'} : ''; ?>
                    </td>
                </tr>
            </table><br>


            <p>Sketsa Lokalisasi</p>
        </div><br><br><br>

        <div style="text-align: right;">
            <span>Bukittinggi
                :<?= isset($data->question8->item1->column1) ? date('d-m-Y', strtotime($data->question8->item1->column1)) : ''; ?>

        </div>

        <div style="float: right;">
            <p style="text-align: center;">Dokter Penanggung Jawab Pelayanan</p>

            <div style="display: flex; justify-content: center; align-items: center;">
                <?php
        if (isset($data) && is_object($data) && isset($data->question9)) {
            $question9Value = $data->question9;
            echo '<img width="120px" height="130px" src="' . $question9Value . '" alt="Image"><br>';
        } else {
            echo 'Image not available';
        }
        ?>
            </div>
            <span style="text-align:center; display: block;">(
                <?php
        if (isset($data) && is_object($data) && isset($data->question10)) {
            echo $data->question10;
        }
        ?>
                )</span>
            <p style="text-align: center;">Nama jelas & tanda tangan</p>
        </div>

    </div>

</body>

</html>