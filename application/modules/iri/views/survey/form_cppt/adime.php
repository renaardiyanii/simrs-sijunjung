<?php 
$history_cppt = $history_soap_pasien_ri->num_rows()!=0?$history_soap_pasien_ri->result():null;
$last_record_cppt = $history_cppt?$history_cppt[0]:null; // get_last_record in cppt
?>

<div class="d-flex justify-content-between" style="width:100%;" >
		<span>Form CPPT</span>
		<!-- <button class="btn btn-primary" onclick="showhideassesment()">Tambah Data</button> -->
	</div>
	<hr>
<br>
<?php 
// var_dump($soap_pasien_ri); 
?>
<div id="form_assesment_medik">
<form method="POST" id="form_adime" class="form-horizontal"> 		

	<div class="form-group row">
		<div class="col-sm-6">
			<label class="col-form-label" for="assesment_adime">Assesment</label><br>
			<textarea rows="5" cols="60" name="assesment_adime" id="assesment_adime"><?= $last_record_cppt?$last_record_cppt->assesment_adime:'' ?></textarea>
		</div>
		<div class="col-sm-6">
			<label class="col-form-label" for="diagnosa_adime">Diagnosa</label><br>
			<textarea rows="5" cols="60" name="diagnosa_adime" id="diagnosa_adime"><?= $last_record_cppt?$last_record_cppt->diagnosa_adime:'' ?></textarea>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-sm-6">
			<label class="col-form-label" for="intervensi_adime">Intervensi</label><br>
			<textarea rows="5" cols="60" name="intervensi_adime" id="intervensi_adime"><?= $last_record_cppt?$last_record_cppt->intervensi_adime:'' ?></textarea>
		</div>
		<div class="col-sm-6">
			<label class="col-form-label" for="monitoring_adime">Monitoring</label><br>
			<textarea rows="5" cols="60" name="monitoring_adime" id="monitoring_adime"><?= $last_record_cppt?$last_record_cppt->monitoring_adime:'' ?></textarea>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-6">
			<label class="col-form-label" for="evaluasi_adime">Evaluasi</label><br>
			<textarea rows="5" cols="60" name="evaluasi_adime" id="evaluasi_adime"><?= $last_record_cppt?$last_record_cppt->evaluasi_adime:'' ?></textarea>
		</div>
	</div>


	
	<input type="hidden" name="id" value="<?= $last_record_cppt?$last_record_cppt->id:'' ?>">
	<input type="hidden" name="role" value="<?= $ppa_sebagai ?>">
	<input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
	<div class="form-group row">
		<div class="col-sm-8">
			<button type="submit" class="btn btn-primary" >Simpan</button>
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
			<th>Aksi</th>
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
					<td><button type="button"  class="btn btn-info dataparsingcppt" data-value='<?= $json_value ?>' > Terapkan Data </button></td>
				
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

<script>

var showmenuassesment = 0;

$(document).ready(function(){	

$(document).on("click", ".dataparsingcppt", function () {
	var value = $(this).data('value');
	console.log(value)
	$("#assesment_adime").html(value.assesment_adime);
	$("#diagnosa_adime").html(value.diagnosa_adime);
	$("#intervensi_adime").html(value.intervensi_adime);
	$("#monitoring_adime").html(value.monitoring_adime);
	$("#evaluasi_adime").html(value.evaluasi_adime);
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

$(document).on("submit","#form_adime",function(e){
	e.preventDefault();
	// alert('asd');
	// document.getElementById("btn-assesment-simpan").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
	$.ajax({  
		url:"<?php echo base_url(); ?>iri/rictindakan/insert_cppt/gizi",                         
		method:"POST",  
		data: new FormData(this),  
		contentType: false,  
		cache: false,  
		processData:false,  
		success: function(data)  
		{ 
			// document.getElementById("form_fisik").reset();
			new swal({
				title: "Selesai",
				text: "Data berhasil disimpan",
				type: "success",
				showCancelButton: false,
				closeOnConfirm: false,
				showLoaderOnConfirm: true,
					willClose: () => {
						window.location.reload();
					}
			},
			function () {
				// window.location.reload();
			});
		}
			
			
	// 	},
	// 	error:function(event, textStatus, errorThrown) {
	// 		swal("Error","Data gagal disimpan.", "error"); 
	// 		console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	// 	}  
	// }); 
});
});



</script>									
									


									
									

