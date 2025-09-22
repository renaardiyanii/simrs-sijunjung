<?php 
    $this->load->view('layout/header_left');
?>
<style>
#notifications {
    cursor: pointer;
    position: fixed;
    right: 0px;
    z-index: 9999;
    top: 100px;
    margin-bottom: 22px;
    margin-right: 15px;
    max-width: 300px;
}
.nav-tabs .nav-item.show .nav-link,
.nav-tabs .nav-link.active {
    color: black;
    /* background-color: #fff; */
    /* border-color: #ddd #ddd #fff; */
    /* border-bottom-color: rgb(255, 255, 255); */
    border-bottom: 3px solid black !important;
    background-color: transparent;
}

.nav-tabs .nav-link {
    border: none !important;
}
.input-group-text i.mdi.mdi-calendar {
    font-size: 18px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* Style for the white background div */
.input-group {
    background-color: white;
    border: 1px solid #ccc;
    /* Add a border for visual separation */
}

/* Style for the input field */
.form-control {
    min-height:22px;
    /* border: none; */
    /* Remove the input field border */
}
.borderless{
    border: none!important;

}

/* Style for the icon */
.input-group-text i.mdi.mdi-calendar {
    font-size: 10px;
    /* Adjust the size as needed */
    color: #555;
    /* Adjust the color as needed */
}

/* .dataTables_filter {
    display: none;
} */

.dataTables_length {
    display: none;
} 

.dataTables_info {
    margin-left: 1em;
    margin-bottom: 1em;
}

.paginate_button {
    margin-right: 1em;
    margin-bottom: 1em;
}

.ui-autocomplete {
    z-index: 1000;
}

.modal_list_rujukan{
    z-index:1050 !important;
}
.modal_buat_sep_irj{
    z-index:1049 !important;
}

</style>
<h4> <b> Daftar Pasien BPJS Seluruh Pelayanan </b></h4>
<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="irj-tab" data-toggle="tab" href="#irj" role="tab" aria-controls="irj"
            aria-selected="true">Instalasi Rawat Jalan</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="igd-tab" data-toggle="tab" href="#igd" role="tab"
            aria-controls="igd-tab" aria-selected="true">Instalasi Gawat Darurat</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="iri-tab" data-toggle="tab" href="#iri" role="tab"
            aria-controls="iri-tab" aria-selected   ="true">Instalasi Rawat Inap</a>
    </li>
</ul>

<div class="tab-content mt-4" id="myTabContent">
    <!-- <div class="tab-pane fade" id="irj" role="tabpanel" aria-labelledby="irj-tab"> -->
    <div class="tab-pane fade show active" id="irj" role="tabpanel" aria-labelledby="irj-tab">
        <div class="row p-t-0 mt-3">
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="datepicker" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="inputcustom" placeholder="Cari Pasien..">
                </div>
            </div>
        </div>
        <div class="card mt-2">

            <div class=" m-t-0">

                <!-- example datatable server side -->
                <table class="table table-striped table-bordered" id="table-artikel">
                    <thead>
                        <tr>    
                            <th width="15%">Nama</th>
                            <th width="15%">No Medrec</th>
                            <th width="10%">Poliklinik</th>
                            <th width="10%">No Kartu BPJS</th>
                            <th width="20%">No. Surat Kontrol</th>
                            <th width="30%">No SEP</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="hasil-irj">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="igd" role="tabpanel" aria-labelledby="igd-tab">
        <div class="row p-t-0 mt-3">
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="datepicker-igd" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="inputcustom-igd" placeholder="Cari Pasien..">
                </div>
            </div>
           
        </div>
        <div class="card mt-2">

            <div class="table-responsive m-t-0 mb-2">

                <!-- example datatable server side -->
                <table class="table table-striped table-bordered" id="table-igd" style="width: 100%">
                    <thead>
                        <tr>    
                            <th width="20%">Pasien</th>
                            <th width="15%">No. Registrasi</th>
                            <th width="15%">No Kartu BPJS</th>
                            <th width="40%">No SEP</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- <div class="tab-pane fade show active" id="iri" role="tabpanel" aria-labelledby="iri-tab"> -->
    <div class="tab-pane fade" id="iri" role="tabpanel" aria-labelledby="iri-tab">
        <div class="row p-t-0 mt-3">
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="datepicker-iri" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="inputcustom-iri" placeholder="Cari Pasien..">
                </div>
            </div>
           
        </div>  
        <div class="card mt-2">
        <br>
            <div class="table-responsive m-t-0 mb-2">

                <!-- example datatable server side -->
                <table class="display nowrap table table-hover table-bordered table-striped" id="table-iri" style="width: 100%">
                    <thead>
                        <tr>    
                            <th width="20%">Pasien</th>
                            <th width="10%">MR</th>
                            <th width="15%">No. Registrasi</th>
                            <th width="15%">No Kartu BPJS</th>
                            <th width="20%">No SPRI</th>
                            <th width="40%">No SEP</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

<div id="notifications"></div>


<div class="modal fade modal_suratkontrol" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold" id="title-suratkontrol">PEMBUATAN SURAT KONTROL</h4>

				<div class="formbuatsurkon">
					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">No.SEP</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="no_sep_surat_bikin">
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Tgl Rencana Kontrol</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="tgl_surat_bikin" onchange="ambilpolikontrol(this.value)">

						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Poli Kontrol</label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="poli_suratkontrol_bikin" class="form-control select2" style="width: 100%"  onchange="ambildoktersuratkontrol(this.value)">
									<option value="">-- Pilih Poliklinik --</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Dokter Surat Kontrol</label>
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
			<div class="modal-footer" id="footer-suratkontrol">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary waves-effect text-left" id="buat-suratkontrol" onclick="buatsuratkontrol()" >Buat Surat Kontrol</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>




<div class="modal fade modal_spri" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<h4 class="text-center text-bold" id="title-spri">PEMBUATAN SPRI</h4>

				<div class="formbuatsurkon">
					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">No.Kartu</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="no_kartu_buat_spri" placeholder="Masukkan No.Kartu BPJS">
							<input type="hidden" class="form-control" id="no_ipd" >
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Tgl Rencana Ranap</label>
						<div class="col-sm-8">
							<input type="date" class="form-control" id="tgl_rencana_ranap" onchange="ambilpolispri(this.value)">

						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Poli SPRI</label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="poli_spri_bikin" class="form-control select2" style="width: 100%"  onchange="ambildokterspri(this.value)">
									<option value="">-- Pilih Poliklinik --</option>
								</select>
							</div>
						</div>
					</div>

					<div class="form-group row">
						<label class="col-sm-3 control-label col-form-label">Dokter SPRI</label>
						<div class="col-sm-8">
							<div class="form-inline" style="width:100%;">
								<select id="dpjp_spri_bikin" class="form-control select2" style="width: 100%" name="dpjp_spri_bikin" >
									<option value="">-- Pilih Dokter --</option>
								</select>
							</div>
						</div>
					</div>


				</div>
			</div>
			<div class="modal-footer" id="footer-spri">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary waves-effect text-left" id="buat-spri" onclick="buatspri()" >Buat SPRI</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>


<div class="modal modal_buat_sep_irj" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body" >
				<h4 class="text-center text-bold" id="title-RT12312">PEMBUATAN SEP RAWAT JALAN</h4>
                <form id="buat_sep_irj">
                    <input type="hidden" name="no_register" id="irj-no_register">
                    <input type="hidden" name="asal_rujukan" id="irj-asalrujukan">
                    <input type="hidden" name="tgl_rujukan" id="irj-tglrujukan">
                    <input type="hidden" name="kode_ppk" id="irj-kode_ppk">
                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 control-label col-form-label">No. Kartu BPJS</p>
                        <div class="input-group col-sm-8">
                            <input type="text" class="form-control" name="no_kartu" id="irj-no_kartu">
                            <div class="">
                                <button type="button" class="btn waves-effect waves-light btn-danger" data-toggle="collapse" data-target="#demo" onclick="getlistrujukannew()"><i class="fa fa-eye"></i> Data Rujukan</button>
                            </div>
                        </div>
                    </div>
                    <div id="demo" class="collapse">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#fk1-buatrawatjalan" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Rujukan Faskes 1</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#fk2-buatrawatjalan" role="tab" ><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Rujukan Faskes 2</span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#fk3-buatrawatjalan" role="tab" ><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Rawat Inap</span></a> </li>
                        </ul>
                        <div class="tab-content">
                            <div id="fk1-buatrawatjalan" class="tab-pane active" role="tabpanel">
                            </div>
                            <div id="fk2-buatrawatjalan" class="tab-pane" role="tabpanel">
                                
                            </div>
                            <div id="fk3-buatrawatjalan" class="tab-pane" role="tabpanel">
                                
                            </div>
                        </div>
                        
                    </div>
                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 control-label col-form-label">No. Rujukan</p>
                        <div class="input-group col-sm-8">
                            <input type="text" class="form-control" id="irj-no_rujukan" name="no_rujukan">
                            
                        </div>
                    </div>
                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 control-label col-form-label">Jumlah Terbit SEP</p>
                        <p class="col-sm-8" id="jml_terbit_sep">...</p>
                    </div>
                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 control-label col-form-label">Tujuan Kunjungan</p>
                        <div class="col-sm-8">
                            <input type="radio" id="tujuan_kunj_normal" name="tujuan_kunj" value="0" onclick="pilihansuratkontrol('0')">
                            <label for="tujuan_kunj_normal">Normal</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="tujuan_kunj_prosedur" name="tujuan_kunj" value="1" onclick="pilihansuratkontrol('1')">
                            <label for="tujuan_kunj_prosedur">Prosedur</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="tujuan_kunj_konsul" name="tujuan_kunj" value="2" onclick="pilihansuratkontrol('2')">
                            <label for="tujuan_kunj_konsul">Konsul Dokter</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                    <div class="form-group row div_bpjs">
                        <p class="col-sm-3 control-label col-form-label">Prosedur</p>
                        <div class="col-sm-8">
                            <input type="radio" id="prosedur_tidak_berkelanjutan" name="flag_procedure" value="0">
                            <label for="prosedur_tidak_berkelanjutan">Prosedur Tidak Berkelanjutan</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="prosedur_berkelanjutan" name="flag_procedure" value="1">
                            <label for="prosedur_berkelanjutan">Prosedur dan Terapi Berkelanjutan</label>&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
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
                    <!-- <div class="form-group row">
                        <label class="col-sm-3 control-label col-form-label" for="tipe_kunjungan">Tipe Kunjungan</label>
                        <div class="col-sm-8">
                            <select  class="form-control" id="tipe_kunjungan" style="width:100%;" onchange="pilihansuratkontrol(this.value)">
                                <option value="">Pilih Tipe Kunjungan</option>
                                <option value="0">Kunjungan Pertama</option>
                                <option value="1" >Kunjungan Poli Internal</option>
                                <option value="2">Kunjungan Kontrol Ulang</option>
                            </select>
                        </div> -->
                    <!-- </div> -->
                    <div class="form-group row">
                        <label class="col-sm-3 control-label col-form-label" for="dpjp_skdp">Dokter BPJS</label>
                        <div class="col-sm-8">
                            <select  class="form-control" id="dpjp_skdp" name="dpjp_skdp" style="width:100%;" >
                                <option value="">Pilih Dokter BPJS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label col-form-label" for="dpjp_skdp">Diagnosa</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm autocomplete_diagnosa_irj" style="width:100%" name="diagnosa" id="diagnosa_irj">
                            </select>
                        </div>
                    </div>
                    <div class="form-group row" id="div-suratkontrol">
                        <p class="col-sm-3 control-label col-form-label">Nomor Surat Kontrol</p>
                        <input type="text" class="form-control col-sm-8" name="nosurat_skdp_sep" id="nosurat_skdp_sep">
                        <input type="hidden" name="dpjp_skdp_sep" id="dpjp_skdp_sep">
                        <!-- <input type="hidden" name="tujuan_kunj" id="tujuan_kunj"> -->
                        <!-- <input type="hidden" name="flag_procedure" id="flag_procedure"> -->
                        <!-- <input type="hidden" name="kd_penunjang" id="kd_penunjang"> -->
                        <!-- <input type="hidden" name="assesment_pel" id="assesment_pel"> -->
                    </div>
                </form>
				
			</div>
			<div class="modal-footer" id="footer-1q2412312">
				<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary waves-effect text-left" id="buat-123123" onclick="buat_sep_pasien_irj()" >Buat SEP</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>


<div class="modal fade" id="modalPembuatanRujukan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buat Rujukan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formRujukanKeluar">
        <!-- <div class="form-group">
            <label for="">Tgl Rujukan</label>
            <input type="date" class="form-control" name="tglRujukan">
        </div> -->
        <div class="form-group">
            <input type="hidden" name="noSep" id="nosep_rujukan">
            <label for="">Tgl Rencana Kunjungan</label>
            <input type="date" class="form-control" name="tglRencanaKunjungan">
        </div>
        <div class="form-group">
            <label for="">Pelayanan</label>
            <select class="form-control" id="pelayanan" name="jnsPelayanan">
                <option value="2">Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Tipe</label>
            <select class="form-control" name="tipeRujukan">
                <option value="0">Penuh</option>
                <option value="1">Partial</option>
                <option value="2">Rujuk Balik ( non PRB )</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Diagnosa Rujukan</label>
            <select class="form-control input-sm autocomplete_diagnosarujukan" style="width:100%" name="diagRujukan" id="diagnosa">
            </select>
        </div>
        <div class="form-group">
            <label for="">Jenis Faskes</label>
            <select class="form-control" id="jenis_faskes" onchange="gantifaskesrujukan(this.value)">
                <option value="">Silahkan Pilih Jenis Faskes</option>
                <option value="1">Faskes 1</option>
                <option value="2">Faskes 2 / RS</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Dirujuk Ke</label>
            <select class="form-control input-sm" style="width:100%" name="ppkDirujuk" id="ppkDirujukEdit">
            </select>
        </div>
        <div class="form-group">
            <label for="">Poli Rujukan</label>
            <select class="form-control input-sm" style="width:100%" name="poliRujukan" id="poliRujukanup">
            </select>
        </div>
        
        <div class="form-group">
            <label for="">Catatan Rujukan</label>
            <input type="text" class="form-control" name="catatan">
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="submitrujukan" onclick="submitRujukan()">Buat Rujukan</button>
      </div>
    </div>
  </div>
</div>

<script>
    var datenow = '<?= date('Y-m-d') ?>';
    var urllistirj = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs?pelayanan=irj'); ?>";
    var urllistigd = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs?pelayanan=igd'); ?>";
    var urllistiri = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs?pelayanan=iri'); ?>";
    var urlupdatesep = "<?php echo base_url('irj/rjcregistrasi/update_sepbpjs'); ?>";
    var baseurl = '<?= base_url('') ?>';
</script>   

<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script src="<?= base_url('assets/notify.js') ?>"></script>
<script src="<?= base_url() ?>assets/js/irj/js_sep_pasien.js"></script>

<?php 
    $this->load->view('layout/footer_left');
?>