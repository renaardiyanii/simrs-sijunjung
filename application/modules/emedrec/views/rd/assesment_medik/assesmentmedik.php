<?php 
// var_dump($rawat_jalan);
$data = (isset($assesment_medik_ird[0]->formjson))?json_decode($assesment_medik_ird[0]->formjson):'';
$data_obat = (isset($keperawatan[0]->formjson)?json_decode($keperawatan[0]->formjson):'');
$hari = (isset($rawat_jalan[0]->tgl_kunjungan))?date('D',strtotime($rawat_jalan[0]->tgl_kunjungan)):'';
// var_dump($data);
switch($hari){
    case 'Fri':
        $hari = 'Jum\'at';
        break;
    case 'Sat':
        $hari = 'Sabtu';
        break;
    case 'Sun':
        $hari = 'Minggu';
        break;
    case 'Mon':
        $hari = 'Senin';
        break;
    case 'Tue':
        $hari = 'Selasa';
        break;
    case 'Wed':
        $hari = 'Rabu';
        break;
    default:
        $hari = 'Kamis';
        break;
}
// var_dump($data);
?>
<!DOCTYPE html>
<html lang="en">
    <style>
          body{
            margin: 0;
            padding: 0;
        }
        .header-parent{
            display: flex;
            justify-content: space-between;

        }
        .right{
            display: flex;
            align-items: flex-end;
            flex-direction: column;
        }
        .patient-info{
            border: 1px solid black;
            padding: 1em;
            display: flex;
            border-radius: 10px;
        }
        #date{
            display: flex;
            justify-content: space-between;
        }
        .kotak{
            
            height: 10;
            width: 10;
            /* border: 1px solid black; */
        }

        .jeniskasus{
            margin-top: 0.5em;
            margin-bottom:0.5em;
            /* padding: 0.5em; */
          
            display: flex;
        }
        .anamnesis{
           border: 0; 
        }
        .bold{
            font-weight: bold;
        }

        .two-row{
            display: flex;
            /* justify-content: space-between; */

        }
        
        .pemeriksaan-umum{
            display: flex;
            justify-content: space-between;
            margin-right: 5em;
        }
        .column-pemeriksaan{
            margin-left: 2px;
            /* margin-right: ; */
        }
        .addspacing{
            margin-right: 10px;
            margin-left: 20px;
        }
        .status{
            margin-top:0.25em;
            margin-bottom:0.25em;
            min-height:50px;
            /* background-color:red; */
        }
        .flexstatus{
            display: flex;
            justify-content: space-between;
        }

        #page2{
            margin-top:100px;
        }
        .footer{
            display: flex;
            justify-content: flex-end;
            margin-top:200px;
        }
        .space{
            margin-left: 10px;
        }
        .spacekosong{
            margin-top:200px;
            margin-bottom:200px;
        }
        .kesimpulan-akhir-content{
            margin-left: 5px;
            
        }
        
        .content-parent{
            display: flex;
            /* margin-right: 100px; */
        }
        .content{
            margin-right: 30px;
        }
        .ttd{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            margin-right: 50px;
        }
        #childttd{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .box{
            margin-top:0.25em;
            min-height:50px;
            margin-bottom:0.25em;
        }
    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesmen awal medik IGD</title>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4" >

<!-- hal 1 -->
    <div class="A4 sheet  padding-fix-10mm"><br>
        <?php $this->load->view('emedrec/rj/header_print') ?>
        <center><h3>ASSESMEN MEDIS IGD</h3></center>
        <div style="font-size:12px;">
             <table border=0 width="100%"  style="font-size:12px">
                <tr>
                    <td width="18%" style="font-size:12px"> <p class="margin-text">Hari/Tanggal</p></td>
                    <td width="2%" style="font-size:12px"><p>:</p></td>
                    <td width="30%" style="font-size:12px"><p><?= (isset($rawat_jalan[0]->tgl_kunjungan))?$hari.' , '.date('d-m-Y',strtotime($rawat_jalan[0]->tgl_kunjungan)):'-'; ?></p></td>
                    <td width="18%" style="font-size:12px"><p>Jam Masuk</p></td>
                    <td width="2%" style="font-size:12px"><p>:</p></td>
                    <td width="30%" style="font-size:12px"><p><?= isset($data_obat->jam_masuk)?$data_obat->jam_masuk:'-' ?> WIB</p></td>

                </tr>
                <tr>
                    <td width="18%" style="font-size:12px"> <span class="margin-text">Jam Ditolong</span></td>
                    <td width="2%" style="font-size:12px">:</td>
                    <td width="30%" style="font-size:12px"><?= isset($data_obat->jam_masuk)?$data_obat->jam_masuk:'-' ?></td>
                    <td width="18%" style="font-size:12px">Jam Keluar</td>
                    <td width="2%" style="font-size:12px">:</td>
                    <td width="30%" style="font-size:12px"><?= isset($data_obat->jam_keluar)?$data_obat->jam_keluar:'-' ?> WIB</td>
                </tr>
                <tr>
                    <td width="18%" style="font-size:12px"> <p class="margin-text">Jenis Kasus</p></td>
                    <td width="2%" style="font-size:12px"><p>:</p></td>
                    <td width="30%" style="font-size:12px" colspan="4"><p>
                        <input type="checkbox" id="bedah" name="neurologi" value="neurologi"  <?= (isset($data->jenis_kasus))?($data->jenis_kasus == 'bedah')?'checked':'':'' ?>>
                        <span>Bedah</span>
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->jenis_kasus))?($data->jenis_kasus == 'neurolog')?'checked':'':'' ?>>
                        <span>Neurologi</span>
                        <input type="checkbox" id="non-neurologi" name="neurologi" value="neurologi" <?= (isset($data->jenis_kasus))?($data->jenis_kasus == 'non_neurologi ')?'checked':'':'' ?>>
                    <span>Non-Neurologi</span></p>   
                </tr>
                <tr>
                    <td width="18%" style="font-size:12px">ANAMNESIS</td>
                    <td width="2%" style="font-size:12px">:</td>
                    <td width="30%" style="font-size:12px" colspan="4"> 
                       
                            
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi"  <?= (isset($data->anamnesa))?in_array('auto_anamnesa',$data->anamnesa)?'checked':'':'' ?>>
                            <span>AUTO</span>
                       
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (isset($data->anamnesa))?in_array('allo_anamnesa',$data->anamnesa)?'checked':'':'' ?>>
                            <span>ALLO</span>
                </tr>
            </table>

            <p style="font-size:12px;font-weight:bold">ANAMNESIS</p>
            <p style="font-size:12px;margin-left:15px"> <?= isset($data->anamnesis)? $data->anamnesis: '' ;?></p>
           
            
    
            <div class="pemeriksaan">
               <b> <p>PEMERIKSAAN FISIK</p></b>

               <table border=0 width="100%"  style="font-size:12px">
                    <tr>
                        <td width="10%" style="font-size:12px"> <p class="margin-text">KU</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p><?= (isset($data->ku))?$data->ku:''; ?></p></td>
                        <td width="10%" style="font-size:12px"><p>Kesadaran</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p> <?= (isset($data->kesadaran))?$data->kesadaran:''; ?></p></td>
                    </tr>
                    <tr>
                        <td width="10%" style="font-size:12px"> <p class="margin-text">TD</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p><?= (isset($data->td))?$data->td:''; ?> mmHg</p></td>
                        <td width="10%" style="font-size:12px"><p>GCS</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p> <?= (isset($data->gcs))?$data->gcs:''; ?></p></td>

                    </tr>
                    <tr>
                        <td width="10%" style="font-size:12px"> <p class="margin-text">Nadi</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p><?= (isset($data->nadi))?$data->nadi:''; ?> x/i</p></td>
                        <td width="10%" style="font-size:12px"><p>Motorik</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p></p></td>

                    </tr>
                    <tr>
                        <td width="10%" style="font-size:12px"> <p class="margin-text">Pernafasan</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p><?= (isset($data->pernafasan))?$data->pernafasan:''; ?></p></td>
                        <td width="10%" style="font-size:12px"><p>Sensorik</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"></td>
                        
                    </tr>
                    <tr>
                        <td width="10%" style="font-size:12px"> <p class="margin-text">Suhu</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px"><p><?= (isset($data->suhu))?$data->suhu:''; ?></p></td>
                        
                    </tr>
                   
                  
                    <tr>
                        <td width="10%" style="font-size:12px"> <p class="margin-text">BB</p></td>
                        <td width="2%" style="font-size:12px"><p>:</p></td>
                        <td width="38%" style="font-size:12px" colspan="4"><p><?= (isset($data->bb))?$data->bb:'0'; ?> Kg</p></td>
            

                    </tr>
                </table>
                <div style="position:absolute;top:53%;right:5%">
                        <div class="two-row">
                            <?php 
                            if(isset($data->sensorik_tangan_kanan) || isset($data->sensorik_tangan_kiri) || isset($data->motorik_kaki_kanan) ||isset($data->motorik_kaki_kiri) ){

                            
                            ?>
                            <table  width="10%">
                                <tr style="border-bottom:1px solid black">
                                    <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->sensorik_tangan_kiri)?$data->sensorik_tangan_kiri:'' ?></td>
                                    <td style="font-size:15pt;text-align:center;"><?= isset($data->sensorik_tangan_kanan)?$data->sensorik_tangan_kanan:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->motorik_kaki_kiri)?$data->motorik_kaki_kiri:'' ?></td>
                                    <td style="font-size:15pt;text-align:center;"><?= isset($data->motorik_kaki_kanan)?$data->motorik_kaki_kanan:'' ?></td>
                                </tr>
                            </table>&nbsp;&nbsp;&nbsp;
                            <?php
                            }
                            ?>
                            <?php 
                            if(isset($data->lengan_kiri) || isset($data->lengan_kiri) || isset($data->kaki_kanan) ||isset($data->kaki_kiri) ){

                            
                            ?>
                            <table  width="10%">
                            <tr style="border-bottom:1px solid black">
                                <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?php 
                               if(isset($data->lengan_kanan)){
                                echo $data->lengan_kanan;
                            }
                                // else{
                                //     if(isset($data->lateralisasi_lengan_kiri)){
                                //         echo 'X';
                                //     }
                                // }
                                ?></td>
                                <td style="font-size:15pt;text-align:center;"><?php 
                               
                                if(isset($data->lengan_kiri)){
                                    echo $data->lengan_kiri;
                                }
                                // else{
                                //     if(isset($data->lateralisasi_lengan_kanan)){
                                //         echo 'X';
                                //     }
                                // }
                                ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?php 
                               
                                if(isset($data->kaki_kanan)){
                                    echo $data->kaki_kanan;
                                }
                                // else{
                                //     if(isset($data->lateralisasi_kaki_kiri)){
                                //         echo 'X';
                                //     }
                                // }
                                ?></td>
                                <td style="font-size:15pt;text-align:center;"><?php 
                                 if(isset($data->kaki_kiri)){
                                    echo $data->kaki_kiri;
                                }
                                // else{
                                //     if(isset($data->lateralisasi_kaki_kanan)){
                                //         echo 'X';
                                //     }
                                // }
                                ?></td>
                            </tr>
                        </table>
                        <?php } ?>
                       
                        </div>
                       
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="literalisasi_kiri" name="literalisasi_kanan" value="1" <?= isset($data->lateralisasi_lengan_kiri[0])?"checked":"" ?> >
                            <label style="margin-right:20px;" class="form-check-label" for="literalisasi_kiri">Literalisasi Kiri</label>

                            <input type="checkbox" class="form-check-input" id="literalisasi_kanan" name="literalisasi_kiri" value="1" <?= isset($data->lateralisasi_lengan_kanan[0])?"checked":"" ?>>
                            <label class="form-check-label" for="literalisasi_kanan">Literalisasi Kanan</label>
                        </div>	
                    </div>
                
                
            </div>
            <!-- <br> -->
            
            <!-- <br> -->
            <div class="status">
                <span class="bold"> </span> <br>
                <div style="display:flex;">
                    <div style="width:60%">

                        <div style="width:70%" class="box">
                            <span class="bold">Status Generalis :</span><br>
                            <span>
                            <?= (isset($data->status_generalis_dokter))?$data->status_generalis_dokter:''; ?>
                            
                            </span>

                        </div>

                        <div class="box">
                            <span class="bold">Status Lokalis :</span><br>
                            <span>
                            <?= (isset($data->status_lokalis_dokter))?$data->status_lokalis_dokter:''; ?>
                            
                            </span>

                        </div>

                        <div class="box">
                            <span class="bold">Diagnosis Kerja : </span><br>
                            <span>
                            <?php 
                                foreach($diagnosa_kerja as $r) {
                                    echo '-'.$r->diagnosa.' ('.$r->klasifikasi_diagnos.') <br>';
                                }
                             ?>
                            </span>

                        </div>

                        <div class="box">
                            <span class="bold">Diagnosis Banding : </span><br>
                            <span>
                            <?= (isset($data->diagnosa_banding_dokter))?$data->diagnosa_banding_dokter:''; ?>

                            </span>
                            
                        </div>
                        <div class="box">
                            <span class="bold">Pemeriksaan Penunjang : </span><br>
                            <span>
                            <?php 
                                foreach($penunjang as $r) {
                                    echo '-'.$r->jenis_tindakan.' ('.$r->ket.') <br>';
                                }
                             ?>
                            </span>
                        </div>
                        
                    </div>
                    <div style="position:absolute;bottom:0;right:0">
                        <div style="position:absolute;bottom:0%;right:0%;">
                            <?php
                            if(isset($data->imageigd)){
                            ?>
                                <img src=" <?= $data->imageigd ?>"  alt="img" height="300" width="300">
                            <?php } ?>
                        </div>
                            <img src="<?= base_url('assets/images/gambar_orang.png') ?>" height="300" width="300" alt="">

                    </div>
                    
                </div>

            </div>
            
        </div><br><br><br><br><br><br>
        <p style="text-align:left;font-size:12px">Hal 1 dari 5</p>
    </div>


<!-- halaman 2 -->
    <div class="A4 sheet  padding-fix-10mm"><br>
        <?php $this->load->view('emedrec/rj/header_print_genap') ?>
        <center><h3>ASSESMEN MEDIS IGD</h3></center>
        <div style="font-size:11px;">
            <div id="terapi" style="min-height:200px;max-height:250px;">
                <span class="bold">TERAPI / TINDAKAN</span>
                <span class="space"> : </span><br><br>
                <table border="1" width="100%" id="terapi">
                         
                         <tr>
                             <td style="text-align:center;height:20px;">Nama Obat/Infus</td>
                             <td style="text-align:center">Frekuensi</td>
                             <td style="text-align:center">Dosis</td>
                             <td style="text-align:center">Cara Pemberian</td>
                             <td style="text-align:center">Nama & Tanda Tangan</td>
                         </tr>
                         <?php
                        // var_dump($data);
                        $jml_array = isset($data->question5)?count($data->question5):'';
                         for ($x = 0; $x < $jml_array; $x++) {
                             if($x<20){
                     ?>
                         <tr>
                             <td style="text-align:center;vertical-align:middle;font-size:9px;"><?= isset($data->question5[$x]->nama_obat)?$data->question5[$x]->nama_obat:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;font-size:9px;"><?= isset($data->question5[$x]->jumlah_frekwensi)?$data->question5[$x]->jumlah_frekwensi:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;font-size:9px;"><?= isset($data->question5[$x]->dosis)?$data->question5[$x]->dosis:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;font-size:9px;"><?= isset($data->question5[$x]->cara_pemberian)?$data->question5[$x]->cara_pemberian:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;font-size:9px;">
                                 <?php
                                 if(isset($rawat_jalan[0]->ttd)){
                                 ?>
                                     <img width="50px" src="<?= (isset($rawat_jalan[0]->ttd)?$rawat_jalan[0]->ttd:''); ?>" alt=""><br>
                                     <span style="font-size:8px">(<?= (isset($rawat_jalan[0]->dokter)?$rawat_jalan[0]->dokter:''); ?>)</span><br>

                                 <?php }else{ ?>
                                     <br><br>
                                     <?php } ?>
                             </td>
                         </tr>
                             <?php } } ?>

                </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            
                <p style="text-align:left;font-size:12px">Hal 2 dari 5</p>
            </div>
            
            
        </div>
    </div>

    <?php
    if($jml_array > 8 && $jml_array < 17){
    ?>
    <!-- halaman 3 -->
    <div class="A4 sheet  padding-fix-10mm"><br>
        <?php $this->load->view('emedrec/rj/header_print') ?>
        <center><h3>ASSESMEN MEDIS IGD</h3></center>
        <div style="font-size:11px;">
            <div id="terapi" style="min-height:800px;max-height:250px;">
                <span class="bold">TERAPI / TINDAKAN</span>
                <span class="space"> : </span><br><br>
                <table border="1" width="100%" >
                         
                         <tr>
                             <td style="text-align:center;height:20px;">Nama Obat/Infus</td>
                             <td style="text-align:center">Frekuensi</td>
                             <td style="text-align:center">Dosis</td>
                             <td style="text-align:center">Cara Pemberian</td>
                             <td style="text-align:center">Nama & Tanda Tangan</td>
                         </tr>
                         <?php
                        // var_dump($data);
                         $jml_array = isset($data->question5)?count($data->question5):'';
                         for ($x = 0; $x < $jml_array; $x++) {
                             if($x>8 && $x < 17){
                     ?>
                         <tr>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->nama_obat)?$data->question5[$x]->nama_obat:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->jumlah_frekwensi)?$data->question5[$x]->jumlah_frekwensi:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->dosis)?$data->question5[$x]->dosis:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->cara_pemberian)?$data->question5[$x]->cara_pemberian:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;">
                                 <?php
                                 if(isset($rawat_jalan[0]->ttd)){
                                 ?>
                                     <img width="120px" src="<?= (isset($rawat_jalan[0]->ttd)?$rawat_jalan[0]->ttd:''); ?>" alt=""><br>
                                     <span style="font-size:12px">(<?= (isset($rawat_jalan[0]->dokter)?$rawat_jalan[0]->dokter:''); ?>)</span><br>

                                 <?php }else{ ?>
                                     <br><br>
                                     <?php } ?>
                             </td>
                         </tr>
                             <?php } } ?>

         </table>
         
            </div>
            
            <p style="text-align:left;font-size:12px">Hal 3 dari 5</p>
        </div>
    </div>
    <?php } ?>

    <?php
    if($jml_array > 17 && $jml_array < 25){
    ?>
    <!-- halaman 4 -->
    <div class="A4 sheet  padding-fix-10mm"><br>
        <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            <br>
        <div style="height:0px;border: 2px solid black;"></div>

        <center><h3>ASSESMEN MEDIS IGD</h3></center>
        <div style="font-size:11px;">
            <div id="terapi" style="min-height:200px;max-height:250px;">
                <span class="bold">TERAPI / TINDAKAN</span>
                <span class="space"> : </span><br><br>
                <table border="1" width="100%" >
                         
                         <tr>
                             <td style="text-align:center;height:20px;">Nama Obat/Infus</td>
                             <td style="text-align:center">Frekuensi</td>
                             <td style="text-align:center">Dosis</td>
                             <td style="text-align:center">Cara Pemberian</td>
                             <td style="text-align:center">Nama & Tanda Tangan</td>
                         </tr>
                         <?php
                        // var_dump($data);
                         $jml_array = isset($data->question5)?count($data->question5):'';
                         for ($x = 0; $x < $jml_array; $x++) {
                             if($x>17 && $x<25){
                     ?>
                         <tr>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->nama_obat)?$data->question5[$x]->nama_obat:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->jumlah_frekwensi)?$data->question5[$x]->jumlah_frekwensi:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->dosis)?$data->question5[$x]->dosis:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;"><?= isset($data->question5[$x]->cara_pemberian)?$data->question5[$x]->cara_pemberian:'' ?></td>
                             <td style="text-align:center;vertical-align:middle;">
                                 <?php
                                 if(isset($rawat_jalan[0]->ttd)){
                                 ?>
                                     <img width="120px" src="<?= (isset($rawat_jalan[0]->ttd)?$rawat_jalan[0]->ttd:''); ?>" alt=""><br>
                                     <span style="font-size:12px">(<?= (isset($rawat_jalan[0]->dokter)?$rawat_jalan[0]->dokter:''); ?>)</span><br>

                                 <?php }else{ ?>
                                     <br><br>
                                     <?php } ?>
                             </td>
                         </tr>
                             <?php } } ?>

         </table>
         
            </div>
            
            
        </div>
    </div>
    <?php } ?>


    <!-- hal 4 -->
    <div class="A4 sheet  padding-fix-10mm"><br>
        <?php $this->load->view('emedrec/rj/header_print_genap') ?>
        <center><h3>ASSESMEN MEDIS IGD</h3></center>
        <div style="font-size:11px;">
            <div id="terapi">
                <span class="bold">KESIMPULAN AKHIR</span>
                <span class="space">: </span>
            </div>
            <div class="content-parent">
                <div class="content" style="border:0;">
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= ($rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP')?'checked':''; ?>>
                        <span>Dirawat di :   <?= (($rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP'))?$rawat_jalan[0]->saran_rawat??"":''; ?></span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= (($rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP'))?'checked':''; ?>>
                        <span>Pindah Jam : <?= (($rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP'))?date('H:i:s',strtotime($rawat_jalan[0]->waktu_pulang)):''; ?> WIB</span>
                    </div>
            </div>
                <div class="content" style="border:0;">
                    <div class="kesimpulan-akhir-content">
                        <span>Pulang :</span>
                    </div>
                    
                    <br>
                    <div class="kesimpulan-akhir-content">
                        <div>
                            <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" 
                            <?php 
                            if($rawat_jalan[0]->ket_pulang == 'izin_dokter'){
                                echo 'checked';
                            }else{
                                echo '';
                            } ?>>
                            <span>Izin Dokter</span>
                        </div>
                       
                        
                        
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->ket_pulang)?$rawat_jalan[0]->ket_pulang == 'atas_permintaan_sendiri'?'checked':'':''  ?>>
                        <span>Atas Permintaan Sendiri </span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->ket_pulang)?$rawat_jalan[0]->ket_pulang == 'tindak_lanjut'?'checked':'':''  ?>>
                        <span>Tindak lanjut</span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->ket_pulang)?$rawat_jalan[0]->ket_pulang == 'dirujuk'?'checked':'':''  ?>>
                        <span>Kontrol ke poli</span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->ket_pulang)?$rawat_jalan[0]->ket_pulang == 'Puskesmas'?'checked':'':''  ?>>
                        <span>Puskesmas</span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->ket_pulang)?$rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP' ||$rawat_jalan[0]->ket_pulang == 'rujuk_rs_lain' ?'checked':'':''  ?>>
                        <!-- <span>Rujuk Ke <?php //echo $rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP' ||$rawat_jalan[0]->ket_pulang == 'rujuk_rs_lain' ?$rawat_jalan[0]->tujuan_rs?$rawat_jalan[0]->tujuan_rs:'Rawat Inap':''; ?></span> -->
                        <span>Rujuk Ke <?php
                        if($rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP'){
                            echo 'Rawat Inap';
                        }elseif($rawat_jalan[0]->ket_pulang == 'rujuk_rs_lain'){
                            echo $rawat_jalan[0]->tujuan_rs;
                        }else{
                            echo '';
                        }
                        ?> </span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <!-- <input type="checkbox" id="neurologi" name="neurologi" value="neurologi"> -->
                        <span style="margin-left:10px;">Alasan Rujuk : <?= isset($rawat_jalan[0]->catatan_plg)?$rawat_jalan[0]->catatan_plg:''; ?></span>
                    </div>
                </div>

                <div class="content" style="border:0;">
                    <br>
                    <br>
                    <div class="kesimpulan-akhir-content">
                       <span>
                           Jam : 
                       </span>
                       <span><?= $rawat_jalan[0]->ket_pulang == 'izin_dokter'?date('H:i:s',strtotime($rawat_jalan[0]->waktu_pulang)):'.......'; ?></span>
                       <span>WIB</span>
                    </div>
                    <div class="kesimpulan-akhir-content">
                        <span>
                            Jam : 
                        </span>
                        <span><?= $rawat_jalan[0]->ket_pulang == 'atas_permintaan_sendiri'?date('H:i:s',strtotime($rawat_jalan[0]->waktu_pulang)):'.......'; ?></span>
                        <span>WIB</span>
                     </div>
                     <br>
                     
                     <div class="kesimpulan-akhir-content" style="margin-top:7px;">
                        <span>
                            Jam : 
                        </span>
                        <span><?= (($rawat_jalan[0]->ket_pulang == 'DIRUJUK_RAWATINAP'))?date('H:i:s',strtotime($rawat_jalan[0]->waktu_pulang)):''; ?></span>
                        <span>WIB</span>
                     </div>
                    
                </div>
            </div>
            <br>
            <br>
            <div id="terapi">
                <span class="bold">KONDISI SAAT PULANG</span>
                <span class="space">: </span>
            </div>
            <div style="display: flex;">
                <div class="kesimpulan-akhir-content">
                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->tindak_lanjut)?$rawat_jalan[0]->tindak_lanjut == 'sembuh'?'checked':'':''  ?>>
                    <span>Sembuh</span>
                </div>
                <div class="kesimpulan-akhir-content">
                    <input type="checkbox" id="neurologi" name="neurologi" value="neurologi" <?= isset($rawat_jalan[0]->tindak_lanjut)?$rawat_jalan[0]->tindak_lanjut == 'perbaikan'?'checked':'':''  ?>>
                    <span>Perbaikan</span>
                </div>
                <div class="kesimpulan-akhir-content">
                    <input type="checkbox" id="neurologi" name="neurologi"  <?= isset($rawat_jalan[0]->tindak_lanjut)?$rawat_jalan[0]->tindak_lanjut == 'tidak_sembuh'?'checked':'':''  ?>>
                    <span>Tidak Sembuh</span>
                </div>
                <div class="kesimpulan-akhir-content">
                    <input type="checkbox" id="neurologi" name="neurologi"  <?= isset($rawat_jalan[0]->tindak_lanjut)?$rawat_jalan[0]->tindak_lanjut == 'meninggal'?'checked':'':''  ?>>
                    <span>Meninggal, JAM : WIB</span>
                </div>
                <div class="kesimpulan-akhir-content">
                    <input type="checkbox" id="neurologi" name="neurologi"  <?= isset($rawat_jalan[0]->tindak_lanjut)?$rawat_jalan[0]->tindak_lanjut == 'doa'?'checked':'':''  ?>>
                    <span>DOA</span>
                </div>

              
            </div><br><br><br>
                
            <div style="display:flex">
                <div>
                    <p><b>OBSERVASI</b></p>
                    <span><u>subject</u></span>
                    <div style="min-height:60px"><?= isset($data->subject)?$data->subject:'' ?></div>

                    <span><u>Assesment</u></span>
                    <div style="min-height:60px"><?= isset($data->assesment)?$data->assesment:'' ?></div>
                </div>

                <div style="margin-left:300px">
                    <p><b><br></b></p>
                    <span><u>Object</u></span>
                    <div style="min-height:60px"><?= isset($data->object)?$data->object:'' ?></div>

                    <span><u>Plan</u></span>
                    <div style="min-height:60px"><?= isset($data->plan)?$data->plan:'' ?></div>
                </div>
                
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

            <p style="text-align:left;font-size:12px">Hal 4 dari 5</p>
            </div>
        </div>


            <div class="A4 sheet  padding-fix-10mm"><br>
                <?php $this->load->view('emedrec/rj/header_print') ?>

                <center><h3>ASSESMEN MEDIS IGD</h3></center>
                <div style="font-size:11px;">
                <div style="min-height:600px">
                <?php
                    if(isset($data->table_konsultasi)){
                    $values = array_chunk($data->table_konsultasi, 2);
                    // var_dump($values);die();
                    for($i = 0;$i<count($values);$i++){
                ?>

                <div style="display:flex;justify-content:space-between;">
                        <div>
                            <?php
                            foreach($values[$i] as $val){
                            //  var_dump($values);die();
                            ?>
                            <span class="bold">KONSULTASI KE DOKTER SPESIALIS</span>
                            <span class="space">: </span><br><br>
                            <span><?= $val->konsultasi_dokter??''; ?></span><br>
                            <span class="bold">Tgl. Konsultasi</span>
                            <span class="space">: </span>
                            <span><?php
                            $date = "";
                            $time = "";
                            if(isset($val->Date)){
                                $date = date('d-m-Y',strtotime($val->Date));
                            }
                            if(isset($val->Time)){
                                $time = $val->Time;
                            }
                            echo $date.' '.$time;
                            ?></span><br>
                            
                            <?php
                                //var_dump($val->konsultasi_dokter);die();
                                // if(isset($val->respon_konsultasi)){
                                    // if($val->respon_konsultasi == "ya"){
                                // if(isset($val->konsultasi_dokter)){
                                $dok = isset($val->konsultasi_dokter)?$val->konsultasi_dokter:'';
                                $ttd_dokter = $this->db->query("SELECT hmis_users.ttd FROM 
                                data_dokter as a
                                left join dyn_user_dokter on a.id_dokter = dyn_user_dokter.id_dokter
                                left join hmis_users on hmis_users.userid = dyn_user_dokter.userid where a.nm_dokter = '$dok' LIMIT 1")->row('ttd');
                                // var_dump($ttd_dokter);die();
                            ?>
                            <img width="140px" src="<?= $ttd_dokter ?>" alt="">
                            <?php //}}} ?>

                            <div>
                                <span class="bold">Catatan Konsultasi</span>
                                <span class="space">: </span><br>
                                <span><?= isset($val->catatan_konsultasi)?$val->catatan_konsultasi:''; ?></span>
                            </div>
                            <br>
                            <hr>
                            <?php } ?>
                        </div>
                </div>
                        <?php
                    } }
                    ?>
            
            </div>
           
            <div class="ttd">
                <div id="childttd">
                <span>Dokter</span>
                   
                    <img width="120px" src="<?= (isset($rawat_jalan[0]->ttd)?$rawat_jalan[0]->ttd:''); ?>" alt="">
                    <span>(<?= (isset($rawat_jalan[0]->dokter)?$rawat_jalan[0]->dokter:'.....................'); ?>)</span><br>
                    <span>No.SIP <?= (isset($nip_dokter->nipeg)?$nip_dokter->nipeg:'.....................'); ?></span><br>
                    <span>Nama Jelas & Tanda Tangan</span>
                </div><br><br><br><br><br><br>
               
            </div>
            <br><br><br><br>
            <p style="text-align:left;font-size:12px">Hal 5 dari 5</p>
            
                </div>
            </div>
</body>
</html>