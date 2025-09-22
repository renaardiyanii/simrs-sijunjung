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
    $('#date_days').show();
	$('#date_months').hide();
});

function cek_tampil_per(tampil_per) {
    // console.log(tampil_per);
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
                <?php echo form_open('iri/riclaporan/lap_kegiatan_mpp');?>
                    <p>Tanggal/Bulan Keluar Pasien</p>
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
                                    <input type="date" id="date_days" class="form-control" name="date_days">	
                                    <input type="month" id="date_months" class="form-control" name="date_months">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <select name="petugas" id="petugas" class="form-control select2">
                                    <option value="">-- Pilih Petugas --</option>
                                    <option value="semua">SEMUA</option>
                                    <?php
                                    foreach($petugas as $r) {
                                        echo '<option value="'.$r->userid.'-'.$r->name.'">'.$r->name.'</option>';
                                    }
                                    ?>
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
					<h4 align="center">Laporan Kegiatan Manejer Pelayanan Pasien <b><?php echo $date;?></b> | <?php echo $nama_petugas;?></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>      
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No RM</th>
                                        <th>Diagnosa</th>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Keluar</th>
                                        <th>Formulir</th>
                                        <th>Ruangan</th>
                                        <th>Petugas MPP</th>
                                        <th>Ket</th>
                                    </tr>                                
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach($lap_mpp as $row) { 
                                        $mpp = isset($row->formjson)?json_decode($row->formjson):null; ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->nama;?></td>
                                            <td><?php echo $row->no_medrec;?></td>
                                            <td><?php echo isset($mpp->diagnosa)?str_replace("\n", "<br>", $mpp->diagnosa):'';?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row->tgl_masuk));?></td>
                                            <td><?php echo isset($row->tgl_keluar)?date("d-m-Y", strtotime($row->tgl_keluar)):'';?></td>
                                            <td>Form A</td>
                                            <td><?php echo $row->nmruang;?></td>
                                            <td><?php echo $row->petugas_mpp;?></td>
                                            <td><?php echo $row->keadaanpulang;?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_lap_kegiatan_mpp/'.$tampil.'/'.$tanggal.'/'.$petugas_mpp);?>" class="btn btn-danger" target="_blank">Excel</a>				
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