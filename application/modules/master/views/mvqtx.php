<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script type='text/javascript'>
  //-----------------------------------------------Data Table
  $(document).ready(function() {
    $('#example').DataTable();

    $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcqtx/insert_qtx",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Qtx';
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
            } else {
              swal("Error","Data gagal disimpan.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-insert").innerHTML = 'Insert Qtx';
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
          url:"<?php echo base_url(); ?>master/mcqtx/edit_qtx",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Qtx';
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
            document.getElementById("btn-edit").innerHTML = 'Edit Qtx';
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
          url:"<?php echo base_url(); ?>master/mcqtx/delete_qtx",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-delete").innerHTML = 'Hapus Qtx';
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
            document.getElementById("btn-delete").innerHTML = 'Hapus Qtx';
            $('#deleteModal').modal('hide');
            swal("Error","Data gagal dihapus.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      }); 




      
  } );
  //---------------------------------------------------------

  $(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
  }); 

  function edit_qtx(id_qtx) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcqtx/get_data_edit_qtx')?>",
      data: {
        id_qtx: id_qtx
      },
      success: function(data){
        $('#edit_id_qtx').val(data[0].id_qtx);
        $('#edit_id').val(data[0].id_qtx);
        $('#edit_qtx').val(data[0].qtx);
        //swal("Sukses!", "Data berhasil di edit.", "success");
      },
      error: function(){
        alert("error");
      }
    });
  }

  function delete_qtx(id_qtx) {
    $('#delete_id_qtx').val(id_qtx);
  }

  function hapus_qtx(id_qtx) {
    $('#hapus_id_qtx').val(id_qtx);
  }


  function aktif_qtx(id_qtx){
    if (confirm('Yakin Mengaktifkan Qtx ini?')) {
      // $('#modalLoading').modal('show');
      $.ajax({
        type:'POST',
        url:"<?php echo base_url();?>master/mcqtx/active_qtx/"+id_qtx,
        data: {
          id_qtx: id_qtx
        },  
				contentType: false,  
				cache: false,  
				processData:false, 
        success: function(data){
      // $('#modalLoading').modal('hide');
          swal({
									title: "Selesai",
									text: "Data berhasil diaktifkan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								}); 
        },
        error: function(){
          swal("Error","Data gagal diaktifkan.", "error");
          alert("error");
        }
      });
    } 
  }
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
          <h3 class="text-white">DAFTAR QTX</h3>
        </div>
        <div class="card-block ">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcqtx/insert_qtx');?> -->
          <form method="POST" id="insert_form" class="form-horizontal"> 
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Qtx Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Qtx Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmqtx" >Qtx</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="qtx" id="qtx"  required>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Qtx</button>
                </div>
              </div>
            </div>
          </div>
          
          <!-- <?php echo form_close();?> -->
          </form>
          <br/> 
          <br/> 

          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Qtx</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Qtx</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($qtx as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_qtx;?></td>
                <td><?php echo $row->qtx;?></td>
                <?php if ($row->deleted ==0): ?>
                  <td>ACTIVE</td>
                <?php else: ?>
                  <td>NON-ACTIVE</td>
                <?php endif; ?>
                <td>
                  <button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_qtx('<?php echo $row->id_qtx;?>')"><i class="fa fa-edit"></i></button>
                  
                  <button type="button" title="Non-Aktif" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="delete_qtx('<?php echo $row->id_qtx;?>')"><i class="fa fa-close"></i></button>
                  <button type="button" class="btn btn-success btn-sm" onclick="aktif_qtx('<?php echo $row->id_qtx;?>')"><i class="fa fa-check"></i></button>
                  
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('master/mcqtx/edit_qtx');?> -->
          <form method="POST" id="edit_form" class="form-horizontal"> 
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Qtx</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmqtx">ID Qtx</p>
                    <div class="col-sm-6">
                      <input type="hidden" class="form-control" name="edit_id_qtx" id="edit_id_qtx" >
                      <input type="text" class="form-control" name="edit_id" id="edit_id"  disabled>
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmqtx">Qtx</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_qtx" id="edit_qtx" >
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit Qtx</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->

          
          <!-- <?php echo form_open('master/mcqtx/delete_qtx');?> -->
          <form method="POST" id="delete_form" class="form-horizontal"> 
          <div class="modal fade" id="deleteModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
            <input type="hidden" class="form-control" name="delete_id_qtx" id="delete_id_qtx">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yakin mau non active Qtx?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                  <button class="btn btn-primary" type="submit" id="btn-delete">Ya</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->




          <!-- <form method="POST" id="hapus_form" class="form-horizontal"> 
          <div class="modal fade" id="hapusModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">
            <input type="hidden" class="form-control" name="hapus_id" id="hapus_id"> -->

              <!-- Modal content-->
              <!-- <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yakin mau menghapus Qtx?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
                  <button class="btn btn-primary" type="submit" id="btn-delete">Ya</button>
                </div>
              </div>
            </div>
          </div>
          </form> -->

        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="modalLoading" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title"><b><i class="fa fa-spinner fa-spin" ></i>Loading....</b></h1>
                </div>
              </div>

            </div>
          </div>
</section>


<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>