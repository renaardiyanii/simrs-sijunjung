<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>

<link href="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Periode Laporan</h4>
            </div>
            <div class="card-block mb-o pb-0">
                <div class="form-body">
                	<div class="form-group row">
						<div class="col-12">
                            <div id="periode" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    							<i class="fa fa-calendar"></i>&nbsp;
							    <span></span> <i class="fa fa-caret-down"></i>
							</div>
							<input type="hidden" id="tgl_awal" name="tgl_awal" value="<?=date('Y-m-d', strtotime('-29 days'))?>">
							<input type="hidden" id="tgl_akhir" name="tgl_akhir" value="<?=date('Y-m-d')?>">
						</div>
					</div>
            	</div>
            </div>
        </div>
    </div>
	<div class="col-12">
	</div>

    <div class="col-lg-12">
        <div class="card">
			<div class="progress">
				<svg class="circular" viewBox="25 25 50 50">
					<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="5" stroke-miterlimit="10" />
				</svg>
			</div>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_rekapan" role="tab">Rekapan</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_konsul" role="tab">Konsul</a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_edukasi" role="tab">Edukasi</a> </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_rekapan" role="tabpanel">
                    <div class="card-block">
                    	<ul class="nav nav-tabs profile-tab" role="tablist">
			                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_status_pasien" role="tab">Status Pasien</a> </li>
			                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_bentuk_makanan" role="tab">Bentuk Makanan</a> </li>
			            </ul>
			            <div class="tab-content">
			                <div class="tab-pane active" id="tab_status_pasien" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('statuspasien'))">
					                            <div class="table-responsive">
													<table id="statuspasien" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="3">No</th>
															  <th rowspan="3">Tanggal</th>
															  <th colspan="3">Pasien Non Covid</th>
															  <th rowspan="3">Total  Non Covid</th>
															  <th colspan="3">Pasien Covid</th>
															  <th rowspan="3">Total Covid</th>
															  <th rowspan="3">Total</th>
															</tr>
															<tr>
															  <th rowspan="2">PC</th>
															  <th colspan="2">BPJS</th>
															  <th rowspan="2">PC</th>
															  <th colspan="2">BPJS</th>
															</tr>
															<tr>
															  <th>Anggota</th>
															  <th>Non Anggota</th>
															  <th>Anggota</th>
															  <th>Non Anggota</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
												            <tr>
												                <th colspan="2" style="text-align:right">Total:</th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												            </tr>
												        </tfoot>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			                <div class="tab-pane" id="tab_bentuk_makanan" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('bentukmakanan'))">
					                            <div class="table-responsive" id="tableDiv">
													<table id="bentukmakanan" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="2">No</th>
															  <th rowspan="2">Tanggal</th>
															  <th rowspan="2">No Register</th>
															  <th colspan="<?=sizeof($bm_header)?>">Bentuk Makanan</th>
															  <th colspan="<?=sizeof($sd_header)?>">Standar Diet</th>
															</tr>
															<tr>
																<?php 
																	foreach ($bm_header as $row) {
																		echo '<th>'.$row->nm_bentuk.'</th>';
																	}
																	foreach ($sd_header as $row) {
																		echo '<th>'.$row->standar.'</th>';
																	}
																?>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			            </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_konsul" role="tabpanel">
                    <div class="card-block">
                    	<ul class="nav nav-tabs profile-tab" role="tablist">
			                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab__konsul_rajal_status_pasien" role="tab">Rajal Status Pasien</a> </li>
			                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab__konsul_rajal_bentuk_makanan" role="tab">Rajal Bentuk Makanan</a> </li>
			                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab__konsul_ranap_status_pasien" role="tab">Ranap Status Pasien</a> </li>
			                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab__konsul_ranap_bentuk_makanan" role="tab">Ranap Bentuk Makanan</a> </li>
			            </ul>
			            <div class="tab-content">
			                <div class="tab-pane active" id="tab__konsul_rajal_status_pasien" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('konrjstatuspasien'))">
					                            <div class="table-responsive">
													<table id="konrjstatuspasien" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="3">No</th>
															  <th rowspan="3">Tanggal</th>
															  <th colspan="3">Pasien Non Covid</th>
															  <th rowspan="3">Total  Non Covid</th>
															  <th colspan="3">Pasien Covid</th>
															  <th rowspan="3">Total Covid</th>
															  <th rowspan="3">Total</th>
															</tr>
															<tr>
															  <th rowspan="2">PC</th>
															  <th colspan="2">BPJS</th>
															  <th rowspan="2">PC</th>
															  <th colspan="2">BPJS</th>
															</tr>
															<tr>
															  <th>Anggota</th>
															  <th>Non Anggota</th>
															  <th>Anggota</th>
															  <th>Non Anggota</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
												            <tr>
												                <th colspan="2" style="text-align:right">Total:</th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												            </tr>
												        </tfoot>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			                <div class="tab-pane" id="tab__konsul_rajal_bentuk_makanan" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('konrjbentukmakanan'))">
					                            <div class="table-responsive" id="tableDiv">
													<table id="konrjbentukmakanan" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="2">No</th>
															  <th rowspan="2">Tanggal</th>
															  <th rowspan="2">No Register</th>
															  <th colspan="<?=sizeof($bm_header)?>">Bentuk Makanan</th>
															  <th colspan="<?=sizeof($sd_header)?>">Standar Diet</th>
															</tr>
															<tr>
																<?php 
																	foreach ($bm_header as $row) {
																		echo '<th>'.$row->nm_bentuk.'</th>';
																	}
																	foreach ($sd_header as $row) {
																		echo '<th>'.$row->standar.'</th>';
																	}
																?>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			                <div class="tab-pane" id="tab__konsul_ranap_status_pasien" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('konristatuspasien'))">
					                            <div class="table-responsive">
													<table id="konristatuspasien" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="3">No</th>
															  <th rowspan="3">Tanggal</th>
															  <th colspan="3">Pasien Non Covid</th>
															  <th rowspan="3">Total  Non Covid</th>
															  <th colspan="3">Pasien Covid</th>
															  <th rowspan="3">Total Covid</th>
															  <th rowspan="3">Total</th>
															</tr>
															<tr>
															  <th rowspan="2">PC</th>
															  <th colspan="2">BPJS</th>
															  <th rowspan="2">PC</th>
															  <th colspan="2">BPJS</th>
															</tr>
															<tr>
															  <th>Anggota</th>
															  <th>Non Anggota</th>
															  <th>Anggota</th>
															  <th>Non Anggota</th>
															</tr>
														</thead>
														<tbody>
														</tbody>
														<tfoot>
												            <tr>
												                <th colspan="2" style="text-align:right">Total:</th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												                <th></th>
												            </tr>
												        </tfoot>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			                <div class="tab-pane" id="tab__konsul_ranap_bentuk_makanan" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('konribentukmakanan'))">
					                            <div class="table-responsive" id="tableDiv">
													<table id="konribentukmakanan" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="2">No</th>
															  <th rowspan="2">Tanggal</th>
															  <th rowspan="2">No Register</th>
															  <th colspan="<?=sizeof($bm_header)?>">Bentuk Makanan</th>
															  <th colspan="<?=sizeof($sd_header)?>">Standar Diet</th>
															</tr>
															<tr>
																<?php 
																	foreach ($bm_header as $row) {
																		echo '<th>'.$row->nm_bentuk.'</th>';
																	}
																	foreach ($sd_header as $row) {
																		echo '<th>'.$row->standar.'</th>';
																	}
																?>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			            </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_edukasi" role="tabpanel">
                    <div class="card-block">
                    	<ul class="nav nav-tabs profile-tab" role="tablist">
			                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab_edukasi_rajal_bentuk_makanan" role="tab">Rajal Bentuk Makanan</a> </li>
			                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab_edukasi_ranap_bentuk_makanan" role="tab">Ranap Bentuk Makanan</a> </li>
			            </ul>
			            <div class="tab-content">
			                <div class="tab-pane active" id="tab_edukasi_rajal_bentuk_makanan" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('edurjbentukmakanan'))">
					                            <div class="table-responsive" id="tableDiv">
													<table id="edurjbentukmakanan" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="2">No</th>
															  <th rowspan="2">Tanggal</th>
															  <th rowspan="2">No Register</th>
															  <th colspan="<?=sizeof($bm_header)?>">Bentuk Makanan</th>
															  <th colspan="<?=sizeof($sd_header)?>">Standar Diet</th>
															</tr>
															<tr>
																<?php 
																	foreach ($bm_header as $row) {
																		echo '<th>'.$row->nm_bentuk.'</th>';
																	}
																	foreach ($sd_header as $row) {
																		echo '<th>'.$row->standar.'</th>';
																	}
																?>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			                <div class="tab-pane" id="tab_edukasi_ranap_bentuk_makanan" role="tabpanel">
			                    <div class="card-block">
			                    	<div class="form-body table-tab">
					                    <div class="row">
					                    	<style>
					                    		.table { border: 1px solid #2980B9; }
												.table thead > tr > th { border-bottom: none; text-align:center; }
												.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td { border: 1px solid #2980B9; text-align:center; }
					                    	</style>
					                        <div class="col-md-12">
					                        	<input type=button class="btn btn-primary" value="Copy to Clipboard" onClick="copytable(document.getElementById('eduribentukmakanan'))">
					                            <div class="table-responsive" id="tableDiv">
													<table id="eduribentukmakanan" class="table table-bordered" width="100%">
														<thead>
															<tr>
															  <th rowspan="2">No</th>
															  <th rowspan="2">Tanggal</th>
															  <th rowspan="2">No Register</th>
															  <th colspan="<?=sizeof($bm_header)?>">Bentuk Makanan</th>
															  <th colspan="<?=sizeof($sd_header)?>">Standar Diet</th>
															</tr>
															<tr>
																<?php 
																	foreach ($bm_header as $row) {
																		echo '<th>'.$row->nm_bentuk.'</th>';
																	}
																	foreach ($sd_header as $row) {
																		echo '<th>'.$row->standar.'</th>';
																	}
																?>
															</tr>
														</thead>
														<tbody>
														</tbody>
													</table>	
												</div>
					                        </div>
					            		</div>
					            	</div>
			                    </div>
			                </div>
			            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
							
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
<script type="text/javascript">
	var statusPasien,bentukMakanan,konRjStatusPasien,konRjBentukMakanan,konRiStatusPasien,konRiBentukMakanan,eduRjBentukMakanan,eduRiBentukMakanan;
	var togglestatusPasien=false;
	var togglebentukMakanan=false;
	var togglekonRjStatusPasien=false;
	var togglekonRjBentukMakanan=false;
	var togglekonRiStatusPasien=false;
	var togglekonRiBentukMakanan=false;
	var toggleeduRjBentukMakanan=false;
	var toggleeduRiBentukMakanan=false;
	$(function() {
	    var start = moment().subtract(29, 'days');
	    var end = moment();

	    function cb(start, end) {
	        $('#periode span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
	    }

	    $('#periode').daterangepicker({
	    	locale: {
		        "format": "DD-MM-YYYY",
		        "separator": " - ",
		        "applyLabel": "Apply",
		        "cancelLabel": "Cancel",
		        "fromLabel": "Dari",
		        "toLabel": "Sampai",
		        "customRangeLabel": "Custom",
		        "weekLabel": "W",
		        "daysOfWeek": [
		            "Mi",
		            "Sen",
		            "Sel",
		            "Ra",
		            "Ka",
		            "Ju",
		            "Sa"
		        ],
		        "monthNames": [
		            "Januari",
		            "Februari",
		            "Maret",
		            "April",
		            "Mei",
		            "Juni",
		            "Juli",
		            "Agustus",
		            "September",
		            "Oktober",
		            "November",
		            "Desember"
		        ],
		        "firstDay": 1
		    },
	        startDate: start,
	        endDate: end,
	        maxDate: end,
	        ranges: {
	           'Today': [moment(), moment()],
	           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
	           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
	           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
	           'This Month': [moment().startOf('month'), moment().endOf('month')],
	           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
	        }
	    }, cb);

	    cb(start, end);

	    $('#periode').on('apply.daterangepicker', function(ev, picker) {
			togglestatusPasien=false;
			togglebentukMakanan=false;
			togglekonRjStatusPasien=false;
			togglekonRjBentukMakanan=false;
			togglekonRiStatusPasien=false;
			togglekonRiBentukMakanan=false;
			toggleeduRjBentukMakanan=false;
			toggleeduRiBentukMakanan=false;
	    	// $(".preloader").show();
			$(".progress").show();
			$(".table-tab").hide();
		  	// console.log(picker.startDate.format('YYYY-MM-DD'));
		  	document.getElementById('tgl_awal').value = picker.startDate.format('YYYY-MM-DD');
		  	// console.log(picker.endDate.format('YYYY-MM-DD'));
		  	document.getElementById('tgl_akhir').value = picker.endDate.format('YYYY-MM-DD');
		  	statusPasien.ajax.reload();
		  	bentukMakanan.ajax.reload();
		  	konRjStatusPasien.ajax.reload();
		  	konRjBentukMakanan.ajax.reload();
		  	konRiStatusPasien.ajax.reload();
		  	konRiBentukMakanan.ajax.reload();
		  	eduRjBentukMakanan.ajax.reload();
		  	eduRiBentukMakanan.ajax.reload();
		});
	});
	$(document).ready(function() {
        $('.selectpicker').selectpicker();
        statusPasien = $('#statuspasien').DataTable({
	  		language: {
            	"processing": "<i class='fa fa-spinner'></i> Loading",
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_status_pasien')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					togglestatusPasien=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	        footerCallback: function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total1 = api
	                .column( 2 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total2 = api
	                .column( 3 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total3 = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total4 = api
	                .column( 5 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total5 = api
	                .column( 6 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total6 = api
	                .column( 7 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total7 = api
	                .column( 8 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total8 = api
	                .column( 9 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total9 = api
	                .column( 10 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	 
	            // Update footer
	            $( api.column( 2 ).footer() ).html(total1);
	            $( api.column( 3 ).footer() ).html(total2);
	            $( api.column( 4 ).footer() ).html(total3);
	            $( api.column( 5 ).footer() ).html(total4);
	            $( api.column( 6 ).footer() ).html(total5);
	            $( api.column( 7 ).footer() ).html(total6);
	            $( api.column( 8 ).footer() ).html(total7);
	            $( api.column( 9 ).footer() ).html(total8);
	            $( api.column( 10 ).footer() ).html(total9);
	        },
	      	columns: [
                // { data: "tgl_order" },
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
                { data: "covid_pc" },
	            { data: "covid_bpjs_anggota" },
                { data: "covid_bpjs_non" },
                { data: "covid_total" },
	            { data: "non_covid_pc" },
                { data: "non_covid_bpjs_anggota" },
                { data: "non_covid_bpjs_non" },
                { data: "non_covid_total" },
                { data: "total" },
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },{
				    "targets": 10,
				    "data": "total",
				    "render": function ( data, type, row, meta ) {
				      return '<b><i>'+data+'</i></b>';
				    }
				} ,
			],
	        order: [[ 0, 'asc' ]],
    	});
    	statusPasien.on( 'order.dt search.dt', function () {
            statusPasien.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        bentukMakanan = $('#bentukmakanan').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_bentuk_makanan')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					togglebentukMakanan=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	      	columns: [
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
            	{ data: "no_ipd" },
				<?php 
					foreach ($bm_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->kode)))).'" },';
					}
				?>
				<?php 
					foreach ($sd_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->standar)))).'" },';
					}
				?>
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },
			],
	        order: [[ 0, 'asc' ]],
    	});
    	bentukMakanan.on( 'order.dt search.dt', function () {
            bentukMakanan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        konRjStatusPasien = $('#konrjstatuspasien').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_kon_rj_status_pasien')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					togglekonRjStatusPasien=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	        footerCallback: function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total1 = api
	                .column( 2 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total2 = api
	                .column( 3 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total3 = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total4 = api
	                .column( 5 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total5 = api
	                .column( 6 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total6 = api
	                .column( 7 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total7 = api
	                .column( 8 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total8 = api
	                .column( 9 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total9 = api
	                .column( 10 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	 
	            // Update footer
	            $( api.column( 2 ).footer() ).html(total1);
	            $( api.column( 3 ).footer() ).html(total2);
	            $( api.column( 4 ).footer() ).html(total3);
	            $( api.column( 5 ).footer() ).html(total4);
	            $( api.column( 6 ).footer() ).html(total5);
	            $( api.column( 7 ).footer() ).html(total6);
	            $( api.column( 8 ).footer() ).html(total7);
	            $( api.column( 9 ).footer() ).html(total8);
	            $( api.column( 10 ).footer() ).html(total9);
	        },
	      	columns: [
                // { data: "tgl_order" },
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
                { data: "covid_pc" },
	            { data: "covid_bpjs_anggota" },
                { data: "covid_bpjs_non" },
                { data: "covid_total" },
	            { data: "non_covid_pc" },
                { data: "non_covid_bpjs_anggota" },
                { data: "non_covid_bpjs_non" },
                { data: "non_covid_total" },
                { data: "total" },
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },{
				    "targets": 10,
				    "data": "total",
				    "render": function ( data, type, row, meta ) {
				      return '<b><i>'+data+'</i></b>';
				    }
				} ,
			],
	        order: [[ 0, 'asc' ]],
    	});
    	konRjStatusPasien.on( 'order.dt search.dt', function () {
            konRjStatusPasien.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        konRjBentukMakanan = $('#konrjbentukmakanan').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_kon_rj_bentuk_makanan')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					togglekonRjBentukMakanan=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	      	columns: [
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
            	{ data: "no_ipd" },
				<?php 
					foreach ($bm_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->kode)))).'" },';
					}
				?>
				<?php 
					foreach ($sd_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->standar)))).'" },';
					}
				?>
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },
			],
	        order: [[ 0, 'asc' ]],
    	});
    	konRjBentukMakanan.on( 'order.dt search.dt', function () {
            konRjBentukMakanan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        konRiStatusPasien = $('#konristatuspasien').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_kon_ri_status_pasien')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					togglekonRiStatusPasien=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	        footerCallback: function ( row, data, start, end, display ) {
	            var api = this.api(), data;
	 
	            // Remove the formatting to get integer data for summation
	            var intVal = function ( i ) {
	                return typeof i === 'string' ?
	                    i.replace(/[\$,]/g, '')*1 :
	                    typeof i === 'number' ?
	                        i : 0;
	            };
	 
	            // Total over all pages
	            total1 = api
	                .column( 2 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total2 = api
	                .column( 3 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total3 = api
	                .column( 4 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total4 = api
	                .column( 5 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total5 = api
	                .column( 6 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total6 = api
	                .column( 7 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total7 = api
	                .column( 8 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total8 = api
	                .column( 9 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	            total9 = api
	                .column( 10 )
	                .data()
	                .reduce( function (a, b) {
	                    return intVal(a) + intVal(b);
	                }, 0 );
	 
	 
	            // Update footer
	            $( api.column( 2 ).footer() ).html(total1);
	            $( api.column( 3 ).footer() ).html(total2);
	            $( api.column( 4 ).footer() ).html(total3);
	            $( api.column( 5 ).footer() ).html(total4);
	            $( api.column( 6 ).footer() ).html(total5);
	            $( api.column( 7 ).footer() ).html(total6);
	            $( api.column( 8 ).footer() ).html(total7);
	            $( api.column( 9 ).footer() ).html(total8);
	            $( api.column( 10 ).footer() ).html(total9);
	        },
	      	columns: [
                // { data: "tgl_order" },
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
                { data: "covid_pc" },
	            { data: "covid_bpjs_anggota" },
                { data: "covid_bpjs_non" },
                { data: "covid_total" },
	            { data: "non_covid_pc" },
                { data: "non_covid_bpjs_anggota" },
                { data: "non_covid_bpjs_non" },
                { data: "non_covid_total" },
                { data: "total" },
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },{
				    "targets": 10,
				    "data": "total",
				    "render": function ( data, type, row, meta ) {
				      return '<b><i>'+data+'</i></b>';
				    }
				} ,
			],
	        order: [[ 0, 'asc' ]],
    	});
    	konRiStatusPasien.on( 'order.dt search.dt', function () {
            konRiStatusPasien.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        konRiBentukMakanan = $('#konribentukmakanan').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_kon_ri_bentuk_makanan')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					togglekonRiBentukMakanan=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	      	columns: [
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
            	{ data: "no_ipd" },
				<?php 
					foreach ($bm_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->kode)))).'" },';
					}
				?>
				<?php 
					foreach ($sd_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->standar)))).'" },';
					}
				?>
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },
			],
	        order: [[ 0, 'asc' ]],
    	});
    	konRiBentukMakanan.on( 'order.dt search.dt', function () {
            konRiBentukMakanan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        eduRjBentukMakanan = $('#edurjbentukmakanan').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_edu_rj_bentuk_makanan')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					toggleeduRjBentukMakanan=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	      	columns: [
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
            	{ data: "no_ipd" },
				<?php 
					foreach ($bm_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->kode)))).'" },';
					}
				?>
				<?php 
					foreach ($sd_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->standar)))).'" },';
					}
				?>
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },
			],
	        order: [[ 0, 'asc' ]],
    	});
    	eduRjBentukMakanan.on( 'order.dt search.dt', function () {
            eduRjBentukMakanan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();

        eduRiBentukMakanan = $('#eduribentukmakanan').DataTable({
	  		language: {
	     		"emptyTable": "Data tidak tersedia."
	    	},
			dom: 'ftri',
	      	ajax: {
		        "url": '<?php echo site_url('gizi/rekap_edu_ri_bentuk_makanan')?>',
		        "type": 'POST',
		        "data": function ( d ) {
		          	return {
		          		tgl_awal:$('#tgl_awal').val(),
		          		tgl_akhir:$('#tgl_akhir').val(),
		          	};
		        },
		        "dataSrc": function (json) {
					toggleeduRiBentukMakanan=true;
					cekPreload();
					// Swal.close();
					return json.data;
				}
	      	},
            displayLength: -1,
	      	columns: [
            	{ data: "rank" },
            	{
				    data: 'tgl',
				    render: function ( data, type, row ) {
				        var dateSplit = data.split('-');
				        return type === "display" || type === "filter" ?
				            dateSplit[2] +'-'+ dateSplit[1] +'-'+ dateSplit[0] :
				            data;
				    }
				},
            	{ data: "no_ipd" },
				<?php 
					foreach ($bm_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->kode)))).'" },';
					}
				?>
				<?php 
					foreach ($sd_header as $row) {
						echo '{ data: "'.strtolower(str_replace("/","_",str_replace(".","_",str_replace(" ","_",$row->standar)))).'" },';
					}
				?>
	        ],
	        columnDefs: [ 
	        	{
		            "searchable": false,
		            "orderable": false,
		            "targets": 0
		        },
			],
	        order: [[ 0, 'asc' ]],
    	});
    	eduRiBentukMakanan.on( 'order.dt search.dt', function () {
            eduRiBentukMakanan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
	});

	function copytable(el) {
		var body = document.body, range, sel;
	    if (document.createRange && window.getSelection) {
	        range = document.createRange();
	        sel = window.getSelection();
	        sel.removeAllRanges();
	        try {
	            range.selectNodeContents(el);
	            sel.addRange(range);
	        } catch (e) {
	            range.selectNode(el);
	            sel.addRange(range);
	        }
	    } else if (body.createTextRange) {
	        range = body.createTextRange();
	        range.moveToElementText(el);
	        range.select();
	    }
        document.execCommand("copy");
	}

	function cekPreload(){
		if(togglestatusPasien && togglebentukMakanan && togglekonRjStatusPasien && togglekonRjBentukMakanan && togglekonRiStatusPasien && togglekonRiBentukMakanan && toggleeduRjBentukMakanan && toggleeduRiBentukMakanan){
			// $(".preloader").hide();
			$(".progress").hide();
			$(".table-tab").show();
		}
	}


</script>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>