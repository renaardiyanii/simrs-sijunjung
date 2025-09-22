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
	$(document).on("click",".create_sep",function() {
	    var no_register = $(this).data("noregister");
	    swal({
	      title: "Pembuatan SEP",
	      text: "Yakin akan membuat SEP dengan pasien tersebut?",
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      confirmButtonText: "Buat SEP",
	      showCancelButton: true,
	      closeOnConfirm: false,
	      showLoaderOnConfirm: true,
	      }, function() {
	        $.ajax({
	          type: "POST",
	          url: "<?php echo base_url().'bpjs/sep/create/'; ?>"+no_register,
	          dataType: "JSON",    
	          success: function(result) {  
	            if (result.metaData.code == '200') {       
	              window.open('<?php echo base_url().'bpjs/sep/cetak/'; ?>'+no_register, '_blank');
	              swal("Sukses", "Silahkan Cetak SEP", "success");   
	            } else {
	              swal("Gagal membuat SEP", result.metaData.message, "error");   
	            }       
	          },
	          error:function(event, textStatus, errorThrown) {    
	              swal("Gagal membuat SEP",formatErrorMessage(event, errorThrown), "error");    
	              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	          }
	        }); 
	    });
	});
	$('.auto-ruang').autocomplete({
		serviceUrl: site+'/iri/ricreservasi/data_ruang',
		onSelect: function (suggestion) {
			$('#kode-ruang-pilih').val(''+suggestion.idrg);
			$('#nama-ruang-pilih').val(''+suggestion.nmruang);
		}
	});
});
</script>
	<?php echo $this->session->flashdata('pesan');?>
<div>
	<div >

				<div class="row">
			
				<div class="col-lg-12 col-md-12">
						<div class="card card-outline-info">
							<div class="card-header">
                        		<h5 class="m-b-0 text-white text-center">DAFTAR ANTRIAN RESERVASI</h5>
                        	</div>
							<div class="card-block">
								<br/>
						<div class="table-responsive">
						<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="dataTables-example" width="100%">
						  <thead>
							<tr>
							  	<th>No. Antri</th>
								<th>No. MedRec</th>
								<th>Reg. Asal</th>
								<th>Tgl. Daftar</th>
								<th>Nama</th>
								<th>Ruang</th>
								<th>Kelas</th>
								<th>Cara Bayar</th>
								<th>Prioritas</th>
								<th>Ren. Masuk</th>
								<th>Aksi</th>
							</tr>
						  </thead>
						  	<tbody>
						  	<?php
						  	foreach ($list_reservasi_all as $r) { ?>
						  	<tr>
						  		<td><?php echo $r['noreservasi'];?></td>
						  		<td><?php echo $r['no_cm'];?></td>
						  		<td><?php echo $r['no_register_asal'];?></td>
						  		<td>
						  		<?php 
						  			echo date('d-m-Y',strtotime($r['tglreserv']));
						  		?>
						  		</td>
						  		<td><?php echo $r['nama'];?><br>
						  		<?php echo $r['no_hp'];?></td>
						  		<td><?php echo $r['nmruang'];?></td>
						  		<td><?php echo $r['kelas'];?></td>
						  		<td><?php echo $r['cara_bayar'];?></td>
						  		<td><?php echo $r['prioritas'];?></td>
						  		<td>
					  			<?php 
						  			echo date('d-m-Y',strtotime($r['tglrencanamasuk']));
						  		?>
						  		</td>
						  		<td>
						  		<?php
						  		if($r['tppri']=='rawatjalan'){
									$link=base_url().'iri/ricpendaftaran/index/'.$r['noreservasi'];
								}else if($r['tppri']=='rawatdarurat'){
									$link=base_url().'iri/ricpendaftaran/index/'.$r['noreservasi'];
								}else{
									$link=base_url().'iri/ricmutasi/index/'.$r['noreservasi'];
								}
						  		?>
						  		<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs btn-block"><i class="fa fa-plus"></i> Setujui</a> 
						  		<?php 
						  		if(substr($r['no_register_asal'], 0,2) == "RI"){ ?>
						  			<a href="<?php echo base_url(); ?>iri/ricdaftar/batal_mutasi/<?php echo $r['noreservasi'] ; ?>" class="btn btn-danger btn-xs btn-block"><i class="fa fa-remove"></i> Batal</a>
						  		<?php
						  		}else{ ?>
						  			<a href="<?php echo base_url(); ?>iri/ricdaftar/batal_reservasi/<?php echo $r['noreservasi'] ; ?>" class="btn btn-danger btn-xs btn-block"><i class="fa fa-remove"></i> Batal</a>
						  		<?php
						  		}
						  		?>
						  		</td>
						  	</tr>
						  	<?php
						  	}
						  	?>
							</tbody>
						</table>
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div>
				</div><!--- row -->
		
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
		
	</div>
</div>
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