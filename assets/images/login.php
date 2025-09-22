

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
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/mintohardjo.ico"> -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/images/mmc.ico'); ?>">
    <title><?php echo $this->config->item('web_title'); ?></title>
    <!-- Bootstrap Core CSS -->
    <!-- <link href="../assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>">
    <!-- Custom CSS -->
    <!-- <link href="css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?php echo site_url('assets/left/css/style.css'); ?>">
    <!-- You can change the theme colors from here -->
    <!-- <link href="css/colors/blue.css" id="theme" rel="stylesheet"> -->
    <link  id="theme" rel="stylesheet" href="<?php echo site_url('assets/left/css/colors/blue.css'); ?>">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
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
    <section id="wrapper">
        <div class="login-register" style="background-image:url(<?php echo site_url('assets/images/login_mmc.jpg'); ?>);">        
            <div class="login-box card">
            <div class="card-block">
                <?php 
                  $attributes = array('class' => 'form-horizontal form-material', 'id' => 'loginform');
                  echo form_open('login', $attributes);
                ?>
                    <a href="javascript:void(0)" class="text-center db">
                      <img class="img-responsive" style="max-width:120px;" src="<?php echo base_url()."assets/images/logos/".$this->config->item('logo_url'); ?>" alt="Home" />
                      <br/>
                      <b><?php echo $this->config->item('web_title'); ?></b><br/><h4><?php echo $this->config->item('namars'); ?></h4>
                    </a>                      
                    <?php echo validation_errors();?>
                    <h3 class="box-title m-b-20">Sign In</h3>                        
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Username" name="username" id="username" autofocus> </div>
                    </div>
                    <div class="form-group m-b-10">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" placeholder="Password" name="password" id="password" value="">
                    </div>
                    <div class="form-group text-center m-t-20 m-b-0">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
          </div>
        </div>
        
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
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
</body>

</html>

