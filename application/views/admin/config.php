<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
	<script>
	$('#browseBtn,#logo_url').on('click', function() {
	   $('#logo_header').trigger('click');
	});
	$('#browseBtn1,#background').on('click', function() {
	   $('#change_background').trigger('click');
	});	
	
	</script>
	<!-- Content Header (Page header) -->	
<div class="row">
<div class="col-lg-8">
    <div class="card card-outline-info">
    	<div class="card-header">
            <h4 class="m-b-0 text-white" align="center">Konfigurasi</h4>
        </div>
        	<div class="card-block">
					<div class="form-body">
					<?php
					echo form_open_multipart('admin/configSave/',array('id'=>'config_form'));
					?>
					<fieldset id="config_info">
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Judul Web</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'web_title',
									'id'=>'web_title',
									'class'=>'form-control', 'value'=>$this->config->item('web_title')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Judul Header</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'header_title',
									'id'=>'header_title',
									'class'=>'form-control', 'value'=>$this->config->item('header_title')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Gambar Logo Header</p>
								<div class="col-sm-8">		
									<div class="input-group">
										<input type="file" name="userfile" accept="image/jpeg, image/png, image/gif" id="logo_header">
										<input type="text" name="logo_url" id="logo_url" class="form-control filefield browse" readonly="" value="<?php echo $this->config->item('logo_url'); ?>" />
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="button" id="browseBtn">Browse</button>
										</span>
									</div>
								</div>								
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Gambar Background</p>
								<div class="col-sm-8">		
									<div class="input-group">
										<input type="file" name="userfile1" accept="image/jpeg, image/png, image/gif" id="change_background" />
										<input type="text" name="background" id="background" class="form-control filefield browse" readonly="" value="<?php echo $this->config->item('background'); ?>" />
										<span class="input-group-btn">
											<button class="btn btn-info btn-flat" type="button" id="browseBtn1">Browse</button>
										</span>
									</div>
								</div>								
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Skin</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'skin',
									'id'=>'skin',
									'class'=>'form-control', 'value'=>$this->config->item('skin')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Nama RS</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'namars',
									'id'=>'namars',
									'class'=>'form-control', 'value'=>$this->config->item('namars')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Nama RS Singkat</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'namasingkat',
									'id'=>'namasingkat',
									'class'=>'form-control', 'value'=>$this->config->item('namasingkat')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Alamat</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'alamat',
									'id'=>'alamat',
									'class'=>'form-control', 'value'=>$this->config->item('alamat')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Kota</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'kota',
									'id'=>'kota',
									'class'=>'form-control', 'value'=>$this->config->item('kota')));?>
								</div>
							</div>
							<div class="form-group row">
								<p class="col-sm-4 form-control-label" >Telepon</p>
								<div class="col-sm-8">
									<?php echo form_input(array(
									'name'=>'telp',
									'id'=>'telp',
									'class'=>'form-control', 'value'=>$this->config->item('telp')));?>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-4 form-control-label" ></div>
								<div class="col-sm-8">		
									<?php 
									echo form_submit(array(
										'name'=>'submit',
										'id'=>'submit',
										'class'=>'form-control', 'value'=>'Simpan',
										'class'=>'btn btn-primary')
									);
									?>
								</div>
							</div>
					</fieldset>
				<?php
				echo form_close();
				?>
				</div>
			</div>
	</div>
</div>
			
<div class="col-lg-4">
    <div class="card card-outline-info">
    	<div class="card-header">
            <h4 class="m-b-0 text-white" align="center">SKIN</h4>
        </div>
        <div class="card-block">
				<form class="form-horizontal p-t-0">
		            <ul id="themecolors" class="m-t-20">
		                <li><b>With Light sidebar</b></li>
		                <li><a href="javascript:void(0)" data-theme="default" class="default-theme">1</a></li>
		                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
		                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
		                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme working">4</a></li>
		                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
		                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
		                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
		                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
		                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
		                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
		                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
		                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
		                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
		            </ul>
		    	</div>
		    </form>
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
