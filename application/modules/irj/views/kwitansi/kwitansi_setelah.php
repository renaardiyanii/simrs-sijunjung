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

			.sheet {
			page-break-after: auto !important;
			}
						
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
		<header style="margin-top:20px; font-size:12pt!important;">
				<table border="1" width="100%" style="border-collapse: collapse; border: solid 1px black;" cellpadding="5px"  cellspacing="5px">
				<tr>
					<td width="30%" >
						<p style="font-size:12px;font-weight:bold">PEMDA KABUPATEN SIJUNJUNG</p>
						<center><span style="font-size:8px">Jl. Prof. M. Yamin, SH No.17</span></center>
						<center><p style="font-size:10px;font-weight:bold">Muaro Sijunjung</p></center>
					</td>
					<td width="40%" style="text-align: center;">
						<p style="font-size:12px; font-weight:bold;">SURAT KETETAPAN RETRIBUSI DAERAH</p>
						<span style="font-size:12px; font-weight:bold;">(SKRD)</span>
						<p style="font-size:8px; text-align:left;">Masa Retribusi :</p>
						<p style="font-size:8px; text-align:left;">Tahun : <?= date('Y') ?></p>
					</td>
					<td width="30%" style="text-align: center;">
						<p style="font-size:8px;">No Urut : <?=strtoupper($no_kwitansi)?></p>
						
					</td>
				</tr>
				</table>
            </header>
			<div style="border: solid 1px black">
            
                <table width="100%" border="0">	
							<tr>
								<td colspan="6" ><center><p size="12px" align="center"><u><b>KWITANSI <?php if (substr($detail_daful->nm_poli,0,3) == 'IGD') {
									echo 'RAWAT DARURAT';
								}else{
									echo 'RAWAT JALAN';
								} ?> </b></u></p></center></td>
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
			</div>
                <?php $no=1; ?>
			
			    <table border="1" style="padding:2px" width="100%" >
						<tr>
							<th width="5%" style="font-size:11px"><p align="center"><b>No</b></p></th>
							<th width="50%" style="font-size:11px"><p align="center"><b>Pemeriksaan</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Biaya</b></p></th>
							<th width="15%" style="font-size:11px"><p align="center"><b>Total</b></p></th>
						</tr>

						<tr><td colspan ="4"><p>Tindakan</p></td></tr>

                       <?php  
					   $jumlah_vtot = 0;  
					   foreach($data_tindakan as $row1){ ?>
					
                        <tr>
                            <td><p align="center" style="font-size:11px"><?= $no++ ?></p></td>
                            <td style="font-size:11px"><p><?= ucwords(strtolower($row1->nmtindakan))?></p></td>
                            <td><p align="right" style="font-size:11px"><?= number_format( $row1->vtot, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format(($row1->vtot), 2 , ',' , '.' )?></p></td>
                        </tr>
						<?php 
						
						$jumlah_vtot += $row1->vtot;
							

						} ?>
			
						<tr>
							<th colspan="3"><p align="right" style="font-size:11px"><b></b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot, 2 , ',' , '.' )?></p></th>
						</tr>

						<tr><td colspan ="4"><p>Laboratorium</p></td></tr>

						<?php  
							$nolab = 1;
							$jumlah_vtot_lab = 0;  
							foreach($data_laboratorium as $row1){ ?>
					
                        <tr>
                            <td><p align="center" style="font-size:11px"><?= $nolab++ ?></p></td>
                            <td style="font-size:11px"><p><?= ucwords(strtolower($row1->jenis_tindakan))?></p></td>
                            <td><p align="right" style="font-size:11px"><?= number_format( $row1->vtot, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format(($row1->vtot), 2 , ',' , '.' )?></p></td>
                        </tr>
						<?php 
						
						$jumlah_vtot_lab += $row1->vtot;
							

						} ?>

						<tr>

							<th colspan="3"><p align="right" style="font-size:11px"><b></b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot_lab, 2 , ',' , '.' )?></p></th>
						</tr>

						<tr><td colspan ="4"><p>Radiologi</p></td></tr>

						<?php  
							$norad = 1;
							$jumlah_vtot_rad = 0;  
							foreach($data_radiologi as $row1){ ?>
					
                        <tr>
                            <td><p align="center" style="font-size:11px"><?= $norad++ ?></p></td>
                            <td style="font-size:11px"><p><?= ucwords(strtolower($row1->jenis_tindakan))?></p></td>
                            <td><p align="right" style="font-size:11px"><?= number_format( $row1->vtot, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format(($row1->vtot), 2 , ',' , '.' )?></p></td>
                        </tr>
						<?php 
						
						$jumlah_vtot_rad += $row1->vtot;
							

						} ?>

						<tr>

							<th colspan="3"><p align="right" style="font-size:11px"><b></b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot_rad, 2 , ',' , '.' )?></p></th>
						</tr>

						<tr><td colspan ="4"><p>Resep</p></td></tr>

						<?php  
							$noresep = 1;
							$jumlah_vtot_resep = 0;  
							foreach($data_resep as $row1){ ?>
					
                        <tr>
                            <td><p align="center" style="font-size:11px"><?= $noresep++ ?></p></td>
                            <td style="font-size:11px"><p><?= ucwords(strtolower($row1->nama_obat))?></p></td>
                            <td><p align="right" style="font-size:11px"><?= number_format( $row1->vtot, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format(($row1->vtot), 2 , ',' , '.' )?></p></td>
                        </tr>
						<?php 
						
						$jumlah_vtot_resep += $row1->vtot;
							

						} ?>

						<tr>

							<th colspan="3"><p align="right" style="font-size:11px"><b></b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot_resep, 2 , ',' , '.' )?></p></th>
						</tr>


						<tr><td colspan ="4"><p>Operasi</p></td></tr>

						<?php  
							$nook = 1;
							$jumlah_vtot_ok = 0;  
							foreach($data_ok as $row1){ ?>
					
                        <tr>
                            <td><p align="center" style="font-size:11px"><?= $nook++ ?></p></td>
                            <td style="font-size:11px"><p><?= ucwords(strtolower($row1->jenis_tindakan))?></p></td>
                            <td><p align="right" style="font-size:11px"><?= number_format( $row1->vtot, 2 , ',' , '.' )?></p></td>
							<td><p align="right" style="font-size:11px"><?= number_format(($row1->vtot), 2 , ',' , '.' )?></p></td>
                        </tr>
						<?php 
						
						$jumlah_vtot_ok += $row1->vtot;
							

						} ?>

						<tr>

							<th colspan="3"><p align="right" style="font-size:11px"><b></b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot_ok, 2 , ',' , '.' )?></p></th>
						</tr>


						<tr>

							<th colspan="3"><p align="right" style="font-size:11px"><b>TOTAL</b></p></th>
							<th><p align="right" style="font-size:11px"><?= number_format( $jumlah_vtot_rad + $jumlah_vtot_lab + $jumlah_vtot + $jumlah_vtot_resep +$jumlah_vtot_ok , 2 , ',' , '.' )?></p></th>
						</tr>
						
						
					
					</table>
					
				
					<div style="border: solid 1px black">
						<table style="width: 100%;" width="100%">
							<tr>
								<td style="width: 50%;"></td>
								<td style="width: 50%;" align="center">Tanah Badantuang <?= $tgl ?></td>
							</tr>

							<tr>
								<td style="width: 50%;"></td>
								<td style="width: 50%;" align="center">Pemimpin BLUD</td>
							</tr>

							<tr>
							<td style="width: 50%;" align="center"><img width="120px" src= "<?= $ttd_wen->ttd ?>"></td>
								
								<td style="width: 50%;" align="center"><img width="120px" src= "<?= $ttd_dir->ttd ?>"></td>
							</tr>

							<tr>
							<td align="center"><?=  $ttd_wen->name ?></td>
								<td style="width: 50%;" align="center">( dr. Reyantis Capanay)</td>
							</tr>

							


							
						</table>
					</div>
					
				</div>
    </body>

</html>
            