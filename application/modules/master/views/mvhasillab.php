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
    $('#example').DataTable({
      "iDisplayLength": 50
    });
    $(".select2").select2();



    $('#insert_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mchasillab/insert_jenis_hasil_lab",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-insert").innerHTML = 'Insert Hasil Lab';
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
              function() {
                window.location.reload();
              });
            console.log(data)
          } else {
            swal("Error", "Data gagal disimpan.", "error");
          }
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-insert").innerHTML = 'Insert Hasil Lab';
          $('#myModal').modal('hide');
          swal("Error", "Data gagal disimpan.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

    $('#edit_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mchasillab/update_jenis_hasil_lab",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-edit").innerHTML = 'Edit Hasil Lab';
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
              function() {
                window.location.reload();
              });
          } else {
            swal("Error", "Data gagal diperbaharui.", "error");
          }
        },
        error: function(event, textStatus, errorThrown) {
          document.getElementById("btn-edit").innerHTML = 'Edit Hasil Lab ';
          $('#myModalEdit').modal('hide');
          swal("Error", "Data gagal diperbaharui.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
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

  function delete_jenis_hasil_lab(id_jenis_hasil_lab) {
    if (confirm('Yakin Menghapus Jenis Hasil Laboratorium?')) {
      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: "<?php echo base_url('master/mchasillab/delete_jenis_hasil_lab') ?>",
        data: {
          id_jenis_hasil_lab: id_jenis_hasil_lab
        },
        success: function(data) {
          swal({
              title: "Dihapus",
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
      });
    }
  }

  function edit_jenis_hasil_lab(id_jenis_hasil_lab) {
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('master/mchasillab/get_data_edit_hasil_lab') ?>",
      data: {
        id_jenis_hasil_lab: id_jenis_hasil_lab
      },
      success: function(data) {
        $('#edit_id_tindakan').val(data[0].id_tindakan).change();
        $('#edit_jenis_hasil').val(data[0].jenis_hasil);
        $('#edit_kadar_normal').val(data[0].kadar_normal);
        $('#edit_satuan').val(data[0].satuan);
        $('#edit_id_jenis_hasil_lab').val(data[0].id_jenis_hasil_lab);
        $('#edit_no_urut').val(data[0].no_urut);
      },
      error: function() {
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
          <h3 class="text-white">DAFTAR JENIS HASIL LABORATORIUM</h3>
        </div>
        <div class="card-block ">

          <div class="col-sm-9">
          </div>

          <!-- <?php echo form_open('master/mchasillab/insert_jenis_hasil_lab'); ?> -->
          <form method="POST" id="insert_form" class="form-horizontal">
            <div class="col-sm-3" align="right">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Jenis Hasil Lab Baru</button>
                </span>
              </div><!-- /input-group -->
            </div><!-- /col-lg-6 -->

            <!-- Modal Insert hasil lab -->
            <div class="modal fade" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success modal-lg"">

              <!-- Modal content-->
              <div class=" modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Tambah Jenis Hasil Lab</h4>
                </div>
                <div class="modal-body">
                  <div class="col-sm-12">
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_id_tindakan">Nama Tindakan</p>
                      <div class="col-sm-8">
                        <select class="form-control select2" style="width: 100%" name="id_tindakan" id="id_tindakan" required="">
                          <option value="">-Pilih Tindakan-</option>
                          <?php
                          foreach ($tindakan_lab as $row1) {
                            echo '<option value="' . $row1->idtindakan . '">' . $row1->nmtindakan . '</option>';
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama Jenis Hasil</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="jenis_hasil" id="jenis_hasil">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_kadar_normal">Kadar Normal</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="kadar_normal" id="kadar_normal">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="satuan" id="satuan">
                      </div>
                    </div>
                    <div class="form-group row">
                      <p class="col-sm-3 form-control-label" id="lbl_no_urut">No Urut</p>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="no_urut" id="no_urut">
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                  </div>
                </div>

                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Jenis Hasil Lab</button>
                </div>
              </div>
            </div>
        </div>
        </form>
        <!-- <?php echo form_close(); ?> -->
        <br />
        <br />

        <table id="example" class="display table table-hover table-striped table-bordered" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Tindakan</th>
              <th>Nama Tindakan</th>
              <th>Jenis hasil</th>
              <th>Kadar Normal</th>
              <th>Satuan</th>
              <th>No Urut</th>
              <?php if ($user_login->userid == 1 || $user_login->userid == 1086 || $user_login->userid == 1085) { ?>
                <th>Aksi</th>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            foreach ($hasil_lab as $row) {
            ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row->id_tindakan; ?></td>
                <td><?php echo $row->nmtindakan; ?></td>
                <td><?php echo $row->jenis_hasil; ?></td>
                <td><?php echo $row->kadar_normal; ?></td>
                <td><?php echo $row->satuan; ?></td>
                <td><?php echo $row->no_urut; ?></td>
                <?php if ($user_login->userid == 1 || $user_login->userid == 1086 || $user_login->userid == 1085) { ?>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModalEdit" onclick="edit_jenis_hasil_lab('<?php echo $row->id_jenis_hasil_lab; ?>')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="delete_jenis_hasil_lab('<?php echo $row->id_jenis_hasil_lab; ?>')"><i class="fa fa-trash"></i></button>
                  </td>
                <?php } ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
</section>

<!-- <?php echo form_open('master/mchasillab/update_jenis_hasil_lab'); ?> -->
<form method="POST" id="edit_form" class="form-horizontal">
  <!-- Modal update hasil lab -->
  <div class="modal fade" id="myModalEdit" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Jenis Hasil Lab</h4>
        </div>
        <div class="modal-body">
          <div class="col-sm-12">
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_id_tindakan">Nama Tindakan</p>
              <div class="col-sm-8">
                <select class="form-control select2" style="width: 100%" name="edit_id_tindakan" id="edit_id_tindakan" required="">
                  <option value="">-Pilih Tindakan-</option>
                  <?php
                  foreach ($tindakan_lab as $row1) {
                    echo '<option value="' . $row1->idtindakan . '">' . $row1->nmtindakan . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_jenis_hasil">Nama Jenis Hasil</p>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="edit_jenis_hasil" id="edit_jenis_hasil">
              </div>
            </div>
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_kadar_normal">Kadar Normal</p>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="edit_kadar_normal" id="edit_kadar_normal">
              </div>
            </div>
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_satuan">Satuan</p>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="edit_satuan" id="edit_satuan">
              </div>
            </div>
            <div class="form-group row">
              <p class="col-sm-3 form-control-label" id="lbl_nourut">No Urut</p>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="edit_no_urut" id="edit_no_urut">
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-sm-1"></div>
          </div>
        </div>

        <div class="modal-footer">
          <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
          <input type="hidden" class="form-control" name="edit_id_jenis_hasil_lab" id="edit_id_jenis_hasil_lab">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="submit" id="btn-edit">Update Jenis Hasil Lab</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- <?php echo form_close(); ?> -->

<?php
if ($role_id == 1) {
  $this->load->view("layout/footer_left");
} else {
  $this->load->view("layout/footer_horizontal");
}
?>