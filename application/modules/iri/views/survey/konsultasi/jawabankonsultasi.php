<?php 
//$this->load->view('layout/header_form');
$history = $history_konsultasi_pasien_iri->result();

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
?>

<?php
// print_r($idkonsul->id);
$data_konsultasi = '';
              if (isset($user_dokter->id_dokter)) {
                foreach ($history_konsultasi_pasien_iri->result_array() as $res) {
                  if (in_array($user_dokter->id_dokter, $res)) {
                    $data_konsultasi = $res['tgl_jawaban'] == null ? $res['id'] : '';
					// var_dump(in_array($user_dokter->id_dokter, $res));die();
                    if ($data_konsultasi != "") {
                      if (substr($res['id_poli_tujuan'], 0, 4) != 'BK00') {
              ?>
                      <?php } else {
                      ?>
                <?php
                      }
                    }
                  }
                }
                ?>
              <?php }

              ?>
<script>
var showhide = 1; //0 tidak tampil ,1 tampil

function openModal(data){
	console.log(data);
	var value = data;
	//var value = $(this).data('value');
		console.log(value);
	
		$("#hal_yang_ditemukan_modal").val(value.hal_yang_ditemukan);
		$("#kesan_modal").val(value.kesan);
		$("#anjuran_modal").val(value.anjuran);
		

		if(value.pemindahan_pengobatan == '0'){
			$('#nonpindah').prop('checked',true);
	
		}else{
			$('#pindah').prop('checked',true);
		}

		$("input[name=pengajuan_konsul_kembali]").val(value.pengajuan_konsul_kembali);
		$("#date_picker").val(value.pengajuan_konsul_kembali);

	// $("input[name=poliklinik_nama]").val(value.nm_poli);
	// $("input[name=nm_dokter_penerima]").val(value.nm_dokter_penerima);
	// $("input[name=idrg]").val(value.ruangan);
	// $("input[name=nm_dokter_pengirim]").val(value.nm_dokter_pengirim);
	// $("#kemungkinan_modal").val(value.kemungkinan);
	// $("#diobati_untuk_modal").val(value.diobati_untuk);
	// $("#kelainan_modal").val(value.kelainan);
	// $("#pengobatan_modal").val(value.pengobatan);
	// $("#perhatian_khusus_modal").val(value.perhatian_khusus);
	// $("#nasehat_modal").val(value.nasehat);

	// if(value.permintaan_dokter_asal == 'rawat_bersama'){
	// 	$('#inlineRadio2_modal').prop('checked',true);
	// }else if(value.permintaan_dokter_asal === 'alih_rawat'){
	// 	$('#inlineRadio1_modal').prop('checked',true);
	// }else{
	// 	$('#inlineRadio3_modal').prop('checked',true);
	// }

	$('#exampleKonsultasijawaban').modal('show');
	

}


$(document).ready(function(){
$("#form_jawaban_konsul_dokter").on("submit",function(e){
		e.preventDefault();
		// alert('hello world');

		$.ajax({  
			url:"<?php echo base_url(); ?>iri/rictindakan/insert_jawaban_konsul",                         
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
					// window.location.reload();
				
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
	<div class="card-header">
        <div class="container-fluid d-flex justify-content-between" style="width:100%;">
            <h5>Jawaban Konsultasi ( ANTAR BAGIAN )</h5>
			<a href="<?= base_url("/emedrec/C_emedrec_iri/konsul_dokter_iri/").$data_pasien[0]['no_ipd'].'/'.$data_pasien[0]['no_medrec'] ?>" target="_blank" class="btn btn-info">Lihat Konsultasi Sebelumnya</a>

        </div>
    </div>



	<form method="POST" id="form_jawaban_konsul_dokter" class="form-horizontal">
			<div class="card-body">

				<!-- <input type="hidden" name="idasalKonsul" id="idasalKonsul" value="<?php //echo $data_konsultasi ?>"> -->
				<input type="hidden" name="idasalKonsul" id="idasalKonsul" value="<?php echo $idkonsul; ?>">
				<?= textarea('hal_yang_ditemukan', 'Hal Hal Yang Ditemukan',isset($get_konsultasi_pasien_iri[0]->hal_yang_ditemukan)?$get_konsultasi_pasien_iri[0]->hal_yang_ditemukan:'')  ?>
				<?= textarea('kesan', 'Kesan',isset($get_konsultasi_pasien_iri[0]->kesan)?$get_konsultasi_pasien_iri[0]->kesan:'') ?>
				<?= textarea('anjuran', 'Anjuran',isset($get_konsultasi_pasien_iri[0]->anjuran)?$get_konsultasi_pasien_iri[0]->anjuran:'') ?>
			

				<div class="form-group row mb-4">
					<label class="col-sm-2  control-label col-form-label" id="dokter">Pengajuan Konsul Kembali</label>
					<div class="col-sm-8">
						<div class="form-inline">
						<input type="date" id="date_picker" class="form-control" placeholder="dd-mm-yyyy" name="pengajuan_konsul_kembali" >
						</div>
					</div>
				</div>

				<div class="form-group row mb-4">
					<label class="col-sm-2  control-label col-form-label" id="dokter">Pemindahan Pengobatan </label>
					<div class="col-sm-8">
						<div class="form-inline">
							<input type="radio" id="pemindahan_pengobatan" name="pemindahan_pengobatan" value="1">
							<label for="pemindahan_pengobatan">Ya</label>

							<input type="radio" id="pemindahan_pengobatan_tidak" name="pemindahan_pengobatan" value="0">
							<label for="pemindahan_pengobatan_tidak">Tidak</label>
						</div>
					</div>
				</div>


				
				
			</div>
			<div class="card-footer">
				<input type="hidden" class="form-control" value="<?php echo $history[0]->id; ?>" name="id_konsul">
				<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd">
				<button type="submit" class="btn btn-primary" id="btn-form-konsul-insert">Simpan</button>
			</div>
	</form>

</div>

	<div class="card m-5">
		<div class="card-header">
			<h5>Riwayat Jawaban Konsultasi</h5>
		</div>
		<div class="card-body">
			<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example" style="width:100%;" style="table-layout: fixed;">
				<thead>
				<tr>
					<th>No.</th>
					<th>Tgl Jawab Konsultasi</th>
					<th>Bagian</th>
					<!-- <th>Jawaban Konsultasi</th> -->
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
							<td><?= isset($value->tgl_jawaban)?date('d-m-Y H:i:s',strtotime($value->tgl_jawaban)):null ?></td>
							<td><?= $value->nm_poli ?></td>
							<!-- <td><?php //echo isset($value->is_accept)?$value->is_accept == '1'?'Diterima':'Ditolak':'Meminta Persetujuan' ?></td> -->
							<td><?= $value->nm_dokter_pengirim ?></td>
							<!-- <td><button type="button" data-value='<?php //echo json_encode($value); ?>' class="btn btn-primary dataparsingKonsultasijawaban" data-toggle="modal" data-target="#exampleKonsultasijawaban"> Detail </button></td> -->
							<td><button type="button" class="btn btn-primary" onclick='openModal(<?= json_encode($value); ?>)'> Detail </button></td>
						</tr>
					
					<?php
						}
					}else{
					?>
						<tr>  
							<td style="text-align:center;" colspan="4">Tidak ada Data</td>
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
<br>
<!-- history data --> 



<!-- modal -->
<div class="modal fade" id="exampleKonsultasijawaban" tabindex="-1" role="dialog" aria-labelledby="exampleKonsultasiLabeljawaban" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Konsultasi Dokter</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
			<?= textareaModel('hal_yang_ditemukan', 'Hal Hal Yang Ditemukan') ?>
			<?= textareaModel('kesan', 'Kesan') ?>
			<?= textareaModel('anjuran', 'Anjuran') ?>
			
			<div class="form-group row" >
				<label class="col-sm-2 control-label col-form-label" id="dokter">Pengajuan Konsul Kembali</label>
				<div class="col-sm-8">
					<div class="form-inline">
						<input type="date" id="date_picker" class="form-control" placeholder="dd-mm-yyyy" name="pengajuan_konsul_kembali">
					</div>
				</div>
	 		</div>
	
			<div class="form-group row">
				<label class="col-sm-2 control-label col-form-label">Pemindahan Pengobatan </label>
				<div class="col-sm-8">
					<input type="radio"  id="pindah" name="pemindahan_pengobatan" value="1">
					<label for="pemindahan_pengobatan">Ya</label>

					<input type="radio"  id="nonpindah" name="pemindahan_pengobatan" value="0">
					<label for="pemindahan_pengobatan_tidak">Tidak</label>
				</div>
			</div>
      </div>
      <div class="modal-footer">
	  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
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

	$('.dataparsingKonsultasijawaban').on('click',function(){
		// var value = $(this).data('value');
		// console.log(value);
	
		// $("#hal_yang_ditemukan_modal").val(value.hal_yang_ditemukan);
		// $("#kesan_modal").val(value.kesan);
		// $("#anjuran_modal").val(value.anjuran);
		

		// if(value.pemindahan_pengobatan == '0'){
		// 	$('#nonpindah').prop('checked',true);
	
		// }else{
		// 	$('#pindah').prop('checked',true);
		// }

		// $("input[name=pengajuan_konsul_kembali]").val(value.pengajuan_konsul_kembali);
		// $("#date_picker").val(value.pengajuan_konsul_kembali);
		

	});

	

	

</script>									
									


									
									

