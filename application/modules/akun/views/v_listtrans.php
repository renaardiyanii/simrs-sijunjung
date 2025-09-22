<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
var table;
$(function() {
	$("#divDetail").css("display", "");
	$('.datepicker').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true
	});  

/*<th>No</th>
				  	<th>No</th>
					<th>No BK</th>
					<th>Uraian</th>
					<th>Bulan</th>
					<th>Tgl transaksi</th>
					<th>Total Debet</th>
					<th>Total Kredit</th>
					<th>Aksi</th>*/
	table = $('#example').DataTable({
		ajax: "<?php echo site_url(); ?>akun/crsakun/get_trans_list",
		columns: [
			{ data: "kode_trans" },
			{ data: "no" },
			{ data: "no_bk" },
			{ data: "uraian" },
			{ data: "bulan" },
			{ data: "tgl_transaksi" },
			{ data: "total_debit" },
			{ data: "total_kredit" },
			{ data: "aksi" }
		],
		bFilter: true,
		bPaginate: true,
		destroy: true,
		order:  [[ 0, "desc" ]]
	});

	
	$('#btnCari').click(function(){
		$.ajax({
			url: '<?php echo site_url(); ?>akun/crsakun/get_trans_list',
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
	
	
	$('#btnReset').click(function(){
		$('#tgl1').prop('disabled',false);
		$('#gd_asal').prop('disabled',false);
		$('#gd_dituju').prop('disabled',false);
		$('#id_amprah').focus();
	});
	
	$('#btnOk').click( function() {
		$('#detailModal').modal('hide');
	});
	
});

function deleteheader(idbukas_header){
	$.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'akun/crsakun/delete_bukasheader'; ?>",
	        dataType: "JSON",
	        data: {idbukas_header:idbukas_header},
	        success: function(data){   
			    if (data == false ) {
			        swal("Error", "Gagal menghapus Transaksi. Silahkan coba lagi.", "error");
			    } else {
			    	table.clear();
			    	table.draw();
					swal("Sukses", "Transaksi berhasil dihapus.", "success");
			    }
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	swal("Error", "Gagal menghapus Transaksi. Silahkan coba lagi.", "error");       
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        },
	        timeout: 0
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
						<div class="col-sm-6">
						  <a class="btn btn-default" href="<?php echo site_url('akun/crsakun/intrans');?>"><i class="fa fa-plus"> &nbsp;Tambah Transaksi</i> </a>	
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Tanggal Transaksi</label>
						<div class="col-sm-3">
							<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
						  		<input type="text" class="form-control datepicker" name="tglawal" id="tglawal" >
							</div>
						</div>
						<label class="col-sm-1 control-label">s/d</label>
						<div class="col-sm-3">
							<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
						  		<input type="text" class="form-control datepicker" name="tglakhir" id="tglakhir" >
						  	</div>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-9">
						  <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
						  <button type="reset" id="btnReset" class="btn btn-warning">Reset</button>
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
				  	<th>No. header</th>
				  	<th>No</th>
					<th>No BK</th>
					<th>Uraian</th>
					<th>Bulan</th>
					<th>Tgl transaksi</th>
					<th>Total Debet</th>
					<th>Total Kredit</th>
					<th>Aksi</th>
				  </tr>
				  </thead>
				</table>		
			</div>
        </div>
      	</div>
    </div>
</div>

<?php
  $this->load->view('layout/footer_left.php');
?>