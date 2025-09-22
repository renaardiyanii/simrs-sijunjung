<?php 
$data = (isset($pemberian_obat->formjson)?json_decode($pemberian_obat->formjson):'');
//  var_dump($data);
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
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <div style="width: 100%;font-size: 12px;min-height:870px">
                <center><h3>DAFTAR PEMBERIAN OBAT</h3></center>
                <table id="data" border="1" cellspacing="0" cellpadding="3px">
                    <tr>
                        <td style="width: 50%;"><span>Elergi Terhadap Obat :</span></td>
                        <td style="width: 50%;"><span>Jenis Pasien :       </span></td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><span>Eso Sebelumnya :</span></td>
                        <td style="width: 50%;"><span>Ruangan : <?= isset($data_pasien[0]->nm_ruang)?$data_pasien[0]->nm_ruang:'' ?></span></td>
                    </tr>
                </table>

                <table id="data" border="1" cellspacing="0" cellpadding="0">
                    <tr style="height: 20px;">
                        <th style="width: 50%;" colspan="7"></th>
                        <th style="width: 50%;" colspan="16"></th>
                    </tr>

                    <tr style="height: 20px;">
                    <th rowspan="2">Tanggal
                            </th>
                        <th rowspan="2">Nama Obat (Dagang/Goenerik), Kekuatan
                            </th>
                        <th rowspan="2">Frekwensi
                            /rute
                            </th>
                        <th rowspan="2">Paraf
                            Dokter
                            </th>
                        <th rowspan="2">Paraf
                            Farmasi
                            </th>
                        <th rowspan="2">Paraf
                        Perawat
                        </th>
                        <th rowspan="2">Waktu/
                            petugas
                            </th>
                        <th colspan="4"></th>
                    </tr>

                    <tr style="height: 20px;">
                        <td style="text-align:center;vertical-align:middle;">P</td>
                        <td style="text-align:center;vertical-align:middle;">S</td>
                        <td style="text-align:center;vertical-align:middle;">S</td>
                        <td style="text-align:center;vertical-align:middle;">M</td>
                    </tr>

                    <?php
                    
                            $jml_array = isset($data->pemberian_obat)?count($data->pemberian_obat):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                           <tr>
                               <td><?= isset($data->pemberian_obat[$x]->tgl)?date('d-m-Y',strtotime($data->pemberian_obat[$x]->tgl)):'' ?></td>
                                <td style="vertical-align:middle;height:2.5em;text-align:center;"><?= isset($data->pemberian_obat[$x]->nm_obat)?$data->pemberian_obat[$x]->nm_obat:'' ?></td>
                                <td style="text-align:center;vertical-align:middle;"><?= isset($data->pemberian_obat[$x]->frekuensi)?str_replace(' ','<br>',$data->pemberian_obat[$x]->frekuensi):'' ?></td>
                                      
                                <?php
                                
                                $id = explode('-',$data->pemberian_obat[$x]->nm_dokter)[1]??null;
                                $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;    
                                    ?>
                                <td> <img width="80px" src="<?= isset($query->ttd)?$query->ttd:''  ?>" alt="">
                                     <p><?= isset($data->pemberian_obat[$x]->nm_dokter)?explode('-',$data->pemberian_obat[$x]->nm_dokter)[0]:''  ?></p>
                                </td>
                            
                                <?php
                                
                                $id2 = explode('-',$data->pemberian_obat[$x]->nm_apoteker)[1]??null;
                                // var_dump( $id2);
                                $query2 = $id2?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id2")->row():null;    
                                // var_dump($query2);
                                    ?>
                                <td> <img width="80px" src="<?= isset($query2->ttd)?$query2->ttd:''  ?>" alt="">
                                     <p><?= isset($data->pemberian_obat[$x]->nm_apoteker)?explode('-',$data->pemberian_obat[$x]->nm_apoteker)[0]:''  ?></p>
                                </td>


                                <?php
                                $id3 = explode('-',$data->pemberian_obat[$x]->nm_perawat)[1]??null;
                                $query3 = $id3?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id3")->row():null;    
                                    ?>
                                <td> <img width="80px" src="<?= isset($query3->ttd)?$query3->ttd:''  ?>" alt="">
                                     <p><?= isset($data->pemberian_obat[$x]->nm_perawat)?explode('-',$data->pemberian_obat[$x]->nm_perawat)[0]:''  ?></p>
                                </td>                           
                                    

                                <td style="text-align:center;vertical-align:middle;"><?= isset($data->pemberian_obat[$x]->waktu)?$data->pemberian_obat[$x]->waktu:'' ?></td>
                                <td style="text-align:center;vertical-align:middle;"><?= (isset($data->pemberian_obat[$x]->pssm)?in_array("pagi", $data->pemberian_obat[$x]->pssm)?'&#10004;':'':'') ?></td>
                                <td style="text-align:center;vertical-align:middle;"><?= (isset($data->pemberian_obat[$x]->pssm)?in_array("siang", $data->pemberian_obat[$x]->pssm)?'&#10004;':'':'') ?></td>
                                <td style="text-align:center;vertical-align:middle;"><?= (isset($data->pemberian_obat[$x]->pssm)?in_array("sore", $data->pemberian_obat[$x]->pssm)?'&#10004;':'':'') ?></td>
                                <td style="text-align:center;vertical-align:middle;"><?= (isset($data->pemberian_obat[$x]->pssm)?in_array("malam", $data->pemberian_obat[$x]->pssm)?'&#10004;':'':'') ?></td>
                                
                            </tr>
                            
                        <?php } ?>

                    
                   
                 
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