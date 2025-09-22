<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);
?>
<div class="card m-5">
    <div class="card-header">
        History SEP
    </div>
    <div class="card-body">
    <form>
        <div class="row mx-2 my-4">
            <!-- Tanggal Surat Kontrol -->
            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Tanggal Mulai</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="date" class="form-control" name="tgl_mulai" required value="<?= $this->input->get('tgl_mulai')?$this->input->get('tgl_mulai'):'' ?>" >
                    </div>	
                </div>								
            </div>

            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Tanggal Akhir</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="date" class="form-control" name="tgl_akhir" required value="<?= $this->input->get('tgl_akhir')?$this->input->get('tgl_akhir'):'' ?>" >
                    </div>	
                </div>								
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Nomor Kartu</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="no_kartu" required value="<?= $nokartu ?>" >
                    </div>	
                </div>								
            </div>

            
            <div class="col-md-5">
                <div class="form-actions">
                    <button type="submit" class="btn waves-effect waves-light btn-info" >
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

<?php
if(isset($monitoring->response->histori)):
    // var_dump($monitoring->response);die();
?>
<div class="card card-outline-info p-4">
    <h4>Hasil Pencarian</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
    
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Diagnosa</th>
                    <th>Kelas Rawat</th>
                    <th>Jenis Pelayanan</th>
                    <th>Nama Peserta</th>
                    <th>Nomor Kartu</th>
                    <th>Nomor SEP</th>
                    <th>Nomor Rujukan</th>
                    <th>Poli</th>
                    <th>PPK Pelayanan</th>
                    <th>Tgl Pulang SEP</th>
                    <th>Tgl SEP</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($monitoring->response->histori)): 
                    $i=1;
                    foreach($monitoring->response->histori as $val):
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $val->diagnosa ?></td>
                        <td><?= $val->kelasRawat ?></td>
                        <td><?= $val->jnsPelayanan ?></td>
                        <td><?= $val->namaPeserta ?></td>
                        <td><?= $val->noKartu ?></td>
                        <td><?= $val->noSep ?></td>
                        <td><?= $val->noRujukan ?></td>
                        <td><?= $val->poli ?></td>
                        <td><?= $val->ppkPelayanan ?></td>
                        <td><?= $val->tglPlgSep ?></td>
                        <td><?= $val->tglSep ?></td>
                    </tr>
                <?php 
                    $i++;
                    endforeach;
                    else:
                ?>
                    <tr>
                        <td rowspan="12"><?= $monitoring->metaData->message ?></td>
                    </tr>
                <?php
                endif; 
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>


<script>

    $('#datepicker').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        orientation: 'bottom' 
    });

</script>


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
        $.ajax({
            type: "GET",
            url: '<?= base_url('bpjs/referensi/dokter_dpjp?pelayanan=2&tglpelayanan=') ?>' + tglpelayanan+'&namaspesialis='+poli,
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