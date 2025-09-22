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
			/* background-image:url('<?= base_url("assets/img/logo_transparency_reduce.png"); ?>')!important; */
		}
	</style>
</head>
<script src="<?= base_url('assets/js/barcode/barcode.js'); ?>"></script>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
<?php foreach($hasil_pemeriksaan_radiologi as $row){ ?>    
    <div class="sheet padding-fix-10mm">
		<div class="imgbackground">
			
			
			<div>
				<center>
					<h3>RSUD SIJUNJUNG </h3>
					<h3>INSTALASI RADIOLOGI </h3>
					<p><b><?= isset($row->jenis_tindakan)?$row->jenis_tindakan:'' ?></b></p>

				</center>
			</div>
			
		


			<!-- BORDER LUAR-->
					<table border="0" width="100%">
							<tr>
								<td width="18%">No. Reg</td>
								<td width="2%"> : </td>
								<td width="30%"><?= isset($row->no_register)?$row->no_register:'' ?></td>
								<td width="18%">Ruang / Poli</td>
								<td width="2%">:</td>
								<td width="30%"><?php 
									$pojavdsapkm = $this->M_emedrec->get_data_rad($row->no_register)->row()->idrg;
									echo $pojavdsapkm;
								?></td>
								
							</tr>
							<tr>
								<td>No RM</td>
								<td> : </td>
								<td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
								<td>Tgl Daftar</td>
								<td>:</td>
								<td><?= isset($row->tgl_kunjungan)?date("d F Y",strtotime($row->tgl_kunjungan)):''?></td>
							</tr>
							<tr>
								<td>Nama</td>
								<td> : </td>
								<td><b><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></b></td>
								<td>Tgl Periksa</td>
								<td> : </td>
								<td><?= isset($row->tanggal_isi)?date("d F Y",strtotime($row->tanggal_isi)):''?></td>
								
							</tr>
							<tr>
								
								<td>J.kel/tgl.lahir </td>
								<td> : </td>
								<td ><?= isset($data_pasien->sex)?$data_pasien->sex.'/'.date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?></td>
								<td>Dokter Pengirim</td>
								<td> : </td>
								<td><?php echo isset($row->nm_dokter)?$row->nm_dokter:''; ?></td>
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
								
							</tr>  
					</table><br>

					<hr color="black">

					<div style="min-height:600px">
						
						
						<pre style="font-size:12px"><?= isset($row->hasil_pengirim)?$row->hasil_pengirim:'' ?></pre><br>

						<!-- <p style="font-size:12px"><?php isset($row->rekam_radiologi)?$row->rekam_radiologi:'' ?></p> -->

						
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
										<p align="center" style="font-weight:bold">
										<?php 
											$cekeestttd = $this->labmdaftar->ttd_haisl($row->id_dokter)->row();
											if ($cekeestttd != null) {
										?>
											<img src="<?php echo $cekeestttd->ttd ?>" alt="">
										<?php }else{} ?>
										<u><?php echo isset($row->nm_dokter)?$row->nm_dokter:''; ?></u><br><br>
										<u>Sip. <?php echo isset($nipeg_dokter->nipeg)?$nipeg_dokter->nipeg:''; ?></u>
										</p>
									</td>
								</tr>	
					</table>    
		</div>
    </div>
<?php } ?>    
</body>

</html>