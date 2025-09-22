<?php 
// var_dump($geriatri);die();
//   var_dump(isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'');
$data = (isset($keperawatan_geriatri->formjson)?json_decode($keperawatan_geriatri->formjson):'');
// $jsonf = json_decode($data->question885, TRUE);
// $colors = array($data->question35[0]->question36);

// foreach($data->question35[0]->question36 as $row) {
//     echo $row->Column1;
// }
// die();
// echo "<pre>";
// var_dump($colors);
// echo "</pre>";die();

// echo "<pre>";
// var_dump($data->question35[0]->question36);
// echo "</pre>";
// die();
// echo '<pre>';
// var_dump($data);
// echo '</pre>';
// die();
// ?>

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
    font-size: 12px;
    position: relative;


}

#data tr td {

    font-size: 12px;
    font-family: arial;

}

#data th {

    font-size: 12px;
    font-family: arial;

}

#noborder td {
    font-family: arial;
    font-size: 12px;
}
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP<br>
            (Dilengkapi 24 jam pasien masuk Ruang Rawat)
        </p>
        <div style="font-size:12px">
            <table border="0" width="100%" style="font-size:12px">
                <tr>
                    <td width="20%"><span class="">Tiba di ruangan</span></td>
                    <td width="3%"><span class="">:<span class=""></span></td>
                    <td width="25%">Tanggal
                        <?=':'.' '.(isset($data->question2->item1->column1)?date('d-m-Y',strtotime($data->question2->item1->column1)):'')?>
                    </td>
                    <td width="15%">
                        Jam<?=' '.':'.' '.(isset($data->question2->item1->column1)?date('H:i',strtotime($data->question2->item1->column1)):'')?>
                    </td>
                    <!-- <td width="20%"><span class=""><span class=""></span></span></td> -->
                </tr>
                <tr>
                    <td width="20%"><span class="">Pengkajian</span></td>
                    <td width="3%"><span class="">:<span class=""></span></td>
                    <td width="25%">Tanggal
                        <?=':'.' '.(isset($data->question2->item1->column2)?date('d-m-Y',strtotime($data->question2->item1->column2)):'')?>
                    </td>
                    <td width="15%">
                        Jam<?=' '.':'.' '.(isset($data->question2->item1->column2)?date('H:i',strtotime($data->question2->item1->column2)):'')?>
                    </td>
                    <!-- <td width="20%"><span class=""><span class=""></span></span></td> -->
                </tr>

                <!--  -->
                <tr>
                    <td width="15%"><span class=""></span></span></td>
                    <td width="3%"><span class=""><span class="text_isi"></span></span></td>
                    <td width="8%"><span class="">
                            <input type="checkbox" value="Auto Anamnesa"
                                <?php echo isset($data->question2->item1->column8[0])? $data->question2->item1->column8[0] == "item1" ? "checked":'':'' ?>>
                            <span>Auto Anamnesa</span>
                    </td>
                    <td width="20%"><span class="">
                            <?php $allo = isset($data->question2->item1->column8[0])?$data->question2->item1->column8[0]:'';?>
                            <input type="checkbox" value="Auto Anamnesa"
                                <?php echo isset($data->question2->item1->column8[0])? $data->question2->item1->column8[0] == "none" ? "checked":'':'' ?>>
                            <span>Allo Anamnesa :
                                <?php echo isset($data->question2->item1->{'column8-Comment'})?$data->question2->item1->{'column8-Comment'}:''?></span>
                    </td>
                    <td width="20%"><span class="">
                            <input type="checkbox" value="Auto Anamnesa"
                                <?php echo isset($data->question2->item1->column10[0])? $data->question2->item1->column10[0] == "Other" ? "checked":'':'' ?>>
                            <span>Hubungan :
                                <?=''.(isset($data->question2->item1->{'column10-Comment'})?$data->question2->item1->{'column10-Comment'}:'')?></span>
                    </td>
                </tr>

                <tr>

                    <td width="15%"><span class="">Cara Masuk</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="8%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column3[0])? $data->question2->item1->column3[0] == "item1" ? "checked":'':'' ?>>
                            <span>Jalan</span>
                    </td>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column3[0])? $data->question2->item1->column3[0] == "item2" ? "checked":'':'' ?>>
                            <span>Kursi Roda</span>
                    </td>

                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column3[0])? $data->question2->item1->column3[0] == "Other" ? "checked":'':'' ?>>
                            <span>Lain Lain
                                <?=''.(isset($data->question2->item1->{'column3-Comment'})?$data->question2->item1->{'column3-Comment'}:'')?>

                            </span>
                    </td>

                </tr>
                <tr>
                    <td width="15%"><span class="">Asal Masuk</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="8%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column9[0])? $data->question2->item1->column9[0] == "item1" ? "checked":'':'' ?>>
                            <span>IGD</span>
                    </td>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column9[0])? $data->question2->item1->column9[0] == "item2" ? "checked":'':'' ?>>
                            <span>Rawat Jalan</span>
                    </td>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column9[0])? $data->question2->item1->column9[0] == "item3" ? "checked":'':'' ?>>
                            <span>Rawat Inap</span>
                    </td>
                <tr>
                    <td width="15%"><span class="">Status</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="10%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column7[0])? $data->question2->item1->column7[0] == "item1" ? "checked":'':'' ?>>
                            <span>menikah</span>
                    </td>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column7[0])? $data->question2->item1->column7[0] == "item2" ? "checked":'':'' ?>>
                            <span>tidak menikah</span>
                    </td>

                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column7[0])? $data->question2->item1->column7[0] == "item3" ? "checked":'':'' ?>>
                            <span>janda</span>
                    </td>

                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column7[0])? $data->question2->item1->column7[0] == "item4" ? "checked":'':'' ?>>
                            <span>duda</span>
                    </td>
                <tr>
                    <td width="15%"><span class="">Agama</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="10%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column4[0])? $data->question2->item1->column4[0] == "item1" ? "checked":'':'' ?>>
                            <span>Islam</span>
                    </td>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column4[0])? $data->question2->item1->column4[0] == "item2" ? "checked":'':'' ?>>
                            <span>Protestan</span>
                    </td>

                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column4[0])? $data->question2->item1->column4[0] == "item3" ? "checked":'':'' ?>>
                            <span>Hindu</span>
                    </td>

                    <td width="20%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column4[0])? $data->question2->item1->column4[0] == "item4" ? "checked":'':'' ?>>
                            <span>Katolik</span>
                    </td>
                    <br>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column4[0])? $data->question2->item1->column4[0] == "item5" ? "checked":'':'' ?>>
                            <span>Budha</span>
                    </td>
                <tr>
                    <td width="15%"><span class="">Tingkat Pendidikan</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="10%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column5[0])? $data->question2->item1->column5[0] == "item1" ? "checked":'':'' ?>>
                            <span>SD</span>
                    </td>
                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column5[0])? $data->question2->item1->column5[0] == "item2" ? "checked":'':'' ?>>
                            <span>SMP</span>
                    </td>

                    <td width="5%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column5[0])? $data->question2->item1->column5[0] == "item3" ? "checked":'':'' ?>>
                            <span>SMA</span>
                    </td>

                    <td width="20%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column5[0])? $data->question2->item1->column5[0] == "item4" ? "checked":'':'' ?>>
                            <span>Perguruan Tinggi</span>
                    </td>

                    <td width="20%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column5[0])? $data->question2->item1->column5[0] == "Other" ? "checked":'':'' ?>>
                            <span>Lain
                                Lain :
                                <?=''.(isset($data->question2->item1->{'column5-Comment'})?$data->question2->item1->{'column5-Comment'}:'')?>
                            </span>

                </tr>


                </tr>


                <tr>
                    <td width="15%"><span class="">Sumber Pendapatan</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="10%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column6[0])? $data->question2->item1->column6[0] == "item1" ? "checked":'':'' ?>>
                            <span>PNS</span>
                    </td>
                    <td width="10%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column6[0])? $data->question2->item1->column6[0] == "item2" ? "checked":'':'' ?>>
                            <span>Wiraswata</span>
                    </td>
                    <td width="10%"><span class="">
                            <input type="checkbox"
                                <?php echo isset($data->question2->item1->column6[0])? $data->question2->item1->column6[0] == "Other" ? "checked":'':'' ?>>

                            <span>Lain Lain :
                                <?php echo isset($data->question2->item1->{'column6-Comment'})?$data->question2->item1->{'column6-Comment'}:''?></span>
                    </td>

                </tr>

                <td width="10%"><span class="">
                    </span>
                </td>
                </tr>
            </table>
            <p><b>1. Riwayat Kesehatan</b></p>

            <div>
                <span>
                    <p style="margin-left: 20px;">Alasan masuk rumah sakit :
                        <?=(isset($data->question3->item1->column1)?$data->question3->item1->column1:'')?></p>
                    <p style="margin-left: 20px;">
                        <?php $keluhan = implode(" ", $data->question3->item1->column2); ?>
                        - Keluhan yang di rasakan saat ini :<br>
                        <?php $dada = strpos($keluhan, "item1"); ?>
                        <input type="checkbox" value="dada"
                            <?php echo isset($dada)? $dada !== false ? "checked":'':'' ?>>
                        <span>nyeri dada</span>

                        <?php $sendi = strpos($keluhan, "item6"); ?>
                        <input type="checkbox" value="sendi"
                            <?php echo isset($sendi)? $sendi !== false ? "checked":'':'' ?>>
                        <span>nyeri sendi</span>

                        <?php $pusing = strpos($keluhan, "item2"); ?>
                        <input type="checkbox" value="pusing"
                            <?php echo isset($pusing)? $pusing !== false ? "checked":'':'' ?>>
                        <span>pusing</span>

                        <?php $gatal = strpos($keluhan, "item7"); ?>
                        <input type="checkbox" value="gatal"
                            <?php echo isset($gatal)? $gatal !== false ? "checked":'':'' ?>>
                        <span>gatal</span>

                        <?php $batuk = strpos($keluhan, "item3"); ?>
                        <input type="checkbox" value="batuk"
                            <?php echo isset($batuk)? $batuk !== false ? "checked":'':'' ?>>
                        <span>batuk</span>

                        <?php $diare = strpos($keluhan, "item8"); ?>
                        <input type="checkbox" value="diare"
                            <?php echo isset($diare)? $diare !== false ? "checked":'':'' ?>>
                        <span>diare</span>

                        <?php $panas = strpos($keluhan, "item4"); ?>
                        <input type="checkbox" value="panas"
                            <?php echo isset($panas)? $panas !== false ? "checked":'':'' ?>>
                        <span>panas</span>

                        <?php $sesak = strpos($keluhan, "item9"); ?>
                        <input type="checkbox" value="sesak"
                            <?php echo isset($sesak)? $sesak !== false ? "checked":'':'' ?>>
                        <span>sesak</span><br>

                        <?php $jantung = strpos($keluhan, "item5"); ?>
                        <input type="checkbox" value="jantung"
                            <?php echo isset($jantung)? $jantung !== false ? "checked":'':'' ?>>
                        <span>jantung berdebar</span>

                        <?php $mata = strpos($keluhan, "item10"); ?>
                        <input type="checkbox" value="mata"
                            <?php echo isset($mata)? $mata !== false ? "checked":'':'' ?>>
                        <span>mata kabur</span>
                    <p>
                </span>
            </div>

            <div>


                <p style="margin-left: 20px;">
                    - Apa keluhan yang di rasakan 3 bulan terakhir :<br>
                    <?php $keluhan3 = implode(" ", $data->question3->item1->column3);?>
                    <?php $dada3 = strpos($keluhan3, "item1"); ?>
                    <input type="checkbox" value="dada" <?php echo isset($dada3)? $dada3 !== false ? "checked":'':'' ?>>
                    <span>nyeri dada</span>

                    <?php $sendi3 = strpos($keluhan3, "item6"); ?>
                    <input type="checkbox" value="sendi"
                        <?php echo isset($sendi3)? $sendi3 !== false ? "checked":'':'' ?>>
                    <span>nyeri sendi</span>

                    <?php $pusing3 = strpos($keluhan3, "item2"); ?>
                    <input type="checkbox" value="pusing"
                        <?php echo isset($pusing3)? $pusing3 !== false ? "checked":'':'' ?>>
                    <span>pusing</span>

                    <?php $gatal3 = strpos($keluhan3, "item7"); ?>
                    <input type="checkbox" value="gatal"
                        <?php echo isset($gatal3)? $gatal3 !== false ? "checked":'':'' ?>>
                    <span>gatal</span>

                    <?php $batuk3 = strpos($keluhan3, "item3"); ?>
                    <input type="checkbox" value="batuk"
                        <?php echo isset($batuk3)? $batuk3 !== false ? "checked":'':'' ?>>
                    <span>batuk</span>

                    <?php $diare3 = strpos($keluhan3, "item8"); ?>
                    <input type="checkbox" value="diare"
                        <?php echo isset($diare3)? $diare3 !== false ? "checked":'':'' ?>>
                    <span>diare</span>

                    <?php $panas3 = strpos($keluhan3, "item4"); ?>
                    <input type="checkbox" value="panas"
                        <?php echo isset($panas3)? $panas3 !== false ? "checked":'':'' ?>>
                    <span>panas</span>

                    <?php $sesak3 = strpos($keluhan3, "item9"); ?>
                    <input type="checkbox" value="sesak"
                        <?php echo isset($sesak3)? $sesak3 !== false ? "checked":'':'' ?>>
                    <span>sesak</span>

                    <?php $jantung3 = strpos($keluhan3, "item5"); ?>
                    <input type="checkbox" value="jantung"
                        <?php echo isset($jantung3)? $jantung3 !== false ? "checked":'':'' ?>>
                    <span>jantung berdebar</span>

                    <?php $mata3 = strpos($keluhan3, "item10"); ?>
                    <input type="checkbox" value="mata" <?php echo isset($mata3)? $mata3 !== false ? "checked":'':'' ?>>
                    <span>mata kabur</span>
                <p>

            </div>

            <div>


                <p style="margin-left: 20px;">
                    - Penyakit saat ini :<br>
                    <?php $penyakit = implode(" ", $data->question3->item1->column4);?>
                    <?php $sesakp = strpos($penyakit, "item1"); ?>
                    <input type="checkbox" value="PPOM"
                        <?php echo isset($sesakp)? $sesakp !== false ? "checked":'':'' ?>>
                    <span>sesak nafas/PPOM</span>

                    <?php $sendip = strpos($penyakit, "item2"); ?>
                    <input type="checkbox" value="rematik"
                        <?php echo isset($sendip)? $sendip !== false ? "checked":'':'' ?>>
                    <span>Nyeri sendi/rematik</span>

                    <?php $diarek = strpos($penyakit, "item3"); ?>
                    <input type="checkbox" value="diare"
                        <?php echo isset($diarek)? $diarek !== false ? "checked":'':'' ?>>
                    <span>Diare</span>

                    <?php $kulitk = strpos($penyakit, "item4"); ?>
                    <input type="checkbox" value="kulit"
                        <?php echo isset($kulitk)? $kulitk !== false ? "checked":'':'' ?>>
                    <span>Penyakit Kulit</span>

                    <?php $jantungk = strpos($penyakit, "item5"); ?>
                    <input type="checkbox" value="jantung"
                        <?php echo isset($jantungk)? $jantungk !== false ? "checked":'':'' ?>>
                    <span>Penyakit Jantung</span>

                    <?php $matak = strpos($penyakit, "item6"); ?>
                    <input type="checkbox" value="mata" <?php echo isset($matak)? $matak !== false ? "checked":'':'' ?>>
                    <span>Mata</span>

                    <?php $dmk = strpos($penyakit, "item7"); ?>
                    <input type="checkbox" value="DM" <?php echo isset($dmk)? $dmk !== false ? "checked":'':'' ?>>
                    <span>DM</span>

                    <?php $hipertensik = strpos($penyakit, "item8"); ?>
                    <input type="checkbox" value="hipertensi"
                        <?php echo isset($hipertensik)? $hipertensik !== false ? "checked":'':'' ?>>
                    <span>hipertensi</span>

                    <?php $laink = strpos($penyakit, "Other"); ?>
                    <input type="checkbox" <?php echo isset($laink)? $laink !== false ? "checked":'':'' ?>>
                    <span>lain-lain</span>
                </p>


            </div>

            <div>


                <p style="margin-left: 20px;">
                    - Kejadian penyakit 3 bulan terakhir :<br>
                    <?php $penyakit3 = implode(" ", $data->question3->item1->column5);?>
                    <?php $sesakp3 = strpos($penyakit3, "item1"); ?>
                    <input type="checkbox" value="PPOM"
                        <?php echo isset($sesakp3)? $sesakp3 !== false ? "checked":'':'' ?>>
                    <span>sesak nafas/PPOM</span>

                    <?php $sendip3 = strpos($penyakit3, "item2"); ?>
                    <input type="checkbox" value="rematik"
                        <?php echo isset($sendip3)? $sendip3 !== false ? "checked":'':'' ?>>
                    <span>Nyeri sendi/rematik</span>

                    <?php $diarek3 = strpos($penyakit3, "item3"); ?>
                    <input type="checkbox" value="diare"
                        <?php echo isset($diarek3)? $diarek3 !== false ? "checked":'':'' ?>>
                    <span>Diare</span>

                    <?php $kulitk3 = strpos($penyakit3, "item4"); ?>
                    <input type="checkbox" value="kulit"
                        <?php echo isset($kulitk3)? $kulitk3 !== false ? "checked":'':'' ?>>
                    <span>Penyakit Kulit</span>

                    <?php $jantungk3 = strpos($penyakit3, "item5"); ?>
                    <input type="checkbox" value="jantung"
                        <?php echo isset($jantungk3)? $jantungk3 !== false ? "checked":'':'' ?>>
                    <span>Penyakit Jantung</span>

                    <?php $matak3 = strpos($penyakit3, "item6"); ?>
                    <input type="checkbox" value="mata"
                        <?php echo isset($matak3)? $matak3 !== false ? "checked":'':'' ?>>
                    <span>Mata</span>

                    <?php $dmk3 = strpos($penyakit3, "item7"); ?>
                    <input type="checkbox" value="DM" <?php echo isset($dmk3)? $dmk3 !== false ? "checked":'':'' ?>>
                    <span>DM</span>

                    <?php $hipertensik3 = strpos($penyakit3, "item8"); ?>
                    <input type="checkbox" value="hipertensi"
                        <?php echo isset($hipertensik3)? $hipertensik3 !== false ? "checked":'':'' ?>>
                    <span>hipertensi</span>

                    <?php $laink3 = strpos($penyakit3, "Other"); ?>
                    <input type="checkbox" <?php echo isset($laink3)? $laink3 !== false ? "checked":'':'' ?>>
                    <span>lain-lain</span>
                </p>


            </div>

            <div>

                <p style="margin-left: 20px;">
                    - Status Gizi :

                    <span>BB:<?=' '.(isset($data->question4->item1->Column1)?$data->question4->item1->Column1:'').' '.'Kg'?></span>
                    <span>IMT:<?=' '.(isset($data->question4->item1->Column2)?$data->question4->item1->Column2:'')?></span>
                </p>
                <p style="margin-left: 20px;">
                    <span>Makan
                        sehari:<?=' '.(isset($data->question4->item1->Column3)?$data->question4->item1->Column3:'').' '.'kali'?></span><br>
                    <span>porsi yang
                        habis:<?=' '.(isset($data->question4->item1->Column4)?$data->question4->item1->Column4:'').' '.'kali'?></span>
                </p>
                <?php $makan_sendiri = implode(" ", $data->question4->item1->Column5)?>
                <p style="margin-left: 20px;" class="">Makan sendiri</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="10%"><span class="">
                            <?php $ya_makan = strpos($makan_sendiri, "item1") ?>
                            <input type="checkbox"
                                <?php echo isset($ya_makan)? $ya_makan !== false ? "checked":'':'' ?>>
                            <span>ya</span>

                            <?php $tidak_makan = strpos($makan_sendiri, "item2") ?>
                            <input type="checkbox"
                                <?php echo isset($tidak_makan)? $tidak_makan !== false ? "checked":'':'' ?>>
                            <span>tidak</span>

                            <?php $bantuan_makan = strpos($makan_sendiri, "item3") ?>
                            <input type="checkbox"
                                <?php echo isset($bantuan_makan)? $bantuan_makan !== false ? "checked":'':'' ?>>
                            <span>Dengan bantuan</span>
                </p>

            </div>
            <p><b>2. Status Fisiologis</b></p>
            <?php $postur_tulang = implode(" ", $data->question5->item1->Column1);?>
            <div>
                <p style="margin-left: 20px;" class="">- Postur Tulang Belakang</span></span></td>
                    <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                    <td width="10%"><span class="">
                            <?php $tegap = strpos($postur_tulang, "item1");?>
                            <input type="checkbox" <?php echo isset($tegap)? $tegap !== false ? "checked":'':'' ?>>
                            <span>tegap</span>

                            <?php $bungkuk = strpos($postur_tulang, "item2");?>
                            <input type="checkbox" <?php echo isset($bungkuk)? $bungkuk !== false ? "checked":'':'' ?>>
                            <span>membungkuk</span>

                            <?php $kifosis = strpos($postur_tulang, "item3");?>
                            <input type="checkbox" <?php echo isset($kifosis)? $kifosis !== false ? "checked":'':'' ?>>
                            <span>kifosis</span>

                            <?php $liosis = strpos($postur_tulang, "item4");?>
                            <input type="checkbox" <?php echo isset($liosis)? $liosis !== false ? "checked":'':'' ?>>
                            <span>skoliosis</span>

                            <?php $lordosis = strpos($postur_tulang, "item5");?>
                            <input type="checkbox"
                                <?php echo isset($lordosis)? $lordosis !== false ? "checked":'':'' ?>>
                            <span>lordosis</span><br>
                            <p style="margin-left: 20px;" class="">- Tanda-tanda Vital
                    </td>
                <p style="margin-left: 20px;">
                    <span style="margin-left:20px">Tekanan
                        Darah:<?=' '.(isset($data->question6->item1->column1)?$data->question6->item1->column1:'').' '.'mmHG'?></span><br>
                    <span style="margin-left: 20px">Suhu
                        :<?=' '.(isset($data->question6->item1->column2)?$data->question6->item1->column2:'').' '.'&deg;C'?></span><br>
                    <span style="margin-left: 20px">Nadi
                        :<?=' '.(isset($data->question6->item1->column3)?$data->question6->item1->column3:'').' '.'x/menit'?></span><br>
                    <span style="margin-left: 20px">Pernafasan
                        :<?=' '.(isset($data->question6->item1->column4)?$data->question6->item1->column4:'').' '.'x/menit'?></span>

                </p>

            </div>
            <div>
                <p><b>3. Status Fisik</b></p>
                <?php $fisik = implode(" ", $data->question7->item1->column1); ?>
                <p style="margin-left: 20px;">
                    - Kepala :<br>

                    <?php $bersih = strpos($fisik, "item1");?>
                    <input type="checkbox" value="bersih"
                        <?php echo isset($bersih)? $bersih !== false ? "checked":'':'' ?>>
                    <span>Bersih</span>

                    <?php $kotor = strpos($fisik, "item2");?>
                    <input type="checkbox" value="kotor"
                        <?php echo isset($kotor)? $kotor !== false ? "checked":'':'' ?>>
                    <span>Kotor</span>

                    <?php $rontok = strpos($fisik, "item3");?>
                    <input type="checkbox" value="rambut_rontok"
                        <?php echo isset($rontok)? $rontok !== false ? "checked":'':'' ?>>
                    <span>Rambut rontok</span>

                    <?php $lain_fisik = strpos($fisik, "Other");?>
                    <input type="checkbox" value="lainnya"
                        <?php echo isset($lain_fisik)? $lain_fisik !== false ? "checked":'':'' ?>>
                    <span>lain-lainnya<?php //echo ' '.(isset($data->check_kepala)?$data->check_kepala:'')?></span>

                </p>
            </div>
        </div>
        <p style="text-align:left;font-size:12px">Hal 1 - 9</p>
        <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>
    </div>

    <!-- halaman 2 -->
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>
        </header>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP<br>
        </p>
        <div style="font-size:12px"><br>
            <div style="margin-left: px;">
                <div>

                    <p style="margin-left: 20px;">
                        - Mata :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>konyungtiva anemis</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>sclera ikterik</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>strabismus</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>penglihatan kabur</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "item5" ? "checked" : '' : '' ?>>
                        <span>riwayat katarak</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "item6" ? "checked" : '' : '' ?>>
                        <span>penggunaan kacamata</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column2[0]) ? $data->question7->item1->column2[0] == "Other" ? "checked" : '' : '' ?>>
                        <span>lain-lainnya :
                            <?=''.(isset($data->question7->item1->{'column2-Comment'})?$data->question7->item1->{'column2-Comment'}:'')?>
                        </span>

                    </p>
                </div>

                <div>

                    <p style="margin-left: 20px;">
                        - Hidung :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column3[0]) ? $data->question7->item1->column3[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>bersih</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column3[0]) ? $data->question7->item1->column3[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>kotor</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column3[0]) ? $data->question7->item1->column3[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>simetris</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column3[0]) ? $data->question7->item1->column3[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>peradangan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column3[0]) ? $data->question7->item1->column3[0] == "item5" ? "checked" : '' : '' ?>>
                        <span>penciuman terganggu</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column3[0]) ? $data->question7->item1->column3[0] == "Other" ? "checked" : '' : '' ?>>
                        <span>lain-lainnya :
                            <?=''.(isset($data->question7->item1->{'column3-Comment'})?$data->question7->item1->{'column3-Comment'}:'')?>
                        </span>
                    </p>
                </div>

                <div>

                    <p style="margin-left: 20px;">
                        - Mulut & Tenggorokan :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>bersih</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>kotor</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>mukosa kering</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>stomatitis</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item5" ? "checked" : '' : '' ?>>
                        <span>karies</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item6" ? "checked" : '' : '' ?>>
                        <span>gigi ompong</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item7" ? "checked" : '' : '' ?>>
                        <span>radang gusi</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item8" ? "checked" : '' : '' ?>>
                        <span>kesulitan menelan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "item9" ? "checked" : '' : '' ?>>
                        <span>kesulitan mengunyah</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column4[0]) ? $data->question7->item1->column4[0] == "Other" ? "checked" : '' : '' ?>>
                        <span>lain-lainnya :
                            <?=''.(isset($data->question7->item1->{'column4-Comment'})?$data->question7->item1->{'column4-Comment'}:'')?></span>
                    </p>
                </div>

                <div>

                    <p style="margin-left: 20px;">
                        - Telinga :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column5[0]) ? $data->question7->item1->column5[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>Bersih</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column5[0]) ? $data->question7->item1->column5[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>Kotor</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column5[0]) ? $data->question7->item1->column5[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>Peradangan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column5[0]) ? $data->question7->item1->column5[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>Pendengaran terganggu</span>
                        <input type="checkbox" <?php echo isset($data->question7->item1->column5[0]) ? $data->question7->item1->column5[0] == "Other
                            " ? "checked" : '' : '' ?>>
                        <span>lain-lainnya :
                            <?=''.(isset($data->question7->item1->{'column5-Comment'})?$data->question7->item1->{'column5-Comment'}:'')?></span>
                    </p>
                </div>

                <div>

                    <p style="margin-left: 20px;">
                        - Leher :
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column6[0]) ? $data->question7->item1->column6[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>pembesaran kelenjer
                            tyroid</span>
                    </p>
                </div>

                <div>

                    <p style="margin-left: 20px;">
                        - Dada :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>normal chest</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>bareel chest</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>pigeon chest</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>retraksi dada</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item5" ? "checked" : '' : '' ?>>
                        <span>wheezing</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item6" ? "checked" : '' : '' ?>>
                        <span>ronchi</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "item7" ? "checked" : '' : '' ?>>
                        <span>suara jantung tambahan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column7[0]) ? $data->question7->item1->column7[0] == "Other" ? "checked" : '' : '' ?>>
                        <span>iktus cordis
                            <?=''.(isset($data->question7->item1->{'column7-Comment'})?$data->question7->item1->{'column7-Comment'}:'')?>
                        </span>
                    </p>
                </div>

                <div>

                    <p style="margin-left: 20px;">
                        - Abdomen :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column8[0]) ? $data->question7->item1->column8[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>distensi</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column8[0]) ? $data->question7->item1->column8[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>flat</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column8[0]) ? $data->question7->item1->column8[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>nyeri tekan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column8[0]) ? $data->question7->item1->column8[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>kembung</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column8[0]) ? $data->question7->item1->column8[0] == "item5" ? "checked" : '' : '' ?>>
                        <span>massa</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column8[0]) ? $data->question7->item1->column8[0] == "Other" ? "checked" : '' : '' ?>>
                        <span>bisisng usus :
                            <?=''.(isset($data->question7->item1->{'column8-Comment'})?$data->question7->item1->{'column8-Comment'}:'')?>
                            Frekwensi (x/menit)

                        </span>
                    </p>
                </div>
                <div>

                    <p style=" margin-left: 20px;">
                        - Genetalia :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column9[0]) ? $data->question7->item1->column9[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>Bersih</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column9[0]) ? $data->question7->item1->column9[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>Kotor</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column9[0]) ? $data->question7->item1->column9[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>hernia</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column9[0]) ? $data->question7->item1->column9[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>haemoroid</span>

                    </p>
                </div>
                <div>

                    <p style="margin-left: 20px;">
                        - Ekstremitas :<br>
                        <input type="checkbox" value="kekuatan otot">
                        <span>Kekuatan otot</span>
                        <img src=" <?= base_url("assets/img/kekuatan_otot.png"); ?>" alt="img" height="25" width="50"
                            style="padding-right:5px;"><br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>haemoroid</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>rentang gerak terbatas</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>tremor</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>edema</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "item5" ? "checked" : '' : '' ?>>
                        <span>kursi roda</span>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "item6" ? "checked" : '' : '' ?>>
                        <span>tongkat</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question7->item1->column10[0]) ? $data->question7->item1->column10[0] == "Other" ? "checked" : '' : '' ?>>
                        <span>lain-lainnya :
                            <?=''.(isset($data->question7->item1->{'column10-Comment'})?$data->question7->item1->{'column10-Comment'}:'')?></span>
                    </p>
                </div>
                <div>
                    <p style="margin-left: 20px;">
                        - Integumen :<br>

                        <input type="checkbox"
                            <?php echo isset($data->question10[0]) ? $data->question10[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>Bersih</span>
                        <input type="checkbox"
                            <?php echo isset($data->question10[0]) ? $data->question10[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>Pucat</span>
                        <input type="checkbox"
                            <?php echo isset($data->question10[0]) ? $data->question10[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>Rash/kemerahan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question10[0]) ? $data->question10[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>lembab</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question10[1]) ? $data->question10[1] == "Other" ? "checked" : '' : '' ?>>
                        <span>lain-lainnya :
                            <?=''.(isset($data->question10[1]->{'Comment'})?$data->question10[1]->{'Comment'}:'')?>
                        </span>
                    </p>
                    <div>

                        <p style="margin-left: 20px;">
                            - Tes Koordinasi dan Keseimbangan :
                        <table id="data" border="1">
                            <tr>
                                <td style="width: 10%;text-align: center;">No</td>
                                <td style="width: 40%;text-align: center;">Aspek Penilaian</td>
                                <td style="width: 20%;text-align: center;">Keterangan</td>
                                <td style="width: 30%;text-align: center;">Nilai</td>
                            </tr>
                            <tr>
                                <th>1</th>
                                <th>Berdiri dengan postur normal</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'1'}) ? ($data->question11->item2->{'1'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>Berdiri dengan postur normal (mata tertutup)</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'2'}) ? ($data->question11->item2->{'2'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>3</th>
                                <th>Berdiri dengan satu kaki</th>
                                <th>Kanan :<br>Kiri :</th>
                                <th><?php echo isset($data->question11->item2->{'3'}) ? ($data->question11->item2->{'3'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>4</th>
                                <th>Berdiri, fleksi trunk, dan berdiri ke posisi netral</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'4'}) ? ($data->question11->item2->{'4'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>5</th>
                                <th>Berdiri, lateral dan fleksi trunk</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'5'}) ? ($data->question11->item2->{'5'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>6</th>
                                <th>Berjalan, tempatkan salah satu tumit di depan jari kaki yang lain</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'6'}) ? ($data->question11->item2->{'6'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>7</th>
                                <th>Berjalan sepanjang garis lurus</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'7'}) ? ($data->question11->item2->{'7'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>8</th>
                                <th>Berjalan mengikuti tanda gambar pada lantai</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'8'}) ? ($data->question11->item2->{'8'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>9</th>
                                <th>Berjalan mundur</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'9'}) ? ($data->question11->item2->{'9'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>10</th>
                                <th>Berjalan mengikuti lingkaran</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'10'}) ? ($data->question11->item2->{'10'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>11</th>
                                <th>Berjalan dengan tumit</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'11'}) ? ($data->question11->item2->{'11'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <th>12</th>
                                <th>Berjalan dengan ujung kaki</th>
                                <th></th>
                                <th><?php echo isset($data->question11->item2->{'12'}) ? ($data->question11->item2->{'12'}) : '' ?>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="3"><b>Jumlah</b></td>
                                <td style="width: 20%; text-align: center; font-weight: bold;">
                                    <?php echo isset($data->question11->item2->{'total'}) ? ($data->question11->item2->{'total'}) : ''  ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <p style="text-align:left;font-size:12px"> Hal 2 - 9</p>
                <p style="text-align:right;font-size:12px"> Rev.08.02.2021.RM-005c / RI</p>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- halaman 3 -->
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP<br>
            (Dilengkapi 24 jam pasien masuk Ruang Rawat)
        </p>
        <div style="font-size:12px"><br>
            <div style="margin-left:25px">
                <p> Keterangan :<br>
                    Refleks+ : normal<br>
                    Refleks- : menurun/meningkat
                </p>
                <table id="data" border="1" style="width: 60%;">
                    <b>Kriteria Penilaian</b> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    &nbsp;<b>Keterangan</b>
                    <tr>
                        <td style="width: 10%;">4</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Melakukan aktivitas dengan lengkap</td><br>
                        <td style="width: 10%;">42-54</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Melakukan aktivitas dengan lengkap</td>
                    </tr>
                    <tr>
                        <td style="width: 10%">3</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Sedikit bantuan (untuk keseimbangan)</td>
                        <td style="width: 10%;">28-41</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%">Sedikit bantuan (untuk keseimbangan)</td>
                    </tr>
                    <tr>
                        <td style="width: 10%">2</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Dengan bantuan sedang s/d maksimal</td>
                        <td style="width: 10%;">12-27</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Dengan bantuan sedang s/d maksimal</td>
                    </tr>
                    <tr>
                        <td style="width: 10%">1</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Tidak mampu melakukan aktivitas</td>
                        <td style="width: 10%;">
                            < 14</td>
                        <td style="width: 5%;text-align: center;">:</td>
                        <td style="width: 45%;">Tidak mampu melakukan aktivitas</td>
                    </tr>
                </table>
                <div>
                    <p><b>4. Frekwensi kunjungan keluarga </b></p>
                    <p style="margin-left:20px">
                        <input type="checkbox"
                            <?php echo isset($data->question13[0]) ? $data->question13[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>1 kali/bulan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question13[0]) ? $data->question13[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>2 kali/bulan</span>
                        <input type="checkbox"
                            <?php echo isset($data->question13[0]) ? $data->question13[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>tidak
                            pernah</span>
                    </p>
                </div>
                <p><b>5. Pengkajian Prilaku Terhadap Kesehatan </b></p>
                <div>
                    <p style="margin-left:25px">
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column1[0]) ? $data->question14->item1->Column1[0] == "" ? "checked" : '' : '' ?>>
                        <span>Merokok</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column1[0]) ? $data->question14->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>tidak</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column1[0]) ? $data->question14->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>ya</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column1[0]) ? $data->question14->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>Kebiasaan merokok > 3 batang sehari</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column1[0]) ? $data->question14->item1->Column1[0] == "item4" ? "checked" : '' : '' ?>>
                        <span>Kebiasaan merokok < 3 batang sehari</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "" ? "checked" : '' : '' ?>>
                                <span>minum alcohol</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                                <span>tidak</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                                <span>ya</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                                <span>sering</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "" ? "checked" : '' : '' ?>>
                                <span>minum
                                    kopi</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                                <span>tidak</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                                <span>ya</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                                <span>1 gelas/hari</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item4" ? "checked" : '' : '' ?>>
                                <span>2 gelas/hari</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item5" ? "checked" : '' : '' ?>>
                                <span>lebih 3 gelas/hari</span>
                    </p>
                </div>
                <div>
                    <p><b>6. Pengetahuan Tentang kesehatan Usia Lanjut</b></p>
                    <div>
                        <p style="margin-left:20px">
                            - Apakah bapak/ibu sudah mengerti tentang penyakit yang di derita :<br>
                            <input type="checkbox"
                                <?php echo isset($data->question15->item1->Column1[0]) ? $data->question15->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                            <span>sudah tau dan jelas</span>
                            <input type="checkbox"
                                <?php echo isset($data->question15->item1->Column1[0]) ? $data->question15->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                            <span>sudah tahu tapi kurang jelas</span>
                            <input type="checkbox"
                                <?php echo isset($data->question15->item1->Column1[0]) ? $data->question15->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                            <span>belum
                                tahu<?php echo isset($data->question15->item1->Column1[0]) ? $data->question15->item1->Column1[0] == "item4" ? "checked" : '' : '' ?></span>
                        </p>
                        <p style="margin-left:20px">
                            - Apakah bapak/ibu sudah mengerti tentang makanan yang sehat :<br>
                            <input type="checkbox"
                                <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                            <span>sudah tau dan jelas</span>
                            <input type="checkbox"
                                <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                            <span>sudah tahu tapi kurang jelas</span>
                            <input type="checkbox"
                                <?php echo isset($data->question14->item1->Column2[0]) ? $data->question14->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                            <span>belum
                                tahu</span>
                        </p>
                    </div>
                    <p style="margin-left:20px">
                        - Apakah bapak/ibu sudah mengerti tentang pencegahan penyakit - penyakit pada usia
                        lanjut :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>sudah tau dan jelas</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>sudah tahu tapi kurang jelas</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column3[0]) ? $data->question14->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>belum
                            tahu</span>
                    </p>
                    <p style="margin-left:20px">
                        - Apakah bapak/ibu sudah mengerti tentang latihan - latihan fisik pada usia lanjut :<br>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column4[0]) ? $data->question14->item1->Column4[0] == "item1" ? "checked" : '' : '' ?>>
                        <span>sudah tau dan jelas</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column4[0]) ? $data->question14->item1->Column4[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>sudah tahu tapi kurang jelas</span>
                        <input type="checkbox"
                            <?php echo isset($data->question14->item1->Column4[0]) ? $data->question14->item1->Column4[0] == "item3" ? "checked" : '' : '' ?>>
                        <span>belum
                            tahu</span>
                    </p>
                </div>
                <div>
                    <p><b>7. Pola Pemenuhan Kebutuhan Sehari-Hari</b></p>
                    <p>&emsp;&emsp;Pola Pemenuhan Kebutuhan Nutrisi :
                    <div>
                        <p style="margin-left:25px">
                            - Frekwensi makan :
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column1[0]) ? $data->question16->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                            <span>1 kali sehari</span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column1[0]) ? $data->question16->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                            <span>2 kali sehari</span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column1[0]) ? $data->question16->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                            <span>3 kali sehari </span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column1[0]) ? $data->question16->item1->Column1[0] == "item4" ? "checked" : '' : '' ?>>
                            <span>tidak
                                teratur</span>
                        </p>
                        <p style="margin-left:25px">
                            - Jumlah makanan yang di habiskan :<br>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column2[0]) ? $data->question16->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                            <span>1 porsi dihabiskan</span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column2[0]) ? $data->question16->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                            <span>1/2 yang di habiskan</span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column2[0]) ? $data->question16->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                            <span>
                                < 1/2 yang dihabiskan</span>
                        </p>
                        <p style="margin-left:25px">
                            - Makanan Tambahan :
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column3[0]) ? $data->question16->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                            <span>di habiskan</span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column3[0]) ? $data->question16->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                            <span>tidak di habiskan</span>
                            <input type="checkbox"
                                <?php echo isset($data->question16->item1->Column3[0]) ? $data->question16->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                            <span>kadang-kadang di
                                habiskan</span>
                        </p>
                    </div>
                </div>
                <br><br><br>
                <p style="text-align:left;font-size:12px">Hal 3 - 9</p>
                <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>
                </br></br></br>
            </div>
        </div>
    </div>
    </div>
    </div>

    <!-- halaman 4 -->

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>
        </header>
    
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP
        </p>
        <div style="font-size:12px"><br>


            <p><b>Pola Pemenuhan Cairan</b></p>

            <p style="margin-left:25px">
                - Frekwensi Minum :
                <input type="checkbox"
                    <?php echo isset($data->question17->item1->column1[0]) ? $data->question17->item1->column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>
                    < 3 gelas sehari</span>
                        <input type="checkbox"
                            <?php echo isset($data->question17->item1->column1[0]) ? $data->question17->item1->column1[0] == "item2" ? "checked" : '' : '' ?>>
                        <span>> 3 gelas
                            sehari</span>
            </p>
            <p style="margin-left:25px">
                Jika jawaban < 3 gelas sehari, alasan : <input type="checkbox"
                    <?php echo isset($data->question17->item1->column2[0]) ? $data->question17->item1->column2[0] == "item1" ? "checked" : '' : '' ?>>
                    <span>takut kencing malam hari</span>
                    <input type="checkbox"
                        <?php echo isset($data->question17->item1->column2[0]) ? $data->question17->item1->column2[0] == "item2" ? "checked" : '' : '' ?>>
                    <span>tidak haus</span>
                    <input type="checkbox"
                        <?php echo isset($data->question17->item1->column2[0]) ? $data->question17->item1->column2[0] == "item3" ? "checked" : '' : '' ?>>
                    <span>persediaan air minum terbatas</span>
                    <input type="checkbox"
                        <?php echo isset($data->question17->item1->column2[0]) ? $data->question17->item1->column2[0] == "item4" ? "checked" : '' : '' ?>>
                    <span>kebiasaan minum air
                        sedikit</span>
            </p>

            <p style="margin-left:25px">
                - Jenis minuman :
                <input type="checkbox"
                    <?php echo isset($data->question17->item1->Column3[0]) ? $data->question17->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>air putih</span>
                <input type="checkbox"
                    <?php echo isset($data->question17->item1->Column3[0]) ? $data->question17->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                <span>kopi</span>
                <input type="checkbox"
                    <?php echo isset($data->question17->item1->Column3[0]) ? $data->question17->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                <span>teh</span>
                <input type="checkbox"
                    <?php echo isset($data->question17->item1->Column3[0]) ? $data->question17->item1->Column3[0] == "item4" ? "checked" : '' : '' ?>>
                <span>susu</span>
                <input type="checkbox"
                    <?php echo isset($data->question17->item1->Column3[0]) ? $data->question17->item1->Column3[0] == "Other" ? "checked" : '' : '' ?>>
                <span>lain-lainnya :
                    <?=''.(isset($data->question17->item1->{'column3-Comment'})?$data->question17->item1->{'column3-Comment'}:'')?></span>
            </p>
            <p><b>Pola Kebiasaan Tidur</b></p>

            <p style="margin-left:25px">
                - Jumlah waktu tidur :
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column1[0]) ? $data->question18->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>4 jam</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column1[0]) ? $data->question18->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                <span>4-6 jam</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column1[0]) ? $data->question18->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                <span>6
                    jam</span>
            </p>


            <p style="margin-left:25px">
                - Gangguan tidur berupa :
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column2[0]) ? $data->question18->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                <span>Insomnia</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column2[0]) ? $data->question18->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                <span>sering terbangun</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column2[0]) ? $data->question18->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                <span>sulit mengawali</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column2[0]) ? $data->question18->item1->Column2[0] == "item4" ? "checked" : '' : '' ?>>
                <span>tidak ada
                    gangguan></span>
            </p>

            <p style="margin-left:25px">
                - Penggunaan waktu luang ketika tidak teratur :
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column3[0]) ? $data->question18->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>santai</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column3[0]) ? $data->question18->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                <span>diam saja</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column3[0]) ? $data->question18->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                <span>ketrampilan</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column3[0]) ? $data->question18->item1->Column3[0] == "item4" ? "checked" : '' : '' ?>>
                <span>mengaji</span>
                <input type="checkbox"
                    <?php echo isset($data->question18->item1->Column3[0]) ? $data->question18->item1->Column3[0] == "Other" ? "checked" : '' : '' ?>>
                <span>lain-lainnya :
                    <?=''.(isset($data->question18->item1->{'column3-Comment'})?$data->question18->item1->{'column18-Comment'}:'')?></span>
            </p>
            <p><b>Pola Eliminasi BAB</b></p>

            <p style="margin-left:25px">
                - Frekwensi BAB :
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column1[0]) ? $data->question21->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>1 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column1[0]) ? $data->question21->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                <span>2 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column1[0]) ? $data->question21->item1->Column1[0] == "Other" ? "checked" : '' : '' ?>>
                <span>lain-lainnya :
                    <?=''.(isset($data->question21->item1->{'column1-Comment'})?$data->question21->item1->{'column1-Comment'}:'')?></span>
            </p>
            <p style="margin-left:25px">
                - Konsistensi :
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column2[0]) ? $data->question21->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                <span>encer</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column2[0]) ? $data->question21->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                <span>lembek</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column2[0]) ? $data->question21->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                <span>keras</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column2[0]) ? $data->question21->item1->Column2[0] == "item4" ? "checked" : '' : '' ?>>
                <span>lain-lainnya :
                    <?=''.(isset($data->question21->item1->{'column2-Comment'})?$data->question21->item1->{'column2-Comment'}:'')?></span>
            </p>
            <p style="margin-left:25px">
                - Gangguan BAB :
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column3[0]) ? $data->question21->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>inkontinensia alvi</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column3[0]) ? $data->question21->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                <span>konstipasi</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column3[0]) ? $data->question21->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                <span>diare</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column3[0]) ? $data->question21->item1->Column3[0] == "item4" ? "checked" : '' : '' ?>>
                <span>tidak ada</span>
                <input type="checkbox"
                    <?php echo isset($data->question21->item1->Column3[0]) ? $data->question21->item1->Column3[0] == "item5" ? "checked" : '' : '' ?>>
                <span>lain-lainnya :
                    <?=''.(isset($data->question21->item1->{'column3-Comment'})?$data->question21->item1->{'column3-Comment'}:'')?></span>
            </p>
            <p><b>Pola BAK</b></p>

            <p style="margin-left:25px">
                - Frekwensi BAK :
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column1[0]) ? $data->question50->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>1-3 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column1[0]) ? $data->question50->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                <span>4-6 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column1[0]) ? $data->question50->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                <span>6 kali sehari</span>
            </p>

            <p style="margin-left:25px">
                - Warna urin :
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column2[0]) ? $data->question50->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                <span>kuning</span>
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column2[0]) ? $data->question50->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                <span>jernih</span>
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column2[0]) ? $data->question50->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                <span>putih jernih</span><br>
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column2[0]) ? $data->question50->item1->Column2[0] == "item4" ? "checked" : '' : '' ?>>
                <span>kuning keruh</span>
            </p>

            <p style="margin-left:25px">
                - Gangguan BAK :
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column3[0]) ? $data->question50->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>inkontinensia urine</span>
                <input type="checkbox"
                    <?php echo isset($data->question50->item1->Column3[0]) ? $data->question50->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>retensio urine</span>
            </p>
            <p><b>Pola Aktivitas</b></p>

            <p style="margin-left:25px">
                - Kegiatan Produktif lansia yang sering dilakukan :
                <input type="checkbox"
                    <?php echo isset($data->question23->item1->Column1[0]) ? $data->question23->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>membantu kegiatan dapur</span>
                <input type="checkbox"
                    <?php echo isset($data->question23->item1->Column1[0]) ? $data->question23->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                <span>pekerjaan rumah tangga</span>
                <input type="checkbox"
                    <?php echo isset($data->question23->item1->Column1[0]) ? $data->question23->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                <span>ketrampilan
                    tangan</span>
            </p>
            <p><b>Pola Pemenuhan Kebersihan Diri</b></p>

            <p style="margin-left:25px">
                - Mandi :
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column1[0]) ? $data->question22->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>1 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column1[0]) ? $data->question22->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                <span>2 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column1[0]) ? $data->question22->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                <span>3 kali sehari</span><br>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column1[0]) ? $data->question22->item1->Column1[0] == "item4" ? "checked" : '' : '' ?>>
                <span>
                    < 1 kali sehari</span>
            </p>
            <p style="margin-left:25px">
                - Memakai sabun :
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column2[0]) ? $data->question22->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                <span>ya</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column2[0]) ? $data->question22->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                <span>tidak</span>
            </p>
            <p style="margin-left:25px">
                - Sikat Gigi :
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column3[0]) ? $data->question22->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>1 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column3[0]) ? $data->question22->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                <span>pekerjaan rumah tangga</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column3[0]) ? $data->question22->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                <span>Tidak pernah,alasan</span>
            </p>
            <p style="margin-left:25px">
                - Menggunakan pasta gigi :
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column4[0]) ? $data->question22->item1->Column4[0] == "item1" ? "checked" : '' : '' ?>>
                <span>ya</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column4[0]) ? $data->question22->item1->Column4[0] == "item2" ? "checked" : '' : '' ?>>
                <span>tidak</span>
            </p>
            <p style="margin-left:25px">
                - Kebiasaan berganti pakaian :
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column5[0]) ? $data->question22->item1->Column5[0] == "item1" ? "checked" : '' : '' ?>>
                <span>1 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column5[0]) ? $data->question22->item1->Column5[0] == "item2" ? "checked" : '' : '' ?>>
                <span>> 1 kali sehari</span>
                <input type="checkbox"
                    <?php echo isset($data->question22->item1->Column5[0]) ? $data->question22->item1->Column5[0] == "Other" ? "checked" : '' : '' ?>>
                <span>Lain-lainnya :
                    <?=''.(isset($data->question22->item1->{'column5-Comment'})?$data->question22->item1->{'column5-Comment'}:'')?>
                </span>
            </p>
        </div><br><br><br>
        <p style="text-align:left;font-size:12px">Hal 4 - 9</p>
        <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>
    </div>


    </div>

    <!-- halaman 5 -->

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
  
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP<br>
            (Dilengkapi 24 jam pasien masuk Ruang Rawat)
        </p>

        <div style="font-size:12px"><br>


            <span> Asesmen Dekubitus ( Skala Norton)<br><br>
                <span> Berikan tanda (√) sesuai kondisi pasien Skor
                </span>
                <table id="data" border="1" style="font-size:12px">
                    <tr>
                        <th style="width: 5%;">Skor</th>
                        <th style="width: 15%;">Kondisi Umum</th>
                        <th style="width: 5%;">
                            (√)
                        </th>
                        <th style="width: 15%;">Kondisi Mental</th>
                        <th style="width: 5%;">
                            (√)
                        </th>
                        <th style="width: 15%;">Aktivitas</th>
                        <th style="width: 5%;">
                            (√)
                        </th>
                        <th style="width: 15%;">Mobilitas</th>
                        <th style="width: 5%;">
                            (√)
                        </th>
                        <th style="width: 15%;">Inkontinensia</th>
                        <th style="width: 5%;">
                            (√)
                        </th>
                        <th style="width: 15%;">Total Skor</th>
                    </tr>

                    <tr>
                        <td style="width: 5%;font-size:12px;text-align:center">4</td>
                        <td style="width: 15%;font-size:12px;text-align:center">Baik
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Waspada
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column2[0]) ? ($data->question24->item1->Column2[0] == "item1" ? "bg-checked" : "") : "" ?> ">
                            <?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Ambulasi
                            baik</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Penuh
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Kontinen
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center"></td>
                    </tr>

                    <tr>
                        <td style="width: 5%;font-size:12px;text-align:center">3</td>
                        <td style="width: 15%;font-size:12px;text-align:center">Cukup
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Apatis
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Perlu
                            bantuan</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Terbatas
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Kadang
                            inkontinen
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center"></td>
                    </tr>

                    <tr>
                        <td style="width: 5%;font-size:12px;text-align:center">2</td>
                        <td style="width: 15%;font-size:12px;text-align:center">Lemah
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Bingung
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Tak bisa
                            pindah bed
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">Sangat
                            terbatas</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center">
                            Inkontinen BAK</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 15%;font-size:12px;text-align:center"></td>
                    </tr>

                    <tr>
                        <td style="width: 5%;font-size:12px;text-align:center">1</td>
                        <td style="width: 10%;font-size:12px;text-align:center">Sangat
                            lemah</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column1[0]) ? $data->question24->item1->Column1[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 10%;font-size:12px;text-align:center">Tak
                            sadar</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column2[0]) ? $data->question24->item1->Column2[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 10%;font-size:12px;text-align:center">Tak
                            bergerak</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column3[0]) ? $data->question24->item1->Column3[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 10%;font-size:12px;text-align:center">
                            Imobilisasi</td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column4[0]) ? $data->question24->item1->Column4[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 10%;font-size:12px;text-align:center">
                            Inkonkontinen BAB &
                            BAK
                        </td>
                        <td style="width: 5%;font-size:12px;text-align:center"
                            class="<?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "bg-checked" : "" : "" ?> ">
                            <?= isset($data->question24->item1->Column5[0]) ? $data->question24->item1->Column5[0] == "item1" ? "√" : "" : "" ?>
                        </td>
                        <td style="width: 10%;font-size:12px;text-align:center"></td>
                    </tr>
                    <tr>
                        <td colspan="11" style="text-align: right;">Jumlah</td>
                        <td style="width: 15%;text-align:center">
                            <?= (isset($data->question24->item1->total) ? $data->question24->item1->total : '') ?>
                        </td>
                    </tr>

                </table><br>
                <input type="checkbox" style="margin-left: 70px;"
                    <?php echo isset($data->question25[0]) ? $data->question25[0] == "item1" ? "checked" : '' : '' ?>>
                <span>Resiko tinggi : > 14</span>

                <input type="checkbox" style="margin-left: 80px;"
                    <?php echo isset($data->question25[0]) ? $data->question25[0] == "item2" ? "checked" : '' : '' ?>>
                <span>Resiko sedang : 12 – 13</span>

                <input type="checkbox" style="margin-left: 70px;"
                    <?php echo isset($data->question25[0]) ? $data->question25[0] == "item3" ? "checked" : '' : '' ?>>
                <span>Resiko kecil : < 14</span>
                        <div>
                            <p><b>8. Asesmen risiko Jatuh</b></p>

                            <div style="margin-left:25px">
                                <span> <b>Asesmen Risiko Jatuh</b> (Skala Morse )</span><br>
                                <span>Lingkari skor sesuai dengan kondisi pasien dan jumlahkan</span><br>
                                <table id="data" border="1">
                                    <tr>
                                        <th style="width: 10%;">No</th>
                                        <th style="width: 35%;">Parameter</th>
                                        <th style="width: 35%;">Status</th>
                                        <th style="width: 20%;">Skor</th>
                                    </tr>
                                    <tr>
                                        <td rowspan="2" style="width: 10%;text-align: center;">1.</td>
                                        <td rowspan="2" style="width: 35%;">Riwayat jatuh </td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{'1'}) ? $data->question26->item1->{'1'} == "0" ? "bg-checked" : "" : "" ?>">

                                            Tidak </td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{'1'}) ? $data->question26->item1->{'1'} == "0" ? "bg-checked" : "" : "" ?>">

                                            0</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{'1'}) ? $data->question26->item1->{'1'} == "0" ? "bg-checked" : "" : "" ?>">
                                            Ya</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{'1'}) ? $data->question26->item1->{'1'} == "0" ? "bg-checked" : "" : "" ?>">
                                            15</td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2" style="width: 10%;text-align: center;">2.</td>
                                        <td rowspan="2" style="width: 35%;">Penyakit penyerta(diagnosis sekunder ≥
                                            2)</td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{2}) ? $data->question26->item1->{2} == "0" ? "bg-checked" : "" : "" ?> ">
                                            Tidak </td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{2}) ? $data->question26->item1->{2} == "0" ? "bg-checked" : "" : "" ?> ">
                                            0</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{2}) ? $data->question26->item1->{2} == "15" ? "bg-checked" : "" : "" ?> ">
                                            Ya</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{2}) ? $data->question26->item1->{2} == "15" ? "bg-checked" : "" : "" ?> ">
                                            15</td>
                                    </tr>

                                    <tr>
                                        <td rowspan="3" style="width: 10%;text-align: center;">3.</td>
                                        <td style="width: 35%;">
                                            Alat bantu jalan<br>
                                            a. Tidak ada/Bed rest / dibantu perawat
                                        </td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{3}) ? $data->question26->item1->{3} == "0" ? "bg-checked" : "" : "" ?> ">
                                            Tanpa alat bantu</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{3}) ? $data->question26->item1->{3} == "0" ? "bg-checked" : "" : "" ?> ">
                                            0</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;">
                                            b. Penopang
                                            tongkat/walker
                                        </td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{3}) ? $data->question26->item1->{3} == "15" ? "bg-checked" : "" : "" ?> ">
                                            Tidak dapat jalan</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{3}) ? $data->question26->item1->{3} == "15" ? "bg-checked" : "" : "" ?> ">
                                            15</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;">
                                            c. Berpegang dengan perabot
                                        </td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{3}) ? $data->question26->item1->{3} == "30" ? "bg-checked" : "" : "" ?> ">
                                            Kursi </td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{3}) ? $data->question26->item1->{3} == "30" ? "bg-checked" : "" : "" ?> ">
                                            30</td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2" style="width: 10%;text-align: center;">4.</td>
                                        <td rowspan="2" style="width: 35%;">Pemakaian terai heparin / intra vena / infus
                                        </td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{4}) ? $data->question26->item1->{4} == "0" ? "bg-checked" : "" : "" ?> ">
                                            Tidak </td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{4}) ? $data->question26->item1->{4} == "0" ? "bg-checked" : "" : "" ?> ">
                                            0</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{4}) ? $data->question26->item1->{4} == "20" ? "bg-checked" : "" : "" ?> ">
                                            Ya</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{4}) ? $data->question26->item1->{4} == "20" ? "bg-checked" : "" : "" ?> ">
                                            20</td>
                                    </tr>

                                    <tr>
                                        <td rowspan="3" style="width: 10%;text-align: center;">5.</td>
                                        <td rowspan="3" style="width: 35%;">Cara berjalan / berpindah </td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{5}) ? $data->question26->item1->{5} == "0" ? "bg-checked" : "" : "" ?> ">
                                            Normal /bed rest/immobilisasi</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{5}) ? $data->question26->item1->{5} == "0" ? "bg-checked" : "" : "" ?> ">
                                            0</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{5}) ? $data->question26->item1->{5} == "10" ? "bg-checked" : "" : "" ?> ">
                                            Lemah</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{5}) ? $data->question26->item1->{5} == "10" ? "bg-checked" : "" : "" ?> ">
                                            10</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{5}) ? $data->question26->item1->{5} == "20" ? "bg-checked" : "" : "" ?> ">
                                            Terganggu</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{5}) ? $data->question26->item1->{5} == "20" ? "bg-checked" : "" : "" ?> ">
                                            20</td>
                                    </tr>

                                    <tr>
                                        <td rowspan="2" style="width: 10%;text-align: center;">6.</td>
                                        <td rowspan="2" style="width: 35%;"> Status mental</td>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{6}) ? $data->question26->item1->{6} == "0" ? "bg-checked" : "" : "" ?> ">
                                            Orientasi sesuai kemampuan diri</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{6}) ? $data->question26->item1->{6} == "0" ? "bg-checked" : "" : "" ?> ">
                                            0</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%;"
                                            class="<?= isset($data->question26->item1->{6}) ? $data->question26->item1->{6} == "15" ? "bg-checked" : "" : "" ?> ">
                                            Lupa keterbatasan diri</td>
                                        <td style="width: 20%;text-align: center;"
                                            class="<?= isset($data->question26->item1->{6}) ? $data->question26->item1->{6} == "15" ? "bg-checked" : "" : "" ?> ">
                                            15</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><b>Total</b></td>
                                        <td style="width: 20%;">
                                            <?php
                                            $total = isset($data->question26->item1->total) ? $data->question26->item1->total : '';
                                            $keterangan = isset($data->question26->item1->keterangan) ? $data->question26->item1->keterangan : '';

                                            echo $total . " (" . $keterangan . ")";
                                            ?>
                                        </td>

                                    </tr>
                                </table>
                                <p>Keterangan :</p>
                                <table id="data" border="1" style="width: 55%;">
                                    <tr>
                                        <td style="width: 30%;">0 – 24</td>
                                        <td style="width: 10%;text-align: center;">:</td>
                                        <td style="width: 60%;">Tidak berisiko</td>
                                    </tr>
                                    <tr>
                                        <td style="">25-50</td>
                                        <td style="text-align: center;">:</td>
                                        <td style="">Risiko rendah</td>
                                    </tr>
                                    <tr>
                                        <td style="">≥ 51</td>
                                        <td style="text-align: center;">:</td>
                                        <td style="">Risiko tinggi</td>
                                    </tr>
                                </table>
                                <p>Keamanan : </p>
                                <input type="checkbox"
                                    <?php echo isset($data->question28[0]) ? $data->question28[0] == "item1" ? "checked" : '' : '' ?>>
                                <span>Tidak</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question28[0]) ? $data->question28[0] == "item2" ? "checked" : '' : '' ?>>
                                <span>Ya :</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question28[0]) ? $data->question28[0] == "item3" ? "checked" : '' : '' ?>>
                                <span>Pasang pengaman tempat tidur/ bed railis</span>
                                <input type="checkbox"
                                    <?php echo isset($data->question28[0]) ? $data->question28[0] == "item4" ? "checked" : '' : '' ?>>
                                <span>Penanda Segitiga Resiko Jatuh </span><br>
                </span>
        </div>







    </div><br><br><br><br><br><br><br><br>
    <p style="text-align:left;font-size:12px">Hal 5 - 9</p>
    <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>

    </div>

    </div>
    </div>

    <!-- halaman 6 -->


    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>

        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP
        </p>

        <div style="font-size:12px"><br>

            <p><b>9. RIWAYAT ALERGI</b></p>

            <div style="margin-left:25px">

                <p>Riwayat Alergi : </p>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column1[0]) ? $data->question29->item1->Column1[0] == "item1" ? "checked" : '' : '' ?>>
                <span>Tidak</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column1[0]) ? $data->question29->item1->Column1[0] == "item2" ? "checked" : '' : '' ?>>
                <span>Ya :</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column1[0]) ? $data->question29->item1->Column1[0] == "item3" ? "checked" : '' : '' ?>>
                <span>Pasang gelang warna merah </span>
                <p>a. Alergi Obat :</p>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column2[0]) ? $data->question29->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                <span>tidak</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column2[0]) ? $data->question29->item1->Column2[0] == "Other" ? "checked" : '' : '' ?>>
                <span>ya, jenis/nama obat
                    <?=''.(isset($data->question29->item1->{'column2-Comment'})?$data->question29->item1->{'column2-Comment'}:'')?>
                </span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column2[0]) ? $data->question29->item1->Column2[0] == "hasNone" ? "checked" : '' : '' ?>>
                <span>Reaksi utama yang timbul</span>
                <p>b. Lain-lain :</p>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>astma</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>>
                <span>eksim kulit</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                <span>sabun</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "item4" ? "checked" : '' : '' ?>>
                <span>debu</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "item5" ? "checked" : '' : '' ?>>
                <span>udara</span>
                <input type="checkbox"
                    <?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "Other" ? "checked" : '' : '' ?>>
                <span>makanan :
                    <?=''.(isset($data->question29->item1->{'column3-Comment'})?$data->question29->item1->{'column3-Comment'}:'')?>
                </span><br>
                <span>reaksi utama yang
                    timbul
                    :<?php echo isset($data->question29->item1->Column3[0]) ? $data->question29->item1->Column3[0] == "hasNone" ? "checked" : '' : '' ?></span>

            </div>
            <p><b>10. ASESMEN NYERI</b></p>

            <div style="margin-left:25px">
                <table border="0" width="100%">
                    <tr>
                        <td><img src=" <?= base_url("assets/img/asesmenawal2.PNG"); ?>" alt="img" height="50"
                                width="200" style="padding-center:5px;"></td><br>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr>
                        <td><img src=" <?= base_url("assets/img/asesmenawal1.PNG"); ?>" alt="img" height="50"
                                width="200" style="padding-center:5px;"></td>
                    </tr>
                </table>
                <p>Keterangan :</p>
                <?php
                $question30 = isset($data->question30) ? $data->question30 : null;

                if ($question30) {
                    $item1 = isset($question30->item1) ? $question30->item1 : null;

                    if ($item1) {
                        $total30 = isset($item1->total) ? $item1->total : '';
                        $ket30 = isset($item1->ket) ? $item1->ket : '';

                        echo "$total30 ($ket30)";
                    }
                }
                ?>

                <table id="data" border="1" style="width: 55%;">
                    <tr>
                        <td style="width: 30%;">0 </td>
                        <td style="width: 10%;text-align: center;">:</td>
                        <td style="width: 60%;">Tidak nyeri</td>
                    </tr>
                    <tr>
                        <td style="">1-3</td>
                        <td style="text-align: center;">:</td>
                        <td style="">Nyeri ringan</td>
                    </tr>
                    <tr>
                        <td style="">4-7</td>
                        <td style="text-align: center;">:</td>
                        <td style="">Nyeri sedang</td>
                    </tr>
                    <tr>
                        <td style="">8-10</td>
                        <td style="text-align: center;">:</td>
                        <td style="">Nyeri berat</td>
                    </tr>
                </table>

                </td>
                </tr>
                <p>Nyeri</p>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column1[0]) ? $data->question32->item1->Column1[0] == "Other" ? "checked" : '' : '' ?>>
                <span>Ya, lokasi
                    :<?=''.(isset($data->question32->item1->{'column1-Comment'})?$data->question32->item1->{'column1-Comment'}:'')?>.Lanjutkan
                    pada formulir pengkajian nyeri
                    komprehensif </span><br>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column1[1]) ? $data->question32->item1->Column1[1] == "item1" ? "checked" : '' : '' ?>>
                <span>tidak</span>
                <p>Nyeri mempengaruhi : </p>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column2[0]) ? $data->question32->item1->Column2[0] == "item1" ? "checked" : '' : '' ?>>
                <span>tidur</span>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column2[0]) ? $data->question32->item1->Column2[0] == "item2" ? "checked" : '' : '' ?>>
                <span>aktivitas
                    fisik</span>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column2[0]) ? $data->question32->item1->Column2[0] == "item3" ? "checked" : '' : '' ?>>
                <span>emosi</span>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column2[0]) ? $data->question32->item1->Column2[0] == "item4" ? "checked" : '' : '' ?>>
                <span>nafsu
                    makan</span>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column2[0]) ? $data->question32->item1->Column2[0] == "item5" ? "checked" : '' : '' ?>>
                <span>konsentrasi
                </span>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column2[0])? $data->question32->item1->Column2[0] == "Other" ? "checked":'':'' ?>>
                <span>Lain-lainnya :
                    <?=''.(isset($data->question32->item1->{'column2-Comment'})?$data->question32->item1->{'column2-Comment'}:'')?>

                </span>

                <p>Nyeri hilang : </p>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column3[0]) ? $data->question32->item1->Column3[0] == "item1" ? "checked" : '' : '' ?>>
                <span>minum
                    obat</span>
                <input type="checkbox"
                    <?php echo isset($data->question32->item1->Column3[0]) ? $data->question32->item1->Column3[0] == "item2" ? "checked" : '' : '' ?>></span>
                <span>istirahat
                    <input type="checkbox"
                        <?php echo isset($data->question32->item1->Column3[0]) ? $data->question32->item1->Column3[0] == "item3" ? "checked" : '' : '' ?>>
                    <span>mendengarkan
                        musik</span>
                    <input type="checkbox"
                        <?php echo isset($data->question32->item1->Column3[0]) ? $data->question32->item1->Column3[0] == "item4" ? "checked" : '' : '' ?>>
                    <span>berubah posisi
                        tidur</span>
                    <input type="checkbox"
                        <?php echo isset($data->question32->item1->Column3[0]) ? $data->question32->item1->Column3[0] == "Other" ? "checked" : '' : '' ?>>
                    <span>Lain-lainnya :
                        <?=''.(isset($data->question32->item1->{'column3-Comment'})?$data->question32->item1->{'column3-Comment'}:'')?>
                    </span>



            </div><br><br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:left;font-size:12px">Hal 6 - 9</p>
            <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>

        </div>


    </div>


    </div>


    <!--halaman 7 -->

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
     
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP
        </p>

        <div style="font-size:12px"><br>

            <p><b>11. KEBUTUHAN EDUKASI</b>
            <p>
            <p>Bahasa sehari-hari :</p>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column1[0]) ? $data->question33->item1->Column1[0]  == "item1" ? "checked" : '' : '' ?>>
            <span>indonesia, aktif/pasif</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column1[0]) ? $data->question33->item1->Column1[0] == "Other" ? "checked" : '' : '' ?>>
            <span>Daerah, jelaskan
                <?=''.(isset($data->question33->item1->{'column1-Comment'})?$data->question33->item1->{'column1-Comment'}:'')?></span><br>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column1[0]) ? $data->question33->item1->Column1[0]  == "item2" ? "checked" : '' : '' ?>>
            <span>inggris, aktif/pasif</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column1) ? $data->question33->item1->Column1[0] == "none" ? "checked" : '' : '' ?>>
            <span>Lain-lainnya, jelaskan :
                <?=''.(isset($data->question33->item1->{'column1-Comment'})?$data->question33->item1->{'column1-Comment'}:'')?></span>
            <p>Perlu penerjemah :</p>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column2[0]) ? $data->question33->item1->Column2[0]  == "item1" ? "checked" : '' : '' ?>>
            <span>tidak</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column2[0]) ? $data->question33->item1->Column2[0]  == "Other" ? "checked" : '' : '' ?>>
            <span>Ya, Bahasa :
                <?=''.(isset($data->question33->item1->{'column2-Comment'})?$data->question33->item1->{'column2-Comment'}:'')?>
            </span>
            <p>Hambatan belajar :</p>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column3[0]) ? $data->question33->item1->Column3[0]  == "item1" ? "checked" : '' : '' ?>>
            <span>Bahasa</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column3[0]) ? $data->question33->item1->Column3[0]  == "item2" ? "checked" : '' : '' ?>>
            <span>Cemas</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column3[0]) ? $data->question33->item1->Column3[0]  == "item3" ? "checked" : '' : '' ?>>
            <span>Menulis</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column3[0]) ? $data->question33->item1->Column3[0] == "Other" ? "checked" : '' : '' ?>>
            <span>Lain-lainnya :
                <?=''.(isset($data->question33->item1->{'column3-Comment'})?$data->question33->item1->{'column3-Comment'}:'')?></span>
            <p>Cara belajar yang di sukai :</p>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column4[0]) ? $data->question33->item1->Column4[0]  == "item1" ? "checked" : '' : '' ?>>
            <span>audio-visual/gambar</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column4[0]) ? $data->question33->item1->Column4[0]  == "item2" ? "checked" : '' : '' ?>>
            <span>diskusi</span>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column4[0]) ? $data->question33->item1->Column4[0] == "item3" ? "checked" : '' : '' ?>>
            <span>Menulis</span><br>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column4[0]) ? $data->question33->item1->Column4[0] == "Other" ? "checked" : '' : '' ?>>
            <span>Lain-lainnya,
                jelaskan :
                <?=''.(isset($data->question33->item1->{'column4-Comment'})?$data->question33->item1->{'column4-Comment'}:'')?>
            </span>
            <p>Potensi kebutuhan pembelajaran
                :<?php echo isset($data->question33->item1->Column5) ? ($data->question33->item1->Column5) : '' ?></p>
            <p>Adanya Ketersediaan Media:</p>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column6[0]) ? $data->question33->item1->Column6[0] == "item1" ? "checked" : '' : '' ?>>
            <span>Tidak</span><br>
            <input type="checkbox"
                <?php echo isset($data->question33->item1->Column6[0]) ? $data->question33->item1->Column6[0] == "Other" ? "checked" : '' : '' ?>>
            <span>Ya
                :
                <?=''.(isset($data->question33->item1->{'column6-Comment'})?$data->question33->item1->{'column6-Comment'}:'')?>
            </span>
            <p>Respon Kognitif :</p>
            <p>Pasien dan keluarga menginginkan informasi tentang :</p>
            <input type="checkbox"
                <?php echo isset($data->question34[0]) ? $data->question34[0]  == "item1" ? "checked" : '' : '' ?>>
            <span>Penyakit yang di derita</span>
            <input type="checkbox"
                <?php echo isset($data->question34[0]) ? $data->question34[0]  == "item2" ? "checked" : '' : '' ?>>
            <span>Tindakan pemeriksaan lanjut</span>
            <input type="checkbox"
                <?php echo isset($data->question34[0]) ? $data->question34[0]  == "item3" ? "checked" : '' : '' ?>>
            <span>Tindakan/pengobatan dan perawatan yang di berikan</span>
            <input type="checkbox"
                <?php echo isset($data->question34[0]) ? $data->question34[0]  == "item4" ? "checked" : '' : '' ?>>
            <span>Perubahan aktifitas sehari-hari</span>
            <input type="checkbox"
                <?php echo isset($data->question34[0]) ? $data->question34[0]  == "item5" ? "checked" : '' : '' ?>>
            <span>Perencanaan diet dan menu</span>
            <input type="checkbox"
                <?php echo isset($data->question34[0]) ? $data->question34[0]  == "item6" ? "checked" : '' : '' ?>>
            <span>Perawatan setelah dirumah</span>
            <p><b>12. RIWAYAT PENGGUNAAN OBAT</b></p>
            <div style="margin-left:25px">
                <p>
                    Riwayat Penggunaan Di rumah :
                    <input type="checkbox"
                        <?php echo isset($data->question35[0]->question37[0]) ? $data->question35[0]->question37[0]  == "item1" ? "checked" : '' : '' ?>>
                    <span>Tidak</span>
                    <input type="checkbox"
                        <?php echo isset($data->question35[0]->question37[0]) ? $data->question35[0]->question37[0]  == "item2" ? "checked" : '' : '' ?>>
                    <span>Ya</span>
                </p>

                <table id="data" border="1">
                    <tr>
                        <td style="width: 10%;text-align: center;">No</td>
                        <td style="width: 40%;text-align: center;">Nama Obat</td>
                        <td style="width: 20%;text-align: center;">Dosis</td>
                        <td style="width: 30%;text-align: center;">Cara Pemberian</td>
                    </tr>
                    <?php
                            // $no=1; 
                            // $jml_array = isset($data->question885)?count($data->question885):'';
                            // for ($x = 0; $x < $jml_array; $x++) {
                        $list_obat = isset($data->question35[0]->question36)?$data->question35[0]->question36:array();
                        $no_obat = 1;
                        foreach($list_obat as $obat) {
                        ?>
                    <tr>
                        <td><?php echo $no_obat++;?></td>
                        <td><?php echo $obat->Column1;?></td>
                        <td><?php echo $obat->Column2;?></td>
                        <td><?php echo $obat->Column3;?></td>
                    </tr>
                    <!-- <tr>
                        <td><?php //echo $no++ ?></td>
                        <td><?php //echo isset($data->question885[$x]->nama_obat2)?$data->question885[$x]->nama_obat2:'' ?>
                        </td>
                        <td><?php //echo isset($data->question885[$x]->dosis)?$data->question885[$x]->dosis:'' ?>
                        </td>
                        <td><?php //echo isset($data->question885[$x]->cara_pemberian)?$data->question885[$x]->cara_pemberian:'' ?>
                        </td>
                    </tr> -->
                    <?php } ?>
                    <!-- <tr>
                        <th>1</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>2</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>3</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>4</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>5</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>6</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr> -->
                </table>
            </div>
        </div><br><br><br><br><br><br><br><br><br><br><br>
        <p style="text-align:left;font-size:12px">Hal 7 - 9</p>
        <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>
    </div>
    </div>
    </div>

    <!--halaman 9 -->

    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_genap') ?>
        </header>
   
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP<br>
            (Dilengkapi 24 jam pasien masuk Ruang Rawat)
        </p>

        <div style="font-size:12px">
            <div style="margin-left:25px"><br><br>


                <p><b>13. DISCHARGE PLANNING</b></p>
                <div style="margin-left:25px">
                    <p>( Dilengkapi dalam 48 jam pertama pasien masuk ruang rawat )</p>
                    <table id="data" border="1">
                        <tr>
                            <th style="width: 30;">Kebutuhan Pelayanan</th>
                            <th style="width: 15;">Ya</th>
                            <th style="width: 15;">Tidak</th>
                            <th style="width: 40;">Keterangan</th>
                        </tr>
                        <tr>
                            <td style="width: 30;">Perlu Pelayanan Home Care</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item1->Column1) && $data->question38->item1->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item1->Column2) && $data->question38->item1->Column2 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item1->Column3) ? $data->question38->item1->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Perlu Pemasangan Implant</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item2->Column1) && $data->question38->item2->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item2->Column2) && $data->question38->item2->Column2 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item2->Column3) ? $data->question38->item2->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Penggunaan Alat Bantu</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item3->Column1) && $data->question38->item3->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item3->Column2) && $data->question38->item3->Column2 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item3->Column3) ? $data->question38->item3->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Telah dilakukan Pemesanan Alat</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item4->Column1) && $data->question38->item4->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item4->Column2) && $data->question38->item4->Column2 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item4->Column3) ? $data->question38->item4->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Dirujuk ke Komunitas Tertentu</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item5->Column1) && $data->question38->item5->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item5->Column2) && $data->question38->item5->Column2 === "1" ? '√' : '') ?>
                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item5->Column3) ? $data->question38->item5->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Dirujuk ke Tim Terapis</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item6->Column1) && $data->question38->item6->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item6->Column2) && $data->question38->item6->Column2 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item6->Column3) ? $data->question38->item6->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Dirujuk ke Ahli Gizi</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item7->Column1) && $data->question38->item7->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item7->Column2) && $data->question38->item7->Column2 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item7->Column3) ? $data->question38->item7->Column3 : '' ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 30;">Lain – Lain</td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item8->Column1) && $data->question38->item8->Column1 === "1" ? '√' : '') ?>

                            </td>
                            <td style="width: 15;text-align:center">
                                <?= (isset($data->question38->item8->Column2) && $data->question38->item8->Column2 === "1" ? '√' : '') ?>
                            </td>
                            <td style="width: 40;">
                                <?php echo isset($data->question38->item8->Column3) ? $data->question38->item8->Column3 : '' ?>
                            </td>
                        </tr>
                    </table>
                </div><br><br><br>
                <p><b>14. DAFTAR DIAGNOSA KEPERAWATAN</b></p>
                <div style="margin-left:25px">
                    <p>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item1" ? "checked" : '') : '' ?>>
                        <span>Bersihan jalan nafas tidak efektif</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item2" ? "checked" : '') : '' ?>>
                        <span>Nyeri</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item3" ? "checked" : '') : '' ?>>
                        <span>Hipertermi</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item4" ? "checked" : '') : '' ?>>
                        <span>Penurunan kapasitas adaptif intra Kranial</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item5" ? "checked" : '') : '' ?>>
                        <span>Risiko Penurunan curah jantung</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item6" ? "checked" : '') : '' ?>>
                        <span>Gangguan menelan</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item7" ? "checked" : '') : '' ?>>
                        <span>Gangguan mobilitas fisik</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item8" ? "checked" : '') : '' ?>>
                        <span>Defisit perawatan diri</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item9" ? "checked" : '') : '' ?>>
                        <span>Risiko ketidakstabilan gula darah</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item10" ? "checked" : '') : '' ?>>
                        <span>Risiko gangguan integritas kulit/jaringan </span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item11" ? "checked" : '') : '' ?>>
                        <span>Risiko perfusi cerebral tidak efektif</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item12" ? "checked" : '') : '' ?>>
                        <span>Demensia</span><br>
                        <input type="checkbox"
                            <?php echo isset($data->question43->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item13" ? "checked" : '') : '' ?>>
                        <span>Risiko
                            jatuh</span><br>
                    <p>___________________________________________________________________________________________</p>
                    <p>___________________________________________________________________________________________</p>
                    <p>___________________________________________________________________________________________</p>
                    <p>___________________________________________________________________________________________</p>


                    </p>
                </div>
            </div>
        </div><br><br><br><br><br><br><br><br><br>
        <p style="text-align:left;font-size:12px">Hal 8 - 9</p>
        <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>

    </div>

    </div>

    <!--halaman 9 -->

    < <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print') ?>
        </header>
    
        <p style="font-weight:bold; font-size: 13px; text-align: center;">
            ASESMEN KEPERAWATAN GERIATRI RAWAT INAP<br>
            (Dilengkapi 24 jam pasien masuk Ruang Rawat)
        </p><br><br>

        <div style="font-size:12px">
            <div style="margin-left:20px">
                <div style="font-size:12px">
                    <div style="margin-left:25px">
                        <p><b>15. INTERVENSI KEPERAWATAN</b></p>
                        <div style="margin-left:25px">
                            <p>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item1" ? "checked" : '') : '' ?>>
                                <span> Latihan batuk efektif</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item2" ? "checked" : '') : '' ?>>
                                <span>Manajemen jalan nafas</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item3" ? "checked" : '') : '' ?>>
                                <span>Pengaturan posisi</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item4" ? "checked" : '') : '' ?>>
                                <span>Pengisapan jalan nafas</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item5" ? "checked" : '') : '' ?>>
                                <span>Perawatan perkembangan</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item6" ? "checked" : '') : '' ?>>
                                <span>Manajemen hipertermia</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item7" ? "checked" : '') : '' ?>>
                                <span>Manajemen kejang</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item8" ? "checked" : '') : '' ?>>
                                <span>Manajemen nyeri</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item9" ? "checked" : '') : '' ?>>
                                <span>Manajemen diare</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item10" ? "checked" : '') : '' ?>>
                                <span>Manajemen cairan</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item11" ? "checked" : '') : '' ?>>
                                <span>Dukungan perawatan diri</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item12" ? "checked" : '') : '' ?>>
                                <span>Pencegahan jatuh</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item13" ? "checked" : '') : '' ?>>
                                <span>Manajemen nutrisi</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item14" ? "checked" : '') : '' ?>>
                                <span>Terapi relaksasi</span><br>

                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item15" ? "checked" : '') : '' ?>>
                                <span>Manajemen peningkatan tekanan intrakranial</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item16" ? "checked" : '') : '' ?>>
                                <span>Pencegahan infeksi</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item17" ? "checked" : '') : '' ?>>
                                <span>Pencegahan aspirasi</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item18" ? "checked" : '') : '' ?>>
                                <span>Perawatan integritas kulit</span><br>
                                <input type="checkbox"
                                    <?php echo isset($data->question42->item1->Column1[0]) ? ($data->question43->item1->Column1[0] == "item19" ? "checked" : '') : '' ?>>
                                <span>Kolaborasi dalam pemberian obat</span><br>
                                <input type="checkbox">
                                _____________________________________________________________________________________

                                <input type="checkbox">
                                _____________________________________________________________________________________
                                <input type="checkbox">
                                _____________________________________________________________________________________

                                <input type="checkbox">
                                _____________________________________________________________________________________
                                <input type="checkbox">
                                _____________________________________________________________________________________

                                <input type="checkbox">
                                _____________________________________________________________________________________

                                <span></span><br>
                            </p>
                            <!-- <div style="min-height:50px">
                            <p><?php //echo isset($data->question1110) ? $data->question1110 : '' ?></p>
                            </div> -->
                        </div>
                        <div style="display: inline; position: relative;">
                            <div style="float: left;">
                                <p>
                                <div style="text-align: center;">
                                    <span>Tanggal selesai pengkajian
                                        :<br><?= isset($data->question44) ? date('d-m-Y', strtotime($data->question44)) : ''; ?>
                                        Jam
                                        :<?= isset($data->question44) ? date('H:i', strtotime($data->question44)) : ''; ?>
                                        Wib</span><br>
                                </div>

                                </p>
                                <p style="text-align: center;">Perawat yang mengkaji I</p>

                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <img width="120px" height="130px" src="<?= $data->question45 ?>" alt="Image"><br>
                                </div>
                                <span style="text-align:center; display: block;">(
                                    <?= isset($data->question46) ? $data->question46 : '' ?> )</span>

                                <p style="text-align: center;">Nama jelas & tanda tangan</p>
                            </div>
                            <div style="float: right;">
                                <p>
                                <div style="text-align: center;">
                                    <span>Tanggal selesai pengkajian
                                        :<br><?= isset($data->question47) ? date('d-m-Y', strtotime($data->question47)) : ''; ?>
                                        Jam
                                        :<?= isset($data->question47) ? date('H:i', strtotime($data->question47)) : ''; ?>
                                        Wib</span><br>
                                </div>

                                </p>
                                <p style="text-align: center;">Perawat yang mengkaji II</p>

                                <div style="display: flex; justify-content: center; align-items: center;">
                                    <img width="120px" height="130px" src="<?= $data->question48 ?>" alt="Image"><br>
                                </div>
                                <span style="text-align:center; display: block;">(
                                    <?= isset($data->question49) ? $data->question49: '' ?> )</span>

                                <p style="text-align: center;">Nama jelas & tanda tangan</p>
                            </div>
                        </div>
                        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                        <p style="text-align:left;font-size:12px">Hal 9 - 9</p>
                        <p style="text-align:right;font-size:12px">Rev.08.02.2021.RM-005c / RI</p>
                    </div>
                </div>
            </div>
</body>

</html>