<?php 
$this->load->view('layout/header_form');
?>

<?php 
	//include('script_rdvpelayanan.php');	
	?>
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script type="text/javascript">



</script>



<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>Prosedur</h5>
        </div>
    </div>

    <div class="card-body">	
		<div class="tab-pane p-20" id="tabProsedur" role="tabpanel">
			<div class="p-20">
					<div class="form-group row mb-4">
						<label for="id_procedure" class="col-3 col-form-label">Prosedur (ICD-9-CM)</label>
						<div class="col-9">
								<input type="text" class="form-control input-sm autocomplete_procedure"  name="id_procedure" id="id_procedure" style="max-width:450px;font-size:15px;">
								<input type="hidden" class="form-control " name="procedure_separate" id="procedure_separate">
						</div>
					</div>	
					<div class="form-group row mb-4">
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
								<button type="button" class="btn btn-primary" id="btn-procedure" onclick="insert_procedure()"><i class="fa fa-floppy-o"></i> Simpan</button>								
						</div>
					</div>									
			

				<hr>
				
			</div>
        </div>
    </div>

    <div class="card-foother">
    </div>
</div>

<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>Riwayat Prosedur</h5>
        </div>
    </div>

    <div class="card-body">	
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
				</div>
    </div>
</div>

<script>
	$(".autocomplete_procedure").autocomplete({  
      minLength: 2,  
      source : function( request, response ) {
          $.ajax({
            url: '<?php echo site_url('ird/rdcpelayanan/autocomplete_procedure')?>',
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
              if(!data.length){
                var result = [{
                 label: 'Data tidak ditemukan', 
                 value: response.term
                }];
                response(result);
              } else {
                response(data);                  
              }                  
            }
          });
      },      
      minLength: 1,     
      select: function (event, ui) {          
          $('#procedure_separate').val(ui.item.id_tind+'@'+ui.item.nm_tindakan);                    
      }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    });
	
	
function insert_procedure() {
    document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'irj/rjcpelayanan/insert_procedure'; ?>",
        dataType: "JSON",
        data: {
          "noreg_procedure" : "<?php echo $no_register; ?>",
          "tgl_kunjungan" : "<?php echo $data_pasien_daftar_ulang->tgl_kunjungan; ?>",
          "id_dokter" : "<?php echo $data_pasien_daftar_ulang->id_dokter; ?>",
          "dokter" : "<?php echo $data_pasien_daftar_ulang->dokter; ?>",
          "id_poli" : "<?php echo $data_pasien_daftar_ulang->id_poli; ?>",
          "id_procedure" : $('#id_procedure').val(),
          "procedure_text" : $('#procedure_text').val(),
          "procedure_separate":$('#procedure_separate').val()
        },
        success: function(result){    
            new Swal({
								icon: 'success',
								title: 'Prosedur berhasil disimpan',
								showConfirmButton: false,
								timer: 1500
							});
          document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          $('#id_procedure').val('');
          $('#procedure_text').val('');
          table_procedure.ajax.reload(); 
        },
        error:function(event, textStatus, errorThrown) { 
          document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';  
            new Swal({
								icon: 'error',
								title: 'Gagal menginput procedure',
                text: textStatus,
								showConfirmButton: true,
								timer: 1500
							});        
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
}

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
	"url": "<?php echo site_url('ird/rdcpelayanan/procedure_pasien')?>",
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



function delete_procedure(id) {       
  new swal({
        title: "Hapus Prosedur",
        text: "Hapus prosedur tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true             
      }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url().'irj/rjcpelayanan/hapus_procedure/'; ?>"+id,
                  dataType: "JSON",                    
                  data: {"id" : id,"no_register" : "<?php echo $no_register; ?>"},                    
                  success: function(data){  
                    if (data == true) {
                      table_procedure.ajax.reload();
                      new Swal({
                          icon: 'success',
                          title: 'Prosedur berhasil dihapus.',
                          showConfirmButton: true,
                          timer: 1500
                        }); 
                      // document.getElementById("form_add_procedure").reset();
                    } else {   
                    new Swal({
                          icon: 'error',
                          title: 'Gagal menghapus data. Silahkan coba lagi.',
                          showConfirmButton: true,
                          timer: 1500
                        });          
                    } 
                  },
                  error:function(event, textStatus, errorThrown) {    
                    new Swal({
                          icon: 'error',
                          title: 'Gagal Menghapus prosedur',
                          showConfirmButton: false,
                          timer: 1500
                        }); 
                      console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                  }
              });   
            } else if (result.isDenied) {
				        new Swal({
                          icon: 'error',
                          title: 'Batal Hapus prosedur',
                          showConfirmButton: false,
                          timer: 1500
                        });  
            }
          
      });  
} 



function set_utama_procedure(id) {
	new swal({
        title: "Set Utama",
        text: "Set utama prosedur tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya",
        showLoaderOnConfirm: true,
        closeOnConfirm: true   
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
              $.ajax({
                type: 'POST',
                url: "<?php echo site_url('irj/rjcpelayanan/set_utama_procedure')?>",
                dataType:"JSON",
                data: {"id" : id,"no_register" : "<?php echo $no_register;?>"},
                    success: function(data){			        	
                      if (data == true) {
                        table_procedure.ajax.reload();
				              new Swal({
                          icon: 'success',
                          title: 'Prosedur berhasil di set utama.',
                          showConfirmButton: false,
                          timer: 1500
                        });  
                      } else {
				              new Swal({
                          icon: 'error',
                          title: 'Gagal men-set utama prosedur. Silahkan coba lagi.',
                          showConfirmButton: false,
                          timer: 1500
                        });  	        	
                      }			        	
                    },
                error:function(event, textStatus, errorThrown) {
                    console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                },
              });  
            } else if (result.isDenied) {
				        new Swal({
                          icon: 'error',
                          title: 'Batal Hapus prosedur',
                          showConfirmButton: false,
                          timer: 1500
                        });  
            }
          
      });  
}
</script>