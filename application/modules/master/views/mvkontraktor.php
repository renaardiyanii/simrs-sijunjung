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
          url:"<?php echo base_url(); ?>master/mckontraktor/insert_kontraktor",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-insert").innerHTML = 'Insert Kontraktor';
            $('#myModal').modal('hide'); 
            document.getElementById("insert_form").reset();
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
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-insert").innerHTML = 'Insert Kontraktor';
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
          url:"<?php echo base_url(); ?>master/mckontraktor/edit_kontraktor",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit kontraktor';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
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
          },
          error:function(event, textStatus, errorThrown) {
            document.getElementById("btn-edit").innerHTML = 'Edit kontraktor';
            $('#editModal').modal('hide');
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

  function edit_kontraktor(id_kontraktor) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('master/mckontraktor/get_data_edit_kontraktor')?>",
      data: {
        id_kontraktor: id_kontraktor
      },
      success: function(data){
        $('#edit_id_kontraktor').val(data[0].id_kontraktor);
        $('#edit_id_kontraktor_hidden').val(data[0].id_kontraktor);
        $('#edit_nmkontraktor').val(data[0].nmkontraktor);
        $('#edit_jenis').val(data[0].jamsoskes);
        
      },
      error: function(){
        alert("error");
       
      }
    });
  }

  function hapus_kontraktor(id_kontraktor){
    if (confirm('Yakin Menghapus Penjamin?')) {
      $.ajax({
        type:'POST',
        dataType: 'json',
        url:"<?php echo base_url('master/mckontraktor/delete_kontraktor')?>",
        data: {
          id_kontraktor: id_kontraktor
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
          alert("error");
          swal("Error","Data gagal dihapus.", "error");
        }
      });
    } 
  }

  function aktif_kontraktor(id){
    if (confirm('Yakin Mengaktifkan Penjamin ini?')) {
      $('#modalLoading').modal('show');
      $.ajax({
        type:'POST',
        url:"<?php echo base_url();?>master/mckontraktor/active_kontraktor/"+id,
        data: {
          id: id
        },  
				contentType: false,  
				cache: false,  
				processData:false, 
        success: function(data){
      $('#modalLoading').modal('hide');
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
          <h3 class="text-white">DAFTAR KELOMPOK JAMINAN</h3>
        </div>
        <div class="card-block">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mckontraktor/insert_kontraktor');?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
          <div class="col-sm-3" align="right">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Penjamin Baru</button>
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
                  <h4 class="modal-title">Tambah Penjamin Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmkontraktor">Nama Penjamin</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="nmkontraktor" id="nmkontraktor">
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nmkontraktor">Jenis Penjamin</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="jamsoskes" id="jamsoskes" required>
                        <option value="0">Kerjasama</option>
                        <option value="1">BPJS</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Penjamin</button>
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
                <th>ID Penjamin</th>
                <th>Nama Penjamin</th>
                <th>Jenis Penjamin</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($kontraktor as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->id_kontraktor;?></td>
                <td><?php echo $row->nmkontraktor;?></td>
                <td><?php //if($row->jamsoskes=='0'){
                //     echo 'Asuransi';
                //   }else{
                //     echo 'Jamsoskes';
                //   }
                  echo $row->bpjs;?></td>
                  <?php if ($row->deleted ==0): ?>
                  <td>ACTIVE</td>
                <?php else: ?>
                  <td>NON-ACTIVE</td>
                <?php endif; ?>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal" onclick="edit_kontraktor('<?php echo $row->id_kontraktor;?>')"><i class="fa fa-edit"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" onclick="hapus_kontraktor('<?php echo $row->id_kontraktor;?>')"><i class="fa fa-trash"></i></button>
                  <!-- <a type="button" class="btn btn-success btn-sm" href="<?php echo base_url('master/mckontraktor/active_kontraktor/'.$row->id_kontraktor)?>" ><i class="fa fa-check"></i></a> -->
                  <button type="button" class="btn btn-success btn-sm" onclick="aktif_kontraktor('<?php echo $row->id_kontraktor;?>')"><i class="fa fa-check"></i></button>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>

          <!-- <?php echo form_open('master/mckontraktor/edit_kontraktor');?> -->
          <form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Penjamin</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Penjamin</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_kontraktor" id="edit_id_kontraktor" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_kontraktor_hidden" id="edit_id_kontraktor_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Penjamin</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_nmkontraktor" id="edit_nmkontraktor">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Jenis Penjamin</p>
                    <div class="col-sm-6">
                      <select class="form-control" name="edit_jenis" id="edit_jenis" required>
                        <option value="0">Kerjasama</option>
                        <option value="1">BPJS</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit Penjamin</button>
                </div>
              </div>
            </div>
          </div>
          </form>
          <!-- <?php echo form_close();?> -->

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