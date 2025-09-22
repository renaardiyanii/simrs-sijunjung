<?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 
	<?php 
	include('script_rjvpelayanan.php');	
	
	?>

<?php
	//$this->load->view('layout/header.php');
?>
<script>
$(function() {	
	$('.auto_search_poli').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});
	$('#dirujuk_rj_ke_poli').hide();
	$('#pilih_dokter').hide();
	$('#div_tgl_kontrol').hide();
	$('#date_picker').datepicker({
		format: "yyyy-mm-dd",
		//endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});

	var lab="<?php echo $rujukan_penunjang->lab;?>";
	var pa="<?php echo $rujukan_penunjang->pa;?>";
	var rad="<?php echo $rujukan_penunjang->rad;?>";
	var obat="<?php echo $rujukan_penunjang->obat;?>";
	
	if(lab=='1' && pa=='1' && rad=='1' && obat=='1'){
		 document.getElementById("button_simpan_rujukan").disabled= true;
	}
	
});		
function pilih_ket_pulang(ket_plg){
	if(ket_plg=='PULANG'){
		$('#div_tgl_kontrol').show();
		$('#dirujuk_rj_ke_poli').hide();
		$('#pilih_dokter').hide();
		document.getElementById("btn_simpan").value = 'Simpan';
	} else {
		$('#div_tgl_kontrol').hide();
		if(ket_plg=='DIRUJUK_RAWATJALAN'){
			$('#dirujuk_rj_ke_poli').show();
			$('#pilih_dokter').show();
			//document.getElementById("btn_simpan").value = 'Cetak Karcis';
			document.getElementById("id_poli_rujuk").required = true;
			document.getElementById("id_dokter_rujuk").required = true;
			$('#div_tgl_kontrol').hide();
		}else{
			$('#dirujuk_rj_ke_poli').hide();
			$('#pilih_dokter').hide();
			document.getElementById("id_poli_rujuk").required = false;
			document.getElementById("id_dokter_rujuk").required = false;
			//document.getElementById("btn_simpan").value = 'Simpan';
		}
	}
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
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	
}
var ajaxku;
function stateChangedDokter(){
    var data;
	//alert(ajaxku.responseText);
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter_rujuk").innerHTML = data;
		}
    }
	
}
</script>
<section class="content-header">
	<div class="row">
		<div class="col-sm-12">
			<div class="card card-outline-info">
                    <div class="card-header">
                        <h5 class="m-b-0 text-white text-center">Data Pasien</h5>
                    </div>
                   	<div class="card-block">
                   		<div class="row">
							<div class="col-sm-12 text-center">
								<img height="100px" class="img-rounded" src="<?php 
								if($data_pasien_daftar_ulang->foto==''){
									echo site_url("upload/photo/unknown.png");
								}else{
									echo site_url("upload/photo/".$data_pasien_daftar_ulang->foto);
								}
								?>">
							</div>
							<div class="col-sm-6 table-responsive">
								<table class="table table-striped" style="font-size:15">
									<tbody>
										<tr>
											<th>Nama</th>
											<td>:&nbsp;</td>
											<td><?php echo strtoupper($data_pasien_daftar_ulang->nama);?></td>
										</tr>
										<tr>
											<th>No. CM</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->no_cm;?></td>
										</tr>
										<tr>
											<th>No. Register</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->no_register;?></td>
										</tr>
										<tr>
											<th>Umur</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->umurrj.' Tahun '.$data_pasien_daftar_ulang->ublnrj.' Bulan '.$data_pasien_daftar_ulang->uharirj.' Hari';?></td>
										</tr>
										<tr>
											<th>Gol Darah</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->goldarah;?></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-6 table-responsive">
								<table class="table table-striped" style="font-size:15">
									<tbody>
										<tr>
											<th>Tanggal Kunjungan</th>
											<td>:&nbsp;</td>
											<td><?php echo date('d-m-Y | H:i',strtotime($data_pasien_daftar_ulang->tgl_kunjungan));?></td>
										</tr>
										<tr>
											<th>Kelas</th>
											<td>:&nbsp;</td>
											<td><?php echo $kelas_pasien;?></td>
										</tr>
										<tr>
											<th>Cara Bayar</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->cara_bayar;?></td>
										</tr>
										<tr>
											<th>Cara Kunjungan</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->cara_kunj;?></td>
										</tr>
										<tr>
											<th>Status Pulang</th>
											<td>:&nbsp;</td>
											<td><?php echo $data_pasien_daftar_ulang->ket_pulang;?></td>
										</tr>
									 </tbody>
								</table>
							</div>
                   		</div>
					</div>
				</div>
			</div>	
</section>

	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="card ">
						<div class="card-block" align="center">
							<ul class="nav nav-tabs customtab" role="tablist">
                                <li class="nav-item text-center"> 
                                	<a class="nav-link active" data-toggle="tab" href="#tabFisik" role="tab"><span class="hidden-xs-down">Pemeriksaan Fisik</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabTindakan" role="tab"><span class="hidden-xs-down">Tindakan</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabDiagnosa" role="tab"><span class="hidden-xs-down">Diagnosa</span></a> 
                                </li>
                                <?php if ($data_pasien_daftar_ulang->cara_bayar == 'BPJS') { ?>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabProsedur" role="tab"><span class="hidden-xs-down">Prosedur</span></a> 
                                </li>
                                <?php } ?>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabOperasi" role="tab"><span class="hidden-xs-down">Operasi</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabLaborat" role="tab"><span class="hidden-xs-down">Laboratorium</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabPatologi" role="tab"><span class="hidden-xs-down">Patologi Anatomi</span></a> 
                                </li>
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabRadiologi" role="tab"><span class="hidden-xs-down">Radiologi</span></a> 
                                </li>                                
                                <li class="nav-item text-center"> 
                                	<a class="nav-link" data-toggle="tab" href="#tabResep" role="tab"><span class="hidden-xs-down">Resep</span></a> 
                                </li>
                            </ul>
						</div>
						
						<!--<div class="panel-body" style="display:block;overflow:auto;">
						<br/>-->
						<div class="tab-content">
							<div class="tab-pane active" id="tabFisik" role="tabpanel">
                                    <div class="p-20">
                                        <?php include('rjvformfisik_view.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabTindakan" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('rjvformtindakan_view.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabDiagnosa" role="tabpanel">
                                	<div class="col-md-12">
                                        <div class="table-responsive">
											<table id="table_diagnosa_view" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>No</th>
														<th>Diagnosa</th>
														<th>Catatan</th>
														<th class="text-center">Klasifikasi</th>				
													</tr>
												</thead>
												<tbody>	
												</tbody>
											</table>
										</div> <!-- table-responsive -->
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabProsedur" role="tabpanel">
                                	<div class="col-md-12">
                                        <div class="table-responsive">
											<table id="tabel_procedure_view" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th>No</th>
														<th>Prosedur</th>
														<th>Catatan</th>
														<th class="text-center">Klasifikasi</th>											
													</tr>
												</thead>
												<tbody>
											
												</tbody>
											</table>
										</div> <!-- table-responsive -->
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabOperasi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_ok.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabLaborat" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_lab.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabPatologi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_pa.php');  ?>
                                    </div>
                                </div>
                                <div class="tab-pane p-20" id="tabRadiologi" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_rad.php');  ?>
                                    </div>
                                </div>                                
                                <div class="tab-pane p-20" id="tabResep" role="tabpanel">
                                	<div class="p-20">
                                        <?php include('form_resep.php');  ?>
                                    </div>
                                </div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<!-- Modal -->
<div class="modal fade" id="form-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
      </div>
	  
        <?php echo form_open('irj/rjcpelayanan/update_tindakan');?>
      <div class="modal-body">
		  <div style="display:block;overflow:auto;">
								<div class="form-group row">
								<p class="col-sm-2 form-control-label" id="tindakan">Tindakan</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<input type="search" style="width:450px" class="auto_search_tindakan2 form-control" placeholder="" id="nmtindakan2" name="nmtindakan2" required>
												<input type="text" class="form-control" class="form-control" readonly placeholder="ID Tindakan" id="idtindakan2"  name="idtindakan2">
											</div>
										</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="operator">Pelaksana</p>
										<div class="col-sm-8">
											<div class="form-inline">
												<input type="search" style="width:450px" class="auto_search_operator2 form-control" placeholder="" id="nm_dokter2" name="nm_dokter2" required>
												<input type="text" class="form-control" placeholder="ID Dokter" id="id_dokter2" readonly name="id_dokter2" >
											</div>
										</div>
								</div>
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Poli</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" value="" name="biaya_poli2" id="biaya_poli2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind</p>
									<div class="col-sm-8">
										<input type="number" class="form-control" value="1" name="qtyind2" id="qtyind2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_dijamin">Dijamin</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="" name="dijamin2" id="dijamin2">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control" value="" name="vtot2" id="vtot2">
									</div>
								</div>
		  </div>
      </div>
      <div class="modal-footer">
		<input type="hidden" class="form-control" value="" name="id_pelayanan_poli2" id="id_pelayanan_poli2">
		<input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
		<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="reset" class="btn btn-default">Reset</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
    </div>
        <?php echo form_close();?>
  </div>
</div>
<!-- Modal -->
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?>
