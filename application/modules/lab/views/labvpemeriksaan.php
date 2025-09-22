<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<script type='text/javascript'>

	$(function(){
		$('#a-search').autocomplete({

		source : function( request, response ) {
			$.ajax({
				url: "<?php echo base_url('lab/labcdaftar/autocomplete_search')?>",
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
		$("#biaya_lab").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});

		var noreg = '<?php echo $no_register ?>';
		var id_ok = '<?php echo $id_ok ?>';
		var idpollllmantap = '<?php echo $idrg ?>';
		console.log(noreg);
		console.log(idpollllmantap);
		$("#update_rujukan_lab").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'lab/labcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_lab').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						if(noreg.substr(0,2) == 'RI'){
							location.href = '<?php echo base_url().'iri/rictindakan/form/lab/'; ?>'+noreg;
						}else{
							if(idpollllmantap == 'BA00'){
								location.href = '<?php echo base_url().'ird/rdcpelayanan/form/lab/' ?>'+noreg;
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

		$("#update_rujukan_lab_ok").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'lab/labcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_lab_ok').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
							location.href = '<?php echo base_url().'ok/okcdaftar/form/lab/'; ?>'+noreg+'/'+id_ok;									
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

		$("#update_rujukan_lab_perawat").submit(function(event) {
			document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'lab/labcdaftar/update_rujukan_penunjang'; ?>",
				dataType: "JSON",
				data: $('#update_rujukan_lab_perawat').serialize(),
				success: function(data){   
			    	document.getElementById("btn-rurjuk").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					if (data.status == true) {
						if(noreg.substr(0,2) == 'RI'){
							location.href = '<?php echo base_url().'iri/rictindakan/form/lab/'; ?>'+noreg;
						}else{
							if(idpollllmantap == 'BA00'){
								location.href = '<?php echo base_url().'ird/rdcpelayanan/form/lab/' ?>'+noreg;
							}else{
								if(idpollllmantap == 'BH00' || idpollllmantap == 'BH03') {
									location.href = '<?php echo base_url().'irj/rjcpelayanan/form/lab/' ?>'+idpollllmantap+'/'+noreg;
								} else {
									location.href = '<?php echo base_url().'irj/rjcpelayanan/form/lab/' ?>'+idpollllmantap+'/'+noreg;
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
			
	function pilih_tindakan(id_tindakan) {
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('lab/labcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				$('#biaya_lab').val(data);
				$('#biaya_lab_hide').val(data);
				$('#qty').val('1');
				set_total();
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function set_total() {
		var total = $("#biaya_lab").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

	function hapus_data_pemeriksaan(id_pemeriksaan_lab)
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
				url:"<?php echo base_url('lab/labcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_lab,
		        success: function(data)
		        {
		           	if(data.status) //if success close modal and reload ajax table
		            {
		            	// $('#myCheckboxes').iCheck('uncheck');
		                // $('#pemeriksaanModal').modal('hide');
		                $("#tabel_lab").load("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register;?> #tabel_lab");
		    			// swal("Data Pemeriksaan Berhasil Dihapus.");

		    			swal({
								title: "Data Pemeriksaan Berhasil Dihapus.",
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
				url:"<?php echo base_url('lab/labcdaftar/insert_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formInsertPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {

		            if(data.status) //if success close modal and reload ajax table
		            {
		            	// $('#myCheckboxes').iCheck('uncheck');
		                // $('#pemeriksaanModal').modal('hide');
		                $("#tabel_lab").load("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register;?> #tabel_lab");
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

	function save_banyak_data(){
		
			$.ajax({
				url:"<?php echo base_url('lab/labcdaftar/save_pemeriksaan')?>",
		        type: "POST",
		        data: $('#formPemeriksaan').serialize(),
		        dataType: "JSON",
		        success: function(data)
		        {

		            if(data) //if success close modal and reload ajax table
		            {
		            	 $('#myCheckboxes').iCheck('uncheck');
		                $('#pemeriksaanModal').modal('hide');
		                $("#tabel_lab").load("<?php echo base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register;?> #tabel_lab");
		    			// swal("Data Pemeriksaan Berhasil Disimpan.");	
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
					 console.log(jqXHR);
					 console.log(textStatus);
					 console.log(errorThrown);
					    window.location.reload();
		            
	        	}
	    	});
		
	}

	function closepage() {
		window.open("<?=base_url('lab/labcdaftar')?>", "_self");
		 window.close();
	}

	function showswal() {
		var base = "<?php echo base_url(); ?>";
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
			window.location.href = base+"lab/labcdaftar";
		});
	}

	function outputpdf(noreg){
		window.open("<?=base_url('lab/labcdaftar/test/')?>"+noreg, "_blank");
	}

	function showorder() {
		var base = "<?php echo base_url(); ?>";	
		var nroeg = "<?php echo $no_register; ?>";	
		window.location.href = base+"lab/labcdaftar/cetak_order/"+nroeg;		
	}

function update_cito(id) {
	document.getElementById('btn-cito-'+id).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
    $.ajax({  
      url:"<?php echo base_url(); ?>lab/labcdaftar/update_cito",                         
      method:"POST",  
      data:{
        id: id
      },  
      success: function(data)  
      { 
        document.getElementById('btn-cito-'+id).innerHTML = 'Cito';
        swal({
          title: "Selesai",
          text: "Data berhasil disimpan",
          type: "success",
          showCancelButton: false,
          closeOnConfirm: true,
          showLoaderOnConfirm: true
        },
        function () {
          window.location.reload();
        }); 
      },
      error:function(event, textStatus, errorThrown) {
        document.getElementById('btn-cito-'+id).innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        swal("Error","Data gagal diperbaharui.", "error"); 
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }  
  });
}
</script>
<?php include('labvdatapasien.php');?>

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
									echo form_open('lab/labcdaftar/insert_pemeriksaan', $attributes); 
								?>
                                <div class="card-block">
                    				<button type="button" class="btn btn-primary box-title" data-toggle="modal" data-target="#pemeriksaanModal">Add Pemeriksaan</button>
                                </div>
                                <div>
                                    <hr class="m-t-0">
                                </div>
                                <!-- <div class="card-block">
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="nmdokter">Dokter</label>
											<div class="col-sm-10">
												<div class="form-group">
													<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter"  required>
														<option value="" disabled selected="">-Pilih Dokter-</option>
														<?php 
														/*
															foreach($dokter as $row){
																if($row->nm_dokter=="SMF LABORATORIUM"){
																	echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
																}else{
																	echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
																}
															}
														*/	
														?>
													</select>
												</div>
											</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="tindakan">Pemeriksaan</label>
											<div class="col-sm-10">
												 <div class="form-inline">
													
													<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
													<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
													
													<div class="form-group">
														<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required="">
															<option value="" disabled selected="">-Pilih Pemeriksaan-</option>
											<?php
											/*
												foreach($data_jenis_lab as $row2){
													echo "<optgroup label='".$row2->nama_jenis."'>";
													foreach($tindakan as $row){
														if($row2->kode_jenis==substr($row->idtindakan,0,2))
															echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
													}
													echo "</optgroup>";
												}
												*/
											?>
														</select>
													</div>
												</div>
											</div>
									</div>
									<div class="form-group row">
										<label class="control-label text-right col-md-2" id="lbl_biaya_periksa">Biaya Pemeriksaan</label>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control" value="<?php //echo $biaya_lab; ?>" name="biaya_lab" id="biaya_lab" disabled>
												<input type="hidden" class="form-control" value="" name="biaya_lab_hide" id="biaya_lab_hide">
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
												<input type="hidden" class="form-control" value="" name="vtot_hide" id="vtot_hide">
											</div>
										</div>
									</div>
                                </div> -->
                                <div>
                                    <hr class="m-t-0">
                                </div>
                                <!-- <div class="card-block">
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
								<?php
									echo form_close();
								?>
                            </div>
                        </div>
                    </div>
                   
					
						
						<h3 class="m-t-20 box-title">Tabel Pemeriksaan</h3>
						
						<!-- <button style="float:right;" type="button" id="popover" class="btn btn-warning" data-toggle="tooltip" title="1.klik Selesai & Cetak &nbsp;&nbsp;&nbsp;&nbsp; 2.Harap Close Page&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;">
							<i class="fa fa-info-circle" aria-hidden="true"></i>
						</button> -->
					
					
                    <hr class="m-t-20 m-b-20">
                    <!--/row-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
			                    <table id="tabel_lab" class="table display table-bordered table-striped">
			                        <thead>
										<tr>
										  	<th>No</th>
										  	<!-- <th>Cito</th> -->
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
												<!-- <td><?php 
													//if($row->cito == '1'){
														//echo 'YA'; 
													//}else{
													//	echo 'TIDAK'; 
													//}													
												?></td> -->
												<!-- <td><?php //echo $row->nm_dokter.' ('.$row->id_dokter.')' ; ?></td> -->
												<td><?php echo $row->jenis_tindakan.' ('.$row->id_tindakan.')' ; ?></td>
												<td><?php echo intval($row->biaya_lab) ; ?></td>
												<td><?php echo $row->qty ; ?></td>
												<td><?php echo intval($row->vtot) ; ?></td>
												<td>
													<a class="btn btn-danger" href="javascript:void()" title="Hapus" onclick="hapus_data_pemeriksaan(<?php echo $row->id_pemeriksaan_lab ; ?>)">Hapus</a>
													<!-- <button class="btn btn-info" type="button" onclick="update_cito(<?php echo $row->id_pemeriksaan_lab; ?>)" id="btn-cito-<?= $row->id_pemeriksaan_lab ?>">Cito</button> -->
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
						<!-- <button onclick="outputpdf('<?php //echo $no_register; ?>')">button</button> -->
							<?php if ($pelayan == 'DOKTER') {  ?>
								<form method="post" id="update_rujukan_lab">
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										<input type="checkbox" class="form-check-input" name="cyto" value="1"> 
										&nbsp;&nbsp;&nbsp;Cyto
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<button type="submit" class="btn btn-primary" id="btn-rurjuk" >Selesai</button>
									</div>  
								</form>	
								<?php }else if($pelayan == 'OK'){ ?>	
									<form method="post" id="update_rujukan_lab_ok">
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										<button type="submit" class="btn btn-primary" id="btn-rurjuk" >Selesai</button>
									</div>  
								</form>	
								<?php }else if($pelayan == 'PERAWAT'){ ?>	
									<form method="post" id="update_rujukan_lab_perawat">
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $pelayan; ?>" name="pelayan" id="pelayan">
										<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register" id="no_register">
										<input type="hidden" class="form-control" value="<?php echo $idrg; ?>" name="idrg" id="idrg">
										<input type="checkbox" class="form-check-input" name="cyto" value="1"> 
										&nbsp;&nbsp;&nbsp;Cyto
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<button type="submit" class="btn btn-primary" id="btn-rurjuk" >Selesai</button>
									</div>  
								</form>							
							<?php }else{ ?>
								<!-- <?php echo form_open('lab/labcdaftar/selesai_daftar_pemeriksaan');?>  -->
								<form action="<?php echo base_url().'lab/labcdaftar/selesai_daftar_pemeriksaan/'.$pelayan ?>" method="post" target="_blank">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">

									
									<div class="form-group">
									<?php $link = site_url('lab/labcdaftar/pemeriksaan_lab/').$no_register;
									if($roleid==1015 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary" onclick="showswal()">
											Selesai & Cetak
											</button>	';
										}else{
											echo '
											<button onclick="closepage()" class="btn btn-primary" >Close</button>
											
										';
										}
										
									} 
									
									?>
								</form>				
								 <!-- <?php echo form_close(); ?> -->
							<?php } ?>	
							
							<!-- <?php if($cara_bayar == 'BPJS') {?>
								<?php echo form_open('lab/labcdaftar/selesai_daftar_pemeriksaan');?>
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">

									
									<div class="form-group">
									<?php $link = site_url('lab/labcdaftar/pemeriksaan_lab/').$no_register;
									if($roleid==11 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary">
											Selesai
											</button>	';
										}else{
											echo '
											<button onclick="closepage()" class="btn btn-primary" >Close</button>
											
										';
										}
										
									} 
									
									?>
									 if($roleid<>11 or $roleid==1){
										echo '
											<button onclick="closepage()" class="btn btn-primary">Close</button>
										';
									} 
														
								<?php echo form_close(); ?>
							<?php }else{ ?>
								<?php echo form_open('lab/labcdaftar/selesai_daftar_pemeriksaan');?> 
								<form action="<?php echo base_url().'lab/labcdaftar/selesai_daftar_pemeriksaan'; ?>" method="post" target="_blank">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">

									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">

									
									<div class="form-group">
									<?php $link = site_url('lab/labcdaftar/pemeriksaan_lab/').$no_register;
									if($roleid==11 or $roleid==1){
										if($cara_bayar != null || $cara_bayar != ''){
											echo '<button class="btn btn-primary" onclick="showswal()">
											Selesai & Cetak
											</button>	';
										}else{
											echo '
											<button onclick="closepage()" class="btn btn-primary" >Close</button>
											
										';
										}
										
									} 
									
									?>
									if($roleid<>11 or $roleid==1){
										echo '
											<button onclick="closepage()" class="btn btn-primary">Close</button>
										';
									} 
								</form>				
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
									<select id="id_dokter" class="form-control " name="id_dokter" required="">
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
					</div> -->
					<div class="pt-2 pb-2">
						<label for="a-search">Cari Pemeriksaan</label>
						<input type="text" class="form-control custom-select" id="a-search">
					</div>

					<div class="accordion" id="accordionExample">
						<?php foreach($data_jenis_lab as $row1){ ?>
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
														
															if($row1->kode_jenis==$row2->idpok2){
																
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
									foreach($data_jenis_lab as $row1){
										echo '
											<div class="form-group row">
												<p class="col-sm-12 form-control-label" id="nmdokter"><b>'.$row1->nama_jenis.'</b></p>
											';
										foreach($tindakan as $row2){
											
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
				<div class="form-group" style="position: absolute;left: 0;margin-left: 20px;">
					<!-- <label for="cito"><b>Cito</b></label><input type="checkbox" name="cito" id="cito" value="1"> -->
				</div>
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

<script type="text/javascript">
	$(function (){
		$('[data-toggle="tooltip"]').tooltip();
	});
	$("#popover").popover('show');;
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
	
	function cetak(){
		window.open("<?=base_url('lab/labcdaftar')?>", "_blank");
	}

</script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 