<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);

    function bikin($nama,$readonly=false){
        echo '
        <div class="mb-2">
            <label for="'.$nama.'" class="col col-form-label">'.$nama.' :</label>
            <div class="col">
                <input type="text"  class="form-control" id="'.$nama.'" '.($readonly?'readonly':'').'>
            </div>
        </div>';
    }

    function inputtext($nama,$id,$label,$readonly=false)
    {
        echo '
        <div class="mb-2">
            <label for="'.$id.'" class="col col-form-label">'.$label.' :</label>
            <div class="col">
                <input type="text" name="'.$nama.'"  class="form-control" id="'.$id.'" '.($readonly?'readonly':'').'>
            </div>
        </div>
        ';
    }

    function inputdate($nama,$id,$label,$readonly=false)
    {
        echo '
        <div class="mb-2">
            <label for="'.$id.'" class="col col-form-label">'.$label.' :</label>
            <div class="col">
                <input type="date" name="'.$nama.'" class="form-control" id="'.$id.'" '.($readonly?'readonly':'').'>
            </div>
        </div>
        ';
    }
    function inputselect($nama,$id,$label,$option='',$readonly=false)
    {
        echo '
        <div class="mb-2">
            <label for="'.$id.'" class="col col-form-label">'.$label.' :</label>
            <div class="col">
                <select class="form-select" name="'.$nama.'" id="'.$id.'">
                '.$option.'
                </select>
            </div>
        </div>
        ';
    }

    function bikin2($nama,$value='')
    {
        echo '
        <div class="row mb-2">
                    <label for="'.$nama.'up" class="col col-form-label">'.$nama.' :</label>
                    <div class="col">
                        <input type="text" class="form-control" name="'.$nama.'" id="'.$nama.'up" value="'.$value.'">
                    </div>
                </div>
        ';
    }

    function datebikin($nama)
    {
        echo '
        <div class="row mb-2">
            <label for="'.$nama.'" class="col col-form-label">'.$nama.' :</label>
            <div class="col">
                <input type="date" class="form-control" name="'.$nama.'" id="'.$nama.'up">
            </div>
        </div>
        ';
    }

    function selectbikin($nama,$option)
    {
        echo '
        <div class="row mb-2">
            <label for="'.$nama.'" class="col col-form-label">'.$nama.' :</label>
            <div class="col">
                <select class="form-select" name="'.$nama.'" id="'.$nama.'up">
                '.$option.'
                </select>
            </div>
        </div>
        ';
    }
?>

<div class="card m-5">
  <div class="card-header">
    SEP
  </div>
  <div class="card-body">
    <h5 class="card-title">Pencarian SEP</h5>
    <div class="row">
        <div class="col-5">
            <div class="input-group">
                <label for="sep" class="col-2 form-label">SEP :</label>
                <input type="text" class="form-control" name="sep" id="sep">
                <button class="btn btn-primary" onclick="carisep($('#sep').val())">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="loadinghasilrencanakontrol m-5">Loading...</div>

<div class="card m-5" id="hasilrencanakontrol">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Hasil Pencarian SEP
            <div>
                <button class="btn btn-info" onclick="updatesep()">Update SEP</button>
                <button class="btn btn-danger" onclick="hapusrencanakontrol()">Hapus SEP</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <form id="formupdatesep">
        <?= inputtext('noSep','noSep','No. SEP') ?>
        <?= inputdate('tglSep','tglSep','Tgl. SEP') ?>
        <?= bikin('jnsPelayanan',true) ?>
        <hr>
        <?= inputtext('klsRawatHak','klsRawatHak','kelas Rawat Hak') ?>
        <?= inputtext('klsRawatNaik','klsRawatNaik','kelas Rawat Naik') ?>
        <?= inputtext('pembiayaan','pembiayaan','Pembiayaan') ?>
        <?= inputtext('penanggungJawab','penanggungJawab','Penanggung Jawab') ?>
        <hr>
        <?= inputtext('noMr','noMr','No. MR') ?>
        <?= inputtext('catatan','catatan','Catatan') ?>
        <?= inputselect('diagAwal','diagawalUpdate','Diagnosa') ?>
        <hr>
        <?= inputselect('tujuan','poliTujuanUpdate','Poli Tujuan') ?>
        <?= inputselect('eksekutif','eksekutif','Poli eksekutif','<option value="0">Tidak</option><option value="1">Ya</option>') ?>
        <hr>
        <?= inputselect('cob','cob','Cob','<option value="0">Tidak</option><option value="1">Ya</option>') ?>
        <?= inputselect('katarak','katarak','Katarak','<option value="0">Tidak</option><option value="1">Ya</option>') ?>
        <hr>
        <?= inputselect('lakaLantas','lakaLantas','Kecelakaan','<option value="0">Bukan Kecelakaan lalu lintas [BKLL]</option><option value="1">KLL dan bukan kecelakaan Kerja [BKK]</option><option value="2">KLL dan KK </option><option value="3">KK</option>') ?>
        <?= inputdate('tglKejadian','tglKejadian','Tgl. Kejadian') ?>
        <?= inputtext('keterangan','keterangan','Keterangan Kejadian') ?>
        <hr>
        <?= inputselect('suplesi','suplesi','Suplesi','<option value="0">Tidak</option><option value="1">Ya</option>') ?>
        <?= inputtext('noSepSuplesi','noSepSuplesi','No. SEP Suplesi') ?>
        <hr>
        <?= inputselect('kdPropinsi','kdPropinsi','Kode Provinsi') ?>
        <?= inputselect('kdKabupaten','kdKabupaten','Kode Kabupaten') ?>
        <?= inputselect('kdKecamatan','kdKecamatan','Kode Kecamatan') ?>
        <hr>
        <?= inputselect('dpjpLayan','dpjpLayan','DPJP') ?>
        <?= inputtext('noTelp','noTelp','No. Telp') ?>
        <?= inputtext('user','user','User') ?>
        </form>
    </div>
</div>


<div class="card m-5">
  <div class="card-header">
    Pengajuan
  </div>
  <div class="card-body">
    <h5 class="card-title">Pengajuan Backdate/Finger SEP</h5>
    <div class="row">
        <div class="col-5">
            <div class="input-group">
                <label for="sep" class="col-2 form-label">Nomor kartu Peserta :</label>
                <select class="form-select" name="type" id="pengajuanapprovaltype">
                    <option value="0">Pengajuan</option>
                    <option value="1">Approval</option>
                </select>
                <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" placeholder="Nomor BPJS">
                <button class="btn btn-primary" onclick="caripengajuan($('#no_bpjs').val())">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="loadinghasilpengajuan m-5">Loading...</div>

<div class="card m-5" id="hasilpengajuan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Form Pengajuan / Approval SEP
        </div>
    </div>
    <div class="card-body">
        <form id="pengajuanapproval">
            <?= bikin2('noKartu') ?>
            <?= datebikin('tglSep') ?>
            <?= selectbikin('jnsPelayanan','<option value="1">R.Inap</option><option value="2">R.Jalan</option>') ?>
            <?= selectbikin('jnsPengajuan','<option value="1">Pengajuan Backdate</option><option value="2">Pengajuan Finger</option>') ?>
            <?= bikin2('keterangan') ?>
            <?= bikin2('user') ?>
        </form>
        <button type="button" class="btn btn-primary" onclick="simpanPengajuan($('#pengajuanapprovaltype').val())">Simpan</button>

    </div>
</div>


<!-- SEP Internal -->


<div class="card m-5">
  <div class="card-header">
    SEP Internal
  </div>
  <div class="card-body">
    <h5 class="card-title">Pencarian SEP Internal</h5>
    <div class="row">
        <div class="col-5">
            <div class="input-group">
                <label for="sep_internal" class="col-2 form-label">SEP :</label>
                <input type="text" class="form-control" name="sep_internal" id="sep_internal">
                <button class="btn btn-primary" id="btnSepInternal" onclick="carisepInternal($('#sep_internal').val())">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>


<div class="card m-5" id="hasilSepInternal">
    <div class="card-header">
    <h5>
        Hasil Pencarian SEP Internal
    </h5>    
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Tujuan Rujukan</th>
                <th>Poli Asal</th>
                <th>Tgl. Rujukan Internal</th>
                <th>No. SEP</th>
                <th>No. Kartu</th>
                <th>Tgl. Sep</th>
                <th>No. Surat</th>
                <th>Dokter</th>
                <th>Diagnosa</th>
                <th>Action</th>
            </tr>
            <tbody id="datahasilSepInternal"></tbody>
        </table>
    </div>
</div>

<script>

    function hapusSepInternal(data)
    {
        $.ajax({
            url: `<?= base_url('bpjs/sep/delete_sep_internal') ?>`,
            method: 'post',
            type:'json',
            data:{
                noSep:data.nosep,
                noSurat:data.nosurat,
                tglRujukanInternal:data.tglrujukinternal,
                kdPoliTuj:data.kdpolituj
            },
            beforeSend: function() {
              
            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    new swal("Berhasil!",data.metaData.message, "success");
                
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");

                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {
            }
        });
    }

    function carisepInternal(sep_internal)
    {
        $("#hasilSepInternal").hide();
        $.ajax({
            url: `<?= base_url('bpjs/sep/cari_sep_internal') ?>/${sep_internal}`,
            beforeSend: function() {
                $('#btnSepInternal').attr('disabled',true);
                $('#btnSepInternal').html('Loading..');
                let html = '<tr><td colspan="9">Silahkan ditunggu..</td></tr>';
                $("#datahasilSepInternal").html(html);
            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`
                            <tr>
                                <td>${e.tujuanrujuk}</td>
                                <td>${e.nmpoliasal}</td>
                                <td>${e.tglrujukinternal}</td>
                                <td>${e.nosep}</td>
                                <td>${e.nokapst}</td>
                                <td>${e.tglsep}</td>
                                <td>${e.nosurat}</td>
                                <td>${e.nmdokter}</td>
                                <td>${e.nmdiag}</td>
                                <td>
                                    <button class="btn btn-primary" onclick='hapusSepInternal(${JSON.stringify(e)})'>Hapus</button>
                                </td>
                            </tr>
                        `;
                    })
                    $("#hasilSepInternal").show();
                    $("#datahasilSepInternal").html(html);
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");

                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {
                $('#btnSepInternal').attr('disabled',false);
                $('#btnSepInternal').html('Cari Data');
            }
        });
    }


    let dataSep = {};

    function updatesep()
    {
        let data = $('#formupdatesep').serialize();
        $.ajax({
            url: `<?= base_url('bpjs/sep/update_sep') ?>`,
            data:data,
            method: "POST",
            type:'JSON',
            beforeSend: function() {
            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    new swal("Berhasil!",data.metaData.message, "success");
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");
                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {

            }
        });
        
    }
    $('#kdPropinsi').select2();
    $('#kdKecamatan').select2();
    $('#kdKabupaten').select2();
    $('#dpjpLayan').select2();


    $('#kdPropinsi').change(function(){
        pilihKabupaten(this.value);
    });

    $('#kdKabupaten').change(function(){
        pilihKecamatan(this.value);
    })

    $('#poliTujuanUpdate').change(function(){
        // console.log(this.value);
        cariDokterDpjp('#dpjpLayan',this.value,false);
    })

    function cariDokterDpjp(id , poli,append=true)
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url('bpjs/referensi/dokter_dpjp?pelayanan=2&tglpelayanan='.date('Y-m-d')) ?>'+'&spesialis='+poli,
            success: function(success){
                if(success.response.list === undefined){
                    $(id).attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                    return;
                }
                var html = ``;
                success.response.list.map((val)=>{
                    html +=`
                        <option value="${val.kode}">${val.nama}</option>
                    `;
                })
                if(append)
                {
                    $(id).append(html);
                    return;
                }
                $(id).html(html);
                
            },
            error:function(error){
                $(id).attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                return;
            }
        });
    }

    function pilihKecamatan(value){
        $.ajax({
            type: "GET",
            url: '<?= base_url('bpjs/referensi/kecamatan?kabupaten=') ?>'+value,
            success: function(success){
                if(success.response.list === undefined){
                    $('#kdKecamatan').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                    return;
                }
                var html = `<option value="" selected>-- Silahkan Pilih Kecamatan --</option>`;
                success.response.list.map((val)=>{
                    html +=`
                        <option value="${val.kode}">${val.nama}</option>
                    `;
                })
                $('#kdKecamatan').html(html);
                return;
            },
            error:function(error){
                $('#kdKecamatan').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                return;
            }
        });
}

    function pilihKabupaten(value)
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url('bpjs/referensi/kabupaten?provinsi=') ?>'+value,
            success: function(success){
                if(success.response.list === undefined){
                    $('#kdKabupaten').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                    return;
                }
                var html = `<option value="" selected>-- Silahkan Pilih Kabupaten --</option>`;
                success.response.list.map((val)=>{
                    html +=`
                        <option value="${val.kode}">${val.nama}</option>
                    `;
                })
                $('#kdKabupaten').html(html);
                return;
            },
            error:function(error){
                $('#kdKabupaten').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                return;
            }
        });
    }

    $('#poliTujuanUpdate').select2({
        placeholder: 'Ketik kode atau nama Poli',
        minimumInputLength: 1,
        language: {
        inputTooShort: function(args) {
            return "Ketik kode atau nama poli";
        },
        noResults: function() {
            return "Poli tidak ditemukan.";
        },
        searching: function() {
            return "Sedang Cari.....";
        }
        },
        ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/poliklinik'; ?>',
        dataType: 'JSON',
        delay: 250,
        processResults: function (data) {
            return {
            results: data
            };
        },
        cache: true
        }
    });

    $('#diagawalUpdate').select2({
        placeholder: 'Ketik kode atau nama diagnosa',
        minimumInputLength: 1,
        language: {
        inputTooShort: function(args) {
            return "Ketik kode atau nama diagnosa";
        },
        noResults: function() {
            return "Diagnosa tidak ditemukan.";
        },
        searching: function() {
            return "Searching.....";
        }
        },
        ajax: {
        type: 'GET',
        url: '<?php echo base_url().'irj/Diagnosa/select2_kode'; ?>',
        dataType: 'JSON',
        delay: 250,
        processResults: function (data) {
            return {
            results: data
            };
        },
        cache: true
        }
    });

    function simpanPengajuan(type)
    {
        let data = $('#pengajuanapproval').serialize();
        $.ajax({
            url: `<?= base_url('bpjs/sep/pengajuan_approval') ?>/${type}`,
            data:data,
            method: "POST",
            type:'JSON',
            beforeSend: function() {
            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    new swal("Berhasil!",data.metaData.message, "success");
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");
                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {

            }
        });
    }

    // Pengajuan Approval
    function caripengajuan(val)
    {
        $.ajax({
            url: `<?= base_url('irj/rjcregistrasi/get_data_pasien_by_no_kartu/') ?>/${val}`,
            beforeSend: function() {
                $(".loadinghasilpengajuan").show();
                $('#hasilpengajuan').hide();
            },
            success: function(data) {
                $('#hasilpengajuan').show();
                let html = '';
                if(data)
                {
                    $('#noKartuup').val(val);
                    return;
                }
                html+= 'Data Kosong';
                $("#hasilpengajuan").html(html);

                // if(data.metaData.code === '200'){
                    // parsingrencanakontrol(data.response);
                // }else{
                    // new swal("Peringatan!",data.metaData.message, "warning");

                // }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {
                $(".loadinghasilpengajuan").hide();

            }
        });
    }

    // end

    function panggilmodal(data)
    {
        $('#exampleModalLabel').html(data.label);
        $('#exampleModalContent').html(data.content);
        $('#exampleModalSubmit').attr('onclick',data.submit);
        $('#exampleModal').modal('show');
        
        if(data.label == 'Update SEP')
        {
            $("#noSepup").val(dataSep.noSep);
            $("#klsRawatHakup").val(dataSep.klsRawat.klsRawatHak);
            $("#klsRawatNaikup").val(dataSep.klsRawat.klsRawatNaik);
            $("#pembiayaanup").val(dataSep.klsRawat.pembiayaan);
            $("#penanggungJawabup").val(dataSep.klsRawat.penanggungJawab);
            $("#noMRup").val(dataSep.peserta.noMr);
            $("#catatanup").val(dataSep.catatan);
            $("#diagAwalup").val(dataSep.diagnosa);
            $("#tujuanup").val(dataSep.poli);
            $("#eksekutifup").val(dataSep.poliEksekutif);
            $("#cobup").val(dataSep.cob);
            $("#katarakup").val(dataSep.katarak);
            $("#lakaLantasup").val(dataSep.nmstatusKecelakaan);
            $("#tglKejadianup").val(dataSep.lokasiKejadian.tglKejadian);
            $("#keteranganup").val(dataSep.lokasiKejadian.ketKejadian);
            $("#suplesiup").val();
            $("#noSepSuplesiup").val();
            $("#kdPropinsiup").val(dataSep.lokasiKejadian.kdProp);
            $("#kdKabupatenup").val(dataSep.lokasiKejadian.kdKab);
            $("#kdKecamatanup").val(dataSep.lokasiKejadian.kdKec);
            $("#dpjpLayanup").val(dataSep.kdDPJP);
            $("#noTelpup").val();
            $("#userup").val();
        }
    }

    function carisep(val)
    {
        $("#hasilrencanakontrol").hide();
        $.ajax({
            url: `<?= base_url('bpjs/sep/cari_sep') ?>/${val}`,
            beforeSend: function() {
                $(".loadinghasilrencanakontrol").show();
            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    parsingrencanakontrol(data.response,data.local);
                    dataSep = data.response;
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

    function parsingrencanakontrol(data,local='')
    {
        // console.log(data.dpjp.kdDPJP);
        $('#hasilrencanakontrol').show();

        $("#noSep").val(data.noSep);
        $("#tglSep").val(data.tglSep);
        $("#jnsPelayanan").val(data.jnsPelayanan);
        $("#klsRawatHak").val(data.klsRawat.klsRawatHak);
        $("#klsRawatNaik").val(data.klsRawat.klsRawatNaik);
        $("#pembiayaan").val(data.klsRawat.pembiayaan);
        $("#penanggungJawab").val(data.klsRawat.penanggungJawab);
        $("#noMr").val(data.peserta.noMr);
        $("#catatan").val(data.catatan);

        var rujukanTrigger = {
            id: local.diagawal,
            text: data.diagnosa
        };

        var newOption = new Option(rujukanTrigger.text, rujukanTrigger.id, false, false);
        $('#diagawalUpdate').append(newOption).trigger('change');
        
        var rujukanTrigger = {
            id: local.politujuan,
            text: data.poli
        };

        var newOption = new Option(rujukanTrigger.text, rujukanTrigger.id, false, false);
        $('#poliTujuanUpdate').append(newOption).trigger('change');
        // var dokter = {
        //     id: data.dpjp.kdDPJP,
        //     text: data.dpjp.nmDPJP
        // };

        // var newOption = new Option(dokter.text, dokter.id, false, false);
        
        // #('#dpjpLayan').append(newOption).trigger('change');
        // cariDokterDpjp('#dpjpLayan',local.politujuan);
        $("#eksekutif").val(data.poliEksekutif);
        $("#cob").val(data.cob);
        $("#katarak").val(data.katarak);
        $("#lakaLantas").val(data.kdStatusKecelakaan);
        $("#tglKejadian").val(data.lokasiKejadian.tglKejadian);
        $("#keterangan").val(data.lokasiKejadian.ketKejadian);
        
        if(data.lokasiKejadian.kdProp){
            $("#kdPropinsi").val(data.lokasiKejadian.kdProp).trigger('change');
            pilihKabupaten(data.lokasiKejadian.kdProp);
            $('#kdKabupaten').val(data.lokasiKejadian.kdKab).trigger('change');
            pilihKecamatan(data.lokasiKejadian.kdKab);
            $("#kdKecamatan").val(data.lokasiKejadian.kdKec).trigger('change');;
        }
        var dpjpLayan = {
            id: data.dpjp.kdDPJP,
            text: data.dpjp.nmDPJP
        };

        var newOption = new Option(dpjpLayan.text, dpjpLayan.id, false, false);
        $('#dpjpLayan').append(newOption).trigger('change');
        $('#noTelp').val(local.notelp)
        
        // $("#noRujukan").val(data.noRujukan);
        // $("#penjamin").val(data.penjamin);
        // $("#kdStatusKecelakaan").val(data.kdStatusKecelakaan);
        // $("#nmstatusKecelakaan").val(data.nmstatusKecelakaan);
        // $("#nama").val(data.peserta.nama);
        // $("#noKartu").val(data.peserta.noKartu);
        // $("#tglLahir").val(data.peserta.tglLahir);



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
            url: '<?= base_url('bpjs/rencanakontrol/data_poli') ?>'+`?jnskontrol=${$('#jnsKontrol').val()}&nomor=${$('#noSep').val()}&tglrencanakontrol=${value}`,
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
                }
            },
            error: function(xhr) {
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
            url: `<?= base_url() ?>/bpjs/sep/update_sep`,
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
            'label':'Update SEP',
            'content':`
            <form id="updateSep">
                <?= bikin2('noSep') ?>
                <hr>
                <?= bikin2('klsRawatHak') ?>
                <?= bikin2('klsRawatNaik') ?>
                <?= bikin2('pembiayaan') ?>
                <?= bikin2('penanggungJawab') ?>
                <hr>
                <?= bikin2('noMR') ?>
                <?= bikin2('catatan') ?>
                <?= selectbikin('diagAwal','<option value="" selected>Silahkan Pilih Diagnosa</option>') ?>
                <hr>
                <?= bikin2('tujuan') ?>
                <?= bikin2('eksekutif') ?>
                <hr>
                <?= bikin2('cob') ?>
                <?= bikin2('katarak') ?>
                <hr>
                <?= bikin2('lakaLantas') ?>
                <?= bikin2('tglKejadian') ?>
                <?= bikin2('keterangan') ?>
                <?= bikin2('suplesi') ?>
                <?= bikin2('noSepSuplesi') ?>
                <?= bikin2('kdPropinsi') ?>
                <?= bikin2('kdKabupaten') ?>
                <?= bikin2('kdKecamatan') ?>
                <hr>
                <?= bikin2('dpjpLayan') ?>
                <?= bikin2('noTelp') ?>
                <?= bikin2('user') ?>
            </form>
            `,
            'submit':'updateSep()'
       }
       $('#diagAwalup').select2({
            placeholder: 'Ketik kode atau nama diagnosa',
            minimumInputLength: 1,
            language: {
            inputTooShort: function(args) {
                return "Ketik kode atau nama diagnosa";
            },
            noResults: function() {
                return "Diagnosa tidak ditemukan.";
            },
            searching: function() {
                return "Searching.....";
            }
            },
            ajax: {
            type: 'GET',
            url: '<?php echo base_url().'irj/Diagnosa/select2_kode'; ?>',
            dataType: 'JSON',
            delay: 250,
            processResults: function (data) {
                return {
                results: data
                };
            },
            cache: true
            }
        });
        panggilmodal(dataModal);
    }

    /**End Update Rencana Kontrol */


    /**
     * Hapus Rencana Kontrol
     */

    function hapusrencanakontrol()
    {
        let sep = $('#sep').val();
        $.ajax({
            method: 'POST',
            type:'JSON',
            data:{
                'nosep': sep,
                'user':'<?= $user ?>',
            },
            url: `<?= base_url() ?>/bpjs/sep/delete_sep`,
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
            }
        });
    }

    /**
     * End Hapus Rencana Kontrol
     */

    $(document).ready(function(){
        $('#hasilrencanakontrol').hide();
        $(".loadinghasilrencanakontrol").hide();
        $('#hasilpengajuan').hide();
        $(".loadinghasilpengajuan").hide();
        $("#hasilSepInternal").hide();
        

        $.ajax({
			type: "GET",
			url: '<?= base_url('bpjs/referensi/provinsi') ?>',
			beforeSend: function() {
				$('#kdPropinsi').append('<option selected>Silahkan Ditunggu....</option>');

			},
			success: function(success){
				if(success.response.list === undefined){
					$('#kdPropinsi').empty().append('<option selected>Silahkan Kontak Admin IT</option>');
					return;
				}
				var html = `<option value="" selected>-- Silahkan Pilih Provinsi --</option>`;
				success.response.list.map((val)=>{
					html +=`
						<option value="${val.kode}">${val.nama}</option>
					`;
				})
				$('#kdPropinsi').empty().append(html);
				return;
			},
			error:function(error){
				$('#kdPropinsi').empty().append('<option selected>Silahkan Kontak Admin IT</option>');
				return;
			},
		});
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
