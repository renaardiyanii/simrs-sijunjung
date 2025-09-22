<?php 
$data = (isset($rekonsiliasi_obat->formjson)?json_decode($rekonsiliasi_obat->formjson):'');
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
        #data {
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 10px;
            position: relative;
        }
        table tr td{
            font-size: 10px;
            vertical-align: middle;
        }

        #data thead tr th{
            text-align: center;
        } 
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

             <div style="width: 100%;font-size: 12px;min-height:680px;">
                <h2 style="font-weight: bold;text-align: center;">REKONSILIASI OBAT</h2>
                <table border="1" cellspacing="0" cellpadding="4px" id="data">
                    <tr>
                        <td>Ruangan : <?= isset($data->question1->{'ruangan :'})?$data->question1->{'ruangan :'}:'' ?></td>
                        <td>Tgl/Jam : <?= isset($data->question1->tgl_jam)? date('d-m-Y',strtotime($data->question1->tgl_jam)):''; ?> / <?= isset($data->question1->tgl_jam)? date('H:i',strtotime($data->question1->tgl_jam)):''; ?></td>
                    </tr>
                </table>
                <table style="width: 100%;" cellpadding="4px" id="data">
                    <tr> 
                        <td>Alergi Obat : <?= isset($data->alergi_obat)?$data->alergi_obat:'' ?>	Jika Ya, nama obat : <?= isset($data->nama_obat)?$data->nama_obat:'' ?></td>
                        <?php
                            $no=1; 
                            $jml = isset($data->rsb)?count($data->rsb):'';
                            
                        ?>
                        
                        <td>
                            <ol>
                                <?php for ($x = 0; $x < $jml; $x++) { ?>
                                    <li><?php echo isset($data->rsb[$x]->rsb1)?$data->rsb[$x]->rsb1:'' ; ?></li>                                            
                                <?php  } ?>
                            </ol>
                        </td>  
                    </tr>
                 


                        <?php
                            $no=1; 
                            $jml_array = isset($data->reaksi_alergi)?count($data->reaksi_alergi):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td>Reaksi Alergi	: <?= isset($data->reaksi_alergi[$x]->reaksi_alergi)?$data->reaksi_alergi[$x]->reaksi_alergi:'' ?></td>
                            </tr>
                        <?php } ?>

                      
                   
                </table>
                <p style="text-align: center;">Semua Jenis Obat : Obat Bebas, Herbal Atau Traditional Chinese Medicine yang dibawa dari rumah</p>
                <table border="1" cellspacing="0" cellpadding="4px" id="data">
                    <tr>
                        <th style="width: 5%;">TGL</th>
                        <th style="width: 15%;">Nama Obat</th>
                        <th style="width: 5%;">Jumlah Obat</th>
                        <th style="width: 8%;">Dosis/
                            Frekwensi
                            </th>
                        <th style="width: 5%;">Rute</th>
                        <th style="width: 8%;">Berapa Lama/ Mulai Gunakan</th>
                        <th style="width: 8%;">Alasan 
                            makan Obat
                            </th>
                        <th style="width: 18%;">Tindakan Lanjut</th>
                        <th style="width: 8%;">Perubahan Aturan Pakai</th>
                    </tr>


                        <?php
                            $no=1; 
                            $jml_obat = isset($data->jenis_obat)?count($data->jenis_obat):'';
                            for ($x = 0; $x < $jml_obat; $x++) {
                        ?>
                            <tr>
                                <td><?= isset($data->jenis_obat[$x]->tgl)?date('d-m-Y',strtotime($data->jenis_obat[$x]->tgl)):'' ?></td>
                                <td><?= isset($data->jenis_obat[$x]->nama_obat)?$data->jenis_obat[$x]->nama_obat:'' ?></td>
                                <td><?= isset($data->jenis_obat[$x]->jumlah_obat)?$data->jenis_obat[$x]->jumlah_obat:'' ?></td>
                                <td><?= isset($data->jenis_obat[$x]->dosi)?$data->jenis_obat[$x]->dosi:'' ?></td>
                                <td><?= isset($data->jenis_obat[$x]->rute)?$data->jenis_obat[$x]->rute:'' ?></td>
                                <td><?= isset($data->jenis_obat[$x]->berapa_lama)?$data->jenis_obat[$x]->berapa_lama:'' ?></td>
                                <td><?= isset($data->jenis_obat[$x]->alasan_makan_obat)?$data->jenis_obat[$x]->alasan_makan_obat:'' ?></td>
                                <td>
                                    <input style="height: 10px; width: 10px;" type="checkbox" name="" id="" <?= (isset($data->jenis_obat[$x]->tindakan_lanjutan)?in_array("1", $data->jenis_obat[$x]->tindakan_lanjutan)?'checked':'':'') ?>><span>Lanjut aturan pakai sama<span><br>
                                    <input style="height: 10px; width: 10px;" type="checkbox" name="" id="" <?= (isset($data->jenis_obat[$x]->tindakan_lanjutan)?in_array("2", $data->jenis_obat[$x]->tindakan_lanjutan)?'checked':'':'') ?>><span>Lanjut aturan pakai berubah<span><br>
                                    <input style="height: 10px; width: 10px;" type="checkbox" name="" id="" <?= (isset($data->jenis_obat[$x]->tindakan_lanjutan)?in_array("3", $data->jenis_obat[$x]->tindakan_lanjutan)?'checked':'':'') ?>><span>Stop<span>
                                </td>
                                <td><?= isset($data->jenis_obat[$x]->perubahan_aturan_pakai)?$data->jenis_obat[$x]->perubahan_aturan_pakai:'' ?></td>
                                
                            </tr>
                        <?php } ?>
                </table>
            </div>                
            <table id="data" width="100%" border="1">
                <?php
                if(isset($data->nama_ttd)){
                foreach($data->nama_ttd as $val){
                    if(isset($val->nama_ttd1)){
                        $user = explode('-',$val->nama_ttd1);
                        $ttd_pasien = $user[1]??null;
                        // var_dump($ttd_pasien);die();
                        $ttd = $ttd_pasien?$this->db->query("select hmis_users.ttd from hmis_users Where hmis_users.userid=$ttd_pasien")->row()->ttd:null;
                        $name = $user[0]??null;
                    }else{
                        $ttd = '';
                        $name='-';
                    }
                ?>
                    <tr>
                        <td width="60%">
                            Nama dan Tanda Tangan<br>
                            <?php
                            if($ttd!=''){
                            ?>
                            <img src="<?= $ttd ?>" alt="ttd" style="width: 100px;height: 50px;"><br>
                            <?php }else{
                                ?>
                                <br><br><br>
                                <?php
                            } ?>
                                <?= $name ?>
                        </td>
                        <td width="20%" style="text-align:center"><center><?= isset($val->tgl)?date('d m Y ',strtotime($val->tgl)):'-'; ?></center></td>
                        <td width="20%" style="text-align:center"><?= isset($val->pukul)?date('H:i:s',strtotime($val->pukul)):'' ?></td>
                    </tr>
                <?php
                }}
                ?>
                 
                </table>
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