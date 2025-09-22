<?php 
	if ($role_id == 1) {
		$this->load->view("layout/header_left");
	} else {
		$this->load->view("layout/header_horizontal");
	} 
?>
<?php $this->load->view("iri/data_pasien_keluar"); ?>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.buttons.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.bootstrap.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/jszip.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/pdfmake.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/vfs_fonts.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.html5.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.print.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.fixedHeader.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.keyTable.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.responsive.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/responsive.bootstrap.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.scroller.min.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.colVis.js"></script> 
	<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.fixedColumns.min.js"></script>
<br>
<div >
	<div >
		 
		<!-- Keterangan page -->
		<section class="content-header">
			<h1>STATUS PASIEN DI RUANGAN</h1>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					<!-- Tabs -->
					<div class="card card-block">
						<ul class="nav nav-tabs customtab" role="tablist">
							<li class="nav-item text-center"><a class="nav-link active" href="#mutasi" data-toggle="tab" role="tab"><span class="hidden-xs-down">Ruangan</span></a></li>
							<li class="nav-item text-center"><a class="nav-link" href="#tindakan" data-toggle="tab" role="tab"><span class="hidden-xs-down">Tindakan</span></a></li>
							<li class="nav-item text-center"><a class="nav-link" href="#ok_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Operasi</span></a></li>
							<li class="nav-item text-center"><a class="nav-link" href="#radiologi" data-toggle="tab" role="tab"><span class="hidden-xs-down">Radiologi</span></a></li>
							<!-- <li class="nav-item text-center"><a class="nav-link" href="#elektromedik" data-toggle="tab" role="tab"><span class="hidden-xs-down">Elektromedik</span></a></li> -->
							<li class="nav-item text-center"><a class="nav-link" href="#lab_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Lab</span></a></li>
							<!-- <li class="nav-item text-center"><a class="nav-link" href="#pa_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Patologi Anatomi</span></a></li> -->
							<li class="nav-item text-center"><a class="nav-link" href="#resep_pasien" data-toggle="tab" role="tab"><span class="hidden-xs-down">Resep</span></a></li>
							<!-- <li class="nav-item text-center"><a href="#tindakan_ird" data-toggle="tab">Tindakan IRD</a></li> -->
							<li class="nav-item text-center"><a class="nav-link" href="#poli_irj" data-toggle="tab" role="tab"><span class="hidden-xs-down">Poli/IRD</span></a></li>							
						</ul>
						<div class="tab-content"><br>
							<div class="tab-pane active" id="mutasi" role="tabpanel">
								<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Ruang</th>
									  <th>Kelas</th>
									  <!-- <th>Jatah Kelas</th> -->
									  <th>Bed</th>
									  <th>Tgl Masuk</th>
									  <th>Tgl Keluar</th>
									  <th>Lama Inap</th>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
									  		<th>Total Biaya Kelas</th>
										<?php
										}
										?>
									  <?php
									  	if((($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL)){ ?>
											<th>Total Biaya Jatah Kelas</th>
										 <?php
										 }
									  ?>
									  <?php
									  	if($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) { ?>
											<th>Total Selisih</th> 
										<?php
										}
									  ?>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									$total_jatah_kelas = 0;
									$total_selisih = 0;
									$total_titip = 0;
									
									if(!empty($list_mutasi_pasien)){
										foreach($list_mutasi_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['nmruang'] ; ?></td>
											<td><?php echo $r['kelas'] ; ?></td>
											<!-- <td><?php echo $r['jatahklsiri'] ; ?></td> -->
											<td><?php echo $r['bed'] ; ?></td>
											<td>
												<?php
										  		echo date('d-m-Y',strtotime($r['tglmasukrg']));
										  		?>
											</td>
											<td><?php 
											if($r['tglkeluarrg'] != null){

										  		echo date('d-m-Y',strtotime($r['tglkeluarrg']));

												//echo date("j F Y", strtotime($r['tglkeluarrg'])) ;
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
													//echo date("j F Y", strtotime($data_pasien[0]['tgl_keluar'])) ;
											  		echo date('d-m-Y',strtotime($data_pasien[0]['tgl_keluar']));
												}else{
													echo "-";	
												}
											}
											?>

											</td>
											<td>
											<?php
											$diff = 1;
											if($r['tglkeluarrg'] != null){
												$start = new DateTime($r['tglmasukrg']);//start
												$end = new DateTime($r['tglkeluarrg']);//end

												$diff = $end->diff($start)->format("%a");
												if($diff == 0){
													$diff = 1;
												}
												echo $diff." Hari"; 
											}else{
												if($data_pasien[0]['tgl_keluar'] != NULL){
												$start = new DateTime($r['tglmasukrg']);//start
													$end = new DateTime($data_pasien[0]['tgl_keluar']);//end

													$diff = $end->diff($start)->format("%a");
													if($diff == 0){
														$diff = 1;
													}
													echo $diff." Hari"; 
												}else{
													$start = new DateTime($r['tglmasukrg']);//start
													$end = new DateTime(date("Y-m-d"));//end

													$diff = $end->diff($start)->format("%a");
													if($diff == 0){
														$diff = 1;
													}
													
													echo $diff." Hari"; 
												}
											}
											?>
											</td>
											<?php if($data_pasien[0]['titip'] == NULL) { 
												if($data_pasien[0]['carabayar'] == 'UMUM') { ?>
													<td><?php echo "Rp. ".number_format($diff * $r['total_tarif'],0);
														$total_bayar = $total_bayar + ($diff * $r['total_tarif'] );?>
													</td>
											<?php } else if($data_pasien[0]['carabayar'] == 'BPJS') { ?>
													<td><?php echo "Rp. ".number_format($diff * $r['total_tarif'],0);
														$total_bayar = $total_bayar + ($diff * $r['total_tarif'] );?>
													</td>
											<?php } else { ?>
													<td><?php echo "Rp. ".number_format($diff * $r['tarif_iks'],0);
														$total_bayar = $total_bayar + ($diff * $r['tarif_iks'] );?>
													</td>
											<?php }
											} ?>
											<?php if(($data_pasien[0]['titip'] == '1') || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL)){ 
												if($data_pasien[0]['carabayar'] == 'UMUM') { ?>
													<td><?php echo "Rp. ".number_format( $diff * $r['tarif_jatah'],0);
														$total_jatah_kelas = $total_jatah_kelas + ($diff * $r['tarif_jatah'] );?>
													</td>
											<?php } else if($data_pasien[0]['carabayar'] == 'BPJS') { ?>
												<td><?php echo "Rp. ".number_format( $diff * $r['tarif_jatah_bpjs'],0);
													$total_jatah_kelas = $total_jatah_kelas + ($diff * $r['tarif_jatah_bpjs'] );?>
												</td>
											<?php } else if($data_pasien[0]['carabayar'] == 'KERJASAMA') { ?>
												<td><?php echo "Rp. ".number_format( $diff * $r['tarif_jatah_iks'],0);
													$total_jatah_kelas = $total_jatah_kelas + ($diff * $r['tarif_jatah_iks'] );?>
												</td>
											<?php }
											} ?>
											<?php if($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) { ?>
												<td>
													<?php
														if(($r['total_tarif'] > $r['tarif_jatah']) || ($r['total_tarif'] == $r['tarif_jatah'])) {
															echo "Rp. ".number_format($total_bayar - $total_jatah_kelas);
															$total_selisih = $total_selisih + ($total_bayar - $total_jatah_kelas);
														} else if($r['total_tarif'] < $r['tarif_jatah']) {
															echo "Rp. ".number_format(0);
															$total_selisih = $total_selisih + (0);
														}
													?>
												</td>
											<?php } ?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
										<?php
											if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == NULL)) { ?>
												<tr>
													<td colspan="6">Total Ruangan</td>
													<td>Rp. <?php echo number_format($total_bayar,0);?></td>
												</tr>
											<?php
											} if($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) { ?>
												<tr>
													<td colspan="6">Total Selisih Ruangan</td>
													<td>Rp. <?php echo number_format($total_selisih,0);?></td>
												</tr>
											<?php
											} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) { ?>
												<tr>
													<td colspan="6">Total Jatah</td>
													<td>Rp. <?php echo number_format($total_jatah_kelas,0);?></td>
												</tr>
											<?php
											}
										?>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="tindakan" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example2" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Nama Ruang</th>
									  <th>Tgl Tindakan</th>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
									  		<th>Biaya Tindakan</th>
										<?php
										}
										?>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
									  		<th>Biaya Jatah Kelas</th>
										<?php
										}
									  ?>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { ?>
											<th>Biaya Jatah Kelas</th>
										<?php
										}
									  ?>
									  <th>Qty</th>
									  <?php
									  	if (($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
											<th>Biaya Selisih</th>
										<?php
										} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == NULL)) { ?>
											<th>Total</th>
										<?php
										} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
											<th>Total Jatah Kelas</th>
										<?php
										} else if ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1') { ?>
											<th>Total</th>
										<?php
										}
									  ?>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar = 0;
									$jatah_tindakan = 0;
									$selisih_tindakan = 0;
									$total_jatah = 0;
									if(!empty($list_tindakan_pasien)){
										foreach($list_tindakan_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; //if($r['nama_kel']!=''){ echo ' | <b>'.$r['nama_kel'].'</b>'; }?></td>
											<td><?php echo $r['pelaksana'] ; ?></td>
											<td><?php echo $r['nmruang'] ; ?></td>
											<td><?php
									  		echo date('d-m-Y',strtotime($r['tgl_layanan']));
											?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['tumuminap'],0) ; ?></td>
												<?php
												}
											?>
											<?php
												if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah'],0) ; ?></td>
													<?php $jatah_tindakan = $jatah_tindakan + ($r['tarif_jatah']);?>
												<?php
												}
											?>
											<?php
												if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_iks'],0) ; ?></td>
													<?php $jatah_tindakan = $jatah_tindakan + ($r['tarif_iks']);?>
												<?php
												}
											?>
											<td><?php echo $r['qtyyanri'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { 
													if(($r['tumuminap'] > $r['tarif_iks']) || ($r['tumuminap'] == $r['tarif_iks'])) { ?>
														<td>Rp. <?php echo number_format(($r['tumuminap']*$r['qtyyanri']) - ($r['tarif_iks']*$r['qtyyanri'])) ; ?></td>
														<?php $selisih_tindakan = $selisih_tindakan + (($r['tumuminap']*$r['qtyyanri']) - ($r['tarif_iks']*$r['qtyyanri']));?>
													<?php
													} else if($r['tumuminap'] < $r['tarif_iks']) { ?>
														<td>Rp. <?php echo number_format(0) ; ?></td>
														<?php $selisih_tindakan = $selisih_tindakan + (0);?>
													<?php
													}
												} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format(($r['tumuminap'])*$r['qtyyanri'],0) ; ?></td>
													<?php $total_bayar = $total_bayar + ($r['tumuminap'])*$r['qtyyanri'];?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format(($r['tarif_jatah'])*$r['qtyyanri'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_jatah'])*$r['qtyyanri'];?>
												<?php
												} else if ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1') { ?>
													<td>Rp. <?php echo number_format(($r['tarif_iks'])*$r['qtyyanri'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_iks'])*$r['qtyyanri'];?>
												<?php
												}
											?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<?php
												if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
												<tr>
													<td colspan="6">Total Selisih Tindakan</td>
													<td>Rp. <?php echo number_format($selisih_tindakan,0);?></td>
												</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Tindakan</td>
														<td>Rp. <?php echo number_format($total_bayar,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
													<tr>
														<td colspan="6">Total Jatah</td>
														<td>Rp. <?php echo number_format($total_jatah,0);?></td>
													</tr>
												<?php
												} else if ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1') { ?>
													<tr>
														<td colspan="6">Total Jatah</td>
														<td>Rp. <?php echo number_format($total_jatah,0);?></td>
													</tr>
												<?php
												}
											?>
										</table>
									</div>
								</div>
							</div>
							
							<div class="tab-pane" id="lab_pasien" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_lab_pasien)){
										echo form_open('lab/labcpengisianhasil/st_cetak_hasil_lab_rawat');
									?>
										<select id="no_lab" class="form-control" name="no_lab"  required>
											<?php 
												foreach($cetak_lab_pasien as $row){
													echo "<option value=".$row['no_lab']." selected>".$row['no_lab']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example4" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Lab</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
									  		<th>Harga Satuan</th>
										<?php
										}
										?>
									  <?php
									  	if((($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL)) { ?>
										  <th>Harga Jatah Kelas</th>
										<?php
										}
									  ?>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									$total_jatah = 0;
									$selisih_lab = 0;
									$jatah = 0;
									if(!empty($list_lab_pasien)){
										foreach($list_lab_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['no_lab'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['biaya_lab'],0) ; ?></td>
												<?php
												}
											?>
											<?php
												if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_jatah']); ?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_iks'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_iks']); ?>
												<?php
												}
											?>
											<td><?php echo $r['qty'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['biaya_lab']*$r['qty']) ; ?></td>
													<?php $total_bayar = $total_bayar + ($r['biaya_lab']*$r['qty']) ;?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) {
													if(($r['biaya_lab'] > $r['tarif_iks']) || ($r['biaya_lab'] == $r['tarif_iks'])) { ?>
														<td>Rp. <?php echo number_format(($r['biaya_lab']*$r['qty']) - ($total_jatah*$r['qty'])) ; ?></td>
														<?php $selisih_lab = $selisih_lab + (($r['biaya_lab']*$r['qty']) - ($total_jatah*$r['qty'])) ;?>
													<?php
													} else if($r['biaya_lab'] < $r['tarif_iks']) { ?>
														<td>Rp. <?php echo number_format(0) ; ?></td>
														<?php $selisih_lab = $selisih_lab + (0) ;?>
													<?php
													}
												} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah']*$r['qty']) ; ?></td>
													<?php $jatah = $jatah + ($r['tarif_jatah']*$r['qty']) ;?>
												<?php
												} else if($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1') { ?>
													<td>Rp. <?php echo number_format($r['tarif_iks']*$r['qty']) ; ?></td>
													<?php $jatah = $jatah + ($r['tarif_iks']*$r['qty']) ;?>
												<?php
												}
											?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>


								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<?php
												if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Laboratorium</td>
														<td>Rp. <?php echo number_format($total_bayar,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Selisih</td>
														<td>Rp. <?php echo number_format($selisih_lab,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) { ?>
													<tr>
														<td colspan="6">Total Jatah</td>
														<td>Rp. <?php echo number_format($jatah,0);?></td>
													</tr>
												<?php
												}
											?>
										</table>
									</div>
								</div>	
							</div>

							<div class="tab-pane" id="pa_pasien" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_pa_pasien)){
										echo form_open('pa/pacpengisianhasil/st_cetak_hasil_pa_rawat');
									?>
										<select id="no_pa" class="form-control" name="no_pa"  required>
											<?php 
												foreach($cetak_pa_pasien as $row){
													echo "<option value=".$row['no_pa']." selected>".$row['no_pa']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example5" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No PA</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_pa_pasien)){
										foreach($list_pa_pasien as $r){ ?>
										<tr>
											<td><?php echo $r['no_pa'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td>
											<?php 
											echo date('d-m-Y',strtotime($r['xupdate']));
											?>
											</td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_pa'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
										<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Patologi Anatomi</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="ok_pasien" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example9" style="table-layout: fixed;">
								  <thead>
									<tr>
									  	<th>No Ok</th>
									  	<th >Jadwal Operasi</th>
									  	<th>Jenis Pemeriksaan</th>
									  	<th>Operator</th>
										<?php
											if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
									  			<th >Total Pemeriksaan Kelas</th>
											<?php
											}
										?>
										<?php
											if((($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL)) { ?>
												<th>Total Jatah Kelas</th>
											<?php
											}
										?>
										<?php
										 if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
											<th>Total Selisih</th>
										<?php
										 }
										?>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									$selisih_operasi = 0;
									$total_jatah = 0;
									if(!empty($list_ok_pasien)){
										foreach($list_ok_pasien as $row){ ?>
										<tr>
											<td><?php echo $row['no_ok'] ; ?></td>
											<td><?php echo date('d-m-Y',strtotime($row['tgl_kunjungan'])); ?></td>
											<td><?php echo $row['jenis_tindakan'].' ('.$row['id_tindakan'].')' ; ?></td>
											<td>
												<?php
													echo 'Dokter : '.$row['dok_ok'].' ('.$row['id_dokter'].')';
													if($row['id_opr_anes']<>NULL)
													echo '<br>- Operator Anestesi: '.$row['nm_opr_anes'].' ('.$row['id_opr_anes'].')';
													if($row['id_dok_anes']<>NULL)
													echo '<br>- Dokter Anestesi: '.$row['dok_anes'].' ('.$row['id_dok_anes'].')';
													if($row['jns_anes']<>NULL)
													echo '<br>- Jenis Anestesi: '.$row['jns_anes'];
													if($row['id_dok_anak']<>NULL)
													echo '<br>- Dokter Anak: '.$row['dok_anak'].' ('.$row['id_dok_anak'].')';
												?> 
											</td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td><?php echo 'Rp '.number_format( $row['biaya_ok']*$r['qty'], 2 , ',' , '.' ); ?></td>
													<?php $total_bayar = $total_bayar + ($row['biaya_ok']*$r['qty']);?>
												<?php
												}
											?>
											<?php
											 if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == '1')) { ?>
											 	<td><?php echo 'Rp '.number_format( $row['tarif_jatah']*$row['qty'], 2 , ',' , '.' ); ?></td>
												 <?php $total_jatah = $total_jatah + ($row['tarif_jatah']*$r['qty']);?>
											<?php
											 } else if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { ?>
											 	<td><?php echo 'Rp '.number_format( $row['tarif_iks']*$row['qty'], 2 , ',' , '.' ); ?></td>
												 <?php $total_jatah = $total_jatah + ($row['tarif_iks']*$r['qty']);?>
											<?php
											 }
											?>
											<?php
												if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) {
													if(($row['biaya_ok'] > $row['tarif_iks']) || ($row['biaya_ok'] == $row['tarif_iks'])) { ?>
														<td><?php echo 'Rp '.number_format(($row['biaya_ok']*$r['qty'])-($row['tarif_iks']*$row['qty'])); ?></td>
														<?php $selisih_operasi = $selisih_operasi + (($row['biaya_ok']*$r['qty'])-($row['tarif_iks']*$row['qty'])); ?>
													<?php
													} else if($row['biaya_ok'] < $row['tarif_iks']) { ?>
														<td><?php echo 'Rp '.number_format(0); ?></td>
														<?php $selisih_operasi = $selisih_operasi + (0); ?>
													<?php
													}
												}
											?>
										</tr>
									<?php
										}
									}else{ ?>
									<tr>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<?php
												if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Selisih</td>
														<td>Rp. <?php echo number_format($selisih_operasi,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Bayar</td>
														<td>Rp. <?php echo number_format($total_bayar,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) { ?>
													<tr>
														<td colspan="6">Total Jatah</td>
														<td>Rp. <?php echo number_format($total_jatah,0);?></td>
													</tr>
												<?php
												}
											?>
										</table> 
									</div>
								</div>
							</div>

							<div class="tab-pane" id="radiologi" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_rad_pasien)){
										echo form_open('rad/radcpengisianhasil/st_cetak_hasil_rad_rawat');
									?>
										<select id="no_rad" class="form-control" name="no_rad"  required>
											<?php 
												foreach($cetak_rad_pasien as $row){
													echo "<option value=".$row['no_rad']." selected>".$row['no_rad']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example6" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Rad</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
									  		<th>Harga Satuan</th>
										<?php
										}
										?>
									  <?php
									  	if((($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) || (($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL))) { ?>
											<th>Harga Jatah Kelas</th>
										<?php
										}
									  ?>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									$total_jatah = 0;
									$selisih_rad = 0;
									$jatah = 0;
									if(!empty($list_radiologi)){
										foreach($list_radiologi as $r){ ?>
										<tr>
											<td><?php echo $r['no_rad'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['biaya_rad'],0) ; ?></td>
												<?php
												}
											?>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_jatah']); ?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_iks'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_iks']); ?>
												<?php
												}
											?>
											<td><?php echo $r['qty'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['biaya_rad']*$r['qty']) ; ?></td>
													<?php $total_bayar = $total_bayar + ($r['biaya_rad']*$r['qty']) ;?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { 
													if(($r['biaya_rad'] > $r['tarif_iks']) || ($r['biaya_rad'] == $r['tarif_iks'])) { ?>
														<td>Rp. <?php echo number_format(($r['biaya_rad']*$r['qty']) - ($total_jatah*$r['qty'])) ; ?></td>
														<?php $selisih_rad = $selisih_rad + (($r['biaya_rad']*$r['qty']) - ($total_jatah*$r['qty'])) ;?>
													<?php
													} else if($r['biaya_rad'] < $r['tarif_iks']) { ?>
														<td>Rp. <?php echo number_format(0) ; ?></td>
														<?php $selisih_rad = $selisih_rad + (0) ;?>
													<?php
													}
												} else if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah']*$r['qty']) ; ?></td>
													<?php $jatah = $jatah + ($r['tarif_jatah']*$r['qty']) ;?>
												<?php
												}
											?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Radiologi</td>
														<td>Rp. <?php echo number_format($total_bayar,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Selisih</td>
														<td>Rp. <?php echo number_format($selisih_rad,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) { ?>
													<tr>
														<td colspan="6">Total Jatah</td>
														<td>Rp. <?php echo number_format($jatah,0);?></td>
													</tr>
												<?php
												}
											?>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="elektromedik" role="tabpanel">
								<div class="form-inline" align="right">
									<div class="input-group">
									<?php
									if(!empty($cetak_em_pasien)){
										echo form_open('elektromedik/emcpengisianhasil/st_cetak_hasil_em_rawat');
									?>
										<select id="no_em" class="form-control" name="no_em"  required>
											<?php 
												foreach($cetak_em_pasien as $row){
													echo "<option value=".$row['no_em']." selected>".$row['no_em']."</option>";
												}
											?>
										</select>
										<span class="input-group-btn">
											<button type="submit" class="btn btn-primary">Cetak Hasil</button>
										</span>
								
									<?php 
										echo form_close();
									}else{
										echo "Hasil Pemeriksaan Belum Keluar";
									}
									?>	
									</div>
								</div>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example11" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Em</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <?php
									  	if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
									  		<th>Harga Satuan</th>
										<?php
										}
										?>
									  <?php
									  	if((($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) || (($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL))) { ?>
											<th>Harga Jatah kelas</th>
										<?php			
										}
									  ?>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									$total_jatah = 0;
									$selisih_em = 0;
									$jatah = 0;
									if(!empty($list_elektromedik)){
										foreach($list_elektromedik as $r){ ?>
										<tr>
											<td><?php echo $r['no_em'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['biaya_em'],0) ; ?></td>
												<?php
												}
											?>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_jatah']); ?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == NULL) || ($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_iks'],0) ; ?></td>
													<?php $total_jatah = $total_jatah + ($r['tarif_iks']); ?>
												<?php
												}
											?>
											<td><?php echo $r['qty'] ; ?></td>
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<td>Rp. <?php echo number_format($r['biaya_em']*$r['qty']) ; ?></td>
													<?php $total_bayar = $total_bayar + ($r['biaya_em']*$r['qty']) ;?>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) {
													if(($r['biaya_em'] > $r['tarif_iks']) || ($r['biaya_em'] == $r['tarif_iks'])) { ?>
														<td>Rp. <?php echo number_format(($r['biaya_em']*$r['qty']) - ($total_jatah*$r['qty'])) ; ?></td>
														<?php $selisih_em = $selisih_em + (($r['biaya_em']*$r['qty']) - ($total_jatah*$r['qty'])) ;?>
													<?php
													} else if($r['biaya_em'] < $r['tarif_iks']) { ?>
														<td>Rp. <?php echo number_format(0) ; ?></td>
														<?php $selisih_em = $selisih_em + (0) ;?>
													<?php
													}
												} else if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == '1')) { ?>
													<td>Rp. <?php echo number_format($r['tarif_jatah']*$r['qty']) ; ?></td>
													<?php $jatah = $jatah + ($r['tarif_jatah']*$r['qty']) ;?>
												<?php
												} else if($data_pasien[0]['carabayar'] == 'KERJASAMA' && $data_pasien[0]['titip'] == '1') { ?>
													<td>Rp. <?php echo number_format($r['tarif_iks']*$r['qty']) ; ?></td>
													<?php $jatah = $jatah + ($r['tarif_iks']*$r['qty']) ;?>
												<?php
												}
											?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<?php
												if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Elektromedik</td>
														<td>Rp. <?php echo number_format($total_bayar,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == NULL)) { ?>
													<tr>
														<td colspan="6">Total Selisih</td>
														<td>Rp. <?php echo number_format($selisih_em,0);?></td>
													</tr>
												<?php
												} else if(($data_pasien[0]['carabayar'] == 'BPJS' || $data_pasien[0]['carabayar'] == 'UMUM' || $data_pasien[0]['carabayar'] == 'KERJASAMA') && ($data_pasien[0]['titip'] == '1')) { ?>
													<tr>
														<td colspan="6">Total Jatah</td>
														<td>Rp. <?php echo number_format($jatah,0);?></td>
													</tr>
												<?php
												}
											?>
										</table>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="resep_pasien" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example7" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Resep</th>
									  <th>Nama Obat</th>
									  <th>Tgl Tindakan</th>
									  <th>Satuan Obat</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_resep_iri)){
										foreach($list_resep_iri as $r){ ?>
										<tr>
											<td><?php echo $r['no_resep'] ?></td>
											<td><?php echo $r['nama_obat'] ; ?></td>
											<td><?php 

									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));

											?></td>
											<td><?php echo $r['Satuan_obat'] ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Resep</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
								<!-- <a target="_blank" href="<?php //echo base_url() ;?>iri/ricstatus/cetak_detail_farmasi/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Cetak Detail"></a> -->
							</div>

							<!--<div class="tab-pane" id="tindakan_ird" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example8">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Biaya</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($list_tindakan_ird)){
										foreach($list_tindakan_ird as $r){ ?>
										<tr>
											<td><?php echo $r['nama_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_ird'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan IRD</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>-->

							<!-- <div class="tab-pane" id="poli_irj" role="tabpanel">
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example10" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Biaya</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar = 0;
									if(!empty($poli_irj)){
										foreach($poli_irj as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php 
											echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_tindakan'],0) ; ?></td>
											<td><?php echo $r['qtyind'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar = $total_bayar + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan Poli</td>
											  <td>Rp. <?php echo number_format($total_bayar,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div> -->
							
							<div class="tab-pane" id="poli_irj" role="tabpanel">
								<h2>Tindakan</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example12" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Tgl Tindakan</th>
									  <th>Biaya Tindakan</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
									$total_bayar_tindakan = 0;
									if(!empty($list_tindakan_ird)){
										foreach($list_tindakan_ird as $r){ ?>
										<tr>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td><?php
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td>Rp. <?php echo number_format($r['biaya_tindakan'],0) ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar_tindakan = $total_bayar_tindakan + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Tindakan IRD</td>
											  <td>Rp. <?php echo number_format($total_bayar_tindakan,0);?></td>
											</tr>
										</table>
									</div>
								</div>
								
								<hr>

								<h2>Operasi</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example13" style="table-layout: fixed;">
								  <thead>
									<tr>
									  	<th>No Ok</th>
									  	<th >Jadwal Operasi</th>
									  	<th>Jenis Pemeriksaan</th>
									  	<th>Operator</th>
									  	<th >Total Pemeriksaan</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_ok = 0;
									if(!empty($list_ok_ird)){
										foreach($list_ok_ird as $row){ ?>
										<tr>
											<td><?php echo $row['no_ok'] ; ?></td>
											<td><?php echo date('d-m-Y',strtotime($row['tgl_kunjungan'])); ?></td>
											<td><?php echo $row['jenis_tindakan'].' ('.$row['id_tindakan'].')' ; ?></td>
											<td>
												<?php
													echo 'Dokter : '.$row['nm_dokter'].' ('.$row['id_dokter'].')';
													if($row['id_opr_anes']<>NULL)
													echo '<br>- Operator Anestesi: '.$row['nm_opr_anes'].' ('.$row['id_opr_anes'].')';
													if($row['id_dok_anes']<>NULL)
													echo '<br>- Dokter Anestesi: '.$row['nm_dok_anes'].' ('.$row['id_dok_anes'].')';
													if($row['jns_anes']<>NULL)
													echo '<br>- Jenis Anestesi: '.$row['jns_anes'];
													if($row['id_dok_anak']<>NULL)
													echo '<br>- Dokter Anak: '.$row['nm_dok_anak'].' ('.$row['id_dok_anak'].')';
												?> 
											</td>
											<td><?php echo 'Rp '.number_format( $row['vtot'], 2 , ',' , '.' ); ?></td>
											<?php $total_bayar_ok = $total_bayar_ok + $row['vtot'];?>
										</tr>
									<?php
										}
									}else{ ?>
									<tr>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
											<td>Tidak Ada Operasi</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Biaya Operasi</td>
											  <td>Rp. <?php echo number_format($total_bayar_ok,0);?></td>
											</tr>
										</table> 
									</div>
								</div>

								<hr>

								<h2>Radiologi</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example14" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Rad</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_rad = 0;
									if(!empty($list_rad_ird)){
										foreach($list_rad_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_rad'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_rad'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot']) ; ?></td>
											<?php $total_bayar_rad = $total_bayar_rad + $r['vtot'] ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Radiologi</td>
											  <td>Rp. <?php echo number_format($total_bayar_rad,0);?></td>
											</tr>
										</table>
									</div>
								</div>

								<hr>

								<!-- <h2>Elektromedik</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example15" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Em</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total Harga</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_em = 0;
									if(!empty($list_em_ird)){
										foreach($list_em_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_em'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php 
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_em'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot']) ; ?></td>
											<?php $total_bayar_em = $total_bayar_em + $r['vtot'] ;?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								
								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Elektromedik</td>
											  <td>Rp. <?php echo number_format($total_bayar_em,0);?></td>
											</tr>
										</table>
									</div>
								</div> -->

								<hr>

								<h2>Laboratorium</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example16" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Lab</th>
									  <th>Jenis Tindakan</th>
									  <th>Tgl Tindakan</th>
									  <th>Dokter</th>
									  <th>Harga Satuan</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_lab = 0;
									if(!empty($list_lab_ird)){
										foreach($list_lab_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_lab'] ; ?></td>
											<td><?php echo $r['jenis_tindakan'] ; ?></td>
											<td><?php
									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
											?></td>
											<td><?php echo $r['nm_dokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['biaya_lab'],0) ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar_lab = $total_bayar_lab + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>


								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Laboratorium</td>
											  <td>Rp. <?php echo number_format($total_bayar_lab,0);?></td>
											</tr>
										</table>
									</div>
								</div>

								<hr>

								<h2>Resep</h2>
								<table width="100%" class="table table-hover table-striped table-bordered data-table" id="dataTables-example17" style="table-layout: fixed;">
								  <thead>
									<tr>
									  <th>No Resep</th>
									  <th>Nama Obat</th>
									  <th>Tgl Tindakan</th>
									  <th>Satuan Obat</th>
									  <th>Qty</th>
									  <th>Total</th>
									</tr>
								  </thead>
								  <tbody>
								  	<?php
								  	$total_bayar_resep = 0;
									if(!empty($list_resep_ird)){
										foreach($list_resep_ird as $r){ ?>
										<tr>
											<td><?php echo $r['no_resep'] ; ?></td>
											<td><?php echo $r['nama_obat'] ; ?></td>
											<td><?php 

									  		echo date('d-m-Y',strtotime($r['tgl_kunjungan']));

											?></td>
											<td><?php echo $r['Satuan_obat'] ; ?></td>
											<td><?php echo $r['qty'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'],0) ; ?></td>
											<?php $total_bayar_resep = $total_bayar_resep + $r['vtot'];?>
										</tr>
										<?php
										}
									}else{ ?>
									<tr>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
											<td>Data Kosong</td>
										</tr>
									<?php
									}
									?>
								  </tbody>
								</table>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Resep</td>
											  <td>Rp. <?php echo number_format($total_bayar_resep,0);?></td>
											</tr>
										</table>
									</div>
								</div>

								<?php 
									$total_bayar_ird = 0 ;
									$total_bayar_ird = $total_bayar_ird + $total_bayar_tindakan + $total_bayar_rad + $total_bayar_em + $total_bayar_lab + $total_bayar_ok + $total_bayar_resep;
								?>

								<hr>

								<div class="form-inline" align="right">
									<div class="input-group">
										<table width="100%" class="table table-hover table-striped table-bordered">
											<tr>
											  <td colspan="6">Total Semua Biaya Poli IGD</td>
											  <td>Rp. <?php echo number_format($total_bayar_ird,0);?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>

						</div>
						
						</div>
					</div>
					<!-- /Tabs -->
					
				
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	$(document).ready(function() {
	    $('#dataTables-example').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example2').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example4').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example5').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example6').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example7').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example8').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example9').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example10').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example11').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
        	]
        });
	    $('#dataTables-example12').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength'
        	]
        });
	    $('#dataTables-example13').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength'
        	]
        });
	    $('#dataTables-example14').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength'
        	]
        });
	    $('#dataTables-example15').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength'
        	]
        });
	    $('#dataTables-example16').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength'
        	]
        });
	    $('#dataTables-example17').DataTable({
	    	dom : 'Bfrtip',
        	buttons: [
        	'pageLength'
        	]
        });
	});
</script>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
