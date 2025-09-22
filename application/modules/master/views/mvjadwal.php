<?php
$this->load->view('irj/layout/header_form', ['hide' => true, 'redirect' => base_url()]);

?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script> -->
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/gh/dubrox/Multiple-Dates-Picker-for-jQuery-UI@master/jquery-ui.multidatespicker.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/clockpicker/0.0.7/jquery-clockpicker.min.js" integrity="sha512-x0qixPCOQbS3xAQw8BL9qjhAh185N7JSw39hzE/ff71BXg7P1fkynTqcLYMlNmwRDtgdoYgURIvos+NJ6g0rNg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> -->

<div class="card m-4">
  <div class="card-header">
    <h3>DAFTAR JADWAL DOKTER</h3>
  </div>
  <div class="card-body m-4">
    <table class="table table-bordered" id="jadwalDokter">
      <thead>
        <tr>
          <!-- <th>No</th> -->
          <th>Dokter Spesialis</th>
          <th>Nama Spesialis</th>
          <th>Tanggal</th>
          <th>Jam Mulai</th>
          <th>Jam Berakhir</th>
          <th>Status</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
    </table>
  </div>
  <div class="card-footer">
    2022 - RSOMH Bukittinggi
  </div>
</div>

<script>
  var table = $('#jadwalDokter').DataTable({
    dom: 'Bfrtip',
    buttons: [{
      text: 'Tambah Jadwal Baru',
      action: function(e, dt, node, config) {
        $('#insertModal').modal('show');
      },
      className: 'btn btn-success'
    }],
    ajax: {
      url: `<?php echo base_url('master/mcjadwal/jadwalDokterSebulan') ?>`,
      dataSrc: ''
    },
    columns: [{
        data: 'nm_poli'
      },
      {
        data: 'nm_dokter'
      },
      {
        data: 'tgl'
      },
      {
        data: 'awal'
      },
      {
        data: 'akhir'
      },
      {
        data: 'statusjadwal'
      },
      {
        targets: -1,
        data: null,
        defaultContent: '<button class="btn btn-primary edit">Edit</button>',
      },
      {
        targets: -1,
        data: null,
        defaultContent: '<button class="btn btn-danger hapus">Hapus</button>',
      },

    ]
  });

  $('#jadwalDokter tbody').on('click', 'button.edit', function() {
    var data = table.row($(this).parents('tr')).data();
    $("#id_poliUpdate").val(data.id_poli);
    gantiDokterSpesialis(data.id_poli, 'update', data.id_dokter);
    $("#tanggalUpdate").val(data.tgl);
    $("#mulaiUpdate").val(data.awal);
    $("#selesaiUpdate").val(data.akhir);
    $("#idUpdate").val(data.id);
    $('#editModal').modal('show');
    if (data.status == '1') {
      $("#status").prop('checked', true);
      return;
    }
    $("#statustidakaktif").prop('checked', true);
  });

  $('#jadwalDokter tbody').on('click', 'button.hapus', function() {
    var data = table.row($(this).parents('tr')).data();
    $.ajax({
      url: '<?= base_url('master/mcjadwal/hapusjadwaldokter') ?>/' + '/' + data.id,
      beforeSend: function() {
        $('.hapus').attr('disabled', true);
        $('.hapus').html('Loading...');
      },
      success: function(data) {
        new swal("Berhasil!", 'Data Berhasil Dihapus', "success").then(function() {
          table.ajax.reload();
        });
      },
      error: function(xhr) {
        new swal("Gagal!", 'Data Gagal Dihapus', "error").then(function() {});
      },
      complete: function() {
        $('.hapus').attr('disabled', false);
        $('.hapus').html('Hapus');
      },
    });

  });

  function getAllPoli() {
    $.ajax({
      url: '<?= base_url('master/mcjadwal/getpoli') ?>',
      beforeSend: function() {

        $("#id_poliUpdate").html('<option value="" selected>Silahkan Ditunggu...</option>');
        $("#id_poli").html('<option value="" selected>Silahkan Ditunggu...</option>');
      },
      success: function(data) {
        let html = '<option value="" selected>Silahkan Dipilih </option>';
        data.map((e) => {
          html += `
          <option value="${e.id_poli}">${e.nm_poli}</option>
          `;
        })

        $("#id_poli").html(html);
        $("#id_poliUpdate").html(html);
      },
      error: function(xhr) {

        $("#id_poliUpdate").html('<option value="" selected>Data Gagal Dimuat , silahkan kontrak Tim IT</option>');
        $("#id_poli").html('<option value="" selected>Data Gagal Dimuat , silahkan kontrak Tim IT</option>');
      },
      complete: function() {},
    });
  }

  function gantiDokterSpesialis(val, update = '', id_dokter = '') {
    $.ajax({
      url: '<?= base_url('master/mcjadwal/getdokter') ?>/' + '/' + val,
      beforeSend: function() {
        if (update != '') {

          $("#id_dokterUpdate").html('<option value="" selected>Silahkan Ditunggu...</option>');
          return;
        }
        $("#id_dokter").html('<option value="" selected>Silahkan Ditunggu...</option>');

      },
      success: function(data) {
        html = '<option value="" selected>Silahkan Dipilih</option>';
        data.map((e) => {
          html += `
          <option value="${e.id_dokter}">${e.nm_dokter}</option>
          
          `;
        })
        if (update != '') {
          $("#id_dokterUpdate").html(html);
          $("#id_dokterUpdate").val(id_dokter).trigger('change');
          return;
        }
        $("#id_dokter").html(html);

      },
      error: function(xhr) {
        if (update != '') {
          $("#id_dokterUpdate").html('<option value="" selected>Silahkan Ditunggu...</option>');
          return;
        }
        $("#id_dokter").html('<option value="" selected>Silahkan Ditunggu...</option>');

      },
      complete: function() {},
    });
  }
  $(document).ready(function() {
    // ambilJadwalDokterSebulan();
    getAllPoli();
    $("#tanggal").multiDatesPicker({
      changeMonth: true
    });
  })

  function updateJadwalDokter() {
    let data = $('#formUpdateJadwalDokter').serialize();
    $.ajax({
      method: 'post',
      data: data,
      url: `<?= base_url('master/mcjadwal/updatejadwaldokter') ?>`,
      beforeSend: function() {

      },
      success: function(data) {
        new swal("Berhasil!", 'Data Berhasil Disimpan', "success").then(function() {
          $("#editModal").modal('hide');
          table.ajax.reload();
        });


      },
      error: function(xhr) {
        new swal("Gagal!", 'Hubungi Tim IT!', "error");
      },
      complete: function() {

      }
    });
  }

  function insertJadwalDokter() {
    if ($('#tanggal').val() == '') {
      new swal("Perhatian!", 'Tanggal Harus Diisi', "error").then(function() {

      });
      return;
    }

    if ($('#id_poli').val() == '') {
      new swal("Perhatian!", 'Poli Harus Diisi', "error").then(function() {

      });
      return;
    }
    if ($('#id_dokter').val() == '') {
      new swal("Perhatian!", 'Dokter Harus Diisi', "error").then(function() {

      });
      return;
    }
    if ($('#mulai').val() == '') {
      new swal("Perhatian!", 'Jam Mulai Harus Diisi', "error").then(function() {

      });
      return;
    }

    if ($('#selesai').val() == '') {
      new swal("Perhatian!", 'Jam Selesai Harus Diisi', "error").then(function() {

      });
      return;
    }




    let data = $('#formInsertJadwalDokter').serialize();
    $.ajax({
      method: 'post',
      data: data,
      url: `<?= base_url('master/mcjadwal/insertjadwaldokter') ?>`,
      beforeSend: function() {

      },
      success: function(data) {
        new swal("Berhasil!", 'Data Berhasil Disimpan', "success").then(function() {
          $("#insertModal").modal('hide');
          table.ajax.reload();
        });


      },
      error: function(xhr) {
        new swal("Gagal!", 'Hubungi Tim IT!', "error");
      },
      complete: function() {

      }
    });
  }
</script>

<div class="modal fade" id="insertModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Dokter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exampleModalContent">
        <form id="formInsertJadwalDokter">
          <label for="">Spesialis</label><br>
          <select name="id_poli" id="id_poli" class="form form-control" style="width:100%" onchange="gantiDokterSpesialis(this.value)"></select><br>
          <label for="">Dokter Spesialis</label>
          <select name="id_dokter" id="id_dokter" class="form form-control" style="width:100%" onchange=""></select>
          <label for="">Tanggal</label>
          <input type="text" name="tgl" id="tanggal" class="form form-control" style="padding-top:30px;padding-bottom:30px;" readonly>
          <label for="">Jam Mulai</label>
          <input type="time" name="mulai" id="mulai" class="form form-control">
          <label for="">Jam Selesai</label>
          <input type="time" name="selesai" id="selesai" class="form form-control">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="insert-jadwal" class="btn btn-primary" onclick="insertJadwalDokter()">Simpan</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal Dokter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exampleModalContent">
        <form id="formUpdateJadwalDokter">
          <input type="hidden" name="id" id="idUpdate">
          <label for="">Spesialis</label><br>
          <select name="id_poli" id="id_poliUpdate" class="form form-control" style="width:100%" onchange="gantiDokterSpesialis(this.value,'update')"></select><br>
          <label for="">Dokter Spesialis</label>
          <select name="id_dokter" id="id_dokterUpdate" class="form form-control" style="width:100%"></select>
          <label for="">Tanggal</label>
          <input type="date" name="tgl" id="tanggalUpdate" class="form form-control" readonly>
          <label for="">Jam Mulai</label>
          <input type="time" name="awal" id="mulaiUpdate" class="form form-control">
          <label for="">Jam Selesai</label>
          <input type="time" name="akhir" id="selesaiUpdate" class="form form-control">
          <label for="">Status</label><br>
          <input type="radio" name="status" id="status" value="1">
          <span>Aktif</span>
          <input type="radio" name="status" id="statustidakaktif" value="0">
          <span>Tidak Aktif</span>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="update-jadwal" class="btn btn-primary" onclick="updateJadwalDokter()">Simpan</button>
      </div>
    </div>
  </div>
</div>