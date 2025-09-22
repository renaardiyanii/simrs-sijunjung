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
            aria-selected="true">Pembuatan Surat Kontrol</a>
    </li>

</ul>

<div class="tab-content mt-4" id="myTabContent">
    
    <div class="tab-pane fade show active" id="kontrol" role="tabpanel" aria-labelledby="kontrol-tab">
        <!-- <div class="row p-t-0 mt-3">
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
        </div> -->
        <div class="card mt-2">

            <div class=" m-t-0">

                <!-- example datatable server side -->
                <table class="table table-striped table-bordered" id="table-artikel">
                    <thead>
                        <tr>    
                            <th width="10%">Tanggal</th>
                            <th width="20%">Nama</th>
                            <th width="15%">No.Medrec</th>
                            <th width="15%">No.Kartu</th>
                            <th width="15%">No.SEP Asal</th>
                            <th width="15%">Poliklinik</th>
                            <th width="30%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="hasil-kontrol">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>





<script>
    var datenow = '<?= date('Y-m-d') ?>';
    var urllistkontrol = "<?php echo base_url('irj/rjcregistrasi/get_listbpjs_pembuatan_kontrol'); ?>";
    var baseurl = '<?= base_url('') ?>';
</script>   

<script src="<?= base_url() ?>asset/js/jquery-ui.js"></script>
<script src="<?= base_url() ?>asset/js/jquery-datatablenew.js"></script>
<script src="<?= base_url('assets/notify.js') ?>"></script>
<script src="<?= base_url() ?>assets/js/irj/js_list_pembuatan_kontrol.js"></script>

<?php 
    $this->load->view('layout/footer_left');
?>