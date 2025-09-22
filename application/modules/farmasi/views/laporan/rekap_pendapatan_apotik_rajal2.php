<?php
$this->load->view('layout/header_left.php');
?>
<script>
	$(document).ready(function() {
		$('#tablePendapatan').DataTable();
		$('#kontraktor').hide();

	});

	function excel() {
		window.location.href = `<?php echo site_url('farmasi/Frmclaporan/rekap_pendapatan_apotik_rajal'); ?>?bulan=${$('#bulan').val()}&carabayar=${$('#carabayar').val()}&idrg=${$('#idrg').val()}&asuransi=${$('#kontraktor').val()}`
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
		let idrg = $("#idrg").val();
		let asuransi = $("#kontraktor").val();
		if (bulan == '') {
			return swal({
				title: "Perhatian!",
				text: "Bulan Wajib Diisi",
				type: "info",
			});
		}
		// $("#judulRekap").html(`Rekap Pendapatan Apotik Rawat ${(pelayanan=='ranap'?'Inap':'Jalan')}`);


		$.ajax({
			url: `<?php echo site_url('farmasi/Frmclaporan/rekap_pendapatan_apotik_rajal'); ?>?bulan=${bulan}&carabayar=${carabayar}&json=true&idrg=${idrg}&asuransi=${asuransi}`,
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

	function bayar(bayars){
		if(bayars == 'KERJASAMA'){
			$('#kontraktor').show();
		}else{
			$('#kontraktor').hide();
		}
	}
</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<select class="form-control" id="carabayar" onchange="bayar(this.value)">
						<option value="semua" selected>Pilih Pembayaran</option>
						<option value="BPJS">BPJS</option>
						<option value="UMUM">UMUM</option>
						<option value="KERJASAMA">KERJASAMA</option>
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<select class="form-control" id="idrg">
						<option value="semua" selected="">---- Pilih Poli ----</option>
						<?php foreach ($poli as $val): ?>
						<option value="<?= $val->id_poli ?>"><?= $val->nm_poli ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<input class="form-control" type="month" id="bulan" placeholder="YYYY-MM">
				</div>
			</div>
			<div class="col-md-4 asuransi">
				<div class="form-group">
					<select class="form-control" id="kontraktor">
						<option value="semua" selected="">---- Pilih Asuransi ----</option>
						<option value="65">PT Bukit Asam Tbk</option>
						<option value="63">PT Asuransi Jiwa Inhealth Indonesia</option>
						<option value="67">PT PLN (Persero) Unit Induk Wilayah Sumatera Barat</option>
						<option value="66">Yayasan Kesehatan Pegawai Telkom</option>
						<option value="68">PT Jasa Raharja (Persero) Cabang Sumatera Barat</option>
						<option value="101">Admedika</option>
						<option value="116">BPJS Ketenagakerjaan</option>
						
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<button class="btn btn-info" id="rekap-pendapatan" onclick="rekap()" style="align:right">Cari Data</button>
					<button class="btn btn-primary" onclick="excel()">Download Excel</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card p-4">
	<div class="card-header">
		<div style="text-align:center;font-size:16px">
			<h4>Rekap Pendapatan Apotik Rawat Jalan</h4>
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