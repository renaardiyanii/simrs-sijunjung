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

<div >
	<div >
		
		
			
		<div class="container-fluid"><br/>
		<section class="content">
				<div class="row">
						<div class="card card-outline-info">
							<div class="card-header text-white" align="center" >Laporan Pindah Ruangan Pasien Rawat Inap <br> 
							
							</div>
							<div class="card-block">
								<form action="<?php echo base_url();?>iri/riclaporan/lap_pindah_ruang_ri" method="post" accept-charset="utf-8">
									<div class="form-group row">
										<div class="col-sm-3">
											<input type="date" id="tgl1" class="form-control" name="tgl1">
										</div>
										<div class="col-sm-3">
											<input type="date" id="tgl2" class="form-control" name="tgl2">
										</div>
										<div class="col-sm-2">
											<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
										</div>
									</div>
								</form>
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
                                <th>No</th>
								<th>No Medrec</th>
								<th>No IPD</th>
                                <th>Nama</th>
								<th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>No Bed Asal</th>
                                <th>No Bed Baru</th>
								<th>Ruang Asal</th>
								<th>Ruang Baru</th>
								<th>Diagnosa</th>
								<th>Jenis Kunjungan</th>
								
								

								<!-- <th>Tgl Keluar</th> -->
							</tr>
						  </thead>

						  	<tbody>
				<?php
					 $i=1;
					foreach($data_kunjungan as $r){
                        
								
					?>
	
					<tr>
                        <td> <?php echo  $i++;?></td>
						<td><?php echo $r['no_medrec'];?></td>
						<td><?php echo $r['no_ipd'];?></td>
						<td><?php echo $r['nama'];?></td>
						<td> <?php echo $r['tgl_masuk'];?></td>
						<td> <?php echo $r['tgl_keluar'];?></td>
                        <td><?php echo $r['bed_asal'];?></td>
                        <td><?php echo $r['bed_pindah'];?></td>				
						<td><?php echo $r['nm_ruang_asal'];?></td>
						<td><?php echo $r['nm_ruang_pindah'];?></td>
						<td><?php echo $r['diagmasuk'].'-'.$r['diagnosa'];?></td>
						<td><?php echo $r['jns_kunj'];?></td>
						
						
					</tr>
				<?php
               
						}
					
				?>
					
							</tbody>
						</table>
						<br>
						<div class="form-inline" align="right">
							<div class="form-group">
								<!--<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>-->
								<a target="_blank" href="<?php echo site_url('iri/riclaporan/excel_lappindah_iri/'.$tgl1.'/'.$tgl2);?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan Excel"></a>
							</div>
						</div>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->
		</div>

	</div>
</div>
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

