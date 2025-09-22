<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
		<div class="row">
			<div class="col-md-12">
			    <div class="card card-outline-info">
			      <div class="card-header text-center">
			       <h4 class="m-b-0 text-white">Change Password</h4>
			      </div>
			      <div class="card-block">	
			              <form role="form" method="POST" id="form-password" action="<?php echo site_url('user/Change_password/save'); ?>">
          <div class="box-body">
            <div class="form-group">
              <label for="service_url">Current Password</label>
              <input class="form-control" id="currpass" name="currpass" type="password" required>
            </div>              
            <div class="form-group">
              <label for="consid">New Password</label>
              <input class="form-control" id="newpass" name="newpass" type="password" required>
            </div>
            <div class="form-group">
              <label for="secid">Retype Password</label>
              <input class="form-control" id="newpass" name="newpass" type="password" required>
            </div>

          </div>
          <!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" class="btn btn-primary" id="btn-submit"><i class="fa fa-floppy-o"></i> Simpan</button>
          </div>
        </form>							
						<div class="row">
						  <div class="col-md-12" id="alertMsg">	
								<?php echo $this->session->flashdata('alert_msg'); ?>
						  </div>
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


<script type='text/javascript'>
// $(function() {
// 	$('#currpass').focus();
	
// 	$( "#newpass" ).change(function() {
// 		if ( ($('#newpass').val()!= '') && ($('#renewpass').val() != '' )){
// 			if ( $('#newpass').val() != $('#renewpass').val() ){
// 			alert('Please retype, newpass is missmatch!');
// 				// $('#newpass').val('');
// 				// $('#renewpass').val('');
// 				// $('#newpass').focus();
// 			}
// 		}
// 	});
// 	$( "#renewpass" ).change(function() {
// 		if ( ($('#newpass').val()!= '') && ($('#renewpass').val() != '' )){
// 			if ( $('#newpass').val() != $('#renewpass').val() ){
// 				alert('Please retype, newpass is missmatch!');
// 				// $('#newpass').val('');
// 				// $('#renewpass').val('');
// 				// $('#newpass').focus();
// 			}
// 		}
// 	});
// })
</script>