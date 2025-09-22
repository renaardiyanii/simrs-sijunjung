<?php
$data = (isset($persalinan_normal->formjson)?json_decode($persalinan_normal->formjson):'');
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
   
    <body class="A4 landscape" >

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header><br>
            <div style="height:0px;border: 2px solid black;"></div>
            <hr color="black">
            <center><h4>PERSALINAN NORMAL</h4></center>

            <div style="font-size:12px">

                <h3>PARTOGRAF</h3>
                <table width="100%">
                    <tr>
                        <td width="16%">No Register :</td>
                        <td width="16%"><?= isset($data->question1->noreg)?$data->question1->noreg:'' ?></td>
                        <td width="16%">Nama Ibu :</td>
                        <td width="16%"><?= isset($data->question1->ibu)?$data->question1->ibu:'' ?></td>
                        <td width="16%">Umur :</td>
                        <td width="16%"><?= isset($data->question1->umur)?$data->question1->umur:'' ?></td>
                    </tr>
                    <tr>
                        <td width="16%">G :</td>
                        <td width="16%"><?= isset($data->question1->g)?$data->question1->g:'' ?></td>
                        <td width="16%">P :</td>
                        <td width="16%"><?= isset($data->question1->p)?$data->question1->p:'' ?></td>
                        <td width="16%">A :</td>
                        <td width="16%"><?= isset($data->question1->a)?$data->question1->a:'' ?></td>
                    </tr>
                    <tr>
                        <td width="16%">No. Puskesmas :</td>
                        <td width="16%"><?= isset($data->question1->puskesmas)?$data->question1->puskesmas:'' ?></td>
                        <td width="16%">Tanggal :</td>
                        <td width="16%"><?= isset($data->question1->tgl)?$data->question1->tgl:'' ?></td>
                        <td width="16%">Jam :</td> 
                        <td width="16%"><?= isset($data->question1->jam)?$data->question1->jam:'' ?></td>
                    </tr>
                    <tr>
                        <td width="16%">Alamat :</td>
                        <td width="16%"><?= isset($data->question1->alamat)?$data->question1->alamat:'' ?></td>
                        <td width="16%">Ketuban Pecah Sejak jam :</td>
                        <td width="16%"><?= isset($data->question1->ketuban)?$data->question1->ketuban:'' ?></td>
                        <td width="16%">Mules Sejak Jam :</td>
                        <td width="16%"><?= isset($data->question1->mules)?$data->question1->mules:'' ?></td>
                    </tr>
                </table><br>

                <h3>Denyut Jantung Janin/Menit</h3><br>

                <table width="100%" border="1">
                    <tr>
                        <td width="3%"><h4>200</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 1'})?$data->question2[0]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 1'})?$data->question2[1]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 1'})?$data->question2[2]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 1'})?$data->question2[3]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 1'})?$data->question2[4]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 1'})?$data->question2[5]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 1'})?$data->question2[6]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 1'})?$data->question2[7]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 1'})?$data->question2[8]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 1'})?$data->question2[9]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 1'})?$data->question2[10]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 1'})?$data->question2[11]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 1'})?$data->question2[12]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 1'})?$data->question2[13]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 1'})?$data->question2[14]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 1'})?$data->question2[15]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 1'})?$data->question2[16]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 1'})?$data->question2[17]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 1'})?$data->question2[18]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 1'})?$data->question2[19]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 1'})?$data->question2[20]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 1'})?$data->question2[21]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 1'})?$data->question2[22]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 1'})?$data->question2[23]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 1'})?$data->question2[24]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 1'})?$data->question2[25]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 1'})?$data->question2[26]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 1'})?$data->question2[27]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 1'})?$data->question2[28]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 1'})?$data->question2[29]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 1'})?$data->question2[30]->{'Column 1'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 1'})?$data->question2[31]->{'Column 1'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>190</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 2'})?$data->question2[0]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 2'})?$data->question2[1]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 2'})?$data->question2[2]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 2'})?$data->question2[3]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 2'})?$data->question2[4]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 2'})?$data->question2[5]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 2'})?$data->question2[6]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 2'})?$data->question2[7]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 2'})?$data->question2[8]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 2'})?$data->question2[9]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 2'})?$data->question2[10]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 2'})?$data->question2[11]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 2'})?$data->question2[12]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 2'})?$data->question2[13]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 2'})?$data->question2[14]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 2'})?$data->question2[15]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 2'})?$data->question2[16]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 2'})?$data->question2[17]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 2'})?$data->question2[18]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 2'})?$data->question2[19]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 2'})?$data->question2[20]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 2'})?$data->question2[21]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 2'})?$data->question2[22]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 2'})?$data->question2[23]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 2'})?$data->question2[24]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 2'})?$data->question2[25]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 2'})?$data->question2[26]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 2'})?$data->question2[27]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 2'})?$data->question2[28]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 2'})?$data->question2[29]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 2'})?$data->question2[30]->{'Column 2'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 2'})?$data->question2[31]->{'Column 2'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>180</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 3'})?$data->question2[0]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 3'})?$data->question2[1]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 3'})?$data->question2[2]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 3'})?$data->question2[3]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 3'})?$data->question2[4]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 3'})?$data->question2[5]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 3'})?$data->question2[6]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 3'})?$data->question2[7]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 3'})?$data->question2[8]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 3'})?$data->question2[9]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 3'})?$data->question2[10]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 3'})?$data->question2[11]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 3'})?$data->question2[12]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 3'})?$data->question2[13]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 3'})?$data->question2[14]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 3'})?$data->question2[15]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 3'})?$data->question2[16]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 3'})?$data->question2[17]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 3'})?$data->question2[18]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 3'})?$data->question2[19]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 3'})?$data->question2[20]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 3'})?$data->question2[21]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 3'})?$data->question2[22]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 3'})?$data->question2[23]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 3'})?$data->question2[24]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 3'})?$data->question2[25]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 3'})?$data->question2[26]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 3'})?$data->question2[27]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 3'})?$data->question2[28]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 3'})?$data->question2[29]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 3'})?$data->question2[30]->{'Column 3'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 3'})?$data->question2[31]->{'Column 3'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>170</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 4'})?$data->question2[0]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 4'})?$data->question2[1]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 4'})?$data->question2[2]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 4'})?$data->question2[3]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 4'})?$data->question2[4]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 4'})?$data->question2[5]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 4'})?$data->question2[6]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 4'})?$data->question2[7]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 4'})?$data->question2[8]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 4'})?$data->question2[9]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 4'})?$data->question2[10]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 4'})?$data->question2[11]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 4'})?$data->question2[12]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 4'})?$data->question2[13]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 4'})?$data->question2[14]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 4'})?$data->question2[15]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 4'})?$data->question2[16]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 4'})?$data->question2[17]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 4'})?$data->question2[18]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 4'})?$data->question2[19]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 4'})?$data->question2[20]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 4'})?$data->question2[21]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 4'})?$data->question2[22]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 4'})?$data->question2[23]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 4'})?$data->question2[24]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 4'})?$data->question2[25]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 4'})?$data->question2[26]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 4'})?$data->question2[27]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 4'})?$data->question2[28]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 4'})?$data->question2[29]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 4'})?$data->question2[30]->{'Column 4'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 4'})?$data->question2[31]->{'Column 4'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>160</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 5'})?$data->question2[0]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 5'})?$data->question2[1]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 5'})?$data->question2[2]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 5'})?$data->question2[3]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 5'})?$data->question2[4]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 5'})?$data->question2[5]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 5'})?$data->question2[6]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 5'})?$data->question2[7]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 5'})?$data->question2[8]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 5'})?$data->question2[9]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 5'})?$data->question2[10]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 5'})?$data->question2[11]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 5'})?$data->question2[12]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 5'})?$data->question2[13]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 5'})?$data->question2[14]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 5'})?$data->question2[15]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 5'})?$data->question2[16]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 5'})?$data->question2[17]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 5'})?$data->question2[18]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 5'})?$data->question2[19]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 5'})?$data->question2[20]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 5'})?$data->question2[21]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 5'})?$data->question2[22]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 5'})?$data->question2[23]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 5'})?$data->question2[24]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 5'})?$data->question2[25]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 5'})?$data->question2[26]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 5'})?$data->question2[27]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 5'})?$data->question2[28]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 5'})?$data->question2[29]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 5'})?$data->question2[30]->{'Column 5'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 5'})?$data->question2[31]->{'Column 5'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>150</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 6'})?$data->question2[0]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 6'})?$data->question2[1]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 6'})?$data->question2[2]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 6'})?$data->question2[3]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 6'})?$data->question2[4]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 6'})?$data->question2[5]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 6'})?$data->question2[6]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 6'})?$data->question2[7]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 6'})?$data->question2[8]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 6'})?$data->question2[9]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 6'})?$data->question2[10]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 6'})?$data->question2[11]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 6'})?$data->question2[12]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 6'})?$data->question2[13]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 6'})?$data->question2[14]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 6'})?$data->question2[15]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 6'})?$data->question2[16]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 6'})?$data->question2[17]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 6'})?$data->question2[18]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 6'})?$data->question2[19]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 6'})?$data->question2[20]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 6'})?$data->question2[21]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 6'})?$data->question2[22]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 6'})?$data->question2[23]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 6'})?$data->question2[24]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 6'})?$data->question2[25]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 6'})?$data->question2[26]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 6'})?$data->question2[27]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 6'})?$data->question2[28]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 6'})?$data->question2[29]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 6'})?$data->question2[30]->{'Column 6'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 6'})?$data->question2[31]->{'Column 6'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>140</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 7'})?$data->question2[0]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 7'})?$data->question2[1]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 7'})?$data->question2[2]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 7'})?$data->question2[3]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 7'})?$data->question2[4]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 7'})?$data->question2[5]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 7'})?$data->question2[6]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 7'})?$data->question2[7]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 7'})?$data->question2[8]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 7'})?$data->question2[9]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 7'})?$data->question2[10]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 7'})?$data->question2[11]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 7'})?$data->question2[12]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 7'})?$data->question2[13]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 7'})?$data->question2[14]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 7'})?$data->question2[15]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 7'})?$data->question2[16]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 7'})?$data->question2[17]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 7'})?$data->question2[18]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 7'})?$data->question2[19]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 7'})?$data->question2[20]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 7'})?$data->question2[21]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 7'})?$data->question2[22]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 7'})?$data->question2[23]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 7'})?$data->question2[24]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 7'})?$data->question2[25]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 7'})?$data->question2[26]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 7'})?$data->question2[27]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 7'})?$data->question2[28]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 7'})?$data->question2[29]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 7'})?$data->question2[30]->{'Column 7'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 7'})?$data->question2[31]->{'Column 7'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>130</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 8'})?$data->question2[0]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 8'})?$data->question2[1]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 8'})?$data->question2[2]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 8'})?$data->question2[3]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 8'})?$data->question2[4]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 8'})?$data->question2[5]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 8'})?$data->question2[6]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 8'})?$data->question2[7]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 8'})?$data->question2[8]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 8'})?$data->question2[9]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 8'})?$data->question2[10]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 8'})?$data->question2[11]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 8'})?$data->question2[12]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 8'})?$data->question2[13]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 8'})?$data->question2[14]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 8'})?$data->question2[15]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 8'})?$data->question2[16]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 8'})?$data->question2[17]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 8'})?$data->question2[18]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 8'})?$data->question2[19]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 8'})?$data->question2[20]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 8'})?$data->question2[21]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 8'})?$data->question2[22]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 8'})?$data->question2[23]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 8'})?$data->question2[24]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 8'})?$data->question2[25]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 8'})?$data->question2[26]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 8'})?$data->question2[27]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 8'})?$data->question2[28]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 8'})?$data->question2[29]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 8'})?$data->question2[30]->{'Column 8'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 8'})?$data->question2[31]->{'Column 8'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>120</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 9'})?$data->question2[0]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 9'})?$data->question2[1]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 9'})?$data->question2[2]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 9'})?$data->question2[3]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 9'})?$data->question2[4]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 9'})?$data->question2[5]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 9'})?$data->question2[6]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 9'})?$data->question2[7]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 9'})?$data->question2[8]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 9'})?$data->question2[9]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 9'})?$data->question2[10]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 9'})?$data->question2[11]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 9'})?$data->question2[12]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 9'})?$data->question2[13]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 9'})?$data->question2[14]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 9'})?$data->question2[15]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 9'})?$data->question2[16]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 9'})?$data->question2[17]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 9'})?$data->question2[18]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 9'})?$data->question2[19]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 9'})?$data->question2[20]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 9'})?$data->question2[21]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 9'})?$data->question2[22]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 9'})?$data->question2[23]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 9'})?$data->question2[24]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 9'})?$data->question2[25]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 9'})?$data->question2[26]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 9'})?$data->question2[27]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 9'})?$data->question2[28]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 9'})?$data->question2[29]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 9'})?$data->question2[30]->{'Column 9'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 9'})?$data->question2[31]->{'Column 9'}:'' ?></td>
                    </tr>
                </table><br>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:right;font-size:12px"></p>
        </div>

        <div class="A4 sheet  padding-fix-10mm">
            <style type="text/css">
                #ketuban {
                    border-top: 1px solid;
                    border-left: 1px solid;
                    border-right: 1px solid;
                    border-bottom: 1px solid;
                } #nyusut {
                    border-left: 1px solid;
                    border-right: 1px solid;
                    border-bottom: 1px solid;
                }
            </style>
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <hr color="black">

            <center><h4>PERSALINAN NORMAL</h4></center>

            <div style="font-size:12px">

            <table width="100%" border="1px solid;">
                <tr>
                        <td width="3%"><h4>110</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 10'})?$data->question2[0]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 10'})?$data->question2[1]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 10'})?$data->question2[2]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 10'})?$data->question2[3]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 10'})?$data->question2[4]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 10'})?$data->question2[5]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 10'})?$data->question2[6]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 10'})?$data->question2[7]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 10'})?$data->question2[8]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 10'})?$data->question2[9]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 10'})?$data->question2[10]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 10'})?$data->question2[11]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 10'})?$data->question2[12]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 10'})?$data->question2[13]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 10'})?$data->question2[14]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 10'})?$data->question2[15]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 10'})?$data->question2[16]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 10'})?$data->question2[17]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 10'})?$data->question2[18]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 10'})?$data->question2[19]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 10'})?$data->question2[20]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 10'})?$data->question2[21]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 10'})?$data->question2[22]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 10'})?$data->question2[23]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 10'})?$data->question2[24]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 10'})?$data->question2[25]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 10'})?$data->question2[26]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 10'})?$data->question2[27]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 10'})?$data->question2[28]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 10'})?$data->question2[29]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 10'})?$data->question2[30]->{'Column 10'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 10'})?$data->question2[31]->{'Column 10'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>100</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 11'})?$data->question2[0]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 11'})?$data->question2[1]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 11'})?$data->question2[2]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 11'})?$data->question2[3]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 11'})?$data->question2[4]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 11'})?$data->question2[5]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 11'})?$data->question2[6]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 11'})?$data->question2[7]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 11'})?$data->question2[8]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 11'})?$data->question2[9]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 11'})?$data->question2[10]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 11'})?$data->question2[11]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 11'})?$data->question2[12]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 11'})?$data->question2[13]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 11'})?$data->question2[14]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 11'})?$data->question2[15]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 11'})?$data->question2[16]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 11'})?$data->question2[17]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 11'})?$data->question2[18]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 11'})?$data->question2[19]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 11'})?$data->question2[20]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 11'})?$data->question2[21]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 11'})?$data->question2[22]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 11'})?$data->question2[23]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 11'})?$data->question2[24]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 11'})?$data->question2[25]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 11'})?$data->question2[26]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 11'})?$data->question2[27]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 11'})?$data->question2[28]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 11'})?$data->question2[29]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 11'})?$data->question2[30]->{'Column 11'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 11'})?$data->question2[31]->{'Column 11'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>90</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 12'})?$data->question2[0]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 12'})?$data->question2[1]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 12'})?$data->question2[2]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 12'})?$data->question2[3]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 12'})?$data->question2[4]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 12'})?$data->question2[5]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 12'})?$data->question2[6]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 12'})?$data->question2[7]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 12'})?$data->question2[8]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 12'})?$data->question2[9]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 12'})?$data->question2[10]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 12'})?$data->question2[11]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 12'})?$data->question2[12]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 12'})?$data->question2[13]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 12'})?$data->question2[14]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 12'})?$data->question2[15]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 12'})?$data->question2[16]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 12'})?$data->question2[17]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 12'})?$data->question2[18]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 12'})?$data->question2[19]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 12'})?$data->question2[20]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 12'})?$data->question2[21]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 12'})?$data->question2[22]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 12'})?$data->question2[23]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 12'})?$data->question2[24]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 12'})?$data->question2[25]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 12'})?$data->question2[26]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 12'})?$data->question2[27]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 12'})?$data->question2[28]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 12'})?$data->question2[29]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 12'})?$data->question2[30]->{'Column 12'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 12'})?$data->question2[31]->{'Column 12'}:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>80</h4></td>
                        <td width="3%"><?= isset($data->question2[0]->{'Column 13'})?$data->question2[0]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[1]->{'Column 13'})?$data->question2[1]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[2]->{'Column 13'})?$data->question2[2]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[3]->{'Column 13'})?$data->question2[3]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[4]->{'Column 13'})?$data->question2[4]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[5]->{'Column 13'})?$data->question2[5]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[6]->{'Column 13'})?$data->question2[6]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[7]->{'Column 13'})?$data->question2[7]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[8]->{'Column 13'})?$data->question2[8]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[9]->{'Column 13'})?$data->question2[9]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[10]->{'Column 13'})?$data->question2[10]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[11]->{'Column 13'})?$data->question2[11]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[12]->{'Column 13'})?$data->question2[12]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[13]->{'Column 13'})?$data->question2[13]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[14]->{'Column 13'})?$data->question2[14]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[15]->{'Column 13'})?$data->question2[15]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[16]->{'Column 13'})?$data->question2[16]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[17]->{'Column 13'})?$data->question2[17]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[18]->{'Column 13'})?$data->question2[18]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[19]->{'Column 13'})?$data->question2[19]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[20]->{'Column 13'})?$data->question2[20]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[21]->{'Column 13'})?$data->question2[21]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[22]->{'Column 13'})?$data->question2[22]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[23]->{'Column 13'})?$data->question2[23]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[24]->{'Column 13'})?$data->question2[24]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[25]->{'Column 13'})?$data->question2[25]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[26]->{'Column 13'})?$data->question2[26]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[27]->{'Column 13'})?$data->question2[27]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[28]->{'Column 13'})?$data->question2[28]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[29]->{'Column 13'})?$data->question2[29]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[30]->{'Column 13'})?$data->question2[30]->{'Column 13'}:'' ?></td>
                        <td width="3%"><?= isset($data->question2[31]->{'Column 13'})?$data->question2[31]->{'Column 13'}:'' ?></td>
                    </tr>
            </table><br>

            <table width="100%">
                <tr>
                    <td width="20%"><h4>Air Ketuban</h4></td>
                    <td width="2%">:</td>
                    <td width="78%"><?= isset($data->question3->air_ketuban)?$data->question3->air_ketuban:'' ?></td>
                </tr>
                <tr>
                    <td width="20%"><h4>Penyusutan</h4></td>
                    <td width="2%">:</td>
                    <td width="78%"><?= isset($data->question3->penyusutan)?$data->question3->penyusutan:'' ?></td>
                </tr>
            </table><br>

            <h3>Pembukaan Serviks (cm)</h3>

            <table width="100%" border="1">
                <tr>
                    <td width="5,8%"></td>
                    <td width="5,8%"><h4>1</h4></td>
                    <td width="5,8%"><h4>2</h4></td>
                    <td width="5,8%"><h4>3</h4></td>
                    <td width="5,8%"><h4>4</h4></td>
                    <td width="5,8%"><h4>5</h4></td>
                    <td width="5,8%"><h4>6</h4></td>
                    <td width="5,8%"><h4>7</h4></td>
                    <td width="5,8%"><h4>8</h4></td>
                    <td width="5,8%"><h4>9</h4></td>
                    <td width="5,8%"><h4>10</h4></td>
                    <td width="5,8%"><h4>11</h4></td>
                    <td width="5,8%"><h4>12</h4></td>
                    <td width="5,8%"><h4>13</h4></td>
                    <td width="5,8%"><h4>14</h4></td>
                    <td width="5,8%"><h4>15</h4></td>
                    <td width="5,8%"><h4>16</h4></td>
                </tr>
                <tr>
                    <td width="5,8%">1</td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'1'})?$data->question4->{'1'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'2'})?$data->question4->{'1'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'3'})?$data->question4->{'1'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'4'})?$data->question4->{'1'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'5'})?$data->question4->{'1'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'6'})?$data->question4->{'1'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'7'})?$data->question4->{'1'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'8'})?$data->question4->{'1'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'9'})?$data->question4->{'1'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'10'})?$data->question4->{'1'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'11'})?$data->question4->{'1'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'12'})?$data->question4->{'1'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'13'})?$data->question4->{'1'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'14'})?$data->question4->{'1'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'15'})?$data->question4->{'1'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'1'}->{'16'})?$data->question4->{'1'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">2</td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'1'})?$data->question4->{'2'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'2'})?$data->question4->{'2'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'3'})?$data->question4->{'2'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'4'})?$data->question4->{'2'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'5'})?$data->question4->{'2'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'6'})?$data->question4->{'2'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'7'})?$data->question4->{'2'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'8'})?$data->question4->{'2'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'9'})?$data->question4->{'2'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'10'})?$data->question4->{'2'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'11'})?$data->question4->{'2'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'12'})?$data->question4->{'2'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'13'})?$data->question4->{'2'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'14'})?$data->question4->{'2'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'15'})?$data->question4->{'2'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'2'}->{'16'})?$data->question4->{'2'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">3</td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'1'})?$data->question4->{'3'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'2'})?$data->question4->{'3'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'3'})?$data->question4->{'3'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'4'})?$data->question4->{'3'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'5'})?$data->question4->{'3'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'6'})?$data->question4->{'3'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'7'})?$data->question4->{'3'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'8'})?$data->question4->{'3'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'9'})?$data->question4->{'3'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'10'})?$data->question4->{'3'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'11'})?$data->question4->{'3'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'12'})?$data->question4->{'3'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'13'})?$data->question4->{'3'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'14'})?$data->question4->{'3'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'15'})?$data->question4->{'3'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'3'}->{'16'})?$data->question4->{'3'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">4</td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'1'})?$data->question4->{'4'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'2'})?$data->question4->{'4'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'3'})?$data->question4->{'4'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'4'})?$data->question4->{'4'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'5'})?$data->question4->{'4'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'6'})?$data->question4->{'4'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'7'})?$data->question4->{'4'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'8'})?$data->question4->{'4'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'9'})?$data->question4->{'4'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'10'})?$data->question4->{'4'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'11'})?$data->question4->{'4'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'12'})?$data->question4->{'4'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'13'})?$data->question4->{'4'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'14'})?$data->question4->{'4'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'15'})?$data->question4->{'4'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'4'}->{'16'})?$data->question4->{'4'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">5</td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'1'})?$data->question4->{'5'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'2'})?$data->question4->{'5'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'3'})?$data->question4->{'5'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'4'})?$data->question4->{'5'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'5'})?$data->question4->{'5'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'6'})?$data->question4->{'5'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'7'})?$data->question4->{'5'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'8'})?$data->question4->{'5'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'9'})?$data->question4->{'5'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'10'})?$data->question4->{'5'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'11'})?$data->question4->{'5'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'12'})?$data->question4->{'5'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'13'})?$data->question4->{'5'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'14'})?$data->question4->{'5'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'15'})?$data->question4->{'5'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'5'}->{'16'})?$data->question4->{'5'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">6</td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'1'})?$data->question4->{'6'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'2'})?$data->question4->{'6'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'3'})?$data->question4->{'6'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'4'})?$data->question4->{'6'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'5'})?$data->question4->{'6'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'6'})?$data->question4->{'6'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'7'})?$data->question4->{'6'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'8'})?$data->question4->{'6'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'9'})?$data->question4->{'6'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'10'})?$data->question4->{'6'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'11'})?$data->question4->{'6'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'12'})?$data->question4->{'6'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'13'})?$data->question4->{'6'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'14'})?$data->question4->{'6'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'15'})?$data->question4->{'6'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'6'}->{'16'})?$data->question4->{'6'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">7</td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'1'})?$data->question4->{'7'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'2'})?$data->question4->{'7'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'3'})?$data->question4->{'7'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'4'})?$data->question4->{'7'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'5'})?$data->question4->{'7'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'6'})?$data->question4->{'7'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'7'})?$data->question4->{'7'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'8'})?$data->question4->{'7'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'9'})?$data->question4->{'7'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'10'})?$data->question4->{'7'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'11'})?$data->question4->{'7'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'12'})?$data->question4->{'7'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'13'})?$data->question4->{'7'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'14'})?$data->question4->{'7'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'15'})?$data->question4->{'7'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'7'}->{'16'})?$data->question4->{'7'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">8</td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'1'})?$data->question4->{'8'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'2'})?$data->question4->{'8'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'3'})?$data->question4->{'8'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'4'})?$data->question4->{'8'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'5'})?$data->question4->{'8'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'6'})?$data->question4->{'8'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'7'})?$data->question4->{'8'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'8'})?$data->question4->{'8'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'9'})?$data->question4->{'8'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'10'})?$data->question4->{'8'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'11'})?$data->question4->{'8'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'12'})?$data->question4->{'8'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'13'})?$data->question4->{'8'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'14'})?$data->question4->{'8'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'15'})?$data->question4->{'8'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'8'}->{'16'})?$data->question4->{'8'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">9</td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'1'})?$data->question4->{'9'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'2'})?$data->question4->{'9'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'3'})?$data->question4->{'9'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'4'})?$data->question4->{'9'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'5'})?$data->question4->{'9'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'6'})?$data->question4->{'9'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'7'})?$data->question4->{'9'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'8'})?$data->question4->{'9'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'9'})?$data->question4->{'9'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'10'})?$data->question4->{'9'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'11'})?$data->question4->{'9'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'12'})?$data->question4->{'9'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'13'})?$data->question4->{'9'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'14'})?$data->question4->{'9'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'15'})?$data->question4->{'9'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'9'}->{'16'})?$data->question4->{'9'}->{'16'}:'' ?></td>
                </tr>
                <tr>
                    <td width="5,8%">10</td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'1'})?$data->question4->{'10'}->{'1'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'2'})?$data->question4->{'10'}->{'2'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'3'})?$data->question4->{'10'}->{'3'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'4'})?$data->question4->{'10'}->{'4'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'5'})?$data->question4->{'10'}->{'5'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'6'})?$data->question4->{'10'}->{'6'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'7'})?$data->question4->{'10'}->{'7'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'8'})?$data->question4->{'10'}->{'8'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'9'})?$data->question4->{'10'}->{'9'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'10'})?$data->question4->{'10'}->{'10'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'11'})?$data->question4->{'10'}->{'11'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'12'})?$data->question4->{'10'}->{'12'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'13'})?$data->question4->{'10'}->{'13'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'14'})?$data->question4->{'10'}->{'14'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'15'})?$data->question4->{'10'}->{'15'}:'' ?></td>
                    <td width="5,8%"><?= isset($data->question4->{'10'}->{'16'})?$data->question4->{'10'}->{'16'}:'' ?></td>
                </tr>
            </table><br>

            <table width="100%">
                <tr>
                    <td width="20%"><h4>Waktu (Jam)</h4></td>
                    <td width="2%">:</td>
                    <td width="78%"><?= isset($data->question5)?$data->question5:'' ?></td>
                </tr>
            </table><br>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:right;font-size:12px">2</p>
        </div>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <hr color="black">

            <center><h4>PERSALINAN NORMAL</h4></center>

            <div style="font-size:12px">

            <h3>Kontraksi Tiap 0 Menit</h3><br>

               <table width="100%" border="1">
                    <tr>
                        <td width="3%"><h4>(5)</h4></td>
                        <td width="3%"><?= isset($data->question6[0]->column1)?$data->question6[0]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[1]->column1)?$data->question6[1]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[2]->column1)?$data->question6[2]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[3]->column1)?$data->question6[3]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[4]->column1)?$data->question6[4]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[5]->column1)?$data->question6[5]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[6]->column1)?$data->question6[6]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[7]->column1)?$data->question6[7]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[8]->column1)?$data->question6[8]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[9]->column1)?$data->question6[9]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[10]->column1)?$data->question6[10]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[11]->column1)?$data->question6[11]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[12]->column1)?$data->question6[12]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[13]->column1)?$data->question6[13]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[14]->column1)?$data->question6[14]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[15]->column1)?$data->question6[15]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[16]->column1)?$data->question6[16]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[17]->column1)?$data->question6[17]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[18]->column1)?$data->question6[18]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[19]->column1)?$data->question6[19]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[20]->column1)?$data->question6[20]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[21]->column1)?$data->question6[21]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[22]->column1)?$data->question6[22]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[23]->column1)?$data->question6[23]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[24]->column1)?$data->question6[24]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[25]->column1)?$data->question6[25]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[26]->column1)?$data->question6[26]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[27]->column1)?$data->question6[27]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[28]->column1)?$data->question6[28]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[29]->column1)?$data->question6[29]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[30]->column1)?$data->question6[30]->column1:'' ?></td>
                        <td width="3%"><?= isset($data->question6[31]->column1)?$data->question6[31]->column1:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>< 20 (4)</h4></td>
                        <td width="3%"><?= isset($data->question6[0]->column2)?$data->question6[0]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[1]->column2)?$data->question6[1]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[2]->column2)?$data->question6[2]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[3]->column2)?$data->question6[3]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[4]->column2)?$data->question6[4]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[5]->column2)?$data->question6[5]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[6]->column2)?$data->question6[6]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[7]->column2)?$data->question6[7]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[8]->column2)?$data->question6[8]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[9]->column2)?$data->question6[9]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[10]->column2)?$data->question6[10]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[11]->column2)?$data->question6[11]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[12]->column2)?$data->question6[12]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[13]->column2)?$data->question6[13]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[14]->column2)?$data->question6[14]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[15]->column2)?$data->question6[15]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[16]->column2)?$data->question6[16]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[17]->column2)?$data->question6[17]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[18]->column2)?$data->question6[18]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[19]->column2)?$data->question6[19]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[20]->column2)?$data->question6[20]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[21]->column2)?$data->question6[21]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[22]->column2)?$data->question6[22]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[23]->column2)?$data->question6[23]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[24]->column2)?$data->question6[24]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[25]->column2)?$data->question6[25]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[26]->column2)?$data->question6[26]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[27]->column2)?$data->question6[27]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[28]->column2)?$data->question6[28]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[29]->column2)?$data->question6[29]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[30]->column2)?$data->question6[30]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question6[31]->column2)?$data->question6[31]->column2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>20-40 (3)</h4></td>
                        <td width="3%"><?= isset($data->question6[0]->column3)?$data->question6[0]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[1]->column3)?$data->question6[1]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[2]->column3)?$data->question6[2]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[3]->column3)?$data->question6[3]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[4]->column3)?$data->question6[4]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[5]->column3)?$data->question6[5]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[6]->column3)?$data->question6[6]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[7]->column3)?$data->question6[7]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[8]->column3)?$data->question6[8]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[9]->column3)?$data->question6[9]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[10]->column3)?$data->question6[10]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[11]->column3)?$data->question6[11]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[12]->column3)?$data->question6[12]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[13]->column3)?$data->question6[13]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[14]->column3)?$data->question6[14]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[15]->column3)?$data->question6[15]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[16]->column3)?$data->question6[16]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[17]->column3)?$data->question6[17]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[18]->column3)?$data->question6[18]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[19]->column3)?$data->question6[19]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[20]->column3)?$data->question6[20]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[21]->column3)?$data->question6[21]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[22]->column3)?$data->question6[22]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[23]->column3)?$data->question6[23]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[24]->column3)?$data->question6[24]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[25]->column3)?$data->question6[25]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[26]->column3)?$data->question6[26]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[27]->column3)?$data->question6[27]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[28]->column3)?$data->question6[28]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[29]->column3)?$data->question6[29]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[30]->column3)?$data->question6[30]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question6[31]->column3)?$data->question6[31]->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>> 40 (2)</h4></td>
                        <td width="3%"><?= isset($data->question6[0]->column4)?$data->question6[0]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[1]->column4)?$data->question6[1]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[2]->column4)?$data->question6[2]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[3]->column4)?$data->question6[3]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[4]->column4)?$data->question6[4]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[5]->column4)?$data->question6[5]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[6]->column4)?$data->question6[6]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[7]->column4)?$data->question6[7]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[8]->column4)?$data->question6[8]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[9]->column4)?$data->question6[9]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[10]->column4)?$data->question6[10]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[11]->column4)?$data->question6[11]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[12]->column4)?$data->question6[12]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[13]->column4)?$data->question6[13]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[14]->column4)?$data->question6[14]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[15]->column4)?$data->question6[15]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[16]->column4)?$data->question6[16]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[17]->column4)?$data->question6[17]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[18]->column4)?$data->question6[18]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[19]->column4)?$data->question6[19]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[20]->column4)?$data->question6[20]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[21]->column4)?$data->question6[21]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[22]->column4)?$data->question6[22]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[23]->column4)?$data->question6[23]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[24]->column4)?$data->question6[24]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[25]->column4)?$data->question6[25]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[26]->column4)?$data->question6[26]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[27]->column4)?$data->question6[27]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[28]->column4)?$data->question6[28]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[29]->column4)?$data->question6[29]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[30]->column4)?$data->question6[30]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question6[31]->column4)?$data->question6[31]->column4:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>dok1 (1)</h4></td>
                        <td width="3%"><?= isset($data->question6[0]->column5)?$data->question6[0]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[1]->column5)?$data->question6[1]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[2]->column5)?$data->question6[2]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[3]->column5)?$data->question6[3]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[4]->column5)?$data->question6[4]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[5]->column5)?$data->question6[5]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[6]->column5)?$data->question6[6]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[7]->column5)?$data->question6[7]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[8]->column5)?$data->question6[8]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[9]->column5)?$data->question6[9]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[10]->column5)?$data->question6[10]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[11]->column5)?$data->question6[11]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[12]->column5)?$data->question6[12]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[13]->column5)?$data->question6[13]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[14]->column5)?$data->question6[14]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[15]->column5)?$data->question6[15]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[16]->column5)?$data->question6[16]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[17]->column5)?$data->question6[17]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[18]->column5)?$data->question6[18]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[19]->column5)?$data->question6[19]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[20]->column5)?$data->question6[20]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[21]->column5)?$data->question6[21]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[22]->column5)?$data->question6[22]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[23]->column5)?$data->question6[23]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[24]->column5)?$data->question6[24]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[25]->column5)?$data->question6[25]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[26]->column5)?$data->question6[26]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[27]->column5)?$data->question6[27]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[28]->column5)?$data->question6[28]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[29]->column5)?$data->question6[29]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[30]->column5)?$data->question6[30]->column5:'' ?></td>
                        <td width="3%"><?= isset($data->question6[31]->column5)?$data->question6[31]->column5:'' ?></td>
                    </tr>
               </table><br>

               <table width="100%">
                <tr>
                    <td width="20%"><h4>Oksilosin U/L</h4></td>
                    <td width="2%">:</td>
                    <td width="78%"><?= isset($data->question7->oksilosin)?$data->question7->oksilosin:'' ?></td>
                </tr>
                <tr>
                    <td width="20%"><h4>Tetes/Menit</h4></td>
                    <td width="2%">:</td>
                    <td width="78%"><?= isset($data->question7->tetes)?$data->question7->tetes:'' ?></td>
                </tr>
            </table><br>

            <h3>Nadi dan Tekanan Darah</h3><br>

            <table width="100%" border="1">
                <tr>
                    <td colspan="3"><h3>Obat dan Cairan IV</h3></td>
                    <td colspan="30"><?= isset($data->obat)?$data->obat:'' ?></td>
                </tr>
                <tr>
                    <td width="3%"><h4>180</h4></td>
                    <td width="3%"><?= isset($data->question8[0]->column1)?$data->question8[0]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[1]->column1)?$data->question8[1]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[2]->column1)?$data->question8[2]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[3]->column1)?$data->question8[3]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[4]->column1)?$data->question8[4]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[5]->column1)?$data->question8[5]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[6]->column1)?$data->question8[6]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[7]->column1)?$data->question8[7]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[8]->column1)?$data->question8[8]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[9]->column1)?$data->question8[9]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[10]->column1)?$data->question8[10]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[11]->column1)?$data->question8[11]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[12]->column1)?$data->question8[12]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[13]->column1)?$data->question8[13]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[14]->column1)?$data->question8[14]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[15]->column1)?$data->question8[15]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[16]->column1)?$data->question8[16]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[17]->column1)?$data->question8[17]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[18]->column1)?$data->question8[18]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[19]->column1)?$data->question8[19]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[20]->column1)?$data->question8[20]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[21]->column1)?$data->question8[21]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[22]->column1)?$data->question8[22]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[23]->column1)?$data->question8[23]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[24]->column1)?$data->question8[24]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[25]->column1)?$data->question8[25]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[26]->column1)?$data->question8[26]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[27]->column1)?$data->question8[27]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[28]->column1)?$data->question8[28]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[29]->column1)?$data->question8[29]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[30]->column1)?$data->question8[30]->column1:'' ?></td>
                    <td width="3%"><?= isset($data->question8[31]->column1)?$data->question8[31]->column1:'' ?></td>
                </tr>
            </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:right;font-size:12px"></p>
        </div>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <hr color="black">

            <center><h4>PERSALINAN NORMAL</h4></center>

            <div style="font-size:12px">

                <table width="100%" border="1">
                    <tr>
                        <td width="3%"><h4>170</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column2)?$data->question8[0]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column2)?$data->question8[1]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column2)?$data->question8[2]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column2)?$data->question8[3]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column2)?$data->question8[4]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column2)?$data->question8[5]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column2)?$data->question8[6]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column2)?$data->question8[7]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column2)?$data->question8[8]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column2)?$data->question8[9]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column2)?$data->question8[10]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column2)?$data->question8[11]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column2)?$data->question8[12]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column2)?$data->question8[13]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column2)?$data->question8[14]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column2)?$data->question8[15]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column2)?$data->question8[16]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column2)?$data->question8[17]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column2)?$data->question8[18]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column2)?$data->question8[19]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column2)?$data->question8[20]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column2)?$data->question8[21]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column2)?$data->question8[22]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column2)?$data->question8[23]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column2)?$data->question8[24]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column2)?$data->question8[25]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column2)?$data->question8[26]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column2)?$data->question8[27]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column2)?$data->question8[28]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column2)?$data->question8[29]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column2)?$data->question8[30]->column2:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column2)?$data->question8[31]->column2:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>160</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column3)?$data->question8[0]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column3)?$data->question8[1]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column3)?$data->question8[2]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column3)?$data->question8[3]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column3)?$data->question8[4]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column3)?$data->question8[5]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column3)?$data->question8[6]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column3)?$data->question8[7]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column3)?$data->question8[8]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column3)?$data->question8[9]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column3)?$data->question8[10]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column3)?$data->question8[11]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column3)?$data->question8[12]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column3)?$data->question8[13]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column3)?$data->question8[14]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column3)?$data->question8[15]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column3)?$data->question8[16]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column3)?$data->question8[17]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column3)?$data->question8[18]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column3)?$data->question8[19]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column3)?$data->question8[20]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column3)?$data->question8[21]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column3)?$data->question8[22]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column3)?$data->question8[23]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column3)?$data->question8[24]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column3)?$data->question8[25]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column3)?$data->question8[26]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column3)?$data->question8[27]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column3)?$data->question8[28]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column3)?$data->question8[29]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column3)?$data->question8[30]->column3:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column3)?$data->question8[31]->column3:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>150</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column4)?$data->question8[0]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column4)?$data->question8[1]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column4)?$data->question8[2]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column4)?$data->question8[3]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column4)?$data->question8[4]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column4)?$data->question8[5]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column4)?$data->question8[6]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column4)?$data->question8[7]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column4)?$data->question8[8]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column4)?$data->question8[9]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column4)?$data->question8[10]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column4)?$data->question8[11]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column4)?$data->question8[12]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column4)?$data->question8[13]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column4)?$data->question8[14]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column4)?$data->question8[15]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column4)?$data->question8[16]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column4)?$data->question8[17]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column4)?$data->question8[18]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column4)?$data->question8[19]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column4)?$data->question8[20]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column4)?$data->question8[21]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column4)?$data->question8[22]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column4)?$data->question8[23]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column4)?$data->question8[24]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column4)?$data->question8[25]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column4)?$data->question8[26]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column4)?$data->question8[27]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column4)?$data->question8[28]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column4)?$data->question8[29]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column4)?$data->question8[30]->column4:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column4)?$data->question8[31]->column4:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>140</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column6)?$data->question8[0]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column6)?$data->question8[1]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column6)?$data->question8[2]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column6)?$data->question8[3]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column6)?$data->question8[4]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column6)?$data->question8[5]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column6)?$data->question8[6]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column6)?$data->question8[7]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column6)?$data->question8[8]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column6)?$data->question8[9]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column6)?$data->question8[10]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column6)?$data->question8[11]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column6)?$data->question8[12]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column6)?$data->question8[13]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column6)?$data->question8[14]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column6)?$data->question8[15]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column6)?$data->question8[16]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column6)?$data->question8[17]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column6)?$data->question8[18]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column6)?$data->question8[19]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column6)?$data->question8[20]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column6)?$data->question8[21]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column6)?$data->question8[22]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column6)?$data->question8[23]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column6)?$data->question8[24]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column6)?$data->question8[25]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column6)?$data->question8[26]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column6)?$data->question8[27]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column6)?$data->question8[28]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column6)?$data->question8[29]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column6)?$data->question8[30]->column6:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column6)?$data->question8[31]->column6:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>130</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column7)?$data->question8[0]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column7)?$data->question8[1]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column7)?$data->question8[2]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column7)?$data->question8[3]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column7)?$data->question8[4]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column7)?$data->question8[5]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column7)?$data->question8[6]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column7)?$data->question8[7]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column7)?$data->question8[8]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column7)?$data->question8[9]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column7)?$data->question8[10]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column7)?$data->question8[11]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column7)?$data->question8[12]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column7)?$data->question8[13]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column7)?$data->question8[14]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column7)?$data->question8[15]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column7)?$data->question8[16]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column7)?$data->question8[17]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column7)?$data->question8[18]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column7)?$data->question8[19]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column7)?$data->question8[20]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column7)?$data->question8[21]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column7)?$data->question8[22]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column7)?$data->question8[23]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column7)?$data->question8[24]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column7)?$data->question8[25]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column7)?$data->question8[26]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column7)?$data->question8[27]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column7)?$data->question8[28]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column7)?$data->question8[29]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column7)?$data->question8[30]->column7:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column7)?$data->question8[31]->column7:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>120</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column8)?$data->question8[0]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column8)?$data->question8[1]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column8)?$data->question8[2]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column8)?$data->question8[3]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column8)?$data->question8[4]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column8)?$data->question8[5]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column8)?$data->question8[6]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column8)?$data->question8[7]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column8)?$data->question8[8]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column8)?$data->question8[9]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column8)?$data->question8[10]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column8)?$data->question8[11]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column8)?$data->question8[12]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column8)?$data->question8[13]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column8)?$data->question8[14]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column8)?$data->question8[15]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column8)?$data->question8[16]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column8)?$data->question8[17]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column8)?$data->question8[18]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column8)?$data->question8[19]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column8)?$data->question8[20]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column8)?$data->question8[21]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column8)?$data->question8[22]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column8)?$data->question8[23]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column8)?$data->question8[24]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column8)?$data->question8[25]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column8)?$data->question8[26]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column8)?$data->question8[27]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column8)?$data->question8[28]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column8)?$data->question8[29]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column8)?$data->question8[30]->column8:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column8)?$data->question8[31]->column8:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>110</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column9)?$data->question8[0]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column9)?$data->question8[1]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column9)?$data->question8[2]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column9)?$data->question8[3]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column9)?$data->question8[4]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column9)?$data->question8[5]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column9)?$data->question8[6]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column9)?$data->question8[7]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column9)?$data->question8[8]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column9)?$data->question8[9]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column9)?$data->question8[10]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column9)?$data->question8[11]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column9)?$data->question8[12]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column9)?$data->question8[13]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column9)?$data->question8[14]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column9)?$data->question8[15]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column9)?$data->question8[16]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column9)?$data->question8[17]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column9)?$data->question8[18]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column9)?$data->question8[19]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column9)?$data->question8[20]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column9)?$data->question8[21]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column9)?$data->question8[22]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column9)?$data->question8[23]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column9)?$data->question8[24]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column9)?$data->question8[25]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column9)?$data->question8[26]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column9)?$data->question8[27]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column9)?$data->question8[28]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column9)?$data->question8[29]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column9)?$data->question8[30]->column9:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column9)?$data->question8[31]->column9:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>100</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column10)?$data->question8[0]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column10)?$data->question8[1]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column10)?$data->question8[2]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column10)?$data->question8[3]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column10)?$data->question8[4]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column10)?$data->question8[5]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column10)?$data->question8[6]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column10)?$data->question8[7]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column10)?$data->question8[8]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column10)?$data->question8[9]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column10)?$data->question8[10]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column10)?$data->question8[11]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column10)?$data->question8[12]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column10)?$data->question8[13]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column10)?$data->question8[14]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column10)?$data->question8[15]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column10)?$data->question8[16]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column10)?$data->question8[17]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column10)?$data->question8[18]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column10)?$data->question8[19]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column10)?$data->question8[20]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column10)?$data->question8[21]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column10)?$data->question8[22]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column10)?$data->question8[23]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column10)?$data->question8[24]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column10)?$data->question8[25]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column10)?$data->question8[26]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column10)?$data->question8[27]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column10)?$data->question8[28]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column10)?$data->question8[29]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column10)?$data->question8[30]->column10:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column10)?$data->question8[31]->column10:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>90</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column11)?$data->question8[0]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column11)?$data->question8[1]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column11)?$data->question8[2]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column11)?$data->question8[3]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column11)?$data->question8[4]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column11)?$data->question8[5]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column11)?$data->question8[6]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column11)?$data->question8[7]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column11)?$data->question8[8]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column11)?$data->question8[9]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column11)?$data->question8[10]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column11)?$data->question8[11]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column11)?$data->question8[12]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column11)?$data->question8[13]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column11)?$data->question8[14]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column11)?$data->question8[15]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column11)?$data->question8[16]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column11)?$data->question8[17]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column11)?$data->question8[18]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column11)?$data->question8[19]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column11)?$data->question8[20]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column11)?$data->question8[21]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column11)?$data->question8[22]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column11)?$data->question8[23]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column11)?$data->question8[24]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column11)?$data->question8[25]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column11)?$data->question8[26]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column11)?$data->question8[27]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column11)?$data->question8[28]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column11)?$data->question8[29]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column11)?$data->question8[30]->column11:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column11)?$data->question8[31]->column11:'' ?></td>
                    </tr>
                    <tr>
                        <td width="3%"><h4>80</h4></td>
                        <td width="3%"><?= isset($data->question8[0]->column12)?$data->question8[0]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[1]->column12)?$data->question8[1]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[2]->column12)?$data->question8[2]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[3]->column12)?$data->question8[3]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[4]->column12)?$data->question8[4]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[5]->column12)?$data->question8[5]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[6]->column12)?$data->question8[6]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[7]->column12)?$data->question8[7]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[8]->column12)?$data->question8[8]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[9]->column12)?$data->question8[9]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[10]->column12)?$data->question8[10]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[11]->column12)?$data->question8[11]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[12]->column12)?$data->question8[12]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[13]->column12)?$data->question8[13]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[14]->column12)?$data->question8[14]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[15]->column12)?$data->question8[15]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[16]->column12)?$data->question8[16]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[17]->column12)?$data->question8[17]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[18]->column12)?$data->question8[18]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[19]->column12)?$data->question8[19]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[20]->column12)?$data->question8[20]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[21]->column12)?$data->question8[21]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[22]->column12)?$data->question8[22]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[23]->column12)?$data->question8[23]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[24]->column12)?$data->question8[24]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[25]->column12)?$data->question8[25]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[26]->column12)?$data->question8[26]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[27]->column12)?$data->question8[27]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[28]->column12)?$data->question8[28]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[29]->column12)?$data->question8[29]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[30]->column12)?$data->question8[30]->column12:'' ?></td>
                        <td width="3%"><?= isset($data->question8[31]->column12)?$data->question8[31]->column12:'' ?></td>
                    </tr>
                    <tr>
                    <td width="3%"><h4>70</h4></td>
                    <td width="3%"><?= isset($data->question8[0]->column13)?$data->question8[0]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[1]->column13)?$data->question8[1]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[2]->column13)?$data->question8[2]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[3]->column13)?$data->question8[3]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[4]->column13)?$data->question8[4]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[5]->column13)?$data->question8[5]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[6]->column13)?$data->question8[6]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[7]->column13)?$data->question8[7]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[8]->column13)?$data->question8[8]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[9]->column13)?$data->question8[9]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[10]->column13)?$data->question8[10]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[11]->column13)?$data->question8[11]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[12]->column13)?$data->question8[12]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[13]->column13)?$data->question8[13]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[14]->column13)?$data->question8[14]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[15]->column13)?$data->question8[15]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[16]->column13)?$data->question8[16]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[17]->column13)?$data->question8[17]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[18]->column13)?$data->question8[18]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[19]->column13)?$data->question8[19]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[20]->column13)?$data->question8[20]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[21]->column13)?$data->question8[21]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[22]->column13)?$data->question8[22]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[23]->column13)?$data->question8[23]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[24]->column13)?$data->question8[24]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[25]->column13)?$data->question8[25]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[26]->column13)?$data->question8[26]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[27]->column13)?$data->question8[27]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[28]->column13)?$data->question8[28]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[29]->column13)?$data->question8[29]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[30]->column13)?$data->question8[30]->column13:'' ?></td>
                    <td width="3%"><?= isset($data->question8[31]->column13)?$data->question8[31]->column13:'' ?></td>
                </tr>
                <tr>
                    <td width="3%"><h4>60</h4></td>
                    <td width="3%"><?= isset($data->question8[0]->column14)?$data->question8[0]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[1]->column14)?$data->question8[1]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[2]->column14)?$data->question8[2]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[3]->column14)?$data->question8[3]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[4]->column14)?$data->question8[4]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[5]->column14)?$data->question8[5]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[6]->column14)?$data->question8[6]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[7]->column14)?$data->question8[7]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[8]->column14)?$data->question8[8]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[9]->column14)?$data->question8[9]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[10]->column14)?$data->question8[10]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[11]->column14)?$data->question8[11]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[12]->column14)?$data->question8[12]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[13]->column14)?$data->question8[13]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[14]->column14)?$data->question8[14]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[15]->column14)?$data->question8[15]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[16]->column14)?$data->question8[16]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[17]->column14)?$data->question8[17]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[18]->column14)?$data->question8[18]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[19]->column14)?$data->question8[19]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[20]->column14)?$data->question8[20]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[21]->column14)?$data->question8[21]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[22]->column14)?$data->question8[22]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[23]->column14)?$data->question8[23]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[24]->column14)?$data->question8[24]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[25]->column14)?$data->question8[25]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[26]->column14)?$data->question8[26]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[27]->column14)?$data->question8[27]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[28]->column14)?$data->question8[28]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[29]->column14)?$data->question8[29]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[30]->column14)?$data->question8[30]->column14:'' ?></td>
                    <td width="3%"><?= isset($data->question8[31]->column14)?$data->question8[31]->column14:'' ?></td>
                </tr>
                <tr>
                    <td width="3%"><h4>Suhu (C)</h4></td>
                    <td width="3%"><?= isset($data->question8[0]->column15)?$data->question8[0]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[1]->column15)?$data->question8[1]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[2]->column15)?$data->question8[2]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[3]->column15)?$data->question8[3]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[4]->column15)?$data->question8[4]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[5]->column15)?$data->question8[5]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[6]->column15)?$data->question8[6]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[7]->column15)?$data->question8[7]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[8]->column15)?$data->question8[8]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[9]->column15)?$data->question8[9]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[10]->column15)?$data->question8[10]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[11]->column15)?$data->question8[11]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[12]->column15)?$data->question8[12]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[13]->column15)?$data->question8[13]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[14]->column15)?$data->question8[14]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[15]->column15)?$data->question8[15]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[16]->column15)?$data->question8[16]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[17]->column15)?$data->question8[17]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[18]->column15)?$data->question8[18]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[19]->column15)?$data->question8[19]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[20]->column15)?$data->question8[20]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[21]->column15)?$data->question8[21]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[22]->column15)?$data->question8[22]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[23]->column15)?$data->question8[23]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[24]->column15)?$data->question8[24]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[25]->column15)?$data->question8[25]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[26]->column15)?$data->question8[26]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[27]->column15)?$data->question8[27]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[28]->column15)?$data->question8[28]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[29]->column15)?$data->question8[29]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[30]->column15)?$data->question8[30]->column15:'' ?></td>
                    <td width="3%"><?= isset($data->question8[31]->column15)?$data->question8[31]->column15:'' ?></td>
                </tr>
                </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:right;font-size:12px"></p>
        </div>
        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <hr color="black">

            <center><h4>PERSALINAN NORMAL</h4></center>

            <div style="font-size:12px">

            <h3>Urine</h3><br>

            <table width="100%" border="1">
                <tr>
                    <td width="3%"><h4>Protein</h4></td>
                    <td width="3%"><?= isset($data->question9[0]->protein)?$data->question9[0]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[1]->protein)?$data->question9[1]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[2]->protein)?$data->question9[2]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[3]->protein)?$data->question9[3]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[4]->protein)?$data->question9[4]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[5]->protein)?$data->question9[5]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[6]->protein)?$data->question9[6]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[7]->protein)?$data->question9[7]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[8]->protein)?$data->question9[8]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[9]->protein)?$data->question9[9]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[10]->protein)?$data->question9[10]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[11]->protein)?$data->question9[11]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[12]->protein)?$data->question9[12]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[13]->protein)?$data->question9[13]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[14]->protein)?$data->question9[14]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[15]->protein)?$data->question9[15]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[16]->protein)?$data->question9[16]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[17]->protein)?$data->question9[17]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[18]->protein)?$data->question9[18]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[19]->protein)?$data->question9[19]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[20]->protein)?$data->question9[20]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[21]->protein)?$data->question9[21]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[22]->protein)?$data->question9[22]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[23]->protein)?$data->question9[23]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[24]->protein)?$data->question9[24]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[25]->protein)?$data->question9[25]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[26]->protein)?$data->question9[26]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[27]->protein)?$data->question9[27]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[28]->protein)?$data->question9[28]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[29]->protein)?$data->question9[29]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[30]->protein)?$data->question9[30]->protein:'' ?></td>
                    <td width="3%"><?= isset($data->question9[31]->protein)?$data->question9[31]->protein:'' ?></td>
                </tr>
                <tr>
                    <td width="3%"><h4>Aseton</h4></td>
                    <td width="3%"><?= isset($data->question9[0]->aseton)?$data->question9[0]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[1]->aseton)?$data->question9[1]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[2]->aseton)?$data->question9[2]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[3]->aseton)?$data->question9[3]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[4]->aseton)?$data->question9[4]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[5]->aseton)?$data->question9[5]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[6]->aseton)?$data->question9[6]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[7]->aseton)?$data->question9[7]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[8]->aseton)?$data->question9[8]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[9]->aseton)?$data->question9[9]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[10]->aseton)?$data->question9[10]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[11]->aseton)?$data->question9[11]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[12]->aseton)?$data->question9[12]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[13]->aseton)?$data->question9[13]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[14]->aseton)?$data->question9[14]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[15]->aseton)?$data->question9[15]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[16]->aseton)?$data->question9[16]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[17]->aseton)?$data->question9[17]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[18]->aseton)?$data->question9[18]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[19]->aseton)?$data->question9[19]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[20]->aseton)?$data->question9[20]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[21]->aseton)?$data->question9[21]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[22]->aseton)?$data->question9[22]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[23]->aseton)?$data->question9[23]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[24]->aseton)?$data->question9[24]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[25]->aseton)?$data->question9[25]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[26]->aseton)?$data->question9[26]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[27]->aseton)?$data->question9[27]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[28]->aseton)?$data->question9[28]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[29]->aseton)?$data->question9[29]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[30]->aseton)?$data->question9[30]->aseton:'' ?></td>
                    <td width="3%"><?= isset($data->question9[31]->aseton)?$data->question9[31]->aseton:'' ?></td>
                </tr>
                <tr>
                    <td width="3%"><h4>Volume</h4></td>
                    <td width="3%"><?= isset($data->question9[0]->volume)?$data->question9[0]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[1]->volume)?$data->question9[1]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[2]->volume)?$data->question9[2]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[3]->volume)?$data->question9[3]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[4]->volume)?$data->question9[4]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[5]->volume)?$data->question9[5]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[6]->volume)?$data->question9[6]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[7]->volume)?$data->question9[7]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[8]->volume)?$data->question9[8]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[9]->volume)?$data->question9[9]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[10]->volume)?$data->question9[10]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[11]->volume)?$data->question9[11]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[12]->volume)?$data->question9[12]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[13]->volume)?$data->question9[13]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[14]->volume)?$data->question9[14]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[15]->volume)?$data->question9[15]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[16]->volume)?$data->question9[16]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[17]->volume)?$data->question9[17]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[18]->volume)?$data->question9[18]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[19]->volume)?$data->question9[19]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[20]->volume)?$data->question9[20]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[21]->volume)?$data->question9[21]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[22]->volume)?$data->question9[22]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[23]->volume)?$data->question9[23]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[24]->volume)?$data->question9[24]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[25]->volume)?$data->question9[25]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[26]->volume)?$data->question9[26]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[27]->volume)?$data->question9[27]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[28]->volume)?$data->question9[28]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[29]->volume)?$data->question9[29]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[30]->volume)?$data->question9[30]->volume:'' ?></td>
                    <td width="3%"><?= isset($data->question9[31]->volume)?$data->question9[31]->volume:'' ?></td>
                </tr>
            </table>
            </div>
            <br><br><br><br><br><br><br><br><br><br>
            <p style="text-align:right;font-size:12px"></p>
        </div>
    </body>
    </html>