<?php
$data = isset($get_assesment_keperawatan_irj->formjson)?json_decode($get_assesment_keperawatan_irj->formjson):'';
// var_dump($data);
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK KEBIDANAN</p>
            <p align="center" style="font-size:12px;font-style:italic">(Dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</p>

            <table width="100%" border="1" cellpadding="3px">

                <tr >
                    <td width="50%" style="font-size:11px">Tanggal : <?= isset($data->tgl_jam)?date('d-m-Y',strtotime($data->tgl_jam)).' ':'' ?></td>
                    <td width="50%" style="font-size:11px">Jam : <?= isset($data->tgl_jam)?date('H:i',strtotime($data->tgl_jam)).' ':'' ?>WIB</td>
                </tr>

                <tr >
                    <td colspan="2">
                        <table width="100%">
                            <tr>
                                <td style="font-size:11px">Sumber Data</td>
                                <td width="2%" style="font-size:11px">:</td>
                                <td width="80%" style="font-size:11px">
                                    <input type="checkbox" id="pasien" name="pasien" value="" <?php echo isset($data->sumber_data)?($data->sumber_data == "pasien" ? "checked" : "disabled"):""; ?>>
                                    <span>Pasien</span>
                                    <input type="checkbox" id="keluarga" name="keluarga" value="" <?php echo isset($data->sumber_data)?($data->sumber_data == "keluarga" ? "checked" : "disabled"):""; ?>>
                                    <span>Keluarga</span>
                                    <input type="checkbox" id="lainnya" name="lainnya" value="" <?php echo isset($data->sumber_data)?($data->sumber_data == "lainnya" ? "checked" : "disabled"):""; ?>>
                                    <span><?= isset($data->check_sumber_data)?$data->check_sumber_data:'lainnya' ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="18%" style="font-size:11px">Rujukan</td>
                                <td width="2%" style="font-size:11px">:</td>
                                <td width="80%" style="font-size:11px">
                                    <input type="checkbox" id="tidak" name="tidak" value="" <?php echo isset($data->rujukan)?($data->rujukan == "tidak" ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak</span>
                                    <input type="checkbox" id="ya" name="ya" value="" <?php echo isset($data->rujukan)?($data->rujukan != "tidak" ? "checked" : "disabled"):""; ?>>
                                    <span>Ya :</span>
                                    <input type="checkbox" id="rs" name="rs" value="" style="margin-left:12px;" <?php echo isset($data->check_rujukan)?($data->check_rujukan == "rs" ? "checked" : "disabled"):""; ?>>
                                    <span>RS <?= isset($data->check_rs)?':'.' '.$data->check_rs:'' ?></span>
                                    <input type="checkbox" id="puskesmas" name="puskesmas" value="" style="margin-left:12px;" <?php echo isset($data->check_rujukan)?($data->check_rujukan == "puskesmas" ? "checked" : "disabled"):""; ?>>
                                    <span>Puskesmas <?= isset($data->check_puskesmas)?':'.' '.$data->check_puskesmas:'' ?></span>
                                    <input type="checkbox" id="dokter" name="dokter" value="" <?php echo isset($data->check_rujukan)?($data->check_rujukan == "dokter" ? "checked" : "disabled"):""; ?>>
                                    <span>Dokter <?= isset($data->check_dokter)?':'.' '.$data->check_dokter:'' ?></span>
                                </td>
                            </tr>
                            
                        </table>

                    </td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-weight:bold;text-align:center" style="font-size:11px">DATA SUBJEKTIF</td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px">
                        <div style="min-height:60px">
                            A. Keluhan Utama
                            <p><?= isset($data->keluhan_utama)?$data->keluhan_utama:'' ?></p>
                        </div>   
                    </td>
                </tr>

                <tr>
                    <td style="font-size:11px">
                        <span>B. Riwayat Menstruasi</span>
                        <div style="margin-left:15px">
                            <table width="100%">
                                <tr>
                                    <td width="60%" style="font-size:11px">
                                        <p>
                                            <li>
                                            Manarche umur : <?= isset($data->manarche_umur)?$data->manarche_umur.' '.'/tahun':'' ?>
                                            </li>
                                        </p> 
                                    </td>

                                    <td width="40%" style="font-size:11px">
                                        <p> Siklus: <?= isset($data->siklus)?$data->siklus.' '.'/hari':'' ?></p> 
                                    </td>

                                </tr>
                                <tr>
                                    <td width="60%" style="font-size:11px">
                                       
                                            <input type="checkbox" id="teratur" name="teratur" value="" style="margin-left:10px" <?php echo isset($data->teratur_tidak_teratur)?($data->teratur_tidak_teratur == "teratur" ? "checked" : "disabled"):""; ?>>
                                            <span style="font-size:11px">Teratur</span>
                                            <input type="checkbox" id="tidak_teratur" name="tidak_teratur" value="" <?php echo isset($data->teratur_tidak_teratur)?($data->teratur_tidak_teratur == "tidak_teratur" ? "checked" : "disabled"):""; ?>>
                                            <span style="font-size:11px">Tidak Teratur</span>
                                       
                                    </td>

                                    <td width="40%" style="font-size:11px">
                                        <span> Lama: <?= isset($data->check_tidak_teratur)?$data->check_tidak_teratur.' '.'/hari':'' ?></span> 
                                    </td>

                                </tr>
                            </table>
                            <p><li>Volume : <?= isset($data->volume)?$data->volume.' '.'cc':'' ?></li></p>
                            <span style="margin-left:15px">Keluhan saat haid : <?= isset($data->keluhan_saat_haid)?$data->keluhan_saat_haid:'' ?></span>
                        </div>  
                    </td>
                    <td style="font-size:11px">
                        <span>C. Riwayat Perkawinan</span>
                        <p>
                            <li style="margin-left:10px">
                                <span>Status</span>
                                    <input type="checkbox" id="belum_kawin" name="belum_kawin" value="" <?php echo isset($data->status_kawin)?($data->status_kawin == "belum_kawin" ? "checked" : "disabled"):""; ?>>
                                    <span>Belum Kawin</span>
                                    <input type="checkbox" id="cerai" name="cerai" value="" <?php echo isset($data->status_kawin)?($data->status_kawin == "cerai" ? "checked" : "disabled"):""; ?>>
                                    <span>Cerai</span>
                                    <input type="checkbox" id="kawin" name="kawin" value="" <?php echo isset($data->status_kawin)?($data->status_kawin == "kawin" ? "checked" : "disabled"):""; ?>>
                                    <span>Kawin: <?= isset($data->check_kawin)?$data->check_kawin.' '.'kali':'' ?></span>
                            </li>
                        </p>
                        <li style="margin-left:10px">
                            <span>Umur waktu pertama kawin : <?= isset($data->umur_waktu_kawin)?$data->umur_waktu_kawin.' '.'tahun':'' ?></span>
                            <p style="margin-left:15px">Kawin dengan suami 1 : <?= isset($data->kawin_dengan_suami1)?$data->kawin_dengan_suami1.' '.'tahun':'' ?></p>
                            <span style="margin-left:15px">Ke 2,3 : <?= isset($data->kawin_dengan_suami2)?$data->kawin_dengan_suami2.' '.'tahun':'' ?></span>
                        </li>
                    </td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px">
                        <span>D. Riwayat Kehamilan, persalinan dan nifas yang lalu</span> 
                        <p>
                            <span style="margin-left:20px">G : <?= isset($data->kehamilan_ke_berapa)?$data->kehamilan_ke_berapa:'' ?></span>
                            <span style="margin-left:15px">P : <?= isset($data->partus_melahir)?$data->partus_melahir:'' ?></span>
                            <span style="margin-left:15px">A : <?= isset($data->berapa_aborsi)?$data->berapa_aborsi:'' ?></span>
                            <span style="margin-left:15px">H : <?= isset($data->yang_hidup)?$data->yang_hidup:'' ?></span>
                            <span style="margin-left:15px">Usia Kehamilan  : <?= isset($data->usia_kehamilan)?$data->usia_kehamilan:'' ?></span>
                        </p>
                        <table width="100%" border="1">
                            <tr>
                                <td width="6.5%" rowspan="3" style="font-size:11px">No</td>
                                <td width="6.5%" rowspan="3" style="font-size:11px">Tgl Partus</td>
                                <td width="6.5%" colspan="3" style="font-size:11px">Umur Hamil</td>
                                <td width="6.5%" rowspan="3" style="font-size:11px">Jenis Partus</td>
                                <td width="6.5%" colspan="2" style="font-size:11px">Penolong</td>
                                <td width="6.5%" colspan="2" style="font-size:11px">Anak</td>
                                <td width="6.5%" colspan="4" style="font-size:11px">Keadaan anak sekarang</td>
                                <td width="6.5%" rowspan="3" style="font-size:11px">ket/komplikasi</td>
                               
                            </tr>

                            <tr>   
                                <td rowspan="2" style="font-size:11px">Abortus</td>
                                <td rowspan="2" style="font-size:11px">Prematur</td>
                                <td rowspan="2" style="font-size:11px">Aterm</td>
                                <td rowspan="2" style="font-size:11px">nakes</td>
                                <td rowspan="2" style="font-size:11px">Non kes</td>
                                <td rowspan="2" style="font-size:11px"></td>
                                <td rowspan="2" style="font-size:11px"></td>
                                <td rowspan="2" style="font-size:11px">BBL</td>
                                <td colspan ="2" style="font-size:11px">Hidup</td>
                                <td rowspan="2" style="font-size:11px">Meninggal</td>    
                            </tr>

                            <tr> 
                                <td style="font-size:11px">normal</td>
                                <td style="font-size:11px">cacat</td>
                            </tr>

                            <?php
                            $no=1; 
                            $jml_array = isset($data->table)?count($data->table):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <tr> 
                                <td style="font-size:11px"><?= $no++ ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->tanggal)?$data->table[$x]->tanggal:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->abostus)?$data->table[$x]->abostus:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->prematur)?$data->table[$x]->prematur:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->aterm)?$data->table[$x]->aterm:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->jenis_partus)?$data->table[$x]->jenis_partus:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->{'na.kes'})?$data->table[$x]->{'na.kes'}:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->non_kes)?$data->table[$x]->non_kes:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->anak)?$data->table[$x]->anak:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->anak)?$data->table[$x]->anak:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->bbl)?$data->table[$x]->bbl:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->normal)?$data->table[$x]->normal:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->cacat)?$data->table[$x]->cacat:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->meninggal)?$data->table[$x]->meninggal:'' ?></td>
                                <td style="font-size:11px"> <?= isset($data->table[$x]->ket_komplikasi)?$data->table[$x]->ket_komplikasi:'' ?></td>
    
                            </tr>
                        <?php } ?>

                            
                           
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="font-size:11px" colspan="2">
                        <span>E. Riwayat pemakaian alat kontrasepsi</span>
                        <div style="margin-left:25px">
                            <p>
                                <input type="checkbox" id="tidak_menggunakan" name="tidak_menggunakan" value="" <?php echo isset($data->kontrasepsi)?($data->kontrasepsi == "tidak_menggunakan" ? "checked" : "disabled"):""; ?>>
                                <span>Tidak menggunakan</span>

                                <input type="checkbox" id="menggunakan" name="menggunakan" value="" <?php echo isset($data->kontrasepsi)?($data->kontrasepsi == "menggunakan" ? "checked" : "disabled"):""; ?>>
                                <span>Menggunakan, jenis : <?= isset($data->jenis)?$data->jenis:'' ?></span>

                                <span style="margin-left:20px">Lama pemakaian : <?= isset($data->lama_pemakaian)?$data->lama_pemakaian:'' ?></span>
                            </p>
                        </div>

                        <span>F. Riwayat hamil</span>
                        <div style="margin-left:25px">
                            <p>
                                <li>
                                    <span>Haid pertama dan haid terakhir : <?= isset($data->hari_pertama_haid)?$data->hari_pertama_haid:'' ?></span>
                                    <span style="margin-left:30px">Tafsiran Partus : <?= isset($data->tafsiran_partus)?$data->tafsiran_partus: ''?></span>
                                </li>
                            </p>
                            <table width="100%">
                                <tr>
                                    <td width="23%" style="font-size:11px">
                                        <li>
                                            <span>Ante Natal Care</span>
                                        </li>
                                    </td>
                                    <td width="2%" style="font-size:11px">:</td>
                                    <td width="75%" style="font-size:11px">
                                        <input type="checkbox" id="tidak" name="tidak" value="" <?php echo isset($data->ante_natal_care)?($data->ante_natal_care == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak</span>
                                        <input type="checkbox" id="ya" name="ya" value="" <?php echo isset($data->ante_natal_care)?($data->ante_natal_care == "ya" ? "checked" : "disabled"):""; ?>>
                                        <span>Ya : di</span>
                                        <input type="checkbox" id="dokter_kan" name="dokter_kan" value="" <?php echo isset($data->check_ya_natal)?($data->check_ya_natal == "dokter_kandungan" ? "checked" : "disabled"):""; ?>>
                                        <span>Dokter Kandungan</span>
                                        <input type="checkbox" id="dokter_um" name="dokter_um" value="" <?php echo isset($data->check_ya_natal)?($data->check_ya_natal == "dokter_umum" ? "checked" : "disabled"):""; ?>>
                                        <span>Dokter umum</span>
                                        <input type="checkbox" id="bidan" name="bidan" value="" <?php echo isset($data->check_ya_natal)?($data->check_ya_natal == "tidak_menggunakan" ? "checked" : "disabled"):""; ?>>
                                        <span>Bidan</span>
                                        <input type="checkbox" id="lainnya" name="lainnya" value="" <?php echo isset($data->check_ya_natal)?($data->check_ya_natal == "lainnya" ? "checked" : "disabled"):""; ?>>
                                        <span><?= isset($data->check_lainnya_natal)?$data->check_lainnya_natal:'' ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="18%" style="font-size:11px">
                                        <p>
                                            <li>
                                                <span>Frekuensi </span>
                                            </li>
                                        </p>
                                       
                                    </td>
                                    <td width="2%" style="font-size:11px"><p>:</p></td>
                                    <td width="80%" style="font-size:11px">
                                    <p>
                                        <input type="checkbox" id="1x" name="1x" value="" <?php echo isset($data->frekuensi)?($data->frekuensi == "1" ? "checked" : "disabled"):""; ?>>
                                        <span>1x</span>
                                        <input type="checkbox" id="2x" name="2x" value="" <?php echo isset($data->frekuensi)?($data->frekuensi == "2" ? "checked" : "disabled"):""; ?>>
                                        <span>2x</span>
                                        <input type="checkbox" id="3x" name="3x" value="" <?php echo isset($data->frekuensi)?($data->frekuensi == "3" ? "checked" : "disabled"):""; ?>>
                                        <span>3x</span>
                                        <input type="checkbox" id="4x" name="4x" value="" <?php echo isset($data->frekuensi)?($data->frekuensi == "4" ? "checked" : "disabled"):""; ?>>
                                        <span>>3x</span>
                                    </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="18%" style="font-size:11px">
                                        <li>
                                            <span>Imunisasi TT</span>
                                        </li>
                                    </td>
                                    <td width="2%" style="font-size:11px">:</td>
                                    <td width="80%" style="font-size:11px">
                                        <input type="checkbox" id="tidak" name="tidak" value=""  <?php echo isset($data->imunisasi)?($data->imunisasi == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak</span>
                                        <input type="checkbox" id="ya" name="ya" value=""  <?php echo isset($data->imunisasi)?($data->imunisasi == "ya" ? "checked" : "disabled"):""; ?>>
                                        <span>Ya <?= isset($data->check_ya)?' '.':'.$data->check_ya.' '.'kali':'' ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="18%" style="font-size:11px">
                                    <p>
                                        <li>
                                            <span>Keluhan saat hamil</span>
                                        </li>
                                    </p>
                                    </td>
                                    <td width="2%" style="font-size:11px"><p>:</p></td>
                                    <td width="80%" style="font-size:11px">
                                    <p>
                                        <input type="checkbox" id="mual" name="mual" value="" <?php echo isset($data->keluhan_saat_hamil)?(in_array("mual", $data->keluhan_saat_hamil) ? "checked" : "disabled"):""; ?>>
                                        <span>mual</span>
                                        <input type="checkbox" id="muntah" name="muntah" value="" <?php echo isset($data->keluhan_saat_hamil)?(in_array("muntah", $data->keluhan_saat_hamil) ? "checked" : "disabled"):""; ?>>
                                        <span>muntah</span>
                                        <input type="checkbox" id="perdarahan" name="perdarahan" value="" <?php echo isset($data->keluhan_saat_hamil)?(in_array("perdarahan", $data->keluhan_saat_hamil) ? "checked" : "disabled"):""; ?>>
                                        <span>Perdarahan</span>
                                        <input type="checkbox" id="pusing" name="pusing" value="" <?php echo isset($data->keluhan_saat_hamil)?(in_array("pusing", $data->keluhan_saat_hamil) ? "checked" : "disabled"):""; ?>>
                                        <span>Pusing</span>
                                        <input type="checkbox" id="sakit_kepala" name="sakit_kepala" value="" <?php echo isset($data->keluhan_saat_hamil)?(in_array("sakit_kepala", $data->keluhan_saat_hamil) ? "checked" : "disabled"):""; ?>>
                                        <span>sakit kepala</span><br>
                                        <input type="checkbox" id="lainnya" name="lainnya" value="" <?php echo isset($data->keluhan_saat_hamil)?(in_array("lainnya", $data->keluhan_saat_hamil) ? "checked" : "disabled"):""; ?>>
                                        <span>lainnya <?= isset($data->check_lainnya)?' '.':'.$data->check_lainnya:'' ?></span>
                                    </p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        
                    </td>
                   
                </tr>

            </table><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:left;font-size:12px">Hal 1 dari 4</p>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK KEBIDANAN</p>

            <table  width="100%" border="1" cellpadding="3px">
                <tr>
                    <td colspan ="2" style="font-size:11px">
                        <span>G. Riwayat penyakit yang lalu/operasi</span>
                        <div style="margin-left:25px">
                            <p>
                                <input type="checkbox" id="hipertensi" name="hipertensi" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("hipertensi", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>Hipertensi</span>
                                <input type="checkbox" id="DM" name="DM" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("dm", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>DM</span>
                                <input type="checkbox" id="jantung" name="jantung" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("jantung", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>Jantung</span>
                                <input type="checkbox" id="asthma" name="hipertensi" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("asthma", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>Asthma</span>
                                <input type="checkbox" id="jiwa" name="jiwa" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("jiwa", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>Jiwa</span>
                                <input type="checkbox" id="hepatitis" name="hepatitis" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("hepatitis", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>Hepatitis</span><br>
                                <input type="checkbox" id="tumor" name="tumor" value="" <?php echo isset($data->riwayat_penyakit)?(in_array("tumor", $data->riwayat_penyakit) ? "checked" : "disabled"):""; ?>>
                                <span>Tumor, di <?= isset($data->check_tumor)?$data->check_tumor:'' ?></span>
                                <input type="checkbox" id="lainnya" name="lainnya" value="" <?php echo isset($data->lainnya)?(in_array("lainnya", $data->lainnya) ? "checked" : "disabled"):""; ?>>
                                <span>Lainnya <?= isset($data->check_lainnya1)?$data->check_lainnya1:'' ?></span>
                            </p>

                            <li>
                                <span>Pernah dirawat</span>
                                <input type="checkbox" id="tidak" name="tidak" value="" <?php echo isset($data->pernah_dirawat)?($data->pernah_dirawat == "tidak" ? "checked" : "disabled"):""; ?>>
                                <span>Tidak</span>
                                <input type="checkbox" id="ya" name="ya" value="" <?php echo isset($data->pernah_dirawat)?($data->pernah_dirawat == "ya" ? "checked" : "disabled"):""; ?>>
                                <span>Ya, alasan dirawat :  <?= isset($data->alasan_dirawat)?$data->alasan_dirawat:'' ?></span>
                                <span style="margin-left:20px">Tanggal :  <?= isset($data->tanggal_dirawat)?$data->tanggal_dirawat:'' ?></span>
                                <span style="margin-left:20px">di :  <?= isset($data->dirawat_di)?$data->dirawat_di:'' ?></span>
                            </li>

                            <li>
                                <span>Pernah dioperasi</span>
                                <input type="checkbox" id="tidak" name="tidak" value="" <?php echo isset($data->pernah_dioperasi)?($data->pernah_dioperasi == "tidak" ? "checked" : "disabled"):""; ?>>
                                <span>Tidak</span>
                                <input type="checkbox" id="ya" name="ya" value="" <?php echo isset($data->pernah_dioperasi)?($data->pernah_dioperasi == "ya" ? "checked" : "disabled"):""; ?>>
                                <span>Ya, alasan dioperasi :  <?= isset($data->alasan_dirawat1)?$data->alasan_dirawat1:'' ?></span>
                                <span style="margin-left:20px">Tanggal :  <?= isset($data->tanggal_dirawat1)?$data->tanggal_dirawat1:'' ?></span>
                                <span style="margin-left:20px">di :  <?= isset($data->dirawat1)?$data->dirawat1:'' ?></span>
                            </li>
                        
                           
                            
                                   
                               
                        </div>

                        <p>H. Riwayat alergi :</p> 
                            <div style="margin-left:25px">
                                <table width="100%">
                                    <tr>
                                        <td width="20%" style="font-size:11px" rowspan="3">
                                            <input type="checkbox" id="tidak" name="tidak" value="" <?php echo isset($data->riwayat_alergi)?($data->riwayat_alergi == "tidak" ? "checked" : "disabled"):""; ?>>
                                            <span>Tidak</span>
                                            <input type="checkbox" id="ya" name="ya" value="" <?php echo isset($data->riwayat_alergi)?($data->riwayat_alergi == "ya" ? "checked" : "disabled"):""; ?>>
                                            <span>Ya,</span>
                                        </td>

                                        <td width="13%" style="font-size:11px">Obat</td>
                                        <td width="2%" style="font-size:11px">:</td>
                                        <td width="25%" style="font-size:11px"><?= isset($data->obat)?$data->obat:'' ?></td>
                                        <td width="13%" style="font-size:11px">Tipe reaksi</td>
                                        <td width="2%" style="font-size:11px">:</td>
                                        <td width="25%" style="font-size:11px"><?= isset($data->tipe_reaksi)?$data->tipe_reaksi:'' ?></td>
                                        
                                    </tr>

                                    <tr>
                                        <td width="13%" style="font-size:11px">Makanan</td>
                                        <td width="2%" style="font-size:11px">:</td>
                                        <td width="25%" style="font-size:11px"><?= isset($data->makanan)?$data->makanan:'' ?></td>
                                        <td width="13%" style="font-size:11px">Tipe reaksi</td>
                                        <td width="2%" style="font-size:11px">:</td>
                                        <td width="25%" style="font-size:11px"><?= isset($data->tipe_reaksi1)?$data->tipe_reaksi1:'' ?></td>
                                        
                                    </tr>

                                    <tr>

                                        <td width="13%" style="font-size:11px">Lain lain</td>
                                        <td width="2%" style="font-size:11px">:</td>
                                        <td width="25%" style="font-size:11px"><?= isset($data->lainya)?$data->lainya:'' ?></td>
                                        <td width="13%" style="font-size:11px">Tipe reaksi</td>
                                        <td width="2%" style="font-size:11px">:</td>
                                        <td width="25%" style="font-size:11px"><?= isset($data->tiper_reaksi2)?$data->tiper_reaksi2:'' ?></td>
                                        
                                    </tr>
                                </table>
                            </div>
                    </td>
                </tr>

                <tr>
                    <td width="50%" style="font-size:11px">
                        <span>I. Riwayat Penyakit Keluarga</span>
                        <p>
                            <input type="checkbox" value="Tidak ada" style="margin-left:20px" <?php echo isset($data->riwayat_penyakit_keluarga)?($data->riwayat_penyakit_keluarga == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                            <span>Tidak ada</span>
                            <input type="checkbox" value="ada" <?php echo isset($data->riwayat_penyakit_keluarga)?($data->riwayat_penyakit_keluarga == "ada" ? "checked" : "disabled"):""; ?>>
                            <span>Ada, jelaskan <?= isset($data->check_jelaskan)?$data->check_jelaskan:'' ?></span>
                        </p>
                    </td>
                    <td width="50%" style="font-size:11px">
                        <span>J. Riwayat Penyakit gynekologi</span>
                            <p>
                                <input type="checkbox" value="Tidak ada" style="margin-left:20px" <?php echo isset($data->{'riwayat-penyakit_gynekologi'})?($data->{'riwayat-penyakit_gynekologi'} == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                                <span>Tidak ada</span>
                                <input type="checkbox" value="ada" <?php echo isset($data->{'riwayat-penyakit_gynekologi'})?($data->{'riwayat-penyakit_gynekologi'} == "ada" ? "checked" : "disabled"):""; ?>>
                                <span>Ada, jelaskan <?= isset($data->question11)?$data->question11:'' ?></span>
                            </p>
                    </td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px">
                        <span>K. Kebutuhan Bio-psikososial-spritual</span>
                        <div style="margin-left:25px">
                            <table width="100%">
                                <tr>
                                    <td width="18%" style="font-size:11px"><p>Pola Makan</p></td>
                                    <td width="2%" style="font-size:11px"><p>:</p></td>
                                    <td width="30%" style="font-size:11px"><p><?= isset($data->pola_makan)?$data->pola_makan:'' ?> x/hari</p></td>
                                    <td width="18%" style="font-size:11px"><p>Terakhir jam</p></td>
                                    <td width="2%" style="font-size:11px"><p>:</p></td>
                                    <td width="30%" style="font-size:11px"><p><?= isset($data->terakhir_jam)?$data->terakhir_jam:'' ?></p></td>
                                </tr>

                                <tr>
                                    <td style="font-size:11px">Pola Minum</td>
                                    <td style="font-size:11px">:</td>
                                    <td style="font-size:11px"><?= isset($data->pola_minum)?$data->pola_minum:'' ?> cc/hari</td>
                                    <td style="font-size:11px">Terakhir jam</td>
                                    <td style="font-size:11px">:</td>
                                    <td style="font-size:11px"><?= isset($data->terakhir_jam1)?$data->terakhir_jam1:'' ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:11px"><p>Pola Eliminasi</p></td>
                                    <td style="font-size:11px"><p>:</p></td>
                                    <td style="font-size:11px"> 
                                        <p>BAK <?= isset($data->bak)?$data->bak:'' ?> cc/hari</p>
                                        <p>BAK <?= isset($data->bak1)?$data->bak1:'' ?> cc/hari</p>
                                    </td>
                                    <td style="font-size:11px">
                                        <p>Terakhir jam
                                            
                                        </p>
                                        <p>Terakhir jam</p>
                                    </td>
                                    <td style="font-size:11px">
                                        <p>:</p>
                                        <p>: </p>
                                    </td>
                                    <td style="font-size:11px"><p>
                                        <?= isset($data->terakhir_jam2)?$data->terakhir_jam2:'' ?>
                                        <span style="margin-left:40px">Warna : <?= isset($data->warna)?$data->warna:'' ?></span>
                                        </p>
                                        <?= isset($data->terakhir_jam3)?$data->terakhir_jam3:'' ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:11px">Pola istirahat</td>
                                    <td style="font-size:11px">:</td>
                                    <td style="font-size:11px">tidur <?= isset($data->tidur)?$data->tidur:'' ?> jam/hari</td>
                                    <td style="font-size:11px"></td>
                                    <td style="font-size:11px"></td>
                                    <td style="font-size:11px"></td>
                                </tr>
                            </table>

                            <table width="100%">
                                <tr>
                                    <td width="28%" style="font-size:11px"><p>Penerimaan kondisi saat ini</p></td>
                                    <td width="2%" style="font-size:11px"><p>:</p></td>
                                    <td width="70%" style="font-size:11px">
                                        <p>
                                            <input type="checkbox"  value="menerima" <?php echo isset($data->penerima_kondis)?($data->penerima_kondis == "menerima" ? "checked" : "disabled"):""; ?>>
                                            <span>Menerima</span>
                                            <input type="checkbox"  value="tidak_menerima" <?php echo isset($data->penerima_kondis)?($data->penerima_kondis == "tidak_menerima" ? "checked" : "disabled"):""; ?>>
                                            <span>Tidak Menerima</span>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="28%" style="font-size:11px">Dukungan sosial dari</td>
                                    <td width="2%" style="font-size:11px">:</td>
                                    <td width="70%" style="font-size:11px">
                                        <input type="checkbox"  value="orang tua" <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "orangtua" ? "checked" : "disabled"):""; ?>>
                                        <span>Orang tua</span>
                                        <input type="checkbox"  value="keluarga" <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "keluarga" ? "checked" : "disabled"):""; ?>>
                                        <span>Keluarga</span>
                                        <input type="checkbox"  value="lainnya" <?php echo isset($data->dukungan_sosial)?($data->dukungan_sosial == "lainnya" ? "checked" : "disabled"):""; ?>>
                                        <span><?= isset($data->check_dukungan_sosial)?$data->check_dukungan_sosial:'' ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="28%" style="font-size:11px"><p>Spiritual</p></td>
                                    <td width="2%" style="font-size:11px"><p>:</p></td>
                                    <td width="70%" style="font-size:11px">
                                        <p>
                                            <input type="checkbox"  value="islam" <?php echo isset($data->spiritual)?($data->spiritual == "islam" ? "checked" : "disabled"):""; ?>>
                                            <span>Islam</span>
                                            <input type="checkbox"  value="kristen" <?php echo isset($data->spiritual)?($data->spiritual == "kristen" ? "checked" : "disabled"):""; ?>>
                                            <span>Kristen</span>
                                            <input type="checkbox"  value="katholik" <?php echo isset($data->spiritual)?($data->spiritual == "katholik" ? "checked" : "disabled"):""; ?>>
                                            <span>Katholik</span>
                                            <input type="checkbox"  value="hindu" <?php echo isset($data->spiritual)?($data->spiritual == "" ? "checked" : "disabled"):""; ?>>
                                            <span>Hindu</span>
                                            <input type="checkbox"  value="budha" <?php echo isset($data->spiritual)?($data->spiritual == "budha" ? "checked" : "disabled"):""; ?>>
                                            <span>Budha</span>
                                            <input type="checkbox"  value="lainnya" <?php echo isset($data->spiritual)?($data->spiritual == "Lainnya" ? "checked" : "disabled"):""; ?>>
                                            <span><?= isset($data->check_spiritual)?$data->check_spiritual:'' ?></span>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="font-size:11px" colspan="3">Pendamping persalinan yang diinginkan (bila hamil) :</td>
                                </tr>

                            </table>     
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px">L. Penilaian Nyeri</td>
                </tr>

                <tr>
                    <td width="50%" style="font-size:11px">
                        <div style="margin-left:25px">
                                <input type="checkbox" value="Tidak ada" <?php echo isset($data->penilaian_nyeri)?($data->penilaian_nyeri == "tidak_ada_nyeri" ? "checked" : "disabled"):""; ?>>
                                <span>Tidak ada nyeri</span>
                                <input type="checkbox" value="nyeri_akut" <?php echo isset($data->penilaian_nyeri)?($data->penilaian_nyeri == "nyeri_akut" ? "checked" : "disabled"):""; ?>>
                                <span>Nyeri Akut</span><br>
                                <input type="checkbox" value="nyeri_kronis" <?php echo isset($data->penilaian_nyeri)?($data->penilaian_nyeri == "nyeri_kronis" ? "checked" : "disabled"):""; ?>>
                                <span>Nyeri Kronis</span>

                                <p>P(Profokatif/penyebab) : <?= isset($data->profokatif)?$data->profokatif:'' ?></p>
                                <p>Q(Quality/gambaran nyeri) : <?= isset($data->quality)?$data->quality:'' ?></p>
                                <p>R(Region/lokasi nyeri) : <?= isset($data->region)?$data->region:'' ?></p>
                                <p>S(Skalaseveritas : <?= isset($data->question15)?$data->question15:'' ?></p>
                                <p>T(Timing/waktu nyeri) : <?= isset($data->question16)?$data->question16:'' ?></p>

                                <p>Apakah nyeri yang dirasakan </p>
                                <li>
                                    Menghalangi tidur malam anda 
                                    <input type="checkbox" value="ya" <?php echo isset($data->menghalangi_tidur)?($data->menghalangi_tidur == "ya" ? "checked" : "disabled"):""; ?>>
                                    <span>Ya</span>
                                    <input type="checkbox" value="tidak" <?php echo isset($data->menghalangi_tidur)?($data->menghalangi_tidur == "tidak" ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak</span>
                                </li>
                                <p>
                                    <li>
                                        Menghalangi anda beraktifitas 
                                        <input type="checkbox" value="ya" <?php echo isset($data->menghalangi_beraktivitas)?($data->menghalangi_beraktivitas == "ya" ? "checked" : "disabled"):""; ?>>
                                        <span>Ya</span>
                                        <input type="checkbox" value="tidak" <?php echo isset($data->menghalangi_beraktivitas)?($data->menghalangi_beraktivitas == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak</span>
                                    </li>
                                </p>
                                <li>
                                    Sakit dirasakan setiap hari
                                    <input type="checkbox" value="ya" <?php echo isset($data->sakit_dirasakan)?($data->sakit_dirasakan == "ya" ? "checked" : "disabled"):""; ?>>
                                    <span>Ya</span>
                                    <input type="checkbox" value="tidak" <?php echo isset($data->sakit_dirasakan)?($data->sakit_dirasakan == "tidak" ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak</span>
                                </li>
                        </div>
                        
                    </td>

                    <!-- gambar nya load disini file nya di : assests/images/nyeri.png -->
                    <td width="50%" style="font-size:11px">

                        <div style="position:absolute;">
                            <div style="position:absolute;">
                                <?php
                                if(isset($data->imagenyeri)){
                                ?>
                                    <img src=" <?= $data->imagenyeri ?>"  alt="img" height="200" width="200">
                                <?php } ?>
                            </div>
                                <img src="<?= base_url('assets/images/nyeri.png') ?>" height="200" width="200" alt="">

                        </div>
    
                
                    </td>
                </tr>

                <tr>
                    <td colspan="2" style="font-size:11px">
                        <span>M. Kriteria resiko jatuh/cedera</span>
                        <div style="margin-left:25px">
                            <p>Total skor: <?= isset($data->total_skor)?$data->total_skor:'' ?>
                                <input type="checkbox" value="rendah" style="margin-left:15px" <?php echo isset($data->question20)?($data->question20 == "rendah" ? "checked" : "disabled"):""; ?>>
                                <span>Rendah</span>
                                <input type="checkbox" value="tinggi" <?php echo isset($data->question20)?($data->question20 == "tinggi" ? "checked" : "disabled"):""; ?>>
                                <span>Tinggi</span>
                                <input type="checkbox" value="sangat tinggi" <?php echo isset($data->question20)?($data->question20 == "sangat_tinggi" ? "checked" : "disabled"):""; ?>>
                                <span>Sangat tinggi</span>
                            </p>
                        </div>
                        <span>N. Kebutuhan komunikasi dan pengajaran</span>
                            <div style="margin-left:25px">
                                <p>
                                    <li>
                                        Bicara
                                        <input type="checkbox" value="normal" <?php echo isset($data->bicara)?($data->bicara == "normal" ? "checked" : "disabled"):""; ?>>
                                        <span>Normal</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->bicara)?($data->bicara == "serangan" ? "checked" : "disabled"):""; ?>>
                                        <span>Serangan awal gangguan bicara,kapan : <?= isset($data->kapan)?$data->kapan:'' ?></span>
                                    </li>
                                </p>
                                <li>
                                        Bahasa sehari hari :
                                        <input type="checkbox" value="indonesia" <?php echo isset($data->bahasa_sehari_hari)?($data->bahasa_sehari_hari == "indonesia" ? "checked" : "disabled"):""; ?>>
                                        <span>Indonesia</span>
                                        <input type="checkbox" value="aktif" <?php echo isset($data->aktif_pasif)?($data->aktif_pasif == "aktif" ? "checked" : "disabled"):""; ?>>
                                        <span>aktif</span>
                                        <input type="checkbox" value="pasif" <?php echo isset($data->aktif_pasif)?($data->aktif_pasif == "pasif" ? "checked" : "disabled"):""; ?>>
                                        <span>pasif</span>
                                        <input type="checkbox" value="daerah" <?php echo isset($data->aktif_pasif)?($data->aktif_pasif == "daerah" ? "checked" : "disabled"):""; ?>>
                                        <span>daerah, jelaskan <?= isset($data->check_jelaskan1)?$data->check_jelaskan1:'' ?></span>
                                </li>
                                <p style="margin-left:155px">
                                        <input type="checkbox" value="inggris" <?php echo isset($data->bahasa_sehari_hari)?($data->bahasa_sehari_hari == "inggris" ? "checked" : "disabled"):""; ?>>
                                        <span>inggris</span>
                                        <input type="checkbox" value="aktif" <?php echo isset($data->aktif_pasif1)?($data->aktif_pasif1 == "aktif" ? "checked" : "disabled"):""; ?>>
                                        <span>aktif</span>
                                        <input type="checkbox" value="pasif" <?php echo isset($data->aktif_pasif1)?($data->aktif_pasif1 == "pasif" ? "checked" : "disabled"):""; ?>>
                                        <span>pasif</span>
                                        <input type="checkbox" value="daerah" <?php echo isset($data->aktif_pasif1)?($data->aktif_pasif1 == "daerah" ? "checked" : "disabled"):""; ?>>
                                        <span>daerah, jelaskan <?= isset($data->check_jelaskan2)?$data->check_jelaskan2:'' ?></span>
                                </p>
                            </div>
                       
                    </td>
                </tr>
                
            </table>
            <p style="text-align:left;font-size:12px">Hal 2 dari 4</p>
        </div>

        
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK KEBIDANAN</p>

            <table  width="100%" border="1" cellpadding="3px">
                <tr>
                    <td colspan="2" style="font-size:11px">
                        <li>
                            Perlu penterjemah
                            <input type="checkbox" value="tidak" <?php echo isset($data->perlu_penerjemah)?($data->perlu_penerjemah == "tidak" ? "checked" : "disabled"):""; ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="ya" <?php echo isset($data->perlu_penerjemah)?($data->perlu_penerjemah == "ya" ? "checked" : "disabled"):""; ?>>
                            <span>ya, bahasa <?= isset($data->check_bahasa)?$data->check_bahasa:'' ?></span>
                        </li>
                        <p style="margin-left:20px">
                           
                            <span>Bahasa isyarat :</span>
                            <input type="checkbox" value="tidak" <?php echo isset($data->bahasa_isyarat)?($data->bahasa_isyarat == "tidak" ? "checked" : "disabled"):""; ?>>
                            <span>tidak </span>
                            <input type="checkbox" value="ya" <?php echo isset($data->bahasa_isyarat)?($data->bahasa_isyarat == "ya" ? "checked" : "disabled"):""; ?>>
                            <span>ya</span>
                        </p>
                        <li>Hambatan belajar</li>
                        <div style="margin-left:25px">
                         <p>Cara belajar yang disukai</p>
                         <table width="100%">
                             <tr>
                                <td width="30%" style="font-size:11px">
                                    <input type="checkbox" value="bahasa" <?php echo isset($data->cara_belajar)?(in_array("bahasa", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Bahasa</span><br>
                                    <input type="checkbox" value="pendengaran" <?php echo isset($data->cara_belajar)?(in_array("pendengaran", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Pendengaran</span><br>
                                    <input type="checkbox" value="hilang_memori" <?php echo isset($data->cara_belajar)?(in_array("hilang_memori", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Hilang Memori</span><br>
                                    <input type="checkbox" value="motivasi buruk" <?php echo isset($data->cara_belajar)?(in_array("motivasi_buruk", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Motivasi buruk</span><br>
                                    <input type="checkbox" value="masalah_penglihatan" <?php echo isset($data->cara_belajar)?(in_array("masalah_penglihatan", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Masalah penglihatan</span><br>
                                    
                                </td>
                                <td width="40%" style="font-size:11px">
                                    <input type="checkbox" value="emosi" <?php echo isset($data->cara_belajar)?(in_array("emosi", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Emosi</span><br>
                                    <input type="checkbox" value="kesulitan_bicara" <?php echo isset($data->cara_belajar)?(in_array("kesulitan_bicara", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Kesulitan bicara</span><br>
                                    <input type="checkbox" value="tidak_ada" <?php echo isset($data->cara_belajar)?(in_array("tidak_ada_partisipasi", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak ada partisipasi dari caregiver</span><br>
                                    <input type="checkbox" value="fisiologi" <?php echo isset($data->cara_belajar)?(in_array("secara_fisiologi", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Secara fisiologi tidak mampu belajar</span><br>
                                    <input type="checkbox" value="kognitif" <?php echo isset($data->cara_belajar)?(in_array("kognitif", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Kognitif</span>
                                </td>
                                <td width="30%" style="font-size:11px">
                                    <input type="checkbox" value="menulis" <?php echo isset($data->cara_belajar)?(in_array("menulis", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Menulis</span><br>
                                    <input type="checkbox" value="audio" <?php echo isset($data->cara_belajar)?(in_array("audio_visual", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>audio-visual / gambar</span><br>
                                    <input type="checkbox" value="diskusi" <?php echo isset($data->cara_belajar)?(in_array("diskusi", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>diskusi</span><br>
                                    <input type="checkbox" value="membaca" <?php echo isset($data->cara_belajar)?(in_array("membaca", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>membaca</span><br>
                                    <input type="checkbox" value="mendengar" <?php echo isset($data->cara_belajar)?(in_array("mendengar", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>mendengar</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="font-size:11px">
                                    <input type="checkbox" value="tidak_ditemukan" <?php echo isset($data->cara_belajar)?(in_array("tidak_ditemukan_hambatan_belajar", $data->cara_belajar) ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak ditemukan hambatan belajar</span>
                                </td>
                            </tr>

                         </table>

                         <table width="100%">
                            <tr>
                                <td width="25%" style="font-size:11px" rowspan="2"><p>Potensial kebutuhan pembelajaran</p></td>
                                <td width="20%" style="font-size:11px">
                                    <p>
                                        <input type="checkbox" value="proses" <?php echo isset($data->potensi_kebutuhan_belajar)?(in_array("proses_penyakit", $data->potensi_kebutuhan_belajar) ? "checked" : "disabled"):""; ?>>
                                        <span>Proses penyakit</span>
                                    </p>
                                </td>
                                <td width="20%" style="font-size:11px">
                                    <p>
                                        <input type="checkbox" value="proses" <?php echo isset($data->potensi_kebutuhan_belajar)?(in_array("pengobatan_tindakan", $data->potensi_kebutuhan_belajar) ? "checked" : "disabled"):""; ?>>
                                        <span>pengobatan/tindakan</span>
                                    </p>
                                </td>
                                <td width="15%" style="font-size:11px">
                                    <p>
                                        <input type="checkbox" value="proses" <?php echo isset($data->potensi_kebutuhan_belajar)?(in_array("terapi", $data->potensi_kebutuhan_belajar) ? "checked" : "disabled"):""; ?>>
                                        <span>Terapi</span>
                                    </p>
                                </td>
                            </tr>

                            <tr>
                                
                                <td width="20%" style="font-size:11px">
                                   
                                        <input type="checkbox" value="proses" <?php echo isset($data->potensi_kebutuhan_belajar)?(in_array("nutrisi", $data->potensi_kebutuhan_belajar) ? "checked" : "disabled"):""; ?>>
                                        <span>Nutrisi</span>
                                   
                                </td>
                                <td width="20%" style="font-size:11px" colspan ="2">
                                    
                                        <input type="checkbox" value="proses" <?php echo isset($data->check_potensi)?(in_array("lainnya", $data->check_potensi) ? "checked" : "disabled"):""; ?>>
                                        <span>lain-lain, jelaskan <?= isset($data->check_lainnya4)?$data->check_lainnya4:'' ?></span>
                                   
                                </td>
                            </tr>
                         </table>
                        </div>
                       
                    </td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px">
                        <table width="100%" border="1">
                            <tr>
                                <td width="6%" style="font-size:11px;text-align:center">No</td>
                                <td width="24%" style="font-size:11px;text-align:center">Riwayat Infeksi</td>
                                <td width="10%" style="font-size:11px;text-align:center">Ya</td>
                                <td width="10%" style="font-size:11px;text-align:center">Tidak</td>
                                <td width="6%" style="font-size:11px;text-align:center">No</td>
                                <td width="24%" style="font-size:11px;text-align:center">Riwayat Infeksi</td>
                                <td width="10%" style="font-size:11px;text-align:center">Ya</td>
                                <td width="10%" style="font-size:11px;text-align:center">Tidak</td>
                            </tr>
                            <tr>
                                <td style="font-size:11px;text-align:center">1</td>
                                <td style="font-size:11px;">Resiko tinggi HIV</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'1'})?($data->question23->{'Row 1'}->{'1'} == "1" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'1'})?($data->question23->{'Row 1'}->{'1'} == "2" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center">4</td>
                                <td style="font-size:11px;">Riwayat penyakit menular seksual </td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'4'})?($data->question23->{'Row 1'}->{'4'} == "1" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'4'})?($data->question23->{'Row 1'}->{'4'} == "2" ? "✓" : ""):""; ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px;text-align:center">2</td>
                                <td style="font-size:11px;">Resiko tinggi hepatitis B</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'2'})?($data->question23->{'Row 1'}->{'2'} == "1" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'2'})?($data->question23->{'Row 1'}->{'2'} == "2" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center">5</td>
                                <td style="font-size:11px;">Riwayat penyakit menular seksual pada pasangan </td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'5'})?($data->question23->{'Row 1'}->{'5'} == "1" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'5'})?($data->question23->{'Row 1'}->{'5'} == "2" ? "✓" : ""):""; ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px;text-align:center">3</td>
                                <td style="font-size:11px;">Tinggal bersama penderita TB/infeksi kronis</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'3'})?($data->question23->{'Row 1'}->{'3'} == "1" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'3'})?($data->question23->{'Row 1'}->{'3'} == "2" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center">6</td>
                                <td style="font-size:11px;">Lainnya </td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'6'})?($data->question23->{'Row 1'}->{'6'} == "1" ? "✓" : ""):""; ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->question23->{'Row 1'}->{'6'})?($data->question23->{'Row 1'}->{'6'} == "2" ? "✓" : ""):""; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px;font-weight:bold;text-align:center">DATA OBJEKTIF</td>
                </tr>

                <tr>
                    <td colspan ="2" style="font-size:11px;">
                    <span>A. Pemeriksaan umum </span>
                        <div style="margin-left:25px">
                            <p>
                                <span>KU : <?= isset($data->ku)?$data->ku:'' ?></span>
                                <span style="margin-left:25px">Kesadaran : <?= isset($data->kesadaran)?$data->kesadaran:'' ?> </span>
                                <span style="margin-left:25px">GCS</span>
                                <span style="margin-left:15px">E  <?= isset($data->gcs)?$data->gcs:'' ?>:</span>
                                <span style="margin-left:15px">M  <?= isset($data->m)?$data->m:'' ?>:</span>
                                <span style="margin-left:15px">V  <?= isset($data->v)?$data->v:'' ?>:</span>
                                <span style="margin-left:25px">BB :  <?= isset($data->bb)?$data->bb:'' ?> KG</span>
                                <span style="margin-left:25px">TB :  <?= isset($data->tb)?$data->tb:'' ?> CM</span>
                            </p>
                                <span>TD : <?= isset($data->td)?$data->td:'' ?> MmHG</span>
                                <span style="margin-left:40px">HR : <?= isset($data->hr)?$data->hr:'' ?> x/menit,rr : <?= isset($data->rr)?$data->rr:'' ?> x/menit</span>
                                <span style="margin-left:40px">Suhu axila :  <?= isset($data->suhu)?$data->suhu:'' ?> °C</span>
                        </div>
                        <p>B. Pemeriksaan fisik </p>
                            <div style="margin-left:25px">
                                <table width="100%">
                                    <tr>
                                        <td width="18%" rowspan="2" style="font-size:11px;"><li>Mata </li></td>
                                        <td width="2%" rowspan="2" style="font-size:11px;">:</td>
                                        <td width="80%" style="font-size:11px;">Konjungtiva :
                                            <input type="checkbox" value="normal" <?php echo isset($data->konjuntiva)?($data->konjuntiva == "pucat" ? "checked" : "disabled"):""; ?>>
                                            <span>Pucat</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->konjuntiva)?($data->konjuntiva == "normal" ? "checked" : "disabled"):""; ?>>
                                            <span>Normal</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="80%" style="font-size:11px;">Sclera :
                                            <input type="checkbox" value="normal" <?php echo isset($data->sclera)?($data->sclera == "putih" ? "checked" : "disabled"):""; ?>>
                                            <span>Putih</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->sclera)?($data->sclera == "kuning" ? "checked" : "disabled"):""; ?>>
                                            <span>Kuning</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->sclera)?($data->sclera == "merah" ? "checked" : "disabled"):""; ?>>
                                            <span>Merah</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="18%"style="font-size:11px;" ><p><li>Leher </li></p></td>
                                        <td width="2%" style="font-size:11px;"><p>:</p></td>
                                        <td width="80%" style="font-size:11px;"><p>Tyroid
                                            <input type="checkbox" value="normal" <?php echo isset($data->tyroid)?($data->tyroid == "teraba" ? "checked" : "disabled"):""; ?>>
                                            <span>Teraba</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->tyroid)?($data->tyroid == "tidak_teraba" ? "checked" : "disabled"):""; ?>>
                                            <span>tidak teraba</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="18%" style="font-size:11px;"><li>Dada</li></td>
                                        <td width="2%" style="font-size:11px;">:</td>
                                        <td width="80%" style="font-size:11px;">Jantung <?= isset($data->jantung)?$data->jantung:'' ?></td>
                                    </tr>
                                    <tr>
                                        <td width="18%" style="font-size:11px;"><p><li>Paru</li></p></td>
                                        <td width="2%" style="font-size:11px;"><p>:</p></td>
                                        <td width="80%" style="font-size:11px;"><p><?= isset($data->paru)?$data->paru:'' ?></p></td>
                                    </tr>
                                    <tr>
                                        <td width="18%" style="font-size:11px;"><li>Mamae</li></td>
                                        <td width="2%" style="font-size:11px;">:</td>
                                        <td width="80%" style="font-size:11px;">
                                            <input type="checkbox" value="normal" <?php echo isset($data->mamae)?($data->mamae == "bentuk" ? "checked" : "disabled"):""; ?>>
                                            <span>bentuk</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->mamae)?($data->mamae == "simetris" ? "checked" : "disabled"):""; ?>>
                                            <span>simetris</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->mamae)?($data->mamae == "asimetris" ? "checked" : "disabled"):""; ?>>
                                            <span>asimetris</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="18%"style="font-size:11px;" ><p><li>Puting Susu</li></p></td>
                                        <td width="2%" style="font-size:11px;"><p>:</p></td>
                                        <td width="80%" style="font-size:11px;"><p>
                                            <input type="checkbox" value="normal" <?php echo isset($data->puting_susu)?($data->puting_susu == "menonjol" ? "checked" : "disabled"):""; ?>>
                                            <span>menonjol</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->puting_susu)?($data->puting_susu == "datar" ? "checked" : "disabled"):""; ?>>
                                            <span>datar</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->puting_susu)?($data->puting_susu == "masuk" ? "checked" : "disabled"):""; ?>>
                                            <span>masuk</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="18%" style="font-size:11px;"><li>Pengeluaran</li></td>
                                        <td width="2%" style="font-size:11px;">:</td>
                                        <td width="80%" style="font-size:11px;">
                                            <input type="checkbox" value="normal" <?php echo isset($data->pengeluaran)?($data->pengeluaran == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                                            <span>tidak ada</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->pengeluaran)?($data->pengeluaran == "ada" ? "checked" : "disabled"):""; ?>> 
                                            <span>ada</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran)?($data->check_pengeluaran == "colocstrum" ? "checked" : "disabled"):""; ?>> 
                                            <span>colostrum</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran)?($data->check_pengeluaran == "asi" ? "checked" : "disabled"):""; ?>> 
                                            <span>ASI</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran)?($data->check_pengeluaran == "nanah" ? "checked" : "disabled"):""; ?>> 
                                            <span>nanah</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran)?($data->check_pengeluaran == "darah" ? "checked" : "disabled"):""; ?>> 
                                            <span>darah</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="18%"style="font-size:11px;" ><p><li>Kebersihan </li></p></td>
                                        <td width="2%" style="font-size:11px;"><p>:</p></td>
                                        <td width="80%" style="font-size:11px;"><p>
                                            <input type="checkbox" value="normal" <?php echo isset($data->kebersihan)?($data->kebersihan == "cukup" ? "checked" : "disabled"):""; ?>>
                                            <span>Cukup</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->kebersihan)?($data->kebersihan == "kurang" ? "checked" : "disabled"):""; ?>>
                                            <span>Kurang</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->kebersihan)?($data->kebersihan == "kelainan" ? "checked" : "disabled"):""; ?>>
                                            <span>kelainan :</span>
                                            <input type="checkbox" value="normal" <?php echo isset($data->kebersihan)?($data->kebersihan == "lecet" ? "checked" : "disabled"):""; ?>>
                                            <span>lecet</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->kebersihan)?($data->kebersihan == "bengkak" ? "checked" : "disabled"):""; ?>>
                                            <span>bengkak</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->kebersihan)?($data->kebersihan == "Lainnya" ? "checked" : "disabled"):""; ?>>
                                            <span><?= isset($data->check_lainnya5)?$data->check_lainnya5:'lainnya' ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="18%" style="font-size:11px;"><li>Extermitas</li></td>
                                        <td width="2%" style="font-size:11px;">:</td>
                                        <td width="80%" style="font-size:11px;">
                                            <input type="checkbox" value="normal" <?php echo isset($data->extremitas)?($data->extremitas == "tungkai" ? "checked" : "disabled"):""; ?>>
                                            <span>Tungkai</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->extremitas)?($data->extremitas == "simetris" ? "checked" : "disabled"):""; ?>>
                                            <span>simetris</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->extremitas)?($data->extremitas == "asimetris" ? "checked" : "disabled"):""; ?>>
                                            <span>Asimetris</span>
                                            
                                            <span>edema : <?= isset($data->edema)?$data->edema:'' ?></span>
                                            
                                            <span style="margin-left:30px">Refleks</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->reflex)?($data->reflex == "+" ? "checked" : "disabled"):""; ?>>
                                            <span>+</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->reflex)?($data->reflex == "-" ? "checked" : "disabled"):""; ?>>
                                            <span>-</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                        <p>C. Pemeriksaan Khusus </p>
                                <span style="margin-left:25px">1. Abdomen</span>
                                <p style="margin-left:45px">a. inpeksi :</p>

                                    <div style="margin-left:50px">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td width="28%"  style="font-size:11px;"><li>Luka bekas operasi</li></td>
                                                <td width="2%"  style="font-size:11px;">:</td>
                                                <td width="70%" style="font-size:11px;">
                                                    <input type="checkbox" value="normal" <?php echo isset($data->luka_bekas_operasi)?($data->luka_bekas_operasi == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                                                    <span>Tidak ada</span>
                                                    <input type="checkbox" value="serangan" <?php echo isset($data->luka_bekas_operasi)?($data->luka_bekas_operasi == "ada" ? "checked" : "disabled"):""; ?>>
                                                    <span>ada</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="28%"  style="font-size:11px;"><li>Kelainan</li></td>
                                                <td width="2%"  style="font-size:11px;">:</td>
                                                <td width="70%" style="font-size:11px;">
                                                    <input type="checkbox" value="normal" <?php echo isset($data->kelainan)?($data->kelainan == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                                                    <span>Tidak ada</span>
                                                    <input type="checkbox" value="serangan" <?php echo isset($data->kelainan)?($data->kelainan == "ada" ? "checked" : "disabled"):""; ?>>
                                                    <span>ada :</span>
                                                    <input type="checkbox" value="normal" <?php echo isset($data->check_kelainan)?($data->check_kelainan == "bandi" ? "checked" : "disabled"):""; ?>>
                                                    <span>Bandi</span>
                                                    <input type="checkbox" value="normal" <?php echo isset($data->check_kelainan)?($data->check_kelainan == "distensi" ? "checked" : "disabled"):""; ?>>
                                                    <span>Distensi</span>
                                                    <input type="checkbox" value="normal" <?php echo isset($data->check_kelainan)?($data->check_kelainan == "lainnya" ? "checked" : "disabled"):""; ?>>
                                                    <span><?= isset($data->check_lainnya6)?$data->check_lainnya6:'Lainnya' ?></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                
                                    <p style="margin-left:45px">b. Palpasi :</p>
                                    <div style="margin-left:50px">
                                        <table width="100%" border="0">
                                            <tr>
                                                <td width="28%"  style="font-size:11px;"><li>Tinggi fundus uteri </li></td>
                                                <td width="2%"  style="font-size:11px;">:</td>
                                                <td width="70%" style="font-size:11px;">
                                                <?= isset($data->tinggi_tundus_uteri)?$data->tinggi_tundus_uteri:'' ?> cm taksiran beserta janin : <?= isset($data->taksiran_berta_janin)?$data->taksiran_berta_janin:'' ?> gram
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="28%"  style="font-size:11px;"><li>Lingkar panggul </li></td>
                                                <td width="2%"  style="font-size:11px;">:</td>
                                                <td width="70%" style="font-size:11px;"><?= isset($data->lingkar_punggung)?$data->lingkar_punggung:'' ?> cm </td>
                                            </tr>
                                            <tr>
                                                <td width="28%"  style="font-size:11px;"><li>Letak punggung</li></td>
                                                <td width="2%"  style="font-size:11px;">:</td>
                                                <td width="70%" style="font-size:11px;">
                                                    <input type="checkbox" value="normal" <?php echo isset($data->letak_punggung)?($data->letak_punggung == "punggung_kanan" ? "checked" : "disabled"):""; ?>>
                                                    <span>Punggung kanan</span>
                                                    <input type="checkbox" value="serangan" <?php echo isset($data->letak_punggung)?($data->letak_punggung == "punggung_kiri" ? "checked" : "disabled"):""; ?>>
                                                    <span>Punggung kiri</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                    </td>
                </tr>
            </table>
            <p style="text-align:left;font-size:12px">Hal 3 dari 4</p>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK KEBIDANAN</p>

            <table  width="100%" border="1" cellpadding="3px">
                <tr>
                    <td colspan="2">
                        <div style="margin-left:50px">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Presentasi</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="normal" <?php echo isset($data->presentasi)?($data->presentasi == "kepala" ? "checked" : "disabled"):""; ?>>
                                        <span>kepala</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->presentasi)?($data->presentasi == "bokong" ? "checked" : "disabled"):""; ?>>
                                        <span>bokong</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->presentasi)?($data->presentasi == "kosong" ? "checked" : "disabled"):""; ?>>
                                        <span>kosong</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><p><li>Bagian terendah</li></p></td>
                                    <td width="2%"  style="font-size:11px;"><p>:</p></td>
                                    <td width="70%" style="font-size:11px;"><p>
                                        <span><?=isset($data->bagian_terendah)?$data->bagian_terendah:'' ?>(perlimaan)</span>
                                        <input type="checkbox" value="serangan">
                                        <span>Osborn test :</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->osborn)?($data->osborn == "+" ? "checked" : "disabled"):""; ?>>
                                        <span>+</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->osborn)?($data->osborn == "-" ? "checked" : "disabled"):""; ?>>
                                        <span>-</span>
                                       </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Kontraksi uterus</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="serangan" <?php echo isset($data->kontraksi_uterus)?($data->kontraksi_uterus == "tidak " ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->kontraksi_uterus)?($data->kontraksi_uterus == "ada" ? "checked" : "disabled"):""; ?>>
                                        <span>Ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_kontraksi)?($data->check_kontraksi == "baik" ? "checked" : "disabled"):""; ?>>
                                        <span>baik</span><br>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_kontraksi)?($data->check_kontraksi == "lembek" ? "checked" : "disabled"):""; ?>>
                                        <span>lembek : his <?= isset($data->his)?$data->his:'' ?> x/menit,lama <?= isset($data->lama)?$data->lama:'' ?> detik</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><p><li>Kelainan</li></p></td>
                                    <td width="2%"  style="font-size:11px;"><p>:</p></td>
                                    <td width="70%" style="font-size:11px;"><p>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->kelainan1)?($data->kelainan1 == "nyeri_tekan" ? "checked" : "disabled"):""; ?>>
                                        <span>Nyeri tekan</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->kelainan1)?($data->kelainan1 == "cekungan_pada_perut" ? "checked" : "disabled"):""; ?>>
                                        <span>cekungan pada perut</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->kelainan1)?($data->kelainan1 == "blass_penuh" ? "checked" : "disabled"):""; ?>>
                                        <span>blasss penuh</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Teraba masa</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="serangan" <?php echo isset($data->teraba)?($data->teraba == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->teraba)?($data->teraba == "ada" ? "checked" : "disabled"):""; ?>>
                                        <span>Ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->question31)?($data->question31 == "solid" ? "checked" : "disabled"):""; ?>>
                                        <span>solid</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->question31)?($data->question31 == "kistik" ? "checked" : "disabled"):""; ?>>
                                        <span>kistik, ukuran <?= isset($data->ukuran)?$data->ukuran:'' ?> cm</span>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="margin-left:45px;font-size:11px;">c. Auskultasi :</p>
                        <div style="margin-left:60px">
                            <table width="100%" border="0">
                                    <tr>
                                        <td width="28%"  style="font-size:11px;">Bising usus</td>
                                        <td width="2%"  style="font-size:11px;">:</td>
                                        <td width="70%" style="font-size:11px;">
                                            <input type="checkbox" value="normal" <?php echo isset($data->bising_usus)?($data->bising_usus == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                                            <span>Tidak ada</span>
                                            <input type="checkbox" value="serangan" <?php echo isset($data->bising_usus)?($data->bising_usus == "ada" ? "checked" : "disabled"):""; ?>>
                                            <span>Ada</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="28%"  style="font-size:11px;"><p>Denyut jantung janin </p></td>
                                        <td width="2%"  style="font-size:11px;"><p>:</p></td>
                                        <td width="70%" style="font-size:11px;">
                                            <span><p><?= isset($data->jantung1)?$data->jantung1:'' ?> x/menit</p></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="28%"  style="font-size:11px;">Anogental </td>
                                        <td width="2%"  style="font-size:11px;"></td>
                                        <td width="70%" style="font-size:11px;"></td>
                                    </tr>
                            </table>
                        </div>

                        <p style="margin-left:45px;font-size:11px;">d. Inpeksi :</p>
                        <div style="margin-left:50px">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Pengeluaran pervaginam</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="normal" <?php echo isset($data->pengeluaran_pervaginam)?($data->pengeluaran_pervaginam == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->pengeluaran_pervaginam)?($data->pengeluaran_pervaginam == "ada" ? "checked" : "disabled"):""; ?>>
                                        <span>ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("darah", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>darah</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("lendir", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>lendir</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("nanah", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>nanah</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("air_ketuban", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>air ketuban</span><br>

                                        <input type="checkbox" value="normal" <?php echo isset($data->check_pengeluaran1)?(in_array("bagian_keil_janin", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>Bagian kecil janin</span>
                                       

                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("lochea", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>lochea</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("rubra", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>rubra</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("sanguinolenta", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>sanguinolenta</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_pengeluaran1)?(in_array("alba", $data->check_pengeluaran1) ? "checked" : "disabled"):""; ?>>
                                        <span>aiba</span>
        
                                    </td>
                                </tr>

                                <tr>
                                    <td width="28%"  style="font-size:11px;"><p><li>Volume</li></p></td>
                                    <td width="2%"  style="font-size:11px;"><p>:</p></td>
                                    <td width="70%" style="font-size:11px;"><p>
                                        <span><?= isset($data->volume1)?$data->volume1:'' ?>,berbau</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->berbau)?($data->berbau == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>tidak</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->berbau)?($data->berbau == "ya" ? "checked" : "disabled"):""; ?>>
                                        <span>ya:bau </span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_berbau)?($data->check_berbau == "amis" ? "checked" : "disabled"):""; ?>>
                                        <span>amis</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_berbau)?($data->check_berbau == "busuk" ? "checked" : "disabled"):""; ?>>
                                        <span>busuk</span></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Perinium</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="serangan" <?php echo isset($data->perinium)?($data->perinium == "utuh" ? "checked" : "disabled"):""; ?>>
                                        <span>utuh</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->perinium)?($data->perinium == "laserasi" ? "checked" : "disabled"):""; ?>>
                                        <span>laserasi derajat <?= isset($data->check_peririum)?$data->check_peririum:'' ?></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="28%"  style="font-size:11px;"><p><li>Jahitan</li></p></td>
                                    <td width="2%"  style="font-size:11px;"><p>:</p></td>
                                    <td width="70%" style="font-size:11px;"><p>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->jahitan)?(in_array("baik", $data->jahitan) ? "checked" : "disabled"):""; ?> >
                                        <span>baik</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->jahitan)?(in_array("terlepas", $data->jahitan) ? "checked" : "disabled"):""; ?> >
                                        <span>terlepas</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->jahitan)?(in_array("hermatom", $data->jahitan) ? "checked" : "disabled"):""; ?> >
                                        <span>hematom</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->jahitan)?(in_array("osdam", $data->jahitan) ? "checked" : "disabled"):""; ?> >
                                        <span>oedem</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->jahitan)?(in_array("ekimosis", $data->jahitan) ? "checked" : "disabled"):""; ?> >
                                        <span>ekimosis</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->jahitan)?(in_array("kemerahan", $data->jahitan) ? "checked" : "disabled"):""; ?> >
                                        <span>kemerahan</span></p>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <p style="margin-left:45px;font-size:11px;">e. Inspekulo vagina :</p>
                        <div style="margin-left:50px">
                            <table width="100%" border="0">
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Vagina</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">Kelainan
                                        <input type="checkbox" value="normal" <?php echo isset($data->kelainan3)?($data->kelainan3 == "tidak_ada" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->kelainan3)?($data->kelainan3 == "ada" ? "checked" : "disabled"):""; ?>>
                                        <span>ada</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_kelainan1)?($data->check_kelainan1 == "fistel" ? "checked" : "disabled"):""; ?>>
                                        <span>fistel</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_kelainan1)?($data->check_kelainan1 == "condiloma" ? "checked" : "disabled"):""; ?>>
                                        <span>condiloma</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->check_kelainan1)?($data->check_kelainan1 == "septum" ? "checked" : "disabled"):""; ?>>
                                        <span>septum</span><br>
                                        <span>varises <?= isset($data->Varises)?$data->Varises:'' ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Hymen</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="normal" <?php echo isset($data->hymen)?($data->hymen == "utuh" ? "checked" : "disabled"):""; ?>>
                                        <span>utuh</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->hymen)?($data->hymen == "robek" ? "checked" : "disabled"):""; ?>>
                                        <span>robek</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->hymen)?($data->hymen == "sampai_datar" ? "checked" : "disabled"):""; ?>>
                                        <span>sampai dasar, arah robekan (jam) <?= isset($data->check_hymen)?$data->check_hymen:'' ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Portio</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="normal" <?php echo isset($data->portio)?($data->portio == "utuh" ? "checked" : "disabled"):""; ?>>
                                        <span>utuh</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->portio)?($data->portio == "arapuh" ? "checked" : "disabled"):""; ?>>
                                        <span>arapuh</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->portio)?($data->portio == "lainnya" ? "checked" : "disabled"):""; ?>>
                                        <span><?= isset($data->check_portio)?$data->check_portio:'lainnya' ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Cavum douglasi</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <input type="checkbox" value="normal" <?php echo isset($data->cavum_douglasi)?($data->cavum_douglasi == "menonjol" ? "checked" : "disabled"):""; ?>>
                                        <span>menonjol :</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->question34)?($data->question34 == "tidak" ? "checked" : "disabled"):""; ?>>
                                        <span>tidak</span>
                                        <input type="checkbox" value="serangan" <?php echo isset($data->question34)?($data->question34 == "ya" ? "checked" : "disabled"):""; ?>>
                                        <span>ya</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Vagina toucher</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <span>oleh <?= isset($data->vagina_toucher)?$data->vagina_toucher:'' ?> tanggal / jam</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="28%"  style="font-size:11px;"><li>Kesan panggul</li></td>
                                    <td width="2%"  style="font-size:11px;">:</td>
                                    <td width="70%" style="font-size:11px;">
                                        <span><?= isset($data->kesan_panggul)?$data->kesan_panggul:'' ?></span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <p style="font-size:11px;">A. Pemeriksaan Penunjang</p>
                        <div style="margin-left:25px;font-size:11px;">
                            <p>1. Laboratorium</p>
                            <p style="margin-left:25px"><?= isset($data->laboratorium)?$data->laboratorium:'' ?></p>
                            <p>2. USG</p>
                            <p style="margin-left:25px"><?= isset($data->usg)?$data->usg:'' ?></p>
                            <p>3. Kardiotografi</p>
                            <p style="margin-left:25px"><?= isset($data->kardiotokografi)?$data->kardiotokografi:'' ?></p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="min-height:20px;font-size:11px">
                        B.Diagnosis kebidanan<br>
                        <span><?= isset($data->diagnosa_kebidanan)?$data->diagnosa_kebidanan:'' ?></span>
                    </div>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <div style="min-height:20px;font-size:11px">C.Tindakan kebidanan<br>
                        <span><?= isset($data->tindakan_kebidanan)?$data->tindakan_kebidanan:'' ?></span>
                    </div>
                    </td>
                </tr>
            </table>

            <table width="100%">
                <tr>
                    <td width ="70%"></td>
                    <td width ="30%">
                        <p>Bidan yang melakukan pengkajian</p>
                        <?php echo isset($data->ttd)?'<img width="120" src="'.$data->ttd.'" alt="">':'<br><br>' ?><br>
                        <span><?= isset($data->nama_ttd)?$data->nama_ttd:'' ?></span>
                       
                    </td>
                </tr>
            </table><br><br><br><br><br><br>
            <p style="text-align:left;font-size:12px">Hal 4 dari 4</p>
        </div>

    </body>