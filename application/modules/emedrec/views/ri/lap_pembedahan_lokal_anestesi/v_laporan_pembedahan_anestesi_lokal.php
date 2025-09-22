<?php
$data = (isset($pembedahan_lokal_anestesi->formjson)?json_decode($pembedahan_lokal_anestesi->formjson):''); 
// var_dump($data);
?>
<head>
       <title></title>
   </head>

   <style>
       #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            position: relative;
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
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="border-bottom: 1px solid black;"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>LAPORAN PEMBEDAHAN DENGAN ANESTESI LOKAL</h4></center>
       
            <div style="font-size:12px">
                <table width="100%" id="data" border="1">
                    <tr>
                        <td width="50%">
                            <table width="100%">
                                <tr>
                                    <td width="30%">Ahli bedah</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->question1->ahli_bedah)?$data->question1->ahli_bedah:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Asisten</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->asisten)?$data->question1->asisten:'' ?></td>
                                </tr>
                                
                            </table>
                        </td>

                        <td width="50%">
                            <table width="100%">
                                <tr>
                                    <td width="35%">Instrumentator</td>
                                    <td width="2%">:</td>
                                    <td><?= isset($data->question1->instrumentator)?$data->question1->instrumentator:'' ?></td>
                                </tr>

                                <tr>
                                    <td>Jenis pembiusan</td>
                                    <td>:</td>
                                    <td><?= isset($data->question1->pembiusan)?$data->question1->pembiusan:'' ?></td>
                                </tr>
                                
                            </table>
                        </td>
                    </tr>
                </table>


                <table width="100%" border="1" cellpadding="3px">
                    <tr>
                        <td>
                            <span>Macam pembedahan	:</span><br><br>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("kecil", $data->question2)?'checked':'':'') ?>>
                            <span>Kecil</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("khusus", $data->question2)?'checked':'':'') ?>>
                            <span>Khusus	 1 </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("darurat", $data->question2)?'checked':'':'') ?>>
                            <span>Darurat gawat </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("bersih", $data->question2)?'checked':'':'') ?>>
                            <span>Bersih</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("tercemar", $data->question2)?'checked':'':'') ?>>
                            <span>Tercemar</span><br><br>

                            <input type="checkbox" value="Tidak"  <?= (isset($data->question2)?in_array("sedang", $data->question2)?'checked':'':'') ?>>
                            <span>Sedang</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("Khusus 2", $data->question2)?'checked':'':'') ?>>
                            <span>Khusus 2 </span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("Berencana", $data->question2)?'checked':'':'') ?>>
                            <span>Berencana</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("Bersih tercemar", $data->question2)?'checked':'':'') ?>>
                            <span>Bersih tercemar</span>
                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("Kotor", $data->question2)?'checked':'':'') ?>>
                            <span>Kotor</span><br><br>

                            <input type="checkbox" value="Tidak" <?= (isset($data->question2)?in_array("Besar", $data->question2)?'checked':'':'') ?>>
                            <span>Besar</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Tindakan pra bedah</span>
                            <p style="min-height:50px"><?= isset($data->tindakan)?$data->tindakan:''?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Tindakan pembedahan</span>
                            <p style="min-height:50px"><?= isset($data->tindakan1)?$data->tindakan1:''?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Diagnosa pasca bedah</span>
                            <p style="min-height:50px"><?= isset($data->diagnosa)?$data->diagnosa:''?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Ahli bius :</span>
                            <p style="min-height:30px"><?= isset($data->ahli_bius)?$data->ahli_bius:''?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Cara pembiusan:	<?= isset($data->question3->cara_pembiusan)?$data->question3->cara_pembiusan:''?></span>&nbsp;&nbsp;
                            <span>Mulai: <?= isset($data->question3->mulai)?$data->question3->mulai:''?>	</span>&nbsp;&nbsp;
                            <span>Selesai	: <?= isset($data->question3->selesai)?$data->question3->selesai:''?>	</span>&nbsp;&nbsp;
                            <span>Lama pembedahan	: <?= isset($data->question3->lama_pembedahan)?$data->question3->lama_pembedahan:''?>	</span>&nbsp;&nbsp;
                            <span>OK  : <?= isset($data->question3->ok)?$data->question3->ok:''?>	</span>&nbsp;&nbsp;
                            <br> <br>
                            <span>Posisi pasien: <?= isset($data->question4->posisi)?$data->question4->posisi:''?>	</span>&nbsp;&nbsp;
                            <span>Jam : <?= isset($data->question4->jam)?$data->question4->jam:''?>	</span>&nbsp;&nbsp;
                            <span>Selesai	: <?= isset($data->question4->selesai)?$data->question4->selesai:''?>	</span>&nbsp;&nbsp;
                            <span>Menit : <?= isset($data->question4->jam1)?date('i:s',strtotime($data->question4->jam1)):''?>	</span>&nbsp;&nbsp;
                            
                        </td>
  
                    </tr>
                    <tr>
                        <td>
                            <table width="100%">
                                <tr>
                                    <td width="25%"><span>URAIAN PEMBEDAHAN :</span></td>
                                    <td><span>Uraian dimulai dari bagian tubuh yang dibedah, cara penemuan tindakan yang dilakukan, explorasi, indikasi dan tindakan macam penutupan luka, dengan lengkap dan jelas, jaringan yang dikeluarkan drainage, darah yang keluar</span></td>
                                </tr>
                            </table>
                            <p style="min-height:60px"><?= isset($data->question6)?$data->question6:''?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Komplikasi :</span>
                            <p style="min-height:30px"><?= isset($data->komplikasi)?$data->komplikasi:''?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span>Jaringan dikirim ke patologi : </span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->jangan)? $data->jangan == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->jangan)? $data->jangan == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span><br><br>
                            <span>Asal jaringan :  <?= isset($data->asal)?$data->asal:''?></span>
                        </td>
                    </tr>
                </table>
                <p >Ahli Bedah</p>
                <img  src="<?= (isset($data->ahli_bedah)?$data->ahli_bedah:'')?>"  width="50px"  height="50px" alt=""><br>
                <span>(<?= isset($data->nama)?$data->nama:''?>)</span>
            </div>

            <div style="display:flex;font-size:10px;margin-top:15px">
                <div>
                    Hal 1 dari 1
                </div>
                <div style="margin-left:550px">
                RM-019b/RI
                </div>
           </div>
        </div>

        
    </body>
    </html>