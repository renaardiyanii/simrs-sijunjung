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
            font-size:11px;
            }
        .table-font-size2{
            font-size:9px;
            margin : 5px 1px 1px 1px;
            padding : 5px 1px 1px 1px;
            }
		.sheet{
			background-repeat:no-repeat!important;
			background-size:700px!important;
			background-position: center center!important;
			background-image:url('<?= base_url("assets/img/logo_transparency_reduce.png"); ?>')!important;
			}
						
    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4">
        <div class="A4 sheet  padding-fix-10mm">
		<div style="text-align: center;">
            
                <h3>RUMAH SAKIT OTAK DR. Drs. M . HATTA BUKITTINGGI </h3>
                <h3>INSTALASI RADIOLOGI </h3>
                <p><b><?= isset($data_hasil_rad[0]->jenis_tindakan)?$data_hasil_rad[0]->jenis_tindakan:'' ?></b></p>

            
        </div>
           

            <?php if(substr($no_register, 0,2)=="PL"){?>
                <table border="0" width="100%">
						<tr>
							<td width="18%">No. Reg</td>
							<td width="2%"> : </td>
							<td width="30%"><?= isset($data_pasien->no_register)?$data_pasien->no_register:'' ?></td>
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
							<td><?= date("d F Y",strtotime($data_pasien->tgl_kunjungan))?></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td> : </td>
							<td><b><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></b></td>
							<td>Tgl Periksa</td>
							<td> : </td>
							<td><?= isset($data_pasien->jadwal)?date("d-m-Y", strtotime($data_pasien->jadwal)):''; ?></td>
                            
						</tr>
						 <tr>
							
						 	<td>J.kel/tgl.lahir </td>
							<td> : </td>
							<td ><?= isset($kelamin)?$kelamin.'/'.date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?></td>
							<td>Dokter Pengirim</td>
							<td> : </td>
							<td> 
								<?php if(substr($no_register, 0,2)=="PL"){?>
									<?= isset($data_pasien->dokter)?$data_pasien->dokter:'' ?>
								<?php } else { ?>
									<?= isset($nama_dokter)?$nama_dokter:'' ?>
								<?php }?>
							</td>
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
            <?php }else{ ?> 
                <table border="0" width="100%">
						<tr>
							<td width="18%">No. Reg</td>
							<td width="2%"> : </td>
							<td width="30%"><?= isset($data_pasien->no_register)?$data_pasien->no_register:'' ?></td>
							<td width="18%">Ruang / Poli</td>
							<td width="2%">:</td>
							<td width="30%"><?php 
								if(substr($no_register,0,2) == 'RJ') {
									echo isset($data_pasien->bed)?$data_pasien->bed:'';
								} else if(substr($no_register,0,2) == 'RI') {
									echo isset($data_pasien->idrg)?$data_pasien->idrg:'';
								} 
								?>
							</td>
						</tr>
                        <tr>
							<td>No RM</td>
							<td> : </td>
							<td><?= isset($data_pasien->no_cm)?$data_pasien->no_cm:'' ?></td>
                            <td>Tgl Daftar</td>
							<td>:</td>
							<td><?= date("d F Y",strtotime($data_pasien->jadwal))?></td>
						</tr>
						<tr>
							<td>Nama</td>
							<td> : </td>
							<td><b><?= isset($data_pasien->nama)?$data_pasien->nama:'' ?></b></td>
							<td>Tgl Periksa</td>
							<td> : </td>
							<td><?= isset($data_pasien->tgl_kunjungan)?date("d F Y", strtotime($data_pasien->tgl_kunjungan)):''; ?></td>
                            
						</tr>
						 <tr>
							
						 	<td>J.kel/tgl.lahir </td>
							<td> : </td>
							<td ><?= isset($kelamin)?$kelamin.'/'.date('d-m-Y',strtotime($data_pasien->tgl_lahir)):'' ?></td>
							<td>Dokter Pengirim</td>
							<td> : </td>
							<td>
								<?php if(substr($no_register, 0,2)=="PL"){?>
									<?= isset($data_pasien->dokter)?$data_pasien->dokter:'' ?>
								<?php } else { ?>
									<?= isset($nama_dokter)?$nama_dokter:'' ?>
								<?php }?>
							</td>
						</tr>
						 <tr>
							<td>Kelas Rawat</td>
							<td> : </td>
							<td><?= isset($data_pasien->kelas)?$data_pasien->kelas:'';?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<tr>
							
						</tr>  
				</table><br>
            <?php } ?>

			<div style="height:0px;border: 2px solid black;"></div>

            <div style="min-height:600px">
				<?php
				$gambar_hasil_rad=$this->radmdaftar->get_gambar_hasil_rad($data_hasil_rad[0]->id_pemeriksaan_rad)->result(); 
					foreach ($gambar_hasil_rad as $gambar) { ?>
					<img src="<?php echo base_url(); ?>download/rad/<?php echo $gambar->name; ?>" alt="img" height="200" style="padding-right:5px;">
				<?php } ?>
                <h2>Hasil Pengirim</h2>
                <pre style="font-size:12px"><?= isset($data_hasil_rad[0]->hasil_pengirim)?$data_hasil_rad[0]->hasil_pengirim:'' ?></pre><br>
				<hr>
				<!-- <h2>Rekam Radiologi</h2> -->
				<!-- <p style="font-size:12px"><?php //echo isset($data_hasil_rad[0]->rekam_radiologi)?$data_hasil_rad[0]->rekam_radiologi:'' ?></p> -->

                
            </div>

			<table style="width:100%;" style="padding-bottom:5px;font-weight:bold">
						<tr>
							<td width="65%" ></td>
							<td width="35%" style="text-align: center;">
								<p style="font-weight:bold">
									Terimakasih atas kerjasamanya
								</p>
								<div style="min-height:60px" >
									<p style="font-weight:bold">Wassalaam</p>
								</div>
								<?php 
									$cekeestttd = $this->labmdaftar->ttd_haisl($id_dokter_1)->row();
									if ($cekeestttd != null) {
								?>
									<img src="<?php echo $cekeestttd->ttd ?>" alt="">
								<?php }else{} ?>
								<p style="font-weight:bold">
								<u><?= isset($dokter_1)?$dokter_1:''  ?></u>
								</p>
							</td>
						</tr>	
			</table>
        </div>
    </body>
</html>