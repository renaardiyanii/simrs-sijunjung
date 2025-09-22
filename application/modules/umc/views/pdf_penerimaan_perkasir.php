<link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
<style>
    #data {
            /* margin-top: 20px; */
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            /* position: relative; */
            text-align: center;
        }
       
        .table-font-size{
            font-size:9px;
            }
        .table-font-size1{
            font-size:12px;
            }
        .table-font-size2{
            font-size:9px;
            margin : 5px 1px 1px 1px;
            padding : 5px 1px 1px 1px;
            }
        .poli {
            font-size: 12px;
        }
</style>

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
                    <td  width="74%" style="font-size:9px;" align="center">
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
                            <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                        </p>
                    </td>
                </tr>
            </table>
        </header>
        <div style="height:0px;border: 2px solid black;"></div><br>
        <p style = "font-weight:bold; font-size: 14px; text-align: center;">
           Laporan Penerimaan Perkari Perkwitansi<br>
           Tanggal : <?php echo $date; ?>
        </p>

        <p style = "font-size: 13px;">Nama kasir : <?php echo $username; ?></p>

        <?php 
        $subtotal_rj = 0;
        $subtotal_ri = 0;
        $subtotal_non_pasien = 0;
        $subtotal_obat = 0;
        foreach($poli as $row1){ 			
            $array = json_decode(json_encode($hasil), True);
            $data_poli=array_column($array, 'asal');                            
            //Klo data tdk kosong, tampilkan
            if (in_array($row1->id_poli, $data_poli)) {	
        ?>
                <div class="poli"><b>Poliklinik : <?php echo $row1->nm_poli ?></b></div>
                <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kasir</th>
                            <th>No Kwitansi</th>
                            <th>Jam</th>
                            <th>No Register</th>
                            <th>No MR</th>
                            <th>Nama</th>
                            <th>Jaminan</th>
                            <th>Status</th>
                            <th>Jenis Bayar</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i=1; 
                    $subtotal = 0;
                    foreach($hasil as $row2){
                        if ($row2->asal==$row1->id_poli) {						
                    ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo $row2->kasir;?></td>
                            <td><?php echo $row2->no_kwitansi;?></td>
                            <td><?php echo date("H:i", strtotime($row2->tgl_cetak));?></td>
                            <td><?php echo $row2->no_register; ?></td>
                            <td><?php echo $row2->no_cm;?></td>						
                            <td><?php echo $row2->nama;?></td>
                            <td><?php echo $row2->cara_bayar;?></td>
                            <td><?php 
                            if($row2->status == NULL) {
                                echo'';
                            } else {
                                echo $row2->status;
                            }
                            ?></td>
                            <td><?php echo $row2->jenis_bayar;?></td>
                            <td><?php echo number_format($row2->tunai);?></td>
                        </tr>
                    <?php 
                    if($row2->status == NULL) {
                        $subtotal += $row2->tunai;
                    } else if($row2->status == 'batal') {
                        $subtotal += 0;
                    } 
                        } 
                    } 
                    $subtotal_rj += $subtotal;?>
                    <tr>
                        <td colspan="10"><b>Subtotal</b></td>
                        <td><?php echo number_format($subtotal); ?></td>
                    </tr>
                    </tbody>
                </table>	            
            <?php 
            }
        } ?>

        <?php if($farmasi) { ?>
            <h4><b>Farmasi</b></h4>
            <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kasir</th>
                        <th>No Kwitansi</th>
                        <th>Jam</th>
                        <th>No Register</th>
                        <th>No MR</th>
                        <th>Nama</th>
                        <th>Jaminan</th>
                        <th>Status</th>
                        <th>Jenis Bayar</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i = 1;
                    foreach($farmasi as $obat) { ?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo $obat->kasir; ?></td>
                            <td><?php echo $obat->no_kwitansi;?></td>
                            <td><?php echo date("H:i", strtotime($obat->tgl_cetak));?></td>
                            <td><?php echo $obat->no_register; ?></td>
                            <td><?php echo $obat->no_cm;?></td>						
                            <td><?php echo $obat->nama;?></td>
                            <td><?php echo $obat->cara_bayar;?></td>
                            <td><?php 
                                if($obat->status == NULL) {
                                    echo'';
                                } else {
                                    echo $obat->status;
                                }
                            ?></td>
                            <td><?php echo $obat->jenis_bayar;?></td>
                            <td><?php echo number_format($obat->tunai);?></td>
                        </tr>
                    <?php 
                        if($obat->status == NULL) {
                            $subtotal_obat += $obat->tunai;
                        } else {
                            $subtotal_obat += 0;
                        } 
                    } ?>
                    <tr>
                        <td colspan="10"><b>Subtotal</b></td>
                        <td><?php echo number_format($subtotal_obat); ?></td>
                    </tr>
                </tbody>
            </table>
        <?php } ?>

<?php if ($hasil_ri) { ?>
    <div class="poli"><b>Rawat Inap</b></div>
                                    <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kasir</th>
                                                <th>No Kwitansi</th>
                                                <th>Jam</th>
                                                <th>No Register</th>
                                                <th>No MR</th>
                                                <th>Nama</th>
                                                <th>Ruang</th>
                                                <th>Jaminan</th>
                                                <th>Status</th>
                                                <th>Jenis Bayar</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach($hasil_ri as $iri) { ?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $iri->kasir; ?></td>
                                                <td><?php echo $iri->no_kwitansi;?></td>
                                                <td><?php echo date("H:i", strtotime($iri->tgl_cetak));?></td>
                                                <td><?php echo $iri->no_register; ?></td>
                                                <td><?php echo $iri->no_cm;?></td>						
                                                <td><?php echo $iri->nama;?></td>
                                                <td><?php echo $iri->nmruang;?></td>
                                                <td><?php echo $iri->carabayar;?></td>
                                                <td><?php 
                                                    if($iri->status == NULL) {
                                                        echo'';
                                                    } else {
                                                        echo $iri->status;
                                                    }
                                                ?></td>
                                                <td><?php echo $iri->jenis_bayar;?></td>
                                                <td><?php echo number_format($iri->tunai);?></td>
                                            </tr>
                                        <?php 
                                            if($iri->status == NULL) {
                                                $subtotal_ri += $iri->tunai;
                                            } else if($iri->status == 'batal') {
                                                $subtotal_ri += 0;
                                            }
                                        }
                                        ?>
                                            <tr>
                                                <td colspan="11"><b>Subtotal</b></td>
                                                <td><?php echo number_format($subtotal_ri); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>

                                <?php if ($non_pasien) { ?>
                                    <div class="poli"><b>Non Pasien</b></div>
                                    <table class="table table-hover table-striped table-bordered" border="1" style="padding:2px">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kasir</th>
                                                <th>Tindakan</th>
                                                <th>No Kwitansi</th>
                                                <th>No MR</th>
                                                <th>Nama</th>
                                                <th>Jenis Bayar</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        $i = 1;
                                        foreach($non_pasien as $non) { 
                                            $tindakan = $this->Mumcicilan->get_tindakan_non_pasien($non->no_kwitansi)->result();?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $non->kasir; ?></td>
                                                <td><?php foreach($tindakan as $ib) {
                                                    echo $ib->item_bayar.'<br>';
                                                }
                                                ?></td>
                                                <td><?php echo $non->no_kwitansi;?></td>
                                                <td><?php echo $non->no_cm;?></td>						
                                                <td><?php echo $non->nama;?></td>
                                                <td><?php echo $non->method_pay;?></td>
                                                <td><?php echo number_format($non->jml);?></td>
                                            </tr>
                                        <?php 
                                            // if($iri->status == NULL) {
                                            //     $subtotal_ri += $iri->tunai;
                                            // } else if($iri->status == 'batal') {
                                            //     $subtotal_ri += 0;
                                            // }
                                            $subtotal_non_pasien += $non->jml;
                                        }
                                        ?>
                                            <tr>
                                                <td colspan="7"><b>Subtotal</b></td>
                                                <td><?php echo number_format($subtotal_non_pasien); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } ?>
									
								<div class="poli"><b>Total : <?php echo number_format($subtotal_rj + $subtotal_ri + $subtotal_non_pasien + $subtotal_obat); ?></b></div>
    </div>
</body>