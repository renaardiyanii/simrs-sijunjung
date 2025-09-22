<div class="row">
    <div class="col-12">
    	<div class="row">
		    <div class="col-sm-12">
		        <div class="ribbon-wrapper card">
		            <div class="ribbon ribbon-info">Data Pasien
		            </div>
		            
					<div class="ribbon-content">
					<div class="p-20">
						<div class="row">
							<?php
								if(substr($no_register, 0,2)!="PL"){
							?>
							<div class="col-sm-2 text-center">
							<img height="100px" class="img-rounded" src="<?php
									if($foto==''){
										echo site_url("upload/photo/unknown.png");
									}else{
										echo site_url("upload/photo/".$foto);
									}
								?>">
							</div>
							<?php
								}
							?>	
							<div class="col-sm-10">
								<table class="table-sm table-striped" style="font-size:15" width="100%">
								  	<tbody>
										<tr>
											<th style="width: 30%;">Tanggal Kunjungan</th>
											<td style="width: 5%;">:</td>
											<td><?php echo date('d-m-Y | H:i',strtotime($tgl_kun));?></td>
										</tr>
										<tr>
											<th>Cara Bayar</th>
											<td>:&nbsp;</td>
											<td><?php echo $cara_bayar;?></td>
										</tr>
									<?php
										if($nmkontraktor!=""){
									?>
										<tr>
											<th></th>
											<td> &nbsp;</td>
											<td><?php echo $nmkontraktor;?></td>
										</tr>
									<?php
										}
									?>
										<tr>
											<th>No. Register</th>
											<td>:&nbsp;</td>
											<td><?php echo $no_register;?></td>
										</tr>
										<tr>
											<th>Nama</th>
											<td>:&nbsp;</td>
											<td><?php echo $nama;?></td>
										</tr>
									<?php
										if(substr($no_register, 0,2)=="PL"){
									?>
										<tr>
											<th>Alamat</th>
											<td>:&nbsp;</td>
											<td><?php echo $alamat;?></td>
										</tr>
										<tr>
											<th>Dokter</th>
											<td>:&nbsp;</td>
											<td><?php echo $dokter_rujuk;?></td>
										</tr>
										<tr>
											<th colspan=3>Pasien Luar</th>
										</tr>
										<tr>
											<th>RS Perujuk</th>
											<td>:&nbsp;</td>
											<td><?php echo $rs_perujuk??"";?></td>
										</tr>
									<?php
										} else if(substr($no_register, 0,2)=="RJ"){
									?>
										<tr>
											<th>No. CM</th>
											<td>:&nbsp;</td>
											<td><?php echo $no_cm;?></td>
										</tr>
										<tr>
											<th>Poli Asal</th>
											<td>:&nbsp;</td>
											<td><?php echo $bed;?></td>
										</tr>
										<tr>
											<th>Diagnosa</th>
											<td>:&nbsp;</td>
											<td><?php
												foreach ($nama_diagnosa as $key) {
													echo $key->diagnosa.', ';
												}
											?></td>
										</tr>
						
									<?php
										} else if(substr($no_register, 0,2)=="RD"){
									?>
										<tr>
											<th>No. CM</th>
											<td>:&nbsp;</td>
											<td><?php echo $no_cm;?></td>
										</tr>
										<tr>
											<th colspan=3>Pasien Rawat Darurat</th>
										</tr>

									<?php
										} else {
									?>
										<tr>
											<th>No. CM</th>
											<td>:&nbsp;</td>
											<td><?php echo $no_cm;?></td>
										</tr>
										<tr>
											<th>Kelas</th>
											<td>:&nbsp;</td>
											<td><?php echo $kelas_pasien;?></td>
										</tr>
										<tr>
											<th>ID Ruangan</th>
											<td>:&nbsp;</td>
											<td><?php echo $idrg;?></td>
										</tr>
										<tr>
											<th>Bed</th>
											<td>:&nbsp;</td>
											<td><?php echo $bed;?></td>
										</tr>
										<tr>
											<th>Diagnosa</th>
											<td>:&nbsp;</td>
											<td><?php echo $nama_diagnosa;?></td>
										</tr>
										<?php
											}
										?>
										<tr>
											<th>Dokter</th>
											<td>:&nbsp;</td>
											<td><?php echo isset($dokter_kirim->nm_dokter)?$dokter_kirim->nm_dokter:'';?></td>
										</tr>										
										<!-- <tr>
											<th>Waktu Masuk Lab</th>
											<td>:&nbsp;</td>
											<td><u><?php echo date('H:i',strtotime($waktu_masuk_lab));?></u></td>
										</tr> -->
									</tbody>
								</table><br>
								<a href="<?php echo site_url('medrec/el_record/pasien/'.$no_medrec); ?>" target="_blank" class="btn btn-danger" style='width:120px; height:30px '>Rekam Medik</a>
							</div>
							</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
	</div>
</div>