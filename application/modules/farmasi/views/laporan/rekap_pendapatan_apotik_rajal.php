<?php
$this->load->view('layout/header_left.php');
?>
<script>
	$(document).ready(function() {
		$('#tablePendapatan').DataTable();

	});

	function excel() {
		window.location.href = `<?php echo site_url('farmasi/Frmclaporan/rekap_pendapatan_apotik_rajal'); ?>?bulan=${$('#bulan').val()}&carabayar=${$('#carabayar').val()}&pelayanan=${$('#pelayanan').val()}`
	}

	function numberWithCommas(x) {
		if (x == null) {
			x = 0;
		}
		return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	}

	function rekap() {
		let carabayar = $("#carabayar").val();
		let bulan = $('#bulan').val();
		let pelayanan = $("#pelayanan").val();
		if (carabayar == '' || bulan == '' || pelayanan == '') {
			return swal({
				title: "Perhatian!",
				text: "Cara Bayar,Pelayanan dan Bulan Wajib Diisi",
				type: "info",
			});
		}
		$("#judulRekap").html(`Rekap Pendapatan Apotik Rawat ${(pelayanan=='ranap'?'Inap':'Jalan')}`);


		$.ajax({
			url: `<?php echo site_url('farmasi/Frmclaporan/rekap_pendapatan_apotik_rajal'); ?>?bulan=${bulan}&carabayar=${carabayar}&json=true&pelayanan=${pelayanan}`,
			beforeSend: function(_) {
				$('#rekap-pendapatan').attr('disabled', true);
				$('#rekap-pendapatan').html('Loading...');
			},
			success: function(response) {
				// console.log(response);
				let html = ``;
				response.map((e) => {
					if (e.nilairmin == null) {
						e.nilairmin = 0;
					}
					html += `
					<tr>
						<td>${e.tgl_kunjungan}</td>
						<td>${e.jmlr}</td>
						<td>${e.jmllr}</td>
						<td>Rp. ${numberWithCommas(e.nilair)}</td>
						<td>Rp. ${numberWithCommas(e.nilairmin==0?0:e.nilairmin)}</td>
						<td>Rp. ${numberWithCommas(e.nilaiall)}</td>
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
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control" id="carabayar">
						<option value="" selected>Pilih Pembayaran</option>
						<option value="BPJS">BPJS</option>
						<option value="UMUM">UMUM</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control" id="pelayanan">
						<option value="" selected>Pilih Pelayanan</option>
						<option value="ranap">Rawat Inap</option>
						<option value="rajal">Rawat Jalan</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<input class="form-control" type="month" id="bulan" placeholder="YYYY-MM">
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
			<h4 id="judulRekap">Rekap Pendapatan Apotik Rawat Jalan / Rawat Inap</h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" class="table" id="tablePendapatan">
			<thead>
				<tr>
					<th>Tgl</th>
					<th>Jumlah R/</th>
					<th>Jumlah Lembar R/</th>
					<th>Nilai R/</th>
					<th>Nilai -R</th>
					<th>Nilai +R</th>
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