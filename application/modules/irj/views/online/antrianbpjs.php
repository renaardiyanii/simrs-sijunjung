<?php 
	$this->load->view("layout/header_left");
    
?> 
<html>
<style>
	table.dataTable{
		border:1px solid black;
	}
	.table td, .table th{
		border-color: #979797;
	}
</style>
<script type='text/javascript'>
	$(function() {
		$('#tableantrian').DataTable();
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});  
	});

	
</script>


<div class="card p-4">
	<div class="card-body">
		<div class="row">
			<div class="col-md-2">
				<div class="form-group">
					<p>Pilih Tanggal awal:</p>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<input class="form-control" type="date" id="tglawal">
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<p>Pilih Tanggal akhir:</p>
				</div>
			</div>

			<div class="col-md-3">
				<div class="form-group">
					<input class="form-control" type="date" id="tglakhir">
				</div>
			</div>

			<div class="col-md-2">
				<div class="form-group">
					<button class="btn btn-info" id="caridata" onclick="funccaridata()">Cari Data</button>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="card p-4">
	<div class="card-header">
		<div style="text-align:center;font-size:16px">
			<h4>Antrian Online BPJS</h4>
		</div>
	</div>
	<div class="card-body">
		<table  width="100%" class="table table-bordered" id="tableantrian">
			<thead>
				<tr>
					<th>Aksi</th>
					<th>No. RM</th>
					<th>NIK</th>
					<th>Nomor Kartu BPJS</th>
					<th>Poliklinik</th>
					<th>Dokter</th>
				</tr>
			</thead>
			<tbody id="hasilantrian">
				
			</tbody>
		</table>
	</div>
</div>
<script>
	
	const funccaridata = ()=>{
		let tglawal = $('#tglawal').val();
		let tglakhir = $('#tglakhir').val();
		callantrian(tglawal,tglakhir);
	}

	const callantrian = (tglawal = '',tglakhir = '')=>{
		$.ajax({
			url:tglawal!=='' && tglakhir!=''?`<?= base_url('irj/rjconline/get_list_antrian') ?>?tglawal=${tglawal}&tglakhir=${tglakhir}`:`<?= base_url('irj/rjconline/get_list_antrian') ?>`,
			beforeSend: function(){
				$("#hasilantrian").html('<tr><td colspan="6" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
			},
			success : function(data){
				let html = '';

				if (data.response.length>0){
					console.log(data.response);
					data.response.map((e)=>{
						html+=`
						<tr>
							<td>
								<button class="btn btn-danger" onclick='batal(${JSON.stringify(e)})'>Batal</button>
								<button class="btn btn-primary" onclick='register(${JSON.stringify(e)})'>Registrasi</button>
							</td>
							<td>${e.norm}</td>
							<td>${e.nik}</td>
							<td>${e.nomorkartu}</td>
							<td>${e.namapoli}</td>
							<td>${e.namadokter}</td>
						</tr>
						`;
					})
				}else{
					html+='<tr><td colspan="6" style="text-align:center;">Data Kosong</td></tr>';
				}
				
				$('#hasilantrian').html(html);
			}
		})
	}
	$(document).ready(function(){
		callantrian();
	});

	function batal(data)
	{
		console.log(data)
	}

	function register(data)
	{
        window.location.href='<?= base_url('') ?>/irj/rjcregistrasi/daftarulangnew/'+data.nocm+`?carabayar=${data.carabayar}&iddokter=${data.iddokter}&idpoli=${data.idpoli}&nokartu=${data.nokartu}&tglkunjungan=${data.tglkunjungan}&online=1&noreservasi=${data.noreservasi}&tiperujukan=${data.tiperujukan}`;
	}
</script>
    <?php 
		$this->load->view("layout/footer_left");
       
    ?> 