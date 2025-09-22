<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}?>
<script type='text/javascript'>

$(function() {
	 
	$('#ruang').hide();
	$('.date_picker').datepicker({
				format: "dd-mm-yyyy",
				endDate: "current",
				autoclose: true,
				todayHighlight: true,
	});
		$('#myTable').DataTable();
});	

function cek_tgl_awal(tgl_awal){
	var tgl_akhir=document.getElementById("tgl_akhir").value;
	if(tgl_akhir==''){
	//none :D just none
	}else if(tgl_akhir<tgl_awal){
		document.getElementById("tgl_akhir").value = '';
	}
}
function cek_tgl_akhir(tgl_akhir){
	var tgl_awal=document.getElementById("tgl_awal").value;
	if(tgl_akhir<tgl_awal){
		document.getElementById("tgl_awal").value = '';
	}
}
	
function cek_tampil_per(val_tampil_per){
	if(val_tampil_per=='TGL'){
		document.getElementById("date_picker_months").value = '';
		document.getElementById("date_picker_years").value = '';
		document.getElementById("date_picker").required = true;
		document.getElementById("date_picker_months").required = false;
		document.getElementById("date_picker_years").required = false;
		$('#date_picker').show();
		$('#date_picker_months').hide();
		$('#date_picker_years').hide();
		$('#cara_bayar').hide();
	}else if(val_tampil_per=='BLN'){
		document.getElementById("date_picker").value = '';
		document.getElementById("date_picker_years").value = '';
		document.getElementById("date_picker").required = false;
		document.getElementById("date_picker_months").required = true;
		document.getElementById("date_picker_years").required = false;
		$('#date_picker').hide();
		$('#date_picker_months').show();
		$('#date_picker_years').hide();
		$('#cara_bayar').show();
	}else{
		document.getElementById("date_picker").value = '';
		document.getElementById("date_picker_months").value = '';
		document.getElementById("date_picker").required = false;
		document.getElementById("date_picker_months").required = false;
		document.getElementById("date_picker_years").required = true;
		$('#date_picker').hide();
		$('#date_picker_months').hide();
		$('#date_picker_years').show();
		$('#cara_bayar').show();
	}
}

function jenis_jenis(params) {
	if(params == 'RJ'){
		$('#ruang').hide();
		$('#poli').show();
	}else{
		$('#ruang').show();
		$('#poli').hide();
	}
}

</script>
<style>
hr {
	border-color:#7DBE64 !important;
}

thead {
	background: #c4e8b6 !important;
	background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
	background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
	background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
}
tr.border_top td {
  border-bottom:1pt solid black;
}
</style>
	
	<!--
	<section class="content-header">
	<legend>Laporan Kunjungan Instalasi Rawat Jalan</legend>
	-->
<div class="container-fluid"><br/>
	<div class="inline">
		<div class="row">
			<div class="card card-block">
				<?php echo form_open('irj/Rjclaporan/datakeu_dokter');?>
				<div class="col-lg-12">
					<div class="form-inline">
						
						<input type="text" id="tgl_awal" class="form-control date_picker" placeholder="tanggal awal" autocomplete="off" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
						<input type="text" id="tgl_akhir" class="form-control date_picker" placeholder="tanggal akhir" autocomplete="off" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
						
						<select name="id_dokter" id="id_dokter" class="form-control" required>
							<option value="" selected>-Pilih Dokter-</option>
							<?php 
							foreach($dokter as $row){
								echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
							}
							?>
						</select>

						<select name="jenis_pelayanan" id="jenis_pelayanan" class="form-control" required onchange="jenis_jenis(this.value)">
							<option value="RJ">RAWAT JALAN</option>
							<option value="RI">RAWAT INAP</option>
						</select> 

						<select name="poli" id="poli" class="form-control" >
							<?php 
							foreach($poliklinik as $row){
								echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
							}
							?>
						</select>

						<select name="ruang" id="ruang" class="form-control" >
							<?php 
							foreach($ruang as $row){
								echo '<option value="'.$row->idrg.'">'.$row->nmruang.'</option>';
							}
							?>
						</select>
						
						&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="btn btn-primary" type="submit">Cari</button>
						
					</div>
					
				</div><!-- /inline -->
			</div>
			<?php echo form_close();?>
		</div>						
	</div>
</div>
	

	<section class="content">
		
			<div class="card card-outline-info">
				<div class="card-header text-white" align="center" >Laporan Pendapatan Dokter <?php echo $date_title; ?><br/></div>
					<div class="card-block">
					
							
								
									<table id="myTable" class="table table-hover" >
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal Kunjungan</th>
												<th>No Register</th>
												<th>Ruang/Poli</th>
												<th>Nama Dokter</th>
												<th>Total</th>
											</tr>
										</thead>
										<tbody>
											<?php if($datakeu_dokter == null){ ?>
												<tr>
													<td colspan="5" align="center">Data Tidak Ada</td>
												</tr>
											<?php }else{ ?>
												<?php $i = 1; foreach($datakeu_dokter as $row){ ?>
													<tr>
														<td><?php echo $i++; ?></td>
														<td><?php echo $row->tgl_kunjungan ?></td>
														<td><?php echo $row->no_register ?></td>
														<td><?php echo $row->nm_poli ?></td>
														<td><?php echo $row->nm_dokter ?></td>
														<td><?php echo $row->vtot ?></td>
													</tr>
												<?php } ?>	
											<?php } ?>
											
										</tbody>
									</table>
								</div>			
							
							<?php
							
							//include("rjvlapkeuangandokter_harian.php");
							
							//if (sizeof($datakeu_dokter)>0){
							?>

		
								<!-- <div class="form-inline" align="right">
									<div class="form-group"> -->
									<!--<a target="_blank" href="<?php// echo site_url('irj/rjclaporan/lap_kunj_poli/'.$tgl_awal.'/'.$tgl_akhir);?>"><input type="button" class="btn btn-primary" value="Cetak Detail"></a>-->
									
									<?php
									//SET PASSING PARAM
								//	$param = $id_dokter."/".$tgl_awal."/".$tgl_akhir."/".$cara_bayar;
									?>
									
									<!-- <a target="_blank" href="<?php echo site_url('irj/rjcexcel/excel_lapkeudokter/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="Download Excel"></a>
									&nbsp;
									<a target="_blank" href="<?php echo site_url('irj/rjccetaklaporan/pdf_lapkeudokter/'.$param);?>"><input type="button" class="btn 
									btn-primary" value="Cetak PDF"></a> -->
									
							<?php 
							//} 
							?>
							</div>
						
							
					</div>
				</div><!--- end panel body -->
			</div><!--- end panel -->
		
	</section>

<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>