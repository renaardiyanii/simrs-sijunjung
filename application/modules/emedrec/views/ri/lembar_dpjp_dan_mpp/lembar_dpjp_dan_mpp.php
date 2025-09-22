<?php 
// var_dump($data_pasien[0]);
// $query = $this->db->query("SELECT hmis_users.ttd FROM dyn_user_dokter LEFT JOIN hmis_users on dyn_user_dokter.userid = hmis_users.userid WHERE dyn_user_dokter.id_dokter = ".$data_pasien[0]->id_dokter." ")->row()->ttd;
// var_dump($drtambahan_iri);
?>
<!DOCTYPE html>
<html>
    <head><title>Lembar Dpjp Dan Mpp</title></head>
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
        #footer{
            display:flex;
            justify-content:space-between;
        }
        .penanda{
            background-color:#3498db;
            color:white;
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
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13pt; text-align: center;">
                LEMBAR DPJP DAN MPP
            </p>
            <div>
                <table id="data">
                    <tr>
                        <td width="60%"><p>Diagnosa Medis :</p></td>
                        <td width="30%"><p >Jaminan : <?= isset($data_pasien[0]->carabayar)?$data_pasien[0]->carabayar:"" ?></p></td>
                       
                    </tr>
                </table>
            
                <table id="data">
                    <tr>
                        <td style="width: 50%;">
                            <p >DPJP Utama :  <?= isset($data_pasien[0]->dokter)?$data_pasien[0]->dokter:'' ?></p>
                        </td>
                        
                        <td style="width: 50%;">
                            <p>Tanggal 		: <?= isset($data_pasien[0]->tgl_masuk)?date('d/m/Y',strtotime($data_pasien[0]->tgl_masuk)):'' ?></p>
                            <p>Tanda Tangan 	: </p>
                            <?php
                            if(isset($data_pasien[0]->id_dokter)){
                            $query = $this->db->query('SELECT hmis_users.ttd FROM dyn_user_dokter LEFT JOIN hmis_users on dyn_user_dokter.userid = hmis_users.userid WHERE dyn_user_dokter.id_dokter = '.$data_pasien[0]->id_dokter.' ')->row()->ttd;
                            
                            ?>
                            <img width="60px" src="<?= $query ?>" alt="">
                            <?php } ?>
                        </td>
                    </tr>
                </table>

                <p>Rawat Bersama</p> 
                <table id="data" border="1">
                    <tr>
                        <td style="width: 50%;"><p>DPJP Utama	: <?= isset($data_pasien[0]->dokter)?$data_pasien[0]->dokter:'' ?></p></td>
                        <td style="width: 50%;"><p>Tgl	: <?= isset($data_pasien[0]->tgl_masuk)?date('d/m/Y',strtotime($data_pasien[0]->tgl_masuk)):'' ?></p></td>
                    </tr>
                    <?php
                    if(count($drtambahan_iri)>0){
                        foreach($drtambahan_iri as $val){
                            if($val->ket == 'Dokter Bersama'){
                    ?>
                    <tr>
                        <td ><p>DPJP	: <?= $val->nm_dokter ?> </p></td>
                        <td ><p>Tgl	: <?= date('d/m/Y',strtotime($val->xcreate)) ?></p></td>
                    </tr>
                    <?php } } }else{ ?>
                    <tr>
                        <td ><p>DPJP	: </p></td>
                        <td ><p>Tgl	: </p></td>
                    </tr>
                    <?php } ?>
                   
                </table>

                <p>Peralihan DPJP Utama</p> 
                <table id="data" border="1">
                <?php
                    if(count($drtambahan_iri)>0){
                        foreach($drtambahan_iri as $val){
                            if(stripos($val->ket,'sebelumnya')){
                    ?>
                     <tr>
                        <td style="width: 50%;"><p>DPJP Peralihan	: <?= $val->nm_dokter??"" ?></p></td>
                        <td style="width: 50%;" rowspan="4"></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><p>Tanggal	: <?= date('d/m/Y',strtotime($val->xcreate))??"" ?></p></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><p>Alasan	: </p></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><p>Peralihan DPJP Utama	:  <?= isset($data_pasien[0]->dokter)?$data_pasien[0]->dokter:'' ?></p></td>
                    </tr>
                    <?php }}}else{ ?>
                    <tr>
                        <td style="width: 50%;"><p>DPJP Peralihan	:</p></td>
                        <td style="width: 50%;" rowspan="4"></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><p>Tanggal	:</p></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><p>Alasan	:</p></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><p>Peralihan DPJP Utama	:	:</p></td>
                    </tr>
                    <?php } ?>
                </table>

                <p>MPP</p> 
                <table id="data" border="1" style="height: 80px;margin-top: -10px;">
                <?php
                    if(count($drtambahan_iri)>0){
                        foreach($drtambahan_iri as $val){
                            if($val->ket == 'case_manager'){
                    ?>
                    <tr>
                        <td style="width: 50%;">
                            <p>MPP	 : <?= $val->nm_dokter??"" ?></p>
                        </td>
                        
                        <td style="width: 50%;">
                            <p>Tanda Tangan 		: </p>
                            <?php $dokter = $val->id_dokter;$query = $this->db->query("SELECT hmis_users.ttd FROM dyn_user_dokter LEFT JOIN hmis_users on hmis_users.userid = dyn_user_dokter.userid WHERE dyn_user_dokter.id_dokter = $dokter")->row();
                            // var_dump($query);
                            ?>
                            <?php
                            if($query){
                            ?>
                            <img width="60px" src="<?= $query->ttd; ?>" alt="">
                            <?php } ?>
                        </td>
                    </tr>
                    <?php }
                }
                }else{ ?>
                    <tr>
                        <td style="width: 50%;">
                            <p>MPP	 :</p>
                        </td>
                        
                        <td style="width: 50%;">
                            <p>Tanda Tangan 		:</p>
                        </td>
                    </tr>
                    <?php } ?>
                    
                </table>   
                <p>Penanggung Jawab</p> 
                <table id="data" border="1" style="height: 80px;margin-top: -10px;">
                <?php
                    if(count($drtambahan_iri)>0){
                        foreach($drtambahan_iri as $val){
                            if($val->ket == 'dokter_ruangan'){
                    ?>
                   <tr>
                        <td style="width: 50%;">
                            <p>MPP	 : <?= $val->nm_dokter??"" ?></p>
                        </td>
                        
                        <td style="width: 50%;">
                            <p>Tanda Tangan 		: </p>
                            <?php $dokter = $val->id_dokter;$query = $this->db->query("SELECT hmis_users.ttd FROM dyn_user_dokter LEFT JOIN hmis_users on hmis_users.userid = dyn_user_dokter.userid WHERE dyn_user_dokter.id_dokter = $dokter")->row();
                            // var_dump($query);
                            ?>
                            <?php
                            if($query){
                            ?>
                            <img width="60px" src="<?= $query->ttd; ?>" alt="">
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                            }}}
                    ?>
                </table> 
                <div id="footer">
                    <p style="font-size:8pt;">Hal 1 dari 1</p>
                    <p style="font-size:8pt;">29.11.2019.RM-027 / RI</p>
                </div>

              
            </div>
        </div>
       
    </body>
</html>