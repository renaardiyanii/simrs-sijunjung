<?php 

$value = isset($get_data_cppt)?$get_data_cppt:'';
$value1 = isset($get_soap_medik)?$get_soap_medik:'';
//  var_dump($value);

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
                        <p>(Diisi Oleh Petugas)</p>
                    </td>
                    <td style="font-style:italic">
                        <p align="right">Halaman 1 dari 2</p>
                    </td>
                </tr>
            </table>

            <div style="min-height:800px">

            <table border="1" width="100%" cellpadding="5px">
                <tr>
                    <th width="10%"> TANGGAL / JAM</th>
                    <th width="10%">PROFESI/BAGIAN</th>
                    <th width="50%">
                        HASIL PEMERIKSAAN,ANALISA,RENCANA,PENATALAKSANAAN PASIEN
                        <p style="font-size:10px">(Dituliskan dengan format SOAP/ADIME, disertai dengan target yang terukur,evaluasi hasil tatalaksana dituliskan dalam assesmen,harap bubuhkan stempel nama,dan paraf pada setiap akhir catatan)</p>
                    </th>
                    <th width="15%">
                        Intruksi Tenaga Kesehatan termasuk pasca Bedah/Prosedur
                        <p style="font-size:10px">(Intruksi Ditulis dengan Rinci dan Jelas)</p>
                    </th>
                    <th width="15%">
                        VERIFIKASI DPJP
                        <p style="font-size:10px">(Bubuhkan Stempel Nama,Paraf,Tgl,Jam)</p>
                    </th>
                </tr>
                <tr>
                    <td>
                    <?= isset($value->tgl_input)?date('d-m-Y',strtotime($value->tgl_input)):'' ?>
                    </td>
                    <td></td>
                    <td>
                        <table border="0" width="100%">
                            <tr>
                                <td width=5%><span class="text_body soap"> S.</span></td>
                                <td>
                                        <?php
                                        if (!empty($value1->subjective_dokter)) {
                                            echo nl2br(str_replace('-', '<br>', $value1->subjective_dokter));
                                        } else {
                                            if (!empty($value->subjective_perawat)) {
                                                echo nl2br(str_replace('-', '<br>', $value->subjective_perawat));
                                            }
                                        }
                                        ?>
                                    </td>
                            </tr>
                            <tr>
                                <td width=5%><span class="text_body soap">O.</span></td>
                                <td>
                                    <?php
                                    if (!empty($value1->objective_dokter)) {
                                        echo nl2br(str_replace('-', '<br>', $value1->objective_dokter));
                                    } else {
                                        if (!empty($value->objective_perawat)) {
                                            echo nl2br(str_replace('-', '<br>', $value->objective_perawat));
                                        }
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width=5%><span class="text_body soap">A.</span></td>
                                <td>
                                    <?= isset($value1->assesment_dokter) && $value1->assesment_dokter != "" 
                                        ? nl2br($value1->assesment_dokter) 
                                        : '-'; ?>
                                </td>
                             </tr>
                            <tr>
                                <td width=5%><span class="text_body soap">P.</span></td>
                                <td>
                                    <?php 
                                    if(isset($value->id_poli)){
                                        if($value->id_poli == 'BC00'){
                                    
                                    ?>
                                        <span>Obat :</span><br>
                                        <?= isset($value1->plan_dokter) 
                                        ? nl2br($value1->plan_dokter) 
                                        : '-'; ?>
                                        <br>
                                        <span>Procedure :</span><br>
                                        <?php 
                                        foreach($get_data_procedur as $dat){
                                            echo '-'.$dat->nm_procedure.'('.$dat->id_procedure.')<br>';
                                        }
                                        ?>
                                    <?php }else{ ?>
                                        <?= isset($value1->plan_dokter) 
                                        ? nl2br($value1->plan_dokter) 
                                        : '-'; ?>
                                    <?php }}
                                    ?>
                                    
                                </td>
                              </tr>
                        </table>
                    </td>
                    <td>
                            <p><?= isset($value1->intruksi) ? nl2br($value1->intruksi) : '' ?></p>
                        </td>

                    <td>
                        <table border="0">
                            <tr>
                                <td style="text-align:center;">
                                    <?php if (isset($value->tandatangan_dokter)) { ?>
                                        <img width="80px" src="<?= $value->tandatangan_dokter; ?>" alt="">
                                    <?php } else {
                                        echo '<br><br><br>';
                                    } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align:center;"><span class="text_isi">(<?= isset($value->nama_dokter) ? $value->nama_dokter : ''; ?>)</span></td>
                            </tr>
                            <?php 
                            if($value1->poli == 'CE00'){ ?>
                                                            <tr>
                                <td><span class="text_isi">FISIOTERAPI. <?= isset($sip_dokter->nipeg) ? $sip_dokter->nipeg : ''; ?></span></td>
                            </tr>
                            <?php }else{ ?>
                                <tr>
                                <td><span class="text_isi">SIP. <?= isset($sip_dokter->nipeg) ? $sip_dokter->nipeg : ''; ?></span></td>
                            </tr>
                            <?php }
                            ?>

                        </table>
                    </td>
                </tr>
            </table>
      
            </div>

            


           
            </p><br><br><br>
             
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p style="font-style:italic">KOMITE REKAM MEDIS</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> No. Dokumen : Rev.I.I/2018/RM.04/RJ</p>
                </div>     
            </div> 
            
        </div>

    
   
      
</script>
    <?php //} ?>      
   </body>
   
   </html>
   
   