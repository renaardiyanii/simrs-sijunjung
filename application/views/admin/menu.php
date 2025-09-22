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
				<button class="btn btn-warning" id="btnAdd">Tambah Menu Baru</button>
				<hr/>
				<form id="idform" class='form-horizontal' action="<?php echo site_url('admin/menuSave'); ?>" method="post">
					<input type="hidden" id="id" name="id"/>
					<div class='form-group'>		
						<div class="col-sm-2"><label>Title</label></div>
						<div class='col-sm-12'><input type="text" id="title" name="title" class="form-control" /></div>
					</div>   
					<div class='form-group'>		
						<div class="col-sm-2"><label>URL</label></div>
						<div class='col-sm-12'><input type="text" id="url" name="url" class="form-control" /></div>
					</div>   
					<div class='form-group'>		
						<div class="col-sm-2"><label>Parent</label></div>
						<div class='col-sm-12'>								
							<?php 
								echo form_dropdown(
								array(
									'name'=>'parent_id',
									'id'=>'parent_id',
									'class'=>'form-control'), 
								$parents, 
								' ');
							?>
						</div>
					</div>   
					<div class='form-group'>		
						<div class='col-sm-12'>
								<button type="reset" class="btn btn-danger">Reset</button>
								<button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
								<!--<a href="#" class="btn btn-primary">Cetak Kartu</a>-->
						</div>
					</div>      							
				</form>
				<ul id="error_message_box"></ul>
				<div id="feedback_bar"></div>
      		</div>
    	</div>
  	</div>
  	<div class="col-lg-8">
    	<div class="card card-outline-info">
      		<div class="card-header">
        		<h4 class="m-b-0 text-white">Atur Urutan Menu</h4>
      		</div>
      		<div class="card-block">					
				<div id="accordion">
				<?php echo $sortMenu; ?>
				</div>
				<br/>
				<button id="btnRefresh" class="btn btn-warning">Refresh</button>
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
	$('#btnAdd').addClass('disabled');
	$( "#dialog-confirm" ).hide();
	$('#btnSimpan').click(function(){
		$.ajax({
			type: 'POST',
			url: $('#idform').attr( 'action' ),
			data: $('#idform').serialize(),
			success: function( response ) {
				if(!response.success)
				{
					//set_feedback(response.message,'error_message',true);
				}
				else
				{
					//set_feedback(response.message,'success_message',false);
					window.location.reload(true);
				}
			},
			dataType:'json'
		});
	});
	$('#accordion').accordion({
        collapsible: true,
        active: false,
        height: 'fill',
        header: '> div > .h3'
    }).sortable({
        items: '.s_panel',
		update: function (event, ui) {
			var a = $(this).sortable("serialize", {
				attribute: "id"
			});
			var r = $(this).sortable( "toArray" );
			$.ajax({
				data: {data:r},
				type: 'POST',
				url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
				success: function( response ) {
					//alert(response);
				}
			});
		}
    });

    $('#accordion').on('accordionactivate', function (event, ui) {
        if (ui.newPanel.length) {
            $('#accordion').sortable('disable');
        } else {
            $('#accordion').sortable('enable');
        }
    });
	
	$( ".sortable" ).sortable({
		update: function (event, ui) {
			var a = $(this).sortable("serialize", {
				attribute: "id"
			});
			var r = $(this).sortable( "toArray" );
			$.ajax({
				data: {data:r},
				type: 'POST',
				url: '<?php echo site_url('admin/updateOrderMenu'); ?>',
				success: function( response ) {
					//alert(response);
				}
			});
		}
	});
		
	$( "#btnRefresh" ).click(function() {
		window.location.reload(true);
	});
	
	$( "#btnAdd" ).click(function() {		
		$("#id").val('');
		$("#title").val('');
		$("#url").val('');
		$("#parent_id").val(0);
	});
});

function editMenu(vid){
	$.ajax({
		data: {id:vid},
		type: 'POST',
		url: '<?php echo site_url('admin/menuInfo'); ?>',
		dataType:'json',
		success: function( response ) {
			$('#btnAdd').removeClass('disabled');
			$("#id").val(response.page_id);
			$("#title").val(response.title);
			$("#url").val(response.url);
			$("#parent_id").val(response.parent_id);			
		}
	});
	return false;
}

function dropMenu(vid){
	$.ajax({
		data: {id:vid},
		type: 'POST',
		url: '<?php echo site_url('admin/hasChildMenu'); ?>',
		dataType:'json',
		success: function( response ) {
			if (response.hasChild){
				$( "#dialog-confirm" ).html("Menu memiliki submenu. <br/>Menu tidak dapat dihapus.");
				$( "#dialog-confirm" ).dialog({
				  resizable: false,
				  modal: true,
				  buttons: {
					"Oke": function() {
					  $( this ).dialog( "close" );
					}
				  }
				});
			}else{
				swal({
			        title: "Hapus Menu",
			        text: "Yakin akan menghapus menu tersebut?",
			        type: "warning",
			        showCancelButton: true,
			        confirmButtonColor: "#DD6B55",
			        confirmButtonText: "Hapus",
			        showLoaderOnConfirm: true,
			        closeOnConfirm: true
			        }, function() {
						$.ajax({
							data: {id:vid},
							type: 'POST',
							url: '<?php echo site_url('admin/dropMenu'); ?>',
							dataType:'json',
							success: function( response ) {
								if (response.success){
									window.location.reload(true);
									swal("Sukses","Berhasil menghapus data.", "success"); 
								}else swal("Error","Gagal menghapus data.", "error"); 
							}
						});           
			      });
			
			}
		}
	});
	
	return false;
}
</script>