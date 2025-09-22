<?php 
$data = isset($keperawatanobgyn->formjson)?json_decode($keperawatanobgyn->formjson):'';
// var_dump($data);die;
?>

<style>
    .bg-checked {
        background-color: #64C9CF;

    }
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
                <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP OBSTETRI DAN GINEKOLOGI</h3>
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
            <td colspan="2">(Diisi oleh Bidan)</td>
            <td >Halaman 1 dari 4</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Tanggal : <?= isset($data->question1)?date('d/m/Y',strtotime($data->question1)):'' ?> </td>
                        <td>Jam : <?= isset($data->question1)?date('h:i',strtotime($data->question1)):'' ?> </td>
                    </tr>
                    <tr>
                        <td colspan="2">Sumber data :  
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item1" ? "checked":'':'' ?>> Pasien 
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item2" ? "checked":'':'' ?>> Keluarga, hubungan : <span class="input-line"></span>
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "other" ? "checked":'':'' ?>> Lainnya, <?= isset($data->{'question2-Comment'})?$data->{'question2-Comment'}:'' ?> <span class="input-line"></span>
                    </tr>
                    <tr>
                        <td colspan="2">Rujukan :  
                            <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item1" ? "checked":'':'' ?>> Tidak   
                            <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item2" ? "checked":'':'' ?>>Ya  
                            <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item1" ? "checked":'':'' ?>>RS…………………………………………… 
                            <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item2" ? "checked":'':'' ?>>Puskesmas………
                            <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item3" ? "checked":'':'' ?>>Dokter……… 
                            <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "other" ? "checked":'':'' ?>>Bidan...........</td>
                    </tr>
                    <tr>
                        <td colspan="2">Diagnosa Rujukan : <?= isset($data->question5)?$data->question5:'' ?></td>
                    </tr>
                </table>
                <p><b>ASESMEN KEPERAWATAN </b></p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                <table border="0" cellpadding="5px" style="width: 48%; border-collapse: collapse;">
                    <tr>
                        <td colspan="3" style="font-weight: bold;">IDENTITAS PASIEN</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question6->text1)?$data->question6->text1:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Lahir</td>
                        <td>:</td>
                        <td><?= isset($data->question6->text3)?$data->question6->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                        <td><?= isset($data->question6->text2)?$data->question6->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td><?= isset($data->question6->text4)?$data->question6->text4:'' ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?= isset($data->question6->text5)?$data->question6->text5:'' ?></td>
                    </tr>
                    <tr>
                        <td>Suku</td>
                        <td>:</td>
                        <td><?= isset($data->question6->text6)?$data->question6->text6:'' ?></td>
                    </tr>
                    <tr>
                        <td>Gol Darah</td>
                        <td>:</td>
                        <td><?= isset($data->question6->text7)?$data->question6->text7:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </table>

                <table border="0" cellpadding="5px" style="width: 48%; border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">SUAMI</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question56[0]->column1)?$data->question56[0]->column1:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Lahir</td>
                        <td>:</td>
                        <td><?= isset($data->question56[0]->column3)?$data->question56[0]->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                        <td><?= isset($data->question56[0]->column2)?$data->question56[0]->column2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td><?= isset($data->question56[0]->column4)?$data->question56[0]->column4:'' ?></td>
                    </tr>
                    <tr>
                        <td>Agama</td>
                        <td>:</td>
                        <td><?= isset($data->question56[0]->column5)?$data->question56[0]->column5:'' ?></td>
                    </tr>
                    <tr>
                        <td>Suku</td>
                        <td>:</td>
                        <td><?= isset($data->question56[0]->column6)?$data->question56[0]->column6:'' ?></td>
                    </tr>
                    <tr>
                        <td>Gol Darah</td>
                        <td>:</td>
                        <td><?= isset($data->question56[0]->column7)?$data->question56[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                   
                </table>
            
            </div>  
                <p style="font-weight: bold;">2. KELUHAN UTAMA</p>
                <span><?= isset($data->question8)?$data->question8:'' ?></span>
                <p style="font-weight: bold;">3. RIWAYAT KESEHATAN</p>
                <p><b>a. Riwayat Penyakit dahulu:</b></p>
                <label><input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item1" ? "checked":'':'' ?>> Tidak</label>
                <label><input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?>> Ya, Penyakit: .............</label>
                <br>
                <p>- Pernah dirawat:
                     <label><input type="checkbox"> Tidak</label>
                      <label><input type="checkbox"> Ya</label>, 
                      Diagnosa: ............. Kapan: ............. Di: .............</p>
                <p>- Pernah dioperasi: 
                    <label><input type="checkbox" <?php echo isset($data->question14)? $data->question14 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question14)? $data->question14 == "item2" ? "checked":'':'' ?>> Ya</label>, 
                    Jenis Operasi: <?= isset($data->question15->text1)?$data->question15->text1:'' ?> Kapan: <?= isset($data->question15->text2)?$data->question15->text2:'' ?></p>
                <p>- Masih dalam pengobatan: 
                    <label><input type="checkbox" <?php echo isset($data->question57)? $data->question57 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question57)? $data->question57 == "item2" ? "checked":'':'' ?>> Ya</label>, Obat: <?= isset($data->question59->text1)?$data->question59->text1:'' ?></p>
                
                <p><b>b. Riwayat penyakit keluarga:</b></p>
                <label><input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item1" ? "checked":'':'' ?>> Tidak</label>
                <label><input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item2" ? "checked":'':'' ?>> Ya</label>
                <input type="checkbox" <?= (isset($data->question17)?in_array("item1", $data->question17)?'checked':'':'') ?>> (Hipertensi 
                <input type="checkbox" <?= (isset($data->question17)?in_array("item2", $data->question17)?'checked':'':'') ?>> Jantung 
                <input type="checkbox" <?= (isset($data->question17)?in_array("item3", $data->question17)?'checked':'':'') ?>> Paru 
                <input type="checkbox" <?= (isset($data->question17)?in_array("item4", $data->question17)?'checked':'':'') ?>> DM 
                <input type="checkbox" <?= (isset($data->question17)?in_array("item5", $data->question17)?'checked':'':'') ?>> Ginjal 
                <input type="checkbox" <?= (isset($data->question17)?in_array("other", $data->question17)?'checked':'':'') ?>> Lainnya: .............)
                
                <p><b>c. Ketergantungan terhadap:</b></p>
                <label><input type="checkbox" <?php echo isset($data->question60)? $data->question60 == "item1" ? "checked":'':'' ?>> Tidak</label>
                <label><input type="checkbox" <?php echo isset($data->question60)? $data->question60 == "item2" ? "checked":'':'' ?>> Ya</label> (
                    <input type="checkbox" <?= (isset($data->question61)?in_array("item1", $data->question61)?'checked':'':'') ?>> Obat-obatan 
                    <input type="checkbox" <?= (isset($data->question61)?in_array("item2", $data->question61)?'checked':'':'') ?>> Rokok 
                    <input type="checkbox" <?= (isset($data->question61)?in_array("item3", $data->question61)?'checked':'':'') ?>> Alkohol 
                    <input type="checkbox" <?= (isset($data->question61)?in_array("other", $data->question61)?'checked':'':'') ?>> Lainnya: .............)
                
                <p><b>d. Riwayat pekerjaan (apakah berhubungan dengan zat-zat berbahaya):</b></p>
                <label><input type="checkbox" <?php echo isset($data->question9)? $data->question9 == "item1" ? "checked":'':'' ?>> Tidak</label>
                <label><input type="checkbox" <?php echo isset($data->question9)? $data->question9 == "other" ? "checked":'':'' ?>> Ya</label>, Sebutkan: .............
                
                <p><b>e. Riwayat Alergi:</b></p>
                <label><input type="checkbox" <?php echo isset($data->question62)? $data->question62 == "item1" ? "checked":'':'' ?>> Tidak</label>
                <label><input type="checkbox" <?php echo isset($data->question62)? $data->question62 == "item2" ? "checked":'':'' ?>> Ya</label>, Obat: ............. Makanan: ............. Lainnya: .............
                <br>
                Reaksi: <?= isset($data->question64)?$data->question64:'......' ?>
                
                <p><b>f. Riwayat pemakaian alat kontrasepsi:</b></p>
                <label><input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>> Tidak</label>
                <label><input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item2" ? "checked":'':'' ?>> Ya</label>, Jenis: <?= isset($data->question11->text1)?$data->question11->text1:'' ?> Lama Pemakaian: <?= isset($data->question11->text2)?$data->question11->text2:'' ?> Keluhan: <?= isset($data->question11->text3)?$data->question11->text3:'' ?>
                
               
                 

              
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP OBSTETRI DAN GINEKOLOGI</h3>
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
            <td colspan="2">(Diisi oleh Bidan)</td>
            <td >Halaman 2 dari 4</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p><b>g. Riwayat Pernikahan:</b></p>
                <p>- Status Pernikahan: 
                    <label><input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item1" ? "checked":'':'' ?>> Single</label> 
                    <label><input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item2" ? "checked":'':'' ?>> Menikah</label>, ...... Kali 
                    <label><input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item3" ? "checked":'':'' ?>> Bercerai</label> 
                    <label><input type="checkbox" <?php echo isset($data->question12)? $data->question12 == "item4" ? "checked":'':'' ?>> Janda / Duda</label></p>
                <p>- Umur waktu pertama kawin: <?= isset($data->question88->text1)?$data->question88->text1:'.........' ?> tahun, 
                    Kawin dengan suami 1: <?= isset($data->question88->text2)?$data->question88->text2:'.........' ?> tahun, 
                    ke 2: <?= isset($data->question88->text3)?$data->question88->text3:'.........' ?> tahun, 
                    ke 3: <?= isset($data->question88->text4)?$data->question88->text4:'.........' ?> Tahun</p>
                <p>- Volume <?= isset($data->question88->text5)?$data->question88->text5:'.........' ?> cc/24 
                jam Keluhan saat haid:
                 <label><input type="checkbox" <?php echo isset($data->question89)? $data->question89 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                 <label><input type="checkbox" <?php echo isset($data->question89)? $data->question89 == "item2" ? "checked":'':'' ?>> Ya</label></p>
                
                <p><b>h. Riwayat Penyakit Ginekologi:</b></p>
                <p><input type="checkbox" <?php echo isset($data->question90)? $data->question90 == "item1" ? "checked":'':'' ?>> Tidak 
                <input type="checkbox" <?php echo isset($data->question90)? $data->question90 == "item2" ? "checked":'':'' ?>> Ya 
                <input type="checkbox" <?= (isset($data->question91)?in_array("item1", $data->question91)?'checked':'':'') ?>>Infertilitas 
                <input type="checkbox" <?= (isset($data->question91)?in_array("item2", $data->question91)?'checked':'':'') ?>>Infeksi Virus 
                <input type="checkbox" <?= (isset($data->question91)?in_array("item3", $data->question91)?'checked':'':'') ?>>PMS 
                <input type="checkbox" >Endometriosis 
                <input type="checkbox" <?= (isset($data->question91)?in_array("item5", $data->question91)?'checked':'':'') ?>>Myoma 
                <input type="checkbox" <?= (isset($data->question91)?in_array("item6", $data->question91)?'checked':'':'') ?>>Polyp Cervix 
                <input type="checkbox" <?= (isset($data->question91)?in_array("item7", $data->question91)?'checked':'':'') ?>>Kanker 
                <input type="checkbox" <?= (isset($data->question91)?in_array("other", $data->question91)?'checked':'':'') ?>>Lain lain</p>
                <p><b>i. Riwayat Menstruasi:</b></p>
                <p>- Menarche, umur: <?= isset($data->question93->text1)?$data->question93->text1:'.........' ?> tahun, Siklus: <?= isset($data->question93->text2)?$data->question93->text2:'.........' ?> hari, 
                <label><input type="checkbox" <?php echo isset($data->question92)? $data->question92 == "item1" ? "checked":'':'' ?>> Teratur</label> 
                <label><input type="checkbox" <?php echo isset($data->question92)? $data->question92 == "item2" ? "checked":'':'' ?>> Tidak teratur</label>, lama: <?= isset($data->question94)?$data->question94:'.........' ?> hari</p>
                
                <p><b>j. Riwayat Hamil ini:</b></p>
                <p>- HPHT: <?= isset($data->question95->text1)?$data->question95->text1:'.........' ?> Taksiran Partus: </p>
                <p>- Asuhan Antenatal: 
                    <label><input type="checkbox" <?php echo isset($data->question96)? $data->question96 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question96)? $data->question96 == "item2" ? "checked":'':'' ?>> Ya</label> (
                        <label><input type="checkbox" <?php echo isset($data->question97)? $data->question97 == "item1" ? "checked":'':'' ?>> Dokter Kandungan</label> 
                        <label><input type="checkbox" <?php echo isset($data->question97)? $data->question97 == "item2" ? "checked":'':'' ?>> Dokter Umum</label> 
                        <label><input type="checkbox" <?php echo isset($data->question97)? $data->question97 == "item3" ? "checked":'':'' ?>> Bidan</label>)</p>
                <p><label><input type="checkbox"> Lainnya</label>: .............</p>
                <p>- Frekuensi: 
                    <label><input type="checkbox" <?php echo isset($data->question98)? $data->question98 == "item1" ? "checked":'':'' ?>> 1X</label> 
                    <label><input type="checkbox" <?php echo isset($data->question98)? $data->question98 == "item2" ? "checked":'':'' ?>> 2X</label> 
                    <label><input type="checkbox" <?php echo isset($data->question98)? $data->question98 == "item3" ? "checked":'':'' ?>> 3X</label> 
                    <label><input type="checkbox" <?php echo isset($data->question98)? $data->question98 == "item4" ? "checked":'':'' ?>> >3X</label> 
                    Imunisasi TT: 
                    <label><input type="checkbox" <?php echo isset($data->question99)? $data->question99 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question99)? $data->question99 == "other" ? "checked":'':'' ?>> Ya</label> ............. kali</p>
                <p>- keluhan saat hamil 
                    <label><input type="checkbox" <?php echo isset($data->question100)? $data->question100 == "item1" ? "checked":'':'' ?>> mual</label> 
                    <label><input type="checkbox" <?php echo isset($data->question100)? $data->question100 == "item2" ? "checked":'':'' ?>> muntah</label> 
                    <label><input type="checkbox" <?php echo isset($data->question100)? $data->question100 == "item3" ? "checked":'':'' ?>> perdarahan</label> 
                    <label><input type="checkbox" <?php echo isset($data->question100)? $data->question100 == "item4" ? "checked":'':'' ?>> pusing</label>
                    <input type="checkbox" <?php echo isset($data->question100)? $data->question100 == "item5" ? "checked":'':'' ?>> sakit kepala</label> 
                    <label><input type="checkbox" <?php echo isset($data->question100)? $data->question100 == "other" ? "checked":'':'' ?>> lainnya</p>
                       
               
              

               
                <p style="font-weight: bold;">4.RIWAYAT KEHAMILAN, PERSALINAN DAN NIFAS
                </p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td rowspan="2">No</td>
                        <td rowspan="2">Tgl/th <br>partus</td>
                        <td rowspan="2">umur <br>kehamilan</td>
                        <td rowspan="2">Jenis <br>persalinan</td>
                        <td rowspan="2">Penolong</td>
                        <td rowspan="2">Penyulit</td>
                        <td colspan="3">Anak</td>
                        <td rowspan="2">Nifas</td>
                        <td rowspan="2">Keadaan <br>anak sekarang</td>
                    </tr>
                    <tr>
                        <td>JK</td>
                        <td>BB</td>
                        <td>PB</td>
                    </tr>
                    <?php 
                    if(isset($data->question18)){
                        $i=1;
                        foreach($data->question18 as $val){ ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= isset($val->column1)?$val->column1:'' ?></td>
                            <td><?= isset($val->column2)?$val->column2:'' ?></td>
                            <td><?= isset($val->column3)?$val->column3:'' ?></td>
                            <td><?= isset($val->column4)?$val->column4:'' ?></td>
                            <td><?= isset($val->column5)?$val->column5:'' ?></td>
                            <td><?= isset($val->column6)?$val->column6:'' ?></td>
                            <td><?= isset($val->column7)?$val->column7:'' ?></td>
                            <td><?= isset($val->column8)?$val->column8:'' ?></td>
                            <td><?= isset($val->column9)?$val->column9:'' ?></td>
                            <td><?= isset($val->column10)?$val->column10:'' ?></td>
                        </tr>
                      <?php   }
                    }
                    ?>
                   
                  
                </table>
                <h3>5. KEBUTUHAN BIO-PSIKOLOGIS DAN SOSIAL</h3>
                <p><b>a. Status Psikologis:</b></p>
                <p>- Masalah Perkawinan: 
                    <label><input type="checkbox" <?php echo isset($data->question20)? $data->question20 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question20)? $data->question20 == "item2" ? "checked":'':'' ?>> Ya</label>: cerai/istri baru/lain-lain <?= isset($data->question21)?$data->question21:'' ?>
                </p>
                <p>- Mengalami kekerasan fisik: 
                    <label><input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question22)? $data->question22 == "item2" ? "checked":'':'' ?>> Ya</label> 
                    <label><input type="checkbox" <?php echo isset($data->question90)? $data->question90 == "item2" ? "checked":'':'' ?>> 
                    Mencederai orang lain</label>
                     <label><input type="checkbox" <?php echo isset($data->question23Mencederaioranglain)? $data->question23Mencederaioranglain == "item1" ? "checked":'':'' ?>> Tidak</label> 
                     <label><input type="checkbox" <?php echo isset($data->question23Mencederaioranglain)? $data->question23Mencederaioranglain == "item2" ? "checked":'':'' ?>> Ya</label>
                </p>
                <p>- Trauma dalam kehidupan: 
                    <label><input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>> Ya</label>, Jelaskan: <?= isset($data->{'question23-Comment'})?$data->{'question23-Comment'}:'............' ?>
                </p>
                <p>- Gangguan tidur: 
                    <label><input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item2" ? "checked":'':'' ?>> Ya</label>, Jelaskan: <?= isset($data->{'question24-Comment'})?$data->{'question24-Comment'}:'............' ?>
                </p>
                <p>- Konsultasi dengan psikologi/psikiater: 
                    <label><input type="checkbox" <?php echo isset($data->question25)? $data->question25 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question25)? $data->question25 == "item2" ? "checked":'':'' ?>> Ya</label>, Jelaskan: <?= isset($data->{'question25-Comment'})?$data->{'question25-Comment'}:'............' ?>
                </p>
                <p>- Penerimaan kondisi saat ini: 
                    <label><input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item1" ? "checked":'':'' ?>> Menerima</label> 
                    <label><input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item2" ? "checked":'':'' ?>> Tidak Menerima</label>, Jelaskan: <?= isset($data->{'question26-Comment'})?$data->{'question26-Comment'}:'............' ?>
                </p>
                <p>- Dukungan sosial dari: 
                    <label><input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item1" ? "checked":'':'' ?>> Suami</label> 
                    <label><input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item2" ? "checked":'':'' ?>> Orang Tua</label> 
                    <label><input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "item3" ? "checked":'':'' ?>> Keluarga</label> 
                    <label><input type="checkbox" <?php echo isset($data->question27)? $data->question27 == "other" ? "checked":'':'' ?>> Lainnya</label>:  <?= isset($data->{'question27-Comment'})?$data->{'question27-Comment'}:'............' ?>
                </p>
                <p>- Pendamping persalinan yang diinginkan (bila hamil): <?= isset($data->question28)?$data->question28:'............' ?></p>
                
                <p><b>b. Kebutuhan sosial:</b></p>
                <p>- Status pernikahan: 
                    <label><input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item1" ? "checked":'':'' ?>> Single</label> 
                    <label><input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item2" ? "checked":'':'' ?>> Menikah</label> ............. kali 
                    <label><input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item3" ? "checked":'':'' ?>> Bercerai</label> 
                    <label><input type="checkbox" <?php echo isset($data->question29)? $data->question29 == "item4" ? "checked":'':'' ?>> Janda</label></p>
                <p>- Umur waktu pertama kawin: <?= isset($data->question30->text1)?$data->question30->text1:'............' ?> th. 
                    Kawin dengan suami 1: <?= isset($data->question31->text1)?$data->question31->text1:'............' ?> th, 
                    ke 2, 3: <?= isset($data->question31->text2)?$data->question31->text2:'............' ?> th</p>
               

            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>
    </div>
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP OBSTETRI DAN GINEKOLOGI</h3>
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
            <td colspan="2">(Diisi oleh Bidan)</td>
            <td >Halaman 3 dari 4</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p>- Tinggal bersama: 
                    <label><input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item1" ? "checked":'':'' ?>> Suami</label> 
                    <label><input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item2" ? "checked":'':'' ?>> Anak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item3" ? "checked":'':'' ?>> Orang Tua</label> 
                    <label><input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item4" ? "checked":'':'' ?>> Sendiri</label> 
                    <label><input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "other" ? "checked":'':'' ?>> Lainnya</label>: .............</p>
                <p>- Nama: <?= isset($data->question33->text1)?$data->question33->text1:'............' ?> No. Telpon: <?= isset($data->question33->text2)?$data->question33->text2:'............' ?></p>
                <p>- Kebiasaan: 
                    <label><input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item1" ? "checked":'':'' ?>> Merokok</label> 
                    <label><input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item2" ? "checked":'':'' ?>> Alkohol</label> 
                    <label><input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "other" ? "checked":'':'' ?>> Lainnya</label>: ............. 
                    Jenis & Jumlah per hari: <?= isset($data->question35)?$data->question35:'............' ?></p>
                
                <p><b>c. Kebutuhan biologis:</b></p>
                <p>- Pola makan: <?= isset($data->question36->text1)?$data->question36->text1:'............' ?> x/hari, Terakhir jam: <?= isset($data->question36->text2)?$data->question36->text2:'............' ?></p>
                <p>- Pola minum: <?= isset($data->question36->text3)?$data->question36->text3:'............' ?> cc/hari, Terakhir jam: <?= isset($data->question36->text4)?$data->question36->text4:'............' ?></p>
                <p>- Pola eliminasi: BAK <?= isset($data->question36->text5)?$data->question36->text5:'............' ?> x/hari, Terakhir jam: <?= isset($data->question36->text6)?$data->question36->text6:'............' ?>, warna: ..........</p>
                <p>- BAB <?= isset($data->question36->text7)?$data->question36->text7:'............' ?> x/hari, Terakhir jam: <?= isset($data->question36->text8)?$data->question36->text8:'............' ?></p>
                
                <h3>6. KEBUTUHAN KOMUNIKASI DAN EDUKASI</h3>
                <p>Terdapat hambatan dalam pembelajaran:</p>
                <p><label><input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item1" ? "checked":'':'' ?> > Tidak</label> 
                <label><input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item2" ? "checked":'':'' ?>> Ya</label>, 
                Jika Ya: 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item1", $data->question38)?'checked':'':'') ?>> Pendengaran</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item2", $data->question38)?'checked':'':'') ?>> Penglihatan</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item3", $data->question38)?'checked':'':'') ?>> Kognitif</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item4", $data->question38)?'checked':'':'') ?>> Fisik</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item5", $data->question38)?'checked':'':'') ?>> Budaya</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item6", $data->question38)?'checked':'':'') ?>> Emosional</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("item7", $data->question38)?'checked':'':'') ?>> Bahasa</label> 
                <label><input type="checkbox" <?= (isset($data->question38)?in_array("other", $data->question38)?'checked':'':'') ?>> Lainnya</label>: .............</p>
                <p><b> Dibutuhkan penerjemah:</b> 
                    <label><input type="checkbox" <?php echo isset($data->question39)? $data->question39 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question39)? $data->question39 == "other" ? "checked":'':'' ?>> Ya</label>, Sebutkan: .............
                </p>
                <p><b> Bahasa Isyarat:</b> 
                    <label><input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "item1" ? "checked":'':'' ?>> Tidak</label> 
                    <label><input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "other" ? "checked":'':'' ?>> Ya</label>
                </p>
                
                <p><b>Kebutuhan edukasi (pilih topik edukasi pada kotak yang tersedia):</b></p>
                <p>
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("item1", $data->question41)?'checked':'':'') ?>> Diagnosa dan Manajemen Penyakit</label>
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("item2", $data->question41)?'checked':'':'') ?>> Obat-obatan / Terapi</label>
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("item3", $data->question41)?'checked':'':'') ?>> Diet dan Nutrisi</label>
                </p>
                <p>
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("item4", $data->question41)?'checked':'':'') ?>> Tindakan Keperawatan</label> .............
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("item5", $data->question41)?'checked':'':'') ?>> Rehabilitasi</label>
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("item6", $data->question41)?'checked':'':'') ?>> Manajemen Nyeri</label>
                </p>
                <p>
                    <label><input type="checkbox" <?= (isset($data->question41)?in_array("other", $data->question41)?'checked':'':'') ?>> Lain-lain, Sebutkan</label>: .............
                </p>
                <h3>7. RESIKO CEDERA JATUH (isi formulir monitoring pencegahan jatuh)</h3>
                <p><input type="checkbox" <?php echo isset($data->question42)? $data->question42 == "item1" ? "checked":'':'' ?>>Tidak 
                <input type="checkbox" <?php echo isset($data->question42)? $data->question42 == "item2" ? "checked":'':'' ?>>Ya, JikaYa, gelang resiko jatuh warna kuning harus dipasang.</p>
                <h3>8. STATUS FUNGSIONAL ( Isi Formulir Barthel Index)</h3>
                <p>Aktivitas dan Mobilisasi : 
                    <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "item1" ? "checked":'':'' ?>>Mandiri 
                    <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "other" ? "checked":'':'' ?>>Perlu bantuan, sebutkan <?= isset($data->question44)?$data->question44:'' ?>
                </p>
                <p><b>Bila terdapat gangguan fungsional, pasien di konsul ke Rehabilitasi Medis melalui DPJP</b></p>
                <p>Nyeri / tidak nyaman :
                    <input type="checkbox" <?php echo isset($data->question44)? $data->question44 == "item1" ? "checked":'':'' ?>>Tidak
                    <input type="checkbox" <?php echo isset($data->question44)? $data->question44 == "item2" ? "checked":'':'' ?>>Ya 
                </p>
                        <p><img src="<?= base_url("assets/img/skala nyer.jpg"); ?>" alt="img" height="150px" width="300px"><img src="<?= base_url("assets/img/nyeri.png"); ?>" alt="img" height="150px" width="300px"></p>
                        <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item1" ? "checked":'':'' ?>>Nyeri Kronis,  Lokasi : <?= isset($data->question48->text1)?$data->question48->text1:'' ?> Frekuensi : <?= isset($data->question48->text2)?$data->question48->text2:'' ?> Durasi :<?= isset($data->question48->text3)?$data->question48->text3:'' ?></p>
                        <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item2" ? "checked":'':'' ?>>Nyeri Akut,  Lokasi : <?= isset($data->question48->text1)?$data->question48->text1:'' ?> Frekuensi : <?= isset($data->question48->text2)?$data->question48->text2:'' ?> Durasi :<?= isset($data->question48->text3)?$data->question48->text3:'' ?></p>
                        <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item3" ? "checked":'':'' ?>>Skor nyeri (0-10): <?= isset($data->question49)?$data->question49:'' ?></p>
                        <p>Nyeri hilang :</p>
                        <p><input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item1" ? "checked":'':'' ?>>Minum obat 
                         <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item2" ? "checked":'':'' ?>> Istirahat 
                          <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item3" ? "checked":'':'' ?>> Mendengar musik  
                          <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item4" ? "checked":'':'' ?>>Berubah posisi  
                          <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "other" ? "checked":'':'' ?>> Lain lain , sebutkan.......................................</p>
                        
            </td>
            
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.c2/RI
            </div>
        </div>
    </div>
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
                    <td colspan="2" style="font-size:10px;font-style:italic">
                        <span>Jl. Lintas Sumatera, Km. 110</span><br>
                        <span>Tanah Badantung-Kab. Sijunjung</span>
                    </td>
                </tr>
            </table>
        </td>

        <td width="40%" style="vertical-align:middle">
            <center>
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP OBSTETRI DAN GINEKOLOGI</h3>
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
            <td colspan="2">(Diisi oleh Bidan)</td>
            <td >Halaman 4 dari 4</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                 <h3>10. NUTRISI</h3>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>No</td>
                        <td>Parameter</td>
                        <td>Penilaian</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Apakah asupan makan berkurang karena nafsu makan berkurang?</td>
                        <td>
                            <input type="checkbox" <?php echo isset($data->question51->item1->column1)? $data->question51->item1->column1 == "item1" ? "checked":'':'' ?>>Ya  
                            <input type="checkbox" <?php echo isset($data->question51->item1->column1)? $data->question51->item1->column1 == "item2" ? "checked":'':'' ?>>Tidak
                        </td>
                    </tr>  
                    <tr>
                        <td>2</td>
                        <td>Ada gangguan metabolism (DM, gangguan fungsi tiroid, infeksi kronis, <br>lain-lain (sebutkan) ........................)</td>
                        <td>
                            <input type="checkbox" <?php echo isset($data->question51->item2->column1)? $data->question51->item2->column1 == "item1" ? "checked":'':'' ?>>Ya  
                            <input type="checkbox" <?php echo isset($data->question51->item2->column1)? $data->question51->item2->column1 == "item2" ? "checked":'':'' ?>>Tidak
                        </td>
                    </tr>  
                    <tr>
                        <td>3</td>
                        <td>Ada pertambahan berat badan yang kurang atau lebih sesuai usia kehamilan</td>
                        <td>
                            <input type="checkbox" <?php echo isset($data->question51->item3->column1)? $data->question51->item3->column1 == "item1" ? "checked":'':'' ?>>Ya  
                            <input type="checkbox" <?php echo isset($data->question51->item3->column1)? $data->question51->item3->column1 == "item2" ? "checked":'':'' ?>>Tidak
                        </td>
                    </tr>  
                    <tr>
                        <td>4</td>
                        <td>Nilai Hb< 10b g/dl atau HCT < 30%</td>
                        <td>
                            <input type="checkbox" <?php echo isset($data->question51->item4->column1)? $data->question51->item4->column1 == "item1" ? "checked":'':'' ?>>Ya  
                            <input type="checkbox" <?php echo isset($data->question51->item4->column1)? $data->question51->item4->column1 == "item2" ? "checked":'':'' ?>>Tidak
                        </td>
                    </tr>  
                </table>
                <p><b>Bila jawabanya ≥ 1  dilaporkan kepada Tim Terapi Gizi. Tgl : <?= isset($data->question52)?date('d/m/Y',strtotime($data->question52)):'' ?> Jam: <?= isset($data->question52)?date('h:i',strtotime($data->question52)):'' ?></b></p>
                <p><input type="checkbox" <?= (isset($data->question53)?in_array("item1", $data->question53)?'checked':'':'') ?>>Untuk pasien dengan masalah Ginekologi /Onkologi :                </p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>No</td>
                        <td>Parameter</td>
                        <td>Skor</td>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td colspan="2">Apakah pasien mengalami penurunan berat badan yang tidak diinginkan dalam 6 bulan terakhir?</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "0" ? "bg-checked" : "" : "" ?> ">a. Tidak penurunan berat badan</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "0" ? "bg-checked" : "" : "" ?> ">0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "2" ? "bg-checked" : "" : "" ?> ">b. Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "2" ? "bg-checked" : "" : "" ?> ">2</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2">c. Jika ya, berapa penurunan berat badan tersebut</td>
                        
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "1" ? "bg-checked" : "" : "" ?> ">1-5       kg</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "1" ? "bg-checked" : "" : "" ?> ">1</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "2" ? "bg-checked" : "" : "" ?> ">6-10     kg</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "2" ? "bg-checked" : "" : "" ?> ">2</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "3" ? "bg-checked" : "" : "" ?> ">11-15  kg</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "3" ? "bg-checked" : "" : "" ?> ">3</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "4" ? "bg-checked" : "" : "" ?> ">>15      kg</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "4" ? "bg-checked" : "" : "" ?> ">4</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "2" ? "bg-checked" : "" : "" ?> ">Tidak yakin penurunannya</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_1) ? $data->skrining->skor->skrining_gizi_1 == "2" ? "bg-checked" : "" : "" ?> ">2</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td colspan="2">Apakah asupan makan berkurang karena berkurangnya nafsu makan?</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_2) ? $data->skrining->skor->skrining_gizi_2 == "0" ? "bg-checked" : "" : "" ?> ">a. Tidak</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_2) ? $data->skrining->skor->skrining_gizi_2 == "0" ? "bg-checked" : "" : "" ?> ">0</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_2) ? $data->skrining->skor->skrining_gizi_2 == "1" ? "bg-checked" : "" : "" ?> ">b. Ya</td>
                        <td class="<?= isset($data->skrining->skor->skrining_gizi_2) ? $data->skrining->skor->skrining_gizi_2 == "1" ? "bg-checked" : "" : "" ?> ">1</td>
                    </tr>
                    <tr>
                        <td colspan="2">Total skor</td>
                        <td><?= isset($data->skrining->skor->total_skor)?$data->skrining->skor->total_skor:'' ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td colspan="3"> Pasien dengan diagnosa khusus 
                            <input type="checkbox" <?php echo isset($data->question54)? $data->question54 == "item1" ? "checked":'':'' ?>>Tidak  
                            <input type="checkbox" <?php echo isset($data->question54)? $data->question54 == "item2" ? "checked":'':'' ?>>Ya ( 
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item1", $data->question55)?'checked':'':'') ?>>DM  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item2", $data->question55)?'checked':'':'') ?>>Ginjal  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item3", $data->question55)?'checked':'':'') ?>>Hati  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item4", $data->question55)?'checked':'':'') ?>>jantung  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item5", $data->question55)?'checked':'':'') ?>> paru  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item6", $data->question55)?'checked':'':'') ?>> stroke  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item7", $data->question55)?'checked':'':'') ?>>kanker  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item8", $data->question55)?'checked':'':'') ?>>penurunan imunitas
                                <input type="checkbox" <?= (isset($data->question55)?in_array("item9", $data->question55)?'checked':'':'') ?>>geriatri  
                                <input type="checkbox" <?= (isset($data->question55)?in_array("other", $data->question55)?'checked':'':'') ?>> lainnya.................)
                        </td>
                    </tr>
                </table>
                <p><b>Bila skor ≥2 dan atau pasien dengan diagnosis/kondisi khusus dilakukan pengkajian lanjut oleh Tim Terapi Gizi</b></p>
                <p>Sudah dilaporkan ke Tim Terapi Gizi: 
                    <input type="checkbox" <?php echo isset($data->question66)? $data->question66 == "item1" ? "checked":'':'' ?>>Tidak  
                    <input type="checkbox" <?php echo isset($data->question66)? $data->question66 == "item2" ? "checked":'':'' ?>>Ya, Tanggal & jam <?= isset($data->question67)?date('d/m/Y h:i',strtotime($data->question67)):'' ?></p>
                <p><b>DAFTAR MASALAH KEBIDANAN                </b></p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>MASALAH KEBIDANAN</td>
                        <td>TUJUAN / TARGET TERUKUR</td>
                    </tr>
                    <?php 
                    if(isset($data->question68)){
                        foreach($data->question68 as $val){ ?>
                    <tr>
                        <td><?= isset($val->column1)?$val->column1:'' ?></td>
                        <td><?= isset($val->column2)?$val->column2:'' ?></td>
                    </tr>
                        

                    <?php }}else{ ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php }
                    ?>
                    

                </table>
                <p><input type="checkbox" <?= (isset($data->question69)?in_array("item1", $data->question69)?'checked':'':'') ?>>Disusun Rencana Kebidanan</p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;"><?= isset($data->question70)?date('d/m/Y h:i',strtotime($data->question70)):'' ?></p>
                                <p style="margin: 5px 0;">Bidan yang melakukan Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="60px" style="text-align:center" src="<?= isset($data->question72)?$data->question72:'' ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question74)?$data->question74:'' ?></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;"><?= isset($data->question71)?date('d/m/Y h:i',strtotime($data->question71)):'' ?></p>
                                <p style="margin: 5px 0;">Bidan yang melengkapi Pengkajian</p>
                                <p style="margin: 5px 0;"><img width="60px" style="text-align:center" src="<?= isset($data->question73)?$data->question73:'' ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question75)?$data->question75:'' ?></p>
                            </div>
                        </div>
                
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06/RI
            </div>
        </div>
    </div>
    </div>
    
</body>
                