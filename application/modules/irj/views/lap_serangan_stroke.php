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
					<form action="<?php echo base_url();?>irj/rjclaporan/lap_serangan_stroke" method="post" accept-charset="utf-8">
						<div class="col-lg-12">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<option value="BLN">Bulan</option>
								</select>
								<input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" style="margin-left: 5px;" required>
								<input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" style="margin-left: 5px;" required>
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
			<h4>LAPORAN SERANGAN STROKE<br>
			<!-- Tanggal <?php //echo $tgl_awal; ?> - <?php //echo $tgl_akhir; ?> -->
			</h4>
		</div>
	</div>
	<div class="card-body">
		<table cellspacing="0" width="100%" border=0 class="table table-striped table-hover">
			   
                    <tr>
                        <td style="font-weight:bold">No</td>
                        <td style="font-weight:bold">Serangan Stroke</td>
                        <td style="font-weight:bold">Jumlah</td>
                        <td style="font-weight:bold">%</td>
                    </tr>
			   
					<?php 
						$total_pasien = $data_kunjungan->kel_golden + $data_kunjungan->kel_akut + $data_kunjungan->non_stroke;
					?>

                    <tr>
                        <td style="font-weight:bold">A</td>
                        <td style="font-weight:bold">Kel Golden Periode</td>
                        <td style="font-weight:bold"><?= isset($data_kunjungan->kel_golden)?$data_kunjungan->kel_golden:'' ?></td>
						<?php 
						if($data_kunjungan->kel_golden == 0){
							$persen_kel_golden = 0;
						}else{
							$persen_kel_golden = $data_kunjungan->kel_golden / $total_pasien;
						}
						
						$persentase_kel_golden = $persen_kel_golden * 100;
						?>
                        <td style="font-weight:bold"><?= number_format($persentase_kel_golden,2).'%' ?><td>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>* ≤ 4,5 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_1)?$data_kunjungan->kel_golden_1:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>- 1 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_1jam)?$data_kunjungan->kel_golden_1jam:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>- 2 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_2jam)?$data_kunjungan->kel_golden_2jam:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>- 3 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_3jam)?$data_kunjungan->kel_golden_3jam:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>- 4 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_4jam)?$data_kunjungan->kel_golden_4jam:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td>- 4.5 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_4koma5jam)?$data_kunjungan->kel_golden_4koma5jam:'' ?></td>
                        <td></td>
                    </tr>

					<tr>
                        <td>2</td>
                        <td>* > 4,5 Jam sd/ ≤ 6 Jam</td>
                        <td><?= isset($data_kunjungan->kel_golden_2)?$data_kunjungan->kel_golden_2:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td style="font-weight:bold">B</td>
                        <td style="font-weight:bold">Kel Akut</td>
                        <td style="font-weight:bold"><?= isset($data_kunjungan->kel_akut)?$data_kunjungan->kel_akut:'' ?></td>
						<?php 
						if($data_kunjungan->kel_akut == 0){
							$persen_kel_akut = 0;
						}else{
							$persen_kel_akut = $data_kunjungan->kel_akut / $total_pasien;
						}
						
						$persentase_kel_akut = $persen_kel_akut * 100;
						?>
                        <td style="font-weight:bold"><?= number_format($persentase_kel_akut,2).'%' ?><td>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>> 06 Jam sd ≤ 24 Jam</td>
                        <td><?= isset($data_kunjungan->kel_akut_1)?$data_kunjungan->kel_akut_1:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>> 24 Jam sd ≤ 03 hari</td>
                        <td><?= isset($data_kunjungan->kel_akut_2)?$data_kunjungan->kel_akut_2:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>> 03 Hari sd ≤ 07 hari</td>
                        <td><?= isset($data_kunjungan->kel_akut_3)?$data_kunjungan->kel_akut_3:'' ?></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>> 07 hari</td>
                        <td><?= isset($data_kunjungan->kel_akut_4)?$data_kunjungan->kel_akut_4:'' ?></td>
                        <td></td>
                    </tr>

					<tr>
                        <td style="font-weight:bold">C</td>
                        <td style="font-weight:bold">Non Stroke</td>
                        <td style="font-weight:bold"><?= isset($data_kunjungan->non_stroke)?$data_kunjungan->non_stroke:'' ?></td>
                        <?php 
						if($data_kunjungan->non_stroke == 0){
							$persen_non_stroke = 0;
						}else{
							$persen_non_stroke = $data_kunjungan->non_stroke / $total_pasien;
						}
						
						$persentase_non_stroke = $persen_non_stroke * 100;
						?>
                        <td style="font-weight:bold"><?= number_format($persentase_non_stroke,2).'%' ?><td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="font-weight:bold">Grand Total</td>
                        <td style="font-weight:bold"><?= $total_pasien ?></td>
                        <?php 
						if($total_pasien == 0){
							$persen_total = 0;
						}else{
							$persen_total = $total_pasien / $total_pasien;
						}
						
						$persentase_total = $persen_total * 100;
						?>
                        <td style="font-weight:bold"><?= number_format($persentase_total,2).'%' ?><td>
                    </tr>
				
		</table>
	</div>
						<div class="form-inline" align="right">
							<div class="form-group">
								<?php 
								if($tampil == 'TGL'){ ?>
									<a target="_blank" href="<?php echo site_url('irj/rjclaporan/excel_lap_serangan_stroke_tgl/');?><?php echo $date1.'/'.$date2;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
								<?php }else if($tampil == 'BLN'){ ?>
									<a target="_blank" href="<?php echo site_url('irj/rjclaporan/excel_lap_serangan_stroke_bln/');?><?php echo $date;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
								
								<?php }else{?>
									<a target="_blank" href="<?php echo site_url('irj/rjclaporan/excel_lap_serangan_stroke_tgl/');?><?php echo $date.'/'.$date;?>"><input type="button" class="btn 
									btn-primary" value="Cetak Laporan Excel"></a>
									<?php }?>
								
							</div>
						</div>
</div>

<?php
$this->load->view('layout/footer_left.php');
?>