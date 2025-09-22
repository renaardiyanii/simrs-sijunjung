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
    var poli = "<?php echo $data_pasien_daftar_ulang->id_poli;?>"
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
						window.open(base+'irj/rjcpelayananfdokter/form/lembar_konsul/'+poli+'/'+no_register, '_self').focus();							
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
		<span>Lembar Konsultasi</span>
		
	</div>
	<hr>
<br>
<form method="POST" id="form_konsul_dokter" class="form-horizontal">	
	<div class="form-group row" >
		<label class="col-sm-2 control-label col-form-label" id="dokter">Tanggal Konsul</label>
			<div class="col-sm-8">
				<div class="form-inline">
					<input type="date" id="date_picker" class="form-control" placeholder="yyyy-mm-dd" name="tanggal_konsul" value="<?= isset($lembar_konsul->tgl_konsul)?$lembar_konsul->tgl_konsul:'' ?>" required>
				</div>
			</div>
	</div><br>
 
	<div class="form-group row">
		<label class="col-sm-2  control-label col-form-label" id="dirujuk_ke" style="margin-bottom:0px;margin-top:0px;!important">Tujuan Poliklinik *</label>
		<div class="col-sm-8">
			<div class="form-inline">
				<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli_akhir"  onchange="ajaxdokterkonsul(this.value)" required>
					<option value="">-- Pilih Nama Poli --</option>
					<?php 
						foreach($poliklinik as $row){
							echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'">'.$row->nm_poli.'</option>';
						}
					?>
				</select>	
			</div>
		</div>
	</div><br>

	

	<div class="form-group row">
		<label class="col-sm-2 control-label col-form-label" id="dokter">Dokter</label>
		<div class="col-sm-8">
			<div class="form-inline">
				<select id="id_dokter_konsul" class="form-control select2" style="width: 100%" name="id_dokter_akhir" required>
				</select>
			</div>
		</div>
	</div><br>

	<?= textarea('penderita','Penderita Kami Rawat Dengan ', isset($lembar_konsul->penderita)?$lembar_konsul->penderita:''); ?><br>

    <?= textarea('diag_kerja','Diagnosis Kerja', isset($lembar_konsul->diag_kerja)?$lembar_konsul->diag_kerja:''); ?><br>

    <?= textarea('ikhtisar','Ikhtisar', isset($lembar_konsul->ikhtisar)?$lembar_konsul->ikhtisar:''); ?><br>

    <?= textarea('kesimpulan','Kesimpulan', isset($lembar_konsul->kesimpulan)?$lembar_konsul->kesimpulan:''); ?><br>

    <?= textarea('konsul_diminta','Konsul yang Diminta', isset($lembar_konsul->konsul_diminta)?$lembar_konsul->konsul_diminta:''); ?><br>
	
	

	<div class="form-group row">
		<label class="col-sm-2 control-label col-form-label">Permintaan </label>
		<div class="col-sm-8">
			<input type="checkbox" id="memberikan_pendapat_dibidang_ts" name="pendapat" value="memberikan_pendapat_dibidang_ts" <?php echo isset($lembar_konsul->pendapat)? $lembar_konsul->pendapat == "memberikan_pendapat_dibidang_ts" ? "checked":'':'' ?>>
			<label for="memberikan_pendapat_dibidang_ts">Memberikan Pendapat Dibidang TS</label>

			<input type="checkbox" id="memberikan_advis_pengobatan" name="pengobatan" value="memberikan_advis_pengobatan" <?php echo isset($lembar_konsul->pengobatan)? $lembar_konsul->pengobatan == "memberikan_advis_pengobatan" ? "checked":'':'' ?>>
			<label for="memberikan_advis_pengobatan">Memberikan Advis Pengobatan</label>

			<input type="checkbox" id="mengambil_alih_pengobatan" name="alih_pengobatan" value="mengambil_alih_pengobatan" <?php echo isset($lembar_konsul->alih_pengobatan)? $lembar_konsul->alih_pengobatan == "mengambil_alih_pengobatan" ? "checked":'':'' ?>>
			<label for="mengambil_alih_pengobatan">Mengambil Alih Pengobatan</label>

            <input type="checkbox" id="raber" name="raber" value="raber" <?php echo isset($lembar_konsul->raber)? $lembar_konsul->raber == "raber" ? "checked":'':'' ?>>
			<label for="raber">Rawat Bersama</label>
		</div>
	</div>

	

	<hr>
	
		
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_register;?>" name="no_register" id="no_register">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_medrec;?>" name="no_medrec">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->cara_bayar;?>" name="cara_bayar">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->id_dokter;?>" name="id_dokter_asal">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->id_poli;?>" name="id_poli_asal">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->nama;?>" name="nama_pasien">

	<button type="submit" class="btn btn-primary" id="btn-form-konsul-insert">Simpan</button>
</form>


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
									


									
									

