<?php
$this->load->view('layout/header_form');
include('script_rjvpelayanan.php');

?>

<div class="card m-5">
<div class="card-body">

<div class="p-20">
									<!-- <a class="btn btn-success" href=" <?php echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$no_medrec); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Diagnosa Sebelumnya</i> </a>&nbsp;&nbsp;&nbsp; -->
									<button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#histori" onclick="history_diagnosa()"><i class="fa fa-binoculars">&nbsp; Diagnosa Sebelumnya</i> </button>&nbsp;&nbsp;&nbsp;
									<?php if($id_poli == 'BH00' || $id_poli == 'BH03') { ?>
										<a class="btn btn-success" href=" <?php echo site_url('irj/rjcpelayananfdokter/form/assesment_medik_dok/'.$id_poli.'/'.$no_register); ?>"><i class="fa fa-binoculars">&nbsp; kembali</i> </a>&nbsp;&nbsp;&nbsp;
									<?php } else { ?>
										<a class="btn btn-success" href=" <?php echo site_url('irj/rjcpelayananfdokter/form/assesment_medik_dok/'.$id_poli.'/'.$no_register); ?>"><i class="fa fa-binoculars">&nbsp; kembali</i> </a>&nbsp;&nbsp;&nbsp;
									<?php } ?>
										
										<div class="form-group row">
									        <label for="id_diagnosa" class="col-3 col-form-label">Diagnosa (ICD-10)</label>
									        <div class="col-9">
												<input type="text" class="form-control input-sm" onkeyup="ajaxhistorysearch(this.value.toUpperCase())" id="cari_diag" name="cari_diag" placeholder="Pencarian Diagnosa">
												<input type="hidden" name="id_diagnosa" id="id_diagnosa">
									        </div>
									    </div><br>		
										<div class="form-group row">
									        <label for="diagnosa_text" class="col-3 col-form-label">Catatan</label>
									        <div class="col-9">
									            <textarea class="form-control" name="diagnosa_text" id="diagnosa_text" cols="30" rows="5" style="resize:vertical"></textarea>
									        </div>
									    </div><br>    	
										<div class="form-group row">
											<div class="offset-sm-3 col-sm-9">									
												<!-- <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button> -->
												<button type="button" class="btn btn-primary" id="btn-diagnosa" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
											</div>
										</div>	
										<div class="table-responsive">
											<table id="table_diagnosa" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
											  	<thead>
												    <tr>
												      <th class="text-center">No</th>
												      <th>Diagnosa</th>
												      <th>Catatan</th>
												      <th class="text-center">Klasifikasi</th>
												      <th class="text-center">Aksi</th>
												    </tr>
												</thead>
												<tbody>
												</tbody>
											</table>
										</div> <!-- table-responsive -->
                                    </div>
</div>
</div>
</div>

<div class="modal fade" tabindex="-1" id="histori" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<form id="form-diagnosa-submit" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">History Diagnosa</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="fomr-inline row">
                        <div class="col-sm-1"></div>
                        <p class="form-control-label col-sm-2" id="nmdokter"><b>Cari </b></p>
                        <div class="col-sm-1"></div>
                        <input type="text" name="keyword" id="keyword" class="form-control col-sm-7" onkeyup="ajaxhistorysearch(this.value.toUpperCase())"  placeholder="Cari Nama Diagnosa..." style="width: 300px;"/>                    
                    </div>
                </div>                                      
                    <div class="form-inline" id="id_diagnosa_history">
                    
                    </div>
            </div>
            <div class="modal-footer">
				<input type="hidden" name="no_register" value="<?= $no_register ?>">
				<input type="hidden" name="tgl_masuk" value="<?= $data_pasien_daftar_ulang->tgl_kunjungan ?>">
				
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
	</form>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
			$('#form-diagnosa-submit').on('submit', function(e){  
				e.preventDefault();             
				$.ajax({  
				url:"<?php echo base_url(); ?>irj/diagnosa/insert_all",                         
				method:"POST",  
				data:new FormData(this),  
				contentType: false,  
				cache: false,  
				processData:false,  
				success: function(data)  
				{ 
					
					new swal({
							title: "Selesai",
							text: "Data berhasil disimpan",
							icon: "success",
							buttons: false, // menonaktifkan tombol
							timer: 800, // menampilkan dialog selama 2 detik
						}).then(() => {
							window.location.reload(); // memuat ulang halaman setelah dialog ditutup
						});
				},
				error:function(event, textStatus, errorThrown) {
					document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					new swal("Error","Data gagal disimpan.", "error"); 
					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}  
				});   
			});
		});
    $('#cari_diag').autocomplete({

source : function( request, response ) {
    $.ajax({
        url: '<?php echo base_url()?>farmasi/Frmcdaftar/cari_data_diagnosawithid',
        dataType: "json",
        data: {
            term: request.term
        },
        success: function (data) {
        if(!data.length){
            var result = [{
                label: 'Data tidak ditemukan', 
                value: response.data    
                }];
            response(result); 
        } else {
            response(data);                  
        }                  
        }
    });
},
select: function (event, ui) {    
    $('#cari_diag').val(ui.item.id_diag+'-'+ui.item.nama);
    $('#id_diagnosa').val(ui.item.id_diag+'@'+ui.item.nama); 
}
});

function insert_diagnosa() {
	$('#btn-diagnosa').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('irj/diagnosa/insert')?>",
        dataType: "JSON",
        data: {
          "no_register" : "<?php echo $no_register; ?>",
          "tgl_masuk" : "<?php echo $data_pasien_daftar_ulang->tgl_kunjungan; ?>",
          "diagnosa" : $('#id_diagnosa').val(),
          "diagnosa_text" : $('#diagnosa_text').val(),
          "cari_diag" : $('#cari_diag').val()
        },
        success: function(result) {
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	if (result.metadata.code) {            

	            if (result.metadata.code == '200') {                      
	              table_diagnosa.ajax.reload();   
					// location.reload();

	              $('#id_diagnosa').val(null).trigger('change');
	              $('#diagnosa_text').val('');
	              $('#cari_diag').val('');
				  //$('#tabDiagnosa')[0].reset();
	              toastr.success('Diagnosa berhasil disimpan.', 'Sukses!');
	            } else if (result.metadata.code == '422') {             
	              toastr.warning('Silahkan pilih diagnosa yang lain.', 'Diagnosa sudah ada.');
	            } else {              
					new Swal({
							icon: 'info',
							title: 'Perhatian!!',
							text: 'Diagnosa harus diisi',
							showConfirmButton: false,
							timer: 1500
						});      
	            }                   
          	} else toastr.error('Silahkan coba kembali.', 'Gagal menginput diagnosa.');          
        },
        error:function(event, textStatus, errorThrown) {  
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput diagnosa.');   
        }
    });
}

function delete_diagnosa(id) {  

$.ajax({
	type: "POST",
	url: "<?php echo base_url().'irj/diagnosa/delete'; ?>",
	dataType: "JSON",
	data: {"id_diagnosa_pasien" : id,"no_register" : '<?php echo $no_register ?>'},                            
 
	success: function(result){   
	  if (result) {  
		new swal({
			title: "Selesai",
			text: "Data berhasil disimpan",
			icon: "success",
			buttons: false, // menonaktifkan tombol
			timer: 800, // menampilkan dialog selama 2 detik
		}).then(() => {
			window.location.reload(); // memuat ulang halaman setelah dialog ditutup
		});
	  
		$('#id_procedure').val('');
		$('#procedure_text').val('');
		table_diagnosa.ajax.reload();
   

			 
	  } 
	  else{
		new swal("Error", "Diagnosa Gagal dihapus.", "warning");
		$('#id_procedure').val('');
		$('#procedure_text').val('');
		table_diagnosa.ajax.reload();

	  }
	},
	error:function(event, textStatus, errorThrown) { 
	  new swal("Gagal menghapus procedure", textStatus, "error");          
	  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	}
});


  
}

function history_diagnosa(){
		ajaxku = buatajax();
		var url="<?php echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>";
		ajaxku.onreadystatechange=stateChangedHistory;
		ajaxku.open("GET",url,true);
		ajaxku.send(null);
}

// function ajaxhistorysearch(text){
// 	ajaxku = buatajax();
// 	var url="<?php echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>";
// 	url=url+"/"+text;
// 	ajaxku.onreadystatechange=stateChangedHistory;
// 	ajaxku.open("GET",url,true);
// 	ajaxku.send(null);
// }

function ajaxhistorysearch(text){
	ajaxku = buatajax();
	var url="<?php echo site_url('reports/Pasien/get_diagnosa_by_medrek/'.$data_pasien_daftar_ulang->no_cm); ?>";
	url=url+"/"+text;
	ajaxku.onreadystatechange=stateChangedHistory;
	ajaxku.open("GET",url,true);
	ajaxku.send(null);
}

//$('#diagnosaHistory').modal('show');

function stateChangedHistory(){
	var data;
	// alert(ajaxku.responseText);
	if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_diagnosa_history").innerHTML = data;
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
</script>

