<?php
$data = (isset($suket_sakit->formjson)?json_decode($suket_sakit->formjson):'');
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
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
        <header style="margin-top:20px; font-size:1pt!important;">

            <table border="0" width="100%">
                <tr>
                    <td width="13%">
                        <p align="center">
                        <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                    <td  width="74%" style="font-size:9px;" align="center">
                        <font style="font-size:8pt!important">
                            <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                        </font>
                        <font style="font-size:8pt">
                            <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                            <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                        </font>    
                        <br>
                        <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                        <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                    </td>
                    <td width="13%">
                        <p align="center">
                            <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>

                </tr>
        
            </table>
        </header>

            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <p style="font-weight:bold;font-size: 16px; text-align: center;">
               <u> SURAT KETERANGAN SAKIT</u>
            </p>
            <center>
                <p style="font-size:14px;">Nomor: <?= isset($data->question2)?$data->question2:'' ?></p>
            </center><br>
            <div style="margin-left:25px">
                <div style="font-size: 14px;">
                    <p>Yang bertanda tangan dibawah ini Direktur Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi menerangkan
                        bahwa : </p>
                    <table border="0" width="100%" style="font-size:14px" cellpadding="5px" cellspacing="3px">
                        <tr>
                            <td width="20%">Nama</td>
                            <td width="3%">:</td>
                            <td><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td>Umur</td>
                            <td>:</td>
                            <?php 
                            $datetime1 = new DateTime($data_pasien[0]->tgl_lahir); // start time
                            $datetime2 = new DateTime(date('Y-m-d')); // end time
                            $interval = $datetime1->diff($datetime2);
                           $umur =  $interval
                                 ->format('%Y');
                            ?>
                            <td><?= $umur.' '.'Tahun'?></td>
                        </tr>
                        <tr>
                            <td>Jenis Kelamin</td>
                            <td>:</td>
                            <?php 
                            if($data_pasien[0]->sex == 'P'){
                                $jenkel = 'Perempuan';
                            }else{
                                $jenkel = 'Laki Laki';
                            }
                            ?>
                            <td><?= isset($jenkel)?$jenkel:'' ?></td>
                        </tr>
                        <tr>
                            <td>Pekerjaan</td>
                            <td>:</td>
                            <td><?= isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan:'' ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= isset($data_pasien[0]->alamat)?$data_pasien[0]->alamat:'' ?></td>
                        </tr>
                    </table>
                </div><br>
                <p style="font-size: 14px;">
                    Menurut hasil pemeriksaan yang bersangkutan saat ini dalam keadaan sakit, oleh sebab itu perlu diberi
                    istirahat selama <?= isset($data->question3->text1)?$data->question3->text1:'.....' ?> Hari, mulai tanggal <?= isset($data->question3->text2)?date('d-m-Y',strtotime($data->question3->text2)):'....' ?> Sampai
                    tanggal <?= isset($data->question3->text3)?date('d-m-Y',strtotime($data->question3->text3)):'.....' ?>
                </p>
                <br><br><br><br><br>

                <div style="float: right; font-size:12px;">
                    <p>Bukittinggi, <?= isset($suket_sakit->tgl_input)?date('d-m-Y',strtotime($suket_sakit->tgl_input)):'.....' ?></p>
                    <p>A.n. Direktur RS. Otak DR. Drs. M. Hatta Bukittinggi</p>
                    <p>Dokter yang menerangkan,</p>
                    <?php
                            $id = $suket_sakit->id_pemeriksa ?? null;

                            $result = $id ? $this->db->query("SELECT ttd,name FROM hmis_users  where userid = '$id'")->row() : null;
                            if (isset($result->ttd)) {
                            ?>
                    <img width="80px" height="80px" src="<?= $result->ttd ?>" alt=""><br>
                    <span><?= isset($result->name) ? $result->name : '' ?></span>
                    <?php } ?>
                    <p>( Nama & tanda tangan )</p>
                </div>

            </div><br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:left;font-size:12px">*)Coret yang tidak perlu</p>

        </div>
    </body>