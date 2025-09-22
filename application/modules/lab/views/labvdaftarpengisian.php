<?php
if ($role_id == 1) {
	$this->load->view("layout/header_left");
} else {
	$this->load->view("layout/header_horizontal");
}
?>
<html>
<script type='text/javascript'>
	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$('#example').DataTable();
	});
	//---------------------------------------------------------

	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  	
	});

	// var intervalSetting = function () {
	// 	location.reload();
	// };
	// setInterval(intervalSetting, 120000);

	function get_hasil(no_register) {
		// alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: "<?php echo base_url('lab/labcdaftar/get_banyak_hasil') ?>",
			data: {
				no_register: no_register
			},
			success: function(data) {
				//alert(data);
				$('#biaya_lab').val(data);
				$('#biaya_lab_hide').val(data);
			},
			error: function() {
				alert("error");
			}
		});
	}
</script>

<?php
echo $this->session->flashdata('success_msg');
?>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
				<div class="row p-t-0">
					<div class="col-md-6">
						<?php echo form_open('lab/labcpengisianhasil'); ?>
						<div class="form-group row">
							<div style="width: 80%;margin-left: 15px;">
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
					<div class="col-md-6">
						<?php echo form_open('lab/labcpengisianhasil'); ?>
						<div class="input-group">
							<input type="text" class="form-control" name="key" placeholder="No. Rekam Medik" required>
							<span class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</span>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card">
			<div class="card-block">
				<div class="table-responsive m-t-0">
					<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Aksi</th>
								<!-- <th width="80px">Waktu Selisih</th> -->
								<!-- <th>Waktu</th> -->
								<th width="80px">Status </th>
								<th width="50px">No RM</th>
								<th width="50px">No Lab</th>
								<th width="50px">No Register</th>
								<th width="200px">Nama</th>
								<th width="80px">Banyak </th>
								<th>Total harga</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach ($laboratorium as $row) {
								$no_register = $row->no_register;
							?>
								<tr>
									<td>
										<a href="javascript:;" class="btn btn-primary" onClick="return openUrl('<?php echo site_url('lab/Labcpengisianhasil/daftar_hasil/' . $row->no_lab); ?>');"><i class="ti-pencil"></i> Isi</a>
									</td>
									<!-- <?php if ($row->tgl_selesai_pemeriksaan == NULL) { ?>
										<td id="clock-<?= $row->no_lab; ?>"></td>
									<?php } else { ?>
										<td id="clock_o_clock-<?= $row->no_lab ?>"></td>
									<?php } ?> -->
									<td>
										<?php if ($row->cetak_hasil == 1)
											echo "Selesai";
										else
											echo "Belum Selesai"; ?>
									</td>
									<td><?php echo $row->no_medrec ?></td>
									<td><?php echo $row->no_lab; ?></td>
									<td><?php echo $row->no_register; ?></td>
									<td><?php echo $row->nama; ?></td>
									<td>
										<?php echo $row->banyak; ?>
									</td>
									<td>
										<?php echo 'Rp. ' . $row->vtot; ?>
										<br>
										<?php
										if ($row->cara_bayar == "UMUM") {
											if ($row->cetak_kwitansi == '1') {
												echo 'UMUM - Lunas';
											} else {
												echo 'UMUM - Belum Lunas';
											}
										} else if ($row->cara_bayar == "BPJS")
											echo 'BPJS';
										else if ($row->cara_bayar == "DIJAMIN")
											echo 'DIJAMIN';
										?>
									</td>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function jamSelesai(id, tglMulai, tglSelesai) {
		const startDate = new Date(tglMulai);
		const endDate = new Date(tglSelesai);

		var delta = Math.abs(endDate - startDate) / 1000;
		var minute = Math.floor(delta / 60);
		var hours = Math.floor(minute / 60);
		var days = Math.floor(hours / 24);

		hours = hours - (days * 24);
		minute = minute - (days * 24 * 60) - (hours * 60);
		delta = delta - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minute * 60);

		const timeString = `${days} Hari ${hours} Jam ${minute} Menit`;

		document.getElementById('clock_o_clock-' + id).textContent = timeString;
	}

	function jamDigital(id, tglMulai) {
		const startDate = new Date(tglMulai);
		const now = new Date();

		var delta = Math.abs(now - startDate) / 1000;
		var minute = Math.floor(delta / 60);
		var hours = Math.floor(minute / 60);
		var days = Math.floor(hours / 24);

		hours = hours - (days * 24);
		minute = minute - (days * 24 * 60) - (hours * 60);
		delta = delta - (days * 24 * 60 * 60) - (hours * 60 * 60) - (minute * 60);

		// const timeString = `${days} Hari ${hours} Jam ${minute} Menit`;
		const timeString = `${hours}:${minute}:${Math.round(delta)}`
		console.log(timeString);

		document.getElementById('clock-' + id).textContent = timeString;
	}

	$(document).ready(function() {
		setTimeout(function() {
			setInterval(function() {
				<?php
				foreach ($laboratorium as $row) {
					if ($row->tgl_selesai_pemeriksaan == NULL) { ?>
						jamDigital('<?= $row->no_lab ?>', '<?= $row->tgl_mulai_pemeriksaan ?>');
					<?php } else { ?>
						jamSelesai('<?= $row->no_lab ?>', '<?= $row->tgl_mulai_pemeriksaan ?>', '<?= $row->tgl_selesai_pemeriksaan ?>');
				<?php }
				} ?>
			}, 0);
		}, 0);
	});
</script>
<?php
$this->load->view('layout/footer_left.php');
?>