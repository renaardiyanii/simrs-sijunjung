<?php 
?>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <script>

// By using querySelector
        JsBarcode("#barcode", "Hi world!");
   </script>

<br>
<header style="margin-top:0px; font-size:1pt!important;">

<table border="0" width="100%">
<tr>
    <td width="10%">
        <p align="center">
        <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="80px" width="100px" style="padding-right:15px;">
        </p>
    </td>
    <td  width="0%"  align="left" style="font-size:18px;font-weight:bold;">
    <p style="margin-top:20px">
        <span>RSUD</span><br>
        <span> AHMAD SYAFII MAARIF</span><br>
    </p>
    </td>
    <td width="45%">
    

        <table class="table_nama" width="100%">
                <tr>
                </tr>
            <?php
            ?>
                <tr>
                    <td width="33%"  style="font-size:12px"><span>Nama</span></td>
                    <td width="2%"  style="font-size:12px"><span>:</span></td>
                    <td width="45%"  style="font-size:12px" colspan="2"><span><?php echo $data_pasien[0]->nama??""; ?></span></td>
                  
                </tr>
                <tr>
                    <td style="font-size:12px"><span>NIK</span></td>
                    <td style="font-size:12px"><span>:</span></td>
                    <td style="font-size:12px"><span><?php echo $data_pasien[0]->no_identitas??""; ?></span></td>
                    <td style="font-size:12px"><span>(<?php echo $data_pasien[0]->sex??""; ?>)</span></td>
                </tr>
                <tr>
                    <td style="font-size:12px"><span>No. RM</span></td>
                    <td style="font-size:12px"><span>:</span></td>
                    <td style="font-size:12px"><span><?php echo $data_pasien[0]->no_cm??""; ?></span></td>
                    <td style="font-size:12px" rowspan="2">
                    <span>
                    <svg class="barcode"
                     jsbarcode-format="code128"
                     jsbarcode-height="30"
                     jsbarcode-width="1"
                     jsbarcode-displayValue="false"
                     jsbarcode-value="<?= $data_pasien[0]->no_cm??""; ?>"
                     jsbarcode-textmargin="0"
                     jsbarcode-margin="0"
                     jsbarcode-marginTop="5"
                     jsbarcode-marginRight="5"
                     jsbarcode-fontoptions="bold">
                     </svg>

                 <script>JsBarcode(".barcode").init();</script>
                    </span></td>
                </tr>
                <tr>
                    <td style="font-size:12px"><span>Tgl Lahir</span></td>
                    <td style="font-size:12px"><span>:</span></td>
                    <td style="font-size:12px"><span><?php echo date('d-m-Y',strtotime($data_pasien[0]->tgl_lahir))??"";//substr($data_pasien[0]->tgl_lahir,0,10); ?></span></td>
                  
                </tr>
            <?php
            ?>
        </table> 
    </td>

    </tr>
   
    </table>

</header>
<div style="border-bottom: 1px solid black;"></div>
<div style="border-bottom: 4px solid black;margin-top:2px"></div>