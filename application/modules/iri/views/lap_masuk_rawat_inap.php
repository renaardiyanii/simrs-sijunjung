<?php
$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
$(function() {
	$('#dataTables-example').DataTable();

	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		//endDate: "current",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_days').show();
	$('#date_months').hide();
});	
function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_days").required = true;
			document.getElementById("date_months").required = false;
			$('#date_days').show();
			$('#date_months').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_months").required = true;
			document.getElementById("date_days").required = false;
			$('#date_days').hide();
			$('#date_months').show();
		}
		// else{
		// 	document.getElementById("date_picker1").value = '';
		// 	document.getElementById("date_picker2").value = '';
		// 	document.getElementById("date_picker_months").value = '';
		// 	document.getElementById("date_picker1").required = false;
		// 	document.getElementById("date_picker2").required = false;
		// 	document.getElementById("date_picker_months").required = false;
		// 	document.getElementById("date_picker_years").required = true;
		// 	$('#date_picker1').hide();
		// 	$('#date_picker2').hide();
		// 	$('#date_picker_months').hide();
		// 	$('#date_picker_years').show();
		// }
	}

</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
			<form action="<?php echo base_url();?>iri/riclaporan/lap_masuk_ri" method="post" accept-charset="utf-8">
				<div class="col-lg-12">
					<div class="form-inline">
						<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Tanggal</option>
							<option value="BLN">Bulan</option>
						</select>
						<input type="date" id="date_days" class="form-control" placeholder="Pilih Tanggal" name="date_days" style="margin-left: 5px;">
						<input type="month" id="date_months" class="form-control" placeholder="Tanggal Akhir" name="date_months" style="margin-left: 5px;">
 						<button class="btn btn-primary" type="submit" style="margin-left: 5px;">Tampilkan</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="card p-4">
	<div class="card-header">
		<div style="text-align:center;font-size:16px">
			<h4>Laporan Masuk Pasien Rawat Inap<br>Tanggal <?php echo $date_title; ?>
			</h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" class="table table-responsive" id="dataTables-example">
			<thead>
                <tr>
					<th>No</th>
                    <th>No Register</th>
					<th>RM</th>
					<th>Nama</th>
					<th>Jenis Kelamin</th>
					<th>Alamat</th>
					<th>Jaminan</th>
					<th>Ruangan</th>
					<th>Kelas</th>
					<th>Jatah Kelas</th>
					<th>DPJP Utama</th>
					<th>Diagnosa Masuk</th>
					<th>Ket Tempat tidur</th>
					<th>Waktu Daftar RI</th>
					<th>Waktu Diterima Petugas RI</th>
					<th>WMRI</th>
					<th>Tgl Masuk</th>
					<th>Tgl Keluar</th>
					<th>Pintu Masuk</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
				foreach($data_kunjungan as $r){ ?>
                    <tr>
						<td> <?php echo $i++;?></td>
						<td><?php echo $r['no_ipd'];?></td>
						<td><?php echo $r['no_cm'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['jenis_kelamin'];?></td>
						<td><?php echo $r['alamat'];?></td>
						<td><?php echo $r['carabayar'];?></td>
						<td><?php echo $r['ruang'];?></td>
						<td><?php echo $r['klsiri'];?></td>
						<td><?php echo $r['jatahklsiri'];?></td>
						<td><?php echo $r['dokter'];?></td>
						<td><?php echo $r['diagmasuk'].'-'.$r['diagnosa'];?></td>
						<td>
						<?php 
							if($r['selisih_tarif'] == 1){
								echo 'Selisih Tarif';
							}else if($r['titip'] == 1){
								echo 'Titip';
							}else if($r['naik_1_tingkat'] == 1){
								echo 'Naik 1 Tingkat';
							}else{
								echo 'Sesuai';
							}
							?>
						</td>
						<td> <?php 
						if($r['wkt_akhir_admisi'] != null){
							echo isset($r['wkt_akhir_admisi'])?date('H:i:s',strtotime($r['wkt_akhir_admisi'])):'';
						}else{
							echo isset($r['tgldaftarri'])?date('H:i:s',strtotime($r['tgldaftarri'])):'';
						}
						?>
						
						</td>
						<td> <?php echo isset($r['wkt_masuk_rg'])?date('H:i:s',strtotime($r['wkt_masuk_rg'])):'';?></td>
						<td>
							<?php
								if($r['tgldaftarri'] != null && $r['wkt_masuk_rg'] != null){
									if($r['wkt_akhir_admisi'] != null){
										$waktu_daftar_ri = date_create($r['wkt_akhir_admisi']);
										$waktu_diterima = date_create($r['wkt_masuk_rg']);
										$diff = date_diff($waktu_diterima,$waktu_daftar_ri);
										echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
									}else{
										$waktu_daftar_ri = date_create($r['tgldaftarri']);
										$waktu_diterima = date_create($r['wkt_masuk_rg']);
										$diff = date_diff($waktu_diterima,$waktu_daftar_ri);
										echo date('H:i:s',strtotime($diff->h.':'.$diff->i.':'.$diff->s)); 
									}
									
								}else{
									echo '';
								}							
							?>
						</td>
						<td><?php echo $r['tgl_masuk'];?></td>
						<td><?php echo $r['tgl_keluar'];?></td>
						<td><?php echo $r['pintu_masuk'];?></td>				
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="form-inline" align="right">
		<div class="form-group">
			<a target="_blank" href="<?php echo site_url('iri/riclaporan/excel_lapmasuk_iri/');?><?php echo $tampil.'/'.$date;?>"><input type="button" class="btn btn-primary" value="Cetak Laporan Excel"></a>
		</div>
	</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>