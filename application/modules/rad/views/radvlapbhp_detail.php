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
    $('#example_bln').DataTable();
    $('#tbl_bln').show();
    $('#btncari').show();
    $('#month_input').show();
    $('#cariLapJmlExpertButton').hide();
    $('#year_input').hide();
    $('#tbl_thn').hide();
});

function cek_tampil_per(val_tampil_per){
	    if(val_tampil_per=='BLN'){
			//alert("bln");
			$('#month_input').show();
			$('#year_input').hide();
            $('#btncari').show();
            $('#cariLapJmlExpertButton').hide();
            $('#tbl_bln').show();
            $('#tbl_thn').hide();
		}else if(val_tampil_per=='THN'){
			$('#tbl_thn').show();
            $('#tbl_bln').hide();
            $('#btncari').hide();
            $('#cariLapJmlExpertButton').show();
			$('#month_input').hide();
			$('#year_input').show();
		}
	}
</script>
<style>
hr {
	border-color:#7DBE64 !important;
} p {
    font-size: 12px;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php //echo form_open('rad/Radclaporan/lap_jml_expert_exe');?>
                <form id="cariLapJmlExpert">
                    
                    <div class="row p-t-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <!-- <option value="TGL">Tanggal</option> -->
                                    <option value="BLN">Bulan</option>
                                    <option value="THN">Tahun</option>
                                </select>
                            </div>
                        </div>											
                        <div class="col-md-3">
                            <div class="form-group">
                                <!-- <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >	
                                </div> -->
                                <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                    <br><p id="date_picker_months">Format Tanggal : YYYY-MM</p>
                                    <p id="date_picker_months">Contoh : 2022-01</p>
                                </div>
                                <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="button" id="cariLapJmlExpertButton">Cari</button>
                                <button class="btn btn-primary" type="button" id="btncari" onClick="get_bln()">Search</button>
                            </div>
                        </div>
                    </div>
                    <?php //echo form_close();?>
                </form>
					
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
					<h4 align="center" id="tgl_periksa">Presentase Expertise Radiologi</h4></div>					
                    <div class="panel-body" id="tbl_thn">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama BHP</th>
                                            <th>Januari</th>
                                            <th>Februari</th>
                                            <th>Maret</th>
                                            <th>April</th>
                                            <th>Mei</th>
                                            <th>Juni</th>
                                            <th>Juli</th>
                                            <th>Agustus</th>
                                            <th>September</th>
                                            <th>Oktober</th>
                                            <th>November</th>
                                            <th>Desember</th>
                                        </tr>
                                       
                                    </thead>
                                    <tbody id="hasilPencarian">
                                       
                                    </tbody>
                                </table>
                        </div>
                            <?php //if($tampil == '') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$today.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} else if($tampil == 'TGL') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$tgl.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} else if($tampil == 'BLN') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$bln.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} else if($tampil == 'THN') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$thn.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} ?>
                    </div>
                    <div class="panel-body" id="tbl_bln">
                        <div class="table-responsive m-t-15">
                            <table id="example_bln" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama BHP</th>
                                            <th>Jumlah</th>
                                        </tr>
                                       
                                    </thead>
                                    <tbody id="hasilPencarianBln">
                                       
                                    </tbody>
                            </table>
                        </div>
                        
                            <?php //if($tampil == '') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$today.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} else if($tampil == 'TGL') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$tgl.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} else if($tampil == 'BLN') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$bln.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} else if($tampil == 'THN') { ?>
                                <!-- <a href="<?php echo base_url('rad/radclaporan/cetak_laporan_pemeriksaan/'.$thn.'/'.$tampil) ?>" class="btn btn-success" target="_blank">Excel</a> -->
                            <?php //} ?>
                    </div>			
                    <button type="button" class="btn btn-danger" onClick="down_excel()">Excel</button>				
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->

<script>
    
    $('#cariLapJmlExpertButton').click(function(){
        let tampil_per = $('#tampil_per').val();
        let data = tampil_per == 'THN'?$('#date_picker_years').val():$('#date_picker_months').val();
        // console.log(data);

        $.ajax({
            url: `<?= base_url('rad/radclaporan/lap_bhp_detail_mod?tampil_per=') ?>${tampil_per}&data=${data}`,
            data: data,
            beforeSend: function() {
                $('#hasilPencarian').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
            },
            success: function(data) {
                // console.log(data);
                let html = '';
                let no = 1;
                let total_exam_jan = 0;
                let total_exam_feb = 0;
                let total_exam_mar = 0;
                let total_exam_apr = 0;
                let total_exam_mei = 0;
                let total_exam_jun = 0;
                let total_exam_jul = 0;
                let total_exam_ags = 0;
                let total_exam_sep = 0;
                let total_exam_okt = 0;
                let total_exam_nov = 0;
                let total_exam_des = 0;
                let total_expert_jan = 0;
                let total_expert_feb = 0;
                let total_expert_mar = 0;
                let total_expert_apr = 0;
                let total_expert_mei = 0;
                let total_expert_jun = 0;
                let total_expert_jul = 0;
                let total_expert_ags = 0;
                let total_expert_sep = 0;
                let total_expert_okt = 0;
                let total_expert_nov = 0;
                let total_expert_des = 0;
                // let modality = '';
                
                data.map((e)=>{
                    html+=`
                        <tr>
                            <td>${no}</td>
                            <td>${e.nama_bhp}</td>
                    
                        `;
                    
                    e.hasil.map((v)=>{
                        if(v[0]['JANUARI'] !== undefined){
                            let jml = v[0]['JANUARI'].jml?(v[0]['JANUARI'].jml!='0'?(v[0]['JANUARI'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['FEBUARI'] !== undefined)
                        {
                            let jml = v[0]['FEBUARI'].jml?(v[0]['FEBUARI'].jml!='0'?(v[0]['FEBUARI'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['MARET'] !== undefined)
                        {
                            let jml = v[0]['MARET'].jml?(v[0]['MARET'].jml!='0'?(v[0]['MARET'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['APRIL'] !== undefined)
                        {
                            let jml = v[0]['APRIL'].jml?(v[0]['APRIL'].jml!='0'?(v[0]['APRIL'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['MEI'] !== undefined)
                        {
                            let jml = v[0]['MEI'].jml?(v[0]['MEI'].jml!='0'?(v[0]['MEI'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['JUNI'] !== undefined)
                        {
                            let jml = v[0]['JUNI'].jml?(v[0]['JUNI'].jml!='0'?(v[0]['JUNI'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['JULI'] !== undefined)
                        {
                            let jml = v[0]['JULI'].jml?(v[0]['JULI'].jml!='0'?(v[0]['JULI'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        
                        if(v[0]['AGUSTUS'] !== undefined)
                        {
                            let jml = v[0]['AGUSTUS'].jml?(v[0]['AGUSTUS'].jml!='0'?(v[0]['AGUSTUS'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                     

                        if(v[0]['SEPTEMBER'] !== undefined)
                        {
                            let jml = v[0]['SEPTEMBER'].jml?(v[0]['SEPTEMBER'].jml!='0'?(v[0]['SEPTEMBER'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['OKTOBER'] !== undefined)
                        {
                            let jml = v[0]['OKTOBER'].jml?(v[0]['OKTOBER'].jml!='0'?(v[0]['OKTOBER'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['NOVEMBER'] !== undefined)
                        {
                            let jml = v[0]['NOVEMBER'].jml?(v[0]['NOVEMBER'].jml!='0'?(v[0]['NOVEMBER'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['DESEMBER'] !== undefined)
                        {
                            let jml = v[0]['DESEMBER'].jml?(v[0]['DESEMBER'].jml!='0'?(v[0]['DESEMBER'].jml):0):0;
                            // let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            // let persen = (expert / exam) * 100;
                            // total_exam_jan = total_exam_jan + parseInt(exam);
                            // total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                    });
                    
                    html+='</tr>';
                    no++
                })
                // console.log(total_exam_ags);
                // html+=`<tr>
                //     <td colspan='2'>Jumlah</td>
                //     <td>${total_exam_jan}</td>
                //     <td>${total_expert_jan}</td>
                //     <td>${(total_expert_jan / total_exam_jan) * 100}%</td>
                //     <td>${total_exam_feb}</td>
                //     <td>${total_expert_feb}</td>
                //     <td>${(total_expert_feb / total_exam_feb) * 100}%</td>
                //     <td>${total_exam_mar}</td>
                //     <td>${total_expert_mar}</td>
                //     <td>${(total_expert_mar / total_exam_mar) * 100}%</td>
                //     <td>${total_exam_apr}</td>
                //     <td>${total_expert_apr}</td>
                //     <td>${(total_expert_apr / total_exam_apr) * 100}%</td>
                //     <td>${total_exam_mei}</td>
                //     <td>${total_expert_mei}</td>
                //     <td>${(total_expert_mei / total_exam_mei) * 100}%</td>
                //     <td>${total_exam_jun}</td>
                //     <td>${total_expert_jun}</td>
                //     <td>${(total_expert_jun / total_exam_jun) * 100}%</td>
                //     <td>${total_exam_jul}</td>
                //     <td>${total_expert_jul}</td>
                //     <td>${(total_expert_jul / total_exam_jul) * 100}%</td>
                //     <td>${total_exam_ags}</td>
                //     <td>${total_expert_ags}</td>
                //     <td>${(total_expert_ags / total_exam_ags) * 100}%</td>
                //     <td>${total_exam_sep}</td>
                //     <td>${total_expert_sep}</td>
                //     <td>${(total_expert_sep / total_exam_sep) * 100}%</td>
                //     <td>${total_exam_okt}</td>
                //     <td>${total_expert_okt}</td>
                //     <td>${(total_expert_okt / total_exam_okt) * 100}%</td>
                //     <td>${total_exam_nov}</td>
                //     <td>${total_expert_nov}</td>
                //     <td>${(total_expert_nov / total_exam_nov) * 100}%</td>
                //     <td>${total_exam_des}</td>
                //     <td>${total_expert_des}</td>
                //     <td>${(total_expert_des / total_exam_des) * 100}%</td>`;
                // html+='</tr>';
                $('#hasilPencarian').html(html);
            },
            error: function(xhr) { 
            },
            complete: function() {
            },
        });
    })
    
function down_excel(){
	var date0 = document.getElementById('date_picker_years').value;
    var date = document.getElementById('date_picker_months').value;
    var tampil = document.getElementById('tampil_per').value;
    
    if(tampil === 'THN') {
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_bhp_detail_thn');?>/'+date0, '_blank');
    } else if (tampil === 'BLN') {
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_bhp_detail_bln');?>/'+date, '_blank');
    }
           
}

function get_bln2(){
    var date = document.getElementById('date_picker_months').value;
    var url = "<?php echo site_url();?>rad/Radclaporan/lap_jml_expert_mod_bln/"+date;
    table = $('#example_bln').DataTable({
        ajax: url,
        columns: [
            { data: "no" },
            { data: "modality" },
            { data: "exam" },
            { data: "expert" },
            { data: "persen"}
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
    var date1 = document.getElementById('date_picker_months').value;
    //var date2 = document.getElementById('date_picker_days2').value;
    // var url = ;
    
    $.ajax({
        url: "<?php echo base_url();?>rad/radclaporan/lap_bhp_detail_bln/"+date1,
        beforeSend: function() {
            $('#btncari').attr('disabled',true);
            $('#btncari').html('Loading....');
        },
        success: function(data) {
            // console.log(data);
            // data = JSON.parse(data);
            $('#example').DataTable();
            $('#hasilPencarianBln').html('');
            let html = '';
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.nama_bhp}</td>
                        <td>${e.jml}</td>
                    </tr>
                    `;
                });
            $('#hasilPencarianBln').append(html);
            $('#example').DataTable();
            return;
            }
            $('#hasilPencarianBln').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');

        },
        error: function(xhr) { // if error occured
            $('#hasilPencarianBln').append('<tr><td colspan="6">Data Tidak ada.</td></tr>');
            
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