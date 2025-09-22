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
                <h4 class="card-title"><br><b>Ruangan Rawat Inap</b></h4>
                <!-- <h6 class="card-subtitle">Total Pasien Hari ini </h6>           
                <div class="ml-auto">
                  <h4 class="dashboard-heading">Total Pasien : <b id="total_pasien"></b></h4>
                </div> -->   
            </div>
          </div>
          <div class="col-md-12">
            <!-- <h4 class="card-title"><center>Ruangan Rawat Inap</center></h4>
            <h6 class="card-subtitle">Total Pasien Hari ini </h6> -->
            <div class="table-responsive">
              <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                    <thead style="border: 2px solid black;">
                    <tr style="border: 2px solid black;">
                        <td colspan="2" style="border: 2px solid black; vertical-align: middle; font-weight: bold;" align="right"><a href="<?=site_url('dashboard/bed/semua');?>"><b style="color:black">TOTAL PASIEN</b></a></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b><?=$kapasitas_tot?></b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b><?=$isi_tot?></b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b><?=$kosong_tot?></b></td>
                    </tr>
                    <tr style="border: 2px solid black; font-weight: bold;">
                        <!-- <td style="border: 2px solid black; vertical-align: middle;" align="center">#</td> -->
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>RUANG</b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>KELAS</b></td>
                        <!--<td>KAPASITAS REAL</td> -->
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>KAPASITAS</b></td>
                        <!--<td>CADANGAN</td> -->
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>ISI</b></td>
                        <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>KOSONG</b></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $kapasitas  =0;
                      $isi        =0;
                      $kosong     =0;
                      $lokasi      ='';
                      foreach ($bed as $row) {
                        if($lokasi==$row->lokasi){
                          echo '
                          <tr>
                            <td><b><center>'.$row->kelas.'</center></b></td>
                            <td><center>'.$row->bed_kapasitas_real.'</center></td>';
                            $jumlah_isi = 0;
                            $jumlah_kosong = 0;
                            $bed_kapasitas_real = $row->bed_kapasitas_real;
                            foreach ($pasien as $row_pasien) {
                              if($row->lokasi==$row_pasien->lokasi && $row->kelas==$row_pasien->kelas){
                                $jumlah_isi = $row_pasien->jumlah;
                                $jumlah_kosong = $bed_kapasitas_real-$jumlah_isi;
                              }
                            }
                            echo '<td><center>'.$jumlah_isi.'</center></td>';
                            echo '<td><center>'.$jumlah_kosong.'</center></td>';
                          echo'
                          </tr>';
                        }else{
                          $lokasi = $row->lokasi;
                          echo '
                          <tr style="border-top: 2px solid black;">
                            <td style="border-right: 2px solid black; vertical-align: middle; vertical: center;" rowspan="';
                            foreach ($ruang as $row_ruang) {
                              if($row->lokasi==$row_ruang->lokasi)
                                echo $row_ruang->jum;
                            }
                          echo '">
                              <a href="'.site_url('dashboard/bed').'/'.$row->lokasi.'"><b style="color:black">'.$row->lokasi.'</b></a>
                            </td>
                            <td><b><center>'.$row->kelas.'</center></b></td>
                            <td><center>'.$row->bed_kapasitas_real.'</center></td>';
                            $jumlah_isi = 0;
                            $jumlah_kosong = 0;
                            $bed_kapasitas_real = $row->bed_kapasitas_real;
                            foreach ($pasien as $row_pasien) {
                              if($row->lokasi==$row_pasien->lokasi && $row->kelas==$row_pasien->kelas){
                                $jumlah_isi = $row_pasien->jumlah;
                                $jumlah_kosong = $bed_kapasitas_real-$jumlah_isi;
                              }
                            }
                            echo '<td><center>'.$jumlah_isi.'</center></td>';
                            echo '<td><center>'.$jumlah_kosong.'</center></td>';
                          echo'
                          </tr>';
                        }
                
                      }
                      echo '<tr>
                                <td colspan="2" style="border: 2px solid black; vertical-align: middle; font-weight: bold;" align="right"><a href="'.site_url('dashboard/bed/semua').'"><b style="color:black">TOTAL PASIEN</b></a></td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>'.$kapasitas_tot.'</b></td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>'.$isi_tot.'</b></td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center"><b>'.$kosong_tot.'</b></td>
                          </tr>';

                    ?>
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</section><!-- /.content -->

<script type='text/javascript'>
  var site = "<?php echo site_url();?>";
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