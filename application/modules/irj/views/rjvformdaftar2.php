<?php
       // if ($role_id == 1) {
            $this->load->view("layout/header_left");
        //} else {
        //    $this->load->view("layout/header_horizontal");
       // }
	
	//cek jenis kunjungan
	if ( date("Y-m-d") == substr($data_pasien->tgl_daftar,0,10) ) 
		$jns_kunjungan="BARU";
	else $jns_kunjungan="LAMA";
?>

<style type="text/css">
	.canvas{
		border:1px solid #ccc;
		border-radius:10px;
	}
	.table-wrapper-scroll-y {
		display: block;
		max-height: 350px;
		overflow-y: auto;
		-ms-overflow-style: -ms-autohiding-scrollbar;
	}
	input:focus::-webkit-input-placeholder { color:transparent; }
	input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
	input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
	input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
	::-webkit-input-placeholder {
   		font-style: italic;
	}
	:-moz-placeholder {
	   font-style: italic;  
	}
	::-moz-placeholder {
	   font-style: italic;  
	}
	:-ms-input-placeholder {  
	   font-style: italic; 
	}
	.demo-radio-button label{
		min-width:120px;
	}
	.ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
	    border: 1px solid #dad55e;
	    background: #fffa90;
	    color: #777620;
	    font-weight: normal;
	}
	.ui-widget-content {    
	  	font-size: 15px;
	}
	.ui-widget-content .ui-state-active {    
	  	font-size: 15px;
	}
	.ui-autocomplete-loading {
		background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
	}	
	.ui-autocomplete { 
		max-height: 270px; overflow-y: scroll; overflow-x: scroll;
	}
</style>

<script type='text/javascript'>
var table_keluarga;
var site = "<?php echo site_url();?>";

function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
        limitField.value = limitField.value.substring(0, limitNum);
    }
}

$(document).ready(function(){
	var signature ;

	$('#detailModal').on('shown.bs.modal', function(e) {
         //get data-id attribute of the clicked element

        var no_register = $(e.relatedTarget).data('id');
        //tableDetail.clear().draw();
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {no_register:no_register},
            url: "<?php echo site_url(); ?>irj/rjcregistrasi/get_obat_desc",
            success: function( response ) {
                tableDetail.clear().draw();
                tableDetail.rows.add(response.data);
                tableDetail.columns.adjust().draw();

                $("#total_rekap").html(response.total);
            }
        });
    });

	tableDetail = $('#tableDetail').DataTable({
            columns: [
                { data: "nama_obat" },
                { data: "satuan" },
                { data: "qty" },
                { data: "signa" }
            ],
            columnDefs: [
                { targets: [ 0 ], orderable: false },
                { targets: [ 1 ], orderable: false },
                { targets: [ 2 ], orderable: false },
                { targets: [ 3 ], orderable: false }
            ],
            bFilter: false,
            bPaginate: true,
            destroy: true
    });
});

function cek_no_rujukan(no_identitas){
	console.log(no_identitas);
	if(no_identitas!='' && no_identitas!='-'){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_no_rujukan')?>/"+no_identitas+"/" + '<?php echo $data_pasien->no_medrec; ?>',
		success: function(data){
			// var jsonData = JSON.parse(data);
			if(data){
				// swal("Peringatan", "No KTP Sama dengan no RM : "+ data.no_cm + '.', "error");
				// document.getElementById("btn-submit").disabled= true;				
				$('#nosurat_skdp_sep').val(data.no_register.slice(-6)); // get no register ==> get 6 angka diakhir
				$('#nosurat_skdp_sep1').val(data.no_register.slice(-6)); // get no register ==> get 6 angka diakhir
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
$(function () {

	
			$('#form_biodata').on("submit",function(e){
				signature =	signaturePad.toDataURL();
				$('#signatureValue').val(signature);
				e.preventDefault();
				document.getElementById("btn-form-biodata-insert").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Menyimpan...';
				$.ajax({  
					url:"<?php echo base_url(); ?>irj/rjcregistrasi/update_data_pasien/",                         
					method:"POST",  
					data:new FormData(this),  
					contentType: false,  
					cache: false,  
					processData:false,  
					success: function(data)  
					{ 
						document.getElementById("form_biodata").reset();
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
						swal("Error","Data gagal disimpan.", "error"); 
						console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
					}  
				}); 
			});	
		});

function changeHandlerCaraBayar(event) {
	//console.log(this.value)
	switch (this.value) {
		case "UMUM":
			// console.log('KOSONG')
			// document.getElementById("no_identitas").  = false;		
			$(".div_bpjs").hide();   
			$("#div_rujukan").hide(); 
			$("#input_kontraktor").hide();
			$("#input_diagnosa").hide();
			// $("#label-identitas").html("No. Identitas");
			// $("#div-no-identitas").hide();
			break;
		case "BPJS":
			// console.log('KTP')
			// document.getElementById("no_identitas").  = true;		
			$(".div_bpjs").show(); 
			$("#div_rujukan").show();
			$("#input_kontraktor").show();
			$("#input_diagnosa").show();
			// $("#no_rujukan").prop(' ',true);
			$.ajax({
            url: '<?php echo base_url('irj/rjcregistrasi/data_kontraktor')?>/BPJS',
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                $('select[name="id_kontraktor"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'">'+ value.nmkontraktor +'</option>');
                });
            }
        });	
			// $("#label-identitas").html("No. NIK *");
			// $("#div-no-identitas").show();
			break;
			case "KERJASAMA":
			// console.log('KTP')
			// document.getElementById("no_identitas").  = true;		
			$(".div_bpjs").hide(); 
			$("#div_rujukan").hide();
			$("#input_kontraktor").show();
			$.ajax({
            url: '<?php echo base_url('irj/rjcregistrasi/data_kontraktor')?>/KERJASAMA',
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                $('select[name="id_kontraktor"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'">'+ value.nmkontraktor +'</option>');
                });
            }
        });	
			// $("#label-identitas").html("No. NIK *");
			// $("#div-no-identitas").show();
			break;
		default:
			// console.log(this.value);
			// document.getElementById("no_identitas"). = true;		
			$(".div_bpjs").hide(); 
			$("#div_rujukan").hide(); 
			$("#input_diagnosa").hide();
			$("#input_kontraktor").hide();
			// $("#label-identitas").html("No. "+this.value); 
			// $("#div-no-identitas").show();
			break;
		}
}

$(document).ready(function() {
	//document.getElementById("no_kartu_bpjs").style.visibility = "hidden";
	var showSuratKontrolSkdp = <?= ($jns_kunjungan == "BARU")?0:1; ?>

	if(showSuratKontrolSkdp){
		$('#no_surat_kontrol_skdp').show();
	} else{
		// $('#no_surat_kontrol_skdp').hide();
		$('#no_surat_kontrol_skdp').show();
	}
	<?php
		if($online==1){
	?>
		$.ajax({
		    url: '<?php echo base_url('irj/rjconline/get_data_online')?>/'+<?=$id_online;?>,
		    type: "GET",
		    dataType: "JSON",
		    success:function(data) {
				$('#id_poli').val(data.id_poli_temp).change();
				$('#cara_bayar').val(data.cara_bayar_temp).change();
				$('#no_rujukan').val(data.no_rujukan_temp).change();
				$('#tgl_kunjungan').val(data.tgl_berobat_temp).change();
		        
		    }
		});	
	<?php
		}
	?>

	//$('#no_kartu_bpjs').hide();

	var radios = document.querySelectorAll('input[type=radio][name="cara_bayar"]');

	Array.prototype.forEach.call(radios, function(radio) {
		radio.addEventListener('change', changeHandlerCaraBayar);
	});
	
	
});

$(function() {
	// $('#div_table_keluarga').hide();
 //    $('#form_input_keluarga').hide();
	// alert($('#kesatuan').val());
	// $('#keluarga_tentara').hide();
		$(".select2").select2();
		
	     
	$(document).on("click","#btn-bpjs-biodata",function() {
		var button = $(this);
		var no_bpjs = $("#no_kartu_bpjs").val();
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('Data Peserta');
	    	swal("No. Kartu Kosong","Harap masukan nomor kartu BPJS.", "warning"); 
	    } else {       	
		    $.ajax({
		        type: "POST",
		        url: "<?php echo site_url('bpjs/peserta/no_kartu'); ?>",
		        dataType: "JSON",
		        data: {"no_bpjs" : no_bpjs},
		        success: function(result){ 
		        	console.log(result);
		        	if (result) {
		        		button.html('Data Peserta');
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
		        			swal("Gagal Data Peserta.",result.metaData.message, "error");
		        		}	              	
		        	} else {
		        		button.html('Data Peserta');
		              	swal("Error","Gagal Data Peserta.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('Data Peserta');
		            swal("Error",formatErrorMessage(event, errorThrown), "error");                 
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });
	$(document).on('hidden.bs.modal', '#modal-search-kode', function () {
	    $('#table-dpjp > tbody').empty();
	    $('#spesialis').val("NONE").change();
	});
	$(document).on("click",".select-kode-dpjp",function() {
	    // $("#dpjp_skdp_sep").val($(this).data('kodedpjp'));
		console.log($(this).data('kodedpjp'));
		console.log($(this).data('namadpjp'));

		// ini untuk id_dokter 
		var id = $(this).data('kodedpjp');
		var nm_dokter = $(this).data('namadpjp');
		var data = {
			id: id,
			text: nm_dokter
		};


		// ini untuk dpjp
		var id2 = $(this).data('kodedpjp') + '-' + $(this).data('namadpjp');
		var nm_dokter2 = $(this).data('namadpjp');
		var data2 = {
			id: id2,
			text: nm_dokter2
		};

		// console.log(data);

		var newOption = new Option(data.text, data.id, true, true);
		var newOption2 = new Option(data2.text, data2.id, true, true);
		$('#dpjp_skdp_sep').append(newOption2).trigger('change');
		$('#id_dokter').append(newOption).trigger('change');
	    $('#modal-search-kode').modal('hide');
	});	
	$(document).on("click","#btn-cari-dpjp",function() {
	    var button = $(this);
	    var jns_pelayanan = $("#jns_pelayanan").val();
	    var spesialis = $("#spesialis").val();
	    button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	    if (jns_pelayanan === '' || spesialis === '') {
	        button.html('<i class="fa fa-search"></i> Cari');
	        swal("Lengkapi Data","Silahkan isi jenis pelayanan dan spesialis/sub spesialis.", "warning"); 
	    } else {        
	      $.ajax({
	          type: "POST",
	          url: "<?php echo site_url('bpjs/referensi/dokter_dpjp'); ?>"+"/"+jns_pelayanan+"/"+spesialis,
	          dataType: "JSON",
	          success: function(result) { 
	            $('#table-dpjp > tbody').empty();
	            button.html('<i class="fa fa-search"></i> Cari');
	            if (result != '' || result != null) {
	              if (result.metaData.code == '200') {
	                $.each(result.response.list, function(i, item) {
	                  $('#table-dpjp > tbody:last-child').append(
	                    '<tr>'
	                    +'<td class="text-center">'+item.kode+'</td>'
	                    +'<td class="text-center">'+item.nama+'</td>'
	                    +'<td class="text-center"><button class="btn btn-danger select-kode-dpjp" data-namadpjp="'+item.nama+'" data-kodedpjp="'+item.kode+'"><i class="fa fa-check"></i> Pilih</button></td>'
	                    +'</tr>'
	                  );
	                });   
	              } else {
	                $('#table-dpjp > tbody:last-child').append(
	                  '<tr>'
	                  +'<td colspan="3" class="text-center">'+result.metaData.message+'</td>'
	                  +'</tr>'
	                );
	              }
	            } else {
	              swal("Error","Gagal load data dokter dpjp.", "error");  
	            }
	          },
	          error:function(event, textStatus, errorThrown) { 
	            button.html('<i class="fa fa-search"></i> Cari');
	            swal("Error",formatErrorMessage(event, errorThrown), "error");                   
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	          }
	      });
	    }
	});
    $(document).on("click","#btn-bpjs-daful",function() {
		var button = $(this);
		var no_bpjs = $("#no_bpjs").val();
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('Data Peserta');
	    	swal("No. Kartu Kosong","Harap masukan nomor kartu BPJS.", "warning"); 
	    } else {       	
		    $.ajax({
		        type: "POST",
		        url: "<?php echo site_url('bpjs/peserta/no_kartu'); ?>",
		        dataType: "JSON",
		        data: {"no_bpjs" : no_bpjs},
		        success: function(result){ 
					var idReplace;

		        	if (result) {
		        		button.html('Data Peserta');
		        		if (result.metaData.code == '200') {
		        			data = result.response.peserta;	     
							if(data.jenisPeserta.kode === "22"){
								idReplace = 3;
							}else if(data.jenisPeserta.kode === '14'){
								idReplace = 17;
							}else{
								idReplace = 60;
							}  	
							$('#id_kontraktor').val(idReplace).trigger('change');
   				        		
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
		        			swal("Gagal Data Peserta.",result.metaData.message, "error");
		        		}	              	
		        	} else {
		        		button.html('Data Peserta');
		              	swal("Error","Gagal Data Peserta.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('Data Peserta');
		            swal("Error",formatErrorMessage(event, errorThrown), "error");                 
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });
    $(document).on("click","#btn-rujukan-kartu",function() {
		var button = $(this);
		var no_bpjs = $("#no_kartu_bpjs").val();
		// var jenis_faskes = $('#cara_kunj').val();
		var jenis_faskes = $('input[name="cara_kunj"]:checked').val();
		// console.log($('#jenis_faskes').val());
		// console.log(no_bpjs) + console.log(jenis_faskes);
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
	    	swal("No. Kartu Kosong","Harap masukan nomor kartu.", "warning"); 
	    } else {       	
		    $.ajax({
		        type: "POST",
		        url: "<?php echo site_url('bpjs/rujukan/no_bpjs'); ?>"+"/"+no_bpjs,
		        dataType: "JSON",	  
		        // data: {"jenis_faskes" : 'RUJUKAN RS' },    
		        data: {"jenis_faskes" : jenis_faskes},    
		        success: function(result){ 
		        	console.log(result);
		        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
		        	if (result != '') {
						if (result.metaData.code == '200') {	        				
							data = result.response.rujukan;	        				        		
		        			$('#rujukan_nomor').html(data.noKunjungan);
		        			$('#rujukan_tgl').html(data.tglKunjungan);
		        			$('#rujukan_faskes').html(data.provPerujuk.kode + ' - ' + data.provPerujuk.nama);
		        			$('#rujukan_poli').html(data.poliRujukan.nama+' (<span id="rujukan_kode_poli">'+data.poliRujukan.kode+'</span>)');
		        			$('#rujukan_nama').html(data.peserta.nama);
		        			$('#rujukan_noka').html(data.peserta.noKartu);
		        			$('#rujukan_diagnosa').html(data.diagnosa.kode + ' - ' + data.diagnosa.nama);
							// if($('#no_kartu_bpjs').val() === ""){
							$('#no_kartu_bpjs').val(data.peserta.noKartu);
							// }
		        			if (data.peserta.sex === 'L') {
		        				$('#rujukan_gender').html('Laki-Laki');
		        			} else if (data.peserta.sex === 'P') {
		        				$('#rujukan_gender').html('Perempuan');
		        			} else {
		        				$('#rujukan_gender').html(data.peserta.sex);
		        			}
		        			$('#rujukan_jenis_rawat').html(data.pelayanan.nama);
							var datanya = {
									id:data.diagnosa.kode +'@'+data.diagnosa.nama,
									text:data.diagnosa.kode + '-' + data.diagnosa.nama
								}
								var newOption = new Option(datanya.text,datanya.id,false,false);
							$('#diagnosa').append(newOption).trigger('change');
		        			$('.modal_norujukan').modal('show');
		        		} else {
		        			swal("Lihat Rujukan",result.metaData.message, "warning");
		        		}	              	
		        	} else {
		              	swal("Gagal Lihat Rujukan","Terjadi Kesalahan, Silahkan Coba Kembali.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
		            swal("Error",formatErrorMessage(event, errorThrown), "error");                   
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });
    $(document).on("click","#btn-rujukan",function() {
		var button = $(this);
		var no_rujukan = $("#no_rujukan").val();
		
	    // var cara_kunjungan = $("#cara_kunj").val();
		var cara_kunjungan = $('input[name="cara_kunj"]:checked').val();
	    var service_url;
	    button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
	    if (cara_kunjungan === 'RUJUKAN RS') {
	    	service_url = "<?php echo site_url('bpjs/rujukan/rs'); ?>"+"/"+no_rujukan;
	    } else service_url = "<?php echo site_url('bpjs/rujukan/pcare'); ?>"+"/"+no_rujukan;
	    if (cara_kunjungan === '') {
	    	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
	    	swal("Gagal Lihat Rujukan","Silahkan pilih cara kunjungan terlebih dahulu.", "warning"); 
	    } else {    	
	    	if (no_rujukan == '') {
		    	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
		    	swal("No. Rujukan Kosong","Silahkan masukan nomor rujukan.", "warning"); 
		    } else {       	
			    $.ajax({
			        type: "POST",
			        url: service_url,
			        dataType: "JSON",		        
			        success: function(result){ 
			        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');	        	
			        	if (result != '') {
			        		if (result.metaData.code == '200') {
			        			data = result.response.rujukan;
								console.log(data);
								$('#kode_faskes_perujuk').val(data.provPerujuk.kode);
								$('#nama_faskes_perujuk').val(data.provPerujuk.nama);
								// var arr = [];
								// arr.push({
								// 	id:data.diagnosa.kode +'@' +data.diagnosa.nama,
								// 	text:data.diagnosa.kode + ' - ' + data.diagnosa.nama
								// })
								// $new_row['id'] = $row->id_icd.'@'.$row->nm_diagnosa;
								// $new_row['text'] = $row->id_icd.' - '.$row->nm_diagnosa;                 
								// $row_set[] = $new_row;	        				        		
								// console.log(data.diagnosa.kode+'@'+ data.diagnosa.nama);
								var datanya = {
									id:data.diagnosa.kode +'@'+data.diagnosa.nama,
									text:data.diagnosa.kode + '-' + data.diagnosa.nama
								}
								var newOption = new Option(datanya.text,datanya.id,false,false);
								$('#diagnosa').append(newOption).trigger('change');
                                $("#id_diagnosa").val(data.diagnosa.kode);
								// $('#diagnosa').select2('data',{id:data.diagnosa.kode +'@'+data.diagnosa.nama,text:data.diagnosa.kode + '-' + data.diagnosa.nama});
			        			$('#rujukan_nomor').html(data.noKunjungan);
			        			$('#rujukan_tgl').html(data.tglKunjungan);
			        			$('#rujukan_faskes').html(data.provPerujuk.kode + ' - ' + data.provPerujuk.nama);
			        			$('#rujukan_poli').html(data.poliRujukan.nama+' (<span id="rujukan_kode_poli">'+data.poliRujukan.kode+'</span>)');
			        			$('#rujukan_nama').html(data.peserta.nama);
			        			$('#rujukan_noka').html(data.peserta.noKartu);
			        			$('#rujukan_diagnosa').html(data.diagnosa.kode + ' - ' + data.diagnosa.nama);
								$('#no_bpjs').val(data.peserta.noKartu);
								// console.log($('#no_kartu_bpjs').val());
								// if($('#no_rujukan').val() === ""){
									// $('#no_rujukan').val(data.peserta.noKartu);
								// }
			        			if (data.peserta.sex === 'L') {
			        				$('#rujukan_gender').html('Laki-Laki');
			        			} else if (data.peserta.sex === 'P') {
			        				$('#rujukan_gender').html('Perempuan');
			        			} else {
			        				$('#rujukan_gender').html(data.peserta.sex);
			        			}
			        			$('#rujukan_jenis_rawat').html(data.pelayanan.nama);
			        			$('.modal_norujukan').modal('show');		        				        	
			        		} else {		        			
			        			swal("Gagal Lihat Rujukan",result.metaData.message, "error");
			        		}	              	
			        	} else {		        		
			              	swal("Error","Gagal Lihat Rujukan", "error");  
			        	}
			        },
			        error:function(event, textStatus, errorThrown) { 
			        	button.html('<i class="fa fa-eye"></i> Lihat Rujukan');
			            swal("Error",formatErrorMessage(event, errorThrown), "error");                   
			            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			        }
			    });
		    }
	    } 
    });
		var jenis_identitas = $('#jenis_identitas').val();
		var val_cara_bayar = $('#cara_bayar').val();
		var alasan_berobat = $('#alasan_berobat').val();
		var cara_kunjungan = $('#cara_kunjungan').val();
		set_ident(jenis_identitas);
		pilih_cara_bayar(jenis_identitas);
		pilih_alber(alasan_berobat);
		pilih_kunjungan(cara_kunjungan);
		show_keluarga();
		table_keluarga = $('#table_keluarga').DataTable({ 
		  "language": {
	      	"emptyTable": "Tidak ada data keluarga/kerabat"
	      },
	      "processing": true,
	      "serverSide": true,
	      "order": [],
	      "lengthMenu": [
	        [ 10, 25, 50, -1 ],
	        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
	      ],
	      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	      "ajax": {
	        "url": "<?php echo site_url('irj/rjcregistrasi/data_keluarga/')?>",
	        "type": "POST",
	        "dataType": 'JSON',
	        "data": function (data) {
	          data.no_nrp = '<?php echo $data_pasien->no_nrp; ?>';
	          data.no_cm = '<?php echo $data_pasien->no_cm; ?>';
	        } 
	      }   
	    });
	    table_keluarga.on('draw', function () {
	        /* Now you can count rows */
	        var count = table_keluarga.data().count();
	        var nrp_sbg = '<?php echo $data_pasien->nrp_sbg; ?>';

	        if (count > 0) {
	        	$('#btn_modal').attr('data-target','#modal_keluarga_anggota');
	        } else {
	        	if (nrp_sbg == 'T') {
	        		$('#btn_modal').attr('data-target','#modal_keluarga_anggota');
	        	} else {
	        		$('#btn_modal').attr('data-target','#modal_keluarga');
	        	}	        	
	        }
		});
	$(".jns_kunj").attr('readonly', true);
	$('#hubungan').hide();
	$("#duplikat_id").hide();
	$("#duplikat_kartu").hide();
	$('#input_kontraktor').hide();
	$('#input_diagnosa').hide();
	$('#input_kecelakaan').hide();
	$('#ird').hide();
	$(".div_bpjs").hide();
	$('#div_rujukan').hide();
	$('#div_katarak').hide();
	$('.div_skdp').hide();
	

	// $('.auto_diagnosa_pasien').autocomplete({
	// 	serviceUrl: site+'iri/ricstatus/data_icd_1',
	// 	onSelect: function (suggestion) {
	// 		//$('#no_cm').val(''+suggestion.no_cm);
	// 		$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
	// 		$('#id_diagnosa').val(''+suggestion.id_icd);
	// 		// $('#nama').val(''+suggestion.nama);
	// 		// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
	// 		// if(suggestion.jenis_kelamin=='L'){
	// 		// 	$('#laki_laki').attr('selected', 'selected');
	// 		// 	$('#perempuan').removeAttr('selected', 'selected');
	// 		// }else{
	// 		// 	$('#laki_laki').removeAttr('selected', 'selected');
	// 		// 	$('#perempuan').attr('selected', 'selected');
	// 		// }
	// 		// $('#telp').val(''+suggestion.telp);
	// 		// $('#hp').val(''+suggestion.hp);
	// 		// $('#id_poli').val(''+suggestion.id_poli);
	// 		// $('#poliasal').val(''+suggestion.poliasal);
	// 		// $('#id_dokter').val(''+suggestion.id_dokter);
	// 		// $('#dokter').val(''+suggestion.dokter);
	// 		// $('#diagnosa').val(''+suggestion.diagnosa);
	// 	}
	// });
	$('.autocomplete_diagnosa').select2({
	    placeholder: 'Ketik kode atau nama diagnosa',
	    minimumInputLength: 1,
	    language: {
	      inputTooShort: function(args) {
	        return "Ketik kode atau nama diagnosa";
	      },
	      noResults: function() {
	        return "Diagnosa tidak ditemukan.";
	      },
	      searching: function() {
	        return "Searching.....";
	      }
	    },
	    ajax: {
	      type: 'GET',
	      url: '<?php echo base_url().'irj/Diagnosa/select2'; ?>',
	      dataType: 'JSON',        
	      delay: 250,
	      processResults: function (data) {
	        return {
	          results: data
	        };
	      },
	      cache: true
	    }
	});


	$('.auto_search_by_nocm').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_medrec);
		}
	});
	
	$('.auto_search_by_nokartu').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_nokartu',
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
		}
	});
	$('.auto_search_by_noidentitas').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_pasien_by_noidentitas',
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
	});
	$('.auto_search_poli').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#id_poli').val(''+suggestion.id_poli);
			$('#kd_ruang').val(''+suggestion.kd_ruang);
		}
	});

	// $('.load_wilayah').select2({
    //     placeholder: '-- Cari Kota/Kabupaten, Kecamatan atau Kelurahan --',
    //     ajax: {
    //       url: '<?php echo site_url('irj/rjcregistrasi/get_wilayah'); ?>',
    //       dataType: 'json',
    //       delay: 250,
    //       processResults: function (data) {
    //         var results = [];

    //             $.each(data, function(index, item){
    //                 results.push({
    //                     id: item.id_provinsi + '@' + item.id_kota + '@' + item.id_kecamatan + '@' + item.id_kelurahan,
    //                     text: item.nm_kelurahan + ', ' + item.nm_kecamatan + ', ' + item.nm_kota + ', ' + item.nm_provinsi
    //                 });
    //             });
    //             return { results: results };
    //       },
    //       cache: true
    //     }
    //   });

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
	
	$('.date_picker').datepicker({
		dateFormat: "dd-mm-yy",
  		changeMonth: true,
  		changeYear: true,
		autoclose: true,
		todayHighlight: true,
		yearRange: "c-100:c+100",	
       maxDate: 0,
	   
	}); 	
	
	$('.date_pickers').datepicker({
		dateFormat: "dd-mm-yy",
  		changeMonth: true,
  		changeYear: true,
		autoclose: true,
		todayHighlight: true,
		yearRange: "c-100:c+100",	
	   
	}); 
	// $("#date_picker1").datepicker("setDate", new Date());

	
	var jns_kunj = '<?php echo $jns_kunjungan; ?>';
		/*var biayakarcis_baru = '<?php echo $biayakarcis->nilai_karcis_baru; ?>';
		var biayakarcis_lama = '<?php echo $biayakarcis->nilai_karcis_lama; ?>';*/
		
		if (jns_kunj=='BARU') {
			var id_poli_umum = '<?php echo $poliumum; ?>';
			$('#id_poli').val(id_poli_umum).change();
			// ajaxdokter(id_poli_umum);			
		}
	//if($('#chk1').prop('checked')==false){
	//  	$('#input_tentara').hide();
	//  	document.getElementById("no_nrp"). = false;
	//	document.getElementById("nrp_sbg"). = false;
	//  }else{
	//  	$('#input_tentara').show();
	//  	document.getElementById("no_nrp"). = true;
	//	document.getElementById("nrp_sbg"). = true;
	//  }

	//$('#chk1').change(function() {
	 // alert($(this).prop('checked'))
	//  if($(this).prop('checked')==false){
	  //	$('#input_tentara').hide();
	 // 	document.getElementById("no_nrp"). = false;
	//	document.getElementById("nrp_sbg"). = false;
	//  }else{
	//  	$('#input_tentara').show();
	//  	document.getElementById("no_nrp"). = true;
	//	document.getElementById("nrp_sbg"). = true;
	//  }
	//});
	// $('#chk_keluarga_tentara').change(function() {
	//   if($(this).prop('checked')==false){
	//   	$('#keluarga_tentara').hide();
	//   }else{
	//   	$('#keluarga_tentara').show();
	//   }
	// });

});
function pilih_cara_bayar(val_cara_bayar){

	var alasan_berobat = $('#alasan_berobat').val();
	if (val_cara_bayar === 'BPJS' && alasan_berobat === 'kecelakaan') {
		$('#input_penjamin_kkl').show();
		$('#input_kontraktor').show();
	} else {
		$('#input_penjamin_kkl').hide();
	}

	if (val_cara_bayar == 'KERJASAMA'){
		$('#input_kontraktor').show();
		$('.div_bpjs').hide();
		$("#div_rujukan").hide();
		document.getElementById("button_cetak_karcis").disabled= false;
		document.getElementById("id_kontraktor").  = true;
		document.getElementById("no_rujukan").  = false;
		document.getElementById("input_diagnosa").  = false;
		document.getElementById("dpjp_skdp_sep").  = false;

		$.ajax({
            url: '<?php echo base_url('irj/rjcregistrasi/data_kontraktor')?>/'+val_cara_bayar,
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                $('select[name="id_kontraktor"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'">'+ value.nmkontraktor +'</option>');
                });
            }
        });		

	} else if (val_cara_bayar == 'BPJS') {
		$('#input_diagnosa').show();
		$('.div_bpjs').show();
		$('#input_kontraktor').show();
		document.getElementById("id_kontraktor").  = false;
		document.getElementById("input_diagnosa").  = true;
		document.getElementById("dpjp_skdp_sep").  = true;
        $.ajax({
            url: '<?php echo base_url('irj/rjcregistrasi/data_kontraktor')?>/'+val_cara_bayar,
            type: "GET",
            dataType: "JSON",
            success:function(data) {
                $('select[name="id_kontraktor"]').empty();
                $.each(data, function(key, value) {
                    if (value.nmkontraktor === 'BPJS Kesehatan') {
                		$('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'" selected>'+ value.nmkontraktor +'</option>');
                	} else {
                		$('select[name="id_kontraktor"]').append('<option value="'+ value.id_kontraktor +'">'+ value.nmkontraktor +'</option>');
                	}
                });
            }
        });
		//cek no kartu
		// var noBpjs = "<?php echo $data_pasien->no_kartu; ?>";	
		// if(noBpjs!=''){
		// 	$('#no_bpjs').val(noBpjs);
			//$('#content_div_bpjs').val('No. Kartu : '+noBpjs);
		// }
		//$('#biayadaftar_').val(0);
		//$('#biayadaftar').val(0);
		//document.getElementById("no_rujukan").  = true;
		//document.getElementById("id_diagnosa").  = true;		
	} else {
		$('select[name="id_kontraktor"]').empty();
		document.getElementById("button_cetak_karcis").disabled= false;
		$('#input_diagnosa').hide();
		$('.div_bpjs').hide();
		$('#div_rujukan').hide();
		$('#input_kontraktor').hide();	
		document.getElementById("id_kontraktor").  = false;
		document.getElementById("no_rujukan").  = false;
		document.getElementById("input_diagnosa").  = false;
		document.getElementById("dpjp_skdp_sep").  = false;
	}
	var cara_kunjungan = $('#cara_kunjungan').val();
	pilih_kunjungan(cara_kunjungan);
}

function pilih_kunjungan(cara_kunjungan) {
	var cara_bayar = $('#cara_bayar').val();
	var cara_kunjungan = $('#cara_kunjungan').val();
	if (cara_bayar === 'BPJS' && (cara_kunjungan === 'RUJUKAN PUSKESMAS' || cara_kunjungan === 'RUJUKAN RS')) {
		$('#div_rujukan').show();
	} else {
		$('#div_rujukan').hide();
	}
	if(cara_kunjungan == 'RUJUKAN RS') {
		$('#jenis_faskes').val(2);	
	} else {
		$('#jenis_faskes').val(1);	
	}
}

var ajaxku;
function ajaxkota(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kotakab'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKota;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_provinsi").value = res[0];
	document.getElementById("provinsi").value = res[1];
}

// function set_rujukan(rujukan){
// 	if(rujukan=='1'){
// 		$('#rujukan_lainnya').show();
// 		document.getElementById("dll_rujukan").  = true;
// 	}else{
// 		$('#rujukan_lainnya').hide();
// 		document.getElementById("dll_rujukan").  = false;
// 	}
// }

function ajaxkec(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kecamatan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();irj/rjcregistrasi/pasien
    ajaxku.onreadystatechange=stateChangedKec;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kotakabupaten").value = res[0];
	document.getElementById("kotakabupaten").value = res[1];
}

function ajaxkel(id){
	var res=id.split("-");//it Works :D
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcregistrasi/data_kelurahan'); ?>";
    url=url+"/"+res[0];
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedKel;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	document.getElementById("id_kecamatan").value = res[0];
	document.getElementById("kecamatan").value = res[1];
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
function stateChangedKota(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
		document.getElementById("kota").innerHTML = data;
		document.getElementById("kec").innerHTML = "<option selected value=\"\">Pilih Kecamatan</option>";
		document.getElementById("kel").innerHTML = "<option selected value=\"\">Pilih Kel/Desa</option>";
    }else{
    document.getElementById("kota").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
    }
    }
}

function stateChangedKontraktor(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_kontraktor").innerHTML = data;
		}
    }
}

function stateChangedKec(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kec").innerHTML = data
    }else{
    document.getElementById("kec").value = "<option selected value=\"\">Pilih Kecamatan</option>";
    }
    }
}

function stateChangedKel(){
    var data;
    if (ajaxku.readyState==4){
    data=ajaxku.responseText;
    if(data.length>=0){
    document.getElementById("kel").innerHTML = data
    }else{
    document.getElementById("kel").value = "<option selected value=\"\">Pilih Kelurahan/Desa</option>";
    }
    }
}

// function pilih_alber(val_alber){
// 		var res=val_alber.split("-");//it Works :D				
// 		if(res=='kecelakaan'){
// 			$('#input_kecelakaan').show();
// 			$('#input_penjamin').show();
// 			document.getElementById("jenis_kecelakaan"). = true;

// 		}else if(res=='sakit'){
// 			$('#input_kecelakaan').hide();
// 			$('#input_penjamin').hide();
// 			document.getElementById("jenis_kecelakaan"). = false;
// 		} else { }
// }

function pilih_alber(val_alber) {
	// var res = val_alber.split("-");	
	var cara_bayar = $('#cara_bayar').val();		
	if (val_alber === 'kecelakaan') {
		$('#input_kecelakaan').show();			
		document.getElementById("jenis_kecelakaan"). = true;
		if (cara_bayar === 'BPJS') {
			$('#input_penjamin_kkl').show();
		} else {
			$('#input_penjamin_kkl').hide();
		}

	} else {
		$('#input_kecelakaan').hide();	
		$('#input_penjamin_kkl').hide();		
		document.getElementById("jenis_kecelakaan"). = false;
	}
}

function ajaxdokter(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(4,4);

	var val_cara_bayar = $('#cara_bayar').val();
	var cara_kunjungan = $('#cara_kunjungan').val();
	//var res=id.split("-");//it Works :D
	if (id=='BA00') {
		if (cara_kunjungan == 'RUJUKAN PUSKESMAS' || cara_kunjungan == 'RUJUKAN RS' && val_cara_bayar == 'BPJS') {
			$('.div_bpjs').show();
			$('#div_rujukan').show();
		} else if (cara_kunjungan === 'DATANG SENDIRI' && val_cara_bayar == 'BPJS') {
			$('.div_bpjs').show();
			$('#no_rujukan').val('');
			$('#div_rujukan').hide();
		} else {
			$('#no_rujukan').val('');
			$('.div_bpjs').hide();
			$('#div_rujukan').hide();
		}
		$('#ird').show();
		$('#hubungan').show();
	} else {
		if (val_cara_bayar == 'BPJS') {
			if (id == 'BH00') {
				$('#div_katarak').show();
			} else {
				$('#div_katarak').hide();
			}
		}
		$('#ird').hide();
		$('#hubungan').hide();
	}

	if (pokpoli == 'EKSE') {
		$("#eksekutif").prop("checked", true); 
		$("#none_class").prop("checked", false); 
	}else{
		$("#none_class").prop("checked", true); 
		$("#eksekutif").prop("checked", false); 
	}

	// if (nk_pokpoli == 'NK') {
	// 	$('#none_class').prop("checked", true);
	// }else{		
	// 	$('#none_class').prop("checked", false);
	// }

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
		console.log(data);
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
			document.getElementById("dpjp_skdp_sep").innerHTML = data;
		}/*else{
		document.getElementById("id_dokter").value = "<option selected value=\"\">Pilih Kota/Kab</option>";
		}*/
    }
}

function terapkan_data_rujukan() {
	var diagnosa = $('#rujukan_diagnosa').text();	
	var no_rujukan = $('#rujukan_nomor').text();	
	var kode_poli = $('#rujukan_kode_poli').text();	
	// console.log(diagnosa);
	// var poli = $('#rujukan_poli').text();	

	var explode = diagnosa.split(" - ");
	var kode_diagnosa = explode[0];
	// console.log($('#no_kartu_bpjs').val());

	$('#no_rujukan').val(no_rujukan);
	$.ajax({
        type: "POST",
        url: "<?php echo site_url('bpjs/pasien/get_poli_bpjs'); ?>/"+kode_poli,
        dataType: "JSON",		        
        success: function(result){ 	        	
        	if (result != '') {
				console.log(result);
        		// $("#id_poli").val(result.id_poli).trigger('change');
				$('#id_poli').val(result.id_poli + result.nm_pokpoli).trigger('change');
				// console.log('sukses')
				// $('#id_diagnosa').val(kode_diagnosa);	
				

        	}
        },
        error:function(event, textStatus, errorThrown) {        
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
	// $('#diagnosa').val(diagnosa);	
	$('.modal_norujukan').modal('hide');
	// $('#id_poli').val(poli);	
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

// function cek_validasi(no_medrec){
//     ajaxku = buatajax();
//     var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
//     url=url+"/"+no_medrec;
//     ajaxku.onreadystatechange=stateChangedValidasi;
//     ajaxku.open("GET",url,true);
//     ajaxku.send(null);
// }	

// function cek_rujukan(){
// 	var no_rujukan = document.getElementById("no_rujukan").value;
// 	var e = document.getElementById("cara_kunjungan");
// 	var get_cara_kunjungan = e.options[e.selectedIndex].value;
// 	if (get_cara_kunjungan == 'RUJUKAN RS') {
// 		var cara_kunjungan = 'RS';
// 	}
// 	else {
// 		var cara_kunjungan = 'PCare';
// 	}	
// 	if (no_rujukan.length == 0) {		
// 	swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan", "error");
// 	}
// 	else {
//     ajaxku = buatajax();
//     var url="<?php echo site_url('irj/rjcwebservice/check_no_rujukan'); ?>";
//     url=url+"/"+no_rujukan+"/"+cara_kunjungan;
//     ajaxku.onreadystatechange=stateChangedValidasiRujukan;
//     ajaxku.open("GET",url,true);
//     ajaxku.send(null);
//     }
// }

// function stateChangedValidasi(){
// 	document.getElementById("btn_cek_kartu").innerHTML = '<i class="fa fa-spinner fa-spin" id="loading-rujukan"></i> Loading...';
// 	var data;
//     if (ajaxku.readyState==4){
// 		data=ajaxku.responseText;
// 		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {			

// 		}
// 		if(data.length>=0){
// 			document.getElementById("data_validasi").innerHTML = data;
// 			$('#modal_validasi').modal('show');
// 		}else{
// 			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
// 		}
// 		document.getElementById("btn_cek_kartu").innerHTML = "Cek Kartu";
//     }
// }

// function stateChangedValidasiRujukan(){
// 	var data;
//     if (ajaxku.readyState==4){
// 		data=ajaxku.responseText;
// 		if(data.length>=0){
// 			document.getElementById("data_validasi").innerHTML = data;
			
// 		}else{
// 			document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
// 		}
// 		if (data.indexOf('Tidak Ditemukan')!= -1 || data.indexOf('Masukan')!= -1) {	
// 			// $('#modal_validasi').modal('show');		
// 			// document.getElementById("cara_bayar" ).disabled=false;
// 			// document.getElementById("cara_bayar").selectedIndex = "0";
// 			document.getElementById("diagnosa" ).disabled=false;
// 			document.getElementById("id_poli" ).disabled=false;
// 			document.getElementById('id_poli').value = '';
// 			document.getElementById('kode_provider').value='';
// 			document.getElementById('diagnosa').value='';
// 			document.getElementById('entri_catatan').value='';	
// 			swal("Cek Nomor Rujukan", "Silahkan masukkan nomor rujukan yang valid", "error");
// 		}
// 		else {
// 			// document.getElementById('cara_bayar').value = 'BPJS';
// 			// document.getElementById("cara_bayar" ).disabled=true;
// 			document.getElementById("diagnosa" ).disabled=false;
// 			document.getElementById("id_poli" ).disabled=false;
// 			var data1 = JSON.parse(data);
// 			document.getElementById('kode_provider').value=data1["response"].item.provKunjungan.kdProvider;
// 			document.getElementById('diagnosa').value=data1["response"].item.diagnosa.kdDiag;
// 			document.getElementById('entri_catatan').value=data1["response"].item.catatan;
// 			var update_kartu = document.getElementById("no_kartu_bpjs").value;
// 			if (update_kartu.length == 0) {
// 			swal({
//   			title: ""+data1["response"].item.peserta.nama+"",
//   			type: "success",
//   			text: "<p>Nomor Kartu : "+data1["response"].item.peserta.noKartu+"<p/><p>NIK : "+data1["response"].item.peserta.nik+"<p/><p>Status Peserta : "+data1["response"].item.peserta.statusPeserta+"</p>",
//   			html: true,
// 			showCancelButton: true,
//   			confirmButtonColor: "#DD6B55",
//   			confirmButtonText: "Simpan Nomor Kartu",
//   			closeOnConfirm: false
// 			},
// 			function(){
// 			update_nokartu(data1["response"].item.peserta.noKartu);
//   			swal("Sukses", "Nomor kartu berhasil disimpan.", "success");
// 			});		  							
// 			}
// 			if (update_kartu.length > 0) {
// 			swal({
//   			title: ""+data1["response"].item.peserta.nama+"",
//   			type: "success",
//   			text: "<p>Nomor Kartu : "+data1["response"].item.peserta.noKartu+"<p/><p>NIK : "+data1["response"].item.peserta.nik+"<p/><p>Status Peserta : "+data1["response"].item.peserta.statusPeserta+"</p>",
//   			html: true,
//   			showCancelButton: true,
//   			confirmButtonColor: "#DD6B55",
//   			confirmButtonText: "Update Nomor Kartu",
//   			closeOnConfirm: false
// 			},
// 			function(){
// 			update_nokartu(data1["response"].item.peserta.noKartu);
//   			swal("Sukses", "Nomor kartu berhasil diupdate.", "success");
// 			});				
// 			}			
// 			// swal(""+data1["response"].item.peserta.nama+"", "Nomor Kartu : "+data1["response"].item.peserta.noKartu+"", "success");	
// 		}
//     }
// }

function cek_eligible(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
    url=url+"/"+no_medrec;
    ajaxku.onreadystatechange=stateChangedSEP;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}	
	
// function stateChangedSEP(){
//     var data;
//     if (ajaxku.readyState==4){
//     data=ajaxku.responseText;
// 		if(data.length>=0){
// 			document.getElementById("data_anggota").innerHTML = data;
// 			$('#data_webservice').modal('show');
// 		}else{
// 			document.getElementById("data_anggota").innerHTML = "Data Tidak Ditemukan";
// 		}
//     }
// }

	
function cek_search_per(val_search_per){
	//alert(val_search_per);
	if(val_search_per=='cm'){
		$("#cari_no_cm").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_cm").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
	}else{
		$("#cari_no_cm").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		
	}
}

function cek_no_identitas(no_identitas, no_identitas_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/"+no_identitas_old,
		success: function(data){
			if (data>0) {
				document.getElementById("content_duplikat_id").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Identitas \""+no_identitas+"\" Sudah Terdaftar ! <br>Silahkan masukkan no identitas lain...";
				$("#duplikat_id").show();
				document.getElementById("btn-submit").disabled= true;
				//$(window).scrollTop(0);
			} else {
				$("#duplikat_id").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}

function cek_no_kartu(no_kartu, no_kartu_old){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/"+no_kartu_old,
		success: function(data){
			//alert(data);
			if (data>0) {
				//alert("No Kartu '"+no_kartu+"' Sudah Terdaftar ! <br> Silahkan masukkan no kartu lain...");
				document.getElementById("content_duplikat_kartu").innerHTML = "<i class=\"icon fa fa-ban\"></i> No Kartu \""+no_kartu+"\" Sudah Terdaftar ! Silahkan masukkan no kartu lain...";
				$("#duplikat_kartu").show();
				document.getElementById("btn-submit").disabled= true;
			} else {
				$("#duplikat_kartu").hide();
				document.getElementById("btn-submit").disabled= false;
			}
		},
		error: function (request, status, error) {
			alert(request.responseText);
		}
    });
}



function set_ident(ident){
	if (ident == '') {
		document.getElementById("no_identitas").  = true;		
		$("#btn_cek_nik").hide();    
		$("#label-identitas").html('Identitas');
	} else if (ident == 'KTP') {
		document.getElementById("no_identitas").  = false;		
		$("#btn_cek_nik").show(); 
		$("#label-identitas").html('No. NIK');
	} else {
		document.getElementById("no_identitas"). = false;		
		$("#btn_cek_nik").hide(); 
		$("#label-identitas").html('No. '+ident); 
	}
}

function update_nokartu(no_kartu) {
  var no_medrec = document.getElementById("no_medrec").value;
  if(no_medrec.length > 0 && no_kartu.length > 0){
  $.ajax({
        type: 'POST',
        url: '<?php echo base_url('irj/rjcwebservice/update_nokartu')?>',
        data: {
        no_kartu:no_kartu,
        no_medrec:no_medrec
        },
        success: function (response) {
		document.getElementById("no_kartu_bpjs").value = no_kartu;
		$('#no_bpjs').val(no_kartu);
        }
    });

return false;
}
}

function save_keluarga() {
    document.getElementById("btn-save-keluarga").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('irj/rjcregistrasi/save_keluarga'); ?>",
      dataType: "JSON",
      data: $('#form_input_keluarga').serialize(),
      success: function(result){      
        if (result == true) {
          document.getElementById("btn-save-keluarga").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan'; 
          show_keluarga();
          $('#modal_keluarga').modal('hide');
          swal("Sukses","Data berhasil disimpan.", "success"); 
        } else {
          swal("Error","Gagal menyimpan data.", "error");  
        }
      },
      error:function(event, textStatus, errorThrown) { 
        document.getElementById("btn-save-keluarga").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
        $('#modal-rl').modal('hide');
        swal("Error","Gagal menyimpan data.", "error");              
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });     
}

function generate_rm(no_medrec) {	
    document.getElementById("btn-generate-rm").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('irj/rjcregistrasi/generate_rm'); ?>",
      dataType: "JSON",
      data: {"no_medrec" : no_medrec,"no_cm" : '<?php echo $data_pasien->no_cm; ?>'},
      success: function(result){      
        if (result == true) {
          document.getElementById("btn-generate-rm").innerHTML = 'Buat RM Baru';  
          swal("Sukses","No. RM Berhasil Diperbaharui.", "success"); 
          // get_rm();         
		  location.reload();
        } else {
          swal("Error","Gagal menyimpan data.", "error");  
        }
      },
      error:function(event, textStatus, errorThrown) { 
        document.getElementById("btn-generate-rm").innerHTML = 'Buat RM Baru';          
        swal("Error","Gagal Generate RM Baru.", "error");              
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });     
}

function get_rm() {	    
    $.ajax({
      type: "POST",
      url: "<?php echo site_url('irj/rjcregistrasi/get_rm'); ?>",
      dataType: "JSON",
      data: {"no_medrec" : '<?php echo $data_pasien->no_medrec; ?>'},
      success: function(result){       
        if (result != '') {
          $('#cm_baru').val(result.no_cm);
          $('#cm_lama').val(result.no_cm_lama);
        }
      },
      error:function(event, textStatus, errorThrown) {                     
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });     
}

function show_keluarga() {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('irj/rjcregistrasi/show_keluarga/'.$data_pasien->no_cm); ?>",
      dataType: "JSON",      
      success: function(result){ 

        if (result !== null) {      	
        	  $('#keluarga_nik').val(result.nik);
	          $('#keluarga_nama').val(result.nama);
	          $('#keluarga_hubungan').val(result.hubungan);	          
	          $('#keluarga_nrp').val(result.no_nrp);
	          $('#keluarga_tgl_lahir').val(result.tgl_lahir);
	          $('#keluarga_alamat').val(result.alamat);
	          $('#keluarga_telp').val(result.no_telp);
	          $('#keluarga_agama').val(result.agama);	          
	          $("#keluarga_pendidikan").val(result.pendidikan).change();	          
	          $("#keluarga_pekerjaan").val(result.pekerjaan).change();
	          $('#keluarga_pangkat').val(result.pangkat);
	          $('#keluarga_alamat_kantor').val(result.alamat_kantor);
	          $('#keluarga_telp_kantor').val(result.telp_kantor);
	          $('#keluarga_jabatan').val(result.jabatan);
	          $('#keluarga_kesatuan').val(result.kesatuan);
	          $('#keluarga_alamat_kesatuan').val(result.alamat_kesatuan);
	          $('#keluarga_telp_kesatuan').val(result.telp_kesatuan);
        }
      },
      error:function(event, textStatus, errorThrown) { 
        swal("Error","Data tidak tersedia .", "error");                    
        console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
      }
    });       
}

function search_dpjp() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("search_dpjp");
  filter = input.value.toUpperCase();
  table = document.getElementById("table-dpjp");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function dokterChange(e){
	// console.log(e.target.value);
	var input = e.target.value;
	var fields = input.split('-');
	var data = {
		id: fields[0],
		text: fields[1]
	};

	console.log(data);

	// var newOption = new Option(data.text, data.id, true, true);
	// $('#id_dokter').append(newOption).trigger('change');
}

function validasiSubmit() {
		$('#signatureValue').val(signature);
	if ($('#check_cetak_kartu').is(':checked')) {
		window.open("<?php echo base_url().'irj/rjcregistrasi/st_cetak_kartu_pasien/'.$data_pasien->no_cm; ?>","_blank");
		window.focus();
	}else{}
}

function validate(form){
			
			// return true;
		
	}


	
</script>

<?php echo $this->session->flashdata('notification');?>
<?php echo $this->session->flashdata('success_msg'); ?>
<div class="card">
    <div class="card-block p-b-0">
        <ul class="nav nav-tabs customtab" role="tablist">
			<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#biodata" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">BIODATA</span></a> </li>
            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#daftar_ulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">DAFTAR ULANG PASIEN IRJ</span></a> </li>
		</ul>
                            <!-- Tab panes -->
        <div class="tab-content">
			<div id="biodata" class="tab-pane" role="tabpanel">					
					<div class="col-lg-10" style="margin: 0 auto;">	
								<br>
						<br>
							<?php
								$no_medrec=$data_pasien->no_medrec;
								if($data_pasien->foto!=''){
									$foto=$data_pasien->foto;
								}else $foto="unknown.png";
							?>
							<div class="row">
								<div class="col-sm-12 text-center">
									<!-- <img height="150px" class="img-rounded" src="<?php echo base_url("upload/photo/".$foto);?>"> -->
								</div>
								<div class="col-sm-12 ">
									<?php echo form_open_multipart('irj/rjcregistrasi/cetak_kartu_pasien');?>
										<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec" id="no_medrec">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cetak_kartu" id="cetak_kartu">
										<!-- <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-id-card-o"></i> Cetak Kartu</button> -->
										<a href="<?php echo site_url('irj/rjcregistrasi/st_cetak_kartu_pasien/').'/'.$data_pasien->no_cm; ?>" target="_blank" class="btn waves-effect waves-light btn-primary"><i class="fa fa-print"></i> Cetak Kartu Pasien</a>	
										<a href="<?php echo site_url('emedrec/C_emedrec/cetak_identitas/').'/'.$data_pasien->no_cm.'/'.$data_pasien->no_medrec; ?>" target="_blank" class="btn waves-effect waves-light btn-danger"><i class="fa fa-print"></i> Cetak Identitas</a>	
										<!-- <button type="button" class="btn btn-primary" alt="default" data-toggle="modal" data-target="<?php if($data_pasien->no_nrp == '') {echo '#modal_keluarga';} else echo '#modal_keluarga_anggota'; ?>"><i class="fa fa-users"></i> Data Keluarga</button>	 -->
										<!-- <button type="button" class="btn btn-primary" alt="default" data-toggle="modal" data-target="modal_keluarga" id="btn_modal"><i class="fa fa-users"></i> Data Keluarga</button>		 -->
									<?php echo form_close();?>										
								</div>
							</div>
							<br>
							<br>
						<!-- <form method="POST"  id="form_biodata" class="form-horizontal" enctype='multipart/form-data'> -->
						<form method="POST"  id="form_biodata" class="form-horizontal">
								<input type="hidden" class="form-control" value="<?php echo $online;?>" name="online" readonly>
								<?php
									if($online==1){
								?>
									<input type="hidden" class="form-control" value="<?php echo $id_online;?>" name="id_online" readonly>
								<?php
									}
								?>
								<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_cm" readonly>
								<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_cm">No RM *</p>
									<div class="col-sm-4">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cm_baru" id="cm_baru" readonly>
									</div>
									<!-- <p class="col-sm-3 form-control-label" id="no_cm">No medi</p> -->
									<div class="col-sm-4">
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_medrec;?>" name="no_medrec" id="cm_baru" readonly>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tgl_daftar">Tanggal Daftar *</p>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="text" class="form-control" value="<?php echo $data_pasien->tgl_daftar;?>" name="tgl_daftar" readonly>
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $data_pasien->nama;?>" name="nama"  >
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
									<div class="col-sm-8">										
										<div class="demo-radio-button">
											<input name="sex" type="radio" id="laki_laki" class="with-gap" value="L" <?php if($data_pasien->sex=='L') echo 'checked' ?>  />
				                            <label for="laki_laki">Laki-Laki</label>
				                            <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" <?php if($data_pasien->sex=='P') echo 'checked' ?> />
				                            <label for="perempuan">Perempuan</label>           		
										</div>
									</div>
								</div>
								
								
								<div class="form-group row">
									<p class="col-sm-3 form-control-label">Pilih Identitas *</p>
									<div class="col-sm-8">
										<div class="form-inline">
												<input name="jenis_identitas" type="radio"  id="KTP"  class="with-gap" value="KTP" <?php if($data_pasien->jenis_identitas=='KTP') echo 'checked';?>  />
												<label for="KTP" >KTP</label>
												<input name="jenis_identitas" type="radio" id="SIM" class="with-gap" value="SIM"  <?php if($data_pasien->jenis_identitas=='SIM') echo 'checked';?>/>
												<label for="SIM" style="margin-left:30px">SIM</label>
												<input name="jenis_identitas" type="radio" id="PASPOR" class="with-gap" value="PASPOR" <?php if($data_pasien->jenis_identitas=='PASPOR') echo 'checked';?>/>
												<label for="PASPOR" style="margin-left:30px">PASPOR</label>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" >No. Identitas *</p>
									<div class="col-sm-5">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_identitas;?>" name="no_identitas"  id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)"  >
									</div>
									<div class="col-sm-3">
										<button class="btn btn-info btn-block" type="button" onclick="cekbpjs_nik()" id="btn_cek_nik">Cek Peserta BPJS</button>
									</div>
								</div>
								<div class="form-group row" id="duplikat_id">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
									</div>
								</div>						
								<hr>
								
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
									<div class="col-sm-5">
										<input type="text"  class="form-control" value="<?php echo isset($data_pasien->no_kartu)?$data_pasien->no_kartu:'';?>" name="no_kartu" id="no_kartu_bpjs" onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')">
									</div>
									<div class="col-sm-3">
										<button class="btn btn-info btn-block" type="button" id="btn-bpjs-biodata">Cek Peserta BPJS</button>
									</div>
								</div>
								<div class="form-group row" id="duplikat_kartu">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-8">
										<p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
									</div>
								</div>
							
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase()"  value="<?php echo $data_pasien->tmpt_lahir;?>" name="tmpt_lahir"  >
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 control-label" id="tgl_lahir">Tanggal Lahir *</label>
									<div class="col-sm-8">
										<input type="date" class="form-control" placeholder="" id="tgl_rujukan" value="<?php echo date('Y-m-d',strtotime($data_pasien->tgl_lahir));?>" name="tgl_lahir">
									</div>
								</div>	
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="agama">Agama *</p>
									<div class="col-sm-8">
									<div class="form-inline">
										<!-- <input name="agama" type="radio"  id="nonea"  class="with-gap" value="" <?php if($data_pasien->agama=='ISLAM') echo 'selected';?>/>
										<label for="nonea">NONE</label> -->
										<input name="agama" type="radio"  id="ISLAM"  class="with-gap" value="ISLAM" <?php if($data_pasien->agama=='ISLAM') echo 'checked';?>  />
										<label for="ISLAM">Islam</label>
										<input name="agama" type="radio"  id="KATHOLIK"  class="with-gap" value="KATHOLIK" <?php if($data_pasien->agama=='KATHOLIK') echo 'checked';?>/>
										<label for="KATHOLIK" style="margin-left:10px;" >Katholik</label>
										<input name="agama" type="radio"  id="KRISTEN"  class="with-gap" value="KRISTEN" <?php if($data_pasien->agama=='KRISTEN') echo 'checked';?>/>
										<label for="KRISTEN" style="margin-left:10px;">Kristen</label>
										<input name="agama" type="radio"  id="BUDHA"  class="with-gap" value="BUDHA" <?php if($data_pasien->agama=='BUDHA') echo 'checked';?>/>
										<label for="BUDHA" style="margin-left:10px;">Budha</label>
										<input name="agama" type="radio"  id="HINDU"  class="with-gap" value="HINDU" <?php if($data_pasien->agama=='HINDU') echo 'checked';?>/>
										<label for="HINDU" style="margin-left:10px;">Hindu</label>
									</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="status">Status *</p>
									<div class="col-sm-8">
										<div class="demo-radio-button">
											<input name="status" type="radio" id="belum_menikah" class="with-gap" value="B" <?php if($data_pasien->status=='B') echo 'checked' ?>  />
				                            <label for="belum_menikah">Belum Menikah</label>
				                            <input name="status" type="radio" id="menikah" class="with-gap" value="K" <?php if($data_pasien->status=='K') echo 'checked' ?> />
				                            <label for="menikah">Sudah Menikah</label>  
				                            <input name="status" type="radio" id="cerai" class="with-gap" value="C" <?php if($data_pasien->status=='C') echo 'checked' ?> />
				                            <label for="cerai">Cerai</label>           		
										</div>
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
									<div class="col-sm-8">
									<div class="form-inline">
										<!-- <input name="goldarah" type="radio"  id="nonegd"  class="with-gap" value="" checked/>
										<label for="nonegd">NONE</label> -->
										<input name="goldarah" type="radio"  id="A+"  class="with-gap" value="A+" <?php if($data_pasien->goldarah=='A+') echo 'checked';?>/>
										<label for="A+">A+</label>
										<input name="goldarah" type="radio"  id="A-"  class="with-gap" value="A-" <?php if($data_pasien->goldarah=='A-') echo 'checked';?>/>
										<label for="A-" style="margin-left:15px;">A-</label>
										<input name="goldarah" type="radio"  id="B+"  class="with-gap" value="B+" <?php if($data_pasien->goldarah=='B+') echo 'checked';?>/>
										<label for="B+" style="margin-left:15px;">B+</label>
										<input name="goldarah" type="radio"  id="B-"  class="with-gap" value="B-" <?php if($data_pasien->goldarah=='B-') echo 'checked';?>/>
										<label for="B-" style="margin-left:15px;">B-</label>
										<input name="goldarah" type="radio"  id="AB+"  class="with-gap" value="AB+" <?php if($data_pasien->goldarah=='AB+') echo 'checked';?>/>
										<label for="AB+" style="margin-left:15px;">AB+</label>
										<input name="goldarah" type="radio"  id="AB-"  class="with-gap" value="AB-" <?php if($data_pasien->goldarah=='AB-') echo 'checked';?>/>
										<label for="AB-" style="margin-left:15px;">AB-</label>
										<input name="goldarah" type="radio"  id="O+"  class="with-gap" value="O+" <?php if($data_pasien->goldarah=='O+') echo 'checked';?>/>
										<label for="O+" style="margin-left:15px;">O+</label>
										<input name="goldarah" type="radio"  id="O-"  class="with-gap" value="O-" <?php if($data_pasien->goldarah=='O-') echo 'checked';?>/>
										<label for="O-" style="margin-left:15px;">O-</label>
									</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="wnegara">Kewarganegaraan *</label>
									<div class="col-sm-8">
										<div class="form-inline">
											<input name="wnegara" type="radio"  id="WNI"  class="with-gap" value="WNI" checked <?php if($data_pasien->wnegara=='WNI') echo 'checked';?>  />
											<label for="WNI">WNI</label>
											<input name="wnegara" type="radio"  id="WNA"  class="with-gap" value="WNA" <?php if($data_pasien->wnegara=='WNA') echo 'checked';?>/>
											<label for="WNA"  style="margin-left:20px;">WNA</label>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="wnegara">Bahasa Sehari Hari *</label>
									<div class="col-sm-8">
										<div class="form-inline">
											<input name="bahasa" onClick="validateBahasa()" type="radio"  id="WNI-bahasa"  class="with-gap" value="INDONESIA" <?= $data_pasien->bahasa == "INDONESIA"?'checked':'' ?>  />
											<label for="WNI-bahasa">INDONESIA</label>
											<input name="bahasa" onClick="validateBahasa()" type="radio"  id="WNA-bahasa"  class="with-gap" value="Daerah" <?= $data_pasien->bahasa == "Daerah"?'checked':'' ?> />
											<label for="WNA-bahasa"  style="margin-left:20px;">Daerah</label>
											<input name="bahasa" onClick="validateBahasa()" type="radio"  id="lainnya"  class="with-gap" <?= $data_pasien->bahasa != "INDONESIA" && $data_pasien->bahasa != "Daerah"?'checked':'' ?> />
											<label for="lainnya" value="<?= $data_pasien->bahasa != "INDONESIA" && $data_pasien->bahasa != "Daerah"?'checked':'' ?>" style="margin-left:20px;margin-right:20px;">Lainnya</label>
											<input type="text" name="bahasa2" id="bahasalainnya" value="<?= $data_pasien->bahasa != "INDONESIA" && $data_pasien->bahasa != "Daerah"?$data_pasien->bahasa:'' ?>">
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3  control-label col-form-label" id="sukubangsa" style="margin-bottom:0px;margin-top:0px;!important">Sukubangsa</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="suku_bangsa" class="form-control" style="width: 100%" name="suku_bangsa" onkeyup="this.value = this.value.toUpperCase()">
													<option value="">-- Pilih Sukubangsa --</option>
													<?php 
													foreach($master_sukubangsa as $row){
														echo '<option value="'.strtoupper($row->nm_sukubangsa).'"  >'.strtoupper($row->nm_sukubangsa).'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="alamat">Alamat *</label>
									<div class="col-sm-8">
										<textarea class="form-control" name="alamat" id="alamats" rows="4" onkeyup="this.value = this.value.toUpperCase()"  ><?= $data_pasien->alamat ?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="alamat"></label>
									<div class="form-group row col-sm-8">
										<div class="col-sm-2">
											<input class="form-control" name="rt" id="rt" type="number" placeholder="RT" min="1" value="<?= $data_pasien->rt ?>">
											
										</div>
										<div class="col-sm-1">
											<input type="hidden" class="form-control" value="/" disabled>
										</div>
										<div class="col-sm-2">
											<input class="form-control" name="rw" id="rw" type="number" placeholder="RW" min="1" <?= $data_pasien->rw ?>>
											
										</div>
											<!-- <input class="form-control" name="rw" type="text"> -->
										
									</div>
									
								</div>

								<!-- ADDED ALAMAT YANG BISA DIHUBUNGI  -->
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="alamat">Alamat Yang Bisa Dihubungi *</label>
									<div class="col-sm-8">
										<textarea class="form-control" name="alamat2" id="alamat2"  rows="4" onkeyup="this.value = this.value.toUpperCase()"  ><?= $data_pasien->alamat2 ?></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="alamat"></label>
									<div class="form-group row col-sm-8">
										<div class="col-sm-2">
											<input class="form-control" name="rt_alamat2" id="rt2" type="number" placeholder="RT" min="1" value="<?= $data_pasien->rt_alamat2 ?>"  >
											
										</div>
										<div class="col-sm-1">
											<input type="hidden" class="form-control" value="/" disabled>
										</div>
										<div class="col-sm-2">
											<input class="form-control" name="rw_alamat2" id="rw2" type="number" placeholder="RW" min="1" value="<?= $data_pasien->rw_alamat2 ?>"  >
											
										</div>

										<div class="col-sm-2">
											<button type="button" class="btn btn-primary" id="btn_alamat" onClick="validateAlamat()">Alamat Sama</button>
										</div>
											
										
									</div>
									
								</div>

								
								<!-- END OF ADDED -->
								<div class="form-group row">
								<label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah *</label>
								<div class="col-sm-8">
									<div class="form-inline">
									   <!-- <select name="load_wilayah" class="form-control load_wilayah" style="width:500px"> -->
									    <select name="load_wilayah" class="form-control load_wilayah" style="width:500px"  >
											<?php if ($data_pasien->kelurahandesa != '') { ?>
												<option value="<?php echo $data_pasien->id_provinsi . '@' . $data_pasien->id_kotakabupaten . '@' . $data_pasien->id_kecamatan . '@' . $data_pasien->id_kelurahandesa; ?>" selected><?php echo $data_pasien->kelurahandesa . ', ' . $data_pasien->kecamatan . ', ' . $data_pasien->kotakabupaten . ', ' . $data_pasien->provinsi; ?></option>
									 		<?php } ?>
									    </select>
										
									</div>
								</div>
							</div>	
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="kodepos">Kode Pos *</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->kodepos;?>" name="kodepos"  >
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
									<div class="col-sm-8">
									<div class="form-inline">
											<!-- <input name="pendidikan" type="radio"  id="nonep"  class="with-gap" value="" checked/>
											<label for="nonep" >NONE</label> -->
											<input name="pendidikan" type="radio"  id="S1/DIV"  class="with-gap" value="S1/DIV" <?php if($data_pasien->pendidikan=='S1/DIV') echo 'checked';?>  />
											<label for="S1/DIV" >S1/DIV</label>
											<input name="pendidikan" type="radio"  id="DIII"  class="with-gap" value="DIII" <?php if($data_pasien->pendidikan=='DIII') echo 'checked';?>/>
											<label for="DIII" style="margin-left:15px;">DIII</label>
											<input name="pendidikan" type="radio"  id="SMA"  class="with-gap" value="SMA" <?php if($data_pasien->pendidikan=='SMA') echo 'checked';?>/>
											<label for="SMA" style="margin-left:15px;">SMA</label>
											<input name="pendidikan" type="radio"  id="SLTP"  class="with-gap" value="SLTP" <?php if($data_pasien->pendidikan=='SLTP') echo 'checked';?>/>
											<label for="SLTP" style="margin-left:15px;">SLTP</label>
											<input name="pendidikan" type="radio"  id="SD"  class="with-gap" value="SD" <?php if($data_pasien->pendidikan=='SD') echo 'checked';?>/>
											<label for="SD" style="margin-left:15px;">SD</label>
											<input name="pendidikan" type="radio"  id="Belum/Tdk Sekolah"  class="with-gap" value="Belum/Tdk Sekolah" <?php if($data_pasien->pendidikan=='Belum/Tdk Sekolah') echo 'checked';?>/>
											<label for="Belum/Tdk Sekolah" style="margin-left:15px;">Belum/Tdk Sekolah</label>
											
									</div>
									</div>
								</div>

					
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
									<div class="col-sm-8">
										<div class="form-inline">
											<?php foreach($pekerjaan as $row) { ?>
												<input name="pekerjaan" type="radio" onClick="validatePekerjaan()" id="<?= $row->pekerjaan ?>"  class="with-gap" value="<?= $row->pekerjaan ?>" <?php if($data_pasien->pekerjaan==$row->pekerjaan) echo 'checked';?>  />
												<label for="<?= $row->pekerjaan ?>" ><?= $row->pekerjaan ?></label>
											<?php } ?>
										</div>
										<input type="text" name="pekerjaan2" id="pekerjaan_lainnya" value="<?= $data_pasien->pekerjaan != "PNS/Pol/TNI" && $data_pasien->pekerjaan != "Dagang"?$data_pasien->pekerjaan:'' ?>">
									</div>
								</div>
								<!-- <div class="form-group row">
									<p class="col-sm-3 form-control-label">Jabatan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php //echo $data_pasien->jabatan;?>" name="jabatan">
									</div>
								</div> -->
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_telp;?>" maxlength="12" name="no_telp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_hp">o. HP</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_hp;?>" name="no_hp">
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" value="<?php echo $data_pasien->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor"  >
									</div>
								</div>		

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" for="nama_ayah">Nama Ayah</label>
									<div class="col-sm-4">
										<input type="text" id="nama_ayah" class="form-control" name="nama_ayah" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off" value="<?= $data_pasien->nama_ayah ?>"  >
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" for="nama_ibu">Nama Ibu</label>
									<div class="col-sm-4">
										<input type="text" id="nama_ibu" class="form-control" name="nama_ibu" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off" value="<?= $data_pasien->nama_ibu ?>"  >
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="label_nama_suami_istri" for="nama_suami_istri">Nama Suami / Istri</label>
									<div class="col-sm-4">
										<input type="text" id="nama_suami_istri" class="form-control" name="nama_suami_istri" onkeyup="this.value = this.value.toUpperCase()" autocomplete="off" value="<?= $data_pasien->suami_istri ?>"  >
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label"  for="signature">TTD Saat Ini</label>
									<div class="col-sm-4">
									
										<?php
										if($data_pasien->ttd_pasien){
										?>
										<img width="120px" src="<?php echo $data_pasien->ttd_pasien ?>" alt="" srcset="">
										<?php }else{?>
											<br><br>
											<?php }?> 
									
									</div>
								</div>	
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label"  for="signature">TTD Pasien</label>
									<div class="col-sm-4">
										<canvas class="canvas"  ></canvas>
									
									</div>
								</div>						
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">		
										<input type="hidden" id="signatureValue" name="ttd_pasien">

										<button type="reset" class="btn btn-danger" id="btn-submit"><i class="fa fa-eraser"></i> Reset</button>
										<button type="submit" class="btn btn-primary" id="btn-form-biodata-insert"><i clcass="fa fa-floppy-o"></i>Simpan</button>
										<!-- <button type="submit" class="btn btn-primary" ><i clcass="fa fa-floppy-o"></i>Simpan</button> -->
									</div>
								</div>						
							</form>
						</div>			
			</div>
		

			<div id="daftar_ulang" class="tab-pane active" role="tabpanel">					
					<div class="col-lg-10" style="margin: 0 auto;">
						<br>
						<button class="btn btn-info" data-toggle="modal" data-target="#detailModal" data-id="<?php echo $no_medrec?>">Obat Terakhir</button>
						<br><br>
							<?php echo form_open('irj/rjcregistrasi/insert_daftar_ulang', array('class' => 'form-horizontal')); ?>
							<!-- <input type="hidden" value="<?php echo $data_pasien->no_kartu;?>" name="no_kartu"> -->
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="jns_kunj">Jenis Kunjungan</label>
									<div class="col-sm-8">
										<div class="form-inline control-label pull-left">
												<input type="hidden" class="form-control" value="<?php echo $online;?>" name="online" readonly>
												<?php
													if($online==1){
												?>
													<input type="hidden" class="form-control" value="<?php echo $id_online;?>" name="id_online" readonly>
												<?php
													}
												?>
												<input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_medrec">
												<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
												<?php echo ($jns_kunjungan == "LAMA" ? 
												
													'
													<input type="radio" name="jns_kunj" class="jns_kunj" value="LAMA" checked><label for="lbl_lama">Lama</label>&nbsp;
													&nbsp;&nbsp;&nbsp;
													<input type="radio" name="jns_kunj" class="jns_kunj" value="BARU"><label for="lbl_lama">Baru</label>&nbsp;
									
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												:
												
													'
													<input type="radio" name="jns_kunj" class="jns_kunj" value="LAMA"><label for="lbl_lama">Lama</label>&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="radio" name="jns_kunj" class="jns_kunj" value="BARU" checked><label for="lbl_lama">Baru</label>&nbsp;
													
													<input type="hidden" name="jns_kunj" value="'.$jns_kunjungan.'">
													'
												);
												?>

										</div>
									</div>
								</div>
								<?php
									if($online==1){
								?>
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Tgl. Kunjungan</label>
									<div class="col-sm-8">
										<div class="input-group">
											<input type="date" class="form-control date_pickers" name="tgl_kunjungan" id="tgl_kunjungan" >
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										</div>
									</div>
								</div>								
								<?php
									 } else {
								?>															
								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Tgl. Kunjungan</label>
									<div class="col-sm-8">
											<input type="date" class="form-control" name="tgl_kunjungan" value="<?php echo date('Y-m-d');?>" disabled>
									</div>
								</div>
								<?php
									}
								?>

								<!-- <div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Penyetor</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<input type="text" name="atas_nama" id="atas_nama" class="form-control" style="width: 100%">
										</div>
									</div>
								</div>								 -->

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Cara Bayar *</label>
									<div class="col-sm-8">
										<div class="form-inline">
											<!-- <select id="cara_bayar" class="custom-select form-control" style="width: 100%" name="cara_bayar" onchange="pilih_cara_bayar(this.value)"  >
												<option value="">-- Pilih Cara Bayar --</option>
												<?php
												//foreach($cara_bayar as $row){
													//echo '<option value="'.$row->cara_bayar.'">'.$row->cara_bayar.'</option>';
												//}
												?> 
											</select>		 -->

																						
												<input type="radio" id="umum" name="cara_bayar" value="UMUM">
												<label for="umum">Umum</label>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="bpjs" name="cara_bayar" value="BPJS">
												<label for="bpjs">BPJS</label>&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="radio" id="kerjasama" name="cara_bayar" value="KERJASAMA">
												<label for="kerjasama">Kerja Sama</label>
										
										</div>
									</div>
								</div>
					<!-- 			
                               <div class="form-group" id="input_kontraktor">
									<p class="col-sm-2 control-label" id="lbl_input_kontraktor">Dijamin Oleh</p>
									<div class="col-sm-5">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-Pilih Penjamin-</option>
													
												</select>
										</div>
									</div>
								</div> -->

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label">Cara Kunjungan *</label>
									<div class="col-sm-8">
												

												<input type="radio" id="datang_sendiri" name="cara_kunj" value="DATANG SENDIRI"  >
												<label for="datang_sendiri">Datang Sendiri</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

												<input type="radio" id="dikirim_dokter" name="cara_kunj" value="DIKIRIM DOKTER">
												<label for="dikirim_dokter">Dikirim Dokter</label>&nbsp;&nbsp;&nbsp;<br>

												<!-- <input type="radio" id="rujukan_poli" name="cara_kunj" value="RUJUKAN POLI">
												<label for="rujukan_poli">Rujukan Poli</label>&nbsp;&nbsp;&nbsp; -->

												<input type="radio" id="rujukan_puskesmas" name="cara_kunj" value="RUJUKAN PUSKESMAS">
												<label for="rujukan_puskesmas">Rujukan Puskesmas</label>&nbsp;&nbsp;&nbsp;

												<input type="radio" id="rujukan_rs" name="cara_kunj" value="RUJUKAN RS">
												<label for="rujukan_rs">Rujukan RS</label>
									</div>
								</div>

								<div class="form-group row">
									<label for="" class="col-sm-3 control-label col-form-label">Kekhususan :</label>
									<div class="col-sm-8">
										<div class="input-group">
											<div class="demo-radio-button mt-1">
												<input name="kekhususan" onClick="validateKekhususan()" type="radio" id="cacat_1" class="with-gap" value="KERETA DORONG" />
												<label for="cacat_1">KERETA DORONG</label>
												<input name="kekhususan" onClick="validateKekhususan()" type="radio" id="cacat_2" class="with-gap" value="KURSI DORONG" />
												<label for="cacat_2">KURSI DORONG</label>
												<input name="kekhususan" onClick="validateKekhususan()" type="radio" id="cacat_3" class="with-gap" />
												<label for="cacat_3">LAINNYA</label> 
												<input type="text" name="kekhususan_lainnya" id="kekhususan_lainnya">
											</div>
										</div>
									</div>
								</div>

                               

								<input type="hidden" name="jenis_faskes" id="jenis_faskes">
								<div class="form-group row div_bpjs">
									<label class="col-sm-3 control-label col-form-label">No. Kartu BPJS</label>
									<div class="col-sm-8">
										<div class="input-group">
	                                        <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?php echo isset($data_pasien->no_kartu)?$data_pasien->no_kartu:null; ?>">
	                                        <span class="input-group-btn">
	                          					<button class="btn btn-info" type="button" id="btn-bpjs-daful"><i class="fa fa-eye"></i> Data Peserta</button>
	                        				</span>
	                        				<span class="input-group-btn">
	                          					<button type="button" class="btn waves-effect waves-light btn-danger" id="btn-rujukan-kartu"><i class="fa fa-eye"></i> Data Rujukan</button>
	                        				</span>
	                                    </div>	
                                    </div>
								</div>

								<div class="form-group row" id="input_kontraktor">
									<label class="col-sm-3 control-label col-form-label" id="lbl_input_kontraktor">Dijamin Oleh</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="id_kontraktor" class="form-control select2" style="width: 100%" name="id_kontraktor">
													<option value="">-- Pilih Penjamin --</option>	
												</select>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-3  control-label col-form-label" id="dirujuk_ke" style="margin-bottom:0px;margin-top:0px;!important">Tujuan Poliklinik *</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="id_poli" class="form-control select2" style="width: 100%" name="id_poli"  onchange="ajaxdokter(this.value)"  >
													<option value="">-- Pilih Nama Poli --</option>
													<?php 
													foreach($poli as $row){
														echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'">'.$row->nm_poli.'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>
								<div id="div_rujukan">
									<hr>	
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">No. Rujukan</label>
										<div class="col-sm-8">
											<div class="input-group">
		                                        <input type="text" class="form-control" name="no_rujukan" id="no_rujukan" onchange="cek_no_rujukan(this.value)" onkeyup="cek_no_rujukan(this.value)">
		                                        <span class="input-group-btn">
		                          					<button class="btn waves-effect waves-light btn-danger" type="button" id="btn-rujukan"><i class="fa fa-eye"></i> Lihat Rujukan</button>
		                        				</span>
		                                    </div>	
	                                    </div>								
									</div>	
									<div class="form-group row" id='no_surat_kontrol_skdp'>
										<label class="col-sm-3 control-label col-form-label">No.Surat Kontrol/SKDP * <img src="<?php echo site_url('assets/images/question_mark24.png'); ?>" style="cursor:default;vertical-align:middle;margin-top: -1px;margin-right: 5px;" data-container="body" data-html="true" data-toggle="tooltip" data-animation="true" data-placement="right" title="Nomor Surat Kontrol, Surat Rujukan Internal atau Surat Rujukan Rawat Inap. Harus 6 Characters"></label>
	                                    <div class="col-sm-8">
		                                    <input type="text" class="form-control" name="nosurat_skdp_sep" id="nosurat_skdp_sep1" >
		                                    <input type="hidden" class="form-control" name="nosurat_skdp_sep1" id="nosurat_skdp_sep"  >
	                                    </div>								
									</div>	
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label">DPJP Pemberi Surat SKDP *</label>
										<div class="col-sm-8">
											<!-- <div class="input-group">
					                            <input type="text" class="form-control" name="dpjp_skdp_sep" id="dpjp_skdp_sep">
					                            <span class="input-group-btn">
					                                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-search-kode"><i class="fa fa-search"></i> Cari DPJP</button>
					                            </span>
					                        </div>  -->
											<div class="input-group">
												<div class="form-inline" style="width:100%;">
													<select id="dpjp_skdp_sep" class="form-control select2" style="width: 100%" name="dpjp_skdp_sep"  onchange="dokterChange(event)">
														<option value="">-- Pilih Dokter --</option>
														
													</select>
												</div>
												<span class="input-group-btn">
					                                <button class="btn btn-info" type="button" data-toggle="modal" data-target="#modal-search-kode"><i class="fa fa-search"></i> Cari DPJP</button>
					                            </span>
											</div>
										</div>							
									</div>	
									<hr>	
								</div>							
								
								<div class="form-group row" id="div_katarak">
									<div class="offset-sm-3 col-sm-8">
										<div class="demo-checkbox">
											<input type="checkbox" class="filled-in" name="katarak" value="1" id="katarak">
		                                    <label for="katarak">Katarak</label>
	                                	</div>									
	                                	<span class="help-block" style="font-size: 14px;">Centang Katarak <i class="fa fa-check"></i>, Jika Peserta Tersebut Mendapatkan Surat Perintah Operasi katarak</span>	
									</div>
								</div>	
								<div id="ird">
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label" id="alber">Alasan Berobat</label>
											<div class="col-sm-8">
											<select class="form-control" name="alber" id="alasan_berobat" onchange="pilih_alber(this.value)"  >
												<option value="sakit">Sakit</option>
												<option value="kecelakaan">Kecelakaan</option>
												<option value="lahir">Melahirkan</option>
											</select></div>
									</div>
									
									<div class="form-group row">
										<label class="col-sm-3 control-label col-form-label" id="pasdatDg">Datang dengan</label>
										<div class="col-sm-8"><select class="form-control" name="pasdatDg"  >
											<option value="klg">Keluarga</option>
											<option value="ttg">Tetangga</option>
											<option value="lain">Lain-lain</option>
										</select></div>
									</div>								
									<div id="input_kecelakaan">
										<div class="form-group row">
											<label class="col-sm-3 control-label col-form-label" id="Kclkaan">Kecelakaan</label>
											<div class="col-sm-8">
												<select  class="form-control select2" name="jenis_kecelakaan" id="jenis_kecelakaan" style="width:100%;">
															<option value="">-- Pilih Jenis Kecelakaan --</option>
															<?php
															foreach($kecelakaan as $row){
																echo '<option value="'.$row->id.'">'.$row->nm_kecelakaan.'</option>';
															}
															?>
														</select>
												<input type="text" class="form-control m-t-10" placeholder="Lokasi Kecelakaan" name="lokasi_kecelakaan" >
											</div>
										</div>
										<div class="form-group row kll_bpjs">
											<label class="col-sm-3 control-label col-form-label">Penjamin KLL *</label>
											<div class="col-sm-9">
												<div class="demo-checkbox">
				                                    <input class="filled-in" type="checkbox" name="kll_penjamin[]" value="1" id="jasa_raharja">
													<label for="jasa_raharja">Jasa Raharja</label>

													<input class="filled-in" type="checkbox" name="kll_penjamin[]" value="2" id="bpjs_tk">
													<label for="jasa_raharja">BPJS Ketenagakerjaan</label>

													<input class="filled-in" type="checkbox" name="kll_penjamin[]" value="3" id="taspen">
													<label for="jasa_raharja">TASPEN</label>

													<input class="filled-in" type="checkbox" name="kll_penjamin[]" value="4" id="asabri">
													<label for="jasa_raharja">ASABRI PT</label>
				                                </div> 											
											</div>
										</div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label">Tgl. Kejadian</label>
			                                <div class="col-md-8">
			                                	<div class="input-group">
													<input type="date" class="form-control" name="kll_tgl_kejadian" id="kll_tgl_kejadian" value="<?php echo date('Y-m-d'); ?>" maxlength="10">
													<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label">Lokasi Kejadian</label>
			                                <div class="col-sm-8">
			                                    <select class="form-control" name="kll_provinsi" id="kll_provinsi" style="width: 100%"></select>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label"></label>
			                                <div class="col-sm-8">
			                                    <select class="form-control" name="kll_kabupaten" id="kll_kabupaten"></select>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label"></label>
			                                <div class="col-sm-8">
			                                    <select class="form-control" name="kll_kecamatan" id="kll_kecamatan"></select>
			                                </div>
			                            </div>
			                            <div class="form-group row kll_bpjs">
			                                <label class="col-sm-3 control-label col-form-label">Keterangan Kejadian</label>
			                                <div class="col-md-8">
			                                    <textarea class="form-control" name="kll_ketkejadian" id="kll_ketkejadian" cols="30" rows="5" style="resize:vertical" placeholder="ketik keterangan kejadian"></textarea>
			                                </div>
			                            </div>
		                            </div>	
								</div>
								<div class="form-group row" id="hubungan">
									<label class="col-sm-3 control-label col-form-label">Hubungan</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select class="form-control" style="width: 100%" name="hubungan">
													<option value="">-- Pilih Hubungan --</option>
													<option value="Ybs.">Ybs.</option>
													<option value="Ortu">Orang Tua</option>
													<option value="Istri">Istri</option>
													<option value="Suami">Suami</option>
													<option value="Anak">Anak</option>
												</select>
										</div>
									</div>
								</div>

								<div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="dokter">Dokter</label>
									<div class="col-sm-8">
										<div class="form-inline">
												<select id="id_dokter" class="form-control select2" style="width: 100%" name="id_dokter"  >
													<option value="">-- Pilih Dokter --</option>
													<?php 
													foreach($dokter as $row){
														echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
													}
													?>
												</select>
										</div>
									</div>
								</div>
								
								<div class="form-group row" id="input_diagnosa">
									<label class="col-sm-3 control-label col-form-label" id="lbl_input_diagnosa">Diagnosa</label>
									<div class="col-sm-8">		
										<select class="form-control autocomplete_diagnosa" name="diagnosa" id="diagnosa" style="width: 100%;"></select>								
										<!-- <input type="text" class="form-control input-sm "  name="diagnosa" id="diagnosa"> -->
  										<input type="hidden" class="form-control" name="id_diagnosa" id="id_diagnosa">
									</div>
								</div>
								<input type="hidden" name="kode_faskes_perujuk" id="kode_faskes_perujuk">
								<input type="hidden" name="nama_faskes_perujuk" id="nama_faskes_perujuk">
								<div class="form-group row">								
									<label class="col-sm-3 control-label col-form-label">Kelas Rawat</label>
									<div class="col-sm-6">
										<div class="form-inline">

												<input type="radio" id="none_class" name="kelas_pasien" value="NK">
												<label for="NK">None Class</label>
												<input type="radio" id="eksekutif" name="kelas_pasien" value="EKSEKUTIF">
												<label for="VVIP">Eksekutif</label>

												<!-- <select class="form-control" style="width: 100%" id="kelas_pasien" name="kelas_pasien"  > -->
													<!--<option value="">-Pilih Kelas-</option>-->
													<!-- <option value="III">III</option> -->
													<!--<?php 
													/*foreach($kelas as $row){
														$string = "";
														if($row->kelas == "III") $string = "SELECTED"; 

														echo '<option value="'.$row->kelas.'" '.$string.'>'.$row->kelas.'</option>';
													}*/
													?>-->
												<!-- </select>												 -->
										</div>
									
									</div>
								</div>
								<!-- <div class="form-group row">
									<label class="col-sm-3 control-label col-form-label" id="catatan">Catatan</label>
									<div class="col-sm-8">
									<textarea class="form-control" name="entri_catatan" id="entri_catatan" cols="30" rows="5" style="resize:vertical"></textarea>
									</div>
								</div>									 -->
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
										<div echo 'masuk sono';die();class="demo-checkbox">
		                                    <input type="checkbox" class="filled-in" value="1" name="cetak_kartu" id="check_cetak_kartu" <?php if($jns_kunjungan == "BARU") echo 'checked ';?>  />
		                                    <label for="check_cetak_kartu">Cetak Kartu</label>
	                                	</div>										
										<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cetak_kartu1" id="cetak_kartu1">
									</div>
								</div>	
								<!-- <div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
									<div class="demo-checkbox">
						
                                    <input type="checkbox" class="filled-in" value="1" name="extra" id="cek_extra"  />
                                    <label for="cek_extra">Tanpa Biaya awal *)</label>
                                		</div>										
									</div>
								</div>
								<p>*) Hanya untuk pasien yang tidak terkena biaya seperti Buka Jahitan</p> -->
								<!-- <input type="hidden" value="" id="kode_provider" name="kode_provider">							
								<input type="hidden" class="form-control" value="<?php echo $data_pasien->no_nrp;?>" name="hidden_nrpdaful" id="hidden_nrpdaful" > -->
								<div class="form-group row">
									<div class="offset-sm-3 col-sm-8">
								<button type="reset" class="btn waves-effect waves-light btn-danger"><i class="fa fa-eraser"></i> Reset</button>
								<button type="submit" class="btn btn-primary" id="button_cetak_karcis" onClick="validasiSubmit()"><i class="fa fa-floppy-o"></i> Simpan</button>
									</div>
								</div>
							<?php echo form_close();
							?>
							</div>
						</div>												
			</div><!--- end col -->
                        </div>

<!-- <div class="container-fluid" style="width:97%;margin:0 auto">	
	<div class="row">
		
				
		
		</div>
	</div> -->
<!--- Modal Web Service -->
<!-- <div class="modal fade" id="data_webservice" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Data</h4>
      </div>
      <div class="modal-body">
			<div id="data_anggota"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>	 -->
<!--- Modal -->
<!-- <div class="modal fade" id="modal_validasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Hasil Validasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
			<div id="data_validasi"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>	 -->

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_keluarga_anggota">
      	<div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Data Keluarga/Kerabat</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
              		<div class="col-md-12">
                  	<div class="table-responsive" id="div_table_keluarga">
							<table id="table_keluarga" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
		                        <thead>
									<tr>
										<th>No</th>
										<th>No. RM</th>
										<th>Hubungan</th>
										<th>Nama</th>
										<th>Alamat</th>
										<th>Telepon</th>
										<th>Pekerjaan</th>
										<!-- <th class="text-center">Aksi</th> -->
									</tr>
		                        </thead>
								<tbody>							
								</tbody>
                    		</table>
					</div> <!-- table-responsive -->						
					</div>									                          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
          </div>
          <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
  	</div> 
  	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_keluarga">
      	<div class="modal-dialog modal-lg">
          <div class="modal-content">
          		<form id="form_input_keluarga">
              <div class="modal-header">
                  <h4 class="modal-title" id="title_modal">Data Keluarga/Kerabat</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
              	<input type="hidden" name="no_cm_pasien" value="<?php echo $data_pasien->no_cm; ?>">
              		<div class="col-md-12">
              			<div class="form-group row">
						  <label class="col-sm-2 col-form-label">NIK</label>
						  <div class="col-sm-7">
						    <input class="form-control" type="text" name="keluarga_nik" id="keluarga_nik">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Nama</label>
						  <div class="col-sm-7">
						    <input class="form-control" type="text" name="keluarga_nama" id="keluarga_nama">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Hubungan</label>
						  <div class="col-sm-7">
						    <input class="form-control" type="text" name="keluarga_hubungan" id="keluarga_hubungan">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">NRP / NIP</label>
						  <div class="col-sm-5">
						    <input class="form-control" type="text" name="keluarga_nrp" id="keluarga_nrp">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Tgl Lahir</label>
						  <div class="col-sm-4">
						    <input class="form-control date_picker" type="text" name="keluarga_tgl_lahir" id="keluarga_tgl_lahir">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Alamat</label>
						  <div class="col-sm-8">
						    <textarea class="form-control" rows="5" name="keluarga_alamat" id="keluarga_alamat"></textarea>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">No. Telp</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_telp"  id="keluarga_telp">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Agama</label>
						  <div class="col-sm-6">
						    <select class="form-control" style="width: 100%" name="keluarga_agama" id="keluarga_agama">
								<option value="">-- Pilih Agama --</option>
								<option value="ISLAM">Islam</option>
								<option value="KATOLIK">Katolik</option>
								<option value="PROTESTAN">Protestan</option>
								<option value="BUDHA">Budha</option>
								<option value="HINDU">Hindu</option>
							</select>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Pendidikan</label>
						  <div class="col-sm-6">						    
							<select class="form-control select2" style="width: 100%" name="keluarga_pendidikan" id="keluarga_pendidikan">
								<option value="">-- Pilih Pendidikan Terakhir --</option>
								<option value="S3">S3 / Subspesialis</option>
								<option value="S2">S2 / Spesialis</option>
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
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Pekerjaan</label>
						  <div class="col-sm-6">
						    <select class="form-control select2" style="width: 100%" name="keluarga_pekerjaan" id="keluarga_pekerjaan">
								<option value="">-- Pilih Pekerjaan --</option>
								<?php foreach($pekerjaan as $row){
										echo '<option value="'.$row->pekerjaan.'">'.$row->pekerjaan.'</option>';
									}
								?>										
							</select>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Pangkat / Golongan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_pangkat" id="keluarga_pangkat">
						  </div>echo 'masuk sono';die();
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Alamat Kantor</label>
						  <div class="col-sm-8">
						    <textarea class="form-control" rows="5" name="keluarga_alamat_kantor" id="keluarga_alamat_kantor"></textarea>
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">No. Telp Kantor</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_telp_kantor" id="keluarga_telp_kantor">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Jabatan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_jabatan" id="keluarga_jabatan">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Kesatuan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_kesatuan" id="keluarga_kesatuan">
						  </div>
						</div>
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">Alamat Kesatuan</label>
						  <div class="col-sm-8">
						    <textarea class="form-control" rows="5" name="keluarga_alamat_kesatuan" id="keluarga_alamat_kesatuan"></textarea>
						  </div>
						</div>	
						<div class="form-group row">
						  <label class="col-sm-2 col-form-label">No. Telp Kesatuan</label>
						  <div class="col-sm-6">
						    <input class="form-control" type="text" name="keluarga_telp_kesatuan" id="keluarga_telp_kesatuan">
						  </div>
						</div>	
					</div>									                          
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-keluarga" onclick="save_keluarga()"><i class="fa fa-floppy-o"></i> Simpan</button>
              </div>
              </form>  
          </div>
          <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
  	</div> 
  	<div class="modal fade modal_norujukan" tabindex="-1" role="dialog" aria-hidden="true">
	  	<div class="modal-dialog modal-lg">
	      	<div class="modal-content">
	          	<div class="modal-header text-center">
	              	<img class="pull-left" src="<?php echo site_url('assets/images/logos/logo_bpjs.png'); ?>" width="120"></img>
	              	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          	</div>
	          	<div class="modal-body">
		  			<h4 class="text-center" style="font-weight: 600;">DATA RUJUKAN</h4>
		            <div class="table-responsive" style="clear: both;margin-top: 25px;">
						<table class="table-xs table-hover" width="100%">
						  <tbody>
						  	<tr>
								<td style="width: 25%;">No. Rujukan</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_nomor"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Tanggal Rujukan</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_tgl"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Faskes Perujuk</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_faskes"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Poli</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_poli"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Nama</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_nama"></td>
							</tr>
							<tr>
								<td style="width: 25%;">No. Kartu BPJS</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_noka"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Diagnosa</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_diagnosa"></td>
							</tr>
							<tr>
								<td style="width: 25%;">Jenis Kelamin</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_gender"></td>
							</tr>						
							<tr>
								<td style="width: 25%;">Jenis Rawat</td>
								<td style="width: 3%;">:</td>
								<td id="rujukan_jenis_rawat"></td>
							</tr>								
						  </tbody>
						</table>					
					</div>
		        </div>
		      	<div class="modal-footer">
		      		<button type="button" class="btn btn-primary waves-effect text-left" data-dismiss="modal" onclick="terapkan_data_rujukan()"><i class="fa fa-check"></i> Gunakan Rujukan</button>
		          	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
		      	</div>
	    	</div>    	
	  	</div>  	
	</div>	
	<div class="modal fade modal_nobpjs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
	              	<button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
	          	</div>
	      	</div>
	      	<!-- /.modal-content -->
	  	</div>
	</div>	
	<div id="modal-search-kode" class="modal modal-search-kode fade" role="dialog" aria-labelledby="modal-search-kode" aria-hidden="true">
	  <div class="modal-dialog modal-lg modal-success">
	      <div class="modal-content">
	          <div class="modal-header">
	              <h4 class="modal-title" id="modal-search-kode">Cari Kode DPJP (BPJS)</h4>
	              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	          </div>
	          <div class="modal-body">
	              <div class="row">
	                <div class="col-sm-12">
	                  <div class="form-group row">
	                    <div class="col-sm-3">
	                      <select  class="form-control" style="width: 100%" name="jns_pelayanan" id="jns_pelayanan">
	                        <option value="2" selected="">R. Jalan</option>
	                        <option value="1">R. Inap</option>
	                      </select>
	                    </div>
	                    <div class="col-sm-6">
	                      <select  class="form-control" style="width: 100%" name="spesialis" id="spesialis" >
	                        <option value="NONE">-- Pilih Poli --</option>
	                        <?php                   
	                          foreach($poli as $row) {
	                            if ($row->poli_bpjs != '' || $row->poli_bpjs != null) {
	                              echo '<option value="'.$row->poli_bpjs.'">'.$row->poli_bpjs.'</option>';  
	                            }                                
	                          }
	                        ?>
	                      </select>
	                    </div>
	                    <div class="col-sm-3">
	                      <button class="btn btn-danger btn-block" type="button" id="btn-cari-dpjp"><i class="fa fa-search"></i> Cari</button>
	                    </div>
	                  </div>
	                </div>
	                <div class="col-sm-12">
	                  	<div class="form-group row">
		                    <div class="col-sm-12">
		                      	<div class="input-group">
		                      		<span class="input-group-btn">
		                                <button class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
		                            </span>
		                            <input type="text" class="form-control" id="search_dpjp" onkeyup="search_dpjp()" placeholder="Ketikan Nama Dokter DPJP..">
		                        </div> 
		                    </div>
	                  	</div>
	                </div>
	                <div class="col-sm-12">
	                  	<div class="table-wrapper-scroll-y">
				            <table width="100%" class="table table-bordered table-condensed" id="table-dpjp">
				                <thead>
				                  <tr>
				                    <th class="text-center" width="22%"><b>Kode DPJP</b></th>
				                    <th class="text-center" width="63%"><b>Nama Dokter</b></th>
				                    <th class="text-center" width="15%"><b>Aksi</b></th>
				                  </tr>
				                </thead>
				                <tbody>
				                </tbody>
				            </table>
			            </div>
	                </div>
	              </div>
	          </div>
	          <div class="modal-footer">
	              <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
	          </div>
	      </div>
	      <!-- /.modal-content -->
	  </div>
	  <!-- /.modal-dialog -->
	</div>

	<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Obat</h4>
            </div>
            <div class="modal-body">
                <div class="modal-body table-responsive m-t-0">
                    <table id="tableDetail" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th align="center">Nama Obat</th>
                            <th align="center">Satuan</th>
                            <th align="center">Qty</th>
                            <th align="center">Signa</th>
                        </tr>
                        </thead>
                        <tbody>
                    </table><br/>
                    <div align="right" id="total_rekap"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
	<script>

		$(document).on("click", "input[name='bahasa']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				$('#noneb').prop('checked', true);
				document.getElementById("bahasalainnya").disabled = true;
			} else { 
				// thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		});
		var canvas = document.querySelector("canvas");
		var signaturePad = new SignaturePad(canvas);

		
			
			

			function validateKekhususan() {
				if (document.getElementById("cacat_3").checked == true) {
					document.getElementById("kekhususan_lainnya").disabled = false;
				}else{
					document.getElementById("kekhususan_lainnya").value='' ; 
					document.getElementById("kekhususan_lainnya").disabled = true;
				}
			}

			if (document.getElementById("cacat_3").checked == true) {
				document.getElementById("kekhususan_lainnya").disabled = false;
			}else{
				document.getElementById("kekhususan_lainnya").value='' ; 
				document.getElementById("kekhususan_lainnya").disabled = true;
			}



//unchecked cara bayar
		$(document).on("click", "input[name='cara_bayar']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
				$(".div_bpjs").hide(); 
				$("#div_rujukan").hide();
				$("#input_kontraktor").hide();
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		})

//unchecked cara kunjungan  
		$(document).on("click", "input[name='cara_kunj']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		})
//unchecked kekhususan
		$(document).on("click", "input[name='kekhususan']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
				document.getElementById("kekhususan_lainnya").disabled = true;
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		})
//unchecked sex
		$(document).on("click", "input[name='sex']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
				document.getElementById("kekhususan_lainnya").disabled = true;
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		})
//unchecked status
		$(document).on("click", "input[name='status']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
				document.getElementById("kekhususan_lainnya").disabled = true;
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		});

		function validateBahasa() {
				if (document.getElementById("lainnya").checked == true) {
					document.getElementById("bahasalainnya").disabled = false;
				}
				else{
					document.getElementById("bahasalainnya").value='' ; 
					document.getElementById("bahasalainnya").disabled = true;
				}
			}

			if (document.getElementById("lainnya").checked == true) {
					document.getElementById("bahasalainnya").disabled = false;
				}
				else{
					document.getElementById("bahasalainnya").value='' ; 
					document.getElementById("bahasalainnya").disabled = true;
				}

				function validatePekerjaan() {
				if (document.getElementById("Lainnya").checked == true) {
					document.getElementById("pekerjaan_lainnya").disabled = false;
				}else{
					document.getElementById("pekerjaan_lainnya").value='' ; 
					document.getElementById("pekerjaan_lainnya").disabled = true;
				}
			}

			if (document.getElementById("Lainnya").checked == true) {
				document.getElementById("pekerjaan_lainnya").disabled = false;
			}else{
				document.getElementById("pekerjaan_lainnya").value='' ; 
				document.getElementById("pekerjaan_lainnya").disabled = true;
			}

			
			function validateAlamat() {
			var alamat = document.getElementById("alamats").value;			
			var rt = document.getElementById("rt").value;
			var rw = document.getElementById("rw").value;
				document.getElementById("alamat2").value = alamat;
				document.getElementById("rt2").value = rt;
				document.getElementById("rw2").value = rw;
			}
		

			


	// validate bahasa sehari hari 
	


	</script>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 