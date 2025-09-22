<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
		// var_dump($triase);'
		// if($triase){

		// }
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

function tindak(waktu_masuk,id_poli,no_register,triase){
	if(waktu_masuk==''){
		$.ajax({ 
		        type: "POST",
		        url: "<?php echo base_url().'ird/rdcpelayanan/update_waktu_masuk'; ?>",
		        dataType: "JSON",
		        data: {'no_register' : no_register},
		        success: function(data){  
					if(triase){
						// window.open(
						// 	'<?php echo site_url('ird/rdcpelayanan/pelayanan_triase_ird');?>/'+id_poli+'/'+no_register,
						// 	'_self' // <- This is what makes it open in a new window.
						// );
						$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    					return openUrl('<?php echo site_url('ird/rdcpelayanan/pelayanan_triase_ird'); ?>/' + id_poli + '/' + no_register);
					}else{
						// window.open(
						// 	'<?php echo site_url('ird/rdcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register,
						// 	'_self' // <- This is what makes it open in a new window.
						// );
						$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    					return openUrl('<?php echo site_url('ird/rdcpelayanan/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register);
					}
		        },
		        error:function(event, textStatus, errorThrown) {    
		            swal("Error","Gagal update waktu masuk.", "error");     
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });  
	}else{
		if(triase == '1'){
			// window.open(
			// 				'<?php echo site_url('ird/rdcpelayanan/pelayanan_triase_ird');?>/'+id_poli+'/'+no_register,
			// 				'_self' // <- This is what makes it open in a new window.
			// 			);
			$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    		return openUrl('<?php echo site_url('ird/rdcpelayanan/pelayanan_triase_ird'); ?>/' + id_poli + '/' + no_register);
		}else{
			// window.open(
			// 				'<?php echo site_url('ird/rdcpelayanan/pelayanan_tindakan');?>/'+id_poli+'/'+no_register,
			// 				'_self' // <- This is what makes it open in a new window.
			// 			);
			$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
    		return openUrl('<?php echo site_url('ird/rdcpelayanan/pelayanan_tindakan'); ?>/' + id_poli + '/' + no_register);
		}
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
								
								<?php echo form_open('ird/rdcpelayanan/kunj_pasien_poli_by_date');?>													
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
												// var_dump($row->tgl);die();
												
												
										?>
										<tr class="<?php
													if($row->ket_pulang == 'BATAL_PELAYANAN_POLI'){
														echo 'batal'; 
													}else{
														echo $row->waktu_masuk_poli?'bebas':''; 
													} 
													
												?>">
										<td class="<?php
													if($row->ket_pulang == 'BATAL_PELAYANAN_POLI'){
														echo 'batal'; 
													}else{
														echo $row->waktu_masuk_poli?'bebas':''; 
													}  ?>">
												<?php //if ($row->kelas!="Urikkes") { ?>
													<?php //if($roleid=='32'){ ?>
													   	<button onclick="tindak('<?php echo $row->waktu_masuk_poli; ?>','<?php echo $id_poli; ?>','<?php echo $id; ?>','<?= (isset($triase))?$triase:''; ?>')" class="btn btn-primary btn-xs">Tindak</button><br>
														
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
												<!-- <a href="<?php echo site_url(); ?>irj/rjcregistrasi/cetak_label/<?php echo $row->id ?>" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-plusthick"></i>Cetak Label</a> -->
												<!-- <a href="<?php echo site_url(); ?>ird/rdcregistrasi/st_cetak_kartu_pasien/<?php echo $row->kode ?>" target="_blank" class="btn btn-info btn-xs"><i class="fa fa-plusthick"></i>Cetak Kartu</a> -->
												<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#editDataModal" onclick="edit_data('<?php echo $row->id ; ?>')">Ubah Cara Bayar</button>
												

											</td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo $row->antri;?>
											<?php 
													if($bts_tanggal > date("Y-m-d", strtotime($row->tgl))){
														echo '- <span style="color:red;">Pasien Berulang</span>';
													}
													?>	
											</td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo $row->status == '1'?($row->ket_pulang == 'DIRUJUK_RAWATINAP'?'Dirujuk Rawat Inap':'Pasien Sudah Pulang'):'-';?></td>
											<?php 
													$date = new DateTime($row->tgl, new DateTimeZone("UTC"));
													?>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php  echo $date->format('d-m-Y') . ' | ' . $date->format('H:i');?></td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?=$row->kode;?></td>
											<?php if($row->ket=='UMUM' and $row->unpaid > 0  ){
												?>
											<td class="<?= $row->waktu_masuk_poli?'text-white':''; ?>"style="color: red !important;"><?php echo $row->id;?></td>
												<?php } else {?>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo $row->id;?></td>
												<?php }?>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo strtoupper($row->nama);?></td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo strtoupper($row->dokter);?></td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo strtoupper($row->ket);?></td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php echo $row->kelas;?></td>
											<td style="<?= $row->waktu_masuk_poli?'color:white':''; ?>" class="<?= $row->waktu_masuk_poli?'bebas':''; ?>"><?php if ($row->kekhususan != null) {
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

<form method="POST" id="update_form" class="form-horizontal">
<div class="modal fade" id="editDataModal" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-success modal-lg">

							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Ubah Cara Bayar</h4>
								</div>
								<div class="modal-body">
									<div class="form-group row">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
										<div class="col-sm-7">
										<input type="hidden" class="form-control" name="no_register_hide" id="no_register_hide">
											<div class="form-inline">
												<!-- <select id="cara_bayar" class="custom-select form-control" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>
													<option value="">-- Pilih Cara Bayar --</option>
													<?php
													//foreach($cara_bayar as $row){
														//echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
													//}
													?> 
												</select>		 -->

																							
													<input type="radio" id="umum_edit" name="cara_bayar_edit" value="UMUM" class="detail_edit">
													<label for="umum_edit">Umum</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" id="bpjs_edit" name="cara_bayar_edit" value="BPJS" class="detail_edit">
													<label for="bpjs_edit">BPJS</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" id="kerjasama_edit" name="cara_bayar_edit" value="KERJASAMA" class="detail_edit">
													<label for="kerjasama_edit">Kerja Sama</label>
											
											</div>
										</div>
									</div>
									<div class="form-group row" id="input_kontraktor_edit">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">Kontraktor</label>
										<div class="col-sm-7">
											<div class="form-inline">
													<select id="id_kontraktor_edit_iks" class="form-control select2" style="width: 100%" name="iks_edit">
														<option value="">-- Pilih Penjamin --</option>	
														<?php 
															foreach($kontraktor as $row){
															echo '<option value="'.$row->id_kontraktor.'@'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
															}
														?>
													</select>
											</div>
										</div>
									</div>
									<div class="form-group row" id="input_kontraktor_bpjs_edit">
										<div class="col-sm-1"></div>
										<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">Kontraktor</label>
										<div class="col-sm-7">
											<div class="form-inline">
													<select id="id_kontraktor_edit_bpjs" class="form-control select2" style="width: 100%" name="iks_bpjs">
														<option value="">-- Pilih Penjamin --</option>	
														<?php 
															foreach($kontraktor_bpjs as $row){
															echo '<option value="'.$row->id_kontraktor.'@'.$row->nmkontraktor.'">'.$row->nmkontraktor.'</option>';
															}
														?>
													</select>
											</div>
										</div>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									<button class="btn btn-primary" type="submit" id="btn-update">Simpan</button>
								</div>
							</div>

						</div>
					</div>
				</form>
<script>
$(document).ready(function(){
	$("#input_kontraktor").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	$("#input_kontraktor_bpjs").css("display","none");
	$(".detail").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar']:checked").val() == "BPJS" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor_bpjs").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$('#input_kontraktor').hide();
		} else if($("input[name='cara_bayar']:checked").val() == "KERJASAMA" ){
			$("#input_kontraktor").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$('#input_kontraktor_bpjs').hide();
		} else {
			$('#input_kontraktor_bpjs').hide();
			$('#input_kontraktor').hide();
		}
	});

	// $("#input_kontraktor_edit").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	// $("#input_perujuk").css("display","none"); //Menghilangkan form-input ketika pertama kali dijalankan
	// $("#input_kontraktor_bpjs_edit").css("display","none");
	$(".detail_edit").click(function(){ //Memberikan even ketika class detail di klik (class detail ialah class radio button)
		if ($("input[name='cara_bayar_edit']:checked").val() == "BPJS" ) { //Jika radio button "berbeda" dipilih maka tampilkan form-inputan
			$("#input_kontraktor_bpjs_edit").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
			$('#input_kontraktor_edit').hide();
		} else if($("input[name='cara_bayar_edit']:checked").val() == "KERJASAMA" ){
			$("#input_kontraktor_edit").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$("#input_perujuk").slideDown("fast"); //Efek Slide Up (Menghilangkan Form Input)
			$('#input_kontraktor_bpjs_edit').hide();
		} else {
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').hide();
		}
	});
});

function edit_data(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('ird/rdcpelayanan/get_data_pasien_igd')?>",
      data: {
        id: id
      },
      success: function(data){
        console.log(data);
        $('#no_register_hide').val(data[0].no_register);
		$('#id_kontraktor_edit_iks').val(data[0].id_kontraktor+'@'+data[0].nmkontraktor);
		$('#id_kontraktor_edit_bpjs').val(data[0].id_kontraktor+'@'+data[0].nmkontraktor);
		if(data[0].cara_bayar === 'UMUM') {
			// $('#umum_edit').checked;
			document.getElementById("umum_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').hide();
		} else if(data[0].cara_bayar === 'BPJS') {
			// $('#bpjs_edit').checked;
			document.getElementById("bpjs_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').show();
			$('#input_kontraktor_edit').hide();
		} else {
			// $('#kerjasama_edit').checked;
			document.getElementById("kerjasama_edit").checked = true;
			$('#input_kontraktor_bpjs_edit').hide();
			$('#input_kontraktor_edit').show();
		}
      },
      error: function(){
        alert("error");
      }
    });
}

$('#update_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-update").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>ird/rdcpelayanan/update_cara_bayar",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
           // document.getElementById("btn-update").innerHTML = 'Edit';
            $('#editDataModal').modal('hide'); 
            document.getElementById("update_form").reset();
            swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									//location.href = '<?php echo base_url().'rad/radcdaftar/pemeriksaan_rad/' ?>'+no_register;
									window.location.reload();
								}); 
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-update").innerHTML = 'Error';
           // $('#editDataModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
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