<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
//   var_dump($data_pasien_daftar_ulang->id_poli);
?> 
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

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
		$('#id_dokter1').select2();
		$('#id_dokter2').select2();
		$('#perawat_anas').select2();
		$('#id_dok_anes').select2();
		$('#id_dokter_asist').select2();
		$('#perawat_sek').select2();
		$('#perawat_ins').select2();
		$('#id_dok_anak').select2();
		$('#idtindakan').select2();
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
console.log(idok);
	     	var formData = new FormData( $("#formdetailok")[0] );
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
						window.location.reload();
						// window.open(base+'irj/rjcpelayananfdokter/pelayanan_tindakan/'+idpoli+'/'+noregister,'_self')
						
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

		$('#formitemok').on('submit', function(e){  
			e.preventDefault(); 
			var form = $(this).serialize();
		    $.ajax({
				type:'post',
				url: site+'ok/okcdaftar/insert_pemeriksaan',
				data : form,   		
				success: function(data){
					data = JSON.parse(data);
					if(data.code == 200){
						Swal.fire(
							'Berhasil!',
							'Data Berhasil Disimpan!',
							'success'
							)
							$("#idtindakan").val('').change();
							// $("#id_dokter1").val('').change();
							$("#id_pemeriksaan_ok").val('');
							tableitem();
							return;
					}
					Swal.fire(
						'Gagal!',
						'Data Gagal Disimpan!',
						'error'
						);
						console.log(data);
						$("#idtindakan").val('').change();
						$("#id_dokter1").val('').change();
						$("#id_pemeriksaan_ok").val('');
						tableitem();
						// $("#btn-simpan").html('Simpan');
					},
				error: function(err){
					Swal.fire(
						'Gagal!',
						'Data Gagal Disimpan!',
						'error'
						);
						console.log(err);
					}
			    });
	        
		});

		
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
		// let idtind = id_tindakan;
		// let id_tmno = idtind.split("@");
		// var  idtindakan = id_tmno[0]
		// var  tmno = id_tmno[1];
		// console.log(idtind);
		if(id_tindakan!=''){
			$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				prioritas : "<?php echo $prioritas ?>",
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
											<select id="id_dokter" class="form-control " name="id_dokter"  required>
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
											<option value="local">Lokal Anestesi</option>
											<option value="ods">ODS</option>
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
											<option value="local">Lokal Anestesi</option>
											<option value="ods">ODS</option>
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

	<?php //if ($role_id == 1|| $role_id == 9): ?>

		<?php if($tindakan_operasi == 'show'){ ?>
			<section class="content" id="tindakan">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-outline-info">	
							<div class="card-header" align="center">
								<h4  align="center" class="text-white">Daftar Item Tindakan Operasi <?php echo $id; ?></h4>
							</div>
							<?php
							$reg=substr("$no_register", 0,2);
								if($reg=="RI"){
							?>
								
							<?php
								}else{
							?>
								<div class="card-block">
									<!-- <button type="button" class="btn btn-primary" onclick="pa2()"><i class="fa fa-plus"></i> Patologi Anatomi</button> -->
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
											<select id="idkamar_operasi" class="form-control " name="idkamar_operasi"  required>
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
												<select id="idtindakan" class="form-control " name="id_tindakan" onchange="pilih_tindakan(this.value)" required>
													<option value="" disabled selected="">-Pilih Tindakan-</option>
													<?php 
														foreach($tindakan as $row){
															
																echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.' | '.$row->tmno.' | '.$row->kategory.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
												
														}
													?>
												</select>
											</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Dokter 1 *</p>
										<div class="col-sm-10">
													<select id="id_dokter1" class="form-control select2" name="id_dokter"  required onchange="set_dokter_joki(this.value)">
														<option value="" disabled selected="">-Pilih Dokter 1-</option>
														<?php 
															foreach($dokter as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.' '.'-'.' '.$row->ket.'</option>';	
															}
														?> 
													</select>
													<p id="dok_joki"></p>
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter2">Dokter 2</p>
										<div class="col-sm-10">
													<select id="id_dokter2" class="form-control select2" name="id_dokter2">
														<option value="" selected="">-Pilih Dokter 2-</option>
														<?php 
															foreach($dokter as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.' '.'-'.' '.$row->ket.'</option>';	
															}
														?>
													</select>
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Asisten Perawat</p>
										<div class="col-sm-10">
												<!-- <input type="id_dokter_asist" class="form-control " name="id_dokter_asist"> -->
													<select id="id_dokter_asist" class="form-control select2" name="id_dokter_asist" >
														<option value="" selected="">-Pilih Asisten Perawat-</option>
														<?php 
															foreach($perawat_asisten as $row){
																echo '<option value="'.$row->userid.'">'.$row->name.'</option>';	
															}
														?> 
													</select>
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Dokter Anastesi</p>
										<div class="col-sm-10">
													<select id="id_dok_anes" class="form-control select2" name="id_dok_anes" >
														<option value="" selected="">-Pilih Dokter Anastesi-</option>
														<?php 
															foreach($dokter as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.' '.'-'.' '.$row->ket.'</option>';	
															}
														?>
													</select>
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="perawat_anas_label">Penata Anastesi</p>
										<div class="col-sm-6">
													<select id="perawat_anas" class="form-control select2" name="perawat_anastesi" >
														<option value="" selected="">-Pilih Penata Anastesi-</option>
														<?php 
															foreach($perawat_asisten as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->name.'</option>';	
															}
														?>
													</select>
												
										</div>
									</div>
<!-- addedd -->
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="perawat_sek_label">Perawat Sekuler</p>
										<div class="col-sm-6">
													<select id="perawat_sek" class="form-control select2" name="perawat_sek" >
														<option value="" selected="">-Pilih Perawat Sekuler-</option>
														<?php 
															foreach($perawat_asisten as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->name.'</option>';	
															}
														?>
													</select>
												
										</div>
									</div>

									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="perawat_ins_label">Perawat Instrumen</p>
										<div class="col-sm-6">
													<select id="perawat_ins" class="form-control select2" name="perawat_ins" >
														<option value="" selected="">-Pilih Penata Anastesi-</option>
														<?php 
															foreach($perawat_asisten as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->name.'</option>';	
															}
														?>
													</select>
												
										</div>
									</div>

<!-- end added -->
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Jenis Anestesi</p>
										<div class="col-sm-6">
													<select id="jns_anes" class="form-control " name="jns_anes">
															<option value="">-Pilih Jenis Anestesi-</option>
															<option value="UMUM">Umum</option>
															<option value="SPINAL">Spinal</option>
															<option value="EPIDURAL">Epidural</option>
															<option value="LOKAL">Lokal</option>
															<option value="LAINNYA">Lain - Lain</option>
														</select>											
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Dokter Anak</p>
										<div class="col-sm-10">
													<select id="id_dok_anak" class="form-control select2" name="id_dok_anak" >
														<option value="" selected="">-Pilih Dokter Anak-</option>
														<?php 
															foreach($dokter as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.' '.'-'.' '.$row->ket.'</option>';	
															}
														?>
													</select>
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Asisten Dokter Anak</p>
										<div class="col-sm-10">
													<select id="id_dok_anak" class="form-control select2" name="id_dok_anak" >
														<option value="" selected="">-Pilih Asisten Dokter Anak-</option>
														<?php 
															foreach($dokter as $row){
																echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';	
															}
														?>
													</select>
										</div>
									</div>
							
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="lbl_biaya_periksa">Biaya Pemeriksaan</p>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control" value="<?php //echo $biaya_ok; ?>" id="biaya_ok" disabled>
												<input type="hidden" class="form-control" value="" name="biaya_ok" id="biaya_ok_hide">
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
											<input type="number" class="form-control" value="0<?php //echo $biaya_ok; ?>" name="biaya_tambahan_ok" id="biaya_tambahan_ok" onchange="set_total(this.value)">
											</div>
										</div>
									</div>
									<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
										<div class="col-sm-3">
											<div class="input-group">
												<span class="input-group-addon">Rp</span>
												<input type="text" class="form-control"  id="vtot" disabled>
												<input type="hidden" class="form-control"  name="vtot" id="vtot_hide">
											</div>
										</div>
									</div>
									
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $id;?>" name="idoperasi_header" id="idoperasi_header_item">
										<input type="hidden" class="form-control" value="<?php echo $id_item_ok;?>" name="id_pemeriksaan_ok" id="id_pemeriksaan_ok">
										<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunjungan">
										<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas">
										<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
										<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
										<input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar">
										<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xinput">


										<input type="hidden" class="form-control" value="0" name="jasa_rs" id="jasa_rs">
										<input type="hidden" class="form-control" value="0" name="jasa_paramedis" id="jasa_paramedis">
										<input type="hidden" class="form-control" value="0" name="jasa_anastesi" id="jasa_anastesi">
										<input type="hidden" class="form-control" value="0" name="jasa_asistensi" id="jasa_asistensi">
										<input type="hidden" class="form-control" value="0" name="jasa_dr" id="jasa_dr">
										<input type="hidden" class="form-control" value="0" name="bmhp" id="bmhp">
										
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
								echo form_open('ok/okcdaftar/selesai_daftar_pemeriksaan');
								// echo form_open('ok/okcdaftar/jadwal_operasi');
								?>
									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $id;?>" name="idoperasi_header" id="idoperasi_header_finish">
										<input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="kelas">
										<input type="hidden" class="form-control" value="<?php echo $idrg;?>" name="idrg">
										<input type="hidden" class="form-control" value="<?php echo $bed;?>" name="bed">
										<div class="form-group">
												
											<?php $getrdrj=substr($no_register, 0,2);
											if($getrdrj=="RJ" or $getrdrj=="RI" or $getrdrj=="PL"){?>
												<button class="btn btn-primary" onClick="cetak()" >Selesai & Cetak</button>
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
		<?php }else{ ?>	

		<?php } ?>
	<?php //endif ?>
	

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
		
		// var myWindow = window.open("<?php //echo base_url('ok/okcdaftar/cetak_faktur')?>/"+no_ok);
		// myWindow.focus();
	}
</script>