<?php
$data = (isset($lap_anestesi->formjson)?json_decode($lap_anestesi->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
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
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>LAPORAN ANESTESI</h4></center>
            
            <div style="font-size:12px">
                <table width="100%" id="data" border="1" cellpadding="3px">
                    <tr>
                        <td colspan="2">
                            <table width="100%">
                                <tr>
                                    <td width="23%">Asal Ruangan</td>
                                    <td width="2%">:</td>
                                    <td width="25%"><?= isset($data->question1->asal_ruangan)?$data->question1->asal_ruangan:'' ?></td>
                                    <td width="23%">Tindakan </td>
                                    <td width="2%">:</td>
                                    <td width="25%"><?= isset($data->question1->tindakan)?$data->question1->tindakan:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Berat Badan</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->bb)?$data->question1->bb:'' ?></td>
                                    <td>Operator</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->operator)?$data->question1->operator:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Tinggi Badan</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->tb)?$data->question1->tb:'' ?></td>
                                    <td>Asisten </td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->asisten)?$data->question1->asisten:'' ?></td>
                                </tr>
                                <tr>
                                    <td>IMT</td>
                                    <td>:</td>
                                    <td><?= isset($data->question22)?$data->question22:'' ?></td>
                                    <td>Dokter Anestesi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->danestesi)?$data->question1->danestesi:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Diagnosis Praoperasi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->praoperatif)?$data->question1->praoperatif:'' ?></td>
                                    <td>Penata Anestesi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->panestesi)?$data->question1->panestesi:'' ?></td>
                                </tr>
                                <tr>
                                    <td>Diagnosis Pascaoperasi</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->pascaoperasi)?$data->question1->pascaoperasi:'' ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="2" style="text-align:center;font-weight:bold">PENILAIAN PRA INDUKSI</td>
                    </tr>
                    <tr>
                        <td colspan="2">Riwayat anestesi dan operasi sebelumnya : <?= isset($data->question2[0]->{'Column 1'})?$data->question2[0]->{'Column 1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Riwayat alergi dan penyakit penyerta : <?= isset($data->question2[0]->{'Column 2'})?$data->question2[0]->{'Column 2'}:'' ?></td>
                    </tr> 
                    <tr>
                        <td colspan="2">Pengobatan saat ini : <?= isset($data->question2[0]->{'Column 3'})?$data->question2[0]->{'Column 3'}:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span>Kesadaran : <?= isset($data->question2[0]->{'Column 4'})?$data->question2[0]->{'Column 4'}:'' ?>  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>Tekanan darah : <?= isset($data->question2[0]->{'Column 5'})?$data->question2[0]->{'Column 5'}:'' ?>  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>Nadi : <?= isset($data->question2[0]->{'Column 6'})?$data->question2[0]->{'Column 6'}:'' ?>  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span> Pernafasan : <?= isset($data->question2[0]->{'Column 7'})?$data->question2[0]->{'Column 7'}:'' ?>  </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>  Suhu : <?= isset($data->question2[0]->{'Column 8'})?$data->question2[0]->{'Column 8'}:'' ?>  </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">Dengan udara bebas/ O2 <?= isset($data->question2[0]->{'Column 9'})?$data->question2[0]->{'Column 9'}:'' ?>  Liter/menit via <?= isset($data->question2[0]->{'Column 1'})?$data->question2[0]->{'Column 1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <span>Pemeriksaan Penunjang : <?= isset($data->question2[0]->{'Column 10'})?$data->question2[0]->{'Column 10'}:'' ?></span>
                            <p style="min-height:30px"></p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table width="100%">
                                <tr>
                                    <td width="25%">Ceklist persiapan anestesi :</td>
                                    <td width="25%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->ceklist)?in_array("persetujuan", $data->ceklist)?'checked':'':'') ?>>
                                        <span>Persetujuan anestesi </span>
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->ceklist)?in_array("obat_anestesi", $data->ceklist)?'checked':'':'') ?>>
                                        <span>Obat-obatan anestesi </span>
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->ceklist)?in_array("talaksana", $data->ceklist)?'checked':'':'') ?>>
                                        <span>Tatalaksana Jalan Napas </span>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="25%"></td>
                                    <td width="25%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->ceklist)?in_array("alat_monitoring", $data->ceklist)?'checked':'':'') ?>>
                                        <span>Alat monitoring </span>
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->ceklist)?in_array("obat_emergency", $data->ceklist)?'checked':'':'') ?>>
                                        <span>Obat-obat emergency </span>
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->ceklist)?in_array("mesin", $data->ceklist)?'checked':'':'') ?>>
                                        <span>Mesin Anestesi </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">ASA   :  <?= isset($data->question34)?$data->question34:'' ?></td>
                    </tr>
                    <tr>
                        <td>Puasa mulai pukul         :<?= isset($data->question4[0]->{'Column 1'})?date('h:i',strtotime($data->question4[0]->{'Column 1'})):'' ?></td>
                        <td width="50%">Tanggal     :<?= isset($data->question4[0]->{'Column 1'})?date('d-m-Y',strtotime($data->question4[0]->{'Column 1'})):'' ?></td>
                    </tr>
                    <tr>
                        <td>Premedikasi  : <?= isset($data->question4[0]->premedikasi)?$data->question4[0]->premedikasi:'' ?></td>
                        <td width="50%">Rute           : <?= isset($data->question4[0]->rute)?$data->question4[0]->rute:'' ?>   Jam :  <?= isset($data->question4[0]->{'Column 2'})?$data->question4[0]->{'Column 2'}:'' ?></td>
                    </tr>
                </table>
                <table width="100%" id="data" border="1" cellpadding="3px">
                    <tr>
                        <td width="15%" rowspan="2">Time Out</td>
                        <td width="15%" rowspan="2">Waktu</td>      
                        <td>
                            <span>Masuk OK  : <?= isset($data->question5->text1)?$data->question5->text1:'' ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span> Insisi  : <?= isset($data->question5->text2)?$data->question5->text2:'' ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>Akhir operasi : <?= isset($data->question5->text3)?$data->question5->text3:'' ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                                        
                        <td>
                            <span>Mulai Anestesi  : <?= isset($data->question5->text4)?$data->question5->text4:'' ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span>  Akhir anestesi  : <?= isset($data->question5->text5)?$data->question5->text5:'' ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                            <span> Total : <?= isset($data->question5->text6)?$data->question5->text6:'' ?> </span>&nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <span>Teknik Anestesi :</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item1", $data->question6)?'checked':'':'') ?>>
                                <span>Anestesi Umum </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item2", $data->question6)?'checked':'':'') ?>>
                                <span>Anestesi Regiona</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item3", $data->question6)?'checked':'':'') ?>>
                                <span>CEGA</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item4", $data->question6)?'checked':'':'') ?>>
                                <span>Konversi</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item5", $data->question6)?'checked':'':'') ?>>
                                <span>Sedasi</span>
                                <input type="checkbox" value="Tidak" <?= (isset($data->question6)?in_array("item6", $data->question6)?'checked':'':'') ?>>
                                <span>Blokperifer</span>
                    </td>
                    </tr>
                </table>
                <table width="100%" id="data" border="1" cellpadding="3px">
                    <tr>
                        <td width="30%"  style="text-align:center">Monitor </td>
                        <td colspan="4" style="text-align:center">Jalur Intravena dan Monitoring Masif</td>
                        <td width="30%" style="text-align:center">Peralatan Lainnya </td>
                    </tr>

                    <tr>
                        <td rowspan="2">
                            <table width="100%">
                                <tr>
                                    <td width="50%">
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item1", $data->question35)?'checked':'':'') ?>>
                                        <span>NIBP</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item2", $data->question35)?'checked':'':'') ?>>
                                        <span>EKG</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item3", $data->question35)?'checked':'':'') ?>>
                                        <span>SPO2</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item4", $data->question35)?'checked':'':'') ?>>
                                        <span>Temp</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item5", $data->question35)?'checked':'':'') ?>>
                                        <span>IBP / Arteria Line</span>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item6", $data->question35)?'checked':'':'') ?>>
                                        <span> EtCO2</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item7", $data->question35)?'checked':'':'') ?>>
                                        <span>Prekordial</span><br>
                                        <input type="checkbox" value="Tidak" <?= (isset($data->question35)?in_array("item8", $data->question35)?'checked':'':'') ?>>
                                        <span>BIS</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="10%" style="text-align:center">Jalur</td>
                        <td width="10%" style="text-align:center">Ukuran</td>
                        <td width="10%" style="text-align:center">Sisi</td>
                        <td width="10%" style="text-align:center">Letak</td>
                        <td rowspan="2">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item1", $data->question7)?'checked':'':'') ?>>
                            <span> Penghangat Cairan</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item2", $data->question7)?'checked':'':'') ?>>
                            <span> Penghangat darah</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item3", $data->question7)?'checked':'':'') ?>>
                            <span>  Infusion pump</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item4", $data->question7)?'checked':'':'') ?>>
                            <span> Syiringe pump</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item5", $data->question7)?'checked':'':'') ?>>
                            <span> Warm air blanket</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item6", $data->question7)?'checked':'':'') ?>>
                            <span> Blanked roll</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item7", $data->question7)?'checked':'':'') ?>>
                            <span> Kateter foley no : <?= isset($data->question37)?$data->question37:'' ?></span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question7)?in_array("item8", $data->question7)?'checked':'':'') ?>>
                            <span> NGT no : <?= isset($data->question38)?$data->question38:'' ?></span><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            
                            <span> IV #1</span><br>
                            
                            <span>  IV #2</span><br>
                            
                            <span> IV #3</span><br>
                            
                            <span> CVC</span><br>
                            
                            <span>  IBP / Arteria Line</span>
                        </td>
                        <td>
                            <span><?= isset($data->question36->{'Row 2'}->{'Column 1'})?$data->question36->{'Row 2'}->{'Column 1'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 3'}->{'Column 1'})?$data->question36->{'Row 3'}->{'Column 1'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 4'}->{'Column 1'})?$data->question36->{'Row 4'}->{'Column 1'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 5'}->{'Column 1'})?$data->question36->{'Row 5'}->{'Column 1'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 6'}->{'Column 1'})?$data->question36->{'Row 6'}->{'Column 1'}:'' ?></span>
                        </td>
                        <td>
                            <span><?= isset($data->question36->{'Row 2'}->{'Column 2'})?$data->question36->{'Row 2'}->{'Column 2'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 3'}->{'Column 2'})?$data->question36->{'Row 3'}->{'Column 2'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 4'}->{'Column 2'})?$data->question36->{'Row 4'}->{'Column 2'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 5'}->{'Column 2'})?$data->question36->{'Row 5'}->{'Column 2'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 6'}->{'Column 2'})?$data->question36->{'Row 6'}->{'Column 2'}:'' ?></span>
                        </td>
                        <td>
                            <span><?= isset($data->question36->{'Row 2'}->{'Column 3'})?$data->question36->{'Row 2'}->{'Column 3'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 3'}->{'Column 3'})?$data->question36->{'Row 3'}->{'Column 3'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 4'}->{'Column 3'})?$data->question36->{'Row 4'}->{'Column 3'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 5'}->{'Column 3'})?$data->question36->{'Row 5'}->{'Column 3'}:'' ?></span><br>
                            <span><?= isset($data->question36->{'Row 6'}->{'Column 3'})?$data->question36->{'Row 6'}->{'Column 3'}:'' ?></span>
                        </td>
                    </tr>
                </table>

                <table width="100%" id="data" border="1" cellpadding="3px">
                    <tr>
                        <th width=25% >Posisi Pasien Selama Operasi</th>
                        <th width=25% >Lengan</th>
                        <th width=25% >Mata</th>
                        <th width=25% >Badan</th>
                    </tr>
                    <tr>
                        <td  width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item1" ? "checked":'':'' ?>>
                            <span>Supine</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item2" ? "checked":'':'' ?>>
                            <span>Semi Fowler</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item3" ? "checked":'':'' ?>>
                            <span>Lithotomi</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item4" ? "checked":'':'' ?>>
                            <span>Duduk</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item5" ? "checked":'':'' ?>>
                            <span>Prone</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item6" ? "checked":'':'' ?>>
                            <span>Lateral decubitus kiri</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item7" ? "checked":'':'' ?>>
                            <span> Jack Knife</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item8" ? "checked":'':'' ?>>
                            <span>Lateral decubitus kanan</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item9" ? "checked":'':'' ?>>
                            <span>Trendelenberg</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column1'})? $data->question8[0]->{'column1'} == "item10" ? "checked":'':'' ?>>
                            <span>Reverse Trendelenberg</span>
                            
                        </td>
                        <td  width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column2'})? $data->question8[0]->{'column2'} == "item1" ? "checked":'':'' ?>>
                            <span>Sudut < 90</span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column2'})? $data->question8[0]->{'column2'} == "item2" ? "checked":'':'' ?>>
                            <span>Bantalan Aksilar</span>
                        </td>
                        <td  width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column3'})? $data->question8[0]->{'column3'} == "item1" ? "checked":'':'' ?>>
                            <span>Lubrikasi</span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column3'})? $data->question8[0]->{'column3'} == "item2" ? "checked":'':'' ?>>
                            <span>Bantalan Tambahan</span>
                        </td>
                        <td  width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column4'})? $data->question8[0]->{'column4'} == "item1" ? "checked":'':'' ?>>
                            <span>Bantalan Punggung</span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question8[0]->{'column4'})? $data->question8[0]->{'column4'} == "item2" ? "checked":'':'' ?>>
                            <span>Bantalan Tungkai</span>
                        </td>
                    </tr>
                
                </table>

                <table width="100%" id="data" border="1" cellpadding="3px">
                    <tr>
                        <th coslpan="4"><center>PENATALAKSANAAN JALAN NAPAS</center></th>  
                    </tr>
                    <tr>
                        <td width="25%" style="text-align:center">Induksi</td>
                        <td width="25%" style="text-align:center">ETT</td>
                        <td width="25%" style="text-align:center">Alat Bantu</td>
                        <td width="25%" style="text-align:center">Konfirmasi</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column1)?in_array("item1", $data->question9[0]->column1)?'checked':'':'') ?>>
                            <span> Inhalasi</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column1)?in_array("item2", $data->question9[0]->column1)?'checked':'':'') ?>>
                            <span>  Intravena</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column1)?in_array("item3", $data->question9[0]->column1)?'checked':'':'') ?>>
                            <span> Preoksigenisasi</span><br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column1)?in_array("item4", $data->question9[0]->column1)?'checked':'':'') ?>>
                            <span> Rapid Sequence Induction</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column1)?in_array("item5", $data->question9[0]->column1)?'checked':'':'') ?>>
                            <span> Penekanan Krikoid</span><br>
                            <span>Jalan Napas :</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column4)?in_array("item1", $data->question9[0]->column4)?'checked':'':'') ?>>
                            <span>Sungkup Muka</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column4)?in_array("item2", $data->question9[0]->column4)?'checked':'':'') ?>>
                            <span>Oral</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column4)?in_array("item3", $data->question9[0]->column4)?'checked':'':'') ?>>
                            <span> LMA</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column4)?in_array("item4", $data->question9[0]->column4)?'checked':'':'') ?>>
                            <span>Nasal</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column4)?in_array("item5", $data->question9[0]->column4)?'checked':'':'') ?>>
                            <span>Trakeostomi</span><br>
                        </td>
                        <td>
                            <span>Tipe : <?= isset($data->ett[0]->{'Column 1'})?$data->ett[0]->{'Column 1'}:'' ?> </span>
                            <span>Ukuran LMA : <?= isset($data->ett[0]->{'Column 7'})?$data->ett[0]->{'Column 7'}:'' ?> </span><br>
                            <span>Kedalaman : <?= isset($data->ett[0]->{'Column 3'})?$data->ett[0]->{'Column 3'}:'' ?></span><br>
                            <span>Cuffed : </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->ett[0]->{'Column 4'})?$data->ett[0]->{'Column 4'} == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->ett[0]->{'Column 4'})?$data->ett[0]->{'Column 4'} == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span><br>
                            <span>Pack :</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->ett[0]->{'Column 5'})?$data->ett[0]->{'Column 5'} == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->ett[0]->{'Column 5'})?$data->ett[0]->{'Column 5'} == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span><br>
                            <span>Pengulangan / Reintubasi : <?= isset($data->ett[0]->{'Column 6'})?$data->ett[0]->{'Column 6'}:'' ?></span><br>
                            <span>Ukuran : <?= isset($data->ett[0]->{'Column 2'})?$data->ett[0]->{'Column 2'}:'' ?></span><br>

                        </td>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item1", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span> Direct laryngoscope</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item2", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span>Mandrin/Stylet</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item3", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span>Fiberoptik</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item4", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span>Tube changer style</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item5", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span>Teknik blind</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item6", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span>Teknik awake</span><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question9[0]->column2)?in_array("item7", $data->question9[0]->column2)?'checked':'':'') ?>>
                            <span> Sudah terintubasi</span>
                        
                        </td>
                        <td>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question9[0]->column3)?in_array("item1", $data->question9[0]->column3)?'checked':'':'') ?>>
                            <span>EtCO2</span><br>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question9[0]->column3)?in_array("item2", $data->question9[0]->column3)?'checked':'':'') ?>>
                            <span>Suara nafas vesikuler bilateral</span><br>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question9[0]->column3)?in_array("item3", $data->question9[0]->column3)?'checked':'':'') ?>>
                            <span>Pipa Sudah diplester</span><br>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question9[0]->column3)?in_array("item4", $data->question9[0]->column3)?'checked':'':'') ?>>
                            <span>Sulit ventilasi</span><br>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question9[0]->column3)?in_array("item5", $data->question9[0]->column3)?'checked':'':'') ?>>
                            <span>Sulit Intubasi</span><br>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question9[0]->column3)?in_array("other", $data->question9[0]->column3)?'checked':'':'') ?>>
                            <span>Dll, <?= isset($data->question9[0]->{'column3-Comment'})?$data->question9[0]->{'column3-Comment'}:'' ?></span><br>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <span>Teknik  : </span>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question10[0]->column1)?in_array("spinal", $data->question10[0]->column1)?'checked':'':'') ?>>
                            <span>Spinal </span>
                           
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question10[0]->column1)?in_array("epidural", $data->question10[0]->column1)?'checked':'':'') ?>>
                            <span>Epidural</span>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question10[0]->column1)?in_array("kaudal", $data->question10[0]->column1)?'checked':'':'') ?>>
                            <span>Kaudal</span>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question10[0]->column1)?in_array("intravena", $data->question10[0]->column1)?'checked':'':'') ?>>
                         
                            <span> Blok Perifer</span><br>
                            <span >Lokasi Tusukan : <?= isset($data->question10[0]->{'column2'})?$data->question10[0]->{'column2'}:'' ?></span>
                          
                            <span style="margin-left:50px"> Jenis jarum :  <?= isset($data->question10[0]->{'column4'})?$data->question10[0]->{'column4'}:'' ?>  </span>
                            <span style="margin-left:50px"> Ukuran jarum :  <?= isset($data->question10[0]->{'column15'})?$data->question10[0]->{'column15'}:'' ?>  </span>
                            <br>
                            <span >Anestesi Lokal   : <?= isset($data->question10[0]->{'column5'})?$data->question10[0]->{'column5'}:'' ?></span>
                            <span style="margin-left:50px">Kosentrasi       :       <?= isset($data->question10[0]->{'column6'})?$data->question10[0]->{'column6'}:'' ?>  </span>
                            <span style="margin-left:50px">  Jumlah :   <?= isset($data->question10[0]->{'column7'})?$data->question10[0]->{'column7'}:'' ?>  </span>
                            <br>
                            <span >Obat Tambahan :  <?= isset($data->question10[0]->{'column8'})?$data->question10[0]->{'column8'}:'' ?></span>
                            <span style="margin-left:50px">Dosis : <?= isset($data->question10[0]->{'column9'})?$data->question10[0]->{'column9'}:'' ?> </span>
                          
                            <br>
                           
                            <span >Komplikasi : <?= isset($data->question10[0]->{'column13'})?$data->question10[0]->{'column13'}:'' ?></span>
                            <br> 
                            <span >Hasil :</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10[0]->{'column14'})? $data->question10[0]->{'column14'} == "item1" ? "checked":'':'' ?>>
                            <span> Partial Block</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10[0]->{'column14'})? $data->question10[0]->{'column14'} == "item2" ? "checked":'':'' ?>>
                            <span> Gagal</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10[0]->{'column14'})? $data->question10[0]->{'column14'} == "item3" ? "checked":'':'' ?>>
                            <span> Total Block  </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10[0]->{'column14'})? $data->question10[0]->{'column14'} == "item4" ? "checked":'':'' ?>>
                            <span> Sempurna</span>
                        </td>
                       
                    </tr>


                </table>
                <div style="display:flex;font-size:10px">
                    <div>
                        Hal 1 dari 4
                    </div>
                    <div style="margin-left:470px">
                        Rev.08.02.2021.RM-019d / RI
                    </div>
                </div>
           </div>            
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>LAPORAN ANESTESI</h4></center>
            
            <div style="font-size:12px">

            <table width="100%" border="1" id="data">
                <tr><td colspan="2" style="font-weight:bold;text-align:center">PEMANTAUAN SELAMA ANESTESI</td></tr>
                <tr><td colspan="2" style="text-align:center">Jam <?= isset($data->question11)?$data->question11:'' ?></td></tr>
                <tr>
                    <td width="20%">
                        <span>SIMBOL</span>
                        <p>Anestesi</p>
                        <span style="margin-left:20px">Operasi</span><br>
                        <span> x→ Mulai</span>
                        <span style="margin-left:20px">○→ Mulai</span><br>
                        <span>  ←x Akhir </span>
                        <span style="margin-left:20px">←○ Akhir</span><br>
                        <p>Tekanan Darah</p>
                        <span>˅ NIBP Sistolik</span><br>
                        <span>˄ NIBP Diastolik</span><br><br>
                        <span>● Nadi</span><br>
                        <span>x  SpO2</span><br><br>
                        <span>Respirasi</span><br><br>
                       
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3->{'Row 1'}->{'Column 1'})? $data->question3->{'Row 1'}->{'Column 1'} == "item1" ? "checked":'':'' ?>>
                        <span> Manual</span> <br>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question3->{'Row 1'}->{'Column 1'})? $data->question3->{'Row 1'}->{'Column 1'} == "item2" ? "checked":'':'' ?>>
                        <span> Ventilator</span> <br><br>
                        <span>Mode : <?= isset($data->question3->{'Row 1'}->{'Column 3'})?$data->question3->{'Row 1'}->{'Column 3'}:'' ?></span><br>
                        <span>Rate :   <?= isset($data->question3->{'Row 1'}->{'Column 3'})?$data->question3->{'Row 1'}->{'Column 3'}:'' ?> x/menit</span><br>
                        <span>TV :  <?= isset($data->question3->{'Row 1'}->{'Column 4'})?$data->question3->{'Row 1'}->{'Column 4'}:'' ?>  ml</span><br>
                        <span>PEEP : <?= isset($data->question3->{'Row 1'}->{'Column 5'})?$data->question3->{'Row 1'}->{'Column 5'}:'' ?> cmH20</span><br>
                        

                        <p>Satu Kotak Kecil = Interval 5 menit</p>
                                 
                    </td> 
                </tr>
            </table>

            <div style="position:absolute;bottom:650;right:38">
                    <div style="position:absolute;bottom:0%;right:0%;">
                        <?php
                        if(isset($data->question43)){
                        ?>
                            <img src=" <?= $data->question43 ?>"  alt="img" height="250px" width="550px">
                        <?php } ?>
                    </div>
                    <img src="<?= base_url('assets/images/grafik_laporan_anes_new.PNG') ?>" height="250px" width="550px" alt="">

                </div>
            <table width="100%" border="1" id="data">
          

                <tr>
                    <td width="10%">Temperatur</td>
                      <td width="3%"><br></td>
                    <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 2'})?$data->question12[$x]->{'Column 2'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">Urine Output</td>
                      <td width="3%"><br></td>
                    <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 3'})?$data->question12[$x]->{'Column 3'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">Blood Loss</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 4'})?$data->question12[$x]->{'Column 4'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">CVP</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 5'})?$data->question12[$x]->{'Column 5'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">EtCO2</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 6'})?$data->question12[$x]->{'Column 6'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">Posisi</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 7'})?$data->question12[$x]->{'Column 7'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">Obat-obatan:</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 8'})?$data->question12[$x]->{'Column 8'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">O2</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 9'})?$data->question12[$x]->{'Column 9'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"><?= isset($data->question12[0]->{'Column 16'})?$data->question12[0]->{'Column 16'}:'air/N2O' ?></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 10'})?$data->question12[$x]->{'Column 10'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">Volatil</td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%">
                        <?= isset($data->question12[$x]->{'Column 11'})?$data->question12[$x]->{'Column 11'}:'' ?>
                        <?= isset($data->question12[$x]->{'Column 17'})?$data->question12[$x]->{'Column 17'}:'' ?>
                    </td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%">Intravena</td>
                    <td width="3%"><?= isset($data->question12[$x]->{'Column 14'})?$data->question12[$x]->{'Column 14'}:'' ?></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"><?= isset($data->question12[$x]->{'Column 12'})?$data->question12[$x]->{'Column 12'}:'' ?></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>


                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                 <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"><?= isset($data->question12[0]->{'Column 18'})?$data->question12[0]->{'Column 18'}:'Infus/Transfusi' ?></td>
                    <td width="3%"><?= isset($data->question12[$x]->{'Column 15'})?$data->question12[$x]->{'Column 15'}:'' ?></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%">
                        <?= isset($data->question12[$x]->{'Column 13'})?$data->question12[$x]->{'Column 13'}:'' ?>
                       
                    </td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>
                   <tr>
                    <td width="10%"></td>
                    <td width="3%"><br></td>
                   <?php 
                    $jml_array = isset($data->question12)?count($data->question12):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <td width="2%"></td>
                    <?php }
                    
                    if($jml_array<=24){
                    $jml_kurang = 24 - $jml_array;
                    for($x = 0; $x < $jml_kurang; $x++){
                    ?>
                        <td width="2%"><br></td>
                    <?php }} ?>
                    <td width="2%"></td>
                </tr>

              
            </table>

            <table width="100%" border="1" id="data">
                <tr>
                    <td width="30%">
                        <span style="font-weight:bold">Operasi Sectio Cesaria</span><br>
                        <p>Lahir</p>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question13[0]->column1)?in_array('mati',$data->question13[0]->column1)?'checked':'':'') ?>>
                        <span>Mati  </span> 
                        <input type="checkbox" value="Tidak" <?= (isset($data->question13[0]->column1)?in_array('hidup',$data->question13[0]->column1)?'checked':'':'') ?>>
                        <span>Hidup  </span> <br><br>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question13[0]->column1)?in_array('laki',$data->question13[0]->column1)?'checked':'':'') ?>>
                        <span>Laki laki  </span> 
                        <input type="checkbox" value="Tidak" <?= (isset($data->question13[0]->column1)?in_array('perempuan',$data->question13[0]->column1)?'checked':'':'') ?>>
                        <span>Perempuan  </span> 
                        <p style="text-align:center">APGAR Score:</p>
                        <span>5': </span>
                        <span style="margin-left:20px">10': : </span>
                    </td>

                    <td width="40%">
                        <span>Catatan</span>
                        <p><?= isset($data->question13[0]->column2)?$data->question13[0]->column2:'' ?></p>
                    </td>

                    <td width="30%">Bukttinggi, <?= isset($lap_anestesi->tgl_input)?date('d-m-Y',strtotime($lap_anestesi->tgl_input)):'' ?> Jam <?= isset($lap_anestesi->tgl_input)?date('h:i',strtotime($lap_anestesi->tgl_input)):'' ?></span>
                        <p style="text-align:center">Dokter Anestesi</p>
                        <?php
                        $id = isset($lap_anestesi->id_pemeriksa)?$lap_anestesi->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                           <center> <img width="70px" src="<?= $query->ttd ?>" alt=""><br></center>
                           <center>(<?= $query->name ?>)<br></center>
                        <?php
                            } else {?>
                                <br><br><br>
                    <?php } ?>
                        <p style="text-align:center">Tanda Tangan & Nama Terang</p>
                    </td>
                </tr>
            </table><br><br>
            <div style="display:flex;font-size:10px">
                    <div>
                        Hal 2 dari 4
                    </div>
                    <div style="margin-left:470px">
                        Rev.08.02.2021.RM-019d / RI
                    </div>
                </div>
            </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>LAPORAN ANESTESI</h4></center>
            
            <div style="font-size:12px">
                <table width="100%" border="1" id="data">
                    <tr>
                        <td colspan="4" style="text-align:center;font-weight:bold">PEMANTAUAN DI RUANG PEMULIHAN</td>
                    </tr>
                    <tr>
                        <td>Tanggal masuk: <?= isset($data->question17->text1)?$data->question17->text1:'' ?></td>
                        <td> Jam :  <?= isset($data->question17->text2)?$data->question17->text2:'' ?>    </td>
                        <td colspan="2"> Perawat Ruang Pemulihan : <?= isset($data->question17->text3)?$data->question17->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="25%" style="text-align:center;font-weight:bold">Kesadaran </td>
                        <td width="25%" style="text-align:center;font-weight:bold">Tanda Vital</td>
                        <td width="25%" style="text-align:center;font-weight:bold">Jalan Napas</td>
                        <td width="25%" style="text-align:center;font-weight:bold">Suhu</td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column1)?in_array('item1',$data->question18[0]->column1)?'checked':'':'') ?>>
                            <span>Alert</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column1)?in_array('item2',$data->question18[0]->column1)?'checked':'':'') ?>>
                            <span>Verbal</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column1)?in_array('item3',$data->question18[0]->column1)?'checked':'':'') ?>>
                            <span>Pain</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column1)?in_array('item4',$data->question18[0]->column1)?'checked':'':'') ?>>
                            <span>Unresponsive</span> <br> 
                        </td>
                        <td>
                            <span>NIBP <?= isset($data->question18[0]->column2)?$data->question18[0]->column2:'....' ?> mmHg</span><br>
                            <span>Nadi <?= isset($data->question18[0]->column3)?$data->question18[0]->column3:'....' ?> x/menit</span><br>
                            <span>Respirasi  <?= isset($data->question18[0]->column4)?$data->question18[0]->column4:'....' ?> x/menit</span><br>
                            <span>SpO2   <?= isset($data->question18[0]->column5)?$data->question18[0]->column5:'....' ?>  %</span><br>
                        </td>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item1',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>Kanul Binasal</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item3',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>Simple Mask</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item2',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>Mayo </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item4',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>SMNR</span> <br> 
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item5',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>ETT  </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item6',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>T-piece</span> <br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18[0]->column6)?in_array('item7',$data->question18[0]->column6)?'checked':'':'') ?>>
                            <span>Trakeastomi</span>
                        </td>
                        <td><?= isset($data->question18[0]->column7)?$data->question18[0]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align:center;font-weight:bold"></td>
                    </tr>
                </table>

                <table width="100%" border="1" id="data">
                    <tr>
                        <td rowspan="2" width="15%" style="text-align:center">PEMANTAUAN</td>
                        <td rowspan="2" width="8%" style="text-align:center">Jam</td>
                        <td style="text-align:center">15'</td>
                        <td style="text-align:center">30'</td>
                        <td style="text-align:center">45'</td>
                        <td style="text-align:center">60'</td>
                        <td style="text-align:center">90'</td>
                        <td style="text-align:center">120'</td>
                        <td style="text-align:center">180'</td>
                        <td style="text-align:center">240'</td>
                        <td style="text-align:center">240'</td>
                        <td style="text-align:center">300'</td>
                        <td style="text-align:center">360'</td>
                        <td style="text-align:center">420'</td>
                        <td style="text-align:center">480'</td>
                        <td style="text-align:center">540'</td>
                    </tr>
                    <tr>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 1'})?$data->question19->{'Row 14'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 2'})?$data->question19->{'Row 14'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 3'})?$data->question19->{'Row 14'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 4'})?$data->question19->{'Row 14'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 5'})?$data->question19->{'Row 14'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 6'})?$data->question19->{'Row 14'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 7'})?$data->question19->{'Row 14'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 8'})?$data->question19->{'Row 14'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 9'})?$data->question19->{'Row 14'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 10'})?$data->question19->{'Row 14'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 11'})?$data->question19->{'Row 14'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 12'})?$data->question19->{'Row 14'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 14'}->{'Column 13'})?$data->question19->{'Row 14'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Kesadaran</td>
                        <td></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 1'})?$data->question19->{'Row 1'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 2'})?$data->question19->{'Row 1'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 3'})?$data->question19->{'Row 1'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 4'})?$data->question19->{'Row 1'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 5'})?$data->question19->{'Row 1'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 6'})?$data->question19->{'Row 1'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 7'})?$data->question19->{'Row 1'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 8'})?$data->question19->{'Row 1'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 9'})?$data->question19->{'Row 1'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 10'})?$data->question19->{'Row 1'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 11'})?$data->question19->{'Row 1'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 12'})?$data->question19->{'Row 1'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 1'}->{'Column 13'})?$data->question19->{'Row 1'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Tekanan Darah Sistolik</td>
                        <td style="text-align:center">mmHg</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 1'})?$data->question19->{'Row 2'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 2'})?$data->question19->{'Row 2'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 3'})?$data->question19->{'Row 2'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 4'})?$data->question19->{'Row 2'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 5'})?$data->question19->{'Row 2'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 6'})?$data->question19->{'Row 2'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 7'})?$data->question19->{'Row 2'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 8'})?$data->question19->{'Row 2'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 9'})?$data->question19->{'Row 2'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 10'})?$data->question19->{'Row 2'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 11'})?$data->question19->{'Row 2'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 12'})?$data->question19->{'Row 2'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 2'}->{'Column 13'})?$data->question19->{'Row 2'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Tekanan Darah Diastolik</td>
                        <td style="text-align:center">mmHg</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 1'})?$data->question19->{'Row 3'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 2'})?$data->question19->{'Row 3'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 3'})?$data->question19->{'Row 3'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 4'})?$data->question19->{'Row 3'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 5'})?$data->question19->{'Row 3'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 6'})?$data->question19->{'Row 3'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 7'})?$data->question19->{'Row 3'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 8'})?$data->question19->{'Row 3'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 9'})?$data->question19->{'Row 3'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 10'})?$data->question19->{'Row 3'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 11'})?$data->question19->{'Row 3'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 12'})?$data->question19->{'Row 3'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 3'}->{'Column 13'})?$data->question19->{'Row 3'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Nadi</td>
                        <td style="text-align:center">x/menit</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 1'})?$data->question19->{'Row 4'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 2'})?$data->question19->{'Row 4'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 3'})?$data->question19->{'Row 4'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 4'})?$data->question19->{'Row 4'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 5'})?$data->question19->{'Row 4'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 6'})?$data->question19->{'Row 4'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 7'})?$data->question19->{'Row 4'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 8'})?$data->question19->{'Row 4'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 9'})?$data->question19->{'Row 4'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 10'})?$data->question19->{'Row 4'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 11'})?$data->question19->{'Row 4'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 12'})?$data->question19->{'Row 4'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 4'}->{'Column 13'})?$data->question19->{'Row 4'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Respirasi</td>
                        <td style="text-align:center">x/menit</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 1'})?$data->question19->{'Row 5'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 2'})?$data->question19->{'Row 5'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 3'})?$data->question19->{'Row 5'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 4'})?$data->question19->{'Row 5'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 5'})?$data->question19->{'Row 5'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 6'})?$data->question19->{'Row 5'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 7'})?$data->question19->{'Row 5'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 8'})?$data->question19->{'Row 5'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 9'})?$data->question19->{'Row 5'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 10'})?$data->question19->{'Row 5'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 11'})?$data->question19->{'Row 5'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 12'})?$data->question19->{'Row 5'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 5'}->{'Column 13'})?$data->question19->{'Row 5'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Suhu</td>
                        <td style="text-align:center">◦C</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 1'})?$data->question19->{'Row 6'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 2'})?$data->question19->{'Row 6'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 3'})?$data->question19->{'Row 6'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 4'})?$data->question19->{'Row 6'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 5'})?$data->question19->{'Row 6'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 6'})?$data->question19->{'Row 6'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 7'})?$data->question19->{'Row 6'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 8'})?$data->question19->{'Row 6'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 9'})?$data->question19->{'Row 6'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 10'})?$data->question19->{'Row 6'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 11'})?$data->question19->{'Row 6'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 12'})?$data->question19->{'Row 6'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 6'}->{'Column 13'})?$data->question19->{'Row 6'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>SpO2</td>
                        <td style="text-align:center">%</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 1'})?$data->question19->{'Row 7'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 2'})?$data->question19->{'Row 7'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 3'})?$data->question19->{'Row 7'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 4'})?$data->question19->{'Row 7'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 5'})?$data->question19->{'Row 7'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 6'})?$data->question19->{'Row 7'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 7'})?$data->question19->{'Row 7'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 8'})?$data->question19->{'Row 7'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 9'})?$data->question19->{'Row 7'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 10'})?$data->question19->{'Row 7'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 11'})?$data->question19->{'Row 7'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 12'})?$data->question19->{'Row 7'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 7'}->{'Column 13'})?$data->question19->{'Row 7'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Skor Nyeri</td>
                        <td style="text-align:center">%</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 1'})?$data->question19->{'Row 8'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 2'})?$data->question19->{'Row 8'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 3'})?$data->question19->{'Row 8'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 4'})?$data->question19->{'Row 8'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 5'})?$data->question19->{'Row 8'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 6'})?$data->question19->{'Row 8'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 7'})?$data->question19->{'Row 8'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 8'})?$data->question19->{'Row 8'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 9'})?$data->question19->{'Row 8'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 10'})?$data->question19->{'Row 8'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 11'})?$data->question19->{'Row 8'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 12'})?$data->question19->{'Row 8'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 8'}->{'Column 13'})?$data->question19->{'Row 8'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>
                        <input type="checkbox" value="Tidak" <?= (isset($data->question39)?in_array('item1',$data->question39)?'checked':'':'') ?>>
                        <span>NRS</span>  
                        <input type="checkbox" value="Tidak" <?= (isset($data->question39)?in_array('item2',$data->question39)?'checked':'':'') ?>>
                        <span>Wong Baker</span> 
                        </td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                      
                    </tr>
                    <tr>
                        <td>  
                        <input type="checkbox" value="Tidak" <?= (isset($data->question39)?in_array('item3',$data->question39)?'checked':'':'') ?>>
                        <span>VAS, <?= isset($data->question23)?$data->question23:'' ?></span> 
                        </td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                      
                    </tr>
                    <tr>
                        <td>Diuresis</td>
                        <td style="text-align:center">ml</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 1'})?$data->question19->{'Row 9'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 2'})?$data->question19->{'Row 9'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 3'})?$data->question19->{'Row 9'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 4'})?$data->question19->{'Row 9'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 5'})?$data->question19->{'Row 9'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 6'})?$data->question19->{'Row 9'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 7'})?$data->question19->{'Row 9'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 8'})?$data->question19->{'Row 9'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 9'})?$data->question19->{'Row 9'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 10'})?$data->question19->{'Row 9'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 11'})?$data->question19->{'Row 9'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 12'})?$data->question19->{'Row 9'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 9'}->{'Column 13'})?$data->question19->{'Row 9'}->{'Column 13'}:'' ?></td>
                      
                    </tr>
                    <tr>
                        <td>Drain</td>
                        <td style="text-align:center">ml</td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 1'})?$data->question19->{'Row 10'}->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 2'})?$data->question19->{'Row 10'}->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 3'})?$data->question19->{'Row 10'}->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 4'})?$data->question19->{'Row 10'}->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 5'})?$data->question19->{'Row 10'}->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 6'})?$data->question19->{'Row 10'}->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 7'})?$data->question19->{'Row 10'}->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 8'})?$data->question19->{'Row 10'}->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 9'})?$data->question19->{'Row 10'}->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 10'})?$data->question19->{'Row 10'}->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 11'})?$data->question19->{'Row 10'}->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 12'})?$data->question19->{'Row 10'}->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question19->{'Row 10'}->{'Column 13'})?$data->question19->{'Row 10'}->{'Column 13'}:'' ?></td>

                    </tr>
                    <tr>
                        <td>Monitoring Lain :</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                       
                    </tr>

                    <?php 
                    $jml_array = isset($data->question40)?count($data->question40):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <tr>
                        <td><?php echo isset($data->question40[$x]->{'Column 1'})?$data->question40[$x]->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 2'})?$data->question40[$x]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 3'})?$data->question40[$x]->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 4'})?$data->question40[$x]->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 5'})?$data->question40[$x]->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 6'})?$data->question40[$x]->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 7'})?$data->question40[$x]->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 8'})?$data->question40[$x]->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 9'})?$data->question40[$x]->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 10'})?$data->question40[$x]->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 11'})?$data->question40[$x]->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 12'})?$data->question40[$x]->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 13'})?$data->question40[$x]->{'Column 13'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 14'})?$data->question40[$x]->{'Column 14'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question40[$x]->{'Column 15'})?$data->question40[$x]->{'Column 15'}:'' ?></td>

                    </tr>
                    <?php  }if($jml_array<=7){
                        $jml_kurang = 7 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                         <tr>
                        <td><br></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                      
                    </tr>

                        <?php }} ?>

                    <tr>
                        <td>obat obatan </td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                       
                    </tr>

                    <?php 
                    $jml_array = isset($data->question41)?count($data->question41):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <tr>
                        <td><?php echo isset($data->question41[$x]->{'Column 1'})?$data->question41[$x]->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 16'})?$data->question41[$x]->{'Column 16'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 2'})?$data->question41[$x]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 3'})?$data->question41[$x]->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 4'})?$data->question41[$x]->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 5'})?$data->question41[$x]->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 6'})?$data->question41[$x]->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 7'})?$data->question41[$x]->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 8'})?$data->question41[$x]->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 9'})?$data->question41[$x]->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 10'})?$data->question41[$x]->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 11'})?$data->question41[$x]->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 12'})?$data->question41[$x]->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 13'})?$data->question41[$x]->{'Column 13'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 14'})?$data->question41[$x]->{'Column 14'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question41[$x]->{'Column 15'})?$data->question41[$x]->{'Column 15'}:'' ?></td>

                    </tr>
                    <?php  }if($jml_array<=6){
                        $jml_kurang = 6 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                         <tr>
                        <td><br></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                      
                    </tr>
                        <?php }} ?>

                        <tr>
                        <td>Cairan/transfusi</td>
                        <td style="text-align:center">ml</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                       
                    </tr>
                    <?php 
                    $jml_array = isset($data->question42)?count($data->question42):0;
                    for ($x = 0; $x < $jml_array; $x++) {
                    ?>
                     <tr>
                        <td><?php echo isset($data->question42[$x]->{'Column 1'})?$data->question42[$x]->{'Column 1'}:'' ?></td>
                        <td style="text-align:center">ml</td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 2'})?$data->question42[$x]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 3'})?$data->question42[$x]->{'Column 3'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 4'})?$data->question42[$x]->{'Column 4'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 5'})?$data->question42[$x]->{'Column 5'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 6'})?$data->question42[$x]->{'Column 6'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 7'})?$data->question42[$x]->{'Column 7'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 8'})?$data->question42[$x]->{'Column 8'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 9'})?$data->question42[$x]->{'Column 9'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 10'})?$data->question42[$x]->{'Column 10'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 11'})?$data->question42[$x]->{'Column 11'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 12'})?$data->question42[$x]->{'Column 12'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 13'})?$data->question42[$x]->{'Column 13'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 14'})?$data->question42[$x]->{'Column 14'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question42[$x]->{'Column 15'})?$data->question42[$x]->{'Column 15'}:'' ?></td>

                    </tr>
                    <?php  }if($jml_array<=6){
                        $jml_kurang = 6 - $jml_array;
                        for($x = 0; $x < $jml_kurang; $x++){
                        ?>
                         <tr>
                        <td><br></td>
                        <td style="text-align:center">ml</td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                        <td style="text-align:center"></td>
                      
                    </tr>
                        <?php }} ?>
                    <tr>
                        <td colspan = "11">
                            <span>Catatan</span>
                            <p><?= isset($data->question20)?$data->question20:'' ?></p>
                        </td>
                        <td colspan = "5">
                            <center>
                            <span>Bukittinggi, <?= isset($lap_anestesi->tgl_input)?date('d-m-y',strtotime($lap_anestesi->tgl_input)):'' ?> Jam <?= isset($lap_anestesi->tgl_input)?date('h:i',strtotime($lap_anestesi->tgl_input)):'' ?></span>
                            <p>Dokter Anestesi</p>
                            <?php
                                $id = isset($lap_anestesi->id_pemeriksa)?$lap_anestesi->id_pemeriksa:null;
                                //  var_dump($id);                                     
                                $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                                if(isset($query->ttd)){
                                ?>

                                <center> <img width="70px" src="<?= $query->ttd ?>" alt=""><br></center>
                                <center>(<?= $query->name ?>)<br></center>
                                <?php
                                    } else {?>
                                        <br><br><br>
                            <?php } ?>
                            <p>Tanda Tangan & Nama Terang</p>
                        </center>
                        </td>
                    </tr>
                </table> <br><br><br>
                <div style="display:flex;font-size:10px">
                    <div>
                        Hal 3 dari 4
                    </div>
                    <div style="margin-left:470px">
                        Rev.08.02.2021.RM-019d / RI
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>LAPORAN ANESTESI</h4></center>
            
            <div style="font-size:12px">
                <table width="100%" border="1" id="data">
                    <tr>
                        <th>KRITERIA PENGELUARAN PASIEN DARI RUANG PEMULIHAN</th>
                    </tr>
                    <tr>
                        <td> 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->aldrete)? $data->aldrete == "item1" ? "checked":'':'' ?>>
                            <span>Aldrete Score</span>  
                        </td>
                    </tr>
                </table>
                <table width="100%" border="1" id="data">
                    <tr>
                        <td width="15%">Aldrete Score</td>
                        <td width="7%">Jam</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->jam)?$data->question15[$x]->jam:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Aktivitas</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->{'1'})?$data->question15[$x]->{'1'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Respirasi</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->{'2'})?$data->question15[$x]->{'2'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Sirkulasi</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->{'3'})?$data->question15[$x]->{'3'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Kesadaran</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->{'5'})?$data->question15[$x]->{'5'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Saturasi</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->{'6'})?$data->question15[$x]->{'6'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%" colspan="2">Total Skor</td>
                        <?php 
                            $jml_array = isset($data->question15)?count($data->question15):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question15[$x]->{'4'})?$data->question15[$x]->{'4'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr><td colspan="14">Bila skor ≥ 8 pasien dapat dipindahkan ke ruang perawatan</td></tr>
                    <tr><td colspan="14">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->aldrete)? $data->aldrete == "item2" ? "checked":'':'' ?>>
                            <span>Steward Score</span>
                    </td></tr>
                    <tr>
                        <td width="15%">Steward Score</td>
                        <td width="7%">Jam</td>
                        <?php 
                            $jml_array = isset($data->question14)?count($data->question14):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question14[$x]->jam)?$data->question14[$x]->jam:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Kesadaran</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question14)?count($data->question14):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question14[$x]->{'1'})?$data->question14[$x]->{'1'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                            <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Respirasi</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question14)?count($data->question14):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question14[$x]->{'2'})?$data->question14[$x]->{'2'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Motorik</td>
                        <td width="7%">0-1-2</td>
                        <?php 
                            $jml_array = isset($data->question14)?count($data->question14):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question14[$x]->{'3'})?$data->question14[$x]->{'3'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%" colspan="2">Total Skor</td>
                        <?php 
                            $jml_array = isset($data->question14)?count($data->question14):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question14[$x]->{'4'})?$data->question14[$x]->{'4'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr><td colspan="14">Bila skor ≥ 5 pasien dapat dipindahkan ke ruang perawatan</td></tr>
                    <tr><td colspan="14">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->aldrete)? $data->aldrete == "item3" ? "checked":'':'' ?>>
                            <span>Bromage Score</span>
                    </td></tr>
                    <tr>
                        <td width="15%">Bromage Score</td>
                        <td width="7%">Jam</td>
                        <?php 
                            $jml_array = isset($data->question16)?count($data->question16):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question16[$x]->jam)?$data->question16[$x]->jam:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Gerakan penuh dari tungkai</td>
                        <td width="7%">3</td>
                        <?php 
                            $jml_array = isset($data->question16)?count($data->question16):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question16[$x]->{'1'})?$data->question16[$x]->{'1'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Tak mampu ekstensi tungkai</td>
                        <td width="7%">2</td>
                        <?php 
                            $jml_array = isset($data->question16)?count($data->question16):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question16[$x]->{'2'})?$data->question16[$x]->{'2'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Tak mampu fleksi lutut</td>
                        <td width="7%">1</td>
                        <?php 
                            $jml_array = isset($data->question16)?count($data->question16):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question16[$x]->{'3'})?$data->question16[$x]->{'3'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                    <tr>
                        <td width="15%">Tak mampu fleksi pergelangan kaki</td>
                        <td width="7%">0</td>
                        <?php 
                            $jml_array = isset($data->question16)?count($data->question16):0;
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                        
                            <td style="text-align:center" width="6%"><?= isset($data->question16[$x]->{'5'})?$data->question16[$x]->{'5'}:'' ?></td>
                            <?php  }if($jml_array<=12){
                                $jml_kurang = 12 - $jml_array;
                                for($x = 0; $x < $jml_kurang; $x++){
                                ?>
                                  <td width="6%"></td>
                        <?php }} ?>
                    </tr>
                   
                    <tr><td colspan="14">Bila skor ≥ 2 pasien dapat dipindahkan ke ruang perawatan</td></tr>
                    <tr><td colspan="14"><br></td></tr>
                    <tr><th colspan="14">INSTRUKSI PASCA ANESTESI</th></tr>
                    <tr><td colspan="14">
                        <span>Observasi kesadaran setiap : <?= isset($data->question28->text1)?$data->question28->text1:'' ?></span>
                        <p>Observasi tanda vital/tekanan darah, nadi, pernafasan, suhu setiap : <?= isset($data->question28->text2)?$data->question28->text2:'' ?></p>
                        <span>Posisi terlentang/miring ke kiri/miring ke kanan/ head up 30◦ : <?= isset($data->question28->text3)?$data->question28->text3:'' ?></span>
                        <p>Pemeriksaan penunjang : <?= isset($data->question28->text4)?$data->question28->text4:'' ?></p>
                        <span>Lain - lain : <?= isset($data->question28->text5)?$data->question28->text5:'' ?></span>
                        <p>Terapi O2 <?= isset($data->question28->text6)?$data->question28->text6:'' ?> Liter/menit via kanul binasal/simple mask/ NRM
                        <span style="margin-left:30px">Selama : <?= isset($data->question28->text7)?$data->question28->text7:'' ?></span>
                        </p>                    
                        <p>Puasa selama : <?= isset($data->question28->text8)?$data->question28->text8:'' ?>
                        <span style="margin-left:30px">  Bila timbul mual/muntah, berikan : <?= isset($data->question28->text9)?$data->question28->text9:'' ?></span>
                        </p>
                        <p>Mulai minum jam :   <?= isset($data->question28->text10)?$data->question28->text10:'' ?>                                                                                         
                        <span style="margin-left:30px">    Mula makan jam <?= isset($data->question28->text11)?$data->question28->text11:'' ?></span>
                        </p>
                                
                        <span>Terapi cairan rumatan : <?= isset($data->question28->text12)?$data->question28->text12:'' ?></span>
                        <p>Transfusi : <?= isset($data->question28->text13)?$data->question28->text13:'' ?></p>
                        <span>Manajemen nyeri : <?= isset($data->question28->text14)?$data->question28->text14:'' ?></span>
                        <p>Obat-obatan lain : <?= isset($data->question28->text15)?$data->question28->text15:'' ?></p>
                        <span>Pemeriksaan penunjang dan peralatan lainnya : <?= isset($data->question28->text16)?$data->question28->text16:'' ?></span><br><br>
                        <span>Ruangan Pasca Bedah</span>
                        <p>Keluar ruang pemulihan tanggal <?= isset($data->question28->text17)?$data->question28->text17:'' ?>
                        <span> Jam <?= isset($data->question28->text18)?$data->question28->text18:'' ?> </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question21)? $data->question21 == "item1" ? "checked":'':'' ?>>
                            <span>ICU/HCU</span> 
                            <input type="checkbox" value="Tidak"<?php echo isset($data->question21)? $data->question21 == "item2" ? "checked":'':'' ?>>
                            <span>Ruangan</span> 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question21)? $data->question21 == "other" ? "checked":'':'' ?>>
                            <span>Lainnya, <?= isset($data->{'question21-Comment'})?$data->{'question21-Comment'}:'' ?></span> 
                       
                    </td>
                </tr>
                <tr>
                    <td colspan="14">
                    <div style="display: inline; position: relative;">
                    <div style="float: left;margin-top: 15px;">
                        <p>Perawat Ruangan</p>
                        <?php
                        $id =isset($lap_anestesi->id_pemeriksa)?$lap_anestesi->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            <span>(<?= (isset($query->name)?$query->name:'')?>)</span><br>  
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>()</span><br>
                        <?php } ?>
                        <span>Tanda Tangan & Nama Terang</span><br>
                      
                        
                             
                    </div>
                    <div style="float: right;margin-top: 15px;">
                        <span>Bukittinggi, <?= isset($lap_anestesi->tgl_input)? date('d-m-Y',strtotime($lap_anestesi->tgl_input)):'' ?> jam <?= isset($lap_anestesi->tgl_input)? date('h:i',strtotime($lap_anestesi->tgl_input)):'' ?></span>
                        <p>Perawat  Anestesi</p>

                        <?php
                        $id1 =isset($lap_anestesi->id_pemeriksa_2)?$lap_anestesi->id_pemeriksa_2:null;
                        //   var_dump($id);die();                                     
                        $query1 = $id1?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id1")->row():null;
                        if(isset($query1->ttd)){
                        ?>

                            <img width="70px" src="<?= $query1->ttd ?>" alt=""><br>
                            <span>(<?= (isset($query1->name)?$query1->name:'')?>)</span><br>  
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>()</span><br>
                        <?php } ?>
                        <span>Tanda Tangan & Nama Terang</span><br>
                        
                             
                    </div>  
             </div>
                    </td>
                </tr>
                </table> <br><br><br>
                <div style="display:flex;font-size:10px">
                    <div>
                        Hal 4 dari 4
                    </div>
                    <div style="margin-left:470px">
                        Rev.08.02.2021.RM-019d / RI
                    </div>
                </div>
            </div>
            </div>
        </div>

    </body>
    </html>