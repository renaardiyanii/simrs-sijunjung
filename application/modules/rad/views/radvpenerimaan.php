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
                                    <br><p>Format Tanggal : YYYY-MM</p>
                                    <p>Contoh : 2022-01</p>
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
					<h4 align="center" id="tgl_periksa">Laporan Penerimaan Radiologi</h4></div>					
                    <div class="panel-body" id="tbl_thn">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <!-- <th rowspan="2">No.</th> -->
                                            <th rowspan="2">Bulan</th>
                                            <th colspan="2">CT SCAN</th>
                                            <th colspan="2">MRI</th>
                                            <th colspan="2">USG</th>
                                            <th colspan="2">PANORAMIK</th>
                                            <th colspan="2">KONVENSIONAL</th>
                                            <!-- <th rowspan="2">PER BULAN</th> -->
                                        </tr>
                                        <tr>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <!-- <th>%</th> -->
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <!-- <th>%</th> -->
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <!-- <th>%</th> -->
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <!-- <th>%</th> -->
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <!-- <th>%</th> -->
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
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <!-- <th>%</th> -->
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
            url: `<?= base_url('rad/radclaporan/lap_penerimaan_thn?tampil_per=') ?>${tampil_per}&data=${data}`,
            data: data,
            beforeSend: function() {
                $('#hasilPencarian').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
            },
            success: function(data) {
                // console.log(data);
                let html = '';
                let total_ct_bpjs = 0;
                let total_mr_bpjs = 0;
                let total_us_bpjs = 0;
                let total_la_bpjs = 0;
                let total_cr_bpjs = 0;
                let total_ct_umum = 0;
                let total_mr_umum = 0;
                let total_us_umum = 0;
                let total_la_umum = 0;
                let total_cr_umum = 0;
                let total_ct = 0;
                let total_mr = 0;
                let total_us = 0;
                let total_la = 0;
                let total_cr = 0;
                let total_jan = 0;
                
                data.map((e)=>{
                    html+=`
                        <tr>
                            <td>${e.bulan}</td>
                    
                        `;
                    
                    e.hasil.map((v)=>{
                        if(v[0]['1 Radiografi CT Scan'] !== undefined){
                            let ct_bpjs = v[0]['1 Radiografi CT Scan'].ct_bpjs==''?0:v[0]['1 Radiografi CT Scan'].ct_bpjs;
                            let ct_umum = v[0]['1 Radiografi CT Scan'].ct_umum==''?0:v[0]['1 Radiografi CT Scan'].ct_umum;
                            total_ct_bpjs = total_ct_bpjs + parseInt(ct_bpjs);
                            total_ct_umum = total_ct_umum + parseInt(ct_umum);
                            total_ct = (total_ct_bpjs + total_ct_umum);
                            var bilangan_ct_bpjs = v[0]['1 Radiografi CT Scan']!=undefined?v[0]['1 Radiografi CT Scan'].ct_bpjs:'';
                            var bilangan_ct_umum = v[0]['1 Radiografi CT Scan']!=undefined?v[0]['1 Radiografi CT Scan'].ct_umum:'';
                            var total_bln = v[0]['1 Radiografi CT Scan']!=undefined?v[0]['1 Radiografi CT Scan'].total_bln:'';
                            html+=`
                                <td>${bilangan_ct_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td>${bilangan_ct_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            `;
                        }
                        if(v[0]['2 Pencitraan MRI'] !== undefined)
                        {
                            let mr_bpjs = v[0]['2 Pencitraan MRI'].mr_bpjs==''?0:v[0]['2 Pencitraan MRI'].mr_bpjs;
                            let mr_umum = v[0]['2 Pencitraan MRI'].mr_umum==''?0:v[0]['2 Pencitraan MRI'].mr_umum;
                            total_mr_bpjs = total_mr_bpjs + parseInt(mr_bpjs);
                            total_mr_umum = total_mr_umum + + parseInt(mr_umum);
                            total_mr = (total_mr_bpjs + total_mr_umum);
                            var bilangan_mr_bpjs = v[0]['2 Pencitraan MRI']!=undefined?v[0]['2 Pencitraan MRI'].mr_bpjs:'';
                            var bilangan_mr_umum = v[0]['2 Pencitraan MRI']!=undefined?v[0]['2 Pencitraan MRI'].mr_umum:'';
                            html+=`
                                <td>${bilangan_mr_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td>${bilangan_mr_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                
                            `;
                        }
                        if(v[0]['3 USG'] !== undefined)
                        {
                            let us_bpjs = v[0]['3 USG'].us_bpjs==''?0:v[0]['3 USG'].us_bpjs;
                            let us_umum = v[0]['3 USG'].us_umum==''?0:v[0]['3 USG'].us_umum;
                            total_us_bpjs = total_us_bpjs + parseInt(us_bpjs);
                            total_us_umum = total_us_umum + + parseInt(us_umum);
                            total_us = (total_us_bpjs + total_us_umum);
                            var bilangan_us_bpjs = v[0]['3 USG']!=undefined?v[0]['3 USG'].us_bpjs:'';
                            var bilangan_us_umum = v[0]['3 USG']!=undefined?v[0]['3 USG'].us_umum:'';
                            html+=`
                                <td>${bilangan_us_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td>${bilangan_us_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            `;
                        }
                        if(v[0]['4 Radiografi Panoramic/Dental'] !== undefined)
                        {
                            let la_bpjs = v[0]['4 Radiografi Panoramic/Dental'].la_bpjs==''?0:v[0]['4 Radiografi Panoramic/Dental'].la_bpjs;
                            let la_umum = v[0]['4 Radiografi Panoramic/Dental'].la_umum==''?0:v[0]['4 Radiografi Panoramic/Dental'].la_umum;
                            total_la_bpjs = total_la_bpjs + parseInt(la_bpjs);
                            total_la_umum = total_la_umum + + parseInt(la_umum);
                            total_la = (total_la_bpjs + total_la_umum);
                            var bilangan_la_bpjs =v[0]['4 Radiografi Panoramic/Dental']!=undefined?v[0]['4 Radiografi Panoramic/Dental'].la_bpjs:'';
                            var bilangan_la_umum =v[0]['4 Radiografi Panoramic/Dental']!=undefined?v[0]['4 Radiografi Panoramic/Dental'].la_umum:'';
                            html+=`
                                <td>${bilangan_la_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td>${bilangan_la_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                
                            `;
                        }
                        if(v[0]['5 Radiografi Konvensional'] !== undefined)
                        {
                            let cr_bpjs = v[0]['5 Radiografi Konvensional'].cr_bpjs==''?0:v[0]['5 Radiografi Konvensional'].cr_bpjs;
                            let cr_umum = v[0]['5 Radiografi Konvensional'].cr_umum==''?0:v[0]['5 Radiografi Konvensional'].cr_umum;
                            total_cr_bpjs = total_cr_bpjs + parseInt(cr_bpjs);
                            total_cr_umum = total_cr_umum + + parseInt(cr_umum);
                            total_cr = (total_cr_bpjs + total_cr_umum);
                            var bilangan_cr_bpjs = v[0]['5 Radiografi Konvensional']!=undefined?v[0]['5 Radiografi Konvensional'].cr_bpjs:'';
                            var bilangan_cr_umum = v[0]['5 Radiografi Konvensional']!=undefined?v[0]['5 Radiografi Konvensional'].cr_umum:'';
                            html+=`
                                <td>${bilangan_cr_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                                <td>${bilangan_cr_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                            `;
                        }
                    });
                    
                    html+='</tr>';
                })
               // $total_jan = $total_jan + (total_ct_bpjs + total_ct_umum + total_mr_bpjs + total_mr_umum + total_us_bpjs + total_us_umum + total_la_bpjs + total_la_umum + total_cr_bpjs + total_cr_umum )
                html+=`<tr>
                        <td rowspan='2'>Jumlah</td>
                        <td>${total_ct_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_ct_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_mr_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_mr_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_us_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_us_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_la_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_la_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_cr_bpjs.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td>${total_cr_umum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                    </tr>
                    <tr>
                        <td colspan='2'>${total_ct.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td colspan='2'>${total_mr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td colspan='2'>${total_us.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td colspan='2'>${total_la.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                        <td colspan='2'>${total_cr.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>`;
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
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_penerimaan_thn');?>/'+date0, '_blank');
    } else if (tampil === 'BLN') {
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_penerimaan_bln');?>/'+date, '_blank');
    }
           
}

function get_bln(){
    var date = document.getElementById('date_picker_months').value;
    var url = "<?php echo site_url();?>rad/Radclaporan/lap_penerimaan_bln/"+date;
    table = $('#example_bln').DataTable({
        ajax: url,
        columns: [
            { data: "no" },
            { data: "modality" },
            { data: "bpjs" },
            { data: "umum" }
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