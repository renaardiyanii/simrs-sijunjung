<?php
 $data = (isset($catatan_observasi->formjson)?json_decode($catatan_observasi->formjson):'');
// var_dump(intval($data->question1[0]->total_skor));
?>
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
            font-size: 10px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }

        .penanda{
            background-color:#3498db; 
            color:white;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4">

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div><br>

            <center><span style="font-size:15px;font-weight:bold">CATATAN OBSERVASI KHUSUS DAN PENGKAJIAN NYERI</span></center>

            <table width="100%" border="1" cellpadding="5px" id="data">
                <tr>
                    <td width="50%">
                        <span style="font-weight:bold">Skor Nyeri</span><br>
                        <span style="font-weight:bold"> 0    :  Tidak Ada Nyeri</span><br>
                        <span style="font-weight:bold"> 10  :  Nyeri Yang Sangat Berat</span><br>
                        
                        <table width="100%" cellpadding="7px">
                            <tr>
                                <td style="font-weight:bold" width="30%">Skor Nyeri</td>
                                <td style="font-weight:bold" width="70%">Intervensi Yang Disarankan</td>
                            </tr>
                            <tr class="<?= isset($data->question1[0]->total_skor)?intval($data->question1[0]->total_skor)<=3?"penanda":"":''; ?>">
                                <td style="font-weight:bold">0 - 3</td>
                                <td>
                                    <span >1. Lanjutkan observasi</span><br>
                                    2. Tindakan keperawatan untuk mengurangi nyeri
                                </td>
                            </tr>
                            <tr class="<?= isset($data->question1[0]->total_skor)?intval($data->question1[0]->total_skor)<=7 && intval($data->question1[0]->total_skor)>=4?"penanda":"":''; ?>">
                                <td style="font-weight:bold">4 - 7</td>
                                <td>Pertimbangkan pemberian analgesik</td>
                            </tr>
                            <tr  class="<?= isset($data->question1[0]->total_skor)?intval($data->question1[0]->total_skor)<=10 && intval($data->question1[0]->total_skor)>=8?"penanda":"":''; ?>">
                                <td style="font-weight:bold">8 - 10 </td>
                                <td>Berikan analgesia sesuai order </td>
                            </tr>
                        </table>
                            <br><br><br><br><br><br>
                        <span style="font-weight:bold">Hubungi DPJP bila skala nyeri > 3</span>
                    </td>

                    <td>
                        <span style="font-weight:bold">Skor Sedasi</span>
                        <table width="100%" cellpadding="5px">
                            <tr>
                                <td style="font-weight:bold" width="10%">Skor</td>
                                <td style="font-weight:bold" width="45%">Deskripsi</td>
                                <td style="font-weight:bold" width="45%">Intervensi Yang Disarankan</td>
                            </tr>

                            <tr class="<?= isset($data->question2[0]->total_skor)?intval($data->question2[0]->total_skor)==0?"penanda":"":''; ?>">
                                <td style="font-weight:bold">0</td>
                                <td>Sadar penuh dan dapat berbicara</td>
                                <td></td>
                            </tr>

                            <tr class="<?= isset($data->question2[0]->total_skor)?intval($data->question2[0]->total_skor)==1?"penanda":"":''; ?>">
                                <td style="font-weight:bold">1</td>
                                <td>Ringan : kadang - kadang tertidur, mudah dibangunkan, bangun dengan sendirinya</td>
                                <td>Lanjutkan observasi atau ganti sedasinya</td>
                            </tr>

                            <tr class="<?= isset($data->question2[0]->total_skor)?intval($data->question2[0]->total_skor)==2?"penanda":"":''; ?>">
                                <td style="font-weight:bold">2</td>
                                <td>Sedang : sering tertidur, mudah dibangunkan, bangun dengan rangsangan</td>
                                <td>Lanjutkan observasi atau ganti sedasinya</td>
                            </tr>

                            <tr class="<?= isset($data->question2[0]->total_skor)?intval($data->question2[0]->total_skor)==3?"penanda":"":''; ?>">
                                <td style="font-weight:bold">3</td>
                                <td>Berat : sangat mengantuk, susah dibangunkan, tertidur saat berbicara</td>
                                <td>Pertimbangkan naloxone dosis rendah  ( sesuai order dokter )</td>
                            </tr>

                            <tr class="<?= isset($data->question2[0]->total_skor)?intval($data->question2[0]->total_skor)==4?"penanda":"":''; ?>">
                                <td style="font-weight:bold">4</td>
                                <td>Tidak Sadar : Tidak  berespon terhadap respon nyeri</td>
                                <td>Review medik segera</td>
                            </tr>

                            <tr class="<?= isset($data->question2[0]->total_skor)?intval($data->question2[0]->total_skor)=='x'?"penanda":"":''; ?>">
                                <td style="font-weight:bold">x</td>
                                <td>Tidur normal</td>
                                <td>Pastikan pasien tidur dan bukan karena sedasi</td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <table width="100%" border="1" cellpadding="5px" id="data">
                <tr>
                    <td>Hari Rawat</td>
                    <td rowspan="2" colspan="7" style="text-align:center">Tanda - Tanda Vital</td>
                    <td colspan="4" style="text-align:center">Pengkajian Nyeri</td>
                    <td rowspan="3">PARAF STAF</td>
                </tr>

                <tr>
                    <td>Tgl/Bln/Thn</td>
                    <td colspan="2" style="text-align:center">Skala</td>
                    <td rowspan="2" colspan="2" style="text-align:center">Intervensi / Keterangan</td>
                    
                </tr>

                <tr>
                    <td>Jam</td>
                    <td>S</td>
                    <td>N</td>
                    <td>P</td>
                    <td>TD</td>
                    <td>SpO2</td>
                    <td>O2</td>
                    <td>Skor Sedasi</td>
                    <td>Istirahat</td>
                    <td>Aktifitas</td>
                </tr>

                <?php
                $no=1; 
                $jml_array = isset($data->question3)?count($data->question3):'';
                for ($x = 0; $x < $jml_array; $x++) {
                ?>
                <tr>
                    <td>
                        <?= isset($data->question3[$x]->hari)?$data->question3[$x]->hari:'' ?><br>
                        <?= isset($data->question3[$x]->tgl)?$data->question3[$x]->tgl:'' ?><br>
                        <?= isset($data->question3[$x]->jam)?$data->question3[$x]->jam:'' ?>
                    </td>
                    <td><?= isset($data->question3[$x]->s)?$data->question3[$x]->s:'' ?></td>
                    <td><?= isset($data->question3[$x]->n)?$data->question3[$x]->n:'' ?></td>
                    <td><?= isset($data->question3[$x]->p)?$data->question3[$x]->p:'' ?></td>
                    <td><?= isset($data->question3[$x]->td)?$data->question3[$x]->td:'' ?></td>
                    <td><?= isset($data->question3[$x]->sp02)?$data->question3[$x]->sp02:'' ?></td>
                    <td><?= isset($data->question3[$x]->o2)?$data->question3[$x]->o2:'' ?></td>
                    <td><?= isset($data->question3[$x]->sedasi)?$data->question3[$x]->sedasi:'' ?></td>
                    <td><?= isset($data->question3[$x]->istirahat)?$data->question3[$x]->istirahat:'' ?></td>
                    <td><?= isset($data->question3[$x]->aktivitas)?$data->question3[$x]->aktivitas:'' ?></td>
                    <td><?= isset($data->question3[$x]->intervensi)?$data->question3[$x]->intervensi:'' ?></td>
                    <td></td>
                    <td><img  src="<?= (isset($data->question3[$x]->paraf)?$data->question3[$x]->paraf:'')?>" width="40px"  height="40px" alt=""><br>  </td>
                </tr>

                <?php } ?>
            </table>
<br>
            <div style="display:flex;font-size:10px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:550px">
                    RM-006a/RI
                </div>
           </div>
            
           
        </div>

    </body>
</html>