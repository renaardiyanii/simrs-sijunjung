<?php
$data = (isset($persetujuan_kedokteran->formjson)?json_decode($persetujuan_kedokteran->formjson):''); 
$result = array_chunk($persetujuan_kedokteran, 1);
// var_dump($data);
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
            <center><span style="font-size:16px;font-weight:bold">PERSETUJUAN TINDAKAN KEDOKTERAN</span></center>

            <table id="data" width="100%" border=1 cellpadding="2px">
                <tr>
                    <td colspan="4" style="text-align:center;font-size:15px;font-weight:bold">PEMBERIAN INFORMASI</td>
                </tr>
                <tr>
                    <td colspan="4">Dokter Pelaksana Tindakan : <?= isset($value->question4)? Explode('-',$value->question4)[0]:'' ?></td>
                </tr>
                <tr>
                    <td colspan="4">Pemberi Informasi : <?= isset($value->question6)? Explode('-',$value->question6)[0]:'' ?></td>
                </tr>
                <tr>
                    <td colspan="4">Penerima informasi/pemberi persetujuan * : <?= isset($value->question1->text3)?$value->question1->text3:'' ?></td>
                </tr>
                <tr>
                    <td colspan="2">Diberikan pada waktu</td>
                    <td>Tanggal :  <?= isset($value->question1->text4)? date('d-m-Y',strtotime($value->question1->text4)):''; ?></td>
                    <td>Jam : <?= isset($value->question1->text4)? date('h:i',strtotime($value->question1->text4)):''; ?></td>
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
                    <td><?= isset($value->question2->{'Row 1'}->isi_informasi)?$value->question2->{'Row 1'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 1'}->ckls[0])? $value->question2->{'Row 1'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Dasar diagnosis</td>
                    <td><?= isset($value->question2->{'Row 2'}->isi_informasi)?$value->question2->{'Row 2'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 2'}->ckls[0])? $value->question2->{'Row 2'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Tindakan Kedokteran</td>
                    <td><?= isset($value->question2->{'Row 3'}->isi_informasi)?$value->question2->{'Row 3'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 3'}->ckls[0])? $value->question2->{'Row 3'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Indikasi Tindakan</td>
                    <td><?= isset($value->question2->{'Row 4'}->isi_informasi)?$value->question2->{'Row 4'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 4'}->ckls[0])? $value->question2->{'Row 4'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Tata Cara</td>
                    <td><?= isset($value->question2->{'Row 5'}->isi_informasi)?$value->question2->{'Row 5'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 5'}->ckls[0])? $value->question2->{'Row 5'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>6</td>
                    <td>Tujuan</td>
                    <td><?= isset($value->question2->{'Row 6'}->isi_informasi)?$value->question2->{'Row 6'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 6'}->ckls[0])? $value->question2->{'Row 6'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>7</td>
                    <td>Risiko</td>
                    <td><?= isset($value->question2->{'Row 7'}->isi_informasi)?$value->question2->{'Row 7'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 7'}->ckls[0])? $value->question2->{'Row 7'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Komplikasi</td>
                    <td><?= isset($value->question2->{'Row 8'}->isi_informasi)?$value->question2->{'Row 8'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 8'}->ckls[0])? $value->question2->{'Row 8'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Prognosis</td>
                    <td><?= isset($value->question2->{'Row 9'}->isi_informasi)?$value->question2->{'Row 9'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 9'}->ckls[0])? $value->question2->{'Row 9'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>10</td>
                    <td>Alternatif & Resiko</td>
                    <td><?= isset($value->question2->{'Row 10'}->isi_informasi)?$value->question2->{'Row 10'}->isi_informasi:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question2->{'Row 10'}->ckls[0])? $value->question2->{'Row 10'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>11</td>
                    <td><?= isset($value->question14[0]->{'Column 1'})?$value->question14[0]->{'Column 1'}:'' ?></td>
                    <td><?= isset($value->question14[0]->{'Column 2'})?$value->question14[0]->{'Column 2'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question14[0]->{'Column 3'}[0])? $value->question14[0]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>12</td>
                    <td><?= isset($value->question14[1]->{'Column 1'})?$value->question14[1]->{'Column 1'}:'' ?></td>
                    <td><?= isset($value->question14[1]->{'Column 2'})?$value->question14[1]->{'Column 2'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question14[1]->{'Column 3'}[0])? $value->question14[1]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                </tr>
                <tr>
                    <td>13</td>
                    <td><?= isset($value->question14[2]->{'Column 1'})?$value->question14[2]->{'Column 1'}:'' ?></td>
                    <td><?= isset($value->question14[2]->{'Column 2'})?$value->question14[2]->{'Column 2'}:'' ?></td>
                    <td style="text-align:center"><?php echo isset($value->question14[2]->{'Column 3'}[0])? $value->question14[2]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
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
                    <td colspan="4"  style="text-align:center;font-size:12px;font-weight:bold">PERSETUJUAN TINDAKAN KEDOKTERAN</td>
                </tr>

                <tr>
                    <td colspan="4">
                    <p style="padding:10px;line-break: strict;">
                    Yang bertanvaluengan di bawah ini, saya , nama 
                    <?= isset($value->question13->{' '}->{'Column 1'})?$value->question13->{' '}->{'Column 1'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp'; ?>, 
                    tanggal lahir <?= isset($value->question13->{' '}->{'tgl_lahir'})?$value->question13->{' '}->{'tgl_lahir'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    <?= isset($value->question13->{' '}->{'jns_kel3'})?$value->question13->{' '}->{'jns_kel3'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    alamat <?= isset($value->question13->{' '}->{'alamat'})?$value->question13->{' '}->{'alamat'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>
                    , dengan ini menyatakan persetujuan untuk 

                    dilakukannya tindakan <?= isset($value->question10)?$value->question10:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                    terhadap saya /  <?= isset($value->question9)?$value->question9:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> saya* 
                    bernama <?= isset($value->question11->{'Row 1'}->{'Column 1'})?$value->question11->{'Row 1'}->{'Column 1'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    tanggal lahir <?= isset($value->question11->{'Row 1'}->{'Column 2'})?$value->question11->{'Row 1'}->{'Column 2'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    <?= isset($value->question11->{'Row 1'}->{'Column 3'})?$value->question11->{'Row 1'}->{'Column 3'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                    Alamat <?= isset($value->question11->{'Row 1'}->{'Column 4'})?$value->question11->{'Row 1'}->{'Column 4'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                    Saya memahami perlunya dan manfaat tindakan tersebut 
                    sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan komplikasi 
                    yang mungkin timbul. Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, 
                    maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung 
                    kepada izin Tuhan Yang Maha Esa. </p><br><br><br><br>
                    <p style="margin-left:450px">Bukitiinggi, <?= isset($persetujuan_kedokteran->tgl_input)? date('d-m-Y h:i',strtotime($persetujuan_kedokteran->tgl_input)):''; ?></p>
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
                <center><span style="font-size:16px;font-weight:bold">PERSETUJUAN TINDAKAN KEDOKTERAN</span></center>

                <table id="data" width="100%" border=1 cellpadding="2px">
                    <tr>
                        <td colspan="4" style="text-align:center;font-size:15px;font-weight:bold">PEMBERIAN INFORMASI</td>
                    </tr>
                    <tr>
                        <td colspan="4">Dokter Pelaksana Tindakan : <?= isset($data->question4)? Explode('-',$data->question4)[0]:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Pemberi Informasi : <?= isset($data->question6)? Explode('-',$data->question6)[0]:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="4">Penerima informasi/pemberi persetujuan * : <?= isset($data->question1->text3)?$data->question1->text3:'' ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Diberikan pada waktu</td>
                        <td>Tanggal :  <?= isset($data->question1->text4)? date('d-m-Y',strtotime($data->question1->text4)):''; ?></td>
                        <td>Jam : <?= isset($data->question1->text4)? date('h:i',strtotime($data->question1->text4)):''; ?></td>
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
                        <td><?= isset($data->question2->{'Row 1'}->isi_informasi)?$data->question2->{'Row 1'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 1'}->ckls[0])? $data->question2->{'Row 1'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Dasar diagnosis</td>
                        <td><?= isset($data->question2->{'Row 2'}->isi_informasi)?$data->question2->{'Row 2'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 2'}->ckls[0])? $data->question2->{'Row 2'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Tindakan Kedokteran</td>
                        <td><?= isset($data->question2->{'Row 3'}->isi_informasi)?$data->question2->{'Row 3'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 3'}->ckls[0])? $data->question2->{'Row 3'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Indikasi Tindakan</td>
                        <td><?= isset($data->question2->{'Row 4'}->isi_informasi)?$data->question2->{'Row 4'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 4'}->ckls[0])? $data->question2->{'Row 4'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Tata Cara</td>
                        <td><?= isset($data->question2->{'Row 5'}->isi_informasi)?$data->question2->{'Row 5'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 5'}->ckls[0])? $data->question2->{'Row 5'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Tujuan</td>
                        <td><?= isset($data->question2->{'Row 6'}->isi_informasi)?$data->question2->{'Row 6'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 6'}->ckls[0])? $data->question2->{'Row 6'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Risiko</td>
                        <td><?= isset($data->question2->{'Row 7'}->isi_informasi)?$data->question2->{'Row 7'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 7'}->ckls[0])? $data->question2->{'Row 7'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>8</td>
                        <td>Komplikasi</td>
                        <td><?= isset($data->question2->{'Row 8'}->isi_informasi)?$data->question2->{'Row 8'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 8'}->ckls[0])? $data->question2->{'Row 8'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>9</td>
                        <td>Prognosis</td>
                        <td><?= isset($data->question2->{'Row 9'}->isi_informasi)?$data->question2->{'Row 9'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 9'}->ckls[0])? $data->question2->{'Row 9'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>10</td>
                        <td>Alternatif & Resiko</td>
                        <td><?= isset($data->question2->{'Row 10'}->isi_informasi)?$data->question2->{'Row 10'}->isi_informasi:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question2->{'Row 10'}->ckls[0])? $data->question2->{'Row 10'}->ckls[0] == "1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>11</td>
                        <td><?= isset($data->question14[0]->{'Column 1'})?$data->question14[0]->{'Column 1'}:'' ?></td>
                        <td><?= isset($data->question14[0]->{'Column 2'})?$data->question14[0]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question14[0]->{'Column 3'}[0])? $data->question14[0]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>12</td>
                        <td><?= isset($data->question14[1]->{'Column 1'})?$data->question14[1]->{'Column 1'}:'' ?></td>
                        <td><?= isset($data->question14[1]->{'Column 2'})?$data->question14[1]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question14[1]->{'Column 3'}[0])? $data->question14[1]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
                    </tr>
                    <tr>
                        <td>13</td>
                        <td><?= isset($data->question14[2]->{'Column 1'})?$data->question14[2]->{'Column 1'}:'' ?></td>
                        <td><?= isset($data->question14[2]->{'Column 2'})?$data->question14[2]->{'Column 2'}:'' ?></td>
                        <td style="text-align:center"><?php echo isset($data->question14[2]->{'Column 3'}[0])? $data->question14[2]->{'Column 3'}[0] == "item1" ? "√ ":'':'' ?></td>
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
                        <td colspan="4"  style="text-align:center;font-size:12px;font-weight:bold">PERSETUJUAN TINDAKAN KEDOKTERAN</td>
                    </tr>

                    <tr>
                        <td colspan="4">
                        <p style="padding:10px;line-break: strict;">
                        Yang bertandatangan di bawah ini, saya , nama 
                        <?= isset($data->question13->{' '}->{'Column 1'})?$data->question13->{' '}->{'Column 1'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp'; ?>, 
                        tanggal lahir <?= isset($data->question13->{' '}->{'tgl_lahir'})?$data->question13->{' '}->{'tgl_lahir'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                        <?= isset($data->question13->{' '}->{'jns_kel3'})?$data->question13->{' '}->{'jns_kel3'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                        alamat <?= isset($data->question13->{' '}->{'alamat'})?$data->question13->{' '}->{'alamat'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>
                        , dengan ini menyatakan persetujuan untuk 

                        dilakukannya tindakan <?= isset($data->question10)?$data->question10:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                        terhadap saya /  <?= isset($data->question9)?$data->question9:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> saya* 
                        bernama <?= isset($data->question11->{'Row 1'}->{'Column 1'})?$data->question11->{'Row 1'}->{'Column 1'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                        tanggal lahir <?= isset($data->question11->{'Row 1'}->{'Column 2'})?$data->question11->{'Row 1'}->{'Column 2'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                        <?= isset($data->question11->{'Row 1'}->{'Column 3'})?$data->question11->{'Row 1'}->{'Column 3'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?>, 
                        Alamat <?= isset($data->question11->{'Row 1'}->{'Column 4'})?$data->question11->{'Row 1'}->{'Column 4'}:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp' ?> 
                        Saya memahami perlunya dan manfaat tindakan tersebut 
                        sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan komplikasi 
                        yang mungkin timbul. Saya juga menyadari bahwa oleh karena ilmu kedokteran bukanlah ilmu pasti, 
                        maka keberhasilan tindakan kedokteran bukanlah keniscayaan, melainkan sangat bergantung 
                        kepada izin Tuhan Yang Maha Esa. </p><br><br><br><br>
                        <p style="margin-left:450px">Bukitiinggi, <?= isset($persetujuan_kedokteran->tgl_input)? date('d-m-Y h:i',strtotime($persetujuan_kedokteran->tgl_input)):''; ?></p>
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