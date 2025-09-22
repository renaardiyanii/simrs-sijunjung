<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    // $('.date_day_pickers').datepicker({
    //     format: "yyyy-mm-dd",
    //     autoclose: true,
    //     todayHighlight: true,
    //     minDate: '0'
    // });
    $('#example').DataTable();
    //$('#example_bln').DataTable();
    $('#tbl_bln').show();
    $('#cariLapJmlExpertButtonBln').show();
    $('#date_picker_months').show();
    $('#cariLapJmlExpertButton').hide();
    $('#date_picker_years').hide();
    $('#tbl_thn').hide();
});

function cek_tampil_per(val_tampil_per){
	    if(val_tampil_per=='BLN'){
			//alert("bln");
			$('#date_picker_days').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
            $('#cariLapJmlExpertButtonBln').show();
            $('#cariLapJmlExpertButton').hide();
            $('#tbl_bln').show();
            $('#tbl_thn').hide();
		}else if(val_tampil_per=='THN'){
			$('#tbl_thn').show();
            $('#tbl_bln').hide();
            $('#cariLapJmlExpertButtonBln').hide();
            $('#cariLapJmlExpertButton').show();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
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
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >
                                    <!-- <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		 -->
                                </div>
                                <!-- <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            </div>
                        </div><div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <!-- <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required > -->
                                    <input type="date" id="date_picker_days2" class="form-control" placeholder="Tanggal Awal" name="date_picker_days2" required >		
                                </div>
                                <!-- <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="id_dokter" id="id_dokter" class="form-control">
                                    <option>-- Pilih Dokter --</option>
                                    <option value="semua">SEMUA</option>
                                    <option value="330">dr. Rommy Sp.Rad</option>
                                    <option value="329">dr. Widya Sp.Rad</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="radiografer" id="radiografer" class="form-control">
                                    <option value="">-- Pilih Radiografer --</option>
                                    <option value="semua">SEMUA</option>
                                    <?php
                                    foreach($radiografer as $r) {
                                        echo '<option value="'.$r->userid.'">'.$r->name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="igd" id="igd" class="form-control">
                                    <option>-- Pilih --</option>
                                    <option value="semua">SEMUA</option>
                                    <option value="non_igd">Non IGD</option>
                                    <option value="igd">IGD</option>
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
					<h4 align="center" id="tgl_periksa">Laporan Waktu Tunggu Radiologi</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl Periksa</th>
                                            <th>Nama Pemeriksaan</th>
                                            <th>Modality</th>
                                            <th>Asal</th>
                                            <th>No Register</th>
                                            <th>No MR</th>
                                            <th>Nama</th>
                                            <th>Umur</th>
                                            <th>Kelamin</th>
                                            <th>Jaminan</th>
                                            <th>Alamat</th>
                                            <th>Diagnosa</th>
                                            <th>Radiografer</th>
                                            <th>Dokter Radiologi</th>
                                            <th>Waktu Periksa</th>
                                            <th>Selesai Periksa</th>
                                            <th>Selesai Expertise</th>
                                            <!-- <th>Luar</th> -->
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
	var date1 = document.getElementById('date_picker_days').value;
    var date2 = document.getElementById('date_picker_days2').value;
    var dokter = document.getElementById('id_dokter').value;
    var radiografer = document.getElementById('radiografer').value;
    var igd = document.getElementById('igd').value;
    
    window.open('<?php echo site_url('rad/Radclaporan/excel_lap_waktu_tunggu');?>/'+date1+'/'+date2+'/'+dokter+'/'+radiografer+'/'+igd, '_blank');      
}

function get_bln2(){
    var date1 = document.getElementById('date_picker_days').value;
    var date2 = document.getElementById('date_picker_days2').value;
    var dokter = document.getElementById('id_dokter').value;
    var radiografer = document.getElementById('radiografer').value;
    var igd = document.getElementById('igd').value;
    var url = "<?php echo site_url();?>rad/Radclaporan/lap_waktu_tunggu_exe/"+date1+'/'+date2+'/'+dokter+'/'+radiografer+'/'+igd;
    table = $('#example').DataTable({
        ajax: url,
        columns: [
            { data: "no" },
            { data: "tgl_periksa" },
            { data: "jenis_tindakan" },
            { data: "modality" },
            { data: "no_register" },
            { data: "no_cm" },
            { data: "nama" },
            { data: "umur" },
            { data: "kelamin" },
            { data: "cara_bayar" },
            { data: "alamat" },
            { data: "diagnosa" },
            { data: "radiografer" },
            { data: "nm_dokter" },
            { data: "waktu_periksa" },
            { data: "selesai_periksa" },
            { data: "selesai_expert" }
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
    var date1 = document.getElementById('date_picker_days').value;
    var date2 = document.getElementById('date_picker_days2').value;
    var dokter = document.getElementById('id_dokter').value;
    var radiografer = document.getElementById('radiografer').value;
    var igd = document.getElementById('igd').value;
    
    $.ajax({
        url: "<?php echo base_url();?>rad/radclaporan/lap_waktu_tunggu_exe/"+date1+"/"+date2+"/"+dokter+"/"+radiografer+"/"+igd,
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
                        <td>${e.tgl_periksa}</td>
                        <td>${e.jenis_tindakan}</td>
                        <td>${e.modality}</td>
                        <td>${e.asal}</td>
                        <td>${e.no_register}</td>
                        <td>${e.no_cm}</td>
                        <td>${e.nama}</td>
                        <td>${e.umur}</td>
                        <td>${e.kelamin}</td>
                        <td>${e.cara_bayar}</td>
                        <td>${e.alamat}</td>
                        <td>${e.diagnosa}</td>
                        <td>${e.radiografer}</td>
                        <td>${e.nm_dokter}</td>
                        <td>${e.waktu_periksa}</td>
                        <td>${e.selesai_periksa}</td>
                        <td>${e.selesai_expert}</td>
                    </tr>
                    `;
                });
            $('#tbodyexample').append(html);
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