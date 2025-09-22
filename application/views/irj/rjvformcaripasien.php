    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 
<script type='text/javascript'>
$(function() {
	$('#tbl-pasien').DataTable({
  		"language": {
     	"emptyTable": "Data tidak tersedia."
    	}
	});

	$(document).on("click",".create_sep",function() {
	    var no_register = $(this).data("noregister");
	    swal({
	      title: "Pembuatan SEP",
	      text: "Yakin akan membuat SEP dengan pasien tersebut?",
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      confirmButtonText: "Buat SEP",
	      showCancelButton: true,
	      closeOnConfirm: false,
	      showLoaderOnConfirm: true,
	      }, function() {
	        $.ajax({
	          type: "POST",
	          url: "<?php echo base_url().'bpjs/sep/create/'; ?>"+no_register,
	          dataType: "JSON",    
	          success: function(result) {  
	            if (result.metaData.code == '200') {       
	              window.open('<?php echo base_url().'bpjs/sep/cetak_perincian/'; ?>'+no_register, '_blank');
	              swal("Sukses", "Silahkan Cetak SEP", "success");   
	            } else {
	              swal("Gagal membuat SEP", result.metaData.message, "error");   
	            }       
	          },
	          error:function(event, textStatus, errorThrown) {    
	              swal("Gagal membuat SEP",formatErrorMessage(event, errorThrown), "error");    
	              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	          }
	        }); 
	    });
	});
	
	$('.auto_search_by_nocm').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
		}
	});

	$('.auto_search_by_nocm_lama').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm_lama',
		onSelect: function (suggestion) {
			$('#cari_no_cm_lama').val(''+suggestion.no_cm_lama);			
		}
	});
	
	$('.auto_search_by_nokartu').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nokartu',
		onSelect: function (suggestion) {
			$('#cari_no_kartu').val(''+suggestion.no_kartu);
		}
	});
	
	$('.auto_search_by_noidentitas').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_noidentitas',
		onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
	});

	$('.auto_search_by_nonrp').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nonrp3',
		onSelect: function (suggestion) {
			$('#cari_no_nrp').val(''+suggestion.no_nrp);
		}
	});
	
	$('.auto_search_by_nama').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nama'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});
	
	$('.auto_search_by_alamat').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_alamat'
		/*onSelect: function (suggestion) {
			$('#cari_no_identitas').val(''+suggestion.no_identitas);
		}
		*/
	});

	$('#cari_tgl').datepicker({
		format: "yyyy-mm-dd",
		endDate: '0',
		autoclose: true,
		todayHighlight: true,
	});  	
});	

function cek_search_per(val_search_per){
	if(val_search_per=='cm'){
		$("#cari_no_cm").css("display", ""); // To unhide
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='cm_lama'){		
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", ""); // To unhide
		$("#cari_no_kartu").css("display", "none");  // To hide
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='kartu'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", ""); 
		$("#cari_no_identitas").css("display", "none");
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='identitas'){
		  // To hide
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", ""); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	}
	else if(val_search_per=='nama'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", ""); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	} 
	else if(val_search_per=='nrp'){
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", ""); 
		$("#cari_alamat").css("display", "none");	
		$("#cari_tgl").css("display", "none");
	} 	
	else if(val_search_per=='alamat') {
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none");
		$("#cari_alamat").css("display", "");
		$("#cari_tgl").css("display", "none");
	}
	else {
		$("#cari_no_cm").css("display", "none");
		$("#cari_no_cm_lama").css("display", "none");  // To hide
		$("#cari_no_kartu").css("display", "none");
		$("#cari_no_identitas").css("display", "none"); 
		$("#cari_nama").css("display", "none"); 
		$("#cari_no_nrp").css("display", "none"); 
		$("#cari_alamat").css("display", "none");
		$("#cari_tgl").css("display", "");
	}
}

function cetak_tracer(no_register) {
      var windowUrl = '<?php echo base_url();?>irj/tracer/cetak/'+no_register;
      window.open(windowUrl,'p');
}
</script>
	
<div class="row">
	<div class="col-md-12">
		<?php echo $this->session->flashdata('success_msg'); ?>
	</div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
			<?php 
              		$attributes = array('class' => '');
					echo form_open('irj/rjcregistrasi/pasien', $attributes);?>
                <div class="row p-t-10 m-b-15">
                    <div class="col-md-2">
                        <div class="form-group">
                            <!-- <label class="control-label">Kategori</label> -->
                            <select name="search_per" id="search_per" class="form-control"  onchange="cek_search_per(this.value)">
								<option value="cm">No. RM</option>
								<option value="cm_lama">No. RM Lama</option>
								<option value="nama">Nama</option>
								<option value="nrp">NIP / NRP</option>
								<option value="kartu">No. BPJS</option>
								<option value="identitas">No. Identitas</option>								
								<option value="alamat">Alamat</option>
								<option value="tgl">Tanggal Lahir</option>
							</select>
                            <!-- <small class="form-control-feedback"> This is inline help </small> -->
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group has-danger">
							<input type="search" class="auto_search_by_nocm form-control" id="cari_no_cm" name="cari_no_cm" placeholder="Pencarian No RM" style="width:450;">
							<input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru" >
							<!--auto_search_cm_lama-->					
							<input type="search" style="width:450; display:none" class=" form-control" id="cari_no_cm_lama" name="cari_no_cm_lama" placeholder="Pencarian No RM Lama">
							<!--auto_search_by_nama-->					
							<input type="search" style="width:450; display:none" class=" form-control" id="cari_nama" name="cari_nama" placeholder="Pencarian Nama">
							<!--auto_search_by_nonrp-->
							<input type="search" style="width:450; display:none" class="auto_search_by_nonrp form-control" id="cari_no_nrp" name="cari_no_nrp" placeholder="Pencarian No NRP">
							<!--auto_search_by_nokartu-->
							<input type="search" style="width:450; display:none" class="auto_search_by_nokartu form-control" id="cari_no_kartu" name="cari_no_kartu" placeholder="Pencarian Kartu BPJS">
							<!--auto_search_by_noidentitas-->
							<input type="search" style="width:450; display:none" class="auto_search_by_noidentitas form-control" id="cari_no_identitas" name="cari_no_identitas" placeholder="Pencarian No Identitas">
							<!--auto_search_by_alamat-->
							<input type="search" style="width:450; display:none" class=" form-control" id="cari_alamat" name="cari_alamat" placeholder="Pencarian Alamat">

							<input type="search" style="width:450; display:none" class="form-control" id="cari_tgl" name="cari_tgl" placeholder="Pencarian Tgl Lahir">
                            <!-- <small class="form-control-feedback"> This field has error. </small> </div> -->
                        </div>
                    </div>
                        <?php $url=site_url('irj/rjcregistrasi/regpasien'); ?>
                    <div class="col-md-5">
                        <div class="form-actions">
                        	<button type="submit" class="btn waves-effect waves-light btn-info" type="button">
                        		<i class="fa fa-search"></i> Cari Pasien
                        	</button>
<!--                         	<button type="button" onclick="javascript:window.location.href='<?php echo $url ?>'; return false;" class="btn waves-effect waves-light btn-danger"><i class="fa fa-user-plus"></i> Tambah Pasien Baru</button> -->
                        </div>
                    </div>
                </div>
				<?php echo form_close();?>            
                <div class="table-responsive m-t-0">
                    <table id="tbl-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
							<tr>
								<th>No. RM</th>
								<th>Nama</th>
								<th>No. Identitas</th>
								<th>No. BPJS</th>								
								<th>Alamat</th>
								<th>Tgl Lahir</th>
								<th width="40px">Aksi</th>
							</tr>
                        </thead>
						<tbody>
							<?php
							if ($data_pasien!="") {
								foreach($data_pasien as $row){
								?>
								<tr>
									<td><?php echo $row->no_cm;?></td>
									<td><?php echo strtoupper($row->nama);?></td>
									<td><?php echo $row->jenis_identitas." - ".$row->no_identitas;?></td>
									<td><?php echo $row->no_kartu;?></td>									
									<td><?php echo $row->alamat;?></td>
									<td><?php echo date('d-m-Y',strtotime($row->tgl_lahir));?></td>
									<td>
										<a href="<?php echo site_url('irj/rjcregistrasi/daftarulang/'.$row->no_medrec); ?>" class="btn btn-primary btn-xs" style='width:85px;margin-bottom: 3px;'>Daftar Ulang</a><br>
										<a href="<?php echo site_url('medrec/el_record/pasien/'.$row->no_medrec); ?>" class="btn btn-danger btn-xs" style='width:85px;'>Rekam Medik</a>
										<!--<a href="<?php echo site_url('medrec/Rme/histori/'.$row->no_cm); ?>" class="btn btn-danger btn-xs" target='_blank' style='width:85px;'>Rekam Medik</a>-->
									</td>
								</tr>
								<?php } 
								}
								?>
						</tbody>
                    </table>
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