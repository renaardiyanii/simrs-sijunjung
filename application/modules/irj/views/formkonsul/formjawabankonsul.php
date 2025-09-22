<?php 
// var_dump($no_register);
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

function ajaxdokter(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(4,4);

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
	var no_register = $('#noreg_konsul').val();
	var base = "<?php echo base_url(); ?>";
	//  var no_reg = "<?php $no_register ?>";
	// console.log(no_reg);
$("#form_jawaban_konsul_dokter").on("submit",function(e){
		e.preventDefault();
		// alert('hello world');

		$.ajax({  
			url:"<?php echo base_url(); ?>irj/rjcpelayananfdokter/insert_jawaban_konsul",                         
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
						swal("Close", "Batal Input Resep", "error");
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
		<span>Jawaban Konsultasi ( ANTAR BAGIAN )</span>
		<a href="<?= base_url('emedrec/C_emedrec/surat_konsul_by_reg/'.$data_pasien_daftar_ulang->no_register_lama.'/'.$data_pasien_daftar_ulang->no_cm.'/'.$data_pasien_daftar_ulang->no_medrec) ?>" class="btn btn-primary" target="_blank">Lihat Konsultasi</a>
	</div>
	<hr>
<br>
<form method="POST" id="form_jawaban_konsul_dokter" class="form-horizontal">	
	<?= textareaModel('detail_penyakit_jawaban', 'Hal Hal Yang Ditemukan') ?>
	<?= textareaModel('kesan_jawaban', 'Kesan') ?>
	<?= textareaModel('anjuran_jawaban', 'Anjuran') ?>
	
	<div class="form-group row" >
		<label class="col-sm-2 control-label col-form-label" id="dokter">Pengajuan Konsul Kembali</label>
			<div class="col-sm-8">
				<div class="form-inline">
					<input type="date" id="date_picker" class="form-control" placeholder="dd-mm-yyyy" name="pengajuan_kembali_jawaban">
				</div>
			</div>
	</div>
	
	<div class="form-group row">
		<label class="col-sm-2 control-label col-form-label">Pemindahan Pengobatan </label>
		<div class="col-sm-8">
			<input type="radio" id="pem1_2" name="pemindahan_pengobatan_jawaban" value="1">
			<label for="pem1_2">Ya</label>

			<input type="radio" id="pem1_3" name="pemindahan_pengobatan_jawaban" value="0">
			<label for="pem1_3">Tidak</label>
		</div>
	</div>
		
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->no_register_lama;?>" name="no_register" id="noreg_konsul">
	<input type="hidden" class="form-control" value="<?php echo $data_pasien_daftar_ulang->id_dokter;?>" name="id_dokter_akhir" id="id_dokter_akhir">
	<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli_akhir" id="id_poli_akhir">
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
									


									
									

