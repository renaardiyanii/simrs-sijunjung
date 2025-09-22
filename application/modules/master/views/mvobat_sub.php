<?php
if ($role_id == 1) {
  $this->load->view("layout/header_left");
} else {
  $this->load->view("layout/header_horizontal");
}
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<script type='text/javascript'>
  $(document).ready(function() {
    $('#example').DataTable({
      "iDisplayLength": 10
    });

    $(".select2").select2();

    $('.load_obat').select2({
      placeholder: '-- Cari Obat --',
      ajax: {
        url: '<?php echo site_url('master/mcobat_poli/get_pilih_obat'); ?>',
        dataType: 'json',
        delay: 250,
        processResults: function(data) {
          var results = [];

          $.each(data, function(index, item) {
            results.push({
              id: item.id_obat,
              text: item.nm_obat
            });
          });
          return {
            results: results
          };
        },
        cache: true
      }
    });

    $('#insert_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mcobat_poli/insert_obat",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-insert").innerHTML = 'Insert Obat';
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
          document.getElementById("btn-insert").innerHTML = 'Insert Obat';
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
        url: "<?php echo base_url(); ?>master/mcobat_sub/edit_obat",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-edit").innerHTML = 'Edit Obat';
          $('#editModal').modal('hide');
          document.getElementById("edit_form").reset();
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
          document.getElementById("btn-edit").innerHTML = 'Edit Obat';
          $('#editModal').modal('hide');
          swal("Error", "Data gagal diperbaharui.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

    $('#delete_form').on('submit', function(e) {
      e.preventDefault();
      document.getElementById("btn-delete").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menghapus...';
      $.ajax({
        url: "<?php echo base_url(); ?>master/mcobat_sub/delete_obat",
        method: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          document.getElementById("btn-delete").innerHTML = 'Hapus Obat';
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
          document.getElementById("btn-delete").innerHTML = 'Hapus Obat';
          $('#deleteModal').modal('hide');
          swal("Error", "Data gagal dihapus.", "error");
          console.log('Error Message: ' + textStatus + ' , HTTP Error: ' + errorThrown);
        }
      });
    });

    $('#cari_obat').autocomplete({

      source: function(request, response) {
        $.ajax({
          url: '<?php echo base_url() ?>master/Mcobat_sub/cari_data_obat_diagnosa_new',
          dataType: "json",
          data: {
            term: request.term
          },
          success: function(data) {
            if (!data.length) {
              var result = [{
                label: 'Data tidak ditemukan',
                value: response.data
              }];
              response(result);
            } else {
              response(data);
            }
          }
        });
      },
      select: function(event, ui) {
        $('#cari_obat').val('' + ui.item.nama);
        $('#id_obat_hidden').val(ui.item.id_obat);
        $('#id_obat').val(ui.item.id_obat);
      }
    });

    $('#cari_obat2').autocomplete({

      source: function(request, response) {
        $.ajax({
          url: '<?php echo base_url() ?>master/Mcobat_sub/cari_data_obat_diagnosa_new',
          dataType: "json",
          data: {
            term: request.term
          },
          success: function(data) {
            if (!data.length) {
              var result = [{
                label: 'Data tidak ditemukan',
                value: response.data
              }];
              response(result);
            } else {
              response(data);
            }
          }
        });
      },
      select: function(event, ui) {
        $('#cari_obat2').val('' + ui.item.nama);
        $('#id_obat_sub_hidden').val(ui.item.id_obat);
        $('#id_obat_sub').val(ui.item.id_obat);
      }
    });

    $('#cari_obat_edit').autocomplete({

      source: function(request, response) {
        $.ajax({
          url: '<?php echo base_url() ?>farmasi/Frmcdaftar/cari_data_obat_diagnosa',
          dataType: "json",
          data: {
            term: request.term
          },
          success: function(data) {
            if (!data.length) {
              var result = [{
                label: 'Data tidak ditemukan',
                value: response.data
              }];
              response(result);
            } else {
              response(data);
            }
          }
        });
      },
      select: function(event, ui) {
        $('#cari_obat_edit').val('' + ui.item.nama);
        $('#edit_id_obat').val(ui.item.id_obat);
        $('#edit_id_obat_hidden').val(ui.item.id_obat);
      }
    });

    $('#cari_obat_edit2').autocomplete({

      source: function(request, response) {
        $.ajax({
          url: '<?php echo base_url() ?>farmasi/Frmcdaftar/cari_data_obat_diagnosa',
          dataType: "json",
          data: {
            term: request.term
          },
          success: function(data) {
            if (!data.length) {
              var result = [{
                label: 'Data tidak ditemukan',
                value: response.data
              }];
              response(result);
            } else {
              response(data);
            }
          }
        });
      },
      select: function(event, ui) {
        $('#cari_obat_edit2').val('' + ui.item.nama);
        $('#edit_id_obat_utama').val(ui.item.id_obat);
        $('#edit_id_obat_utama_hidden').val(ui.item.id_obat);
      }
    });

    $('#editModal').on('show.bs.collapse', function() {
      $('#myModal').collapse('hide');
    })

    $('#myModal').on('show.bs.collapse', function() {
      $('#editModal').collapse('hide');
    })

  });


  function edit_obat(id) {
    console.log(id)
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: "<?php echo base_url('master/mcobat_sub/get_data_edit_obat') ?>",
      data: {
        id: id
      },
      success: function(data) {
        $('#edit_id_obat_sub').val(data[0].id_obat_sub);
        $('#edit_id_obat_sub_hidden').val(data[0].id_obat_sub);
        var $newOption = $("<option selected='selected'></option>").val(data[0].id_obat_sub).text(data[0].nm_obat_substitusi)

        $('#cari_obat_edit').val(data[0].nm_obat_substitusi);
        // $("#edit_id_obat").append($newOption).trigger('change');
        $("#edit_id_obat").val(data[0].id_obat_sub);
        $('#edit_id_obat_utama').val(data[0].id_obat).change();
      },
      error: function() {
        alert("error");
      }
    });
  }

  function delete_obat(id) {
    $('#delete_id').val(id);
  }

  function aktif_obat(id) {
    if (confirm('Yakin Mengaktifkan Obat ini?')) {
      $.ajax({
        type: 'POST',
        url: "<?php echo base_url(); ?>master/mcobat_sub/active_obat/" + id,
        data: {
          id: id
        },
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          swal({
              title: "Selesai",
              text: "Data berhasil diaktifkan",
              type: "success",
              showCancelButton: false,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
            },
            function() {
              window.location.reload();
            });
        },
        error: function() {
          swal("Error", "Data gagal diaktifkan.", "error");
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
          <h3 class="text-white">DAFTAR OBAT SUBSTITUSI</h3>
        </div>
        <div class="card-block">
          <div class="col-sm-6">
          </div><!-- /col-lg-3 -->

          <!-- <?php echo form_open('master/mcobat_poli/insert_obat'); ?> -->
          <form method="POST" action="<?php echo base_url() . 'master/mcobat_sub/insert_obat'; ?>" class="form-horizontal">
            <div class="col-sm-3" align="right">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#myModal"><i class="fa fa-plus"></i> Obat Baru</button>
                </span>
              </div><!-- /input-group -->
            </div><!-- /col-lg-6 -->

            <!-- Modal Insert Obat -->
            <div class="collapse" id="myModal" role="dialog" data-backdrop="static" data-keyboard="false">


              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                  <h4 class="modal-title">Tambah Obat Baru</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Nama Obat</p>
                    <div class="col-sm-6">

                      <input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
                      <input type="hidden" name="id_obat" id="id_obat">
                      <input type="hidden" name="id_obat_hidden" id="id_obat_hidden">
                      <!-- <select name="id_obat" class="form-control load_obat" style="width:300px" onkeyup="this.value" required></select>
                      <input type="hidden" name="id_obat_hidden"> -->
                    </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label" id="lbl_nama">Obat Substitusi</p>
                    <div class="col-sm-6">

                      <input type="search" class="form-control" id="cari_obat2" name="cari_obat2" placeholder="Pencarian Obat">
                      <input type="hidden" name="id_obat_sub" id="id_obat_sub">
                      <input type="hidden" name="id_obat_sub_hidden" id="id_obat_sub_hidden">
                      <!-- <select name="id_obat" class="form-control load_obat" style="width:300px" onkeyup="this.value" required></select>
                      <input type="hidden" name="id_obat_hidden"> -->
                    </div>
                  </div>

                </div>
                <div class="modal-footer">
                  <input type="hidden" class="form-control" value="<?php echo $user_info->username; ?>" name="xuser">
                  <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                  <button class="btn btn-primary" type="submit" id="btn-insert">Insert Obat</button>
                </div>
              </div>

            </div>
          </form>
          <!-- <?php echo form_close(); ?> -->


          <form method="POST" id="edit_form" class="form-horizontal">
            <!-- Modal Edit Obat -->
            <div class="collapse" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">


              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                  <h4 class="modal-title">Edit Obat</h4>
                </div>

                <div class="modal-body">

                  +
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Obat Substitusi</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id_obat_sub" id="edit_id_obat_sub" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_obat_sub_hidden" id="edit_id_obat_sub_hidden">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Obat Substitusi</p>
                    <div class="col-sm-6">
                      <input type="search" class="form-control" id="cari_obat_edit" name="cari_obat" placeholder="Pencarian Obat">
                      <input type="hidden" name="edit_id_obat" id="edit_id_obat">
                      <input type="hidden" name="edit_id_obat_hidden" id="edit_id_obat_hidden">
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Obat</p>
                    <div class="col-sm-6">
                      <input type="search" class="form-control" id="cari_obat_edit2" name="cari_obat_sub" placeholder="Pencarian Obat">
                      <input type="hidden" name="edit_id_obat_utama" id="edit_id_obat_utama">
                      <input type="hidden" name="edit_id_obat_utama_hidden" id="edit_id_obat_utama_hidden">
                    </div>
                  </div>

                </div>

                <div class="modal-footer">
                  <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit Obat</button>
                </div>

              </div>

            </div>

          </form>

          <br />
          <br />
          <div class="table-responsive">
            <table id="example" class="display table table-hover table-striped table-bordered" cellpadding="0" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Obat Substitusi</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama Obat</th>
                  <th>Obat Substitusi</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </tfoot>
              <tbody id="bodyt">
                <?php $i = 1;
                foreach ($obat as $row) { ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $row->nm_obat_utama; ?></td>
                    <td><?php echo $row->nm_obat_substitusi; ?></td>
                    <td>
                      <?php if ($row->deleted == '0') {
                        echo 'AKTIF';
                      } else {
                        echo 'TIDAK AKTIF';
                      } ?>
                    </td>
                    <td>
                      <!-- <button type="button" title="Edit" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#editModal" onclick="edit_obat(<?php echo $row->id; ?>)"><i class="fa fa-edit"></i></button> -->
                      <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" onclick="delete_obat('<?php echo $row->id; ?>')"><i class="fa fa-trash"></i></button>
                      <button type="button" class="btn btn-success btn-sm" onclick="aktif_obat('<?php echo $row->id ?>')"><i class="fa fa-check"></i></button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>



          <form method="POST" id="delete_form" class="form-horizontal">
            <!-- Modal Edit Obat -->
            <div class="modal fade" id="deleteModal" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-success">
                <input type="hidden" class="form-control" name="delete_id" id="delete_id">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Yakin mau hapus Obat?</h4>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Jangan hapus</button>
                    <button class="btn btn-primary" type="submit" id="btn-delete">Yakin hapus</button>
                  </div>
                </div>
              </div>
            </div>
          </form>

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