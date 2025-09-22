    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<?php //echo json_encode($data_pasien); ?>
<script type="text/javascript">
	$(function() {
	 	$('#table_kunjungan_rjrd,#table_kunjungan_iri,#table_farmasi,#table_laboratorium,#table_diagnosis,#table_operasi').DataTable( {
		    "language": {
		      "emptyTable": "Data tidak tersedia."
		    }
		});
	});
	 
</script>
	<div class="row">
		<?php 
			if($data_pasien->foto == "") $foto = "unknown.png"; 
				else $foto = $data_pasien->foto;
 
			// Tanggal Lahir
			$birthday = $data_pasien->tgl_lahir;
			
			// Convert Ke Date Time
			$biday = new DateTime($birthday);
			$today = new DateTime();
			
			$diff = $today->diff($biday);
			
			// Display
			// echo "Tanggal Lahir: ". date('d M Y', strtotime($birthday)) .'<br />';
			// echo "Umur: ". $diff->y ." Tahun";
			// echo "Bulan: ".$diff->m.'<br />';
			// echo "Hari: ".$diff->d.'<br />';
			$tahun =  $diff->y;
			$bulan =  $diff->m;
			$hari =  $diff->d;
 
		?>	
		<div class="col-md-12 col-xs-12 col-lg-12">
			
          <div class="card">
            <div class="card-block">
                <center class="m-t-30"> <img src="<?php echo site_url("upload/photo/unknown.png");?>" class="img-circle" width="100">
                    <h4 class="card-title m-t-10"><?php echo strtoupper($data_pasien->nama).' (No. RM : '.strtoupper($data_pasien->no_cm).')';?></h4>
                    <h6 class="card-subtitle"><?php echo $data_pasien->tmpt_lahir.', '.date(' d-m-Y',strtotime($data_pasien->tgl_lahir)).' ('.$tahun.' Tahun '.$bulan.' bulan '.$hari.' hari)';?></h6>
                </center>
            </div>
            <div><hr></div>
            <div class="card-block">
              	<div class="row">
	                <div class="col-sm-12 border-right">
	                	<div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">   
	                        <div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_pasien" aria-expanded="false" aria-controls="collapse_pasien">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Pasien</h5> 
		                            </div>  
	                        	</a>
	                            <div id="collapse_pasien" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="row">
											<div class="col-sm-6">
												<?php
													$no_medrec=$data_pasien->no_medrec;
													if($data_pasien->foto!=''){
														$foto=$data_pasien->foto;
													}else $foto="unknown.png";
												?>
													<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_cm" readonly>
													<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="no_cm">No MR</p>
														<div class="col-sm-8">
															<input type="text" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cm_baru" readonly>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="tgl_daftar">Tanggal Daftar</p>
														<div class="col-sm-8">
															<input type="text" class="form-control" value="<?php echo $data_pasien->tgl_daftar;?>" name="tgl_daftar" readonly>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->nama;?>" name="nama" required>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
														<div class="col-sm-8">
															<?php 
																if($data_pasien->sex=='L'){
																	echo '<input disabled type="text" class="form-control" value="Laki-laki" name="" required>';
																}else{
																	echo '<input disabled type="text" class="form-control" value="Perempuan" name="" required>';
																}
															?>
														</div>
													</div>
													
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" >Pilih Identitas</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)">
																		<option value="">-Pilih Identitas-</option>
																		<option <?php if($data_pasien->jenis_identitas=='KTP') echo 'selected';?> value="KTP">KTP</option>
																		<option <?php if($data_pasien->jenis_identitas=='SIM') echo 'selected';?> value="SIM">SIM</option>
																		<option <?php if($data_pasien->jenis_identitas=='PASPOR') echo 'selected';?> value="PASPOR">Paspor</option>
																		<option <?php if($data_pasien->jenis_identitas=='KTM') echo 'selected';?> value="KTM">KTM</option>
																		<option <?php if($data_pasien->jenis_identitas=='NIK') echo 'selected';?> value="NIK">NIK</option>
																		<option <?php if($data_pasien->jenis_identitas=='DLL') echo 'selected';?> value="DLL">Lainnya</option>
																	</select>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" >No. Identitas</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->no_identitas;?>" name="no_identitas"  id="no_identitas" onchange="cek_no_identitas(this.value,'<?php echo $data_pasien->no_identitas; ?>')">
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu Keluarga</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->no_kk;?>" name="no_kk" id="no_kk">
														</div>
													</div>			
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->no_kartu;?>" name="no_kartu" id="no_kartu_bpjs" onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')">
														</div>
													</div>
												
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control"  value="<?php echo $data_pasien->tmpt_lahir;?>" name="tmpt_lahir" >
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="tgl_lahir">Tanggal Lahir *</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control date_picker" value="<?php echo date('Y-m-d',strtotime($data_pasien->tgl_lahir));?>" name="tgl_lahir" required>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="agama">Agama</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled class="form-control" style="width: 100%" name="agama">
																		<option value="">-Pilih Agama-</option>
																		<option <?php if($data_pasien->agama=='ISLAM') echo 'selected';?> value="ISLAM">Islam</option>
																		<option <?php if($data_pasien->agama=='KATOLIK') echo 'selected';?> value="KATOLIK">Katolik</option>
																		<option <?php if($data_pasien->agama=='PROTESTAN') echo 'selected';?> value="PROTESTAN">Protestan</option>
																		<option <?php if($data_pasien->agama=='BUDHA') echo 'selected';?> value="BUDHA">Budha</option>
																		<option <?php if($data_pasien->agama=='HINDU') echo 'selected';?> value="HINDU">Hindu</option>
																		<option <?php if($data_pasien->agama=='KONGHUCU') echo 'selected';?> value="KONGHUCU">Konghucu</option>
																	</select>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="status">Status</p>
														<div class="col-sm-8">
															<?php 
																if($data_pasien->status=='B'){
																	echo '<input disabled type="text" class="form-control" value="Belum Menikah" name="" required>';
																}else if($data_pasien->status=='K'){
																	echo '<input disabled type="text" class="form-control" value="Sudah Menikah" name="" required>';
																}else if ($data_pasien->status=='C'){
																	echo '<input disabled type="text" class="form-control" value="Cerai" name="" required>';
																}else{
																	echo '<input disabled type="text" class="form-control" value="" name="" required>';
																}
															?>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
														<div class="col-sm-8">
															<div class="form-inline">
																<select disabled class="form-control" style="width: 100%" name="goldarah">
																	<option value="">-Pilih Golongan Darah-</option>
																	<option <?php if($data_pasien->goldarah=='A+') echo 'selected';?> value="A+">A+</option>
																	<option <?php if($data_pasien->goldarah=='A-') echo 'selected';?> value="A-">A-</option>
																	<option <?php if($data_pasien->goldarah=='B+') echo 'selected';?> value="B+">B+</option>
																	<option <?php if($data_pasien->goldarah=='B-') echo 'selected';?> value="B-">B-</option>
																	<option <?php if($data_pasien->goldarah=='AB+') echo 'selected';?> value="AB+">AB+</option>
																	<option <?php if($data_pasien->goldarah=='AB-') echo 'selected';?> value="AB-">AB-</option>
																	<option <?php if($data_pasien->goldarah=='O+') echo 'selected';?> value="O+">O+</option>
																	<option <?php if($data_pasien->goldarah=='O-') echo 'selected';?> value="O-">O-</option>
																</select>
															</div>
														</div>
													</div>
											</div><!-- end div col-sm-6-->

											<div class="col-sm-6">
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="wnegara">Kewarganegaraan</p>
														<div class="col-sm-8">
															<div class="form-inline">
																<select disabled class="form-control" style="width: 100%" name="wnegara">
																	<?php if($data_pasien->wnegara=='WNA'){
																		echo '<option value="WNI" >WNI</option><option value="WNA" selected>WNA</option>';
																	}else{
																		echo '<option value="WNI" selected>WNI</option><option value="WNA" >WNA</option>';
																	}
																	?>
																</select>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="alamat">Alamat *</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->alamat;?>" name="alamat" required>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="rt_rw">RT - RW</p>
														<div class="col-sm-8">
															<input disabled type="text" size="4" class="form-control" value="<?php echo 'Rt. '. $data_pasien->rt.' Rw.'.$data_pasien->rw;?>" name="rt">
														</div>
													</div>
													<div class="form-group row">
													<!--- -->
														<p class="col-sm-3 form-control-label" id="lbl_provinsi">Provinsi</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled id="prop" class="form-control select2" style="width: 100%" onchange="ajaxkota(this.value)">
																		<option value="">-Pilih Provinsi-</option>
																		<?php 
																		foreach($prop as $row1){
																			echo '<option '; if($data_pasien->id_provinsi==$row1->id) echo 'selected '; echo 'value="'.$row1->id.'-'.$row1->nama.'">'.$row1->nama.'</option>';
																		}
																		?>
																	</select>
																
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="lbl_kotakabupaten">Kota/Kabupaten</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled id="kota" class="form-control select2" style="width: 100%" onchange="ajaxkec(this.value)">
																		<?php 
																		echo '<option value="'.$data_pasien->id_kotakabupaten.'-'.$data_pasien->kotakabupaten.'">'.$data_pasien->kotakabupaten.'</option>';?>
																		<option value="">-Pilih Kota/Kabupaten-</option>
																	</select>
																
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="lbl_kecamatan">Kecamatan</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled id="kec" class="form-control select2" style="width: 100%" onchange="ajaxkel(this.value)">
																		<?php echo '<option value="'.$data_pasien->id_kecamatan.'-'.$data_pasien->kecamatan.'">'.$data_pasien->kecamatan.'</option>';?>
																		<option value="">-Pilih Kecamatan-</option>
																	</select>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="lbl_kelurahandesa">Kelurahan</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled id="kel" class="form-control select2" style="width: 100%" onchange="setkel(this.value)">
																		<?php echo '<option value="'.$data_pasien->id_kelurahandesa.'-'.$data_pasien->kelurahandesa.'">'.$data_pasien->kelurahandesa.'</option>';?>
																		<option value="">-Pilih Kelurahan/Desa-</option>
																	</select>
																
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="kodepos">Kode Pos</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->kodepos;?>" name="kodepos">
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
														<div class="col-sm-8">
															<div class="form-inline">
																	<select disabled class="form-control" style="width: 100%" name="pendidikan">
																		<option value="">-Pilih Pendidikan Terakhir-</option>
																		<option <?php if($data_pasien->pendidikan=='SD') echo 'selected';?> value="SD">SD</option>
																		<option <?php if($data_pasien->pendidikan=='SMP') echo 'selected';?> value="SMP">SMP</option>
																		<option <?php if($data_pasien->pendidikan=='SMA') echo 'selected';?> value="SMA">SMA</option>
																		<option <?php if($data_pasien->pendidikan=='D1') echo 'selected';?> value="D1">D1</option>
																		<option <?php if($data_pasien->pendidikan=='D2') echo 'selected';?> value="D2">D2</option>
																		<option <?php if($data_pasien->pendidikan=='D3') echo 'selected';?> value="D3">D3</option>
																		<option <?php if($data_pasien->pendidikan=='D4') echo 'selected';?> value="D4">D4</option>
																		<option <?php if($data_pasien->pendidikan=='S1') echo 'selected';?> value="S1">S1</option>
																		<option <?php if($data_pasien->pendidikan=='S2') echo 'selected';?> value="S2">S2</option>
																		<option <?php if($data_pasien->pendidikan=='S3') echo 'selected';?> value="S3">S3</option>
																	</select>
															</div>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
														<div class="col-sm-8">
															<select disabled class="form-control" style="width: 100%" name="pekerjaan">
																		<option value="">-Pilih Pekerjaan Terakhir-</option>
																		<option <?php if($data_pasien->pekerjaan=='SWASTA') echo 'selected';?> value="SWASTA">SWASTA</option>
																		<option <?php if($data_pasien->pekerjaan=='MAHASISWA') echo 'selected';?> value="MAHASISWA">MAHASISWA</option>			
																		<option <?php if($data_pasien->pekerjaan=='PELAJAR') echo 'selected';?> value="PELAJAR">PELAJAR</option>
																		<option <?php if($data_pasien->pekerjaan=='PNS') echo 'selected';?> value="PNS">PNS</option>									
																		<option <?php if($data_pasien->pekerjaan=='TIDAK ADA') echo 'selected';?> value="TIDAK ADA">TIDAK ADA</option>
																		<option <?php if($data_pasien->pekerjaan=='LAINNYA') echo 'selected';?> value="LAINNYA">LAINNYA</option>
																	</select>
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->no_telp;?>" maxlength="12" name="no_telp">
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="no_hp">No. HP</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->no_hp;?>" maxlength="12" name="no_hp">
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor">
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="email">Email</p>
														<div class="col-sm-8">
															<input disabled type="email" class="form-control" value="<?php echo $data_pasien->email;?>" name="email">
														</div>
													</div>
													<div class="form-group row">
														<p class="col-sm-3 form-control-label" id="nama_ibu_istri">Nama Ibu Kandung</p>
														<div class="col-sm-8">
															<input disabled type="text" class="form-control" value="<?php echo $data_pasien->nm_ibu_istri;?>" name="nm_ibu_istri">
														</div>
													</div>
											</div><!-- end div col-sm-6-->
										</div><!-- row -->
	                                </div>
	                            </div>
	                    	</div> <!-- Data Pasien -->
	                    	<div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#kunjungan_rjrd" aria-expanded="false" aria-controls="kunjungan_rjrd">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Kunjungan Rawat Jalan / Darurat <span class="label label-warning p-t-5 pull-right"><?php echo $count_kunj_jalan.' Kunjungan ';?></span></h5> 
		 
		                            </div>  
	                        	</a>
	                            <div id="kunjungan_rjrd" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="table-responsive m-t-0">
		                                	<table class="display nowrap table table-hover" cellspacing="0" id="table_kunjungan_rjrd">
						 						<thead>
													<tr>
														<th align="center">No Register</th>
														<th align="center">Tgl Kunjungan</th>
														<th align="center">Poli</th>
														<th align="center">Dokter</th>
														<th align="center">Diagnosa</th>
														<th align="center">Aksi</th>
													</tr>
						                        </thead>	                                		
												<tbody>
													<?php
														foreach ($kunj_jalan as $row) {
															echo "<tr>
																	<td>".$row->no_register."</td>
																	<td>".date('d-m-Y | H:i',strtotime($row->tgl_kunjungan))."</td>
																	<td>".$row->nm_poli."</td>
																	<td>".$row->nm_dokter."</td>
																	<td>".$row->diagnosa."</td>
																	<td><a href='".site_url('irj/rjcpelayanan/pelayanan_tindakan_view/'.$row->id_poli.'/'.$row->no_register)."' class='btn btn-primary btn-sm' style='width:85px;' target='_blank'>View Details</a></td>
																</tr>";
														}
													?>
												</tbody>
											</table>
										</div>

	                                </div>
	                            </div>
	                    	</div> <!-- Data Kunjungan Rawat Jalan / Darurat -->
	                    	<div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#kunjungan_iri" aria-expanded="false" aria-controls="kunjungan_iri">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Kunjungan Rawat Inap<span class="label label-warning p-t-5 pull-right"><?php echo $count_kunj_inap.' Kunjungan ';?></span></h5> 
		 
		                            </div>  
	                        	</a>
	                            <div id="kunjungan_iri" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="table-responsive m-t-0">
											<table class="display nowrap table table-hover" cellspacing="0" id="table_kunjungan_iri">
												<thead>
													<tr>
														<th align="center">No Register</th>
														<th align="center">Tgl Kunjungan</th>
														<th align="center">Ruangan</th>
														<th align="center">Dokter</th>
														<th align="center">Diagnosa</th>
														<th align="center">Aksi</th>
													</tr>
						                        </thead>	
												<tbody>
													<?php
														foreach ($kunj_inap as $row) {
															echo "<tr>
																	<td>".$row->no_ipd."</td>
																	<td>".date('d-m-Y',strtotime($row->tgl_masuk))."</td>
																	<td>".$row->nmruang."</td>
																	<td>".$row->dokter."</td>
																	<td>".$row->nm_diagnosa."</td>
																	<td><a href='".site_url('iri/ricstatus/index/'.$row->no_ipd.'/1')."' class='btn btn-primary btn-sm' style='width:85px;' target='_blank'>View Details</a></td>
																</tr>";
														}
													?>
												</tbody>
											</table>
										</div>

	                                </div>
	                            </div>
	                    	</div> <!-- Data Kunjungan Rawat Inap -->
	                    	<div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_farmasi" aria-expanded="false" aria-controls="collapse_farmasi">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Farmasi<span class="label label-warning p-t-5 pull-right"><?php echo $count_data_farmasi.' Kunjungan ';?></span></h5> 
		 
		                            </div>  
	                        	</a>
	                            <div id="collapse_farmasi" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="table-responsive m-t-0">
											<table class="display nowrap table table-hover" cellspacing="0" id="table_farmasi">
												<thead>
													<tr>
														<th align="center">No Register</th>
														<th align="center">Tgl Kunjungan</th>
														<th align="center">Ruangan</th>
														<th align="center">Item Obat</th>
														<th align="center">Qty</th>
													</tr>
						                        </thead>	
												<tbody>
													<?php
														$vtot=0;
														foreach ($data_farmasi as $row) {
															$vtot=$vtot+$row->qty;
															echo "<tr>
																	<td>".$row->no_register."</td>
																	<td>".date('d-m-Y',strtotime($row->tgl_kunjungan))."</td>
																	<td>".$row->nmruang."</td>
																	<td>".$row->nama_obat."</td>
																	<td>".$row->qty."</td>
																</tr>";
														}
													?>
												</tbody>
											</table>
											<h5 align="center">Total : <?php echo $vtot;?></h5>
										</div>

	                                </div>
	                            </div>
	                    	</div> <!-- Data Farmasi -->
	                    	<div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_laboratorium" aria-expanded="false" aria-controls="collapse_laboratorium">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Laboratorium<span class="label label-warning p-t-5 pull-right"><?php echo $count_data_lab.' Kunjungan ';?></span></h5> 
		 
		                            </div>  
	                        	</a>
	                            <div id="collapse_laboratorium" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="table-responsive m-t-0">
											<table class="display nowrap table table-hover" cellspacing="0" id="table_laboratorium">
												<thead>
													<tr>
														<th align="center">No Register</th>
														<th align="center">Tgl Kunjungan</th>
														<th align="center">Ruangan</th>
														<th align="center">Pemeriksaan</th>
														<th align="center">Qty</th>
													</tr>
						                        </thead>
												<tbody>
													<?php
														$vtot=0;
														foreach ($data_lab as $row) {
															$vtot=$vtot+$row->qty;
															echo "<tr>
																	<td>".$row->no_register."</td>
																	<td>".date('d-m-Y',strtotime($row->tgl_kunjungan))."</td>
																	<td>".$row->nmruang."</td>
																	<td>".$row->jenis_tindakan."</td>
																	<td>".$row->qty."</td>
																</tr>";
														}
													?>
												</tbody>
											</table>
											<h5 align="center">Total : <?php echo $vtot;?></h5>
										</div>

	                                </div>
	                            </div>
	                    	</div> <!-- Data Laboratorium -->
	                    	<div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_diagnosis" aria-expanded="false" aria-controls="collapse_diagnosis">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Diagnosis<span class="label label-warning p-t-5 pull-right"><?php echo $count_data_rad.' Kunjungan ';?></span></h5> 
		 
		                            </div>  
	                        	</a>
	                            <div id="collapse_diagnosis" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="table-responsive m-t-0">
											<table class="display nowrap table table-hover" cellspacing="0" id="table_diagnosis">
												<thead>
													<tr>
														<th align="center">No Register</th>
														<th align="center">Tgl Kunjungan</th>
														<th align="center">Ruangan</th>
														<th align="center">Pemeriksaan</th>
														<th align="center">Qty</th>
													</tr>
						                        </thead>
												<tbody>
													<?php
														$vtot=0;
														foreach ($data_rad as $row) {
															$vtot=$vtot+$row->qty;
															echo "<tr>
																	<td>".$row->no_register."</td>
																	<td>".date('d-m-Y',strtotime($row->tgl_kunjungan))."</td>
																	<td>".$row->nmruang."</td>
																	<td>".$row->jenis_tindakan."</td>
																	<td>".$row->qty."</td>
																</tr>";
														}
													?>
												</tbody>
											</table>
											<h5 align="center">Total : <?php echo $vtot;?></h5>
										</div>

	                                </div>
	                            </div>
	                    	</div> <!-- Data Diagnosis -->
	                    	<div class="card card-outline-info">
	                        	<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_operasi" aria-expanded="false" aria-controls="collapse_operasi">
		                            <div class="card-header" role="tab">
		                                <h5 class="mb-0 text-white">Data Operasi<span class="label label-warning p-t-5 pull-right"><?php echo $count_data_ok.' Kunjungan ';?></span></h5> 
		 
		                            </div>  
	                        	</a>
	                            <div id="collapse_operasi" class="collapse" role="tabpanel" aria-labelledby="headingThree">
	                                <div class="card-block">
	                                	<div class="table-responsive m-t-0">
											<table class="display nowrap table table-hover" cellspacing="0" id="table_operasi">
												<thead>
													<tr>
														<th align="center">No Register</th>
														<th align="center">Tgl Kunjungan</th>
														<th align="center">Ruangan</th>
														<th align="center">Pemeriksaan</th>
														<th align="center">Qty</th>
													</tr>
						                        </thead>
												<tbody>
													<?php
														$vtot=0;
														foreach ($data_ok as $row) {
															$vtot=$vtot+$row->qty;
															echo "<tr>
																	<td>".$row->no_register."</td>
																	<td>".date('d-m-Y',strtotime($row->tgl_kunjungan))."</td>
																	<td>".$row->nmruang."</td>
																	<td>".$row->jenis_tindakan."</td>
																	<td>".$row->qty."</td>
																</tr>";
														}
													?>
												</tbody>
											</table>
											<h5 align="center">Total : <?php echo $vtot;?></h5>
										</div>

	                                </div>
	                            </div>
	                    	</div> <!-- Data Operasi -->
	                    </div> <!-- accordion --> 
	                </div>
              	</div> <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->
        </div>
	</div>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 