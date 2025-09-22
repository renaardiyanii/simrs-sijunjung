<?php

?>
<!DOCTYPE html>
<html>

<head>
    <title>Lembar Program Terapi</title>
</head>
<!-- <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet"> -->

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<style>
.center-text{
    text-align:center;
}
</style>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <!-- <?php// $this->load->view('emedrec/header_print') ?> -->
        <?php 
        include('header_print.php');
        ?>
        <hr color="black">
        <p align="center" class="text_judul" style="font-weight:bold;">ASESMEN AWAL MEDIS <?php 
        switch($poli){
            case 'POLI UMUM':
                echo 'POLIKLINIK UMUM';
                break;
            default:
                echo $poli;
        };
         ?></p>
        <table border="0" width="100%">
                        <br>
                        <tr>
                            <td width="30%"><span class="text_sub_judul">Hari/Tanggal : <?= isset($soap_pasien_rj->tgl_input)?($soap_pasien_rj->tgl_input != null)? date("d-m-Y",strtotime($soap_pasien_rj->tgl_input)): '-':'-' ;?> </span></td>
                            <td width="20%"><span class="text_sub_judul">Jam Datang : <?= isset($soap_pasien_rj->tgl_input)?($soap_pasien_rj->tgl_input != null)? date("H:i",strtotime($soap_pasien_rj->tgl_input)): '-':'-' ;?>  WIB</span></td>
                        </tr>
                    </table>
        <table border="1" width="100%">
          
            <tr>
                <td>
                    <table border="0" width="100%">
                        <br>
                        <tr>
                            <td>
                                <span class="text_sub_judul">ANAMNESIS :</span>
                            </td>
                        </tr>
                    </table>
                    <br>

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span ><?= isset($soap_pasien_rj->subjective_dokter)? $soap_pasien_rj->subjective_dokter: '-' ;?></span>
                            </td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="80%"><span class="text_sub_judul">PEMERIKSAAN FISIK :</span></td>
                        </tr>
                    </table>

                    <?php 
                    if($poli != "POLI MATA"){

                     ?>
                    
                    <table border="0" width="100%">

                        <tr>
                            <td width="5%">
                            </td>

                            <td width="5%"><span class="text_body">TD</span></td>
                            <td width="5%"><span class="text_body">:</span></td>
                            <td width="5%"><span class="text_body"><?= isset($pemeriksaan_fisik->sitolic)? $pemeriksaan_fisik->sitolic.'/'.$pemeriksaan_fisik->diatolic: '-' ;?></span></td>
                            <td width="65%"><span class="text_body">mmg</span></td>

                        </tr>

                        <tr>
                            <td width="5%">
                            </td>
                            <td width="5%"><span class="text_body">Nadi</span></td>
                            <td width="5%"><span class="text_body">:</span></td>
                            <td width="5%"><span class="text_body"><?= isset($pemeriksaan_fisik->nadi)? $pemeriksaan_fisik->nadi: '-' ;?></span></td>
                            <td width="65%"><span class="text_body">x/i</span></td>


                        </tr>

                        <tr>
                            <td width="5%">
                            </td>
                            <td width="5%"><span class="text_body">Pernafasan</span></td>
                            <td width="5%"><span class="text_body">:</span></td>
                            <td width="5%"><span class="text_body"><?= isset($pemeriksaan_fisik->frekuensi_nafas)? $pemeriksaan_fisik->frekuensi_nafas: '-' ;?></span></td>
                            <td width="65%"><span class="text_body">x/i</span></td>

                        </tr>

                        <tr>
                            <td width="5%">
                            </td>
                            <td width="5%"><span class="text_body">Suhu</span></td>
                            <td width="5%"><span class="text_body">:</span></td>
                            <td width="15%"><span class="text_body"><?= isset($pemeriksaan_fisik->suhu)? $pemeriksaan_fisik->suhu: '-' ;?></span></td>
                            <td width="65%"><span class="text_body">°C</span></td>

                        </tr>


                    </table>
                    <?php }
                    else if($poli == 'POLI MATA'){
                        echo '<table border="0" width="100%">
                        <tr>
                            <td>
                                <span>Status Generalis</span>
                            </td>
                        </tr>
                    </table>
                <br>';
                    }?>
                        
                </td>
            </tr>
            <?php if($poli == 'POLI MATA'){ ?>
                <tr>
                <td>
                    <table border="0" width="100%">
                  
                        <tr>
                            <td>
                                <span class="text_sub_judul">STATUS OFTALMIK :</span>
                            </td>
                        </tr>
                    </table>
              

                    <table border="0" width="100%">
                        <tr>
                            <td colspan="2">
                                Visus : 
                            </td>
                            <td colspan="2">
                                Kacamata : 
                            </td>
                            
                        </tr>
                        <tr>
                            <td>OD</td>
                            <td>: <?= isset($pemeriksaan_fisik->visus_od)? $pemeriksaan_fisik->visus_od: '-' ;?></td>
                            <td>OD</td>
                            <td>: <?= isset($pemeriksaan_fisik->kacamata_od)? $pemeriksaan_fisik->kacamata_od: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>OS</td>
                            <td>: <?= isset($pemeriksaan_fisik->visus_os)? $pemeriksaan_fisik->visus_os: '-' ;?></td>
                            <td>OS</td>
                            <td>: <?= isset($pemeriksaan_fisik->kacamata_os)? $pemeriksaan_fisik->kacamata_os: '-' ;?></td>
                        </tr>

                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
              

                    <table border="1" width="100%">
                        <tr>
                            <th>
                               &nbsp; 
                            </td>
                            <th width="25%">
                                OD 
                            </th>
                            <th width="25%">OS</th>
                            
                        </tr>
                        <tr>
                            <td>KEDUDUKAN / GERAK BOLA MATA</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->kedudukan_od)? $pemeriksaan_fisik->kedudukan_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->kedudukan_os)? $pemeriksaan_fisik->kedudukan_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>CONJUNGTIVA</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->conjungtiva_od)? $pemeriksaan_fisik->conjungtiva_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->conjungtiva_os)? $pemeriksaan_fisik->conjungtiva_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>CORNEA</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->cornea_od)? $pemeriksaan_fisik->cornea_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->cornea_os)? $pemeriksaan_fisik->cornea_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>C O A</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->coa_od)? $pemeriksaan_fisik->coa_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->coa_os)? $pemeriksaan_fisik->coa_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>PUPIL / IRIS</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->pupil_od)? $pemeriksaan_fisik->pupil_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->pupil_os)? $pemeriksaan_fisik->pupil_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>LENSA</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->lensa_od)? $pemeriksaan_fisik->lensa_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->lensa_os)? $pemeriksaan_fisik->lensa_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>VITREOUS HUMOR</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->humor_od)? $pemeriksaan_fisik->humor_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->humor_os)? $pemeriksaan_fisik->humor_os: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>FUNDUS OKULI</td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->okuli_od)? $pemeriksaan_fisik->okuli_od: '-' ;?></td>
                            <td class="center-text"><?= isset($pemeriksaan_fisik->okuli_os)? $pemeriksaan_fisik->okuli_os: '-' ;?></td>
                        </tr>
                        

                    </table>
                </td>
            </tr>
                <?php } ?>
            <tr>
                <td>
                    <table border="0" width="100%">
                  
                        <tr>
                            <td>
                                <span class="text_sub_judul">DIAGNOSIS KERJA :</span>
                            </td>
                        </tr>
                    </table>
              

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span ><?= isset($soap_pasien_rj->diagnosis_kerja_dokter)?$soap_pasien_rj->diagnosis_kerja_dokter : '-' ;?></span>
                            </td>
                            
                        </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" width="100%">
                      
                        <tr>
                            <td>
                                <span class="text_sub_judul">DIAGNOSIS BANDING :</span>
                            </td>
                        </tr>
                    </table>
                    

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span ><?= isset($soap_pasien_rj->diagnosis_banding_dokter)? $soap_pasien_rj->diagnosis_banding_dokter: '-' ;?></span>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" width="100%">
                        
                        <tr>
                            <td>
                                <span class="text_sub_judul">PEMERIKSAAN PENUNJANG :</span>
                            </td>
                        </tr>
                    </table>
                    

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span><?= isset($soap_pasien_rj->pemeriksaan_penunjang_dokter)? $soap_pasien_rj->pemeriksaan_penunjang_dokter: '-' ;?></span>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" width="100%">
                        
                        <tr>
                            <td>
                                <span class="text_sub_judul">THERAPI / TINDAKAN :</span>
                            </td>
                        </tr>
                    </table>
                    

                    <table border="0" width="100%">
                        <tr>
                            <td width="5%">
                            </td>
                            <td>
                                <span><?= isset($soap_pasien_rj->terapi_tindakan_dokter)? $soap_pasien_rj->terapi_tindakan_dokter: '-' ;?></span>
                            </td>
                        </tr>
                    </table>
                    
                </td>
                
            </tr>
            <tr>
                <td>
                    <table border="0"  width="100%">
                        <tr>
                            <td>
                                <span style="font-weight:bold;">KONTROL ULANG :</span>
                            </td>
                            <td>
                                <!-- <input type="checkbox" name="kontrol_ulang" id="kontrol_ulang"> -->
                                <!-- <label for="kontrol_ulang">Kembali Kontrol</label> -->
                                <span style="display:flex;"> <?= isset($data_rawat_jalan->tgl_kontrol)?'&#10004;':'<div class="kotakkecil"></div>' ?>&nbsp; Kembali Kontrol</span>
                            </td>
                            <td>
                                <span>Hari / Tanggal</span>
                                <span>: <?= isset($data_rawat_jalan->tgl_kontrol)?$data_rawat_jalan->tgl_kontrol:'-'; ?></span>
                            </td>
                            <td>
                                <span>&nbsp; </span>
                                <span>&nbsp;</span>
                            </td>
                            
                        </tr>
                    </table>
                    

                   
                </td>
                
            </tr>

            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="75%">
                            </td>

                            <td> <span class="text_sub_judul">Tanda Tangan</span>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td width="81%"></td>
                            <td><img width="120px" src="<?= isset($data_rawat_jalan->ttd)?$data_rawat_jalan->ttd:''; ?>" alt=""></td>
                        </tr>
                    </table>
                    <table border="0" width="100%">
                        <tr>
                            <td width="65%">
                            </td>

                            <td> <span>(<?= isset($data_rawat_jalan->dokter)? $data_rawat_jalan->dokter: '' ?>)</span>
                            
                        </tr>
                        <tr>
                            <td width='65%'></td>
                            <td> <span style="font-size:12px">SIP. <?= isset($nip_dokter->nipeg)? $nip_dokter->nipeg: '' ?> </span></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
    </div>
    </td>
    </tr>



    </table>

    <footer>
    </footer>
    </div>
</body>

</html>
