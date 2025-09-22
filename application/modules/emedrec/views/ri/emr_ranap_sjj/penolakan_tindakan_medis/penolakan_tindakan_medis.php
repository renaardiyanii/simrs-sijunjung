<?php 
$data = isset($pen_medis->formjson)?json_decode($pen_medis->formjson):'';
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
                <h3>PENOLAKAN TINDAKAN MEDIS</h3>
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
        <h2 style="text-align: center;">PEMBERIAN INFORMASI</h2>
        <p><b>Dokter Pelaksana Tindakan : <?= isset($data->question3)?$data->question3:'' ?></b></p>
        <p><b>Pemberi Informasi : <?= isset($data->question6)?$data->question6:'' ?></b></p>
        <p><b>Penerima Informasi : <?= isset($data->mt_penelitian->penerima)?$data->mt_penelitian->penerima:'' ?></b></p>
        
        <table border="1" width="100%" style="border-collapse: collapse; text-align: left;">
            <tr>
                <th>No.</th>
                <th>Jenis Informasi</th>
                <th>ISI INFORMASI</th>
                <th>TANDA (√)</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Diagnosis (WD dan DD)</td>
                <td><?= isset($data->info_penelitian->diagnosis->{'Column 1'})?$data->info_penelitian->diagnosis->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->diagnosis->{'Column 2'}[0])? $data->info_penelitian->diagnosis->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            </tr>
            <tr>
                <td>2</td>
                <td>Dasar Diagnosis
                <td><?= isset($data->info_penelitian->tindakan->{'Column 1'})?$data->info_penelitian->tindakan->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->tindakan->{'Column 2'}[0])? $data->info_penelitian->tindakan->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr>
                <td>3</td>
                <td>Tindakan</td>
               <td><?= isset($data->info_penelitian->tindakan_anestesi->{'Column 1'})?$data->info_penelitian->tindakan_anestesi->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->tindakan_anestesi->{'Column 2'}[0])? $data->info_penelitian->tindakan_anestesi->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr>
                <td>4</td>
                <td>Indikasi Tindakan</td>
               <td><?= isset($data->info_penelitian->indikasi_tind->{'Column 1'})?$data->info_penelitian->indikasi_tind->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->indikasi_tind->{'Column 2'}[0])? $data->info_penelitian->indikasi_tind->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr>
                <td>5</td>
                <td>Tata Cara Tindakan</td>
               <td><?= isset($data->info_penelitian->tatacara->{'Column 1'})?$data->info_penelitian->tatacara->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->tatacara->{'Column 2'}[0])? $data->info_penelitian->tatacara->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr>
                <td>6</td>
                <td>Tujuan Tindakan</td>
               <td><?= isset($data->info_penelitian->tujuan->{'Column 1'})?$data->info_penelitian->tujuan->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->tujuan->{'Column 2'}[0])? $data->info_penelitian->tujuan->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr><td>7</td>
            <td>Komplikasi</td>
           <td><?= isset($data->info_penelitian->komplikasi->{'Column 1'})?$data->info_penelitian->komplikasi->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->komplikasi->{'Column 2'}[0])? $data->info_penelitian->komplikasi->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr>
                <td>8</td>
                <td>Prognosis</td>
               <td><?= isset($data->info_penelitian->prognosis->{'Column 1'})?$data->info_penelitian->prognosis->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->prognosis->{'Column 2'}[0])? $data->info_penelitian->prognosis->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
            <tr>
                <td>9</td>
                <td>Alternatif & Risiko</td>
               <td><?= isset($data->info_penelitian->alternatif->{'Column 1'})?$data->info_penelitian->alternatif->{'Column 1'}:'' ?></td>
                <td style="text-align:center"><?php echo isset($data->info_penelitian->alternatif->{'Column 2'}[0])? $data->info_penelitian->alternatif->{'Column 2'}[0] == "item1" ? "✓":'':'' ?></td>
        </table>
        
        <p>Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas serta memberi kesempatan untuk bertanya dan atau berdiskusi</p>
        <p style="text-align: right;">( ttd. Dokter )</p>
        
        <p>Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas dan telah memahaminya.</p>
        <p style="text-align: right;">( ttd. Pasien )</p>
        
        <h3 style="text-align: center;">PENOLAKAN</h3>
        <p>Yang bertandatangan di bawah ini, nama <?= isset($data->mt_bio_wali_pasien->nm)?$data->mt_bio_wali_pasien->nm:'...................' ?> Umur <?= isset($data->mt_bio_wali_pasien->umur)?$data->mt_bio_wali_pasien->umur:'...................' ?> tahun</p>
        <p>Alamat <?= isset($data->mt_bio_wali_pasien->alamat)?$data->mt_bio_wali_pasien->alamat:'...................' ?></p>
        <p>Dengan ini menyatakan <b>MENOLAK</b> untuk dilakukan tindakan <?= isset($data->txt_tindakan)?$data->txt_tindakan:'...................' ?></p>
        <p>Terhadap saya / <?= isset($data->question1)?$data->question1:'...................' ?>, saya yang bernama <?= isset($data->mt_bio_pasien1->nama)?$data->mt_bio_pasien1->nama:'...................' ?></p>
        <p>Tgl. lahir <?= isset($data->mt_bio_pasien1->umur)?$data->mt_bio_pasien1->umur:'...................' ?> Alamat <?= isset($data->mt_bio_pasien1->alamat)?$data->mt_bio_pasien1->alamat:'...................' ?></p>
        <p>Dirawat di <?= isset($data_pasien[0]->nm_ruang)?$data_pasien[0]->nm_ruang:'...................' ?> No. RM :<?= isset($data_pasien[0]->no_cm)?$data_pasien[0]->no_cm:'...................' ?></p>
        
        <p>Saya memahami perlunya tindakan tersebut sebagaimana telah dijelaskan kepada saya, termasuk risiko dan komplikasi yang mungkin terjadi. Saya juga menyadari oleh karena itu kedokteran bukanlah ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung kepada izin Tuhan Yang Maha Esa.</p>
        <br><br><br><br><br><br>
        <p style="text-align: right;">Tanah Badantung, <?= isset($data->question18)?date('d-m-Y',strtotime($data->question18)):'' ?> Pukul : <?= isset($data->question18)?date('H:i',strtotime($data->question18)):'' ?>  WIB</p>
        <table width="100%">
            <tr>
                <td style="text-align: center;">
                Saksi
                <br>
                <img width="80px" style="text-align:center" src="<?= isset($data->question26)?$data->question26:'' ?>" alt="">
                <p>( <?= isset($data->question27)?$data->question27:'...................' ?> )</p>
                </td>
                <td style="text-align: center;">Yang Menyatakan Pasien / Wali
                <br>
                <img width="80px" style="text-align:center" src="<?= isset($data->question24)?$data->question24:'' ?>" alt="">
                <p>( <?= isset($data->question28)?$data->question28:'...................' ?> )</p>
                </td>
                <td style="text-align: center;">Dokter<br>
                <img width="80px" style="text-align:center" src="<?= isset($data->question25)?$data->question25:'' ?>" alt="">
                <p>( <?= isset($data->question30)?$data->question30:'...................' ?> )</p>
                </td>
                <!-- <td style="text-align: center;">Saksi<br>( ............................ )</td> -->
            </tr>
        </table>
          
                       
        </td>
       </tr>
       
    </table>
                <div>
                
                <div style="margin-left:540px; font-size:12px;">
                Rev.I.I/2018/RM.17.a2/RI-GN
                    </div>
               </div>
    </div>
</div>
</body>

</html>