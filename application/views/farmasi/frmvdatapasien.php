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
								<tr>
									<th>Nama</th>
									<td>:&nbsp;</td>
									<td><?php echo $nama;?></td>
								</tr>
								<tr>
									<th>No. Register</th>
									<td>:&nbsp;</td>
									<td><?php echo $no_register;?></td>
								</tr>
								<tr>
									<th>Dokter</th>
									<td>:&nbsp;</td>
									<td><?php echo $nmdokter;?></td>
								</tr>
								
			<?php
				if(substr($no_register, 0,2)=="PL"){
			?>
								<tr>
									<th colspan=3>Pasien Luar</th>
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
									<th>Unit</th>
									<td>:&nbsp;</td>
									<th colspan=3>Pasien Rawat Jalan</th>
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
									<th>Unit</th>
									<td>:&nbsp;</td>
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

			<?php
				}
			?>
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