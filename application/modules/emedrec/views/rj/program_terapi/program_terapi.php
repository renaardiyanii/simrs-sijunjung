<?php 

$data = isset($program_terapi_rehab->formjson)?json_decode($program_terapi_rehab->formjson):'';
$data_chunk = isset($data->question3)? array_chunk($data->question3,20):null;
//  var_dump($data_chunk);

?>
<style>
    table tr td {
        font-size: 12px;
        font-family: arial;
    }
    table tr th {
        font-size: 12px;
        font-family: arial;
    }
</style>
   <!DOCTYPE html>
   <html>
   
   <head>
       <title></title>
   </head>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
   <?php
   if($data_chunk):
   foreach($data_chunk as $val):
   ?>

   <body class="A4" >
       <div class="A4 sheet  padding-fix-10mm">
       <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                        <h3>LEMBAR FORMULIR RAWAT JALAN <br> LAYANAN KEDOKTERAN FISI DAN REHABILITAS</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                        </tr>
                        <tr> 
                            <td style="font-size:10px" width="20%">Nama</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">TglLahir</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>


        <table border="1" width="100%" cellpadding="5px">
            <tr>
                <td width="70%" style="font-style:italic">
                    <p>(Diisi Oleh Dokter)</p>
                </td>
                <td style="font-style:italic">
                    <p align="right">Halaman 1 dari 1</p>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <p>Diagnosa : <?= isset($data->question1->diagnosa)?$data->question1->diagnosa:'' ?></p>
                    <p>Permintaan Terapi : <?= isset($data->question1->permintaan_terapi)?$data->question1->permintaan_terapi:'' ?></p>
                    <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="10%" style="font-size: 10px;" rowspan="2">No</th>
                                <th width="30%" style="font-size: 10px;" rowspan="2">Program</th>
                                <th width="10%" style="font-size: 10px;" rowspan="2">Tanggal</th>
                                <th width="40%" style="font-size: 10px;" colspan="3">TTD</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;"><center>Pasien</center></td>
                                <td style="font-size: 10px;"><center>Dokter</center></td>
                                <td style="font-size: 10px;"><center>Terapis</center></td>
                            </tr>

                            <?php 
                            $i = 1;
                            $jml_array = isset($val)?count($val):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                            ?>

                            <tr>
                                <td height="40" style="font-size: 10px;"><center><?= $i++ ?></center></td>
                                <td style="font-size: 10px;"><?= isset($val[$x]->question2[0]->program)?$val[$x]->question2[0]->program:'' ?></td>
                                <td style="font-size: 10px;"><?= isset($val[$x]->question2[0]->tanggal)?date('d-m-Y',strtotime($val[$x]->question2[0]->tanggal)):'' ?></td>
                                <td style="font-size: 10px;"> <img src="<?= isset($val[$x]->question2[0]->ttd_pasien)?$val[$x]->question2[0]->ttd_pasien:'' ?>" alt="img" height="30px" width="30px"></td>
                                <td style="font-size: 10px;"><img src="<?= isset($val[$x]->question2[0]->ttd_dokter)?$val[$x]->question2[0]->ttd_dokter:'' ?>" alt="img" height="30px" width="30px"></td>
                                <td style="font-size: 10px;"><img src="<?= isset($val[$x]->question2[0]->ttd_terapis)?$val[$x]->question2[0]->ttd_terapis:'' ?>" alt="img" height="30px" width="30px"></td>
                            </tr>

                            <?php }
                            
                            if($jml_array<=20){
                            $jml_kurang = 20 - $jml_array;
                            for($x = 0; $x < $jml_kurang; $x++){
                            ?>
                            <tr>
                                <td height="40" style="font-size: 10px;"><center><?= $i++ ?></center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <?php }} ?>
                            
                    </table>
                </td>
            </tr>
                
            </table>
       </div>
     
     
  

   <?php endforeach;else: ?>
    <div class="A4 sheet  padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                        <h3>LEMBAR FORMULIR RAWAT JALAN <br> LAYANAN KEDOKTERAN FISI DAN REHABILITAS</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                        </tr>
                        <tr> 
                            <td style="font-size:10px" width="20%">Nama</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">TglLahir</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 1 dari 1</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <p>Diagnosa : <?= isset($data->question1->diagnosa)?$data->question1->diagnosa:'' ?></p>
                    <p>Permintaan Terapi : <?= isset($data->question1->permintaan_terapi)?$data->question1->permintaan_terapi:'' ?></p>
                    <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="10%" style="font-size: 10px;" rowspan="2">No</th>
                                <th width="30%" style="font-size: 10px;" rowspan="2">Program</th>
                                <th width="10%" style="font-size: 10px;" rowspan="2">Tanggal</th>
                                <th width="40%" style="font-size: 10px;" colspan="3">TTD</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;"><center>Pasien</center></td>
                                <td style="font-size: 10px;"><center>Dokter</center></td>
                                <td style="font-size: 10px;"><center>Terapis</center></td>
                            </tr>
                            <tr>
                                <td height="40"  style="font-size: 10px;"><center>1</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>2</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>3</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>4</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>5</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>6</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>7</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>8</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>9</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>10</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>11</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>12</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>13</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>14</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>15</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>16</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>17</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>18</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>19</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>20</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                
            </table>
       </div>
       <div class="A4 sheet  padding-fix-10mm">
        <table border="1" width="100%" cellpadding="5px" style="margin-top:30px">
            <tr>
                <td width="30%">
                    <table border="0" width="100%">
                        <tr>
                            <td width="30%">
                                <img src="<?= base_url("assets/img/logo.png"); ?>" alt="img" height="60px" width="50px" style="padding-right:15px;">
                            </td>
                            <td width="70%" style="vertical-align:middle">
                                <h3>RSUD AHMAD SYAFII MAARIF</h3>
                            </td>
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
                        <h3>LEMBAR FORMULIR RAWAT JALAN <br> LAYANAN KEDOKTERAN FISI DAN REHABILITAS</h3>
                    </center>
                </td>
                        <td width="30%">
                    <table border="0" width="100%" cellpadding="7px">
                        <tr>
                            <td style="font-size:10px" width="20%">No.RM</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->no_medrec)?$data_pasien->no_medrec:'' ?></td>
                        </tr>
                        <tr> 
                            <td style="font-size:10px" width="20%">Nama</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
                        </tr>
                        <tr>
                            <td style="font-size:10px" width="20%">TglLahir</td>
                            <td style="font-size:10px" width="2%">:</td>
                            <td style="font-size:10px"><?= isset($data_pasien->tgl_lahir)?date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?>
                                <span style="float:right">(<?= isset($data_pasien->sex)?$data_pasien->sex:'' ?>)</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <td width="70%" style="font-style:italic">
                        <p>(Diisi Oleh Dokter)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 2 dari 2 </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                    <p>Diagnosa : <?= isset($data->question1->diagnosa)?$data->question1->diagnosa:'' ?></p>
                    <p>Permintaan Terapi : <?= isset($data->question1->permintaan_terapi)?$data->question1->permintaan_terapi:'' ?></p>
                    <table border="1" width="100%" cellpadding="3">
                            <tr>
                                <th width="10%" style="font-size: 10px;" rowspan="2">No</th>
                                <th width="30%" style="font-size: 10px;" rowspan="2">Program</th>
                                <th width="10%" style="font-size: 10px;" rowspan="2">Tanggal</th>
                                <th width="40%" style="font-size: 10px;" colspan="3">TTD</th>
                            </tr>
                            <tr>
                                <td style="font-size: 10px;"><center>Pasien</center></td>
                                <td style="font-size: 10px;"><center>Dokter</center></td>
                                <td style="font-size: 10px;"><center>Terapis</center></td>
                            </tr>
                            <tr>
                                <td height="40"  style="font-size: 10px;"><center>21</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>22</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>23</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>24</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>25</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>26</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>27</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>28</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>29</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>30</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>31</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>32</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>33</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>34</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>35</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>36</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>37</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>38</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>39</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                            <tr>
                                 <td height="40" style="font-size: 10px;"><center>40</center></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                                <td style="font-size: 10px;"></td>
                            </tr>
                        </table>
                    </td>
                    
                    </tr>
                    
                </tr>
                
            </table>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2024/RM.03.k/RJ </p>
                </div>     
            </div> 
           
       </div>
       

    <?php endif ?>
    </body>
   </html>
   
   