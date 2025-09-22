<?php $this->load->view("layout/header_left"); ?>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.fixedHeader.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/responsive.bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.scroller.min.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.colVis.js"></script>
<script src="<?php echo base_url(); ?>asset/plugins/datatables/dataTables.fixedColumns.min.js"></script>
<link rel="stylesheet" href="<?php echo site_url('assets/css/toastr.min.css'); ?>">
<script type="text/javascript" src="<?php echo site_url('assets/js/toastr.min.js'); ?>"></script>

<section class="content" id="konten">
  <div class="col-lg-12 col-md-12">
    <?php echo $this->session->flashdata('pesan'); ?>
    <div class="card card-outline-info">
      <div class="card-header">
        <div class="col-md-3">
          <div class="input-group">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input class="form-control" id="date" name="bulan" placeholder="yyyy-mm" type="text" / value="<?= date('Y-m') ?>" autocomplete="off" required>
            <div class="input-group-btn">
              <button type="button" id="btn-filter" class="btn btn-danger"><i class="fa fa-search"></i> Filter</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card-block">
        <div class="table-responsive m-t-15">
          <table class="table table-hover table-striped table-bordered data-table table-sm" id="dataTables-example" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" width="15px" style="vertical-align: middle;">No.</th>
                <th rowspan="2" width="15%" style="vertical-align: middle;">Nama Pasien</th>
                <th rowspan="2" style="vertical-align: middle;">MR</th>
                <th rowspan="2" width="15%" style="vertical-align: middle;">Ruang Rawat</th>
                <th colspan="3" style="text-align: center;">Rencana Pulang Pasien H-1</th>
                <th rowspan="2" style="vertical-align: middle;">Tanggal Keluar</th>
                <th rowspan="2" style="vertical-align: middle;">Jam Keluar</th>
                <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
              </tr>
              <tr>
                <th>User Click</th>
                <th>Tanggal</th>
                <th>Jam</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>

          <div class="form-inline m-t-15" align="right">
            <div class="input-group">
              <table width="100%" class="table table-hover table-striped table-bordered" style="text-align: center;">
                <tr>
                  <td style="vertical-align: middle;">Perhitungan: </td>
                  <td>
                    (Jumlah Pasien Pulang <= Jam 12) - (Keterangan) <hr>
                      (Pasien yang direncanakan pulang H-1) - (Keterangan)
                  </td>
                  <td style="vertical-align: middle;">x 100% =</td>
                  <td>
                    <span id="jml_krg12">0</span>
                    <hr>
                    <span id="jml_h_1">0</span>
                  </td>
                  <td style="vertical-align: middle;">x 100% =</td>
                  <td style="vertical-align: middle;"><span id="perhitungan_result">0</span></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  $(document).ready(function() {
    var date_input = $('input[name="bulan"]');
    var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
      format: 'yyyy-mm',
      monthHighlight: true,
      autoclose: true,
      startView: "year",
      minViewMode: "months"
    });

    data_table = $('#dataTables-example').DataTable({
      "responsive": true,
      "processing": true,
      "language": {
        "processing": '<i class="fa fa-circle-o-notch fa-spin fa-3x"></i><span class="sr-only"> Memuat Data...</span>'
      },
      "searching": true,
      "aLengthMenu": [
        [10, 40, 60, -1],
        [10, 40, 60, "All"]
      ],
      "iDisplayLength": 10,
      "order": [],
      "ajax": {
        "url": "<?php echo site_url('iri/riclaporan/lap_rencana_plg_h_1_dt_ajax') ?>",
        "type": "POST",
        "data": function(data) {
          data.date = $('#date').val();
        },
        "dataSrc": function(data) {
          if (data.vdata) {
            // console.log(data);
            $("#jml_krg12").text(data.jml_krg12);
            $("#jml_h_1").text(data.jml_h_1);
            $("#perhitungan_result").text(((data.jml_krg12 != 0 && data.jml_h_1 != 0) ? ((((data.jml_krg12) / (data.jml_h_1)) * 100).toFixed(1)) : '0.0') + '%');
            return data.vdata;
          }
          $("#jml_krg12").text(0);
          $("#jml_h_1").text(0);
          $("#perhitungan_result").text('0.0%');
          return [];
        },
        "error": function(jqXHR, textStatus, errorThrown) {
          ferrorDT();
          toastr.options.progressBar = true;
          toastr.error('Please try again or contact your administrator.', 'Error!', {
            timeOut: 7000
          });
        },
      },
      "columns": [{
        "data": "no_row"
      }, {
        "data": "nm_pasien"
      }, {
        "data": "no_medrec"
      }, {
        "data": "nmruang"
      }, {
        "data": "nm_user_verif"
      }, {
        "data": "tgl_vm1"
      }, {
        "data": "time_vm1"
      }, {
        "data": "tgl_keluar"
      }, {
        "data": "jam_keluar"
      }, {
        "data": "kondisi"
      }],
      "columnDefs": [{
        // "targets": [0], //first column / numbering column
        "orderable": false, //set not orderable
      }, ],
      "dom": 'Bfrtip',
      "buttons": [
        'pageLength', 'copy', 'csv', 'excel'
        // , 'pdf', 'print'
      ]
    });

    $('#btn-filter').click(function() { //button filter event click
      data_table.ajax.reload(); //just reload table
    });

    function ferrorDT() {
      data_table.clear().draw();
      $(".dataTables_processing").css("display", "none");
    }
  });
</script>

<?php
$this->load->view("layout/footer_left");
?>