<?php
	if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>

<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<style>
	.modal-obat{
		width:200%;
		margin-left:-50%;
	}
</style>
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	});
</script>

<script type='text/javascript'>

	$(function(){
		$('#a-search').autocomplete({

		source : function( request, response ) {
			$.ajax({
				url: "<?php echo base_url('elektromedik/emcdaftar/autocomplete_search')?>",
				dataType: "json",
				data: {
					term: request.term
				},
				success: function (data) {
				if(!data.length){
					var result = [{
						label: 'Data tidak ditemukan', 
						value: response.data    
						}];
					response(result); 
				} else {
					response(data);                  
				}                  
				}
			});
		},
		select: function (event, ui) { 
			$('#a-search').val(ui.item.label);
			$('#'+ui.item.idtindakan.toLowerCase()).iCheck('check');
			$("#"+ui.item.idpok2).addClass('show');
		}
		});

		$( "#a-search" ).autocomplete( "option", "appendTo", "#accordionExample" );
		
	});

	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$("#biaya_em").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});

		var noreg = '<?php echo $no_register ?>';
		var idpollllmantap = '<?php echo $idrg ?>';
		console.log(noreg);
		console.log(idpollllmantap);
		$("#update_rujukan_em").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'elektromedik/emcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_em').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						if(noreg.substr(0,2) == 'RI'){
							location.href = '<?php echo base_url().'iri/rictindakan/form/elektromedik/'; ?>'+noreg;
						}else{
							if(idpollllmantap == 'BA00'){
								location.href = '<?php echo base_url().'ird/rdcpelayanan/form/asesmenmedik' ?>'+noreg;
							}else{
								if(idpollllmantap == 'BH00' || idpollllmantap == 'BH03') {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/asesmen_medik_dok_mata/' ?>'+idpollllmantap+'/'+noreg;
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
	} );
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('elektromedik/emcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_em').val(data);
				$('#biaya_em_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	$(function(){
		$('.auto_diagnosa_pasien').autocomplete({
			serviceUrl: site+'iri/ricstatus/data_icd_1',
			onSelect: function (suggestion) {
				$('#dis_diagmasuk').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
				$('#id_diagnosa').val(''+suggestion.id_icd);
			}
		});
	});

	function set_total() {
		var total = $("#biaya_em").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_em)
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
				url:"<?php echo base_url('elektromedik/emcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_em,
		        success: function(data)
		        {
	                $("#tabel_em").load("<?php echo base_url('elektromedik/emcdaftar/pemeriksaan_em').'/'.$no_register;?> #tabel_em");
	    			swal({
								title: "Data Pemeriksaan Berhasil Dihapus.",
								text: "Akan menghilang dalam 3 detik.",
								timer: 2000,
								type: "success",
								showConfirmButton: false,
								showCancelButton: false,
								showLoaderOnConfirm: true
							});
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
				url:"<?php echo base_url('elektromedik/emcdaftar/insert_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formInsertPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                $("#tabel_em").load("<?php echo base_url('elektromedik/emcdaftar/pemeriksaan_em').'/'.$no_register;?> #tabel_em");
			    			swal({
								title: "Data Pemeriksaan Berhasil Disimpan.",
								text: "Akan menghilang dalam 3 detik.",
								timer: 2000,
								type: "success",
								showConfirmButton: false,
								showCancelButton: false,
								showLoaderOnConfirm: true
							});
			                // window.location.reload();
			            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert(errorThrown);
	        	}
	    	});
		});
	}

	function save_banyak_data(){
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
				url:"<?php echo base_url('elektromedik/emcdaftar/save_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {
		            if(data.status) //if success close modal and reload ajax table
		            {
		            	 $('#myCheckboxes').iCheck('uncheck');
		                $('#pemeriksaanModal').modal('hide');
		                $("#tabel_em").load("<?php echo base_url('elektromedik/emcdaftar/pemeriksaan_em').'/'.$no_register;?> #tabel_em");
		    			// swal("Data Pemeriksaan Berhasil Disimpan.");
		    			
		    			swal({
						  	title: "Data Pemeriksaan Berhasil Disimpan.",
						  	text: "Akan menghilang dalam 3 detik.",
						  	timer: 2000,
                            type: "success",
						  	showConfirmButton: false,
						  	showCancelButton: false,
                            showLoaderOnConfirm: true
						});
		                
		            }else{
						swal({
                            title: "Gagal",
                            text: "Pastikan Data Diisi Dengan Benar",
                            type: "error",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            // window.location.reload();
                        });
					}


		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		         	// window.location.reload();
	        	}
	    	});
		});
	}

	function edit_diag(){
		var id_diagnosa = document.getElementById("id_diagnosa").value;
		swal({
		  	title: "Edit Data",
		  	text: "Benar Akan Mengedit Data Diagnosa?",
		  	type: "info",
		  	showCancelButton: true,
		  	closeOnConfirm: false,
		  	showLoaderOnConfirm: true,
		},
		function(){
			$.ajax({
				url:"<?php echo base_url('elektromedik/emcdaftar/edit_diag')?>",
		        type: "POST",
		        data: {
		        	no_register : "<?php echo $no_register;?>",
		        	id_diagnosa : id_diagnosa
		        },
		        dataType: "JSON",
		        success: function(data)
		        {
		            if(data.status) //if success close modal and reload ajax table
		            {
		    			swal("Data Diagnosa Berhasil Diedit.");
		    			
		    // 			swal({
						//   	title: "Data Pemeriksaan Berhasil Disimpan.",
						//   	text: "Akan menghilang dalam 3 detik.",
						//   	timer: 3000,
						//   	showConfirmButton: false,
						//   	showCancelButton: true
						// });
		                // window.location.reload();
		            }


		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		         	window.location.reload();
	        	}
	    	});
		});
	}

	function closepage() {
		window.open(' ', '_self', ' '); window.close();
	}
	function tindak(em,no_register){
		if(em==''){
			swal({
			title: "Tambah Resep",
			text: "Apakah Sudah Yakin Tambah Obat ?",
			type: "info",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		},
		function(){
				$.ajax({
					type: "POST",
					url: "<?php echo base_url().'elektromedik/emcdaftar/update_status_em'; ?>",
					dataType: "JSON",
					data: {'no_register' : no_register},
					success: function(data){  
					location.href = '<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em');?>/'+no_register; 
					},
					error:function(event, textStatus, errorThrown) {    
						swal("Error","Gagal Tambah Obat.", "error");     
						console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
					}
				});      	         	        
		});
		}else{
			location.href = '<?php echo site_url('elektromedik/emcdaftar/pemeriksaan_em');?>/'+no_register;
		}
	}

function showswal() {
	new swal({
		title: "",
		text: "MOHON REFRESH HALAMAN",
		type: "success",
		showConfirmButton: true,
		showCancelButton: false,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	},
	function () {
		// window.location.reload();
			location.href = '<?php echo site_url('elektromedik/emcdaftar');?>';
	});
}
</script>

<?php include('emvdatapasien.php');?>
<?php
	echo $this->session->flashdata('warning');
?>
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
                        	<div class="card b-all shadow-none">
								<!-- <?php 
									$attributes = array('id' => 'formInsertPemeriksaan', 'class' => 'form-horizontal');
									echo form_open('elektromedik/emcdaftar/insert_pemeriksaan', $attributes);
								?> -->
                                <div class="card-block">
                    				<button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>
									<?php if($obat_resep_em == null) {?>
										<button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#obatresep">Add Resep</button>
									<?php }else{ ?>
										<button type="button" class="btn btn-danger box-title" data-toggle="modal" data-target="#hapusobatresep">Hapus Resep</button>
									<?php } ?>
                    				<!-- <button type="button" class="btn btn-primary" onclick="resep()"><i class="fa fa-plus"></i> Resep</button> -->
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
                                <!-- <div class="card-block">
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_input_diagnosa">Diagnosa Awal</label>
										<div class="col-md-10">
											<div class="form-group">
												<input type="text" class="form-control auto_diagnosa_pasien col-lg-12"  name="diagnosa" id="diagnosa" style="width:300px;font-size:15px;" value="<?php echo $diagnosa?>">
												<input type="hidden" class="form-control " name="id_diagnosa" id="id_diagnosa" value="<?php 
												
												echo $id_diagnosa
												
												?>">
												<button type="button" id="submit" onclick="edit_diag()" class="btn btn-success">Edit</button>
											</div>
										</div>
									</div>
									<div class="form-group row" style="display: none;">
										<label class="control-label text-right col-md-2" id="nmdokter">Dokter</label>
										<div class="col-sm-10">
											<div class="form-group">
												<select id="id_dokter" class="form-control js-example-basic-single col-lg-12" name="id_dokter"  required>
													<option value="" disabled selected="">-Pilih Dokter-</option>
													<?php 
														foreach($dokter as $row){
															if($row->nm_dokter=="SMF ELEKTROMEDIK"){
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
												<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required>
													<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
													<?php 
														 foreach($tindakan as $row){
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
												<input type="text" class="form-control" name="biaya_em" id="biaya_em" disabled>
											</div>
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_qty">Qtyind</label>
										<div class="col-sm-3">
											<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
										</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_vtot">Total</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control" name="vtot" id="vtot" disabled>
											</div>
										</div>
									</div>
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
								<div class="card-block col-md-12" align="right">
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
                                </div> -->
								<!-- <?php
									echo form_close();
								?> -->
                            </div>
                        </div>
                    </div>
                    <h3 class="m-t-20 box-title">Tabel Pemeriksaan</h3>
					<!-- <button style="float:right;" type="button" id="popover" class="btn btn-warning" data-toggle="tooltip" title="1.klik Selesai & Cetak &nbsp;&nbsp;&nbsp;&nbsp; 2.Harap close page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
							<i class="fa fa-info-circle" aria-hidden="true"></i>
						</button> -->
                    <hr class="m-t-20 m-b-20">
                    <!--/row-->
					<form action="<?php echo base_url().'elektromedik/Emcdaftar/add_tanggal_tindak' ?>" method="post" style="width: 100%;">
						<div class="row">
							<label style="font-size:15px;font-weight: bold;text-align: center;" class="col-md-2">Tanggal Di Tindak</label>
							<div class="col-md-4">
								<input type="date" name="tgl_tindak" id="tgl_tindak" class="form-control" value="<?php echo isset($data_pemeriksaan[0]->tgl_tindakan)?date('Y-m-d',strtotime($data_pemeriksaan[0]->tgl_tindakan)):'';  ?>">
							</div>
							<div class="col-md-4">
								<input type="time" name="waktu_tindak" id="waktu_tindak" class="form-control" value="<?php echo isset($data_pemeriksaan[0]->tgl_tindakan)?date('H:i',strtotime($data_pemeriksaan[0]->tgl_tindakan)):'';  ?>">
							</div>
							<input type="hidden" name="no_register" id="no_register" class="form-control" value="<?php echo $no_register;?>">
							<button type="submit" class="btn btn-info col-md-2">Simpan</button>
						</div>
					</form>
					<br>
										
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_em" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<!-- <th>Tanggal Pemeriksaan</th> -->
										  	<!-- <th>Dokter</th> -->
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
												<!-- <td><?php //echo $row->tgl_kunjungan ; ?></td> -->
												<!-- <td><?php //echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td> -->
												<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
												<td><?php echo $row->biaya_em ; ?></td>
												<td><?php echo $row->qty ; ?></td>
												<td><?php echo intval($row->vtot) ; ?></td>
												<td>
													<a class="btn btn-danger" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_em ; ?>)">Hapus</a>
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
							<?php if ($pelayan == 'DOKTER') { ?>
								<!-- $link = base_url().'ird/rdcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register; -->
								<form method="post" id="update_rujukan_em">
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										<button type="submit" class="btn btn-primary" id="btn-rurjuk">Selesai</button>
									</div>  
								</form>	
							<?php }else{ ?>	
								<!-- <?php echo form_open('elektromedik/emcdaftar/selesai_daftar_pemeriksaan');?> -->
								<form action="<?php echo base_url().'elektromedik/emcdaftar/selesai_daftar_pemeriksaan/'.$pelayan ?>" method="post" target="_blank">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">

									<div class="form-group">
									<?php  if($roleid==1017 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary" onclick="showswal()">
											Selesai & Cetak
											</button>	';
										}else{
											echo '
											<button type="button" onclick="closepage()" class="btn btn-primary" >Close</button>
											
										';
										}
									}
										
									?>
								</form>						
								<!-- <?php echo form_close(); ?> -->
							<?php } ?>	

							
							<!-- <?php if($cara_bayar == 'BPJS') {?>
								<?php echo form_open('elektromedik/emcdaftar/selesai_daftar_pemeriksaan');?>
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">

									<div class="form-group">
									<?php  //if($roleid==11 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary">
											Selesai
											</button>	';
										}else{
											echo '
											<button type="button" onclick="closepage()" class="btn btn-primary" >Close</button>
											
										';
										}
										
									//	} 
									//if($roleid<>11 or $roleid==1){
										echo '
											<button type="button" onclick="closepage()" class="btn btn-primary">Close</button>
										';
									//}
									?>
														
								<?php echo form_close(); ?>
							<?php }else{ ?>	
								<?php echo form_open('elektromedik/emcdaftar/selesai_daftar_pemeriksaan');?>
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">

									<div class="form-group">
									<?php  //if($roleid==11 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary" onclick="showswal()">
											Selesai & Cetak
											</button>	';
										}else{
											echo '
											<button type="button" onclick="closepage()" class="btn btn-primary" >Close</button>
											
										';
										}
										
									//	} 
									//if($roleid<>11 or $roleid==1){
										echo '
											<button type="button" onclick="closepage()" class="btn btn-primary">Close</button>
										';
									//}
									?>
														
								<?php echo form_close(); ?>
							<?php } ?>	 -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pemeriksaanModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-lg">
        <div class="modal-content">
            <form action="#" id="formPemeriksaan" class="formPemeriksaan">
		        <div class="modal-header">
		            <h3 class="modal-title">Input Pemeriksaan</h3>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <div class="modal-body">

					<!-- <div class="form-group row">
						<p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Dokter *</b></p>
						<div class="col-sm-10">
							<div class="form-inline">
								<div class="form-group">
									<select id="id_dokter" class="form-control" name="id_dokter" required="">
										<option value="" disabled selected="">-Pilih Dokter-</option>
										<?php 
											foreach($dokter as $row){
												if($row->nm_dokter=="SMF LABORATORIUM"){
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
					</div>

		        	<div class="form-group row"  style="display: none;">
						<p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Dokter *</b></p>
						<div class="col-sm-10">
							<div class="form-inline">
								<div class="form-group">
									<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter" required="">
										<option value="" disabled selected="">-Pilih Dokter-</option>
										<?php 
											foreach($dokter as $row){
												// if($row->nm_dokter=="SMF ELEKTROMEDIK"){
												// 	echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
												// }else{
													echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
												// }
											}
										?>
									</select>
								</div>
							</div>
						</div>
					</div> -->
					<div class="pt-2 pb-2">
						<label for="a-search">Cari Pemeriksaan</label>
						<input type="text" class="form-control custom-select" id="a-search">
					</div>

					<div class="accordion" id="accordionExample">
						<?php foreach($data_jenis_em as $row1){ ?>
							<div class="row">
								<div class="col-md-12">
									<div class="card b-all shadow-none">
										<div class="card-header">
											<h2 class="mb-0">
												<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $row1->kode_jenis; ?>" aria-expanded="false" aria-controls="<?php echo $row1->kode_jenis; ?>" style="color:black;font-weight:bold;">
													<?php echo $row1->nama_jenis; ?>
												</button>
											</h2>
										</div>

										<div id="<?php echo $row1->kode_jenis; ?>" class="collapse" data-parent="#accordionExample">
											<div class="card-block">
												<div class='form-group row'>
													<?php 
														foreach($tindakan as $row2){
														
															if($row1->kode_jenis==$row2->idkel_tind){
																
																echo "
																	<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
																		<input type='checkbox' name='myCheckboxes[]' id='".strtolower($row2->idtindakan)."' value='".$row2->idtindakan."' /> ".$row2->nmtindakan."
																	</div>";
															}
														}
													?>
												</div>
												<div>
													<hr class='m-t-0'>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>

					<!-- <div class="row">
		                <div class="col-md-12">
		                	<div class="card b-all shadow-none">
		                        <div class="card-block">
								<?php
									foreach($data_jenis_em as $row1){
										echo '
											<div class="form-group row">
												<p class="col-sm-12 form-control-label" id="nmdokter"><b>'.$row1->nama_jenis.'</b></p>
											';
										foreach($tindakan as $row2){
											//echo '<div class="col-xs-3" style="background:#000000;border-style: dashed;">';
											if($row1->kode_jenis==$row2->idpok2){
												echo "<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
												<input type='checkbox' name='myCheckboxes[]' id='myCheckboxes' value='".$row2->idtindakan."' /> ".$row2->nmtindakan."</div>";
											}
										}
										echo '</div>
											<div>
												<hr class="m-t-0">
											</div>';
									}
									?>
								</div>
							</div>
						</div>
					</div> -->


		        </div>
		        <div class="modal-footer">
		            <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		        </div>
				<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
				<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
				<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
				<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
				<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
				<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
				<input type="hidden" class="form-control" value="<?php echo $tgl_periksa;?>" name="tgl_periksa">
				<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">	
				<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
				<input type="hidden" class="form-control" value="<?php echo $user_info->userid;?>" name="xuserid">
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="obatresep" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content modal-obat">
        <?php echo form_open('elektromedik/emcdaftar/insert_permintaan_resep'); ?>
            <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
		        <div class="modal-header">
		            <h3 class="modal-title">Input Obat</h3>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <div class="modal-body">

                    <div class="form-group row">
						<div class="col-sm-10">
							<table cellspacing="2" cellpadding="2" style="width: 100%;">
								<tr>
                        			<td>
										<label><?= $obat_em->nm_obat ?></label>
									</td>
									<td>
										<select class="form-control" name="signa" id="signa" style="width: 200px;" >
                                			<option value="">-Pilih Signa-</option>  
											<?php foreach ($satuan_signa as $row) { ?>
												<option value="<?=$row->signa?>"><?=$row->signa?></option>
											<?php }	?>
										</select>
									</td>
									<td>
										<select class="form-control" name="qtx" id="qtx" style="width: 200px;" >
                                			<option value="">-Pilih Qtx-</option>  
											<?php foreach ($qtx as $row) { ?>
												<option value="<?=$row->qtx?>"><?=$row->qtx?></option>
											<?php }	?>
										</select>
									</td>
									<td>
										<select class="form-control" name="satuan" id="satuan" style="width: 200px;" >
                                			<option value="">-Pilih Satuan-</option>  
											<?php foreach ($satuan as $row) { ?>
												<option value="<?=$row->nm_satuan?>"><?=$row->nm_satuan?></option>
											<?php }	?>
										</select>
									</td>
									<td>
										<select class="form-control" name="cara_pakai" id="cara_pakai" style="width: 200px;" >
                                			<option value="">-Pilih Cara Pakai-</option>  
											<?php foreach ($cara_pakai as $row) { ?>
												<option value="<?=$row->cara_pakai?>"><?=$row->cara_pakai?></option>
											<?php }	?>
										</select>
									</td>
									<td>
										<input type="hidden" name="id_obat" id="id_obat" value="<?= $obat_em->id_obat ?>">
										<input type="hidden" name="nm_obat" id="nm_obat" value="<?= $obat_em->nm_obat ?>">
										<input type="hidden" name="id_inventory" id="id_inventory" value="<?= $obat_em->id_inventory ?>">
										<input type="hidden" name="hargajual" id="hargajual" value="<?= $obat_em->hargajual ?>">
										<input type="number" min="1" name="qty" id="qty" placeholder="Qty" class="form-control" style="width: 70px;" required>
									</td>
								</tr>
							</table>							
						</div>
                    </div>		      

		        </div>

		        <div class="modal-footer">
                    <!-- <input type="hidden" name="idpoli" value="<?=$id_poli?>"/> -->
                    <input type="hidden" name="no_register" id="no_register" value="<?php echo $no_register; ?>">
                    <input type="hidden" name="no_medrec" id="no_medrec" value="<?php echo $no_medrec; ?>">
                    <input type="hidden" name="cara_bayar" id="cara_bayar" value="<?php echo $cara_bayar; ?>">
                    <input type="hidden" name="idrg" id="idrg" value="<?php echo $idrg; ?>">
                    <input type="hidden" name="bed" id="bed" value="<?php echo $bed; ?>">
                    <input type="hidden" name="kelas_pasien" id="kelas_pasien" value="<?php echo $kelas_pasien; ?>">
                    <!-- <input type="hidden" name="no_resep" id="no_resep" value="<?php echo $no_resep; ?>" > -->
                    <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
                    <input type="hidden" name="pelayan" id="pelayan" value="<?php echo $pelayan; ?>">
                    <button type="submit" class="btn btn-primary">Save</button>
		            <!-- <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button> -->
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		        </div>
            <!-- </form> -->
            <?php echo form_close(); ?> 
        </div>
    </div>
</div>

<div class="modal fade" id="hapusobatresep" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-lg">
        <div class="modal-content">
        <?php echo form_open('elektromedik/emcdaftar/hapus_permintaan_resep'); ?>
            <!-- <form action="#" id="formPemeriksaan" class="formPemeriksaan"> -->
		        <div class="modal-header">
		            <h3 class="modal-title">Hapus Obat</h3>
		            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                <span aria-hidden="true">&times;</span>
		            </button>
		        </div>
		        <div class="modal-body">

                    <div class="form-group row">
						<div class="col-sm-10">
							<h4>Yakin Hapus Obat?</h4>						
						</div>
                    </div>		      

		        </div>
				
		        <div class="modal-footer">
                    <input type="hidden" name="id_resep_pasien" id="id_resep_pasien" value="<?php echo $obat_resep_em->id_resep_pasien; ?>">
                    <input type="hidden" name="no_register" id="no_register" value="<?php echo $no_register; ?>">
                    <input type="hidden" name="no_medrec" id="no_medrec" value="<?php echo $no_medrec; ?>">
                    <input type="hidden" name="pelayan" id="pelayan" value="<?php echo $pelayan; ?>">
                    <button type="submit" class="btn btn-primary">Delete</button>
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
		        </div>
            <!-- </form> -->
            <?php echo form_close(); ?> 
        </div>
    </div>
</div>

<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>