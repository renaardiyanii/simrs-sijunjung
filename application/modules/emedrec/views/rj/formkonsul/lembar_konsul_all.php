<?php 
// $data = $konsul_dokter_iri?$konsul_dokter_iri:null;
$konsul = $data_konsul;
$json = isset($data_rehab_medik->jawaban_konsul_rehab)?json_decode($data_rehab_medik->jawaban_konsul_rehab):'';
//var_dump($data_rehab_medik->jawaban_konsul_rehab); die();
?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <style>
         .data {
            border-collapse: collapse;
            border: 1px solid black;    
            width: 80%;
            font-size: 14px;
            position: relative;
        }
        .text-center{
            text-align:center;
        }
    </style>
    <?php foreach($konsul as $data) { ?>
    <body class="A4" >
    <!-- lembar konsultasi -->
        <div class="A4 sheet  padding-fix-10mm">
            <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                                </font>
                                <font style="font-size:8pt">
                                    <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                    <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                                </font>    
                                <br>
                                <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                                <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
               LEMBAR KONSULTASI (ANTAR BAGIAN)
            </p>
            <div style="font-size:11px;">
               <table width="100%" border= 1 cellpadding="6px">
                   <tr>
                       <td width="30%" rowspan="2"><p>Nama : <?= isset($data->nama_pasien)?$data->nama_pasien:''?></p></td>
                       <td width="30%" rowspan="2"><p>Tgl Lahir : <?= isset($data->tgl_lahir)?date('d-m-Y',strtotime($data->tgl_lahir)):'' ?></p></td>
                       <td width="40%" colspan="3" style="text-align:center;">No Rekam Medis</td>
                   </tr>
                   <tr>
                       <td class="text-center"><?= isset($data->no_medrec)?substr($data->no_medrec,0,2):''?></td>
                       <td class="text-center"><?= isset($data->no_medrec)?substr($data->no_medrec,2,2):''?></td>
                       <td class="text-center"><?= isset($data->no_medrec)?substr($data->no_medrec,4):''?></td>
                   </tr>
                   <tr>
                  <tr>
                      <td colspan="2">
                          <p>Konsultasi Kepada : <?= isset($data->dokter_penerima)?$data->dokter_penerima:'' ?></p>
                          <p>Departemen / Unit : <?= isset($data->nama_poli_akhir)?$data->nama_poli_akhir:'' ?></p>
                      </td>
                      <td colspan="3">
                          <p>Dari : <?= isset($data->nama_poli_asal)?$data->nama_poli_asal:'' ?></p>
                          <p>dr  : <?= isset($data->dokter_pengirim)?$data->dokter_pengirim:'' ?></p>
                    </td>
                  </tr>
                  <tr>
                      <td colspan="5">
                          <p>PERMINTAAN KONSULTASI</p>

                            <div style="min-height:100px">

                                <p><b>Teman Sejawat Yth,</b></p>
                                <span style="margin-left:30px">Sudilah kiranya memeriksa dan mengobati pasien (nama tersebut diatas)</span><br>
                                <span>dengan kemungkinan / sangkaan</span>
                                <!-- isian sangkaan -->
                                <p ><?= isset($data->kemungkinan_sangkaan)?$data->kemungkinan_sangkaan:''?></p>
                            </div>

                         <div style="min-height:60px">
                             1. Dibagian
                             <span></span>
                             Pasien ini diobati untuk
                             <p style="margin-left:25px"><?= isset($data->bagian)?$data->bagian:'' ?></p>
                        </div>

                        <div style="min-height:60px">
                            <p>
                                Telah ditentukan kelainan-kelainan dari keadaan pasien berikut ini :
                            </p>
                            <!-- isian kelainan -->
                            <p style="margin-left:25px"><?= isset($data->kelainan)?$data->kelainan:'' ?></p>
                        </div>

                         
                        <div style="min-height:60px">
                            <p>2. Pengobatan yang telah dilakukan</p>
                                <!-- isian pengobatan -->
                            <p style="margin-left:25px"><?= isset($data->pengobatan_untuk)?$data->pengobatan_untuk:'' ?></p>
                        </div>
                        

                        <div style="min-height:60px">
                            <p>3. Mohon perhatian khusus terhadap</p>
                            <!-- isian perhatian khusus -->
                            <p style="margin-left:25px"><?= isset($data->perhatian_khusus)?$data->perhatian_khusus:'' ?></p>
                        </div>
                        

                        <div style="min-height:60px">
                        <p style="margin-left:25px">dan nasehat <?= isset($data->nasehat)?' '.$data->nasehat:'' ?></p>
                        <!-- isian nasehat -->
                    </div>
                        

                        <table>
                            <tr>
                                <td>Sudilah sejawat untuk  :</td>
                                <td>  ⁻     Alih Rawat</td>
                                <td><input  style="margin-left:30px" type="checkbox" name="" id="" <?php echo isset($data->opsi_konsul)?$data->opsi_konsul == 'alih_rawat'?'checked':'disabled':'disabled'  ?>></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>⁻     Rawat Bersama   </td>
                                <td ><input type="checkbox" style="margin-left:30px" name="" id="" <?php echo isset($data->opsi_konsul)?$data->opsi_konsul == 'rawat_bersama'?'checked':'disabled':'disabled'  ?>></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>-      Konsultasi  1 X </td>
                                <td><input type="checkbox"  style="margin-left:30px" name="" id="" <?php echo isset($data->opsi_konsul)?$data->opsi_konsul == 'konsultasi'?'checked':'disabled':'disabled'  ?>></td>
                            </tr>
                        </table>

                        <p>Atas bantuannya, diucapkan terima kasih.</p><br>
                        <p>
                            <span>Tanggal       : <?= isset($data->tanggal_konsul)?date('d-m-Y',strtotime($data->tanggal_konsul)):'' ?></span>
                            <span style="margin-left:200px">Jam    : <?= isset($data->tgl_konsultasi)?date('H:i:s',strtotime($data->tgl_konsultasi)):'' ?></span>
                        </p><br>
            
                        <p>Dokter yang mengirim</p>
                        <p>Nama   : <?= isset($data->dokter_pengirim)?$data->dokter_pengirim:'' ?></p>
                        <p>Nip    &nbsp;: <?= isset($data->nipeg_pengirim)?$data->nipeg_pengirim:'' ?></p>
                        
                      </td>
                  </tr>
               </table>
            </div>
        </div>


    <!-- jawaban konsultasi -->
    <div class="A4 sheet  padding-fix-10mm">
            <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                                </font>
                                <font style="font-size:8pt">
                                    <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                    <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                                </font>    
                                <br>
                                <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                                <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
               JAWABAN / LAPORAN KONSULTASI
            </p>
            <div style="font-size:12px">
                <p>Teman Sejawat Yth.</p>
                <p style="margin-left:30px">Pada pemeriksaan yang telah kami lakukan terhadap pasien</p>

                <p>
                    <p>Nama : <?= isset($data->nama_pasien)?$data->nama_pasien:'' ?></p>
                    <span>Umur : <?= isset($data->umur)?$data->umur:'' ?></span>
                </p>

                <p>
                    <span>Yang dikirim oleh teman sejawat pada tanggal<b><?= isset($data->tanggal_konsul)?' '.date('d-m-Y',strtotime($data->tanggal_konsul)):'' ?></b></span>
                    <span>Terdapat hal-hal Sebagai berikut :</span>
                </p>
                
                <div style="min-height:30px">
                    <p>1. 
                        <?php if($data->id_poli_akhir == 'BK00') { ?>
                            <span><?= isset($json->subjective)?$json->subjective:'' ?></span>
                        <?php } else { ?>
                            <span><?= isset($data->detail_penyakit_jawaban)?$data->detail_penyakit_jawaban:'' ?></span>
                        <?php } ?>
                    </p>
                </div>

                <div style="min-height:60px">
                    <p>2. Kesan</p>
                    <p>
                        <?php if($data->id_poli_akhir == 'BK00') { ?>
                            <?= isset($json->assesment)?$json->assesment:'' ?>
                        <?php } else { ?>
                            <?= isset($data->kesan_jawaban)?$data->kesan_jawaban:'' ?>
                        <?php } ?> 
                    </p>
                </div>

                <div style="min-height:60px">
                    <p>3. Anjuran</p>
                    <p>
                        <?php if($data->id_poli_akhir == 'BK00') { ?>
                            <?= isset($json->planning)?$json->planning:'' ?>
                        <?php } else { ?>
                            <?= isset($data->anjuran_jawaban)?$data->anjuran_jawaban:'' ?>
                        <?php } ?>
                    </p>
                </div>

                <p>4a.Mohon agar pasien  dikirim  kepada kami  untuk periksa kembali pada tanggal  : <b><?= isset($data->pengajuan_kembali_jawaban)?' '.date('d-m-Y',strtotime($data->pengajuan_kembali_jawaban)):'' ?></b></p>
                <p></p>

                <p>4b.Untuk pengobatan selanjutnya pasien dipindahkan ke Unit perawatan</p>
                <p>
                    <span style="margin-left:25px">dibagian kami :</span>

                    <span style="margin-left:50px">
                        <span>Ya</span>
                        <input type="checkbox" name="" id="" <?php echo isset($data->pemindahan_pengobatan_jawaban)?$data->pemindahan_pengobatan_jawaban == '1'?'checked':'disabled':'disabled'  ?>>
                    </span>

                    <span style="margin-left:50px">
                        <span>Tidak</span>
                        <input type="checkbox" name="" id="" <?php echo isset($data->pemindahan_pengobatan_jawaban)?$data->pemindahan_pengobatan_jawaban != '1'?'checked':'disabled':'disabled'  ?>>
                    </span>

                </p><br>

                <p>Sekian agar teman sejawat maklum.</p><br>
    
                <p>
                    <span>Tanggal       : <?= isset($data->tgl_jawaban)?' '.date('d-m-Y',strtotime($data->tgl_jawaban)):'' ?></span>
                    <span style="margin-left:200px">Jam    : <?= isset($data->tgl_jawaban)?' '.date('H:i:s',strtotime($data->tgl_jawaban)):'' ?></span>
                </p><br>
    
                <p>Dokter Konsulen</p>
                <p>Nama : <?= isset($data->dokter_penerima)?$data->dokter_penerima:'' ?></p>
                <p>Nip &nbsp;: <?= isset($data->nipeg_penerima)?$data->nipeg_penerima:'' ?></p>
            </div>
    </div>






    </body>
    <?php } ?>
</html>