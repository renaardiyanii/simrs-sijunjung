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
	

	
	
});	
function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			$('#cara_bayar').show();
			$('#date_picker').show();			
			$('#date_picker_months').hide();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker').hide();
			$('#cara_bayar').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
}	


</script>
	
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
			<?php echo form_open('irj/Rjclaporan/lap_dokter_poli_jaminan');?>
				<div class="row p-t-20">
					<div class="col-md-2">
					<div class="form-group">
						<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
							<option value="TGL">Harian</option>
							<option value="BLN">Bulanan</option>
							<option value="THN">Tahunan</option>
						</select>
					</div>
					</div>
					<div class="col-md-3">
					<div class="">
						<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl" required>
						<input type="month" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
						<input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="yyyy" name="tahun">
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
					<h4 align="center">Laporan Kunjungan <?php echo $judul ?></h4></div>
					</div>
						<div class="card-body">
							<div>
							<?php if ($valid == 'KOSONG') { ?>
									<center>Data Tidak Ditemukan</center>
							<?php }else{ ?>
								<table cellpadding="0" cellspacing="0" class="table table-hover table-bordered" border="1" id="dataTable">
								<thead style="font-weight: bold;text-align: center;">
								<tr>
									<td>No</td>
									<td>NAMA DOKTER</td>
									<td>SELISIH PERAWAT DOKTER</td>
									<td>PASIEN</td>
									<td>WAKTU RATA RATA</td>
								</tr>							
								</thead>
									<?php $i = 1; foreach($poli as $row2){ 
			
										$array = json_decode(json_encode($data), True);
										$data_poli=array_column($array, 'id_poli');
									
										//Klo data tdk kosong, tampilkan
										if (in_array($row2->id_poli, $data_poli)) {	 ?>	
											<tr>
												<td colspan="5"><?php echo $row2->nm_poli;?></td>
											</tr>
											<?php 
										
												foreach ($data as $row) { 
													if ($row->id_poli == $row2->id_poli) { 
														
												?>
													<tr>
													<td><?php echo $i++; ?></td>
														<td><?php echo $row->nm_dokter; ?></td>
														<td><?php echo $row->jumlah; ?></td>
														<td><?php echo $row->pasien; ?></td>
														<td><?php  
															$selisih = (int)$row->jumlah / (int)$row->pasien;
															echo number_format($selisih,2,",",".");
														?></td>
													</tr>

												<?php } ?>
											<?php } ?>
											
											
										<?php } ?>
									<?php } ?>
															
								</table>
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
						
						<a href="<?php echo site_url('irj/rjclaporan/excel_lap_wilayah_jaminan/'.$param);?>"><input type="button" class="btn 
									btn-warning" value="Excel"></a>
									&nbsp;
											
				
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
});

</script>