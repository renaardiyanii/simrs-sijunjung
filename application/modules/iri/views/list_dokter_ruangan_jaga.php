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
                <?php echo form_open('iri/riclaporan/list_dokter_ruangan_jaga');?>
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
                                <select name="id_dokter" id="id_dokter" class="form-control select2">
                                    <option value="">-- Pilih Petugas --</option>
                                    <option value="semua">SEMUA</option>
                                    <?php
                                    foreach($dokter_umum as $r) {
                                        echo '<option value="'.$r->id_dokter.'-'.$r->nm_dokter.'">'.$r->nm_dokter.'</option>';
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
					<h4 align="center">Laporan Pasien Dokter Ruangan / Dokter Jaga IGD <b><?php echo $date_title; echo $nmdokter;?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                                <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No RM</th>
                                            <th>Nama</th>
                                            <th>Kelamin</th>
                                            <th>Jaminan</th>
                                            <th>Ruangan</th>
                                            <th>Kelas</th>
                                            <th>Asuhan Medis Dlm Bentuk SOAP Yg Dilakukan</th>
                                            <th>Pengkajian Awal Medis</th>
                                            <th>Pasien Pulang Yg Dientrikan Diagnosis</th>
                                            <th>Melakukan Tindakan Emergency</th>
                                            <th>Kelengkapan Rekam Medis</th>
                                            <th>Kepatuhan Pelaksanaan Tebak</th>
                                            <th>Respon Tim Sisrute <= 1 Jam</th>
                                            <th>Petugas</th>
                                            <th>Tgl Masuk</th>
                                            <th>Tgl Keluar</th>
                                        </tr>                             
                                    </thead>
                                    <tbody>
                                    <?php
                                        $i = 1;
                                        foreach($list_dokter as $row) { ?> 
                                            <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row->no_medrec;?></td>
                                                <td><?php echo $row->nama;?></td>
                                                <td><?php echo $row->sex;?></td>
                                                <td><?php echo $row->carabayar;?></td>
                                                <?php 
                                                $ruang = explode("@",$row->nm_ruang);
                                                if(isset($ruang[1])){
                                                    $ruangan = $ruang[1];
                                                }else{
                                                    $ruang2 = explode("-",$row->nm_ruang);
                                                    if(isset($ruang2[1])){
                                                        $ruangan = $ruang2[1];
                                                    }else{
                                                        $ruangan = $row->nm_ruang;
                                                    }
                                                   
                                                    
                                                }
                                                ?>
                                                <td><?php echo $ruangan;?></td>
                                                <td><?php echo $row->klsiri;?></td>
                                                <td><?php if($row->soap >= 1) {
                                                    echo 'Ada';
                                                } else {
                                                    echo 'Tidak';
                                                }
                                                ?></td>
                                                <td><?php if($row->medis >= 1) {
                                                    echo 'Ada';
                                                } else {
                                                    echo 'Tidak';
                                                }
                                                ?></td>
                                                <td><?php if($row->diagnosa >= 1) {
                                                    echo 'Ada';
                                                } else {
                                                    echo 'Tidak';
                                                }
                                                ?></td>
                                                <td><?php if($row->soap_emergency >= 1) {
                                                    echo 'Ada';
                                                } else {
                                                    echo 'Tidak';
                                                }
                                                ?></td>
                                                <td>
                                                <?php if($row->rm >= 1) {
                                                    echo 'Ada';
                                                } else {
                                                    echo 'Tidak';
                                                }
                                                ?>
                                                </td>
                                                <td><?php if($row->tebak >= 1) {
                                                   echo 'Ada';
                                                    } else {
                                                        echo 'Tidak';
                                                    }
                                                ?></td>
                                                <td><?php if($row->sisrute >= 1) {
                                                    echo 'Ada';
                                                     } else {
                                                    
                                                        echo 'Tidak';
                                                  
                                                } ?></td>
                                                <td><?php echo $row->petugas;?></td>
                                                <td><?php echo date("d-m-Y", strtotime($row->tgl_masuk));?></td>
                                                <td><?php echo isset($row->tgl_keluar)?date("d-m-Y", strtotime($row->tgl_keluar)):'';?></td>
                                            </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_list_dokter_ruangan_jaga/'.$date.'/'.$tampil.'/'.$id_dokter);?>" class="btn btn-danger" target="_blank">Excel</a>				
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