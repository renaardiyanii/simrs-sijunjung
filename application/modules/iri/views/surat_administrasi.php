<?php 
 $data = (isset($penanggung_jawab->formjson)?json_decode($penanggung_jawab->formjson):'');
//  var_dump($data->question23->nama); 
?>

<!DOCTYPE html>
<html>
    <head><title>Tata Tertib Pasien</title></head>
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
        .h-2{
            height:40px;
            text-align:center;
        }
        .h-2 td{
            vertical-align:middle;
        }

        .h-3{
            height:35px;
        }
        .h-3 td{
            vertical-align:middle;
        }
        .h-3 td span{
            display: inline-block;
            line-height:1.5;
        }

        .penanda{
            background-color:#3498db; 
            color:white;
        }
        .row{
            display:flex;

        }
        .footer{
            float:right;
            margin-top:20px;
        }
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
            <p style = "font-weight:bold; font-size: 18px; text-align: center;">
                SURAT PERJANJIAN<br>
                PENYELESAIAN ADMINISTRASI PEMBAYARAN BIAYA PERAWATAN<br>
                PASIEN <?php echo isset($data_pasien->nmkontraktor)?$data_pasien->nmkontraktor:$data_pasien->carabayar ?>
            </p>
            <p style="font-size: 13px;">Yang bertanda tangan dibawah ini :</p>
                <table width="100%" border=0 cellpadding="3px">
                    <tr>
                        <td width="20%">Nama</td>
                        <td width="2%">:</td>
                        <td><?php echo isset($data->question23->nama)?$data->question23->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Hub. dengan pasien</td>
                        <td width="5%">:</td>
                        <td><?php echo isset($data->question23->hub)?$data->question23->hub:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">No. Telp/ Hp</td>
                        <td width="5%">:</td>
                        <td><?php echo isset($data->question23->no_hp)?$data->question23->no_hp:'' ?></td>
                    </tr>
                </table>
            <p style="font-size: 13px;">Bertindak atas nama sendiri/ pasien ( coret yang tidak perlu ) :</p>
                <table width="100%" border=0 cellpadding="3px">
                    <tr>
                        <td width="20%">Nama</td>
                        <td width="5%">:</td>
                        <td><?php echo isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Jenis Kelamin</td>
                        <td width="5%">:</td>
                        <td><?php echo isset($data_pasien->sex)?$data_pasien->sex:'' ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Alamat</td>
                        <td width="5%">:</td>
                        <td><?php echo isset($data_pasien->alamat)?$data_pasien->alamat:'' ?></td>
                    </tr>
                </table>
                <p style="font-size: 13px;">Dengan ini menyatakan :</p>
                <p style="font-size: 13px;">1. Bersedia untuk memenuhi dan menyelesaikan seluruh administrasi pembayaran apabila ada 
                    selisih biaya perawatan karena atas permintaan sendiri untuk naik kelas kelas perawatan 
                    yang telah menjadi hak pasien peserta BPJS non PBI, paling lambat 3 ( Tiga ) hari perawatan 
                    yang lebih tinggi dari Bersedia untuk memenuhi dan menyelesaikan seluruh administrasi pembayaran 
                    selisih biaya
                </p>
                <p style="font-size: 13px;">
                    2. Sebagai dasar Penyelesaian administrasi pasien pulang, maka saya bersedia untuk memenuhi dan menyelesaikan seluruh 
                    administrasi pembayaran selisih biaya, dengan membayar uang muka sebesar Rp.<?php echo isset($data_pasien->uang_muka_adm)?number_format( $data_pasien->uang_muka_adm,0):'0' ?>
                    yang akan di kurangi dengan total selisih biaya perawatan Ril yang menjadi Kewajiban saya
                </p>
                <p style="font-size: 13px;">
                    3. Apabila saya tidak memenuhi kewajiban sebagaimana yang telah saya nyatakan pada poin 1 (satu ) di atas, dan 
                    apabila total selisih biaya perawatan Riil yang seharusnya saya bayarkan melebihi uang muka yang telah 
                    dibayarkan maka surat perjanjian ini sekaligus berfungsi sebagai surat perjanjian Hutang yang nilainya 
                    sebesar sisa selisih biaya perawatan Riil yang seharusnya saya bayarkan.
                </p><br>
                <p style="font-size: 13px;">Demikian Perjanjian ini saya buat, untuk dipergunakan seperlunya.</p>

                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: right;text-align: center;">
                        <p>Bukittinggi, <?php echo date('d-m-Y') ?></p>
                        <img  src="<?= (isset($data->ttd_pasien)?$data->ttd_pasien:'')?>" width="120px"  height="120px" alt=""><br>  
                        <span><?php echo isset($data->question23->nama)?$data->question23->nama:'' ?></span>
                    </div>     
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <p style="font-size: 13px;"><b>Tembusan :</b></p>
                <table width="100%" border=0 cellpadding="3px">
                    <tr>
                        <td width="10%">Lembar 1</td>
                        <td width="2%">:</td>
                        <td>Bendahara Penerima</td>
                    </tr>
                    <tr>
                        <td>Lembar 2</td>
                        <td>:</td>
                        <td>Untuk PPasien</td>
                    </tr>
                    <tr>
                        <td>Lembar 3</td>
                        <td>:</td>
                        <td>Untuk Petugas Verifikasi</td>
                    </tr>
                    <tr>
                        <td>Lembar 3</td>
                        <td>:</td>
                        <td>Untuk Petugas Ruangan Rawat Inap</td>
                    </tr>
                </table>
        </div>

        <?php 
        if($data_pasien->uang_muka_adm != null || $data_pasien->uang_muka_adm != ''){ ?>
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
            <p style = "font-weight:bold; font-size: 18px; text-align: center;">
                    BUKTI PENERIMAAN UANG MUKA
            </p><br>
            
                <table width="100%" border=0 cellpadding="5px">
                    <tr>
                        <td width="30%">Telah Terima Dari</td>
                        <td width="2%">:</td>
                        <td><?php echo isset($data->question23->nama)?$data->question23->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td>Sejumlah Uang Sebesar</td>
                        <td>:</td>
                        <td><?php echo isset($data_pasien->uang_muka_adm)?number_format( $data_pasien->uang_muka_adm,0):'0' ?></td>
                    </tr>
                    <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td><?= $vtot_terbilang .' '.'rupiah' ?></td>
                    </tr>
                    <tr>
                        <td>Untuk Keperluan</td>
                        <td>:</td>
                        <td>
                            Pelayanan Rawat Pasien
                            <table width="100%" border=0 cellpadding="5px">
                                <tr>
                                    <td width="30%">Atas Nama</td>
                                    <td width="2%">:</td>
                                    <td><?php echo isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Rawatan di</td>
                                    <td>:</td>
                                    <td><?php echo isset($data_pasien->nmruang)?$data_pasien->nmruang:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Masuk Tanggal</td>
                                    <td>:</td>
                                    <td><?php echo isset($data_pasien->tgl_masuk)?date('d-m-Y',strtotime($data_pasien->tgl_masuk)):'' ?></td>
                                </tr>
                                <tr>
                                    <td>Keluar Tanggal</td>
                                    <td>:</td>
                                    <td><?php echo isset($data_pasien->tgl_keluar)?date('d-m-Y',strtotime($data_pasien->tgl_keluar)):'' ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <br><br><br>
                <p style="margin-left:550px;font-size:13px">Bukitiinggi, <?php echo date('d-m-Y') ?></p>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Yang Menyerahkan,</p>
                        <br><br><br><br><br><br><br><br><br>
                        <span><?php echo isset($data->question23->nama)?$data->question23->nama:'' ?>	</span>      
                    </div>
                    <div style="float: right;text-align: center;">
                        <p>Verifikasi yang Menerima,</p>
                        <img  src="<?= (isset($data_pasien->ttd_verif)?$data_pasien->ttd_verif:'')?>" width="120px"  height="120px" alt=""><br> 
                        <span><?php echo isset($data_pasien->nmverif)?$data_pasien->nmverif:'' ?>	</span>  
                    </div>     
                </div>
                <br><br><br><br><br><br><br><br><br><br>
                <p style="font-size: 13px;"><b>Tembusan :</b></p>
                <table width="100%" border=0 cellpadding="3px">
                    <tr>
                        <td width="10%">Lembar 1</td>
                        <td width="2%">:</td>
                        <td>Bendahara Penerima</td>
                    </tr>
                    <tr>
                        <td>Lembar 2</td>
                        <td>:</td>
                        <td>Untuk PPasien</td>
                    </tr>
                    <tr>
                        <td>Lembar 3</td>
                        <td>:</td>
                        <td>Untuk Petugas Verifikasi</td>
                    </tr>
                    <tr>
                        <td>Lembar 3</td>
                        <td>:</td>
                        <td>Untuk Petugas Ruangan Rawat Inap</td>
                    </tr>
                </table>
        </div>
        <?php 
    }
        ?>
    </body>
</html> 