<script src="<?php echo site_url('asset/plugins/ckeditor/ckeditor.js'); ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<style type="text/css">
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
.ui-autocomplete { max-height: 270px; overflow-y: scroll; overflow-x: scroll;}
</style>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
var table_diagnosa;
var table_diagnosa_view;  
var table_procedure;
var table_procedure_view;
$(function(){   
  cek_diag_utama();
    $(".autocomplete_diagnosa").autocomplete({  
      minLength: 2,  
      source : function( request, response ) {
          $.ajax({
            url: '<?php echo site_url('irj/rjcpelayanan/autocomplete_diagnosa')?>',
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
              if(!data.length){
                var result = [{
                 label: 'Data tidak ditemukan', 
                 value: response.term
                }];
                response(result);
              } else {
                response(data);                  
              }                  
            }
          });
      },      
      minLength: 1,     
      select: function (event, ui) {          
          $('#diagnosa_separate').val(ui.item.id_icd+'@'+ui.item.nm_diagnosa);                    
      }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    }); 
    $(".autocomplete_procedure").autocomplete({  
      minLength: 2,  
      source : function( request, response ) {
          $.ajax({
            url: '<?php echo site_url('irj/rjcpelayanan/autocomplete_procedure')?>',
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
              if(!data.length){
                var result = [{
                 label: 'Data tidak ditemukan', 
                 value: response.term
                }];
                response(result);
              } else {
                response(data);                  
              }                  
            }
          });
      },      
      minLength: 1,     
      select: function (event, ui) {          
          $('#procedure_separate').val(ui.item.id_tind+'@'+ui.item.nm_tindakan);                    
      }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    }); 
    $.ui.autocomplete.prototype._renderItem = function (ul, item) {        
      var t = String(item.value).replace(
              new RegExp("(?![^&;]+;)(?!<[^<>])(" + $.ui.autocomplete.escapeRegex(this.term) + ")(?![^<>]>)(?![^&;]+;)", "gi"),
              "<span class='ui-state-highlight'>$&</span>");
      return $("<li></li>")
          .data("item.autocomplete", item)
          .append("<a style='display:inline-block;width: 100%;'>" + t + "</a>")
          .appendTo(ul);
    };    
});
$(document).ready(function() {
	var carabayar="<?php echo $data_pasien_daftar_ulang->cara_bayar;?>"		

	var no_register = "<?php echo $no_register;?>";
	var cekview = "<?php echo $view;?>";
	if(cekview==0){
		tabeltindakan(no_register);
	}else{
		tabeltindakan_view(no_register);
	}

  var dietgizi = "<?php echo $idpokdiet;?>";
  if(dietgizi!=''){
    $('#record_gizi').val(dietgizi).change();
  }

	$("#form_add_tindakan").submit(function(event) {
	    document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
	    $.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'irj/rjcpelayanan/insert_tindakan'; ?>",
	        dataType: "JSON",
	        data: $('#form_add_tindakan').serialize(),
	        success: function(data){   
			    if (data == true) {
			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			    	$("#prop").val("").change();
			    	$("#id_dokter").prop("selected", false).change();
			    	$('#form_add_tindakan')[0].reset();
			        tabeltindakan(no_register);
			        swal("Sukses", "Tindakan berhasil disimpan.", "success");
			    } else {
			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					swal("Error", "Gagal menginput tindakan. Silahkan coba lagi.", "error");	        	
			    }
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        },
	        timeout: 0
	    });
	  event.preventDefault();
	});

  $("#form_add_diet").submit(function(event) {
      document.getElementById("btn-diet").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'irj/rjcpelayanan/insert_dietpasien'; ?>",
          dataType: "JSON",
          data: $('#form_add_diet').serialize(),
          success: function(data){   
          if (data == true) {
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              swal("Sukses", "Jenis Diet berhasil disimpan.", "success");
          } else {
            document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          swal("Error", "Gagal menginput Jenis Diet. Silahkan coba lagi.", "error");            
          }
          },
          error:function(event, textStatus, errorThrown) { 
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          },
          timeout: 0
      });
    event.preventDefault();
  });

		
    table_diagnosa = $('#table_diagnosa').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('irj/rjcpelayanan/diagnosa_pasien')?>",
        "type": "POST",
        "dataType": 'JSON',
        "data": function (data) {
          data.no_register = '<?php echo $no_register;?>';
        }        
      },
      "columnDefs": [
      { 
        "orderable": false, //set not orderable
        "targets": [0,4] // column index 
      }
      ],
    });	
    table_diagnosa_view = $('#table_diagnosa_view').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('irj/rjcpelayanan/diagnosa_pasien_view')?>",
        "type": "POST",
        "dataType": 'JSON',
        "data": function (data) {
          data.no_register = '<?php echo $data_pasien_daftar_ulang->no_register;?>';
        }        
      },
      "columnDefs": [
      { 
        "orderable": false, //set not orderable
        "targets": [0] // column index 
      }
      ],
    }); 


    

    if(carabayar=='BPJS'){
	    table_procedure = $('#tabel_procedure').DataTable({ 
	      "processing": true,
	      "serverSide": true,
	      "order": [],
	      "lengthMenu": [
	        [ 10, 25, 50, -1 ],
	        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
	      ],
	      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	      "ajax": {
	        "url": "<?php echo site_url('irj/rjcpelayanan/procedure_pasien')?>",
	        "type": "POST",
	        "dataType": 'JSON',
	        "data": function (data) {
	          data.no_register = '<?php echo $no_register;?>';
	        }        
	      },
	      "columnDefs": [
	      { 
	        "orderable": false, //set not orderable
	        "targets": [0,4] // column index 
	      }
	      ],
	    });
      table_procedure_view = $('#tabel_procedure_view').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],
        "lengthMenu": [
          [ 10, 25, 50, -1 ],
          [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "ajax": {
          "url": "<?php echo site_url('irj/rjcpelayanan/procedure_pasien_view')?>",
          "type": "POST",
          "dataType": 'JSON',
          "data": function (data) {
            data.no_register = '<?php echo $no_register;?>';
          }        
        },
        "columnDefs": [
        { 
          "orderable": false, //set not orderable
          "targets": [0] // column index 
        }
        ],
      });
    }
	  
	$(".select2").select2();
    // CKEDITOR.replace('subjective');
    // CKEDITOR.replace('apawe');
    // CKEDITOR.replace('objective');
    // CKEDITOR.replace('assesment');
    // CKEDITOR.replace('plan');
    // CKEDITOR.replace('diagnosis_kerja');
    // CKEDITOR.replace('diagnosis_banding');
    // CKEDITOR.replace('pemeriksaan_penunjang');
    // CKEDITOR.replace('tindakan');

   
	
	//-----------------------------------------------Data Table
    $('#tabel_tindakan').DataTable();
	$('#tabel_diagnosa').DataTable();
	$('#tabel_lab').DataTable();
	$('#tabel_pa').DataTable();
	$('#tabel_rad').DataTable();
	$('#tabel_ok').DataTable();
	$('#tabel_resep').DataTable();
	$('#tabel_obat1').DataTable();
	$('#tabel_obat2').DataTable();
    $('#tabel_obat3').DataTable();
	//---------------------------------------------------------
	
	//CEK DATA LAB DAN RESEP-------------------------------------------
	var a_lab="<?php echo $a_lab ?>";
	var a_pa="<?php echo $a_pa ?>";
	var a_obat="<?php echo $a_obat ?>";
	var a_rad="<?php echo $a_rad ?>";
	
	//------------------------------------------------------------------
});

function cek_diag_utama(){
  $.ajax({
          type: "POST",
          url: "<?php echo base_url().'irj/rjcpelayanan/cek_diag'; ?>",
          dataType: "JSON",
          data: {"no_register" : "<?php echo $no_register;?>"},
          success: function(data){
        if (data == '1') {
          $("#diag_alert").hide();
        } else if (data == '2') {
          $("#diag_alert").show();
        }
          },
          error:function(event, textStatus, errorThrown) {      
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          },
          timeout: 0
      });
}
function set_utama_procedure(id) {
	swal({
        title: "Set Utama",
        text: "Set utama prosedur tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
			$.ajax({
				type: 'POST',
				url: "<?php echo site_url('procedure/set_utama_irj')?>",
				dataType:"JSON",
				data: {"id" : id,"no_register" : "<?php echo $no_register;?>"},
		        success: function(data){			        	
		        	if (data == true) {
		        		table_procedure.ajax.reload();
		        		swal("Sukses", "Prosedur berhasil di set utama.", "success");
		        	} else {
						swal("Error", "Gagal men-set utama prosedur. Silahkan coba lagi.", "error");	        	
		        	}			        	
		        },
		        error:function(event, textStatus, errorThrown) {
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        },
			});           
    });
}

function set_utama_diagnosa(id_diagnosa_pasien) {
	swal({
        title: "Set Utama",
        text: "Set utama diagnosa tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
			$.ajax({
				type: 'POST',
				url: "<?php echo site_url('diagnosa/set_utama_irj')?>",
				dataType:"JSON",
				data: {"id_diagnosa_pasien" : id_diagnosa_pasien,"no_register" : "<?php echo $no_register;?>"},
		        success: function(data){			        	
		        	if (data == true) {                
		        		table_diagnosa.ajax.reload();
                cek_diag_utama();
		        		swal("Sukses", "Diagnosa berhasil di set utama.", "success");
		        	} else {
						swal("Error", "Gagal men-set utama diagnosa. Silahkan coba lagi.", "error");	        	
		        	}			        	
		        },
		        error:function(event, textStatus, errorThrown) {
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        },
			});           
    });
}

function tabeltindakan(no_register){
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>irj/rjcpelayanan/tindakan_pasien/"+no_register,
        columns: [
            { data: "id_pelayanan_poli" },
            { data: "nmtindakan" },
            { data: "nm_dokter" },
            { data: "biaya_tindakan" },
            { data: "qtyind" },
            { data: "biaya_alkes" },
            { data: "vtot" },
            { data: "aksi"}
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	 });
	}

function tabeltindakan_view(no_register){
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>irj/rjcpelayanan/tindakan_pasien/"+no_register,
        columns: [
            { data: "id_pelayanan_poli" },
            { data: "nmtindakan" },
            { data: "nm_dokter" },
            { data: "biaya_tindakan" },
            { data: "qtyind" },
            { data: "biaya_alkes" },
            { data: "vtot" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	 });
	}

function pilih_tindakan(tindakan) {
	//alert(tindakan);	
	if(tindakan!=''){
		var result = tindakan.split('@');
		var id_tindakan = result[0];
		
		if(id_tindakan.substring(0,2)=='1B') {
			$("#dokterDiv").show();
			document.getElementById("id_dokter").required = false;
		} else {
			$("#dokterDiv").show();
			document.getElementById("id_dokter").required = true;
		}
		
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('irj/rjcpelayanan/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>"
			},
			success: function(data){
				//alert(data);
				$('#biaya_tindakan').val(data[0]);
				$('#biaya_tindakan_hide').val(data[0]);
        if(data[1] == '' || data[1] == null){
          $('#biaya_alkes').val(0);
				  $('#biaya_alkes_hide').val(0);
          vtot = parseInt(data[0])+parseInt(0);
        }else{
          $('#biaya_alkes').val(data[1]);
				  $('#biaya_alkes_hide').val(data[1]);
          vtot = parseInt(data[0])+parseInt(data[1]);
        }				
				$('#qtyind').val(1);

				
				$('#vtot').val(vtot);
				$('#vtot_hide').val(vtot);
			},
			error: function(xhr, status, error) {
				alert(xhr.responseText);
			}
	    });
	}else
		document.getElementById("id_dokter").required = true;
	
	
}

function pilih_tindakan_lab(id_tindakan) {
   // alert("<?php echo site_url('irj/rjcpelayanan/get_biaya_tindakan'); ?>");
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('lab/labcdaftar/get_biaya_tindakan')?>",
		data: {
			id_tindakan: id_tindakan,
			kelas : "<?php echo $kelas_pasien ?>"
		},
		success: function(data){
			//alert(data);
			$('#biaya_lab').val(data);
			$('#biaya_lab_hide').val(data);
			$('#qty_lab').val(1);
			$('#vtot_lab').val(data);
			$('#vtot_lab_hide').val(data);
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total() {
  var alkes = $("#biaya_alkes").val();
  var biaya_alkes = 0;
  if (alkes != '') {
    biaya_alkes = alkes;
  }else{
    biaya_alkes = 0;
  }
  console.log(biaya_alkes);
	var total = $("#biaya_tindakan").val() * $("#qtyind").val() + biaya_alkes * $("#qtyind").val() ;	
	$('#vtot').val(total);
	$('#vtot_hide').val(total);
}

function set_total_lab() {
	var total = $("#biaya_lab").val() * $("#qty_lab").val();	
	$('#vtot_lab').val(total);
	$('#vtot_lab_hide').val(total);
}

function pilih_obat(id_resep) {
	$.ajax({
		type:'POST',
		dataType: 'json',
		url:"<?php echo base_url('farmasi/Frmcdaftar/get_biaya_tindakan')?>",
		data: {
			id_resep: id_resep
		},
		success: function(data){
		
			var num = data*1.3*1.1;
			$('#biaya_obat').val(num.toFixed(2));
			$('#biaya_obat').maskMoney('mask');
			$('#biaya_obat_hide').val(num.toFixed(2));
			$("#qtyResep").val('1');
		
			$('#vtot_resep').val(num.toFixed(2));
			$('#vtot_resep').maskMoney('mask' );
			$('#vtot_resep_hide').val(num.toFixed(2));
		},
		error: function(){
			alert("error");
		}
    });
}

function set_total_resep() {
	var total = $("#biaya_obat_hide").val() * $("#qtyResep").val();
	$('#vtot_resep').val(total.toFixed(2));
	$('#vtot_resep').maskMoney('mask');
	$('#vtot_resep_hide').val(total.toFixed(2));
}

function insert_diagnosa(){
  if ($('#diagnosa_separate').val() !='' && $('#id_diagnosa').val()!='') {
    document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'irj/Diagnosa/insert_irj'; ?>",
        dataType: "JSON",
        data: $('#form_add_diagnosa').serialize(),
        success: function(result){    
        if (result.metadata.code) {            
          if (result.metadata.code == '200') {             
            document.getElementById("form_add_diagnosa").reset();            
            table_diagnosa.ajax.reload();   
            cek_diag_utama();       
            swal("Sukses", "Diagnosa berhasil disimpan.", "success");
          } else if (result.metadata.code == '422') {             
            swal("Diagnosa sudah ada.", "Silahkan pilih diagnosa yang lain.", "warning"); 
          } else {            
            swal("Gagal menginput diagnosa", result.metadata.message, "error");           
          }                   
        } else swal("Gagal menginput diagnosa", "Silahkan coba lagi.", "error");        
        document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
        },
        error:function(event, textStatus, errorThrown) {           
          document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';   
          swal("Gagal menginput diagnosa", textStatus, "error");    
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
  } else{swal("Diagnosa tidak boleh kosong.", " Silahkan pilih dan klik diagnosa.", "warning");}  
  $('#diagnosa_separate').val('');
  $('#id_diagnosa').val('');
}

function insert_procedure() {
  if ($('#procedure_separate').val()!='' && $('#id_procedure').val()!='') {
    document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'procedure/insert_irj'; ?>",
        dataType: "JSON",
        data: $('#form_add_procedure').serialize(),
        success: function(result){   
          if (result.metadata.code) {            
            if (result.metadata.code == '200') {               
              document.getElementById("form_add_procedure").reset();
              $('#procedure_separate').val('');
              table_procedure.ajax.reload();          
              swal("Sukses", "Prosedur berhasil disimpan.", "success");
            } else if (result.metadata.code == '422') {             
              swal("Procedure sudah ada.", "Silahkan pilih procedure yang lain.", "warning"); 
            } else {            
              swal("Gagal menginput procedure", result.metadata.message, "error");           
            }           
          } 
          document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
        },
        error:function(event, textStatus, errorThrown) { 
          document.getElementById("btn-procedure").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          swal("Gagal menginput procedure", textStatus, "error");          
          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        }
    });
  } else swal("Procedure tidak boleh kosong.", "Silahkan pilih dan klik procedure.", "error"); 
  $('#procedure_separate').val('');
  $('#id_procedure').val('');
}

function delete_diagnosa(id) {       
  swal({
        title: "Hapus Diagnosa",
        text: "Hapus diagnosa tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
			  $.ajax({
			      type: "POST",
			      url: "<?php echo base_url().'diagnosa/delete_irj'; ?>",
			      dataType: "JSON",        
            data: {"id_diagnosa_pasien" : id,"no_register" : "<?php echo $no_register; ?>"},             
			      success: function(data){  
			        if (data == true) {
			          table_diagnosa.ajax.reload();
                cek_diag_utama();
			          document.getElementById("form_add_diagnosa").reset();
			          swal("Sukses", "Diagnosa berhasil dihapus.", "success");
			        } else {
			          swal("Error", "Gagal menghapus diagnosa. Silahkan coba lagi.", "error");            
			        }
			      },
			      error:function(event, textStatus, errorThrown) {    
			          swal("Error", "Gagal Menghapus Data.", "error");
			          console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			      }
			  });           
      });   
}

function delete_procedure(id) {       
  swal({
        title: "Hapus Prosedur",
        text: "Hapus prosedur tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url().'procedure/delete_irj'; ?>",
                  dataType: "JSON",                    
                  data: {"id" : id,"no_register" : "<?php echo $no_register; ?>"},                    
                  success: function(data){  
                    if (data == true) {
                      table_procedure.ajax.reload();
                      document.getElementById("form_add_procedure").reset();
                      swal("Sukses", "Prosedur berhasil dihapus.", "success");
                    } else {
                      swal("Error", "Gagal menghapus data. Silahkan coba lagi.", "error");            
                    } 
                  },
                  error:function(event, textStatus, errorThrown) {    
                      swal("Error", "Gagal Menghapus prosedur.", "error");
                      console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
                  }
              });           
      });   
} 

</script>
