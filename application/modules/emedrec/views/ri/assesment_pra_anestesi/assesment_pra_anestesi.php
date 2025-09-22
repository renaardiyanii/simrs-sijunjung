<?php
$data = (isset($pra_anestesti->formjson)?json_decode($pra_anestesti->formjson):'');
$result = array_chunk($pra_anestesti, 1);
//  var_dump();
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
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

            <center><h4>ASSESMENT PRA ANESTESI/SEDASI</h4></center>
        

            <div style="font-size:12px">
            <?php 
            // $val = $result[$i]->formjson?json_decode($result[$i]->formjson):null;
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
                //  var_dump($value);die();
            ?>
            <table width="100%" id="data" border="1" cellpadding="3px">

                <tr>
                    <td width="8%">Kesadaran</td>
                    <td width="8%">Berat Badan </td>
                    <td width="8%">Tekanan Darah </td>
                    <td width="8%">Frekuensi Nadi </td>
                    <td width="8%">Frekuensi Napas </td>
                    <td width="8%">Suhu</td>
                    <td width="8%">CVP SpO2,dan lain-lain</td>
                    <td  colspan="2" rowspan="2"> Diagnosa :
                        <p><?= isset($value->question5->diagnosa)?$value->question5->diagnosa:'' ?></p>
                    </td>
                </tr>

                <tr>
                    <td><?= isset($value->question1[0]->kesadaran)?$value->question1[0]->kesadaran:'' ?></td>
                    <td> <?= isset($value->question1[0]->bb)?$value->question1[0]->bb:'' ?></td>
                    <td> <?= isset($value->question1[0]->td)?$value->question1[0]->td:'' ?></td>
                    <td> <?= isset($value->question1[0]->fn)?$value->question1[0]->fn:'' ?></td>
                    <td><?= isset($value->question1[0]->fna)?$value->question1[0]->fna:'' ?></td>
                    <td><?= isset($value->question1[0]->suhu)?$value->question1[0]->suhu:'' ?></td>
                    <td><?= isset($value->question1[0]->cvp)?$value->question1[0]->cvp:'' ?></td>
                  
                    
                </tr>
                <tr>
                    <td colspan="7" rowspan="3">
                        <span style="font-weight:bold">Riwayat Operasi / Anestesi : <?= isset($value->question2[0]->riwayat_operasi)?$value->question2[0]->riwayat_operasi:'' ?></span><br>
                        <span style="font-weight:bold">Riwayat komplikasi anestesi pada pasien</span><br><br>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question2[0]->komplikasi)? $value->question2[0]->komplikasi == "ada" ? "checked":'':'' ?>>
                            <span>Ada, <?= isset($value->question2[0]->detilkomplikasi)?$value->question2[0]->detilkomplikasi:'' ?></span>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question2[0]->komplikasi)? $value->question2[0]->komplikasi == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak Ada</span><br><br>
                        <span style="font-weight:bold">Gigi :</span>
                            <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question2[0]->gigi)? $value->question2[0]->gigi == "tampak" ? "checked":'':'' ?>>
                            <span>Tampak normal </span><br><br>
                            <input type="checkbox" value="Auto Anamnesa" style="margin-left:45px"   <?php echo isset($value->question2[0]->gigi)? $value->question2[0]->gigi == "goyah" ? "checked":'':'' ?>>
                            <span>Goyah :</span>

                            <input type="checkbox" value="Auto Anamnesa"   <?= (isset($value->question2[0]->detilgigi)?in_array('semua ',$value->question2[0]->detilgigi)?'checked':'':'') ?>>
                            <span>Semua  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($value->question2[0]->detilgigi)?in_array('atas',$value->question2[0]->detilgigi)?'checked':'':'') ?>>
                            <span>Atas   </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($value->question2[0]->detilgigi)?in_array('sebagian ',$value->question2[0]->detilgigi)?'checked':'':'') ?>>
                            <span>Sebagian  </span><br><br>
                            <input type="checkbox" value="Auto Anamnesa" style="margin-left:45px"    <?php echo isset($value->question2[0]->gigi)? $value->question2[0]->gigi == "gigi_palsu" ? "checked":'':'' ?>>
                            <span>Gigi palsu   : </span>
                            <input type="checkbox" value="Auto Anamnesa"   <?= (isset($value->question2[0]->detilgigi1)?in_array('semua ',$value->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Semua  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($value->question2[0]->detilgigi1)?in_array('atas',$value->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Atas   </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($value->question2[0]->detilgigi1)?in_array('bawah ',$value->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Bawah   </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($value->question2[0]->detilgigi1)?in_array('sebagian',$value->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Sebagian  </span><br><br>

                    </td>
                    <td  colspan="2">Rencana tindakan : <p><?= isset($value->question5->tindakan)?$value->question5->tindakan:'' ?></p></td>
                   
                </tr>
                <tr> <td  colspan="2">Obat yang sedang dikonsumsi :<p><?= isset($value->question5->obat)?$value->question5->obat:'' ?></p> </td></tr>
                <tr> <td  colspan="2">Alergi obat / makanan : <p><?= isset($value->question5->alergi)?$value->question5->alergi:'' ?></p></td></tr>
                <tr>
                    <td colspan="7" >
                    <span style="font-weight:bold">Jalan Nafas :  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question2[0]->jalan_nafas)? $value->question2[0]->jalan_nafas == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada masalah yang terlihat </span><br>
                            <span style="font-weight:bold">Skor Mallampati  : <?= isset($value->malampati)?$value->malampati:'' ?></span>  
                            <img src=<?= base_url("assets/images/praanestesi.PNG"); ?> alt=""  width="150" height="100">
                    
                    </td>
                    <td>
                    Pemeriksaan Lab 
                    </td>
                    <td>
                    Radiologi  dan Penunjang lain
                    </td>
                   
                </tr>
                <tr>
                    <td colspan="7" rowspan="2">
                    <span style="font-weight:bold">Respirasi :</span> <br><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "asma" ? "checked":'':'' ?>>
                        <span>Asma</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "ppok" ? "checked":'':'' ?>>
                        <span>PPOK</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "ispa" ? "checked":'':'' ?>>
                        <span>ISPA     </span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "riwayat_ispa" ? "checked":'':'' ?>>
                        <span>Riwayat ISPA    </span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "sleep" ? "checked":'':'' ?>>
                        <span>Sleep Apneu</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "merokok" ? "checked":'':'' ?>>
                        <span>Merokok <?= isset($value->question4[0]->batang)?$value->question4[0]->batang:'...' ?> Batang/ bungkus tiap hari selama <?= isset($value->question4[0]->thn)?$value->question4[0]->thn:'...' ?> thn</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "riwayat" ? "checked":'':'' ?>>
                        <span>Riwayat Merokok <?= isset($value->question4[0]->batang1)?$value->question4[0]->batang1:'...' ?> Batang/ bungkus tiap hari selama <?= isset($value->question4[0]->thn2)?$value->question4[0]->thn2:'...' ?> thn</span><br>
                        <span>Berhenti <?= isset($value->question4[0]->berhenti)?$value->question4[0]->berhenti:'...' ?></span><br>
                        
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "normal" ? "checked":'':'' ?>>
                        <span>Normal </span>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->respirasi)? $value->question4[0]->respirasi == "other" ? "checked":'':'' ?>>
                        <span>Lain-lain : <?= isset($value->question4[0]->{'respirasi-Comment'})?$value->question4[0]->{'respirasi-Comment'}:'' ?></span><br><br>


                        <span  style="font-weight:bold">Kardiovaskular :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "angina " ? "checked":'':'' ?>>
                                    <span>Angina  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "cad" ? "checked":'':'' ?>>
                                    <span>CAD  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "chf" ? "checked":'':'' ?>>
                                    <span>CHF </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "disritmia" ? "checked":'':'' ?>>
                                    <span>Disritmia  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "hipertensi " ? "checked":'':'' ?>>
                                    <span>Hipertensi  </span><br>
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "dislipidemia" ? "checked":'':'' ?>>
                                    <span>Dislipidemia   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "mci" ? "checked":'':'' ?>>
                                    <span>MCI  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "pacemaker" ? "checked":'':'' ?>>
                                    <span>Pacemaker   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "penyakit" ? "checked":'':'' ?>>
                                    <span>Penyakit Katup  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain : <?= isset($value->question4[0]->{'kardiovaskular-Comment'})?$value->question4[0]->{'kardiovaskular-Comment'}:'' ?></span><br><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->kardiovaskular)? $value->question4[0]->kardiovaskular == "normal " ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                </td>
                            </tr>
                        </table>
                        <span style="font-weight:bold">Sistem Pencernaan :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->sistem_pencernaan)? $value->question4[0]->sistem_pencernaan == "penyakit" ? "checked":'':'' ?>>
                                    <span>Penyakit Liver   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->sistem_pencernaan)? $value->question4[0]->sistem_pencernaan == "mual" ? "checked":'':'' ?>>
                                    <span>Mual / Muntah   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->sistem_pencernaan)? $value->question4[0]->sistem_pencernaan == "drug" ? "checked":'':'' ?>>
                                    <span>Drug/Alcohol Abuse  </span><br>
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->sistem_pencernaan)? $value->question4[0]->sistem_pencernaan == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain :<?= isset($value->question4[0]->{'sistem_pencernaan-Comment'})?$value->question4[0]->{'sistem_pencernaan-Comment'}:'' ?>  </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->sistem_pencernaan)? $value->question4[0]->sistem_pencernaan == "normal " ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                </td>
                            </tr>
                        </table><br>

                        <span style="font-weight:bold">Neuro / Musculoskeletal :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "art" ? "checked":'':'' ?>>
                                    <span>Artritis    </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "cva" ? "checked":'':'' ?>>
                                    <span>CVA / TIA    </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "lumpuh" ? "checked":'':'' ?>>
                                    <span>Kelumpuhan </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "neuromuskular" ? "checked":'':'' ?>>
                                    <span>Penyakit Neuromuskular   </span><br>
                                  
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "kejang" ? "checked":'':'' ?>>
                                    <span>Kejang   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain : <?= isset($value->question4[0]->{'neuro-Comment'})?$value->question4[0]->{'neuro-Comment'}:'' ?>   </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->neuro)? $value->question4[0]->neuro == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                </td>
                            </tr>
                        </table><br>

                        <span style="font-weight:bold">Ginjal / Endokrin :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa" <?php echo isset($value->question4[0]->ginjal)? $value->question4[0]->ginjal == "dm" ? "checked":'':'' ?>>
                                    <span>DM     </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->ginjal)? $value->question4[0]->ginjal == "gagal" ? "checked":'':'' ?>>
                                    <span>Gagal Ginjal / dialisis    </span><br>
                                  
                                  
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->ginjal)? $value->question4[0]->ginjal == "riwayat" ? "checked":'':'' ?>>
                                    <span>Riwayat Steroid              </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->ginjal)? $value->question4[0]->ginjal == "tiroid" ? "checked":'':'' ?>>
                                    <span>Penyakit tiroid                 </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->ginjal)? $value->question4[0]->ginjal == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->question4[0]->ginjal)? $value->question4[0]->ginjal == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain : <?= isset($value->question4[0]->{'ginjal-Comment'})?$value->question4[0]->{'ginjal-Comment'}:'' ?></span><br>
                                </td>
                            </tr>
                        </table><br>

                        <span style="font-weight:bold">Lain-lain :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->lainlain)? $value->question4[0]->lainlain == "koagulopati" ? "checked":'':'' ?>>
                                    <span>Koagulopati      </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->lainlain)? $value->question4[0]->lainlain == "obesitas" ? "checked":'':'' ?>>
                                    <span>Obesitas     </span><br>
                                  
                                  
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->lainlain)? $value->question4[0]->lainlain == "kehamilan" ? "checked":'':'' ?>>
                                    <span>Kehamilan                   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->lainlain)? $value->question4[0]->lainlain == "prikiatri" ? "checked":'':'' ?>>
                                    <span>Riwayat Psikiatri                  </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->lainlain)? $value->question4[0]->lainlain == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->question4[0]->lainlain)? $value->question4[0]->lainlain == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak ada </span><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <span>Hb : <?= isset($value->question6->hb)?$value->question6->hb:'...' ?> </span><br>
                        <span> Ht : <?= isset($value->question6->ht)?$value->question6->ht:'...' ?> </span><br>
                        <span> Leukosit : <?= isset($value->question6->leukosit)?$value->question6->leukosit:'...' ?>   </span><br>
                        <span> Trombosit: <?= isset($value->question6->trombosit)?$value->question6->trombosit:'...' ?> </span><br>
                        <span> GDS : <?= isset($value->question6->gds)?$value->question6->gds:'...' ?>  </span><br>
                        <span> HBs Ag : <?= isset($value->question6->hbs)?$value->question6->hbs:'...' ?> </span><br>
                        <span> Anti HIV: <?= isset($value->question6->anti)?$value->question6->anti:'...' ?> </span><br>
                        <span> Lain-lain: <?= isset($value->question6->Lainlain)?$value->question6->Lainlain:'...' ?> </span><br>
                    </td>
                    <td>
                        Rontgen<br><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->rontgen)? $value->rontgen == "ada" ? "checked":'':'' ?>>
                        <span>Ada</span>
                        <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($value->rontgen)? $value->rontgen == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span><br><br>
                         EKG<br><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->ekg)? $value->ekg == "ada" ? "checked":'':'' ?>>
                        <span>Ada</span>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($value->ekg)? $value->ekg == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <span>Puasa </span><br>
                        <span>Minum Terakhir Jam : <?= isset($value->question7->minum)?$value->question7->minum:'' ?> </span><br>
                        <span>Makan Terakhir  Jam : <?= isset($value->question7->makan)?$value->question7->makan:'' ?> </span>
                        <p style="font-weight:bold">Rencana Anestesi : </p>
                        <span>ASA : <?= isset($value->rencana[0]->asa)?$value->rencana[0]->asa:'' ?></span>&nbsp;&nbsp;&nbsp;
                        

                        <p>Rencana : <?= isset($value->rencana[0]->rencana)?$value->rencana[0]->rencana:'' ?></p>
                        <span style="font-weight:bold">Premedikasi : </span><br><br>
                        <span>Obat  <?= isset($value->premedikas[0]->obat)?$value->premedikas[0]->obat:'' ?></span><br>
                        <span>Waktu <?= isset($value->premedikas[0]->waktu)?$value->premedikas[0]->waktu:'' ?></span><br>
                        <p style="min-height:100px"></p>

                        <p>Bukittinggi, <?= isset($pra_anestesti->tgl_input)?date('d/m/Y',strtotime($pra_anestesti->tgl_input)):'' ?> Jam :  <?= isset($pra_anestesti->tgl_input)?date('h:i',strtotime($pra_anestesti->tgl_input)):'' ?></p>
                        <span>Dokter Anestesi</span><br>
                        <?php
                        $id = isset($pra_anestesti->id_pemeriksa)?$pra_anestesti->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users  where hmis_users.userid = $id")->row():null;
                       
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <span>( <?= isset($query->name)?$query->name:'' ?> )</span><br>
                        <span>Tanda Tangan & Nama Terang</span>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>(  )</span><br>
                                <span>Tanda Tangan & Nama Terang</span>
                            <?php } ?>


            
                        
                    </td>
                    
                </tr>


            </table>
            <?php endforeach; ?>
            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            </div>
           
        </div>
    <?php }}else{ ?>  
      
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMENT PRA ANESTESI/SEDASI</h4></center>
        

            <div style="font-size:12px">

            <table width="100%" id="data" border="1" cellpadding="3px">

                <tr>
                    <td width="8%">Kesadaran</td>
                    <td width="8%">Berat Badan </td>
                    <td width="8%">Tekanan Darah </td>
                    <td width="8%">Frekuensi Nadi </td>
                    <td width="8%">Frekuensi Napas </td>
                    <td width="8%">Suhu</td>
                    <td width="8%">CVP SpO2,dan lain-lain</td>
                    <td  colspan="2" rowspan="2"> Diagnosa :
                        <p><?= isset($data->question5->diagnosa)?$data->question5->diagnosa:'' ?></p>
                    </td>
                </tr>

                <tr>
                    <td><?= isset($data->question1[0]->kesadaran)?$data->question1[0]->kesadaran:'' ?></td>
                    <td> <?= isset($data->question1[0]->bb)?$data->question1[0]->bb:'' ?></td>
                    <td> <?= isset($data->question1[0]->td)?$data->question1[0]->td:'' ?></td>
                    <td> <?= isset($data->question1[0]->fn)?$data->question1[0]->fn:'' ?></td>
                    <td><?= isset($data->question1[0]->fna)?$data->question1[0]->fna:'' ?></td>
                    <td><?= isset($data->question1[0]->suhu)?$data->question1[0]->suhu:'' ?></td>
                    <td><?= isset($data->question1[0]->cvp)?$data->question1[0]->cvp:'' ?></td>
                  
                    
                </tr>
                <tr>
                    <td colspan="7" rowspan="3">
                        <span style="font-weight:bold">Riwayat Operasi / Anestesi : <?= isset($data->question2[0]->riwayat_operasi)?$data->question2[0]->riwayat_operasi:'' ?></span><br>
                        <span style="font-weight:bold">Riwayat komplikasi anestesi pada pasien</span><br><br>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question2[0]->komplikasi)? $data->question2[0]->komplikasi == "ada" ? "checked":'':'' ?>>
                            <span>Ada, <?= isset($data->question2[0]->detilkomplikasi)?$data->question2[0]->detilkomplikasi:'' ?></span>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question2[0]->komplikasi)? $data->question2[0]->komplikasi == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak Ada</span><br><br>
                        <span style="font-weight:bold">Gigi :</span>
                            <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question2[0]->gigi)? $data->question2[0]->gigi == "tampak" ? "checked":'':'' ?>>
                            <span>Tampak normal </span><br><br>
                            <input type="checkbox" value="Auto Anamnesa" style="margin-left:45px"   <?php echo isset($data->question2[0]->gigi)? $data->question2[0]->gigi == "goyah" ? "checked":'':'' ?>>
                            <span>Goyah :</span>

                            <input type="checkbox" value="Auto Anamnesa"   <?= (isset($data->question2[0]->detilgigi)?in_array('semua ',$data->question2[0]->detilgigi)?'checked':'':'') ?>>
                            <span>Semua  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($data->question2[0]->detilgigi)?in_array('atas',$data->question2[0]->detilgigi)?'checked':'':'') ?>>
                            <span>Atas   </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($data->question2[0]->detilgigi)?in_array('sebagian ',$data->question2[0]->detilgigi)?'checked':'':'') ?>>
                            <span>Sebagian  </span><br><br>
                            <input type="checkbox" value="Auto Anamnesa" style="margin-left:45px"    <?php echo isset($data->question2[0]->gigi)? $data->question2[0]->gigi == "gigi_palsu" ? "checked":'':'' ?>>
                            <span>Gigi palsu   : </span>
                            <input type="checkbox" value="Auto Anamnesa"   <?= (isset($data->question2[0]->detilgigi1)?in_array('semua ',$data->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Semua  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($data->question2[0]->detilgigi1)?in_array('atas',$data->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Atas   </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($data->question2[0]->detilgigi1)?in_array('bawah ',$data->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Bawah   </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?= (isset($data->question2[0]->detilgigi1)?in_array('sebagian',$data->question2[0]->detilgigi1)?'checked':'':'') ?>>
                            <span>Sebagian  </span><br><br>

                    </td>
                    <td  colspan="2">Rencana tindakan : <p><?= isset($data->question5->tindakan)?$data->question5->tindakan:'' ?></p></td>
                   
                </tr>
                <tr> <td  colspan="2">Obat yang sedang dikonsumsi :<p><?= isset($data->question5->obat)?$data->question5->obat:'' ?></p> </td></tr>
                <tr> <td  colspan="2">Alergi obat / makanan : <p><?= isset($data->question5->alergi)?$data->question5->alergi:'' ?></p></td></tr>
                <tr>
                    <td colspan="7" >
                    <span style="font-weight:bold">Jalan Nafas :  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question2[0]->jalan_nafas)? $data->question2[0]->jalan_nafas == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada masalah yang terlihat </span><br>
                            <span style="font-weight:bold">Skor Mallampati  : <?= isset($data->malampati)?$data->malampati:'' ?></span>  
                            <img src=<?= base_url("assets/images/praanestesi.PNG"); ?> alt=""  width="150" height="100">
                    
                    </td>
                    <td>
                    Pemeriksaan Lab 
                    </td>
                    <td>
                    Radiologi  dan Penunjang lain
                    </td>
                   
                </tr>
                <tr>
                    <td colspan="7" rowspan="2">
                    <span style="font-weight:bold">Respirasi :</span> <br><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "asma" ? "checked":'':'' ?>>
                        <span>Asma</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "ppok" ? "checked":'':'' ?>>
                        <span>PPOK</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "ispa" ? "checked":'':'' ?>>
                        <span>ISPA     </span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "riwayat_ispa" ? "checked":'':'' ?>>
                        <span>Riwayat ISPA    </span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "sleep" ? "checked":'':'' ?>>
                        <span>Sleep Apneu</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "merokok" ? "checked":'':'' ?>>
                        <span>Merokok <?= isset($data->question4[0]->batang)?$data->question4[0]->batang:'...' ?> Batang/ bungkus tiap hari selama <?= isset($data->question4[0]->thn)?$data->question4[0]->thn:'...' ?> thn</span><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "riwayat" ? "checked":'':'' ?>>
                        <span>Riwayat Merokok <?= isset($data->question4[0]->batang1)?$data->question4[0]->batang1:'...' ?> Batang/ bungkus tiap hari selama <?= isset($data->question4[0]->thn2)?$data->question4[0]->thn2:'...' ?> thn</span><br>
                        <span>Berhenti <?= isset($data->question4[0]->berhenti)?$data->question4[0]->berhenti:'...' ?></span><br>
                        
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "normal" ? "checked":'':'' ?>>
                        <span>Normal </span>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->respirasi)? $data->question4[0]->respirasi == "other" ? "checked":'':'' ?>>
                        <span>Lain-lain : <?= isset($data->question4[0]->{'respirasi-Comment'})?$data->question4[0]->{'respirasi-Comment'}:'' ?></span><br><br>


                        <span  style="font-weight:bold">Kardiovaskular :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "angina " ? "checked":'':'' ?>>
                                    <span>Angina  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "cad" ? "checked":'':'' ?>>
                                    <span>CAD  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "chf" ? "checked":'':'' ?>>
                                    <span>CHF </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "disritmia" ? "checked":'':'' ?>>
                                    <span>Disritmia  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "hipertensi " ? "checked":'':'' ?>>
                                    <span>Hipertensi  </span><br>
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "dislipidemia" ? "checked":'':'' ?>>
                                    <span>Dislipidemia   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "mci" ? "checked":'':'' ?>>
                                    <span>MCI  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "pacemaker" ? "checked":'':'' ?>>
                                    <span>Pacemaker   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "penyakit" ? "checked":'':'' ?>>
                                    <span>Penyakit Katup  </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain : <?= isset($data->question4[0]->{'kardiovaskular-Comment'})?$data->question4[0]->{'kardiovaskular-Comment'}:'' ?></span><br><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->kardiovaskular)? $data->question4[0]->kardiovaskular == "normal " ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                </td>
                            </tr>
                        </table>
                        <span style="font-weight:bold">Sistem Pencernaan :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->sistem_pencernaan)? $data->question4[0]->sistem_pencernaan == "penyakit" ? "checked":'':'' ?>>
                                    <span>Penyakit Liver   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->sistem_pencernaan)? $data->question4[0]->sistem_pencernaan == "mual" ? "checked":'':'' ?>>
                                    <span>Mual / Muntah   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->sistem_pencernaan)? $data->question4[0]->sistem_pencernaan == "drug" ? "checked":'':'' ?>>
                                    <span>Drug/Alcohol Abuse  </span><br>
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->sistem_pencernaan)? $data->question4[0]->sistem_pencernaan == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain :<?= isset($data->question4[0]->{'sistem_pencernaan-Comment'})?$data->question4[0]->{'sistem_pencernaan-Comment'}:'' ?>  </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->sistem_pencernaan)? $data->question4[0]->sistem_pencernaan == "normal " ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                </td>
                            </tr>
                        </table><br>

                        <span style="font-weight:bold">Neuro / Musculoskeletal :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "art" ? "checked":'':'' ?>>
                                    <span>Artritis    </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "cva" ? "checked":'':'' ?>>
                                    <span>CVA / TIA    </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "lumpuh" ? "checked":'':'' ?>>
                                    <span>Kelumpuhan </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "neuromuskular" ? "checked":'':'' ?>>
                                    <span>Penyakit Neuromuskular   </span><br>
                                  
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "kejang" ? "checked":'':'' ?>>
                                    <span>Kejang   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain : <?= isset($data->question4[0]->{'neuro-Comment'})?$data->question4[0]->{'neuro-Comment'}:'' ?>   </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->neuro)? $data->question4[0]->neuro == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                </td>
                            </tr>
                        </table><br>

                        <span style="font-weight:bold">Ginjal / Endokrin :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa" <?php echo isset($data->question4[0]->ginjal)? $data->question4[0]->ginjal == "dm" ? "checked":'':'' ?>>
                                    <span>DM     </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->ginjal)? $data->question4[0]->ginjal == "gagal" ? "checked":'':'' ?>>
                                    <span>Gagal Ginjal / dialisis    </span><br>
                                  
                                  
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->ginjal)? $data->question4[0]->ginjal == "riwayat" ? "checked":'':'' ?>>
                                    <span>Riwayat Steroid              </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->ginjal)? $data->question4[0]->ginjal == "tiroid" ? "checked":'':'' ?>>
                                    <span>Penyakit tiroid                 </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->ginjal)? $data->question4[0]->ginjal == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                    <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question4[0]->ginjal)? $data->question4[0]->ginjal == "other" ? "checked":'':'' ?>>
                                    <span>Lain-lain : <?= isset($data->question4[0]->{'ginjal-Comment'})?$data->question4[0]->{'ginjal-Comment'}:'' ?></span><br>
                                </td>
                            </tr>
                        </table><br>

                        <span style="font-weight:bold">Lain-lain :</span><br><br>
                        <table width="100%">
                            <tr>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->lainlain)? $data->question4[0]->lainlain == "koagulopati" ? "checked":'':'' ?>>
                                    <span>Koagulopati      </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->lainlain)? $data->question4[0]->lainlain == "obesitas" ? "checked":'':'' ?>>
                                    <span>Obesitas     </span><br>
                                  
                                  
                                </td>
                                <td width="35%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->lainlain)? $data->question4[0]->lainlain == "kehamilan" ? "checked":'':'' ?>>
                                    <span>Kehamilan                   </span><br>
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->lainlain)? $data->question4[0]->lainlain == "prikiatri" ? "checked":'':'' ?>>
                                    <span>Riwayat Psikiatri                  </span><br>
                                </td>
                                <td width="30%">
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->lainlain)? $data->question4[0]->lainlain == "normal" ? "checked":'':'' ?>>
                                    <span>Normal</span><br>
                                    <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->question4[0]->lainlain)? $data->question4[0]->lainlain == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak ada </span><br>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>
                        <span>Hb : <?= isset($data->question6->hb)?$data->question6->hb:'...' ?> </span><br>
                        <span> Ht : <?= isset($data->question6->ht)?$data->question6->ht:'...' ?> </span><br>
                        <span> Leukosit : <?= isset($data->question6->leukosit)?$data->question6->leukosit:'...' ?>   </span><br>
                        <span> Trombosit: <?= isset($data->question6->trombosit)?$data->question6->trombosit:'...' ?> </span><br>
                        <span> GDS : <?= isset($data->question6->gds)?$data->question6->gds:'...' ?>  </span><br>
                        <span> HBs Ag : <?= isset($data->question6->hbs)?$data->question6->hbs:'...' ?> </span><br>
                        <span> Anti HIV: <?= isset($data->question6->anti)?$data->question6->anti:'...' ?> </span><br>
                        <span> Lain-lain: <?= isset($data->question6->Lainlain)?$data->question6->Lainlain:'...' ?> </span><br>
                    </td>
                    <td>
                        Rontgen<br><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->rontgen)? $data->rontgen == "ada" ? "checked":'':'' ?>>
                        <span>Ada</span>
                        <input type="checkbox" value="Auto Anamnesa"   <?php echo isset($data->rontgen)? $data->rontgen == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span><br><br>
                         EKG<br><br>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->ekg)? $data->ekg == "ada" ? "checked":'':'' ?>>
                        <span>Ada</span>
                        <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->ekg)? $data->ekg == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak ada</span>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <span>Puasa </span><br>
                        <span>Minum Terakhir Jam : <?= isset($data->question7->minum)?$data->question7->minum:'' ?> </span><br>
                        <span>Makan Terakhir  Jam : <?= isset($data->question7->makan)?$data->question7->makan:'' ?> </span>
                        <p style="font-weight:bold">Rencana Anestesi : </p>
                        <span>ASA : <?= isset($data->rencana[0]->asa)?$data->rencana[0]->asa:'' ?></span>&nbsp;&nbsp;&nbsp;
                        

                        <p>Rencana : <?= isset($data->rencana[0]->rencana)?$data->rencana[0]->rencana:'' ?></p>
                        <span style="font-weight:bold">Premedikasi : </span><br><br>
                        <span>Obat  <?= isset($data->premedikas[0]->obat)?$data->premedikas[0]->obat:'' ?></span><br>
                        <span>Waktu <?= isset($data->premedikas[0]->waktu)?$data->premedikas[0]->waktu:'' ?></span><br>
                        <p style="min-height:100px"></p>

                        <p>Bukittinggi, <?= isset($pra_anestesti->tgl_input)?date('d/m/Y',strtotime($pra_anestesti->tgl_input)):'' ?> Jam :  <?= isset($pra_anestesti->tgl_input)?date('h:i',strtotime($pra_anestesti->tgl_input)):'' ?></p>
                        <span>Dokter Anestesi</span><br>
                        <?php
                        $id = isset($pra_anestesti->id_pemeriksa)?$pra_anestesti->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users  where hmis_users.userid = $id")->row():null;
                       
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <span>( <?= isset($query->name)?$query->name:'' ?> )</span><br>
                        <span>Tanda Tangan & Nama Terang</span>
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>(  )</span><br>
                                <span>Tanda Tangan & Nama Terang</span>
                            <?php } ?>


            
                        
                    </td>
                    
                </tr>


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
           
        </div>
    <?php } ?>
    </body>
    </html>

   