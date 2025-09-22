<?php
$data = (isset($selisih_tarif->formjson) ? json_decode($selisih_tarif->formjson) : '');
// var_dump($data);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Surat Pernyataan Selisih Tarif</title>
</head>
<style>
#data {
    /* margin-top: 20px; */
    border-collapse: collapse;
    border: 1px solid black;
    width: 100%;
    font-size: 10px;
    /* position: relative; */
    text-align: justify;

}

.h-2 {
    height: 40px;
    text-align: center;
}

.h-2 td {
    vertical-align: middle;
}

.h-3 {
    height: 35px;
}

.h-3 td {
    vertical-align: middle;
}

.h-3 td span {
    display: inline-block;
    line-height: 1.5;
}

.penanda {
    background-color: #3498db;
    color: white;
}

.row {
    display: flex;

}

.footer {
    float: right;
    margin-top: 20px;
}

p {
    text-align: justify;
}
ol>li {
    text-align:justify;
}
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>

        <p style="font-weight:bold; font-size: 14px; text-align: center;">
            SURAT PERNYATAAN SELISIH TARIF
        </p>

        <div style="font-size: 12px;min-height:600px">
            <p>Saya yang bertanda tangan dibawah ini :</p>
            <table>
                <tr>
                    <p style="margin-left: 20px;">
                        <span>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?= isset($data->data->text1) ? $data->data->text1 : '' ?></td>
                        </span>
                    </p>
                </tr>
                <tr>
                    <p style="margin-left: 20px;">
                        <span>
                            <td>No KTP</td>
                            <td>:</td>
                            <td><?= isset($data->data->text2) ? $data->data->text2 : '' ?></td>
                        </span>
                    </p>
                </tr>
                <tr>
                    <p style="margin-left: 20px;">
                        <span>
                            <td>Umur</td>
                            <td>:</td>
                            <td><?= isset($data->data->text4) ? $data->data->text4 : '' ?></td>
                        </span>
                    </p>
                </tr>
                <tr>
                    <p style="margin-left: 20px;">
                        <span>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= isset($data->data->text3) ? $data->data->text3 : '' ?></td>
                        </span>
                    </p>
                </tr>
            </table>
            <p>Adalah <?= isset($data->question2) ? $data->question2 : '' ?> (sebutkan hubungan dengan pasien) dari
                pasien yang nama tertera didalam label atas.</p>
            <p>
                <span>Dengan ini menyatakan bersedia membayar selisih tarif sesuai aturan yang berlaku di Rumah
                    Sakit Otak DR.Drs.M.Hatta Bukittinggi tentang : <b>PENETAPAN PENGENAAN SELISIH BIAYA DALAM
                        PROGRAM JAMINAN KESEHATAN</b> dan terkait Permenkes No 3 Tahun 2023 tentang Standar Tarif
                    Pelayanan Kesehatan Dalam Penyelenggaraan Program Jaminan Kesehatan.</span>
            </p>
            <ol>
                <li>Peningkatan kelas perawatan yang lebih tinggi dari haknya <b>tidak dapat dilakukan oleh peserta BPJS
                        hak kelas III (tiga) baik BPJS PBI maupun BPJS Mandiri.</b></li>
                <li>Untuk peningkatan kelas perawatan kelas III (tiga) yang melebihi satu tingkat dari kelas rawatan
                    yang menjadi hak peserta tidak dijamin oleh BPJS (menjadi pasien umum dan berlaku tarif sesuai
                    ketentuan Rumah Sakit Otak DR.Drs.M. Hatta Bukittinggi).</li>
            </ol>
            <span> Pasal 48 : </span>
            <ol>
                <li>Hak rawat kelas II (dua) naik ke kelas I (satu), maka Selisih tarif INA-CBG pada kelas rawat inap
                    Kelas I (satu) dengan tarif INA-CBG pada kelas rawat inap kelas II (dua);</li>
                <li>Hak rawat kelas 1 naik ke kelas diatas kelas 1(VIP), maka selisih tarif INA-CBG kelas 1 dengan tarif
                    kelas di atas kelas 1 yaitu paling banyak sebesar 75% (tujuh puluh lima persen) dari tarif INA-CBG
                    kelas 1</li>
                <li>Hak rawat kelas 2 naik ke kelas diatas kelas 1(VIP), maka selisih tarif INA-CBG antara kelas 1
                    dengan kelas 2 ditambah paling banyak sebesar 75% (tujuh puluh lima persen) dari tarif INA-CBG kelas
                    1</li>
                <li>4. Ketentuan selisih biaya hak rawat kelas 1 naik ke kelas diatas kelas 1 dan hak rawat kelas 2 naik
                    ke kelas di atas kelas 1 (VIP) tidak berlaku apabila biaya pelayanan rawat inap di Rumah Sakit tidak
                    melebihi tarif INA-CBG sesuai hak
                    peserta.</li>
            </ol>
            <span>Demikianlah surat pernyataan ini dibuat untuk digunakan seperlunya.</span>
            <div style="display: inline; position: relative;">
                <div style="float: left;margin-top: 15px;">
                    <p>Saksi / Petugas,</p>
                    <?php
                        $id = isset($selisih_tarif->id_pemeriksa) ? $selisih_tarif->id_pemeriksa : null;
                        //  var_dump($id);                                     
                        $query = $id ? $this->db->query("SELECT ttd FROM hmis_users  where hmis_users.userid = $id")->row() : null;
                        if (isset($query->ttd)) {
                        ?>

                    <img width="80px" height="80px" src="<?= $query->ttd ?>" alt=""><br>
                    <?php
                        } else { ?>
                    <br><br><br>
                    <?php } ?>

                    <span>(<?= (isset($selisih_tarif->nm_pemeriksa) ? $selisih_tarif->nm_pemeriksa : '') ?>)</span><br>
                    <span>Tanda tangan & Nama Terang</span>
                </div>
                <div style="float: right;">
                    <span>Bukittinggi,
                        <?= isset($selisih_tarif->tgl_input) ? date('d-m-Y', strtotime($selisih_tarif->tgl_input)) : '' ?></span>
                    <p>Yang Menyatakan,</p>
                    <img src="<?= (isset($data->question7) ? $data->question7 : '') ?>" width="80px" height="80px"
                        alt=""><br>
                    <span>(<?= isset($data->data->text1) ? $data->data->text1 : '' ?>)</span><br>
                    <span>Tanda tangan & Nama Terang</span>
                </div>
            </div>

        </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <div style="display:flex;font-size:12px">
            <div style="display:flex;font-size:12px">
                <div>
                    <p>Hal 1 dari 1</p>
                </div>

            </div>
            <div style="margin-left:500px">
                <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </p>
            </div>
        </div>

</body>

</html>