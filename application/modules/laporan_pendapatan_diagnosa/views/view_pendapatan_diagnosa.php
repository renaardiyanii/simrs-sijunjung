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
    // $('#date_picker_days').show();

    // $('#tgl').daterangepicker({
    //   	opens: 'left',
	// 	format: 'YYYY-MM-DD',
	// });
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
    // $('#penjamin').select2();
    // $('#penjamin').multiselect({
    //     // enableFiltering: true,
    //     includeSelectAllOption: true,
    //     // buttonClass: 'form-control',
    // });
});

$(document).on("keypress",".select2-input",function(event){
    if (event.ctrlKey || event.metaKey) {
        var id =$(this).parents("div[class*='select2-container']").attr("id").replace("s2id_","");
        var element =$("#"+id);
        if (event.which == 97){
            var selected = [];
            $('.select2-drop-active').find("ul.select2-results li").each(function(i,e){
                selected.push($(e).data("select2-data"));
            });
            element.select2("data", selected);
        } else if (event.which == 100){
            element.select2("data", []);
        }
    }
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
                <!-- <?php echo form_open('laporan/claporandiagnosa');?> -->
                    <div class="row p-t-0">
                        
                        <div class="col-md-3">
                            <!-- <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div> -->
                            <label class="form-label"> Periode Awal</label>
                            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
				                <input  class="form-control " id="startMonth" name="startMonth" placeholder="Start Period" autocomplete="off" />
                                <input  class="form-control " id="startMonthHidden" name="startMonthHidden" placeholder="Start Period" autocomplete="off" hidden/>
				            </div>
                        </div>
                        <div class="col-md-3">
                            <!-- <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div> -->
                            <label class="form-label"> Periode Akhir</label>
                            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
				                <input  class="form-control " id="endMonth" name="endMonth" placeholder="End Period" autocomplete="off" />
                                <input  class="form-control " id="endMonthHidden" name="endMonthHidden" placeholder="End Period" autocomplete="off" hidden/>
				            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Penjamin</label>
                            <select name="penjamin" id="penjamin" class="form-control" selected=false>
                                <option value="" selected disabled>Pilih Penjamin</option>
                                <!-- <option value="all">SEMUA</option> -->
                                <option value="BPJS">BPJS</option>
                                <option value="UMUM">UMUM</option>
                                <option value ="KHUSUS">IKS</option>
                            </select>
                        </div>    
                        <div class="col-md-3">
                            <label class="form-label">Kelompok Pelayanan</label>
                            <select name="kelPelayanan" id="kelPelayanan" class="form-control">
                                <option value="" selected disabled>Pilih Kelompok Pelayanan</option>
                                <option value="rawat_inap">Rawat Inap</option>
                                <option value="rawat_jalan">Rawat Jalan</option>
                            </select>
                        </div>   
                        <div class="col-md-3">
                            <label class="form-label"></label>
                            <div class="form-actions">
                                <button class="btn btn-primary" type="button" onclick="getPendapatanDiagnosa()"><span><i class="fa fa-search"></i> Search</span></button>
                                <button class="btn btn-warning" type="button" onclick="getPendapatanDiagnosaExcel()"><span><i class="fa fa-download"></i> Excel</span></button>
                            </div>
                        </div>                
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date_picker_days2">	
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row align-items-center"style="padding-top:12px;">
                        
                        
                    </div>
                <!-- <?php echo form_close();?> -->
			</div>			
		</div>						
	</div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Pendapatan Diagnosa</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Diagnosa</th>
                                            <th>Nama Diagnosa</th>
                                            <th>Kode CBG</th>
                                            <th>Nama CBG</th>
                                            <th>Jumlah Kasus</th>
                                            <th>Total Tarif Riil</th>
                                            <th>Total Tarif BPJS (Umbal)</th>
                                        </tr>                         
                                    </thead>
                                    <tbody>
                                        
                                        <?php 
                                        if (isset($pendapatan_diagnosa)) {
                                        
                                            $i = 1;
                                            foreach ($pendapatan_diagnosa as $row) { 
                                        ?>
                                         <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->id_diagnosa;?></td>
                                            <td><?php echo $row->diagnosa;?></td>
                                            <td><?php echo "-";?></td>
                                            <td><?php echo "-";?></td>
                                            <td><?php echo $row->total_kasus;?></td>
                                            <td><?php echo "Rp. ". number_format($row->total_pendapatan,2,',','.');?></td>
                                            <td><?php echo "-";?></td>
                                        </tr>
                                        <?php }
                                        }
                                        ?>
                                    <tbody>
                                </table>
                        </div>
                        <!-- <h5><b>Total Rupiah BPJS : </b><?php echo number_format($total_bpjs); ?></h5><br>
                        <h5><b>Total Rupiah UMUM : </b><?php echo number_format($total_ruang_umum + $total_umum); ?></h5><br>
                        <h5><b>Total Rupiah IKS PLN : </b><?php echo number_format($total_iks_pln); ?></h5><br>
                        <h5><b>Total Rupiah IKS DLL : </b><?php echo number_format($total_iks); ?></h5> -->
                    </div>
                    <!-- <a href="<?= base_url('iri/riclaporan/excel_lap_realisasi_tindakan'.'/'.$tgl1.'/'.$tgl2); ?>" class="btn btn-danger" target="_blank">Excel</a> -->
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->

<script>
    function getPendapatanDiagnosa(){
        var startMonth = $("#startMonthHidden").val();
        var endMonth = $("#endMonthHidden").val();
        var penjamin = $("#penjamin").val();
        var kelPelayanan = $("#kelPelayanan").val();
        $.ajax({
            url: "<?php echo site_url('laporan/claporandiagnosa/getPendapatanDiagnosa'); ?>",
            dataType:'json',
            type: "POST",
            data: {
                startMonth: startMonth,
                endMonth: endMonth, 
                penjamin: penjamin,
                kelPelayanan: kelPelayanan,
            },
            success: function(data) {
                console.log(data);
                $("#example").dataTable().fnDestroy();
                $('#example').DataTable( {
                    data: data,
                    columns: [
                        { data: 'no' },
                        { data: 'id_diagnosa' },
                        { data: 'diagnosa' },
                        { data: 'kode_cbg' },
                        { data: 'nama_cbg' },
                        { data: 'total_kasus' },
                        { data: 'total_pendapatan' },
                    ]
                } );
            }

        })
    }

    function getPendapatanDiagnosaExcel(){
        var startMonth = $("#startMonthHidden").val();
        var endMonth = $("#endMonthHidden").val();
        var startMonthString = $("#startMonth").val();
        var endMonthString = $("#endMonth").val();
        var penjamin = $("#penjamin").val();
        var kelPelayanan = $("#kelPelayanan").val();;
        $.ajax({
            url: "<?php echo site_url('laporan/claporandiagnosa/getPendapatanDiagnosaExcel'); ?>",
            dataType:'json',
            type: "POST",
            data: { 
                startMonth: startMonth,
                endMonth: endMonth, 
                penjamin: penjamin,
                kelPelayanan: kelPelayanan,
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