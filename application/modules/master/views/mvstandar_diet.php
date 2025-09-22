<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<style type="text/css">
  .table-wrapper-scroll-y {
    display: block;
    max-height: 400px;
    overflow-y: auto;
    -ms-overflow-style: -ms-autohiding-scrollbar;
  }
  .modal {
    overflow-y:auto;
  }
  .modal-edit-poli .modal-header {
    background: rgb(0, 141, 76);
    border-bottom-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-edit-poli .modal-footer {
    background: rgb(0, 141, 76);
    border-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-edit-poli .modal-body {
    background: rgb(0, 166, 90);
    color: #fff;
  }
  .modal-tambah-poli .modal-header {
    background: rgb(0, 141, 76);
    border-bottom-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-tambah-poli .modal-footer {
    background: rgb(0, 141, 76);
    border-color: rgb(0, 115, 62);
    color: #fff;
  }
  .modal-tambah-poli .modal-body {
    background: rgb(0, 166, 90);
    color: #fff;
  }
</style>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();

    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });

    $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcstandar_diet/insert",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Tambah Standar Diet';
            $('#myModal').modal('hide'); 
            document.getElementById("insert_form").reset();
            if (data = true) {        
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
              console.log(data)
            } else {
              swal("Error","Data gagal disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-insert").innerHTML = 'Tambah standar diet';
            $('#myModal').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
    }); 


    $('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcstandar_diet/edit_standar_diet",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Standar Diet';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            if (data = true) {        
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
              swal("Error","Data gagal disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit Standar Diet';
            $('#editModal').modal('hide');
            swal("Error","Data gagal disimpan.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
    });

    $('#delete_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-delete").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> non active...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcstandar_diet/delete_standar_diet",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-delete").innerHTML = 'Hapus Standar Diet';
            $('#deleteModal').modal('hide'); 
            document.getElementById("delete_form").reset();
            if (data = true) {        
              swal({
									title: "Selesai",
									text: "Data berhasil di non active",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								});
            } else {
              swal("Error","Data gagal di non active.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-delete").innerHTML = 'Hapus standar Diet';
            $('#deleteModal').modal('hide');
            swal("Error","Data gagal dihapus.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
    });
      
    $('#active_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-active").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> active...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcstandar_diet/active_standar_diet",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-active").innerHTML = 'active Standar Diet';
            $('#activeModal').modal('hide'); 
            document.getElementById("active_form").reset();
            if (data = true) {        
              swal({
									title: "Selesai",
									text: "Data berhasil active",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								});
            } else {
              swal("Error","Data gagal active.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-active").innerHTML = 'Active standar Diet';
            $('#activeModal').modal('hide');
            swal("Error","Data gagal active.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
    });

    });



   
      
      

    


  

  function edit_standar_diet(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcstandar_diet/get_data_edit_standar_diet')?>",
      data: {
        id: id
      },
      success: function(data){
        $('#edit_id_standar_diet').val(data[0].id);
        $('#edit_standar_diet').val(data[0].standar_diet);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function delete_standar_diet(id) {
    $('#delete_id').val(id);
  }

  function active_standar_diet(id) {
    $('#active_id').val(id);
  }
  //---------------------------------------------------------


</script>
<section class="content-header">
  <?php
    echo $this->session->flashdata('success_msg');
  ?>
</section>

<section class="content">
  <div class="row" id="row">
    <div class="col-sm-12">
      <div class="card card-outline-primary">
        <div class="card-header">
          <h3 class="text-white">DAFTAR STANDAR DIET</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>
         <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah Standar Diet Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" aria-labelledby="header-modal-tambah" aria-hidden="true">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" id="header-modal-tambah"><b>Tambah Standar Diet Baru</b></h4>
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_nm_poli">Nama </p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="standar_diet" required>
                      </div>
                  </div>             		  
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Tambah</button>
                </div>
              </div>
            </div>
          </div>
          </form>
	        <hr>
          <br/> 
          <br/> 

          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>stndar Diet</th>
                <th>Aksi</th>
              </tr>
            </thead>           
            <tbody>
              <?php
                  $i=1;
                  foreach($standar_diet as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->standar_diet;?></td>
                <td>
                <button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_standar_diet('<?php echo $row->id;?>')"><i class="fa fa-edit"></i></button>
                <button type="button" title="Non-Aktif" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="delete_standar_diet('<?php echo $row->id;?>')"><i class="fa fa-close"></i></button>
                <button type="button" title="Aktif" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#activeModal" onclick="active_standar_diet('<?php echo $row->id;?>')"><i class="fa fa-check"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

         
        </div>
      </div>
    </div>
</section>

    <form method="POST" id="insert_role_form" class="form-horizontal">


      <!-- Modal Insert Obat -->
      <div class="modal fade" id="myModalRoleForm" role="dialog" aria-labelledby="header-modal-tambah" aria-hidden="true">
        <div class="modal-dialog modal-success modal-lg">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="header-modal-tambah"><b>Tambah Role Form Baru</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">

              <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Hak Akses</label>
                <div class="col-sm-9">
                  <div id="body-modal"></div>										
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <input type="hidden" class="form-control"  name="id_form" id="id_form">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              <button class="btn btn-primary" type="submit" id="btn-insert">Simpan</button>
            </div>
          </div>
        </div>
      </div>
    </form>


    <form method="POST" id="edit_form" class="form-horizontal"> 
        <!-- Modal Edit Obat -->
        <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
          <div class="modal-dialog modal-success">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit standar Diet</h4>
              </div>
              
              <div class="modal-body">
                <div class="form-group row">
                  <div class="col-sm-1"></div>
                  <p class="col-sm-3 form-control-label" id="lbl_nmdiagnosa">Nama standar Diet</p>
                  <div class="col-sm-6">
                  <input type="hidden" class="form-control" name="edit_id_standar_diet" id="edit_id_standar_diet">
                    <input type="text" class="form-control" name="edit_standar_diet" id="edit_standar_diet">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
              </div>
            </div>
          </div>
        </div>
    </form>

    <form method="POST" id="delete_form" class="form-horizontal"> 
          <div class="modal fade" id="deleteModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
            <input type="hidden" class="form-control" name="delete_id" id="delete_id">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yakin mau non active ?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                  <button class="btn btn-primary" type="submit" id="btn-delete">Ya</button>
                </div>
              </div>
            </div>
          </div>
    </form>

    <form method="POST" id="active_form" class="form-horizontal"> 
          <div class="modal fade" id="activeModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
            <input type="hidden" class="form-control" name="active_id" id="active_id">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yakin mau active ?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                  <button class="btn btn-primary" type="submit" id="btn-active">Ya</button>
                </div>
              </div>
            </div>
          </div>
    </form>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
