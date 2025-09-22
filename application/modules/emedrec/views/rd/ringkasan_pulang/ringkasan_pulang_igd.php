<?php 
$data = (isset($ringkasan_pulang->formjson))?json_decode($ringkasan_pulang->formjson):'';
?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
                    <header style="margin-top:0px;">
                        <?php $this->load->view('emedrec/rj/header_print') ?>
                    </header>
                    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
                        <tr>
                        <td>Tanggal Kunjungan :  <?php
                            if (isset($data_daftar_ulang->tgl_kunjungan)) {
                                // Jangan ubah timezone, langsung tampilkan tanggal mentah dari database
                                $datetime = new DateTime($data_daftar_ulang->tgl_kunjungan, new DateTimeZone("UTC"));
                                echo $datetime->format("d-m-Y");
                            }
                            ?></td>
                        </tr>
                    </table>

                    <table border="0" width="100%" cellpadding="5px">
                        <tr>
                            <td>1. DIAGNOSA :
                                <div style="min-height:50px">
                                    <p style="margin-left:20px"> 
                                    <?php
                                            if (isset($get_data_diag)) {
                                                foreach ($get_data_diag as $diag) {
                                                    // Cek apakah ada diagnosa_text
                                                    $catatan = !empty($diag->diagnosa_text) ? ' = ' . $diag->diagnosa_text : '';

                                                    echo $diag->id_diagnosa . ' - ' . $diag->diagnosa . ' (' . $diag->klasifikasi_diagnos . ')' . $catatan . '<br>';
                                                }
                                            }
                                            ?>
                                </p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2. TINDAKAN :
                                <div style="min-height:50px">
                                    <p style="margin-left:20px"><?= isset($data->tindakan)?str_replace("\n","<br>",$data->tindakan):'' ?></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3 PENATALAKSANA : <?= isset($data->laksana)?$data->laksana:'' ?></td>
                            
                        </tr>
                    </table>

                    <table style="width: 100%; border-collapse: collapse; margin: 5px auto; border: 1px solid black;">
                            <tr>
                                <td style="border: 1px solid black; padding: 8px; ">Pukul</td>
                                <td style="border: 1px solid black; padding: 8px; ">Nama obat / infus</td>
                                <td style="border: 1px solid black; padding: 8px; ">Dosis</td>
                                <td style="border: 1px solid black; padding: 8px; ">Nama Tindakan</td>
                                <td style="border: 1px solid black; padding: 8px; ">Dilakukan oleh</td>
                            </tr>
                            <?php 
                            if(isset($data->penatalaksana)){
                                foreach($data->penatalaksana as $penata){
                             ?>
                                <tr>
                                    <td style="border: 1px solid black; padding: 5px;"><?= isset($penata->pukul)?$penata->pukul:'' ?></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <?= isset($penata->nama_obat)?$penata->nama_obat:'' ?></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <?= isset($penata->dosis)?$penata->dosis:'' ?></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <?= isset($penata->nm_tindakan)?$penata->nm_tindakan:'' ?></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <?= isset($penata->dilakukan)?$penata->dilakukan:'' ?></td>
                                </tr>
                            <?php }}else { ?>
                                <tr>
                                    <td style="border: 1px solid black; padding: 5px;"><br></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <br></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <br></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <br></td>
                                    <td style="border: 1px solid black; padding: 5px;"> <br></td>
                                </tr>
                            <?php }
                            ?>
                            
                            
                            
                    </table>
                
                    

                    <div style="display: inline; position: relative;">
                            
                            <div style="float: left;margin-top: 15px;font-size:12px; margin-left: 20px">
                                    
                                    <p>Perawat pemberi pelayanan </p>
                                    <p style="margin: 10px 0;"> <img width="90px" src="<?= isset($data->question2)?$data->question2:'' ?>" alt=""></p>
                                    <p style="margin: 10px 0;"><span>( <?= isset($data->question3)?$data->question3:'' ?> )</span></p>
                           
                                
                            </div>  
                            <div style="float: right;margin-top: 15px;font-size:12px; margin-right: 20px">
                                    
                                    <p>Dokter pemberi pelayanan </p>
                                    <p style="margin: 10px 0;"> <img width="90px" src="<?= isset($data_dokter->ttd)?$data_dokter->ttd:null;  ?>" alt=""></p>
                                    <p style="margin: 10px 0;"><span>( <?= isset($data_dokter->name)?$data_dokter->name:'' ?> )</span></p>
                           
                                
                            </div> 
                    </div>
            
    </div>


    <div class="A4 sheet  padding-fix-10mm">
       
        <br></br>
        <table border="1" width="100%" cellpadding="10px" style="margin-top:10px">
            <center>
                <u><span style="font-size:14px;font-weight:bold;">INFORMASI PEMINDAHAN RUANGAN / PEMULANGAN PASIEN</span></u><br>
               
            </center>
        </table>

        <table style="width: 100%; border-collapse: collapse; margin: 5px auto; border: 1px solid black;">
                <tr>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">INFORMASI</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">√</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center;">KETERANGAN</td>
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;">MRS </td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"><input type="checkbox" <?php echo isset($data->mrs->mrs->ckls)?(in_array("ckls", $data->mrs->mrs->ckls) ? "checked" : "disabled"):""; ?>></td>
                    <td style="border: 1px solid black; padding: 8px;">
                        <div>
                            <p>Diruang :............</p>
                            <input type="checkbox" <?php echo isset($data->mrs->mrs->keterangan)?($data->mrs->mrs->keterangan == "foto_rongsen" ? "checked" : "disabled"):'';?>>Foto Rotgen :...........<br>
                            <input type="checkbox" <?php echo isset($data->mrs->mrs->keterangan)?($data->mrs->mrs->keterangan == "ekg" ? "checked" : "disabled"):'';?>>EKG:..............Lembar<br>
                            <input type="checkbox" <?php echo isset($data->mrs->mrs->keterangan)?($data->mrs->mrs->keterangan == "obat" ? "checked" : "disabled"):'';?>>Obat obatan<br>
                            <input type="checkbox" <?php echo isset($data->mrs->mrs->keterangan)?($data->mrs->mrs->keterangan == "lab" ? "checked" : "disabled"):'';?>>Laboratorium :................Lembar
                        </div>
                    </td>
                    
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"> Dipulangkan</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"> <input type="checkbox" <?php echo isset($data->dipulangkan->dipulangkan->ckls)?(in_array("ckls", $data->dipulangkan->dipulangkan->ckls) ? "checked" : "disabled"):""; ?>></td>
                    <td style="border: 1px solid black; padding: 8px;"> 
                    <div>
                            <input type="checkbox" <?php echo isset($data->dipulangkan->dipulangkan->keterangan)?($data->dipulangkan->dipulangkan->keterangan == "kie" ? "checked" : "disabled"):'';?>>KIE
                            <input type="checkbox" <?php echo isset($data->dipulangkan->dipulangkan->keterangan)?($data->dipulangkan->dipulangkan->keterangan == "obat_pulang" ? "checked" : "disabled"):'';?>>Obat pulang
                            <input type="checkbox" <?php echo isset($data->dipulangkan->dipulangkan->keterangan)?($data->dipulangkan->dipulangkan->keterangan == "foto_rongsen" ? "checked" : "disabled"):'';?>>foto rotgen<br>
                            <input type="checkbox" <?php echo isset($data->dipulangkan->dipulangkan->keterangan)?($data->dipulangkan->dipulangkan->keterangan == "laboratorium" ? "checked" : "disabled"):'';?>>Laboratorium 
                            <input type="checkbox" <?php echo isset($data->dipulangkan->dipulangkan->keterangan)?($data->dipulangkan->dipulangkan->keterangan == "kontrol" ? "checked" : "disabled"):'';?>>Kontrol poliklinik
                    </div>
                    </td>
                    
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"> Pulang paksa</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"><input type="checkbox" <?php echo isset($data->pulang_paksa->pulang_paksa->ckls)?(in_array("ckls", $data->pulang_paksa->pulang_paksa->ckls) ? "checked" : "disabled"):""; ?>></td>
                    <td style="border: 1px solid black; padding: 8px;">
                    <div>
                            <input type="checkbox" <?php echo isset($data->pulang_paksa->pulang_paksa->keterangan)?($data->pulang_paksa->pulang_paksa->keterangan == "kie" ? "checked" : "disabled"):'';?>>KIE
                            <input type="checkbox" <?php echo isset($data->pulang_paksa->pulang_paksa->keterangan)?($data->pulang_paksa->pulang_paksa->keterangan == "ttd" ? "checked" : "disabled"):'';?>>Tanda tangan pernyataan pulang paksa
                            
                        </div>
                    </td>
                    </td>
                   
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"> Meninggal</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"><input type="checkbox" <?php echo isset($data->meninggal->meninggal->ckls)?(in_array("ckls", $data->meninggal->meninggal->ckls) ? "checked" : "disabled"):""; ?>></td>
                    <td style="border: 1px solid black; padding: 8px;">
                        <p> Dinyatakan meninggal pukul  <?= isset($data->meninggal->meninggal->keterangan)?date('h:i',strtotime($data->meninggal->meninggal->keterangan)):'' ?> WIB
                    </td>
                    
                </tr>
                <tr>
                    <td style="border: 1px solid black; padding: 8px;"> Minggat</td>
                    <td style="border: 1px solid black; padding: 8px; text-align: center; vertical-align: middle;"><input type="checkbox" <?php echo isset($data->minggat->minggat->ckls)?(in_array("ckls", $data->minggat->minggat->ckls) ? "checked" : "disabled"):""; ?>></td>
                    <td style="border: 1px solid black; padding: 8px;">
                    <div>
                            <p> Dinyatakan minggat pukul...........WIB </p>
                            <input type="checkbox" <?php echo isset($data->minggat->minggat->keterangan)?($data->minggat->minggat->keterangan == "l_satpam" ? "checked" : "disabled"):'';?>>Lapor Satpam
                            <input type="checkbox" <?php echo isset($data->minggat->minggat->keterangan)?($data->minggat->minggat->keterangan == "l_kooordinator" ? "checked" : "disabled"):'';?>>Lapor Piket <br>
                            <input type="checkbox" <?php echo isset($data->minggat->minggat->keterangan)?($data->minggat->minggat->keterangan == "l_piket" ? "checked" : "disabled"):'';?>>Lapor koordinator/pengawas
                        
                    </div>
                    </td>
                    
                </tr>
                
        </table>
    </div>


</body>

</html>