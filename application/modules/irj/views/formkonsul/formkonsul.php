<?php 
$this->load->view('layout/header_form');
function textareaModel($name,$title){
	return '<div class="form-group row">
		<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
		<div class="col-sm-8">
			<div class="input-group">
				<textarea name="'.$name.'" id="'.$name.'_modal" class="form-control" style="height: 100px" ></textarea>
			</div>
		</div>
	</div>';
}

function textarea($name,$title,$value=''){
	return '<div class="form-group row">
		<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
		<div class="col-sm-8">
			<div class="input-group">
				<textarea name="'.$name.'" id="'.$name.'" class="form-control" style="height: 100px" >'.$value.'</textarea>
			</div>
		</div>
	</div>';
}

function inputText($name,$title,$value="")
{
	return '
	<div class="form-group row">
		<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
		<div class="col-sm-8">
			<div class="input-group">
				<input type="text" name="'.$name.'" value="'.$value.'" disabled />
			</div>
		</div>
	</div>
	';
}

$diagnosa = '';
$obat = '';

if(count($data_obat_pasien)>0){
	foreach($data_obat_pasien as $val){
		$obat .= '- '.$val->nama_obat.PHP_EOL;
	
	}
}
if(count($data_diagnosa_pasien_by_no_reg)>0){
	foreach($data_diagnosa_pasien_by_no_reg as $val){
		$diagnosa .= '- '.$val->id_diagnosa.' - '.$val->diagnosa.PHP_EOL;
	}
}

?>

<script>
var showhide = 1; //0 tidak tampil ,1 tampil

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxdokterkonsul(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(4,4);
	console.log(id_poli);

	if (pokpoli == 'EKSE') {
		$("#eksekutif").prop("checked", true); 
		$("#none_class").prop("checked", false); 
	}else{
		$("#none_class").prop("checked", true); 
		$("#eksekutif").prop("checked", false); 
	}

    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
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
			document.getElementById("id_dokter_konsul").innerHTML = data;
		}
    }
}


$(document).ready(function(){
	var no_register = $('#no_register').val();
	var base = "<?php echo base_url(); ?>";
$("#form_konsul_dokter").on("submit",function(e){
		e.preventDefault();
		// alert('hello world');		
console.log(no_register);
		$.ajax({  
			url:"<?php echo base_url(); ?>irj/rjcpelayananfdokter/insert_konsul",                         
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
					showLoaderOnConfirm: true,
					closeOnConfirm: false,
					closeOnCancel: false        
				}).then((result) => {
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {		
						window.open(base+'irj/rjcpelayanan/surat_konsul/'+no_register, '_blank').focus();							
					} else if (result.isDenied) {
						swal("Close", "Batal Input Konsul", "error");
					}
				});

				
			},
			error:function(event, textStatus, errorThrown) {
				new swal("Error","Data gagal disimpan.", "error"); 
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}  
		});

	});
});
</script>
<div class="card m-5">
<div class="card-body">
<div class="d-flex justify-content-between" style="width:100%;" >
		<span>Lembar Konsultasi ( ANTAR BAGIAN )</span>
		<a href="<?= base_url('emedrec/C_emedrec/surat_konsul_by_reg/'.$data_pasien_daftar_ulang->no_register.'/'.$data_pasien_daftar_ulang->no_cm) ?>" class="btn btn-primary" target="_blank">Lihat Konsultasi</a>
	</div>
	<hr>
<br>
<form method="POST" id="form_konsul_dokter" class="form-horizontal">	
	<div class="form-group row" >
		<label class="col-sm-2 control-label col-form-label" id="dokter">Tanggal Konsul</label>
			<div class="col-sm-8">
				<div class="form-inline">
					
						<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tanggal_konsul" value="<?= isset($konsul->tanggal_konsul)?$konsul->tanggal_konsul:'' ?>" required>
					
				</div>
			</div>
	</div>
 
	<div class="form-group row">
		<label class="col-sm-2  control-label col-form-label" id="dirujuk_ke" style="margin-bottom:0px;margin-top:0px;!important">Tujuan Poliklinik *</label>
		<div class="col-sm-8">
			<div class="form-inline">
				<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli_akhir"  onchange="ajaxdokterkonsul(this.value)" required>
					<option value="">-- Pilih Nama Poli --</option>
					<?php 
					// foreach($poliklinik as $row){
					// 	echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'" ';
					// 	if($data_konsul->id_poli_akhir == $row->id_poli) echo 'selected';
					// 	echo '>'.$row->nm_poli.'</option>';
					// }
					//var_dump($konsultasi->id_poli_akhir); die();
					if($radio == 'RAD') {
						foreach($poli_rad as $row){
							echo '<option value="'.$row->id_poli.'">'.$row->nm_poli.'</option>';
						}
					} else {
						foreach($poliklinik as $row){
							echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'">'.$row->nm_poli.'</option>';
						}
					}
					?>
				</select>	
			</div>
		</div>
	</div>

	<div class="form-group row">								
		<label class="col-sm-2 control-label col-form-label">Kelas Rawat</label>
		<div class="col-sm-8">
			<div class="form-inline">

					<input type="radio" id="none_class" name="kelas_pasien" value="NK" <?php echo isset($daftar_ulang->kelas_pasien)? $daftar_ulang->kelas_pasien == "NK" ? "checked":'':'' ?>>
					<label for="NK">None Class</label>
					<input type="radio" id="eksekutif" name="kelas_pasien" value="EKSEKUTIF" <?php echo isset($daftar_ulang->kelas_pasien)? $daftar_ulang->kelas_pasien == "EKSEKUTIF" ? "checked":'':'' ?>>
					<label for="VVIP">Eksekutif</label>
			</div>
		
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 control-label col-form-label" id="dokter">Konsultasi kepada</label>
		<div class="col-sm-8">
			<div class="form-inline">
				<select id="id_dokter_konsul" class="form-control select2" style="width: 100%" name="id_dokter_akhir" required>
					<?php
						// if(isset($konsul->id_dokter_akhir)?$konsul->id_dokter_akhir:''){
						// 	echo '<option value="'.$row->id_dokter.''.$row->nm_dokter.'" selected>'.$konsul->nm_dokter.'</option>';
						// }
					?>
				</select>
			</div>
		</div>
	</div>

	<?= textarea('kemungkinan_sangkaan','Kemungkinan Sangkaan', isset($konsul->kemungkinan_sangkaan)?$konsul->kemungkinan_sangkaan:''); ?>
	<?= inputText('bagian','Bagian',$nama_poli,true) ?>
	<?= textarea('pengobatan_untuk','Pengobatan',$diagnosa); ?>
	<?= textarea('kelainan','Kelainan - Kelainan', isset($konsul->kelainan)?$konsul->kelainan:''); ?>
	<?= textarea('pengobatan','Pengobatan Yang Telah Dilakukan',$obat); ?>
	<?= textarea('perhatian_khusus','Perhatian Khusus', isset($konsul->perhatian_khusus)?$konsul->perhatian_khusus:''); ?>
	<?= textarea('nasehat','Nasehat', isset($konsul->nasehat)?$konsul->nasehat:''); ?>

	<div class="form-group row">
		<label class="col-sm-2 control-label col-form-label">Permintaan </label>
		<div class="col-sm-8">
			<input type="radio" id="pemindahan_pengobatan" name="opsi_konsul" value="alih_rawat" <?php echo isset($konsul->opsi_konsul)? $konsul->opsi_konsul == "alih_rawat" ? "checked":'':'' ?>>
			<label for="pemindahan_pengobatan">Alih Rawat</label>

			<input type="radio" id="pemindahan_pengobatan_tidak" name="opsi_konsul" value="rawat_bersama" <?php echo isset($konsul->opsi_konsul)? $konsul->opsi_konsul == "rawat_bersama" ? "checked":'':'' ?>>
			<label for="pemindahan_pengobatan_tidak">Rawat Bersama</label>

			<input type="radio" id="konnsultasi_sekali" name="opsi_konsul" value="konsultasi_sekali" <?php echo isset($konsul->opsi_konsul)? $konsul->opsi_konsul == "konsultasi_sekali" ? "checked":'':'' ?>>
			<label for="konnsultasi_sekali">Konsultasi 1x</label>
		</div>
	</div>

	<!-- <div class="form-group row">
		<div class="col-sm-8">
			<input type="checkbox" id="verif_daftar" name="verif_daftar" value="YA" <?php echo isset($konsul->verif_daftar)? $konsul->verif_daftar == "YA" ? "checked":'':'' ?>>
			<label for="verif_daftar">Verifikasi Pendaftaran</label>
		</div>
	</div> -->

	<hr>
	
		
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_register;?>" name="no_register" id="no_register">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_medrec;?>" name="no_medrec">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->cara_bayar;?>" name="cara_bayar">
	<?php if($radio == 'RAD') { ?>
		<input type="hidden" class="form-control" value="329" name="id_dokter_asal">
		<input type="hidden" class="form-control" value="LA00" name="id_poli_asal">
	<?php } else { ?>
		<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->id_dokter;?>" name="id_dokter_asal">
		<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->id_poli;?>" name="id_poli_asal">
	<?php } ?>
		
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->nama;?>" name="nama_pasien">

	<button type="submit" class="btn btn-primary" id="btn-form-konsul-insert">Simpan</button>
</form>

<?php if($data_pasien_daftar_ulang->no_register_lama == NULL) { ?>
<div class="card-body">
		<!-- history data -->
		<table class="table table-hover table-striped table-bordered datatable">
			<thead>
				<tr>
					<th>No.</th>
					<th>Tgl Konsultasi</th>
					<!-- <th>Jawaban Konsultasi</th> -->
					<th>Tujuan</th>
					<th>Dokter Konsultasi</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				if($history_konsul->num_rows()){
					foreach($history_konsul->result() as $value){
				?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= date('d-m-Y',strtotime($value->tanggal_konsul)) ?></td>
						<td><?= $value->nm_poli ?></td>
						<td><?= $value->nm_dokter ?></td>
						<td>
							<input type="hidden" name="id_poli" value="<?php echo $id_poli; ?>">
							<!-- <button type="button" class="btn btn-primary" onclick='openModal(<?= json_encode($value); ?>)'> Detail </button> -->
							<a href="<?php echo base_url('irj/rjcpelayananfdokter/hapus_konsul_pasien/'.$value->no_register.'/'.$value->id.'/'.$value->id_poli_akhir.'/'.$id_poli);?>" class="btn btn-primary">Hapus</a>
						</td>
					</tr>
				
				<?php
					}
				}
				?>
			</tbody>
		</table>
	</div>
<?php } ?>
<br>
<!-- history data -->
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
		var value = $(this).data('value');
		console.log(value);
	
		$("#poliklinik_idrg").val(value.id_poli_tujuan);
		$("input[name=nm_dokter_penerima]").val(value.nm_dokter_penerima);
		$("input[name=idrg]").val(value.ruangan);
		$("input[name=nm_dokter_pengirim]").val(value.nm_dokter_pengirim);
		$("#kemungkinan_modal").val(value.kemungkinan);
		$("#diobati_untuk_modal").val(value.diobati_untuk);
		$("#kelainan_modal").val(value.kelainan);
		$("#pengobatan_modal").val(value.pengobatan);
		$("#perhatian_khusus_modal").val(value.perhatian_khusus);
		$("#nasehat_modal").val(value.nasehat);

		if(value.rawat_bersama == 'rawat_bersama'){
			$('#inlineRadio2_modal').prop('checked',true);
		}else if(value.rawat_bersama === 'alih_rawat'){
			$('#inlineRadio1_modal').prop('checked',true);
		}else{
			$('#inlineRadio3_modal').prop('checked',true);
		}

	});

	

	

</script>									
									


									
									

