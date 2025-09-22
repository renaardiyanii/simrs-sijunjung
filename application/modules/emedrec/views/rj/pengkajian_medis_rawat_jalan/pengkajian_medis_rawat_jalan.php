<?php 

$data = isset($pengkajian_medis->formjson)?json_decode($pengkajian_medis->formjson):'';
//  var_dump($data);

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
   
   <body class="A4" >
       <div class="A4 sheet  padding-fix-10mm">
       
            <header>
                <?php $this->load->view('emedrec/rj/header_print') ?>
            </header>

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
                        <div style="min-height:150px">
                            <P>A. ANAMNESIS</p>
                            <p style="margin-left:20px">Keluhan Utama : <?= isset($data->question1->kel_utama->anamnesis1)?$data->question1->kel_utama->anamnesis1:'' ?></P>
                            <p style="margin-left:20px">Anamnesis Khusus : <?= isset($data->question1->anamnesis->anamnesis1)?$data->question1->anamnesis->anamnesis1:'' ?></p>  
                        </div>

                        <div style="min-height:100px">
                            <P>B. PEMERIKSAAN FISIK</p>
                                <table border="0" width="100%" cellpadding="5px">
                                    <tr>
                                        <td width="12%">Tanda Vital :</td>
                                        <td width="30%">
                                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question2->td)?"checked" : "disabled";?>>
                                            <label for="sendiri">Tekanan Darah : <?=isset($data->question2->td)?$data->question2->td:'' ?> mmHg</label><br>
                                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question2->pernafasan)?"checked" : "disabled";?>>
                                            <label for="sendiri">Pernafasan : <?=isset($data->question2->pernafasan)?$data->question2->pernafasan:'' ?> x/menit</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question2->nadi)?"checked" : "disabled";?>>
                                            <label for="sendiri">Nadi : <?=isset($data->question2->nadi)?$data->question2->nadi:'' ?> x/menit</label><br>
                                            <input type="checkbox" name="sendiri" id="sendiri" value=""<?php echo isset($data->question2->suhu)?"checked" : "disabled";?>>
                                            <label for="sendiri">Suhu : <?=isset($data->question2->suhu)?$data->question2->suhu:'' ?> °C </label>
                                        </td>
                                        
                                     </tr>
                                     <tr>
                                         <td>
                                             <p style="margin-left:20px"> <?=isset($data->question7)?str_replace("\n","<br>",$data->question7):'' ?></P>
                                   
                                        </td>
                                     </tr>
                                </table>
                        </div>

                        <div style="min-height:120px">
                            <P>C. PEMERIKSAAN PENUNJANG</p>
                            <p style="margin-left:20px"> <?=isset($data->question3)?str_replace("\n","<br>",$data->question3):'' ?></P>
                        </div>

                        <div style="min-height:120px">
                            <P>C. DIAGNOSIS</p>
                            <p style="margin-left:20px"><?=isset($data->question4)?str_replace("\n","<br>",$data->question4):'' ?></P>
                        </div>
                        

                        <div style="min-height:120px">
                            <P>C. PENGOBATAN</p>
                            <p style="margin-left:20px"><?=isset($data->question5)?str_replace("\n","<br>",$data->question5):'' ?></P>
                        </div>

                        <div style="min-height:120px">
                            <P>C. PERENCANAAN</p>
                            <p style="margin-left:20px"><?=isset($data->question6)?str_replace("\n","<br>",$data->question6):'' ?></P>
                        </div>
                    </td>
                </tr>

              


            </table>


            <p style="font-size:7px;font-style:italic">*)Coret yang tidak perlu<br>
            </p><br><br><br>
             
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.02.a/RJ-GN </p>
                </div>     
            </div> 
            
        </div>

    
   
      
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   