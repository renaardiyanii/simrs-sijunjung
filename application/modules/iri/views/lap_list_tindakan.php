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
    $('.select2').select2();
    $('#example').DataTable();
});

function cek_tampil_per(val_tampil_per){
	if(val_tampil_per=='TGL'){
		$('#date_days').show();
		$('#date_months').hide();
	}else if(val_tampil_per=='BLN'){
		$('#date_months').show();
		$('#date_days').hide();
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
                <?php echo form_open('iri/riclaporan/list_tindakan');?>
                <p>Tanggal/Bulan pasien pulang</p>
                    <div class="row p-t-0">
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="TGL">Tanggal</option>
                                    <option value="BLN">Bulan</option>
                                </select>
                            </div>
                        </div>											
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">
                                    <input type="month" id="date_months" class="form-control" name="date_months">
                                    <input type="date" id="date_days" class="form-control" name="date_days">		
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="ruang" id="ruang" class="form-control select2">
                                    <option value="">-- Pilih Ruang --</option>
                                    <option value="semua">SEMUA</option>
                                    <?php
                                    foreach($list_ruang as $r) {
                                        echo '<option value="'.$r->idrg.'-'.$r->nmruang.'">'.$r->nmruang.'</option>';
                                    }
                                    ?>
                                </select>
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
                     
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
				<div class="card-title" align="center" >
					<h4 align="center">Laporan Tindakan Rawat Inap <b><?php echo $date_title; echo $nmruang;?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">No</th>
                                            <th rowspan="2">Nama Tindakan</th>
                                            <th rowspan="2">Ruangan</th>
                                            <th rowspan="2">Kelas</th>
                                            <th rowspan="2">Tarif RS</th>
                                            <th colspan="4">Kelompok Jaminan</th>
                                            <th rowspan="2">Total Pendapatan</th>
                                        </tr>    
                                        <tr>
                                            <th>BPJS</th>
                                            <th>UMUM</th>
                                            <th>IKS</th>
                                            <th>Total</th>
                                        </tr>                              
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        $total_bpjs = 0;
                                        $total_umum = 0;
                                        $total_iks = 0;
                                        $total = 0;
                                        $tarif_rs = 0;
                                        $total_tarif = 0;
                                        foreach($tindakan as $row) { 
                                            $total_bpjs += $row->bpjs;
                                            $total_umum += $row->umum;
                                            $total_iks += $row->iks;
                                            $total += $row->bpjs + $row->umum + $row->iks;
                                            $tarif_rs += $row->tarif_rs;
                                            $total_tarif += ($row->bpjs + $row->umum + $row->iks) * $row->tarif_rs;?>
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->nmtindakan;?></td>
                                                <td><?php echo $row->nmruang;?></td>
                                                <td><?php echo $row->kelas;?></td>
                                                <td><?php echo number_format($row->tarif_rs);?></td>
                                                <td><?php echo $row->bpjs;?></td>
                                                <td><?php echo $row->umum;?></td>
                                                <td><?php echo $row->iks;?></td>
                                                <td><?php echo $row->bpjs + $row->umum + $row->iks;?></td>
                                                <td><?php echo number_format(($row->bpjs + $row->umum + $row->iks) * $row->tarif_rs);?></td>
                                            </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="4"><b>Grand Total</b></td>
                                        <td><?php echo number_format($tarif_rs);?></td>
                                        <td><?php echo $total_bpjs;?></td>
                                        <td><?php echo $total_umum;?></td>
                                        <td><?php echo $total_iks;?></td>
                                        <td><?php echo $total;?></td>
                                        <td><?php echo number_format($total_tarif);?></td>
                                    </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_list_tindakan/'.$date.'/'.$tampil.'/'.$idrg);?>" class="btn btn-danger">Excel</a>				
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