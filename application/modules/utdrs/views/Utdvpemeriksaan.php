<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
    <link href="<?php echo site_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <script src="<?php echo site_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script type='text/javascript'>

	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$("#biaya_pa").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});

		var noreg = '<?php echo $no_register ?>';
		var idpollllmantap = '<?php echo $idrg ?>';

		  $("#update_rujukan_pa").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'utdrs/utdcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_pa').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						if(noreg.substr(0,2) == 'RI'){
							location.href = '<?php echo base_url().'iri/rictindakan/form/utd/'; ?>'+noreg;
						}else{
							if(idpollllmantap == 'BA00'){
								location.href = '<?php echo base_url().'ird/rdcpelayanan/form/utd/' ?>'+noreg;
							}else{
								if(idpollllmantap == 'BH00' || idpollllmantap == 'BH03') {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/assesment_medik_dok/' ?>'+idpollllmantap+'/'+noreg;
								} else {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/assesment_medik_dok/' ?>'+idpollllmantap+'/'+noreg;
								}
							}							
						}										
					} else {
						document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
						swal("Error", "Gagal menginput tindakan. Silahkan coba lagi.", "error");	  
						window.location.reload();      	
					}
				},
				error:function(event, textStatus, errorThrown) {       
					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				},
				timeout: 0
			});
			event.preventDefault();
		});  

	});
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";
			
	function pilih_tindakan_h(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('pa/pacdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_pa_h').val(data);
				$('#biaya_pa_hide_h').val(data);
				$('#qty_h').val('1');
				set_total_h();
			},
			error: function(){
				alert("gagal ambil harga");
			}
	    });
	}
			
	function pilih_tindakan_s(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('pa/pacdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_pa_s').val(data);
				$('#biaya_pa_hide_s').val(data);
				$('#qty_s').val('1');
				set_total_s();
			},
			error: function(){
				alert("gagal ambil harga");
			}
	    });
	}

	function set_total_s() {
		var total = $("#biaya_pa_s").val() * $("#qty_s").val();	
		$('#vtot_s').val(total);
		$('#vtot_hide_s').val(total);
	}

	function set_total_h() {
		var total = $("#biaya_pa_h").val() * $("#qty_h").val();	
		$('#vtot_h').val(total);
		$('#vtot_hide_h').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_utd)
	{
	  	swal({
		  	title: "Hapus Data",
		  	text: "Benar Akan Menghapus Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
				type:'POST',
				dataType: 'json',
				url:"<?php echo base_url('utdrs/utdcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_utd,
		        success: function(data)
		        {
		           	if(data.status) //if success close modal and reload ajax table
		            {
		            	// $('#myCheckboxes').iCheck('uncheck');
		                // $('#pemeriksaanModal').modal('hide');
		                $("#tabel_pa").load("<?php echo base_url('utdrs/utdcdaftar/pemeriksaan_utdrs').'/'.$no_register;?> #tabel_pa");
		    			// swal("Data Pemeriksaan Berhasil Dihapus.");

		    			swal({
						  	title: "Data Pemeriksaan Berhasil Dihapus.",
						  	text: "Akan menghilang dalam 3 detik.",
						  	timer: 3000,
						  	showConfirmButton: false,
						  	showCancelButton: true
						});
		                // window.location.reload();
		            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert('Error hapus / hapus data');
		        }
		    });
		});
	}

	function save(){
		swal({
		  	title: "Tambah Data",
		  	text: "Benar Akan Menyimpan Data?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
				$.ajax({
					url:"<?php echo base_url('utdrs/utdcdaftar/insert_pemeriksaan')?>",
			        type: "POST",
			        data: $('#formInsertPemeriksaanHisto').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                $("#tabel_pa").load("<?php echo base_url('utdrs/utdcdaftar/pemeriksaan_utdrs').'/'.$no_register;?> #tabel_pa");
			    			// swal("Data Pemeriksaan Berhasil Disimpan.");
				    			
			    			swal({
							  	title: "Data Pemeriksaan Berhasil Disimpan.",
							  	text: "Akan menghilang dalam 3 detik.",
							  	timer: 3000,
							  	showConfirmButton: false,
							  	showCancelButton: true
							});
			                // window.location.reload();
			            }


			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			        	alert(textStatus);
			         	// window.location.reload();
		        	}
		    	});
			
		});
	}

	function cetak_blanko(id_pemeriksaan_pa) {
		window.open("<?php echo base_url('pa/pacdaftar/cetak_blanko')?>/"+id_pemeriksaan_pa, "_blank")
	}

	function closepage() {
		window.open(' ', '_self', ' '); window.close();
	}


</script>	
<?php include('utdvdatapasien.php');?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Daftar Pemeriksaan <?php if($tgl_periksa!=''){echo ' | '.date('d-m-Y',strtotime($tgl_periksa)); }?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                        	<div class="card">
	                            <div class="card-block p-b-0">
	                                
	                                <!-- Tab panes -->
	                                <div class="tab-content">
	                                    <div class="tab-pane active" id="histopatologi" role="tabpanel" aria-expanded="true">
										<?php 
											$attributes = array('id' => 'formInsertPemeriksaanHisto', 'class' => 'form-horizontal');
											echo form_open('pa/pacdaftar/insert_pemeriksaan', $attributes); 
										?>
                                			<div class="card-block">

															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="nmdokter">Dokter</label>
																	<div class="col-sm-10">
																		<div class="form-group">
																			<select id="id_dokter_h" class="form-control js-example-basic-single" name="id_dokter_h" style="width: 100%" required>
																				<option value="" disabled selected="">-Pilih Dokter-</option>
																				<?php 
																					foreach($dokter as $row){
																						if($row->nm_dokter=="SMF PATOLOGI ANATOMI"){
																							echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
																						}else{
																							echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
																						}
																					}
																				?>
																			</select>
																		</div>
																	</div>
															</div>

															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="tindakan">Pemeriksaan</label>
																	<div class="col-sm-10">
																		
																			<div class="form-group">
																				<select id="idtindakan_h" class="form-control js-example-basic-single" name="idtindakan_h" onchange="pilih_tindakan_h(this.value)" style="width: 100%" required="">
																					<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
																					<?php 
																						foreach($tindakan_histo as $row){
																							echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
																						}
																					?>
																				</select>
																			</div>
																		
																	</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_biaya_periksa">Biaya Pemeriksaan</label>
																<div class="col-sm-3">
																	<div class="input-group">
																		<span class="input-group-addon">Rp</span>
																		<input type="text" class="form-control" value="<?php //echo $biaya_pa; ?>" name="biaya_pa_h" id="biaya_pa_h" disabled>
																		<input type="hidden" class="form-control" value="" name="biaya_pa_hide_h" id="biaya_pa_hide_h">
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_qty">Qtyind</label>
																<div class="col-sm-3">
																	<input type="number" class="form-control" name="qty_h" id="qty_h" min=1 onchange="set_total_h(this.value)">
																</div>
															</div>
															<div class="form-group row">
																<label class="control-label text-right col-md-2" id="lbl_vtot">Total</label>
																<div class="col-sm-3">
																	<div class="input-group">
																		<span class="input-group-addon">Rp</span>
																		<input type="text" class="form-control" name="vtot_h" id="vtot_h" disabled>
																		<input type="hidden" class="form-control" value="" name="vtot_hide_h" id="vtot_hide_h">
																	</div>
																</div>
															</div>

															<div class="card-block">
																
																<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
																<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
																<input type="hidden" class="form-control" value="<?php echo $tgl_periksa;?>" name="tgl_periksa">
																<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
																<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
																<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
																<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
																<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
																<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
																
																<button type="reset" class="btn btn-invers">Reset</button>
																<button type="button" id="submit" onclick="save()" class="btn btn-success">Simpan</button>
						                                	</div>
											</div>
										<?php
											echo form_close();
										?>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
                        </div>
                    </div>
                    <h3 class="m-t-20 box-title">Tabel Pemeriksaan</h3>
                    <hr class="m-t-20 m-b-20">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_pa" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<!-- <th>No PA</th>
										  	<th>Tanggal Pemeriksaan</th> -->
										  	<th>Dokter</th>
										  	<th>Jenis Pemeriksaan</th>
										  	<th>Biaya Pemeriksaan</th>
										  	<th>Qtyind</th>
										  	<th>Total</th>
										  	<th>Aksi</th>
										</tr>
			                        </thead>
									<tbody>
										<?php
											$i=1;
											foreach($data_pemeriksaan as $row){
										?>
											<tr>
												<td><?php echo $i++ ; ?></td>
												<!-- <td><?php // echo $row->no_pa_tindakan ; ?></td>
												<td><?php // echo $row->xupdate ; ?></td> -->
												<td><?php echo $row->nm_dokter ; ?></td>
												<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
												<td><?php echo $row->biaya_utd ; ?></td>
												<td><?php echo $row->qty ; ?></td>
												<td><?php echo $row->vtot ; ?></td>
												<td>
													<a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_utdrs ; ?>)">Hapus</a><br> &nbsp;
													<!-- <a class="btn btn-success btn-sm" href="javascript:void()" title="Cetak" onclick="cetak_blanko(<?php echo $row->id_pemeriksaan_pa ; ?>)">Cetak Blanko</a> -->
												</td>
											</tr>
										<?php
											}
										?>
									</tbody>
			                    </table>
			                </div>
		                </div>
                    </div>
                </div>
                <hr>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12" align="right">

						<?php if ($pelayan == 'DOKTER' || $pelayan == 'PERAWAT') {  ?>
								<form method="post" id="update_rujukan_pa">
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										<button type="submit" class="btn btn-primary" id="btn-rurjuk" >Selesai</button>
									</div>  
								</form>	

						<?php }else{ ?>

							<?php
							echo form_open('utdrs/utdcdaftar/selesai_daftar_pemeriksaan');?>
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

								<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
								<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">

								<div class="form-group">
									<button class="btn btn-primary">Selesai & Cetak</button>				
							<?php
								echo form_close();
							?>

						<?php } ?>
							
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	});
</script>

<?php
	$this->load->view('layout/footer_left.php');
?>