    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<?php 
$this->load->view("iri/layout/script_addon"); 
?>
   <!-- Date Picker Plugin JavaScript -->
    <script src="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js'); ?>"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="<?php echo site_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <script>

    </script>
<script type='text/javascript'>
$(function() {
    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
    	locale: {
      		format: 'YYYY-MM-DD'
		},
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
	 
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
	// $('#date_picker1').show();
	$('#date_picker2').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	
});	
// function cek_tgl_awal(tgl_awal){
// 		var tgl_akhir=document.getElementById("date_picker2").value;
// 		var tgl_akhir=$('#date_picker2').val();
// 		if(tgl_akhir==''){
// 		//none :D just none
// 		}else if(tgl_akhir<tgl_awal){
// 			$('#date_picker2').val('');
// 			document.getElementById("date_picker2").value = '';
// 		}
// 	}

function rawat_lagi(no_ipd){
      swal({
         title: "Kembalikan Pasien",
         text: "Benar Akan Memasukkan Pasien Ke ruangan?",
         type: "info",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
      },
      function(){
         location.href = '<?php echo base_url("iri/rickwitansi/balikan_keruangan"); ?>/'+no_ipd;
      });
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
			document.getElementById("date_picker_months").value = '<?php echo date('Y-m'); ?>';
			document.getElementById("date_picker_years").value = '<?php echo date('Y'); ?>';
			// document.getElementById("date_picker1").required = true;
			document.getElementById("date_picker2").required = true;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = false;
			// $('#date_picker1').show();
			$('#date_picker_months').hide();
			$('#date_picker2').show();
			$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			// document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '<?php echo date('Y'); ?>';
			// document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			// $('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			// document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '<?php echo date('Y-m'); ?>';
			// document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			// $('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>
<div class="row">
		<div class="col-md-12">
			<div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Medical Record Pasien Rawat Inap</h5></div>
                    <div class="card-block">					
						<form action="<?php echo base_url();?>iri/ricmedrec/" method="post" accept-charset="utf-8">
						<div class="form-group row">
						<div class="col-sm-2">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="TGL">Tanggal</option>
									<option value="BLN">Bulan</option>
									<option value="THN">Tahun</option>
								</select>
								</div>
								<!-- <input type="text" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required> -->
								<!-- <input type="text" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required> -->
								<div class="col-sm-4">
							<!-- 	<input class="form-control input-daterange-datepicker" type="text" name="daterange" value="01/01/2015 - 01/31/2015" /> -->
								<input type="text" id="date_picker2" class="form-control input-daterange-datepicker" name="tgl_akhir" required readonly style="cursor: pointer;">
								<input type="text" id="date_picker_months" class="form-control" value="<?php echo date('Y-m'); ?>" name="bulan">
								<input type="text" id="date_picker_years" class="form-control" value="<?php echo date('Y'); ?>" name="tahun">
								</div>
								<div class="col-sm-3">
								<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
								</div>
						</div>
						</form>					
						<br>
						<?php if ($type == 'TGL') { ?>
						<center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo $date_start.' - '.$date_end;?></b></h4></center>
						<?php } else if ($type == 'BLN') { ?> <center><h4 class="box-title">Daftar Pasien Pulang Bulan <b><?php echo $bulan_show.$tahun_show;?></b></h4></center>
						<?php } else if ($type == 'THN') { ?> <center><h4 class="box-title">Daftar Pasien Pulang Tahun <b><?php echo $tahun_show;?></b></h4></center>
						<?php } else { ?> <center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo date('d F Y', strtotime('-7 days')).' s/d '.date('d F Y');?></b></h4></center>
						<?php } ?>
						<br>
						<div class="table-responsive">
                    	<table id="table-list-medrec" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
						  <thead>
							<tr>
								<th>No. Register</th>
								<th>Nama</th>
								<th>No MedRec</th>
								<th>Ruang</th>
								<!-- th>Usia</th> -->
								<th>JK</th>
							<!-- 	<th>Kls</th> -->
								<th>Tgl Masuk</th>
								<th>Tgl Keluar</th>
								<th>Lama Rawat</th>
							<!-- 	<th>Hari Perawatan</th> -->
								<th>Dokter</th>
						<!-- 		<th>Diagnosa</th>
								<th>Icd</th>
								<th>Berat Bayi</th>
								<th>Jenis Pasien</th>
								<th>Pangkat</th>
								<th>Kesatuan</th>
								<th>Keterangan</th> -->
								<th class="text-center">Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_medrec as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['no_medrec_minto']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		<!-- <td>
						  			<?php
										$interval = date_diff(date_create(), date_create($r['tgl_lahir']));
										echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
									?>
						  		</td> -->
						  		<td><?php echo $r['sex']?></td>
						  		<!-- <td><?php echo $r['klsiri']?></td> -->
						  		<td>
					  			<?php 
						  		$tgl_indo = $controller->obj_tanggal();

						  		$bln_row = $tgl_indo->bulan(substr($r['tgl_masuk'],6,2));
						  		$tgl_row = substr($r['tgl_masuk'],8,2);
						  		$thn_row = substr($r['tgl_masuk'],0,4);

						  		echo $tgl_row." ".$bln_row." ".$thn_row;
						  		?>
						  		</td>
						  		<td>
					  			<?php 
						  		$tgl_indo = $controller->obj_tanggal();

						  		$bln_row = $tgl_indo->bulan(substr($r['tgl_keluar'],6,2));
						  		$tgl_row = substr($r['tgl_keluar'],8,2);
						  		$thn_row = substr($r['tgl_keluar'],0,4);

						  		echo $tgl_row." ".$bln_row." ".$thn_row;
						  		?>
						  		</td>
					  			<td>
					  			<?php
									 $temp_tgl_awal = strtotime($r['tgl_masuk']);
									 $temp_tgl_akhir = strtotime($r['tgl_keluar']);
								     $diff = $temp_tgl_akhir - $temp_tgl_awal;
								     $diff =  floor($diff/(60*60*24));
								     if($diff == 0){
								     	$diff = 1;
								     }
								     echo $diff.' Hari';
								?>
						  		</td>
						  		<!-- <td><?php echo $diff + 1;?></td> -->
						  		<td><?php echo $r['dokter']?></td>
						  <!-- 		<td><?php echo $r['nm_diagnosa'].",".$r['list_diagnosa_tambahan']?></td>
						  		<td><?php echo $r['diagnosa1'] .",".$r['list_id_diagnosa_tambahan']?> </td>
						  		<td><?php echo $r['brtlahir']?></td>
						  		<td><?php echo $r['nmkontraktor']?></td>
						  		<td><?php echo $r['kesatuan']?></td>
						  		<td><?php echo $r['pangkat']?></td>
						  		<td><?php echo $r['jenis_bayar']?></td> -->
						  		<td>
						  		<?php
						  		if(empty($r['diagnosa1']) || $r['diagnosa1'] == ''){ ?>
						  		<a href="<?php echo base_url(); ?>iri/ricmedrec/lengkapi_medrec/<?php echo $r['no_ipd']?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plusthick"></i> Lengkapi Data</button></a>
						  		<?php
						  		} if($r['tgl_keluar']==date('Y-m-d')){?>
									<button type="button" id="submit" onclick="rawat_lagi('<?php echo $r['no_ipd'];?>')" class="btn btn-danger">Kembalikan Keruangan</button>
						  		<?php }
						  		?>

						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>						
						</div> <!-- table-responsive -->
						<br>
						<div class="form-actions text-center">
							<a class="btn waves-effect waves-light btn-primary m-b-10" target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec/');?><?php echo '/'.$tgl.'/'.$type ;?>"><i class="fa fa-print"></i> Cetak Laporan PDF</a>
							<a class="btn waves-effect waves-light btn-primary m-b-10" target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec_excel/');?><?php echo '/'.$tgl.'/'.$type ;?>"><i class="fa fa-file-excel-o"></i> Cetak Laporan Excel</a>
						</div>
	
	</div>
			</div>
		</div>

		</div>	
<script>
	$(document).ready(function() {
		var dataTable = $('#table-list-medrec').DataTable( {
			
		});
		$('#calendar-tgl').datepicker();
	});
</script>

</div>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 
