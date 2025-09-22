<?php
 $data = (isset($cuti_perawatan->formjson)?json_decode($cuti_perawatan->formjson):'');
//  var_dump($data->question8->item1->column1);
?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            /* border: 1px solid black;     */
            width: 100%;
            font-size: 12px;
            position: relative;
            
        }

        #data tr td{
            
            font-size: 12px;
            font-family:arial;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:14px;font-family:arial">
                PERMOHONAN IZIN<br>
                PULANG DALAM JANGKA WAKTU TERTENTU / CUTI PERAWATAN
            </p>
            <div style="font-size:12px;font-family:arial">
                <p style="font-family:arial">
                    Saya yang bertanggung jawab terhadap pasien meminta ke pada Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi untuk mengijinkan kepada : 
                </p>

                <table id="data" width="100%" cellpadding="5px">
                    <tr>
                        <td width="20%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal lahir / Umur</td>
                        <td>:</td>
                        <td><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?></td>
                    </tr>
                    <tr>
                        <td>No. Rekam Medik</td>
                        <td>:</td>
                        <td><?= isset($data_pasien[0]->no_medrec)?$data_pasien[0]->no_medrec:'' ?></td>
                    </tr>
                    <tr>
                        <td>Dirawat di ruang</td>
                        <td>:</td>
                        <td><?= isset($data_pasien[0]->nmruang)?$data_pasien[0]->nmruang:'' ?></td>
                    </tr>
                </table>

                <p style="font-family:arial">Untuk izin pulang sementara (cuti perawatan) karena kepentingan :</p>
                <div style="min-height:50px"><?= isset($data->question3)?$data->question3:'' ?></div>
                <span>Dalam waktu <?= isset($data->question4)?$data->question4:'....' ?></span>
                <span style="margin-left:10px">hari (mulai tanggal <?= isset($data->question5)?date('d-m-Y',strtotime($data->question5)):'.....' ?> </span>
                <span style="margin-left:30px">s/d tanggal <?= isset($data->question6)?date('d-m-Y',strtotime($data->question6)):'.....' ?> ) </span><br><br><br>

                <p style="font-family:arial">
                    Selama berada di luar Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi yang bertanggung jawab terhadap pasien adalah :
                </p>

                <table id="data" width="100%" cellpadding="5px">
                    <tr>
                        <td width="25%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question7->text1)?$data->question7->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td>No KPT / SIM</td>
                        <td>:</td>
                        <td><?= isset($data->question7->text2)?$data->question7->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Hubungan dengan pasien</td>
                        <td>:</td>
                        <td><?= isset($data->question7->text3)?$data->question7->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td><?= isset($data->question7->text4)?$data->question7->text4:'' ?></td>
                    </tr>
                </table>

                <p style="font-family:arial">
                    Selama berada di luar Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi pasien berada <?= isset($data->question8->item1->column1)?$data->question8->item1->column1:'.....' ?>
                </p>

                <p style="font-family:arial">
                    No telepon yang bisa dihubungi  <?= isset($data->question9->item1->column1)?$data->question9->item1->column1:'.....' ?>
                </p><br><br><br><br><br><br>

                <div style="float: right;text-align: center;font-family:arial">
                    <p style="font-family:arial">Bukittinggi, <?= isset($cuti_perawatan->tgl_input)?date('d-m-Y',strtotime($cuti_perawatan->tgl_input)):'' ?></p>
                    <p style="font-family:arial">PEMOHON</p>
                    <img width="80px" src="<?= isset($data->question11)?$data->question11:'' ?>" alt=""><br>
                    <span style="font-family:arial">(<?= isset($data->question7->text1)?$data->question7->text1:'............' ?>)</span>    
                </div>
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <div style="display:flex;font-size:12px;font-family:arial">
                <div style="font-family:arial">
                    Hal 1 dari 1
                </div>
                <div style="margin-left:490px;font-family:arial">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
          
        </div>



    </body>
</html>