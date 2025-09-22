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
	$('#date_picker_months').hide();

    $('#detailModal').on('shown.bs.modal', function(e) {
         //get data-id attribute of the clicked element

        var no_register = $(e.relatedTarget).data('id');
        //tableDetail.clear().draw();
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {no_register:no_register},
            url: "<?php echo site_url(); ?>rad/radclaporan/get_detail_bhp_rad",
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
                { data: "jenis_tindakan" },
                { data: "nama_bhp" },
                { data: "satuan" },
                { data: "kategori" },
                { data: "qty" }
            ],
            columnDefs: [
                { targets: [ 0 ], orderable: false },
                { targets: [ 1 ], orderable: false },
                { targets: [ 2 ], orderable: false },
                { targets: [ 3 ], orderable: false },
                { targets: [ 4 ], orderable: false },
                { targets: [ 5 ], orderable: false }
            ],
            bFilter: false,
            bPaginate: true,
            destroy: true
        });
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
<style>
hr {
	border-color:#7DBE64 !important;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php //echo form_open('rad/Radclaporan/lap_waktu_tunggu_exe');?>
                    
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="tampil" id="tampil" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="TGL">Tanggal</option> 
                                    <option value="BLN">Bulan</option>
                                    <!-- <option value="THN">Tahun</option> -->
                                </select>
                            </div>
                        </div>								
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >
                                    <!-- <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		 -->
                                </div>
                                <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <!-- <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="ppa" id="ppa" class="form-control">
                                    <option value="dpjp">DPJP</option>
                                    <option value="raber">Dokter Bersama</option>
                                    <option value="konsul">Konsultasi</option>
                                </select>
                            </div>
                        </div>	
                        <!--<div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input"> -->
                                    <!-- <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required > -->
                                    <!-- <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		
                                </div> -->
                                <!-- <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            <!-- </div>
                        </div> -->
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" id="btncari" name="btncari" type="button" onclick="get_bln()">Search</button>
                            </div>
                        </div>
                    </div>
                    <?php //echo form_close();?>
					
			</div>			
		</div>						
	</div>
</div>


</section>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Laporan DPJP Utama</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama DPJP</th>
                                            <th rowspan="2">ICU</th>
                                            <th rowspan="2">HCU</th>
                                            <th colspan="2">Neurologi/Limpapeh</th>
                                            <th colspan="3">Anak/Bedah/Panorama</th>
                                            <th colspan="3">Interne</th>
                                            <th colspan="2">Irna B L1,2/Singgalang</th>
                                            <th rowspan="2">Irna B L3/Singgalang</th>
                                            <th rowspan="2">Irna C L1/Merapi</th>
                                            <th rowspan="2">Irna C L2/Merapi</th>
                                            <th rowspan="2">Irna C L3/Merapi</th>
                                            <th rowspan="2">Total</th>
                                        </tr>  
                                        <tr>
                                            <th>I</th>
                                            <th>II</th>
                                            <th>I</th>
                                            <th>II</th>
                                            <th>III</th>
                                            <th>I</th>
                                            <th>II</th>
                                            <th>III</th>
                                            <th>II</th>
                                            <th>VIP</th>
                                        </tr>                                     
                                    </thead>
                                    <tbody id="tbodyexample">
                                    </tbody>
                                </table>
                        </div>
                    </div>			
                    <button type="button" class="btn btn-danger" onClick="down_excel()">Excel</button>				
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
<script>
    
function down_excel(){
    var date = document.getElementById('date_picker_days').value;
    var bln = document.getElementById('date_picker_months').value;
    var ppa = document.getElementById('ppa').value;
    var tampil = document.getElementById('tampil').value;

    if(tampil === 'TGL') {
        var url = "<?php echo base_url();?>iri/riclaporan/excel_lap_dpjp_utama_tgl/"+date+"/"+ppa;
    } else if(tampil === 'BLN') {
        var url = "<?php echo base_url();?>iri/riclaporan/excel_lap_dpjp_utama/"+bln+"/"+ppa;
    }
    
    window.open(url, '_blank');      
}

function get_bln(){
    var date = document.getElementById('date_picker_days').value;
    var bln = document.getElementById('date_picker_months').value;
    var ppa = document.getElementById('ppa').value;
    var tampil = document.getElementById('tampil').value;
   
    if(tampil === 'TGL') {
        var url = "<?php echo base_url();?>iri/riclaporan/lap_dpjp_exe_tgl/"+date+"/"+ppa;
    } else if(tampil === 'BLN') {
        var url = "<?php echo base_url();?>iri/riclaporan/lap_dpjp_exe/"+bln+"/"+ppa;
    }
    
    $.ajax({
        url: url,
        beforeSend: function() {
            $('#btncari').attr('disabled',true);
            $('#btncari').html('Loading....');
        },
        success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
            $('#example').DataTable();
            $('#tbodyexample').html('');
            let html = '';
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.dokter}</td>
                        <td>${e.jml_icu}</td>
                        <td>${e.jml_hcu}</td>
                        <td>${e.jml_neuro_1}</td>
                        <td>${e.jml_neuro_2}</td>
                        <td>${e.jml_anak_bedah_1}</td>
                        <td>${e.jml_anak_bedah_2}</td>
                        <td>${e.jml_anak_bedah_3}</td>
                        <td>${e.jml_interne_1}</td>
                        <td>${e.jml_interne_2}</td>
                        <td>${e.jml_interne_3}</td>
                        <td>${e.jml_irnab_lt12_2}</td>
                        <td>${e.jml_irnab_lt12_vip}</td>
                        <td>${e.jml_irnab_lt3}</td>
                        <td>${e.jml_irnac_lt1}</td>
                        <td>${e.jml_irnac_lt2}</td>
                        <td>${e.jml_irnac_lt3}</td>
                        <td>${e.total}</td>
                    </tr>
                    `;
                });
            $('#tbodyexample').append(html);
            $('#example').DataTable();
            return;
            }
            $('#tbodyexample').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');

        },
        error: function(xhr) { // if error occured
            $('#tbodyexample').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');
            
        },
        complete: function() {
            $('#btncari').attr('disabled',false);
            $('#btncari').html('Cari');
        },
    });
}
</script>
    
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>