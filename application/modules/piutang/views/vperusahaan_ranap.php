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
<section class="content">
	<div class="row">				
		<div class="card" style="width:97%;margin:0 auto">
			<div class="card-header">
				<h3 class="card-title">Daftar Ikatan Kerjasama </h3>			
			</div>
			<div class="card-block">
					<div class="inline">
						<div class="row">
							<div class="form-inline">
								<form action="<?php echo base_url();?>piutang/cperusahaan/iks_ranap" method="post" accept-charset="utf-8">
								<div class="col-lg-12">
									<i>*pilih tanggal untuk melihat tagihan</i>
									<div class="form-inline">
										<!-- <select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
											<option value="TGL">Tanggal</option>
											<option value="BLN">Bulanan</option>
										</select>&nbsp;&nbsp;&nbsp; -->
										
										<input type="date" id="date_days1" class="form-control" placeholder="Pilih Tanggal" name="date_days1">&nbsp;&nbsp;&nbsp;
										<input type="date" id="date_days2" class="form-control" placeholder="Pilih Tanggal" name="date_days2">
										&nbsp;&nbsp;&nbsp;
										<button class="btn btn-primary" type="submit">Tampilkan</button>
									</div>
								</div><!-- /inline -->
								</form>	
							</div>
						</div>						
					</div>
				
				<hr>
				<br/>
				
					<table id="tabel_kwitansi" class="display table table-hover table-bordered table-striped" cellspacing="0" width="100%">
						<thead>
							<tr>
                              <th>No</th>
							  <th>IKS</th>
                              <th>Aksi</th>
							</tr>
						</thead>
						<tbody>
						
							<?php
							//  print_r($pasien_piutang);
							$i=1;
							foreach($perusahaan as $row){
						?>
							<tr>
                              <td><?php echo $i++;?></td>
                              <td><?php echo $row->nmkontraktor;?></td>
							  <td>
									<a href="<?php echo site_url('piutang/cperusahaan/get_list_pasien_ranap/'.$row->id_kontraktor.'/'.$date1.'/'.$date2); ?>" class="btn btn-default btn-sm" target = "_blank"><i class="fa fa-book"></i>Detail</a>
							  </td>
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
