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
    Data Lembar Pengajuan Klaim
  </div>
  <div class="card-body">
    <h5 class="card-title">Pencarian data peserta berdasarkan NIK Kependudukan</h5>
    <div class="row">
        <div class="col">
            <div class="input-group">
                <label for="tglMasuk" class="col-2 form-label">Tgl. Masuk :</label>
                <input type="date" class="form-control" name="tglMasuk" id="tglMasuk">&nbsp;&nbsp;&nbsp;
                <label for="tglAkhir" class="col-2 form-label">Jenis Pelayanan :</label>
                <select class="form-control" name="tglAkhir" id="tglAkhir">
                    <option value="1">Rawat Inap</option>
                    <option value="2">Rawat Jalan</option>
                </select>
                <button class="btn btn-primary" id="cariButtonRujukan" onclick="cariLembarPengajuanKlaim()">Cari Data</button>
            </div>
        </div>
    </div>
  </div>
</div>

<div class="loadinghasilrencanakontrol m-5">Loading...</div>

<div class="card m-5" id="hasilrencanakontrol">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Hasil Pencarian 
        </div>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="row">No.</th>
                    <th scope="row">DPJP</th>
                    <th scope="row">Diagnosa</th>
                    <th scope="row">Jns. Pelayanan</th>
                    <th scope="row">No. SEP</th>
                    <th scope="row">Cara Keluar</th>
                    <th scope="row">Kelas Rawat</th>
                    <th scope="row">Kondisi Pulang</th>
                    <th scope="row">Ruang Rawat</th>
                    <th scope="row">Spesialistik</th>
                    <th scope="row">Nama</th>
                    <th scope="row">
                        <button class="btn btn-primary">Detail</button>
                        <button class="btn btn-primary">Update</button>
                        <button class="btn btn-primary">Hapus</button>
                    </th>
                </tr>
            </thead>
            <tbody id="hasilPencarian">

            </tbody>
        </table>
       
    </div>
</div>


<div class="card m-5" id="hasilpengajuan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Form Pengajuan Klaim
        </div>
    </div>
    <div class="card-body">
        <form id="buatKlaim">
            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">No. SEP</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="noSep" id="no_sep">
                        <span class="input-group-btn">
                            <button class="btn waves-effect waves-light btn-danger" type="button" id="btn-cek-sep"><i class="fa fa-eye"></i> Cek No. SEP</button>
                        </span>
                    </div>
                </div>								
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Tanggal Masuk</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="date" class="form-control" name="tglMasuk" id="tgl_masuk"  >
                    </div>	
                </div>								
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Tanggal Keluar</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="date" class="form-control" name="tglKeluar"  id="tgl_keluar">
                    </div>	
                </div>								
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Jaminan</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="jaminan" class="form-control" id="jaminan" style="width: 100%">
                        <option value="1">JKN</option>
                    </select>
                    </div>
                </div>								
            </div>

            
            <div class="form-group row ranap mb-3">
                <label class="col-sm-3 control-label col-form-label">Ruang Rawat</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="ruangRawat" class="form-control" id="ruangrawat" style="width: 100%">
                    </select>
                    </div>
                </div>								
            </div>
            <div class="form-group row ranap mb-3">
                <label class="col-sm-3 control-label col-form-label">Kelas Rawat</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="kelasRawat" class="form-control ranap" id="kelasrawat" style="width: 100%">
                    </select>
                    </div>
                </div>								
            </div>
            <div class="form-group row ranap mb-3">
                <label class="col-sm-3 control-label col-form-label">Spesialistik</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="spesialistik" class="form-control" id="spesialistik" style="width: 100%">
                    </select>
                    </div>
                </div>								
            </div>

            <div class="form-group row ranap mb-3" >
                <label class="col-sm-3 control-label col-form-label">Cara Keluar</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="caraKeluar" class="form-control " id="carakeluar" style="width: 100%">
                    </select>
                    </div>
                </div>								
            </div>
            <div class="form-group row ranap mb-3">
                <label class="col-sm-3 control-label col-form-label">Kondisi Pulang</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="kondisiPulang" class="form-control " id="pascapulang" style="width: 100%">
                    </select>
                    </div>
                </div>								
            </div>
           

            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Tindak Lanjut</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="tindakLanjut" class="form-control" id="tindaklanjut" style="width: 100%" onchange="gantiTindakLanjut(this.value)">
                        <option value="1">Diperbolehkan Pulang</option>
                        <option value="2">Pemeriksaan Penunjang</option>
                        <option value="3">Dirujuk Ke</option>
                        <option value="4">Kontrol Kembali</option>
                    </select>
                    </div>
                </div>								
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">poli Klinik</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="poliKlinik" class="form-control " id="poliKlinik" style="width: 100%">
                    </select>
                    </div>
                </div>								
            </div>
            
            <hr>
            
            <div class="dirujuke">
                <div class="form-group row mb-3">
                    <label  class="col-sm-3 control-label"><b> Dirujuk Ke</b></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label  class="col-sm-3 control-label">Jenis faskes :</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select class="form-select" onchange="gantiFaskes(this.value)">
                                <option value="1">Faskes 1</option><option value="2" selected>Faskes 2 / RS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label col-form-label">Kode Faskes / Nama Faskes</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select name="kodePPK" class="form-control" id="kodefaskes" style="width: 100%" >
                            </select>
                        </div>
                    </div>								
                </div>
            </div>
            <hr>
            <div class="kontrolkembali">
                <div class="form-group row mb-3">
                    <label  class="col-sm-3 control-label"><b> Kontrol Kembali :</b></label>
                    <div class="col-sm-8">
                        <div class="input-group">
                        </div>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label col-form-label">Tanggal Kontrol Kembali</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="date" class="form-control" name="tglKontrol" id="tgl_kontrol_kembali"  >
                        </div>	
                    </div>								
                </div>
    
                <div class="form-group row mb-3">
                    <label class="col-sm-3 control-label col-form-label">Poliklinik</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                        <select name="poli" class="form-control" id="poli_kontrol" style="width: 100%" >
                        </select>
                        </div>
                    </div>								
                </div>
            </div>
            <hr>

            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">DPJP</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <select name="DPJP" class="form-control" id="dokterdpjp" style="width: 100%">
                        </select>
                    </div>
                </div>								
            </div>

            <!-- Diagnosa  -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Diagnosa</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <select class="form-control" id="diagnosa" style="width:100%"></select>
                    
                    </div>
                </div>								
            </div>
            <!-- Tipe Diagnosa  -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Tipe Diagnosa</label>
                <div class="col-sm-8">
                    <div class="input-group">
                    <select name="tipe_diagnosa" class="form-control" id="tipe_diagnosa" style="width: 100%">
                        <option value="P">Primary</option>
                        <option value="S">Secondary</option>
                    </select>
                    </div>
                </div>								
            </div>
    
            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label"></label>
                <div class="col-sm-8">
                    <button type="button" id="btnTambahDiagnosa" class="btn btn-primary">Tambah Diagnosa</button>
                </div>								
            </div>
    
    
                <!-- Procedure  -->
            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label">Procedure</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <select class="form-control" name="procedure" id="procedure"></select>
                    </div>
                </div>								
            </div>
            <div class="form-group row mb-3">
                <label class="col-sm-3 control-label col-form-label"></label>
                <div class="col-sm-8">
                    <button type="button" id="btnTambahProcedure" class="btn btn-primary">Tambah Procedure</button>
                </div>								
            </div>
            <hr>
                <p>List Diagnosa</p>
                <div id="diagnosaTambahan"></div>
            <hr>
            <hr>
                <p>List Procedure</p>
                <div id="procedureTambahan"></div>
            <hr>
            <br><br>
        </form>
        <button type="button" class="btn btn-primary" id="submitLpk">Simpan</button>

    </div>
</div>

<script>
    var diagnosa = [];
    var procedure = [];
    $('#submitLpk').click(function(){
        var nosep = $('#no_sep').val();
        var tgl_masuk = $('#tgl_masuk').val();
        var tgl_keluar = $('#tgl_keluar').val();
        var jaminan = $('#jaminan').val();
        var poli = $('#poliKlinik').val();
        var ruangrawat = $('#ruangrawat').val();
        var kelasrawat = $('#kelasrawat').val();
        var spesialistik = $("#spesialistik").val();
        var carakeluar = $("#carakeluar").val();
        var kondisipulang = $('#pascapulang').val();
        var tindaklanjut = $('#tindaklanjut').val();
        var dirujukke = $('#kodefaskes').val();
        var tglkontrolkembali = $('#tgl_kontrol_kembali').val();
        var dpjp = $('#dokterdpjp').val();
        var polikontrolulang = $('#poli_kontrol').val();
        var data = {nosep,tgl_masuk,tgl_keluar,jaminan,poli,ruangrawat,kelasrawat,spesialistik,carakeluar,kondisipulang,tindaklanjut,dirujukke,tglkontrolkembali,dpjp,polikontrolulang}
        data.diagnosa = diagnosa;
        data.procedure = procedure;
        $.ajax({
            url: "<?php echo site_url('bpjs/lpk/insert'); ?>",
            dataType: "json",
            method:"post",
            data:data,
            success: function (data) {
                console.log(data);
                if(data.metaData.code !='200')
                {
                    new swal("Gagal !",result.metaData.code, "warning");
                    return;
                }
                new swal("Berhasil",result.metaData.code, "success");
                return;
            },
            error: function(err)
            {
                new swal("Gagal !",'Hubungi Tim IT', "warning");
            },
        });
    });

    function gantiTindakLanjut(value)
    {
        if(value == '3')
        {
            $(".dirujuke").show();
            $('.kontrolkembali').hide();
        }
        if(value == '4')
        {
            $(".dirujuke").hide();
            $('.kontrolkembali').show();
        }else{
            $(".dirujuke").hide();
            $('.kontrolkembali').hide();
        }
    }


    $('.ranap').hide();
    
    $('.dirujuke').hide();
    
    $('.kontrolkembali').hide();
    $('#btn-cek-sep').click(function(){
        $.ajax({
            url: "<?php echo site_url('bpjs/sep/cari_sep'); ?>/"+$('#no_sep').val(),
            dataType: "json",
            success: function (data) {
                console.log(data);
                if(data.metaData.code !='200')
                {
                    new swal("Gagal !",result.metaData.code, "warning");
                    return;
                }
                if(data.response.jnsPelayanan == 'Rawat Inap')
                {
                    $('.ranap').show();
                    return;
                }
                $("#tgl_masuk").val(data.response.tglSep);
                $("#tgl_keluar").val(data.response.tglSep);

                var datapoli = {
                    id: data.local.politujuan,
                    text: data.response.poli
                };

                var newOption = new Option(datapoli.text, datapoli.id, false, false);
                $('#poliKlinik').append(newOption).trigger('change');

                // var datadpjp = {
                //     id: data.response.dpjp.kdDPJP,
                //     text: data.response.dpjp.nmDPJP
                // };

                // var newOption = new Option(datadpjp.text, datadpjp.id, false, false);
                // $('#dokterdpjp').append(newOption).trigger('change');

            }
        });
    });

    $('#dokterdpjp').select2();
    $('#ruangrawat').select2();
    $('#kelasrawat').select2();
    $('#spesialistik').select2();
    $('#carakeluar').select2();
    $('#pascapulang').select2();


    $('#btnTambahDiagnosa').click(function(){
        if($('#diagnosa').val() == '')
        {
            swal('Peringatan!','Diagnosa Tidak Boleh diisi Kosong','warning');
            return;
        }
        if($('#tipe_diagnosa').val() == null)
        {   
            swal('Peringatan!','Silahkan Pilih Tipe Diagnosa','warning');
            return;
        }
        diagnosa.push({
            'kode':$('#diagnosa').val(),
            'level':`${$('#tipe_diagnosa').val()=='P'?'1':'2'}`
        });
        $('#diagnosaTambahan').append(`
                                    <ul>
                                        <li>${$('#diagnosa').val()} (${$('#tipe_diagnosa').val()})</li>
                                    </ul>
                                    `);
        $('#tipe_diagnosa').val('');
        $('#diagnosa').val('');
        // $('#diagnosa_autocomplete').val('');
    });

    $('#btnTambahProcedure').click(function(){
        if($('#procedure').val() == '')
        {
            swal('Peringatan!','Procedure Tidak Boleh diisi Kosong','warning');
            return;
        }
        procedure.push({
            'kode':`${$('#procedure').val()}`
        });
        $('#procedureTambahan').append(`
                                    <ul>
                                        <li>${$('#procedure').val()})</li>
                                    </ul>
                                    `);
        $('#procedure').val('');
        // console.log(procedure);
    });
    
    

    function selectdpjp(poli)
    {
        $.ajax({
            type: "GET",
            url: '<?= base_url('bpjs/referensi/dokter_dpjp?pelayanan=2&tglpelayanan='.date('Y-m-d')) ?>'+'&spesialis='+poli,
            success: function(success){
                if(success.response.list === undefined){
                    $('#dokterdpjp').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                    return;
                }
                var html = ``;
                success.response.list.map((val)=>{
                    html +=`
                        <option value="${val.kode}">${val.nama}</option>
                    `;
                });
                $('#dokterdpjp').html(html);
                
            },
            error:function(error){
                $('#dokterdpjp').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                return;
            }
        });
    }

    

    $('#poli_kontrol').select2({
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
    function cariLembarPengajuanKlaim()
    {
        $.ajax({
            url: '<?= base_url('bpjs/lpk/') ?>',
            beforeSend: function() {
            },
            success: function(data) {
            },
            error: function(xhr) { 
            },
            complete: function() {
            },
            });
    }

    
    $('#diagnosa').select2({
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

    $('#procedure').select2({
        placeholder: 'Ketik kode atau nama procedure',
        minimumInputLength: 1,
        language: {
        inputTooShort: function(args) {
            return "Ketik kode atau nama procedure";
        },
        noResults: function() {
            return "procedure tidak ditemukan.";
        },
        searching: function() {
            return "Searching.....";
        }
        },
        ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/procedure'; ?>',
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

    let faskes = '2';
    function gantiFaskes(val)
    {
        faskes = val;
    }



    $('#dokterdpjp').select2({
        placeholder: 'Ketik nama dokter/DPJP',
        minimumInputLength: 1,
        language: {
        inputTooShort: function(args) {
            return "Ketik nama dokter/DPJP";
        },
        noResults: function() {
            return "nama dokter/DPJP tidak ditemukan.";
        },
        searching: function() {
            return "Sedang Dicari.....";
        }
        },
        ajax: {
        type: 'GET',
        url: '<?php echo base_url().'bpjs/referensi/dokterdpjp_lpk'; ?>',
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

    $('#kodefaskes').select2({
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
        url: '<?php echo base_url().'bpjs/rujukan/ppa_rujukan?kodefaskes='; ?>'+faskes,
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

    $(document).ready(function(){
        $.ajax({
            url: '<?= base_url('bpjs/referensi/ruangrawat') ?>',
            beforeSend: function() {
                $('#ruangrawat').prop('disabled',true);
                $('#ruangrawat').empty().append('<option value="" selected>Sedang Mengambil data..</option>');
            },
            success: function(data) {
                let html = '';
                if(data.metaData.code == '200')
                {
                    data.response.list.map((e)=>{
                        html+=`
                            <option value="${e.kode}">${e.nama}</option>
                        `;
                    })
                    $('#ruangrawat').empty().append(html);
                    return;    
                }
                if(data.metaData.code == '201')
                {
                    $('#ruangrawat').empty().append(`<option value="" selected>${data.metaData.message}</option>`);
                    return;
                }
                $('#ruangrawat').empty().append('<option value="" selected>Gagal Mengambil Data..</option>');
            
            },
            error: function(xhr) { 
                $('#ruangrawat').empty().append('<option selected>Gagal Mengambil Data,Hubungi Tim IT</option>');
            },
            complete: function() {
                $('#ruangrawat').prop('disabled',false);
            },
        });

        $.ajax({
            url: '<?= base_url('bpjs/referensi/kelasrawat') ?>',
            beforeSend: function() {
                $('#kelasrawat').prop('disabled',true);
                $('#kelasrawat').empty().append('<option value="" selected>Sedang Mengambil data..</option>');
            },
            success: function(data) {
                let html = '<option value="">Silahkan Dipilih Kelas Rawat</option>';
                if(data.metaData.code == '200')
                {
                    data.response.list.map((e)=>{
                        html+=`
                            <option value="${e.kode}">${e.nama}</option>
                        `;
                    })
                    $('#kelasrawat').empty().append(html);
                    return;    
                }
                if(data.metaData.code == '201')
                {
                    $('#kelasrawat').empty().append(`<option value="" selected>${data.metaData.message}</option>`);
                    return;
                }
                $('#kelasrawat').empty().append('<option value="" selected>Gagal Mengambil Data..</option>');
            
            },
            error: function(xhr) { 
                $('#kelasrawat').empty().append('<option selected>Gagal Mengambil Data,Hubungi Tim IT</option>');
            },
            complete: function() {
                $('#kelasrawat').prop('disabled',false);
            },
        });

        $.ajax({
            url: '<?= base_url('bpjs/referensi/spesialistik') ?>',
            beforeSend: function() {
                $('#spesialistik').prop('disabled',true);
                $('#spesialistik').empty().append('<option value="" selected>Sedang Mengambil data..</option>');
            },
            success: function(data) {
                let html = '<option value="">Silahkan Dipilih Spesialistik</option>';
                if(data.metaData.code == '200')
                {
                    data.response.list.map((e)=>{
                        html+=`
                            <option value="${e.kode}">${e.nama}</option>
                        `;
                    })
                    $('#spesialistik').empty().append(html);
                    return;    
                }
                if(data.metaData.code == '201')
                {
                    $('#spesialistik').empty().append(`<option value="" selected>${data.metaData.message}</option>`);
                    return;
                }
                $('#spesialistik').empty().append('<option value="" selected>Gagal Mengambil Data..</option>');
            
            },
            error: function(xhr) { 
                $('#spesialistik').empty().append('<option value="" selected>Gagal Mengambil Data,Hubungi Tim IT</option>');
            },
            complete: function() {
                $('#spesialistik').prop('disabled',false);
            },
        });

        $.ajax({
            url: '<?= base_url('bpjs/referensi/carakeluar') ?>',
            beforeSend: function() {
                $('#carakeluar').prop('disabled',true);
                $('#carakeluar').empty().append('<option value="" selected>Sedang Mengambil data..</option>');
            },
            success: function(data) {
                let html = '<option value="">Silahkan Dipilih Cara Keluar..</option>';
                if(data.metaData.code == '200')
                {
                    data.response.list.map((e)=>{
                        html+=`
                            <option value="${e.kode}">${e.nama}</option>
                        `;
                    })
                    $('#carakeluar').empty().append(html);
                    return;    
                }
                if(data.metaData.code == '201')
                {
                    $('#carakeluar').empty().append(`<option value="" selected>${data.metaData.message}</option>`);
                    return;
                }
                $('#carakeluar').empty().append('<option value="" selected>Gagal Mengambil Data..</option>');
            
            },
            error: function(xhr) { 
                $('#carakeluar').empty().append('<option selected>Gagal Mengambil Data,Hubungi Tim IT</option>');
            },
            complete: function() {
                $('#carakeluar').prop('disabled',false);
            },
        });

        $.ajax({
            url: '<?= base_url('bpjs/referensi/pascapulang') ?>',
            beforeSend: function() {
                $('#pascapulang').prop('disabled',true);
                $('#pascapulang').empty().append('<option value="" selected>Sedang Mengambil data..</option>');
            },
            success: function(data) {
                let html = '<option value="">Silahkan Pilih Pasca Pulang</option>';
                if(data.metaData.code == '200')
                {
                    data.response.list.map((e)=>{
                        html+=`
                            <option value="${e.kode}">${e.nama}</option>
                        `;
                    })
                    $('#pascapulang').empty().append(html);
                    return;    
                }
                if(data.metaData.code == '201')
                {
                    $('#pascapulang').empty().append(`<option value="" selected>${data.metaData.message}</option>`);
                    return;
                }
                $('#pascapulang').empty().append('<option value="" selected>Gagal Mengambil Data..</option>');
            
            },
            error: function(xhr) { 
                $('#pascapulang').empty().append('<option selected>Gagal Mengambil Data,Hubungi Tim IT</option>');
            },
            complete: function() {
                $('#pascapulang').prop('disabled',false);
            },
        });

       
        

        
    });
</script>