<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);
    // var_dump($data);
    // die();
?>
<?php 
if($data->metaData->code != "200" && $data->metaData->message != "Sukses" ){

echo '
<div class="card m-5">
  <div class="card-header">
    Edit Surat Kontrol
  </div>
  <div class="card-body">
    <h6>'.$data->metaData->message.'</h6>
  </div>
</div>
';
return;
}
?>
<div class="card m-5">
  <div class="card-header">
    Edit Surat Kontrol
  </div>
  <div class="card-body">
    <form id="update_rencana_kontrol">
        <div class="mb-3 row">
            <input type="hidden" name="noSEP" id="nosepupdate" value="<?= $data->response->sep->noSep ?>">
            <label for="tgl" class="col-sm-4 col-form-label">Tgl.Rencana Kontrol / Inap</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="tgl" name="tgl" value="<?php echo $data->response->tglRencanaKontrol ?>" onchange="pilihpolikontrol(this.value)">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="jnsKontrol" class="col-sm-4 col-form-label">Pelayanan</label>
            <div class="col-sm-8">
                <select name="jnsKontrol" id="jnsKontrol" class="form-control" >
                    <option value="">--Pilih Pelayanan--</option>
                    <option value="2" <?php echo $data->response->jnsKontrol=='2'?'selected':'' ?>>Rawat Jalan</option>
                    <option value="1" <?php echo $data->response->jnsKontrol!='2'?'selected':'' ?>>Rawat Inap</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nosuratkontrol" class="col-sm-4 col-form-label">No. Surat Kontrol</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="nosuratkontrol" name="nosuratkontrol" value="<?php echo $data->response->noSuratKontrol ?>">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="spesialis" class="col-sm-4 col-form-label">Spesialis/Sub Spesialis</label>
            <div class="col-sm-8">
                <select name="spesialis" id="spesialis" class="form-control" onchange="pilihdokterkontrol(this.value)">
                    <option value="">--Pilih Spesialis/Sub Spesialis--</option>
                    <option  value="<?php echo $data->response->poliTujuan ?>" selected><?php echo $data->response->namaPoliTujuan ?></option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="dpjp" class="col-sm-4 col-form-label">DPJP Tujuan kontrol / Inap</label>
            <div class="col-sm-8">
                <select name="dpjp" id="dpjp" class="form-control" value="<?php echo $data->response->kodeDokter ?>" >
                    <option value="">--Pilih Dpjp--</option>
                    <option  value="<?php echo $data->response->kodeDokter ?>" selected><?php echo $data->response->namaDokter ?></option>
                </select>
            </div>
        </div>
    </form>
    <button id="btnsubmit" class="btn btn-primary" onclick="update_rencana_kontrol()">Simpan</button>
  </div>
</div>


<script>

    

    function update_rencana_kontrol()
    {
        let form = $("#update_rencana_kontrol").serialize();
        $.ajax({
            url: `<?= base_url('bpjs/rencanakontrol/update_suratkontrol') ?>`,
            method:"post",
            data:form,
            beforeSend: function() {
                $("#btnsubmit").attr('disabled',true);
                $("#btnsubmit").html('Loading...');

            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    new swal("Berhasil!",data.metaData.message, "success");
                    // carirencanakontrol($('#rencanakontrol').val())
                    // window.location.reload();
                    return;
                }
                new swal("Peringatan!",data.metaData.message, "warning");
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");
            },
            complete: function() {
                $("#btnsubmit").attr('disabled',false);
                $("#btnsubmit").html('Submit');


            }
        });
    }


    /**
     * Update Rencana Kontrol
     */


    function pilihdokterkontrol(value,initial=false)
    {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_dokter') ?>'+`?jnskontrol=${$('#jnsKontrol').val()}&poli=${value}&tglrencanakontrol=${$('#tgl').val()}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`<option value="${e.kodeDokter}" ${initial && e.kodeDokter == '<?php echo $data->response->kodeDokter ?>'?'selected':''}>${e.namaDokter} ( ${e.jadwalPraktek} )</option>`;
                    })
                    $('#dpjp').empty();
                    $('#dpjp').append('<option value="">Silahkan Pilih Dokter</option>');
                    $('#dpjp').append(html);
                }
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

    function pilihpolikontrol(value,initial=false){
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_poli') ?>'+`?jnskontrol=${$('#jnsKontrol').val()}&nomor=${$('#nosepupdate').val()}&tglrencanakontrol=${value}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        
                        html+=`<option value="${e.kodePoli}" ${initial&& e.kodePoli == '<?php echo $data->response->poliTujuan ?>'?'selected':''}>${e.namaPoli}</option>`;
                    })
                    $('#spesialis').empty();
                    $('#spesialis').append('<option value="">Silahkan Pilih Poliklinik..</option>');
                    $('#spesialis').append(html);
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
        pilihpolikontrol("<?php echo $data->response->tglRencanaKontrol ?>",true);
        pilihdokterkontrol("<?php echo $data->response->poliTujuan ?>",true);

    });
</script>