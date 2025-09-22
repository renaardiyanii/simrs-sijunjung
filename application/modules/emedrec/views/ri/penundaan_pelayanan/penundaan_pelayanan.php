<?php
$data = (isset($pelayanan->formjson)?json_decode($pelayanan->formjson):'');
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
            font-size: 10px;
            position: relative;
        }

        #data tr td{
            
            font-size: 10px;
            
        }
        #footer{
            position: relative;
        }

        #place{
            position: absolute;
            right: 30px;
        }

        #name_dokter{
            position: absolute;
            right: 80px;
            top: 20px;
            font-weight: bold;
        }

        #ttd_dokter{
            position: absolute;
            right: 50px;
            top: 100px;
        }

        #text-footer1{
            position: absolute;
            right: 10px;
            top: 250px;
        }

        #text-footer2{
            position: absolute;
            left: 10px;
            top: 250px;
        }
       
   </style>
   
   <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
   <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
   
    <body class="A4" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>

            <center><h4>PENUNDAAN PELAYANAN</h4></center>

            <div style="font-size:12px;min-height:870px">

                <p>Saya yang bertanda tangan di bawah ini yang menerima informasi :</p>

                <p>*Pasien sendiri / keluarga pasien atau penanggung jawab pasien, nama <?= isset($data->question1->nama)?$data->question1->nama:'' ?></p>
                <table>
                    <tr>
                        <td>Poli / Ruangan</td>
                        <td>: <?= isset($data->question1->poli)?$data->question1->poli:'' ?></td>
                    </tr>
                    <tr>
                        <td>Nama dokter Pengirim</td>
                        <td>: <?= isset($data->question1->nm_dokter)?$data->question1->nm_dokter:'' ?></td>
                    </tr>
                    <tr>
                        <td>Pelayanan yang akan di lakukan </td>
                        <td>: <?= isset($data->question1->pelayanan)?$data->question1->pelayanan:'' ?></td>
                    </tr>
                </table>
                <br>
                <p>Dengan ini menyatakan bahwa saya telah menerima informasi terhadap penundaan pelayanan dikarenakan : </p>

                <ul style="list-style-type: none;">
                    <li>
                        <input type="checkbox" <?= (isset($data->question2)?in_array("kerusakan", $data->question2)?'checked':'':'') ?>>
                        <label for="">Kerusakan Alat</label>
                    </li>
                    <li>
                        <input type="checkbox" <?= (isset($data->question2)?in_array("kondisi", $data->question2)?'checked':'':'') ?>>
                        <label for="">Kondisi Umum Pasien</label>
                    </li>
                    <li>
                        <input type="checkbox" <?= (isset($data->question2)?in_array("penundaan", $data->question2)?'checked':'':'') ?>>
                        <label for="">Penundaan Penjadwalan</label>
                    </li>
                    <li>
                        <input type="checkbox" <?= (isset($data->question2)?in_array("pemadaman", $data->question2)?'checked':'':'') ?>>
                        <label for="">Pemadaman Instalasi Listrik</label>
                    </li>
                </ul>

                <p>Maka dengan ini saya <b> Setuju</b> untuk dilakukan Penundaan Pelayanan dengan alternatif yang diberikan : </p>

                <ul style="list-style-type: none;">
                    <li>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "other" ? "checked":'':'' ?>>
                        <label for="">Dijadwalkan ulang dan menjadi prioritas.</label><br>
                        <label for="" style="margin-left: 20px;">Jadwal yang akan datang : <?= isset($data->{'question3-Comment'})?:'' ?></label>
                    </li>
                    <li>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item2" ? "checked":'':'' ?>>
                        <label for="">Dirujuk ke Layanan kesehatan lain, ke <?= isset($data->rujuk_ke)?$data->rujuk_ke:'' ?>.</label>
                    </li>
                    <li>
                        <input type="checkbox" <?php echo isset($data->question3)? $data->question3 == "item1" ? "checked":'':'' ?>>
                        <label for="">Dikembalikan kepada dokter pengirim.</label>
                    </li>

                </ul>
                <p>Bukittinggi,<?= isset($pelayanan->tgl_input)?date('d-m-Y',strtotime($pelayanan->tgl_input)):'' ?>  Pukul <?= isset($pelayanan->tgl_input)?date('h:i',strtotime($pelayanan->tgl_input)):'' ?></p>
                <div style="display: inline; position: relative;">
                    <div style="float: left;">
                        <p>Menyetujui</p>
                        <p>Pasien / Keluarga Pasien</p>
                        <img width="70px" src="<?= isset($data->question5)?$data->question5:'' ?>" alt=""><br>
                        <span>(<?= isset($data->question8)?$data->question8:'' ?>)</span>     
                    </div>
                    <div style="float: left;margin-left: 25%;">
                        <p>&nbsp;</p>
                        <p>Mengetahui DPJP</p>
                        <img width="70px" src="<?= isset($data->question6 )?$data->question6 :''?>" alt=""><br>
                        <span>(<?= isset($data->question9)?$data->question9:'' ?>)</span>    
                    </div>
                    <div style="float: right;">
                        <p>&nbsp;</p>
                        <p>Pemberi Informasi</p>
                        <img width="70px" src="<?= isset($data->question7)?$data->question7:'' ?>" alt=""><br>
                        <span>(<?= isset($data->question10)?$data->question10:'' ?>)</span>    
                    </div>     
                </div>
                <br><br><br><br><br><br><br><br><br><br>

                <p>*) Lingkari salah satu</p>
            </div>

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