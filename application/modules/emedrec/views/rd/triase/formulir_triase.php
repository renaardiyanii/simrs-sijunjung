<?php 
$data = (isset($triase->formjson))?json_decode($triase->formjson):'';
?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
                    <tr>
                        <td width="50%">
                            <table style="width: 100%; border: 0;">
                                
                                <tr>
                                    <td style="text-align: left;">
                                        <img src="<?= base_url('assets/img/logo.png'); ?>" alt="img" height="80px" width="70px" style="padding-bottom: 15px;">
                                    </td>
                                    <td style="font-size: 11px; text-align: center;">
                                        <b>PEMERINTAHAN KABUPATEN SIJUNJUNG</b><br>
                                        <b>RSUD AHMAD SYAFII MAARIF</b><br>
                                        <span style="font-size: 9px;">JL. Lintas Sumatera Km110 Tanah Badantuang Kab Sijunjung</span><br>
                                        <span style="font-size: 9px;">INSTALASI GAWAT DARURAT</span><br>
                                        <b>FORMULIR TRIASE</b>
                                    </td>
                                
                                </tr>
                                
                            </table>
                        </td>
                        <td width="50%" rowspan="4">
                            <table border="0" width="100%" cellpadding="5px" >
                                <tr>
                                    <td style="font-size:10px" width="40%">NO.RM</td>
                                    <td style="font-size:10px" width="2%">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">NAMA</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">JENIS KELAMIN</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->sex)?$data_pasien->sex:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">TANGGAL LAHIR/UMUR</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:10px">AGAMA</td>
                                    <td style="font-size:10px">: </td>
                                    <td style="font-size:10px"><?= isset($data_pasien->agama)?$data_pasien->agama:'' ?></td>
                                    
                                </tr>
                                <tr>
                                    <td style="font-size:10px">PEKERJAAN</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->pekerjaan)?$data_pasien->pekerjaan:'' ?></td>
                                
                                </tr>
                                
                                <tr>
                                    <td style="font-size:10px">JAM REGISTRASI</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_daftar_ulang->tgl_kunjungan)?date('h:i',strtotime($data_daftar_ulang->tgl_kunjungan)):'' ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:10px">CARA BAYAR</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_daftar_ulang->cara_bayar)?$data_daftar_ulang->cara_bayar:'' ?></td>
                                </tr>

                                <tr>
                                    <td style="font-size:10px">ALAMAT</td>
                                    <td style="font-size:10px">:</td>
                                    <td style="font-size:10px"><?= isset($data_pasien->alamat)?$data_pasien->alamat:'' ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" width="100%" cellpadding="1px">
                                <tr>
                                    
                                    <div style="font-size:10px;">
                                           <input type="checkbox" 
                                                style="width:55px; height:55px; <?php 
                                                    $question3 = isset($data->question3) ? (array)$data->question3 : []; 
                                                    if (in_array("merah", $question3)) { 
                                                        echo 'accent-color:red;'; 
                                                    } 
                                                ?>" 
                                                <?php echo in_array("merah", $question3) ? "checked" : "disabled"; ?>
                                            >
                                            <input type="checkbox" 
                                                style="width:55px; height:55px; <?php 
                                                    $question3 = isset($data->question3) ? (array)$data->question3 : []; 
                                                    if (in_array("kuning", $question3)) { 
                                                        echo 'accent-color:yellow;'; 
                                                    } 
                                                ?>" 
                                                <?php echo in_array("kuning", $question3) ? "checked" : "disabled"; ?>
                                            >  
                                             <input type="checkbox" 
                                                style="width:55px; height:55px; <?php 
                                                    $question3 = isset($data->question3) ? (array)$data->question3 : []; 
                                                    if (in_array("hijau", $question3)) { 
                                                        echo 'accent-color:green;'; 
                                                    } 
                                                ?>" 
                                                <?php echo in_array("hijau", $question3) ? "checked" : "disabled"; ?>
                                            >
                                            <input type="checkbox" 
                                                style="width:55px; height:55px; <?php 
                                                    $question3 = isset($data->question3) ? (array)$data->question3 : []; 
                                                    if (in_array("hitam", $question3)) { 
                                                        echo 'accent-color:black;'; 
                                                    } 
                                                ?>" 
                                                <?php echo in_array("hitam", $question3) ? "checked" : "disabled"; ?>
                                            >
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="border: 0px solid black;font-size:10px;">Cara Datang :</td>
                                    <td style="border: 0px solid black;">
                                    <div style="font-size:10px;">
                                            <input type="checkbox" <?php echo isset($data->cara_datang)?(in_array("sendiri", $data->cara_datang) ? "checked" : "disabled"):""; ?>>Sendiri
                                            <input type="checkbox" <?php echo isset($data->cara_datang)?(in_array("ambulance", $data->cara_datang) ? "checked" : "disabled"):""; ?>>Ambulance
                                            <input type="checkbox" <?php echo isset($data->cara_datang)?(in_array("diantar_polisi", $data->cara_datang) ? "checked" : "disabled"):""; ?>>Diantar polisi
                                            <input type="checkbox" <?php echo isset($data->cara_datang)?(in_array("other", $data->cara_datang) ? "checked" : "disabled"):""; ?>>Lain - lain   
                                    </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="font-size:10px;">Asal Rujukan : <?= isset($data->asruk)?$data->asruk:'' ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table border="0" width="100%" cellpadding="1px">
                            <tr>
                                <td style="border: 0px solid black; padding: 4px; font-size:10px;">DEATH ON ARRIVAL (DOA) :</td>
                                <td style="border: 0px solid black; padding: 4px; font-size:10px;">
                                <div>
                                        <input type="checkbox" <?php echo isset($data->doa)?(in_array("tidak_nafas", $data->doa) ? "checked" : "disabled"):""; ?>>Tidak ada nafas spontan/bunyi nafas<br>
                                        <input type="checkbox" <?php echo isset($data->doa)?(in_array("reflek_kornea", $data->doa) ? "checked" : "disabled"):""; ?>>Reflek Kornea tidak ada<br>
                                        <input type="checkbox" <?php echo isset($data->doa)?(in_array("tida_ada_nadi", $data->doa) ? "checked" : "disabled"):""; ?>>Tidak ada nadi/bunyi jantung
                                    
                                </div>
                                </td>
                                <td style="border: 0px solid black; padding: 4px; font-size:10px;">
                                    <div>
                                        <input type="checkbox" <?php echo isset($data->doa)?(in_array("dolls_eys", $data->doa) ? "checked" : "disabled"):""; ?>> Dools Eyes tidak bergerak<br>
                                        <input type="checkbox" <?php echo isset($data->doa)?(in_array("reflek_cahaya", $data->doa) ? "checked" : "disabled"):""; ?>>Reflek cahaya tidak ada<br>
                                        <input type="checkbox" <?php echo isset($data->doa)?(in_array("ekg_datar", $data->doa) ? "checked" : "disabled"):""; ?>>EKG Datar
                                    </div>
                                </td>
                            </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </header>
            
            <table border="1" width="100%" style="border-collapse: collapse;">

                <tr>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">PEMERIKSAAN</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">Skala Triase 1 <br>(0 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">Skala Triase 2 <br>(10 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">Skala Triase 3 <br>(30 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">Skala Triase 4 <br>(60 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">Skala Triase 5 <br>(120 Menit)</td>
                    <td style="border: 1px solid black; padding: 10px; text-align: center; font-size:12px;">Tanda <br> Vital</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">JALAN NAFAS</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->skala1)?(in_array("sumbatan", $data->jalan_nafas->jalan_nafas->skala1) ? "checked" : "disabled"):""; ?>>Sumbatan / risiko sumbatan
                                
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->skala2)?(in_array("bebas", $data->jalan_nafas->jalan_nafas->skala2) ? "checked" : "disabled"):""; ?>>Bebas / Ancaman <br>
                                
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->skala3)?(in_array("bebas", $data->jalan_nafas->jalan_nafas->skala3) ? "checked" : "disabled"):""; ?>>Bebas<br>
                            
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->skala4)?(in_array("bebas", $data->jalan_nafas->jalan_nafas->skala4) ? "checked" : "disabled"):""; ?>>Bebas<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->jalan_nafas->jalan_nafas->skala5)?(in_array("bebas", $data->jalan_nafas->jalan_nafas->skala5) ? "checked" : "disabled"):""; ?>>Bebas<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <p> Tekanan darah ..../...mmHg<br>
                        
                    </td>
                
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">PERNAFASAN</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala1)?(in_array("henti", $data->pernafasan->pernafasan->skala1) ? "checked" : "disabled"):""; ?>>Henti/ancaman henti nafas<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala1)?(in_array("bradipnea", $data->pernafasan->pernafasan->skala1) ? "checked" : "disabled"):""; ?>>Bradpnea (< 10)<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala1)?(in_array("distres", $data->pernafasan->pernafasan->skala1) ? "checked" : "disabled"):""; ?>>Distres ekstrim<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala1)?(in_array("sianosis", $data->pernafasan->pernafasan->skala1) ? "checked" : "disabled"):""; ?>>Sianosis /hipoventilasi
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala2)?(in_array("takipnea", $data->pernafasan->pernafasan->skala2) ? "checked" : "disabled"):""; ?>>Takipnea<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala2)?(in_array("mengi", $data->pernafasan->pernafasan->skala2) ? "checked" : "disabled"):""; ?>>Mengi<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala2)?(in_array("distres", $data->pernafasan->pernafasan->skala2) ? "checked" : "disabled"):""; ?>>Distres nafas berat
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                            
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala3)?(in_array("mengi", $data->pernafasan->pernafasan->skala3) ? "checked" : "disabled"):""; ?>>Mengi/sesak nafa sedang<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala3)?(in_array("saturas", $data->pernafasan->pernafasan->skala3) ? "checked" : "disabled"):""; ?>>saturasi 02 (90-95)<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                            
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala4)?(in_array("rr", $data->pernafasan->pernafasan->skala4) ? "checked" : "disabled"):""; ?>>RR Normal<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala4)?(in_array("aspirasi", $data->pernafasan->pernafasan->skala4) ? "checked" : "disabled"):""; ?>>aspirasi tanpa distre nafas<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala4)?(in_array("cedera", $data->pernafasan->pernafasan->skala4) ? "checked" : "disabled"):""; ?>>cedera dada tanpa distres nafas<br>
                                <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala4)?(in_array("sulit_menelan", $data->pernafasan->pernafasan->skala4) ? "checked" : "disabled"):""; ?>>sulit menelan tanpa distres nafas<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                 <input type="checkbox" <?php echo isset($data->pernafasan->pernafasan->skala5)?(in_array("normal", $data->pernafasan->pernafasan->skala5) ? "checked" : "disabled"):""; ?>>Normal<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <p>suhu............C<br>
                        <p> Nadi...........x/mnt<br>
                        <p>Nafas..........x/mnt<br>
                        <p>Sa02........%
                    </td>
                
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">SIRKULASI</td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala1)?(in_array("henti_jantung", $data->sirkulasi->sirkulasi->skala1) ? "checked" : "disabled"):""; ?>>Henti Jantung<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala1)?(in_array("nadi", $data->sirkulasi->sirkulasi->skala1) ? "checked" : "disabled"):""; ?>>Nadi tidak teraba<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala1)?(in_array("akral_dingin", $data->sirkulasi->sirkulasi->skala1) ? "checked" : "disabled"):""; ?>>Akral dingin<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala1)?(in_array("crt", $data->sirkulasi->sirkulasi->skala1) ? "checked" : "disabled"):""; ?>>CRT > 2dtk<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala2)?(in_array("nadi_lemah", $data->sirkulasi->sirkulasi->skala2) ? "checked" : "disabled"):""; ?>>Nadi lemah<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala2)?(in_array("bradikardi", $data->sirkulasi->sirkulasi->skala2) ? "checked" : "disabled"):""; ?>>Bradikardi/< 50<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala2)?(in_array("takikardi", $data->sirkulasi->sirkulasi->skala2) ? "checked" : "disabled"):""; ?>>Takikardia/ > 150<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala2)?(in_array("pucat", $data->sirkulasi->sirkulasi->skala2) ? "checked" : "disabled"):""; ?>>Pucat / lembab<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala3)?(in_array("nadi_kuat", $data->sirkulasi->sirkulasi->skala3) ? "checked" : "disabled"):""; ?>>Nadi kuat<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala3)?(in_array("takikardia", $data->sirkulasi->sirkulasi->skala3) ? "checked" : "disabled"):""; ?>>Takikardi<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala3)?(in_array("sistol", $data->sirkulasi->sirkulasi->skala3) ? "checked" : "disabled"):""; ?>>sistol > 160<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala3)?(in_array("diastol", $data->sirkulasi->sirkulasi->skala3) ? "checked" : "disabled"):""; ?>>diastol > 100<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala3)?(in_array("perdarahan", $data->sirkulasi->sirkulasi->skala3) ? "checked" : "disabled"):""; ?>>Perdarahan<br>

                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala4)?(in_array("nadi_kuat", $data->sirkulasi->sirkulasi->skala4) ? "checked" : "disabled"):""; ?>>Nadi kuat<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala4)?(in_array("frekuensi", $data->sirkulasi->sirkulasi->skala4) ? "checked" : "disabled"):""; ?>>Frekuensi nadi normal<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala4)?(in_array("sistol_normal", $data->sirkulasi->sirkulasi->skala4) ? "checked" : "disabled"):""; ?>>Sistol normal<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala4)?(in_array("diastol_normal", $data->sirkulasi->sirkulasi->skala4) ? "checked" : "disabled"):""; ?>>Diastol normal<br>
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->skala5)?(in_array("normal", $data->sirkulasi->sirkulasi->skala5) ? "checked" : "disabled"):""; ?>>Normal<br>
                                
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 4px; font-size:12px;">
                            <div>
                                <p style="text-align:center">IMUNISASI</p>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->tanda_vital)?(in_array("ada", $data->sirkulasi->sirkulasi->tanda_vital) ? "checked" : "disabled"):""; ?>>ada<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->tanda_vital)?(in_array("tidak_ada", $data->sirkulasi->sirkulasi->tanda_vital) ? "checked" : "disabled"):""; ?>>Tidak ada<br>
                                <input type="checkbox" <?php echo isset($data->sirkulasi->sirkulasi->tanda_vital)?(in_array("tidak_tahu", $data->sirkulasi->sirkulasi->tanda_vital) ? "checked" : "disabled"):""; ?>>Tidak tahu<br>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">DISABILITAS</td>
                    <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                            <div>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->skala1)?(in_array("gcs", $data->disabilitas->disabilitas->skala1) ? "checked" : "disabled"):""; ?>>GCS < 8<br> (3/4/5/6/7/8) <br>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->skala1)?(in_array("tidak_ada", $data->disabilitas->disabilitas->skala1) ? "checked" : "disabled"):""; ?>>Tidak ada respon hanya atas nyeri<br>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->skala1)?(in_array("kejang", $data->disabilitas->disabilitas->skala1) ? "checked" : "disabled"):""; ?>>Kejang<br>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->skala1)?(in_array("amuk", $data->disabilitas->disabilitas->skala1) ? "checked" : "disabled"):""; ?>>Amuk/gangguan tingkah laku berat
                            
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("gcs", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>GCS 9-12 <br>(9/10/11/12)<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("gelisah", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Gelisah<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("nyeri_dada", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Nyeri dada khas<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("hermi", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Hemi-paresis akut<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("disfasia", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Disfasia berat<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("nyer_hebat", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Nyeri hebat<br>(9/10)<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("nyeri_mengarah", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Nyeri mengarah<br>PE/AAA/KET<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("agresif", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Agresif<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("perlu_hebat", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Perlu bebat<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala2)?(in_array("agitas_berat", $data->disabilitas->disabilitas->skala2) ? "checked" : "disabled"):""; ?>>Agitasi Berat<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("gcs", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>GCS > 12 (13/14)<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("kejang", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Kejang GCS 15<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("cedera_kepala", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Cedera kepala<br> pernah tidak sadar <br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("nyeri_berat", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Nyeri berat (7/8)<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("nyeri_dada", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Nyeri dada<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("nyeri_abdomen", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Nyeri abdomen<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("nyeri_usia", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Nyeri usia > 65 tahun<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala3)?(in_array("sensasi", $data->disabilitas->disabilitas->skala3) ? "checked" : "disabled"):""; ?>>Sensasi berubah<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala4)?(in_array("gcs", $data->disabilitas->disabilitas->skala4) ? "checked" : "disabled"):""; ?>>GCS 15<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala4)?(in_array("cedera_kepala", $data->disabilitas->disabilitas->skala4) ? "checked" : "disabled"):""; ?>>Cedera kepala<br>tanpa pernah <br>tidak sadar<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala4)?(in_array("nyeri_sedang", $data->disabilitas->disabilitas->skala4) ? "checked" : "disabled"):""; ?>>Nyeri sedang<br>(4/5/6)<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala4)?(in_array("nyeri_perut", $data->disabilitas->disabilitas->skala4) ? "checked" : "disabled"):""; ?>>Nyeri perut<br> tidak khas<br>
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala4)?(in_array("psikiatri", $data->disabilitas->disabilitas->skala4) ? "checked" : "disabled"):""; ?>>Psikiatri ringan dalam observasi
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                
                                <input type="checkbox" <?php echo isset($data->disabilitas->disabilitas->skala5)?(in_array("gcs", $data->disabilitas->disabilitas->skala5) ? "checked" : "disabled"):""; ?>>GCS 15<br>
                            </div>
                    </td>
                    <td style="border: 1px solid black; padding: 8px; font-size:10px;">
                            <div>
                                <p style="text-align:center">Resiko penularan infeksi</p>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->tanda_vital)?(in_array("batuk", $data->disabilitas->disabilitas->tanda_vital) ? "checked" : "disabled"):""; ?>>Batuk lebih <br> dari 2 minggu <br>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->tanda_vital)?(in_array("rujukan", $data->disabilitas->disabilitas->tanda_vital) ? "checked" : "disabled"):""; ?>>Rujukan dengan suspek / konfirmasi<br>airbone disease<br>
                                <input type="checkbox"  <?php echo isset($data->disabilitas->disabilitas->tanda_vital)?(in_array("perjalanan_luar", $data->disabilitas->disabilitas->tanda_vital) ? "checked" : "disabled"):""; ?>>Perjalanan dari luar negri
                            </div>
                    </td>
                </tr>
            </table>
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <table border="1" width="100%" style="border-collapse: collapse;margin-top:20px">

          
                   


            <tr>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;">LAIN-LAIN</td>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;" width="15%"></td>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("gd", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>GD < 36mg/dl/< 2 mmol/l<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("demam", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>Demam dengan letargi<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("asam", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>Asam /Basa pada mata<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("trauma", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>Trauma multiple major<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("trauma_lokal", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>Trauma lokal / major/amputasi<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("riwayat_resiko", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>riwayat resiko tinggi<br>setelah sedaktif<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala2)?(in_array("sengatan", $data->lainnya->lainya->skala2) ? "checked" : "disabled"):""; ?>>sengatan/gigitan binatang<br>berbahaya
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("gd", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>GD > 288mg/dl<br>atau > 16mmol/l<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("immunodepresan", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Immunodepresan + demam<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("muntah", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Muntah persisten<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("dehidrasi", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Dehidrasi<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("cedera", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Cedera sedang/deformitas<br>laserasi berat/crush<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("trauma_sedang", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Trauma sedamh dengan<br>riwayat risiko tinggi <br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("neonatus_stabil", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Neonatus stabil<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("anak_risiko", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Anak dengan risiko<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala3)?(in_array("psikiatri", $data->lainnya->lainya->skala3) ? "checked" : "disabled"):""; ?>>Psikiatri sedang<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <div>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala4)?(in_array("muntah", $data->lainnya->lainya->skala4) ? "checked" : "disabled"):""; ?>>Muntah mencret tanpa dehidrasi<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala4)?(in_array("inflamasi", $data->lainnya->lainya->skala4) ? "checked" : "disabled"):""; ?>>Inflamasi / benda asing mata<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala4)?(in_array("sprain", $data->lainnya->lainya->skala4) ? "checked" : "disabled"):""; ?>>Sprain/faktur/laserasi tanpa nyeri ringan TTV dbn<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala4)?(in_array("cast", $data->lainnya->lainya->skala4) ? "checked" : "disabled"):""; ?>>Cast ketat, neurovaskuler normal<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <div>
                            
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala5)?(in_array("kronis", $data->lainnya->lainya->skala5) ? "checked" : "disabled"):""; ?>>Kronis<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala5)?(in_array("minor", $data->lainnya->lainya->skala5) ? "checked" : "disabled"):""; ?>>Minor<br>
                            <input type="checkbox" <?php echo isset($data->lainnya->lainya->skala5)?(in_array("administratif", $data->lainnya->lainya->skala5) ? "checked" : "disabled"):""; ?>>Administratif<br>
                        </div>
                </td>
                <td style="border: 1px solid black; padding: 8px; font-size:12px;">
                        <div>
                            <p style="text-align:center">Psikologis</p>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("marah", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Marah<br>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("takut", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Takut<br>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("cemas", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Cemas<br>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("depresi", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Depresi<br>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("gelisah", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Gelisah<br>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("tidak_masalah", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Tidak masalah<br>
                            <input type="checkbox"  <?php echo isset($data->lainnya->lainya->tanda_vital)?(in_array("other", $data->lainnya->lainya->tanda_vital) ? "checked" : "disabled"):""; ?>>Lain-lain<br>
                        </div>
                </td>
            
            </tr>
           <tr>
                <td td colspan="7" style="border: 1px solid black; padding: 8px; font-size:12px;">INTERVENSI dan RESPONNYA <br><br> (Tindakan/Medikamentosa)
                </td>
           </tr>
           <tr>
                <td colspan="2"style="border: 1px solid black; padding: 8px; font-size:12px;">JALAN NAFAS</td>
                <td colspan="5" style="border: 1px solid black; padding: 8px; font-size:12px;">:
                    <?= isset($data->intervensi->jalan_nafas1)?$data->intervensi->jalan_nafas1:''?>
                </td>
           </tr>
           <tr>
                <td colspan="2"style="border: 1px solid black; padding: 8px; font-size:12px;">PERNAFASAN</td>
                <td colspan="5" style="border: 1px solid black; padding: 8px; font-size:12px;">:
                <?= isset($data->intervensi->pernafasan1)?$data->intervensi->pernafasan1:''?>
                </td>
           </tr>
           <tr>
                <td colspan="2"style="border: 1px solid black; padding: 8px; font-size:12px;">SIRKULASI</td>
                <td colspan="5" style="border: 1px solid black; padding: 8px; font-size:12px;">:
                <?= isset($data->intervensi->sirkulasi1)?$data->intervensi->sirkulasi1:''?>
                </td>
           </tr>
           <tr>
                <td colspan="2"style="border: 1px solid black; padding: 8px; font-size:12px;">DISABILITAS</td>
                <td colspan="5" style="border: 1px solid black; padding: 8px; font-size:12px;">:
                <?= isset($data->intervensi->disabilitas1)?$data->intervensi->disabilitas1:''?>
                </td>
           </tr>
           <tr>
                <td colspan="2"style="border: 1px solid black; padding: 8px; font-size:12px;">LAIN-LAIN</td>
                <td colspan="5" style="border: 1px solid black; padding: 8px; font-size:12px;">:
                <?= isset($data->intervensi->lainya1)?$data->intervensi->lainya1:''?>
                </td>
           </tr>
           <tr>
                <td colspan="2"style="border: 1px solid black; padding: 8px; font-size:12px;">Diteruskan ke</td>
                <td colspan="5" style="border: 1px solid black; padding: 8px; font-size:12px;">
                    <div>
                            <input type="checkbox" <?php echo isset($data->ditreskan)?(in_array("resusitas", $data->ditreskan) ? "checked" : "disabled"):""; ?>>RESUSITASI
                            <input type="checkbox" <?php echo isset($data->ditreskan)?(in_array("medikal", $data->ditreskan) ? "checked" : "disabled"):""; ?>>MEDIKAL
                            <input type="checkbox" <?php echo isset($data->ditreskan)?(in_array("anak", $data->ditreskan) ? "checked" : "disabled"):""; ?>>Anak
                            <input type="checkbox" <?php echo isset($data->ditreskan)?(in_array("surgikal", $data->ditreskan) ? "checked" : "disabled"):""; ?>>SURGIKAL
                            <input type="checkbox" <?php echo isset($data->ditreskan)?(in_array("obgin", $data->ditreskan) ? "checked" : "disabled"):""; ?>>OBGIN
                            <input type="checkbox" <?php echo isset($data->ditreskan)?(in_array("forensik", $data->ditreskan) ? "checked" : "disabled"):""; ?>>FORENSIK
                        </div>
                </td>
           </tr>
        </table>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p>Serah terima Triase DPJP  Jam :</p>
                <p>Dokter Triase</p>
                <br><br><br>
                <span>(______)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p><br></p>
                <p>Perawat Triase</p>
                <br><br><br>
                <span>(______)</span>
            </div>
            <div style="text-align: center; font-size: 12px; margin: 15px 20px;">
                <p><br></p>
                <p>DPJP</p>
                <br><br><br>
                <span>(_____)</span>
            </div>
        </div>

</div>

</body>

</html>