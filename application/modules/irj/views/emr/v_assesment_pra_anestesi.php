<?php
$data = (isset($pra_anestesti->formjson)?json_decode($pra_anestesti->formjson):'');
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

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

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
                    <td colspan="7" rowspan="4">
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
                    <td>Pemeriksaan Lab <p><?= isset($data->question5->alergi)?$data->question5->alergi:'' ?></p></td>
                    <td>Radiologi dan Penunjang lain <p><?= isset($data->question5->alergi)?$data->question5->alergi:'' ?></p></td>
                </tr>
                <tr>
                    <td colspan="7" >
                    <span style="font-weight:bold">Jalan Nafas :  </span>
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->question2[0]->jalan_nafas)? $data->question2[0]->jalan_nafas == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada masalah yang terlihat </span><br>
                            <span style="font-weight:bold">Skor Mallampati  : <?= isset($data->malampati)?$data->malampati:'' ?></span>  
                            <img src=<?= base_url("assets/images/praanestesi.PNG"); ?> alt=""  width="150" height="100">
                    
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
                    
                </tr>

                <tr>
                    <td colspan="2">
                        <span>Puasa </span><br>
                        <span>Minum Terakhir Jam : <?= isset($data->question7->minum)?$data->question7->minum:'' ?> </span><br>
                        <span>Makan Terakhir  Jam : <?= isset($data->question7->makan)?$data->question7->makan:'' ?> </span>
                        <p style="font-weight:bold">Rencana Anestesi : </p>
                        <span>ASA : <?= isset($data->rencana[0]->asa)?$data->rencana[0]->asa:'' ?></span>&nbsp;&nbsp;&nbsp;
                        <span>Ket : <?= isset($data->rencana[0]->ket)?$data->rencana[0]->ket:'' ?></span>&nbsp;&nbsp;&nbsp;
                        

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
            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:450px">
                Rev.08.02.2021. RM-019e / RI
                </div>
           </div>
            </div>
           
        </div>

      
    </body>
    </html>

   