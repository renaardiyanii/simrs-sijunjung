    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<script type='text/javascript'>
var table_prosedur;
  $(document).ready(function() {

    $('#edit_prosedur').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-edit").innerHTML = '';
    });
    $('#add_prosedur').on('hidden.bs.modal', function () {
      document.getElementById("alert-modal-add").innerHTML = '';
    });  

    table_prosedur = $('#table-prosedur').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [ [20, 25, 50, -1], [20, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('master/prosedur/get_prosedur')?>",
        "type": "POST"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "20%",
        "targets": 3 // column index 
      }],   
    });

  });

  function delete_prosedur(id_procedure){
     swal({
        title: "Hapus Prosedur",
        text: "Yakin akan menghapus prosedur tersebut?",
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
                url: "<?php echo base_url().'master/prosedur/delete_prosedur'; ?>",
                dataType: "JSON",
                data: {'id_procedure' : id_procedure},
                success: function(data){  
                  if (data == true) {
                      table_prosedur.ajax.reload();
                      swal({
                            title: "Selesai",
                            text: "Data berhasil dihapus",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });                  
                  } else {
                      swal("Error","Gagal menghapus prosedur.", "error"); 
                  }
                },
                error:function(event, textStatus, errorThrown) {    
                    swal("Error","Gagal menghapus prosedur.", "error");     
                    console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                }
            });
      });
  }

  function show_prosedur(id_prosedur){
    $.ajax({
        type: "GET",
        url: "<?php echo base_url().'master/prosedur/show_prosedur/'; ?>"+id_prosedur,
        dataType: "JSON",
        success: function(data){
          $('#id_prosedur').val(data.id);
          $('#id_tind').val(data.id_tind);
          $('#nm_tindakan').val(data.nm_tindakan);
          $('#edit_prosedur').modal('show');
        },
        error:function(event, textStatus, errorThrown) {
            swal("Error","Load data tidak berhasil.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

  function update_prosedur(){
    document.getElementById("submit_edit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'master/prosedur/edit_prosedur'; ?>",
        dataType: "JSON",
        data: $('#form_edit').serialize(),
        success: function(data){
          if (data == true) {
            document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            $('#edit_prosedur').modal('hide');  
            table_prosedur.ajax.reload();
            swal({
                            title: "Selesai",
                            text: "Data berhasil diperbaharui",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
          } else {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          }
        },
        error:function(event, textStatus, errorThrown) {
              document.getElementById("alert-modal-edit").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_edit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  }     

  function insert_prosedur(){
    console.log($('#form_add').serialize());
    document.getElementById("submit_add").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'master/prosedur/insert_prosedur'; ?>",
        dataType: "JSON",
        data: $('#form_add').serialize(),
        success: function(data){
          if (data == true) {
          document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';            
            $('#add_prosedur').modal('hide');  
            table_prosedur.ajax.reload();
            swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true
                        },
                        function () {
                            window.location.reload();
                        });
          } else {
              document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          }
        },
        error:function(event, textStatus, errorThrown) {
              document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  }     



</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

  <div class="row">
  <div class="col-lg-12 col-md-12">
    <div class="card">                  
      <div class="card-block p-b-15">
      <div class="d-flex flex-wrap">
          <div>
              <h3 class="card-title">Daftar Prosedur</h3>
              <h6 class="card-subtitle">Kelola data prosedur (ICD-9-CM).</h6> </div>
          <div class="ml-auto">
              <button class="btn btn-primary" data-toggle="modal" data-target="#add_prosedur">
            <i class="fa fa-plus"></i> Tambah Prosedur
        </button>
          </div>
      </div>
       
      <br>     
              <div class="table-responsive">         
              <table id="table-prosedur" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Kode</th>
                  <th>Prosedur</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>
                
                </tbody>
              </table>
              </div>
             <!--  </div> -->
            </div>
            <!-- /.card-block -->
      </div> <!-- .card -->
      </div>
  </div>

 <div class="modal fade" id="edit_prosedur" tabindex="-1" role="dialog" aria-labelledby="edit_prosedur">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Edit Prosedur</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <div id="alert-modal-edit"></div>  
                                                <form class="form-horizontal" id="form_edit">  
                                                <div class="form-group row">
                                                  <label for="add_idtind" class="col-2 col-form-label">Kode</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="id_tind" name="id_tind" required>
                                                  </div>
                                                </div>  
                                                <div class="form-group row">
                                                  <label for="add_nmtindakan" class="col-2 col-form-label">Prosedur</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nm_tindakan" name="nm_tindakan" required>
                                                  </div>
                                                </div>     
                                                <input type="hidden" class="form-control" name="id_prosedur" id="id_prosedur">          
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="submit_edit" onclick="update_prosedur()"><i class="fa fa-floppy-o"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->

  <div class="modal fade" id="add_prosedur" tabindex="-1" role="dialog" aria-labelledby="add_prosedur">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Tambah Prosedur</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <div id="alert-modal-add"></div>  
                                                <form class="form-horizontal" id="form_add">  
                                                <div class="form-group row">
                                                  <label for="add_idtind" class="col-2 col-form-label">Kode</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="add_idtind" name="add_idtind" required>
                                                  </div>
                                                </div>  
                                                <div class="form-group row">
                                                  <label for="add_nmtindakan" class="col-2 col-form-label">Prosedur</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="add_nmtindakan" name="add_nmtindakan" required>
                                                  </div>
                                                </div>               
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="submit_add" onclick="insert_prosedur()"><i class="fa fa-floppy-o"></i> Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 