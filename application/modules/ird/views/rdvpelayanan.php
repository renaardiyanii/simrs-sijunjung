<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }

    ?> 
	<?php 
	include('script_rdvpelayanan.php');	
	
	echo $this->session->flashdata('success_msg'); 
	echo $this->session->flashdata('notification');
	?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<script type="text/javascript">

$(function() {
	$('.auto_search_poli').autocomplete({
		serviceUrl: '<?php echo site_url();?>/ird/rdcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});

	  $('#id_diagnosa').select2({
	    placeholder: 'Ketik kode atau nama diagnosa',
	    minimumInputLength: 1,
	    language: {
	      inputTooShort: function(args) {
	        return "Ketik kode atau nama diagnosa";
	      },
	      noResults: function() {
	        return "Diagnosa tidak ditemukan.";
	      },
	      searching: function() {
	        return "Searching.....";
	      }
	    },
	    ajax: {
	      type: 'GET',
	      url: '<?php echo base_url().'ird/Diagnosa/select2'; ?>',
	      dataType: 'JSON',          
	      delay: 250,
	      processResults: function (data) {            
	        return {
	          results: data
	        };
	      },
	      cache: true
	    }
	});
	

	$('#dirujuk_rj_ke_poli').hide();
	$('#pilih_dokter').hide();
	$('#div_rujukrslain').hide();
	$('#div_rujukan').hide();
	$('#div_alasan').hide();
	$('#div_rawat_di').hide();
	$('#div_puskesmas').hide();

   	// $('#date_picker').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	minDate: 0,
	// 	autoclose: true,
	// 	todayHighlight: true,
	// });
	
	//add jam kontrol ulang

	$('.clockpicker').clockpicker({
        	donetext: 'Done',
    	}).find('input').change(function() {
        	console.log(this.value);
    });

	$("#jam_kontrol_ulang").timepicker({
		    showInputs: false,
		    showMeridian: false
	});

	$("#jam_periksa").timepicker({
		    showInputs: false,
		    showMeridian: false
	});

	//end jam kontrol ulang

    // $("#date_picker").datepicker("setDate", new Date());

	var lab="<?php echo $rujukan_penunjang->lab;?>";
	var pa="<?php echo $rujukan_penunjang->pa;?>";
	var ok="<?php echo $rujukan_penunjang->ok;?>";
	var rad="<?php echo $rujukan_penunjang->rad;?>";
	var em="<?php echo $rujukan_penunjang->em;?>";
	var obat="<?php echo $rujukan_penunjang->obat;?>";
	var fisio="<?php echo $rujukan_penunjang->fisio;?>";
	
	if(lab=='1' && pa=='1' && rad=='1' && obat=='1' && fisio=='1' && ok=='1' && em == '1'){
		 document.getElementById("button_simpan_rujukan").disabled= true;
	}
	
});	

function insert_diagnosa() {
	$('#btn-diagnosa').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('ird/diagnosa/insert')?>",
        dataType: "JSON",
        data: {
          "no_register" : "<?php echo $no_register; ?>",
          "tgl_masuk" : "<?php echo $data_pasien_daftar_ulang->tgl_kunjungan; ?>",
          "diagnosa" : $('#id_diagnosa').val(),
          "diagnosa_text" : $('#diagnosa_text').val()
        },
        success: function(result) {
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	if (result.metadata.code) {            
	            if (result.metadata.code == '200') {                      
	              table_diagnosa.ajax.reload();      
	              $('#id_diagnosa').val(null).trigger('change');
	              $('#diagnosa_text').val('');
				  new Swal({
								icon: 'success',
								title: 'Diagnosa berhasil disimpan',
								showConfirmButton: false,
								timer: 1500
							});
				 
	            } else if (result.metadata.code == '422') {     
					new Swal({
								icon: 'info',
								title: 'Diagnosa sudah ada.',
								showConfirmButton: false,
								timer: 1500
							});        
	            } else {   
					new Swal({
								icon: 'info',
								title: 'Perhatian!!',
								text: result.metadata.message,
								showConfirmButton: false,
								timer: 1500
							});               
	            }                   
          	} else {
				new Swal({
								icon: 'error',
								title: 'Gagal menginput diagnosa.',
								showConfirmButton: false,
								timer: 1500
							}); 
			}      
        },
        error:function(event, textStatus, errorThrown) {  
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
			new Swal({
								icon: 'error',
								title: 'Gagal menginput diagnosa.',
								text: formatErrorMessage(event, errorThrown),
								showConfirmButton: false,
								timer: 1500
							}); 
        }
    });
}

function set_utama_diagnosa(id_diagnosa_pasien) {
    new swal({
		title: "Set Utama",
		text: "Set utama diagnosa tersebut?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Ya",
		showLoaderOnConfirm: true,
		closeOnConfirm: true                
    }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: "<?php echo site_url('ird/diagnosa/set_utama')?>",
					dataType:"JSON",
					data: {"id_diagnosa_pasien" : id_diagnosa_pasien,"no_register" : '<?php echo $no_register ?>'},
					success: function(data){                
						if (data == true) {            
						table_diagnosa.ajax.reload(); 
						new Swal({
								icon: 'success',
								title: 'Diagnosa berhasil di set menjadi utama',
								showConfirmButton: false,
								timer: 1500
							}); 
						} else {
							new Swal({
								icon: 'error',
								title: 'Gagal men-set utama diagnosa. Silahkan coba lagi.',
								showConfirmButton: false,
								timer: 1500
							});         
						}               
					},
					error:function(event, textStatus, errorThrown) {
						new Swal({
								icon: 'error',
								title: 'Gagal me-set utama',
								text: formatErrorMessage(event, errorThrown),
								showConfirmButton: false,
								timer: 1500
							});              
					},
				});
            } else if (result.isDenied) {
				new Swal({
                          icon: 'error',
                          title: 'Batal men-set Diagnosa',
                          showConfirmButton: false,
                          timer: 1500
                        });  
            }
          
    });
}

function delete_diagnosa(id) {       
    new swal({
     	title: "Hapus Diagnosa",
		text: "Hapus diagnosa tersebut?",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Ya (hapus)",
		showCancelButton: true,
		// closeOnConfirm: false,
		showLoaderOnConfirm: true	                  
    }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url().'ird/diagnosa/delete'; ?>",
					dataType: "JSON",        
					data: {"id_diagnosa_pasien" : id,"no_register" : '<?php echo $no_register ?>'},             
					success: function(data){  
						if (data == true) {
						table_diagnosa.ajax.reload();
							new Swal({
								icon: 'success',
								title: 'Diagnosa berhasil dihapus',
								showConfirmButton: false,
								timer: 1500
							}); 
						} else {
							new Swal({
								icon: 'error',
								title: 'Gagal menghapus diagnosa. Silahkan coba lagi',
								showConfirmButton: false,
								timer: 1500
							});         
						}
					},
					error:function(event, textStatus, errorThrown) { 
						new Swal({
                          icon: 'error',
                          title: 'Gagal Menghapus Data.',
                          showConfirmButton: false,
                          timer: 1500
                        });     
						toastr.error(formatErrorMessage(event, errorThrown), 'Error!');      
					}
				}); 
            } else if (result.isDenied) {
				new Swal({
                          icon: 'error',
                          title: 'Batal Hapus Diagnosa',
                          showConfirmButton: false,
                          timer: 1500
                        });  
            }
          
    });
}  



function ok_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Operasi!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ird/rdcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'ok',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#ok_refresh').load(document.URL +' #ok_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('ok/okcdaftar/pemeriksaan_ok'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("ok1").checked = false;
	  }
	});
}

function lab_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Laboratorium!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ird/rdcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'lab',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#lab_refresh').load(document.URL +' #lab_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('lab/labcdaftar/pemeriksaan_lab'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("lab1").checked = false;
	  }
	});
}

function rad_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Radiologi!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ird/rdcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'rad',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#rad_refresh').load(document.URL +' #rad_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('rad/radcdaftar/pemeriksaan_rad'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("rad1").checked = false;
	  }
	});
}

function em_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Elektromedik!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ird/rdcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'em',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#em_refresh').load(document.URL +' #em_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('em/emcdaftar/pemeriksaan_em'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("em1").checked = false;
	  }
	});
}

function pa_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Patologi Anatomi!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ird/rdcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'pa',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#pa_refresh').load(document.URL +' #pa_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('pa/pacdaftar/pemeriksaan_pa'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("pa1").checked = false;
	  }
	});
}


function pilih_ket_pulang(ket_plg){
	switch(ket_plg) {
	case 'izin_dokter':
		$('#div_rujukrslain').hide();
		$('#div_rujuk_penunjang').hide();//diubahdlu
		$('#div_rujukan').hide();
		document.getElementById("btn_simpan").value = 'Simpan';
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_alasan').hide();
		$('#div_rawat_di').hide();
		$('#id_poli_rujuk').hide();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();
		$('#div_puskesmas').hide();
		break;
	case 'DIRUJUK_RAWATINAP':
		$('#div_rujukrslain').hide();
		$('#div_rujukan').show();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_alasan').show();
		$('#id_poli_rujuk').hide();
		$('#div_puskesmas').hide();
		$('#div_rawat_di').show();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();
		break;
	case 'atas_permintaan_sendiri':
		$('#div_rujukan').hide();
		$('#div_rujuk_penunjang').hide();//diubahdlu
		$('#div_rujukrslain').hide();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_rawat_di').hide();
		$('#id_poli_rujuk').hide();
		$('#div_puskesmas').hide();
		$('#id_dokter_rujuk').hide();
		$('#div_alasan').hide();
		$('#dirujuk_ke').hide();

		break;
	case 'tindak_lanjut':
		$('#div_rujukan').hide();
		$('#div_rujukrslain').hide();
		$('#dirujuk_rj_ke_poli').hide();
		$('#div_rawat_di').hide();
		$('#pilih_dokter').hide();
		$('#div_alasan').hide();
		$('#id_poli_rujuk').hide();
		$('#div_puskesmas').hide();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();

		break;
	case 'kontrol_poli':
		$('#div_rujukan').hide();
		$('#div_rujukrslain').hide();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_alasan').hide();
		$('#div_rawat_di').hide();
		$('#div_puskesmas').hide();
		$('#id_poli_rujuk').hide();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();

		break;
	case 'Puskesmas':
		$('#div_rujukan').hide();
		$('#div_puskesmas').show();
		$('#div_rujukrslain').hide();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_rawat_di').hide();
		$('#div_alasan').hide();
		$('#id_poli_rujuk').hide();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();

		break;
	case 'rujuk_rs_lain':
		$('#div_rujukan').hide();
		$('#div_rujukrslain').show();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_alasan').show();
		$('#id_poli_rujuk').hide();
		$('#div_rawat_di').hide();
		$('#div_puskesmas').hide();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();

		
		break;
	case 'dirujuk':
		$('#div_rujukrslain').hide();
		$('#div_rujukan').hide();
		$('#dirujuk_rj_ke_poli').show();
		$('#div_rawat_di').hide();
		$('#div_puskesmas').hide();
		$('#pilih_dokter').show();
		$('#id_dokter_rujuk').show();
		$('#div_alasan').show();
		$('#id_dokter_rujuk').show();
		$('#id_poli_rujuk').show();
		$('#id_dokter_rujuk').show();
		$('#dirujuk_ke').show();

		break;
	default:
		$('#div_rujukrslain').hide();
		$('#div_rujukan').hide();
		$('#dirujuk_rj_ke_poli').hide();
		$('#div_puskesmas').hide();
		$('#pilih_dokter').hide();
		$('#div_rawat_di').hide();
		$('#div_alasan').hide();
		$('#id_poli_rujuk').hide();
		$('#id_dokter_rujuk').hide();
		$('#dirujuk_ke').hide();

		// code block
	}
	// if(ket_plg=='PULANG'){
	// 	$('#div_tgl_kontrol').show();
	// 	$('#div_jam_kontrol').show();
	// 	$('#div_rujuk_penunjang').hide();//diubahdlu
	// 	$('#dirujuk_rj_ke_poli').hide();
	// 	$('#pilih_dokter').hide();
	// 	document.getElementById("btn_simpan").value = 'Simpan';
	// } else {
	// 	$('#div_tgl_kontrol').hide();
	// 	$('#div_rujuk_penunjang').hide();
	// 	$('#div_jam_kontrol').show();
	// 	if(ket_plg=='DIRUJUK_RAWATJALAN'){
	// 		$('#dirujuk_rj_ke_poli').show();
	// 		$('#pilih_dokter').show();
	// 		document.getElementById("id_poli_rujuk").required = true;
	// 		document.getElementById("id_dokter_rujuk").required= false;
	// 		$('#div_tgl_kontrol').show();
	// 	}else{
	// 		$('#dirujuk_rj_ke_poli').hide();
	// 		$('#pilih_dokter').hide();
	// 		document.getElementById("id_poli_rujuk").required = false;
	// 		document.getElementById("id_dokter_rujuk").required= false;
	// 		//document.getElementById("btn_simpan").value = 'Simpan';
	// 	}
	// }
}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxdokter(id_poli){
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/rdcregistrasi/data_dokter_poli'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}

var ajaxku;
function stateChangedDokter(){
    var data;
	//alert(ajaxku.responseText);
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter_rujuk").innerHTML = data;
		}
    }
	
}

function cetak_resume(){
	window.open('<?php echo site_url('ird/rdcpelayanan/cetak_resume/').$data_pasien_daftar_ulang->no_cm;; ?>');
}

function update_dokter(no_register){
	var id_dokter = $('#id_dokter').val();
	var nmdokter = $('#nmdokter').val();
	$.ajax({
			type: "POST",
			url: "<?php echo base_url("ird/rdcpelayanan/update_dokter/"); ?>",
			dataType: "JSON",
			data:{
				'no_register':no_register,
				'id_dokter':id_dokter,
				'nmdokter':nmdokter
			},
			success: function(data){  
				if (data == '1') {
					new swal("Sukses", "Dokter berhasil diupdate.", "success");
					tabeltindakan(no_register);
				} else {
					new swal("Error","Gagal update. Silahkan coba lagi.", "error"); 
				}
			},
			error:function(event, textStatus, errorThrown) {    
				new swal("Error","Gagal update. Silahkan coba lagi.", "error");     
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
	});   
}
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
});	

	function validate(form){

		
		// if(form.no_identitas.value==""){
		// 	return false;
		// }
		document.getElementById("btn-simpan-pulang").disabled = true;
		document.getElementById("btn-simpan-pulang").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
		return true;
	}

	function redirectOnClick(){
		document.location ='ControllerName/ActionName';
	}

</script>
<?php echo $this->session->flashdata('pesan'); ?>

	<section class="content">
		<div class="row">
			<div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Data Pasien</h5></div>
                    <div class="card-block">
					
						<div class="row">
						
						
							<div class="table-responsive m-t-10 p-10" style="clear: both;">
						<table class="table-xs table-striped" width="100%">
						  <tbody>
						  	<tr>
								<td style="width: 38%;color:green">No. Antrian</td>
								<td style="width: 5%;">:</td>
								<td style="color:green"><b><?php echo $data_pasien_daftar_ulang->no_antrian;?></b></td>
							</tr>
							<tr>
								<td style="width: 38%;">No. RM</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->no_cm;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Nama</td>
								<td style="width: 5%;">:</td>
								<td><?php echo strtoupper($data_pasien_daftar_ulang->nama);?></td>
							</tr>
							<tr>
								<td style="width: 38%;">No. Register</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $no_register;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Tgl Lahir</td>
								<td style="width: 5%;">:</td>
								<?php 
								$interval = date_diff(date_create(),date_create($data_pasien->tgl_lahir));
								?>
								<td><?= //$interval->format("%Y tahun, %M Bulan , %d Hari"); 
								 date('d-m-Y',strtotime($data_pasien->tgl_lahir));?>
								</td>
							</tr>
							<tr>
								<td style="width: 38%;">Alamat</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->alamat;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Dokter Poli</td>
								<td style="width: 5%;">:</td>
								<td>
									<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" required>
														<option value="">-Pilih Pelaksana-</option>
														<?php 
														foreach($dokter_tindakan2 as $row){
															echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'" ';
															if($row->id_dokter==$id_dokterrawat) echo 'selected';
															echo '>'.$row->id_dokter.$row->nm_dokter.'-'.$row->ket.'</option>';
														}
														
														?>
													</select>

								<!-- <input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien_daftar_ulang->id_dokter)){echo $data_pasien_daftar_ulang->id_dokter;}?>">
								<input type="text" class="form-control form-control-sm auto_no_register_dokter m-t-5" name="nmdokter" id="nmdokter" value="<?php if(isset($data_pasien_daftar_ulang->dokter)){echo $data_pasien_daftar_ulang->dokter;}?>"> -->

								<button type="button" class="btn waves-effect waves-light btn-primary btn-xs m-b-5 m-t-5" onclick="update_dokter('<?php echo $data_pasien_daftar_ulang->no_register;?>')">Ubah Dokter</button>
								</td>
							</tr>														
							<!-- <tr>
								<td style="width: 38%;">Cara Bayar</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->cara_bayar;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Kelas</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $kelas_pasien;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Penjamin</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->nmkontraktor;?></td>
							</tr>														
							<tr>
								<td style="width: 38%;">Waktu Masuk</td>
								<td style="width: 5%;">:</td>
								<td><u><?php echo date('H:i',strtotime($data_pasien_daftar_ulang->waktu_masuk_poli));?></u></td>
							</tr>	 -->
						  </tbody>
						</table>
						
											<br/>
					<!-- <span class="input-group-btn"> -->
						<center>
						<a class="btn btn-success" href="<?php echo site_url('emedrec/c_emedrec/cetak_diagnosa_noreg/'.$data_pasien_daftar_ulang->no_register.'/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; SBPK</i> </a>&nbsp;
						<a class="btn btn-primary" href="<?php echo site_url('emedrec/c_emedrec/cetak_cppt_rawat_jalan/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik</i> </a>&nbsp;&nbsp;&nbsp;
						<a class="btn btn-success" href="<?php echo site_url('reports/PointMedika/get_cppt_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik Lama ( PointMedika )</i> </a>&nbsp;&nbsp;&nbsp;
						<a class="btn btn-success" href="<?php echo site_url('reports/PointMedika/get_assesmen_medis_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Assesment Medik Lama ( PointMedika )</i> </a>&nbsp;&nbsp;&nbsp;
					
						
						</center>
					<!-- </span> -->
					</div>
			</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php include('pulang/status_pulang.php'); ?>
<!--================================================================================================================================================================ -->
<!--============================================================== ini untuk penunjang comment dulu================================================================= -->
<!--================================================================================================================================================================ -->				
                <!-- <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Rujukan Penunjang</h5></div>
                    <div class="card-block">
					<form method="POST" id="form_rujukan" class="form-horizontal"> 
					<?php echo form_open('ird/rdcpelayanan/update_rujukan_penunjang'); ?> 
						<div class="form-group row">
							<p class="col-sm-12 form-control-label" id="label_rujukan">Rujukan Penunjang :</p>
							<div class="col-sm-12">
								<div class="form-inline">
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->ok=='1') { ?>
												<input type="checkbox" id="ok" class="filled-in" value=null checked disabled name="pa"/>
			                                    <label class="m-b-0" for="ok">Operasi <?php if($rujukan_penunjang->status_ok=='0') { echo '|
			                                     <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="ok" class="filled-in" <?php if($rujukan_penunjang->status_ok=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="ok" />
	                                    		<label class="m-b-0" for="ok">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
									 <div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->pa=='1') { ?>
												<input type="checkbox" id="pa" class="filled-in" value=null checked disabled name="pa"/>
			                                    <label class="m-b-0" for="pa">Patologi Anatomi <?php if($rujukan_penunjang->status_pa=='0') { echo '| <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="pa" class="filled-in" <?php if($rujukan_penunjang->status_pa=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="pa" />
	                                    		<label class="m-b-0" for="pa">Patologi Anatomi <?php if($rujukan_penunjang->status_pa=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div> 
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->lab=='1') { ?>
												<input type="checkbox" id="lab" class="filled-in" value=null checked disabled name="lab"/>
			                                    <label class="m-b-0" for="lab">Laboratorium <?php if($rujukan_penunjang->status_lab=='0') { echo '| <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="lab" class="filled-in" <?php if($rujukan_penunjang->status_lab=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="lab" />
	                                    		<label class="m-b-0" for="lab">Laboratorium <?php if($rujukan_penunjang->status_lab=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->rad=='1') { ?>
												<input type="checkbox" id="rad" class="filled-in" value=null checked disabled name="rad"/>
			                                    <label class="m-b-0" for="rad">Radiologi <?php if($rujukan_penunjang->status_rad=='0') { echo '| <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="rad" class="filled-in" <?php if($rujukan_penunjang->status_rad=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="rad" />
	                                    		<label class="m-b-0" for="rad">Radiologi <?php if($rujukan_penunjang->status_rad=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->obat=='1') { ?>
												<input type="checkbox" id="oabt" class="filled-in" value=null checked disabled name="obat"/>
			                                    <label class="m-b-0" for="obat">Obat <?php if($rujukan_penunjang->status_obat=='0') { echo '| <a href="'.base_url('farmasi/frmcdaftar/permintaan_obat').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="obat" class="filled-in" <?php if($rujukan_penunjang->status_obat=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="obat" />
	                                    		<label class="m-b-0" for="obat">Obat <?php if($rujukan_penunjang->status_obat=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->em=='1') { ?>
												<input type="checkbox" id="em" class="filled-in" value=null checked disabled name="em"/>
			                                    <label class="m-b-0" for="em">Elektromedik <?php if($rujukan_penunjang->status_em=='0') { echo '| <a href="'.base_url('elektromedik/emcdaftar/pemeriksaan_em').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="em" class="filled-in" <?php if($rujukan_penunjang->status_em=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="em" />
	                                    		<label class="m-b-0" for="em">Elektromedik <?php if($rujukan_penunjang->status_em=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>

								</div>
							</div>
							

							<div class="offset-sm-6 col-sm-6">

								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
								<input type="submit" class="btn btn-primary col-md-offset-1" id="button_simpan_rujukan" value="Simpan">
							</div>
						</div>			
					</form>	
					<?php echo form_close();?>
                    </div> 
                </div> -->
<!--================================================================================================================================================================ -->				
<!--============================================================== sampe sini ====================================================================================== -->				
<!--================================================================================================================================================================ -->				
            </div>
			<div class="col-md-12">
				<!-- <div class="alert alert-danger" id="diag_alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    <h4 class="text-danger"><i class="fa fa-ban"></i> DIAGNOSA UTAMA BELUM DIISI !</h4>
                </div> -->
                        <div class="card">
                        	
                            <!-- Nav tabs -->
                            <div class="table-responsive">
                            <ul class="nav nav-tabs customtab" role="tablist" style="overflow-x: scroll;">
							<?php if( $staff == 'dokter'){ ?>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_diagnosa?>" data-toggle="tab" href="#tabDiagnosa" role="tab"><span class="hidden-xs-down">Diagnosa</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_fisik?>" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-xs-down">Pemeriksaan Fisik</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_triase?>" data-toggle="tab" href="#tabTriase" role="tab"><span class="hidden-xs-down">Triase</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_assesment_medik?>" data-toggle="tab" href="#tabAssesmentMedik" role="tab"><span class="hidden-xs-down">Assesment Medik</span></a>
                                </li>
								
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_transfer_ruangan?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-xs-down">Transfer Ruangan</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_prosedur?>" data-toggle="tab" href="#tabProsedur" role="tab"><span class="hidden-xs-down">Prosedur</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_lab?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_rad?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a>
                                </li> 
								<li class="nav-item text-center"> 
									<a class="nav-link <?=$tab_em?>" data-toggle="tab" href="#tabElektromedik" role="tab"><span class="hidden-xs-down">Elektromedik</span></a>
								</li>                            
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_resep?>" data-toggle="tab" href="#tabResep" role="tab"><span class="hidden-xs-down">Resep</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_skrining_covid?>" data-toggle="tab" href="#tabSkriningCovid" role="tab"><span class="hidden-xs-down">Skrining COVID-19</span></a>
                                </li> 

								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_tindakan?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-xs-down">Tindakan</span></a>
                                </li> 
								<!-- <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_cppt?>" data-toggle="tab" href="#tabCppt" role="tab"><span class="hidden-xs-down">Evaluasi</span></a>
                                </li>  -->
								
								
                             
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a> 
                                </li>
                                
                                <!-- <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_pa?>" data-toggle="tab" href="#tabPatologi" role="tab"><span class="hidden-xs-down">Patologi Anatomi</span></a>
                                </li> -->
                                       
								
								<a class="btn btn-success btn-md" href="<?php echo site_url('emedrec/C_emedrec/cetak_asesmen_awal_keperawatan_ird/'.$data_pasien_daftar_ulang->no_register.'/'.$data_pasien_daftar_ulang->no_cm.'/'.$data_pasien_daftar_ulang->no_medrec); ?>" target="_blank">Lihat Assesment Keperawatan</i> </a>

								
							<?php } else { ?> 
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_fisik?>" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-xs-down">Pemeriksaan Fisik</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_ews?>" data-toggle="tab" href="#tabEws" role="tab"><span class="hidden-xs-down">Lembar Observasi EWS</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_assesment_keperawatan?>" data-toggle="tab" href="#tabAssesmentKeperawatan" role="tab"><span class="hidden-xs-down">Assesment Keperawatan</span></a>
                                </li>
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_cppt?>" data-toggle="tab" href="#tabCppt" role="tab"><span class="hidden-xs-down">Evaluasi</span></a>
                                </li> 
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_transfer_ruangan?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-xs-down">Transfer Ruangan</span></a>
                                </li>
								<!-- <li class="nav-item text-center"> 
                                	<a class="nav-link <?php //echo $tab_transfer_ruangan?>" data-toggle="tab" href="#tabTransferRuangan" role="tab"><span class="hidden-xs-down">Transfer Ruangan</span></a>
                                </li>  -->
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_serah_terima?>" data-toggle="tab" href="#tabSerahTerima" role="tab"><span class="hidden-xs-down">Catatan Serah Terima</span></a>
                                </li> 
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_fungsional_status?>" data-toggle="tab" href="#tabFungsionalStatus" role="tab"><span class="hidden-xs-down">Penilaian Fungsional</span></a>
                                </li> 
								<li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_tindakan?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-xs-down">Tindakan</span></a>
                                </li> 
								
							<?php }?>

								
									
                            </ul>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">
							<?php if($staff == 'dokter'){ ?>
									<div class="tab-pane <?=$tab_triase?>" id="tabTriase" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvtriase.php'); ?>
										</div>
									</div>
									
									<div class="tab-pane <?=$tab_fisik?>" id="tabFisik" role="tabpanel">
										<div class="p-20">
											<?php include('rdvformfisik.php'); ?>
										</div>
									</div>
									<div class="tab-pane <?=$tab_assesment_medik?>" id="tabAssesmentMedik" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvassesmentmedis.php'); ?>
										</div>
									</div>
									<div class="tab-pane <?=$tab_transfer_ruangan?>" id="tabTransferRuangan" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvtransferruangan.php'); ?>
										</div>
									</div>

									<div class="tab-pane <?=$tab_skrining_covid?>" id="tabSkriningCovid" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvskriningcovid.php'); ?>
										</div>
									</div>


									<div class="tab-pane p-20 <?=$tab_diagnosa?>" id="tabDiagnosa" role="tabpanel">
                                	<div class="p-20">
										<div class="form-group row">
									        <label for="id_diagnosa" class="col-3 col-form-label">Diagnosa (ICD-10)</label>
									        <div class="col-9">
									            <select class="form-control" name="id_diagnosa" id="id_diagnosa" style="width: 100%;"></select>
									        </div>
									    </div>				
										<div class="form-group row">
									        <label for="diagnosa_text" class="col-3 col-form-label">Catatan</label>
									        <div class="col-9">
									            <textarea class="form-control" name="diagnosa_text" id="diagnosa_text" cols="30" rows="5" style="resize:vertical"></textarea>
									        </div>
									    </div>           	
										<div class="form-group row">
											<div class="offset-sm-3 col-sm-9">									
												<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
												<button type="button" class="btn btn-primary" id="btn-diagnosa" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
											</div>
										</div>										
															
										<div class="table-responsive">
											<table id="table_diagnosa" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
											  	<thead>
												    <tr>
												      <th class="text-center">No</th>
												      <th>Diagnosa</th>
												      <th>Catatan</th>
												      <th class="text-center">Klasifikasi</th>
												      <th class="text-center">Aksi</th>
												    </tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div> <!-- table-responsive -->
                                    </div>
                                </div>          

								<div class="tab-pane p-20" id="tabProsedur" role="tabpanel">
                                	<div class="p-20">
                                        <?php // include('rjvformprocedure.php');  ?>
										<!-- <form class="form" id="form_add_procedure" method="post"> -->
											<div class="form-group row">
												<label for="id_procedure" class="col-3 col-form-label">Prosedur (ICD-9-CM)</label>
												<div class="col-9">
														<input type="text" class="form-control input-sm autocomplete_procedure"  name="id_procedure" id="id_procedure" style="max-width:450px;font-size:15px;">
														<input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">
												</div>
											</div>	
											<div class="form-group row">
												<label for="procedure_text" class="col-3 col-form-label" id="catatan">Catatan</label>
												<div class="col-9">
														<textarea class="form-control" name="procedure_text" id="procedure_text" cols="30" rows="5" style="resize:vertical"></textarea>
												</div>
											</div>            	
											<div class="form-group row">
												<div class="offset-sm-3 col-sm-9">	
														<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
														<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
														<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
														<input type="hidden" name="tgl_kunjungan" value="<?php echo $tgl_kunjungan;?>">
														<!-- <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button> -->
														<button type="button" class="btn btn-primary" id="btn-procedure" onclick="insert_procedure()"><i class="fa fa-floppy-o"></i> Simpan</button>								
												</div>
											</div>									
										<!-- </form> -->

										<hr>
										<div class="table-responsive">
											<table id="tabel_procedure" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>No</th>
														<th>Prosedur</th>
														<th>Catatan</th>
														<th class="text-center">Klasifikasi</th>
														<th class="text-center">Aksi</th>
													</tr>
												</thead>
												<tbody>
											
												</tbody>
											</table>
										</div>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabOperasi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_ok.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_lab?>" id="tabLaborat" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_lab.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_pa?>" id="tabPatologi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_pa.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_rad?>" id="tabRadiologi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_rad.php');  ?>
                                    </div>
                                </div> 
                                <div class="tab-pane p-20 <?=$tab_em?>" id="tabElektromedik" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_em.php');  ?>
                                    </div>
                                </div>                                
                                <div class="tab-pane p-20 <?=$tab_resep?>" id="tabResep" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_resep.php');  ?>
                                    </div>
                                </div>
									
							<?php }else{ ?>
									<div class="tab-pane <?=$tab_fisik?>" id="tabFisik" role="tabpanel">
										<div class="p-20">
											<?php include('rdvformfisik.php'); ?>
										</div>
									</div>
									<div class="tab-pane <?=$tab_ews?>" id="tabEws" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvews.php'); ?>
										</div>
									</div>
									<div class="tab-pane p-20 <?=$tab_assesment_keperawatan?>" id="tabAssesmentKeperawatan" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvassesmentkeperawatan.php') ?>
										</div>
									</div>
									<div class="tab-pane <?=$tab_transfer_ruangan?>" id="tabTransferRuangan" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvtransferruangan.php'); ?>
										</div>
									</div>

									<div class="tab-pane <?=$tab_serah_terima?>" id="tabSerahTerima" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvserahterima.php'); ?>
										</div>
									</div>
									<div class="tab-pane <?=$tab_fungsional_status?>" id="tabFungsionalStatus" role="tabpanel">
										<div class="p-20">
											<?php include('emr/rdvpenilaianstatusfungsional.php'); ?>
										</div>
									</div>
									
								
									
								<?php } ?> 

								<div class="tab-pane p-20 <?=$tab_cppt?>" id="tabCppt" role="tabpanel">
									<div class="p-20">
										<?php include('formcppt/formcppt.php');  ?>
									</div>
								</div>
							
								<div class="tab-pane p-20 <?=$tab_tindakan?>" id="tabTindakan" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rdvformtindakanajax.php');  ?>
                                    </div>
                                </div>

								
								
                            </div>
                        </div>
            </div>            
		</div>
	</section>

	<script>
	$(document).ready(function() { 
	$('#form_rujukan').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("button_simpan_rujukan").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>ird/rdcpelayanan/update_rujukan_penunjang/",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("form_rujukan").reset();
			new swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
            
            
          },
          error:function(event, textStatus, errorThrown) {
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
}); 
});


	</script>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 