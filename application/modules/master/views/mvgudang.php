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
          url:"<?php echo base_url(); ?>master/mcgudang/insert_gudang",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Gudang';
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
            document.getElementById("btn-insert").innerHTML = 'Insert Gudang';
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
          url:"<?php echo base_url(); ?>master/mcgudang/edit_gudang",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Gudang';
            $('#editModalGudang').modal('hide'); 
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
            document.getElementById("btn-edit").innerHTML = 'Edit Gudang';
            $('#editModalGudang').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
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

  
  function hapus_gudang(id_gudang){
    if (confirm('Yakin Menghapus gudang?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mcgudang/delete_gudang')?>",
        data: {
          id_gudang: id_gudang
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
          //location.reload();
        },
        error: function(){
          swal("Error","Data gagal dihapus.", "error");
          alert("error");
        }
      });
    } 
  }

  function edit_gudang(id_gudang) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcgudang/get_data_edit_gudang')?>",
      data: {
        id_gudang: id_gudang
      },
      success: function(data){
        $('#edit_id_gudang_hidden').val(data[0].id_gudang);
        $('#edit_namagudang').val(data[0].nama_gudang);
        $('#edit_ketgudang').val(data[0].ket);
      },
      error: function(){
        alert("error");
      }
    });
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
          <h3 class="text-white">DAFTAR GUDANG & TPO</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mcgudang/insert_gudang');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Gudang Baru</button>
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
                  <h4 class="modal-title">Tambah Gudang Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmgudang">Nama gudang</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nama_gudang" id="nama_gudang">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_ket">Ket</p>
                    <div class="col-sm-6">
                      <select id="ket" class="form-control" name="ket">
                        <option value="" disabled selected="">-Pilih Ket-</option>
                        <?php 
                          foreach($ket as $row){
                            echo '<option value="'.$row->nm_ket.'">'.$row->nm_ket.'</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert gudang</button>
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
                <th>ID Gudang</th>
                <th>Nama Gudang</th>
                <th>ket</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>No</th>
                <th>ID Gudang</th>
                <th>Nama Gudang</th>
                <th>Ket</th>
                <th>Aksi</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
                  $i=1;
                  foreach($gudang as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_gudang;?></td>
                <td><?php echo $row->nama_gudang;?></td>
                <td><?php echo $row->ket;?></td>
                <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" title="Edit Gudang" data-target="#editModalGudang" onclick="edit_gudang('<?php echo $row->id_gudang;?>')"><i class="fa fa-edit"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="hapus_gudang('<?php echo $row->id_gudang;?>')"><i class="fa fa-trash"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- <?php echo form_open('master/mcgudang/edit_gudang');?>  -->
        <form method="POST" id="edit_form" class="form-horizontal">
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="editModalGudang" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Gudang</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Nama Gudang</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_namagudang" id="edit_namagudang">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-3 form-control-label">Ket</p>
                      <div class="col-sm-6">
                      <select id="edit_ketgudang" class="form-control" name="edit_ketgudang">
                        <option value="" disabled selected="">-Pilih Ket-</option>
                        <?php 
                          foreach($ket as $row){
                            echo '<option value="'.$row->nm_ket.'">'.$row->nm_ket.'</option>';
                          }
                        ?>
                      </select>
                      </div>
                    </div>
                    
                  </div>
                  
                  <div class="modal-footer">
                    <input type="hidden" class="form-control" name="edit_id_gudang_hidden" id="edit_id_gudang_hidden">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit">Edit Gudang</button>
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