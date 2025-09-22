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
		let idrg = $("#idrg").val();
		if (dates == '') {
			return swal({
				title: "Perhatian!",
				text: "Tgl. Awal dan Tgl. Akhir Harus Sesuai ",
				type: "info",
			});
		}
		let tgl_pertama = convertDateToYmd(dates.split('-')[0]);
		let tgl_kedua = convertDateToYmd(dates.split('-')[1]);

		window.location.href = `<?php echo site_url('farmasi/Frmclaporan/laporan_pemakaian_obat_per_dokter_ranap'); ?>?tgl_pertama=${tgl_pertama}&tgl_kedua=${tgl_kedua}&idrg=${idrg}`
	}

	function numberWithCommas(x) {
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}


	function convertDateToYmd(dt)
	{
		dts = dt.split('/')
		return `${dts[2].trim()}-${dts[0].trim()}-${dts[1].trim()}`;
	}


	function rekap() {
		let dates = $('#tgl_pertama').val();
		let idrg = $("#idrg").val();
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
			url: `<?php echo site_url('farmasi/Frmclaporan/laporan_pemakaian_obat_per_dokter_ranap'); ?>?tgl_pertama=${tgl_pertama}&tgl_kedua=${tgl_kedua}&json=true&idrg=${idrg}`,
			beforeSend: function(_) {
				$('#rekap-pendapatan').attr('disabled', true);
				$('#rekap-pendapatan').html('Loading...');
			},
			success: function(response) {
				let html = ``;
				response.map((e) => {

					html += `
					<tr>
						<td>${e.no_register}</td>
						<td>${e.no_medrec}</td>
						<td>${e.nama}</td>
						<td>${e.namapoli}</td>
						<td>${e.namadokter}</td>

						<td>${e.waktu_resep_dokter=='undifined'?'':''}</td>
						<td>${e.waktu_resep_dokter=='undifined'?'':''}</td>
						<td>${e.waktu_telaah_obat=='undifined'?'':''}</td>
						<td>${e.waktu_selesai_farmasi=='undifined'?'':''}</td>


						<td>${e.nfornas}</td>
						<td>${e.fornas}</td>
						<td>${e.jlhr}</td>
						<td>Rp. ${e.biaya_obat?numberWithCommas(e.biaya_obat):0}</td>
						<td>${e.diskon}</td>
						<td>Rp. ${e.jp?numberWithCommas(e.jp):0}</td>
						<td>Rp. ${e.totalbiaya?numberWithCommas(e.totalbiaya):0}</td>
					</tr>
					`;
				});
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
					<select class="form-control" id="idrg">
						<option value="semua" selected="">---- Pilih Gudang ----</option>
						<?php foreach ($gudang as $val): ?>
						<option value="<?= $val->id_gudang ?>"><?= $val->nama_gudang ?></option>
						<?php endforeach ?>
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
		<table cellspacing="0" width="100%" class="table table-responsive" id="tablePendapatan">
			<thead>
				<tr>
					<th>No. Register</th>
					<th>No. RM</th>
					<th>Nama</th>
					<th>Nama Poli</th>
					<th>Nama Dokter</th>

					<th>Order Resep</th>
					<th>Verifikasi Farmasi</th>
					<th>Telaah Obat</th>
					<th>Selesai Pemeriksaan</th>

					<th>Non Fornas</th>
					<th>Fornas</th>
					<th>Jlh R/</th>
					<th>Biaya Obat</th>
					<th>Diskon</th>
					<th>JP</th>
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