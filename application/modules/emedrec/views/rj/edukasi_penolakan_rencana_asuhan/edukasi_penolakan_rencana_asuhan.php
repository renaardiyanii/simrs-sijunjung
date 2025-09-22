<?php
$data = (isset($edukasi_penolakan_rencana_asuhan->formjson)?json_decode($edukasi_penolakan_rencana_asuhan->formjson):'');
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
            <?php $this->load->view('emedrec/rj/header_print') ?>
        </header>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            <center>
                <h4>FORMULIR PERSETUJUAN / PENOLAKAN RENCANA ASUHAN</h4>
            </center>
        </p>
        <div style="margin-left:1px;min-height:870px">
            <table border="1" width="100%">

                <tr>
                    <td>
                        <table border="0" width="100%">
                            <br>
                            <tr>
                                <td>
                                    <span class="text_sub_judul">Rencana Asuhan Yang Disetujui / Ditolak : <?= isset($data->question3->text1)?$data->question3->text1:'' ?></span>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%">
                            <br>
                            <tr>
                                <td>
                                    <span class="text_sub_judul">Alasan Persetujuan / Penolakan : <?= isset($data->question3->text2)?$data->question3->text2:'' ?></span>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </td>
                </tr>
            </table>
            <table id="data" width="100%" border="1" cellpadding="3px">
                <tr>
                    <td rowspan="2" style="text-align:center">Tanggal Jam</td>
                    <td rowspan="2" style="text-align:center">Materi Edukasi Resiko Persetujuan / Penolakan</td>
                    <td colspan="3" style="text-align:center">Tanda tangan dan Nama lengkap</td>
                </tr>
                <tr>
                    <td width="15%" style="text-align:center">Pasien</td>
                    <td width="15%" style="text-align:center">Keluarga (Hubungan)</td>
                    <td width="15%" style="text-align:center">Staff RS</td>
                </tr>
                <!-- <tr>
                    <td colspan="2" rowspan="2" style="text-align:center"> </td>
                    <td rowspan="2" style="text-align:center"> </td>

                </tr>
                <tr>
                    <td width="15%" style="text-align:center"> </td>
                    <td width="15%" style="text-align:center"> </td>
                    <td width="15%" style="text-align:center"> </td>
                </tr> -->





                <?php
                            $no=1; 
                            $jml_array = isset($data->question1)?count($data->question1):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                <tr>
                    
                    <td width="35%"><?= isset($data->question1[$x]->{'Column 1'})?date('d-m-Y H:i',strtotime($data->question1[$x]->{'Column 1'})):'' ?></td>
                    <td width="15%"><?= isset($data->question1[$x]->{'Column 2'})?$data->question1[$x]->{'Column 2'}:'' ?></td>
            
                    <td width="15%"><img width="130px"
                            src="<?= (isset($data->question1[$x]->{'Column 3'})?$data->question1[$x]->{'Column 3'}:'') ?>" alt=""></td>
                    <td width="15%"><img width="130px"
                            src="<?= (isset($data->question1[$x]->{'Column 4'})?$data->question1[$x]->{'Column 4'}:'') ?>" alt="">
                    </td>
                    <td width="15%"><img width="130px"
                            src="<?= (isset($data->question1[$x]->{'Column 5'})?$data->question1[$x]->{'Column 5'}:'') ?>" alt="">
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        <div style="display:flex;font-size:12px;font-family:arial">
            <div>
                <p></p>
            </div>
            <div style="margin-left:650px;">
                <p style="font-family:arial">Hal 1 dari 1</p>
            </div>
        </div>