<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/'); ?>/favicon-rsomh/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/'); ?>/favicon-rsomh/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/'); ?>/favicon-rsomh/favicon-16x16.png">
  <link rel="manifest" type="image/png" sizes="16x16" href="<?= base_url('assets/'); ?>/favicon-rsomh/site.webmanifest"> -->
  <title><?= $title; ?></title>
  <link href="<?= base_url('assets/'); ?>plugins/bootstrap/css/bootstrap.login.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">
  <style>
    .lightRun {
      background: #1F6BCF;
      font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
      background: linear-gradient(to right, #3EB7CF 0%, #BDA6CF 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      -webkit-animation: ani 12s linear infinite;
    }

    @keyframes ani {
      from {
        background-position: -280px -94px;
      }

      to {
        background-position: 680px -94px;
      }
    }
  </style>
</head>

<body>

  <section id="wrapper">
    <div class="login-register" style="background-image:url(<?= base_url('assets/'); ?>img/rsud_sijunjung.png);">
      <div class="login-box card">
        <div class="card-body">
          <form class="form-horizontal form-material" id="loginform" method="post" action="<?= base_url('user/login'); ?>">
            <div class="text-center">
              <img src="<?= base_url('assets/img/logo.png'); ?>" class="m-b-10" width="50px" height="auto">
            </div>
            <!-- <h3 class="box-title text-center lightRun">e-Kamek</h3> -->
            <h3 class="box-title m-b-30 text-center">RSUD Ahmad Syafii Maarif </h3>
            <div class="form-group ">
              <div class="col-xs-12">
                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username" value="<?= set_value('username'); ?>">
                <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password">
                <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
              </div>
            </div>
            <div class="form-group text-center m-t-20">
              <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Masuk</button>
              </div>
            </div>
            <div class="form-group m-b-0">
              <div class="col-sm-12 text-center">
                <a class="small">Copyright &copy; 2021-<?= date('Y'); ?> RSUD Sijunjung</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </section>
  <script src="<?= base_url('assets/'); ?>plugins/jquery/jquery.min.js"></script>
  <script src="<?= base_url('assets/'); ?>js/jquery.slimscroll.js"></script>

</body>

</html>