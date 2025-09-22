<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<?php $this->load->view("iri/layout/script_addon"); ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<script>
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto-ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#kode-ruang-pilih').val(''+suggestion.idrg);
			$('#nama-ruang-pilih').val(''+suggestion.nmruang);
		}
	});
	$(document).on("click",".batal_inap",function() {
      var getLink = $(this).attr('href');
      swal({
        title: "Batal Reservasi",
        text: "Yakin akan membatalkan reservasi tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Batalkan",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
			// $.ajax({
			// 	type: 'POST',
			// 	url: getLink,
			// 	dataType:'JSON',
			// 	success: function(response) {
			// 		if (response.success){
			// 			objTable.ajax.reload();
			// 			swal("Sukses","Berhasil menghapus data.", "success"); 
			// 		}else swal("Error","Gagal menghapus data.", "error"); 
			// 	}
			// });  
			location.href = getLink;         
      });
      return false;
    });
});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<?php echo $this->session->flashdata('pesan');?>
		<div class="card card-outline-info">
			<div class="card-header">
                <h4 class="m-b-0 text-white text-center">DAFTAR ANTRIAN RESERVASI</h4>
            </div>
			<div class="card-block p-b-15">
				<div class="table-responsive m-t-0">
                	<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="dataTables-example">
						  <thead>
							<tr>
								<th>Registrasi Asal</th>
								<th width="7%">Tanggal Kunjungan</th>
								<th>Nama</th>
								<th>No Medrec</th>
								<th width="13%">Data Pasien</th>
								<th>Poli Asal</th>
								<th>Dokter</th>
								<th>Cara Bayar</th>
								<th>Diagnosa</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($data_irj as $r) { ?>
						  	<tr>
						  		<td>
							  		Rawat Jalan<br>
							  		<?php echo $r['no_register'];?>
						  		</td>
						  		<td>
						  		<?php
						  			echo date('d-m-Y',strtotime($r['tgl_kunjungan']));
						  		?>
						  		</td>
						  		<td><?php echo $r['nama'];?></td>
						  		<td><?php echo $r['no_cm'];?></td>
						  		<td>
						  			<?php if($r['sex']=='P'){
						  				echo 'Perempuan';} else {
						  				echo 'Laki-laki';}?><br>
						  			<?php echo date('d-m-Y',strtotime($r['tgl_lahir']));?><br>
						  			<?php echo $r['no_telp'];?>
						  		</td>
						  		<td><?php echo $r['id_poli']." - ".$r['nm_poli'];?></td>
						  		<td><?php echo $r['nama_dokter'];?></td>
						  		<td><?php echo $r['cara_bayar'];?></td>
						  		<td><?php echo $r['id_diagnosa']." ".$r['diagnosa'];?></td>
						  		<td><a class="btn waves-effect waves-light btn-primary btn-xs" href="<?php echo base_url(); ?>iri/ricreservasi/reservasi_from_list/<?php echo $r['no_register']; ?>"><i class="fa fa-plus"></i> Reservasi</a>
						  		<a class="btn waves-effect waves-light btn-danger btn-xs batal_inap" href="<?php echo base_url(); ?>iri/ricreservasi/batal/<?php echo $r['no_register']; ?>"><i class="fa fa-close"></i> Batal</a>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
					</table>
				</div><!-- table-responsive -->
			</div><!--- card block -->
		</div><!--- card -->
	</div><!--- col-md-12 -->
</div><!--- row -->

		<!-- /Main content -->
		
		<!-- Modal -->
		<div class="modal fade bs-example-modal-sm" id="modal-batal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
					</div>
					<div class="modal-body">
						Apakah kamu yakin ingin mengapprove ini?
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tidak</button>
						<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Ya</button>
					</div>
				</div>
			</div>
		</div>
		<!-- /Modal -->

<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
</script>
<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>
