<?php 
$data = isset($per_trans_darah->formjson)?json_decode($per_trans_darah->formjson):'';
// var_dump($data);die;
?>


</style>
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
                <h3>PERNYATAAN TRANSFUSI DARAH</h3>
            </center>
           
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
        <tr>
            <td colspan="2">(Diisi oleh Petugas)</td>
            <td >Halaman 1 dari 1</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="30%" >Alasan tranfusi </td>
                    <td width="20%" > : <?= isset($data->question1->text1)?$data->question1->text1:'' ?></td>
                    <td width="30%" >Dokter yang meminta darah </td>
                    <td width="20%" > : <?= isset($data->question1->text2)?$data->question1->text2:'' ?></td>
                </tr>
                <tr>
                    <td width="30%" >Diagnosa Klinis  </td>
                    <td width="20%" >:</td>
                    <td width="30%" ><?= isset($data->question1->text3)?$data->question1->text3:'' ?></td>
                    <td width="20%" > </td>
                </tr>
                <tr>
                    <td width="30%" >Kadar HB </td>
                    <td width="20%" >:</td>
                    <td width="30%" >Jumlah Trombosit  </td>
                    <td width="20%" >: <?= isset($data->question1->text4)?$data->question1->text4:'' ?></td>
                </tr>
                
            </table>
            <p style="font-size: 14px;"><strong>JENIS DARAH / KOMPONEN DARAH YANG DIBERIKAN  & JUMLAH : <?= isset($data->question2->text1)?$data->question2->text1:'' ?> </strong></p>
            <p style="font-size: 14px;"> Tanggal & Jam Permintaan :<?= isset($data->question2->text2)?date('d/m/Y',strtotime($data->question2->text2)):'..........' ?>Tanggal  digunakan : <?= isset($data->question2->text3)?date('d/m/Y',strtotime($data->question2->text3)):'...........' ?></p>
            <p style="font-size: 14px;">Pemberian Informasi</p>
            <table border="1" width="100%" cellpadding="2">
                <tr>
                    <td rowspan="2"><b><center>NO</center></b></td>
                    <td rowspan="2"><b><center>PENJELASAN TRANSFUSI</center></b></td>
                    <td rowspan="2"><b><center>JELAS</center></b></td>
                    <td colspan="2"><b><center>TANDA TANGAN & NAMA</center></b></td>
                </tr>
                <tr>
                    <td><b><center>PEMBERI INFORMASI</center></b></td>
                    <td><b><center>PENERIMA INFORMASI</center></b></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Indikasi tranfusi & jenis darah yang diberikan</td>
                    <td style="text-align:center"><?php echo isset($data->question2->item1->jelas[0])? $data->question2->item1->jelas[0] == "item1" ? "v":'':'' ?></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item1->ttd)?$data->question2->item1->ttd:''; ?>" alt="img" height="30px" width="30px"></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item1->ttd2)?$data->question2->item1->ttd2:''; ?>" alt="img" height="30px" width="30px"></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Infeksi yang dapat ditularkan melalui tranfusi darah & pemeriksaan penapisan terhadap produk darah</td>
                    <td style="text-align:center"><?php echo isset($data->question2->item2->jelas[0])? $data->question2->item2->jelas[0] == "item1" ? "v":'':'' ?></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item2->ttd)?$data->question2->item2->ttd:''; ?>" alt="img" height="30px" width="30px"></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item2->ttd2)?$data->question2->item2->ttd2:''; ?>" alt="img" height="30px" width="30px"></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Kemungkinan risiko tertular infeksi kecil beserta usaha untuk memperkecil risiko tsb</td>
                    <td style="text-align:center"><?php echo isset($data->question2->item3->jelas[0])? $data->question2->item3->jelas[0] == "item1" ? "v":'':'' ?></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item3->ttd)?$data->question2->item3->ttd:''; ?>" alt="img" height="30px" width="30px"></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item3->ttd2)?$data->question2->item3->ttd2:''; ?>" alt="img" height="30px" width="30px"></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Pemeriksaan pre tranfusi untuk menghindari reaksi ketidak cocokan akibat tranfusi</td>
                    <td style="text-align:center"><?php echo isset($data->question2->item4->jelas[0])? $data->question2->item4->jelas[0] == "item1" ? "v":'':'' ?></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item4->ttd)?$data->question2->item4->ttd:''; ?>" alt="img" height="30px" width="30px"></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item4->ttd2)?$data->question2->item4->ttd2:''; ?>" alt="img" height="30px" width="30px"></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Hubungan tranfusi darah dengan agama / kepercayaan</td>
                    <td style="text-align:center"><?php echo isset($data->question2->item5->jelas[0])? $data->question2->item5->jelas[0] == "item1" ? "v":'':'' ?></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item5->ttd)?$data->question2->item5->ttd:''; ?>" alt="img" height="30px" width="30px"></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item5->ttd2)?$data->question2->item5->ttd2:''; ?>" alt="img" height="30px" width="30px"></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Biaya penggantian pengelolaan darah</td>
                    <td style="text-align:center"><?php echo isset($data->question2->item6->jelas[0])? $data->question2->item6->jelas[0] == "item1" ? "v":'':'' ?></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item6->ttd)?$data->question2->item6->ttd:''; ?>" alt="img" height="30px" width="30px"></td>
                    <td style="text-align:center"><img src="<?= isset($data->question2->item6->ttd2)?$data->question2->item6->ttd2:''; ?>" alt="img" height="30px" width="30px"></td>
                </tr>
               
            </table>
            <p style="font-size: 14px;"><strong><center>PERSETUJUAN PEMBERIAN TRANSFUSI</center></strong></p>
            <p style="font-size: 12px;"><input type="checkbox" <?= (isset($data->question3)?in_array("item1", $data->question3)?'checked':'':'') ?>>Pasien tidak memperoleh persetujuan tindakan medis sehubungan dengan kedaruratan dari tranfusi</p><p><input type="checkbox" <?= (isset($data->question3)?in_array("item2", $data->question3)?'checked':'':'') ?>> Pasien / keluarga telah mendapatkan penjelasan tetapi tidak berharap untuk mendiskusikan risiko dari tranfusi</p> <p><input type="checkbox" <?= (isset($data->question3)?in_array("item3", $data->question3)?'checked':'':'') ?>>Pasien / keluarga  telah menerima penjelasan & diberi kesempatan mendiskusikan manfaat serta risiko tranfusi darah terhadap dirinya. </p>
            <p style="font-size: 12px;">Yang bertanda tangan dibawah ini saya sebagai WALI <input type="checkbox" <?= (isset($data->question4)?in_array("item1", $data->question4)?'checked':'':'') ?>>Anak <input type="checkbox" <?= (isset($data->question4)?in_array("item2", $data->question4)?'checked':'':'') ?>> Istri <input type="checkbox" <?= (isset($data->question4)?in_array("item3", $data->question4)?'checked':'':'') ?>> Suami <input type="checkbox"> Lainnya :.......................dari nama pasien tersebut diatas</p>
            <table border="0" width="100%" cellpadding="2">
                <tr>
                    <td width="40%" >1. Nama : <?= isset($data_pasien[0]->nama)?$data_pasien[0]->nama:'' ?></td>
                    <td width="60%" >3. Pekerjaan : <?= isset($data_pasien[0]->pekerjaan)?$data_pasien[0]->pekerjaan:'' ?></td>
                </tr>
                <tr>
                    <td width="40%" >2. No KTP : <?= isset($data_pasien[0]->no_identitas)?$data_pasien[0]->no_identitas:'' ?></td>
                    <td width="60%"><?= isset($data_pasien[0]->sex)?$data_pasien[0]->sex:'' ?></td>
                </tr>
                <tr>
                    <td width="40%" >4. Alamat : <?= isset($data_pasien[0]->alamat)?$data_pasien[0]->alamat:'' ?></td>
                </tr>
            </table>
            <p style="font-size: 14px;"><strong><center>PERNYATAAN</center></strong></p>
            <p style="font-size: 12px; line-height: 1.6; margin-bottom: 10px;">
                Saya <input type="checkbox" <?php echo isset($data->question5)? $data->question5 == "item1" ? "checked":'':'' ?>><b>Menyetujui</b><input type="checkbox" <?php echo isset($data->question5)? $data->question5 == "item2" ? "checked":'':'' ?>><b>Menolak</b> tindakan tranfusI darah yang diberikan pada saya / keluarga saya yang bernama  
                <br>setelah menerima penjelasan dari informasi sebagaimana diatas yang di beri tanda / 
                <br>tandatangan di kolom kanannya dan telah memahami.</b>
            </p>
            <div style="display: flex; justify-content: space-between; width: 100%; text-align: center; margin-top: 20px;">
                <!-- Kolom Dokter -->
                <div style="width: 33%;">
                    <p><br></p>
                    <p>Dokter</p>
                    <?php
                        $id_dokter = isset($data->question15) ? $data->question15 : null;
                        // var_dump($data->question17);die();
                        $id_dokter1 = null;
                        $dokter = null;

                        // Pastikan $id_dokter adalah string dulu
                        if (is_string($id_dokter) && strpos($id_dokter, '-') !== false) {
                            $parts = explode('-', $id_dokter);
                            if (isset($parts[1])) {
                                $id_dokter1 = trim($parts[1]); // trimming untuk jaga-jaga ada spasi

                                if (!empty($id_dokter1)) {
                                    $query = $this->db->query("SELECT a.name, a.ttd 
                                        FROM hmis_users a
                                        JOIN dyn_user_dokter b ON a.userid = b.userid
                                        WHERE b.id_dokter = '$id_dokter1'");
                                    $dokter = $query->row();
                                }
                            }
                        }
                        ?>
                    <p><img width="50px" src="<?= isset($dokter->ttd) ? $dokter->ttd : '' ?>"></p>
                    <p>(<?= isset($dokter->name) ? $dokter->name : '' ?>)</p>
               
                 </div>

                <!-- Kolom Petugas Saksi -->
                <div style="width: 33%;">
                <p><br></p>
                    <p>Petugas Saksi</p>
                    <p><img width="50px" src="<?= isset($data->question10)?$data->question10:''; ?>" alt="img" height="30px" width="30px"></p>
                    <p><?= isset($data->question13)?$data->question13:'' ?></p>
                </div>

                <!-- Kolom Pasien/Keluarga -->
                <div style="width: 33%;">
                    <p>Tanah Badantuang, <?= isset($data->question8)? date('d/m/Y',strtotime($data->question8)):'' ?></p>
                    <p>Pasien/Keluarga</p>
                    <p><img width="50px" src="<?= isset($data->question11)?$data->question11:''; ?>" alt="img" height="30px" width="30px"></p>
                    <p><?= isset($data->question14)?$data->question14:'' ?></p>
                </div>
            </div>
                       
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.17.b2/RI-GN
                    </div>
               </div>
    </div>
</div>
</body>

</html>