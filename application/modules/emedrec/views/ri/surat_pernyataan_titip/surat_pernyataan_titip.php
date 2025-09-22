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
            SURAT PERNYATAAN TITIP<br>
            (RUANG RAWAT TIDAK TERSEDIA SESUAI JATAH)

        </p>
        <div style="margin-left:25px">
            <div>
                <p>Saya yang bertanda tangan dibawah ini :</p>
                <table border="0" width="100" style="font-size:12px">
                    <tr>
                        <td width="40%"><span class="">NAMA</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                    <tr>
                        <td width="40%"><span class="">NIK</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                    <tr>
                        <td width="40%"><span class="">Umur</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                    <tr>
                        <td width="40%"><span class="">Alamat</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                    <tr>
                        <td width="40%"><span class="">No.HP</span></span></td>
                        <td width="3%"><span class="">:<span class=""></span></span></td>
                    </tr>
                </table>
            </div>
            <div style="font-size:12px">
                <p>Adalah............(sebutkan hubungan dengan pasien) dari pasien yang nama tertera didalam
                    label
                    atas :</p>

                <p>Dikarenakan hak jatah ruangan pasien ketika masuk rumah sakit penuh. Maka dengan ini saya menyatakan
                    bahwa :<br>

                    1. Hak jatah kelas BPJS pasien adalah ..............<br>
                    2. Ruangan yang ditempati saat masuk rumah sakit adalah ......................... Kelas
                    ...............................<br>
                    3. Saya bersedia pasien dipindahkan kembali ketika ruangan yang sesuai jatah telah tersedia.<br>
                    4. Jika tidak bersedia pindah maka saya bersedia untuk melakukan pernyataan selisih tarif terhitung
                    dari
                    awal pasien masuk rumah sakit.<br>
                    5. Jika BPJS kelas 3 tidak bersedia dipindahkan ketika ruangan tersedia maka saya bersedia UMUM.
                    Dikarenakan BPJS kelas 3 tidak boleh naik kelas atau selisih tarif.<br>
                    Demikianlah surat pernyataan ini dibuat dengan sebenarnya, dalam keadaan sadar dan tanpa ada paksaan
                    dari pihak manapun dan untuk dipergunakan sebagaimana mestinya.</p>
                <br><br><br><br><br>
                <div style="float: left;">
                    <p>
                        <span>Bukittinggi,
                            <?= isset($data->question1112)? date('d-m-Y',strtotime($data->question1112)):''; ?></span><br>

                    </p>
                    <p>Pasien/Penanggung pasien</p>
                    <p>Materai 1000</p>
                    <?php
                        $name_two = $data->nm_pemeriksa_2??null;                                   
                        $result_two = $name_two?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_two'")->row():null;
                        if(isset($result_two->ttd)){
                    ?> <img width="120px" height="130px" src="<?= $result_two->ttd ?>" alt=""><br>
                    <?php }?>
                    <span><?= isset($data->nm_pemeriksa_2)?$data->nm_pemeriksa_2:'' ?></span>
                    <br><br><br><br>
                    <p>( Nama jelas & tanda tangan )</p>
                </div>
                <div style="float: right;">
                    <p>Petugas Rumah sakit</p>
                    <?php
                        $name_two = $data->nm_pemeriksa_2??null;
                                                            
                        $result_two = $name_two?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_two'")->row():null;
                        if(isset($result_two->ttd)){
                    ?>
                    <img width="120px" height="130px" src="<?= $result_two->ttd ?>" alt=""><br>
                    <?php }?>
                    <span><?= isset($data->nm_pemeriksa_2)?$data->nm_pemeriksa_2:'' ?></span>
                    <br><br><br><br><br><br><br>
                    <p>( Nama jelas & tanda tangan )</p>
                </div>

            </div><br><br><br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:left;font-size:12px">Hal 1 - 1</p>
            <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>