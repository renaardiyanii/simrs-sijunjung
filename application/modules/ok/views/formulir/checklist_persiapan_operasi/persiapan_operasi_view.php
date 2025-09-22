<?php
$data = (isset($persiapan_operasi->formjson)?json_decode($persiapan_operasi->formjson):'');
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
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 12px;
            
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

            <center><h4>CHECKLIST PERSIAPAN OPERASI</h4></center>
           
            <div style="font-size:12px">

                <table width="100%" id="data" border=1>
                    <tr>
                        <td width="50%">
                            <table width="100%">
                                <tr>
                                    <td width="35%">Ruangan</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 1'})?$data->question10->{'Row 1'}->{'Column 1'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Diagnosis</td>
                                    <td>:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 2'})?$data->question10->{'Row 1'}->{'Column 2'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Dokter Bedah</td>
                                    <td>:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 3'})?$data->question10->{'Row 1'}->{'Column 3'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Dokter Anestesi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 4'})?$data->question10->{'Row 1'}->{'Column 4'}:'' ?></td>
                                </tr>
                            </table>
                        </td>

                        <td width="50%">
                            <table width="100%">
                                <tr>
                                    <td width="35%">Jenis Operasi</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 5'})?$data->question10->{'Row 1'}->{'Column 5'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Jenis Pembiusan</td>
                                    <td>:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 6'})?$data->question10->{'Row 1'}->{'Column 6'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Dokter Anestesi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 7'})?$data->question10->{'Row 1'}->{'Column 7'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Sifat Operasi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question10->{'Row 1'}->{'Column 8'})?$data->question10->{'Row 1'}->{'Column 8'}:'' ?></td>
                                </tr>
                            </table>
                        </td>
                       
                    </tr>
                   
                </table><br>

              <table width="100%" id="data" border="1" cellpadding="2px">
                <tr>
                    <th width="10%">No</th>
                    <th>Persiapan</th>
                    <th width="10%">Ya</th>
                    <th width="10%">tdk</th>
                </tr>

                <tr>
                    <td style="text-align:center" rowspan="5">1.</td>
                    <td>Persiapan administrasi :</td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                </tr>
                <tr>
                    
                    <td>a.	Surat Izin Operasi</td>
                    <td style="text-align:center"><?php echo isset($data->question1->item1->{'column1'})? $data->question1->item1->{'column1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question1->item1->{'column1'})? $data->question1->item1->{'column1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>b.	Administrasi Keuangan</td>
                    <td style="text-align:center"><?php echo isset($data->question1->item2->{'column1'})? $data->question1->item2->{'column1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question1->item2->{'column1'})? $data->question1->item2->{'column1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>c.	SJPK / Askes</td>
                    <td style="text-align:center"><?php echo isset($data->question1->item3->{'column1'})? $data->question1->item3->{'column1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question1->item3->{'column1'})? $data->question1->item3->{'column1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>d.	Status Pasien</td>
                    <td style="text-align:center"><?php echo isset($data->question1->item4->{'column1'})? $data->question1->item4->{'column1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question1->item4->{'column1'})? $data->question1->item4->{'column1'} == "0" ? "✓":'':'' ?></td>
                </tr>


                <tr>
                    <td style="text-align:center" rowspan="6">2.</td>
                    <td>a.	Pemeriksaan Diagnostik :</td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                </tr>
                <tr>
                    
                    <td>b.	Rontgent</td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 1'}->{'Column 1'})? $data->question7->{'Row 1'}->{'Column 1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 1'}->{'Column 1'})? $data->question7->{'Row 1'}->{'Column 1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>c.	EKG</td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 2'}->{'Column 1'})? $data->question7->{'Row 2'}->{'Column 1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 2'}->{'Column 1'})? $data->question7->{'Row 2'}->{'Column 1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>d.	Laboratorium</td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 3'}->{'Column 1'})? $data->question7->{'Row 3'}->{'Column 1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 3'}->{'Column 1'})? $data->question7->{'Row 3'}->{'Column 1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>e.	Echo</td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 4'}->{'Column 1'})? $data->question7->{'Row 4'}->{'Column 1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 4'}->{'Column 1'})? $data->question7->{'Row 4'}->{'Column 1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>f.	Lain – lain :  <?= isset($data->question8)?$data->question8:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 5'}->{'Column 1'})? $data->question7->{'Row 5'}->{'Column 1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question7->{'Row 5'}->{'Column 1'})? $data->question7->{'Row 5'}->{'Column 1'} == "0" ? "✓":'':'' ?></td>
                </tr>


                <tr>
                    <td style="text-align:center" rowspan="10">3.</td>
                    <td>a.	TTV</td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 1'})? $data->question2->{'Row 1'}->{'Column 1'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 1'})? $data->question2->{'Row 1'}->{'Column 1'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>b.	Makan terakhir : jam : <?= isset($data->question2->{'Row 1'}->{'Column 3'})?$data->question2->{'Row 1'}->{'Column 3'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 2'})? $data->question2->{'Row 1'}->{'Column 2'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 2'})? $data->question2->{'Row 1'}->{'Column 2'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>c.	Pre medikasi : jam : <?= isset($data->question2->{'Row 1'}->{'Column 5'})?$data->question2->{'Row 1'}->{'Column 5'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 4'})? $data->question2->{'Row 1'}->{'Column 4'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 4'})? $data->question2->{'Row 1'}->{'Column 4'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>d.	Levement : jam : <?= isset($data->question2->{'Row 1'}->{'Column 7'})?$data->question2->{'Row 1'}->{'Column 7'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 6'})? $data->question2->{'Row 1'}->{'Column 6'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 6'})? $data->question2->{'Row 1'}->{'Column 6'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>e.	Persiapan kulit / cukur <?= isset($data->question2->{'Row 1'}->{'Column 9'})?$data->question2->{'Row 1'}->{'Column 9'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 8'})? $data->question2->{'Row 1'}->{'Column 8'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 8'})? $data->question2->{'Row 1'}->{'Column 8'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>f.	Vagina toilet <?= isset($data->question2->{'Row 1'}->{'Column 16'})?$data->question2->{'Row 1'}->{'Column 16'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 10'})? $data->question2->{'Row 1'}->{'Column 10'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 10'})? $data->question2->{'Row 1'}->{'Column 10'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>g.	Pengosongan kandung kemih : jam : <?= isset($data->question2->{'Row 1'}->{'Column 12'})?$data->question2->{'Row 1'}->{'Column 12'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 11'})? $data->question2->{'Row 1'}->{'Column 11'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 11'})? $data->question2->{'Row 1'}->{'Column 11'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>h.	Perhiasan</td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 13'})? $data->question2->{'Row 1'}->{'Column 13'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 13'})? $data->question2->{'Row 1'}->{'Column 13'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>i.	Gigi palsu </td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 14'})? $data->question2->{'Row 1'}->{'Column 14'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 14'})? $data->question2->{'Row 1'}->{'Column 14'} == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>j.	Pewarna kuku</td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 15'})? $data->question2->{'Row 1'}->{'Column 15'} == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->{'Column 15'})? $data->question2->{'Row 1'}->{'Column 15'} == "0" ? "✓":'':'' ?></td>
                </tr>


                <tr>
                    <td style="text-align:center" rowspan="4">4.</td>
                    <td>Persiapan Tambahan :</td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                </tr>
                <tr>
                    
                    <td>a.	Darah	: <?= isset($data->question3->darah->column2)?$data->question3->darah->column2:'' ?> cc</td>
                    <td style="text-align:center"><?php echo isset($data->question3->darah->column1)? $data->question3->darah->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question3->darah->column1)? $data->question3->darah->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>b.	Infus	    : <?= isset($data->question3->infus->column2)?$data->question3->infus->column2:'' ?> cc </td>
                    <td style="text-align:center"><?php echo isset($data->question3->infus->column1)? $data->question3->infus->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question3->infus->column1)? $data->question3->infus->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>c.	Jenis	: <?= isset($data->question3->jenis->column2)?$data->question3->jenis->column2:'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question3->jenis->column1)? $data->question3->jenis->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question3->jenis->column1)? $data->question3->jenis->column1 == "0" ? "✓":'':'' ?></td>
                </tr>



                <tr>
                    <td style="text-align:center" rowspan="8">5.</td>
                    <td>Riwayat penyakit masa lalu dan therapi :</td>
                    <td style="text-align:center"></td>
                    <td style="text-align:center"></td>
                </tr>
                <tr>
                    
                    <td>a. Diabetes mellitus ( Gula Darah terakhir )</td>
                    <td style="text-align:center"><?php echo isset($data->question4->diabetes->column1)? $data->question4->diabetes->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->diabetes->column1)? $data->question4->diabetes->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>b. Hipertensi</td>
                    <td style="text-align:center"><?php echo isset($data->question4->hipertensi->column1)? $data->question4->hipertensi->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->hipertensi->column1)? $data->question4->hipertensi->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>c.	Asma</td>
                    <td style="text-align:center"><?php echo isset($data->question4->asma->column1)? $data->question4->asma->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->asma->column1)? $data->question4->asma->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>d.	Jantung</td>
                    <td style="text-align:center"><?php echo isset($data->question4->jantung->column1)? $data->question4->jantung->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->jantung->column1)? $data->question4->jantung->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>e.	Ginjal</td>
                    <td style="text-align:center"><?php echo isset($data->question4->ginjal->column1)? $data->question4->ginjal->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->ginjal->column1)? $data->question4->ginjal->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>f.	Alergi obat / makanan : <?= isset($data->lergi)?$data->lergi:''?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->alergi->column1)? $data->question4->alergi->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->alergi->column1)? $data->question4->alergi->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
                <tr>
                    
                    <td>g. Lain lain : <?= isset($data->question9)?$data->question9:''?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->lainya->column1)? $data->question4->lainya->column1 == "1" ? "✓":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question4->lainya->column1)? $data->question4->lainya->column1 == "0" ? "✓":'':'' ?></td>
                </tr>
               
              </table>

              <div style="display: inline; position: relative;">
                    <div style="float: left;margin-top: 15px;">
                        <p>Perawat Ruangan</p>
                        <?php
                        $id =isset($persiapan_operasi->id_pemeriksa)?$persiapan_operasi->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <span>(<?= (isset($query->name)?$query->name:'')?>)</span><br>  
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>()</span><br>
                        <?php } ?>

                      
                        
                             
                    </div>
                    <div style="float: right;">
                        <span>Bukittinggi, <?= isset($persiapan_operasi->tgl_input)? date('d-m-Y',strtotime($persiapan_operasi->tgl_input)):'' ?></span>
                        <p>Perawat  Anestesi</p>

                        <?php
                        $id1 =isset($persiapan_operasi->id_pemeriksa_2)?$persiapan_operasi->id_pemeriksa_2:null;
                        //   var_dump($id);die();                                     
                        $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                        if(isset($query1->ttd)){
                        ?>

                            <img width="70px" src="<?= $query1->ttd ?>" alt=""><br>
                            <span>(<?= (isset($query1->name)?$query1->name:'')?>)</span><br>  
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>()</span><br>
                        <?php } ?>

                        
                             
                    </div>  
             </div><br><br><br><br><br><br><br><br><br><br><br><br>

             <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:470px">
                Rev.08.02.2021. RM-019a / RI
                </div>
            </div>


        </div>

       

    </body>
    </html>

   