<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#date_days').show();			
	$('#date_months').hide();
    $('#example').DataTable();
});

function cek_tampil_per(val) {
    if(val === 'TGL') {
		document.getElementById("date_days").required = true;
		document.getElementById("date_months").required = false;
		$('#date_days').show();			
		$('#date_months').hide();
    } else if(val === 'BLN') {
        document.getElementById("date_days").required = false;
		document.getElementById("date_months").required = true;
		$('#date_days').hide();			
		$('#date_months').show();
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
                <?php echo form_open('lab/labclaporan/lap_jml_pemeriksaan');?>
                    <div class="row p-t-0">		
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" onchange="cek_tampil_per(this.value)" class="form-control">
                                    <option value="TGL">Tanggal</option>
                                    <option value="BLN">Bulan</option>
                                </select>
                            </div>
                        </div>								 
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="date" id="date_days" class="form-control" name="date_days">
                                <input type="month" id="date_months" class="form-control" name="date_months">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" id="btncari" name="btncari" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>	
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
					<h4 align="center">Laporan Pemeriksaan Pasien Laboratorium <b><?php echo $date ?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>       
                                    <tr>
                                        <th rowspan="3">No</th>
                                        <th rowspan="3">Jenis Pemeriksaan</th>
                                        <th colspan="9">dr. Elhuriyah, Sp. PK</th>
                                        <th colspan="9">dr. Fatimah Yasin, Sp. PK</th>
                                    </tr>
                                    <tr>
                                        <th colspan="3">Rawat Inap</th>
                                        <th colspan="3">Rawat Jalan</th>
                                        <th rowspan="2">Eksekutif</th>
                                        <th rowspan="2">Isolasi</th>
                                        <th rowspan="2">Jumlah</th>
                                        <th colspan="3">Rawat Inap</th>
                                        <th colspan="3">Rawat Jalan</th>
                                        <th rowspan="2">Eksekutif</th>
                                        <th rowspan="2">Isolasi</th>
                                        <th rowspan="2">Jumlah</th>
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
                                    </tr>                
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    $col_1 = 0;
                                    $col_2 = 0;
                                    $col_3 = 0;
                                    $col_4 = 0;
                                    $col_5 = 0;
                                    $col_6 = 0;
                                    $col_7 = 0;
                                    $col_8 = 0;
                                    $col_9 = 0;
                                    $col_10 = 0;
                                    $col_11 = 0;
                                    $col_12 = 0;
                                    $col_13 = 0;
                                    $col_14 = 0;
                                    $col_15 = 0;
                                    $col_16 = 0;
                                    $col_17 = 0;
                                    $col_18 = 0;
                                    foreach($lap_pemeriksaan as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->jenis_tindakan;?></td>
                                            <td><?php $col_1+=$row->el_ri_bpjs;echo $row->el_ri_bpjs;?></td>
                                            <td><?php $col_2+=$row->el_ri_umum;echo $row->el_ri_umum;?></td>
                                            <td><?php $col_3+=$row->el_ri_iks;echo $row->el_ri_iks;?></td>
                                            <td><?php $col_4+=$row->el_rj_bpjs;echo $row->el_rj_bpjs;?></td>
                                            <td><?php $col_5+=$row->el_rj_umum;echo $row->el_rj_umum;?></td>
                                            <td><?php $col_6+=$row->el_rj_iks;echo $row->el_rj_iks;?></td>
                                            <td><?php $col_7+=$row->el_eksekutif;echo $row->el_eksekutif;?></td>
                                            <td><?php $col_8+=$row->el_isolasi;echo $row->el_isolasi;?></td>
                                            <td><?php $col_9+=$row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum +  $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi;echo $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum +  $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi;?></td>
                                            <td><?php $col_10+=$row->f_ri_bpjs;echo $row->f_ri_bpjs;?></td>
                                            <td><?php $col_11+=$row->f_ri_umum;echo $row->f_ri_umum;?></td>
                                            <td><?php $col_12+=$row->f_ri_iks;echo $row->f_ri_iks;?></td>
                                            <td><?php $col_13+=$row->f_rj_bpjs;echo $row->f_rj_bpjs;?></td>
                                            <td><?php $col_14+=$row->f_rj_umum;echo $row->f_rj_umum;?></td>
                                            <td><?php $col_15+=$row->f_rj_iks;echo $row->f_rj_iks;?></td>
                                            <td><?php $col_16+=$row->f_eksekutif;echo $row->f_eksekutif;?></td>
                                            <td><?php $col_17+=$row->f_isolasi;echo $row->f_isolasi;?></td>
                                            <td><?php $col_18+=$row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum +  $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi;;echo $row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum +  $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi;?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="2">Jumlah</td>
                                        <td><?=$col_1 ?></td>
                                        <td><?=$col_2 ?></td>
                                        <td><?=$col_3 ?></td>
                                        <td><?=$col_4 ?></td>
                                        <td><?=$col_5 ?></td>
                                        <td><?=$col_6 ?></td>
                                        <td><?=$col_7 ?></td>
                                        <td><?=$col_8 ?></td>
                                        <td><?=$col_9 ?></td>
                                        <td><?=$col_10 ?></td>
                                        <td><?=$col_11 ?></td>
                                        <td><?=$col_12 ?></td>
                                        <td><?=$col_13 ?></td>
                                        <td><?=$col_14 ?></td>
                                        <td><?=$col_15 ?></td>
                                        <td><?=$col_16 ?></td>
                                        <td><?=$col_17 ?></td>
                                        <td><?=$col_18 ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('lab/labclaporan/excel_lap_jml_pemeriksaan/'.$tanggal.'/'.$tampil) ?>" class="btn btn-danger" target="_blank">Excel</a>				
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
    }
?>