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
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo site_url('assets/images/mintohardjo.ico'); ?>">
    <title><?php echo $this->config->item('web_title'); ?></title>
    <!-- Bootstrap Core CSS -->    
    <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap3/css/bootstrap.min.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>      
    <!-- You can change the theme colors from here -->
    <!-- <link href="css/colors/blue.css" id="theme" rel="stylesheet"> -->
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
    body {
        height: 100%;
        margin: 0;
        padding: 0;
        padding-top: 15px;
        padding-bottom: 15px;
        background-color: #0783d3;
    }
  </style>
  <style>


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
        /* IE 6 */
        * html #footer {
           position:absolute;
           top:expression((0-(footer.offsetHeight)+(document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight)+(ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop))+'px');
        }
        .content_panggil {
          padding: 10px;
        }
        .bg-antrian {
            color: #fff;
            background-color: #344d81;
            border: 0;
        }
        .row.vdivide [class*='col-']:not(:last-child):after {
          background: #e0e0e0;
          width: 1px;
          content: "";
          display:block;
          position: absolute;
          top:0;
          bottom: 0;
          right: 0;
          min-height: 70px;
        }



  </style>
<script type="text/javascript">
  $(document).ready(function() {
    show_time('clock');
    show_date('current_date');
  });
  function show_time(id)
{
        date = new Date;
        year = date.getFullYear();
        month = date.getMonth();
        months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'Jully', 'August', 'September', 'October', 'November', 'December');
        d = date.getDate();
        day = date.getDay();
        days = new Array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        h = date.getHours();
        if(h<10)
        {
                h = "0"+h;
        }
        m = date.getMinutes();
        if(m<10)
        {
                m = "0"+m;
        }
        s = date.getSeconds();
        if(s<10)
        {
                s = "0"+s;
        }
        result = ''+h+':'+m+':'+s;
        document.getElementById(id).innerHTML = result;
        setTimeout('show_time("'+id+'");','1000');
        return true;
}
  function show_date(id)
{
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
</script>  
</head>

<body>
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-9">  
          <div class="clearfix">
            <img src="<?php echo site_url('assets/images/logos/Logo.png'); ?>" alt="Logo RSAL Mintohardjo" width="100" style="float: left;margin-right: 10px;">            
            <h3 style="font-size: 30px;color: #fffd56;">Rumah Sakit Angkatan Laut Dr. Mintohardjo</h3>
            <p style="font-size: 14px;color: #fffd56;">Jl. Bendungan Hilir No.17A, RT.4/RW.3, Bend. Hilir, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10210</p>
          </div>                      
        </div>
        <div class="col-md-3">
        <section class="box text-center">
          <h1 style="letter-spacing: 3px;margin: 0;" id="clock"></h1>
          <p style="font-size: 15px;margin-bottom: 0;" id="current_date"></p>
        </section>
        </div>
    </div>
    <br>
    <div class="row">        
        <div class="col-md-4">  
          <div class="panel bg-antrian text-center" style="margin-bottom: 5px;">
              <div class="panel-body bg-antrian">               
                  <h1 class="card-text" style="color: #fffd56;">LOKET 1</h1>                
              </div>              
          </div> 
          <div class="panel text-center">
              <div class="panel-heading">
                  <h1 class="panel-title">NOMOR ANTRIAN</h1>
              </div>
              <div class="panel-body bg-antrian">
                <div class="content_panggil">
                  <h1 style="font-size: 54px;">D 001</h1>
                </div> 
              </div>              
          </div>                   
        </div>
        <div class="col-md-8">
          <iframe width="420" height="244" src="https://www.youtube.com/embed/XGSy3_Czz8"></iframe>
        </div>
    </div>
    <br>
    <div class="col-md-12 bg-antrian" style="padding: 20px;">      
      <div class="row">      
        <div class="row vdivide">
          <div class="col-sm-3 text-center">
            <h4 style="font-size: 16px;color: #fffd56;">LOKET 1</h4>
            <h1 style="margin-bottom: 20px;">D 16</h1>
            <h4 style="font-size: 16px;color: #fffd56;">DEWO</h4>
          </div>
          <div class="col-sm-3 text-center">
            <h4 style="font-size: 16px;color: #fffd56;">LOKET 2</h4>
            <h1 style="margin-bottom: 20px;">E 12</h1>
            <h4 style="font-size: 16px;color: #fffd56;">SHINTA</h4>
          </div>
          <div class="col-sm-3 text-center">
            <h4 style="font-size: 16px;color: #fffd56;">LOKET 3</h4>
            <h1 style="margin-bottom: 20px;">E 13</h1>
            <h4 style="font-size: 16px;color: #fffd56;">WAHYU</h4>
          </div>
          <div class="col-sm-3 text-center">
            <h4 style="font-size: 16px;color: #fffd56;">LOKET 4</h4>
            <h1 style="margin-bottom: 20px;">D 18</h1>
            <h4 style="font-size: 16px;color: #fffd56;">AZHAR</h4>
          </div>
        </div>
      </div>
        <!-- <div class="col-md-3">     
            <div class="panel bg-antrian text-center">
              <div class="panel-heading">
                  <h3 class="panel-title">LOKET 1</h3>
              </div>
              <div class="panel-body bg-antrian">
                <div class="content_panggil">
                  <h1 class="card-text">D 001</h1>
                </div> 
              </div>
              <div class="panel-footer bg-antrian">DEWO</div>
            </div>                
        </div>
        <div class="col-md-3">  
            <div class="card text-center">
              <div class="card-header">
                LOKET 2
              </div>
              <div class="card-body">
                <div class="content_panggil">
                  <h1 class="card-text">E 001</h1>
                </div>                
              </div>
              <div class="card-footer text-muted">
                Wahyu
              </div>
            </div>                    
        </div>
        <div class="col-md-3">  
            <div class="card text-center">
              <div class="card-header">
                LOKET 3
              </div>
              <div class="card-body">
                <div class="content_panggil">
                  <h1 class="card-text">F 001</h1>
                </div>                
              </div>
              <div class="card-footer text-muted">
                Shinta
              </div>
            </div>                    
        </div>
        <div class="col-md-3">  
            <div class="card text-center">
              <div class="card-header">
                LOKET 4
              </div>
              <div class="card-body">
                <div class="content_panggil">
                  <h1 class="card-text">F 001</h1>
                </div>                
              </div>
              <div class="card-footer text-muted">
                Junaedi
              </div>
            </div>                    
        </div> -->
 
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="footer">
        <marquee>
          RUMAH SAKIT ANGKATAN LAUT Dr. MINTOHARJO "Melayani dengan Amanah, Niat Mulia, Hati Ikhlas dan Senyum"
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
   
</body>

</html>



