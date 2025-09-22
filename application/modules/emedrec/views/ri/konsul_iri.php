<?php 
$data = $konsul_dokter_iri?$konsul_dokter_iri:null;
//var_dump($data);
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
    <body class="A4" >
            <?php 
                $jml_array = isset($data)?count($data):'';
                for ($x = 0; $x < $jml_array; $x++) { ?>
    <!-- lembar konsultasi -->
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                Konsultasi IRI
            </p>
            <div style="font-size:5px;">
               <table width="100%" border= 1 cellpadding="3px">
                   <tr>
                       <td width="30%" rowspan="2"><p>Nama :<br><br> <?= isset($data[$x]->nama)?$data[$x]->nama:''?></p></td>
                       <td width="30%" rowspan="2"><p>Tgl Lahir : <br><br><?= isset($data[$x]->tgl_lahir)?date('d-m-Y',strtotime($data[$x]->tgl_lahir)):'' ?></p></td>
                       <td width="40%" colspan="3" style="text-align:center;">No Rekam Medis</td>
                   </tr>
                   <tr>
                       <td class="text-center"><?= isset($data[$x]->no_cm)?substr($data[$x]->no_cm,0,2):''?></td>
                       <td class="text-center"><?= isset($data[$x]->no_cm)?substr($data[$x]->no_cm,2,2):''?></td>
                       <td class="text-center"><?= isset($data[$x]->no_cm)?substr($data[$x]->no_cm,4):''?></td>
                   </tr>
                   <tr>
                  <tr>
                      <td colspan="2">
                          <p>Konsultasi Kepada : <?= isset($data[$x]->nama_dokter_penerima)?$data[$x]->nama_dokter_penerima:'' ?></p>
                          <p>Departemen / Unit : <?= isset($data[$x]->nm_poli)?$data[$x]->nm_poli:'' ?></p>
                      </td>
                      <td colspan="3">
                          <p>Dari : <?= isset($data[$x]->nmruang)?$data[$x]->nmruang:'' ?></p>
                          <p>dr  : <?= isset($data[$x]->nm_dokter_pengirim)?$data[$x]->nm_dokter_pengirim:'' ?></p>
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
                                <p ><?= isset($data[$x]->kemungkinan)?$data[$x]->kemungkinan:''?></p>
                            </div>

                         <div style="min-height:20px">
                             1. Dibagian
                             <span></span>
                             Pasien ini diobati untuk : <u><?= isset($data[$x]->diobati_untuk)?$data[$x]->diobati_untuk:'' ?></u>
                        </div>

                        <div style="min-height:20px">
                            <p>
                                Telah ditentukan kelainan-kelainan dari keadaan pasien berikut ini :
                            </p>
                            <!-- isian kelainan -->
                            <p style="margin-left:25px"><?= isset($data[$x]->kelainan)?$data[$x]->kelainan:'' ?></p>
                        </div>

                         
                        <div style="min-height:30px">
                            <p>2. Pengobatan yang telah dilakukan</p>
                                <!-- isian pengobatan -->
                            <p style="margin-left:25px"><?= isset($data[$x]->pengobatan)?$data[$x]->pengobatan:'' ?></p>
                        </div>
                        

                        <div style="min-height:30px">
                            <p>3. Mohon perhatian khusus terhadap</p>
                            <!-- isian perhatian khusus -->
                            <p style="margin-left:25px"><?= isset($data[$x]->perhatian_khusus)?$data[$x]->perhatian_khusus:'' ?></p>
                        </div>
                        

                        <div style="min-height:30px">
                        <p style="margin-left:25px">dan nasehat <?= isset($data[$x]->nasehat)?' '.$data[$x]->nasehat:'' ?></p>
                        <!-- isian nasehat -->
                    </div>
                        

                        <table>
                            <tr>
                                <td>Sudilah sejawat untuk  :</td>
                                <td>  ⁻     Alih Rawat</td>
                                <td><input  style="margin-left:30px" type="checkbox" name="" id="" <?php echo isset($data[$x]->permintaan_dokter_asal)?$data[$x]->permintaan_dokter_asal == 'alih_rawat'?'checked':'disabled':'disabled'  ?>></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>⁻     Rawat Bersama   </td>
                                <td ><input type="checkbox" style="margin-left:30px" name="" id="" <?php echo isset($data[$x]->permintaan_dokter_asal)?$data[$x]->permintaan_dokter_asal == 'rawat_bersama'?'checked':'disabled':'disabled'  ?>></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>-      Konsultasi  1 X </td>
                                <td><input type="checkbox"  style="margin-left:30px" name="" id="" <?php echo isset($data[$x]->permintaan_dokter_asal)?$data[$x]->permintaan_dokter_asal == 'konsultasi'?'checked':'disabled':'disabled'  ?>></td>
                            </tr>
                        </table>

                        <p>Atas bantuannya, diucapkan terima kasih.</p><br>
                       

                        <table>
                            <tr>
                                <td width="60%">
                                <p>
                                    <p>Tanggal       : <?= isset($data[$x]->tgl_konsultasi)?date('d-m-Y',strtotime($data[$x]->tgl_konsultasi)):'' ?></p>
                                    <p>Jam    : <?= isset($data[$x]->tgl_konsultasi)?date('H:i:s',strtotime($data[$x]->tgl_konsultasi)):'' ?></p>
                                </p>
                                </td>
                                <td>
                                    <p>Dokter yang mengirim</p>
                                    <img  src="<?= $data[$x]->ttd_pengirim; ?>" width="120px" height="100px" alt="">
                                    <p>Nama   : <?= isset($data[$x]->nm_dokter_pengirim)?$data[$x]->nm_dokter_pengirim:'' ?></p>
                                    <p><?= isset($data[$x]->nipeg_pengirim)?$data[$x]->nipeg_pengirim:'' ?></p>
                                </td>
                            </tr>
                        </table>


            
                        
                        
                      </td>
                  </tr>
               </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>


    <!-- jawaban konsultasi -->
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                JAWABAN / LAPORAN KONSULTASI
                </p>
                <div style="font-size:12px">
                    <p>Teman Sejawat Yth.</p>
                    <p style="margin-left:30px">Pada pemeriksaan yang telah kami lakukan terhadap pasien</p>

                    <p>
                        <p>Nama : <?= isset($data[$x]->nama)?$data[$x]->nama:'' ?></p>
                        <span>Umur : <?= isset($data[$x]->umur)?$data[$x]->umur:'' ?></span>
                    </p>

                    <p>
                        <span>Yang dikirim oleh teman sejawat pada tanggal<b><?= isset($data[$x]->tgl_konsultasi)?' '.date('d-m-Y',strtotime($data[$x]->tgl_konsultasi)):'' ?></b></span>
                        <span>Terdapat hal-hal Sebagai berikut :</span>
                    </p>
                    
                    <div style="min-height:60px">
                        <p>1. 
                            <span><?= isset($data[$x]->hal_yang_ditemukan)?str_replace('plus','Plus(+)',str_replace('minus','Minus(-)',$data[$x]->hal_yang_ditemukan)):'' ?></span>
                        </p>
                    </div>

                    <div style="min-height:60px">
                        <p>2. Kesan</p>
                        <p><?= isset($data[$x]->kesan)?$data[$x]->kesan:'' ?></p>
                    </div>

                    <div style="min-height:60px">
                        <p>3. Anjuran</p>
                        <p><?= isset($data[$x]->anjuran)?$data[$x]->anjuran:'' ?></p>
                    </div>

                    <p>4a.Mohon agar pasien  dikirim  kepada kami  untuk periksa kembali pada tanggal  : <b><?= isset($data[$x]->pengajuan_konsul_kembali)?' '.date('d-m-Y',strtotime($data[$x]->pengajuan_konsul_kembali)):'' ?></b></p>
                    <p></p>

                    <p>4b.Untuk pengobatan selanjutnya pasien dipindahkan ke Unit perawatan</p>
                    <p>
                        <span style="margin-left:25px">dibagian kami :</span>

                        <span style="margin-left:50px">
                            <span>Ya</span>
                            <input type="checkbox" name="" id="" <?php echo isset($data[$x]->pemindahan_pengobatan)?$data[$x]->pemindahan_pengobatan == '1'?'checked':'disabled':'disabled'  ?>>
                        </span>

                        <span style="margin-left:50px">
                            <span>Tidak</span>
                            <input type="checkbox" name="" id="" <?php echo isset($data[$x]->pemindahan_pengobatan)?$data[$x]->pemindahan_pengobatan != '1'?'checked':'disabled':'disabled'  ?>>
                        </span>

                    </p>

                    <p>Sekian agar teman sejawat maklum.</p><br>
        
                

                    <table>
                        <tr>
                            <td style="min-width:60%">
                            
                                <p>Tanggal       : <?= isset($data[$x]->tgl_jawaban)?' '.date('d-m-Y',strtotime($data[$x]->tgl_jawaban)):'' ?></p>
                                <p>Jam    : <?= isset($data[$x]->tgl_jawaban)?' '.date('H:i:s',strtotime($data[$x]->tgl_jawaban)):'' ?></p>
                        
                            </td>
                            <td  width="40%">
                                <p>Dokter Konsulen</p>
                                <img  src="<?= $data[$x]->ttd_penerima; ?>" width="120px" height="100px" alt="">
                                <p>Nama : <?= isset($data[$x]->nama_dokter_penerima)?$data[$x]->nama_dokter_penerima:'' ?></p>
                                <p><?= isset($data[$x]->nipeg_penerima)?$data[$x]->nipeg_penerima:'' ?></p>
                            </td>
                        </tr>
                    </table>
        
                    
                </div>
                <br><br> <br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
        <?php } ?>





    </body>
</html>