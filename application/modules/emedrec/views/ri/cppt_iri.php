<?php 
$result = array_chunk($cppt_iri, 1);
$json = isset($result[0]->konsul_dokter)?json_decode($result[0]->konsul_dokter):null;
// var_dump($result); 
// die();
?>

<!DOCTYPE html>
<html>
    <head><title>Catatan Perkembangan Pasien Terintegrasi</title></head>
    <style>
        td,th{
            padding:0.25em;
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
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    CATATAN PERKEMBANGAN PASIEN TERINTEGRASI
                </p>
                <div style="font-size:6px">
                    <table id="data" border="1" cellspacing="0" cellpadding="0">
                        <tr style="text-align: center;">
                            <td style="width: 10%;font-size:11px"><b>Tanggal / Jam</b></td>
                            <td style="width: 10%;font-size:11px"><b>PROFESI / BAGIAN</b></td>
                            <td style="width: 30%;font-size:11px">
                                <b>HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</b><br>
                                (Dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan paraf pada setiap akhir catatan)
                            </td>
                            <td style="width: 25%;font-size:11px">
                                <b>Instruksi Tenaga Kesehatan termasuk pasca Bedah/ Prosedur</b>
                                (Instruksi Ditulis dengan Rinci dan Jelas)
                            </td>
                            <td style="width: 25%;font-size:11px">
                                <b>VERIFIKASI DPJP
                                    (Bubuhkan Stempel Nama, Paraf, Tgl, Jam)
                                    </b>
                                    (DPJP harus membaca seluruh rencana perawatan)
                            </td>
                        </tr>
                        <?php foreach($result[$i] as $value): ?>
                            <?php
                                // $kekuatan_otot = explode('@',$value->kekuatan_otot);
                                // if(count($kekuatan_otot) == 4){
                                $tangan_kiri = $value->tangan_kiri_otot;
                                $tangan_kanan = $value->tangan_kanan_otot;
                                $kaki_kiri = $value->kaki_kiri_otot;
                                $kaki_kanan = $value->kaki_kanan_otot;
                                // }
                                ?>
                        <tr>
                            <td>
                                <p style="font-size:11px;text-align:center"><?= isset($value->tanggal_pemeriksaan)?date('d-m-Y H:i:s',strtotime($value->tanggal_pemeriksaan)):''; ?></p>
                            </td>
                            <td>
                                <p style="font-size:11px;text-align:center"><?= isset($value->role)?$value->role:'' ?></p>
                            </td>
                            <td>
                            
                                <table width="100%">
                                <?php //if() ?>
                                    <tr height="20px">
                                        <p style="color:red;font-size:10px"><?php 
                                            if($value->emergency){
                                                echo 'Emergency';
                                            }
                                            ?></p>
                                        <td width="10%" style="<?= ($value->assesment_adime)?"font-size:10px":'font-size:10px' ?>">

                                            
                                            <p>
                                            <?= ($value->assesment_adime)?'A':'S' ?></p>
                                        </td>
                                        <td width="5%"><p>:</p></td>
                                        <td width="85%" style="<?= ($value->assesment_adime)?"font-size:10px":'font-size:10px' ?>"><p><?= ($value->assesment_adime)?$value->assesment_adime:chunk_split($value->subjective,40,"<br>")?></p></td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->diagnosa_adime)?"font-size:10px":'font-size:10px' ?>"><?= ($value->diagnosa_adime)?'D':'O' ?></td>
                                        <td width="5%"> :</td>
                                        <td width="85%"> 
                                            <pre style="<?= ($value->diagnosa_adime)?"font-size:10px":'font-size:10px' ?>"><?=($value->diagnosa_adime)?$value->diagnosa_adime:chunk_split(str_replace('\n','<br>','Pemerikaan Fisik :  \n'.$value->objective),40,"<br>") ?></pre>
                                            <?php 
                                            if(isset($tangan_kanan) && isset($tangan_kiri) && isset($kaki_kanan) && isset($kaki_kiri) ){
                                            ?>
                                             <table  width="10%">
                                                <tr style="border-bottom:1px solid black">
                                                    <td style="font-size:9pt;text-align:center;border-right:1px solid black;">
                                                    <?= $tangan_kanan ?>
                                                    </td>
                                                    <td style="font-size:9pt;text-align:center;">
                                                    <?= $tangan_kiri ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:9pt;text-align:center;border-right:1px solid black;">
                                                    <?= $kaki_kanan ?>
                                                    </td>
                                                    <td style="font-size:9pt;text-align:center;">
                                                    <?= $kaki_kiri ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->intervensi_adime)?"font-size:10px":'font-size:10px' ?>"><p><?= ($value->intervensi_adime)?'I':'A' ?></p></td>
                                        <td width="5%"><p>:</p></td>
                                        <td width="85%" style="<?= ($value->intervensi_adime)?"font-size:10px":'font-size:10px' ?>"><p><?= ($value->intervensi_adime)?$value->intervensi_adime:$value->assesment ?></p></td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->monitoring_adime)?"font-size:10px":'font-size:10px' ?>"><?= ($value->monitoring_adime)?'M':'P' ?></td>
                                        <td width="5%">:</td>
                                        <td width="85%" style="<?= ($value->monitoring_adime)?"font-size:10px":'font-size:10px' ?>"><?= ($value->monitoring_adime)?$value->monitoring_adime:$value->plan ?></td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->evaluasi_adime)?"font-size:10px":'font-size:10px' ?>"><?= ($value->evaluasi_adime)?'E':'' ?></td>
                                        <td width="5%"><?= ($value->evaluasi_adime)?':':'' ?></td>
                                        <td width="85%" style="<?= ($value->evaluasi_adime)?"font-size:10px":'font-size:10px' ?>">
                                        <?= ($value->evaluasi_adime)?$value->evaluasi_adime:'' ?>
                                        <?php echo isset($value->ttd)?'<img width="50" src="'.$value->ttd.'" alt="">':'<br>' ?>
                                        <p style="font-size:7px"><?= isset($value->nama_pemeriksa)?$value->nama_pemeriksa:'' ?></p>
                                       
                                            </td>
                                    </tr>
                                    <tr height="20px">
                                        <td colspan="3">
                                                <?php
                                                    $json_konsultasi = $value->konsul_dokter?json_decode($value->konsul_dokter):null;
                                                    //var_dump($json_konsultasi[0]->konsultasi_dokter); die();
                                                    if($json_konsultasi){
                                                        foreach($json_konsultasi as $val){
                                                ?>
                                                    <table width="100%" border="1">
                                                        <tr>
                                                            <td colspan="2"  style="text-align:center;font-size:7px;font-color:blue">KONFIRMASI</td>
                                                            <td colspan="2"  style="text-align:center;font-size:7px;font-color:blue">RSUD SIJUNJUNG</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2"  style="text-align:center;font-size:7px;font-color:blue">PEMBERI PESAN</td>
                                                            <td colspan="2"  style="text-align:center;font-size:7px;font-color:blue">PENERIMA PESAN </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Tanggal</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><?= isset($val->table_konsultasi[0]->tgl)?date('d/m/Y',strtotime($val->table_konsultasi[0]->tgl)):'' ?></td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Tanggal</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><?= isset($val->penerima_pesan[0]->tgl)?date('d/m/Y',strtotime($val->penerima_pesan[0]->tgl)):'' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Jam</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><?= isset($val->table_konsultasi[0]->jam)?date('H:i',strtotime($val->table_konsultasi[0]->jam)):'' ?></td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Jam</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><?= isset($val->penerima_pesan[0]->jam)?date('H:i',strtotime($val->penerima_pesan[0]->jam)):'' ?></td>
                                                        </tr>
                                                       
                                                        <?php
                                                                $id_pemberi = isset($val->table_konsultasi[0]->nama_terang)?$val->table_konsultasi[0]->nama_terang:'';
                                                                $idpem = explode('-',$id_pemberi);
                                                                $idpem2 = isset($idpem[1])?$idpem[1]:'';
                                                                $id = isset($idpem2)?$idpem2:null;                         
                                                                $query = $id?$this->db->query("SELECT
                                                                            ttd,name
                                                                        FROM
                                                                            hmis_users
                                                                             
                                                                        WHERE
                                                                            userid = $id")->row():null;



                                                                $id_penerima = isset($val->penerima_pesan[0]->nama_terang)?$val->penerima_pesan[0]->nama_terang:'';
                                                                $idpenerima = explode('-',$id_penerima);
                                                                $idpenerima2 = isset($idpenerima[1])?$idpenerima[1]:'';
                                                                $id2 = isset($idpenerima2)?$idpenerima2:null;                           
                                                                $query2 = $id2?$this->db->query("SELECT
                                                                ttd,name
                                                            FROM
                                                                hmis_users
                                                                 
                                                            WHERE
                                                                userid = $id2")->row():null;
                                                        ?>
                                                         <tr>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Nama Terang</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><?= isset($query->name)?$val->table_konsultasi[0]->nama_terang:'' ?></td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Nama Terang</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><?= isset($query2->name)?$val->penerima_pesan[0]->nama_terang:'' ?></td>
                                                        </tr>
                                                        <tr>
                                                            <?php
                                                            if(isset($val->table_konsultasi[0]->ttd_pemberi)){ ?>
                                                                <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Tanda Tangan</td>
                                                                <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><img src="<?= isset($val->table_konsultasi[0]->ttd_pemberi)?$val->table_konsultasi[0]->ttd_pemberi:'' ?>" alt="" width="50px" height="50px"></td>
                                                            <?php }else{ ?>
                                                                <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Tanda Tangan</td>
                                                                <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><img src="<?= isset($query->ttd)?$query->ttd:'' ?>" alt="" width="50px" height="50px"></td>
                                                            <?php }
                                                            ?>

                                                            <?php 
                                                            if(isset($val->penerima_pesan[0]->ttd_pemberi)){ ?>
<td style="text-align:center;font-size:7px;font-color:blue" width="25%">Tanda Tangan</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><img src="<?= isset($val->penerima_pesan[0]->ttd_pemberi)?$val->penerima_pesan[0]->ttd_pemberi:'' ?>" alt="" width="50px" height="50px"></td>
                                                            <?php }else{ ?>
                                                                <td style="text-align:center;font-size:7px;font-color:blue" width="25%">Tanda Tangan</td>
                                                            <td style="text-align:center;font-size:7px;font-color:blue" width="25%"><img src="<?= isset($query2->ttd)?$query2->ttd:'' ?>" alt="" width="50px" height="50px"></td>
                                                            <?php }
                                                            ?>
                                                       
                                                            
                                                            
                                                        </tr>
                                                             
                                                    
                                                                
                                                    </table>
                                                <?php }
                                                } ?>
                                        </td>
                                    </tr>
                                </table>
                           
            
                           
                            </td>
                            <td>
                                <p style="font-size:10px">
                                   <?php echo $value->instruksi?str_replace([PHP_EOL,"\r","\n"],'<br>',$value->instruksi):''; ?>
                                </p>
                            </td>
                            <td>
                                <p style="font-size:10px">
                                    <!-- disini dpjp -->
                                    <span><?php 
                                        if(date('H:i:s', strtotime($value->tgl_acc_pjp)) == '00:00:00') {
                                            echo ($value->tgl_acc_pjp)?date('d/m/Y',strtotime($value->tgl_acc_pjp)):''; 
                                        } else {
                                            echo ($value->tgl_acc_pjp)?date('d/m/Y , H:i:s',strtotime($value->tgl_acc_pjp)):'';
                                        }
                                    ?></span><br><br>
                                    <p style="text-align:center">
                                    <?php echo ($value->ttd_pjp)?'<img width="120" src="'.$value->ttd_pjp.'" alt="">':'<br><br>' ?>
                                    <p style="text-align:center;font-size:10px"><?= isset($value->nama_pjp)?$value->nama_pjp:'' ?></p>
                                    

                                </p>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            
                
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
                </br></br></br></br> </br></br></br></br></br></br></br>
            </div>
        <?php }}else{ ?>
            <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    CATATAN PERKEMBANGAN PASIEN TERINTEGRASI
                </p>
                <div style="font-size:11px">
                    <table id="data" border="1" cellspacing="0" cellpadding="0">
                        <tr style="text-align: center;">
                            <td style="width: 10%;"><b>Tanggal / Jam</b></td>
                            <td style="width: 10%;"><b>PROFESI / BAGIAN</b></td>
                            <td style="width: 30%;">
                                <b>HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN</b><br>
                                (Dituliskan dengan format SOAP, disertai dengan target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan stempel nama, dan paraf pada setiap akhir catatan)
                            </td>
                            <td style="width: 25%;">
                                <b>Instruksi Tenaga Kesehatan termasuk pasca Bedah/ Prosedur</b>
                                (Instruksi Ditulis dengan Rinci dan Jelas)
                            </td>
                            <td style="width: 25%;">
                                <b>VERIFIKASI DPJP
                                    (Bubuhkan Stempel Nama, Paraf, Tgl, Jam)
                                    </b>
                                    (DPJP harus membaca seluruh rencana perawatan)
                            </td>
                        </tr>
                        <?php //foreach($result[$i] as $value): ?>
                        <tr>
                            <td>
                                <p style="font-size:11px;text-align:center">-</p>
                            </td>
                            <td>
                                <p style="font-size:11px;text-align:center">-</p>
                            </td>
                            <td>
                            
                                <table width="100%">
                                <?php //if() ?>
                                    <tr height="20px">
                                        <td width="10%"><p>S</p><td>
                                        <td width="5%"><p>:</p><td>
                                        <td width="85%"><p>-</p><td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%">O<td>
                                        <td width="5%">:<td>
                                        <td width="85%"> 
                                            TESTING
                                        <table  width="10%">
                                                <tr style="border-bottom:1px solid black">
                                                    <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= '6' ?></td>
                                                    <td style="font-size:15pt;text-align:center;"><?= '5' ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= "4" ?></td>
                                                    <td style="font-size:15pt;text-align:center;"><?= '2' ?></td>
                                                </tr>
                                            </table>
                                        <td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%"><p>A</p><td>
                                        <td width="5%"><p>:</p><td>
                                        <td width="85%"><p>-</p><td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%">P<td>
                                        <td width="5%">:<td>
                                        <td width="85%">-<td>
                                    </tr>
                                    <!-- <tr height="20px">
                                        <td width="10%">E<td>
                                        <td width="5%">:<td>
                                        <td width="85%">-<td>
                                    </tr> -->
                                </table>
                           
            
                           
                            </td>
                            <td>
                                <p>
                              
                                </p>
                            </td>
                            <td>
                            <p>
                                <span>Bukittinggi,.........</span><br><br>
                                <p style="text-align:center">
                                <br><br>
                                <p style="text-align:center">-</p>
                            </p>
                            </td>
                        </tr>
                        <?php //endforeach; ?>
                    </table>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br>
            
                
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            </br></br></br></br> </br></br></br></br></br></br></br>
            </div>
        <?php } ?>

    </body>
</html>