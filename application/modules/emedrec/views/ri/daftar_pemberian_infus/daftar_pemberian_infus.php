<?php $data = (isset($infus->formjson)?json_decode($infus->formjson):''); ?>

<!DOCTYPE html>
   <html>

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
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

             <div style="width: 100%;font-size: 12px;min-height:870px">
                <h2 style="font-weight: bold;text-align: center;">DAFTAR PEMBERIAN INFUS</h2>

                <table id="data" border="1" cellspacing="0" cellpadding="0">
                    <tr style="text-align: center;height: 20px;">
                        <th style="width: 15%;">Dokter</th>
                        <th style="width: 10%;">Botol Ke</th>
                        <th style="width: 10%;">Jenis Cairan</th>
                        <th style="width: 5%;">Tetes/cc</th>
                        <th style="width: 5%;">Permenit</th>
                        <th style="width: 10%;">Mulai Tgl & Jam</th>
                        <th style="width: 10%;">Selesai Tgl & Jam</th>
                        <th style="width: 15%;">Paraf Perawat</th>
                        <th style="width: 20%;">Keterangan</th>
                    </tr>
                    <?php
                            $no=1; 
                            $jml_array = isset($data->question1)?count($data->question1):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                    <tr>
                        <td style="text-align:center;margin-top:15px"><?= isset($data->question1[$x]->nm_dokter)?Explode('-',$data->question1[$x]->nm_dokter)[0]:(isset($data->question1[$x]->nm_dokter)?Explode('-',$data->question1[$x]->nm_dokter)[0]:'') ?></td>
                        <td style="text-align:center"> <?= isset($data->question1[$x]->botol)?$data->question1[$x]->botol:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question1[$x]->jns_cairan)?$data->question1[$x]->jns_cairan:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question1[$x]->column1)?$data->question1[$x]->column1:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question1[$x]->column2)?$data->question1[$x]->column2:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question1[$x]->jam)?date('d-m-Y h:i',strtotime($data->question1[$x]->jam)):'' ?></td>
                        <td style="text-align:center"><?= isset($data->question1[$x]->tgl_selesai)?date('d-m-Y h:i',strtotime($data->question1[$x]->tgl_selesai)):'' ?></td>
                        <td style="text-align:center">
                        <?php
                                $id_dok = isset($data->question1[$x]->perawat)?Explode('-',$data->question1[$x]->perawat)[1]:(isset($data->question1[$x]->perawat)?Explode('-',$data->question1[$x]->perawat)[1]:'');
                                                                
                                $query_ttd = $id_dok?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where  hmis_users.userid = $id_dok")->row():null;
                                // $ttd_contoh = isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd;
                                //if(isset($ttd_dokter_pengirim->ttd_dokter_pengirim)?$ttd_dokter_pengirim->ttd_dokter_pengirim:$query_ttd->ttd){
                                    if(isset($query_ttd->ttd)){
                                        //  var_dump($ttd_dokter_pengirim);
                            ?>    <div>
                                        <img width="70px" src="<?php echo $query_ttd->ttd ?>" alt=""><br>
                                    </div>
                                <?php } else {?>
                                        <br><br><br>
                                    <?php } ?>
                        </td>
                        <td style="text-align:center"><?= isset($data->question1[$x]->ket)?$data->question1[$x]->ket:'' ?></td>
                    </tr>
                    <?php } if($jml_array<=10){
                        $jml_kurang = 10 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){ ?>
                        <tr>
                            <td style="text-align:center;margin-top:15px" height="5px">&nbsp;</td>
                            <td style="text-align:center"> &nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                            <td style="text-align:center">&nbsp;</td>
                        </tr>
                    <?php }} ?>
                </table>
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