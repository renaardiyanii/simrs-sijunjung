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
    <td colspan="4">
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       <tr>
            <td colspan="4">
            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5;">
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 18px;">SERAH TERIMA BAYI DENGAN KELUARGA PASIEN<br><br><br></td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 10px; font-size: 14px;">
                Telah diserahkan seorang bayi pada jam <span style="border-bottom: 1px solid black;">........................</span> WIB, 
                hari <span style="border-bottom: 1px solid black;">........................</span> <br>tanggal 
                <span style="border-bottom: 1px solid black;">......................................</span> tahun 
                <span style="border-bottom: 1px solid black;">......................................</span> kepada keluarga bayi: 
                <span style="border-bottom: 1px solid black;">......................................</span> (hubungan dengan pasien)
            </td>
        </tr>
        <tr>
            <td style="width: 30%; padding: 8px;">Nama Bayi</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Jenis Kelamin</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">No. Rekam Medis</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Nama Ibu</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">No. Rekam Medis</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Alamat</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; text-align: center; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5;">
        <tr>
            <td style="width: 50%; font-weight: bold;">Keluarga yang menerima,</td>
            <td style="width: 50%; font-weight: bold;">Petugas yang menyerahkan,</td>
        </tr>
        <tr>
            <td style="padding: 40px;">(TTD)</td>
            <td style="padding: 40px;">(TTD)</td>
        </tr>
        <tr>
            <td>Nama: ________________________</td>
            <td>Nama: ________________________</td>
        </tr>
        <tr>
            <td>Alamat: ________________________</td>
            <td>Alamat: ________________________</td>
        </tr>
    </table>
            </td>
            
       </tr>
       
    </table>
    </td>
    </div>
    
</body>

</html>