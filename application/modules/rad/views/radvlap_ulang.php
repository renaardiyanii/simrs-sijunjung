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
					<h4 align="center" id="tgl_periksa">Laporan Pengulangan Radiologi</h4></div>					
                    <div class="panel-body" id="tbl_thn">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Jenis Layanan</th>
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
                                            <th>Jenis Layanan</th>
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
            url: `<?= base_url('rad/radclaporan/lap_ulang_mod_thn?tampil_per=') ?>${tampil_per}&data=${data}`,
            data: data,
            beforeSend: function() {
                $('#hasilPencarian').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
            },
            success: function(data) {
                // console.log(data);
                let html = '';
                let no = 1;
                let total_jan = 0;
                let total_feb = 0;
                let total_mar = 0;
                let total_apr = 0;
                let total_mei = 0;
                let total_jun = 0;
                let total_jul = 0;
                let total_ags = 0;
                let total_sep = 0;
                let total_okt = 0;
                let total_nov = 0;
                let total_des = 0;
              
                data.map((e)=>{
                    html+=`
                        <tr>
                            <td>${no}</td>
                            <td>${e.modality}</td>
                    
                        `;
                    
                    e.hasil.map((v)=>{
                        if(v[0]['JANUARI'] !== undefined){
                            let jml = v[0]['JANUARI'].jml?(v[0]['JANUARI'].jml!='0'?(v[0]['JANUARI'].jml):0):0;
                            total_jan += parseInt(jml);
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
                            total_feb += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_feb = total_exam_feb + parseInt(exam);
                            // total_expert_feb = total_expert_feb + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['MARET'] !== undefined)
                        {
                            let jml = v[0]['MARET'].jml?(v[0]['MARET'].jml!='0'?(v[0]['MARET'].jml):0):0;
                            total_mar += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_mar = total_exam_mar + parseInt(exam);
                            // total_expert_mar = total_expert_mar + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['APRIL'] !== undefined)
                        {
                            let jml = v[0]['APRIL'].jml?(v[0]['APRIL'].jml!='0'?(v[0]['APRIL'].jml):0):0;
                            total_apr += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_apr = total_exam_apr + parseInt(exam);
                            // total_expert_apr = total_expert_apr + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['MEI'] !== undefined)
                        {
                            let jml = v[0]['MEI'].jml?(v[0]['MEI'].jml!='0'?(v[0]['MEI'].jml):0):0;
                            total_mei += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_mei = total_exam_mei + parseInt(exam);
                            // total_expert_mei = total_expert_mei + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['JUNI'] !== undefined)
                        {
                            let jml = v[0]['JUNI'].jml?(v[0]['JUNI'].jml!='0'?(v[0]['JUNI'].jml):0):0;
                            total_jun += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_jun = total_exam_jun + parseInt(exam);
                            // total_expert_jun = total_expert_jun + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['JULI'] !== undefined)
                        {
                            let jml = v[0]['JULI'].jml?(v[0]['JULI'].jml!='0'?(v[0]['JULI'].jml):0):0;
                            total_jul += parseInt(jml);
                            // let persen = (expert / jml) * 100;
                            // total_exam_jul = total_exam_jul + parseInt(exam);
                            // total_expert_jul = total_expert_jul + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        
                        if(v[0]['AGUSTUS'] !== undefined)
                        {
                            let jml = v[0]['AGUSTUS'].jml?(v[0]['AGUSTUS'].jml!='0'?(v[0]['AGUSTUS'].jml):0):0;
                            total_ags += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_ags = total_exam_ags + parseInt(exam);
                            // total_expert_ags = total_expert_ags + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                     

                        if(v[0]['SEPTEMBER'] !== undefined)
                        {
                            let jml = v[0]['SEPTEMBER'].jml?(v[0]['SEPTEMBER'].jml!='0'?(v[0]['SEPTEMBER'].jml):0):0;
                            total_sep += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_sep = total_exam_sep + parseInt(exam);
                            // total_expert_sep = total_expert_sep + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['OKTOBER'] !== undefined)
                        {
                            let jml = v[0]['OKTOBER'].jml?(v[0]['OKTOBER'].jml!='0'?(v[0]['OKTOBER'].jml):0):0;
                            total_okt += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_okt = total_exam_okt + parseInt(exam);
                            // total_expert_okt = total_expert_okt + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['NOVEMBER'] !== undefined)
                        {
                            let jml = v[0]['NOVEMBER'].jml?(v[0]['NOVEMBER'].jml!='0'?(v[0]['NOVEMBER'].jml):0):0;
                            total_nov += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_nov = total_exam_nov + parseInt(exam);
                            // total_expert_nov = total_expert_nov + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                        if(v[0]['DESEMBER'] !== undefined)
                        {
                            let jml = v[0]['DESEMBER'].jml?(v[0]['DESEMBER'].jml!='0'?(v[0]['DESEMBER'].jml):0):0;
                            total_des += parseInt(jml);
                            // let persen = (expert / exam) * 100;
                            // total_exam_des = total_exam_des+ parseInt(exam);
                            // total_expert_des = total_expert_des + + parseInt(expert);
                            html+=`
                                <td>${jml}</td>
                            `;
                        }
                    });
                    

                   
                    
                    html+='</tr>';
                    no++
                })
                html+=`<tr>
                    <td colspan='2'>Jumlah Exposi</td>
                    <td>${total_jan}</td>
                    <td>${total_feb}</td>
                    <td>${total_mar}</td>
                    <td>${total_apr}</td>
                    <td>${total_mei}</td>
                    <td>${total_jun}</td>
                    <td>${total_jul}</td>
                    <td>${total_ags}</td>
                    <td>${total_sep}</td>
                    <td>${total_okt}</td> 
                    <td>${total_nov}</td> 
                    <td>${total_des}</td>`;
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
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_ulang_thn');?>/'+date0, '_blank');
    } else if (tampil === 'BLN') {
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_ulang_bln');?>/'+date, '_blank');
    }
           
}

function get_bln(){
    var date = document.getElementById('date_picker_months').value;
    var url = "<?php echo site_url();?>rad/Radclaporan/lap_ulang_mod_bln/"+date;
    table = $('#example_bln').DataTable({
        ajax: url,
        columns: [
            { data: "no" },
            { data: "modality" },
            { data: "jml" }
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