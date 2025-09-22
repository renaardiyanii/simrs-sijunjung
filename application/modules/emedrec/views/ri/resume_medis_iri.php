<?php 
    $json = json_decode($ttf->formjson,true);
// $fisik = isset($pemeriksaan_fisik_ri->td)?'Tekanan darah :'.$pemeriksaan_fisik_ri->td.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->bb)?'Berat Badan :'.$pemeriksaan_fisik_ri->bb.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->nadi)?'Nadi :'.$pemeriksaan_fisik_ri->nadi.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->frekuensi_nafas)?'Frekuensi Nafas :'.$pemeriksaan_fisik_ri->frekuensi_nafas.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->suhu)?'Suhu :'.$pemeriksaan_fisik_ri->suhu.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->lingkar_kepala)?'Lingkar Kepala :'.$pemeriksaan_fisik_ri->lingkar_kepala.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->keadaan_umum_pasien)?'Keadaan Umum :'.$pemeriksaan_fisik_ri->keadaan_umum_pasien.'<br>':'';
// $fisik .= isset($pemeriksaan_fisik_ri->kesadaran_pasien)?'Kesadaran Pasien :'.$pemeriksaan_fisik_ri->kesadaran_pasien.'<br>':'';

//   echo count($radiologi);
//  var_dump($pasien);
//   var_dump($obat);
// var_dump($obat[1]->nama_obat);
// count($obat);
// var_dump($pemeriksaan_fisik_ri);
?>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   <style>
       #div1 {
           position: relative;
       }
   
       .header-parent {
           display: flex;
           justify-content: space-between;
   
       }
   
       .right {
           display: flex;
           align-items: flex-end;
           flex-direction: column;
           /* font-size: 12px; */
       }
       .text_body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       .text_isi{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
        font-weight: bold;
       }
       .text_judul{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
       }   
       .patient-info {
           border: 1px solid black;
           padding: 1em;
           display: flex;
           border-radius: 10px;
       }
   
       #date {
           display: flex;
           justify-content: space-between;
       }
   
       .nomr {
           font-weight: bold;
           display: inline;
   
       }
       .margin-left-3px{
           margin-left:3px;
       }

       .margin-right-3px{
           margin-right:3px;
       }
   
       .kotak {
           float: left;
           text-align:center;
           /* margin-top:10px; */
           width: 20px;
           height: 25px;
           /* margin-left:px; */

           border: 1px solid black;
       }

       .tanpa-kotak {
           border: 1px solid black;
           padding: 5px;
       }
       .kotakin {
           /* border: 1px solid black; */
           padding: 5px;
       }
       
       .judul {
           font-weight: bold;
           /* border: 1px solid black; */
           /* width: 400px; */
           /* height: 50px; */
           padding:0px 10px;
           font-size: 12px;
           text-align: center;
           
       }
   
       .content {
           border: 1px solid black;
           padding-left: 15px;
           padding-top: 15px;
           padding-bottom: 15px;
           /* font-size: 6pt!important; */
       }
   
       .ttd {
           display: flex;
           flex-direction: column;
           justify-content: center;
           align-items: flex-end;
           margin-right: 50px;
           font-size: 11px;
       }
   
       #childttd {
           display: flex;
           flex-direction: column;
           align-items: center;
           /* font-size: 11px; */
       }
       .center{
           width:100%;
           margin:auto;
           text-align: center;
           /* background-color: aquamarine; */
       }
       td {line-height: 1.5; vertical-align:top;font-size:small;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       .table tr td{
           font-size:8.5pt!important;
       }
       .hr{
           height:2px;
           background-color:black;
       }
       .row{
           display:flex;
       }
       .row .text-body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11pt;
       }
       table{
        border-collapse: collapse;
       }
   </style>
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
                <!-- <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                            <p align="center">
                            <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                            </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                            <font style="font-size:8pt!important">
                                <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                            </font>
                            <font style="font-size:8pt">
                                <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                            </font>    
                            <br>
                            <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                            <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                            </td>
                            <td width="13%">
                            <p align="center">
                                <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                            </p>
                            </td>
                    
                        </tr>
                    
                    </table>
                </header> -->

                <header style="margin-top:0px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="10%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
                                </p>
                            </td>
                            <td  width="70%"  align="left" style="font-size:31px;font-weight:bold;">
                                <p style="margin-top:20px">
                                    <span>RS. OTAK DR. Drs. M.HATTA</span><br>
                                    <span> BUKITTINGGI</span><br>
                                </p>
                            </td>
                            <td width="20%">
                                <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px"><?= isset($kode_document)?$kode_document!=""?$kode_document->result()[0]->kode_rm:"":""; ?></span>

                                <table class="table_nama" width="100%">
                                        <tr>
                                        </tr>
                                    <?php
                                    // foreach ($data_pasien as $row) {
                                    ?>
                                        <tr>
                                            <td width="33%"  style="font-size:20px"><span>Nama</span></td>
                                            <td width="2%"  style="font-size:20px"><span>:</span></td>
                                            <td width="45%"  style="font-size:20px"><span><?php echo $data_pasien[0]->nama??""; ?></span></td>
                                            <td width="20%"  style="font-size:20px"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:20px"><span>NIK</span></td>
                                            <td style="font-size:20px"><span>:</span></td>
                                            <td style="font-size:20px"><span><?php echo $data_pasien[0]->no_identitas??""; ?></span></td>
                                            <td style="font-size:20px"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:20px"><span>No. RM</span></td>
                                            <td style="font-size:20px"><span>:</span></td>
                                            <td style="font-size:20px"><span><?php echo $data_pasien[0]->no_cm??""; ?></span></td>
                                            <td style="font-size:20px"><span>(<?php echo $data_pasien[0]->sex??""; ?>)</span></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:20px"><span>Tgl Lahir</span></td>
                                            <td style="font-size:20px"><span>:</span></td>
                                            <td style="font-size:20px"><span><?php echo date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir))??"";//substr($data_pasien[0]->tgl_lahir,0,10); ?></span></td>
                                            <td style="font-size:20px"><span>
                                                <barcode code="<?= $data_pasien[0]->no_cm; ?>" type="EAN13" height="0.5" />
                                            </span></td>
                                        </tr>
                                    <?php
                                    // }
                                    ?>
                                </table> 
                            </td>
                        </tr>                
                    </table>
                </header><br>

                <div class="hr">
                </div>
                <p align="center" class="text_judul" style="font-weight:bold;">RESUME MEDIS PASIEN PULANG</p>

                
                <table border="1" width="100%">
                    <tr>
                        <td width="60%">Tanggal Masuk: <?php echo isset($pasien->tgl_masuk)?$pasien->tgl_masuk:'';?></td>
                        <td width="40%">Tanggal Keluar: <?php echo isset($pasien->tgl_keluar_resume)?$pasien->tgl_keluar_resume:'';?></td>
                    </tr>
                    <tr>
                        <td width="60%">Diagnosis/Alasan Waktu Masuk:<?php echo isset($pasien->nm_diagmasuk)?$pasien->nm_diagmasuk:'';?></td>
                        <td width="40%">Ruang Rawat: <br><?php echo isset($pasien->nmruang)?$pasien->nmruang:'';?></td>
                    </tr>
                </table>

                <table border="0" width="100%" >
                    <tr >
                        <td width="5%"><p> 1.</p></td>
                        <td width="95%"><p>Riwayat Penyakit:</p></td>
                    </tr>
                </table>
                <!--START FOREACH NOTE IRI-->

                <div class="row" style="min-height:80px;">
                    <div style="margin-right:40px"><span class="text-body"></span></div>
                    <span class="text_isi"><p style="font-size:12px;margin-left:15px"><?php echo isset($riwayat_penyakit['riwayat_kesehatan'])?$riwayat_penyakit['riwayat_kesehatan']:'' ?></p></span>
                </div>

                

                <table border="0" width="100%">
                    <tr>
                        <td width="5%"><p>2.</p></td>
                        <td width="95%"><p>Pemeriksaan Fisik</p></td>
                    </tr>
                </table>
                <div class="row" style="min-height:120px;">
                    <div style="margin-right:40px"><span class="text-body"></span></div>
                    <pre style="font-size:12px;margin-left:15px"><?php echo isset($fisik)?$fisik:'' ?></pre>
                </div>
                <!--END FOREACH NOTE IRI-->
                
                <table border="0" width="100%">
                    <tr>
                        <td width="5%">3.</td>
                        <td width="95%">Penemuan Klinik (Lab, Ro, Ct Scan, MRI):</td>
                    </tr>
                </table>
                <div class="row" style="min-height:150px;">
                    <div style="margin-right:40px"><span class="text-body"></span></div>
                    <p  style="font-size:12px;margin-left:15px">
                               <b><?php echo'Penunjang Rawat Inap' ?></b><br>

                                <?php   
                                    $jml_rad = isset($radiologi)?count($radiologi):'';
                                    for ($x = 0; $x < $jml_rad; $x++) {
                                ?>
                                    <?= isset($radiologi[$x]->jenis_tindakan)?'Radiologi :'.$radiologi[$x]->jenis_tindakan:''; ?><br>
                                <?php } ?>

                                <?php   
                                    $jml_em = isset($elektro)?count($elektro):'';
                                    for ($x = 0; $x < $jml_em; $x++) {
                                ?>
                                    <?= isset($elektro[$x]->jenis_tindakan)?'Elektromedik :'.$elektro[$x]->jenis_tindakan:''; ?><br>
                                <?php } ?>

                                <?php   
                                    $jml_lab = isset($labor)?count($labor):'';
                                    for ($x = 0; $x < $jml_lab; $x++) {
                                ?>
                                    <?= isset($labor[$x]->jenis_tindakan)?'Laboratorium :'.$labor[$x]->jenis_tindakan:''; ?><br>
                                    <?php   
                                        $jml_hasil_lab = isset($hasil_lab)?count($hasil_lab):'';
                                        for ($y = 0; $y < $jml_hasil_lab; $y++) {
                                            if ($labor[$x]->id_tindakan == $hasil_lab[$y]->id_tindakan) {                                                                                    
                                    ?>
                                        <?= isset($hasil_lab[$y])?
                                            ' • Jenis Hasil : '.$hasil_lab[$y]->jenis_hasil.' Hasil : '.$hasil_lab[$y]->hasil_lab.' Kadar Normal : '.$hasil_lab[$y]->kadar_normal.$hasil_lab[$y]->satuan
                                        :''; ?><br>
                                    <?php } 
                                        } ?>
                                <?php } ?>

                                

                                <b><?php echo'Penunjang IGD' ?></b><br>

                                <?php if($id_poli == 'BA00'){ ?>
                                    <?php   
                                        $jml_rad_igd = isset($radiologi_igd)?count($radiologi_igd):'';
                                        for ($x = 0; $x < $jml_rad_igd; $x++) {
                                    ?>
                                        <?= isset($radiologi_igd[$x]->jenis_tindakan)?'Radiologi :'.$radiologi_igd[$x]->jenis_tindakan:''; ?><br>
                                    <?php } ?>

                                    <?php   
                                        $jml_em_igd = isset($elektro_igd)?count($elektro_igd):'';
                                        for ($x = 0; $x < $jml_em_igd; $x++) {
                                    ?>
                                        <?= isset($elektro_igd[$x]->jenis_tindakan)?'Elektromedik :'.$elektro_igd[$x]->jenis_tindakan:''; ?><br>
                                    <?php } ?>

                                    <?php   
                                        $jml_lab_igd = isset($labor_igd)?count($labor_igd):'';
                                        for ($x = 0; $x < $jml_lab_igd; $x++) {
                                    ?>
                                        <?= isset($labor_igd[$x]->jenis_tindakan)?'Laboratorium :'.$labor_igd[$x]->jenis_tindakan:''; ?><br>
                                        <?php   
                                            $jml_hasil_lab_igd = isset($hasil_lab_igd)?count($hasil_lab_igd):'';
                                            for ($y = 0; $y < $jml_hasil_lab_igd; $y++) {
                                                if ($labor_igd[$x]->id_tindakan == $hasil_lab_igd[$y]->id_tindakan) {                                                                                    
                                        ?>
                                            <?= isset($hasil_lab_igd[$y])?
                                                ' • Jenis Hasil : '.$hasil_lab_igd[$y]->jenis_hasil.' Hasil : '.$hasil_lab_igd[$y]->hasil_lab.' Kadar Normal : '.$hasil_lab_igd[$y]->kadar_normal.$hasil_lab_igd[$y]->satuan
                                            :''; ?><br>
                                        <?php } 
                                            } ?>
                                    <?php } ?>
                                    
                                <?php }else{} ?>    

                                
                    </p>
                </div>
                
                <table border="0" width="100%">
                    <tr>
                        <td width="5%">4. </td>
                        <td width="60%">Diagnosa Utama : <?= isset($diagnosa_utama[0]->diagnosa)?$diagnosa_utama[0]->diagnosa:''; ?></td>
                        <td width="35%">ICD 10 : <?= isset($diagnosa_utama[0]->id_diagnosa)?$diagnosa_utama[0]->id_diagnosa:''; ?></td>
                    </tr>
                    <?php   
                                    $jml_diag = isset($diagnosa)?count($diagnosa):'';
                                    for ($x = 0; $x < $jml_diag; $x++) {
                                ?>
                                     <tr>
                                        <td width="5%"></td>
                                        <td width="60%">Diagnosa Sekunder : <?= isset($diagnosa[$x]->diagnosa)?$diagnosa[$x]->diagnosa:''; ?></td>
                                        <td width="35%">ICD 10 : <?= isset($diagnosa[$x]->id_diagnosa)?$diagnosa[$x]->id_diagnosa:''; ?></td>
                                    </tr>
                                <?php } ?>
                   
                    
                </table><br>

                <table border="0" width="100%">
                    <tr>
                        <td width="5%">5. </td>
                        <td width="60%">Tindakan/Prosedur/Operasi </td>
                    </tr>
                    <?php   
                                    $jml_tind = isset($tindakan)?count($tindakan):'';
                                    for ($x = 0; $x < $jml_tind; $x++) {
                                ?>
                                     <tr>
                                        <td width="5%"></td>
                                        <td width="60%"> <?= isset($tindakan[$x]->nm_procedure)?$tindakan[$x]->nm_procedure:''?></td>
                                        <td width="35%">ICD 9 CM : <?= isset($tindakan[$x]->id_procedure)?$tindakan[$x]->id_procedure:'' ?></td>
                                    </tr>
                                <?php } ?>
                   
            
                </table>

            
                <table border="0" width="100%">
                    <tr>
                        <td width="5%"><p>6.</p> </td>
                        <td width="95%"><p>Terapi/Pengobatan Selama Perawatan</p></td>
                    </tr>
                </table>
                <div style="min-height:10%;">
                <?php   
                        $jml_all_obat = isset($obat_all)?count($obat_all):'';
                        for ($x = 0; $x <  $jml_all_obat; $x++) {
                    ?>
                    <p style="font-size:12px;margin-left:15px;left: 15px;">
                        <?= isset($obat_all[$x]->nama_obat)?$obat_all[$x]->nama_obat:'' ?> (<?= isset($obat_all[$x]->signa)?$obat_all[$x]->signa:'' ?>)
                    </p> 
                <?php } ?>
                   
                    
                    
                </div>
                    

                <table border="0" width="100%">
                    <tr>
                        <td width="5%"><p>7.</p></td>
                        <td width="95%"><p>Kondisi Saat Pulang :</p> <br>
                            <input type="checkbox" class="text-body" value="perbaikan" <?php echo ($pasien->status_pulang=='PERBAIKAN' ? 'checked="" ' : 'disabled=""') ?>><label class="text-body" for="perbaikan">Perbaikan</label>
                            <input type="checkbox" class="text-body" value="sembuh" <?php echo ($pasien->status_pulang=='PULANG' ? 'checked="" ' : 'disabled=""') ?>><label class="text-body" for="sembuh">Sembuh</label>
                            <input type="checkbox" class="text-body" value="blm_sembuh" <?php echo ($pasien->status_pulang=='BELUM_SEMBUH' ? 'checked="" ' : 'disabled=""') ?>><label class="text-body" for="blm_sembuh">Belum Sembuh</label>
                            <input type="checkbox" class="text-body" value="meninggal_krg_48" <?php echo ($pasien->status_pulang=='MENINGGALKRG48' ? 'checked="" ' : 'disabled=""') ?>><label class="text-body" for="meniggal_krg_48">Meninggal<48Jam</label>
                            <input type="checkbox" class="text-body" value="meninggal_lbh_48" <?php echo ($pasien->status_pulang=='MENINGGALLBH48' ? 'checked="" ' : 'disabled=""') ?>><label class="text-body" for="meniggal_lbh_48">Meninggal>=48Jam</label>
                        </td>
                    </tr>
                </table><br>

                <table border="0" width="100%">
                    <tr>
                        <td width="5%"><p>8</p></td>
                        <td width="95%"><p>Cara Pulang :</p><br>
                            <input type="checkbox" class="text-body" value="izin_dktr" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "izin_dokter" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="izin_dktr">Izin Dokter</label>
                            <input type="checkbox" class="text-body" value="rujuk" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "rujuk" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="rujuk">Rujuk</label>
                            <input type="checkbox" class="text-body" value="aps" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "aps" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="aps">APS</label>
                            <input type="checkbox" class="text-body" value="pindah" <?php echo isset($pasien->cara_pulang)? $pasien->cara_pulang == "pindah_rs" ? 'checked=""':'disabled=""':'' ?>><label class="text-body" for="pindah">Pindah RS</label>
                    </td>
                    </tr>
                </table><br>
                <table border="0" width="100%">
                    <tr>
                        <td width="5%"><p>9.</p></td>
                        <td width="95%"><p>Anjuran/Rencana/Kontrol</p></td>
                    </tr>
                    <tr>
                        <td width="5%"></td>
                        <td width="95%">Selanjutnya: <?php echo isset($pasien->anjuran)?$pasien->anjuran:'';?></td>
                    </tr>
                </table>
                
                <table border="0" width="100%">
                    <tr>
                        <td width="5%">10.</td>
                        <td width="95%">Terapi Pulang:</td>
                    </tr>
                </table>
                <div style="min-height:60%">
                <table border="1" width="100%" >
                    <tr height="10px">
                        <td width="10%">Nama Obat</td>
                        <td width="10%">Keterangan</td>
                    </tr>
                
                    <?php   
                                    $jml_array = isset($obat)?count($obat):'';
                                    for ($x = 0; $x < $jml_array; $x++) {
                                ?>
                                    <tr>
                                        
                                        <td><?= isset($obat[$x]->nama_obat)?$obat[$x]->nama_obat:'' ?></td>
                                        <td><?= isset($obat[$x]->signa)?$obat[$x]->signa:'' ?></td>
                                    </tr>
                                <?php } ?>
                    
                </table>
                </div>
               <br><br>

                <table border="0" width="100%">
                    <tr>
                        <td width="60%"></td>
                        <td width="40%">Bukittinggi, <?php echo isset($pasien->tgl_keluar)?$pasien->tgl_keluar:'';?></td>
                    <tr>
                    <tr>
                        <td width="60%">Pasien/Keluarga</td>
                        <td width="40%">Dokter Penanggung Jawab Pelayanan</td>
                    <tr>
                    <tr height="80px">
                        <td width="60%">
                            <?php
                               
                               if(isset($json['ttd_1']) != null){
                           ?>
                               <img width="120px" src="<?= $json['ttd_1'] ?>" alt="ttd">
                           <?php }else{} ?>
                        </td>
                        <td width="40%">
                            <?php
                            if($pasien->ttd_dpjp != null){
                            ?>
                                <img width="120px" src="<?= $pasien->ttd_dpjp ?>" alt="ttd">
                            <?php }else{
                            } ?>
                        </td>
                    <tr>
                    <tr>
                        <td width="60%">(<span class="text_isi"><?php echo isset($json['penanggung_jawab_pasien']['nama'])?$json['penanggung_jawab_pasien']['nama']:'';?>)</td>
                        <td width="40%">( <span class="text_isi"><?php echo isset($pasien->dokter)?$pasien->dokter:'';?>)</td>
                    <tr>
                    <tr>
                        <td width="60%">Nama jelas & tanda tangan</td>
                        <td width="40%">SIP. <?= isset($sip_dokter->nipeg)?$sip_dokter->nipeg:'' ?></td>
                    <tr>
                </table>
               
        </div>   <!--END FOREACH PASIEN-->


    </body> 

   
   
   </html>
   
   