    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<script type='text/javascript'>
	var table_cari=null; var cek=0;
$(function() {
	
	$("#form_cari_umc").on('submit', function(event) {
		event.preventDefault();
	    //document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
	    /*$.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'umc/cumcicilan/pasien/'; ?>",
	        dataType: "JSON",
	        data: $('#form_cari_umc').serialize(),
	        success: function(data){   
			    if (parseInt(data) == 0) {
			    	//document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			        table_cari.ajax.reload();
			        //swal("Sukses", "Diagnosa berhasil disimpan.", "success");
			        swal("Error", "Data Pasien tidak ditemukan", "error");
			    } else {
			    	//document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			    	table_cari.ajax.reload();	        	
			    }
			    //cek_utama_diagnosa();
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	//document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        },
	        timeout: 0
	    });
	  event.preventDefault();*/
	  //console.log($('#form_cari_umc').serialize());
	  cek=1;
	  table_cari.ajax.reload();
	}); 
	//$("#duplikat_id").hide();
	//$("#duplikat_kartu").hide();
	
	table_cari = $('#table_cari').DataTable({
        //ajax: "<?php //echo site_url();?>umc/cumcicilan/pasien",
        ajax: {
            url: "<?php echo site_url();?>umc/cumcicilan/pasien/",
            type: "POST",
            dataSrc:"",
            data: function ( d ) {
	            d.cari_no_cm = $('#cari_no_cm').val();
	            d.cari_nama = $('#cari_nama').val();
	            d.cari_no_nrp = $("#cari_no_nrp").val();
	            d.cari_no_cm_lama = $("#cari_no_cm_lama").val();
	            d.cari_no_identitas = $("#cari_no_identitas").val();
	            d.cari_tgl = $("#cari_tgl").val();
	            d.cari_no_kartu = $("#cari_no_kartu").val();
	            d.cari_alamat = $("#cari_alamat").val();
        	}
            /*data: {
            	"cari_no_cm" : $('#cari_no_cm').val(),
            	"cari_no_nrp" : $('#cari_no_nrp').val()
            }*/
        },
        language: {
      		emptyTable : "Data Pasien Tidak Ditemukan"
    	},
        columns: [
            { data: "no_cm" },
            { data: "nama" },
            { data: "no_identitas" },
            { data: "no_kartu" },
            { data: "alamat" },
            //{ data: "tgl_lahir" },
            { data: "tgl_lahir", render: function (data) {
                        var date = new Date(data);
                        return date.getDate()+ '-' +date.getMonth()+ '-' +date.getFullYear();
            }},
            { data: null, render: function ( data, type, row ) {
                        return '<a href="<?php echo site_url("umc/cumcicilan/input_irj/");?>/'+data.no_medrec+'" class="btn btn-primary btn-xs" style="width:85px;margin-bottom: 3px;">Input</a><br><a href="<?php echo site_url("medrec/el_record/pasien/");?>/'+data.no_medrec+'" class="btn btn-danger btn-xs" style="width:85px;">Rekam Medik</a>';
                        }
                    }
        ],
        // columnDefs: [
        //     { targets: [ 0 ], visible: false }
        // ],
        // bFilter: true,
        // bPaginate: true,
        // destroy: true,
        // order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	 });
	// table_cari.ajax.reload();
	$('.auto_search_by_nocm').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
	});

	$('.auto_search_by_nocm_lama').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm_lama',
		onSelect: function (suggestion) {
			$('#cari_no_cm_lama').val(''+suggestion.no_cm_lama);			
		}
	});
	
	$('.auto_search_by_nokartu').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nokartu',
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
		}
	});
	
	$('.auto_search_by_noidentitas').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_noidentitas',
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
	});

	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nonrp3',
		onSelect: function (suggestion) {
			$('#cari_no_nrp').val(''+suggestion.no_nrp);
		}
	});
	
	$('.auto_search_by_nama').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nama'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});
	
	$('.auto_search_by_alamat').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_alamat'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});

	$('#cari_tgl').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  
		
});	

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

	
function cek_nokartu(no_medrec){
    ajaxku = buatajax();
    var url="<?php echo site_url('irj/rjcwebservice/check_no_kartu'); ?>";
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

function cek_search_per(val_search_per){
	//alert(val_search_per);
	$("#cari_no_cm").val(""); // To unhide
	$("#cari_no_cm_lama").val("");  // To hide
	$("#cari_no_kartu").val("");  // To hide
	$("#cari_no_identitas").val("");
	$("#cari_nama").val(""); 
	$("#cari_no_nrp").val(""); 
	$("#cari_alamat").val("");
	$("#cari_tgl").val("");

	if(val_search_per=='cm'){
		$("#cari_no_cm").css("display", ""); // To unhide
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='cm_lama'){		
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='identitas'){
		  // To hide
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='nama'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", ""); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	} 
	else if(val_search_per=='nrp'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", ""); 
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	} 	
	else if(val_search_per=='alamat') {
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
		$("#cari_alamat").css("display", "");
		$("#cari_tgl").css("display", "none");
	}
	else {
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "");
	}
}
//
function cek_no_identitas(no_identitas){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_noidentitas')?>/"+no_identitas+"/",
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

function cek_no_kartu(no_kartu){
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('irj/rjcregistrasi/cek_available_nokartu')?>/"+no_kartu+"/",
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
function cetak_tracer(no_register) {
      var windowUrl = '<?php echo base_url();?>irj/tracer/cetak/'+no_register;
      window.open(windowUrl,'p');
}
</script>
	
<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('success_msg'); ?>
	</div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
			<form class="form" id="form_cari_umc">
                <div class="row p-t-10 m-b-15">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- <label class="control-label">Kategori</label> -->
                            <select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
								<option value="cm">No. RM</option>
								<option value="cm_lama">No. RM Lama</option>
								<option value="nama">Nama</option>
								<option value="nrp">NIP / NRP</option>
								<option value="kartu">No. BPJS</option>
								<option value="identitas">No. Identitas</option>								
								<option value="alamat">Alamat</option>
								<option value="tgl">Tanggal Lahir</option>
							</select>
                            <!-- <small class="form-control-feedback"> This is inline help </small> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group has-danger">
							<input type="search" class="auto_search_by_nocm form-control" id="cari_no_cm" name="cari_no_cm" placeholder="Pencarian No RM" style="width:450;">
							<input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru">
							<!--auto_search_cm_lama-->					
							<input type="search" style="width:450; display:none" class=" form-control" id="cari_no_cm_lama" name="cari_no_cm_lama" placeholder="Pencarian No RM Lama">
							<!--auto_search_by_nama-->					
							<input type="search" style="width:450; display:none" class=" form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama">
							<!--auto_search_by_nonrp-->
							<input type="search" style="width:450; display:none" class="auto_search_by_nonrp form-control" id="cari_no_nrp" name="cari_no_nrp" placeholder="Pencarian No NRP">
							<!--auto_search_by_nokartu-->
							<input type="search" style="width:450; display:none" class="auto_search_by_nokartu form-control" id="cari_no_kartu" name="cari_no_kartu" placeholder="Pencarian Kartu BPJS">
							<!--auto_search_by_noidentitas-->
							<input type="search" style="width:450; display:none" class="auto_search_by_noidentitas form-control" id="cari_no_identitas" name="cari_no_identitas" placeholder="Pencarian No Identitas">
							<!--auto_search_by_alamat-->
							<input type="search" style="width:450; display:none" class=" form-control" id="cari_alamat" name="cari_alamat" placeholder="Pencarian Alamat">

							<input type="search" style="width:450; display:none" class="form-control" id="cari_tgl" name="cari_tgl" placeholder="Pencarian Tgl Lahir">
                            <!-- <small class="form-control-feedback"> This field has error. </small> </div> -->
                        </div>
                    </div>
                        <?php //$url=site_url('irj/rjcregistrasi/regpasien'); ?>
                    <div class="col-md-5">
                        <div class="form-actions">
                        	<button type="submit" class="btn waves-effect waves-light btn-info">
                        		<i class="fa fa-search"></i> Cari Pasien
                        	</button>
<!--                         	<button type="button" onclick="javascript:window.location.href='<?php //echo $url ?>'; return false;" class="btn waves-effect waves-light btn-danger"><i class="fa fa-user-plus"></i> Tambah Pasien Baru</button> -->
                        </div>
                    </div>
                </div>
				</form>           
                <div class="table-responsive m-t-0">
                    <table id="table_cari" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
							<tr>
								<th>No. RM</th>
								<th>Nama</th>
								<th>No. Identitas</th>
								<th>No. BPJS</th>								
								<th>Alamat</th>
								<th>Tgl Lahir</th>
								<th width="40px">Aksi</th>
							</tr>
                        </thead>
						<tbody>
							
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 