<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type='text/javascript'>

	$(document).ready(function() {
       	$('#jadwal_operasi').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});
	    $("#jam_jadwal_operasi").timepicker({
		    showInputs: false,
		    showMeridian: false
	    });
	    $('#tabel_tindakan').DataTable({
	    	"language": {
		      "emptyTable": "Tidak Ada Operasi."
		    },
		    "columnDefs": [{ 
		        "orderable": false,
		        "targets": 5 // column index 
		    }]
	    });
		$("#biaya_ok").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});
	});
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_ok').val(data);
				$('#biaya_ok_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function set_total() {
		var total = $("#biaya_ok").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_ok)
	{
	  if(confirm('Are you sure delete this data?'))
	  {
	    // ajax delete data to database
	   	$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_ok,
	        success: function(data)
	        {
	           //if success reload ajax table
	          window.location.reload();
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	        }
	    });
	  }
	}


</script>
	<?php include('okvdatapasien.php');?>
		<div class="row">
		    <div class="col-sm-12">
		        <div class="ribbon-wrapper card">
		            <div class="ribbon ribbon-info">
		            	Daftar Pemeriksaan
		            </div>
		            
					<div class="ribbon-content">
						<div class="p-20">
						<?php echo form_open('ok/okcdaftar/insert_pemeriksaan'); ?>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-md-6">
													<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required>
														<option value="" disabled selected="">-- Pilih Tindakan --</option>
														<?php 
															foreach($tindakan as $row){
																echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
															}
														?>
													</select>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Dokter 1</p>
									<div class="col-md-6">
												<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter1"  required>
													<option value="" disabled selected="">-- Pilih Dokter 1 --</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter2">Dokter 2</p>
									<div class="col-md-6">
												<select id="id_dokter2" class="form-control js-example-basic-single" name="id_dokter2">
													<option value="" selected="">-- Pilih Dokter 2 --</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Dokter Anastesi</p>
									<div class="col-md-6">
												<select id="id_dok_anes" class="form-control js-example-basic-single" name="id_dok_anes" >
													<option value="" selected="">-- Pilih Dokter Anastesi --</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Jenis Anastesi</p>
									<div class="col-sm-6">
												<input type="text" class="form-control" name="jns_anes" id="jns_anes">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Dokter Anak</p>
									<div class="col-sm-9">
										<div class="form-inline">
											<div class="form-group">
												<select id="id_dok_anak" class="form-control js-example-basic-single" name="id_dok_anak" >
													<option value="" selected="">-- Pilih Dokter Anak --</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Tanggal Operasi</p>
									<div class="col-sm-9">
											<div class="form-group row">
												<div class="input-group date col-sm-4">
		                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                                            <input type="text" id="jadwal_operasi" class="form-control" name="jadwal_operasi" required="">
                                        		</div>
                                        		<div class="input-group bootstrap-timepicker col-sm-4">
		                                            <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
		                                            <input type="text" id="jam_jadwal_operasi" class="form-control" placeholder="Jam Operasi" name="jam_jadwal_operasi" required="">
                                        		</div>
								            <!-- <div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
								                    <input type='text' class="form-control" />
								                    <span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
								                </div>
								            </div> -->
											</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_biaya_periksa">Biaya Pemeriksaan</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">Rp</span>
											<input type="text" class="form-control" value="0.00" name="biaya_ok" id="biaya_ok" readonly>
											<input type="hidden" class="form-control" value="" name="biaya_ok_hide" id="biaya_ok_hide">
										</div>
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_qty">Qtyind</p>
									<div class="col-sm-3 col-md-2">
										<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)" value="0">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon1">Rp</span>
											<input type="text" class="form-control" name="vtot" id="vtot" value="0.00" readonly>
											<input type="hidden" class="form-control" value="" name="vtot_hide" id="vtot_hide">
										</div>
									</div>
								</div>
								
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									
									<div class="form-group row">
										<div class="offset-sm-3 col-sm-9">
											<button type="reset" class="btn btn-danger">Reset</button>
											<button type="submit" class="btn btn-primary">Simpan</button>
										</div>										
									</div>
							<?php echo form_close();?>
								<br>
									<div class="table-responsive">
										<table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
											<thead>
												<tr>
												  	<th>No</th>
												  	<th width="15%">Jadwal Operasi</th>
												  	<th>Jenis Pemeriksaan</th>
												  	<th>Operator</th>
												  	<!-- <th>Dokter</th>
												  	<th>Operator Anestesi</th>
												  	<th>Dokter Anestesi</th>
												  	<th>Jenis Anestesi</th>
												  	<th>Dokter Anak</th> -->
												  	<th width="10%">Total Pemeriksaan</th>
												  	<th width="5%" class="text-center">Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$i=1;
														foreach($data_pemeriksaan as $row){
														
													?>
														<tr>
															<td><?php echo $i++ ; ?></td>
															<td><?php echo $row->tgl_operasi ; ?></td>
															<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
															<!-- <td><?php echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td>
															<td><?php echo $row->nm_opr_anes.' ('.$row->id_opr_anes.')' ; ?></td>
															<td><?php echo $row->nm_dok_anes.' ('.$row->id_dok_anes.')' ; ?></td>
															<td><?php echo $row->jns_anes ; ?></td>
															<td><?php echo $row->nm_dok_anak.' ('.$row->id_dok_anak.')' ; ?></td> -->
															<td>
																<?php
																	echo 'Dokter 1 : '.$row->nm_dokter.' ('.$row->id_dokter.')';
																	if($row->id_dokter2<>NULL)
																	echo '<br>Dokter 2 : '.$row->nm_dokter2.' ('.$row->id_dokter2.')';
																	if($row->id_dok_anes<>NULL)
																	echo '<br>Dokter Anestesi: '.$row->nm_dok_anes.' ('.$row->id_dok_anes.')';
																	if($row->jns_anes<>NULL)
																	echo '<br>Jenis Anestesi: '.$row->jns_anes;
																	if($row->id_dok_anak<>NULL)
																	echo '<br>Dokter Anak: '.$row->nm_dok_anak.' ('.$row->id_dok_anak.')';
																?> 

															</td>


															<td><?php echo 'Rp '.number_format( $row->vtot, 2 , ',' , '.' ); ?></td>
															<td>
																<button type="button" class="btn btn-danger btn-sm" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_ok ; ?>)"><i class="fa fa-trash"></i> Hapus</button>
															</td>
														</tr>
													<?php
														}
													?>
											</tbody>
										</table>									
									</div> <!-- table-responsive -->
										<br>
								<?php
									echo form_open('ok/okcdaftar/selesai_daftar_pemeriksaan');?>
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Selesai & Cetak</button>
									</div>			
								<?php
									echo form_close();
								?>
						</div> <!-- p-20 -->
					</div>
		        </div>
		    </div>
		</div> <!-- row-ribbon -->


    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>