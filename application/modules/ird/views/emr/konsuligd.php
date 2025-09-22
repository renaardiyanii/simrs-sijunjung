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

function cekRanap(no_reg)
{
	$.ajax({
		type: 'GET',
		url: '<?= base_url('ird/rdcpelayanan/cek_pasien_ird_ranap') ?>/'+no_reg,
		beforeSend: function() {
			var html = `
			<div class="alert alert-dark" role="alert">
				Silahkan Ditunggu sebentar......
			</div>
			`;

			$('#alertnya').html(html);
		},
		success: function(data) {
			if(data.length){
				$('#alertnya').hide();
				return;
			}
			var html = `
			<div class="alert alert-danger" role="alert">
				Pasien Belum terdaftar di rawat inap
			</div>
			`;

			$('#alertnya').html(html);
			$('#btn-form-konsul-insert').prop('disabled',true);
		},
		error: function(xhr) { // if error occured
			var html = `
			<div class="alert alert-danger" role="alert">
				Silahkan Kontak Admin SIRS
			</div>
			`;

			$('#alertnya').html(html);
			$('#btn-form-konsul-insert').prop('disabled',true);
			new swal("Error","Silahkan Kontak Admin SIRS", "error"); 
		
		},
		complete: function() {
		},
	});
}

$(document).ready(function(){
	$('.datatable').DataTable({});
	$('.select2').select2({});
	cekRanap('<?php echo $no_register;?>');
})
</script>
<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid d-flex justify-content-between" style="width:100%;">
            <h5>Lembar Konsultasi ( ANTAR BAGIAN )</h5>
        </div>
    </div>
	<form method="POST" id="form_konsul" class="form-horizontal">	
	
		<div class="card-body">
			<div id="alertnya">

			</div>
			<div class="form-group row mb-4">
				<label class="col-sm-2  control-label col-form-label" id="dirujuk_ke">Tujuan Bagian*</label>
				<div class="col-sm-8">
					<div class="form-inline">
						<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli_tujuan"  onchange="ajaxdokter(this.value)" required>
							<option value="">-- Pilih Spesialis Bagian --</option>
							<?php 
							foreach($poli as $row){
								echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'">'.str_replace('POLI','',$row->nm_poli).'</option>';
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

			<?= inputrow('','dr',$data_pasien_daftar_ulang->dokter,'Dokter Pengirim','disabled') ?>
			<input type="hidden" name="tgl_masuk" value="<?= $data_pasien_daftar_ulang->tgl_kunjungan ?>">
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
				
			<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_ipd">
			<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->id_dokter;?>" name="id_dokter_pengirim">
			<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->dokter;?>" name="nm_dokter_pengirim">
		</div>
		<div class="card-footer">
			<button type="submit" class="btn btn-primary" id="btn-form-konsul-insert">Simpan</button>
		</div>
	</form>
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
			url:"<?php echo base_url(); ?>ird/rdcpelayananfdokter/insert_konsul",                         
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
					closeOnConfirm: true,
					showLoaderOnConfirm: true
				},
				function () {
					window.location.reload();
				});
					// window.location.reload();
				
			},
			error:function(event, textStatus, errorThrown) {
				new swal("Error","Data gagal disimpan.", "error"); 
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}  
		});

	});

</script>									
									


									
									

