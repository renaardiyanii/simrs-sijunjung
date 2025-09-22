<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else if ($role_id == 37) {
        $this->load->view("layout/header_dashboard");
    } else {
        $this->load->view("layout/header_horizontal");
    }

    function addcard($role, $roles, $title, $icon="fa-money", $iconcolor="red", $link="#" ) {
        if(in_array($role, $roles) ){ 
            echo "<div class=\"col-6 col-sm-6 col-md-6 col-lg-3\">
                    <a href=\"$link\">
                        <div class=\"card\">
                            <div class=\"row\">
                                <div class=\"col-md-12\">
                                    <div class=\"social-widget\">
                                        <div class=\"soc-header\" style=\"background: $iconcolor;\"><i class=\"fa $icon \"></i></div>
                                        <div class=\"soc-content\">
                                            <div class=\"col-md-12 b-r\">
                                                <span class=\"progress-description\">
                                                <b> $title </b>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>";
        }
    }
?>

<!-- Main content -->
<section class="content">

    <!-- Box 1 -->
    <div class="row">
        <?php
            // addcard($role_id, [1,53,52,37,49],"PENDAPATAN KESELURUHAN");
            // addcard($role_id, [1,53,52,37,49],"PENDAPATAN PELAYANAN PASIEN", "fa-dollar", "#00FF00",site_url('dashboard/pendapatan'));
            addcard($role_id, [1,51,52,37,1025],"KUNJUNGAN POLIKLINIK", "fa-bar-chart", "blue",site_url('dashboard/poliklinik'));
            addcard($role_id, [1,51,52,37,1025],"DATA PER <br/>POLIKLINIK", "fa-line-chart", "orange",site_url('dashboard/poli'));
            addcard($role_id, [1,51,52,37,1025],"10 DIAGNOSA TERBANYAK", "fa-area-chart", "green",site_url('dashboard/top_ten_diagnosa'));
            

            if($role_id == 1042 || $role_id == 1043 || $role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 37 || $role_id == 1011 || $role_id == 1025){
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
         if($role_id == 1 || $role_id == 1025)
            {
        ?>
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
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
        </div> -->
        <?php
            }

            if($role_id == 1 || $role_id == 50 || $role_id == 52 || $role_id == 37 || $role_id == 37){
        ?>
        <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/farmasi'); ?>">
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
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/farmasi_pembelian'); ?>">
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
        </div> -->
        <?php
            }

            if($role_id == 1){
                // || $role_id == 50 || $role_id == 37 || $role_id == 37){
            
        ?>
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/farmasi_amprah'); ?>">
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
        </div> -->
        <?php
            }

            if($role_id == 1 || $role_id == 50 || $role_id == 52 || $role_id == 37 || $role_id == 37){
        ?>
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/farmasi_stok'); ?>">
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
        </div> -->
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 56 || $role_id == 37){
        ?>
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/lab'); ?>">
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
        </div> -->
        <?php
            }

            if($role_id == 1 || $role_id == 51 || $role_id == 52 || $role_id == 56 || $role_id == 37 ){
        ?>
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/rad'); ?>">
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
        </div> -->
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
            if($role_id == 1 || $role_id == 37 || $role_id == 52 || $role_id == 1025){
        ?>
        <!-- <div class="col-6 col-sm-6 col-md-6 col-lg-3">
            <a href="<?php echo site_url('dashboard/cari_pasien'); ?>">
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
        </div> -->
        <?php
            }
        ?>
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