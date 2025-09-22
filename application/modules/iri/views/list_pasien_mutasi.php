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
					<form action="<?php echo base_url();?>iri/ricmedrec/list_pasien_mutasi" method="post" accept-charset="utf-8">
						<div class="form-group row">
							<!-- <div class="col-sm-4">
								<input type="text" id="medrec" class="form-control" name="medrec" placeholder="No Rekam Medis">
							</div> -->
                            <div class="col-sm-2">
								<input type="date" id="medrec" class="form-control" name="tgl_awal">
							</div>
                            <div class="col-sm-2">
                            <input type="date" id="medrec" class="form-control" name="tgl_akhir">
							</div>
							<div class="col-sm-2">
								<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Cari</button>
							</div>
						</div>
						</form>									
						<br>
						 <center><h4 class="box-title">Daftar Pasien Mutasi Tanggal <b><?php echo date('d F Y', strtotime($week_awal)).' s/d '.date('d F Y', strtotime($week_akhir));?></b></h4></center>
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
								<!-- <th>Tgl Keluar</th> -->
								<!-- <th>Lama Rawat</th> -->
								<th>Dokter</th>
								<!-- <th>User</th> -->
						
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_mutasi as $r) { ?>
						  	<tr>
                                <td><button class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal" data-id="<?php echo $r->no_ipd?>"><i class="fa fa-search"></i>Detail</button></td>
						  		<td><?php echo $r->no_ipd?></td>
						  		<td><?php echo $r->nama?></td>
						  		<td><?php echo $r->no_cm?></td>
						  		<td><?php echo $r->nmruang?></td>
						  		<td><?php echo $r->sex?></td>	
						  		<td><?php echo $r->tgl_masuk?></td>
								<td><?php echo $r->dokter?></td>
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
							<a class="btn waves-effect waves-light btn-primary m-b-10" target="_blank" href="<?php echo site_url('iri/riclaporan/excel_list_pasien_pulang/');?><?php echo '/'.$week_awal.'/'.$week_akhir ;?>"><i class="fa fa-file-excel-o"></i> Cetak Laporan Excel</a>
						</div>
	
	</div>
			</div>
		</div>

		</div>	

<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail BHP</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body table-responsive m-t-0">
                    <table id="tableDetail" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th align="center">No Register</th>
                            <th align="center">Nama</th>
                            <th align="center">Ruang</th>
                            <th align="center">Kelas</th>
                            <th align="center">Tgl Masuk</th>
                            <th align="center">Tgl Keluar</th>
                            <th align="center">Status Keluar</th>
                        </tr>
                        </thead>
                        <tbody>
                    </table><br/>
                    <div align="right" id="total_rekap"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
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

        $('#detailModal').on('shown.bs.modal', function(e) {
         //get data-id attribute of the clicked element

            var no_register = $(e.relatedTarget).data('id');
         //tableDetail.clear().draw();
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: {no_register:no_register},
                url: "<?php echo site_url(); ?>iri/ricmedrec/get_detail_mutasi",
                success: function( response ) {
                    tableDetail.clear().draw();
                    tableDetail.rows.add(response.data);
                    tableDetail.columns.adjust().draw();

                    $("#total_rekap").html(response.total);
                }
            });
        });

        tableDetail = $('#tableDetail').DataTable({
            columns: [
                { data: "no_register" },
                { data: "nama" },
                { data: "ruang" },
                { data: "kelas" },
                { data: "tgl_masuk" },
                { data: "tgl_keluar" },
                { data: "status" }
            ],
            columnDefs: [
                { targets: [ 0 ], orderable: false },
                { targets: [ 1 ], orderable: false },
                { targets: [ 2 ], orderable: false },
                { targets: [ 3 ], orderable: false },
                { targets: [ 4 ], orderable: false },
                { targets: [ 5 ], orderable: false },
                { targets: [ 6 ], orderable: false }
            ],
            bFilter: false,
            bPaginate: true,
            destroy: true
        });
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
