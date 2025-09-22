<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
	$ada_kultur = false;
	$ada_pewarnaan = false;
?> 
<style>
	select.form-control:not([size]):not([multiple]) {
		height: 0;
	}
	.form-control{
		/* min-height:20px!important; */
		width:auto!important;
	}
	#notifications {
		cursor: pointer;
		position: fixed;
		right: 0px;
		z-index: 9999;
		top: 100px;
		margin-bottom: 22px;
		margin-right: 15px;
		max-width: 300px;
	}
</style>
<script src="<?= base_url('assets/notify.js') ?>"></script>

<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable({
    	"aLengthMenu": [150]
    });
} );
//---------------------------------------------------------

		
function isi_value(isi_value, id) {
	document.getElementById(id).value = isi_value;
}	
var site = "<?php echo site_url();?>";
function simpan_hasil(id) {
	var x = document.getElementById(id).value;
	dataString = 'id='+id+'&val='+x;
	$.ajax({
        type: "GET",
        url:"<?php echo base_url('lab/Labcpengisianhasil/simpan_hasil')?>",
		data: dataString,
        cache: false,
        success: function(html) {	
            location.reload();
        }
    });
}

function simpan(){
	swal({
	  	title: "Simpan Data",
	  	text: "Benar Akan Menyimpan Data?",
	  	type: "info",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	showLoaderOnConfirm: true,
	},
	function(){
		$.ajax({
			url:"<?php echo base_url('lab/labcpengisianhasil/simpan_hasil')?>",
	        type: "POST",
	        data: $('#formSave').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {
				// console.log(data)

	            if(data.status) //if success close modal and reload ajax table
	            {
	            	// $('#myCheckboxes').iCheck('uncheck');
	                // $('#pemeriksaanModal').modal('hide');
	                // $("#form_table").load("<?php echo base_url('lab/labcpengisianhasil/daftar_hasil').'/'.$no_lab;?> #form_table");

	    			// swal("Data Pemeriksaan Berhasil Disimpan.");

	    			swal({
					  	title: "Data Pemeriksaan Berhasil Disimpan.",
					  	text: "Akan menghilang dalam 3 detik.",
					  	timer: 3000,
					  	showConfirmButton: false,
					  	showCancelButton: true
					});
	                window.location.reload();
	            }


	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	         	window.location.reload()
        	}
    	});
	});
}


function simpan_nama_organisme_kultur()
{
	var nama_organisme_kultur = $('#nama_organisme_kultur').val();

	$.ajax({
		type: "POST",
		url: "<?=base_url('lab/Labcpengisianhasil/input_nama_organisme_kultur')?>",
		data: {
			no_lab: "<?=$no_lab?>",
			nama_organisme_kultur : nama_organisme_kultur
		},
		success: function (data) {
			swal({
				icon:"success",
				title: "Berhasil",
				text: "Data Berhasil Disimpan",
			});
			// Notify("Nama Organisme Berhasil Disimpan", null, null, 'success');
		}
	});
}

function simpan_dokter() {
	var id_dokter = $('#id_dokter').val();
	console.log(id_dokter);
	$.ajax({
		type: "POST",
		url: "<?=base_url('lab/Labcpengisianhasil/input_dokter_lab')?>",
		data: {
			no_lab: "<?=$no_lab?>",
			id_dokter : id_dokter
		},
		dataType: 'text',
		success: function (data) {
			location.reload();
		}
	});
    	
}

function simpan_tgl() {
	var id_tindakan_periksa = $('#id_tindakan_periksa').val();
	var tgl_periksa = $('#tgl_periksa').val();
	var time_periksa = $('#time_periksa').val();
	$.ajax({
		type: "POST",
		url: "<?=base_url('lab/Labcpengisianhasil/input_tgl_lab')?>",
		data: {
			no_lab: "<?=$no_lab?>",
			id_tindakan_periksa : id_tindakan_periksa,
			tgl_periksa : tgl_periksa,
			time_periksa : time_periksa
		},
		dataType: 'text',
		success: function (data) {
			location.reload();
		}
	});
    	
}



function edit(){
	swal({
	  	title: "Edit Data",
	  	text: "Benar Akan Menyimpan Data?",
	  	type: "info",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	showLoaderOnConfirm: true,
	},
	function(){
		$.ajax({
			url:"<?php echo base_url('lab/labcpengisianhasil/edit_hasil_submit')?>",
	        type: "POST",
	        data: $('#formEdit').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	            	// $('#myCheckboxes').iCheck('uncheck');
	                // $('#pemeriksaanModal').modal('hide');
	                // $("#form_table").load("<?php echo base_url('lab/labcpengisianhasil/daftar_hasil').'/'.$no_lab;?> #form_table");
	    			// swal("Data Pemeriksaan Berhasil Disimpan.");

	    			swal({
					  	title: "Data Pemeriksaan Berhasil Diedit.",
					  	text: "Akan menghilang dalam 3 detik.",
					  	timer: 3000,
					  	showConfirmButton: false,
					  	showCancelButton: true
					});
	                window.location.reload();
	            }


	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	         	// window.location.reload();
        	}
    	});
	});
}

function showswal() {
	swal({
		title: "MOHON KEMBALI KE HALAMAN SEBELUMNYA",
		text: "KLIK OK",
		type: "success",
		showConfirmButton: true,
		showCancelButton: false,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	},
	function () {
		// window.location.reload();
			location.href = '<?php echo site_url('lab/labcpengisianhasil');?>';
	});
}

</script>
<?php include('labvdatapasien.php');
$itot=0;?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Pengisian Hasil Tes Laboratorium : <?php echo $no_lab; ?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
							<div class="form-group row">
								<?php 
								if($isedit != 1){ ?>
									<a href="<?= base_url('lab/Labcpengisianhasil/daftar_hasil/'.$no_lab); ?>" class="btn btn-primary">Kembali</a>&nbsp;
								<?php }else{ ?>
									<a href="<?= base_url('lab/labcdaftarhasil'); ?>" class="btn btn-primary">Kembali</a>&nbsp;
								<?php } ?>
								
								<!-- <?php if(substr($no_register,0,2) == 'RJ'){ ?>
									<?php //if($idrg == 'BA00'){ ?>
										<form action="<?= base_url('emedrec/C_emedrec/cetak_cppt_rawat_jalan_by_noreg'); ?>" method="post">
											<input type="hidden" name="user_id" value="<?= $no_register; ?>"> 
											<input type="hidden" name="no_cm" value="<?= $no_cm; ?>">
											<input type="hidden" name="no_medrec" value="<?= $no_medrec; ?>">  
											<button type="submit" class="btn btn-primary" formtarget="_blank" style="padding-left: 10px;padding-right: 10px; ">CPPT</button>
										</form> 
									<?php //}else{ ?>
										
									<?php //} ?>
								<?php }elseif(substr($no_register,0,2) == 'RI') { ?>
									<form action="<?= base_url('emedrec/C_emedrec_iri/get_cppt_iri'); ?>" method="post">
										<input type="hidden" name="user_id" value="<?= $no_register; ?>"> 
										<input type="hidden" name="no_cm" value="<?= $no_cm; ?>">
										<input type="hidden" name="no_medrec" value="<?= $no_medrec; ?>">  
										<button type="submit" class="btn btn-primary" formtarget="_blank" style="padding-left: 10px;padding-right: 10px; ">CPPT</button>
									</form>
								<?php }else{} ?> -->
							</div>
							<div class="form-group row">
								<p class="col-sm-1 form-control-label text-right" id="nmdokter"><b>Dokter</b></p>
								<div class="col-sm-10">
									<div class="form-inline">
										<div class="form-group">
											<select id="id_dokter" class="form-control " name="id_dokter" required="">
												<option value="" disabled selected="">-Pilih Dokter-</option>
												<?php 
													foreach($dokter as $row){
														if($row->id_dokter==$dokter_pengisi->id_dokter){
															echo '<option value="'.$row->id_dokter.'" selected>'.$row->nm_dokter.'</option>';
														}else{
															echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
														}
													}
												?>
											</select>
										</div>
										
										<button type="button" onclick="simpan_dokter()" class="btn btn-primary" style="margin-left: 10px;">Simpan</button>
									</div>
								</div>
							</div>
							<!-- <div class="form-group row">
								<p class="col-sm-1 form-control-label text-right" id="tglperiksa"><b>Tanggal Periksa</b></p>
								<div class="col-sm-10">
									<div class="form-inline">
										<div class="form-group">
											<select id="id_tindakan_periksa" class="form-control " name="id_tindakan_periksa" required="">
												<option value="" disabled selected="">-Pilih Tindakan-</option>
												<?php 
													foreach($daftar_periksa as $row){
														echo '<option value="'.$row->id_tindakan.'">'.$row->jenis_tindakan.'</option>';														
													}
												?>
											</select>
										</div>
										<div class="form-group">
											<input type="date" name="tgl_periksa" id="tgl_periksa" class="form-control">
											<input type="time" name="time_periksa" id="time_periksa" class="form-control">
										</div>
										
										<button type="button" onclick="simpan_tgl()" class="btn btn-primary" style="margin-left: 10px;">Simpan</button>
									</div>
								</div>
								
								


								<div class="col-sm-10">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th><b>Jenis Tindakan</b></th>
												<th><b>Tanggal Periksa</b></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($daftar_periksa as $row){ ?>
											<tr>
												<td><?php echo $row->jenis_tindakan ?></td>
												<td><?php echo $row->tgl_periksa ?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div> -->
						<?php if ($dokter_pengisi->id_dokter == null) { ?>
						<?php }else{ 
							// var_dump($daftarpengisian);die();
							
							?>
							<div class="table-responsive">
								<?php  if($jenis == 'isi'){
									$attributes = array('id' => 'formSave');
									echo form_open('lab/labcpengisianhasil/simpan_hasil', $attributes);
								?>
								<?php
								foreach($daftarpengisian as $row){
									$array = json_decode(json_encode($jenis_hasil_lab), True);
									$data_tindakan=array_column($array, 'idtindakan');
									if(strpos($row->jenis_tindakan, 'Kultur Dan Sensitifity') !== false){
										$ada_kultur = true;
									}
									if(strpos($row->jenis_tindakan, 'Pewarnaan') !== false){
										$ada_pewarnaan = true;
									}
								}
								if(!$ada_kultur && !$ada_pewarnaan){
								?>
									<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Jenis Pemeriksaan</th>
											  <th>Hasil</th>
											  <th>Kadar Normal</th>
											  <th>Satuan</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$ada_kultur = false;
											// print_r($pasien_daftar);
												$i=1;
												$itot = 1;
												foreach($daftarpengisian as $row){
													$array = json_decode(json_encode($jenis_hasil_lab), True);
													$data_tindakan=array_column($array, 'idtindakan');
													if(strpos($row->jenis_tindakan, 'Kultur Dan Sensitifity') !== false){
														$ada_kultur = true;
													}
													// var_dump($data_tindakan);die();
													// var_dump($row);die();
												//$id_pelayanan_poli=$row->id_pelayanan_poli;
													if ((in_array($row->id_tindakan, $data_tindakan) || in_array($row->idtindak, $data_tindakan)) && strpos($row->jenis_tindakan, 'Kultur Dan Sensitifity') === false) {	
											?>
												<tr>
												  	<td><?php echo $i;?>
														<input type="hidden" class="form-control" value="<?php echo $row->idtindak;?>" name="id_tindakan_<?php echo $itot;?>">
														<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab_<?php echo $itot;?>">
													</td>
												  	<td><?php echo $row->jenis_tindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?>
														<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_<?php echo $itot;?>">
														<input type="hidden" class="form-control" value="<?php echo $row->no_urut;?>" name="urut_<?php echo $itot;?>">
												  	</td>
												  	<td><input type="text" class="form-control" name="hasil_lab_<?php echo $itot;?>"></td>
												  	<td><?php echo $row->kadar_normal;?>
														<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_<?php echo $itot;?>">
													</td>
												  	<td><?php echo $row->satuan;?>
														<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_<?php echo $itot;?>">
													</td>
												</tr>
											<?php
													$i++;
													$itot++;;
												} }
											?>
											<!-- <tr>
												<td colspan="2">Keterangan/Catatan</td>
												<td colspan="4"><textarea class="form-control" name="ket" id="" cols="100" rows="5" style="width:50%;"></textarea></td>
											</tr> -->
										</tbody>
									</table>	
									<br><br>
									<?php }if($ada_kultur && !$ada_pewarnaan){
											$get_kultur = $this->labmdaftar->get_nama_organisme_kultur($id_tindakan_hidden,$no_lab); 

										?>
										
										
									<h4>Pemeriksaan Kultur Dan Sensitifity</h4><hr>
									<div class="form-group">
										<label for="">Nama Organisme</label>
										<input type="text" name="nama_organisme_kultur" class="form-control" id="nama_organisme_kultur" value="<?= $get_kultur?$get_kultur->nama_organisme_kultur:'' ?>">
										<button type="button" onclick="simpan_nama_organisme_kultur()" class="btn btn-primary" >Simpan</button>
									</div>
									<table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Jenis Pemeriksaan</th>
											  <!-- <th>Nama Organisme</th> -->
											  <th>antibiotik</th>
											  <th>MIC</th>
											  <th>Sensitifitas</th>
											</tr>
										</thead>
										<tbody id="tambahan-hasil-kultur">
											<?php
												foreach($daftarpengisian as $row){
													$i=1;
													$itot = 1;
													$array = json_decode(json_encode($jenis_hasil_lab), True);
													$data_tindakan=array_column($array, 'idtindakan');
													// var_dump($data_tindakan);die();
													// var_dump($row);die();
												//$id_pelayanan_poli=$row->id_pelayanan_poli;
													if ((in_array($row->id_tindakan, $data_tindakan) || in_array($row->idtindak, $data_tindakan)) && strpos($row->jenis_tindakan, 'Kultur Dan Sensitifity') !== false) {	
											?>
												<tr>
												  	<td><?php echo $i;?>
														<input type="hidden" class="form-control" value="<?php echo $row->idtindak;?>" name="id_tindakan_<?php echo $itot;?>">
														<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab_<?php echo $itot;?>">
													</td>
												  	<td><?php echo $row->jenis_tindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?>
														<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_<?php echo $itot;?>">
												  	</td>
													<!-- <td>
														<input type="text" class="form-control" name="nama_organisme_<?php //echo $itot; ?>" id="">
													</td> -->
													<td>
														<select class="form-control" name="jenis_kuman_<?= $itot; ?>">
															<?php
															foreach($master_jenis_kuman_lab as $val):
															?>
															<option value="">Silahkan Pilih Antibiotik</option>
															<option value="<?= $val->nama ?>"><?= $val->nama ?></option>
															<?php endforeach; ?>
														</select>	
													</td>
												  	<td>
														<input type="text" class="form-control" name="mic_<?= $itot; ?>">
														<?php //echo $row->kadar_normal;?>
														<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_<?php echo $itot;?>">
													</td>
												  	<td>
														<input type="text" class="form-control" name="sensitifitas_<?= $itot; ?>">
														<?php //echo $row->satuan;?>
														<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_<?php echo $itot;?>">
													</td>
												</tr>
											<?php
													$i++;
													$itot++;;
												} }
											?>
											<!-- <tr>
												<td colspan="2">Keterangan/Catatan</td>
												<td colspan="4"><textarea class="form-control" name="ket" id="" cols="100" rows="5" style="width:50%;"></textarea></td>
											</tr> -->
										</tbody>
									</table>
									<button type="button" onclick="tambahhasilkultur()" class="btn btn-primary"><i class="mdi mdi-arrow-down-bold-circle mr-2"></i>Tambah Hasil</button>
									<?php }if($ada_pewarnaan){ ?>
										<!-- pewarnaan -->
										<h4>Pemeriksaan Pewarnaan</h4>
										<table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
											<thead>
												<tr>
												<th>No</th>
												<th>Nama Pemeriksaan</th>
												<th>Jenis Pemeriksaan</th>
												<th>Hasil</th>
												</tr>
											</thead>
											<tbody id="tambahan-hasil-pewarnaan">
												<?php
													foreach($daftarpengisian as $row){
														$i=1;
														$itot = 1;
														$array = json_decode(json_encode($jenis_hasil_lab), True);
														$data_tindakan=array_column($array, 'idtindakan');
														// var_dump($data_tindakan);die();
														// var_dump($row);die();
													//$id_pelayanan_poli=$row->id_pelayanan_poli;
														if ((in_array($row->id_tindakan, $data_tindakan) || in_array($row->idtindak, $data_tindakan)) && strpos($row->jenis_tindakan, 'Pewarnaan') !== false) {	
												?>
													<tr>
														<td><?php echo $i;?>
															<input type="hidden" class="form-control" value="<?php echo $row->idtindak;?>" name="id_tindakan_<?php echo $itot;?>">
															<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab_<?php echo $itot;?>">
														</td>
														<td><?php echo $row->jenis_tindakan;?></td>
														<td><?php echo $row->jenis_hasil;?>
															<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_<?php echo $itot;?>">
														</td>
														<td>
															<select class="form-control" name="hasil_lab_<?= $itot; ?>">
																<option value="Coccus gram (+)">Coccus gram (+)</option>
																<option value="Basill gram (-)">Basill gram (-)</option>
																<option value="Jamur">Jamur</option>
																<option value="Coccus deret gram (+)">Coccus deret gram (+)</option>
																<option value="Coccus gerombol gram (+)">Coccus gerombol gram (+)</option>

																<option value="Basill deret gram negatif">Basill deret gram negatif</option>
																<option value="Basill gerombol gram negatif">Basill gerombol gram negatif</option>
																<option value="cocobasill gram negatif">cocobasill gram negatif</option>
																<option value="cocobasill gram positif">cocobasill gram positif</option>

															</select>	
															<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_<?php echo $itot;?>">
															<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_<?php echo $itot;?>">
														</td>
													</tr>
												<?php
														$i++;
														$itot++;;
													} }
												?>
												<!-- <tr>
													<td colspan="2">Keterangan/Catatan</td>
													<td colspan="4"><textarea class="form-control" name="ket" id="" cols="100" rows="5" style="width:50%;"></textarea></td>
												</tr> -->
											</tbody>
										</table>
										<button type="button" onclick="tambahhasilpewarnaan()" class="btn btn-primary"><i class="mdi mdi-arrow-down-bold-circle mr-2"></i>Tambah Hasil</button>
										
									<?php } ?>

									<!-- end -->
									<div class="form-inline" align="right"><br>
										<input type="hidden" class="form-control" value="<?php echo $no_lab;?>" name="no_lab">
										<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $itot;?>" name="itot" id="itots">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="no_cm">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->nama;?>" name="nama">
										<input type="hidden" class="form-control" value="<?php echo $jk;?>" name="kelamin">
										<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunjungan">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->alamat;?>" name="alamat">
										<input type="hidden" class="form-control" value="<?php echo $drpengirim;?>" name="dokter">
										<input type="hidden" class="form-control" value="<?php echo $dokter_isi->nm_dokter;?>" name="dokter_lab">
										<input type="hidden" class="form-control" value="<?php echo $usia;?>" name="usia">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->cara_bayar;?>" name="cara_bayar">
										<input type="hidden" class="form-control" value="<?php echo $asal;?>" name="asal">
										<input type="hidden" class="form-control" value="<?php echo $ttd;?>" name="ttd">
										<!-- <button type="save" class="btn btn-primary">Simpan</button> -->
									</div>	
										<div>
						                    <hr class="m-t-20">
						                </div>
										<div class="col-md-12" align="right">
					                		<button type="button" id="submit" onclick="simpan()" class="btn btn-info">Simpan</button>
						                </div>

								<?php 
									echo form_close();
								} else {  
									foreach($daftarpengisian as $row){
										$array = json_decode(json_encode($jenis_hasil_lab), True);
										$data_tindakan=array_column($array, 'idtindakan');
										if(strpos($row->nmtindakan, 'Kultur Dan Sensitifity') !== false){
											$ada_kultur = true;
										}
										if(strpos($row->nmtindakan, 'Pewarnaan') !== false){
											$ada_pewarnaan = true;
										}
									}	
								?>
								
								<form action="" method="post" id="formEdit">
									<?php if(!$ada_kultur && !$ada_pewarnaan){ ?>
									<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Jenis Pemeriksaan</th>
											  <th>Hasil</th>
											  <th>Kadar Normal</th>
											  <th>Satuan</th>
											</tr>
										</thead>
										<tbody>
											<?php
											// print_r($pasien_daftar);
												$i=1;
												$itot = 1;
												foreach($daftarpengisian as $row){
												//$id_pelayanan_poli=$row->id_pelayanan_poli;
													if(strpos($row->nmtindakan, 'Kultur Dan Sensitifity') !== false){
														$ada_kultur = true;
													}
													if(strpos($row->nmtindakan, 'Pewarnaan') !== false){
														$ada_pewarnaan = true;
													}
													if(strpos($row->nmtindakan, 'Kultur Dan Sensitifity') === false){
													
											?>
												<tr>
												  	<td><?php echo $i;?>
														<input type="hidden" class="form-control" value="<?php echo $row->id_hasil_pemeriksaan;?>" name="id_hasil_pemeriksaan_<?php echo $i;?>"></td>
												  	<td><?php echo $row->nmtindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?></td>
												  	<td>
													  	<input type="hidden" class="form-control" name="id_tindakan_<?php echo $i;?>" value="<?php echo $row->id_tindakan;?>" style="width:93%;" >
													  	<input type="hidden" class="form-control" name="jenis_hasil_<?php echo $i;?>" value="<?php echo $row->jenis_hasil;?>" style="width:93%;" >
														<input type="hidden" class="form-control" name="kadar_normal_<?php echo $i;?>" value="<?php echo $row->kadar_normal;?>" style="width:93%;" >
														<input type="hidden" class="form-control" name="satuan_<?php echo $i;?>" value="<?php echo $row->satuan;?>" style="width:93%;" >
														<input type="text" class="form-control" name="hasil_lab_<?php echo $i;?>" value="<?php echo $row->hasil_lab;?>" style="width:93%;" >
													</td>
												  	<td><?php echo $row->kadar_normal;?></td>
												  	<td><?php echo $row->satuan;?></td>
												</tr>
											<?php
													$i++;
													$itot++;
												}}
											?>
										</tbody>
									</table>
									
									<?php } 
									if($ada_kultur){
										$i=1;
										$itot = 1;
										$get_kultur = $this->labmdaftar->get_nama_organisme_kultur($id_tindakan_hidden,$no_lab); 
										
										?>
										<br><br>
									<h4>Pemeriksaan Kultur Dan Sensitifity</h4><hr>
									<div class="form-group">
										<label for="">Nama Organisme</label>
										<input type="text" name="nama_organisme_kultur" class="form-control" id="nama_organisme_kultur" value="<?= $get_kultur?$get_kultur->nama_organisme_kultur:'' ?>">
										<button type="button" onclick="simpan_nama_organisme_kultur()" class="btn btn-primary" >Simpan</button>
									</div>
									<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Jenis Pemeriksaan</th>
											  <!-- <th>Nama Organisme</th> -->
											  <th>antibiotik</th>
											  <th>MIC</th>
											  <th>Sensitifitas</th>
											</tr>
										</thead>
										<tbody id="tambahan-hasil-kultur-edit">
											<?php
												foreach($daftarpengisian as $row){
													if (strpos($row->nmtindakan, 'Kultur Dan Sensitifity') !== false) {	
											?>
												<tr>
												  	<td><?php echo $i;?>
													  <input type="hidden" class="form-control" value="<?php echo $row->id_hasil_pemeriksaan;?>" name="id_hasil_pemeriksaan_<?php echo $itot;?>"></td>
													
													</td>
												  	<td><?php echo $row->nmtindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?>
													  <input type="hidden" class="form-control" name="id_tindakan_<?php echo $itot;?>" value="<?php echo $row->id_tindakan;?>" style="width:93%;" >
													  	<input type="hidden" class="form-control" name="jenis_hasil_<?php echo $itot;?>" value="<?php echo $row->jenis_hasil;?>" style="width:93%;" >
														<input type="hidden" class="form-control" name="kadar_normal_<?php echo $itot;?>" value="<?php echo $row->kadar_normal;?>" style="width:93%;" >
														
													</td>
													<!-- <td>
														<input type="text" class="form-control" name="nama_organisme_<?php //echo $itot; ?>" id="" value="<?php //echo $row->nama_organisme ?>">
													</td> -->
													<td>
														<select class="form-control" name="jenis_kuman_<?= $itot; ?>" >
															<?php
															foreach($master_jenis_kuman_lab as $val):
															?>
															<option value="<?= $val->nama ?>" <?= $row->jenis_kuman==$val->nama?'selected':'' ?>><?= $val->nama ?></option>
															<?php endforeach; ?>
														</select>	
													</td>
												  	<td>
														<input type="text" class="form-control" name="mic_<?= $itot; ?>" value="<?= $row->mic ?>">
													</td>
												  	<td>
														<input type="text" class="form-control" name="sensitifitas_<?= $itot; ?>" value="<?= $row->sensitifitas ?>">
													</td>
												</tr>
											<?php
													$i++;
													$itot++;
												} }
											?>
											<!-- <tr>
												<td colspan="2">Keterangan/Catatan</td>
												<td colspan="4"><textarea class="form-control" name="ket" id="" cols="100" rows="5" style="width:50%;"></textarea></td>
											</tr> -->
										</tbody>
									</table>
									<button type="button" onclick="tambahhasilkulturedit()" class="btn btn-primary"><i class="mdi mdi-arrow-down-bold-circle mr-2"></i>Tambah Hasil</button>
									<?php }
									if($ada_pewarnaan){
										$i=1;
										$itot = 1; ?>
										<br><br>
									<h4>Pemeriksaan Pewarnaan</h4>
									<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Jenis Pemeriksaan</th>
											  <th>Hasil</th>
											</tr>
										</thead>
										<tbody id="tambahan-hasil-pewarnaan-edit">
											<?php
												foreach($daftarpengisian as $row){
													if (strpos($row->nmtindakan, 'Pewarnaan') !== false) {	
											?>
												<tr>
												  	<td><?php echo $i;?>
													  <input type="hidden" class="form-control" value="<?php echo $row->id_hasil_pemeriksaan;?>" name="id_hasil_pemeriksaan_<?php echo $itot;?>"></td>
													
													</td>
												  	<td><?php echo $row->nmtindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?>
													  <input type="hidden" class="form-control" name="id_tindakan_<?php echo $itot;?>" value="<?php echo $row->id_tindakan;?>" style="width:93%;" >
													  	<input type="hidden" class="form-control" name="jenis_hasil_<?php echo $itot;?>" value="<?php echo $row->jenis_hasil;?>" style="width:93%;" >
														<input type="hidden" class="form-control" name="kadar_normal_<?php echo $itot;?>" value="<?php echo $row->kadar_normal;?>" style="width:93%;" >
														
													</td>
													<td>
														<select class="form-control" name="hasil_lab_<?= $itot; ?>">
															<option value="Coccus gram (+)" <?php echo $row->hasil_lab == 'Coccus gram (+)'?'selected':'';?>>Coccus gram (+)</option>
															<option value="Basill gram (-)" <?php echo $row->hasil_lab == 'Basill gram (-)'?'selected':'';?>>Basill gram (-)</option>
															<option value="Jamur" <?php echo $row->hasil_lab == 'Jamur'?'selected':'';?>>Jamur</option>
															<option value="Coccus deret gram (+)" <?php echo $row->hasil_lab == 'Coccus deret gram (+)'?'selected':'';?>>Coccus deret gram (+)</option>
															<option value="Coccus gerombol gram (+)" <?php echo $row->hasil_lab == 'Coccus gerombol gram (+)'?'selected':'';?>>Coccus gerombol gram (+)</option>

															<option value="Basill deret gram negatif" <?php echo $row->hasil_lab == 'Basill deret gram negatif'?'selected':'';?>>Basill deret gram negatif</option>
															<option value="Basill gerombol gram negatif" <?php echo $row->hasil_lab == 'Basill gerombol gram negatif'?'selected':'';?>>Basill gerombol gram negatif</option>
															<option value="cocobasill gram negatif" <?php echo $row->hasil_lab == 'cocobasill gram negatif'?'selected':'';?>>cocobasill gram negatif</option>
															<option value="cocobasill gram positif" <?php echo $row->hasil_lab == 'cocobasill gram positif'?'selected':'';?>>cocobasill gram positif</option>

														</select>	
													</td>
												  	
												</tr>
											<?php
													$i++;
													$itot++;
												} }
											?>
											<!-- <tr>
												<td colspan="2">Keterangan/Catatan</td>
												<td colspan="4"><textarea class="form-control" name="ket" id="" cols="100" rows="5" style="width:50%;"></textarea></td>
											</tr> -->
										</tbody>
									</table>
									<button type="button" onclick="tambahhasilpewarnaanedit()" class="btn btn-primary"><i class="mdi mdi-arrow-down-bold-circle mr-2"></i>Tambah Hasil</button>
									<?php } ?>


									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $itot;?>" name="itot" id="itot-edit">
										<input type="hidden" class="form-control" value="<?php echo $no_lab;?>" name="no_lab"><br>
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="no_cm">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->nama;?>" name="nama">
										<input type="hidden" class="form-control" value="<?php echo $jk;?>" name="kelamin">
										<input type="hidden" class="form-control" value="<?php echo $tgl_kun;?>" name="tgl_kunjungan">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->alamat;?>" name="alamat">
										<input type="hidden" class="form-control" value="<?php echo $drpengirim;?>" name="dokter">
										<input type="hidden" class="form-control" value="<?php echo $dokter_isi->nm_dokter;?>" name="dokter_lab">
										<input type="hidden" class="form-control" value="<?php echo $usia;?>" name="usia">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->cara_bayar;?>" name="cara_bayar">
										<input type="hidden" class="form-control" value="<?php echo $asal;?>" name="asal">
										<input type="hidden" class="form-control" value="<?php echo $ttd;?>" name="ttd">
									</div>	
									<div>
					                    <hr class="m-t-20">
					                </div>
									<div class="col-md-12" align="right">										
										<button type="button" id="submit" onclick="edit()" class="btn btn-info">Edit Data</button><br><br>
										
										<div>
												<hr class="m-t-20">
											</div>
										
					                </div>
								</form>
									
								<?php 
									
								} 
								?>

										<br>
							</div>
						<?php } ?>                            
                        </div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<script>
	let i = <?= $i; ?>;
	let itot = <?= $itot; ?>;

	function tambahhasilpewarnaanedit()
	{
		let html = `
		<tr>
			<td>${i}
				<input type="hidden" class="form-control" value="<?php echo $row->id_tindakan??'';?>" name="id_tindakan_${itot}">
			</td>
			<td><?php echo $row->jenis_hasil??'';?></td>
			<td><?php echo $row->jenis_hasil??'';?>
				<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_${itot}">
			</td>
			<td>
				<select class="form-control" name="hasil_lab_${itot}">
					<option value="Coccus gram (+)">Coccus gram (+)</option>
					<option value="Basill gram (-)">Basill gram (-)</option>
					<option value="Jamur">Jamur</option>
					<option value="Coccus deret gram (+)">Coccus deret gram (+)</option>
					<option value="Coccus gerombol gram (+)">Coccus gerombol gram (+)</option>

					<option value="Basill deret gram negatif">Basill deret gram negatif</option>
					<option value="Basill gerombol gram negatif">Basill gerombol gram negatif</option>
					<option value="cocobasill gram negatif">cocobasill gram negatif</option>
					<option value="cocobasill gram positif">cocobasill gram positif</option>

				</select>	
			</td>
		</tr>
		`;

		i++;itot++;
		$("#itot-edit").val(itot);
		$("#tambahan-hasil-pewarnaan-edit").append(html);
	}

	function tambahhasilkulturedit()
	{
		let html = `
		<tr>
			<td>${i}
				<input type="hidden" class="form-control" value="<?php echo $row->id_tindakan??'';?>" name="id_tindakan_${itot}">
			</td>
			<td><?php echo $row->jenis_hasil??'';?></td>
			<td><?php echo $row->jenis_hasil??'';?>
				<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_${itot}">
			</td>
			<td>
				<select class="form-control" name="jenis_kuman_${itot}">
					<?php
					foreach($master_jenis_kuman_lab as $val):
					?>
					<option value="<?= $val->nama ?>"><?= $val->nama ?></option>
					<?php endforeach; ?>
				</select>	
			</td>
			<td>
				<input type="text" class="form-control" name="mic_${itot}">
				<?php //echo $row->kadar_normal;?>
				<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_${itot}">
			</td>
			<td>
				<input type="text" class="form-control" name="sensitifitas_${itot}">
				<?php //echo $row->satuan;?>
				<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_${itot}">
			</td>
		</tr>
		`;

		i++;itot++;
		$("#itot-edit").val(itot);
		$("#tambahan-hasil-kultur-edit").append(html);
	}
	function tambahhasilkultur()
	{
		let html = `
		<tr>
			<td>${i}
				<input type="hidden" class="form-control" value="<?php echo $row->idtindak??'';?>" name="id_tindakan_${itot}">
				<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab??'';?>" name="id_pemeriksaan_lab_${itot}">
			</td>
			<td><?php echo $row->jenis_tindakan??'';?></td>
			<td><?php echo $row->jenis_hasil??'';?>
				<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_${itot}">
			</td>
			<td>
				<select class="form-control" name="jenis_kuman_${itot}">
					<?php
					foreach($master_jenis_kuman_lab as $val):
					?>
					<option value="<?= $val->nama ?>"><?= $val->nama ?></option>
					<?php endforeach; ?>
				</select>	
			</td>
			<td>
				<input type="text" class="form-control" name="mic_${itot}">
				<?php //echo $row->kadar_normal;?>
				<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_${itot}">
			</td>
			<td>
				<input type="text" class="form-control" name="sensitifitas_${itot}">
				<?php //echo $row->satuan;?>
				<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_${itot}">
			</td>
		</tr>
		`;
		i++;itot++;
		$("#itots").val(itot);
		$("#tambahan-hasil-kultur").append(html);
	}
	function tambahhasilpewarnaan()
	{
		let html = `
		<tr>
			<td>${i}
				<input type="hidden" class="form-control" value="<?php echo $row->idtindak??'';?>" name="id_tindakan_${itot}">
				<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab??'';?>" name="id_pemeriksaan_lab_${itot}">
			</td>
			<td><?php echo $row->jenis_tindakan??'';?></td>
			<td><?php echo $row->jenis_hasil??'';?>
				<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_${itot}">
			</td>
			<td>
				<select class="form-control" name="hasil_lab_${itot}">
					<option value="Coccus gram (+)">Coccus gram (+)</option>
					<option value="Basill gram (-)">Basill gram (-)</option>
					<option value="Jamur">Jamur</option>
					<option value="Coccus deret gram (+)">Coccus deret gram (+)</option>
					<option value="Coccus gerombol gram (+)">Coccus gerombol gram (+)</option>

					<option value="Basill deret gram negatif">Basill deret gram negatif</option>
					<option value="Basill gerombol gram negatif">Basill gerombol gram negatif</option>
					<option value="cocobasill gram negatif">cocobasill gram negatif</option>
					<option value="cocobasill gram positif">cocobasill gram positif</option>

				</select>	
				<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_${itot}">
				<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_${itot}">
			</td>
		</tr>
		`;
		i++;itot++;
		$("#itots").val(itot);
		$("#tambahan-hasil-pewarnaan").append(html);
	}
</script>

<?php
	$this->load->view('layout/footer_left.php');
?>