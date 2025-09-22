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
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="carabayar" id="carabayar" class="form-control">
                                    <option>-- Pilih Cara Bayar --</option>
                                    <option value="semua">SEMUA</option>
                                    <option value="TUNAI">TUNAI</option>
                                    <option value="BANK">BANK</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <select name="user_kasir" id="user_kasir" class="form-control">
                                    <option value="">-- Pilih User Kasir --</option>
                                    <option value="semua">SEMUA</option>
                                    <?php
                                    foreach($user_kasir as $r) {
                                        echo '<option value="'.$r->username.'">'.$r->name.'</option>';
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
					<h4 align="center" id="tgl_periksa">Laporan Penerimaan Per Kasir Per Kwitansi</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Kwitansi</th>
                                            <th>Asal</th>
                                            <th>Jam</th>
                                            <th>No Register</th>
                                            <th>No MR</th>
                                            <th>Nama</th>
                                            <th>Jaminan</th>
                                            <th>Status</th>
                                            <th>Jenis Bayar</th>
                                            <th>Tindakan</th>
                                            <!-- <th>Jaminan</th>
                                            <th>Alamat</th>
                                            <th>Diagnosa</th>
                                            <th>Radiografer</th>
                                            <th>Dokter Radiologi</th>
                                            <th>Waktu Periksa</th>
                                            <th>Selesai Periksa</th>
                                            <th>Selesai Expertise</th> -->
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
    // var date2 = document.getElementById('date_picker_days2').value;
    var user = document.getElementById('user_kasir').value;
    var carabayar = document.getElementById('carabayar').value;
    
    window.open('<?php echo site_url('umc/cumcicilan/excel_lap_penerimaan_perkasir');?>/'+date1+'/'+user+'/'+carabayar, '_blank');      
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

$.fn.dataTable.pipeline = function (opts) {
    // Configuration options
    var conf = $.extend(
        {
            pages: 5, // number of pages to cache
            url: '', // script url
            data: null, // function or object with parameters to send to the server
            // matching how `ajax.data` works in DataTables
            method: 'GET', // Ajax HTTP method
        },
        opts
    );
 
    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;
 
    return function (request, drawCallback, settings) {
        var ajax = false;
        var requestStart = request.start;
        var drawStart = request.start;
        var requestLength = request.length;
        var requestEnd = requestStart + requestLength;
 
        if (settings.clearCache) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        } else if (cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper) {
            // outside cached data - need to make a request
            ajax = true;
        } else if (
            JSON.stringify(request.order) !== JSON.stringify(cacheLastRequest.order) ||
            JSON.stringify(request.columns) !== JSON.stringify(cacheLastRequest.columns) ||
            JSON.stringify(request.search) !== JSON.stringify(cacheLastRequest.search)
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
 
        // Store the request for checking next time around
        cacheLastRequest = $.extend(true, {}, request);
 
        if (ajax) {
            // Need data from the server
            if (requestStart < cacheLower) {
                requestStart = requestStart - requestLength * (conf.pages - 1);
 
                if (requestStart < 0) {
                    requestStart = 0;
                }
            }
 
            cacheLower = requestStart;
            cacheUpper = requestStart + requestLength * conf.pages;
 
            request.start = requestStart;
            request.length = requestLength * conf.pages;
 
            // Provide the same `data` options as DataTables.
            if (typeof conf.data === 'function') {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data(request);
                if (d) {
                    $.extend(request, d);
                }
            } else if ($.isPlainObject(conf.data)) {
                // As an object, the data given extends the default
                $.extend(request, conf.data);
            }
 
            return $.ajax({
                type: conf.method,
                url: conf.url,
                data: request,
                dataType: 'json',
                cache: false,
                success: function (json) {
                    cacheLastJson = $.extend(true, {}, json);
 
                    if (cacheLower != drawStart) {
                        json.data.splice(0, drawStart - cacheLower);
                    }
                    if (requestLength >= -1) {
                        json.data.splice(requestLength, json.data.length);
                    }
 
                    drawCallback(json);
                },
            });
        } else {
            json = $.extend(true, {}, cacheLastJson);
            json.draw = request.draw; // Update the echo for each response
            json.data.splice(0, requestStart - cacheLower);
            json.data.splice(requestLength, json.data.length);
 
            drawCallback(json);
        }
    };
};

$.fn.dataTable.Api.register('clearPipeline()', function () {
    return this.iterator('table', function (settings) {
        settings.clearCache = true;
    });
});

function get_bln(){
    var date1 = document.getElementById('date_picker_days').value;
    // var date2 = document.getElementById('date_picker_days2').value;
    var user = document.getElementById('user_kasir').value;
    var carabayar = document.getElementById('carabayar').value;
    //var igd = document.getElementById('igd').value;
    
    $.ajax({
        url: "<?php echo base_url();?>umc/cumcicilan/lap_penerimaan_perkasir_exe/"+date1+"/"+user+"/"+carabayar,
        beforeSend: function() {
            $('#btncari').attr('disabled',true);
            $('#btncari').html('Loading....');
        },
        success: function(data) {
            // console.log(data);
            $(document).ready(function() {
                $('#example').DataTable();
            });
            data = JSON.parse(data);
            $('#example').DataTable();
            $('#tbodyexample').html('');
            let html = '';
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.no_kwitansi}</td>
                        <td>${e.asal}</td>
                        <td>${e.jam}</td>
                        <td>${e.no_register}</td>
                        <td>${e.no_cm}</td>
                        <td>${e.nama}</td>
                        <td>${e.cara_bayar}</td>
                        <td>${e.status}</td>
                        <td>${e.jenis_bayar}</td>
                        <td>${e.tindakan}</td>
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