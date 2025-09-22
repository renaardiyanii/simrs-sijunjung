<?php
$data = (isset($lap_operasi->formjson)?json_decode($lap_operasi->formjson):'');
$result = array_chunk($lap_operasi, 1);
// echo '<pre>';
// var_dump($result);die();
// echo '</pre>';
 ?> 
<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            /* position: relative; */
            text-align: center;
        }
       
        .table-font-size{
            font-size:9px;
            }
        .table-font-size1{
            font-size:11px;
            }
        .table-font-size2{
            font-size:9px;
            margin : 5px 1px 1px 1px;
            padding : 5px 1px 1px 1px;
            }
						
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4">
    <?php 
    if($result){
        for($i = 0;$i<count($result);$i++){
        // var_dump($result[$i]);die();
            
            ?>
        <?php 
            // $val = $result[$i]->formjson?json_decode($result[$i]->formjson):null;
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
                //  var_dump($value);die();
            ?>
    <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <h4 align="center"><b><u>LAPORAN OPERASI</u></b></h4>

                    <table>												
						<tr>
							<td><p><b>Nama Ahli Bedah</p></b></td>
							<td><p> : </p></td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 1'})?$value->question1->{'Row 1'}->{'Column 1'}:'' ?></p></td>
						</tr>
						<tr>
							<td><b>Nama Asisten</b></td>
							<td> : </td>
							<td><?= isset($value->question1->{'Row 1'}->{'Column 2'})?$value->question1->{'Row 1'}->{'Column 2'}:''?></td>
						</tr>
                        <tr>
							<td><p><b>Nama Instrumen</p></b></td>
							<td><p> : </p></td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 3'})?$value->question1->{'Row 1'}->{'Column 3'}:''?></p></td>
						</tr>
                        <tr>
							<td><b>Nama Ahli Anestesi</b></td>
							<td> : </td>
							<td><?= isset($value->question1->{'Row 1'}->{'Column 4'})?$value->question1->{'Row 1'}->{'Column 4'}:'' ?></td>
						</tr>
                        <tr>
							<td><p><b>Nama Perawat Anestesi</p></b></td>
							<td><p> : </p></td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 5'})?$value->question1->{'Row 1'}->{'Column 5'}:'' ?></p></td>
						</tr>
						
						<tr>
							<td><b>Jenis Anestesi</b></td>
							<td> : </td>
							<td>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 6'})? $value->question1->{'Row 1'}->{'Column 6'} == "UMUM" ? "checked":'':'' ?>>
                            <span>UMUM</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 6'})? $value->question1->{'Row 1'}->{'Column 6'} == "SPINAL" ? "checked":'':'' ?>>
                            <span>SPINAL</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 6'})? $value->question1->{'Row 1'}->{'Column 6'} == "EPIDURAL" ? "checked":'':'' ?>>
                            <span>EPIDURAL</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 6'})? $value->question1->{'Row 1'}->{'Column 6'} == "LOKAL" ? "checked":'':'' ?>>
                            <span>LOKAL</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 6'})? $value->question1->{'Row 1'}->{'Column 6'} == "other" ? "checked":'':'' ?>>
                            <span>LAIN - LAIN</span>
                            </td>
						</tr>

                        <tr>
							<td><p><b>Jenis Operasi</b></p></td>
							<td><p> :</p> </td>
							<td><p>
                          
                            <span><?= isset($value->question1->{'Row 1'}->{'Column 7'})?$value->question1->{'Row 1'}->{'Column 7'}:'' ?></span>
                           
                            </p></td>
						</tr>

                        <tr>
							<td><b>Diagnosa Pra Bedah</b></td>
							<td> : </td>
							<td><?= isset($value->question1->{'Row 1'}->{'Column 8'})?$value->question1->{'Row 1'}->{'Column 8'}:'' ?></td>
						</tr>

                        <tr>
							<td><p><b>Diagnosa Pasca Bedah</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 9'})?$value->question1->{'Row 1'}->{'Column 9'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Komplikasi yang ditemukan</b></td>
							<td> : </td>
							<td><?= isset($value->question1->{'Row 1'}->{'Column 10'})?$value->question1->{'Row 1'}->{'Column 10'}:'' ?></td>
						</tr>

                        <tr>
							<td><p><b>Nama Operasi / Tindakan</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 11'})?$value->question1->{'Row 1'}->{'Column 11'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>ICD 9</b></td>
							<td> : </td>
							<td><?= isset($value->question1->{'Row 1'}->{'Column 22'})?$value->question1->{'Row 1'}->{'Column 22'}:'' ?></td>
						</tr>

                        <tr>
							<td><b>Implant yang dipasang</b></td>
							<td> : </td>
							<td>
                                <?= isset($value->question1->{'Row 1'}->{'Column 12'})?$value->question1->{'Row 1'}->{'Column 12'}:'' ?>
                                <span style="margin-left:30px">No Seri :  <?= isset($value->question1->{'Row 1'}->{'Column 13'})?$value->question1->{'Row 1'}->{'Column 13'}:'' ?></span>
                            </td>
						</tr>

						

                        <tr>
							<td><p><b>Jumlah Perdarahan</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 14'})?$value->question1->{'Row 1'}->{'Column 14'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Jumlah Tranfuse</b></td>
							<td> : </td>
							<td><?= isset($value->question1->{'Row 1'}->{'Column 15'})?$value->question1->{'Row 1'}->{'Column 15'}:'' ?></td>
						</tr>

                        <tr>
							<td><p><b>Jaringan yang di eks/inc</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($value->question1->{'Row 1'}->{'Column 16'})?$value->question1->{'Row 1'}->{'Column 16'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Di Pa kan </b></td>
							<td> : </td>
							<td>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 17'})? $value->question1->{'Row 1'}->{'Column 17'} == "item1" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($value->question1->{'Row 1'}->{'Column 17'})? $value->question1->{'Row 1'}->{'Column 17'} == "item2" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                            </td>
						</tr>

					</table><br>
                    <table border="1" style="padding:2px">		
						<thead>										
						<tr>
							<td width="20%"><b>Tgl Operasi</b></td>							
							<td width="20%"><b>Jam Operasi Dimulai</b></td>
							<td width="20%"><b>Jam Operasi Selesai</b></td>
							<td width="30%"><b>Lama Operasi Berlangsung</b></td>							
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width="20%" align="center"><?= isset($value->question1->{'Row 1'}->{'Column 18'})?date('d-m-Y',strtotime($value->question1->{'Row 1'}->{'Column 18'})):'' ?></td>		
							<td width="20%" align="center"><?= isset($value->question1->{'Row 1'}->{'Column 19'})?$value->question1->{'Row 1'}->{'Column 19'}:'' ?></td>
							<td width="20%" align="center"><?= isset($value->question1->{'Row 1'}->{'Column 20'})?$value->question1->{'Row 1'}->{'Column 20'}:'' ?></td>
							<td width="30%" align="center"><?= isset($value->question1->{'Row 1'}->{'Column 21'})?$value->question1->{'Row 1'}->{'Column 21'}:'' ?>Jam</td>							
						</tr>
						</tbody>
					</table>
                    <p style="font-size:12px"><b>LAPORAN OPERASI</b></p>
			        <p style="font-size:10px;min-height:280px"><?= isset($value->question2)?$value->question2:'' ?></p>
                    
                    <div style="display: inline; position: relative;font-size: 12px;">
                        <div style="float: left;text-align: center;">
                            <p>Hal 1 dari 2</p>    
                        </div>
                        <div style="float: right;text-align: center;">
                            <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                        </div>     
                    </div> 
    </div>

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>
        </header>

        <p style="font-size:12px"><b>INTRUKSI PASCA BEDAH</b></p>
        <p style="font-size:12px;min-height:30%"><?= isset($value->question3)?$value->question3:'' ?></p>

        <p style="font-size:12px"><b>Obat Obatan yang Diberikan</b></p>
        <p style="font-size:12px;min-height:20%"><?= isset($value->question4)?$value->question4:'' ?></p>

                <br>
                <br><br>
                <br>
                <table style="width:100%;">
                    <tr>
                        <td width="65%" ></td>
                        <td>
                            <p>Operator </p>
                                <?php
                                $idPemeriksa =isset($val->id_pemeriksa)?$val->id_pemeriksa:null;
                                //   var_dump($id);die();                                     
                                $query1 = $idPemeriksa?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $idPemeriksa")->row():null;
                                if(isset($query1->ttd)){
                                ?>

                                    <img width="70px" src="<?= $query1->ttd ?>" alt=""><br>
                                    <span>(<?= (isset($query1->name)?$query1->name:'')?>)</span><br>  
                                <?php
                                    } else {?>
                                        <br><br><br>
                                        <span>()</span><br>
                                <?php } ?>
                        </td>
                    </tr>	
                </table>
            <br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
    </div>
    <?php endforeach; ?>
    <?php }}else{ ?>  

        
    <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <h4 align="center"><b><u>LAPORAN OPERASI</u></b></h4>

                    <table>												
						<tr>
							<td><p><b>Nama Ahli Bedah</p></b></td>
							<td><p> : </p></td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 1'})?$data->question1->{'Row 1'}->{'Column 1'}:'' ?></p></td>
						</tr>
						<tr>
							<td><b>Nama Asisten</b></td>
							<td> : </td>
							<td><?= isset($data->question1->{'Row 1'}->{'Column 2'})?$data->question1->{'Row 1'}->{'Column 2'}:''?></td>
						</tr>
                        <tr>
							<td><p><b>Nama Instrumen</p></b></td>
							<td><p> : </p></td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 3'})?$data->question1->{'Row 1'}->{'Column 3'}:''?></p></td>
						</tr>
                        <tr>
							<td><b>Nama Ahli Anestesi</b></td>
							<td> : </td>
							<td><?= isset($data->question1->{'Row 1'}->{'Column 4'})?$data->question1->{'Row 1'}->{'Column 4'}:'' ?></td>
						</tr>
                        <tr>
							<td><p><b>Nama Perawat Anestesi</p></b></td>
							<td><p> : </p></td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 5'})?$data->question1->{'Row 1'}->{'Column 5'}:'' ?></p></td>
						</tr>
						
						<tr>
							<td><b>Jenis Anestesi</b></td>
							<td> : </td>
							<td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 6'})? $data->question1->{'Row 1'}->{'Column 6'} == "UMUM" ? "checked":'':'' ?>>
                            <span>UMUM</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 6'})? $data->question1->{'Row 1'}->{'Column 6'} == "SPINAL" ? "checked":'':'' ?>>
                            <span>SPINAL</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 6'})? $data->question1->{'Row 1'}->{'Column 6'} == "EPIDURAL" ? "checked":'':'' ?>>
                            <span>EPIDURAL</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 6'})? $data->question1->{'Row 1'}->{'Column 6'} == "LOKAL" ? "checked":'':'' ?>>
                            <span>LOKAL</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 6'})? $data->question1->{'Row 1'}->{'Column 6'} == "other" ? "checked":'':'' ?>>
                            <span>LAIN - LAIN</span>
                            </td>
						</tr>

                        <tr>
							<td><p><b>Jenis Operasi</b></p></td>
							<td><p> :</p> </td>
							<td><p>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 7'})? $data->question1->{'Row 1'}->{'Column 7'} == "item1" ? "checked":'':'' ?>>
                            <span>Mayor</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 7'})? $data->question1->{'Row 1'}->{'Column 7'} == "item2" ? "checked":'':'' ?>>
                            <span>Medium</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 7'})? $data->question1->{'Row 1'}->{'Column 7'} == "item3" ? "checked":'':'' ?>>
                            <span>Minor</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 7'})? $data->question1->{'Row 1'}->{'Column 7'} == "item4" ? "checked":'':'' ?>>
                            <span>Emergency</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 7'})? $data->question1->{'Row 1'}->{'Column 7'} == "item5" ? "checked":'':'' ?>>
                            <span>Elektive</span>
                            </p></td>
						</tr>

                        <tr>
							<td><b>Diagnosa Pra Bedah</b></td>
							<td> : </td>
							<td><?= isset($data->question1->{'Row 1'}->{'Column 8'})?$data->question1->{'Row 1'}->{'Column 8'}:'' ?></td>
						</tr>

                        <tr>
							<td><p><b>Diagnosa Pasca Bedah</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 9'})?$data->question1->{'Row 1'}->{'Column 9'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Komplikasi yang ditemukan</b></td>
							<td> : </td>
							<td><?= isset($data->question1->{'Row 1'}->{'Column 10'})?$data->question1->{'Row 1'}->{'Column 10'}:'' ?></td>
						</tr>

                        <tr>
							<td><p><b>Nama Operasi / Tindakan</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 11'})?$data->question1->{'Row 1'}->{'Column 11'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Implant yang dipasang</b></td>
							<td> : </td>
							<td>
                                <?= isset($data->question1->{'Row 1'}->{'Column 12'})?$data->question1->{'Row 1'}->{'Column 12'}:'' ?>
                                <span style="margin-left:30px">No Seri :  <?= isset($data->question1->{'Row 1'}->{'Column 13'})?$data->question1->{'Row 1'}->{'Column 13'}:'' ?></span>
                            </td>
						</tr>

						

                        <tr>
							<td><p><b>Jumlah Perdarahan</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 14'})?$data->question1->{'Row 1'}->{'Column 14'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Jumlah Tranfuse</b></td>
							<td> : </td>
							<td><?= isset($data->question1->{'Row 1'}->{'Column 15'})?$data->question1->{'Row 1'}->{'Column 15'}:'' ?></td>
						</tr>

                        <tr>
							<td><p><b>Jaringan yang di eks/inc</b></p></td>
							<td><p> :</p> </td>
							<td><p><?= isset($data->question1->{'Row 1'}->{'Column 16'})?$data->question1->{'Row 1'}->{'Column 16'}:'' ?></p></td>
						</tr>

                        <tr>
							<td><b>Di Pa kan </b></td>
							<td> : </td>
							<td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 17'})? $data->question1->{'Row 1'}->{'Column 17'} == "item1" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question1->{'Row 1'}->{'Column 17'})? $data->question1->{'Row 1'}->{'Column 17'} == "item2" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                            </td>
						</tr>

					</table><br>
                    <table border="1" style="padding:2px">		
						<thead>										
						<tr>
							<td width="20%"><b>Tgl Operasi</b></td>							
							<td width="20%"><b>Jam Operasi Dimulai</b></td>
							<td width="20%"><b>Jam Operasi Selesai</b></td>
							<td width="30%"><b>Lama Operasi Berlangsung</b></td>							
						</tr>
						</thead>
						<tbody>
						<tr>
							<td width="20%" align="center"><?= isset($data->question1->{'Row 1'}->{'Column 18'})?date('d-m-Y',strtotime($data->question1->{'Row 1'}->{'Column 18'})):'' ?></td>		
							<td width="20%" align="center"><?= isset($data->question1->{'Row 1'}->{'Column 19'})?$data->question1->{'Row 1'}->{'Column 19'}:'' ?></td>
							<td width="20%" align="center"><?= isset($data->question1->{'Row 1'}->{'Column 20'})?$data->question1->{'Row 1'}->{'Column 20'}:'' ?></td>
							<td width="30%" align="center"><?= isset($data->question1->{'Row 1'}->{'Column 21'})?$data->question1->{'Row 1'}->{'Column 21'}:'' ?>Jam</td>							
						</tr>
						</tbody>
					</table>
                    <p style="font-size:12px"><b>LAPORAN OPERASI</b></p>
			        <p style="font-size:12px;min-height:280px"><?= isset($data->question2)?$data->question2:'' ?></p>
                    
                    <div style="display: inline; position: relative;font-size: 12px;">
                        <div style="float: left;text-align: center;">
                            <p>Hal 1 dari 2</p>    
                        </div>
                        <div style="float: right;text-align: center;">
                            <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                        </div>     
                    </div> 
    </div>

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>
        </header>
        

        <p style="font-size:12px"><b>INTRUKSI PASCA BEDAH</b></p>
        <p style="font-size:12px;min-height:30%"><?= isset($data->question3)?$data->question3:'' ?></p>

        <p style="font-size:12px"><b>Obat Obatan yang Diberikan</b></p>
        <p style="font-size:12px;min-height:20%"><?= isset($data->question4)?$data->question4:'' ?></p>

                <br>
                <br><br>
                <br>
                <table style="width:100%;">
                    <tr>
                        <td width="65%" ></td>
                        <td>
                            <p>Operator </p>
                                <?php
                                $id1 =isset($lap_operasi->id_pemeriksa)?$lap_operasi->id_pemeriksa:null;
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
                        </td>
                    </tr>	
                </table>
            <br><br><br>
                    <div style="display: inline; position: relative;font-size: 12px;">
                        <div style="float: left;text-align: center;">
                            <p>Hal 2 dari 2</p>    
                        </div>
                        <div style="float: right;text-align: center;">
                            <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                        </div>     
                    </div> 
    </div>
    
    <?php } ?>
    
    </body>
</html>