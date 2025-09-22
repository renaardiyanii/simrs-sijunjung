    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/dropify/dist/css/dropify.min.css'); ?>">
    <style type="text/css">    	
		.page-titles {
		  display: none;
		}				
    </style>	
    <script type="text/javascript">
    function download() {	    
    	swal({
			title: "Download?",
			text: "Download Laporan Daftar Nominatif Rumkital Dr. Mintohardjo",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#DD6B55",
			confirmButtonText: "Download",
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: false,
			}, function() {		  				
				var jenis = $('#jenis').val();
				swal("Download", "File berhasil di download.", "success");
				window.open("<?php echo site_url('kepegawaian/laporan/download_daftar_nominatif'); ?>/"+jenis, "_blank");		
			}
		);						
	}	
	</script>
    <?php if($this->session->flashdata('notification') == 'empty') { ?>
		<script type="text/javascript">
		  swal("Gagal Mengunduh", "Data tidak tersedia.", "error");
		</script>
	<?php } ?>
<div class="m-t-30">	
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
            	<h3 class="card-title">Daftar Nominatif Rumkital Dr. Mintohardjo</h3>
				<form class="m-t-30" id="form_download" method="POST" action="<?php echo site_url('kepegawaian/laporan/download_daftar_nominatif');?>">
	                <div class="row p-t-10 m-b-15">
	                    <div class="col-md-6">
	                    	<div class="form-group row">
                                <label for="example-search-input" class="col-md-3 col-form-label">Berdasarkan</label>
                                <div class="col-md-9">
                                    <select name="jenis" id="jenis" class="form-control">
										<option value="1" selected>Militer</option>
										<option value="2">PNS</option>										
										<option value="3">PHL</option>	
									</select>
                                </div>
                               <!--  <label for="example-search-input" class="col-md-1 col-form-label">Priode</label>
                                <div class="col-md-3">
                                    <select name="periode" id="periode" class="form-control">
										<option value="harian">Harian</option>
										<option value="bulanan">Bulanan</option>	
										<option value="tahunan">Tahunan</option>										
									</select>
                                </div>
                                <input class="form-control col-md-3" type="text" name=""> -->
                            </div>	                           	                       
	                    </div>	                 	                        
	                    <div class="col-md-6">
	                        <div class="form-actions">
	                        	<button class="btn waves-effect waves-light btn-danger" type="button" id="btn-submit" style="margin-right: 10px;" onclick="download()">
	                        		<i class="fa fa-download"></i> Download Laporan
	                        	</button> 	                        	                          	
	                        </div>
	                    </div>
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