<?php
date_default_timezone_set('Asia/Jakarta');
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
		$('#date_months').show();
		$('#date_days').hide();
	}
}

</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
			<form action="<?php echo base_url();?>ird/rdclaporan/lap_kunj_pasien_igd" method="post" accept-charset="utf-8">
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
			<h4>Laporan Kunjungan Pasien<br>Tanggal <?php echo $date_title; ?></h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" class="table table-responsive" id="dataTables-example">
			<thead>
				<tr>
					<th width="3%"><b>No</b></th>
					<th width="10%"><b>Nama</b></th>
					<th width="5%"><b>No MR</b></th>
					<th width="5%"><b>Jenis Pasien</b></th>
					<th width="3%"><b>Umur</b></th>
					<th width="3%"><b>Jenis Kelamin</b></th>
					<th width="7%"><b>No SEP</b></th>
					<th width="6%"><b>Jaminan</b></th>
					<th width="6%"><b>Alamat</b></th>
					<th width="10%"><b>Diagnosa</b></th>
					<th width="10%"><b>ICD-10</b></th>				
					<th width="10%"><b>Dokter</b></th>
					<th width="5%"><b>Waktu Masuk</b></th>
					<th width="5%"><b>Waktu Keluar</b></th>
					<th width="5%"><b>Ket Pulang</b></th>
					<th width="5%"><b>LOS IGD</b></th>
					<th width="5%"><b>Serangan Stroke</b></th>
					<th width="5%"><b>Tindakan</b></th>
				</tr>
			</thead>
			<tbody>
			<?php
				$i=1;
				foreach($data_kunjungan as $r){ ?>
					<tr>
						<td> <?php echo $i++;?></td>
						<td><?php echo $r['nama'];?></td>
						<td><?php echo $r['no_cm'];?></td>
						<td><?php echo $r['jns_kunj'];?></td>
						<td><?php echo (int)date('Y') - (int)date('Y',strtotime(isset($r['tgl_lahir'])?$r['tgl_lahir']:'')) ; ?></td>				
						<td><?php echo $r['jenis_kelamin'];?></td>
						<td><?php 
							if($r['cara_bayar'] == 'BPJS') {
								if($r['ket_pulang'] == 'BATAL_PELAYANAN_POLI' || $r['ket_pulang'] == 'DIRUJUK_RAWATINAP') {
									echo '-';
								} else {
									if($r['no_sep'] == NULL) {
										echo '- '."<a href='".base_url()."irj/rjcregistrasi/sep_pasien/' target=\"_blank\" class=\"btn btn-danger btn-sm\"> Isi No SEP disini</a>";
									} else {
										echo $r['no_sep'];
									}
								}
							} else {
								echo '-';
							}
						?></td>
						<td>
							<?php 
								if($r['cara_bayar'] == 'KERJASAMA'){
									echo $r['nmkontraktor'];
								}else{
									echo $r['cara_bayar'];
								}
							?>
						</td>
						<td><?php echo $r['alamat'];?></td>
						<td><?php echo $r['nama_diagnosa'];?></td>	
						<td><?php echo $r['id_diagnosa'];?></td>
						<td><?php echo $r['nama_dokter'];?></td>	
						<td><?php echo $r['jam'];?></td>				
						<td><?php echo isset($r['waktu_pulang'])?date('H:i:s',strtotime($r['waktu_pulang'])):'';?></td>	
						<td><?php echo $r['ket_pulang'];?></td>
						<td>
							<?php
								if($r['tgl_daftar'] != null && $r['waktu_pulang'] != null){
									$waktu_masuk = date("H:i:s", strtotime($r['tgl_daftar']));
									$waktu_keluar = date("H:i:s", strtotime($r['waktu_pulang']));
									$datetime1 = new DateTime($waktu_masuk);//start time
									$datetime2 = new DateTime($waktu_keluar);//end time
									$interval = $datetime1->diff($datetime2);
									echo date('H:i:s', strtotime($interval->h.':'.$interval->i.':'.$interval->s));
								}else{
									echo '';
								}							
							?>
						</td>
						<td>
							<?php 
							$ket_stroke = json_decode($r['ket_stroke']);
							$kel_golden_details = json_decode($r['kel_golden_details']);
							$golden_details_satu = json_decode($r['golden_details_satu']);
							$kel_akut = json_decode($r['kel_akut']);

							if($ket_stroke == 'Kel Akut'){
								echo 'Kel Akut('.$kel_akut.')';
							}else if($ket_stroke == 'Kel Golden Stroke'){
								if($kel_golden_details == '≤ 4,5 Jam'){
									echo 'Kel Golden('.$golden_details_satu.')';
								}else{
									echo 'Kel Golden('.$kel_golden_details.')';
								}
							}else if($ket_stroke == 'Non Stroke'){
								echo 'Non Stroke';
							}
							
							?>
						</td>
						<td>
							<?php 
							foreach($data_kunjungan_tind as $tindakan_pasien){
								if($tindakan_pasien['no_register'] == $r['no_register']){ 
									echo '-'.$tindakan_pasien['nmtindakan'].'<br>';
								}

							}
							?>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<div class="form-inline" align="right">
		<div class="form-group">
			<a target="_blank" href="<?php echo site_url('ird/rdclaporan/excel_lap_igd');?><?php echo '/'.$tampil.'/'.$date;?>"><input type="button" class="btn btn-primary" value="Cetak Laporan Excel"></a>
		</div>
	</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>