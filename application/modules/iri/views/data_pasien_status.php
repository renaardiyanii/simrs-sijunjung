<script>

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.meninggal').hide();
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa1').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#id_row_diagnosa').val(''+suggestion.id_icd);
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
	// $('#tgl_meninggal').datepicker({
	// 		format: "yyyy-mm-dd",
	// 		autoclose: true,
	// 		todayHighlight: true,
	// 	});
	  $("#jam_meninggal").timepicker({
		    showInputs: false,
		    showMeridian: false
	 });

});

function update_status_pemeriksaan_ok(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Operasi ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_ok/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		//alert("Request Pemeriksaan Radiologi Berhasil Dikirim. ");	
	    		//window.open("'.site_url("rad/radcdaftar/pemeriksaan_rad/no_ipd").'", "_blank");
	    		window.open(' <?php echo base_url("ok/okcdaftar/pemeriksaan_ok")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}

function batal_pasien(no_ipd){
	var r = confirm("Anda yakin ingin membatalkan pasien ?");
	if (r == true) {
		window.location.href = '<?php echo base_url("iri/ricstatus/batalkan_pasien/")?>/'+no_ipd;
	   	// window.open('<?php echo base_url("iri/ricstatus/batalkan_pasien/")?>/'+no_ipd , "_self");
	    // alert('<?php echo base_url("iri/ricstatus/batalkan_pasien/")?>/'+no_ipd);
	} else {
	    return false;
	}
	
}

function pulang(val_plg){
	if(val_plg!=''){
		if(val_plg=="MENINGGAL"){
			$('.meninggal').show();
			document.getElementById("tgl_meninggal").required= true;
			document.getElementById("jam_meninggal").required= true;
			document.getElementById("kondisi_meninggal").required= true;
		}else{
			$('.meninggal').hide();
			document.getElementById("tgl_meninggal").required= false;
			document.getElementById("jam_meninggal").required= false;
			document.getElementById("kondisi_meninggal").required= false;
		}
	}

}

function update_status_pemeriksaan_rad(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Radiologi ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_rad/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		//alert("Request Pemeriksaan Radiologi Berhasil Dikirim. ");	
	    		//window.open("'.site_url("rad/radcdaftar/pemeriksaan_rad/no_ipd").'", "_blank");
	    		window.open(' <?php echo base_url("rad/radcdaftar/pemeriksaan_rad")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}


function update_status_pemeriksaan_lab(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Laboratorium ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_lab/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		//alert("Request Pemeriksaan Laboratorium Berhasil Dikirim. ");
	    		window.open(' <?php echo base_url("lab/labcdaftar/pemeriksaan_lab")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}


function update_status_pemeriksaan_pa(no_ipd){
	var r = confirm("Anda yakin ingin menambah pemeriksaan Patologi Anatomi ?");
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_pa/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		alert("Request Pemeriksaan Patologi Anatomi Berhasil Dikirim. ");
	    		window.open(' <?php echo base_url("pa/pacdaftar/pemeriksaan_pa")?>/'+no_ipd);
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
	   return true;
	} else {
	    return false;
	}
	
}

function update_status_resep(no_ipd){
	var r = confirm("Anda yakin ingin memberikan resep?");
	if (r == true) {
	    $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rictindakan/set_status_resep/"); ?>',
		    data:{
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		//var obj = JSON.parse(data);
	    		alert("Request Resep Obat Berhasil Dikirim. ");
	    		// if(!isEmpty(obj)){
	    		// 	$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
	    		// 	$('#vtot_kelas').val(obj[0]['total_tarif']);
	    		// 	$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
	    		// 	$('#biaya_tindakan').val(temp[1] - obj[0]['total_tarif']);
	    		// }else{
	    		// 	$("#harga_satuan_jatah_kelas").val('0');
	    		// 	$("#biaya_jatah_kelas").val('0');
	    		// 	//$('#vtot').val('0');
	    		// }
		    }
		});
		return true;
	} else {
	   return false;
	}
}

function update_dokter(no_ipd){
	var r = confirm("Anda yakin ingin mengupdate dokter?");
	if (r == true) {
			var id_dokter = $('#id_dokter').val();
			var nmdokter = $('#nmdokter').val();
	    $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/ricstatus/update_dokter/"); ?>',
		    data:{
		    		'no_ipd':no_ipd,
		    		'id_dokter':id_dokter,
		    		'nmdokter':nmdokter
		    	},
		    success:function(data){
		    	if(data == "1"){
		    		alert("Dokter berhasil diupdate");
		    	}else{
		    		alert("Gagal update. Silahkan coba lagi");
		    	}
		    }
		});
		return true;
	} else {
	   return false;
	}
}

function showswal() {
		var base = "<?php echo base_url(); ?>";
		new swal({
			title: "",
			text: "MOHON REFRESH HALAMAN",
			type: "success",
			showConfirmButton: true,
			showCancelButton: false,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function () {
			window.location.href = base+"iri/ricpasien";
		});
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

const kwitansinew = ()=>{
	let data = btoa('<?= $data_pasien[0]['no_ipd'] ?>');
	window.open(`${baseurl}/iri/ricstatus/cetak_list_pembayaran_pasien?q=${data}`,
	'_blank');
}
</script>
		<div class="row">
			<div class="col-sm-6">
				<div class="card card-outline-info">
					<div class="card-header text-white" align="center" >Data Pasien</div>
					<div class="card-block">
						<br/>
							<div class="row">
								<div class="col-sm-3">
									<div align="center"><img height="100px" class="img-rounded" src="<?php 
											if($data_pasien[0]['foto']==''){
												echo site_url("upload/photo/unknown.png");
											}else{
												echo site_url("upload/photo/".$data_pasien[0]['foto']); 
											}
											?>">
											<!-- <a href="<?php echo base_url();?>iri/ricsjp/cetak_gelang/<?php echo $data_pasien[0]['no_ipd'] ;?>" target="_blank"><input type="button" class="btn btn-primary btn-sm" value="Cetak Gelang"></a> -->

											<a href="<?php echo base_url(); ?>iri/ricstatus/index/<?php echo $data_pasien[0]['no_ipd'];?>"><input type="button" class="btn btn-primary btn-sm" value="Status Pasien"></a>


									</div>
									<!-- <div align="center"><br><a href="<?php echo base_url(); ?>iri/ricstatus/index/<?php echo $data_pasien[0]['no_ipd'];?>"><button type="button" class="btn btn-warning btn-sm" style="white-space: normal;"><i class="fa fa-plusthick"></i> Status Pasien</button></a><br></div>
									</div> -->
									<div align="center"><br><a href="<?php echo base_url();?>iri/rictindakan/list_dokter/<?php echo $data_pasien[0]['no_ipd'];?>"><input type="button" class="btn btn-success btn-sm" value="Dokter Pasien"></a></div>

									<div align="center"><br><button onclick="return batal_pasien('<?php echo $data_pasien[0]['no_ipd'] ;?>');" class="btn btn-warning btn-sm" style="white-space: normal;">Batalkan Pasien</button></div>
									
									<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/0';?>" target="_blank" class="btn btn-danger btn-sm" style="white-space: normal;">Lihat Kwitansi Sementara</a><br></div>
									<!-- <?php if($data_pasien[0]['carabayar'] == 'KERJASAMA') { ?>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/3';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Kelas Rawat</a><br></div>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/4';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Jatah Rawat</a><br></div>
									<?php } else if($data_pasien[0]['carabayar'] == 'BPJS' && $data_pasien[0]['selisih_tarif'] == '1') { ?>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/2';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Kelas Rawat</a><br></div>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/5';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Rekap Kwitansi Jatah Rawat</a><br></div>
									<?php } else if($data_pasien[0]['carabayar'] == 'UMUM') { ?>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/2';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Rekap Kwitansi</a><br></div>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/6';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Rekap Kwitansi Sudah Cetak</a><br></div>
									<?php } else { ?>
										<div align="center"><br><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/2';?>" target="_blank" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Rekap Kwitansi</a><br></div>
									<?php } ?>
									<div align="center"><br><button onclick="kwitansinew()" class="btn btn-info btn-sm" style="white-space: normal;">Lihat Kwitansi (new)</button><br></div>
									<div align="center"><br><a href="<?php echo base_url();?>iri/riclaporan/rincian_bill_detail/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank" class="btn btn-primary btn-sm" style="white-space: normal;">Rincian Bill</a><br></div> -->
								</div>

									
								<div class="col-sm-9 table-responsive">
									<table class="table-sm table-striped" style="font-size:15">
									<tbody>
										<tr>
											<th>Nama</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['nama'];?></td>
										</tr>
										<tr>
											<th>No. MedRec</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['no_cm'];?></td>
										</tr>
										<tr>
											<th>No. Register</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['no_ipd'];?></td>
										</tr>
										<tr>
											<th>Tgl Lahir</th>
											<td>:&nbsp;</td>
											<td><?php
												$interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
												//echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
												echo date('d-m-Y', strtotime($data_pasien[0]['tgl_lahir']));
											?>
											</td>
										</tr>
										<tr>
											<th>Alamat</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['alamat'];?>
											</td>
										</tr>
										<tr>
											<th>Gol Darah</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['goldarah'];?></td>
										</tr>
										<tr>
											<th>Tanggal Kunjungan</th>
											<td>:&nbsp;</td>
											<td><?php echo date('d-m-Y', strtotime($data_pasien[0]['tgl_masuk'])); ?></td>
											<!-- <td><?php //echo date("j F Y", strtotime($data_pasien[0]['tgl_masuk'])); ?></td> -->
										</tr>
										<tr>
											<th>Kelas</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['kelas'];?></td>
										</tr>
										<tr>
											<th>DPJP</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['dokter'];?>
											</td>
										</tr>
										<tr>
											<th>Cara Bayar</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien[0]['carabayar'];?> <a href="<?php echo base_url() ;?>iri/ricpasien/ubah_cara_bayar/<?php echo $data_pasien[0]['no_ipd'] ;?>"><input type="button" class="btn btn-primary btn-sm" value="Ubah"></a></td>
										</tr>
										<tr>
											<th></th>
											<td> &nbsp;</td>
											<td><?php echo $data_pasien[0]['nmkontraktor'];?></td>
										</tr>
										
									</tbody>
									</table>
								
								</div>
							</div>
						<br/>
							<div class="row" style="align: center;">
								<div class="col-md-12">
										<a href="<?php echo base_url().'emedrec/C_emedrec/rekam_medik_detail/'.$data_pasien[0]['no_cm'].'/'.$data_pasien[0]['no_medrec'].'/'.$data_pasien[0]['no_ipd'].'/'.$data_pasien[0]['noregasal'] ?>" target="_blank" rel="noopener noreferrer" class="btn btn-primary" style="margin-left: 45%;width:25%;">REKAM MEDIK</a>									
								</div>								
							</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="card card-outline-danger">
					
				
					<!-- <div class="card card-outline-info">
					<div class="card-block">
						<?php echo form_open('iri/rictindakan/rujukan_penunjang'); ?>
						<?php
						// var_dump($rujukan_penunjang);
						?>
						<?php foreach($rujukan_penunjang as $row){
						$lab= $row->lab; $ok= $row->ok; $pa= $row->pa; $rad= $row->rad; $obat= $row->obat; ?>
						<div class="form-group row">
							<p class="col-sm-12 form-control-label" id="label_rujukan">Rujukan Penunjang</p>
							<div class="col-sm-12">
								<div class="form-inline">
									<div class="form-group col-sm-6">
								<div class="demo-checkbox">
								<label class="checkbox-inline ">
								<?php 
									if($row->status_ok>='1'){
										if($row->ok=='0'){
										echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" checked="checked" value="1" disabled><label for="okCheckbox"> Operasi | '.$row->status_ok.' Done</label>';
										} else {
											echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" checked="checked" value="1" disabled><label for="okCheckbox"> Operasi';
											echo ' | <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a></label>';
										}
									}
									else { 
										if($row->ok=='0'){
										echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox"  value="1"><label for="okCheckbox"> Operasi</label>';
										} else {
											echo '<input type="checkbox" id="okCheckbox"  class="flat-red" name="okCheckbox" checked="checked" value="1" disabled><label for="okCheckbox"> Operasi';
											echo ' | <a href="'.base_url('ok/okcdaftar/pemeriksaan_ok').'/'.$data_pasien[0]['no_ipd'].'" target="_blank"> Progres</a></label>';
										}
									}?>
								</label>
							</div>
						</div>
						<div class="form-group col-sm-6">
								<div class="demo-checkbox">
								<label class="checkbox-inline ">
								<?php 
									if($row->status_lab>='1'){
										if($row->lab=='0'){
										echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox"  value="1" ><label for="labCheckbox"> Lab | '.$row->status_lab.' Done</label>';
										} else {
											echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox" checked="checked" value="1" disabled><label for="labCheckbox"> Lab';
											echo ' | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$data_pasien[0]['no_ipd'].'" target="_blank">Progress</a></label>';
										}
									}
									else { 
										if($row->lab=='0'){
										echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox"  value="1"><label for="labCheckbox"> Lab</label>';
										} else {
											echo '<input type="checkbox" id="labCheckbox"  class="flat-red" name="labCheckbox" checked="checked" value="1" disabled><label for="labCheckbox"> Lab';
											echo ' | <a href="'.base_url('lab/labcdaftar/pemeriksaan_lab').'/'.$data_pasien[0]['no_ipd'].'" target="_blank"> Progress</a></label>';
										}
									}?>
								</label>
								</div>
						</div>
						
						<div class="form-group col-sm-6">
							<div class="demo-checkbox">
								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_rad>='1'){
										if($row->rad=='0'){
										echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox"  value="1"><label for="radCheckbox"> Radiologi | '.$row->status_rad.' Done</label>';
										} else {
											echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox" checked="checked" value="1" disabled><label for="radCheckbox"> Radiologi';
											echo ' | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$data_pasien[0]['no_ipd'].'/DOKTER" target="_blank"> Progress</a></label>';
										}
									}
									else { 
										if($row->rad=='0'){
										echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox" value="1"><label for="radCheckbox"> Radiologi</label>';
										} else {
											echo '<input type="checkbox" id="radCheckbox"  class="flat-red" name="radCheckbox" checked="checked" value="1" disabled><label for="radCheckbox"> Radiologi';
											echo ' | <a href="'.base_url('rad/radcdaftar/pemeriksaan_rad').'/'.$data_pasien[0]['no_ipd'].'/DOKTER" target="_blank"> Progress</a></label>';
										}
									}?>
								</label>
							</div>
						</div>
						

                        <div class="form-group col-sm-6">
							<div class="demo-checkbox">
								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_obat>='1'){
										if($row->obat=='0'){
										echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox"  value="1"><label for="obatCheckbox"> Obat | '.$row->status_obat.' Done</label>';
										} else {
											echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox" checked="checked" value="1" disabled><label for="obatCheckbox"> Obat';
											echo ' | <a href="'.base_url('farmasi/frmcdaftar/permintaan_obat').'/'.$data_pasien[0]['no_ipd'].'/DOKTER" target="_blank"> Progress</a></label>';
										}
									}
									else { 
										if($row->obat=='0'){
										echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatCheckbox" value="1"><label for="obatCheckbox"> Obat </label>';
										} else {
											echo '<input type="checkbox" id="obatCheckbox"  class="flat-red" name="obatradCheckbox" checked="checked" value="1" disabled><label for="obatradCheckbox"> Obat';
											echo ' | <a href="'.base_url('farmasi/frmcdaftar/permintaan_obat').'/'.$data_pasien[0]['no_ipd'].'/DOKTER" target="_blank"> Progress</a></label>';
										}
									}?>
								</label>
							</div>
						</div>


						<div class="form-group col-sm-6">
							<div class="demo-checkbox">
								<label class="checkbox-inline no_indent">
								<?php 
									if($row->status_em>='1'){
										if($row->em=='0'){
										echo '<input type="checkbox" id="emCheckbox"  class="flat-red" name="emCheckbox"  value="1"><label for="emCheckbox"> Elektromedik | '.$row->status_em.' Done</label>';
										} else {
											echo '<input type="checkbox" id="emCheckbox"  class="flat-red" name="emCheckbox" checked="checked" value="1" disabled><label for="emCheckbox"> Elektromedik';
											echo ' | <a href="'.base_url('elektromedik/emcdaftar/pemeriksaan_em').'/'.$data_pasien[0]['no_ipd'].'" target="_blank"> Progress</a></label>';
										}
									}
									else { 
										if($row->em=='0'){
										echo '<input type="checkbox" id="emCheckbox"  class="flat-red" name="emCheckbox" value="1"><label for="emCheckbox"> Elektromedik</label>';
										} else {
											echo '<input type="checkbox" id="emCheckbox"  class="flat-red" name="emCheckbox" checked="checked" value="1" disabled><label for="emCheckbox"> Elektromedik';
											echo ' | <a href="'.base_url('elektromedik/emcdaftar/pemeriksaan_em').'/'.$data_pasien[0]['no_ipd'].'" target="_blank"> Progress</a></label>';
										}
									}?>
								</label>
							</div>
						</div>


			
							<div class="col-sm-12" align="right">	
							
								<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd">
								<input type="hidden" class="form-control" value="<?php echo $linkheader;?>" name="linkheader">
									<button type="submit" class="btn btn-primary btn-sm"> Simpan </button>
							</div>	
					</div>			
						</div>
					<?php } ?>
					<?php echo form_close();?>
					</div>
				</div>			 -->
				
			</div>	
		</div>
	