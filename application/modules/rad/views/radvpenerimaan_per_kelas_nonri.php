<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    //const monthControl = document.querySelector('input[type="month"]');
    // $('.date_day_pickers').datepicker({
    //     format: "yyyy-mm-dd",
    //     autoclose: true,
    //     todayHighlight: true,
    //     minDate: '0'
    // });
    $('#example').DataTable();
   
});

// function cek_tampil_per(val_tampil_per){
// 	    if(val_tampil_per=='MR'){
// 			//alert("bln");
//             $('#mri').show();
//             $('#hasilPencarianMRI').show();
//             $('#hasilPencarian').hide();
//             $('#bukan_mri').hide();
// 		}else{
// 			$('#bukan_mri').show();
//             $('#mri').hide();
//             $('#hasilPencarianMRI').hide();
//             $('#hasilPencarian').show();
// 		}
// 	}

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
                <?php //echo form_open('rad/Radclaporan/lap_utilisasi');?>
                <form id="cariLapJmlExpert">
                    <div class="row p-t-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control">
                                    <!-- <option value="TGL">Tanggal</option> -->
                                    <option value="BLN">Bulan</option>
                                    <!-- <option value="THN">Tahun</option> -->
                                </select>
                            </div>
                        </div>											
                        <div class="col-md-3">
                            <div class="form-group">
                                <!-- <div id="date_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days" required >	
                                </div> -->
                                <div id="month_input">
                                    <!-- <label for="date_picker_months">Bulan</label> -->
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
                                    <br><p>Format Tanggal : YYYY-MM</p>
                                    <p>Contoh : 2022-01</p>
                                </div>
                                <!-- <div id="year_input">
                                    <input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">				
                                </div> -->
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-actions">
                                <select name="modality" id="modality" class="form-control">
                                    <option>-- Pilih Modality --</option>
                                    <option value="CT">CT Scan</option>
                                    <option value="MR">MRI</option>
                                    <option value="US">USG</option>
                                    <option value="LA">Radiologi Panoramik</option>
                                    <option value="CR-DX">Radiologi Konvensional</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-actions">
                                <!-- <button type class="btn btn-primary" type="button" id="cariLapJmlExpertButton">Cari</button> -->
                                <button id="btncari" class="btn btn-primary" type="button" onclick="get_bln()">Cari</button>
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
					<h4 align="center">Laporan Penerimaan Non Rawat Inap</h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" style="width:100%;" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">NO</th>
                                            <th rowspan="3">Jenis Pemeriksaan</th>
                                            <th colspan="6">POLI</th>
                                            <th colspan="6">Luar</th>
                                            <th colspan="6">IGD</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3">UMUM</th>
                                            <th colspan="3">BPJS</th>
                                            <th colspan="3">UMUM</th>
                                            <th colspan="3">BPJS</th>
                                            <th colspan="3">UMUM</th>
                                            <th colspan="3">BPJS</th>
                                        </tr>
                                        <tr>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
                                            <th>JML</th>
                                            <th>Tarif</th>
                                            <th>Penerimaan</th>
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
    
    // $('#cariLapJmlExpertButton').click(function(){
    //     let tampil_per = $('#modality').val();
    //     let data = $('#date_picker_months').val();
    //     // console.log(data);

    //     $.ajax({
    //         url: `<?php //echo base_url('rad/radclaporan/lap_utilitas_bln?tampil_per=') ?>${tampil_per}&data=${data}`,
    //         data: data,
    //         beforeSend: function() {
    //             if(tampil_per === 'MR') {
    //                 $('#hasilPencarianMRI').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
    //             } else {
    //                 $('#hasilPencarian').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
    //             }
    //         },
    //         success: function(data) {
    //             // console.log(data);
    //             let html = '';
                
    //             data.map((e)=>{
    //                 html+=`
    //                     <tr>
    //                         <td>${e.modality}</td>
    //                     `;
                    
    //                 e.hasil.map((v)=>{
    //                     if(v[0]['1'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['1'].jml==''?'':v[0]['1'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['2'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['2'].jml==''?'':v[0]['2'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['3'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['3'].jml==''?'':v[0]['3'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['4'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['4'].jml==''?'':v[0]['4'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['5'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['5'].jml==''?'':v[0]['5'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['6'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['6'].jml==''?'':v[0]['6'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['7'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['7'].jml==''?'':v[0]['7'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['8'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['8'].jml==''?'':v[0]['8'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['9'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['9'].jml==''?'':v[0]['9'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['10'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['10'].jml==''?'':v[0]['10'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['11'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['11'].jml==''?'':v[0]['11'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['12'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['12'].jml==''?'':v[0]['12'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['13'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['13'].jml==''?'':v[0]['13'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['14'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['14'].jml==''?'':v[0]['14'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['15'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['15'].jml==''?'':v[0]['15'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['16'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['16'].jml==''?'':v[0]['16'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['17'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['17'].jml==''?'':v[0]['17'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['18'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['18'].jml==''?'':v[0]['18'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['19'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['19'].jml==''?'':v[0]['19'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['20'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['20'].jml==''?'':v[0]['20'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['21'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['21'].jml==''?'':v[0]['21'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['22'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['22'].jml==''?'':v[0]['22'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['23'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['23'].jml==''?'':v[0]['23'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['24'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['24'].jml==''?'':v[0]['24'].jml}</td>
    //                         `;
    //                     }if(v[0]['25'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['25'].jml==''?'':v[0]['25'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['26'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['26'].jml==''?'':v[0]['26'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['27'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['27'].jml==''?'':v[0]['27'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['28'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['28'].jml==''?'':v[0]['28'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['29'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['29'].jml==''?'':v[0]['29'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['30'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['30'].jml==''?'':v[0]['30'].jml}</td>
    //                         `;
    //                     }
    //                     if(v[0]['31'] !== undefined){
    //                         html+=`
    //                             <td>${v[0]['31'].jml==''?'':v[0]['31'].jml}</td>
    //                         `;
    //                     }
    //                 });
    //                html+=`<td>${e.rata}</td>
    //                     <td>${e.hari_kerja}</td>
    //                     <td>${e.total}</td>`;
    //                 html+='</tr>';
    //             })
    //             //html+=`<td>${rata}</td>`;
    //            // $total_jan = $total_jan + (total_ct_bpjs + total_ct_umum + total_mr_bpjs + total_mr_umum + total_us_bpjs + total_us_umum + total_la_bpjs + total_la_umum + total_cr_bpjs + total_cr_umum )
    //             if(tampil_per !== 'MR') {
    //                 $('#hasilPencarian').html(html);
    //             } else {
    //                 $('#hasilPencarianMRI').html(html);
    //             }
    //         },
    //         error: function(xhr) { 
    //         },
    //         complete: function() {
    //         },
    //     });
    // })
    
function down_excel(){
	//var date0 = document.getElementById('date_picker_years').value;
    var date = document.getElementById('date_picker_months').value;
    var tampil = document.getElementById('modality').value;
    

    window.open('<?php echo site_url('rad/Radclaporan/excel_lap_penerimaan_per_kelas_nonri');?>/'+date+'/'+tampil, '_blank');

}

function get_bln(){
    $('#example').DataTable();
    var modal = $('#modality').val();
    var date = $('#date_picker_months').val();
    var url = "<?php echo site_url();?>rad/radclaporan/lap_penerimaan_per_kelas_mod_nonri/"+date+"/"+modal;
   	    
    $.ajax({
        url: url,
        beforeSend: function() {
            $('#btncari').attr('disabled',true);
            $('#btncari').html('Loading....');
        },
        success: function(data) {
            // console.log(data);
            data = JSON.parse(data);
            $('#tbodyexample').html('');
            let html = '';
            if(data.data.length>0){
                data.data.map((e)=>{
                    html+=`
                    <tr>
                        <td>${e.no}</td>
                        <td>${e.jenis_tindakan}</td>
                        <td>${e.jml_umum_rj}</td>
                        <td>${e.sat_umum_rj}</td>
                        <td>${e.total_umum_rj}</td>
                        <td>${e.jml_bpjs_rj}</td>
                        <td>${e.sat_bpjs_rj}</td>
                        <td>${e.total_bpjs_rj}</td>
                        <td>${e.jml_umum_luar}</td>
                        <td>${e.sat_umum_luar}</td>
                        <td>${e.total_umum_luar}</td>
                        <td>${e.jml_bpjs_luar}</td>
                        <td>${e.sat_bpjs_luar}</td>
                        <td>${e.total_bpjs_luar}</td>
                        <td>${e.jml_umum_rd}</td>
                        <td>${e.sat_umum_rd}</td>
                        <td>${e.total_umum_rd}</td>
                        <td>${e.jml_bpjs_rd}</td>
                        <td>${e.sat_bpjs_rd}</td>
                        <td>${e.total_bpjs_rd}</td>
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