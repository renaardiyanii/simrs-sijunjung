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
<?php foreach ($data_obat as $key) { ?> 
       
    <table id="wrap" cellspacing="0" cellpadding="0" style="width:100%;margin-left:10px;margin-right:10px;">
        
        <tr>
            <td>
                <table style="width:100%;">
                    <tr>
                        <td style="width:15%;">
                            <img src="assets/images/logos/<?php echo $this->config->item('logo_url'); ?>" height="40px" width="40px" class="left">
                        </td>
                        <td style="width:85%;">
                            <label>RS.OTAK DR.Drs.M.HATTA BKT</label><br>
                            <label>DEPO FARMASI RAWAT JALAN</label> 
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td>No.Resep : <?php echo $no_resep; ?></td>
                        <td style="float: right;">TGL : <?php echo $tgl; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $nama; ?></td>
                        <td style="float: right;">RM : <?php echo $key->no_medrec; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="float: right;">Lhr : <?php echo $tgl_lahir; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Nama Obat : <?php echo $key->nm_obat; ?></td>
                    </tr>
                    <tr>
                        <td>Tgl. Kadaluarsa : <?php echo $tgL_kadaluarsa; ?></td>
                        <td style="float: right;">Jlh : <?php echo $key->qty; ?></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <div style="text-align: center;">
                    <label style="text-align: center;"><b><?php echo $key->signa; ?></b></label>
                </div> 
            </td>
        </tr> 

    </table>
    
<?php } ?>
</body>
</html>