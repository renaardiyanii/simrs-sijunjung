<?php 
$data_awal_medis = (isset($data_igd->formjson)?json_decode($data_igd->formjson):'');
// var_dump($ppa_sebagai);die();
$history_cppt = $history_soap_pasien_ri->num_rows()!=0?$history_soap_pasien_ri->result():null;
$last_record_cppt = $history_cppt?$history_cppt[0]:null; // get_last_record in cppt
$ppanya = '';
switch($ppa_sebagai)
{
	case 'dokter_dpjp':
		$ppanya = 'Dokter DPJP';
		break;
	case 'case_manager':
		$ppanya = 'Case Manager';
		break;
	case 'dokter_jaga':
		$ppanya = 'Dokter Jaga';
		break;
	case 'dokter_ruangan':
		$ppanya = 'Dokter Ruangan';
		break;
	case 'perawat':
		$ppanya = "Perawat";
		break;
	case 'Farmatologi':
		$ppanya = "Farmasi";
		$last_record_cppt = null;
		break;
	case 'Fisioterapis':
		$ppanya = "Fisioterapi";
		$last_record_cppt = null;
		break;
	default:
		$ppanya = '';
		break;
}
// $ppa_sebagai = 'dokter_dpjp';
?>

<script>
$(function(){
	$('.ppa').val("<?= $ppanya ?>").trigger('change');

	
});

function acceptCppt(id_cppt,opsi="",no_ipd="")
{
	$.ajax({  
		url: opsi!==""?"<?php echo base_url(); ?>iri/rictindakan/update_cppt/all":"<?php echo base_url(); ?>iri/rictindakan/update_cppt",                         
		method:"POST",
		data: opsi!==""?{
			id : no_ipd
		}:{
			id : id_cppt
		},
		dataType: 'json', 
		success: function(data)  
		{ 
			new swal({
				title: "Selesai",
				text: "Data berhasil disimpan",
				type: "success",
				showCancelButton: false,
				closeOnConfirm: false,
				showLoaderOnConfirm: true
			},
			function () {
				window.location.reload();
			});
			
		},
		error:function(event, textStatus, errorThrown) {
			new swal("Error","Data gagal disimpan.", "error"); 
			console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		}  
	});
}

$(document).on("submit","#form_cppt",function(e){
		e.preventDefault();

		$.ajax({  
			url:"<?php echo base_url(); ?>iri/rictindakan/insert_cppt",                         
			method:"POST",  
			data: new FormData(this),  
			contentType: false,  
			cache: false,  
			processData:false,  
			success: function(data)  
			{ 
				new swal({
					title: "Selesai",
					text: "Data berhasil disimpan",
					type: "success",
					showCancelButton: false,
					closeOnConfirm: false,
					showLoaderOnConfirm: true
				},
				function () {
					window.location.reload();
				});
				
			},
			error:function(event, textStatus, errorThrown) {
				new swal("Error","Data gagal disimpan.", "error"); 
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}  
		});

	});

	let base_url = "<?= base_url('emedrec/C_emedrec_iri/catatan_medis_awal_rawat_inap/'.$no_ipd.'/'.$data_pasien[0]['no_cm'].'/'.$data_pasien[0]['no_medrec']) ?>" 
</script>

<div class="" style="width:100%;" >
		<span>Form CPPT</span>
		<button class="btn btn-primary ml-3" onclick="window.open(base_url)" target="_blank">Assesment Awal Medis</button>
	</div>
	<hr>
<br>

<div id="form_assesment_medik">
<form method="POST" id="form_cppt" class="form-horizontal"> 		
	<div class="form-group row">
		<label for="prop" class="col-md-2 col-form-label">Sebagai</label>
		<div class="col-md-8">
			<select id="prop" class="select2 ppa form-control" name="role"  required style="width: 100%">
				<option value="">-PPA-</option>
				<option value="Dokter DPJP">Dokter DPJP</option>
				<option value="Dokter Jaga">Dokter Jaga</option>
				<option value="Dokter Ruangan">Dokter Ruangan</option>
				<option value="Dokter Tambahan">Dokter Tambahan</option>
				<option value="Perawat">Perawat</option>
				<option value="Farmasi">Farmasi</option>
				<option value="Gizi">Gizi</option>
				<option value="Fisioterapi">Fisioterapi</option>
				<option value="Case Manager">Case Manager</option>
				
			</select>
		</div>
	</div>

	<?php
	// if($ppa_sebagai == "perawat"){
	?>
<!-- 
	<div class="form-group row">
		<label for="prop" class="col-md-2 col-form-label">Pemeriksa</label>
		<div class="col-md-8">
			<select id="prop" class="autocomplete-1 form-control" name="pemeriksa"  required style="width: 100%">
				<option value="">-Sebagai-</option>
			</select>
		</div>
	</div> -->
	
	<?php //} ?>

	<div class="form-group row">
	<?php if ($history_soap_pasien_ri->num_rows() == 0) { ?>
		<div class="col-sm-6">
			<label class="col-form-label" for="ket_awal_medis">Keterangan awal medis</label><br>
			<textarea rows="5" cols="60" name="ket_awal_medis" id="awal_medis_cppt"><?= isset($data_awal_medis->anamnesis)?$data_awal_medis->anamnesis:'' ?></textarea>
		</div>
	<?php }else{ ?>	
	<?php } ?>	
		<div class="col-sm-6">
			<label class="col-form-label" for="subjective">Subjective</label><br>
			<textarea rows="5" cols="60" name="subjective" id="subjective_cppt"><?= $last_record_cppt?$last_record_cppt->subjective:'' ?></textarea>
		</div>
		
	</div>
	<div class="form-group row">
		<div class="col-sm-6">
			<label class="col-form-label" for="objective">Objective</label><br>
			<textarea rows="5" cols="60" name="objective" id="objective_cppt"><?= $last_record_cppt?str_replace('\n',PHP_EOL,explode('@',$last_record_cppt->objective)[0]):'' ?></textarea>
		</div>
		<div class="col-sm-6">
			<label class="col-form-label" for="assesment">Assesment</label><br>
			<textarea rows="5" cols="60" name="assesment" id="assesment_cppt"><?= $last_record_cppt?$last_record_cppt->assesment:'' ?></textarea>
		</div>
		
	</div>

	<div class="form-group row">
		<div class="col-sm-6">
			<label class="col-form-label" for="instruksi">Instruksi</label><br>
			<textarea rows="5" cols="60" name="instruksi" id="instruksi_cppt"></textarea>
		</div>
		<div class="col-sm-6">
			<label class="col-form-label" for="plan">Plan</label><br>
			<textarea rows="5" cols="60" name="plan" id="plan_cppt"><?= $last_record_cppt?$last_record_cppt->plan:'' ?></textarea>
		</div>
		
	</div>
	<input type="hidden" name="id" id="id_soap" value="<?= $ppa_sebagai == "perawat"?$last_record_cppt?$last_record_cppt->id:'':"" ?>">
	<input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
	<div class="form-group row">
		<div class="col-sm-8">
			<button type="submit" class="btn btn-primary" id="btn-assesment-simpan">Simpan</button>
		</div>
	</div>

</form>
</div>


<div>
	<table class="table table-hover table-striped table-bordered data-table" id="dataTables-assesment" style="width:100%;" style="table-layout: fixed;">
		<thead>
		<tr>
			<th>No.</th>
			<th>Tgl Pemeriksaan</th>
			<th>Nama Pemeriksa</th>
			<th>Role</th>
			<th>Subjective</th>
			<th style="<?= $ppa_sebagai == 'dokter_dpjp'?'text-align:center':'' ?>;">Aksi&nbsp;
			<?php
			 if($ppa_sebagai == 'dokter_dpjp')
			 { 
			 ?>
			 <button class="btn btn-primary btn-sm" onclick="acceptCppt(<?= $value->id ?>,'all','<?= $value->no_ipd ?>')">Verifikasi Semua</button>
			 <?php 
			  }
			 ?>
			</th>
		</tr>
		</thead>
		<tbody>
			<?php
			$i = 1;
			if($history_soap_pasien_ri->num_rows()){
				foreach($history_soap_pasien_ri->result() as $value){
					$json_value = json_encode($value);
			?>
				<tr>
					<td><?= $i++; ?></td>
					<td><?= date('d-m-Y H:i:s',strtotime($value->tanggal_pemeriksaan)) ?></td>
					<td><?= isset($value->nama_pemeriksa)?$value->nama_pemeriksa:'' ?></td>
					<td><?= isset($value->role)?$value->role:'' ?></td>
					<td><?=  (strlen($value->subjective) >20)?substr($value->subjective , 0, 20) . '...':$value->subjective; ?></td>
					<!-- <td><button type="button"  class="btn btn-primary dataparsingAssesment" data-toggle="modal" data-value='<?php //echo json_encode($value); ?>' data-target="#exampleAssesment">Detail CPPT </button></td> -->
					<td>
						<div class="row" style="<?= $ppa_sebagai == 'dokter_dpjp'?'margin-left:20px':'margin-left:10px' ?>;">
							<button type="button" style="margin-right:5px;"  class="btn btn-info btn-sm dataparsingcppt" data-value='<?= $json_value ?>' > Terapkan Data </button>&nbsp;
							<?php
							if($ppa_sebagai == 'dokter_dpjp')
							{ 
							?>
							<button class="btn btn-info btn-sm" onclick="acceptCppt(<?= $value->id ?>)"> Verifikasi</button>
							<?php
							}
							?>
						</div>
					</td>
				
				</tr>
			
			<?php
				}
			}else{
			?>
				<tr>  
					<td style="text-align:center;" colspan="6">Tidak ada Data</td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
	</div>

	<!-- <div class="modal fade" id="exampleAssesment" tabindex="-1" role="dialog" aria-labelledby="exampleAssesmentLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Assesment Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<?php //echo  createTextAreaForm('subjective_assesment_','Subjective','s_1'); ?>
			<?php //echo  createTextAreaForm('assesment_dokter_assesment_','Assesment','s_2'); ?>
			<?php //echo  createTextAreaForm('pemeriksaan_penunjang_dokter_assesment_','Pemeriksaan Penunjang Dokter','s_3'); ?>
			<?php //echo  createTextAreaForm('diagnosis_kerja_dokter_assesment_','Diagnosis Kerja','s_4'); ?>
			<?php //echo  createTextAreaForm('objective_assesment_','Objective','s_5'); ?>
			<?php //echo  createTextAreaForm('plan_dokter_assesment_','Plan','s_6'); ?>
			<?php //echo  createTextAreaForm('terapi_tindakan_dokter_assesment_','Terapi / Tindakan','s_7'); ?>
			<?php //echo  createTextAreaForm('diagnosis_banding_dokter_assesment_','Diagnosis Banding','s_8'); ?>

			<?php //echo  createTextAreaForm('assesment_adime_new','Assesment','s_9'); ?>
			<?php //echo  createTextAreaForm('diagnosa_adime_new','Diagnosa','s_10'); ?>
			<?php //echo  createTextAreaForm('intervensi_adime_new','Intervensi','s_11'); ?>
			<?php //echo  createTextAreaForm('monitoring_adime_new','Monitoring','s_12'); ?>
			<?php //echo  createTextAreaForm('evaluasi_adime_new','Evaluasi','s_13'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div> -->



<script>

var showmenuassesment = 0;

$(document).ready(function(){	



	
$(document).on("click", ".dataparsingcppt", function () {
	var value = $(this).data('value');
	console.log(value.subjective);
	$("#subjective_cppt").html(value.subjective);
	$("#objective_cppt").html(value.objective);
	$("#assesment_cppt").html(value.assesment);
	$("#plan_cppt").html(value.plan);
	$("#instruksi_cppt").html(value.instruksi);
});

$('.autocomplete-1').select2({
	placeholder: 'Ketik Nama Perawat',
	minimumInputLength: 1,
	language: {
		inputTooShort: function(args) {
		return "Ketik Nama Perawat";
		},
		noResults: function() {
		return "Perawat tidak ditemukan.";
		},
		searching: function() {
		return "Mencari.....";
		}
	},
	ajax: {
		type: 'GET',
		url: '<?php echo base_url().'iri/rictindakan/select2_perawat'; ?>',
		dataType: 'JSON',        
		delay: 250,
		processResults: function (data) {
		return {
			results: data
		};
		},
		cache: true
	}
});

$('#example').DataTable( {
		ajax: "<?php echo site_url('admin/userList'); ?>",
		columns: [
			{ data: "id" },
			{ data: "username" },
			{ data: "name" },
			{ data: "role" },
			{ data: "ppa" },
			{ data: "dokter" },
			{ data: "plus" },
			{ data: "poli" },
			{ data: "ruang" },
			{ data: "hakakses" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		]	
	} );

$('.dataparsingAssesment').on('click',function(){
	var value = $(this).data('value');
	// console.log(value);
	if (value.assesment_adime){
		$("#s_1").hide();
		$("#s_2").hide();
		$("#s_3").hide();
		$("#s_4").hide();
		$("#s_5").hide();
		$("#s_6").hide();
		$("#s_7").hide();
		$("#s_8").hide();
		$("#s_9").show();
		$("#s_10").show();
		$("#s_11").show();
		$("#s_12").show();
		$("#s_13").show();
		$("#assesment_adime_new_assesment").val(value.assesment_adime);
		$("#diagnosa_adime_new_assesment").val(value.diagnosa_adime);
		$("#intervensi_adime_new_assesment").val(value.intervensi_adime);
		$("#monitoring_adime_new_assesment").val(value.monitoring_adime);
		$("#evaluasi_adime_new_assesment").val(value.evaluasi_adime);
	}else{
		$("#s_1").show();
		$("#s_2").show();
		$("#s_3").show();
		$("#s_4").show();
		$("#s_5").show();
		$("#s_6").show();
		$("#s_7").show();
		$("#s_8").show();
		$("#subjective_assesment__assesment").val(value.subjective);
		$("#objective_assesment__assesment").val(value.objective);
		$("#assesment_dokter_assesment__assesment").val(value.assesment);
		$("#pemeriksaan_penunjang_dokter_assesment__assesment").val(value.pemeriksaan_penunjang);
		$("#diagnosis_kerja_dokter_assesment__assesment").val(value.diagnosis_kerja);
		$("#plan_dokter_assesment__assesment").val(value.plan);
		$("#terapi_tindakan_dokter_assesment__assesment").val(value.terapi_tindakan);
		$("#diagnosis_banding_dokter_assesment__assesment").val(value.diagnosis_banding);
		$("#s_9").hide();
		$("#s_10").hide();
		$("#s_11").hide();
		$("#s_12").hide();
		$("#s_13").hide();
	}

	
});


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

// });



</script>									
									


									
									

