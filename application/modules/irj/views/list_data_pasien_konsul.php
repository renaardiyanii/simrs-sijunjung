
<?php 
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}?>

<script type='text/javascript'>
$(function() {
	 
	$('#dataTables-example').DataTable();
	//url
	// $('#date_picker1').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	// $('#date_picker2').datepicker({
	// 			format: "yyyy-mm-dd",
	// 			//endDate: "current",
	// 			autoclose: true,
	// 			todayHighlight: true,
	// 	});
	

	// $('#date_picker_months').datepicker({
	// 	format: "yyyy-mm",
	// 	//endDate: "current",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	viewMode: "months", 
	// 	minViewMode: "months",
	// }); 
	// $('#date_picker_years').datepicker({
	// 	format: "yyyy",
	// 	//endDate: "current",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	format: "yyyy",
	// 	viewMode: "years", 
	// 	minViewMode: "years",
	// });
	// $('#date_picker1').show();
	// $('#date_picker2').show();
	// $('#date_picker_months').hide();
	// $('#date_picker_years').hide();
});	
function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}
	function cek_tampil_per(val_tampil_per){
		if(val_tampil_per=='TGL'){
	//		document.getElementById("date_picker_months").value = '';
	//		document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = true;
			document.getElementById("date_picker2").required = true;
	//		document.getElementById("date_picker_months").required = false;
	//		document.getElementById("date_picker_years").required = false;
			$('#date_picker1').show();
		//	$('#date_picker_months').hide();
			$('#date_picker2').show();
		//	$('#date_picker_years').hide();
		}else if(val_tampil_per=='BLN'){
			document.getElementById("date_picker1").value = '';
			// document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_years").value = '';
			document.getElementById("date_picker1").required = false;
			// document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = true;
			document.getElementById("date_picker_years").required = false;
			$('#date_picker1').hide();
			// $('#date_picker2').hide();
			$('#date_picker_months').show();
			$('#date_picker_years').hide();
		}else{
			document.getElementById("date_picker1").value = '';
			document.getElementById("date_picker2").value = '';
			document.getElementById("date_picker_months").value = '';
			document.getElementById("date_picker1").required = false;
			document.getElementById("date_picker2").required = false;
			document.getElementById("date_picker_months").required = false;
			document.getElementById("date_picker_years").required = true;
			$('#date_picker1').hide();
			$('#date_picker2').hide();
			$('#date_picker_months').hide();
			$('#date_picker_years').show();
		}
	}

</script>

<div >
	<div >
		
		<!-- <div class="container-fluid"><br/><br/>
			<div class="inline">
				<div class="row">
					<div class="form-inline">
						<form action="<?php echo base_url();?>irj/rjclaporan/pasien_baru_irj" method="post" accept-charset="utf-8">
						<div class="col-lg-12">
							<div class="form-inline">
								<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
									<option value="BLN">Bulan</option>
								</select>
								 <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_awal" onchange="cek_tgl_awal(this.value)" required>
								<input type="date" id="date_picker2" class="form-control" placeholder="Tanggal Akhir" name="tgl_akhir" onchange="cek_tgl_akhir(this.value)" required>
                                <input type="month" id="date_picker_months" class="form-control" placeholder="yyyy-mm" name="bulan">
 								<button class="btn btn-primary" type="submit">Tampilkan</button>
								
							</div>
						</div> /inline 
					</div>
					</form>		</div>						
			</div>
		</div>-->
			
		<div class="container-fluid"><br/>
		<section class="content">
				<div class="row">
						<div class="card card-outline-info">
							<div class="card-header text-white" align="center" >Data Kunjungan Pasien Konsultasi 
							</div>
							<div class="card-block">
								<br/>
						<div style="display:block;overflow:auto;">
						<table class="table table-hover table-striped table-bordered data-table" id="dataTables-example">
						  <thead>
							<tr>
								<th>No Register</th>
								<th>No Medrec</th>
								<th>Nama</th>
								<th>Tanggal Konsul</th>
								<th>Dokter Pengirim</th>
								<th>Poli Asal</th>
								<th>Dokter Penerima</th>
								<th>Poli TUjuan</th>
                                <th>Aksi</th>
							</tr>
						  </thead>

						  	<tbody>
				<?php
					// $i=0;
					foreach($data_kunjungan as $r){						
					?>
	

					<tr>
						<td><?php echo $r->no_reg;?></td>
						<td><?php echo $r->no_cm;?></td>
						<td><?php echo $r->nama;?></td>
						<td><?php echo date("d-m-Y", strtotime($r->tgl_konsul));?></td>
						<td><?php echo $r->dokter_asal;?></td>
						<td><?php echo $r->poli_asal;?></td>					
						<td><?php echo $r->dokter_akhir;?></td>
						<td><?php echo $r->poli_akhir;?></td>
						<td>
							<a target="_blank" href="<?php echo site_url('emedrec/C_emedrec/lembar_konsul_pasien/'.$r->no_reg.'/'.$r->no_cm.'/'.$r->no_medrec);?>"><input type="button" class="btn 
							btn-primary" value="Cetak Lembar Konsul"></a><br>
							<a target="_blank" href="<?php echo site_url('irj/rjcregistrasi/daftarulangnew/'.$r->no_medrec.'/'.$r->no_reg);?>"><input type="button" class="btn 
							btn-danger" value="Daftar Ulang"></a>
                        </td>							
					</tr>
				<?php
						}
					// }
					// $vtot=$vtot+($i-1);
				?>
					<!-- <tr>
						<td colspan="6"><p align="right"><b>Total</b></p></td>
						<td BGCOLOR="yellow"><p align="right"><b><?php echo $i-1;?></b></p></td>
					</tr> -->

							</tbody>
						</table>
						<br>
						<!-- <div class="form-inline" align="right">
							<div class="form-group">
								<a target="_blank" href="<?php //echo site_url('iri/riclaporan/cetak_laporan_harian/');?><?php //echo '/'.$tgl_awal ;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan PDF"></a>
								<a target="_blank" href="<?php echo site_url('irj/Rjclaporan/excel_lap_pasien_baru_irj/');?><?php echo '/'.$tgl;?>"><input type="button" class="btn 
								btn-primary" value="Cetak Laporan Excel"></a>
							</div>
						</div> -->
						</div><!-- style overflow -->
					</div><!--- end panel body -->
				</div><!--- end panel -->
				</div><!--- end panel -->
		</section>
		<!-- /Main content -->
		</div>

	</div>
</div>

<form method="POST" id="edit_form" class="form-horizontal">
          <!-- Modal Edit Obat -->
          <div class="modal fade" id="editModal" role="dialog" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-success">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Edit Konsul</h4>
                </div>
                <div class="modal-body">
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Konsul</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_id" id="edit_id" disabled="">
                      <input type="hidden" class="form-control" name="edit_id_hidden" id="edit_id_hidden">
					  <input type="hidden" class="form-control" name="noreg_hidden" id="noreg_hidden">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Tanggal Konsul</p>
                    <div class="col-sm-6">
                      <input type="datetime-local" class="form-control" name="edit_tgl" id="edit_tgl">
                    </div>
                  </div>
				  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Poli Tujuan</p>
                    <div class="col-sm-6">
						<input type="text" class="form-control" name="id_poli_old" id="id_poli_old" readonly>
						<input type="hidden" class="form-control" name="id_poli_hidden" id="id_poli_hidden">
                    </div>
                  </div>
				  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Dokter</p>
                    <div class="col-sm-6">
						<input type="text" class="form-control" name="id_dokter_konsul_new" id="id_dokter_konsul_new" readonly>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Pilih Poli</p>
                    <div class="col-sm-6">
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
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kelas Rawat</p>
                    <div class="col-sm-6">
						<input type="radio" id="none_class" name="kelas_pasien" value="NK">
						<label for="NK">None Class</label>
						<input type="radio" id="eksekutif" name="kelas_pasien" value="EKSEKUTIF">
						<label for="VVIP">Eksekutif</label>
                    </div>
                  </div>
				  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Pilih Dokter</p>
                    <div class="col-sm-6">
						<select id="id_dokter_konsul" class="form-control select2" style="width: 100%" name="id_dokter_akhir" required>
						
						</select>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kemungkinan Sangkaan</p>
                    <div class="col-sm-6">
						<textarea name="edit_kemungkinan" id="edit_kemungkinan" cols="30" rows="7"></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Bagian</p>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_asal" id="edit_asal" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Pengobatan</p>
                    <div class="col-sm-6">
						<textarea name="edit_pengobatan" id="edit_pengobatan" cols="30" rows="7"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Kelainan Kelainan</p>
                    <div class="col-sm-6">
						<textarea name="edit_kelainan" id="edit_kelainan" cols="30" rows="7"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Pengobatan yg telah di lakukan</p>
                    <div class="col-sm-6">
                      <textarea name="edit_pengobatan_yg_dilakukan" id="edit_pengobatan_yg_dilakukan" cols="30" rows="7"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Perhatian Khusus</p>
                    <div class="col-sm-6">
						<textarea name="edit_perhatian" id="edit_perhatian" cols="30" rows="7"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nasehat</p>
                    <div class="col-sm-6">
						<textarea name="edit_nasehat" id="edit_nasehat" cols="30" rows="7"></textarea>
                    </div>
                  </div>
				  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Permintaan Konsul</p>
                    <div class="col-sm-6">
						<input type="radio" id="alih_rawat" name="opsi_konsul" value="alih_rawat">
						<label for="pemindahan_pengobatan">Alih Rawat</label>

						<input type="radio" id="rawat_bersama" name="opsi_konsul" value="rawat_bersama">
						<label for="pemindahan_pengobatan_tidak">Rawat Bersama</label>

						<input type="radio" id="konsul_sekali" name="opsi_konsul" value="konsultasi_sekali">
						<label for="konnsultasi_sekali">Konsultasi 1x</label>
                    </div>
                  </div>
				  <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label"></p>
                    <div class="col-sm-6">
						<input type="checkbox" id="verif_daftar" name="verif_daftar" value="1">
						<label for="verif_daftar">Verifikasi Pendaftaran</label>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary" type="submit" id="btn-edit">Edit</button>
                </div>
              </div>
            </div>
          </div>
          </form>
<script>
	$('#calendar-tgl').datepicker();

	function edit(id) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('irj/rjclaporan/get_data_edit_konsul')?>",
      data: {
        id: id
      },
      success: function(data){
		//console.log(data)
        $('#edit_id').val(data[0].id);
        $('#edit_id_hidden').val(data[0].id);
		$('#noreg_hidden').val(data[0].no_register);
		$('#id_poli_hidden').val(data[0].id_poli_akhir);
        $('#edit_tgl').val(data[0].tanggal_konsul);
		$('#id_poli_old').val(data[0].poli_tujuan);
		$('#id_dokter_konsul_new').val(data[0].dokter_penerima);
		// $('#id_dokter_konsul').trigger('change');
        $('#edit_asal').val(data[0].poli_asal);
        $('#edit_kemungkinan').val(data[0].kemungkinan_sangkaan);
        $('#edit_pengobatan').val(data[0].pengobatan_untuk);
        $('#edit_kelainan').val(data[0].kelainan);
        $('#edit_pengobatan_yg_dilakukan').val(data[0].pengobatan);
        $('#edit_perhatian').val(data[0].perhatian_khusus);
        $('#edit_nasehat').val(data[0].nasehat);
        $('#opsi_konsul').val(data[0].opsi_konsul);
        //$('#verif_daftar').val(data[0].verif_daftar);
    //     $('#edit_minstok').val(data[0].min_stock);
		if(data[0].opsi_konsul == 'rawat_bersama'){
			$('#rawat_bersama').prop('checked',true);
		}else if(data[0].opsi_konsul === 'alih_rawat'){
			$('#alih_rawat').prop('checked',true);
		}else{
			$('#konsul_sekali').prop('checked',true);
		}

		if(data[0].kelas == 'NK') {
			$('#none_class').prop('checked',true);
		} else {
			$('#eksekutif').prop('checked',true);
		}
      },
      error: function(){
        alert("error");
      }
    });
  }

  $('#edit_form').on('submit', function(e){  
        e.preventDefault();             
        document.getElementById("btn-edit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
        $.ajax({  
          url:"<?php echo base_url(); ?>irj/rjclaporan/edit_konsul",                         
          method:"POST",  
          data:new FormData(this),  
          contentType: false,  
          cache: false,  
          processData:false,  
          success: function(data)  
          { 
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide'); 
            document.getElementById("edit_form").reset();
            swal({
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
            document.getElementById("btn-edit").innerHTML = 'Edit Obat';
            $('#editModal').modal('hide');
            swal("Error","Data gagal diperbaharui.", "error"); 
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          }  
        });   
      });

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
</script>

<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>


