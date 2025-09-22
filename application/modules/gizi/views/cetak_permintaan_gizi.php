<?php


?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
    <style type="text/css">
            .table-font-size{
                font-size:14px;
            }
            .table-font-size2{
                font-size:8px;
            }
            .table-ttd{
                font-size:7px;
                padding : 1px, 2px, 2px;
            }
            .font-italic{
                font-size:7px;
                font-style:italic;
            }
        </style>

<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header style="margin-top:0px; font-size:1pt!important;">
            <table border="0" width="100%">
                <tr>
                    <td width="70%" align="left" style="font-size:20px;font-weight:bold;">
                        <p style="margin-top:10px">
                            <span>RS. OTAK DR. Drs. M.HATTA</span><br>
                            <span> BUKITTINGGI</span><br>
                        </p>
                    </td> 
                    <td width="30%" align="left" style=";font-weight:bold;">
                        <p style="margin-top:10px">
                            <span>Dicetak <?php echo $tgl_jam ?></span>
                        </p>
                    </td> 
                </tr>
            </table>
        </header>
        <hr>

    
        <table class="table-font-size">                           
            <tr>                                
                <td width="20%">RUANGAN</td>
                <td width="3%">:</td>
                <td width="34%"><?= $lokasi ?></td>
                <td></td>
            </tr>
            
        </table><br>                        
        
        <table class="table-font" border="1" cellpadding="2px" style="vertical-align: middle">
            <thead>
                <tr>
                    <th rowspan="2" width="5%"  style="text-align: center;vertical-align:middle;">NO</th>
                    <th rowspan="2" width="15%"  style="text-align: center;">NAMA</th>
                    <th rowspan="2" width="12%"  style="text-align: center;">No Register</th>
                    <th rowspan="2" width="13%"  style="text-align: center;">KLS/KMR</th>
                    <th rowspan="2" width="12%"  style="text-align: center;">DIAGNOSA</th>
                    <th colspan="2" width="18%" style="text-align: center;">DIET</th>
                    <th rowspan="2" width="15%"  style="text-align: center;">CATATAN</th>
                    <th rowspan="2" width="10%"  style="text-align: center;">STATUS</th>
                </tr>
                <tr>
                    <td style="text-align: center;font-size:8px;">STANDAR</td>
                    <td style="text-align: center;font-size:8px;">BENTUK</td>
                </tr>
            </thead>
            <tbody>
            <?php 
            
                $i = 1;
                foreach ($result as $item) {
                    //  var_dump($item);die();
                    // $data2['gizi']=null;
                    // $this->Mgizi->update_ceklis_ahli_gizi($item->no_ipd,$data2);
                    if ($item->bed == '' || $item->bed == null) {
                        $kamar = '';
                        $bed = '';
                    } else {
                        $kamar_bed = explode(" ", $item->bed);
                        $kamar = substr($kamar_bed[0], -2);
                        $bed = $kamar_bed[2];
                    }
                    $bentuk_makanan = '';
                    if ($item->bentuk == 'MK') {
                        $bentuk_makanan = 'Makanan Cair';
                    } else {
                        $bentuk_makanan = $item->bentuk;
                    }

                    ?>

                   
                        <tr>
                            <td width="5%" style="text-align: center;"><?= $i++ ?></td>
                            <td width="15%"><?= $item->nama ?></td>
                            <td width="12%" style="text-align: center;"><?= $item->no_ipd ?></td>
                            <td width="13%" style="text-align: center;"><?= $item->kelas.'/'.$kamar.'/'.$bed ?></td>
                            <td width="12%"> <?= $item->diagmasuk ?></td>
                            <td width="9%" style="text-align: center;"><?= $item->standar ?></td>
                            <td width="9%" style="text-align: center;"><?= $bentuk_makanan ?></td>
                            <td width="15%"><?= $item->catatan ?></td>
                            <td width="10%" style="text-align: center;"><?= $item->nmkontraktor ?></td>
                        </tr>
                   

                   <?php } ?>
                   </tbody>
                </table>
                    


    </div>

       

</body>




</html>