<?php
	if ($role_id == 1) {
    	$this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }	
?>
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/dropify/dist/css/dropify.min.css'); ?>">
<style type="text/css">
small {
	font-size: 13.5px;
}
.demo-radio-button label{min-width:70px;margin-top: 13px;font-size: 14px;}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
}
.card-actions a {
    cursor: pointer;
    color: #ffffff;
    opacity: 1;
    padding-left: 12px;
    font-size: 14px;
}
.card .card-header {
    background: #fff;
    border-bottom: 0px;
}
.page-titles {
  	display: none;
}
</style>
<script type="text/javascript">
	var tbl_pendidikan_umum=null;
	var tbl_pendidikan_militer=null;
	var tbl_pangkat=null;
	var tbl_jabatan=null;
	var tbl_tandajasa=null;	
	
	$(function() {
		$(".select2").select2();				
		$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
		$('.year_picker').datepicker({			
			endDate: "current",
			autoclose: true,
			todayHighlight: true,
			format: "yyyy",
			viewMode: "years", 
			minViewMode: "years"		
		});  		
	});	

	
	
	$(document).ready(function(){  		
		load_data();
		$("#form_pendumum").submit(function(event) {
	      	document.getElementById("submit_pendumum").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'kepegawaian/personil/save_pendumum'; ?>",
				dataType: "JSON",
				data: $('#form_pendumum').serialize(),
				success: function(data){   
				  if (data == true) {
				    document.getElementById("submit_pendumum").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';	
				    $('#form_pendumum').trigger("reset");           
				    $('#modal_pendumum').modal('hide');
				    tbl_pendidikan_umum.ajax.reload();
				    swal("Sukses", "Data berhasil disimpan.", "success");
				  } else {
				    document.getElementById("submit_pendumum").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				    $('#modal_pendumum').modal('hide');
				    swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");           
				  }          
				},
				error:function(event, textStatus, errorThrown) { 
				  document.getElementById("submit_pendumum").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				  $('#modal_pendumum').modal('hide');
				  swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");        
				  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}
			});
	      	event.preventDefault();
	    });
	    $(".js-example-placeholder-single").select2({
		    placeholder: "Pilih Pangkat / Gol",
		    allowClear: true
		});
	    $("#form_pendmiliter").submit(function(event) {
	      	document.getElementById("submit_pendmiliter").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'kepegawaian/personil/save_pendmiliter'; ?>",
				dataType: "JSON",
				data: $('#form_pendmiliter').serialize(),
				success: function(data){   
				  if (data == true) {
				    document.getElementById("submit_pendmiliter").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';	
				    $('#form_pendmiliter').trigger("reset");           
				    $('#modal_pendmiliter').modal('hide');
				    tbl_pendidikan_militer.ajax.reload();
				    swal("Sukses", "Data berhasil disimpan.", "success");
				  } else {
				    document.getElementById("submit_pendmiliter").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				    $('#modal_pendmiliter').modal('hide');
				    swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");           
				  }          
				},
				error:function(event, textStatus, errorThrown) { 
				  document.getElementById("submit_pendmiliter").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				  $('#modal_pendmiliter').modal('hide');
				  swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");        
				  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}
			});
	      	event.preventDefault();
	    });
	    $('#modal_pendumum').on('hidden.bs.modal', function () {
		    document.getElementById("form_pendumum").reset();	
		    $('#gelar_pendumum').val('').trigger('change');	    		    
		    $('#id_pendumum').val('');		    
		    $('#method_pendumum').val('');
		});
		$('#modal_pendmiliter').on('hidden.bs.modal', function () {
		    document.getElementById("form_pendmiliter").reset();		    		    
		    $('#id_pendmiliter').val('');		    
		    $('#method_pendmiliter').val('');
		});
	    $('#modal_pangkat').on('hidden.bs.modal', function () {
		    document.getElementById("form_pangkat").reset();		    
		    $('#input_pangkat').val('').trigger('change');
		    $('#id_pangkat').val('');		    
		    $('#method_pangkat').val('');
		});
		$('#modal_jabatan').on('hidden.bs.modal', function () {
		    document.getElementById("form_jabatan").reset();
		    $('#id_jabatan').val('');		    
		    $('#method_jabatan').val('');
		});
		$('#modal_tandajasa').on('hidden.bs.modal', function () {
		    document.getElementById("form_tandajasa").reset();	
		    $('#id_tandajasa').val('');		    
		    $('#method_tandajasa').val('');	    
		});
	    $("#form_pangkat").submit(function(event) {
	      	document.getElementById("submit_pangkat").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'kepegawaian/personil/save_pangkat'; ?>",
				dataType: "JSON",
				data: $('#form_pangkat').serialize(),
				success: function(data) {   
				  if (data == true) {
				    document.getElementById("submit_pangkat").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';	
				    $('#form_pangkat').trigger("reset");           
				    $('#modal_pangkat').modal('hide');
				    tbl_pangkat.ajax.reload();
				    swal("Sukses", "Data berhasil disimpan.", "success");
				  } else {
				    document.getElementById("submit_pangkat").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				    $('#modal_pangkat').modal('hide');
				    swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");           
				  }          
				},
				error:function(event, textStatus, errorThrown) { 
				  document.getElementById("submit_pangkat").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				  $('#modal_pangkat').modal('hide');
				  swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");        
				  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}
			});
	      	event.preventDefault();
	    });
	    $("#form_jabatan").submit(function(event) {
	      	document.getElementById("submit_jabatan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'kepegawaian/personil/save_jabatan'; ?>",
				dataType: "JSON",
				data: $('#form_jabatan').serialize(),
				success: function(data){ 				
				  if (data == true) {
				    document.getElementById("submit_jabatan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';	
				    $('#form_jabatan').trigger("reset");           
				    $('#modal_jabatan').modal('hide');
				    tbl_jabatan.ajax.reload();
				    swal("Sukses", "Data berhasil disimpan.", "success");
				  } else {
				    document.getElementById("submit_jabatan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				    $('#modal_jabatan').modal('hide');
				    swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");           
				  }          
				},
				error:function(event, textStatus, errorThrown) { 
				  document.getElementById("submit_jabatan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				  $('#modal_jabatan').modal('hide');
				  swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");        
				  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}
			});
	      	event.preventDefault();
	    });
	    $("#form_tandajasa").submit(function(event) {
	      	document.getElementById("submit_tandajasa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
			$.ajax({
				type: "POST",
				url: "<?php echo base_url().'kepegawaian/personil/save_tandajasa'; ?>",
				dataType: "JSON",
				data: $('#form_tandajasa').serialize(),
				success: function(data){ 				
				  if (data == true) {
				    document.getElementById("submit_tandajasa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';	
				    $('#form_tandajasa').trigger("reset");           
				    $('#modal_tandajasa').modal('hide');
				    tbl_tandajasa.ajax.reload();
				    swal("Sukses", "Data berhasil disimpan.", "success");
				  } else {
				    document.getElementById("submit_tandajasa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				    $('#modal_tandajasa').modal('hide');
				    swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");           
				  }          
				},
				error:function(event, textStatus, errorThrown) { 
				  document.getElementById("submit_tandajasa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				  $('#modal_tandajasa').modal('hide');
				  swal("Error", "Gagal Menyimpan Data. Silahkan coba lagi.", "error");        
				  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}
			});
	      	event.preventDefault();
	    });
      	$('#form_personil').on('submit', function(e){  
           	e.preventDefault();             
           	document.getElementById("btn-update").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
	        $.ajax({  
				url:"<?php echo base_url(); ?>kepegawaian/personil/update_personil",                         
				method:"POST",  
				data:new FormData(this),  
				contentType: false,  
				cache: false,  
				processData:false,  
				success: function(data)  
				{  	
					document.getElementById("btn-update").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan Data';
					load_data();
					swal("Sukses","Data berhasil disimpan.", "success");  
				},
		        error:function(event, textStatus, errorThrown) {
		        	document.getElementById("btn-update").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan Data';
		            swal("Error","Data gagal disimpan.", "error"); 
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }  
	        });   
    	}); 
    	tbl_pendidikan_umum = $('#tbl_pendidikan_umum').DataTable({ 
			"language": {
			"emptyTable": "Data tidak ada."
			},
			"processing": true,
			"serverSide": true,
			"searching": false,
			"order": [],
			"lengthMenu": [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"ajax": {
			"url": "<?php echo site_url('kepegawaian/datatable/pendidikan_umum')?>",
			"type": "POST",
			"dataType": 'JSON',
			"data": function (data) {
			  data.id_personil = '<?php echo $data_pegawai->id; ?>';
			}        
			},
			"columnDefs": [
			{ 
			"orderable": false, //set not orderable
			"targets": [0,5] // column index 
			}
			],
	    }); 
	    tbl_pendidikan_militer = $('#tbl_pendidikan_militer').DataTable({ 
			"language": {
			"emptyTable": "Data tidak ada."
			},
			"processing": true,
			"serverSide": true,
			"searching": false,
			"order": [],
			"lengthMenu": [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"ajax": {
			"url": "<?php echo site_url('kepegawaian/datatable/pendidikan_militer')?>",
			"type": "POST",
			"dataType": 'JSON',
			"data": function (data) {
			  data.id_personil = '<?php echo $data_pegawai->id; ?>';
			}        
			},
			"columnDefs": [
			{ 
			"orderable": false, //set not orderable
			"targets": [0,3] // column index 
			}
			],
	    });
	    tbl_pangkat = $('#tbl_pangkat').DataTable({ 
			"language": {
			"emptyTable": "Data tidak ada."
			},
			"processing": true,
			"serverSide": true,
			"searching": false,
			"order": [],
			"lengthMenu": [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"ajax": {
			"url": "<?php echo site_url('kepegawaian/datatable/pangkat')?>",
			"type": "POST",
			"dataType": 'JSON',
			"data": function (data) {
			  data.id_personil = '<?php echo $data_pegawai->id; ?>';
			}        
			},
			"columnDefs": [
			{ 
			"orderable": false, //set not orderable
			"targets": [0,3] // column index 
			}
			],
	    }); 
	    tbl_jabatan = $('#tbl_jabatan').DataTable({ 
			"language": {
			"emptyTable": "Data tidak ada."
			},
			"processing": true,
			"serverSide": true,
			"searching": false,
			"order": [],
			"lengthMenu": [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"ajax": {
			"url": "<?php echo site_url('kepegawaian/datatable/jabatan')?>",
			"type": "POST",
			"dataType": 'JSON',
			"data": function (data) {
			  data.id_personil = '<?php echo $data_pegawai->id; ?>';
			}        
			},
			"columnDefs": [
			{ 
			"orderable": false, //set not orderable
			"targets": [0,3] // column index 
			}
			],
	    });
	    tbl_tandajasa = $('#tbl_tandajasa').DataTable({ 
			"language": {
			"emptyTable": "Data tidak ada."
			},
			"processing": true,
			"serverSide": true,
			"searching": false,
			"order": [],
			"lengthMenu": [
			[ 10, 25, 50, -1 ],
			[ '10 rows', '25 rows', '50 rows', 'Show all' ]
			],
			"lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
			"ajax": {
			"url": "<?php echo site_url('kepegawaian/datatable/tanda_jasa')?>",
			"type": "POST",
			"dataType": 'JSON',
			"data": function (data) {
			  data.id_personil = '<?php echo $data_pegawai->id; ?>';
			}        
			},
			"columnDefs": [
			{ 
			"orderable": false, //set not orderable
			"targets": [0,1] // column index 
			}
			],
	    });  
 	});
 	function load_data(){
	    $.ajax({
	        type: "GET",
	        url: "<?php echo base_url().'kepegawaian/personil/load_data/' . $data_pegawai->id; ?>",
	        dataType: "JSON",
	        success: function(data){
	        	var foto = '<?php echo base_url()."upload/personil/";?>'+data.foto;	 
	        	     	
	        	// document.getElementById("foto").setAttribute('data-default-file', foto); 
	        	if (data.foto == '' || data.foto == null) {	        		
	        		var drEvent = $('#foto').dropify();
					drEvent = drEvent.data('dropify');
					drEvent.resetPreview();
					drEvent.clearElement();
					$('#remove_foto').hide();
	        	} else {
	        		$("#foto").addClass('dropify');
	        		$("#foto").attr("data-default-file", foto);
	        		$('#remove_foto').show();
	        	}	        	
             	$('.dropify').dropify();       	          
	        	$('#nm_pegawai').val(data.nama);
	        	$('#nik').val(data.nik);
	        	$('#nip_nrp').val(data.nip_nrp);
	        	$('#alamat').val(data.alamat);
	        	$('#tmpt_lahir').val(data.tmpt_lahir);
	        	$('#tgl_lahir').val(data.tgl_lahir);	        	
	        	$('#phone').val(data.phone);	        	
	        	$('#agama').val(data.agama).change();
	        	// $('#pangkat').val(data.id).change();

	        	// $('#masa_pangkat').val(data.masa_pangkat);
	        	// $('#jabatan').val(data.jabatan);
	        	// $('#tmt_jabatan').val(data.tmt_jabatan);
	        	$('#tmt_masuk').val(data.tmt_masuk);
	        	// $('#lama_jabatan').val(data.lama_jabatan);
	        	$('#tmt_tni').val(data.tmt_tni);
	        	$('#masa_prajurit').val(data.masa_prajurit);
	        	$('#korps').val(data.korps);
	        	$('#tmt_fiktif').val(data.tmt_fiktif);
	        	$('#k_tk').val(data.k_tk);
	        	$('#status_rumah').val(data.status_rumah);
	        	$('#suku').val(data.suku);
				if (data.gender == 'L') {
					$('#laki_laki').prop('checked', true);
				} 
				if (data.gender == 'P') {
					$('#perempuan').prop('checked', true);
				}
				if (data.kelompok_medis == '1') {
					$('#medis').prop('checked', true);
				} 
				if (data.kelompok_medis == '2') {
					$('#paramedis').prop('checked', true);
				}	
				if (data.kelompok_medis == '3') {
					$('#apoteker').prop('checked', true);
				}	
				if (data.kelompok_medis == '4') {
					$('#non_kesehatan').prop('checked', true);
				}	          
	        },
	        error:function(event, textStatus, errorThrown) {
	            swal("Error","Load data tidak berhasil.", "error"); 
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        }
	    });
  	}

  	function add_pendumum() {
	 	$('#modal_pendumum').modal('show');
	 	$('#header_pendumum').html('Tambah Pendidikan Umum');
	}
	function edit_pendumum(id) {	 	
	 	$.ajax({
			type: "POST",
			url: "<?php echo base_url().'kepegawaian/personil/show_pendidikan/'; ?>"+id,
			dataType: "JSON",			
			success: function(data) {   
				if (data != '') {
					$('#modal_pendumum').modal('show');
		 			$('#header_pendumum').html('Edit Pendidikan Umum');	
		 			$('#id_pendumum').val(id);
	 				$('#method_pendumum').val('edit'); 	 				
	 				$('#gelar_pendumum').val(data.pendidikan).change(); 
	 				$('#tmpt_pendumum').val(data.tmpt_pendidikan); 
	 				$('#jurusan_pendumum').val(data.jurusan); 
	 				$('#thlulus_pendumum').val(data.th_lulus);    
				} else {			    
					swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");           
				}          
			},
			error:function(event, textStatus, errorThrown) { 			  
			  swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");    
			  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});	 	
	}
	function delete_pendumum(id) {	 		 	
		swal({
          title: "Hapus Data",
          text: "Hapus data tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/delete_pendidikan/'; ?>",
                    data: {"id":id,"id_personil":"<?php echo $data_pegawai->id;?>","jenis":'1'},
                    dataType: "JSON",                    
                    success: function(data){  
						if (data == true) {
							tbl_pendidikan_umum.ajax.reload();
							swal("Sukses", "Data berhasil dihapus.", "success");						  	
						} else {
							swal("Error", "Gagal Menghapus Data.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Error", "Gagal Menghapus Data.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}

	function add_pendmiliter() {
	 	$('#modal_pendmiliter').modal('show');
	 	$('#header_pendmiliter').html('Tambah Pendidikan Militer');
	}
	function edit_pendmiliter(id) {	 	
	 	$.ajax({
			type: "POST",
			url: "<?php echo base_url().'kepegawaian/personil/show_pendidikan/'; ?>"+id,
			dataType: "JSON",			
			success: function(data) {   
				if (data != '') {
					$('#modal_pendmiliter').modal('show');
		 			$('#header_pendmiliter').html('Edit Pendidikan Militer');	
		 			$('#id_pendmiliter').val(id);
	 				$('#method_pendmiliter').val('edit'); 	 				
	 				$('#gelar_pendmiliter').val(data.pendidikan).change(); 	 				
	 				$('#thlulus_pendmiliter').val(data.th_lulus);    
				} else {			    
					swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");           
				}          
			},
			error:function(event, textStatus, errorThrown) { 			  
			  swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");    
			  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});	 	
	}
	function delete_pendmiliter(id) {	 		 	
		swal({
          title: "Hapus Data",
          text: "Hapus data tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/delete_pendidikan/'; ?>",
                    data: {"id":id,"id_personil":"<?php echo $data_pegawai->id;?>","jenis":'2'},
                    dataType: "JSON",                    
                    success: function(data){  
						if (data == true) {
							tbl_pendidikan_militer.ajax.reload();
							swal("Sukses", "Data berhasil dihapus.", "success");						  	
						} else {
							swal("Error", "Gagal Menghapus Data.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Error", "Gagal Menghapus Data.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}

	function add_pangkat() {
	 	$('#modal_pangkat').modal('show');
	 	$('#header_pangkat').html('Tambah Data Pangkat');
	}
	function edit_pangkat(id) {	 	
	 	$.ajax({
			type: "POST",
			url: "<?php echo base_url().'kepegawaian/personil/show_pangkat/'; ?>"+id,
			dataType: "JSON",			
			success: function(data) {   
				if (data != '') {
					$('#modal_pangkat').modal('show');
		 			$('#header_pangkat').html('Edit Data Pangkat');	
		 			$('#id_pangkat').val(id);
	 				$('#method_pangkat').val('edit'); 		 					
	 				// $('#input_pangkat').val(data.pangkat).change();	
	 				$('#input_pangkat').val(data.id).trigger('change');			 					 				
	 				$('#tmt_pangkat').val(data.tmt_pangkat);    
				} else {			    
					swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");           
				}          
			},
			error:function(event, textStatus, errorThrown) { 			  
			  swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");    
			  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});	 	
	}
	function delete_pangkat(id) {	 		 	
		swal({
          title: "Hapus Data",
          text: "Hapus data tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/delete_pangkat'; ?>",
                    dataType: "JSON",     
                    data: {"id":id,"id_personil":"<?php echo $data_pegawai->id;?>"},               
                    success: function(data){  
						if (data == true) {
							tbl_pangkat.ajax.reload();
							swal("Sukses", "Data berhasil dihapus.", "success");						  	
						} else {
							swal("Error", "Gagal Menghapus Data.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Error", "Gagal Menghapus Data.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}

	function add_jabatan() {
	 	$('#modal_jabatan').modal('show');
	 	$('#header_jabatan').html('Tambah Data Jabatan');
	}
	function edit_jabatan(id) {	 	
	 	$.ajax({
			type: "POST",
			url: "<?php echo base_url().'kepegawaian/personil/show_jabatan/'; ?>"+id,
			dataType: "JSON",			
			success: function(data) {
			console.log(data);
				if (data != '') {
					$('#modal_jabatan').modal('show');
		 			$('#header_jabatan').html('Edit Data Jabatan');	
		 			$('#id_jabatan').val(id);
	 				$('#method_jabatan').val('edit'); 	
	 				$('#input_jabatan').val(data.jabatan); 					 					 				
	 				$('#input_tmt_jabatan').val(data.tmt_jabatan);    
				} else {			    
					swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");           
				}          
			},
			error:function(event, textStatus, errorThrown) { 			  
			  swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");    
			  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});	 	
	}
	function delete_jabatan(id) {	 		 	
		swal({
          title: "Hapus Data",
          text: "Hapus data tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/delete_jabatan/'; ?>"+id,
                    dataType: "JSON",                    
                    success: function(data){  
						if (data == true) {
							tbl_jabatan.ajax.reload();
							swal("Sukses", "Data berhasil dihapus.", "success");						  	
						} else {
							swal("Error", "Gagal Menghapus Data.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Error", "Gagal Menghapus Data.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}

	function add_tandajasa() {
	 	$('#modal_tandajasa').modal('show');
	 	$('#header_tandajasa').html('Tambah Data Tanda Jasa');
	}
	function edit_tandajasa(id) {	 	
	 	$.ajax({
			type: "POST",
			url: "<?php echo base_url().'kepegawaian/personil/show_tandajasa/'; ?>"+id,
			dataType: "JSON",			
			success: function(data) {
			console.log(data);
				if (data != '') {
					$('#modal_tandajasa').modal('show');
		 			$('#header_tandajasa').html('Edit Data Tanda Jasa');	
		 			$('#id_tandajasa').val(id);
	 				$('#method_tandajasa').val('edit'); 	
	 				$('#input_tandajasa').val(data.tanda_jasa); 					 					 					 				   
				} else {			    
					swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");           
				}          
			},
			error:function(event, textStatus, errorThrown) { 			  
			  swal("Error", "Gagal Load Data. Silahkan coba lagi.", "error");    
			  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});	 	
	}
	function delete_tandajasa(id) {	 		 	
		swal({
          title: "Hapus Data",
          text: "Hapus data tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/delete_tandajasa/'; ?>"+id,
                    dataType: "JSON",                    
                    success: function(data){  
						if (data == true) {
							tbl_tandajasa.ajax.reload();
							swal("Sukses", "Data berhasil dihapus.", "success");						  	
						} else {
							swal("Error", "Gagal Menghapus Data.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Error", "Gagal Menghapus Data.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}
	function delete_foto(id) {	 		 	
		swal({
          title: "Hapus Foto",
          text: "Hapus foto tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/remove_foto/'; ?>",
                    dataType: "JSON",  
                    data: {id:id},                    
                    success: function(data){  
						if (data == true) {											
							load_data();
							swal("Sukses", "Foto berhasil dihapus.", "success");						  	
						} else {
							swal("Error", "Gagal Menghapus Foto.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {    
                        swal("Error", "Gagal Menghapus Foto.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}
	function delete_personil(id) {			 		 	
		swal({
          title: "Hapus Data",
          text: "Hapus data tersebut?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya (hapus)",
          showCancelButton: true,
          closeOnConfirm: false,
          showLoaderOnConfirm: true,
          }, function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url().'kepegawaian/personil/delete_personil'; ?>",
                    dataType: "JSON",  
                    data: {id:id},                    
                    success: function(data){  
						if (data == true) {													
							window.location = "<?php echo base_url().'kepegawaian/personil'; ?>";						  	
						} else {											
							swal("Error", "Gagal Menghapus Data.", "error");
						}
                    },
                    error:function(event, textStatus, errorThrown) {                       				 
                        swal("Error", "Gagal Menghapus Data.", "error");
                        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                    }
                });           
        }); 	
	}
</script>
	
	<form method="POST" id="form_personil" class="form-horizontal form-material"> 
    	<div class="m-t-30">    			        
	        <div class="col-lg-12 col-xlg-12 col-md-12">	            
	            <div class="card">              	 
	            	<div class="card-header">
                        <div class="card-actions">
                        	<button class="btn btn-primary" type="submit" id="btn-update"><i class="fa fa-floppy-o"></i> Simpan Data</button>
                        	<button class="btn btn-danger" type="button" id="btn-delete" onclick="delete_personil('<?php echo $data_pegawai->id;?>')"><i class="fa fa-trash"></i> Hapus Data</button>
                            <a href="<?php echo site_url('kepegawaian/personil/cetak_kutipan').'/'.$data_pegawai->id; ?>" target="_blank" class="btn btn-warning"><i class="fa fa-print"></i> Kutipan Riwayat Hidup</a>
                        </div>
                        <h4 class="card-title m-b-0">DATA PERSONIL</h4>
                    </div>	             	
		            <div class="card-body b-t p-t-20"> 
		            	<input type="hidden" class="form-control form-control-line" name="id_personil" id="id_personil" value="<?php echo $data_pegawai->id; ?>">                    	   
		             	<div class="row">
		                 	<div class="col-md-3 col-lg-2">
		                        <center> 				                  
				                    	<input type="file" data-max-file-size="2M" data-width="150" name="foto" id="foto" data-default-file="" data-allowed-file-extensions="jpg png jpeg" data-show-remove="false"/>
				                    	<button type="button" class="btn btn-danger btn-block m-t-10" onclick="delete_foto('<?php echo $data_pegawai->id;?>')" id="remove_foto">Hapus</button>
				                	
			                    </center>
		                    </div>
		                    <div class="col-md-9">									
				                    <div class="row">
				                       	<div class="col-md-6">
				                       		<div class="form-group row">
						                        <small class="col-md-12">Nama </small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="nm_pegawai" id="nm_pegawai" value="">
						                        </div>
					                        </div>
					                        <div class="form-group row">
						                        <small class="col-md-12">NIK</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="nik" id="nik">
						                        </div>
						                    </div>
						                    <div class="form-group row">
						                        <small class="col-md-12">Alamat</small>
						                        <div class="col-md-12">
						                            <textarea rows="6" class="form-control form-control-line" name="alamat" id="alamat"></textarea>
						                        </div>
						                    </div>					                    
				                       	</div> <!-- col-md-6 -->
				                       	<div class="col-md-6">	
				                       		<div class="form-group row">
						                        <small class="col-md-12">Tempat Lahir</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="tmpt_lahir" id="tmpt_lahir">
						                        </div>
						                    </div>		                       						
						                    <div class="form-group row">
						                        <small class="col-md-12">Tanggal Lahir </small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line date_picker" name="tgl_lahir" id="tgl_lahir">
						                        </div>
						                    </div>					                    	
						                    <div class="form-group row">
						                        <small class="col-md-12">Jenis Kelamin </small>
						                        <div class="col-md-12">
						                            <div class="demo-radio-button">
														<input name="gender" type="radio" id="laki_laki" class="with-gap" value="L"/>
							                            <label for="laki_laki">Laki-Laki</label>
							                            <input name="gender" type="radio" id="perempuan" class="with-gap" value="P"/>
							                            <label for="perempuan">Perempuan</label>           		
													</div>
						                        </div>
						                    </div>	
						                    <div class="form-group row">
						                        <small class="col-md-12">Agama </small>
						                        <div class="col-md-12">
						                            <select class="form-control" style="width: 100%" name="agama" id="agama">
														<option value="">-- Pilih Agama --</option>
														<option value="ISLAM">ISLAM</option>
														<option value="KATOLIK">KATOLIK</option>
														<option value="PROTESTAN">PROTESTAN</option>
														<option value="BUDHA">BUDHA</option>
														<option value="HINDU">HINDU</option>
														<option value="KONGHUCU">KONGHUCU</option>
													</select>
						                        </div>
						                    </div>				                    				                    
				            			</div> <!-- col-md-6 -->				                                    
				                    </div>
				                
		                            		
		                    </div>
		                </div>                                  
		            </div>
		            
	            </div>
	        </div>	<!-- Column -->
	        <div class="col-lg-12 col-xlg-12 col-md-12">
	            <div class="card">
	            	<!-- Nav tabs -->
	            	<ul class="nav nav-tabs profile-tab" role="tablist">
	                	<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_lainlain" role="tab">Data Lainnya</a> </li>
	                	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_pendidikan" role="tab">Pendidikan</a> </li>
	                	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_pangkat" role="tab">Pangkat</a> </li>
	                	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_jabatan" role="tab">Jabatan</a> </li>
	                	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_tandajasa" role="tab">Tanda Jasa</a> </li>
	            	</ul>
	                <!-- Tab panes -->
	                <div class="tab-content">
	                    <div class="tab-pane active" id="tab_lainlain" role="tabpanel">
	                        <div class="card-block">                            
				                    <div class="row">
				                       	<div class="col-md-6">	
				                       		<div class="form-group row">
						                        <small class="col-md-12">NIP / NRP </small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="nip_nrp" id="nip_nrp">
						                        </div>
						                    </div>
				                       		<div class="form-group row">
						                        <small class="col-md-12">TMT Masuk</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line date_picker" name="tmt_masuk" id="tmt_masuk">
						                        </div>
					                    	</div>	
				                       		<div class="form-group row">
						                        <small class="col-md-12">Kelompok Medis</small>
						                        <div class="col-md-12">
						                            <div class="demo-radio-button">
														<input name="kelompok_medis" type="radio" id="medis" class="with-gap" value="1"/>
							                            <label for="medis">Medis</label>
							                            <input name="kelompok_medis" type="radio" id="paramedis" class="with-gap" value="2"/>
							                            <label for="paramedis">Paramedis</label>  
							                            <input name="kelompok_medis" type="radio" id="apoteker" class="with-gap" value="3"/>
							                            <label for="apoteker">Apoteker</label>
							                            <input name="kelompok_medis" type="radio" id="non_kesehatan" class="with-gap" value="4"/>
							                            <label for="non_kesehatan">Non Kesehatan</label>           		
													</div>
						                        </div>
						                    </div>		
						                    <div class="form-group row">
						                        <small class="col-md-12">No. SIP</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="no_sip" id="no_sip">
						                        </div>
						                    </div>	     
						                    <div class="form-group row">
						                        <small class="col-md-12">No. Telp</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="phone" id="phone">
						                        </div>
					                    	</div>	           									                   
					                    	<div class="form-group row">
						                       	<small class="col-md-12">Keluarga / Tanggungan Keluarga (K/TK)</small>
						                       	<div class="col-md-12">
						                           	<input type="text" class="form-control form-control-line" name="k_tk" id="k_tk">
						                       	</div>
						                   	</div>
				                       	</div> <!-- col-md-6 -->
				                       	<div class="col-md-6">					                       		
				                       		<div class="form-group row">
						                       	<small class="col-md-12">Status Rumah</small>
						                       	<div class="col-md-12">
						                           	<input type="text" class="form-control form-control-line" name="status_rumah" id="status_rumah">
						                       	</div>
						                   	</div>
				                       		<div class="form-group row">
						                       	<small class="col-md-12">TMT TNI</small>
						                       	<div class="col-md-12">
						                           	<input type="text" class="form-control form-control-line date_picker" name="tmt_tni" id="tmt_tni">
						                       	</div>
						                   	</div>
						                   	<div class="form-group row">
						                       	<small class="col-md-12">Masa Dinas Prajurit</small>
						                       	<div class="col-md-12">
						                           	<input type="text" class="form-control form-control-line" name="masa_prajurit" id="masa_prajurit">
						                       	</div>
						                   	</div>		                       						
						                   	<div class="form-group row">
						                       	<small class="col-md-12">Korps</small>
						                       	<div class="col-md-12">
						                           	<input type="text" class="form-control form-control-line" name="korps" id="korps">
						                       	</div>
						                   	</div>
						                   	<div class="form-group row">
						                        <small class="col-md-12">TMT Fiktif</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line date_picker" name="tmt_fiktif" id="tmt_fiktif">
						                        </div>
						                    </div>
						                    <div class="form-group row">
						                        <small class="col-md-12">Suku</small>
						                        <div class="col-md-12">
						                            <input type="text" class="form-control form-control-line" name="suku" id="suku">
						                        </div>
						                    </div>					                    
				                       	</div> <!-- col-md-6 -->				                                    
				                    </div>			                
	                        </div>
	                    </div>	<!-- tab lain-lain -->
	                    <div class="tab-pane" id="tab_pendidikan" role="tabpanel">                    	
	                        <div class="card-block"> 
	                        	<div class="col-md-12">   
			                        <div class="card">
			                            <div class="card-body bg-info">
			                                <h4 class="text-white card-title mb-0">Pendidikan Umum</h4>		                                
			                            </div>
			                            <div class="card-body">
			                                <div class="message-box contact-box">
			                                    <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark" onclick="add_pendumum()">+</button></h2>
			                                    <br>
			                                    <div class="table-responsive">
		                                            <table class="display nowrap table table-hover table-bordered" id="tbl_pendidikan_umum" width="100%">
		                                                <thead>
		                                                    <tr>
		                                                    	<th class="text-center">NO</th>
		                                                        <th>PENDIDIKAN</th>
		                                                        <th>ASAL PENDIDIKAN</th>
		                                                        <th>JURUSAN</th>	                 
		                                                        <th class="text-center">TAHUN LULUS</th>          
		                                                        <th class="text-center">Aksi</th>
		                                                    </tr>
		                                                </thead>
		                                                <tbody>		                                                                     
		                                                </tbody>
		                                            </table>
		                                        </div>
			                                </div>
			                            </div>
			                        </div>  
		                        </div>                  	
	                        	<div class="col-md-12">   
			                        <div class="card">
			                            <div class="card-body bg-info">
			                                <h4 class="text-white card-title mb-0">Pendidikan Militer</h4>		                                
			                            </div>
			                            <div class="card-body">
			                                <div class="message-box contact-box">
			                                    <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark" onclick="add_pendmiliter()">+</button></h2>
			                                    <br>
			                                    <div class="table-responsive">
		                                            <table class="display nowrap table table-hover table-bordered" id="tbl_pendidikan_militer" width="100%">
		                                                <thead>
		                                                    <tr>
		                                                    	<th class="text-center">NO</th>
		                                                        <th>PENDIDIKAN</th>	                 
		                                                        <th class="text-center">TAHUN LULUS</th>                
		                                                        <th class="text-center">Aksi</th>
		                                                    </tr>
		                                                </thead>
		                                                <tbody>
		                                                </tbody>
		                                            </table>
		                                        </div>
			                                </div>
			                            </div>
			                        </div>  
		                        </div> 
	                        </div>
	                    </div>	<!-- tab pendidikan -->
	                    <div class="tab-pane" id="tab_pangkat" role="tabpanel">
	                        <div class="card-block">
	                            <div class="col-md-12">   
			                        <div class="card">
			                            <div class="card-body bg-info">
			                                <h4 class="text-white card-title mb-0">Riwayat Pangkat</h4>		                                
			                            </div>
			                            <div class="card-body">
			                                <div class="message-box contact-box">
			                                    <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark" onclick="add_pangkat()">+</button></h2>
			                                    <div class="table-responsive">
		                                            <table class="display nowrap table table-hover table-bordered" id="tbl_pangkat" width="100%">
		                                                <thead>
		                                                    <tr>
		                                                    	<th class="text-center">NO</th>
		                                                    	<th>PANGKAT</th>
		                                                        <th class="text-center">TMT PANGKAT</th>
		                                                        <th class="text-center">Aksi</th>
		                                                    </tr>
		                                                </thead>
		                                                <tbody>		                                                                        
		                                                </tbody>
		                                            </table>
		                                        </div>
			                                </div>
			                            </div>
			                        </div>  
		                        </div> 
	                        </div>
	                    </div>	<!-- tab pangkat -->
	                    <div class="tab-pane" id="tab_jabatan" role="tabpanel">
	                        <div class="card-block">
	                            <div class="col-md-12">   
			                        <div class="card">
			                            <div class="card-body bg-info">
			                                <h4 class="text-white card-title mb-0">Riwayat Jabatan</h4>		                                
			                            </div>
			                            <div class="card-body">
			                                <div class="message-box contact-box">
			                                    <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark" onclick="add_jabatan()">+</button></h2>
			                                    <div class="table-responsive">
		                                            <table class="display nowrap table table-hover table-bordered" id="tbl_jabatan" width="100%">
		                                                <thead>
		                                                    <tr>
		                                                    	<th class="text-center">NO</th>
		                                                    	<th>JABATAN</th>
		                                                        <th class="text-center">TMT JABATAN</th>
		                                                        <th class="text-center">Aksi</th>
		                                                    </tr>
		                                                </thead>
		                                                <tbody>		                                                                        
		                                                </tbody>
		                                            </table>
		                                        </div>
			                                </div>
			                            </div>
			                        </div>  
		                        </div> 
	                        </div>
	                    </div>	<!-- tab jabatan -->                    
	                    <div class="tab-pane" id="tab_tandajasa" role="tabpanel">
	                        <div class="card-block">
	                            <div class="col-md-12">   
			                        <div class="card">
			                            <div class="card-body bg-info">
			                                <h4 class="text-white card-title mb-0">Riwayat Tanda Jasa</h4>		                                
			                            </div>
			                            <div class="card-body">
			                                <div class="message-box contact-box">
			                                    <h2 class="add-ct-btn"><button type="button" class="btn btn-circle btn-lg btn-success waves-effect waves-dark" onclick="add_tandajasa()">+</button></h2>
			                                    <div class="table-responsive">
		                                            <table class="display nowrap table table-hover table-bordered" id="tbl_tandajasa" width="100%">
		                                                <thead>
		                                                    <tr>
		                                                    	<th class="text-center">NO</th>
		                                                    	<th>TANDA JASA</th>
		                                                        <th class="text-center">Aksi</th>
		                                                    </tr>
		                                                </thead>
		                                                <tbody>
		                                                </tbody>
		                                            </table>
		                                        </div>
			                                </div>
			                            </div>
			                        </div>  
		                        </div> 
	                        </div>
	                    </div>	<!-- tab tanda jasa -->
	                </div>
	            </div>
	        </div> <!-- Column -->    	
    	</div>	<!-- Row -->
    </form>
	<div class="modal fade" id="modal_pendumum" role="dialog" aria-labelledby="modal_pendumum">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="header_pendumum"></h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <form id="form_pendumum">
		        <div class="modal-body">				
					<div class="box-body">	                
					  	<input type="hidden" class="form-control" name="id_pendumum" id="id_pendumum">
					  	<input type="hidden" class="form-control" name="idpersonil_pendumum" id="idpersonil_pendumum" value="<?php echo $data_pegawai->id; ?>">
					  	<input type="hidden" class="form-control" name="method_pendumum" id="method_pendumum">	              
					    <div class="form-group">
					    	<label for="gelar_pendumum" class="control-label">Pendidikan</label>
					        <select class="form-control" style="width: 100%" name="gelar_pendumum" id="gelar_pendumum" required>
								<option value="">-- Pilih Pendidikan --</option>
								<option value="S3">S3</option>
								<option value="S2">S2</option>
								<option value="S1">S1</option>
								<option value="D4">D4</option>
								<option value="D3">D3</option>
								<option value="PTTD">PTTD</option>
								<option value="SPRG">SPRG</option>
								<option value="SPAG">SPAG</option>
								<option value="SPK">SPK</option>
								<option value="SAA">SAA</option>
								<option value="SMAK">SMAK</option>
								<option value="SMK">SMK</option>
								<option value="SMA">SMA</option>					
							</select>
					    </div>                            
					    <div class="form-group">
					    	<label for="tmpt_pendumum" class="control-label">Asal Pendidikan</label><br>
					    	<input type="text" class="form-control"  name="tmpt_pendumum" id="tmpt_pendumum">	
					    </div>  
					    <div class="form-group">
					    	<label for="jurusan_pendumum" class="control-label">Jurusan</label><br>
					    	<input type="text" class="form-control"  name="jurusan_pendumum" id="jurusan_pendumum" placeholder="Jika tidak perlu kosongkan">	
					    </div> 
					    <div class="form-group">
					    	<label for="thlulus_pendumum" class="control-label">Tahun Lulus</label><br>
					    	<input type="text" class="form-control year_picker"  name="thlulus_pendumum" id="thlulus_pendumum">	
					    </div>                                                                           
					</div>				                                               
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		            <button type="submit" class="btn btn-primary" id="submit_pendumum"><i class="fa fa-floppy-o"></i> Simpan</button>
		        </div>
	        </form> 
	      </div>
	    </div>
	</div><!-- /.modal -->	
	<div class="modal fade" id="modal_pendmiliter" role="dialog" aria-labelledby="modal_pendmiliter">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="header_pendmiliter"></h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <form id="form_pendmiliter">
		        <div class="modal-body">				
					<div class="box-body">	                
					  	<input type="hidden" class="form-control" name="id_pendmiliter" id="id_pendmiliter">
					  	<input type="hidden" class="form-control" name="idpersonil_pendmiliter" id="idpersonil_pendmiliter" value="<?php echo $data_pegawai->id; ?>">
					  	<input type="hidden" class="form-control" name="method_pendmiliter" id="method_pendmiliter">	              
					    <div class="form-group">
					    	<label for="gelar_pendmiliter" class="control-label">Pendidikan</label>
					        <input type="text" class="form-control"  name="gelar_pendmiliter" id="gelar_pendmiliter" required>
					    </div>                            					    
					    <div class="form-group">
					    	<label for="thlulus_pendmiliter" class="control-label">Lulus</label><br>
					    	<input type="text" class="form-control year_picker"  name="thlulus_pendmiliter" id="thlulus_pendmiliter">	
					    </div>                                                                           
					</div>				                                               
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		            <button type="submit" class="btn btn-primary" id="submit_pendmiliter"><i class="fa fa-floppy-o"></i> Simpan</button>
		        </div>
	        </form> 
	      </div>
	    </div>
	</div><!-- /.modal -->	
	<div class="modal fade" id="modal_pangkat" role="dialog" aria-labelledby="modal_pangkat">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="header_pangkat"></h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <form id="form_pangkat">
		        <div class="modal-body">				
					<div class="box-body">	                
					  	<input type="hidden" class="form-control" name="id_pangkat" id="id_pangkat">
					  	<input type="hidden" class="form-control" name="idpersonil_pangkat" id="idpersonil_pangkat" value="<?php echo $data_pegawai->id; ?>">
					  	<input type="hidden" class="form-control" name="method_pangkat" id="method_pangkat">	              
					    <div class="form-group">
					    	<label for="input_pangkat" class="control-label">Pangkat / Gol</label>
					        <select name="input_pangkat" id="input_pangkat" class="js-example-placeholder-single js-states form-control form-control-line select2" style="width: 100%" required>
								<option value=""></option>
								<?php 
									$group = '';
									foreach($pangkat as $row){													
										if ($row->jenis != $group) {
											switch ($row->jenis) {
												case 1:
													echo '<optgroup label="TNI">';
													break;
												case 2:
													echo '<optgroup label="PNS">';
													break;
												case 3:
													echo '<optgroup label="PHL">';
													break;
											}											
										}																
										echo '<option value="'.$row->id.'">'.$row->pangkat.'</option>';	
										$group = $row->jenis;
										if ($row->jenis != $group) {
											echo '</optgroup>';
										}
									}
								?>															
							</select>
					    </div>                            					    
					    <div class="form-group">
					    	<label for="tmt_pangkat" class="control-label">TMT Pangkat</label><br>
					    	<input type="text" class="form-control date_picker"  name="tmt_pangkat" id="tmt_pangkat">	
					    </div>                                                                           
					</div>				                                               
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		            <button type="submit" class="btn btn-primary" id="submit_pangkat"><i class="fa fa-floppy-o"></i> Simpan</button>
		        </div>
	        </form> 
	      </div>
	    </div>
	</div><!-- /.modal -->	
	<div class="modal fade" id="modal_jabatan" role="dialog" aria-labelledby="modal_jabatan">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="header_jabatan"></h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <form id="form_jabatan">
		        <div class="modal-body">				
					<div class="box-body">	                
					  	<input type="hidden" class="form-control" name="id_jabatan" id="id_jabatan">
					  	<input type="hidden" class="form-control" name="idpersonil_jabatan" id="idpersonil_jabatan" value="<?php echo $data_pegawai->id; ?>">
					  	<input type="hidden" class="form-control" name="method_jabatan" id="method_jabatan">	              
					    <div class="form-group">
					    	<label for="input_jabatan" class="control-label">Jabatan</label>
					        <input type="text" class="form-control"  name="input_jabatan" id="input_jabatan" required>
					    </div>                            					    
					    <div class="form-group">
					    	<label for="input_tmt_jabatan" class="control-label">TMT Jabatan</label><br>
					    	<input type="text" class="form-control date_picker"  name="input_tmt_jabatan" id="input_tmt_jabatan">	
					    </div>                                                                           
					</div>				                                               
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		            <button type="submit" class="btn btn-primary" id="submit_jabatan"><i class="fa fa-floppy-o"></i> Simpan</button>
		        </div>
	        </form> 
	      </div>
	    </div>
	</div><!-- /.modal -->	
	<div class="modal fade" id="modal_tandajasa" role="dialog" aria-labelledby="modal_tandajasa">
	    <div class="modal-dialog" role="document">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h4 class="modal-title" id="header_tandajasa"></h4>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        </div>
	        <form id="form_tandajasa">
		        <div class="modal-body">				
					<div class="box-body">	                
					  	<input type="hidden" class="form-control" name="id_tandajasa" id="id_tandajasa">
					  	<input type="hidden" class="form-control" name="idpersonil_tandajasa" id="idpersonil_tandajasa" value="<?php echo $data_pegawai->id; ?>">
					  	<input type="hidden" class="form-control" name="method_tandajasa" id="method_tandajasa">	              
					    <div class="form-group">
					    	<label for="input_tandajasa" class="control-label">Tanda Jasa</label>
					        <input type="text" class="form-control"  name="input_tandajasa" id="input_tandajasa" required>
					    </div>                            					    					                    
					</div>				                                               
		        </div>
		        <div class="modal-footer">
		            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		            <button type="submit" class="btn btn-primary" id="submit_tandajasa"><i class="fa fa-floppy-o"></i> Simpan</button>
		        </div>
	        </form> 
	      </div>
	    </div>
	</div><!-- /.modal -->	    
	<script src="<?php echo site_url('assets/plugins/dropify/dist/js/dropify.min.js'); ?>"></script>
    <script>
    $(document).ready(function() {            
        $('.dropify').dropify();        
    });
    </script>                
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>