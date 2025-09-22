<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
var table, tableObat;
$(function() {
	$("#divDetail").css("display", "");
	// $('.datepicker').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	endDate: '0',
	// 	autoclose: true,
	// 	todayHighlight: true
	// });  
	table = $('#example').DataTable({
		ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcpinjam/get_pinjam_list",
		columns: [
			{ data: "id_pinjam" },
			{ data: "tgl_pinjam" },
			{ data: "tujuan" },
			{ data: "user" },
			{ data: "aksi" }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 0, "desc" ]]
	});
	tableObat = $('#tableObat').DataTable({
		// ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcdistribusi/get_detail_list",
		columns: [
			{ data: "id_obat" },
			{ data: "nm_obat" },
			{ data: "satuank" },
			{ data: "qty_req" },
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 0, "asc" ]]
	});
	
	$('#id_amprah').autocomplete({
		serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcamprah/auto_id_amprah',
		onSelect: function (suggestion) {
			$.ajax({
			  dataType: "json",
			  data: {id: suggestion.value },
			  type: "POST",
			  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_info",
			  success: function( response ) {
				$('#tgl0').val(''+response.tgl_amprah);
				$('#tgl1').val('');
				$('#tgl1').prop('disabled',true);
				$('#gd_asal').val(''+response.gd_asal);
				$('#gd_asal').prop('disabled',true);
				$('#gd_dituju').val(''+response.gd_dituju);
				$('#gd_dituju').prop('disabled',true);
			  }
			});		
			$('#btnCari').focus();
		}
	});
	$('#btnCari').click(function(){
		$.ajax({
			url: '<?php echo site_url(); ?>logistik_farmasi/Frmcpinjam/get_pinjam_list',
			type: 'POST',
			data: $('#frmCari').serialize(),
			dataType: "json",
			success: function (response) {
				//alert(JSON.stringify(response.data));Frmcamprah/get_amprah_detail_list",
				table.clear().draw();
				table.rows.add(response.data);
				table.columns.adjust().draw(); 
			}
		});
	});
	
	$('#detailModal').on('shown.bs.modal', function(e) {
		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');
		$('#sIdAmprah').html(id);
		$("#amprahid").val(id);
		//populate the textbox		
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:id},
		  url: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",
		  success: function( response ) {
				tableObat.clear().draw();
				tableObat.rows.add(response.data);
				tableObat.columns.adjust().draw(); 
		  }
		});		
	});
	$('#btnReset').click(function(){
		$('#tgl1').prop('disabled',false);
		$('#gd_asal').prop('disabled',false);
		$('#gd_dituju').prop('disabled',false);
		$('#id_amprah').focus();
	});
	
	$('#btnOk').click( function() {
		$('#detailModal').modal('hide');
	});
	
	$('#btnCetak').click( function() {
		var id = $('#sIdAmprah').text();
		var win = window.open(baseurl+'download/logistik_farmasi/FA_'+id+'.pdf', '_blank');
		if (win) {
			//Browser has allowed it to be opened
			win.focus();
		} else {
			//Browser has blocked it
			alert('Please allow popups for this website');
		}
	});
});

    
</script>

<div class="row">
	<div class="col-lg-12 col-md-12">	
	<div style="background: #e4efe0">
		<div class="inner">
			<div class="container-fluid"><br>
				<form id="frmCari" class="form-horizontal">
					<div class="form-group row">
						<label class="col-sm-2 control-label">ID Pinjaman</label>
						<div class="col-sm-4">
						  <input type="text" class="form-control" name="id_pinjam" id="id_pinjam" >
						</div>
						<div class="col-sm-6">
						  <a class="btn btn-primary pull-right" href="<?php echo site_url('logistik_farmasi/Frmcpinjam/form');?>"><i class="fa fa-plus"> &nbsp;Tambah Pinjaman</i> </a>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-2 control-label">Tanggal Pinjaman</label>
						<div class="col-sm-3">
						  <input type="date" class="form-control datepicker" name="tgl0" id="tgl0" >
						</div>
						<label class="col-sm-1 control-label">s/d</label>
						<div class="col-sm-3">
						  <input type="date" class="form-control datepicker" name="tgl1" id="tgl1" >
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
<br></br>
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
            <div class="modal-body">
				<table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				  <thead>
				  <tr>
					<th>ID Pinjam</th>
					<th>Tgl Pinjam</th>
					<th>Tujuan</th>
					<th>User</th>
					<th>Aksi</th>
				  </tr>
				  </thead>
				</table>		
			</div>
        </div>
      	</div>
    </div>
	<!-- Modal Insert-->
	<div class="modal fade lg" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-default modal-lg">
	  	<!-- Modal content-->
	  	<div class="modal-content">
			<div class="modal-header">
			  	<button type="button" class="close" data-dismiss="modal">&times;</button>
			  	<h4 class="modal-title">Detail ID Amprah : <span id="sIdAmprah"></span></h4>
			</div>
			<div class="modal-body table-responsive m-t-0">							
				<table id="tableObat" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
			  		<thead>
			  		<tr>
						<th>ID Obat</th>
						<th>Nama Obat</th>
						<th>Satuan</th>
						<th>Jml Diminta</th>
			  		</tr>
			  		</thead>
				</table>	
				<br>
			</div>
			<div class="modal-footer">
				<button id="btnOk" class="btn btn-primary pull-right">OK</button>
				<?php echo form_open('logistik_farmasi/Frmcamprah/verifikasi_total'); ?>
					<input type="hidden" name="id_amprah" id="amprahid">
					<button class="btn btn-primary" type="submit">verif</button>
				<?php echo form_close(); ?>
				<!-- <span class="pull-right">&nbsp;&nbsp;</span>
				<button id="btnCetak" class="btn btn-primary pull-right">Lihat Faktur</button> -->
			</div>
	  	</div>
	</div>
	</div>
</div>

<?php
  $this->load->view('layout/footer_left.php');
?>