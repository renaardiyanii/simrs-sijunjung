<?php
$data_formjson = isset($soap_pasien_rj->formjson)?json_decode($soap_pasien_rj->formjson):'';
//  var_dump($data_formjson);
// var_dump($nip_dokter);
// var_dump($pemeriksaan_fisik);

?>
<!DOCTYPE html>
<html>

<head>
    <title>ASESMEN AWAL MEDIS MATA</title>
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
        <p align="center" class="text_judul" style="font-weight:bold;">ASESMEN AWAL MEDIS MATA 
        </p>
        <div style="min-height:850px">
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
                                <span ><?= isset($data_formjson->anamnesis)? $data_formjson->anamnesis: '-' ;?></span>
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

                  
                    <table border="0" width="100%">
                        <tr>
                            <td>
                                <span>Status Generalis</span>
                                <p><?= isset($data_formjson->pemeriksaan_fisik)?$data_formjson->pemeriksaan_fisik:'' ?></p>
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
                            <td>: <?= isset($data_formjson->visus->od)? $data_formjson->visus->od: '-' ;?></td>
                            <td>OD</td>
                            <td>: <?= isset($data_formjson->kacamata->od)? $data_formjson->kacamata->od: '-' ;?></td>
                        </tr>
                        <tr>
                            <td>OS</td>
                            <td>: <?= isset($data_formjson->visus->os)? $data_formjson->visus->os: '-' ;?></td>
                            <td>OS</td>
                            <td>: <?= isset($data_formjson->kacamata->od)? $data_formjson->kacamata->od: '-' ;?></td>
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
                            <td>PALPEBRA</td>
                            <td class="center-text"><?php echo isset($data_formjson->question2->od->palpebra)? $data_formjson->question2->od->palpebra == "other" ? $data_formjson->question2->od->{'palpebra-Comment'}:$data_formjson->question2->od->palpebra:'-' ?></td>
                            <td class="center-text"> <?php echo isset($data_formjson->question2->os->palpebra)? $data_formjson->question2->os->palpebra == "other" ? $data_formjson->question2->os->{'palpebra-Comment'}:$data_formjson->question2->os->palpebra:'-' ?></td>
                        </tr>
                        <tr>
                            <td>CONJUNGTIVA</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->conjungtiva)? $data_formjson->question2->od->conjungtiva == "other" ? $data_formjson->question2->od->{'conjungtiva-Comment'}:$data_formjson->question2->od->conjungtiva:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->conjungtiva)?  $data_formjson->question2->os->conjungtiva== "other" ? $data_formjson->question2->os->{'conjungtiva-Comment'}:$data_formjson->question2->os->conjungtiva:'-' ?></td>
                        </tr>
                        <tr>
                            <td>CORNEA</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->cornea)? $data_formjson->question2->od->cornea == "other" ? $data_formjson->question2->od->{'cornea-Comment'}:$data_formjson->question2->od->cornea:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->cornea)?  $data_formjson->question2->os->cornea== "other" ? $data_formjson->question2->os->{'cornea-Comment'}:$data_formjson->question2->os->cornea:'-' ?></td>
                        </tr>
                        <tr>
                            <td>PUPIL / IRIS</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->pupil)? $data_formjson->question2->od->pupil == "other" ? $data_formjson->question2->od->{'pupil-Comment'}:$data_formjson->question2->od->pupil:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->pupil)? $data_formjson->question2->os->pupil== "other" ? $data_formjson->question2->os->{'pupil-Comment'}:$data_formjson->question2->os->pupil:'-' ?></td>
                        </tr>
                        <tr>
                            <td>C O A</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->coa)? $data_formjson->question2->od->coa == "other" ? $data_formjson->question2->od->{'coa-Comment'}:$data_formjson->question2->od->coa:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->coa)? $data_formjson->question2->os->coa== "other" ? $data_formjson->question2->os->{'coa-Comment'}:$data_formjson->question2->os->coa:'-' ?></td>
                        </tr>
                        <tr>
                            <td>LENSA</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->lensa)? $data_formjson->question2->od->lensa == "other" ? $data_formjson->question2->od->{'lensa-Comment'}:$data_formjson->question2->od->lensa:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->lensa)? $data_formjson->question2->os->lensa== "other" ? $data_formjson->question2->os->{'lensa-Comment'}:$data_formjson->question2->os->lensa:'-' ?></td>
                        </tr>
                        <tr>
                            <td>VITREOUS HUMOR</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->vitreous)? $data_formjson->question2->od->vitreous == "other" ? $data_formjson->question2->od->{'vitreous-Comment'}:$data_formjson->question2->od->vitreous:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->vitreous)? $data_formjson->question2->os->vitreous== "other" ? $data_formjson->question2->os->{'vitreous-Comment'}:$data_formjson->question2->os->vitreous:'-' ?></td>
                        </tr>
                        <tr>
                            <td>FUNDUS OKULI</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->fundus)? $data_formjson->question2->od->fundus == "other" ? $data_formjson->question2->od->{'fundus-Comment'}:$data_formjson->question2->od->fundus:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->fundus)? $data_formjson->question2->os->fundus== "other" ? $data_formjson->question2->os->{'fundus-Comment'}:$data_formjson->question2->os->fundus:'-' ?></td>
                        </tr>


                        <tr>
                            <td>KEDUDUKAN  BOLA MATA</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->kedudukan)? $data_formjson->question2->od->kedudukan == "other" ? $data_formjson->question2->od->{'kedudukan-Comment'}:$data_formjson->question2->od->kedudukan:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->kedudukan)? $data_formjson->question2->os->kedudukan== "other" ? $data_formjson->question2->os->{'kedudukan-Comment'}:$data_formjson->question2->os->kedudukan:'-' ?></td>
                        </tr>

                        <tr>
                            <td>GERAKAN BOLA MATA</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->gerakan_bola_mata)? $data_formjson->question2->od->gerakan_bola_mata == "other" ? $data_formjson->question2->od->{'gerakan_bola_mata-Comment'}:$data_formjson->question2->od->gerakan_bola_mata:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->gerakan_bola_mata)? $data_formjson->question2->os->gerakan_bola_mata== "other" ? $data_formjson->question2->os->{'gerakan_bola_mata-Comment'}:$data_formjson->question2->os->gerakan_bol_mata:'-' ?></td>
                        </tr>

                        <tr>
                            <td>TEKANAN INTRA OKULER</td>
                            <td class="center-text"><?= isset($data_formjson->question2->od->tekanan_intra_okuler)? $data_formjson->question2->od->tekanan_intra_okuler == "other" ? $data_formjson->question2->od->{'tekanan_intra_okuler-Comment'}:$data_formjson->question2->od->tekanan_intra_okuler:'-' ?></td>
                            <td class="center-text"><?= isset($data_formjson->question2->os->tekanan_intra_okuler)? $data_formjson->question2->od->tekanan_intra_okuler == "other" ? $data_formjson->question2->od->{'tekanan_intra_okuler-Comment'}:$data_formjson->question2->od->tekanan_intra_okuler:'-' ?></td>
                        </tr>
                       
                       
                        
                       
                       
                        
                        
                        
                        

                    </table>
                </td>
            </tr>
              
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
                                <span ><?= isset($data_formjson->diagnosa_kerja)?$data_formjson->diagnosa_kerja : '-' ;?></span>
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
                                <span ><?= isset($data_formjson->diagnosa_banding)?$data_formjson->diagnosa_banding : '-' ;?></span>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr>

            <!-- <tr>
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
                                <span>><?= isset($data_formjson->diagnosa_banding)?$data_formjson->diagnosa_banding : '-' ;?></span>
                            </td>
                        </tr>
                    </table>
                    
                </td>
            </tr> -->

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
                                <span><?= isset($data_formjson->therapi_tindakan)? $data_formjson->therapi_tindakan: '-' ;?></span>
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
                            <td> <span style="font-size:12px">No.Sip <?= isset($nip_dokter->nipeg)? $nip_dokter->nipeg: '' ?> </span></td>
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
    </div>
    </td>
    </tr>



    </table>
    </div>
    <footer>
    <p style="text-align:left;font-size:12px">Hal 1 dari 1</p>
    </footer>
    </div>
</body>

</html>
