<?php
$data = (isset($checklist_keselamatan_operasi->formjson)?json_decode($checklist_keselamatan_operasi->formjson):'');
// var_dump($data->question1);
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

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

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
                        $id = explode('-',isset($data->question7)?$data->question7:null)[1]??null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                        <span>Dokter Anestesi: <?= isset($data->question7)? Explode('-',$data->question7)[0]:'.....................' ?></span><br>




                        <?php
                        $id1 = explode('-',isset($data->question8)?$data->question8:null)[1]??null;
                        //  var_dump($id);                                     
                        $query1 = $id1?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id1")->row():null;
                        if(isset($query1->ttd)){
                        ?>

                            <img width="70px" src="<?= $query1->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>

                        <p>Perawat  Anestesi : <?= isset($data->question8)? Explode('-',$data->question8)[0]:'.....................' ?></p>

                        
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
                        $id2 = explode('-',isset($data->question9)?$data->question9:null)[1]??null;
                        //  var_dump($id);                                     
                        $query2 = $id2?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id2")->row():null;
                        if(isset($query2->ttd)){
                        ?>

                            <img width="70px" src="<?= $query2->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                        <span>Perawat  sirkuler  : <?= isset($data->question9)? Explode('-',$data->question9)[0]:'.....................' ?></span>

                     


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
                        $id3 = explode('-',isset($data->question10)?$data->question10:null)[1]??null;
                        //  var_dump($id);                                     
                        $query3 = $id3?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id3")->row():null;
                        if(isset($query3->ttd)){
                        ?>

                            <img width="70px" src="<?= $query3->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                        <span>dr. Bedah  : <?= isset($data->question10)? Explode('-',$data->question10)[0]:'.....................' ?></span>



                        <?php
                        $id4 = explode('-',isset($data->question11)?$data->question11:null)[1]??null;
                        //  var_dump($id);                                     
                        $query4 = $id4?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id4")->row():null;
                        if(isset($query4->ttd)){
                        ?>

                            <img width="70px" src="<?= $query4->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                        <span>dr. Anestesi : <?= isset($data->question11)? Explode('-',$data->question11)[0]:'.....................' ?></span>



                        <?php
                        $id5 = explode('-',isset($data->question11)?$data->question11:null)[1]??null;
                        //  var_dump($id);                                     
                        $query5 = $id5?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id5")->row():null;
                        if(isset($query5->ttd)){
                        ?>

                            <img width="70px" src="<?= $query5->ttd ?>" alt=""><br>
                        <?php
                            } else {?>
                                <br><br><br>
                            <?php } ?>
                        <span>dr. Anestesi : <?= isset($data->question12)? Explode('-',$data->question12)[0]:'.....................' ?></span>



                        <p>Tgl    : <?= isset($data->question6)? date('d m Y', strtotime($data->question6)):'' ?></p>
                        <span>Jam  : <?= isset($data->question6)? date('h:i:s', strtotime($data->question6)):'' ?></span>
                    </td>
    
                </tr>

                <tr>
                    <td colspan="5">CATATAN : Beri tanda  √  bila sudah dilaksanakan / ya</td>
                </tr>
            </table><br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:470px">
                Rev.08.02.2021. RM-018c / RI
                </div>
           </div>
           
        </div>

       
    </body>
    </html>

   