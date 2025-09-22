    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 
	<?php 
	include('script_rjvpelayanan.php');	
	
	echo $this->session->flashdata('success_msg'); 
	echo $this->session->flashdata('notification');

	?>
<script type="text/javascript">
$(function() {
	$('.auto_search_poli').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	$('.auto_diagnosa_pasien').autocomplete({
	    serviceUrl: '<?php echo base_url().'iri/ricstatus/data_icd_1'; ?>',
	    onSelect: function (suggestion) {
	      $('#id_diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
	      $('#diagnosa').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);

	    }
  	});
	$('#dirujuk_rj_ke_poli').hide();
	$('#pilih_dokter').hide();
	$('#div_tgl_kontrol').hide();
	$('#div_rujuk_penunjang').hide();
   	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		minDate: 0,
		autoclose: true,
		todayHighlight: true,
	});
    $("#date_picker").datepicker("setDate", new Date());

	var lab="<?php echo $rujukan_penunjang->lab;?>";
	var pa="<?php echo $rujukan_penunjang->pa;?>";
	var ok="<?php echo $rujukan_penunjang->ok;?>";
	var rad="<?php echo $rujukan_penunjang->rad;?>";
	var obat="<?php echo $rujukan_penunjang->obat;?>";
	var fisio="<?php echo $rujukan_penunjang->fisio;?>";
	
	if(lab=='1' && pa=='1' && rad=='1' && obat=='1' && fisio=='1' && ok=='1'){
		 document.getElementById("button_simpan_rujukan").disabled= true;
	}
	
});		

function ok_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Operasi!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'ok',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#ok_refresh').load(document.URL +' #ok_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('ok/okcdaftar/pemeriksaan_ok'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("ok1").checked = false;
	  }
	});
}

function lab_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Laboratorium!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'lab',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#lab_refresh').load(document.URL +' #lab_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('lab/labcdaftar/pemeriksaan_lab'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("lab1").checked = false;
	  }
	});
}

function rad_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Radiologi!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'rad',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#rad_refresh').load(document.URL +' #rad_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('rad/radcdaftar/pemeriksaan_rad'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("rad1").checked = false;
	  }
	});
}

function pa_enable(){
    jadwal_rujuk = document.getElementById('date_picker').value;
	// alert(jadwal_lab);
	swal({
	  title: "Rujuk?",
	  text: "Rujuk Penunjang Patologi Anatomi!",
	  type: "warning",
	  showCancelButton: true,
  	  showLoaderOnConfirm: true,
	  confirmButtonColor: "#DD6B55",
	  confirmButtonText: "Ya!",
	  cancelButtonText: "Tidak!",
	  closeOnConfirm: false,
	  closeOnCancel: false
	},
	function(isConfirm){
	  if (isConfirm) {
	    $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcpelayanan/update_rujukan_penunjang_2')?>",
			data: {
				no_register: '<?php echo $no_register ?>',
				jenis_rujuk: 'pa',
				jadwal_rujuk: jadwal_rujuk,
			},
			success: function(data){
				$('#pa_refresh').load(document.URL +' #pa_refresh');
			    swal("Sukses!", "Rujuk selesai di pilih.", "success");
	 			window.open('<?php echo site_url('pa/pacdaftar/pemeriksaan_pa'); echo "/".$no_register ?>','_blank');
			},
			error: function(){
				alert("error");
			}
		});
	  } else {
	    swal("Close", "Tidak Jadi", "error");
		document.getElementById("pa1").checked = false;
	  }
	});
}

function pilih_ket_pulang(ket_plg){
	if(ket_plg=='PULANG'){
		$('#div_tgl_kontrol').show();
		$('#div_rujuk_penunjang').hide();//diubahdlu
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		document.getElementById("btn_simpan").value = 'Simpan';
	} else {
		$('#div_tgl_kontrol').hide();
		$('#div_rujuk_penunjang').hide();
		if(ket_plg=='DIRUJUK_RAWATJALAN'){
			$('#dirujuk_rj_ke_poli').show();
			$('#pilih_dokter').show();
			document.getElementById("id_poli_rujuk").required = true;
			document.getElementById("id_dokter_rujuk").required= false;
			$('#div_tgl_kontrol').hide();
		}else{
			$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			document.getElementById("id_poli_rujuk").required = false;
			document.getElementById("id_dokter_rujuk").required= false;
			//document.getElementById("btn_simpan").value = 'Simpan';
		}
	}
}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxdokter(id_poli){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli2'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}

var ajaxku;
function stateChangedDokter(){
    var data;
	//alert(ajaxku.responseText);
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
		}
    }
	
}

function update_dokter(no_register){
	// var r = confirm("Anda yakin ingin mengupdate dokter?");
	// if (r == true) {
	// 		var id_dokter = $('#id_dokter').val();
	// 		var nmdokter = $('#nmdokter').val();
	//     $.ajax({
	// 	    type:'POST',
	// 	    url:'<?php echo base_url("irj/rjcpelayanan/update_dokter/"); ?>',
	// 	    data:{
	// 	    		'no_register':no_register,
	// 	    		'id_dokter':id_dokter,
	// 	    		'nmdokter':nmdokter
	// 	    	},
	// 	    success:function(data){
	// 	    	// if(data == "1"){
	// 	    		alert("Dokter berhasil diupdate");
	// 	    	// }else{
	// 	    	// 	alert("Gagal update. Silahkan coba lagi");
	// 	    	// }
	// 	    }
	// 	});
	// 	return true;
	// } else {
	//    return false;
	// }

	swal({
        title: "Update Dokter",
        text: "Yakin akan mengupdate dokter?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Update",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
        	var id_dokter = $('#id_dokter').val();
			var nmdokter = $('#nmdokter').val();
				$.ajax({
				        type: "POST",
				        url: "<?php echo base_url("irj/rjcpelayanan/update_dokter/"); ?>",
				        dataType: "JSON",
				        data:{
		    				'no_register':no_register,
		    				'id_dokter':id_dokter,
		    				'nmdokter':nmdokter
		    			},
				        success: function(data){  
				          if (data == '1') {
				              swal("Sukses", "Dokter berhasil diupdate.", "success");
				              tabeltindakan(no_register);
				          } else {
				              swal("Error","Gagal update. Silahkan coba lagi.", "error"); 
				          }
				        },
				        error:function(event, textStatus, errorThrown) {    
				            swal("Error","Gagal update. Silahkan coba lagi.", "error");     
				            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				        }
				});           
      });
      return false;
}
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
});	

	function validate(form){
		// if(form.no_identitas.value==""){
		// 	return false;
		// }
		document.getElementById("btn-simpan-pulang").disabled = true;
		document.getElementById("btn-simpan-pulang").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
		return true;
	}
</script>
	<section class="content">
		<div class="row">
			<div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Data Pasien</h5></div>
                    <div class="card-block">
					
						<div class="row">
						
						<div class="col-sm-12 text-center"><img height="90px" class="img-rounded" src="<?php 
							if($data_pasien_daftar_ulang->foto==''){
								echo site_url("upload/photo/unknown.png");
							}else{
								echo site_url("upload/photo/".$data_pasien_daftar_ulang->foto);
							}
							?>"></div>
							<div class="table-responsive m-t-10 p-10" style="clear: both;">
						<table class="table-xs table-striped" width="100%">
						  <tbody>
						  	<tr>
								<td style="width: 38%;color:green">No. Antrian</td>
								<td style="width: 5%;">:</td>
								<td style="color:green"><b><?php echo $data_pasien_daftar_ulang->no_antrian;?></b></td>
							</tr>
							<tr>
								<td style="width: 38%;">No. MR</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->no_cm;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Nama</td>
								<td style="width: 5%;">:</td>
								<td><?php echo strtoupper($data_pasien_daftar_ulang->nama);?></td>
							</tr>
							<tr>
								<td style="width: 38%;">No. Register</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $no_register;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Umur</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->umurrj.' Thn '.$data_pasien_daftar_ulang->ublnrj.' Bln '.$data_pasien_daftar_ulang->uharirj.' Hr';?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Gol Darah</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->goldarah;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Tanggal Kunjungan</td>
								<td style="width: 5%;">:</td>
								<td><?php echo date('d-m-Y',strtotime($data_pasien_daftar_ulang->tgl_kunjungan)).' | '.date('H:i:s',strtotime($data_pasien_daftar_ulang->tgl_kunjungan));?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Dokter Poli</td>
								<td style="width: 5%;">:</td>
								<td>
									<select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;" required>
														<option value="">-Pilih Pelaksana-</option>
														<?php 
														foreach($dokter_tindakan2 as $row){
															echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'" ';
															if($row->id_dokter==$id_dokterrawat) echo 'selected';
															echo '>'.$row->nm_dokter.'</option>';
														}
														
														?>
													</select>

								<!-- <input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien_daftar_ulang->id_dokter)){echo $data_pasien_daftar_ulang->id_dokter;}?>">
								<input type="text" class="form-control form-control-sm auto_no_register_dokter m-t-5" name="nmdokter" id="nmdokter" value="<?php if(isset($data_pasien_daftar_ulang->dokter)){echo $data_pasien_daftar_ulang->dokter;}?>"> -->

								<button type="button" class="btn waves-effect waves-light btn-primary btn-xs m-b-5 m-t-5" onclick="update_dokter('<?php echo $data_pasien_daftar_ulang->no_register;?>')">Ubah Dokter</button>
								</td>
							</tr>														
							<tr>
								<td style="width: 38%;">Cara Bayar</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->cara_bayar;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Kelas</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $kelas_pasien;?></td>
							</tr>
							<tr>
								<td style="width: 38%;">Penjamin</td>
								<td style="width: 5%;">:</td>
								<td><?php echo $data_pasien_daftar_ulang->nmkontraktor;?></td>
							</tr>														
							<tr>
								<td style="width: 38%;">Waktu Masuk</td>
								<td style="width: 5%;">:</td>
								<td><u><?php echo date('H:i',strtotime($data_pasien_daftar_ulang->waktu_masuk_poli));?></u></td>
							</tr>	
						  </tbody>
						</table>
						
											<br/>
					<!-- <span class="input-group-btn"> -->
						<center>
						<a class="btn btn-primary" href="<?php echo site_url('medrec/el_record/pasien/'.$data_pasien_daftar_ulang->no_medrec); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik</i> </a>&nbsp;&nbsp;&nbsp;
						<?php if($id_poli=='BA00'){?>
						<a class="btn btn-warning" href="<?php echo site_url()."irj/rjcpelayanan/note_igd/".$no_register;?>" target="_blank"><i class="fa fa-book">&nbsp; Catatan Medis IGD</i> </a>
						<?php }?>
						
						</center>
					<!-- </span> -->
					</div>
			</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Status Pulang</h5></div>
                    <div class="card-block">
						<!-- <?php echo form_open('irj/rjcpelayanan/update_pulang'); ?> -->
						<form method="POST" onsubmit="return validate(this)" action="<?php echo base_url('irj/rjcpelayanan/update_pulang')?>">
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" id="lbl_ket_pulang">Status Pulang</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<select class="form-control custom-select" name="ket_pulang" id="ket_pulang" onchange="pilih_ket_pulang(this.value)" required>
													<option value="">-Pilih Ket Pulang-</option>
													<option value="PULANG">Pulang</option>					
													<option value="DIRUJUK_RAWATJALAN">Dirujuk Rawat Jalan</option>
													<option value="DIRUJUK_RAWATINAP">Dirujuk Rawat Inap</option>
													<option value="DIRUJUK_RS">Dirujuk ke RS Lain</option>
													<option value="MENINGGAL">Meninggal</option>
												</select>
											</div>
										</div>
									</div>
							</div>
							<div class="form-group row" id="dirujuk_rj_ke_poli">
								<p class="col-sm-4 form-control-label label-sm" id="dirujuk_ke"></p>
									<div class="col-sm-8">
											Dirujuk Ke:
											<div class="form-inline">
													<select id="id_poli_rujuk" class="form-control custom-select" name="id_poli_rujuk" onchange="ajaxdokter(this.value)">
														<option value="">-Pilih Nama Poli-</option>
														<?php 
														foreach($poliklinik as $row){
															echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
														}
														?>
													</select>
												
											</div>
											<!--
											<input type="search" style="width:300px" class="auto_search_poli form-control input-sm" id="nm_poli" placeholder="Nama Poli">
											
											<div class="form-inline">
											ID Poli : <input type="text" size="8" class="form-control input-sm" placeholder="" id="id_poli" readonly name="id_poli_rujuk">
											Ruang : <input type="text" size="8" class="form-control input-sm" placeholder="" id="kd_ruang" readonly name="kd_ruang_rujuk">
											</div>
											-->
									</div>
							</div>
							<!-- <div class="form-group row" id="pilih_dokter">
								<p class="col-sm-4 form-control-label label-sm"></p>
									<div class="col-sm-8">
											Dokter:
											<div class="form-inline">
													<select id="id_dokter_rujuk" class="form-control custom-select" name="id_dokter_rujuk">
														<option value="">-Pilih Dokter-</option>
														<?php 
														foreach($dokter as $row){
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
														}
														?>
													</select>
												
											</div>
											
									</div>
							</div> -->
							<div class="form-group row" id="div_tgl_kontrol">
								<p class="col-sm-4 form-control-label" id="lbl_tgl_kontrol">Tanggal Kontrol</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<div class="form-group">
												<input type="text" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tgl_kontrol">
											</div>
										</div>
									</div>
							</div>
							<?php //tampilkan jika poli penyakit dalam BQ00
								// if ($id_poli=='BQ00'){
							?>
							<div class="form-group row" id="div_rujuk_penunjang" style="display:none">
								<p class="col-sm-3 form-control-label" id="lbl_tgl_kontrol">Rujuk Penunjang</p>
								<div class="col-sm-9">
									<div class="form-group col-sm-6">
										<div id="ok_refresh">
										 	<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->ok=='1'){
													if($rujukan_penunjang->status_ok=='0'){
														echo '<input type="checkbox" id="ok1" name="ok1" value=null unchecked disabled> Operasi<br>belum selesai.';
													} else if($rujukan_penunjang->status_ok=='1'){
														echo '<input type="checkbox" id="ok1" name="ok1" value=null checked disabled> Operasi | <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="ok1" name="ok1" value="2" onclick=ok_enable()> Operasi';
													}
												}else { 
													echo '<input type="checkbox" id="ok1" name="ok1" value="2" onclick=ok_enable()> Operasi';
												}
												?>										  
											</label> 
											<!--<div class="demo-checkbox">
										<?php if($rujukan_penunjang->ok=='1') { ?>
												<input type="checkbox" id="ok1" class="filled-in" value=null checked disabled name="ok1"/>
			                                    <label class="m-b-0" for="ok1">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="ok1" class="filled-in" <?php if($rujukan_penunjang->status_ok=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="ok1" />
	                                    		<label class="m-b-0" for="ok1">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>-->
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="pa_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->pa=='1'){
													if($rujukan_penunjang->status_pa=='0'){
														echo '<input type="checkbox" id="pa1" name="pa1" value=null unchecked disabled> Patologi Anatomi<br>belum selesai.';
													} else if($rujukan_penunjang->status_pa=='1'){
														echo '<input type="checkbox" id="pa1" name="pa1" value=null checked disabled> Patologi Anatomi | <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="pa1" name="pa1" value="2" onclick=pa_enable()> Patologi Anatomi';
													}
												}else { 
													echo '<input type="checkbox" id="pa1" name="pa1" value="2" onclick=pa_enable()> Patologi Anatomi';
												}
												?>										  
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="lab_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->lab=='1'){
													if($rujukan_penunjang->status_lab=='0'){
														echo '<input type="checkbox" id="lab1" name="lab1" value=null unchecked disabled> Laboratorium<br>belum selesai.';
													} else if($rujukan_penunjang->status_lab=='1'){
														echo '<input type="checkbox" id="lab1" name="lab1" value=null checked disabled> Laboratorium | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="lab1" name="lab1" value="2" onclick=lab_enable()> Laboratorium';
													}
												}else { 
													echo '<input type="checkbox" id="lab1" name="lab1" value="2" onclick=lab_enable()> Laboratorium';
												}
												?>										  
											</label>
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div id="rad_refresh">
											<label class="checkbox-inline">
												<?php 
												if($rujukan_penunjang->rad=='1'){
													if($rujukan_penunjang->status_rad=='0'){
														echo '<input type="checkbox" id="rad2" name="rad2" value=null unchecked disabled> Radiologi<br>belum selesai.';
													} else if($rujukan_penunjang->status_rad=='1'){
														echo '<input type="checkbox" id="rad2" name="rad2" value=null checked disabled> Radiologi | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register.'" target="_blank">Progress</a>';
													} else {
														echo '<input type="checkbox" id="rad2" name="rad2" value="2" onclick=rad_enable()> Radiologi';
													}
												}else { 
													echo '<input type="checkbox" id="rad2" name="rad2" value="2" onclick=rad_enable()> Radiologi';
												}
												?>										  
											</label>
										</div>
									</div>
								</div>
							</div>
							<?php //end = tampilkan jika poli penyakit dalam
								// }
							?>
							<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="div_catatan">Catatan</p>
									<div class="col-sm-8">
									<textarea class="form-control" name="note_pulang" id="note_pulang" cols="25" rows="3" style="resize:vertical"></textarea>
									</div>
							</div>
								<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<div class="form-group row">
									<div class="offset-sm-4 col-sm-8">
                                                        <button type="submit" class="btn btn-primary" id="btn-simpan-pulang">Simpan</button>
                                                        <button type="reset" class="btn btn-warning">Reset</button>
                                                    </div>
								</div>
						<!-- <?php echo form_close();?> -->
					</form>
                    </div> <!-- card block -->
                </div>
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Rujukan Penunjang</h5></div>
                    <div class="card-block">
				<?php echo form_open('irj/rjcpelayanan/update_rujukan_penunjang'); ?>
						<div class="form-group row">
							<p class="col-sm-12 form-control-label" id="label_rujukan">Rujukan Penunjang :</p>
							<div class="col-sm-12">
								<div class="form-inline">
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->ok=='1') { ?>
												<input type="checkbox" id="ok" class="filled-in" value=null checked disabled name="pa"/>
			                                    <label class="m-b-0" for="ok">Operasi <?php if($rujukan_penunjang->status_ok=='0') { echo '|
			                                     <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="ok" class="filled-in" <?php if($rujukan_penunjang->status_ok=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="ok" />
	                                    		<label class="m-b-0" for="ok">Operasi <?php if($rujukan_penunjang->status_ok=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
									<!-- <div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->pa=='1') { ?>
												<input type="checkbox" id="pa" class="filled-in" value=null checked disabled name="pa"/>
			                                    <label class="m-b-0" for="pa">Patologi Anatomi <?php if($rujukan_penunjang->status_pa=='0') { echo '| <a href="'.base_url('pa/pacdaftar/pemeriksaan_pa').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="pa" class="filled-in" <?php if($rujukan_penunjang->status_pa=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="pa" />
	                                    		<label class="m-b-0" for="pa">Patologi Anatomi <?php if($rujukan_penunjang->status_pa=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div> -->
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->lab=='1') { ?>
												<input type="checkbox" id="lab" class="filled-in" value=null checked disabled name="lab"/>
			                                    <label class="m-b-0" for="lab">Laboratorium <?php if($rujukan_penunjang->status_lab=='0') { echo '| <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="lab" class="filled-in" <?php if($rujukan_penunjang->status_lab=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="lab" />
	                                    		<label class="m-b-0" for="lab">Laboratorium <?php if($rujukan_penunjang->status_lab=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
									<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->rad=='1') { ?>
												<input type="checkbox" id="rad" class="filled-in" value=null checked disabled name="rad"/>
			                                    <label class="m-b-0" for="rad">Radiologi <?php if($rujukan_penunjang->status_rad=='0') { echo '| <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="rad" class="filled-in" <?php if($rujukan_penunjang->status_rad=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="rad" />
	                                    		<label class="m-b-0" for="rad">Radiologi <?php if($rujukan_penunjang->status_rad=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>
										<div class="form-group col-sm-6">
										<div class="demo-checkbox">
										<?php if($rujukan_penunjang->obat=='1') { ?>
												<input type="checkbox" id="oabt" class="filled-in" value=null checked disabled name="obat"/>
			                                    <label class="m-b-0" for="obat">Obat <?php if($rujukan_penunjang->status_obat=='0') { echo '| <a href="'.base_url('farmasi/frmcdaftar/permintaan_obat').'/'.$no_register.'" target="_blank">Progress </a>'; } else { echo '| Done'; }?>
			                                    </label>
										<?php } else { ?>
												<input type="checkbox" id="obat" class="filled-in" <?php if($rujukan_penunjang->status_obat=='0') { echo 'value="1"'; } else { echo 'value=null checked disabled'; }?> name="obat" />
	                                    		<label class="m-b-0" for="obat">Obat <?php if($rujukan_penunjang->status_obat=='1') echo '| Done';?></label>
										<?php } ?>												  
										</div>
									</div>

								</div>
							</div>
							

							<div class="offset-sm-6 col-sm-6">

								<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
								<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
								<input type="submit" class="btn btn-primary col-md-offset-1" id="button_simpan_rujukan" value="Simpan">
							</div>
						</div>			
						<?php echo form_close();?>
                    </div> <!-- card block -->
                </div>
            </div>
			<div class="col-md-12">
				<div class="alert alert-danger" id="diag_alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
                    <h4 class="text-danger"><i class="fa fa-ban"></i> DIAGNOSA UTAMA BELUM DIISI !</h4>
                </div>
				<?php if($id_poli=='BQ04'){?>
                <div class="alert alert-info">
                	<form class="form" id="form_add_diet">
						<div class="form-group row">
							<p class="col-sm-2 form-control-label" id="jns_diet">Jenis Diet *</p>
								<div class="col-sm-10">
									<!--<input type="search" style="width:100%" class="auto_search_tindakan form-control" placeholder="" id="nmtindakan" name="nmtindakan" required>
									<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan"  name="idtindakan">
													-->
									<select id="record_gizi" class="form-control select2" name="record_gizi"  style="width:100%;" required>
										<option value="">-Pilih Kel Diet-</option>
										<?php 
											foreach($keldiet as $row){
												echo '<option value="'.$row->idpokdiet;
												
												echo '">'.$row->pokdiet.'</option>';
										}?>
														</select>
											</div>
										</div>
							<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_medrec;?>" name="no_medrec">
							<input type="hidden" class="form-control" value="IRJ" name="rawat">	
							<div class="form-group row">
								<div class="offset-sm-2 col-sm-6">
	                                <button type="submit" class="btn btn-primary" id="btn-diet">Simpan</button>
	                            </div>
							</div>
					</form>
                    
                </div>
                <?php } ?>
                        <div class="card">
                        	
                            <!-- Nav tabs -->
                            <div class="table-responsive">
                            <ul class="nav nav-tabs customtab" role="tablist" style="overflow-x: scroll;">
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_fisik?>" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-xs-down">Pemeriksaan Fisik</span></a>
                                </li>
                                <?php if ($id_poli == 'BQ04') { ?>                                                             
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_gizi?>" data-toggle="tab" href="#tabGizi" role="tab"><span class="hidden-xs-down">Gizi</span></a>
                                </li>
                                <?php } ?>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_tindakan?>" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-xs-down">Tindakan</span></a>
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_diagnosa?>" data-toggle="tab" href="#tabDiagnosa" role="tab"><span class="hidden-xs-down">Diagnosa</span></a>
                                </li>
                                <?php if ($data_pasien_daftar_ulang->cara_bayar == 'BPJS') { ?>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabProsedur" role="tab"><span class="hidden-xs-down">Prosedur</span></a> 
                                </li>
                                <?php } ?>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_lab?>" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a>
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_pa?>" data-toggle="tab" href="#tabPatologi" role="tab"><span class="hidden-xs-down">Patologi Anatomi</span></a>
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_rad?>" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a>
                                </li>                                
                                <li class="nav-item text-center"> 
                                	<a class="nav-link <?=$tab_resep?>" data-toggle="tab" href="#tabResep" role="tab"><span class="hidden-xs-down">Resep</span></a>
                                </li>
                            </ul>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane <?=$tab_fisik?>" id="tabFisik" role="tabpanel">
                                    <div class="p-20">
                                        <?php include('rjvformfisik.php');  ?>
                                    </div>
                                </div>
                                <?php if ($id_poli == 'BQ04') { ?>                                                             
                                <div class="tab-pane p-20 <?=$tab_gizi?>" id="tabGizi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformgizi.php');  ?>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="tab-pane p-20 <?=$tab_tindakan?>" id="tabTindakan" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformtindakanajax.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_diagnosa?>" id="tabDiagnosa" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformdiagnosa.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabProsedur" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformprocedure.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabOperasi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_ok.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_lab?>" id="tabLaborat" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_lab.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_pa?>" id="tabPatologi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_pa.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20 <?=$tab_rad?>" id="tabRadiologi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_rad.php');  ?>
                                    </div>
                                </div>                                
                                <div class="tab-pane p-20 <?=$tab_resep?>" id="tabResep" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_resep.php');  ?>
                                    </div>
                                </div>
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