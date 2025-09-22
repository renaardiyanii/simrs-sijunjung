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
      $('#example').DataTable( {
        "iDisplayLength": 50
      } );
      $(".select2").select2();



      $('#insert_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>master/mcdeskrad/insert_bhp",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert BHP';
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
            document.getElementById("btn-insert").innerHTML = 'Insert BHP';
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
          url:"<?php echo base_url(); ?>master/mcdeskrad/update_bhp",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit BHP Radiologi';
            $('#myModalEdit').modal('hide'); 
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
            document.getElementById("btn-edit").innerHTML = 'Edit BHP Radiologi ';
            $('#myModalEdit').modal('hide');
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

  function delete_jenis_hasil_lab(id_jenis_hasil_lab){
    if (confirm('Yakin Menghapus Jenis Hasil Laboratorium?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mchasillab/delete_jenis_hasil_lab')?>",
        data: {
          id_jenis_hasil_lab: id_jenis_hasil_lab
        },
        success: function(data){
          swal({
                            title: "Dihapus",
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
      });
    } 
  }

  function edit(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mcdeskrad/get_data_edit_bhp')?>",
      data: {
        id: id
      },
      success: function(data){
        $('#id_bhp').val(data[0].id_bhp);
        $('#nama_bhp_edit').val(data[0].nama_bhp);
        $('#satuan_bhp_edit').val(data[0].satuan_bhp);
        $('#kategori_edit').val(data[0].kategori);
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
          <h3 class="text-white">DAFTAR BHP RADIOLOGI</h3>
        </div>
        <div class="card-block ">

          <div class="col-sm-9">
          </div>

          <!-- <?php //echo form_open('master/mchasillab/insert_jenis_hasil_lab');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> BHP Baru</button>
              </span>
            </div>
          </div> 
          <!-- Modal Insert hasil lab -->
          <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog"> 

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah BHP</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama BHP</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama" id="nama">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_kadar_normal">Satuan BHP</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="satuan" id="satuan">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_satuan">Kategori</p>
                      <div class="col-sm-8">
                        <select name="kategori" id="kategori" class="form-control">
                          <option>-- Pilih Kategori --</option>
                          <option value="OBAT">Obat</option>
                          <option value="BHP">BHP</option>
                        </select>
                        <!-- <input type="text" class="form-control" name="kategori" id="kategori"> -->
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                  </div>
                </div>
    
                <div class="modal-footer">
                  <!-- <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser"> -->
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert</button>
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
                <th>Nama BHP</th>
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($master_bhp as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->nama_bhp;?></td>
                <td><?php echo $row->satuan_bhp;?></td>
                <td><?php echo $row->kategori;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalEdit" onclick="edit('<?php echo $row->id_bhp;?>')"><i class="fa fa-edit"></i></button>
                  <!-- <button type="button" class="btn btn-danger btn-sm"  onclick="delete_jenis_hasil_lab('<?php echo $row->id_jenis_hasil_lab;?>')"><i class="fa fa-trash"></i></button> -->
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

        <!-- <?php echo form_open('master/mchasillab/update_jenis_hasil_lab');?> -->
        <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal update hasil lab -->
          <div class="modal fade" id="myModalEdit" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit BHP</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama BHP</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_bhp_edit" id="nama_bhp_edit">
                        <input type="hidden" class="form-control" name="id_bhp" id="id_bhp">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Satuan BHP</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="satuan_bhp_edit" id="satuan_bhp_edit">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Kategori</p>
                      <div class="col-sm-8">
                        <select name="kategori_edit" id="kategori_edit" class="form-control">
                          <option>-- Pilih Kategori --</option>
                          <option value="OBAT">Obat</option>
                          <option value="BHP">BHP</option>
                        </select>
                        <!-- <input type="text" class="form-control" name="kategori_edit" id="kategori_edit"> -->
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                  </div>
                </div>
    
                <div class="modal-footer">
                  <!-- <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser"> -->
                  <!-- <input type="hidden" class="form-control" name="edit_id_jenis_hasil_lab" id="edit_id_jenis_hasil_lab"> -->
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Update</button>
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
