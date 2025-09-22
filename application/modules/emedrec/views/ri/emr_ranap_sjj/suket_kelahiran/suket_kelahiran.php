<?php 
$data = isset($pengantar_ranap->formjson)?json_decode($pengantar_ranap->formjson):'';
// var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
          
            <table border="0" width="100%" cellspacing="0" cellpadding="5">
            <h2 style="text-align: center;">SURAT KETERANGAN KELAHIRAN</h2>
            <p style="text-align: center;">Nomor : _______/RSUD-SJJ/_______/2018</p>
            <p>Yang bertanda tangan di bawah ini : Dokter Spesialis Kandungan/Bidan Rumah Sakit Umum Daerah Sijunjung, dengan ini menerangkan bahwa :</p>
                    <tr>
                        <td>Nama Ibu</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Nama Bapak</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>......................................................</td>
                    </tr>
                </table>
                
                <p>Telah melahirkan seorang anak,</p>
                
                <table border="0" width="100%" cellspacing="0" cellpadding="5">
                    <tr>
                        <td>Hari</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Jam</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>......................................................</td>
                    </tr>
                </table>
                
                <p><b>Bayi yang diberi nama :.................</b></p>
                
                
                <p><b>Dengan Data Kelahiran:</b></p>
                <table border="0" width="100%" cellspacing="0" cellpadding="5">
                    <tr>
                        <td>Berat Badan</td>
                        <td>......................................................Gram</td>
                    </tr>
                    <tr>
                        <td>Panjang Badan</td>
                        <td>...................................................... Cm</td>
                    </tr>
                    <tr>
                        <td>Kelahiran Normal</td>
                        <td><input type="checkbox">YA <input type="checkbox">TIDAK</td>
                    </tr>
                    <tr>
                        <td>Kelahiran dengan Tindakan</td>
                        <td><input type="checkbox">YA <input type="checkbox">TIDAK</td>
                    </tr>
                    <tr>
                        <td>Kelainan Bawaan Lahir</td>
                        <td>......................................................</td>
                    </tr>
                    <tr>
                        <td>Kembar</td>
                        <td><input type="checkbox">YA <input type="checkbox">TIDAK</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>......................................................Orang</td>
                    </tr>
                </table>
                
                <p style="text-align: right;">Sijunjung, .......................</p>
                <p style="text-align: right;">Penolong Persalinan</p>
                <p style="text-align: right;"><br><br>(_________________________)</p>
            </td>
       </tr>
       
    </table>
               
    </div>
  
</body>

</html>