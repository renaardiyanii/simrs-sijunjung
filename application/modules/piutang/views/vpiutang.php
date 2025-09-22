<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<script type='text/javascript'>
	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
	
	$(document).ready(function() {
		$('#tabel_kwitansi').DataTable();
	} );
	
</script>
	
<?php
	echo $this->session->flashdata('message_cetak'); 
	if($kasir!=''){
		echo '<div class="content-header">
							<div class="box box-default">
								<div class="alert alert-warning alert-dismissable">
									 <h3 align="center">Loket Kasir User : &nbsp;<b>'.$kasir.'</b></h3><p>*) Ubah Loket Kasir di <a href="'.site_url().'">Beranda</a> karena mempengaruhi nomor kwitansi</p>
									</div>
							</div>
						</div>';
	}
?>
<section class="content">
	<div class="row">				
		<div class="card" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title">Daftar Pasien Piutang </h3>			
			</div>
			<div class="card-block">
				<div class="form-group row">
					<div class="col-md-5">
						<?php echo form_open('piutang/cpiutang');?>
						<div class="form-group row">
							<div style="width: 30%;margin-left: 15px;">											
								<input type="date" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="tgl" value="<?php echo date('Y-m-d') ?>">
							</div>

							<div style="width: 30%;margin-left: 5px;">											
								<input type="text"  class="form-control" placeholder="No Medrec" name="no_medrec">
							</div>

							<div style="margin-left: 5px;" class="input-group-btn">
								<button class="btn btn-primary" type="submit">Cari</button>
							</div>
						</div>
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div><!-- /inline -->
				
				<hr>
				<br/>
				
					<table id="tabel_kwitansi" class="display table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
                              <th>No</th>
							  <th>Aksi</th>
                              <th>Tgl Kwitansi</th>
                              <th>No Medrec</th>
							  <th>No Register</th>
							  <th>Jenis Kwitansi</th>
							  <th>Nama</th>
							 
							  
							</tr>
						</thead>
						<tbody>
						
							<?php
							//  print_r($pasien_piutang);
							$i=1;
							foreach($pasien_piutang as $row){
						?>
							<tr>
                              <td><?php echo $i++;?></td>
							  <td>
								<?php 
								if($row->jns_kwitansi == 'Rawat Jalan' || $row->jns_kwitansi == 'Rawat Jalan (Sebelum Poli)'){ ?>
									<a href="<?php echo site_url('irj/rjckwitansi/cetak_detail_tagihan/'.$row->no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Detail</a>
								<?php }else if($row->jns_kwitansi == 'Laboratorium'){ ?>
									<a href="<?php echo site_url('lab/labckwitansi/cetak_detail_tagihan_lab/'.$row->no_lab); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Detail</a>
								<?php }else if ($row->jns_kwitansi == 'Radiologi'){ ?>
									<a href="<?php echo site_url('rad/radckwitansi/cetak_detail_tagihan_rad/'.$row->no_rad); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Detail</a>
								<?php }else if ($row->jns_kwitansi == 'Elektromedik'){ ?>
									<a href="<?php echo site_url('elektromedik/emckwitansi/cetak_detail_tagihan_em/'.$row->no_em); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Detail</a>
								<?php }else if($row->jns_kwitansi == 'Rawat Inap'){ ?>
									<a href="<?php echo site_url('iri/riclaporan/rincian_bill_detail/'.$row->no_register); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Detail</a>
								<?php }
								?>
                                <a href="<?php echo site_url('piutang/cpiutang/rincian_angsuran/'.$row->id); ?>" class="btn btn-default btn-sm"><i class="fa fa-book"></i>Bayar</a>
							  </td>
                              <td><?php echo date('d-m-Y',strtotime($row->created_date));?></td>
							  <td><?php echo $row->medrec;?></td>
							  <td><?php echo $row->no_register;?></td>
							  <td><?php echo $row->jns_kwitansi;?></td>
							  <td><?php echo $row->nama;?></td>
							  
							</tr>
						<?php
							}
						?>
						</tbody>
					</table>
					
					<?php
					//echo $this->session->flashdata('message_nodata');
					?>
				</div>
			</div><!-- /panel body -->
        </div><!-- /.box-body -->
	
</section>

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>
