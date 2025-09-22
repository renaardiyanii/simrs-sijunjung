<?php 
// var_dump($data_jam);die();
if( $stat != '1' &&  substr($no_register, 0, 2) == 'RI'){ 
// echo 'data jam ada';    
?>
<html>

<head>
    <title></title>
</head>
<style>
table {
    /* border: 1px solid black; */
}

table tr td {
    font-size: 10px;
}
</style>

<body>
    <?php 
        foreach($data_jam as $jam){
            ?>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .wrapper {
            display: table;
            width: 100%;
            height: 100%;
        }

        .content {
            display: table-cell;
            vertical-align: top; /* Penting: memastikan isi tetap di atas */
            padding: 0px 5px;
        }

        .header-table {
            width: 100%;
        }

        .header-table td p {
            font-size: 8pt;
            margin: 0;
            padding: 0;
        }
    </style>

<div class="wrapper">
    <div class="content">
          <table class="header-table" border="0" style="width:100%; border-bottom: 1px solid black;">
                <tr>
                    <td style="width:15%;">
                        <img src="assets/images/logos/logo.jpeg" width="20px">
                    </td>
                    <td style="width:85%; font-weight:bold;">
                        <p style="margin:0;">RSUD AHMAD SYAFII MAARIF</p>
                        <span>DEPO FARMASI RAWAT INAP</span>
                    </td>
                </tr>
            </table>

            

            <!-- Data Pasien -->
            <table style="width: 100%; font-size: 11pt;">
                <tr>
                    <td style="font-weight:bold;font-size:12px">No RM : <?= $data_obat_jam[0]->no_cm ?? '' ?></td>
                    <td style="font-weight:bold;font-size:12px; text-align:right"><?= isset($data_obat_jam[0]->tgl_kunjungan)?date('d-m-Y',strtotime($data_obat_jam[0]->tgl_kunjungan)):'' ?></td>
                </tr>
                <tr>
                    <td  style="font-weight:bold;font-size:12px">Nama : <?= strtoupper($data_obat_jam[0]->nama ?? '') ?></td>
                     <td  style="font-weight:bold;text-align:right;font-size:12px"> <?= strtoupper($data_obat_jam[0]->bed ?? '') ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight:bold;font-size:12px">Tgl Lahir : <?= isset($data_obat_jam[0]->tgl_lahir)?date('d-m-Y',strtotime($data_obat_jam[0]->tgl_lahir)):'' ?></td>
                </tr>

                <tr>
                    <td colspan="2" style="font-weight:bold;font-size:15px;text-align:center">
                        JAM <?= $jam->jam ?>
                    </td>
                </tr>
                    <?php 
                        foreach ($data_obat_jam as $key) {
                            if (in_array($jam->jam, [
                                $key->jam_pemberian1,
                                $key->jam_pemberian2,
                                $key->jam_pemberian3,
                                $key->jam_pemberian4,
                                $key->jam_pemberian5,
                                $key->jam_pemberian6
                            ])) {
                    ?>
                <tr>
                    <td style="font-weight:bold;font-size:13px;">
                        <?= strtoupper($key->nama_obat); ?>
                    </td>
                      <td style="font-weight:bold;font-size:13px;">
                       ED : 
                    </td>
                </tr>

          

          
           
          
        <?php }} ?>
        </table>
    </div>
</div>


    <?php  }  ?>

    

</body>

</html>
<?php }else{ ?>
        <html>

        <head>
            <title></title>
        </head>
        <style>
        table {
            border: 1px solid black;
        }

        table tr td {
            font-size: 12px;
        }
        </style>

        <body>
            <?php 
        // echo 'Hello';
        foreach ($data_obat as $key) { ?>

            <table cellspacing="0" cellpadding="0" style="width:100%;margin-left:5px;margin-right:5px">

                <tr>
                    <td>
                        <table style="width:100%;">

                            <tr>
                                
                                <td style="width:15%;">
                                    <img src="assets/images/logos/logo.jpeg" width="40px"
                                        class="left">
                                </td>
                                <td style="width:85%;">
                                    <p style="font-size:12pt;">RSUD AHMAD SYAFII MAARIF</p>
                                    <?php
                                    if($roleid == '1028'){ ?>
                                        <p style="font-size:12pt;">DEPO FARMASI OK</p>
                                    <?php }else{ ?>
                                        <?php 
                                            if( substr($key->no_register, 0, 2) == 'RI'){ ?>
                                            <p style="font-size:12pt;">DEPO FARMASI RAWAT INAP</p>
                                        <?php }else{ ?>
                                            <p style="font-size:12pt;">DEPO FARMASI RAWAT JALAN</p>
                                        <?php }
                                        ?>
                                <?php  } ?>
                                    
                                    
                                        
                                </td>
                            
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table style="width: 100%;">
                            <!-- <tr>
                                <td width="70%"><b>Antrian : <?php // echo $key->no_antri; ?></b></td>
                                <td style="font-weight:bold"></td>
                            </tr> -->
                            <tr>
                                <td width="70%"><b>Antrian : <?php echo $key->no_antri; ?></b></td>
                                <td style="font-weight:bold"><?php echo date('d/m/Y',strtotime($tgl)); ?></td>
                            </tr>
                            <tr>
                                <td style="font-weight:bold"><?php echo $nama.' '.'('.$key->no_cm.')'; ?></td>
                                <td style="font-weight:bold">Lhr : <?php echo date('d/m/Y',strtotime($tgl_lahir)); ?></td>
                            </tr>
                        
                        
                            
                            <tr>
                                <td colspan="2" style="font-weight:bold;font-size:16px;text-align:center"><?php echo strtoupper($key->nama_obat); ?></td>
                            </tr>
                            <tr>
                                <td><br></td>
                                <td style="font-weight:bold"></td>
                            </tr>
                            <tr>
                                <td>Exp Date : <?php echo date('d/m/Y',strtotime($key->expire_date)); ?></td>
                                <td style="font-weight:bold">Qty : <?php echo $key->qty; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <div style="text-align: center;">
                            <center>
                                <?php 
                                // var_dump($key);die();
                                if($key->kali_harian != '' && $key->cara_pakai != '' && $key->Satuan_obat != ''){  ?>
                                    <p style="text-align: center;font-size:16px;">
                                    <b><?php echo $key->kali_harian.', '.$key->qtx.' '.$key->Satuan_obat; ?><br>
                                    <?php echo $key->cara_pakai  ?>
                                
                                    
                                    <?php 
                                    echo $key->ket_pakai_p=='1'?'/Pagi ':'';
                                    echo $key->ket_pakai_s=='1'?'/Siang ':'';
                                    echo $key->ket_pakai_m=='1'?'/Malam ':'';
                                    ?>

                                </b></p>
                                <?php }else{ ?> 
                                    <p style="text-align: center;font-size:16px;">
                                    <b><b><?php echo $key->signa; ?>
                                    <?php 
                                    echo $key->ket_pakai_p=='1'?'/Pagi ':'';
                                    echo $key->ket_pakai_s=='1'?'/Siang ':'';
                                    echo $key->ket_pakai_m=='1'?'/Malam ':'';
                                    ?>

                                    </b></p>
                                    <p style="font-size:11pt;"><b><?= strtoupper($key->cara_pakai) ?></b></p>
                                <?php } ?>
                                
                            </center>
                        </div>
                    </td>
                </tr>

            </table>

            <?php } ?>
        </body>

        </html>
<?php }

?>

