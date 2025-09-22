<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);

    function bikin($nama){
        echo '<label for="'.$nama.'" class="col col-form-label">'.$nama.' :</label>
        <div class="col">
            <input type="text"  class="form-control" id="'.$nama.'" readonly>
        </div>';
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

    function selectbikin($nama,$option='')
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
    List Rujukan Keluar RS
  </div>
  <div class="card-body">
    <h5 class="card-title">List Rujukan Keluar RS</h5>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <label for="tglMulaiRujukanKeluarRs" class="col-2 form-label">Tgl. Mulai :</label>
                <input type="date" class="form-control" name="tglMulaiRujukanKeluarRs" id="tglMulaiRujukanKeluarRs">&nbsp;&nbsp;&nbsp;
                <label for="tglAkhirRujukanKeluarRs" class="col-2 form-label">Tgl. Akhir :</label>
                <input type="date" class="form-control" name="tglAkhirRujukanKeluarRs" id="tglAkhirRujukanKeluarRs">
                <button class="btn btn-primary" id="cariButtonRujukanKeluarRs" onclick="cariListRujukanKeluarRs()">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="card m-5" id="hasilListRujukanBody">
  <div class="card-header">
    Hasil Pencarian List Rujukan Keluar RS
  </div>
  <div class="card-body">
    <h5 class="card-title">Hasil : </h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">No. Rujukan</th>
                    <th scope="col">Tgl. Rujukan</th>
                    <th scope="col">Jenis Pelayanan</th>
                    <th scope="col">No. SEP</th>
                    <th scope="col">No. Kartu</th>
                    <th scope="col">Nama</th>
                    <th scope="col">PPK Dirujuk</th>
                    <th scope="col">Nama PPK Dirujuk</th>
                </tr>
            </thead>
            <tbody id="hasillistRujukan"></tbody>
        </table>
    </div>
  </div>
</div>


<div class="card m-5" id="detailRujukan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Detail Rujukan
        </div>
    </div>
    <div class="card-body">
        <form id="detailRujukan">
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">noRujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="noRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">No. SEP :</label>
                <input type="text" class="form-control" name="noRujukan" id="noSep">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">noKartu :</label>
                <input type="text" class="form-control" name="noRujukan" id="noKartu">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Nama :</label>
                <input type="text" class="form-control" name="noRujukan" id="nama">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">kelas Rawat :</label>
                <input type="text" class="form-control" name="noRujukan" id="kelasRawat">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">kelamin :</label>
                <input type="text" class="form-control" name="noRujukan" id="kelamin">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">tgl Lahir :</label>
                <input type="text" class="form-control" name="noRujukan" id="tglLahir">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Tgl Sep :</label>
                <input type="text" class="form-control" name="noRujukan" id="tglSep">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Tgl Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="tglRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Tgl Rencana Kunjungan :</label>
                <input type="text" class="form-control" name="noRujukan" id="tglRencanaKunjungan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Ppk Dirujuk :</label>
                <input type="text" class="form-control" name="noRujukan" id="ppkDirujuk">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Nama Ppk Dirujuk :</label>
                <input type="text" class="form-control" name="noRujukan" id="namaPpkDirujuk">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Jns Pelayanan :</label>
                <input type="text" class="form-control" name="noRujukan" id="jnsPelayanan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">catatan :</label>
                <input type="text" class="form-control" name="noRujukan" id="catatan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Diag Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="diagRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Nama Diag Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="namaDiagRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Tipe Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="tipeRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Nama Tipe Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="namaTipeRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Poli Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="poliRujukan">
            </div>
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">Nama Poli Rujukan :</label>
                <input type="text" class="form-control" name="noRujukan" id="namaPoliRujukan">
            </div>
        </form>
    </div>
</div>


<div class="card m-5" id="hasilpengajuan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Form Pembuatan Rujukan
        </div>
    </div>
    <div class="card-body">
        <form id="buatRujukan">
            <?= bikin2('noSep') ?>
            <?= datebikin('tglRujukan') ?>
            <?= datebikin('tglRencanaKunjungan') ?>
            <div class="row mb-2">
                <label for="kodefaskes" class="col col-form-label">Jenis faskes :</label>
                <div class="col">
                    <select class="form-select" id="kodefaskes" onchange="gantiFaskes(this.value)">
                    <option value="">Silahkan Dipilih</option><option value="1">Faskes 1</option><option value="2" >Faskes 2 / RS</option>
                    </select>
                </div>
            </div>
            <?= selectbikin('ppkDirujuk') ?>
            <?= selectbikin('jnsPelayanan','<option value="1">Rawat Inap</option><option value="2">Rawat Jalan</option>') ?>
            <?= bikin2('catatan') ?>
            <?= selectbikin('diagRujukan') ?>
            <?= selectbikin('tipeRujukan','<option value="0">Penuh</option><option value="1">Partial</option><option value="2">Balik PRB</option>') ?>
            <?= selectbikin('poliRujukan') ?>
            <?= bikin2('user',$user) ?>
        </form>
        <button type="button" class="btn btn-primary" id="SubmitRujukan">Simpan</button>

    </div>
</div>


<div class="card m-5" id="hasilpengajuan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Form Edit Rujukan
        </div>
    </div>
    <div class="card-body">
        <form id="editRujukan">
            <div class="row mb-3">
                <label for="noRujukanEdit" class="col-sm col-form-label">noRujukan :</label>
                <div class="input-group col">
                    <input type="text" class="form-control" name="noRujukan" id="noRujukanEdit">
                    <button type="button" class="btn btn-primary" id="ceknorujukanbutton" onclick="cekNoRujukan($('#noRujukanEdit').val())">Cek No. Rujukan</button>
                </div>
            </div>
            <div class="row mb-2">
                <label for="tglRujukanEdit" class="col col-form-label">tglRujukan :</label>
                <div class="col">
                    <input type="date" class="form-control openformedit" name="tglRujukan" id="tglRujukanEdit">
                </div>
            </div>
            <div class="row mb-2">
                <label for="tglRencanaKunjunganEdit" class="col col-form-label">tglRencanaKunjungan :</label>
                <div class="col">
                    <input type="date" class="form-control openformedit" name="tglRencanaKunjungan" id="tglRencanaKunjunganEdit">
                </div>
            </div>
            <div class="row mb-2">
                <label for="jenisFaskesEdit" class="col col-form-label">Jenis faskes :</label>
                <div class="col">
                    <select class="form-select openformedit" id="jenisFaskesEdit" onchange="gantiFaskesEdit(this.value)">
                        <option value="1">Faskes 1</option><option value="2" selected>Faskes 2 / RS</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="ppkDirujukEdit" class="col col-form-label">ppkDirujuk :</label>
                <div class="col">
                    <select class="form-select openformedit" name="ppkDirujuk" id="ppkDirujukEdit">
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="jnsPelayananEdit" class="col col-form-label">jnsPelayanan :</label>
                <div class="col">
                    <select class="form-select openformedit" name="jnsPelayanan" id="jnsPelayananEdit">
                        <option value="1">Rawat Inap</option><option value="2">Rawat Jalan</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="catatanEdit" class="col col-form-label">catatan :</label>
                <div class="col">
                    <input type="text" class="form-control openformedit" name="catatan" id="catatanEdit" value="">
                </div>
            </div>
            <div class="row mb-2">
                <label for="diagRujukanEdit" class="col col-form-label">diagRujukan :</label>
                <div class="col">
                    <select class="form-select openformedit" name="diagRujukan" id="diagRujukanEdit">
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="tipeRujukanEdit" class="col col-form-label">tipeRujukan :</label>
                <div class="col">
                    <select class="form-select openformedit" name="tipeRujukan" id="tipeRujukanEdit">
                        <option value="0">Penuh</option><option value="1">Partial</option><option value="2">Balik PRB</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="poliRujukanEdit" class="col col-form-label">poliRujukan :</label>
                <div class="col">
                    <select class="form-select openformedit" name="poliRujukan" id="poliRujukanEdit">
                    </select>
                </div>
            </div>
            <div class="row mb-2">
                <label for="userEdit" class="col col-form-label">user :</label>
                <div class="col">
                    <input type="text" class="form-control openformedit" name="user" id="userEdit" >
                </div>
            </div>
        </form>
        <button type="button" class="btn btn-primary openformedit" id="SubmitEditRujukan">Simpan</button>

    </div>
</div>

<div class="card m-5">
  <div class="card-header">
    List Spesialistik Rujukan
  </div>
  <div class="card-body">
    <h5 class="card-title">List Spesialistik Rujukan</h5>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <label for="kodePpk" class="col-2 form-label">Kode PPK Rujukan :</label>
                <input type="text" class="form-control" name="kodePpk" id="kodePpk">&nbsp;&nbsp;&nbsp;
                <label for="tglRujukan" class="col-2 form-label">Tgl. Rujukan :</label>
                <input type="date" class="form-control" name="tglRujukan" id="tglRujukanSpesialistik">
                <button class="btn btn-primary" id="cariButtonRujukan" onclick="cariListRujukanKeluar()">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>



<div class="card m-5" id="hasilListSpesialistik">
  <div class="card-header">
    Hasil Pencarian List Spesialistik Rujukan
  </div>
  <div class="card-body">
    <h5 class="card-title">Hasil : </h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode Spesialis</th>
                    <th scope="col">Nama Spesialis</th>
                    <th scope="col">Kapasitas</th>
                    <th scope="col">Jumlah Rujukan</th>
                    <th scope="col">Persentase</th>
                </tr>
            </thead>
            <tbody id="dataHasilListSpesialistik"></tbody>
        </table>
    </div>
  </div>
</div>


<div class="card m-5">
  <div class="card-header">
    List Sarana Rujukan
  </div>
  <div class="card-body">
    <h5 class="card-title">List Sarana Rujukan</h5>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <label for="kodePPkRujukanSarana" class="col-2 form-label">Kode PPK Rujukan :</label>
                <input type="text" class="form-control" name="kodePPkRujukanSarana" id="kodePPkRujukanSarana">&nbsp;&nbsp;&nbsp;
                <button class="btn btn-primary" id="cariListSaranaRujukanBtn" onclick="cariListSaranaRujukan()">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>



<div class="card m-5" id="hasilListSarana">
  <div class="card-header">
    Hasil Pencarian List Sarana Rujukan
  </div>
  <div class="card-body">
    <h5 class="card-title">Hasil : </h5>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Kode Sarana</th>
                    <th scope="col">Nama Sarana</th>
                </tr>
            </thead>
            <tbody id="dataHasilListSarana"></tbody>
        </table>
    </div>
  </div>
</div>

<script>
    
    $('.openformedit').attr('disabled',true);
    $('#hasilListRujukan').hide();

    function detailRujukan(norujukan)
    {
        $.ajax({
            url: '<?= base_url('bpjs/rujukan/data_rujukan_keluar_rs?norujukan=') ?>'+norujukan,
            beforeSend: function() {
                // $('#SubmitEditRujukan').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code == '200')
                {
                    // new swal("Berhasil!",data.metaData.message, "success");
                    // return;
                    $('#detailRujukan').show();
                    $('#noRujukan').val(data.response.rujukan.noRujukan);
                    $('#noSep').val(data.response.rujukan.noSep);
                    $('#noKartu').val(data.response.rujukan.noKartu);
                    $('#nama').val(data.response.rujukan.nama);
                    $('#kelasRawat').val(data.response.rujukan.kelasRawat);
                    $('#kelamin').val(data.response.rujukan.kelamin);
                    $('#tglLahir').val(data.response.rujukan.tglLahir);
                    $('#tglSep').val(data.response.rujukan.tglSep);
                    $('#tglRujukan').val(data.response.rujukan.tglRujukan);
                    $('#tglRencanaKunjungan').val(data.response.rujukan.tglRencanaKunjungan);
                    $('#ppkDirujuk').val(data.response.rujukan.ppkDirujuk);
                    $('#namaPpkDirujuk').val(data.response.rujukan.namaPpkDirujuk);
                    $('#jnsPelayanan').val(data.response.rujukan.jnsPelayanan);
                    $('#catatan').val(data.response.rujukan.catatan);
                    $('#diagRujukan').val(data.response.rujukan.diagRujukan);
                    $('#namaDiagRujukan').val(data.response.rujukan.namaDiagRujukan);
                    $('#tipeRujukan').val(data.response.rujukan.tipeRujukan);
                    $('#namaTipeRujukan').val(data.response.rujukan.namaTipeRujukan);
                    $('#poliRujukan').val(data.response.rujukan.poliRujukan);
                    $('#namaPoliRujukan').val(data.response.rujukan.namaPoliRujukan);
                    return;
                }
                new swal("Peringatan!",data.metaData.message, "warning");
                return;
                
            },
            error: function(xhr) { 
                new swal("Peringatan!",'Silahkan Kontak Admin IT', "warning");
                return;
            },
            complete: function() {
                // $('#SubmitEditRujukan').attr('disabled',false);                
            },
            dataType: 'json'
        });
    }

    function cariListSaranaRujukan()
    {
        $.ajax({
            url: `<?= base_url('bpjs/rujukan/list_sarana?ppkrujukan=') ?>${$('#kodePPkRujukanSarana').val()}`,
            beforeSend: function() {
                $('#cariListSaranaRujukanBtn').html('Loading...');
                $('#cariListSaranaRujukanBtn').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    $('#hasilListSarana').show();
                    $('#dataHasilListSarana').html('<tr><td style="text-align:center;" colspan="9">Silahkan Ditunggu...</td></tr>');
                    let html = ''
                    let no = 1;
                    data.response.list.map((e)=>{
                        html+=`
                            <tr>
                                <td scope="row">${no}</td>
                                <td>${e.kodeSarana}</td>
                                <td>${e.namaSarana}</td>
                            </tr>
                        `;
                        no++;
                    })
                    html+='';

                    $('#dataHasilListSarana').html(html);
                    
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");
                    $('#hasilListSarana').hide();

                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");
                $('#hasilListSarana').hide();

            },
            complete: function() {
                $('#cariListSaranaRujukanBtn').html('Cari Data');
                $('#cariListSaranaRujukanBtn').attr('disabled',false);
            }
        });
    }

    function cariListRujukanKeluarRs()
    {
        $.ajax({
            url: `<?= base_url('bpjs/rujukan/list_rujukan_keluar_rs') ?>?tglmulai=${$('#tglMulaiRujukanKeluarRs').val()}&tglakhir=${$('#tglAkhirRujukanKeluarRs').val()}`,
            beforeSend: function() {
                $('#cariButtonRujukanKeluarRs').html('Loading...');
                $('#cariButtonRujukanKeluarRs').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    $('#hasilListRujukanBody').show();
                    $('#hasillistRujukan').html('<tr><td style="text-align:center;" colspan="9">Silahkan Ditunggu...</td></tr>');
                    let html = ''
                    let no = 1;
                    data.response.list.map((e)=>{
                        html+=`
                            <tr>
                                <td scope="row">${no}</td>
                                <td>${e.noRujukan}</td>
                                <td>${e.tglRujukan}</td>
                                <td>${e.jnsPelayanan}</td>
                                <td>${e.noSep}</td>
                                <td>${e.noKartu}</td>
                                <td>${e.nama}</td>
                                <td>${e.ppkDirujuk}</td>
                                <td>${e.namaPpkDirujuk}</td>
                            </tr>
                        `;
                        no++;
                    })
                    html+='';

                    $('#hasillistRujukan').html(html);
                    
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");
                    $('#hasilListRujukanBody').hide();

                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");
                $('#hasilListRujukanBody').hide();

            },
            complete: function() {
                $('#cariButtonRujukanKeluarRs').html('Cari Data');
                $('#cariButtonRujukanKeluarRs').attr('disabled',false);
            }
        });
    }

    function cariListRujukanKeluar()
    {
        $.ajax({
            url: `<?= base_url('bpjs/rujukan/list_spesialistik_rujukan?ppkrujukan=') ?>${$('#kodePpk').val()}&tglrujukan=${$('#tglRujukanSpesialistik').val()}`,
            beforeSend: function() {
                $('#cariListRujukanKeluar').html('Loading...');
                $('#cariListRujukanKeluar').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code === '200'){
                    $('#hasilListSpesialistik').show();
                    $('#dataHasilListSpesialistik').html('<tr><td style="text-align:center;" colspan="9">Silahkan Ditunggu...</td></tr>');
                    let html = ''
                    let no = 1;
                    data.response.list.map((e)=>{
                        html+=`
                            <tr>
                                <td scope="row">${no}</td>
                                <td>${e.kodeSpesialis}</td>
                                <td>${e.namaSpesialis}</td>
                                <td>${e.kapasitas}</td>
                                <td>${e.jumlahRujukan}</td>
                                <td>${e.persentase}</td>
                            </tr>
                        `;
                        no++;
                    })
                    html+='';

                    $('#dataHasilListSpesialistik').html(html);
                    
                }else{
                    new swal("Peringatan!",data.metaData.message, "warning");
                    $('#hasilListSpesialistik').hide();

                }
            },
            error: function(xhr) {
                new swal("Peringatan!",'Hubungi Admin IT', "warning");
                $('#hasilListSpesialistik').hide();

            },
            complete: function() {
                $('#cariListRujukanKeluar').html('Cari Data');
                $('#cariListRujukanKeluar').attr('disabled',false);
            }
        });
    }

    function cekNoRujukan(val)
    {
        if(val!='')
        {
            $.ajax({
                url: `<?= base_url('bpjs/rujukan/data_rujukan/') ?>/${val}`,
                beforeSend: function() {
                    $('#ceknorujukanbutton').html('Loading...');
                    $('#ceknorujukanbutton').attr('disabled',true);
                },
                success: function(data) {
                    if(data.metaData.code === '200'){
                        $('.openformedit').attr('disabled',false);
                        $("#tglRujukanEdit").val(data.response.rujukan.tglRujukan);
                        $("#tglRencanaKunjunganEdit").val(data.response.rujukan.tglRencanaKunjungan);
                        var rujukanTrigger = {
                            id: data.response.rujukan.ppkDirujuk,
                            text: data.response.rujukan.namaPpkDirujuk
                        };

                        var newOption = new Option(rujukanTrigger.text, rujukanTrigger.id, false, false);
                        $('#ppkDirujukEdit').append(newOption).trigger('change');


                        $("#jnsPelayananEdit").val(data.response.rujukan.jnsPelayanan);
                        $("#catatanEdit").val(data.response.rujukan.catatan);
                        var rujukanTrigger = {
                            id: data.response.rujukan.diagRujukan,
                            text: data.response.rujukan.namaDiagRujukan
                        };
                        
                        var newOption = new Option(rujukanTrigger.text, rujukanTrigger.id, false, false);
                        
                        $("#diagRujukanEdit").append(newOption).trigger('change');
                        
                        var rujukanTrigger = {
                            id: data.response.rujukan.tipeRujukan,
                            text: data.response.rujukan.namaTipeRujukan
                        };
                        
                        var newOption = new Option(rujukanTrigger.text, rujukanTrigger.id, false, false);
                        
                        $("#tipeRujukanEdit").append(newOption).trigger('change');
                        
                        var rujukanTrigger = {
                            id: data.response.rujukan.poliRujukan,
                            text: data.response.rujukan.namaPoliRujukan
                        };
                        
                        var newOption = new Option(rujukanTrigger.text, rujukanTrigger.id, false, false);
                        
                        $("#poliRujukanEdit").append(newOption).trigger('change');

                        $('#userEdit').val(data.response.rujukan.user);
                        
                    }else{
                        new swal("Peringatan!",data.metaData.message, "warning");
                        $('.openformedit').attr('disabled',true);

                    }
                },
                error: function(xhr) {
                    new swal("Peringatan!",'Hubungi Admin IT', "warning");
                    $('.openformedit').attr('disabled',true);

                },
                complete: function() {
                    $('#ceknorujukanbutton').html('Cek No. Rujukan');
                    $('#ceknorujukanbutton').attr('disabled',false);
                }
            });
            return;
        }

        $('.openformedit').attr('disabled',true);
    }

    let faskes = '2';
    let faskesedit = '2';

    function gantiFaskesEdit(val)
    {
        if(val != ''){

            $('#ppkDirujukEdit').select2({
            placeholder: 'Ketik kode atau nama PPK',
            minimumInputLength: 3,
            language: {
            inputTooShort: function(args) {
                return "Ketik kode atau nama PPK";
            },
            noResults: function() {
                return "PPK tidak ditemukan.";
            },
            searching: function() {
                return "Sedang Dicari.....";
            }
            },
            ajax: {
            type: 'GET',
            url: '<?php echo base_url().'bpjs/rujukan/ppa_rujukan?kodefaskes='; ?>'+val,
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
        }
    }


    function gantiFaskes(val)
    {
        if(val != ''){

            $('#ppkDirujukup').select2({
                placeholder: 'Ketik kode atau nama PPK',
                minimumInputLength: 1,
                language: {
                inputTooShort: function(args) {
                    return "Ketik kode atau nama PPK";
                },
                noResults: function() {
                    return "PPK tidak ditemukan.";
                },
                searching: function() {
                    return "Sedang Dicari.....";
                }
                },
                ajax: {
                type: 'GET',
                url: '<?php echo base_url().'bpjs/rujukan/ppa_rujukan?kodefaskes='; ?>'+val,
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
        }
    }
    $(document).ready(function(){
        
        $('#kodefaskesup').change(function(e){
            faskes = this.value;
        });
        $('#detailRujukan').hide();
        $('#hasilListSpesialistik').hide();
        $('#hasilListSarana').hide();
        $('#hasilListRujukanBody').hide();
        

        
    });


    $('#SubmitEditRujukan').click(function(){
        let data = $('#editRujukan').serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('bpjs/rujukan/update') ?>',
            data: data,
            beforeSend: function() {
                $('#SubmitEditRujukan').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code == '200')
                {
                    new swal("Berhasil!",data.metaData.message, "success");
                    return;
                }
                new swal("Peringatan!",data.metaData.message, "warning");
                return;
                
            },
            error: function(xhr) { 
                new swal("Peringatan!",'Silahkan Kontak Admin IT', "warning");
                return;
            },
            complete: function() {
                $('#SubmitEditRujukan').attr('disabled',false);                
            },
            dataType: 'json'
        });
    })

    $('#SubmitRujukan').click(function(){
        let data = $('#buatRujukan').serialize();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('bpjs/rujukan/insert') ?>',
            data: data,
            beforeSend: function() {
                $('#SubmitRujukan').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code == '200')
                {
                    window.open('<?php echo base_url().'bpjs/rujukan/cetak_rujukan/'; ?>'+`${data.response.rujukan.noRujukan}`, '_blank');
                    // new swal("Berhasil!",data.metaData.message, "success");

                    return;
                }
                new swal("Peringatan!",data.metaData.message, "warning");
                return;
                
            },
            error: function(xhr) { 
                new swal("Peringatan!",'Silahkan Kontak Admin IT', "warning");
                return;
            },
            complete: function() {
                $('#SubmitRujukan').attr('disabled',false);                
            },
            dataType: 'json'
        });
    })

    

    $('#diagRujukanup').select2({
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

    $('#diagRujukanEdit').select2({
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

    

    


    
    $('#poliRujukanup').select2({
        placeholder: 'Ketik kode atau nama Poli',
        minimumInputLength: 3,
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

    $('#poliRujukanEdit').select2({
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
    
    
</script>
