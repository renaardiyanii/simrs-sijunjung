
<?php
// var_dump($pasien_iri[0]);die();
// var_dump($data_pasien[0]);die();
$klsiri = '3';
// switch($pasien_iri[0]->klsiri){
//     case 'III':
//         $klsiri = '3';
//         break;
//     case 'II':
//         $klsiri = '2';
//         break;

//     case 'I':
//         $klsiri = '1';
//         break;
//     default:
//         $klsiri = '3';
// }
$no_rujukan = '';
$id_poli = isset($data_pasien[0]['id_poli'])?$data_pasien[0]['id_poli']:null;
// var_dump($data_pasien[0]);die();
if($id_poli){
    if($data_pasien[0]['id_poli'] == 'BA00')
    {
        $no_rujukan = $data_pasien[0]['no_sep'];
    }else{
        $no_rujukan = substr_replace($data_pasien[0]['no_rujukan'],"",-1).substr(str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTUVWXYZ", 1)), 0, 1);
    }
}


?>

<form id="formInsertPenanggungJawab" >
    <input type="hidden" name="no_ipd" value="<?= $pasien_iri[0]->no_ipd??'' ?>">
    <input type="hidden" name="carabayar" value="<?= $pasien_iri[0]->carabayar??'' ?>">
    <input type="hidden" name="no_medrec" value="<?php echo $irna_reservasi[0]['no_medrec']; ?>">
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">No. Kartu BPJS</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?php echo $data_pasien[0]['no_kartu']; ?>" >
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button" id="btn-cek-kartu"><i class="fa fa-eye"></i> Data Peserta</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">Tgl . SEP</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="date" class="form-control" id="tgl_sep" value="<?php echo date('Y-m-d') ?>" >
                    </div>
                </div>
            </div>

            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">Dijamin Oleh</label>
                <div class="col-sm-9">
                    <input type="hidden" name="id_kontraktor_bpjs">
                    <select class="form-control js-example-basic-single" style="width:100%" name="nmkontraktorbpjs" id="nmkontraktorbpjs">
                        <option value="">-- Pilih Penjamin -- </option>
                        <?php
                        foreach ($kontraktorbpjs as $r) { ?>
                        <option value="<?php echo $r['id_kontraktor'] ;?>"><?php echo $r['nmkontraktor'] ;?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 control-label col-form-label">No. Telp</label>
                <div class="col-sm-9">
                    <div class="">
                        <input type="text" class="form-control" id="no_telp_bpjs" value="<?php echo $data_pasien[0]['no_hp']; ?>">

                    </div>
                </div>
            </div>
            <!-- <div class="form-group row" style="display:none;">
                <label class="col-sm-3 col-form-label">Asal Rujukan</label>
                <div class="col-sm-9">
                    <select id="asal_rujukan" class="form-control" style="width: 100%" name="asal_rujukan" disabled>
                        <option value="1">Faskes Tingkat 1</option>
                        <option value="2" selected>Faskes Tingkat 2</option>
                    </select>
                </div>
            </div>
            <div class="form-group row" style="display:none;">
                <label class="col-sm-3 col-form-label">PPK Asal Rujukan</label>
                <div class="col-sm-9">
                    <select class="form-control" style="width:100%" name="ppk_asal_rujukan" id="ppk_asal_rujukan" disabled>
                        <option value="1671342" selected>RS. Musi Medika Cendikia</option>
                    </select>
                </div>
            </div> -->
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 control-label col-form-label">Tgl. Rujukan</label>
                <div class="col-sm-9">
                    <div class="">
                        <input type="date" class="form-control date_picker" id="tgl_rujukan" name="tgl_rujukan" value="<?php echo date('Y-m-d'); ?>">

                    </div>
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">No. Rujukan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="no_rujukan" value="<?php echo $no_rujukan; ?>" id="no_rujukan">
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">No. SEP</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="no_sep" value="" id="no_sep">
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">No. SPRI *</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="nosurat_skdp_sep" id="nosurat_skdp_sep">
                        <button type="button" class="btn btn-primary" onclick="bikinspri()">Buat SPRI</button>
                    </div>
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">DPJP Pemberi SPRI *</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <select id="dpjp_skdp_sep" class="form-control select2" style="width: 100%" name="dpjp_skdp_sep" >
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group form_perusahaan row">
                <label class="col-sm-3 col-form-label">Kontraktor</label>
                <div class="col-sm-9">
                <input type="hidden" name="id_kontraktor_bpjs">
                    <select class="form-control js-example-basic-single" style="width:100%" name="nmkontraktorbpjs" id="nmkontraktorbpjs">
                        <option value="">Pilih Kontraktor</option>
                        <?php
                        foreach ($kontraktor as $r) { ?>
                        <option value="<?php echo $r['id_kontraktor'] ;?>"><?php echo $r['nmkontraktor'] ;?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Catatan SEP</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="catatan" id="catatan" rows="5"><?php echo isset($data_pasien[0]['catatan'])?$data_pasien[0]['catatan']:''; ?></textarea>
                </div>
            </div>
            <div class="form-group form_perusahaan row">
                <label class="col-sm-3 col-form-label">P/I/S/A</label>
                <div class="col-sm-9">
                    <select class="form-control input-sm js-example-basic-single" name="ketpembayarri">
                        <option value="Ybs">Ybs</option>
                        <option value="Istri">Istri</option>
                        <option value="Suami">Suami</option>
                        <option value="Anak">Anak</option>
                    </select>
                </div>
            </div>
            <div class="form-group form_perusahaan row">
                <label class="col-sm-3 col-form-label">Nama Peserta</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="nmpembayatri">
                </div>
            </div>
            <div class="form-group form_perusahaan row">
                <label class="col-sm-3 col-form-label">Golongan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="golpembayarri">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="nmpjawabri"  required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                        <select name="jenkel" id="jenkel" class="form-control">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L">Laki - laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="alamatpjawabri"  >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No.Telp / HP</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="notlppjawab" id="notlppjawab" >
                        <!-- <input type="hidden" class="form-control input-sm" name="spri" value="<?= ($irna_reservasi[0]['spri'])??$irna_reservasi[0]['spri']; ?>"> -->
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kartu Identitas</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="kartuidpjawab">
                                <option value="KTP">KTP</option>
                                <option value="SIM">SIM</option>
                                <option value="SIM">PASPOR</option>
                                <!-- <option <div class="p-20">value="PASPOR"></option> -->
                                <option value="KTM">KTM</option>
                                <option value="NIK">NIK</option>
                            </select>
                        </div>
                        <div class="col-sm-5"><input type="text" class="form-control" name="noidpjawab" >
                        </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Hub.Keluarga</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="hubpjawabri">
                            <option value="Suami">Suami</option>
                            <option value="Istri">Istri</option>
                            <option value="Ayah">Ayah</option>
                            <option value="Ibu">Ibu</option>
                            <option value="Saudara">Saudara</option>
                            <option value="Anak">Anak</option>
                        </select>
                    </div>
                </div>



            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama 1 :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="namaaksespjawabri1" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama 2 :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="namaaksespjawabri2" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama 3 :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="namaaksespjawabri3" >
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Kelas Rawat Hak :</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" id="klsRawatHak" value="<?= $klsiri ?>"  >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Kelas Rawat Naik :</label>
                <div class="col-sm-9">
                    <select class="form-control input-sm" id="klsrawatnaik" >
                        <option value="">Silahkan Pilih Jika Naik kelas</option>
                        <option value="1">VVIP</option>
                        <option value="2">VIP</option>
                        <option value="3">Kelas 1</option>
                        <option value="4">Kelas 2</option>
                        <option value="5">Kelas 3</option>
                        <option value="6">ICCU</option>
                        <option value="7">ICU</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">pembiayaan :</label>
                <div class="col-sm-9">
                    <select class="form-control input-sm" id="pembiayaan" onchange="changePenanggungJawab(this.value)" >
                        <option value="">Silahkan Pilih Jika Naik kelas</option>
                        <option value="1-Pribadi">Pribadi</option>
                        <option value="2-Pemberi Kerja">Pemberi Kerja</option>
                        <option value="3-Asuransi Kesehatan Tambahan">Asuransi Kesehatan Tambahan.</option>
                    </select>
                    <input type="hidden" class="form-control input-sm" id="penanggungjawab" >
                </div>
            </div>
            <hr>
        </div>
    </div>
    <button type="button" class="btn btn-info" onclick="buatsep()">Buat SEP</button>
    <button type="submit" class="btn btn-primary">Simpan</button>

</form>




<!-- modal spri -->
<div class="modal fade modal_suratkontrol" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold">PEMBUATAN SPRI</h4>
				<table class="table-xs table-hover" width="100%" border="1" id="listsep">
					<tr>
						<td>No.</td>
						<td>No SEP</td>
						<td>Tujuan Poli</td>
						<td>Aksi</td>
					</tr>
				</table>
				<br>
				<div class="formbuatsurkon">
					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">No.SEP</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="no_sep_surat_bikin">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Tgl Rencana Ranap</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="tgl_surat_bikin" onchange="ambilpolikontrol(this.value)">

						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Poli </label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="poli_suratkontrol_bikin" class="form-control select2" style="width: 100%"  onchange="ambildoktersuratkontrol(this.value)">
									<option value="">-- Pilih Poliklinik --</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Dokter SPRI</label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="dpjp_suratkontrol_bikin" class="form-control select2" style="width: 100%" name="dpjp_suratkontrol_bikin" >
									<option value="">-- Pilih Dokter --</option>
								</select>
							</div>
						</div>
					</div>


				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary waves-effect text-left" onclick="buatsuratkontrol()" >Buat SPRI</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>

<!-- end spri -->

<script>
function buatsuratkontrol()
    {
        $.ajax({
            method:'POST',
            type:'JSON',
            data:{
                'noKartu':'<?=  $data_pasien[0]['no_kartu']; ?>',
                'noSepAsal':$('#no_sep_surat_bikin').val(),
                'kodeDokter':$('#dpjp_suratkontrol_bikin').val().split('-')[0],
                'poliKontrol':$('#poli_suratkontrol_bikin').val(),
                'tglRencanaKontrol':$('#tgl_surat_bikin').val(),
                'user':'ADMIN',
                'nama_dokter':$('#dpjp_suratkontrol_bikin').val().split('-')[1]
            },
            url: '<?= base_url('bpjs/rencanakontrol/insert_spri') ?>',
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    $('#nosurat_skdp_sep').val(data.response.noSPRI);
                    $('#dpjp_skdp_sep').html(`<option value="${$('#dpjp_suratkontrol_bikin').val().split('-')[0]}" selected>${$('#dpjp_suratkontrol_bikin').val().split('-')[1]}</option>`)
                    $('.modal_suratkontrol').modal('hide');
                }else{
                    swal("Peringatan!",data.metaData.message, "warning");

                }
            },
            error: function(xhr) {
                swal("Peringatan!",'Hubungi Admin IT', "warning");

            },
            complete: function() {

            }
        });
    }

function ambildoktersuratkontrol(kodepoli)
    {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_dokter') ?>'+`?jnskontrol=1&poli=${kodepoli}&tglrencanakontrol=${$('#tgl_surat_bikin').val()}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`<option value="${e.kodeDokter}-${e.namaDokter}">${e.namaDokter}</option>`;
                    })
                    $('#dpjp_suratkontrol_bikin').empty();
                    $('#dpjp_suratkontrol_bikin').append('<option value="">Silahkan Pilih Dokter</option>');
                    $('#dpjp_suratkontrol_bikin').append(html);
                }
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

function ambilpolikontrol(tgl)
    {
        $.ajax({
            url: '<?= base_url('bpjs/rencanakontrol/data_poli') ?>'+`?jnskontrol=1&nomor=<?php echo $data_pasien[0]['no_kartu']; ?>&tglrencanakontrol=${tgl}`,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                if(data.metaData.code === '200'){
                    data.response.list.map((e)=>{
                        html+=`<option value="${e.kodePoli}">${e.namaPoli}</option>`;
                    })
                    $('#poli_suratkontrol_bikin').empty();
                    $('#poli_suratkontrol_bikin').append('<option value="">Silahkan Pilih Poliklinik..</option>');
                    $('#poli_suratkontrol_bikin').append(html);
                }
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

function bikinspri()
{
    $('.modal_suratkontrol').modal('show');
}

function ambilriwayatsep(nokartu)
    {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/bpjs_sep_nokartu/') ?>'+'/'+nokartu,
            beforeSend: function() {

            },
            success: function(data) {
                let html = '';
                index = 1;
                if(data.length > 0){
                    data.map((e)=>{
                        html+=`
                        <tr>
                            <td>${index}</td>
                            <td>${e.no_sep}</td>
                            <td>${e.politujuan}</td>
                            <td>
                            <button class="btn btn-xs btn-primary" onclick="parsingsepsuratkontrol('${e.no_sep}')">Gunakan SEP</button>
                            </td>
                        </tr>
                        `;
                        index++;
                    })
                    $("#listsep").append(html);
                }
            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

    function parsingsepsuratkontrol(no_sep)
    {
        $.ajax({
            url: '<?= base_url('irj/rjcregistrasi/cek_surat_kontrol_exist') ?>'+'/'+no_sep,
            beforeSend: function() {

            },
            success: function(data) {
                if(data){
                    $('#nosurat_skdp_sep').val(data.surat_kontrol);
                    $('#dpjp_skdp_sep').html(`<option value="${data.dokter_bpjs}" selected>${data.nama_dokter_bpjs}</option>`)
                    // $('#dokter_bpjs').html(`<option value="${data.dokter_bpjs}" selected>${data.nama_dokter_bpjs}</option>`)
                    // $('#dokter_bpjs').attr("style", "pointer-events: none;width:100%;");
                    // $('#dokter_bpjs').attr("tabindex", "-1");
                    $('.modal_suratkontrol').modal('hide');
                }else{
                    $('#no_sep_surat_bikin').val(no_sep);
                }

            },
            error: function(xhr) {
            },
            complete: function() {

            }
        });
    }

$(document).ready(function() {
    ambilriwayatsep('<?php echo $data_pasien[0]['no_kartu']; ?>');
    $('#formInsertPenanggungJawab').on('submit', function(e){
        e.preventDefault();
        // document.getElementById("btn-form-fisik-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({
            url:"<?php echo base_url('iri/ricpendaftaran/update_pendaftaran_pasien')?>",
            type: "POST",
            data: $('#formInsertPenanggungJawab').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.code ===200)
                {
                    new swal({
                            title: "Selesai",
                            text: "Data berhasil disimpan",
                            type: "success",
                            showCancelButton: false,
                            closeOnConfirm: false,
                            showLoaderOnConfirm: true,
                                willClose: () => {
                                    window.location.reload();
                                }
                        },
                        function () {
                            window.location.reload();
                        });
                }

                // document.getElementById("submit").disabled = true;
                // document.getElementById("submit").innerHTML = 'Mohon Tunggu ...';

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                // window.location.reload();
                // alert(errorThrown);
            }
        });
    });

} );

function changePenanggungJawab(val)
{
    $('#penanggungjawab').val(val);
}


function buatsep(){
    $.ajax({
        url: `<?= base_url('bpjs/sep/insert_sep') ?>/`+'<?= $pasien_iri[0]->no_ipd??'' ?>',
        type: 'JSON',
        method:'POST',
        data:{
            'no_kartu':'<?php echo $data_pasien[0]['no_kartu']; ?>',
            'tgl_sep':$('#tgl_sep').val(),
            'kelasrawat':$('#klsRawatHak').val(),
            'klsrawatnaik':$('#klsrawatnaik').val(),
            'pembiayaan':$('#pembiayaan').val().split('-')[0],
            'penanggungjawab':$('#penanggungjawab').val().split('-')[1],
            'no_medrec':'<?= $data_pasien[0]['no_cm'] ?>',
            'asalrujukan': '',
            'tglrujukan':$('#tgl_rujukan').val(),
            'norujukan':$('#no_rujukan').val(),
            'ppkrujukan':'0311R001',
            'catatan':$('#catatan').val(),
            'diagawal':'<?= isset($data_pasien[0]['diagnosa'])?$data_pasien[0]['diagnosa']:'' ?>',
            'politujuan':'',
            'tujuankunj':'0',
            'flagprocedure':'',
            'kdpenunjang':'',
            'assesmentpel':'',
            'nosurat':$('#nosurat_skdp_sep').val(),
            'dpjpsurat':$('#dpjp_skdp_sep').val(),
            'dpjplayan':'',
            'notelp':$('#no_telp_bpjs').val(),
            'user':'<?= 'ADMIN' ?>',
        },
        beforeSend: function() {

        },
        success: function(data) {
            if(data.metaData.code === '200'){
                $('#no_sep').val(data.response.sep.noSep);
                window.open('<?php echo base_url().'bpjs/sep/cetakan_sep/'; ?>'+'<?= $pasien_iri[0]->no_ipd??'' ?>', '_blank');
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