<?php
$data = isset($catatan_ponek->formjson)?json_decode($catatan_ponek->formjson):'';
// var_dump($data);die()
?>
<style>
    .tanda-tangan {
        width: 100%;
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
    }
    .tanda-tangan div {
        text-align: center;
        width: 45%;
    }
    .tanda-tangan p {
        margin-bottom: 70px;
    }
    .sheet {
        padding: 20mm;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>
<body class="A4">
<div class="A4 sheet padding-fix-10mm">
<table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:17px;"></td>
                    <td width="70%" style="vertical-align:middle"><h3>RSUD AHMAD SYAFII MAARIF</h3></td>
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
                <h3>CATATAN KEPERAWATAN PONEK</h3>
            </center>
        </td>
        <td width="30%">
            <table border="0" width="100%" cellpadding="7px">
                <tr>
                    <td style="font-size:10px" width="20%">No.RM</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">Nama</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                </tr>
                <tr>
                    <td style="font-size:10px" width="20%">TglLahir</td>
                    <td style="font-size:10px" width="2%">:</td>
                    <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                        <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                    </td>
                </tr>
            </table>
        </td>
        <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td colspan="2">
                        <table border="0" width="100%">
                           <tr>
                           <p style="font-size: 13px;"><b>A. Identitas</b></p>
                               <td style="width: 5px; font-size: 13px;">Nama </td>
                               <td style="width: 110px; font-size: 13px;">: <?php echo $data_pasien->nama;?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Alamat </td>
                                <td style="width: 110px;  font-size: 13px;">:  <?php echo $data_pasien->alamat;?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">Tanggal Lahir </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= date('d-m-Y',strtotime($data_pasien->tgl_lahir)) ?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">No. MR </td>
                                <td style="width: 110px;  font-size: 13px;">: <?php echo $data_pasien->no_cm;?></td>
                            </tr>
                           </tr>
                           <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>B</b></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">1. Keluhan Pasien </td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question1)?$data->question1:'' ?></td>
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">2. Masalah Keperawatan / Kebidanan</td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question2)?$data->question2:'' ?></td>
                                
                            </tr>
                            <tr>
                                <td style="width: 5px;  font-size: 13px;">3. Diagnosa Keperawatan / Kebidanan</td>
                                <td style="width: 110px;  font-size: 13px;">: <?= isset($data->question3)?$data->question3:'' ?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>C. Asuhan keperawatan</b></td>
                            </tr>
                            
                        </table>
                        <table>
                        <tr>
                            <td style="vertical-align: top; font-size: 13px">
                                <ol start="1">
                                    <li>Mengatur Posisi Pasien</li>
                                    <li>Kompres hangat/dingin</li>
                                    <li>Pemberian Cairan parenteral</li>
                                    <li>Ganti perban luka bersih</li>
                                    <li>Ganti perban luka kotor</li>
                                    <li>Perawatan luka bersih</li>
                                    <li>Perawatan luka kotor</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item1->column1)?(in_array("item1", $data->question4->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item2->column1)?(in_array("item1", $data->question4->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item3->column1)?(in_array("item1", $data->question4->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item4->column1)?(in_array("item1", $data->question4->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item5->column1)?(in_array("item1", $data->question4->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item6->column1)?(in_array("item1", $data->question4->item6->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question4->item7->column1)?(in_array("item1", $data->question4->item7->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px">
                                <ol start="8">
                                    <li>Heacting</li>
                                    <li>Heating luka kotor</li>
                                    <li>Hitung beban cairan</li>
                                    <li>Memandikan pasien</li>
                                    <li>Oral hygine</li>
                                    <li>Vulva hygine</li>
                                    <li>Pemantauan monitor</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item1->column1)?(in_array("item1", $data->question5->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item2->column1)?(in_array("item1", $data->question5->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item3->column1)?(in_array("item1", $data->question5->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item4->column1)?(in_array("item1", $data->question5->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item5->column1)?(in_array("item1", $data->question5->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item6->column1)?(in_array("item1", $data->question5->item6->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question5->item7->column1)?(in_array("item1", $data->question5->item7->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <ol start="13">
                                    <li>Perawatan BBL</li>
                                    <li>Observasi pasca rujukan</li>
                                    <li>Edukasi</li>
                                    <li>Perawatan jenazah</li>
                                    <li>Pemberian O2</li>
                                   
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question6->item1->column1)?(in_array("item1", $data->question6->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question6->item2->column1)?(in_array("item1", $data->question6->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question6->item3->column1)?(in_array("item1", $data->question6->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question6->item4->column1)?(in_array("item1", $data->question6->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question6->item5->column1)?(in_array("item1", $data->question6->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                   
                                </table>`
                            </td>
                        </tr>
                    </table>
                    <table>
                            <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>D.  Tindakan pendelegasian</b></td>
                            </tr>
                        <tr>
                            <td style="vertical-align: top; font-size: 13px">
                                <ol start="1">
                                    <li>Injeksi</li>
                                    <li>IUFD</li>
                                    <li>PNGT</li>
                                    <li>Kateter</li>
                                    <li>Skin Test</li>
                                    <li>Obat suppos</li>
                                    <li>Obat oles</li>
                                    <li>Spuling mata</li>
                                    <li>Pemberian obat oral</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item1->column1)?(in_array("item1", $data->question7->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item2->column1)?(in_array("item1", $data->question7->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item3->column1)?(in_array("item1", $data->question7->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item4->column1)?(in_array("item1", $data->question7->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item5->column1)?(in_array("item1", $data->question7->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item6->column1)?(in_array("item1", $data->question7->item6->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item7->column1)?(in_array("item1", $data->question7->item7->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question7->item8->column1)?(in_array("item1", $data->question7->item8->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <ol start="10">
                                    <li>Heacting</li>
                                    <li>Pemasangan IUVD Umbilikal</li>
                                    <li>Nebulizer</li>
                                    <li>Suction</li>
                                    <li>NRM</li>
                                    <li>Pemberian obat infus pam</li>
                                    <li>Pemberian obat siring pam</li>
                                    <li>RJP</li>
                                    <li>Obat pervaginam</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item1->column1)?(in_array("item1", $data->question8->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item2->column1)?(in_array("item1", $data->question8->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item3->column1)?(in_array("item1", $data->question8->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item4->column1)?(in_array("item1", $data->question8->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item5->column1)?(in_array("item1", $data->question8->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item6->column1)?(in_array("item1", $data->question8->item6->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item7->column1)?(in_array("item1", $data->question8->item7->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item8->column1)?(in_array("item1", $data->question8->item8->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question8->item9->column1)?(in_array("item1", $data->question8->item9->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <ol start="19">
                                    <li>Tampon vagina</li>
                                    <li>Tampon hidung</li>
                                    <li>Transfusi</li>
                                   <li>Pengambilan sampel darah</li>
                                   <li>Pengambilan sampel cairan</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question9->item1->column1)?(in_array("item1", $data->question9->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question9->item2->column1)?(in_array("item1", $data->question9->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question9->item3->column1)?(in_array("item1", $data->question9->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question9->item4->column1)?(in_array("item1", $data->question9->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"  <?php echo isset($data->question9->item5->column1)?(in_array("item1", $data->question9->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                   
                                </table>`
                            </td>
                        </tr>
                    </table>
                    <table>
                            <tr>
                                <td colspan="2" style="font-size: 13px;"><br><b>E. Tindakan Kebidanan</b></td>
                            </tr>
                        <tr>
                            <td style="vertical-align: top; font-size: 13px">
                                <ol start="1">
                                    <li>Pemantauan kala I</li>
                                    <li>Persalinan Kala II</li>
                                    <li>Pertolongan Kala III</li>
                                    <li>Pemantauan Kala IV</li>
                                    <li>Vacum</li>
                                    <li>KBI/KBE</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question10->item1->column1)?(in_array("item1", $data->question10->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question10->item2->column1)?(in_array("item1", $data->question10->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question10->item3->column1)?(in_array("item1", $data->question10->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question10->item4->column1)?(in_array("item1", $data->question10->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question10->item5->column1)?(in_array("item1", $data->question10->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question10->item6->column1)?(in_array("item1", $data->question10->item6->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                   
                                </table>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <ol start="7">
                                    <li>Pemantauan drip induksi</li>
                                    <li>Heating vagina derajat I,II,III</li>
                                    <li>Heating porsio</li>
                                    <li>Ekplorasi vacum uterus</li>
                                    <li>Masase uterus</li>
                                    <li>Pemasangan IUD</li>
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question11->item1->column1)?(in_array("item1", $data->question11->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question11->item2->column1)?(in_array("item1", $data->question11->item2->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox"<?php echo isset($data->question11->item3->column1)?(in_array("item1", $data->question11->item3->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question11->item4->column1)?(in_array("item1", $data->question11->item4->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question11->item5->column1)?(in_array("item1", $data->question11->item5->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question11->item6->column1)?(in_array("item1", $data->question11->item6->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                
                                </table>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <ol start="13">
                                    <li>Pemasangan laminaria</li>
                                   
                                </ol>
                            </td>
                            <td style="vertical-align: top;  font-size: 13px"">
                                <table>
                                    <tr>
                                        <td><input type="checkbox" <?php echo isset($data->question12->item1->column1)?(in_array("item1", $data->question12->item1->column1) ? "checked" : "disabled"):""; ?>></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    </td>
                    
                </tr>
          
            
            
    </tr>
</table>
</div>

</body>
</html>
