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
        format: "MM yyyy",
        viewMode: "months", 
        minViewMode: "months",
        orientation: "bottom",
    });
   
    $('#startMonth').datepicker().on("changeMonth", function(e) {
        var date = new Date(e.date);
        var stringDate = date.toLocaleDateString("id");
        console.log(date.getMonth());
        yr      = date.getFullYear(),
        month   = date.getMonth() < 10 ? parseInt(date.getMonth()) +1 : parseInt(date.getMonth())+1,
        month = month < 10 ? '0' + month : month,
        day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate(),
        newDate = yr + '-' + month + '-' + day;
        console.log(newDate);
        $('#startMonthHidden').val(newDate);
        console.log($('#startMonthHidden').val());
    });
    $('#endMonth').datepicker({
        format: "M yyyy",
        viewMode: "months", 
        minViewMode: "months",
        orientation: "bottom",
        autoClose: true,
    }).on("changeMonth", function(e){
        
        var date = new Date(e.date);
        var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
        var stringDate = lastDay.toLocaleDateString("id");
        console.log(stringDate);
        yr      = lastDay.getFullYear(),
        month   = lastDay.getMonth() < 10 ? parseInt(lastDay.getMonth()) +1 : parseInt(lastDay.getMonth())+1,
        month = month < 10 ? '0' + month : month,
        day     = lastDay.getDate()  < 10 ? '0' + lastDay.getDate()  : lastDay.getDate(),
        newDate = yr + '-' + month + '-' + day;
        $('#endMonthHidden').val(newDate);
        console.log($('#endMonthHidden').val());
    });
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
                            <label class="form-label">Periode Awal</label>
                            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
                                <input  class="form-control " id="startMonth" name="startMonth" placeholder="Start Period" autocomplete="off" />
                                <input  class="form-control " id="startMonthHidden" name="startMonthHidden" placeholder="Start Period" autocomplete="off" hidden/>
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
                            <label class="form-label">Periode Akhir</label>
                            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
				                <!-- <input type="text" class="form-control pull-right" id="tgl" name="tgl" placeholder="Pilih Tanggal"> -->
                                <input  class="form-control " id="endMonth" name="endMonth" placeholder="End Period" autocomplete="off"/>
                                <input  class="form-control " id="endMonthHidden" name="endMonthHidden" placeholder="End Period" autocomplete="off" hidden/>
				            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"></label>
                            <div class="form-actions">
                                <button class="btn btn-primary" type="button" onClick="getLaporanTxtRawatJalan()"><span><i class= "fa fa-search"></i> Search</span></button>
                                <button class="btn btn-warning" type="button" onClick="downloadTxtRajalExcel()"><span><i class= "fa fa-download"></i> Excel</button>
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
                                            <th>Tarif RS Total</th>
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

<script type="text/javascript">
function getLaporanTxtRawatJalan(){
    // var startMonthString = $("#startMonth").val();
    // var endMonthString = $("#startMonth").val();
    var startMonth = $("#startMonthHidden").val();
    var endMonth = $("#endMonthHidden").val();
    $.ajax({
        url: "<?php echo site_url('laporan/claporantxtbpjs/getLaporanTxtRawatJalan'); ?>",
        dataType:'json',
        type: "POST",
        data: { 
            startMonth: startMonth, 
            endMonth: endMonth,
        },
        success: function(data) {
            console.log(data);
            $("#example").dataTable().fnDestroy();
            $('#example').DataTable( {
                data: data,
                columns: [
                    { data: 'kelompokPenagihan' },
                    { data: 'tanggalPelayanan' },
                    { data: 'kelas' },
                    { data: 'poliklinik' },
                    { data: 'noSep' },
                    { data: 'namaPasien'},
                    { data: 'diagnosa' },
                    { data: 'kodeCBG' },
                    { data: 'deskripsiCBG' },
                    { data: 'namaDokter' },
                    { data: 'spesialistik' },
                    { data: 'tarifInaCbg' },
                    { data: 'tarifTotal' }
                ]
            } );
        }

    })
}

function downloadTxtRajalExcel(){
        var startMonth = $("#startMonthHidden").val();
        var endMonth = $("#endMonthHidden").val();
        var startMonthString = $("#startMonth").val();
        var endMonthString = $("#endMonth").val();
        $.ajax({
            url: "<?php echo site_url('laporan/claporantxtbpjs/laporanTxtRawatJalanDownload'); ?>",
            dataType:'json',
            type: "POST",
            data: { 
                startMonth: startMonth,
                endMonth: endMonth,
                startMonthString: startMonthString,
                endMonthString: endMonthString
            },
            success: function(data) {
                console.log(data);
            }
        }).done(function(data){
            console.log("success");
            console.log(data);
            var $a = $("<a>");
            $a.attr("href",data.file);
            $("body").append($a);
            $a.attr("download",data.fileName);
            $a[0].click();
            $a.remove();
        });
    }
</script>

<?php
   if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>