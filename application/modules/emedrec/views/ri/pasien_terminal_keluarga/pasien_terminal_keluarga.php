<?php
$data = (isset($asesmen_ulang_terminal_keluarga->formjson)?json_decode($asesmen_ulang_terminal_keluarga->formjson):'');
// var_dump($data);
?>
<!DOCTYPE html>
   <html>

   <head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 10px; */
            /* border-collapse: collapse; */
            /* border: 1px solid black;     */
            width: 100%;
            font-size: 11px;
            position: relative;
            
            
        }

        #data tr td{
            
            font-size: 12px;
            font-family:arial;
            
        }

        #data th{
            
            font-size: 12px;
            font-family:arial;
            
        }

        #noborder td{
            font-family: arial;
            font-size: 12px;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p align="center" style="font-weight:bold;font-size:14px;font-family:arial">ASESMEN AWAL DAN ULANG PASIEN TERMINAL DAN KELUARGA</p>
          
            <div style="font-size:12px;font-family:arial">
                <p>
                    <span style="font-family:arial">Asesmen Awal / Ulang Tanggal : <?= isset($data->question5)?date('d-m-Y',strtotime($data->question5)):'' ?></span>
                    <span style="font-family:arial;margin-left:300px">Pukul : <?= isset($data->question5)?date('H:i',strtotime($data->question5)):'' ?></span>
                </p>

                
                    <span style="font-family:arial">1.Gejala seperti mau muntah dan kesulitan bernafas </span><br>
                    <span style="font-family:arial;margin-left:15px">1.1.Kegawatan pernafasan :</span>
                    <table width="100%" id="noborder" style="margin-left:35px;" cellpadding="0">
                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item1", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Dyspnoe</span>
                            </td>
                            <td  width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item2", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nafas cepat dan dangkal</span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item3", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nafas lambat</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item4", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nafas Tak teratur </span>
                            </td>
                            <td >
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item5", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nafas melalui mulut </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item6", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Mukosa oral kering </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item7", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ada sekret </span>
                            </td>
                            <td >
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item8", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">SpO2 < normal </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item9", $data->question3)?'checked':'':'') ?>>
                                <span style="font-family:arial">T.A.K</span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;margin-left:15px">1.2.Kehilangan Tonus otot : </span>
                    <table width="100%" id="noborder" style="margin-left:35px;">
                        <tr>
                            <td width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("mual", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Mual </span>
                            </td>
                            <td  width="30%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("item1", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Penurunan Pergerakan tubuh</span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("item2", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Sulit Berbicara</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("item3", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Sulit menelan</span>
                            </td>
                            <td >
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("item4", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Distensi Abdomen </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("item5", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Inkontinensia Urine </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("item6", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">Inkontinensia alvi </span>
                            </td>
                            <td >
                                <input type="checkbox" value="Tidak" <?= (isset($data->question4)?in_array("T.A.K", $data->question4)?'checked':'':'') ?>>
                                <span style="font-family:arial">T.A.K </span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;margin-left:15px">1.3.Nyeri :</span>
                    <table width="100%" id="noborder" style="margin-left:35px;">
                        <tr>
                            <td width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item1", $data->question6)?'checked':'':'') ?>>
                                <span style="font-family:arial">Tidak  </span>
                            </td>
                            <td  width="30%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("other", $data->question6)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ya <?= isset($data->{'question6-Comment'})?':'.' '.$data->{'question6-Comment'}:'' ?></span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;margin-left:15px">1.4.Perlambatan Sirkulasi : </span>
                    <table width="100%" id="noborder" style="margin-left:35px;">
                        <tr>
                            <td width="35%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item1", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">Bercak dan sianosis pada ekstremitas </span>
                            </td>
                            <td  width="30%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item2", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">Kulit dingin dan berkeringat </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item11", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">Gelisah </span>
                            </td>
                            <td >
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item10", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">Tekanan Darah menurun </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item12", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">Lemas</span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item13", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nadi lambat dan lemah</span>
                            </td>
                            <td >
                                <input type="checkbox" value="Tidak" <?= (isset($data->question8)?in_array("item15", $data->question8)?'checked':'':'') ?>>
                                <span style="font-family:arial">T.A.K </span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial">2.Faktor-faktor yang meningkatkan dan membangkitkan gejala fisik : </span><br>
                    <table width="100%" id="noborder" style="margin-left:15px;">
                        <tr>
                            <td width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question92)?in_array("item1", $data->question92)?'checked':'':'') ?>>
                                <span style="font-family:arial">Melakukan aktivitas fisik  </span>
                            </td>
                            <td  width="30%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question92)?in_array("item2", $data->question92)?'checked':'':'') ?>>
                                <span style="font-family:arial">Pindah posisi </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question92)?in_array("other", $data->question92)?'checked':'':'') ?>>
                                <span style="font-family:arial"><?= isset($data->{'question92-Comment'})?$data->{'question92-Comment'}:'' ?></span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial">3.Manajemen gejala saat ini ada respon pasien :</span><br>
                    <span style="font-family:arial;margin-left:10px">Masalah keperawatan *</span><br>
                    <table width="100%" id="noborder" style="margin-left:15px;">
                        <tr>
                            <td width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item1", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Mual </span>
                            </td>
                            <td  width="30%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item2", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Pola Nafas tidak efektif </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item3", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Bersihan jalan nafas tidak efektif </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item4", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Perubahan persepsi sensori </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item5", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Konstipasi </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item6", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Defisit perawatan diri </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item7", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nyeri akut </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question9)?in_array("item8", $data->question9)?'checked':'':'') ?>>
                                <span style="font-family:arial">Nyeri Kronis </span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;font-weight:bold">4.Orientasi spiritual pasien dan keluarga : </span><br>
                    <table width="100%" id="noborder" style="margin-left:15px;">
                        <tr>
                            <td width="35%">
                                <span style="font-family:arial">Apakah perlu pelayanan spiritual ? </span>
                            </td>
                            <td  width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("item1", $data->question12)?'checked':'':'') ?>>
                                <span style="font-family:arial">Tidak </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("other", $data->question12)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ya, oleh : <?= isset($data->{'question12-Comment'})?$data->{'question12-Comment'}:'' ?></span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;font-weight:bold">5.	Urusan dan kebutuhan spiritual pasien dan keluarga seperti putus asa, penderitaan, rasa bersalah atau pengampunan : </span><br>
                    <table width="100%" id="noborder" style="margin-left:15px;">
                        <tr>
                            <td width="25%">
                                <span style="font-family:arial">Perlu didoakan : </span>
                            </td>
                            <td  width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question15)?in_array("item4", $data->question15)?'checked':'':'') ?>>
                                <span style="font-family:arial">Tidak </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question15)?in_array("item3", $data->question15)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ya</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span style="font-family:arial">Perlu bimbingan rohani 	:</span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question17)?in_array("item4", $data->question17)?'checked':'':'') ?>>
                                <span style="font-family:arial">Tidak </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question17)?in_array("item3", $data->question17)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ya</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <span style="font-family:arial">Perlu pendampingan rohani 	:</span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("item4", $data->question18)?'checked':'':'') ?>>
                                <span style="font-family:arial">Tidak </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("item3", $data->question18)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ya</span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;font-weight:bold">6.	Status psikososial dan keluarga :</span><br>
                    <span style="font-family:arial;margin-left:15px">6.1.<b style="font-family:arial">Apakah ada orang yang ingin dihubungi saat ini? :</b></span>
                    <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item1", $data->question7)?'checked':'':'') ?>>
                    <span style="font-family:arial">Tidak</span><br>
                    <table width="100%" id="noborder" style="margin-left:30px;">
                        <tr>
                            <td  width="25%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("other", $data->question7)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ya, siapa <?= isset($data->{'question7-Comment'})?$data->{'question7-Comment'}:'' ?></span>
                            </td>
                            <td>
                                <span style="font-family:arial">Hubungan dengan pasien sebagai : <?= isset($data->question22->{'Hubungan dengan pasien sebagai :'})?$data->question22->{'Hubungan dengan pasien sebagai :'}:'' ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <span style="font-family:arial"> Dimana : <?= isset($data->question22->{'Dimana :'})?$data->question22->{'Dimana :'}:'' ?></span>
                            </td>
                            <td>
                                <span style="font-family:arial">No. Telpon/HP : <?= isset($data->question22->{'No. Telpon/HP :'})?$data->question22->{'No. Telpon/HP :'}:'' ?></span>
                            </td>
                        </tr>
                    </table>
                    <span style="font-family:arial;margin-left:15px">6.2.<b style="font-family:arial">Bagaimana rencana perawatan selanjutnya ?</b></span><br>
                        <input type="checkbox" value="Tidak" style="margin-left:35px" <?= (isset($data->question23)?in_array("item1", $data->question23)?'checked':'':'') ?>>
                        <span style="font-family:arial">Tetap dirawat di RS </span><br>
                        <input type="checkbox" value="Tidak" style="margin-left:35px" <?= (isset($data->question23)?in_array("item2", $data->question23)?'checked':'':'') ?>>
                        <span style="font-family:arial">Dirawat di rumah</span>
                            <table width="100%" id="noborder" style="margin-left:35px;">
                                <tr>
                                    <td  width="50%">
                                        <span style="font-family:arial">Apakah lingkungan rumah sudah disiapkan ? </span>
                                    </td>
                                    <td width="20%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question24)?in_array("item1", $data->question24)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Ya</span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question24)?in_array("item2", $data->question24)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Tidak</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="font-family:arial">Jika Ya, apakah ada yang mampu nmerawat pasien di rumah ?	</span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question27)?in_array("other", $data->question27)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Ya, oleh : <?= isset($data->{'question27-Comment'})?$data->{'question27-Comment'}:'' ?></span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question27)?in_array("item1", $data->question27)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Tidak</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span style="font-family:arial">Jika tidak, apakah perlu difasilitasi RS (Home Care)?</span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question25)?in_array("item1", $data->question25)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Ya</span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question25)?in_array("item2", $data->question25)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Tidak</span>
                                    </td>
                                </tr>
                            
                            </table>

                    <span style="font-family:arial;margin-left:15px">6.3.<b style="font-family:arial">Reaksi pasien atas penyakitnya</b></span><br>
                    <span style="font-family:arial;margin-left:35px;font-weight:bold">Asesmen informasi</span><br>
                        <table width="100%" id="noborder" style="margin-left:35px;">
                                <tr>
                                    <td  width="30%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question29)?in_array("item1", $data->question29)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Menyangkal </span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question29)?in_array("item2", $data->question29)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Sedih / menangis</span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question29)?in_array("item6", $data->question29)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Marah  </span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question29)?in_array("item7", $data->question29)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Rasa bersalah </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question29)?in_array("item8", $data->question29)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Takut  </span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question29)?in_array("item9", $data->question29)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Ketidak berdayaan </span>
                                    </td>
                                </tr>
                            
                        </table>

                        <span style="font-family:arial;margin-left:35px;font-weight:bold">Masalah keperawatan *</span><br>
                        <table width="100%" id="noborder" style="margin-left:35px;">
                                <tr>
                                    <td  width="30%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question14)?in_array("item1", $data->question14)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Anxietas </span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question14)?in_array("item2", $data->question14)?'checked':'':'') ?>>
                                        <span style="font-family:arial">Distress Spiritual </span>
                                    </td>
                                </tr>
                        </table>
            </div>
            <br><br><br><br><br><br>
            <div style="display:flex;font-size:12px;font-family:arial">
                <div style="font-family:arial">
                    Hal 1 dari 2
                </div>
                <div style="margin-left:500px;font-family:arial">
                <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                </div>
           </div>
        </div>


        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <p align="center" style="font-weight:bold;font-size:14px;font-family:arial">ASESMEN AWAL DAN ULANG PASIEN TERMINAL DAN KELUARGA</p>
                <div style="font-family:arial;font-size:12px">
                    <span style="font-family:arial;margin-left:15px">6.4.Reaksi keluarga atas penyakit pasien : </span><br>
                    <span style="font-family:arial;margin-left:35px;">Asesmen informasi </span><br>
                    <table width="100%" id="noborder" style="margin-left:35px;">
                        <tr>
                            <td  width="40%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item1", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Marah  </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item2", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Letih/lelah</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item3", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Gangguan tidur </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item4", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Rasa bersalah</span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item5", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Penurunan Konsentrasi  </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item6", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Perubahan kebiasaan pola komunikasi </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item7", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ketidakmampuan memenuhi peran yang diharapkan </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item8", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Keluarga kurang berpartisipasi membuat keputusan dalam perawatan pasien</span>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question21)?in_array("item9", $data->question21)?'checked':'':'') ?>>
                                <span style="font-family:arial">Keluarga kurang berkomunikasi dengan pasien </span>
                            </td>
                        </tr>
                    </table>

                    <span style="font-family:arial;margin-left:35px;font-weight:bold">Masalah keperawatan *</span><br>
                    <table width="100%" id="noborder" style="margin-left:35px;">
                        <tr>
                            <td  width="40%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question26)?in_array("item1", $data->question26)?'checked':'':'') ?>>
                                <span style="font-family:arial">Koping individu tidak efektif   </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question26)?in_array("item2", $data->question26)?'checked':'':'') ?>>
                                <span style="font-family:arial">Distress Spiritual </span>
                            </td>
                        </tr>
                    </table><br>

                    <span style="font-family:arial;">7.	Kebutuhan dukungan atau kelonggaran pelayanan bagi pasien, keluarga dan pemberi pelayanan lain :</span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question30)?in_array("item1", $data->question30)?'checked':'':'') ?>>
                        <span style="font-family:arial">Pasien perlu didampingin keluarga </span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question30)?in_array("item2", $data->question30)?'checked':'':'') ?>>
                        <span style="font-family:arial">Keluarga dapat mengunjungi pasien di luar waktu berkunjung  </span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question30)?in_array("item3", $data->question30)?'checked':'':'') ?>>
                        <span style="font-family:arial">Sahabat dapat mengunjungi pasien di luar waktu berkunjung </span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question30)?in_array("other", $data->question30)?'checked':'':'') ?>>
                        <span style="font-family:arial"><?= isset($data->{'question30-Comment'})?$data->{'question30-Comment'}:'...' ?> </span><br><br>

                    <span style="font-family:arial;">8.	Apakah ada kebutuhan akan alternatif atau timgkat pelayanan lain :</span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question31)?in_array("item1", $data->question31)?'checked':'':'') ?>>
                        <span style="font-family:arial">Tidak </span>
                        <input type="checkbox" style="margin-left:90px" value="Tidak" <?= (isset($data->question32)?in_array("item1", $data->question32)?'checked':'':'') ?>>
                        <span style="font-family:arial">Autopsi  </span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question31)?in_array("other", $data->question31)?'checked':'':'') ?>>
                        <span style="font-family:arial">Donasi Organ : <?= isset($data->{'question30-Comment'})?$data->{'question30-Comment'}:'' ?></span><br>
                        <input type="checkbox" style="margin-left:20px" value="Tidak" <?= (isset($data->question32)?in_array("other", $data->question32)?'checked':'':'') ?>>
                        <span style="font-family:arial"><?= isset($data->{'question32-Comment'})?$data->{'question32-Comment'}:'' ?></span><br><br>


                    <span style="font-family:arial;">9.	Faktor resiko bagi keluarga yang ditinggalkan : </span><br>
                    <span style="font-family:arial;margin-left:20px">Asesmen informasi  </span><br>
                    <table width="100%" id="noborder" style="margin-left:20px;">
                        <tr>
                            <td  width="50%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item1", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Marah </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item2", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Letih/lelah  </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item3", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Depresi  </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item4", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Gangguan tidur  </span>
                            </td>
                        </tr>


                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item5", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Rasa bersalah </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item6", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Sedih/menangis  </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item7", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Perubahan kebiasaan pola komunikasi </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item8", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Penurunan konsentrasi   </span>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question33)?in_array("item9", $data->question33)?'checked':'':'') ?>>
                                <span style="font-family:arial">Ketidak mampuan memenuhi peran yang diharapkan</span>
                            </td>
                            
                        </tr>
                    </table>
                    <span style="font-family:arial;margin-left:20px;font-weight:bold">Masalah keperawatan * </span><br>
                    <table width="100%" id="noborder" style="margin-left:20px;">
                        <tr>
                            <td  width="50%">
                                <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item1", $data->question35)?'checked':'':'') ?>>
                                <span style="font-family:arial">Koping individu tidak efektif  </span>
                            </td>
                            <td>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item2", $data->question35)?'checked':'':'') ?>>
                                <span style="font-family:arial">Distress Spiritual</span>
                            </td>
                        </tr>
                    </table><br><br><br><br>

                    <div style="float: left;margin-top:20px">
                        
                        <center><span style="font-family:arial;">Perawat</span></center>
                        <br><br><br>
                        <center><span style="font-family:arial;">(.....................)</span><center>
                        <center><span style="font-family:arial;">Nama jelas & tanda tangan</span></center>
                    </div>

                    <div style="float: right;">
                        <span style="font-family:arial">Tanggal, <?= isset($asesmen_ulang_terminal_keluarga->tgl_input)?date('d-m-Y',strtotime($asesmen_ulang_terminal_keluarga->tgl_input)):'' ?></span><br>
                        <center><span style="font-family:arial">Dokter</span></center>
                        <br><br><br>
                        <center><span style="font-family:arial;">(.....................)</span><center>
                        <center><span style="font-family:arial;">Nama jelas & tanda tangan</span></center> 
                    </div>

                </div>

                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display:flex;font-size:12px;font-family:arial">
                    <div style="font-family:arial">
                        Hal 2 dari 2
                    </div>
                    <div style="margin-left:500px;font-family:arial">
                    <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?>
                    </div>
            </div>
        </div>

       

       



    </body>
</html>