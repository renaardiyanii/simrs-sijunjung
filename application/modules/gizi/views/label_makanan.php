<html>
<head>
    <title></title>
</head>
    <style>        
        table{
            border: 1px solid black;
        }
        table tr td{
            font-size: 12px;
        }
    </style>
   
   <body>

    <?php 
    foreach ($datapasien as $key) { ?> 
     <div class="A4 sheet  padding-fix-10mm">
        <table id="wrap" cellspacing="0" cellpadding="0" style="width:100%;margin-left:10px;margin-right:10px;font-size:14px">
            <tr>
                <td>
                    <table style="width:100%;">
                        <tr>
                            <td style="width:15%;">
                                <img src="assets/images/logos/<?php echo $this->config->item('logo_url'); ?>" height="40px" width="40px" class="left">
                            </td>
                            <td style="width:85%;">
                                <label>RS.OTAK DR.Drs.M.HATTA BKT</label><br>
                                <label>DIET GIZI</label> 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table style="width:100%;">
                        <tr>
                            <td style="width:85%;">
                                <label>Nama :<?= $key->no_cm ?></label><br>
                            </td>
                        <tr>

                        <tr>
                            <td style="width:85%;">
                                <label>Nama :<?= $key->nama ?></label><br>
                            </td>
                        <tr>
                           
                           <td style="width:85%;">
                               <label>Nama :<?= $key->lokasi ?></label><br>
                           </td>
                       </tr>

                       <tr>
                           
                           <td style="width:85%;">
                               <label>Standar :<?= $key->standar ?></label><br>
                           </td>
                         
                       </tr>

                       <tr>
                           
                           
                           <td style="width:85%;">
                               <label>Bentuk :<?= $key->bentuk ?></label><br>
                           </td>
                       </tr>
                    </table>
                </td>
            </tr>

            
        </table>
    </div>
    <?php } ?>
</body>

</html>
