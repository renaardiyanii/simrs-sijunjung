<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= $title; ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?= base_url('assets/'); ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

  <!-- Custom styles for this template-->
  <link href="<?= base_url('assets/'); ?>css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/img/logo.png'); ?>">

</head>

<body class="bg-gradient-info" style="background: #26c6da">

  <title><?php echo $this->config->item('web_title'); ?></title>
<div class="container">

<!-- Outer Row -->
<div class="row justify-content-center">

  <div class="col-lg-12">

      <div class="card o-hidden border-0 shadow-lg my-5" style="background-image: url(<?= base_url('assets/img/gedung.jpg'); ?>); background-repeat: no-repeat; background-size: 100% 100%">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-6 d-none d-lg-block text-center">
                <!-- <img src="<?= base_url('assets/img/gedung.jpeg'); ?>" class="p-0 mt-4 rounded mx-auto d-block" width="250%" height="500em" alt=""> -->
            </div>
            <div class="col-lg-6">
              <div class="p-5">
                <div class="text-center">
                    <img src="<?= base_url('assets/img/logo.png'); ?>" alt="" width="150px" height="auto">
                    <br>
                    <br>
                    <h1 class="h4 text-gray-900 mb-4">Rumah Sakit Otak Dr. Drs. M. Hatta </h1>
                    <b><?php echo $this->config->item('web_title'); ?></b><br/><h4><?php echo $this->config->item('namars'); ?></h4>
                </div>
                <?= $this->session->flashdata('message'); ?>
                <form class="user" method="post" action="<?= base_url('user/login'); ?>">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Masuk
                  </button>
                </form>
                <hr>
                <div class="text-center">
                  <!--a class="small" href="change_password">Lupa Password ?</a-->
                </div>
                <div class="text-center">
                  <a class="small text-white">Copyright &copy; <?= date('Y'); ?> RSOMH</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

  </div>

</div>

</div>

  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?= base_url('assets/'); ?>js/sb-admin-2.min.js"></script>

</body>

</html>