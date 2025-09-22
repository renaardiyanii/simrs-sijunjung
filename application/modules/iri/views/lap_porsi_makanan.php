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
    $('.select2').select2();
    $('#date_months').show();
	$('#date_days').hide();
});

function cek_tampil_per(tampil_per) {
    if(tampil_per == 'TGL') {
		$('#date_days').show();
		$('#date_months').hide();
	} else if(tampil_per == 'BLN') {
		$('#date_months').show();
		$('#date_days').hide();
	}
}
</script>
<style>
hr {
	border-color:#7DBE64 !important;
} p {
    font-size: 13px;
}
</style>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-info">
			<div class="card-block">
                <?php echo form_open('iri/riclaporan/lap_porsi_makanan_gizi');?>
                    <p>Tanggal/Bulan pasien pulang</p>
                    <div class="row p-t-0">
                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="BLN">Bulan</option>
                                    <option value="TGL">Tanggal</option>
                                </select>
                            </div>
                        </div>											 -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="date_input">	
                                    <input type="month" id="date_months" class="form-control" name="date_months">
                                    <!-- <input type="date" id="date_days" class="form-control" name="date_days">	 -->
                                </div>
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
					<h4 align="center">Laporan Porsi Makanan Tindakan Gizi <b><?php echo $judul;?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>      
                                    <tr>
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Kelas Rawatan</th>
                                        <th colspan="4">Jaminan</th>
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
                                    foreach($porsi as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->kelas;?></td>
                                            <td><?php echo $row->tgl_bpjs * 3;?></td>
                                            <td><?php echo $row->tgl_umum * 3;?></td>
                                            <td><?php echo $row->tgl_iks * 3;?></td>
                                            <td><?php echo ($row->tgl_bpjs + $row->tgl_umum + $row->tgl_iks) * 3;?></td>
                                        </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_lap_porsi_gizi/'.$date);?>" class="btn btn-danger" target="_blank">Excel</a>				
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