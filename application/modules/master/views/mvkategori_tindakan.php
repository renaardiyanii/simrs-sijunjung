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
    });
    $(".select2").select2();

    $('#insert_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mckategori/insert_kategori",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-insert").innerHTML = 'Insert Tindakan';
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
          function() {
            window.location.reload();
          });
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-insert").innerHTML = 'Insert Tindakan';
          $('#myModal').modal('hide');
          swal("Error", "Data gagal disimpan.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

    $('#delete_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-delete").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menghapus...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mckategori/delete_kategori/",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-delete").innerHTML = 'Hapus Kategori';
          $('#deleteModal').modal('hide');
          document.getElementById("delete_form").reset();
          swal({
              title: "Selesai",
              text: "Data berhasil dihapus",
              type: "success",
              showCancelButton: false,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            },
            function() {
              window.location.reload();
            });
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-delete").innerHTML = 'Hapus Tindakan';
          $('#deleteModal').modal('hide');
          swal("Error", "Data gagal dihapus.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

    $('#edit_form').on('submit', function(e){  
      e.preventDefault();             
      document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
      $.ajax({  
        url:"<?php echo base_url(); ?>master/mckategori/update_kategori",                         
        method:"POST",  
        data:new FormData(this),  
        contentType: false,  
        cache: false,  
        processData:false,  
        success: function(data)  
        { 
          document.getElementById("btn-edit").innerHTML = 'Update';
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
          document.getElementById("btn-edit").innerHTML = 'Update ';
          $('#myModalEdit').modal('hide');
          swal("Error","Data gagal diperbaharui.", "error"); 
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }  
      });   
    });
});
  //---------------------------------------------------------

$(function() {
    $('#date_picker').datepicker({
      format: "yyyy-mm-dd",
      endDate: '0',
      autoclose: true,
      todayHighlight: true,
    });  
});

function delete_tindakan(id) {
    $('#delete_id').val(id);
}

function edit_kategori(id) {
  $.ajax({
    type:'POST',
    dataType: 'json',
    url:"<?php echo base_url('master/mckategori/get_data_edit_kategori')?>",
    data: {
      id: id
    },
    success: function(data){
      $('#edit_id_kategori').val(data.id_kategori);
      $('#edit_id_kategori_hidden').val(data.id_kategori);
      $('#edit_nama_kategori').val(data.kategori);
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
          <h3 class="text-white">DAFTAR TINDAKAN RADIOLOGI</h3>
        </div>
        <div class="card-block ">
          <form method="POST" id="insert_form" class="form-horizontal">
            <div class="form-group row">
              <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah Kategori</button>
                  </span>
                </div>
              </div>
            </div>

            <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Kategori</h4>
                  </div>
                  <div class="modal-body">
                    <div class="form-group row">
                      <div class="col-sm-1"></div>
                      <p class="col-sm-4 form-control-label" id="lbl_nama">Nama Kategori</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" required>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-insert">Insert</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
          <br/> 
          <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori Tindakan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
                  $i=1;
                  foreach($kategori as $row){
              ?>
              <tr>
                <td><?php echo $i++;?></td>
                <td><?php echo $row->kategori;?></td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalEdit" onclick="edit_kategori('<?php echo $row->id_kategori;?>')"><i class="fa fa-edit"></i></button>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onClick="delete_tindakan('<?php echo $row->id_kategori; ?>')"><i class="fa fa-trash"></i></button>
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

<form method="POST" id="delete_form" class="form-horizontal">
    <div class="modal fade" id="deleteModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-success">
            <input type="hidden" class="form-control" name="delete_id" id="delete_id">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Yakin mau hapus Kategori Tindakan?</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Jangan hapus</button>
                  <button class="btn btn-primary" type="submit" id="btn-delete">Yakin hapus</button>
                </div>
            </div>
        </div>
    </div>
</form>

<form method="POST" id="edit_form" class="form-horizontal">
  <div class="modal fade" id="myModalEdit" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Kategori</h4>
        </div>
        <div class="modal-body">
          <div class="col-sm-12">
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">ID Kategori</p>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="edit_id_kategori" id="edit_id_kategori" disabled>
                <input type="hidden" class="form-control" name="edit_id_kategori_hidden" id="edit_id_kategori_hidden">
              </div>
            </div>
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama Kategori</p>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="edit_nama_kategori" id="edit_nama_kategori">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit" id="btn-edit">Update</button>
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
