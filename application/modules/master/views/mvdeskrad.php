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
  $(".select2").select2();


  $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/Mcdeskrad/insert_deskripsi",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Deskripsi Radiologi ';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Deskripsi Radiologi ';
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
          url:"<?php echo base_url(); ?>master/Mcdeskrad/edit_deskripsi",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit ';
            $('myModalEdit').modal('hide'); 
            document.getElementById("edit_form").reset();
            if (data = true) {        
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
              swal("Error","Data gagal diperbaharui.", "error");
            }
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit ';
            $('myModalEdit').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });  
  } );
  //---------------------------------------------------------

  function edit_deskripsi(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcdeskrad/get_data_edit')?>",
      data: {
        id: id
      },
      success: function(data){
	//alert(data[0].id_dokter);
        $('#edit_id').val(data[0].id);
        $('#edit_id_hidden').val(data[0].id);
        $('#edit_judul').val(data[0].judul);
        $('#edit_isi').val(data[0].isi);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_deskripsi(id){
    if (confirm('Yakin Menghapus Deskripsi Radiologi ?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcdeskrad/delete_deskripsi/')?>"+id,
        data: {
          id: id
        },
        success: function(data){
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
        },
        error: function(){
          swal("Error","Data gagal dihapus.", "error");
          // alert("error");
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
          <h3 class="text-white">DAFTAR DESKRIPSI RADIOLOGI</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/Mcdeskrad/insert_deskripsi');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Deskripsi Radiologi Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert  -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Deskripsi Radiologi Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Judul </p>
                      <div class="col-sm-8">
                        <!-- <input type="hidden" class="form-control" name="id" id="id"> -->
                        <input type="text" class="form-control" name="judul" id="judul">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Deskripsi </p>
                      <div class="col-sm-8">
                        <!-- <input type="hidden" class="form-control" name="id" id="id"> -->
                        <textarea class="form-control" name="isi" id="isi" cols="30" rows="10"></textarea>
                      </div>
                    </div>
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Deskripsi Radiologi</button>
                </div>
              </div>
            </div>
          </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->
          <br/> 
          <br/> 

          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul </th>
                <th>Deskripsi </th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($deskripsi as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->judul;?></td>
                <td><?php echo $row->isi;?></td>
                <td align="center">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalEdit"  onclick="edit_deskripsi('<?php echo $row->id;?>')"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-danger btn-sm" onclick="hapus_deskripsi('<?php echo $row->id;?>')"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</section>

      <!-- <?php echo form_open('master/Mcdeskrad/edit_deskripsi');?> -->

        <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Update Deskripsi Radiologi -->
          <div class="modal fade" id="myModalEdit" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Deskripsi Radiologi</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">

                  <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_id" id="edit_id" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Judul </p>
                      <div class="col-sm-8">
                        <!-- <input type="hidden" class="form-control" name="id" id="id"> -->
                        <input type="text" class="form-control" name="edit_judul" id="edit_judul">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_deskripsi">Deskripsi Radiologi </p>
                      <div class="col-sm-8">
                        <!-- <input type="hidden" class="form-control" name="id" id="id"> -->
                        <textarea class="form-control" name="edit_isi" id="edit_isi" cols="30" rows="10"></textarea>
                      </div>
                    </div>
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Update Deskripsi Radiologi</button>
                </div>
              </div>
            </div>
          </div>
          </div>
        </form>
      <!-- <?php echo form_close();?> -->

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
