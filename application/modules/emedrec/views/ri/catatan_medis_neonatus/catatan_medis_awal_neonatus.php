<?php
$data = (isset($neonatus->formjson)?json_decode($neonatus->formjson):'');
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
            font-size: 10px;
            position: relative;
        }

        #data tr td{
            font-size: 10px;
        }
       
        #ortu {
            border-left: 1px solid;
            border-right: 1px solid;
            border-top: 1px solid;
            border-bottom: 1px solid;
        }

        #allo {
            border-left: 1px solid;
            border-right: 1px solid;
            border-top: 1px solid;
        }

        #keluhan {
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
        }

        #riwayat {
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
        }

        #pemeriksaanfisik {
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
        } #gizi tr td {
            border: 1px solid;
        }
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>CATATAN MEDIS AWAL NEONATUS</h4></center>

            <div style="font-size:12px;min-height:870px">

                <table width="100%" id="ortu">
                    <tr>
                        <td width="50%"><b>Tanggal : </b><?= isset($data->question1)? date('d-m-Y',strtotime($data->question1)):''; ?></td>
                        <td width="50%"><b>Jam : </b><?= isset($data->question1)? date('h:i',strtotime($data->question1)):''; ?></td>
                    </tr>
                </table>
               
                <table width="100%" id="keluhan">
                    <tr>
                        <td colspan="4"><h4>1. Anamnesa</h4></td>
                    </tr>
                    <tr>
                        <td colspan="4">Keluhan utama : <?= isset($data->question2)?$data->question2:''; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Riwayat Penyakit sekarang : <?= isset($data->question3)?$data->question3:''; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Riwayat penyakit dahulu : <?= isset($data->question4)?$data->question4:''; ?></td>
                    </tr>
                    <tr>
                        <td colspan="4"><b>Keadaan Umum :</b></td>
                    </tr>
                    <tr>
                        <td width="25%">Kondisi saat lahir : </td>
                        <td width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question5)? $data->question5 == "segera_menangis" ? "checked":'':'' ?>>
                            <span>Segera menangis</span>
                        </td>
                        <td width="25%"> 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question5)? $data->question5 == "tidak_segera_menangis" ? "checked":'':'' ?>>
                            <span>Tidak Segera menangis </span>
                        </td>
                        <td width="25%"> Apgar Score : <?= isset($data->question6)? $data->question6:''; ?></td>
                    </tr>
                    <tr>
                        <td width="25%">Gerak : <?= isset($data->question7->gerak)? $data->question7->gerak:''; ?></td>
                        <td width="25%">Tangis : <?= isset($data->question7->tangis)? $data->question7->tangis:''; ?>  </td>
                        <td width="25%">Warna kulit : <?= isset($data->question7->warna_kulit)? $data->question7->warna_kulit:''; ?></td>
                    </tr>
                    <tr>
                        <td width="25%">HR : <?= isset($data->question8->hr)? $data->question8->hr:''; ?> x/mnt</td>
                        <td width="25%">Suhu : <?= isset($data->question8->suhu)? $data->question8->suhu:''; ?></td>
                        <td width="25%">RR : <?= isset($data->question8->rr)? $data->question8->rr:''; ?> x/mnt</td>
                        <td width="25%">Saturasi O2 : <?= isset($data->question8->saturasi)? $data->question8->saturasi:''; ?></td>
                    </tr>
                    <tr>
                        <td width="25%">Capilary Refill : </td>
                        <td width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question9)? $data->question9 == "<2detik" ? "checked":'':'' ?>>
                            <span>< 2 detik</span>
                        </td>
                        <td width="25%">
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question9)? $data->question9 == ">2detik" ? "checked":'':'' ?>>
                            <span>> 2 detik</span>
                        </td>
                    </tr>
                </table>

                <table width="100%" id="keluhan">
                    <tr>
                        <td colspan="5"><h4>2. Ukuran Antropometri :</h4></td>
                    </tr>
                    <tr>
                        <td width="20%">BBL : <?= isset($data->question10->bbl)?$data->question10->bbl:''; ?> gram</td>
                        <td width="20%">PB : <?= isset($data->question10->pb)?$data->question10->pb:''; ?></td>
                        <td width="20%">LK : <?= isset($data->question10->lk)?$data->question10->lk:''; ?> cm</td>
                        <td width="20%">LD : <?= isset($data->question10->ld)?$data->question10->ld:''; ?> cm</td>
                        <td width="20%">LP<?= isset($data->question10->lp)?$data->question10->lp:''; ?> cm</td>
                    </tr>
                </table>

                <table width="100%" id="keluhan">
                    <tr>
                        <td colspan="5"><h4>3. Pemeriksaan fisik</h4></td>
                    </tr>
                    <tr>
                        <td width="20%" rowspan="2">Kepala : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("simetris", $data->kepala)?'checked':'':'') ?>>
                            <span>Simeteris</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("asimetris", $data->kepala)?'checked':'':'') ?>>
                            <span>Asimetris</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("cephal", $data->kepala)?'checked':'':'') ?>>
                            <span>Cephal Hematoma</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("caput", $data->kepala)?'checked':'':'') ?>>
                            <span>Caput Succedanium</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("anenceephali", $data->kepala)?'checked':'':'') ?>>
                            <span>Anencephali</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("microcephali", $data->kepala)?'checked':'':'') ?>>
                            <span>Mikrocephali</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("hydrocephalus", $data->kepala)?'checked':'':'') ?>>
                            <span>Hydrocephalus</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kepala)?in_array("other", $data->kepala)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'kepala-Comment'})?$data->{'kepala-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">UUB : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question11)?in_array("datar", $data->question11)?'checked':'':'') ?>>
                            <span>Datar</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question11)?in_array("cembung", $data->question11)?'checked':'':'') ?>>
                            <span>Cembung</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question11)?in_array("cekung", $data->question11)?'checked':'':'') ?>>
                            <span>Cekung</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"<?= (isset($data->question11)?in_array("other", $data->question11)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'question11-Comment'})?$data->{'question11-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Mata : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("normal", $data->question12)?'checked':'':'') ?>>
                            <span>Normal</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("anemia", $data->question12)?'checked':'':'') ?>>
                            <span>Anemia</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("ikterus", $data->question12)?'checked':'':'') ?>>
                            <span>Ikerus</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("sekret", $data->question12)?'checked':'':'') ?>>
                            <span>Sekret</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question12)?in_array("other", $data->question12)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'question12-Comment'})?$data->{'question12-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">THT : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("normal", $data->question13)?'checked':'':'') ?>>
                            <span>Normal</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("nch", $data->question13)?'checked':'':'') ?>>
                            <span>NCH</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("cianosis", $data->question13)?'checked':'':'') ?>>
                            <span>Cianomis</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("sekret", $data->question13)?'checked':'':'') ?>>
                            <span>Sekret</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->question13)?in_array("other", $data->question13)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'question13-Comment'})?$data->{'question13-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" rowspan="2">Mulut : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->mulut)?in_array("normal", $data->mulut)?'checked':'':'') ?>>
                            <span>Normal</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->mulut)?in_array("labioschizis", $data->mulut)?'checked':'':'') ?>>
                            <span>Labioschizis</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->mulut)?in_array("labiopalaschizis", $data->mulut)?'checked':'':'') ?>>
                            <span>Labiopalatoshizis</span>
                        </td>
                        <td width="20%">Labiogenatopalatoshizis</td>
                    </tr>
                    <tr>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->mulut)?in_array("mukosa", $data->mulut)?'checked':'':'') ?>>
                            <span>Mukosa</span>
                        </td>
                        <td width="20%">Warna : <?= isset($data->warna)?$data->warna:''; ?></td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->mulut)?in_array("reflek_hisap", $data->mulut)?'checked':'':'') ?>>
                            <span>Reflek hisap</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->mulut)?in_array("other", $data->mulut)?'checked':'':'') ?>>
                            <span>Lainnya :  <?= isset($data->{'mulut-Comment'})?$data->{'mulut-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">Thorax : <?= isset($data->thorax)?$data->thorax:''; ?></td>
                    </tr>
                    <tr>
                        <td width="20%">Paru : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->paru)?in_array("normal", $data->paru)?'checked':'':'') ?>>
                            <span>Normal</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->paru)?in_array("retraksi", $data->paru)?'checked':'':'') ?>>
                            <span>Retraksi</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->paru)?in_array("sesak", $data->paru)?'checked':'':'') ?>>
                            <span>Sesak</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->paru)?in_array("merintih", $data->paru)?'checked':'':'') ?>>
                            <span>Merintih</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->paru)?in_array("sianosis", $data->paru)?'checked':'':'') ?>>
                            <span>Sianosis</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->paru)?in_array("nch", $data->paru)?'checked':'':'') ?>>
                            <span>NCH </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" rowspan="2">Jantung : BJ I/II</td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->jantung)?in_array("murni", $data->jantung)?'checked':'':'') ?>>
                            <span>Murni</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->jantung)?in_array("tidak_murni", $data->jantung)?'checked':'':'') ?>>
                            <span>Tidak Murni</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->jantung)?in_array("reguler", $data->jantung)?'checked':'':'') ?>>
                            <span>Reguler</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->jantung)?in_array("tidak_reguler", $data->jantung)?'checked':'':'') ?>>
                            <span>Tidak regular</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->jantung)?in_array("bunyi", $data->jantung)?'checked':'':'') ?>>
                            <span>Bunyi tambahan</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Abdomen : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question14)?in_array("normal", $data->question14)?'checked':'':'') ?>>
                            <span>Normal</span>
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question14)?in_array("distensi", $data->question14)?'checked':'':'') ?>>
                            <span>Distensi</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question14)?in_array("busing_usu", $data->question14)?'checked':'':'') ?>>
                            <span>Bising usus</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question14)?in_array("pembesaran_hepar", $data->question14)?'checked':'':'') ?>>
                            <span>Pembesaran hepar</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak"  <?= (isset($data->question14)?in_array("pembesaran_limpa", $data->question14)?'checked':'':'') ?>>
                            <span>Pembesaran limpa</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Tali pusat : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->tali_pusat)?in_array("segar", $data->tali_pusat)?'checked':'':'') ?>>
                            <span>Segar</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->tali_pusat)?in_array("layu", $data->tali_pusat)?'checked':'':'') ?>>
                            <span>Layu</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->tali_pusat)?in_array("other", $data->tali_pusat)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'tali_pusat-Comment'})?$data->{'tali_pusat-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Punggung : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->punggung)?in_array("normal", $data->punggung)?'checked':'':'') ?>>
                            <span>Normal</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->punggung)?in_array("spina_bifida", $data->punggung)?'checked':'':'') ?>>
                            <span>Spina Bifida</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->punggung)?in_array("gibus", $data->punggung)?'checked':'':'') ?>>
                            <span>Gibus</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->punggung)?in_array("other", $data->punggung)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'punggung-Comment'})?$data->{'punggung-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Genetalia : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->genetalia)?in_array("kelainanL", $data->genetalia)?'checked':'':'') ?>>
                            <span>(L)Kelainan , <?= isset($data->question22)?$data->question22:''; ?></span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->genetalia)?in_array("hemaphrodit", $data->genetalia)?'checked':'':'') ?>>
                            <span>Hemaphrodit</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->genetalia)?in_array("kelainanp", $data->genetalia)?'checked':'':'') ?>>
                            <span>(P) Kelainan , <?= isset($data->question21)?$data->question21:''; ?></span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->genetalia)?in_array("other", $data->genetalia)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'genetalia-Comment'})?$data->{'genetalia-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Anus : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->anus)?in_array("ada", $data->anus)?'checked':'':'') ?>>
                            <span>Ada</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->anus)?in_array("tidak_ada", $data->anus)?'checked':'':'') ?>>
                            <span>Tidak ada</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->anus)?in_array("bab", $data->anus)?'checked':'':'') ?>>
                            <span>BAB</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Ekstremitas : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array("simetris", $data->ekstremitas)?'checked':'':'') ?>>
                            <span>Simetris</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array("asimetris", $data->ekstremitas)?'checked':'':'') ?>>
                            <span>Asimetris</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array("refleks", $data->ekstremitas)?'checked':'':'') ?>>
                            <span>Refleks morro</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->ekstremitas)?in_array("other", $data->ekstremitas)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'ekstremitas-Comment'})?$data->{'ekstremitas-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%" rowspan="2">Kulit : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("turgor", $data->kulit)?'checked':'':'') ?>>
                            <span>Turgor</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("kutis_marmorata", $data->kulit)?'checked':'':'') ?>>
                            <span>Kutis marmorata</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("sianosis", $data->kulit)?'checked':'':'') ?>>
                            <span>Sianosis</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("ikterus", $data->kulit)?'checked':'':'') ?>>
                            <span>Ikerus </span>
                        </td>
                    </tr>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("perdarahan", $data->kulit)?'checked':'':'') ?>>
                            <span>Perdarahan</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("hematoma", $data->kulit)?'checked':'':'') ?>>
                            <span>Hematoma</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("sklerema", $data->kulit)?'checked':'':'') ?>>
                            <span>Sklerema</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->kulit)?in_array("other", $data->kulit)?'checked':'':'') ?>>
                            <span>Lainnya : <?= isset($data->{'kulit-Comment'})?$data->{'kulit-Comment'}:''; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="20%">Metablisme : </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->metablisme)?in_array("edema", $data->metablisme)?'checked':'':'') ?>>
                            <span>Edema</span>
                        </td>
                        <td width="20%">
                            <input type="checkbox" value="Tidak" <?= (isset($data->metablisme)?in_array("bak", $data->metablisme)?'checked':'':'') ?>>
                            <span>BAK</span>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 4</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
            
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <style type="text/css">
                #pemeriksaanfisik2 {
                    border-left: 1px solid;
                    border-right: 1px solid;
                    border-top: 1px solid;
                    border-bottom: 1px solid;
                } #penunjang {
                    border-left: 1px solid;
                    border-right: 1px solid;
                    border-top: 1px solid;
                    border-bottom: 1px solid;
                } #lab {
                    border-right: 1px solid;
                }
            </style>
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>

            <center><h4>CATATAN MEDIS AWAL NEONATUS</h4></center>

            <div style="font-size:12px;min-height:870px">

                <table width="100%" id="gizi">
                    <tr>
                        <td colspan="5"><h4>4. Penilaian SKor Downes</h4></td>
                    </tr>
                    <tr>
                        <td width="23,75%">Pernapasan</td>
                        <td width="23,75%">0</td>
                        <td width="23,75%">1</td>
                        <td width="23,75%">2</td>
                        <td width="5%">Nilai</td>
                    </tr>
                    <tr>
                        <td width="23,75%">Frekuensi napas</td>
                        <td width="23,75%">< 60/menit</td>
                        <td width="23,75%">60 - 80 /menit</td>
                        <td width="23,75%">> 80/menit</td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->{'1'})?$data->question15->{'Row 1'}->{'1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="23,75%">Retraksi</td>
                        <td width="23,75%">Tidak ada retraksi</td>
                        <td width="23,75%">Retraksi ringan</td>
                        <td width="23,75%">Retraksi berat</td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->{'5'})?$data->question15->{'Row 1'}->{'5'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="23,75%">Sianosis</td>
                        <td width="23,75%">Tidak ada sianosis</td>
                        <td width="23,75%">Sianosis hilang dengan O2</td>
                        <td width="23,75%">Sianosis menetap walaupun diberi O2</td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->{'2'})?$data->question15->{'Row 1'}->{'2'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="23,75%">Air entry</td>
                        <td width="23,75%">Udara masuk</td>
                        <td width="23,75%">Penurunan ringan udara masuk</td>
                        <td width="23,75%">Tidak ada udara masuk</td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->{'3'})?$data->question15->{'Row 1'}->{'3'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="23,75%">Merintih</td>
                        <td width="23,75%">Tidak merintih</td>
                        <td width="23,75%">Dapat didengar dengan stetoskop</td>
                        <td width="23,75%">Dpat didengar tanpa alat bantu</td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->{'4'})?$data->question15->{'Row 1'}->{'4'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="95%" colspan="4"><h4>Total Nilai</h4></td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->total_skor)?$data->question15->{'Row 1'}->total_skor:'' ?></td>
                    </tr>
                    <tr>
                        <td width="95%" colspan="4"><h4>Keterangan</h4></td>
                        <td width="5%" style="text-align:center"><?= isset($data->question15->{'Row 1'}->keterangan)?$data->question15->{'Row 1'}->keterangan:'' ?></td>
                    </tr>
                </table>

                <p>Keterangan Skor</p>
                <p>< 4 : Tidak ada gawat napas</p>
                <p>4 - 7 : Gawat napas</p>
                <p>> 7 : Ancaman gagal napas(pemeriksaan AGD)</p><br>

                <h3>5. Penilaian Usia kehamilan (Diisi <= 24 jam setelah lahir)</h3>
               
            
                    <div style="position:absolute;bottom:90;right:35">
                        <div style="position:absolute;bottom:0%;right:0%;">
                            <?php
                            if(isset($data->penilaian_usia)){
                            ?>
                                <img src=" <?= $data->penilaian_usia ?>"  alt="img" height="400px" width="750px">
                            <?php } ?>
                        </div>
                            <img src="<?= base_url('assets/images/cat_medis_neonatus.PNG') ?>" height="400px" width="700px" alt="">

                    </div>
                   
               
               
          
            </div>
           
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 4</p>    
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

            <center><h4>CATATAN MEDIS AWAL NEONATUS</h4></center>

            <div style="font-size:12px;min-height:870px">
                <h3>6. Maturitas Fisik</h3>
                <table width="100%" border="1" id="data">
                        <tr>
                            <th width="10%">Tanda</th>
                            <th width="10%">-1</th>
                            <th width="10%">0</th>
                            <th width="10%">1</th>
                            <th width="10%">2</th>
                            <th width="10%">3</th>
                            <th width="10%">4</th>
                            <th width="10%">5</th>
                            <th width="10%">Score</th>
                        </tr>
                        <tr>
                            <td><h4>Kulit</h4></td>
                            <td>Lengket, rapuh, transparan</td>
                            <td>Merah seperti agar, gelatin transparan</td>
                            <td>Merah muda halus, vena vena tampak</td>
                            <td>Permukaan mengelupas dengan tanpa ruam vena jarang</td>
                            <td>Daerah pucat & pecah-pecah, vena panjang</td>
                            <td>Seperti kertas kulit pecah dalam tidak ada vena</td>
                            <td>Pecah-pecah, kasar, keriput</td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'1'})?$data->question16->{'Row 1'}->{'1'}:'' ?></td>
                        </tr>
                        <tr>
                            <td><h4>Lanugo</h4></td>
                            <td>Tidak Ada</td>
                            <td>Jarang</td>
                            <td>Banyak Sekali</td>
                            <td>Menipis</td>
                            <td>Menghilang</td>
                            <td>Umumnya Tidak Ada</td>
                            <td></td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'2'})?$data->question16->{'Row 1'}->{'2'}:'' ?></td>
                        </tr>
                        <tr>
                            <td><h4>Permukaan Plantar Kaki</h4></td>
                            <td>Tumit ibu jari kaki 40-50mmmm: -1 < 40mm: -2</td>
                            <td>>50mm tidak ada garis</td>
                            <td>Garis-garis merah tipis</td>
                            <td>Lipatan melintang hanya pada bagian anterior</td>
                            <td>Lipatan pada 2/3 anterior</td>
                            <td>Garis-garis pada seluruh telapak kaki</td>
                            <td></td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'3'})?$data->question16->{'Row 1'}->{'3'}:'' ?></td>
                        </tr>
                        <tr>
                            <td><h4>Payudara</h4></td>
                            <td>Tidak Tampak</td>
                            <td>Hamper tidak tampak</td>
                            <td>Areola data,tidak ada benjolan</td>
                            <td>Areola berbintil benjolan1-2mm</td>
                            <td>Areola imbul benjolan 3-4mm</td>
                            <td>Areola penuh berjalan 5-10mm</td>
                            <td></td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'4'})?$data->question16->{'Row 1'}->{'4'}:'' ?></td>
                        </tr>
                        <tr>
                            <td><h4>Mata/Daun Telinga</h4></td>
                            <td>Kelopak mata menyatu longgar:-1, ketat : -2</td>
                            <td>Kelopak mata terbuka,pinna datar, tetap terlipat</td>
                            <td>Pinna sedikit melengkung lunak, recoil lambat</td>
                            <td>Pinna memutar penuh,lunak,tetapi sudah recoil</td>
                            <td>Pinna keras berbentuk recoil segera</td>
                            <td>Kartilago tebal,telinga kaku</td>
                            <td></td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'7'})?$data->question16->{'Row 1'}->{'7'}:'' ?></td>
                        </tr>
                        <tr>
                            <td><h4>Kelamin Laki Laki</h4></td>
                            <td>Skorotum datar,halus</td>
                            <td>Skorotum kosong,rugae samar</td>
                            <td>Testis pada kanal bagian atas rugae jarang</td>
                            <td>Testis menuju ke bawah, rugae sedikit</td>
                            <td>Testis di skorotum,rugae jelas</td>
                            <td>Testis pendulous rugae dalam</td>
                            <td></td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'5'})?$data->question16->{'Row 1'}->{'5'}:'' ?></td>
                        </tr>
                        <tr>
                            <td><h4>Kelamin Perempuan</h4></td>
                            <td>Klirotis menonjol,labia mendatar</td>
                            <td>Klirotis menonjol, labia minora kecil</td>
                            <td>Kliroptis menonjol, labia minora membesar</td>
                            <td>Labia mayora & minora sama-sama menonjol</td>
                            <td>Labia mayora besar, labia miora kecil</td>
                            <td>Labia mayora menutupi klirotis & labia minora</td>
                            <td></td>
                            <td style="text-align:center"><?= isset($data->question16->{'Row 1'}->{'6'})?$data->question16->{'Row 1'}->{'6'}:'' ?></td>
                        </tr>
                        <tr>
                            <td width="82%" colspan="8"><h4>Score</h4></td>
                            <td width="16%" style="text-align:center"><?= isset($data->question16->{'Row 1'}->total_skor)?$data->question16->{'Row 1'}->total_skor:'' ?></td>
                        </tr>
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 3 dari 4</p>    
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

            <center><h4>CATATAN MEDIS AWAL NEONATUS</h4></center>

            <div style="font-size:12px;min-height:870px">
                <h3>7. Klasifikasi Bayi Menurut Lubchenco</h3>
                
                <div style="position:absolute;bottom:450;right:100">
                    <div style="position:absolute;bottom:0%;right:0%;">
                        <?php
                        if(isset($data->question17)){
                        ?>
                            <img src=" <?= $data->question17 ?>"  alt="img" height="450px" width="600px">
                        <?php } ?>
                    </div>
                    <img src="<?= base_url('assets/images/cat_medis_neonatus_2.PNG') ?>" height="450px" width="600px" alt="">

                </div>
              
                <br>
                <table width="100%" style="margin-top:430px">
                    <tr>
                        <td align="left" width="50%">BMK : Besar Masa Kehamilan</td>
                        <td align="right" width="50%">KB : Kurang Bulan</td>
                    </tr>
                    <tr>
                        <td align="left" width="50%">SMK : Sesuai Masa Kehamilan</td>
                        <td align="right" width="50%">CB : Cukup Bulan</td>
                    </tr>
                    <tr>
                        <td align="left" width="50%">KMK : Kecil Masa Kehamilan</td>
                        <td align="right" width="50%">LB : Lebih Bulan</td>
                    </tr>
                </table><br>

                <h4>8. Diagnosis Kerja</h4>
                <p><?= isset($data->diagnosis_kerja)?$data->diagnosis_kerja:'' ?></p>
                <h4>9. Rencana Tata Laksana Medis</h4>
                <p><?= isset($data->rencana_tata)?$data->rencana_tata:'' ?></p>

                <table width="100%">
                    <tr>
                        <td align="right"><b>Dokter Ruang Perintologi</b></td>
                    </tr>
                    <tr>
                        <td align="right">  <?php
                        $id =isset($neonatus->id_pemeriksa)?$neonatus->id_pemeriksa:null;
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
                        <?php } ?></td>
                    </tr>
                    <tr>
                        <td align="right"><b>(Nama Jelas & Ttd)</b></td>
                    </tr>
                </table>
            </div>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 4 dari 4</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    </body>
    </html>