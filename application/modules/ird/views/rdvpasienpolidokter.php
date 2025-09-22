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
	$.ajax({
		type: "POST",
		url: "<?php echo base_url().'ird/rdcpelayananfdokter/update_waktu_masuk'; ?>",
		dataType: "JSON",
		data: {'no_register' : no_register},
		success: function(data){  
			//location.href = '<?php echo site_url('ird/rdcpelayananfdokter/pelayanan_tindakan');?>/'+id_poli+'/'+no_register; 
			$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    		return openUrl('<?php echo site_url('ird/rdcpelayananfdokter/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register);
		},
		error:function(event, textStatus, errorThrown) {    
			swal("Error","Gagal update waktu masuk.", "error");     
			console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		}
	}); 
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
               var getLink = '<?php echo base_url(); ?>ird/rdcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               new swal({
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
               var getLink = '<?php echo base_url(); ?>ird/rdcpelayanan/pelayanan_batal/'+id_poli+'/'+no_register+'/'+hapus;
               new swal({ 
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


function buatSep(noreg) {
	$.ajax({
		url: `<?= base_url('bpjs/sep/insert_sep') ?>/` + noreg,
		beforeSend: function() {

		},
		success: function(data) {
			if (data.metaData.code === '200') {
				$('#no_sep').val(data.response.sep.noSep);
				window.open('<?php echo base_url() . 'bpjs/sep/cetakan_sep/'; ?>' + noreg, '_blank');
			} else {
				new swal("Peringatan!", data.metaData.message, "warning");
			}
		},
		error: function(xhr) {
			new swal("Peringatan!", 'Hubungi Admin IT', "warning");
		},
		complete: function() {

		}
	});
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
								
								<?php echo form_open('ird/rdcpelayananfdokter/kunj_pasien_poli_by_date');?>
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
											<th>Status Pulang / Rujuk</th>

											  <th>Tanggal Kunjungan</th>
											  <th>No Medrec</th>
											  <th>No Registrasi</th>
											  <th>Nama</th>
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
												$datenow = date('Y-m');	
												$cek_berulang = $this->rdmpencarian->cek_pasien_berulang($row->no_medrec,$datenow);
												$tgl_kunj_terakhir = isset($cek_berulang->row()->tgl_kunjungan)?$cek_berulang->row()->tgl_kunjungan:'';

												if($tgl_kunj_terakhir != ''){
													$tanggal = new DateTime($tgl_kunj_terakhir);
													$tanggal->modify('+30 days');
													$bts_tanggal = $tanggal->format('Y-m-d');
												}else{
													$bts_tanggal = date('Y-m-d');
												}
										?>
										<tr class="<?= $row->waktu_masuk_dokter?'bebas':''; ?>">
										<td class="<?= $row->waktu_masuk_dokter?'bebas':''; ?>">
												<?php //if ($row->kelas!="Urikkes") { ?>
													<?php //if($roleid=='32'){ ?>
														   <button onclick="tindak('<?php echo $row->waktu_masuk_dokter; ?>','<?php echo $id_poli; ?>','<?php echo $id; ?>')" class="btn btn-primary btn-xs">Tindak</button><br>
						
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
												<a href="<?php //echo site_url('ird/rdcpelayanan/pelayanan_tindakan/'.$id_poli.'/'.$no_register); ?>" class="btn btn-primary btn-xs">Tindak</a>
												<?php //} ?> -->
												<?= strtoupper($row->ket) == 'BPJS' ? '<button type="button" class="btn btn-danger btn-xs" onclick="buatSep(\'' . $row->id . '\')">Cetak Sep</button>' : '';  ?>

												
												

											</td>
											<td style="<?= $row->waktu_masuk_dokter?'color:white':''; ?>" class="<?= $row->waktu_masuk_dokter?'bebas':''; ?>"><?php echo $row->antri;?>
											<?php 
													if($bts_tanggal > date("Y-m-d", strtotime($row->tgl))){
														echo '- <span style="color:red;">Pasien Berulang</span>';
													}
													?>
											</td>
											<td style="<?= $row->waktu_masuk_dokter?'color:white':''; ?>" class="<?= $row->waktu_masuk_dokter?'bebas':''; ?>"><?php echo $row->status == '1'?($row->ket_pulang == 'DIRUJUK_RAWATINAP'?'Dirujuk Rawat Inap':'Pasien Sudah Pulang'):'-';?></td>
													<?php 
													$date = new DateTime($row->tgl, new DateTimeZone("UTC"));
													?>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php  echo $date->format('d-m-Y') . ' | ' . $date->format('H:i');?></td>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?=$row->kode;?></td>
											<?php if($row->ket=='UMUM' and $row->unpaid > 0  ){
												?>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>" style="color: red !important;"><?php echo $row->id;?></td>
												<?php } else {?>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo $row->id;?></td>
												<?php }?>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo strtoupper($row->nama);?></td>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo strtoupper($row->dokter);?></td>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo strtoupper($row->ket);?></td>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php echo $row->kelas;?></td>
											<td  class="<?= $row->waktu_masuk_dokter?'text-white':''; ?>"><?php if ($row->kekhususan != null) {
												echo 'KHUSUS | FAST TRACK';
												// echo $row->kekhususan;
											}else{

											} ?></td>
											
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