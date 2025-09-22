<?php 
$data = isset($per_per_rujukan->formjson)?json_decode($per_per_rujukan->formjson):'';
// var_dump($data);die;
?>


</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
    <!-- <header style="margin-top:0px;">
        <?php $this->load->view('emedrec/rj/header_print') ?>
    </header> -->
    <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
    <tr>
        <td width="30%">
            <table border="0" width="100%">
                <tr>
                    <td width="30%"><img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="70px" width="60px" style="padding-right:15px;"></td>
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
                <h3>FORMULIR PERSETUJUAN / PENOLAKAN RUJUKAN</h3>
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
            <td colspan="2"></td>
            <td >Halaman 1 dari 1</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
        <h2 style="text-align: center;">PEMBERIAN INFORMASI</h2>
        <p><b>Pemberi Informasi : <?= isset($data->question6)?$data->question6:'' ?></b></p>
        <p><b>Penerima Informasi : <?= isset($data->question3)?$data->question3:'' ?></b></p>
        
        <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th><center>No.</center></th>
                <th><center>Jenis Informasi</center></th>
                <th><center>ISI INFORMASI</center></th>
                <th><center>TANDA (√)</center></th>
            </tr>
            <tr><td>1</td><td>Diagnosis dan terapi / tindakan<br> medis yang diperlukan</td><td><?= isset($data->info_penelitian->diagnosis->{'Column 1'})?nl2br($data->info_penelitian->diagnosis->{'Column 1'}):'' ?></td>
            <td> 
                <label><center>
                    <input type="checkbox" 
                        <?= !empty($data->info_penelitian->diagnosis->{'Column 2'}[0]) ? "checked" : "" ?>>
                </center></label>
            </td>
            </tr>
            <tr><td>2</td><td>Alasan dan tujuan dilakukan rujukan</td><td><?= isset($data->info_penelitian->alasan->{'Column 1'})?nl2br($data->info_penelitian->alasan->{'Column 1'}):'' ?></td>
             <td> 
                <label><center>
                    <input type="checkbox" 
                        <?= !empty($data->info_penelitian->alasan->{'Column 2'}[0]) ? "checked" : "" ?>>
                </center></label>
            </td>
            </tr>
            <tr><td>3</td><td>Risiko yang dapat timbul <br>apabila rujukan tidak dilakukan</td><td><?= isset($data->info_penelitian->risiko->{'Column 1'})?nl2br($data->info_penelitian->risiko->{'Column 1'}):'' ?></td>
            <td> 
                <label><center>
                    <input type="checkbox" 
                        <?= !empty($data->info_penelitian->alasan->{'Column 2'}[0]) ? "checked" : "" ?>>
                </center></label>
            </td>
            </tr>
            <tr><td>4</td><td>Transfortasi rujukan</td><td><?= isset($data->info_penelitian->transfortasi->{'Column 1'})?nl2br($data->info_penelitian->transfortasi->{'Column 1'}):'' ?></td>
            <td> 
                <label><center>
                    <input type="checkbox" 
                        <?= !empty($data->info_penelitian->transfortasi->{'Column 2'}[0]) ? "checked" : "" ?>>
                </center></label>
            </td>
            </tr>
            <tr><td>5</td><td>Risiko atau penyulit yang <br>dapat timbul selama dalam perjalanan</td><td><?= isset($data->info_penelitian->penyulit->{'Column 1'})?nl2br($data->info_penelitian->penyulit->{'Column 1'}):'' ?></td>
             <td> 
                <label><center>
                    <input type="checkbox" 
                        <?= !empty($data->info_penelitian->penyulit->{'Column 2'}[0]) ? "checked" : "" ?>>
                </center></label>
            </td>
            </tr>
            <tr><td>6</td><td>Rumah sakit yang dituju</td><td><?= isset($data->info_penelitian->{'rumah sakit'}->{'Column 1'})?nl2br($data->info_penelitian->{'rumah sakit'}->{'Column 1'}):'' ?></td>
             <td> 
                <label><center>
                    <input type="checkbox" 
                        <?= !empty($data->info_penelitian->{'rumah sakit'}->{'Column 2'}[0]) ? "checked" : "" ?>>
                </center></label>
            </td>
            </tr>
          
        </table>
        
        <p>Dengan ini menyatakan bahwa saya.<b> <?= isset($data->question7)?$data->question7:'' ?></b><br> telah menerangkan hal-hal di atas secara benar dan jelas serta memberi kesempatan untuk bertanya dan atau berdiskusi</p>
        <p style="text-align: right;">( ttd. Dokter ) <br><p style="text-align: right;"><img width="30px" src="<?= isset($data->question10) ? $data->question10 : '' ?>"></p>
                   <p style="text-align: right;">(<?= isset($data->question23) ? $data->question23 : '' ?>)</p></p>
        
        <p>Dengan ini menyatakan bahwa saya/keluarga pasien <b><?= isset($data->question7)?$data->question7:'' ?> </b>telah menerima informasi sebagaimana di atas yang saya beri tanda/paraf di kolom kanannya serta diberi kesempatan untuk bertanya/berdiskusi dan telah memahaminya.</p>
        <p style="text-align: right;">( ttd. Pasien )<br><p style="text-align: right;"><img width="30px" src="<?= isset($data->question11) ? $data->question11 : '' ?>"></p>
                   <p style="text-align: right;">(<?= isset($data->question23) ? $data->question23 : '' ?>)</p>
        
        <h3 style="text-align: center;">PERSETUJUAN/PENOLAKAN*RUJUKAN</h3>
        <p>Yang bertandatangan di bawah ini,</p>
        <table border="0" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <td width="30%">Nama</td>
                <td width="70%">: <?= isset($data->question12->text1)?$data->question12->text1:'' ?> </td>
            </tr>
            <tr>
                <td width="30%">Umur</td>
                <td width="70%">: <?= isset($data->question12->text2)?$data->question12->text2:'' ?> </td>
            </tr>
            <tr>
                <td width="30%">Alamat</td>
                <td width="70%">: <?= isset($data->question12->text3)?$data->question12->text3:'' ?> </td>
            </tr>
        </table>
        <p>Dengan ini menyatakan  <label>
            <input type="checkbox" name="persetujuan" value="setuju" <?php echo isset($data->question13)? $data->question13 == "Setuju" ? "checked":'':'' ?>> SETUJU
            </label>
            <label>
            <input type="checkbox" name="persetujuan" value="menolak" <?php echo isset($data->question13)? $data->question13 == "Menolak" ? "checked":'':'' ?>> MENOLAK
            </label> untuk dilakukan rujukan terhadap saya :  <?= isset($data->question14)?$data->question14:'' ?></p>
           

        <table border="0" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <td width="30%">Nama</td>
                <td width="70%">: <?= isset($data->question15->text1)?$data->question15->text1:'' ?></td>
            </tr>
            <tr>
                <td width="30%">Umur</td>
                <td width="70%">: <?= isset($data->question15->text2)?$data->question15->text2:'' ?></td>
            </tr>
            <tr>
                <td width="30%">Alamat</td>
                <td width="70%">: <?= isset($data->question15->text3)?$data->question15->text3:'' ?></td>
            </tr>
        </table>
        <p>Saya memahami perlunya dan manfaat rujukan tersebut sebagaimana telah dijelaskan kepada saya, termasuk risiko  yang mungkin timbul apabila rujukan tersebut dilaksanakan atau tidak dilaksanakan. <br>
        saya bertanggung jawab secara penuh atas segala akibat yang timbul sebagai akibat dilakukan atau tidak dilakukan rujukan tersebut.
        </p>
        
        <p style="text-align: right;">Tanah Badantung, <?= isset($data->question16)?$data->question16:'' ?> WIB</p>
        <table width="100%">
            <tr>
                <td style="text-align: center;">yang menyatakan<br><p><img width="50px" src="<?= isset($data->question17) ? $data->question17 : '' ?>"></p>
                   <p>(<?= isset($data->question20) ? $data->question20 : '' ?>)</p></td>
                <td style="text-align: center;">saksi<br><p><img width="50px" src="<?= isset($data->question18) ? $data->question18 : '' ?>"></p>
                   <p>(<?= isset($data->question21) ? $data->question21 : '' ?>)</p></td>
                <td style="text-align: center;">saksi<br><p><img width="50px" src="<?= isset($data->question19) ? $data->question19 : '' ?>"></p>
                   <p>(<?= isset($data->question22) ? $data->question22 : '' ?>)</p></td>
                  </tr>
        </table><br>
          <p><b>CATATAN</p>
          <p>*coret yang tidak perlu</b></p>
                       
        </td>
       </tr>
       
    </table>
                
</div>
</body>

</html>