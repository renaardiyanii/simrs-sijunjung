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
	$('#date_picker_months').hide();
});

function cek_tampil_per(val) {
    if(val == 'Tanggal') {
        document.getElementById("date_picker_months").value = '';
		document.getElementById("date_picker_days").required = true;
		document.getElementById("date_picker_months").required = false;
		$('#date_picker_days').show();			
		$('#date_picker_months').hide();
    } else if(val == 'Bulan') {
        document.getElementById("date_picker_days").value = '';
		document.getElementById("date_picker_months").required = true;
		document.getElementById("date_picker_days").required = false;
		$('#date_picker_days').hide();			
		$('#date_picker_months').show();
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
                <?php echo form_open('rad/radclaporan/lap_pasien_luar');?>
                    <div class="row p-t-0">		
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="tipe" id="tipe" class="form-control"  onchange="cek_tampil_per(this.value)">
                                    <option value="Tanggal">Harian</option>
                                    <option value="Bulan">Bulanan</option>
                                </select>
                            </div>
                        </div>						
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_picker_days" class="form-control" placeholder="Bulan" name="date">	
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="month">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" id="btncari" type="submit">Search</button>
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
					<h4 align="center">Laporan Pasien Luar <?php echo $tipe;?><b> <?php echo $judul;?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>No Register</th>
                                        <th>Nama</th>
                                        <th>Tgl Kunjungan</th>
                                        <th>Pemeriksaan</th>
                                        <th>Tgl Pemeriksaan</th>
                                        <th>Jaminan</th>
                                        <th>Modality</th>
                                        <th>Tgl Dibaca</th>
                                        <th>Dokter</th>
                                        <th>Kontraktor</th>
                                    </tr>                                       
                                </thead>
                                <tbody id="tbodyexample">
                                    <?php
                                    $i = 1;
                                    foreach($pasien_luar as $row) { ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->no_register;?></td>
                                            <td><?php echo $row->nama;?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row->tgl_kunjungan));?></td>
                                            <td><?php echo $row->jenis_tindakan;?></td>
                                            <td><?php 
                                            if($row->tgl_generate != NULL) {
                                                echo date('d-m-Y', strtotime($row->tgl_generate));
                                            } else {
                                                echo '';
                                            }?></td>
                                            <td><?php echo $row->cara_bayar;?></td>
                                            <td><?php echo $row->modality;?></td>
                                            <td><?php 
                                            if($row->tanggal_isi != NULL) {
                                                echo date('d-m-Y', strtotime($row->tanggal_isi));
                                            } else {
                                                echo '';
                                            }?></td>
                                            <td><?php echo $row->nm_dokter;?></td>
                                            <td><?php echo $row->nmkontraktor;?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('rad/radclaporan/excel_lap_pasien_luar/'.$tipe.'/'.$date); ?>" class="btn btn-danger" target="_blank">Excel</a>				
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