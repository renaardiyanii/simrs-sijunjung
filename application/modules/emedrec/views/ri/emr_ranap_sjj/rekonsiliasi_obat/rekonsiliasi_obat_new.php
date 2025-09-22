<?php 
$data = isset($rekon_obat->formjson)?json_decode($rekon_obat->formjson):'';
$data_chunk = isset($data->jenis_obat)? array_chunk($data->jenis_obat,10):null;
$data_chunk1 = isset($data->question6)? array_chunk($data->question6,5):null;
?>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php
// Count total pages needed
$total_pages = max(
    $data_chunk ? count($data_chunk) : 0,
    $data_chunk1 ? count($data_chunk1) : 0
);

for($page_num = 0; $page_num < $total_pages; $page_num++):
    $current_chunk = $data_chunk[$page_num] ?? [];
    $current_chunk1 = $data_chunk1[$page_num] ?? [];
?>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
        <tr>
            <td width="30%">
                <table border="0" width="100%">
                    <tr>
                        <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="Hospital logo with green cross symbol on white background" height="70px" width="60px" style="padding-right:15px;"></td>
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
                    <h3>FORMULIR REKONSILIASI OBAT</h3>
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
                <td style="font-size:13px" colspan="2">(Diisi oleh petugas)</td>
                <td style="font-size:13px">Halaman <?= $page_num+1 ?> dari <?= $total_pages ?></td>
            </tr>
        
        </table>
        <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
        <tr>
                <td>Alergi : <input type="checkbox"  <?php echo isset($data->question1)? $data->question1 == "item2" ? "checked":'':'' ?>> Tidak  <input type="checkbox" <?php echo isset($data->question1)? $data->question1 == "item1" ? "checked":'':'' ?>> Ya, Nama obat : 1 <?= isset($data->question2->text1)?nl2br($data->question2->text1):'' ?> 2: <?= isset($data->question2->text2)?nl2br($data->question2->text2):'' ?> 3 :<?= isset($data->question2->text3)?nl2br($data->question2->text3):'' ?> </td>
        </tr>
       
        <tr>
                <td colspan="4">
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td rowspan="3">Tanggal</td>
                            <td rowspan="3">Nama Obat</td>
                            <td rowspan="3">Frekuensi <BR>/Dosis</td>
                            <td rowspan="3">Rute</td>
                            <td colspan="2"><center>Diisi DOkter</center></td>
                            <td colspan="8"><center>Diisi Apoteker</center></td>
                        </tr>
                      <tr>
                         <td colspan="2">Dilanjutkan saat <br>admisi</td>
                         <td  colspan="2">Dilanjutkan saat <br>transfer I</td>
                         <td  colspan="2">Dilanjutkan saat <br>transfer II</td>
                         <td  colspan="2">Dilanjutkan saat <br>transfer III</td>
                         <td  colspan="2">Dilanjutkan saat <br>Pulang</td>
                      </tr>
                      <tr>
                        <td>Ya</td>
                        <td>Tidak</td>
                        <td>Ya</td>
                        <td>Tidak</td>
                        <td>Ya</td>
                        <td>Tidak</td>
                        <td>Ya</td>
                        <td>Tidak</td>
                        <td>Ya</td>
                        <td>Tidak</td>
                      </tr>
                       <?php 
                        $i=1;
                        $jml_array = isset($current_chunk)?count($current_chunk):'';
                        for ($x = 0; $x < $jml_array; $x++) {
                        ?> 
                    <tr>
                        <td><?= isset($current_chunk[$x]->column1)?$current_chunk[$x]->column1:'' ?></td>
                        <td><?= isset($current_chunk[$x]->nama_obat)?$current_chunk[$x]->nama_obat:'' ?></td>
                        <td><?= isset($current_chunk[$x]->dosis)?$current_chunk[$x]->dosis:'' ?></td>
                        <td><?= isset($current_chunk[$x]->frek)?$current_chunk[$x]->frek:'' ?></td>
                        <td><input type="checkbox" name="dilanjutkan1[]" value="item1" <?= (in_array('item1', $current_chunk[$x]->dilanjutkan1 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan1[]" value="item2" <?= (in_array('item2', $current_chunk[$x]->dilanjutkan1 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan2[]" value="item1" <?= (in_array('item1', $current_chunk[$x]->dilanjutkan2 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan2[]" value="item2" <?= (in_array('item2', $current_chunk[$x]->dilanjutkan2 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan3[]" value="item1" <?= (in_array('item1', $current_chunk[$x]->dilanjutkan3 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan3[]" value="item2" <?= (in_array('item2', $current_chunk[$x]->dilanjutkan3 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan4[]" value="item1" <?= (in_array('item1', $current_chunk[$x]->dilanjutkan4 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan4[]" value="item2" <?= (in_array('item2', $current_chunk[$x]->dilanjutkan4 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan5[]" value="item1" <?= (in_array('item1', $current_chunk[$x]->dilanjutkan5 ?? []) ? 'checked' : '') ?>></td>
                        <td><input type="checkbox" name="dilanjutkan5[]" value="item2" <?= (in_array('item2', $current_chunk[$x]->dilanjutkan5 ?? []) ? 'checked' : '') ?>></td>
                    </tr>
                     <?php }
                            if($jml_array<=5){
                            $jml_kurang = 5 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                        <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php }} ?>
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td>Nama Dokter/DPJP</td>
                            <td>Tanda tangan</td>
                            <td>Tanggal & Jam</td>
                        </tr>
                        <tr>
                            <td><?= isset($data->question3)?$data->question3:''; ?></td>
                            <td><img src="<?= isset($data->question4)?$data->question4:''; ?>" alt="Doctor signature on white background" height="60px" width="60px"></td>
                            <td><?= isset($data->question5)?date('d-m-Y h:i',strtotime($data->question5)):'' ?></td>
                        </tr>
                    </table>
                    
                    <table border="1" width="100%" cellpadding="2">
                        <tr>
                            <td>Nama Apoteker</td>
                            <td>Tanda tangan Apoteker</td>
                            <td>Tanggal & Jam</td>
                        </tr>
                         <?php 
                        $jml_array1 = isset($current_chunk1)?count($current_chunk1):'';
                        for ($x = 0; $x < $jml_array1; $x++) {
                        ?> 
                        <tr>
                             <td><?= isset($current_chunk1[$x]->column2)?$current_chunk1[$x]->column2:'' ?></td>
                             <td><img src="<?= isset($current_chunk1[$x]->column1)?$current_chunk1[$x]->column1:'' ?>" alt="Pharmacist signature on white background" height="60px" width="60px"></td>
                             <td><?= isset($current_chunk1[$x]->column3)?$current_chunk1[$x]->column3:'' ?></td>
                        </tr>
                        <?php }
                            if($jml_array1<=5){
                            $jml_kurang = 5 - $jml_array1;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?> 
                         <tr>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                             <td>&nbsp;</td>
                        </tr>
                         <?php }} ?>
                         <tr>
                            <td width="35%">INTRUKSI : <br> <?= isset($data->question8)?nl2br($data->question8):''; ?></td>
                            <td colspan="2" width="65%">1. Dokter memutuskan semua obat yang akan diteruskan /dihentikan dan mencatatnya pada catatan perkembangan pasien terintegrasi dan membubuhkan tanda tangan <br>
                            2. Apoteker membandingkan dan menganalisis obat yang akan diteruskan dan membubuhkan tanda tangan</td>
                         </tr>
                     </table>

                </td>
                  
                </table>
                
                
        </tr>
        </table>
        <div>
            <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.16/RI
            </div>
        </div>
    </div>
</body>

<?php endfor; ?>

</html>
