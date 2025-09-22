<?php 
 if(isset($catatan_medis_awal_inap[0]->formjson_dewasa) )
 {
    $catatan_medis_awal = json_decode($catatan_medis_awal_inap[0]->formjson_dewasa);
 }

 $test = $catatan_medis_awal_inap;
//   var_dump($test);

?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
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
        #data {
            /* margin-top: 20px; */
            /* border-collapse: collapse; */
            /* border: 1px solid black;     */
            width: 100%;
            font-size: 13px;
            /* position: relative; */
            text-align: justify;
           
        }

    </style>
        <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
                
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 15px; text-align: center;">
                    CATATAN MEDIS AWAL RAWAT INAP
                </p>

                <div style="font-size:13px">
                        <p style="font-weight:bold"><u>ANAMNESA</u></p>
                        <p ><?=(isset($catatan_medis_awal->anamnesa)?$catatan_medis_awal->anamnesa:'') ?></p> 

                        <p style="font-weight:bold"><u>KELUHAN UTAMA</u></p>
                        <p> <?=(isset($catatan_medis_awal->keluhan)?$catatan_medis_awal->keluhan:'') ?></p>

                        <p style="font-weight:bold"><u>RIWAYAT PENYAKIT SEKARANG</u></p>
                        <p> <?=(isset($catatan_medis_awal->riwayat)?$catatan_medis_awal->riwayat:'') ?></p>

                        <p style="font-weight:bold"><u>RIWAYAT PENYAKIT DAHULU</u></p>
                        <p> <?=(isset($catatan_medis_awal->riwayat_penyakit_dahulu)?$catatan_medis_awal->riwayat_penyakit_dahulu:'') ?></p>

                        <p style="font-weight:bold"><u>RIWAYAT PENYAKIT DALAM KELUARGA</u></p>
                        <p> <?=(isset($catatan_medis_awal->penyakit_keluarga)?$catatan_medis_awal->penyakit_keluarga:'') ?></p>

                        <p style="font-weight:bold"><u>RIWAYAT PEKERJAAN</u></p>
                        <p><?=(isset($catatan_medis_awal->riwayat_pekerjaan)?$catatan_medis_awal->riwayat_pekerjaan:'') ?></p>

                        <P style="font-weight:bold"><u>RIWAYAT SOSIAL EKONOMI</u></P>
                        <P>
                            <input type="checkbox" value="Biaya sendiri" <?php echo isset($catatan_medis_awal->riwayat_sosial)? $catatan_medis_awal->riwayat_sosial == "UMUM" ? "checked":'':'' ?>>
                            <span>Biaya sendiri</span>

                            <input type="checkbox" value="Asuransi" style="margin-left:50px" <?php echo isset($catatan_medis_awal->riwayat_sosial)? $catatan_medis_awal->riwayat_sosial != "UMUM" ? "checked":'':'' ?>>
                            <span>Asuransi :  <?php echo isset($catatan_medis_awal->check_asuransi)? $catatan_medis_awal->check_asuransi != "UMUM" ? $catatan_medis_awal->check_asuransi:'':'' ?></span>
                        </P>

                        <p style="font-weight:bold"><u>RIWAYAT KEJIWAAN</u></p>
                        <p><?=(isset($catatan_medis_awal->kejiwaan)?$catatan_medis_awal->kejiwaan:'') ?></p>

                        <p> <b><u>RIWAYAT KEBIASAAN</u></b> </p>
                        <p>
                                <input type="checkbox" value="Merokok"  <?php echo isset($catatan_medis_awal->riwayat_kebiasaan)? in_array('meroko',$catatan_medis_awal->riwayat_kebiasaan) ? "checked":'':'' ?>>
                                <span>Merokok</span>
                                <input type="checkbox" value="Alkohol" style="margin-left:50px" <?php echo isset($catatan_medis_awal->riwayat_kebiasaan)? in_array('akohol',$catatan_medis_awal->riwayat_kebiasaan) ? "checked":'':'' ?>>
                                <span>Alkohol</span>
                                <input type="checkbox" value="Lainnya" style="margin-left:50px" <?php echo isset($catatan_medis_awal->riwayat_kebiasaan)? in_array('other',$catatan_medis_awal->riwayat_kebiasaan) ? "checked":'':'' ?>>
                                <span>Lainnya <?=':'.' '.(isset($catatan_medis_awal->{'riwayat_kebiasaan-Comment'})?$catatan_medis_awal->{'riwayat_kebiasaan-Comment'}:'') ?></span><BR>
                        </p>
                        <p><b>PEMERIKSAAN UMUM / GENERAL EXAMINATION</b></p>
 
                        <table id="data" border="1">
                            <tr>
                                <td style="width: 25%">Keadaan Umum</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->keadaan_umum)?$catatan_medis_awal->keadaan_umum:'') ?></td>
                                <td style="width: 25%;">Suhu</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->suhu)?$catatan_medis_awal->suhu:'').' '.'°C'?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">Kesadaran</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->kesadaran)?$catatan_medis_awal->kesadaran:'') ?></td>
                                <td style="width: 25%;">GCS</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->gcs)?$catatan_medis_awal->gcs:'') ?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">Tekanan Darah</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->td)?$catatan_medis_awal->td:'').' '.'mmHg'?></td>          
                                <td style="width: 25%;">BB / TB</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->bb)?$catatan_medis_awal->bb:'')?> </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">Nadi</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->nadi)?$catatan_medis_awal->nadi:'').' '.'x/menit'?></td>           
                                <td style="width: 25%;">Keadaan Gizi</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->keadaan_gizi)?$catatan_medis_awal->keadaan_gizi:'') ?></td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">Pernafasan</td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->pernafasan)?$catatan_medis_awal->pernafasan:'').' '.'x/menit'?></td>           
                                <td style="width: 25%;">Skor Nyeri </td>
                                <td style="width: 25%;">: <?=(isset($catatan_medis_awal->skor_nyeri)?$catatan_medis_awal->skor_nyeri:'').' '.'x/menit'?></td>
                            </tr>
                        </table><br>

                        <table id="data" border="1" style="text-align:center;">
                            <tr>
                                <th style="width: 30%;"></th> 
                                <th style="width: 20%;text-align:center;">NORMAL</th>
                                <th style="width: 50%;text-align:center">JIKA TIDAK NORMAL JELASKAN</th>
                            </tr>
                            
                            <tr>
                                <td style="width: 30%;">Kepala</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->kepala->normal)? $catatan_medis_awal->table->kepala == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->kepala->jelaskan)? $catatan_medis_awal->table->kepala->jelaskan:'' ?></td>  
                            </tr>

                            <tr>
                                <td style="width: 30%;">Mata</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->mata->normal)? $catatan_medis_awal->table->mata == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->mata->jelaskan)? $catatan_medis_awal->table->mata->jelaskan:'' ?></td>      
                            </tr>

                            <tr>
                                <td style="width: 30%;">THT</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->tht->normal)? $catatan_medis_awal->table->tht == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->tht->jelaskan)? $catatan_medis_awal->table->tht->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Mulut</td>
                                <td style="width: 20%;"><?php echo isset($catatan_medis_awal->mulut)? $catatan_medis_awal->mulut == null ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->mulut)? $catatan_medis_awal->mulut != null ? $catatan_medis_awal->mulut:'':'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Leher</th>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->leher->normal)? $catatan_medis_awal->table->leher == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->leher->jelaskan)? $catatan_medis_awal->table->leher->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Jantung</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->jantung->normal)? $catatan_medis_awal->table->jantung == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->jantung->jelaskan)? $catatan_medis_awal->table->jantung->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Paru</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->paru->normal)? $catatan_medis_awal->table->paru == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->paru->jelaskan)? $catatan_medis_awal->table->paru->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Dada & Payudara</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->dada->normal)? $catatan_medis_awal->table->dada == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->dada->jelaskan)? $catatan_medis_awal->table->dada->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Perut</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->perut->normal)? $catatan_medis_awal->table->perut == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->perut->jelaskan)? $catatan_medis_awal->table->perut->jelaskan:'' ?></td>
                                
                            </tr>
                        </table>
                </div>  
                <br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 2</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
            <p style = "font-weight:bold; font-size: 15px; text-align: center;">
                CATATAN MEDIS AWAL RAWAT INAP
            </p><br>
            <div>

            <div style="font-size:14px">
            <table id="data" border="1" style="text-align:center;">
                            <tr>
                                <th style="width: 30%;"></th> 
                                <th style="width: 20%;text-align:center;">NORMAL</th>
                                <th style="width: 50%;text-align:center">JIKA TIDAK NORMAL JELASKAN</th>
                            </tr>
                          
                            <tr>
                                <td style="width: 30%;">Urogenital</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->urogenital->normal)? $catatan_medis_awal->table->urogenital == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->urogenital->jelaskan)? $catatan_medis_awal->table->urogenital->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Anggota Gerak</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->anggota->normal)? $catatan_medis_awal->table->anggota == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->anggota->jelaskan)? $catatan_medis_awal->table->anggota->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Status Neurologis</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->status->normal)? $catatan_medis_awal->table->status == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->status->jelaskan)? $catatan_medis_awal->table->status->jelaskan:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 30%;">Muskuloskeletal</td>
                                <td style="width: 20%;"> <?php echo isset($catatan_medis_awal->table->muskulosksletas->normal)? $catatan_medis_awal->table->muskulosksletas == true ? "✓":'':'' ?></td>
                                <td style="width: 50%;"><?php echo isset($catatan_medis_awal->table->muskulosksletas->jelaskan)? $catatan_medis_awal->table->muskulosksletas->jelaskan:'' ?></td>
                                
                            </tr>
                        </table>
                <p><u><b>PEMERIKSAAN PENUNJANG</b></u></p>
                <p><?=(isset($catatan_medis_awal->pemeriksaan_penunjang)?$catatan_medis_awal->pemeriksaan_penunjang:'') ?></p>

                <p><u><b>DIAGNOSIS KERJA</b></u></p>
                <p><?=(isset($catatan_medis_awal->diagnosis_kerja)?$catatan_medis_awal->diagnosis_kerja:'') ?></p>

                <p><u><b>DIAGNOSIS BANDING</b></u></p>
                <p><?=(isset($catatan_medis_awal->diagnosis_banding)?$catatan_medis_awal->diagnosis_banding:'') ?></p>

                <p><u><b>PENGOBATAN / TERAPI</b></u></p>
                <p><?=(isset($catatan_medis_awal->pengobatan)?$catatan_medis_awal->pengobatan:'') ?></p>

                <p><u><b> RENCANA TINDAKAN</b></u></p>
                <p><?=(isset($catatan_medis_awal->rencana)?$catatan_medis_awal->rencana:'') ?></p>


               <br><br>
               <div style="float:right">
                    <table>
                    <tr>
                        <td>Tanggal : <?= isset($catatan_medis_awal->tgl)? date('d-m-Y',strtotime($catatan_medis_awal->tgl)):''; ?></td>
                    </tr>
                    <tr>
                        <td>Jam :  <?= isset($catatan_medis_awal->tgl)? date('H:i:s',strtotime($catatan_medis_awal->tgl)):''; ?></td>
                    </tr>
                    <tr>
                        <td>DPJP/Case Manager</td>
                    </tr>
                    <tr>
                        <td>
                        <img width="130px" src="<?=(isset($test[0]->ttd)?$test[0]->ttd:'') ?>" alt="">
                        </td>
                    </tr>
                    </table>
                    <span><?=(isset($test[0]->nm_pemeriksa)?$test[0]->nm_pemeriksa:'') ?></span><br>
                    <span>SIP. <?=(isset($test[0]->nipeg)?$test[0]->nipeg:'') ?></span><br>
                   
                </div>

            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 2 dari 2</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            
        </div>
        
    </body>
</html>