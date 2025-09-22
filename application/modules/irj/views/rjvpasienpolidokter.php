    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 
<html>
<style>
	.text-white{
		color:white;
	}
	.bebas{
		background-color:#50CB93!important;
	}
	.batal{
		background-color:red!important;
	}
</style>
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
		dateFormat: "dd-mm-yy",
  		changeMonth: true,
  		changeYear: true,
		autoclose: true,
		todayHighlight: true,
		yearRange: "c-100:c+100",
	});  

});

function tindak(waktu_masuk,id_poli,no_register){
	if(waktu_masuk==''){
		$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'irj/rjcpelayananfdokter/update_waktu_masuk'; ?>",
		        dataType: "JSON",
		        data: {'no_register' : no_register},
		        success: function(data){  
					$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
					return openUrl('<?php echo site_url('irj/rjcpelayananfdokter/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register);
		          //location.href = '<?php echo site_url('irj/rjcpelayananfdokter/pelayanan_tindakan');?>/'+id_poli+'/'+no_register; 
		        },
		        error:function(event, textStatus, errorThrown) {    
		            swal("Error","Gagal update waktu masuk.", "error");     
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });   
	}else{
		$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
		return openUrl('<?php echo site_url('irj/rjcpelayananfdokter/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register);
      	//location.href = '<?php echo site_url('irj/rjcpelayananfdokter/pelayanan_tindakan');?>/'+id_poli+'/'+no_register;
   	}
}

// var intervalSetting = function () {
// 		location.reload();
// 	};
// setInterval(intervalSetting, 60000);
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
								
								<?php echo form_open('irj/rjcpelayananfdokter/kunj_pasien_poli_by_date');?>
								<div class="form-group row">
									<div class="col-md-4">											
										<input type="date"  class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
										<input type="hidden" class="form-control" name="id_poli" value="<?php echo $id_poli;?>">																				
									</div>
									<div class="input-group-btn">
										<button class="btn btn-primary" type="submit">Cari</button>
								  	</div>
								</div>
								<?php echo form_close();?>
								<br/>
								<div class="table-responsive m-t-0">
								<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
									<thead>
										<tr>
										<th class="text-center">Aksi</th>
											<th>No Antrian</th>
											<th>Tanggal Kunjungan</th>
											<th>No Medrec</th>
											<th>No Registrasi</th>
											<th>Nama</th>
											<th>J.kel</th>
											<th>Dokter</th>
											<th>Status</th>
											<th>Kelas</th>
											<th>Kekhususan </th>											  	
										</tr>
									</thead>
									<tbody>
										<?php
											// print_r($pasien_daftar);
											$i=1;
												foreach($pasien_daftar as $row){
												$id=$row->id;	
										?>
										<tr class="<?php
													if($row->ket_pulang == 'BATAL_PELAYANAN_POLI'){
														echo 'batal'; 
													}else{
														echo $row->waktu_masuk_dokter?'bebas':''; 
													} 
													 ?>">
										<td class="<?php
													if($row->ket_pulang == 'BATAL_PELAYANAN_POLI'){
														echo 'batal'; 
													}else{
														echo $row->waktu_masuk_dokter?'bebas':''; 
													} 
													 ?>">
												<?php //if ($row->kelas!="Urikkes") { ?>
													<?php //if($roleid=='32'){ ?>
													   	<button onclick="tindak('<?php echo $row->waktu_masuk_dokter; ?>','<?php echo $id_poli; ?>','<?php echo $id; ?>')" class="btn btn-primary btn-xs">Tindak</button>
														
													<?php //} else{ ?>
														<button type="button" onclick="hapus_pelayanan('<?php echo $id_poli; ?>','<?php echo $id; ?>','<?php echo $row->ket; ?>','<?php echo $row->hapusSEP; ?>','0')" class="btn btn-warning btn-xs delete-pelayanan">Batal</button>
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
																						
												<?php 
													$data_konsul = $this->rjmpelayanan->get_data_konsul_by_noreg($row->no_register_lama)->row(); 
													if ($data_konsul != null) {
												?>
													<form action="<?= base_url('emedrec/C_emedrec/surat_konsul_by_reg'); ?>" method="post">
														<input type="hidden" name="user_id" value="<?php echo $row->no_register_lama;?>"> 
														<input type="hidden" name="no_cm" value="<?= $row->kode; ?>">
														<input type="hidden" name="no_medrec" value="<?= intval($row->kode); ?>">
														<button type="submit" class="btn btn-info btn-xs" formtarget="_blank">KONSUL</button>
													</form>
												<?php }else{ ?>
												<?php } ?>

											</td>
											<td style="<?= $row->waktu_masuk_dokter?'color:white':''; ?>" class="<?php
													if($row->ket_pulang == 'BATAL_PELAYANAN_POLI'){
														echo 'batal'; 
													}else{
														echo $row->waktu_masuk_dokter?'bebas':''; 
													} 
													 ?>"><?php echo $row->antri;?></td>
													 <?php 
													//  date_default_timezone_set('Asia/Jakarta'); 
													$date = new DateTime($row->tgl, new DateTimeZone("UTC"));
													//  $tanggal = new DateTime($row->tgl);
													 ?>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php  echo $date->format('d-m-Y') . ' | ' . $date->format('H:i');?></td>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?=$row->kode;?></td>
											
											<!-- perbaikan urgent , unpaid > 0 -->
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>" class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo $row->id;?></td>
											
										
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo strtoupper($row->nama);?></td>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo strtoupper($row->sex);?></td>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo strtoupper($row->dokter);?></td>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>">
											<?php 
													if($row->ket == 'KERJASAMA' OR $row->ket == 'BPJS'){
														echo strtoupper($row->ket).'('.$row->nmkontraktor.')';
													}else{
														echo strtoupper($row->ket);
													} ?>
											</td>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo $row->kelas;?></td>
											<td class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php if ($row->kekhususan != null) {
												echo 'KHUSUS | FAST TRACK';
												// echo $row->kekhususan;
											}else{

											} ?></td>
											<!-- <td class="text-nowrap">
                                                    <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                                </td> -->
											
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