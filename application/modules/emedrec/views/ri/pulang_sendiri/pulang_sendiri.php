<?php
$data = (isset($pulang_sendiri->formjson)?json_decode($pulang_sendiri->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }
        #footer{
            position: relative;
        }

        #place{
            position: absolute;
            right: 30px;
        }

        #name_dokter{
            position: absolute;
            right: 80px;
            top: 20px;
            font-weight: bold;
        }

        #ttd_dokter{
            position: absolute;
            right: 50px;
            top: 100px;
        }

        #text-footer1{
            position: absolute;
            right: 10px;
            top: 250px;
        }

        #text-footer2{
            position: absolute;
            left: 10px;
            top: 250px;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4><u>PULANG ATAS PERMINTAAN SENDIRI</u></h4></center>
            <div style="font-size:12px;min-height:870px">
                <p>Saya yang bertanda tangan di tangan dibawah ini <?= isset($data->question4)?$data->question4:'' ?>  dari pasien/ pasien sendiri  </p>
                <table style="margin-left: 20px;" cellpadding="4px" cellspacing="3px">
                    <tr>
                        <td>Nama</td>
                        <td>: <?= isset($data->identitas->nama)?$data->identitas->nama:'........' ?></td>
                    </tr>
                    <tr>
                        <td>Umur</td>
                        <td>: <?= isset($data->identitas->umur)?$data->identitas->umur:'........' ?></td>
                    </tr>
                    <tr>
                        <td>No. RM</td>
                        <td>: <?= isset($data->identitas->no_rm)?$data->identitas->no_rm:'........' ?></td>
                    </tr>
                    <tr>
                        <td>Dirawat di Ruang</td>
                        <td>: <?= isset($data->identitas->dirawat)?$data->identitas->dirawat:'........' ?></td>
                    </tr>
                    <tr>
                        <td>Alasan Pulang</td>
                        <td>: <?= isset($data->identitas->alasan_pulang)?$data->identitas->alasan_pulang:'........' ?></td>
                    </tr>
                </table>
                <p>Menyatakan  telah melanggar nasehat Dokter untuk dirawat sesuai dengan rencana dan meminta pulang atas kemauan sendiri, dengan menanggung segala akibatnya.</p>
                <br><br><br><br><br><br>
                <div style="display: inline; position: relative;">
                    <div style="float: left;">
                            <p>&nbsp;</p>
                            <p>DPJP/Dokter Jaga/ Perawat</p>
                            <?php
                            $id =isset($pulang_sendiri->id_pemeriksa)?$pulang_sendiri->id_pemeriksa:null;
                            //  var_dump($id);                                     
                            $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                            if(isset($query->ttd)){
                            ?>

                                <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                
                            <?php
                                } else {?>
                                    <br><br><br><br>
                            <?php } ?>  
                            <span>(<?= (isset($pulang_sendiri->nm_pemeriksa)?$pulang_sendiri->nm_pemeriksa:'')?>)</span><br> 
                            <span>Tanda tangan & Nama Terang </span>      
                    </div>
                    <div style="float: right;">
                        <p>Bukittinggi, <?= isset($pulang_sendiri->tgl_input)?date('d-m-Y',strtotime($pulang_sendiri->tgl_input)):'' ?></p>
                        <p style="text-align: center;">Yang Menyatakan,</p>
                        <img width="70px" src="<?= isset($data->yg_menyatakan)?$data->yg_menyatakan:'' ?>" alt=""><br>
                        <span style="margin-left: 31px;">(<?= isset($data->question2)?$data->question2:'' ?>)</span><br>  
                        <span style="margin-left: 31px;">Tanda tangan & Nama Terang </span>      
                    </div>
    
                </div>
            </div>

            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    </body>

 
</html>