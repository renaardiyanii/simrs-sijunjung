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
							<img src="<?= FCPATH . ("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
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
						<label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsomh.co.id</label>
					</td>
					<td width="13%">
						<p align="center">
							<img src="<?= FCPATH . ("assets/img/$logo_header"); ?>" alt="img" height="60" style="padding-right:5px;">
						</p>
					</td>
				</tr>
			</table>
		</header>
		<div style="height:0px;border: 2px solid black;"></div><br>
		<?php if (substr($no_register, 0, 2) == "PL") { ?>
			<table border="0">
				<tr>
					<td width="10%">No. Diag</td>
					<td width="2%"> : </td>
					<td width="40%"><?= $no_em ?></td>
					<td width="10%">No Reg</td>
					<td width="2%"> : </td>
					<td width="16%"><?= $data_pasien->no_register ?></td>
					<td width="5%">No MR</td>
					<td width="2%"> : </td>
					<td width="13%">-</td>
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
					<td><?= $data_pasien->dokter ?></td>
					<td width="10%">Kelamin</td>
					<td width="2%"> : </td>
					<td width="16%">-</td>
					<td width="5%">Usia</td>
					<td width="2%"> : </td>
					<td width="13%"><?= (int)date('Y') - (int)$data_pasien->tgl_lahir; ?></td>
				</tr>
				<tr>
					<td width="10%">Tanggal</td>
					<td width="2%"> : </td>
					<td width="40%"><?= date("d F Y", strtotime($data_pasien->tgl_kunjungan)) ?></td>
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
					<td colspan="4" rowspan="2">-</td>
				</tr>
			</table>

		<?php } else { ?>
			<table border="0" cellpadding="0" cellspacing="1" width="100%">
				<tr>
					<td width="18%">No. Diag</td>
					<td width="2%">:</td>
					<td width="30%"><?= $no_em ?></td>
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
					<td><?= $tahun ?>Thn</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td> : </td>
					<td><?= date("d F Y", strtotime($data_pasien->tgl_kunjungan)) ?></td>
					<td>Status</td>
					<td> : </td>
					<td><?= $cara_bayar ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td> : </td>
					<td>
						<?= $almt ?>
					</td>
					<td>Asal / Lokasi</td>
					<td> : </td>
					<td><?= $lokasi ?></td>
				</tr>
			</table>
		<?php } ?>

		<br>
		<table class="table-isi" border="1" width="100%">
			<?php
			//var_dump($gambar_hasil_em);die();
			foreach ($data_hasil_em2 as $key) {
				//$gambar_hasil_em1=$this->emmdaftar->get_gambar_hasil_em($key->id_pemeriksaan_em)->result(); 
			?>

				<tr>
					<th colspan="2">
						<p align="left" style="font-size:11px">
							<b>Jenis Pemeriksaan : <?= $key->jenis_tindakan ?></b>
						</p>
					</th>
				</tr>

				<?php foreach ($gambar_hasil_em as $gambar) {
					// echo '<pre>';
					// 			var_dump($gambar);
					// 			echo '</pre>';
					// 			die();
					foreach ($gambar as $val) :
						// echo '<pre>';
						// 		var_dump($val);
						// 		echo '</pre>';
						// 		die();
						if ($key->id_pemeriksaan_em == $val->id_pemeriksaan_em) :
				?>

							<tr>
								<td width="30%">
									<p style="font-size:11px">Gambar Hasil Pemeriksaan : </p>
								</td>
								<td width="70%">
									<img src="<?php echo base_url('download/') . $val->name; ?>" alt="img" height="60" style="padding-right:5px;">
								</td>
							</tr>

				<?php
						endif;
					endforeach;
				}	 ?>

				<tr>
					<td width="30%" style="font-size:11px">
						Dokter 1 :<br>
						Hasil :
					</td>
					<td width="70%" style="font-size:11px">
						<span align="left">
							<?= $dokter_1 ?><br>
							<?= $key->hasil ?>
						</span>
					</td>
				</tr>

				<tr>
					<td style="font-size:11px">Dokter Pengirim :<br>Hasil :</td>
					<td>
						<span style="font-size:11px" align="left"><?= $nama_dokter ?><br><?= $key->hasil_pengirim ?></span>
					</td>
				</tr>

			<?php } ?>

		</table>

		<br />
		<br />
		<table style="width:100%;" style="padding-bottom:5px;font-size: 20px;">
			<tr>
				<td width="75%"><img src="<?php echo $qr; ?>" alt=""></td>
				<td width="25%" style="text-align: center;">

					<br />
					<p> <?= $kota_header . ',' . ' ' . $tgl	?></p>
					<br>Dokter Pembaca
					<?php
					// $cekeestttd = $this->labmdaftar->ttd_haisl($id_dokter_1)->row();
					// if ($cekeestttd != null) {
					?>
					<img src="<?php echo $ttd ?>" alt="">
					<?php //}else{} 
					?>
					<br><br><br>
					<p> <?= $dokter_1 ?></p>

				</td>
			</tr>
		</table>

		<div>
</body>
<html>