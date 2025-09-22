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
	var site = "<?php echo site_url(); ?>";
	var table=null;
	var idok="<?php echo $id?>";
	$(document).ready(function() {
		$('.clockpicker').clockpicker({
        	donetext: 'Done',
    	}).find('input').change(function() {
        	console.log(this.value);
    	});
       	$('#tgl_jadwal_ok').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});
	    $("#intime_jadwal_ok").timepicker({
		    showInputs: false,
		    showMeridian: false
	    });
	    if (idok!='') {
	    	$('#tindakan').show();
	   	 	$('#tindakan2').show();
	    }else {
	    $('#tindakan').hide();
	    $('#tindakan2').hide();
		}
	    $('#tabel_tindakan').DataTable();
		$("#biaya_ok").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		// $("#biaya_tambahan_ok").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});

		
		if(idok!=''){
			get_operasi_header(idok);
		}else{
			$('#no_register_show').val("<?php echo $no_register?>");
			$('#no_register').val("<?php echo $no_register?>");
			$('#type_rawat').val("<?php echo $type_rawat;?>").change();
		}
	  	

	  	var v00 = $("#formdetailok").validate({
	      rules: {
	        tgl_jadwal_ok: {
	          required: true
	        },
	        intime_jadwal_ok:{
	        	required: true
	        },
	        id_dokter:{
	        	required:true
	        },
	        // idkamar_operasi:{
	        // 	required:true
	        // },
	        type_rawat:{
	        	required:true
	        },
	        prioritas:{
	        	required:true
	        }
	      },
	    highlight: function (element) { // hightlight error inputs
	                    $(element)
	                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
	                },

	                unhighlight: function (element) { // revert the change done by hightlight
	                    $(element)
	                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
	                },
	     errorElement: "span",
	     errorClass: "help-block help-block-error",
	     submitHandler: function(form) {

	     	var formData = new FormData( $("#formdetailok")[0] );
		    $.ajax({
				type:'post',
				url: site+'ok/okcdaftar/save_detailok',
				type : 'POST', 
				data : formData,
				async : false,
				cache : false,
				contentType : false,
				processData : false,	     		
				success: function(data){
					alert("Detail Operasi berhasil disimpan");
					if(idok!=''){
						get_operasi_header(idok);
					}else{
						get_operasi_header(data);
						idok=data;
						$("#idoperasi_header_detail").val(data);
						$("#idoperasi_header_item").val(data);
						$("#idoperasi_header_finish").val(data);
						$('#tindakan').show();
	   	 				$('#tindakan2').show();

					}
						
					},
				error: function(){
						alert("error");
					}
			    });
	        }
	    });

	var v01 = $("#formitemok").validate({
	      rules: {
	        idtindakan: {
	          required: true
	        },
	        id_dokter1:{
	        	required: true
	        }	        
	      },
	    highlight: function (element) { // hightlight error inputs
	                    $(element)
	                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
	                },

	                unhighlight: function (element) { // revert the change done by hightlight
	                    $(element)
	                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
	                },
	     errorElement: "span",
	     errorClass: "help-block help-block-error",
	     submitHandler: function(form) {

	     	var formData = new FormData( $("#formitemok")[0] );
		    $.ajax({
				type:'post',
				url: site+'ok/okcdaftar/insert_pemeriksaan',
				type : 'POST', 
				data : formData,
				async : false,
				cache : false,
				contentType : false,
				processData : false,	     		
				success: function(data){
						alert("Item tindakan berhasil disimpan");
						$("#idtindakan").val('').change();
						$("#id_dokter1").val('').change();
						$("#id_pemeriksaan_ok").val('');
						tableitem(idok);
						$("#btn-simpan").html('Simpan');
					},
				error: function(){
						alert("error");
					}
			    });
	        }
	    });

		tableitem("<?php echo $id?>");
	});

	function tableitem(id){
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>ok/okcdaftar/get_itempemeriksaan/"+id,
        columns: [
            { data: "id_pemeriksaan_ok" },
            { data: "jenis_tindakan" },
            { data: "operator" },
            { data: "vtot" },
            { data: "aksi" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: true }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
    });
}
			
	function pilih_tindakan(id_tindakan) {
		if(id_tindakan!=''){
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
		}else{
			$('#biaya_ok').val(0);
			$('#biaya_ok_hide').val(0);
			$('#qty').val('1');
			set_total();
		}
	}

	function get_operasi_header(id) {
		$.ajax({
			type:'GET',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_operasi_header')?>"+'/'+id,			
			success: function(data){
				if(data.no_register==null){
					$('#no_register_show').val(data.no_reservasi);
					$('#no_reservasi').val(data.no_reservasi);			
				}else{
					$('#no_register_show').val(data.no_register);
					$('#no_register').val(data.no_register);
				}
				
				$('#type_rawat').val(data.type_rawat).change();
				$('#id_dokter').val(data.id_dokter).change();
				$('#idkamar_operasi').val(data.idkamar_operasi).change();
				$('#tgl_jadwal_ok').val(data.tgl_jadwal_ok);
				$('#intime_jadwal_ok').val(data.intime_jadwal_ok);
				$('#prioritas').val(data.prioritas).change();
				$('#ket').val(data.ket);
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function set_total() {
		if ($("#biaya_tambahan_ok").val()=='') {
			tamb=0;
		}else{
		tamb= parseInt($("#biaya_tambahan_ok").val());}
		var total = ( $("#biaya_ok").val() * $("#qty").val() ) +tamb ;	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}

  	function hapus_data_pemeriksaan(id_pemeriksaan_ok)
	{
	  if(confirm('Hapus Item Tindakan Operasi ?'))
	  {
	    // ajax delete data to database
	   	$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/hapus_data_pemeriksaan')?>/"+id_pemeriksaan_ok,
	        success: function(data)
	        {
	           //if success reload ajax table
	           if(idok!=''){
	           		tableitem(idok);
	           }
	          
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	        }
	    });
	  }
	}

	function edit_data_pemeriksaan(id_pemeriksaan_ok)
	{	  
	   	$.ajax({
			type:'GET',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_data_item_pemeriksaan')?>/"+id_pemeriksaan_ok,
	        success: function(data)
	        {	           
	           if(data!=''){
	           		//tableitem(idok);
	           		$('#id_pemeriksaan_ok').val(data.id_pemeriksaan_ok);
	           		$('#idtindakan').focus();
	           		$('#idtindakan').val(data.id_tindakan).change();
					$('#id_dokter1').val(data.id_dokter).change();
					if(data.id_dokter2!=''){
						$('#id_dokter2').val(data.id_dokter2).change();	
					}
					
					if(data.id_dokter_asist!=''){
						$('#id_dokter_asist').val(data.id_dokter_asist).change();	
					}

					if(data.perawat_anastesi!=''){
						$('#perawat_anas').val(data.perawat_anastesi).change();	
					}

					if(data.jns_anes!=''){
						$('#jns_anes').val(data.jns_anes).change();	
					}
					
					if(data.id_dok_anak!=''){
						$('#id_dok_anak').val(data.id_dok_anak).change();	
					}

					$('#qty').val(data.qty).change();
					$("#btn-simpan").html('Edit');
	           }
	          
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	            alert('Error adding / update data');
	        }
	    });	  
	}

	function closepage() {
		window.open(' ', '_self', ' '); window.close();
	}

	function pa() {
        swal({
                title: "Patologi Anatomi",
                text: "Input Data Patologi Anatomi Pasien?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                    	
                        type: "POST",
                        url: "<?=base_url('iri/rictindakan/update_rujukan_pa_ruangan')?>",
                        data: {
                            no_register: "<?php echo "$no_register"; ?>",
                            pa: "1"
                        },
                        dataType: 'text',
                        success: function (data) {
                            //if(data === 'success'){
                            window.open("<?=base_url('pa/pacdaftar/pemeriksaan_pa/'.$no_register)?>", "_blank");
                            /*}else{
                                swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                            }*/
                        }
                    });
                } else {
                    swal("Close", "Batal Input Patologi Anatomi", "error");
                }
            });
    }

    function pa2() {
        swal({
                title: "Patologi Anatomi",
                text: "Input Data Patologi Anatomi Pasien?",
                type: "warning",
                showCancelButton: true,
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya!",
                cancelButtonText: "Tidak!",
                closeOnConfirm: true,
                closeOnCancel: false
            },
            function(isConfirm){
                if (isConfirm) {
                    $.ajax({
                    	
                        type: "POST",
                        url: "<?=base_url('irj/rjcpelayanan/update_rujukan_pa_ruangan')?>",
                        data: {
                        	id_poli: "<?php echo "$idrg";?>",
                        	no_register: "<?php echo "$no_register" ?>",
                            pa: "1"
                        },
                        dataType: 'text',
                        success: function (data) {
                            //if(data === 'success'){
                            window.open("<?=base_url('pa/pacdaftar/pemeriksaan_pa/'.$no_register.'')?>", "_blank");
                            /*}else{
                                swal("Close", "Oops! Terjadi Kesalahan, silahkan hubungi IT", "error");
                            }*/
                        }
                    });
                } else {
                    swal("Close", "Batal Input Patologi Anatomi", "error");
                }
            });
    }

</script>
	<?php include('okvdatapasien.php');?>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-outline-info">	
						<div class="card-header" align="center">
							<h4 class="text-white" align="center">Detail Jadwal Operasi</h4>
						</div>
						<div class="card-block" style="display:block;overflow:auto;">

							<!-- form -->
							
							<form class="form-horizontal" method="POST" id="formdetailok">
								<div class="col-sm-10">
									<input type="hidden" class="form-control" name="no_register" id="no_register">
									<input type="hidden" class="form-control" name="no_reservasi" id="no_reservasi">
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="no_register_lbl">No Reg/Reservasi</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="no_register_show" id="no_register_show" placeholder="No Reg/Reservasi" disabled>					
									</div>
								</div>
								<div class="form-group row" hidden="true">
									<p class="col-sm-2 form-control-label" id="type_rawat_lbl">Type Rawat</p>
										<div class="col-sm-8">
													<select id="type_rawat" class="form-control js-example-basic-single" name="type_rawat">
														<option value="" >-Pilih Tipe Rawat-</option>
														<option value="ruangrawat">IRI</option>
														<option value="rawatjalan">IRJ</option>
													</select>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter *</p>
									<div class="col-sm-8">
												<select id="id_dokter" class="form-control js-example-basic-single" name="id_dokter"  required>
													<option value="" disabled selected="">-Pilih Dokter-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>											
									</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="prioritas_lbl">Prioritas *</p>
									<div class="col-sm-8">
										
											<select id="prioritas" class="form-control js-example-basic-single" name="prioritas"  required>
												<option value="" >-Pilih Prioritas-</option>
												<option value="elektif">Elektif</option>
												<option value="cito">Cito</option>
											</select>
									</div>
								</div>								
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Tanggal Operasi *</p>
									<div class="col-sm-7">
										<div class="form-inline">
											<div class="form-group">
								                <div class='input-group date' >
													<input type="text" id="tgl_jadwal_ok" class="form-control" placeholder="Tanggal Operasi" name="tgl_jadwal_ok" required="">
													<span class="input-group-addon">
								                        <span class="fa fa-calendar-o"></span>
								                    </span>
												</div>&nbsp;
								                <div class='input-group clockpicker' >
													<input type="text" id="intime_jadwal_ok" class="form-control" placeholder="Jam Masuk Operasi" name="intime_jadwal_ok" required="">
													<span class="input-group-addon">
								                        <span class="fa fa-clock-o"></span>
								                    </span>
												</div>
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
									<p class="col-sm-2 form-control-label" id="ket_lbl">Keterangan</p>
									<div class="col-sm-8">
										<!-- <div class="form-inline">
											<div class="form-group"> -->
												<input type="text" class="form-control" name="ket" id="ket" placeholder="Ex: Operasi Katarak">
											<!-- </div>
										</div> -->
									</div>
								</div>
																
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $id;?>" name="idoperasi_header" id="idoperasi_header_detail">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">									
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									<div class="form-group">
										<button type="reset" class="btn btn-danger">Reset</button>&nbsp;
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							</div>
							</form>
							<div class="col-sm-6">

							</div>

							<!-- table -->
									
									</div>
									<br>
								
									</div>																			
								</div>			
						</div>					
			
		</section>

		<section class="content" id="tindakan">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-outline-info">	
						<div class="card-header" align="center">
							<h4  align="center" class="text-white">Daftar Item Tindakan Operasi <?php echo $id; ?></h4>
						</div>
						<?php
						$reg=substr("$no_register", 0,2);
							if($reg=="RI"){
						?>
	                                <div class="card-block">
	                    				<button type="button" class="btn btn-primary" onclick="pa()"><i class="fa fa-plus"></i> Patologi Anatomi</button>
	                                </div>
                        <?php
                    		}else{
                    	?>
                    				<div class="card-block">
	                    				<button type="button" class="btn btn-primary" onclick="pa2()"><i class="fa fa-plus"></i> Patologi Anatomi</button>
	                                </div>
                    		<?php } ?>
                        <div>
                            <hr class="m-t-0">
                        </div>
						<div class="card-block" style="display:block;overflow:auto;">

							<!-- form -->
							<div class="container-fluid">
							<form class="form-horizontal" method="POST" id="formitemok">
							<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="idkamar_operasi_lbl">Kamar Operasi *</p>
									<div class="col-sm-8">
												<select id="idkamar_operasi" class="form-control js-example-basic-single" name="idkamar_operasi"  required>
													<option value="" disabled selected="">-Pilih Kamar Operasi-</option>
													<?php 
														foreach($kamarok as $row){
															echo '<option value="'.$row->idrg.'">'.$row->nmruang.'</option>';	
														}
													?>
												</select>
									</div>
							</div>
							
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="tindakan">Tindakan *</p>
										<div class="col-sm-10">
													<select id="idtindakan" class="form-control js-example-basic-single" name="idtindakan" onchange="pilih_tindakan(this.value)" required>
														<option value="" disabled selected="">-Pilih Tindakan-</option>
														<?php 
															foreach($tindakan as $row){
																echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
															}
														?>
													</select>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter 1 *</p>
									<div class="col-sm-10">
												<select id="id_dokter1" class="form-control js-example-basic-single" name="id_dokter1"  required>
													<option value="" disabled selected="">-Pilih Dokter 1-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter2">Dokter 2</p>
									<div class="col-sm-10">
												<select id="id_dokter2" class="form-control js-example-basic-single" name="id_dokter2">
													<option value="" selected="">-Pilih Dokter 2-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Asisten Dokter</p>
									<div class="col-sm-10">
											<!-- <input type="id_dokter_asist" class="form-control js-example-basic-single" name="id_dokter_asist"> -->
												<select id="id_dokter_asist" class="form-control js-example-basic-single" name="id_dokter_asist" >
													<option value="" selected="">-Pilih Asisten Dokter-</option>
													<?php 
														foreach($perawat_asisten as $row){
															echo '<option value="'.$row->id.'">'.$row->nm_perawat.'</option>';	
														}
													?> 
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter Anastesi</p>
									<div class="col-sm-10">
												<select id="id_dok_anes" class="form-control js-example-basic-single" name="id_dok_anes" >
													<option value="" selected="">-Pilih Dokter Anastesi-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="perawat_anas_label">Penata Anastesi</p>
									<div class="col-sm-6">
												<select id="perawat_anas" class="form-control js-example-basic-single" name="perawat_anas" >
													<option value="" selected="">-Pilih Penata Anastesi-</option>
													<?php 
														foreach($perawat_anastesi as $row){
															echo '<option value="'.$row->id.'">'.$row->nm_perawat.'</option>';	
														}
													?>
												</select>
											
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Jenis Anestesi</p>
									<div class="col-sm-6">
												<select id="jns_anes" class="form-control js-example-basic-single" name="jns_anes">
														<option value="">-Pilih Jenis Anestesi-</option>
														<option value="GENERAL">General/Umum</option>
														<option value="SPINAL">Spinal</option>
														<option value="LOKAL">Lokal</option>
													</select>											
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter Anak</p>
									<div class="col-sm-10">
												<select id="id_dok_anak" class="form-control js-example-basic-single" name="id_dok_anak" >
													<option value="" selected="">-Pilih Dokter Anak-</option>
													<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
														}
													?>
												</select>
									</div>
								</div>
								<!-- <div class="form-group row">
									<p class="col-sm-2 form-control-label" id="tgl_operasi_lbl">Tanggal Operasi</p>
									<div class="col-sm-10">
										<div class="form-inline">
											<div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
													<input type="text" id="jadwal_operasi" class="form-control" placeholder="Tanggal Operasi" name="jadwal_operasi" required="">
													<span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
												</div>
								                <div class='input-group bootstrap-timepicker' id='jadwal_operasi'>
													<input type="text" id="jam_jadwal_operasi" class="form-control" placeholder="Jam Operasi" name="jam_jadwal_operasi" required="">
													<span class="input-group-addon">
								                        <span class="glyphicon glyphicon-time"></span>
								                    </span>
												</div>
											</div>
								             <div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
								                    <input type='text' class="form-control" />
								                    <span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
								                </div>
								            </div>
										</div>
									</div>
								</div>-->
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_periksa">Biaya Pemeriksaan</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" value="<?php //echo $biaya_ok; ?>" name="biaya_ok" id="biaya_ok" disabled>
											<input type="hidden" class="form-control" value="" name="biaya_ok_hide" id="biaya_ok_hide">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qty">Qtyind</p>
									<div class="col-sm-3">
										<input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_total(this.value)">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_tambahan">Biaya Tambahan</p>
									<div class="col-sm-3">
										<div class="input-group">
										<span class="input-group-addon">Rp</span>
										<input type="number" class="form-control" value="<?php //echo $biaya_ok; ?>" name="biaya_tambahan_ok" id="biaya_tambahan_ok" onchange="set_total(this.value)">
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" class="form-control" name="vtot" id="vtot" disabled>
											<input type="hidden" class="form-control" value="" name="vtot_hide" id="vtot_hide">
										</div>
									</div>
								</div>
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $id;?>" name="idoperasi_header" id="idoperasi_header_item">
									<input type="hidden" class="form-control" value="<?php echo $id_item_ok;?>" name="id_pemeriksaan_ok" id="id_pemeriksaan_ok">
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
									<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunj">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									
									<div class="form-group">
										<button type="reset" class="btn btn-danger">Reset</button>&nbsp;
										<button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="content" id="tindakan2" >
			<div class="card card-block">			
			<div class="row">
				<div class="col-sm-12">	
										<table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>No</th>
												  	<th >Jenis Pemeriksaan</th>
												  	<th >Operator</th>
												  	<!-- <th>Dokter</th>
												  	<th>Operator Anestesi</th>
												  	<th>Dokter Anestesi</th>
												  	<th>Jenis Anestesi</th>
												  	<th>Dokter Anak</th> -->
												  	<th >Total Pemeriksaan</th>
												  	<th >Aksi</th>
												</tr>
											</thead>
										</table>
				</div>
			</div>
			<br>
			<p>* Klik selesai & Cetak setelah selesai operasi berlangsung</p>
			<?php if($no_register!=''){ 
									echo form_open('ok/okcdaftar/selesai_daftar_pemeriksaan');?>
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
									<input type="hidden" class="form-control" value="<?php echo $id;?>" name="idoperasi_header" id="idoperasi_header_finish">
									<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas_pasien">
									<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
									<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
									<div class="form-group">
											
										<?php $getrdrj=substr($no_register, 0,2);
										if($getrdrj=="RJ" or $getrdrj=="RI"){?>
											<button class="btn btn-primary">Selesai & Cetak</button>
											<?php }else{?>
											<button class="btn btn-primary" disabled="true">Selesai & Cetak</button>
										<?php }?>
										
									</div>	
									</div>		
								<?php
									echo form_close();
								}?>
			</div>	
		</section>

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