<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
    $('#date_picker_days').show();
});

function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
			$('#date_picker_days').show();
		//	$('#date_picker_months').hide();
			$('#date_picker_months').hide();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			$('#date_picker_months').show();
			$('#date_picker_days').hide();
		}
	}
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php //echo form_open('iri/riclaporan/lap_realisasi_tindakan');?>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days1" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div>
                        </div>	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days2" class="form-control" placeholder="Bulan" name="date_picker_days2">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="button" onclick="getRealisasiTindakan()" id="btn-cari">Search</button>
                            </div>
                        </div>
                    </div>
                <?php //echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Realisasi Tindakan</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Kelompok Tindakan</th>
                                        <th rowspan="2">Kategori</th>
                                        <th rowspan="2">Sub Kelompok</th>
                                        <th rowspan="2">Tindakan</th>
                                        <th rowspan="2">Satuan</th>
                                        <th colspan="4">Volume</th>
                                        <th colspan="4">Rupiah Realisasi</th>
                                    </tr> 
                                    <tr>
                                        <th>BPJS</th>
                                        <th>UMUM</th>
                                        <th>IKS PLN</th>
                                        <th>IKS DLL</th>
                                        <th>BPJS</th>
                                        <th>UMUM</th>
                                        <th>IKS PLN</th>
                                        <th>IKS DLL</th>
                                    </tr>                                      
                                </thead>
                                <tbody id="tbodyexample">
                                </tbody>
                            </table>
                        </div>
                    </div><br>
                    <div id="totalUmum"></div>
                    <div id="totalBpjs"></div>
                    <div id="totalIksPln"></div>
                    <div id="totalIks"></div><br>
                    <button class="btn btn-warning" type="button" onclick="excelRealisasiTindakan()"><span><i class= "fa fa-download"></i> Excel</button>
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
<script type="text/javascript">
function getRealisasiTindakan() {
    var startMonth = $("#date_picker_days1").val();
    var endMonth = $("#date_picker_days2").val();
    
    $.ajax({
        url: "<?php echo site_url('iri/riclaporan/getRealisasiTindakan'); ?>",
        beforeSend: function() {
            $('#btn-cari').attr('disabled',true);
            $('#btn-cari').html('Loading....');
        },
        dataType:'json',
        type: "POST",
        data: { 
            startMonth: startMonth, 
            endMonth: endMonth,
        },
        success: function(data) {
            $("#example").dataTable().fnDestroy();
            vtotUmum = 0;
            vtotBpjs = 0;
            vtotIksPln = 0;
            vtotIks = 0;
            $('#example').DataTable( {
                data: data,
                columns: [
                    { data: 'no' },
                    { data: 'kel_tindakan' },
                    { data: 'kategori' },
                    { data: 'sub_kelompok' },
                    { data: 'nmtindakan' },
                    { data: 'satuan'},
                    { data: 'qty_bpjs' },
                    { data: 'qty_umum' },
                    { data: 'qty_iks_pln' },
                    { data: 'qty_iks' },
                    { data: 'vtot_bpjs' },
                    { data: 'vtot_umum' },
                    { data: 'vtot_iks_pln' },
                    { data: 'vtot_iks' }
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;

                    // Loop through the data to sum up "vtot umum"
                    api.rows().every(function () {
                        var rowData = this.data();
                        vtotUmum += parseFloat(rowData.vtotUmum) || 0;
                        vtotBpjs += parseFloat(rowData.vtotBpjs) || 0;
                        vtotIksPln += parseFloat(rowData.vtotIksPln) || 0;
                        vtotIks += parseFloat(rowData.vtotIks) || 0;
                    });

                    // Update the total in your variable or wherever you want
                    $('#totalUmum').html("Total Rupiah Umum : Rp. "+ vtotUmum.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#totalBpjs').html("Total Rupiah BPJS : Rp. "+ vtotBpjs.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#totalIksPln').html("Total Rupiah IKS PLN : Rp. "+ vtotIksPln.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                    $('#totalIks').html("Total Rupiah IKS DLL : Rp. "+ vtotIks.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                }
            });
        },
        complete: function() {
            $('#btn-cari').attr('disabled',false);
            $('#btn-cari').html('Search');
        },  
    })
}

function excelRealisasiTindakan(){
	var date1 = document.getElementById('date_picker_days1').value;
    var date2 = document.getElementById('date_picker_days2').value;
    
    window.open('<?php echo site_url('iri/riclaporan/excel_lap_realisasi_tindakan');?>/'+date1+'/'+date2, '_blank');      
}
</script>
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>