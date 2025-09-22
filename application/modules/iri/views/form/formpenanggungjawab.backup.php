
<?php 
// var_dump($pasien_iri[0]->nmpjawabri);die();
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
                <label class="col-sm-3 col-form-label">Asal Rujukan</label>
                <div class="col-sm-9">
                    <select id="asal_rujukan" class="form-control" style="width: 100%" name="asal_rujukan" disabled>
                        <option value="1">Faskes Tingkat 1</option>
                        <option value="2" selected>Faskes Tingkat 2</option>
                    </select>
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">PPK Asal Rujukan</label>
                <div class="col-sm-9">
                    <select class="form-control" style="width:100%" name="ppk_asal_rujukan" id="ppk_asal_rujukan" disabled>
                        <option value="1671342" selected>RS. Musi Medika Cendikia</option>
                    </select>
                </div>
            </div>
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
                    <input type="text" class="form-control" name="no_rujukan" value="<?php echo $data_pasien[0]['no_rujukan']; ?>" id="no_rujukan">
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
                    <input type="text" class="form-control" name="nosurat_skdp_sep" value="<?= ($irna_reservasi[0]['spri'])??$irna_reservasi[0]['spri']; ?>">
                </div>
            </div>
            <div class="form-group form_bpjs row">
                <label class="col-sm-3 col-form-label">DPJP Pemberi SPRI *</label>
                <div class="col-sm-9">
                    <div class="input-group">
                        <input type="text" class="form-control" name="dpjp_skdp_sep" id="dpjp_skdp_sep">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button" id="btn-cari-dpjp"><i class="fa fa-search"></i> Cari DPJP</button>
                        </span>
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
                    <textarea class="form-control" name="catatan" id="catatan" rows="5"><?php echo $data_pasien[0]['catatan']; ?></textarea>
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
                        <input type="text" class="form-control input-sm" name="notlppjawab" >
                        <input type="hidden" class="form-control input-sm" name="spri" value="<?= ($irna_reservasi[0]['spri'])??$irna_reservasi[0]['spri']; ?>">
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
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>

</form>

<script>

$(document).ready(function() {
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
</script>