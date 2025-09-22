<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<!-- <style>
.table-condensed thead tr:nth-child(2),
.table-condensed tbody {
  display: none
}
</style> -->
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable();
    $('#date_picker_days').show();
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
    // $('#endMonth').datepicker().on("changeMonth", function(e) {
       
    // });
    // $('#tgl').daterangepicker({
    //   	opens: 'right',
	// 	format: 'DD/MM/YYYY',
	// });
    $('#ksm').select2({
        placeholder: "Pilih KSM",
        allowClear: true,
    });
    $('#dokter').select2();
    // $('#dokter').multiselect({
    //     includeSelectAllOption: true,
    //     buttonClass: 'form-control',
        
    // });
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
                <!-- <?php echo form_open('laporan/doclaporan');?> -->
                    <div class="row p-t-0">
                        <div class="col-md-3">
                            <label class="form-label">Periode Awal</label>
                            <div class="input-group">
				                <div class="input-group-addon">
				                    <i class="fa fa-calendar"></i>
				                </div>
                                <input  class="form-control " id="startMonth" name="startMonth" placeholder="Start Period" autocomplete="off" />
                                <input  class="form-control " id="startMonthHidden" name="startMonthHidden" placeholder="Start Period" autocomplete="off" hidden/>
				            </div>
                        </div>
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
                        <div class="col-md-6">
                            <label class="form-label">KSM</label>
                            <select name="ksm" id="ksm" class="form-control" multiple="multiple">
                                <?php
                                if (isset($allKSM)) {
                                    foreach ($allKSM as $ksm) {
                                        ?>
                                            <option value = "<?php echo "'$ksm->id_poli'"; ?>"><?php echo $ksm->nm_poli;?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
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
                                <button class="btn btn-primary" type="button" onClick="getDataRealisasi()"><span><i class= "fa fa-search"></i> Search</span></button>
                                <button class="btn btn-warning" type="button" onClick="getRealisasiDokterExcel()"><span><i class= "fa fa-download"></i> Excel</button>
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center" style="padding-top:12px;">
                        
                        
                    </div>
                    <!-- <div class="row align-items-center" style="padding-top:12px;">
                        <label class="col-sm-1 col-form-label">Pilih Dokter</label>
                        <div class="col-md-3">
                            <select name="dokter[]" id="dokter" class="form-control" multiple="multiple">
                               <?php
                                    foreach ($allDokter as $dokter) {
                                ?>
                                    <option value = "<?php echo $dokter->id_dokter; ?>"><?php echo $dokter->nm_dokter;?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div> -->
                    
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
					<h4 align="center">Realisasi Dokter</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama Dokter</th>
                                            <th rowspan="2">KSM</th>
                                            <th colspan = "3">Jumlah Kasus Ranap</th>
                                            <th colspan = "3">Jumlah Kasus Rajal</th>
                                            <th colspan = "3">Jumlah Tindakan OK</th>
                                            <th colspan = "3">Jumlah Tindakan diluar OK</th>
                                            <th colspan = "1" rowspan = "2">Total Tarif Rill</th>
                                            <th colspan = "3">Penerimaan</th>
                                        </tr>
                                        <tr>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS</th>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS</th>
                                        </tr>                                      
                                    </thead>
                                    <tbody>
                                        <?php if(isset($pendapatanDokter)){
                                            $i = 1;
                                            foreach($pendapatanDokter as $result){
                                        ?>
                                            <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $result->nm_dokter; ?></td>
                                                <td><?php echo $result->ksm; ?></td>
                                                <td><?php echo $result->iri_bpjs; ?></td>
                                                <td><?php echo $result->iri_umum; ?></td>
                                                <td><?php echo $result->iri_iks; ?></td>
                                                <td><?php echo $result->irj_bpjs; ?></td>
                                                <td><?php echo $result->irj_umum; ?></td>
                                                <td><?php echo $result->irj_iks; ?></td>
                                                <td><?php echo $result->ok_bpjs; ?></td>
                                                <td><?php echo $result->ok_umum; ?></td>
                                                <td><?php echo $result->ok_iks; ?></td>
                                                <td><?php echo $result->no_ok_bpjs; ?></td>
                                                <td><?php echo $result->non_ok_umum; ?></td>
                                                <td><?php echo $result->non_ok_iks; ?></td>
                                                <td><?php echo "Rp. ". number_format($result->total_tarif,2,',','.'); ?></td>
                                                <td><?php echo "-"; ?></td>
                                                <td><?php echo "-"; ?></td>
                                                <td><?php echo "-"; ?></td>
                                            </tr>
                                        <?php
                                            }
                                        }?>
                                    </tbody>    
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

<script type="text/javascript">
$(document).ready(function() {
  $("#dokter").select2();
});

const rupiah = (number)=>{
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR"
    }).format(number);
}

function getDataRealisasi(){
    // var startMonthString = $("#startMonth").val();
    // var endMonthString = $("#startMonth").val();
    var startMonth = $("#startMonthHidden").val();
    var endMonth = $("#endMonthHidden").val();
    var ksm = $("#ksm").val();
    $.ajax({
        url: "<?php echo site_url('laporan/doclaporan/getDataRealisasi'); ?>",
        dataType:'json',
        type: "POST",
        data: { 
            startMonth: startMonth, 
            endMonth: endMonth,
            ksm: ksm,
        },
        success: function(data) {
            console.log(data);
            $("#example").dataTable().fnDestroy();
            $('#example').DataTable( {
                data: data,
                columns: [
                    { data: 'no' },
                    { data: 'nm_dokter' },
                    { data: 'ksm' },
                    { data: 'iri_bpjs' },
                    { data: 'iri_umum' },
                    { data: 'iri_iks' },
                    { data: 'irj_bpjs' },
                    { data: 'irj_umum' },
                    { data: 'irj_iks' },
                    { data: 'ok_bpjs' },
                    { data: 'ok_umum' },
                    { data: 'ok_iks' },
                    { data: 'no_ok_bpjs' },
                    { data: 'non_ok_umum' },
                    { data: 'non_ok_iks' },
                    { data: 'total_tarif'},
                    { data: 'pendapatan_bpjs' },
                    { data: 'pendapatan_umum' },
                    { data: 'pendapatan_iks' },
                ]
            } );
        }

    })
}

function getRealisasiDokterExcel(){
    var startMonth = $("#startMonthHidden").val();
    var endMonth = $("#endMonthHidden").val();
    var startMonthString = $("#startMonth").val();
    var endMonthString = $("#endMonth").val();
    var ksm = $("#ksm").val();
    $.ajax({
        type:'POST',
        dataType:'json',
        url:"<?php echo site_url('laporan/doclaporan/getDataRealisasiExcel'); ?>",
        data: {
            startMonth: startMonth,
            endMonth : endMonth,
            startMonthString : startMonthString,
            endMonthString : endMonthString,
            ksm: ksm,
        },
        success: function(data){
            console.log("success");
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



var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

// function ajaxdokter(id_poli){
// 	var id = id_poli.substr(0,4);
// 	var pokpoli = id_poli.substr(5);
// 	console.log(id_poli);
// 	console.log(id);
// 	console.log(pokpoli);

// 	var val_cara_bayar = $('#cara_bayar').val();
// 	var cara_kunjungan = $('#cara_kunjungan').val();
// 	//var res=id.split("-");//it Works :D

//     ajaxku = buatajax();
//     var url="<?php echo site_url('laporan/doclaporan/getDokterByPoli'); ?>";
//     url=url+"/"+id;
//     // url=url+"/"+Math.random();
//     ajaxku.onreadystatechange=stateChangedDokter;
//     ajaxku.open("GET",url,true);
//     ajaxku.send(null);
// 	//document.getElementById("id_provinsi").value = res[0];
// 	//document.getElementById("provinsi").value = res[1];  
	
// }

// function stateChangedDokter(){
//     var data;
// 	console.log(ajaxku.readyState);
//     if (ajaxku.readyState==4){
// 		data=ajaxku.responseText;	
// 		if(data.length>=0){
// 			document.getElementById("dokter").innerHTML = data;
// 		}
//     }
// }
// stateChangedDokter();
</script>

<?php
   if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>