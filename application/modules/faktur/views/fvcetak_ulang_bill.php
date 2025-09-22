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
	<?php
		echo $this->session->flashdata('success_msg');
	?>
</section>
<section class="content">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-outline-info">
				<div class="card-header">
					<h3 class="text-white" align="center">Bill Pasien Pulang Rawat Inap <?php echo $date_title;?></h3>
				</div>
				<div class="card-block">
					<div class="form-group row">
						<div class="col-md-4">
							<?php echo form_open('faktur/fcrekap/bill_pasien_iri');?>
								<div class="input-group">
									<input type="date" id="date_days" class="form-control" placeholder="Tanggal Kwitansi" name="date_days">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div>
						<div class="col-md-4">
							<?php echo form_open('faktur/fcrekap/bill_pasien_iri');?>
								<div class="input-group">
									<input type="text" id="no_rm" class="form-control" placeholder="No Rekam Medis" name="no_rm">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div>		
						<div class="col-md-4">
							<?php echo form_open('faktur/fcrekap/bill_pasien_iri');?>
								<div class="input-group">
									<input type="text" id="sep" class="form-control" placeholder="No SEP" name="sep">
									<span class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
									</span>
								</div>
							<?php echo form_close();?>
						</div>	
					</div><!-- /inline -->
					<hr>
					<table id="example" class="display" cellspacing="0" width="100%">
						<thead>
							<tr>
							  <th>Aksi</th>
							  <th>No Register</th>
							  <th>Nama</th>
							  <th>No Medrec</th>
							  <th>No SEP</th>
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
							foreach($bill as $row){ ?>
                                <tr>
                                    <td><a href="<?php echo site_url('iri/riclaporan/rincian_bill_detail/'.$row->no_ipd); ?>" target="_blank" class="btn btn-primary" style="width:63px;">Bill Pasien</a><br>
										<?php if($row->carabayar == 'KERJASAMA') { ?>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/3';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Kelas Rawat</a><br>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/4';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Jatah Rawat</a><br>
										<?php } else if($row->carabayar == 'BPJS' && $row->selisih_tarif == '1') { ?>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/2';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Kelas Rawat</a><br>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/5';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Jatah Rawat</a><br>
										<?php } else if($row->carabayar == 'UMUM') { ?>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/2';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Rekap Kwitansi</a><br>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/6';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Rekap Kwitansi Sudah Cetak</a><br>
										<?php } else { ?>
											<a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $row->no_ipd.'/2';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Rekap Kwitansi</a><br>
										<?php } ?>
									</td>
                                    <td><?php echo $row->no_ipd;?></td>
                                    <td><?php echo $row->nama;?></td>
                                    <td><?php echo $row->no_cm;?></td>
									<td><?php echo $row->no_sep;?></td>
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