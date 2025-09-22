<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?>
	<?php

	include('script_rjvpelayanan.php');


	echo $this->session->flashdata('success_msg');
	echo $this->session->flashdata('notification');

	//  var_dump($user);
	?>

	<script>
		$(document).ready(function(){
			$('#form-diagnosa-submit').on('submit', function(e){
				e.preventDefault();
				$.ajax({
				url:"<?php echo base_url(); ?>irj/diagnosa/insert_all",
				method:"POST",
				data:new FormData(this),
				contentType: false,
				cache: false,
				processData:false,
				success: function(data)
				{

					new swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true,
										willClose: () => {
											// window.location.reload();
										}
								},
								function () {
									// window.location.reload();
								});
				},
				error:function(event, textStatus, errorThrown) {
					document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					new swal("Error","Data gagal disimpan.", "error");
					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}
				});
			});
		});

	</script>

		<!-- modal -->
		<!-- -->
<div class="modal fade" id="diagnosaHistory" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<form id="form-diagnosa-submit" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">History Diagnosa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="fomr-inline row">
                        <div class="col-sm-1"></div>
                        <p class="form-control-label col-sm-2" id="nmdokter"><b>Cari </b></p>
                        <div class="col-sm-1"></div>
                        <input type="text" name="keyword" id="keyword" class="form-control col-sm-7" onkeyup="ajaxhistorysearch(this.value.toUpperCase())"  placeholder="Cari Nama Diagnosa..." style="width: 300px;"/>
                    </div>
                </div>
                    <div class="form-inline" id="id_diagnosa_history">

                    </div>
            </div>
            <div class="modal-footer">
				<input type="hidden" name="no_register" value="<?= $no_register ?>">
				<input type="hidden" name="tgl_masuk" value="<?= $data_pasien_daftar_ulang->tgl_kunjungan ?>">

                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
	</form>
    </div>
  </div>
</div>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>

<script type="text/javascript">
var id_poli = '<?= $id_poli; ?>';
var statfisik = '<?= $statfisik ?>';
var jawabankonsul = '<?= $data_pasien_daftar_ulang->no_register_lama ?>';






$(document).ready(function(){
	switch(statfisik){
		case 'show':
			// $('#tab_tindakannya').show();
			// $('#tabTindakan').hide();
			$('#tab_diagnosanya').hide();
			$('#tabDiagnosa').hide();
			$('#tab_prosedurnya').hide();
			$('#tabProsedur').hide();
			$('#tab_operasinya').hide();
			$('#tabOperasi').hide();
			$('#tab_labnya').hide();
			$('#tabLaborat').hide();
			$('#tab_radnya').hide();
			$('#tabRadiologi').hide();
			$('#tab_emnya').hide();
			$('#tabElektromedik').hide();
			$('#tab_resepnya').hide();
			$('#tabResep').hide();
			$('#tab_konsulnya').hide();
			$('#tabKonsul').hide();
			$('#tab_jawabankonsulnya').hide();
			$('#tabJawabanKonsul').hide();
			$('#tab_medikdokternya').hide();
			$('#tab_rehabnya').hide();
			$('#tab_rehabnyaanak').hide();
			$('#tab_medikdokternyaMata').hide();
			$('#tab_persetujuannya').hide();
			$('#tab_transfernya').hide();

			if(id_poli === "BG00"){
				$('#tab_gizinya').hide();

			}else if(id_poli === "BQ04"){
				$('#tab_giginya').hide();
			}else{
				$('#tab_giginya').hide();
				$('#tab_gizinya').hide();

			}
			break
		default:
			$('#tab_fisiknya').hide();
			$('#tabFisik').hide();
			$('#tabAssesmentKeperawatan').hide();
			$('#tab_assesmentkeperawatannyaMata').hide();
			$('#tab_assesmentkeperawatannya').hide();
			$('#tab_assesmentkeperawatannyabidan').hide();
			$('#tabAssesmentMedikPerawat').hide();
			$('#tab_assesmentmedikperawatnya').hide();
			if(jawabankonsul){
				$('#tab_jawabankonsulnya').show();
			}else{
				$('#tab_jawabankonsulnya').hide();
			}

			if(id_poli === "BG00"){
				$('#tab_gizinya').hide();
			}
			else if(id_poli === "BQ04"){
				$('#tab_giginya').hide();

			}else{
				$('#tab_giginya').hide();
				$('#tab_gizinya').hide();
			}
			break;
	}
});



function iricase(caseiri){
	if(caseiri=='OPERASI'){
		$('#divok').show();
	}else{
		$('#divok').hide();
	}
}

$(function() {




	$('#auto_ruang').autocomplete({
		// serviceUrl: '<?php echo base_url(); ?>/iri/ricreservasi/data_ruang',
		// onSelect: function (suggestion) {
		// 	$('#ruang').val(''+suggestion.idrg);
		// 	$('#nm_ruang').val(''+suggestion.nmruang);
		// 	//$('#kelas').val(''+suggestion.kelas);
		// }

		source : function( request, response ) {
			$.ajax({
				url: '<?php echo base_url(); ?>/iri/ricreservasi/data_ruang_2',
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
		select: function (event,ui) {
			// console.log(ui);
			$('#ruang').val(ui.item.idrg);
		}
	});
	$('.auto_search_poli').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	// $('.auto_diagnosa_pasien').autocomplete({
	//     serviceUrl: '<?php echo base_url().'iri/ricstatus/data_icd_1'; ?>',
	//     onSelect: function (suggestion) {
	//       $('#id_diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
	//       $('#diagnosa').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);

	//     }
  	// });

	$('#cari_diag').autocomplete({

		source : function( request, response ) {
			$.ajax({
				url: '<?php echo base_url()?>farmasi/Frmcdaftar/cari_data_diagnosawithid',
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
			$('#cari_diag').val(ui.item.id_diag+'-'+ui.item.nama);
			$('#id_diagnosa').val(ui.item.id_diag+'@'+ui.item.nama);
		}
	});

	// $('#id_diagnosa').select2({
	//     placeholder: 'Ketik kode atau nama diagnosa',
	//     minimumInputLength: 1,
	//     language: {
	//       inputTooShort: function(args) {
	//         return "Ketik kode atau nama diagnosa";reports/PointMedika/get_cppt_by_medrek
	//       },
	//       noResults: function() {
	//         return "Diagnosa tidak ditemukan.";
	//       },
	//       searching: function() {
	//         return "Searching.....";
	//       }
	//     },
	//     ajax: {
	//       type: 'GET',
	//       url: '<?php echo base_url().'irj/Diagnosa/select2'; ?>',
	//       dataType: 'JSON',
	//       delay: 250,
	//       processResults: function (data) {
	//         return {
	//           results: data
	//         };
	//       },
	//       cache: true
	//     }
	// });

	$('#dirujuk_rj_ke_poli').hide();
	$('#pilih_dokter').hide();
	$('#div_tgl_kontrol').hide();
	$('#div_jam_kontrol').hide();
	// $('#div_rujuk_penunjang').hide();
	// $('#dirujuk_rj_ke_poli').hide();
			// $('#pilih_dokter').hide();
			// $('#div_tgl_kontrol').show();
			// $('#div_jam_kontrol').show();
			$("#lbl_tgl_kontrol").html("Tanggal Meninggal");
			$("#lbl_jam_kontrol").html("Jam Meninggal");
			$('#div_tindak_lanjut').hide();
			$('#div_rujukan').hide();
			$('#div_prioritas').hide();
			$('#div_ruangan').hide();
			$('#div_alasan_fasilitas').hide();
			$('#div_diagnosis_awal').hide();
			$('#div_tindakan_asal').hide();
			$('#div_kesan').hide();
			$('#div_anjuran').hide();
			$('#div_catatan').hide();
			$('#div_tgl_periksa').hide();
			$('#div_jam_periksa').hide();
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
        url: "<?php echo site_url('irj/diagnosa/insert')?>",
        dataType: "JSON",
        data: {
          "no_register" : "<?php echo $no_register; ?>",
          "tgl_masuk" : "<?php echo $data_pasien_daftar_ulang->tgl_kunjungan; ?>",
          "diagnosa" : $('#id_diagnosa').val(),
          "diagnosa_text" : $('#diagnosa_text').val(),
          "cari_diag" : $('#cari_diag').val()
        },
        success: function(result) {
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	if (result.metadata.code) {

	            if (result.metadata.code == '200') {
	              table_diagnosa.ajax.reload();
					// location.reload();

	              $('#id_diagnosa').val(null).trigger('change');
	              $('#diagnosa_text').val('');
	              $('#cari_diag').val('');
				  $('#tabDiagnosa')[0].reset();
	              toastr.success('Diagnosa berhasil disimpan.', 'Sukses!');
	            } else if (result.metadata.code == '422') {
	              toastr.warning('Silahkan pilih diagnosa yang lain.', 'Diagnosa sudah ada.');
	            } else {
	              toastr.warning(result.metadata.message, 'Perhatian!!');
	            }
          	} else toastr.error('Silahkan coba kembali.', 'Gagal menginput diagnosa.');
        },
        error:function(event, textStatus, errorThrown) {
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput diagnosa.');
        }
    });
}

function set_utama_diagnosa(id_diagnosa_pasien) {
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('irj/diagnosa/set_utama')?>",
        dataType: "JSON",
        data: {"id_diagnosa_pasien" : id_diagnosa_pasien,"no_register" : '<?php echo $no_register ?>'},


        success: function(result){
          if (result) {
            new swal("Sukses", "Diagnosa berhasil di set utama.", "success");

            $('#id_procedure').val('');
            $('#procedure_text').val('');
            table_diagnosa.ajax.reload();


          }
          else{
            new swal("Error", "Gagal men-set utama Diagnosa. Silahkan coba lagi.", "error");
            table_diagnosa.ajax.reload();
          }
        },
        error:function(event, textStatus, errorThrown) {
          new swal("Gagal men-set Utama Diagnosa", textStatus, "error");
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });

}

function delete_diagnosa(id) {

	$.ajax({
        type: "POST",
		url: "<?php echo base_url().'irj/diagnosa/delete'; ?>",
        dataType: "JSON",
		data: {"id_diagnosa_pasien" : id,"no_register" : '<?php echo $no_register ?>'},

        success: function(result){
          if (result) {
            new swal("Sukses", "Diagnosa berhasil dihapus.", "success");

            $('#id_procedure').val('');
            $('#procedure_text').val('');
			table_diagnosa.ajax.reload();



          }
          else{
            new swal("Error", "Diagnosa Gagal dihapus.", "warning");
            $('#id_procedure').val('');
            $('#procedure_text').val('');
			table_diagnosa.ajax.reload();

          }
        },
        error:function(event, textStatus, errorThrown) {
          new swal("Gagal menghapus procedure", textStatus, "error");
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
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
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
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
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
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
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
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
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
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
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
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
	case 'PULANG':
		$('#div_tgl_kontrol').hide();
		$('#div_jam_kontrol').hide();
		$('#div_rujuk_penunjang').hide();//diubahdlu
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_tindak_lanjut').hide();
		document.getElementById("btn_simpan").value = 'Simpan';
		break;
	case 'KONTROL':
		$('#div_tgl_kontrol').show();
		$('#div_alasan_fasilitas').show();
		$('#div_jam_kontrol').show();
			$("#lbl_tgl_kontrol").html("Tanggal Kontrol");
			$("#lbl_jam_kontrol").html("Jam Kontrol");
		$('#div_rujuk_penunjang').hide();//diubahdlu
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		$('#div_tindak_lanjut').show();
		$('#div_diagnosis_awal').hide();
		$('#div_tindakan_asal').hide();
		$('#div_kesan').hide();
		$('#div_anjuran').hide();
		$('#div_tgl_periksa').hide();
		$('#div_jam_periksa').hide();
			$('#id_poli_rujuk').prop('required',false);
			$('#id_dokter_rujuk').prop('required',false);
			$('#kesan').prop('required',false);
			$('#anjuran').prop('required',false);
			$('#tindak_lanjut').prop('required',true);
		break;
	case 'DIRUJUK_RAWATJALAN':
		$('#dirujuk_rj_ke_poli').show();
			$('#pilih_dokter').show();
			$('#div_tgl_kontrol').hide();
			$('#div_tindak_lanjut').hide();
			$('#div_diagnosis_awal').show();
			$('#div_tindakan_asal').show();
			$('#div_kesan').hide();
			$('#div_anjuran').hide();
			$('#div_catatan').hide();
			$('#div_tgl_periksa').hide();
			$('#div_jam_periksa').hide();
				$('#id_poli_rujuk').prop('required',true);
				$('#id_dokter_rujuk').prop('required',true);
				$('#tindak_lanjut').prop('required',false);
				$('#kesan').prop('required',false);
				$('#anjuran').prop('required',false);

		break;
	case 'JAWABAN_KONSUL':
			$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			$('#div_tgl_kontrol').hide();
			$('#div_tindak_lanjut').hide();
			$('#div_diagnosis_awal').hide();
			$('#div_tindakan_asal').hide();
			$('#div_kesan').show();
			// document.getElementById("kesan").required= true;
			$('#div_anjuran').show();
			$('#div_catatan').hide();
			// document.getElementById("anjuran").required= true;
			$('#div_tgl_periksa').show();
			$('#div_jam_periksa').show();
				$('#id_poli_rujuk').prop('required',false);
				$('#id_dokter_rujuk').prop('required',false);
				$('#tindak_lanjut').prop('required',false);
				$('#kesan').prop('required',true);
				$('#anjuran').prop('required',true);
		break;
	case 'DIRUJUK_RAWATINAP':
		$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			$('#div_tindak_lanjut').show();
			$('#div_diagnosis_awal').hide();
			$('#div_tindakan_asal').hide();
			$('#div_kesan').hide();
			$('#div_rujukan').show();
			$('#div_prioritas').show();
			$('#div_ruangan').show();
			$('#div_anjuran').hide();
				$('#id_poli_rujuk').prop('required',false);
				$('#id_dokter_rujuk').prop('required',false);
				$('#tindak_lanjut').prop('required',true);
				$('#kesan').prop('required',false);
				$('#anjuran').prop('required',false);
		break;
	case 'DIRUJUK_RAWATINAP_NR':
		$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			$('#div_tindak_lanjut').show();
			$('#div_diagnosis_awal').hide();
			$('#div_tindakan_asal').hide();
			$('#div_kesan').hide();
			$('#div_rujukan').show();
			$('#div_anjuran').hide();
				$('#id_poli_rujuk').prop('required',false);
				$('#id_dokter_rujuk').prop('required',false);
				$('#tindak_lanjut').prop('required',true);
				$('#kesan').prop('required',false);
				$('#anjuran').prop('required',false);
		break;
	case 'MENINGGAL':
		$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			$('#div_tgl_kontrol').show();
			$('#div_jam_kontrol').show();
			$("#lbl_tgl_kontrol").html("Tanggal Meninggal");
			$("#lbl_jam_kontrol").html("Jam Meninggal");
			$('#div_tindak_lanjut').show();
			$('#div_diagnosis_awal').hide();
			$('#div_tindakan_asal').hide();
			$('#div_kesan').hide();
			$('#div_anjuran').hide();
			$('#div_tgl_periksa').hide();
			$('#div_jam_periksa').hide();
				$('#id_poli_rujuk').prop('required',false);
				$('#id_dokter_rujuk').prop('required',false);
				$('#tindak_lanjut').prop('required',true);
				$('#kesan').prop('required',false);
				$('#anjuran').prop('required',false);
		break;
	default:
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
function history_diagnosa(){
		ajaxku = buatajax();
		var url="<?php echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>";
		ajaxku.onreadystatechange=stateChangedHistory;
		ajaxku.open("GET",url,true);
		ajaxku.send(null);
	}

function ajaxhistorysearch(text){
	ajaxku = buatajax();
	var url="<?php echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>";
	url=url+"/"+text;
	ajaxku.onreadystatechange=stateChangedHistory;
	ajaxku.open("GET",url,true);
	ajaxku.send(null);
}


function stateChangedHistory(){
	var data;
	// alert(ajaxku.responseText);
	if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_diagnosa_history").innerHTML = data;
		}
	}

}
function ajaxdokter(id_poli){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
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
	window.open('<?php echo site_url('irj/rjcpelayanan/cetak_resume/').$data_pasien_daftar_ulang->no_cm;; ?>');
}

function update_dokter(no_register){
	var id_dokter = $('#id_dokter').val();
	var nmdokter = $('#nmdokter').val();
	$.ajax({
		type: "POST",
		url: "<?php echo base_url("irj/rjcpelayanan/update_dokter/"); ?>",
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
			// console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
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
	<section class="content">
		<div class="row">
			<div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Data Pasien</h5></div>
                    <div class="card-block">

					<div class="row">

						<!-- <div class="col-sm-12 text-center">
							<img height="90px" class="img-rounded" src="<?php
							if($data_pasien_daftar_ulang->foto==''){
								echo site_url("upload/photo/unknown.png");
							}else{
								echo site_url("upload/photo/".$data_pasien_daftar_ulang->foto);
							}
							?>">
						</div> -->
						<div class="table-responsive m-t-10 p-10" style="clear: both;">

						<table class="table-xs table-striped" width="100%">
						  <tbody>
						  	<tr>
								<td style="width: 20%;color:green">No. Antrian</td>
								<td style="width: 5%;">:</td>
								<td style="color:green"><b><?php echo $data_pasien_daftar_ulang->no_antrian;?></b></td>
							</tr>
							<tr>
								<td style="width: 20%;">No. RM</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->no_cm;?></td>
							</tr>
							<tr>
								<td style="width: 20%;">No. Register</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $no_register;?></td>
							</tr>
							<tr>
								<td style="width: 20%;">Nama</td>
								<td style="width: 5%;">:</td>
								<td><?php echo strtoupper($data_pasien_daftar_ulang->nama);?></td>
							</tr>
							<tr>
								<td style="width: 20%;">Jenis Kelamin</td>
								<td style="width: 5%;">:</td>
								<td><?php
								if($data_pasien->sex == 'L'){
									echo 'Laki - Laki';
								}else{
									echo 'Perempuan';
								}

								?>

								</td>
							</tr>
							<tr>
								<td style="width: 20%;">Tgl Lahir</td>
								<td style="width: 5%;">:</td>
								<?php
								$interval = date_diff(date_create(),date_create($data_pasien->tgl_lahir));
								?>
								<td><?= date('d-m-Y',strtotime($data_pasien->tgl_lahir)) ?></td>
							</tr>
							<tr>
								<td style="width: 20%;">Alamat</td>
								<td style="width: 5%;">:</td>
								<td><?= $data_pasien->alamat;?></td>
							</tr>


							<!-- <tr>
								<td style="width: 20%;">Gol Darah</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->goldarah;?></td>
							</tr> -->
							<!-- <tr>
								<td style="width: 20%;">Tanggal Kunjungan</td>
								<td style="width: 5%;">:</td>
								<td><?php echo date('d-m-Y',strtotime($data_pasien_daftar_ulang->tgl_kunjungan)).' | '.date('H:i:s',strtotime($data_pasien_daftar_ulang->tgl_kunjungan));?></td>
							</tr> -->
							<tr>
								<td style="width: 20%;">Dokter Poli</td>
								<td style="width: 5%;">:</td>
								<td>
									<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" required>
														<option value="">-Pilih Pelaksana-</option>
														<?php
														foreach($dokter_tindakan2 as $row){

															if($row->id_dokter==$id_dokterrawat) {
																echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'</option>';
															}else{
																echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
															}
														}

														?>
													</select>

								<!-- <input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien_daftar_ulang->id_dokter)){echo $data_pasien_daftar_ulang->id_dokter;}?>">
								<input type="text" class="form-control form-control-sm auto_no_register_dokter m-t-5" name="nmdokter" id="nmdokter" value="<?php if(isset($data_pasien_daftar_ulang->dokter)){echo $data_pasien_daftar_ulang->dokter;}?>"> -->

								<button type="button" class="btn waves-effect waves-light btn-primary btn-xs m-b-5 m-t-5" onclick="update_dokter('<?php echo $data_pasien_daftar_ulang->no_register;?>')">Ubah Dokter</button>
								</td>
							</tr>
							<!-- <tr>
								<td style="width: 20%;">Cara Bayar</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->cara_bayar;?></td>
							</tr> -->
							<!-- <tr>
								<td style="width: 20%;">Kelas</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $kelas_pasien;?></td>
							</tr>
							<tr>
								<td style="width: 20%;">Penjamin</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->nmkontraktor;?></td>
							</tr>
							<tr>
								<td style="width: 20%;">Waktu Masuk</td>
								<td style="width: 5%;">:</td>
								<td><u><?php echo date('H:i',strtotime($data_pasien_daftar_ulang->waktu_masuk_poli));?></u></td>
							</tr>
							<tr>
								<td style="width: 20%;">Poliklinik</td>
								<td style="width: 5%;">:</td>
								<td><u><?php echo $nama_poli;?></u></td>
							</tr>	 -->
						  </tbody>
						</table>

							<br/>
							<!-- <span class="input-group-btn"> -->
								<center>
								<a class="btn btn-success" href="<?php echo site_url('emedrec/c_emedrec/cetak_diagnosa_noreg/'.$data_pasien_daftar_ulang->no_register.'/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; SBPK</i> </a>&nbsp;
								<a class="btn btn-primary" href="<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/'.$data_pasien_daftar_ulang->no_cm.'/'.$data_pasien_daftar_ulang->no_medrec); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik</i> </a>&nbsp;&nbsp;&nbsp;
								<a class="btn btn-success" href="<?php echo site_url('reports/PointMedika/get_cppt_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik Lama ( PointMedika )</i> </a>&nbsp;&nbsp;&nbsp;
								<a class="btn btn-success" href="<?php echo site_url('reports/PointMedika/get_assesmen_medis_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Assesment Medik Lama ( PointMedika )</i> </a>&nbsp;&nbsp;&nbsp;

								<?php if($id_poli=='BA00'){?>
								<a class="btn btn-warning" href="<?php echo site_url()."irj/rjcpelayanan/note_igd/".$no_register;?>" target="_blank"><i class="fa fa-book">&nbsp; Catatan Medis IGD</i> </a>
								<?php }?>

								</center>
							<!-- </span> -->
					</div>
			</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Status Pulang</h5></div>
                    <div class="card-block">
						<?php echo form_open('irj/rjcpelayanan/update_pulang'); ?>
						<!-- <form method="POST" onsubmit="return validate(this)" action="<?php echo base_url('irj/rjcpelayanan/update_pulang')?>"> -->
						<!-- <input type="hidden" name="no_register" value="<?php// echo $no_register;?>"> -->
						<input type="hidden" name="id_dokter_asal" value="<?php  echo isset($dokter_tindakan2[0]->id_dokter)?$dokter_tindakan2[0]->id_dokter:'';?>">
						<input type="hidden" name="id_dokter" value="<?php  echo isset($dokter_tindakan2[0]->id_dokter)?$dokter_tindakan2[0]->id_dokter:'';?>">
						<input type="hidden" name="nama_dokter" value="<?php  echo isset($dokter_tindakan2[0]->nm_dokter)?$dokter_tindakan2[0]->nm_dokter:'';?>">
						<input type="hidden" name="id_poli_asal" value="<?php echo $id_poli;?>">
						<input type="hidden" name="nama_pasien" value="<?php echo strtoupper($data_pasien_daftar_ulang->nama);?>">
						<input type="hidden" name="no_register_lama" value="<?php echo $data_pasien_daftar_ulang->no_register_lama;?>">
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" id="lbl_ket_pulang">Status Pulang</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control custom-select" name="ket_pulang" id="ket_pulang" onchange="pilih_ket_pulang(this.value)" required>
													<option value="">-Pilih Ket Pulang-</option>
													<!-- <option value="PULANG">Pulang</option> -->
													<option value="KONTROL">Kontrol</option>
													<!-- <option value="DIRUJUK_RAWATJALAN">Konsul</option> -->
													<!-- <option value="JAWABAN_KONSUL">Jawaban Konsul</option> -->
													<option value="DIRUJUK_RAWATINAP">Dirujuk Rawat Inap</option>
													<option value="DIRUJUK_RAWATINAP_NR">Dirujuk Rawat Inap NR</option>
													<option value="DIRUJUK_RS">Dirujuk ke RS Lain</option>
													<option value="MENINGGAL">Meninggal</option>
												</select>
											</div>
										</div>
									</div>
							</div>
							<div class="form-group row" id="dirujuk_rj_ke_poli">
								<p class="col-sm-4 form-control-label label-sm" id="dirujuk_ke">Dirujuk Ke:</p>
									<div class="col-sm-8">
											<div class="form-inline">
													<select id="id_poli_rujuk" class="form-control custom-select" name="id_poli_rujuk" onchange="ajaxdokter(this.value)">
														<option value="">-Pilih Nama Poli-</option>
														<?php
														foreach($poliklinik as $row){
															echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
														}
														?>
													</select>

											</div>
									</div>
							</div>
							<div class="form-group row" id="pilih_dokter">
								<p class="col-sm-4 form-control-label label-sm">Dokter:</p>
									<div class="col-sm-8">
											<div class="form-inline">
													<select id="id_dokter_rujuk" class="form-control custom-select" name="dokter_kontrol_id">
														<option value="">-Pilih Dokter-</option>
														<?php
														?>
													</select>

											</div>

									</div>
							</div>
							<div class="form-group row" id="div_tgl_kontrol">
								<p class="col-sm-4 form-control-label" id="lbl_tgl_kontrol">Tanggal Kontrol</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl_kontrol">
											</div>
										</div>
									</div>
							</div>
							<!-- add jam kontrol ulang -->

							<div class="form-group row" id="div_jam_kontrol">
								<p class="col-sm-4 form-control-label" id="lbl_jam_kontrol">Jam Kontrol</p>
									<div class="col-sm-8">
										<div class="form-inline">
										<div class='input-group clockpicker' >
												<input type="text" id="jam_kontrol_ulang" class="form-control" placeholder="Jam Kontrol Ulang" name="jam_kontrol_ulang">
												<span class="input-group-addon">
													<span class="fa fa-clock-o"></span>
												</span>
											</div>
										</div>
									</div>
							</div>

							<div class="form-group row" id="div_tgl_periksa">
								<p class="col-sm-4 form-control-label" id="lbl_tgl_periksa">Tanggal Periksa</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tanggal_periksa">
											</div>
										</div>
									</div>
							</div>

							<div class="form-group row" id="div_jam_periksa">
								<p class="col-sm-4 form-control-label" id="lbl_jam_periksa">Jam Periksa</p>
									<div class="col-sm-8">
										<div class="form-inline">
										<div class='input-group clockpicker' >
												<input type="text" id="jam_periksa" class="form-control" placeholder="Jam Periksa" name="jam_periksa">
												<span class="input-group-addon">
													<span class="fa fa-clock-o"></span>
												</span>
											</div>
										</div>
									</div>
							</div>




							<?php //tampilkan jika poli penyakit dalam BQ00
								// if ($id_poli=='BQ00'){
							?>
							<div class="form-group row" id="div_rujuk_penunjang" style="display:none">
								<p class="col-sm-3 form-control-label" id="lbl_tgl_kontrol">Rujuk Penunjang</p>
								<div class="col-sm-9">
									<div class="form-group col-sm-6">
										<div id="ok_refresh">
										 	<label class="checkbox-inline">
												<?php
												if($rujukan_penunjang->ok=='1'){
													if($rujukan_penunjang->status_ok=='0'){
														echo '<input type="checkbox" id="ok1" name="ok1" value=null unchecked disabled> Operasi<br>belum selesai.';
													} else if($rujukan_penunjang->status_ok=='1'){
														echo '<input type="checkbox" id="ok1" name="ok1" value=null checked disabled> Operasi | <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="ok1" name="ok1" value="2" onclick=ok_enable()> Operasi';
													}
												}else {
													echo '<input type="checkbox" id="ok1" name="ok1" value="2" onclick=ok_enable()> Operasi';
												}
												?>
											</label>
											<!--<div class="demo-checkbox">
										<?php if($rujukan_penunjang->ok=='1') { ?>
												<input type="checkbox" id="ok1" class="filled-in" value=null checked disabled name="ok1"/>
			                                    <label class="m-b-0" for="ok1">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="ok1" class="filled-in" <?php if($rujukan_penunjang->status_ok=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="ok1" />
	                                    		<label class="m-b-0" for="ok1">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?></label>
										<?php } ?>
										</div>-->
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="pa_refresh">
											<label class="checkbox-inline">
												<?php
												if($rujukan_penunjang->pa=='1'){
													if($rujukan_penunjang->status_pa=='0'){
														echo '<input type="checkbox" id="pa1" name="pa1" value=null unchecked disabled> Patologi Anatomi<br>belum selesai.';
													} else if($rujukan_penunjang->status_pa=='1'){
														echo '<input type="checkbox" id="pa1" name="pa1" value=null checked disabled> Patologi Anatomi | <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="pa1" name="pa1" value="2" onclick=pa_enable()> Patologi Anatomi';
													}
												}else {
													echo '<input type="checkbox" id="pa1" name="pa1" value="2" onclick=pa_enable()> Patologi Anatomi';
												}
												?>
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="lab_refresh">
											<label class="checkbox-inline">
												<?php
												if($rujukan_penunjang->lab=='1'){
													if($rujukan_penunjang->status_lab=='0'){
														echo '<input type="checkbox" id="lab1" name="lab1" value=null unchecked disabled> Laboratorium<br>belum selesai.';
													} else if($rujukan_penunjang->status_lab=='1'){
														echo '<input type="checkbox" id="lab1" name="lab1" value=null checked disabled> Laboratorium | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="lab1" name="lab1" value="2" onclick=lab_enable()> Laboratorium';
													}
												}else {
													echo '<input type="checkbox" id="lab1" name="lab1" value="2" onclick=lab_enable()> Laboratorium';
												}
												?>
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="rad_refresh">
											<label class="checkbox-inline">
												<?php
												if($rujukan_penunjang->rad=='1'){
													if($rujukan_penunjang->status_rad=='0'){
														echo '<input type="checkbox" id="rad2" name="rad2" value=null unchecked disabled> Radiologi<br>belum selesai.';
													} else if($rujukan_penunjang->status_rad=='1'){
														echo '<input type="checkbox" id="rad2" name="rad2" value=null checked disabled> Radiologi | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="rad2" name="rad2" value="2" onclick=rad_enable()> Radiologi';
													}
												}else {
													echo '<input type="checkbox" id="rad2" name="rad2" value="2" onclick=rad_enable()> Radiologi';
												}
												?>
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="emr_refresh">
											<label class="checkbox-inline">
												<?php
												if($rujukan_penunjang->em=='1'){
													if($rujukan_penunjang->status_em=='0'){
														echo '<input type="checkbox" id="em2" name="em2" value=null unchecked disabled> Elektromedik<br>belum selesai.';
													} else if($rujukan_penunjang->status_em=='1'){
														echo '<input type="checkbox" id="em2" name="em2" value=null checked disabled> Elektromedik | <a href="'.base_url('em/emcdaftar/pemeriksaan_em').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="em2" name="em2" value="2" onclick=em_enable()> Elektromedik';
													}
												}else {
													echo '<input type="checkbox" id="em2" name="em2" value="2" onclick=em_enable()> Elektromedik';
												}
												?>
											</label>
										</div>
									</div>
								</div>
							</div>
							<?php //end = tampilkan jika poli penyakit dalam
								// }
							?>
							<div class="form-group row" id="div_catatan">
									<p class="col-sm-4 form-control-label" >Alasan</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="note_pulang" id="note_pulang" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>
							<div class="form-group row" id='div_tindak_lanjut'>
									<p class="col-sm-4 form-control-label" id="lbl_tindak">Tindak Lanjut</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="tindak_lanjut" id="tindak_lanjut" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>

							<div class="form-group row" id="div_rujukan">
								<label class="col-md-3 col-form-label">Rujukan</label>
								<div class="col-md-7">
									<select class="form-control input-sm" name="rujukan">
										<option value="regional">Regional</option>
										<option value="nasional">Nasional</option>
										<option value="rslain">RS Lain</option>
									</select>
								</div>
							</div>
							<div id="div_prioritas">
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Kasus</label>
									<div class="col-md-7">
										<select class="form-control input-sm" id="pilihan_prioritas" name="pilihan_prioritas" onchange="iricase(this.value)">
											<option value="-">-</option>
											<option value="IRD">Emergency</option>
											<option value="HBSAG">HBSAG+</option>
											<option value="KEMO">Kemoterapi</option>
											<option value="HEMO">Hemodialisa</option>
											<option value="OPERASI">Operasi Terjadwal</option>
											<option value="TALA">Talamesia</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-3 col-form-label">Prioritas</label>
									<div class="col-md-3">
										<select class="form-control input-sm" name="prioritas">
											<option id="normal" value="normal">Normal</option>
											<option id="high" value="high">High</option>
										</select>
									</div>
									<div class="col-md-6">
										<input type="checkbox" class="filled-in" value="Y" name="infeksi" id="check_infeksi"/>
										<label for="check_infeksi">Infeksi</label>
									</div>
								</div>
							</div>


							<div class="form-group row" id='div_alasan_fasilitas'>
									<p class="col-sm-4 form-control-label" id="lbl_tindak">Alasan</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="alasan_fasilitas" id="alasan_fasilitas" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>


							<div class="form-group row" id='div_diagnosis_awal'>
									<p class="col-sm-4 form-control-label" id="lbl_diagnosis_awal">Diagnosa Awal</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="diagnosis_awal" id="diagnosis_awal" cols="25" rows="3" style="resize:vertical"></textarea>
									</div>
							</div>


							<div class="form-group row" id='div_tindakan_asal'>
									<p class="col-sm-4 form-control-label" id="lbl_tindak">Tindakan yang dilakukan</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="tindakan_asal" id="tindakan_asal" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>

							<div class="form-group row" id='div_kesan'>
									<p class="col-sm-4 form-control-label" id="lbl_diagnosis_awal">Kesan</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="kesan" id="diagnosis_awal" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>


							<div class="form-group row" id='div_anjuran'>
									<p class="col-sm-4 form-control-label">Anjuran</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="anjuran" id="anjuran" cols="25" rows="3" style="resize:vertical" ></textarea>
									</div>
							</div>



							<?php if($statfisik != 'show'){ ?>
							<div class="form-group row" id="div_cetak_prmrj">
								<input class="col-sm-4 form-control-label" type="checkbox" name="cetak_prmrj" id="cetak_prmrj">
								<label for="cetak_prmrj">Cetak PRMRJ</label>
							</div>
							<?php } ?>
								<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<div class="form-group row">
									<div class="offset-sm-4 col-sm-8">
                                                        <button type="submit" class="btn btn-primary" id="btn-simpan-pulang">Simpan</button>
                                                        <button type="reset" class="btn btn-warning">Reset</button>
														<!-- <button type="button" onclick="cetak_resume()" class="btn btn-primary">Cetak</button> -->
                                                    </div>
								</div>
						<?php echo form_close();?>
					<!-- </form> -->
                    </div> <!-- card block -->
                </div>
<!--================================================================================================================================================================ -->
<!--============================================================== ini untuk penunjang comment dulu================================================================= -->
<!--================================================================================================================================================================ -->
                <!-- <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Rujukan Penunjang</h5></div>
                    <div class="card-block">
					<form method="POST" id="form_rujukan" class="form-horizontal">
					 <?php echo form_open('irj/rjcpelayanan/update_rujukan_penunjang'); ?>
						<div class="form-group row">
							<p class="col-sm-12 form-control-label" id="label_rujukan">Rujukan Penunjang :</p>
							<div class="col-sm-12">
								<div class="form-inline">
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->ok=='1') { ?>
												<input type="checkbox" id="ok" class="filled-in" value=null checked disabled name="ok"/>
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
				<?php if($id_poli=='BQ04'){?>
                <div class="alert alert-info">
                	<form class="form" id="form_add_diet">
						<div class="form-group row">
							<p class="col-sm-2 form-control-label" id="jns_diet">Jenis Diet *</p>
								<div class="col-sm-10">
									<!--<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
									<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
													-->
									<select id="record_gizi" class="form-control select2" name="record_gizi"  style="width:100%;" required>
										<option value="">-Pilih Kel Diet-</option>
										<?php
											foreach($keldiet as $row){
												echo '<option value="'.$row->idpokdiet;

												echo '">'.$row->pokdiet.'</option>';
										}?>
														</select>
											</div>
										</div>
							<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_medrec;?>" name="no_medrec">
							<input type="hidden" class="form-control" value="IRJ" name="rawat">
							<div class="form-group row">
								<div class="offset-sm-2 col-sm-6">
	                                <button type="submit" class="btn btn-primary" id="btn-diet">Simpan</button>
	                            </div>
							</div>
					</form>

                </div>
                <?php } ?>
                        <div class="card">

                            <!-- Nav tabs -->
                            <div class="table-responsive">
                            <ul class="nav nav-tabs customtab" role="tablist" style="overflow-x: scroll;">
								<li class="nav-item text-center" id="tab_fisiknya">
                                	<a class="nav-link <?=$tab_fisik?>" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-xs-down">Pemeriksaan Fisik</span></a>
                                </li>



								<?php
								if($id_poli == 'BE00'){
								?>
								<li class="nav-item text-center" id="tab_assesmentkeperawatannyabidan">
                                	<a class="nav-link <?=$tab_assesment_keperawatan_bidan?>" data-toggle="tab" href="#tabAssesmentKeperawatanBidan" role="tab"><span class="hidden-xs-down">Assesment Awal Keperawatan Kebidanan</span></a>

                                </li>
								<?php }else if ($id_poli == 'BH00' || $id_poli == 'BH03')  { ?>
									<li class="nav-item text-center" id="tab_assesmentkeperawatannyaMata">
                                	<a class="nav-link <?=$tab_assesment_keperawatan_mata?>" data-toggle="tab" href="#tabAssesmentKeperawatanMata" role="tab"><span class="hidden-xs-down">Assesment Awal Keperawatan Mata</span></a>
                                </li>
								<?php }else{?>
									<li class="nav-item text-center" id="tab_assesmentkeperawatannya">
                                	<a class="nav-link <?=$tab_assesment_keperawatan?>" data-toggle="tab" href="#tabAssesmentKeperawatan" role="tab"><span class="hidden-xs-down">Assesment Awal Keperawatan</span></a>
								<?php }?>





								<li class="nav-item text-center" id="tab_assesmentmedikperawatnya">
                                	<a class="nav-link <?=$tab_assesment_medik_perawat?>" data-toggle="tab" href="#tabAssesmentMedikPerawat" role="tab"><span class="hidden-xs-down">Assesment Kunjungan</span></a>
                                </li>

								<?php if ($id_poli == 'BH00' || $id_poli == 'BH03'){ ?>
									<li class="nav-item text-center" id="tab_medikdokternyaMata">
                                	<a class="nav-link <?=$tab_assesment_medik_dokter_mata?>" data-toggle="tab" href="#tab_assesment_medik_dokter_mata" role="tab"><span class="hidden-xs-down">Assesment Medik Dokter Mata</span></a>
                                </li>
								<?php }else{ ?>
									<li class="nav-item text-center" id="tab_medikdokternya">
                                	<a class="nav-link <?=$tab_assesment_medik_dokter?>" data-toggle="tab" href="#tab_assesment_medik_dokter" role="tab"><span class="hidden-xs-down">Assesment Medik Dokter</span></a>
                                	</li>
								<?php } ?>
								<li class="nav-item text-center" id="tab_giginya">
                                	<a class="nav-link <?=$tab_gigi?>" data-toggle="tab" href="#tabGigi" role="tab"><span class="hidden-xs-down">Gigi</span></a>
                                </li>
                                <li class="nav-item text-center" id="tab_gizinya">
                                	<a class="nav-link <?=$tab_gizi?>" data-toggle="tab" href="#tabGizi" role="tab"><span class="hidden-xs-down">Gizi</span></a>
                                </li>

								<?php if ($id_poli == 'BK00'){ ?>
									<li class="nav-item text-center" id="tab_rehabnya">
                                		<a class="nav-link <?=$tab_rehab_medik?>" data-toggle="tab" href="#tabrehab_medik" role="tab"><span class="hidden-xs-down">Asesmen Awal Medis Poliklinik Rehabilitasi Medik</span></a>
                                	</li>
									<li class="nav-item text-center" id="tab_rehabnyaanak">
                                		<a class="nav-link <?=$tab_rehab_medik_anak?>" data-toggle="tab" href="#tabrehab_medik_anak" role="tab"><span class="hidden-xs-down">Asesmen Awal Medis Poliklinik Rehabilitasi Medik Anak</span></a>
                                	</li>
								<?php } ?>

								<li class="nav-item text-center" id="tab_tindakannya">
									<a class="nav-link <?=$tab_tindakan?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-xs-down">Tindakan</span></a>
								</li>
								<li class="nav-item text-center" id="tab_diagnosanya">
									<a class="nav-link <?=$tab_diagnosa?>" data-toggle="tab" href="#tabDiagnosa" role="tab"><span class="hidden-xs-down">Diagnosa</span></a>
								</li>
								<li class="nav-item text-center" id="tab_prosedurnya">
									<a class="nav-link <?=$tab_prosedur?>" data-toggle="tab" href="#tabProsedur" role="tab"><span class="hidden-xs-down">Prosedur</span></a>
								</li>
								<li class="nav-item text-center" id="tab_operasinya">
									<a class="nav-link" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a>
								</li>
								<li class="nav-item text-center" id="tab_labnya">
									<a class="nav-link <?=$tab_lab?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a>
								</li>
								<li class="nav-item text-center" id="tab_radnya">
									<a class="nav-link <?=$tab_rad?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a>
								</li>
								<li class="nav-item text-center" id="tab_emnya">
									<a class="nav-link <?=$tab_em?>" data-toggle="tab" href="#tabElektromedik" role="tab"><span class="hidden-xs-down">Elektromedik</span></a>
								</li>
								<li class="nav-item text-center" id="tab_resepnya">
									<a class="nav-link <?=$tab_resep?>" data-toggle="tab" href="#tabResep" role="tab"><span class="hidden-xs-down">Resep</span></a>
								</li>
								<li class="nav-item text-center" id="tab_transfernya">
									<a class="nav-link <?=$tab_transfer?>" data-toggle="tab" href="#tab_transfer" role="tab"><span class="hidden-xs-down">Transfer Ruangan</span></a>
								</li>
								<li class="nav-item text-center" id="tab_konsulnya">
									<a class="nav-link <?=$tab_konsul?>" data-toggle="tab" href="#tabKonsul" role="tab"><span class="hidden-xs-down">Konsultasi</span></a>
								</li>
								<li class="nav-item text-center" id="tab_jawabankonsulnya">
									<a class="nav-link <?=$tab_jawaban_konsul?>" data-toggle="tab" href="#tabJawabanKonsul" role="tab"><span class="hidden-xs-down">Jawaban Konsultasi</span></a>
								</li>
								<!-- <a class="btn btn-success btn-md" href="<?php //echo site_url('irj/rjcpelayanan/cetak_asesmen_awal_keperawatan/'.$data_pasien_daftar_ulang->no_cm.'/'.$data_pasien_daftar_ulang->no_register); ?>" target="_blank">Lihat Assesment Keperawatan</i> </a> -->
								<?php if ($id_poli == 'BJ00'){ ?>
								<li class="nav-item text-center">
                                	<a class="nav-link <?=$tab_fungsional_status?>" data-toggle="tab" href="#tabFungsionalStatus" role="tab"><span class="hidden-xs-down">Penilaian Fungsional</span></a>
                                </li>
								<?php } ?>
                            </ul>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">

									<div class="tab-pane p-20 <?=$tab_assesment_medik_dokter_mata?>" id="tab_assesment_medik_dokter_mata" role="tabpanel">
										<div class="p-20">
											<?php include('form_medik_mata.php');  ?>
										</div>
									</div>

									<div class="tab-pane p-20 <?=$tab_assesment_medik_dokter?>" id="tab_assesment_medik_dokter" role="tabpanel">
										<div class="p-20">
											<?php include('assesmentmedikdokter/formassesmentmedikdokter.php');  ?>
										</div>
									</div>

									<div class="tab-pane  p-20 <?=$tab_fungsional_status?>" id="tabFungsionalStatus" role="tabpanel">
										<div class="p-20">
											<?php include('penilaian_fungsional/rdvpenilaianstatusfungsional.php'); ?>
										</div>
									</div>




								<div class="tab-pane p-20 <?=$tab_tindakan?>" id="tabTindakan" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformtindakanajax.php');  ?>
                                    </div>
                                </div>


								<div class="tab-pane p-20 <?=$tab_diagnosa?>" id="tabDiagnosa" role="tabpanel">
                                	<div class="p-20">
									<!-- <a class="btn btn-success" href="echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Diagnosa Sebelumnya</i> </a>&nbsp;&nbsp;&nbsp; -->
									<button class="btn btn-success" data-toggle="modal" data-target="#diagnosaHistory" onclick="history_diagnosa()"><i class="fa fa-binoculars">&nbsp; Diagnosa Sebelumnya</i> </button>&nbsp;&nbsp;&nbsp;
										<div class="form-group row">
									        <label for="id_diagnosa" class="col-3 col-form-label">Diagnosa (ICD-10)</label>
									        <div class="col-9">
												<input type="text" class="form-control custom-select" id="cari_diag" name="cari_diag" placeholder="Pencarian Diagnosa">
												<input type="hidden" name="id_diagnosa" id="id_diagnosa">
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
								<div class="tab-pane p-20 <?=$tab_konsul?>" id="tabKonsul" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('formkonsul/formkonsul.php');  ?>
                                    </div>
                                </div>
								<div class="tab-pane p-20 <?=$tab_transfer?>" id="tab_transfer" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('transfer_ruangan/rjvtransferruangan.php');  ?>
                                    </div>
                                </div>
								<div class="tab-pane p-20 <?=$tab_jawaban_konsul?>" id="tabJawabanKonsul" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('formkonsul/formjawabankonsul.php');  ?>
                                    </div>
                                </div>

                                <div class="tab-pane <?=$tab_fisik?>" id="tabFisik" role="tabpanel">
                                    <div class="p-20">
                                        <?php include('rjvformfisik.php');  ?>

                                    </div>
                                </div>
								<div class="tab-pane p-20 <?=$tab_assesment_keperawatan?>" id="tabAssesmentKeperawatan" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformassesmentkeperawatanjs.php'); ?>
                                    </div>
                                </div>
								<div class="tab-pane p-20 <?=$tab_assesment_keperawatan_bidan?>" id="tabAssesmentKeperawatanBidan" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvassesmentbidan.php'); ?>
                                    </div>
                                </div>
								<div class="tab-pane p-20 <?=$tab_assesment_keperawatan_mata?>" id="tabAssesmentKeperawatanMata" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvassesmentmata.php'); ?>
                                    </div>
                                </div>
								<?php
								if($id_poli != 'BK07'){
								?>
								<div class="tab-pane p-20 <?=$tab_assesment_medik_perawat?>" id="tabAssesmentMedikPerawat" role="tabpanel">
                                	<div class="p-20">
										<?php include('formmedikperawat/rjvformmedikperawat.php'); ?>
                                    </div>
                                </div>
								<?php }else{ ?>
								<div class="tab-pane p-20 <?=$tab_assesment_medik_perawat?>" id="tabAssesmentMedikPerawat" role="tabpanel">
                                	<div class="p-20">
										<?php include('formmedikperawat/fisioterapi/rjvformmedikperawat.php'); ?>
                                    </div>
                                </div>
								<?php } ?>
								<div class="tab-pane p-20 <?=$tab_gigi?>" id="tabGigi" role="tabpanel">
									<div class="p-20">
										<?php include('formgigi/rjvformgigi.php');  ?>
									</div>
								</div>

								<div class="tab-pane p-20 <?=$tab_gizi?>" id="tabGizi" role="tabpanel">
									<div class="p-20">
										<?php include('rjvformgizi.php');  ?>
									</div>
								</div>

								<div class="tab-pane p-20 <?=$tab_rehab_medik_anak?>" id="tabrehab_medik_anak" role="tabpanel">
									<div class="p-20">
									<?php include('medik_rehab/medik_rehab_anak.php'); ?>
									</div>
								</div>
								<div class="tab-pane p-20 <?=$tab_rehab_medik?>" id="tabrehab_medik" role="tabpanel">
									<div class="p-20">
									<?php include('medik_rehab/medik_rehab.php'); ?>
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
			url:"<?php echo base_url(); ?>irj/rjcpelayanan/update_rujukan_penunjang/",
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
								icon: 'success',
								type: "success",
								showCancelButton: false,
								closeOnConfirm: true,
								showLoaderOnConfirm: true,
								willClose: () => {
									window.location.reload();
								}
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