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
	 
	
	$('#date_picker_months').datepicker({
		format: "yyyy-mm",
		autoclose: true,
		todayHighlight: true,
		viewMode: "months", 
		minViewMode: "months",
	}); 
	$('#date_picker_years').datepicker({
		format: "yyyy",
		autoclose: true,
		todayHighlight: true,
		format: "yyyy",
		viewMode: "years", 
		minViewMode: "years",
	});
	$('#date_picker2').show();
	$('#date_picker_months').hide();
	$('#date_picker_years').hide();

	
});	


</script>

<div class="row">
		<div class="col-md-12">
			<div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">List Antrian Pasien Punya Bayi</h5></div>
                    <div class="card-block">	
					
					<div class="table-responsive">
                    	<table id="table-list-medrec" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
						  <thead>
							<tr>
								<th class="text-center">Aksi</th>
								<th>No. IPD </th>
								<th>Nama</th>
								<th>No MedRec</th>
                                <th>Tgl Masuk</th>
								<th>Ruang</th>
								
								
						
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($data_pasien_ibu as $r) { ?>
                            <tr>
                                <th class="text-center">
                                <a href="<?php echo site_url("iri/Ricbayi/pendaftaran_bayi/".$r->no_medrec.'/'.$r->noregasal); ?>"
                                class="btn btn-danger btn-xs">Daftar Bayi</a>
                                </th>
								<th><?= $r->no_ipd ?></th>
								<th><?= $r->nama ?></th>
								<th><?= $r->no_medrec ?></th>
                                <th><?= $r->tgl_masuk ?></th>
								<th><?= $r->nm_ruang ?></th>
								
                            </tr>
                            <?php } ?>

							</tbody>
						</table>						
					</div> <!-- table-responsive -->
						
	
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
