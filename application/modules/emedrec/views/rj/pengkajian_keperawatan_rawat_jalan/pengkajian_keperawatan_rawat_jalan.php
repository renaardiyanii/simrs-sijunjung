<?php 

$data = isset($assesment_keperawatan->formjson)?json_decode($assesment_keperawatan->formjson):'';
// var_dump($data->stat_psikologi);

?>

<style>
    table tr td {

        font-size: 12px;
        font-family: arial;

    }

    table tr th {

        font-size: 12px;
        font-family: arial;
        

    }
</style>
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

            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 1 dari 2</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%"><p>Tanggal : <?= isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'' ?></p></td>
                                <td><p>Jam : <?= isset($data->tgl)?date('h:i',strtotime($data->tgl)):'' ?></p></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                            <tr>
                                <td width="20%">
                                    <p>Unit</p>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("penyakit_dalam", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Penyakit Dalam</label><br>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("mata", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Mata</label>
                                </td>
                                <td width="15%">
                                    <p><br></p>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("bedah", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Bedah</label><br>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("gigi", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Gigi</label>
                                </td>
                                <td width="20%">
                                    <p><br></p>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("akupuntur", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Akupuntur</label><br>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("umum", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Umum</label>
                                </td>
                                <td width="15%">
                                    <p><br></p>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("jiwa", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Jiwa</label><br>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("paru", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Paru</label>
                                </td>
                                <td width="20%">
                                    <p><br></p>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("tht", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">THT</label><br>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("other", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Lain-lain : <?= isset($data->{'question1-Comment'})?$data->{'question1-Comment'}:'' ?></label>
                                </td>
                                <td width="20%">
                                    <p><br></p>
                                    <input type="checkbox" value=""<?php echo isset($data->question1)?(in_array("syaraf", $data->question1) ? "checked" : "disabled"):""; ?>>
                                    <label for="sendiri">Syaraf</label>
                                    
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h4>ASESMEN KEPERAWATAN</h4>
                        <table border="1" width="100%" cellpadding="3px">
                            <tr>
                                <th width="25%">TANDA VITAL</th>
                                <th width="25%">NUTRISI</th>
                                <th width="25%">FUNGSIONAL</th>
                                <th width="25%">RIWAYAT ALERGI</th>
                            </tr>

                            <tr>
                                <td>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="60%">Tekanan Darah</td>
                                            <td width="30%"><?= isset($data->tanda_vital->td)?$data->tanda_vital->td:'' ?></td>
                                            <td>mmHg</td>
                                        </tr>

                                        <tr>
                                            <td>Nadi</td>
                                            <td><?= isset($data->tanda_vital->nadi)?$data->tanda_vital->nadi:'' ?></td>
                                            <td>x/menit</td>
                                        </tr>

                                        <tr>
                                            <td>Suhu</td>
                                            <td><?= isset($data->tanda_vital->suhu)?$data->tanda_vital->suhu:'' ?></td>
                                            <td>°C</td>
                                        </tr>

                                        <tr>
                                            <td>Pernafasan</td>
                                            <td><?= isset($data->tanda_vital->pernafasan)?$data->tanda_vital->pernafasan:'' ?></td>
                                            <td>x/menit</td>
                                        </tr>

                                    </table>
                                </td>
                                <td>
                                    <table border="0" width="100%" cellpadding="5px">
                                        <tr>
                                            <td width="60%">Berat Badan</td>
                                            <td width="30%"><?= isset($data->nutrisi->berat_badan)?$data->nutrisi->berat_badan:'' ?></td>
                                            <td>Kg</td>
                                        </tr>

                                        <tr>
                                            <td>Tinggi Badan</td>
                                            <td><?= isset($data->nutrisi->tinggi_badan)?$data->nutrisi->tinggi_badan:'' ?></td>
                                            <td>cm</td>
                                        </tr>

                                        <tr>
                                            <td>IMT</td>
                                            <td><?= isset($data->nutrisi->imt)?$data->nutrisi->imt:'' ?></td>
                                            <td>Kg/m2</td>
                                        </tr>

                                    </table>
                                </td>
                                <td>
                                    <p>1. Alat Bantu : <?= isset($data->question2->item1->alat_bantu)?$data->question2->item1->alat_bantu:'' ?></p>
                                    <p>2. Prothesis : <?= isset($data->question2->item1->prothesis)?$data->question2->item1->prothesis:'' ?></p>
                                    <p>3. Cacat Tubuh : <?= isset($data->question2->item1->cacat)?$data->question2->item1->cacat:'' ?></p>
                                    <p>4. IADL : <br><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" style="margin-left:15px" value=""<?php echo isset($data->question2->item1->adl)?($data->question2->item1->adl == "mandiri" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Mandiri</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" style="margin-left:15px" value=""<?php echo isset($data->question2->item1->adl)?($data->question2->item1->adl == "dibantu" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Dibantu</label>

                                    </p>

                                    <p>5. Riwayat jatuh dalam 3 bulan terakhir : <br><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" style="margin-left:15px" value=""<?php echo isset($data->question2->item1->riwayat)?($data->question2->item1->riwayat == "ya" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Ya</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" style="margin-left:15px" value=""<?php echo isset($data->question2->item1->riwayat)?($data->question2->item1->riwayat == "tidak" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Tidak</label>

                                    </p>
                                </td>
                                <td>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question3->item1->riwayat)?($data->question3->item1->riwayat == "tidak" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Tidak</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question3->item1->riwayat)?($data->question3->item1->riwayat == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Ya</label>
                                    <p>Kalau Ya :</p>
                                        <span><?= isset($data->question3->item1->{'riwayat-Comment'})?$data->question3->item1->{'riwayat-Comment'}:'' ?></span>
                                </td>

                            </tr>

                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h4>RIWAYAT PSIKOSOSIAL,SPIRITUAL DAN EKONOMI</h4>
                        <table border="1" width="100%" cellpadding="5px">
                            <tr>
                                <th width="30%">Status Psikologi</th>
                                <th width="40%">Status Mental</th>
                                <th width="30%">Status Sosial</th>
                            </tr>

                            <tr>
                                <td>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "cemas" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Cemas</label>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "takut" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Takut</label>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "sedih" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Sedih</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "bunuh_diri" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Kecenderungan Bunuh diri</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_psikologi)?($data->stat_psikologi == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Lainnya, sebutkan <?= isset($data->{'stat_psikologi-Comment'})?$data->{'stat_psikologi-Comment'}:'' ?></label>
                                </td>
                                <td>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->status_mental)?($data->status_mental == "sadar" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Sadar dan Orientasi Baik</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->status_mental)?($data->status_mental == "kekerasan" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Ada masalah perilaku, sebutkan</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->status_mental)?($data->status_mental == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Perilaku kekerasan yang dialami pasien sebelumnya <?= isset($data->{'status_mental-Comment'})?$data->{'status_mental-Comment'}:'' ?> </label><br>
                                   
                                </td>
                                <td>
                                    <p>Hubungan pasien dengan anggota keluarga :<br>
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->sta_sosial)?($data->sta_sosial == "baik" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Baik</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->sta_sosial)?($data->sta_sosial == "tidak" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Tidak Baik</label><br>
                                    </p>

                                    <p>Tampat Tinggal :<br>
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->tempat)?($data->tempat == "rumah" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">rumah</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->tempat)?($data->tempat == "apartemen" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Apartemen</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->tempat)?($data->tempat == "panti" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Panti</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->tempat)?($data->tempat == "other" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">lainnya, <?= isset($data->{'tempat-Comment'})?$data->{'tempat-Comment'}:'' ?></label><br>
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <table border="1" width="100%" cellpadding="5px">
                            <tr>
                                <th width="60%">Status Spiritual</th>
                                <th>Status Ekonomi</th>
                            </tr>

                            <tr>
                                <td>
                                    <p>1. Kegiatan keagamaan yang biasa dilakukan :</p>
                                    <p style="margin-left:10px"><?= isset($data->keagamaan)?$data->keagamaan:'' ?></p>

                                    <p>2. Kegiatan spiritual yang dibutuhkan selama perawatan :</p>
                                    <p style="margin-left:10px"><?= isset($data->spiritual)?$data->spiritual:'' ?></p>
                                </td>
                                <td>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_ekonomi)?($data->stat_ekonomi == "dinas" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Dinas</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_ekonomi)?($data->stat_ekonomi == "perusahaan" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Perusahaan</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_ekonomi)?($data->stat_ekonomi == "asuransi" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Asuransi</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_ekonomi)?($data->stat_ekonomi == "jaminan" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Jaminan</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_ekonomi)?($data->stat_ekonomi == "biaya_sendiri" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Biaya Sendiri</label><br>
                                    <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->stat_ekonomi)?($data->stat_ekonomi == "other" ? "checked" : "disabled"):'';?>>
                                    <label for="sendiri">Lainnya , <?= isset($data->{'stat_ekonomi-Comment'})?$data->{'stat_ekonomi-Comment'}:'' ?></label><br>

                                </td>
                            </tr>
                        </table><br><br><br>
                    </td>
                </tr>


            </table>


            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
                beri tanda (v)pada ▯ sesuai pilihan
            </p><br><br><br>
             
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.02.b/RJ-GN </p>
                </div>     
            </div> 
            
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
                <tr>
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Perawat)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 2 dari 2</p>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <h4>KEBUTUHAN KOMUNIKASI DAN EDUKASI</h4>
                        <p>Terdapat hambatan dalam pembelajaran :</p>
                            <table border="0" width="100%" cellpadding="3px">
                                <tr>
                                    <td width="15%">
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->hambatan)?($data->hambatan == "tidak" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Tidak</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("budaya", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Budaya</label>
                                    </td>

                                    <td width="15%">
                                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->hambatan)?($data->hambatan == "ya" ? "checked" : "disabled"):'';?>>
                                        <label for="sendiri">Ya,Jika Ya :</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("emosi", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Emosi</label>
                                    </td>

                                    <td width="15%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("pendengaran", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Pendengaran</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("bahasa", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Bahasa</label>
                                    </td>

                                    <td width="15%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("penglihatan", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Penglihatan</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("other", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Lainnya <?= isset($data->{'detail-Comment'})?$data->{'detail-Comment'}:'' ?></label>
                                    </td>

                                    <td width="15%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("kognitif", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Kognitif</label>
                                        
                                    </td>

                                    <td width="15%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->detail)?(in_array("fisik", $data->detail) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Fisik</label>
                                        
                                    </td>
                                </tr>
                            </table>
                        <p>Dibutuhkan penerjemah :
                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->penerjemah)?($data->penerjemah == "tidak" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Tidak</label>

                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->penerjemah)?($data->penerjemah == "other" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Ya, Sebutkan <?= isset($data->{'penerjemah-Comment'})?$data->{'penerjemah-Comment'}:'' ?></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Bahasa Isyarat : 
                                <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->b_isyarat)?($data->b_isyarat == "tidak" ? "checked" : "disabled"):'';?>>
                                <label for="sendiri">Tidak</label>

                                <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->b_isyarat)?($data->b_isyarat == "ya" ? "checked" : "disabled"):'';?>>
                                <label for="sendiri">Ya</label>

                        </p>
                        <p>Kebutuhan edukasi (pilih topik edukasi pada kotak yang tersedia) :</p>
                            <table border="0" width="100%" cellpadding="3px">
                                <tr>
                                    <td width="40%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("diagnosis", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Diagnosa dan manajemen penyakit</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("tindakan", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Tindakan keperawatan</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("other", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Lain-lain, sebutkan <?= isset($data->{'edukasi-Comment'})?$data->{'edukasi-Comment'}:'' ?></label>
                                    </td>

                                    <td width="30%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("obat", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Obat-obatan / Terapi</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("rehabilitasi", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Rehabilitasi</label>
                                    </td>

                                    <td width="30%">
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("diet", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Diet dan Nutrisi</label><br>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->edukasi)?(in_array("nyeri", $data->edukasi) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Manajemen Nyeri</label>
                                    </td>

                                   
                                </tr>
                            </table>

                        <h4>STATUS FUNGSIONAL</h4>
                        <p>
                            Aktivitas dan Mobilisasi : 
                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->mobilitas)?($data->mobilitas == "mandiri" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Mandiri</label>

                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->mobilitas)?($data->mobilitas == "other" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Perlu bantuan, sebutkan <?= isset($data->{'mobilitas-Comment'})?$data->{'mobilitas-Comment'}:'' ?></label>

                        </p>
                        <p>Alat bantu jalan, sebutkan <?= isset($data->bantu_jalan)?$data->bantu_jalan:'' ?></p>


                        <h4>RISIKO CEDERA/JATUH (isi formulir monitoring pencegahan jatuh)</h4>
                        <p>
                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question7)?($data->question7 == "ya" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Tidak</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question7)?($data->question7 == "tidak" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Ya, Jika Ya, Gelang resiko jatuh warna kuning harus dipasang</label>
                        </p>

                        <h4>SKALA NYERI</h4>
                        <p> Nyeri :
                        <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->nyeri)?($data->nyeri == "tidak" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Tidak</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->nyeri)?($data->nyeri == "ya" ? "checked" : "disabled"):'';?>>
                            <label for="sendiri">Ya, Jika Ya, Gelang resiko jatuh warna kuning harus dipasang</label>

                        </p>

                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="40%">
                                    <table border="1" width="100%" cellpadding="5px">
                                        <tr>
                                            <td> <img src="<?= base_url("assets/images/nyeri_sjj.png"); ?>" alt="img" height="100px" width="250px"></td>
                                        </tr>
                                    </table>
                                   
                                </td>
                                <td width="50%">
                                    <table border="1" width="100%" cellpadding="5px">
                                        <tr>
                                            <td height="100px">
                                                <table  border="0" width="100%" cellpadding="5px">
                                                    <tr>
                                                        <td width="20%">1 - 3 </td>
                                                        <td width="2%">:</td>
                                                        <td>Nyeri ringan, analgetik oral</td>
                                                    </tr>

                                                    <tr>
                                                        <td>4 - 7 </td>
                                                        <td>:</td>
                                                        <td>Nyeri sedang, perlu anal getik injeksi</td>
                                                    </tr>

                                                    <tr>
                                                        <td>8 - 10 </td>
                                                        <td>:</td>
                                                        <td>Nyeri berat, konsul Tim Nyeri</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="25%">
                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri2)?(in_array("kronis", $data->nyeri2) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Nyeri Kronis,</label>
                                    </p>

                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri2)?(in_array("akut", $data->nyeri2) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Nyeri Akut,</label>
                                    </p>

                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri2)?(in_array("score", $data->nyeri2) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Score Nyeri(0-10): <?= isset($data->rate)?$data->rate:'' ?></label>
                                    </p>
                                </td>
                                <td width="25%">
                                    <p>Lokasi : <?= isset($data->lokasi2->lokasi)?$data->lokasi2->lokasi:'' ?><p>
                                    <p>Lokasi : <?= isset($data->lokasi1->lokasi)?$data->lokasi1->lokasi:'' ?><p>
                                    
                                </td>
                                <td width="25%">
                                    <p>Frekuensi : <?= isset($data->lokasi2->frekuensi)?$data->lokasi2->frekuensi:'' ?><p>
                                    <p>Frekuensi : <?= isset($data->lokasi1->frekuensi)?$data->lokasi1->frekuensi:'' ?><p>
                                </td>
                                <td width="25%">
                                    <p>Durasi : <?= isset($data->lokasi2->durasi)?$data->lokasi2->durasi:'' ?><p>
                                    <p>Durasi : <?= isset($data->lokasi1->durasi)?$data->lokasi1->durasi:'' ?><p>
                                </td>
                            </tr>
                        </table>

                        <table border="0" width="100%" cellpadding="5px">
                            <tr>
                                <td width="15%">
                                    <p>Nyeri Hilang :<p>
                                </td>
                                <td>
                                    <p>
                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri_hilang)?(in_array("minum_obat", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Minum Obat</label>

                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri_hilang)?(in_array("istirahat", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Istirahat</label>

                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri_hilang)?(in_array("mendengar_musik", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Mendengar Musik</label>

                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri_hilang)?(in_array("posisi_tidur", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Berubah Posisi Tidur</label><br>

                                        <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->nyeri_hilang)?(in_array("other", $data->nyeri_hilang) ? "checked" : "disabled"):""; ?>>
                                        <label for="sendiri">Lain-lain, sebutkan <?= isset($data->{'nyeri_hilang-Comment'})?$data->{'nyeri_hilang-Comment'}:'' ?></label>
                                    </p>
                                </td>
                               
                                
                            </tr>
                        </table>

                        <h4>DAFTAR MASALAH KEPERAWATAN PRIORITAS</h4>
                        <table border="1" width="100%" cellpadding="5px">
                            <tr>
                                <th width="10%">NO</th>
                                <th width="45%">MASALAH KEPERAWATAN</th>
                                <th width="45%">TUJUAN TERUKUR</th>
                            </tr>

                            <?php 
                                $jml_array = isset($data->question6)?count($data->question6):'';
                                for ($x = 0 , $y = 1; $x < $jml_array; $x++) {
                                  
                            ?>
                                <tr>
                                    <td><?= $y++  ?></td>
                                    <td><?php echo isset($data->question6[$x]->masalah_keperawatan)? $data->question6[$x]->masalah_keperawatan:'' ?></td>
                                    <td><?php echo isset($data->question6[$x]->tujuan)? $data->question6[$x]->tujuan:'' ?></td> 
                                </tr>
                                
                            
                                
                            <?php } ?>
                        </table>
                        <p>
                            <input type="checkbox" name="sendiri" id="sendiri" <?php echo isset($data->disusun)?(in_array("disusun", $data->disusun) ? "checked" : "disabled"):""; ?>>
                            <label for="sendiri"><b>Disusun Rencana Keperawatan</b></label>
                        </p>

                        <div style="display: inline; position: relative;">
                            <div style="float: left;margin-top: 15px;">
                                <p>Tanggal <?= isset($assesment_keperawatan->tgl_input)?date('d-m-Y',strtotime($assesment_keperawatan->tgl_input)):'' ?> Jam <?= isset($assesment_keperawatan->tgl_input)?date('h:i',strtotime($assesment_keperawatan->tgl_input)):'' ?></p>
                                <p>Perawat Yang Melakukan Pengkajian</p>
                                    <img src="<?= $data->ttd ?>" alt="img" height="50px" width="50px"><br>
                                <?php 
                                    $id =isset($assesment_keperawatan->id_pemeriksa)?$assesment_keperawatan->id_pemeriksa:null;                                    
                                    $query1 = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                                    ?>
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br>  
                                        
                            </div>
                            <div style="float: right;margin-top: 15px;">
                            <p>Tanggal <?= isset($assesment_keperawatan->tgl_input)?date('d-m-Y',strtotime($assesment_keperawatan->tgl_input)):'' ?> Jam <?= isset($assesment_keperawatan->tgl_input2)?date('h:i',strtotime($assesment_keperawatan->tgl_input2)):'' ?></p>
                                    <p>Perawat Yang Melengkapi Pengkajian</p>
                                    <img src="<?= $data->question8 ?>" alt="img" height="50px" width="50px"><br>
                                    <?php 
                                    $id1 =isset($assesment_keperawatan->id_pemeriksa2)?$assesment_keperawatan->id_pemeriksa2:null;                                    
                                    $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                                    ?>
                                    <span>( <?=  isset($query1->name)?$query1->name:'' ?> )</span><br> 
                                
                            </div>  
                        </div>
                    </td>

                    
                </tr>
            </table>

            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.02.b/RJ-GN </p>
                </div>     
            </div> 
        </div>
    
   
      
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   