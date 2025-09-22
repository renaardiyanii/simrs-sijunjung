<?php
$data = (isset($pernyataan_titip->formjson)?json_decode($pernyataan_titip->formjson):'');
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
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
   
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            SURAT PERNYATAAN TITIP<br>
            (RUANG RAWAT TIDAK TERSEDIA SESUAI JATAH)

        </p>
        <div style="margin-left:25px;font-size:12px;min-height:900px">
            <div>
                <p>Saya yang bertanda tangan dibawah ini :</p>
                <table border="0" width="100" style="font-size:12px" cellpadding="5px">
                    <tr>
                        <td width="40%">Nama</td>
                        <td width="3%">:</td>
                        <td><?= isset($data->question2->text1)?$data->question2->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td><?= isset($data->question2->text2)?$data->question2->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>:</td>
                        <td><?= isset($data->question2->text3)?$data->question2->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= isset($data->question2->text4)?$data->question2->text4:'' ?></td>
                    </tr>
                    <tr>
                        <td>No.HP</td>
                        <td>:</td>
                        <td><?= isset($data->question2->text5)?$data->question2->text5:'' ?></td>
                    </tr>
                </table>
            </div>
            <div style="font-size:12px">
                <p>Adalah <?= isset($data->question3)?$data->question3:'....' ?> (sebutkan hubungan dengan pasien) dari pasien yang nama tertera didalam
                    label
                    atas :</p>

                <p>Dikarenakan hak jatah ruangan pasien ketika masuk rumah sakit penuh. Maka dengan ini saya menyatakan
                    bahwa :<br>

                    1. Hak jatah kelas BPJS pasien adalah <?= isset($data->question5->item1->{'column1'})?$data->question5->item1->{'column1'}:'....' ?><br>
                    2. Ruangan yang ditempati saat masuk rumah sakit adalah <?= isset($data->question5->item2->{'column1'})?$data->question5->item2->{'column1'}:'....' ?> Kelas
                    <?= isset($data->question5->item3->{'column1'})?$data->question5->item3->{'column1'}:'....' ?><br>
                    3. Saya bersedia pasien dipindahkan kembali ketika ruangan yang sesuai jatah telah tersedia.<br>
                    4. Jika tidak bersedia pindah maka saya bersedia untuk melakukan pernyataan selisih tarif terhitung
                    dari
                    awal pasien masuk rumah sakit.<br>
                    5. Jika BPJS kelas 3 tidak bersedia dipindahkan ketika ruangan tersedia maka saya bersedia UMUM.
                    Dikarenakan BPJS kelas 3 tidak boleh naik kelas atau selisih tarif.<br>
                    Demikianlah surat pernyataan ini dibuat dengan sebenarnya, dalam keadaan sadar dan tanpa ada paksaan
                    dari pihak manapun dan untuk dipergunakan sebagaimana mestinya.</p>
                <br><br><br><br><br>
                <div style="float: left">
                    <span style="font-family:arial">Bukittinggi, <?= isset($pernyataan_titip->tgl_input)?date('d-m-Y',strtotime($pernyataan_titip->tgl_input)):'' ?></span><br>
                    <center><span style="font-family:arial;">Pasien/Penanggung Jawab Pasien</span></center>
                    <center><img width="80px" src="<?= isset($data->question8)?$data->question8:'' ?>" alt=""> </center><br>
                    <center><span style="font-family:arial;">(<?= isset($data->question2->text1)?$data->question2->text1:'' ?>)</span><center>
                    <center><span style="font-family:arial;">Nama jelas & tanda tangan</span></center>
                </div>

                <div style="float: right">
                    
                    <span style="font-family:arial">Petugas Rumah Sakit</span>
                    <br><br><br><br><br><br>
                    <center><span style="font-family:arial;">(.....................)</span><center>
                    <center><span style="font-family:arial;">Nama jelas & tanda tangan</span></center> 
                </div>
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

        </div>

            <div style="display:flex;font-size:12px;font-family:arial">
                <div style="font-family:arial">
                    Hal 1 dari 1
                </div>
                <div style="margin-left:525px;font-family:arial">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>

    </div>