<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else if ($role_id == 37) {
        $this->load->view("layout/header_dashboard");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>
 <style type="text/css">
 	.stylish-table thead th {
		color: #4b5255;
		font-weight: 500;
	}
	.stylish-table tbody td h6 {
		font-weight: 400;
		color: #4b5255;
	}
	a:focus { 
		color: #fff;
	}
	.btn:active,
	.btn:focus,
	.btn.active {
		background-image: none;
		outline: 0;
		-webkit-box-shadow: none;
		box-shadow: none;
		outline: none !important;
	}
		::-webkit-input-placeholder {
	   font-style: italic;
	}
	:-moz-placeholder {
	   font-style: italic;  
	}
	::-moz-placeholder {
	   font-style: italic;  
	}
	:-ms-input-placeholder {  
	   font-style: italic; 
	}
	.form-control {
		color: #4b5255;
	}
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
	.card .card-header {
	    background: #fff;
	    border-bottom: 0px;
	}
	select {text-align-last:center; }
	@media (min-width: 481px) and (max-width: 767px) {
		.card-body {
			padding-left: 10px;
			padding-right: 10px;
		}
	}

	@media (min-width: 320px) and (max-width: 480px) {
		.mini-sidebar .page-wrapper-dashboard {
			padding-top: 10px;
		}
		.card-body {
			padding-left: 10px;
			padding-right: 10px;
			padding: 10px;
		}
		.form-group {
			margin-bottom: 15px;
		}
		#btn-search {
			width: 100%;
			font-size: 13px;
		}
		.col-form-label,.form-control {
			font-size: 13px;
		}
		.card .card-header {
			padding: 10px; 
		}
		.card-title {
			font-size: 16px;
			font-weight: 500;
		}
		.stylish-table thead th {
			font-size: 13px;
			color: #000;
			font-weight: 500;
		}
		.stylish-table tbody td h6 {
			font-size: 11px;
			font-weight: 400;
		}
		.dataTables_info, .dataTables_length,.dataTables_filter {
			font-size: 11px;
		}
		.panel-personil {
			padding: 0;
		}
		.img-personil {
			width: 40px;
		}
	}
    </style>
<script type='text/javascript'>
	var table_personil;
	var site_url = '<?php echo base_url(); ?>';
	$(function() {	
		$(document).on("click","#btn-search",function() {
		    table_personil.ajax.reload();
		});	
		$('.date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true,
		});
		$("#div_nama").hide();
		$("#div_nip_nrp").hide();
		$("#div_pendidikan").hide();
		$("#div_jenis").hide();
		$("#div_tgl_lahir").hide();
		$("#div_pangkat").hide();
		$("#div_jabatan").hide();
		$("#div_alamat").hide();
		$("#div_jurusan").hide();
		table_personil = $('#table-personil').DataTable({ 
	      "processing": true,
	      "serverSide": true,
	      "language": {
		      "emptyTable": "Data tidak tersedia.",
            	"processing": "<i class='fa fa-spinner'></i> Loading",
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
	          data.search_nama = $('#search_nama').val(); 
	          data.search_tgl_lahir = $('#search_tgl_lahir').val(); 
	          data.search_pangkat = $('#search_pangkat').val();
	          data.search_jabatan = $('#search_jabatan').val(); 
	          data.search_pendidikan = $('#search_pendidikan').val(); 
	          data.search_nip_nrp = $('#search_nip_nrp').val(); 
	          data.search_alamat = $('#search_alamat').val();      
	        }
	      },      
	      "columnDefs": [{ 
	        "orderable": false, //set not orderable
	        "width": "5%",
	        "targets": [0,1] // column index 
	      }],
	    });
	    $('#table-personil tbody').on('click', 'tr', function () {
	        var data = table_personil.row(this).data();        
	        window.location = site_url+'kepegawaian/personil/edit/'+data[7];
	    }); 
	    $( "#search_nama" ).keydown(function() {			
			if ( event.which == 13 ) {
				table_personil.ajax.reload();
			}			
		});		
		$( "#search_nama" ).keyup(function() {
			if($(this).val().length == 0) {
				table_personil.ajax.reload();
			}
		});
		$('#search_jenis').on('change', function() {
			table_personil.ajax.reload();
		});
		$('#form_import').on('submit', function(e){  
           	e.preventDefault();             
           	document.getElementById("btn-import").innerHTML = '<i class="fa fa-spinner fa-spin" ></i> Loading';
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
		if (pilih == 'all') {		
			$("#div_jenis").hide();
			$("#div_nip_nrp").hide();	
			$("#div_pendidikan").hide();
			$("#div_nama").hide();
			$("#div_tgl_lahir").hide();	
			$("#div_pangkat").hide();	
			$("#div_jabatan").hide();
			$("#div_alamat").hide();
			// $("#div_btn_cari").hide();
		} else if (pilih == 'jenis') {		
			$("#div_jenis").show();
			$("#div_nip_nrp").hide();	
			$("#div_pendidikan").hide();
			$("#div_nama").hide();
			$("#div_tgl_lahir").hide();	
			$("#div_pangkat").hide();	
			$("#div_jabatan").hide();
			$("#div_alamat").hide();
			// $("#div_btn_cari").hide();
		} else if (pilih == 'nip_nrp') {	
			$("#div_nip_nrp").show();	
			$("#div_pendidikan").hide();
			$("#div_tgl_lahir").hide();	
			$("#div_jenis").hide();
			$("#div_nama").hide();	
			$("#div_pangkat").hide();	
			$("#div_jabatan").hide();
			$("#div_alamat").hide();
			// $("#div_btn_cari").show();
		} else if (pilih == 'tgl_lahir') {	
			$("#div_nip_nrp").hide();	
			$("#div_pendidikan").hide();
			$("#div_tgl_lahir").show();	
			$("#div_jenis").hide();
			$("#div_nama").hide();	
			$("#div_pangkat").hide();	
			$("#div_jabatan").hide();
			$("#div_alamat").hide();
			// $("#div_btn_cari").show();
		} else if (pilih == 'pangkat') {
			$("#div_nip_nrp").hide();
			$("#div_pendidikan").hide();
			$("#div_pangkat").show();		
			$("#div_tgl_lahir").hide();	
			$("#div_jenis").hide();
			$("#div_nama").hide();	
			$("#div_alamat").hide();
			$("#div_jabatan").hide();	
			// $("#div_btn_cari").hide();	
		} else if (pilih == 'pendidikan') {
			$("#div_nip_nrp").hide();
			$("#div_pangkat").hide();		
			$("#div_pendidikan").show();
			$("#div_tgl_lahir").hide();	
			$("#div_jenis").hide();
			$("#div_nama").hide();	
			$("#div_alamat").hide();
			$("#div_jabatan").hide();
			// $("#div_btn_cari").hide();		
		} else if (pilih == 'jabatan') {
			$("#div_nip_nrp").hide();
			$("#div_pendidikan").hide();
			$("#div_jabatan").show();	
			$("#div_pangkat").hide();		
			$("#div_tgl_lahir").hide();	
			$("#div_jenis").hide();
			$("#div_nama").hide();	
			$("#div_alamat").hide();
			// $("#div_btn_cari").show();	
		} else if (pilih == 'alamat') {
			$("#div_nip_nrp").hide();
			$("#div_pendidikan").hide();
			$("#div_jabatan").hide();	
			$("#div_pangkat").hide();		
			$("#div_tgl_lahir").hide();	
			$("#div_jenis").hide();
			$("#div_nama").hide();	
			$("#div_alamat").show();	
			// $("#div_btn_cari").show();	
		} else {
			$("#div_nip_nrp").hide();
			$("#div_pendidikan").hide();
			$("#div_nama").show();	
			$("#div_tgl_lahir").hide();	
			$("#div_jenis").hide();
			$("#div_pangkat").hide();
			$("#div_jabatan").hide();	
			$("#div_alamat").hide();
			// $("#div_btn_cari").show();	
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
	<div class="col-lg-12 col-md-12 panel-personil">
	    <div class="card">
	    	<div class="card-header bg-white">
				<h4 class="card-title m-b-0">Data Personil</h4>
			</div>
	        <div class="card-body b-t">
				<form id="form_search" class="form-horizontal" onSubmit="return false;">
                	<div class="form-group row">
						<label class="col-md-2 control-label col-form-label">Cari Berdasarkan :</label>
						<div class="col-md-2">
	                        <div class="form-group">	                            
	                            <select name="search_per" id="search_per" class="form-control" onchange="change_search(this.value)">
	                            	<option value="all">Semua</option>
									<option value="nama">Nama</option>
									<option value="nip_nrp">NIP / NRP</option>
									<option value="jenis">Jenis</option>
									<option value="pangkat">Pangkat</option>
									<option value="jabatan">Jabatan</option>
									<option value="pendidikan">Pendidikan</option>
									<option value="alamat">Alamat</option>								
									<option value="tgl_lahir">Tanggal Lahir</option>
								</select>	                            
	                        </div>
	                    </div>
	                    <div class="col-md-4" id="div_nama">
	                    	<div class="form-group">	    
								<input type="search" class="form-control" id="search_nama" name="search_nama" placeholder="Ketik Nama Personil">
							</div>
	                    </div>	 
	                    <div class="col-md-4" id="div_nip_nrp">
	                    	<div class="form-group">
								<input type="search" class="form-control" id="search_nip_nrp" name="search_nip_nrp" placeholder="Ketik NIP / NRP">
							</div>
	                    </div>	  
	                    <div class="col-md-3" id="div_tgl_lahir">
	                    	<div class="form-group">
	                    		<input type="text" class="form-control date_picker" id="search_tgl_lahir" name="search_tgl_lahir" placeholder="Masukkan Tanggal Lahir">
	                    	</div>
	                    </div>	  
	                    <div class="col-md-4" id="div_jabatan">
	                    	<div class="form-group">
	                    		<input type="text" class="form-control" id="search_jabatan" name="search_jabatan" placeholder="Ketik Nama Jabatan">
	                    	</div>
	                    </div>	
	                    <div class="col-md-4" id="div_alamat">
	                    	<div class="form-group">
	                    		<input type="text" class="form-control" id="search_alamat" name="search_alamat" placeholder="Ketik Alamat">
	                    	</div>
	                    </div>	 
	                    <div class="col-md-3" id="div_jenis">  
	                    	<div class="form-group">
			                    <select name="search_jenis" id="search_jenis" class="form-control">
									<option value="1">ANGGOTA MILITER</option>
									<option value="2">PNS</option>
									<option value="3">PHL</option>									
								</select>	      
							</div>              
	                    </div>
	                    <div class="col-md-3" id="div_pendidikan"> 
	                    	<div class="form-group"> 
			                    <select name="search_pendidikan" id="search_pendidikan" class="form-control" style="width: 100%">
									<option value="" selected>-- Pilih Pendidikan --</option>											
									<option value="1">Pendidikan Umum</option>
									<option value="2">Pendidikan Militer</option>
								</select>             
							</div>      
	                    </div>
	                    <div class="col-md-3" id="div_pangkat">  
	                    	<div class="form-group">
			                    <select name="search_pangkat" id="search_pangkat" class="form-control" style="width: 100%">
									<option value="">-- Pilih Pangkat --</option>
									<?php 
										$group = '';
										foreach($pangkat as $row){													
											if ($row->jenis != $group) {
												switch ($row->jenis) {
													case 1:
														echo '<optgroup label="TNI">';
														break;
													case 2:
														echo '<optgroup label="PNS">';
														break;
													case 3:
														echo '<optgroup label="PHL">';
														break;
												}											
											}																
											echo '<option value="'.$row->id.'">'.$row->pangkat.'</option>';	
											$group = $row->jenis;
											if ($row->jenis != $group) {
												echo '</optgroup>';
											}
										}
									?>															
								</select>       
							</div>            
	                    </div>
	                    <div class="col-md-3" id="div_jurusan">  
	                    	<div class="form-group">
			                    <select name="search_jurusan" id="search_jurusan" class="form-control" style="width: 100%">
									<option value="">-- Pilih Jurusan --</option>
									<?php 
										$group = '';
										foreach($pangkat as $row){													
											if ($row->jenis != $group) {
												switch ($row->jenis) {
													case 1:
														echo '<optgroup label="TNI">';
														break;
													case 2:
														echo '<optgroup label="PNS">';
														break;
													case 3:
														echo '<optgroup label="PHL">';
														break;
												}											
											}																
											echo '<option value="'.$row->id.'">'.$row->pangkat.'</option>';	
											$group = $row->jenis;
											if ($row->jenis != $group) {
												echo '</optgroup>';
											}
										}
									?>															
								</select>       
							</div>            
	                    </div>
	                    <div class="col-md-2" id="div_btn_cari">
	                    	<div class="form-group">
	                        	<button class="btn waves-effect waves-light btn-primary" type="button" id="btn-search">
	                        		<i class="fa fa-search"></i> Cari Data
	                        	</button>             
                        	</div>           	                        	                          	
	                    </div>
					</div>
				</form>          
	            <div class="table-responsive m-t-0">
	                <table id="table-personil" class="table stylish-table table-hover" cellspacing="0" width="100%">
	                    <thead>
							<tr>
								<th class="text-center">No.</th>						
								<th class="text-center"></th>	
								<th>Nama</th>								
								<th class="text-center">NIP/NRP</th>
								<th class="text-center">Pangkat/Gol</th>	
								<th class="text-center">Jabatan</th>							
								<th class="text-center">Alamat</th>																
							</tr>
	                    </thead>
						<tbody>							
						</tbody>
	                </table>
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