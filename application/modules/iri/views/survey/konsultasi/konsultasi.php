<?php 
$this->load->view('layout/header_form');
function inputrow($name,$title='',$value='',$placeholder = '',$disabled=''){
	return '<div class="form-group row mb-4">
	<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
	<div class="col-sm-8">
		<div class="input-group">
			<input type="text" class="form-control" name="'.$name.'" id="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" '.$disabled.'>
		</div>
	</div>
</div>';
}

function inputrowModel($name,$title=''){
	return '<div class="form-group row mb-4">
	<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
	<div class="col-sm-8">
		<div class="input-group">
			<input type="text" class="form-control" name="'.$name.'" id="'.$name.'_modal" >
		</div>
	</div>
</div>';
}

function textareaModel($name,$title){
	return '<div class="form-group row mb-4">
		<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
		<div class="col-sm-8">
			<div class="input-group">
				<textarea name="'.$name.'" id="'.$name.'_modal" class="form-control" style="height: 100px" ></textarea>
			</div>
		</div>
	</div>';
}

function textarea($name,$title,$value=''){
	return '<div class="form-group row mb-4">
		<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
		<div class="col-sm-8">
			<div class="input-group">
				<textarea name="'.$name.'" id="'.$name.'" class="form-control" style="height: 100px" >'.$value.'</textarea>
			</div>
		</div>
	</div>';
}



?>

<script>
var showhide = 1; //0 tidak tampil ,1 tampil

function openModal(data){
	console.log(data);
	var value = data;
	$("input[name=poliklinik_nama]").val(value.nm_poli);
	$("input[name=nm_dokter_penerima]").val(value.nm_dokter_penerima);
	$("input[name=idrg]").val(value.ruangan);
	$("input[name=nm_dokter_pengirim]").val(value.nm_dokter_pengirim);
	$("#kemungkinan_modal").val(value.kemungkinan);
	$("#diobati_untuk_modal").val(value.diobati_untuk);
	$("#kelainan_modal").val(value.kelainan);
	$("#pengobatan_modal").val(value.pengobatan);
	$("#perhatian_khusus_modal").val(value.perhatian_khusus);
	$("#nasehat_modal").val(value.nasehat);

	if(value.permintaan_dokter_asal == 'rawat_bersama'){
		$('#inlineRadio2_modal').prop('checked',true);
	}else if(value.permintaan_dokter_asal === 'alih_rawat'){
		$('#inlineRadio1_modal').prop('checked',true);
	}else{
		$('#inlineRadio3_modal').prop('checked',true);
	}

	$('#exampleKonsultasi').modal('show');
	

}

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxdokter(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(4,4);

    ajaxku = buatajax();
    var url="<?php echo site_url('iri/rictindakan/data_dokter_poli'); ?>";
    url=url+"/"+id;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	
}
function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter_penerima").innerHTML = data;
		}
    }
}
$(document).ready(function(){
	$('.datatable').DataTable({});
	$('.select2').select2({});
})
</script>
<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid d-flex justify-content-between" style="width:100%;">
            <h5>Lembar Konsultasi ( ANTAR BAGIAN )</h5>
			<button class="btn btn-primary" id="btnshowhide">Tambah Data</button>

        </div>
    </div>
	<form method="POST" id="form_konsul" class="form-horizontal">	
	
		<div class="card-body">
			<div class="form-group row mb-4">
				<label class="col-sm-2  control-label col-form-label" id="dirujuk_ke">Tujuan Bagian*</label>
				<div class="col-sm-8">
					<div class="form-inline">
						<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli_tujuan"  onchange="ajaxdokter(this.value)" required>
							<option value="">-- Pilih Spesialis Bagian --</option>
							<?php 
							if($radio == 'RAD') {
								foreach($poli_rad as $row){
									echo '<option value="'.$row->id_poli.'">'.str_replace('POLI','',$row->nm_poli).'</option>';
								}
							} else {
								foreach($poli as $row){
									echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'">'.str_replace('POLI','',$row->nm_poli).'</option>';
								}
							}
							?>
						</select>	
					</div>
				</div>
			</div>
			<div class="form-group row mb-4">
				<label class="col-sm-2 control-label col-form-label" id="dokter">Konsultasi kepada</label>
				<div class="col-sm-8">
					<div class="form-inline">
						<select id="id_dokter_penerima" class="form-control select2" style="width: 100%" name="id_dokter_penerima" required>
						</select>
					</div>
				</div>
			</div>

			<?= inputrow('','dr',$data_pasien[0]['dokter'],'Dokter Pengirim','disabled') ?>
			<input type="hidden" name="tgl_masuk" value="<?= $data_pasien[0]['tgl_masuk'] ?>">
			<hr>
			<h5>PERMINTAAN KONSULTASI</h5><br><br>
			<?= textarea('kemungkinan','Kemungkinan / Sangkaan',isset($get_konsultasi_pasien_iri[0]->kemungkinan)?$get_konsultasi_pasien_iri[0]->kemungkinan:'')  ?>
			<?= inputrow('diobati_untuk','Diobati Untuk',isset($get_konsultasi_pasien_iri[0]->diobati_untuk)?$get_konsultasi_pasien_iri[0]->diobati_untuk:'') ?>
			<?= textarea('kelainan','Kelainan - Kelainan',isset($get_konsultasi_pasien_iri[0]->kelainan)?$get_konsultasi_pasien_iri[0]->kelainan:'')  ?>
			<?= textarea('pengobatan','Pengobatan Yang Telah Dilakukan',isset($get_konsultasi_pasien_iri[0]->pengobatan)?$get_konsultasi_pasien_iri[0]->pengobatan:'')  ?>
			<?= textarea('perhatian_khusus','Perhatian Khusus',isset($get_konsultasi_pasien_iri[0]->perhatian_khusus)?$get_konsultasi_pasien_iri[0]->perhatian_khusus:'')  ?>
			<?= inputrow('nasehat','Nasehat',isset($get_konsultasi_pasien_iri[0]->nasehat)?$get_konsultasi_pasien_iri[0]->nasehat:'') ?>
			<div class="form-group row">
				<label class="col-sm-2 control-label col-form-label" id="dokter">permintaan Ke Dokter Tujuan</label>
				<div class="col-sm-8">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio1" value="alih_rawat" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'alih_rawat'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio1">Alih Rawat</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio2" value="rawat_bersama" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'rawat_bersama'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio2">Rawat Bersama</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio3" value="konsultasi" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'konsultasi'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio3">Konsultasi 1 X</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio4" value="dpjp_pengganti" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'dpjp_pengganti'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio4">DPJP Pengganti</label>
					</div>
				</div>
			</div>
				
			<input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
			<?php if($radio == 'RAD') { ?>
				<input type="hidden" class="form-control" value="329" name="id_dokter_pengirim">
				<input type="hidden" class="form-control" value="dr. Widya Sp.Rad" name="nm_dokter_pengirim">
			<?php } else { ?>
				<input type="hidden" class="form-control" value="<?php echo $dpjp_iri[0]->id_dokter;?>" name="id_dokter_pengirim">
				<input type="hidden" class="form-control" value="<?php echo $dpjp_iri[0]->nm_dokter;?>" name="nm_dokter_pengirim">
			<?php } ?>
			<!-- <input type="hidden" class="form-control" value="<?php echo $radio;?>" name="radio"> -->
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary" id="btn-form-konsul-insert">Simpan</button>
		</div>
	</form>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>Riwayat Konsultasi</h5>
    </div>
	<div class="card-body">
		<!-- history data -->
		<table class="table table-hover table-striped table-bordered datatable">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tgl Konsultasi</th>
					<th>Jawaban Konsultasi</th>
					<th>Dokter Konsultasi</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				if($history_konsultasi_pasien_iri->num_rows()){
					foreach($history_konsultasi_pasien_iri->result() as $value){
				?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= date('d-m-Y H:i:s',strtotime($value->tgl_konsultasi)) ?></td>
						<td><?= isset($value->is_accept)?$value->is_accept == '1'?'Diterima':'Ditolak':'Meminta Persetujuan' ?></td>
						<td><?= $value->nm_dokter_penerima ?></td>
						<td>
							<input type="hidden" name="ipd" id="ipd" value="<?php echo $no_ipd; ?>">
							<input type="hidden" name="id_dokter_penerima" id="" value="<?php echo $value->id_dokter_penerima; ?>">
							<button type="button" class="btn btn-primary" onclick='openModal(<?= json_encode($value); ?>)'> Detail </button>
							<a href="<?php echo base_url('iri/rictindakan/hapus_konsul_pasien_iri/'.$value->no_ipd.'/'.$value->id.'/'.$value->id_dokter_penerima);?>" class="btn btn-primary">Hapus</a>
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



<!-- modal -->
<div class="modal fade" id="exampleKonsultasi" tabindex="-1" role="dialog" aria-labelledby="exampleKonsultasiLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Konsultasi Dokter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<?= inputrow('poliklinik_nama','Tujuan Poliklinik') ?>
			<?= inputrow('nm_dokter_penerima','Konsultasi Kepada') ?>
			
			<?= inputrow('nm_dokter_pengirim','dr') ?>
			<span>PERMINTAAN KONSULTASI</span><br><br>
			<?= textareaModel('kemungkinan','Kemungkinan / Sangkaan') ?>
			<?= inputrowModel('diobati_untuk','Diobati Untuk') ?>
			<?= textareaModel('kelainan','Kelainan - Kelainan')  ?>
			<?= textareaModel('pengobatan','Pengobatan Yang Telah Dilakukan')  ?>
			<?= textareaModel('perhatian_khusus','Perhatian Khusus')  ?>
			<?= inputrowModel('nasehat','Nasehat') ?>
			<div class="form-group row">
				<label class="col-sm-2 control-label col-form-label" id="dokter">permintaan Ke Dokter Tujuan</label>
				<div class="col-sm-8">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio1_modal" value="alih_rawat" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'alih_rawat'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio1">Alih Rawat</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio2_modal" value="rawat_bersama" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'rawat_bersama'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio2">Rawat Bersama</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio3_modal" value="konsultasi" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'konsultasi'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio3">Konsultasi 1 X</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="permintaan_dokter_asal" id="inlineRadio4_modal" value="dpjp_pengganti" <?= isset($get_konsultasi_pasien_iri[0]->permintaan_dokter_asal)?$get_konsultasi_pasien_iri[0]->permintaan_dokter_asal == 'dpjp_pengganti'?"checked":"":"" ?>>
						<label class="form-check-label" for="inlineRadio4">DPJP Pengganti</label>
					</div>
				</div>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
	

	$(document).on("click","#btnshowhide",function(){
		if(showhide == 1){
			$('#form_konsul').hide();showhide = 0;
		}else{
			$('#form_konsul').show();showhide = 1;

		}
	});

	$('.dataparsingKonsultasi').on('click',function(){
		// var value = $(this).data('value');
		// console.log(value);
	

	})

	$(document).on("submit","#form_konsul",function(e){
		e.preventDefault();

		$.ajax({  
			url:"<?php echo base_url(); ?>iri/rictindakan/insert_konsul",                         
			method:"POST",  
			data: new FormData(this),  
			contentType: false,  
			cache: false,  
			processData:false,  
			success: function(data)  
			{ 
			// 	new swal({
			// 	title: "Selesai",
			// 	text: "Data berhasil disimpan",
			// 	type: "success",
			// 	showCancelButton: false,
			// 	closeOnConfirm: false,
			// 	showLoaderOnConfirm: true
			// },
			// function () {
			// 	window.location.reload();
			// });
			
			window.location.reload();
				
			},
			error:function(event, textStatus, errorThrown) {
				new swal("Error","Data gagal disimpan.", "error"); 
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}  
		});

	});

</script>									
									


									
									

