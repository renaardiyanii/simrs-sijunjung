<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<style type="text/css">
.canvas{
	border:1px solid #ccc;
	border-radius:10px;
}
.demo-radio-button label{min-width:120px;}
</style>
<script type='text/javascript'>



var site = "<?php echo site_url();?>";
$(function() {
	var radios = document.querySelectorAll('input[type=radio][name="jenis_identitas"]');
	var radios_pasutri = document.querySelectorAll('input[type=radio][name="status"]');
	var radios_sex = document.querySelectorAll('input[type=radio][name="sex"]');
	// var bhs = document.querySelectorAll('input[type=radio][name="bahasa"]');
	var gender;

	$('#label_nama_suami').hide();
	$('#nama_suami').hide();
	$('#label_nama_istri').hide();
	$('#nama_istri').hide();
	// $('#bahasalainnya').hide();

	// Array.prototype.forEach.call(bhs, function(radio) {
	// 	radio.addEventListener('change', changeHandlerBahasa);
	// });


	Array.prototype.forEach.call(radios_sex, function(radio) {
		radio.addEventListener('change', changeHandlerSex);
	});
	
	Array.prototype.forEach.call(radios, function(radio) {
		radio.addEventListener('change', changeHandlerJenisIdentitas);
	});

	Array.prototype.forEach.call(radios_pasutri, function(radio) {
		radio.addEventListener('change', changeHandlerStatus);
	});

	

	


	var jenis_identitas = $('#jenis_identitas').val();
	set_ident("");	
	$(".select2").select2();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();

	// $('.date_picker').datepicker({
	// 	dateFormat: "dd-mm-yy",
  	// 	changeMonth: true,
  	// 	changeYear: true,
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	yearRange: "c-100:c+100",	
    //    maxDate: 0,
	   
	// });  

	 $('.load_wilayah').select2({
        placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
        ajax: {
          url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah'); ?>',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            var results = [];

                $.each(data, function(index, item){
                    results.push({
                        id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
                        text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
                    });
                });
                return { results: results };
          },
          cache: true
        }
    });
});

function cek_no_identitas(no_identitas){
	if(no_identitas!=''){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/",
		success: function(data){
			// var jsonData = JSON.parse(data);
			console.log(data.no_cm);
			if(data){
				swal("Peringatan", "No KTP Sama dengan no RM : "+ data.no_cm + '.', "error");
				// document.getElementById("btn-submit").disabled= true;				

			}else{
				// document.getElementById("btn-submit").disabled= false;
			}
			// if (data>0) {
			// 	document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
			// 	// console.log(data);
			// 	// document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			// 	$("#duplikat_id").show();
			// } else {
			// 	$("#duplikat_id").hide();
			// 	// document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			// 	// swal("Error", "Pendaftaran Gagal. Silahkan coba lagi.", "error");	
			// }
		},
		error: function (request, status, error) {
			// alert(request.responseText);
		}
    });}
}

function changeHandlerSex(event){
	gender = this.value;
}

function changeHandlerByBpjs(sex){
	gender = sex;
}

function changeHandlerStatus(event) {
	switch (this.value) {
		case "":
			$("#label_nama_suami").hide(); 
			$("#nama_suami").hide(); 
			$("#label_nama_istri").hide(); 
			$("#nama_istri").hide();
			break;
		case "B":	
			$("#label_nama_suami").hide(); 
			$("#nama_suami").hide(); 
			$("#label_nama_istri").hide();
			$("#nama_istri").hide();
			break;
		case "K":
			if(gender == 'L'){
				$("#label_nama_istri").show(); 
				$("#nama_istri").show(); 
				$("#label_nama_suami").hide(); 
				$("#nama_suami").hide(); 
				$("#nama_suami").val(''); 
			}else if(gender == 'P'){
				$("#label_nama_suami").show();
				$("#nama_suami").show();
				$("#label_nama_istri").hide(); 
				$('#nama_istri').val('');
				$("#nama_istri").hide();
			}
			break;
		default:
			$("#label_nama_suami").hide(); 
			$("#nama_suami").hide(); 
			$("#label_nama_istri").hide();
			$("#nama_istri").hide();
			break;
		}
}




function changeHandlerJenisIdentitas(event) {
	switch (this.value) {
		case "":
			// console.log('KOSONG')
			// document.getElementById("no_identitas").required = false;		
			$("#btn_cek_nik").hide();    
			$("#label-identitas").html("No. Identitas");
			$("#div-no-identitas").hide();
			break;
		case "KTP":
			// console.log('KTP')
			// document.getElementById("no_identitas").required = true;		
			$("#btn_cek_nik").show(); 
			$("#label-identitas").html("No. NIK *");
			$("#div-no-identitas").show();
			break;
		case "LAINNYA":
			// console.log('KTP')
			// document.getElementById("no_identitas").required = true;		
			// $("#btn_cek_nik").show(); 
			// $("#label-identitas").html("No. NIK *");
			$("#no_identitas").val("-");
			$("#div-no-identitas").hide();
			break;
		default:
			// console.log(this.value);
			// document.getElementById("no_identitas").required= true;		
			$("#btn_cek_nik").hide(); 
			$("#label-identitas").html("No. "+this.value); 
			$("#div-no-identitas").show();
			break;
		}
}



function set_ident(ident) {
	$("#no_identitas").val("");
	if (ident == "") {
		document.getElementById("no_identitas").required = true;		
		$("#btn_cek_nik").hide();    
		$("#label-identitas").html("No. Identitas");
		$("#div-no-identitas").hide();
	} else if (ident == "KTP") {
		document.getElementById("no_identitas").required = true;		
		$("#btn_cek_nik").show(); 
		$("#label-identitas").html("No. NIK");
		$("#div-no-identitas").show();
	} else {
		document.getElementById("no_identitas").required= true;		
		$("#btn_cek_nik").hide(); 
		$("#label-identitas").html("No. "+ident); 
		$("#div-no-identitas").show();
	}
}

function terapkan_data_bpjs() {
	var tgl_lahir = $('#bpjs_tgl_lahir').text();	
	var nama = $('#bpjs_nama').text();	
	var no_nik = $('#bpjs_nik').text();	
	var no_bpjs = $('#bpjs_noka').text();	
	var gender = $('#bpjs_gender').text();	

	$('#tgl_lahir').val(tgl_lahir);	        			
	$('#nama').val(nama);
	if (data.nik != '') {
		$('#jenis_identitas').val('KTP');
		$('#jenis_identitas').trigger('change');
		$('#no_identitas').val(no_nik);
		$('#no_bpjs').val(no_bpjs);
	}
	if (gender == 'L') {
		$('#laki_laki').prop('checked', true);
	}
	if (gender == 'P') {
		$('#perempuan').prop('checked', true);
	}
	changeHandlerByBpjs(gender);
	$('.modal_nobpjs').modal('hide');
}

function cek_nobpjs(){
	document.getElementById("btn_cek_kartu").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
    no_bpjs = $("#no_bpjs").val();
    if (no_bpjs == '') {
    	document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS';
    	swal("No. Kartu Kosong","Masukan terlebih dulu nomor kartu BPJS.", "warning"); 
    } else {       	
	    $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('bpjs/peserta/no_kartu'); ?>",
	        dataType: "JSON",
	        data: {"no_bpjs" : no_bpjs},
	        success: function(result){
	        	if (result != '') {
	        		if (result.metaData.code == '200') {
	        			document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS'; 	
	        			data = result.response.peserta;	        				        		
	        			$('.modal_nobpjs').modal('show');
	        			document.getElementById("bpjs_noka").innerHTML = data.noKartu;
	        			document.getElementById("bpjs_nik").innerHTML = data.nik;
	        			document.getElementById("bpjs_nama").innerHTML = data.nama;	        			
	        			document.getElementById("bpjs_gender").innerHTML = data.sex;
	        			document.getElementById("bpjs_tgl_lahir").innerHTML = data.tglLahir;
	        			document.getElementById("bpjs_no_telepon").innerHTML = data.mr.noTelepon;	        			
	        			document.getElementById("bpjs_kdprovider").innerHTML = data.provUmum.kdProvider;
	        			document.getElementById("bpjs_nmprovider").innerHTML = data.provUmum.nmProvider;	        			
	        			document.getElementById("bpjs_jnspeserta").innerHTML = data.jenisPeserta.keterangan;	        		
	        			document.getElementById("bpjs_nmkelas").innerHTML = data.hakKelas.keterangan;	        			
	        			document.getElementById("bpjs_status_keterangan").innerHTML = data.statusPeserta.keterangan;  
	        			document.getElementById("bpjs_cob_nama").innerHTML = data.cob.nmAsuransi;
	        			document.getElementById("bpjs_cob_nomor").innerHTML = data.cob.noAsuransi;	        			
	        			document.getElementById("bpjs_cob_tat").innerHTML = data.cob.tglTAT;	        		
	        			document.getElementById("bpjs_cob_tmt").innerHTML = data.cob.tglTMT; 
	        			document.getElementById("bpjs_informasi_dinsos").innerHTML = data.informasi.dinsos;	        			
	        			document.getElementById("bpjs_informasi_sktm").innerHTML = data.informasi.noSKTM;	
	        			document.getElementById("bpjs_informasi_prb").innerHTML = data.informasi.prolanisPRB;		        	
	        		} else {
	        			document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS'; 	
	        			swal("Gagal Cek Peserta BPJS.",result.metaData.message, "error");
	        		}	              	
	        	} else {
	        		document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS';
	              	swal("Error","Gagal Cek Peserta BPJS.", "error");  
	        	}
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btn_cek_kartu").innerHTML = 'Cek Peserta BPJS';
	            swal("Error","Gagal Cek Peserta BPJS.", "error");                   
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        }
	    });
    }
}
function cekbpjs_nik(){
	document.getElementById("btn_cek_nik").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
    no_nik = $("#no_identitas").val();
    if (no_nik == '') {
    	swal("NIK Kosong","Mohon masukkan NIK yang valid.", "warning"); 
    	document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
    } else {    	
	    $.ajax({
	        type: "POST",
	        url: "<?php echo site_url('bpjs/peserta/nik'); ?>",
	        dataType: "JSON",
	        data: {"no_nik" : no_nik},
	        success: function(result){ 
	        	if (result) {
	        		document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
	        		if (result.metaData.code == '200') {
	        			data = result.response.peserta;	    		        		
	        			$('.modal_nobpjs').modal('show');
	        			document.getElementById("bpjs_noka").innerHTML = data.noKartu;
	        			document.getElementById("bpjs_nik").innerHTML = data.nik;
	        			document.getElementById("bpjs_nama").innerHTML = data.nama;	        			
	        			document.getElementById("bpjs_gender").innerHTML = data.sex;
	        			document.getElementById("bpjs_tgl_lahir").innerHTML = data.tglLahir;
	        			document.getElementById("bpjs_no_telepon").innerHTML = data.mr.noTelepon;	        			
	        			document.getElementById("bpjs_kdprovider").innerHTML = data.provUmum.kdProvider;
	        			document.getElementById("bpjs_nmprovider").innerHTML = data.provUmum.nmProvider;	        			
	        			document.getElementById("bpjs_jnspeserta").innerHTML = data.jenisPeserta.keterangan;	        		
	        			document.getElementById("bpjs_nmkelas").innerHTML = data.hakKelas.keterangan;	        			
	        			document.getElementById("bpjs_status_keterangan").innerHTML = data.statusPeserta.keterangan;  
	        			document.getElementById("bpjs_cob_nama").innerHTML = data.cob.nmAsuransi;
	        			document.getElementById("bpjs_cob_nomor").innerHTML = data.cob.noAsuransi;	        			
	        			document.getElementById("bpjs_cob_tat").innerHTML = data.cob.tglTAT;	        		
	        			document.getElementById("bpjs_cob_tmt").innerHTML = data.cob.tglTMT; 
	        			document.getElementById("bpjs_informasi_dinsos").innerHTML = data.informasi.dinsos;	        			
	        			document.getElementById("bpjs_informasi_sktm").innerHTML = data.informasi.noSKTM;	
	        			document.getElementById("bpjs_informasi_prb").innerHTML = data.informasi.prolanisPRB;	      	
	        		} else {
	        			swal("Gagal Cek Peserta BPJS",result.metaData.message, "error");
	        		}	              	
	        	} else {
	        		document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
	              	swal("Error","Gagal Cek Peserta BPJS.", "error");  
	        	}
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btn_cek_nik").innerHTML = 'Cek Peserta BPJS';
	            swal("Gagal Cek Peserta BPJS.",textStatus, "error");                   
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        }
	    });
    }
}

function jenisiden() {
	if(document.getElementById("KTP").checked == true && document.getElementById("SIM").checked == false && document.getElementById("PASPOR").checked == false && document.getElementById("LAINNYA").checked == false 
	 || document.getElementById("KTP").checked == false && document.getElementById("SIM").checked == true && document.getElementById("PASPOR").checked == false && document.getElementById("LAINNYA").checked == false  
	 || document.getElementById("KTP").checked == false && document.getElementById("SIM").checked == false && document.getElementById("PASPOR").checked == true && document.getElementById("LAINNYA").checked == false 
	 || document.getElementById("KTP").checked == false && document.getElementById("SIM").checked == false && document.getElementById("PASPOR").checked == false && document.getElementById("LAINNYA").checked == true    ){
			
	}else{
		alert("Pilih 1 Identitas");
	}

	if(document.getElementById("laki_laki").checked == true && document.getElementById("perempuan").checked == false 
	 || document.getElementById("laki_laki").checked == false && document.getElementById("perempuan").checked == true ){
			
	}else{
		alert("Pilih 1 Jenis Kelamin");
	}
}

	function validate(form){
			var signature =	signaturePad.toDataURL();
			$('#signatureValue').val(signature);
			// document.getElementById("btn-submit").disabled = true;
			document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
			return true;
		
	}



			
</script>
	
<?php echo $this->session->flashdata('success_msg'); ?>

<br>
<div class="card card-outline-info">
	<div class="card-header">
        <h4 class="m-b-0 text-white text-center">Pendaftaran Pasien Bayi</h4>
    </div>
    <div class="card-block p-b-15">
    <form method="POST" onsubmit="return validate(this)" action="<?php echo base_url('iri/ricbayi/insert_data_pasien')?>" enctype="multipart/form-data">
						<br>
						
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label">Nama Lengkap *</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" name="nama" id="nama" onkeyup="this.value = this.value.toUpperCase()" required autocomplete="off"> 
                                </div>
                            </div>
                                                
                            <div class="form-group row">
                                <label class="col-sm-3 control-label col-form-label" id="sex">Jenis Kelamin *</label>
                                <div class="col-sm-6">							
                                        <div class="demo-radio-button">
                                            <input name="sex" type="radio" id="laki_laki" class="with-gap" value="L"/>
                                            <label for="laki_laki">Laki-Laki</label>
                                            <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" />
                                            <label for="perempuan">Perempuan</label>           		
                                        </div>								
                                </div>
                            </div>
							
        <!-- <div class="form-group row">
            <label class="col-sm-3 control-label col-form-label">Pilih Identitas *</label>
            <div class="col-sm-5">
                <div class="form-inline">
                        <input name="jenis_identitas" type="radio"  id="KTP"  class="with-gap" value="KTP" />
                        <label for="KTP" >KTP</label>
                        <input name="jenis_identitas" type="radio" id="SIM" class="with-gap" value="SIM"  />
                        <label for="SIM" style="margin-left:30px">SIM</label>
                        <input name="jenis_identitas" type="radio" id="PASPOR" class="with-gap" value="PASPOR" />
                        <label for="PASPOR" style="margin-left:30px">PASPOR</label>
                        <input name="jenis_identitas" type="radio" id="LAINNYA" class="with-gap" value="LAINNYA" />
                        <label for="LAINNYA" style="margin-left:30px">LAINNYA</label>
                </div>
            </div>
        </div> -->

							<!-- <div class="form-group row" id="div-no-identitas">
								<label class="col-sm-3 control-label col-form-label" ><span id="label-identitas">No. Identitas</span></label>
								<div class="col-sm-5">																		
                                    <input type="text" class="form-control input-block" name="no_identitas" id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)" autocomplete="off">
								</div>
								<div class="col-sm-3">
									<button class="btn btn-info btn-block" type="button" onclick="cekbpjs_nik()" id="btn_cek_nik">Cek Peserta BPJS</button>
								</div>
							</div>
							<div class="form-group row" id="duplikat_id">
								<label class="col-sm-3 control-label col-form-label"></label>
								<div class="col-sm-8">
									<label class="control-label col-form-label" id="content_duplikat_id" style="color: red;"></label>
								</div>
							</div>
							<div class="form-group row" >
								<label class="col-sm-3 control-label col-form-label" id="no_kartu_bpjs">No. Kartu BPJS</label>
								<div class="col-sm-8">
									<div class="input-group"style="z-index:1;">
                                        <input type="text" class="form-control" name="no_kartu" id="no_bpjs" autocomplete="off">
                                        <span class="input-group-btn">
                          					<button class="btn btn-info" type="button" onclick="cek_nobpjs()" id="btn_cek_kartu">Cek Kartu BPJS</button>
                        				</span>
                                    </div>	
								</div>
							</div>
							<div class="form-group row" id="duplikat_kartu">
								<label class="col-sm-3 control-label col-form-label"></label>
								<div class="col-sm-8">
									<label class="control-label col-form-label" id="content_duplikat_kartu" style="color: red;"></label>
								</div>
							</div>							 -->
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" for="tmpt_lahir">Tempat Lahir *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" onkeyup="this.value = this.value.toUpperCase()" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Tanggal Lahir *</label>
								<div class="col-sm-8">
									<input type="date" class="form-control date_picker" data-date-format="dd/mm/yyyy" id="tgl_lahir" maxDate="0" placeholder="dd-mm-yyyy" name="tgl_lahir" required>
								</div>
							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="agama">Agama</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<input name="agama" type="radio"  id="nonea"  class="with-gap" value="" checked />
										<label for="nonea"style="display:none;">NONE</label>
										<input name="agama" type="radio"  id="ISLAM"  class="with-gap" value="ISLAM" />
										<label for="ISLAM">Islam</label>
										<input name="agama" type="radio"  id="KATHOLIK"  class="with-gap" value="KATHOLIK" />
										<label for="KATHOLIK" style="margin-left:10px;" >Katholik</label>
										<input name="agama" type="radio"  id="KRISTEN"  class="with-gap" value="KRISTEN" />
										<label for="KRISTEN" style="margin-left:10px;">Kristen</label>
										<input name="agama" type="radio"  id="BUDHA"  class="with-gap" value="BUDHA" />
										<label for="BUDHA" style="margin-left:10px;">Budha</label>
										<input name="agama" type="radio"  id="HINDU"  class="with-gap" value="HINDU" />
										<label for="HINDU" style="margin-left:10px;">Hindu</label>
										
										
									</div>
								</div>
							</div> -->
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="status">Status Perkawinan</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<input name="status" type="radio" id="nonesp" class="with-gap" value="" checked/>
				                            <label for="nonesp"style="display:none;">NONE</label>
											<input name="status" type="radio" id="belum_kawin" class="with-gap" value="B" />
				                            <label for="belum_kawin">Belum Kawin</label>
				                            <input name="status" type="radio" id="sudah_kawin" class="with-gap" value="K" />
				                            <label for="sudah_kawin" style="margin-left:10px;">Sudah Kawin</label> 
				                            <input name="status" type="radio" id="cerai" class="with-gap" value="C" />
				                            <label for="cerai" style="margin-left:10px;">Cerai</label>           		
									</div>	
								</div>
							</div> -->
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="goldarah">Golongan Darah</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<input name="goldarah" type="radio"  id="nonegd"  class="with-gap" value="" checked/>
										<label for="nonegd"style="display:none;">NONE</label>
										<input name="goldarah" type="radio"  id="A+"  class="with-gap" value="A+" />
										<label for="A+">A+</label>
										<input name="goldarah" type="radio"  id="A-"  class="with-gap" value="A-" />
										<label for="A-" style="margin-left:15px;">A-</label>
										<input name="goldarah" type="radio"  id="B+"  class="with-gap" value="B+" />
										<label for="B+" style="margin-left:15px;">B+</label>
										<input name="goldarah" type="radio"  id="B-"  class="with-gap" value="B-" />
										<label for="B-" style="margin-left:15px;">B-</label>
										<input name="goldarah" type="radio"  id="AB+"  class="with-gap" value="AB+" />
										<label for="AB+" style="margin-left:15px;">AB+</label>
										<input name="goldarah" type="radio"  id="AB-"  class="with-gap" value="AB-" />
										<label for="AB-" style="margin-left:15px;">AB-</label>
										<input name="goldarah" type="radio"  id="O+"  class="with-gap" value="O+" />
										<label for="O+" style="margin-left:15px;">O+</label>
										<input name="goldarah" type="radio"  id="O-"  class="with-gap" value="O-" />
										<label for="O-" style="margin-left:15px;">O-</label>
									</div>
								</div>
							</div>
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="wnegara">Kewarganegaraan</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<input name="wnegara" type="radio"  id="WNI"  class="with-gap" value="WNI" checked />
										<label for="WNI">WNI</label>
										<input name="wnegara" type="radio"  id="WNA"  class="with-gap" value="WNA" />
										<label for="WNA"  style="margin-left:20px;">WNA</label>
									</div>
								</div>
							</div> -->
							
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="wnegara">Bahasa Sehari Hari</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<input name="bahasa" type="radio"  id="noneb"  class="with-gap" value="" checked/>
										<label for="noneb"style="display:none;">NONE</label>
										<input name="bahasa" onClick="validateBahasa()" type="radio"  id="WNI-bahasa"  class="with-gap" value="INDONESIA"/>
										<label for="WNI-bahasa">INDONESIA</label>
										<input name="bahasa" onClick="validateBahasa()" type="radio"  id="WNA-bahasa"  class="with-gap" value="Daerah" />
										<label for="WNA-bahasa"  style="margin-left:20px;">Daerah</label>
										<input name="bahasa" onClick="validateBahasa()" type="radio"  id="lainnya"  class="with-gap" />
										<label for="lainnya"  style="margin-left:20px;margin-right:20px;">Lainnya</label>
										<input type="text" name="bahasa2" id="bahasalainnya" >
									</div>
								</div>
							</div> -->


                            <!-- <div class="form-group row">
                                <label class="col-sm-3  control-label col-form-label" id="sukubangsa" style="margin-bottom:0px;margin-top:0px;!important">Sukubangsa</label>
                                <div class="col-sm-8">
                                    <div class="form-inline">
                                            <select id="suku_bangsa" class="form-control select2" style="width: 100%" name="suku_bangsa" onkeyup="this.value = this.value.toUpperCase()">
                                                <option value="">-- Pilih Sukubangsa --</option>
                                                <?php 
                                                foreach($master_sukubangsa as $row){
                                                    echo '<option value="'.strtoupper($row->nm_sukubangsa).'">'.strtoupper($row->nm_sukubangsa).'</option>';
                                                }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                            </div> -->

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="alamat">Alamat</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="alamat" id="alamats" rows="4" onkeyup="this.value = this.value.toUpperCase()"></textarea>
								</div>
							</div> -->

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="alamat"></label>
								<div class="form-group row col-sm-8">
									<div class="col-sm-2">
										<input class="form-control" name="rt" id="rt" type="number" placeholder="RT" min="1">
										
									</div>
									<div class="col-sm-1">
										<input type="hidden" class="form-control" value="/" disabled>
									</div>
									<div class="col-sm-2">
										<input class="form-control" name="rw" id="rw" type="number" placeholder="RW" min="1">
										
									</div>
										
									
								</div>
								
							</div> -->
							<!-- ADDED ALAMAT YANG BISA DIHUBUNGI  -->
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="alamat">Alamat Yang Bisa Dihubungi</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="alamat2" id="alamat2"  rows="4" onkeyup="this.value = this.value.toUpperCase()"></textarea>
								</div>
							</div> -->

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="alamat"></label>
								<div class="form-group row col-sm-8">
									<div class="col-sm-2">
										<input class="form-control" name="rt_alamat2" id="rt2" type="number" placeholder="RT" min="1">
										
									</div>
									<div class="col-sm-1">
										<input type="hidden" class="form-control" value="/" disabled>
									</div>
									<div class="col-sm-2">
										<input class="form-control" name="rw_alamat2" id="rw2" type="number" placeholder="RW" min="1">
										
									</div>

									<div class="col-sm-2">
										<button type="button" class="btn btn-primary" id="btn_alamat" onClick="validateAlamat()">Alamat Sama</button>
									</div>
										
									
								</div>
								
							</div> -->
							<!-- END OF ADDED -->
							
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah *</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select name="load_wilayah" class="form-control load_wilayah" style="width:500px" onkeyup="this.value = this.value.toUpperCase()" required></select>
										
									</div>
								</div>
							</div>	 -->
                            
                            
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kodepos">Kode Pos</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" id="kodeposnya" name="kodepos">
								</div>
							</div> -->

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pendidikan">Pendidikan</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<input name="pendidikan" type="radio"  id="nonep"  class="with-gap" value="" checked/>
											<label for="nonep" style="display:none;">NONE</label>
											<input name="pendidikan" type="radio"  id="S1/DIV"  class="with-gap" value="S1/DIV" />
											<label for="S1/DIV" >S1/DIV</label>
											<input name="pendidikan" type="radio"  id="DIII"  class="with-gap" value="DIII" />
											<label for="DIII" style="margin-left:15px;">DIII</label>
											<input name="pendidikan" type="radio"  id="SMA"  class="with-gap" value="SMA" />
											<label for="SMA" style="margin-left:15px;">SMA</label>
											<input name="pendidikan" type="radio"  id="SLTP"  class="with-gap" value="SLTP" />
											<label for="SLTP" style="margin-left:15px;">SLTP</label>
											<input name="pendidikan" type="radio"  id="SD"  class="with-gap" value="SD" />
											<label for="SD" style="margin-left:15px;">SD</label>
											<input name="pendidikan" type="radio"  id="Belum/Tdk Sekolah"  class="with-gap" value="Belum/Tdk Sekolah" />
											<label for="Belum/Tdk Sekolah" style="margin-left:15px;">Belum/Tdk Sekolah</label>
											
									</div>
								</div>
							</div> -->

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pekerjaan">Pekerjaan</label>
								<div class="col-sm-8">
									
											<input name="pekerjaan" type="radio"  id="nonepe"  class="with-gap"  onClick="validatePekerjaan()" value="" checked/>
											<label for="nonepe" style="display:none;">NONE</label>
										<?php foreach($pekerjaan as $row){
												echo '<input name="pekerjaan" onClick="validatePekerjaan()" type="radio"  id="'.$row->pekerjaan.'"  class="with-gap" value="'.$row->pekerjaan.'" />
												<label for="'.$row->pekerjaan.'" style="margin-left:15px;">'.$row->pekerjaan.'</label>';
												// echo '<option value="'.$row->pekerjaan.'">'.$row->pekerjaan.'</option>';
											}
										?>
										<input type="text" name="pekerjaan2" id="pekerjaan_lainnya">	
								</div>
							</div> -->

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_telp_kantor">No. Telp Kantor</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" maxlength="13" name="no_telp_kantor" autocomplete="off">
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_telp">No. Telp</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" maxlength="13" name="no_telp" autocomplete="off">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_hp" maxlength="13" minlength="10">No. HP</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="no_hp" autocomplete="off">
								</div>
							</div> -->

							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" for="nama_ayah">Nama Ayah</label>
								<div class="col-sm-4">
									<input type="text" id="nama_ayah" class="form-control" name="nama_ayah" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" for="nama_ibu">Nama Ibu</label>
								<div class="col-sm-4">
									<input type="text" id="nama_ibu" class="form-control" name="nama_ibu" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off">
								</div>
							</div>

							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="label_nama_suami_istri" for="nama_suami_istri">Nama Suami / Istri</label>
								<div class="col-sm-4">
									<input type="text" id="nama_suami_istri" class="form-control" name="nama_suami_istri" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label"  for="signature">TTD Pasien</label>
								<div class="col-sm-4">
								
								<canvas class="canvas"></canvas>
								</div>
							</div> -->



							


							
			<hr>
			<div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                         <div class="row">
                             <div class="col-md-12 text-center">
                                <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
                                <input type="hidden" class="form-control" value="<?php echo $no_mr_ibu;?>"  name="no_mr_ibu">
								<input type="hidden" class="form-control" value="<?php echo $noreg_ibu;?>"  name="noreg_ibu">
								<!-- <input type="hidden" class="form-control" value="<?php //echo $user_info->username;?>"  name="user_name">
								<input type="hidden" class="form-control" value="<?php //echo $user_info->userid;?>"  name="userid"> -->
								<button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit">Simpan</button>
                             </div>
                         </div>
                     </div>
                </div>
            </div>
		<!-- 	</div>  -->
		<!-- end tab content -->
		<!-- <?php echo form_close();?> -->
	</form>

	</div><!-- Card Box -->
</div><!-- Card -->		
	<!-- sample modal content -->
     
	
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 