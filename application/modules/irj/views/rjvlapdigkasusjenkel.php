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
			<?php echo form_open('irj/Rjclaporan/lap_dig_kasus_jenkel');?>
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
							?>
							Laporan Kunjungan Diagnosa Berdasarkan 
							Jenis Kelamin Dan Kasus <?= $layananya ?> <?= $judul ?> 
							Di RSUD SIJUNJUNG
						<?php }
						
						?>
						
					</h4>
				</div>
			
				<div class="card-body">
					<div>
					<?php if ($valid == 'KOSONG') { ?>
							<center>Data Tidak Ditemukan</center>
					<?php }else{ ?>
						<table cellpadding="0" cellspacing="0" class="table table-hover table-bordered" border="1">
						<thead style="font-weight: bold;text-align: center;">							
							<tr>
								<td style="width: 5%;" rowspan="2">No</td>
								<td style="width: 30%;" rowspan="2">Diagnosa</td>
								<td style="width: 15%;" rowspan="2">Kode ICD10</td>
								<?php 
								if($layanan == 'ri'){ ?>
									<td style="width: 20%;" colspan="2">Pasien Hidup</td>
									<td style="width: 10%;" rowspan="2">Total Pasien Hidup</td>
									<td style="width: 10%;" rowspan="2">Total Pasien Mati</td>
									<td style="width: 10%;" rowspan="2">Total Pasien <br>(H + M)</td>
								<?php }else{ ?>
									<td style="width: 20%;" colspan="2">Kunjungan Baru</td>
									<td style="width: 10%;" rowspan="2">Total Kunjungan Baru</td>
									<td style="width: 10%;" rowspan="2">Total Kunjungan Lama</td>
									<td style="width: 10%;" rowspan="2">Total Kunjungan <br>(B + L)</td>
								<?php }
								?>
								
							</tr>
							<tr>
								<td>L</td>
								<td>P</td>
							</tr>
						</thead>
							<?php $i=1; foreach ($diagnosa as $row) { ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo $row->nm_diagnosa; ?></td>
									<td><?php echo $row->id_diagnosa; ?></td>
									<td><?php echo $row->l; ?></td>
									<td><?php echo $row->p; ?></td>
									<td><?php echo $row->baru; ?></td>
									<td><?php echo $row->lama; ?></td>
									<td><?php echo $row->jumlah; ?></td>
								</tr>
							<?php } ?>
							<tr style="font-weight: bold;">
								<td colspan="3">TOTAL</td>
								<td><?php echo $jumlah_l; ?></td>
								<td><?php echo $jumlah_p; ?></td>
								<td><?php echo $jumlah_baru; ?></td>
								<td><?php echo $jumlah_lama; ?></td>
								<td><?php echo $jumlah_total; ?></td>
							</tr>
						</table>
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
                        						
				<a href="<?php echo site_url('irj/rjclaporan/excel_lap_dig_kasus_jenkel/'.$param);?>"><input type="button" class="btn 
				"  style="background-color: lime;color:white;" value="Excel"></a>
				&nbsp;
				<a href="<?php echo site_url('irj/rjclaporan/pdf_lap_dig_kasus_jenkel/'.$param);?>" target="_blank"><input type="button" class="btn 
				"  style="background-color: red;color:white;" value="PDF"></a>

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