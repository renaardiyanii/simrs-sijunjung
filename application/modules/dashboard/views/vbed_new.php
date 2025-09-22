<?php
if ($role_id == 1) {
  $this->load->view("layout/header_left");
} else if ($role_id == 37) {
  $this->load->view("layout/header_dashboard");
} else {
  $this->load->view("layout/header_horizontal");
}
?>

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
              <h3 class="card-title"><br><b>Ruangan Rawat Inap</b></h3>
              <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6>           
                <div class="ml-auto">
                  <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4>
                </div> -->
            </div>
          </div>
          <br>
          <div class="col-md-12">
            <div class="vtabs customvtab">
              <ul class="nav nav-tabs tabs-vertical" role="tablist" style="width: 10%;">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#listRuanganKosong" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">List ruangan kosong</span> </a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#listRuanganTerisi" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">List ruangan terisi</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#summary" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Summary</span></a> </li>
              </ul>
              <!-- Tab panes -->
              <div class="tab-content" style="width: 90%;">
                <div class="tab-pane active" id="listRuanganKosong" role="tabpanel">
                  <div class="table-responsive">
                    <table class="table table-striped full-color-table full-info-table hover-table table-bordered" style="border: solid 2px #1e88e5;">
                      <thead>
                        <tr>
                          <th class="text-center" style="font-weight: bold; vertical-align: middle;">#</th>
                          <th style="font-weight: bold; vertical-align: middle;">Ruangan</th>
                          <th class="text-center" style="font-weight: bold;">VIP</th>
                          <th class="text-center" style="font-weight: bold;">Kelas 1</th>
                          <th class="text-center" style="font-weight: bold;">Kelas 2</th>
                          <th class="text-center" style="font-weight: bold;">Kelas 3</th>
                          <th style="font-weight: bold; vertical-align: middle;">Total</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $total_kosong = 0;
                        foreach ($bed as $rb => $item) {
                          $total_kosong += $item->tot_kosong;
                        ?>
                          <tr>
                            <td class="text-center"><?= $rb + 1  ?></td>
                            <td><?= $item->nmruang ?></td>
                            <td class="text-center"><?= ($item->vip_kosong) ? '<span class="label label-success">' . $item->vip_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls1_kosong) ? '<span class="label label-success">' . $item->kls1_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls2_kosong) ? '<span class="label label-success">' . $item->kls2_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls3_kosong) ? '<span class="label label-success">' . $item->kls3_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->tot_kosong) ? '<span class="label label-success">' . $item->tot_kosong . '</span>' : '' ?></td>
                          </tr>
                        <?php } ?>
                        <tr style="background: #1e88e5;">
                          <td colspan="6" class="text-right" style="font-weight: bold; color: white;">TOTAL</td>
                          <td class="text-center" style="font-weight: bold; color: white;"><?= $total_kosong ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="listRuanganTerisi" role="tabpanel">
                  <div class="table-responsive">
                    <table class="table table-striped full-color-table full-danger-table hover-table table-bordered" style="border: solid 2px #fc4b6c;">
                      <thead>

                        <tr>
                          <th class="text-center" style="font-weight: bold; vertical-align: middle;">#</th>
                          <th style="font-weight: bold; vertical-align: middle;">Ruangan</th>
                          <th class="text-center" style="font-weight: bold;">VIP</th>
                          <th class="text-center" style="font-weight: bold;">Kelas 1</th>
                          <th class="text-center" style="font-weight: bold;">Kelas 2</th>
                          <th class="text-center" style="font-weight: bold;">Kelas 3</th>
                          <th style="font-weight: bold; vertical-align: middle;">Total</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $total_isi = 0;
                        foreach ($bed as $rb => $item) {
                          $total_isi += $item->tot_isi;
                        ?>
                          <tr>
                            <td class="text-center"><?= $rb + 1  ?></td>
                            <td><?= $item->nmruang ?></td>
                            <td class="text-center"><?= ($item->vip_isi) ? '<span class="label label-danger">' . $item->vip_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls1_isi) ? '<span class="label label-danger">' . $item->kls1_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls2_isi) ? '<span class="label label-danger">' . $item->kls2_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls3_isi) ? '<span class="label label-danger">' . $item->kls3_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->tot_isi) ? '<span class="label label-danger">' . $item->tot_isi . '</span>' : '' ?></td>
                          </tr>
                        <?php } ?>
                        <tr style="background: #fc4b6c;">
                          <td colspan="6" class="text-right" style="font-weight: bold; color: white;">TOTAL</td>
                          <td class="text-center" style="font-weight: bold; color: white;"><?= $total_isi ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="summary" role="tabpanel">
                  <div class="table-responsive">
                    <table class="table table-striped full-color-table full-muted-table hover-table table-bordered" style="border: solid 2px #99abb4;">
                      <thead>

                        <tr>
                          <th rowspan="2" class="text-center" style="font-weight: bold; vertical-align: middle;">#</th>
                          <th rowspan="2" style="font-weight: bold; vertical-align: middle;">Ruangan</th>
                          <th colspan="2" class="text-center" style="font-weight: bold;">VIP</th>
                          <th colspan="2" class="text-center" style="font-weight: bold;">Kelas 1</th>
                          <th colspan="2" class="text-center" style="font-weight: bold;">Kelas 2</th>
                          <th colspan="2" class="text-center" style="font-weight: bold;">Kelas 3</th>
                          <th rowspan="2" style="font-weight: bold; vertical-align: middle;">Total Kosong</th>
                          <th rowspan="2" style="font-weight: bold; vertical-align: middle;">Total Isi</th>
                          <th rowspan="2" style="font-weight: bold; vertical-align: middle;">Total</th>
                        </tr>
                        <tr>
                          <th class="text-center" style="font-weight: bold;">Kosong</th>
                          <th class="text-center" style="font-weight: bold;">Isi</th>
                          <th class="text-center" style="font-weight: bold;">Kosong</th>
                          <th class="text-center" style="font-weight: bold;">Isi</th>
                          <th class="text-center" style="font-weight: bold;">Kosong</th>
                          <th class="text-center" style="font-weight: bold;">Isi</th>
                          <th class="text-center" style="font-weight: bold;">Kosong</th>
                          <th class="text-center" style="font-weight: bold;">Isi</th>
                        </tr>
                      </thead>
                      <tbody>

                        <?php
                        $total = 0;
                        $total_kosong = 0;
                        $total_isi = 0;
                        foreach ($bed as $rb => $item) {
                          $total += $item->total;
                          $total_kosong += $item->tot_kosong;
                          $total_isi += $item->tot_isi;
                        ?>
                          <tr>
                            <td class="text-center"><?= $rb + 1  ?></td>
                            <td><?= $item->nmruang ?></td>
                            <td class="text-center"><?= ($item->vip_kosong) ? '<span class="label label-success">' . $item->vip_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->vip_isi) ? '<span class="label label-danger">' . $item->vip_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls1_kosong) ? '<span class="label label-success">' . $item->kls1_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls1_isi) ? '<span class="label label-danger">' . $item->kls1_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls2_kosong) ? '<span class="label label-success">' . $item->kls2_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls2_isi) ? '<span class="label label-danger">' . $item->kls2_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls3_kosong) ? '<span class="label label-success">' . $item->kls3_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->kls3_isi) ? '<span class="label label-danger">' . $item->kls3_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->tot_kosong) ? '<span class="label label-success">' . $item->tot_kosong . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->tot_isi) ? '<span class="label label-danger">' . $item->tot_isi . '</span>' : '' ?></td>
                            <td class="text-center"><?= ($item->total) ? '<span class="label label-primary">' . $item->total . '</span>' : '' ?></td>
                          </tr>
                        <?php } ?>
                        <tr style="background: #99abb4;">
                          <td colspan="10" class="text-right" style="font-weight: bold; color: white;">TOTAL</td>
                          <td class="text-center" style="font-weight: bold; color: white;"><?= $total_kosong ?></td>
                          <td class="text-center" style="font-weight: bold; color: white;"><?= $total_isi ?></td>
                          <td class="text-center" style="font-weight: bold; color: white;"><?= $total ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>
  var site = "<?php echo site_url(); ?>";
  $(document).ready(function() {

  });

  $(function() {
    // objTable = $('#example').DataTable( {
    //     ajax: "<?php echo site_url('dashboard/data_bed'); ?>",
    //     columns: [
    //       { data: "rank" },
    //       { data: "kelas" },
    //       { data: "lokasi" },
    //       { data: "bed_kapasitas_real" },
    //       // { data: "bed_utama" },
    //       // { data: "bed_cadangan" },
    //       { data: "bed_isi" },
    //       { data: "bed_kosong" }
    //     ],
    //     columnDefs: [
    //       { targets: [ 0 ], visible: false }
    //     ],
    //     searching: false, 
    //     paging: false,
    //     bDestroy : true
    //   } );
  });
  // var intervalSetting = function () {
  //   objTable.ajax.reload();
  // };
  // setInterval(intervalSetting, 10000);
</script>

<?php
if ($role_id == 1) {
  $this->load->view("layout/footer_left");
} else {
  $this->load->view("layout/footer_horizontal");
}
?>