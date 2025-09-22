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
    $('#date_picker_days').show();
    $('.select2').select2({
        placeholder: "Pilih Unit Kerja",
        allowClear: true,
    });
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
<style>
hr {
	border-color:#7DBE64 !important;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('umc/cumcicilan/lap_realisasi_unit_kerja_exe');?>
                    <div class="row p-t-0">	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days1" class="form-control" placeholder="Bulan" name="date_picker_days1">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days2" class="form-control" placeholder="Bulan" name="date_picker_days2">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="unit_kerja" id="unit_kerja" class="form-control select2" placeholder="pilih unit kerja">
                                    <option value="">-- piih Unit Kerja --</option>
                                    <?php
									foreach ($rj_poli as $r) {
										echo '<option value="POLI_'.$r->id_poli.'_'.$r->nm_poli.'">POLI '.$r->nm_poli.'</option>';
									}
                                    foreach ($ruang as $r1) {
										echo '<option value="RUANG_'.$r1->idrg.'_'.$r1->nmruang.'">'.$r1->nmruang.'</option>';
									}
                                    foreach ($rehab as $r2) {
										echo '<option value="INSREHAB_'.$r2->sub_kelompok.'">Ins Rehab - '.$r2->sub_kelompok.'</option>';
									}
									?>
                                    <option value="UDT">Ins. UDT</option>
                                    <option value="LAB">Ins. Laboratorium</option>
                                    <option value="RAD">Ins. Radiologi</option>
                                    <option value="OK">Ins. Bedah</option>
                                    <option value="FAR">Ins. Farmasi</option>
                                    <option value="GIZI">Ins. Gizi</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
			</div>			
		</div>						
	</div>
</div>
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center"><?php echo $date_title ?></h4></div>					
                    <div class="panel-body">
                        <!-- <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No.</th>
                                            <th rowspan="2">Tindakan</th>
                                            <th rowspan="2">Total Vol.</th>
                                            <th colspan="3">Volume</th>
                                            <th colspan="3">Penerimaan</th>
                                        </tr>   
                                        <tr>
                                            <td>BPJS</td>
                                            <td>UMUM</td>
                                            <td>IKS</td>
                                            <td>BPJS</td>
                                            <td>UMUM</td>
                                            <td>IKS</td>
                                        </tr>                                    
                                    </thead>
                                    <tbody id="tbodyexample">
                                    </tbody>
                                </table>
                        </div><br> -->
                        <?php include("isi_laprealisasi_unit_kerja.php");?>
                    </div>	
                    <!-- <a href="<?= base_url('iri/riclaporan/excel_lap_realisasi_potensi_bpjs/'.$object.'/'.$date1.'/'.$date2); ?>" class="btn btn-success" target="_blank">Excel</a>			 -->
				</div>
			</div>
		</div>	 	
	</div>	 	
</div><!-- end row -->
    
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }?>