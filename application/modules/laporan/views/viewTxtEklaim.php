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
                                <button class="btn btn-primary" type="button" onClick="getLaporanTxtEklaim()"><span><i class= "fa fa-search"></i> Search</span></button>
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
					<h4 align="center">Laporan BPJS E - Klaim</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No SEP</th>
                                            <th>No Register</th>
                                            <th>Nama</th>
                                            <th>Tgl Lahir</th>
                                            <th>No Kartu BPJS</th>
                                            <th>Tgl Masuk</th>
                                            <th>Tgl Pulang</th>
                                            <th>Jenis Rawat</th>
                                            <th>Kelas Rawat</th>
                                            <th>Adl Sub Acute</th>
                                            <th>Adl Chronic</th>
                                            <th>Icu Indikator</th>
                                            <th>Icu Los</th>
                                            <th>Jam Ventilator</th>
                                            <th>Upgrade Class Ind</th>
                                            <th>Upgrade Class</th>
                                            <th>Upgrade Class Los</th>
                                            <th>Add Payment PCT</th>
                                            <th>Birth Weight</th>
                                            <th>Discharge Status</th>
                                            <th>Diagnosa</th>
                                            <th>Procedure</th>
                                            <th>Tarif Poli Eks</th>
                                            <th>Dokter</th>
                                            <th>Kode Tarif</th>
                                            <th>Payor ID</th>
                                            <th>Payor CD</th>
                                            <th>Cob CD</th>
                                            <th>NIK</th>
                                            <th>Special CMG</th>
                                            <th>Kode INA-CBG</th>
                                            <th>Tarif CBG Kelas 1</th>
                                            <th>Tarif CBG Kelas 2</th>
                                            <th>Tgl Grouper</th>
                                            <th>Status Kirim</th>
                                            <th>Status Klaim</th>
                                            <th>Verifikasi</th>
                                            <th>Tarif Prosedur Non Bedah</th>
                                            <th>Tarif Prosedur Bedah</th>
                                            <th>Tarif Konsul</th>
                                            <th>Tarif Tenaga Ahli</th>
                                            <th>Tarif Keperawatan</th>
                                            <th>Tarif Penunjang</th>
                                            <th>Tarif Radiologi</th>
                                            <th>Tarif Laboratorium</th>
                                            <th>Tarif Pelayanan Darah</th>
                                            <th>Tarif Rehab</th>
                                            <th>Tarif Kamar</th>
                                            <th>Tarif Rawat Intensif</th>
                                            <th>Tarif Obat</th>
                                            <th>Tarif Alkes</th>
                                            <th>Tarif BMHP</th>
                                            <th>Tarif Sewa Alat</th>
                                            <th>Tarif Obat Kronis</th>
                                            <th>Tarif Obat Kemoterapi</th>                                        
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
function getLaporanTxtEklaim(){
    // var startMonthString = $("#startMonth").val();
    // var endMonthString = $("#startMonth").val();
    var startMonth = $("#startMonthHidden").val();
    var endMonth = $("#endMonthHidden").val();
    $.ajax({
        url: "<?php echo site_url('laporan/claporantxtbpjs/getLaporanTxtEklaim'); ?>",
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
                    { data: 'no' },
                    { data: 'no_sep' },
                    { data: 'no_register' },
                    { data: 'nama_pasien' },
                    { data: 'tgl_lahir' },
                    { data: 'nomor_kartu' },
                    { data: 'tgl_masuk'},
                    { data: 'tgl_pulang' },
                    { data: 'jenis_rawat' },
                    { data: 'kelas_rawat' },
                    { data: 'adl_sub_acute' },
                    { data: 'adl_chronic' },
                    { data: 'icu_indikator' },
                    { data: 'icu_los' },
                    { data: 'ventilator_hour' },
                    { data: 'upgrade_class_ind' },
                    { data: 'upgrade_class_class' },
                    { data: 'upgrade_class_los' },
                    { data: 'add_payment_pct' },
                    { data: 'birth_weight' },
                    { data: 'discharge_status'},
                    { data: 'diagnosa' },
                    { data: 'procedure' },
                    { data: 'tarif_poli_eks' },
                    { data: 'nama_dokter' },
                    { data: 'kode_tarif' },
                    { data: 'payor_id' },
                    { data: 'payor_cd' },
                    { data: 'cob_cd' },
                    { data: 'coder_nik' },
                    { data: 'special_cmg' },
                    { data: 'cbg_code' },
                    { data: 'tarif_grouper1' },
                    { data: 'tarif_grouper2' },
                    { data: 'grouper_at'},
                    { data: 'status_kirim' },
                    { data: 'status_klaim' },
                    { data: 'verifikasi' },
                    { data: 'tarif_prosedur_non_bedah' },
                    { data: 'tarif_prosedur_bedah' },
                    { data: 'tarif_konsultasi' },
                    { data: 'tarif_tenaga_ahli' },
                    { data: 'tarif_keperawatan' },
                    { data: 'tarif_penunjang' },
                    { data: 'tarif_radiologi' },
                    { data: 'tarif_laboratorium' },
                    { data: 'tarif_pelayanan_darah' },
                    { data: 'tarif_rehabilitasi' },
                    { data: 'tarif_kamar'},
                    { data: 'tarif_rawat_intensif' },
                    { data: 'tarif_obat' },
                    { data: 'tarif_alkes' },
                    { data: 'tarif_bmhp' },
                    { data: 'tarif_sewa_alat' },
                    { data: 'tarif_obat_kronis' },
                    { data: 'tarif_obat_kemoterapi' }
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
            url: "<?php echo site_url('laporan/claporantxtbpjs/laporanTxtEklaimDownload'); ?>",
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