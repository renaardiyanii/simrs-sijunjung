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

	.table-isi {
		padding: 2px 5px;
	}

	.table-isi th {
		border-bottom: 1px solid #ddd;
	}

	.table-isi td {
		border-bottom: 1px solid #ddd;
		font-size: 9dp;
	}

	.sheet {
		background-repeat: no-repeat !important;
		background-size: 700px !important;
		background-position: center center !important;
		/* background-image:url('<?= base_url("assets/img/logo_transparency_reduce.png"); ?>')!important; */
	}
</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
	<?php
	//var_dump($data_hasil_rad2);die();
	foreach ($data_hasil_rad2 as $key) {
		//$gambar_hasil_rad=$this->radmdaftar->get_gambar_hasil_rad($key->id_pemeriksaan_rad)->result();
		//var_dump($key);die();
	?>
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
								<b><label>RSUD SIJUNJUNG</label></b><br>
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
					HASIL PEMERIKSAAN RADIOLOGI
				</b></p>
			<table border="0" width="100%">
				<tr>
					<td width="18%">No. Reg</td>
					<td width="2%"> : </td>
					<td width="30%"><?= isset($data_pasien->no_register) ? $data_pasien->no_register : '' ?></td>
					<td width="18%">Ruang / Poli</td>
					<td width="2%">:</td>
					<td width="30%"><?= isset($data_pasien->bed) ? $data_pasien->bed : '' ?></td>

				</tr>
				<tr>
					<td>No RM</td>
					<td> : </td>
					<td><?= isset($data_pasien->no_cm) ? $data_pasien->no_cm : '' ?></td>
					<td>Tgl Daftar</td>
					<td>:</td>
					<td><?= date("d-m-Y H:i:s", strtotime($data_pasien->tgl_kunjungan)) ?></td>
				</tr>
				<tr>
					<td>Nama</td>
					<td> : </td>
					<td><b><?= isset($data_pasien->nama) ? $data_pasien->nama : '' ?></b></td>
					<!-- <td>Tgl Hasil</td>
							<td> : </td>
							<td><?= isset($key->tanggal_isi) ? date("d-m-Y H:i:s", strtotime($key->tanggal_isi)) : '' ?></td> -->
					<td>J.kel/tgl.lahir </td>
					<td> : </td>
					<td><?= isset($kelamin) ? $kelamin . '/' . date('d-m-Y', strtotime($data_pasien->tgl_lahir)) : '' ?></td>
				</tr>
				<tr>
					<td>Dokter Pengirim</td>
					<td> : </td>
					<td>
						<?php if (substr($no_register, 0, 2) == "PL") { ?>
							<?= isset($data_pasien->dokter) ? $data_pasien->dokter : '' ?>
						<?php } else { ?>
							<?= isset($nama_dokter) ? $nama_dokter : '' ?>
						<?php } ?>
					</td>
					<td>Rujukan</td>
					<td> : </td>
					<td></td>
				</tr>
				<tr>
					<td>Kelas Rawat</td>
					<td> : </td>
					<td><?php echo $data_pasien->kelas; ?></td>
				</tr>
				<tr>

				</tr>
			</table><br>

			<div>

				<b>Jenis Pemeriksaan : <?php echo $key->jenis_tindakan ?></b><br>
				<?php
				// echo '<pre>';
				// var_dump($gambar_hasil_rad);
				// echo '</pre>';

				foreach ($resultGambar as $gambar) {
					// echo '<pre>';
					// 			var_dump($gambar);
					// 			echo '</pre>';
					// die();

					foreach ($gambar as $val) {
						// 	echo '<pre>';
						// 			var_dump($val);
						// 			echo '</pre>';

						if ($key->id_pemeriksaan_rad == $val->id_pemeriksaan_rad) :
				?>
							<img src="<?php echo base_url(); ?>download/rad/<?php echo $val->name; ?>" alt="" height="200" style="padding-right:5px;">
				<?php
						endif;
					}
					// die();
				} ?>
				<br>
				<p>Hasil Pengirim</p>
				<pre style="font-size:12px"><?= $key->hasil_pengirim ?></pre>
				<!-- <p>Rekam Radiologi</p>
				<p style="font-size:12px"><?php //echo $key->rekam_radiologi 
																	?></p> -->
				<hr>
			</div>

			<table style="width:100%;" style="padding-bottom:5px;font-weight:bold">
				<tr>
					<td width="65%">
						
					</td>
					<td width="35%" style="text-align: center;">
						<p style="font-weight:bold">
							Terimakasih atas kerjasamanya
						</p>
						<div style="min-height:60px">
							<p style="font-weight:bold">Wassalaam</p>
						</div>
						<?php
						// if($key->id_dokter_1 != null){
						// 	$cekeestttd = $this->labmdaftar->ttd_haisl($key->id_dokter_1)->row();
						// }else{
						// 	$cekeestttd = null;
						// }

						// if ($cekeestttd != null) {
						?>
						<img src="<?php echo $ttd ?>" alt="">
						<?php //}else{} 
						?>
						<p style="font-weight:bold">
							<u><?php
									// if($key->id_dokter_1 != null){
									// 	$cekeename = $this->labmdaftar->ttd_haisl($key->id_dokter_1)->row();
									echo $name;
									// }else{
									// 	echo '';
									// }

									?></u>
						</p>
					</td>
				</tr>
			</table>

		</div>


	<?php } ?>
</body>

</html>