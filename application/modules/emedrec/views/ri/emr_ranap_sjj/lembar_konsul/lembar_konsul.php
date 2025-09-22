<?php 

// var_dump($konsul);die();

if($konsul){ ?>
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<html>

<?php foreach($konsul as $val){ 
    $data = isset($val->formjson)?json_decode($val->formjson):'';
?>

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        
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
                    <h3>LEMBAR KONSULTASI <br> (Penderita Dirawat)</h3>
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
            <td >Halaman 1 dari 2</td>
            
        </tr>
        <tr>
              <td width="40%"> &nbsp; &nbsp;
                    <p style="margin: 5px;">Yth :  <span style="border-bottom: 1px dotted black; width: 80px;"><?= isset($val->dokter_konsulen)?$val->dokter_konsulen:'' ?></span></p>
                      <p style="margin: 5px; font-size: small;">( Konsulen yang diminta )</p>
              </td>
              <td width="40%">&nbsp; &nbsp;
                     <p style="margin: 5px; text-align: center;">Bagian/ Sub Bagian yang diminta</p>
                       <p style="margin: 5px; text-align: center; border-bottom: 1px dotted black;"><?= isset($data->bagian_sub)?$data->bagian_sub:'' ?></p>
              </td>
              <td width="20%">&nbsp; &nbsp;
                <p style="margin: 5px;">Tanggal : <span style="border-bottom: 1px dotted black; width: 80px; display: inline-block;"><?= isset($val->tgl_konsul)?date('d-m-Y',strtotime($val->tgl_konsul)):'' ?></span></p>
              </td>
         </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
                <p style="margin-top: 10px;">PENDERITA KAMI RAWAT DENGAN: <?= isset($data->penderita->penderita1)?$data->penderita->penderita1:'' ?></span></p>

                <p>DIAGNOSIS KERJA: <?= isset($data->penderita->diagnosis)?$data->penderita->diagnosis:'' ?></span></p>

                <p>TANDA PEMERIKSAAN KAMI TERMUKAN:</p>
                <p>(Ikhtisar Klinis):</p>
                <div style="min-height:50px">
                    <?= isset($data->ikhtisar)?$data->ikhtisar:'' ?>
                </div>

                <p>Kesimpulan:</p>
                <div style="min-height:50px">
                    <?= isset($data->kesimpulan)?$data->kesimpulan:'' ?>
                </div>

                <p>Konsul yang diminta:</p>
                <div style="min-height:50px">
                    <?= isset($data->konsul)?$data->konsul:'' ?>
                </div>

                <p>KONSULEN DIHARAPKAN:</p>
                <p>
                    <input type="checkbox" <?= (isset($data->konsulen)?in_array("pendapat", $data->konsulen)?'checked':'':'') ?>> MEMBERIKAN PENDAPAT DIBIDANG TS<br>
                    <input type="checkbox" <?= (isset($data->konsulen)?in_array("advis", $data->konsulen)?'checked':'':'') ?>> MEMBERI ADVIS PENGOBATAN<br>
                    <input type="checkbox" <?= (isset($data->konsulen)?in_array("alih_pengobatan", $data->konsulen)?'checked':'':'') ?>> MENGAMBIL ALIH PENGOBATAN<br>
                    <input type="checkbox" <?= (isset($data->konsulen)?in_array("rawat_bersama", $data->konsulen)?'checked':'':'') ?>> RAWAT BERSAMA
                </p>

                <p>DEMIKIANLAH HARAPAN KAMI, SEMOGA TS MAKLUM</p>
                <p>ATAS PERHATIAN DAN KERJA SAMA DIUCAPKAN TERIMA KASIH</p>

                <p style="text-align: right;">Tanah Badantuang, <?= isset($data->question6)?date('d-m-Y',strtotime($data->question6)):'' ?></span></p>
                <p  style="text-align: right;"><img width="60px" src="<?= isset($dokter_rawat->ttd)?$dokter_rawat->ttd:'' ?>" alt="Tanda Tangan"></p>
                 <p  style="text-align: right;">(<?= isset($dokter_rawat->name)?$dokter_rawat->name:'' ?>)</p>
            </td>
       </tr>
    </table>
    <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.11.a/RI
                    </div>
               </div>
    </div>
</div>
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
                <h3>LEMBAR KONSULTASI <br> (Penderita Dirawat)</h3>
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
            <td >Halaman 2 dari 2</td>
            
        </tr>
        <tr>
             <td style="padding: 10px;" colspan="3"><center>LEMBARAN KONSULTASI <br> <span style="font-weight: normal;">&nbsp;&nbsp;(Jawaban Konsul)</span></center></td>
         </tr>
         <tr>
            <td style="padding: 10px;" colspan="3"><center>PENDAPAT KONSULEN</center>&nbsp;&nbsp;</td>
         </tr>
    </table>
    <table border="1" width="100%" cellpadding="5px" style="margin-top:0px">
       
       <tr>
            <td colspan="4">
           
                    <p style="margin-top: 10px;">Yth. TS <?= isset($val->dokter)?$val->dokter:'' ?></span></p>

                    <p>Membalas konsul TS, dengan ini kami telah memeriksa penderita:</p>

                    <p>Penemuan :</p>
                    <div style="min-height:50px">
                        <?= isset($data->penemuan)?$data->penemuan:$val->penemuan ?>
                    </div>


                    <p>Kesimpulan:</p>
                    <div style="min-height:50px">
                        <?= isset($data->question2)?$data->question2:$val->kesimpulan ?>
                    </div>

                    <p>Anjuran :</p>
                    <div style="min-height:50px">
                        <?= isset($data->question3)?$data->question3:$val->anjuran ?>
                    </div>

                    <p>Atas perhatian dan kerjasama diucapkan terima kasih.</p>

                    <p>CATATAN : kami setuju/tidak setuju pindah rawat/rawat bersama</p>
                    <?php 
                    if(isset($data->question1)){ ?>
                    <p>
                        <input type="checkbox" <?php echo isset($data->question1)? $data->question1 == "setuju" ? "checked":'':'' ?>> Kami Setuju<br>
                        <input type="checkbox" <?php echo isset($data->question1)? $data->question1 == "tidak" ? "checked":'':'' ?>> Tidak Setuju Pindah Rawat<br>
                        <input type="checkbox" <?php echo isset($data->question1)? $data->question1 == "rawat" ? "checked":'':'' ?>> Rawat Bersama<br>
                    </p>
                    <?php }else{ ?>
                        <p>
                            <input type="checkbox" <?php echo isset($val->catatan)? $val->catatan == "Kami Setuju" ? "checked":'':'' ?>> Kami Setuju<br>
                            <input type="checkbox" <?php echo isset($val->catatan)? $val->catatan == "Tidak Setuju Pindah Rawat" ? "checked":'':'' ?>> Tidak Setuju Pindah Rawat<br>
                            <input type="checkbox" <?php echo isset($val->catatan)? $val->catatan == "Rawat Bersama" ? "checked":'':'' ?>> Rawat Bersama<br>
                        </p>
                   <?php  }
                    ?>
                   
                    <p style="text-align: right;">Tanah Badantuang,  <?= isset($data->question5)?date('d-m-Y',strtotime($data->question5)):date('d-m-Y',strtotime($val->tgl_jawaban)) ?></span></p><br><br><br>
                    <p style="text-align: right;">Dokter Konsulen</span></p> 
                    <?php
                                    $id = isset($val->dokter_konsul)?$val->dokter_konsul:null;                           
                                                                                $query = $id?$this->db->query("SELECT
                                                ttd 
                                            FROM
                                                hmis_users
                                                LEFT JOIN dyn_user_dokter ON hmis_users.userid = dyn_user_dokter.userid 
                                            WHERE
                                                dyn_user_dokter.id_dokter = $id")->row():null;

                                    ?>
                                   
                                    
                                <p style="text-align: right;"> <img width="70px" src="<?= isset($query->ttd)?$query->ttd:'' ?>" alt=""><br></p>
                                <p style="text-align: right;"><span>( <?= isset($val->dokter_konsulen)?$val->dokter_konsulen:'' ?> )</span><br></p>
                    
           
            </td>
       </tr>
    </table>
    <div style="margin-left:580px; font-size:12px;">
                Rev.I.I/2018/RM.11.a/RI
                    </div>
               </div>
    </div>
</div>
</body>
<?php }}else { ?>

   

<?php }
?>


