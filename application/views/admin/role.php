<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>

<div class="row">
  	<div class="col-lg-4">
    	<div class="card card-outline-info">
      		<div class="card-header">
        		<h4 class="m-b-0 text-white">Form Input</h4>
      		</div>
      		<div class="card-block">
				<hr/>
				<form id="idform" action="<?php echo site_url('admin/roleSave'); ?>" method="post">	
					<div class="form-group row">
						<p class="col-sm-4 form-control-label">Role *</p>
						<div class="col-sm-8">
							<input type="text" class="form-control" placeholder="" name="role"  id="role" required>
							<input type="hidden" name="id" id="id" value=''>
						</div>
					</div>								
					<div class="form-group row">
						<p class="col-sm-4 form-control-label">Deskripsi *</p>
						<div class="col-sm-8">
							<textarea class="form-control" rows="2" placeholder="" name="deskripsi" id="deskripsi" required></textarea>
						</div>
					</div>	
					<div class="form-group row">
						<div class="col-sm-4">
						</div>
						<div class="col-sm-8">
							<div class="form-inline">
								<button type="reset" class="btn btn-primary">Reset</button>&nbsp;
								<button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
								<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
							</div>
						</div>	
					</div>
				</form>
      		</div>
    	</div>
  	</div>
  	<div class="col-lg-8">
    	<div class="card card-outline-info">
      		<div class="card-header">
        		<h4 class="m-b-0 text-white">Daftar Role</h4>
      		</div>
      		<div class="card-block">	
        		<div class="table-responsive m-t-20">				
					<table class="display nowrap table table-hover table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th></th>
								<th>Role</th>
								<th>Deskripsi</th>
								<th>Access</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
					</table>
				</div>
      		</div>
    	</div>
  	</div>
</div>
<div id="dialog-confirm"></div>
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
								<th>urutan</th>
								<th></th>
								<th>Menu</th>
							</tr>
						</thead>
					</table>
				</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="saveSetting()" class="btn btn-primary" id="btn-simpan"><i class="fa fa-floppy-o"></i> Simpan</button>
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


<script type='text/javascript'>
$(function() {
	$( "#dialog-confirm" ).hide();
	objTable = $('#example').DataTable( {
		ajax: "<?php echo site_url('admin/roleList'); ?>",
		columns: [
			{ data: "id" },
			{ data: "role" },
			{ data: "deskripsi" },
			{ data: "access" },
			{ data: "edit" },
			{ data: "drop" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false }
		]	
	});	
	
	$('#btnSimpan').click(function(){
		$.ajax({
			data: {id:$('#role').val()},
			type: 'POST',
			url: '<?php echo site_url('admin/roleExist'); ?>',
			dataType:'json',
			success: function( response ) {
				if (response.exist){
					$( "#dialog-confirm" ).html("Sudah ada role dengan nama yang sama!");
					$( "#dialog-confirm" ).dialog({
					  resizable: false,
					  modal: true,
					  buttons: {
						"Oke": function() {
							$( this ).dialog( "close" );
							$('#role').focus();
						}
					  }
					});
				}else{										  
					$.ajax({			
						type: 'POST',				
						url: $('#idform').attr( 'action' ),
						data: $('#idform').serialize(),
						dataType:'json',
						success: function( response ) {
							if (response.success) window.location.reload(true);
							else alert("Gagal menambahkan data");
						}
					});							
				}
			}
		});
	});
	//=========== When (modal) POP-UP closed, remove class from TR Grid =================
	$('#myModal').on('hidden.bs.modal', function (e) {
		$("tr").removeClass('detailselected');
	});
});

var objTable2;
function setAccessRole(vid,vname){
	if (objTable2!= null)
		objTable2.destroy();

	objTable2 = $('#detailTable').DataTable( {
		ajax: "<?php echo site_url('admin/roleMenuList'); ?>/"+vid,
		columns: [
			{ data: "id" },
			{ data: "urutan" },
			{
				data:   "sts",
				render: function ( data, type, row ) {
					if ( type === 'display' ) {
						if (data==0){
							return "<input type='checkbox' name='checkApp' value='"+vid+"' onchange='chooseApp(this)'id='"+row.id+"'/><label for='"+row.id+"'></label>";
						}else{
							return "<input type='checkbox' name='checkApp' value='"+vid+"' onchange='chooseApp(this)' id='"+row.id+"' checked/><label for='"+row.id+"'></label>";
						}
					}
					return data;
				},
				className: "dt-body-center"
			},
			{ data: "menu" }
		],
		columnDefs: [
			{ targets: [ 0 ], visible: false },
			{ targets: [ 1 ], visible: false, orderable: false },
			{ targets: [ 2 ], orderable: false },
			{ targets: [ 3 ], orderable: false }
		],
		paging: false,			
		searching: false,
		autoWidth: false,
		order: [[ 1, "asc" ]]			
	} );	
	$('#modalTitle').html( "Set Access Menu for Role : <strong>"+vname+"</strong>");
}

function saveSetting() {
	document.getElementById("btn-simpan").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
	var vdata = [];
	var checkApp = $("#detailForm input:checkbox");
	var x=0;
	for (var i = 0; i < checkApp.length; i++) {
		if (checkApp[i].checked) {
			vdata[x] = {"menu_id":objTable2.column( 0 ).data()[i],"role_id":checkApp[i].value,"menu":objTable2.column( 3 ).data()[i]};	
			x++;
		}
	}
	
	$.ajax({		
		type: 'POST',					
		url: '<?php echo site_url('admin/roleMenuSave'); ?>',
		data: {vdata:vdata},
		dataType:'json',
		success: function( response ) {
			document.getElementById("btn-simpan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			if (response.success){ 				
				$('#myModal').modal('hide');
				swal("Sukses", "Access Menu Berhasil Disimpan.", "success");				
			}else 
				swal("Error", "Access Menu Gagal.", "error");
		}
	});	
}
</script>