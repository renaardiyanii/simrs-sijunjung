<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?> 

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
	         	// window.location.reload()
        	}
    	});
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

function simpan_ket() {
	var catatan = $('#catatan').val();

	$.ajax({
		type: "POST",
		url: "<?=base_url('lab/Labcpengisianhasil/input_keterangan_pemeriksaan')?>",
		data: {
			no_lab: "<?=$no_lab?>",
			catatan : catatan
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
	                // window.location.reload();
	            }


	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {
	         	window.location.reload();
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
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
							
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
							
						<?php if ($dokter_pengisi->id_dokter == null) { ?>
						<?php }else{ ?>
							<?php  if($jenis == 'isi'){
									$attributes = array('id' => 'formSave');
									echo form_open('lab/labcpengisianhasil/simpan_hasil', $attributes);
								?>

								<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Jenis Pemeriksaan</th>
											  <th>Hasil</th>
											  <th>Nilai Normal</th>
											  <th>Satuan</th>
											</tr>
										</thead>
										<tbody>
											<?php
											// print_r($pasien_daftar);
												$i=1;
												foreach($daftarpengisian as $row){
												//$id_pelayanan_poli=$row->id_pelayanan_poli;
												
											?>
												<tr>
												  	<td><?php echo $i;?>
														<input type="hidden" class="form-control" value="<?php echo $row->id_tindakan;?>" name="id_tindakan_<?php echo $i;?>">
														<input type="hidden" class="form-control" value="<?php echo $row->id_pemeriksaan_lab;?>" name="id_pemeriksaan_lab_<?php echo $i;?>">
													</td>
												  	<td><?php echo $row->jenis_tindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?>
														<input type="hidden" class="form-control" value="<?php echo $row->jenis_hasil;?>" name="jenis_hasil_<?php echo $i;?>">
												  	</td>
												  	<td><input type="text" class="form-control" name="hasil_lab_<?php echo $i;?>"></td>
												  	<td><?php echo $row->kadar_normal;?>
														<input type="hidden" class="form-control" value="<?php echo $row->kadar_normal;?>" name="kadar_normal_<?php echo $i;?>">
													</td>
												  	<td><?php echo $row->satuan;?>
														<input type="hidden" class="form-control" value="<?php echo $row->satuan;?>" name="satuan_<?php echo $i;?>">
													</td>
												</tr>
											<?php
													$i++;
													$itot++;;
												}
											?>
										</tbody>
									</table>
									<div class="form-inline" align="right"><br>
										<input type="hidden" class="form-control" value="<?php echo $no_lab;?>" name="no_lab">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $itot;?>" name="itot">
										
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
									$attributes2 = array('id' => 'formEdit');
									echo form_open('lab/labcpengisianhasil/edit_hasil_submit', $attributes2);
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
											// print_r($pasien_daftar);
												$i=1;
												foreach($daftarpengisian as $row){
												//$id_pelayanan_poli=$row->id_pelayanan_poli;
												
											?>
												<tr>
												  	<td><?php echo $i;?>
														<input type="hidden" class="form-control" value="<?php echo $row->id_hasil_pemeriksaan;?>" name="id_hasil_pemeriksaan_<?php echo $i;?>"></td>
												  	<td><?php echo $row->nmtindakan;?></td>
												  	<td><?php echo $row->jenis_hasil;?></td>
												  	<td><input type="text" class="form-control" name="hasil_lab_<?php echo $i;?>" value="<?php echo $row->hasil_lab;?>"></td>
												  	<td><?php echo $row->kadar_normal;?></td>
												  	<td><?php echo $row->satuan;?></td>
												  	
												</tr>
											<?php
													$i++;
													$itot++;
												}
											?>
										</tbody>
									</table>

									<div class="form-inline" align="right">
										<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
										<input type="hidden" class="form-control" value="<?php echo $itot;?>" name="itot">
										<input type="hidden" class="form-control" value="<?php echo $no_lab;?>" name="no_lab"><br>
										<!-- <button type="save" class="btn btn-primary">Edit Data</button> -->
									</div>	
									<div>
					                    <hr class="m-t-20">
					                </div>
									<div class="col-md-12" align="right">
										<button type="button" id="submit" onclick="edit()" class="btn btn-info">Edit Data</button>
					                </div>

								<?php 
									echo form_close();
								?>

								<div class="col-md-12" align="right">
									<a href="<?php echo base_url('lab/labcpengisianhasil/cetak_hasil_lab/'.$no_lab);?>" target="_blank" class="btn btn-block btn-inverse btn-lg">PREVIEW</a>
								</div><br>
								<?php echo form_open('lab/labcpengisianhasil/st_cetak_hasil_lab',array('target'=>'_blank')); ?>
									<select hidden id="no_lab" class="form-control" name="no_lab"  required>
										<?php 
											echo "<option value='$no_lab' selected>$no_lab</option>";
										?>
									</select>
									<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_lab);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->

									<div class="col-md-12" align="right">
										<button type="submit" class="btn btn-block btn-info btn-lg" onclick="showswal()">SELESAI</button>
									</div>
								<?php echo form_close(); ?>	
							        
						<?php }} ?>                            
                        </div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('tgl_periksa').valueAsDate = new Date();

Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

$(document).ready( function() {
    $('#tgl_periksa').val(new Date().toDateInputValue());
});​


</script>

<?php
	$this->load->view('layout/footer_left.php');
?>