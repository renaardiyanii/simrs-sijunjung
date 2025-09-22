<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?>
<script type='text/javascript'>
var intervalSetting = function () { 
location.reload(); 
}; 
setInterval(intervalSetting, 120000);

	$(function() {
		// $('#date_picker').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// });  
	});
	
	$(document).ready(function() {
		// $('#date_picker1').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// }); 
		// $('#date_picker2').datepicker({
		// 	format: "yyyy-mm-dd",
		// 	endDate: '0',
		// 	autoclose: true,
		// 	todayHighlight: true,
		// }); 
		$('#tabel_kwitansi').DataTable();
		$(".select2").select2();
	
	//-----------------------------------------------Data Table
		$('#tabel_tindakan').DataTable();
		$('#tabel_lab').DataTable();
		$('#tabel_cetak_lab').DataTable();
		$('#tabel_cetak_rad').DataTable();
		$('#tabel_farm').DataTable();
		$('#tabel_cetak_farm').DataTable();
	} );

</script>

	
<?php
	echo $this->session->flashdata('message_cetak'); 
?>

<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-group row">
					<div class="col-md-8">
						<?php echo form_open('user/cuser/penunjang/');?>
							<div class="form-group ">
								<input type="date" id="date_picker1" class="form-control" placeholder="Tanggal Awal" name="date0">
								<input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="date1">
								
									<button class="btn btn-primary" type="submit">Cari</button>
								
							</div><!-- /input-group -->
						<?php echo form_close();?>
					</div><!-- /.col-lg-6 -->
						
				</div>
					<div class="card card-outline-success">
						
						
						<!--<div class="panel-body" style="display:block;overflow:auto;">
						<br/>-->
						<ul class="nav nav-tabs customtab" role="tablist">
							<li class="nav-item text-center"> 
                                	<a class="nav-link active" data-toggle="tab" href="#tabRad" role="tab"><span class="hidden-xs-down">Radiologi</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabLab" role="tab"><span class="hidden-xs-down">Laboratorium</span></a> 
                                </li>  
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabPa" role="tab"><span class="hidden-xs-down">Patologi Anatomi</span></a> 
                                </li>                              
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabFarmasi" role="tab"><span class="hidden-xs-down">Farmasi</span></a> 
                                </li>
                            </ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tabRad" role="tabpanel"> 
								<div class="p-20">  						
									<?php include('user_rad.php');  ?>
								</div>
							</div> <!-- end div tab tindakan -->
							
							<div id="tabLab" class="tab-pane p-20">	
								<div class="p-20">    						
									<?php include('user_lab.php');  ?>
								</div>	
							</div> <!-- end div tab diagnosa -->
							
							<div id="tabPa" class="tab-pane p-20">	
								<div class="p-20">    						
									<?php include('user_pa.php');  ?>
								</div>	
							</div>

							<div id="tabFarmasi" class="tab-pane p-20">
								<div class="p-20">
									<?php include('user_farmasi.php');  ?>
								</div>
							</div> <!-- end div tab lab -->
				</div>
			</div>
		</section>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>