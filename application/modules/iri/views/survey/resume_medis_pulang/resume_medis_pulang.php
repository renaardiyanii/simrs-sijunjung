<?php
$this->load->view('layout/header_form');
?>
<style>
	.ui-autocomplete-loading {
		background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
	}

	.ui-autocomplete {
		max-height: 270px;
		overflow-y: scroll;
		overflow-x: scroll;
	}
</style>
<script>
	var table_diagnosa_resume;
	var table_procedure_resume;
	var site = "<?php echo site_url(); ?>";

	$(document).ready(function() {
		table_diagnosa_resume = $('#table_diagnosa_resume').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"lengthMenu": [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"ajax": {
				"url": "<?php echo site_url('iri/rictindakan/diagnosa_pasien') ?>",
				"type": "POST",
				"dataType": 'JSON',
				"data": function(data) {
					data.no_register = '<?php echo $data_pasien[0]['no_ipd']; ?>';
				}
			},
			"columnDefs": [{
				"orderable": false, //set not orderable
				"targets": [0, 4], // column index 
				"defaultContent": "-",
				"targets": "_all"
			}],
		});

		table_procedure_resume = $('#table_procedure_resume').DataTable({
			"processing": true,
			"serverSide": true,
			"order": [],
			"lengthMenu": [
				[10, 25, 50, -1],
				['10 rows', '25 rows', '50 rows', 'Show all']
			],
			"lengthMenu": [
				[10, 25, 50, -1],
				[10, 25, 50, "All"]
			],
			"ajax": {
				"url": "<?php echo site_url('iri/rictindakan/procedure_pasien') ?>",
				"type": "POST",
				"dataType": 'JSON',
				"data": function(data) {
					data.no_register = '<?php echo $data_pasien[0]['no_ipd']; ?>';
				}
			},
			"columnDefs": [{
				"orderable": false, //set not orderable
				"targets": [0, 4], // column index 
				"defaultContent": "-",
				"targets": "_all"
			}],
		});

		$('#nilai').val(function(_, val) {
			return val.split('\n').slice(1).join('\n');
		});
	});

	$(function() {
		// Clock pickers
		$(".autocomplete_procedure").autocomplete({
			minLength: 2,
			source: function(request, response) {
				$.ajax({
					url: '<?php echo site_url('ird/rdcpelayanan/autocomplete_procedure') ?>',
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						if (!data.length) {
							var result = [{
								label: 'Data tidak ditemukan',
								value: response.term
							}];
							response(result);
						} else {
							response(data);
						}
					}
				});
			},
			minLength: 1,
			select: function(event, ui) {
				$('#cari_prosedur').val(ui.item.id_tind + '-' + ui.item.nm_tindakan);
				$('#id_procedure').val(ui.item.id_tind);
				$('#procedure_separate').val(ui.item.nm_tindakan);
			}
		}).on("focus", function() {
			$(this).autocomplete("search", $(this).val());
		});

		$(".autocomplete_diagnosa").autocomplete({
			minLength: 2,
			source: function(request, response) {
				$.ajax({
					url: '<?php echo site_url('ird/rdcpelayanan/autocomplete_diagnosa') ?>',
					dataType: "json",
					data: {
						term: request.term
					},
					success: function(data) {
						if (!data.length) {
							var result = [{
								label: 'Data tidak ditemukan',
								value: response.term
							}];
							response(result);
						} else {
							response(data);
						}
					}
				});
			},
			minLength: 1,
			select: function(event, ui) {
				$('#diagnosa1').val(ui.item.id_icd);
				$('#diagnosa1').val('' + ui.item.id_icd);
				$('#diagnosa2_name').val(ui.item.id_icd + ' - ' + ui.item.nm_diagnosa)
				$('#id_row_diagnosa2').val('' + ui.item.id_icd);
				$('#nm_diagnosa2').val('' + ui.item.nm_diagnosa);
			}
		}).on("focus", function() {
			$(this).autocomplete("search", $(this).val());
		});


	});
	jQuery(function($) {

		$('.clockpicker').clockpicker({
			donetext: 'Done',
		}).find('input').change(function() {
			console.log(this.value);
		});
	});

	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_no_register_dokter').autocomplete({
			serviceUrl: site + '/iri/ricpendaftaran/data_dokter_autocomp',
			onSelect: function(suggestion) {
				$('#id_dokter').val('' + suggestion.id_dokter);
				$('#dokter').val('' + suggestion.nm_dokter);
			}
		});
	});

	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_no_register_dokter_pengirim').autocomplete({
			serviceUrl: site + '/iri/ricpendaftaran/data_dokter_autocomp',
			onSelect: function(suggestion) {
				$('#drpengirim').val('' + suggestion.nm_dokter);
			}
		});
	});

	var site = "<?php echo site_url(); ?>";
	$(function() {
		$('.auto_no_register_dokter_konsulen').autocomplete({
			serviceUrl: site + '/iri/ricpendaftaran/data_dokter_autocomp',
			onSelect: function(suggestion) {
				$('#drkonsulen').val('' + suggestion.nm_dokter);
			}
		});
	});

	function diagSet(diag) {
		var myarr = diag.split("-");
		console.log(myarr[0]);
		console.log(myarr[1]);

		$('#diagnosa1').val('' + myarr[0]);
		$('#diagnosa2_name').val(myarr[0] + ' - ' + myarr[1])
		$('#id_row_diagnosa2').val('' + myarr[0]);
		$('#nm_diagnosa2').val('' + myarr[1]);
	}

	function submitDiagnosa() {
		let no_ipd = $('#no_ipd_h').val();
		let id_diagnosa = $('#id_row_diagnosa2').val();
		let nm_diagnosa = $('#nm_diagnosa2').val();
		let diagnosa_text = $('#diagnosa_text').val();

		$.ajax({
			url: "<?php echo site_url('iri/rictindakan/tambah_diagnosa_proses'); ?>",
			type: "POST",
			data: {
				'no_ipd_h': no_ipd,
				'id_row_diagnosa2': id_diagnosa,
				'nm_diagnosa2': nm_diagnosa,
				'diagnosa_text': diagnosa_text
			},
			dataType: "JSON",
			success: function(data) {


				if (data.code == '500') {
					new Swal({
						icon: 'info',
						title: 'Perhatian!!',
						text: 'Diagnosa harus diisi',
						showConfirmButton: false,
						timer: 1500
					});
				} else {
					console.log(data);
					table_diagnosa_resume.ajax.reload();
					$('#diagnosa1').val('');
					$('#diagnosa1').val('');
					$('#diagnosa2_name').val('');
					$('#id_row_diagnosa2').val('');
					$('#nm_diagnosa2').val('');
					$(".autocomplete_diagnosa").val('');
				}

			},
			error: function(jqXHR, textStatus, errorThrown) {
				window.location.reload();
				alert(errorThrown);
			}
		});
	}

	function set_utama_diagnosa(id_diagnosa_pasien) {

		$.ajax({
			type: 'POST',
			url: "<?php echo site_url('ird/diagnosa/set_utama') ?>",
			dataType: "JSON",
			data: {
				"id_diagnosa_pasien": id_diagnosa_pasien,
				"no_register": '<?php echo $data_pasien[0]['no_ipd']; ?>'
			},
			success: function(data) {
				if (data == true) {
					table_diagnosa_resume.ajax.reload();
					new Swal({
						icon: 'success',
						title: 'Diagnosa berhasil di set menjadi utama',
						showConfirmButton: false,
						timer: 1500
					});
					table_diagnosa_resume.ajax.reload();
				} else {
					new Swal({
						icon: 'error',
						title: 'Gagal men-set utama diagnosa. Silahkan coba lagi.',
						showConfirmButton: false,
						timer: 1500
					});
					table_diagnosa_resume.ajax.reload();
				}
			},
			error: function(event, textStatus, errorThrown) {
				new Swal({
					icon: 'error',
					title: 'Gagal me-set utama',
					text: formatErrorMessage(event, errorThrown),
					showConfirmButton: false,
					timer: 1500
				});
			},
		});

	}

	function delete_diagnosa(id) {

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() . 'ird/diagnosa/delete'; ?>",
			dataType: "JSON",
			data: {
				"id_diagnosa_pasien": id,
				"no_register": '<?php echo $data_pasien[0]['no_ipd']; ?>'
			},
			success: function(data) {
				if (data == true) {
					table_diagnosa_resume.ajax.reload();
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
			error: function(event, textStatus, errorThrown) {
				new Swal({
					icon: 'error',
					title: 'Gagal Menghapus Data.',
					showConfirmButton: false,
					timer: 1500
				});
			}
		});


	}

	function submitProsedur() {
		let no_ipd = $('#no_register_resume').val();
		let id_dokter = $('#id_dokter_resume').val();
		let id_poli = $('#id_poli_resume').val();

		let id_procedure = $('#id_procedure').val();
		let nm_procedure = $('#procedure_separate').val();
		console.log(no_ipd);
		console.log(id_dokter);
		console.log(id_poli);
		console.log(id_procedure);
		console.log(nm_procedure);

		$.ajax({
			url: "<?php echo site_url('iri/rictindakan/tambah_prosedur_proses'); ?>",
			type: "POST",
			data: {
				'no_ipd': no_ipd,
				'id_dokter': id_dokter,
				'id_poli': id_poli,
				'id_procedure': id_procedure,
				'nm_procedure': nm_procedure
			},
			dataType: "JSON",
			success: function(data) {

				console.log(data.code);

				table_procedure_resume.ajax.reload();

				$('#cari_prosedur').val('');
				$('#id_procedure').val('');
				$('#procedure_separate').val('');
				$(".autocomplete_procedure").val('');
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// window.location.reload();
				alert(errorThrown);
			}
		});
	}

	function set_utama_procedure(id) {

		$.ajax({
			type: 'POST',
			url: "<?php echo site_url('iri/rictindakan/set_utama_procedure') ?>",
			dataType: "JSON",
			data: {
				"id": id,
				"no_register": "<?php echo $data_pasien[0]['no_ipd']; ?>"
			},
			success: function(data) {
				if (data == true) {
					table_procedure_resume.ajax.reload();
					new Swal({
						icon: 'success',
						title: 'Prosedur berhasil di set utama.',
						showConfirmButton: false,
						timer: 1500
					});
				} else {
					new Swal({
						icon: 'error',
						title: 'Gagal men-set utama prosedur. Silahkan coba lagi.',
						showConfirmButton: false,
						timer: 1500
					});
				}
			},
			error: function(event, textStatus, errorThrown) {
				console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
			},
		});

	}

	function delete_procedure(id) {

		$.ajax({
			type: "POST",
			url: "<?php echo base_url() . 'iri/rictindakan/hapus_procedure'; ?>",
			dataType: "JSON",
			data: {
				"id": id,
				"no_register": "<?php echo $data_pasien[0]['no_ipd']; ?>"
			},
			success: function(data) {
				if (data == true) {
					table_procedure_resume.ajax.reload();
					new Swal({
						icon: 'success',
						title: 'Prosedur berhasil dihapus.',
						showConfirmButton: false,
						timer: 1500
					});
					// document.getElementById("form_add_procedure").reset();
				} else {
					new Swal({
						icon: 'error',
						title: 'Gagal menghapus data. Silahkan coba lagi.',
						showConfirmButton: false,
						timer: 1500
					});
				}
			},
			error: function(event, textStatus, errorThrown) {
				new Swal({
					icon: 'error',
					title: 'Gagal Menghapus prosedur',
					showConfirmButton: false,
					timer: 1500
				});
				console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
			}
		});

	}
</script>
<div class="card m-5">
	<div class="card-header">
		<h5>DIAGNOSA AKHIR</h5>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('iri/ricresume/simpan_resume'); ?>" method="post">
		<div class="card-body">
			<?php echo $this->session->flashdata('pesan'); ?>
			<?php echo $this->session->flashdata('success_msg'); ?>

			<!-- Form Resume Medik -->
			<div class="p-20">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label for="" class="col-sm-1 col-form-label">Diagnosa</label>
							<div class="col-sm-12">
								<input type="text" class="form-control input-sm autocomplete_diagnosa" name="id_diagnosa" id="id_diagnosa" style="font-size:15px;" required>
								<input type="hidden" name="diagnosa1" id="diagnosa1"><br>
							</div>
							<label for="" class="col-sm-1 col-form-label">Catatan</label>
							<div class="col-sm-12">
								<textarea name="diagnosa_text" id="diagnosa_text" cols="30" rows="10" class="form-control"></textarea> <br>
							</div>
							<div class="col-sm-2">
								<input type="hidden" value="" name="diagnosa2_name" id="diagnosa2_name" />
								<input type="hidden" value="" id="id_row_diagnosa2" name="id_row_diagnosa2" />
								<input type="hidden" value="" id="nm_diagnosa2" name="nm_diagnosa2" />
								<input type="hidden" name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd']; ?>" />
							</div>
						</div>


					</div>
				</div>

			</div>
		</div>
		<div class="card-footer">
			<button type="button" class="btn btn-primary btn-sm" onclick="submitDiagnosa()"><i class="fa fa-plus"></i> Tambah Diagnosa</button>

		</div>
	</form>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>History Diagnosa</h5>
	</div>
	<div class="card-body">
		<div class="form-group">
			<table id="table_diagnosa_resume" class="table table-bordered" style="width: 100%;">
				<thead>
					<tr>
						<td>No</td>
						<td>Diagnosa</td>
						<td>Catatan</td>
						<td>Klasifikasi</td>
						<td>Aksi</td>
					</tr>
				</thead>
				<tbody></tbody>
			</table>
		</div>

	</div>
</div>
<div class="card m-5">
	<div class="card-header">
		<h5>PROSEDUR AKHIR</h5>
	</div>
	<div class="card-body">
		<!-- Form Resume Medik -->
		<form class="form-horizontal" action="<?php echo site_url('iri/ricresume/simpan_resume'); ?>" method="post">
			<div class="p-20">
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group row">
							<label for="" class="col-sm-1 col-form-label">Prosedur</label>
							<div class="col-sm-9">
								<input type="text" class="form-control input-sm autocomplete_procedure" name="cari_prosedur" id="cari_prosedur" style="width:100%;font-size:15px;">
								<input type="hidden" class="form-control " name="id_procedure" id="id_procedure">
								<input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">
							</div>
							<div class="col-sm-2">
								<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['idrg']; ?>" name="id_poli_resume" id="id_poli_resume">
								<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd']; ?>" name="no_register_resume" id="no_register_resume">
								<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['dr_dpjp']; ?>" name="id_dokter_resume" id="id_dokter_resume">
								<button type="button" class="btn btn-primary btn-sm" onclick="submitProsedur()"><i class="fa fa-plus"></i> Tambah Prosedur</button>
							</div>
						</div>
						<br>

						<div class="form-group">
							<table id="table_procedure_resume" class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td>No</td>
										<td>Id Prosedur</td>
										<td>Prosedur</td>
										<td>Klasifikasi</td>
										<td>Aksi</td>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>

					</div>
				</div>

			</div> <!-- p-20 -->
		</form>
	</div>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>RESUME PULANG PASIEN RAWAT INAP *</h5>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('iri/ricresume/simpan_resume'); ?>" method="post">
		<div class="card-body">
			<div class="p-20">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group row mb-3">
							<label for="no_ipd" class="col-sm-4 col-form-label">No. Register</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'] ?>" name="no_ipd" id="no_ipd">
							</div>
						</div>
						<div class="form-group row  mb-3">
							<label for="no_cm" class="col-sm-4 col-form-label">No. RM</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['no_cm'] ?>" name="no_cm" id="no_cm">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="nama" class="col-sm-4 col-form-label">Nama</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['nama'] ?>" name="nama" id="nama">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['alamat'] ?>" name="alamat" id="alamat">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="tgl_lahir" class="col-sm-4 col-form-label">Tgl. Lahir</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo date('Y-m-d', strtotime($data_pasien[0]['tgl_lahir'])) ?>" name="tgl_lahir" id="tgl_lahir">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="tgl_masuk" class="col-sm-4 col-form-label">Tgl. Masuk</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>" name="tgl_masuk" id="tgl_masuk">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label class="col-sm-4 col-form-label">Tgl. Meninggal</label>
							<div class="col-sm-5">
								<input type="date" class="form-control" name="tgl_meninggal" id="tgl_meninggal" value="<?php echo $data_pasien[0]['tgl_meninggal'] ?>">
							</div>
							<div class="col-sm-3">
								<div class="input-group clockpicker" data-placement="bottom" data-align="top" data-autoclose="true">
									<input autocomplete="off" type="time" class="form-control" value="<?php echo $data_pasien[0]['jam_meninggal'] ?>" name="jam_meninggal" id="jam_meninggal"> <span class="input-group-addon"> <span class="fa fa-clock-o"></span> </span>
								</div>
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="kondisi_meninggal" class="col-sm-4 col-form-label">Kondisi Meninggal</label>
							<div class="col-sm-8">
								<select class="form-control" name="kondisi_meninggal" id="kondisi_meninggal">
									<option value="">-Pilih Waktu-</option>
									<option value="MENINGGALKRG48" <?php if ($data_pasien[0]['kondisi_meninggal'] == 'MENINGGALKRG48') echo 'selected'; ?>>Kurang dari 48 Jam</option>
									<option value="MENINGGALLBH48" <?php if ($data_pasien[0]['kondisi_meninggal'] == 'MENINGGALLBH48') echo 'selected'; ?>>Lebih dari 48 Jam</option>
								</select>
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="id_smf" class="col-sm-4 col-form-label">SMF</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['id_smf'] ?>" name="id_smf" id="id_smf">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label class="col-sm-4 col-form-label">Ruang</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['idrg'] ?>" name="idrg" id="idrg">
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['nmruang'] ?>" name="nmruang" id="nmruang">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label class="col-sm-4 col-form-label">Kelas / Bed</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['kelas'] ?>" name="kelas" id="kelas">
							</div>
							<div class="col-sm-5">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['bed'] ?>" name="bed" id="bed">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="" class="col-sm-4 col-form-label">Dr. Pengirim</label>
							<div class="col-sm-8">
								<input type="text" class="form-control auto_no_register_dokter_pengirim" value="<?php echo $data_pasien[0]['drpengirim'] ?>" name="drpengirim" id="drpengirim">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="" class="col-sm-4 col-form-label">Dokter yang Merawat</label>
							<div class="col-sm-8">
								<input type="hidden" value="<?php echo $data_pasien[0]['dr_dpjp'] ?>" name="id_dokter" id="id_dokter">
								<input type="text" class="form-control auto_no_register_dokter" value="<?php echo $data_pasien[0]['dokter'] ?>" name="dokter" id="dokter">
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group row mb-3">
							<label for="" class="col-sm-4 col-form-label">Anjuran</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" value="<?php echo $data_pasien[0]['anjuran'] ?>" name="anjuran" id="anjuran">
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="" class="col-sm-4 col-form-label">Keadaan Pulang *</label>
							<div class="col-sm-8">
								<select class="form-control" name="keadaanpulang">
									<option value="PERBAIKAN" <?php if ($data_pasien[0]['keadaanpulang'] == "PERBAIKAN") {
																	echo "selected='true'";
																} ?>>PERBAIKAN</option>
									<option value="PULANG" <?php if ($data_pasien[0]['keadaanpulang'] == "PULANG") {
																echo "selected='true'";
															} ?>>PULANG</option>
									<option value="BELUM_SEMBUH" <?php if ($data_pasien[0]['keadaanpulang'] == "BELUM_SEMBUH") {
																		echo "selected='true'";
																	} ?>>BELUM SEMBUH</option>
									<option value="MENINGGAL" <?php if ($data_pasien[0]['keadaanpulang'] == "MENINGGAL") {
																	echo "selected='true'";
																} ?>>MENINGGAL</option>
								</select>
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="" class="col-sm-4 col-form-label">Cara Pulang *</label>
							<div class="col-sm-8">
								<select class="form-control" name="cara_pulang">
									<option value="izin_dokter" <?php if ($data_pasien[0]['cara_pulang'] == "izin_dokter") {
																	echo "selected='true'";
																} ?>>IZIN DOKTER</option>
									<option value="rujuk" <?php if ($data_pasien[0]['cara_pulang'] == "rujuk") {
																echo "selected='true'";
															} ?>>RUJUK</option>
									<option value="aps" <?php if ($data_pasien[0]['cara_pulang'] == "aps") {
															echo "selected='true'";
														} ?>>APS</option>
									<option value="pindah_rs" <?php if ($data_pasien[0]['cara_pulang'] == "pindah_rs") {
																	echo "selected='true'";
																} ?>>PINDAH RS</option>

								</select>
							</div>
						</div>
						<div class="form-group row mb-3">
							<label for="" class="col-sm-4 col-form-label">Tgl Pulang *</label>
							<div class="col-sm-8">
								<input type="date" class="form-control" name="tgl_pulang" id="tgl_pulang" value="<?php echo $data_pasien[0]['tgl_keluar_resume'] ?>">
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>

		</div>
	</form>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>PENUNJANG</h5>
		<span class="text-muted">*Wajib Pilih Penunjang Yang Akan Ditampilkan di Resume</span>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('emedrec/C_emedrec_iri/add_penunjang_resume_medis_iri'); ?>" method="post">
		<div class="card-body">
			<!-- Form Resume Medik -->
			<div class="p-20">
				<div class="row">
					<div class="col-sm-12">
						<h4>•Rawat Inap</h4>
						<div class="form-group">
							<p class="font-weight-bold">Elektromedik</p>
							<table class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td></td>
										<td>No EM</td>
										<td>Id Tindakan</td>
										<td>Jenis Tindakan</td>
										<td>Tanggal Tindakan</td>
										<td>Dokter</td>
									</tr>
								</thead>

								<tbody>
									<?php
									if (!empty($list_em_pasien_iri)) {
										foreach ($list_em_pasien_iri as $row_em) {
									?>
											<tr>
												<td><input type="checkbox" name="jumlah_em[]" id="<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->id_pemeriksaan_em; ?>"><label for="<?php echo $row_em->id_pemeriksaan_em; ?>"></label></td>
												<td><input type="text" name="no_em-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->no_em; ?>" class="form-control" readonly></td>
												<td><input type="text" name="id_tindakan-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->id_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="jenis_tindakan-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->jenis_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="tgl_kunjungan-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->tgl_kunjungan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="nm_dokter-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->nm_dokter; ?>" class="form-control" readonly>
													<input type="hidden" name="id_pemeriksaan_em[]" id="id_pemeriksaan_em" value="<?php echo $row_em->id_pemeriksaan_em; ?>">
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="5">Data Kosong</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							<p class="font-weight-bold">Radiologi</p>
							<table class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td></td>
										<td>No RAD</td>
										<td>Id Tindakan</td>
										<td>Jenis Tindakan</td>
										<td>Tanggal Tindakan</td>
										<td>Dokter</td>
									</tr>
								</thead>

								<tbody>
									<?php
									if (!empty($list_rad_pasien_iri)) {
										foreach ($list_rad_pasien_iri as $row_rad) {
									?>
											<tr>
												<td><input type="checkbox" name="jumlah_rad[]" id="<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->id_pemeriksaan_rad; ?>"><label for="<?php echo $row_rad->id_pemeriksaan_rad; ?>"></label></td>
												<td><input type="text" name="no_rad-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->no_rad; ?>" class="form-control" readonly></td>
												<td><input type="text" name="id_tindakan-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->id_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="jenis_tindakan-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->jenis_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="tgl_kunjungan-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->tgl_kunjungan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="nm_dokter-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->nm_dokter; ?>" class="form-control" readonly>
													<input type="hidden" name="id_pemeriksaan_rad[]" id="id_pemeriksaan_rad" value="<?php echo $row_rad->id_pemeriksaan_rad; ?>">
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="5">Data Kosong</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							<p class="font-weight-bold">Laboratorium</p>
							<table class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td></td>
										<td>No LAB</td>
										<td>Id Tindakan</td>
										<td>Jenis Tindakan</td>
										<td>Nilai</td>
										<td>Tanggal Tindakan</td>
										<td>Dokter</td>
									</tr>
								</thead>

								<tbody>
									<?php
									if (!empty($list_lab_pasien_iri)) {
										foreach ($list_lab_pasien_iri as $row_lab) {
											$nilai = $this->M_emedrec_iri->get_nilai_hasil_lab($row_lab->no_lab, $row_lab->id_tindakan, $no_ipd)->result();
									?>
											<tr>
												<td><input type="checkbox" name="jumlah_lab[]" id="<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->id_pemeriksaan_lab; ?>"><label for="<?php echo $row_lab->id_pemeriksaan_lab; ?>"></label></td>
												<td><input type="text" name="no_lab-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->no_lab; ?>" class="form-control" readonly></td>
												<td><input type="text" name="id_tindakan-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->id_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="jenis_tindakan-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->jenis_tindakan; ?>" class="form-control" readonly></td>
												<td><textarea name="nilai" id="nilai" cols="30" rows="5" class="form-control" readonly>
														<?php foreach ($nilai as $row_nilai) { ?>
															- <?php echo $row_nilai->jenis_hasil; ?>: <?php echo $row_nilai->hasil_lab; ?>
														<?php }
														?>
													</textarea></td>
												<td><input type="text" name="tgl_kunjungan-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->tgl_kunjungan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="nm_dokter-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->nm_dokter; ?>" class="form-control" readonly>
													<input type="hidden" name="id_pemeriksaan_lab[]" id="id_pemeriksaan_lab" value="<?php echo $row_lab->id_pemeriksaan_lab; ?>">
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="5">Data Kosong</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div> <!-- p-20 -->
			<?php //if($id_poli_old == 'BA00'){ 
			?>
			<div class="p-20">
				<div class="row">
					<div class="col-sm-12">
						<h4>•Instalasi Gawat Darurat</h4>
						<div class="form-group">
							Elektromedik
							<table class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td></td>
										<td>No EM</td>
										<td>Id Tindakan</td>
										<td>Jenis Tindakan</td>
										<td>Tanggal Tindakan</td>
										<td>Dokter</td>
									</tr>
								</thead>

								<tbody>
									<?php
									if (!empty($list_em_pasien_igd)) {
										foreach ($list_em_pasien_igd as $row_em) {
									?>
											<tr>
												<td><input type="checkbox" name="jumlah_em_igd[]" id="<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->id_pemeriksaan_em; ?>"><label for="<?php echo $row_em->id_pemeriksaan_em; ?>"></label></td>
												<td><input type="text" name="no_em-igd-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->no_em; ?>" class="form-control" readonly></td>
												<td><input type="text" name="id_tindakan-igd-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->id_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="jenis_tindakan-igd-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->jenis_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="tgl_kunjungan-igd-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->tgl_kunjungan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="nm_dokter-igd-<?php echo $row_em->id_pemeriksaan_em; ?>" value="<?php echo $row_em->nm_dokter; ?>" class="form-control" readonly>
													<input type="hidden" name="id_pemeriksaan_em_igd[]" id="id_pemeriksaan_em" value="<?php echo $row_em->id_pemeriksaan_em; ?>">
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="5">Data Kosong</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							Radiologi
							<table class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td></td>
										<td>No RAD</td>
										<td>Id Tindakan</td>
										<td>Jenis Tindakan</td>
										<td>Tanggal Tindakan</td>
										<td>Dokter</td>
									</tr>
								</thead>

								<tbody>
									<?php
									if (!empty($list_rad_pasien_igd)) {
										foreach ($list_rad_pasien_igd as $row_rad) {
									?>
											<tr>
												<td><input type="checkbox" name="jumlah_rad_igd[]" id="<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->id_pemeriksaan_rad; ?>"><label for="<?php echo $row_rad->id_pemeriksaan_rad; ?>"></label></td>
												<td><input type="text" name="no_rad-igd-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->no_rad; ?>" class="form-control" readonly></td>
												<td><input type="text" name="id_tindakan-igd-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->id_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="jenis_tindakan-igd-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->jenis_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="tgl_kunjungan-igd-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->tgl_kunjungan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="nm_dokter-igd-<?php echo $row_rad->id_pemeriksaan_rad; ?>" value="<?php echo $row_rad->nm_dokter; ?>" class="form-control" readonly>
													<input type="hidden" name="id_pemeriksaan_rad_igd[]" id="id_pemeriksaan_rad" value="<?php echo $row_rad->id_pemeriksaan_rad; ?>">
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="5">Data Kosong</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>

						<div class="form-group">
							Laboratorium
							<table class="table table-bordered" style="width: 100%;">
								<thead>
									<tr>
										<td></td>
										<td>No LAB</td>
										<td>Id Tindakan</td>
										<td>Jenis Tindakan</td>
										<td>Nilai</td>
										<td>Tanggal Tindakan</td>
										<td>Dokter</td>
									</tr>
								</thead>

								<tbody>
									<?php
									if (!empty($list_lab_pasien_igd)) {
										foreach ($list_lab_pasien_igd as $row_lab) {
											$nilai = $this->M_emedrec_iri->get_nilai_hasil_lab($row_lab->no_lab, $row_lab->id_tindakan, $noregasal)->result();
									?>
											<tr>
												<td><input type="checkbox" name="jumlah_lab_igd[]" id="<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->id_pemeriksaan_lab; ?>"><label for="<?php echo $row_lab->id_pemeriksaan_lab; ?>"></label></td>
												<td><input type="text" name="no_lab-igd-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->no_lab; ?>" class="form-control" readonly></td>
												<td><input type="text" name="id_tindakan-igd-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->id_tindakan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="jenis_tindakan-igd-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->jenis_tindakan; ?>" class="form-control" readonly></td>
												<td><textarea name="nilai_igd" id="nilai_igd" cols="30" rows="5" class="form-control" readonly>
														<?php foreach ($nilai as $row_nilai) { ?>
															- <?php echo $row_nilai->jenis_hasil; ?>: <?php echo $row_nilai->hasil_lab; ?>
														<?php }
														?>
													</textarea></td>
												<td><input type="text" name="tgl_kunjungan-igd-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->tgl_kunjungan; ?>" class="form-control" readonly></td>
												<td><input type="text" name="nm_dokter-igd-<?php echo $row_lab->id_pemeriksaan_lab; ?>" value="<?php echo $row_lab->nm_dokter; ?>" class="form-control" readonly>
													<input type="hidden" name="id_pemeriksaan_lab_igd[]" id="id_pemeriksaan_lab" value="<?php echo $row_lab->id_pemeriksaan_lab; ?>">
												</td>
											</tr>
										<?php }
									} else { ?>
										<tr>
											<td colspan="5">Data Kosong</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<?php //}else{} 
			?>

			<div class="ribbon-content">
				<div class="row">
					<div class="col-md-12">
						<div class="form-actions">
							<hr>
							<input type="hidden" name="no_ipd" value="<?php echo $data_pasien[0]['no_ipd']; ?>" class="form-control">
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>
		</div>
	</form>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>OBAT</h5>
		<span class="text-xs text-muted">*Wajib Pilih Obat Yang Akan Ditampilkan di Resume</span>
	</div>
	<div class="card-body">

		<label for=""></label>
		<form class="form-horizontal" action="<?php echo site_url('emedrec/C_emedrec_iri/add_obat_resume_medis_iri'); ?>" method="post">
			<div class="ribbon-content">
				<!-- Form Resume Medik -->
				<div class="p-20">
					<div class="row">
						<div class="col-sm-12">
							<h4>•Rawat Inap</h4>
							<div class="form-group">
								<table class="table table-bordered" style="width: 100%;">
									<thead>
										<tr>
											<td></td>

											<td>Nama Obat</td>
											<td>Signa</td>
											<td>Tanggal Order</td>
											<td>Dokter</td>
										</tr>
									</thead>

									<tbody id="obatPulangKio">

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div> <!-- p-20 -->
				<button class="btn btn-primary" type="button" onclick="simpanResumeObat()">Simpan</button>
			</div> <!-- ribbon-content -->

			<?php if ($id_poli_old == 'BA00') { ?>
				<div class="ribbon-content">
					<div class="p-20">
						<div class="row">
							<div class="col-sm-12">
								<h4>•Instalasi Gawat Darurat</h4>
								<div class="form-group">
									<table class="table table-bordered" style="width: 100%;">
										<thead>
											<tr>
												<td></td>
												<td>No Resep</td>
												<td>Nama Obat</td>
												<td>Signa</td>
												<td>Tanggal Order</td>
												<td>Dokter</td>
											</tr>
										</thead>

										<tbody>
											<?php
											if (!empty($oabt_all_igd)) {
												foreach ($oabt_all_igd as $row_pay_gd) {
											?>
													<tr>
														<td><input type="checkbox" name="jumlah_resep_igd[]" id="<?php echo $row_pay_gd->id_resep_pasien; ?>" value="<?php echo $row_pay_gd->id_resep_pasien; ?>"><label for="<?php echo $row_pay_gd->id_resep_pasien; ?>"></label></td>
														<td><input type="text" name="no_resep-igd-<?php echo $row_pay_gd->id_resep_pasien; ?>" value="<?php echo $row_pay_gd->no_resep; ?>" class="form-control" readonly></td>
														<td><input type="text" name="nama_obat-igd-<?php echo $row_pay_gd->id_resep_pasien; ?>" value="<?php echo $row_pay_gd->nama_obat; ?>" class="form-control" readonly></td>
														<td><input type="text" name="signa-igd-<?php echo $row_pay_gd->id_resep_pasien; ?>" value="<?php echo $row_pay_gd->signa; ?>" class="form-control" readonly></td>
														<td><input type="text" name="tgl_kunjungan-igd-<?php echo $row_pay_gd->id_resep_pasien; ?>" value="<?php echo $row_pay_gd->tgl_kunjungan; ?>" class="form-control" readonly></td>
														<td><input type="text" name="nm_dokter-igd-<?php echo $row_pay_gd->id_resep_pasien; ?>" value="<?php echo $row_pay_gd->xinput; ?>" class="form-control" readonly>
															<input type="hidden" name="id_resep_pasien_igd[]" id="id_resep_pasien" value="<?php echo $row_pay_gd->id_resep_pasien; ?>">
														</td>
													</tr>
												<?php }
											} else { ?>
												<tr>
													<td colspan="5">Data Kosong</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } else {
			} ?>

			<div class="ribbon-content">
				<div class="row">
					<div class="col-md-12">
						<div class="form-actions">
							<hr>
							<input type="hidden" name="no_ipd" value="<?php echo $data_pasien[0]['no_ipd']; ?>" class="form-control">
							<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>
						</div>
					</div>
				</div>
			</div>

		</form>


		<?php if ($data_resume != '') { ?>
			<div class="ribbon-wrapper card">
				<div class="ribbon ribbon-info">RESUME EDIT</div>
				<div class="ribbon-content">
					<!-- Form Resume Medik -->
					<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/update_resume'); ?>" method="post">
						<div class="p-20">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group row">
										<label for="" class="col-sm-2 col-form-label">Riwayat Penyakit</label>
										<div class="col-sm-10">
											<textarea name="edit_riwayat_resume" id="edit_riwayat_resume" class="form-control" cols="30" rows="10"><?php echo $data_resume->riwayat_penyakit ?></textarea>
										</div>
									</div>
									<br>
									<div class="form-group row">
										<label for="" class="col-sm-2 col-form-label">Pemeriksaan Fisik</label>
										<div class="col-sm-10">
											<textarea name="edit_pemeriksaan_fisik" id="edit_pemeriksaan_fisik" class="form-control" cols="30" rows="10"><?php echo str_replace('<br>', PHP_EOL, $data_resume->pemeriksaan_fisik) ?></textarea>
										</div>
									</div>
									<br>
									<div class="form-group row">
										<label for="" class="col-sm-2 col-form-label">Penemuan Klinik</label>
										<div class="col-sm-10">
											<textarea name="edit_penemuan_klinik" id="edit_penemuan_klinik" class="form-control" cols="30" rows="10"><?php echo str_replace('<br>', PHP_EOL, $data_resume->penemuan_klinik) ?></textarea>
										</div>
									</div>
									<br>

								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="form-actions">
										<hr>
										<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd']; ?>" name="edit_no_register_resume" id="edit_no_register_resume">
										<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>
										<a class="btn btn-danger" target="_blank" href="<?php echo base_url() ?>emedrec/C_emedrec_iri/cetak_resume_medis_iri_last/<?php echo  $data_pasien[0]['no_ipd'] . '/' . $data_pasien[0]['no_medrec'] . '/' . $data_pasien[0]['no_cm']; ?>"><i class="fa fa-print"></i> Cetak Resume Medik</a>
									</div>
								</div>
							</div>
						</div> <!-- p-20 -->
					</form>
				</div> <!-- ribbon-content -->
			</div> <!-- card -->
		<?php } ?>
	</div>
</div>

<script>
	$('#calendar-tgl-lahir').datepicker();
	$('#calendar-tgl-masuk').datepicker();
	$('#calendar-tgl-meninggal').datepicker();
	$('#tgl_meninggal').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	let dataObatKioRanap = [];

	function getObatKioLast() {
		$.ajax({
			url: '<?= base_url('iri/rictindakan/get_last_obat_kio/' . $data_pasien[0]['no_ipd']) ?>',
			beforeSend: function() {
				$('#obatPulangKio').html('<tr><td colspan="6" style="text-align:center;"> Loading ... </td></tr>');
			},
			success: function(data) {
				let html = '';
				if (data.kio.question2.length > 0) {
					data.kio.question2.map((e, index) => {
						if (e.nm_obat !== undefined) {

							html += `
							<tr>
								<td>
								<input type="checkbox" name="check" id="checkbox-${index}" onchange='masukanObat(${JSON.stringify(e)},"checkbox-${index}")'>
								</td>
								<td>${e.nm_obat}</td>
								<td>${e.frekuensi??''}</td>
								<td>${data.tgl_resep}</td>
								<td></td>
							</tr>
							`;
						} else {
							if (e.obat_luar !== undefined) {
								html += `
								<tr>
									<td>
									
								<input type="checkbox" name="check"  id="checkbox-${index}" onchange='masukanObat(${JSON.stringify(e)},"checkbox-${index}")'>
									</td>
									<td>${e.obat_luar}</td>
									<td>${e.frekuensi??''}</td>
									<td>${data.tgl_resep??''}</td>
									<td></td>
								</tr>
								`;
							}
						}
						// jmlObatKioRanap++;
						// console.log(e);
						// dataObatKioRanap.push(e);

					});
					$('#obatPulangKio').html(html);
					return;
				}
				html = '<tr><td colspan="6" style="text-align:center;"> Data Kosong </td></tr>';
				$('#obatPulangKio').html(html);

			},
			error: function(xhr) { // if error occured
				$('#obatPulangKio').html('<tr><td colspan="6" style="text-align:center;"> Data Gagal Dimuat </td></tr>');

			},
			complete: function() {

			},
		});
	}

	function masukanObat(data, id) {
		let checked = $('#' + id).is(":checked");
		if (checked) {
			dataObatKioRanap.push(data);
		} else {
			const indexOfObject = dataObatKioRanap.findIndex(object => {
				return object.nm_obat === data.nm_obat;
			});
			dataObatKioRanap.splice(indexOfObject, 1);
		}
		console.log(dataObatKioRanap);
		return;

		// on simpan update
		// on load , load kembali datanya

	}

	function simpanResumeObat() {
		$.ajax({
			url: '<?= base_url('emedrec/C_emedrec_iri/add_obat_resume_mesid_kio_ri/' . $data_pasien[0]['no_ipd']) ?>',
			method: 'post',
			data: {
				data: dataObatKioRanap
			},
			beforeSend: function() {},
			success: function(data) {
				new Swal({
					icon: 'success',
					title: 'Berhasil Disimpan',
				});
			},
			error: function(xhr) { // if error occured
				new Swal({
					icon: 'error',
					title: 'Gagal Disimpan',
				});
			},
			complete: function() {

			},
		});
	}

	$(document).ready(function() {
		getObatKioLast();
	})
</script>