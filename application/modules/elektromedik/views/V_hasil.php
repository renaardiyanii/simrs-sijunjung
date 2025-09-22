<?php 

if ($kode_jenis == 'MF') {
    $json = json_decode($mf_hasil, TRUE);
}elseif($kode_jenis == 'MB'){
    $json = json_decode($mb_hasil, TRUE);
}elseif($kode_jenis == 'MC'){
    $json = json_decode($mc_hasil, TRUE);
}elseif($kode_jenis == 'MD'){
    $json = json_decode($md_hasil, TRUE);
}elseif($kode_jenis == 'MA'){
    $json = json_decode($ma_hasil, TRUE);
}elseif($kode_jenis == 'ME'){
    $json = json_decode($me_hasil, TRUE);
}else{
    $json = '';
}    



?>
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<head>
    <title></title>
</head>
<style>

.paragraf2 { max-width: 60px;
        background-color: pink;
        overflow: auto;}
.grid-container {
  width:100%;
}
.item2 {
  width:45%;
  float:left;
}
.item3 {
  width:45%;
  float:right;
}
</style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4" >
    <div class="A4 sheet  padding-fix-10mm"><br>
        <table style="width: 100%;" border="0">
            <tr>
                <td width="13%">
                    <p align="center">
                        <img src="<?= base_url('assets/img/').$logo_kesehatan_header; ?>" alt="img" height="60" style="padding-right:5px;">
                    </p>
                </td>
                <td  width="74%" style="font-size:9px;" align="center">
                    <font style="font-size:12px">
                        <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                    </font>
                    <font style="font-size:11px">
                        <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                        <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                    </font>    
                    <br>
                    <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                    <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                </td>
                <td width="13%">
                    <p align="center">
                        <img src="<?= base_url('assets/img/').$logo_header; ?>" alt="img" height="60" style="padding-right:5px;">
                    </p>
                </td>
            </tr>
        </table>

        <hr color="black">
        <?php if ($kode_jenis == 'MF') { ?>
            <h4 align="center"><b>
                EMG-Report
            </b></h4>
            <p align="right" style="font-size: 13px;"><?php echo $kota_header.','.$tgl ?></p>
            <br/>
           
            <table style="width: 100%;">
                <tr>
                    <td style="width: 20%; font-size: 13px;"><p>Nama Pasien</p></td>
                    <td style="width: 80%; font-size: 13px;"><p> : <?= $data_pasien->nama ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Medical Record</p></td>
                    <td style="font-size: 13px;"><p> : <?= $no_em ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Umur</p></td>
                    <td style="font-size: 13px;"><p> : <?= $umur ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Alamat</p></td>
                    <td style="font-size: 13px;"><p> : <?= $data_pasien->kotakabupaten ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Referring MD</p></td>
                    <td style="font-size: 13px;"><p> : <?= $nama_dokter_reffering ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Reading MD</p></td>
                    <td style="font-size: 13px;"><p> : <?= $nama_dokter_reading ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Data</p></td>
                    <td style="font-size: 13px;"><p> : <?php echo $json['mf_data']; ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;"><p>Kesan</p></td>
                    <td style="font-size: 13px;"><p> : <?php echo $json['mf_kesan']; ?></p></td>
                </tr>
                <tr>
                    <td style="font-size: 13px;color:#525c95;"><p>Kesimpulan</p></td>
                    <td style="font-size: 13px;color:#525c95;"><p> : <?php echo $json['mf_kesimpulan']; ?></p></td>
                </tr>
            </table>

        <?php }elseif($kode_jenis == 'MB'){ ?>
            <h3 align="center"><b>
                EEG-REPORT
            </b></h3>
            <h3 align="center"><b>
                PATIENT INFORMATION
            </b></h3>
            <br/>
           
            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%;line-height: 1;"><p>Patient</p></td>
                    <td style="width: 75%;line-height: 1;"><p> : <?= $data_pasien->nama ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Date of birth</p></td>
                    <td style="line-height: 1;"><p> : <?= date('d F Y',strtotime($data_pasien->tgl_lahir)); ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>EEG-Recording</p></td>
                    <td style="line-height: 1;"><p> : <?= $no_em ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Date of Recording</p></td>
                    <td style="line-height: 1;"><p> : <?= date('d F Y',strtotime($data_pasien->tgl_kunjungan)); ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Alamat</p></td>
                    <td style="line-height: 1;"><p> : <?= $data_pasien->kotakabupaten ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Referring MD</p></td>
                    <td style="line-height: 1;"><p> : <?= $nama_dokter_reffering ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Reading MD</p></td>
                    <td style="line-height: 1;"><p> : <?= $nama_dokter_reading ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Previous EEG</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $json['mb_pre_eeg']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>History</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $json['mb_history']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>HV Effort</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $json['mb_hve']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Photic Diving Response</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $json['mb_pdr']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Tech Comments</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $json['mb_tech_comment']; ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Technologist</p></td>
                    <td style="line-height: 1;"><p> : <?php echo $json['mb_technologist']; ?> </p></td>
                </tr>
            </table>

            <h3 align="center"><b>
                INTERPRETATION
            </b></h3>
            <!-- <p style="line-height: 1;color:#525c95;"><?php echo $json['mb_interpretation']; ?></p>
            <p style="line-height: 1;color:#525c95;">KESAN : <?php echo $json['mb_kesan']; ?></p> -->

            <table style="width: 100%;">
                <tr>
                    <td style="width: 25%;line-height: 1;"><p>Physician Signature</p></td>
                    <td style="width: 75%;line-height: 1;"><p> : <?= $nama_dokter_reading ?></p></td>
                </tr>
                <tr>
                    <td style="line-height: 1;"><p>Date Dictated</p></td>
                    <td style="line-height: 1;"><p> : <?= $data_pemeriksaan->tanggal_isi ?></p></td>
                </tr>
            </table>

        <?php }elseif($kode_jenis == 'MC'){ ?>
            <table style="width: 100%;">
                <tr>
                    <td align="left" style="width: 50%;line-height: 1;"><b><p>Patient : <?= $data_pasien->nama?></p></b></td>
                    <td align="right" style="width: 50%;line-height: 1;"><b><p>Referred by : <?= $nama_dokter_reffering ?></p></b></td>
                </tr>
                <tr>
                    <td align="left" style="line-height: 1;"><b><p>Examinated by : <?= $nama_dokter_reading ?></p></b></td>
                    <td align="right" style="line-height: 1;"><p> <?= $data_pemeriksaan->tgl_kunjungan ?></p></td>
                </tr>
                <tr>
                    <td align="left" colspan="2" style="line-height: 1;"><p>Protocol name : <?= $data_pemeriksaan->jenis_tindakan ?></p></td>
                </tr>
            </table>
            
                <p>Deskripsi : </p>
                <p style="line-height: 1;margin-left: 15px;"><?php echo $json['mc_deskripsi']; ?></p>
            
                <p>Note : </p>
                <p style="line-height: 1;margin-left: 15px;"><?php echo $json['mc_note']; ?></p>
            
                <p>Kesimpulan : </p>
                <p style="line-height: 1;margin-left: 15px;"><?php echo $json['mc_kesimpulan']; ?></p>
            
        <?php }elseif($kode_jenis == 'MD'){ ?>
            <h3 align="center"><b>
                PEMERIKSAAN ECHOCARDIOGRAPHY
            </b></h3>
            
            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td colspan="2"><b>IDENTIFICATION</b></td>
                </tr>
                <tr>
                    <td style="width: 25%;">Name</td>
                    <td style="width: 40%;"><?= $data_pasien->nama ?></td>
                    <td style="width: 35%;">Poliklinik : <?= $nama_poli ?></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><?= $umur ?></td>
                    <td>Jaminan : <?= $kontraktor ?></td>
                </tr>
                <tr>
                    <td>Medical Record No.</td>
                    <td><?= $no_em ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>No Echo Video</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Date of Investigation</td>
                    <td><?= date('d F Y',strtotime($data_pemeriksaan->tgl_kunjungan)) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td>CLINICAL DIAGNOSIS</td>
                    <td><?= $diagnosa ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td colspan="4"><b>MEASUREMENTS</b></td>
                </tr>
                <tr>
                    <td style="width: 25%;">Aorta</td>
                    <td style="width: 25%;"> <?php echo $json['md_aorta']; ?></td>
                    <td style="width: 25%;">LV EDD</td>
                    <td style="width: 25%;"> <?php echo $json['md_lv_edd']; ?></td>
                </tr>
                <tr>
                    <td>Left Atrium</td>
                    <td> <?php echo $json['md_left_atrium']; ?></td>
                    <td>LV ESD</td>
                    <td> <?php echo $json['md_lv_esd']; ?></td>
                </tr>
                <tr>
                    <td>Ejection Fraction</td>
                    <td> <?php echo $json['md_ejection_fraction']; ?></td>
                    <td>IVSD</td>
                    <td> <?php echo $json['md_ivsd']; ?></td>
                </tr>
                <tr>
                    <td>EPSS</td>
                    <td> <?php echo $json['md_epss']; ?></td>
                    <td>IVSS</td>
                    <td> <?php echo $json['md_ivss']; ?></td>
                </tr>
                <tr>
                    <td>RV Dimension</td>
                    <td> <?php echo $json['md_rv_dimension']; ?></td>
                    <td>LVPW Diastolic</td>
                    <td> <?php echo $json['md_lvpw_diastolic']; ?></td>
                </tr>
                <tr>
                    <td>LAVI</td>
                    <td> <?php echo $json['md_lavi']; ?></td>
                    <td>TAPSE</td>
                    <td> <?php echo $json['md_tapse']; ?></td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td colspan="2"><b>DESCRIPTION</b></td>
                </tr>
                <tr>
                    <td style="width: 25%;">Dimensi Ruang Jantung</td>
                    <td style="width: 75%;"> <?php echo $json['md_dimensi_r_jantung']; ?></td>
                </tr>
                <tr>
                    <td>LVH</td>
                    <td> <?php echo $json['md_lvh']; ?></td>
                </tr>
                <tr>
                    <td>Kontaraktilitas LV</td>
                    <td> <?php echo $json['md_kontraktilitas_lv']; ?></td>
                </tr>
                <tr>
                    <td>Kontaraktilitas RV</td>
                    <td> <?php echo $json['md_kontraktilitas_rv']; ?></td>
                </tr>
                <tr>
                    <td>Analisis Segmental</td>
                    <td> <?php echo $json['md_analisis_segmental']; ?></td>
                </tr>
                <tr>
                    <td>K. Aorta</td>
                    <td> <?php echo $json['md_k_aorta']; ?></td>
                </tr>
                <tr>
                    <td>K. Mitral</td>
                    <td> <?php echo $json['md_k_mitral']; ?></td>
                </tr>
                <tr>
                    <td>K. Trikuspid</td>
                    <td> <?php echo $json['md_k_trikuspid']; ?></td>
                </tr>
                <tr>
                    <td>K. Pulmonal</td>
                    <td> <?php echo $json['md_k_pulmonal']; ?></td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td rowspan="2">Doppler</td>
                    <td>E/A : <?php echo $json['md_dop_ea']; ?></td>
                    <td>DT : <?php echo $json['md_dop_dt']; ?></td>
                    <td>E/e : <?php echo $json['md_dop_ee']; ?></td>
                </tr>
                <tr>
                    <td>Ao Vmax : <?php echo $json['md_dop_ao_vmax']; ?></td>
                    <td>MPAP : <?php echo $json['md_dop_mpap']; ?></td>
                    <td> <?php echo $json['md_dop']; ?></td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td>Other :  <?php echo $json['md_other']; ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>

            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;">
                <tr>
                    <td><b>CONCLUSION</b></td>
                </tr>
                <tr>
                    <td>
                        <ul>
                            <li>Dimensi Ruang Jantung <u><?php echo $json['md_dimensi_r_jantung']; ?></u></li>
                            <li>Kontaraktilitas LV  <u><?php echo $json['md_kontraktilitas_lv']; ?></u></li>
                            <li>Normakinetik Global  <u><?php echo $json['md_normakinetik_global']; ?></u></li>
                            <li>Katup - katup struktur dan fungsi  <u><?php echo $json['md_katup_struk_func']; ?></u></li>
                            <li>Droppler E/A  <u><?php echo $json['md_dop_ea']; ?></u></li>
                            <li>Regugitasi  <u><?php echo $json['md_regugitasi']; ?></u></li>
                        </ul>
                        Final Conclusion :  <?php echo $json['md_final_conclusion']; ?>
                    </td>
                </tr>
            </table>

        <?php }elseif($kode_jenis == 'MA'){ ?>
            <h3 align="center"><b>
                INSTALASI RAWAT JALAN
            </b></h3>
            <h3 align="center"><b>
                UDT
            </b></h3>
            <h3 align="center"><b>
                HASIL USG
            </b></h3>
            <table border="0" width="100%">
                            <tr>
                                <td width="50%">
                                     <table border ="0" width ="100%">
                                         <tr >
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">No. RM</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"> <?php echo $data_pasien->no_cm; ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Nama</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?php echo $data_pasien->nama; ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Tgl. Lahir </td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?php echo date('d F Y',strtotime($data_pasien->tgl_lahir)) ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Jenis Kelamin</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?php echo $jenis_kelamin; ?></span></td>
                                         </tr>
                                     </table>
                                 </td>
                                 <td width="50%">
                                     <table border ="0" width ="100%">
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Rujukan</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?= $nama_poli ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Tgl. Periksa</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?= date('d F Y',strtotime($data_pemeriksaan->tgl_kunjungan)) ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Tgl. Hasil</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?= $data_pemeriksaan->tanggal_isi ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Dokter Pengirim</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?= $nama_dokter_reffering ?></span></td>
                                         </tr>
                                     </table>
                                 </td>
                            </tr>
            </table>
            <p>Klinis :  <?php echo $diagnosa; ?></p>

            <p>
                <span>TS Yth</span><br>
                <span>Pemeriksaan Ultrasonografi Abdomen atas dengan transduser kurve.</span>
            </p>

            <p style="margin-left: 20px;">
                <?php echo $json['ma_isi']; ?> 
            </p>

            Kesan : 
            
            <p style="margin-left: 20px;">
                <?php echo $json['ma_kesan']; ?> 
            </p> 
                    
                
            
            <table border="0" width="100%">
                    <tr>
                        <td>
                            <br>
                            <table border="0" width="100%">
                                <tr>
                                    <td width="70%">
                                    </td>

                                    <td> <center><span class="text_body">Bukittinggi,<?= date('d F Y',strtotime($data_pemeriksaan->tgl_kunjungan)) ?></span></span></center>
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <br>
                            <br>
                            <table border="0" width="100%">
                                <tr>
                                    <td width="70%">
                                    </td>

                                    <td>
                                        <img width="120px" src="<?= $data_pemeriksaan->ttd ?>" alt="">
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <table border="0" width="100%">
                                <tr>
                                    <td width="70%">
                                    </td>

                                    <td> <center><span class="text_body"> <?= $nama_dokter_reading ?></span></center>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
            </table>

        <?php }elseif($kode_jenis == 'ME'){ ?>
            <center><h3>CAROTID ULTRASOUND</h3></center>
            <table border="1" width="100%">
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Nama</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                     <span class="text_isi"> <?= $data_pasien->nama ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Alamat</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                     <span class="text_isi"><?= $data_pasien->kotakabupaten ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Tanggal</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                 <span class="text_isi"><?= date('d F Y',strtotime($data_pemeriksaan->tgl_kunjungan)) ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Diagnosis</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                 <span class="text_isi"><?= $diagnosa ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Faktor Resiko</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                 <span class="text_isi"><?= $json['me_faktor_resiko'] ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Dokter Pengirim</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                 <span class="text_isi"><?= $nama_dokter_reading ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>  
         </table>
         <h3>DESKRIPSI</h3>

         <div class="grid-container">

         <div class="item2">
            <p>Left</p>
            <table width= "100%" style="text-align:center;font-size:12px" border=1>
                <tr>
                    <th  width= "40%">Segment</th>
                    <th  width= "30%">PSV</th>
                    <th  width= "30%">EDV</th>
                </tr>
                <tr>
                    <td  width= "40%">CCA</td>
                    <td  width= "30%"><?= $json['me_l_cca_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_l_cca_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">Bulb</td>
                    <td  width= "30%"><?= $json['me_l_bulb_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_l_bulb_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">ICA</td>
                    <td  width= "30%"><?= $json['me_l_ica_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_l_ica_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">ECA</td>
                    <td  width= "30%"><?= $json['me_l_eca_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_l_eca_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">ICA:CCA</td>
                    <td  width= "30%" colspan="2"><?= $json['me_l_ica_eca_psv_edv'] ?> </td>
                </tr>
                <tr>
                    <td  width= "40%">Vertebral</td>
                    <td  width= "30%"><?= $json['me_l_veterbal_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_l_veterbal_edv'] ?></td>
                </tr>

            </table>
         
         </div>
         <div class="item3">
         <p>Right</p>
         <table width= "100%" style="text-align:center;font-size:12px" border=1>
         <tr>
                    <th  width= "40%">Segment</th>
                    <th  width= "30%">PSV</th>
                    <th  width= "30%">EDV</th>
                </tr>
                <tr>
                    <td  width= "40%">CCA</td>
                    <td  width= "30%"><?= $json['me_r_cca_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_r_cca_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">Bulb</td>
                    <td  width= "30%"><?= $json['me_r_bulb_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_r_bulb_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">ICA</td>
                    <td  width= "30%"><?= $json['me_r_ica_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_r_ica_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">ECA</td>
                    <td  width= "30%"><?= $json['me_r_eca_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_r_eca_edv'] ?></td>
                </tr>
                <tr>
                    <td  width= "40%">ICA:CCA</td>
                    <td  width= "30%" colspan="2"><?= $json['me_r_ica_eca_psv_edv'] ?> </td>
                </tr>
                <tr>
                    <td  width= "40%">Vertebral</td>
                    <td  width= "30%"><?= $json['me_r_veterbal_psv'] ?></td>
                    <td  width= "30%"><?= $json['me_r_veterbal_edv'] ?></td>
                </tr>
            </table>
         </div>  
            </div>

            <p>
                Kesimpulan :
            </p>
            <p style="margin-left: 15px;">
                <?= $json['me_kesimpulan'] ?>
            </p>

        <?php }else{ ?>

            <header style="margin-top:20px; font-size:1pt!important;">
            <table border="0" width="100%">
                <tr>                    
                        <td>
                            <table class="table_nama" width="100%" cellspacing="1" cellpadding="0">
                                    <tr>
                                        <td width="20%"><span class="text_body">Nama</span></td>
                                        <td width="5%"><span class="text_body">:</span></td>
                                        <td width="75%"><span class="text_isi"><?php echo $data_pasien->nama; ?></span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><span class="text_body">NIK</span></td>
                                        <td width="5%"><span class="text_body">:</span></td>
                                        <td width="75%"><span class="text_isi"><?php echo $data_pasien->no_identitas; ?></span></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><span class="text_body">Jenis Kelamin</span></td>
                                        <td width="5%"><span class="text_body">:</span></td>
                                        <td width="75%"><span class="text_isi"><?php echo $jenis_kelamin; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><span class="text_body">No. RM</span></td>
                                        <td width="5%"><span class="text_body">:</span></td>
                                        <td width="75%"><span class="text_isi"><?php echo $data_pasien->no_cm; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><span class="text_body">Tanggal Lahir</span></td>
                                        <td width="5%"><span class="text_body">:</span></td>
                                        <td width="75%"><span class="text_isi"><?php echo date('d F Y',strtotime($data_pasien->tgl_lahir)) ?></span></td>
                                    </tr>
                        <?php
                            // }
                        ?>
                    </table> 
                </td>
                </tr>
            </table>
            </header>
            <br>

            <table border="1" width="100%">
                 <tr>
                     <td>
                         <table border="0" width="100%">
                            <tr>
                                <td width="50%">
                                     <table border ="0" width ="100%">
                                         <tr >
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Ruang Poli</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"> <?= $nama_poli ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Tanggal Daftar</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"><?= date('d F Y',strtotime($data_pemeriksaan->tgl_kunjungan)) ?></span></td>
                                         </tr>
                                     </table>
                                 </td>
                                 <td width="50%">
                                     <table border ="0" width ="100%">
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Tanggal Hasil</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"> <?= date('d-m-Y H:i:s', strtotime($data_pemeriksaan->tanggal_isi))  ?></span></td>
                                         </tr>
                                         <tr>
                                             <td width="2%"></td>
                                             <td width="30%"><span class="text_body">Dokter Pengirim</td>
                                             <td width="3%"><span class="text_body">:</td>
                                             <td width="65%"><span class="text_isi"> <?= $nama_dokter_reffering ?></span></td>
                                         </tr>
                                     </table>
                                 </td>
                            </tr>
                         </table>
                     </td>
                 </tr>

                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Hasil</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                     <span class="text_isi"> <?= $data_pemeriksaan->hasil ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Saran</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                     <span class="text_isi"><?= $data_pemeriksaan->saran ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">BTK</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                 <span class="text_isi"><?= $data_pemeriksaan->btk ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                 <tr>
                     <td width="100%">
                         <table border="0" width="100%">
                             <br>
                             <tr>
                                 <td width="2%"> </td>
                                 <td width="15%">
                                     <span class="text_body">Rekam Elektromedik</span>
                                 </td>
                                 <td width="2%"><span class="text_body">:</span></td>
                                 <td>
                                 <span class="text_isi"><?= $data_pemeriksaan->rekam_elektromedik ?></span>
                                 </td>
                             </tr>
                         </table>
                         <br>
                     </td>
                 </tr>
                
                 
         </table>
         
            <table border="0" width="100%">
         <tr>
             <td>
                 <br>
                 <table border="0" width="100%">
                     <tr>
                         <td width="70%">
                         </td>

                         <td> <center><span class="text_body">Yang Bertandatangan</span></center>
                         </td>
                     </tr>
                 </table>
                 <br>
                 <br>
                 <br>
                 <table border="0" width="100%">
                     <tr>
                         <td width="70%">
                         </td>

                         <td>
                            <img width="120px" src="<?= $data_pemeriksaan->ttd ?>" alt="">
                        </td>
                     </tr>
                 </table>
                 <br>
                 <table border="0" width="100%">
                     <tr>
                         <td width="70%">
                         </td>

                         <td> <center><span class="text_body"> <?= $nama_dokter_reading ?></span></center>
                         </td>
                     </tr>
                 </table>
             </td>
         </tr>
            </table>
 

        <?php } ?>   
    </div>

    <div class="A4 sheet  padding-fix-10mm"><br>
    <?php
        $gambar_hasil_em=$this->emmdaftar->get_gambar_hasil_em($data_hasil[0]->id_pemeriksaan_em)->result(); 
            foreach ($gambar_hasil_em as $gambar) { ?>
            <img src="<?php echo base_url(); ?>download/<?php echo $gambar->name; ?>" alt="img">
            <br>
        <?php } ?>
    </div>
    
</body>

</html>
   
   