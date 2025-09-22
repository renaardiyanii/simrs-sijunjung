<?php $this->load->view("layout/header_left"); ?>
<?php $this->load->view('script_biodata'); ?>
<?php $this->load->view('script_daftarulang'); ?>
<?php $this->load->view('modal'); ?>
<style type="text/css">
	.canvas{
		border:1px solid #ccc;
		border-radius:10px;
	}
	.table-wrapper-scroll-y {
		display: block;
		max-height: 350px;
		overflow-y: auto;
		-ms-overflow-style: -ms-autohiding-scrollbar;
	}
	input:focus::-webkit-input-placeholder { color:transparent; }
	input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
	input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
	input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
	::-webkit-input-placeholder {
   		font-style: italic;
	}
	:-moz-placeholder {
	   font-style: italic;
	}
	::-moz-placeholder {
	   font-style: italic;
	}
	:-ms-input-placeholder {
	   font-style: italic;
	}
	.demo-radio-button label{
		min-width:120px;
	}
	.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
	    border: 1px solid #dad55e;
	    background: #fffa90;
	    color: #777620;
	    font-weight: normal;
	}
	.ui-widget-content {
	  	font-size: 15px;
	}
	.ui-widget-content .ui-state-active {
	  	font-size: 15px;
	}
	.ui-autocomplete-loading {
		background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
	}
	.ui-autocomplete {
		max-height: 270px; overflow-y: scroll; overflow-x: scroll;
	}
</style>
<script>
     $(function() {
    $('#load_wilayahs').select2({
            placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
            ajax: {
                url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah_baru'); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    console.log(data);
                    var results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
                            text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
                        });
                    });
                    return {
                        results: results
                    };
                },
                cache: true
            }
        });
    });
</script>
<?php echo $this->session->flashdata('notification');?>
<?php echo $this->session->flashdata('success_msg'); ?>
<div class="card">
    <div class="card-block p-b-0">
        <ul class="nav nav-tabs customtab" role="tablist">
			<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#biodata" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">BIODATA</span></a> </li>
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#daftar_ulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">DAFTAR ULANG PASIEN IRJ</span></a> </li>
		</ul>
        <div class="tab-content">
			<div id="biodata" class="tab-pane" role="tabpanel">
                <div class="col-lg-10" style="margin: 0 auto;">
                    <br>
                    <br>
                    <?php
                            $foto="unknown.png";
                    ?>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                        </div>
                        <div class="col-sm-12 ">
                            <?php echo form_open_multipart('irj/rjcregistrasi/cetak_kartu_pasien');?>
                                <input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
                                <input type="hidden" class="form-control" name="cetak_kartu" id="cetak_kartu">
                                <button onclick="cetakkartupasien()" class="btn waves-effect waves-light btn-primary"><i class="fa fa-print"></i> Cetak Kartu Pasien</button>
                                <button onclick="cetakidentitaspasien()" class="btn waves-effect waves-light btn-info"><i class="fa fa-print"></i> Cetak Identitas</button>
                             <?php echo form_close();?>
                        </div>
                    </div>
                    <br>
                    <br>
                    <form method="POST"  id="form_biodata" class="form-horizontal">
                        <input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_cm" readonly>
                        <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="xcreate">
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="no_cm">No RM *</p>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="cm_baru" id="cm_baru" readonly>
                            </div>
                            <div class="col-sm-4">
                                <input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="cm_baru" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="tgl_daftar">Tanggal Daftar *</p>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control"  name="tgl_daftar" id="tgl_daftar_pasien" readonly>
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase()" id="nama_pasien" name="nama" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
                            <div class="col-sm-8">
                                <div class="demo-radio-button">
                                    <input name="sex" type="radio" id="laki_laki" class="with-gap" value="L" />
                                    <label for="laki_laki">Laki-Laki</label>
                                    <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" />
                                    <label for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label">Pilih Identitas *</p>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                        <input name="jenis_identitas" type="radio"  id="KTP" class="with-gap" value="KTP" />
                                        <label for="KTP" >KTP</label>
                                        <input name="jenis_identitas" type="radio" id="SIM" class="with-gap" value="SIM" />
                                        <label for="SIM" style="margin-left:30px">SIM</label>
                                        <input name="jenis_identitas" type="radio" id="PASPOR" class="with-gap" value="PASPOR" />
                                        <label for="PASPOR" style="margin-left:30px">PASPOR</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" >No. Identitas *</p>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="no_identitas"  id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)">
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-info btn-block" type="button" onclick="cekbpjs_nik()" id="btn_cek_nik">Cek Peserta BPJS</button>
                            </div>
                        </div>
                        <div class="form-group row" id="duplikat_id">
                            <p class="col-sm-3 form-control-label"></p>
                            <div class="col-sm-8">
                                <p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
                            <div class="col-sm-5">
                                <input type="text"  class="form-control"  name="no_kartu" id="no_kartu_bpjs" >
                            </div>
                            <div class="col-sm-3">
                                <button id="cekbtnbpjsbiodata" class="btn btn-info btn-block" type="button" onclick="cekbpjs_nokartu()">Cek Peserta BPJS</button>
                            </div>
                        </div>
                        <div class="form-group row" id="duplikat_kartu">
                            <p class="col-sm-3 form-control-label"></p>
                            <div class="col-sm-8">
                                <p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
                            </div>
                        </div>

                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir *</p>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase()"  name="tmpt_lahir" id="tmpt_lahirval">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" id="tgl_lahir">Tanggal Lahir *</label>
                            <div class="col-sm-8">
                                <input type="date" class="form-control" placeholder="" id="tgl_lahir_pasien" name="tgl_lahir">
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="agama">Agama *</p>
                            <div class="col-sm-8">
                            <div class="form-inline">
                                <input name="agama" type="radio"  id="ISLAM"  class="with-gap" value="ISLAM" />
                                <label for="ISLAM">Islam</label>
                                <input name="agama" type="radio"  id="KATHOLIK"  class="with-gap" value="KATHOLIK" />
                                <label for="KATHOLIK" style="margin-left:10px;" >Katholik</label>
                                <input name="agama" type="radio"  id="KRISTEN"  class="with-gap" value="KRISTEN" />
                                <label for="KRISTEN" style="margin-left:10px;">Kristen</label>
                                <input name="agama" type="radio"  id="BUDHA"  class="with-gap" value="BUDHA" />
                                <label for="BUDHA" style="margin-left:10px;">Budha</label>
                                <input name="agama" type="radio"  id="HINDU"  class="with-gap" value="HINDU" />
                                <label for="HINDU" style="margin-left:10px;">Hindu</label>
                            </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="status">Status </p>
                            <div class="col-sm-8">
                                <div class="demo-radio-button">
                                    <input name="status" type="radio" id="B" class="with-gap" value="B" />
                                    <label for="B">Belum Menikah</label>
                                    <input name="status" type="radio" id="K" class="with-gap" value="K"  />
                                    <label for="K">Sudah Menikah</label>
                                    <input name="status" type="radio" id="C" class="with-gap" value="C"  />
                                    <label for="C">Cerai</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    <input name="goldarah" type="radio"  id="A+"  class="with-gap" value="A+" />
                                    <label for="A+">A+</label>
                                    <input name="goldarah" type="radio"  id="A-"  class="with-gap" value="A-" />
                                    <label for="A-" style="margin-left:15px;">A-</label>
                                    <input name="goldarah" type="radio"  id="B+"  class="with-gap" value="B+" />
                                    <label for="B+" style="margin-left:15px;">B+</label>
                                    <input name="goldarah" type="radio"  id="B-"  class="with-gap" value="B-" />
                                    <label for="B-" style="margin-left:15px;">B-</label>
                                    <input name="goldarah" type="radio"  id="AB+"  class="with-gap" value="AB+" />
                                    <label for="AB+" style="margin-left:15px;">AB+</label>
                                    <input name="goldarah" type="radio"  id="AB-"  class="with-gap" value="AB-" />
                                    <label for="AB-" style="margin-left:15px;">AB-</label>
                                    <input name="goldarah" type="radio"  id="O+"  class="with-gap" value="O+" />
                                    <label for="O+" style="margin-left:15px;">O+</label>
                                    <input name="goldarah" type="radio"  id="O-"  class="with-gap" value="O-" />
                                    <label for="O-" style="margin-left:15px;">O-</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="wnegara">Kewarganegaraan *</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    <input name="wnegara" type="radio"  id="WNI"  class="with-gap" value="WNI" />
                                    <label for="WNI">WNI</label>
                                    <input name="wnegara" type="radio"  id="WNA"  class="with-gap" value="WNA" />
                                    <label for="WNA"  style="margin-left:20px;">WNA</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="wnegara">Bahasa Sehari Hari *</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    <input name="bahasa" onClick="validateBahasa()" type="radio"  id="WNI-bahasa"  class="with-gap" value="INDONESIA" />
                                    <label for="WNI-bahasa">INDONESIA</label>
                                    <input name="bahasa" onClick="validateBahasa()" type="radio"  id="WNA-bahasaD"  class="with-gap" value="Daerah"  />
                                    <label for="WNA-bahasaD"  style="margin-left:20px;">Daerah</label>
                                    <input name="bahasa" onClick="validateBahasa()" type="radio"  id="lainnyaBahasa"  class="with-gap" />
                                    <label for="lainnya"  style="margin-left:20px;margin-right:20px;">Lainnya</label>
                                    <input type="text" name="bahasa2" id="bahasalainnya">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3  control-label col-form-label" id="sukubangsa" style="margin-bottom:0px;margin-top:0px;!important">Sukubangsa</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                        <select id="suku_bangsa" class="form-control" style="width: 100%" name="suku_bangsa" onkeyup="this.value = this.value.toUpperCase()">
                                            <option value="">-- Pilih Sukubangsa --</option>
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="alamat">Alamat *</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="alamat" id="alamats" rows="4" onkeyup="this.value = this.value.toUpperCase()"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="alamat"></label>
                            <div class="form-group row col-sm-8">
                                <div class="col-sm-2">
                                    <input class="form-control" name="rt" id="rt" type="text" placeholder="RT" >

                                </div>
                                <div class="col-sm-1">
                                    <input type="hidden" class="form-control" value="/" disabled>
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control" name="rw" id="rw" type="text" placeholder="RW">
                                </div>
                            </div>
                        </div>

                        <!-- ADDED ALAMAT YANG BISA DIHUBUNGI  -->
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="alamat">Alamat Yang Bisa Dihubungi *</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="alamat2" id="alamat2"  rows="4" onkeyup="this.value = this.value.toUpperCase()"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="alamat"></label>
                            <div class="form-group row col-sm-8">
                                <div class="col-sm-2">
                                    <input class="form-control" name="rt_alamat2" id="rt2" type="text" placeholder="RT" min="1">

                                </div>
                                <div class="col-sm-1">
                                    <input type="hidden" class="form-control" value="/" disabled>
                                </div>
                                <div class="col-sm-2">
                                    <input class="form-control" name="rw_alamat2" id="rw2" type="text" placeholder="RW" min="1">

                                </div>

                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-primary" id="btn_alamat" onClick="validateAlamat()">Alamat Sama</button>
                                </div>


                            </div>

                        </div>


                        <!-- END OF ADDED -->
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah *</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                <!-- <select name="load_wilayah" class="form-control load_wilayah" style="width:500px"> -->
                                    <select name="load_wilayah" id="load_wilayahs" class="form-control" style="width:500px">
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label">Kode Pos *</p>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="kodepos" name="kodepos">
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    <input name="pendidikan" type="radio"  id="S1/DIV"  class="with-gap" value="S1/DIV"/>
                                    <label for="S1/DIV" >S1/DIV</label>
                                    <input name="pendidikan" type="radio"  id="DIII"  class="with-gap" value="DIII" />
                                    <label for="DIII" style="margin-left:15px;">DIII</label>
                                    <input name="pendidikan" type="radio"  id="SMA"  class="with-gap" value="SMA" />
                                    <label for="SMA" style="margin-left:15px;">SMA</label>
                                    <input name="pendidikan" type="radio"  id="SLTP"  class="with-gap" value="SLTP" />
                                    <label for="SLTP" style="margin-left:15px;">SLTP</label>
                                    <input name="pendidikan" type="radio"  id="SD"  class="with-gap" value="SD" />
                                    <label for="SD" style="margin-left:15px;">SD</label>
                                    <input name="pendidikan" type="radio"  id="Belum/Tdk Sekolah"  class="with-gap" value="Belum/Tdk Sekolah"/>
                                    <label for="Belum/Tdk Sekolah" style="margin-left:15px;">Belum/Tdk Sekolah</label>

                                </div>
                            </div>
                        </div>


                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
                            <div class="col-sm-8">
                                <div class="form-inline" id="pilih_pekerjaan">
                                </div>
                                <input type="text" name="pekerjaan2" id="pekerjaan_lainnya" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_telpval"  maxlength="12" name="no_telp">
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="no_hp">No. HP</p>
                            <div class="col-sm-8">
                                <input type="text" class="form-control"  id="no_hpval" name="no_hp" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="no_telp_kantorval" maxlength="12" name="no_telp_kantor">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" for="nama_ayah">Nama Ayah</label>
                            <div class="col-sm-4">
                                <input type="text" id="nama_ayah" class="form-control" name="nama_ayah" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" for="nama_ibu">Nama Ibu</label>
                            <div class="col-sm-4">
                                <input type="text" id="nama_ibu" class="form-control" name="nama_ibu" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="label_nama_suami_istri" for="nama_suami_istri">Nama Suami / Istri</label>
                            <div class="col-sm-4">
                                <input type="text" id="nama_suami_istri" class="form-control" name="nama_suami_istri" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label"  for="signature">TTD Saat Ini</label>
                            <div class="col-sm-4" id="ttdpasien">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label"  for="signature">TTD Pasien/Keluarga Pasien</label>
                            <div class="col-sm-4">
                                <canvas class="canvas" required></canvas>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="offset-sm-3 col-sm-8">
                                <input type="hidden" id="signatureValue" name="ttd_pasien">

                                <button type="reset" class="btn btn-danger" id="btn-submit"><i class="fa fa-eraser"></i> Reset</button>
                                <button type="submit" class="btn btn-primary" id="btn-form-biodata-insert"><i clcass="fa fa-floppy-o"></i>Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
			</div>


			<div id="daftar_ulang" class="tab-pane active" role="tabpanel">
                <?php echo form_open('irj/rjcregistrasi/insert_daftar_ulang_new', array('class' => 'form-horizontal')); ?>
                    <div class="col-lg-10" style="margin: 0 auto;">
                        <br>
                        <br>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="jns_kunj">Jenis Kunjungan</label>
                            <div class="col-sm-8">
                                <div class="form-inline control-label pull-left">
                                    <!-- added untuk antrol -->
                                    <input type="hidden" class="form-control" value="<?= isset($reservasi->kodebooking)?$reservasi->kodebooking:'' ?>" name="reservasi">
                                    <!-- end added -->
                                    <input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
                                    <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="xcreate">
                                    <input type="hidden" class="form-control" id="kelasrawat" name="kelasrawat">
                                    <input type="hidden" class="form-control" id="asalrujukan" name="asalrujukan">
                                    <input type="hidden" class="form-control" id="tglrujukan" name="tglrujukan">
                                    <input type="hidden" class="form-control" id="ppkrujukan" name="ppkrujukan">
                                    <input type="radio" name="jns_kunj" class="jns_kunj" id="jnskunjlama" value="LAMA"><label for="lbl_lama">Lama</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="jns_kunj" class="jns_kunj" id="jnskunjbaru" value="BARU"><label for="lbl_lama">Baru</label>&nbsp;
                                    <!-- <input type="hidden" name="jns_kunj" id="jnskunjval"> -->
                                    <input type="hidden" name="namafaskes" id="namafaskes">
                                    <input type="hidden" name="prb" id="prb">
                                    <input type="hidden" name="online" value="<?= $online?1:0 ?>">
                                    <input type="hidden" name="noreservasi" value="<?= $online?$online['noreservasi']:null ?>">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label">Tgl. Kunjungan</label>
                            <div class="col-sm-8">
                                    <input type="date" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $online?$online['tglkunjungan']:date('Y-m-d');?>" >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    <select id="cara_bayar" class="custom-select form-control select2" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar_kontraktor(this.value)" required>
                                        <option value="">-- Pilih Cara Bayar --</option>
                                        <option value="UMUM">UMUM</option>
                                        <option value="BPJS">BPJS</option>
                                        <option value="KERJASAMA">KERJASAMA</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label">Cara Datang *</label>
                            <div class="col-sm-8">
                                <select id="cara_dtg" class="custom-select form-control select2" style="width: 100%" name="cara_dtg" required>
                                    <option value="">-- Pilih Cara Datang --</option>
                                    <option value="SENDIRI">SENDIRI</option>
                                    <option value="KELUARGA">KELUARGA</option>
                                    <option value="AMBULANCE">AMBULANCE</option>
                                    <option value="POLISI">POLISI</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label">Rujukan *</label>
                            <div class="col-sm-8">
                                <select id="cara_kunj" class="custom-select form-control select2" style="width: 100%" name="cara_kunj" required>
                                    <option value="">-- Pilih Rujukan --</option>
                                    <option value="DATANG SENDIRI">DATANG SENDIRI</option>
                                    <option value="DIKIRIM DOKTER">DIKIRIM DOKTER</option>
                                    <option value="RUJUKAN POLI">RUJUKAN POLI</option>
                                    <option value="RUJUKAN PUSKESMAS">RUJUKAN PUSKESMAS</option>
                                    <option value="RUJUKAN RS">RUJUKAN RS</option>
                                </select>
                            </div>
                        </div>


                        

                        <div class="form-group row jamkordatbukan">
                                <label class="col-sm-3 control-label col-form-label">Jamkordat</label>
                                <div class="col-sm-8">
                                    <select id="jamkordat" class="custom-select form-control" style="width: 100%" onchange="isjamkordat(this.value)" >
                                        <option value="" selected>Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>
                        </div>
                        
                        <div class="form-group row faskesjamkordat">
                                <label class="col-sm-3 control-label col-form-label">Faskes</label>
                                <div class="col-sm-8">
                                    <select id="faskestingkat" class="custom-select form-control" style="width: 100%" onchange="gantifaskestingkat(this.value)">
                                        <option value="" >Silahkan Dipilih Faskes Tingkat</option>
                                        <option value="1">Faskes 1</option>
                                        <option value="2">Faskes 2 / RS</option>
                                    </select>
                                </div>
                        </div>
                        
                        <div class="form-group row" id="rujukjamkordat">
                                <label class="col-sm-3 control-label col-form-label">Ppk Rujukan</label>
                                <div class="col-sm-8">
                                    <select id="ppkrujukjarkomdat" name="ppkrujukan_jarkomdat" class="custom-select form-control" style="width: 100%" onchange="isinamafaskes(this.value)" >
                                    </select>
                                </div>
                        </div>

                        

                       
                        <!-- <input type="hidden" name="jenis_faskes" id="jenis_faskes"> -->

                        <div class="form-group row div_bpjs">
                            <label class="col-sm-3 control-label col-form-label">No. Kartu BPJS</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" >
                                    <span class="input-group-btn">
                                        <button class="btn btn-info" type="button" id="btn-bpjs-daful"><i class="fa fa-eye"></i> Data Peserta</button>
                                    </span>
                                    <span class="input-group-btn">
                                        <button type="button" class="btn waves-effect waves-light btn-danger" id="btn-rujukan-kartu"><i class="fa fa-eye"></i> Data Rujukan</button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row div_bpjs_kerjasama" id="input_kontraktor">
                            <label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">Dijamin Oleh</label>
                            <div class="col-sm-8">
                                <div class="form-inline">
                                    <select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
                                        <option value="">-- Pilih Penjamin --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="div_rujukan" class="div_bpjs_thp">
                            <hr>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">No. SEP Manual</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="no_sep" id="no_sep_manual" >

                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">No. Rujukan</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="no_rujukan" id="no_rujukan">
                                        <span class="input-group-btn">
                                            <button class="btn waves-effect waves-light btn-danger" type="button" id="btn-rujukan" onclick="cek_no_rujukan($('#no_rujukan').val())"><i class="fa fa-eye"></i> Lihat Rujukan</button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <p class="col-sm-3 control-label col-form-label">Jumlah Terbit SEP</p>
                                <p class="col-sm-8" id="jml_terbit_sep">...</p>
                            </div>

                            <!-- Tujuan Kunjungan -->
                            <div class="form-group row div_bpjs">
                                <p class="col-sm-3 control-label col-form-label">Tujuan Kunjungan</p>
                                <div class="col-sm-8">
                                    <input type="radio" id="tujuan_kunj_normal" name="tujuan_kunj" value="0">
                                    <label for="tujuan_kunj_normal">Normal</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="tujuan_kunj_prosedur" name="tujuan_kunj" value="1">
                                    <label for="tujuan_kunj_prosedur">Prosedur</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="tujuan_kunj_konsul" name="tujuan_kunj" value="2">
                                    <label for="tujuan_kunj_konsul">Konsul Dokter</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>

                            <!-- Flag Procedure -->
                            <div class="form-group row div_bpjs">
                                <p class="col-sm-3 control-label col-form-label">Prosedur</p>
                                <div class="col-sm-8">
                                    <input type="radio" id="prosedur_tidak_berkelanjutan" name="flag_procedure" value="0">
                                    <label for="prosedur_tidak_berkelanjutan">Prosedur Tidak Berkelanjutan</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="prosedur_berkelanjutan" name="flag_procedure" value="1">
                                    <label for="prosedur_berkelanjutan">Prosedur dan Terapi Berkelanjutan</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>

                            <!-- Kode Penunjang -->
                            <div class="form-group row div_bpjs">
                                <label class="col-sm-3 control-label col-form-label">Penunjang</label>
                                <div class="col-sm-8">
                                    <select id="kode_penunjang" class="custom-select form-control" style="width: 100%" name="kd_penunjang">
                                        <option value="">-- Pilih Penunjang --</option>
                                        <option value="1">Radioterapi</option>
                                        <option value="2">Kemoterapi</option>
                                        <option value="3">Rehabilitasi Medik</option>
                                        <option value="4">Rehabilitasi Psikososial</option>
                                        <option value="5">Transfusi Darah</option>
                                        <option value="6">Pelayanan Gigi</option>
                                        <option value="7">Laboratorium</option>
                                        <option value="8">USG</option>
                                        <option value="9">Farmasi</option>
                                        <option value="10">Lain - Lain</option>
                                        <option value="11">MRI</option>
                                        <option value="12">HEMODIALISA</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row div_bpjs">
                                <label class="col-sm-3 control-label col-form-label">Assesment Pelayanan</label>
                                <div class="col-sm-8">
                                    <select id="assesment_pel" class="custom-select form-control" style="width: 100%" name="assesment_pel">
                                        <option value="">-- Pilih Assesment Pelayanan --</option>
                                        <option value="1">Poli spesialis tidak tersedia pada hari sebelumnya,</option>
                                        <option value="2">Jam Poli telah berakhir pada hari sebelumnya</option>
                                        <option value="3">Dokter Spesialis yang dimaksud tidak praktek pada hari sebelumnya</option>
                                        <option value="4">Atas Instruksi RS</option>
                                        <option value="5">Tujuan Kontrol</option>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">No.Surat Kontrol</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="nosurat_skdp_sep" id="no_surat_kontrol_skdp">
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" type="button" id="btn-suratkontrol"><i class="fa fa-eye"></i> Buat Surat Kontrol</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">Dokter Surat Kontrol</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <div class="form-inline" style="width:100%;">
                                            <select id="dpjp_suratkontrol" class="form-control select2" style="width: 100%" name="dpjp_suratkontrol" >
                                                <option value="">-- Pilih Dokter --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>

                    <!-- <div class="form-group row div_bpjs_thp2">
                        <label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">Suplesi</label>
                        <div class="col-sm-8">
                            <div class="form-inline">
                                <select id="suplesi" class="form-control select2" style="width: 100%" name="suplesi">
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </div>
                        </div>
                    </div> -->
                   
                    <div class="ird">
                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="alber">Alasan Berobat</label>
                                <div class="col-sm-8">
                                <select class="form-control" name="alber" id="alasan_berobat" onchange="pilih_alber(this.value)" >
                                    <option value="sakit">Sakit</option>
                                    <option value="kecelakaan">Kecelakaan</option>
                                    <option value="lahir">Melahirkan</option>
                                </select></div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label" id="pasdatDg">Datang dengan</label>
                            <div class="col-sm-8"><select class="form-control" name="pasdatDg" >
                                <option value="klg">Keluarga</option>
                                <option value="ttg">Tetangga</option>
                                <option value="lain">Lain-lain</option>
                            </select></div>
                        </div>
                        <div id="input_kecelakaan">
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label" id="Kclkaan">Kecelakaan</label>
                                <div class="col-sm-8">
                                    <select  class="form-control select2" name="jenis_kecelakaan" id="jenis_kecelakaan" style="width:100%;">
                                                <option value="">-- Pilih Jenis Kecelakaan --</option>
                                            </select>
                                    <input type="text" class="form-control m-t-10" placeholder="Lokasi Kecelakaan" name="lokasi_kecelakaan" >
                                </div>
                            </div>
                            <div class="form-group row kll_bpjs">
                                <label class="col-sm-3 control-label col-form-label">Penjamin KLL *</label>
                                <div class="col-sm-9">
                                    <div class="demo-checkbox">
                                        <input class="filled-in" type="checkbox" name="kll_penjamin[]" value="1" id="jasa_raharja">
                                        <label for="jasa_raharja">Jasa Raharja</label>

                                        <input class="filled-in" type="checkbox" name="kll_penjamin[]" value="2" id="bpjs_tk">
                                        <label for="jasa_raharja">BPJS Ketenagakerjaan</label>

                                        <input class="filled-in" type="checkbox" name="kll_penjamin[]" value="3" id="taspen">
                                        <label for="jasa_raharja">TASPEN</label>

                                        <input class="filled-in" type="checkbox" name="kll_penjamin[]" value="4" id="asabri">
                                        <label for="jasa_raharja">ASABRI PT</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row kll_bpjs">
                                <label class="col-sm-3 control-label col-form-label">Tgl. Kejadian</label>
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="kll_tgl_kejadian" id="kll_tgl_kejadian" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row kll_bpjs">
                                <label class="col-sm-3 control-label col-form-label">Lokasi Kejadian</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="kll_provinsi" id="kll_provinsi" style="width: 100%"></select>
                                </div>
                            </div>
                            <div class="form-group row kll_bpjs">
                                <label class="col-sm-3 control-label col-form-label"></label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="kll_kabupaten" id="kll_kabupaten"></select>
                                </div>
                            </div>
                            <div class="form-group row kll_bpjs">
                                <label class="col-sm-3 control-label col-form-label"></label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="kll_kecamatan" id="kll_kecamatan"></select>
                                </div>
                            </div>
                            <div class="form-group row kll_bpjs">
                                <label class="col-sm-3 control-label col-form-label">Keterangan Kejadian</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" name="kll_ketkejadian" id="kll_ketkejadian" cols="30" rows="5" style="resize:vertical" placeholder="ketik keterangan kejadian"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row ird" id="hubungan">
                        <label class="col-sm-3 control-label col-form-label">Hubungan</label>
                        <div class="col-sm-8">
                            <div class="form-inline">
                                    <select class="form-control" style="width: 100%" name="hubungan">
                                        <option value="">-- Pilih Hubungan --</option>
                                        <option value="Ybs.">Ybs.</option>
                                        <option value="Ortu">Orang Tua</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Anak">Anak</option>
                                    </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3  control-label col-form-label" id="dirujuk_ke" style="margin-bottom:0px;margin-top:0px;!important">Tujuan Poliklinik *</label>
                        <div class="col-sm-8">
                            <div class="form-inline">
                                <select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli">
                                    <option value="">-- Pilih Nama Poli --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row" id="div_katarak">
                        <div class="offset-sm-3 col-sm-8">
                            <div class="demo-checkbox">
                                <input type="checkbox" class="filled-in" name="katarak" value="1" id="katarak">
                                <label for="katarak">Katarak</label>
                            </div>
                            <span class="help-block" style="font-size: 14px;">Centang Katarak <i class="fa fa-check"></i>, Jika Peserta Tersebut Mendapatkan Surat Perintah Operasi katarak</span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 control-label col-form-label" id="dokter">Dokter Praktek</label>
                        <div class="col-sm-8">
                            <div class="form-inline">
                                    <select id="id_dokter" class="form-control select2" style="width: 100%" name="id_dokter" >
                                        <option value="">-- Pilih Dokter --</option>
                                    </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row div_bpjs">
                        <label class="col-sm-3 control-label col-form-label" id="dokter_bpjs_label">Dokter BPJS</label>
                        <div class="col-sm-8">
                            <div class="form-inline">
                                    <select id="dokter_bpjs" class="form-control select2" style="width: 100%" name="dokter_bpjs" >
                                        <option value="">-- Pilih Dokter --</option>
                                    </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row div_bpjs" id="input_diagnosa">
                        <label class="col-sm-3 control-label col-form-label" id="lbl_input_diagnosa">Diagnosa</label>
                        <div class="col-sm-8">
                            <select class="form-control autocomplete_diagnosa" name="diagnosa" id="diagnosa" style="width: 100%;"></select>
                            <input type="hidden" class="form-control" name="id_diagnosa" id="id_diagnosa">
                        </div>
                    </div>
                   

                        <div class="form-group row">
                            <label class="col-sm-3 control-label col-form-label">Kelas Rawat</label>
                            <div class="col-sm-8">
                                <select id="kelas_pasien" class="custom-select form-control select2" style="width: 100%" name="kelas_pasien" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="III" selected>III</option>
                                    <option value="II">II</option>
                                    <option value="I">I</option>
                                </select>
                            </div>
                        </div>

                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 form-control-label" >No. Telp</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="no_telpdaftar"  maxlength="12" name="no_telp">
                        </div>
                    </div>
                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 form-control-label" >Catatan</p>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="catatan" name="catatan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-3 col-sm-8">
                            <div class="demo-checkbox">
                                <input type="checkbox" class="filled-in" value="1" name="cetak_kartu" id="check_cetak_kartu"  />
                                <label for="check_cetak_kartu">Cetak Kartu</label>
                            </div>
                            <input type="hidden" class="form-control" name="cetak_kartu1" id="cetak_kartu1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="offset-sm-3 col-sm-8">
                            <button type="reset" class="btn waves-effect waves-light btn-danger"><i class="fa fa-eraser"></i> Reset</button>
                            <button type="submit" class="btn btn-primary" id="button_cetak_karcis" onClick="validasiSubmit()"><i class="fa fa-floppy-o"></i> Simpan</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view("layout/footer_left"); ?>