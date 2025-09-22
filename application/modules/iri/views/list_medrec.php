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

	$('#tanggal_laporan').daterangepicker({
			autoUpdateInput: false,
			dateFormat:'YYYY-MM-DD',
			Format:'YYYY-MM-DD',
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('#tanggal_laporan').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
		});

		$('#tanggal_laporan').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});

		
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

	$('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>iri/Ricmedrec/save_tidak_lengkap",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'simpan';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            if (data = true) {        
              swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								});
            } else {
              swal("Error","Data gagal disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'simpan';
            $('#editModal').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

	
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

	function tidak_lengkap(noreg) {
    // $.ajax({
    //   type:'POST',
    //   dataType: 'json',
    //   url:"<?php //echo base_url('master/mcdiagnosa/get_data_edit_diagnosa')?>",
    //   data: {
    //     id: id
    //   },
    //   success: function(data){
        $('#noregg').val(noreg);
		console.log(noreg)
    //     $('#edit_iddiagnosa').val(data[0].id_icd);
    //     $('#edit_nmdiagnosaeng').val(data[0].nm_diagnosa);
    //     $('#edit_nmdiagnosaind').val(data[0].diagnosa_indonesia);
    //     //swal("Sukses!", "Data berhasil di edit.", "success");
    //   },
    //   error: function(){
    //     alert("error");
    //   }
    // });
  }

  function cek_search_per(val_search_per){
	if(val_search_per=='cm'){
		$("#medrec").css("display", ""); // To unhide
		$("#tanggal_laporan").css("display", "none"); 
	}
	else if(val_search_per=='tgl'){
		$("#medrec").css("display", "none");
		$("#tanggal_laporan").css("display", ""); 
	} 
	else {
		$("#medrec").css("display", "none");
		$("#tanggal_laporan").css("display", "none"); 
	}
}

</script>

<div class="row">
		<div class="col-md-12">
			<div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Medical Record Pasien Rawat Inap</h5></div>
                    <div class="card-block">	
					<form action="<?php echo base_url();?>iri/ricmedrec/by_medrec" method="post" accept-charset="utf-8">
						<div class="form-group row">
							<div class="form-inline">
								<select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
									<option value="cm">No MR</option>
									<option value="tgl">Tanggal</option>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="text"  id="medrec" class="form-control" name="medrec" placeholder="No Medrec">
									<input type="text" class="form-control" id="tanggal_laporan" name="tanggal_laporan" autocomplete="off" style="display:none" placeholder="Pilih Tanggal">
							</div>
							<div class="col-sm-3">
								<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
							</div>
						</div>
						</form>									
						<br>
						<?php if ($type == 'TGL') { ?>x
						<center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo $date_start.' - '.$date_end;?></b></h4></center>
						<?php } else if ($type == 'BLN') { ?> <center><h4 class="box-title">Daftar Pasien Pulang Bulan <b><?php echo $bulan_show.$tahun_show;?></b></h4></center>
						<?php } else if ($type == 'THN') { ?> <center><h4 class="box-title">Daftar Pasien Pulang Tahun <b><?php echo $tahun_show;?></b></h4></center>
						<?php } else { ?> <center><h4 class="box-title">Daftar Pasien Pulang Tanggal <b><?php echo date('d F Y', strtotime('-14 days')).' s/d '.date('d F Y');?></b></h4></center>
						<?php } ?>
						<br>
						
						<div class="table-responsive">
                    	<table id="table-list-medrec" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
						  <thead>
							<tr>
								<th class="text-center">Aksi</th>
								<th>No. Register</th>
								<th>Nama</th>
								<th>No MedRec</th>
								<th>Ruang</th>
								<th>JK</th>
								<th>Tgl Masuk</th>
								<th>Tgl Keluar</th>
								<th>Lama Rawat</th>
								<th>Dokter</th>
								<!-- <th>Verifikator</th>
								<th>User</th> -->
						
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_medrec as $r) { ?>
						  	<tr>
								<td>
								<a href="<?php echo base_url(); ?>iri/rictindakan/index/<?php echo $r['no_ipd']  ?>/<?= $userid ?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plusthick"></i>Lengkapi Data</button></a>
									<a href="<?php echo base_url(); ?>iri/ricstatus/index/<?php echo $r['no_ipd'] ?>"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-plusthick"></i> Status</button></a>
								
									
									
								<?php if($r['tgl_keluar']==date('Y-m-d')){?>
										<button type="button" id="submit" onclick="rawat_lagi('<?php echo $r['no_ipd'];?>')" class="btn btn-danger">Kembalikan Keruangan</button>
						  		<?php } ?>
								
						  		</td>
						  		<td><?php echo $r['no_ipd']?></td>
						  		<td><?php echo $r['nama']?></td>
						  		<td><?php echo $r['no_medrec_minto']?></td>
						  		<td><?php echo $r['nmruang']?></td>
						  		
						  		<td><?php echo $r['sex']?></td>
						  		
						  		<td>
									<?php 
									// $tgl_indo = $controller->obj_tanggal();

									$bln_row = $controller->bulan(substr($r['tgl_masuk'],6,2));
									$tgl_row = substr($r['tgl_masuk'],8,2);
									$thn_row = substr($r['tgl_masuk'],0,4);

									//echo $tgl_row." ".$bln_row." ".$thn_row;
									echo date('d-m-Y',strtotime($r['tgl_masuk']));
									?>
						  		</td>
						  		<td>
									<?php 
									// $tgl_indo = $controller->obj_tanggal();

									$bln_row = $controller->bulan(substr($r['tgl_keluar'],6,2));
									$tgl_row = substr($r['tgl_keluar'],8,2);
									$thn_row = substr($r['tgl_keluar'],0,4);

									//echo $tgl_row." ".$bln_row." ".$thn_row;
									echo date('d-m-Y',strtotime($r['tgl_keluar']));
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
						  		
						  		<td><?php echo $r['dokter']?></td>
								<!-- <td><?php //echo $r['verifikator']?></td> -->
								<!-- <td><?php// echo $r['xuser']?></td> -->
						  
						  	
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>						
						</div> <!-- table-responsive -->
						<br>
						<div class="form-actions text-left">
							<!-- <a class="btn waves-effect waves-light btn-primary m-b-10" target="_blank" href="<?php echo site_url('iri/riclaporan/cetak_medrec/');?><?php// echo '/'.$tgl.'/'.$type ;?>"><i class="fa fa-print"></i> Cetak Laporan PDF</a> -->
							<!-- <a class="btn waves-effect waves-light btn-primary m-b-10" target="_blank" href="<?php echo site_url('iri/riclaporan/excel_list_pasien_pulang/');?><?php echo '/'.$week_awal.'/'.$week_akhir ;?>"><i class="fa fa-file-excel-o"></i> Cetak Laporan Excel</a> -->
						</div>

		  <form method="POST" id="edit_form" class="form-horizontal"> 
          <!-- Modal Edit Obat -->
				<div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
					<div class="modal-dialog modal-success">

					<!-- Modal content-->
					<div class="modal-content">
						<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Keterangan Tidak Lengkap</h4>
						</div>
						
						<div class="modal-body">
							<div class="form-group row">
								<div class="col-sm-1"></div>
								<p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">keterangan</p>
								<div class="col-sm-8">
									<textarea class="form-control" id="textAreaExample1" rows="4" name="ket"></textarea>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						<input type="hidden" class="form-control" name="noregg" id="noregg">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button class="btn btn-primary" type="submit" id="btn-edit">simpan</button>
						</div>
					</div>
					</div>
				</div>
          </form>
	
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
