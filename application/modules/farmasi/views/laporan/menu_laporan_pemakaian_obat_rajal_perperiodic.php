<?php
$this->load->view('layout/header_left.php');
?>
<script type="text/javascript" src="<?= base_url('assets/moment.js') ?>"></script>
<script type="text/javascript" src="<?= base_url() ?>/assets/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>/assets/daterangepicker.css" />
<script>
	$(document).ready(function() {
		$('#tablePendapatan').DataTable();
		$('#tgl_pertama').daterangepicker();
	});

	function excel() {
		let dates = $('#tgl_pertama').val();
		let subkel = $('#subkel').val();
		if (dates == '') {
			return swal({
				title: "Perhatian!",
				text: "Tgl. Awal dan Tgl. Akhir Harus Sesuai ",
				type: "info",
			});
		}
		let tgl_pertama = convertDateToYmd(dates.split('-')[0]);
		let tgl_kedua = convertDateToYmd(dates.split('-')[1]);

		window.location.href = `<?php echo site_url('farmasi/Frmclaporan/laporan_pemakaian_obat_rajal_perperiodic'); ?>?tgl_pertama=${tgl_pertama}&tgl_kedua=${tgl_kedua}&subkel=${subkel}`
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}


	function convertDateToYmd(dt) {
		dts = dt.split('/')
		return `${dts[2].trim()}-${dts[0].trim()}-${dts[1].trim()}`;
	}


	function rekap() {
		let dates = $('#tgl_pertama').val();
		let subkel = $('#subkel').val();
		if (dates == '') {
			return swal({
				title: "Perhatian!",
				text: "Tgl. Awal dan Tgl. Akhir Harus Sesuai ",
				type: "info",
			});
		}
		let tgl_pertama = convertDateToYmd(dates.split('-')[0]);
		let tgl_kedua = convertDateToYmd(dates.split('-')[1]);

		$.ajax({
			url: `<?php echo site_url('farmasi/Frmclaporan/laporan_pemakaian_obat_rajal_perperiodic'); ?>?tgl_pertama=${tgl_pertama}&tgl_kedua=${tgl_kedua}&subkel=${subkel}&json=true`,
			beforeSend: function(_) {
				$('#rekap-pendapatan').attr('disabled', true);
				$('#rekap-pendapatan').html('Loading...');
			},
			success: function(response) {
				console.log(response)
				let html = ``;
				response.data.map((f) => {
					// if (e.kode == f.subkelompok) {
						html += `
						<tr>
							<td>${f.nm_obat}</td>
							<td>${f.total_pemakaian}</td>
						</tr>
						`;
					// }
				})
				// response.kelompok.map((e) => {
				// 	html += `
				// 	<tr>
				// 		<td colspan="3" class="bg-success">${e.bentuk_sediaan===null?'Lainnya':e.bentuk_sediaan}</td>
				// 	</tr>
				// 	`;
				// })
				// response.map((e) => {

				// 	html += `
				// 	<tr>
				// 		<td>${e.nm_obat}</td>
				// 		<td>${e.betuk_sediaan}</td>
				// 		<td>${e.total_pemakaian}</td>
				// 	</tr>
				// 	`;
				// });
				$('#tablePendapatan').DataTable().clear().destroy();
				$("#rekapPendapatan").html(html);
				$('#tablePendapatan').DataTable();

			},
			complete: function(_) {
				$('#rekap-pendapatan').attr('disabled', false);
				$('#rekap-pendapatan').html('Cari Data');
			}
		});

	}
</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<p>Pilih Tanggal :</p>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<input class="form-control" type="text" id="tgl_pertama" placeholder="YYYY-MM">
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<select id="subkel" class="form-control" name="subkel">
						<option value="semua" selected>-Bentuk Sediaan-</option>
						<?php 
							foreach($subkel as $row){
							echo '<option value="'.$row->kode.'">'.$row->bentuk_sediaan.'</option>';
							}
						?>
					</select>
				</div>
			</div>

			<div class="col-md-4">
				<div class="form-group">
					<button class="btn btn-info" id="rekap-pendapatan" onclick="rekap()">Cari Data</button>
					<button class="btn btn-primary" onclick="excel()">Download Excel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card p-4">
	<div class="card-header">
		<div style="text-align:center;font-size:16px">
			<h4>Laporan Pemakaian Obat Per Dokter</h4>
		</div>
	</div>
	<div class="card-body">
		<table width="100%" class="table" id="tablePendapatan">
			<thead>
				<tr>
					<th>Nama Obat</th>
					<th>Total</th>
				</tr>
			</thead>
			<tbody id="rekapPendapatan">
			</tbody>
		</table>
	</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>