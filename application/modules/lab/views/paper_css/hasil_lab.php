<?php
//var_dump($hasil_lab);die();
?>
<!DOCTYPE html>
<html>

<head>
	<title></title>
</head>
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

	.table-font-size {
		font-size: 9px;
	}

	.table-font-size1 {
		font-size: 11px;
	}

	.table-font-size2 {
		font-size: 9px;
		margin: 5px 1px 1px 1px;
		padding: 5px 1px 1px 1px;
	}

	.lab_hasil {
		color: #ff0000 !important;
	}

	.micro tr td {
		font-size: 13px;
		line-height: 1.5;
	}
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<!-- <link rel="stylesheet" href="<?php //echo base_url('assets/css/paper.css') 
																	?>"> -->

<body class="A4">
	<div class="A4 sheet  padding-fix-10mm">
		<header style="margin-top:20px; font-size:1pt!important;">
			<table border="0" width="100%">
				<tr>
					<td width="13%">
						<p align="center">
							<img src="<?= FCPATH . ("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
						</p>
					</td>
					<td width="74%" style="font-size:9px;" align="center">
						<font style="font-size:8pt!important">
							<b><label>RSUD AHMAD SYAFII MAARIF</label></b><br>
						</font>
						<!-- <font style="font-size:8pt">
							<b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
							<b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
						</font>
						<br>
						<label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
						<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsomh.co.id</label> -->
					</td>
					<td width="13%">
						<p align="center">
							<!-- <img src="<?= FCPATH . ("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;"> -->
						</p>
					</td>
				</tr>
			</table>
		</header>
		<div style="height:0px;border: 2px solid black;"></div>
		<p align="center"><b>
				HASIL PEMERIKSAAN LABORATORIUM
			</b></p><br />
		<?php if (substr($no_register, 0, 2) == "PL") { ?>
			<table border="0">
				<tr>
					<td width="10%">No. Lab</td>
					<td width="2%"> : </td>
					<td width="40%"><?= $no_lab ?></td>
					<td width="10%">No Reg</td>
					<td width="2%"> : </td>
					<td width="16%"><?= $data_pasien->no_register ?></td>
					<td width="5%">No MR</td>
					<td width="2%"> : </td>
					<td width="13%">PL-<?= $data_pasien->no_cm ?></td>
				</tr>
				<tr>
					<td>Dokter</td>
					<td> : </td>
					<td><?= $data_pasien->dokter ?></td>
					<td>Nama Pasien</td>
					<td> : </td>
					<td colspan="4"><b><?= $data_pasien->nama ?></b></td>
				</tr>
				<tr>
					<td>Dr. PJ. Lab</td>
					<td> : </td>
					<td><?= $data_pasien->nm_dokter ?></td>
					<td width="10%">Kelamin</td>
					<td width="2%"> : </td>
					<td width="16%"><?php if ($data_pasien->jk == 'P') {
														echo 'Perempuan';
													} else {
														echo 'Laki - laki';
													} ?></td>
					<td width="5%">Usia</td>
					<td width="2%"> : </td>
					<td width="13%"><?php
													$tgl_lahir = date('Y', strtotime($data_pasien->tgl_lahir));
													$sekarang = date('Y');
													$tahun = (int)$sekarang - (int)$tgl_lahir;
													echo $tahun;
													?></td>
				</tr>
				<tr>
					<td width="10%">Tanggal</td>
					<td width="2%"> : </td>
					<td width="40%"><?= date("d F Y", strtotime($data_pasien->tgl_kunjungan)); ?></td>
					<td>Status</td>
					<td> : </td>
					<td>UMUM</td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td> : </td>
					<td><?= $data_pasien->alamat ?></td>
					<td>Asal / Lokasi</td>
					<td> : </td>
					<td colspan="4" rowspan="2 ">-</td>
				</tr>
			</table>
		<?php } else { ?>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
				<tr>
					<td width="18%">No. Lab</td>
					<td width="2%">:</td>
					<td width="30%"><?= $no_lab ?></td>
					<td width="18%">No Reg</td>
					<td width="2%"> : </td>
					<td width="30%"><?= $data_pasien->no_register ?></td>
				</tr>
				<tr>
					<td>No MR</td>
					<td> : </td>
					<td><?= $data_pasien->no_cm ?></td>
					<td>Dokter</td>
					<td> : </td>
					<td><?= $nama_dokter ?></td>
				</tr>
				<tr>
					<td>Nama Pasien</td>
					<td> : </td>
					<td><b><?= $data_pasien->nama ?></b></td>
					<td>Dr. PJ. Lab</td>
					<td> : </td>
					<td><?= $data_pasien->nm_dokter ?></td>
				</tr>
				<tr>

					<td>Kelamin</td>
					<td> : </td>
					<td><?= $kelamin ?></td>
					<td>Usia</td>
					<td> : </td>
					<?php
					// $age = date_diff(date_create($usia), date_create('now'))->y;
					// $age1 = date_diff(date_create($usia), date_create('now'))->m;
					?>
					<td><?= $usia->y . ' ' . 'Tahun' . ' ' . $usia->m . ' ' . 'Bulan' ?></td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td> : </td>
					<td><?= date("d F Y", strtotime($data_pasien->tgl_kunjungan)) ?></td>

					<td>Tgl Lahir</td>
					<td>:</td>
					<td><?= $data_pasien->tgl_lahir ? date('d-m-Y', strtotime($data_pasien->tgl_lahir)) : '-' ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td> : </td>
					<td>
						<?= $almt ?>
					</td>
					<td>Asal / Lokasi</td>
					<td> : </td>
					<td><?php if (substr($data_pasien->no_register, 0, 2) == 'RI') {
								echo $lokasi;
							} else {
								echo $data_pasien->bed;
							} ?></td>
				</tr>
				<tr>
					<td>Status</td>
					<td> : </td>
					<td><?= $cara_bayar ?></td>
					<td>Cito</td>
					<td>:</td>
					<td><?= $data_pasien->cito == '1' ? 'Ya' : 'Tidak' ?></td>
				</tr>
				<tr>
					<td>Tgl Jam Mulai</td>
					<td>:</td>
					<td><?= $data_pasien->tgl_mulai_pemeriksaan ? date('d-m-Y H:i:s', strtotime($data_pasien->tgl_mulai_pemeriksaan)) : '-' ?></td>
					<td>Tgl Jam Selesai</td>
					<td>:</td>
					<td><?= $data_pasien->tgl_selesai_pemeriksaan ? date('d-m-Y H:i:s', strtotime($data_pasien->tgl_selesai_pemeriksaan)) : '-' ?></td>
				</tr>

			</table>
		<?php } ?>
		<br>
		<?php

		// foreach($)
		// $iskultur = isset($data_jenis_lab[0]->nmtindakan)?strpos($data_jenis_lab[0]->nmtindakan, 'Kultur Dan Sensitifity') !== false?true:false:false;
		?>
		<!-- non kultur -->
		<table width="100%" border="1">
			<tr>
				<th style="font-size:11px;text-align:center" width="30%">
					<p align="center"><b>Jenis Pemeriksaan</b></p>
				</th>
				<th style="font-size:11px;text-align:center" width="30%">
					<p align="center"><b>Hasil</b></p>
				</th>
				<th style="font-size:11px;text-align:center" width="15%">
					<p align="center"><b>Satuan</b></p>
				</th>
				<th colspan="2" style="font-size:11px;text-align:center" width="25%">
					<p align="center"><b>Nilai Rujukan</b></p>
				</th>
			</tr>
			<?php
			//$ket = [];
			foreach ($data_kategori_lab as $rw) {

				$tindakan = strtoupper($rw->nama_jenis); ?>
				<tr>
					<td colspan="5" style="font-size:12px;text-align:center">
						<p align="center">
							<b><i><?= $tindakan ?></i></b>
						</p>
					</td>
				</tr>

				<?php

				foreach ($data_jenis_lab as $row) {
					// $iskultur = isset($row->nmtindakan) ? strpos($row->nmtindakan, 'Kultur Dan Sensitifity') !== false ? true : false : false;
					if ($rw->kode_jenis == substr($row->id_tindakan, 0, 2)) { ?>
						<tr>
							<td colspan="5">
								<p align="left" style="font-size:12px"><b>- <?= $row->nmtindakan ?></b></p>
							</td>
						</tr>
						<?php //if ($iskultur) :
						//urgent
						//$get_kultur = $this->labmdaftar->get_nama_organisme_kultur($row->id_tindakan,$no_lab); 
						?>
						<!-- <tr>
							<td colspan="5">
								<p style="font-size:11px">Nama Organisme : <?php //echo $get_kultur?$get_kultur->nama_organisme_kultur:'' 
																														?></p>
							</td>

						</tr> -->
						<?php //endif 
						?>

						<?php
						//if ($iskultur) :
						?>
						<!-- <tr>
								<th style="font-size:11px;text-align:center" width="30%">
									<p align="center"><b>Jenis Pemeriksaan</b></p>
								</th>
								<th style="font-size:11px;text-align:center" width="30%">
									<p align="center"><b>Antibiotik</b></p>
								</th>
								<th style="font-size:11px;text-align:center" width="15%">
									<p align="center"><b>MIC</b></p>
								</th>
								<th colspan="2" style="font-size:11px;text-align:center" width="25%">
									<p align="center"><b>Sensitifitas</b></p>
								</th>
							</tr> -->
						<?php //else : 
						?>

						<?php //endif; 
						?>

						<?php $data_hasil_lab = $this->labmdaftar->get_data_hasil_lab($row->id_tindakan, $row->no_lab)->result();

						foreach ($data_hasil_lab as $row1) {
							$kadar_normal = str_replace('<', '&lt;', $row1->kadar_normal);
							$kadar_normal = str_replace('>', '&gt;', $kadar_normal);
							$kadars = $this->labmdaftar->convertTipeKadarNormal($row1->kadar_normal, $row1->hasil_lab, $kelamin); ?>
							<tr>
								<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $row1->jenis_hasil ?></td>
								<td width="30%" class="<?= $kadars ? 'lab_hasil' : '' ?>">
									<center><?php echo $row1->hasil_lab; //$iskultur ? $row1->jenis_kuman :
													?></center>
								</td>

								<td width="15%"><?php echo $row1->satuan //$iskultur ? $row1->mic :
																?></td>
								<td width="25%" colspan="2"><?php echo $row1->kadar_normal //$iskultur ? $row1->sensitifitas : 
																						?></td>
							</tr>
						<?php
						}
						?>
					<?php } ?>
				<?php } ?>
			<?php } ?>
		</table><br>
		<!-- non kultur -->

		<!-- kultur -->
		<?php if ($data_kategori_kultur) { ?>
			<table width="100%" border="1">
				<tr>
					<th style="font-size:11px;text-align:center" width="30%">
						<p align="center"><b>Jenis Pemeriksaan</b></p>
					</th>
					<th style="font-size:11px;text-align:center" width="30%">
						<p align="center"><b>Antibiotik</b></p>
					</th>
					<th style="font-size:11px;text-align:center" width="15%">
						<p align="center"><b>MIC</b></p>
					</th>
					<th colspan="2" style="font-size:11px;text-align:center" width="25%">
						<p align="center"><b>Sensitifitas</b></p>
					</th>
				</tr>
				<?php
				//$ket = [];
				foreach ($data_kategori_kultur as $rwk) {

					$tindakan = strtoupper($rwk->nama_jenis); ?>
					<tr>
						<td colspan="5" style="font-size:12px;text-align:center">
							<p align="center">
								<b><i><?= $tindakan ?></i></b>
							</p>
						</td>
					</tr>

					<?php

					foreach ($data_jenis_kultur as $rowk) {
						$iskultur = isset($rowk->nmtindakan) ? strpos($rowk->nmtindakan, 'Kultur Dan Sensitifity') !== false ? true : false : false;
						if ($rwk->kode_jenis == substr($rowk->id_tindakan, 0, 2)) { ?>
							<tr>
								<td colspan="5">
									<p align="left" style="font-size:12px"><b>- <?= $rowk->nmtindakan ?></b></p>
								</td>
							</tr>
							<?php if ($iskultur) :
								//urgent
								$get_kultur = $this->labmdaftar->get_nama_organisme_kultur($rowk->id_tindakan, $no_lab);
							?>
								<tr>
									<td colspan="5">
										<p style="font-size:11px">Nama Organisme : <?php echo $get_kultur ? $get_kultur->nama_organisme_kultur : '' ?></p>
									</td>

								</tr>
							<?php endif ?>

							<?php $data_hasil_lab = $this->labmdaftar->get_data_hasil_lab($rowk->id_tindakan, $rowk->no_lab)->result();

							foreach ($data_hasil_lab as $row1k) {
								$kadar_normal = str_replace('<', '&lt;', $row1k->kadar_normal);
								$kadar_normal = str_replace('>', '&gt;', $kadar_normal);
								$kadars = $this->labmdaftar->convertTipeKadarNormal($row1k->kadar_normal, $row1k->hasil_lab, $kelamin); ?>
								<tr>
									<td width="30%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $row1k->jenis_hasil ?></td>
									<td width="30%" class="<?= $kadars ? 'lab_hasil' : '' ?>">
										<center><?php echo $iskultur ? $row1k->jenis_kuman : ''; ?></center>
									</td>

									<td width="15%"><?php echo $iskultur ? $row1k->mic : '' // $row1->satuan
																	?></td>
									<td width="25%" colspan="2"><?php echo $iskultur ? $row1k->sensitifitas : '' //$row1->kadar_normal
																							?></td>
								</tr>
							<?php
							}
							?>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</table><br>
		<?php } ?>
		<!-- end kultur -->
		<!-- <table width="100%" border="1" cellpadding="6px">
			<tr>
				<td><b>Catatan : </b><?php echo isset($ket) ? $ket : ''; ?></td>
			</tr>
		</table> -->
		<br />



		<table style="width:100%;" style="padding-bottom:5px;">
			<tr>
				<!-- <td width="65%"><img src="<?php //echo $qr; ?>" alt=""></td> -->
				<td width="65%"></td>
				<td width="35%" style="text-align: center;">
					<p>
						<br />
						Tanah Badantuang, <?= date("d-m-Y", strtotime($data_pasien->tgl_kunjungan));	?><br><br>

						<?php
                               
                                                            
                                $query1 = $user_id?$this->db->query("SELECT ttd,name FROM hmis_users where hmis_users.userid = $user_id")->row():null;
                                if(isset($query1->ttd)){
                                ?>

                                    <img width="120px" src="<?= $query1->ttd ?>" alt=""><br><br><br>
             
                                <?php
                                    } else {?>
                                       
                                <?php } ?>
						
						<?= $data_pasien->nm_dokter ?>
					</p>
				</td>
			</tr>
		</table>
		<br>
		<p style="font-size:11px">*Penafsiran Makna hasil pemeriksaan laboratorium ini hanya dapat diberikan oleh dokter</p>
	</div>
</body>

</html>