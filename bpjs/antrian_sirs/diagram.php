<?php

include 'inc/koneksi.php'; 


$sql="	SELECT concat(right(max(`tgl_plyn`),2),'-',mid(max(`tgl_plyn`),6,2),'-',left(max(`tgl_plyn`),4)) as WAKTU
		FROM  `tbl_kunjungan_rs_detail` ";

$rs=mysqli_query($con,$sql);
if (!$rs)
	{exit("Error in SQL");}  

	while ($r = mysqli_fetch_array($rs,MYSQLI_ASSOC)){
		$waktu = strtoupper($r['WAKTU']);
	}
	
date_default_timezone_set("Asia/Jakarta");
$tanggal = date("Y-m-d"); 

if(isset($_POST["tanggal"])) {
$tanggal = $_POST['tanggal'];
$tgl = substr($_POST['tanggal'],-2,2);
$bln = substr($_POST['tanggal'],5,2);
$thn = substr($_POST['tanggal'],0,4);
$waktu = $tgl.'-'.$bln.'-'.$thn; 
//echo $waktu;
}

switch($_GET['aksi']){
default:

break;
case "irj":
?>
<div class="box box-solid box-info">
<div class="box-header">
<i class="fa fa-info"></i>Informasi Kunjungan Pasien Rawat Jalan
</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">
				<form id="form1"  name="form1" method="post" action="?module=diagram&aksi=irj">
					<div class="row">
					<label class="col-sm-1 control-label">Tanggal</label>
						<div class="col-md-3" >
							<input type="date" class="form-control"  value="<?php 
							date_default_timezone_set("Asia/Jakarta");
							echo $tanggal 
							?>" name="tanggal" id="tanggal">
						</div>
						<input type="submit" name="proses" id="proses" value="Proses" />
					</div>
				</form>
				
                <div class="row">
                    <div class="col-md-6" >
                        <div class="card" >
						
						
                             <!-- <iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_irj.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
							 <iframe src="./diagram/total_kunjungan_harian_irj.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card" >
						
						
                             <!--<iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_list_irj.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="20px" marginwidth="5px" style="margin-left:10px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="95%"></iframe> -->
							 <iframe src="./diagram/total_kunjungan_harian_list_irj.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="20px" marginwidth="5px" style="margin-left:10px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="95%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card" >
							<!-- <frame src="http://rsstrokebkt.com/webdashboard/diagram/jam_kunjungan_harian_irj.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
						
                             <iframe src="./diagram/jam_kunjungan_harian_irj.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>
</div><!-- /.row -->
<?php
break;
case "iri":
?>

<div class="box box-solid box-info">
<div class="box-header">
<i class="fa fa-info"></i>Informasi Kunjungan Pasien Rawat Inap
</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">
				<form id="form1"  name="form1" method="post" action="?module=diagram&aksi=iri">
					<div class="row">
					<label class="col-sm-1 control-label">Tanggal</label>
						<div class="col-md-3" >
							<input type="date" class="form-control"  value="<?php 
							date_default_timezone_set("Asia/Jakarta");
							echo $tanggal
							?>" name="tanggal" id="tanggal">
						</div>
						<input type="submit" name="proses" id="proses" value="Proses" />
					</div>
				</form>
				
                <div class="row">
                    <div class="col-md-6" >
                        <div class="card" >
						
						
                             <!-- <iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_iri.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
							 <iframe src="./diagram/total_kunjungan_harian_iri.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card" >
						
						
                             <!--<iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_list_iri.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="20px" marginwidth="5px" style="margin-left:10px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="95%"></iframe> -->
							 <iframe src="./diagram/total_kunjungan_harian_list_iri.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="20px" marginwidth="5px" style="margin-left:10px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="95%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card" >
							
							<!-- <frame src="http://rsstrokebkt.com/webdashboard/diagram/jam_kunjungan_harian_iri.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
						
                             <iframe src="./diagram/jam_kunjungan_harian_iri.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>
</div><!-- /.row -->

 <?php
break;
case "penunjang":
?>

<div class="box box-solid box-info">
<div class="box-header">
<i class="fa fa-info"></i>Informasi Kunjungan Pasien IGD & Penunjang
</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">
				<form id="form1"  name="form1" method="post" action="?module=diagram&aksi=penunjang">
					<div class="row">
					<label class="col-sm-1 control-label">Tanggal</label>
						<div class="col-md-3" >
							<input type="date" class="form-control"  value="<?php 
							date_default_timezone_set("Asia/Jakarta");
							echo $tanggal 
							?>" name="tanggal" id="tanggal">
						</div>
						<input type="submit" name="proses" id="proses" value="Proses" />
					</div>
				</form>
				
                <div class="row">
                    <div class="col-md-6" >
                        <div class="card" >
						
						
                             <!-- <iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_penunjang.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
							 <iframe src="./diagram/total_kunjungan_harian_penunjang.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card" >
						
						
                             <!--<iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_list_penunjang.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="20px" marginwidth="5px" style="margin-left:10px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="95%"></iframe> -->
							 <iframe src="./diagram/total_kunjungan_harian_list_penunjang.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="20px" marginwidth="5px" style="margin-left:10px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="95%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card" >
							
							<!-- <frame src="http://rsstrokebkt.com/webdashboard/diagram/jam_kunjungan_harian_igd.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
						
                             <iframe src="./diagram/jam_kunjungan_harian_igd.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe>
								<div class="footer">
                                    <hr>
                                    <div class="stats">
                                        <i class="fa fa-history"></i> 
										
                                    </div>
										diperbaharui pada tanggal: <?=$waktu?>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</div>
</div><!-- /.row -->
<?php
break;
case "dft_online":
?>

<div class="box box-solid box-info">
	<div class="box-header">
		<i class="fa fa-info"></i>Informasi Pendaftaran Online dan Offline Tahunan
	</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">
				
                <div class="row">
                    <div class="col-md-12" >
                        <div class="card" >
						
						
                             <!-- <iframe src="http://rsstrokebkt.com/webdashboard/diagram/total_kunjungan_harian_penunjang.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
							 <iframe src="./diagram/kunjungan_online.php" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="680px" scrolling="yes" width="100%"></iframe>
						
                        </div>
                    </div>
                </div>
			</div>
	</div>
</div><!-- /.row -->
<div class="box box-solid box-info">
	<div class="box-header">
		<i class="fa fa-info"></i>Informasi Pendaftaran Online dan Offline Semester
	</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card" >
							
							<!-- <frame src="http://rsstrokebkt.com/webdashboard/diagram/jam_kunjungan_harian_igd.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
						
                             <iframe src="./diagram/kunjungan_online_semester.php" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="680px" scrolling="yes" width="100%"></iframe>
	
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div><!-- /.row -->
<div class="box box-solid box-info">
	<div class="box-header">
		<i class="fa fa-info"></i>Informasi Pendaftaran Online dan Offline Triwulan
	</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card" >
							
							<!-- <frame src="http://rsstrokebkt.com/webdashboard/diagram/jam_kunjungan_harian_igd.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->
						
                             <iframe src="./diagram/kunjungan_online_triwulan.php" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="680px" scrolling="yes" width="100%"></iframe>
	
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div><!-- /.row -->
 <?php
break;
case "survey":
?>

<div class="box box-solid box-info">
<div class="box-header">
<i class="fa fa-info"></i>Informasi Indikator Kepuasan Masyarakat
</div>
<div class="box-body">
<div class="content">
            <div class="container-fluid">
				
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card" >
							<b>
							<ol type="number" start="1">
								<li>Laporan Survey Indeks Kepuasan Masyarakat Tahunan
									<iframe src="http://rsstrokebkt.com/module/survey/grafik_tahun.php" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="505px" scrolling="yes" width="805px"></iframe>
								</li>
								<li>Laporan Survey Indeks Kepuasan Masyarakat Semester
									<iframe src="http://rsstrokebkt.com/module/survey/grafik_semester.php" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="535px" scrolling="yes" width="805px"></iframe>
								</li>
								<li>Laporan Survey Indeks Kepuasan Masyarakat Triwulan
									<iframe src="http://rsstrokebkt.com/module/survey/grafik_triwulan.php" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="555px" scrolling="yes" width="805px"></iframe>
								</li>
							</ol>
							</b>
                            <!-- <iframe src="./diagram/jam_kunjungan_harian_igd.php?tanggal=<?=$waktu?>" border="0" framspacing="0" marginheight="0" marginwidth="5px" style="margin-left:5px; margin-right:5px;" vspace="0" hspace="0" frameborder="0" height="405px" scrolling="yes" width="100%"></iframe> -->

                        </div>
                        </div>
                    </div>
                </div>
				
            </div>
        </div>


</div>
</div><!-- /.row -->
<?php
break;}
?>