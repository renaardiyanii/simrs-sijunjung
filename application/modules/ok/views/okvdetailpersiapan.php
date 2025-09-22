<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
//   var_dump($data_pasien_daftar_ulang->id_poli);
?> 

<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/survey/survey.jquery.min.js') ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>


 
<style type="text/css">

.title{
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
	<section class="content-header">
		<div class="row">
			<div class="col-sm-12">
				<div class="card card-outline-info">	
					<div class="card-header" align="center">
						<h4 class="text-white" align="center">Detail Persiapan Operasi</h4>
					</div>		
                </div>
            </div>   		
		</div>	
	</section>

    <div id="accordion">
        <div class="card mt-2 mb-2 ">
            <div class="list-group list-group-flush">

            		<div class="list-group-item" >
                        <div class="card-header" id="headingOne"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <div class="row">
                                <div class="img mr-3 ml-3 mt-2">
                                    <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($checklist_persiapan_operasi)?'check.png':'uncheck.png' ?>" alt="">
                                </div>
                                <div >
                                    <a >
                                    <span class="title" style="font-weight:medium;font-size:12pt">Checklist Persiapan Operasi</span>
                                    </a><br>
                                    <span class="subtitle"><?php echo ($checklist_persiapan_operasi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
                                </div>
                                
                            </div>
                        </div>
			
			

                        <div style="width:100%" id="collapseOne" class="collapse" aria-labelledby="headingOne"  data-parent="#accordion">
                            <div style="margin-left:50px"><a href="<?= base_url('ok/okcdaftar/checklist_persiapan_operasi_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak checklist Persiapan operasi </a></div>
                            <?php include('formulir\checklist_persiapan_operasi\checklist_persiapan_operasi.php'); ?>
                        </div>
		        	</div>

					<div class="list-group-item" >
                        <div class="card-header" id="headingTwo"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            <div class="row">
                                <div class="img mr-3 ml-3 mt-2">
                                    <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($asuhan_keperawatan_peri_operatif)?'check.png':'uncheck.png' ?>" alt="">
                                </div>
                                <div >
                                    <a >
                                    <span class="title" style="font-weight:medium;font-size:12pt">Asuhan Keperawatan Pre Operatif</span>
                                    </a><br>
                                    <span class="subtitle"><?php echo ($asuhan_keperawatan_peri_operatif)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
                                </div>
                                
                            </div>
                        </div>
			
			

                        <div style="width:100%" id="collapseTwo" class="collapse ml-2 mr-3 mt-1" aria-labelledby="headingTwo" aria-expanded="true" data-parent="#accordion">
                            <div style="margin-left:50px"><a href="<?= base_url('ok/okcdaftar/asuhan_keperawatan_pre_operatif_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Asuhan Keperawatan Pre Operatif </a></div>
                            <?php include('formulir\asuhan_keperawatan_pre_operatif\asuhan_keperawatan_pre_operatif.php'); ?>
                        </div>
		        	</div>

					<div class="list-group-item" >
                        <div class="card-header" id="headingThree"  data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            <div class="row">
                                <div class="img mr-3 ml-3 mt-2">
                                    <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($assesment_pra_anestesi)?'check.png':'uncheck.png' ?>" alt="">
                                </div>
                                <div >
                                    <a >
                                    <span class="title" style="font-weight:medium;font-size:12pt">Assesment Pre Anestesi</span>
                                    </a><br>
                                    <span class="subtitle"><?php echo ($assesment_pra_anestesi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
                                </div>
                                
                            </div>
                        </div>
			
			

                        <div style="width:100%" id="collapseThree" class="collapse  ml-2 mr-3 mt-1" aria-labelledby="headingThree" aria-expanded="true" data-parent="#accordion">
                            <div style="margin-left:50px"><a href="<?= base_url('ok/okcdaftar/assesment_pra_anestesi_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Assesment Pre Anestesi </a></div> 
                            <?php include('formulir\assesment_pra_anestesi\assesment_pra_anastesi.php'); ?>
                        </div>
		        	</div>

					<div class="list-group-item" >
                        <div class="card-header" id="headingFour"  data-toggle="collapse" data-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                            <div class="row">
                                <div class="img mr-3 ml-3 mt-2">
                                    <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($status_sedasi)?'check.png':'uncheck.png' ?>" alt="">
                                </div>
                                <div >
                                    <a >
                                    <span class="title" style="font-weight:medium;font-size:12pt">Status Sedasi</span>
                                    </a><br>
                                    <span class="subtitle"><?php echo ($status_sedasi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
                                </div>
                                
                            </div>
                        </div>
			
			

                        <div style="width:100%" id="collapseFour" class="collapse  ml-2 mr-3 mt-1" aria-labelledby="headingFour" aria-expanded="true" data-parent="#accordion">
                            <div style="margin-left:50px"><a href="<?= base_url('ok/okcdaftar/status_sedasi_view/'.$no_register.'/'.$id); ?>" target="_blank" class="btn btn-primary mt-4 mb-4"> Cetak Status Sedasi </a></div> 
                            <?php include('formulir\status_sedasi\status_sedasi.php'); ?>
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

