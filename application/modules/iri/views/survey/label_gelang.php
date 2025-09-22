<html>

<head>
    <title></title>
</head>
<style>


table tr td {
    font-size: 12px;
}
</style>

<body>

    <table cellspacing="2px" border="0" cellpadding="2px" style="width:100%;margin-left:5px;margin-right:5px">
        <tr>
            <td width="15%">
                <img src="assets/img/logo.png" width="30px">
            </td>
            <td>
            <p style="font-size:13px;font-weight:bold;text-align:center">RSUD AHMAD SYAFII MAARIF</p>
            </td>
        </tr>
    </table>
    <div style="border-bottom: 1px solid black"></div>
   

    <table cellspacing="2px" border="0" cellpadding="2px" style="width:100%;margin-left:5px;margin-right:5px">
        <tr>
            <td width="30%">NO. RM</td>
            <td width="2%">:</td>
            <td><?= $data_pasien->no_cm ?></td>
        </tr>

        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td><?= $data_pasien->nama ?></td>
        </tr>

        <tr>
            <td>TGL LAHIR</td>
            <td>:</td>
            <td><?= date('d-m-Y',strtotime($data_pasien->tgl_lahir)) ?></td>
        </tr>
    </table>


    <!-- <table cellspacing="0" cellpadding="0" style="width:100%;margin-left:5px;margin-right:5px">

        <tr>
            <td>
                <table style="width:100%;">

                    <tr>
                        
                        <td style="width:15%;">
                            <img src="assets/images/logos/logo_new.jpeg" width="40px"
                                class="left">
                        </td>
                        <td style="width:85%;">
                            <p style="font-size:12pt;">RSUD AHMAD SYAFII MAARIF</p>
                        </td>
                       
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td width="70%"><b><?php echo $nama; ?></td>
                        <td style="font-weight:bold"><?php echo date('d/m/Y',strtotime($tgl)); ?></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold">MR : <?php echo $key->no_medrec; ?></td>
                        <td style="font-weight:bold">Lhr : <?php echo date('d/m/Y',strtotime($tgl_lahir)); ?></td>
                    </tr>
                   
                    
                    <tr>
                        <td colspan="2" style="font-weight:bold;font-size:15px;text-align:center"><?php echo strtoupper($key->nama_obat); ?></td>
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
                        <p style="font-size:11pt;"><b><?= strtoupper($key->cara_pakai) ?></b></p>
                        <p style="text-align: center;font-size:16px;">
                            <b><?php echo $key->kali_harian.', '.$key->qtx.' '.$key->Satuan_obat; ?>
                            <?php 
                            echo $key->ket_pakai_p=='1'?'/Pagi ':'';
                            echo $key->ket_pakai_s=='1'?'/Siang ':'';
                            echo $key->ket_pakai_m=='1'?'/Malam ':'';
                            ?>

                            </b></p>
                    </center>
                </div>
            </td>
        </tr>

    </table> -->

 
</body>

</html>