<?php
$data = (isset($data_laporan_persalinan->formjson)?json_decode($data_laporan_persalinan->formjson):'');
//  var_dump($data);
?>

<!DOCTYPE html>
   <html>

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

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <center><h4>LAPORAN PERSALINAN</h4></center>

            <div style="font-size:12px">

                <p>Keadaan ibu pasca persalinan</p>

                <table width="100%">
                    <tr>
                        <td width="23%">Keadaan umum</td>
                        <td width="2%">:</td>
                        <td width="75%"><?= isset($data->keadaan_umum)?$data->keadaan_umum:'' ?></td>
                    </tr>

                    <tr>
                        <td width="23%"><p>Nadi</td>
                        <td width="2%"><p>:</p></td>
                        <td width="75%"><p>
                            <span><?= isset($data->question2->nadi)?$data->question2->nadi.' '.'x/mnt':'' ?></span>
                            <span style="margin-left:10px">Tekanan darah <?= isset($data->question2->tekanan_darah)?$data->question2->tekanan_darah.' '.'mmHg':'' ?> </span>
                            <span style="margin-left:10px">Suhu <?= isset($data->question2->suhu)?$data->question2->suhu.' '.'°C':'' ?> </span>
                            <span style="margin-left:10px">Hb <?= isset($data->question2->hb)?$data->question2->hb.' '.'g%':'' ?> </span>
                        </p></td>
                    </tr>

                    <tr>
                        <td width="23%">Uterus</td>
                        <td width="2%">:</td>
                        <td width="75%"><?= isset($data->uterus)?$data->uterus:'' ?></td>
                    </tr>

                    <tr>
                        <td width="23%"><p>Perdarahan kala III</p></td>
                        <td width="2%"><p>:<p></td>
                        <td width="75%"><p>
                            <span><?= isset($data->perdarahan->perdarahan_kala2)?$data->perdarahan->perdarahan_kala2.' '.'cc':'' ?> </span>
                            <span style="margin-left:40px">Kala IV : <?= isset($data->perdarahan->kala_iv)?$data->perdarahan->kala_iv.' '.'cc':'' ?></span></p>
                        </td>
                    </tr>
                </table>

                <table width="100%" border="0">
                    <tr>
                        <td width="10%" rowspan="2">Placeta :</td>
                        <td width="13%">Bentuk/ukuran</td>
                        <td width="2%">:</td>
                        <td width="20%"><?= isset($data->planceta->bentuk_ukuran)?$data->planceta->bentuk_ukuran:'' ?> </td>
                        <td width="25%">Cairan Ketuban</td>
                        <td width="5%">:</td>
                        <td width="20%"><?= isset($data->planceta->cairan_ketuban)?$data->planceta->cairan_ketuban:'' ?></td>
                    </tr>

                    <tr>
                      
                        <td width="13%">Tali Pusat</td>
                        <td width="2%">:</td>
                        <td width="20%"><?= isset($data->planceta->tali_pusat)?$data->planceta->tali_pusat:'' ?></td>
                        <td width="25%"></td>
                        <td width="5%"></td>
                        <td width="20%"></td>
                    </tr>

                    <tr>
                        <td width="10%" rowspan="5">Anak :</td>
                        <td width="13%"></td>
                        <td width="2%"></td>
                        <td width="20%"></td>
                        <td width="25%"></td>
                        <td width="5%"></td>
                        <td width="20%"></td>
                    </tr>

                    <tr>
                        
                        <td width="13%">Jenis Kelamin</td>
                        <td width="2%">:</td>
                        <td width="20%"><?= isset($data->question1)?$data->question1:'' ?></td>
                        <td width="25%">Lahir </td>
                        <td width="5%">:</td>
                        <td width="20%"><?= isset($data->question5)?$data->question5:'' ?></td>
                    </tr>

                    <tr>
                       
                        <td width="13%">Berat badan</td>
                        <td width="2%">:</td>
                        <td width="20%"><?= isset($data->question3->berat_badan)?$data->question3->berat_badan:'' ?></td>
                        <td width="25%">Panjang Badan</td>
                        <td width="5%">:</td>
                        <td width="20%"><?= isset($data->question3->panjang_badan)?$data->question3->panjang_badan:'' ?></td>
                    </tr>

                    <tr>
                      
                        <td width="13%">Lingkar dada</td>
                        <td width="2%">:</td>
                        <td width="20%"><?= isset($data->question3->lingkar_dada)?$data->question3->lingkar_dada:'' ?></td>
                        <td width="25%">Lingkar kepala</td>
                        <td width="5%">:</td>
                        <td width="20%"><?= isset($data->question3->lingkar_kepala)?$data->question3->lingkar_kepala:'' ?></td>
                    </tr>

                    <tr>
                      
                      <td width="13%">Kelainan kongenital</td>
                      <td width="2%">:</td>
                      <td width="20%" colspan ="4"><?= isset($data->question3->kelainan_kongenital)?$data->question3->kelainan_kongenital:'' ?></td>
                     
                  </tr>

                  
                </table>

                <p>Untuk bayi yang keadaan jelek : lahir hidup kemudian meninggal :  <?= isset($data->bayi)?$data->bayi:'' ?> jam post partum</p>
                <p>
                    <span>Bayi lahir mati : <?= isset($data->bayi_lahir->bayi_lahir_mati)?$data->bayi_lahir->bayi_lahir_mati:'' ?></span>
                    <span>Sebab kelahiran mati : <?= isset($data->bayi_lahir->sebab_kelahiran)?$data->bayi_lahir->sebab_kelahiran:'' ?></span>
                </p>

                <table  width="100%" border="1">
                    <tr>
                        <th width ="15%">0</th>
                        <th width ="15%">1</th>
                        <th width ="15%">2</th>
                        <th width ="20%">APGAR SCORE</th>
                        <th width ="20%" style="text-align:center">1 Menit</th>
                        <th width ="15%" style="text-align:center">5 Menit</th>
                    </tr>
                    <tr>
                        <td>Tak ada</td>
                        <td>< 100</td>
                        <td>> 100</td>
                        <td>Denyut jantung</td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 1'}->{'1'})?$data->question4->{'Row 1'}->{'1'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 2'}->{'1'})?$data->question4->{'Row 2'}->{'1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tak ada</td>
                        <td>Tak teratur</td>
                        <td>Baik</td>
                        <td>Pernafasan</td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 1'}->{'2'})?$data->question4->{'Row 1'}->{'2'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 2'}->{'2'})?$data->question4->{'Row 2'}->{'2'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Lumpuh</td>
                        <td>Fleksi Sedikit</td>
                        <td>Gerakan Aktif</td>
                        <td>Tonus otot</td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 1'}->{'3'})?$data->question4->{'Row 1'}->{'3'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 2'}->{'3'})?$data->question4->{'Row 2'}->{'3'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Tidak Ada</td>
                        <td></td>
                        <td>Menangis Kuat</td>
                        <td>Peka rangsangan</td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 1'}->{'4'})?$data->question4->{'Row 1'}->{'4'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 2'}->{'4'})?$data->question4->{'Row 2'}->{'4'}:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pucat</td>
                        <td>Badan merah estermitas biru</td>
                        <td>Merah jambu</td>
                        <td>Warna</td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 1'}->{'5'})?$data->question4->{'Row 1'}->{'5'}:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 2'}->{'5'})?$data->question4->{'Row 2'}->{'5'}:'' ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Total</td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 1'}->total_skor)?$data->question4->{'Row 1'}->total_skor:'' ?></td>
                        <td style="text-align:center"><?= isset($data->question4->{'Row 2'}->total_skor)?$data->question4->{'Row 2'}->total_skor:'' ?></td>
                    </tr>
                </table>

                <table width="100%">
                    <tr>
                        <td width="23%"><p>Iktisar persalinan</p></td>
                        <td width="2%"><p></p></td>
                        <td width="70%"><p></p></td>
                    </tr>

                    <tr>
                        <td width="23%">Ketuban pecah tgl</td>
                        <td width="2%">:</td>
                        <td width="70%">
                            <span><?= isset($data->iktisar->ketuban_pecah)? date('d-m-Y',strtotime($data->iktisar->ketuban_pecah)):''; ?></span>
                            <span>jam <?= isset($data->iktisar->ketuban_pecah)? date('H:i',strtotime($data->iktisar->ketuban_pecah)):''; ?></span>
                            <span>Lahir tanggal <?= isset($data->iktisar->lahir)? date('d-m-Y',strtotime($data->iktisar->lahir)):''; ?></span>
                            <span>jam <?= isset($data->iktisar->lahir)? date('H:i',strtotime($data->iktisar->lahir)):''; ?></span>
                        </td>
                    </tr>

                    <tr>
                        <td width="23%"><p>Macam persalinan</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="70%"><p><?= isset($data->iktisar->macam_persalinan)?$data->iktisar->macam_persalinan:'' ?></p></td>
                    </tr>

                    <tr>
                        <td width="23%">Indikasi</td>
                        <td width="2%">:</td>
                        <td width="70%"><?= isset($data->iktisar->indikasi)?$data->iktisar->indikasi:'' ?></td>
                    </tr>

                    <tr>
                        <td width="23%"><p>Lama persalinan</p></td>
                        <td width="2%"><p>:</p></td>
                        <td width="70%"><p><?= isset($data->iktisar->lama_persalinan)?$data->iktisar->lama_persalinan:'' ?></p></td>
                    </tr>

                    <tr>
                        <td width="23%">Lain lain</td>
                        <td width="2%">:</td>
                        <td width="70%"><?= isset($data->iktisar->lainnya)?$data->iktisar->lainnya:'' ?></td>
                    </tr>
                </table><br><br>

                <table width="100%">
                    <tr>
                        <td width="70%"></td>
                        <td>
                            <p>Penolong Persalinan

                            <?php
                        $id =isset($data_laporan_persalinan->id_pemeriksa)?$data_laporan_persalinan->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                            <img width="100px" src="<?= $query->ttd ?>" alt=""><br>
                            <span>(<?= (isset($query->name)?$query->name:'')?>)</span><br>  
                        <?php
                            } else {?>
                                <br><br><br>
                                <span>()</span><br>
                        <?php } ?>

                            Nama jelas dan tanda tangan
                            </p>
                        <td>
                    </tr>
                </table>

            </div>
            <br><br><br> <br><br><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    </body>
</html>