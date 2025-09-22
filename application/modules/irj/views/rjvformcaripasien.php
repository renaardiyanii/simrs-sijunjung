<?php
if ($role_id == 1) {
	$this->load->view("layout/header_left");
} else {
	$this->load->view("layout/header_left");
}
?>
<script type='text/javascript'>
	function cetakKartu(noMedrec) {
		window.location.href = 'st_cetak_kartu_pasien/' + noMedrec;
	}

	function create_sep(no_register) {
		new swal({
			title: "Pembuatan SEP",
			text: "Yakin akan membuat SEP dengan pasien tersebut?",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Buat SEP",
			showCancelButton: true,
			closeOnConfirm: false,
		}, function() {
			$.ajax({
				url: `<?= base_url('bpjs/sep/insert_sep') ?>/` + no_register,
				beforeSend: function() {

				},
				success: function(data) {
					if (data.metaData.code === '200') {
						$('#no_sep').val(data.response.sep.noSep);
						window.open('<?php echo base_url() . 'bpjs/sep/cetakan_sep/'; ?>' + no_register, '_blank');
					} else {
						new swal("Peringatan!", data.metaData.message, "warning");
					}
				},
				error: function(xhr) {
					new swal("Peringatan!", 'Hubungi Admin IT', "warning");

				},
				complete: function() {

				}
			});
			// window.open('<?php echo base_url() . 'bpjs/sep/insert_sep/'; ?>'+no_register, '_blank');
			// swal("Sukses", "Silahkan Cetak SEP", "success");
		});
	}

	$(function() {

		// add validation

		// Restricts input for the given textbox to the given inputFilter.
		function setInputFilter(textbox, inputFilter) {
			["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
				textbox.addEventListener(event, function() {
					if (inputFilter(this.value)) {
						this.oldValue = this.value;
						this.oldSelectionStart = this.selectionStart;
						this.oldSelectionEnd = this.selectionEnd;
					} else if (this.hasOwnProperty("oldValue")) {
						this.value = this.oldValue;
						this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
					} else {
						this.value = "";
					}
				});
			});
		}


		setInputFilter(document.getElementById("cari_no_cm"), function(value) {
			return /^-?\d*$/.test(value);
		});
		setInputFilter(document.getElementById("cari_no_kartu"), function(value) {
			return /^-?\d*$/.test(value);
		});
		setInputFilter(document.getElementById("cari_no_identitas"), function(value) {
			return /^-?\d*$/.test(value);
		});

		// end of add validation


		$('#tbl-pasien').DataTable({
			"language": {
				"emptyTable": "Data tidak tersedia."
			}
		});

		$('#tbl-detail').DataTable({
			"language": {
				"emptyTable": "Data tidak tersedia."
			}
		});



		$(document).on("click", ".create_sjp", function() {
			var no_register = $(this).data("noregister");
			swal({
				title: "CETAK SJP",
				text: "Yakin akan mencetak SJP dengan pasien tersebut?",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Cetak SJP",
				showCancelButton: true,
				closeOnConfirm: false,
				showLoaderOnConfirm: true,
			}, function() {
				$.ajax({
					type: "POST",
					url: "<?php echo base_url() . 'irj/Rjcsjp/cetak_sjp/'; ?>" + no_register,
					dataType: "JSON",
					success: function(result) {
						if (result.metaData.code == '200') {
							swal("Sukses", "Berhasil Cetak SJP", "success");
							window.location.reload();
						} else {
							swal("Gagal cetak SJP", result.metaData.message, "error");
						}
						window.location.reload();
					},
					error: function(event, textStatus, errorThrown) {
						swal("Gagal cetak SJP", formatErrorMessage(event, errorThrown), "error");
						console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
					}
				});
			});
		});

		$('.auto_search_by_nocm').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_nocm',
			onSelect: function(suggestion) {
				$('#cari_no_cm').val('' + suggestion.no_cm);
				$('#no_medrec_baru').val('' + suggestion.no_medrec);
			}
		});

		$('.auto_search_by_nocm_lama').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_nocm_lama',
			onSelect: function(suggestion) {
				$('#cari_no_cm_lama').val('' + suggestion.no_cm_lama);
			}
		});

		$('.auto_search_by_nokartu').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_nokartu',
			onSelect: function(suggestion) {
				$('#cari_no_kartu').val('' + suggestion.no_kartu);
			}
		});

		$('.auto_search_by_noidentitas').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_noidentitas',
			onSelect: function(suggestion) {
				$('#cari_no_identitas').val('' + suggestion.no_identitas);
			}
		});

		$('.auto_search_by_nonrp').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_nonrp3',
			onSelect: function(suggestion) {
				$('#cari_no_nrp').val('' + suggestion.no_nrp);
			}
		});

		$('.auto_search_by_nama').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_nama'
			/*onSelect: function (suggestion) {
				$('#cari_no_identitas').val(''+suggestion.no_identitas);
			}
			*/
		});

		$('.auto_search_by_alamat').autocomplete({
			serviceUrl: '<?php echo site_url(); ?>/irj/rjcautocomplete/data_pasien_by_alamat'
			/*onSelect: function (suggestion) {
				$('#cari_no_identitas').val(''+suggestion.no_identitas);
			}
			*/
		});

		// $('#cari_tgl').datepicker({
		// 	dateFormat: "dd-mm-yy",
		// 	changeMonth: true,
		// 	changeYear: true,
		// 	autoclose: true,
		// 	todayHighlight: true,
		// 	yearRange: "c-100:c+100",
		// });
	});

	function cek_search_per(val_search_per) {
		if (val_search_per == 'cm') {
			$("#cari_no_cm").css("display", ""); // To unhide
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "none"); // To hide
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "none");
		} else if (val_search_per == 'cm_lama') {
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", ""); // To unhide
			$("#cari_no_kartu").css("display", "none"); // To hide
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "none");
		} else if (val_search_per == 'kartu') {
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "");
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "none");
		} else if (val_search_per == 'identitas') {
			// To hide
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "none");
			$("#cari_no_identitas").css("display", "");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "none");
		} else if (val_search_per == 'nama') {
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "none");
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "none");
		} else if (val_search_per == 'nrp') {
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "none");
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "none");
		} else if (val_search_per == 'alamat') {
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "none");
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "");
			$("#cari_tgl").css("display", "none");
		} else {
			$("#cari_no_cm").css("display", "none");
			$("#cari_no_cm_lama").css("display", "none"); // To hide
			$("#cari_no_kartu").css("display", "none");
			$("#cari_no_identitas").css("display", "none");
			$("#cari_nama").css("display", "none");
			$("#cari_no_nrp").css("display", "none");
			$("#cari_alamat").css("display", "none");
			$("#cari_tgl").css("display", "");
		}
	}

	function cetak_tracer(no_register) {
		var windowUrl = '<?php echo base_url(); ?>irj/tracer/cetak/' + no_register;
		window.open(windowUrl, 'p');
	}

	function tindakan(id_poli, no_register) {
		var windowUrl = '<?php echo base_url(); ?>irj/rjcpelayanan/form/tindakan/' + id_poli + '/' + no_register;
		window.open(windowUrl, 'p');
	}

	function cetak_identitas(no_medrec) {
		var windowUrl = '<?php echo base_url(); ?>irj/rjcregistrasi/cetak_identitas/' + no_medrec;
		window.open(windowUrl, 'p');
	}

	function cetak_registrasi(no_register,no_medrec) {
		var windowUrl = '<?php echo base_url(); ?>irj/rjcregistrasi/cetak_registrasi/' + no_register + '/' + no_medrec;
		window.open(windowUrl, 'p');
	}

	function cetak_label(no_register) {
		var windowUrl = '<?php echo base_url(); ?>irj/rjcregistrasi/cetak_label/' + no_register;
		window.open(windowUrl, 'p');
	}

	$(function() {
		$('#nama').keyup(function() {
			this.value = this.value.toLocaleUpperCase();
		});
	});
</script>

<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('success_msg'); ?>
	</div>
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-block">
				<?php
				$attributes = array('class' => '');
				echo form_open('irj/rjcregistrasi/pasien', $attributes); ?>
				<div class="row p-t-10 m-b-15">
					<div class="col-md-2">
						<div class="form-group">
							<!-- <label class="control-label">Kategori</label> -->
							<select name="search_per" id="search_per" class="form-control" onchange="cek_search_per(this.value)">
								<option value="cm">No. RM</option>
								<!-- <option value="cm_lama">No. RM Lama</option> -->
								<option value="nama">Nama</option>
								<!-- <option value="nrp">NIP / NRP</option> -->
								<option value="kartu">No. BPJS</option>
								<option value="identitas">No. Identitas</option>
								<option value="alamat">Alamat</option>
								<option value="tgl">Tanggal Lahir</option>
							</select>
							<!-- <small class="form-control-feedback"> This is inline help </small> -->
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group has-danger">
							<input type="search" style="width:430" class="auto_search_by_nocm form-control" id="cari_no_cm" name="cari_no_cm" placeholder="Pencarian No RM">
							<input type="hidden" style="width:430" class="form-control" id="no_medrec_baru" name="no_medrec_baru">
							<!--auto_search_cm_lama-->
							<input type="search" style="width:430; display:none" class=" form-control" id="cari_no_cm_lama" name="cari_no_cm_lama" placeholder="Pencarian No RM Lama">
							<!--auto_search_by_nama-->
							<input type="search" style="width:430; display:none" class=" form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama" onkeyup="this.value = this.value.toUpperCase()">
							<!--auto_search_by_nonrp-->
							<input type="search" style="width:430; display:none" class="auto_search_by_nonrp form-control" id="cari_no_nrp" name="cari_no_nrp" placeholder="Pencarian No NRP">
							<!--auto_search_by_nokartu-->
							<input type="search" style="width:430; display:none" class="auto_search_by_nokartu form-control" id="cari_no_kartu" name="cari_no_kartu" placeholder="Pencarian Kartu BPJS">
							<!--auto_search_by_noidentitas-->
							<input type="search" style="width:430; display:none" class="auto_search_by_noidentitas form-control" id="cari_no_identitas" name="cari_no_identitas" placeholder="Pencarian No Identitas">
							<!--auto_search_by_alamat-->
							<input type="search" style="width:430; display:none" class=" form-control" id="cari_alamat" name="cari_alamat" placeholder="Pencarian Alamat" onkeyup="this.value = this.value.toUpperCase()">

							<input type="date" style="width:430; display:none" class="form-control" id="cari_tgl" name="cari_tgl" placeholder="Pencarian Tgl Lahir">
							<!-- <small class="form-control-feedback"> This field has error. </small> </div> -->
						</div>
					</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<?php $url = site_url('irj/rjcregistrasi/regpasien'); ?>
					<div class="col-md-4">
						<div class="form-actions">
							<button type="submit" class="btn waves-effect waves-light btn-info" type="button">
								<i class="fa fa-search"></i> Cari Pasien
							</button>
							<button type="button" onclick="javascript:window.location.href='<?php echo $url ?>'; return false;" class="btn waves-effect waves-light btn-danger"><i class="fa fa-user-plus"></i> Tambah Pasien Baru</button>
						</div>
					</div>
					<!-- <div class="col-md-2">
						<div class="form-actions">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Registrasi Pasien Luar</button>
						</div>
					</div> -->
				</div>
				<?php echo form_close(); ?>
				<div class="table-responsive m-t-0">
					<table id="tbl-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
						<thead>
							<tr>
								<th width="40px">Aksi</th>
								<th>No. RM</th>
								<th>Nama</th>
								<th>No. Identitas</th>
								<th>No. BPJS</th>
								<th>Alamat</th>
								<th>Tgl Lahir</th>

							</tr>
						</thead>
						<tbody>
							<?php
							if ($data_pasien != "") {
								foreach ($data_pasien as $row) {
							?>
									<tr>

										<td>
											<a href="<?php echo site_url('irj/rjcregistrasi/daftarulangnew/' . $row->no_medrec); ?>" class="btn btn-primary btn-xs" style='width:85px;margin-bottom: 3px;'>Daftar Ulang</a><br>
											<!-- <a href="<?php //echo site_url('medrec/el_record/pasien/' . $row->no_medrec); ?>" class="btn btn-danger btn-xs" style='width:85px;margin-bottom: 3px;'>Rekam Medik</a><br> -->
											<!-- <a href="<?php //echo site_url('irj/rjcpelayanan/cetak_resume/') . $row->no_medrec; ?>" class="btn btn-danger btn-xs" target='_blank' style='width:85px;width:85px;margin-bottom: 3px;'>Cetak PRMRJ</a><br> -->
											<a href="<?php echo site_url('irj/rjcregistrasi/st_cetak_kartu_pasien/') . '/' . $row->no_cm; ?>" target="_blank" class="btn btn-danger btn-xs" style='width:85px;margin-bottom: 3px;'>Cetak Kartu Pasien</a><br>
											<!-- <a href="<?php //echo base_url('irj/rjcregistrasi/cetak_label_cm/') . $row->no_cm; ?>" target="_blank" class="btn btn-info btn-xs" style='width:85px;'>Cetak Label</a> -->
										</td>
										<td><?php echo $row->no_cm; ?></td>
										<td><?php echo strtoupper($row->nama); ?></td>
										<td><?php echo $row->jenis_identitas . " - " . $row->no_identitas; ?></td>
										<td><?php echo $row->no_kartu; ?></td>
										<td><?php echo $row->alamat; ?></td>
										<td><?php echo date('d-m-Y', strtotime($row->tgl_lahir)); ?></td>


									</tr>
							<?php }
							}
							?>
						</tbody>
					</table>
				</div>
				<br>
				<br>
				<!-- rawosi add -->

				<div>
					<h3>History Kunjungan Pasien</h3>
				</div>
				<div class="table-responsive m-t-0">
					<table id="tbl-detail" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
						<thead>
							<tr>
								<th>No. Register</th>
								<th>Tgl_kunjungan</th>
								<th>Pasien</th>
								<th>Poliklinik</th>
								<th>Dokter</th>
							</tr>
						</thead>
						<tbody>
							<?php
							//if($this->input->post->search_per 'RM'){
							if ($data_registrasi != "") {
								foreach ($data_registrasi as $row) {
							?>
									<tr>
										<td><?php echo $row->no_register; ?></td>
										<td><?php echo $row->tgl_kunjungan; ?></td>
										<td><?php echo $row->cara_bayar; ?></td>
										<td><?php echo strtoupper($row->poliklinik); ?></td>
										<td><?php echo $row->dokter; ?></td>

									</tr>
							<?php }
							}
							//}

							?>
						</tbody>
					</table>
				</div>

				<!-- end off rawosi add -->



			</div>
		</div>
	</div>
</div>
<form method="POST" id="pl_form" class="form-horizontal">
	<div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-success modal-lg">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Registrasi Pasien Luar</h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Pilih Penunjang</p>
						<div class="col-sm-7">
							<select name="penunjang" id="penunjang" class="form-control" required>
								<option value="LAB">Laboratorium</option>
								<option value="RAD">Radiologi</option>
								<option value="EM">Elektromedik</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_nama">Nama</p>
						<div class="col-sm-7">
							<input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
							<input type="text" class="form-control" name="nama" id="nama" required>
						</div>
					</div>
					<!-- <div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="lbl_alamat">Usia</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="usia" id="usia">
										</div>
									</div> -->
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">NIK</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="nik" id="nik" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Jenis Kelamin</p>
						<div class="col-sm-7">
							<select name="jk" id="jk" class="form-control" required>
								<option value="L">Laki-laki</option>
								<option value="P">Perempuan</option>
							</select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
						<div class="col-sm-7">
							<div class="form-inline">
								<!-- <select id="cara_bayar" class="custom-select form-control" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>
													<option value="">-- Pilih Cara Bayar --</option>
													<?php
													//foreach($cara_bayar as $row){
													//echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
													//}
													?> 
												</select>		 -->


								<input type="radio" id="umum" name="cara_bayar" value="UMUM" class="detail" required>
								<label for="umum">Umum</label>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" id="bpjs" name="cara_bayar" value="BPJS" class="detail">
								<label for="bpjs">BPJS</label>&nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" id="kerjasama" name="cara_bayar" value="KERJASAMA" class="detail">
								<label for="kerjasama">Kerja Sama</label>

							</div>
						</div>
					</div>
					<div class="form-group row" id="input_kontraktor">
						<div class="col-sm-1"></div>
						<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
						<div class="col-sm-7">
							<div class="form-inline">
								<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="iks">
									<option value="">-- Pilih Penjamin --</option>
									<?php
									foreach ($kontraktor as $row) {
										echo '<option value="' . $row->nmkontraktor . '">' . $row->nmkontraktor . '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group row" id="input_kontraktor_bpjs">
						<div class="col-sm-1"></div>
						<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">RS Perujuk</label>
						<div class="col-sm-7">
							<div class="form-inline">
								<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="iks_bpjs">
									<option value="">-- Pilih Penjamin --</option>
									<?php
									foreach ($kontraktor_bpjs as $row) {
										echo '<option value="' . $row->nmkontraktor . '">' . $row->nmkontraktor . '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<!-- <div class="form-group row" id="input_perujuk">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">RS Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="perujuk" id="perujuk">	
										</div>
									</div> -->
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 control-label col-form-label">Tanggal Lahir</p>
						<div class="col-sm-7">
							<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_alamat">Alamat</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="alamat" id="alamat">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="lbl_dokter">Dokter Perujuk</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="dokter" id="dokter" placeholder="Isi Jika Ada">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="">Diagnosa</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="diagnosa" id="diagnosa">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="">No HP</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="no_hp" id="no_hp" required>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-1"></div>
						<p class="col-sm-3 form-control-label" id="">Email</p>
						<div class="col-sm-7">
							<input type="text" class="form-control" name="email" id="email">
						</div>
					</div>
					<!-- <div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">RS Perujuk</p>
										<div class="col-sm-7">
											<input type="text" class="form-control" name="perujuk" id="perujuk">	
										</div>
									</div>
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<p class="col-sm-3 form-control-label" id="">IKS</p>
										<div class="col-sm-7">
											<select name="iks" id="iks" class="form-control">
												<option value="">--Pilih Kontraktor--</option>
												<?php
												foreach ($kontraktor as $row) {
													echo '<option value="' . $row->nmkontraktor . '">' . $row->nmkontraktor . '</option>';
												}
												?>
											</select>
										</div>
									</div> -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button class="btn btn-primary" type="submit" id="btn-edit">Simpan</button>
				</div>
			</div>

		</div>
	</div>
</form>
<script>
	$('#pl_form').on('submit', function(e) {
		var penunjang = document.getElementById("penunjang").value;
		if (penunjang === 'RAD') {
			url = "<?php echo base_url(); ?>rad/radcdaftar/daftar_pasien_luar";
		} else if (penunjang === 'LAB') {
			url = "<?php echo base_url(); ?>lab/labcdaftar/daftar_pasien_luar";
		} else if (penunjang === 'EM') {
			url = "<?php echo base_url(); ?>elektromedik/emcdaftar/daftar_pasien_luar"
		}
		e.preventDefault();
		document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
		$.ajax({
			url: url,
			method: "POST",
			data: new FormData(this),
			contentType: false,
			cache: false,
			processData: false,
			success: function(data) {
				document.getElementById("btn-edit").innerHTML = 'Edit';
				$('#myModal').modal('hide');
				document.getElementById("pl_form").reset();
				swal({
						title: "Selesai",
						text: "Data berhasil disimpan",
						type: "success",
						showCancelButton: false,
						closeOnConfirm: false,
						showLoaderOnConfirm: true
					},
					function() {
						window.location.reload();
					});
			},
			error: function(event, textStatus, errorThrown) {
				document.getElementById("btn-edit").innerHTML = 'Edit';
				$('#myModal').modal('hide');
				swal("Error", "Data gagal diperbaharui.", "error");
				console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
			}
		});
	});

	$(document).ready(function() {
		$("#input_kontraktor").css("display", "none"); //Menghilangkan form-input ketika pertama kali dijalankan
		$("#input_perujuk").css("display", "none"); //Menghilangkan form-input ketika pertama kali dijalankan
		$("#input_kontraktor_bpjs").css("display", "none");
		$(".detail").click(function() { //Memberikan even ketika class detail di klik (class detail ialah class radio button)
			if ($("input[name='cara_bayar']:checked").val() == "BPJS") { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
				$("#input_kontraktor_bpjs").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
				$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
				$('#input_kontraktor').hide();
			} else if ($("input[name='cara_bayar']:checked").val() == "KERJASAMA") {
				$("#input_kontraktor").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
				$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
				$('#input_kontraktor_bpjs').hide();
			} else {
				$('#input_kontraktor_bpjs').hide();
				$('#input_kontraktor').hide();
			}
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