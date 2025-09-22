<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<style>
    #data {
        /* margin-top: 20px; */

        width: 100%;
        font-size: 9px;
        /* position: relative; */

    }

    .table-font-size {
        font-size: 9px;
    }

    .table-font-size1 {
        font-size: 11px;
        width: 100%;
    }

    .table-font-size2 {
        font-size: 9px;
        margin: 5px 1px 1px 1px;
        padding: 5px 1px 1px 1px;
    }
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header style="margin-top:20px; font-size:1pt!important;">
            <table border="0" width="100%">
                <tr>
                    <td width="13%">
                        <p align="center">
                            <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                    <td width="74%" style="font-size:9px;" align="center">
                        <font style="font-size:8pt!important">
                            <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                        </font>
                        <font style="font-size:8pt">
                            <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                            <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                        </font>
                        <br>
                        <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                        <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                    </td>
                    <td width="13%">
                        <p align="center">
                            <img src=" <?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                </tr>
            </table>
        </header>
        <div style="height:0px;border: 2px solid black;"></div><br>
        <table class="table-font-size1" border="0">
            <tr>
                <td width="20%">No. Registrasi</td>
                <td width="2%">:</td>
                <td width="25%"><?= $no_register ?></td>
                <td width="24%">Cara Bayar</td>
                <td width="2%">:</td>
                <td width="15%"><?= $cara_bayar ?></td>

            </tr>
            <tr>
                <td width="20%">No. RM</td>
                <td width="2%">:</td>
                <td width="20%"><?= substr($no_register, 0, 2) == 'PL' ? '-' : $no_cm ?></td>
                <td width="20%">Unit Asal</td>
                <td width="2%">:</td>
                <td width="20%"><?= $bed ?></td>
                <!-- <td  width="24%">No Kwitansi</td>
							<td  width="2%">:</td>
							<td  width="20%"><?php //echo $no_kwitansi 
                                                ?></td> -->
                <!-- <td width="24%">No Resep</td>
							<td width="2%">:</td>
							<td width="15%"></td> -->
            </tr>
            <tr>
                <td width="20%">Nama Pasien</td>
                <td width="2%">:</td>
                <td width="20%"><?= $nama ?></td>

                <td width="20%">Tanggal</td>
                <td width="2%">:</td>
                <td width="20%"><?= isset($tgl_kunj)?date('d-m-Y',strtotime($tgl_kunj)):'' ?></td>

                <!-- <td  width="24%">Resep Dokter</td>
							<td  width="2%">:</td> -->
                <!-- <td  width="20%"><?= $nmdokter ?></td> -->
            </tr>
            <!-- <tr>
							<td  width="20%">Sudah Terima Dari</td>
							<td  width="2%">:</td>
							<td  width="20%"><?php //echo str_replace('%20', ' ', $penyetor)
                                                ?></td>
						</tr> -->
        </table>
        <br>

        <table class="table-font-size1" border="1">
            <tr>
                <th>
                    <p align="center">No</p>
                </th>
                <th>
                    <p align="center">Nama Item</p>
                </th>
                <th>
                    <p align="center">Harga</p>
                </th>
                <th>
                    <p align="center">Banyak</p>
                </th>
                <th>
                    <p align="center">Total</p>
                </th>
            </tr>
            <?php $i = 1;
            $jumlah_vtot = 0;
            $mbalase = [];
            $mbalase_racikan = [];
            foreach ($data_permintaan as $row) {
                $jumlah_vtot += $row->vtot;
                $vtot = number_format($row->vtot, 2, ',', '.'); 
                if($row->item_obat == null){
                    array_push($mbalase_racikan,$row->embalase);
                }

                if($row->item_obat != null){
                    array_push($mbalase,$row->embalase);
                }?>
                <tr>
                    <td>
                        <p align="center" style="font-size:11px"> <?= $i ?></p>
                    </td>
                    <td>
                        <p style="font-size:11px"><?php if($row->kategori6 != '' || $row->kategori6 != null){
                                echo $row->nama_obat.'('.$row->kategori6.')';
                            }else{
                                echo $row->nama_obat;
                            } ?></p>
                    </td>
                    <td>
                        <p style="font-size:11px"><?php echo number_format($row->biaya_obat) ?></p>
                    </td>
                    <td>
                        <p style="font-size:11px"><?php echo $row->qty ?></p>
                    </td>
                    <td>
                        <p style="font-size:11px"><?php echo number_format($row->vtot);
                                                    //$jumlat_vtot += $row->vtot + $row->embalase; 
                                                    ?></p>
                    </td>
                </tr>

                <?php
                $i++; ?>

            <?php } //if($cara_bayar=='BPJS'){
            //$vtot_terbilang=$cterbilang->terbilang($jumlah_vtot);
            ?>
            <tr>
                <td><?php echo $i;?></td>
                <td>Pelayanan Farmasi Klinik Non Racikan</td>
                <td><?php echo $mbalase[0];?></td>
                <td><?php echo count($mbalase);?></td>
                <td><?php echo number_format($mbalase[0] * count($mbalase));?></td>
            </tr>
            <?php $totmbalase = $mbalase[0] * count($mbalase);
            $totmbalase_racikan = 0;
            if(count($mbalase_racikan)>0):
            ?>
            <tr>
                <td><?php $i++;echo $i;?></td>
                <td>Pelayanan Farmasi Klinik Racikan</td>
                <td><?php echo $mbalase_racikan[0];?></td>
                <td><?php echo count($mbalase_racikan);?></td>
                <td><?php echo number_format($mbalase_racikan[0] * count($mbalase_racikan));?></td>
            </tr>
            <?php $totmbalase_racikan += $mbalase_racikan[0] * count($mbalase_racikan);
            endif; ?>
            <!-- </table> -->
            <!-- <tr><br>
                                <th colspan="3"><p class="table-font-size1" align="right">Jumlah   </p></th>
                                <th bgcolor="yellow"><p class="table-font-size1" align="right"><?= number_format('0', 2, ',', '.') ?></p></th>
                            </tr>
                            
                        <tr>
                            <p class="table-font-size1" align="right">Biaya yang dibayar oleh pasien sebesar 0 rupiah (Ditanggung BPJS)</p>
                            <table class="table-font-size1">
                                <tr>
                                    <td><p align="right">Tanggal-Jam: <?= $tgl_jam ?></p></td>
                                </tr>
                            </table>
                        </tr> -->
            <?php //} 
            ?>



            <?php $vtot_terbilang = $cterbilang->terbilang($jumlah_vtot + $totmbalase + $totmbalase_racikan); ?>

            <tr>
                </hr></br>
                <th colspan="4">
                    <p class="table-font-size1" align="right">Jumlah </p>
                </th>
                <th bgcolor="yellow">
                    <p class="table-font-size1" align="right"><?= number_format($jumlah_vtot + $totmbalase + $totmbalase_racikan, 2, ',', '.') ?></p>
                </th>
            </tr>
            <?php if ($cara_bayar == 'BPJS') { ?>
                <tr>
                    </hr></br>
                    <th colspan="4">
                        <p class="table-font-size1" align="left">Biaya yang dibayar oleh pasien sebesar 0 rupiah (Ditanggung BPJS)</p>
                    </th>
                </tr>
            <?php }  ?>
            <?php
            $totakhir = $jumlah_vtot + $totmbalase + $totmbalase_racikan - $diskon;
            if ($diskon != 0) {
            ?>

                <tr>
                    <th colspan="4">
                        <p class="table-font-size1" align="right">Diskon </p>
                    </th>
                    <th bgcolor="yellow">
                        <p class="table-font-size1" align="right"><?= $diskon ?></p>
                    </th>
                </tr>

                <tr>
                    </hr></br>
                    <th colspan="4">
                        <p class="table-font-size1" align="right">Total Bayar </p>
                    </th>
                    <th>
                        <p class="table-font-size1" align="right"><?= number_format($totakhir, 2, ',', '.') ?></p>
                    </th>
                </tr>

                <?php $jumlah_vtot = $jumlah_vtot - $diskon; ?>
            <?php   }
            $vtot_terbilang = $cterbilang->terbilang($totakhir);
            ?>







        </table>
        <!-- <br><br>
                    <p style="font-size:12px">
                        Terbilang : <?php //echo $vtot_terbilang 
                                    ?>
                    </p>
                    <p class="table-font-size1" align="right"><i>Untuk Pembayaran Obat yang diminta, sesuai nota terlampir</i></p>-
                    <p style="float:right">                               
                        <table style="width:100%;">
                            <tr>
                                <td width="65%" >
                                    <p>
                                        <?php //echo $kota_header.','.' '.$tgl 
                                        ?>
                                        <br>
                                        <br>Pasien
                                        <br>
                                        <br><br><br>
                                    
                                    </p>
                                </td>
                                <td width="35%">
                                    <p>
                                        <?php //echo $kota_header.','.' '.$tgl 
                                        ?>
                                        <br>an.Kepala Rumah Sakit
                                        <br>K a s i r
                                        <br><br><br>ADMIN
                                        <?php //echo $nama_xuser 
                                        ?>
                                    </p>
                                </td>
                            </tr>	
                        </table>
                    </p> -->
    </div>
</body>

</html>