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

    <!-- Box 1 -->
    <div class="row">
        <?php
            if($role_id == 1 || $role_id == 53 || $role_id == 52 || $role_id == 37 || $role_id == 49){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="#">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: red;"><i class="fa fa-money "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                         <b> PENDAPATAN KESELURUHAN </b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 53 || $role_id == 52 || $role_id == 37 || $role_id == 49){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/pendapatan'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #00FF00;"><i class="fa fa-dollar"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                         <b> PENDAPATAN PELAYANAN PASIEN </b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/poliklinik'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: blue;"><i class="fa fa-bar-chart "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                          <b>KUNJUNGAN POLIKLINIK</b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/poli'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: orange;"><i class="fa fa-line-chart "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                         <b> DATA PER POLIKLINIK</b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/diagnosa'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: green;"><i class="fa fa-area-chart "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                          <b> 10 DIAGNOSA TERBANYAK</b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

          <!-- /.col -->
          <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/pasien'); ?>">
              <div class="card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="social-widget">
                            <div class="soc-header box-linkedin"><i class="fa fa-user "></i></div>
                            <div class="soc-content">
                                <div class="col-md-12 b-r">
                                    <span class="progress-description">
                                      Pasien Per Tanggal
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </a>
          </div> -->
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/bed'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #1a1a1a;"><i class="fa fa-bed "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                         <b> MONITORING BED </b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

         // if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 37)
         if($role_id == 1 )
            {
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/pulang_ranap'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #40ffff;"><i class="fa fa-calendar-check-o"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                        <span class="progress-description">
                                         <b> PASIEN PULANG RANAP </b>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 50 || $role_id == 52 || $role_id == 37 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/farmasi'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #800080;"><i class="fa fa-medkit "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                 <b> 10 OBAT TERBANYAK</b>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 50 || $role_id == 52 || $role_id == 37 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/farmasi_pembelian'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #A0522D;"><i class="fa fa-cart-plus"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                               <b>   PEMBELIAN OBAT </b>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 ){
                // || $role_id == 50 || $role_id == 37 || $role_id == 37){
            
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/farmasi_amprah'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #B8860B;"><i class="fa fa-share-alt"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                <b> AMPRAH & DISTRIBUSI RUANGAN </b>
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 50 || $role_id == 52 || $role_id == 37 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/farmasi_stok'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #CC0000;"><i class="fa fa-plus-circle"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  LAPORAN STOK
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 37 || $role_id == 52 || $role_id == 55 || $role_id == 57){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/urikes'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #FFC000;"><i class="fa fa-stethoscope"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  URIKES
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 56 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/lab'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #4FCA00;"><i class="fa fa-user-md "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  LABORATORIUM
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 56 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/rad'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #4A2A00;"><i class="fa fa-heartbeat "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  RADIOLOGI
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 37 || $role_id == 52){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/indikator_kinerja'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #6495ED;"><i class="fa fa-tasks"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  INDIKATOR KINERJA
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }

            if($role_id == 1 || $role_id == 37 || $role_id == 52){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/cari_pasien'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: blue;"><i class="fa fa-users"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  CARI PASIEN
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/aset'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: black;"><i class="fa fa-cubes"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  ASET
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('Dashboard/kepegawaian'); ?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header" style="background: #8bd4e4;"><i class="fa fa-user-circle"></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  KEPEGAWAIAN
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <?php
            }
        ?>
        <!-- /.col -->
        <!--<div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php /*echo site_url('Dashboard/farmasi_obat'); */?>">
                <div class="card">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="social-widget">
                                <div class="soc-header box-linkedin"><i class="fa fa-medkit "></i></div>
                                <div class="soc-content">
                                    <div class="col-md-12 b-r">
                                <span class="progress-description">
                                  Obat Expired
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>-->
    </div>
    <!-- /.row -->

    <!-- =========================================================== -->
</section><!-- /.content -->
<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>