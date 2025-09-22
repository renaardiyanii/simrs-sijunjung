<?php 
$this->load->view('layout/header_form');
?>
<?php
	$subjective_perawat = "";
	$subjective_dokter = "";
	$objective_perawat = "";
	$objective_dokter = "";
	$assesment_perawat = "";
	$assesment_dokter = "";
	$plan_perawat = "";
	$plan_dokter = "";
if($pelayan == "PERAWAT"){
	if(isset($soap_pasien_rj->assesment_perawat)){
		$assesment_perawat.= $soap_pasien_rj->assesment_perawat;
	}
	if(isset($soap_pasien_rj->plan_perawat)){
		$plan_perawat.= $soap_pasien_rj->plan_perawat;
	}
	if(isset($soap_pasien_rj->subjective_perawat)){
		$subjective_perawat.= $soap_pasien_rj->subjective_perawat;
	}
	if(isset($soap_pasien_rj->objective_perawat)){
		$objective_perawat.=$soap_pasien_rj->objective_perawat;
	}
}else{
	if(isset($soap_pasien_rj->assesment_dokter)){
		$assesment_dokter.= $soap_pasien_rj->assesment_dokter;
	}
	if(isset($soap_pasien_rj->plan_dokter)){
		$plan_dokter.=$soap_pasien_rj->plan_dokter;
	}
	if(isset($soap_pasien_rj->subjective_dokter)){
		$subjective_dokter.=$soap_pasien_rj->subjective_dokter;
	}
	if(isset($soap_pasien_rj->objective_dokter)){
		$objective_dokter.=$soap_pasien_rj->objective_dokter;
	}

}
?>

<div class="card m-5">
		<div class="card-header">
			<div class="container-fluid d-flex justify-content-between" style="width:100%;">
				<h5>Evaluasi</h5>
			</div>
		</div>

		<div id="form_assesment_medik">
			<form method="POST" id="form_cppt" class="form-horizontal"> 
				<div class="card-body">
					
					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label" for="subjective">Subjective</label><br>
							<textarea rows="5" cols="60" name="<?= $pelayan == "PERAWAT"?'subjective_perawat':'subjective_dokter' ?>" id="subjective_cppt"><?= $pelayan == "PERAWAT"?str_replace('<br>',PHP_EOL,$subjective_perawat):str_replace('<br>',PHP_EOL,$subjective_dokter) ?></textarea>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label" for="objective">Objective</label><br>
							<textarea rows="5" cols="60" name="<?= $pelayan == "PERAWAT"?'objective_perawat':'objective_dokter' ?>" id="objective"><?= $pelayan == "PERAWAT"?str_replace('<br>',PHP_EOL,$objective_perawat):str_replace('<br>',PHP_EOL,$objective_dokter); ?></textarea>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-6">
							<label class="col-form-label" for="assesment_perawat">Analisa</label><br>
							<textarea rows="5" cols="60" name="<?= $pelayan == "PERAWAT"?'assesment_perawat':'assesment_dokter' ?>" id="assesment"><?= $pelayan == "PERAWAT"?$assesment_perawat:str_replace('<br>',PHP_EOL,$assesment_dokter); ?></textarea>
						</div>
						<div class="col-sm-6">
							<label class="col-form-label" for="plan">Plan</label><br>
							<textarea rows="5" cols="60" name="<?= $pelayan == "PERAWAT"?'plan_perawat':'plan_dokter' ?>" id="plan"><?= $pelayan == "PERAWAT"?$plan_perawat:str_replace('<br>',PHP_EOL,$plan_dokter); ?></textarea>
						</div>
					</div>
				</div>

				<div class="card-footer">
					<input type="hidden" class="form-control" value="<?= $data_pasien_daftar_ulang->no_register ?>" name="no_register">
					<div class="form-group row">
						<div class="col-sm-8">
							<button type="submit" class="btn btn-primary" id="btn-assesment-simpan">Simpan</button>
						</div>
					</div>
				</div>
					

			</form>
			</div>
		</div>

	
</div>









<script>

var showmenuassesment = 0;

$(document).ready(function(){	



if(showmenuassesment == 1){
	$("#form_assesment_medik").hide();
}
});

function showhideassesment(){
	if(showmenuassesment == 1){
		$("#form_assesment_medik").hide();
		showmenuassesment = 0;
	}else{
		$("#form_assesment_medik").show();
		showmenuassesment = 1;
	}
}

$(document).on("submit","#form_cppt",function(e){
	e.preventDefault();
	// alert('asd');
	// document.getElementById("btn-assesment-simpan").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
	$.ajax({  
		url:"<?php echo base_url('ird/rdcpelayanan/insert_cppt'); ?>",                         
		method:"POST",  
		data: new FormData(this),  
		contentType: false,  
		cache: false,  
		processData:false,  
		success: function(data)  
		{ 
			location.reload();
		}
	});
});



</script>									
									


									
									

