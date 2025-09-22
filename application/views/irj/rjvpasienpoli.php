    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 
<html>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable({
    	"pageLength":100,
    	"columnDefs": [
      { 
        "orderable": false, //set not orderable
        "targets": [7] // column index 
      }
      ]
    });
} );
//---------------------------------------------------------

$(function() {
$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  

});

function tindak(waktu_masuk,id_poli,no_register){
	if(waktu_masuk==''){
		swal({
         title: "Tindak Pasien",
         text: "Apakah Pasien sudah masuk Ke Ruangan Poli ?",
         type: "info",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
      },
      function(){
		 	$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'irj/rjcpelayanan/update_waktu_masuk'; ?>",
		        dataType: "JSON",
		        data: {'no_register' : no_register},
		        success: function(data){  
		          location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register; 
		        },
		        error:function(event, textStatus, errorThrown) {    
		            swal("Error","Gagal update waktu masuk.", "error");     
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });      	         	        
      });
	}else{
		$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'irj/rjcpelayanan/update_waktu_masuk'; ?>",
		        dataType: "JSON",
		        data: {'no_register' : no_register},
		        success: function(data){  
		          location.href = '<?php echo site_url('irj/rjcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register; 
		        },
		        error:function(event, textStatus, errorThrown) {    
		            swal("Error","Gagal update waktu masuk.", "error");     
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });  
      	// location.href = '<?php //echo site_url('irj/rjcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register;
   	}
}

var intervalSetting = function () {
		location.reload();
	};
setInterval(intervalSetting, 60000);
</script>
<script>
      //   jQuery(document).ready(function($){
      //       $('.delete-pelayanan').on('click',function(){
      //           var getLink = $(this).attr('href');
      //          swal({
  			 //   title: "Hapus Nomor SEP",
  			 //   text: "Yakin akan menghapus Nomor SEP ini?",
  			 //   type: "warning",
  			 //   showCancelButton: true,
  			 //   confirmButtonColor: "#DD6B55",
  			 //   confirmButtonText: "Hapus",
  			 //   closeOnConfirm: false
			   // },function(){
      //                   window.location.href = getLink
      //               });
      //           return false;
      //       });
      //   });
function hapus_pelayanan(id_poli,no_register,cara_bayar,status_sep,hapus) {
	if(hapus=='0'){
		titlebtl = "Batalkan Pelayanan";
		textbtl="Yakin akan membatalkan pelayanan";
	}else{
		titlebtl = "Hapus Pelayanan";
		textbtl="Yakin akan menghapus pelayanan";
	}

	if (status_sep == 0 && cara_bayar == 'BPJS') {
               var getLink = '<?php echo base_url(); ?>irj/rjcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               swal({
  			   title: titlebtl,
  			   text: textbtl + " dan menghapus SEP?",
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Ya",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
	}
	else {
               var getLink = '<?php echo base_url(); ?>irj/rjcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               swal({ 
  			   title: titlebtl,
  			   text: textbtl + " ini?",
  			   type: "warning",
  			   showCancelButton: true,
  			   confirmButtonColor: "#DD6B55",
  			   confirmButtonText: "Ya",
  			   closeOnConfirm: false
			   },function(){
                        window.location.href = getLink
                    });
                return false;
	}

}      
    </script>
	<section class="content-header">
			<?php
				echo $this->session->flashdata('success_msg');
				echo $this->session->flashdata('notification');				
				echo $this->session->flashdata('notification_sep');				
			?>
				
			</section>
			<section class="content">
				<div class="row">
					<div class="col-sm-12">
						<div class="card card-block">
								<h3 class="card-title p-b-10">Daftar Antrian Pasien Poli <b><?php echo $nma_poli.' ('.$id_poli.')';?></b></h3>
							
							<div>
								
								<?php echo form_open('irj/rjcpelayanan/kunj_pasien_poli_by_date');?>
								<div class="row">
								<div class="input-group col-sm-5 col-md-4">
								  <input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
								  <input type="hidden" class="form-control" name="id_poli" value="<?php echo $id_poli;?>">
								  <span class="input-group-btn">
									<button class="btn btn-primary" type="submit">Cari</button>
								  </span>
								</div><!-- /input-group -->
								</div>
								<?php echo form_close();?>
								<br/>
								<div class="table-responsive m-t-0">
								<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
									<thead>
										<tr>
											<th>No Antrian</th>
											  <th>Tanggal Kunjungan</th>
											  <th>No Medrec</th>
											  <th>No Registrasi</th>
											  <th>Nama</th>
											   <th>Dokter</th>
											  <th>Status</th>
											  <th>Kelas</th>
											  <th class="text-center">Aksi</th>	
										</tr>
									</thead>
									<tbody>
										<?php
											// print_r($pasien_daftar);
											$i=1;
												foreach($pasien_daftar as $row){
												$id=$row->id;	
										?>
										<tr>
											<td><?php echo $row->antri;?></td>
											<td><?php echo date("d-m-Y", strtotime($row->tgl)).' | '.date("H:i", strtotime($row->tgl));?></td>
											<td><?=$row->kode;?></td>
											<?php if($row->ket=='UMUM' and $row->unpaid > 0  ){
												?>
											<td style="color: red !important;"><?php echo $row->id;?></td>
												<?php } else {?>
											<td><?php echo $row->id;?></td>
												<?php }?>
											<td><?php echo strtoupper($row->nama);?></td>
											<td><?php echo strtoupper($row->dokter);?></td>
											<td><?php echo strtoupper($row->ket);?></td>
											<td><?php echo $row->kelas;?></td>
											<!-- <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td> -->
											<td class="text-nowrap">
												<?php //if ($row->kelas!="Urikkes") { ?>
													<?php //if($roleid=='32'){ ?>
													   	<button onclick="tindak('<?php echo $row->waktu_masuk_poli; ?>','<?php echo $id_poli; ?>','<?php echo $id; ?>')" class="btn btn-primary btn-xs">Tindak</button>
														
													<?php //} else{ ?>
														<button onclick="hapus_pelayanan('<?php echo $id_poli; ?>','<?php echo $id; ?>','<?php echo $row->ket; ?>',<?php echo $row->hapusSEP; ?>,'0')" class="btn btn-warning btn-xs delete-pelayanan">Batal</button>
													<?php //} ?>
												<?php //} else {?>
											<!-- 	<a href="<?php echo base_url();?>urikes/Curikes/isi_hasil_poli/<?php echo $row->kode; ?>" class="btn btn-primary btn-xs" style="margin-right:3px;">Tindak</a> -->

												<?php //} ?>

												<!-- <button onclick="hapus_pelayanan('<?php echo $id_poli; ?>','<?php echo $no_register; ?>','<?php echo $row->cara_bayar; ?>',<?php echo $row->hapusSEP; ?>,'1')" class="btn btn-danger btn-xs delete-pelayanan">Hapus</button> -->
													
												
												<!--<?php //if($row->cara_bayar=='UMUM' and $row->unpaid>=2 and $id_poli!='BA00'){
												?>
												<a href="javascript:void(0)" class="btn btn-primary btn-xs" disabled>Tindak</a>
												<a href="javascript:void(0)" class="btn btn-danger btn-xs" disabled>Batal</a> 
												
												<?php //} else {?>
												<a href="<?php //echo site_url('irj/rjcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
												<?php //} ?> -->
										
												
												

											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								</div>
								<?php
									//echo $this->session->flashdata('message_nodata'); 
								?>								
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