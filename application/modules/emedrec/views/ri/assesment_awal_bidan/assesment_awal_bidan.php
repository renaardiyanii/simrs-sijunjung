<?php
$data = (isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'');
// var_dump($data->table);
?>

<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 5px;   
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 11px;
            
        }
        #bg-checked{
            background-color:#64C9CF;
            color:white;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
        
        <div class="A4 sheet  padding-fix-10mm">
                <header>
                    <?php $this->load->view('emedrec/ri/header_print') ?>
                </header>
                <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
                <div style="font-size:11px">
                    <span style="font-weight:bold">1. ASESMEN AWAL KEBIDANAN</span><br>
                    <span>diisi oleh bidan dengan cara memberi tanda "" pada kotak yang telah disediakan</span>

                    <table width="100%" id="data">
                        <tr>
                            <td width="15%">Tiba di ruangan</td>
                            <td width="5%">:</td>
                            <td width="40%">Tanggal <?= isset($data->asesmen[0]->tiba_diruangan)? date('d-m-Y',strtotime($data->asesmen[0]->tiba_diruangan)):''; ?></td>
                            <td width="140%">Jam  <?= isset($data->asesmen[0]->tiba_diruangan)? date('H-i',strtotime($data->asesmen[0]->tiba_diruangan)):''; ?></td>
                        </tr>

                        <tr>
                            <td width="15%">Pengkajian</td>
                            <td width="5%">:</td>
                            <td width="40%">Tanggal <?= isset($data->asesmen[0]->pengkajian)? date('d-m-Y',strtotime($data->asesmen[0]->pengkajian)):''; ?></td>
                            <td width="140%">Jam <?= isset($data->asesmen[0]->pengkajian)? date('H:i',strtotime($data->asesmen[0]->pengkajian)):''; ?></td>
                        </tr>

                        <tr>
                            <td width="15%"></td>
                            <td width="5%">:</td>
                            <td width="40%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->none)? $data->asesmen[0]->none == "auto_anamnesa" ? "checked":'':'' ?>>
                                <span>Auto Anamnesis</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->none)? $data->asesmen[0]->none == "allo_anamnesa" ? "checked":'':'' ?>>
                                <span>Allo Anamnesis</span>
                            </td>
                            <td width="140%">
                                
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->none)? $data->asesmen[0]->none == "hubungan" ? "checked":'':'' ?>>
                                <span>Hubungan :</span>
                            </td>
                        </tr>

                        <tr>
                            <td width="15%">Cara masuk</td>
                            <td width="5%">:</td>
                            <td width="40%" colspan="2">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->cara_masuk)? $data->asesmen[0]->cara_masuk == "jalan" ? "checked":'':'' ?>>
                                <span>Jalan</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->cara_masuk)? $data->asesmen[0]->cara_masuk == "kursi_roda" ? "checked":'':'' ?>>
                                <span>Kursi Roda</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->cara_masuk)? $data->asesmen[0]->cara_masuk == "brankar" ? "checked":'':'' ?>>
                                <span>Brankar</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->cara_masuk)? $data->asesmen[0]->cara_masuk == "other" ? "checked":'':'' ?>>
                                <span>Lain lain : <?= isset($data->asesmen[0]->{'cara_masuk-Comment'})?$data->asesmen[0]->{'cara_masuk-Comment'}:'' ?></span>
                            </td>
                            
                        </tr>

                        <tr>
                            <td width="15%">Asal masuk</td>
                            <td width="5%">:</td>
                            <td width="40%" colspan="2">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->asal_masuk)? $data->asesmen[0]->asal_masuk == "igd" ? "checked":'':'' ?>>
                                <span>IGD</span> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->asesmen[0]->asal_masuk)? $data->asesmen[0]->asal_masuk == "rawat_jalan" ? "checked":'':'' ?>>
                                <span>Rawat Jalan</span> 
                            </td>
                            
                        </tr>
                    </table>

                    <p>ALASAN MASUK</p>
                        <div style="min-height:30px">
                            <span>Keluhan Utama</span><br>
                            <span><?= isset($data->keluhan_utama)?$data->keluhan_utama:'' ?></span>
                        </div>

                        <p>RIWAYAT ALERGI</p>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->alergi)? $data->alergi == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak ada alergi</span>
                            <div style="display:flex">
                                <div>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->alergi_obat)?in_array("obat", $data->alergi_obat)?'checked':'':'') ?>>
                                    <span>Alergi obat, sebutkan : <?= isset($data->chek_obat)?$data->chek_obat:'' ?></span><br>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->alergi_makanan)?in_array("makanan", $data->alergi_makanan)?'checked':'':'') ?>>
                                    <span>Alergi makanan, sebutkan : <?= isset($data->question4)?$data->question4:'' ?></span><br>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->alergi_lainnya)?in_array("alergi_lainnya", $data->alergi_lainnya)?'checked':'':'') ?>>
                                    <span>Alergi lainnya, sebutkan : <?= isset($data->question5)?$data->question5:'' ?></span>
                                </div>
                                <div style="margin-left:30px">
                                    <span>Reaksi</span><br>
                                    <span>Reaksi</span><br>
                                    <span>Reaksi</span>

                                </div>
                            </div>

                            <input type="checkbox" value="Tidak" <?= (isset($data->gelang)?in_array("gelang_tanda", $data->gelang)?'checked':'':'') ?>>
                            <span>Gelang tanda alergi dipasang (warna merah)</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->tidak_diketahui)?in_array("tidak_diketahui", $data->tidak_diketahui)?'checked':'':'') ?>>
                            <span>Tidak Diketahui</span><br>

                            <span>Diberitahukan ke dokter/farmasi (apoteker)/dietsien</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->diberitahukan)? $data->diberitahukan == "ya" ? "checked":'':'' ?>>
                            <span>ya, pukul <?= isset($data->pukul)?$data->pukul:'' ?></span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->diberitahukan)? $data->diberitahukan == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>

                            <p><b>SKRINING NYERI</b></p>
                            <span>Nilai Nyeri Pain Score</span><br>
                            <!-- BUAT GAMBAR NYERI -->

                            <span><b>Keterangan :</b></span>
                            <table id="data" width="30%">
                                <tr>
                                    <td width="8%">0</td>
                                    <td width="2%">:</td>
                                    <td width="23%">Tidak Nyeri</td>
                                </tr>
                                <tr>
                                    <td width="5%">1 - 3</td>
                                    <td width="2%">:</td>
                                    <td width="23%">Nyeri Ringan</td>
                                </tr>
                                <tr>
                                    <td width="5%">4 - 7</td>
                                    <td width="2%">:</td>
                                    <td width="23%">Nyeri Sedang</td>
                                </tr>
                                <tr>
                                    <td width="5%">8 - 10</td>
                                    <td width="2%">:</td>
                                    <td width="23%">Nyeri Berat</td>
                                </tr>
                            </table>

                            <p>Nyeri
                                <input type="checkbox" value="Tidak" <?php echo isset($data->nyeri)? $data->nyeri == "other" ? "checked":'':'' ?>>
                                <span>ya, Lokasi <?= isset($data->{'nyeri-Comment'})?$data->{'nyeri-Comment'}:'' ?>, lanjutkan pada formulir pengkajian nyeri komprehensif</span><br>
                                <input type="checkbox" style="margin-left:40px" value="Tidak" <?php echo isset($data->nyeri)? $data->nyeri == "tidak" ? "checked":'':'' ?>>
                                <span>Tidak</span>
                            </p>

                            <p>Nyeri mempengaruhi</p>
                                <input type="checkbox" value="Tidak" <?= (isset($data->nyeri_mempengaruhi)?in_array("tidur", $data->nyeri_mempengaruhi)?'checked':'':'') ?>>
                                <span>Tidur</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->nyeri_mempengaruhi)?in_array("aktivitas_fisik", $data->nyeri_mempengaruhi)?'checked':'':'') ?>>
                                <span>Aktivitas Fisik</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->nyeri_mempengaruhi)?in_array("emosi", $data->nyeri_mempengaruhi)?'checked':'':'') ?>>
                                <span>Emosi</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->nyeri_mempengaruhi)?in_array("nafsu_makan", $data->nyeri_mempengaruhi)?'checked':'':'') ?>>
                                <span>Nafsu Makan</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->nyeri_mempengaruhi)?in_array("konsentrasi", $data->nyeri_mempengaruhi)?'checked':'':'') ?>>
                                <span>Konsentrasi</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->nyeri_mempengaruhi)?in_array("other", $data->nyeri_mempengaruhi)?'checked':'':'') ?>>
                                <span>lain-lainnya : <?= isset($data->{'nyeri_mempengaruhi-Comment'})?$data->{'nyeri_mempengaruhi-Comment'}:'' ?></span>
                          
                       

                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 8</p>    
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

            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">
                <span>SKRINING GIZI AWAL</span><br>
                    <table id="data" width="100%" border="1">
                        <tr>
                            <td width="90%">
                        
                            <span>1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak di inginkan<span></td>
                            <td  width="5%">Skor</td>
                            <td  width="5%">Skor Pasien</td>
                        </tr>
                        <tr>
                            <td width="90%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "0" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                            <td  width="5%">0</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%"> 
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "2" ? "checked":'':'' ?>>
                                <span>Tidak yakin (ada tanda baju menjadi longgar)</span>
                        </td>
                            <td  width="5%">2</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "2" ? "2":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                               
                                <span>ya, ada penurunan BB sebanyak</span>
                            </td>
                            <td  width="5%"></td>
                            <td  width="5%"></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "1" ? "checked":'':'' ?>>
                                <span>1 - 5 kg</span>
                            </td>
                            <td  width="5%">1</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "2" ? "checked":'':'' ?>>
                                <span>6 - 10 kg</span>
                            </td>
                            <td  width="5%">2</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "2" ? "2":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "3" ? "checked":'':'' ?>>
                                <span>11 - 15 kg</span>
                            </td>
                            <td  width="5%">3</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "3" ? "3":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "4" ? "checked":'':'' ?>>
                                <span>> 15  kg</span>
                            </td>
                            <td  width="5%">4</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "4" ? "4":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "2" ? "checked":'':'' ?>>
                                <span>Tidak tahu berapa kg penurunan nya</span>
                            </td>
                            <td  width="5%">2</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'1'})? $data->skrining_gizi->skor->{'1'} == "2" ? "2":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                        
                            <span>2. Apakah asupan makanan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makanan ?<span></td>
                            <td  width="5%">Skor</td>
                            <td  width="5%">Skor Pasien</td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'2'})? $data->skrining_gizi->skor->{'2'} == "0" ? "checked":'':'' ?>>
                                <span>Tidak</span>
                            </td>
                            <td  width="5%">0</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'2'})? $data->skrining_gizi->skor->{'2'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi->skor->{'2'})? $data->skrining_gizi->skor->{'2'} == "1" ? "checked":'':'' ?>>
                                <span>Ya</span>
                            </td>
                            <td  width="5%">1</td>
                            <td  width="5%"><?php echo isset($data->skrining_gizi->skor->{'2'})? $data->skrining_gizi->skor->{'2'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td width="90%">
                                <span>Total skor (Bila skor ≥2, pasien beresiko malnutrisi, konsul ke ahli gizi)</span>
                            </td>
                            <td  width="5%"></td>
                            <td  width="5%"><?= isset($data->skrining_gizi->skor->total_skor)?$data->skrining_gizi->skor->total_skor:'' ?></td>
                        </tr>
                    
                    </table>
                    <span>Asesmen Fungsional (Barthel Indeks)</span><br>
                    <span>Beri nilai pada hasil pemeriksaan dan jumlahkan</span>

                    <table id="data" width="100%" border="1">
                        <tr>
                            <th width="5%" rowspan="2">No</th>
                            <th width="25%" rowspan="2">Fungsi</th>
                            <th width="10%" rowspan="2">Skor</th>
                            <th width="40%" rowspan="2">Uraian</th>
                            <th width="10%" colspan="2">Saat Masuk RS</th>
                    
                        </tr>
                        <tr>
                            
                            <th width="10%">Saat Masuk RS</th>
                            <th width="10%">Saat Keluar RS</th>
                        </tr>
                        <tr>
                            <td style="text-align:center" rowspan="3">1.</td>
                            <td rowspan="3">Mengendalikan rangsang berkemih (BAB)</td>
                            <td style="text-align:center">0</td>
                            <td>Tak terkendali/ tak teratur (perlu pencahar)</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'1'})? $data->assesment_fungsional->masuk_rs->{'1'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'1'})? $data->assesment_fungsional->keluar_rs->{'1'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>Kadang-kadang tak terkendali</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'1'})? $data->assesment_fungsional->masuk_rs->{'1'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'1'})? $data->assesment_fungsional->keluar_rs->{'1'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'1'})? $data->assesment_fungsional->masuk_rs->{'1'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'1'})? $data->assesment_fungsional->keluar_rs->{'1'} == "2" ? "2":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="3">2.</td>
                            <td rowspan="3">Mengendalikan rangsang berkemih (BAK)</td>
                            <td style="text-align:center">0</td>
                            <td>Tak terkendali/ pakai keteter</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'2'})? $data->assesment_fungsional->masuk_rs->{'2'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'2'})? $data->assesment_fungsional->keluar_rs->{'2'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>kadang kadang tak terkendali (1x24 jam)</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'2'})? $data->assesment_fungsional->masuk_rs->{'2'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'2'})? $data->assesment_fungsional->keluar_rs->{'2'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'2'})? $data->assesment_fungsional->masuk_rs->{'2'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'2'})? $data->assesment_fungsional->keluar_rs->{'2'} == "2" ? "2":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="2">3.</td>
                            <td rowspan="2">Membersihkan diri (cuci muka, sisir rambut, sikat gigi)</td>
                            <td style="text-align:center">0</td>
                            <td>Butuh pertolongan orang lain</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'3'})? $data->assesment_fungsional->masuk_rs->{'3'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'3'})? $data->assesment_fungsional->keluar_rs->{'3'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>perlu pertolongan pada beberapa kegiatan tetapi dapat mengerjakan sendiri kegiatan yang lain</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'3'})? $data->assesment_fungsional->masuk_rs->{'3'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'3'})? $data->assesment_fungsional->keluar_rs->{'3'} == "1" ? "1":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="3">4.</td>
                            <td rowspan="3">Penggunaan jamban masuk dan keluar (melepaskan, memakai celana, membersihkan , menyiram)</td>
                            <td style="text-align:center">0</td>
                            <td>Tergantung pertolongan orang lain</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'4'})? $data->assesment_fungsional->masuk_rs->{'4'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'4'})? $data->assesment_fungsional->keluar_rs->{'4'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>perlu pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yang lain.</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'4'})? $data->assesment_fungsional->masuk_rs->{'4'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'4'})? $data->assesment_fungsional->keluar_rs->{'4'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'4'})? $data->assesment_fungsional->masuk_rs->{'4'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'4'})? $data->assesment_fungsional->keluar_rs->{'4'} == "2" ? "2":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="3">5.</td>
                            <td rowspan="3">Makan</td>
                            <td style="text-align:center">0</td>
                            <td>Tidak mampu</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'5'})? $data->assesment_fungsional->masuk_rs->{'5'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'5'})? $data->assesment_fungsional->keluar_rs->{'5'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>Perlu pertolongan memotong makanan</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'5'})? $data->assesment_fungsional->masuk_rs->{'5'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'5'})? $data->assesment_fungsional->keluar_rs->{'5'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'5'})? $data->assesment_fungsional->masuk_rs->{'5'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'5'})? $data->assesment_fungsional->keluar_rs->{'5'} == "2" ? "2":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="3">6.</td>
                            <td rowspan="3">Berubah sikap dari berbaring ke duduk</td>
                            <td style="text-align:center">0</td>
                            <td>Tidak mampu</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'6'})? $data->assesment_fungsional->masuk_rs->{'6'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'6'})? $data->assesment_fungsional->keluar_rs->{'6'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>Perlu pertolongan memotong makanan</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'6'})? $data->assesment_fungsional->masuk_rs->{'6'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'6'})? $data->assesment_fungsional->keluar_rs->{'6'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'6'})? $data->assesment_fungsional->masuk_rs->{'6'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'6'})? $data->assesment_fungsional->keluar_rs->{'6'} == "2" ? "2":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="4">7.</td>
                            <td rowspan="4">Berpindah/berjalan</td>
                            <td style="text-align:center">0</td>
                            <td>Tidak mampu</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'7'})? $data->assesment_fungsional->masuk_rs->{'7'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'7'})? $data->assesment_fungsional->keluar_rs->{'7'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>bisa (pindah) dengan kursi roda</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'7'})? $data->assesment_fungsional->masuk_rs->{'7'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'7'})? $data->assesment_fungsional->keluar_rs->{'7'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Berjalan dengan bantuan 1 orang</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'7'})? $data->assesment_fungsional->masuk_rs->{'7'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'7'})? $data->assesment_fungsional->keluar_rs->{'7'} == "2" ? "2":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">3</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'7'})? $data->assesment_fungsional->masuk_rs->{'7'} == "3" ? "3":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'7'})? $data->assesment_fungsional->keluar_rs->{'7'} == "3" ? "3":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center">8.</td>
                            <td>Memakai baju</td>
                            <td style="text-align:center">0</td>
                            <td>Tergantung pada orang lain</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'8'})? $data->assesment_fungsional->masuk_rs->{'8'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'8'})? $data->assesment_fungsional->keluar_rs->{'8'} == "0" ? "0":'':'' ?></td>
                        </tr>


                        <tr>
                            <td style="text-align:center" rowspan="3">9.</td>
                            <td rowspan="3">Naik turun tangga</td>
                            <td style="text-align:center">0</td>
                            <td>Tidak mampu</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'9'})? $data->assesment_fungsional->masuk_rs->{'9'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'9'})? $data->assesment_fungsional->keluar_rs->{'9'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>Butuh pertolongan</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'9'})? $data->assesment_fungsional->masuk_rs->{'9'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'9'})? $data->assesment_fungsional->keluar_rs->{'9'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">2</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'9'})? $data->assesment_fungsional->masuk_rs->{'9'} == "2" ? "2":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'9'})? $data->assesment_fungsional->keluar_rs->{'9'} == "2" ? "2":'':'' ?></td>
                        </tr>

                        <tr>
                            <td style="text-align:center" rowspan="2">10.</td>
                            <td rowspan="2">Mandi</td>
                            <td style="text-align:center">0</td>
                            <td>Tergantung orang lain</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'10'})? $data->assesment_fungsional->masuk_rs->{'10'} == "0" ? "0":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'10'})? $data->assesment_fungsional->keluar_rs->{'10'} == "0" ? "0":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center">1</td>
                            <td>Mandiri</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->{'10'})? $data->assesment_fungsional->masuk_rs->{'10'} == "1" ? "1":'':'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->{'10'})? $data->assesment_fungsional->keluar_rs->{'10'} == "1" ? "1":'':'' ?></td>
                        </tr>
                        <tr>
                            <td style="text-align:center" colspan="4">Total Skor</td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->masuk_rs->total_skor)? $data->assesment_fungsional->masuk_rs->total_skor:'' ?></td>
                            <td style="text-align:center"><?php echo isset($data->assesment_fungsional->keluar_rs->total_skor)? $data->assesment_fungsional->keluar_rs->total_skor :'' ?></td>
                            
                        </tr>
                        
                    </table>

                    <table id="data" width="45%">
                        <tr>
                            <td width="10%">Keterangan</td>
                            <td width="5%">20</td>
                            <td width="30%">: Mandiri</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>12-19</td>
                            <td>: Ketergantungan Ringan</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>9-11</td>
                            <td>: Ketergantungan Sedang</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>5-8</td>
                            <td>: Ketergantungan Berat</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>0-4</td>
                            <td>: Ketergantungan Total</td>
                        </tr>
                    </table>
        
            </div><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">
                <span><b>ASESMEN RISIKO JATUH</b></span>

                <p>Pengkajian Resiko Jatuh :</p>
                <p style="text-align:right">Penilaian Risiko Jatuh Pada Pasien</p>
                <span>Dewasa (Skala Morse)</span>

                <table width="100%" id="data" border="1">
                    <tr>
                        <th width="5%">No</th>
                        <th width="45%">Parameter</th>
                        <th width="35%">Status</th>
                        <th width="15%">Skor</th>
                    </tr>
                    <tr>
                        <td rowspan="2">1.</td>
                        <td rowspan="2">Riwayat Jatuh</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "0"?"bg-checked":"":"" ?>">Tidak</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "0"?"bg-checked":"":"" ?>"  style="text-align:center">0</td>
                    </tr>
        
                    <tr>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "15"?"bg-checked":"":"" ?>">Ya</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "15"?"bg-checked":"":"" ?>"  style="text-align:center">25</td>
                    </tr>

                    <tr>
                        <td rowspan="2">2.</td>
                        <td rowspan="2">Penyakit penyerta (diagnosis sekunder ≥ 2)</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "0"?"bg-checked":"":"" ?>">Tidak</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "0"?"bg-checked":"":"" ?>" style="text-align:center">0</td>
                    </tr>
        
                    <tr>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "15"?"bg-checked":"":"" ?>">Ya</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "15"?"bg-checked":"":"" ?>" style="text-align:center">15</td>
                    </tr>

                    <tr>
                        <td rowspan="3">3.</td>
                        <td >
                            <span>Alat bantu jalan</span><br>
                            <sapn>a. Tidak ada/Bed rest / dibantu perawat</span>
                        </td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "0"?"bg-checked":"":"" ?>">Tanpa alat bantu</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "0"?"bg-checked":"":"" ?>" style="text-align:center">0</td>
                    </tr>

                    <tr>
                        <td >b. Penopang tongkat/walker</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "15"?"bg-checked":"":"" ?>">Tidak dapat jalan</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "15"?"bg-checked":"":"" ?>" style="text-align:center">15</td>
                    </tr>

                    <tr>
                        <td >c. Berpegang dengan perabot</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "30"?"bg-checked":"":"" ?>">Kursi</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "30"?"bg-checked":"":"" ?>" style="text-align:center">30</td>
                    </tr>

                    <tr>
                        <td rowspan="2">4.</td>
                        <td rowspan="2">Pemakaian terapi heparin / intra vena / infus</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "0"?"bg-checked":"":"" ?>" >Tidak</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "0"?"bg-checked":"":"" ?>"  style="text-align:center">0</td>
                    </tr>
        
                    <tr>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "20"?"bg-checked":"":"" ?>" >Ya</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "20"?"bg-checked":"":"" ?>"  style="text-align:center">20</td>
                    </tr>

                    <tr>
                        <td rowspan="3">5.</td>
                        <td rowspan="3">Cara berjalan / berpindah</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "0"?"bg-checked":"":"" ?>">Normal /bed rest/immobilisasi</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "0"?"bg-checked":"":"" ?>" style="text-align:center">0</td>
                    </tr>
        
                    <tr>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "10"?"bg-checked":"":"" ?>">Lemah</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "10"?"bg-checked":"":"" ?>" style="text-align:center">10</td>
                    </tr>

                    <tr>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "20"?"bg-checked":"":"" ?>">Terganggu</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "20"?"bg-checked":"":"" ?>" style="text-align:center">20</td>
                    </tr>

                    <tr>
                        <td rowspan="2">6.</td>
                        <td rowspan="2">Status mental</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "0"?"bg-checked":"":"" ?>">Orientasi sesuai kemampuan diri</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "0"?"bg-checked":"":"" ?>" style="text-align:center">0</td>
                    </tr>
        
                    <tr>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "15"?"bg-checked":"":"" ?>">Lupa keterbatasan diri</td>
                        <td id="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "15"?"bg-checked":"":"" ?>" style="text-align:center">15</td>
                    </tr>

                    <tr>
                        <td style="text-align:center;font-weight:bold" colspan="3">Total</td>
                       
                        <td style="text-align:center;font-weight:bold"><?= isset($data->assesment_resiko_jatuh->skor->total_skor)?$data->assesment_resiko_jatuh->skor->total_skor :'' ?></td>
                    </tr>
                </table>

                <table width="40%" id="data" border="0">
                    <tr>
                        <td rowspan="3" width="10%">Keterangan</td>
                        <td width="10%"><p>0 - 24 </p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="18%"><p>tidak beresiko </p></td>
                    </tr>

                    <tr>
                    
                        <td><p>25 - 50 </p></td>
                        <td><p>:</p></td>
                        <td><p>risiko rendah </p></td>
                    </tr>

                    <tr>
                    
                        <td><p>≥ 51 </p></td>
                        <td><p>:</p></td>
                        <td><p>risiko tinggi </p></td>
                    </tr>
                </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 3 dari 8</p>    
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

            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">

                <span>ASUHAN KEBIDANAN</span>
                <p>A. DATA SUBJEKTIF</p>  
                <div style="margin-left:25px">
                    <span>1. Riwayat Menstruasi</span>

                        <table id="data" cellpadding="5px" style="margin-left:20px">
                            <tr>
                                <td width="15%">Menarche</td>
                                <td width="2%">:</td>
                                <td><?= isset($data->riwayat_menstruasi[0]->menarche)?$data->riwayat_menstruasi[0]->menarche:'' ?> Tahun</td>
                            </tr>

                            <tr>
                                <td width="15%">Siklus</td>
                                <td width="2%">:</td>
                                <td>
                                    <span><?= isset($data->riwayat_menstruasi[0]->siklus)?$data->riwayat_menstruasi[0]->siklus:'' ?> Hari </span>

                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_menstruasi[0]->teratur)? $data->riwayat_menstruasi[0]->teratur == "teratur" ? "checked":'':'' ?>>
                                    <span>Teratur</span> 
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_menstruasi[0]->teratur)? $data->riwayat_menstruasi[0]->teratur == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak Teratur</span> 
                                    <span style="margin-left:30px">Lama : <?= isset($data->riwayat_menstruasi[0]->lama)?$data->riwayat_menstruasi[0]->lama:'' ?></span>
                                </td>
                            </tr>

                            <tr>
                                <td width="15%">Keluhan</td>
                                <td width="2%">:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_menstruasi[0]->keluhan)?in_array('dismenorhoe',$data->riwayat_menstruasi[0]->keluhan)?'checked':'':'') ?>>
                                    <span>Dismenorhoe</span> 
                                    <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_menstruasi[0]->keluhan)?in_array('spotting',$data->riwayat_menstruasi[0]->keluhan)?'checked':'':'') ?>>
                                    <span>Spotting</span> 
                                    <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_menstruasi[0]->keluhan)?in_array('menorrharge',$data->riwayat_menstruasi[0]->keluhan)?'checked':'':'') ?>>
                                    <span>Menorrhagia</span>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_menstruasi[0]->keluhan)?in_array('metrorhagi',$data->riwayat_menstruasi[0]->keluhan)?'checked':'':'') ?>>
                                    <span>Metrohagi</span>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_menstruasi[0]->keluhan)?in_array('lainnya',$data->riwayat_menstruasi[0]->keluhan)?'checked':'':'') ?>>
                                    <span>Lainnya : <?= isset($data->riwayat_menstruasi[0]->detillainnya)?$data->riwayat_menstruasi[0]->detillainnya:'' ?></span>
                                
                                </td>
                            </tr>

                            <tr>
                                <td width="15%">HPHT</td>
                                <td width="2%">:</td>
                                <td>
                                <span><?= isset($data->hpht->hpht1)?$data->hpht->hpht1:'' ?></span>
                                <span style="margin-left:40px">HPL : <?= isset($data->hpht->hpl)?$data->hpht->hpl:'' ?></span>
                                <span style="margin-left:40px">UK : <?= isset($data->hpht->uk)?$data->hpht->uk:'' ?></span>
                                
                                </td>
                            </tr>
                        </table> 

                        <table id="data" cellpadding="5px">
                            <tr>
                                <td width="25%">2. Riwayat Perkawinan</td>
                                <td width="2%">:</td>
                                <td width=:73%>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_perkawinan)? $data->riwayat_perkawinan == "K" ? "checked":'':'' ?>>
                                        <span>Menikah</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_perkawinan)? $data->riwayat_perkawinan == "B" ? "checked":'':'' ?>>
                                        <span>Belum menikah</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_perkawinan)? $data->riwayat_perkawinan == "C" ? "checked":'':'' ?>>
                                        <span>Janda</span> 
                                </td>
                            </tr>
                            <tr>
                                <td width="25%"><p style="margin-left:20px">Status Pernikahan</p></td>
                                <td width="2%">:</td>
                                <td width=:73%>
                                    <p>
                                        <span>Istri</span>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->istri)? $data->istri == "1" ? "checked":'':'' ?>>
                                        <span>1x</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->istri)? $data->istri == "2" ? "checked":'':'' ?>>
                                        <span>2x</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->istri)? $data->istri == "3" ? "checked":'':'' ?>>
                                        <span>> 2x</span><br><br>

                                        <span>Suami</span>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->suami)? $data->suami == "1" ? "checked":'':'' ?>>
                                        <span>1x</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->suami)? $data->suami == "2" ? "checked":'':'' ?>>
                                        <span>2x</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->suami)? $data->suami == "3" ? "checked":'':'' ?>>
                                        <span>> 2x</span>
                                    </p>
                                         
                                </td>
                            </tr>
                            <tr>
                                <td width="25%"><p style="margin-left:20px">Usia Perkawinan</p></td>
                                <td width="2%">:</td>
                                <td width=:73%>
                                        <span><?= isset($data->usia->usia_perkawinan)?$data->usia->usia_perkawinan:'' ?> Tahun</span>
                                        <span style="margin-left:20px">Hubungan : <?= isset($data->usia->hubungan)?$data->usia->hubungan:'' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="25%"><p style="margin-left:20px">Keluarga Terdekat</p></td>
                                <td width="2%">:</td>
                                <td width=:73%>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> keluarga[0]->keluarga_terdekat)?in_array('orang_tua',$data->keluarga[0]->keluarga_terdekat)?'checked':'':'') ?>>
                                        <span>Orang tua</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> keluarga[0]->keluarga_terdekat)?in_array('suami',$data->keluarga[0]->keluarga_terdekat)?'checked':'':'') ?>>
                                        <span>Suami</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> keluarga[0]->keluarga_terdekat)?in_array('anak',$data->keluarga[0]->keluarga_terdekat)?'checked':'':'') ?>>
                                        <span>Anak</span>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> keluarga[0]->keluarga_terdekat)?in_array('sendiri',$data->keluarga[0]->keluarga_terdekat)?'checked':'':'') ?>>
                                        <span>Sendiri</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> keluarga[0]->keluarga_terdekat)?in_array('other',$data->keluarga[0]->keluarga_terdekat)?'checked':'':'') ?>>
                                        <span>Lain lain : <?= isset($data-> keluarga[0]->{'keluarga_terdekat-Comment'})?$data-> keluarga[0]->{'keluarga_terdekat-Comment'}:'' ?></span> 
                                </td>
                            </tr>
                            <tr>
                                <td width="25%"><p style="margin-left:20px">Tinggal dengan</p></td>
                                <td width="2%">:</td>
                                <td width=:73%>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data-> keluarga[0]->tinggal)? $data-> keluarga[0]->tinggal == "ya" ? "checked":'':'' ?>>
                                        <span>Ya</span> 
                                        <input type="checkbox" value="Tidak" <?php echo isset($data-> keluarga[0]->tinggal)? $data-> keluarga[0]->tinggal == "tidak" ? "checked":'':'' ?>>
                                        <span>Tidak</span> 
                                </td>
                            </tr>
                        </table>

                        <span>3. Riwayat Psikososial dan Spiritual</span>

                        <div style="display:flex;margin-left:20px">

                            <div>
                                <p>a) Status Psikologis</p>
                                    <div style="margin-left:20px">
                                        <input type="checkbox"  value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_psikologis)?in_array('cemas',$data-> riwayat_psikososial[0]->status_psikologis)?'checked':'':'') ?>>
                                        <span>cemas</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_psikologis)?in_array('takut',$data-> riwayat_psikososial[0]->status_psikologis)?'checked':'':'') ?>>
                                        <span>takut</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_psikologis)?in_array('marah',$data-> riwayat_psikososial[0]->status_psikologis)?'checked':'':'') ?>>
                                        <span>marah</span> <br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_psikologis)?in_array('sedih',$data-> riwayat_psikososial[0]->status_psikologis)?'checked':'':'') ?>>
                                        <span>sedih</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_psikologis)?in_array('kecenderungan',$data-> riwayat_psikososial[0]->status_psikologis)?'checked':'':'') ?>>
                                        <span>kecenderungan bunuh diri</span><br>
                                        <span>Lain - Lain,Sebutkan <?= isset($data-> riwayat_psikososial[0]->{'status_psikologis-Comment'})?$data-> riwayat_psikososial[0]->{'status_psikologis-Comment'}:'' ?></span>
                                    </div>
                                <p>b) Status Mental</p>
                                    <div style="margin-left:20px">
                                        <input type="checkbox"  value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_mental)?in_array('sadar_orientasi',$data-> riwayat_psikososial[0]->status_mental)?'checked':'':'') ?>>
                                        <span>sadar dan orientasi baik</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_mental)?in_array('ada_masalah',$data-> riwayat_psikososial[0]->status_mental)?'checked':'':'') ?>>
                                        <span>ada masalah perilaku, sebutkan <?= isset($data-> riwayat_psikososial[0]->detilmasalah)?$data-> riwayat_psikososial[0]->detilmasalah:'' ?></span> <br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->status_mental)?in_array('perilaku_kekerasan',$data-> riwayat_psikososial[0]->status_mental)?'checked':'':'') ?>>
                                        <span>Perilaku kekerasan yang dialami pasien sebelumnya <?= isset($data-> riwayat_psikososial[0]->detil_perilaku)?$data-> riwayat_psikososial[0]->detil_perilaku:'' ?></span>
                                    </div>
                                <p>c) Status Ekonomi dan Sosial</p>
                                    <div style="margin-left:20px">
                                        <input type="checkbox"  value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->staus_ekonomi)?in_array('asuransi',$data-> riwayat_psikososial[0]->staus_ekonomi)?'checked':'':'') ?>>
                                        <span>Asuransi</span>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->staus_ekonomi)?in_array('jaminan',$data-> riwayat_psikososial[0]->staus_ekonomi)?'checked':'':'') ?>>
                                        <span>Jaminan</span> 
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->staus_ekonomi)?in_array('biata_sendiri',$data-> riwayat_psikososial[0]->staus_ekonomi)?'checked':'':'') ?>>
                                        <span>Biaya sendiri</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data-> riwayat_psikososial[0]->staus_ekonomi)?in_array('other',$data-> riwayat_psikososial[0]->staus_ekonomi)?'checked':'':'') ?>>
                                        <span>Lainnya,sebutkan <?= isset($data-> riwayat_psikososial[0]->{'staus_ekonomi-Comment'})?$data-> riwayat_psikososial[0]->{'staus_ekonomi-Comment'}:'' ?></span>
                                    </div>
                                     
                                     
                            </div>

                            <div>
                                <p>d) Kultural</p>
                                    <div style="margin-left:20px">
                                        <span>Hubungan pasien dengan anggota keluarga</span><br>
                                        <input type="checkbox"  value="Tidak" <?php echo isset($data->kultural[0]->kultural_kerabat)? $data->kultural[0]->kultural_kerabat == "baik" ? "checked":'':'' ?>>
                                        <span>Baik</span>
                                        <input type="checkbox" value="Tidak" <?php echo isset($data->kultural[0]->kultural_kerabat)? $data->kultural[0]->kultural_kerabat == "tidak_baik" ? "checked":'':'' ?>>
                                        <span>Tidak baik</span><br>

                                        <span>Kerabat terdekat yang dapat dihubungi:</span>
                                        <table id="data">
                                            <tr>
                                                <td width="20%">Nama</td>
                                                <td width="5%">:</td>
                                                <td width="20%"><?= isset($data->kultural[0]->kerabat)?$data->kultural[0]->kerabat:'' ?></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">Hubungan</td>
                                                <td width="5%">:</td>
                                                <td width="20%"><?= isset($data->kultural[0]->hubungan)?$data->kultural[0]->hubungan:'' ?></td>
                                            </tr>
                                            <tr>
                                                <td width="20%">Telepon</td>
                                                <td width="5%">:</td>
                                                <td width="20%"><?= isset($data->kultural[0]->telepon)?$data->kultural[0]->telepon:'' ?></td>
                                            </tr>
                                        </table>
                                        <span>Nilai nilai dan kepercayaan yang dianut oleh pasien : <?= isset($data->kultural[0]->nilai_nilai)?$data->kultural[0]->nilai_nilai:'' ?></span>
                                    </div>
                                <p>d) Status Spiritual</p>
                                    <div style="margin-left:20px">
                                        <span>Kegiatan keagamaan yang biasa dilakukan : <?= isset($data->kultural[0]->statu_spiritual)?$data->kultural[0]->statu_spiritual:'' ?></span><br>
                                        <span>Kegiatan spiritual yang dibutuhkan selama perawatan: <?= isset($data->kultural[0]->kegiatan_spiritual)?$data->kultural[0]->kegiatan_spiritual:'' ?></span>
                                    </div>
                                    
                            </div>
                        </div>

                        <p>4. Kebutuhan komunikasi dan edukasi</p>
                        <div style="margin-left:20px">

                            <span>Terdapat hambatan dalam pembelajaran :</span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->hambatan_belajar)? $data->hambatan_belajar == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->hambatan_belajar)? $data->hambatan_belajar == "ya" ? "checked":'':'' ?>>
                            <span>Ya, Jika ya :</span><br>

                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('pendengaran',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Pendengaran</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('penglihatan',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Penglihatan</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('kognitif',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Kognitif</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('fisik',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Fisik</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('budaya',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Budaya</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('emosi',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Emosi</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('bahasa',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Bahasa</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data-> check_hambatan)?in_array('other',$data-> check_hambatan)?'checked':'':'') ?>>
                            <span>Lainnya <?= isset($data-> {'check_hambatan-Comment'})?$data-> {'check_hambatan-Comment'}:'' ?></span>

                            <p>Dibutuhkan penterjemah :
                                <input type="checkbox" value="Tidak" <?php echo isset($data->penerjemah)? $data->penerjemah == "tidak" ? "checked":'':'' ?>>
                                <span>Tidak</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->penerjemah)? $data->penerjemah == "other" ? "checked":'':'' ?>>
                                <span>Ya, sebutkan <?= isset($data-> {'penerjemah-Comment'})?$data-> {'penerjemah-Comment'}:'' ?></span>

                                <span style="margin-left:20px">Bahasa isyarat</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->bahasa_isyarat)? $data->bahasa_isyarat == "tidak" ? "checked":'':'' ?>>
                                <span>Tidak</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->bahasa_isyarat)? $data->bahasa_isyarat == "ya" ? "checked":'':'' ?>>
                                <span>Ya, <?= isset($data-> {'bahasa_isyarat-Comment'})?$data-> {'bahasa_isyarat-Comment'}:'' ?></span>
                            </p>

                            <span>Kebutuhan edukasi (Pilih topik edukasi pada kotak yang tersedia) :</span><br>
                            <span>Diagnosa dan manajemen penyakit : </span>
                                <input type="checkbox" value="Tidak" <?= (isset($data-> diagnosa)?in_array('obat',$data-> diagnosa)?'checked':'':'') ?>>
                                <span>Obat-obatan / terapi</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data-> diagnosa)?in_array('diet',$data-> diagnosa)?'checked':'':'') ?>>
                                <span>Diet dan nutrisi</span><br>

                            <span>Tindakan keperawatan : </span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                                <span>Rehabilitasi </span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                                <span>Manajemen nyeri</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                                <span>Lain - lain, sebutkan </span>
                        
                        </div>

                        <p>5. Perencanaan Pulang /Discharge Planning :</p>
                            <div style="margin-left:20px">
                                <span>(dilengkapi dalam waktu 48 jam pertama pasien masuk ruang rawat)</span><br>

                                <span>a) Pasien tinggal dengan siapa ?</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->pasien_tingal)? $data->question8[0]->pasien_tingal == "sendiri" ? "checked":'':'' ?>>
                                    <span>Sendiri</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->pasien_tingal)? $data->question8[0]->pasien_tingal == "other" ? "checked":'':'' ?>>
                                    <span>Anak / Lain-lain,sebutkan <?= isset($data->question8[0]->{'pasien_tingal-Comment'})?$data->question8[0]->{'pasien_tingal-Comment'}:'' ?></span><br>

                                <span>b) Dimana letak kamar pasien dirumah ?</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->letak_kamar)? $data->question8[0]->letak_kamar == "lsntsi_dasar" ? "checked":'':'' ?>>
                                    <span>Laintai dasar</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->letak_kamar)? $data->question8[0]->letak_kamar == "other" ? "checked":'':'' ?>>
                                    <span>Lantai dua / tiga, sebutkan <?= isset($data->question8[0]->{'letak_kamar-Comment'})?$data->question8[0]->{'letak_kamar-Comment'}:'' ?></span>
                            </div>
                        
                       




                        
                </div>

               
                
            </div>
            <br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 4 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">

                <div style="margin-left:20px">
                    <span>c) Bagaimana kondisi rumah pasien ?</span><br>
                        <div style="margin-left:20px">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question8[0]->kondiri_rumah)?in_array('penerangan_lampu',$data->question8[0]->kondiri_rumah)?'checked':'':'') ?>>
                            <span>Penerangan lampu cukup terang / kurang</span><br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question8[0]->kondiri_rumah)?in_array('kamar_tidur',$data->question8[0]->kondiri_rumah)?'checked':'':'') ?>>
                            <span>Kamar tidur jauh / dekat dengan kamar mandi</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question8[0]->kondiri_rumah)?in_array('wc',$data->question8[0]->kondiri_rumah)?'checked':'':'') ?>>
                            <span>WC jongkok / duduk </span>
                        </div>

                    <span>d) Bagaimana perawatan kebutuhan dasar pasien ?</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->perawatan_kebutuhan)? $data->question8[0]->perawatan_kebutuhan == "mandiri" ? "checked":'':'' ?>>
                            <span>Mandiri </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->perawatan_kebutuhan)? $data->question8[0]->perawatan_kebutuhan == "dibantu_sebagian" ? "checked":'':'' ?>>
                            <span>Dibantu sebagian </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->perawatan_kebutuhan)? $data->question8[0]->perawatan_kebutuhan == "dibantu_penuh" ? "checked":'':'' ?>>
                            <span>Dibantu penuh </span><br>

                    <span>e) Apakah pasien memerlukan alat bantu bantu khusus ?</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->alat_bantu_pasien)? $data->question8[0]->alat_bantu_pasien == "other" ? "checked":'':'' ?>>
                            <span>Ya, sebutkan <?= isset($data->question8[0]->{'alat_bantu_pasien-Comment'})?$data->question8[0]->{'alat_bantu_pasien-Comment'}:'' ?> </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->alat_bantu_pasien)? $data->question8[0]->alat_bantu_pasien == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak </span>

                            <div style="margin-left:20px">
                            <span>Apakah diet makanan pasien ?</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8[0]->diet)?in_array('bebas',$data->question8[0]->diet)?'checked':'':'') ?>>
                                <span>Bebas</span> 
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8[0]->diet)?in_array('vegetarian',$data->question8[0]->diet)?'checked':'':'') ?>>
                                <span>Vegetarian</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8[0]->diet)?in_array('other',$data->question8[0]->diet)?'checked':'':'') ?>>
                                <span>Khusus, sebutkan <?= isset($data->question8[0]->{'diet-Comment'})?$data->question8[0]->{'diet-Comment'}:'' ?> </span><br>

                                <span>Perkiraan hari rawatan <?= isset($data->question8[0]->perkiraan_hari)?$data->question8[0]->perkiraan_hari:'' ?> hari</span>
                            </div>


                            
                        
                </div>



                <p>6. Riwayat kehamilan persalinan dan nifas </p>

                <div style="margin-left:20px">
                    <span>G : <?= isset($data->gpah->g)?$data->gpah->g:'' ?></span>
                    <span>P : <?= isset($data->gpah->p)?$data->gpah->p:'' ?></span>
                    <span>A : <?= isset($data->gpah->a)?$data->gpah->a:'' ?></span>
                    <span>H : <?= isset($data->gpah->h)?$data->gpah->h:'' ?></span>
                </div>

                <table border="1" id="data">
                    <tr>
                        <th>No</th>
                        <th>Tahun partus</th>
                        <th>Tempat partus</th>
                        <th>Umur Hamil</th>
                        <th>Jenis Persalinan</th>
                        <th>Penolong persalinan</th>
                        <th>Penyulit</th>
                        <th>Jenis Kelamin/Berat lahir</th>
                        <th>Keadaan anak sekarang</th>
                    </tr>
                    <?php
                            $no=1; 
                            $jml_array = isset($data->table2)?count($data->table2):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= isset($data->table2[$x]->no)?$data->table2[$x]->no:'' ?></td>
                                <td><?= isset($data->table2[$x]->tahun_partus)?$data->table2[$x]->tahun_partus:'' ?></td>
                                <td><?= isset($data->table2[$x]->tempat_partus)?$data->table2[$x]->tempat_partus:'' ?></td>
                                <td><?= isset($data->table2[$x]->umur_hamil)?$data->table2[$x]->umur_hamil:'' ?></td>
                                <td><?= isset($data->table2[$x]->jenis_persalinan)?$data->table2[$x]->jenis_persalinan:'' ?></td>
                                <td><?= isset($data->table2[$x]->penolong_persalinan)?$data->table2[$x]->penolong_persalinan:'' ?></td>
                                <td><?= isset($data->table2[$x]->jenis_kelamin)?$data->table2[$x]->jenis_kelamin:'' ?></td>
                                <td><?= isset($data->table2[$x]->kesadaran)?$data->table2[$x]->kesadaran:'' ?></td>
                            </tr>
                        <?php } ?>
                    
                </table>

                <p>7. Riwayat penyakit dahulu </p>

                <div style="margin-left:20px">
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('asma',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>Asma </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('jantung',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>Jantung </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('hipertensi',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>Hipertensi </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('dm',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>DM </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('tiroid',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>Tiroid </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('epilepsi',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>Epilepsi </span><br>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakti)?in_array('other',$data->table[0]->riwayat_penyakti)?'checked':'':'') ?>>
                    <span>Riwayat operasi : <?= isset($data->table[0]->{'riwayat_penyakti-Comment'})?$data->table[0]->{'riwayat_penyakti-Comment'}:'' ?> </span>
                </div>

                <p>8. Riwayat penyakit Keluarga </p>

                <div style="margin-left:20px">
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('kanker',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Kanker hipertensi </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('penyakit_ginjal',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Penyakit ginjal </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('kelainan_bawaan',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Kelainan bawaan </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('tbc',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>TBC </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('alergi',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Alergi </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('penyakit_hati',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Penyakit hati </span><br>

                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('dm',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>DM </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('penyakit_jiwa',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span> Penyakit Jiwa</span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('hamil_kembar',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Hamil Kembar </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('epilepsi',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span> Epilepsi</span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_penyakit_keluarga)?in_array('other',$data->table[0]->riwayat_penyakit_keluarga)?'checked':'':'') ?>>
                    <span>Lain lain : <?= isset($data->table[0]->{'riwayat_penyakit_keluarga-Comment'})?$data->table[0]->{'riwayat_penyakit_keluarga-Comment'}:'' ?> </span>
                </div>

                <p>9. Riwayat Ginekologi </p>

                <div style="margin-left:20px">
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('infertilitas',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Infertilitas</span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('infeksi_virus',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Infeksi virus </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('pms',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>PMS </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('cervisitis',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Cervisitis kronis </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('endometrio',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Endometrio </span><br>

                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('myoma',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Myoma </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('polip_serviks',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Polip serviks </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('kanker_kandungan',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span> Kanker kandungan</span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('operasi_kandungan',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Operasi Kandungan </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('perkosaan',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span> Perkosaan</span><br>

                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('flor_albus',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Flour albus (gatal) : </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->detil_flour)? $data->table[0]->detil_flour == "ya" ? "checked":'':'' ?>>
                    <span>Ya </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->table[0]->detil_flour)? $data->table[0]->detil_flour == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak, </span>

                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('berbau',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Berbau : </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->detil_berbau)? $data->detil_berbau == "ya" ? "checked":'':'' ?>>
                    <span>Ya </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->detil_berbau)? $data->detil_berbau == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak,  </span>
                    <span style="margin-left:10px">Warna ....</span><br>

                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('post_coital_bleeding',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Post coital bleeding, </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table[0]->riwayat_genekologi)?in_array('other',$data->table[0]->riwayat_genekologi)?'checked':'':'') ?>>
                    <span>Lain lain .... </span>
                </div>

                <p>10. Riwayat KB </p>

                    <div style="margin-left:25px">
                        <span>Metode KB yang pernah dipakai </span>

                        <?php
                            $no=1; 
                            $jml = isset($data->metode_kb)?count($data->metode_kb):'';
                            for ($x = 0; $x < $jml; $x++) {
                        ?>
                            <div style="display:flex">
                            <div>
                                <p><?= $no++ ?>.</p>
                            </div>
                            <div style="margin-left:5px">
                                <p><?= isset($data->metode_kb[$x]->metode)?$data->metode_kb[$x]->metode:'' ?></p>
                            </div>

                            <div style="margin-left:30px">
                                <p>Lama : <?= isset($data->metode_kb[$x]->lama)?$data->metode_kb[$x]->lama:'' ?> tahun</p>
                            </div>
                        </div>
                        <?php } ?>

                        

                        <span>Komplikasi dari KB :</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                        <span>Perdarahan  </span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                        <span>PID/Radang punggul  </span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                        <span>Lain lain ...  </span>
                    </div>

                <p>11. Pola eliminasi/istirahat </p>
                    <div style="margin-left:25px">
                        <table id="data" border="0">
                            <tr>
                                <td width="15%">Pola Eliminasi</td>
                                <td width="2%">:</td>
                                <td width="25%">BAK : <?= isset($data->pola_eliminasi->bak)?$data->pola_eliminasi->bak:'' ?> cc/hari</td>
                                <td width="5%">Warna</td>
                                <td width="2%">:</td>
                                <td width="41%"><?= isset($data->pola_eliminasi->warna)?$data->pola_eliminasi->warna:'' ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>BAB : <?= isset($data->pola_eliminasi->bab)?$data->pola_eliminasi->bab:'' ?> x/hari</td>
                                <td>Karakteristik</td>
                                <td>:</td>
                                <td><?= isset($data->pola_eliminasi->karakteristik)?$data->pola_eliminasi->karakteristik:'' ?></td>
                            </tr>
                            <tr>
                                <td width="15%">Pola Istirahat</td>
                                <td width="2%">:</td>
                                <td width="25%" colspan="2">Tidur malam : <?= isset($data->pola_istirahat->tidur_malam)?$data->pola_istirahat->tidur_malam:'' ?> jam/hari</td>
                                <td width="5%" colspan="2">Tidur Siang : <?= isset($data->pola_istirahat->tidur_siang)?$data->pola_istirahat->tidur_siang:'' ?> jam/hari</td>
                                
                            </tr>
                        </table>
                    </div>

            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 5 dari 8</p>    
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

            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">
                <span>B. Data Objektif</span>
                <p>1. Pemeriksaan umum<br>
                    <div style="margin-left:20px">
                        <span>Keadaan umum : <?= isset($data->pemeriksaan_umum->keadaan_umum)?$data->pemeriksaan_umum->keadaan_umum:'' ?></span>
                        <span style="margin-left:15px">Kesadaran : <?= isset($data->pemeriksaan_umum->kesadaran)?$data->pemeriksaan_umum->kesadaran:'' ?></span>
                        <span style="margin-left:15px">BB/TB : <?= isset($data->pemeriksaan_umum->bb)?$data->pemeriksaan_umum->bb:'' ?> kg/ <?= isset($data->pemeriksaan_umum->tb)?$data->pemeriksaan_umum->tb:'' ?> cm</span><br>

                        <span>TD : <?= isset($data->question7->td)?$data->question7->td:'' ?> mmHg</span>
                        <span style="margin-left:15px">Frekuensi nadi : <?= isset($data->question7->frekuensi_nadi)?$data->question7->frekuensi_nadi:'' ?> x/menit</span>
                        <span style="margin-left:15px">Suhu : <?= isset($data->question7->suhu)?$data->question7->suhu:'' ?> °C</span>
                        <span style="margin-left:15px">Frekuensi pernafasan : <?= isset($data->question7->frekuensi_nafas)?$data->question7->frekuensi_nafas:'' ?> x/menit</span>
                    </div>   
                </p>

                <p>
                    <span>2. Pemeriksaan fisik</span>
                        <div style="margin-left:20px">
                        <table id="data" width="100%">
                            <tr>
                                <td width="7%">Kepala</td>
                                <td width="2%">:</td>
                                <td width="22%">
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->kepala)?in_array('mesocephal',$data->pemeriksaan_fisik[0]->kepala)?'checked':'':'') ?>>
                                    <span>Mesocephal  </span>
                                </td>
                                <td width="27%">
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->kepala)?in_array('kotor',$data->pemeriksaan_fisik[0]->kepala)?'checked':'':'') ?>>
                                    <span>Kotor </span>
                                </td>
                                <td width="29%">
                                
                                </td>
                                <td width="13%">
                                    
                                </td>
                            </tr>

                            <tr>
                                <td>Rambut</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->rambut)?in_array(' bersih',$data->pemeriksaan_fisik[0]->rambut)?'checked':'':'') ?>>
                                    <span>Bersih  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->rambut)?in_array('pucat',$data->pemeriksaan_fisik[0]->rambut)?'checked':'':'') ?>>
                                    <span>Pucat </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->rambut)?in_array(' oedem',$data->pemeriksaan_fisik[0]->rambut)?'checked':'':'') ?>>
                                    <span>Oedem  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->rambut)?in_array('cloasma',$data->pemeriksaan_fisik[0]->rambut)?'checked':'':'') ?>>
                                    <span>Cloasma  </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Muka</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->muka)?in_array('normal',$data->pemeriksaan_fisik[0]->muka)?'checked':'':'') ?>>
                                    <span>Normal  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->muka)?in_array('sklrea_ikterik',$data->pemeriksaan_fisik[0]->muka)?'checked':'':'') ?>>
                                    <span>Sklera ikterik </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak">
                                    <span>Pandangan kabur  </span>
                                </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Mata</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" >
                                    <span>Konjungtiva merah  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" >
                                    <span>Sekret </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" >
                                    <span>Polip  </span>
                                </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Hidung</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->hidung)?in_array('normal',$data->pemeriksaan_fisik[0]->hidung)?'checked':'':'') ?>>
                                    <span>Normal  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->hidung)?in_array(' serumen',$data->pemeriksaan_fisik[0]->hidung)?'checked':'':'') ?>>
                                    <span>Serumen </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->hidung)?in_array('polip',$data->pemeriksaan_fisik[0]->hidung)?'checked':'':'') ?>>
                                    <span>Polip  </span>
                                </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Telinga</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->telinga)?in_array(' bersih',$data->pemeriksaan_fisik[0]->telinga)?'checked':'':'') ?>>
                                    <span>Bersih  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->telinga)?in_array('kotor',$data->pemeriksaan_fisik[0]->telinga)?'checked':'':'') ?>>
                                    <span>Kotor </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->telinga)?in_array('other',$data->pemeriksaan_fisik[0]->telinga)?'checked':'':'') ?>>
                                    <span>Lain lain : <?=isset($data->pemeriksaan_fisik[0]->{'telinga-Comment'})?$data->pemeriksaan_fisik[0]->{'telinga-Comment'}:'' ?>  </span>
                                </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Mulut</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->mulut)?in_array('bersih',$data->pemeriksaan_fisik[0]->mulut)?'checked':'':'') ?>>
                                    <span>Bersih  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->mulut)?in_array('pembesaran',$data->pemeriksaan_fisik[0]->mulut)?'checked':'':'') ?>>
                                    <span>Pembesaran Kel. Tiroid </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->mulut)?in_array('pembesaran1',$data->pemeriksaan_fisik[0]->mulut)?'checked':'':'') ?>>
                                    <span>Pembesaran vena jugularis  </span>
                                </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>Leher</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->leher)?in_array('pembesaran_limfe',$data->pemeriksaan_fisik[0]->leher)?'checked':'':'') ?>>
                                    <span>Pembesaran Limfe  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->leher)?in_array('asimetris',$data->pemeriksaan_fisik[0]->leher)?'checked':'':'') ?>>
                                    <span>Asimetris</span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->leher)?in_array('pernafasan_normal',$data->pemeriksaan_fisik[0]->leher)?'checked':'':'') ?>>
                                    <span>Pernafasan normal  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->leher)?in_array('sesak',$data->pemeriksaan_fisik[0]->leher)?'checked':'':'') ?>>
                                    <span>Sesak  </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Dada</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->dada)?in_array('semiteris',$data->pemeriksaan_fisik[0]->dada)?'checked':'':'') ?>>
                                    <span>Simetris  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->dada)?in_array('putting',$data->pemeriksaan_fisik[0]->dada)?'checked':'':'') ?>>
                                    <span>Putting datar/tenggelam</span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->dada)?in_array('putting1',$data->pemeriksaan_fisik[0]->dada)?'checked':'':'') ?>>
                                    <span>Putting menonjol  </span>
                                </td>
                                <td>
                                </td>
                            </tr>

                            <tr>
                                <td>Payudara</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->payudara)?in_array('colostrum',$data->pemeriksaan_fisik[0]->payudara)?'checked':'':'') ?>>
                                    <span>Colostrum  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->payudara)?in_array('nyeri',$data->pemeriksaan_fisik[0]->payudara)?'checked':'':'') ?>>
                                    <span>Nyeri tekan</span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->payudara)?in_array('ya',$data->pemeriksaan_fisik[0]->payudara)?'checked':'':'') ?>>
                                    <span>ya  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->payudara)?in_array('tidak',$data->pemeriksaan_fisik[0]->payudara)?'checked':'':'') ?>>
                                    <span>tidak  </span>
                                </td>
                            </tr>

                            <tr>
                                <td>Abdomen</td>
                                <td>:</td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->abdomen)?in_array('luka',$data->pemeriksaan_fisik[0]->abdomen)?'checked':'':'') ?>>
                                    <span>Luka bekas operasi  </span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->abdomen)?in_array('mass_tumor',$data->pemeriksaan_fisik[0]->abdomen)?'checked':'':'') ?>>
                                    <span>Mass tumor</span>
                                </td>
                                <td>
                                    <input type="checkbox" value="Tidak" <?= (isset($data->pemeriksaan_fisik[0]->abdomen)?in_array('other',$data->pemeriksaan_fisik[0]->abdomen)?'checked':'':'') ?>>
                                    <span><?= isset($data->pemeriksaan_fisik[0]->{'abdomen-Comment'})?$data->pemeriksaan_fisik[0]->{'abdomen-Comment'}:''?></span>
                                </td>
                                <td>
                            
                                </td>
                            </tr>
                        </table>
                    </div>

                </p>

                <p>(Khusus obstetri)</p>
                <span>Abdomen</span><br>
                <span>Inpeksi :</span>
                    <div style="margin-left:20px">
                        <input type="checkbox" value="Tidak" <?= (isset($data->abdomen_inspeksi)?in_array('membesar_dengan',$data->abdomen_inspeksi)?'checked':'':'') ?>>
                        <span>Membesar dengan arah memanjang/melebar </span>
                        <input type="checkbox" value="Tidak" <?= (isset($data->abdomen_inspeksi)?in_array('pelebaran_vena',$data->abdomen_inspeksi)?'checked':'':'') ?>>
                        <span>Peleberan vena </span>
                        <input type="checkbox" value="Tidak" <?= (isset($data->abdomen_inspeksi)?in_array('linea_alba',$data->abdomen_inspeksi)?'checked':'':'') ?>>
                        <span>Linea aiba </span>
                        <input type="checkbox" value="Tidak" <?= (isset($data->abdomen_inspeksi)?in_array('linea_nigra',$data->abdomen_inspeksi)?'checked':'':'') ?>>
                        <span>Linea nigra </span><br>

                        <input type="checkbox" value="Tidak" >
                        <span>Striae livide </span>
                        <input type="checkbox" value="Tidak" <?= (isset($data->abdomen_inspeksi)?in_array('striae',$data->abdomen_inspeksi)?'checked':'':'') ?>>
                        <span>Striae albican </span>
                        <input type="checkbox" value="Tidak" <?= (isset($data->abdomen_inspeksi)?in_array('other',$data->abdomen_inspeksi)?'checked':'':'') ?>>
                        <span>Luka bekas oprasi <?=isset($data->{'abdomen_inspeksi-Comment'})?$data->{'abdomen_inspeksi-Comment'}:'' ?> </span>
                    </div>
                <p>Palpasi</p>
                <span>Leopoid I</span><br>
                <span>Leopoid II</span><br>
                <span>Leopoid III</span><br>
                <span>Leopoid IV</span><br>
                    <input type="checkbox" value="Tidak" <?= (isset($data->nyeri1)?in_array('nyeri_tekan',$data->nyeri1)?'checked':'':'') ?>>
                    <span>Nyeri tekan </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->nyeri1)?in_array('osborn',$data->nyeri1)?'checked':'':'') ?>>
                    <span>Osborn test </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->nyeri1)?in_array('cekungan',$data->nyeri1)?'checked':'':'') ?>>
                    <span>Cekungan pada perut </span>

                <p>Tinggi fundus uteri (TFU) : <?= isset($data->tinggi->tinggu_fundus)?$data->tinggi->tinggu_fundus:'' ?> cm</p>
                <span>Taksiran berat janin (TBJ) : <?= isset($data->tinggi->taksiran)?$data->tinggi->taksiran:'' ?> gram</span><br>
                
                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                <span>His : <?= isset($data->his)?$data->his:'' ?> x/10mnt </span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->teratur)? $data->teratur == "teratur1" ? "checked":'':'' ?>>
                <span>Teratur </span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->teratur)? $data->teratur == "tidak" ? "checked":'':'' ?>>
                <span>Tidak Teratur </span><br>

                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                <span>Durasi : <?= isset($data->durasi)?$data->durasi:'' ?> detik </span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->kuat)? $data->kuat == "kuar" ? "checked":'':'' ?>>
                <span>Kuat </span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->kuat)? $data->kuat == "sedang" ? "checked":'':'' ?>>
                <span>Sedang </span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->kuat)? $data->kuat == "lemah" ? "checked":'':'' ?>>
                <span>Lemah </span><br>
                <span>Auskuitasi : DJJ <?= isset($data->auskultasi)?$data->auskultasi:'' ?> x/menit</span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->teratur_tidak)? $data->teratur_tidak == "teratur1" ? "checked":'':'' ?>>
                <span>Teratur </span>
                <input type="checkbox" value="Tidak" <?php echo isset($data->teratur_tidak)? $data->teratur_tidak == "tidak" ? "checked":'':'' ?>>
                <span>Tidak Teratur </span>

                <p>Genitalia</p>
                <span>Inpeksi</span><br>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('bersih',$data->inspeksi)?'checked':'':'') ?>>
                <span>Bersih </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('kotor',$data->inspeksi)?'checked':'':'') ?>>
                <span>Kotor </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('',$data->inspeksi)?'checked':'':'') ?>>
                <span>Varises </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('oedem',$data->inspeksi)?'checked':'':'') ?>>
                <span>Oedem </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('abses',$data->inspeksi)?'checked':'':'') ?>>
                <span>Abses </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('hematom ',$data->inspeksi)?'checked':'':'') ?>>
                <span>Hematom </span><br>

                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('other',$data->inspeksi)?'checked':'':'') ?>>
                <span>Pengeluaran per vagina : banyaknya <?= isset($data->{'inspeksi-Comment'})?$data->{'inspeksi-Comment'}:'' ?> cc </span><br>

                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('konsistensi ',$data->inspeksi)?'checked':'':'') ?>>
                <span>Konsistensi </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('encer',$data->inspeksi)?'checked':'':'') ?>>
                <span>Encer </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('gumpalan /stolsel',$data->inspeksi)?'checked':'':'') ?>>
                <span>Gumpalan/stolsel </span><br>

                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('ketuban',$data->inspeksi)?'checked':'':'') ?>>
                <span>Ketuban </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('keputihan',$data->inspeksi)?'checked':'':'') ?>>
                <span>Keputihan </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('darah',$data->inspeksi)?'checked':'':'') ?>>
                <span>Darah </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->inspeksi)?in_array('darah_lender',$data->inspeksi)?'checked':'':'') ?>>
                <span>Darah lender </span>

                <p>Inspekulo</p>
                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                <span>Vagina : <?= isset($data->vagina)?$data->vagina:'' ?> </span><br>

                <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array('portio',$data->question11)?'checked':'':'') ?>>
                <span>Portio </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array('merah',$data->question11)?'checked':'':'') ?>>
                <span>Merah </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array('darah',$data->question11)?'checked':'':'') ?>>
                <span>Darah </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array('keputihan',$data->question11)?'checked':'':'') ?>>
                <span>Keputihan </span>
                <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array('air_ketuban',$data->question11)?'checked':'':'') ?>>
                <span>Air ketuban </span>

                <p>Periksa dalam</p>
                <table width="60%" id="data" border="0">
                    <tr>
                        <td width="40%">
                            <span>Uretra</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->uretra)? $data->periksa_dalam[0]->uretra == "infeksi" ? "checked":'':'' ?>>
                            <span>Infeksi </span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->uretra)? $data->periksa_dalam[0]->uretra == "tidak_ada" ? "checked":'':'' ?>>
                            <span>tidak ada </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span>Vulva</span>&nbsp;
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->vulva)? $data->periksa_dalam[0]->vulva == "pembengkakan" ? "checked":'':'' ?>>
                            <span>Pembengkakan kelenjar bartholini </span>
                        </td>
                        <td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->vulva)? $data->periksa_dalam[0]->vulva == "tidak_ada" ? "checked":'':'' ?>>
                            <span>tidak ada </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span>Vagina</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->vagina1)? $data->periksa_dalam[0]->vagina1 == "licin" ? "checked":'':'' ?>>
                            <span>Licin </span>
                        </td>
                        <td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->vagina1)? $data->periksa_dalam[0]->vagina1 == "benjolan" ? "checked":'':'' ?>>
                            <span>benjolan </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span>Portio</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->portio)? $data->periksa_dalam[0]->portio == " tebal" ? "checked":'':'' ?>>
                            <span>Tebal </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->portio)? $data->periksa_dalam[0]->portio == "tipis" ? "checked":'':'' ?>>
                            <span>Tipis </span>
                        </td>
                        <td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->portio)? $data->periksa_dalam[0]->portio == "lunak" ? "checked":'':'' ?>>
                            <span>Lunak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->periksa_dalam[0]->portio)? $data->periksa_dalam[0]->portio == "kaku" ? "checked":'':'' ?>>
                            <span>Kaku </span>
                        </td>
                    </tr>

                </table>















            </div><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 6 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">
                <span style="margin-left:5px">Pembukaan : <?= isset($data->pembukaan)?$data->pembukaan:'' ?> cm</span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table4)?in_array('selaput_ketuban',$data->table4)?'checked':'':'') ?>>
                    <span>Selaput ketuban  </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->table4)?in_array('ketuban',$data->table4)?'checked':'':'') ?>>
                    <span>Ketuban  </span>
                    <input type="checkbox" value="Tidak" style="margin-left:30px" <?= (isset($data->table4)?in_array('other',$data->table4)?'checked':'':'') ?>>
                    <span>STLD : <?= isset($data->{'table4-Comment'})?$data->{'table4-Comment'}:'' ?>  </span>

                <table id="data" cellpadding="5px">
                    <tr>
                        <td width="20%">Bg. Terendah</td>
                        <td width="2%">:</td>
                        <td width="78%"><?= isset($data->table5[0]->bg_terendah)?$data->table5[0]->bg_terendah:'' ?></td>
                    </tr>

                    <tr>
                        <td width="20%">UUK</td>
                        <td width="2%">:</td>
                        <td width="78%"><?= isset($data->table5[0]->uuk)?$data->table5[0]->uuk:'' ?></td>
                    </tr>

                    <tr>
                        <td width="20%">Penurunan</td>
                        <td width="2%">:</td>
                        <td width="78%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table5[0]->penurunan)? $data->table5[0]->penurunan == "1" ? "checked":'':'' ?>>
                            <span>H I  </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table5[0]->penurunan)? $data->table5[0]->penurunan == "2" ? "checked":'':'' ?>>
                            <span>H II  </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table5[0]->penurunan)? $data->table5[0]->penurunan == "3" ? "checked":'':'' ?>>
                            <span>HIII  </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table5[0]->penurunan)? $data->table5[0]->penurunan == "4" ? "checked":'':'' ?>>
                            <span>H IV  </span>
                        </td>
                    </tr>

                    <tr>
                        <td width="20%">Ketuban pecah</td>
                        <td width="2%">:</td>
                        <td width="78%">Jam <?= isset($data->table5[0]->ketuban_pecah)?$data->table5[0]->ketuban_pecah:'' ?></td>
                    </tr>

                    <tr>
                        <td width="20%">Bishop score</td>
                        <td width="2%">:</td>
                        <td width="78%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->table5[0]->bilshop)? $data->table5[0]->bilshop == "1" ? "checked":'':'' ?>>
                            <span>≥ 6  </span>

                            <input type="checkbox" value="Tidak" <?php echo isset($data->table5[0]->bilshop)? $data->table5[0]->bilshop == "2" ? "checked":'':'' ?>>
                            <span>< 6  </span>
                        </td>
                    </tr>
                </table>

                <p>Ekstremitas</p>
                    <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array('atas',$data->ekstremitas)?'checked':'':'') ?>>
                    <span>Atas  </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array('oedema ',$data->ekstremitas)?'checked':'':'') ?>>
                    <span>Oedema  </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array('',$data->ekstremitas)?'checked':'':'') ?>>
                    <span>Normal  </span><br>

                    <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas2)?in_array('bawah',$data->ekstremitas2)?'checked':'':'') ?>>
                    <span>Bawah  </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array('oedema ',$data->ekstremitas)?'checked':'':'') ?>>
                    <span>Oedema  </span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array('',$data->ekstremitas)?'checked':'':'') ?>>
                    <span>Normal  </span>

                <p>Pemeriksaan Penunjang</p>
                <div style="display:flex">

                    <div>
                        <span>Darah</span>
                    </div>

                    <div style="margin-left:20px">
                        <span>Hb: <?= isset($data->darah->hb)?$data->darah->hb:'' ?></span>
                        <span>Golongan darah: <?= isset($data->darah->golongan_darah)?$data->darah->golongan_darah:'' ?></span>
                        <span>leukosit: <?= isset($data->darah->leukosit)?$data->darah->leukosit:'' ?></span>
                        <p>
                            <span>Trombosit: <?= isset($data->darah->trombosit)?$data->darah->trombosit:'' ?></span>
                            <span>HbsAg: <?= isset($data->darah->hbsag)?$data->darah->hbsag:'' ?></span>
                            <span>GDS: <?= isset($data->darah->gds)?$data->darah->gds:'' ?></span>
                        </p>
                        <span>HIV : <?= isset($data->darah->hiv)?$data->darah->hiv:'' ?></span>
                    </div>

                </div>

            </div>
            <br><br><br><br><br<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 7 dari 8</p>    
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

            <center><h4>ASSESMENT AWAL KEPERAWATAN RAWAT INAP KEBIDANAN</h4></center>
            <div style="font-size:11px">
                <span>c. Daftar masalah kebidanan</span>
                <table id="data" width="100%" border="1">

                        <tr>
                            <th width="40%">Masalah Kebidanan</th>
                            <th width="25%">Tujuan</th>
                            <th width="35%">Intervensi</th>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('hamil',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Hamil  </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('primi',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Primi / multi /grandepara  </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('preterm',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Preterm / postterm </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('malpresentasi',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Malpresentasi / malposisi </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('tunggal',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Tunggal / ganda </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('hidup',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Hidup / Mati</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('intrauterin',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>intrauterin / ekstrauterin</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('keadaan_janin',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Keadaan janin baik / tidak</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('keadaan_ibu',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>keadaan ibu baik / tidak</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('inpartu ',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Inpartu / belum</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('abortus',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Abortus / H.A.P / H.P.P</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('prom',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>PPROM / PROM</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('peb',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>PEB / Eklapsia</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('anemia',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Anemia ringan / sedang / berat</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('infeksi',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Infeksi</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('luka_jalan',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Luka jalan Lahir</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('kala',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Kala I / II memanjang</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('kehamilan',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Kehamilan Ektopik</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('nyeri',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Nyeri akut abdomen</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->masalah_kebidanan)?in_array('perdarahan',$data->table_daftar[0]->masalah_kebidanan)?'checked':'':'') ?>>
                                <span>Perdarahan uterus abnormal</span>
                            </td>
                            <td rowspan ="4">
                                <span>Dalam jangka</span><br>
                                <span>waktu......</span><br>
                                <span>Masalah dapat teratasi dengan kriteri hasil</span><br><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>> <br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>> <br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>> <br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>> 
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('monitoring',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Monitor tanda tanda vital  </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('pemberian',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Pemberian oksigen </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('memberikan_posisi',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Memberikan posisi semi fowler </span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('memberikan_obat',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Memberikan obat oral,injeksi,infus</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('memasang_infus',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Memasang infus</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('pemasangan_chateter',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Pemasangan chateter</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('pemasangan_ctg ',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Pemasangan CTG dan merekam</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('merekam_ekg ',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Merekam EKG</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('merekam_usg',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Merekam USG</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('membantu_persalinan',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>membantu persalinan dengan tindakan</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('jahit_luka',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Jahit luka</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('memberikan_pendidikan',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Memberikan pendidikan kesehatan</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('pantau_kemajuan',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Pantau kemajuan persalinan</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('itmenolong_persalinanem1',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Menolong persalinan spontan</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('manual_plesenta',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Manual Plasenta</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('pemasangan_transfusi',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Pemasangan tranfusi darah</span><br>
                                <input type="checkbox" value="Tidak" <?= (isset($data->table_daftar[0]->intervensi)?in_array('pemasangan_monitor',$data->table_daftar[0]->intervensi)?'checked':'':'') ?>>
                                <span>Pemasangan monitor</span><br>
                                
                            </td>
                        </tr>


                </table>
                <div style="min-height:200px"></div>
                    <table id="data" width="100%">
                        <tr>
                            <td width="70%"></td>
                            <td>
                                <p>Bukittinggi, <?=isset($assesment_awal_keperawatan_iri[0]->tgl_input_perawat_1)?date('d-m-Y',strtotime($assesment_awal_keperawatan_iri[0]->tgl_input_perawat_1)):'' ?></p>
                                <span>Bidan yang melakukan pengkajian</span><br>
                                <img style="margin-left:5em;" src="<?= isset($assesment_awal_keperawatan_iri[0]->ttd)?$assesment_awal_keperawatan_iri[0]->ttd:''; ?>" width="120px" height="120px" alt="">
                                <center><span><?= isset($assesment_awal_keperawatan_iri[0]->name)?$assesment_awal_keperawatan_iri[0]->name:'' ?></span><center>
                            </td>
                        </tr>
                    </table>
                </div>
            <br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 8 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    </body>
</html>