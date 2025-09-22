<?php
$data = (isset($surat_rujukan->formjson)?json_decode($surat_rujukan->formjson):'');
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

            <center><h4>SURAT RUJUKAN</h4></center>
            <center><h5>NO <?= isset($data->question1->no)?$data->question1->no:'......' ?></h5></center>
            <div style="font-size:12px;min-height:850px">
                <div>
                    <p>Kepada Yth. T. Sejawat <?= isset($data->question1->kpd)?$data->question1->kpd:'........' ?></p>
                    <p>Di Rumah Sakit <?= isset($data->question1->dirumah)?$data->question1->dirumah:'........' ?></p>
                    <p>Bagian <?= isset($data->question1->bagian)?$data->question1->bagian:'......' ?></p>
                </div>
                <br>
                <p>Mohon pemeriksaan dan pengobatan lebih lanjut terhadap penderita :</p>
                    <table cellpadding="4px" cellspacing="3px">
                        <tr>
                            <td>Nama</td>
                            <td>&nbsp;: <?= isset($data->question2[0]->nama)?$data->question2[0]->nama:'......' ?>	</td>
                        </tr>
                        <tr>
                            <td>Status Pasien</td>
                            <td>&nbsp;:
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "umum" ? "checked":'':'' ?>>
                                <span>Umum</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "pln" ? "checked":'':'' ?>>
                                <span>PLN</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "bukit" ? "checked":'':'' ?>>
                                <span>Bukit Asam</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "nayaka" ? "checked":'':'' ?>>
                                <span>Nayaka</span>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "bpjs" ? "checked":'':'' ?>>
                                <span>BPJS</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "telkom" ? "checked":'':'' ?>>
                                <span>Telkom</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_pasien)? $data->question2[0]->status_pasien == "other" ? "checked":'':'' ?>>
                                <span>Lainnya, <?= isset($data->question2[0]->{'status_pasien-Comment'})?$data->question2[0]->{'status_pasien-Comment'}:'' ?></span>
                               

                            </td>
                        </tr>
                        <tr>
                            <td>No. Kartu</td>
                            <td>&nbsp;:	<?= isset($data->question2[0]->no_kartu)?$data->question2[0]->no_kartu:'......' ?></td>
                        </tr>
                        <tr>
                            <td>Status peserta</td>
                            <td>&nbsp;:
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_peserta)? $data->question2[0]->status_peserta == "peserta" ? "checked":'':'' ?>>
                                <span>Peserta</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_peserta)? $data->question2[0]->status_peserta == "suami" ? "checked":'':'' ?>>
                                <span>Suami</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_peserta)? $data->question2[0]->status_peserta == "istri" ? "checked":'':'' ?>>
                                <span>Istri</span>
                                <input type="checkbox" <?php echo isset($data->question2[0]->status_peserta)? $data->question2[0]->status_peserta == "anak" ? "checked":'':'' ?>>
                                <span>Anak</span>
                            </td>
                        </tr>
                        <tr>
                            <td>Diagnosa/ keluhan</td>
                            <td>&nbsp;:	<?= isset($data->question2[0]->diagnosa)?$data->question2[0]->diagnosa:'......' ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Tindakan yang telah dilakukan</td>
                            <td>&nbsp;:	<?= isset($data->question2[0]->tindakan)?$data->question2[0]->tindakan:'......' ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Terapi yang telah diberikan</td>
                            <td>&nbsp;: <?= isset($data->question2[0]->terapi)?$data->question2[0]->terapi:'......' ?>	</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Pemeriksaan Penunjang</td>
                            <td>&nbsp;:	 <?= isset($data->question2[0]->pemeriksaan)?$data->question2[0]->pemeriksaan:'......' ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>

                    <br><br><br><br><br><br><br><br><br><br><br><br>
                   


                    <div style="float: right;margin-top: 15px;">
                        <span>Bukittinggi, <?= isset($surat_rujukan->tgl_input)? date('d-m-Y',strtotime($surat_rujukan->tgl_input)):'' ?></span>
                        <p>DPJP/ Dokter Pengirim</p>
                        <?php
                        $id =isset($surat_rujukan->id_pemeriksa)?$surat_rujukan->id_pemeriksa:null;
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
            </div>

            <div style="display: inline; position: relative;font-size: 12px;min-height:870px">
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