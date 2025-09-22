<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}?>

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
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();
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
	//		document.getElementById("date_picker_months").value = '';
	//		document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = true;
			document.getElementById("date_picker2").required = true;
	//		document.getElementById("date_picker_months").required = false;
	//		document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
		//	$('#date_picker_months').hide();
			$('#date_picker2').show();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').hide();
			//$('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>	
<section class="content">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-header text-white" align="center" >Laporan Pasien Rawat Inap <br> </div>
			<div class="card-block"><br/>
				<div class="table-responsive m-t-15">
					<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="dataTables-example">
						<thead>
							<tr> 
								<th>No</th>
								<th>No. Register</th>
								<th>RM</th>
								<th>Nama</th>
								<th>Kamar</th>
								<th>Kelas</th>
								<th>Jatah Kelas</th>
								<th>No. Bed</th>
								<th>Tgl. Masuk</th>
								<th>Tanggal Perencanaan Pemulangan Pasien</th>
								<th>Dokter Yang Merawat</th>
								<th>Ket Tempat Tidur</th>
								<th>Bayi</th>
								<th>PENJAMIN</th>
							</tr>
						</thead>
						<tbody>
						<?php
					 	$i=1;
						foreach($data_kunjungan as $r){
							?>	
							<tr>
								<td> <?php echo  $i++;?></td>
								<td> <?php echo $r['no_ipd'];?></td>
								<td><?php echo $r['no_cm'];?></td>
								<td><?php echo $r['nama'];?></td>
								<td><?php echo $r['nmruang'];?></td>
								<td><?php echo $r['kelas'];?></td>					
								<td><?php echo $r['jatahklsiri'];?></td>
								<td><?php echo $r['bed'];?></td>
								<td><?php echo date("d-m-Y", strtotime($r['tgl_masuk']));?></td>
								<td><?php echo $r['tanggal_perencanaan_pemulangan']?date("d-m-Y", strtotime($r['tanggal_perencanaan_pemulangan'])):'';?></td>
								<td><?php echo $r['dokter'];?></td>
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


								<td><?php if ($r['status_bayi'] == 0) {
									echo "Tidak Punya";
								} else {
									echo "Punya";
								}
								?></td>
								<td><?php echo $r['carabayar'];?></td>						
							</tr>
						<?php } ?>
						</tbody>
					</table><br>
					<div class="form-inline" align="right">
						<div class="form-group">
							<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
							btn-primary" value="Cetak Laporan PDF"></a>-->
							<a target="_blank" href="<?php echo site_url('iri/riclaporan/excel_laprawat_iri/');?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan Excel"></a>
						</div>
					</div>
				</div><!-- style overflow -->
			</div><!--- end panel body -->
		</div><!--- end panel -->
	</div><!--- end panel -->
</section>
		<!-- /Main content -->
		
<script>
	$('#calendar-tgl').datepicker();
</script>

<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>
