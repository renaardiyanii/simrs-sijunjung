<?php 
$data = isset($permintaan->formjson)?json_decode($permintaan->formjson):'';
// $data_chunk = isset($data->question21)? array_chunk($data->question21,7):null;
//  var_dump($data_iri->klsiri);die;
?>


<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <h3><center>PERMINTAAN TRANSFUSI DARAH</center></h3>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Rumah Sakit</td>
                        <td>: <?= isset($data->question1->text1) ? nl2br($data->question1->text1) : '' ?></td>
                        <td>No RM</td>
                        <td>:<?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                    </tr>
                        <td>Bagian</td>
                        <td>: <?= isset($data->question1->text3) ? nl2br($data->question1->text3) : '' ?></td>
                        <td>Kelas</td>
                        <td>: <?= isset($data_iri[0]['klsiri']) ? $data_iri[0]['klsiri'] : '' ?></td>
                    </tr>
                    <tr>
                        <td>Ruang rawat</td>
                        <td>: <?= isset($data->question1->text4) ? nl2br($data->question1->text4) : '' ?></td>
                     </tr>
                    <tr>
                        <td>Dokter yang meminta</td>
                        <td>: <?= isset($data->question3->item1->column1) ? nl2br($data->question3->item1->column1) : '' ?></td>
                     </tr>
                    <tr>
                        <td>Nama OS</td>
                        <td>: <?= isset($data->question3->item1->column2) ? nl2br($data->question3->item1->column2) : '' ?></td>
                     </tr>
                     <tr>
                        <td>Nama Suami</td>
                        <td>: <?= isset($data->question3->item1->column3) ? nl2br($data->question3->item1->column3) : '' ?></td>
                     </tr>
                    <tr>
                        <td>Tgl Lahir/ Umur </td>
                        <td colspan="2">: <?php
                        if (isset($data_pasien[0]->tgl_lahir)) {
                            $tahun_lahir = date('Y', strtotime($data_pasien[0]->tgl_lahir));
                            $tahun_sekarang = date('Y');
                            $umur = $tahun_sekarang - $tahun_lahir;
                            echo $umur . " tahun";
                        } else {
                            echo "Tanggal lahir tidak tersedia";
                        }
                        ?>

                            </td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>:
                            <label>
                            <input type="checkbox" value="Laki-laki" 
                                <?= isset($data->question3->item1->column5) && $data->question3->item1->column5 == "item1" ? "checked" : "" ?>>
                            Laki-laki
                            </label>
                            <label style="margin-left: 15px;">
                            <input type="checkbox" value="Perempuan" 
                                <?= isset($data->question3->item1->column5) && $data->question3->item1->column5 == "item2" ? "checked" : "" ?>>
                            Perempuan
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Alamat rumah</td>
                        <td colspan="2">: <?= isset($data->question3->item1->column6)?nl2br($data->question3->item1->column6):'' ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Permintaan </td>
                        <td colspan="2">: <?= isset($data->question3->item1->column7)?$data->question3->item1->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Diperlukan </td>
                        <td colspan="2">: <?= isset($data->question3->item1->column8)?$data->question3->item1->column8:'' ?></td>
                    </tr>
                    <tr>
                        <td>Diagnosa klinis</td>
                          <td colspan="2">: <?= isset($data->question3->item1->column9)?$data->question3->item1->column9:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Alasan Transfusi</td>
                           <td colspan="2">: <?= isset($data->question3->item1->column10)?$data->question3->item1->column10:'' ?>
                    </tr>
                     <tr>
                        <td>HB</td>
                           <td colspan="2">: <?= isset($data->question3->item1->column11)?$data->question3->item1->column11:'' ?>
                    </tr>
                    <tr>
                        <td>Transfusi Sebelumnya*</td>
                        <td>
                                :<input type="checkbox" name="transfusi" value="tidak" <?= isset($data->question3->item1->column12) && $data->question3->item1->column12 == "item2" ? "checked" : "" ?>> Tidak
                                <input type="checkbox" name="transfusi" value="Ya" <?= isset($data->question3->item1->column12) && $data->question3->item1->column12 == "item1" ? "checked" : "" ?>> Ya, kapan : <?= isset($data->question3->item1->column17)?$data->question3->item1->column17:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Reaksi Transfusi</td>
                        <td>
                                :<input type="checkbox" name="transfusi" value="tidak" <?= isset($data->question3->item1->column18) && $data->question3->item1->column18 == "item2" ? "checked" : "" ?>> Tidak
                                <input type="checkbox" name="transfusi" value="Ya" <?= isset($data->question3->item1->column18) && $data->question3->item1->column18 == "item1" ? "checked" : "" ?>> Ya, Gejala : <?= isset($data->question3->item1->column19)?$data->question3->item1->column19:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Apakah pernah diperiksa serologi<br> golongan darah (coombs test)</td>
                        <td>
                                :<input type="checkbox" name="transfusi" value="tidak" <?= isset($data->question3->item1->column13) && $data->question3->item1->column13 == "item2" ? "checked" : "" ?>> Tidak
                                <input type="checkbox" name="transfusi" value="Ya" <?= isset($data->question3->item1->column13) && $data->question3->item1->column13 == "item1" ? "checked" : "" ?>> Ya
                        </td>
                    </tr>
                    <tr>
                        <td>Dimana </td>
                        <td colspan="2">: <?= isset($data->question3->item1->column14)?$data->question3->item1->column14:'' ?> </td>
                    </tr>
                     <tr>
                        <td>Kapan </td>
                        <td colspan="2">: <?= isset($data->question3->item1->column15)?$data->question3->item1->column15:'' ?></td>
                    </tr>
                     <tr>
                        <td>Hasil </td>
                        <td colspan="2">: <?= isset($data->question3->item1->column16)?$data->question3->item1->column16:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="3">Khusus untuk pasien wanita :</td>
                    </tr>
                    <tr>
                        <td>1. Jumlah kehamilan sebelumnya : </td>
                       <td colspan="2">: <?= isset($data->question2->text1) ? nl2br($data->question2->text1) : '' ?> </td>
                    </tr>
                    <tr>
                        <td>2. Pernah abortus </td>
                        <td colspan="2">: <?= isset($data->question2->text2)?$data->question2->text2:'' ?> cc</td>
                    </tr>
                    <tr>
                        <td>3. Adakah sebelumnya penyakit hemolitik <br>pada bayi </td>
                        <td colspan="2">: <?= isset($data->question2->text3)?$data->question2->text3:'' ?> Unit</td>
                    </tr>
                    <tr>
                        <td>HDN</td>
                        <td>
                                :<input type="checkbox" name="transfusi" value="tidak" <?= isset($data->question4) && $data->question4 == "item1" ? "checked" : "" ?>> CYTO
                                <input type="checkbox" name="transfusi" value="Ya" <?= isset($data->question4) && $data->question4 == "item2" ? "checked" : "" ?>> BIASA
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                        <p style="font-size:10px;"><b>PERHATIAN !</b>
                        <p style="font-size:10px;">*)- Beri tanda √ pada kotak (      ) yang dimaksud
                        <p style="font-size:10px;">'- Setiap permintaan darah harap disertai contoh darah beku 5 cc minimal 2 cc
                        <p style="font-size:10px;">'- Nama dan identitas O.S pada formulr dan contoh darah harus sama
                        <p style="font-size:10px;">'- Sebelum transfusi, cocokkan etiket pada kantong darah dengan labelnya dan disertakan
                        <p style="font-size:10px;">'dengan identitas O.S yang akan ditransfusi. Bila ada ketidak cocokan, segera 
                        <p style="font-size:10px;">'kembalikan ke UTDC
                        </td>
                    </tr>
                     <tr>
                        <td colspan="2">
                            <b>Darah Lengkap (Whole Blood)</b>
                            <table style="width:100%; font-size:12px; border-collapse:collapse; margin-top:5px;">
                                <tr>
                                    <td style="width:20px;">
                                        <input type="checkbox" name="transfusi" value="Segar" <?= (isset($data->question7->item1->column1)?in_array("item1", $data->question7->item1->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>Segar (48 jam)</td>
                                    <td style="width:150px;">: <?= isset($data->question7->item1->column2)?$data->question7->item1->column2:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="transfusi" value="Baru" <?= (isset($data->question7->item2->column1)?in_array("item1", $data->question7->item2->column1)?'checked':'':'') ?>></td>
                                    <td>Baru (max 2-7 hari)</td>
                                    <td>: <?= isset($data->question7->item2->column2)?$data->question7->item2->column2:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="transfusi" value="Biasa" <?= (isset($data->question7->item3->column1)?in_array("item1", $data->question7->item3->column1)?'checked':'':'') ?>></td>
                                    <td>Biasa</td>
                                    <td>: <?= isset($data->question7->item3->column2)?$data->question7->item3->column2:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="transfusi" value="PRC" <?= (isset($data->question7->item4->column1)?in_array("item1", $data->question7->item4->column1)?'checked':'':'') ?>></td>
                                    <td>II. Packed Red Cells (PRC)</td>
                                    <td>: <?= isset($data->question7->item4->column2)?$data->question7->item4->column2:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="transfusi" value="WE" <?= (isset($data->question7->item5->column1)?in_array("item1", $data->question7->item5->column1)?'checked':'':'') ?>></td>
                                    <td>III. Washed Erytrocite (WE)</td>
                                    <td>: <?= isset($data->question7->item5->column2)?$data->question7->item5->column2:'' ?> cc</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                     <tr>
                        <td colspan="2">
                            <b>IV. PLASMA</b>
                            <table style="width:100%; font-size:12px; border-collapse:collapse; margin-top:5px;">
                                <tr>
                                    <td style="width:20px;">
                                        <input type="checkbox" name="transfusi" value="LP" <?= (isset($data->question6->item1->column1)?in_array("item1", $data->question6->item1->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>Liquid Plasma (LP)</td>
                                    <td style="width:150px;">: <?= isset($data->question6->item1->column2)?$data->question6->item1->column2:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="transfusi" value="FFP" <?= (isset($data->question6->item2->column1)?in_array("item1", $data->question6->item2->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>Fresh Frozen Plasma (FFP)</td>
                                    <td>: <?= isset($data->question6->item2->column2)?$data->question6->item2->column2:'' ?>. cc</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
       </tr>
    </table>
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <h3><center>PERMINTAAN TRANSFUSI DARAH</center></h3>
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td colspan="2">
                            <b>V. FAKTOR PEMBEKUAN</b>
                            <table style="width:100%; font-size:12px; border-collapse:collapse; margin-top:5px;">
                                <tr>
                                    <td style="width:20px;">
                                        <input type="checkbox" name="transfusi" value="LP" <?= (isset($data->question8->item1->column1)?in_array("item1", $data->question8->item1->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>Thrombocyte Concentrate (TC) biasa</td>
                                    <td style="width:150px;">: <?= isset($data->question8->item1->column2)?$data->question8->item1->column2:'' ?> cc</td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="transfusi" value="FFP" <?= (isset($data->question8->item2->column1)?in_array("item1", $data->question8->item2->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>Thrombocyte Aperesis</td>
                                    <td>: <?= isset($data->question8->item2->column2)?$data->question8->item2->column2:'' ?> cc</td>
                                </tr>
                                 <tr>
                                    <td>
                                        <input type="checkbox" name="transfusi" value="FFP" <?= (isset($data->question8->item3->column1)?in_array("item1", $data->question8->item3->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>Cryoprecipitate (AHF)</td>
                                    <td>: <?= isset($data->question8->item3->column2)?$data->question8->item3->column2:'' ?>cc</td>
                                </tr>
                                 <tr>
                                    <td>
                                        <input type="checkbox" name="transfusi" value="FFP" <?= (isset($data->question8->item4->column1)?in_array("item1", $data->question8->item4->column1)?'checked':'':'') ?>>
                                    </td>
                                    <td>DLL</td>
                                    <td>: <?= isset($data->question8->item4->column2)?$data->question8->item4->column2:'' ?>cc</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                            <input type="checkbox" name="transfusi" value="tidak" <?= isset($data->question9) && $data->question9 == "item1" ? "checked" : "" ?>> DENGAN CROSMATCHING
                                            <input type="checkbox" name="transfusi" value="Ya" <?= isset($data->question9) && $data->question9 == "item2" ? "checked" : "" ?>> TANPA CROSMATCHING
                                    </td>
                                </tr>
                            </table>
                            <div style="display: flex; justify-content: space-around; margin-top: 20px; text-align: center;">

                                <!-- TTD DPJP -->
                                <div>
                                    <p style="font-size: 13px;">Petugas RS yang mengambil contoh darah OS</p>
                                        <img src=" <?= isset($data->question10)?$data->question10:'' ?>" alt="ttd" height="80px" width="60px"><br>
                                        <p><?= isset($data->question12)?$data->question12:'' ?></p>
                                        <br>
                                   
                                </div>

                                <!-- TTD Kedua -->
                                <div>
                                    <p style="font-size: 13px;">Dokter yang meminta darah</p>
                                    <img src=" <?= isset($data->question11)?$data->question11:'' ?>" alt="ttd" height="80px" width="60px"><br>
                                        <p><?= isset($data->question13)?$data->question13:'' ?></p>
                                        <br>
                                </div>

                            </div>
                        <p><b>DIISI OLEH PETUGAS UTD</b></p>
                        <tr>
                            <td style="width: 30;">Contoh darah OS</td>
                            <td style="width: 70;">: <?= isset($data->question14->text1)?$data->question14->text1:'' ?></td>
                        </tr>
                         <tr>
                            <td style="width: 30;">Diterima tanggal & Jam</td>
                            <td style="width: 70;">: <?= isset($data->question14->text2)?$data->question14->text2:'' ?></td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Petugas  penerima</td>
                            <td style="width: 70;">: <?= isset($data->question14->text3)?$data->question14->text3:'' ?></td>
                        </tr>
                         <tr>
                            <td colspan="2">ABO : <?= isset($data->question15->text1)?$data->question15->text1:'' ?> &nbsp;&nbsp; RESUS : <?= isset($data->question15->text2)?$data->question15->text2:'' ?> &nbsp;&nbsp; LAIN LAIN : <?= isset($data->question15->text3)?$data->question15->text3:'' ?></td>
                        </tr>
                        <tr>
                            <td>Hasil Cross </td>
                            <td>
                                    :<input type="checkbox" name="transfusi" value="tidak" <?= (isset($data->question16)?in_array("item1", $data->question16)?'checked':'':'') ?>> Compatible (Cocok)
                                    <input type="checkbox" name="transfusi" value="Ya" <?= (isset($data->question16)?in_array("item2", $data->question16)?'checked':'':'') ?>>Incompatible ( Tidak cocok)
                                    <input type="checkbox" name="transfusi" value="Ya" <?= (isset($data->question16)?in_array("item3", $data->question16)?'checked':'':'') ?>>Tanpa Cross
                            </td>
                         </tr>
                        <tr>
                            <td style="width: 30;">Petugas  pemeriksa</td>
                            <td style="width: 70;">: <?= isset($data->question17)?$data->question17:'' ?></td>
                        </tr>
                         <tr>
                            <td style="width: 30;">Petugas  yang mengeluarkan darah</td>
                            <td style="width: 70;">: <?= isset($data->question18->text1)?$data->question18->text1:'' ?></td>
                        </tr>
                         <tr>
                            <td style="width: 30;">Tanggal dan jam</td>
                            <td style="width: 70;">: <?= isset($data->question18->text2)?$data->question18->text2:'' ?></td>
                        </tr>
                         <tr> 
                            <td style="width: 50%; text-align: center;">
                                 <p style="font-size: 13px;">Penerima darah</p>
                                <img src=" <?= isset($data->question19)?$data->question19:'' ?>" alt="ttd" height="80px" width="60px"><br>
                                <p><?= isset($data->question20)?$data->question20:'' ?></p>
                            </td>
                        </tr>

                        </td>
                    </tr>
                </table>
            </td>
       </tr>
    </table>
    </div>
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
                    <td width="80%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size:9px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="2px" >
                <tr>
                    <td style="font-size:13px" width="20%">No.RM</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:13px" width="20%">Nama</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                </tr>

                <tr>
                    <td style="font-size:13px" width="20%">TglLahir</td>
                    <td style="font-size:13px" width="2%">:</td>
                    <td style="font-size:13px"><?= isset($data_pasien[0]->tgl_lahir)?date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?>)</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
        
       
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
    
       <tr>
            <td colspan="4">
                <h3><center>PERMINTAAN TRANSFUSI DARAH</center></h3>
            </td>
                                  <table border="1" width="100%">
                            <tr>
                                <td colspan="4"><center>Telah diberikan darah golongan </center></td>
                                <td>ABO</td>
                                <td>RESUS</td>
                                <td>LAIN LAIN</td>
                            </tr>
                            <tr>
                                <td colspan="4"><center>dengan perincian</center></td>
                                 <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td>Jumlah yang dikeluarkan cc/kantong</td>
                                <td>jenis darah</td>
                                <td>NO</td>
                                <td>Tgl. Pengambilan</td>
                                 <td colspan="3">No Kantong</td>
                            </tr>
                            <?php if (!empty($data->question21) && is_array($data->question21)): ?>
                            <?php foreach ($data->question21 as $key => $question): ?>
                            <tr>
                                <td>&nbsp;<?= isset($question->column1) ? $question->column1 : '' ?></td>
                                <td>&nbsp;<?= isset($question->column2) ? $question->column2 : '' ?></td>
                                <td>&nbsp;<?= isset($question->column3) ? $question->column3 : '' ?></td>
                                <td>&nbsp;<?= isset($question->column4) ? $question->column4 : '' ?></td>
                                <td colspan="3">&nbsp;<?= isset($question->column5) ? $question->column5 : '' ?></td>
                            </tr>
                             <?php endforeach; ?>
                             <?php endif; ?>
                        </table>
                        <div style="display: flex; justify-content: flex-end; margin-top: 20px; text-align: center;">
                                <!-- TTD DPJP -->
                                <div style="text-align: center; margin-right: 50px;">
                                    <p style="font-size: 13px;">Dijanjikan tanggal : <?= isset($data->question23)?$data->question23:'' ?> </p>
                                    <p style="font-size: 13px;">Petugas yang menjanjikan</p>
                                     <img src=" <?= isset($data->question22)?$data->question22:'' ?>" alt="ttd" height="80px" width="60px"><br>
                                    <p><?= isset($data->question24)?$data->question24:'' ?></p>
                                </div>
                            </div>
       </tr>
    </table>
    </div>
</body>