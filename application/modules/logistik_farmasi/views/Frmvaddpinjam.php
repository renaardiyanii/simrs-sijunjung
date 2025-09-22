<?php
  $this->load->view('layout/header_left.php');
?>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script> 
<script type='text/javascript'>
 Date.prototype.yyyymmdd = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();

        return [this.getFullYear() + '-',
            (mm > 9 ? '' : '0') + mm + '-',
            (dd > 9 ? '' : '0') + dd + '-'
        ].join('');
    };

var table;
var ndata = 0;
$(function() {
	<?php echo $this->session->flashdata('cetak'); ?>
	var $id_obat = $("#id_obat").select2();
	
	// $('#tgl_amprah').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	endDate: '0',
	// 	autoclose: true,
	// 	todayHighlight: true
	// });  
	var myDate = new Date(); 
	// $('#tgl_amprah').datepicker('setDate', myDate.yyyymmdd());
	table = $('#example').DataTable();
	$('#btnUbah').css("display", "none");
	$('#detailObat').css("display", "none");
   	$( "#vgd_dituju" ).change(function() {
		// $('#vgd_dituju').prop('disabled', 'disabled');
		if ($( "#vgd_dituju" ).val() == '') {			
			$('#btnUbah').css("display", "none");
			$('#detailObat').css("display", "none");
			$('#gd_dituju').val( $( "#vgd_dituju" ).val() );
		}else{
			$('#btnUbah').css("display", "");
			$('#detailObat').css("display", "");
			$('#gd_dituju').val( $( "#vgd_dituju" ).val() );
		}
	});
	
   	$( "#btnUbah" ).click(function() {
		// $('#vgd_dituju').prop('disabled', '');
		 $('#vgd_dituju option[value=""]').prop('selected', 'selected'); 
		$('#gd_dituju').val("");
		$('#vgd_dituju').focus();
		$('#btnUbah').css("display", "none");
		table.clear().draw();
		$('#detailObat').css("display", "none");
	});
	
	$("#id_obat").change(function(){
		if ($('#id_obat').val() != ''){
			$.ajax({
			  dataType: "html",
			  data: {id: $('#id_obat').val() },
			  type: "POST",
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_satuan_obat",
			  success: function( response ) {
				$('#satuank').val( response );
			  }
			});		
			// $('#jml').val('1');
		}
	});

		
   	// $( "#btnTambah" ).click(function() {
   	// 	var id_obat = $('#id_obat').val();
   	// 	var qty = $('#jml').val();
   	// 	var gd_asal = $('#gd_asal').val();
   	// 	$.ajax({
    //     	type: "POST",
    //         dataType: "JSON",
    //         data: {"id_obat" : id_obat,
    //     			"qty" : qty,
    //     			"gd_asal": gd_asal},
    //         url: "<?php //echo base_url().'logistik_farmasi/Frmcamprah/cek_stock/'; ?>",
    //         success : function(result){
    //           if(result.success == 1){
    //             swal("Sukses", "Data berhasil disimpan", "success");
	//                 table.row.add( [
	// 				$('#id_obat').val(),
	// 				$( "#id_obat option:selected" ).text(),
	// 				$('#satuank').val(),
	// 				$('#jml').val(),
	// 				// '<center><button type="button" id="delete" class="btnDel btn btn-primary btn-xs" title="Hapus" onClick="delete_obat(\"'+id_obat+'\",\"'+qty+'\",\"'+gd_asal+'\")">Hapus</button></center>'
	// 				'<center><button type="button" id="hapus" name="hapus" class="btnDel btn btn-primary btn-xs" title="Hapus" data-id='+id_obat+' data-qty='+qty+' data-gudang='+gd_asal+'>Hapus</button></center>'
	// 				] ).draw(false);
	// 					$id_obat.val("").trigger("change");
	// 					$('#satuank').val('');
	// 					$('#jml').val('');		
	// 					populateDataObat();
    //           }else{
    //             swal("Gagal", "Stok Tidak Mencukupi", "error");
    //           }
    //         }
    //     });		
	// });

	$("#btnTambah").click(function () {
            addItems();
        });


	$('#example tbody').on( 'click', 'button.btnDel', function () {
		table.row( $(this).parents('tr') ).remove().draw();
		populateDataObat();
	} );
  
   	$( "#btnSimpan" ).click(function() {
		if (ndata == 0){
			alert("Silahkan input data obat");
			$('#id_obat').focus();
		}else
			$( "#frmAdd" ).submit();
	});

   	$( "#hapus" ).click(function() {
   		var id_obat=$(this).data('id');
   		var qty=$(this).data('qty');
   		var gudang=$(this).data('gudang');
		$.ajax({
			type: "POST",
	        dataType: "JSON",
	        data: {"id_obat" : id_obat,
	        		"qty" : qty,
	        		"gd_asal": gd_asal},
			url: "<?php echo base_url().'logistik_farmasi/Frmcamprah/cek_stock_hapus/'; ?>",
	            success : function(result){
	              	if(result.success == 1){
	                	swal("Sukses", "Data berhasil dihapus", "success");
	            	}else{
	            		swal("Gagal", "Data gagal dihapus", "error");
	            	}
	            }
		});	
	});

	$(".autocomplete_obat").autocomplete({  
      minLength: 2,  
      source : function( request, response ) {
          $.ajax({
			url: "<?php echo base_url().'logistik_farmasi/Frmcamprah/autocomplete_obat'; ?>",
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
		$('#keyword').val(''+ui.item.nm_obat);    
		ajaxobatallsearch(ui.item.id_obat);             
      }
    }).on("focus", function () {
        $(this).autocomplete("search", $(this).val());
    }); 

});



function addItems() { 
        var idobat = $('#id_obat').val();
        var satuan = $('#satuank').val();
        var qty = $('#jml').val();
       

        if(idobat == "" || satuan == "" || qty == "") {

            swal({
                    title: "Perhatian!",
                    text: "Kolom Item Amprah Tidak Boleh Kosong!",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                },
                function(){
                    $('#cari_obat').focus();
                });
        }else{
            table.row.add([
                $('#id_obat').val(),
                $( "#id_obat option:selected" ).text(),
				$('#satuank').val(),
                $('#jml').val(),
                '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>'
            ]).draw(false);

            $('#id_obat').val("");
			$('#id_obat').val("").trigger("change");
            $('#satuank').val("");
            $('#jml').val("");

            populateDataObat();
        }
    }




function populateDataObat(){
	vjson = table.rows().data();
	ndata = vjson.length;
	var vjson2= [[]];
	jQuery.each( vjson, function( i, val ) {
		vjson2[i] = {"id_obat": vjson[i][0], "satuank":vjson[i][2], "jml":vjson[i][3],"nm_obat":vjson[i][1]} ;  
	});
	$('#dataobat').val( JSON.stringify(vjson2) );
}
function cetak(id){
	var win = window.open(baseurl+'download/logistik_farmasi/FA_'+id+'.pdf', '_blank');
	if (win) {
		//Browser has allowed it to be opened
		win.focus();
	} else {
		//Browser has blocked it
		alert('Please allow popups for this website');
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

var ajaxku;
function ajaxobatallsearch(text){
	console.log(text);
	ajaxku = buatajax();
	var url="<?php echo site_url('logistik_farmasi/Frmcamprah/data_obat_all_search'); ?>";
	url=url+"/"+text;
	ajaxku.onreadystatechange=stateChangedObatAll;
	ajaxku.open("GET",url,true);
	ajaxku.send(null);
}

function stateChangedObatAll(){
	var data;
	//alert(ajaxku.responseText);
	if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_obat_all").innerHTML = data;
		}
	}
	
}

function clear_cari_stok(){  
	ajaxobatallsearch(''); 
	$('#keyword').val('');  
}

</script>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
        <div class="card-block">
        	<!-- <button type="button" class="btn btn-primary pull-right" href="<?php echo site_url('logistik_farmasi/Frmcamprah');?>"><i class="fa fa-book"> &nbsp;Monitoring Amprah</i></button>
        	<br></br> -->
			<div class="row">
			  	<div class="col-xs-9" id="alertMsg">	
					<?php echo $this->session->flashdata('alert_msg'); ?>
			  	</div>
			  	<div class="col-xs-3" align="right"></div> 
			</div>
			<?php echo form_open('logistik_farmasi/Frmcpinjam/save',array('id'=>'frmAdd','method'=>'post')); ?>
			<div class="modal-body">
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Tanggal Pinjam</p>
                    <div class="col-sm-3">
					<input type="date" value="<?= date('Y-m-d') ?>" class="form-control" name="tgl_pinjam" id="tgl_pinjam" required>
                     
                    </div>
                </div>
               
                <div class="form-group row">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Tujuan Peminjaman</p>
                    <div class="col-sm-6">
                       <select name="vgd_dituju" id="vgd_dituju" class="form-control js-example-basic-single"  required>
						<option value="">-Pilih Tujuan-</option>
                        <?php
                          foreach($select_gudang1 as $row){
                            echo '<option value="'.$row->id.'">'.$row->pbf.'</option>';
                          }
                        ?>
                        </select>
                    </div>
                </div>
				<input type="hidden" id="user" name="user" value="<?php echo $user_info->username; ?>"/>
            </div>
			<div class="modal-footer">
				<div id="detailObat">
					<!-- <p><i>*Obat diambil dari gudang asal</i></p> -->
					<div class="form-group row">
						<p class="col-sm-1 form-control-label">Nama Obat</p>
						<div class="col-sm-3">
						  <select id="id_obat" class="form-control select2" name="id_obat">
								<option value="">-Pilih Obat-</option>
								<?php
									foreach($data_obat as $row){
										echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-sm-1">
						  Satuan
						</div>
						<div class="col-sm-2">
							<select id="satuank" class="form-control" name="satuank">
								<option value="">-Pilih satuan-</option>
								<?php
									foreach($satuan as $row){
										echo '<option value="'.$row->nm_satuan.'">'.$row->nm_satuan.'</option>';
									}
								?>
							</select>
						</div>
						<div class="col-sm-1">
						  Jumlah
						</div>
						<div class="col-sm-2">
						  <input type="number" class="form-control" name="jml" id="jml" min=0 >
						</div>
						<div class="col-sm-1">
						<a class="btn btn-danger" id="btnTambah" href="#"><i class="fa fa-plus"></i> Tambahkan</a>
						</div>
						
					</div>
					<br/>
					<table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
					  	<thead>
					  	<tr>
							<th>ID Obat</th>
							<th>Nama Obat</th>
							<th>Satuan</th>
							<th>Jumlah Diminta</th>
							<th>Aksi</th>
					  	</tr>
					  	</thead>
					</table>
				<br/><br/>
				</div>
			</div>
			<input type="hidden" name="dataobat" id="dataobat">
			<button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
			<!-- <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#detailModal" style="float: right;">Cek Stok</button> -->
			<?php echo form_close();?>
        </div>
        </div>
    </div>
</div>

 <!-- Modal Insert-->
 <div class="collapse fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
	
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Cek Stok<span id="sIdAmprah"></span></h4>
			</div>
			<div class="modal-body table-responsive">	
				<div class="form-group row">
					<p class="col-sm-1 form-control-label text-right" id="nmdokter"><b>Obat *</b></p>
					<div class="col-sm-11">
						<div class="form-group row">
							<input type="text" name="keyword" id="keyword" class="form-control col-sm-10 autocomplete_obat" placeholder="Cari Nama Obat..." style="width:100%;margin-right:5px;" />
							<button type="button" class="btn btn-primary" onclick="clear_cari_stok()">CLEAR</button>
						</div>
					</div>
				</div>		      

				<div class="form-group row">						
					<div class="col-sm-12">
						<div class="form-inline" id="id_obat_all">
						
						</div>
					</div>
				</div>

			</div>
		</div>

</div>

<?php
  $this->load->view('layout/footer_left.php');
?>