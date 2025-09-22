<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script>
$(document).ready(function() {
    $('#example').DataTable();
    $('#startMonth').datepicker({
        format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months"
    });
    // $('#date_picker_days').show();

    // $('#tgl').daterangepicker({
    //   	opens: 'left',
	// 	format: 'YYYY-MM-DD',
	// });
    // $('#penjamin').select2();
    // $('#penjamin').multiselect({
    //     // enableFiltering: true,
    //     includeSelectAllOption: true,
    //     // buttonClass: 'form-control',
    // });
});
</script>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <!-- <?php echo form_open('laporan/doclaporan');?> -->
                    <div class="row p-t-0">
                        <div class="col-md-3">
                            <!-- <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div> -->
                            <label class="form-label"> Periode</label>
                            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
				                <!-- <input type="text" class="form-control pull-right" id="tgl" name="tgl" placeholder="Pilih Tanggal"> -->
                                <input  class="form-control " id="startMonth" name="startMonth" placeholder="Bulan Awal" />
				            </div>
                        </div>   
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days2">	
                                </div>
                            </div>
                        </div> -->
                        <div class="col-md-3">
                            <label class="form-label"></label>
                            <div class="form-actions">
                                <button class="btn btn-primary" type="button" onClick=""><span><i class= "fa fa-search"></i> Search</span></button>
                                <button class="btn btn-warning" type="button" onClick=""><span><i class= "fa fa-download"></i> Excel</button>
                            </div>
                        </div>
                    </div>
			</div>			
		</div>						
	</div>
</div>


<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Laporan BPJS Rawat Jalan</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kelompok Penagihan</th>
                                            <th>Tanggal Pelayanan</th>
                                            <th>Kelas</th>
                                            <th>Ruang Poli (Terakhir)</th>
                                            <th>SEP</th>
                                            <th>Nama Pasien</th>
                                            <th>Diagnosa</th>
                                            <th>Kode INA-CBG</th>
                                            <th>Deskripsi INA-CBG</th>
                                            <th>Nama DPJP</th>
                                            <th>Spesialistik</th>
                                            <th>Tarif INA-CBG</th>
                                        </tr>                         
                                    </thead>
                                    <tbody>
                                        
                             
                                    <tbody>
                                </table>
                        </div>
                    </div>
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->

<?php
   if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>