<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);

    function bikin($nama){
        echo '<label for="'.$nama.'" class="col col-form-label">'.$nama.' :</label>
        <div class="col">
            <input type="text"  class="form-control" id="'.$nama.'" readonly>
        </div>';
    }

    function bikin2($nama,$value='',$label='')
    {
        echo '
        <div class="row mb-2">
                    <label for="'.$nama.'up" class="col col-form-label">'.($label==''?$nama:$label).' :</label>
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


<div class="card m-5" id="hasilpengajuan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Pembuatan Rujukan Balik ( PRB )
        </div>
    </div>
    <div class="card-body">
        <form id="buatPrb">
            <?= bikin2('noSep') ?>
            <?= bikin2('noKartu') ?>
            <?= bikin2('alamat') ?>
            <?= bikin2('email') ?>
            <?= selectbikin('programPRB') ?>
            <?= selectbikin('dokterSpesialis') ?>
            <?= selectbikin('dokter','<option value="">Silahkan Dipilih Dokter</option>') ?>
            <?= bikin2('keterangan') ?>
            <?= bikin2('saran') ?>
            <?= bikin2('user',$user) ?>
            <hr>
                <?= selectbikin('obat') ?>
                <?= bikin2('signa1') ?>
                <?= bikin2('signa2') ?>
                <?= bikin2('jmlObat') ?>
                <button type="button" class="btn btn-info" onclick="tambahObat()">Tambah Obat</button>
            <hr>
            <div>
                List Obat : <br>
                <div  id="listObat"></div>
            </div>
            <hr>

            <button type="button" class="btn btn-primary" id="submitPrb">Simpan</button>
        </form>

    </div>
</div>


<div class="card m-5" id="hasilpengajuan">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            Hapus Rujukan Balik ( PRB )
        </div>
    </div>
    <div class="card-body">
        <form id="buatPrb">
            <?= bikin2('noSrbDelete','','No. SRB') ?>
            <?= bikin2('noSepDelete','','No. SEP') ?>
            <?= bikin2('userDelete',$user,'User') ?>
            <button type="button" class="btn btn-danger" id="hapusPrb">Hapus</button>
        </form>

    </div>
</div>


<script>

    $('#hapusPrb').click(function(){
        $.ajax({
            type: 'POST',
            url: '<?= base_url('bpjs/prb/delete') ?>',
            data: {
                'noSep':$("#noSepDeleteup").val(),
                'noSrb':$("#noSrbDeleteup").val(),
                'user':$("#userDeleteup").val(),
            },
            beforeSend: function() {
                $('#hapusPrb').attr('disabled',true);
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
                $('#hapusPrb').attr('disabled',false);                
            },
            dataType: 'json'
        });
    })

    let obat = [];

    $('#submitPrb').click(function(){
        $.ajax({
            type: 'POST',
            url: '<?= base_url('bpjs/prb/insert') ?>',
            data: {
                'noSep':$("#noSepup").val(),
                'noKartu':$("#noKartuup").val(),
                'alamat':$("#alamatup").val(),
                'email':$("#emailup").val(),
                'programPRB':$("#programPRBup").val(),
                'kodeDPJP':$("#dokterup").val(),
                'keterangan':$("#keteranganup").val(),
                'saran':$("#saranup").val(),
                'user':$("#userup").val(),
                'obat':obat,
            },
            beforeSend: function() {
                $('#submitPrb').attr('disabled',true);
            },
            success: function(data) {
                if(data.metaData.code == '200')
                {
                    window.open('<?php echo base_url().'bpjs/prb/cetak_prb/'; ?>'+`${data.response.noSRB}/${$("#noSepup").val()}`, '_blank');
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
                $('#submitPrb').attr('disabled',false);                
            },
            dataType: 'json'
        });
    })

    function tambahObat()
    {
        obat.push({
            kdObat:$('#obatup').val(),
            signa1:$('#signa1up').val(),
            signa2:$('#signa2up').val(),
            jmlObat:$('#jmlObatup').val(),
        });
        $('#listObat').append(
            `
            <p>Kode Obat : ${$('#obatup').val()} (${$('#signa1up').val()} - ${$('#signa2up').val()}), Qty : ${$('#jmlObatup').val()} </p>
            `
        );
        $('#obatup').empty();
        $('#signa1up').val('');
        $('#signa2up').val('');
        $('#jmlObatup').val('');
    }

    $('#obatup').select2({
        placeholder: 'Ketik kode atau nama Obat',
        minimumInputLength: 3,
        language: {
        inputTooShort: function(args) {
            return "Ketik kode atau nama Obat";
        },
        noResults: function() {
            return "Obat tidak ditemukan.";
        },
        searching: function() {
            return "Sedang Dicari.....";
        }
        },
        ajax: {
        type: 'GET',
        url: '<?php echo base_url().'/bpjs/referensi/obatprb'; ?>',
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

    

    function callAjax(url,success,btnTrigger=''){
        
        $.ajax({
            url: url,
            beforeSend: function() {
                btnTrigger != ''?$('#'+btnTrigger).attr('disabled',true):'';
            },
            success: success,
            error: function(xhr) { 
                new swal("Peringatan!",'Silahkan Kontak Admin IT', "warning");
            },
            complete: function() {
                btnTrigger != ''?$('#'+btnTrigger).attr('disabled',false):'';
            },
        });
    }
   
    $(document).ready(function(){
        
        // program prb
        callAjax('<?= base_url('bpjs/referensi/diagnosaprb') ?>',function(data){
            let html = '<option value="">Silahkan Pilih Progran PRB</option>';
            if(data.metaData.code == '200'){
                data.response.list.map((e)=>{
                    html+= `
                        <option value="${e.kode}">${e.nama}</option>
                    `;
                })
                $('#programPRBup').empty().append(html);
            }
        },'programPrbup')
        
    });


    
    $('#dokterSpesialisup').select2({
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

    $('#dokterSpesialisup').change(function(){
         // Dokter DPJP
         callAjax('<?= base_url('bpjs/referensi/dokter_dpjp?pelayanan=2&tglpelayanan='.date('Y-m-d')) ?>'+'&spesialis='+this.value,function(data){
                let html = '<option value="">Silahkan Pilih Dokter</option>';
                if(data.metaData.code == '200'){
                    data.response.list.map((e)=>{
                        html+= `
                            <option value="${e.kode}">${e.nama}</option>
                        `;
                    })
                    $('#dokterup').empty().append(html);
                }
            },'dokterup')
    })

    $("#programPRBup").select2();
    $("#dokterup").select2();
    
    
</script>
