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
?>

<script>
	/**
	 * Added Eretensi
	 * @aldi
	 */

	function openeretensi() {
		$('#exampleModal').modal('show');
		$.ajax({
			url: '<?= base_url("irj/rjcpelayanan/eretensi/" . $data_pasien_daftar_ulang->no_cm) ?>',
			beforeSend: function() {
				$('#hasilPencarian').html('<tr><td style="text-align:center;" colspan="3">Sedang Mencari Data...</td></tr>');
			},
			success: function(data) {
				let html = '';
				let index = 1;
				if (data.code == 200) {

					data.data.map((e) => {
						html += `
						<tr>
							<td>${index}</td>
							<td>${e.nama_file}</td>
							<td><a target="_self" class="btn btn-primary" href="http://192.168.206.50/emr/view/rekam_medis/${e.no_scan}/${e.nama_file}">Lihat</a></td>
						</tr>
						`;
						index++;
					})
				} else {
					html += `<tr><td colspan="3">Data Tidak Ditemukan</td></tr>`;
				}
				$('#hasilPencarian').html(html);
				// $('#hasilPencarian').html('Hasil ')
			},
			error: function(xhr) {
				$('#hasilPencarian').html('<tr><td style="text-align:center;" colspan="3">Data Tidak Ditemukan</td></tr>');

			},
			complete: function() {
				// $('#hasilPencarian').html('<tr><td style="text-align:center;" colspan="3">Data Tidak Ditemukan</td></tr>');

			}
		});
	}
	//end added eretensi
	$(document).ready(function() {
		$('#poli-surat-kontrol').on('change', function(val) {
			$.ajax({
				type: 'GET',
				url: '<?php echo  base_url('irj/rjcpelayanan/get_dokter_by_poli/'); ?>' + this.value.split('-')[0],
				beforeSend: function() {
					$('#dokter-surat-kontrol').find('option')
						.remove()
						.end()
						.append('<option value="">Sedang Mengambil Data...</option>')
						.val('')
				},
				success: function(data) {
					console.log(data);
					if (data.length > 0) {
						$('#dokter-surat-kontrol').find('option')
							.remove()
							.end()
							.append('<option value="">Silahkan Pilih Data</option>')
							.val('');
						let html = `<option value="">Silahkan Pilih Data</option>`;
						data.map((item) => {
							html += `<option value="${item.kode_dpjp_bpjs}">${item.nm_dokter}</option>`;
						});
						$('#dokter-surat-kontrol').html(html)
					}
				},
				error: function(xhr) {
					$('#poli-surat-kontrol').find('option')
						.remove()
						.end()
						.append('<option value="">Gagal Mengambil Data , Silahkan coba kembali</option>')
						.val('');
				},
				complete: function() {

				}
			});
		})
		$('#btn-buatnosuratkontrol').click(function() {
			location.href = "<?= base_url('bpjs/rencanakontrol/insert/'.$data_pasien_daftar_ulang->no_sep) ?>";
			// $('#modalbuatsuratkontrol').modal('show');
			// $('#modalbuatsuratkontrol').on('shown.bs.modal', function() {
			// 	$.ajax({
			// 		type: 'GET',
			// 		url: '<?php //echo  base_url('irj/rjcpelayanan/get_poli_bpjs/' . $poli_bpjs); ?>',
			// 		beforeSend: function() {
			// 			$('#poli-surat-kontrol').find('option')
			// 				.remove()
			// 				.end()
			// 				.append('<option value="">Sedang Mengambil Data...</option>')
			// 				.val('')
			// 		},
			// 		success: function(data) {
			// 			console.log(data);
			// 			if (data.length > 0) {
			// 				$('#poli-surat-kontrol').find('option')
			// 					.remove()
			// 					.end()
			// 					.append('<option value="">Silahkan Pilih Data</option>')
			// 					.val('');
			// 				let html = `<option value="">Silahkan Pilih Data</option>`;
			// 				data.map((item) => {
			// 					html += `<option value="${item.id_poli}-${item.poli_bpjs}">${item.nm_poli}</option>`;
			// 				});
			// 				$('#poli-surat-kontrol').html(html)
			// 			}
			// 		},
			// 		error: function(xhr) {
			// 			$('#poli-surat-kontrol').find('option')
			// 				.remove()
			// 				.end()
			// 				.append('<option value="">Gagal Mengambil Data , Silahkan coba kembali</option>')
			// 				.val('');
			// 		},
			// 		complete: function() {

			// 		}
			// 	});

			// 	$('#tgl-surat-kontrol').datepicker({
			// 		format: "yyyy-mm-dd",
			// 		// minDate: 1,
			// 		autoclose: true,
			// 		todayHighlight: true,
			// 	});
			// });
		});
		$('#form-diagnosa-submit').on('submit', function(e) {
			e.preventDefault();
			$.ajax({
				url: "<?php echo base_url(); ?>irj/diagnosa/insert_all",
				method: "POST",
				data: new FormData(this),
				contentType: false,
				cache: false,
				processData: false,
				success: function(data) {

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
						function() {
							// window.location.reload();
						});
				},
				error: function(event, textStatus, errorThrown) {
					document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					new swal("Error", "Data gagal disimpan.", "error");
					console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	var id_poli = '<?= $id_poli; ?>';
	var statfisik = '<?= $statfisik ?>';
	var jawabankonsul = '<?= $data_pasien_daftar_ulang->no_register_lama ?>';


	$('#tombolkembali').on('click', function() {
		$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
	});



	$(document).ready(function() {
		$("#div_surat_kontrol").hide();

		switch (statfisik) {
			case 'show':
				// $('#tab_tindakannya').show();
				// $('#tabTindakan').hide();
				// $('#tab_diagnosanya').hide();
				$('#tabDiagnosa').hide();
				$('#tab_prosedurnya').hide();
				$('#tabProsedur').hide();
				// $('#tab_operasinya').hide();
				$('#tab_geriatri').hide();
				// $('#tab_asuhan_gizi').hide();
				$('#tab_asuhan_gizi_anak').hide();
				$('#tabOperasi').hide();
				$('#tab_labnya').hide();
				$('#tabLaborat').hide();
				$('#tab_radnya').hide();
				$('#tabRadiologi').hide();
				$('#tab_emnya').hide();
				$('#tabElektromedik').hide();
				// $('#tab_resepnya').hide();
				$('#tabResep').hide();
				// $('#tab_upload').hide();
				$('#tab_konsulnya').hide();
				$('#tabKonsul').hide();
				$('#tab_jawabankonsulnya').hide();
				$('#tabJawabanKonsul').hide();
				$('#tab_medik_obgyn').hide();
				//$('#tab_medikdokternya').hide();
				$('#tab_rehabnya').hide();
				$('#tab_rehabnyaanak').hide();
				$('#tab_medikdokternyaMata').hide();
				$('#tab_persetujuannya').hide();
				$('#rasal').hide();
				$('#raslan').hide();
				$('#gyysen').hide();
				$('#raspatur').hide();
				$('#iadl').hide();
				$('#edukasi_penolakan_asuhan').hide();
				//$('#tab_transfernya').hide();
				$('#lap_anestesi').hide();
				$('#pra_anestesi').hide();
				$('#status_sedasi').hide();
				if (id_poli === "BG00") {
					$('#tab_gizinya').hide();

				} else if (id_poli === "BM00") {
					$('#tab_giginya').hide();
				} else {
					$('#tab_giginya').hide();
					$('#tab_gizinya').hide();

				}
				$('#tab_cppt').hide();
				// $('#tab_ringkasan_keluar_rj').hide();
				// $('#tab_kontrol_pasien').hide();
				// $('#tab_konsul_pasien').hide();
				$('#tab_jawaban_konsul_pasien').hide();
				// $('#tab_pengantar_ranap').hide();
				$('#tab_transfusi_darah').hide();
				// $('#tab_persetujuan_medik').hide();
				$('#tab_penolakan_medik').hide();
				$('#tab_medik_anak').hide();
				$('#tab_tht').hide();
				$('#tab_gigi').hide();
				// $('#tab_keperawatan_anak').hide();
				$('#tab_fisikrehab').hide();
				$('#tab_ujifungsidok').hide();
				

				
				break
			default:
			
			$('#tab_program_terapi').hide();
			$('#tab_ujifungsi').hide();
				$('#tab_fisiknya').hide();
				$('#tab_diagnosanya').hide();
				$('#tab_lab').hide();
				$('#tab_rad').hide();
				$('#tab_pa').hide();
				$('#tab_resepnya').hide();
				$('#tabFisik').hide();
				$('#tab_keperawatan_anak').hide();
				$('#tabAssesmentKeperawatan').hide();
				$('#tab_assesmentkeperawatannyaMata').hide();
				$('#tab_assesmentkeperawatannya').hide();
				$('#tab_obgyn').hide();
				$('#tab_assesmentkeperawatannyabidan').hide();
				$('#tabAssesmentMedikPerawat').hide();
				$('#tab_assesmentmedikperawatnya').hide();
				$('#tab_fungsional').hide();
				if (jawabankonsul) {
					if (id_poli === "BK00") {
						$('#tab_jawabankonsulnya').hide();
						$('#tab_jawabankonsulrehabmedik').show();
						$('#lap_anestesi').hide();
						$('#pra_anestesi').hide();
						$('#status_sedasi').hide();
						// $('#lap_echo').hide();
						// $('#tab_medikdokternya').hide();
				
					} else if (id_poli === "BB05") {
						$('#tab_jawabankonsulnya').show();
						$('#tab_jawabankonsulrehabmedik').hide();
						$('#lap_anestesi').show();
						$('#pra_anestesi').show();
						$('#status_sedasi').show();
					} else {
						$('#tab_jawabankonsulnya').show();
						$('#tab_jawabankonsulrehabmedik').hide();
						$('#lap_anestesi').hide();
						$('#pra_anestesi').hide();
						$('#status_sedasi').hide();
					}
				} else {
					$('#tab_jawabankonsulnya').hide();
					$('#tab_jawabankonsulrehabmedik').hide();
					$('#lap_anestesi').hide();
					$('#pra_anestesi').hide();
					$('#status_sedasi').hide();
				}

				if (id_poli === "BG00") {
					$('#tab_gizinya').hide();
				} else if (id_poli === "BQ04") {
					$('#tab_giginya').hide();

				} else {
					$('#tab_giginya').hide();
					$('#tab_gizinya').hide();
				}
				break;
		}
	});



	function iricase(caseiri) {
		if (caseiri == 'OPERASI') {
			$('#divok').show();
		} else {
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

			source: function(request, response) {
				$.ajax({
					url: '<?php echo base_url(); ?>/iri/ricreservasi/data_ruang_2',
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						if (!data.length) {
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
			select: function(event, ui) {
				// console.log(ui);
				$('#ruang').val(ui.item.idrg);
			}
		});
		$('.auto_search_poli').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_poli',
			onSelect: function(suggestion) {
				$('#id_poli').val('' + suggestion.id_poli);
				$('#kd_ruang').val('' + suggestion.kd_ruang);
			}
		});
		// $('.auto_diagnosa_pasien').autocomplete({
		//     serviceUrl: '<?php echo base_url() . 'iri/ricstatus/data_icd_1'; ?>',
		//     onSelect: function (suggestion) {
		//       $('#id_diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
		//       $('#diagnosa').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);

		//     }
		// });

		$('#cari_diag').autocomplete({

			source: function(request, response) {
				$.ajax({
					url: '<?php echo base_url() ?>farmasi/Frmcdaftar/cari_data_diagnosawithid',
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						if (!data.length) {
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
			select: function(event, ui) {
				$('#cari_diag').val(ui.item.id_diag + '-' + ui.item.nama);
				$('#id_diagnosa').val(ui.item.id_diag + '@' + ui.item.nama);
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
		//       url: '<?php echo base_url() . 'irj/Diagnosa/select2'; ?>',
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

		// var tomorrow = new Date(today.getTime() + 24 * 60 * 60 * 1000);
		$('#date_picker').datepicker({
			format: "dd-mm-yyyy",
			minDate: +1,
			autoclose: true,
			todayHighlight: true,
		});

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

		// var lab="<?php // echo $rujukan_penunjang->lab;
								?>";
		// var pa="<?php //echo $rujukan_penunjang->pa;
								?>";
		// var ok="<?php //echo $rujukan_penunjang->ok;
								?>";
		// var rad="<?php //echo $rujukan_penunjang->rad;
								?>";
		// var em="<?php //echo $rujukan_penunjang->em;
								?>";
		// var obat="<?php //echo $rujukan_penunjang->obat;
									?>";
		// var fisio="<?php //echo $rujukan_penunjang->fisio;
									?>";

		// if(lab=='1' && pa=='1' && rad=='1' && obat=='1' && fisio=='1' && ok=='1' && em == '1'){
		// 	 document.getElementById("button_simpan_rujukan").disabled= true;
		// }

	});



	function pilih_ket_pulang(ket_plg) {
		switch (ket_plg) {
			case 'PULANG':
				$("#div_surat_kontrol").hide();
				$('#div_tgl_kontrol').hide();
				$('#div_jam_kontrol').hide();
				$('#div_rujuk_penunjang').hide(); //diubahdlu
				$('#dirujuk_rj_ke_poli').hide();
				$('#pilih_dokter').hide();
				$('#div_tindak_lanjut').hide();
				document.getElementById("btn_simpan").value = 'Simpan';
				break;
			case 'KONTROL':
				$("#div_surat_kontrol").show();
				$('#div_tgl_kontrol').show();
				$('#div_alasan_fasilitas').show();
				$('#div_jam_kontrol').show();
				$("#lbl_tgl_kontrol").html("Tanggal Kontrol");
				$("#lbl_jam_kontrol").html("Jam Kontrol");
				$('#div_rujuk_penunjang').hide(); //diubahdlu
				$('#dirujuk_rj_ke_poli').hide();
				$('#pilih_dokter').hide();
				$('#div_tindak_lanjut').show();
				$('#div_diagnosis_awal').hide();
				$('#div_tindakan_asal').hide();
				$('#div_kesan').hide();
				$('#div_anjuran').hide();
				$('#div_tgl_periksa').hide();
				$('#div_jam_periksa').hide();
				$('#id_poli_rujuk').prop('required', false);
				$('#id_dokter_rujuk').prop('required', false);
				$('#kesan').prop('required', false);
				$('#anjuran').prop('required', false);
				$('#tindak_lanjut').prop('required', true);
				break;
			case 'DIRUJUK_RAWATJALAN':
				$("#div_surat_kontrol").hide();
				$('#dirujuk_rj_ke_poli').show();
				$('#pilih_dokter').show();
				$('#div_tgl_kontrol').hide();
				$('#div_tindak_lanjut').hide();
				$('#div_diagnosis_awal').hide();
				$('#div_tindakan_asal').hide();
				$('#div_kesan').hide();
				$('#div_anjuran').hide();
				$('#div_catatan').hide();
				$('#div_tgl_periksa').hide();
				$('#div_jam_periksa').hide();
				$('#id_poli_rujuk').prop('required', true);
				$('#id_dokter_rujuk').prop('required', true);
				$('#tindak_lanjut').prop('required', false);
				$('#kesan').prop('required', false);
				$('#anjuran').prop('required', false);

				break;
			case 'JAWABAN_KONSUL':
				$("#div_surat_kontrol").hide();
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
				$('#id_poli_rujuk').prop('required', false);
				$('#id_dokter_rujuk').prop('required', false);
				$('#tindak_lanjut').prop('required', false);
				$('#kesan').prop('required', true);
				$('#anjuran').prop('required', true);
				break;
			case 'DIRUJUK_RAWATINAP':
				$("#div_surat_kontrol").hide();
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
				$('#id_poli_rujuk').prop('required', false);
				$('#id_dokter_rujuk').prop('required', false);
				$('#tindak_lanjut').prop('required', true);
				$('#kesan').prop('required', false);
				$('#anjuran').prop('required', false);
				break;
			case 'DIRUJUK_RAWATINAP_NR':
				$("#div_surat_kontrol").hide();
				$('#dirujuk_rj_ke_poli').hide();
				$('#pilih_dokter').hide();
				$('#div_tindak_lanjut').show();
				$('#div_diagnosis_awal').hide();
				$('#div_tindakan_asal').hide();
				$('#div_kesan').hide();
				$('#div_rujukan').show();
				$('#div_anjuran').hide();
				$('#id_poli_rujuk').prop('required', false);
				$('#id_dokter_rujuk').prop('required', false);
				$('#tindak_lanjut').prop('required', true);
				$('#kesan').prop('required', false);
				$('#anjuran').prop('required', false);
				break;
			case 'MENINGGAL':
				$("#div_surat_kontrol").hide();
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
				$('#id_poli_rujuk').prop('required', false);
				$('#id_dokter_rujuk').prop('required', false);
				$('#tindak_lanjut').prop('required', true);
				$('#kesan').prop('required', false);
				$('#anjuran').prop('required', false);
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

	function buatajax() {
		if (window.XMLHttpRequest) {
			return new XMLHttpRequest();
		}
		if (window.ActiveXObject) {
			return new ActiveXObject("Microsoft.XMLHTTP");
		}
		return null;
	}






	function ajaxdokter(id_poli) {
		ajaxku = buatajax();
		var url = "<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
		url = url + "/" + id_poli;
		url = url + "/" + Math.random();
		ajaxku.onreadystatechange = stateChangedDokter;
		ajaxku.open("GET", url, true);
		ajaxku.send(null);
	}

	var ajaxku;

	function stateChangedDokter() {
		var data;
		//alert(ajaxku.responseText);
		if (ajaxku.readyState == 4) {
			data = ajaxku.responseText;
			if (data.length >= 0) {
				document.getElementById("id_dokter_rujuk").innerHTML = data;
			}
		}

	}


	function cetak_resume() {
		window.open('<?php echo site_url('irj/rjcpelayanan/cetak_resume/') . $data_pasien_daftar_ulang->no_cm;; ?>');
	}

	function update_dokter(no_register) {
		var id_dokter = $('#id_dokter').val();
		var nmdokter = $('#nmdokter').val();
		$.ajax({
			type: "POST",
			url: "<?php echo base_url("irj/rjcpelayanan/update_dokter/"); ?>",
			dataType: "JSON",
			data: {
				'no_register': no_register,
				'id_dokter': id_dokter,
				'nmdokter': nmdokter
			},
			success: function(data) {
				if (data == '1') {
					new swal("Sukses", "Dokter berhasil diupdate.", "success");
					tabeltindakan(no_register);
				} else {
					new swal("Error", "Gagal update. Silahkan coba lagi.", "error");
				}
			},
			error: function(event, textStatus, errorThrown) {
				new swal("Error", "Gagal update. Silahkan coba lagi.", "error");
				// console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});
	}
	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_no_register_dokter').autocomplete({
			serviceUrl: site + '/iri/ricpendaftaran/data_dokter_autocomp',
			onSelect: function(suggestion) {
				$('#id_dokter').val('' + suggestion.id_dokter);
				$('#nmdokter').val('' + suggestion.nm_dokter);
			}
		});
	});

	function validate(form) {
		document.getElementById("btn-simpan-pulang").disabled = true;
		document.getElementById("btn-simpan-pulang").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
		return true;
	}

	function redirectOnClick() {
		document.location = 'ControllerName/ActionName';
	}
</script>
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="card card-outline-info">
				<div class="card-header">
					<h5 class="m-b-0 text-white text-center">Data Pasien</h5>
				</div>
				<div class="card-block">

					<div class="row">
						<div class="table-responsive m-t-10 p-10" style="clear: both;">

							<table class="table-xs table-striped" width="100%">
								<tbody>
									<tr>
										<td style="width: 20%;color:green">No. Antrian</td>
										<td style="width: 5%;">:</td>
										<td style="color:green"><b><?php echo $data_pasien_daftar_ulang->no_antrian; ?></b></td>
									</tr>
									<tr>
										<td style="width: 20%;">No. RM</td>
										<td style="width: 5%;">:</td>
										<td><?php echo $data_pasien_daftar_ulang->no_cm; ?></td>
									</tr>
									<tr>
										<td style="width: 20%;">No. Register</td>
										<td style="width: 5%;">:</td>
										<td><?php echo $no_register; ?></td>
									</tr>
									<tr>
										<td style="width: 20%;">Nama</td>
										<td style="width: 5%;">:</td>
										<td><?php echo strtoupper($data_pasien_daftar_ulang->nama); ?></td>
									</tr>
									<tr>
										<td style="width: 20%;">Jenis Kelamin</td>
										<td style="width: 5%;">:</td>
										<td><?php
												if ($data_pasien->sex == 'L') {
													echo 'Laki - Laki';
												} else {
													echo 'Perempuan';
												}

												?>

										</td>
									</tr>
									<tr>
										<td style="width: 20%;">Tgl Lahir</td>
										<td style="width: 5%;">:</td>
										<?php
										$interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));
										?>
										<td><?= date('d-m-Y', strtotime($data_pasien->tgl_lahir)) ?></td>
									</tr>
									<tr>
										<td style="width: 20%;">Umur</td>
										<td style="width: 5%;">:</td>
										<td><?php
											// Menghitung selisih antara tanggal sekarang dan tanggal lahir
											$interval = date_diff(date_create(), date_create($data_pasien->tgl_lahir));

											// Menampilkan hasil usia dalam tahun, bulan, dan hari
											echo $interval->y . " tahun, " . $interval->m . " bulan, " . $interval->d . " hari";
											?>

										</td>
									</tr>
									<tr>
										<td style="width: 20%;">Alamat</td>
										<td style="width: 5%;">:</td>
										<td><?= $data_pasien->alamat; ?></td>
									</tr>
									<tr>
										<td style="width: 20%;">Dokter Poli</td>
										<td style="width: 5%;">:</td>
										<td>
											<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" required>
												<option value="">-Pilih Pelaksana-</option>
												<?php
												foreach ($dokter_tindakan2 as $row) {

													if ($row->id_dokter == $id_dokterrawat) {
														echo '<option value="' . $row->id_dokter . '@' . $row->nm_dokter . '" selected>' . $row->nm_dokter . '</option>';
													} else {
														echo '<option value="' . $row->id_dokter . '@' . $row->nm_dokter . '">' . $row->nm_dokter . '</option>';
													}
												}

												?>
											</select>

											<button type="button" class="btn waves-effect waves-light btn-primary btn-xs m-b-5 m-t-5" onclick="update_dokter('<?php echo $data_pasien_daftar_ulang->no_register; ?>')">Ubah Dokter</button>
										</td>
									</tr>

								</tbody>
							</table>
							<br />

							<center>
								<a class="btn btn-success" href="<?php echo site_url('emedrec/c_emedrec/cetak_diagnosa_noreg/' . $data_pasien_daftar_ulang->no_register . '/' . $data_pasien_daftar_ulang->no_cm); ?>" target="_self"><i class="fa fa-binoculars">&nbsp; SBPK</i> </a>&nbsp;
								<a class="btn btn-primary" href="<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/' . $data_pasien_daftar_ulang->no_cm . '/' . $data_pasien_daftar_ulang->no_medrec); ?>" target="_self"><i class="fa fa-binoculars">&nbsp; Rekam Medik Elektronik</i> </a>&nbsp;&nbsp;&nbsp;
								<a class="btn btn-danger" href="<?php echo site_url('medrec/el_record/pasien/' . $data_pasien_daftar_ulang->no_cm.'/'.$data_pasien_daftar_ulang->no_medrec ); ?>" target="_self"><i class="fa fa-binoculars">&nbsp; Rekam Medik</i> </a>&nbsp;&nbsp;&nbsp;
								<button onclick="icare()" class="btn btn-primary" ><i class="fa fa-binoculars">&nbsp; ICare BPJS</i> </button>&nbsp;&nbsp;&nbsp;
								<!-- <a class="btn btn-success" href="<?php echo site_url('reports/PointMedika/get_cppt_by_medrek/' . $data_pasien_daftar_ulang->no_cm); ?>" target="_self"><i class="fa fa-binoculars">&nbsp; Rekam Medik Lama ( PointMedika )</i> </a>&nbsp;&nbsp;&nbsp; -->
								<!-- <a class="btn btn-success mt-2" href="<?php echo site_url('reports/PointMedika/get_assesmen_medis_by_medrek/' . $data_pasien_daftar_ulang->no_cm); ?>" target="_self"><i class="fa fa-binoculars">&nbsp; Assesment Medik Lama ( PointMedika )</i> </a>&nbsp;&nbsp;&nbsp;
								<a class="btn btn-info text-white mt-2" onclick="openeretensi()">&nbsp; Lihat E retensi</i> </a>&nbsp;&nbsp;&nbsp;
								<button class="btn btn-success mt-2" data-toggle="modal" data-target="#modalMultipleFile"><span class="mdi mdi-file-multiple"></span></button> -->

								<?php if ($id_poli == 'BA00') { ?>
									<!-- <a class="btn btn-warning" href="<?php echo site_url() . "irj/rjcpelayanan/note_igd/" . $no_register; ?>" target="_self"><i class="fa fa-book">&nbsp; Catatan Medis IGD</i> </a> -->
								<?php } ?>
							</center>

						</div>
					</div>
				</div>
			</div>

			<div class="card card-outline-info">
				<div class="card-header">
					<h5 class="m-b-0 text-white text-center">Status Pulang</h5>
				</div>
				<div class="card-block">
					<?php echo form_open('irj/rjcpelayanan/update_pulang'); ?>

					<input type="hidden" name="id_dokter_asal" value="<?php echo isset($dokter_tindakan2[0]->id_dokter) ? $dokter_tindakan2[0]->id_dokter : ''; ?>">
					<input type="hidden" name="id_dokter" value="<?php echo isset($dokter_tindakan2[0]->id_dokter) ? $dokter_tindakan2[0]->id_dokter : ''; ?>">
					<input type="hidden" name="nama_dokter" value="<?php echo isset($dokter_tindakan2[0]->nm_dokter) ? $dokter_tindakan2[0]->nm_dokter : ''; ?>">
					<input type="hidden" name="id_poli_asal" value="<?php echo $id_poli; ?>">
					<input type="hidden" name="nama_pasien" value="<?php echo strtoupper($data_pasien_daftar_ulang->nama); ?>">
					<input type="hidden" name="no_register_lama" value="<?php echo $data_pasien_daftar_ulang->no_register_lama; ?>">
					<div class="form-group row">
						<p class="col-sm-4 form-control-label" id="lbl_ket_pulang">Status Pulang</p>
						<div class="col-sm-8">
							<div class="form-inline">
								<div class="form-group">
									<select class="form-control custom-select" name="ket_pulang" id="ket_pulang" onchange="pilih_ket_pulang(this.value)" required>
										<option value="">-Pilih Ket Pulang-</option>
										<option value="PULANG">Pulang</option>
										<option value="KONTROL">Kontrol</option>
										<option value="DIRUJUK_RAWATJALAN">Dirujuk Rawat Jalan</option>
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
									foreach ($poliklinik as $row) {
										echo '<option value="' . $row->id_poli . '">' . $row->nm_poli . '</option>';
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

					<div class="form-group row" id="div_jam_kontrol">
						<p class="col-sm-4 form-control-label" id="lbl_jam_kontrol">Jam Kontrol</p>
						<div class="col-sm-8">
							<div class="form-inline">
								<div class='input-group clockpicker'>
									<input type="text" id="jam_kontrol_ulang" class="form-control" placeholder="Jam Kontrol Ulang" name="jam_kontrol_ulang">
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group row" id="div_tgl_kontrol">
						<p class="col-sm-4 form-control-label" id="lbl_tgl_kontrol">Tanggal Kontrol</p>
						<div class="col-sm-8">
							<div class="form-inline">
								<div class="form-group">
									<input type="text" id="date_picker" class="form-control" name="tgl_kontrol">
								</div>
							</div>
						</div>
					</div>
					<!-- add jam kontrol ulang -->
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
								<div class='input-group clockpicker'>
									<input type="text" id="jam_periksa" class="form-control" placeholder="Jam Periksa" name="jam_periksa">
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group row" id="div_catatan">
						<p class="col-sm-4 form-control-label">Alasan</p>
						<div class="col-sm-8">
							<textarea class="form-control" name="note_pulang" id="note_pulang" cols="25" rows="3" style="resize:vertical"></textarea>
						</div>
					</div>
					<div class="form-group row" id='div_tindak_lanjut'>
						<p class="col-sm-4 form-control-label" id="lbl_tindak">Tindak Lanjut</p>
						<div class="col-sm-8">
							<textarea class="form-control" name="tindak_lanjut" id="tindak_lanjut" cols="25" rows="3" style="resize:vertical"></textarea>
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
								<input type="checkbox" class="filled-in" value="Y" name="infeksi" id="check_infeksi" />
								<label for="check_infeksi">Infeksi</label>
							</div>
						</div>
					</div>


					<div class="form-group row" id='div_alasan_fasilitas'>
						<p class="col-sm-4 form-control-label" id="lbl_tindak">Alasan</p>
						<div class="col-sm-8">
							<textarea class="form-control" name="alasan_fasilitas" id="alasan_fasilitas" cols="25" rows="3" style="resize:vertical"></textarea>
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
							<textarea class="form-control" name="tindakan_asal" id="tindakan_asal" cols="25" rows="3" style="resize:vertical"></textarea>
						</div>
					</div>

					<div class="form-group row" id='div_kesan'>
						<p class="col-sm-4 form-control-label" id="lbl_diagnosis_awal">Kesan</p>
						<div class="col-sm-8">
							<textarea class="form-control" name="kesan" id="diagnosis_awal" cols="25" rows="3" style="resize:vertical"></textarea>
						</div>
					</div>


					<div class="form-group row" id='div_anjuran'>
						<p class="col-sm-4 form-control-label">Anjuran</p>
						<div class="col-sm-8">
							<textarea class="form-control" name="anjuran" id="anjuran" cols="25" rows="3" style="resize:vertical"></textarea>
						</div>
					</div>


					<!-- added Kebutuhan Bikin Surat Kontrol BPJS -->
					<div class="form-group row" id="div_surat_kontrol">
						<p class="col-sm-4 form-control-label" id="lbl_jam_kontrol">No. Surat Kontrol BPJS</p>
						<div class="col-sm-8">
							<div class="form-inline">
								<div class='input-group'>
									<!-- <input type="text" id="no_surat_kontrol" class="form-control" placeholder="Masukan Surat Kontrol / Buat " name="no_surat_kontrol"> -->
									<span class="input-group-addon">
										<button type="button" id="btn-buatnosuratkontrol" class="btn btn-primary">Buat No. Surat Kontrol</button>
									</span>
								</div>
							</div>
						</div>
					</div>

					<?php if ($statfisik != 'show') { ?>
						<div class="form-group row" id="div_cetak_prmrj">
							<input class="col-sm-4 form-control-label" type="checkbox" name="cetak_prmrj" id="cetak_prmrj">
							<label for="cetak_prmrj">Cetak PRMRJ</label>
						</div>
					<?php } ?>
					<input type="hidden" class="form-control" value="<?php echo $id_poli; ?>" name="id_poli">
					<input type="hidden" class="form-control" value="<?php echo $no_register; ?>" name="no_register">
					<div class="form-group row">
						<div class="offset-sm-4 col-sm-8">
							<button type="submit" class="btn btn-primary" id="btn-simpan-pulang">Simpan</button>
							<button type="reset" class="btn btn-warning">Reset</button>
							<!-- <button type="button" onclick="cetak_resume()" class="btn btn-primary">Cetak</button> -->
						</div>
					</div>
					<?php echo form_close(); ?>

				</div>
			</div>

		</div>
		<div class="col-md-6">
			<div class="card card-outline-info ">
				<div class="card-header text-white" align="center">Pelayanan Pasien</div>
				<div class="card-body p-5">
					<table class=" datatable table  table-striped">
						<thead>
							<tr>
								<th>Nama Form</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<tr id="tab_fisiknya">
								<td>Pemeriksaan Fisik</td>
								<td>
									<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/pem_fisik/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
								</td>
							</tr>

							<tr id="tab_cppt">
								<td>CPPT</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/assesment_medik_dok/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/cppt_rajal/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<?php 
							if($id_poli == 'BH00'){ ?>
								<tr id="tab_resepmata">
									<td>Resep Mata</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/resep_mata/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/resep_kacamata/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								<tr id="tab_resepmata">
									<td>Laporan Pembedahan</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/lap_pembedahan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/lap_pemebedahan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>
							<?php }
							?>

							<?php 
							if($id_poli == 'CF00'){ ?>
								<tr id="tab_fisikrehab">
									<td>Layanan Kedokteran Fisik dan Rehabilitasi</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/program_terapi_rehab/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/program_terapi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

								<tr id="tab_ujifungsi">
									<td>Hasil Tindakan Uji Fungsi/Prosedur Layanan Kedokteran Fisik dan Rehabilitasi</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/uji_fungsi_rehab/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/hasil_uji_fungsi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								<tr id="tab_ujifungsidok">
									<td>Hasil Tindakan Uji Fungsi/Prosedur Layanan Kedokteran Fisik dan Rehabilitasi perawat</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/uji_fungsi_rehab/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/hasil_uji_fungsi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

						

								<tr id="tab_program_terapi">
									<td>Layanan Kedokteran Fisik dan Rehabilitasi(Program Terapi)</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/program_terapi_rehab/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/program_terapi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>
							<?php }
							?>

							<?php 
							if($id_poli == 'CE00'){ ?>
								<tr id="tab_program_terapi">
									<td>Layanan Kedokteran Fisik dan Rehabilitasi(Program Terapi)</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/program_terapi_rehab/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/program_terapi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>
								<tr id="tab_cppt">
								<td>CPPT</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/assesment_medik_dok/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/cppt_rajal/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</tdf>
							</tr>
							<?php 	}
								
								?>


							<?php 
							// anak
							if($id_poli == 'BC00'){ ?> 

								<tr id="tab_keperawatan_anak">
									<td>Pengkajian Keperawatan Anak</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/keperawatan_anak/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_anak/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								<tr id="tab_medik_anak">
									<td>Pengkajian Medik Anak</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/medik_anak/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_medis_anak/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>
								<tr id="tab_asuhan_gizi_anak">
								<td>Asuhan Gizi Anak</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/asuhan_gizi_anak/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<!-- <form action="<?= base_url('emedrec/C_emedrec/surat_rujukan_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form> -->
									</div>
								</td>
							</tr>

							<?php 
							// tht
							}else if($id_poli == 'BI00'){ ?>

								<tr id="tab_assesmentkeperawatannya">
									<td>Pengkajian Keperawatan</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/pengkajian_keperawatan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>


								<tr id="tab_tht">
									<td>Pengkajian THTKL</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengkajian_tht/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_tht/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

							<?php }else if($id_poli == 'BG00'){?>
							<!-- gigi -->
								<tr id="tab_assesmentkeperawatannya">
									<td>Pengkajian Keperawatan</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/pengkajian_keperawatan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>


								<tr id="tab_gigi">
									<td>Pengkajian Medis Gigi</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengkajian_gigi/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_gigi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>
								<?php }else if($id_poli == 'CD00'){?>
							<!-- PERIODENTIK -->
								


								<tr id="tab_gigi">
									<td>Pengkajian Medis Gigi</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengkajian_gigi/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_gigi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

								<?php }else if($id_poli == 'BK00'){?>

			
								<tr id="lap_echo">
									<td>Laporan Echocardiography</td>
									<td>
										<a target="_blank" href="<?php echo base_url('irj/rjcpelayananfdokter/form/lap_echo/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_blank" href="<?php echo base_url('emedrec/C_emedrec/lap_echo/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								<tr id="tab_medikdokternya">
									<td>Pengkajian Medis Dokter</td>
									<td>
										<div class="form-inline">
											<a target="_blank" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengkajian_medis/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_blank" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

								<?php }else if($id_poli == 'CH00'){?>
							

								<tr id="form_hiv">
									<td>Formulir Registrasi Layanan dan konseling Tes HIV</td>
									<td>
										<a target="_blank" href="<?php echo base_url('irj/rjcpelayananfdokter/form/formulir_hiv/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_blank" href="<?php echo base_url('emedrec/C_emedrec/formulir_registrasi_hiv/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								<tr id="persetujuan_hiv">
									<td>Formulir Persetujuan Tes HIV</td>
									<td>
										<a target="_blank" href="<?php echo base_url('irj/rjcpelayananfdokter/form/persetujuan_hiv/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_blank" href="<?php echo base_url('emedrec/C_emedrec/persetujuan_hiv/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								
						

								<?php }else if($id_poli == 'BM00'){?>
							<!-- gigi -->
								<tr id="tab_assesmentkeperawatannya">
									<td>Pengkajian Keperawatan</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/pengkajian_keperawatan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>


								<tr id="tab_gigi">
									<td>Pengkajian Medis Gigi</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengkajian_gigi/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_gigi/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

							<?php }else if($id_poli == 'BE00'){?>
							<!-- POLI KB DAN BB -->
								<tr id="tab_obgyn">
									<td>Pengkajian Keperawatan Obgyn</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/keperawatan_obgyn/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_keperawatan_obgyn/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

								<tr id="tab_obgyn_dokter">
									<td>Pengkajian Medik Obgyn</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/medik_obgyn/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_obgyn/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>
								
							<?php }else{ ?>
								<tr id="tab_assesmentkeperawatannya">
									<td>Pengkajian Keperawatan</td>
									<td>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/pengkajian_keperawatan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a>
									</td>
								</tr>

								<tr id="tab_medikdokternya">
									<td>Pengkajian Medis Dokter</td>
									<td>
										<div class="form-inline">
											<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengkajian_medis/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
											<form action="<?= base_url('emedrec/C_emedrec/pengkajian_medis_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
												<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
												<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
											</form>
										</div>
									</td>
								</tr>

							<?php }
							?>

							
							
							<tr id="tab_lab">
								<td>Laboratorium</td>
								<td>
									<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/lab/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
									<a target="_self" href="<?php echo base_url('emedrec/C_emedrec/cetak_history_laboratorium_all/' . $no_medrec); ?>" class="btn btn-primary">View</a>
								</td>
							</tr>

							<tr id="tab_rad">
								<td>Radiologi</td>
								<td>
									<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/rad/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
									<!-- <a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a> -->
								</td>
							</tr>

							<tr id="tab_pa">
								<td>Patologi Anatomi</td>
								<td>
									<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/pa/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
									<!-- <a target="_self" href="<?php echo base_url('emedrec/C_emedrec/pengkajian_rawat_jalan/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" class="btn btn-primary">View</a> -->
								</td>
							</tr>

							

							

							

							<tr id="tab_ringkasan_keluar_rj">
								<td>Ringkasan Keluar Pasien RJ</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/ringkasan_keluar_pasien_rj/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/ringkasan_keluar_rj/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>
							
							<tr id="tab_tindakannya">
								<td>Tindakan</td>
								<td>
									<?php if ($statfisik == 'show') { ?>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/tindakan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
									<?php } else { ?>
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/tindakan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
									<?php } ?>
								</td>
							</tr>
							
							<tr id="tab_operasinya">
								<td>Operasi</td>
								<td>
									<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/operasi/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
								</td>
							</tr>

							<tr id="tab_resepnya">
								<td>Resep</td>
								<td>
									<a target="_self" href="<?php echo base_url('irj/rjcpelayanan/form/resep/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
								</td>
							</tr>
							<tr id="tab_upload">
								<td>Upload pemeriksaan penunjang</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/upload_penunjang_rj/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Upload</a>
										<form action="<?= base_url('emedrec/C_emedrec/upload_penunjang_rj/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_kontrol_pasien">
								<td>Lembar Kontrol Pasien</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/lembar_kontrol/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/lembar_kontrol_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_konsul_pasien">
								<td>Lembar Konsultasi</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/lembar_konsul/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/lembar_konsul_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_jawaban_konsul_pasien">
								<td>Lembar Jawaban Konsultasi</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/lembar_jawaban_konsul/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/lembar_jawaban_konsul_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_pengantar_ranap">
								<td>Pengantar Rawat Inap</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pengantar_ranap/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/pengantar_surat_ranap/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_transfusi_darah">
								<td>Permintaan Transfusi Darah</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/transfusi_darah/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/permintaan_transfusi_darah/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_persetujuan_medik">
								<td>Persetujuan Tindakan Medik</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/persetujuan_tindakan_medik/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/persetujuan_tindakan_medik/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_penolakan_medik">
								<td>Penolakan Tindakan Medis</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/penolakan_tindakan_medik/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/penolakan_tindakan_medik/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_surat_rujukan">
								<td>Surat Rujukan</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/surat_rujukan/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/surat_rujukan_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form>
									</div>
								</td>
							</tr>

							<tr id="tab_pa">
								<td>Patologi Anatomi</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/pa/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<form action="<?= base_url('emedrec/C_emedrec/surat_rujukan_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<!-- <button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button> -->
										</form>
									</div>
								</td>
							</tr>
							<tr id="tab_asuhan_gizi">
								<td>Asuhan Gizi</td>
								<td>
									<div class="form-inline">
										<a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/asuhan_gizi/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
										<!-- <form action="<?= base_url('emedrec/C_emedrec/surat_rujukan_pasien/' . $no_register . '/' . $no_cm . '/' . $no_medrec); ?>" method="post">
											<input type="hidden" name="poli" value="<?= $nm_poli; ?>">
											<button type="submit" class="btn btn-primary" formtarget="_self" style="margin-left: 5px;"> View</button>
										</form> -->
									</div>
								</td>
							</tr>
							
							
							

									<tr id="tab_diagnosanya">
                                        <td>Diagnosa</td>
                                        <td>
                                             <a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/diagnosa/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Input</a>
                                        </td>
                                    </tr>
                                    <!-- <tr id="tab_prosedurnya">
                                        <td>Procedure</td>
                                        <td>
                                             <a target="_self" href="<?php echo base_url('irj/rjcpelayananfdokter/form/procedure/' . $id_poli . '/' . $no_register); ?>" class="btn btn-primary">Lihat</a>
                                        </td>
                                    </tr> -->
						</tbody>
					</table>
				</div>
			</div>
			<!-- </div> -->
		</div>
	</div>
</section>


<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form id="#">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">E-Retensi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="table">
						<table width="100%">
							<tr>
								<th>No.</th>
								<th>Nama File</th>
								<th>Aksi</th>
							</tr>
							<tbody id="hasilPencarian"></tbody>
						</table>
					</div>
					<!-- <div id="hasilPencarian"></div> -->
				</div>

			</div>
		</div>
	</form>
</div>



<div class="modal fade bd-example-modal-lg" id="modalbuatsuratkontrol" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<form id="formbuatsuratkontrol">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Pembuatan Surat Kontrol</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="">
						<div class="form-group row">
							<p class="col-2 form-control-label">SEP</p>
							<div class="col">
								<input type="text" class="form-control" name="sep" value="<?= $data_pasien_daftar_ulang->no_sep ?>"></input>
							</div>
						</div>
						<div class="form-group row">
							<p class="col-2 form-control-label">Poliklinik</p>
							<div class="col">
								<select class="form-control custom-select" id="poli-surat-kontrol" name="poli">
									<option value="">Pilih Poli Tujuan Kontrol</option>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<p class="col-2 form-control-label">Dokter</p>
							<div class="col">
								<select class="form-control custom-select" id="dokter-surat-kontrol" name="dokter">
									<option value="">Pilih Dokter</option>
								</select>
							</div>
						</div>

						<div class="form-group row">
							<p class="col-2 form-control-label">Tgl. Rencana kontrol</p>
							<div class="col">
								<input type="text" class="form-control" id="tgl-surat-kontrol" name="tglrencanakontrol"></input>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" type="button" class="btn btn-primary">Buat Surat Kontrol</button>
				</div>
			</div>
		</div>
	</form>
</div>
<script>
	function icare()
		{
			<?php 
			$dokterpilihan = '';
				foreach($dokter_tindakan2 as $row){

					if($row->id_dokter==$id_dokterrawat) {
						$dokterpilihan = $row->kode_dpjp_bpjs;
					}					
				}
				?>
			let nokartu = '<?= $data_pasien_daftar_ulang->no_kartu ?>';
			let dokterbpjs = '<?= $dokterpilihan ?>';
			if(nokartu == '' || nokartu == null){
				new swal({
					title: "Perhatian",
					text: "Mohon lengkapi data No. Kartu Pasien & Data Dokter HFIS",
					type: "error",
					showCancelButton: false,
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				});
				return;
			}
			$.ajax({  
					url:`<?php echo base_url(); ?>/antrol/icare?hit=1&pilihan=${dokterbpjs}&nokartu=${nokartu}`,
					success: function(data)  
					{ 
						if(data.response == null)
						{
							new swal({
								title: "Perhatian",
								text: data.metaData.message,
								type: "error",
								showCancelButton: false,
								closeOnConfirm: false,
								showLoaderOnConfirm: true
							});
							return;
						}
						window.open(data.response.url, '_blank', 'location=yes,height=1280,width=1280,scrollbars=yes,status=yes');
						
						
					},
					error:function(event, textStatus, errorThrown) {
						swal("Error","Data gagal disimpan.", "error"); 
						console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
					}  
					});  
		}
	$('#formbuatsuratkontrol').on('submit', function(e) {
		e.preventDefault();
		let data = $('#formbuatsuratkontrol').serialize();
		$.ajax({
			url: "<?php echo base_url(); ?>bpjs/rencanakontrol/insert_surat_kontrol",
			method: "POST",
			data: data,
			dataType: 'json',
			success: function(data) {
				if (data.metaData.code == '200') {
					$('#no_surat_kontrol').val(data.response.noSuratKontrol);
				}
				// console.log(data);
				new swal({
						title: "Selesai",
						text: "Data berhasil disimpan",
						type: "success",
						showCancelButton: false,
						closeOnConfirm: false,
						showLoaderOnConfirm: true,
						willClose: () => {}
					},
					function() {});
			},
			error: function(event, textStatus, errorThrown) {
				new swal("Error", "Data gagal disimpan.", "error");
				console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
			}
		});
	})
</script>

<div class="modal fade" id="modalMultipleFile" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-success">

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Combined View RJ & RI</h4>
			</div>
			<div class="modal-body">
				<table class="datatableModalD nowrap table table-striped" cellspacing="110">
					<thead style="display: none;">
						<th>Form</th>
					</thead>
					<tbody>
						<tr class="clickable-row" data-href="<?= base_url('emedrec/C_emedrec_iri/konsul_rj_ri/' . $data_pasien_daftar_ulang->no_cm . '/' . $data_pasien_daftar_ulang->no_medrec); ?>">
							<td>Konsul</td>
						</tr>
						<tr class="clickable-row" data-href="<?= base_url('emedrec/C_emedrec_iri/cppt_rj_ri/' . $data_pasien_daftar_ulang->no_cm . '/' . $data_pasien_daftar_ulang->no_medrec); ?>">
							<td>CPPT</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function($) {
		$(".clickable-row").click(function() {
			window.open($(this).data("href"), '_self');
		});
	});

	$('.datatableModalD').DataTable({
		paging: false,
		ordering: false,
		info: false,
		"lengthChange": false,
		pagingType: "simple"
	});
</script>
<style>
	/* .dataTables_wrapper .dataTables_paginate .paginate_button {
		border: 0.5px solid #828282;
		font-size: 12px;
		margin-right: 10px;
	}

	.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
		border: 0px;
	} */

	.datatableModalD tr {
		cursor: pointer;
	}

	.datatableModalD tr:hover td {
		-moz-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
		-webkit-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
		box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
	}

	.datatableModalD tr:hover td:first-child {
		-moz-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
		-webkit-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
		box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
	}

	.datatableModalD tr:hover td:last-child {
		-moz-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
		-webkit-box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
		box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.8);
	}

	.datatableModalD tr:hover td:after {
		content: "";
		width: 3px;
		height: 100%;
		background-color: #F5F8FB;
		position: absolute;
		right: 0;
		top: 0;
		z-index: 1;
	}
</style>

<?php
if ($role_id == 1) {
	$this->load->view("layout/footer_left");
} else {
	$this->load->view("layout/footer_horizontal");
}
?>