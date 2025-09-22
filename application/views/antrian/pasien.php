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
    <title>ANTRIAN PENDAFTARAN PASIEN | RSAL MINTOHARDJO</title>
    <!-- Bootstrap Core CSS -->    
    <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap3/css/bootstrap.min.css'); ?>">
    <script src="<?php echo site_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>      
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
        .btn-bpjs{
              display: inline-block;
              text-decoration: none;
              background: #ff4040;
              color: rgb(82, 142, 150);
              width: 122px;
              font-size: 20px;
              height: 120px;
              line-height: 120px;
              margin-bottom: 15px;
              border-radius: 50%;
              text-align: center;
              vertical-align: middle;
              overflow: hidden;
              box-shadow: inset 0px 3px 0 rgba(255,255,255,0.3), 0 3px 3px rgba(0, 0, 0, 0.3);
              font-weight: bold;
              border-bottom: solid 3px #e22626;
              text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.65);
              transition: .4s;
          }

          .btn-bpjs:active{
              -ms-transform: translateY(1px);
              -webkit-transform: translateY(1px);
              transform: translateY(1px);
              box-shadow: 0 0 2px rgba(0, 0, 0, 0.35);
              border-bottom: none;
          }

          .btn-anggota{
              display: inline-block;
              text-decoration: none;
              background: #0783d3;
              color: rgb(82, 142, 150);
              width: 122px;
              font-size: 20px;
              height: 120px;
              line-height: 120px;
              margin-bottom: 15px;
              border-radius: 50%;
              text-align: center;
              vertical-align: middle;
              overflow: hidden;
              box-shadow: inset 0px 3px 0 rgba(255,255,255,0.3), 0 3px 3px rgba(0, 0, 0, 0.3);
              font-weight: bold;
              border-bottom: solid 3px #344d81;
              text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.65);
              transition: .4s;
          }

          .btn-anggota:active{
              -ms-transform: translateY(1px);
              -webkit-transform: translateY(1px);
              transform: translateY(1px);
              box-shadow: 0 0 2px rgba(0, 0, 0, 0.35);
              border-bottom: none;
          }

          .btn-fisio{
              display: inline-block;
              text-decoration: none;
              background: #00A86B;
              color: rgb(82, 142, 150);
              width: 122px;
              font-size: 20px;
              height: 120px;
              line-height: 120px;
              margin-bottom: 15px;
              border-radius: 50%;
              text-align: center;
              vertical-align: middle;
              overflow: hidden;
              box-shadow: inset 0px 3px 0 rgba(255,255,255,0.3), 0 3px 3px rgba(0, 0, 0, 0.3);
              font-weight: bold;
              border-bottom: solid 3px #007e50;
              text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.65);
              transition: .4s;
          }

          .btn-fisio:active{
              -ms-transform: translateY(1px);
              -webkit-transform: translateY(1px);
              transform: translateY(1px);
              box-shadow: 0 0 2px rgba(0, 0, 0, 0.35);
              border-bottom: none;
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
function cetak_antrian(jns_pasien) {
      var windowUrl = '<?php echo base_url();?>antrian/cetak_antrian/'+jns_pasien;
      window.open(windowUrl,'p');
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
    <br>
    <div class="row">
      <div class="col-md-12 text-center">        
        <h3 style="color: #fffd56;">- PENGAMBILAN NOMOR ANTRIAN PENDAFTARAN -</h3>
        <h3 style="color: #fffd56;">( Pukul 06:00 - 11:00 WIB )</h3>
        <br>
        <br>

      </div>
    </div>
    <div class="col-md-12 bg-antrian" style="padding: 20px;">      
      <div class="row">      
        <div class="row vdivide">
          <div class="col-sm-4 text-center">
            <a href="javascript:void(0)" onclick="cetak_antrian('bpjs')" class="btn-bpjs"></a>
            <h4 style="font-size: 20px;color: #fffd56;">Tekan tombol MERAH untuk mengambil nomor antrian PASIEN BPJS dan ASKES</h4><br>
          </div>
          <div class="col-sm-4 text-center">  
            <a href="javascript:void(0)" onclick="cetak_antrian('anggota')" class="btn-anggota"></a>   
            <h4 style="font-size: 20px;color: #fffd56;">Tekan tombol BIRU untuk mengambil nomor antrian ANGGOTA TNI,PNS TNI,POLRI DAN KELUARGA</h4>
          </div>
          <div class="col-sm-4 text-center">
            <a href="javascript:void(0)" onclick="cetak_antrian('fisio')" class="btn-fisio"></a> 
            <h4 style="font-size: 20px;color: #fffd56;">Tekan tombol HIJAU untuk mengambil nomor antrian FISIOTHERAPI 1-6</h4>
          </div>
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



