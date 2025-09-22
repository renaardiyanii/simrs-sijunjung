    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
    <link rel="stylesheet" href="<?php echo site_url('assets/plugins/dropify/dist/css/dropify.min.css'); ?>">
    <style type="text/css">
    	.dropify-message p {
    		text-align: center;
    	}
    	#table-personil tbody tr {
			cursor: pointer;
		}
		.page-titles {
		  display: none;
		}
		.demo-radio-button label{min-width:120px;margin-top: 13px;font-size: 14px;}
		
    </style>
<script type='text/javascript'>
	var table_personil;
	var site_url = '<?php echo base_url(); ?>';
	$(function() {
		$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
		$('#date_picker_years').datepicker({
			format: "yyyy",
			endDate: "current",
			autoclose: true,
			todayHighlight: true,			
			viewMode: "years", 
			minViewMode: "years",
		});
		$("#search_jenis").hide();
		table_personil = $('#table-personil').DataTable({ 
	      "processing": true,
	      "serverSide": true,
	      "language": {
		      "emptyTable": "Data tidak tersedia."
		  },
	      "order": [],    
	      "lengthMenu": [
	        [ 10, 25, 50, -1 ],
	        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
	      ],
	      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
	      "ajax": {
	        "url": "<?php echo site_url('kepegawaian/datatable/show_personil'); ?>",
	        "type": "POST",
	        "dataType": 'JSON',
	        "data": function (data) {
	          data.search_per = $('#search_per').val();
	          data.search_jenis = $('#search_jenis').val();
	          data.search_input = $('#search_input').val(); 
	          // if ($('#search_per').val() == 'jenis') {
	          // 	data.search_jenis = $('#search_jenis').val();
	          // 	data.search_by = '';
	          // } else data.search_by = $('#search_by').val();          
	        }
	      },      
	      "columnDefs": [{ 
	        "orderable": false, //set not orderable
	        "width": "5%",
	        "targets": 0 // column index 
	      }],
	    });
	    $('#table-personil tbody').on('click', 'tr', function () {
	        var data = table_personil.row(this).data();        
	        window.location = site_url+'kepegawaian/personil/edit/'+data[6];
	    }); 
	    $( "#search_input" ).keydown(function() {			
			if ( event.which == 13 ) {
				table_personil.ajax.reload();
			}			
		});		
		$( "#search_input" ).keyup(function() {
			if($(this).val().length == 0) {
				table_personil.ajax.reload();
			}
		});
		$('#search_jenis').on('change', function() {
			table_personil.ajax.reload();
		});
		$('#search_per').on('change', function() {
			table_personil.ajax.reload();
		});
		$('#form_import').on('submit', function(e){  
           	e.preventDefault();             
           	document.getElementById("btn-import").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading...';
	        $.ajax({  
				url:"<?php echo base_url(); ?>kepegawaian/personil/import_personil",                         
				method:"POST",  
				data:new FormData(this),  
				contentType: false,  
				cache: false,  
				processData:false,  
				success: function(result) {
					console.log(result);
					if (result==true) {						
						document.getElementById("btn-import").innerHTML = '<i class="fa fa-download"></i> Import Data';
						table_personil.ajax.reload();						
						swal("Sukses","Proses import data berhasil.", "success"); 
					} else {
						document.getElementById("btn-import").innerHTML = '<i class="fa fa-download"></i> Import Data';	
						table_personil.ajax.reload();					
						swal("Sukses","Proses import data gagal.", "error");  
					}					
				},
		        error:function(event, textStatus, errorThrown) {
		        	document.getElementById("btn-import").innerHTML = '<i class="fa fa-download"></i> Import Data';
		            swal("Error","Proses import data tidak berhasil.", "error"); 
		            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
		        }  
	        });   
    	}); 
	 		
	});	
	
	function change_search(pilih) {
		if(pilih=='jenis'){		
			$("#search_input").hide();
			$("#search_jenis").show();		
		} else {
			$("#search_jenis").hide();
			$("#search_input").show();		
		}
  	}
</script>
<?php if($this->session->flashdata('notification')) { ?>
	<script type="text/javascript">
		swal({
	      title: "",
	      text: "<?php echo $this->session->flashdata('notification'); ?>",
	      type: "error",
	      html: true,	      	           
	    });	  
	</script>
<?php } ?>	
<div class="m-t-30">	
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
            	<h3 class="card-title">Data Personil</h3>
				<form class="m-t-30" id="form_search" onSubmit="return false;">
	                <div class="row p-t-10 m-b-15">
	                    <div class="col-md-2">
	                        <div class="form-group">	                            
	                            <select name="search_per" id="search_per" class="form-control" onchange="change_search(this.value)">
	                            	<option value="" selected>-- Pilih --</option>
									<option value="nama">Nama</option>
									<option value="nip_nrp">NIP/NRP</option>
									<option value="jenis">Jenis</option>
									<option value="alamat">Alamat</option>								
									<option value="tgl_lahir">Tanggal Lahir</option>
								</select>	                            
	                        </div>
	                    </div>
	                    <div class="col-md-4">
							<input type="search" class="search_input form-control" id="search_input" name="search_input" placeholder="Search..." style="width:450;">
							<select name="search_jenis" id="search_jenis" class="form-control">
								<option value="TNI">ANGGOTA MILITER</option>
								<option value="PNS">PNS</option>
								<option value="PHL">PHL</option>									
							</select>	                        
	                    </div>	                        
	                    <div class="col-md-6">
	                        <div class="form-actions">	                        	
	                        	<button class="btn waves-effect waves-light btn-info" type="button" style="margin-right: 10px;" data-toggle="modal" data-target="#modal_add_pers">
	                        		<i class="fa fa-user-plus"></i> Tambah Data Personil
	                        	</button>
	                        	<button class="btn waves-effect waves-light btn-danger" type="button" style="margin-right: 10px;" data-toggle="modal" data-target="#modal_import">
	                        		<i class="fa fa-download"></i> Import Data Personil
	                        	</button> 	                        	                          	
	                        </div>
	                    </div>
	                </div>
				</form>          
                <div class="table-responsive m-t-0">
                    <table id="table-personil" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
                        <thead>
							<tr>
								<th>No.</th>								
								<th>Nama</th>								
								<th>NIP/NRP</th>	
								<th>Pangkat/Gol</th>
								<th>Jabatan</th>							
								<th>Alamat</th>																
							</tr>
                        </thead>
						<tbody>							
						</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_add_pers" tabindex="-1" role="dialog" aria-labelledby="modal_add_pers">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Tambah Data Personil</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <form id="form_add" class="form-horizontal form-material" action="<?php echo site_url('kepegawaian/personil/insert_personil'); ?>" method="POST" enctype="multipart/form-data">
	        <div class="modal-body">				
				<div class="col-md-12">									
                    <div class="row">
                    	<div class="col-md-3">
	                        <center> 				               					                      
			                    <input class="dropify" type="file"  data-max-file-size="2M" data-width="150" name="foto" id="foto" data-default-file="" data-allowed-file-extensions="jpg png jpeg pdf"/>		
		                    </center>
	                    </div>
                       	<div class="col-md-9">
	                       	<div class="row">
		                       	<div class="col-md-6">	
		                       		<div class="form-group row">
				                        <small class="col-md-12">Nama </small>
				                        <div class="col-md-12">
				                            <input type="text" class="form-control form-control-line" name="nm_pegawai" id="nm_pegawai">
				                        </div>
			                        </div>
				                    <div class="form-group row">
				                        <small class="col-md-12">NIK</small>
				                        <div class="col-md-12">
				                            <input type="text" class="form-control form-control-line" name="nik" id="nik">
				                        </div>
				                    </div>
				                    <div class="form-group row">
				                        <small class="col-md-12">Alamat</small>
				                        <div class="col-md-12">
				                            <textarea rows="5" class="form-control form-control-line" name="alamat" id="alamat"></textarea>
				                        </div>
				                    </div>					                    
		                       	</div> <!-- col-md-6 -->
		                       	<div class="col-md-6">	
		                       		<div class="form-group row">
				                        <small class="col-md-12">Tempat Lahir</small>
				                        <div class="col-md-12">
				                            <input type="text" class="form-control form-control-line" name="tmpt_lahir" id="tmpt_lahir">
				                        </div>
				                    </div>		                       						
				                    <div class="form-group row">
				                        <small class="col-md-12">Tanggal Lahir </small>
				                        <div class="col-md-12">
				                            <input type="text" class="form-control form-control-line date_picker" name="tgl_lahir" id="tgl_lahir">
				                        </div>
				                    </div>					                    	
				                    <div class="form-group row">
				                        <small class="col-md-12">Jenis Kelamin </small>
				                        <div class="col-md-12">
				                            <div class="demo-radio-button">
												<input name="gender" type="radio" id="laki_laki" class="with-gap" value="L"/>
					                            <label for="laki_laki">Laki-Laki</label>
					                            <input name="gender" type="radio" id="perempuan" class="with-gap" value="P"/>
					                            <label for="perempuan">Perempuan</label>           		
											</div>
				                        </div>
				                    </div>	
				                    <div class="form-group row">
				                        <small class="col-md-12">Agama </small>
				                        <div class="col-md-12">
				                            <select class="form-control" style="width: 100%" name="agama" id="agama">
												<option value=""></option>
												<option value="ISLAM">ISLAM</option>
												<option value="KATOLIK">KATOLIK</option>
												<option value="PROTESTAN">PROTESTAN</option>
												<option value="BUDHA">BUDHA</option>
												<option value="HINDU">HINDU</option>
												<option value="KONGHUCU">KONGHUCU</option>
											</select>
				                        </div>
				                    </div>				                    				                    
		            			</div> <!-- col-md-6 -->		
		            		</div>
	            		</div>		                                    
                    </div>						                	
            	</div>	<!-- Column -->				                                               
	        </div>
	        <div class="modal-footer">
	            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan</button>
	        </div>
        </form> 
      </div>
    </div>
</div><!-- /.modal -->

<div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-labelledby="modal_import">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Import Data Personil</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
       	<form id="form_import" class="form-horizontal form-material" method="POST" enctype="multipart/form-data">
	        <div class="modal-body">				
				<div class="col-md-12">									
                    <input type="file" name="file" class="dropify" data-allowed-file-extensions="xls xlsx">					               	
            	</div>	<!-- Column -->				                                               
	        </div>
	        <div class="modal-footer">
	            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	            <button type="submit" class="btn btn-primary" id="btn-import"><i class="fa fa-download"></i> Import Data</button>
	        </div>
        </form> 
      </div>
    </div>
</div><!-- /.modal -->	

<script src="<?php echo site_url('assets/plugins/dropify/dist/js/dropify.min.js'); ?>"></script>
<script>
	$(document).ready(function() {            
	    $('.dropify').dropify();        
	});
</script> 
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 