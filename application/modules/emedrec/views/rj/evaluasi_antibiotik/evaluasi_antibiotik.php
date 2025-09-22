<?php
// $data = (isset($geriatri->formjson)?json_decode($geriatri->formjson):'');
// var_dump($data);
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
            <?php $this->load->view('emedrec/header_print') ?>
        </header>
        <div style="border-bottom: 1px solid black;margin-top:3px"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div>

        <center>
            <h4>EVALUASI PEMAKAIAN ANTIBIOTIK (GYSSENS)</h4>
        </center>

        <div style="font-size:12px;text-align: center;">
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
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'1'})?intval($data->question12->{'Row 1'}->{'1'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'1'})?intval($data->question12->{'Row 1'}->{'1'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori I</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tidak Tepat Waktu</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'2'})?intval($data->question12->{'Row 1'}->{'2'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'2'})?intval($data->question12->{'Row 1'}->{'2'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIA</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tidak Tepat Dosis</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'3'})?intval($data->question12->{'Row 1'}->{'3'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'3'})?intval($data->question12->{'Row 1'}->{'3'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIB</td>
                    <td style="width: 50%">Penggunaan Antibiotik Tidak Tepat Interval Pemberian</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'4'})?intval($data->question12->{'Row 1'}->{'4'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'4'})?intval($data->question12->{'Row 1'}->{'4'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIC</td>
                    <td style="width: 50%">Penggnaan Antibiotik Tidak Tepat Cara / Rute Pemberian</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'5'})?intval($data->question12->{'Row 1'}->{'5'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'5'})?intval($data->question12->{'Row 1'}->{'5'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIIA</td>
                    <td style="width: 50%">Penggunaan Antibiotik Terlalu Lama</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'6'})?intval($data->question12->{'Row 1'}->{'6'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'6'})?intval($data->question12->{'Row 1'}->{'6'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IIIB</td>
                    <td style="width: 50%">Penggunaan Antibiotik Terlalu Singkat</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'7'})?intval($data->question12->{'Row 1'}->{'7'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'7'})?intval($data->question12->{'Row 1'}->{'7'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVA</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang lebih Efektif</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'8'})?intval($data->question12->{'Row 1'}->{'8'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'8'})?intval($data->question12->{'Row 1'}->{'8'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVB</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang Kurang Toksik / Lebih Aman</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'9'})?intval($data->question12->{'Row 1'}->{'9'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align;"
                        class="<?= isset($data->question12->{'Row 1'}->{'9'})?intval($data->question12->{'Row 1'}->{'9'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVC</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang Lebih Murah</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'10'})?intval($data->question12->{'Row 1'}->{'10'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'10'})?intval($data->question12->{'Row 1'}->{'10'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori IVD</td>
                    <td style="width: 50%">Ada Antibiotik Lain yang Spektrumnya Lebih Sempit</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'11'})?intval($data->question12->{'Row 1'}->{'11'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'11'})?intval($data->question12->{'Row 1'}->{'11'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori V</td>
                    <td style="width: 50%">Tidak Ada Indikasi Penggunaan Antibiotik</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'12'})?intval($data->question12->{'Row 1'}->{'12'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'12'})?intval($data->question12->{'Row 1'}->{'12'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;text-align;">Kategori VI</td>
                    <td style="width: 50%">Data Rekam Medik Tidak Lengkap dan Tidak Dapat Dievaluasi</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'13'})?intval($data->question12->{'Row 1'}->{'13'}) =="1"?"penanda":"":''; ?>">
                    </td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'13'})?intval($data->question12->{'Row 1'}->{'13'}) =="0"?"penanda":"":''; ?>">
                    </td>
                </tr>
                <!-- <tr>
                    <td style="width: 10%;text-align: center;">14.</td>
                    <td style="width: 50%">Impotensi</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'14'})?intval($data->question12->{'Row 1'}->{'14'}) =="1"?"penanda":"":''; ?>">
                        1</td>
                    <td style="width: 20%;text-align: center;"
                        class="<?= isset($data->question12->{'Row 1'}->{'14'})?intval($data->question12->{'Row 1'}->{'14'}) =="0"?"penanda":"":''; ?>">
                0 
                </td>
                </tr>-->
                <tr>
                    <td colspan="2" style="width: 10%;text-align: center;"><b>Total Kasus</b></td><br>
                    <td style="width: 20%;text-align: center;" colspan="2">
                        <?= isset($data->question12->{'Row 1'}->total_kasus)?$data->question12->{'Row 1'}->total_kasus:'' ?>
                    </td>

                </tr>

                <!-- <tr>
                    <td colspan="2" style="width: 10%;text-align: center;"><b>Persentase(%)</b></td><br>
                    <td style="width: 20%;text-align: center;" colspan="2">
                        <?= isset($data->question12->{'Row 1'}->kategori)?$data->question12->{'Row 1'}->kategori:'' ?>
                    </td>

                </tr> -->
            </table>
            <!-- <p>
                <b> Interpretasi : Skor > 2 : Kategori Pasien Geriatri</b>
            </p>
            <br><br> <br><br> <br><br>
            <table width="100%">
                <tr>
                    <td align="right"><b>Dokter Penyakit Dalam</b></td>
                </tr>
                <tr>
                    <td align="right">
                        <?php
                        $id = explode('-',isset( $data->question9)? $data->question9:null)[1]??null;
                                                            
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                        <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                        <p>( <?= $query->name ?> </p>
                        <?php
                            } else {?>
                        <br><br><br> <br><br><br>
                        <?php } ?>
                    </td>
                </tr>
                <tr>
                    <td align="right"><b>Nama jelas & tanda tangan</b></td>
                </tr>
            </table> -->
        </div>
        <br><br> <br><br> <br><br><br><br> <br><br> <br><br><br><br>
        <div style="display:flex;font-size:10px">
            <div>
                Hal 1 dari 1
                <!-- </div>
            <div style="margin-left:470px">
                Rev.08.02.2021.RM-004c / RI
            </div> -->
            </div>
        </div>


</body>

</html>