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
    $('#cariLapJmlExpertButtonBln').show();
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
            $('#cariLapJmlExpertButtonBln').show();
            $('#cariLapJmlExpertButton').hide();
            $('#tbl_bln').show();
            $('#tbl_thn').hide();
		}else if(val_tampil_per=='THN'){
			$('#tbl_thn').show();
            $('#tbl_bln').hide();
            $('#cariLapJmlExpertButtonBln').hide();
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
                                <button class="btn btn-primary" type="button" id="cariLapJmlExpertButtonBln" onClick="get_bln()">Search</button>
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
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Tindakan</th>
                                            <th colspan="3">Januari</th>
                                            <th colspan="3">Februari</th>
                                            <th colspan="3">Maret</th>
                                            <th colspan="3">April</th>
                                            <th colspan="3">Mei</th>
                                            <th colspan="3">Juni</th>
                                            <th colspan="3">Juli</th>
                                            <th colspan="3">Agustus</th>
                                            <th colspan="3">September</th>
                                            <th colspan="3">Oktober</th>
                                            <th colspan="3">November</th>
                                            <th colspan="3">Desember</th>
                                        </tr>
                                        <tr>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
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
                                            <th>Tindakan</th>
                                            <th>JML EXAM</th>
                                            <th>JML EXPERT</th>
                                            <th>%</th>
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
            url: `<?= base_url('rad/radclaporan/lap_jml_expert_mod?tampil_per=') ?>${tampil_per}&data=${data}`,
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
                            <td>${e.modality}</td>
                    
                        `;
                    
                    e.hasil.map((v)=>{
                        if(v[0]['JANUARI'] !== undefined){
                            let exam = v[0]['JANUARI'].exam==''?0:v[0]['JANUARI'].exam;
                            let expert = v[0]['JANUARI'].expert==''?0:v[0]['JANUARI'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_jan = total_exam_jan + parseInt(exam);
                            total_expert_jan = total_expert_jan + + parseInt(expert);
                            html+=`
                                <td>${v[0]['JANUARI']!=undefined?v[0]['JANUARI'].exam:''}</td>
                                <td>${v[0]['JANUARI']!=undefined?v[0]['JANUARI'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['FEBUARI'] !== undefined)
                        {
                            let exam = v[0]['FEBUARI'].exam==''?0:v[0]['FEBUARI'].exam;
                            let expert = v[0]['FEBUARI'].expert==''?0:v[0]['FEBUARI'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_feb = total_exam_feb + parseInt(exam);
                            total_expert_feb = total_expert_feb + + parseInt(expert);
                            html+=`
                                <td>${v[0]['FEBUARI']!=undefined?v[0]['FEBUARI'].exam:''}</td>
                                <td>${v[0]['FEBUARI']!=undefined?v[0]['FEBUARI'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['MARET'] !== undefined)
                        {
                            let exam = v[0]['MARET'].exam==''?0:v[0]['MARET'].exam;
                            let expert = v[0]['MARET'].expert==''?0:v[0]['MARET'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_mar = total_exam_mar + parseInt(exam);
                            total_expert_mar = total_expert_mar + + parseInt(expert);
                            html+=`
                                <td>${v[0]['MARET']!=undefined?v[0]['MARET'].exam:''}</td>
                                <td>${v[0]['MARET']!=undefined?v[0]['MARET'].expert:''}</td>
                                <td>${persen}%</td>
                            `;
                        }
                        if(v[0]['APRIL'] !== undefined)
                        {
                            let exam = v[0]['APRIL'].exam==''?0:v[0]['APRIL'].exam;
                            let expert = v[0]['APRIL'].expert==''?0:v[0]['APRIL'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_apr = total_exam_apr + parseInt(exam);
                            total_expert_apr = total_expert_apr + + parseInt(expert);
                            html+=`
                                <td>${v[0]['APRIL']!=undefined?v[0]['APRIL'].exam:''}</td>
                                <td>${v[0]['APRIL']!=undefined?v[0]['APRIL'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['MEI'] !== undefined)
                        {
                            let exam = v[0]['MEI'].exam==''?0:v[0]['MEI'].exam;
                            let expert = v[0]['MEI'].expert==''?0:v[0]['MEI'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_mei = total_exam_mei + parseInt(exam);
                            total_expert_mei = total_expert_mei + + parseInt(expert);
                            html+=`
                                <td>${v[0]['MEI']!=undefined?v[0]['MEI'].exam:''}</td>
                                <td>${v[0]['MEI']!=undefined?v[0]['MEI'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['JUNI'] !== undefined)
                        {
                            let exam = v[0]['JUNI'].exam==''?0:v[0]['JUNI'].exam;
                            let expert = v[0]['JUNI'].expert==''?0:v[0]['JUNI'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_jun = total_exam_jun + parseInt(exam);
                            total_expert_jun = total_expert_jun + + parseInt(expert);
                            html+=`
                                <td>${v[0]['JUNI']!=undefined?v[0]['JUNI'].exam:''}</td>
                                <td>${v[0]['JUNI']!=undefined?v[0]['JUNI'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['JULI'] !== undefined)
                        {
                            let exam = v[0]['JULI'].exam==''?0:v[0]['JULI'].exam;
                            let expert = v[0]['JULI'].expert==''?0:v[0]['JULI'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_jul = total_exam_jul + parseInt(exam);
                            total_expert_jul = total_expert_jul + + parseInt(expert);
                            html+=`
                                <td>${v[0]['JULI']!=undefined?v[0]['JULI'].exam:''}</td>
                                <td>${v[0]['JULI']!=undefined?v[0]['JULI'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        
                        if(v[0]['AGUSTUS'] !== undefined)
                        {
                            let exam = v[0]['AGUSTUS'].exam==''?0:v[0]['AGUSTUS'].exam;
                            let expert = v[0]['AGUSTUS'].expert==''?0:v[0]['AGUSTUS'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_ags = total_exam_ags + parseInt(exam);
                            total_expert_ags = total_expert_ags + + parseInt(expert);
                            html+=`
                                <td>${v[0]['AGUSTUS']!=undefined?v[0]['AGUSTUS'].exam:'&nbsp;'}</td>
                                <td>${v[0]['AGUSTUS']!=undefined?v[0]['AGUSTUS'].expert:'&nbsp;'}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                     

                        if(v[0]['SEPTEMBER'] !== undefined)
                        {
                            let exam = v[0]['SEPTEMBER'].exam==''?0:v[0]['SEPTEMBER'].exam;
                            let expert = v[0]['SEPTEMBER'].expert==''?0:v[0]['SEPTEMBER'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_sep = total_exam_sep + parseInt(exam);
                            total_expert_sep = total_expert_sep + + parseInt(expert);
                            html+=`
                                <td>${v[0]['SEPTEMBER']!=undefined?v[0]['SEPTEMBER'].exam:''}</td>
                                <td>${v[0]['SEPTEMBER']!=undefined?v[0]['SEPTEMBER'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['OKTOBER'] !== undefined)
                        {
                            let exam = v[0]['OKTOBER'].exam==''?0:v[0]['OKTOBER'].exam;
                            let expert = v[0]['OKTOBER'].expert==''?0:v[0]['OKTOBER'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_okt = total_exam_okt + parseInt(exam);
                            total_expert_okt = total_expert_okt + + parseInt(expert);
                            html+=`
                                <td>${v[0]['OKTOBER']!=undefined?v[0]['OKTOBER'].exam:''}</td>
                                <td>${v[0]['OKTOBER']!=undefined?v[0]['OKTOBER'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['NOVEMBER'] !== undefined)
                        {
                            let exam = v[0]['NOVEMBER'].exam==''?0:v[0]['NOVEMBER'].exam;
                            let expert = v[0]['NOVEMBER'].expert==''?0:v[0]['NOVEMBER'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_nov = total_exam_nov + parseInt(exam);
                            total_expert_nov = total_expert_nov + + parseInt(expert);
                            html+=`
                                <td>${v[0]['NOVEMBER']!=undefined?v[0]['NOVEMBER'].exam:''}</td>
                                <td>${v[0]['NOVEMBER']!=undefined?v[0]['NOVEMBER'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                        if(v[0]['DESEMBER'] !== undefined)
                        {
                            let exam = v[0]['DESEMBER'].exam==''?0:v[0]['DESEMBER'].exam;
                            let expert = v[0]['DESEMBER'].expert==''?0:v[0]['DESEMBER'].expert;
                            let persen = (expert / exam) * 100;
                            total_exam_des = total_exam_des+ parseInt(exam);
                            total_expert_des = total_expert_des + + parseInt(expert);
                            html+=`
                                <td>${v[0]['DESEMBER']!=undefined?v[0]['DESEMBER'].exam:''}</td>
                                <td>${v[0]['DESEMBER']!=undefined?v[0]['DESEMBER'].expert:''}</td>
                                <td>${persen}%</td>
                                
                            `;
                        }
                    });
                    

                   
                    
                    html+='</tr>';
                    no++
                })
                console.log(total_exam_ags);
                html+=`<tr>
                    <td colspan='2'>Jumlah</td>
                    <td>${total_exam_jan}</td>
                    <td>${total_expert_jan}</td>
                    <td>${(total_expert_jan / total_exam_jan) * 100}%</td>
                    <td>${total_exam_feb}</td>
                    <td>${total_expert_feb}</td>
                    <td>${(total_expert_feb / total_exam_feb) * 100}%</td>
                    <td>${total_exam_mar}</td>
                    <td>${total_expert_mar}</td>
                    <td>${(total_expert_mar / total_exam_mar) * 100}%</td>
                    <td>${total_exam_apr}</td>
                    <td>${total_expert_apr}</td>
                    <td>${(total_expert_apr / total_exam_apr) * 100}%</td>
                    <td>${total_exam_mei}</td>
                    <td>${total_expert_mei}</td>
                    <td>${(total_expert_mei / total_exam_mei) * 100}%</td>
                    <td>${total_exam_jun}</td>
                    <td>${total_expert_jun}</td>
                    <td>${(total_expert_jun / total_exam_jun) * 100}%</td>
                    <td>${total_exam_jul}</td>
                    <td>${total_expert_jul}</td>
                    <td>${(total_expert_jul / total_exam_jul) * 100}%</td>
                    <td>${total_exam_ags}</td>
                    <td>${total_expert_ags}</td>
                    <td>${(total_expert_ags / total_exam_ags) * 100}%</td>
                    <td>${total_exam_sep}</td>
                    <td>${total_expert_sep}</td>
                    <td>${(total_expert_sep / total_exam_sep) * 100}%</td>
                    <td>${total_exam_okt}</td>
                    <td>${total_expert_okt}</td>
                    <td>${(total_expert_okt / total_exam_okt) * 100}%</td>
                    <td>${total_exam_nov}</td>
                    <td>${total_expert_nov}</td>
                    <td>${(total_expert_nov / total_exam_nov) * 100}%</td>
                    <td>${total_exam_des}</td>
                    <td>${total_expert_des}</td>
                    <td>${(total_expert_des / total_exam_des) * 100}%</td>`;
                html+='</tr>';
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
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_jml_expert_thn');?>/'+date0, '_blank');
    } else if (tampil === 'BLN') {
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_jml_expert_bln');?>/'+date, '_blank');
    }
           
}

function get_bln(){
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
</script>
    
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>