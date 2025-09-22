<?php
$data = (isset($asuhan_preoperatif->formjson)?json_decode($asuhan_preoperatif->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            /* border-collapse: collapse;
            border: 1px solid black;     */
            width: 100%;
            font-size: 10px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>ASUHAN KEPERAWATAN PRE OPERATIF</h4></center>
            
            <div style="font-size:12px">
                <table width="100%" id="data" border=0 cellpadding="5px">
                    <tr>
                        <td width="25%" style="font-weight:bold">Data Subjektif</td>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question1)?in_array("item1", $data->question1)?'checked':'':'') ?>>
                            <span>Pasien mengeluh nyeri </span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question1)?in_array("item2", $data->question1)?'checked':'':'') ?>>
                            <span>Pasien  mengatakan cemas </span>
                        </td>
                            
                    </tr>

                    <tr>
                        <td width="25%" style="font-weight:bold">Data Objektif </td>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item1", $data->question2)?'checked':'':'') ?>>
                            <span>Banyak bertanya meminta informasi    </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item2", $data->question2)?'checked':'':'') ?>>
                            <span>Pasien terlihat cemas dan tegang </span><br><br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item3", $data->question2)?'checked':'':'') ?>>
                            <span>Salah persepsi    </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item4", $data->question2)?'checked':'':'') ?>>
                            <span>Skala cemas <?= isset($data->question11)?$data->question11:''; ?></span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item5", $data->question2)?'checked':'':'') ?>>
                            <span>Skala nyeri  <?= isset($data->question12)?$data->question12:''; ?></span> <br><br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item6", $data->question2)?'checked':'':'') ?>>
                            <span>TD : <?= isset($data->question4->text1)?$data->question4->text1.' '.'Mmhg':''; ?> </span>&nbsp;&nbsp;&nbsp;
                            <span>Nadi : <?= isset($data->question4->text2)?$data->question4->text2.' '.'x/mnt':''; ?>          </span>&nbsp;&nbsp;&nbsp;
                            <span>Pernafasan : <?= isset($data->question4->text3)?$data->question4->text3.' '.'x/mnt':''; ?>         </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item7", $data->question2)?'checked':'':'') ?>>
                            <span>Wajah meringis      </span><br><br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item8", $data->question2)?'checked':'':'') ?>>
                            <span>Nyeri berkurang</span> <br><br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item9", $data->question2)?'checked':'':'') ?>>
                            <span>Pengetahuan pasien bertambah setelah dilakukan tindakan keperawatan Ditandai dengan : </span> <br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item10", $data->question2)?'checked':'':'') ?>>
                            <span>Pasien terlihat tenang</span> 

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item13", $data->question2)?'checked':'':'') ?>>
                            <span>Cemas berkurang</span> <br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item11", $data->question2)?'checked':'':'') ?>>
                            <span>Menyatakan pemahaman proses penyakit, pengobatan</span> <br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("item12", $data->question2)?'checked':'':'') ?>>
                            <span>Berpartisipasi dalam program pengobatan</span> <br>

                        </td>
                            
                    </tr>

                    <tr>
                        <td style="font-weight:bold">Diagnosa</td>
                        <td>
                            <span>Dx : Nyeri  berhubungan dengan :</span>
                            <p>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item1", $data->question3)?'checked':'':'') ?>>
                            <span>Fraktur </span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item2", $data->question3)?'checked':'':'') ?>>
                            <span>Distensi jaringan oleh inflamasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question3)?in_array("item4", $data->question3)?'checked':'':'') ?>>
                            <span>kerusakan integritas kulit</span> <br>
                            </p>

                            <span>Dx : Kurang pengetahuan tentang kondisi , prognosis dan kebutuhan pengobatan berhubungan dengan :</span>
                            <p>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item1", $data->question6)?'checked':'':'') ?>>
                            <span>Salah interprestasi </span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item2", $data->question6)?'checked':'':'') ?>>
                            <span>Kurang mengenal informasi</span> <br>
                            
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold">Intervensi  dan implementasi mandiri perawat :</td>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item1", $data->question5)?'checked':'':'') ?>>
                            <span>Identifikasi pasien (verbal dan visual)</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item2", $data->question5)?'checked':'':'') ?>>
                            <span>Periksa jenis dan lokasi pembedahan (penandaan lokasi operasi)</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item3", $data->question5)?'checked':'':'') ?>>
                            <span>Periksa kelengkapan konsultasi dan memastikan pemeriksaan radiologi, laboratorium, dll</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item4", $data->question5)?'checked':'':'') ?>>
                            <span>Periksa kelengkapan (informed consent)/ surat izin operasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item5", $data->question5)?'checked':'':'') ?>>
                            <span>Memastikan persediaan darah pengosongan kandung kemih / clysma</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item6", $data->question5)?'checked':'':'') ?>>
                            <span>Memastikan persiapan fisik, puasa/ makan dan minum terakhir , persiapan kulit dan sal. Cerna</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item7", $data->question5)?'checked':'':'') ?>>
                            <span>Kaji nyeri, lokasi, karakteristik, beratnya (skala 0-10) selidiki dan laporkan perubahan nyeri</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item8", $data->question5)?'checked':'':'') ?>>
                            <span>Atur posisi yang nyaman untuk mengurangi nyeri</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item9", $data->question5)?'checked':'':'') ?>>
                            <span>Pertahankan istirahat dan posisi pasien</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item10", $data->question5)?'checked':'':'') ?>>
                            <span>Pasang pengaman brangkar</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item11", $data->question5)?'checked':'':'') ?>>
                            <span>Kaji tingkat kecemasan pasien dan kaji tingkat pengetahuan klien dan keluarga tentang tindakan operasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item12", $data->question5)?'checked':'':'') ?>>
                            <span>Perkenalkan diri dan tim operasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item13", $data->question5)?'checked':'':'') ?>>
                            <span>Perkenalkan pasien dengan lingkungan kamar operasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item14", $data->question5)?'checked':'':'') ?>>
                            <span>Edukasi pasien secara ringkas tentang proses perawatan kamar operasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question5)?in_array("item15", $data->question5)?'checked':'':'') ?>>
                            <span>Evaluasi tingkat pemahaman pasien</span> <br>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold">Tujuan</td>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item1", $data->question7)?'checked':'':'') ?>>
                            <span>Tujuan tercapai nyeri kurang</span>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item3", $data->question7)?'checked':'':'') ?>>
                            <span>Tujuan tidak tercapai nyeri tidak berkurang</span> <br>

                            <input type="checkbox" value="Tidak" style="margin-top:6px" <?= (isset($data->question7)?in_array("item2", $data->question7)?'checked':'':'') ?>>
                            <span>Tujuan tercapai cemas kurang</span> 

                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item4", $data->question7)?'checked':'':'') ?>>
                            <span>Tujuan tidak tercapai cemas tidak berkurang</span> <br>
                        </td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold">Evaluasi</td>
                        <td>
                            <span style="font-weight:bold">S</span>
                            <span style="margin-left:30px">Pasien menyatakan proses penyakit, perawatannya</span><br>

                            <span style="font-weight:bold">O</span>
                                <input style="margin-left:30px;margin-top:6px" type="checkbox" value="Tidak"  <?= (isset($data->question8->{'Row 1'}->{'Column 2'})?in_array("item1", $data->question8->{'Row 1'}->{'Column 2'})?'checked':'':'') ?>>
                                <span>Cemas berkurang skala cemas	: <?= isset($data->question8->{'Row 1'}->{'Column 5'})?$data->question8->{'Row 1'}->{'Column 5'}:'' ?></span> 

                                <input type="checkbox" value="Tidak" <?= (isset($data->question8->{'Row 1'}->{'Column 2'})?in_array("item2", $data->question8->{'Row 1'}->{'Column 2'})?'checked':'':'') ?>>
                                <span>Nyeri berkurang Skal nyeri 	: <?= isset($data->question8->{'Row 1'}->{'Column 6'})?$data->question8->{'Row 1'}->{'Column 6'}:'' ?></span> <br>

                           <span style="font-weight:bold"> A</span>
                                <input style="margin-left:30px;margin-top:6px;" type="checkbox" value="Tidak" <?= (isset($data->question8->{'Row 1'}->{'Column 3'})?in_array("item1", $data->question8->{'Row 1'}->{'Column 3'})?'checked':'':'') ?>>
                                <span>Masalah teratasi </span> 

                                <input type="checkbox" value="Tidak" <?= (isset($data->question8->{'Row 1'}->{'Column 3'})?in_array("item2", $data->question8->{'Row 1'}->{'Column 3'})?'checked':'':'') ?>>
                                <span>Masalah tidak teratasi </span> <br>

                            <span style="font-weight:bold;">P</span>
                            <span style="margin-left:30px;">Intervensi dilanjutkan di intra operatif</span><br>
                        </td>
                    </tr>
                </table><br>

                <p>Perawat Kamar Operasi</p>
                <img  src="<?= (isset($data->question9)?$data->question9:'')?>" width="50px"  height="50px" alt="">
                <p>(<?= isset($data->question10)?$data->question10:'' ?>)</p>
                <span>Tanda tangan dan nama jelas</span>

              

              

            </div>

            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:550px">
                RM.018e / RI
                </div>
           </div>
            
        </div>

        
    </body>
    </html>