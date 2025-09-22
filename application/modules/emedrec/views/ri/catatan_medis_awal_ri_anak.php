<?php 
//   var_dump($catatan_medis_awal_anak);
// var_dump($catatan_medis_awal_anak[0]->formjson_anak);
//  var_dump(isset($catatan_medis_awal_anak[0]->formjson_anak)?json_decode($catatan_medis_awal_anak[0]->formjson_anak):'');
$data = (isset($catatan_medis_awal_anak[0]->formjson_anak)?json_decode($catatan_medis_awal_anak[0]->formjson_anak):'');
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
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    
<body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 15px; text-align: center;">
                CATATAN MEDIS AWAL RAWAT INAP ANAK
            </p>
            
                <div style="font-size: 13px;">
                        <div>
                            <p><b><u>ANAMNESA</u></b></p>
                        </div>
                        
                        <div>
                            <p><b>1.	Keluhan Utama	:</b></p>
                            <p style="margin-left:25px"><?= (isset($data->keluhan_utama)?$data->keluhan_utama:'') ?></p>
                        </div>

                        <div>
                            <p><b>2.	Riwayat Penyakit Sekarang	:</b></p>
                            <p style="margin-left:25px"><?= (isset($data->riwayat_penyakit_sekarang)?$data->riwayat_penyakit_sekarang:'') ?></p>
                        </div>

                        <div>
                            <p><b>3.	Riwayat Penyakit Dahulu	:</b></p>
                            <p style="margin-left:25px"><?= (isset($data->riwayat_dahulu)?$data->riwayat_dahulu:'') ?></p>
                        </div>

                        <div>
                            <p><b>4.	Riwayat penyakit dalam keluarga:</b></p>
                            <p style="margin-left:25px">
                                <input type="checkbox" value="Hipertensi" <?= (isset($data-> penyakit_keluarga)?in_array("hipertensi", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span> Hipertensi</span>
                                <input type="checkbox" value="Diabetes" <?= (isset($data-> penyakit_keluarga)?in_array("diabetes", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Diabetes</span>
                                <input type="checkbox" value="Jantung" <?= (isset($data-> penyakit_keluarga)?in_array("jantung", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Jantung</span>
                                <input type="checkbox" value="Stroke" <?= (isset($data-> penyakit_keluarga)?in_array("stroke", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Stroke</span>
                                <input type="checkbox" value="Ginjal" <?= (isset($data-> penyakit_keluarga)?in_array("ginjal", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Ginjal</span>
                                <input type="checkbox" value="Asma" <?= (isset($data-> penyakit_keluarga)?in_array("asma", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Asma</span>
                                <input type="checkbox" value="Hati" <?= (isset($data-> penyakit_keluarga)?in_array("hati", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Hati</span><br>
                                <input type="checkbox" value="Kanker" <?= (isset($data-> penyakit_keluarga)?in_array("kanker", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Kanker</span>
                                <input type="checkbox" value="TB" <?= (isset($data-> penyakit_keluarga)?in_array("TB", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>TB</span>
                                <input type="checkbox" value="Glaukoma" <?= (isset($data-> penyakit_keluarga)?in_array("glaukoma", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Glaukoma</span>
                                <input type="checkbox" value="PMS" <?= (isset($data-> penyakit_keluarga)?in_array("pms", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>PMS</span>
                                <input type="checkbox" value="Perdarahan" <?= (isset($data-> penyakit_keluarga)?in_array("perdarahan", $data->penyakit_keluarga)?'checked':'':'') ?>>
                                <span>Perdarahan<span><br>
                                <span> Lainnya : <?= (isset($data->penyakit_keluarga_lainnya)?$data->penyakit_keluarga_lainnya:'') ?></span>
                            </p>
                        </div>

                        <div>
                            <p><b>5.	Riwayat pribadi/sosial/lingkungan	:</b></p>
                            <p style="margin-left:25px"><?= (isset($data->riwayat_pribadi)?$data->riwayat_pribadi:'') ?></p>
                        </div>

                        <div>
                            <p><b>6.	Riwayat Pengobatan	:</b></p>
                            <p style="margin-left:25px"> <?= (isset($data->riwayat_pengobatan)?$data->riwayat_pengobatan:'') ?></p>
                        </div>

                        <div>
                            <p><b>7.	Riwayat Imunisasi :</b></p>
                            <p style="margin-left:25px">
                            <input type="checkbox" value="BCG"<?= (isset($data->bcg_imunisasi)?in_array("BCG", $data->bcg_imunisasi)?'checked':'':'') ?>>
                            <span>BCG</span>
                            <input type="checkbox" value="Polio" <?= (isset($data->polio_imunisasi)?in_array("1", $data->polio_imunisasi)?'checked':'':'') ?>>
                            <span>Polio <?= ':'.(isset($data->value_polio)?$data->value_polio:'').' '.'kali'?></span>
                            <input type="checkbox" value="Hepatitis B" <?= (isset($data->hepatitis_imunisasi)?in_array("1", $data->hepatitis_imunisasi)?'checked':'':'') ?>>
                            <span>Hepatitis B  <?= ':'.(isset($data->value_hepatitis)?$data->value_hepatitis:'').' '.'kali'?></span>
                            <input type="checkbox" value="DPT" <?= (isset($data->dpt_imunisasi)?in_array("1", $data->dpt_imunisasi)?'checked':'':'') ?>>
                            <span>DPT <?= ':'.(isset($data->value_dpt)?$data->value_dpt:'').' '.'kali'?></span><br>
                            <input type="checkbox" value="Campak" <?= (isset($data->campak_imunisasi)?in_array("1", $data->campak_imunisasi)?'checked':'':'') ?>>
                            <span>Campak <?= ':'.(isset($data->value_campak)?$data->value_campak:'').' '.'kali'?></span>
                            <input type="checkbox" value="Lainnya" <?= (isset($data->lainnya_imunisasi)?in_array("1", $data->lainnya_imunisasi)?'checked':'':'') ?>>
                            <span>Lainnya <?= ':'.(isset($data->value_lainnya)?$data->value_lainnya:'')?></span>
                            </p>
                        </div>

                        <div>
                            <p><b>8.	Riwayat Persalinan :</b>
                                <span style="margin-left:15px">
                                    <input type="checkbox" value="normal" <?php echo isset($data->riwayat_persalinan)? $data->riwayat_persalinan == 'normal' ? 'checked':'':'' ?>>
                                    <span>Normal</span>
                                    <input type="checkbox" value="vacum" <?php echo isset($data->riwayat_persalinan)? $data->riwayat_persalinan == 'vacum' ? 'checked':'':'' ?>>
                                    <span>Vacum</span>
                                    <input type="checkbox" value="forceps" <?php echo isset($data->riwayat_persalinan)? $data->riwayat_persalinan == 'forceps' ? 'checked':'':'' ?>>
                                    <span>Forceps</label>
                                    <input type="checkbox" value="SC" <?php echo isset($data->riwayat_persalinan)? $data->riwayat_persalinan == 'sc' ? 'checked':'':'' ?>>
                                    <span>SC</span>
                                </span>
                            </p>
                            <p style="margin-left:25px">
                                <span>Ditolong Oleh </span>
                                <span style="margin-left:75px">
                                    <input type="checkbox" value="dokter" <?php echo isset($data->penolong_persalinan)? $data->penolong_persalinan == 'dokter' ? 'checked':'':'' ?>>
                                    <span>Dokter</span>
                                    <input type="checkbox" value="bidan" <?php echo isset($data->penolong_persalinan)? $data->penolong_persalinan == 'bidan' ? 'checked':'':'' ?>>
                                    <span>Bidan</span> 
                                    <input type="checkbox" value="lainnya" <?php echo isset($data->penolong_persalinan)? $data->penolong_persalinan == 'lainnya' ? 'checked':'':'' ?>>
                                    <span>Lainnya</span>
                                </span>

                                <p style="margin-left:25px">
                                    <span>BB: <?= (isset($data->BB_persalinan)?$data->BB_persalinan:'')?></span>
                                    <span style="margin-left: 100px;">PB: <?= (isset($data->PB_persalinan)?$data->PB_persalinan:'')?></span>
                                    <span style="margin-left: 100px;">LK: <?= (isset($data->LK_persalinan)?$data->LK_persalinan:'')?></span>
                                </p>

                                <p style="margin-left:25px">
                                    <span>Keadaan saat lahir</span>
                                    <span style="margin-left:35px">
                                        <input type="checkbox" value="Segera menangis" <?php echo isset($data->keadaan_saat_lahir)? $data->keadaan_saat_lahir == 'segera menangis' ? 'checked':'':'' ?>>
                                        <span>Segera menangis</span>
                                        <input type="checkbox" value="Tidak segera menangis" <?php echo isset($data->keadaan_saat_lahir)? $data->keadaan_saat_lahir == 'tidak segera menangis' ? 'checked':'':'' ?>>
                                        <span>Tidak segera menangis</span>
                                    </span>   
                                </p>     
                            </p>
                        </div>
                </div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            
                
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 4</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

<!-- halaman 2 -->
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>   
            <p style = "font-weight:bold; font-size: 15px; text-align: center;">
                CATATAN MEDIS AWAL RAWAT INAP ANAK
            </p>
            <div style="font-size: 13px;">
                    <p><b>9.	Riwayat Nutrisi:</b></p>
                    <div style="display: flex;font-size:12px">
                            <div style="margin-left: 30px;">
                                <span>ASI</span>
                                <br>
                                <span>Susu Formula</span>
                                <br>
                                <span>Bubu Susu</span>
                                <br>
                                <span>Nasi Tim</span>
                                <br>
                                <span>Makanan DEwasa</span>
                
                            </div>

                            <div style="flex-direction: column; margin-left: 30px;">
                                <input type="checkbox" value="eksklusif" <?= (isset($data->asi_ekslusif)?in_array("1", $data->asi_ekslusif)?'checked':'':'') ?>>
                                <span>eksklusif <?= ':'.(isset($data->value_asi_ekslusif)?$data->value_asi_ekslusif:'').' '.'bulan'?></span>
                                <br>
                                <input type="checkbox" value="eksklusif" <?= (isset($data->formula_sejak_usia)?in_array("1", $data->formula_sejak_usia)?'checked':'':'') ?>>
                                <span>Sejak Usia <?= ':'.(isset($data->value_usia_formula)?$data->value_usia_formula:'').' '.'bulan'?></span>
                                <br>
                                <input type="checkbox" value="eksklusif" <?= (isset($data->bubur_usia)?in_array("1", $data->bubur_usia)?'checked':'':'') ?>>
                                <span>Sejak Usia <?= ':'.(isset($data->value_bubur_usia)?$data->value_bubur_usia:'').' '.'bulan'?></span>
                                <br>
                                <input type="checkbox" value="eksklusif" <?= (isset($data->usia_nasi_tim)?in_array("1", $data->usia_nasi_tim)?'checked':'':'') ?>>
                                <span>Sejak Usia <?= ':'.(isset($data->value_nasi_tim_usia)?$data->value_nasi_tim_usia:'').' '.'bulan'?></span>
                                <br>
                                <input type="checkbox" value="eksklusif" <?= (isset($data->usia_makanan_dewasa)?in_array("1", $data->usia_makanan_dewasa)?'checked':'':'') ?>>
                                <span>Sejak Usia <?= ':'.(isset($data->value_makanan_usia)?$data->value_makanan_usia:'').' '.'bulan'?></span>
                                <br>
                                
                            </div>

                            <div style="flex-direction: column; margin-left: 30px;">
                                <input type="checkbox" value="durasi" <?= (isset($data->asi_durasi)?in_array("1", $data->asi_durasi)?'checked':'':'') ?>>
                                <span>Durasi <?= ':'.(isset($data->value_asi_ekslusif)?$data->value_asi_ekslusif:'').' '.'bulan'?></span>
                                <br>
                                <input type="checkbox" value="frekuensi" <?= (isset($data->formula_frekuensi)?in_array("1", $data->formula_frekuensi)?'checked':'':'') ?>>
                                <span>Frekuensi <?= ':'.(isset($data->value_formula_frekuensi)?$data->value_formula_frekuensi:'').' '.'x/hari'?></span>
                                <br>
                                <input type="checkbox" value="frekuensi" <?= (isset($data->frekuensi_bubur_susu)?in_array("1", $data->frekuensi_bubur_susu)?'checked':'':'') ?>>
                                <span>Frekuensi <?= ':'.(isset($data->value_bubur_frekuensi)?$data->value_bubur_frekuensi:'').' '.'x/hari'?></span>
                                <br>
                                <input type="checkbox" value="frekuensi" <?= (isset($data->nasitim_frekuensi)?in_array("1", $data->nasitim_frekuensi)?'checked':'':'') ?>>
                                <span>Frekuensi <?= ':'.(isset($data->value_nasitim_frekuensi)?$data->value_nasitim_frekuensi:'').' '.'x/hari'?></span>
                                <br>
                                <input type="checkbox" value="frekuensi" <?= (isset($data->makanan_dewasa_frekuensi)?in_array("1", $data->makanan_dewasa_frekuensi)?'checked':'':'') ?>>
                                <span>Frekuensi <?= ':'.(isset($data->value_makanan_frekuensi)?$data->value_makanan_frekuensi:'').' '.'x/hari'?></span>
                                <br>
                                
                            </div>

                            <div style="flex-direction: column;margin-left: 20px;">
                                <input type="checkbox" value="frekuensi" <?= (isset($data->frekuensi_asi)?in_array("1", $data->frekuensi_asi)?'checked':'':'') ?>>
                                <span>Frekuensi <?= ':'.(isset($data->value_frekuensi_asi)?$data->value_frekuensi_asi:'').' '.'x/hari'?></span> 
                            </div>
                    </div>

                    <p><b>10.	Riwayat Tumbuh Kembang:</b> </p>
                    <div style="margin-left:30px">
                        <input type="checkbox" value="Menegakkan kepala" <?= (isset($data->menegakan_kepala)?in_array("1", $data->menegakan_kepala)?'checked':'':'') ?>>
                        <span>Menegakkan kepala <?= ':'.(isset($data->value_menegakan_kepala)?$data->value_menegakan_kepala:'').' '.'bulan'?><span>
                        <input type="checkbox" value="Membalik badan" <?= (isset($data->membalik_badan)?in_array("1", $data->membalik_badan)?'checked':'':'') ?>>
                        <span>Membalik badan <?= ':'.(isset($data->value_membalik_badan)?$data->value_membalik_badan:'').' '.'bulan'?></span><br>
                        <input type="checkbox" value="Duduk" <?= (isset($data->duduk)?in_array("1", $data->duduk)?'checked':'':'') ?>>
                        <span>Duduk <?= ':'.(isset($data->value_duduk)?$data->value_duduk:'').' '.'bulan'?></span>
                        <input type="checkbox" value="Merangkak" <?= (isset($data->merangkak)?in_array("1", $data->merangkak)?'checked':'':'') ?>>
                        <span>Merangkak <?= ':'.(isset($data->value_merangkak)?$data->value_merangkak:'').' '.'bulan'?></span>
                        <input type="checkbox" value="Berdiri" <?= (isset($data->berdiri)?in_array("1", $data->berdiri)?'checked':'':'') ?>>
                        <span>Berdiri <?= ':'.(isset($data->value_berdiri)?$data->value_berdiri:'').' '.'bulan'?></span><br>
                        <input type="checkbox" value="Berjalan" <?= (isset($data->berjalan)?in_array("1", $data->berjalan)?'checked':'':'') ?>>
                        <span>Berjalan <?= ':'.(isset($data->value_berjalan)?$data->value_berjalan:'').' '.'bulan'?></span>
                        <input type="checkbox" value="Bicara" <?= (isset($data->bicara)?in_array("1", $data->bicara)?'checked':'':'') ?>>
                        <span>Bicara <?= ':'.(isset($data->value_bicara)?$data->value_bicara:'').' '.'bulan'?></span>
                        
                    </div>
                
                    <p><b>11.	Riwayat Alergi :</b> 
                            <input type="checkbox" value="Tidak"  <?php echo isset($data->riwayat_alergi)? $data->riwayat_alergi == '0' ? 'checked':'':'' ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya" <?php echo isset($data->riwayat_alergi)? $data->riwayat_alergi != '0' ? 'checked':'':'' ?>>
                            <span>Ya</span>
                    </p>
                    <div style="margin-left:30px">
                        

                        <p>Obat <?= ':'.(isset($data->obat_alergi)?$data->obat_alergi:'')?></p>
                        <p>Makanan <?= ':'.(isset($data->makanan_alergi)?$data->makanan_alergi:'')?> </p>
                        <p>Lain-lain <?= ':'.(isset($data->lainnya_alergi)?$data->lainnya_alergi:'')?></p>
                        
                        <p>reaksi <?= ':'.(isset($data->reaksi_one)?$data->reaksi_one:'')?></p>
                        <p>reaksi <?= ':'.(isset($data->reaksi_two)?$data->reaksi_two:'')?></p>
                        <p>reaksi <?= ':'.(isset($data->reaksi_tiga)?$data->reaksi_tiga:'')?></p>
                    </div>
                
                    <p>
                        <b>12.	Riwayat Operasi : </b>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_operasi)? $data->riwayat_operasi == '0' ? 'checked':'':'' ?>>
                        <span>Tidak</span>
                        
                        <input type="checkbox" value="Ya" <?php echo isset($data->riwayat_operasi)? $data->riwayat_operasi != '0' ? 'checked':'':'' ?>>
                        <span>Ya, Jenis &</span><br>
                        <span style="margin-left:30px">Kapan <?= ':'.(isset($data->value_operasi)?$data->value_operasi:'')?></span>

                    </p>
                    <p>
                        <b>13.	Riwayat Tranfusi: </b>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_transfusi)?$data->riwayat_transfusi == '0'?'checked':'':''  ?>>
                        <span>Tidak</span>
                        
                        <input type="checkbox" value="Ya" <?php echo isset($data->riwayat_transfusi)?$data->riwayat_transfusi != '0'?'checked':'':''  ?>>
                        <span>Ya</span><br>

                        <span style="margin-left:30px">Reaksi Transfusi:</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->reaksi_transfusi)?$data->reaksi_transfusi == '0'?'checked':'':''  ?>>
                        <span>Tidak</span>
                        
                        <input type="checkbox" value="Ya" <?php echo isset($data->reaksi_transfusi)?$data->reaksi_transfusi != '0'?'checked':'':''  ?>>
                        <span>Ya,reaksi yang timbul <?= ':'.(isset($data->value_reaksi_transfusi)?$data->value_reaksi_transfusi:'')?></span>
                    </p>
                <p>
                    <b>14.	Penilaian Nyeri	:</b><br>
                    <span style="margin-left:30px">Nyeri:</span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->nyeri)?$data->nyeri == 'tidak'?'checked':'':''  ?>>
                    <span>Tidak</span>
                    
                    <input type="checkbox" value="Ya" <?php echo isset($data->nyeri)?$data->nyeri != 'tidak'?'checked':'':''  ?>>
                    <span>Ya :</span><br>
                    <span style="margin-left: 30px;">Lokasi <?= ':'.(isset($data->lokasi_nyeri)?$data->lokasi_nyeri:'')?></span><br>
                    <span style="margin-left: 30px;">Skala FLACC <?= ':'.(isset($data->skala_nyeri)?$data->skala_nyeri:'')?></span><br>
                    
                    <span style="margin-left:30px">Jenis:</span>
                    <input type="checkbox" value="Akut" <?php echo isset($data->jenis_nyeri)?$data->jenis_nyeri == 'akut'?'checked':'':''  ?>>
                    <span>Akut</span>
                    
                    <input type="checkbox" value="Kronis" <?php echo isset($data->jenis_nyeri)?$data->jenis_nyeri != 'akut'?'checked':'':''  ?>>
                    <span>Kronis</span>
                </p>
                <p><b><u>PEMERIKSAAN FISIK</u></b></p>
                    <span><b>1.	Tanda-tanda Vital</b></span><br>
                    <div style="margin-left:25px"> 
                            <span>Keadaan Umum : <?=(isset($data->keadaan_umum)?$data->keadaan_umum:'')?></span><br>
                            <span>GCS	:	
                                <span style="margin-left:15px">E : <?=(isset($data->E_gcs)?$data->E_gcs:'')?></span>	
                                <span style="margin-left:35px">M : <?=(isset($data->M_gcs)?$data->M_gcs:'')?></span>	
                                <span style="margin-left:35px">V : <?=(isset($data->V_gcs)?$data->V_gcs:'')?></span><br>
                            </span>
                            <span>Tekanan darah: <?=(isset($data->td)?$data->td:'')?></span>
                            <span style="margin-left:35px">Suhu:  <?=(isset($data->suhu)?$data->suhu:'')?></span>
                            <span style="margin-left:35px">Nadi:  <?=(isset($data->nadi)?$data->nadi:'')?></span><br>
                            <span>isi <?= ':'.(isset($data->isi)?$data->isi:'')?></span>
                                <span style="margin-left:30px">teratur :</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->value_isi_teratur)?$data->value_isi_teratur != 'ya'?'checked':'':''  ?>>
                                <span>Tidak</span>
                                
                                <input type="checkbox" value="Ya" <?php echo isset($data->value_isi_teratur)?$data->value_isi_teratur == 'ya'?'checked':'':''  ?>>
                                <span>Ya</span>
                        <br>
                            <span>Respirasi: <?=(isset($data->respirasi)?$data->respirasi:'')?></span><br>
                            <span>Tipe : <?=(isset($data->tipe)?$data->tipe:'')?></span><br>
                            <span>Saturasi Oksigen	 <?=':'.' '.(isset($data->oksigen)?$data->oksigen:'').' '.'%'?><br>	
                            Pada</span>
                            <input type="checkbox" value="Udara Ruangan "<?= (isset($data->value_oksigen)?in_array("udara ruangan", $data->value_oksigen)?'checked':'':'') ?>>
                            <span>Udara Ruangan </span>
                            <input type="checkbox" value="Sungkup" <?= (isset($data->value_oksigen)?in_array("sungkup", $data->value_oksigen)?'checked':'':'') ?>>
                            <span>Sungkup</span>
                            <input type="checkbox" value="Nasal Prong" <?= (isset($data->value_oksigen)?in_array("nasal prong", $data->value_oksigen)?'checked':'':'') ?>>
                            <span>Nasal Prong  </span>
                            <input type="checkbox" value="Lainnya" <?= (isset($data->value_oksigen)?in_array("lainnya", $data->value_oksigen)?'checked':'':'') ?>>
                            <span>Lainnya</span>
                    </div>
               

                    <p><b>2.	Pemeriksaan Umum:</b></p>
                    <div style="margin-left:25px">
                        <span>Kepala	:
                                <input type="checkbox" value="Normal" <?php echo isset($data->kepala)?$data->kepala == 'normal'?'checked':'':''  ?>>
                            <span>Normal </span>
                            <input type="checkbox" value="Mikrosefali" <?php echo isset($data->kepala)?$data->kepala == 'mikrosefali'?'checked':'':''  ?>>
                            <span>Mikrosefali</span>
                            <input type="checkbox" value="Makrosefal " <?php echo isset($data->kepala)?$data->kepala == 'makrosefali'?'checked':'':''  ?>>
                            <span>Makrosefal</span>
                            <input type="checkbox" value="lainnya" <?php echo isset($data->kepala)?$data->kepala == 'lainnya'?'checked':'':''  ?>>
                            <span>Lainnya</span>
                        </span><br>
                        <span>Rambut :</span><br>
                        <span>- Warna	:
                            <input type="checkbox" value="Hitam" <?php echo isset($data->warna_rambut)?$data->warna_rambut == 'hitam'?'checked':'':''  ?>>
                            <span>Hitam</span>
                            <input type="checkbox" value="Seperti rambut jagung" <?php echo isset($data->warna_rambut)?$data->warna_rambut != 'hitam'?'checked':'':''  ?>>
                            <span>Seperti rambut jagung</span>
                        </span><br>
                        <span>
                            - Mudah dicabut	:
                            <input type="checkbox" value="Tidak" <?php echo isset($data->mudah_dicabut)?$data->mudah_dicabut != 'ya'?'checked':'':''  ?>>
                            <span>Tidak</span>
                            
                            <input type="checkbox" value="Ya" <?php echo isset($data->mudah_dicabut)?$data->mudah_dicabut == 'ya'?'checked':'':''  ?>>
                            <span>Ya</span>
                        </span>
                    </div>
                    
            </div><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 2 dari 4</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>


<!-- halaman 3 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 15px; text-align: center;">
                    CATATAN MEDIS AWAL RAWAT INAP ANAK
                </p>
                <div style="font-size:13px">
                    <div style="margin-left:25px">
                        <p><br>Mata   :</p>
                        <span>
                            Palpebra	:
                            <input type="checkbox" value="Normal" <?php echo isset($data->palpebra)?$data->palpebra == 'normal'?'checked':'':''  ?>>
                            <span>Normal</span>
                            
                            <input type="checkbox" value="Cekung" <?php echo isset($data->palpebra)?$data->palpebra == 'cekung'?'checked':'':''  ?>>
                            <span>Cekung</span>
                            <input type="checkbox" value="Cekung" <?php echo isset($data->palpebra)?$data->palpebra == 'oedema'?'checked':'':''  ?>>
                            <span>Oedema</span>
                        </span><br>

                        <span>
                            Konjungtiva pucat :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->konjungtiva_pucat)?$data->konjungtiva_pucat != 'ya'?'checked':'':''  ?>>
                            <span>Tidak</span>
                        
                            <input type="checkbox" value="Ya" <?php echo isset($data->konjungtiva_pucat)?$data->konjungtiva_pucat == 'ya'?'checked':'':''  ?>>
                            <span>Ya</span>
                        
                        </span><br>

                        <span>
                            Hiperemi	:
                            <input type="checkbox" value="Tidak" <?php echo isset($data->hiperemi)?$data->hiperemi != 'ya'?'checked':'':''  ?>>
                            <span>Tidak</span>
                        
                            <input type="checkbox" value="Ya" <?php echo isset($data->hiperemi)?$data->hiperemi == 'ya'?'checked':'':''  ?>>
                            <span>Ya</span>

                        </span><br>
                        <span>
                            Sekret :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->sekret)?$data->sekret != 'ya'?'checked':'':''  ?>>
                            <span>Tidak</span>
                        
                            <input type="checkbox" value="Ya" <?php echo isset($data->sekret)?$data->sekret == 'ya'?'checked':'':''  ?>>
                            <span>Ya</span>
                        
                        </span><br>
                        <span>
                            Sklera Ikterik :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->sklera_ikterik)?$data->sklera_ikterik == 'tidak'?'checked':'':''  ?>>
                            <span>Tidak</span>
                        
                            <input type="checkbox" value="Ya" <?php echo isset($data->sklera_ikterik)?$data->sklera_ikterik != 'tidak'?'checked':'':''  ?>>
                            <span>Ya</span>
                        
                        </span><br>
                        <span>
                            Pupil isokor	:
                            <input type="checkbox" value="Tidak" <?php echo isset($data->pupil_isokor)?$data->pupil_isokor != 'ya'?'checked':'':''  ?>>
                            <span>Tidak</span>
                        
                            <input type="checkbox" value="Ya" <?php echo isset($data->pupil_isokor)?$data->pupil_isokor == 'ya'?'checked':'':''  ?>>
                            <span>Ya</span>
                        </span><br>
                        <span>Reflek cahaya: <?=(isset($data->reflek_cahaya)?$data->reflek_cahaya:'')?></span><br>


                        <span>
                            <p>THT :<p>
                            <input type="checkbox" value="Telinga" <?= (isset($data->telinga)?in_array("telinga", $data->telinga)?'checked':'':'') ?>>
                            <span>Telinga <?=':'.' '.(isset($data->value_telinga)?$data->value_telinga:'')?></span>
                            <input type="checkbox" value="Hidung:" <?= (isset($data->hidung)?in_array("hidung", $data->hidung)?'checked':'':'') ?>>
                            <span>Hidung  <?=':'.' '.(isset($data->value_hidung)?$data->value_hidung:'')?></span><br>
                            <input type="checkbox"  value="Tenggorokan: faring: " <?= (isset($data->tenggorokan)?in_array("tenggorokan", $data->tenggorokan)?'checked':'':'') ?>>
                            <span>Tenggorokan:</span>
                            <span >faring: <?=(isset($data->faring)?$data->faring:'')?></span>
                            <span>tonsil: <?=(isset($data->value_tonsil_new)?$data->value_tonsil_new:'')?></span><br>
                            <input type="checkbox" value="Lidah" <?= (isset($data->lidah)?in_array("lidah", $data->lidah)?'checked':'':'') ?>>
                            <span>Lidah : <?=(isset($data->value_lidah)?$data->value_lidah:'')?></span>
                            <input type="checkbox" value="Lidah" <?= (isset($data->bibir)?in_array("bibir", $data->bibir)?'checked':'':'') ?>>
                            <span>Bibir : <?=(isset($data->value_lidah)?$data->value_lidah:'')?></span>
                        
                        </span><br>

                        <span>
                            <p>Leher :<p>
                            <input type="checkbox" value="JVP"<?= (isset($data->jvp_leher)?in_array("JVP", $data->jvp_leher)?'checked':'':'') ?>>
                            <span>JVP : <?=(isset($data->value_leher)?$data->value_leher:'')?></span>
                            <input type="checkbox" value="pembesaran_kelenjar" style="margin-left: 10px;" <?= (isset($data->pembesaran_kelenjar)?in_array("pembesaran kelenjar", $data->pembesaran_kelenjar)?'checked':'':'') ?>>
                            <span>Pembesaran Kelenjar :</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->value_kelenjar)?in_array("tidak", $data->value_kelenjar)?'checked':'':'') ?>>
                            <span>Tidak</span>
                        
                            <input type="checkbox" value="Ya" <?= (isset($data->value_kelenjar)?in_array("ya", $data->value_kelenjar)?'checked':'':'') ?>>
                            <span>Ya</span>
                            <span>ukuran</span>
                            <input type="checkbox" value="Tunggal" <?= (isset($data->value_kelenjar)?in_array("tunggal", $data->value_kelenjar)?'checked':'':'') ?>>
                            <span>Tunggal </span><br>
                            <input type="checkbox" value="Lidah" <?= (isset($data->value_kelenjar)?in_array("multipel", $data->value_kelenjar)?'checked':'':'') ?>>
                            <span>Multipel</span>
                            <input type="checkbox" value="Lidah" <?= (isset($data->value_kelenjar)?in_array("multipel", $data->value_kelenjar)?'checked':'':'') ?>>
                            <span>Kaku Kuduk</span>
                        
                            <input type="checkbox" value="Lidah">
                            <span>Lainnya</span>
                        </span><br>

                        <span>
                            <p>Thoraks	:<p>
                            <input type="checkbox" value="Simetris" <?= (isset($data->thoraks)?in_array("simetris", $data->thoraks)?'checked':'':'') ?>>
                            <span>Simetris </span>
                            <input type="checkbox" value="Asimetris" <?= (isset($data->thoraks)?in_array("asimetris", $data->thoraks)?'checked':'':'') ?>>
                            <span>Asimetris</span>
                            <input type="checkbox" value="Bentuk dada">
                            <span>Bentuk dada : </span>
                        </span><br>

                        <span>
                            -	Cor	:<br>
                            <input type="checkbox" value="S1,S2"<?= (isset($data->cor_s_satu)?in_array("s1_s2", $data->cor_s_satu)?'checked':'':'') ?>>
                            <span>S1,S2 : <?=(isset($data->value_cor_s_satu)?$data->value_cor_s_satu:'')?></span>
                            <span><?=(isset($data->reguler_ireguler)?$data->reguler_ireguler:'')?></span>
                            <input type="checkbox" value="Murmur" <?= (isset($data->murmur)?in_array("murmur", $data->murmur)?'checked':'':'') ?>>
                            <span>Murmur :<?=(isset($data->value_murmur)?$data->value_murmur:'')?></span>
                            <input type="checkbox" value="Lain-lain" <?= (isset($data->cor_lainnya)?in_array("lain_lain", $data->cor_lainnya)?'checked':'':'') ?>>
                            <span>Lain-lain : <?=(isset($data->value_cor_lainnya)?$data->value_cor_lainnya:'')?> </span>
                        </span><br>
                        <span>
                            <span>- Pulmo</span><br>
                            <input type="checkbox" value="Suara napas" <?= (isset($data->suara_nafas)?in_array("suara_napas", $data->suara_nafas)?'checked':'':'') ?>>
                            <span>Suara napas : <?=(isset($data->value_suara_nafas)?$data->value_suara_nafas:'')?></span>
                            <input type="checkbox" value="Rales" <?= (isset($data->rales)?in_array("rales", $data->rales)?'checked':'':'') ?>>
                            <span>Rales : <?=(isset($data->value_rales)?$data->value_rales:'')?></span>
                            <input type="checkbox" value="Wheezing" <?= (isset($data->wheezing)?in_array("wheezing", $data->wheezing)?'checked':'':'') ?>>
                            <span for="Wheezing" >Wheezing: <?=(isset($data->value_wheezing)?$data->value_wheezing:'')?></span><br>
                            <input type="checkbox" value="Lain-lain" <?= (isset($data->lainnya_pulmo)?in_array("lain lain", $data->lainnya_pulmo)?'checked':'':'') ?>>
                            <span>Lain-lain : <?=(isset($data->value_lainnya_pulmo)?$data->value_lainnya_pulmo:'')?></label>
                        </span>

                        <p>
                            <p>Abdomen	:<p>
                                <input type="checkbox" value="Distensi" <?= (isset($data->distensi)?in_array("distensi", $data->distensi)?'checked':'':'') ?>>
                                <span>Distensi : <?=(isset($data->value_distensi)?$data->value_distensi:'')?></span>

                                <input type="checkbox" value="Nyeri tekan" <?= (isset($data->nyeri_tekan)?in_array("nyeri_tekan", $data->nyeri_tekan)?'checked':'':'') ?>>
                                <span>Nyeri tekan : <?=(isset($data->value_nyeri_tekan)?$data->value_nyeri_tekan:'')?></span>
                                <span>Lokasi : <?=(isset($data->lokasi_nyeri_tekan)?$data->lokasi_nyeri_tekan:'')?></span><br>


                                <input type="checkbox" value="Meteorismus"<?= (isset($data->meteorismus)?in_array("meteorismus", $data->meteorismus)?'checked':'':'') ?>>
                                <span>Meteorismus : <?=(isset($data->value_meteorismus)?$data->value_meteorismus:'')?></span>
                                <input type="checkbox" value="Peristaltik" <?= (isset($data->paristaltik)?in_array("paristaltik", $data->paristaltik)?'checked':'':'') ?>>
                                <span>Peristaltik : <?=(isset($data->value_paristaltik)?$data->value_paristaltik:'')?></span>
                                <input type="checkbox" value="Turgor" <?= (isset($data->turgor)?in_array("turgor", $data->turgor)?'checked':'':'') ?>>
                                <span>Turgor : <?=(isset($data->Value_turgor)?$data->Value_turgor:'')?></span>
                                <input type="checkbox" value="Asites" <?= (isset($data->asites)?in_array("asites", $data->asites)?'checked':'':'') ?>>
                                <span>Asites : <?=(isset($data->value_asites)?$data->value_asites:'')?></span>
                            </span>
                        </p>

                        <p>-	Hepar : <?=(isset($data->hepar_massa->hepar)?$data->hepar_massa->hepar:'')?></p>
                        <p>-	Lien  : <?=(isset($data->lien_ginjal->lien)?$data->lien_ginjal->lien:'')?></p>
                        <p>-	Ginjal  : <?=(isset($data->lien_ginjal->ginjal)?$data->lien_ginjal->ginjal:'')?></p>
                        <p>-	Massa : <?=(isset($data->hepar_massa->massa)?$data->hepar_massa->massa:'')?></p>

                        <p>
                            <p>Ekstremitas	:</p>
                            <input type="checkbox" value="Hangat/Dingin" <?= (isset($data->hangat_dingin)?in_array("hangat/dingin", $data->hangat_dingin)?'checked':'':'') ?>>
                            <span>Hangat/Dingin</span>
                            <input type="checkbox" value="Oedema" <?= (isset($data->oedema)?in_array("oedema", $data->oedema)?'checked':'':'') ?>>
                            <span>Oedema <?=(isset($data->value_oedema)?$data->value_oedema:'')?></span>
                            <input type="checkbox" value="CRT" <?= (isset($data->CRT)?in_array("crt", $data->CRT)?'checked':'':'') ?>>
                            <span>CRT : <?=(isset($data->value_crt)?$data->value_crt:'')?></span>

                            <input type="checkbox" value="reflaks_fisiologi" <?= (isset($data->reflaks_fisiologi)?in_array("reflaks fisiologi", $data->reflaks_fisiologi)?'checked':'':'') ?>>
                            <span>Reflaks Fisiologi</span><br>
                            <input type="checkbox" value="refleks_patologi" <?= (isset($data->refleks_patologi)?in_array("refleks_patologi", $data->refleks_patologi)?'checked':'':'') ?>>
                            <span>Refleks Patologi</span>
                            <input type="checkbox" value="refleks_patologi" <?= (isset($data->ekstremitas_lain)?in_array("Ekstremitas", $data->ekstremitas_lain)?'checked':'':'') ?>>
                            <span>Lain Lain : <?=(isset($data->value_ekstremitas)?$data->value_ekstremitas:'')?></span>
                        </p>
                        <p>Kulit	: <?=(isset($data->kulit->kulit)?$data->kulit->kulit:'')?></p>
                        <p>Genitalia eksterna	:  <?=(isset($data->kulit->genitalia_eksterna)?$data->kulit->genitalia_eksterna:'')?></p>
                        <p>Status pubertas	:<br>
                            <input type="checkbox" value="Perempuan">
                                
                            <span>Perempuan:</span>
                            <span>M : <?=(isset($data->MP_pubertas->M_pubertas)?$data->MP_pubertas->M_pubertas:'')?></span>
                            <span style="margin-left:30px">P : <?=(isset($data->MP_pubertas->P_pubertas)?$data->MP_pubertas->P_pubertas:'')?><span><br>
                            <input type="checkbox" value="Laki-laki">
                               
                            <span>Laki-laki	:</span>
                            <span>G : <?=(isset($data->GP_pubertas->G_pubertas)?$data->GP_pubertas->G_pubertas:'')?></span>
                            <span style="margin-left:30px">P : <?=(isset($data->GP_pubertas->P_pubertas_lk)?$data->GP_pubertas->P_pubertas_lk:'')?></span>
                        </p>

                        <p>Status antropometri	:<br>
                            <span>BB/U : <?=(isset($data->status_antropometri->BB_U)?$data->status_antropometri->BB_U:'')?></span>		
                            <span>TB/U atau PB/U : <?=(isset($data->status_antropometri->TB_U)?$data->status_antropometri->TB_U:'')?></span>	
                            <span>BB/TB : <?=(isset($data->status_antropometri->BB_TB)?$data->status_antropometri->BB_TB:'')?></span>	
                            <span>BBl : <?=(isset($data->status_antropometri->BBI)?$data->status_antropometri->BBI:'')?></span>
                        </p>
                    </div>
                </div>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 3 dari 4</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

<!-- halaman 4 -->
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 15px; text-align: center;">
                    CATATAN MEDIS AWAL RAWAT INAP ANAK
                </p>
                <div style="font-size:13px;min-height:870px">
                    
                    <div>
                        <p><b><u>HASIL PEMERIKSAAN PENUNJANG </u></b></p>
                        <p style="margin-left:25px"><?=(isset($data->pem_penunjang)?$data->pem_penunjang:'')?></p>
                    </div>

                    <div>
                        <p><b><u>DIAGNOSIS KERJA/DIAGNOSA BANDING </u></b></p>
                        <p style="margin-left:25px"><?=(isset($data->diag_kerja)?$data->diag_kerja:'')?></p>
                    </div>

                    <div>
                        <p><b><u>RENCANA TATA LAKSANA MEDIS</u></b></p>
                        <p style="margin-left:25px"><?=(isset($data->tata_laksana)?$data->tata_laksana:'')?></p>
                    </div>

                    <br><br><br><br><br><br><br><br>
                    <div class="ttd">
                        <div id="childttd">
                        <span>Tanda tangan dan nama Dokter</span>
                        
                            <br><br><br>
                            <img width="120px" height="110px"src="<?= (isset($catatan_medis_awal_anak[0]->ttd)?$catatan_medis_awal_anak[0]->ttd:''); ?>" alt=""><br>
                            <span><i><?= isset($catatan_medis_awal_anak[0]->nm_dokter)?$catatan_medis_awal_anak[0]->nm_dokter:'' ?></i></span>
                            <span>SIP. <?= isset($sip_dokter->nipeg)?$sip_dokter->nipeg:'' ?></span>
                        </div>
                    </div>
                </div>
            
                
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 4 dari 4</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

        
</body>
    
</html>