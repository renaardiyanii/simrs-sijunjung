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
                <?php echo form_open('iri/riclaporan/lap_pasien_pulang_rawat_inap');?>
                    <p>Tanggal/Bulan pulang</p>
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
					<h4 align="center">Laporan Pasien Pulang RI <b><?php echo $date;?></b></h4></div>					
                    <div class="panel-body">
                        <div class="table-responsive m-t-15">
                            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                                <thead>      
                                    <tr>
                                        <th>No</th>
                                        <th>No Register</th>
                                        <th>No RM</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat Kota</th>
                                        <th>Jaminan</th>
                                        <th>Ruangan</th>
                                        <th>Kelas</th>
                                        <th>Jatah Kelas</th>
                                        <th>DPJP Utama</th>
                                        <th>Diagnosa Masuk</th>
                                        <th>Ket Tempat Tidur</th>
                                        <th>Waktu Daftar RI</th>
                                        <th>Waktu Diterima Petugas RI</th>
                                        <th>Tgl Masuk</th>
                                        <th>Tgl Perencanaan Pemulangan Pasien</th>
                                        <th>Tgl Keluar</th>
                                        <th>Pintu Masuk</th>
                                    </tr>                                
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    foreach($laporan as $row) { 
                                        $rencana_pulang = isset($row->formjson)?json_decode($row->formjson):null;
                                    ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $row->no_ipd;?></td>
                                            <td><?php echo $row->no_medrec;?></td>
                                            <td><?php echo $row->nama;?></td>
                                            <td><?php
                                                if($row->sex == 'P') {
                                                    echo 'Perempuan';
                                                } else {
                                                    echo 'Laki Laki';
                                                }
                                            ?></td>
                                            <td><?php echo $row->kotakabupaten;?></td>
                                            <td><?php echo $row->carabayar;?></td>
                                            <td><?php echo $row->nmruang;?></td>
                                            <td><?php echo $row->klsiri;?></td>
                                            <td><?php echo $row->jatahklsiri;?></td>
                                            <td><?php echo $row->dokter;?></td>
                                            <td><?php echo $row->nm_diagnosa;?></td>
                                            <td><?php 
                                                if($row->titip == '1') {
                                                    echo 'Titip : YA'.'<br>';
                                                } else {
                                                    echo 'Titip : Tidak'.'<br>';
                                                }

                                                if($row->selisih_tarif == 1) {
                                                    echo 'Selisih Tarif : YA';
                                                } else {
                                                    echo 'Selisih Tarif : Tidak';
                                                }
                                            ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row->tgldaftarri));?></td>
                                            <td><?php if($row->wkt_masuk_rg != '') {
                                                echo date("d-m-Y", strtotime($row->wkt_masuk_rg));
                                            } else {
                                                echo '';
                                            }
                                            ?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row->tgl_masuk));?></td>
                                            <td><?php echo isset($rencana_pulang->tanggal_perencanaan_pemulangan)?date("d-m-Y", strtotime($rencana_pulang->tanggal_perencanaan_pemulangan)):'';?></td>
                                            <td><?php echo date("d-m-Y", strtotime($row->tgl_keluar));?></td>
                                            <td><?php echo $row->nm_poli;?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>			
                    <a href="<?php echo base_url('iri/riclaporan/excel_lap_pasien_pulang_rawat_inap_v2/'.$tampil.'/'.$tanggal);?>" class="btn btn-danger" target="_blank">Excel</a>				
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