<?php 
$data_formjson = isset($get_assesment_keperawatan_irj->formjson)?json_decode($get_assesment_keperawatan_irj->formjson):'';
// var_dump($data_formjson->kaki_kanan);
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
// echo $skor;
?>

<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       table tr td{
           font-size:11px;
       }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
    <?php
// var_dump($kode_document);
?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK MATA</p>
            <p align="center" style="font-size:12px;font-style:italic">(Dilengkapi dalam waktu 2 jam pertama pasien masuk ruang rawat jalan)</p>

            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td width="70%">DATA UMUM</td>
                                <td width="30%">Cara Bayar : <?php echo $data_rawat_jalan[0]->cara_bayar??'';?></td>
                            </tr>
                        </table>
            
                        <table border="0" width="100%">
                            <tr>
                                <td width="30%"><p>Hari/Tanggal : <?php echo $asesmen_keperawatan[0]->tgl??'';?></p></td>
                                <td width="25%"><p>Jam Datang : <?php echo isset($asesmen_keperawatan[0]->tgl_kunjungan)?substr($asesmen_keperawatan[0]->tgl_kunjungan,11,5).' ':''; ?>WIB</p></td>
                                <td width="30%"><p>Jam Pemeriksaan : <?= isset($asesmen_keperawatan[0]->tanggal_pemeriksaan)?date('H.i',strtotime($asesmen_keperawatan[0]->tanggal_pemeriksaan)).' ':'' ?>WIB</p></td>
                            </tr>

                            <tr>
                                <td colspan ="3">
                                    <span>Sumber data :</span>
                                    <input type="checkbox" >
                                    <span>Pasien</span>
                                    <input type="checkbox">
                                    <span>Keluarga</span>            
                                    <input type="checkbox">
                                    <span></span>
                                </td>
                              
                            </tr>
                        </table>

                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%">
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
                        <table border="0" width="100%">
                            <tr>
                                <td>
                                    <div style="min-height:30px">
                                        <span>RIWAYAT KESEHATAN</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                <span><?= isset($data_formjson->riwayat_kesehatan_sekarang)?$data_formjson->riwayat_kesehatan_sekarang:'' ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%" >
                            <tr>
                                <td><span>PEMERIKSAAN FISIK</span></td>
                            </tr>
                        </table>
                        <table border="0" width="100%" >
                            <tr>
                                <td width="50%"> 
                                     <p>Kesadaran : <?php echo $asesmen_keperawatan[0]->keadaan_umum??''; ?></p>
                                </td>
                                <td width="50%">
                                     <p>Keadaan Umum : <?php echo $asesmen_keperawatan[0]->keadaan_umum??''; ?></p>
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%" >
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
                                        RR : 
                                       
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
                        <p>Status oftalmik</p>
                        <table border="0" width="100%" >
                            <tr>
                                <td colspan="3">VISUS</td>
                                <td colspan="3">KACAMATA</td>
                            </tr>
                            <tr>
                                <td width="10%"><span>OD</span></td>
                                <td width="2%">:</td>
                                <td width="38%"><?= isset($data_formjson->visus->od)?$data_formjson->visus->od:'' ?></td>
                                <td width="10%"><span>OD</span></td>
                                <td width="2%">:</td>
                                <td width="38%"><?= isset($data_formjson->kacamata->od)?$data_formjson->kacamata->od:'' ?></td>
                            </tr>
                            <tr>
                                <td><span>OS</span></td>
                                <td>:</td>
                                <td><?= isset($data_formjson->visus->os)?$data_formjson->visus->os:'' ?></td>
                                <td><span>OS</span></td>
                                <td>:</td>
                                <td><?= isset($data_formjson->kacamata->os)?$data_formjson->kacamata->os:'' ?></td>
                            </tr>
                        </table>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%" >
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
                                <td>
                                    <p>
                                    <span>Nyeri : </span>
                                        <input type="checkbox"  value="nyeri_ya" <?php echo isset($data_formjson->nyeri)?($data_formjson->nyeri == "tidak" ? "checked" : "disabled"):''; ?>>
                                        <span>Tidak</span>
                                        <input type="checkbox"  value="nyeri_tidak" <?php echo isset($data_formjson->nyeri)?($data_formjson->nyeri == "ya, bersifat" ? "checked" : "disabled"):''; ?>>
                                        <span>Ya, Bersifat</span>
                                        <input type="checkbox"  value="nyeri_akut" <?php echo isset($data_formjson->check_nyeri)?($data_formjson->check_nyeri == "akut" ? "checked" : "disabled"):''; ?>>
                                        <span>Akut</span>
                                        <input type="checkbox"  value="nyeri_kronis" <?php echo isset($data_formjson->check_nyeri)?($data_formjson->check_nyeri == "kronis" ? "checked" : "disabled"):''; ?>>
                                        <span>Kronis</span> 
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td><img src=" <?= base_url("assets/img/asesmenawal1.PNG"); ?>"  alt="img" height="50" width="200" style="padding-right:5px;"></td>

                            </tr>
                        </table>
                        
                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%"><span>1.</span></td>
                                    <td width="30%"><span>Kualitas Nyeri</span></td>
                                    <td width="5%"><span>:</span></td>
                                    <td width="60%">
                                        <input type="checkbox"  value="nyeri_tumpul" <?php echo isset($data_formjson->kualitas_nyeri)?($data_formjson->kualitas_nyeri == "nyeri_tumpul" ? "checked" : "disabled"):''; ?>>Nyeri Tumpul
                                        <input type="checkbox"  value="nyeri_tajam" <?php echo isset($data_formjson->kualitas_nyeri)?($data_formjson->kualitas_nyeri == "nyeri_tajam" ? "checked" : "disabled"):''; ?>>Nyeri Tajam
                                        <input type="checkbox"  value="panas" <?php echo isset($data_formjson->kualitas_nyeri)?($data_formjson->kualitas_nyeri == "panas_terbakar" ? "checked" : "disabled"):''; ?>>Panas Terbakar
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><p>2.</p></td>
                                    <td width="30%"><p>Menjalar</p></td>
                                    <td width="5%"><p>:</p></td>
                                    <td width="60%"><p>
                                        <input type="checkbox"  value="tidak" <?php echo isset($data_formjson->menjalar)?($data_formjson->menjalar == null||$data_formjson->menjalar =='tidak' ? "checked":"disabled"):''; ?>>
                                        <span>Tidak</span>
                                        <input type="checkbox"  value="iya" <?php echo isset($data_formjson->menjalar)?($data_formjson->menjalar != "tidak"? "checked" : "disabled"):''; ?>>
                                        <span>Ya,*</span>
                                        <span>ke </span>
                                        <?php 
                                            if(isset($data_formjson->menjalar)){
                                                if ($data_formjson->menjalar == 'tidak'){
                                                    echo '';
                                                } else {
                                                    echo $data_formjson->check_menjalar;
                                                }
                                            }else{
                                                echo "";
                                            }    
                                        ?>
                                        </p>
                                        
      
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span>3.</span></td>
                                    <td width="30%"><span>Skor Nyeri</span></td>
                                    <td width="5%"><span>:</span></td>
                                    <td width="60%">
                                        <span><?php echo $data_formjson->skor_nyeri??""; ?></span>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><p>4.</p></td>
                                    <td width="30%"><p>Frekuensi Nyeri</p></td>
                                    <td width="5%"><p>:</p></td>
                                    <td width="60%"><p>
                                        <input type="checkbox"  value="frek_jarang" <?php echo isset($data_formjson->frekuensi_nyeri)?($data_formjson->frekuensi_nyeri == "jarang" ? "checked" : "disabled"):""; ?>>
                                        <span>Jarang</span>
                                        <input type="checkbox"  value="frek_hilang_timbul" <?php echo isset($data_formjson->frekuensi_nyeri)?($data_formjson->frekuensi_nyeri == "hilang_timbul" ? "checked" : "disabled"):""; ?>>
                                        <span>Hilang Timbul</span>
                                        <input type="checkbox"  value="frek_terus" <?php echo isset($data_formjson->frekuensi_nyeri)?($data_formjson->frekuensi_nyeri == "terus_menerus" ? "checked" : "disabled"):""; ?>>
                                        <span>Terus Menerus</span></p>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span>5.</span></td>
                                    <td width="30%"><span>Lamanya Nyeri</span></td>
                                    <td width="5%"><span>:</span></td>
                                    <td width="60%">
                                    <span><?php echo $data_formjson->lamanya_nyeri??""; ?></span>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><p>6.</p></td>
                                    <td width="30%"><p>Lokasi Nyeri</p></td>
                                    <td width="5%"><p>:</p></td>
                                    <td width="60%">
                                        <p><?php echo $data_formjson->lokasi_nyeri??""; ?></p>
                                    </td>
                                <tr>
                                <tr>
                                    <td width="5%"><span>7.</span></td>
                                    <td width="30%"><span>Faktor-faktor yang mengurangi / menghilangkan nyeri </span></td>
                                    <td width="5%"><span>:</span></td>
                                    <td width="60%">
                                        <input type="checkbox"  value="min_obat" <?php echo isset($data_formjson->faktor_faktor)?(in_array("minum_obat", $data_formjson->faktor_faktor) ? "checked" : "disabled"):""; ?>>
                                        <span>Minum Obat</span>
                                        <input type="checkbox"  value="istirahat" <?php echo isset($data_formjson->faktor_faktor)?(in_array("istirahat", $data_formjson->faktor_faktor) ? "checked" : "disabled"):""; ?>>
                                        <span>Istirahat</span>
                                        <input type="checkbox"  value="musik" <?php echo isset($data_formjson->faktor_faktor)?(in_array("mendengar_musik", $data_formjson->faktor_faktor) ? "checked" : "disabled"):""; ?>>
                                        <span>Mendengarkan Musik</span><br>
                                        <input type="checkbox"  value="pos_tidur" <?php echo isset($data_formjson->faktor_faktor)?(in_array("berubah_posisi_tidur", $data_formjson->faktor_faktor) ? "checked" : "disabled"):""; ?>>
                                        <span>Berubah Posisi Tidur</span>
                                    </td>
                                <tr>
                            </table>
                            
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td><span style="font-weight:bold;">SKRINING GIZI (Berdasarkan Malnutrition Screening Tool/MST)</span></td>
                            </tr>
                            <tr>
                                <td><p>1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak diinginkan selama 6 bulan terakhir?</p></td>
                            </tr>
                        </table>
        
                        <table border="0" width="100%">
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-1" name="soal1-1" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "0" ? "checked" : "disabled"):""; ?>>
                                    <span for="soal1-1">Tidak
                                </td>
                                <td width="15%"><span>0</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-2" name="soal1-2" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "2" ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak yakin (ada tanda : baju menjadi lebih longgar)</span>
                                </td>
                                <td width="15%"><span>0</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-3" name="soal1-3" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "ya" ? "checked" : "disabled"):""; ?>>
                                    <span>Ya, ada penurunan berat badan sebanyak</span>
                                </td>
                                <td width="15%"><span></span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-4" name="soal1-4" value="" <?php  echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "1" ? "checked" : "disabled"):""; ?>>
                                    <span>1-5 Kg</span>
                                </td>
                                <td width="15%"><span>1</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">

                                    <input type="radio" id="soal1-5" name="soal1-5" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "2" ? "checked" : "disabled"):""; ?>>
                                    <span>6-10 Kg</span>
                                </td>
                                <td width="15%"><span>2</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">

                                    <input type="radio" id="soal1-6" name="soal1-6" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "3" ? "checked" : "disabled"):""; ?>>
                                    <span>11-15 Kg</span>
                                </td>
                                <td width="15%"><span>3</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-7" name="soal1-7" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "4" ? "checked" : "disabled"):""; ?>>
                                    <span>>15 Kg</span>
                                </td>
                                <td width="15%"><span>0</span></td>
                            </tr>
                            <tr>
                                <td width="5%"></td>
                                <td width="80%">
                                    <input type="radio" id="soal1-8" name="soal1-8" value="" <?php echo isset($data_formjson->table_skrining->result->{'1'})?($data_formjson->table_skrining->result->{'1'} == "2" ? "checked" : "disabled"):""; ?>>
                                    <span>Tidak tahu berapa Kg penurunannya</span>
                                </td>
                                <td width="15%"><span>0</span></td>
                            </tr>
                        </table>

                               
                    </td>
                </tr>
               
            </table><br>
            <p style="text-align:left;font-size:12px">Hal 1 dari 1</p>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print_genap') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:16px">ASESMEN AWAL KEPERAWATAN POLIKLINIK MATA</p>

            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td>
                            <table border="0" width="100%">
                                    <tr>
                                        <td><span>2. Apakah asupan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makanan?</span></td>
                                    </tr>
                            </table>

                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%"></td>
                                    <td width="80%">
                                        <input type="radio" id="soal2-1" name="soal2-1" value="" <?php echo isset($data_formjson->table_skrining->result->{'2'})?($data_formjson->table_skrining->result->{'2'} == "0" ? "checked" : "disabled"):""; ?>>
                                        <span>Tidak</span>
                                    </td>
                                    <td width="15%"><span>0</span></td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="80%">
                                    
                                        <input type="radio" id="soal2-2" name="soal2-2" value="" <?php echo isset($data_formjson->table_skrining->result->{'2'})?($data_formjson->table_skrining->result->{'2'} == "1" ? "checked" : "disabled"):""; ?>>
                                        <span>Ya</span>
                                    </td>
                                    <td width="15%"><span>1</span></td>
                                </tr>
                            </table><hr>   
                            
                            <table border="0" width="100%">
                                <tr>
                                    <td>
                                        <table>
                                                <tr>
                                                    <td<span>TOTAL SKOR: <?php echo isset($data_formjson->table_skrining->result->total_skor)?$data_formjson->table_skrining->result->total_skor:''; ?></span></td>
                                                </tr>
                                                <tr>
                                                    <td><span>Bila Skor > 2 dan atau pasien dengan diagnosis/kondisi khusus dilaporkan ke dokter pemeriksa</span></td>
                                                </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr><td><span style="font-weight:bold">STATUS PSIKOSIAL</span></td></tr>
                            <tr>
                                <td>
                                    <table border="0" width="100%">
                                        <tr>
                                            <td width="40%">
                                                <p>Hubungan dengan anggota keluarga : </p>
                                            </td>
                                            <td width="60%"><p>
                                                <input type="radio" id="hubungan_baik" name="hubungan_baik" value="" <?php echo isset($data_formjson->hubungan_dengan_keluarga)?($data_formjson->hubungan_dengan_keluarga == "baik" ? "checked" : "disabled"):""; ?>>
                                                <span>Baik</span>
                                                <input type="radio" id="hubungan_tidak_baik" name="hubungan_tidak_baik" value="" <?php echo isset($data_formjson->hubungan_dengan_keluarga)?($data_formjson->hubungan_dengan_keluarga == "tidak_baik" ? "checked" : "disabled"):""; ?>>
                                                <span>Tidak Baik</span></p>
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
                                    <span style="font-weight:bold">STATUS PSIKOLOGIS</span>
                                </td>
                            </tr>
                            <tr>
                                <td><p>
                                    <span><input type="checkbox" id="tenang" name="tenang"  value="tenang" <?php echo isset($data_formjson->status_psikologi)?($data_formjson->status_psikologi == "tenang" ? "checked" : "disabled"):""; ?>>Tenang</span>
                                    <span><input type="checkbox"  value="marah" <?php echo isset($data_formjson->status_psikologi)?($data_formjson->status_psikologi == "marah" ? "checked" : "disabled"):""; ?>>Marah</span>
                                    <span><input type="checkbox"  value="cemas" <?php echo isset($data_formjson->status_psikologi)?($data_formjson->status_psikologi == "cemas" ? "checked" : "disabled"):""; ?>>Cemas</span>
                                    <span><input type="checkbox"  value="takut" <?php echo isset($data_formjson->status_psikologi)?($data_formjson->status_psikologi == "takut" ? "checked" : "disabled"):""; ?>>Takut</span>
                                    <span><input type="checkbox"  value="kec_bunuh_diri" <?php echo isset($data_formjson->status_psikologi)?($data_formjson->status_psikologi == "bunuhdiri" ? "checked" : "disabled"):""; ?>>Kecenderungan Bunuh Diri dilaporkan ke</span>
                                    <span><input type="checkbox"  value="lainnya" <?php echo isset($data_formjson->status_psikologi)?($data_formjson->status_psikologi == "lainnya" ? "checked" : "disabled"):""; ?>>Lainnya</span></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" widrh="100%">
                            <tr>
                                <td><span style="font-weight:bold">STATUS SOSIAL EKONOMI</span></td>
                            </tr>
                        </table>
                        <table border="0" width="100%">
                            <tr>
                                <td width="20%"><p>Status Pernikahan</p></td>
                                <td width="5%"><p>:</p></td>
                                <td width="75%"><p>
                                    <span><input type="checkbox" id="single" name="single"  value="single" <?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == 'B'? "checked" : "disabled"):""; ?>>Single</span>
                                    <span><input type="checkbox" id="menikah" name="menikah"  value="menikah" <?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == 'K' ? "checked" : "disabled"):""; ?>>Menikah</span>
                                    <span><input type="checkbox" id="janda_duda" name="janda_duda"  value="janda_duda" <?php echo isset($data_pasien[0]->status)?($data_pasien[0]->status == "C" ? "checked" : "disabled"):""; ?>>Janda/Duda</span></p>
                                </td>
                            </tr>
                            <tr>
                                <td width="20%"><span>Pekerjaan</span></td>
                                <td width="5%"><span>:</span></td>
                                <td width="75%">
                                    <span><input type="checkbox" id="pns" name="pns"  value="pns" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan == "PNS/Pol/TNI" ? "checked" : "disabled"):""; ?>>PNS</span>
                                    <span><input type="checkbox" id="swasta" name="swasta"  value="swasta" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan == "Karyawan Swasta" ? "checked" : "disabled"):""; ?>>Swasta</span>
                                    <span><input type="checkbox" id="tni_polri" name="tni_polri"  value="tni_polri" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan == "tni_polri" ? "checked" : "disabled"):""; ?>>TNI/POLRI</span>
                                    <span><input type="checkbox" id="tni_polri" name="lainnya"  value="lainnya" <?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan != "Karyawan Swasta" && $data_pasien[0]->pekerjaan != "PNS/Pol/TNI" ? "checked" : "disabled"):""; ?>><?php echo isset($data_pasien[0]->pekerjaan)?($data_pasien[0]->pekerjaan != "Karyawan Swasta" && $data_pasien[0]->pekerjaan != "PNS/Pol/TNI" ? $data_pasien[0]->pekerjaan : "Lainnya"):''; ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr><td><span style="font-weight:bold">SKRINING RISIKO CEDERA / JATUH</span></td></tr>
                            <tr>
                                <td>
                                <span><input type="checkbox" id="resiko_rendah" name="resiko_rendah" value="resiko_rendah" <?php echo isset($data_formjson->resiko_jatuh)?($data_formjson->resiko_jatuh == "resiko_rendah" ? "checked" : "disabled"):""; ?>>Resiko Rendah</span>
                                <span><input type="checkbox" id="resiko_tinggi" name="resiko_tinggi"  value="resiko_tinggi" <?php echo isset($data_formjson->resiko_jatuh)?($data_formjson->resiko_jatuh == "resiko_tinggi" ? "checked" : "disabled"):""; ?>>Resiko Tinggi</span>
                                <span><input type="checkbox" id="tidak_beresiko" name="tidak_bersiko"  value="tidak_beresiko" <?php echo isset($data_formjson->resiko_jatuh)?($data_formjson->resiko_jatuh == "tidak_beresiko" ? "checked" : "disabled"):""; ?>>Tidak Beresiko</span>
                                <span><input type="checkbox" id="gelang" name="gelang"  value="gelang" <?php echo isset($data_formjson->resiko_jatuh)?($data_formjson->resiko_jatuh == "pasang_gelang" ? "checked" : "disabled"):""; ?>>Pasang Gelang Resiko Jatuh Warna Kuning</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td><span style="font-weight:bold">ASESMEN FUNGSIONAL</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <span><input type="checkbox" id="mandiri" name="mandiri" value="mandiri" <?php echo isset($data_formjson->penggunaan_alat_bantu)?($data_formjson->penggunaan_alat_bantu == "mandiri" ? "checked" : "disabled"):""; ?>>Mandiri</span>
                                    <span><input type="checkbox" id="perlu_bantuan" name="perlu_bantuan"  value="perlu_bantuan" <?php echo isset($data_formjson->penggunaan_alat_bantu)?($data_formjson->penggunaan_alat_bantu == "perlu_bantuan" ? "checked" : "disabled"):""; ?>>Perlu Bantuan,</span>
                                    <span>Sebutkan, <span><?php echo $data_formjson->check_alat_bantu??"";?></span></span><br>

                                    <span><input type="checkbox" id="ketergantungan_total" name="ketergantungan_total"  value="ketergantungan_total" <?php echo isset($data_formjson->penggunaan_alat_bantu)?($data_formjson->penggunaan_alat_bantu == "ketergantungan_total" ? "checked" : "disabled"):""; ?>>Ketergantungan Total</span>
                                    <br><span><input type="checkbox" id="kekuatan_otot" name="kekuatan_otot"  value="kekuatan_otot" <?php echo isset($data_formjson->kekuatan_otot)?($data_formjson->kekuatan_otot == "kekuatan_otot" ? "checked" : "disabled"):""; ?>>Kekuatan Otot</span>
                                    <table  width="10%">
                                        <tr style="border-bottom:1px solid black">
                                            <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data_formjson->tangan_kanan)?($data_formjson->tangan_kanan?$data_formjson->tangan_kanan :''):'' ?></td>
                                            <td style="font-size:15pt;text-align:center;"><?= isset($data_formjson->tangan_kiri)?($data_formjson->tangan_kiri?$data_formjson->tangan_kiri :''):"" ?></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data_formjson->kaki_kanan)?($data_formjson->kaki_kanan?$data_formjson->kaki_kanan :''):'' ?></td>
                                            <td style="font-size:15pt;text-align:center;"><?= isset($data_formjson->kaki_kanan)?($data_formjson->kaki_kanan?$data_formjson->kaki_kanan :''):'' ?></td>
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
                    
                        <table border="0" width="100%">
                            <tr>
                                <td width=50%><span style="font-weight:bold">MASALAH KEPERAWATAN</span></td>
                                <td width=50%><span style="font-weight:bold">TUJUAN/KRITERIA HASIL</span></td>
                            </tr>
                            <tr>
                                <td style="margin-top:10px;" width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->nyeri_akut[0])?($data_formjson->nyeri_akut[0] != "" ? "checked" : "disabled"):''; ?>>Nyeri (akut/kronis)</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->chek_nyeri_akut??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->ketidakseimbangan_nutrisi[0])?($data_formjson->ketidakseimbangan_nutrisi[0] != "" ? "checked" : "disabled"):''; ?>>Ketidak seimbangan nutrisi kurang dari kebutuhan</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_ketidakseimbangan_nutrisi??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->pola_nafas_tidak_efektif[0])?($data_formjson->pola_nafas_tidak_efektif[0] != "" ? "checked" : "disabled"):''; ?>>Pola nafas tidak efektif</span>
                                </td>
                                <td width="50%">
                                <span><?php echo $data_formjson->check_pola_nafas_tidak_efektif??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->bersihkan_jalan_nafas[0])?($data_formjson->bersihkan_jalan_nafas[0] != "" ? "checked" : "disabled"):''; ?>>Bersihkan jalan nafas</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_bersihkan_jalan_nafas??""; ?></span>
                                </td>
                            </tr>
                            
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->hipertermia[0])?($data_formjson->hipertermia[0] != "" ? "checked" : "disabled"):''; ?>>Hipertermia</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_hipertermia??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->diare[0])?($data_formjson->diare[0] != "" ? "checked" : "disabled"):''; ?>>Diare</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_diare??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->resiko_infeksi_pembedahan[0])?($data_formjson->resiko_infeksi_pembedahan[0] != "" ? "checked" : "disabled"):''; ?>>Resiko infeksi, pembedahan</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_resiko_infeksi_pembedahan??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->ansietas[0])?($data_formjson->ansietas[0] != "" ? "checked" : "disabled"):''; ?>>Ansietas</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_ansietas??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->gangguan_citra_tubuh[0])?($data_formjson->gangguan_citra_tubuh[0] != "" ? "checked" : "disabled"):""; ?>>Gangguan citra tubuh</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_gangguan_citra_tubuh??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->gangguan_menelan[0])?($data_formjson->gangguan_menelan[0] != "" ? "checked" : "disabled"):""; ?>>Gangguan menelan</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_gangguan_menelan??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->penurunan_curah_jantung[0])?($data_formjson->penurunan_curah_jantung[0] != "" ? "checked" : "disabled"):""; ?>>Penurunan curah jantung</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_penurunan_curah_jantung??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->intoleran_aktifitas[0])?($data_formjson->intoleran_aktifitas[0] != "" ? "checked" : "disabled"):""; ?>>Intoleransi Aktifitas</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_intoleran_aktifitas??""; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->gangguan_mobilitas_fisik[0])?($data_formjson->gangguan_mobilitas_fisik[0] != "" ? "checked" : "disabled"):""; ?>>Gangguan Mobilitas Fisik</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_gangguan_mobilitas_fisik??''; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->hambatan_komunikasi_verbal[0])?($data_formjson->hambatan_komunikasi_verbal[0] != "" ? "checked" : "disabled"):""; ?>>Hambatan Komunikasi Verbal</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_hambatan_komunikasi_verbal??''; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->diskontuinitas_jaringan[0])?($data_formjson->diskontuinitas_jaringan[0] != "" ? "checked" : "disabled"):""; ?>>Diskontinuitas jaringan</span>
                                </td>
                                <td width="50%">
                                    <span><?php echo $data_formjson->check_diskontuinitas_jaringan??''; ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?php echo isset($data_formjson->ketidakstabilan_gula_darah[0])?($data_formjson->ketidakstabilan_gula_darah[0] != "" ? "checked" : "disabled"):""; ?>>Ketidakstabilan kadar gula darah</span>
                                </td>
                                <td width="50%">
                                    <span><?= isset($data_formjson->check_ketidakstabila_gula_darah)?$data_formjson->check_ketidakstabila_gula_darah :" " ?></span>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <span><input type="checkbox" value="" <?= isset($data_formjson->check_lainnya[0])? 'checked':'' ?> ><?= isset($data_formjson->check_lainnya)?$data_formjson->check_lainnya :"Lainnya" ?></span>
                                </td>
                                <td width="50%">
                                    <span><?= isset($data_formjson->check_ketidakstabila_gula_darah)?$data_formjson->check_ketidakstabila_gula_darah :" " ?></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                <tr>
                <tr>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td><span style="font-weight:bold">KEBUTUHAN EDUKASI</span></td>
                            </tr>
                            <tr>
                                <td width="40%">
                                <span><input type="checkbox" value="" <?php echo isset($data_formjson->{'Pengetahuan Edukasi'})?(in_array("1", $data_formjson->{'Pengetahuan Edukasi'}) ? "checked" : "disabled"):""; ?>>Pengetahuan tentang penyakit</span> 
                                </td>

                                <td width="40%">
                                <span><input type="checkbox" value="" <?php echo isset($data_formjson->perawatan_penyakit)?(in_array("1", $data_formjson->perawatan_penyakit) ? "checked" : "disabled"):""; ?>>Perawatan di rumah tentang penyakitnya</span> 
                                </td>

                                <td>
                                <span><input type="checkbox" value="" <?php echo isset($data_formjson->diet)?(in_array("1", $data_formjson->diet) ? "checked" : "disabled"):""; ?>>diet</span> 
                                </td>

                                
                            </tr>
                           
                            <tr>
                                
                                <td width="20%">
                                <span><input type="checkbox" value="" <?php echo isset($data_formjson->cara_minum_obat)?(in_array("1", $data_formjson->cara_minum_obat) ? "checked" : "disabled"):""; ?>>Cara minum obat</span> 
                                </td>
                               

                                <td>
                                <span><input type="checkbox" value="" <?php echo isset($data_rawat_jalan->ket_pulang)?($data_rawat_jalan->ket_pulang == "KONTROL" ? "checked" : "disabled"):''; ?>>Kontrol ulang</span> 
                                </td>
                            </tr>
        
                            
                            <tr>
                               
                            </tr>
                           
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
                                        <br>
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
            </table><br>
            <div style="text-align:left;font-size:12px">Hal 2 dari 2</div>
        </div>
    </body>
</html>