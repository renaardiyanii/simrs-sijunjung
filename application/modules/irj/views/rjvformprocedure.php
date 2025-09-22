<?php 
// var_dump($data_pasien_daftar_ulang);
?>

			<!-- form -->
			<form class="form" id="form_add_procedure">
				<div class="form-group row">
	                <label for="id_procedure" class="col-3 col-form-label">Prosedur (ICD-9-CM)</label>
	                <div class="col-9">
	                    	<input type="text" class="form-control input-sm autocomplete_procedure"  name="id_procedure" id="id_procedure" style="max-width:450px;font-size:15px;">
	          				<input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">
	                </div>
	            </div>	
				<div class="form-group row">
	                <label for="procedure_text" class="col-3 col-form-label" id="catatan">Catatan</label>
	                <div class="col-9">
	                    	<textarea class="form-control" name="procedure_text" id="procedure_text" cols="30" rows="5" style="resize:vertical"></textarea>
	                </div>
            	</div>            	
				<div class="form-group row">
					<div class="offset-sm-3 col-sm-9">	
							<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
							<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
							<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
							<input type="hidden" name="tgl_kunjungan" value="<?php echo $tgl_kunjungan;?>">
							<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
							<button type="button" class="btn btn-primary" id="btn-procedure" onclick="masukan_procedure()"><i class="fa fa-floppy-o"></i> Simpan</button>								
					</div>
				</div>									
			</form>
								
		<!-- table -->
		<hr>
		<div class="table-responsive">
			<table id="tabel_procedure" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Prosedur</th>
						<th>Catatan</th>
						<th class="text-center">Klasifikasi</th>
						<th class="text-center">Aksi</th>
					</tr>
				</thead>
				<tbody>
			
				</tbody>
			</table>
		</div> <!-- table-responsive -->


<script>

var table_procedure;
var table_procedure_view;

// if(carabayar=='BPJS'){
	    table_procedure = $('#tabel_procedure').DataTable({ 
	      "processing": true,
	      "serverSide": true,
	      "order": [],
	      "lengthMenu": [
	        [ 10, 25, 50, -1 ],
	        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
	      ],
	      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	      "ajax": {
	        "url": "<?php echo site_url('irj/rjcpelayanan/procedure_pasien')?>",
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
    
    // }



function masukan_procedure() {
	$('#btn-procedure').prop('disabled', true).css('cursor','wait').html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('irj/rjcpelayanan/insert_procedure')?>",
        dataType: "JSON",
        data: {
          "noreg_procedure" : "<?php echo $no_register; ?>",
          "tgl_kunjungan" : "<?php echo $data_pasien_daftar_ulang->tgl_kunjungan; ?>",
          "id_dokter" : "<?php echo $data_pasien_daftar_ulang->id_dokter; ?>",
          "dokter" : "<?php echo $data_pasien_daftar_ulang->dokter; ?>",
          "id_poli" : "<?php echo $data_pasien_daftar_ulang->id_poli; ?>",
          "id_procedure" : $('#id_procedure').val(),
          "procedure_text" : $('#diagnosa_text').val(),
		  "procedure_separate":$('#procedure_separate').val()
        },
        success: function(result) {
        	$('#btn-procedure').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
			document.getElementById("tabel_procedure").reset();
			$('#procedure_separate').val('');
			tabel_procedure.ajax.reload();   
			swal("Sukses", "Prosedur berhasil disimpan.", "success");
  
        },
        error:function(event, textStatus, errorThrown) {  
        	$('#btn-procedure').prop('disabled', false).css('cursor','pointer').html('<i class="fa fa-floppy-o"></i> Simpan');
          	toastr.error(formatErrorMessage(event, errorThrown), 'Gagal menginput Procedure.');   
        }
    });
}
</script>