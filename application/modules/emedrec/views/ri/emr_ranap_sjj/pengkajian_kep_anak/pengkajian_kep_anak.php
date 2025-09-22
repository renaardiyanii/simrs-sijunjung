<?php 
$data = isset($kep_anak->formjson)?json_decode($kep_anak->formjson):'';
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
                <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 1 dari 6</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="0" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>Tanggal : <?= isset($data->question1)?date('d/m/Y',strtotime($data->question1)):'' ?></td>
                        <td>Jam : <?= isset($data->question1)?date('h:i',strtotime($data->question1)):'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Sumber data :     <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item1" ? "checked":'':'' ?>> Pasien 
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "item2" ? "checked":'':'' ?>> Keluarga, hubungan : <span class="input-line"></span>
                        <input type="checkbox" <?php echo isset($data->question2)? $data->question2 == "other" ? "checked":'':'' ?>> Lainnya, <?= isset($data->{'question2-Comment'})?$data->{'question2-Comment'}:'' ?> <span class="input-line"></span></td>
                    </tr>
                    <tr>
                        <td colspan="2">Rujukan :  <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item1" ? "checked":'':'' ?>> Tidak   <input type="checkbox"  <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item2" ? "checked":'':'' ?>>Ya  <input type="checkbox"  <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item1" ? "checked":'':'' ?>>RS…………………………………………… <input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item2" ? "checked":'':'' ?> >Puskesmas………<input type="checkbox" <?php echo isset($data->question4)? $data->question4 == "item3" ? "checked":'':'' ?>>Dokter……… </td>
                    </tr>
                    <tr>
                        <td colspan="2">Diagnosa Rujukan : <?= isset($data->question5)?$data->question5:'' ?></td>
                    </tr>
                </table>
                <p><b>1. IDENTITAS </b></p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                <table border="0" cellpadding="5px" style="width: 48%; border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">NAMA AYAH</td>
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
                       <td><?= isset($data->question6->text2)?$data->question6->text2:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                       <td><?= isset($data->question6->text3)?$data->question6->text3:'' ?></td>
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
                       <td><?= isset($data->question6->text8)?$data->question6->text8:'' ?></td>
                    </tr>
                </table>

                <table border="0" cellpadding="5px" style="width: 48%; border-collapse: collapse;">
                    <tr>
                        <td colspan="2" style="font-weight: bold;">NAMA IBU</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%">Nama</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question56[0]->column1)?$data->question56[0]->column1:'' ?></td>
                    </tr>
                    <tr><td>Tgl. Lahir</td><td>:</td><td></td></tr>
                    <tr>
                        <td width="18%">Pendidikan</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question56[0]->column2)?$data->question56[0]->column2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="18%">Pekerjaan</td>
                        <td width="2%">:</td>
                        <td><?= isset($data->question56[0]->column4)?$data->question56[0]->column4:'' ?></td>
                    </tr>
                    <tr>
                        <td width="18%">Agama</td>
                        <td width="2%">:</td>
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
                        <td>Perkawinan Ke</td>
                        <td>:</td>
                       <td><?= isset($data->question56[0]->column8)?$data->question56[0]->column8:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Peserta KB</td>
                        <td>: <input type="checkbox" <?= (isset($data->question56[0]->column9)?in_array("item1", $data->question56[0]->column9)?'checked':'':'') ?>>AKDR  
                        <input type="checkbox" <?= (isset($data->question56[0]->column9)?in_array("item2", $data->question56[0]->column9)?'checked':'':'') ?>>Suntik 
                        <input type="checkbox" <?= (isset($data->question56[0]->column9)?in_array("item3", $data->question56[0]->column9)?'checked':'':'') ?>>Susuk 
                        <input type="checkbox" <?= (isset($data->question56[0]->column9)?in_array("item4", $data->question56[0]->column9)?'checked':'':'') ?>>Pill 
                        <input type="checkbox" <?= (isset($data->question56[0]->column9)?in_array("item5", $data->question56[0]->column9)?'checked':'':'') ?>>Kondom 
                        <input type="checkbox" <?= (isset($data->question56[0]->column9)?in_array("other", $data->question56[0]->column9)?'checked':'':'') ?>>Lainnya..........</td>
                    </tr>
                </table>

            </div>            
                <p style="font-weight: bold;">2. PEMERIKSAAN FISIK</p>
                <p>BB: <span><?= isset($data->question8->text1)?$data->question8->text1:'.......' ?></span> kg  
                TB: <span><?= isset($data->question8->text2)?$data->question8->text2:'.......' ?></span> cm 
                LK: <span><?= isset($data->question8->text3)?$data->question8->text3:'.......' ?></span> cm  <br> <br>
                Tekanan darah: <span><?= isset($data->question8->text4)?$data->question8->text4:'.......' ?></span> mmHg  
                Nadi: <span><?= isset($data->question8->text5)?$data->question8->text5:'.......' ?></span> x/mnt  
                Pernafasan: <span><?= isset($data->question8->text6)?$data->question8->text6:'.......' ?></span> x/mnt 
                Suhu: <span><?= isset($data->question8->text7)?$data->question8->text7:'.......' ?></span> C
                </p>
                <h3>3. RIWAYAT KESEHATAN</h3>
                <p>Tempat: <?= isset($data->question9->text1)?$data->question9->text1:'.......' ?> BB saat lahir: <?= isset($data->question9->text2)?$data->question9->text2:'.......' ?></p>
                <p>Partus: <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item1" ? "checked":'':'' ?>> Spontan 
                <input type="checkbox" <?php echo isset($data->question10)? $data->question10 == "item2" ? "checked":'':'' ?>> Tindakan</p>
                <p>Anak ke: <?= isset($data->question12->text1)?$data->question12->text1:'.......' ?> Anak pungut sejak: <?= isset($data->question12->text2)?$data->question12->text2:'.......' ?></p>
                <p>Imunisasi: <?= isset($data->question12->text3)?$data->question12->text3:'.......' ?></p>
                
                <p>Riwayat Penyakit dahulu: <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item1" ? "checked":'':'' ?>> Tidak 
                <input type="checkbox" <?php echo isset($data->question13)? $data->question13 == "item2" ? "checked":'':'' ?>> Ya, Penyakit <?= isset($data->{'question13-Comment'})?$data->{'question13-Comment'}:'' ?></p>
                <p>Pernah dirawat: 
                    <input type="checkbox"> Tidak 
                    <input type="checkbox"> Ya, Diagnosa .......................... Kapan: .......................... Di: ..........................</p>
                <p>Pernah dioperasi: 
                    <input type="checkbox" <?php echo isset($data->question14)? $data->question14 == "item1" ? "checked":'':'' ?>> Tidak 
                    <input type="checkbox" <?php echo isset($data->question14)? $data->question14 == "item2" ? "checked":'':'' ?>> Ya, Jenis Operasi <?= isset($data->question15->text2)?$data->question15->text2:'' ?> Kapan: <?= isset($data->question15->text2)?$data->question15->text2:'' ?></p>
                <p>Masih dalam pengobatan: 
                    <input type="checkbox" <?php echo isset($data->question57)? $data->question57 == "item1" ? "checked":'':'' ?>> Tidak 
                    <input type="checkbox" <?php echo isset($data->question57)? $data->question57 == "item2" ? "checked":'':'' ?>> Ya, Obat <?= isset($data->question59->text1)?$data->question59->text1:'' ?></p>
                
                <h4>Riwayat penyakit keluarga:</h4>
                <p><input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item1" ? "checked":'':'' ?>> Tidak 
                <input type="checkbox" <?php echo isset($data->question16)? $data->question16 == "item2" ? "checked":'':'' ?>> Ya ( 
                    <input type="checkbox" <?= (isset($data->question17)?in_array("item1", $data->question17)?'checked':'':'') ?>> Hipertensi 
                    <input type="checkbox" <?= (isset($data->question17)?in_array("item2", $data->question17)?'checked':'':'') ?>> Jantung 
                    <input type="checkbox" <?= (isset($data->question17)?in_array("item3", $data->question17)?'checked':'':'') ?>> Paru 
                    <input type="checkbox" <?= (isset($data->question17)?in_array("item4", $data->question17)?'checked':'':'') ?>> DM 
                    <input type="checkbox" <?= (isset($data->question17)?in_array("item5", $data->question17)?'checked':'':'') ?>> Ginjal 
                    <input type="checkbox" <?= (isset($data->question17)?in_array("other", $data->question17)?'checked':'':'') ?>> Lainnya <?= isset($data->{'question17-Comment'})?$data->{'question17-Comment'}:'' ?> )</p>
                
                <h4>Kecanduan terhadap:</h4>
                <p><input type="checkbox" <?php echo isset($data->question60)? $data->question60 == "item1" ? "checked":'':'' ?>> Tidak 
                <input type="checkbox" <?php echo isset($data->question60)? $data->question60 == "item2" ? "checked":'':'' ?>> Ya, Jika Ya: 
                <input type="checkbox" <?= (isset($data->question61)?in_array("item1", $data->question61)?'checked':'':'') ?>> Obat-obatan 
                <input type="checkbox" <?= (isset($data->question61)?in_array("item2", $data->question61)?'checked':'':'') ?>> Rokok 
                <input type="checkbox" <?= (isset($data->question61)?in_array("item3", $data->question61)?'checked':'':'') ?>> Alkohol 
                <input type="checkbox" <?= (isset($data->question61)?in_array("other", $data->question61)?'checked':'':'') ?>> Lainnya <?= isset($data->{'question60-Comment'})?$data->{'question60-Comment'}:'' ?></p>
                
                <h4>Riwayat Alergi:</h4>
                <p><input type="checkbox" <?php echo isset($data->question62)? $data->question62 == "item1" ? "checked":'':'' ?>> Tidak <input type="checkbox" <?php echo isset($data->question62)? $data->question62 == "item2" ? "checked":'':'' ?>> Ya: 
                <input type="checkbox" <?= (isset($data->question63)?in_array("item1", $data->question63)?'checked':'':'') ?>> Obat .......................... 
                <input type="checkbox" <?= (isset($data->question63)?in_array("item2", $data->question63)?'checked':'':'') ?>> Makanan .......................... 
                <input type="checkbox" <?= (isset($data->question63)?in_array("other", $data->question63)?'checked':'':'') ?>> Lainnya <?= isset($data->{'question63-Comment'})?$data->{'question63-Comment'}:'' ?></p>
                <p>Reaksi: <?= isset($data->question64)?$data->question64:'' ?></p>
                 

              
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.b2/RI
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
             <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 2 dari 6</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p style="font-weight: bold;">4. RIWAYAT PSIKOSOSIAL DAN SPIRITUAL</p>
                <p>a. Status Psikologis</p>
                <p style="margin: 5px 0;">Anak kandung 
                    <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question23)? $data->question23 == "item2" ? "checked":'':'' ?>> Ya  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    Penelantaran fisik / mental   <input type="checkbox" <?php echo isset($data->question18)? $data->question18 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question18)? $data->question18 == "item2" ? "checked":'':'' ?>> Ya   
                </p>
                <p style="margin: 5px 0;">Penurunan prestasi sekolah
                    <input type="checkbox" <?php echo isset($data->question19)? $data->question19 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question19)? $data->question19 == "item2" ? "checked":'':'' ?>> Ya  &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;
                     Gangguan tumbuh kembang <input type="checkbox" <?php echo isset($data->question20)? $data->question20 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question20)? $data->question20 == "item2" ? "checked":'':'' ?>> Ya  
                </p>
                
                <p style="margin: 5px 0;">Kekerasan fisik
                    <input type="checkbox" <?php echo isset($data->question21)? $data->question21 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question21)? $data->question21 == "other" ? "checked":'':'' ?>> Ya  
                </p>
                <p><b>Bila terdapat masalah psikologis, pasien dikonsultasikan ke psikiater/psikolog melalui DPJP  </b></p>
                <p>b. Status Sosial</p>
                <p style="margin: 5px 0;">Saudara
                    <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item1" ? "checked":'':'' ?>> Kandung, jumlah <?= isset($data->question25)?$data->question25:'' ?> orang  
                    <input type="checkbox" <?php echo isset($data->question24)? $data->question24 == "item2" ? "checked":'':'' ?>> Tiri, jumlah : <?= isset($data->question25)?$data->question25:'' ?> orang  
                </p>
                <p style="margin: 5px 0;">Tinggal bersama
                    <input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "item1" ? "checked":'':'' ?>> orangtua
                    <input type="checkbox" <?php echo isset($data->question26)? $data->question26 == "other" ? "checked":'':'' ?>>lainnya  &nbsp;&nbsp;&nbsp;&nbsp;
                    Nama : <?= isset($data->question27->text1)?$data->question27->text1:'' ?> No Telp : <?= isset($data->question27->text2)?$data->question27->text2:'' ?>
                </p>
                <p style="margin: 5px 0;">Pendidikan saat ini
                    <input type="checkbox" <?php echo isset($data->question28)? $data->question28 == "item1" ? "checked":'':'' ?>> belum sekola
                    <input type="checkbox" <?php echo isset($data->question28)? $data->question28 == "item2" ? "checked":'':'' ?>> SD  
                    <input type="checkbox" <?php echo isset($data->question28)? $data->question28 == "item3" ? "checked":'':'' ?>> SMP
                    <input type="checkbox" <?php echo isset($data->question28)? $data->question28 == "item4" ? "checked":'':'' ?>> SMA / SMK    
                </p>
                <P>c. Spiritual</P>
                <p>Kegiatan keagamaan yang biasa dilakukan (untuk usia >6 tahun) : <?= isset($data->question29->text1)?$data->question29->text1:'' ?></p>

                <p style="font-weight: bold;">5. KEBUTUHAN KOMUNIKASI & EDUKASI</p>

                <p style="margin: 5px 0;">Edukasi Diberikan Kepada :  
                    <input type="checkbox" <?php echo isset($data->question30)? $data->question30 == "other" ? "checked":'':'' ?>> Orang Tua  
                    <input type="checkbox" <?php echo isset($data->question30)? $data->question30 == "item2" ? "checked":'':'' ?>> Keluarga (Hubungan Dengan Pasien <span><?= isset($data->question31)?$data->question31:'' ?></span>)  
                </p>

                <p style="margin: 5px 0;">Bicara :  
                    <input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item1" ? "checked":'':'' ?>> Normal  
                    <input type="checkbox" <?php echo isset($data->question32)? $data->question32 == "item2" ? "checked":'':'' ?>> Serangan Awal Gangguan Bicara, Kapan <span><?= isset($data->question33)?$data->question33:'' ?></span>  
                </p>

                <p style="margin: 5px 0;">Bahasa Sehari-Hari :  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item1" ? "checked":'':'' ?>> Indonesia, Aktif / Pasif  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item3" ? "checked":'':'' ?>> Daerah, Jelaskan <span>.......................</span>  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "item2" ? "checked":'':'' ?>> Inggris, Aktif / Pasif  
                    <input type="checkbox" <?php echo isset($data->question34)? $data->question34 == "other" ? "checked":'':'' ?>> Lain – Lain, Jelaskan <span>.......................</span>  
                </p>

                <p style="margin: 5px 0;">Perlu Penterjemah :  
                    <input type="checkbox" <?php echo isset($data->question35)? $data->question35 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question35)? $data->question35 == "item2" ? "checked":'':'' ?>> Ya, Bahasa <span>.......................</span>  
                    Bahasa Isyarat:  
                    <input type="checkbox" <?php echo isset($data->question36)? $data->question36 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question36)? $data->question36 == "item2" ? "checked":'':'' ?>> Ya  
                </p>

                <p style="font-weight: bold;">Hambatan Edukasi</p>

                <p style="margin: 5px 0;">
                    <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item1" ? "checked":'':'' ?>> Tidak Ditemukan Hambatan  
                </p>

                <p style="margin: 5px 0;"> <input type="checkbox" <?php echo isset($data->question37)? $data->question37 == "item2" ? "checked":'':'' ?>>Ada Hambatan:</p>

                <p style="margin-left: 20px;">
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item1", $data->question39)?'checked':'':'') ?>> Bahasa  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item5", $data->question39)?'checked':'':'') ?>> Pendengaran  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item7", $data->question39)?'checked':'':'') ?>> Hilang memori  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item9", $data->question39)?'checked':'':'') ?>> Motivasi buruk  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item11", $data->question39)?'checked':'':'') ?>> Masalah penglihatan  
                </p>

                <p style="margin-left: 20px;">
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item2", $data->question39)?'checked':'':'') ?>> Cemas  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item6", $data->question39)?'checked':'':'') ?>> Emosi  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item8", $data->question39)?'checked':'':'') ?>> Kesulitan bicara  
                    <input type="checkbox" > Tidak ada partisipasi dari caregiver  
                    <input type="checkbox" <?= (isset($data->question39)?in_array("item12", $data->question39)?'checked':'':'') ?>> Secara fisiologi tidak mampu belajar  
                </p>

                <p style="margin: 5px 0;"><b>Kebutuhan Edukasi : </b> 
                    <input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "item1" ? "checked":'':'' ?>> Proses Penyakit  
                    <input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "item3" ? "checked":'':'' ?>> Pengobatan/Tindakan  
                    <input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "item2" ? "checked":'':'' ?>> Terapi/Obat  
                    <input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "item4" ? "checked":'':'' ?>> Nutrisi  
                    <input type="checkbox" > Support/Psikolog  
                    <input type="checkbox" <?php echo isset($data->question40)? $data->question40 == "other" ? "checked":'':'' ?>> Lainnya, Jelaskan <span>.......................</span>  
                </p>

                <p style="font-weight: bold;">Bersedia untuk dikunjungi <input type="checkbox" <?php echo isset($data->question41)? $data->question41 == "item1" ? "checked":'':'' ?>> Tidak  
                    <input type="checkbox" <?php echo isset($data->question41)? $data->question41 == "item2" ? "checked":'':'' ?>> Ya (  
                    <input type="checkbox" <?php echo isset($data->question42)? $data->question42 == "item1" ? "checked":'':'' ?>> keluarga
                    <input type="checkbox" <?php echo isset($data->question42)? $data->question42 == "item2" ? "checked":'':'' ?>> kerabat  
                    <input type="checkbox" <?php echo isset($data->question42)? $data->question42 == "item3" ? "checked":'':'' ?>> rohaniawan  )</p>

               
                <p style="font-weight: bold;">6. SKALA NYERI METODE FLACC SCALE (diisi oleh perawat khusus usia 2 bulan - 7 tahun)
                </p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td rowspan="2">Kategori</td>
                        <td colspan="3"><center>Score</center></td>
                        <td rowspan="2">Nilai Score</td>
                    </tr>
                    <tr>
                        <td><center>0</center></td>
                        <td><center>1</center></td>
                        <td><center>2</center></td>
                    </tr>
                    <tr>
                        <td>Face (Wajah)</td>
                        <td>Tidak ada ekspresi khusus, senyum</td>
                        <td>Menyeringai, mengerutkan dahi, tampak tidak tertarik (kadang-kadang) </td>
                        <td>Dagu gemetar, gerutu berulang (sering)</td>
                        <td><?= isset($data->table_assesment_nyeri->result->{'1'})?$data->table_assesment_nyeri->result->{'1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Leg (Kaki)</td>
                        <td>Tidak adaPosisi normal atau santai</td>
                        <td>Gelisah, tegang</td>
                        <td>Dagu gemetar, gerutu beruMenendang, kaki tertekuk</td>
                        <td><?= isset($data->table_assesment_nyeri->result->{'2'})?$data->table_assesment_nyeri->result->{'2'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Activity (Aktivitas)</td>
                        <td>Berbaring tenang, posisi normal, gerakan mudah</td>
                        <td>Menggeliat, tidak bisa diam, tegang</td>
                        <td>Kaku atau tegan</td>
                        <td><?= isset($data->table_assesment_nyeri->result->{'3'})?$data->table_assesment_nyeri->result->{'3'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Cry (Menangis)</td>
                        <td>Tidak menangis</td>
                        <td>Merintih, merengek, kadang-kadang mengeluh</td>
                        <td>Terus menangis, berteriak</td>
                        <td><?= isset($data->table_assesment_nyeri->result->{'4'})?$data->table_assesment_nyeri->result->{'4'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Consolability (Kemampuan Consol)/td>
                        <td>rileks</td>
                        <td>Dapat ditenangkan dengan sentuhan, pelukan, bujukan, dapat dialihkan</td>
                        <td>Sering mengeluh, sulit dibujuk</td>
                        <td><?= isset($data->table_assesment_nyeri->result->{'5'})?$data->table_assesment_nyeri->result->{'5'}:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Total score</td>
                        <td><?= isset($data->table_assesment_nyeri->result->total_skor)?$data->table_assesment_nyeri->result->total_skor:'' ?></td>
                    </tr>
                </table>

            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.b2/RI
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
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 3 dari 6</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                        <p style="font-weight:bold;margin-left:10px">
                            <span>Bila usia diatas 7 tahun menggunakan Numeric Scale (lihat panduan pengkajian nyeri)                            <span>    
                        </p>
                        <p>Nyeri / tidak nyaman :<input type="checkbox" <?php echo isset($data->question44)? $data->question44 == "item1" ? "checked":'':'' ?>>Tidak
                        <input type="checkbox" <?php echo isset($data->question44)? $data->question44 == "item2" ? "checked":'':'' ?>>Ya </p>
                        <p><img src="<?= base_url("assets/img/skala nyer.jpg"); ?>" alt="img" height="150px" width="300px"><img src="<?= base_url("assets/img/nyeri.png"); ?>" alt="img" height="150px" width="300px"></p>
                        <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item1" ? "checked":'':'' ?>>Nyeri Kronis,  Lokasi : <?= isset($data->question48->text1)?$data->question48->text1:'.............' ?> Frekuensi : <?= isset($data->question48->text2)?$data->question48->text2:'.............' ?> Durasi : <?= isset($data->question48->text3)?$data->question48->text3:'.............' ?></p>
                        <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item2" ? "checked":'':'' ?>>Nyeri Akut,  Lokasi : <?= isset($data->question48->text1)?$data->question48->text1:'.............' ?> Frekuensi : <?= isset($data->question48->text2)?$data->question48->text2:'.............' ?> Durasi : <?= isset($data->question48->text3)?$data->question48->text3:'.............' ?></p>
                        <p><input type="checkbox" <?php echo isset($data->question47)? $data->question47 == "item3" ? "checked":'':'' ?>>Skor nyeri (0-10): <?= isset($data->question49)?$data->question49:'.............' ?></p>
                        <p>Nyeri hilang :</p>
                        <p><input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item1" ? "checked":'':'' ?>>Minum obat  
                        <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item2" ? "checked":'':'' ?>> Istirahat  
                        <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item3" ? "checked":'':'' ?>> Mendengar musik  
                        <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "item4" ? "checked":'':'' ?>>Berubah posisi  
                        <input type="checkbox" <?php echo isset($data->question50)? $data->question50 == "other" ? "checked":'':'' ?>> Lain lain , sebutkan.......................................</p>
                        <p style="font-weight: bold;">7. SKRINING GIZI ANAK (Berdasarkan metode strong kids) <br>(Lingkari skor sesuai dengan jawaban, total skor adalah jumlah skor yang dilingkari)
                        </p>
                        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                            <tr>
                                <td>NO</td>
                                <td>PARAMETER</td>
                                <td>SKOR</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>apakah ppasien tampak kurus ?</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'1'}) ? $data->table_risiko_nutrisional->result->{'1'} == "0" ? "bg-checked" : "" : "" ?> ">>a. tidak</td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'1'}) ? $data->table_risiko_nutrisional->result->{'1'} == "0" ? "bg-checked" : "" : "" ?> ">>0</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'1'}) ? $data->table_risiko_nutrisional->result->{'1'} == "1" ? "bg-checked" : "" : "" ?> ">b. ya</td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'1'}) ? $data->table_risiko_nutrisional->result->{'1'} == "1" ? "bg-checked" : "" : "" ?> ">1</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td colspan="2">Apakah terdapat penyakit atau keadaan berikut yang mengakibatkan pasien berisiko mengalami malnutrisi ?                                 </td>
                                
                            </tr>
                            <tr>
                                <td></td>
                               <td>
                                <ul>
                                    <li>Diare kronik (lebih dari 2 minggu)</li>
                                    <li>Penyakit Jantung Bawaan</li>
                                    <li>Infeksi Human Immunodeficiency Virus (HIV)</li>
                                    <li>Kanker</li>
                                    <li>Penyakit hati kronik                                    </li>
                                    <li>Penyakit Ginjal kronik</li>
                                    <li>TB Paru</li>
                                    <li>Luka bakar luas</li>
                                    <li>Lain-lain (berdasarkan pertimbangan dokter) ……………                                    </li>
                                </ul>
                               </td>
                                <td>
                                <ul>
                                    <li>Kelainan anatomi daerah mulut yang menyebabkan kesulitan makan (misal: bibir sumbing)                                    </li>
                                    <li>Trauma                                    </li>
                                    <li>Kelainan metabolik bawaan                                     </li>
                                    <li>Retardasi mental</li>
                                    <li>Keterlambatan perkembangan                                   </li>
                                    <li>Rencana/paskaoperasi mayor (misal: laparotomi, Torakotomi)</li>
                                    <li>Terpasang stoma</li>
                                </ul>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'2'}) ? $data->table_risiko_nutrisional->result->{'2'} == "0" ? "bg-checked" : "" : "" ?> ">a. Tidak </td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'2'}) ? $data->table_risiko_nutrisional->result->{'2'} == "0" ? "bg-checked" : "" : "" ?> ">0</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'2'}) ? $data->table_risiko_nutrisional->result->{'2'} == "2" ? "bg-checked" : "" : "" ?> ">b. Ya</td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'2'}) ? $data->table_risiko_nutrisional->result->{'2'} == "2" ? "bg-checked" : "" : "" ?> ">2</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td colspan="2">Apakah terdapat salah satu dari kondisi berikut? <br>
                                - Diare ≥ 5 kali/hari dan atau muntah> 3 kali/hari dalam seminggu terakhir
                                <br>Asupan makanan berkurang selama 1 minggu terakhir
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'3'}) ? $data->table_risiko_nutrisional->result->{'3'} == "0" ? "bg-checked" : "" : "" ?> ">a. Tidak </td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'3'}) ? $data->table_risiko_nutrisional->result->{'3'} == "0" ? "bg-checked" : "" : "" ?> ">0</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'3'}) ? $data->table_risiko_nutrisional->result->{'3'} == "1" ? "bg-checked" : "" : "" ?> ">b. Ya</td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'3'}) ? $data->table_risiko_nutrisional->result->{'3'} == "1" ? "bg-checked" : "" : "" ?> ">1</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td colspan="2">Apakah terdapat penurunan berat badan atau tidak ada penambahan berat badan      (bayi< 1 tahun) selama beberapa minggu/bulan terakhir?
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'4'}) ? $data->table_risiko_nutrisional->result->{'4'} == "0" ? "bg-checked" : "" : "" ?> ">a. Tidak </td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'4'}) ? $data->table_risiko_nutrisional->result->{'4'} == "0" ? "bg-checked" : "" : "" ?> ">0</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'4'}) ? $data->table_risiko_nutrisional->result->{'4'} == "1" ? "bg-checked" : "" : "" ?> ">b. Ya</td>
                                <td class="<?= isset($data->table_risiko_nutrisional->result->{'4'}) ? $data->table_risiko_nutrisional->result->{'4'} == "1" ? "bg-checked" : "" : "" ?> ">1</td>
                            </tr>
                        </table>


            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.b2/RI
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
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 4 dari 6</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <p>Hasil total skor :</p>
                <p>0	:	Berisiko rendah, ulangi skrining setiap 7 hari                </p>
                <p>1-3	:	Berisiko menengah, dirujuk ke Tim Terapi Gizi. Monitor asupan makan setiap 3 hari</p>
                <p>4-5	:	Berisiko tinggi, dirujuk ke Tim Terapi Gizi. Monitor asupan makan setiap hari 
                </p>
                <p>Sudah dilaporkan ke Tim Terapi Gizi : 
                <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "item1" ? "checked":'':'' ?>> Tidak 
                <input type="checkbox" <?php echo isset($data->question43)? $data->question43 == "other" ? "checked":'':'' ?>> Ya, tanggal & jam..............</p>
                <p style="font-weight: bold;">8. PENILAIAN RISIKO JATUH PADA PASIEN ANAK (Isi formulir risiko jatuh dengan skala Humpty Dumpty)
                </p>
                <p> 
                    <input type="checkbox" <?php echo isset($data->question52)? $data->question52 == "item1" ? "checked":'':'' ?>>Risiko rendah  
                    <input type="checkbox" <?php echo isset($data->question52)? $data->question52 == "item2" ? "checked":'':'' ?>> Risiko tinggi</p>
                <p>Tingkat resiko :</p>
                <p>Skor 7 – 11	:	Risiko rendah untuk jatuh</p>
                <p>Skor ≥ 12	:	Risiko tinggi untuk jatuh</p>
                <p style="font-weight: bold;">9. TINGKAT PERKEMBANGAN SAAT INI  (Diisi bila anak berusia 1 bulan – 5 tahun)
                </p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>UMUR</td>
                        <td>GERAKAN KASAR</td>
                        <td>GERAKAN HALUS</td>
                        <td>KOMUNIKASI BERBICARA</td>
                        <td>SOSIAL & KEMANDIRIAN</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item1" ? "bg-checked" : "" : "" ?> ">1 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item1" ? "bg-checked" : "" : "" ?> ">Tangan & kaki bergerak aktif</td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item1" ? "bg-checked" : "" : "" ?> ">Kepala menoleh ke samping kanan & kiri</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item1" ? "bg-checked" : "" : "" ?> ">Bereaksi terhadap bunyi</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item1" ? "bg-checked" : "" : "" ?> ">Menatap wajah ibu / pengasuh</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item2" ? "bg-checked" : "" : "" ?> ">2 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item2" ? "bg-checked" : "" : "" ?> ">Mengangkat kepala ketika tengkurap</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item2" ? "bg-checked" : "" : "" ?> ">Bersuara Ooo… Ooo / ooo..ooo</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item2" ? "bg-checked" : "" : "" ?> ">Tersenyum spontan</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item3" ? "bg-checked" : "" : "" ?> ">3 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item3" ? "bg-checked" : "" : "" ?> ">Kepala tegak ketika didudukkan</td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item2" ? "bg-checked" : "" : "" ?> ">Memegang mainan</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item3" ? "bg-checked" : "" : "" ?> ">Tertawa/berteriak</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item3" ? "bg-checked" : "" : "" ?> ">Memandang tangannya</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item4" ? "bg-checked" : "" : "" ?> ">4 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item4" ? "bg-checked" : "" : "" ?> ">Tengkurap-terlentang sendiri</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item5" ? "bg-checked" : "" : "" ?> ">5 bulan</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item3" ? "bg-checked" : "" : "" ?> ">Meraih, menggapai</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item4" ? "bg-checked" : "" : "" ?> ">Menoleh ke suara</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item4" ? "bg-checked" : "" : "" ?> ">Meraih mainan</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item6" ? "bg-checked" : "" : "" ?> ">6 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item5" ? "bg-checked" : "" : "" ?> ">Duduk tanpa berpegangan</td>
                        <td></td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item5" ? "bg-checked" : "" : "" ?> ">Memasukkan benda ke mulut</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item7" ? "bg-checked" : "" : "" ?> ">7 bulan</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item4" ? "bg-checked" : "" : "" ?> ">Mengambil dgn tangan kanan dan kiri</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item5" ? "bg-checked" : "" : "" ?> ">Bersuara ma..ma.., da.. da..</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item8" ? "bg-checked" : "" : "" ?> ">8 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item6" ? "bg-checked" : "" : "" ?> ">Berdiri berpegangan</td>
                        <td></td>
                        <td>Bersuara ma..ma.., da.. da..</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item9" ? "bg-checked" : "" : "" ?> ">9 bulan</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item5" ? "bg-checked" : "" : "" ?> ">menjimpit</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item7" ? "bg-checked" : "" : "" ?> ">Memanggil mama, papa</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item6" ? "bg-checked" : "" : "" ?> ">Melambaikan tangan</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item10" ? "bg-checked" : "" : "" ?> ">10 bulan</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item6" ? "bg-checked" : "" : "" ?> ">Memukul mainan dengan kedua tangan</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item1" ? "bg-checked" : "" : "" ?> "></td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item7" ? "bg-checked" : "" : "" ?> ">Bertepuk tangan</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item11" ? "bg-checked" : "" : "" ?> ">11 bulan</td>
                        <td></td>
                        <td></td>
                        <td>Memanggil mama, papa</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item8" ? "bg-checked" : "" : "" ?> ">Menunjuk dan meminta</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item12" ? "bg-checked" : "" : "" ?> ">12 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item7" ? "bg-checked" : "" : "" ?> ">Berdiri tanpa berpegangan</td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item7" ? "bg-checked" : "" : "" ?> ">Memasukkan mainan ke cangkir</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item9" ? "bg-checked" : "" : "" ?> ">Bermain dengan orang lain</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item13" ? "bg-checked" : "" : "" ?> ">15 bulan</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item8" ? "bg-checked" : "" : "" ?> ">Berjalan </td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item8" ? "bg-checked" : "" : "" ?> ">Mencoret-coret</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item9" ? "bg-checked" : "" : "" ?> ">Berbicara 2 kata</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item10" ? "bg-checked" : "" : "" ?> ">Minum dari gelas</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item14" ? "bg-checked" : "" : "" ?> ">1,5 tahun</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item9" ? "bg-checked" : "" : "" ?> ">Lari, naik tangga</td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item9" ? "bg-checked" : "" : "" ?> ">Menumpuk 2 kubus</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item10" ? "bg-checked" : "" : "" ?> ">Berbicara beberapa kata</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item11" ? "bg-checked" : "" : "" ?> ">Memakai sendok dan menyuapi boneka</td>
                    </tr>
                  
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item15" ? "bg-checked" : "" : "" ?> ">2 tahun</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item10" ? "bg-checked" : "" : "" ?> ">Menendang bola</td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item10" ? "bg-checked" : "" : "" ?> ">Menumpuk 4 kubus</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item11" ? "bg-checked" : "" : "" ?> ">Menujuk 1 gambar</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item12" ? "bg-checked" : "" : "" ?> ">Menyikat gigi, melepas dan memakai pakaian</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item16" ? "bg-checked" : "" : "" ?> ">2,5 tahun</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item11" ? "bg-checked" : "" : "" ?> ">Melompat </td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item12" ? "bg-checked" : "" : "" ?> ">Menunjuk bagian 6 tubuh</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item13" ? "bg-checked" : "" : "" ?> ">Mencuci dan mengeringkan tangan</td>
                    </tr>
                   
                        
                </table>
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.b2/RI
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
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 5 dari 6</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item17" ? "bg-checked" : "" : "" ?> ">3 tahun</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item11" ? "bg-checked" : "" : "" ?> ">Menumpuk 8 kubus</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item13" ? "bg-checked" : "" : "" ?> ">Menyebut 4 gambar</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item14" ? "bg-checked" : "" : "" ?> ">Menyebut nama teman</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item18" ? "bg-checked" : "" : "" ?> ">3,5 tahun</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item12" ? "bg-checked" : "" : "" ?> ">Berdiri satu kaki 3 detik</td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item12" ? "bg-checked" : "" : "" ?> ">Menggoyangkan ibu jari</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item14" ? "bg-checked" : "" : "" ?> ">Bercerita singkat menyebutkan penggunaan benda</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item15" ? "bg-checked" : "" : "" ?> ">Memakai baju kaos</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item19" ? "bg-checked" : "" : "" ?> ">4 tahun</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item13" ? "bg-checked" : "" : "" ?> ">Menggambar lingkaran</td>
                        <td class="<?= isset($data->question87[0]->column4) ? $data->question87[0]->column4 == "item1" ? "bg-checked" : "" : "" ?> "></td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item16" ? "bg-checked" : "" : "" ?> ">Memakai baju tanpa dibatu</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item20" ? "bg-checked" : "" : "" ?> ">4,5 tahun</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column3) ? $data->question87[0]->column3 == "item14" ? "bg-checked" : "" : "" ?> ">Menggambar manusia (kepala, badan, kaki, tangan)</td>
                        <td></td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item17" ? "bg-checked" : "" : "" ?> ">Bermain kartu, menyikat gigi tanpa dibantu</td>
                    </tr>
                    <tr>
                        <td class="<?= isset($data->question87[0]->column1) ? $data->question87[0]->column1 == "item21" ? "bg-checked" : "" : "" ?> ">5 tahun</td>
                        <td class="<?= isset($data->question87[0]->column2) ? $data->question87[0]->column2 == "item13" ? "bg-checked" : "" : "" ?> ">Berdiri satu kaki 5 detik</td>
                        <td >Menghitung kubus</td>
                        <td class="<?= isset($data->question87[0]->column5) ? $data->question87[0]->column5 == "item18" ? "bg-checked" : "" : "" ?> ">Mengambil makanan sendiri</td>
                    </tr>
                  
            </table>
            <h3 style="text-align: center; font-weight: bold;">HASIL PENGKAJIAN PERTUMBUHAN DAN PERKEMBANGAN BAYI DAN BALITA</h3>
            <p>Gerakan kasar/motorik kasar :<?= isset($data->question53->text1)?$data->question53->text1:'.............' ?></p>
            <p>Gerakan halus/motorik halus :<?= isset($data->question53->text2)?$data->question53->text2:'.............' ?></p>
            <p>Komunikasi/ berbicara :<?= isset($data->question53->text3)?$data->question53->text3:'.............' ?></p>
            <p>Sosial & kemandirian :<?= isset($data->question53->text4)?$data->question53->text4:'.............' ?></p>
            <p>Gangguan tumbuh kembang : <input type="checkbox" <?php echo isset($data->question54)? $data->question54 == "item1" ? "checked":'':'' ?>> Tidak 
            <input type="checkbox" <?php echo isset($data->question54)? $data->question54 == "item2" ? "checked":'':'' ?>> Ya</p>
            
            <h4 style="font-weight: bold;">Bila terdapat masalah tumbuh kembang lapor ke DPJP</h4>
            <p>Sudah dilaporkan ke DPJP : Tgl <?= isset($data->question65)?date('d/m/Y',strtotime($data->question65)):'.............' ?> Jam <?= isset($data->question65)?date('h:i',strtotime($data->question65)):'.............' ?></p>
            <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                <tr>
                    <td>No</td>
                    <td>Aktivitas</td>
                    <td>Skor</td>
                    <td>Normal usia</td>
                    <td>Penjelasan Pemberian Skor</td>
                </tr>
                <tr>
                    <td colspan="5"><center>PERAWATAN DIRI</center></td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>makan</td>
                    <td><?= isset($data->question66->item1->column1)?$data->question66->item1->column1:'' ?></td>
                    <td><?= isset($data->question66->item1->column2)?$data->question66->item1->column2:'' ?></td>
                    <td><?= isset($data->question66->item1->column3)?$data->question66->item1->column3:'' ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Mengurus Diri</td>
                    <td><?= isset($data->question66->item2->column1)?$data->question66->item2->column1:'' ?></td>
                    <td><?= isset($data->question66->item2->column2)?$data->question66->item2->column2:'' ?></td>
                    <td><?= isset($data->question66->item2->column3)?$data->question66->item2->column3:'' ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Mandir</td>
                    <td><?= isset($data->question66->item3->column1)?$data->question66->item3->column1:'' ?></td>
                    <td><?= isset($data->question66->item3->column2)?$data->question66->item3->column2:'' ?></td>
                    <td><?= isset($data->question66->item3->column3)?$data->question66->item3->column3:'' ?></td>
                </tr> 
                <tr>
                    <td>4</td>
                    <td>Berpakaian bagian atas tubuh</td>
                    <td><?= isset($data->question66->item4->column1)?$data->question66->item4->column1:'' ?></td>
                    <td><?= isset($data->question66->item4->column2)?$data->question66->item4->column2:'' ?></td>
                    <td><?= isset($data->question66->item4->column3)?$data->question66->item4->column3:'' ?></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Berpakaian bagian bawah tubuh</td>
                    <td><?= isset($data->question66->item5->column1)?$data->question66->item5->column1:'' ?></td>
                    <td><?= isset($data->question66->item5->column2)?$data->question66->item5->column2:'' ?></td>
                    <td><?= isset($data->question66->item5->column3)?$data->question66->item5->column3:'' ?></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Aktivitas sekitar BAK dan BAB (Toileting)</td>
                    <td><?= isset($data->question66->item6->column1)?$data->question66->item6->column1:'' ?></td>
                    <td><?= isset($data->question66->item6->column2)?$data->question66->item6->column2:'' ?></td>
                    <td><?= isset($data->question66->item6->column3)?$data->question66->item6->column3:'' ?></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Kontrol BAK </td>
                    <td><?= isset($data->question66->item7->column1)?$data->question66->item7->column1:'' ?></td>
                    <td><?= isset($data->question66->item7->column2)?$data->question66->item7->column2:'' ?></td>
                    <td><?= isset($data->question66->item7->column3)?$data->question66->item7->column3:'' ?></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Kontrol BAB</td>
                    <td><?= isset($data->question66->item8->column1)?$data->question66->item8->column1:'' ?></td>
                    <td><?= isset($data->question66->item8->column2)?$data->question66->item8->column2:'' ?></td>
                    <td><?= isset($data->question66->item8->column3)?$data->question66->item8->column3:'' ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Total perawatan diri</b></td>
                    <td><?= isset($data->question66->item9->column1)?$data->question66->item9->column1:'' ?></td>
                    <td><?= isset($data->question66->item9->column2)?$data->question66->item9->column2:'' ?></td>
                    <td><?= isset($data->question66->item9->column3)?$data->question66->item9->column3:'' ?></td>
                </tr>
                <tr>
                    <td colspan="5"><center>MOBILITAS</center></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Berpindah ke dan dari kursi roda</td>
                    <td><?= isset($data->question67->item1->column1)?$data->question67->item1->column1:'' ?></td>
                    <td><?= isset($data->question67->item1->column2)?$data->question67->item1->column2:'' ?></td>
                    <td>Gait : <input type="checkbox" <?= (isset($data->question67->item1->column3)?in_array("item1", $data->question67->item1->column3)?'checked':'':'') ?>>Berjaan 
                    <input type="checkbox" <?= (isset($data->question67->item1->column3)?in_array("item2", $data->question67->item1->column3)?'checked':'':'') ?>>Kursi roda 
                    <input type="checkbox" <?= (isset($data->question67->item1->column3)?in_array("item3", $data->question67->item1->column3)?'checked':'':'') ?>>Keduanya</td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Berpindah ked an dari WC / Jamban</td>
                    <td><?= isset($data->question68->item2->column1)?$data->question68->item2->column1:'' ?></td>
                    <td><?= isset($data->question68->item2->column2)?$data->question68->item2->column2:'' ?></td>
                    <td><?= isset($data->question68->item2->column3)?$data->question68->item2->column3:'' ?></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td>Berpindah ked an dari kamar mandi</td>
                    <td><?= isset($data->question68->item3->column1)?$data->question68->item3->column1:'' ?></td>
                    <td><?= isset($data->question68->item3->column2)?$data->question68->item3->column2:'' ?></td>
                    <td><?= isset($data->question68->item3->column3)?$data->question68->item3->column3:'' ?></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td>Lokomosi : Berjalan / Berkursi roda / Merangkak</td>
                    <td><?= isset($data->question69->item4->column1)?$data->question69->item4->column1:'' ?></td>
                    <td><?= isset($data->question69->item4->column2)?$data->question69->item4->column2:'' ?></td>
                    <td>Gait : <input type="checkbox" <?= (isset($data->question69->item4->column3)?in_array("item1", $data->question69->item4->column3)?'checked':'':'') ?>>Berjaan 
                    <input type="checkbox" <?= (isset($data->question69->item4->column3)?in_array("item2", $data->question69->item4->column3)?'checked':'':'') ?>>Kursi roda 
                    <input type="checkbox" <?= (isset($data->question69->item4->column3)?in_array("item3", $data->question69->item4->column3)?'checked':'':'') ?>>merangkak 
                    <input type="checkbox" <?= (isset($data->question69->item4->column3)?in_array("other", $data->question69->item4->column3)?'checked':'':'') ?>>lainnya <?= isset($data->question69->item4->{'column3-Comment'})?$data->question69->item4->{'column3-Comment'}:'' ?></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td>Lokomosi : Naik Tangga</td>
                    <td><?= isset($data->question70->item1->column1)?$data->question70->item1->column1:'' ?></td>
                    <td><?= isset($data->question70->item1->column2)?$data->question70->item1->column2:'' ?></td>
                    <td><?= isset($data->question70->item1->column3)?$data->question70->item1->column3:'' ?></td>
                </tr>
                <tr>
                    <td colspan="2">Total mobilitas</td>
                    <td><?= isset($data->question70->item2->column1)?$data->question70->item2->column1:'' ?></td>
                    <td><?= isset($data->question70->item2->column2)?$data->question70->item2->column2:'' ?></td>
                    <td><?= isset($data->question70->item2->column3)?$data->question70->item2->column3:'' ?></td>
                </tr>
            </table>
            </td>
       </tr>
    </table>
    <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:350px;font-family:arial">
            No.Dokumen : Rev.I.I/2018/RM.06.b2/RI
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
            <h3>PENGKAJIAN KEPERAWATAN PASIEN RAWAT INAP ANAK</h3>
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
            <td colspan="2">(Diisi oleh Perawat)</td>
            <td >Halaman 6 dari 6</td>
        </tr>
      
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
             
       <tr>
            <td colspan="4">
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    
                    <tr>
                        <td colspan="5"><center>KOMUNIKASI</center></td>
                    </tr>
                    <tr>
                        <td>14</td>
                        <td>pemahaman</td>
                        <td><?= isset($data->question73->item1->column1)?$data->question73->item1->column1:'' ?></td>
                        <td><?= isset($data->question73->item1->column2)?$data->question73->item1->column2:'' ?></td>
                        <td>cara : <input type="checkbox" <?= (isset($data->question73->item1->column3)?in_array("item1", $data->question73->item1->column3)?'checked':'':'') ?>>Pendengaran  
                        <input type="checkbox" <?= (isset($data->question73->item1->column3)?in_array("item2", $data->question73->item1->column3)?'checked':'':'') ?>>Penglihatan  
                        <input type="checkbox" <?= (isset($data->question73->item1->column3)?in_array("item3", $data->question73->item1->column3)?'checked':'':'') ?>>Keduanya 
                        <input type="checkbox" <?= (isset($data->question73->item1->column3)?in_array("other", $data->question73->item1->column3)?'checked':'':'') ?>>lainnya.............</td>
                    
                    </tr>
                    <tr>
                        <td>15</td>
                        <td>Ekspresi</td>
                        <td><?= isset($data->question71->item1->column1)?$data->question71->item1->column1:'' ?></td>
                        <td><?= isset($data->question71->item1->column2)?$data->question71->item1->column2:'' ?></td>
                        <td>cara : <input type="checkbox" <?= (isset($data->question71->item1->column3)?in_array("item1", $data->question71->item1->column3)?'checked':'':'') ?>>vokal 
                        <input type="checkbox" <?= (isset($data->question71->item1->column3)?in_array("item2", $data->question71->item1->column3)?'checked':'':'') ?>>non vokal  
                        <input type="checkbox" <?= (isset($data->question71->item1->column3)?in_array("item3", $data->question71->item1->column3)?'checked':'':'') ?>>Keduanya </td>
                    
                    </tr>
                    <tr>
                        <td colspan="5"><center>KOGNISI SOSIAL</center></td>
                    </tr>
                    <tr>
                        <td>16</td>
                        <td>Interaksi Sosial</td>
                        <td><?= isset($data->question72->item1->column1)?$data->question72->item1->column1:'' ?></td>
                        <td><?= isset($data->question72->item1->column2)?$data->question72->item1->column2:'' ?></td>
                        <td><?= isset($data->question72->item1->column3)?$data->question72->item1->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td>17</td>
                        <td>Pemecahan masalah</td>
                        <td><?= isset($data->question72->item2->column1)?$data->question72->item2->column1:'' ?></td>
                        <td><?= isset($data->question72->item2->column2)?$data->question72->item2->column2:'' ?></td>
                        <td><?= isset($data->question72->item2->column3)?$data->question72->item2->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td>18</td>
                        <td>Memori </td>
                        <td><?= isset($data->question72->item3->column1)?$data->question72->item3->column1:'' ?></td>
                        <td><?= isset($data->question72->item3->column2)?$data->question72->item3->column2:'' ?></td>
                        <td><?= isset($data->question72->item3->column3)?$data->question72->item3->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Total kognisi</td>
                        <td><?= isset($data->question72->item4->column1)?$data->question72->item4->column1:'' ?></td>
                        <td><?= isset($data->question72->item4->column2)?$data->question72->item4->column2:'' ?></td>
                        <td><?= isset($data->question72->item4->column3)?$data->question72->item4->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Total weefim</td>
                        <td><?= isset($data->question72->item5->column1)?$data->question72->item5->column1:'' ?></td>
                        <td><?= isset($data->question72->item5->column2)?$data->question72->item5->column2:'' ?></td>
                        <td><?= isset($data->question72->item5->column3)?$data->question72->item5->column3:'' ?></td>
                    </tr>
                </table>
                <p><input type="checkbox" <?= (isset($data->question74)?in_array("item1", $data->question74)?'checked':'':'') ?>> Tanpa bantuan 
                <input type="checkbox" <?= (isset($data->question74)?in_array("item2", $data->question74)?'checked':'':'') ?>>Bantuan - Ketergantungan dengan modifikasi 
                <input type="checkbox" <?= (isset($data->question74)?in_array("item3", $data->question74)?'checked':'':'') ?>> Bantuan – Ketergantungan Penuh</p>
               
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                
                    <tr>
                        <td colspan="2"><center>WeeFIM Level</center></td>
                    </tr>
                    <tr>
                        <td>
                            <p>Tanpa bantuan</p>
                            <p>7. Kemandirian komplit (tepat waktu, Aman)</p>
                            <p>6. Mandiri dengan modifikasi (bantuan alat)</p>
                            <p>Bantuan – Ketergantungan Penuh</p>
                            <p>2. Bantuan maksimal (sebesar  = 25% - 49%)</p>
                            <p>1. 	Bantuan total (sebesar  = 0% - 24%)</p>
                        </td>
                        <td>
                            <p>Bantuan – Ketergantungan dengan Modifikasi                    </p>
                            <p>5. Mandiri dengan supervise</p>
                            <p>4. Bantuan minimal (sebesar  = 75% atau lebih)</p>
                            <p>3. Bantuan sedang (sebesar  = 50% atau lebih)</p>
                        </td>
                    </tr>
                </table>
                <p>Bila terdapat gangguan fungsional, pasien dikonsultasikan ke Rehab Medik Anak melalui DPJP</p>
                <p>Sudah dilaporkan ke DPJP : Tgl <?= isset($data->question77)?date('d/m/Y',strtotime($data->question77)):'' ?> Jam : <?= isset($data->question77)?date('h:i',strtotime($data->question77)):'' ?></p>
                <p style="font-weight: bold;">11. DISCHARGE PLANNING (dilengkapi dalam 48 jam pertama pasien masuk ruang rawat)
                </p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                
                   <tr>
                        <td>KOMPONEN PENILAIAN</td>
                        <td>YA</td>
                        <td>TIDAK</td>
                        <td>KETERANGAN</td>
                   </tr>
                   <tr>
                        <td>Perlu pelayanan home care</td>
                        <td style="text-align:center"><?php echo isset($data->question78->item1->column1)? $data->question78->item1->column1 == "item1" ? "✓":'':'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question78->item1->column1)? $data->question78->item1->column1 == "item2" ? "✓":'':'' ?></td>
                        <td><?= isset($data->question78->item1->column2)?$data->question78->item1->column2:'' ?></td>
                   </tr>
                   <tr>
                        <td>Penggunaan alat bantu</td>
                        <td style="text-align:center"><?php echo isset($data->question78->item2->column1)? $data->question78->item2->column1 == "item1" ? "✓":'':'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question78->item2->column1)? $data->question78->item2->column1 == "item2" ? "✓":'':'' ?></td>
                        <td><?= isset($data->question78->item2->column2)?$data->question78->item2->column2:'' ?></td>
                   </tr>
                   <tr>
                        <td>Dirujuk ke komunitas tertentu</td>
                        <td style="text-align:center"><?php echo isset($data->question78->item3->column1)? $data->question78->item3->column1 == "item1" ? "✓":'':'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question78->item3->column1)? $data->question78->item3->column1 == "item2" ? "✓":'':'' ?></td>
                        <td><?= isset($data->question78->item3->column2)?$data->question78->item3->column2:'' ?></td>
                   </tr>
                   <tr>
                        <td>Dirujuk ke tim terapis</td>
                        <td style="text-align:center"><?php echo isset($data->question78->item4->column1)? $data->question78->item4->column1 == "item1" ? "✓":'':'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question78->item4->column1)? $data->question78->item4->column1 == "item2" ? "✓":'':'' ?></td>
                        <td><?= isset($data->question78->item4->column2)?$data->question78->item4->column2:'' ?></td>
                   </tr>
                   <tr>
                        <td>Dirujuk ke ahli gizi</td>
                        <td style="text-align:center"><?php echo isset($data->question78->item5->column1)? $data->question78->item5->column1 == "item1" ? "✓":'':'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question78->item5->column1)? $data->question78->item5->column1 == "item2" ? "✓":'':'' ?></td>
                        <td><?= isset($data->question78->item5->column2)?$data->question78->item5->column2:'' ?></td>
                   </tr>
                   <tr>
                        <td>Lain-lain :</td>
                        <td style="text-align:center"><?php echo isset($data->question78->item6->column1)? $data->question78->item6->column1 == "item1" ? "✓":'':'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question78->item6->column1)? $data->question78->item6->column1 == "item2" ? "✓":'':'' ?></td>
                        <td><?= isset($data->question78->item6->column2)?$data->question78->item6->column2:'' ?></td>
                   </tr>
                </table>
                <p style="font-weight: bold;">12. DAFTAR MASALAH KEPERAWATAN PRIORITAS 
                </p>
                <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                    <tr>
                        <td>NO</td>
                        <td>MASALAH KEPERAWATAN</td>
                        <td>TUJUAN TERUKUR</td>
                    </tr>
                    <?php 
                    $i = 1;
                    if(isset($data->question79)){
                        foreach($data->question79 as $val){
                    
                     ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= isset($val->column1)?$val->column1:'' ?></td>
                        <td><?= isset($val->column2)?$val->column2:'' ?></td>
                    </tr>
                    <?php }}else{ ?>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php }
                    ?>
                   
                </table>
                <p><input type="checkbox" <?= (isset($data->question80)?in_array("item1", $data->question80)?'checked':'':'') ?>>Disusun Rencana Keperawatan</p>
                <div style="display: flex; justify-content: space-between; width: 100%;">
                            <!-- Perawat 1 (Kiri) -->
                            <div style="width: 50%;">
                                <p style="margin: 5px 0;">Tanggal & Jam <?= isset($data->question81)?date('d/m/Y h:i',strtotime($data->question81)):'' ?></p>
                                <p style="margin: 5px 0;">Perawat yang melakukan pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="<?= isset($data->question83)?$data->question83:'' ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question85)?$data->question85:'' ?></p>
                            </div>

                            <!-- Perawat 2 (Kanan) -->
                            <div style="width: 50%; text-align: right;">
                                <p style="margin: 5px 0;">Tanggal & Jam <?= isset($data->question82)?date('d/m/Y h:i',strtotime($data->question82)):'' ?></p>
                                <p style="margin: 5px 0;">Perawat yang melengkapi pengkajian</p>
                                <p style="margin: 5px 0;"><img width="30px" style="text-align:center" src="<?= isset($data->question84)?$data->question84:'' ?>" alt=""></p>
                                <p style="margin: 5px 0;"><?= isset($data->question86)?$data->question86:'' ?></p>
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
            No.Dokumen : Rev.I.I/2018/RM.06.b2/RI
            </div>
        </div>
    </div>
    </div>
</body>
                