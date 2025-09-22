<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/images/mintohardjo.ico'); ?>">
     <title><?php echo $this->config->item('web_title'); ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/jqueryui/jquery-ui.css'); ?>">
    
    <!-- Custom CSS -->
    <link href="<?php echo site_url('assets/left/css/style.css'); ?>" rel="stylesheet">    
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/morrisjs/morris.css'); ?>">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo site_url('assets/left/css/colors/blue.css'); ?>" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  <!--   <link rel="stylesheet" href="<?php echo site_url('assets/plugins/datatables/jquery.dataTables.min.css'); ?>"> -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/jquery.autocomplete.css'); ?>">
    <link href="<?php echo site_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>">
    <!--alerts CSS -->
    <link href="<?php echo site_url('assets/plugins/sweetalert/sweetalert.css'); ?>" rel="stylesheet" type="text/css">
<style type="text/css">
    html,body {
        height: 100%;
        margin: 0;
        padding: 0;
        padding-top: 10px;
        padding-bottom: 15px;
        background-color: #0783d3;
    }
        .box
        {
          width: 100%;
          font-size: 1.25rem; /* 20 */
          background-color: #344d81;
          padding: 15px; /* 40 */
          color: #ffffff;
        }
        .footer
        {
          /*position: fixed;*/
          bottom: 0;
          width: 100%;
          font-size: 1.25rem; /* 20 */
          background: rgba(16, 40, 88, .6);
          padding: 10px; /* 40 */
          color: #fffd56;
        }
        #footer {
          position:fixed;
          left:0px;
          bottom:0px;           
          width:100%;           
          font-size: 16px; /* 20 */
          background: rgba(16, 40, 88, .6);
          padding: 10px; /* 40 */
          padding-top: 20px;
          color: #fffd56;
        }
        .table thead th, .table th {            
            border: 1px solid #eceeef;
        }

        th {
            background-color : lightblue;
            color : black;
        }
        td {
            font-size: 22px;
            color : black;
            padding: 1px !important;
        }
        /* IE 6 */
        * html #footer {
           position:absolute;
           top:expression((0-(footer.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
        }       



  </style>
 
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/jqueryui/jquery-ui.js'); ?>"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/tether.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/hmis.js'); ?>"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo site_url('assets/left/js/jquery.slimscroll.js'); ?>"></script>
    <!--Wave Effects -->
    <script src="<?php echo site_url('assets/left/js/waves.js'); ?>"></script>
    <!--Menu sidebar -->
    <script src="<?php echo site_url('assets/left/js/sidebarmenu.js'); ?>"></script>
    <!--stickey kit -->
    <script src="<?php echo site_url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo site_url('assets/left/js/custom.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/moment/moment.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/clockpicker/dist/jquery-clockpicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/timepicker/bootstrap-timepicker.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- This is data table -->
    <script src="<?php echo site_url('assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
   <!--  <script src="<?php echo site_url('assets/plugins/datatables/dataTables.bootstrap.js'); ?>"></script> -->
    <script src="<?php echo site_url('assets/plugins/jquery.autocomplete.js'); ?>"></script>
    <!-- Sweet-Alert  -->
    <script src="<?php echo site_url('assets/plugins/sweetalert/sweetalert.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sweetalert/jquery.sweet-alert.custom.js'); ?>"></script>
    <!-- Mask Money -->
    <script src="<?php echo site_url('assets/js/jquery.maskMoney.js'); ?>" type="text/javascript"></script>
    <!-- Validation-->
    <script src="<?php echo site_url('assets/plugins/jquery-validation/js/jquery.validate.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/validation.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo site_url('assets/js/validator.js'); ?>" type="text/javascript"></script>
    <!-- SELECT2 -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/select2/dist/css/select2.min.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/select2/dist/js/select2.full.min.js'); ?>"></script>
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/icheck/skins/all.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/icheck/icheck.min.js'); ?>"></script>

    <script src="<?php echo site_url('assets/plugins/morrisjs/morris.min.js'); ?>"></script> 
    <script src="<?php echo site_url('assets/plugins/raphael/raphael-min.js'); ?>"></script>
    <script type="text/javascript">
        var baseurl = "<?php print base_url(); ?>";
        $(document).ready(function() {
            show_time('clock');
            show_date('current_date');
        });
        function show_time(id)  {
            date = new Date;
            year = date.getFullYear();
            month = date.getMonth();
            months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
            d = date.getDate();
            day = date.getDay();
            days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
            h = date.getHours();
            if(h<10) {
                h = "0"+h;
            }
            m = date.getMinutes();
            if(m<10) {
                m = "0"+m;
            }
            s = date.getSeconds();
            if(s<10) {
                s = "0"+s;
            }
            result = ''+h+':'+m+':'+s;
            document.getElementById(id).innerHTML = result;
            setTimeout('show_time("'+id+'");','1000');
            return true;
        }
        function show_date(id) {
            date = new Date;
            year = date.getFullYear();
            month = date.getMonth();
            months = new Array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
            d = date.getDate();
            day = date.getDay();
            days = new Array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            result = ''+days[day]+', '+d+' '+months[month]+' '+year+'';
            document.getElementById(id).innerHTML = result;
            setTimeout('show_date("'+id+'");','1000');
            return true;
        }
        function cetak_antrian(jns_pasien) {
            var windowUrl = '<?php echo base_url();?>antrian/cetak_antrian/'+jns_pasien;
            window.open(windowUrl,'p');
        }
    </script>

  </head>

  <body class="card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
          <div id="container-fluid" class="container-fluid">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-9">  
          <div class="clearfix">
            <img src="<?php echo site_url('asset/images/logos/logo.png'); ?>" alt="Logo RSAL Mintohardjo" width="120" style="float: left;margin-right: 10px;">            
            <h3 style="font-size: 30px;color: #fffd56;padding-top: 17px;">Rumah Sakit Angkatan Laut Dr. Mintohardjo</h3>
            <p style="font-size: 15px;color: #fffd56;margin-bottom: 8px;">Jl. Bendungan Hilir No. 17, Jakarta Pusat, Daerah Khusus Ibukota Jakarta</p>
            <p style="font-size: 15px;color: #fffd56;">Kode Pos : 10210 Telp : (021) 5703081 – 85 (021) 5749037 – 40 Email : rsalminto@gmail.com</p>
          </div>                      
        </div>
        <div class="col-md-3">
        <section class="box text-center">
          <h1 style="letter-spacing: 3px;margin: 0;color: #fff;" id="clock"></h1>
          <p style="font-size: 15px;margin-bottom: 0;" id="current_date"></p>
        </section>
        </div>
    </div>
    <hr>   
    <div class="row">
        <div class="col-md-12">   
            <div class="ribbon-wrapper card" style="min-height: 493px;">
                <div class="ribbon ribbon-info">INFORMASI JADWAL DOKTER</div>
                <div class="ribbon-content">
                    
<?php 
        $array = json_decode(json_encode($jadwal_dokter), True);
        $data_poli=array_column($array, 'id_poli');
?>
  <div id="carouselExampleCaptions1" class="carousel slide" data-ride="carousel" >
    <ol class="carousel-indicators">
    <?php $count1=0; foreach($poli as $row1){ 
            
                        //Klo data tdk kosong, tampilkan
          if (in_array($row1->id_poli, $data_poli)) { ?>
                <li data-target="#carouselExampleCaptions1" data-slide-to="<?php echo $count1;?>" <?php if($count1==0){ echo 'class="active"';}?> ></li>
    <?php }}?>
    </ol>
    <div class="carousel-inner">
                    <?php $count=0; foreach($poli as $row1){ 
            
                        //Klo data tdk kosong, tampilkan
                        if (in_array($row1->id_poli, $data_poli)) { 
                    ?>
                        <div class="carousel-item <?php if($count==0){echo 'active';}?>">
                        <h3 align="center" style="color:black;" ><b><?php echo $row1->nm_poli ?></b></h3>
                        <table class="table table-bordered" >
                                        <thead>
                                            <tr>
                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">No</th>
                                                <th rowspan="2" style="vertical-align:middle;">DOKTER</th>
                                                <th>HARI</th>  
                                                <th class="text-center">JAM</th> 
                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">LOKASI</th>
                                            </tr>                                            
                                        </thead>
                                        <tbody>                                            
                                            <?php 
                                                $count++;
                                                $poli=""; 
                                                $i=1; 
                                                foreach ($jadwal_dokter as $item) { 
                                                    if($item->nm_poli==$row1->nm_poli) {
                                                    echo '<tr>';
                                                        echo '<td class="text-center">'.$i++.'</td>';
                                                        echo '<td><b>&nbsp;&nbsp;'.$item->nm_dokter.'</b></td>';
                                                        echo '<td><b>&nbsp;&nbsp;'.$item->hari.'</b></td>';
                                                        echo '<td class="text-center"><b>'.$item->awal . ' - ' . $item->akhir.'</b></td>';
                                                        echo '<td class="text-center"><b>'.$item->lokasi.'</b></td> ';
                                                    echo '</tr>';
                                                    }
                                                }
                                            ?>                                         
                                        </tbody>
                                    </table>    
                            
                        <br />
                        <!--<div class="carousel-caption d-none d-md-block">
                          <h4><b>Poliklinik : <?php //echo $row1->nm_poli ?></b></h4>
                        </div>-->
                        </div>
                <?php 
                        }?><?php
                    }
                    ?>
                
                </div>
                <a class="carousel-control-prev" href="#carouselExampleCaptions1" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions1" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
        </div>
    <div class="row">
      <div class="col-md-12">
        <div id="footer">
        <marquee>
          RUMAH SAKIT ANGKATAN LAUT Dr. MINTOHARDJO "Melayani dengan Amanah, Niat Mulia, Hati Ikhlas dan Senyum"
        </marquee>
        </div>
      </div>
    </div>
  </div>
    
    
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/tether.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo site_url('assets/left/js/jquery.slimscroll.js'); ?>"></script>
    <!--Wave Effects -->
    <script src="<?php echo site_url('assets/left/js/waves.js'); ?>"></script>
    <!--Menu sidebar -->
    <script src="<?php echo site_url('assets/left/js/sidebarmenu.js'); ?>"></script>
    <!--stickey kit -->
    <script src="<?php echo site_url('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/plugins/sparkline/jquery.sparkline.min.js'); ?>"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo site_url('assets/left/js/custom.min.js'); ?>"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo site_url('assets/plugins/styleswitcher/jQuery.style.switcher.js'); ?>"></script>
   

<?php 
if(!isset($_GET['rel'])){
?>
          </div>
          <!-- ============================================================== -->
          <!-- End Container fluid  -->
          <!-- ============================================================== -->
        <!-- ============================================================== -->
        
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
  </body>

</html>
<?php 
}
?>  


