_<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
   <script>

// By using querySelector
        JsBarcode("#barcode", "Hi world!");
   </script>
<?php
// var_dump($kode_document);
?>
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
        <span>RS. OTAK DR. Drs. M.HATTA</span><br>
        <span> BUKITTINGGI</span><br>
    </p>
    </td>
    <td width="45%">
        <span style="font-weight:bold;font-size:12px;text-align: right;display:block;margin-right:5px"><?= isset($kode_document)?$kode_document!=""?$kode_document->result()[0]->kode_rm:"":""; ?></span>

        
    </td>

    </tr>
   
    </table>
</header>