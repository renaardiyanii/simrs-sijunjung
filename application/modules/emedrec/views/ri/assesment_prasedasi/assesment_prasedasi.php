<?php
$data = (isset($prasedasi->formjson)?json_decode($prasedasi->formjson):'');
// var_dump($data);
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
            font-size: 12px;
            position: relative;
        }

        #data tr td{
            
            font-size: 12px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>ASSESMENT PRA SEDASI</h4></center>

            <table width="100%" id="data" border="1" cellpadding="4px">
                <tr>
                    <td width="50%" colspan="2">Rencana prosedur : <?= isset($data->rencana_prosedur)?$data->rencana_prosedur:'' ?></td>
                </tr>
                <tr>
                    <td width="50%" colspan="2">Diagnosa sebelum  prosedur :  <?= isset($data->diagnosa_sebelum)?$data->diagnosa_sebelum:'' ?></td>
                </tr>
                <tr>
                    <td width="50%" colspan="2">
                        Jenis  prosedur : &nbsp;&nbsp;&nbsp; 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->jenis_prosedur)? $data->jenis_prosedur == "cito" ? "checked":'':'' ?>>
                            <span>Cito </span>&nbsp;&nbsp;&nbsp;
                            <input type="checkbox" value="Tidak"  <?php echo isset($data->jenis_prosedur)? $data->jenis_prosedur == "elektif" ? "checked":'':'' ?>>
                            <span>Elektif </span>
                    </td>
                </tr>
                <tr>
                    <td width="50%" colspan="2">
                       <span>Berat badan : <?= isset($data->question1->bb)?$data->question1->bb:'' ?> kg</span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <span>Tinggi badan  : <?= isset($data->question1->tb)?$data->question1->tb:'' ?> cm</span> 
                    </td>
                </tr>
                <tr>
                    <td width="50%" colspan="2">
                        <span>Riwayat penyakit lain : <?= isset($data->question1->penyakit)?$data->question1->penyakit:'' ?></span>
                        <p style="min-height:80px"></p>
                    </td>
                </tr>
               
                <tr>
                    <td colspan="2">
                        <table width="100%">
                            <tr>
                                <td width="35%">Riwayat merokok : <br><br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->meroko)? $data->riwayat->{'Row 1'}->meroko == "ya" ? "checked":'':'' ?>>
                                    <span>Ya </span><br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->meroko)? $data->riwayat->{'Row 1'}->meroko == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                </td>
                                <td width="35%">Riwayat Alkohol	<br><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->alkohol)? $data->riwayat->{'Row 1'}->alkohol == "ya" ? "checked":'':'' ?>>
                                    <span>Ya </span><br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->alkohol)? $data->riwayat->{'Row 1'}->alkohol == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                </td>
                                <td width="30%">Riwayat Narkoba<br><br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->narkoba)? $data->riwayat->{'Row 1'}->narkoba == "ya" ? "checked":'':'' ?>>
                                    <span>Ya</span><br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->narkoba)? $data->riwayat->{'Row 1'}->narkoba == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                </td>
                            </tr>
                        </table><br>
                        <span>Riwayat pemakaian obat lain : <?= isset($data->riwayat->{'Row 1'}->narkoba)? $data->riwayat->{'Row 1'}->obat_lain:'' ?></span>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <span>Riwayat efek samping dengan sedasi, analgesia, anestesia regional atau umum</span><br><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->efek)? $data->riwayat->{'Row 1'}->efek == "ya" ? "checked":'':'' ?>>
                            <span>Ya <?=isset($data->riwayat->{'Row 1'}->ya)?$data->riwayat->{'Row 1'}->ya:'' ?></span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat->{'Row 1'}->efek)? $data->riwayat->{'Row 1'}->efek == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak </span>
                    </td>
                </tr>

                <tr>
                    <td>Penilaian Sistem  </td>
                    <td>Pemeriksaan Fisik  </td>
                </tr>

                <tr>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td width="10%"></td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->nyeri)? $data->penilaian_sistem->{'Row 1'}->nyeri == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Nyeri</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->nyeri)? $data->penilaian_sistem->{'Row 1'}->nyeri == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">A</td>
                            </tr>

                            <tr>
                                <td width="10%">N</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->neurologi)? $data->penilaian_sistem->{'Row 1'}->neurologi == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Neurologi</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->neurologi)? $data->penilaian_sistem->{'Row 1'}->neurologi == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">B</td>
                            </tr>

                            <tr>
                                <td width="10%">O</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->kardiovaskuler)? $data->penilaian_sistem->{'Row 1'}->kardiovaskuler == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Kardiovaskuler</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->kardiovaskuler)? $data->penilaian_sistem->{'Row 1'}->kardiovaskuler == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">N</td>
                            </tr>

                            <tr>
                                <td width="10%">R</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->respirasi)? $data->penilaian_sistem->{'Row 1'}->respirasi == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Respirasi</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->respirasi)? $data->penilaian_sistem->{'Row 1'}->respirasi == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">O</td>
                            </tr>

                            <tr>
                                <td width="10%">M</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->saluran_pencemaran)? $data->penilaian_sistem->{'Row 1'}->saluran_pencemaran == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Saluran pencemaran</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->saluran_pencemaran)? $data->penilaian_sistem->{'Row 1'}->saluran_pencemaran == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">R</td>
                            </tr>

                            <tr>
                                <td width="10%">A</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->ginjal)? $data->penilaian_sistem->{'Row 1'}->ginjal == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Ginjal dan saluran kemih</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->ginjal)? $data->penilaian_sistem->{'Row 1'}->ginjal == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">M</td>
                            </tr>

                            <tr>
                                <td width="10%">L</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->endokrin)? $data->penilaian_sistem->{'Row 1'}->endokrin == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Endokrin/ metabolik </td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->endokrin)? $data->penilaian_sistem->{'Row 1'}->endokrin == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">A</td>
                            </tr>

                            <tr>
                                <td width="10%"></td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->kemungkinan_hamil)? $data->penilaian_sistem->{'Row 1'}->kemungkinan_hamil == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Kemungkinan hamil	 </td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->penilaian_sistem->{'Row 1'}->kemungkinan_hamil)? $data->penilaian_sistem->{'Row 1'}->kemungkinan_hamil == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">L</td>
                            </tr>

                            <tr>
                                <td width="10%">Ya</td>
                                <td width="10%"></td>
                                <td width="50%"></td>
                                <td width="15%"></td>
                                <td width="15%">Tidak</td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%">
                        <table width="100%">
                            <tr>
                                <td width="10%"></td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->jantung)? $data->pemeriksaan_fisik->{'Row 1'}->jantung == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Jantung	</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->jantung)? $data->pemeriksaan_fisik->{'Row 1'}->jantung == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">A</td>
                            </tr>

                            <tr>
                                <td width="10%">N</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->paru)? $data->pemeriksaan_fisik->{'Row 1'}->paru == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Paru</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->paru)? $data->pemeriksaan_fisik->{'Row 1'}->paru == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">B</td>
                            </tr>

                            <tr>
                                <td width="10%">O</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->abdomen)? $data->pemeriksaan_fisik->{'Row 1'}->abdomen == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Abdomen</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->abdomen)? $data->pemeriksaan_fisik->{'Row 1'}->abdomen == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">N</td>
                            </tr>

                            <tr>
                                <td width="10%">R</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->kesadaran)? $data->pemeriksaan_fisik->{'Row 1'}->kesadaran == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Kesadaran</td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->kesadaran)? $data->pemeriksaan_fisik->{'Row 1'}->kesadaran == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">O</td>
                            </tr>

                            <tr>
                                <td width="10%">M</td>
                                <td width="10%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->lainnya)? $data->pemeriksaan_fisik->{'Row 1'}->lainnya == "normal" ? "checked":'':'' ?>></td>
                                <td width="50%">Lain – lain </td>
                                <td width="15%"><input type="checkbox" value="Tidak" <?php echo isset($data->pemeriksaan_fisik->{'Row 1'}->lainnya)? $data->pemeriksaan_fisik->{'Row 1'}->lainnya == "abnormal" ? "checked":'':'' ?>></td>
                                <td width="15%">R</td>
                            </tr>

                            <tr>
                                <td width="10%">A</td>
                                <td width="10%"><input type="checkbox" value="Tidak" ></td>
                                <td width="50%"></td>
                                <td width="15%"><input type="checkbox" value="Tidak" ></td>
                                <td width="15%">M</td>
                            </tr>

                            <tr>
                                <td width="10%">L</td>
                                <td width="10%"><input type="checkbox" value="Tidak" ></td>
                                <td width="50%"> </td>
                                <td width="15%"><input type="checkbox" value="Tidak" ></td>
                                <td width="15%">A</td>
                            </tr>

                            <tr>
                                <td width="10%"></td>
                                <td width="10%"><input type="checkbox" value="Tidak" ></td>
                                <td width="50%"></td>
                                <td width="15%"><input type="checkbox" value="Tidak" ></td>
                                <td width="15%">L</td>
                            </tr>

                            <tr>
                                <td width="10%">Ya</td>
                                <td width="10%"><input type="checkbox" value="Tidak" ></td>
                                <td width="50%"></td>
                                <td width="15%"><input type="checkbox" value="Tidak" ></td>
                                <td width="15%">Tidak</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span>Catatan tambahan : </span>
                        <p style="min-height:250px"><?= isset($data->catatan)?$data->catatan:'' ?></p>
                    </td>
                </tr>
            </table>
            
            <br><br><br>
            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 4
                </div>
                <div style="margin-left:570px">
                RM-019f / RI
                </div>
           </div>
                
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>ASSESMENT PRA SEDASI</h4></center>

            <table width="100%" id="data" border="1" cellpadding="4px">
                <tr>
                    <td>
                        <center><span style="font-weight:bold;text-align:center;font-size:12px">PENILAIAN SEBELUM SEDASI</span><center>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="10%">
                                    <input  type="checkbox" value="Tidak" <?php echo isset($data->status_asa)? $data->status_asa == "normal" ? "checked":'':'' ?>>
                                    <span>I </span> 
                                </td>
                                <td width="2%">:</td>
                                <td>Normal/ sehat</td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <input  type="checkbox" value="Tidak" <?php echo isset($data->status_asa)? $data->status_asa == "ringan" ? "checked":'':'' ?>>
                                    <span>II </span> 
                                </td>
                                <td width="2%">:</td>
                                <td>Penyakit sistemik ringan</td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <input  type="checkbox" value="Tidak" <?php echo isset($data->status_asa)? $data->status_asa == "berat" ? "checked":'':'' ?>>
                                    <span>III </span> 
                                </td>
                                <td width="2%">:</td>
                                <td>Penyakit sistemik berat</td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <input  type="checkbox" value="Tidak" <?php echo isset($data->status_asa)? $data->status_asa == "nyawa" ? "checked":'':'' ?>>
                                    <span>IV </span> 
                                </td>
                                <td width="2%">:</td>
                                <td>Penyakit yang mengancam nyawa</td>
                            </tr>
                            <tr>
                                <td width="10%">
                                    <input  type="checkbox" value="Tidak" <?php echo isset($data->status_asa)? $data->status_asa == "bertahan_hidup" ? "checked":'':'' ?>>
                                    <span>V </span> 
                                </td>
                                <td width="2%">:</td>
                                <td>Tidak dapat bertahan hidup dengan/ tanpa prosedur</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Penilaian Jalan Nafas  :  </span>
                            <input  type="checkbox" value="Tidak" <?php echo isset($data->jalan_nafas)? $data->jalan_nafas == "normal" ? "checked":'':'' ?>>
                            <span>Normal </span> &nbsp; &nbsp; &nbsp; &nbsp;
                            <input  type="checkbox" value="Tidak" <?php echo isset($data->jalan_nafas)? $data->jalan_nafas == "abnormal" ? "checked":'':'' ?>>
                            <span>Abnormal </span> <br><br>

                        <span>Skor Mallampati</span><br><br><br>
                        <span>Abnormal</span>
                        <table width="100%">
                            <tr>
                                <td width="50%">
                                    <input  type="checkbox" value="Tidak" <?= (isset($data->abnormal)?in_array("jarak", $data->abnormal)?'checked':'':'') ?>>
                                    <span>Jarak hyoid – mental (< 3 jari dewasa)	 </span> 
                                </td>
                                <td width="50%">
                                    <input  type="checkbox" value="Tidak" <?= (isset($data->abnormal)?in_array("buka_mulut", $data->abnormal)?'checked':'':'') ?>>
                                    <span>Leher pendek/ ekstensi leher terganggu	 </span> 
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <input  type="checkbox" value="Tidak" <?= (isset($data->abnormal)?in_array("leher", $data->abnormal)?'checked':'':'') ?>>
                                    <span>Buka mulut sempit (< 3 jari dewasa)</span> 
                                </td>
                                <td width="50%">
                                    <input  type="checkbox" value="Tidak" <?= (isset($data->abnormal)?in_array("uvula", $data->abnormal)?'checked':'':'') ?>>
                                    <span>Uvula tidak tampak </span> 
                                </td>
                            </tr>
                        </table><br>
                        <span>Lain-lain : </span><br><br>
                            <input  type="checkbox" value="Tidak" <?= (isset($data->lain)?in_array("gigi", $data->lain)?'checked':'':'') ?>>
                            <span>Gigi berantakan/ maju/ gigi palsu/ kawat gigi/ gigi tambahan/ gigi goyang </span><br>
                            <input  type="checkbox" value="Tidak" <?= (isset($data->lain)?in_array("pembengkakan", $data->lain)?'checked':'':'') ?>>
                            <span>Pembengkakan wajah dan leher </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input  type="checkbox" value="Tidak" <?= (isset($data->lain)?in_array("other", $data->lain)?'checked':'':'') ?>>
                            <span>Lain-lain : <?= isset($data->{'lain-Comment'})?$data->{'lain-Comment'}:'' ?> </span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span>Status Puasa</span><br><br>
                            <input  type="checkbox" value="Tidak" <?php echo isset($data->question3->text1)? $data->question3->text1 != null ? "checked":'':'' ?>>
                            <span>Makan terakhir jam : <?= isset($data->question3->text1)?$data->question3->text1:'' ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input  type="checkbox" value="Tidak" <?php echo isset($data->question3->minum)? $data->question3->minum != null ? "checked":'':'' ?>>
                            <span>Minum terakhir jam : <?= isset($data->question3->minum)?$data->question3->minum:'' ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>>
                        <span><i>Informed Consent</i></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <center><span style="font-weight:bold;text-align:center;font-size:12px">RINGKASAN PROSEDUR SEDASI</span><center>
                    </td>
                </tr>
                <tr>
                    <td>
                    Prosedur yang dilakukan : <?= isset($data->question4->{'Row 1'}->prosedur)?$data->question4->{'Row 1'}->prosedur:'' ?>
                    </td>
                </tr>
                <tr>
                    <td>
                    Diagnosa setelah  prosedur :  <?= isset($data->question4->{'Row 1'}->diagnosa_setelah)?$data->question4->{'Row 1'}->diagnosa_setelah:'' ?>
                    </td>
                </tr>
                <tr>
                    <td>
                    Spesimen  :
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->question4->{'Row 1'}->spesimen)? $data->question4->{'Row 1'}->spesimen == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span>
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->question4->{'Row 1'}->spesimen)? $data->question4->{'Row 1'}->spesimen == "ya" ? "checked":'':'' ?>>
                        <span>Ya ........</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        Respon Komplikasi :  
                        <p style="min-height:40px"><?= isset($data->question4->{'Row 1'}->komplikasi)?$data->question4->{'Row 1'}->komplikasi:'' ?></p>

                    </td>
                </tr>
                <tr>
                    <td>
                     Reversal : 
                        <p style="min-height:40px"><?= isset($data->question4->{'Row 1'}->reversal)?$data->question4->{'Row 1'}->reversal:'' ?></p>

                    </td>
                </tr>
                 <tr>
                    <td>
                        Catatan  :
                        <p style="min-height:150px"><?= isset($data->question4->{'Row 1'}->catatan1)?$data->question4->{'Row 1'}->catatan1:'' ?></p>

                    </td>
                </tr>
            </table>

            <br><br><br><br>
            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 2 dari 4
                </div>
                <div style="margin-left:570px">
                RM-019f / RI
                </div>
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>ASSESMENT PRA SEDASI</h4></center>

            <table width="100%" id="data" border="1" cellpadding="3px">
                <tr>
                    <td colspan="7"><center><span style="font-weight:bold">MONITORING PROSEDUR SEDASI</span></center></td>
                </tr>
                <tr>
                    <td colspan="4">Jam Mulai : <?= isset($data->question5->mulai)?$data->question5->mulai:'' ?></td>
                    <td colspan="3">Jam Selesai : <?= isset($data->question5->selesai)?$data->question5->selesai:'' ?></td>
                </tr>
                <tr>
                    <td width="10%">Waktu</td>
                    <td width="15%">Tekanan Darah</td>
                    <td width="10%">Laju Nadi</td>
                    <td width="15%">Laju Nafas</td>
                    <td width="10%">Saturasi</td>
                    <td width="30%">Obat</td>
                    <td width="10%">Dosis</td>
                </tr>
                <tr>
                    <td><br></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table><br>

            <table width="100%" id="data" border="1" cellpadding="3px">
                <tr>
                    <th colspan="6">KRITERIA PEMULIHAN PASCA SEDASI UMUM ANAK (STEWARD SCORE)</th>
                </tr>
                <tr>
                    <th width="15%" colspan="2">SKOR</th>
                    <th width="30%">KRITERIA</th>
                    <th width="15%">MULAI OBSERVASI</th>
                    <th width="15%">15 Menit </th>
                    <th width="20%">SELESAI OBSERVASI</th>
                </tr>
                <tr>
                    <td rowspan="3">KESADARAN</td>
                    <td>2</td>
                    <td>Bangun</td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'1'})? $data->kriteria->{'Row 1'}->{'1'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'1'})? $data->kriteria->{'Row 2'}->{'1'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'1'})? $data->kriteria->{'Row 3'}->{'1'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Adanya respon terhadap rangsang </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'1'})? $data->kriteria->{'Row 1'}->{'1'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'1'})? $data->kriteria->{'Row 2'}->{'1'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'1'})? $data->kriteria->{'Row 3'}->{'1'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Tidak ada respon </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'1'})? $data->kriteria->{'Row 1'}->{'1'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'1'})? $data->kriteria->{'Row 2'}->{'1'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'1'})? $data->kriteria->{'Row 3'}->{'1'} == "0" ? "√":'':'' ?></td>
                </tr>


                <tr>
                    <td rowspan="3">RESPIRASI</td>
                    <td>2</td>
                    <td>Batuk / Menangis </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'2'})? $data->kriteria->{'Row 1'}->{'2'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'2'})? $data->kriteria->{'Row 2'}->{'2'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'2'})? $data->kriteria->{'Row 3'}->{'2'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Berusaha bernafas </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'2'})? $data->kriteria->{'Row 1'}->{'2'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'2'})? $data->kriteria->{'Row 2'}->{'2'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'2'})? $data->kriteria->{'Row 3'}->{'2'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Perlu bantuan bernafas  </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'2'})? $data->kriteria->{'Row 1'}->{'2'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'2'})? $data->kriteria->{'Row 2'}->{'2'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'2'})? $data->kriteria->{'Row 3'}->{'2'} == "0" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    <td rowspan="3">MOTORIK</td>
                    <td>2</td>
                    <td>Gerakan bertujuan </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'3'})? $data->kriteria->{'Row 1'}->{'3'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'3'})? $data->kriteria->{'Row 2'}->{'3'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'3'})? $data->kriteria->{'Row 3'}->{'3'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Gerakan tanpa tujuan  </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'3'})? $data->kriteria->{'Row 1'}->{'3'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'3'})? $data->kriteria->{'Row 2'}->{'3'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'3'})? $data->kriteria->{'Row 3'}->{'3'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Tidak bergerak  </td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 1'}->{'3'})? $data->kriteria->{'Row 1'}->{'3'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 2'}->{'3'})? $data->kriteria->{'Row 2'}->{'3'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->kriteria->{'Row 3'}->{'3'})? $data->kriteria->{'Row 3'}->{'3'} == "0" ? "√":'':'' ?></td>
                </tr>
                <?php 
                $satu = isset($data->kriteria->{'Row 1'}->total_skor)?$data->kriteria->{'Row 1'}->total_skor:'';
                $dua =  isset($data->kriteria->{'Row 2'}->total_skor)?$data->kriteria->{'Row 2'}->total_skor:'';
                $tiga =  isset($data->kriteria->{'Row 3'}->total_skor)?$data->kriteria->{'Row 3'}->total_skor:'';
                $jmlh_skor = $satu + $dua + $tiga;
                ?>
                <tr>
                    <td colspan="6"><span style="font-weight:bold">TOTAL  SKOR : <?= isset($jmlh_skor)?$jmlh_skor:'' ?></span></td>
                </tr>

                <tr>
                    <td colspan="6"><span>Skor  > 5 boleh pindah ruangan  </span></td>
                </tr>

                <tr>
                    <th colspan="6">KRITERIA PEMULIHAN PASCA SEDASI UMUM DEWASA (ALDRETE SCORE )</th>
                </tr>

                <tr>
                    <th width="15%" colspan="2">SKOR</th>
                    <th width="30%">KRITERIA</th>
                    <th width="15%">MULAI OBSERVASI</th>
                    <th width="15%">15 Menit </th>
                    <th width="20%">SELESAI OBSERVASI</th>
                </tr>

                <tr>
                    <td rowspan="3">MOTORIK</td>
                    <td>2</td>
                    <td>Dapat menggerakkan 4 ekstremitas</td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'1'})? $data->question6->{'Row 1'}->{'1'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'1'})? $data->question6->{'Row 2'}->{'1'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'1'})? $data->question6->{'Row 3'}->{'1'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Dapat menggerakkan 2 ekstremitas  </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'1'})? $data->question6->{'Row 1'}->{'1'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'1'})? $data->question6->{'Row 2'}->{'1'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'1'})? $data->question6->{'Row 3'}->{'1'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Tidak dapat menggerakkan ekstremitas   </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'1'})? $data->question6->{'Row 1'}->{'1'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'1'})? $data->question6->{'Row 2'}->{'1'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'1'})? $data->question6->{'Row 3'}->{'1'} == "0" ? "√":'':'' ?></td>
                </tr>


                <tr>
                    <td rowspan="3">RESPIRASI</td>
                    <td>2</td>
                    <td>Mampu nafas dalam dan batuk</td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'2'})? $data->question6->{'Row 1'}->{'2'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'2'})? $data->question6->{'Row 2'}->{'2'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'2'})? $data->question6->{'Row 3'}->{'2'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Sesak nafas / nafas terbatas  </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'2'})? $data->question6->{'Row 1'}->{'2'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'2'})? $data->question6->{'Row 2'}->{'2'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'2'})? $data->question6->{'Row 3'}->{'2'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Apnoe   </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'2'})? $data->question6->{'Row 1'}->{'2'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'2'})? $data->question6->{'Row 2'}->{'2'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'2'})? $data->question6->{'Row 3'}->{'2'} == "0" ? "√":'':'' ?></td>
                </tr>


                <tr>
                    <td rowspan="3">SIRKULASI</td>
                    <td>2</td>
                    <td>Perbedaan TD < 20% dari TD pre sedasi</td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'3'})? $data->question6->{'Row 1'}->{'3'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'3'})? $data->question6->{'Row 2'}->{'3'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'3'})? $data->question6->{'Row 3'}->{'3'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Perbedaan TD 20% s/d 50% dari TD pre sedasi  </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'3'})? $data->question6->{'Row 1'}->{'3'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'3'})? $data->question6->{'Row 2'}->{'3'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'3'})? $data->question6->{'Row 3'}->{'3'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Perbedaan TD > 50% dari TD pre sedasi   </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'3'})? $data->question6->{'Row 1'}->{'3'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'3'})? $data->question6->{'Row 2'}->{'3'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'3'})? $data->question6->{'Row 3'}->{'3'} == "0" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    <td rowspan="3">KESADARAN</td>
                    <td>2</td>
                    <td>Sadar penuh</td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'4'})? $data->question6->{'Row 1'}->{'4'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'4'})? $data->question6->{'Row 2'}->{'4'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'4'})? $data->question6->{'Row 3'}->{'4'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Bangun bila dipanggil  </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'4'})? $data->question6->{'Row 1'}->{'4'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'4'})? $data->question6->{'Row 2'}->{'4'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'4'})? $data->question6->{'Row 3'}->{'4'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Tidak ada respon bila dipanggil    </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'4'})? $data->question6->{'Row 1'}->{'4'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'4'})? $data->question6->{'Row 2'}->{'4'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'4'})? $data->question6->{'Row 3'}->{'4'} == "0" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    <td rowspan="3">PERIFER</td>
                    <td>2</td>
                    <td>Warna kulit kemerahan </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'5'})? $data->question6->{'Row 1'}->{'5'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'5'})? $data->question6->{'Row 2'}->{'5'} == "2" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'5'})? $data->question6->{'Row 3'}->{'5'} == "2" ? "√":'':'' ?></td>
                </tr>

                <tr>
                   
                    <td>1</td>
                    <td>Pucat / bercak-bercak   </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'5'})? $data->question6->{'Row 1'}->{'5'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'5'})? $data->question6->{'Row 2'}->{'5'} == "1" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'5'})? $data->question6->{'Row 3'}->{'5'} == "1" ? "√":'':'' ?></td>
                </tr>

                <tr>
                    
                    <td>0</td>
                    <td>Sianosis     </td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 1'}->{'5'})? $data->question6->{'Row 1'}->{'5'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 2'}->{'5'})? $data->question6->{'Row 2'}->{'5'} == "0" ? "√":'':'' ?></td>
                    <td style="text-align:center"><?php echo isset($data->question6->{'Row 3'}->{'5'})? $data->question6->{'Row 3'}->{'5'} == "0" ? "√":'':'' ?></td>
                </tr>
                <?php 
                $satu1 = isset($data->question6->{'Row 1'}->total_skor)?$data->question6->{'Row 1'}->total_skor:'';
                $dua2 =  isset($data->question6->{'Row 2'}->total_skor)?$data->question6->{'Row 2'}->total_skor:'';
                $tiga3 =  isset($data->question6->{'Row 3'}->total_skor)?$data->question6->{'Row 3'}->total_skor:'';
                 $jmlh_skor1 = $satu1 + $dua2 + $tiga3;
                ?>
                <tr>
                    <td colspan="6"><span style="font-weight:bold">TOTAL  SKOR : <?= isset($jmlh_skor1)?$jmlh_skor1:'' ?></span></td>
                </tr>

                <tr>
                    <td colspan="6"><span>Skor  > 9 boleh pindah ruangan  </span></td>
                </tr>
            </table>
            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 3 dari 4
                </div>
                <div style="margin-left:570px">
                RM-019f / RI
                </div>
           </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>ASSESMENT PRA SEDASI</h4></center>
            <table width="100%" id="data" border="1" cellpadding="3px">
                <tr>
                    <th>INSTRUKSI SETELAH PROSEDUR SEDASI</th>
                </tr>
                <tr>
                    <td>
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->anakdewasa)? $data->anakdewasa == "anak" ? "checked":'':'' ?>>
                        <span>Pasien anak-anak</span> 
                        <ol>
                            <li>Memberitahukan pada keluarga pasien, jangan memberikan makanan atau minuman jika anak anda belum benar-benar sadar penuh.</li>
                            <li>Memberitahukan pada keluarga pasien, jangan membiarkan anak anda melakukan permainan yang membutuhkan koordinasi keseimbangan dan kekuatan tertentu. Hindari berenang, naik sepeda, memanjat, naik tangga untuk delapan jam karena dapat mengakibatkan cedera yang tidak diinginkan.</li>
                            <li>Memberitahukan pada keluarga pasien, selalu mengawasi anak anda jika anak tersebut terbiasa main di luar rumah.</li>
                            <li>Memberitahukan pada keluarga pasien, untuk menjauhkan sementara anak anda dari alat-alat listrik, alat memasak selama delapan jam.</li>
                        </ol>


                        <input  type="checkbox" value="Tidak" <?php echo isset($data->anakdewasa)? $data->anakdewasa == "dewasa" ? "checked":'':'' ?>>
                        <span>Pasien dewasa</span> 
                        <ol>
                            <li>Memberitahukan pada pasien sebaiknya tidak melakukan aktivitas berbahaya, mengendarai mobil, berenang, mengoperasikan peralatan ataupun melakukan pekerjaan di ketinggian untuk sementara waktu, sampai efek obat tersebut hilang.</li>
                            <li>Memberitahukan pada pasien mungkin merasa pusing, merasa lemah untuk sementara waktu. Hal tersebut wajar terjadi untuk beberapa jam. Setelah anda merasa siap untuk makan dan minum, anda boleh mencoba dengan minum air putih terlebih dahulu. Jika setelah mencoba minum air putih anda tidak muntah anda boleh mencoba makan.</li>
                            <li>Memberitahukan pada pasien jika mendapat obat pereda sakit untuk dibawa pulang, anda harus menanyakan kepada dokter anda kapan anda harus meminum obat pereda sakit tersebut.</li>
                            <li>Memberitahukan pada pasien tidak boleh meminum alkohol, obat tidur atau obat-obatan yang membuat anda mengantuk selama 24 jam.</li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>Pemulangan Pasien :  </p>
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->question8)? $data->question8 == "rawatjalan" ? "checked":'':'' ?>>
                        <span>Rawat Jalan</span> <br>
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->question8)? $data->question8 == "rawatinap" ? "checked":'':'' ?>>
                        <span>Rawat Inap</span> <br>
                        <input  type="checkbox" value="Tidak" <?php echo isset($data->question8)? $data->question8 == "other" ? "checked":'':'' ?>>
                        <span>Lain-lain</span> 
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td width="50%" style="text-align:center">
                                <span> </span><br><br>
                                    <p>Dokter Anestesi</p>
                                    <img  src="<?= (isset($data->ttd)?$data->ttd:'')?>" width="50px"  height="50px" alt=""><br><br>
                                    (<?= isset($data->nama1)?$data->nama1:'' ?>)<br>
                                    <span>Tanda Tangan & Nama Terang</span>
                                </td>
                                <td style="text-align:center"><br>
                                <span>Bukittinggi,<?= isset($data->bukit)?date('d/m/Y', strtotime($data->bukit)):'' ?> Jam : <?= isset($data->bukit)?date('h:i:s', strtotime($data->bukit)):'' ?></span>
                                    <p>  Perawat </p>
                                    <img  src="<?= (isset($data->ttd2)?$data->ttd2:'')?>" width="50px"  height="50px" alt=""><br><br>
                                    (<?= isset($data->question9)?$data->question9:'' ?>)<br>
                                    <span>Tanda Tangan & Nama Terang</span>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 4 dari 4
                </div>
                <div style="margin-left:570px">
                RM-019f / RI
                </div>
           </div>
        </div>

        
    </body>
    </html>

   