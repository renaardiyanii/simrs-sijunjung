<?php
$data = (isset($asuhan_gizi->formjson)?json_decode($asuhan_gizi->formjson):'');
//var_dump($diag_masuk);
?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
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
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASUHAN GIZI</p>
            <div style="font-size:12px">

            <span style="font-size: 12px;">Diagnosa Medis	: <?= isset($diag_masuk->diagnosa)?'('.$diag_masuk->id_diagnosa.')'.$diag_masuk->diagnosa:'' ?></span>

                <table id="data" border="1" cellpadding="5px">

                        <tr>
                            <td>
                                <span>Tanggal	: <?= isset($data->tgl)?$data->tgl:'' ?></span>
                                <span style="margin-left: 200px;">Jam  : <?= isset($data->jam)?$data->jam:'' ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;"><b>Asesmen</b></td>
                        </tr>
                        <tr>
                            <td>
                                <span><b>Antropometri</b></span><br>
                                <table width="65%">
                                    <tr>
                                        <td width="10%">BB</td>
                                        <td width="2%">:</td>
                                        <td width="10%"><?= isset($data->antropometri->row->berat_badan)?$data->antropometri->row->berat_badan:'' ?></td>
                                        <td width="15%">kg / LLA</td>
                                        <td width="2%">:</td>
                                        <td width="15%"><?= isset($data->antropometri->row->lla1)?$data->antropometri->row->lla1:'' ?></td>
                                    </tr>

                                    <tr>
                                        <td><p>TB</p></td>
                                        <td><p>:</p></td>
                                        <td><p><?= isset($data->antropometri->row->tinggi_badan)?$data->antropometri->row->tinggi_badan:'' ?></p></td>
                                        <td><p>cm / tinggi lutut</p></td>
                                        <td><p>:</p></td>
                                        <td><p><?= isset($data->antropometri->row->tinggi_lutut1)?$data->antropometri->row->tinggi_lutut1:'' ?></p></td>
                                    </tr>

                                    <tr>
                                        <td>IMT</td>
                                        <td>:</td>
                                        <td><?= isset($data->antropometri->row->imt)?$data->antropometri->row->imt:'' ?></td>
                                        <td>kg / m²</td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td><p>Status Gizi</p></td>
                                        <td><p>:</p></td>
                                        <td><p><?= isset($data->antropometri->row->status_gizi)?$data->antropometri->row->status_gizi:'' ?></p></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span><b>Biokimia</b></span><br>
                                <table width="100%">
                                    <tr>
                                        <td width="50%"><p>
                                            <input type="checkbox" value="Glukosa darah" <?= (isset($data-> gula_darah)?in_array('glukosa_darah',$data->gula_darah)?'checked':'':'') ?>>
                                            <span>Glukosa darah <b><?= isset($data->check_guladarah)?$data->check_guladarah:'.....' ?></b> mg/dL (N < 140 mg/dL)</span></p>
                                        </td>
                                        <td width="50%"><p>
                                            <input type="checkbox" value="SGPT" <?= (isset($data-> sgpt)?in_array('sgpt',$data->sgpt)?'checked':'':'') ?>>
                                            <span>SGPT <b><?= isset($data->check_sgpt)?$data->check_sgpt:'.....' ?></b> U/L (N < 40 U/L) </span></p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="50%">
                                            <input type="checkbox" value="Ureum" <?= (isset($data-> ureum)?in_array('ureum',$data->ureum)?'checked':'':'') ?>>
                                            <span>Ureum <b><?= isset($data->check_ureum)?$data->check_ureum:'.....' ?></b> mg/dL (N = 20-50 mg/dL)  </span>
                                            </td>
                                            <td width="50%">
                                            <input type="checkbox" value="SGOT" <?= (isset($data-> sgot)?in_array('sgot',$data->sgot)?'checked':'':'') ?>>
                                            <span>SGOT <b><?= isset($data->check_sgot)?$data->check_sgot:'.....' ?></b> U/L (N < 35 U/L) </span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="50%"><p>
                                        <input type="checkbox" value="Kreatinin" <?= (isset($data-> kreatinim)?in_array('kreatinim',$data->kreatinim)?'checked':'':'') ?>>
                                        <span>Kreatinin <b><?= isset($data->check_kreatinim)?$data->check_kreatinim:'.....' ?></b> mg/dL (N =0,5-1,5 mg/dL)  </span></p>
                                        </td>
                                        <td width="50%"><p>
                                        <input type="checkbox" value="Albumin" <?= (isset($data-> albumin)?in_array('albumin',$data->albumin)?'checked':'':'') ?>>
                                        <span>Albumin <b><?= isset($data->check_albumin)?$data->check_albumin:'.....' ?></b> gr/dL (N=3,5-5,0 gr/dL)</span></p>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width="50%">
                                            <input type="checkbox" value="null" <?= (isset($data-> lainnya)?in_array('lainnya',$data->lainnya)?'checked':'':'') ?>>
                                            <span>Lainnya <?= isset($data->check_lainnya)?$data->check_lainnya:'.....' ?></span>
                                            </td>
                                            <!-- <td width="50%">
                                            <input type="checkbox" value="null" <?= (isset($data-> gula_darah)?in_array('glukosa_darah',$data->gula_darah)?'checked':'':'') ?>>
                                            <span>........</span>
                                        </td> -->
                                    </tr>

                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td><div style="min-height:50px">
                            <b>Klinik / Fisik</b><br>
                            <pre><?= isset($data->klinik_fisik)?$data->klinik_fisik:''?><pre>
                        </div></td>
                        </tr>

                        <tr>
                            <td>
                                <span><b>Riwayat Gizi</b></span><br>
                                <p>
                                    <table width="60%" border="1">
                                        <tr>
                                            <td width="40%" style="font-weight:bold"><p>Alergi Makanan</p></td>
                                            <td width="10%" style="font-weight:bold;text-align:center" ><p>Ya</p></td>
                                            <td width="10%" style="font-weight:bold;text-align:center"><p>Tidak</p></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">1.	Telur</td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->telur)?$data->table_alergi[0]->telur == 'ya'?'√':'':'') ?></td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->telur)?$data->table_alergi[0]->telur == 'tidak'?'√':'':'') ?></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">2.	Susu sapi & produk olahan</td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->susu_sapi)?$data->table_alergi[0]->susu_sapi == 'ya'?'√':'':'') ?></td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->susu_sapi)?$data->table_alergi[0]->susu_sapi == 'tidak'?'√':'':'') ?></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">-	Kacang kedelai / tanah</td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->kacang)?$data->table_alergi[0]->kacang == 'ya'?'√':'':'') ?></td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->kacang)?$data->table_alergi[0]->kacang == 'tidak'?'√':'':'') ?></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">-	Gluten / gandum</td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->gulten)?$data->table_alergi[0]->gulten == 'ya'?'√':'':'') ?></td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->gulten)?$data->table_alergi[0]->gulten == 'tidak'?'√':'':'') ?></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">-	Udang</td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->udang)?$data->table_alergi[0]->udang == 'ya'?'√':'':'') ?></td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->udang)?$data->table_alergi[0]->udang == 'tidak'?'√':'':'') ?></td>
                                        </tr>
                                        <tr>
                                            <td width="40%">-	Ikan</td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->ikan)?$data->table_alergi[0]->ikan == 'ya'?'√':'':'') ?></td>
                                            <td width="10%" style="text-align:center"><?= (isset($data->table_alergi[0]->ikan)?$data->table_alergi[0]->ikan == 'tidak'?'√':'':'') ?></td>
                                        </tr>
                                    </table>
                                </p>

                                <div>
                                        <p style="font-weight:bold;">Pola Makan :</p>
                                        <p style="min-height:50px"><?= isset($data->pola_makanan)?$data->pola_makanan:'' ?></p>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div style="min-height:50px">
                                    <span style="font-weight:bold;min-height:50px"><b>Riwayat Personal</b></span>
                                    <p><?= isset($data->riwayat_personal)?$data->riwayat_personal:'' ?></p>
                                </div>
                                
                            </td>
                        </tr>
                </table>

            </div>
            <br><br><br>
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

            <p align="center" style="font-weight:bold;font-size:16px">ASUHAN GIZI</p>
            <div style="font-size:12px">

            <table id="data" border="1">
                    <tr>
                        <td style="text-align: center;"><b>Diagnosis Gizi</b></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="min-height:180px;padding:1em;"><?= isset($data->diagnosis_gizi)?$data->diagnosis_gizi:'' ?></div>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><b>Intervensi Gizi</b></td>
                    </tr>
                    <tr>
                        <td>
                            <div style="padding:1em;">
                                <p>DPJP / dr. Sp.GK    : <?= isset($data->dpjp)?$data->dpjp:'' ?></p>
                                <span><u>Kebutuhan Gizi : </u></span><br>

                                <table width="100%" style="margin-left:25px">
                                    <tr>
                                        <td width="13%">Energi</td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->kebutuhan_gizi->energi)?$data->kebutuhan_gizi->energi.' '.'kalori':'' ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Protein</td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->kebutuhan_gizi->protein)?$data->kebutuhan_gizi->protein.' '.'gr':'' ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Lemak</td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->kebutuhan_gizi->lemak)?$data->kebutuhan_gizi->lemak.' '.'gr':'' ?></td>
                                    </tr>
                                    <tr>
                                        <td width="13%">Karbohidrat</td>
                                        <td width="2%">:</td>
                                        <td><?= isset($data->kebutuhan_gizi->karbohidrat)?$data->kebutuhan_gizi->karbohidrat.' '.'gr':'' ?></td>
                                    </tr>
                                </table>

                                <div style="min-height:80px">
                                    <p>Diit    : <?= isset($data->kebutuhan_gizi->diit)?$data->kebutuhan_gizi->diit:'' ?></p>
                                </div>
                            </div>
                        
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><b>Monitoring</b></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> monitoring)?in_array('item1',$data->monitoring)?'checked':'':'') ?>>
                            <span>Asupan Selama Dirawat</span>

                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> monitoring)?in_array('item2',$data->monitoring)?'checked':'':'') ?>>
                            <span>Data Biokimia</span>

                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> monitoring)?in_array('item3',$data->monitoring)?'checked':'':'') ?>>
                            <span>Data Fisik/Klinis</span>

                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> monitoring)?in_array('item4',$data->monitoring)?'checked':'':'') ?>>
                            <span>Kepatuhan Diet</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center;"><b>Evaluasi</b></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> evaluasi)?in_array('item1',$data->evaluasi)?'checked':'':'') ?>>
                            <span>Asupan Selama Dirawat</span>

                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> evaluasi)?in_array('item2',$data->evaluasi)?'checked':'':'') ?>>
                            <span>Data Biokimia</span>

                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> evaluasi)?in_array('item3',$data->evaluasi)?'checked':'':'') ?>>
                            <span>Data Fisik/Klinis</span>

                            <input type="checkbox" value="Kreatinin" <?= (isset($data-> evaluasi)?in_array('item4',$data->evaluasi)?'checked':'':'') ?>>
                            <span>Kepatuhan Diet</span>
                        </td>
                    </tr>
            </table>

            <table width="100%">
                <tr>
                    <td width="65%"></td>
                    <td>
                        <br>
                                <span>Tanggal <?= isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'' ?></span>
                                <span>, <?= isset($data->jam)?$data->jam:'' ?></span>
                         
                            <p style="text-align:center">Nutrisionis</p>
                            <center><img width="120px" src="<?= isset($ttd_user->ttd)?$ttd_user->ttd:''; ?>" alt=""><br><center>
                            <p style="text-align:center"><?= isset($asuhan_gizi->xuser)?$asuhan_gizi->xuser:'' ?></p>
                    </td>
                </tr>
            </table>

            </div>
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