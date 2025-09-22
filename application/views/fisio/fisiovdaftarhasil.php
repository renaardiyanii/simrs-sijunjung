<?php
	$this->load->view('layout/header_left.php');
?>

<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    $('#example').DataTable({
    	"aLengthMenu": [100]
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
	         	window.location.reload();
        	}
    	});
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
                            <div class="table-responsive">
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
														<input type="hidden" class="form-control" value="<?php echo $row->id_tindakan;?>" name="id_tindakan_<?php echo $i;?>">
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

									echo form_open('lab/labcpengisianhasil/st_cetak_hasil_lab');
								?>
										<select hidden id="no_lab" class="form-control" name="no_lab"  required>
											<?php 
												echo "<option value='$no_lab' selected>$no_lab</option>";
											?>
										</select>
										<!--<a href="<?php //echo site_url('irj/rjckwitansi/st_cetak_kwitansi_kt/'.$no_lab);?>"><input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak"></a>-->

										<div class="col-md-12" align="right">
											<button type="submit" class="btn btn-block btn-inverse btn-lg">Cetak Hasil</button>
						                </div>
										<div>
						                    <hr class="m-t-20">
						                </div>
								<?php 
									echo form_close();

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
								} 
								?>
							</div>
                        </div>
            		</div>
            	</div>
            </div>
        </div>
    </div>
</div>


<?php
	$this->load->view('layout/footer_left.php');
?>