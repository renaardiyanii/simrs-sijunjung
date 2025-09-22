<?php
$data = (isset($kebidanan_ginekologi->formjson)?json_decode($kebidanan_ginekologi->formjson):'');
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
        }

        tr td{
            
            font-size: 11px;
            
        } #ruang {
            border-left: 1px solid;
            border-right: 1px solid;
            border-top: 1px solid;
            border-bottom: 1px solid;
        } #alasan {
            border-left: 1px solid;
            border-right: 1px solid;
            border-bottom: 1px solid;
        } #alergi {
            border-left: 1px solid;
            border-right: 1px solid;
        } #gizi tr td {
            border: 1px solid;
        } #kanan {
            border-right: 1px solid;
        }
        .penanda{
            background-color:#3498db; 
            color:white;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4">

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:12px">

                <table width="100%"  id="data" border="0">
                    <tr>
                        <td width="25%">Tiba di ruangan : </td>
                        <td width="25%">Tanggal <?= isset($data->question1->tiba)?date('d-m-Y', strtotime($data->question1->tiba)):'' ?></td>
                        <td width="50%" colspan="2">Jam  <?= isset($data->question1->tiba)?date('h:i', strtotime($data->question1->tiba)):'' ?></td>
                    </tr>
                    <tr>
                        <td >Pengkajian :</td>
                        <td >Tanggal <?= isset($data->question1->pengkajian)?date('d-m-Y', strtotime($data->question1->pengkajian)):'' ?></td>
                        <td  colspan="2">Jam <?= isset($data->question1->pengkajian)?date('h:i', strtotime($data->question1->pengkajian)):'' ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->auto_allo)? $data->auto_allo == "auto" ? "checked":'':'' ?>>
                            <span>Auto Anamnesis</span>
                        </td>
                        <td colspan="3">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->auto_allo)? $data->auto_allo == "allo" ? "checked":'':'' ?>>
                            <span>Allo Anamnesis</span>
                            <span style="margin-left:20px">Hubungan <?= isset($data->question3)?$data->question3:'' ?></span>
                        </td>
                       
                    </tr>
                    <tr>
                        <td> Cara Masuk :</td>
                        <td width="18%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "jalan" ? "checked":'':'' ?>>
                            Jalan
                        </td>
                        <td width="18%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "kursi_roda" ? "checked":'':'' ?>>
                            Kursi Roda
                        </td>
                        <td width="18%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "brankar" ? "checked":'':'' ?>>
                            Brankar
                        </td>
                        <td width="18%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "other" ? "checked":'':'' ?>>
                            Lain Lain , <?= isset($data->{'cara_masuk-Comment'})?$data->{'cara_masuk-Comment'}:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Asal Masuk :</td>
                        <td width="18,75%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->asal_masuk)? $data->asal_masuk == "igd" ? "checked":'':'' ?>>
                            <span>IGD</span>
                        </td>
                        <td width="18,75%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->asal_masuk)? $data->asal_masuk == "rajal" ? "checked":'':'' ?>>
                            <span>Rawat Jalan</span>
                        </td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td><b>ALASAN MASUK</b></td>
                    </tr>
                </table>

                <table width="100%" id="alergi">
                    <tr>
                        <td>
                            <span>Keluhan Utama</span>
                            <p><?= isset($data->question2)?$data->question2:'' ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_alergi)?in_array("tidak_ada", $data->riwayat_alergi)?'checked':'':'') ?>>
                            <span>Tidak ada alergi</span>
                        </td>
                    </tr>
                   
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_alergi)?in_array("obat", $data->riwayat_alergi)?'checked':'':'') ?>>
                            <span>Alergi Obat</span>
                        </td>
                        <td width="33%">Sebutkan : <?= isset($data->reaksi->sebutkan)?$data->reaksi->sebutkan:'' ?></td>
                        <td width="33%">Reaksi : <?= isset($data->reaksi->reaksi)?$data->reaksi->reaksi:'' ?></td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_alergi)?in_array("makanan", $data->riwayat_alergi)?'checked':'':'') ?>>
                            <span>Alergi Makanan</span>
                        </td>
                        <td width="33%">Sebutkan : <?= isset($data->reaksi2->sebutkan)?$data->reaksi2->sebutkan:'' ?></td>
                        <td width="33%">Reaksi : <?= isset($data->reaksi2->reaksi)?$data->reaksi2->reaksi:'' ?></td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_alergi)?in_array("lainnya", $data->riwayat_alergi)?'checked':'':'') ?>>
                            <span>Alergi Lainnya</span>
                        </td>
                        <td width="33%">Sebutkan : <?= isset($data->reaksi3->sebutkan)?$data->reaksi3->sebutkan:'' ?></td>
                        <td width="33%">Reaksi : <?= isset($data->reaksi3->reaksi)?$data->reaksi3->reaksi:'' ?></td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_alergi)?in_array("gelang", $data->riwayat_alergi)?'checked':'':'') ?>>
                            <span>Gelang Tanda Alergi dipasang (Warna Merah)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_alergi)?in_array("tidak_diketahui", $data->riwayat_alergi)?'checked':'':'') ?>>
                            <span>Tidak diketahui</span>
                        </td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td>Diberitahukan ke dokter/farmasi(apoteker)/dietisien (coret salah satu)</td>
                    </tr>
                    <tr>
                        <td width="40%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->diberitahukan)? $data->diberitahukan == "ya" ? "checked":'':'' ?>>
                            <span>Ya, Pukul <?= isset($data->pukul)?$data->pukul:'' ?></span>
                        </td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->diberitahukan)? $data->diberitahukan == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td><b>SKRINING NYERI</b></td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td width="50%">
                        
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "tidak_ada_nyeri" ? "checked":'':'' ?>>
                            <span>Tidak Ada Nyeri</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "nyeri_akut" ? "checked":'':'' ?>>
                            <span>Nyeri Akut</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question4)? $data->question4 == "nyeri_kronis" ? "checked":'':'' ?>>
                            <span>Nyeri Kronis</span>
                        </td>
                        <td width="50%" rowspan="10">
                            <img  src="<?php echo base_url('assets/images/kebidanan_ginekologi.png') ?>" alt=""><br>
                            skala nyeri :<?= isset($data->question6[0]->nyeri)?$data->question6[0]->nyeri:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">P(profokatif/penyebab): <?= isset($data->question5->p)?$data->question5->p:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">Q(quality/gambaran nyeri): <?= isset($data->question5->q)?$data->question5->q:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">R(region/lokasi nyeri): <?= isset($data->question5->r)?$data->question5->r:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">S(skala severitas): <?= isset($data->question5->s)?$data->question5->s:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">T(timing/waktu nyeri): <?= isset($data->question5->t)?$data->question5->t:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">Apakah nyeri yg dirasakan:</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            - Menghalangi tidur malam anda
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->menghalangi)? $data->question6[0]->menghalangi == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->menghalangi)? $data->question6[0]->menghalangi == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            - Menghalangi anda beraktifitas
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->mengahalangi2)? $data->question6[0]->mengahalangi2 == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->mengahalangi2)? $data->question6[0]->mengahalangi2 == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            - Sakit dirasakan setiap hari
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->sakit)? $data->question6[0]->sakit == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question6[0]->sakit)? $data->question6[0]->sakit == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                    </tr>
                </table><br>

                <table width="100%" id="gizi">
                    <tr>
                        <td colspan = "3"><b>SKRINING GIZI AWAL</b></td>
                    </tr>
                    <tr>
                        <td width="70%">1. Apakah pasien mengalami penurunan berat badan yang tidak direncanakan/tidak di inginkan</td>
                        <td width="15%" style="text-align:center">Skor</td>
                        <td width="15%" style="text-align:center">Skor Pasien</td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_1)? $data->skrining_gizi_matrix->skor->skrining_gizi_1 == "0" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                        <td width="15%" style="text-align:center">0</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_1)? $data->skrining_gizi_matrix->skor->skrining_gizi_1 == "0" ? $data->skrining_gizi_matrix->skor->skrining_gizi_1:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_1)? $data->skrining_gizi_matrix->skor->skrining_gizi_1 == "2" ? "checked":'':'' ?>>
                            <span>Tidak Yakin (ada tanda: baju menjadi longgar)</span>
                        </td>
                        <td width="15%" style="text-align:center">2</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_1)? $data->skrining_gizi_matrix->skor->skrining_gizi_1 == "2" ? $data->skrining_gizi_matrix->skor->skrining_gizi_1:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_1)? $data->skrining_gizi_matrix->skor->skrining_gizi_1 == "0" ? "checked":'':'' ?>>
                            <span>Ya, ada penurunan BB sebanyak:</span>
                        </td>
                        <td width="15%" style="text-align:center"></td>
                        <td width="15%" style="text-align:center"></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "1" ? "checked":'':'' ?>>
                            <span>1 - 5 Kg</span>
                        </td>
                        <td width="15%" style="text-align:center">1</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "1" ? $data->skrining_gizi_matrix->skor->skrining_gizi_3:'':'' ?></td>
                    </tr>
                </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
            <div style="font-size:12px">

                <table width="100%" id="gizi">
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "2" ? "checked":'':'' ?>>
                            <span>6 - 10 Kg</span>
                        </td>
                        <td width="15%" style="text-align:center">2</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "2" ? $data->skrining_gizi_matrix->skor->skrining_gizi_3:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "3" ? "checked":'':'' ?>>
                            <span>11 - 15 Kg</span>
                        </td>
                        <td width="15%" style="text-align:center">3</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "3" ? $data->skrining_gizi_matrix->skor->skrining_gizi_3:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "4" ? "checked":'':'' ?>>
                            <span>> 15 Kg</span>
                        </td>
                        <td width="15%" style="text-align:center">4</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "4" ? $data->skrining_gizi_matrix->skor->skrining_gizi_3:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "2" ? "checked":'':'' ?>>
                            <span>Tidak tahu berapa kg penurunnya</span>
                        </td>
                        <td width="15%" style="text-align:center">2</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_3)? $data->skrining_gizi_matrix->skor->skrining_gizi_3 == "2" ? $data->skrining_gizi_matrix->skor->skrining_gizi_3:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">1. Apakah asupan makan pasien berkurang karena penurunan nafsu makan/kesulitan menerima makanan ?</td>
                        <td width="15%" style="text-align:center">Skor</td>
                        <td width="15%" style="text-align:center">Skor Pasien</td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_2)? $data->skrining_gizi_matrix->skor->skrining_gizi_2 == "0" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                        <td width="15%" style="text-align:center">0</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_2)? $data->skrining_gizi_matrix->skor->skrining_gizi_2 == "0" ? $data->skrining_gizi_matrix->skor->skrining_gizi_2:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_2)? $data->skrining_gizi_matrix->skor->skrining_gizi_2 == "1" ? "checked":'':'' ?>>
                            <span>Ya</span>
                        </td>
                        <td width="15%" style="text-align:center">1</td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->skrining_gizi_2)? $data->skrining_gizi_matrix->skor->skrining_gizi_2 == "1" ? $data->skrining_gizi_matrix->skor->skrining_gizi_2:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="70%">Total skor (Bila skor >2, pasien berisiko malnutrisi, konsul ahli gizi</td>
                        <td width="15%" style="text-align:center"></td>
                        <td width="15%" style="text-align:center"><?php echo isset($data->skrining_gizi_matrix->skor->total_skor)? $data->skrining_gizi_matrix->skor->total_skor:'' ?></td>
                    </tr>
                </table><br>

                <table width="100%" id="gizi">
                    <tr>
                        <td colspan="6"><b>ASSESMEN FUNGSIONAL</b></td>
                    </tr>
                    <tr>
                        <td colspan="6">Beri nilai pada hasil pemeriksaan dan jumlahkan</td>
                    </tr>
                    <tr>
                        <td width="5%" rowspan="2">No</td>
                        <td width="35%" rowspan="2">Fungsi</td>
                        <td width="5%" rowspan="2">Skor</td>
                        <td width="35%" rowspan="2">Uraian</td>
                        <td width="20%" colspan="2">Nilai</td>
                    </tr>
                    <tr>
                        <td width="10%">Saat Masuk RS</td>
                        <td width="10%">Saat Keluar RS</td>
                    </tr>
                    <tr>
                        <td width="5%" rowspan="3">1</td>
                        <td width="35%" rowspan="3">Mengendalikan rangsangan defekasi (BAB)</td>
                        <td width="5%" style="text-align:center">0</td>
                        <td width="35%">Tak terkendali/tak teratur (perlu pencahar)</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'1'})? $data->fungsional->masuk->{'1'} == "0" ? $data->fungsional->masuk->{'1'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'1'})? $data->fungsional->keluar->{'1'} == "0" ? $data->fungsional->keluar->{'1'}:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Kadang kadang tak terkendali</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'1'})? $data->fungsional->masuk->{'1'} == "1" ? $data->fungsional->masuk->{'1'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'1'})? $data->fungsional->keluar->{'1'} == "1" ? $data->fungsional->keluar->{'1'}:'':'' ?></td>
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'1'})? $data->fungsional->masuk->{'1'} == "2" ? $data->fungsional->masuk->{'1'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'1'})? $data->fungsional->keluar->{'1'} == "2" ? $data->fungsional->keluar->{'1'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%" rowspan="3">2</td>
                        <td width="35%" rowspan="3">Mengendalikan rangsangan berkemih (BAK)</td>
                        <td width="5%">0</td>
                        <td width="35%">Tak terkendali/pakai kateter</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'2'})? $data->fungsional->masuk->{'2'} == "0" ? $data->fungsional->masuk->{'2'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'2'})? $data->fungsional->keluar->{'2'} == "0" ? $data->fungsional->keluar->{'2'}:'':'' ?></td> 
                        
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Kadang kadang tak terkendali (1x24 jam)</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'2'})? $data->fungsional->masuk->{'2'} == "1" ? $data->fungsional->masuk->{'2'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'2'})? $data->fungsional->keluar->{'2'} == "1" ? $data->fungsional->keluar->{'2'}:'':'' ?></td> 
                      
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'2'})? $data->fungsional->masuk->{'2'} == "2" ? $data->fungsional->masuk->{'2'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'2'})? $data->fungsional->keluar->{'2'} == "2" ? $data->fungsional->keluar->{'2'}:'':'' ?></td> 
                       
                    </tr>
                    <tr>
                        <td width="5%" rowspan="2">3</td>
                        <td width="35%" rowspan="2">Membersihkan diri(cuci muka, sisir rambut, sikat gigi)</td>
                        <td width="5%">0</td>
                        <td width="35%">Butuh pertolongan orang lain</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'3'})? $data->fungsional->masuk->{'3'} == "0" ? $data->fungsional->masuk->{'3'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'3'})? $data->fungsional->keluar->{'3'} == "0" ? $data->fungsional->keluar->{'3'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Perlu pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yg lain</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'3'})? $data->fungsional->masuk->{'3'} == "1" ? $data->fungsional->masuk->{'3'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'3'})? $data->fungsional->keluar->{'3'} == "1" ? $data->fungsional->keluar->{'3'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%" rowspan="3">4</td>
                        <td width="35%" rowspan="3">Penggunaan jamban, masuk dan keluar(melepaskan, memakai celana, membersihkan, menyiram)</td>
                        <td width="5%">0</td>
                        <td width="35%">Tergantung pertolongan orang</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'4'})? $data->fungsional->masuk->{'4'} == "0" ? $data->fungsional->masuk->{'4'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'4'})? $data->fungsional->keluar->{'4'} == "0" ? $data->fungsional->keluar->{'4'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Perlu pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yg lain</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'4'})? $data->fungsional->masuk->{'4'} == "1" ? $data->fungsional->masuk->{'4'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'4'})? $data->fungsional->keluar->{'4'} == "1" ? $data->fungsional->keluar->{'4'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'4'})? $data->fungsional->masuk->{'4'} == "2" ? $data->fungsional->masuk->{'4'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'4'})? $data->fungsional->keluar->{'4'} == "2" ? $data->fungsional->keluar->{'4'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%" rowspan="3">5</td>
                        <td width="35%" rowspan="3">Makan</td>
                        <td width="5%">0</td>
                        <td width="35%">Tidak mampu</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'5'})? $data->fungsional->masuk->{'5'} == "0" ? $data->fungsional->masuk->{'5'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'5'})? $data->fungsional->keluar->{'5'} == "0" ? $data->fungsional->keluar->{'5'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Perlu pertolongan memotong makanan</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'5'})? $data->fungsional->masuk->{'5'} == "1" ? $data->fungsional->masuk->{'5'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'5'})? $data->fungsional->keluar->{'5'} == "1" ? $data->fungsional->keluar->{'5'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'5'})? $data->fungsional->masuk->{'5'} == "2" ? $data->fungsional->masuk->{'5'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'5'})? $data->fungsional->keluar->{'5'} == "2" ? $data->fungsional->keluar->{'5'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%" rowspan="3">6</td>
                        <td width="35%" rowspan="3">Berubah sikap dari berbaring ke duduk</td>
                        <td width="5%">0</td>
                        <td width="35%">Tidak mampu</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'6'})? $data->fungsional->masuk->{'6'} == "0" ? $data->fungsional->masuk->{'6'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'6'})? $data->fungsional->keluar->{'6'} == "0" ? $data->fungsional->keluar->{'6'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Perlu pertolongan memotong makanan</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'6'})? $data->fungsional->masuk->{'6'} == "1" ? $data->fungsional->masuk->{'6'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'6'})? $data->fungsional->keluar->{'6'} == "1" ? $data->fungsional->keluar->{'6'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'6'})? $data->fungsional->masuk->{'6'} == "2" ? $data->fungsional->masuk->{'6'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'6'})? $data->fungsional->keluar->{'6'} == "2" ? $data->fungsional->keluar->{'6'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%" rowspan="4">7</td>
                        <td width="35%" rowspan="4">Berpindah/Berjalan</td>
                        <td width="5%">0</td>
                        <td width="35%">Tidak mampu</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'7'})? $data->fungsional->masuk->{'7'} == "0" ? $data->fungsional->masuk->{'7'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'7'})? $data->fungsional->keluar->{'7'} == "0" ? $data->fungsional->keluar->{'7'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Bisa (pindah) dengan kursi roda</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'7'})? $data->fungsional->masuk->{'7'} == "1" ? $data->fungsional->masuk->{'7'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'7'})? $data->fungsional->keluar->{'7'} == "1" ? $data->fungsional->keluar->{'7'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Berjalan dengan bantuan 1 orang</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'7'})? $data->fungsional->masuk->{'7'} == "2" ? $data->fungsional->masuk->{'7'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'7'})? $data->fungsional->keluar->{'7'} == "2" ? $data->fungsional->keluar->{'7'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">3</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'7'})? $data->fungsional->masuk->{'7'} == "3" ? $data->fungsional->masuk->{'7'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'7'})? $data->fungsional->keluar->{'7'} == "3" ? $data->fungsional->keluar->{'7'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">8</td>
                        <td width="35%">Memakai baju</td>
                        <td width="5%">0</td>
                        <td width="35%">Tergantung pada orang lain</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'8'})? $data->fungsional->masuk->{'8'} == "0" ? $data->fungsional->masuk->{'8'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'8'})? $data->fungsional->keluar->{'8'} == "0" ? $data->fungsional->keluar->{'8'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%" rowspan="3">9</td>
                        <td width="35%" rowspan="3">Naik/turun tangga</td>
                        <td width="5%">0</td>
                        <td width="35%">Tidak mampu</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'9'})? $data->fungsional->masuk->{'9'} == "0" ? $data->fungsional->masuk->{'9'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'9'})? $data->fungsional->keluar->{'9'} == "0" ? $data->fungsional->keluar->{'9'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Butuh pertolongan</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'9'})? $data->fungsional->masuk->{'9'} == "1" ? $data->fungsional->masuk->{'9'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'9'})? $data->fungsional->keluar->{'9'} == "1" ? $data->fungsional->keluar->{'9'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">2</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'9'})? $data->fungsional->masuk->{'9'} == "2" ? $data->fungsional->masuk->{'9'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'9'})? $data->fungsional->keluar->{'9'} == "2" ? $data->fungsional->keluar->{'9'}:'':'' ?></td> 
                    </tr>
                </table>

            </div>
            <br><br><br><br><br> <br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:11px">

                <table width="100%" id="gizi">
                    <tr>
                        <td width="5%" rowspan="2">10</td>
                        <td width="35%" rowspan="2">Mandi</td>
                        <td width="5%">0</td>
                        <td width="35%">Tergantung orang lain</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'10'})? $data->fungsional->masuk->{'10'} == "0" ? $data->fungsional->masuk->{'10'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'10'})? $data->fungsional->keluar->{'10'} == "0" ? $data->fungsional->keluar->{'10'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Mandiri</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->{'10'})? $data->fungsional->masuk->{'10'} == "1" ? $data->fungsional->masuk->{'10'}:'':'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->{'10'})? $data->fungsional->keluar->{'10'} == "1" ? $data->fungsional->keluar->{'10'}:'':'' ?></td> 
                    </tr>
                    <tr>
                        <td colspan="4" width="80%">Total Score</td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->masuk->total_skor)? $data->fungsional->masuk->total_skor:'' ?></td>
                        <td width="10%" style="text-align:center"><?php echo isset($data->fungsional->keluar->total_skor)? $data->fungsional->keluar->total_skor:'' ?></td> 
                    </tr>
                </table>

                <p>Penilaian :</p>
                <p>0 - 4 : Ketergantungan total</p>
                <p>5 - 8 : Ketergantungan berat</p>
                <p>9 - 11 : Ketergantungan sedang</p>
                <p>12 - 19 : Ketergantungan ringan</p>
                <p>20 : Mandiri</p>
                <p style="font-weight:bold">RESIKO CEDERA/JATUH</p>

                <p>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question8)? $data->question8 == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question8)? $data->question8 == "ya" ? "checked":'':'' ?>>
                    <span>YA </span>
                    Bila ya, resiko jatuh : <?= isset($data->question9)?$data->question9:'' ?>
                </p>
                <p>
                    Jika resiko jatuh sedang atau tinggi dipasang gelang resiko jatuh kuning  
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question43)? $data->question43 == "ya" ? "checked":'':'' ?>>
                    <span>Tidak </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question43)? $data->question43 == "tidak" ? "checked":'':'' ?>>
                    <span>YA </span>
                </p>
                <p>
                    Diberitahukan ke dokter
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question93)? $data->question93 == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak </span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question93)? $data->question93 == "other" ? "checked":'':'' ?>>
                    <span>Ya, Pukul <?= isset($data->{'question93-Comment'})?$data->{'question93-Comment'}:'' ?></span>
                </p>

                <table width="100%" id="gizi">
                    <tr>
                        <td colspan = "2" width = "30%">Item Penilaian</td>
                        <td width="3%">Skor</td>
                        <td colspan = "2" width = "30%">Item Penilaian</td>
                        <td width="3%">Skor</td>
                        <td colspan = "2" width = "30%">Item Penilaian</td>
                        <td width="3%">Skor</td>
                    </tr>
                    <tr>
                        <td width="27%">Riwayat Jatuh<br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'1'})? $data->question10->skor->{'1'} == "25" ? "checked":'':'' ?>>
                            <span>Ya </span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'1'})? $data->question10->skor->{'1'} == "0" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                        <td width="3%"><br>25<br>
                            0
                        </td>
                        <td width="3%" style="text-align:center;vertical-align:middle"><?= isset($data->question10->skor->{'1'})?$data->question10->skor->{'1'}:'' ?></td>
                        <td width="27%">Diagnosis Sekunder(>2 diagnosis medis)<br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'3'})? $data->question10->skor->{'3'} == "15" ? "checked":'':'' ?>>
                            <span>Ya </span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'3'})? $data->question10->skor->{'3'} == "0" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                        <td width="3%"><br><br>15<br>
                            0
                        </td>
                        <td width="3%" style="text-align:center;vertical-align:middle"><?= isset($data->question10->skor->{'3'})?$data->question10->skor->{'3'}:'' ?></td>
                        <td width="27%">Alat bantu<br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'5'})? $data->question10->skor->{'5'} == "30" ? "checked":'':'' ?>>
                                <span>Berpegangan pada perabot </span><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'5'})? $data->question10->skor->{'5'} == "15" ? "checked":'':'' ?>>
                                <span>Tongkat/alat penopang</span><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'5'})? $data->question10->skor->{'5'} == "0" ? "checked":'':'' ?>>
                                <span>Tidak ada/kursi roda/perawat/tirah baring</span>
                            </td>
                            <td width="3%"><br>30<br>
                                15<br>
                                0
                            </td>
                            <td width="3%"  style="text-align:center;vertical-align:middle"><?= isset($data->question10->skor->{'5'})?$data->question10->skor->{'5'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="27%">Terpasang Infus<br>
                            <input type="checkbox" value="Tidak"<?php echo isset($data->question10->skor->{'2'})? $data->question10->skor->{'2'} == "20" ? "checked":'':'' ?>>
                            <span>Ya </span><br>
                            <input type="checkbox" value="Tidak"<?php echo isset($data->question10->skor->{'2'})? $data->question10->skor->{'2'} == "0" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                        </td>
                        <td width="3%"><br>20<br>
                            0
                        </td>
                        <td width="3%" style="text-align:center;vertical-align:middle"><?= isset($data->question10->skor->{'2'})?$data->question10->skor->{'2'}:'' ?></td>
                        <td width="27%">Gaya Berjalan<br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'4'})? $data->question10->skor->{'4'} == "20" ? "checked":'':'' ?>>
                            <span>Terganggu  </span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'4'})? $data->question10->skor->{'4'} == "10" ? "checked":'':'' ?>>
                            <span>Lemah</span><br>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'4'})? $data->question10->skor->{'4'} == "0" ? "checked":'':'' ?>>
                            <span>Normal/tirah baring/imobilisasi</span>
                        </td>
                        <td width="3%"><br>20<br>10<br>
                            0
                        </td>
                        <td width="3%" style="text-align:center;vertical-align:middle"><?= isset($data->question10->skor->{'4'})?$data->question10->skor->{'4'}:'' ?></td>
                        <td width="27%">Status mental<br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'6'})? $data->question10->skor->{'6'} == "15" ? "checked":'':'' ?>>
                                <span>Sering lupa akan keterbatasan </span><br>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question10->skor->{'6'})? $data->question10->skor->{'6'} == "0" ? "checked":'':'' ?>>
                                <span>Sadar Akan kemampuan</span>
                            </td>
                            <td width="3%"><br>
                                15<br><br>
                                0
                            </td>
                            <td width="3%" style="text-align:center;vertical-align:middle"><?= isset($data->question10->skor->{'6'})?$data->question10->skor->{'6'}:'' ?></td>
                    </tr>
                </table>

                <p>Total Keseluruhan Skor : <?= isset($data->question10->skor->total_skor)?$data->question10->skor->total_skor:'' ?></p>
                <p>Kriteria resiko cedera/jatuh; Rendah 0- 24  Sedang 25 - 44  Tinggi >45</p>

                <table width="100%" id="gizi">
                    <tr>
                        <td colspan = "3">PENILAIAN RISIKO JATUH PADA PASIEN GERIATRI (Sydney Scoring) USIA >65 TAHUN</td>
                    </tr>
                    <tr>
                        <td width="10%">No</td>
                        <td width="80%">PARAMETER</td>
                        <td width="10%">Skor</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'1'})?intval($data->table_resiko_jatuh_geriatri->result->{'1'})=="4"?"penanda":"":''; ?>">
                        <td width="10%">1</td>
                        <td width="80%">Gangguan gaya berjalan (diseret, menghentak, berayun)</td>
                        <td width="10%">4</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'2'})?intval($data->table_resiko_jatuh_geriatri->result->{'2'})=="3"?"penanda":"":''; ?>">
                        <td width="10%">2</td>
                        <td width="80%">Pusing/pingsan pada posisi tegak</td>
                        <td width="10%">3</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'3'})?intval($data->table_resiko_jatuh_geriatri->result->{'3'})=="3"?"penanda":"":''; ?>">
                        <td width="10%">3</td>
                        <td width="80%">Kebingungan setiap saat</td>
                        <td width="10%">3</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'4'})?intval($data->table_resiko_jatuh_geriatri->result->{'4'})=="3"?"penanda":"":''; ?>">
                        <td width="10%">4</td>
                        <td width="80%">Nocturia/incontinen</td>
                        <td width="10%">3</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'5'})?intval($data->table_resiko_jatuh_geriatri->result->{'5'})=="3"?"penanda":"":''; ?>">
                        <td width="10%">5</td>
                        <td width="80%">Kebingungan intermitten</td>
                        <td width="10%">3</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'6'})?intval($data->table_resiko_jatuh_geriatri->result->{'6'})=="3"?"penanda":"":''; ?>">
                        <td width="10%">6</td>
                        <td width="80%">Kelemahan umum</td>
                        <td width="10%">3</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'7'})?intval($data->table_resiko_jatuh_geriatri->result->{'7'})=="2"?"penanda":"":''; ?>">
                        <td width="10%">7</td>
                        <td width="80%">Mengonsumsi obat beresiko tinggi(diuretik, narkotik, sedatif, anti psikotik, vasodilator, anti angina, anti hipertensi, obat hipogilkemik, anti depresan, neuroleptik, NSAID</td>
                        <td width="10%">2</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'8'})?intval($data->table_resiko_jatuh_geriatri->result->{'8'})=="2"?"penanda":"":''; ?>">
                        <td width="10%">8</td>
                        <td width="80%">Riwayat Jatuh dalam waktu 12 bulan sebelumnya</td>
                        <td width="10%">2</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'9'})?intval($data->table_resiko_jatuh_geriatri->result->{'9'})=="1"?"penanda":"":''; ?>">
                        <td width="10%">9</td>
                        <td width="80%">Osteoporosis</td>
                        <td width="10%">1</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'10'})?intval($data->table_resiko_jatuh_geriatri->result->{'10'})=="1"?"penanda":"":''; ?>">
                        <td width="10%">10</td>
                        <td width="80%">Gangguan pendengaran dan penglihatan</td>
                        <td width="10%">1</td>
                    </tr>
                    <tr  class="<?= isset($data->table_resiko_jatuh_geriatri->result->{'11'})?intval($data->table_resiko_jatuh_geriatri->result->{'11'})=="1"?"penanda":"":''; ?>">
                        <td width="10%">11</td>
                        <td width="80%">Usia >70 tahun</td>
                        <td width="10%">1</td>
                    </tr>
                    <tr>
                        <td width="90%" colspan = "2">Total Skor</td>
                        <td width="10%"><?= isset($data->table_resiko_jatuh_geriatri->result->total_skor)?$data->table_resiko_jatuh_geriatri->result->total_skor:'' ?></td>
                    </tr>
                </table>

            </div>
            <br><br><br>  <br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 3 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:12px">
                <p>Tingkat resiko :</p>
                <p>Skor 1 - 3 : Rendah</p>
                <p>Skor >4 : Tinggi (pasang gelang resiko jatuh)</p>
                <p>(untuk intervensi lihat panduan risiko jatuh)</p>

                <table width="100%" id="ruang">
                    <tr>
                        <td>RIWAYAT PSIKOSOSIAL DAN SPIRITUAL</td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td width="50%">a). Status Psikologis</td>
                        <td width="50%">d). Kultural</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array("cemas", $data->question11)?'checked':'':'') ?>>
                            <span>Cemas </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array("takut", $data->question11)?'checked':'':'') ?>>
                            <span>Takut </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array("marah", $data->question11)?'checked':'':'') ?>>
                            <span>Marah </span>
                        </td>
                        <td width="50%">Hubungan Pasien dengan anggota keluarga:</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array("sedih", $data->question11)?'checked':'':'') ?>>
                            <span>Sedih </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array("kecenderungan", $data->question11)?'checked':'':'') ?>>
                            <span>Kecenderungan bunuh diri </span>
                        </td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question14)?in_array("baik", $data->question14)?'checked':'':'') ?>>
                            <span>Baik </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question14)?in_array("tidak_baik", $data->question14)?'checked':'':'') ?>>
                            <span>Tidak Baik </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question11)?in_array("other", $data->question11)?'checked':'':'') ?>>
                            <span>Lain Lain, Sebutkan <?= isset($data->{'question11-Comment'})?$data->{'question11-Comment'}:'' ?></span>
                        </td>
                        <td width="50%">Kerabat terdekat yg dapat dihubungi</td>
                    </tr>
                    <tr>
                        <td width="50%">b). Status mental: </td>
                        <td width="50%">Nama : <?= isset($data->question15->nama)?$data->question15->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("sadar", $data->question12)?'checked':'':'') ?>>
                            <span>Sadar dan orientasi baik </span>
                        </td>
                        <td width="50%">Hubungan : <?= isset($data->question15->hubungan)?$data->question15->hubungan:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("ada_masalah", $data->question12)?'checked':'':'') ?>>
                            <span>Ada masalah perilaku, Sebutkan : </span>
                        </td>
                        <td width="50%">Telepon : <?= isset($data->question15->telepon)?$data->question15->telepon:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("other", $data->question12)?'checked':'':'') ?>>
                            <span>Perilaku kekerasan yang dialami pasien </span>
                        </td>
                        <td width="50%">Nilai nilai dan kepercayaan yg dianut oleh</td>
                    </tr>
                    <tr>
                        <td width="50%">sebelumnya : <?= isset($data->{'question12-Comment'})?$data->{'question12-Comment'}:'' ?> </td>
                        <td width="50%">pasien : <?= isset($data->question15->nilai)?$data->question15->nilai:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%">c). Status ekonomi dan sosial</td>
                        <td width="50%">e). Status spiritual</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("asuransi", $data->question13)?'checked':'':'') ?>>
                            <span>Asuransi </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("jaminan", $data->question13)?'checked':'':'') ?>>
                            <span>Jaminan </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("other", $data->question13)?'checked':'':'') ?>>
                            <span>Biaya Sendiri  </span>
                        </td>
                        <td width="50%">Kegiatan keagamaan yg biasa dilakukan : <?= isset($data->question16->kegiatan_keagamaan)?$data->question16->kegiatan_keagamaan:'' ?></td>
                    </tr>
                    <tr>
                        <td width="50%" rowspan="3">Lainnya, Sebutkan : <?= isset($data->{'question13-Comment'})?$data->{'question13-Comment'}:'' ?></td>
                        <td width="50%"></td>
                    </tr>
                    <tr>
                        <td width="50%">Kegiatan spiritual yg dibutuhkan selama</td>
                    </tr>
                    <tr>
                        <td width="50%">perawatan : <?= isset($data->question16->kegiatan_spiritual)?$data->question16->kegiatan_spiritual:'' ?></td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td>KEBUTUHAN KOMUNIKASI DAN EDUKASI</td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td colspan="3">Terdapat hambatan dalam pembelajaran:</td>
                    </tr>
                    <tr>
                        <td width="33%" rowspan="2">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question17)? $data->question17 == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question17)? $data->question17 == "ya" ? "checked":'':'' ?>>
                            <span>Ya, Jika Ya : </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("pendengaran", $data->question18)?'checked':'':'') ?>>
                            <span>Pendengaran </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("penglihatan", $data->question18)?'checked':'':'') ?>>
                            <span>Penglihatan </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("kognitif", $data->question18)?'checked':'':'') ?>>
                            <span>Kognitif </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("fisik", $data->question18)?'checked':'':'') ?>>
                            <span>Fisik </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("budaya", $data->question18)?'checked':'':'') ?>>
                            <span>Budaya </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("emosi", $data->question18)?'checked':'':'') ?>>
                            <span>Emosi </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("bahasa", $data->question18)?'checked':'':'') ?>>
                            <span>Bahasa </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question18)?in_array("other", $data->question18)?'checked':'':'') ?>>
                            <span>Lainnya, <?= isset($data->{'question18-Comment'})?$data->{'question18-Comment'}:'' ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            Dibutuhkan penerjemah: 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question19)? $data->question19 == "tidak" ? "checked":'':'' ?>>
                            <span> TIdak </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question19)? $data->question19 == "other" ? "checked":'':'' ?>>
                            <span>Ya, sebutkan :  <?= isset($data->{'question19-Comment'})?$data->{'question19-Comment'}:'' ?></span>
                        </td>
                        <td width="33%">
                            Bahasa Isyarat : 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question20)? $data->question20 == "tidak" ? "checked":'':'' ?>>
                            <span> Tidak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question20)? $data->question20 == "ya" ? "checked":'':'' ?>>
                            <span>Ya <?= isset($data->{'question20-Comment'})?$data->{'question20-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Kebutuhan Edukasi (pilih topik pada kotak yg tersedia):</td>
                    </tr>
                    <tr>
                        <td width="33%">Diagnosa dan manajemen penyakit </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question22)? $data->question22 == "obat" ? "checked":'':'' ?>>
                            <span>Obat obatan/terapi </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question22)? $data->question22 == "diet" ? "checked":'':'' ?>>
                            <span>Diet dan nutrisi</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Tindakan keperawatan</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question23)? $data->question23 == "rehabilitasi" ? "checked":'':'' ?>>
                            <span>Rehabilitasi </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question23)? $data->question23 == "manajemen_nyeri" ? "checked":'':'' ?>>
                            <span>Manajemen nyeri </span>
                        </td>
                        <td width="33%"> 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question23)? $data->question23 == "other" ? "checked":'':'' ?>>
                            <span>Lain lain, Sebutkan : <?= isset($data->{'question23-Comment'})?$data->{'question23-Comment'}:'' ?></span>
                        </td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td>PERENCANAAN PULANG / <i>DISCHARGE PLANNING</i></td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td colspan="2"><i>dilengkapi dalam waktu 48 jam pertama pasien masuk ruang rawat</i></td>
                    </tr>
                    <tr>
                        <td width="50%">a). Pasien tinggal dengan siapa?</td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question24)? $data->question24 == "sendiri" ? "checked":'':'' ?>>
                            <span>Sendiri </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question24)? $data->question24 == "other" ? "checked":'':'' ?>>
                            <span>Anak/Lain lain, Sebutkan : <?= isset($data->{'question24-Comment'})?$data->{'question24-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">b). Dimana letak kamar pasien di rumah?</td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question25)? $data->question25 == "lantai" ? "checked":'':'' ?>>
                            <span>Lantai dasar </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question25)? $data->question25 == "other" ? "checked":'':'' ?>>
                            <span>Lantai dua/tiga <?= isset($data->{'question25-Comment'})?$data->{'question25-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">c). bagaimana kondisi rumah pasien?</td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question26)?in_array("penerangan", $data->question26)?'checked':'':'') ?>>
                            <span>Penerangan lampu cukup terang/kurang </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question26)?in_array("kamar_tidur", $data->question26)?'checked':'':'') ?> >
                            <span>Kamar tidur jauh/dekat dengan kamar mandi</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question26)?in_array("wc", $data->question26)?'checked':'':'') ?>>                      
                            <span>WC jongkok/duduk </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">d). Bagaimana perawatan kebutuhan dasar pasien?</td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question27)? $data->question27 == "mandiri" ? "checked":'':'' ?>>
                            <span>Mandiri </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question27)? $data->question27 == "dibantu" ? "checked":'':'' ?>>
                            <span>Dibantu sebagian</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question27)? $data->question27 == "dibantu_penuh" ? "checked":'':'' ?>>
                            <span>Dibantu penuh</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">e). Apakah pasien memerlukan alat bantu khusus?</td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question28)? $data->question28 == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question28)? $data->question28 == "other" ? "checked":'':'' ?>>
                            <span>Ya, Sebutkan : <?= isset($data->{'question28-Comment'})?$data->{'question28-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Apakah diet makanan pasien? 
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question29)? $data->question29 == "bebas" ? "checked":'':'' ?>>
                            <span>Bebas </span>
                        </td>
                        <td width="50%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question29)? $data->question29 == "vegetarian" ? "checked":'':'' ?>>
                            <span>Vegetarian</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question29)? $data->question29 == "other" ? "checked":'':'' ?>>
                            <span>Khusus, Sebutkan : <?= isset($data->{'question29-Comment'})?$data->{'question29-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="50%">Perkiraan hari rawatan <?= isset($data->question30)?$data->question30:'' ?> Hari</td>
                    </tr>
                </table>
            </div>
            <br><br><br> <br><br><br> <br><br><br> <br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 4 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:12px">
                <table width="100%" id="ruang">
                    <tr>
                        <td>ASUHAN GYNECOLOGY</td>
                    </tr>
                </table>

                <table width="100%" id="alasan">
                    <tr>
                        <td colspan="3"><b>A. DATA SUBJEKIF</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">1. Riwayat menstruasi</td>
                    </tr>
                    <tr>
                        <td width="25%">Menarche : </td>
                        <td width="25%" colspan="2"><?= isset($data->question31->menarche)?$data->question31->menarche:'' ?> Tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">Siklus : <?= isset($data->question31->siklus)?$data->question31->siklus:'' ?> Hari</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question32)? $data->question32 == "teratur" ? "checked":'':'' ?>>
                            <span>Teratur</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question32)? $data->question32 == "tidak_teratur" ? "checked":'':'' ?>>
                            <span>Tidak Teratur</span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question33)?$data->question33:'' ?> Hari</td>
                    </tr>
                    <tr>
                        <td width="33%">Keluhan : 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question34)? $data->question34 == "dismenorhoe" ? "checked":'':'' ?>>
                            <span>Dismenorhoe</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question34)? $data->question34 == "spotting" ? "checked":'':'' ?>>
                            <span>Spooting</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question34)? $data->question34 == "menorrhagia" ? "checked":'':'' ?>>
                            <span>Menorrhagia</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question34)? $data->question34 == "metrorhagia" ? "checked":'':'' ?>>
                            <span>Metrorhagia</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question34)? $data->question34 == "other" ? "checked":'':'' ?>>
                            <span>Lainnya, <?= isset($data->{'question34-Comment'})?$data->{'question34-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">RIwayat Perkawinan </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question35)? $data->question35 == "menikah" ? "checked":'':'' ?>>
                            <span>Menikah</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question35)? $data->question35 == "belum" ? "checked":'':'' ?>>
                            <span>Belum menikah</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question35)? $data->question35 == "janda" ? "checked":'':'' ?>>
                            <span>Janda</span>
                         </td>
                    </tr>
                    <tr>
                        <td width="33%" rowspan="2">Status Pernikahan: </td>
                        <td width="33%">Istri 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question37)? $data->question37 == "1" ? "checked":'':'' ?>>
                            <span>1x</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question37)? $data->question37 == "2" ? "checked":'':'' ?>>
                            <span>2x</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question37)? $data->question37 == "3" ? "checked":'':'' ?>>
                            <span>>2x</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Suami 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question38)? $data->question38 == "1" ? "checked":'':'' ?>>
                            <span>1x</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question38)? $data->question38 == "2" ? "checked":'':'' ?>>
                            <span>2x</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question38)? $data->question38 == "3" ? "checked":'':'' ?>>
                            <span>>2x</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Lama Pernikahan: </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question39)? $data->question39 == "1" ? "checked":'':'' ?>>
                            <span> < 3 tahun</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question39)? $data->question39 == "2" ? "checked":'':'' ?>>
                            <span>3 - 5 tahun</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question39)? $data->question39 == "3" ? "checked":'':'' ?>>
                            <span>>5 tahun</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Usia perkawinan : </td>
                        <td width="33%"><?= isset($data->question40->usia)?$data->question40->usia:'' ?> tahun</td>
                        <td width="33%">Hubungan <?= isset($data->question40->tahun)?$data->question40->tahun:'' ?> </td>
                    </tr>
                    <tr>
                        <td width="33%">Keluarga terdekat :  
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question41)? $data->question41 == "orang_tua" ? "checked":'':'' ?>>
                            <span>Orang tua</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question41)? $data->question41 == "suami" ? "checked":'':'' ?>>
                            <span>Suami</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question41)? $data->question41 == "anak" ? "checked":'':'' ?>>
                            <span>Anak</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question41)? $data->question41 == "sendiri" ? "checked":'':'' ?>>
                            <span>Sendiri</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question41)? $data->question41 == "other" ? "checked":'':'' ?>>
                            <span>Lainnya, <?= isset($data->{'question41-Comment'})?$data->{'question41-Comment'}:'' ?></span>
                        </td>
                    </tr>
                </table><br>

                <table width="100%" id="ruang">
                    <tr>
                        <td colspan="4">3. Riwayat kehamilan, persalinan dan nifas yg lalu</td>
                    </tr>
                    <tr>
                        <td width="25%">G: <?= isset($data->question42->g)?$data->question42->g:'' ?></td>
                        <td width="25%">P: <?= isset($data->question42->p)?$data->question42->p:'' ?></td>
                        <td width="25%">A: <?= isset($data->question42->a)?$data->question42->a:'' ?></td>
                        <td width="25%">H: <?= isset($data->question42->h)?$data->question42->h:'' ?></td>
                    </tr>
                </table><br>

                <table width="100%" id="gizi">
                    <tr>
                        <td width="3%">No</td>
                        <td width="12%">Tahun partus</td>
                        <td width="12%">Tempat partus</td>
                        <td width="12%">Umur hamil</td>
                        <td width="12%">Jenis persalinan</td>
                        <td width="12%">Penolong persalinan</td>
                        <td width="12%">Penyulit</td>
                        <td width="12%">JK/Berat lahir</td>
                        <td width="13%">Keadaan anak sekarang</td>
                    </tr>
                    <?php 
                            $jml_array = isset($data->question92)?count($data->question92):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                            <tr>  
                                <td width="7%"><?= $x ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 1'})?$data->question92[$x]->{'Column 1'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 2'})?$data->question92[$x]->{'Column 2'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 3'})?$data->question92[$x]->{'Column 3'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 4'})?$data->question92[$x]->{'Column 4'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 5'})?$data->question92[$x]->{'Column 5'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 6'})?$data->question92[$x]->{'Column 6'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 7'})?$data->question92[$x]->{'Column 7'}:'' ?></td>
                                <td width="7%"><?= isset($data->question92[$x]->{'Column 8'})?$data->question92[$x]->{'Column 8'}:'' ?></td>
                            </tr>
                            <?php } ?>
                            <?php 
                            if($jml_array<=10){
                            $jml_kurang = 10 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                           <tr>  
                                <td width="7%"><br></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                                <td width="7%"><?= '' ?></td>
                            </tr>
                            <?php }} ?>
                            
                    </tr>
                </table><br>

                <table width="100%" id="ruang">
                    <tr>
                        <td colspan="3">4. Riwayat penyakit dahulu</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("asma", $data->question44)?'checked':'':'') ?>>
                            <span>Asma</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("jantung", $data->question44)?'checked':'':'') ?>>
                            <span>Jantung</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("hipertensi", $data->question44)?'checked':'':'') ?>>
                            <span>Hipertensi</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("dm", $data->question44)?'checked':'':'') ?>>
                            <span>DM</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("tiroid", $data->question44)?'checked':'':'') ?>>
                            <span>Tiroid</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("epilepsi", $data->question44)?'checked':'':'') ?>>
                            <span>Epilepsi</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan = "3">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question44)?in_array("other", $data->question44)?'checked':'':'') ?>>
                            <span>Riwayat Operasi</span>
                            <?= isset($data->{'question44-Comment'})?$data->{'question44-Comment'}:'' ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">5. Riwayat penyakit keluarga</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("kanker", $data->question45)?'checked':'':'') ?>>
                            <span>Kanker</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("hipertensi", $data->question45)?'checked':'':'') ?>>
                            <span>Hipertensi</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("ginjal", $data->question45)?'checked':'':'') ?>>
                            <span>Penyakit ginjal</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("kelainan_bawaan", $data->question45)?'checked':'':'') ?>>
                            <span>Kelainan bawaan</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("tbc", $data->question45)?'checked':'':'') ?>>
                            <span>TBC</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("alergi", $data->question45)?'checked':'':'') ?>>
                            <span>Alergi</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("hati", $data->question45)?'checked':'':'') ?>>
                            <span>Penyakit hati</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("dm", $data->question45)?'checked':'':'') ?>>
                            <span>DM</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("jiwa", $data->question45)?'checked':'':'') ?>>
                            <span>Penyakit jiwa</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("hamil_kembar", $data->question45)?'checked':'':'') ?>>
                            <span>Hamil kembar</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("epilepsi", $data->question45)?'checked':'':'') ?>>
                            <span>Epilepsi</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question45)?in_array("other", $data->question45)?'checked':'':'') ?>>
                            <span>Lain lain , <?= isset($data->{'question45-Comment'})?$data->{'question45-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">6. Riwayat Ginekologi</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("infertilitas", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Infertilitas</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("infeksi", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Infeksi virus</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("pms", $data->ginekologi)?'checked':'':'') ?>>
                            <span>PMS</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("cervisitis", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Cervisitis kronis</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("endrometrio", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Endometrio</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("myoma", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Myoma</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("polip", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Polip serviks</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("kanker_kandungan", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Kanker kandungan</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("operasi_kandungan", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Operasi kandungan</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("perkosaan", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Perkosaan</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33   %">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("flour", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Flour albus(gatal): </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question47)? $data->question47 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question47)? $data->question47 == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak, </span>
                        </td>
                        <td width="33%">Berbau : 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question46)? $data->question46 == "ya" ? "checked":'':'' ?>>
                            <span>Ya, </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question46)? $data->question46 == "other" ? "checked":'':'' ?>>
                            <span>Tidak, warna : <?= isset($data->{'question46-Comment'})?$data->{'question46-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("postcoital", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Post coital bleeding </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ginekologi)?in_array("other", $data->ginekologi)?'checked':'':'') ?>>
                            <span>Lain lain, Warna : <?= isset($data->{'ginekologi-Comment'})?$data->{'ginekologi-Comment'}:'' ?></span>
                        </td>
                    </tr>
                </table>
            </div>
            <br><br><br>  <br><br><br>  <br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 5 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:12px">
               <table width="100%" id="ruang">
                    <tr>
                        <td colspan="3">7. Riwayat penyakit menular</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question48)?in_array("sipilis", $data->question48)?'checked':'':'') ?>>
                            <span>Sipilis </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question48)?in_array("hiv", $data->question48)?'checked':'':'') ?>>
                            <span>HIV </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question48)?in_array("hepatitis", $data->question48)?'checked':'':'') ?>>
                            <span>Hepatitis </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question48)?in_array("other", $data->question48)?'checked':'':'') ?>>
                            <span>Lain lain : <?= isset($data->{'question48-Comment'})?$data->{'question48-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">8. Riwayat KB</td>
                    </tr>
                    <tr>
                        <td width="33%" rowspan="8">Metode KB yg pernah dipakai </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("pil", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>PIL </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question50)?$data->question50:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("iud", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>IUD </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question49)?$data->question49:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("suntik", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>Suntik </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question51)?$data->question51:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("implan", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>Implant </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question52)?$data->question52:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("kondom", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>Kondom </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question53)?$data->question53:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("mow", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>MOW </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question54)?$data->question54:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("mop", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>MOP </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question55)?$data->question55:'' ?> tahun</td>
                    </tr><tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->riwayat_kb)?in_array("Alami", $data->riwayat_kb)?'checked':'':'') ?>>
                            <span>Alami </span>
                        </td>
                        <td width="33%">Lama : <?= isset($data->question56)?$data->question56:'' ?> tahun</td>
                    </tr>
                    <tr>
                        <td width="33%">Komplikasi dari KB : </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question57)?in_array("perdarahan", $data->question57)?'checked':'':'') ?>>
                            <span>Pendarahan </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question57)?in_array("pid", $data->question57)?'checked':'':'') ?>>
                            <span>PID/Radang panggul </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question57)?in_array("other", $data->question57)?'checked':'':'') ?>>
                            <span>Lain lain:  <?= isset($data->{'question57-Comment'})?$data->{'question57-Comment'}:'' ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">9. Pola eliminasi/istirahat</td>
                    </tr>
                    <tr>
                        <td width="33%" rowspan="2">Pola eliminasi : </td>
                        <td width="33%">BAK <?= isset($data->question58->bak)?$data->question58->bak:'' ?> cc/hari</td>
                        <td width="33%">Warna : <?= isset($data->question58->warna)?$data->question58->warna:'' ?> </td>
                    </tr>
                    <tr>
                        <td width="33%">BAB <?= isset($data->question58->bab)?$data->question58->bab:'' ?> x/hari</td>
                        <td width="33%">Karakteristik : <?= isset($data->question58->karakteristik)?$data->question58->karakteristik:'' ?> </td>
                    </tr>
                    <tr>
                        <td width="33%">Pola istirahat : </td>
                        <td width="33%">Tidur malam <?= isset($data->question94->malam)?$data->question94->malam:'' ?> jam/hari</td>
                        <td width="33%">Tidur siang : <?= isset($data->question94->siang)?$data->question94->siang:'' ?> jam/hari</td>
                    </tr>
                    <tr>
                        <td width="33%">10. Perilaku kesehatan : </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question59)?in_array("penggunaan_alkohol", $data->question59)?'checked':'':'') ?>>
                            <span>Penggunaan alkohol </span>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question59)?in_array("jamu", $data->question59)?'checked':'':'') ?>>
                            <span>Jamu </span>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question59)?in_array("meroko", $data->question59)?'checked':'':'') ?>>
                            <span>Merokok </span>
                        </td>
                    </tr>
               </table><br>

               <table width="100%" id="ruang">
                    <tr>
                        <td colspan="3"><b>B. DATA OBJEKTIF</b></td>
                    </tr>
                    <tr>
                        <td colspan="3">1. Pemeriksaan Umum</td>
                    </tr>
                    <tr>
                        <td colspan="3">Keadaan umum : <?= isset($data->question60->keadaan_umum)?$data->question60->keadaan_umum:'' ?></td>
                    </tr>
                    <tr>
                        <td width="33%">Kesadaran : 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question61)? $data->question61 == "compos_mentis" ? "checked":'':'' ?>>
                            <span>Compos mentis </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question61)? $data->question61 == "apatis" ? "checked":'':'' ?>>
                            <span>Apatis </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question61)? $data->question61 == "somnolen" ? "checked":'':'' ?>>
                            <span>Somnolen </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question61)? $data->question61 == "soporous" ? "checked":'':'' ?>>
                            <span>Soporous / koma </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">TD : <?= isset($data->question62->td)?$data->question62->td:'' ?> mmHg</td>
                        <td width="33%">Frekuensi nadi <?= isset($data->question62->fd)?$data->question62->fd:'' ?> x/mnt;
                            Suhu : <?= isset($data->question62->suhu)?$data->question62->suhu:'' ?> C 
                        </td>
                        <td width="33%">Frekuensi pernapasan : <?= isset($data->question62->frekuensi_pernafasan)?$data->question62->frekuensi_pernafasan:'' ?> x/mnt</td>
                    </tr>
                    <tr>
                        <td width="33%">Berat badan sebelum hamil <?= isset($data->question63->bb_sebelum)?$data->question63->bb_sebelum:'' ?> Kg</td>
                        <td width="33%">Tinggi badan : <?= isset($data->question63->t_badan)?$data->question63->t_badan:'' ?> cm</td>
                    </tr>
                    <tr>
                        <td width="33%">Berat badan sekarang <?= isset($data->question62->bb_sekarang)?$data->question62->bb_sekarang:'' ?> Kg</td>
                        <td width="33%">Lingkar lengan : <?= isset($data->question62->l_lengan)?$data->question62->l_lengan:'' ?> cm</td>
                    </tr>
                    <tr>
                        <td colspan="3">2. Pemeriksaan Fisik</td>
                    </tr>
                    <tr>
                        <td colspan="3">Wajah</td>
                    </tr>
                    <tr>
                        <td width="33%">Oedema : </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question64)? $data->question64 == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question64)? $data->question64 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Cloasma Gravidarum : </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question65)? $data->question65 == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question65)? $data->question65 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" rowspan="3">Mata </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question66)? $data->question66 == "simetris" ? "checked":'':'' ?>>
                            <span>Simetris </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question66)? $data->question66 == "asimetris" ? "checked":'':'' ?>>
                            <span>Asimetris </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                           
                            <span>Sklera </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question67)? $data->question67 == "ikterik" ? "checked":'':'' ?>>
                            <span>Ikterik </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question67)? $data->question67 == "non" ? "checked":'':'' ?>>
                            <span>Non Ikterik </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            
                            <span>Konjungtiva </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question68)? $data->question68 == "anemis" ? "checked":'':'' ?>>
                            <span>Anemis </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question68)? $data->question68 == "non" ? "checked":'':'' ?>>
                            <span>Non Anemis </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Mulut </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question69)? $data->question69 == "mukosa_kering" ? "checked":'':'' ?>>
                            <span>Mukosa kering </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question69)? $data->question69 == "mukosa_lembab" ? "checked":'':'' ?>>
                            <span>Mukosa lembab </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" rowspan="2">Leher </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question70)? $data->question70 == "pembesaran_tiroid" ? "checked":'':'' ?>>
                            <span>Pembesaran tyroid </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question70)? $data->question70 == "pembesaran" ? "checked":'':'' ?>>
                            <span>Pembesaran </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question70)? $data->question70 == "vena" ? "checked":'':'' ?>>
                            <span>Vena jugularis </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question70)? $data->question70 == "kaku" ? "checked":'':'' ?>>
                            <span>Kaku duduk </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question70)? $data->question70 == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada masalah </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Mamae</b></td>
                    </tr>
                    <tr>
                        <td width="33%">Bentuk  
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question71)? $data->question71 == "simetris" ? "checked":'':'' ?>>
                            <span>Simetris </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question71)? $data->question71 == "asimetris" ? "checked":'':'' ?>>
                            <span>Asimetris, </span>
                        </td>
                        <td colspan="2">Puting susu 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question72)? $data->question72 == "menonjol" ? "checked":'':'' ?>>
                            <span>Menonjol </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question72)? $data->question72 == "datar" ? "checked":'':'' ?>>
                            <span>Datar </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question72)? $data->question72 == "masuk" ? "checked":'':'' ?>>
                            <span>Masuk </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Pengeluaran 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question73)? $data->question73 == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question73)? $data->question73 == "ada" ? "checked":'':'' ?>>
                            <span>Ada </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question74)? $data->question74 == "colostrum" ? "checked":'':'' ?>>
                            <span>Colostrum </span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question74)? $data->question74 == "asi" ? "checked":'':'' ?>>
                            <span>Asi </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question74)? $data->question74 == "nanah" ? "checked":'':'' ?>>
                            <span>Nanah </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question74)? $data->question74 == "darah" ? "checked":'':'' ?>>
                            <span>Darah </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Kebersihan 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question75)? $data->question75 == "cukup" ? "checked":'':'' ?>>
                            <span>Cukup </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question75)? $data->question75 == "kurang" ? "checked":'':'' ?>>
                            <span>Kurang </span>
                        </td>
                        <td colspan="2">Kelainan 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question76)? $data->question76 == "lecet" ? "checked":'':'' ?>>
                            <span>Lecet </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question76)? $data->question76 == "bengkak" ? "checked":'':'' ?>>
                            <span>Bengkak </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question76)? $data->question76 == "other" ? "checked":'':'' ?>>
                            <span>Lainnya : <?= isset($data->{'question76-Comment'})?$data->{'question76-Comment'}:'' ?> </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Abdomen</b></td>
                    </tr>
                    <tr>
                        <td width="33%">Pembesaran sesuai dengan usia kehamilan</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question77)? $data->question77 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question77)? $data->question77 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Bekas luka operasi</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question78)? $data->question78 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question78)? $data->question78 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Striae gravidarum</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question79)? $data->question79 == "livid" ? "checked":'':'' ?>>
                            <span>Livid </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question79)? $data->question79 == "albican" ? "checked":'':'' ?>>
                            <span>Albican </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Pembengkakan pada perut</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question80)? $data->question80 == "ada" ? "checked":'':'' ?>>
                            <span>Ada </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question80)? $data->question80 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Ekstremitas</b></td>
                    </tr>
                    <tr>
                        <td width="33%">Oedema</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question81)? $data->question81 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question81)? $data->question81 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Varises</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question82)? $data->question82 == "ya" ? "checked":'':'' ?>>
                            <span>Ya </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question82)? $data->question82 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Reflek patella</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question83)? $data->question83 == "kiri" ? "checked":'':'' ?>>
                            <span>Kiri </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question83)? $data->question83 == "kanan" ? "checked":'':'' ?>>
                            <span>Kanan </span>
                        </td>
                    </tr>
               </table>
            </div>
            <br><br><br> <br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 6 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:12px">
               <table width="100%" id="ruang">
                    <tr>
                        <td colspan="3"><b>Inpesculum</b></td>
                    </tr>
                    <tr>
                        <td width="33%">Oedema</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question84)? $data->question84 == "ada" ? "checked":'':'' ?>>
                            <span>Ada </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question84)? $data->question84 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Pembesaran Kelenjar Bartholini</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question85)? $data->question85 == "ada" ? "checked":'':'' ?>>
                            <span>Ada </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question85)? $data->question85 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Tanda tanda infeksi</td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question86)? $data->question86 == "ada" ? "checked":'':'' ?>>
                            <span>Ada </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question86)? $data->question86 == "tidak" ? "checked":'':'' ?>>
                            <span>TIdak </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%">Lainnya : <?= isset($data->{'question86-Comment'})?$data->{'question86-Comment'}:'' ?></td>
                    </tr>
               </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 7 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>ASSESMEN AWAL KEBIDANAN GINEKOLOGI RAWAT INAP</h4></center>
        
            <div style="font-size:12px">

                <table width="100%" id="ruang">
                    <tr>
                        <td><b>DAFTAR MASALAH KEBIDANAN</b></td>
                    </tr>
                </table>

               <table width="100%" id="alasan">
                    <tr>
                        <td width="33%" id="kanan">Diagnosa Kebidanan</td>
                        <td width="33%" id="kanan">Masalah</td>
                        <td width="33%">Kebutuhan</td>
                    </tr>
               </table>

               <table width="100%" id="alasan">
                    <tr>
                        <td width="33%" id="kanan">Hamil</td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("abortus", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Abortus</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("monitor", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Monitor tanda tanda vital</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("primipara", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Primipara</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("kpd", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>KPD</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("pemberian_oksigen", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Pemberian oksigen</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("multipara", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Multipara</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("cpd", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>CPD</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("memberikan_posisi", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Memberikan posisi semi fowler</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("grandepara", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Grandepara</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("hap", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>H.A.P</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("memberikan_obat", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Meberikan obat</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("tunggal", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Tunggal</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("hpp", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>H.P.P</span>
                        </td>
                        <td width="33%">oral, injeksi, infus</td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("ganda", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Ganda</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("kehamilan_ektopik", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Kehamilan ektopik</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("memasang_infus", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Memasang infus</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("intrauterina", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Intrauterine</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("pprom", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>PPROM</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("pemasangan_chateter", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Pemasangan chateter</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question90->{'Row 1'}->hamil)?in_array("ekstrauterin", $data->question90->{'Row 1'}->hamil)?'checked':'':'') ?>>
                            <span>Ekstrauterine</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("prom", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>PROM</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("ctg", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Pemasangan CTG dan merekam</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">usia kehamilan</td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("peb", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>PEB</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("merekam_ekg", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Merekam EKG</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->usia_kehamilan)?in_array("pretrerm", $data->question90->{'Row 1'}->usia_kehamilan)?'checked':'':'') ?>>
                            <span>Preterm</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("eklamsia", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Eklamsia</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("merekam_usg", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Merekam USG</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->usia_kehamilan)?in_array("post_term", $data->question90->{'Row 1'}->usia_kehamilan)?'checked':'':'') ?>>
                            <span>Post term</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("anemia_ringan", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Anemia ringan</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("persalinan", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Membantu persalinan dengan</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">posisi</td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("anemia_sedang", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Anemia sedang</span>
                        </td>
                        <td width="33%">tindakan </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->posisi)?in_array("kepala", $data->question90->{'Row 1'}->posisi)?'checked':'':'') ?>>
                            <span>Kepala</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("anemia_berat", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Anemia berat</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("jahit", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Jahit luka</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->posisi)?in_array("sungsang", $data->question90->{'Row 1'}->posisi)?'checked':'':'') ?>>
                            <span>Sungsang</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("infeksi", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Infeksi</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("memberikan", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Memberikan pendidikan</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->posisi)?in_array("lintang", $data->question90->{'Row 1'}->posisi)?'checked':'':'') ?>>
                            <span>Lintang</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("luka_jalan", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Luka jalan lahir</span>
                        </td>
                        <td width="33%">kesehatan</td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">presentasi</td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("perdarahan", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Pendarahan uterus abnormal</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("pantauan_kemajuan", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Pantau kemajuan persalinan</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->presentasi)?in_array("belakang_kepala", $data->question90->{'Row 1'}->presentasi)?'checked':'':'') ?>>
                            <span>Belakang kepala</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("retensio", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Retensio plasenta</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("menolong_persalinan", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Menolong persalinan spontan</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->presentasi)?in_array("bokong", $data->question90->{'Row 1'}->presentasi)?'checked':'':'') ?>>
                            <span>Bokong</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("plasenta", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Plasenta previa</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("manual_plasenta", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Manual plasenta</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->presentasi)?in_array("muka", $data->question90->{'Row 1'}->presentasi)?'checked':'':'') ?>>
                            <span>Muka</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("mioma_uteri", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Mioma uteri</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("pemasangan_transfusi", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Pemasangan Transfusi darah</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->presentasi)?in_array("ekstremitas", $data->question90->{'Row 1'}->presentasi)?'checked':'':'') ?>>
                            <span>Ekstremitas</span>
                        </td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("kista", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Kista ovarium</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("pemasanga_monitor", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Pemasangan monitor</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">keadaan ibu</td>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question87[0]->masalah)?in_array("inversion", $data->question87[0]->masalah)?'checked':'':'') ?>>
                            <span>Inversion uteri</span>
                        </td>
                        <td width="33%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question88[0]->kebutuhan)?in_array("manajemen_nyeri", $data->question88[0]->kebutuhan)?'checked':'':'') ?>>
                            <span>Manajemen nyeri</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->keadaan_ibu)?in_array("baik", $data->question90->{'Row 1'}->keadaan_ibu)?'checked':'':'') ?>>
                            <span>Baik</span>
                        </td>
                        <td width="33%" id="kanan">
                           
                        </td>
                        <td width="33%">
                            
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->keadaan_ibu)?in_array("tidak", $data->question90->{'Row 1'}->keadaan_ibu)?'checked':'':'') ?>>
                            <span>Tidak Baik</span>
                        </td>
                        <td width="33%" id="kanan" rowspan="6">
                          
                        </td>
                        <td width="33%" rowspan="6">
                         
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">keadaan janin</td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->keadaan_janin)?in_array("baik", $data->question90->{'Row 1'}->keadaan_janin)?'checked':'':'') ?>>
                            <span>Baik</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="33%" id="kanan">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question90->{'Row 1'}->keadaan_janin)?in_array("tidak_baik", $data->question90->{'Row 1'}->keadaan_janin)?'checked':'':'') ?>>
                            <span>Tidak Baik</span>
                        </td>
                    </tr>
                  
               </table><br><br>

               <table width="100%" border="0">
                    <tr>
                        <td align="right"><b>Bidan yang melakukan pengkajian</b></td>
                    </tr>
                  
                        <?php
                            $id = isset($kebidanan_ginekologi->id_pemeriksa)?$kebidanan_ginekologi->id_pemeriksa:'';
                            //  var_dump($id);                                     
                            $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users  where hmis_users.userid = $id")->row():null;
                            if(isset($query->ttd)){
                            ?>
                            <tr align="right">
                                <td width="50%">  
                                    <img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                                    <span><?= $query->name ?></span>
                                </td>
                            </tr>  
                            <?php
                                } else {?>
                                    <br><br><br>
                                <?php } ?>

                        
                    
                    <tr>
                        <td align="right"><b>(Nama jelas dan ttd)</b></td>
                    </tr>
               </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 8 dari 8</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    </body>
    </html>