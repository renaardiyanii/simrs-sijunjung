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
          url:"<?php echo base_url(); ?>master/mcsatuan_obat/insert_satuan",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Satuan Obat';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Satuan Obat';
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
          url:"<?php echo base_url(); ?>master/mcsatuan_obat/edit_satuan",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Obat Konsinyasi';
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
            document.getElementById("btn-edit").innerHTML = 'Edit Obat Konsinyasi';
            $('myModalEdit').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });  
  } );
  //---------------------------------------------------------

  function edit_satuan(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/Mcsatuan_obat/get_data_edit')?>",
      data: {
        id: id
      },
      success: function(data){
	//alert(data[0].id_dokter);
        $('#edit_id').val(data[0].id_satuan);
        $('#edit_id_hidden').val(data[0].id_satuan);
        $('#edit_satuan').val(data[0].nm_satuan);
      },
      error: function(){
        alert("error");
      }
    });
  }

  function hapus_satuan(id_satuan){
    if (confirm('Yakin Menghapus Satuan Obat?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/Mcsatuan_obat/delete_satuan_obat/')?>"+id_satuan,
        data: {
          id_satuan: id_satuan
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
          <h3 class="text-white">DAFTAR SATUAN OBAT</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcsatuan_obat/insert_satuan');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Satuan Baru</button>
              </span>
            </div><!-- /input-group --> 
          </div><!-- /col-lg-6 -->

          <!-- Modal Insert Obat -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Satuan Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan Obat</p>
                      <div class="col-sm-8">
                        <!-- <input type="hidden" class="form-control" name="id_satuan" id="id"> -->
                        <input type="text" class="form-control" name="satuan" id="satuan">
                      </div>
                    </div>
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Satuan</button>
                </div>
              </div>
            </div>
          </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->
          <br/> 
          <br/> 

          <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Satuan Obat</th>
                <!-- <th>Jenis</th> -->
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($satuan as $row){
              ?>
              <tr>
                <td width="10%"><?php echo $i++;?></td>
                <td><?php echo $row->nm_satuan;?></td>
                <td align="center" width="10%">
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalEdit"  onclick="edit_satuan('<?php echo $row->id_satuan;?>')"><i class="fa fa-edit"></i></button>
                  <button class="btn btn-danger btn-sm" onclick="hapus_satuan('<?php echo $row->id_satuan;?>')"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
      </div>
    </div>
  </div>
</section>

  <!-- <?php echo form_open('master/mcsatuan_obat/edit_satuan');?> -->

        <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Update Satuan -->
          <div class="modal fade" id="myModalEdit" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Satuan Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">

                  <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Id Satuan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="edit_id" id="edit_id" disabled="">
                        <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan Obat</p>
                      <div class="col-sm-8">
                        <!-- <input type="hidden" class="form-control" name="id_satuan" id="id"> -->
                        <input type="text" class="form-control" name="edit_satuan" id="edit_satuan">
                      </div>
                    </div>
                </div>
		
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Update Satuan</button>
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
