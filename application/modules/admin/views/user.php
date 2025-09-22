<?php
	$this->load->view('layout/header_left.php');
?>
<script type="text/javascript">
  $(document).ready(function() {
	//   $('#id_dokter').select2();
	  $('#select2').select2();

  });
	$('#browseBtn').on('click', function() {
	   $('#userfile').trigger('click');
	});  	
</script>
<style>
.canvas{
	border:1px solid #ccc;
	border-radius:10px;
}
#canvas2{
	border:1px solid #ccc;
	border-radius:10px;
}
</style>

<div class="row">
  	<div class="col-lg-12">
    	<div class="card card-outline-info">
      		<div class="card-header">
        		<h4 class="m-b-0 text-white">Form Input User</h4>
      		</div>
      		<div class="card-block">
            	<div class="col-md-12">
					<form id="idform" method="POST" enctype="multipart/form-data">	
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Username *</p>
							<div class="col-lg-6">
								<input type="text" class="form-control" placeholder=""  id="username" name="username" required>
								<input type="hidden" name="userid" id="userid" value=''>
							</div>
						</div>		
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Full Name *</p>
							<div class="col-lg-6">
								<input type="text" class="form-control" placeholder=""  id="name" name="name" required>
							</div>
						</div>								
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Password *</p>
							<div class="col-lg-6">
								<input type="password" class="form-control" placeholder="" name="password" id="password" required>
							</div>
						</div>		
						<div class="form-group row">
							<p class="col-lg-3 form-control-label">Retype Password *</p>
							<div class="col-lg-6">
								<input type="password" class="form-control" placeholder="" id="repassword" required>
							</div>
						</div>	
						<div class="form-group row">
							<label class="col-sm-3 control-label col-form-label"  for="signature">TTD User</label>
							<div class="col-sm-4">
							<canvas class="canvas"></canvas>
							</div>
						</div>

							<!--ini untuk upload photo  -->
						<!-- <div class="form-group row">
							<p class="col-lg-3 form-control-label">Photo</p>
							<div class="col-lg-6">						
								<div class="input-group">
									<span class="input-group-btn">
									    <span class="btn btn-info btn-flat" id="browseBtn">Browse</span>
									    <input name="userfile" onchange="$(this).parent().parent().find('.form-control').html($(this).val().split(/[\\|/]/).pop());" style="display: none;" type="file" accept="image/jpeg, image/png, image/gif" id="userfile">
									</span>
									<span class="form-control"></span>
								</div>															
							</div>
						</div>		 -->
						<input type="hidden" id="signatureValue" name="ttd">

						<div class="form-group row">
								<div class="offset-sm-3 col-sm-8">
									<button type="reset" class="btn waves-effect waves-light btn-danger"><i class="fa fa-eraser"></i> Reset</button>
									<button type="button" class="btn waves-effect waves-light btn-primary" id="btn_save"><i class="fa fa-floppy-o"></i> Simpan</button>
									<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
							</div>	
						</div>
					</form>
				</div>
      		</div>
    	</div>
  	</div>
</div>

<div class="row">
  	<div class="col-lg-12">
    	<div class="card card-outline-info">
      		<div class="card-header">
        		<h4 class="m-b-0 text-white">Daftar User</h4>
      		</div>
      		<div class="card-block">
        		<div class="table-responsive m-t-20">
					<table class="display nowrap table table-hover table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th></th>
								<th>Username</th>
								<th>Name</th>
								<th class="text-center">Roles</th>
								<th class="text-center">PPA</th>
								<th class="text-center">Dokter</th>
								<th class="text-center">Gudang</th>
								<th class="text-center">Poli</th>
								<th class="text-center">Ruangan</th>
								<th class="text-center">Hak Akses Kasir</th>
								<th class="text-center">Aksi</th>
							</tr>
						</thead>
					</table>
        		</div>
      		</div>
    	</div>
  	</div>
</div>

<!-- ModalDokter -->
<div class="modal fade" id="myModalDokter" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="formDokter" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="dokter_reload">&times;</button>
					<h4 class="modal-title" id="modalTitle"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="userid_dokter" class="col-4 col-form-label">User</label>
						<div class="col-sm-6">
							<div class="input-group">
								<input type="text" class="form-control" id="name_dokter" disabled>
							</div>
						</div>	
					</div>
					<input type="hidden" name="userid" id="userid_dokter">

					<div class="form-group row">
						<label  class="col-4 col-form-label">Dokter</label>
						<div class="col-sm-6">
						<div class="form-inline">
							<select class="form-control spil_dokter" id="select2" style="width: 100%" name="id_dokter">
								<option value="0">-- Pilih Dokter --</option>
								<?php 
								foreach($dokter as $row){
									echo '<option value="'.$row->id_dokter.'">'.$row->id_dokter.'.'.$row->nm_dokter.'</option>';
								}
								?>
							</select>
						</div>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="save_role"><i class="fa fa-floppy-o"></i> Simpan</button>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- ./ModalDokter -->

<!-- Modal PPA -->
<div class="modal fade" id="myModalPpa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form id="formPpa" method="POST">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="ppa_reload">&times;</button>
					<h4 class="modal-title" id="modalTitle"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group row">
						<label for="userid_ppa" class="col-4 col-form-label">User</label>
						<div class="col-sm-6">
							<div class="input-group">
								<input type="text" class="form-control" id="name_ppa" disabled>
							</div>
						</div>	
					</div>
					<input type="hidden" name="userid" id="userid_ppa">

					<div class="form-group row">
						<label  class="col-4 col-form-label">PPA</label>
						<div class="col-sm-6">
						<div class="form-inline">
							<select class="form-control spil_ppa" id="select2" style="width: 100%" name="ppa">
								<option value="0">-- Pilih PPA --</option>
								<?php 
								foreach($ppa as $row){
									echo '<option value="'.$row->id.'">'.$row->id.'.'.$row->ppa.'</option>';
								}
								?>
							</select>
						</div>
						</div>	
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="save_ppa"><i class="fa fa-floppy-o"></i> Simpan</button>
				</div>
			</div>
		</form>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- ./Modal PPA -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalTitle"></h4>
			</div>
			<div class="modal-body">							
				<div class="table-responsive">
					<form id="detailForm" >
						<table class="table table-striped table-bordered table-hover" id="detailTable">
							<thead>
								<tr>
									<th></th>
									<th></th>
									<th>Role</th>
								</tr>
							</thead>
						</table>
					</form>
				</div>
				<!-- /.table-responsive -->
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveSetting()" class="btn btn-primary" id="save_role"><i class="fa fa-floppy-o"></i> Simpan</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- modal -->
<div class="modal fade" id="myModalGdg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalTitleGdg"></h4>
			</div>
			<div class="modal-body">							
				<div class="table-responsive">
				<form id="detailFormGdg" >
					<table class="table table-striped table-bordered table-hover" id="detailTableGdg">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>Gudang</th>
							</tr>
						</thead>
					</table>
				</form>
				</div>
				<!-- /.table-responsive -->
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveSettingGdg()" class="btn btn-primary" id="save_gudang"><i class="fa fa-floppy-o"></i> Simpan</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" id="myModalPoli" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalTitlePoli"></h4>
			</div>
			<div class="modal-body">							
				<div class="table-responsive">
				<form id="detailFormPoli" >
					<table class="table table-striped table-bordered table-hover" id="detailTablePoli">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>Poliklinik</th>
							</tr>
						</thead>
					</table>
				</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveSettingPoli()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
			</div>
		</div>
	</div>
</div>
<!-- /.modal-dialog -->
<div class="modal fade" id="myModalRuang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalTitleRuang"></h4>
			</div>
			<div class="modal-body">							
				<div class="table-responsive">
				<form id="detailFormRuang" >
					<table class="table table-striped table-bordered table-hover" id="detailTableRuang">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>Ruangan</th>
							</tr>
						</thead>
					</table>
				</form>
				</div>
				<!-- /.table-responsive -->
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveSettingRuang()" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>
<!--- end panel -->

<div class="modal fade" id="myModalAkses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalTitleAkses"></h4>
			</div>
			<div class="modal-body">							
				<div class="table-responsive">
				<form id="detailFormAkses" >
					<table class="table table-striped table-bordered table-hover" id="detailTableAkses">
						<thead>
							<tr>
								<th></th>
								<th></th>
								<th>Akses</th>
							</tr>
						</thead>
					</table>
				</form>
				</div>
				<!-- /.table-responsive -->
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveSettingAkses()" class="btn btn-primary" id="save_akses"><i class="fa fa-floppy-o"></i> Save</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
</div>

								<!-- sample modal content -->
    <div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Reset Password</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="editForm" class="form-horizontal">
	                <div class="modal-body">
						<div class="row">
							<div class="col-md-12">										
									<div class="row">
										<div class="col-md-12">	
											<div class="form-group">
												<label class="control-label col-sm-4">Username</label>
												<div class="col-sm-8">
												          <input type="hidden" name="vuseridid" id="vuseridid">
													<input type="text" class="form-control" name="vusernamename" id="vusernamename">
													
												</div>
											</div>
										</div>
									</div>								
									<div class="row">
										<div class="col-md-12">	
											<div class="form-group">
												<label class="control-label col-sm-4">Name</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="vnamename" id="vnamename">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">	
											<div class="form-group">
												<label class="control-label col-sm-4">Password</label>
												<div class="col-sm-8">
													<input type="password" class="form-control" name="vpassword" id="vpassword" required>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">	
											<div class="form-group">
												<label class="control-label col-sm-4">Retype Password</label>
												<div class="col-sm-8">
													<input type="password" class="form-control" name="vrepassword" id="vrepassword" required>
												</div>
											</div>
										</div>
									</div>						
							</div>
						</div>
					</div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
						<button class="btn btn-info waves-effect" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
	                </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editModaluser" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Edit User</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                </div>
                <form id="editFormuser" class="form-horizontal">
	                <div class="modal-body">
						<div class="row">
							<div class="col-md-12">										
									<div class="row">
										<div class="col-md-12">	
											<div class="form-group">
												<label class="control-label col-sm-4">Username</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="vusernameuser" id="vusernameuser">
													<input type="hidden" name="vuseriduser" id="vuseriduser">
												</div>
											</div>
										</div>
									</div>								
									<div class="row">
										<div class="col-md-12">	
											<div class="form-group">
												<label class="control-label col-sm-4">Name</label>
												<div class="col-sm-8">
													<input type="text" class="form-control" name="vnameuser" id="vnameuser">
												</div>
											</div>
										</div>
									</div>				
							</div>
						</div>
					</div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
						<button class="btn btn-info waves-effect" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
	                </div>
                </form>
            </div>
        </div>
    </div>

	<div id="ttdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Tambah / Edit Tanda Tangan</b></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="ttdForm" class="form-horizontal">
	                <div class="modal-body">
					
						<div class="form-group row">                        
							<p class="col-sm-4 form-control-label">Username</p>
							<div class="col-sm-8">
								<input type="text" class="form-control" name="username" id="usernamettd" readonly>
								<input type="hidden" name="userid" id="useridttd">
							</div>
                        </div>
						<div class="form-group row">                        
							<p class="col-sm-4 form-control-label">TTD</p>
							<div class="col-sm-8">
								<canvas id="canvas2"></canvas>                        
							</div>
						</div>
						<div class="form-group row">                        
							<p class="col-sm-4 form-control-label">TTD DISIMPAN</p>
							<div class="col-sm-8">
							<!-- <input type="text" id="contohttd" > -->
							<img id="imagettd" name="my_image" alt="ttd belum ada" class="form-control" />                      
							</div>
						</div>
					</div>
					<input type="hidden" name="ttd" id="signatureValueDua">
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-error waves-effect" data-dismiss="modal">Close</button>
	                    <button type="button" class="btn btn-primary waves-effect" id="clear">Clear</button>
						<button class="btn btn-info waves-effect" type="submit"><i class="fa fa-floppy-o"></i> Simpan</button>
	                </div>
                </form>
            </div>
        </div>
    </div>





<?php
	$this->load->view('layout/footer_left.php');
?>


<script type='text/javascript'>

var canvas = document.querySelector("canvas");
var signaturePad = new SignaturePad(canvas);

var canvas2 = document.getElementById('canvas2');
var signaturePad2 = new SignaturePad(canvas2);

var context = canvas2.getContext('2d');

document.getElementById('clear').addEventListener('click', function() {
          context.clearRect(0, 0, canvas2.width, canvas2.height);
        }, false);

// var canvas2 = document.querySelector('canvas2');
// var signaturePad2 = new SignaturePad(canvas2);

// var canvasModal = document.querySelector("ttdModalCanvas");
// var signaturePadDua = new SignaturePad(canvasModal);

$(function() {
	objTable = $('#example').DataTable( {
			ajax: "<?php echo site_url('admin/userList'); ?>",
			columns: [
				{ data: "id" },
				{ data: "username" },
				{ data: "name" },
				{ data: "role" },
				{ data: "ppa" },
				{ data: "dokter" },
				{ data: "plus" },
				{ data: "poli" },
				{ data: "ruang" },
				{ data: "hakakses" },
				{ data: "aksi" }
			],
			columnDefs: [
				{ targets: [ 0 ], visible: false }
			]	
		} );	
		$('#dokter_reload').on('click', function(e) {
			// e.preventDefault();
			// $('#myModalDokter').modal('hide');
			window.location.reload();
		});	
	
	$(":reset").click(function(){		
		$("#username").prop('disabled', false);
	});	
	$('#username').keypress(function( e ) {
    if(e.which === 32) 
        return false;
	});
	$( "#username" ).change(function() {
		var vnip = $("#username").val();
		$.ajax({
		  dataType: "json",
		  type: 'POST',
		  data: {id:vnip},
		  url: '<?php echo site_url('admin/userExist'); ?>',
		  success: function( response ) {
			if (response.exist){
				alert("Username "+vnip+" sudah terdaftar!");
				$("#username").val('');
				$('#username').focus();
			}
		  }
		})
	});
	$( "#password" ).change(function() {
		if ( ($('#password').val()!= '') && ($('#repassword').val() != '' )){
			if ( $('#password').val() != $('#repassword').val() ){
			alert('Please retype, password is missmatch!');
				$('#password').val('');
				$('#repassword').val('');
				$('#password').focus();
			}
		}
	});
	$( "#repassword" ).change(function() {
		if ( ($('#password').val()!= '') && ($('#repassword').val() != '' )){
			if ( $('#password').val() != $('#repassword').val() ){
				alert('Please retype, password is missmatch!');
				$('#password').val('');
				$('#repassword').val('');
				$('#password').focus();
			}
		}
	});
	$('#btn_save').on('click', function (e) {
		var signature =	signaturePad.toDataURL();
		$('#signatureValue').val(signature);
		document.getElementById("btn_save").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Saving...';
		var formData = new FormData($('#idform')[0]);
		$.ajax({
			dataType: "JSON",
			type: 'POST',
			// async: true,
			cache: false,
			contentType: false,
			processData: false,
			url: "<?php echo base_url('admin/user_insert'); ?>",
			data: formData,
			success: function (response) {
				if(response.success){ 
					document.getElementById("btn_save").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					objTable.ajax.reload();
					$("#idform")[0].reset();
					swal("Sukses","Input User Berhasil.", "success");
				} else {
				document.getElementById("btn_save").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				if(response.msg){
					swal("Error",response.msg, "error");
					return;
				}
					swal("Error","Input User Gagal.", "error");
				}
			}
		});	
	});
	
	//=========== When (modal) POP-UP closed, remove class from TR Grid =================
	$('#myModal').on('hidden.bs.modal', function (e) {
		$("tr").removeClass('detailselected');
	});
	
		
	$('#editModal').on('shown.bs.modal', function(e) {
		e.preventDefault();
		$("#editForm")[0].reset();		
		var id = $(e.relatedTarget).data('id');
		var nm = $(e.relatedTarget).data('username');
		var namalengkap = $(e.relatedTarget).data('name');
		// console.log (id);
                    // console.log (nm);
		// console.log (namalengkap);

		$('#vuseridid').val(id);
		$('#vusernamename').val(nm);
		$('#vnamename').val(namalengkap);
		$( "#vpassword" ).focus();
				
	});
	

		
	$('#editModaluser').on('shown.bs.modal', function(e) {
		e.preventDefault();
		$("#editFormuser")[0].reset();		
		var id = $(e.relatedTarget).data('id');
		var nm = $(e.relatedTarget).data('username');
		var namalengkap = $(e.relatedTarget).data('name');
		console.log (id);
                    console.log (nm);
		console.log (namalengkap);
		$('#vuseriduser').val(id);
		$('#vusernameuser').val(nm);
		$('#vnameuser').val(namalengkap);
				
	});
		
	/**/
		$('#editForm').on('submit', function (e) {
			e.preventDefault();
			if ( ($('#vpassword').val()!= '') && ($('#vrepassword').val() != '' )){
				if ( $('#vpassword').val() != $('#vrepassword').val() ){
					alert('Please retype, password is missmatch!');
					$('#vpassword').val('');
					$('#vrepassword').val('');
					$('#vpassword').focus();
				}else{
					//alert("<?php echo site_url(); ?>");
					
					$.ajax({
						type: 'POST',
						data: $('#editForm').serialize(),
						url: '<?php echo site_url(); ?>/admin/reset_password',
						dataType: "json",
						success: function (response) {
							//alert(JSON.stringify(response));
							if(response.success){						
								objTable.ajax.reload();
								$('#editModal').modal('hide');
								swal("Sukses","Reset Password Berhasil.", "success"); 												
							} else {
								if(response.msg){
									swal("Error",response.msg, "error");
									return;
								}
								swal("Error","Reset Password Gagal.", "error"); 	
							}
						}
					});
				}
			}else{				
				$('#editModal').modal('hide');
			}			
		});

		$('#editFormuser').on('submit', function (e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				data: $('#editFormuser').serialize(),
				url: '<?php echo site_url(); ?>/admin/edit_user',
				dataType: "json",
				success: function (response) {
					//alert(JSON.stringify(response));
					if(response.success){						
						objTable.ajax.reload();
						$('#editModaluser').modal('hide');
						swal("Sukses","Edit User Berhasil.", "success"); 												
					} else {
						swal("Error","Edit User Gagal.", "error"); 	
					}
				}
			});		
		});
		
		$('#ttdModal').on('shown.bs.modal', function(e) {
			e.preventDefault();
			$("#ttdForm")[0].reset();		
			var id = $(e.relatedTarget).data('id');
			var nm = $(e.relatedTarget).data('username');
			var ttd = $(e.relatedTarget).data('ttd');
			$('#useridttd').val(id);
			$('#usernamettd').val(nm);
			$('#imagettd').attr("src",ttd);
			// $('#contohttd').val(ttd);
		});

		

		// ttdForm
		$('#ttdForm').on('submit', function (e) {
			var signaturedua =	signaturePad2.toDataURL();
			$('#signatureValueDua').val(signaturedua);
			e.preventDefault();
			$.ajax({
				type: 'POST',
				data: $('#ttdForm').serialize(),
				url: '<?php echo site_url(); ?>/admin/update_ttd',
				dataType: "json",
				success: function (response) {
					// alert(JSON.stringify(response));
					
					if(response.success){						
						objTable.ajax.reload();
						$('#ttdModal').modal('hide');
						swal("Sukses","Tanda Tangan Berhasil Disimpan.", "success"); 												
					} else {
						swal("Error","Tanda Tangan Gagal Disimpan.", "error"); 	
					}
				}
			});
		});

});

function setUserPpa(vid,vname){
	$('#userid_ppa').val(vid);
	$('#name_ppa').val(vname);
	$.ajax({
		type: 'POST',
		data : {'userid':vid},
		url : '<?php echo site_url(); ?>admin/cek_ppa',
		dataType: "json",
		success: function (response) {
				$('.spil_ppa option[value='+response.kode.ppa+']').attr('selected','selected').change();						
		}
	});
}



function setUserDokter(vid,vname){
	$('#userid_dokter').val(vid);
	$('#name_dokter').val(vname);
	$.ajax({
		type: 'POST',
		data : {'userid':vid},
		url : '<?php echo site_url(); ?>admin/cek_dokter',
		dataType: "json",
		success: function (response) {	
			console.log(response.kode.id_dokter == "0");
			console.log(response.kode.id_dokter);
			console.log(response);
			
				$('.spil_dokter option[value='+response.kode.id_dokter+']').attr('selected','selected').change();
										
															
		}
	});
}


var objTable2;
function setUserRole(vid,vname){
	if (objTable2!= null)
		objTable2.destroy();

	objTable2 = $('#detailTable').DataTable( {
		ajax: "<?php echo site_url('admin/userRoleList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='radio' name='checkApp' value='"+vid+"' id='"+row.id+"'/><label for='"+row.id+"'></label>";
						}else{
							return "<input type='radio' name='checkApp' value='"+vid+"' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "role" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitle').html( "Role for User : <strong>"+vname+"</strong>");
}

var objTable3;
function setUserGudang(vid,vname){
	if (objTable3!= null)
		objTable3.destroy();

	objTable3 = $('#detailTableGdg').DataTable( {
		ajax: "<?php echo site_url('admin/userGdgList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkGdg' value='"+vid+"' onchange='chooseApp(this)'id='"+row.id+"'/><label for='"+row.id+"'></label>";
						}else{
							return "<input type='checkbox' name='checkGdg' value='"+vid+"' onchange='chooseApp(this)' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
						}
					}
					return data;
					
				},
				className: "dt-body-center"
			},
			{ data: "nama" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitleGdg').html( "Gudang Access for User : <strong>"+vname+"</strong>");
}

var objTable4;
function setUserPoli(vid,vname){
	if (objTable4!= null)
		objTable4.destroy();

	objTable4 = $('#detailTablePoli').DataTable( {
		ajax: "<?php echo site_url('admin/userPoliList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkPoli' value='"+vid+"' onchange='chooseApp(this)'id='"+row.id+"'/><label for='"+row.id+"'></label>";
						}else{
							return "<input type='checkbox' name='checkPoli' value='"+vid+"' onchange='chooseApp(this)' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "nama" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitlePoli').html( "Poli Access for User : <strong>"+vname+"</strong>");
}

var objTable5;
function setUserRuang(vid,vname){
	if (objTable5!= null)
		objTable5.destroy();

	objTable5 = $('#detailTableRuang').DataTable( {
		ajax: "<?php echo site_url('admin/userRuangList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkRuang' value='"+vid+"' onchange='chooseApp(this)' id='"+row.id+"'/><label for='"+row.id+"'></label>";
						}else{
							return "<input type='checkbox' name='checkRuang' value='"+vid+"' onchange='chooseApp(this)' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "nama" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	
	$('#modalTitleRuang').html( "Ruang Access for User : <strong>"+vname+"</strong>");
}

var objTable6;
function setUserAkses(vid,vname){
	if (objTable6!= null)
		objTable6.destroy();

	objTable6 = $('#detailTableAkses').DataTable( {
		ajax: "<?php echo site_url('admin/userAksesList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='radio' name='checkApp1' value='"+vid+"' id='"+row.id+"'/><label for='"+row.id+"'></label>";
						}else{
							return "<input type='radio' name='checkApp1' value='"+vid+"' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "kasir" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], orderable: false },
			{ targets: [ 2 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false
	} );	

	$('#modalTitleAkses').html( "Grant Access for User : <strong>"+vname+"</strong>");
}

    $(document).on("click",".delete_user",function() {
      var getLink = $(this).attr('href');
      swal({
        title: "Hapus User",
        text: "Yakin akan menghapus user tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Hapus",
        showLoaderOnConfirm: true,
        closeOnConfirm: true
        }, function() {
			$.ajax({
				type: 'POST',
				url: getLink,
				dataType:'JSON',
				success: function(response) {
					if (response.success){
						objTable.ajax.reload();
						swal("Sukses","Berhasil menghapus data.", "success"); 
					}else swal("Error","Gagal menghapus data.", "error"); 
				}
			});           
      });
      return false;
    });


	// 

// added ->aldi
// save for setting user dokter
$('#formPpa').on('submit',function(e){
	e.preventDefault();
	// alert('hello world');
	document.getElementById("save_ppa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
	
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userSavePpa'); ?>',
		data: $('form#formPpa').serialize(),
		dataType:'json',
		success: function( response ) {
			if (response.kode){ 
				document.getElementById("save_ppa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				$('#myModalPpa').modal('hide');
				// swal("Sukses","Assign Dokter Berhasil.", "success");
				swal({
					title: "Sukses!", 
					text: "Assign PPA Berhasil.", 
					type: "success"
					},
				function(){ 
					location.reload();
				}
				);
				
			}else {
				document.getElementById("save_ppa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				// swal("Error","Assign Dokter Gagal.", "error");
				swal({
					title: "Error!", 
					text: "Assign PPA Gagal.", 
					type: "error"
					},
				function(){ 
					location.reload();
				}
				);
				window.location.reload();
			}
		}
	});	
});

// added ->aldi
// save for setting user dokter
$('#formDokter').on('submit',function(e){
	e.preventDefault();
	// alert('hello world');
	document.getElementById("save_role").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
	
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userSaveDokter'); ?>',
		data: $('form#formDokter').serialize(),
		dataType:'json',
		success: function( response ) {
			if (response.kode){ 
				document.getElementById("save_role").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				$('#myModalDokter').modal('hide');
				// swal("Sukses","Assign Dokter Berhasil.", "success");
				swal({
					title: "Sukses!", 
					text: "Assign Dokter Berhasil.", 
					type: "success"
					},
				function(){ 
					location.reload();
				}
				);
				
			}else {
				document.getElementById("save_role").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				// swal("Error","Assign Dokter Gagal.", "error");
				swal({
					title: "Error!", 
					text: "Assign Dokter Gagal.", 
					type: "error"
					},
				function(){ 
					location.reload();
				}
				);
				window.location.reload();
			}
		}
	});	
});



function saveSetting(){
	document.getElementById("save_role").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
	var vdata = [];
	var checkApp = $("#detailForm input:radio");
	var x=0;
	for (var i = 0; i < checkApp.length; i++) {
		if (checkApp[i].checked) {
			vdata[x] = {"roleid":objTable2.column( 0 ).data()[i],"userid":checkApp[i].value,"role":objTable2.column( 2 ).data()[i]};	
			x++;
		}
	}
	
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userRoleSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				document.getElementById("save_role").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				$('#myModal').modal('hide');
				swal("Sukses","Assign Role Berhasil.", "success");
			}else {
				document.getElementById("save_role").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				swal("Error","Assign Role Gagal.", "error");
			}
		}
	});	
}

function saveSettingAkses(){
	document.getElementById("save_akses").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
	var vdata = [];
	var checkApp1 = $("#detailFormAkses input:radio");
	var x=0;
	for (var i = 0; i < checkApp1.length; i++) {
		if (checkApp1[i].checked) {
			vdata[x] = {"idkasir":objTable6.column( 0 ).data()[i],"userid":checkApp1[i].value,"kasir":objTable6.column( 2 ).data()[i]};	
			x++;
		}
	}
	
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userAksesSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				document.getElementById("save_akses").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				$('#myModalAkses').modal('hide');
				swal("Sukses","Hak akses kasir Berhasil.", "success");
			}else {
				document.getElementById("save_kasir").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				swal("Error","Hak Akses Gagal.", "error");
			}
		}
	});	
}

function saveSettingGdg(){
	document.getElementById("save_gudang").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
	var vdata = [];
	var checkGdg = $("#detailFormGdg input:checkbox");
	var x=0;
	for (var i = 0; i < checkGdg.length; i++) {
		var uname=checkGdg[i].value;
		if (checkGdg[i].checked) {
			vdata[x] = {"id_gudang":objTable3.column( 0 ).data()[i],"userid":checkGdg[i].value,"nama_gudang":objTable3.column( 2 ).data()[i]};	
			x++;
		}
	}
	if(x==0){
		//delete
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userGdgDelete'); ?>',
		data: {vdata:uname},
		dataType:'json',
		success: function( response ) {			
			if (response.success){ 
				document.getElementById("save_gudang").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				$('#myModalGdg').modal('hide');
				swal("Sukses","Akses Gudang Berhasil.", "success");
			}else {
				document.getElementById("save_gudang").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				swal("Error","Akses Gudang Gagal.", "error");
			}
		}
	});
	}else{
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userGdgSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				document.getElementById("save_gudang").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				$('#myModalGdg').modal('hide');
				swal("Sukses","Akses Gudang Berhasil.", "success");
			}else {
				document.getElementById("save_gudang").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
				swal("Error","Akses Gudang Gagal.", "error");
			}
		}
	});
	}
}

function saveSettingPoli(){
	var vdata = [];
	var checkPoli = $("#detailFormPoli input:checkbox");
	var x=0;
	for (var i = 0; i < checkPoli.length; i++) {
		var uname=checkPoli[i].value;
		if (checkPoli[i].checked) {
			vdata[x] = {"id_poli":objTable4.column( 0 ).data()[i],"userid":checkPoli[i].value,"nm_poli":objTable4.column( 2 ).data()[i]};	
			x++;
		}
	}
	//alert(x);
	if(x==0){
		//delete
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userPoliDelete'); ?>',
		data: {vdata:uname},
		dataType:'json',
		success: function( response ) {
				alert("Akses Poli Berhasil");
				$('#myModalPoli').modal('hide');			
		}
	});
	}else{
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userPoliSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			if (response.success){ 
				alert("Akses Poli Berhasil");
				$('#myModalPoli').modal('hide');
			}else 
				alert("Akses Poli Gagal");
		}
	});
	}
}

function saveSettingRuang(){
	var vdata = [];
	var checkRuang = $("#detailFormRuang input:checkbox");
	var x=0;
	for (var i = 0; i < checkRuang.length; i++) {
		var uname=checkRuang[i].value;
		if (checkRuang[i].checked) {			
			vdata[x] = {"id_ruang":objTable5.column( 0 ).data()[i],"userid":checkRuang[i].value,"nm_ruang":objTable5.column( 2 ).data()[i]};	
			x++;
		}
	}
	if(x==0){
		//delete
		$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/userRuangDelete'); ?>',
		data: {vdata:uname},
		dataType:'json',
		success: function( response ) {
			//if (response.success){ 
				alert("Akses Ruang Berhasil");
				$('#myModalRuang').modal('hide');
			//}else 
			//	alert("Akses Gudang Gagal");
		}
	});
	}else{
		$.ajax({		
			type: 'POST',					
			url: '<?php echo site_url('admin/userRuangSave'); ?>',
			data: {vdata:vdata},
			dataType:'json',
			success: function( response ) {
				if (response.success){ 
					alert("Akses Ruang Berhasil");
					$('#myModalRuang').modal('hide');
				}else 
					alert("Akses Ruang Gagal");
			}
		});
	}
}
</script>