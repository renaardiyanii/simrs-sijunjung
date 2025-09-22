<?php
  $this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
var idbukas_header="<?php echo $idbukas_header;?>"
var table_detail;
	$(function() {
		$(".select2").select2();
		$('.datepicker').datepicker({
	      format: "yyyy-mm-dd",
	      endDate: '0',
	      autoclose: true,
	      todayHighlight: true,
	    });

		if(idbukas_header!=''){
			$('#idbukas_header').val(idbukas_header);
			$('#idbukas_header1').val(idbukas_header);
			$.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'akun/crsakun/get_bukasheader_data'; ?>",
		        dataType: "JSON",
		        data: {idbukas_header:idbukas_header},
		        success: function(data){
				    if (data != null ) {
				    	$("#no_bk").val(data[0].no_bk);
				    	$("#tgl_transaksi").val(data[0].tgl_transaksi);
				    	$("#deskripsi").val(data[0].uraian);
				    	$("#kode_manggaran").val(data[0].kode_mataanggaran).change();
				    	tabeldetail(idbukas_header);
				    } else {
						swal("Error", "Gagal mengambil data Transaksi. Silahkan coba lagi.", "error");	        	
				    }
		        },
		        error:function(event, textStatus, errorThrown) {       
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        },
		        timeout: 0
	    	});
		}

		// table_detail = $('#table-detail').DataTable({ });

		$("#frmAddHeader").submit(function(event) {
			//alert('aaaaa');
	    //document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
	    $.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'akun/crsakun/insert_bukasheader'; ?>",
	        dataType: "JSON",
	        data: $('#frmAddHeader').serialize(),
	        success: function(data){   
			    if (data != null ) {
			    	document.getElementById("btnAddHeader").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			    	$('#idbukas_header').val(data);
			    	$('#idbukas_header1').val(data);
			    	if(idbukas_header==''){
			    		tabeldetail(data);
			    	}else{
			    		tabeldetail(idbukas_header);
			    	}
			        
			        swal("Sukses", "Transaksi berhasil disimpan.", "success");
			    } else {
			    	document.getElementById("btnAddHeader").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					swal("Error", "Gagal menginput Transaksi. Silahkan coba lagi.", "error");	        	
			    }
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btnAddHeader").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        },
	        timeout: 0
	    });
	  	event.preventDefault();
		});


		$("#detailModal").on("hidden.bs.modal", function(){
    		$("#frmAddDetail")[0].reset();
    		$('#id_norek').val('').change();
		});

		$("#frmAddDetail").submit(function(event) {
		    $.ajax({
		        type: "POST",
		        url: "<?php echo base_url().'akun/crsakun/insert_bukasdetail'; ?>",
		        dataType: "JSON",
		        data: $('#frmAddDetail').serialize(),
		        success: function(data){   
				    if (data != null ) {
				    	if(idbukas_header==''){
				    		tabeldetail($('#idbukas_header').val());
				    	}else{
				    		tabeldetail(idbukas_header);
				    	}
				        $('#detailModal').modal('hide');
				        swal("Sukses", "Transaksi berhasil disimpan.", "success");
				    } else {
						swal("Error", "Gagal menginput Transaksi. Silahkan coba lagi.", "error");	        	
				    }
		        },
		        error:function(event, textStatus, errorThrown) {       
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        },
		        timeout: 0
		    });
		  	event.preventDefault();
		});
		

	});

function tabeldetail(idbukas_header){
    table = $('#table-detail').DataTable({
        ajax: "<?php echo site_url();?>akun/crsakun/get_bukas_detail/"+idbukas_header,
        columns: [
            { data: "no" },
            { data: "no_rek" },
            { data: "debit" },
            { data: "kredit" },
            { data: "aksi"}
        ],
        columnDefs: [
            { targets: [ 0 ], visible: true },
             { targets: 4 , width: "10%" }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	 });
}

function editdetail(idbukas_detail,id_norek,debit,kredit){
	$('#detailModal').modal('show');

	$('#id_norek').val(id_norek).change();
	$('#debit').val(debit);
	$('#kredit').val(kredit);
	$('#idbukas_detail').val(idbukas_detail);
}

function deletedetail(idbukas_detail){
	$.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'akun/crsakun/delete_bukasdetail'; ?>",
	        dataType: "JSON",
	        data: {idbukas_detail:idbukas_detail},
	        success: function(data){   
			    if (data != null ) {
			        swal("Error", "Gagal menghapus Detail Transaksi. Silahkan coba lagi.", "error");
			    } else {
			    	tabeldetail(data);
					swal("Sukses", "Transaksi berhasil disimpan.", "success");
			    }
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	swal("Error", "Gagal menghapus Detail Transaksi. Silahkan coba lagi.", "error");       
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
				<form id="frmAddHeader" class="form-horizontal">
					<div class="form-group row">
						<label class="col-sm-3 control-label">Nomor Transaksi</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" name="no_bk" id="no_bk" required>
							<input type="hidden" class="form-control" value="<?php echo $idbukas_header;?>" name="idbukas_header1" id="idbukas_header1" >
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Tanggal Transaksi</label>
						<div class="col-sm-3">
							<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa fa-calendar"></i>
				          	</div>
						  		<input type="text" class="form-control datepicker" name="tgl_transaksi" id="tgl_transaksi" required>
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Deskripsi</label>
						<div class="col-sm-5">
							<textarea class="form-control" name="deskripsi" id="deskripsi" cols="30" rows="5" style="resize:vertical" required></textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Mata Anggaran</label>
						<div class="col-sm-5">							  
						  <select name="kode_manggaran" id="kode_manggaran" class="form-control select2" style="width:100%" required="">
							<option value="" selected>---- Pilih Mata Anggaran ----</option>
							<?php
							  foreach($mataanggaran as $row){
								echo '<option value="'.$row->kode_manggaran.'"';
								if($row->status=='Nonaktif'){
									echo 'disabled';
								}
								echo '>'.$row->kode_manggaran.' - '.$row->nm_manggaran.'</option>';
							  }
							?>
						  </select>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-9">
						  <button type="submit" id="btnAddHeader" class="btn btn-primary">Simpan</button>
						  <button type="reset" id="btnReset" class="btn btn-warning">Reset</button>
						</div>
					</div>					
				</form>	
			</div>
		</div>
	</div>
	</div>
</div>
<br>
<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card card-outline-danger">
			<div class="card-header">
				<button class="btn btn-default list-inline pull-right" data-toggle="modal" data-target="#detailModal"><i class="fa fa-plus"> &nbsp;Input</i></button>
				<h4 class="card-title text-white">Detail Transaksi</h4>
						  
			</div>
			<div class="card-block">
				<table id="table-detail" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				  <thead>
				  <tr>
				  	<th>No</th>
					<th>No Rekening</th>
					<th>Debet</th>
					<th>Kredit</th>
					<th>Aksi</th>
				  </tr>
				  </thead>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-default modal-lg">
	  	<!-- Modal content-->
	  	<div class="modal-content">
			<div class="modal-header">
			  	<h4 class="modal-title"></h4>
			  	<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">							
				<form id="frmAddDetail" class="form-horizontal">
					<div class="form-group row">
						<label class="col-sm-3 control-label">Nomor Rekening</label>
						<div class="col-sm-5">
							<select name="id_norek" id="id_norek" class="form-control select2" style="width:100%" required="">
							<option value="" selected>---- Pilih Nomor Rekening ----</option>
							<?php
							  foreach($norek as $row){
								echo '<option value="'.$row->id_norek.'">'.$row->jns_bank.' - '.$row->no_rek.'</option>';
							  }
							?>
						  </select>
							<input type="hidden" class="form-control" name="idbukas_header" id="idbukas_header" >
							<input type="hidden" class="form-control" name="idbukas_detail" id="idbukas_detail" >
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Nominal Debet</label>
						<div class="col-sm-5">
							<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa">Rp.</i>
				          	</div>
						  		<input type="number" class="form-control" value=0 name="debit" id="debit" >
							</div>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label">Nominal Kredit</label>
						<div class="col-sm-5">
							<div class="input-group">
				          	<div class="input-group-addon">
				            	<i class="fa">Rp.</i>
				          	</div>
						  		<input type="number" class="form-control" value=0 name="kredit" id="kredit" >
							</div>
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-sm-3">
						</div>
						<div class="col-sm-9">
						  <button type="submit" id="btnAddDetails" class="btn btn-primary">Simpan</button>
						  <button type="reset" id="btnReset" class="btn btn-warning">Reset</button>
						</div>
					</div>					
				</form>
			</div>
			<div class="modal-footer">
				
			</div>
	  	</div>
	</div>
	</div>
<?php
  $this->load->view('layout/footer_left.php');
?>