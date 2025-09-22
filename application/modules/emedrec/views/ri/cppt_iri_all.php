<?php 
$result = array_chunk($cppt_iri, 1);
// var_dump($result);
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
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
                <div style="height:0px;border: 2px solid black;"></div>
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
                                        <td width="10%" style="<?= ($value->assesment_adime)?"font-size:8pt":'' ?>"><p><?= ($value->assesment_adime)?'A':'S' ?></p><td>
                                        <td width="5%"><p>:</p><td>
                                        <td width="85%" style="<?= ($value->assesment_adime)?"font-size:8pt":'' ?>"><p><?= ($value->assesment_adime)?$value->assesment_adime:$value->subjective?></p><td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->diagnosa_adime)?"font-size:8pt":'' ?>"><?= ($value->diagnosa_adime)?'D':'O' ?><td>
                                        <td width="5%"> :<td>
                                        <td width="85%"> 
                                            <pre style="<?= ($value->diagnosa_adime)?"font-size:8pt":'font-size:9pt' ?>"><?=($value->diagnosa_adime)?$value->diagnosa_adime:str_replace('\n','<br>','Pemerikaan Fisik :  \n'.$value->objective) ?></pre>
                                            <?php 
                                            if(isset($tangan_kanan) && isset($tangan_kiri) && isset($kaki_kanan) && isset($kaki_kiri) ){
                                            ?>
                                             <table  width="10%">
                                                <tr style="border-bottom:1px solid black">
                                                    <td style="font-size:15pt;text-align:center;border-right:1px solid black;">
                                                    <?= $tangan_kanan ?>
                                                    </td>
                                                    <td style="font-size:15pt;text-align:center;">
                                                    <?= $tangan_kiri ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:15pt;text-align:center;border-right:1px solid black;">
                                                    <?= $kaki_kanan ?>
                                                    </td>
                                                    <td style="font-size:15pt;text-align:center;">
                                                    <?= $kaki_kiri ?>
                                                    </td>
                                                </tr>
                                            </table>
                                            <?php } ?>
                                        <td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->intervensi_adime)?"font-size:8pt":'' ?>"><p><?= ($value->intervensi_adime)?'I':'A' ?></p><td>
                                        <td width="5%"><p>:</p><td>
                                        <td width="85%" style="<?= ($value->intervensi_adime)?"font-size:8pt":'' ?>"><p><?= ($value->intervensi_adime)?$value->intervensi_adime:$value->assesment ?></p><td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->monitoring_adime)?"font-size:8pt":'' ?>"><?= ($value->monitoring_adime)?'M':'P' ?><td>
                                        <td width="5%">:<td>
                                        <td width="85%" style="<?= ($value->monitoring_adime)?"font-size:8pt":'' ?>"><?= ($value->monitoring_adime)?$value->monitoring_adime:$value->plan ?><td>
                                    </tr>
                                    <tr height="20px">
                                        <td width="10%" style="<?= ($value->evaluasi_adime)?"font-size:8pt":'' ?>"><?= ($value->evaluasi_adime)?'E':'' ?><td>
                                        <td width="5%"><?= ($value->evaluasi_adime)?':':'' ?><td>
                                        <td width="85%" style="<?= ($value->evaluasi_adime)?"font-size:8pt":'' ?>">
                                        <?= ($value->evaluasi_adime)?$value->evaluasi_adime:'' ?>
                                        <?php echo isset($value->ttd)?'<img width="100" src="'.$value->ttd.'" alt="">':'<br><br>' ?>
                                        <p ><?= isset($value->nama_pemeriksa)?$value->nama_pemeriksa:'' ?></p>
                                        <?php
                                            $json_konsultasi = $value->konsul_dokter?json_decode($value->konsul_dokter):null;
                                            if($json_konsultasi){
                                                foreach($json_konsultasi as $val){
                                        ?>
                                        <table width="100%" border="1">
                                                    <tr>
                                                        <td colspan="2" style="text-align:center;font-size:10px;font-color:blue">KONFIRMASI</td>-
                                                        
                                                    </tr>
                                                    <tr>
                                                    <td> 
                                                            <span style="font-size:9px">Tgl : <?= isset($value->tanggal_pemeriksaan)?date('d/m/Y',strtotime($value->tanggal_pemeriksaan)):'' ?></span><br>
                                                            <span style="font-size:9px">Jam : <?= isset($value->tanggal_pemeriksaan)?date('H:i',strtotime($value->tanggal_pemeriksaan)):'' ?></span><br>
                                                            <p style="font-size:9px;text-align:center;font-size:9px">Penerima Intruksi</p>
                                                                <img width="80px" src="<?= isset($value->ttd)?$value->ttd:'' ?>" alt="">
                                                           
                                                            <p style="font-size:9px;text-align:center"><?= isset($value->nama_pemeriksa)?$value->nama_pemeriksa:'' ?></p>
                                                        </td>
                                                        <td width="50%">
                                                            <span style="font-size:9px;">Tgl : <?= isset($val->Date)?date('d/m/Y',strtotime($val->Date)):'' ?></span><br>
                                                            <span style="font-size:9px">Jam : <?= isset($val->Date)?date('H:i',strtotime($val->Date)):'' ?></span>
                                                            <p style="font-size:9px;text-align:center">Pemberi Intruksi</p>
                                                            <?php
                                                            if(isset($val->respon_konsultasi)){
                                                                if($val->respon_konsultasi == "ya"){
                                                                    // echo var_dump($val->respon_konsultasi);
                                                                $id = explode('-',$val->konsultasi_dokter)[1]??null;
                                                                
                                                                $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where id_dokter = $id")->row():null;
                                                                // var_dump($query);
                                                                if(isset($query->ttd)){
                                                                ?>
                                                                    <img width="80px" src="<?= $query->ttd ?>" alt="">
                                                                <?php
                                                                    } 
                                                                } 
                                                            }?>
                                                            
                                                            <p style="font-size:9px;text-align:center"><?= explode('-',$val->konsultasi_dokter)[0] ?></p>

                                                        </td>
                                                       
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2" style="font-size:10px;font-color:blue">
                                                        Catatan Konsultasi :<br>
                                                        <?= isset($val->cat_konsul)?$val->cat_konsul:'' ?>
                                                        </td>
                                                        
                                                    </tr>
                                                    
                                                </table>
                                        <?php }
                                        } ?>
                                        <td>
                                    </tr>
                                </table>
                           
            
                           
                            </td>
                            <td>
                                <p>
                                   <?php echo $value->instruksi?str_replace([PHP_EOL,"\r","\n"],'<br>',$value->instruksi):''; ?>
                                </p>
                            </td>
                            <td>
                            <p>
                                <!-- disini dpjp -->
                                <span><?= ($value->tgl_acc_pjp)?date('d/m/Y , H:i:s',strtotime($value->tgl_acc_pjp)):'' ?></span><br><br>
                                <p style="text-align:center">
                                <?php echo ($value->ttd_pjp)?'<img width="120" src="'.$value->ttd_pjp.'" alt="">':'<br><br>' ?>
                                <p style="text-align:center"><?= isset($value->nama_pjp)?$value->nama_pjp:'' ?></p>
                                

                            </p>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            
                
                <p style="text-align:right;font-size:12px">1</p>
                </br></br></br></br> </br></br></br></br></br></br></br>
            </div>
        <?php }}else{ ?>
            <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print_ganjil') ?>
            </header>
                <div style="height:0px;border: 2px solid black;"></div>
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
            
                
            <p style="text-align:right;font-size:12px">2</p>
            </br></br></br></br> </br></br></br></br></br></br></br>
            </div>
        <?php } ?>

    </body>
</html>