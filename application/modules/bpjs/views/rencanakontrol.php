<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);
?>

<div class="card m-5">
  <div class="card-header">
    Rencana Kontrol
  </div>
  <div class="card-body">
    <h5 class="card-title">Pencarian Rencana Kontrol</h5>
    <div class="row">
        <div class="col-5">
            <div class="input-group">
                <label for="rencanakontrol" class="col-2 form-label">Rencana Kontrol :</label>
                <input type="text" class="form-control" name="rencanakontrol" id="rencanakontrol">
                <button class="btn btn-primary" onclick="carirencanakontrol($('#rencanakontrol').val())">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="loadinghasilrencanakontrol m-5">Loading...</div>

<div class="card m-5" id="hasilrencanakontrol">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Hasil Pencarian Rencana Kontrol
            <div>
                <button class="btn btn-info" onclick="updaterencanakontrol()">Update Rencana Kontrol</button>
                <button class="btn btn-danger" onclick="hapusrencanakontrol()">Hapus Rencana Kontrol</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <label for="nosuratkontrol" class="col col-form-label">No SuratKontrol :</label>
            <div class="col">
                <input type="text"  class="form-control" id="nosuratkontrol" readonly>
            </div>

            <label for="tglsuratkontrol" class="col col-form-label">Tgl SuratKontrol :</label>
            <div class="col">
                <input type="text"  class="form-control" id="tglsuratkontrol" readonly>
            </div>

            <label for="tglTerbit" class="col col-form-label">tglTerbit :</label>
            <div class="col">
                <input type="text" class="form-control" id="tglTerbit" readonly>
            </div>

            <label for="jnsKontrol" class="col col-form-label">jnsKontrol :</label>
            <div class="col">
                <input type="text" class="form-control" id="jnsKontrol" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label for="namaPoliTujuan" class="col col-form-label">namaPoliTujuan :</label>
            <div class="col">
                <input type="text"  class="form-control" id="namaPoliTujuan" readonly>
            </div>

            <label for="namaDokter" class="col col-form-label">namaDokter :</label>
            <div class="col">
                <input type="text"  class="form-control" id="namaDokter" readonly>
            </div>

            <label for="namaDokterPembuat" class="col col-form-label">namaDokterPembuat :</label>
            <div class="col">
                <input type="text" class="form-control" id="namaDokterPembuat" readonly>
            </div>

            <label for="namaJnsKontrol" class="col col-form-label">namaJnsKontrol :</label>
            <div class="col">
                <input type="text" class="form-control" id="namaJnsKontrol" readonly>
            </div>
        </div>

        <div class="row mb-3">
            <label for="noSep" class="col col-form-label">noSep :</label>
            <div class="col">
                <input type="text"  class="form-control" id="noSep" readonly>
            </div>

            <label for="tglSep" class="col col-form-label">tglSep :</label>
            <div class="col">
                <input type="text"  class="form-control" id="tglSep" readonly>
            </div>

            <label for="jnsPelayanan" class="col col-form-label">jnsPelayanan :</label>
            <div class="col">
                <input type="text" class="form-control" id="jnsPelayanan" readonly>
            </div>

            <label for="poli" class="col col-form-label">poli :</label>
            <div class="col">
                <input type="text" class="form-control" id="poli" readonly>
            </div>
        </div>
    </div>
</div>

<div class="card m-5">
  <div class="card-header">
    List SEP Rencana Kontrol / SPRI
  </div>
  <div class="card-body">
    <h5 class="card-title">List SEP RencanaKontrol / SPRI</h5>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <label for="tglAwal" class="col-2 form-label">Tgl. Awal :</label>
                <input type="date" class="form-control" name="tglAwal" id="tglAwal">&nbsp;&nbsp;&nbsp;
                <label for="tglAkhir" class="col-2 form-label">Tgl. Akhir :</label>
                <input type="date" class="form-control" name="tglAkhir" id="tglAkhir">
                <label for="filter" class="col-2 form-label">Filter :</label>
                <select class="form-control" name="filter" id="filter"><option value="1">Tgl. Entri</option><option value="2">Tgl. Rencana Kontrol</option></select>
                <button class="btn btn-primary" id="cariListSepRencanaKontrolBtn" onclick="cariListSepRencanaKontrol()">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="card m-5" id="hasilListSarana">
  <div class="card-header">
    Hasil Pencarian List Rencana Kontrol / SPRI
  </div>
  <div class="card-body">
    <h5 class="card-title">Hasil : </h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">No. Surat Kontrol</th>
                    <th scope="col">Jenis Pelayanan</th>
                    <th scope="col">Jenis Kontrol</th>
                    <th scope="col">Nama Jenis Kontrol</th>
                    <th scope="col">Tgl. Rencana Kontrol</th>
                    <th scope="col">Tgl. Terbit Kontrol</th>
                    <th scope="col">No. SEP Asal</th>
                    <th scope="col">Kode Poli Asal</th>
                    <th scope="col">Nama Poli Asal</th>
                    <th scope="col">Poli Tujuan</th>
                    <th scope="col">Nama Poli Tujuan</th>
                    <th scope="col">Tgl. SEP</th>
                    <th scope="col">Kode Dokter</th>
                    <th scope="col">Nama Dokter</th>
                    <th scope="col">No. Kartu</th>
                    <th scope="col">Nama</th>
                </tr>
            </thead>
            <tbody id="dataHasilListSarana"></tbody>
        </table>
    </div>
  </div>
</div>


<script>

    function cariListSepRencanaKontrol()
    {
        $('#hasilListSarana').hide();
        $('#cariListSepRencanaKontrolBtn').attr('disabled',true);
        $('#cariListSepRencanaKontrolBtn').html('Sedang Mencari Data...');
        let tglAwal = $('#tglAwal').val();
        let tglAkhir = $('#tglAkhir').val();
        let filter = $('#filter').val();

        $.ajax({
            url: `<?= base_url('bpjs/rencanakontrol/data_nomor_surat_kontrol') ?>?tglAwal=${tglAwal}&tglAkhir=${tglAkhir}&filter=${filter}`,
            beforeSend: function() {
                // $(".loadinghasilrencanakontrol").show();

            },
            success: function(data) {
                let html = '';
                let no= 1;
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`
                            <tr>
                                <td scope="row">${no}</td>
                                <td>${e.noSuratKontrol}</td>
                                <td>${e.jnsPelayanan}</td>
                                <td>${e.jnsKontrol}</td>
                                <td>${e.namaJnsKontrol}</td>
                                <td>${e.tglRencanaKontrol}</td>
                                <td>${e.tglTerbitKontrol}</td>
                                <td>${e.noSepAsalKontrol}</td>
                                <td>${e.poliAsal}</td>
                                <td>${e.namaPoliAsal}</td>
                                <td>${e.poliTujuan}</td>
                                <td>${e.namaPoliTujuan}</td>
                                <td>${e.tglSEP}</td>
                                <td>${e.kodeDokter}</td>
                                <td>${e.namaDokter}</td>
                                <td>${e.noKartu}</td>
                                <td>${e.nama}</td>
                            </tr>
                        `;
                        no++;
                    })
                    $('#hasilListSarana').show();
                    $('#dataHasilListSarana').html(html);

                }else{
                    html+=`<tr colspan="16">${data.metaData.message}</tr>`
                    $('#dataHasilListSarana').html(data.metaData.message);
                    new swal("Peringatan!",data.metaData.message, "warning");
                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");
            },
            complete: function() {
                $('#cariListSepRencanaKontrolBtn').attr('disabled',false);
                $('#cariListSepRencanaKontrolBtn').html('Cari Data');
            }
        });
    }

    function panggilmodal(data)
    {
        $('#exampleModalLabel').html(data.label);
        $('#exampleModalContent').html(data.content);
        $('#exampleModalSubmit').attr('onclick',data.submit);
        $('#exampleModal').modal('show');
    }

    function carirencanakontrol(val)
    {
        $("#hasilrencanakontrol").hide();
        $.ajax({
            url: `<?= base_url('bpjs/rencanakontrol/cari_nomor') ?>/${val}`,
            beforeSend: function() {
                $(".loadinghasilrencanakontrol").show();

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    parsingrencanakontrol(data.response);
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");

                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {
                $(".loadinghasilrencanakontrol").hide();

            }
        });
    }

    function parsingrencanakontrol(data)
    {
        $('#hasilrencanakontrol').show();

        $("#nosuratkontrol").val(data.noSuratKontrol);
        $("#tglsuratkontrol").val(data.tglRencanaKontrol);
        $("#tglTerbit").val(data.tglTerbit);
        $("#jnsKontrol").val(data.jnsKontrol);
        $("#namaPoliTujuan").val(data.namaPoliTujuan);
        $("#namaDokter").val(data.namaDokter);
        $("#namaDokterPembuat").val(data.namaDokterPembuat);
        $("#namaJnsKontrol").val(data.namaJnsKontrol);
        $("#noSep").val(data.sep.noSep);
        $("#tglSep").val(data.sep.tglSep);
        $("#jnsPelayanan").val(data.sep.jnsPelayanan);
        $("#poli").val(data.sep.poli);
    }


    /**
     * Update Rencana Kontrol
     */


    function pilihdokterkontrol(value)
    {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_dokter') ?>'+`?jnskontrol=${$('#jnsKontrol').val()}&poli=${value}&tglrencanakontrol=${$('#tglRencanaKontrolupdate').val()}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`<option value="${e.kodeDokter}">${e.namaDokter} ( ${e.jadwalPraktek} )</option>`;
                    })
                    $('#kodeDokterupdate').empty();
                    $('#kodeDokterupdate').append('<option value="">Silahkan Pilih Dokter</option>');
                    $('#kodeDokterupdate').append(html);
                }
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

    function pilihpolikontrol(value){
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_poli') ?>'+`?jnskontrol=${$('#jnsKontrol').val()}&nomor=${$('#nosepupdate').val()}&tglrencanakontrol=${value}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`<option value="${e.kodePoli}">${e.namaPoli}</option>`;
                    })
                    $('#poliKontrolupdate').empty();
                    $('#poliKontrolupdate').append('<option value="">Silahkan Pilih Poliklinik..</option>');
                    $('#poliKontrolupdate').append(html);
                    return;
                }

            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Tim IT', "warning");

            },
            complete: function() {

            }
        });
    }


    function updaterencanakontrolAjax()
    {
        let data = $('#updateSuratKontrol').serialize();
        $.ajax({
            method: 'POST',
            type:'JSON',
            data: data,
            url: `<?= base_url() ?>/bpjs/rencanakontrol/update_rencana_kontrol`,
            beforeSend: function() {

            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    new swal("Berhasil!",data.metaData.message, "success");
                    carirencanakontrol($('#rencanakontrol').val())
                    return;
                }
                new swal("Peringatan!",data.metaData.message, "warning");
                carirencanakontrol($('#rencanakontrol').val())


            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {
                $('#exampleModal').modal('hide');
            }
        });
    }

    function updaterencanakontrol()
    {
        dataModal = {
            'label':'Update Rencana Kontrol',
            'content':`
            <form id="updateSuratKontrol">
            <div class="row mb-2">
                <label for="nosuratkontrolupdate" class="col col-form-label">No. Surat kontrol :</label>
                <div class="col">
                    <input type="text" class="form-control" name="noSuratKontrol" id="nosuratkontrolupdate" value="${$('#nosuratkontrol').val()}">
                </div>
            </div>
            <div class="row mb-2">
                <label for="nosepupdate" class="col col-form-label">No. SEP/ No. kartu :</label>
                <div class="col">
                    <input type="text" class="form-control" name="noSEP" id="nosepupdate" value="${$('#noSep').val()}">
                </div>
            </div>

            <div class="row mb-2">
                <label for="tglRencanaKontrolupdate" class="col col-form-label">Tgl Rencana Kontrol :</label>
                <div class="col">
                    <input type="date" class="form-control" name="tglRencanaKontrol" id="tglRencanaKontrolupdate" onchange="pilihpolikontrol(this.value)" value="">
                </div>
            </div>

            <div class="row mb-2">
                <label for="poliKontrolupdate" class="col col-form-label">Poli Kontrol :</label>
                <div class="col">
                    <select id="poliKontrolupdate" name="poliKontrol" class="form-select" width="100%" onchange="pilihdokterkontrol(this.value)"><option>Pilih Poli<option/></select>
                </div>
            </div>

            <div class="row mb-2">
                <label for="kodeDokterupdate" class="col col-form-label">Kode Dokter :</label>
                <div class="col">
                    <select id="kodeDokterupdate" name="kodeDokter" class="form-select" width="100%"><option>Pilih Dokter<option/></select>
                </div>
            </div>

            <div class="row mb-2">
                <label for="jenissurat" class="col col-form-label">Jenis Surat :</label>
                <div class="col">
                    <select  name="jenissurat" class="form-select" id="jenissurat" width="100%"><option value="1" selected>SPRI<option/><option value="2">Surat Kontrol<option/></select>
                </div>
            </div>


            <div class="row mb-2">
                <label for="userupdate" class="col col-form-label">user :</label>
                <div class="col">
                    <input type="text" name="user" class="form-control" id="userupdate" value="<?= $user ?>" readonly>
                </div>
            </div>
            </form>



            `,
            'submit':'updaterencanakontrolAjax()'
       }
        panggilmodal(dataModal);
    }

    /**End Update Rencana Kontrol */


    /**
     * Hapus Rencana Kontrol
     */

    function hapusrencanakontrol()
    {
        let nosuratkontrol = $('#nosuratkontrol').val();
        $.ajax({
            type:'JSON',
            method:'POST',
            data:{
                'noSuratKontrol':nosuratkontrol,
                'user':'admin'
            },
            url: `<?= base_url() ?>/bpjs/rencanakontrol/hapus_rencana_kontrol`,
            beforeSend: function() {

            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    new swal("Berhasil!",data.metaData.message, "success");
                    return;
                }
                new swal("Peringatan!",data.metaData.message, "warning");


            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {
                $('#exampleModal').modal('hide');
            }
        });
    }

    /**
     * End Hapus Rencana Kontrol
     */

    $(document).ready(function(){
        $('#hasilrencanakontrol').hide();
        $(".loadinghasilrencanakontrol").hide();
        $('#hasilListSarana').hide();

    });
</script>



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="exampleModalContent">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="exampleModalSubmit">Simpan</button>
      </div>
    </div>
  </div>
</div>
