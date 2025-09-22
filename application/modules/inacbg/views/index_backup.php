<?php
if ($role_id == 1) {
  $this->load->view("layout/header_left");
} else {
  $this->load->view("layout/header_horizontal");
}
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo site_url('assets/css/toastr.min.css'); ?>">
<script type="text/javascript" src="<?php echo site_url('assets/js/toastr.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/datetimepicker-master/jquery.datetimepicker.css'); ?>">
<script type="text/javascript" src="<?php echo site_url('assets/plugins/datetimepicker-master/jquery.datetimepicker.js'); ?>"></script>

<style type="text/css">
  .rowtabledetail {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    margin-right: 20px;
    margin-top: 10px;
  }

  [type="radio"]:disabled+label {
    color: #4b5255;
  }

  .demo-radio-button label {
    min-width: 90px;
  }

  .comment-text {
    padding: 0;
    padding-left: 20px;
  }

  input[type=text]:disabled,
  textarea:disabled {
    background: #fafafa;
    color: #555;
    cursor: default;
  }

  .tooltip-inner {
    color: #fff;
    background: #FF9900;
  }

  /* input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }*/
  #toast-container>div {
    opacity: 0.9;
    -ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=90);
    filter: alpha(opacity=90);
  }

  table.dataTable tbody td {
    padding: 10px 18px;
  }

  table.dataTable tbody th {
    padding: 10px 22px;
  }

  #claim_form {
    margin-top: 10px;
  }

  #table-pelayanan tbody tr {
    background-color: #f6f6f6;
  }

  #table_diagnosa tbody tr,
  #table_procedure tbody tr,
  #table-grouper-result tbody tr,
  #table-pelayanan tbody tr[role="row"] {
    background-color: #ffffff;
  }

  .ui-menu .ui-menu-item {
    padding: 0;
    border-bottom: 1px solid #ededed;
  }

  .ui-menu .ui-state-focus,
  .ui-menu .ui-state-active {
    margin: 0;
  }

  .user-block .description {
    color: #444;
    font-size: 16px;
  }

  .user-block .username {
    font-size: 18px;
    font-weight: bold;
  }

  .ui-state-highlight,
  .ui-widget-content .ui-state-highlight,
  .ui-widget-header .ui-state-highlight {
    border: 0;
    background: #fffa90;
    color: #777620;
    font-weight: normal;
  }

  .ui-state-active,
  .ui-widget-content .ui-state-active,
  .ui-widget-header .ui-state-active,
  a.ui-button:active,
  .ui-button:active,
  .ui-state-active.ui-button:hover {
    border: 0;
    background: #eee;
    color: #333;
  }

  .ui-autocomplete {
    max-height: 270px;
    overflow-y: scroll;
    overflow-x: scroll;
  }

  .ui-widget-content {
    font-size: 12px;
  }

  .ui-widget-content .ui-state-active {
    font-size: 12px;
  }

  .ui-autocomplete-loading {
    background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
  }

  .page-titles {
    display: none;
  }

  .dataTables_info {
    display: none;
  }

  .sidebar-nav>ul>li>a.active {
    font-weight: 400;
    background: #ffffff;
    color: #546e7b;
  }

  .sidebar-nav>ul>li>a.active:hover i {
    /*background-color: #fff;*/
    color: #fff;
  }

  .sidebar-nav>ul>li>a.active i {
    color: #546e7b;
  }

  th {
    font-size: 14px;
  }

  #table-pelayanan tbody tr {
    cursor: pointer;
  }

  td.details-control {
    background: url('<?php echo site_url('assets/images/details_open.png'); ?>') no-repeat center center;
    cursor: pointer;
  }

  tr.shown td.details-control {
    background: url('<?php echo site_url('assets/images/details_close.png'); ?>') no-repeat center center;
  }

  .borderless>tbody>tr>td {
    border: none;
    padding: 1px;
  }

  td.dataTables_empty {
    text-align: center;
  }

  @media screen and (min-width: 768px) {
    .box-body {
      padding: 15px;
    }
  }

  .profile-username {
    margin-top: 10px;
  }

  .profile-user-img {
    margin: 0 auto;
    width: 100px;
    padding: 10px;
    border: 3px solid #bfbfbf;
  }

  th {
    font-size: 14px;
  }

  .box-body {
    padding: 15px;
  }

  #total_tarif_rs:before {
    content: 'Rp';
    /*font-size: 0.85em;*/
    margin-right: 5px;
    /*vertical-align: bottom;*/
  }

  .load_input {
    background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") center center no-repeat;
  }

  table.table-bordered {
    border: 1px solid #000;
    margin-top: 20px;
  }

  table.table-bordered>thead>tr>th {
    border: 1px solid #000;
  }

  table.table-bordered>tbody>tr>td {
    border: 1px solid #000;
  }
</style>
<?php include('index_javascript.php') ?>


<div class="card mt-4">
  <div class="card-header">
    <h4>Coding / Grouping</h4>
  </div>
  <div class="card-body">
    <div class="row">
      <label class="col-sm-4 col-form-label col-form-label ml-4 pb-4">Cari No. RM / No. SEP / Nama</label>
      <div class="col-sm-6">
        <div class="input-group">
          <input type="text" class="form-control" id="cari_pasien">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button" id="btn-cari"><i class="fa fa-search"></i>&nbsp;Cari</button>
          </span>
        </div>
      </div>
    </div>
    <div class="card-body b-t p-t-20 p-b-20 text-center" id="show-loading" style="padding: 20px;">
      <p style="font-size: 16px;font-weight: 600;"><i class="fa fa-spinner fa-spin"></i>&nbsp; Menampilkan Data Pelayanan</p>
    </div>
    <div id="show-pasien">
      <hr>
      <div class="row">
        <div class="pl-4 ml-4 d-flex flex-row comment-row">
          <img src="<?php echo site_url("assets/images/user_unknown.png"); ?>" alt="user" width="45" height="45">
          <div class="comment-text w-100">
            <h5 class="username box-title" id="nama_pasien" style="margin-bottom: 4px;"></h5>
            <p style="margin-bottom: 0;"><span id="no_rm"></span> <span style="color:#444;" id="separate_rm">••</span> <span id="gender"></span> <span style="color:#444;" id="separate_gender">••</span> <span id="tgl_lahir"></span></p>
          </div>
        </div>
        <hr>
      </div>
    </div>

    <div id="load_pelayanan" class="m-4">

      <table id="table-pelayanan" class="table table-hover table-bordered" width="100%">
        <thead>
          <tr>
            <th class="text-center">Pilih</th>
            <th>No. Register</th>
            <th>Tgl. Masuk</th>
            <th>Tgl. Pulang</th>
            <th>No. SEP</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody id="hasil_load_pelayanan">
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="modal_sep" class="modal fade" role="dialog" aria-labelledby="modal-search-kode" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-success">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modal-search-kode">Edit SEP</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <form id="form_sep_manual" class="form-horizontal">
        <div class="modal-body" style="background-color: #ecf0f5;">
          <div class="form-group row">
            <label for="no_sep_manual" class="col-sm-2 col-form-label" style="text-align: left;">No. SEP</label>
            <div class="col-sm-7">
              <div class="input-group">
                <input type="text" class="form-control" name="no_sep_manual" id="no_sep_manual" placeholder="Masukkan Nomor SEP">
                <span class="input-group-btn">
                  <button class="btn btn-danger" type="button" id="btn-cek-sep"><i class="fa fa-eye"></i> Data SEP</button>
                </span>
              </div>
            </div>
          </div>
          <div class="card card-outline-default" id="show_result_sep" style="margin-top: 25px;">
            <div class="card-header text-center">
              <div class="card-actions">
                <a class="btn-close" data-action="close"><i class="ti-close"></i></a>
              </div>
              <h3 class="card-title m-b-0 text-bold" style="font-size: 15px;">DATA DETAIL SEP</h3>
            </div>
            <!-- /.box-header -->
            <div class="card-body">
              <div class="table-responsive" style="clear: both;margin-top: 0;">
                <table class="table table-hover borderless" width="100%">
                  <tbody>
                    <tr>
                      <td style="width: 25%;">No. SEP</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_sep" class="text-bold"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Tanggal SEP</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_tgl_sep"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">No. Rujukan</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_no_rujukan"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Jenis Pelayanan</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_jns_pelayanan"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Kelas Rawat</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_kls_rawat"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Poli</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_poli"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Nama</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_nama"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">No. Kartu BPJS</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_no_bpjs"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Diagnosa</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_diagnosa"></td>
                    </tr>
                    <tr>
                      <td style="width: 25%;">Catatan</td>
                      <td style="width: 3%;">:</td>
                      <td id="show_catatan"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="btn-sep-manual"><i class="fa fa-floppy-o"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
if ($role_id == 1) {
  $this->load->view("layout/footer_left");
} else {
  $this->load->view("layout/footer_horizontal");
}
?>