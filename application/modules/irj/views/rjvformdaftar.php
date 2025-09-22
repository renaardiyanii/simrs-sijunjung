<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>
<style type="text/css">
.demo-radio-button label{min-width:120px;}
</style>
<script type='text/javascript'>
	var site = "<?php echo site_url();?>";
	$(function() {
		var jenis_identitas = $('#jenis_identitas').val();
		set_ident(jenis_identitas);	
		$(".select2").select2();
		$("#duplikat_id").hide();
		$("#duplikat_id_bpjs").hide();
		$("#duplikat_kartu").hide();

		$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});  

		$('.auto_search_by_nonrp').autocomplete({
			serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nonrp',
			onSelect: function (suggestion) {
				$('#no_nrp').val(''+suggestion.no_nrp);
				$('#hidden_no_nrp').val(''+suggestion.no_nrp);
			}
		});

		$('.load_wilayah').select2({
            placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
            ajax: {
                url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah'); ?>',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    var results = [];

                    $.each(data, function(index, item) {
                        results.push({
                            id: item.id_provinsi + '@' + item.id_kota + '@' + item
                                .id_kecamatan + '@' + item.id_kelurahan,
                            text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' +
                                item.nm_kota + ', ' + item.nm_provinsi
                        });
                    });
                    return {
                        results: results
                    };
                },
                cache: true
            }
        });
	});	

	var ajaxku;
	function ajaxkel(id){
		var res=id.split("-");//it Works :D
	    ajaxku = buatajax();
	    var url="<?php echo site_url('irj/rjcregistrasi/data_kelurahan2'); ?>";
	    url=url+"/"+res[0];
	    url=url+"/"+Math.random();
	    ajaxku.onreadystatechange=stateChangedKel;
	    ajaxku.open("GET",url,true);
	    ajaxku.send(null);
		// document.getElementById("id_kecamatan").value = res[0];
		// document.getElementById("kecamatan").value = res[1];
	}
	function setkel(id){
		var res=id.split("-");//it Works :D
		document.getElementById("id_kelurahandesa").value = res[0];
		document.getElementById("kelurahandesa").value = res[1];
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
	function stateChangedKel(){
	    var data;
	    if (ajaxku.readyState==4){
	    data=ajaxku.responseText;
	    if(data.length>=0){
	    document.getElementById("name_wilayah").innerHTML = data
	    }else{
	    document.getElementById("name_wilayah").value = "<option selected value=\"\">Pilih Kelurahan/Desa</option>";
	    }
	    }
	}

	function cek_no_identitas(no_identitas){
		console.log(no_identitas)
		if(no_identitas!=''){
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/",
			success: function(data){
				if (data) {
					console.log(data)
					document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
					$("#duplikat_id").show();
					document.getElementById("btn-submit").disabled= true;				
				} else {
					$("#duplikat_id").hide();
					document.getElementById("btn-submit").disabled= false;
				}
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}
	    });}
	}

	function cek_no_kartu_bpjs(no_kartu){
		console.log(no_kartu)
		if(no_identitas!=''){
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu_bpjs')?>/"+no_kartu+"/",
			success: function(data){
				if (data) {
					console.log(data)
					document.getElementById("content_duplikat_id_bpjs").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! <br>Silahkan masukkan no kartu lain...";
					$("#duplikat_id_bpjs").show();
					document.getElementById("btn-submit").disabled= true;				
				} else {
					$("#duplikat_id_bpjs").hide();
					document.getElementById("btn-submit").disabled= false;
				}
			},
			error: function (request, status, error) {
				alert(request.responseText);
			}
	    });}
	}

	function set_ident(ident) {
			$("#no_identitas").val("");
		if (ident == "") {
			document.getElementById("no_identitas").required = false;		
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
		cek_alamat_nik(no_nik);
		if (gender == 'L') {
			$('#laki_laki').prop('checked', true);
		}
		if (gender == 'P') {
			$('#perempuan').prop('checked', true);
		}
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
		        url: "<?php echo site_url('bpjs/peserta/cari_peserta?pencarian=nokartu&nomor='); ?>"+no_bpjs,
		        success: function(result){ 
		        	console.log(result);
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
	function cek_alamat_nik(nik){
		if(nik!=''){
	   		// alert(nik);
			$.ajax({
				type:'POST',
				dataType: 'json',
				url:"<?php echo base_url('irj/rjcregistrasi/cek_alamat_nik')?>/"+nik,
				success: function(data){
					//alert(data);
			        var newOption = new Option(data.kecamatan+', '+data.daerah+', '+data.propinsi, no_nik.substr(0, 6), false, false);
					$('#load_wilayah').append(newOption).trigger('change');
					ajaxkel(nik.substr(0, 6));
				},
				error: function (request, status, error) {
					// alert(request.responseText);
				}
	   	 	});
	 	}
	}

	function validate(form){
		// if(form.no_identitas.value==""){
		// 	return false;
		// }
		document.getElementById("btn-submit").disabled = true;
		document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
		return true;
	}

	var myVar, myVar2;
	function get_ektp(){
		myVar = setInterval(myTimer, 2000);
        $('#ambilData').modal('show');
	}

    // var myVar = setInterval(myTimer, 2000);
    // var reader = ;
    function myTimer() {
        $.ajax({
            type: 'GET',
            url: '<?php echo site_url(); ?>irj/rjcregistrasi/cek_temp/loket3',
            dataType: "json",
            success: function (response) {
                // //alert(JSON.stringify(response));
                // if(response.success){                       
                //     // objTable.ajax.reload();
                //     // $('#editModal').modal('hide');
                //     swal("Sukses","Update Pegawai Berhasil. "+response.status, "success");
                //     window.location.href='<?php echo site_url();?>pegawai/data';
                // } else {
                //     swal("Error",response.status, "error");     
                // }
                if(response == null){
                    // swal("NULL","DATA NULL. ", "error");
                } else {
                    $('#id_kelurahandesa').val(response.id_keldesa);
                    $('#kelurahandesa').val(response.keldesa);
                    $('#nama').val(response.nama);
                    if(response.jk=='LAKI-LAKI'){
                    	$('#laki_laki').click();
                    }else{
                    	$('#perempuan').click();
                    }
                    $('#jenis_identitas').val('KTP');
                    set_ident('KTP')
                    $('#no_identitas').val(response.nik);
                    $('#tmpt_lahir').val(response.tempat_lahir);
                    var tgl_lahir = response.tgl_lahir;
                    var h=tgl_lahir.substr(0, 2)
                    var b=tgl_lahir.substr(3, 2)
                    var t=tgl_lahir.substr(6, 4)
                    $('#tgl_lahir').val(t+'-'+b+'-'+h);
                    $('#agama').val(response.agama);
                    if(response.status=='BELUM KAWIN'){
                    	$('#belum_kawin').click();
                    }else if(response.status=='BELUM KAWIN'){
                    	$('#sudah_kawin').click();
                    }
                    $('#alamat').val(response.alamat+' RT/RW '+response.rtrw);
                    var newOption = new Option(response.kecamatan+', '+response.daerah+', '+response.propinsi, response.nik.substr(0, 6), false, false);
					$('#load_wilayah').append(newOption).trigger('change');
					ajaxkel(response.nik.substr(0, 6));
                    if(response.kewarganegaraan=='WNI'){
                    	$('#WNI').click();
                    }else{
                    	$('#WNA').click();
                    }
                    $('#foto_blob').val(response.foto);
                    $("#foto_blob_view").attr("src","data:image/png;base64,"+response.foto);
                    $('#ttd_blob').val(response.ttd);
                    $("#ttd_blob_view").attr("src","data:image/png;base64,"+response.ttd);
                    $('#fingerprint_blob').val(response.fingerprint);
                    $("#fingerprint_blob_view").attr("src","data:image/png;base64,"+response.fingerprint);

                    myStopFunction();
                    swal({
                        title: "Sukses",
                        text: "Berhasil Memuat Data EKTP",
                        timer: 1000,
                        showConfirmButton: false,
                        showCancelButton: true
                    });
                    $('#ambilData').modal('hide');
                	cek_no_identitas(response.nik);
					myVar2 = setInterval(ubahKelurahan, 4000);
					//cek bpjs
					var no_nik = response.nik;
					$.ajax({
					    type: "POST",
					    url: "<?php echo site_url('bpjs/peserta/nik'); ?>",
					    dataType: "JSON",
					    data: {"no_nik" : no_nik},
					    success: function(result){ 
					    	if (result) {
					    		if (result.metaData.code == '200') {
					    			data = result.response.peserta;	        				   
                    				$('#no_bpjs').val(data.noKartu);
					    		} else {
					    			swal("Gagal Cek Peserta BPJS",result.metaData.message, "error");
					    		}	              	
					    	} else {
					          	swal("Error","Gagal Cek Peserta BPJS.", "error");  
					    	}
					    },
					    error:function(event, textStatus, errorThrown) { 
					        swal("Gagal Cek Peserta BPJS.",textStatus, "error");                   
					        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
					    }
					});
                }
            },
            error: function(){
                // echo 'error';
            }
        });
    }

    function myStopFunction() {
        clearInterval(myVar);
    }

    function ubahKelurahan() {
		var id_keldesa = $('#id_kelurahandesa').val();
		var keldesa = $('#kelurahandesa').val();
		// alert(id_keldesa+'-'+keldesa);
		$('#name_wilayah').val(id_keldesa+'-'+keldesa); // Select the option with a value of '1'
		$('#name_wilayah').trigger('change'); // Notify any JS components that the value changed
        clearInterval(myVar2);
    }

    function inputNumbersOnly(evt){
	    var charCode = (evt.which) ? evt.which : evt.keyCode
	    if (charCode > 31 && (charCode < 48 || charCode > 57))
	        return false;
	    return true;
	}

	function validateBahasa() {
        if (document.getElementById("lainnya").checked == true) {
            document.getElementById("bahasalainnya").disabled = false;
        } else {
            document.getElementById("bahasalainnya").value = '';
            document.getElementById("bahasalainnya").disabled = true;
        }
    }

    if (document.getElementById("lainnya").checked == true) {
        document.getElementById("bahasalainnya").disabled = false;
    } else {
        document.getElementById("bahasalainnya").value = '';
        document.getElementById("bahasalainnya").disabled = true;
    }

</script>


<div class="modal fade" id="ambilData" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">
        <div class="modal-content">
            <form action="#" id="formPemeriksaan" class="formPemeriksaan">
                <!-- <div class="modal-header">
                    <h4 class="modal-title">Tempel KTP Anda</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="card b-all shadow-none">
                                <div class="card-block">
                                    <img src="<?=site_url();?>assets/images/loading.gif" alt="">
                                    <h4 class="modal-title text-center">Tempelkan KTP Anda pada Reader</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                    <button type="button" id="submit" onclick="save_banyak_data()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div> -->
            </form>
        </div>
    </div>
</div>
	
<?php echo $this->session->flashdata('success_msg'); ?>

<br>
<div class="card card-outline-info">
	<div class="card-header">
        <h4 class="m-b-0 text-white text-center">PENDAFTARAN PASIEN BARU</h4>
    </div>
    <div class="card-block p-b-15">
    <!-- <?php echo form_open_multipart('irj/rjcregistrasi/insert_data_pasien');?>	 -->
    				<form method="POST" onsubmit="return validate(this)" action="<?php echo base_url('irj/rjcregistrasi/insert_data_pasien')?>">

						<!-- <button type="button" class="btn waves-effect waves-light btn-primary" id="btn-ektp" onclick="get_ektp()">Ambil Dari KTP Reader</button>
						<br>
						<br> -->
                        <h5>IDENTITAS PASIEN</h5><hr><br>
						<div class="col-lg-10" style="margin: 0 auto;">	
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. RM Baru</label>
								<div class="col-sm-8">
									<span class="badge badge-danger font-20"><?php //echo str_pad($last_mr, 6, "0", STR_PAD_LEFT);?></span>	
								</div>
							</div> -->
							<!-- <input type="hidden" class="form-control" name="mr_lama" id="mr_lama">
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. RM Lama</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="mr_lama" id="mr_lama">	
								</div>
							</div> -->
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Nama Lengkap *</label>
								<div class="col-sm-6">
									<input type="text" class="form-control" name="nama" id="nama" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="sex">Jenis Kelamin *</label>
								<div class="col-sm-6">							
										<div class="demo-radio-button">
											<input name="sex" type="radio" id="laki_laki" class="with-gap" value="L" />
				                            <label for="laki_laki">Laki-Laki</label>
				                            <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" />
				                            <label for="perempuan">Perempuan</label>           		
										</div>								
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Pilih Identitas</label>
								<div class="col-sm-4">
									<div class="form-inline">
											<select  class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)" >
												<option value="">-- Pilih Identitas --</option>
												<option value="KTP">KTP</option>
												<option value="SIM">SIM</option>
												<option value="PASPOR">Paspor</option>
												<option value="KTM">KTM</option>
												<option value="DLL">Lainnya</option>
											</select>
									</div>
								</div>
							</div>
							<div class="form-group row" id="div-no-identitas">
								<label class="col-sm-3 control-label col-form-label" ><span id="label-identitas">No. Identitas</span></label>
								<div class="col-sm-5">																		
                                    <input type="text" class="form-control input-block" name="no_identitas" id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)" onkeypress="return inputNumbersOnly(event)" maxlength="16">
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
							<!-- <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_kartu">No. Kartu Keluarga</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="no_kk" id="no_kk">
								</div>
							</div> -->
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">No. Kartu BPJS</label>
								<div class="col-sm-8">
									<div class="input-group">
                                        <input type="text" class="form-control" name="no_kartu" id="no_bpjs" onchange="cek_no_kartu_bpjs(this.value)" onkeyup="cek_no_kartu_bpjs(this.value)" onkeypress="return inputNumbersOnly(event)" maxlength="16">
                                        <span class="input-group-btn">
                          					<button class="btn btn-info" type="button" onclick="cek_nobpjs()" id="btn_cek_kartu">Cek Kartu BPJS</button>
                        				</span>
                                    </div>	
								</div>
							</div>	

							<div class="form-group row" id="duplikat_id_bpjs">
								<label class="col-sm-3 control-label col-form-label"></label>
								<div class="col-sm-8">
									<label class="control-label col-form-label" id="content_duplikat_id_bpjs" style="color: red;"></label>
								</div>
							</div>


							<div class="form-group row" id="duplikat_kartu">
								<label class="col-sm-3 control-label col-form-label"></label>
								<div class="col-sm-8">
									<label class="control-label col-form-label" id="content_duplikat_kartu" style="color: red;"></label>
								</div>
							</div>							
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="val_tmpt_lahir">Tempat Lahir *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control" name="tmpt_lahir" id="tmpt_lahir" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label">Tanggal Lahir *</label>
								<div class="col-sm-8">
									<input type="text" class="form-control date_picker" id="tgl_lahir" maxDate="0" name="tgl_lahir" required>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="view_agama">Agama</label>
								<div class="col-sm-8">
									<div class="form-inline">
											<select class="form-control" style="width: 100%" name="agama" id="agama">
												<option value="">-- Pilih Agama --</option>
												<option value="ISLAM">Islam</option>
												<option value="KATOLIK">Katolik</option>
												<option value="PROTESTAN">Protestan</option>
												<option value="BUDHA">Budha</option>
												<option value="HINDU">Hindu</option>
												<option value="KONGHUCU">Konghucu</option>
											</select>
										
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="status">Status Perkawinan</label>
								<div class="col-sm-8">
									<div class="demo-radio-button">
											<input name="status" type="radio" id="belum_kawin" class="with-gap" value="B" />
				                            <label for="belum_kawin">Belum Kawin</label>
				                            <input name="status" type="radio" id="sudah_kawin" class="with-gap" value="K" />
				                            <label for="sudah_kawin">Sudah Kawin</label> 
				                            <input name="status" type="radio" id="jd" class="with-gap" value="JD" />
				                            <label for="jd">Janda/Duda</label>  
											<input name="status" type="radio" id="ch" class="with-gap" value="CH" />
				                            <label for="ch">Cerai Hidup</label>         		
											<input name="status" type="radio" id="cm" class="with-gap" value="CM" />
				                            <label for="cm">Cerai Mati</label>         		 
									</div>	
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="goldarah">Golongan Darah</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="goldarah">
											<option value="">-- Pilih Golongan Darah --</option>
											<option value="A+">A+</option>
											<option value="A-">A-</option>
											<option value="B+">B+</option>
											<option value="B-">B-</option>
											<option value="AB+">AB+</option>
											<option value="AB-">AB-</option>
											<option value="O+">O+</option>
											<option value="O-">O-</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="wnegara">Kewarganegaraan</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="wnegara">
											<option value="WNI">WNI</option>
											<option value="WNA">WNA</option>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="etnis">Etnis</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<select class="form-control" style="width: 100%" name="etnis">
											<option value="">-- Pilih Etnis --</option>
											<?php foreach($master_sukubangsa as $row){
													echo "<option value='".$row->nm_sukubangsa."'>".$row->nm_sukubangsa."</option>";
												}
											?>
										</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="view_alamat">Alamat</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="alamat" id="alamat" rows="5"></textarea>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="view_rtrw"></label>
								<div class="col-sm-8">
									<div class="row">
										<div class="col-sm-4">
											<div class="input-group">
												<span class="input-group-addon">
													RT
												</span>
												<input type="text" class="form-control" name="rt" id="rt" onkeypress="return inputNumbersOnly(event)" maxlength="3">
											</div>
										</div>
										<div class="col-sm-4">
											<div class="input-group">
												<span class="input-group-addon">
													RW
												</span>
												<input type="text" class="form-control" name="rw" id="rw" onkeypress="return inputNumbersOnly(event)" maxlength="3">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah</label>
								<div class="col-sm-8">
									<div class="form-inline">
										<select id="load_wilayah" name="load_wilayah" class="form-control load_wilayah" style="width:500px" onchange="ajaxkel(this.value)"></select>
									</div>
								</div>
							</div>		
														
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="kodepos">Kode Pos</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="kodepos" onkeypress="return inputNumbersOnly(event)" maxlength="5">
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pendidikan">Pendidikan</label>
								<div class="col-sm-5">
									<div class="form-inline">
											<select class="form-control select2" style="width: 100%" name="pendidikan">
												<option value="">-- Pilih Pendidikan Terakhir --</option>
												<option value="S3">S3</option>
												<option value="S2">S2</option>
												<option value="S1">S1</option>
												<option value="D4">D4</option>
												<option value="D3">D3</option>
												<option value="D2">D2</option>
												<option value="D1">D1</option>
												<option value="SMA">SMA</option>
												<option value="SMP">SMP</option>
												<option value="SD">SD</option>
												<option value="Di Bawah Umur">Di Bawah Umur</option>
											</select>
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="pekerjaan">Pekerjaan</label>
								<div class="col-sm-5">
									<select class="form-control select2" style="width: 100%" name="pekerjaan">
										<option value="">-- Pilih Pekerjaan --</option>
										<?php foreach($pekerjaan as $row){
												echo '<option value="'.$row->pekerjaan.'">'.$row->pekerjaan.'</option>';
											}
										?>										
									</select>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="wnegara">Bahasa Sehari Hari</label>
								<div class="col-sm-5">
									<div class="form-inline">
										<input name="bahasa" type="radio" id="noneb" class="with-gap" value="" checked />
										<label for="noneb" style="display:none;">NONE</label>
										<input name="bahasa" onClick="validateBahasa()" type="radio" id="WNI-bahasa" class="with-gap" value="INDONESIA" />
										<label for="WNI-bahasa">INDONESIA</label>
										<input name="bahasa" onClick="validateBahasa()" type="radio" id="WNA-bahasa" class="with-gap" value="DAERAH" />
										<label for="WNA-bahasa" style="margin-left:20px;">DAERAH</label>
										<!-- <input name="bahasa" onClick="validateBahasa()" type="radio" id="lainnya" class="with-gap" />
										<label for="lainnya" style="margin-left:5px;margin-right:20px;">Lainnya</label>
										<input type="text" name="bahasa2" id="bahasalainnya"> -->
									</div>
								</div>
							</div>
							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_hp_lbl" maxlength="13" minlength="10">No. HP</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="no_hp" onkeypress="return inputNumbersOnly(event)" maxlength="13">
								</div>
							</div>

							<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="nm_ibu" maxlength="13" minlength="10">Nama Ibu Kandung</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="nm_ibu_kndg">
								</div>
							</div>
																
						</div>

                        <h5>DATA PENANGGUNG JAWAB PASIEN</h5><hr><br>
                        <div class="col-lg-10" style="margin: 0 auto;">
                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="nm_penanggung_jawab" maxlength="13" minlength="10">Nama *</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="nm_penanggung_jawab">
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="umur" maxlength="13" minlength="10">Umur *</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="umur_penanggung_jawab">
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="sex_penanggung_jawab">Jenis Kelamin *</label>
								<div class="col-sm-6">							
										<div class="demo-radio-button">
											<input name="sex_penanggung_jawab" type="radio" id="laki_laki_tg_jawab" class="with-gap" value="L" />
				                            <label for="laki_laki_tg_jawab">Laki-Laki</label>
				                            <input name="sex_penanggung_jawab" type="radio" id="perempuan_tg_jawab" class="with-gap" value="P" />
				                            <label for="perempuan_tg_jawab">Perempuan</label>           		
										</div>								
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="view_alamat_tg_jawab">Alamat</label>
								<div class="col-sm-8">
									<textarea class="form-control" name="alamat_tg_jawab" id="alamat_tg_jawab" rows="5"></textarea>
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="no_hp_tg_jawab" maxlength="13" minlength="10">No. Telp/HP</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="no_hp_tg_jawab" onkeypress="return inputNumbersOnly(event)" maxlength="13">
								</div>
							</div>

                            <div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="hub_tg_jawab" maxlength="13" minlength="10">Hubungan</label>
								<div class="col-sm-4">
									<input type="text" class="form-control" name="hub_tg_jawab"  maxlength="13">
								</div>
							</div>


                        </div>
				
			<hr>
			<div class="form-actions">
                <div class="row">
                    <div class="col-md-12">
                         <div class="row">
                             <div class="col-md-12 text-center">
                                <button type="reset" class="btn waves-effect waves-light btn-danger">Reset</button>
								<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
                                <input type="hidden" class="form-control" value="<?php echo $user_info->userid;?>"  name="user_id">
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
      	<div class="modal fade modal_nobpjs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
          	<div class="modal-dialog modal-lg">
              	<div class="modal-content">
                  	<div class="modal-header text-center">
                      	<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>                    	
                      	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  	</div>
                  	<div class="modal-body">
                  		<h4 class="text-center text-bold">DATA PESERTA BPJS</h4>
	                    <div class="table-responsive m-t-30" style="clear: both;">
						<table class="table-xs table-hover" width="100%">
					  <tbody>
					  	<tr>
							<td style="width: 25%;">No. Kartu BPJS</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_noka"></td>
						</tr>
						<tr>
							<td style="width: 25%;">NIK</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nik"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">Nama</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nama"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">Jenis Kelamin</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_gender"></td>
						</tr>
						<tr>
							<td style="width: 25%;">Tanggal Lahir</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_tgl_lahir"></td>
						</tr>
						<tr>
							<td style="width: 25%;">No. Telepon</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_no_telepon"></td>
						</tr>													
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Provider Umum</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  					  
						<tr>
							<td style="width: 25%;">Kode Provider</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_kdprovider"></td>
						</tr>		
						<tr>
							<td style="width: 25%;">Nama Provider</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nmprovider"></td>
						</tr>					
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Jenis Peserta</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  						
						<tr>
							<td style="width: 25%;">Jenis Peserta</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_jnspeserta"></td>
						</tr>	
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Hak Kelas</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  						
						<tr>
							<td style="width: 25%;">Nama Kelas</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_nmkelas"></td>
						</tr>						
					  </tbody>
					</table>
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Status Peserta</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>						  												
						<tr>
							<td style="width: 25%;">Keterangan</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_status_keterangan"></td>
						</tr>
					  </tbody>
					</table>					
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">COB</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>
					  	<tr>
							<td style="width: 25%;">Nama Asuransi</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_nama"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">No. Asuransi</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_nomor"></td>
						</tr>	
						<tr>
							<td style="width: 25%;">Tanggal TAT</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_tat"></td>
						</tr>	
						<tr>
							<td style="width: 25%;">Tanggal TMT</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_cob_tmt"></td>
						</tr>								
					  </tbody>
					</table>					
					<hr>
					<h5 class="text-bold" style="font-size: 15px;color: ededed;font-weight: 600;">Informasi</h5>
					<table class="table-xs table-hover" width="100%">
					  <tbody>
					  	<tr>
							<td style="width: 25%;">Dinsos</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_informasi_dinsos"></td>
						</tr>						
						<tr>
							<td style="width: 25%;">No. SKTM</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_informasi_sktm"></td>
						</tr>
						<tr>
							<td style="width: 25%;">Prolanis PRB</td>
							<td style="width: 3%;">:</td>
							<td id="bpjs_informasi_prb"></td>
						</tr>															
					  </tbody>
					</table>	
						</div>
                  	</div>
                  	<div class="modal-footer">
                  		<button type="button" class="btn btn-primary waves-effect text-left" onclick="terapkan_data_bpjs()">Terapkan Data</button>
                      	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
                  	</div>
              	</div>
              	<!-- /.modal-content -->
          	</div>
          	<!-- /.modal-dialog -->
      	</div>
      	<!-- /.modal -->		
	
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 