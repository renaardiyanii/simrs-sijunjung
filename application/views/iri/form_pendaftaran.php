<?php  if ($role_id == 1) {
            $this->load->view("layout/header_left");
       } else {
            $this->load->view("layout/header_left");
} ?>
<?php $this->load->view("iri/layout/all_page_js_req"); ?>
<style type="text/css">
	.table-wrapper-scroll-y {
		display: block;
		max-height: 350px;
		overflow-y: auto;
		-ms-overflow-style: -ms-autohiding-scrollbar;
	}
	label {
	    font-weight: 600;
	}
	textarea {
		resize: vertical;
	}
	.modal {
		overflow-y:auto;
	}
	#modal-search-kode .modal-header {
		color: #887056;
		border-bottom:1px solid #ddd;
		background-color: #eae4ce;
		-webkit-border-top-left-radius: 5px;
		-webkit-border-top-right-radius: 5px;
		-moz-border-radius-topleft: 5px;
		-moz-border-radius-topright: 5px;
		border-top-left-radius: 5px;
		border-top-right-radius: 5px;
	}
	#modal-search-kode .modal-footer {
		color: #887056;
		border-top: 1px solid #ddd;
		background-color: #eae4ce;
		-webkit-border-bottom-left-radius: 5px;
		-webkit-border-bottom-right-radius: 5px;
		-moz-border-radius-bottomleft: 5px;
		-moz-border-radius-bottomright: 5px;
		border-bottom-left-radius: 5px;
		border-bottom-right-radius: 5px;
	}
</style>
<script type='text/javascript'>
$(document).ready(function(){
	// $("#asal_rujukan").prop('disabled',true);
	// $("#ppk_asal_rujukan").prop('disabled',true);
	$('#div_rujukan').hide();
	$('#loading-rujukan').hide();
	$('.js-example-basic-single').select2();

	if ($('#barulahir').prop('checked')==true) {
		$('#input_regibu').show();
	} else {
		$('#input_regibu').hide();
	}

	$('#barulahir').change(function() {
	  if($(this).prop('checked')==true){
	  	$('#input_regibu').show();
	  }else{
	  	$('#input_regibu').hide();
	  }
	});

	$(document).on("click",".select-kode-dpjp",function() {
	    $("#dpjp_skdp_sep").val($(this).data('kodedpjp'));
	    $('#modal-search-kode').modal('hide');
	});	
	$(document).on("click","#btn-cari-dpjp",function() {
	    var button = $(this);
	    button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');     
		$.ajax({
			type: "POST",
			url: "<?php echo site_url('bpjs/referensi/dokter_dpjp/1/none'); ?>",
			dataType: "JSON",
			success: function(result) { 
				$('#modal-search-kode').modal('show');
			    $('#table-dpjp > tbody').empty();
			    button.html('<i class="fa fa-search"></i> Cari Kode');
			    if (result != '' || result != null) {
			      if (result.metaData.code == '200') {
			        $.each(result.response.list, function(i, item) {
			          $('#table-dpjp > tbody:last-child').append(
			            '<tr>'
			            +'<td class="text-center">'+item.kode+'</td>'
			            +'<td class="text-center">'+item.nama+'</td>'
			            +'<td class="text-center"><button class="btn btn-danger select-kode-dpjp" data-kodedpjp="'+item.kode+'"><i class="fa fa-check"></i> Pilih</button></td>'
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
				button.html('<i class="fa fa-search"></i> Cari Kode');
				swal("Error",formatErrorMessage(event, errorThrown), "error");                   
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}
		});
	});
	$(document).on("click","#btn-cek-kartu",function() {
		var button = $(this);
		var no_bpjs = $("#no_bpjs").val();
		button.html('<i class="fa fa-spinner fa-spin" ></i> Loading...');
		if (no_bpjs == '') {
	    	button.html('Cek Kartu BPJS');
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
		        		button.html('Cek Kartu BPJS');
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
		        			swal("Gagal Cek Kartu BPJS.",result.metaData.message, "error");
		        		}	              	
		        	} else {
		        		button.html('Cek Kartu BPJS');
		              	swal("Error","Gagal Cek Kartu BPJS.", "error");  
		        	}
		        },
		        error:function(event, textStatus, errorThrown) { 
		        	button.html('Cek Kartu BPJS');
		            swal("Error","Gagal Cek Kartu BPJS.", "error");                   
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }
		    });
	    }
    });

	
	//untuk nampilin form bpjs ato engga di awal
	var kls_bpjs = "<?php echo $kls_bpjs;?>";
		//alert(kls_bpjs);
		if(kls_bpjs!='' || kls_bpjs!=null){
			$('#jatahkls').val(kls_bpjs).change();
		}
	var cara_bayar = "<?php echo $data_pasien[0]['cara_bayar'] ;?>";
	if (cara_bayar == "BPJS"){
		$('.form_bpjs').show();
		$('#div_rujukan').show();
		$('.form_perusahaan').hide();
		document.getElementById("nmkontraktorbpjs").required= false;
		document.getElementById("no_bpjs").required= true;
		
	} else if(cara_bayar == "KERJASAMA"){
		$('.form_bpjs').hide();
		$('#div_rujukan').hide();	
		$('.form_perusahaan').show();
		document.getElementById("nmkontraktorbpjs").required= false;
		document.getElementById("no_bpjs").required= false;
	} else {
		$('.form_bpjs').hide();
		$('#div_rujukan').hide();		
		$('.form_perusahaan').hide();
		document.getElementById("nmkontraktorbpjs").required= false;
		document.getElementById("no_bpjs").required= false;
	}

});


function save(){
	var cara_bayar = "<?php echo $data_pasien[0]['cara_bayar'] ;?>";
	var id_poli = "<?php echo $data_pasien[0]['id_poli'] ;?>";
	if(cara_bayar == "BPJS"){
		var nmkontraktorbpjs = document.getElementById("nmkontraktorbpjs").value;
		var no_bpjs = document.getElementById("no_bpjs").value;
		var id_dokter = document.getElementById("id_dokter").value;
		var ruang = document.getElementById("ruang").value;
		var ppk_asal_rujukan = $('#ppk_asal_rujukan').val();

		if(id_dokter=='') {
			swal("Dokter Kosong","Silahkan Input Dokter Terlebih Dahulu.", "warning"); 
			document.getElementById("id_dokter").focus();
		} else if(no_bpjs=='') {
			swal("No. BPJS Kosong","No. BPJS Tidak Boleh Kosong.", "warning"); 
			document.getElementById("no_bpjs").focus();
		} else if(nmkontraktorbpjs=='') {
			swal("Penjamin Kosong","Silahkan Pilih Penjamin.", "warning");  
			document.getElementById("nmkontraktorbpjs").focus();
		} else if(ruang=='') {
			swal("Ruangan Kosong","Silahkan Pilih Ruangan.", "warning");  
			document.getElementById("ruang").focus();
		} else if (id_poli != 'BA00' && ppk_asal_rujukan == null) {
			swal("PPK Rujukan Kosong","Silahkan Pilih PPK Asal Rujukan.", "warning");  
		} else{
			swal({
			  	title: "Tambah Data",
			  	text: "Benar Akan Menyimpan Data?",
			  	type: "info",
			  	showCancelButton: true,
			  	closeOnConfirm: false,
			  	showLoaderOnConfirm: true,
			},
			function(){
				$.ajax({
					url:"<?php echo base_url('iri/ricpendaftaran/insert_pendaftaran')?>",
			        type: "POST",
			        data: $('#formInsertPasien').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {
			        	if(data.status) //if success close modal and reload ajax table
			            {
			            	if(data.ket=="1") //if success close modal and reload ajax table
				            {
				            	window.open("<?php echo site_url(); ?>"+data.nex, "_blank");window.focus()
				            	window.location.href = "<?php echo site_url('iri/ricdaftar'); ?>";
				            }else if(data.ket=="2"){
				            	alert('Pendaftaran Pasien Gagal. Pasien sudah dirawat diruangan.');
				            }
			            }
			            document.getElementById("submit").disabled = true;
						document.getElementById("submit").innerHTML = 'Mohon Tunggu ...';

			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			         	// window.location.reload();
			         	alert(errorThrown);
		        	}
		    	});
			});
		}
	}else if(cara_bayar == "KERJASAMA"){
		var nmkontraktorbpj = document.getElementById("nmkontraktorbpjs").value;
		var id_dokter = document.getElementById("id_dokter").value;
		var ruang = document.getElementById("ruang").value;
		if(id_dokter==''){
			alert('Dokter Belum di Input');
			document.getElementById("id_dokter").focus();
		}else if(nmkontraktorbpjs ==''){
			alert('Kontraktor Belum di Input');
			document.getElementById("nmkontraktorbpjs").focus();
		}else if(ruang==''){
			alert('Ruangan Belum di Input');
			document.getElementById("ruang").focus();
		}else{
			swal({
			  	title: "Tambah Data",
			  	text: "Benar Akan Menyimpan Data?",
			  	type: "info",
			  	showCancelButton: true,
			  	closeOnConfirm: false,
			  	showLoaderOnConfirm: true,
			},
			function(){
				$.ajax({
					url:"<?php echo base_url('iri/ricpendaftaran/insert_pendaftaran')?>",
			        type: "POST",
			        data: $('#formInsertPasien').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {
			        	if(data.status) //if success close modal and reload ajax table
			            {
			            	if(data.ket=="1") //if success close modal and reload ajax table
				            {
				            	window.open("<?php echo site_url(); ?>"+data.nex, "_blank");window.focus()
				            	window.location.href = "<?php echo site_url('iri/ricdaftar'); ?>";
				            }else if(data.ket=="2"){
				            	alert('Pendaftaran Pasien Gagal. Pasien sudah dirawat diruangan.');
				            }
			            }
			        document.getElementById("submit").disabled = true;
					document.getElementById("submit").innerHTML = 'Mohon Tunggu ...';
			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			         	// window.location.reload();
			         	alert(errorThrown);
		        	}
		    	});
			});
		}
	}else{
		var id_dokter = document.getElementById("id_dokter").value;
		var ruang = document.getElementById("ruang").value;
		if(id_dokter==''){
			alert('Dokter Belum di Input');
			document.getElementById("id_dokter").focus();
		}else if(ruang==''){
			alert('Ruangan Belum di Input');
			document.getElementById("ruang").focus();
		}else{
			swal({
			  	title: "Tambah Data",
			  	text: "Benar Akan Menyimpan Data?",
			  	type: "info",
			  	showCancelButton: true,
			  	closeOnConfirm: false,
			  	showLoaderOnConfirm: true,
			},
			function(){
				$.ajax({
					url:"<?php echo base_url('iri/ricpendaftaran/insert_pendaftaran')?>",
			        type: "POST",
			        data: $('#formInsertPasien').serialize(),
			        dataType: "JSON",
			        success: function(data)
			        {
			        	if(data.status) //if success close modal and reload ajax table
			            {
			            	if(data.ket=="1") //if success close modal and reload ajax table
				            {
				            	window.open("<?php echo site_url(); ?>"+data.nex, "_blank");window.focus()
				            	window.location.href = "<?php echo site_url('iri/ricdaftar'); ?>";
				            }else if(data.ket=="2"){
				            	alert('Pendaftaran Pasien Gagal. Pasien sudah dirawat diruangan.');
				            }
			            }
			        document.getElementById("submit").disabled = true;
					document.getElementById("submit").innerHTML = 'Mohon Tunggu ...';
			        },
			        error: function (jqXHR, textStatus, errorThrown)
			        {
			         	// window.location.reload();
			         	alert(errorThrown);
		        	}
		    	});
			});
		}
	}
}

$(function(){
<?php if($data_pasien[0]['sex']=='L'){ ?>
	$('#laki_laki').attr('selected', 'selected');
	$('#perempuan').removeAttr('selected', 'selected');
<?php }else{ ?>
	$('#laki_laki').removeAttr('selected', 'selected');
	$('#perempuan').attr('selected', 'selected');
<?php } ?>
});

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_ruang').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_ruang',
		onSelect: function (suggestion) {
			$('#ruang').val(''+suggestion.idrg);
			$('#nm_ruang').val(''+suggestion.nmruang);
			$('#kelas').val(''+suggestion.kelas);
		}
	});
});

function get_bed(val){
	$('#bed')
        .find('option')
        .remove()
        .end()
    ;
    $("#bed").append("<option value=''>Loading...</option>");
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricmutasi/get_empty_bed_select/",
        data:   {
                    val        : val
                },
    }).done(function(msg) {
    	$('#bed')
            .find('option')
            .remove()
            .end()
        ;
        $("#bed").append(msg);
    });
}

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_register_dokter').autocomplete({
		serviceUrl: site+'/iri/ricpendaftaran/data_dokter_autocomp',
		onSelect: function (suggestion) {
			$('#id_dokter').val(''+suggestion.id_dokter);
			$('#nmdokter').val(''+suggestion.nm_dokter);
		}
	});
});

// buat pendaftaran ibu
var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_no_ipd_pasien').autocomplete({
		// serviceUrl: site+'/iri/ricreservasi/data_pasien_irj',
		serviceUrl: site+'/iri/ricpasien/data_pasien_auto',
		onSelect: function (suggestion) {
			$('#ipdnama').val(''+suggestion.no_ipd+' - '+suggestion.nama);
			$('#noipdibu').val(''+suggestion.no_ipd);
		}
	});
});

function cek_kartu_bpjs(){
	var no_bpjs = $('#no_bpjs').val();
	$.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>iri/ricstatus/cek_kartu_bpjs/",
        data:   {
                    no_bpjs        : no_bpjs
                },
    }).done(function(msg) {
    	if(msg == ""){
    		document.getElementById("data_validasi").innerHTML = "Data Tidak Ditemukan";
    	}else{
    		document.getElementById("data_validasi").innerHTML = msg;
    	}
    	$('#modal_validasi').modal('show');
    });
}

// function ambil_sep(){
// 	var no_bpjs = $('#no_bpjs').val();
// 	var nosjp = $('#nosjp').val();
// 	var diagnosa_id = $('#diagnosa_id').val();
// 	var no_cm_hidden = $('#no_cm_hidden').val();
// 	var noregasal_hidden = $('#noregasal_hidden').val();
// 	var ruang = $('#ruang').val();
// 	var ppk = $('#ppk').val();
// 	$.ajax({
//         type: "POST",
//         url: "<?php echo base_url(); ?>iri/ricstatus/ambil_sep/",
//         data:   {
//                     no_bpjs        : no_bpjs,
//                     noregasal_hidden        : noregasal_hidden,
//                     ruang        : ruang,
//                     nosjp        : nosjp,
//                     diagnosa_id  : diagnosa_id,
//                     no_cm        : no_cm_hidden,
//                     ppk          : ppk
//                 },
//     }).done(function(msg) {
//     	obj = JSON.parse(msg);
//     	if(obj.status == 0){
//     		alert(obj.response);
//     	}else{
//     	  	$('#no_sep').val(obj.response);
// 			$('#no_sep_hidden').val(obj.response);
//     	}
//     });
// }

var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			//$('#no_cm').val(''+suggestion.no_cm);
			$('#diagnosa').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
			$('#diagnosa_id').val(''+suggestion.id_icd);
			// $('#nama').val(''+suggestion.nama);
			// $('.tanggal_lahir').val(''+suggestion.tanggal_lahir);
			// if(suggestion.jenis_kelamin=='L'){
			// 	$('#laki_laki').attr('selected', 'selected');
			// 	$('#perempuan').removeAttr('selected', 'selected');
			// }else{
			// 	$('#laki_laki').removeAttr('selected', 'selected');
			// 	$('#perempuan').attr('selected', 'selected');
			// }
			// $('#telp').val(''+suggestion.telp);
			// $('#hp').val(''+suggestion.hp);
			// $('#id_poli').val(''+suggestion.id_poli);
			// $('#poliasal').val(''+suggestion.poliasal);
			// $('#id_dokter').val(''+suggestion.id_dokter);
			// $('#dokter').val(''+suggestion.dokter);
			// $('#diagnosa').val(''+suggestion.diagnosa);
		}
	});
});

function update_form_bpjs(cara_bayar){

	if(cara_bayar == "BPJS"){
		$('.form_bpjs').show();
		$('#div_rujukan').show();	
		$('.form_perusahaan').hide();
		 //nmkontraktorbpjs
		document.getElementById("nmkontraktorbpjs").required= true;
		document.getElementById("no_bpjs").required= true;
	}else if(cara_bayar == "KERJASAMA"){
		$('.form_bpjs').hide();
		$('#div_rujukan').hide();	
		$('.form_perusahaan').show();
		document.getElementById("nmkontraktorbpjs").required= true;
		document.getElementById("no_bpjs").required= false;
	}else{
		$('#div_rujukan').hide();	
		$('.form_bpjs').hide();
		$('.form_perusahaan').hide();
		document.getElementById("nmkontraktorbpjs").required= false;
		document.getElementById("no_bpjs").required= false;
	}
}
var ajaxku;
function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
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
</script>
<div>
	<div>
		
		<!-- Keterangan page -->
		<section class="content-header">
			<h2 class="card-title">PENDAFTARAN RAWAT INAP</h2>			
		</section>
		<!-- /Keterangan page -->

        <!-- Main content -->
        <section class="content">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $this->session->flashdata('pesan');?>
					<?php echo $this->session->flashdata('notification');?>
					<div class="card card-outline-info">
						<div class="card-header">
                        		<h5 class="m-b-0 text-white text-center">Form Pendaftaran</h5>
                        	</div>
						<br/>

						<!-- Modal Validasi -->
						<div class="modal fade" id="modal_validasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        <h4 class="modal-title" id="myModalLabel">Hasil Validasi</h4>
						      </div>
						      <div class="modal-body">
									<div id="data_validasi"></div>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
						      </div>
						    </div>
						  </div>
						</div>	
						<!-- Modal -->

						<!-- Form Pendaftaran -->
						<form action="#" id="formInsertPasien" class="formInsertPasien">
						<!-- <form class="formInsertPasien" action="javascript:;" method="post" id="formInsertPasien"> -->
							<div class="card-block">
								<div class="row">
									<div class="col-sm-6">
										<div class="">
											<div class="form-group row">
												<label class="col-md-3 col-form-label">No. Register Asal</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="noregasal" value="<?php echo $irna_reservasi[0]['no_register_asal']; ?>" readonly>
													<input type="hidden" value="<?php echo $irna_reservasi[0]['no_register_asal']; ?>" id="noregasal_hidden">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-3 col-form-label">No. RM</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="no_cm" value="<?php echo $irna_reservasi[0]['no_cm']; ?>" readonly>
													<input type="hidden" name="no_cm_hidden" value="<?php echo $irna_reservasi[0]['no_medrec']; ?>" id="no_cm_hidden">
												</div>
											</div>
											
											<div class="form-group row">
												<label class="col-md-3 col-form-label">Tgl. Daftar</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="tgldaftarri" value="<?php echo date('Y-m-d H:i:s',strtotime($irna_reservasi[0]['tglreserv'])); ?>" readonly>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Cara Bayar</label>
												<div class="col-sm-9">
													<!-- <input type="text" class="form-control input-sm" name="carabayar"> -->
													<select class="form-control input-sm" name="carabayar" onchange="update_form_bpjs(this.value)" id="cara_bayar">
														<?php
														foreach ($cara_bayar as $r) { 
															if($r['cara_bayar'] == $data_pasien[0]['cara_bayar']){ ?>
															<option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
															<?php
															}else{ ?>
															<option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>
															<?php
															}
														?>
														<?php
														}
														?>
													</select>
												</div>
											</div>										
											<!-- <div class="form-group row">
												<label class="col-sm-3 col-form-label">Cara Datang</label>
												<div class="col-sm-9">
													<select class="form-control input-sm" id="id_smf" name="id_smf" >
														<?php
															foreach ($smf as $r) { ?>
														<option value="<?php echo $r['cara_kunj'];?>" ><?php echo $r['cara_kunj'];?></option>
														<?php															
														}?>
													</select>
												</div>
											</div> -->
											<!-- <div class="form-group">
												<label class="col-sm-3 col-form-label">Cara Masuk</div>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="caramasuk">
												</div>
											</div> -->
										<div class="form-group row">
												<label class="col-sm-3 col-form-label">Dokter PJP</label>
												<div class="col-sm-9">
													<input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien[0]['id_dokter'])){echo $data_pasien[0]['id_dokter'];}?>">
													
													<input type="text" class="form-control input-sm auto_no_register_dokter" id="nmdokter" name="nmdokter" value="<?php if(isset($data_pasien[0]['nm_dokter'])){echo $data_pasien[0]['nm_dokter'];}?>" required>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Diagnosa</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" value="<?php echo $irna_reservasi[0]['diagnosa'];?> - <?php echo $irna_reservasi[0]['nm_diagnosa'];?>" ><div id="loading_diagnosa"></div>

													<input type="hidden" name="diagnosa_id" id="diagnosa_id" value="<?php echo $irna_reservasi[0]['diagnosa'];?>" >
												</div>
											</div>
											<div class="form-group row">
												<div class="offset-sm-3 col-sm-8">
													<div class="demo-checkbox">
														<input type="checkbox" class="filled-in" name="katarak" value="1" id="katarak">
					                                    <label for="katarak">Katarak</label>
				                                	</div>									
				                                	<span class="help-block" style="font-size: 13px;">Centang Katarak <i class="fa fa-check"></i>, Jika Peserta Tersebut Mendapatkan Surat Perintah Operasi katarak</span>	
												</div>
											</div>	
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Catatan Ringkasan</label>
												<div class="col-sm-9">
													<textarea class="form-control" name="catatan_ring" id="catatan_ring" rows="5"></textarea>
												</div>
											</div>

										</div>
									</div>
									<div class="col-sm-6 form-right">
										<div class="box-body">
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">No. Reg. Lama</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" name="noipdlama" value="<?php echo $irna_reservasi[0]['noreservasi']; ?>">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Nama</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" disabled="true" name="nama_disp" value="<?php echo $data_pasien[0]['nama']; ?>" >
													<input type="hidden" name="nama" value="<?php echo $data_pasien[0]['nama']; ?>" >
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Tgl. Lahir</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm" id="calendar-tgl-lahir" name="tgllahirri" value="<?php echo date('d-m-Y',strtotime($data_pasien[0]['tgl_lahir'])); ?>" disabled="true">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Jenis Kelamin <?php echo $data_pasien[0]['sex']; ?></label>
												<div class="col-sm-4">
													<select class="form-control input-sm" name="sex" disabled="true">
														<option id="laki_laki" value="L">Laki-Laki</option>
														<option id="perempuan" value="P">Perempuan</option>
													</select>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-3 col-form-label">Gol. Darah</label>
												<div class="col-sm-4">
													<select class="form-control input-sm" name="goldarah">
														<option value="A">A</option>
														<option value="B">B</option>
														<option value="O">O</option>
														<option value="AB">AB</option>
													</select>
												</div>
												<div class="col-sm-5">
													<div class="demo-checkbox">	
														<input type="checkbox" class="filled-in" value="Y" name="barulahir" id="barulahir" />
	                                    				<label for="barulahir">Bayi Baru Lahir</label>
													</div>
												</div>
											</div>
											<div class="form-group row" id="input_regibu">
												<label class="col-sm-3 col-form-label">No. Register Ibu</label>
												<div class="col-sm-9">
													<input type="text" class="form-control input-sm auto_no_ipd_pasien" name="ipdnama" id="ipdnama">
													<input type="hidden" name="noipdibu" id="noipdibu">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<!-- Tabs -->
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs customtab" role="tablist">
									<li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab" role="tab">Biodata</a></li>
									<li class="nav-item"><a class="nav-link" href="#penanggung-jawab" data-toggle="tab" role="tab">Penanggung Jawab</a></li>
									<li class="nav-item"><a class="nav-link" href="#ruangan" data-toggle="tab" role="tab">Ruangan</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="biodata">
										<div class="row">
											<div class="col-sm-6">
												<div class="card-block">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Alamat</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="alamatri" value="<?php echo $data_pasien[0]['alamat']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Kelurahan</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="kelurahanri" value="<?php echo $data_pasien[0]['kelurahandesa']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Kecamatan</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="kecamatanri" value="<?php echo $data_pasien[0]['kecamatan']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">RT/RW</label>
															<div class="col-sm-3">
																<input type="text" class="form-control input-sm" name="rtri" value="<?php echo $data_pasien[0]['rt']; ?>" >
															</div>
															<div class="col-sm-3">
																<input type="text" class="form-control input-sm" name="rwri" value="<?php echo $data_pasien[0]['rw']; ?>" >
															</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Daerah</label>
															<div class="col-sm-3">
																<input type="text" class="form-control input-sm" name="id_daerah">
															</div>
															<div class="col-sm-6">
																<input type="text" class="form-control input-sm" name="nmdaerah">
															</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">No. Telp</label>
														<div class="col-sm-3">
															<input type="text" class="form-control" name="notelp" value="<?php echo $data_pasien[0]['no_telp']; ?>" >
														</div>
														<label class="col-sm-2 col-form-label">No. HP</label>
														<div class="col-sm-4">
															<input type="text" class="form-control" name="nohp" value="<?php echo $data_pasien[0]['no_hp']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Status</label>
														<div class="col-sm-3">
															<input type="text" class="form-control input-sm" name="statusri" value="<?php echo $data_pasien[0]['status']; ?>" >
														</div>
														<label class="col-sm-2 col-form-label">Agama</label>
														<div class="col-sm-4">
															<input type="text" class="form-control input-sm" name="agamari" value="<?php echo $data_pasien[0]['agama']; ?>" >
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="card-block">
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Pendidikan</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="pendidikanri" value="<?php echo $data_pasien[0]['pendidikan']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Pekerjaan</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="pekerjaanri" value="<?php echo $data_pasien[0]['pekerjaan']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Warga Negara</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="wnegarari" value="<?php echo $data_pasien[0]['wnegara']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Suku Bangsa</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="sukubangsari" value="<?php echo $data_pasien[0]['sukubangsa']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Bahasa</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="bahasari" value="<?php echo $data_pasien[0]['bahasa']; ?>">
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Nama Ibu/Istri</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="nm_ibu_istri" value="<?php echo $data_pasien[0]['nm_ibu_istri']; ?>" >
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Nama Ayah/Suami</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" name="nm_ayah_suami" value="<?php echo $data_pasien[0]['nm_ayah_suami']; ?>" >
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="penanggung-jawab" role="tabpanel">
									<div class="p-20">
										<div class="row">
											<div class="col-sm-6">
												<div class="card card-block">
													<div class="card-header">
														<h5 class="m-b-0 text-white text-center">Penjamin</h5>
													</div>
													<br/>
													<div class="card-body">
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">Dijamin Oleh</label>
															<div class="col-sm-9">
																<input type="hidden" name="id_kontraktor_bpjs">
																<select class="form-control js-example-basic-single" style="width:100%" name="nmkontraktorbpjs" id="nmkontraktorbpjs">
																	<option value="">-- Pilih Penjamin -- </option>
																	<?php
																	foreach ($kontraktorbpjs as $r) { ?>
																	<option value="<?php echo $r['id_kontraktor'] ;?>"><?php echo $r['nmkontraktor'] ;?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">No. Kartu BPJS</label>
															<div class="col-sm-9">
																<div class="input-group">
							                                        <input type="text" class="form-control" name="no_bpjs" id="no_bpjs" value="<?php echo $data_pasien[0]['no_kartu']; ?>" readonly>
							                                        <span class="input-group-btn">
							                          					<button class="btn btn-info" type="button" id="btn-cek-kartu"><i class="fa fa-eye"></i> Data Peserta</button>
							                        				</span>
							                                    </div>	
															</div>
														</div>
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">Asal Rujukan</label>
															<div class="col-sm-9">
																<select id="asal_rujukan" class="form-control" style="width: 100%" name="asal_rujukan" disabled>
																	<option value="1">Faskes Tingkat 1</option>
																	<option value="2" selected>Faskes Tingkat 2</option>
																</select>
															</div>
														</div>
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">PPK Asal Rujukan</label>
															<div class="col-sm-9">
																<select class="form-control" style="width:100%" name="ppk_asal_rujukan" id="ppk_asal_rujukan" disabled>
																	<option value="1671342" selected>RS. Musi Medika Cendikia</option>
																</select>
															</div>
														</div>
														<div class="form-group form_bpjs row">									
															<label class="col-sm-3 control-label col-form-label">Tgl. Rujukan</label>
															<div class="col-sm-9">
																<div class="input-group">
																	<input type="text" class="form-control date_picker" id="tgl_rujukan" name="tgl_rujukan" value="<?php echo date('Y-m-d'); ?>">
																	<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																</div>
															</div>
														</div>
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">No. Rujukan</label>
															<div class="col-sm-9">
   																<input type="text" class="form-control" name="no_rujukan" value="<?php echo $data_pasien[0]['no_rujukan']; ?>" id="no_rujukan">
															</div>
														</div>
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">No. SPRI *</label>
															<div class="col-sm-9">
																<input type="text" class="form-control" name="nosurat_skdp_sep" value="<?php echo $nosurat_skdp; ?>">
															</div>
														</div>
														<div class="form-group form_bpjs row">
															<label class="col-sm-3 col-form-label">DPJP Pemberi SPRI *</label>
															<div class="col-sm-9">
																<div class="input-group">
										                            <input type="text" class="form-control" name="dpjp_skdp_sep" id="dpjp_skdp_sep">
										                            <span class="input-group-btn">
										                                <button class="btn btn-info" type="button" id="btn-cari-dpjp"><i class="fa fa-search"></i> Cari DPJP</button>
										                            </span>
										                        </div>  
															</div>
														</div>
														<div class="form-group form_perusahaan row">
															<label class="col-sm-3 col-form-label">Kontraktor</label>
															<div class="col-sm-9">
																<input type="hidden" name="id_kontraktor_bpjs">
																<select class="form-control js-example-basic-single" style="width:100%" name="nmkontraktorbpjs" id="nmkontraktorbpjs">
																	<option value="">Pilih Kontraktor</option>
																	<?php
																	foreach ($kontraktor as $r) { ?>
																	<option value="<?php echo $r['id_kontraktor'] ;?>"><?php echo $r['nmkontraktor'] ;?></option>
																	<?php
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Catatan SEP</label>
															<div class="col-sm-9">
																<textarea class="form-control" name="catatan" id="catatan" rows="5"><?php echo $data_pasien[0]['catatan']; ?></textarea>
															</div>
														</div>
														<div class="form-group form_perusahaan row">
															<label class="col-sm-3 col-form-label">P/I/S/A</label>
															<div class="col-sm-9">
																<select class="form-control input-sm" name="ketpembayarri">
																	<option value="Ybs">Ybs</option>
																	<option value="Istri">Istri</option>
																	<option value="Suami">Suami</option>
																	<option value="Anak">Anak</option>
																</select>
															</div>
														</div>
														<div class="form-group form_perusahaan row">
															<label class="col-sm-3 col-form-label">Nama Peserta</label>
															<div class="col-sm-9">
																<input type="text" class="form-control input-sm" name="nmpembayarri">
															</div>
														</div>
														<div class="form-group form_perusahaan row">
															<label class="col-sm-3 col-form-label">Golongan</label>
															<div class="col-sm-9">
																<input type="text" class="form-control input-sm" name="golpembayarri">
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="card card-block">
													<div class="box-header with-border">
														<h3 class="box-title">Keluarga</h3>
													</div>
													<div class="box-body">
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Nama</label>
															<div class="col-sm-9">
																<input type="text" class="form-control input-sm" name="nmpjawabri">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Alamat</label>
															<div class="col-sm-9">
																<input type="text" class="form-control input-sm" name="alamatpjawabri">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">No.Telp / HP</label>
															<div class="col-sm-9">
																<input type="text" class="form-control input-sm" name="notlppjawab">
															</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Kartu Identitas</label>
																<div class="col-sm-4">
																	<select class="form-control" name="kartuidp">
																		<option value="KTP">KTP</option>
																		<option value="SIM">SIM</option>
																		<option value="PASPOR">PASPOR</option>
																		<option value="KTM">KTM</option>
																		<option value="NIK">NIK</option>
																	</select>
																</div>
																<div class="col-sm-5"><input type="text" class="form-control" name="noidpjawab">
																</div>
														</div>
														<div class="form-group row">
															<label class="col-sm-3 col-form-label">Hub.Keluarga</label>
															<div class="col-sm-6">
																<select class="form-control" name="hubjawabri">
																	<option value="Suami">Suami</option>
																	<option value="Istri">Istri</option>
																	<option value="Ayah">Ayah</option>
																	<option value="Ibu">Ibu</option>
																	<option value="Saudara">Saudara</option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										</div>
									</div>
									<div class="tab-pane" id="ruangan" role="tabpanel">
										<div class="row">
											<div class="col-sm-8">
												<div class="card-block">
													<!-- <div class="form-group">
														<label class="col-sm-3 col-form-label">Bed</div>
														<div class="col-sm-9">
														<select class="form-control input-sm" name="bed">
															<?php
															foreach ($empty_bed as $r) { ?>
															<option value="<?php echo $r['bed'] ;?>"><?php echo $r['bed'] ;?></option>
															<?php
															}
															?>
														</select>
														</div>
													</div> -->
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Ruang Pilih *</label>
														<div class="col-sm-9">
															<span class="label-form-validation"></span>
															<!-- <select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																<?php
																if(empty($empty_bed)){ ?>
																<option value="" selected="true" Kelas yang dipesan penuh silahkan reservasi ulang</option>
																<?php
																} else{
																	foreach ($kelas as $r) { 
																		if($irna_reservasi[0]['kelas'] == $r['kelas'] && $irna_reservasi[0]['idrg'] == $r['idrg']){ 
																			$status_kelas = 1;
																		?>
																<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>" selected="true"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
																	<?php
																	}else{ ?>
																	<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
																	<?php
																	}
																	}
																?>
																<?php
																}
																?>
															</select> -->
															<?php 
																if(empty($kelas)){
															?>
																<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																	<option value="" selected="true">Semua Kelas Penuh</option>
																</select>
															<?php
																} else { 
																	if(empty($status_bed)){ 
															?>
																	<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																	 	<option value="" selected="true">-- Kelas yang dipesan penuh silahkan pilih kelas lain --</option>
															<?php
																		foreach ($kelas as $r) { 
															?>
																		<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
																			
																		}
															?>
																	</select> 
															<?php
																	} else {
															?>
																		<select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
															<?php
																		foreach ($kelas as $r) { 
																			if($irna_reservasi[0]['kelas'] == $r['kelas'] && $irna_reservasi[0]['idrg'] == $r['idrg']){ 
															?>
																				<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>" selected="true"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
															<?php
																			} else {
															?>
																		<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>

															<?php
																			}
																		}
																	}
																}
															?>
																	</select>

															<!-- <select class="form-control input-sm" id="ruang" name="ruang" onchange="get_bed(this.value)" required>
																<?php
																$status_kelas = 0;
																if(empty($kelas)){ 
																?>
																	<option value="" selected="true">Semua Kelas Penuh</option>
																<?php
																}else{
																	foreach ($kelas as $r) { 
																		if($irna_reservasi[0]['kelas'] == $r['kelas'] && $irna_reservasi[0]['idrg'] == $r['idrg']){ 
																			$status_kelas = 1;
																		?>
																<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>" selected="true"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
																	<?php
																	}else{ ?>
																	<option value="<?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?>"><?php echo $r['idrg'].'-'.$r['nmruang'].'-'.$r['kelas'] ;?></option>
																	<?php
																	}
																	}
																?>
																<?php
																}
																?>
																<?php if($status_kelas == 0){ ?>
																<option value="" selected="true">-- Kelas yang dipesan penuh silahkan pilih kelas lain --</option>
																<?php
																}?>
															</select> -->
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Bed</label>
														<div class="col-sm-9">
															<select class="form-control input-sm" id="bed" name="bed" required>
																<?php
																foreach ($empty_bed as $r) { ?>
																<option value="<?php echo $r['bed'] ;?>"><?php echo $r['bed'];?></option>
																<?php	
																}
																?>
															</select>
														</div>
													</div>													
													<!-- <div class="form-group">
														<label class="col-sm-3 col-form-label">Ruang</div>
														<div class="col-sm-9">
															<span class="label-form-validation"></span>
															<input type="text" class="form-control input-sm auto_ruang" id="ruang" name="ruang" value="<?php echo $irna_reservasi[0]['ruangpilih']; ?>" readonly>
														</div>
													</div>
													<div class="form-group">
														<label class="col-sm-3 col-form-label"></div>
														<div class="col-sm-9">
															<span class="label-form-validation"></span>
															<div class="col-sm-8 input-left"><input type="text" class="form-control input-sm" id="nm_ruang" name="nm_ruang" value="<?php echo $irna_reservasi[0]['nmruang']; ?>" readonly></div>
															<div class="col-sm-4 input-right"><input type="text" class="form-control input-sm" id="kelas" name="kelas" value="<?php echo $irna_reservasi[0]['kelas']; ?>" readonly></div>
														</div>
													</div> -->
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Tgl. Masuk</label>
														<div class="col-sm-9">
															<input type="text" class="form-control input-sm" id="calendar-tgl-masuk" name="tglmasukrg" value="<?php echo $irna_reservasi[0]['tglrencanamasuk']; ?>" required>
														</div>
													</div>
													<div class="form-group row">
														<label class="col-sm-3 col-form-label">Jatah Kelas</label>
														<div class="col-sm-9">
															<!-- <input type="text" class="form-control input-sm" name="jatahkls"> -->
															<select class="form-control input-sm" name="jatahkls" id="jatahkls">
																<?php
																foreach ($all_kelas as $r) {  ?>
																<option value="<?php echo $r['kelas'] ;?>"><?php echo $r['kelas'] ;?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- /Tabs -->
							
							<!-- Button -->
							<div class="container">
							<div class="row">
								<div class="col-md-12 text-center">
									<a href="<?php echo base_url(); ?>iri/Ricdaftar" class="btn btn-danger"><i class="fa fa-arrow-left"></i> Kembali</a>
									<button type="button" id="submit" onclick="save()" class="btn btn-primary"><i class="fa fa-print"></i> Simpan</button>	
								</div>
							</div>
							</div>
							<br/>
							<!-- /Button -->
							
							<!-- Modal -->
							<div class="modal fade bs-example-modal-sm" id="modal-pendaftaran" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="myModalLabel">Konfirmasi</h4>
										</div>
										<div class="modal-body">
											Apakah kamu yakin dengan data tersebut?
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-remove"></i> Tidak</button>
											<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Ya</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Modal -->
						</form>
						<!-- /Form Pendaftaran -->
						
					</div>
					
				</div>
			</div>
		</section>
		<!-- /Main content -->
		
	</div>
</div>
<script>
	

	$('#calendar-tgl-daftar').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-lahir').datepicker({
		format: 'yyyy-mm-dd'
	});
	$('#calendar-tgl-masuk').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		minDate: '0'
	});
	$('.date_picker').datepicker({
		format: "yyyy-mm-dd",
		//endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
</script>
	
	<div class="modal fade modal_nobpjs" role="dialog" aria-hidden="true">
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
<?php $this->load->view("layout/footer_left"); ?>
