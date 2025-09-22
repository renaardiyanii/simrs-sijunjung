<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
var table, tblObat;
$(function() {
	// $('.datepicker').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	endDate: '0',
	// 	autoclose: true,
	// 	todayHighlight: true
	// });  
	table = $('#example').DataTable({
		ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_po_list",
		columns: [
			{ data: "id_po" },
			{ data: "no_po" },
			{ data: "tgl_po" },
			{ data: "company_name" },
			{ data: "sumber_dana" },
			{ data: "user" },
			{ data: "status" },
			{ data: "aksi" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 2, "asc" ],[ 1, "asc" ]]
	});
	tableObat = $('#tableObat').DataTable({
		//ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",
		columns: [
			{ data: "item_id" },
			{ data: "description" },
			{ data: "nm_generik" },
			{ data: "satuank" },
			{ data: "bentuk_sediaan" },
			{ data: "kemasan" },
			{ data: "qty_po" },
			{ data: "hargabeli" },
			{ data: "subtotal" }
			//{ data: "jml_kemasan" },
			//{ data: "harga_item" }
			//{ data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 0, '') }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 0, "asc" ]]
	});
	
	$('#no_po').autocomplete({
		serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcpo/auto_no_po',
		onSelect: function (suggestion) {
			$.ajax({
			  dataType: "json",
			  data: {id: suggestion.id },
			  type: "POST",
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_info",
			  success: function( response ) {
				//alert(JSON.stringify(response));
				$('#tgl0').val(response.tgl_po);
				$('#tgl1').val('');
				$('#tgl1').prop('disabled',true);
				$('#supplier_id').val(response.supplier_id);
				$('#supplier_id').prop("disabled", true);
			  }
			});		
			$('#btnCari').focus();
		}
	});
	$('#btnCari').click(function(){
		refreshPO();
	});
	
	$('#detailModal').on('shown.bs.modal', function(e) {
		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');
		var open = $(e.relatedTarget).data('open');
		var no = $(e.relatedTarget).data('no');
		$('#sDetailID').html(no);
		$('#hideIdPO').val(id);
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_detail_list",
		  success: function( response ) {
				tableObat.clear().draw();
				tableObat.rows.add(response.data);
				tableObat.columns.adjust().draw(); 

				$("#totals").html('<h3>' + response.total + '</h3>');
				if(open == 1 ){
					$('#btnEdit').attr('hidden', false);
				}else{
					$('#btnEdit').attr('hidden', true);
					// $('span').remove('.aw');
					// $('input').remove('#hideIdPO2');
				}
		  }
		});	
	});
	
	$('#btnOK').click( function() {
		$('#detailModal').modal('hide');
    });

    $('#btnOKEdit').click( function() {
		var idpo = $('#hideIdPO').val();
		var values = $("input[name='qtypo[]']").map(function(){
						return $(this).val();
					 }).get();
		var values2 = $("input[name='itemid[]']").map(function(){
						return $(this).val();
					 }).get();
        // console.log(values);
        // console.log(idpo);
        // console.log(values2);
        swal({	
		  	title: "Edit Qty PO",
		  	text: "Apa anda yakin ingin mengubah qty PO ?",
		  	type: "warning",
		  	showCancelButton: true,
		  	cancelButtonText: "Tidak",
		  	confirmButtonText: "Ya",
		  	closeOnConfirm: false,
		},
		function(){
		// alert(id);
			$.ajax({
			  dataType: "json",
			  type: 'POST',
			  data: {id:idpo, qty:values, iditem:values2},
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/update_qty_po",
			  success: function(){
					swal({
					  	title: "Qty PO berhasil diubah",
					  	text: "Akan menghilang dalam 3 detik.",
					  	type: "success",
					  	timer: 3000,
					  	showConfirmButton: false,
					  	showCancelButton: true
					});
					refreshPO();
					$('#detailModal').modal('hide');
			  }
			});	
		});
		// $('#detailModal').modal('hide');
    });

    $('#btnEdit').click( function() {
		$('.qtypo').attr("readonly", false);
		$('.qtypo').attr("style", "text-align: right; width: 50px; float: right; background-color: #f3c1d2; border: 0.5px; border-radius:5px;");
		$('#btnOK').attr("hidden", true);
		$('#btnOKEdit').attr("hidden", false);
    });

    $(document).on("click","#btnCancel",function(){
    	var id = $(this).data('idpo');
    	// console.log(id);
    	swal({	
		  	title: "Batalkan PO",
		  	text: "Apa anda yakin ingin membatalkan PO ?",
		  	type: "warning",
		  	showCancelButton: true,
		  	cancelButtonText: "Tidak",
		  	confirmButtonText: "Ya",
		  	closeOnConfirm: false,
		},
		function(){
		// alert(id);
			$.ajax({
			  dataType: "json",
			  type: 'POST',
			  data: {id:id},
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/cancel_po",
			  success: function(){
					swal({
					  	title: "PO berhasil dibatalkan",
					  	text: "Akan menghilang dalam 3 detik.",
					  	type: "success",
					  	timer: 3000,
					  	showConfirmButton: false,
					  	showCancelButton: true
					});
					refreshPO();
			  }
			});	
		});
    });
	
	$('#btnReset').click(function(){
		$('#tgl1').prop('disabled',false);
		$('#supplier_id').prop("disabled", false);
		$('#no_po').focus();
	});

	$('#btnCetak').click( function() {
		var id = $('#hideIdPO').val();
		var win = window.open('<?=site_url('/logistik_farmasi/Frmcpo/surat_pesanan/')?>'+id, '_blank');
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
			//Browser has blocked it
			alert('Please allow popups for this website');
		}
	});


});

function refreshPO(){
	$.ajax({
		url: '<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_po_list',
		type: 'POST',
		data: $('#frmCari').serialize(),
		dataType: "json",
		success: function (response) {
			//alert(JSON.stringify(response.data));
			table.clear().draw();
			table.rows.add(response.data);
			table.columns.adjust().draw(); 
		}
	});
	$('#btnOK').attr("hidden", false);
	$('#btnOKEdit').attr("hidden", true);
}

function export_excel(){
	var d = new Date();
	tglawal = document.getElementById("tgl0").value;
	if(tglawal === ""){
		tglawal = "<?php echo date('Y-m-d');?>"
	}
	tglakhir = document.getElementById("tgl1").value;
	if(tglakhir === ""){
		tglakhir = "<?php echo date('Y-m-d');?>"
	}
	url = "<?php echo base_url('logistik_farmasi/Frmcpo/export_excel')?>";
	swal({
	  	title: "Export To Excel",
	  	text: "Benar Akan Export?",
	  	type: "info",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	showLoaderOnConfirm: true,
	},
	function(){
		window.open(url+'/'+tglawal+'/'+tglakhir, "_blank");
		// alert(url+'/'+tglawal+'/'+tglakhir);
		swal({
		  	title: "Data Excel Berhasil Di download.",
		  	text: "Akan menghilang dalam 3 detik.",
		  	timer: 3000,
		  	showConfirmButton: false,
		  	showCancelButton: true
		});
	});
}
    
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">	
	<div style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid"><br>
				<form id="frmCari" class="form-horizontal">
					<div class="form-group row">
						<label class="col-sm-2 control-label">Nomor PO</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" name="no_po" id="no_po" >
						</div>
						<div class="col-sm-6">
						  <a class="btn btn-primary pull-right" href="<?php echo site_url('logistik_farmasi/Frmcpo/form');?>"><i class="fa fa-plus"> &nbsp;Tambah PO</i> </a>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 control-label">Tanggal PO</label>
						<div class="col-sm-3">
						  <input type="date" class="form-control datepicker" name="tgl0" id="tgl0" >
						</div>
						<label class="col-sm-1 control-label">s/d</label>
						<div class="col-sm-3">
						  <input type="date" class="form-control datepicker" name="tgl1" id="tgl1" >
						</div>
						<!-- <div class="col-sm-3">
	                		<button type="button" id="submit" onclick="export_excel()" class="btn btn-primary pull-right"><i class="fa fa-print"> &nbsp;Export Excel</i> </button>
						</div> -->
					</div>
					<div class="form-group row">
						<label class="col-sm-2 control-label">Supplier</label>
						<div class="col-sm-4">
						  <select name="supplier_id" id="supplier_id" class="form-control" style="width:100%" required="">
							<option value="" selected>---- Pilih Supplier ----</option>
							<?php
							  foreach($select_pemasok as $row){
								echo '<option value="'.$row->id.'">'.$row->pbf.'</option>';
							  }
							?>
						  </select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-2">
						</div>
						<div class="col-sm-10">
						  <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
						  <button type="reset" id="btnReset" class="btn btn-primary">Reset</button>
						</div>
					</div>					
				</form>		
			</div>
		</div>
	</div>
	</div>
</div>
<br><br>
<div class="row">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-header">
			<div class="row">
			  <div class="col-xs-9" id="alertMsg">	
					<?php echo $this->session->flashdata('alert_msg'); ?>
			  </div>
			</div>
        </div>
        <div class="card-block">
            <div class="modal-body table-responsive m-t-0">
				<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				  <thead>
				  <tr>
					<th>ID PO</th>
					<th>No. PO</th>
					<th>Tgl PO</th>
					<th>Supplier</th>
					<th>Jenis Pesanan</th>
					<th>User</th>
					<th>Status</th>
					<th>Aksi</th>
				  </tr>
				  </thead>
				</table>		
			</div>
        </div>
      </div>
    </div>
</div>
<!-- Modal Insert-->
<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-default modal-lg">
	  <!-- Modal content-->
	  <div class="modal-content">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <h4 class="modal-title">Detail PO No : <span id="sDetailID"></h4>
		</div>
		<div class="modal-body table-responsive m-t-0">							
			<table id="tableObat" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
			  <thead>
			  <tr>
				<th><p align="center">ID Obat</p></th>
				<th><p align="center">Nama Obat</p></th>
				<th><p align="center">Generik</p></th>
				<th><p align="center">Satuan Kecil</p></th>
				<th><p align="center">Bentuk Sediaan</p></th>
				<th><p align="center">Kemasan/Satuan</p></th>
				<th><p align="center">Jml PO</p></th>
				<th><p align="center">Harga Beli</p></th>
				<th><p align="center">Subtotal</p></th>
			  </tr>
			  </thead>
			</table>
            <br/><br/>
            <table cellspacing="0" width="100%" class="display">
                <thead>
                <tr>
                    <th width="80%"><div align="right"><h3>Total</h3></div></th>
                    <th width="20%"><div align="right" id="totals"></div></th>
                </tr>
                </thead>
            </table>
		<div class="modal-footer">	
			<input type="hidden" id="hideIdPO"> 
			<!-- <button id="btnOK" class="btn btn-primary pull-right">OK</button>
			<button id="btnOKEdit" class="btn btn-primary pull-right" hidden>OK</button> -->
			<!-- &nbsp;&nbsp; -->
			<!-- <span class="pull-right">&nbsp;&nbsp;</span>-->
			<!-- <button id="btnEdit" class="btn btn-primary pull-right" hidden>Edit Qty</button>
			&nbsp;&nbsp; -->
			<!-- <span class="pull-right aw">&nbsp;&nbsp;</span><input type="hidden" id="hideIdPO2"> -->
			<button id="btnCetak" class="btn btn-primary pull-right">Surat Pesanan</button>
		</div>
	  </div>
	</div>
</div>

<?php
  $this->load->view('layout/footer_left.php');
?>