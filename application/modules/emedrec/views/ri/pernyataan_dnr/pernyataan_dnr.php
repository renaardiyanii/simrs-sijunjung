<?php
$data = (isset($dnr->formjson)?json_decode($dnr->formjson):'');
$result = array_chunk($dnr, 1);
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
    <?php 
    if($result){
        for($i = 0;$i<count($result);$i++){ ?>

        <?php 
            foreach( $result[$i] as $val): 
            $value = $val->formjson?json_decode($val->formjson):null;
            ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>SURAT PERNYATAAN JANGAN DILAKUKAN RESUSITASI </h4></center>

            <div style="font-size:12px">
                <p>Yang bertanda tangan dibawah ini saya: </p>
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:<?= isset($value->question1->nama)?$value->question1->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td>Taggal lahir</td>
                        <td>:<?= isset($value->question1->tgl)?$value->question1->tgl:'' ?></td>
                    </tr>
                </table>

                <p>Dengan ini saya menyatakan bahwa saya membuat keputusan dan menyetujui perintah do not resuscitate (jangan di resusitasi). </p>
                
                <p>Saya menyatakan bahwa jika jantung saya berhenti berdetak atau jika saya berhenti bernapas , tidak ada prosedur medis untuk mengembalikan bernapas atau berfungsi kembali jantung akan dilakukan oleh staf Rumah sakit,  namun tidak terbatas pada staf layanan medis darurat.</p>

                <p>Saya memahami bahwa keputusan ini tidak akan mencegah saya menerima pelayanan kesehatan lainnya seperti pemberian maneuver Heimlich atau pemberian oksigen dan langkah-langkah perawatan untuk meningkatkan kenyamanan lainnya.</p>

                <p>Saya memberikan izin agar informasi ini diberikan kepada seluruh staf rumah sakit, Saya memahami bahwa saya dapat mencabut pernyataan ini setiap saat. </p>
                <br><br><br><br>
                
                <div style="display: inline; position: relative;">
                    <div style="float: left;">
                        <p>Yang menyatakan</p>
                        <img width="70px" src="<?= isset($value->question3)?$value->question3:'' ?>" alt=""><br>
                        <span>(<?= isset($value->question6)?$value->question6:'' ?>)</span>     
                    </div>
                    <div style="float: left;margin-left: 25%;">
                        <p>Saksi</p>
                        <img width="70px" src="<?= isset($value->question4)?$value->question4:'' ?>" alt=""><br>
                        <span>(<?= isset($value->question7)?$value->question7:'' ?>)</span>    
                    </div>
                    <div style="float: right;">
                        <p>Saksi</p>
                        <img width="70px" src="<?= isset($value->question5)?$value->question5:'' ?>" alt=""><br>
                        <span>(<?= isset($value->question8)?$value->question8:'' ?>)</span>    
                    </div>     
                </div>

                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display:flex;font-size:10px">
                        <div>
                            Hal 1 dari 2
                        </div>
                        <div style="margin-left:470px">
                        Rev.08.02.2021. RM-023c / RI
                        </div>
                </div>
            </div>
        </div>
        

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>SURAT PERNYATAAN JANGAN DILAKUKAN RESUSITASI </h4></center>

            <div style="font-size:12px">
                <p>Formulir ini adalah perintah dokter penanggung jawab pelayanan kepada seluruh                                                                                   staf klinis rumah sakit, agar tidak dilakukan resusitasi pada pasien ini bila terjadi henti jantung (bila tak ada denyut nadi) dan henti nafas (tak ada pernafasan spontan).</p>
                <p>Formulir ini juga memberikan perintah kepada staf medis untuk tetap melakukan intervensi atau pengobatan, atau tata laksana lainnya sebelum terjadinya henti jantung atau henti nafas.</p>

                <table>
                    <tr>
                        <td>Nama pasien</td>
                        <td>:<?= isset($value->question10->nama)?$value->question10->nama:'' ?> </td>
                    </tr>
                    <tr>
                        <td>Tanggal lahir </td>
                        <td>:<?= isset($value->question10->tgl)?$value->question10->tgl:'' ?> </td>
                    </tr>
                </table>

                <p style="line-height: 0px;">Perintah/ Pernyataan dokter penanggung jawab pelayanan :</p>
                <p>Saya dokter yang bertanda tangan dibawah ini menginstruksikan kepada seluruh staf medis dan staf klinis lainnya untuk melakukan hal-hal tertulis dibawah ini: </p>
                <ul>
                    <li>Usaha komprehensif untuk mencegah henti jantung atau henti nafas tanpa melakukan intubasi. <b> DO NOT RESUCITATE TIDAK DILAKUKAN RESUSITASI JANTUNG PARU (RJP) </b></li>
                    <li>Usaha suportif sebelum terjadi henti nafas atau henti jantung yang meliputi pembukaan jalan nafas non invasive, mengontrol perdarahan, memposisikan pasien dengan nyaman, pemberian oat-obatan anati nyeri. <b> TIDAK MELAKUKAN RJP (RESUSITASI JANTUNG PARU) </b>bila henti nafas atau henti jantung terjadi.</li>
                </ul>

                <p>Saya dokter yang bertanda tangan dibawah ini menyatakan bahwa keputusan DNR diatas diambil setelah pasien diberikan penjelasan dan informed consent diperoleh dari salah satu :</p>

                <ul>
                    <li>Pasien </li>
                    <li>Tenaga kesehatan yang ditunjuk pasien </li>
                    <li>Wali yang sah atas pasien (termasuk yang ditunjuk oleh pengadilan) </li>
                    <li>Anggota keluarga pasien </li>
                </ul>

                <p>Jika yang diatas tidak dimungkinkan maka dokter yang bertanda tangan dibawah ini memberikan perintah DNR berdasarkan pada : </p>

                <ul>
                    <li>Instruksi pasien sebelumnya atau </li>
                    <li>Keputusan dua orang dokter yang menyatakan bahwa Resusitasi jantung paru (RJP) akan mendatangkan hasil yang tidak efektif.</li>
                </ul>
                <br>
                <p style="line-height: 0px;">
                
                <?php
                        $id =isset( $val->id_pemeriksa)? $val->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                        <b>TANDA TANGAN DOKTER: </b><img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            
                        <?php
                            } else {?>
                               <b>TANDA TANGAN DOKTER: …………………………………………. </b>
                        <?php } ?>  
            
                </p>
                
                <p style="float: left;">Nama Lengkap : <?= isset( $val->nm_pemeriksa)? $val->nm_pemeriksa:'' ?> &nbsp;&nbsp;</p>
                <p style="float: left;">NIP: .................................</p>
                <p style="float: left;">No TelP:................,</p>
                <p style="float: left;">Tgl:<?= isset( $val->tgl_input)?date('d-m-Y',strtotime( $val->tgl_input)):'' ?></p>
                
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                        <div>
                            Hal 2 dari 2
                        </div>
                        <div style="margin-left:470px">
                        Rev.08.02.2021. RM-023c / RI
                        </div>
            </div>
        </div>

        <?php endforeach; ?>
        <?php }}else{ ?>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>SURAT PERNYATAAN JANGAN DILAKUKAN RESUSITASI </h4></center>

            <div style="font-size:12px">
                <p>Yang bertanda tangan dibawah ini saya: </p>
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:<?= isset($data->question1->nama)?$data->question1->nama:'' ?></td>
                    </tr>
                    <tr>
                        <td>Taggal lahir</td>
                        <td>:<?= isset($data->question1->tgl)?$data->question1->tgl:'' ?></td>
                    </tr>
                </table>

                <p>Dengan ini saya menyatakan bahwa saya membuat keputusan dan menyetujui perintah do not resuscitate (jangan di resusitasi). </p>
                
                <p>Saya menyatakan bahwa jika jantung saya berhenti berdetak atau jika saya berhenti bernapas , tidak ada prosedur medis untuk mengembalikan bernapas atau berfungsi kembali jantung akan dilakukan oleh staf Rumah sakit,  namun tidak terbatas pada staf layanan medis darurat.</p>

                <p>Saya memahami bahwa keputusan ini tidak akan mencegah saya menerima pelayanan kesehatan lainnya seperti pemberian maneuver Heimlich atau pemberian oksigen dan langkah-langkah perawatan untuk meningkatkan kenyamanan lainnya.</p>

                <p>Saya memberikan izin agar informasi ini diberikan kepada seluruh staf rumah sakit, Saya memahami bahwa saya dapat mencabut pernyataan ini setiap saat. </p>
                <br><br><br><br>
                
                <div style="display: inline; position: relative;">
                    <div style="float: left;">
                        <p>Yang menyatakan</p>
                        <img width="70px" src="<?= isset($data->question3)?$data->question3:'' ?>" alt=""><br>
                        <span>(<?= isset($data->question6)?$data->question6:'' ?>)</span>     
                    </div>
                    <div style="float: left;margin-left: 25%;">
                        <p>Saksi</p>
                        <img width="70px" src="<?= isset($data->question4)?$data->question4:'' ?>" alt=""><br>
                        <span>(<?= isset($data->question7)?$data->question7:'' ?>)</span>    
                    </div>
                    <div style="float: right;">
                        <p>Saksi</p>
                        <img width="70px" src="<?= isset($data->question5)?$data->question5:'' ?>" alt=""><br>
                        <span>(<?= isset($data->question8)?$data->question8:'' ?>)</span>    
                    </div>     
                </div>

                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display:flex;font-size:10px">
                        <div>
                            Hal 1 dari 2
                        </div>
                        <div style="margin-left:470px">
                        Rev.08.02.2021. RM-023c / RI
                        </div>
                </div>
            </div>
        </div>
        

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="border-bottom: 1px solid black;margin-top:3px"></div>
            <div style="border-bottom: 4px solid black;margin-top:2px"></div>

            <center><h4>SURAT PERNYATAAN JANGAN DILAKUKAN RESUSITASI </h4></center>

            <div style="font-size:12px">
                <p>Formulir ini adalah perintah dokter penanggung jawab pelayanan kepada seluruh                                                                                   staf klinis rumah sakit, agar tidak dilakukan resusitasi pada pasien ini bila terjadi henti jantung (bila tak ada denyut nadi) dan henti nafas (tak ada pernafasan spontan).</p>
                <p>Formulir ini juga memberikan perintah kepada staf medis untuk tetap melakukan intervensi atau pengobatan, atau tata laksana lainnya sebelum terjadinya henti jantung atau henti nafas.</p>

                <table>
                    <tr>
                        <td>Nama pasien</td>
                        <td>:<?= isset($data->question10->nama)?$data->question10->nama:'' ?> </td>
                    </tr>
                    <tr>
                        <td>Tanggal lahir </td>
                        <td>:<?= isset($data->question10->tgl)?$data->question10->tgl:'' ?> </td>
                    </tr>
                </table>

                <p style="line-height: 0px;">Perintah/ Pernyataan dokter penanggung jawab pelayanan :</p>
                <p>Saya dokter yang bertanda tangan dibawah ini menginstruksikan kepada seluruh staf medis dan staf klinis lainnya untuk melakukan hal-hal tertulis dibawah ini: </p>
                <ul>
                    <li>Usaha komprehensif untuk mencegah henti jantung atau henti nafas tanpa melakukan intubasi. <b> DO NOT RESUCITATE TIDAK DILAKUKAN RESUSITASI JANTUNG PARU (RJP) </b></li>
                    <li>Usaha suportif sebelum terjadi henti nafas atau henti jantung yang meliputi pembukaan jalan nafas non invasive, mengontrol perdarahan, memposisikan pasien dengan nyaman, pemberian oat-obatan anati nyeri. <b> TIDAK MELAKUKAN RJP (RESUSITASI JANTUNG PARU) </b>bila henti nafas atau henti jantung terjadi.</li>
                </ul>

                <p>Saya dokter yang bertanda tangan dibawah ini menyatakan bahwa keputusan DNR diatas diambil setelah pasien diberikan penjelasan dan informed consent diperoleh dari salah satu :</p>

                <ul>
                    <li>Pasien </li>
                    <li>Tenaga kesehatan yang ditunjuk pasien </li>
                    <li>Wali yang sah atas pasien (termasuk yang ditunjuk oleh pengadilan) </li>
                    <li>Anggota keluarga pasien </li>
                </ul>

                <p>Jika yang diatas tidak dimungkinkan maka dokter yang bertanda tangan dibawah ini memberikan perintah DNR berdasarkan pada : </p>

                <ul>
                    <li>Instruksi pasien sebelumnya atau </li>
                    <li>Keputusan dua orang dokter yang menyatakan bahwa Resusitasi jantung paru (RJP) akan mendatangkan hasil yang tidak efektif.</li>
                </ul>
                <br>
                <p style="line-height: 0px;">
                
                <?php
                        $id =isset($dnr->id_pemeriksa)?$dnr->id_pemeriksa:null;
                        //  var_dump($id);                                     
                        $query = $id?$this->db->query("SELECT ttd FROM hmis_users LEFT JOIN dyn_user_dokter on dyn_user_dokter.userid = hmis_users.userid where hmis_users.userid = $id")->row():null;
                        if(isset($query->ttd)){
                        ?>

                        <b>TANDA TANGAN DOKTER: </b><img width="70px" src="<?= $query->ttd ?>" alt=""><br>
                            
                        <?php
                            } else {?>
                               <b>TANDA TANGAN DOKTER: …………………………………………. </b>
                        <?php } ?>  
            
                </p>
                
                <p style="float: left;">Nama Lengkap : <?= isset($dnr->nm_pemeriksa)?$dnr->nm_pemeriksa:'' ?> &nbsp;&nbsp;</p>
                <p style="float: left;">NIP: .................................</p>
                <p style="float: left;">No TelP:................,</p>
                <p style="float: left;">Tgl:<?= isset($dnr->tgl_input)?date('d-m-Y',strtotime($dnr->tgl_input)):'' ?></p>
                
            </div><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div style="display:flex;font-size:10px">
                        <div>
                            Hal 2 dari 2
                        </div>
                        <div style="margin-left:470px">
                        Rev.08.02.2021. RM-023c / RI
                        </div>
            </div>
        </div>
        <?php } ?>
    </body>

 
</html>