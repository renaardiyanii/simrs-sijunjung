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
    $('#example').DataTable({
        fixedHeader: {
            header: true,
            footer: true
        }
    });
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
                <?php echo form_open('elektromedik/emclaporan/lap_jml_tindakan');?>
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
					<h4 align="center">Laporan Jumlah Tindakan Elektromedik Berdasarkan DPJP <b><?php echo $date_title ?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>       
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Tindakan</th>
                                        <th rowspan="2">DPJP</th>
                                        <th rowspan="2">Ket DPJP</th>
                                        <th colspan="3">Kelompok Jaminan</th>
                                        <th rowspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <th>BPJS</th>
                                        <th>UMUM</th>
                                        <th>IKS</th>
                                    </tr>        
                                </thead>
                                <tbody>
                                <?php
                                    $i = 1;
                                    $bpjs = 0;
                                    $umum = 0;
                                    $iks = 0;
                                    $total_count = 0;
                                    foreach($list_tindakan as $row) { 
                                        $total = $row->bpjs + $row->umum + $row->iks;
                                        $bpjs += $row->bpjs;
                                        $umum += $row->umum;
                                        $iks += $row->iks;
                                        $total_count += $total;?> 
                                        <tr>
                                            <td><?php echo $i++?></td>
                                            <td><?php echo $row->tindakan;?></td>
                                            <td><?php echo $row->dokter;?></td>
                                            <td><?php echo $row->ket;?></td>
                                            <td><?php echo $row->bpjs;?></td>
                                            <td><?php echo $row->umum;?></td>
                                            <td><?php echo $row->iks;?></td>
                                            <td><?php echo $total;?></td>
                                        </tr>
                                <?php } ?>
                                    <tr>
                                        <td colspan="4"><b>Grand Total</b></td>
                                        <td><?php echo $bpjs;?></td>
                                        <td><?php echo $umum;?></td>
                                        <td><?php echo $iks;?></td>
                                        <td><?php echo $total_count;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>		
                    
                    <a href="<?php echo base_url('elektromedik/emclaporan/excel_jml_tindakan/'.$date.'/'.$tampil) ?>" class="btn btn-danger" target="_blank">Excel</a>				
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