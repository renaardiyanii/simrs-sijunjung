<?php
$data = (isset($penolakan_kedokteran->formjson)?json_decode($penolakan_kedokteran->formjson):''); 
$result = array_chunk($penolakan_kedokteran, 1);
// var_dump($data->mt_bio_pasien1);
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
            font-size: 11px;
            position: relative;
        }

        #data tr td{
            
            font-size: 12px;
            
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >
    <?php 
    if($result){
        for($i = 0;$i<count($result);$i++){ ?>

        <?php 
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
            ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><span style="font-size:16px;font-weight:bold">PENOLAKAN TINDAKAN KEDOKTERAN</span></center>

            <table id="data" width="100%" border=1 cellpadding="2px">
                <tr>
                    <td colspan="4" style="text-align:center;font-size:15px;font-weight:bold">PEMBERIAN INFORMASI</td>
                </tr>
                <tr>
                    <td colspan="4">Dokter Pelaksana Tindakan : <?= isset($value->question3)? Explode('-',$value->question3)[0]:'' ?></td>
                </tr>
                <tr>
                    <td colspan="4">Pemberi Informasi : <?= isset($value->question6)? Explode('-',$value->question6)[0]:'' ?></td>
                </tr>
                <tr>
                    <td colspan="4">Penerima informasi/pemberi persetujuan * : <?= isset($value->mt_penelitian->penerima)?$value->mt_penelitian->penerima:'' ?></td>
                </tr>
                <tr>
                    <td colspan="2">Diberikan pada waktu</td>
                    <td>Tanggal :  <?= isset($value->mt_penelitian->wkt)? date('d-m-Y',strtotime($value->mt_penelitian->wkt)):''; ?></td>
                    <td>Jam : <?= isset($value->mt_penelitian->wkt)? date('h:i',strtotime($value->mt_penelitian->wkt)):''; ?></td>
                </tr>
                <tr>
                    <td style="text-align:center;font-size:12px;font-weight:bold">NO</td>
                    <td style="text-align:center;font-size:12px;font-weight:bold">JENIS INFORMASI</td>
                    <td style="text-align:center;font-size:12px;font-weight:bold">ISI INFORMASI</td>
                    <td style="text-align:center;font-size:12px;font-weight:bold">TANDA (√ )</td>
                </tr>
                <tr>
                        <td>1</td>
                        <td>Diagnosis (WD dan DD)</td>
                        <td><?= isset($value->info_penelitian->diagnosis->{'Column 1'})?$value->info_penelitian->diagnosis->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->diagnosis->{'Column 2'}[0])? $value->info_penelitian->diagnosis->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Dasar diagnosis</td>
                        <td><?= isset($value->info_penelitian->tindakan->{'Column 1'})?$value->info_penelitian->tindakan->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->tindakan->{'Column 2'}[0])? $value->info_penelitian->tindakan->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tindakan Medis</td>
                        <td>
                        <?= isset($value->info_penelitian->tindakan_anestesi->{'Column 1'})?$value->info_penelitian->tindakan_anestesi->{'Column 1'}:'' ?>
                        </td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->tindakan_anestesi->{'Column 2'}[0])? $value->info_penelitian->tindakan_anestesi->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Indikasi Tindakan</td>
                        <td><?= isset($value->info_penelitian->indikasi_tind->{'Column 1'})?$value->info_penelitian->indikasi_tind->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->indikasi_tind->{'Column 2'}[0])? $value->info_penelitian->indikasi_tind->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Tata Cara</td>
                        <td><?= isset($value->info_penelitian->tatacara->{'Column 1'})?$value->info_penelitian->tatacara->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->tatacara->{'Column 2'}[0])? $value->info_penelitian->tatacara->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Tujuan</td>
                        <td><?= isset($value->info_penelitian->tujuan->{'Column 1'})?$value->info_penelitian->tujuan->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->tujuan->{'Column 2'}[0])? $value->info_penelitian->tujuan->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Risiko</td>
                        <td><?= isset($value->info_penelitian->risiko->{'Column 1'})?$value->info_penelitian->risiko->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->risiko->{'Column 2'}[0])? $value->info_penelitian->risiko->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Komplikasi</td>
                        <td><?= isset($value->info_penelitian->komplikasi->{'Column 1'})?$value->info_penelitian->komplikasi->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->komplikasi->{'Column 2'}[0])? $value->info_penelitian->komplikasi->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Prognosis</td>
                        <td><?= isset($value->info_penelitian->prognosis->{'Column 1'})?$value->info_penelitian->prognosis->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->prognosis->{'Column 2'}[0])? $value->info_penelitian->prognosis->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Alternatif & Resiko</td>
                        <td><?= isset($value->info_penelitian->alternatif->{'Column 1'})?$value->info_penelitian->alternatif->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->info_penelitian->alternatif->{'Column 2'}[0])? $value->info_penelitian->alternatif->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td><?= isset($value->question7[0]->{'Column 1'})?$value->question7[0]->{'Column 1'}:'' ?></td>
                        <td><?= isset($value->question7[0]->{'Column 2'})?$value->question7[0]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->question7[0]->{'Column 3'}[0])? $value->question7[0]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td><?= isset($value->question7[1]->{'Column 1'})?$value->question7[1]->{'Column 1'}:'' ?></td>
                        <td><?= isset($value->question7[1]->{'Column 2'})?$value->question7[1]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->question7[1]->{'Column 3'}[0])? $value->question7[1]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td><?= isset($value->question7[2]->{'Column 1'})?$value->question7[2]->{'Column 1'}:'' ?></td>
                        <td><?= isset($value->question7[2]->{'Column 2'})?$value->question7[2]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($value->question7[2]->{'Column 3'}[0])? $value->question7[2]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>

                <tr>
                    <td colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi</td>
                    <td>Tandatangan
                    <br><br><br><br><br><br>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya beri tanda/paraf di kolom kanannya serta telah diberi kesempatan untuk bertanya/berdiskusi, dan telah memahaminya</td>
                    <td>Tandatangan
                    <br><br><br><br><br><br>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">* Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau   
                    Keluarga terdekat
                    </td>
                </tr>

                <tr>
                    <td colspan="4"  style="text-align:center;font-size:12px;font-weight:bold">PENOLAKAN TINDAKAN KEDOKTERAN</td>
                </tr>

                <tr>
                    <td colspan="4">
                    <p style="padding:10px;line-break: strict;">
                    Yang bertanvaluengan di bawah ini, saya , nama 
                    <?= isset($value->mt_bio_wali_pasien->nm)?$value->mt_bio_wali_pasien->nm:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp'; ?>, 
                    umur <?= isset($value->mt_bio_wali_pasien->umur)?$value->mt_bio_wali_pasien->umur:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> .tahun, 
                    <?= isset($value->mt_bio_wali_pasien->jk)?$value->mt_bio_wali_pasien->jk:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    alamat <?= isset($value->mt_bio_wali_pasien->alamat)?$value->mt_bio_wali_pasien->alamat:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>
                    , dengan ini menyatakan Penolakan untuk  

                    dilakukannya tindakan <?= isset($value->txt_tindakan)?$value->txt_tindakan:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                    terhadap saya /  <?= isset($value->question1)?$value->question1:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> saya* 
                    bernama <?= isset($value->mt_bio_pasien1->nama)?$value->mt_bio_pasien1->nama:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    umur <?= isset($value->mt_bio_pasien1->umur)?$value->mt_bio_pasien1->umur:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> .tahun, 
                    <?= isset($value->mt_bio_pasien1->jk)?$value->mt_bio_pasien1->jk:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    Alamat <?= isset($value->mt_bio_pasien1->alamat)?$value->mt_bio_pasien1->alamat:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                    Saya memahami perlunya dan manfaat tindakan tersebut 
                    sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan komplikasi 
                    yang mungkin timbul. Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, 
                    maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung 
                    kepada izin Tuhan Yang Maha Esa. </p><br><br><br><br>
                    <p style="margin-left:450px">Bukitiinggi, <?= isset($penolakan_kedokteran->tgl_input)? date('d-m-Y h:i',strtotime($penolakan_kedokteran->tgl_input)):''; ?></p>
                    <table width="100%" border="0">
                        <tr>
                            <td  width="30%">
                                <center><span style="text-align:center">Yang menyatakan</span></center>
                                <br><br><br><br><br><br>
                                <p style="text-align:center">
                                    <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) <span><br>
                                    <span>Tanda Tangan & Nama Terang <span> 
                                </p>
                            </td>

                            <td  width="30%">
                            <center><span style="text-align:center">Saksi 1</span> </center>
                            <br><br><br><br><br><br>
                                <p style="text-align:center">
                                <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) <span><br>
                                    <span>Tanda Tangan & Nama Terang <span> 
                                </p>
                            </td>

                            <td  width="40%">
                            <center><span style="text-align:center">Saksi 2</span> </center>
                            <br><br><br><br><br><br>
                                <p style="text-align:center">
                                <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) <span><br>
                                    <span>Tanda Tangan & Nama Terang <span> 
                                </p>
                            </td>
                        </tr>

                    
                    </table>
                    </td>
                </tr>
                
            </table><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    <?php endforeach; ?>
    <?php }}else{ ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><span style="font-size:16px;font-weight:bold">PENOLAKAN TINDAKAN KEDOKTERAN</span></center>

            <table id="data" width="100%" border=1 cellpadding="2px">
                <tr>
                    <td colspan="4" style="text-align:center;font-size:15px;font-weight:bold">PEMBERIAN INFORMASI</td>
                </tr>
                <tr>
                    <td colspan="4">Dokter Pelaksana Tindakan : <?= isset($data->question3)? Explode('-',$data->question3)[0]:'' ?></td>
                </tr>
                <tr>
                    <td colspan="4">Pemberi Informasi : <?= isset($data->question6)? Explode('-',$data->question6)[0]:'' ?></td>
                </tr>
                <tr>
                    <td colspan="4">Penerima informasi/pemberi persetujuan * : <?= isset($data->mt_penelitian->penerima)?$data->mt_penelitian->penerima:'' ?></td>
                </tr>
                <tr>
                    <td colspan="2">Diberikan pada waktu</td>
                    <td>Tanggal :  <?= isset($data->mt_penelitian->wkt)? date('d-m-Y',strtotime($data->mt_penelitian->wkt)):''; ?></td>
                    <td>Jam : <?= isset($data->mt_penelitian->wkt)? date('h:i',strtotime($data->mt_penelitian->wkt)):''; ?></td>
                </tr>
                <tr>
                    <td style="text-align:center;font-size:12px;font-weight:bold">NO</td>
                    <td style="text-align:center;font-size:12px;font-weight:bold">JENIS INFORMASI</td>
                    <td style="text-align:center;font-size:12px;font-weight:bold">ISI INFORMASI</td>
                    <td style="text-align:center;font-size:12px;font-weight:bold">TANDA (√ )</td>
                </tr>
                <tr>
                        <td>1</td>
                        <td>Diagnosis (WD dan DD)</td>
                        <td><?= isset($data->info_penelitian->diagnosis->{'Column 1'})?$data->info_penelitian->diagnosis->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->diagnosis->{'Column 2'}[0])? $data->info_penelitian->diagnosis->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Dasar diagnosis</td>
                        <td><?= isset($data->info_penelitian->tindakan->{'Column 1'})?$data->info_penelitian->tindakan->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->tindakan->{'Column 2'}[0])? $data->info_penelitian->tindakan->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tindakan Medis</td>
                        <td>
                        <?= isset($data->info_penelitian->tindakan_anestesi->{'Column 1'})?$data->info_penelitian->tindakan_anestesi->{'Column 1'}:'' ?>
                        </td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->tindakan_anestesi->{'Column 2'}[0])? $data->info_penelitian->tindakan_anestesi->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Indikasi Tindakan</td>
                        <td><?= isset($data->info_penelitian->indikasi_tind->{'Column 1'})?$data->info_penelitian->indikasi_tind->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->indikasi_tind->{'Column 2'}[0])? $data->info_penelitian->indikasi_tind->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Tata Cara</td>
                        <td><?= isset($data->info_penelitian->tatacara->{'Column 1'})?$data->info_penelitian->tatacara->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->tatacara->{'Column 2'}[0])? $data->info_penelitian->tatacara->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Tujuan</td>
                        <td><?= isset($data->info_penelitian->tujuan->{'Column 1'})?$data->info_penelitian->tujuan->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->tujuan->{'Column 2'}[0])? $data->info_penelitian->tujuan->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Risiko</td>
                        <td><?= isset($data->info_penelitian->risiko->{'Column 1'})?$data->info_penelitian->risiko->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->risiko->{'Column 2'}[0])? $data->info_penelitian->risiko->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Komplikasi</td>
                        <td><?= isset($data->info_penelitian->komplikasi->{'Column 1'})?$data->info_penelitian->komplikasi->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->komplikasi->{'Column 2'}[0])? $data->info_penelitian->komplikasi->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Prognosis</td>
                        <td><?= isset($data->info_penelitian->prognosis->{'Column 1'})?$data->info_penelitian->prognosis->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->prognosis->{'Column 2'}[0])? $data->info_penelitian->prognosis->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Alternatif & Resiko</td>
                        <td><?= isset($data->info_penelitian->alternatif->{'Column 1'})?$data->info_penelitian->alternatif->{'Column 1'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->info_penelitian->alternatif->{'Column 2'}[0])? $data->info_penelitian->alternatif->{'Column 2'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td><?= isset($data->question7[0]->{'Column 1'})?$data->question7[0]->{'Column 1'}:'' ?></td>
                        <td><?= isset($data->question7[0]->{'Column 2'})?$data->question7[0]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question7[0]->{'Column 3'}[0])? $data->question7[0]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td><?= isset($data->question7[1]->{'Column 1'})?$data->question7[1]->{'Column 1'}:'' ?></td>
                        <td><?= isset($data->question7[1]->{'Column 2'})?$data->question7[1]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question7[1]->{'Column 3'}[0])? $data->question7[1]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td><?= isset($data->question7[2]->{'Column 1'})?$data->question7[2]->{'Column 1'}:'' ?></td>
                        <td><?= isset($data->question7[2]->{'Column 2'})?$data->question7[2]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question7[2]->{'Column 3'}[0])? $data->question7[2]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>

                <tr>
                    <td colspan="3">Dengan ini menyatakan bahwa saya telah menerangkan hal-hal di atas secara benar dan jelas dan memberikan kesempatan untuk bertanya dan/atau berdiskusi</td>
                    <td>Tandatangan
                    <br><br><br><br><br><br>
                    </td>
                </tr>

                <tr>
                    <td colspan="3">Dengan ini menyatakan bahwa saya telah menerima informasi sebagaimana di atas yang saya beri tanda/paraf di kolom kanannya serta telah diberi kesempatan untuk bertanya/berdiskusi, dan telah memahaminya</td>
                    <td>Tandatangan
                    <br><br><br><br><br><br>
                    </td>
                </tr>

                <tr>
                    <td colspan="4">* Bila pasien tidak kompeten atau tidak mau menerima informasi, maka penerima informasi adalah wali atau   
                    Keluarga terdekat
                    </td>
                </tr>

                <tr>
                    <td colspan="4"  style="text-align:center;font-size:12px;font-weight:bold">PENOLAKAN TINDAKAN KEDOKTERAN</td>
                </tr>

                <tr>
                    <td colspan="4">
                    <p style="padding:10px;line-break: strict;">
                    Yang bertandatangan di bawah ini, saya , nama 
                    <?= isset($data->mt_bio_wali_pasien->nm)?$data->mt_bio_wali_pasien->nm:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp'; ?>, 
                    umur <?= isset($data->mt_bio_wali_pasien->umur)?$data->mt_bio_wali_pasien->umur:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> .tahun, 
                    <?= isset($data->mt_bio_wali_pasien->jk)?$data->mt_bio_wali_pasien->jk:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    alamat <?= isset($data->mt_bio_wali_pasien->alamat)?$data->mt_bio_wali_pasien->alamat:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>
                    , dengan ini menyatakan Penolakan untuk  

                    dilakukannya tindakan <?= isset($data->txt_tindakan)?$data->txt_tindakan:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                    terhadap saya /  <?= isset($data->question1)?$data->question1:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> saya* 
                    bernama <?= isset($data->mt_bio_pasien1->nama)?$data->mt_bio_pasien1->nama:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    umur <?= isset($data->mt_bio_pasien1->umur)?$data->mt_bio_pasien1->umur:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> .tahun, 
                    <?= isset($data->mt_bio_pasien1->jk)?$data->mt_bio_pasien1->jk:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    Alamat <?= isset($data->mt_bio_pasien1->alamat)?$data->mt_bio_pasien1->alamat:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                    Saya memahami perlunya dan manfaat tindakan tersebut 
                    sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan komplikasi 
                    yang mungkin timbul. Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, 
                    maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung 
                    kepada izin Tuhan Yang Maha Esa. </p><br><br><br><br>
                    <p style="margin-left:450px">Bukitiinggi, <?= isset($penolakan_kedokteran->tgl_input)? date('d-m-Y h:i',strtotime($penolakan_kedokteran->tgl_input)):''; ?></p>
                    <table width="100%" border="0">
                        <tr>
                            <td  width="30%">
                                <center><span style="text-align:center">Yang menyatakan</span></center>
                                <br><br><br><br><br><br>
                                <p style="text-align:center">
                                    <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) <span><br>
                                    <span>Tanda Tangan & Nama Terang <span> 
                                </p>
                            </td>

                            <td  width="30%">
                            <center><span style="text-align:center">Saksi 1</span> </center>
                            <br><br><br><br><br><br>
                                <p style="text-align:center">
                                <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) <span><br>
                                    <span>Tanda Tangan & Nama Terang <span> 
                                </p>
                            </td>

                            <td  width="40%">
                            <center><span style="text-align:center">Saksi 2</span> </center>
                            <br><br><br><br><br><br>
                                <p style="text-align:center">
                                <span>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;) <span><br>
                                    <span>Tanda Tangan & Nama Terang <span> 
                                </p>
                            </td>
                        </tr>

                    
                    </table>
                    </td>
                </tr>
                
            </table><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 1</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>
    <?php } ?>
    </body>
    </html>