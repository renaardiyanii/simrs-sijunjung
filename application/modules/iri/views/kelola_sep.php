<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<style type="text/css">
  	th { font-size: 14px; }  	
</style>
<script type="text/javascript">
  var table_sep;

  $(document).ready(function() {
 
    table_sep = $('#table-sep').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "language": {
        "searchPlaceholder": " No. SEP, Nama"
      },
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('iri/kelola_sep/get_sep')?>",
        "type": "POST"
      },
      "columnDefs": [{ 
        "orderable": false,
        "targets": 6
      }],
   
    });
      
  });

function buat_sep(no_sep) {
     swal({
        title: "Hapus SEP",
        text: "Yakin akan menghapus Nomor SEP tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
              type: "POST",
              url: "<?php echo base_url().'bpjs/sep/hapus_sep'; ?>",
              dataType: "JSON",
              data: {'no_sep' : no_sep,'jnsPelayanan' : '1'},
              success: function(data){  
                  if (data.metadata.code == '200') {
                    table_sep.ajax.reload();
                      swal("Sukses", "SEP berhasil dihapus.", "success");
                  } else {
                      swal("Error", data.metadata.message, "error");
                  }
              },
              error:function(event, textStatus, errorThrown) {    
                  swal("Error","Gagal menghapus SEP.", "error");     
                  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
              }
          });
      });
}

function hapus_sep(no_sep) {
	   swal({
        title: "Hapus SEP",
        text: "Yakin akan menghapus Nomor SEP tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
          $.ajax({
  		        type: "POST",
  		        url: "<?php echo base_url().'bpjs/sep/hapus_sep'; ?>",
  		        dataType: "JSON",
  		        data: {'no_sep' : no_sep,'jnsPelayanan' : '1'},
  		        success: function(data){  
  		          	if (data.metadata.code == '200') {
  		          		table_sep.ajax.reload();
  		              	swal("Sukses", "SEP berhasil dihapus.", "success");
  		          	} else {
  		              	swal("Error", data.metadata.message, "error");
  		          	}
  		        },
  		        error:function(event, textStatus, errorThrown) {    
  		            swal("Error","Gagal menghapus SEP.", "error");     
  		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
  		        }
      		});
      });
}

function update_tglplg() {
          $.ajax({
              type: "POST",
              url: "<?php echo base_url().'bpjs/sep/update_tglplg'; ?>",
              dataType: "JSON",
              data: {'no_sep' : $('#no_sep').val(),'tgl_pulang' : $('#tgl_pulang').val(),'jnsPelayanan' : '1'},
              success: function(data){  
                  if (data.metadata.code == '200') {
                      table_sep.ajax.reload();
                      swal("Sukses", "Tanggal Pulang Berhasil diupdate.", "success");
                  } else {
                      swal("Error", data.metadata.message, "error");
                  }
              },
              error:function(event, textStatus, errorThrown) {    
                  swal("Error","Gagal mengupdate tanggal pulang.", "error");     
                  console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
              }
          });
}

function update_sep(no_sep) {
  $.ajax({
    type: "POST",
    url: "<?php echo base_url().'iri/kelola_sep/get_pasien_iri'; ?>",
    dataType: "JSON",
    data: {'no_sep' : no_sep},
    success: function(data) {
      $('#modal_update').modal('show');
      $('#no_sep').val(no_sep);
      $('#tgl_pulang').val(data.tgl_keluar);
    },
    error:function(event, textStatus, errorThrown) {    
        swal("Error","Gagal load data.", "error");     
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
    }
  });
	
}

function cetak_sep(no_register) {   
  $.ajax({
    type: "POST",
    url: "<?php echo base_url().'bpjs/sep/show/'; ?>"+no_register,
    dataType: "JSON",    
    success: function(result){  
        if (result.metaData.code == '200') {          
          window.open('<?php echo base_url().'bpjs/sep/irj/'; ?>'+no_register, '_blank');
        } else if (result.metaData.code == 'No.SEP Harus Diisi 19 digit') {    
          swal("SEP Tidak Ditemukan","No. SEP Harus 19 digit.", "warning");  
        } else {
          swal("Gagal mencetak SEP", result.metaData.message, "error");           
        }
    },
    error:function(event, textStatus, errorThrown) {    
        swal(errorThrown,textStatus, "error");    
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
    }
  });
}

function penjaminan_sep(no_register) {     
  swal({
      title: "Pengajuan Penjaminan SEP",
      text: "Isi keterangan pengajuan :",
      type: "input",
      showCancelButton: true,
      closeOnConfirm: false,
      confirmButtonText: "Submit",
      animation: "slide-from-top",
      inputPlaceholder: "Isi keterangan",
      showLoaderOnConfirm: true
  }, function(keterangan){
      if (keterangan === false) return false;
      if (keterangan === "") {
        swal.showInputError("Keterangan tidak boleh kosong!");
        return false
      } 
      $.ajax({
        type: "POST",
        url: "<?php echo base_url().'bpjs/sep/pengajuan_penjaminan_irj/'; ?>"+no_register,
        dataType: "JSON",    
        data: {'keterangan' : keterangan},
        success: function(result) {   
            if (result.metaData.code == '200') {          
              window.open('<?php echo base_url().'bpjs/sep/create_irj/'; ?>'+no_register, '_blank');
            } else {
              swal("Penjaminan SEP Gagal",result.metaData.message, "error");            
            }
        },
        error:function(event, textStatus, errorThrown) {    
            swal(errorThrown,textStatus, "error");     
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
      });     
  });  
}

</script>

<div>
  <div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 text-white">Kelola SEP Rawat Inap</h4></div>
            <div class="card-block">                    
              <div class="table-responsive m-t-0">      
             <table id="table-sep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>No. SEP</th>
                  <th>No. RM</th>
                  <th>Nama</th>
                  <th>No. Kartu</th>
                  <th>Tgl Masuk</th>                  
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->     
    
  </div>
</div>

	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_update">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="title_modal">Update SEP</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body">
                    <input type="hidden" class="form-control" name="no_sep" id="no_sep">
                   	<ul class="nav nav-tabs customtab" role="tablist">
                       	<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#data" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan</span></a> </li>
                       	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tglpulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Tanggal Pulang</span></a> </li>
                   	</ul>
                    <div class="tab-content">
                        <div class="tab-pane active p-20" id="data" role="tabpanel">
                        	<form class="form-horizontal" id="form_catatan">
                            <div class="form-group row">
                  <label for="example-number-input" class="col-sm-2 col-form-label">Tanggal SEP</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="tgl_sep" id="tgl_sep">
                  </div>
                </div>
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-2 col-form-label">Catatan</label>
								  <div class="col-sm-9">
								    <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-2 col-sm-9">	
								    <button type="button" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                        <div class="tab-pane  p-20" id="tglpulang" role="tabpanel">
                        	<form class="form-horizontal" id="form_tglpulang">
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-3 col-form-label">Tanggal Pulang</label>
								  <div class="col-sm-6">
								   	<input type="text" class="form-control" name="tgl_pulang" id="tgl_pulang">
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-3 col-sm-9">	
								    <button type="button" class="btn btn-primary" onclick="update_tglplg('')"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                    </div>                                 
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal Update SEP -->

<?php
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
?>