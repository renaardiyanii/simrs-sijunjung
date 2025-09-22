<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?> 
<!-- <link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>"> -->
<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/survey/survey.jquery.min.js') ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/surveyjs/surveyjs.widgets.js'); ?>"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>
<style type="text/css">

	.demo-radio-button label{
		min-width:120px;
	}
	title{
		font-size:12pt;
		font-weight:bold;
	}
	.subtitle{
		font-size:9pt;
		font-weight:light;
	}

	.hr{
		background-color:gray;
		height:1px;
		width:22%;
		margin-left:4em;
		margin-right:4em;
		margin-bottom:2em;
	}
	.list-group-item{
		display:flex;
		flex-direction:column;
		align-items:flex-start;
	}

	.js-example-basic-single{
		z-index: 9999;
	}

</style>


	<?php include('okvdatapasien.php');?>	


	<div id="accordion">
        <div class="card mt-2 mb-2 ">
            <div class="list-group list-group-flush">

				<div class="list-group-item" >
					<div class="card-header" id="headingOne"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<div class="row">
							<div class="img mr-3 ml-3 mt-2">
								<img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($checklist_keselamatan_operasi)?'check.png':'uncheck.png' ?>" alt="">
							</div>
							<div>
								<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Cheklist Keselamatan Pasien Dikamar Operasi</span>
								</a><br>
								<span class="subtitle"><?php echo ($checklist_keselamatan_operasi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
							</div>
						
						</div>
					</div>
			
			

					<div style="width:100%" id="collapseOne" class="collapse  ml-2 mr-3 mt-1" aria-labelledby="headingOne"  data-parent="#accordion">
					   <div style="margin-left:50px"><a href="<?= base_url('ok/okchasil/checklist_keselamatan_operasi_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak checklist keselamatan operasi </a></div>
						<?php include(FCPATH.'application\modules\ok\views\formulir\checklist_keselamatan_operasi\checklist_keselamatan_pasien_operasi.php'); ?>
					</div>
				</div>

				<div class="list-group-item" >
					<div class="card-header" id="headingTwo"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
						<div class="row">
							<div class="img mr-3 ml-3 mt-2">
								<img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($laporan_operasi)?'check.png':'uncheck.png' ?>" alt="">
							</div>
							<div>
								<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Laporan Operasi</span>
								</a><br>
								<span class="subtitle"><?php echo ($laporan_operasi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
							</div>
						
						</div>
					</div>
			
			

					<div style="width:100%" id="collapseTwo" class="collapse  ml-3 mr-3 mt-1" aria-labelledby="headingTwo"  data-parent="#accordion">
						<div style="margin-left:50px"><a href="<?= base_url('ok/okchasil/laporan_operasi_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Laporan Operasi </a></div>
						<?php include('formulir\laporan_operasi\laporan_operasi.php'); ?>
					</div>
				</div>

				<div class="list-group-item" >
					<div class="card-header" id="headingThree"  data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
						<div class="row">
							<div class="img mr-3 ml-3 mt-2">
								<img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($laporan_anestesi)?'check.png':'uncheck.png' ?>" alt="">
							</div>
							<div>
								<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Laporan Anestesi</span>
								</a><br>
								<span class="subtitle"><?php echo ($laporan_anestesi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
							</div>
						
						</div>
					</div>
			
			

					<div style="width:100%" id="collapseThree" class="collapse  ml-3 mr-3 mt-1" aria-labelledby="headingThree"  data-parent="#accordion">
						<div style="margin-left:50px"><a href="<?= base_url('ok/okchasil/laporan_anestesi_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Laporan Anestesi </a></div>
						<?php include('formulir\laporan_anestesi\laporan_anestesi.php'); ?>	
					</div>
				</div>
				
			</div>

	
		</div>
	</div>

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 

