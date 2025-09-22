<?php
$data = (isset($gyssens->formjson)?json_decode($gyssens->formjson):'');
// var_dump($data->question2->{'1'}->{'0'});
?>

<head>
    <title></title>
</head>

<style>
#data {
    /* margin-top: 10px; */
    /* border-collapse: collapse; */
    /* border: 1px solid black;     */
    width: 100%;
    font-size: 11px;
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

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/rj/header_print') ?>
        </header>

        <center>
            <h4>EVALUASI PEMAKAIAN ANTIBIOTIK (GYSSENS)</h4>
        </center>

        <div style="font-size:12px;text-align: center;min-height:600px">
            <p>
                <span><b>
                        Analisa Kualitatif Pengguna Antibiotika
                    </b></span>
            </p>
            <table id="data" border="1">
                <tr>
                    <th rowspan="2" style="width: 20%">Kategori Gyssens</th>
                    <th rowspan="2" style="width: 50%">Keterangan</th>

                </tr>
                <tr>
                    <th style="width: 20%">Jumlah Kasus</th>
                    <th style="width: 20%">Persentase (%) </th>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori 0</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tepat / Bijak</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'0'})?$data->question2->{'1'}->{'0'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori I</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tidak Tepat Waktu</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'1'})?$data->question2->{'1'}->{'1'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIA</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tidak Tepat Dosis</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'2a'})?$data->question2->{'1'}->{'2a'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIB</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tidak Tepat Interval Pemberian</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'2b'})?$data->question2->{'1'}->{'2b'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIC</td>
                    <td style="width: 50%">Penggnaan Antibiotik Tidak Tepat Cara / Rute Pemberian</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'2c'})?$data->question2->{'1'}->{'2c'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIIA</td>
                    <td style="width: 50%">Penggunaan Antibiotik Terlalu Lama</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'3a'})?$data->question2->{'1'}->{'3a'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIIB</td>
                    <td style="width: 50%">Penggunaan Antibiotik Terlalu Singkat</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'3b'})?$data->question2->{'1'}->{'3b'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVA</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang lebih Efektif</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'4a'})?$data->question2->{'1'}->{'4a'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVB</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang Kurang Toksik / Lebih Aman</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'4b'})?$data->question2->{'1'}->{'4b'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVC</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang Lebih Murah</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'4c'})?$data->question2->{'1'}->{'4c'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVD</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang Spektrumnya Lebih Sempit</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'4d'})?$data->question2->{'1'}->{'4d'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori V</td>
                    <td style="width: 50%">Tidak Ada Indikasi Penggunaan Antibiotik</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'5'})?$data->question2->{'1'}->{'5'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori VI</td>
                    <td style="width: 50%">Data Rekam Medik Tidak Lengkap dan Tidak Dapat Dievaluasi</td>
                    <td style="width: 20%;text-align: center;"><?= isset($data->question2->{'1'}->{'6'})?$data->question2->{'1'}->{'6'}:'' ?>
                    </td>
                    <td style="width: 20%;text-align: center;">
                    </td>
                </tr>
                
                <tr>
                    <td colspan="2" style="width: 10%;text-align: center;"><b>Total Kasus</b></td><br>
                    <td style="width: 20%;text-align: center;" colspan="2">
                    <?= isset($data->question2->{'1'}->total)?$data->question2->{'1'}->total:'' ?>
                    </td>

                </tr>

            </table>
            
        </div>
        <br><br> <br><br> <br><br><br><br> <br><br> <br><br>
        <div style="display:flex;font-size:12px;font-family:arial">
            <div>
                <p></p>
            </div>
            <div style="margin-left:650px;">
                <p style="font-family:arial">Hal 1 dari 1</p>
            </div>
        </div>


</body>

</html>