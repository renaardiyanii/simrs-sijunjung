<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?> 
<!-- <link rel="stylesheet" href="<?php echo site_url('asset/plugins/iCheck/flat/green.css'); ?>"> -->
<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/survey/survey.jquery.min.js') ?>"></script>
<style type="text/css">

	.demo-radio-button label{
		min-width:120px;
	}

</style>
<!-- <script src="<?php echo site_url('asset/plugins/iCheck/icheck.min.js'); ?>"></script> -->
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
					swal({
									title: "Selesai",
									text: "Laporan Operasi berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true
								},
								function () {
									window.location.reload();
								});			
						get_operasi_header(idok);
					},
				error: function(){
						alert("error");
					}
			    });
	        }
	    });	

		tableitem("<?php echo $id?>");

		$("#collapseOne").collapse('hide');
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
				$('#id_dokter2').val(data.nm_asis);
				$('#perawat_ins').val(data.perawat_instrumen);
				$('#dokter_anastesi').val(data.nm_dokter_anes);
				$('#perawat_anastesi').val(data.perawat_anas);
				$('#tgl_jadwal_ok').val(data.tgl_jadwal_ok);
				$('#intime_jadwal_ok').val(data.intime_jadwal_ok);
				if(data.outtime_jadwal_ok!='' || data.outtime_jadwal_ok!=null){
					$('#outtime_jadwal_ok').val(data.outtime_jadwal_ok);
				}
        		var base = "<?php echo base_url() ?>";
				var base_url = base+"download/ok/"+data.gambar_implant;
				$('#show_gambar_implant').attr("src",base+"download/ok/"+data.gambar_implant);
				console.log(base_url);
				$('#lap_ok').val(data.lap_ok);
				$('#cat_pr').val(data.cat_pr);
				$('#komplikasi').val(data.komplikasi);
				$('#jmlh_perdarahan').val(data.jmlh_perdarahan);
				$('#jmlh_transfuse').val(data.jmlh_transfuse);
				$('#di_pa_kan').val(data.di_pa_kan);
				$('#ins_pasca_bedah').val(data.ins_pasca_bedah);
				$('#obat_diberikan').val(data.obat_diberikan);
				$('#jaringan').val(data.jaringan);
				//$('#lama_ok').val(data.lama_ok);
				$('#tind_ok').val(data.tind_ok);
				$('#jns_anes').val(data.jns_anes);
				$('#type_operasi').val(data.type_operasi);
				$('#id_diagnosapreok').val(data.id_diagnosa+' - '+data.nama_diagnosa);

				if(data.type_operasi=='' || data.type_operasi==null){
					document.getElementById('btn-cetak').disabled=true;
				}else{
					document.getElementById('btn-cetak').disabled=false;
				}

				// if(data.diag_preop!='' && data.diag_preop!=null){
				// 	$('#id_diagnosapreok').val(data.iddiag_preop+' - '+data.diag_preop);
				// 	$('#diagnosapreok').val(data.iddiag_preop+'@'+data.diag_preop);
				// }
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
							<form class="form-horizontal" method="POST" id="formhasilok">
							<div class="col-sm-10">
									<input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register" id="no_register">

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nmdokter">Nama Ahli Bedah</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="id_dokter" id="id_dokter">		
									</div>
								</div>

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nm_dokter2">Nama Asisten</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="id_dokter2" id="id_dokter2">		
									</div>
								</div>

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nminstrumen">Nama Instrumen</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="perawat_ins" id="perawat_ins">		
									</div>
								</div>

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="nm_anestesi">Nama Ahli Anestesi</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="dokter_anastesi" id="dokter_anastesi">		
									</div>
								</div>

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="perawat_anestesi">Nama Perawat Anestesi</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="perawat_anastesi" id="perawat_anastesi">		
									</div>
								</div>

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="type_anas">Jenis Anestesi</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="jns_anes" id="jns_anes">		
									</div>
								</div>

								
								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label">Jenis Operasi</p>
									<div class="col-sm-8">
										<select id="type_operasi" class="form-control js-example-basic-single" name="type_operasi"  >
												<option value="" >-Pilih Jenis Operasi-</option>
												<option value="MAYOR">Mayor</option>
												<option value="MEDIUM">Medium</option>
												<option value="MINOR">Minor</option>
												<option value="EMERGENCY">Emergency</option>
												<option value="ELEKTIVE">Elektive</option>
												<option value="KHUSUS">Khusus</option>
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
										<p class="col-sm-2 form-control-label" id="komplikasi1">Komplikasi Yang di Temukan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="komplikasi" id="komplikasi">		
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="no_register_lbl">Nama / Tindakan Operasi</p>
									<div class="col-sm-8">
										<textarea class="form-control" name="tind_ok" id="tind_ok" cols="30" rows="5" style="resize:vertical"></textarea>					
									</div>
								</div>
								

								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="implant">Implant yang dipasang</p>
									<div class="col-sm-8">
										<!-- <input type="text" class="form-control" name="implant" id="implant"> -->
										<!-- <input type="checkbox" name="jumlah_obat[]" id="test" value="test">
                                        <label for="test">test</label> -->	
											<input name="implant" type="radio" id="YA"value="YA"/>
				                            <label for="YA" onClick="validate('YA')" style="font-weight:bold;">YA</label> <i class="fa fa-check" id="iya"></i>											
				                            <input name="implant" type="radio" id="TIDAK"value="TIDAK"/>
				                            <label for="TIDAK" onClick="validate('TIDAK')" style="font-weight:bold;">TIDAK</label> <i class="fa fa-check" id="ga"></i>   
									</div>
								</div>


								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="gambar_implant">No Seri</p>
									<div class="col-sm-8">
										<input type="file" class="form-control" name="gambar_implant" id="gambar_implant" >
									</div>
								</div>


								<div class="form-group row">
										<p class="col-sm-2 form-control-label" id="gambar_implant"></p>
									<div class="col-sm-8">
										<img src="" id="show_gambar_implant" alt="gambar belum di input" width="100px" height="100px">
									</div>
								</div>

								
								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="jmlh_perdarahan1">Jumlah Perdarahan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="jmlh_perdarahan" id="jmlh_perdarahan">					
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="jmlh_transfuse1">Jumlah Transfuse</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="jmlh_transfuse" id="jmlh_transfuse">				
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="jaringan1">Jaringan yang di eks/inc</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="jaringan" id="jaringan">				
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="di_pa_kan1">Di PA Kan</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="di_pa_kan" id="di_pa_kan">				
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
									<p class="col-sm-2 form-control-label" id="ket_lbl">Intruksi Pasca Bedah</p>
									<div class="col-sm-8">
										<!-- <div class="form-inline">
											<div class="form-group"> -->
												<textarea class="form-control" name="ins_pasca_bedah" id="ins_pasca_bedah" cols="30" rows="5" style="resize:vertical"></textarea>
											<!-- </div>
										</div> -->
									</div>
								</div>

								<div class="form-group row">
									<p class="col-sm-2 form-control-label" id="ket_lbl">Obat obatan yang diberikan</p>
									<div class="col-sm-8">
										<!-- <div class="form-inline">
											<div class="form-group"> -->
												<textarea class="form-control" name="obat_diberikan" id="obat_diberikan" cols="30" rows="5" style="resize:vertical"></textarea>
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
									
			
	</section>		


	<div id="accordion">
        <div class="card mt-2 mb-2 ">
            <div class="list-group list-group-flush">

				<div class="list-group-item" >
					<div class="card-header" id="headingOne"  data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
						<div class="row">
							<div class="img mr-3 ml-3 mt-2">
								<img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($checklist_keselamatan_operasi)?'check.png':'uncheck.png' ?>" alt="">
							</div>
							<div>
								<a>
								<span class="title" style="font-weight:medium;font-size:12pt">Cheklist Keselamatan Pasien Dikamar Operasi</span>
								</a><br>
								<span class="subtitle"><?php echo ($checklist_keselamatan_operasi)?'Pengisian Formulir Sudah Selesai':'Pengisian Formulir Belum Selesai' ?></span>
							</div>
						
						</div>
					</div>
			
			

					<div id="collapseOne" class="collapse show ml-2 mr-3 mt-1" aria-labelledby="headingOne"  data-parent="#accordion">
						<?php include(FCPATH.'application\modules\ok\views\formulir\checklist_keselamatan_operasi\checklist_keselamatan_pasien_operasi.php'); ?>
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

<script type="text/javascript">
$(document).ready(function() {
  $(".js-example-basic-single").select2();
});

document.getElementById("iya").style = 'display:none';
document.getElementById("ga").style = 'display:none';

$(document).on("click", "input[name='sex']", function(){
			thisRadio = $(this);
			if (thisRadio.hasClass("imCek")) {
				thisRadio.removeClass("imCek");
				thisRadio.prop('checked', false);
				document.getElementById("kekhususan_lainnya").disabled = true;
			} else { 
				thisRadio.prop('checked', true);
				thisRadio.addClass("imCek");
			};
		})

function validate(test) {
	if (test == 'YA') {
		document.getElementById("YA").checked = true;
		if (document.getElementById("YA").checked = true) {		
			document.getElementById("iya").style = 'display:';
			document.getElementById("ga").style = 'display:none';	
		}else{
			document.getElementById("iya").style = 'display:none';
			document.getElementById("ga").style = 'display:none';	
		}
	}else{
		document.getElementById("TIDAK").checked = true;
		if (document.getElementById("TIDAK").checked = true) {		
			document.getElementById("iya").style = 'display:none';
			document.getElementById("ga").style = 'display:';	
		}else{
			document.getElementById("iya").style = 'display:none';
			document.getElementById("ga").style = 'display:none';	
		}
	}
}

</script>