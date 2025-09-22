<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}?>
<script type='text/javascript'>
	$(document).ready(function() {
	    $('#example').DataTable();
	    $('#tabel_kwitansi').DataTable();
	} );
</script>

<section class="content-header">
<?php echo $this->session->flashdata('pesan');?>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-outline-info">
				<div class="card-header">
					<h3 class="text-white" align="center">Belum Selesai Administrasi Rawat Inap <?php echo $date_title;?></h3>
				</div>
				<div class="card-block">
					<!-- <div class="form-group row"> -->
						<!-- <div class="col-md-4"> -->
                    <?php echo form_open('faktur/fcrekap/pasien_blm_administrasi');?>
                        <div class="row p-t-0">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div id="month_input">
                                        <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
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
						<!-- </div> -->
						<!-- <div class="col-md-4">
							<?php echo form_open('faktur/fcrekap/bill_pasien_iri');?>
								<div class="input-group">
									<input type="text" id="no_rm" class="form-control" placeholder="No Rekam Medis" name="no_rm">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div>		 -->
					<!-- </div>/inline -->
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>Aksi</th>
                              <th>Ket</th>
							  <th>No Register</th>
							  <th>Nama</th>
							  <th>No Medrec</th>
							  <th>Ruang</th>
							  <th>Jaminan</th>
							  <th>JK</th>
                              <th>Tgl Masuk</th>
							  <th>Tgl Keluar</th>
                              <th>DPJP</th>
							</tr>
						</thead>
						<tbody>
							<?php
							foreach($pasien as $row){ ?>
                                <tr>
                                    <td><a href="<?php echo site_url('faktur/fcrekap/selesai_administrasi/'.$row->no_ipd); ?>" class="btn btn-primary">Selesai Administrasi</a></td>
                                    <td><?php echo $row->ket;?></td>
                                    <td><?php echo $row->no_ipd;?></td>
                                    <td><?php echo $row->nama;?></td>
                                    <td><?php echo $row->no_cm;?></td>
                                    <td><?php echo $row->nmruang;?></td>
                                    <td><?php echo $row->carabayar;?></td>
                                    <td><?php echo $row->sex;?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row->tgl_masuk));?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row->tgl_keluar));?></td>
                                    <td><?php echo $row->dokter;?></td>
                                </tr>
						    <?php } ?>
						</tbody>
					</table>								
				</div>
			</div>
		</div>
    </div>
</section>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>