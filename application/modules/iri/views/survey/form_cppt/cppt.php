<?php 
$this->load->view('layout/header_form');
$data_awal_medis = (isset($data_igd->formjson)?json_decode($data_igd->formjson):'');
$history_cppt = $history_soap_pasien_ri->num_rows()!=0?$history_soap_pasien_ri->result():null;
$last_record_cppt = $history_cppt?$history_cppt[0]:null; // get_last_record in cppt
$ppanya = '';
// bahan 1 id_pemeriksa
// bahan 2 $user->userid

switch($ppa_sebagai)
{
	// urgent nanti pindahkan ke models
	case 'dokter_dpjp':
		$ppanya = 'Dokter DPJP';
		$query = $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND role='Perawat' ORDER BY id DESC limit 1");
		$last_record_cppt = $query->num_rows()!=0?$query->row():null;
		break;
	case 'case_manager':
		$ppanya = 'Case Manager';
		break;
	case 'dokter_jaga':
		$ppanya = 'Dokter Jaga';
		$query = $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND role='Perawat' ORDER BY id DESC limit 1");
		$last_record_cppt = $query->num_rows()!=0?$query->row():null;
		break;
	case 'dokter_ruangan':
		$ppanya = 'Dokter Ruangan';
		$query = $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND role='Perawat' ORDER BY id DESC limit 1");
		$last_record_cppt = $query->num_rows()!=0?$query->row():null;
		break;
	case 'perawat':
		$ppanya = "Perawat";
		break;
	case 'Farmatologi':
		$ppanya = "Farmasi";
		$query = $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND role='Perawat' ORDER BY id DESC limit 1");
		$last_record_cppt = $query->num_rows()!=0?$query->row():null;
		break;
	case 'Fisioterapis':
		$ppanya = "Fisioterapi";
		// untuk sementara karena urgent 
		$query = $this->db->query("SELECT * FROM soap_pasien_ri WHERE no_ipd='$no_ipd' AND role='Perawat' ORDER BY id DESC limit 1");
		$last_record_cppt = $query->num_rows()!=0?$query->row():null;
		break;
	default:
		$ppanya = '';
		break;
}
// $ppanya = 'Farmasi';
// echo $ppanya;
?>

<div class="card m-5">
	<div class="card-header text-end">
		<a href="<?= base_url('/emedrec/C_emedrec_iri/get_cppt_iri/'.$data_pasien[0]['no_ipd'].'/'.$data_pasien[0]['no_cm'].'/'.$data_pasien[0]['no_medrec']) ?>" target="_blank" class="btn btn-primary pull-right">Lihat CPPT</a>
		<?php
		if($ppanya =='Farmasi'){
			?>
		<button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Lihat Obat</button>	
		<form action="<?= base_url('emedrec/C_emedrec_iri/cetak_surat_laboratorium_iri_all'); ?>" method="post">
		<input type="hidden" name="user_id" value="<?= $data_pasien[0]['no_ipd']; ?>"> 
			<input type="hidden" name="no_cm" value="<?= sprintf("%08d",$data_pasien[0]['no_medrec']); ?>">
			<input type="hidden" name="no_medrec" value="<?= $data_pasien[0]['no_medrec']; ?>">
			<button type="submit" class="btn btn-warning  ml-4  mt-2" formtarget="_blank">Hasil Laboratorium</button>
		</form>
		<?php
		}
		?>
	</div>
	<div class="card-body">			
		<div id="surveyCppt"></div>
	</div>
</div>

<!-- show modal list obat -->
<div class="modal fade bd-example-modal-lg" id="modalObat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Daftar Obat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class="table-responsive m-t-0">
		<table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>No Resep</th>
				<th>Obat</th>
				<th>Nama Obat</th>
				<th>Tgl Tindakan</th>
				<th>Signa</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_bayar = 0;
			if(!empty($list_resep_pasien)){
				foreach($list_resep_pasien as $r){ ?>
				<tr>
					<td><?php echo $r->no_resep ; ?></td>
					<td>
						<?php
							if ($r->obat_luar == 0) {
								echo 'OBAT LUAR';
							}else{
								echo 'OBAT RS';
							}
						?>
					</td>
					<td><?php echo $r->nama_obat ; ?></td>
					<td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
					<td><?php echo $r->signa ; ?></td>
				</tr>
				<?php
				}
			}else{ ?>
			<tr>
					<td colspan="8" style="text-align:center">Data Kosong</td>
				</tr>
			<?php
			}
			?>
		</tbody>
		</table>
		</div>
      </div>
    </div>
  </div>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>Riwayat CPPT</h5>
	</div>
	<div class="card-body">
		<table class="table table-hover table-striped table-bordered data-table" id="datatablecppt" style="width:100%;" style="table-layout: fixed;">
			<thead>
			<tr>
				<th>No.</th>
				<th>Tgl Pemeriksaan</th>
				<th>Nama Pemeriksa</th>
				<th>Role</th>
				<th>Subjective</th>
				<th style="<?= $ppa_sebagai == 'dokter_dpjp'?'text-align:center':'' ?>;">Aksi&nbsp;
				<?php
				 if($ppa_sebagai == 'dokter_dpjp' && $history_soap_pasien_ri->num_rows())
				 { 
				 ?>
				 <button class="btn btn-primary btn-sm" onclick="acceptCppt('1','all','<?= $no_ipd ?>')">Verifikasi Semua</button>
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
							<div>
								<button type="button" style="margin-right:5px;"  class="btn btn-info btn-sm dataparsingcppt" data-value='<?= $json_value ?>' > Terapkan Data </button>&nbsp;
								<?php // if($user->userid == 1){ ?>
								<button type="button" style="margin-right:5px;"  class="btn btn-danger btn-sm dataparsingcpptdelete" data-value='<?= $json_value ?>' > Delete Data </button>&nbsp;
								<?php// } ?>
								<?php
								if($value->id_pemeriksa == $user->userid){
								?>
								<!-- <button type="button" style="margin-right:5px;"  class="btn btn-info btn-sm dataparsingcpptEdit" data-value='<?= $json_value ?>' > Edit Data </button>&nbsp; -->
								<?php } ?>
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
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<script>
$(document).ready( function () {
    $('#datatablecppt').DataTable();
} );
var insert = 1; // trigger insert atau update
var idcppt = 0;  // insert = 0 berarti idcppt ini diisi sama id cpptnya
var noipd = '<?php echo $no_ipd ;?>';

    
function acceptCppt(id_cppt,opsi="",no_ipd="")
{
	$.ajax({  
		url: opsi!==""?"<?php echo base_url(); ?>iri/rictindakan/update_cppt/all":"<?php echo base_url(); ?>iri/rictindakan/update_cppt",                         
		method:"POST",
		data: opsi!==""?{
			id : no_ipd,
			noipd : noipd
		}:{
			id : id_cppt,
			noipd : noipd
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
			
			window.location.reload();
		},
		error:function(event, textStatus, errorThrown) {
			new swal("Error","Data gagal disimpan.", "error"); 
			console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		}  
	});
}

    Survey.StylesManager.applyTheme("modern");
    surveyJsonCppt = <?php echo file_get_contents("cppt.json",FILE_USE_INCLUDE_PATH);?>;
    var surveyCppt = new Survey.Model(surveyJsonCppt);

	
		


    function sendDataToCppt(survey) {
        
        $.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_cppt/')?>" + insert,
            type : 'POST',
            data : {
				no_ipd:'<?php echo $no_ipd ;?>',
                subjective: survey.data.subjective,
                objective: survey.data.objective,
                assesment: survey.data.assesment,
                plan: survey.data.plan,
                instruksi: survey.data.instruksi,
                role : '<?= $ppanya!=""?$ppanya:$ppa_sebagai ?>',
                id : insert==1?'<?= $ppa_sebagai == "perawat"?$last_record_cppt?$last_record_cppt->id:"":"" ?>':idcppt,
                konsul_dokter : JSON.stringify(survey.data.konsultasi),
				emergency: JSON.stringify(survey.data.emergensi),
				tanggal_pemeriksaan: JSON.stringify(survey.data.tgl_pemeriksaan),
            },
            datatype:'json',
            success:function(data)
            {
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
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
            
    }
    
    <?php
    if($last_record_cppt){
    ?>
     <?php
    if($last_record_cppt->konsul_dokter){
    ?>
        surveyCppt.data = {
            'konsul':[
                'Konsul Dokter'
            ]
        }
    <?php } ?>
    surveyCppt.setValue('subjective',"<?= str_replace([PHP_EOL,"\r","\n"],'\n',$last_record_cppt->subjective) ?>")
    // surveyCppt.setValue('objective',"<?= str_replace([PHP_EOL,"\r","\n"],'\n',$last_record_cppt->objective) ?>")
	surveyCppt.setValue('objective',"Tekanan Darah : <?= isset($pem_fisik_last->sitolic)?$pem_fisik_last->sitolic.'/'.$pem_fisik_last->diatolic:'' ?>\nBB : <?= isset($pem_fisik_last->bb)?$pem_fisik_last->bb:'' ?>\nNadi : <?= isset($pem_fisik_last->nadi)?$pem_fisik_last->nadi:'' ?>\nSaturasi Oksigen : <?= isset($pem_fisik_last->oksigen)?$pem_fisik_last->oksigen:'' ?>\nFrekuensi Nafas : <?= isset($pem_fisik_last->frekuensi_nafas)?$pem_fisik_last->frekuensi_nafas:'' ?>\nSuhu : <?= isset($pem_fisik_last->suhu)?$pem_fisik_last->suhu:'' ?>")
   //	surveyCppt.setValue('assesment',"<?= str_replace([PHP_EOL,"\r","\n"],'\n',$last_record_cppt->assesment) ?>")
  //  surveyCppt.setValue('plan',"<?= str_replace([PHP_EOL,"\r","\n"],'\n',$last_record_cppt->plan) ?>")
//surveyCppt.setValue('instruksi',"<?= str_replace([PHP_EOL,"\r","\n"],'\n',$last_record_cppt->instruksi) ?>")
   // surveyCppt.setValue('table_konsultasi',<?= $last_record_cppt->konsul_dokter ?>)
   
    <?php } else { ?>
		surveyCppt.setValue('objective',"Tekanan Darah : <?= isset($pem_fisik_last->sitolic)?$pem_fisik_last->sitolic.'/'.$pem_fisik_last->diatolic:'' ?>\nBB : <?= isset($pem_fisik_last->bb)?$pem_fisik_last->bb:'' ?>\nNadi : <?= isset($pem_fisik_last->nadi)?$pem_fisik_last->nadi:'' ?>\nSaturasi Oksigen : <?= isset($pem_fisik_last->oksigen)?$pem_fisik_last->oksigen:'' ?>\nFrekuensi Nafas : <?= isset($pem_fisik_last->frekuensi_nafas)?$pem_fisik_last->frekuensi_nafas:'' ?>\nSuhu : <?= isset($pem_fisik_last->suhu)?$pem_fisik_last->suhu:'' ?>")
		surveyCppt.setValue('subjective',<?= json_encode(isset($pem_fisik_last->keluhan) ? $pem_fisik_last->keluhan : '') ?>)
	<?php }?>

	// edit data
	$(document).on("click", ".dataparsingcpptEdit", function () {
        var value = $(this).data('value');
		surveyCppt.setValue('subjective',value.subjective);
		surveyCppt.setValue('obbjective',value.obbjective);
        surveyCppt.setValue('assesment',value.assesment);
        surveyCppt.setValue('plan',value.plan);
        surveyCppt.setValue('instruksi',value.instruksi);
        surveyCppt.setValue('table_konsultasi',value.table_konsultasi);
		insert = 0;
		idcppt = value.id;
		// console.log(idcppt);
		// document.getElementById("submit").innerHTML = 'Update';


    });

	// delete cppt khusus admin
	$(document).on("click", ".dataparsingcpptdelete", function () {
        var value = $(this).data('value');
		idcppt = value.id;
		console.log(value);
		$.ajax({
            url: "<?php echo base_url('iri/rictindakan/delete_cppt/')?>" + idcppt,
            type : 'GET',
            success:function(data)
            {
				
					 window.location.reload();
				
				
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });


    });
	

    $(document).on("click", ".dataparsingcppt", function () {
        var value = $(this).data('value');
		surveyCppt.setValue('subjective',value.subjective);
		surveyCppt.setValue('objective',value.objective);
        surveyCppt.setValue('assesment',value.assesment);
        surveyCppt.setValue('plan',value.plan);
        surveyCppt.setValue('instruksi',value.instruksi);
    });


    surveyCppt.render("surveyCppt");
    surveyCppt
        .onComplete
        .add(function (result) {
            sendDataToCppt(result);
        });

		// surveyCppt.showNavigationButtons = false;


// function saveToSurvey(){
// 	survey.completeLastPage();
// }
</script>