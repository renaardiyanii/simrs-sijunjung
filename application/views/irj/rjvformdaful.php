    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 

<?php 
	foreach($detail_pasien as $row){ 
	$no_register=$row->no_register;
	$hubungan=$row->hubungan;
	$diagnosa1 = $row->diagnosa;
	$dokter1 = $row->id_dokter;
	$nmdokter = $row->nm_dokter;
	$asalrujukan = $row->asal_rujukan;
	$carakunjungan = $row->cara_kunj;
	$norujukan = $row->no_rujukan;
	$carabayar = $row->cara_bayar;
	$nobpjs1 = $row->no_kartu;
	$kelas1=$row->kelas_pasien;
	$poli1=$row->id_poli;
	$nosep1=$row->no_sep;
	$statusBp=$row->status_bpjs;
	//echo $row->tgl_rujukan;
}
?>
<script>
$(document).ready(function() {
	$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
	      checkboxClass: 'icheckbox_flat-green',
	      radioClass: 'iradio_flat-green'
	    });

	$('.select2').select2();
	//$("#biayadaftar_").maskMoney({thousands:',', decimal:'.', affixesStay: true});

	

	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
	
	

	var carakunj = "<?php echo $carakunjungan;?>";		
	
	if(carakunj!=''){
		$("#cara_kunj").val(carakunj);
	}

	var nosep = "<?php echo $nosep1;?>";		
	
	if(nosep==''){
		$('#btn-cetak-sep').addClass('disabled');
	}

	

	var carakunj = "<?php echo $carakunjungan;?>";
	if(carakunj!=''){
	$("#carakunj1").val(carakunj);
	}

	var hubungan = "<?php echo $hubungan;?>";
	if(hubungan!=''){
	$("#hubungan1").val(hubungan);
	}

	var poli = "<?php echo $poli1;?>";
	if(poli!=''){
	$("#pilihPoli").val(poli).change();
	}
	
	var diag = "<?php echo $diagnosa1;?>";
	var n = diag.length;
	if(diag!=''){
		$("#id_diagnosa").val(diag);
		
	}
	
	var dokter = "<?php echo $dokter1;?>";
	var nmdokter = "<?php echo $nmdokter;?>";

	if(dokter!=''){
		$("#operatorTindakan").val(dokter).change();		
	}

	//$row1->id_dokter.'@'.$row1->nm_dokter.
	
	
	var rujukan = "<?php echo $asalrujukan;?>";
	if(rujukan!='')
	{
		$("#asal_rujukan").val(rujukan);
	}

	var carabayar = "<?php echo $carabayar;?>";
	if(carabayar!='')
	{
		$("#cara_bayar1").val(carabayar).change();
		if(carabayar=='BPJS'){
			var noBpjs = "<?php echo $nobpjs1; ?>";			
			if(noBpjs!=''){
				$('#content_warn_kartu').val('No. Kartu : '+noBpjs);
			}else{
				$('#content_warn_kartu').val('Isi terlebih dahulu No. Kartu BPJS Pasien');
			}
		}
	}

});
var ajaxku;
function pilih_cara_bayar(val_cara_bayar){
		var res=val_cara_bayar.split("-");//it Works :D
		if(val_cara_bayar!=''){
			//document.getElementById("biayadaftar").value = res[1];
			document.getElementById("cara_bayar1").value = val_cara_bayar;
		}else{
			//document.getElementById("biayadaftar").value = '';
			document.getElementById("cara_bayar1").value = '';
		}
		if(val_cara_bayar=='DIJAMIN'){
			$('#cek_sep').hide();
			document.getElementById("input_kontraktor").required = true;
			$('#input_kontraktor').show();
			//$('#btnUpdate').show();
			//$('#btnCetak').hide();
		}else{
			$('#input_kontraktor').hide();
			$('#cek_sep').hide();
			//NoSEPdiv
			document.getElementById("input_kontraktor").required = false;
			$('#NoSEPdiv').hide();
			$('#btn-cetak-sep').hide();
			//$('#btnUpdate').show();
			//$('#btnCetak').hide();
		}
		if(val_cara_bayar=='BPJS'){
			//document.getElementById("biayadaftar_").value='0';
			//document.getElementById("biayadaftar").value='0';
			$('#cek_sep').show();
			$('#NoSEPdiv').show();
			$('#btn-cetak-sep').show();
			var noBpjs = "<?php echo $nobpjs1; ?>";			
			if(noBpjs!=''){
				document.getElementById("content_warn_kartu").innerHTML = "No. Kartu : "+noBpjs;
			}else{
				document.getElementById("content_warn_kartu").innerHTML = "Isi terlebih dahulu No. Kartu BPJS Pasien";
			}
			//$('#btnUpdate').hide();
			//$('#btnCetak').show();
			//alert('hahahaha');
			//$("#no_rujukan").attr("disabled", true);
			//$("#asal_rujukan").attr("disabled", true);
			//document.getElementById("no_rujukan").required = true;
			//document.getElementById("asal_rujukan").required = true;
			//document.getElementById("tgl_rujukan").required = true;
			//document.getElementById("cek_sep").show;
			//$('#biayadaftar_').val('0');
			//$('#biayadaftar').val('0');
		}else{
			
			$('#cek_sep').hide();
			$('#btn-cetak-sep').hide();
			//$('#btnUpdate').show();
			//$('#btn-cetak-sep').hide();

			document.getElementById("no_rujukan").required = false;
			document.getElementById("asal_rujukan").required = false;
			document.getElementById("tgl_rujukan").required = false;
			//$("#no_rujukan").removeAttr("disabled");
			//$("#asal_rujukan").removeAttr("disabled");
			//document.getElementById("biayadaftar_").value='15,000';
			//document.getElementById("biayadaftar").value='15000';
			//$('#biayadaftar_').val('15,000');
			//$('#biayadaftar').val('15000');
		}
	}

function ajaxdokter(id_poli){


	//var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_dokter_poli'); ?>";
    url=url+"/"+id_poli;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	//document.getElementById("id_provinsi").value = res[0];
	//document.getElementById("provinsi").value = res[1];
	
}
function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("operatorTindakan").innerHTML = data;
		}/*else{
		document.getElementById("id_dokter").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
		}*/
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

function cek_nokartu(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('ird/IrDRegistrasi/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedSEP;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}

function stateChangedSEP(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("data_anggota").innerHTML = data;
			$('#data_webservice').modal('show');
		}else{
			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
		}
    }
}

function ambil_sep(){
	var url_sep="<?php echo site_url('ird/IrDRegistrasi/ambil_sep'); ?>";

	var no_reg = "<?php echo $no_register;?>";
	$.ajax({
        type: "POST",
        url: url_sep+"/"+no_reg,
    }).done(function(msg) {
    	obj = JSON.parse(msg);
    	if(obj.status == 0){
    		alert(obj.response);
		$('#btn-cetak-sep').addClass('disabled');
    	}else{
    	  	$('#no_sep').val(obj.response);
		$('#no_sep_hidden').val(obj.response);
		$('#btn-cetak-sep').removeClass('disabled');
    	}
    });
}
</script>
<div class="card card-outline-info">
	<div class="card-header">
        <h4 class="m-b-0 text-white text-center">DETAIL PASIEN</h4>
    </div>
    <div class="card-block p-b-15">	
    	<?php echo form_open('irj/rjcregistrasi/insert_pasien_bpjs');?>
						<br>
						<br>
						<?php
								foreach($detail_pasien as $row){
								
								$no_medrec=$row->no_medrec;
								$nama=$row->nama;
								$no_register=$row->no_register;
								
								//cek jenis kunjungan
								if ( date("Y-m-d") == substr($row->tgl_daftar,0,10) ) 
									$jns_kunjungan="BARU";
								else $jns_kunjungan="LAMA";
							?>													
						<input type="hidden" class="form-control" value="<?php echo $row->no_medrec;?>"name="no_medrec">
						<input type="hidden" class="form-control" value="<?php echo $row->no_register;?>"name="no_register">
						
						<input type="hidden" id="no_sep_hidden" name="no_sep_hidden">
						<div class="col-lg-10" style="margin: 0 auto;">																		
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="jns_kunj">Jenis Kunjungan</label>
								<div class="col-sm-6">
									<div class="form-inline">
										<div class="form-group">
											<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" readonly name="no_medrec">
											<?php echo ($jns_kunjungan == "LAMA" ? 
											
												'
												<input type="radio" class="flat-red" name="jns_kunj" class="jns_kunj" value="LAMA" checked>&nbsp;Lama
												&nbsp;&nbsp;&nbsp;
												<input type="radio" class="flat-red " name="jns_kunj" class="jns_kunj" value="BARU" disabled>&nbsp;Baru
								
												<input type="hidden"  name="jns_kunj" value="'.$jns_kunjungan.'">
												'
											:
											
												'
												<input type="radio"  class="flat-red" name="jns_kunj" class="jns_kunj" value="LAMA" disabled>&nbsp;Lama
												&nbsp;&nbsp;&nbsp;
												<input type="radio" class="flat-red" name="jns_kunj" class="jns_kunj" value="BARU" checked>&nbsp;Baru
												
												<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
												'
											);
											?>
											
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="namapserta">Nama</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" placeholder="" value="<?php echo $row->nama;?>" name="nama" readonly>
								</div>
							</div>
							<div class="form-group row">
							
								<label class="col-sm-3 control-label" >Cara Kunjungan *</label>
								<div class="col-sm-6">
											<select class="form-control" style="width: 100%" name="cara_kunj" id="cara_kunj" required>
												<option value="">-Pilih Cara Kunjungan-</option>
												<?php 
												foreach($cara_berkunjung as $row1){
													echo '<option value="'.$row1->cara_kunj.'">'.$row1->cara_kunj.'</option>';
												}
												?>
											</select>
								</div>
							</div>
							<div class="form-group row">
							
								<label class="col-sm-3 control-label" >Cara Bayar*</label>
								<div class="col-sm-6">
											<select id="cara_bayar1" class="form-control" name="cara_bayar" onchange="pilih_cara_bayar(this.value)" required>					
												<option value="">-Pilih Cara Bayar-</option>
												<?php 
												foreach($cara_bayar as $row1){
													echo '<option value="'.$row1->cara_bayar.'">'.$row1->cara_bayar.'</option>';
												}
												?>
											</select>
								</div>
							</div>
							<div class="form-group row" id="input_kontraktor">
								<label class="col-sm-3 control-label" id="lbl_input_kontraktor">Kontraktor</label>
								<div class="col-sm-6">
									<select id="jenis_kontraktor" class="form-control select2" name="jenis_kontraktor" style="width : 100%;">
												
												<option value="">-Pilih Kontraktor-</option>
												<?php 
												foreach($kontraktor as $row1){
													 if($row->id_kontraktor!='' and $row->id_kontraktor==$row1->id_kontraktor){ echo '<option value="'.$row1->id_kontraktor.'" selected>'.$row1->nmkontraktor.'</option>';}else
													echo '<option value="'.$row1->id_kontraktor.'">'.$row1->nmkontraktor.'</option>';
												}
												?>
									</select>
								</div>
							</div>
							<div class="form-group row" id="cek_sep" name="cek_sep"  style="width:99%;">
								<div class="pull-right"><a href="#responsive" class="btn btn-danger" onclick="cek_nokartu('<?php echo $row->no_medrec;?>')" >Validasi</a>
								</div>							
							</div>
							<div class="form-group row" id="warn_kartu">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-6">
									<p class="control-label" id="content_warn_kartu" style="color: red;"></p>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label" >Asal Rujukan </label>
								<div class="col-sm-6">
											<select class="form-control select2" style="width: 100%" name="asal_rujukan" id="asal_rujukan">
												<?php if($row->asal_rujukan!=''){ echo '<option value='.$row->asal_rujukan.'>'.$row->nm_ppk.'</option>'; } ?>
												<option value="0">-Pilih Asal Rujukan-</option>
												<option value="1">Lainnya</option>
												<?php 
												foreach($ppk as $row1){
													echo '<option value="'.$row1->kd_ppk.'">'.$row1->nm_ppk.'</option>';
												}
												?>
											</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label" >No. SJP/Rujukan</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" placeholder="" name="no_rujukan" id="no_rujukan" value="<?php echo $row->no_rujukan; ?>">
								</div>
							</div>	
							<div class="form-group row">
								<label class="col-sm-3 control-label"> Tgl. Rujukan</label>
								<div class="col-sm-6">
									<input type="date" class="form-control" placeholder="" id="tgl_rujukan" name="tgl_rujukan" value="<?php if($row->tgl_rujukan!=''){echo date("Y-m-d", strtotime($row->tgl_rujukan));} ?>">
								</div>
							</div>					
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="kelas_pasien">Kelas Pasien</label>
								<div class="col-sm-6">
									<select class="form-control" name="kelas_pasien" id="kelas_pasien1" required >
										<option value="III">III</option>										
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="tanggal_kunj">Tanggal Kunjungan</label>
								<div class="col-sm-6">
									<input type="date" class="form-control" placeholder="eg : 2001-05-11" id="tgl_kunj" name="tgl_kunj" value="<?php echo date('Y-m-d', strtotime($row->tgl_kunjungan)); ?>"  required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="dirujuk_ke">Tujuan Poliklinik*</label>
								<div class="col-sm-6">
											<select id="pilihPoli" class="form-control select2" style="width: 100%" name="id_poli"  onchange="ajaxdokter(this.value)" required>
												<option value="">-Pilih Nama Poli-</option>
												<?php 
												foreach($poli as $row1){
													echo '<option value="'.$row1->id_poli.'">'.$row1->nm_poli.'</option>';
												}
												?>
											</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="dokter">Dokter *</label>
								<div class="col-sm-6">
									<div class="form-inline">
											<select id="operatorTindakan" class="form-control select2" style="width: 100%" name="id_dokter">
												<option value="">-Pilih Dokter-</option>
												<?php 
												foreach($dokter as $row1){
													echo '<option value="'.$row1->id_dokter.'">'.$row1->nm_dokter.'</option>';
												}
												?>
											</select>
									</div>
								</div>
							</div>																								
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="nama_penjamin">Nama Penjamin</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" placeholder="" name="nama_penjamin" value="<?php echo $row->nama_penjamin;?>">
								</div>
							</div>														
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="pasdatDg">Datang dengan</label>
								<div class="col-sm-6"><select class="form-control" name="pasdatDg" id="pasdatDg">									
									<option value="klg">Keluarga</option>
									<option value="ttg">Tetangga</option>
									<option value="lain">Lain-lain</option>
								</select></div>
							</div>															
							<div class="form-group row" id="diagnosa1">
								<label class="col-sm-3 control-label" >Diagnosa*</label>
								<div class="col-sm-6">																					
									<select id="id_diagnosa" name="id_diagnosa" class="form-control "  required>
												<option value="">-Pilih Diagnosa-</option>
												
												<?php 
												foreach($diagnosa as $row1){
													echo '<option value="'.$row1->id_icd.'">'.$row1->id_icd.' - '.$row1->nm_diagnosa.'</option>';
												}
												?>
											</select>			
								</div>
							</div>																								
							<div class="form-group row">
								<label class="col-sm-3 control-label" id="hubungan">Hubungan Keluarga</label>
								<div class="col-sm-6">
									<select class="form-control" name="hubungan" id="hubungan1">
																					
										<option value="">-Pilih Hubungan-</option>
										<option value="Ybs.">Ybs.</option>
										<option value="Istri">Istri</option>
										<option value="Suami">Suami</option>
										<option value="Anak">Anak</option>
									</select>
								</div>
							</div>
							<div class="form-group row" id="NoSEPdiv">
								<label class="col-sm-3 control-label" >No SEP</label>
								<div class="col-sm-6">
									<div class="input-group">
										
										<input type="text" class="form-control" name="no_sep" id="no_sep" value="<?php echo $row->no_sep;?>">
										
										<!-- <span class="input-group-btn">
										<button type="button" class="btn btn-primary btn-sm" onclick="ambil_sep()" id="button-ambil-sep" ><i class="fa fa-save"></i> Ambil SEP</button>			</span> -->
									</div>
								</div>
							</div>																							
						</div><!-- end div col-lg-10-->								
			<hr>
			<div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                         <div class="row">
                             <div class="col-md-12 text-center">
                                <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
								<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
								<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan</button>
								<button type="button" class="btn waves-effect waves-light btn-info" id="btn-submit">Cetak SEP</button>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
            <?php echo form_close();}?>
	<!-- 	</div>  -->
		<!-- end tab content -->		
	</div><!-- Card Box -->
</div><!-- Card -->		

<?php
	include('webservice_modal.php');
	?>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 
