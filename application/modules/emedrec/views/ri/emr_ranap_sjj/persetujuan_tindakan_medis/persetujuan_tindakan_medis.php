<?php 
$data = isset($persetujuan_medis->formjson)?json_decode($persetujuan_medis->formjson):'';
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
                <h3>PERSETUJUAN TINDAKAN MEDIS</h3>
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
            <td colspan="2">(Diisi oleh Dokter)</td>
            <td >Halaman 1 dari 1</td>
            
        </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
        <td colspan="4">
        <h2  style="font-size: 13px;"><center>PEMBERIAN INFORMASI</center></h2>
        <p style="font-size: 10px;"><b>Dokter Pelaksana Tindakan : <?= isset($data->question4)?$data->question4:'' ?></b></p>
        <p style="font-size: 10px;"><b>Pemberi Informasi : <?= isset($data->question6)?$data->question6:'' ?></b></p>
        <p style="font-size: 10px;"><b>Penerima Informasi : <?= isset($data->question1->text3)?$data->question1->text3:'' ?></b></p>
        
        <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th style="font-size: 10px;">No.</th>
                <th style="font-size: 10px;">Jenis Informasi</th>
                <th style="font-size: 10px;">ISI INFORMASI</th>
                <th style="font-size: 10px;">TANDA (√)</th>
            </tr>
            <tr>
                <td style="font-size: 10px;">1</td>
                <td style="font-size: 10px;">Diagnosis (WD dan DD)</td>
                <td><?= isset($data->question2->Row1->isi_informasi)?$data->question2->Row1->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row1->ckls[0])? $data->question2->Row1->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">2</td>
                <td style="font-size: 10px;">Dasar Diagnosis</td>
              <td><?= isset($data->question2->Row2->isi_informasi)?$data->question2->Row2->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row2->ckls[0])? $data->question2->Row2->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">3</td>
                <td style="font-size: 10px;">Tindakan kedokteran</td>
              <td><?= isset($data->question2->Row3->isi_informasi)?$data->question2->Row3->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row3->ckls[0])? $data->question2->Row3->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">4</td>
                <td style="font-size: 10px;">Tata Cara </td>
              <td><?= isset($data->question2->Row5->isi_informasi)?$data->question2->Row5->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row5->ckls[0])? $data->question2->Row5->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">5</td>
                <td style="font-size: 10px;">Indikasi Tindakan</td>
              <td><?= isset($data->question2->Row4->isi_informasi)?$data->question2->Row4->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row4->ckls[0])? $data->question2->Row4->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">6</td>
                <td style="font-size: 10px;">Tujuan Tindakan</td>
              <td><?= isset($data->question2->Row6->isi_informasi)?$data->question2->Row6->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row6->ckls[0])? $data->question2->Row6->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">7</td>
                <td style="font-size: 10px;">Resiko dan Komplikasi</td>
              <td><?= isset($data->question2->Row7->isi_informasi)?$data->question2->Row7->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row7->ckls[0])? $data->question2->Row7->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">8</td>
                <td style="font-size: 10px;">Prognosis</td>
              <td><?= isset($data->question2->Row8->isi_informasi)?$data->question2->Row8->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row8->ckls[0])? $data->question2->Row8->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">9</td>
                <td style="font-size: 10px;">Keuntungan</td>
              <td><?= isset($data->question2->Row8->isi_informasi)?$data->question2->Row8->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row8->ckls[0])? $data->question2->Row8->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">10</td>
                <td  style="font-size: 10px;">Alternatif
                    <p>-Pilihan pengobatan</p>
                    <p>-Transfusi darah</p>
                </td>
              <td><?= isset($data->question2->Row10->isi_informasi)?$data->question2->Row10->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row10->ckls[0])? $data->question2->Row10->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td style="font-size: 10px;">11</td>
                <td style="font-size: 10px;">Hal yang akan dilakukan untuk <p>Menyelamatkan pasien </p>
                    <p>-Perluasan tindakan</p>
                    <p>-konsultasi selama tindakan</p>
                    <p>-Resusitasi</p>
                </td>
              <td><?= isset($data->question2->Row10->isi_informasi)?$data->question2->Row10->isi_informasi:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->question2->Row10->ckls[0])? $data->question2->Row10->ckls[0] == "1" ? "✓":'':'' ?></td>
            </tr>
        </table>
        
        <p style="font-size: 11px;">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas serta memberi kesempatan untuk bertanya dan atau berdiskusi</p>
        <p style="text-align: right; font-size: 10px;"> <img src="<?= isset($data->question14)?$data->question14:''; ?>" alt="img" height="30px" width="30px"></p>
        <p style="text-align: right; font-size: 10px;">( ttd. Dokter )</p>
        
        <p style="font-size: 11px;">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas dan telah memahaminya.</p>
        <p style="text-align: right; font-size: 10px;"> <img src="<?= isset($data->question16)?$data->question16:''; ?>" alt="img" height="30px" width="30px"></p>
        <p style="text-align: right; font-size: 10px;">( ttd. Pasien )</p>
        
        <h3 style="font-size: 13px;"><center>PERSETUJUAN</center></h3>
        <p style="font-size: 11px;">Yang bertandatangan di bawah ini, nama <?= isset($data->question31->{'Row 1'}->{'Column 1'})?$data->question31->{'Row 1'}->{'Column 1'}:'' ?> Tgl Lahir <?= isset($data->question31->{'Row 1'}->{'Column 2'})?date('d/m/Y',strtotime($data->question31->{'Row 1'}->{'Column 2'})):'' ?></p>
        <p style="font-size: 11px;">Alamat <?= isset($data->question31->{'Row 1'}->{'Column 4'})?$data->question31->{'Row 1'}->{'Column 4'}:'' ?></p>
        <p style="font-size: 11px;">Dengan ini menyatakan <b>SETUJU</b> untuk dilakukan tindakan <?= isset($data->question10)?$data->question10:'' ?></p>
        <p style="font-size: 11px;">Terhadap saya / <?= isset($data->question9)?$data->question9:'' ?>, saya yang bernama <?= isset($data->question11->{'Row 1'}->{'Column 1'})?$data->question11->{'Row 1'}->{'Column 1'}:'' ?></p>
        <p style="font-size: 11px;">Tgl. lahir <?= isset($data->question11->{'Row 1'}->{'Column 2'})?$data->question11->{'Row 1'}->{'Column 2'}:'' ?> Alamat <?= isset($data->question11->{'Row 1'}->{'Column 4'})?$data->question11->{'Row 1'}->{'Column 4'}:'' ?></p>
        <p style="font-size: 11px;">Dirawat di ............ No. RM :<?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'' ?></p>
        
        <p style="font-size: 11px;">Saya memahami perlunya tindakan tersebut sebagaimana telah dijelaskan kepada saya, termasuk risiko dan komplikasi yang mungkin terjadi. Saya juga menyadari oleh karena itu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.</p>
        <br><br>
        <p style="text-align: right;">Tanah Badantung, <?= isset($data->question18)?date('d/m/Y',strtotime($data->question18)):'' ?> Pukul : <?= isset($data->question18)?date('h:i',strtotime($data->question18)):'' ?> WIB</p>
        <table width="100%">
            <tr>
                <td style="text-align: center;">
                    <p style="font-size: 11px;">Saksi</p>
                    <p><img src="<?= isset($data->question19)?$data->question19:''; ?>" alt="img" height="30px" width="30px"></p>
                    <p style="font-size: 11px;">(<?= isset($data->question27)?$data->question27:'' ?>)</p>
                    
                </td>
                <td style="text-align: center;">
                    <p style="font-size: 11px;">Yang Menyatakan/Wali Pasien</p>
                    <p><img src="<?= isset($data->question24)?$data->question24:''; ?>" alt="img" height="30px" width="30px"></p>
                    <p style="font-size: 11px;">(<?= isset($data->question28)?$data->question28:'' ?>)</p>
                </td>
                <td style="text-align: center;">
                    <p style="font-size: 11px;">Dokter</p>
                    <p><img src="<?= isset($data->question25)?$data->question25:''; ?>" alt="img" height="30px" width="30px"></p>
                    <p style="font-size: 11px;">(<?= isset($data->question29)?$data->question29:'' ?>)</p>
                </td>
                <td style="text-align: center;">
                    <p style="font-size: 11px;">Saksi</p>
                    <p><img src="<?= isset($data->question26)?$data->question26:''; ?>" alt="img" height="30px" width="30px"></p>
                    <p style="font-size: 11px;">(<?= isset($data->question30)?$data->question30:'' ?>)</p>
                </td>
            </tr>
        </table>
          
                       
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.17.a1/RI-GN
                    </div>
               </div>
    </div>
</div>
</body>

</html>