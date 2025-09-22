<?php 
$this->load->view('layout/header_form');
?>

<?php 
	//include('script_rdvpelayanan.php');	
	?>

<style>

.select2-selection.required {
   background-color: yellow !important;
}
		</style>

<script type="text/javascript">
$(function() {

    $('#id_diagnosa').select2({
	    placeholder: 'Ketik kode atau nama diagnosa',
	    minimumInputLength: 1,
	    language: {
	      inputTooShort: function(args) {
	        return "Ketik kode atau nama diagnosa";
	      },
	      noResults: function() {
	        return "Diagnosa tidak ditemukan.";
	      },
	      searching: function() {
	        return "Searching.....";
	      }
	    },
	    ajax: {
	      type: 'GET',
	      url: '<?php echo base_url().'ird/Diagnosa/select2'; ?>',
	      dataType: 'JSON',          
	      delay: 250,
	      processResults: function (data) {            
	        return {
	          results: data
	        };
	      },
	      cache: true
	    }
	});

});

function insert_diagnosa() {
	$('#btn-diagnosa').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('ird/diagnosa/insert')?>",
        dataType: "JSON",
        data: {
          "no_register" : "<?php echo $no_register; ?>",
          "tgl_masuk" : "<?php echo $data_pasien_daftar_ulang->tgl_kunjungan; ?>",
          "diagnosa" : $('#id_diagnosa').val(),
          "diagnosa_text" : $('#diagnosa_text').val()
        },
        success: function(result) {
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	if (result.metadata.code) {            
	            if (result.metadata.code == '200') {                      
	              table_diagnosa.ajax.reload();      
	              $('#id_diagnosa').val(null).trigger('change');
	              $('#diagnosa_text').val('');
				  new Swal({
								icon: 'success',
								title: 'Diagnosa berhasil disimpan',
								showConfirmButton: false,
								timer: 1500
							});
				 
	            } else if (result.metadata.code == '422') {     
					new Swal({
								icon: 'info',
								title: 'Diagnosa sudah ada.',
								showConfirmButton: false,
								timer: 1500
							});        
	            } else {   
					new Swal({
								icon: 'info',
								title: 'Perhatian!!',
								text: 'Diagnosa harus diisi',
								showConfirmButton: false,
								timer: 1500
							});               
	            }                   
          	} else {
				new Swal({
								icon: 'error',
								title: 'Gagal menginput diagnosa.',
								showConfirmButton: false,
								timer: 1500
							}); 
			}      
        },
        error:function(event, textStatus, errorThrown) {  
        	$('#btn-diagnosa').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
			new Swal({
								icon: 'error',
								title: 'Gagal menginput diagnosa.',
								text: formatErrorMessage(event, errorThrown),
								showConfirmButton: false,
								timer: 1500
							}); 
        }
    });
}

function set_utama_diagnosa(id_diagnosa_pasien) {
	$.ajax({
					type: 'POST',
					url: "<?php echo site_url('ird/diagnosa/set_utama')?>",
					dataType:"JSON",
					data: {"id_diagnosa_pasien" : id_diagnosa_pasien,"no_register" : '<?php echo $no_register ?>'},
					success: function(data){                
						if (data == true) {            
						table_diagnosa.ajax.reload(); 
						new Swal({
								icon: 'success',
								title: 'Diagnosa berhasil di set menjadi utama',
								showConfirmButton: false,
								timer: 1500
							}); 
						} else {
							new Swal({
								icon: 'error',
								title: 'Gagal men-set utama diagnosa. Silahkan coba lagi.',
								showConfirmButton: false,
								timer: 1500
							});         
						}               
					},
					error:function(event, textStatus, errorThrown) {
						new Swal({
								icon: 'error',
								title: 'Gagal me-set utama',
								text: formatErrorMessage(event, errorThrown),
								showConfirmButton: false,
								timer: 1500
							});              
					},
				});
}

function delete_diagnosa(id) {       
	$.ajax({
					type: "POST",
					url: "<?php echo base_url().'ird/diagnosa/delete'; ?>",
					dataType: "JSON",        
					data: {"id_diagnosa_pasien" : id,"no_register" : '<?php echo $no_register ?>'},             
					success: function(data){  
						if (data == true) {
						table_diagnosa.ajax.reload();
							new Swal({
								icon: 'success',
								title: 'Diagnosa berhasil dihapus',
								showConfirmButton: false,
								timer: 1500
							}); 
						} else {
							new Swal({
								icon: 'error',
								title: 'Gagal menghapus diagnosa. Silahkan coba lagi',
								showConfirmButton: false,
								timer: 1500
							});         
						}
					},
					error:function(event, textStatus, errorThrown) { 
						new Swal({
                          icon: 'error',
                          title: 'Gagal Menghapus Data.',
                          showConfirmButton: false,
                          timer: 1500
                        });     
						toastr.error(formatErrorMessage(event, errorThrown), 'Error!');      
					}
				}); 
} 
</script>



<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>Diagnosa</h5>
        </div>
    </div>

    <div class="card-body">	
        <div class="tab-pane p-20" id="tabDiagnosa" role="tabpanel">
            <div class="p-20">
                <div class="form-group row mb-4">
                    <label for="id_diagnosa" class="col-3 col-form-label">Diagnosa (ICD-10)</label>
                    <div class="col-9">
                        <select class="form-control" name="id_diagnosa" id="id_diagnosa" style="width: 100%;" required></select>
                    </div>
                </div>				
                <div class="form-group row mb-4">
                    <label for="diagnosa_text" class="col-3 col-form-label">Catatan</label>
                    <div class="col-9">
                        <textarea class="form-control" name="diagnosa_text" id="diagnosa_text" cols="30" rows="5" style="resize:vertical"></textarea>
                    </div>
                </div>           	
                <div class="form-group row mb-4">
                    <div class="offset-sm-3 col-sm-9">									
                        <button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                        <button type="button" class="btn btn-primary" id="btn-diagnosa" onclick="insert_diagnosa()"><i class="fa fa-floppy-o"></i> Simpan</button>
                    </div>
                </div>										
                                    
                
            </div>
        </div>
    </div>

    <div class="card-foother">
    </div>
</div>

<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>Riwayat Diagnosa</h5>
        </div>
    </div>

    <div class="card-body">	
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
                </div> 
    </div>
</div>

<script>
	table_diagnosa = $('#table_diagnosa').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('ird/rdcpelayanan/diagnosa_pasien')?>",
        "type": "POST",
        "dataType": 'JSON',
        "data": function (data) {
          data.no_register = '<?php echo $no_register;?>';
        }        
      },
      "columnDefs": [
      { 
        "orderable": false, //set not orderable
        "targets": [0,4] // column index 
      }
      ],
    });	
</script>