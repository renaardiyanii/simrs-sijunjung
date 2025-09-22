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
			<?php echo form_open('irj/Rjclaporan/lap_jenkel_jaminan_kasus');?>
				<div class="row p-t-20">
				<div class="col-md-2">
							<div class="form-group">
								<select name="layanan" id="layanan" class="form-control">
									<option value="rj">Rawat Jalan</option>
									<option value="rd">Rawat Darurat</option>
									<option value="ri">Rawat Inap</option>
								</select>
							</div>
					</div>
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
					<h4 align="center"> 
						<?php 
								if($layanan != ''){ 
									if($layanan == 'rj'){
										$layananya = 'Rawat Jalan';
									}else if($layanan == 'rd'){
										$layananya = 'Rawat Darurat';
									}else{
										$layananya = 'Rawat Inap';
									}
								}else{
									$layananya = '';
								}
						?>
						Laporan Kunjungan Poliklinik Berdasarkan Jaminan, 
										Kasus & Jenis Kelamin <?= $layananya ?> <?= $judul ?> 
										Di Rumah Sakit Otak DR. Drs. M. Hatta Bukittinggi</h4>
				</div>
				
						<div class="card-body">
							<div>
							<?php if ($valid == 'KOSONG') { ?>
									<center>Data Tidak Ditemukan</center>
							<?php }else{ ?>
								<div class="table-responsive ">
									<table cellpadding="0" cellspacing="0" class=" table table-hover table-bordered" border="1">
										<thead style="font-weight: bold;text-align: center;">
											<tr>
												<td style="width: 5%;" rowspan="3">No</td>
												<td style="width: 15%;" rowspan="3">Poli</td>
												<td style="width: 10%;" colspan="4">UMUM</td>
												<td style="width: 10%;" colspan="4">BPJS</td>
												<td style="width: 10%;" colspan="4">BUKIT ASAM</td>
												<td style="width: 10%;" colspan="4">PLN</td>
												<td style="width: 10%;" colspan="4">INHEALTH</td>										
												<td style="width: 10%;" colspan="4">TELKOM</td>
												<td style="width: 10%;" colspan="2" rowspan="2">TOTAL KASUS</td>
												<td style="width: 10%;" rowspan="3">Total</td>
											</tr>
											<?php 
											if($layanan == 'ri'){ ?>
<tr>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
												<td colspan="2">H</td>
												<td colspan="2">M</td>
											</tr>
											<tr>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>HIDUP</td>
												<td>MATI</td>
											</tr>
											<?php }else{ ?>
												<tr>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
												<td colspan="2">B</td>
												<td colspan="2">L</td>
											</tr>
											<tr>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>L</td>
												<td>P</td>
												<td>BARU</td>
												<td>LAMA</td>
											</tr>
											<?php }
											
											?>
											
										
										</thead>
										<?php $i=1; foreach ($kunj_poli as $row) {?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row->nm_poli ?></td>

												<td><?php echo $row->umum_baru_l ?></td>
												<td><?php echo $row->umum_baru_p ?></td>
												<td><?php echo $row->umum_lama_l ?></td>
												<td><?php echo $row->umum_lama_p ?></td>

												<td><?php echo $row->bpjs_baru_l ?></td>
												<td><?php echo $row->bpjs_baru_p ?></td>
												<td><?php echo $row->bpjs_lama_l ?></td>
												<td><?php echo $row->bpjs_lama_p ?></td>

												<td><?php echo $row->bukit_asam_baru_l ?></td>
												<td><?php echo $row->bukit_asam_baru_p ?></td>
												<td><?php echo $row->bukit_asam_lama_l ?></td>
												<td><?php echo $row->bukit_asam_lama_p ?></td>

												<td><?php echo $row->pln_baru_l ?></td>
												<td><?php echo $row->pln_baru_p ?></td>
												<td><?php echo $row->pln_lama_l ?></td>
												<td><?php echo $row->pln_lama_p ?></td>

												<td><?php echo $row->inhealth_baru_l ?></td>
												<td><?php echo $row->inhealth_baru_p ?></td>
												<td><?php echo $row->inhealth_lama_l ?></td>
												<td><?php echo $row->inhealth_lama_p ?></td>

												<td><?php echo $row->telkom_baru_l ?></td>
												<td><?php echo $row->telkom_baru_p ?></td>
												<td><?php echo $row->telkom_lama_l ?></td>
												<td><?php echo $row->telkom_lama_p ?></td>

												<td><?php echo $row->baru ?></td>
												<td><?php echo $row->lama ?></td>

												<td><?php echo $row->jumlah ?></td>

											</tr>
										<?php } ?>	
										<tr style="font-weight: bold;">
											<td colspan="2">Grand Total</td>
											<td><?php echo $jumlah_umum_baru_l ?></td>
											<td><?php echo $jumlah_umum_baru_p ?></td>
											<td><?php echo $jumlah_umum_lama_l ?></td>
											<td><?php echo $jumlah_umum_lama_p ?></td>
											
											<td><?php echo $jumlah_bpjs_baru_l ?></td>
											<td><?php echo $jumlah_bpjs_baru_p ?></td>
											<td><?php echo $jumlah_bpjs_lama_l ?></td>
											<td><?php echo $jumlah_bpjs_lama_p ?></td>
											
											<td><?php echo $jumlah_bukit_asam_baru_l ?></td>
											<td><?php echo $jumlah_bukit_asam_baru_p ?></td>
											<td><?php echo $jumlah_bukit_asam_lama_l ?></td>
											<td><?php echo $jumlah_bukit_asam_lama_p ?></td>
											
											<td><?php echo $jumlah_pln_baru_l ?></td>
											<td><?php echo $jumlah_pln_baru_p ?></td>
											<td><?php echo $jumlah_pln_lama_l ?></td>
											<td><?php echo $jumlah_pln_lama_p ?></td>
											
											<td><?php echo $jumlah_inhealth_baru_l ?></td>
											<td><?php echo $jumlah_inhealth_baru_p ?></td>
											<td><?php echo $jumlah_inhealth_lama_l ?></td>
											<td><?php echo $jumlah_inhealth_lama_p ?></td>
											
											<td><?php echo $jumlah_telkom_baru_l ?></td>
											<td><?php echo $jumlah_telkom_baru_p ?></td>
											<td><?php echo $jumlah_telkom_lama_l ?></td>
											<td><?php echo $jumlah_telkom_lama_p ?></td>

											<td><?php echo $jumlah_baru ?></td>
											<td><?php echo $jumlah_lama ?></td>

											<td><?php echo $jumlah_total ?></td>
										</tr>
									</table>
								</div>
								<?php } ?>
							</div>							
						</div>	
						<?php
							//SET PASSING PARAM
							$param=$lap_per.'/'.$layanan;
							if ($lap_per=="TGL") {
								$param .= "/".$tgl;
							} else if ($lap_per=="BLN") {
								$param .= "/".$bulan;
							} else if ($lap_per=="THN") {
								$param .= "/".$tahun;
							} 
						?>
						<a href="<?php echo site_url('irj/rjclaporan/excel_lap_jenkel_jaminan_kasus/'.$param);?>"><input type="button" class="btn 
						" style="background-color: lime;color:white;" value="Excel"></a>
						&nbsp;		
						<a href="<?php echo site_url('irj/rjclaporan/pdf_lap_jenkel_jaminan_kasus/'.$param);?>" target="_blank"><input type="button" class="btn 
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
});

</script>