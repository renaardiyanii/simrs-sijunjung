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
    font-size: 18px;
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
<!-- <h4> <b> Daftar Pasien BPJS Seluruh Pelayanan </b></h4> -->
<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="kontrol-tab" data-toggle="tab" href="#kontrol" role="tab" aria-controls="kontrol"
            aria-selected="true">Daftar Kontrol Pasien</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="konsul-tab" data-toggle="tab" href="#konsul" role="tab"
            aria-controls="konsul-tab" aria-selected="true">Daftar Konsul Pasien (Rujukan Internal)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="rujukan-tab" data-toggle="tab" href="#rujukan" role="tab"
            aria-controls="rujukan-tab" aria-selected   ="true">Daftar Pembuatan Surat Rujukan RS Lain</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="postranap-tab" data-toggle="tab" href="#postranap" role="tab"
            aria-controls="postranap-tab" aria-selected   ="true">Daftar Pembuatan Surat Kontrol(Post Ranap)</a>
    </li>
    <li class="nav-item">
        <a class="nav-link " id="backdateranap-tab" data-toggle="tab" href="#backdateranap" role="tab"
            aria-controls="backdateranap-tab" aria-selected   ="true">Pengajuan Backdate(SEP) Ranap</a>
    </li>
</ul>

<div class="tab-content mt-4" id="myTabContent">
    
    <div class="tab-pane fade show active" id="kontrol" role="tabpanel" aria-labelledby="kontrol-tab">
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
                            <th width="10%">Tgl Kontrol</th>
                            <th width="15%">Pasien</th>
                            <th width="15%">No.Kartu</th>
                            <th width="15%">No.SEP Asal</th>
                            <th width="20%">No.Surat Kontrol</th>
                            <th width="10%">Poliklinik</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="hasil-kontrol">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="konsul" role="tabpanel" aria-labelledby="konsul-tab">
        <div class="row p-t-0 mt-3">
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="datepicker-konsul" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="inputcustom-konsul" placeholder="Cari Pasien..">
                </div>
            </div>
           
        </div>
        <div class="card mt-2">

            <div class="table-responsive m-t-0 mb-2">

                <!-- example datatable server side -->
                <table class="table table-striped table-bordered" id="table-konsul" style="width: 100%">
                    <thead>
                        <tr>    
                            <th width="20%">Tgl Konsul</th>
                            <th width="20%">Pasien</th>
                            <th width="15%">No. Regis Lama</th>
                            <th width="15%">No Kartu</th>
                            <th width="10%">Poli Asal</th>
                            <th width="10%">Dokter Asal</th>
                            <th width="10%">Poli Tujuan</th>
                            <th width="10%">Dokter Tujuan</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="rujukan" role="tabpanel" aria-labelledby="rujukan-tab">
        <div class="row p-t-0 mt-3">
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="datepicker-rujukan" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="inputcustom-rujukan" placeholder="Cari Pasien..">
                </div>
            </div>
           
        </div>  
        <div class="card mt-2">
        <br>
            <div class="table-responsive m-t-0 mb-2">
                <table class="display nowrap table table-hover table-bordered table-striped" id="table-rujukan" style="width: 100%">
                    <thead>
                        <tr>   
                            <th width="10%">Tgl Dirujuk</th> 
                            <th width="20%">Pasien</th>
                            <th width="20%">No Kartu BPJS</th>
                            <th width="20%">No SEP</th>
                            <th width="15%">Rumah Sakit Tujuan</th>
                            <th width="15%">Bagian</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
   
    <div class="tab-pane fade" id="postranap" role="tabpanel" aria-labelledby="postranap-tab">
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

               
                <table class="display nowrap table table-hover table-bordered table-striped" id="table-iri" style="width: 100%">
                    <thead>
                        <tr> 
                            <th width="15%">Tgl Pulang</th>   
                            <th width="15%">Pasien</th>
                            <th width="10%">MR</th>
                            <th width="20%">No Kartu BPJS</th>
                            <th width="20%">No SEP</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="backdateranap" role="tabpanel" aria-labelledby="backdateranap-tab">
        <div class="row p-t-0 mt-3">
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="datepicker-backdateranap" placeholder="Pilih Tanggal">

                    <div class="input-group-prepend mr-2">
                        <span class="input-group-text">
                            <i class="mdi mdi-calendar"></i>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group d-flex align-items-center">
                    <input type="text" class="form-control borderless" id="inputcustom-backdateranap" placeholder="Cari Pasien..">
                </div>
            </div>
           
        </div>  
        <div class="card mt-2">
        <br>
            <div class="table-responsive m-t-0 mb-2">

               
                <table class="display nowrap table table-hover table-bordered table-striped" id="table-backdateranap" style="width: 100%">
                    <thead>
                        <tr> 
                            <th width="15%">Tgl Masuk</th>   
                            <th width="15%">Pasien</th>
                            <th width="10%">MR</th>
                            <th width="20%">No Kartu BPJS</th>
                            <th width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>





<script>
    var datenow = '<?= date('Y-m-d') ?>';
    var urllistkontrol = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs_kontrol'); ?>";
    var urllistkonsul = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs_konsul'); ?>";
    var urllistrujukan = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs_rujukan'); ?>";
    var urllistiri = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs_posranap'); ?>";
    var urllistbackdateranap = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs_backdate_ranap'); ?>";
    var baseurl = '<?= base_url('') ?>';
</script>   

<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script src="<?= base_url('assets/notify.js') ?>"></script>
<script src="<?= base_url() ?>assets/js/irj/js_list_sep_pasien.js"></script>

<?php 
    $this->load->view('layout/footer_left');
?>