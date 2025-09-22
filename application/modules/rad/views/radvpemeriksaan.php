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
	.bebas {
    background-color: #50CB93 !important;
  }
</style>
<?php
// var_dump($data_pemeriksaan);	
?>
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>

<script type="text/javascript">
	$(document).ready(function() {
	  $(".js-example-basic-single").select2();
	  //$('#radiografer').select2();
	});

	$('#tombolkembali').on('click', function() {
		$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
	});
</script>

<script type='text/javascript'>

	$(function(){

		$('#a-search').autocomplete({

		source : function( request, response ) {
			$.ajax({
				url: "<?php echo base_url('rad/radcdaftar/autocomplete_search')?>",
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
			$("#"+ui.item.idkel_tind).addClass('show');
		}
		});

		$( "#a-search" ).autocomplete( "option", "appendTo", "#accordionExample" );
		
	});

	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$("#biaya_rad").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});

		var noreg = '<?php echo $no_register ?>';
		var id_ok = '';
		var cm = '<?php echo $no_cm ?>';
		var idpollllmantap = '<?php echo $idrg ?>';
		console.log(noreg);
		console.log(idpollllmantap);
		$("#update_rujukan_rad").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'rad/Radcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_rad').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						if(noreg.substr(0,2) == 'RI'){
							location.href = '<?php echo base_url().'iri/rictindakan/form/radiologi/'; ?>'+noreg;
							//window.open('<?php echo base_url('rad/radcdaftar/cetak_order/'); ?>'+noreg, '_blank');
						}else{
							if(idpollllmantap == 'BA00'){
								location.href = '<?php echo base_url().'ird/rdcpelayanan/form/rad/' ?>'+noreg;
								//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
							}else{
								if(idpollllmantap == 'BH00' || idpollllmantap == 'BH03') {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/assesment_medik_dok/' ?>'+idpollllmantap+'/'+noreg;
									//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
								} else {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/assesment_medik_dok/' ?>'+idpollllmantap+'/'+noreg;
									//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
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

		$("#update_rujukan_rad_ok").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'rad/Radcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_rad_ok').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						location.href = '<?php echo base_url().'ok/okcdaftar/form/rad/'; ?>'+noreg+'/'+id_ok;
															
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

		$("#update_rujukan_rad_perawat").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'rad/Radcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_rad_perawat').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						if(noreg.substr(0,2) == 'RI'){
							location.href = '<?php echo base_url().'iri/rictindakan/form/radiologi/'; ?>'+noreg;
							//window.open('<?php echo base_url('rad/radcdaftar/cetak_order/'); ?>'+noreg, '_blank');
						}else{
							if(idpollllmantap == 'BA00'){
								location.href = '<?php echo base_url().'ird/rdcpelayanan/form/rad/' ?>'+noreg;
								//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
							}else{
								if(idpollllmantap == 'BH00' || idpollllmantap == 'BH03') {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/rad/' ?>'+idpollllmantap+'/'+noreg;
									//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
								} else {
									location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/rad/' ?>'+idpollllmantap+'/'+noreg;
									//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
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
		var noreg = '<?php echo $no_register ?>';
		var cm = '<?php echo $no_cm ?>';
		var idpollllmantap = '<?php echo $idrg ?>';

	function showswaldokter() {
		swal({
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
			// window.location.reload();
			
			if(noreg.substr(0,2) == 'RI'){
				location.href = '<?php echo base_url().'iri/rictindakan/form/radiologi/'; ?>'+noreg;
				//window.open('<?php echo base_url('rad/radcdaftar/cetak_order/'); ?>'+noreg, '_blank');
			}else{
				if(idpollllmantap == 'BA00'){
					location.href = '<?php echo base_url().'ird/rdcpelayanan/form/asesmenmedik/' ?>'+noreg;
					//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
				}else{
					if(idpollllmantap == 'BH00' || idpollllmantap == 'BH03') {
						location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/asesmen_medik_dok_mata/' ?>'+idpollllmantap+'/'+noreg;
						//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
					} else {
						location.href = '<?php echo base_url().'irj/rjcpelayananfdokter/form/assesment_medik_dok/' ?>'+idpollllmantap+'/'+noreg;
						//window.open('<?php echo base_url('rad/radcdaftar/cetak_permintaan_order/'); ?>'+noreg+'/'+cm, '_blank');
					}
				}							
			}										
		});
	}
	//---------------------------------------------------------

	var site = "<?php echo site_url();?>";
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('rad/radcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_rad').val(data);
				$('#biaya_rad_hide').val(data);
				// $('#qty').val('1');
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
		var total = $("#biaya_rad").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_rad)
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
				url:"<?php echo base_url('rad/radcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_rad,
		        success: function(data)
		        {
	                $("#tabel_rad").load("<?php echo base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register;?> #tabel_rad");
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
		
	        $.ajax({
				url:"<?php echo base_url('rad/radcdaftar/insert_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formInsertPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {

			            if(data.status) //if success close modal and reload ajax table
			            {
			            	// $('#myCheckboxes').iCheck('uncheck');
			                // $('#pemeriksaanModal').modal('hide');
			                // $("#tabel_rad").load("<?php echo base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register;?> #tabel_rad");
			    			swal({
								title: "Berhasil!", 
								text: "Data Pemeriksaan Berhasil Disimpan.", 
								type: "success",
								icon: "success",
								buttons: false, // menonaktifkan tombol
								timer: 500,
								},
							function(){ 
								location.reload();
							}
							);
						
			                // window.location.reload();
			            }
		        },
		        error: function (jqXHR, textStatus, errorThrown)
		        {
		            alert(errorThrown);
	        	}
	    	});
		
	}

	function cetak(){
		window.open("<?=base_url('rad/radcdaftar/')?>", "_blank");
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
				url:"<?php echo base_url('rad/radcdaftar/save_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {
		            if(data.status) //if success close modal and reload ajax table
		            {
		            	 $('#myCheckboxes').iCheck('uncheck');
		                $('#pemeriksaanModal').modal('hide');
		                // $("#tabel_rad").load("<?php echo base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register;?> #tabel_rad");
		    			// swal("Data Pemeriksaan Berhasil Disimpan.");
		    			
		    			// swal({
						//   	title: "Data Pemeriksaan Berhasil Disimpan.",
						//   	text: "Akan menghilang dalam 3 detik.",
						//   	timer: 2000,
                        //     type: "success",
						//   	showConfirmButton: false,
						//   	showCancelButton: false,
                        //     showLoaderOnConfirm: true
						// });
						swal({
								title: "Berhasil!", 
								text: "Data Pemeriksaan Berhasil Disimpan.", 
								type: "success"
								},
							function(){ 
								location.reload();
							}
							);
		                // window.location.reload();
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
                            window.location.reload();
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
				url:"<?php echo base_url('rad/radcdaftar/edit_diag')?>",
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

	function tindak(rad,no_register){
		if(rad==''){
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
					url: "<?php echo base_url().'rad/radcdaftar/update_status_rad'; ?>",
					dataType: "JSON",
					data: {'no_register' : no_register},
					success: function(data){  
					location.href = '<?php echo site_url('rad/radcdaftar/pemeriksaan_rad');?>/'+no_register; 
					},
					error:function(event, textStatus, errorThrown) {    
						swal("Error","Gagal Tambah Obat.", "error");     
						console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
					}
				});      	         	        
		});
		}else{
			location.href = '<?php echo site_url('rad/radcdaftar/pemeriksaan_rad');?>/'+no_register;
		}
	}

	function showswal() {
		swal({
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
			// window.location.reload();
			//location.href = '<?php echo site_url('rad/radcdaftar');?>';
		});
	}

	function save_bius(){
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
				url:"<?php echo base_url('rad/radcdaftar/save_pemeriksaan_bius')?>",
				type: "POST",
				data: $('#formPemeriksaanbius').serialize(),
				dataType: "JSON",
				success: function(data)
				{
					if(data.status) //if success close modal and reload ajax table
					{
						swal({
								title: "Berhasil!", 
								text: "Data Pemeriksaan Berhasil Disimpan.", 
								type: "success"
								},
							function(){ 
								location.reload();
							}
							);
						// window.location.reload();
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
							window.location.reload();
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

</script>
<setion class="content">
<?php echo $this->session->flashdata('success_msg'); ?>
<?php include('radvdatapasien.php');?>

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
								<?php 
									$attributes = array('id' => 'formInsertPemeriksaan', 'class' => 'form-horizontal');
									echo form_open('rad/radcdaftar/insert_pemeriksaan', $attributes);
								?>
                                <div class="card-block row">
									<?php // if ($pelayan == '') {  ?>
                    					<!-- <button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>&nbsp;&nbsp; -->
								
									
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
                               
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="tindakan">Pemeriksaan</label>
										<div class="col-sm-4">
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
										<div class="col-sm-4">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control" name="biaya_rad" id="biaya_rad" disabled>
												<input type="hidden" class="form-control" name="biaya_rad_hide" id="biaya_rad_hide">
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
                                </div>
								<?php
									echo form_close();
								?>
                            </div>
                        </div>
                    </div>
                    <h3 class="m-t-20 box-title">Tabel Pemeriksaan</h3>
					<!-- <button style="float:right;" type="button" id="popover" class="btn btn-warning" data-toggle="tooltip" title="1.klik Selesai & Cetak &nbsp;&nbsp;&nbsp;&nbsp; 2.Harap close page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
							<i class="fa fa-info-circle" aria-hidden="true"></i>
						</button> -->
                    <hr class="m-t-20 m-b-20">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_rad" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<!-- <th>Tanggal Pemeriksaan</th> -->
										  	<!-- <th>Modality</th> -->
										  	<!-- <th>CATATAN</th> -->
										  	<!-- <th>Accesion Number</th> -->
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
												<td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $i++ ; ?></td>
												<!-- <td><?php //echo $row->tgl_kunjungan ; ?></td> -->
												<!-- <td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $row->modality ; ?></td> -->
												<!-- <td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $row->komen ; ?></td> -->
												<!-- <td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $row->accesion_number ; ?></td> -->
												<td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
												<td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $row->biaya_rad ; ?></td>
												<td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo $row->qty ; ?></td>
												<td class="<?= $row->selesai ? 'bebas' : ''; ?>"><?php echo intval($row->vtot) ; ?></td>
												<td class="<?= $row->selesai ? 'bebas' : ''; ?>">
													<?php if ($pelayan == 'DOKTER' || $pelayan == 'OK' || $pelayan == 'PERAWAT' ) {  ?>
														<a class="btn btn-danger btn-sm" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_rad ; ?>)">Hapus</a>
													<?php } else { ?>
														<!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="" onclick="">Generate AN</button> -->
														<!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bhpPetugas" onclick="insert_petugas(<?php echo $row->id_pemeriksaan_rad ; ?>)">Petugas</button> -->
														<!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#bhpModal" onclick="insert_bhp(<?php echo $row->id_pemeriksaan_rad ; ?>)">BHP</button> -->
														<!-- <a href="<?php echo base_url('rad/radcdaftar/form_bhp/'.$row->id_pemeriksaan_rad); ?>" class="btn btn-primary btn-sm" target="_blank">BHP</a> -->
														<!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ulangModal" onclick="ulang_tindak(<?php echo $row->id_pemeriksaan_rad ; ?>)">Ulang</button> -->
														<?php //if($row->accesion_number != NULL) { ?>
															<!-- <a href="<?php echo base_url('rad/radcdaftar/selesai_pemeriksaan/'.$row->id_pemeriksaan_rad.'/'.$no_register); ?>" class="btn btn-primary btn-sm">Selesai</a>
															<a href="<?php echo base_url('rad/radcdaftar/cetak_permintaan_bhp/'.$row->id_pemeriksaan_rad); ?>" class="btn btn-primary btn-sm" target="_blank">Cetak</a> -->
															<a href="<?php echo base_url('rad/radcdaftar/batal_pemeriksaan/'.$row->id_pemeriksaan_rad.'/'.$no_register); ?>" class="btn btn-danger btn-sm">Batal</a>
														<?php //} ?>
													<?php } ?>
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
							<?php if ($pelayan == 'DOKTER') {  ?>
								<!-- $link = base_url().'ird/rdcpelayananfdokter/pelayanan_tindakan/'.$idrg.'/'.$no_register; -->
								<form method="post" id="update_rujukan_rad">
									<div class="form-inline" align="right">
										<label>Diagnosa Klinis : </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="text" class="form-control"  name="diag_klinis" id="diag_klinis">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec" id="no_medrec">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										
										<button type="submit" class="btn btn-primary" id="btn-rurjuk">Selesai</button>
									</div>  
								</form>
							<?php }else if ($pelayan == 'OK') {  ?>		
								<form method="post" id="update_rujukan_rad_ok">
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec" id="no_medrec">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										<button type="submit" class="btn btn-primary" id="btn-rurjuk">Selesai</button>
									</div>  
								</form>		
							<?php }else if ($pelayan == 'PERAWAT') {  ?>		
							<form method="post" id="update_rujukan_rad_perawat">
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
									<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec; ?>" name="no_medrec" id="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
									<button type="submit" class="btn btn-primary" id="btn-rurjuk">Selesai</button>
								</div>  
							</form>							
							<?php }else{ ?>	
								<!-- <?php echo form_open('rad/radcdaftar/selesai_daftar_pemeriksaan');?> -->
								<form action="<?php echo base_url().'rad/radcdaftar/selesai_daftar_pemeriksaan/'.$pelayan ?>" method="post">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" name="radiologi" value='<?= json_encode($data_pemeriksaan_pacsman); ?>'>
									<input type="hidden" name="no_cm" value="<?= $no_cm ?>">

									<div class="form-group">
									<?php if($roleid==1016 or $roleid==1){
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
								<?php echo form_open('rad/radcdaftar/selesai_daftar_pemeriksaan');?>
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" name="radiologi" value='<?= json_encode($data_pemeriksaan); ?>'>
									<input type="hidden" name="no_cm" value="<?= $no_cm ?>">

									<div class="form-group">
									<?php $link = site_url('rad/radcdaftar/pemeriksaan_rad/').$no_register; //if($roleid==11 or $roleid==1){
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
											<button onclick="closepage()" class="btn btn-primary">Close</button>
										';
									//}
									?>
														
								<?php echo form_close(); ?>
							<?php }else{ ?>	
								<?php echo form_open('rad/radcdaftar/selesai_daftar_pemeriksaan');?>
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" name="radiologi" value='<?= json_encode($data_pemeriksaan); ?>'>
									<input type="hidden" name="no_cm" value="<?= $no_cm ?>">

									<div class="form-group">
									<?php $link = site_url('rad/radcdaftar/pemeriksaan_rad/').$no_register; //if($roleid==11 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary">
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
											<button onclick="closepage()" class="btn btn-primary">Close</button>
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
</section>
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
												if($row->nm_dokter=="SMF RADIOLOGI"){
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
					</div> -->									

					<div class="form-group row">
						<p class="col-sm-2 form-control-label text-right" id="nmdokter"><b>Catatan *</b></p>
						<div class="col-sm-10">
							<div class="form-inline">
								<div class="form-group">
									<input type="text" name="komen" id="komen" class="form-control" align="left" style="float: left;" placeholder="Catatan">
								</div>
							</div>
						</div>						
					</div>
					<div class="pt-2 pb-2">
						<label for="a-search">Cari Pemeriksaan</label>
						<input type="text" class="form-control custom-select" id="a-search">
					</div>

					<div class="accordion" id="accordionExample">
						<?php foreach($tindakan_request_kel as $row1){ ?>
							<div class="row">
								<div class="col-md-12">
									<div class="card b-all shadow-none">
										<div class="card-header">
											<h2 class="mb-0">
												<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#<?php echo $row1->kel_tindakan; ?>" aria-expanded="false" aria-controls="<?php echo $row1->kel_tindakan; ?>" style="color:black;font-weight:bold;">
													<?php echo $row1->kel_tindakan; ?>
												</button>
											</h2>
										</div>

										<div id="<?php echo $row1->kel_tindakan; ?>" class="collapse" data-parent="#accordionExample">
											<div class="card-block">
												<div class='form-group row'>
													<?php 
														foreach($tindakan_request as $row2){
														
															if($row1->kel_tindakan==$row2->kel_tindakan){
																
																echo "
																	<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
																		<input type='checkbox' name='myCheckboxes[]' id='".strtolower($row2->nm_tindakan)."' value='".$row2->nm_tindakan."' /> ".$row2->nm_tindakan."
																	</div>";
															}elseif($row2->kel_tindakan == null){
																echo "<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
																<input type='checkbox' name='myCheckboxes[]' id='".strtolower($row2->nm_tindakan)."' value='".$row2->nm_tindakan."' /> ".$row2->nm_tindakan."</div>";
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
									foreach($data_jenis_rad as $row1){
										echo '
											<div class="form-group row">
												<p class="col-sm-12 form-control-label" id="nmdokter"><b>'.$row1->nama_jenis.'</b></p>
											';
										foreach($tindakan as $row2){
											//echo '<div class="col-xs-3" style="background:#000000;border-style: dashed;">';
											if($row1->kode_jenis==$row2->idkel_tind){
												echo "<div class='col-sm-3' style='margin: 10px 0px 10px 0px;'> 
												<input type='checkbox' name='myCheckboxes[]' id='myCheckboxes' value='".$row2->idtindakan."' /> ".$row2->nmtindakan."</div>";
											}elseif($row1->kode_jenis=='LA' && $row2->idkel_tind == null) {
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
				<!-- <input type="hidden" class="form-control" value="<?php echo $norad;?>" name="norad"> -->
				<?php
				if(substr($no_register, 0,2)=="PL"){ ?>
					<input type="hidden" class="form-control" value="<?php echo $rs_perujuk;?>" name="rs_perujuk">
					<input type="hidden" class="form-control" value="<?php echo $nmkontraktor;?>" name="nmkontraktor">
				<?php
				}
				?>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="obatresep" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content modal-obat">
        <?php echo form_open('rad/radcdaftar/insert_permintaan_resep'); ?>
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
										<label><?= $obat_rad->nm_obat ?></label>
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
										<input type="hidden" name="id_obat" id="id_obat" value="<?= $obat_rad->id_obat ?>">
										<input type="hidden" name="nm_obat" id="nm_obat" value="<?= $obat_rad->nm_obat ?>">
										<input type="hidden" name="id_inventory" id="id_inventory" value="<?= $obat_rad->id_inventory ?>">
										<input type="hidden" name="hargajual" id="hargajual" value="<?= $obat_rad->hargajual ?>">
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
        <?php echo form_open('rad/radcdaftar/hapus_permintaan_resep'); ?>
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
                    <input type="hidden" name="id_resep_pasien" id="id_resep_pasien" value="<?php echo $obat_resep_rad->id_resep_pasien; ?>">
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

<form method="POST" id="ulang_form" class="form-horizontal">
    <!-- Modal Edit Obat -->
    <div class="modal fade" id="ulangModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pengulangan Tindakan</h4>
                </div>
                <div class="modal-body">
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Id Pemeriksaan</p>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="edit_id" id="edit_id" disabled="">
							<input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
							<input type="hidden" class="form-control" name="noreg_ulang" id="noreg_ulang">
						</div>
                  	</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Alasan Pengulangan</p>
						<div class="col-sm-6">
							<select name="alasan" id="alasan" class="form-control" onchange="cek_tampil_per(this.value)">
								<option value="">-- Pilih Alasan --</option>
								<option value="pasien_bergerak">Pasien Bergerak</option>
								<option value="artefak">Artefak / Benda Asing</option>
								<option value="terpotong">Terpotong</option>
								<option value="eksposisi">Faktor Eksposisi Rendah/Tinggi</option>
								<option value="lain">Lain Lain</option>
							</select>
						</div>
                  	</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label"></p>
						<div class="col-sm-6">
							<input type="text" name="text_lain" id="text_lain" class="form-control">
						</div>
                  	</div>
					  <div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Keterangan</p>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="kali_ulang" id="kali_ulang" disabled="">
						</div>
                  	</div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form method="POST" id="bhp_form" class="form-horizontal">
    <!-- Modal Edit Obat -->
    <div class="modal fade bd-example-modal-lg" id="bhpModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">BHP</h4>
                </div>
                <div class="modal-body">
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Id Pemeriksaan</p>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="edit_id_bhp" id="edit_id_bhp" disabled="">
							<input type="hidden" class="form-control" name="edit_id_bhp_hidden" id="edit_id_bhp_hidden">
						</div>
                  	</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">catatan BHP</p>
						<div class="col-sm-6">
							<textarea class="form-control" name="edit_bhp" id="edit_bhp" cols="30" rows="10"></textarea>
						</div>
                  	</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">BHP Gagal</p>
						<div class="col-sm-6">
							<input type="number" class="form-control" name="bhp_gagal" id="bhp_gagal" value="0">
						</div>
                  	</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">BHP yang dipakai</p>
						<div class="col-sm-6">
							<input type="number" class="form-control" name="bhp_total" id="bhp_total" value="0">
						</div>
                  	</div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form method="POST" id="petugas_form" class="form-horizontal">
    <!-- Modal Edit Obat -->
    <div class="modal fade" id="bhpPetugas"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pilih Petugas</h4>
                </div>
                <div class="modal-body">
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Id Pemeriksaan</p>
						<div class="col-sm-6">
							<input type="text" class="form-control" name="edit_id_radiografer" id="edit_id_radiografer" disabled="">
							<input type="hidden" class="form-control" name="edit_id_radiografer_hidden" id="edit_id_radiografer_hidden">
							<input type="hidden" class="form-control" name="no_register_modal_petugas" id="no_register_modal_petugas">
						</div>
                  	</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label">Radiografer</p>
						<div class="col-sm-6">
							<select name="radiografer" id="radiografer" class="form-control select2">
								<option value="">-- Pilih Radiografer --</option>
								<?php
								foreach($radiografer as $r) {
									echo '<option value="'.$r->userid.'@'.$r->username.'">'.$r->name.'</option>';
								}
								?>
							</select>
						</div>
                  	</div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
$(function() {
    //$('#text_lain').hide();
});
var no_register = '<?php echo $no_register ?>';
var id_pemeriksaan = '';
function insert_petugas(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('rad/radcdaftar/get_data_pemeriksaan')?>",
      data: {
        id: id
      },
      success: function(data){
        //console.log(data);
        $('#edit_id_radiografer').val(data[0].id_pemeriksaan_rad);
		$('#edit_id_radiografer_hidden').val(data[0].id_pemeriksaan_rad);
		$('#no_register_modal_petugas').val(data[0].no_register);
		$('#radiografer').val(data[0].id_radiografer+'@'+data[0].xuser);
      },
      error: function(){
        alert("error");
      }
    });
}

function insert_bhp(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('rad/radcdaftar/get_data_pemeriksaan')?>",
      data: {
        id: id
      },
      success: function(data){
        //console.log(data);
        $('#edit_id_bhp').val(data[0].id_pemeriksaan_rad);
		$('#edit_id_bhp_hidden').val(data[0].id_pemeriksaan_rad);
		$('#edit_bhp').val(data[0].catatan_bhp);
		$('#bhp_total').val(data[0].bhp_total);
		$('#bhp_gagal').val(data[0].bhp_gagal);
      },
      error: function(){
        alert("error");
      }
    });
}

function ulang_tindak(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('rad/radcdaftar/get_data_pemeriksaan')?>",
      data: {
        id: id
      },
      success: function(data){
        //console.log(data);
        $('#edit_id').val(data[0].id_pemeriksaan_rad);
		$('#edit_id_hidden').val(data[0].id_pemeriksaan_rad);
		$('#noreg_ulang').val(data[0].no_register);
		$('#alasan').val(data[0].alasan_ulang);
		$('#text_lain').val(data[0].alasan_ulang_detail);
		if(data[0].ulang === null) {
			$('#kali_ulang').val('Belum ada pengulangan');
		} else {
			$('#kali_ulang').val(data[0].ulang + ' Kali Ulang');
		}
      },
      error: function(){
        alert("error");
      }
    });
}

$('#petugas_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>rad/radcdaftar/insert_petugas_tindakan",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit';
            $('#petugasModal').modal('hide'); 
            document.getElementById("petugas_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+id_pemeriksaan;
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit';
            $('#petugasModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

	  $('#bhp_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>rad/radcdaftar/insert_catatan_bhp",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit';
            $('#bhpModal').modal('hide'); 
            document.getElementById("bhp_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+id_pemeriksaan;
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit';
            $('#bhpModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

	  $('#ulang_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>rad/radcdaftar/insert_ulang_tindakan",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit';
            $('#ulangModal').modal('hide'); 
            document.getElementById("ulang_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+id_pemeriksaan;
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit';
            $('#ulangModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });
// function cek_tampil_per(val_tampil_per){
//          if(val_tampil_per=='lain'){
//              $('#text_lain').show();
//          }else {
//              $('#text_lain').hide();
//          } 
//  }
</script>
<?php
	if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>