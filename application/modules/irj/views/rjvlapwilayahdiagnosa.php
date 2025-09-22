<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<script type='text/javascript'>
$(function() {
	 

	$('#date_picker').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();
	$('#table').DataTable();

	
});	

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			// document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			// document.getElementById("date_picker_years").required = false;
			$('#cara_bayar').show();
			$('#date_picker').show();			
			$('#date_picker_months').hide();
			// $('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			// document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			// document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').show();
			// $('#date_picker_years').hide();
		}
		// else{
		// 	document.getElementById("date_picker").value = '';
		// 	document.getElementById("date_picker_months").value = '';
		// 	document.getElementById("date_picker").required = false;
		// 	document.getElementById("date_picker_months").required = false;
		// 	document.getElementById("date_picker_years").required = true;
		// 	$('#date_picker').hide();
		// 	$('#cara_bayar').hide();
		// 	$('#date_picker_months').hide();
		// 	$('#date_picker_years').show();
		// }
}	


</script>
	
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
			<?php echo form_open('irj/Rjclaporan/lap_wilayah_diagnosa');?>
				<div class="row p-t-20">
					<div class="col-md-2">
					<div class="form-group">
						<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Harian</option>
							<option value="BLN">Bulanan</option>
							<!-- <option value="THN">Tahunan</option> -->
						</select>
					</div>
					</div>
					<div class="col-md-3">
					<div class="">
						<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl" required>
						<input type="month" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
						<!-- <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun"> -->
					</div>
					</div>
							
					<div class="col-md-1">
					<div class="form-actions">
						<button class="btn btn-primary" type="submit">Cari</button>
					</div>
					</div>
				</div>
				<?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
	
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				
				<div class="card-title" align="center" >
					<h4 align="center">Laporan Kunjungan <?php echo $judul ?></h4>
				</div>

				<div class="card-body">
					<div>
						<?php if ($valid == 'KOSONG') { ?>
								<center>Data Tidak Ditemukan</center>
						<?php }else{ ?>
							<div class="table-responsive ">
								<table cellpadding="0" cellspacing="0" class=" table table-hover table-bordered" border="1" id="table">
								<thead style="font-weight: bold;text-align: center;">							
									<tr>
										<td>No</td>
										<td>Diagnosa</td>
										<?php foreach ($wilayah as $row) { 	?>
											<td><?php echo $row->kotakabupaten?></td>
										<?php } ?>
									</tr>
								</thead>
									<?php $i=1;
										foreach ($wilayah_detail as $key) {	
											foreach ($diagnosa as $key2) {
													
												if ($key2->id_icd == $key->id_diagnosa) {
													
																																																			
									?>
										<tr>
										
											<td><?php echo $i++; ?></td>
											<td><?php echo $key2->nm_diagnosa; ?> - <?php echo isset($key->tgl_kunjungan)?$key->tgl_kunjungan:'' ?></td>
											<?php 
												foreach ($wilayah as $row2) {
												if ($row2->kotakabupaten == $key->kotakabupaten) { ?>
													<td><?php echo $key->jmlh_pasien?></td>
												
												<?php }else{  ?>
													<td></td>
												<?php  } } ?>
										</tr>
									<?php
									} 
								}	 } ?>
									
								</table>
							</div>
						<?php } ?>
					</div>							
				</div>	                        										

					<?php
						//SET PASSING PARAM
						$param=$lap_per;
						if ($lap_per=="TGL") {
							$param .= "/".$tgl;
						} else if ($lap_per=="BLN") {
							$param .= "/".$bulan;
						} else if ($lap_per=="THN") {
							$param .= "/".$tahun;
						} 
					?>
					
					<!-- <a href="<?php echo site_url('irj/rjclaporan/excel_lap_wilayah_diagnosa/'.$param);?>"><input type="button" class="btn 
					" style="background-color: lime;color:white;" value="Excel"></a> -->
					<!-- &nbsp; -->
					<a href="<?php echo site_url('irj/rjclaporan/pdf_lap_wilayah_diagnosa/'.$param);?>" target="_blank"><input type="button" class="btn 
					" style="background-color: red;color:white;" value="PDF"></a>

			</div>
		</div>	
	</div>
</div>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 


<script type="text/javascript">
	var test = document.getElementById('baru_l').value;

	console.log(test);

$(document).ready(function() {
  $(".js-example-basic-single").select2();
  $('#table').DataTable();
});

</script>