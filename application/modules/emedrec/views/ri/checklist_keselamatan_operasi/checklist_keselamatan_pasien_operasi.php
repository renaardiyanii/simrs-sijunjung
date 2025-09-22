<?php
$data = (isset($checklist_keselamatan_operasi->formjson)?json_decode($checklist_keselamatan_operasi->formjson):'');
$result = array_chunk($checklist_keselamatan_operasi, 1);
// var_dump($data);die();
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 11px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
    <?php 
    if($result){
        for($i = 0;$i<count($result);$i++){ ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>CHECKLIST KESELAMATAN DI KAMAR OPERASI</h4></center>
            <?php 
            // $val = $result[$i]->formjson?json_decode($result[$i]->formjson):null;
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
                //  var_dump($value);die();
            ?>
            <table width="100%" id="data" border="1" cellpadding="3px">
                <tr>
                    <th width= "30%">Sebelum Induksi Anestesi <br>( Sign In )</th>
                    <th width= "5%">➩</th>
                    <th width= "30%">Sebelum Insisi(Time Out)</th>
                    <th width= "5%">➩</th>
                    <th width= "30%">Sebelum pasien meninggalkan Ruang Operasi  (Sign Out)</th>
                </tr>

                <tr>
                    <td>
                        <span style="font-weight:bold">Minimal ada perawat dan dr  Anestesi</span><br>
                        <span>
                        Apakah  identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada persetujuan  tindakan medis  yang akan di lakukan (inform concern)?
                        </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 1'})?  $value->question1[0]->{'Column 1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 1'})?  $value->question1[0]->{'Column 1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 
                        <br><br>

                        <span>Apakah area yang akan dioperasi sudah diberi tanda ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 2'})?  $value->question1[0]->{'Column 2'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 2'})?  $value->question1[0]->{'Column 2'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>

                        <span>Apakah mesin anestesi dan obat –obatan sudah lengkap ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 3'})?  $value->question1[0]->{'Column 3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 3'})?  $value->question1[0]->{'Column 3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>

                        <span>Apakah pasien sudah memakai pulse oksimetri dan sudah berfungsi baik?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 4'})?  $value->question1[0]->{'Column 4'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 4'})?  $value->question1[0]->{'Column 4'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>

                        <span>Apakah pasien memiliki  riwayat alergi?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 5'})?  $value->question1[0]->{'Column 5'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 5'})?  $value->question1[0]->{'Column 5'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        
                        <br><br>

                        <span>Apakah pasien memiliki gangguan pernapasan</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 6'})?  $value->question1[0]->{'Column 6'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 6'})?  $value->question1[0]->{'Column 6'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>

                        <span>Resiko perdarahan > 500 ml (7ml/kg bagi pasien anak)  bagi pasien ligasi</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question1[0]->{'Column 7'})?  $value->question1[0]->{'Column 7'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset( $value->question1[0]->{'Column 7'})?  $value->question1[0]->{'Column 7'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br>

                        <p>Tanda Tangan & Nama</p>

                        <?php
                        // var_dump($id_ok);die();                           
                        $query = $this->db->query("SELECT a.id_dok_anes,b.id_dokter,c.ttd,d.nm_dokter 
                        from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dok_anes = b.id_dokter 
                        left join hmis_users c on c.userid = b.userid left join data_dokter d on a.id_dok_anes = d.id_dokter
                        where a.idoperasi_header = $id_ok")->row();
                        // var_dump($id_ok);die();
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <span>Dokter Anestesi: <?= $query->nm_dokter ?></span><br>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>Dokter Anestesi: </span><br>
                            <?php } ?>
                       




                        <?php
                        $anes = isset($anes)?$anes:null;
                        $query1 = $this->db->query("SELECT a.perawat_anastesi,b.id_dokter,c.ttd,d.nm_dokter from pemeriksaan_operasi a left join dyn_user_dokter b on a.perawat_anastesi = b.id_dokter left join hmis_users c on c.userid = b.userid left join data_dokter d on a.perawat_anastesi = d.id_dokter
                        where c.userid = $anes")->row();
                        if(isset($query1->ttd)){
                        ?>

                            <img width="70px" src="<?= $query1->ttd ?>" alt=""><br>
                            <p>Perawat  Anestesi : <?= $query1->nm_dokter ?></p>
                        <?php
                            } else {?>
                                <br><br><br>
                                <p>Perawat  Anestesi :</p>
                            <?php } ?>

                        
                        <p>Tgl    : <?= isset( $value->tgl_sign_in)?date('d-m-Y',strtotime( $value->tgl_sign_in)):'' ?></p>
                        <span>Jam  : <?= isset( $value->tgl_sign_in)?date('h:i:s',strtotime( $value->tgl_sign_in)):'' ?></span>

                    </td>

                    <td></td>
                    <td>
                        <span style="font-weight:bold">Dengan perawat, dr Anestesi & Bedah </span><br>
                        <span>
                        Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri(nama & peran)
                        </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question2[0]->{'column1'})?  $value->question2[0]->{'column1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question2[0]->{'column1'})?  $value->question2[0]->{'column1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 
                        <br><br>

                        <span>Memastikan dan membaca ulang nama pasien, tindakan medis dan area yang akan diinsisi </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question2[0]->{'column2'})?  $value->question2[0]->{'column2'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question2[0]->{'column2'})?  $value->question2[0]->{'column2'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>

                        <span>Apakah profilaksis anti biotik sudah diberikan 1 jam sebelumnya</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question2[0]->{'column3'})?  $value->question2[0]->{'column3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question2[0]->{'column3'})?  $value->question2[0]->{'column3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>
                        <span style="font-weight:bold">Kejadian beresiko yang perlu diantisipasi untuk dr Bedah</span><br>
                        <span>Apakah tindakan beresiko atau tindakan tidak rutin yang akan dilakukan</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column1'})?  $value->question3[0]->{'column1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column1'})?  $value->question3[0]->{'column1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>
                        <span>Berapa lama tindakan  ini akan dikerjakan : <?= isset( $value->question3[0]->{'column2'})? $value->question3[0]->{'column2'}:'' ?></span><br><br>

                        <span>Apakah sudah diantisipasi perdarahan?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column3'})?  $value->question3[0]->{'column3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column3'})?  $value->question3[0]->{'column3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        
                        <br><br>
                        <span style="font-weight:bold">Untuk dr. Anestesi</span><br>
                        <span>Apakah ada hal khusus untuk pasien</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column4'})?  $value->question3[0]->{'column4'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset( $value->question3[0]->column8)? $value->question3[0]->column8:'' ?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column4'})?  $value->question3[0]->{'column4'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>
                        <span style="font-weight:bold">Untuk Tim Perawat</span><br>
                        <span>Apakah ada masalah dengan peralatan atau masalah alat yang dikhawatirkan ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column5'})?  $value->question3[0]->{'column5'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column5'})?  $value->question3[0]->{'column5'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Apakah hasil radiologi yang diperlukan sudah ada?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column6'})?  $value->question3[0]->{'column6'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column6'})?  $value->question3[0]->{'column6'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Apakah sudah dipastikan keseterilan alat?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column7'})?  $value->question3[0]->{'column7'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question3[0]->{'column7'})?  $value->question3[0]->{'column7'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br>

                        <p>Tanda Tangan & Nama</p>
                        
                        <?php
                        // var_dump($id_ok);die();
                       $query2 = $this->db->query("SELECT a.id_dok_anes,b.id_dokter,c.ttd,d.nm_dokter 
                       from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dok_anes = b.id_dokter 
                       left join hmis_users c on c.userid = b.userid left join data_dokter d on a.id_dok_anes = d.id_dokter
                       where a.idoperasi_header = $id_ok")->row();
                        // var_dump($query2);die();
                        if(isset($query2->ttd)){
                        ?>

                            <img width="70px" src="<?= $query2->ttd ?>" alt=""><br>
                            <span>Perawat  sirkuler  : <?= $query2->nm_dokter ?></span>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>Perawat  sirkuler  : </span>
                            <?php } ?>

                     


                            <p>Tgl    : <?= isset( $value->tgl_time_out)?date('d-m-Y',strtotime( $value->tgl_time_out)):'' ?></p>
                        <span>Jam  : <?= isset( $value->tgl_time_out)?date('h:i:s',strtotime( $value->tgl_time_out)):'' ?></span>

                    </td>
                    <td></td>
                    <td>
                        <span style="font-weight:bold">Dengan perawat, dr Anestesi & dr Bedah</span><br>
                        <span>Secara verbal  perawat memastikan : Nama tindakan</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column1'})?  $value->question4[0]->{'column1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset( $value->question4[0]->{'column6'})? $value->question4[0]->{'column6'}:''?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column1'})?  $value->question4[0]->{'column1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Kelengkapan alat, jumlah kasa dan jarum/alat lain</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column2'})?  $value->question4[0]->{'column2'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column2'})?  $value->question4[0]->{'column2'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Pelabelan spesimen (baca label spesimen dan nama pasien dengan keras)</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column3'})?  $value->question4[0]->{'column3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column3'})?  $value->question4[0]->{'column3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Apakah ada masalah dengan peralatan yang perlu disampaikan ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column4'})?  $value->question4[0]->{'column4'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset( $value->question4[0]->{'column7'})? $value->question4[0]->{'column7'}:''?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column4'})?  $value->question4[0]->{'column4'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span style="font-weight:bold">Dengan perawat, dr Anestesi & dr Bedah</span><br>
                        <span>Apakah ada catatan khusus untuk proses recovery  /  penanganan perawatan pasien </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column5'})?  $value->question4[0]->{'column5'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset( $value->question4[0]->{'column8'})? $value->question4[0]->{'column8'}:'' ?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset( $value->question4[0]->{'column5'})?  $value->question4[0]->{'column5'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <p>Tanda Tangan & Nama</p>
                        <?php
                      $query3 = $this->db->query("SELECT a.id_dokter,b.id_dokter,c.ttd,d.nm_dokter 
                      from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dokter = b.id_dokter 
                      left join hmis_users c on c.userid = b.userid left join data_dokter d on a.id_dokter = d.id_dokter
                      where a.idoperasi_header = $id_ok")->row();
                        if(isset($query3->ttd)){
                        ?>

                            <img width="70px" src="<?= $query3->ttd ?>" alt=""><br>
                            <span>dr. Bedah  : <?= $query3->nm_dokter ?></span>
                       <?php
                            } else {?>
                                <br><br><br>
                                <span>dr. Bedah  : </span>
                            <?php } ?>
                        



                        <?php
                         $query4 = $this->db->query("SELECT a.id_dok_anes,b.id_dokter,c.ttd,d.nm_dokter 
                         from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dok_anes = b.id_dokter 
                         left join hmis_users c on c.userid = b.userid 
                         left join data_dokter d on a.id_dok_anes = d.id_dokter
                         where a.idoperasi_header = $id_ok")->row();
                        if(isset($query4->ttd)){
                        ?>

                            <img width="70px" src="<?= $query4->ttd ?>" alt=""><br>
                            <span>dr. Anestesi :<?= $query4->nm_dokter ?> </span><br>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>dr. Anestesi : </span>
                            <?php } ?>
                       



                        <?php
                       $query5 = $this->db->query("SELECT a.perawat_sek,c.ttd,d.nm_dokter
                       from pemeriksaan_operasi a
                       left join hmis_users c on cast(c.userid as text) = a.perawat_sek  
                       left join dyn_user_dokter b on cast(b.userid as text) = a.perawat_sek 
                       left join data_dokter d on b.id_dokter = d.id_dokter where a.idoperasi_header = '$id_ok'")->row();
                        if(isset($query5->ttd)){
                        ?>

                            <img width="70px" src="<?= $query5->ttd ?>" alt=""><br>
                            <span>Perawat Sirkuler : <?= $query5->nm_dokter ?></span>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>Perawat Sirkuler : </span>
                            <?php } ?>
                        



                            <p>Tgl    : <?= isset( $value->tgl_sign_out)?date('d-m-Y',strtotime( $value->tgl_sign_out)):'' ?></p>
                        <span>Jam  : <?= isset( $value->tgl_sign_out)?date('h:i:s',strtotime( $value->tgl_sign_out)):'' ?></span>
                    </td>
    
                </tr>

                <tr>
                    <td colspan="5">CATATAN : Beri tanda  √  bila sudah dilaksanakan / ya</td>
                </tr>
            </table><br>
            <?php endforeach; ?>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
           
        </div>

    <?php }}else{ ?> 
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>CHECKLIST KESELAMATAN DI KAMAR OPERASI</h4></center>
            <table width="100%" id="data" border="1" cellpadding="3px">
                <tr>
                    <th width= "30%">Sebelum Induksi Anestesi <br>( Sign In )</th>
                    <th width= "5%">➩</th>
                    <th width= "30%">Sebelum Insisi(Time Out)</th>
                    <th width= "5%">➩</th>
                    <th width= "30%">Sebelum pasien meninggalkan Ruang Operasi  (Sign Out)</th>
                </tr>

                <tr>
                    <td>
                        <span style="font-weight:bold">Minimal ada perawat dan dr  Anestesi</span><br>
                        <span>
                        Apakah  identitas pasien sudah benar, rencana tindakan sudah jelas, dan ada persetujuan  tindakan medis  yang akan di lakukan (inform concern)?
                        </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 1'})? $data->question1[0]->{'Column 1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 1'})? $data->question1[0]->{'Column 1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 
                        <br><br>

                        <span>Apakah area yang akan dioperasi sudah diberi tanda ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 2'})? $data->question1[0]->{'Column 2'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 2'})? $data->question1[0]->{'Column 2'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>

                        <span>Apakah mesin anestesi dan obat –obatan sudah lengkap ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 3'})? $data->question1[0]->{'Column 3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 3'})? $data->question1[0]->{'Column 3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>

                        <span>Apakah pasien sudah memakai pulse oksimetri dan sudah berfungsi baik?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 4'})? $data->question1[0]->{'Column 4'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 4'})? $data->question1[0]->{'Column 4'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>

                        <span>Apakah pasien memiliki  riwayat alergi?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 5'})? $data->question1[0]->{'Column 5'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 5'})? $data->question1[0]->{'Column 5'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        
                        <br><br>

                        <span>Apakah pasien memiliki gangguan pernapasan</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 6'})? $data->question1[0]->{'Column 6'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 6'})? $data->question1[0]->{'Column 6'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>

                        <span>Resiko perdarahan > 500 ml (7ml/kg bagi pasien anak)  bagi pasien ligasi</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question1[0]->{'Column 7'})? $data->question1[0]->{'Column 7'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak"<?php echo isset($data->question1[0]->{'Column 7'})? $data->question1[0]->{'Column 7'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br>

                        <p>Tanda Tangan & Nama</p>

                        <?php
                                                        //  var_dump($id_ok);die();
                                                           $query = $this->db->query("SELECT a.id_dok_anes,b.id_dokter,c.ttd,d.nm_dokter from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dok_anes = b.id_dokter left join hmis_users c on c.userid = b.userid left join data_dokter d on a.id_dok_anes = d.id_dokter
                                                           where a.idoperasi_header = '$id_ok'")->row();
                                                        //    var_dump($query->ttd);die();
                                                           if(isset($query->ttd)){
                                                           ?>
                                   
                                                               <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                                               <span>Dokter Anestesi: <?= $query->nm_dokter ?></span><br>
                                                           <?php
                                                               } else {?>
                                                                   <br><br><br>
                                                                   <span>Dokter Anestesi: </span><br>
                                                               <?php } ?>
                                                          
                                   
                                   
                                   
                                   
                                                           <?php
                                                       
                                                        //    $aness= isset($anes)?$anes:null;
                                                        // var_dump($anes);die();
                                                           $query1 = $this->db->query("SELECT a.perawat_anastesi,b.id_dokter,c.ttd,d.nm_dokter from pemeriksaan_operasi a left join dyn_user_dokter b on a.perawat_anastesi = b.id_dokter left join hmis_users c on c.userid = b.userid left join data_dokter d on a.perawat_anastesi = d.id_dokter
                                                           where cast(c.userid as text) = '$anes'")->row();
 
                                                           if(isset($query1->ttd)){
                                                           ?>
                                   
                                                               <img width="70px" src="<?= $query1->ttd ?>" alt=""><br>
                                                               <p>Perawat  Anestesi : <?= $query1->nm_dokter ?></p>
                                                           <?php
                                                               } else {?>
                                                                   <br><br><br>
                                                                   <p>Perawat  Anestesi :</p>
                                                               <?php } ?>

                        
                        <p>Tgl    : <?= isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'' ?></p>
                        <span>Jam  : <?= isset($data->tgl)?date('h:i:s',strtotime($data->tgl)):'' ?></span>

                    </td>

                    <td></td>
                    <td>
                        <span style="font-weight:bold">Dengan perawat, dr Anestesi & Bedah </span><br>
                        <span>
                        Memastikan bahwa semua anggota tim medis sudah memperkenalkan diri(nama & peran)
                        </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->{'column1'})? $data->question2[0]->{'column1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->{'column1'})? $data->question2[0]->{'column1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 
                        <br><br>

                        <span>Memastikan dan membaca ulang nama pasien, tindakan medis dan area yang akan diinsisi </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->{'column2'})? $data->question2[0]->{'column2'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->{'column2'})? $data->question2[0]->{'column2'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>

                        <span>Apakah profilaksis anti biotik sudah diberikan 1 jam sebelumnya</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->{'column3'})? $data->question2[0]->{'column3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question2[0]->{'column3'})? $data->question2[0]->{'column3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span> 

                        <br><br>
                        <span style="font-weight:bold">Kejadian beresiko yang perlu diantisipasi untuk dr Bedah</span><br>
                        <span>Apakah tindakan beresiko atau tindakan tidak rutin yang akan dilakukan</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column1'})? $data->question3[0]->{'column1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column1'})? $data->question3[0]->{'column1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>
                        <span>Berapa lama tindakan  ini akan dikerjakan : <?= isset($data->question3[0]->{'column2'})?$data->question3[0]->{'column2'}:'' ?></span><br><br>

                        <span>Apakah sudah diantisipasi perdarahan?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column3'})? $data->question3[0]->{'column3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column3'})? $data->question3[0]->{'column3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        
                        <br><br>
                        <span style="font-weight:bold">Untuk dr. Anestesi</span><br>
                        <span>Apakah ada hal khusus untuk pasien</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column4'})? $data->question3[0]->{'column4'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset($data->question3[0]->column8)?$data->question3[0]->column8:'' ?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column4'})? $data->question3[0]->{'column4'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span>

                        <br><br>
                        <span style="font-weight:bold">Untuk Tim Perawat</span><br>
                        <span>Apakah ada masalah dengan peralatan atau masalah alat yang dikhawatirkan ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column5'})? $data->question3[0]->{'column5'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column5'})? $data->question3[0]->{'column5'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Apakah hasil radiologi yang diperlukan sudah ada?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column6'})? $data->question3[0]->{'column6'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column6'})? $data->question3[0]->{'column6'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Apakah sudah dipastikan keseterilan alat?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column7'})? $data->question3[0]->{'column7'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3[0]->{'column7'})? $data->question3[0]->{'column7'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br>

                        <p>Tanda Tangan & Nama</p>
                        
                        <?php
                       $query2 = $this->db->query("SELECT a.perawat_sek,c.ttd,d.nm_dokter
                       from pemeriksaan_operasi a
                       left join hmis_users c on cast(c.userid as text) = a.perawat_sek  left join dyn_user_dokter b on cast(b.userid as text) = a.perawat_sek left join data_dokter d on b.id_dokter = d.id_dokter where a.idoperasi_header = '$id_ok'")->row();
                        // var_dump($query2);die();
                        if(isset($query2->ttd)){
                        ?>

                            <img width="70px" src="<?= $query2->ttd ?>" alt=""><br>
                            <span>Perawat  sirkuler  : <?= $query2->nm_dokter ?></span>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>Perawat  sirkuler  : </span>
                            <?php } ?>

                     


                        <p>Tgl    : <?= isset($data->question5)?date('d m Y', strtotime($data->question5)):'' ?></p>
                        <span>Jam  : <?= isset($data->question5)?date('h:i:s', strtotime($data->question5)):'' ?></span>

                    </td>
                    <td></td>
                    <td>
                        <span style="font-weight:bold">Dengan perawat, dr Anestesi & dr Bedah</span><br>
                        <span>Secara verbal  perawat memastikan : Nama tindakan</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column1'})? $data->question4[0]->{'column1'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset($data->question4[0]->{'column6'})?$data->question4[0]->{'column6'}:''?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column1'})? $data->question4[0]->{'column1'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Kelengkapan alat, jumlah kasa dan jarum/alat lain</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column2'})? $data->question4[0]->{'column2'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column2'})? $data->question4[0]->{'column2'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Pelabelan spesimen (baca label spesimen dan nama pasien dengan keras)</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column3'})? $data->question4[0]->{'column3'} == "ya" ? "checked":'':'' ?>>
                        <span>ya</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column3'})? $data->question4[0]->{'column3'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span>Apakah ada masalah dengan peralatan yang perlu disampaikan ?</span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column4'})? $data->question4[0]->{'column4'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset($data->question4[0]->{'column7'})?$data->question4[0]->{'column7'}:''?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column4'})? $data->question4[0]->{'column4'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <span style="font-weight:bold">Dengan perawat, dr Anestesi & dr Bedah</span><br>
                        <span>Apakah ada catatan khusus untuk proses recovery  /  penanganan perawatan pasien </span><br><br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column5'})? $data->question4[0]->{'column5'} == "ya" ? "checked":'':'' ?>>
                        <span>ya, <?= isset($data->question4[0]->{'column8'})?$data->question4[0]->{'column8'}:'' ?></span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question4[0]->{'column5'})? $data->question4[0]->{'column5'} == "tidak" ? "checked":'':'' ?>>
                        <span>tdk </span><br><br>

                        <p>Tanda Tangan & Nama</p>
                        <?php
                      $query3 = $this->db->query("SELECT a.id_dokter,b.id_dokter,c.ttd,d.nm_dokter from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dokter = b.id_dokter left join hmis_users c on c.userid = b.userid left join data_dokter d on a.id_dokter = d.id_dokter
                      where a.idoperasi_header = $id_ok")->row();
                        if(isset($query3->ttd)){
                        ?>

                            <img width="70px" src="<?= $query3->ttd ?>" alt=""><br>
                            <span>dr. Bedah  : <?= $query3->nm_dokter ?></span>
                       <?php
                            } else {?>
                                <br><br><br>
                                <span>dr. Bedah  : </span>
                            <?php } ?>
                        



                        <?php
                         $query4 = $this->db->query("SELECT a.id_dok_anes,b.id_dokter,c.ttd,d.nm_dokter from pemeriksaan_operasi a left join dyn_user_dokter b on a.id_dok_anes = b.id_dokter left join hmis_users c on c.userid = b.userid left join data_dokter d on a.id_dok_anes = d.id_dokter
                         where a.idoperasi_header = $id_ok")->row();
                         
                        if(isset($query4->ttd)){
                        ?>

                            <img width="70px" src="<?= $query4->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                        <span>dr. Anestesi : <?= isset( $value->question11)? Explode('-', $value->question11)[0]:'.....................' ?></span>



                        <?php
                       $query5 = $this->db->query("SELECT a.perawat_sek,c.ttd,d.nm_dokter
                       from pemeriksaan_operasi a
                       left join hmis_users c on cast(c.userid as text) = a.perawat_sek  left join dyn_user_dokter b on cast(b.userid as text) = a.perawat_sek left join data_dokter d on b.id_dokter = d.id_dokter where a.idoperasi_header = '$id_ok'")->row();
                        if(isset($query5->ttd)){
                        ?>

                            <img width="70px" src="<?= $query5->ttd ?>" alt=""><br>
                            <span>Perawat Sirkuler : <?= $query5->nm_dokter ?></span>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>Perawat Sirkuler : </span>
                            <?php } ?>



                        <p>Tgl    : <?= isset($data->question6)? date('d m Y', strtotime($data->question6)):'' ?></p>
                        <span>Jam  : <?= isset($data->question6)? date('h:i:s', strtotime($data->question6)):'' ?></span>
                    </td>
    
                </tr>

                <tr>
                    <td colspan="5">CATATAN : Beri tanda  √  bila sudah dilaksanakan / ya</td>
                </tr>
            </table><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
           
        </div>
    <?php } ?>
    </body>
    </html>

   