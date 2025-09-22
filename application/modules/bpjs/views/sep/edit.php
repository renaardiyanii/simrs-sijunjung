<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);
?>
<?php 
if($data->metaData->code != "200" && $data->metaData->message != "Sukses" ){

echo '
<div class="card m-5">
  <div class="card-header">
    Edit SEP
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
    Edit SEP
  </div>
  <div class="card-body">
    <h4><?= $data->response->noSep ?></h4>
    <hr>
    <form id="updatesepform">
    <div class="mb-3 row">
        <input type="hidden" name="noSep" value="<?= $data->response->noSep ?>">
        <input type="hidden" name="klsRawatHak" value="<?= $data->response->klsRawat->klsRawatHak ?>">
        <input type="hidden" name="klsRawatNaik" value="<?= $data->response->klsRawat->klsRawatNaik??'' ?>">
        <input type="hidden" name="pembiayaan" value="<?= $data->response->klsRawat->pembiayaan??'' ?>">
        <input type="hidden" name="penanggungJawab" value="<?= $data->response->klsRawat->penanggungJawab??'' ?>">
        <input type="hidden" name="tujuan" id="tujuan">
        <input type="hidden" name="eksekutif" id="eksekutif" value="<?= $data->response->poliEksekutif??'0' ?>">
        <input type="hidden" name="cob" id="cob" value="<?= $data->response->cob??'0' ?>">
        <input type="hidden" name="katarak" id="katarak" value="<?= $data->response->katarak=="0"?'0':'1' ?>">
        <input type="hidden" name="suplesi" id="suplesi" value="">
        <input type="hidden" name="noSepSuplesi" id="noSepSuplesi" value="">

        <label for="dpjp" class="col-sm-4 col-form-label">DPJP yang melayani</label>
        <div class="col-sm-8">
            <select name="dpjpLayan" id="dpjp" class="form-control">
                <option value="">--Pilih Dpjp--</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="noMr" class="col-sm-4 col-form-label">No. MR</label>
        <div class="col-sm-8">
            <input type="text" name="noMr" id="noMr" class="form-control" value="<?= $data->response->peserta->noMr ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="diagnosa" class="col-sm-4 col-form-label">Diagnosa</label>
        <div class="col-sm-8">
            <select name="diagAwal" id="diagnosa" class="form-control">
                <?php 
                if($data->du):
                ?>
                <option value="<?= $data->du->diagnosa ?>"><?= $data->response->diagnosa ?></option>
                <?php endif; ?>
            </select>
        </div>
    </div>
    <div class="mb-3 row">
        <label for="notelp" class="col-sm-4 col-form-label">No. Telepon</label>
        <div class="col-sm-8">
            <input type="text" name="noTelp" id="notelp" class="form-control" value="<?= $data->local->notelp??'00000000000' ?>">
        </div>
    </div>
    <div class="mb-3 row">
        <label for="catatan" class="col-sm-4 col-form-label">Catatan</label>
        <div class="col-sm-8">
            <input type="text" name="catatan" id="catatan" class="form-control" value="<?= $data->response->catatan ?>" >
        </div>
    </div>
    <div class="mb-3 row">
        <label for="kecelakaan" class="col-sm-4 col-form-label">Status Kecelakaan</label>
        <div class="col-sm-8">
            <select name="lakaLantas" id="kecelakaan" class="form-control" onchange="changekecelakaan(this.value)">
                <option value="0" <?= $data->response->kdStatusKecelakaan=='0'?'selected':"" ?>>Bukan Kecelakaan lalu lintas [BKLL]</option>
                <option value="1" <?= $data->response->kdStatusKecelakaan=='1'?'selected':"" ?>>KLL dan bukan kecelakaan Kerja [BKK]</option>
                <option value="2" <?= $data->response->kdStatusKecelakaan=='2'?'selected':"" ?>>KLL dan KK </option>
                <option value="3" <?= $data->response->kdStatusKecelakaan=='3'?'selected':"" ?>>KK</option>    
            </select>
        </div>
    </div>
    <div class="mb-3 row rowkecelakaan">
        <label for="tglKejadian" class="col-sm-4 col-form-label">Tanggal Kejadian</label>
        <div class="col-sm-8">
            <input type="date" name="tglKejadian" id="tglKejadian" class="form-control" value="<?= $data->response->lokasiKejadian->tglKejadian??'' ?>">
        </div>
    </div>
    <div class="mb-3 row rowkecelakaan">
        <label for="ketKejadian" class="col-sm-4 col-form-label">Keterangan Kejadian</label>
        <div class="col-sm-8">
            <input type="text" name="keterangan" id="ketKejadian" class="form-control"  value="<?= $data->response->lokasiKejadian->ketKejadian??'' ?>">
        </div>
    </div>
    <div class="mb-3 row rowkecelakaan">
        <label for="kdPropinsi" class="col-sm-4 col-form-label">Kode Provinsi</label>
        <div class="col-sm-8">
            <select name="kdPropinsi" id="kdPropinsi" class="form-control">
                <option value="">--Pilih kdPropinsi--</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row rowkecelakaan">
        <label for="kdKabupaten" class="col-sm-4 col-form-label">Kode Kabupaten</label>
        <div class="col-sm-8">
            <select name="kdKabupaten" id="kdKabupaten" class="form-control">
                <option value="">--Pilih kdKabupaten--</option>
            </select>
        </div>
    </div>
    <div class="mb-3 row rowkecelakaan">
        <label for="kdKecamatan" class="col-sm-4 col-form-label">Kode Kecamatan</label>
        <div class="col-sm-8">
            <select name="kdKecamatan" id="kdKecamatan" class="form-control">
                <option value="">--Pilih kdKecamatan--</option>
            </select>
        </div>
    </div>
    </form>
    <button id="btnsubmit" class="btn btn-primary" onclick="updatesep()">Simpan</button>
  </div>
</div>


<script>
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

    $(document).ready(function(){
        
        $.ajax({
			type: "GET",
			url: '<?= base_url('bpjs/referensi/get_bpjs_by_id_poli/'.$data->du->id_poli) ?>',
			success: function(success){
				$("#tujuan").val(success.poli_bpjs);
				return;
			},
			error:function(error){
				console.log(error);
                return;
			},
		});

        if('<?= $data->response->kdStatusKecelakaan ?>' !='0'){
            $(".rowkecelakaan").show();
        }else{
            $(".rowkecelakaan").hide();
        }
        cariDokterDpjp('<?= $data->response->poli ?>','<?= $data->response->tglSep ?>');
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

    function changekecelakaan(v)
    {
        if(v !='0'){
            $('.rowkecelakaan').show();
        }else{
            $('.rowkecelakaan').hide();
        }
    }
    

    function cariDokterDpjp(poli,tglpelayanan,append=true)
    {
        var opsi = poli == "INSTALASI GAWAT DARURAT"?"1":"2";
        $.ajax({
            type: "GET",
            url: '<?= base_url('bpjs/referensi/dokter_dpjp?pelayanan=') ?>'+opsi+'&tglpelayanan=' + tglpelayanan+'&namaspesialis='+poli,
            success: function(success){
                if(success.response.list === undefined){
                    $('#dpjp').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                    return;
                }
                var html = ``;
                success.response.list.map((val)=>{
                if(val.kode == '<?= $data->response->dpjp->kdDPJP ?>'){
                    html +=`
                        <option value="${val.kode}" selected>${val.nama}</option>
                    `;
                }else{
                    html +=`
                        <option value="${val.kode}">${val.nama}</option>
                    `;
                }
                })
                if(append)
                {
                    $('#dpjp').append(html);
                    return;
                }
                $('#dpjp').html(html);
                
            },
            error:function(error){
                $('#dpjp').attr('placeholder','Gagal Mengambil Data , silahkan masukan kode secara manual');
                return;
            }
        });
    }

    function updatesep()
    {
        let data = $('#updatesepform').serialize();
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
</script>