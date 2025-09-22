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
    $('#example_bln').DataTable();
    $('#mri').hide();
    $('#bukan_mri').show();
});

function cek_tampil_per(val_tampil_per){
	    if(val_tampil_per=='MR'){
			//alert("bln");
            $('#mri').show();
            $('#hasilPencarianMRI').show();
            $('#hasilPencarian').hide();
            $('#bukan_mri').hide();
		}else{
			$('#bukan_mri').show();
            $('#mri').hide();
            $('#hasilPencarianMRI').hide();
            $('#hasilPencarian').show();
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
                <?php //echo form_open('rad/Radclaporan/lap_utilisasi');?>
                <form id="cariLapJmlExpert">
                    <div class="row p-t-0">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
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
                                <select name="modality" id="modality" class="form-control" onchange="cek_tampil_per(this.value)">
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
                                <button class="btn btn-primary" type="button" id="cariLapJmlExpertButton">Cari</button>
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
					<h4 align="center" id="tgl_periksa">Laporan Utilisasi Radiologi</h4></div>					
                    <div class="panel-body" id="mri">
                        <div class="table-responsive m-t-15">
                            <table id="example_bln" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>TGL</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>
                                            <th>11</th>
                                            <th>12</th>
                                            <th>13</th>
                                            <th>14</th>
                                            <th>15</th>
                                            <th>16</th>
                                            <th>17</th>
                                            <th>18</th>
                                            <th>19</th>
                                            <th>20</th>
                                            <th>21</th>
                                            <th>22</th>
                                            <th>23</th>
                                            <th>24</th>
                                            <th>25</th>
                                            <th>26</th>
                                            <th>27</th>
                                            <th>28</th>
                                            <th>29</th>
                                            <th>30</th>
                                            <th>31</th>
                                            <th>Rata Rata</th>
                                            <th rowspan="2">JML HARI KERJA</th>
                                            <th rowspan="2">JML PEMERIKSAAN</th>
                                        </tr>
                                        <tr>
                                            <th>LIMIT</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                            <th>5</th>
                                        </tr>
                                    </thead>
                                    <tbody id="hasilPencarianMRI">
                                       
                                    </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="panel-body" id="bukan_mri">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>TGL</th>
                                            <th>1</th>
                                            <th>2</th>
                                            <th>3</th>
                                            <th>4</th>
                                            <th>5</th>
                                            <th>6</th>
                                            <th>7</th>
                                            <th>8</th>
                                            <th>9</th>
                                            <th>10</th>
                                            <th>11</th>
                                            <th>12</th>
                                            <th>13</th>
                                            <th>14</th>
                                            <th>15</th>
                                            <th>16</th>
                                            <th>17</th>
                                            <th>18</th>
                                            <th>19</th>
                                            <th>20</th>
                                            <th>21</th>
                                            <th>22</th>
                                            <th>23</th>
                                            <th>24</th>
                                            <th>25</th>
                                            <th>26</th>
                                            <th>27</th>
                                            <th>28</th>
                                            <th>29</th>
                                            <th>30</th>
                                            <th>31</th>
                                            <th>Rata Rata</th>
                                            <th rowspan="2">JML HARI KERJA</th>
                                            <th rowspan="2">JML PEMERIKSAAN</th>
                                        </tr>
                                        <tr>
                                            <th>LIMIT</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="hasilPencarian">
                                       
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
    
    $('#cariLapJmlExpertButton').click(function(){
        let tampil_per = $('#modality').val();
        let data = $('#date_picker_months').val();
        // console.log(data);

        $.ajax({
            url: `<?= base_url('rad/radclaporan/lap_utilitas_bln?tampil_per=') ?>${tampil_per}&data=${data}`,
            data: data,
            beforeSend: function() {
                if(tampil_per === 'MR') {
                    $('#hasilPencarianMRI').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
                } else {
                    $('#hasilPencarian').html('<tr><td colspan="5" style="text-align:center;">Sedang Mengambil Data...</td></tr>');
                }
            },
            success: function(data) {
                // console.log(data);
                let html = '';
                
                data.map((e)=>{
                    html+=`
                        <tr>
                            <td>${e.modality}</td>
                        `;
                    
                    e.hasil.map((v)=>{
                        if(v[0]['1'] !== undefined){
                            html+=`
                                <td>${v[0]['1'].jml==''?'':v[0]['1'].jml}</td>
                            `;
                        }
                        if(v[0]['2'] !== undefined){
                            html+=`
                                <td>${v[0]['2'].jml==''?'':v[0]['2'].jml}</td>
                            `;
                        }
                        if(v[0]['3'] !== undefined){
                            html+=`
                                <td>${v[0]['3'].jml==''?'':v[0]['3'].jml}</td>
                            `;
                        }
                        if(v[0]['4'] !== undefined){
                            html+=`
                                <td>${v[0]['4'].jml==''?'':v[0]['4'].jml}</td>
                            `;
                        }
                        if(v[0]['5'] !== undefined){
                            html+=`
                                <td>${v[0]['5'].jml==''?'':v[0]['5'].jml}</td>
                            `;
                        }
                        if(v[0]['6'] !== undefined){
                            html+=`
                                <td>${v[0]['6'].jml==''?'':v[0]['6'].jml}</td>
                            `;
                        }
                        if(v[0]['7'] !== undefined){
                            html+=`
                                <td>${v[0]['7'].jml==''?'':v[0]['7'].jml}</td>
                            `;
                        }
                        if(v[0]['8'] !== undefined){
                            html+=`
                                <td>${v[0]['8'].jml==''?'':v[0]['8'].jml}</td>
                            `;
                        }
                        if(v[0]['9'] !== undefined){
                            html+=`
                                <td>${v[0]['9'].jml==''?'':v[0]['9'].jml}</td>
                            `;
                        }
                        if(v[0]['10'] !== undefined){
                            html+=`
                                <td>${v[0]['10'].jml==''?'':v[0]['10'].jml}</td>
                            `;
                        }
                        if(v[0]['11'] !== undefined){
                            html+=`
                                <td>${v[0]['11'].jml==''?'':v[0]['11'].jml}</td>
                            `;
                        }
                        if(v[0]['12'] !== undefined){
                            html+=`
                                <td>${v[0]['12'].jml==''?'':v[0]['12'].jml}</td>
                            `;
                        }
                        if(v[0]['13'] !== undefined){
                            html+=`
                                <td>${v[0]['13'].jml==''?'':v[0]['13'].jml}</td>
                            `;
                        }
                        if(v[0]['14'] !== undefined){
                            html+=`
                                <td>${v[0]['14'].jml==''?'':v[0]['14'].jml}</td>
                            `;
                        }
                        if(v[0]['15'] !== undefined){
                            html+=`
                                <td>${v[0]['15'].jml==''?'':v[0]['15'].jml}</td>
                            `;
                        }
                        if(v[0]['16'] !== undefined){
                            html+=`
                                <td>${v[0]['16'].jml==''?'':v[0]['16'].jml}</td>
                            `;
                        }
                        if(v[0]['17'] !== undefined){
                            html+=`
                                <td>${v[0]['17'].jml==''?'':v[0]['17'].jml}</td>
                            `;
                        }
                        if(v[0]['18'] !== undefined){
                            html+=`
                                <td>${v[0]['18'].jml==''?'':v[0]['18'].jml}</td>
                            `;
                        }
                        if(v[0]['19'] !== undefined){
                            html+=`
                                <td>${v[0]['19'].jml==''?'':v[0]['19'].jml}</td>
                            `;
                        }
                        if(v[0]['20'] !== undefined){
                            html+=`
                                <td>${v[0]['20'].jml==''?'':v[0]['20'].jml}</td>
                            `;
                        }
                        if(v[0]['21'] !== undefined){
                            html+=`
                                <td>${v[0]['21'].jml==''?'':v[0]['21'].jml}</td>
                            `;
                        }
                        if(v[0]['22'] !== undefined){
                            html+=`
                                <td>${v[0]['22'].jml==''?'':v[0]['22'].jml}</td>
                            `;
                        }
                        if(v[0]['23'] !== undefined){
                            html+=`
                                <td>${v[0]['23'].jml==''?'':v[0]['23'].jml}</td>
                            `;
                        }
                        if(v[0]['24'] !== undefined){
                            html+=`
                                <td>${v[0]['24'].jml==''?'':v[0]['24'].jml}</td>
                            `;
                        }if(v[0]['25'] !== undefined){
                            html+=`
                                <td>${v[0]['25'].jml==''?'':v[0]['25'].jml}</td>
                            `;
                        }
                        if(v[0]['26'] !== undefined){
                            html+=`
                                <td>${v[0]['26'].jml==''?'':v[0]['26'].jml}</td>
                            `;
                        }
                        if(v[0]['27'] !== undefined){
                            html+=`
                                <td>${v[0]['27'].jml==''?'':v[0]['27'].jml}</td>
                            `;
                        }
                        if(v[0]['28'] !== undefined){
                            html+=`
                                <td>${v[0]['28'].jml==''?'':v[0]['28'].jml}</td>
                            `;
                        }
                        if(v[0]['29'] !== undefined){
                            html+=`
                                <td>${v[0]['29'].jml==''?'':v[0]['29'].jml}</td>
                            `;
                        }
                        if(v[0]['30'] !== undefined){
                            html+=`
                                <td>${v[0]['30'].jml==''?'':v[0]['30'].jml}</td>
                            `;
                        }
                        if(v[0]['31'] !== undefined){
                            html+=`
                                <td>${v[0]['31'].jml==''?'':v[0]['31'].jml}</td>
                            `;
                        }
                    });
                   html+=`<td>${e.rata}</td>
                        <td>${e.hari_kerja}</td>
                        <td>${e.total}</td>`;
                    html+='</tr>';
                })
                //html+=`<td>${rata}</td>`;
               // $total_jan = $total_jan + (total_ct_bpjs + total_ct_umum + total_mr_bpjs + total_mr_umum + total_us_bpjs + total_us_umum + total_la_bpjs + total_la_umum + total_cr_bpjs + total_cr_umum )
                if(tampil_per !== 'MR') {
                    $('#hasilPencarian').html(html);
                } else {
                    $('#hasilPencarianMRI').html(html);
                }
            },
            error: function(xhr) { 
            },
            complete: function() {
            },
        });
    })
    
function down_excel(){
	//var date0 = document.getElementById('date_picker_years').value;
    var date = document.getElementById('date_picker_months').value;
    var tampil = document.getElementById('modality').value;
    
    //if(tampil === 'THN') {
        window.open('<?php echo site_url('rad/Radclaporan/excel_lap_utilitas');?>/'+date+'/'+tampil, '_blank');
    // } else if (tampil === 'BLN') {
    //     window.open('<?php echo site_url('rad/Radclaporan/excel_lap_penerimaan_bln');?>/'+date, '_blank');
    // }
           
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