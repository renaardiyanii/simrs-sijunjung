<?php 

$data_formjson = isset($get_assesment_keperawatan_irj->formjson)?json_decode($get_assesment_keperawatan_irj->formjson):'';
// var_dump($asesmen_keperawatan);die();
$skor = 0;
if(isset($data_formjson->value_gizi_penurunan_bb)){

    switch($data_formjson->value_gizi_penurunan_bb){
        case '1-5kg':
            $skor +=1;
            break;
        case '6-10kg':
            $skor +=2;
            break;
        case '11-15Kg':
            $skor +=3;
            break;
        case '>15Kg':
            break;
        default:
            break;
    }
   
}
if(isset($data_formjson->gizi_asupan_makan)){
    switch($data_formjson->gizi_asupan_makan){
        case 'ya':
            $skor +=1;
            break;
        case 'tidak':
            $skor +=0;
            break;
    }
}
?>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <script>
        JsBarcode("#barcode", "Hi world!");
   </script>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <body class="A4" >
       <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK</p>
            <p align="center" style="font-size:12px;font-style:italic">(Dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</p>

            <table border="1" width="100%">
                <tr>
                    <td>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="70%"><p style="font-weight:bold">DATA UMUM</p></td>
                                <td width="30%"><P>Cara Bayar : <?php echo $data_rawat_jalan[0]->cara_bayar??'';?></p></td>
                            </tr>
                        </table>
            
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="30%"><p>Hari/Tanggal : <?php echo $asesmen_keperawatan[0]->tgl??'';?></p></td>
                                <td width="25%"><p>Jam Datang : <?php echo isset($asesmen_keperawatan[0]->tgl_kunjungan)?substr($asesmen_keperawatan[0]->tgl_kunjungan,11,5).' ':''; ?>WIB</p></td>
                                <td width="30%"><p>Jam Pemeriksaan : <?= isset($asesmen_keperawatan[0]->tanggal_pemeriksaan)?date('H.i',strtotime($asesmen_keperawatan[0]->tanggal_pemeriksaan)).' ':'' ?>WIB</p></td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="20%"><span>Agama</span></td>
                                <td width="2%"><span>:</span></td>
                                <td width="78%">
                                    <input type="radio" id="islam" name="islam" value="" <?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "ISLAM" ? "checked" : "disabled"):'';?>>
                                    <span>Islam</span>
                                    <input type="radio" id="kristen_k" name="kristen_k" value="" <?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "KATOLIK" ? "checked" : "disabled"):''; ?>>
                                    <span>Katolik</span>
                                    <input type="radio" id="kristen_p" name="kristen_p" value="" <?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "PROTESTAN" ? "checked" : "disabled"):''; ?>>
                                    <span>Protestan</span>
                                    <input type="radio" id="hindu" name="hindu" value="" <?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "HINDU" ? "checked" : "disabled"):''; ?>>
                                    <span>Hindu</span>
                                    <input type="radio" id="budha" name="budha" value="" <?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "BUDHA" ? "checked" : "disabled"):''; ?>>
                                    <span>Budha</span>
                                    <input type="radio" id="other" name="other" value="" <?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "" ? "checked" : "disabled"):''; ?>>
                                    <span><?php echo isset($data_pasien[0]->agama)?($data_pasien[0]->agama == "" ? "Lainnya" : "Lainnya"):''; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td><span>Status Pasien</span></td>
                                <td><span>:</span></td>
                                <td><span><?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == "B" ? "BARU" : "LAMA"):''; ?></span></td>
                            </tr>
                            <tr>
                                <td><span>Alamat</span></td>
                                <td><span>:</span></td>
                                <td><span><?php echo $data_pasien[0]->alamat??"" ?></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
               
                <tr>
                    <td>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td>
                                    <span>RIWAYAT KESEHATAN</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <span><?= isset($data_formjson->riwayat_kesehatan)?$data_formjson->riwayat_kesehatan:'' ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td><span>PEMERIKSAAN FISIK</span></td>
                            </tr>
                        </table>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="50%"> 
                                     <span>Keadaan Umum : <span><?php echo $asesmen_keperawatan[0]->keadaan_umum??''; ?></span>
                                </td>
                                <td width="50%">
                                     <span>Keadaan Umum : <span><?php echo $asesmen_keperawatan[0]->keadaan_umum??''; ?></span>
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="20%">
                                    <span>Tanda - Tanda Vital : </span>  
                                </td>
                                <td width="20%">
                                    <span> 
                                        TD: 
                                        <?php echo (isset($asesmen_keperawatan[0]->sitolic)?$asesmen_keperawatan[0]->sitolic:'').'/'.
                                        (isset($asesmen_keperawatan[0]->diatolic)?$asesmen_keperawatan[0]->diatolic.' '.'mmHG':'') ?>    
                                    </span>
                                </td>
                                <td width="20%">
                                    <span>
                                        HR : 
                                        <?php echo isset($asesmen_keperawatan[0]->nadi)?$asesmen_keperawatan[0]->nadi.' '.'x/i':"";?>
                                    </span> 
                                </td>
                                <td width="20%">
                                    <span>
                                        Suhu :
                                        <?php echo isset($asesmen_keperawatan[0]->suhu)?$asesmen_keperawatan[0]->suhu.' '.'°C':"";?>
                                    </span> 
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="18%"><span>Berat Badan</span></td>
                                <td width="2%">:</td>
                                <td width="80%"><span><span><?php echo isset($asesmen_keperawatan[0]->bb)?$asesmen_keperawatan[0]->bb:"";?></span> Kg</span></td>
                            </tr>
                            <tr>
                                <td><span>Lingkar Kepala</span></td>
                                <td>:</td>
                                <td><span><span><?php echo isset($asesmen_keperawatan[0]->lingkar_kepala)?$asesmen_keperawatan[0]->lingkar_kepala:"";?></span> Cm</span></td>
                            </tr>
                        </table>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="20%"><span>RIWAYAT ALERGI</span></td>
                                <td width="20%">
                                    <input type="checkbox"  value="alergi_tidak" <?php echo isset($data_formjson->alergi)?($data_formjson->alergi == "0" ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak</span>
                                    <input type="checkbox"  value="alergi_ya" <?php echo isset($data_formjson->alergi)?($data_formjson->alergi == "1" ? "checked" : "disabled"):""; ?>>
                                    <span>Ya</span>
                                </td>
                                <td width="60%">
                                    <span>Sebutkan, <?php echo $data_formjson->riwayat_alergi??"";?></span>
                                    <span style="margin-left:20px">reaksi, <?php echo $data_formjson->reaksi_alergi??"" ?></span>
                                </td>
                            </tr>
                            <tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td><span>ASSESMEN NYERI</span></td>
                            </tr>
                            <tr>
                                <span>Nyeri : </span>
                                
                                <input type="checkbox"  value="nyeri_ya" <?php echo isset($data_formjson->nyeri)?($data_formjson->nyeri == "tidak" ? "checked" : "disabled"):''; ?>>
                                <span>Tidak</span>
                                <input type="checkbox"  value="nyeri_tidak" <?php echo isset($data_formjson->nyeri)?($data_formjson->nyeri == "ya_bersifat" ? "checked" : "disabled"):''; ?>>
                                <span>Ya, Bersifat</span>
                                <input type="checkbox"  value="nyeri_akut" <?php echo isset($data_formjson->check_nyeri1)?($data_formjson->check_nyeri1 == "akut" ? "checked" : "disabled"):''; ?>>
                                <span>Akut</span>
                                <input type="checkbox"  value="nyeri_kronis" <?php echo isset($data_formjson->check_nyeri1)?($data_formjson->check_nyeri1 == "kronis" ? "checked" : "disabled"):''; ?>>
                                <span>Kronis</span> 
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td><img src=" <?= base_url("assets/img/asesmenawal1.PNG"); ?>"  alt="img" height="50" width="200" style="padding-right:5px;"></td>
                                <td><img src=" <?= base_url("assets/img/asesmenawal2.PNG"); ?>"  alt="img" height="50" width="200" style="padding-right:5px;"></td>
                            </tr>
                        </table>
                        
                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%"><span class="text_body">1.</span></td>
                                    <td width="30%"><span class="text_body">Kualitas Nyeri</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                        <label><input type="checkbox"  value="nyeri_tumpul" <?php echo isset($data_formjson->kualitas_nyeri)?($data_formjson->kualitas_nyeri == "nyeri_tumpul" ? "checked" : "disabled"):''; ?>>Nyeri Tumpul</label>
                                        <label><input type="checkbox"  value="nyeri_tajam" <?php echo isset($data_formjson->kualitas_nyeri)?($data_formjson->kualitas_nyeri == "nyeri_tajam" ? "checked" : "disabled"):''; ?>>Nyeri Tajam</label>
                                        <label><input type="checkbox"  value="panas" <?php echo isset($data_formjson->kualitas_nyeri)?($data_formjson->kualitas_nyeri == "panas_terbakar" ? "checked" : "disabled"):''; ?>>Panas Terbakar</label>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span class="text_body">2.</span></td>
                                    <td width="30%"><span class="text_body">Menjalar</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                        <label><input type="checkbox"  value="tidak" <?php echo isset($data_formjson->menjalar)?($data_formjson->menjalar == null||$data_formjson->menjalar =='tidak' ? "checked":"disabled"):''; ?>>Tidak</label>
                                        <label><input type="checkbox"  value="iya" <?php echo isset($data_formjson->menjalar)?($data_formjson->menjalar != "tidak"? "checked" : "disabled"):''; ?>>
                                        Ya,*
                                        <span class="text_body">ke <span class="text_isi">
                                        <?php 
                                        if(isset($data_formjson->menjalar)){
                                            if ($data_formjson->menjalar == 'tidak'){
                                                echo '';
                                            } else {
                                                echo $data_formjson->value_menjalar;
                                            }
                                        }else{
                                            echo "";
                                        }    ?>
                                        
                                                        
                                        </span></span> 
                                        </label>
                                    
                                    
                                </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span class="text_body">3.</span></td>
                                    <td width="30%"><span class="text_body">Skala Nyeri</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                        <span class="text_isi"><?php echo $data_formjson->skala_nyeri??""; ?></span>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span class="text_body">4.</span></td>
                                    <td width="30%"><span class="text_body">Frekuensi Nyeri</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                        <label><input type="checkbox"  value="frek_jarang" <?php echo isset($data_formjson->frekuensi_nyeri)?($data_formjson->frekuensi_nyeri == "jarang" ? "checked" : "disabled"):""; ?>>Jarang</label>
                                        <label><input type="checkbox"  value="frek_hilang_timbul" <?php echo isset($data_formjson->frekuensi_nyeri)?($data_formjson->frekuensi_nyeri == "hilang_timbul" ? "checked" : "disabled"):""; ?>>Hilang Timbul</label>
                                        <label><input type="checkbox"  value="frek_terus" <?php echo isset($data_formjson->frekuensi_nyeri)?($data_formjson->frekuensi_nyeri == "terus_menerus" ? "checked" : "disabled"):""; ?>>Terus Menerus</label>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span class="text_body">5.</span></td>
                                    <td width="30%"><span class="text_body">Lamanya Nyeri</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                    <span class="text_isi"><?php echo $data_formjson->durasi_nyeri??""; ?></span>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span class="text_body">6.</span></td>
                                    <td width="30%"><span class="text_body">Lokasi Nyeri</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                        <span class="text_isi"><?php echo $data_formjson->lokasi_nyeri??""; ?></span>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span class="text_body">7.</span></td>
                                    <td width="30%"><span class="text_body">Faktor Penghilang Nyeri</span></td>
                                    <td width="5%"><span class="text_body">:</span></td>
                                    <td width="60%">
                                        <label><input type="checkbox"  value="min_obat" <?php echo isset($data_formjson->faktor_nyeri)?(in_array("1", $data_formjson->faktor_nyeri) ? "checked" : "disabled"):""; ?>>Minum Obat</label>
                                        <label><input type="checkbox"  value="istirahat" <?php echo isset($data_formjson->faktor_nyeri)?(in_array("2", $data_formjson->faktor_nyeri) ? "checked" : "disabled"):""; ?>>Istirahat</label>
                                        <label><input type="checkbox"  value="musik" <?php echo isset($data_formjson->faktor_nyeri)?(in_array("3", $data_formjson->faktor_nyeri) ? "checked" : "disabled"):""; ?>>Mendengarkan Musik</label>
                                        <label><input type="checkbox"  value="pos_tidur" <?php echo isset($data_formjson->faktor_nyeri)?(in_array("4", $data_formjson->faktor_nyeri) ? "checked" : "disabled"):""; ?>>Berubah Posisi Tidur</label>
                                    </td>
                                <tr>
                            </table>
                            
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td><span class="text_sub_judul">SKRINING GIZI (Berdasarkan Malnutrition Screening Tool/MST)</span></td>
                            </tr>
                            <tr>
                                <td><span class="text_body">1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak diinginkan selama 6 bulan terakhir?</span></td>
                            </tr>
                        </table>
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <span class="text_sub_judul">SKRINING GIZI (Berdasarkan Malnutrition Screening Tool/MST)</span>
                            </div>
                        </div> -->
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <span class="text_body">1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak diinginkan selama 6 bulan terakhir?</span>
                            </div>
                        </div> -->
                        <table border="0" width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-1" name="soal1-1" value="" <?php echo isset($data_formjson->gizi_penurunan_bb)?($data_formjson->gizi_penurunan_bb == "tidak" ? "checked" : "disabled"):""; ?>>
                                    <labe class="text_body"l for="soal1-1">Tidak</label>
                                </td>
                                <td width="15%"><span class="text_body">0</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-2" name="soal1-2" value="" <?php echo isset($data_formjson->gizi_penurunan_bb)?($data_formjson->gizi_penurunan_bb == "tidak_yakin" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-2">Tidak yakin (ada tanda : baju menjadi lebih longgar)</label>
                                </td>
                                <td width="15%"><span class="text_body">0</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-3" name="soal1-3" value="" <?php echo isset($data_formjson->gizi_penurunan_bb)?($data_formjson->gizi_penurunan_bb == "ya" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-3">Ya, ada penurunan berat badan sebanyak</label>
                                </td>
                                <td width="15%"><span class="text_body"></span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-4" name="soal1-4" value="" <?php  echo isset($data_formjson->value_gizi_penurunan_bb)?($data_formjson->value_gizi_penurunan_bb == "1-5kg" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-4">1-5 Kg</label>
                                </td>
                                <td width="15%"><span class="text_body">1</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">

                                    <input type="radio" id="soal1-5" name="soal1-5" value="" <?php echo isset($data_formjson->value_gizi_penurunan_bb)?($data_formjson->value_gizi_penurunan_bb == "6-10kg" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-5">6-10 Kg</label>
                                </td>
                                <td width="15%"><span class="text_body">2</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">

                                    <input type="radio" id="soal1-6" name="soal1-6" value="" <?php echo isset($data_formjson->value_gizi_penurunan_bb)?($data_formjson->value_gizi_penurunan_bb == "11-15Kg" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-6">11-15 Kg</label>
                                </td>
                                <td width="15%"><span class="text_body">3</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-7" name="soal1-7" value="" <?php echo isset($data_formjson->value_gizi_penurunan_bb)?($data_formjson->value_gizi_penurunan_bb == ">15Kg" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-7">>15 Kg</label>
                                </td>
                                <td width="15%"><span class="text_body">0</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-8" name="soal1-8" value="" <?php echo isset($data_formjson->value_gizi_penurunan_bb)?($data_formjson->value_gizi_penurunan_bb == "tidak_tahu" ? "checked" : "disabled"):""; ?>>
                                    <label class="text_body" for="soal1-8">Tidak tahu berapa Kg penurunannya</label>
                                </td>
                                <td width="15%"><span class="text_body">0</span></td>
                            </tr>
                        </table>

                        <table border="0" width="100%">
                            <tr>
                                <td><span class="text_body">2. Apakah asupan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makanan?</span></td>
                            </tr>
                        </table>
                        <!-- <div class="row">
                            <div class="col-lg-12">
                                <span class="text_body">2. Apakah asupan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makanan?</span>
                            </div>
                        </div> -->
                        <table border="0" width="100%">
                                <tr>
                                    <td width="5%"></td>
                                    <td width="80%">
                                        <input type="radio" id="soal2-1" name="soal2-1" value="" <?php echo isset($data_formjson->gizi_asupan_makan)?($data_formjson->gizi_asupan_makan == "tidak" ? "checked" : "disabled"):''; ?>>
                                        <label class="text_body" for="soal2-1">Tidak</label>
                                    </td>
                                    <td width="15%"><span class="text_body">0</span></td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="80%">
                                    
                                        <input type="radio" id="soal2-2" name="soal2-2" value="" <?php echo isset($data_formjson->gizi_asupan_makan)?($data_formjson->gizi_asupan_makan == "ya" ? "checked" : "disabled"):''; ?>>
                                        <label class="text_body" for="soal2-2">Ya</label>
                                    </td>
                                    <td width="15%"><span class="text_body">1</span></td>
                                </tr>
                        </table>           
                    </td>
                </tr>
                <tr>
                    <td>
                        <table>
                                <tr>
                                    <td<span class="text_body">TOTAL SKOR: <?= $skor; ?></span></td>
                                </tr>
                                <tr>
                                    <td><span class="text_body">Bila Skor > 2 dan atau pasien dengan diagnosis/kondisi khusus dilaporkan ke dokter pemeriksa</span></td>
                                </tr>
                        </table>
                    </td>
                </tr>
            </table><!-- BORDER LUAR --><br><br><br><br><br><br>
            <p style="text-align:left;font-size:12px">Hal 1 dari 2</p>
        <footer>
        </footer>
    </div>
    
    <!-- HALAMAN 2-->
    <div class="A4 sheet  padding-fix-10mm">
   
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>
            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK</p>
            <p align="center" style="font-size:12px;font-style:italic">(Dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</p>
        <!-- BORDER LUAR-->
        <table border="1" width="100%">
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr><td><span class="text_sub_judul">STATUS PSIKOSIAL</span></td></tr>
                        <tr>
                            <td>
                                <table border="0" width="100%">
                                    <tr>
                                        <td width="30%">
                                            <span class="text_body">Hubungan dengan anggota keluarga : </span>
                                        </td>
                                        <td>
                                            <input type="radio" id="hubungan_baik" name="hubungan_baik" value="" <?php echo isset($data_formjson->stat_sosial_keluarga)?($data_formjson->stat_sosial_keluarga == "baik" ? "checked" : "disabled"):""; ?>>
                                            <label class="text_body" for="hubungan_baik">Baik</label>
                                            <input type="radio" id="hubungan_tidak_baik" name="hubungan_tidak_baik" value="" <?php echo isset($data_formjson->stat_sosial_keluarga)?($data_formjson->stat_sosial_keluarga == "tidak_baik" ? "checked" : "disabled"):""; ?>>
                                            <label class="text_body" for="hubungan_tidak_baik">Tidak Baik</label>
                                        </td>
                                    </td>
                                </table>
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
                                <span class="text_sub_judul">STATUS PSIKOLOGIS</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" id="tenang" name="tenang"  value="tenang" <?php echo isset($data_formjson->stat_psikologis)?($data_formjson->stat_psikologis == "tenang" ? "checked" : "disabled"):""; ?>>Tenang</label>
                                <label><input type="checkbox"  value="marah" <?php echo isset($data_formjson->stat_psikologis)?($data_formjson->stat_psikologis == "marah" ? "checked" : "disabled"):""; ?>>Marah</label>
                                <label><input type="checkbox"  value="cemas" <?php echo isset($data_formjson->stat_psikologis)?($data_formjson->stat_psikologis == "cemas" ? "checked" : "disabled"):""; ?>>Cemas</label>
                                <label><input type="checkbox"  value="takut" <?php echo isset($data_formjson->stat_psikologis)?($data_formjson->stat_psikologis == "takut" ? "checked" : "disabled"):""; ?>>Takut</label>
                                <label><input type="checkbox"  value="kec_bunuh_diri" <?php echo isset($data_formjson->stat_psikologis)?($data_formjson->stat_psikologis == "bunuhdiri" ? "checked" : "disabled"):""; ?>>Kecenderungan Bunuh Diri</label>
                                <label><input type="checkbox"  value="lainnya" <?php echo isset($data_formjson->stat_psikologis)?($data_formjson->stat_psikologis == "lainnya" ? "checked" : "disabled"):""; ?>>Lainnya</label>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" widrh="100%">
                        <tr>
                            <td><span class="text_sub_judul">STATUS SOSIAL EKONOMI</span></td>
                        </tr>
                    </table>
                    <table border="0" width="100%">
                        <tr>
                            <td width="20%"><span class="text_body">Status Pernikahan</span></td>
                            <td width="5%"><span class="text_body">:</span></td>
                            <td width="75%">
                                <label><input type="checkbox" id="single" name="single"  value="single" <?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == 'B'? "checked" : "disabled"):""; ?>>Single</label>
                                <label><input type="checkbox" id="menikah" name="menikah"  value="menikah" <?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == 'K' ? "checked" : "disabled"):""; ?>>Menikah</label>
                                <label><input type="checkbox" id="janda_duda" name="janda_duda"  value="janda_duda" <?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == "C" ? "checked" : "disabled"):""; ?>>Janda/Duda</label>
                            </td>
                        </tr>
                        <tr>
                            <td width="20%"><span class="text_body">Pekerjaan</span></td>
                            <td width="5%"><span class="text_body">:</span></td>
                            <td width="75%">
                                <label><input type="checkbox" id="pns" name="pns"  value="pns" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan == "PNS/Pol/TNI" ? "checked" : "disabled"):""; ?>>PNS</label>
                                <label><input type="checkbox" id="swasta" name="swasta"  value="swasta" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan == "Karyawan Swasta" ? "checked" : "disabled"):""; ?>>Swasta</label>
                                <label><input type="checkbox" id="tni_polri" name="tni_polri"  value="tni_polri" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan == "tni_polri" ? "checked" : "disabled"):""; ?>>TNI/POLRI</label>
                                <label><input type="checkbox" id="tni_polri" name="lainnya"  value="lainnya" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan != "Karyawan Swasta" && $data_pasien[0]->pekerjaan != "PNS/Pol/TNI" ? "checked" : "disabled"):""; ?>><?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan != "Karyawan Swasta" && $data_pasien[0]->pekerjaan != "PNS/Pol/TNI" ? $data_pasien[0]->pekerjaan : "Lainnya"):''; ?></label>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr><td><span class="text_sub_judul">SKRINING RISIKO CEDERA / JATUH</span></td></tr>
                        <tr>
                            <td>
                            <label><input type="checkbox" id="resiko_rendah" name="resiko_rendah" value="resiko_rendah" <?php echo isset($data_formjson->skrining_risiko_cedera)?($data_formjson->skrining_risiko_cedera == "resiko_rendah" ? "checked" : "disabled"):""; ?>>Resiko Rendah</label>
                            <label><input type="checkbox" id="resiko_tinggi" name="resiko_tinggi"  value="resiko_tinggi" <?php echo isset($data_formjson->skrining_risiko_cedera)?($data_formjson->skrining_risiko_cedera == "resiko_tinggi" ? "checked" : "disabled"):""; ?>>Resiko Tinggi</label>
                            <label><input type="checkbox" id="tidak_beresiko" name="tidak_bersiko"  value="tidak_beresiko" <?php echo isset($data_formjson->skrining_risiko_cedera)?($data_formjson->skrining_risiko_cedera == "tidak_beresiko" ? "checked" : "disabled"):""; ?>>Tidak Beresiko</label>
                            <label><input type="checkbox" id="gelang" name="gelang"  value="gelang" <?php echo isset($data_formjson->skrining_risiko_cedera)?($data_formjson->skrining_risiko_cedera == "pasang_gelang" ? "checked" : "disabled"):""; ?>>Pasang Gelang Resiko Jatuh Warna Kuning</label>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td><span class="text_sub_judul">ASESMEN FUNGSIONAL</span></td>
                        </tr>
                        <tr>
                            <td>
                                <label><input type="checkbox" id="mandiri" name="mandiri" value="mandiri" <?php echo isset($data_formjson->fungsional_alat_bantu)?($data_formjson->fungsional_alat_bantu == "mandiri" ? "checked" : "disabled"):""; ?>>Mandiri</label>
                                <label><input type="checkbox" id="perlu_bantuan" name="perlu_bantuan"  value="perlu_bantuan" <?php echo isset($data_formjson->fungsional_alat_bantu)?($data_formjson->fungsional_alat_bantu == "perlu_bantuan" ? "checked" : "disabled"):""; ?>>Perlu Bantuan,</label>
                                <span class="text_body">Sebutkan, <span class="text_isi"><?php echo $data_formjson->alat_bantu??"";?></span></span><br>

                                <label><input type="checkbox" id="ketergantungan_total" name="ketergantungan_total"  value="ketergantungan_total" <?php echo isset($data_formjson->fungsional_alat_bantu)?($data_formjson->fungsional_alat_bantu == "ketergantungan_total" ? "checked" : "disabled"):""; ?>>Ketergantungan Total</label>
                                <!-- <label><input type="checkbox" id="lapor_dokter" name="lapor_dokter"  value="lapor_dokter" <?php echo isset($data_formjson->fungsional_alat_bantu)?($data_formjson->fungsional_alat_bantu == "dilaporkan_dokter" ? "checked" : "disabled"):""; ?>>dilaporkan dokter Jam</label>
                                <span class="text_body">........ WIB</span> -->
                                <br><label><input type="checkbox" id="kekuatan_otot" name="kekuatan_otot"  value="kekuatan_otot" <?php echo isset($data_formjson->kekuatan_otot)?(in_array("kekuatan_otot", $data_formjson->kekuatan_otot) ? "checked" : "disabled"):""; ?>>Kekuatan Otot</label>
                                <table  width="10%">
                                    <tr style="border-bottom:1px solid black">
                                        <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data_formjson->tangan_kanan)?($data_formjson->tangan_kanan?$data_formjson->tangan_kanan :''):'' ?></td>
                                        <td style="font-size:15pt;text-align:center;"><?= isset($data_formjson->tangan_kiri)?($data_formjson->tangan_kiri?$data_formjson->tangan_kiri :''):"" ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data_formjson->{'kaki_Kanan'})?($data_formjson->{'kaki_Kanan'}?$data_formjson->{'kaki_Kanan'} :''):"" ?></td>
                                        <td style="font-size:15pt;text-align:center;"><?= isset($data_formjson->{'kaki_Kiri'})?($data_formjson->{'kaki_Kiri'}?$data_formjson->{'kaki_Kiri'} :''):"" ?></td>
                                    </tr>
                                </table>
                            </td>                            
                        </tr>
                    </table>
                    <br>
                </td>
            </tr>
            <tr>
                <td>
                <?php 
                        // foreach ($asesmen_masalah_keperawatan as $data_formjson) {
                ?>
                    <table border="0" width="100%">
                        <tr>
                            <td width=50%><span class="text_sub_judul">MASALAH KEPERAWATAN</span></td>
                            <td width=50%><span class="text_sub_judul">TUJUAN/KRITERIA HASIL</span></td>
                        </tr>
                        <tr >
                            <td style="margin-top:10px;" width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->nyeri_akut[0])?($data_formjson->nyeri_akut[0] != "" ? "checked" : "disabled"):''; ?>>Nyeri (akut/kronis)</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->chek_nyeri_akut??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->ketidakseimbangan_nutrisi[0])?($data_formjson->ketidakseimbangan_nutrisi[0] != "" ? "checked" : "disabled"):''; ?>>Ketidak seimbangan nutrisi kurang dari kebutuhan</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_ketidakseimbangan_nutrisi??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->pola_nafas_tidak_efektif[0])?($data_formjson->pola_nafas_tidak_efektif[0] != "" ? "checked" : "disabled"):''; ?>>Pola nafas tidak efektif</label>
                            </td>
                            <td width="50%">
                            <span class="text_isi"><?php echo $data_formjson->check_pola_nafas_tidak_efektif??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->bersihkan_jalan_nafas[0])?($data_formjson->bersihkan_jalan_nafas[0] != "" ? "checked" : "disabled"):''; ?>>Bersihkan jalan nafas</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_bersihkan_jalan_nafas??""; ?></span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->hipertermia[0])?($data_formjson->hipertermia[0] != "" ? "checked" : "disabled"):''; ?>>Hipertermia</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_hipertermia??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->diare[0])?($data_formjson->diare[0] != "" ? "checked" : "disabled"):''; ?>>Diare</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_diare??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->resiko_infeksi_pembedahan[0])?($data_formjson->resiko_infeksi_pembedahan[0] != "" ? "checked" : "disabled"):''; ?>>Resiko infeksi, pembedahan</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_resiko_infeksi_pembedahan??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->ansietas[0])?($data_formjson->ansietas[0] != "" ? "checked" : "disabled"):''; ?>>Ansietas</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_ansietas??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->gangguan_citra_tubuh[0])?($data_formjson->gangguan_citra_tubuh[0] != "" ? "checked" : "disabled"):""; ?>>Gangguan citra tubuh</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_gangguan_citra_tubuh??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->gangguan_menelan[0])?($data_formjson->gangguan_menelan[0] != "" ? "checked" : "disabled"):""; ?>>Gangguan menelan</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_gangguan_menelan??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->penurunan_curah_jantung[0])?($data_formjson->penurunan_curah_jantung[0] != "" ? "checked" : "disabled"):""; ?>>Penurunan curah jantung</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_penurunan_curah_jantung??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->intoleran_aktifitas[0])?($data_formjson->intoleran_aktifitas[0] != "" ? "checked" : "disabled"):""; ?>>Intoleransi Aktifitas</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_intoleran_aktifitas??""; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->gangguan_mobilitas_fisik[0])?($data_formjson->gangguan_mobilitas_fisik[0] != "" ? "checked" : "disabled"):""; ?>>Gangguan Mobilitas Fisik</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_gangguan_mobilitas_fisik??''; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->hambatan_komunikasi_verbal[0])?($data_formjson->hambatan_komunikasi_verbal[0] != "" ? "checked" : "disabled"):""; ?>>Hambatan Komunikasi Verbal</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_hambatan_komunikasi_verbal??''; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->diskontuinitas_jaringan[0])?($data_formjson->diskontuinitas_jaringan[0] != "" ? "checked" : "disabled"):""; ?>>Diskontinuitas jaringan</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_diskontuinitas_jaringan??''; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?php echo isset($data_formjson->ketidakstabilan_gula_darah[0])?($data_formjson->ketidakstabilan_gula_darah[0] != "" ? "checked" : "disabled"):""; ?>>Ketidakstabilan kadar gula darah</label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?php echo $data_formjson->check_ketidakstabilan_gula_darah??''; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?= isset($data_formjson->check_lainnya[0])? 'checked':'' ?> ><?= isset($data_formjson->check_lainnya)?$data_formjson->check_lainnya :"Lainnya ............" ?></label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?= isset($data_formjson->check_lainnya2)?$data_formjson->check_lainnya2 :" " ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td width="50%">
                                <label><input type="checkbox" value="" <?= isset($data_formjson->check_lainnya1)? 'checked':'' ?> ><?= isset($data_formjson->check_lainnya1)?$data_formjson->check_lainnya1 :"Lainnya ............" ?></label>
                            </td>
                            <td width="50%">
                                <span class="text_isi"><?= isset($data_formjson->check_lainnya3)?$data_formjson->check_lainnya3 :" " ?></span>
                            </td>
                        </tr>
                    </table>
                    <?php
                         //}
                    ?>
                </td>
            <tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td><span class="text_sub_judul">KEBUTUHAN EDUKASI</span></td>
                        </tr>
                        <tr>
                            <td>
                            <label><input type="checkbox" value="" <?php echo isset($data_formjson->kebutuhan_edukasi)?(in_array("pengetahuan tentang penyakit", $data_formjson->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>Pengetahuan tentang penyakit</label> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <label><input type="checkbox" value="" <?php echo isset($data_formjson->kebutuhan_edukasi)?(in_array("perawatan dirumah tentang penyakit", $data_formjson->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>Perawatan di rumah tentang penyakitnya</label> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <label><input type="checkbox" value="" <?php echo isset($data_formjson->kebutuhan_edukasi)?(in_array("cara minum obat", $data_formjson->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>Cara minum obat</label> 
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <label><input type="checkbox" value="" <?php echo isset($data_formjson->kebutuhan_edukasi)?(in_array("diet", $data_formjson->kebutuhan_edukasi) ? "checked" : "disabled"):""; ?>>diet</label> 
                            </td>
                        </tr>
                        <?php
                            //foreach ($data_rawat_jalan as $row_rawat_jalan) {
                        ?>
                        <tr>
                            <td>
                            <label><input type="checkbox" value="" <?php echo isset($data_rawat_jalan->ket_pulang)?($data_rawat_jalan->ket_pulang == "KONTROL" ? "checked" : "disabled"):''; ?>>Kontrol ulang</label> 
                            </td>
                        </tr>
                        <?php
                            //}
                        ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="100%">
                        <tr>
                            <td width="70%">
                            </td>
                            <td width="30%" style="border-right:1;border-left=1;">
                                <!-- <center>
                                    <img height="150px" width="150px" src="<?php  echo $json['question120']; ?>" id="img_ttd"/>
                                </center> -->
                            </td>
                        </tr>
                        <?php
                            // foreach ($data_rawat_jalan as $row_rawat_jalan) {
                        ?>
                        <tr>
                            <td width="70%">
                            </td>
                            <td width="30%">
                            <center>
                                <span class="text_isi">
                                    <?php 
                                    if(isset($get_ttd_perawat->ttd)){
                                    ?>
                                        <img width="120px" src="<?= ($get_ttd_perawat->ttd)?$get_ttd_perawat->ttd:'-'; ?>" alt="" srcset="">
                                    <?php } else{?>
                                    <br><br><br>
                                    <?php } ?>
                                </span> 
                            </center>
                            </td>
                        </tr>
                        <tr>
                            <td width="70%">
                            </td>
                            <td width="30%">
                            <center>
                                <span class="text_isi"><?= $get_ttd_perawat->name??"" ?></span> 
                            </center>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table><!--BORDER LUAR END--><br><br><br><br><br><br><br><br>
        <p style="text-align:left;font-size:12px">Hal 2 dari 2</p>

   </div><!-- END HALAMAN 2-->
      
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   