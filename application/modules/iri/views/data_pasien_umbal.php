<div class="row">
    <div class="col-12">
    	<div class="row">
		    <div class="col-sm-12">
		        <div class="ribbon-wrapper card">
		            <div class="ribbon ribbon-info">Data Pasien</div>
					<div class="ribbon-content">
					<div class="p-20">
						<div class="row">
							<div class="col-sm-10">
							
								<table class="table-sm table-striped" style="font-size:15" width="100%">
								  	<tbody>
										<tr>
											<th style="width: 30%;">Tanggal Keluar</th>
											<td style="width: 5%;">:</td>
											<td><?php echo date('d-m-Y',strtotime($data_pasien->tgl_keluar_resume));?></td>
										</tr>
										<tr>
											<th>Cara Bayar</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->carabayar;?></td>
										</tr>
										<tr>
											<th>Kontraktor</th>
											<td> &nbsp;</td>
											<td><?php echo $data_pasien->nmkontraktor;?></td>
										</tr>
										<tr>
											<th>No. Register</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->no_ipd;?></td>
										</tr>
										<tr>
											<th>Nama</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->nama;?></td>
										</tr>
										<tr>
											<th>Jenis Kelamin</th>
											<td>:&nbsp;</td>
											<td><?php
                                            if($data_pasien->sex == 'L') {
                                                echo 'Laki Laki';
                                            } else {
                                                echo 'Perempuan';
                                            }
                                            ?></td>
										</tr>
										<tr>
											<th>Alamat</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->alamat;?></td>
										</tr>
										<tr>
											<th>No. CM</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->no_cm;?></td>
										</tr>
										<tr>
											<th>Ruang</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->ruang;?></td>
										</tr>
										<tr>
											<th>Dokter</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien->dokter;?></td>
										</tr>
									</tbody>
								</table>
							</div>
							</div>
						</div>
					</div>
		        </div>
		    </div>
		</div>
	</div>
</div>