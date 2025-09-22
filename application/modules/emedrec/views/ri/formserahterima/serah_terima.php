<?php 
$result = array_chunk($serah_terima, 1);
//  var_dump($result[0]);
?>

<!DOCTYPE html>
<html lang="en">
    <style>
        #footer{
            position:absolute;
            bottom:3px;
            left:40px;
            font-size:8pt;
        }
          body{
            margin: 0;
            padding: 0;
        }
        .header-parent{
            display: flex;
            justify-content: space-between;

        }
        .right{
            display: flex;
            align-items: flex-end;
            flex-direction: column;
        }
        .patient-info{
            border: 1px solid black;
            padding: 1em;
            display: flex;
            border-radius: 10px;
        }
        #date{
            display: flex;
            justify-content: space-between;
        }
        .kotak{
            
            height: 10;
            width: 10;
            /* border: 1px solid black; */
        }

        .jeniskasus{
            margin-top: 0.5em;
            margin-bottom:0.5em;
            /* padding: 0.5em; */
          
            display: flex;
        }
        .anamnesis{
           border: 0; 
        }
        .bold{
            font-weight: bold;
        }

        .two-row{
            display: flex;
            /* justify-content: space-between; */

        }
        
        .pemeriksaan-umum{
            display: flex;
            justify-content: space-between;
            margin-right: 5em;
        }
        .column-pemeriksaan{
            margin-left: 2px;
            /* margin-right: ; */
        }
        .addspacing{
            margin-right: 10px;
            margin-left: 20px;
        }
        .status{
            margin-top:0.25em;
            margin-bottom:0.25em;
            min-height:50px;
            /* background-color:red; */
        }
        .flexstatus{
            display: flex;
            justify-content: space-between;
        }

        #page2{
            margin-top:100px;
        }
        .footer{
            display: flex;
            justify-content: flex-end;
            margin-top:200px;
        }
        .space{
            margin-left: 10px;
        }
        .spacekosong{
            margin-top:200px;
            margin-bottom:200px;
        }
        .kesimpulan-akhir-content{
            margin-left: 5px;
            
        }
        
        .content-parent{
            display: flex;
            /* margin-right: 100px; */
        }
        .content{
            margin-right: 30px;
        }
        .ttd{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-end;
            margin-right: 50px;
        }
        #childttd{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .box{
            margin-top:0.25em;
            min-height:50px;
            margin-bottom:0.25em;
        }
    </style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catatan Serah Terima (Hand Over) Asuhan Pasien</title>
</head>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4" >
    <?php
    if(count($result)>0){
        // foreach($result as $val){
            for($i=0;$i<count($result);$i++){
            
            ?>
        <div class="A4 sheet  padding-fix-10mm">
        <!-- <div class=""> -->
          
        <?php $this->load->view('emedrec/ri/header_print') ?>

            <p style ="text-align:center;font-size:14px">CATATAN SERAH TERIMA (HAND OVER) ASUHAN PASIEN</p>
            <div style="min-height:870px">
            <table id="data" border="1">
                <tr>
                    <th style="width: 15%;font-size:10px">Tanggal / Jam</th>
                    <th style="width: 15%;font-size:10px">Profesi</th>
                    <th style="width: 30%;font-size:10px">Catatan</th>
                    <th style="width: 20%;font-size:10px">Petugas yang menyerahkan
                        (Nama, paraf)
                        </th>
                    <th style="width: 20%;font-size:10px">Petugas yang menerima (Nama, paraf)</th>
                </tr>
                <?php
                foreach($result[$i] as $val){
                    $data = json_decode($val->formjson);
                    
                ?>
                <tr>
                    <td style="vertical-align: middle;text-align:center;font-size:11px"><?= isset($data->waktu)?date('d-m-Y H:i',strtotime($data->waktu)):"" ?></td>
                    <td style="text-align:center;vertical-align: middle;font-size:11px"><?= isset($data->profesi)?$data->profesi:"" ?></td>
                    <td style="padding:5px!important;">
                        <br>
                        <span style="font-size:11px">S:</span><br><br>
                        <span style="font-size:11px"><?= isset($data->situations)?$data->situations:'' ?></span><br><br>
                        <span style="font-size:11px">B:</span><br><br>
                        <span style="font-size:11px"><?= isset($data->background)?str_replace([PHP_EOL,"<br>","\r","\n"],'<br>',$data->background):'' ?></span><br><br>
                        <span style="font-size:11px">A:</span><br><br>
                        <span style="font-size:11px"><?= isset($data->asessment)?$data->asessment:'' ?></span><br><br>
                        <span style="font-size:11px">R:</span><br><br>
                        <span style="font-size:11px"><?= isset($pasien_iri)?count($pasien_iri)!=0?(isset($pasien_iri[0]->nm_ruang)?$pasien_iri[0]->nm_ruang:''):'':(isset($data->recommendation)?$data->recommendation:'') ?></span><br><br>
                        <br>
                    </td>
                    <td style="text-align:center; vertical-align: middle;font-size:11px">
                    <?php 
                    $query ="";
                    // var_dump($data->petugas1);
                    if(isset($data->petugas1)){
                        
                        $id = explode('-',$data->petugas1);
                        $id_pisah = $id[1];
                        // echo $id;
                        $query = $this->db->query("SELECT ttd FROM hmis_users WHERE userid=$id_pisah")->row();
                                            
                    }
                    // var_dump($query);
                    if(isset($query)){
                    ?>
                    <center><img width="120px" src="<?= isset($query->ttd)?$query->ttd:'' ?>" alt=""></center>
                    <?php } ?><br>
                    <?= isset($data->petugas1)?explode('-',$data->petugas1)[0]:"" ?>
                    
                    
                    </td>
                    <td style="text-align:center; vertical-align: middle;font-size:11px">
                
                    <?php 
                    $query ="";
                    // var_dump($data->petugas2);die();
                    if(isset($data->petugas2)){
                        $id_petugas = explode('-',$data->petugas2);
                        // var_dump(explode('-',$data->petugas2)[1]);die();
                        $id = $id_petugas[1]??"";
                        $query = $id!=""?$this->db->query("SELECT ttd FROM hmis_users WHERE userid=$id")->row():null;
                        
                    }
                    if($query){
                    ?>
                <center> <img width="120px" src="<?= isset($query->ttd)?$query->ttd:'' ?>" alt=""><center><br>
                    <?= isset($data->petugas2)?$id_petugas[0]:"" ?>
                    <?php } ?>

                </td>
                </tr>
                <?php } ?>
            </table> 
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
    <?php 
        }
        }else{ ?>
        <div class="A4 sheet  padding-fix-10mm">
        <?php $this->load->view('emedrec/ri/header_print') ?>

            <center><h3>CATATAN SERAH TERIMA (HAND OVER) ASUHAN PASIEN</h3></center>
            <table id="data" border="1">
            <tr>
                <th style="width: 15%;">Tanggal / Jam</th>
                <th style="width: 15%;">Profesi</th>
                <th style="width: 30%;">Catatan</th>
                <th style="width: 20%;">Petugas yang menyerahkan
                    (Nama, paraf)
                    </th>
                <th style="width: 20%;">Petugas yang menerima (Nama, paraf)</th>
            </tr>
            <tr style="height: 730px;">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>   

        <div id="footer">
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 1 dari 1</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>
        
       
        </div>
    <?php } ?>
</body>
</html>