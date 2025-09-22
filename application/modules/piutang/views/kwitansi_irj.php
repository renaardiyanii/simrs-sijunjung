<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
          #data {
            /* margin-top: 20px; */
            
            width: 100%;
            font-size: 9px;
            /* position: relative; */
            
        }
       
        .table-font-size{
            font-size:9px;
            }
        .table-font-size1{
            font-size:11px;
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
            <div style="height:0px;border: 2px solid black;" ></div>
                <table width="100%" border="0">	
							<tr>
								<td colspan="6" ><p size="12px" align="center"><u><b>KWITANSI <?php if (substr($detail_daful->nm_poli,0,3) == 'IGD') {
									echo 'RAWAT DARURAT';
								}else{
									echo 'RAWAT JALAN';
								} ?> </b></u></p></td>
							</tr>	
	
							<tr>
								<td ><b>No Register</b></td>
								<td > : </td>
								<td><?= $no_register?></td>
								<!-- <td width="23%"><b>Telah Terima Dari</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?= str_replace('%20', ' ', $penyetor)?></td> -->
								<td width="23%"><b>Nama Pasien</b></td>
								<td width="2%"> : </td>
								<td width="25%"><?=strtoupper($nama_pasien)?></td>

							</tr>
							<tr>
								<td ><b>No RM</b></td>
								<td > : </td>
								<td><?= strtoupper($data_pasien->no_cm)?></td>
								<td ><b>Alamat</b></td>
								<td > : </td>
								<td><?= strtoupper($data_pasien->alamat)?></td>
							</tr>
							<tr>
								<td><b>Umur</b></td>
								<td > : </td>
								<td><?=strtoupper($umur)?>Tahun</td>
								<td><b>Kota</b></td>
								<td> : </td>
								<td><?=$data_pasien->kotakabupaten?></td>
							</tr>
							<tr>
								<td ><b>Tgl Reg</b></td>
								<td > : </td>
								<td><?=date("d-m-Y", strtotime($data_pasien->tgl_kunjungan))?></td>	
								<td><b>Jenis Kelamin</b></td>
								<td > : </td>
								<td><?=strtoupper($jenkel)?></td>
							</tr>
							<tr>
								<td ><b>Pembayaran</b></td>
								<td > : </td>
								<td><?=strtoupper($data_pasien->cara_bayar)?></td>	
								<td><b>No Kwitansi</b></td>
								<td > : </td>
								<td><?=strtoupper($no_kwitansi)?></td>
							</tr>
							<tr>
								<!-- <td ><b>Dijamin Oleh</b></td>
								<td > : </td>
								<td><?=strtoupper($detail_daful->kontraktor)?></td>	 -->
								<td><b>Dokter</b></td>
								<td> : </td>
								<td><?=strtoupper($detail_daful->nm_dokter)?></td>
								<td><b>Unit</b></td>
								<td> : </td>
								<td rowspan="3"><?=strtoupper($detail_daful->nm_poli)?></td>
							</tr>
							
							<!-- <tr>
								
								
							</tr>											 -->
				</table><br>

         
			
			        <table border="1" style="padding:2px" width="100%" >
						<tr>
							<th width="5%" style="font-size:11px" colspan="4"><p align="left"><b>Tindakan Pelayanan</b></p></th>
						</tr>
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>
						<?php 
						if($data_tindakan != ''){
						$no=1;
						$total_tagihan_tind=0;
						foreach($data_tindakan as $tind){ ?>
							<tr>
								<td width="5%" style="font-size:11px"><p align="center"><?= $no++ ?></p></td>
								<td width="50%" style="font-size:11px"><p align="center"><?= $tind->nmtindakan ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($tind->biaya_tindakan, 2 , ',' , '.' ) ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($tind->vtot, 2 , ',' , '.' ) ?></p></td>
							</tr>
							
						<?php 
							$total_tagihan_tind += $tind->vtot;
						}
						?>
						<tr>
							<td width="5%" style="font-size:11px" colspan="3"><p align="left"><b>Subtotal</b></p></td>
							<td width="5%" style="font-size:11px"><p align="left"><b> <?php echo number_format($total_tagihan_tind, 2 , ',' , '.' )?></b></p></td>
						</tr>
						<?php } ?>

						<!-- labor -->
						<tr>
							<th width="5%" style="font-size:11px" colspan="4"><p align="left"><b>Laboratorium</b></p></th>
						</tr>
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>

						<?php 
						$no=1;
						$total_tagihan_labor=0;
						foreach($data_labor as $labor){ ?>
							<tr>
								<td width="5%" style="font-size:11px"><p align="center"><?= $no++ ?></p></td>
								<td width="50%" style="font-size:11px"><p align="center"><?= $labor->jenis_tindakan ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($labor->biaya_lab, 2 , ',' , '.' ) ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($labor->vtot, 2 , ',' , '.' ) ?></p></td>
							</tr>
							
						<?php 
							$total_tagihan_labor += $labor->vtot;
						}
						?>
						<tr>
							<td width="5%" style="font-size:11px" colspan="3"><p align="left"><b>Subtotal</b></p></td>
							<td width="5%" style="font-size:11px"><p align="left"><b> <?php echo number_format($total_tagihan_labor, 2 , ',' , '.' )?></b></p></td>
						</tr>

						

						<!-- rad -->
						<tr>
							<th width="5%" style="font-size:11px" colspan="4"><p align="left"><b>Radiologi</b></p></th>
						</tr>
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>
						<?php 
						$no=1;
						$total_tagihan_rad=0;
						foreach($data_rad as $rad){ ?>
							<tr>
								<td width="5%" style="font-size:11px"><p align="center"><?= $no++ ?></p></td>
								<td width="50%" style="font-size:11px"><p align="center"><?= $rad->jenis_tindakan ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($rad->biaya_rad, 2 , ',' , '.' ) ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($rad->vtot, 2 , ',' , '.' ) ?></p></td>
							</tr>
							
						<?php 
							$total_tagihan_rad += $rad->vtot;
						}
						?>
						<tr>
							<td width="5%" style="font-size:11px" colspan="3"><p align="left"><b>Subtotal</b></p></td>
							<td width="5%" style="font-size:11px"><p align="left"><b> <?php echo number_format($total_tagihan_rad, 2 , ',' , '.' )?></b></p></td>
						</tr>

						<!-- em -->
						<tr>
							<th width="5%" style="font-size:11px" colspan="4"><p align="left"><b>Elektromedik</b></p></th>
						</tr>
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>
						<?php 
						$no=1;
						$total_tagihan_em=0;
						foreach($data_em as $em){ ?>
							<tr>
								<td width="5%" style="font-size:11px"><p align="center"><?= $no++ ?></p></td>
								<td width="50%" style="font-size:11px"><p align="center"><?= $em->jenis_tindakan ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($em->biaya_em, 2 , ',' , '.' ) ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($em->vtot, 2 , ',' , '.' ) ?></p></td>
							</tr>
							
						<?php 
							$total_tagihan_em += $em->vtot;
						}
						?>
						<tr>
							<td width="5%" style="font-size:11px" colspan="3"><p align="left"><b>Subtotal</b></p></td>
							<td width="5%" style="font-size:11px"><p align="left"><b> <?php echo number_format($total_tagihan_em, 2 , ',' , '.' )?></b></p></td>
						</tr>

						<!-- resep -->
						<tr>
							<th width="5%" style="font-size:11px" colspan="4"><p align="left"><b>Resep</b></p></th>
						</tr>
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Nama Obat</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>
						<?php 
						$no=1;
						$total_tagihan_obat=0;
						foreach($data_resep as $obat){ ?>
							<tr>
								<td width="5%" style="font-size:11px"><p align="center"><?= $no++ ?></p></td>
								<td width="50%" style="font-size:11px"><p align="center"><?= $obat->nama_obat ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($obat->biaya_obat, 2 , ',' , '.' ) ?></p></td>
								<td width="15%" style="font-size:11px"><p align="center"><?php echo number_format($obat->vtot, 2 , ',' , '.' ) ?></p></td>
							</tr>
							
						<?php 
							$total_tagihan_obat += $obat->vtot;
						}
						?>
						<tr>
							<td width="5%" style="font-size:11px" colspan="3"><p align="left"><b>Subtotal</b></p></td>
							<td width="5%" style="font-size:11px"><p align="left"><b> <?php echo number_format($total_tagihan_obat, 2 , ',' , '.' )?></b></p></td>
						</tr>
						<tr>
							<?php 
							$total =  $total_tagihan_tind + $total_tagihan_labor + $total_tagihan_rad + $total_tagihan_em + $total_tagihan_obat; 
							?>
							<td width="5%" style="font-size:11px" colspan="3"><p align="left"><b>Total Tagihan</b></p></td>
							<td width="5%" style="font-size:11px"><p align="left"><b> <?php echo number_format($total, 2 , ',' , '.' )?></b></p></td>
						</tr>
				    </table>


                    <table style="width:100%;">
						<tr>
							<td width="65%" >
							<p>
								<?= $kota_header.','.' '.$tgl ?>
								<br>Pasien
								<br>
								<br><br><br>
								
								</p>
							</td>
							<td width="35%">
								<p>
								<?= $kota_header.','.' '.$tgl ?>
								<br>an. Bendaharawan Rumah Sakit
								<br>K a s i r
								<br><br><br><?= $user ?>
								</p>
							</td>
						</tr>	
					</table>
        </div>
    </body>

</html>
            