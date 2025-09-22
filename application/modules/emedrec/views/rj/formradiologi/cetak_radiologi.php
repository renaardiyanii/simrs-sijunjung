<?php
// var_dump($hasil_pemeriksaan_radiologi);
// $result = array_chunk($data_pasien_irj, 1);

?>
<!DOCTYPE html>
<html>

<head>
    <title></title>
	<style>
		.sheet{
			background-repeat:no-repeat!important;
			background-size:700px!important;
			background-position: center center!important;
			background-image:url('<?= base_url("assets/img/logo_transparency_reduce.png"); ?>')!important;
		}
	</style>
</head>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    
    <div class="sheet padding-fix-10mm">
		<div class="imgbackground">
			
			
			<div>
				<center>
					<h3>RUMAH SAKIT OTAK DR. Drs. M . HATTA BUKITTINGGI </h3>
					<h3>INSTALASI RADIOLOGI </h3>
					<p><b><?= isset($hasil_pemeriksaan_radiologi[0]->jenis_tindakan)?$hasil_pemeriksaan_radiologi[0]->jenis_tindakan:'' ?></b></p>

				</center>
			</div>
			
		


			<!-- BORDER LUAR-->
					<table border="0" width="100%">
							<tr>
								<td width="18%">No. Reg</td>
								<td width="2%"> : </td>
								<td width="30%"><?= isset($data_pasien_rad->no_register)?$data_pasien_rad->no_register:'' ?></td>
								<td width="18%">Ruang / Poli</td>
								<td width="2%">:</td>
								<td width="30%">Radiologi</td>
								
							</tr>
							<tr>
								<td>No RM</td>
								<td> : </td>
								<td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
								<td>Tgl Daftar</td>
								<td>:</td>
								<td><?= isset($data_pasien_rad->tgl_kunjungan)?date("d-m-Y H:i:s",strtotime($data_pasien_rad->tgl_kunjungan)):''?></td>
							</tr>
							<tr>
								<td>Nama</td>
								<td> : </td>
								<td><b><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></b></td>
								<td>Tgl Hasil</td>
								<td> : </td>
								<td><?php echo isset($hasil_pemeriksaan_radiologi[0]->tanggal_isi)?date("d-m-Y H:i:s",strtotime($hasil_pemeriksaan_radiologi[0]->tanggal_isi)):''; ?></td>
								
							</tr>
							<tr>
								
								<td>J.kel/tgl.lahir </td>
								<td> : </td>
								<td ><?= isset($data_pasien->sex)?$data_pasien->sex.'/'.date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?></td>
								<td>Dokter Pengirim</td>
								<td> : </td>
								<td><?php echo isset($hasil_pemeriksaan_radiologi[0]->nm_dokter)?$hasil_pemeriksaan_radiologi[0]->nm_dokter:''; ?></td>
							</tr>
							<tr>
								<td >Rujukan</td>
								<td> : </td>
								<td ></td>
								<td>Kelas Rawat</td>
								<td> : </td>
								<td></td>
							</tr>
							<tr>
								<td >Diagnosa</td>
								<td> : </td>
								<td colspan="3">
								<?php 
										foreach ($nama_diagnosa as $key) {
											echo $key->diagnosa.', ';
										}
									?>
								</td>
								
							</tr>  
					</table><br>

					<hr color="black">

					<div style="min-height:600px">
						
						
						<p><pre style="font-size:12px"><?= isset($hasil_pemeriksaan_radiologi[0]->hasil_pengirim)?$hasil_pemeriksaan_radiologi[0]->hasil_pengirim:'' ?></pre><p><br>

						<!-- <p style="font-size:12px"><?php //echo isset($hasil_pemeriksaan_radiologi[0]->rekam_radiologi)?$hasil_pemeriksaan_radiologi[0]->rekam_radiologi:'' ?></p> -->

						
					</div>

					<table style="width:100%;" style="padding-bottom:5px;font-weight:bold">
								<tr>
									<td width="65%" ></td>
									<td width="35%">
										<p align="center" style="font-weight:bold">
											Terimakasih atas kerjasamanya
										</p>
										<div align="center" style="min-height:60px" >
											<p style="font-weight:bold">Wassalaam</p>
										</div>
										<?php 
											$cekeestttd = $this->labmdaftar->ttd_haisl($hasil_pemeriksaan_radiologi[0]->id_dokter)->row();
											if ($cekeestttd != null) {
										?>
											<img src="<?php echo $cekeestttd->ttd ?>" alt="">
										<?php }else{} ?>
										<p align="center" style="font-weight:bold">
										<u><?php echo isset($hasil_pemeriksaan_radiologi[0]->nm_dokter)?$hasil_pemeriksaan_radiologi[0]->nm_dokter:''; ?></u><br><br>
										<u>Sip. <?php echo isset($nipeg_dokter->nipeg)?$nipeg_dokter->nipeg:''; ?></u>
										</p>
									</td>
								</tr>	
					</table>    
		</div>
    </div>
    
</body>

</html>