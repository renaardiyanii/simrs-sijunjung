<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);

?>

<div class="card m-5">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Ketersediaan Kamar RS
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="datatable" width="100%">
            <thead>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Terakhir Update</td>
                    <td>Ketersediaan Bed Pria & Wanita</td>
                    <td>Kapasitas</td>
                    <td>Nama Ruang</td>
                    <td>Nama Kelas</td>
                    <td>Kode Ruang</td>
                    <td>tersedia</td>
                    <td>Row Number</td>
                    <td>Tersedia Wanita</td>
                    <td>Tersedia Pria</td>
                    <td>Kode Kelas</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>



<script>


var table= $('#datatable').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                text: 'Tambah Ruangan Baru',
                action: function ( e, dt, node, config ) {
                    $('#insertModal').modal('show');
                },
                className:'btn btn-success'
            }
        ],
        ajax: {
            url: `<?php echo base_url('bpjs/aplicares/ketersediaankamar/1?start=1&limit=1000') ?>`,
            dataSrc: 'response.list'
        },
        columns:[
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
            { data: 'lastupdate' },
            { data: 'tersediapriawanita' },
            { data: 'kapasitas' },
            { data: 'namaruang' },
            { data: 'namakelas' },
            { data: 'koderuang' },
            { data: 'tersedia' },
            { data: 'rownumber' },
            { data: 'tersediawanita' },
            { data: 'tersediapria' },
            { data: 'kodekelas' },
            
        ]
    } );
    $('#datatable tbody').on('click', 'button.edit', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#kodekelas').val(data.kodekelas);
        $('#koderuang').val(data.koderuang);
        $('#namaruang').val(data.namaruang);
        $('#kapasitas').val(data.kapasitas);
        $('#tersedia').val(data.tersedia);
        $('#tersediapria').val(data.tersediapria);
        $('#tersediawanita').val(data.tersediawanita);
        $('#tersediapriawanita').val(data.tersediapriawanita);
        $('#exampleModal').modal('show');
    });
    $('#datatable tbody').on('click', 'button.hapus', function () {
        var data = table.row($(this).parents('tr')).data();
        $.ajax({
            method:'post',
            data:data,
            url: `<?= base_url('bpjs/aplicares/hapusruangan') ?>`,
            beforeSend: function() {
            
            },
            success: function(data) {
                new swal("Berhasil!",data.metadata.message, "success").then(function(){
                    table.ajax.reload();
                }); 
            },
            error: function(xhr) {
                new swal("Gagal!",'Hubungi Tim IT!', "error");
            },
            complete: function() {

            }
        });
    });

    function ambilKodeKelas(){
        $.ajax({
            url: `<?= base_url('bpjs/aplicares/refkamar') ?>`,
            beforeSend: function() {
                $('#kodekelasIn').html('<option value="" selected>Silahkan Ditunggu</option>');
            },
            success: function(data) {
                if(data.metadata.code == 1){
                    let html = '<option value="">Silahkan Pilih Kelas</option>';
                    data.response.list.map((e)=>{
                        html+=`
                        <option value="${e.kodekelas}">${e.namakelas}</option>
                        `;
                    });
                    $("#kodekelasIn").html(html);
                }
                 $("#kodekelasIn").select2({
                    dropdownParent: $("#insertModal")
                });
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

    function ambilRuangan(){
        $.ajax({
            url: `<?= base_url('master/mcruang/allruang') ?>`,
            beforeSend: function() {
                $('#koderuangIn').html('<option value="" selected>Silahkan Ditunggu</option>');
            },
            success: function(data) {
                let html = '<option value="">Silahkan Pilih Ruangan</option>';
                data.map((e)=>{
                    html+=`
                    <option value="${e.idrg}@${e.nmruang}">${e.nmruang}</option>
                    `;
                });
                $("#koderuangIn").html(html);
                $("#koderuangIn").select2({
                    dropdownParent: $("#insertModal")
                });
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

    function gantiNamaRuang(val)
    {
        $("#namaruangIn").val(val.split('@')[1]);
    }
$(document).ready(function(){
   
    ambilKodeKelas();
    ambilRuangan();
    
   
})

function updateketersediaantidur(){
    let data = $('#formKetersediaanTempatTidur').serialize();
    $.ajax({
        method:'post',
        data:data,
        url: `<?= base_url('bpjs/aplicares/updatetempattidur') ?>`,
        beforeSend: function() {
           
        },
        success: function(data) {
            if(data.metadata.code != 0){
                new swal("Berhasil!",data.metadata.message, "success").then(function(){
                    $("#exampleModal").modal('hide');
                    table.ajax.reload();
                }); 
                return;
            }
            new swal("Gagal!",data.metadata.message, "error").then(function(){
                    // $("#exampleModal").modal('hide');
                    // table.ajax.reload();
                }); 
        },
        error: function(xhr) {
            new swal("Gagal!",'Hubungi Tim IT!', "error");
        },
        complete: function() {

        }
    });
}

function insertketersediaantidur()
{
    let data = $('#formTambahRuangBaru').serialize();
    $.ajax({
        method:'post',
        data:data,
        url: `<?= base_url('bpjs/aplicares/ruanganbaru') ?>`,
        beforeSend: function() {
           
        },
        success: function(data) {
            new swal("Berhasil!",data.metadata.message, "success").then(function(){
                $("#insertModal").modal('hide');
                table.ajax.reload();
            });   


        },
        error: function(xhr) {
            new swal("Gagal!",'Hubungi Tim IT!', "error");
        },
        complete: function() {

        }
    });
}
</script>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Ketersediaan Tempat Tidur</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exampleModalContent">
        <form id="formKetersediaanTempatTidur">
            <label for="">Kode Kelas</label>
            <input type="text" name="kodekelas" id="kodekelas" class="form form-control" readonly>
            <label for="">Kode Ruang</label>
            <input type="text" name="koderuang" id="koderuang" class="form form-control" readonly>
            <label for="">Nama Ruang</label>
            <input type="text" name="namaruang" id="namaruang" class="form form-control" readonly>
            <label for="">Kapasitas</label>
            <input type="text" name="kapasitas" id="kapasitas" class="form form-control">
            <label for="">Tersedia</label>
            <input type="text" name="tersedia" id="tersedia" class="form form-control">
            <label for="">Tersedia Pria</label>
            <input type="text" name="tersediapria" id="tersediapria" class="form form-control">
            <label for="">Tersedia Wanita</label>
            <input type="text" name="tersediawanita" id="tersediawanita" class="form form-control">
            <label for="">Tersedia Pria & Wanita</label>
            <input type="text" name="tersediapriawanita" id="tersediapriawanita" class="form form-control">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="updateketersediaantidur()">Simpan</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="insertModal" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Ruangan Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exampleModalContent">
        <form id="formTambahRuangBaru">
            <label for="">Kode Kelas</label><br>
            <select name="kodekelas" id="kodekelasIn" class="form form-control" style="width:100%"></select><br>
            <label for="">Kode Ruang</label>
            <select name="koderuang" id="koderuangIn" class="form form-control" style="width:100%" onchange="gantiNamaRuang(this.value)"></select>
            <label for="">Nama Ruang</label>
            <input type="text" name="namaruang" id="namaruangIn" class="form form-control" readonly>
            <label for="">Kapasitas</label>
            <input type="text" name="kapasitas" id="kapasitasIn" class="form form-control">
            <label for="">Tersedia</label>
            <input type="text" name="tersedia" id="tersediaIn" class="form form-control">
            <label for="">Tersedia Pria</label>
            <input type="text" name="tersediapria" id="tersediapriaIn" class="form form-control">
            <label for="">Tersedia Wanita</label>
            <input type="text" name="tersediawanita" id="tersediawanitaIn" class="form form-control">
            <label for="">Tersedia Pria & Wanita</label>
            <input type="text" name="tersediapriawanita" id="tersediapriawanitaIn" class="form form-control">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="insertketersediaantidur()">Simpan</button>
      </div>
    </div>
  </div>
</div>