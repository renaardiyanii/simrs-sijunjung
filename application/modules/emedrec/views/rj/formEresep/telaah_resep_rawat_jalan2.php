<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
<?php
// var_dump($data_pasien_irj);

$data_formjson = isset($telaah_obat[0]->formjson) ? json_decode($telaah_obat[0]->formjson) : '';
//  var_dump($data_formjson);
// var_dump($resep_pasien);
// var_dump($data_pasien);
// var_dump($pemeriksaan_fisik);
$result = array_chunk($resep_pasien, 8);
// var_dump($result);
// die();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>

</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <?php
    for ($i = 0; $i < count($result); $i++) { ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>
            <div style="position: relative;display: inline;width: 100%;">
                <div style="width: 65%;float: left;">
                    <span class="text_isi"><?php echo isset($resep_pasien[0]->bed) ? $resep_pasien[0]->bed : ''; ?></span><br>
                    <span class="text_isi">Jaminan :<?php echo isset($resep_pasien[0]->nmkontraktor) ? $resep_pasien[0]->nmkontraktor : (isset($resep_pasien[0]->cara_bayar) ? $resep_pasien[0]->cara_bayar : ''); ?></span><br>
                    <span class="text_isi">No SEP :<?php echo isset($resep_pasien[0]->no_sep) ? $resep_pasien[0]->no_sep : '-'; ?></span><br>
                    <!-- <span class="text_isi">Iter Obat :<?php echo isset($resep_pasien[0]->iter_obat) ? $resep_pasien[0]->iter_obat == 0 ? '-' : $resep_pasien[0]->iter_obat .' '.'Kali' : '-'; ?></span> -->
                    <?php
                    if ($resep_pasien) {
                    ?>
                        <table style="width: 100%;" cellpadding="5px">
                            <?php 
                            $b=1;
                            $total = 0;
                            foreach ($result[$i] as $data) { 
                            $total += $data->vtot;    
                            ?>
                                <tr>
                                    <td width="40%">
                                        
                                        <table style="width:100%;" border="1">
                                            <tr>
                                                <td width="5%" rowspan="3"><span style="font-weight:bold"><center><?= $b++ ?></center></span></td>
                                                <td colspan = "2">
                                                    <span style="font-size:15;font-weight:bold"><?php
                                                                            echo ($data->nama_obat) ? $data->nama_obat : '-';
                                                                            if ($data->racikan == '1') {
                                                                                foreach ($data_tindakan_racik as $row1) {
                                                                                    if ($data->id_resep_pasien == $row1->id_resep_pasien) {
                                                                                        echo '<br><span style="font-size:12px">- ' . $row1->nm_obat . ' Dosis ' . $row1->dosis . ', Satuan ' . $row1->satuan . ' (' . $row1->qty . ')</span>';
                                                                                    }
                                                                                }
                                                                            }
                                                                            ?></span>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                    <span>Jumlah : <?= ($data->qty) ? $data->qty : '0'; ?></span>
                                                </tdwidth="50%">
                                                <td> <?= ($data->racikan) ? 'racikan' : 'Non-Racikan'; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><span><center>Aturan Pakai</span><br>
                                                <?php
                                                    if($data->kali_harian != '' && $data->cara_pakai != ''){ ?>
                                                        <span class="text_body"><?php echo $data->kali_harian.', '.$data->qtx.' ,'.$data->cara_pakai; ?></span>
                                                        
                                                    <?php }else{ ?>
                                                        <span class="text_body"><?php echo $data->signa; ?></span>
                                                    <?php }
                                                    
                                                    ?><br>
                                                    <?php 
                                                        echo $data->ket_pakai_p=='1'?'/Pagi ':'';
                                                        echo $data->ket_pakai_s=='1'?'/Siang ':'';
                                                        echo $data->ket_pakai_m=='1'?'/Malam ':'';
                                                        ?>
                                                        </center>
                                                </td>
                                                   
                                            </tr>
                                        </table>
                                    </td>
                                
                                </tr>
                            <?php } ?>
                        </table>
                        <table border="1" cellpadding="5px" align="right" style="margin-right:5px">
                            <tr>
                                <td>Total Harga : </td>
                                <td>Rp. <?= number_format($total, '2', ',', '.') ?></td>
                            </tr>
                        </table>
                    <?php
                    }
                    ?>
                      

                    <table border="0" width="100%">
                        <tr>
                            <td></td>
                            <td width="60%"><br>
                                <label><b><span class="text_body"> Dokter Penanggung Jawab Pasien</b></span></label><br>
                                <?php
                                if (isset($resep_pasien[0]->ttd)) {
                                ?>
                                    <label><span class="text_body"> <img width="120px" src="<?= $resep_pasien[0]->ttd; ?>" alt=""></span></label><br>
                                    <label><b><span class="text_body"> <?= $resep_pasien[0]->nm_dokter; ?><b></span></label>
                                    <label><b><span class="text_body"> No.Sip<?= $resep_pasien[0]->nm_dokter; ?><b></span></label>
                                <?php } else { ?>
                                    <br><br>
                                <?php } ?>

                            </td>
                        </tr>
                    </table>
                </div><br>
                <div style="width: 35%;float: left;">
                    <table border="0" width="100%">
                        <tr>
                            <td>
                                <table style="width:100%;border: 1px solid black;" border="0" cellpadding="2px">
                                    <tr>
                                        <td>Tanggal : <span style="float:right"><?= ($resep_pasien) ? date('d-m-Y', strtotime($resep_pasien[0]->tgl_kunjungan)) : '-'; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text_body">Dokter : <?= ($resep_pasien) ? isset($resep_pasien[0]->nm_dokter) ? $resep_pasien[0]->nm_dokter : '-' : '-'; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="text_body">SIP : <?= isset($sip_dokter) ? $sip_dokter->nipeg : ''; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="text_body">Riwayat Alergi Obat : <?= ($pemeriksaan_fisik) ? $pemeriksaan_fisik[0]->reaksi_alergi ? $pemeriksaan_fisik[0]->reaksi_alergi : 'Tidak Ada' : '-'; ?></span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <hr color="black">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table border="1" width="100%">
                                    <tr>
                                        <td>
                                            <table class="side_table" border="0" width="100%">
                                                <thead>
                                                    <tr class="border_bottom">
                                                        <td width="60%"><span class="text_isi">Telaah Resep</span></td>
                                                        <td width="20%"><span class="text_isi">Ya</span></td>
                                                        <td width="20%"><span class="text_isi">Tidak</span></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Kejelasan Penulisan Resep</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'1'}) ? ($data_formjson->telaah_resep->{'1'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'1'}) ? ($data_formjson->telaah_resep->{'1'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>

                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat Pasien</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'2'}) ? ($data_formjson->telaah_resep->{'2'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'2'}) ? ($data_formjson->telaah_resep->{'2'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat Obat</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'3'}) ? ($data_formjson->telaah_resep->{'3'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'3'}) ? ($data_formjson->telaah_resep->{'3'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat Dosis & Kekuatan</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'4'}) ? ($data_formjson->telaah_resep->{'4'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'4'}) ? ($data_formjson->telaah_resep->{'4'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat Cara Pemberian</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'5'}) ? ($data_formjson->telaah_resep->{'5'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'5'}) ? ($data_formjson->telaah_resep->{'5'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tidak ada duplikasi</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'6'}) ? ($data_formjson->telaah_resep->{'6'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'6'}) ? ($data_formjson->telaah_resep->{'6'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tidak ada interaksi obat</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'7'}) ? ($data_formjson->telaah_resep->{'7'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'7'}) ? ($data_formjson->telaah_resep->{'7'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tidak ada alergi</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'8'}) ? ($data_formjson->telaah_resep->{'8'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'8'}) ? ($data_formjson->telaah_resep->{'8'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Kontra indikasi</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->telaah_resep->{'9'}) ? ($data_formjson->telaah_resep->{'9'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->telaah_resep->{'9'}) ? ($data_formjson->telaah_resep->{'9'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="side_table" border="1" width="100%">
                                    <tr>
                                        <td width="50%">
                                            <span class="text_body"> <center>Apoteker/Ass. Apt</center></span>
                                        </td>
                                        <td>
                                            <span class="text_body"><center> Disetujui Dokter </center></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <?php
                                        if (isset($telaah_obat[0]->ttd_apoteker)) {
                                        ?>
                                            <td><img width="120px" src="<?= $telaah_obat[0]->ttd_apoteker; ?>" alt="">
                                                <?= ($telaah_obat) ? $telaah_obat[0]->nm_apoteker ? $telaah_obat[0]->nm_apoteker : '-' : '-'; ?>
                                            </td>

                                        <?php } else { ?>
                                            <td><br><br></td>
                                        <?php } ?>
                                        <?php
                                        if (isset($resep_pasien[0]->ttd)) {
                                        ?>
                                            <td><img width="120px" src="<?= $resep_pasien[0]->ttd; ?>" alt=""><br>
                                                <?= ($resep_pasien) ? $resep_pasien[0]->nm_dokter ? $resep_pasien[0]->nm_dokter : '-' : '-'; ?>
                                            </td>

                                        <?php } ?>
                                    </tr>


                                </table>
                            </td>
                        </tr>
                      
                       
                        <tr>
                            <td>
                                <table border="1" width="100%">
                                    <tr>
                                        <td>
                                            <table class="side_table" border="0" width="100%">
                                                <thead>
                                                    <tr class="border_bottom">
                                                        <td width="70%"><span class="text_isi">Telaah Obat</span></td>
                                                        <td width="15%"><span class="text_isi">Ya</span></td>
                                                        <td width="15%"><span class="text_isi">Tidak</span></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat pasien</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'1'}) ? ($data_formjson->verif_penyerahan_obat->{'1'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'1'}) ? ($data_formjson->verif_penyerahan_obat->{'1'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat indikasi</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'2'}) ? ($data_formjson->verif_penyerahan_obat->{'2'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'2'}) ? ($data_formjson->verif_penyerahan_obat->{'2'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat obat</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'3'}) ? ($data_formjson->verif_penyerahan_obat->{'3'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'3'}) ? ($data_formjson->verif_penyerahan_obat->{'3'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat dosis & kekuatan</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'4'}) ? ($data_formjson->verif_penyerahan_obat->{'4'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'4'}) ? ($data_formjson->verif_penyerahan_obat->{'4'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat cara pemberian</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'5'}) ? ($data_formjson->verif_penyerahan_obat->{'5'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'5'}) ? ($data_formjson->verif_penyerahan_obat->{'5'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat waktu pemberian</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'6'}) ? ($data_formjson->verif_penyerahan_obat->{'6'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'6'}) ? ($data_formjson->verif_penyerahan_obat->{'6'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                    <tr class="border_bottom">
                                                        <td><span class="text_body">Tepat Dokumentasi</span></td>
                                                        <td><input type="radio" value="1_y" <?php echo isset($data_formjson->verif_penyerahan_obat->{'7'}) ? ($data_formjson->verif_penyerahan_obat->{'7'} == "ya" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                        <td><input type="radio" value="1_t" <?php echo isset($data_formjson->verif_penyerahan_obat->{'7'}) ? ($data_formjson->verif_penyerahan_obat->{'7'} == "tidak" ? "checked='checked'" : "disabled='disabled'") : ''; ?>></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                    </table>

                    <table class="side_table" border="1" width="100%">
                                    <tr>
                                        <td width="50%">
                                            <span class="text_body"> <center>Apoteker/Ass. Apt<center></span>
                                        </td>
                                        <td>
                                            <span class="text_body"> <center>Pasien / Kel <center></span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <?php
                                        if (isset($telaah_obat[0]->ttd_apoteker)) {
                                        ?>
                                            <td><img width="120px" src="<?= $telaah_obat[0]->ttd_apoteker; ?>" alt="">
                                                <?= ($telaah_obat) ? $telaah_obat[0]->nm_apoteker ? $telaah_obat[0]->nm_apoteker : '-' : '-'; ?>
                                            </td>

                                        <?php } else { ?>
                                            <td><br><br></td>
                                        <?php } ?>
                                        
                                            <td><br><br>
                                            </td>

                                        
                                    </tr>


                                </table>
                </div>
            </div>
        </div>
    <?php } ?>
</body>

</html>