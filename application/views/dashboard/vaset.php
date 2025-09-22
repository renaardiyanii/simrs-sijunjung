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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="d-flex flex-wrap">
                            <h4 class="card-title"><br><b>Laporan Aset</b></h4>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                                <thead style="border: 2px solid black; font-weight: bold;">
                                <tr style="border: 2px solid black;">
                                    <td style="border: 2px solid black; vertical-align: middle;" width="5%"><center>#</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Nomor Aset</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Nama Aset</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Kondisi</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Merk</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Lokasi Aset</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Tanggal Perolehan</center></td>
                                    <td style="border: 2px solid black; vertical-align: middle;"><center>Harga</center></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--<div class="col-md-12">
            <div class="card card-outline-primary">
                <div class="card-body chart-responsive">
                    <div class="col-sm-12">
                        <div class="form-inline">
                            <div class="form-group">
                                <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                                <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                                <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_poli()"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="chart" id="container" style="height: 450px;width: 100%;"></div>
                    <div class="overlay" id="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
    <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>

    $(function() {
        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('dashboard/data_aset'); ?>",
            columns: [
                { data: "no" },
                { data: "no_asset" },
                { data: "description" },
                { data: "kondisi" },
                { data: "merk" },
                { data: "lokasi" },
                { data: "tgl_perolehan" },
                { data: "harga" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]]
        } );
    });
    // setInterval(intervalSetting, 3000);
</script>

<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>