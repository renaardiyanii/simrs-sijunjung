<?php 
$data = isset($transfusi_darah->formjson)?json_decode($transfusi_darah->formjson):'';
?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

    <body class="A4">
    <div class="A4 sheet  padding-fix-10mm"><br>
        <header>
            <table style="width: 100%; border: 0;">
                <tr>
                    <td style="text-align: center;">
                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 15px; text-align: center;">
                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                        <label>JL. Lintas Sumatera Km 110 Tanah Badantuang Kabupaten Sijunjung</label><br>
                        <label>Email : rsudsijunjung1@gmail.com</label>
                    </td>
                </tr>
            </table>

        </header>
        <div style="border-bottom: 1px solid black;"></div>
        <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>
      
        <center>
            <u><span style="font-size:17px;font-weight:bold;">PERMINTAAN TRANSFUSI DARAH</span></u><br>
        </center>
        <br><br>
        <div style="font-size:14px;">
            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                     <td style="font-size: 14px" width="30%">Kepada Rumah Sakit : <?= isset($data->transfusi->rs)?$data->transfusi->rs:'' ?></td>
                     <td style="font-size: 14px" width="30%">Bag : <?= isset($data->transfusi->bag)?$data->transfusi->bag:'' ?></td>
                     <td style="font-size: 14px">Kelas : <?= isset($data->transfusi->kelas)?$data->transfusi->kelas:'' ?></td>
                 </tr>
            </table>
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
            
                <tr>
                    <td style="font-size: 14px">Dr. yang meminta</td>
                    <td></td>
                    <td>:</td>
                    <td> <?= isset($data->question1->item1->dr)?$data->question1->item1->dr:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 14px">No. Rekam Medis</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question1->item1->noreg)?$data->question1->item1->noreg:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Nama OS</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question1->item1->nm_os)?$data->question1->item1->nm_os:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Umur</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question1->item1->umur)?$data->question1->item1->umur:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Jenis Kelamin</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question1->item1->jk)?$data->question1->item1->jk:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Alamat</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question1->item1->alamat)?$data->question1->item1->alamat:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size: 14px">Diagnosa (sementara)</td>
                    <td></td>
                    <td>:</td>
                    <td>
                        <?= isset($data->question1->item1->diagnosa) 
                            ? nl2br($data->question1->item1->diagnosa) 
                            : '' ?>
                    </td>

                </tr>
                <tr>
                    <td style="font-size: 14px">Indikasi Tegas</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question1->item1->indikasi)?$data->question1->item1->indikasi:'' ?></td>
                </tr>
            </table>

            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="font-size: 14px">Diperlukan Tgl : <?= isset($data->question1->item1->diperlukan)?date('d-m-Y',strtotime($data->question1->item1->diperlukan)):'' ?></td>
                     <td style="font-size: 14px">Jam : <?= isset($data->question1->item1->indikasi)?date('h:i',strtotime($data->question1->item1->diperlukan)):'' ?></td>
                     
                 </tr>
                 <tr>
                    <td style="font-size: 14px">Trasf. Sebelumnya : <?= isset($data->question1->item1->trafs)?$data->question1->item1->trafs:'' ?></td>
                     <td style="font-size: 14px">Kapan : <?= isset($data->question1->item1->kapan)?$data->question1->item1->kapan:'' ?></td>
                     
                 </tr>
            </table>
           
            <br>
            <span>Untuk OS Wanita :</span>
            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <tr>
                    <td style="font-size: 14px">Pernah hamil : <?= isset($data->question1->item1->p_hamil)?$data->question1->item1->p_hamil:'' ?></td>
                     <td style="font-size: 14px">Abortus : <?= isset($data->question1->item1->abortus)?$data->question1->item1->abortus:'' ?></td>
                     <td style="font-size: 14px">Partus : <?= isset($data->question1->item1->partus)?$data->question1->item1->partus:'' ?></td>
                 </tr>
            </table>
            <br>
            <table border="0" width="100%" style="border-collapse: collapse; margin-top: 10px;">
                <span>Jenis Darah yang diperlukan</span>
                <tr>
                    <td style="font-size: 14px; padding: 10px;" width="30%">1.Whole Blood </td>
                     <td style="font-size: 14px; padding: 10px;">:<?= isset($data->question2->whole)?$data->question2->whole:'.........................' ?> cc</td>
                 </tr>
                 <tr>
                    <td style="font-size: 14px; padding: 10px;">2. Packed Red Cells</td>
                    <td style="font-size: 14px; padding: 10px;">:<?= isset($data->question2->packed)?$data->question2->packed:'.........................' ?> unit</td>
                 </tr>
                 <tr>
                    <td style="font-size: 14px; padding: 10px;">3. Liquid Plasma</td>
                    <td style="font-size: 14px; padding: 10px;">:<?= isset($data->question2->liquid)?$data->question2->liquid:'.........................' ?> unit</td>
                 </tr>
                 <tr>
                    <td style="font-size: 14px; padding: 10px;">4. Trombosit</td>
                    <td style="font-size: 14px; padding: 10px;">:<?= isset($data->question2->trombosit)?$data->question2->trombosit:'.........................' ?> unit</td>
                 </tr>
                 <tr>
                    <td style="font-size: 14px; padding: 10px;">5. FFP</td>
                    <td style="font-size: 14px; padding: 10px;">:<?= isset($data->question2->ffp)?$data->question2->ffp:'.........................' ?> unit</td>
                 </tr>
                 
            </table>
            <br>
            <table style="margin-left: 5; border-collapse: separate; border-spacing: 0 10px;">
                <tr>
                    <td style="font-size: 14px">Hal Hal lainnya</td>
                    <td></td>
                    <td>:</td>
                    <td><?= isset($data->question3)?$data->question3:'.........................' ?></td>
                </tr>
           <br><br>
             <div style="display: inline; position: relative;">
                    
                    <div style="float: right;margin-top: 15px;">
                            <p>Tanah Badantung, <?= isset($transfusi_darah->tgl_input)?date('d-m-Y',strtotime($transfusi_darah->tgl_input)):'' ?></p>
                            <p>Dokter Konsulen</p>
                            <br><br><br>
                            <?php 
                            $id1 =isset($transfusi_darah->id_pemeriksa)?$transfusi_darah->id_pemeriksa:null;                                    
                            $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                            ?>
                            <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br> 
                           
                    </div>  
                </div>
        </div>
    </div>

    </body>
</html>