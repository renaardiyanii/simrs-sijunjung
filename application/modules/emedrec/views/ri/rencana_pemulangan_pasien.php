<?php 
$data = (isset($rencana_pemulangan->formjson)?json_decode($rencana_pemulangan->formjson):'');
// var_dump($rencana_pemulangan);
?>
<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            
            
            /* position: relative; */
            /* text-align: justify; */
           
        }

        #data tr td{
            font-size: 11px;
        }
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >

    <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
            Rencana Pemulangan Pasien (Discharge Planning)
            </p>
            <div style="font-size:11px">

                <table id="data" border="1" cellpadding="4px">
                        <tr>
                            <td colspan="2"><span>Diagnosa Medis :	<?= isset($pasien->nm_diagmasuk)?$pasien->nm_diagmasuk:'' ?></span></td>
                            <td><span>Ruangan : <?= isset($pasien->nm_ruang)?$pasien->nm_ruang:''?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>SAAT MASUK RUMAH SAKIT</b></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span>Tanggal Masuk RS : <?= isset($pasien->tgl_masuk)?date('d-m-Y',strtotime($pasien->tgl_masuk)):'' ?></span></td>
                            <td><span>Jam   :  <?= isset($pasien->jam_masuk)?$pasien->jam_masuk:'' ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3"><span>Alasan Masuk RS : <?= isset($data->question11)?$data->question11:'' ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="2"><span>Tanggal Perencanaan Pemulangan Pasien (Discharge Planning) : <br><br><?= isset($data->tanggal_perencanaan_pemulangan)?$data->tanggal_perencanaan_pemulangan:'' ?></span></td>
                            <td><span>Jam   : <?= isset($data->question4)?date('H:i:s',strtotime($data->question4)):'' ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3"><span>Estimasi tanggal pemulangan pasien : <?= isset($data->estimasi_tanggal)?date('d-m-Y',strtotime($data->estimasi_tanggal)):'' ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3"><span>Nama Perawat   : <?= $rencana_pemulangan->perawat??"-" ?></span></td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>KETERANGAN RENCANA PEMULANGAN </b></td> 
                        </tr>
                        <tr>
                            <td style="width: 5%;" id="column01">1</td>
                            <td style="width: 55%;">
                                    <span>Pengaruh rawat inap terhadap:</span>
                                    <p><li>Pasien dan keluarga pasien</li></p>
                                    <p><li>Pekerjaan</li></p>
                                    <p><li>Keuangan</li></p>
                            
                            </td>
                            <td style="width: 40%;">
                                <span></span>
                                <p>
                                    <input type="checkbox" name="" id="" <?php echo isset($data->pasien_keluarga_pasien)? $data->pasien_keluarga_pasien == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya</span>
                                    <input type="checkbox" name="" id="" <?php echo isset($data->pasien_keluarga_pasien)? $data->pasien_keluarga_pasien != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span>
                                </p>
                                <p>
                                    <input type="checkbox" name="" id="" <?php echo isset($data->pekerjaan)?$data->pekerjaan == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya</span>
                                    <input type="checkbox" name="" id="" <?php echo isset($data->pekerjaan)?$data->pekerjaan != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                </p>
                                <p>
                                    <input type="checkbox" name="" id="" <?php echo isset($data->keuangan)?$data->keuangan == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya</span>
                                    <input type="checkbox" name="" id="" <?php echo isset($data->keuangan)?$data->keuangan != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                </p>
                            </td>
                        </tr>

                        <tr>
                            <td id="column01">2</td>
                                <td>Antisipasi terhadap masalah saat pulang</td>
                                <td>
                                
                                <input type="checkbox" name="" id="" <?php echo isset($data->antisipasi_terhadap_masalah)?$data->antisipasi_terhadap_masalah == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya</span>
                                <input type="checkbox" name="" id="" <?php echo isset($data->antisipasi_terhadap_masalah)?$data->antisipasi_terhadap_masalah != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <p>Penjelasan <?= isset($data->check_antisipasi)?$data->check_antisipasi:'' ?></p>
                                
                            </td>
                        </tr>
                        <tr>
                            <td id="column01">3</td>
                            <td colspan="2">
                                Bantuan diperlukan dalam hal :
                                <p>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("minum_obat", $data->question3)?'checked':'':'') ?>><span>minum obat</span>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("makan", $data->question3)?'checked':'':'') ?>><span>makan</span>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("menyiapkan_makanan", $data->question3)?'checked':'':'') ?>><span>menyiapkan makanan</span>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("edukasi_kesehatan", $data->question3)?'checked':'':'') ?>><span>edukasi kesehatan</span>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("mandi", $data->question3)?'checked':'':'') ?>><span>mandi</span>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("diet", $data->question3)?'checked':'':'') ?>><span>diet</span>
                                <input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("berpakaian", $data->question3)?'checked':'':'') ?>><span>berpakaian</span>
                                <p><input type="checkbox" name="" id="" <?= (isset($data->question3)?in_array("transport", $data->question3)?'checked':'':'') ?>><span>transportasi</span></p>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td id="column01">4</td>
                            <td>
                                Adakah yang membantu keperluan tersebut diatas?
                            </td>
                            <td>                
                            <input type="checkbox" name="" id="" <?php echo isset($data->adakah_yang_membantu)?$data->adakah_yang_membantu != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->adakah_yang_membantu)?$data->adakah_yang_membantu == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->check_adakah_yang_membantu)?' '.$data->check_adakah_yang_membantu:'' ?></span>
                            </td>
                        </tr>
                        <td id="column01">5</td>
                            <td>Apakah Pasien  hidup/ tinggal  sendiri  setelah keluar dari rumah sakit?</td>
                            <td>                
                                <input type="checkbox" name="" id="" <?php echo isset($data->adakah_yang_membantu)?$data->adakah_yang_membantu != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->adakah_yang_membantu)?$data->adakah_yang_membantu == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya, <?= isset($data->check_apakah_pasien)?' '.$data->check_apakah_pasien:'' ?></span>
                                <p>Jelaskan orang yang akan merawat</p>
                                <p></p>
                            </td>
                        </tr>
                            <td id="column01">6</td>
                            <td>Apakah pasien menggunakan peralatan medis di rumah setelah keluar rumah sakit (cateter, NGT, double lumen, oksigen)?</td>
                            <td>              
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_menggunakan)?$data->apakah_pasien_menggunakan != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_menggunakan)?$data->apakah_pasien_menggunakan == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->question5)?' '.$data->question5:'' ?></span>
                            </td>
                        </tr>
                        <td id="column01">7</td>
                            <td>Apakah pasien memerlukan alat bantu setelah keluar dari RS (tongkat, kursi roda, walker  dll) ?</td>
                            <td>                
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_memerlukan)?$data->apakah_pasien_memerlukan != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_memerlukan)?$data->apakah_pasien_memerlukan == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->question7)?' '.$data->question7:'' ?></span>
                            </td>
                        </tr>
                        <td id="column01">8</td>
                            <td>Apakah memerlukan bantuan /perawatan khusus dirumah setelah keluar RS (homecare, home visit)?</td>
                            <td>  
                                            
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_memerlukan)?$data->apakah_memerlukan != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_memerlukan)?$data->apakah_memerlukan == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->question6)?' '.$data->question6:'' ?></span>
                            
                            </td>
                        </tr>
                        <td id="column01">9</td>
                            <td>Apakah pasien bermasalah dalam memenuhi kebutuhan pribadinya setelah keluar dari rumah sakit (makan, minum, toileting, dll) ?</td>
                            <td>     
                                    
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_bermasalah)?$data->apakah_pasien_bermasalah != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_bermasalah)?$data->apakah_pasien_bermasalah == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->question8)?' '.$data->question8:'' ?></span>
                            
                            </td>
                        </tr>
                        <td id="column01">10</td>
                            <td>Apakah pasien memiliki nyeri kronis dan kelelahan setelah keluar dari rumah sakit?</td>
                            <td>  
                                            
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_memiliki)?$data->apakah_pasien_memiliki != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_memiliki)?$data->apakah_pasien_memiliki == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->question10)?' '.$data->question10:'' ?></span>
                                
                            </td>
                        </tr>
                        <td id="column01">11</td>
                            <td>Apakah pasien dan keluarga memerlukan edukasi kesehatan setelah keluar dari rumah sakit (obat-obatan, nyeri,diit, mencari pertolongan, follow up)?</td>
                            <td> 
                                            
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_keluarga)?$data->apakah_pasien_keluarga != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_keluarga)?$data->apakah_pasien_keluarga == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->question9)?' '.$data->question9:'' ?></span>
                            
                            </td>
                        </tr>
                        <td id="column01">12</td>
                            <td>Apakah pasien dan keluarga memerlukan keterampilan khusus setelah keluar dari rumah sakit (perawatan luka, injeksi, perawatan bayi dll)?</td>
                            <td> 
                                            
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_keluarga1)?$data->apakah_pasien_keluarga1 != "ya" ? "checked":'disabled':'disabled' ?>><span>Tidak</span><br>
                                <input type="checkbox" name="" id="" <?php echo isset($data->apakah_pasien_keluarga1)?$data->apakah_pasien_keluarga1 == "ya" ? "checked":'disabled':'disabled' ?>><span>Ya,Jelaskan <?= isset($data->rencana_pemulangan_pasien)?' '.$data->rencana_pemulangan_pasien:'' ?></span>
                            
                            </td>
                        </tr>
                </table>

            </div>
            <br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 2</p>    
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
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                RENCANA PEMULANGAN PASIEN
            </p>
            <div style="font-size:11px;min-height:870px">
                <table width="100%" border=1 id="data" cellpadding="4px">
                    <tr>
                        <td  colspan="4"><p>Catatan tambahan (notes) apabila ada perubahan discharge planning setelah initial assesment</p></td>
                    </tr>
                    <tr>
                        <td  width="15%" style="text-align:center"><p>Tgl/jam</p></td>
                        <td  width="15%" style="text-align:center"><p>Profesi</p></td>
                        <td  width="50%" style="text-align:center"><p>Catatan</p></td>
                        <td  width="20%" style="text-align:center"><p>Nama/Paraf</p></td>
                    </tr>
                    <?php
                                
                                $jml_array = isset($data->table_rencana_pemulangan)?count($data->table_rencana_pemulangan):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <tr>
                                
                                    <td><?= isset($data->table_rencana_pemulangan[$x]->Date)?date('d-m-y',strtotime($data->table_rencana_pemulangan[$x]->Date)):'' ?></td>
                                    <td><?= isset($rencana_pemulangan->name)?$rencana_pemulangan->name:'' ?></td>
                                    <td><?= isset($data->table_rencana_pemulangan[$x]->catatan)?$data->table_rencana_pemulangan[$x]->catatan:'' ?></td>
                                    <td><img width="80px" src="<?= isset($rencana_pemulangan->ttd)?$rencana_pemulangan->ttd:'' ?>" alt=""></td>
                                
                                </tr>
                            <?php } ?>
                </table>
            </div>
            
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 2 dari 2</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
 
        </div>
    </body>
</html>