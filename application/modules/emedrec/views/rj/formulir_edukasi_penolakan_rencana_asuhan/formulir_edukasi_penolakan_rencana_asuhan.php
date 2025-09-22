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
            <?php $this->load->view('emedrec/header_print') ?>
        </header>
        <div style="height:0px;border: 2px solid black;"></div>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            <center>
                <h4>FORMULIR PERSETUJUAN / PENOLAKAN RENCANA ASUHAN</h4>
            </center>
        </p>
        <div style="margin-left:1px">
            <table border="1" width="100%">

                <tr>
                    <td>
                        <table border="0" width="100%">
                            <br>
                            <tr>
                                <td>
                                    <span class="text_sub_judul">Rencana Asuhan Yang Disetujui / Ditolak :</span>
                                </td>
                            </tr>
                        </table>
                        <br>

                        <table border="0" width="100%">
                            <tr>
                                <td width="5%">
                                </td>
                                <td>
                                    <span
                                        class="text_isi"><?= (isset($rencana_asuhan[0]->catatan))?$rencana_asuhan[0]->catatan:'' ?></span>
                                    <span
                                        class="text_isi"><?= (isset($data->rencana_asuhan))?$data->rencana_asuhan:'' ?></span>
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
                                    <span class="text_sub_judul">Alasan Persetujuan / Penolakan :</span>
                                </td>
                            </tr>
                        </table>
                        <br>

                        <table border="0" width="100%">
                            <tr>
                                <td width="5%">
                                </td>
                                <td>
                                    <span
                                        class="text_isi"><?= isset($object_dokter->objective_dokter)?$object_dokter->objective_dokter:'' ?></span>
                                </td>
                            </tr>
                        </table>
                        <br>
                    </td>
                </tr>
            </table>
            <table id="data" width="100%" border="1" cellpadding="3px">
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center">Tanggal Jam</td>
                    <td rowspan="2" style="text-align:center">Materi Edukasi Resiko Persetujuan / Penolakan</td>
                    <td colspan="3" style="text-align:center">Tanda tangan dan Nama lengkap</td>
                </tr>
                <tr>
                    <td width="15%" style="text-align:center">Pasien</td>
                    <td width="15%" style="text-align:center">Keluarga (Hubungan)</td>
                    <td width="15%" style="text-align:center">Staff RS</td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="2" style="text-align:center"> </td>
                    <td rowspan="2" style="text-align:center"> </td>

                </tr>
                <tr>
                    <td width="15%" style="text-align:center"> </td>
                    <td width="15%" style="text-align:center"> </td>
                    <td width="15%" style="text-align:center"> </td>
                </tr>





                <?php
                            $no=1; 
                            $jml_array = isset($data->table)?count($data->table):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                <tr>
                    <td width="5%"><?= $no++ ?></td>
                    <td width="35%"><?= isset($data->table[$x]->tanggal_jam)?$data->table[$x]->tanggal_jam:'' ?>
                    </td>
                    <td width="15%"><?= isset($data->table[$x]->penolakan)?$data->table[$x]->penolakan:'' ?></td>
                    <td width="15%"><img width="130px"
                            src="<?= (isset($data->table[$x]->ttd)?$data->table[$x]->pasien:'') ?>" alt=""></td>
                    <td width="15%"><img width="130px"
                            src="<?= (isset($lap_terapi->ttd_keluarga)?$lap_terapi->ttd_keluarga:'') ?>" alt="">
                    </td>
                    <td width="15%"><img width="130px"
                            src="<?= (isset($lap_terapi->ttd_keluarga)?$lap_terapi->ttd_staff_rs:'') ?>" alt="">
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>