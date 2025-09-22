<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 

<script src="<?php echo site_url('assets/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script type='text/javascript'>
//-----------------------------------------------Data Table
$(document).ready(function() {
    // $('#example').DataTable({
    // 	"aLengthMenu": [100]
    // });
    // CKEDITOR.replace('makroskopik');
    // CKEDITOR.replace('mikroskopik');
	// <?php if($jenis_blanko==2){ ?>
    // CKEDITOR.replace('saran');
	// <?php } ?>
    // CKEDITOR.replace('kesimpulan');
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
        url:"<?php echo base_url('pa/pacpengisianhasil/simpan_hasil')?>",
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
			url:"<?php echo base_url('pa/pacpengisianhasil/simpan_hasil')?>",
	        type: "POST",
	        data: $('#formSave').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
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
			url:"<?php echo base_url('pa/pacpengisianhasil/edit_hasil_submit')?>",
	        type: "POST",
	        data: $('#formEdit').serialize(),
	        dataType: "JSON",
	        success: function(data)
	        {

	            if(data.status) //if success close modal and reload ajax table
	            {
	            	// $('#myCheckboxes').iCheck('uncheck');
	                // $('#pemeriksaanModal').modal('hide');
	                // $("#form_table").load("<?php echo base_url('pa/pacpengisianhasil/daftar_hasil').'/'.$no_pa;?> #form_table");
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

function cetak(id_pemeriksaan, no_pa) {
	var myWindow = window.open("<?php echo base_url('pa/pacpengisianhasil/cetak_hasil_pa_tindakan')?>/"+id_pemeriksaan+"/"+no_pa, "_blank");
		myWindow.focus();
}

</script>

<style>
	.cetak_hasil {
		background-color: #50CB93 !important;
	}
</style>

<?php include('pavdatapasien.php');
$itot=0;?>

<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white">Pengisian Hasil Tes Patologi Anatomi : <?php echo $no_pa; ?></h4>
            </div>
            <div class="card-block">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
									<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th>No PA</th>
											  <th>ID Tindakan</th>
											  <th>Nama Pemeriksaan</th>
											  <th>Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
												$i=1;
												foreach($daftarpengisian as $row){

													if($row->cetak_hasil == 1) {
														$cetak_hasil = 'cetak_hasil';
													} else {
														$cetak_hasil = '';
													}
											?>
												<tr>
												  	<td class ="<?php echo $cetak_hasil;?>"><?php echo $row->no_pa;?></td>
													<td class ="<?php echo $cetak_hasil;?>"><?php echo $row->id_tindakan;?></td>
												  	<td class ="<?php echo $cetak_hasil;?>"><?php echo $row->jenis_tindakan;?></td>
													<?php 
													if($row->id_hasil_pemeriksaan==''){ ?>

													<td class ="<?php echo $cetak_hasil;?>">
														<a href="<?php echo site_url('pa/pacpengisianhasil/isi_hasil/'.$row->id_pemeriksaan_pa); ?>" class="btn btn-primary">Isi Hasil</a>
													</td>

													<?php }else{ ?>

														<td class ="<?php echo $cetak_hasil;?>">
															<div class="form-inline">
																<a href="javascript:;" class="btn btn-danger" style="margin-right: 5px;" onClick="return openUrl('<?php echo site_url('pa/pacpengisianhasil/edit_hasil/'.$row->id_pemeriksaan_pa); ?>');">Edit Hasil</a>
																<form id="pengisianhasilform" method="post">
																	<input type="hidden" name="id_dokter" id="id_dokter" value="<?php echo $row->id_dokter?>">
																	<input type="hidden" name="nm_dokter" id="nm_dokter" value="<?php echo $row->nm_dokter?>">
																	<input type="hidden" name="id_pemeriksaan_rad" id="id_pemeriksaan_rad" value="<?php echo $row->id_pemeriksaan_pa?>">
																	<input type="hidden" name="no_cm" id="no_cm" value="<?php echo $no_cm?>">
																	<input type="hidden" name="hasil_pengirim" id="hasil_pengirim" value="<?php echo $row->hasil_pa?>">
																	
																</form>
																<a href="<?php echo base_url('pa/pacpengisianhasil/st_cetak_hasil_pa/'.$row->id_pemeriksaan_pa.'/'.$row->no_pa);?>" class="btn btn-success" style="margin-left: 5px;" onClick="cetak('<?php echo $row->id_pemeriksaan_pa ?>','<?php echo $row->no_pa ?>');">SELESAI</a>
															</div>
														</td>
													<?php }
													
													?>
													
												</tr>
											<?php
													$i++;
												}
											?>
										</tbody>
									</table>	
								<?php 
									echo form_close();
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