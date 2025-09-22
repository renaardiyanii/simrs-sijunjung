<?php
date_default_timezone_set('Asia/Jakarta');
$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
$(function() {
	 
	$('#dataTables-example').DataTable();

	// $('#date_picker1').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	// $('#date_picker2').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	

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
	$('#date_picker1').show();
	$('#date_picker2').show();
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
		document.getElementById("date_picker1").required = true;
		document.getElementById("date_picker2").required = true;
		document.getElementById("date_months").required = false;
		$('#date_picker1').show();
		$('#date_picker2').show();
		$('#date_months').hide();
	}else if(val_tampil_per=='BLN'){
		document.getElementById("date_months").required = true;
		document.getElementById("date_picker1").required = false;
		document.getElementById("date_picker2").required = false;
		$('#date_months').show();
		$('#date_picker1').hide();
		$('#date_picker2').hide();
	}
}

</script>

<div class="card p-4">
	<div class="card-body">
		<div class="row">
					<form action="<?php echo base_url();?>iri/ricmedrec/laporan_kelengkapan_rm" method="post" accept-charset="utf-8">
						<div class="col-lg-12">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<option value="BLN">Bulan</option>
								</select>
								<input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" style="margin-left: 5px;" required>
								<input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" style="margin-left: 10px;" required>
								<input type="month" id="date_months" class="form-control" placeholder="Tanggal Akhir" name="date_months" style="margin-left: 5px;">
								<select name="idrg" id="idrg" class="form-control" style="margin-left: 10px;" required>
									<option value="semua">Semua</option>
									<option value="'0801'">Limpapeh L2</option>
									<option value="'0802','0804'">Limpapeh L3</option>
									<option value="'0803','0805'">Limpapeh L4</option>
									<option value="'0601','0602'">Singgalang L1 dan L2</option>
									<option value="'0603'">Singgalang L3</option>
									<option value="'0701'">Merapi L1</option>
									<option value="'0705','0702'">Merapi L2</option>
									<option value="'0706','0703'">Merapi L3</option>
									<option value="'0101','0501','0103'">Anak</option>
									<option value="'0502'">Bedah</option>
									<option value="'0503','0107'">Kebidanan</option>
									<option value="'0404','0704'">ICU</option>
									<option value="'0406'">NICU</option>
								</select>
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
			<h4>KELENGKAPAN DAN KETEPATAN PENGEMBALIAN REKAM MEDIS DALAM WAKTU 24 JAM<br>
			<!-- Tanggal <?php //echo $tgl_awal; ?> - <?php //echo $tgl_akhir; ?> -->
			</h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" class="table table-responsive" id="dataTables-example">
			<thead>
				<tr>
								<th width="3%"><b>Dirawat Diruangan</b></th>
								<th width="10%"><b>DPJP</b></th>
								<th width="5%"><b>Lengkap ≤ 24 jam</b></th>
								<th width="3%"><b>%</b></th>
								<th width="3%"><b>Tdk Lengkap ≤ 24 jam </b></th>
								<th width="6%"><b>%</b></th>
								<th width="6%"><b>Jumlah Berkas</b></th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($data_kunjungan as $r) { ?>
							<tr>
								<td><?php echo $r->nmruang ?></td>
								<td><?php echo $r->dokter ?></td>
								<td><?php echo $r->lengkap_kurang_24 ?></td>
								<?php 
									$jmlh_berkas = $r->lengkap_kurang_24 + $r->tdk_lengkap_kurang_24;
									if($r->lengkap_kurang_24 == '0' && $jmlh_berkas == 0){
										$lengkap = 0;
									}else{
										$lengkap = $r->lengkap_kurang_24 / $jmlh_berkas;
										
									}
									$lengkap_persen = $lengkap * 100;
									if($r->tdk_lengkap_kurang_24 == '0' && $jmlh_berkas == 0){
										$tdk_lengkap = 0;
										
									}else{
										$tdk_lengkap = $r->tdk_lengkap_kurang_24 / $jmlh_berkas;
									}
									
									$tdk_lengkap_persen = $tdk_lengkap * 100;

								?>
								<td><?php echo $lengkap_persen.'%' ?></td>
								<td><?php echo $r->tdk_lengkap_kurang_24 ?></td>
								<td><?php echo $tdk_lengkap_persen.'%' ?></td>
								<?php 
								
								?>
								<td><?php echo $jmlh_berkas ?></td>
							</tr>

				<?php } ?>
			</tbody>
		</table>
	</div>
						<div class="form-inline" align="right">
							<div class="form-group">
								<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>-->
								<!-- <a target="_blank" href="<?php echo site_url('iri/ricmedrec/excel_laporan_kelengkapan_rm');?><?php echo '/'.$idrg.'/'.$tgl_awal.'/'.$tgl_akhir;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan Excel"></a> -->

								<?php 
								if($tampil == 'TGL'){ ?>
									<a target="_blank" href="<?php echo site_url('iri/ricmedrec/excel_laporan_kelengkapan_rm/');?><?php echo $idrg.'/'.$tgl_awal.'/'.$tgl_akhir;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
								<?php }else if($tampil == 'BLN'){ ?>
									<a target="_blank" href="<?php echo site_url('iri/ricmedrec/excel_laporan_kelengkapan_rm_bln/');?><?php echo $idrg.'/'.$date;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
								
								<?php }else{?>
									<a target="_blank" href="<?php echo site_url('iri/ricmedrec/excel_laporan_kelengkapan_rm/');?><?php echo $idrg.'/'.$tgl_awal.'/'.$tgl_akhir;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
									<?php }?>


							</div>
						</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>