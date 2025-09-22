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
            FORMULIR PATOLOGI KLINIK
        </p>
        <div style="margin-left:25px">
            <div>
                <table border="0" width="100" style="font-size:12px">
                    <tr>
                        <td width="40%"><span class="">Nama Dokter</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                    <tr>
                        <td width="40%"><span class="">Ruangan</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                </table><br><br>
            </div>
            <table border="0" width="79%" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Jaringan tubuh di dapat</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                    <td width="30%"><span class="">Eksisi percobaan/Kerokan/Operasi/Seksi</span></span></td>
                </tr>

            </table><br>
            <table border="0" width="275" style=" font-size:12px">
                <tr>
                    <td width="50%"><span class="">Jaringan yang diambil</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                </tr>
            </table><br>
            <table border="0" width="538" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Cairan Fiksasi</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                    <td width="40%"><span class="">Formalin 10%</span></span></td>
                </tr>
            </table><br>
            <table border="0" width="280" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Diagnosa Klinik</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                </tr>
            </table><br>
            <table border="0" width="280" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Keterangan Klinik</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                </tr>
            </table><br>
            <table border="0" width="280" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Pemeriksaan Radiologi</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                </tr>
            </table><br>
            <table border="0" width="280" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Ongkos Pembayaran</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                </tr>
            </table><br>
            <table border="0" width="280" style="font-size:12px">
                <tr>
                    <td width="40%"><span class="">Hasil Laboratorium</span></span></td>
                    <td width="3%"><span class="">:<span class=""></span></span></td>
                </tr>
            </table>

            <p>Sketsa Lokalisasi</p>
        </div><br><br><br>

        <div style="float: right;">
            <p>
                <span>Bukittinggi,
                    <?= isset($data->question1112)? date('d-m-Y',strtotime($data->question1112)):''; ?></span><br>

            </p>
            <p>Dokter Penanggung Jawab Pelayanan</p>
            <?php
                        $name_two = $data->nm_pemeriksa_2??null;
                                                            
                        $result_two = $name_two?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_two'")->row():null;
                        if(isset($result_two->ttd)){
                    ?>
            <img width="120px" height="130px" src="<?= $result_two->ttd ?>" alt=""><br>
            <?php }?>
            <span><?= isset($data->nm_pemeriksa_2)?$data->nm_pemeriksa_2:'' ?></span><br>
            <br>
            <p>( Nama jelas & tanda tangan )</p>
        </div>
    </div>

</body>