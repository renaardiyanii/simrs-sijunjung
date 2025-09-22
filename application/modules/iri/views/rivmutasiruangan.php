<?php if ($role_id == 1) {
	$this->load->view("layout/header_left");
} else {
	$this->load->view("layout/header_left");
} ?>

<link href="<?= base_url(); ?>assets/surveyjs/modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url(); ?>assets/surveyjs/survey.jquery.min.js"></script>
<script src="<?php echo base_url('assets/form/sweetalert2@11.js') ?>"></script>

<style>
	.modal-dialog {
		width: 100%;
		height: 100%;
		padding: 0;
		margin: 5px;
	}

	.modal-content {
		width: 275%;
		height: 100%;
		border-radius: 0;
		color: #333;
		overflow: auto;
	}

	.close {
		color: black ! important;
		opacity: 1.0;
	}
</style>
<script type='text/javascript'>
	$(document).ready(function() {
		$('#datatable2').DataTable();

		var vals = $('#ruang').val();

		$('#bed')
			.find('option')
			.remove()
			.end();
		$("#bed").append("<option value=''>Loading...</option>");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
			data: {
				val: vals
			},
		}).done(function(msg) {
			$('#bed')
				.find('option')
				.remove()
				.end();
			$("#bed").append(msg);
		});

	});

	function get_bed(val) {
		$('#bed')
			.find('option')
			.remove()
			.end();
		$("#bed").append("<option value=''>Loading...</option>");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
			data: {
				val: val
			},
		}).done(function(msg) {
			$('#bed')
				.find('option')
				.remove()
				.end();
			$("#bed").append(msg);
		});
	}

	function get_bed_mutasi(val) {
		$('#bed2')
			.find('option')
			.remove()
			.end();
		$("#bed2").append("<option value=''>Loading...</option>");
		$.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select_mutasi/",
			data: {
				val: val
			},
		}).done(function(msg) {
			$('#bed2')
				.find('option')
				.remove()
				.end();
			$("#bed2").append(msg);
		});
	}

	function showswal() {
		Swal.fire({
				title: "",
				text: "MOHON REFRESH HALAMAN",
				tye: "success",
				showConfirmButton: true,
				showCancelButton: false,
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			},
			function() {
				// window.location.reload();
				// window.location.reload();
				location.href = '<?php echo site_url('iri/Ricpasien/'); ?>';
			});
	}

	function submitMutasi() {

		if ($('#ruang').val() == '') {
			alert('pilih ruang');
			return;
		}
		let data = $("#mutasi_form").serialize();
		console.log(data);
		document.getElementById('btn-mutasi').innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
		Swal.fire({
			title: "Yakin Mutasi Pasien?",
			text: "Klik Ya Jika Anda Yakin",
			type: "warning",
			showCancelButton: true,
			confirmButtonText: "Ya",
			cancelButtonText: "Tidak",
			closeOnConfirm: false,
			closeOnCancel: false
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "<?= base_url() ?>/iri/ricmutasi/mutasi_ruangan",
					method: "POST",
					data: data,
					success: function(data) {
						document.getElementById('btn-mutasi').innerHTML = 'Simpan';
						Swal.fire({
							title: "Selesai",
							text: "Data berhasil disimpan",
							type: "success",
							showCancelButton: false,
							closeOnConfirm: true,
							showLoaderOnConfirm: true
						});
						$('section').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
						$('.card').remove();
					
							return openUrl("<?= site_url('iri/Ricpasien') ?>");
					},
					error: function(event, textStatus, errorThrown) {
						//$('#ulangModal').modal('hide');
						document.getElementById('btn-mutasi').innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
						Swal.fire("Error", "Data gagal diperbaharui.", "error");
						console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
					}
				});
			} else {
				document.getElementById('btn-mutasi').innerHTML = 'Simpan';
				Swal.fire("Tidak Jadi dimutasi", "", "error");
			}
		});
		return false;
	}
</script>
<section class="content-header">
	<?php
	echo $this->session->flashdata('success_msg');
	?>
</section>

<div class="card">
	<!-- <form action="<?php //echo base_url().'iri/ricmutasi/mutasi_ruangan'; 
											?>" method="post"> -->
	<form id="mutasi_form" method="post">
		<div class="card-body p-5">
			<h4 class="card-title">Mutasi Ruangan</h4>
			<hr>
			<div class="form-group row">
				<label class="col-sm-3 col-form-label">No Medrec</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->no_medrec; ?>" readonly="">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">No Ipd</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->no_ipd; ?>" readonly="">
					<input type="hidden" name="no_ipd" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->no_ipd; ?>">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Nama</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->nama; ?>" readonly="">
				</div>
			</div>

			<hr>
			<?php 
			if (!empty($data_pasien->tgl_keluar) && strtotime($data_pasien->tgl_keluar) !== false) {
				if (date('Y-m', strtotime($data_pasien->tgl_keluar)) < date('Y-m')) { ?>

					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Tanggal Masuk</label>
						<div class="col-sm-9">
							<input type="date" name="tgl_masuk" class="form-control" style="width: 100%;">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Tanggal Keluar</label>
						<div class="col-sm-9">
							<input type="date" name="tgl_keluar" class="form-control" style="width: 100%;">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Ruangan *</label>
						<div class="col-sm-9">
							<span class="label-form-validation"></span>
								<select class="form-control input-sm select2" id="ruang" name="ruang2" onchange="get_bed_mutasi(this.value)" required>
									<option value="" selected="true">-Pilih Ruang-</option>
									<?php foreach ($kelas as $r) { ?>
										<option value="<?php echo $r['idrg'] . '@' . $r['nmruang'] . '@' . $r['kelas']; ?>"><?php echo $r['idrg'] . ' - ' . $r['nmruang'] . ' - Kelas(' . $r['kelas'] . ') - ' . $r['lokasi']; ?></option>
									<?php } ?>
								</select>

						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 col-form-label">Bed</label>
						<div class="col-sm-9">
							<select class="form-control input-sm select2" id="bed2" name="bed2" required>
							</select>
						</div>
						<input type="hidden" name="bed_hidden" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->bed; ?>">
					</div>

			<?php }
				}else{ ?>

			

			

			





			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Ruangan *</label>
				<div class="col-sm-9">
					<span class="label-form-validation"></span>

					<?php if (empty($kelas)) { ?>
						<select class="form-control select2" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
							<option value="" selected="true">Semua Kelas Penuh</option>
						</select>
						<?php
					} else {
						if (empty($status_bed)) {
						?>
							<select class="form-control input-sm select2" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
								<option value="" selected="true">-- Kelas yang dipesan penuh silahkan pilih kelas lain --</option>
								<?php foreach ($kelas as $r) { ?>
									<option value="<?php echo $r['idrg'] . '@' . $r['nmruang'] . '@' . $r['kelas']; ?>"><?php echo $r['idrg'] . ' - ' . $r['nmruang'] . ' - Kelas(' . $r['kelas'] . ') - ' . $r['lokasi']; ?></option>
								<?php } ?>
							</select>
						<?php } else { ?>
							<select class="form-control input-sm select2" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
								<option value="" selected="true">-- Pilih Ruangan --</option>

								<?php
								foreach ($kelas as $r) {
									//if($data_pasien->klsiri == $r['kelas'] && $data_pasien->idrg == $r['idrg']){ 
								?>
									<!-- <option value="<?php echo $r['idrg'] . '@' . $r['nmruang'] . '@' . $r['kelas']; ?>" selected=""><?php echo $r['idrg'] . ' - ' . $r['nmruang'] . ' - Kelas(' . $r['kelas'] . ') - ' . $r['lokasi']; ?></option> -->
									<?php //} else { 
									?>
									<option value="<?php echo $r['idrg'] . '@' . $r['nmruang'] . '@' . $r['kelas']; ?>"><?php echo $r['idrg'] . ' - ' . $r['nmruang'] . ' - Kelas(' . $r['kelas'] . ') - ' . $r['lokasi']; ?></option>
						<?php
									//}
								}
							}
						}
						?>
							</select>
				</div>
				<input type="hidden" name="idrg_hidden" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->idrg; ?>">
			</div>

			<div class="form-group row">
				<label class="col-sm-3 col-form-label">Bed</label>
				<div class="col-sm-9">
					<select class="form-control input-sm select2" id="bed" name="bed" required>
						<?php
						// foreach ($empty_bed as $r) { 
						?>
						<!-- <option value="<?php //echo $r['bed'] ;
																?>"><?php //echo $r['bed'];
																														?></option> -->
						<?php
						// }
						?>
					</select>
				</div>
				<input type="hidden" name="bed_hidden" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->bed; ?>">
			</div>
			<?php } ?>
			<div class="form-group row">
				<!-- <label class="col-sm-3 col-form-label">Kelas</label>
				<div class="col-sm-9">
						<select class="form-control input-sm select2" name="jatahkls" id="jatahkls" required>
							<?php
							foreach ($all_kelas as $r) {
								if ($r['kelas'] != 'EKSEKUTIF') {
									if ($r['kelas'] != 'NK') {
										if ($data_pasien->klsiri == $r['kelas']) {
							?>				
								<option value="<?php echo $r['kelas']; ?>" selected><?php echo $r['kelas']; ?></option>
							<?php } else { ?>
								<option value="<?php echo $r['kelas']; ?>"><?php echo $r['kelas']; ?></option>
							<?php
										}
									}
								}
							}
							?>
						</select>
				</div>	 -->
				<input type="hidden" name="klsiri_hidden" class="form-control" style="width: 100%;" value="<?php echo $data_pasien->klsiri; ?>">
			</div>

			<?php
			if ($pasien[0]['titip'] == '1') { ?>
				<div class="col-sm-3">
					<div class="demo-checkbox">
						<input type="checkbox" name="titip" id="titip" value="1" <?php echo isset($pasien[0]['titip']) ? $pasien[0]['titip'] == "1" ? "checked" : '' : '' ?>>
						<label for="titip">Titip</label>
					</div>
				</div>
			<?php
			}
			?>

		</div>
		<div class="card-footer">
			<div class="form-group row">
				<a href="<?php echo base_url(); ?>iri/Ricpasien" class="btn btn-warning">kembali</a> &nbsp;
				<button type="button" value="Simpan" onclick="submitMutasi()" class="btn btn-primary" id="btn-mutasi">SImpan</button>
			</div>
		</div>
	</form>
</div>

<div class="card m-8">
	<div class="card-header">
		<h5>Riwayat Mutasi</h5>
	</div>
	<div class="card-body">
		<table class="table table-hover table-striped table-bordered data-table" style="width:100%;" style="table-layout: fixed;" cellpadding="3px">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tgl Masuk</th>
					<th>Ruang</th>
					<th>Bed</th>
					<th>Tgl Keluar</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				foreach ($histori_ruang as $value) {

				?>

					<tr>
						<th><?= $i++; ?></th>
						<th><?= isset($value->tglmasukrg) ? date('d-m-Y', strtotime($value->tglmasukrg)) : '' ?></th>
						<th><?= $value->nmruang . '(' . $value->idrg . ')'  ?></th>
						<th><?= $value->bed ?></th>
						<th><?= isset($value->tglkeluarrg) ? date('d-m-Y', strtotime($value->tglkeluarrg)) :'' ?></th>
						<th>
							<?php if ($value->tglkeluarrg != null) { ?>
								<a href="<?php echo site_url("iri/ricmutasi/hapus_detail/" . $value->idrgiri . '/' . $data_pasien->no_ipd); ?>" class="btn btn-danger btn-xs">hapus</a>
							<?php } ?>
						</th>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>
<script>
	swalConfirmationForMutation();

	function swalConfirmationForMutation() {
		Swal.fire({
			title: 'Konfirmasi...',
			icon: 'warning',
			text: "Harap memastikan tindakan billing & form rekam medis telah terisi/lengkap.",
			showDenyButton: true,
			showCancelButton: false,
			confirmButtonText: 'Sudah Terisi/Lengkap',
			denyButtonText: `Kembali`,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			allowOutsideClick: false
		}).then((result) => {
			if (result.isConfirmed) {
				result.dismiss === Swal.DismissReason.cancel;
			} else if (result.isDenied) {
				$('section').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
				$('.card').remove();
				return openUrl("<?= site_url('iri/Ricpasien') ?>");
			}
		})
	}
</script>