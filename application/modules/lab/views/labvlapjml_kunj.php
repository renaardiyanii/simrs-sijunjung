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
    $('#tindakan').select2();
    $('#date_days').show();
	$('#date_months').hide();
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
		$('#date_days').show();
		$('#date_months').hide();
	}else if(val_tampil_per=='BLN'){
		$('#date_months').show();
		$('#date_days').hide();
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="TGL">Tanggal</option>
                                    <option value="BLN">Bulan</option>
                                </select>
                            </div>
                        </div>											
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="month" id="date_months" class="form-control" name="date_months">
                                    <input type="date" id="date_days" class="form-control" name="date_days">		
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">
                            <div class="form-group">
                                <select id="tindakan" class="form-control select2" style="width: 100%" name="tindakan">
									<option value="">-- Pilih Tindakan --</option>	
									<?php 
									foreach($tindakan as $row){
										echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.'</option>';
									}
									?>
								</select>
                            </div>
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
					<h4 align="center">Laporan Kunjungan Laboratorium</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">TGL</th>
                                            <th colspan="2">VIP</th>
                                            <th colspan="2">Kelas 1</th>
                                            <th colspan="2">Kelas 2</th>
                                            <th colspan="2">Kelas 3</th>
                                            <th colspan="2">ICU</th>
                                            <th colspan="2">HCU</th>
                                            <th colspan="2">Isolasi</th>
                                            <th colspan="2">Rawat Jalan</th>
                                            <th colspan="2">IGD</th>
                                            <th rowspan="2">POLI Eksekutif</th>
                                            <th rowspan="2">Pasien Luar</th>
                                        </tr>       
                                        <tr>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
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
	var month = document.getElementById('date_months').value;
    var date = document.getElementById('date_days').value;
    var tampil = document.getElementById('tampil_per').value;

    if(tampil === 'TGL') {
        var url = "<?php echo base_url();?>lab/labclaporan/excel_lap_jml_kunj/"+date+"/"+tampil;
    } else {
        var url = "<?php echo base_url();?>lab/labclaporan/excel_lap_jml_kunj/"+month+"/"+tampil;
    }
    
    window.open(url, '_blank');       
}

function get_bln2(){
    var date1 = document.getElementById('date_picker_days').value;
    var date2 = document.getElementById('date_picker_days2').value;
    var url = "<?php echo site_url();?>rad/Radclaporan/lap_bhp_exe/"+date1+'/'+date2;
    table = $('#example').DataTable({
        ajax: url,
        columns: [
            { data: "no" },
            { data: "no_reigister" },
            { data: "nama" },
            { data: "no_medrec" },
            { data: "asal" },
            { data: "kelamin" },
            { data: "jaminan" },
            { data: "umur" },
            { data: "aksi" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
        /*,
        drawCallback: function ( data ) {
                //Make your callback here.
                console.log(data.aoData);
                alert(data);
                return data;
            }*/               
    	});	    
}

function get_bln(){
    var month = document.getElementById('date_months').value;
    var date = document.getElementById('date_days').value;
    var tampil = document.getElementById('tampil_per').value;

    if(tampil === 'TGL') {
        var url = "<?php echo base_url();?>lab/labclaporan/lap_jml_kunjungan_exe/"+date+"/"+tampil;
    } else {
        var url = "<?php echo base_url();?>lab/labclaporan/lap_jml_kunjungan_exe/"+month+"/"+tampil;
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
            let tot_bpjs_vip = 0;
            let tot_umum_vip = 0;
            let tot_bpjs_1 = 0;
            let tot_umum_1 = 0;
            let tot_bpjs_2 = 0;
            let tot_umum_2 = 0;
            let tot_bpjs_3 = 0;
            let tot_umum_3 = 0;
            let tot_bpjs_icu = 0;
            let tot_umum_icu = 0;
            let tot_bpjs_hcu = 0;
            let tot_umum_hcu = 0;
            let tot_bpjs_isolasi = 0;
            let tot_umum_isolasi = 0;
            let tot_bpjs_rj = 0;
            let tot_umum_rj = 0;
            let tot_bpjs_rd = 0;
            let tot_umum_rd = 0;
            let tot_eks = 0;
            let tot_pasien_luar = 0;
            if(data.data.length>0){
                data.data.map((e)=>{
                    console.log(e.jml_bpjs_vip);
                    html+=`
                    <tr>
                        <td>${e.tgl}</td>
                        <td>${e.jml_bpjs_vip}</td>
                        <td>${e.jml_umum_vip}</td>
                        <td>${e.jml_bpjs_1}</td>
                        <td>${e.jml_umum_1}</td>
                        <td>${e.jml_bpjs_2}</td>
                        <td>${e.jml_umum_2}</td>
                        <td>${e.jml_bpjs_3}</td>
                        <td>${e.jml_umum_3}</td>
                        <td>${e.jml_bpjs_icu}</td>
                        <td>${e.jml_umum_icu}</td>
                        <td>${e.jml_bpjs_hcu}</td>
                        <td>${e.jml_umum_hcu}</td>
                        <td>${e.jml_isolasi_bpjs}</td>
                        <td>${e.jml_isolasi_umum}</td>
                        <td>${e.jml_bpjs_rj}</td>
                        <td>${e.jml_umum_rj}</td>
                        <td>${e.jml_bpjs_rd}</td>
                        <td>${e.jml_umum_rd}</td>
                        <td>${e.jml_eks}</td>
                        <td>${e.jml_pasien_luar}</td>
                    </tr>
                    `;

                    tot_bpjs_vip += parseInt(e.jml_bpjs_vip);
                    tot_umum_vip += parseInt(e.jml_umum_vip);
                    tot_bpjs_1 += parseInt(e.jml_bpjs_1);
                    tot_umum_1 += parseInt(e.jml_umum_1);
                    tot_bpjs_2 += parseInt(e.jml_bpjs_2);
                    tot_umum_2 += parseInt(e.jml_umum_2);
                    tot_bpjs_3 += parseInt(e.jml_bpjs_3);
                    tot_umum_3 += parseInt(e.jml_umum_3);
                    tot_bpjs_icu += parseInt(e.jml_bpjs_icu);
                    tot_umum_icu += parseInt(e.jml_umum_icu);
                    tot_bpjs_hcu += parseInt(e.jml_bpjs_hcu);
                    tot_umum_hcu += parseInt(e.jml_umum_hcu);
                    tot_bpjs_isolasi += parseInt(e.jml_isolasi_bpjs);
                    tot_umum_isolasi += parseInt(e.jml_isolasi_umum);
                    tot_bpjs_rj += parseInt(e.jml_bpjs_rj);
                    tot_umum_rj += parseInt(e.jml_umum_rj);
                    tot_bpjs_rd += parseInt(e.jml_bpjs_rd);
                    tot_umum_rd += parseInt(e.jml_umum_rd);
                    tot_eks += parseInt(e.jml_eks);
                    tot_pasien_luar += parseInt(e.jml_pasien_luar);
                });
                html += `
                    <tr>
                        <td>Total</td>
                        <td>${tot_bpjs_vip}</td>
                        <td>${tot_umum_vip}</td>
                        <td>${tot_bpjs_1}</td>
                        <td>${tot_umum_1}</td>
                        <td>${tot_bpjs_2}</td>
                        <td>${tot_umum_2}</td>
                        <td>${tot_bpjs_3}</td>
                        <td>${tot_umum_3}</td>
                        <td>${tot_bpjs_icu}</td>
                        <td>${tot_umum_icu}</td>
                        <td>${tot_bpjs_hcu}</td>
                        <td>${tot_umum_hcu}</td>
                        <td>${tot_bpjs_isolasi}</td>
                        <td>${tot_umum_isolasi}</td>
                        <td>${tot_bpjs_rj}</td>
                        <td>${tot_umum_rj}</td>
                        <td>${tot_bpjs_rd}</td>
                        <td>${tot_umum_rd}</td>
                        <td>${tot_eks}</td>
                        <td>${tot_pasien_luar}</td>
                    </tr>`;
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