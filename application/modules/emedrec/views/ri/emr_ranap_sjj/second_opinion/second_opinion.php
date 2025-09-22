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
    <tr>
    <td colspan="4">
    <table border="0" width="100%" align="center" cellpadding="5px" style="margin-top:20px; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5;">
        <tr>
            <td colspan="2" style="text-align: center; font-weight: bold; font-size: 18px; padding: 10px;">PERMINTAAN PENDAPAT LAIN<br>(SECOND OPINION)</td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 10px;">Saya yang bertandatangan di bawah ini,</td>
        </tr>
        <tr>
            <td style="width: 30%; padding: 8px;">Nama</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Alamat</td>
            <td style="padding: 8px;">: ________________________</td>
        </tr>
        <tr>
            <td style="padding: 8px;">Umur</td>
            <td style="padding: 8px;">: ______ tahun</td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 10px;">
                Dengan ini menyatakan permintaan untuk mendapat <i>second opinion</i> atas:<br>
                __________________________________________________________
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding: 10px;">
                Saya memahami perlunya dan manfaat Pendapat lain (<i>second opinion</i>) tersebut sebagaimana telah dijelaskan kepada saya.
                <br><br>
                Saya telah mendapat kesempatan untuk bertanya dan telah mendapat jawaban yang memuaskan.
                <br><br>
                Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti dan selalu berkembang, maka perbedaan pendapat ahli adalah biasa terjadi dalam dunia kedokteran.
                <br><br>
                Saya menyadari beban biaya <i>second opinion</i> menjadi tanggung jawab saya.
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; padding: 10px;">
                Tanah Badantuang, ____________________ Pukul: ______ WIB
            </td>
        </tr>
    </table>
    <br>
    <table width="80%" align="center" style="text-align: center; font-family: Arial, sans-serif; font-size: 13px; line-height: 1.5; border-collapse: collapse;">
        <tr>
            <td style="width: 33%; font-weight: bold; padding: 10px;">Saksi 1</td>
            <td style="width: 33%; font-weight: bold; padding: 10px;">Saksi 2</td>
            <td style="width: 33%; font-weight: bold; padding: 10px;">Yang Menyatakan<br>Pasien / Wali **</td>
        </tr>
        <tr>
            <td style="padding: 30px;">________________________</td>
            <td style="padding: 30px;"> ________________________</td>
            <td style="padding: 30px;"> ________________________ </td>
        </tr>
        <tr>
            <td colspan="3" style="font-weight: bold; padding-top: 20px;">DPJP</td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 30px;"> ________________________ </td>
        </tr>
       
    </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div>
                <div style="margin-right:530px; font-size:14px;">
                KOMITE REKAM MEDIS
                    </div>
                <div style="margin-left:530px; font-size:14px;">
                Rev.I.I/2018/RM.06.f/RI 
                    </div>
               </div>
    </td>
    </tr>
    </div>
    
</body>

</html>