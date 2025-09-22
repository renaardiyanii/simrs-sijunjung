<?php //var_dump($data_pemeriksaan);die(); ?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
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
                                <img src="<?= base_url("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                               
                                <font style="font-size:14px">
                                    <h3>RSUD AHMAD SYAFII MAARIF</h3>
                                    <!-- <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b> -->
                                </font>    
                                <br>
                               
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <!-- <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;"> -->
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 14px; text-align: center;">
                FAKTUR OPERASI No.OK_<?= $no_ok ?>
            </p>

            <table width= "100%" border="0">
						
						
						<tr>
							<td width="20%"><b>No. Registrasi</b></td>
							<td width="3%"> : </td>
							<td width="22%"><?= isset($data_pasien->no_register)?$data_pasien->no_register:'' ?></td>
							<td width="20%"><b>Nama Pasien</b></td>
							<td width="3%"> : </td>
							<td width="32%"><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></td>
						</tr>
						<tr>
							<td><b>No. Medrec</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
							<td><b>Umur</b></td>
							<td> : </td>
							<td><?= isset($tahun)?$tahun:'' ?>tahun.</td>
						</tr>
						<tr>
							<td><b>Golongan Pasien</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->cara_bayar)?$data_pasien->cara_bayar:'' ?></td>
							<td><b>Alamat</b></td>
							<td> : </td>
							<td><?= isset($data_pasien->alamat)?$data_pasien->alamat:'' ?></td>
						</tr>
						<tr>
							<td width="20%"><b>Terbilang</b></td>
							<td width="3%"> : </td>
							<td colspan ="4"><b><i><?= isset($vtot_terbilang)?strtoupper($vtot_terbilang):'' ?></i></b></td>							
						</tr>
					</table><br><br>

                    <table border="1" style="padding:2px;font-size:12px" width="100%">
						<tr>
							<th width="5%"><p align="center"><b>No</b></p></th>
							<th width="55%"><p align="center"><b>Nama Pemeriksaan</b></p></th>
							<th width="15%"><p align="center"><b>Biaya</b></p></th>
							<th width="10%"><p align="center"><b>Banyak</b></p></th>
							<th width="15%"><p align="center"><b>Total</b></p></th>
						</tr>
					<?php
					$i=1;
					$jumlah_vtot=0;
					foreach($data_pemeriksaan as $row){
						// var_dump($row);die();
						$jumlah_vtot=$jumlah_vtot+$row->vtot;
						$vtot = number_format( $row->vtot, 2 , ',' , '.' );
						?>
						<tr>
						  	<td><p align="center"><?= $i ?></p></td>
						  	<td><p><?= $row->jenis_tindakan ?></p></td>
							<!-- <?php //var_dump($row->jenis_tindakan);die(); ?> -->
						  	<td><p align="right"><?= number_format( $row->biaya_ok, 2 , ',' , '.' )?></p></td>
						  	<td><p align="center"><?= $row->qty ?></p></td>
						  	<td><p align="right"><?= $vtot ?></P></td>
						</tr>
					<?php	$i++; 
                    }
                    ?>
						<tr>
							<th colspan="4"><p align="right"><b>Total   </b></p></th>
							<th><p align="right"><?= number_format( $jumlah_vtot, 2 , ',' , '.' )?></p></th>
						</tr>
					</table>

                    </table>
					<br>
					<br>
					<table style="width:100%;">
						<tr>
							<td width="65%" ></td>
							<td>
								<p align="center">
								<?= $kota_header ?>, <?= $tgl ?>
                               
								<br>Kamar Operasi
								<br><br><br><?= $xuser ?>
								</p>
							</td>
						</tr>	
					</table>
        </div>