<?php
$this->load->view('layout/header_left.php');
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

	.flex {
		display: flex;
	}

	.justify-arround {
		justify-content: space-around;
	}
</style>
<script type='text/javascript'>
	var site = "<?php echo site_url(); ?>";

	function tableAjaxReload(table) {
		// location.reload();

	};

	//-----------------------------------------------Data Table
	$(document).ready(function() {
		// var tabel, tableDetail;
		$('#table-artikel-date').hide();
		$('#table-artikel-noreg').hide();



		// datatable serverside
		tabel = $('#table-artikel').DataTable({
			"processing": true,
			"responsive": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[1, 'desc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				"url": "<?= base_url('farmasi/frmcdaftardatatable/view_data_persiapan'); ?>", // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 10, 50],
				[10, 10, 50]
			], // Combobox Limit
			"columns": [{
					targets: -1,
					data: null,
					render: function(a, b, data, d) {
						//console.log(data);
						// //console.log(data.jml_resep!== null || data.jml_resep !== '0');

						// if(data.wkt_dispensing_obat == null && data.wkt_penyerahan_obat == null ){
						// 	let button = `
						// 	<button class="btn btn-danger btn-sm proses">Proses</button><br>
						// 	<button class="btn btn-danger btn-sm selesai">Selesai</button><br>

						// 	`;
						// 	return button;
						// }else if(data.wkt_dispensing_obat != null && data.wkt_penyerahan_obat == null){
						// 	let button = `
						// 	<button class="btn btn-primary btn-sm proses">Proses</button><br>
						// 	<button class="btn btn-danger btn-sm selesai">Selesai</button><br>

						// 	`;
						// 	return button;
						// }else{
						// 	let button = `
						// 	<button class="btn btn-primary btn-sm proses">Proses</button><br>
						// 	<button class="btn btn-primary btn-sm selesai">Selesai</button><br>

						// 	`;
						// 	return button;
						// }
						// console.log(data.no_register);
						// return `<input type="checkbox" name="items[]"  onchange="masukanlist('${data.no_register}',this)" value="ON"  class="form-control" id="items${data.no_register}"><label for="items${data.no_register}"></label>`
						return `
						<button class="btn btn-primary btn-sm panggil">Panggil</button><br>
						<button class="btn btn-primary btn-sm selesai">Selesai</button>`;


					}
				},
				{
					"data": "tgl_kunjungan"
				}, // Tampilkan judul
				{
					"data": "no_cm"
				}, // Tampilkan kategori
				{
					"data": "nama"
				}, // Tampilkan penulis
				{
					"data": "sex"
				}, // Tampilkan tgl posting
				{
					"data": "alamat"
				},
				{
					'data': 'no_hp'
				},
				{
					'data': 'bed'
				},
				{
					'data': 'cara_bayar'
				}
			],
		});

		
		
		$('#table-artikel tbody').on('click', 'button.panggil', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/panggilantrianfarmasi/'); ?>/${data.no_register}`,
				success: function(response) {
					new swal("Berhasil!", "Berhasil Memanggil!", "success").then(function() {
						// location.reload();
						// tabel.ajax.reload();
					});
				}
			});
		});

		$('#table-artikel tbody').on('click', 'button.selesai', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/force_selesai/'); ?>/${data.no_register}`,
				success: function(response) {
					if (response.code == 200) {
						window.open('<?= base_url() ?>' + '/' + response.cetak)
					}
					new swal("Berhasil!", "Penyerahan Obat Berhasil!", "success").then(function() {
						// location.reload();
						tabel.ajax.reload();
					});
				}
			});
		});

		$('#table-artikel tbody').on('click', 'button.proses', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/force_proses/'); ?>/${data.no_register}`,
				success: function(response) {
					new swal("Berhasil!", "Pasien Berhasil Di proses!", "success").then(function() {
						// location.reload();
						tabel.ajax.reload();
					});

				}
			});
		});


		$("#find_by_noreg5").click(function() {
			var key = $("#key").val();

			$.ajax({
				dataType: "json",
				type: 'POST',
				data: {
					key: key
				},
				url: "<?php echo site_url('farmasi/frmcdaftar/get_data_pasien_noreg'); ?>",
				success: function(response) {
					tabel.clear().draw();
					tabel.rows.add(response.data);
					tabel.columns.adjust().draw();
				}
			});
		});

		// $("#find_by_date").click(function() {
		// 	var tgl = $("#date_picker").val();

		// 	$.ajax({
		// 		dataType: "json",
		// 		type: 'POST',
		// 		data: {
		// 			tgl: tgl
		// 		},
		// 		url: "<?php //echo site_url('farmasi/frmcdaftar/get_data_pasien'); 
									?>",
		// 		success: function(response) {
		// 			objTable.clear().draw();
		// 			objTable.rows.add(response.data);
		// 			objTable.columns.adjust().draw();
		// 		}
		// 	});
		// });


	});

	function get_bydate() {
		var date = $("#date_picker").val();
		$('#table-artikel').hide();
		// $('#table-artikel').hide();
		// tabel.hide();
		$('#table-artikel-date').show();
		// tabel.clear().draw();
		// //console.log(date);
		if ($.fn.DataTable.isDataTable('#table-artikel-date')) {
			// If the DataTable is already initialized, destroy it first
			$('#table-artikel-date').DataTable().destroy();
		}
		searchtabel = $('#table-artikel-date').DataTable({
			"processing": true,
			"responsive": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[1, 'desc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				// "dataType": "json",
				"url": "<?= base_url('farmasi/frmcdaftardatatable/view_data_persiapan_bydate/'); ?>" + date, // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 10, 50],
				[10, 10, 50]
			], // Combobox Limit
			"columns": [{
					targets: -1,
					data: null,
					render: function(a, b, data, d) {
						//console.log(data);
						// //console.log(data.jml_resep!== null || data.jml_resep !== '0');

						// if(data.wkt_dispensing_obat == null && data.wkt_penyerahan_obat == null ){
						// let button = `
						// <button class="btn btn-danger btn-sm proses">Proses</button><br>
						// <button class="btn btn-danger btn-sm selesai">Selesai</button><br>

						// `;
						// return button;
						// }else if(data.wkt_dispensing_obat != null && data.wkt_penyerahan_obat == null){
						// 	let button = `
						// 	<button class="btn btn-primary btn-sm proses">Proses</button><br>
						// 	<button class="btn btn-danger btn-sm selesai">Selesai</button><br>

						// 	`;
						// 	return button;
						// }else{
						// 	let button = `
						// 	<button class="btn btn-primary btn-sm proses">Proses</button><br>
						// 	<button class="btn btn-primary btn-sm selesai">Selesai</button><br>

						// 	`;
						// 	return button;
						// }
						// console.log(data.no_register);

						return `<input type="checkbox" name="items[]" onchange="masukanlist('${data.no_register}',this)" value="ON" class="form-control" id="items${data.no_register}"><label for="items${data.no_register}"></label>`

					}
				},
				{
					"data": "tgl_kunjungan"
				}, // Tampilkan judul
				{
					"data": "no_cm"
				}, // Tampilkan kategori
				{
					"data": "nama"
				}, // Tampilkan penulis
				{
					"data": "sex"
				}, // Tampilkan tgl posting
				{
					"data": "alamat"
				},
				{
					'data': 'no_hp'
				},
				{
					'data': 'bed'
				},
				{
					'data': 'cara_bayar'
				}
			],
		});

		$('#table-artikel-date tbody').on('click', 'button.selesai', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/force_selesai/'); ?>/${data.no_register}`,
				success: function(response) {
					new swal("Berhasil!", "Penyerahan Obat Berhasil!", "success").then(function() {
						// location.reload();
						tabel.ajax.reload();
					});
				}
			});
		});

		$('#table-artikel-date tbody').on('click', 'button.proses', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/force_proses/'); ?>/${data.no_register}`,
				success: function(response) {
					new swal("Berhasil!", "Pasien Berhasil Di proses!", "success").then(function() {
						// location.reload();
						tabel.ajax.reload();
					});
				}
			});
		});
	}

	function get_bynoreg() {
		var noreg = $('#key').val();
		$('#table-artikel').hide();
		// tabel.hide();
		$('#table-artikel-noreg').show();
		// tabel.clear().draw();
		// console.log(noreg);
		searchtabel = $('#table-artikel-noreg').DataTable({
			"processing": true,
			"responsive": true,
			"serverSide": true,
			"ordering": true, // Set true agar bisa di sorting
			"order": [
				[1, 'desc']
			], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
			"ajax": {
				// "dataType": "json",
				"url": "<?= base_url('farmasi/frmcdaftardatatable/view_data_persiapan_bynoreg/'); ?>" + noreg, // URL file untuk proses select datanya
				"type": "POST"
			},
			"deferRender": true,
			"aLengthMenu": [
				[10, 10, 50],
				[10, 10, 50]
			], // Combobox Limit
			"columns": [{
					targets: -1,
					data: null,
					render: function(a, b, data, d) {
						// console.log(data);
						// // console.log(data.jml_resep!== null || data.jml_resep !== '0');

						if (data.wkt_dispensing_obat == null && data.wkt_penyerahan_obat == null) {
							let button = `
							<button class="btn btn-danger btn-sm proses">Proses</button><br>
							<button class="btn btn-danger btn-sm selesai">Selesai</button><br>
							
							`;
							return button;
						} else if (data.wkt_dispensing_obat != null && data.wkt_penyerahan_obat == null) {
							let button = `
								<button class="btn btn-primary btn-sm proses">Proses</button><br>
								<button class="btn btn-danger btn-sm selesai">Selesai</button><br>
								
								`;
							return button;
						} else {
							let button = `
								<button class="btn btn-primary btn-sm proses">Proses</button><br>
								<button class="btn btn-primary btn-sm selesai">Selesai</button><br>
								
								`;
							return button;
						}
					}
				},
				{
					"data": "tgl_kunjungan"
				}, // Tampilkan judul
				{
					"data": "no_cm"
				}, // Tampilkan kategori
				{
					"data": "nama"
				}, // Tampilkan penulis
				{
					"data": "sex"
				}, // Tampilkan tgl posting
				{
					"data": "alamat"
				},
				{
					'data': 'no_hp'
				},
				{
					'data': 'bed'
				},
				{
					'data': 'cara_bayar'
				}
			],
		});

		$('#table-artikel-noreg tbody').on('click', 'button.selesai', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/force_selesai/'); ?>/${data.no_register}`,
				success: function(response) {
					new swal("Berhasil!", "Penyerahan Obat Berhasil!", "success").then(function() {
						// location.reload();
						tabel.ajax.reload();
					});
				}
			});
		});

		$('#table-artikel-noreg tbody').on('click', 'button.proses', function() {
			var data = tabel.row($(this).parents('tr')).data();
			$.ajax({
				dataType: "json",
				type: 'POST',
				url: `<?php echo site_url('farmasi/Frmcdaftar/force_proses/'); ?>/${data.no_register}`,
				success: function(response) {
					new swal("Berhasil!", "Pasien Berhasil Di proses!", "success").then(function() {
						// location.reload();
						tabel.ajax.reload();
					});
				}
			});
		});
	}
	//---------------------------------------------------------
</script>
<section class="content-header">
	<?php
	echo $this->session->flashdata('success_msg');
	?>
</section>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 align="center">DAFTAR PERSIAPAN OBAT RAWAT JALAN</h3>
			</div>
			<div class="card-block">
				<div class="row p-t-0">
					<div class="col-md-4">
						<div class="form-group row">
							<div class="">
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="button" id="find_by_date" onclick="get_bydate()">Cari</button>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control" name="key" id="key" placeholder="No. RM" required>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" id="find_by_noreg" onclick="get_bynoreg()">Cari</button>
								</span>
							</div><!-- /input-group -->
						</div><!-- /col-lg-6 -->
					</div>
				</div>
			</div>

			<?php echo form_close(); ?>
			<div class="card-block">
				<div class="table-responsive m-t-0">

					<!-- example datatable server side -->
					<div class="row">
						<!-- <button class="btn btn-primary" type="button" onclick="proses()">Proses</button> -->
						&nbsp;&nbsp;&nbsp;<button class="btn btn-danger" type="button" onclick="selesai()">Selesai</button>
					</div>
					<table class="table table-striped table-bordered" id="table-artikel">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>Tanggal Kunjungan</th>
								<th>No RM</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>Alamat</th>
								<th>No HP</th>
								<th>Ruang</th>
								<th>Jaminan</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

					<table class="table table-striped table-bordered" id="table-artikel-date">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>Tanggal Kunjungan</th>
								<th>No RM</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>Alamat</th>
								<th>No HP</th>
								<th>Ruang</th>
								<th>Jaminan</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
					<table class="table table-striped table-bordered" id="table-artikel-noreg">
						<thead>
							<tr>
								<th>Aksi</th>
								<th>Tanggal Kunjungan</th>
								<th>No RM</th>
								<th>Nama</th>
								<th>Jenis Kelamin</th>
								<th>Alamat</th>
								<th>No HP</th>
								<th>Ruang</th>
								<th>Jaminan</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>



				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var noregs = [];

	function proses() {
		// console.log(noregs);
		$.ajax({
			dataType: "json",
			type: 'POST',
			url: `<?php echo site_url('farmasi/Frmcdaftar/bulk_force_proses/'); ?>`,
			data: {
				'noreg': noregs
			},
			success: function(response) {
				new swal("Berhasil!", "Pasien Berhasil Di proses!", "success").then(function() {
					// location.reload();
					// tabel.ajax.reload();
					// noregs = [];
				});
				// console.log(response);


			}
		});
	}

	function selesai() {
		// console.log(noregs);
		$.ajax({
			dataType: "json",
			type: 'POST',
			url: `<?php echo site_url('farmasi/Frmcdaftar/bulk_force_selesai/'); ?>`,
			data: {
				'noreg': noregs
			},
			success: function(response) {
				new swal("Berhasil!", "Pasien Berhasil Selesai!", "success").then(function() {
					// location.reload();
					tabel.ajax.reload();

					searchtabel.ajax.reload();
					// noregs = [];
				});
				// console.log(response);

			}
		});
	}

	function masukanlist(noreg, val) {
		// console.log(val.checked);
		// tandanya dia checklist
		if (val.checked) {
			const itemToAdd = noreg;
			const index = noregs.indexOf(itemToAdd);
			if (index !== -1) {} else {
				noregs.push(noreg);
			}
		} else {
			const itemToRemove = noreg;
			const index = noregs.indexOf(itemToRemove);
			if (index !== -1) {
				noregs.splice(index, 1);
			}
		}
	}
</script>





<?php
$this->load->view('layout/footer_left.php');
?>