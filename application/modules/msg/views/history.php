<?php
if ($role_id == 1) {
	$this->load->view("layout/header_left");
} else {
	$this->load->view("layout/header_left");
}
?>
<html>
<script type='text/javascript'>
	//-----------------------------------------------Data Table
	$(document).ready(function() {
		$('#example').DataTable();
	});
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
						<div class="form-group row" style="margin-bottom: 0;">
							<div style="width: 80%;margin-left: 15px;">
								<input type="date" id="in_tgl" class="form-control" name="date" value="<?php echo date('Y-m-d') ?>" required>
							</div>
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit" id="btnCari">Cari</button>
							</div>
						</div>
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
							<th>No</th>
							<th>Time</th>
							<th>Jenis Penunjang</th>
							<th>Role</th>
							<th>User</th>
							<th>Response Code</th>
							<th>Response Body</th>
						</thead>
						<tbody>
							<?php
							$n = 1;
							foreach ($history as $row) {
							?>
								<tr>
									<td class="text-center"><?php echo $n++; ?></td>
									<td><?php echo date('H:i:s', strtotime($row->created_date)); ?></td>
									<td class="text-center"><?php echo strtoupper($row->jenis_penunjang); ?></td>
									<td><?php echo $row->role; ?></td>
									<td><?php echo $row->created_user; ?></td>
									<td class="text-center"><?php echo $row->response_code; ?></td>
									<td class="text-center">
										<button class="btn btn-sm btn-success btnResBody">View</button>
										<textarea class="txresbody" style="display: none;"><?php echo $row->response_body; ?></textarea>
									</td>
								<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="modal_resbody" tabindex="-1" role="dialog" aria-labelledby="modal_response_body">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Response Body</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<textarea id="showjsonresbody" rows="25" class="form-control"></textarea>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php
$this->load->view('layout/footer_left.php');
?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script type="text/javascript">
	$('.btnResBody').on('click', function() {
		$('#modal_resbody').modal('show');
		$('#showjsonresbody').val(JSON.stringify(JSON.parse($(this).parent().find('.txresbody').val()), null, 4));
	});

	$('#btnCari').on('click', function name() {
		var tgl = $('#in_tgl').val();
		if (tgl) {
			$("#example").dataTable().fnDestroy();
			var table = $('#example').DataTable({
				responsive: true,
				// "scrollX": true,
				"ajax": {
					"type": "POST",
					"url": baseurl + "msg/waba/history_by_date",
					"data": {
						tgl: tgl
					},
					"timeout": 120000,
					"dataSrc": function(json) {
						if (json != null) {
							return json
						} else {
							return "";
						}
					}
				},
				"sAjaxDataProp": "",
				"width": "100%",
				"order": [
					[0, "asc"]
				],
				"aoColumns": [{
						"mData": null,
						"title": "No",
						render: function(data, type, row, meta) {
							return meta.row + meta.settings._iDisplayStart + 1;
						}
					}, {
						"mData": null,
						"title": "Time",
						"render": function(data, row, type, meta) {
							var time = new Date(data.created_date);
							return time.toLocaleTimeString([], {
								hourCycle: 'h23',
								hour: '2-digit',
								minute: '2-digit',
								second: '2-digit',
							});
						}
					},
					{
						"mData": null,
						"title": "Jenis Penunjang",
						"render": function(data, row, type, meta) {
							var jns_penunjang = data.jenis_penunjang;
							return jns_penunjang;
						}
					},
					{
						"mData": null,
						"title": "Role",
						"render": function(data, row, type, meta) {

							return data.role;
						}
					},
					{
						"mData": null,
						"title": "User",
						"render": function(data, row, type, meta) {

							return data.created_user;
						}
					},
					{
						"mData": null,
						"title": "Response Code",
						"render": function(data, row, type, meta) {

							return data.response_code;
						}
					},
					{
						"mData": null,
						"title": "Response Body",
						"render": function(data, row, type, meta) {
							let btn_resbod = '';

							btn_resbod += '<button class="btn btn-sm btn-success btnResBody">View</button>';
							btn_resbod += '<textarea class="txresbody" style="display: none;">' + data.response_body + '</textarea>';

							return btn_resbod;
						}
					}
				],
				'columnDefs': [{
					"targets": [0, 2, 5, 6], // your case first column
					"className": "text-center"
				}, {
					"targets": [1], // your case first column
					"className": "text-left"
				}]
			});
		} else {
			Swal.fire({
				icon: 'error',
				title: 'Oopss! Error',
				title: 'Tanggal Belum di Pilih'
			});
		}
	});

	$('#example').on('click', '.btnResBody', function() {
		$('#modal_resbody').modal('show');
		$('#showjsonresbody').val(JSON.stringify(JSON.parse($(this).parent().find('.txresbody').val()), null, 4));
	});
</script>