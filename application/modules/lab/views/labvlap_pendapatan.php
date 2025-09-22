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
    //$('#tindakan').select2();
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
                        <!-- <div class="col-md-3">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)"> -->
                                    <!-- <option value="TGL">Tanggal</option> -->
                                    <!-- <option value="BLN">Bulan</option>
                                    <option value="THN">Tahun</option>
                                </select>
                            </div>
                        </div>											 -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="month" id="date_picker_months" class="form-control" name="date_picker_months" required>
                                    <!-- <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		 -->
                                </div>
                                <!-- <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select id="tindakan" class="form-control select2" style="width: 100%" name="tindakan">
									<option value="">-- Pilih Jenis --</option>	
									<?php 
									foreach($jenis_lab as $row){
										echo '<option value="'.$row->kode_jenis.'">'.$row->nama_jenis.'</option>';
									}
									?>
								</select>
                            </div>
                        </div>
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
					<h4 align="center">Laporan Pendapatan Laboratorium</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Tindakan</th>
                                            <th colspan="3">VIP</th>
                                            <th colspan="3">Kelas 1</th>
                                            <th colspan="3">Kelas 2</th>
                                            <th colspan="3">Kelas 3</th>
                                            <th colspan="3">ICU</th>
                                            <th colspan="3">HCU</th>
                                            <th colspan="3">Rawat Jalan</th>
                                            <th colspan="3">IGD</th>
                                            <th colspan="3">POLI Eksekutif</th>
                                        </tr>
                                        <tr>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
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
	var date1 = document.getElementById('date_picker_months').value;
    var tindakan = document.getElementById('tindakan').value;
    
    window.open('<?php echo site_url('lab/labclaporan/excel_lap_pendapatan');?>/'+date1+'/'+tindakan, '_blank');      
}

function get_bln(){
    var date1 = document.getElementById('date_picker_months').value;
    var tindakan = document.getElementById('tindakan').value;
    // var url = ;
    
    $.ajax({
        url: "<?php echo base_url();?>lab/labclaporan/lap_pendapatan_exe/"+date1+"/"+tindakan,
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
            //let no = 1;
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.jenis_tindakan}</td>
                        <td>${e.jml_vip}</td>
                        <td>${e.tarif_vip}</td>
                        <td>${e.total_vip}</td>
                        <td>${e.jml_1}</td>
                        <td>${e.tarif_1}</td>
                        <td>${e.total_1}</td>
                        <td>${e.jml_2}</td>
                        <td>${e.tarif_2}</td>
                        <td>${e.total_2}</td>
                        <td>${e.jml_3}</td>
                        <td>${e.tarif_3}</td>
                        <td>${e.total_3}</td>
                        <td>${e.jml_icu}</td>
                        <td>${e.tarif_1}</td>
                        <td>${e.total_icu}</td>
                        <td>${e.jml_hcu}</td>
                        <td>${e.tarif_2}</td>
                        <td>${e.total_hcu}</td>
                        <td>${e.jml_rj}</td>
                        <td>${e.tarif_nk}</td>
                        <td>${e.total_rj}</td>
                        <td>${e.jml_rd}</td>
                        <td>${e.tarif_nk}</td>
                        <td>${e.total_rd}</td>
                        <td>${e.jml_eks}</td>
                        <td>${e.tarif_eks}</td>
                        <td>${e.total_eks}</td>
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