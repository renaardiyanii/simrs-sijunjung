<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>">

<script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script>
<script type='text/javascript'>
	var site = "<?php echo site_url(); ?>";
	var table=null;
	var idok="<?php echo $id?>";
	$(document).ready(function() {
		$('.clockpicker').clockpicker({
        	donetext: 'Done',
    	}).find('input').change(function() {
        	console.log(this.value);
    	});
		$('.auto_diagnosa_pasien1').autocomplete({
    	serviceUrl: site+'iri/ricstatus/data_icd_1',
    	onSelect: function (suggestion) {
      		$('#id_diagpreok').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
      		$('#diagnosapreok').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);      
    	}
  		});

  		$('.auto_diagnosa_pasien2').autocomplete({
    	serviceUrl: site+'iri/ricstatus/data_icd_1',
    	onSelect: function (suggestion) {
      		$('#id_diagpostok').val(suggestion.id_icd+' - '+suggestion.nm_diagnosa);
      		$('#diagnosapostok').val(''+suggestion.id_icd+'@'+suggestion.nm_diagnosa);      
    	}
  		});

       	$('#tgl_jadwal_ok').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			todayHighlight: true,
		});
	    $(".waktu_ok").timepicker({
		    showInputs: false,
		    showMeridian: false
	    });
	    $('#tabel_tindakan').DataTable();
		$("#biaya_ok").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$("#vtot").maskMoney({thousands:',', decimal:'.', affixesStay: true});
		$('input').iCheck({
	    	checkboxClass: 'icheckbox_flat-green'
	  	});

		
		if(idok!=''){
			get_operasi_header(idok);
		}else{
			$('#no_register_show').val("<?php echo $no_register?>");
			$('#no_register').val("<?php echo $no_register?>");
			$('#type_rawat').val("<?php echo $type_rawat;?>").change();
		}
	  	

	  	var v00 = $("#formhasilok").validate({
	      rules: {	   
	      	type_anas:{
	      		required:true
	      	},
	      	type_operasi:{
	      		required:true
	      	},
	        intime_jadwal_ok:{
	        	required: true
	        },
	        outtime_jadwal_ok:{
	        	required: true
	        },
	        lama_ok:{
	        	required:true
	        }
	      },
	    highlight: function (element) { // hightlight error inputs
	                    $(element)
	                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
	                },

	                unhighlight: function (element) { // revert the change done by hightlight
	                    $(element)
	                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
	                },
	     errorElement: "span",
	     errorClass: "help-block help-block-error",
	     submitHandler: function(form) {

	     	var formData = new FormData( $("#formhasilok")[0] );
		    $.ajax({
				type:'post',
				url: site+'ok/okchasil/save_hasilok',
				type : 'POST', 
				data : formData,
				async : false,
				cache : false,
				contentType : false,
				processData : false,	     		
				success: function(data){
						alert("Laporan Operasi berhasil disimpan");					
						get_operasi_header(idok);
					},
				error: function(){
						alert("error");
					}
			    });
	        }
	    });	

		tableitem("<?php echo $id?>");
	});

	function tableitem(id){
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>ok/okcdaftar/get_itempemeriksaan/"+id,
        columns: [
            { data: "id_pemeriksaan_ok" },
            { data: "jenis_tindakan" },
            { data: "operator" },
            { data: "vtot" },
            { data: "aksi" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
    });
}
			
	function get_operasi_header(id) {
		$.ajax({
			type:'GET',
			dataType: 'json',
			url:"<?php echo base_url('ok/okcdaftar/get_operasi_header')?>"+'/'+id,			
			success: function(data){
				$('#no_register').val(data.no_register);
				$('#kamar_ok').val(data.nmruang);
				$('#id_dokter').val(data.nm_dokter);
				$('#tgl_jadwal_ok').val(data.tgl_jadwal_ok);
				$('#intime_jadwal_ok').val(data.intime_jadwal_ok);
				if(data.outtime_jadwal_ok!='' || data.outtime_jadwal_ok!=null){
					$('#outtime_jadwal_ok').val(data.outtime_jadwal_ok);
				}
				
				$('#lap_ok').val(data.lap_ok);
				$('#cat_pr').val(data.cat_pr);
				//$('#lama_ok').val(data.lama_ok);
				$('#tind_ok').val(data.tind_ok);
				$('#type_anas').val(data.type_anas);
				$('#type_operasi').val(data.type_operasi);

				if(data.type_operasi=='' || data.type_operasi==null){
					document.getElementById('btn-cetak').disabled=true;
				}else{
					document.getElementById('btn-cetak').disabled=false;
				}

				if(data.diag_preop!='' && data.diag_preop!=null){
					$('#id_diagnosapreok').val(data.iddiag_preop+' - '+data.diag_preop);
					$('#diagnosapreok').val(data.iddiag_preop+'@'+data.diag_preop);
				}
				if(data.diag_postop!='' && data.diag_postop!=null){
					$('#id_diagnosapostok').val(data.iddiag_postop+' - '+data.diag_postop);
					$('#diagnosapostok').val(data.iddiag_postop+'@'+data.diag_postop);
				}
				
				$('#id_diagpreok').val(data.iddiag_preop);
				$('#id_diagpostok').val(data.iddiag_postop);
			},
			error: function(){
				alert("error");
			}
	    });
	}

	function cetak(){
    	window.open('<?php echo site_url('ok/okchasil/cetak_hasil');?>/'+idok, '_blank');    
	}

	function set_total() {
		var total = $("#biaya_ok").val() * $("#qty").val();	
		$('#vtot').val(total);
		$('#vtot_hide').val(total);
	}  

</script>
	<?php include('okvdatapasien.php');?>
	<section class="content-header">
			<div class="row">
				<div class="col-sm-12">
					<div class="card card-outline-info">	
						<div class="card-header" align="center">
							<h4  align="center" class="text-white">LAPORAN OPERASI | <?php echo $no_register;?></h4>
						</div>
						<div class="card-block" style="display:block;overflow:auto;">

							<!-- form -->
							
							<form class="form-horizontal" method="POST" id="formhasilok">
								<div class="col-sm-10">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register" id="no_register">
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">Jenis Anestesi</p>
									<div class="col-sm-8">
										<select id="type_anas" class="form-control js-example-basic-single" name="type_anas"  >
												<option value="" >-Pilih Jenis Anastesi-</option>
												<option value="TOPIKAL">Topikal</option>
												<option value="LOKAL">Lokal</option>
												<option value="SUB-CON">Sub-con</option>
												<option value="BLOCK">Block</option>
												<option value="GENERAL">Umum/General</option>
											</select>				
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">Jenis Operasi</p>
									<div class="col-sm-8">
										<select id="type_operasi" class="form-control js-example-basic-single" name="type_operasi"  >
												<option value="" >-Pilih Jenis Operasi-</option>
												<option value="KHUSUS">Khusus</option>
												<option value="BESAR">Besar</option>
												<option value="SEDANG">Sedang</option>
												<option value="KECIL">Kecil</option>
											</select>				
									</div>
								</div>
								<div class="form-group row">
				                  <p class="col-sm-2 form-control-label">Diagnosa Pre Op</p>
				                  <div class="col-sm-10">
									<input type="text" class="form-control input-sm auto_diagnosa_pasien1"  name="id_diagnosapreok" id="id_diagnosapreok" required style="width:400px;font-size:15px;">
									<input type="hidden" class="form-control " name="diagnosapreok" id="diagnosapreok">
									<input type="hidden" class="form-control " name="id_diagpreok" id="id_diagpreok">				
				                  </div>
				                </div>
								<div class="form-group row">
				                  <p class="col-sm-2 form-control-label">Diagnosa Post Op</p>
				                  <div class="col-sm-10">
									<input type="text" class="form-control input-sm auto_diagnosa_pasien2"  name="id_diagnosapostok" id="id_diagnosapostok" required style="width:400px;font-size:15px;">
									<input type="hidden" class="form-control " name="diagnosapostok" id="diagnosapostok">
									<input type="hidden" class="form-control " name="id_diagpostok" id="id_diagpostok">				
				                  </div>
				                </div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="no_register_lbl">Tindakan Operasi</p>
									<div class="col-sm-8">
										<textarea class="form-control" name="tind_ok" id="tind_ok" cols="30" rows="5" style="resize:vertical"></textarea>					
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="nmdokter">Dokter</p>
									<div class="col-sm-8">
												<input type="text" class="form-control" name="id_dokter" id="id_dokter" placeholder="Dokter" disabled>		
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="idkamar_operasi_lbl">Kamar Operasi</p>
									<div class="col-sm-8">
												<input type="text" class="form-control" name="kamar_ok" id="kamar_ok" placeholder="Kamar Operasi" disabled>												
									</div>
								</div>
								<div class="form-group row">
									<p class="col-sm-3 form-control-label" id="nmdokter">Tanggal Operasi *</p>
									<div class="col-sm-9">
										<div class="form-inline">
											<div class="form-group">
								                <div class='input-group date' >
													<input type="text" id="tgl_jadwal_ok" class="form-control" placeholder="Tanggal Operasi" name="tgl_jadwal_ok" required="" disabled="true">
													<span class="input-group-addon">
								                        <span class="fa fa-calendar-o"></span>
								                    </span>
												</div>&nbsp;
								                <div class='input-group clockpicker' >
													<input type="text" id="intime_jadwal_ok" class="form-control waktu_ok" placeholder="Jam Masuk Operasi" name="intime_jadwal_ok" required="">
													<span class="input-group-addon">
								                        <span class="fa fa-clock-o"></span>
								                    </span>
												</div>
												&nbsp;
												<div class='input-group clockpicker' >
													<input type="text" id="outtime_jadwal_ok" class="form-control waktu_ok" placeholder="Jam Selesai Operasi" name="outtime_jadwal_ok" required="true">
													<span class="input-group-addon">
								                        <span class="fa fa-clock-o"></span>
								                    </span>
												</div>&nbsp;												
											</div>											
								            <!-- <div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
								                    <input type='text' class="form-control" />
								                    <span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
								                </div>
								            </div> -->
										</div>
									</div>
								</div>
								<!--<div class="form-group row">
									<p class="col-sm-3 form-control-label"></p>
									<div class="col-sm-9">
										<div class="form-inline">
											<div class="form-group">								                
												<div class='input-group bootstrap-timepicker' >
													<input type="text" id="lama_ok" class="form-control" placeholder="Lama Operasi" name="lama_ok" required="true">
													<span class="input-group-addon">
								                        <span > Jam</span>
								                    </span>
												</div>
											</div>											
								            <!-- <div class="form-group">
								                <div class='input-group date' id='jadwal_operasi'>
								                    <input type='text' class="form-control" />
								                    <span class="input-group-addon">
								                        <span class="glyphicon glyphicon-calendar"></span>
								                    </span>
								                </div>
								            </div> 
										</div>
									</div>
								</div>-->
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="ket_lbl">Laporan Operasi</p>
									<div class="col-sm-8">
										<!-- <div class="form-inline">
											<div class="form-group"> -->
												<textarea class="form-control" name="lap_ok" id="lap_ok" cols="30" rows="5" style="resize:vertical"></textarea>
											<!-- </div>
										</div> -->
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="ket_lbl">Catatan Perawat Ruangan</p>
									<div class="col-sm-8">
										<!-- <div class="form-inline">
											<div class="form-group"> -->
												<textarea class="form-control" name="cat_pr" id="cat_pr" cols="30" rows="5" style="resize:vertical"></textarea>
											<!-- </div>
										</div> -->
									</div>
								</div>
																
								
								<div class="form-inline" align="right">
									<input type="hidden" class="form-control" value="<?php echo $id;?>" name="idoperasi_header" id="idoperasi_header">								
									<input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
									<div class="form-group">
										<button type="reset" class="btn btn-danger">Reset</button>&nbsp;
										<button type="submit" class="btn btn-primary">Simpan</button>&nbsp;
										<button type="button" id="btn-cetak" class="btn btn-success" onclick="cetak()">Cetak Laporan Operasi</button>
									</div>
								</div>
							</div>
							</form>

							<div class="col-sm-10" align="right">

								
							</div>

							<!-- table -->
									
									</div>									
									</div>																			
								</div>			
						</div>					
			
		</section>		

<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});
</script>