<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
//   var_dump($data_pasien_daftar_ulang->id_poli);
?> 
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">

<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script> 
<style type="text/css">
.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
    border: 1px solid #dad55e;
    background: #fffa90;
    color: #777620;
    font-weight: normal;
}
.ui-widget-content {    
  font-size: 15px;
}
.ui-widget-content .ui-state-active {    
  font-size: 15px;
}
.ui-autocomplete-loading {
  background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
}	
.ui-autocomplete { max-height: 270px; overflow-y: scroll; overflow-x: scroll;}
</style>
<script type='text/javascript'>
	var site = "<?php echo site_url(); ?>";
    var base = "<?php echo base_url() ?>";
	var table=null;
	var idok="<?php echo $id?>";
	var noregister="<?php echo $no_register?>";
	var idpoli="<?php echo isset($data_pasien_daftar_ulang->id_poli)?$data_pasien_daftar_ulang->id_poli:''?>";
	console.log(idpoli);
	$(document).ready(function() {
		$('.clockpicker').clockpicker({
        	donetext: 'Done',
    	}).find('input').change(function() {
        	console.log(this.value);
    	});
       	// $('#tgl_jadwal_ok').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });
		$('#id_dokter').select2();
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

		
		
			$('#no_register_show').val("<?php echo $no_register?>");
			$('#no_register').val("<?php echo $no_register?>");
			$('#type_rawat').val("<?php echo $type_rawat;?>").change();
	
	  	

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
console.log(idok);
	     	var formData = new FormData( $("#formdetailok")[0] );
			var noreg = '<?php echo $no_register; ?>';
		    $.ajax({
				url: site+'ok/okcdaftar/save_detailok',
				type : 'POST', 
				data : formData,
				async : false,
				cache : false,
				contentType : false,
				processData : false,	     		
				success: function(data){
					 swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
							showConfirmButton:false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: false,

								willClose: () => {
								window.location.reload();
								}
                        });
					if(idok!=''){
						get_operasi_header(idok);
						//window.location.reload();
						if(noregister.substr(0,2) == 'RI') {
							window.open(base+'iri/rictindakan/index/'+noregister,'_self')
						} else if(noreg.substr(0,2) == 'RJ') {
							if(idpoli == 'BA00') {
								window.open(base+'ird/rdcpelayananfdokter/pelayanan_tindakan/BA00/'+noregister,'_self')
							} else {
								window.open(base+'irj/rjcpelayananfdokter/pelayanan_tindakan/'+idpoli+'/'+noregister,'_self')
							}
						}
					}else{
						get_operasi_header(data);
						idok=data;
						$("#idoperasi_header_detail").val(data);
						$("#idoperasi_header_item").val(data);
						$("#idoperasi_header_finish").val(data);
						$('#tindakan').show();
	   	 				$('#tindakan2').show();
							window.location.reload();
							// window.open(base+'irj/rjcpelayananfdokter/pelayanan_tindakan/'+idpoli+'/'+noregister,'_self')
					}
						
					},
	
			    });
	        }
	    });

		var v01 = $("#formitemok").validate({
	      rules: {
	        idtindakan: {
	          required: false
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
						tableitem();
						$("#btn-simpan").html('Simpan');
					},
				error: function(){
						alert("error");
					}
			    });
	        }
	    });

		// tableitem("<?php echo $id?>");

		
		$('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>ok/okcdaftar/edit_jam_operasi",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Jam';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            if (data = true) {        
              swal({
                            title: "Selesai",
                            text: "Data berhasil diperbaharui",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
							willClose: () => {
                            window.location.reload();
                        }
                        },
                        function () {
                            window.location.reload();
                        });
            } else {
              swal("Error","Data gagal diperbaharui.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Poli';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });


		
	});

	function tableitem(){
	var no_ok = $('#idoperasi_header_finish').val(); 
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>ok/okcdaftar/get_itempemeriksaan/"+no_ok,
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
				console.log(data);
				$('#biaya_ok').val(data);//.total_tarif);
				$('#biaya_ok_hide').val(data);//.total_tarif);
				//$('#jasa_rs').val(data.jasa_rs);
				// $('#jasa_paramedis').val(data.jasa_paramedis);
				// $('#jasa_anastesi').val(data.jasa_anastesi);
				// $('#jasa_asistensi').val(data.jasa_asistensi);
				// $('#jasa_dr').val(data.jasa_dr);
				// $('#bmhp').val(data.tarid_alkes);
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
			$('#jasa_rs').val(0);
			$('#jasa_paramedis').val(0);
			$('#jasa_anastesi').val(0);
			$('#jasa_asistensi').val(0);
			$('#jasa_dr').val(0);
			$('#bmhp').val(0);
			$('#qty').val('1');
			set_total();
		}
	}

	function get_operasi_header(id) {
		$.ajax({
			type:'GET',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_operasi_header_jadwal')?>"+'/'+id,			
			success: function(data){
				if(data.no_register==null){
					$('#no_register_show').val(data.no_reservasi);
					$('#no_reservasi').val(data.no_reservasi);			
				}else{
					$('#no_register_show').val(data.no_register);
					$('#no_register').val(data.no_register);
				}

				if(data.pasien_tunda=='' || data.pasien_tunda==null){
					$('#tgl_jadwal_ok').val(data.tgl_jadwal_ok);
				}else{
					$('#tgl_jadwal_ok').val(data.tgl_jadwal_ok_tunda);
				}

				if(data.pasien_tunda=='' || data.pasien_tunda==null){
					$('#intime_jadwal_ok').val(data.intime_jadwal_ok);
				}else{
					$('#intime_jadwal_ok').val(data.intime_jadwal_ok_tunda);
				}

				
				$('#type_rawat').val(data.type_rawat).change();
				$('#id_dokter').val(data.id_dokter).change();
				$('#idkamar_operasi').val(data.idkamar_operasi).change();
				
				
				$('#prioritas').val(data.prioritas).change();
				$('#cari_diag').val(data.id_diagnosa+'--'+data.nama_diagnosa).change();
				$('#ket').val(data.ket);
			},
			error: function(){
				// alert("error");
			}
	    });
	}

	function set_total() {
		if ($("#biaya_tambahan_ok").val()=='') {
			tamb=0;
		}else{
			tamb= parseInt($("#biaya_tambahan_ok").val());
		}	
		var total = ( $("#biaya_ok").val() * $("#qty").val() ) +tamb ;
		var jasa_rs = $("#jasa_rs").val() * $("#qty").val();
		var jasa_paramedis = $("#jasa_paramedis").val() * $("#qty").val();
		var jasa_anastesi = $("#jasa_anastesi").val() * $("#qty").val();
		var jasa_asistensi = $("#jasa_asistensi").val() * $("#qty").val();
		var jasa_dr = $("#jasa_dr").val() * $("#qty").val();
		var bmhp = $("#bmhp").val() * $("#qty").val();
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
		$('#jasa_rs').val(jasa_rs);
		$('#jasa_paramedis').val(jasa_paramedis);
		$('#jasa_anastesi').val(jasa_anastesi);
		$('#jasa_asistensi').val(jasa_asistensi);
		$('#jasa_dr').val(jasa_dr);
		$('#bmhp').val(bmhp);
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
	           		tableitem();
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

    function set_dokter_joki(value) {
    	var dokter_dpjp = $('#id_dokter').val();
    	if (dokter_dpjp != value) {
    		$('#dok_joki').html('Dokter Joki');
    	}else{
    		$('#dok_joki').html('');
    	}
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
								<input type="hidden" class="form-control" name="idok" id="idok" value="<?= $id ?>">

							<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="no_register_lbl">No Reg/Reservasi</p>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_register_show" id="no_register_show" placeholder="No Reg/Reservasi" disabled>					
								</div>
							</div>

							<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="type_rawat_lbl">Type Rawat</p>
									<div class="col-sm-8">
												<select id="type_rawat" class="form-control " name="type_rawat">
													<option value="" >-Pilih Tipe Rawat-</option>
													<option value="ruangrawat">IRI</option>
													<option value="rawatjalan">IRJ</option>
												</select>
									</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="nmdokter">Dokter *</p>
								<div class="col-sm-8">
											<select id="id_dokter" class="form-control select2" name="id_dokter"  required>
												<option value="" disabled selected="">-Pilih Dokter-</option>
												<?php 
													foreach($dokter as $row){
														echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.' '.'-'.' '.$row->ket.'</option>';
													}
												?>
											</select>											
								</div>
							</div>
							<?php if ($idrg != 'IGD (Intalasi Gawat Darurat)'){ ?>
							<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="prioritas_lbl">Prioritas *</p>
								<div class="col-sm-8">
									
										<select id="prioritas" class="form-control " name="prioritas"  required>
											<option value="" >-Pilih Prioritas-</option>
											<option value="elektif" selected="selected">Elektif</option>
											<option value="cito">Cito</option>
											<option value="ods">ODS</option>
											<option value="local">Lokal Anastesi</option>
										</select>
								</div>
							</div>
							<?php } else {?>	
								<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="prioritas_lbl">Prioritas *</p>
								<div class="col-sm-8">
									
										<select id="prioritas" class="form-control " name="prioritas"  required>
											<option value="" >-Pilih Prioritas-</option>
											<option value="elektif">Elektif</option>
											<option value="cito" selected="selected">Cito</option>
										</select>
								</div>
							</div>
							<?php } ?>							
							<div class="form-group row">
								<p class="col-sm-3 form-control-label" id="nmdokter">Tanggal Operasi *</p>
								<div class="col-sm-7">
									<div class="form-inline">
										<div class="form-group">
							                <div class=' date' >
												<input type="date" id="tgl_jadwal_ok" class="form-control" placeholder="Tanggal Operasi" name="tgl_jadwal_ok" required="">
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
								<p class="col-sm-2 form-control-label" id="">Diagnosa</p>
								<div class="col-sm-8">
									<input type="text" class="form-control custom-select" id="cari_diag" name="cari_diag" placeholder="Pencarian Diagnosa">
									<input type="hidden" name="id_diagnosa" id="id_diagnosa">
																	
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
								<!-- <a href="<?php // echo site_url("iri/rictindakan/form/operasi/".$no_register); ?>"class="btn btn-primary">Kembali</a>&nbsp; -->
									<button type="reset" class="btn btn-danger">Reset</button>&nbsp;
									<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;
									<button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#editModal" onclick="edit_tgl_operasi('<?php echo $id;?>')">Tunda</button>
								</div>
							</div>
		
						</div>
						</form>
						<div>
						<form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="collapse" id="editModal" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Edit Jadwal Operasi</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>

                <div class="modal-body">
                  <div class="form-group row">

							<div class="col-sm-1"></div>
							<div class="col-sm-8">
								<input type="hidden" class="form-control" name="idoperasi_header" id="idoperasi_header" value="<?php echo $id;?>">
							</div>

							<div class="form-group row">
								<p class="col-sm-4 form-control-label" id="tgl_operasi" style="margin-left:20px">Tanggal Operasi</p>
								<div class="col-sm-6">
									<div class="form-inline">
										<div class="form-group">

							                <div class=' date'>
												<input type="date" id="tgl_jadwal_ok_tunda" class="form-control" placeholder="Tanggal Operasi" name="tgl_jadwal_ok_tunda">
											</div>&nbsp;

							                <div class='input-group clockpicker' >
												<input type="text" id="intime_jadwal_ok_tunda" class="form-control" placeholder="Jam Masuk Operasi" name="intime_jadwal_ok_tunda">
												<span class="input-group-addon">
							                    <span class="fa fa-clock-o"></span>
							                    </span>
											</div>
										</div>
							            
									</div>
								</div>
							</div>
                </div>                                
		              
                  
                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                </div>
				
              </div>
            </div>
          </div>
          </form>		
						</div>

						<!-- table -->
								
								</div>
								<br>
							
								</div>																			
							</div>			
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
tableitem();
$(function() {
		$('#cari_diag').autocomplete({
			source : function( request, response ) {
				$.ajax({
					url: '<?php echo site_url()?>farmasi/Frmcdaftar/cari_data_diagnosawithid',
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
				$('#cari_diag').val(ui.item.id_diag+' - '+ui.item.nama);
				$('#id_diagnosa').val(ui.item.id_diag); 
			}
		});
})
	function cetak(){
		// var no_ok = $('#idoperasi_header_finish').val(); 
		var no_ok = $('#idoperasi_header_finish').val(); 
		
		var myWindow = window.open("<?php echo base_url('ok/okcdaftar/cetak_faktur')?>/"+no_ok+"/", "", "width=200,height=100");
		myWindow.focus();
	}
</script>