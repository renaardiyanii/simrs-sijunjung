<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else if ($role_id == 37){
    $this->load->view("layout/header_dashboard");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
    <style type="text/css">
        tbody > tr > td {
            border: 2px solid #000;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <!-- <header class="floating-header">
    <div class="floating-menu-btn">
      <div class="floating-menu-toggle-wrap">
        <div class="floating-menu-toggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </div>
    </div>
    <div class="main-navigation-wrap">
      <nav class="main-navigation" data-back-btn-text="Back">
        <ul class="menu">
          <li class="delay-1"><a href="<?php echo site_url('dashboard'); ?>">Menu Utama</a></li>
          <li class="delay-1"><a href="<?php echo site_url('Change_password'); ?>">Ganti Password</a></li>
          <li class="delay-2"><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header> -->
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-outline-primary">
                    <div class="card-footer">
                        <div class="col-sm-10">
                            <div class="form-inline">
                             <form id="formEx">
                                <div class="form-group">
                                   <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal"  required>&nbsp;
                                   <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir"  required>&nbsp;
                                    <button class="btn btn-primary btn-xs" type="button" id="btnCari" >Cari</button>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-block chart-responsive">
                        <!-- <p class="col-sm-2">Cari Data</p> -->
                        <!-- <div class="chart" id="obat" style="height: 450px;width: 100%;"></div> -->

                        <div class="table-responsive">
                        <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                            <thead style="border: 2px solid black; font-weight: bold;">
                            <tr style="border: 2px solid black;">
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">No</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Tgl Amprah</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Gudang Peminta</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Gudang Pengirim</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Jumlah Permintaan</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Jumlah Pengiriman</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 0; $total = 0;

                            ?>
                            </tbody>
                        </table>
                        </div>
                        <div class="overlay" id="overlay">
                            <!--<i class="fa fa-refresh fa-spin"></i>-->
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->

    </section><!-- /.content -->

<script type="text/javascript">
     var site = "<?php echo site_url();?>";
  $(document).ready(function() {
    $('#date_picker_awal').datepicker({
        format: "yyyy-mm-dd",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
    }); 
    $('#date_picker_akhir').datepicker({
        format: "yyyy-mm-dd",
        endDate: "current",
        autoclose: true,
        todayHighlight: true,
    }); 

        var objTable;

        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('dashboard/data_farmasi_amprah'); ?>",
            columns: [
                { data: "no" },
                { data: "tgl_amprah" },
                { data: "gd_peminta" },
                { data: "gd_distribusi" },
                { data: "permintaan" },
                { data: "pengiriman" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );

        $("#btnCari").click(function () {
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: $('#formEx').serialize(),
                url: "<?php echo site_url('dashboard/data_farmasi_amprah'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });
    });
</script>
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>