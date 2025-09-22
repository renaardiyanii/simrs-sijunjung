<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
?>
<br>
<?php $this->load->view("iri/data_pasien"); ?>
<?php // $this->load->view("iri/layout/all_page_js_req"); ?>

<script type='text/javascript'>
	var table_pasien; 
	var table_history; 

$(document).ready(function(){
	show_permintaan_diet('<?php echo $no_ipd; ?>');
    $('.select2').select2();
    $("#form_permintaan_diet").submit(function(event) {
      document.getElementById("btn-submit").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'gizi/insert_permintaan_diet'; ?>",
          dataType: "JSON",
          data: {"no_ipd" : "<?php echo $no_ipd; ?>","bed" : "<?php echo $data_pasien[0]['bed']; ?>","standar_diet" : $("#standar_diet").val().toString(),"catatan" : $("#catatan").val(),"bentuk_makanan" : $("#bentuk_makanan").val()},
          success: function(result) {   
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            if (result.metadata.code == '200') {
              table_history.ajax.reload(); 
              show_permintaan_diet('<?php echo $no_ipd; ?>');
              swal("Sukses", "Permintaan Diet Berhasil Disimpan.", "success");
            } else if (result.metadata.code == '402') {
              swal(result.metadata.message, "Harap isikan data jika ada perubahan permintaan diet.", "warning"); 
            } else {
              swal("Gagal Menyimpan Permintaan", "Silahkan COba Lagi.", "error");            
            }
          },
          error:function(event, textStatus, errorThrown) { 
            document.getElementById("btn-submit").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';                     
            swal("Gagal Menyimpan Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
          }
      });
      event.preventDefault();
    });
    table_history = $('#table-history').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],    
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('gizi/history_permintaan_diet')?>",
        "type": "POST",
        "data": {"no_ipd" : "<?php echo $no_ipd; ?>"}
      }
    });

	  
   	$('#tgl_tindakan').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		endDate: '0',	
	});
	$('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });

		$('#tanggal').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		});

	$('.js-example-basic-single').select2();

	$("#form_add_diet").submit(function(event) {
      document.getElementById("btn-diet").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
      $.ajax({
          type: "POST",
          url: "<?php echo base_url().'irj/rjcpelayanan/insert_dietpasien'; ?>",
          dataType: "JSON",
          data: $('#form_add_diet').serialize(),
          success: function(data){   
          if (data == true) {
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
              swal("Sukses", "Jenis Diet berhasil disimpan.", "success");
          } else {
            document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
          swal("Error", "Gagal menginput Jenis Diet. Silahkan coba lagi.", "error");            
          }
          },
          error:function(event, textStatus, errorThrown) { 
            document.getElementById("btn-diet").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
          },
          timeout: 0
      });
    event.preventDefault();
  });

	table_pasien = $('#table-pasien').DataTable({ 
      "processing": true,
      "serverSide": true,
      "order": [],
      // "language": {
      //   "searchPlaceholder": " No. SEP, Nama"
      // },
      "lengthMenu": [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
      "ajax": {
        "url": "<?php echo site_url('gizi/show_pasien_gizi').'/'.$no_ipd;?>",
        "type": "post"
      },
      "columnDefs": [{ 
        "orderable": false, //set not orderable
        "width": "15%",
        "targets": 6 // column index 
      }
      // ,{ "width": "18%", "targets": 3 },{ "width": "10%", "targets": 2 },{ "width": "7%", "targets": 0 }
      ],
   
    });

    var v00 = $("#forminputmenupasien").validate({
      rules: {
        iddiet: {
          required: true
        },
        ket_waktu: {
          required: true
        },
        tanggal:{
          required: true
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
          var formData = new FormData( $("#forminputmenupasien")[0] );
          $.ajax({
            type:'post',
            url: "<?php echo base_url('gizi/insert_gizipasien/')?>",
            type : 'POST', 
            data : formData,
            async : false,
            cache : false,
            contentType : false,
            processData : false,
            beforeSend:function()
            {
            },      
            complete:function()
            {
                //stopPreloader();
            },
            success:function(data)
            {       
                    alert("Data Berhasil Disimpan");                    
                    // console.log(data);
                    // tablegizipasien();
                    $("#forminputmenupasien")[0].reset();
                    table_pasien.ajax.reload();
            },
            error: function(){
                        alert("error");
            }
          });           
        }
    });
});
	
function form_tambah_tindakan(){
	alert("test");
}


$('tindakan').on('change', function (e) {
    var optionSelected = $("option:selected", this);
    var valueSelected = this.value;
    alert(valueSelected);
});

// moris below

function show_permintaan_diet(no_ipd)
  {
    $.ajax({
      type: "GET",
      url: "<?php echo site_url('gizi/show_permintaan_diet'); ?>/"+no_ipd,
      dataType: "JSON",      
      success: function(result){    
      console.log(result);     
        if (result != null) {    
          var standar_diet = result.standar.split(',');
          $('#standar_diet').select2().select2('val', [standar_diet]);
          $('#bentuk_makanan').val(result.bentuk).trigger('change');
          $('#catatan').val(result.catatan);
        }
      },
      error:function(event, textStatus, errorThrown) { 
        swal("Gagal Menampilkan Data Permintaan Diet",formatErrorMessage(event, errorThrown), "error");  
      }
    });
  }

function pilih_tindakan(val){
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_tindakan').val(temp[1]);
	$('#biaya_tindakan_hide').val(temp[1]);

	$('#biaya_alkes').val(temp[3]);
	$('#biaya_alkes_hide').val(temp[3]);

	$('#paket').val(temp[2]);
	var qty = $('#qtyind').val();
	var total = ((parseInt(qty) * (parseInt(temp[1])  + parseInt(temp[3]))));
	$('#vtot').val(total);



}

function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }

    return true;
}

function set_total(val){
	var biaya_tindakan = $('#biaya_tindakan').val();
	var biaya_alkes = $('#biaya_alkes_hide').val();
	var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();

	var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();

	var total = (parseInt(val) * (parseInt(biaya_tindakan) + parseInt(biaya_alkes)));
	var total_jatah_kelas = val * harga_satuan_jatah_kelas;
	$('#vtot').val(total);
	$('#vtot_kelas').val(total_jatah_kelas);
}

function insert_total(){
	var jumlah = $('#jumlah').val();

	// bawah
	//qty di set 1 karena hasil dari perhitungan sendiri


	var val = $('select[name=idtindakan]').val();
	var temp = val.split("-");
	var cara_bayar = "$data_pasien[0]['carabayar']";

	$('#biaya_tindakan').val(jumlah);
	$('#biaya_tindakan_hide').val(jumlah);
	var qty = 1;
	$('#qtyind').val(1)
	var total = qty * jumlah;
	$('#vtot').val(total);

	$.ajax({
	    type:'POST',
	    url:'<?php echo base_url("iri/rictindakan/get_tarif_by_jatah_id_kelas/"); ?>',
	    data:{
	    		'id_tindakan':temp[0],
	    		'cara_bayar':temp[0],
	    		'kelas':"<?php echo $data_pasien[0]['jatahklsiri']; ?>",
	    	},
	    success:function(data){
    		var obj = JSON.parse(data);
    		
    		if(!isEmpty(obj)){
    			$("#harga_satuan_jatah_kelas").val(obj[0]['total_tarif']);
    			$("#biaya_jatah_kelas").val(obj[0]['total_tarif']);
    			$('#vtot_kelas').val(obj[0]['total_tarif']);
    			$('#vtot').val(total - (obj[0]['total_tarif'] * qty) );
    			$('#biaya_tindakan').val(jumlah - obj[0]['total_tarif']);
    		}else{
    			$("#harga_satuan_jatah_kelas").val('0');
    			$("#biaya_jatah_kelas").val('0');
    			//$('#vtot').val('0');
    		}
	    }
	});

	//alert(jumlah);
}

function delete_menu(id) {       
  swal({
        title: "Hapus Menu",
        text: "Hapus Menu tersebut?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya (hapus)",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
        }, function() {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'gizi/delete_menu/'; ?>"+id,
            dataType: "JSON",                    
            success: function(data){  
              if (data == true) {
                table_pasien.ajax.reload();
                swal("Sukses", "Menu berhasil dihapus.", "success");
              } else {
                swal("Error", "Gagal menghapus Menu. Silahkan coba lagi.", "error");            
              }
            },
            error:function(event, textStatus, errorThrown) {    
                swal("Error", "Gagal Menghapus Data.", "error");
                console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });           
      });   
}
</script>

<div class="row">
	<div class="col-lg-12">
		<div class="ribbon-wrapper card">
		    <div class="ribbon ribbon-info">
		        Pelayanan Pasien
		    </div>		            
			
			<div class="p-20">
				<ul class="nav nav-tabs customtab" role="tablist">
	                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tindak_pasien" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">TINDAKAN</span></a> </li>
	                      
	                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#gizi_pasien" role="tab" aria-expanded="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">PERMINTAAN DIET GIZI</span></a> </li> 
	   			 </ul>	
                           					 
			<div class="tab-content">
				<div id="tindak_pasien" class="tab-pane active" role="tabpanel">
					<div class="col-lg-10" style="margin: 0 auto;">	
					<div class="row">
						<div class="col-sm-12">
						<br>    								
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan'); ?>" method="post">
								<div class="form-group row">
								  	<label for="prop" class="col-md-2 col-form-label">Tindakan</label>
								  	<div class="col-md-6">
								    	<select id="prop" class="js-example-basic-single form-control" name="idtindakan" id="idtindakan" onchange="pilih_tindakan(this.value)" required style="min-width: 500px">
											<option value="">-Pilih Tindakan-</option>
												<?php foreach($list_tindakan as $r){
												?>	
												<option value="<?php echo $r['idtindakan'].'-'.$r['total_tarif'].'-'.$r['paket'].'-'.$r['tarif_alkes'] ; ?>"><?php echo $r['idtindakan']." - ".$r['nmtindakan']." | Rp.".number_format($r['total_tarif'], 2 , ',' , '.' );?></option>;
												<?php
												}
												?>
										</select>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label class="col-md-2 col-form-label">Pelaksana</label>
								  	<div class="col-md-6">
								    	<select class="form-control js-example-basic-single" name="operatorTindakan" required style="min-width: 500px">
											<option value="">-Pilih Pelaksana-</option>											
											<?php foreach($list_dokter as $r){
											?>	
											<option value="<?php echo $r['id_dokter'] ; ?>"><?php echo $r['nm_dokter'] ;?></option>;
											<?php
											}
											?>		
										</select>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label class="col-md-2 col-form-label">Waktu Tindakan</label>
								  	<div class="col-md-3">
								    	<div class='input-group date' id='tgl_tindakan'>
											<input type="text" id="tgl_tindakan" class="form-control" placeholder="Tanggal Tindakan" name="tgl_tindakan" required="" value="<?php echo date('Y-m-d')?>">
											<span class="input-group-addon">
								                <span class="fa fa-calendar"></span>
								            </span>
										</div>
								  	</div>
								</div>
								
								<div class="form-group row">
								  	<label class="col-md-2 col-form-label">Biaya Tindakan</label>
								  	<div class="col-md-4">
								  		<div class='input-group' >
								  			<span class="input-group-addon">
								                <span>Rp</span>
								            </span>
									    	<input type="number" min=0 class="form-control"  name="biaya_tindakan" id="biaya_tindakan" disabled>
											<input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
										</div>
								  	</div>
								</div>
								<div class="form-group row">
								  	<label class="col-md-2 col-form-label">Biaya Alkes</label>
								  	<div class="col-md-4">
								  		<div class='input-group' >
								  			<span class="input-group-addon">
								                <span>Rp</span>
								            </span>
								    		<input type="number" min=0 class="form-control"  name="biaya_alkes" id="biaya_alkes" disabled>
											<input type="hidden" class="form-control" name="biaya_alkes_hide" id="biaya_alkes_hide">
										</div>
								  	</div>
								</div>
								<!-- <div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_biaya_poli">Biaya Jatah Kelas</p>
									<div class="col-sm-8">
										<input type="number" min=0 class="form-control"  name="biaya_jatah_kelas" id="biaya_jatah_kelas" disabled>
									</div>
								</div> -->
								<div class="form-group row">
								  	<label class="col-md-2 col-form-label">Qty</label>
								  	<div class="col-md-2">
								    	<input type="number" class="form-control" value="1" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)">
								  	</div>
								</div>	
								<div class="form-group row">
								  	<label class="col-md-2 col-form-label">Total</label>
								  	<div class="col-md-4">
								  		<div class='input-group' >
								  			<span class="input-group-addon">
								                <span>Rp</span>
								            </span>
								    		<input type="text" class="form-control" name="vtot" id="vtot" disabled>	
								    		<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
								    	</div>	
								  	</div>
								</div>						
								<!-- *) Diisi hanya untuk tindakan Operasi Paket<div class="form-group row">
									<p class="col-sm-4 form-control-label" id="lbl_vtot">Total Jatah Kelas</p>
									<div class="col-sm-8">
										<input type="text" class="form-control" name="vtot_kelas" id="vtot_kelas" disabled>								<input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
									</div>
								</div> -->
								<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
								<input type="hidden"  name="harga_satuan_jatah_kelas" id="harga_satuan_jatah_kelas" />
								<input type="hidden"  name="paket" id="paket" />
								<div class="form-group row">
								  	<div class="offset-md-2 col-md-10">
								    	<button type="reset" class="btn btn-danger">Reset</button>
										<button type="submit" class="btn btn-primary">Tambah</button>
								  	</div>
								</div>								
							</form>

							<form name="Calc">
								<TABLE BORDER=4>
								<TR>
								<TD>
								<INPUT TYPE="text"   NAME="Input" Size="16" id="jumlah">
								<br>
								</TD>
								</TR>
								<TR>
								<TD>
								<INPUT TYPE="button" NAME="one"   VALUE="  1  " OnClick="Calc.Input.value += '1'">
								<INPUT TYPE="button" NAME="two"   VALUE="  2  " OnCLick="Calc.Input.value += '2'">
								<INPUT TYPE="button" NAME="three" VALUE="  3  " OnClick="Calc.Input.value += '3'">
								<INPUT TYPE="button" NAME="plus"  VALUE="  +  " OnClick="Calc.Input.value += ' + '">
								<br>
								<INPUT TYPE="button" NAME="four"  VALUE="  4  " OnClick="Calc.Input.value += '4'">
								<INPUT TYPE="button" NAME="five"  VALUE="  5  " OnCLick="Calc.Input.value += '5'">
								<INPUT TYPE="button" NAME="six"   VALUE="  6  " OnClick="Calc.Input.value += '6'">
								<INPUT TYPE="button" NAME="minus" VALUE="  -  " OnClick="Calc.Input.value += ' - '">
								<br>
								<INPUT TYPE="button" NAME="seven" VALUE="  7  " OnClick="Calc.Input.value += '7'">
								<INPUT TYPE="button" NAME="eight" VALUE="  8  " OnCLick="Calc.Input.value += '8'">
								<INPUT TYPE="button" NAME="nine"  VALUE="  9  " OnClick="Calc.Input.value += '9'">
								<INPUT TYPE="button" NAME="times" VALUE="  x  " OnClick="Calc.Input.value += ' * '">
								<br>
								<INPUT TYPE="button" NAME="clear" VALUE="  c  " OnClick="Calc.Input.value = ''">
								<INPUT TYPE="button" NAME="zero"  VALUE="  0  " OnClick="Calc.Input.value += '0'">
								<INPUT TYPE="button" NAME="DoIt"  VALUE="  =  " OnClick="Calc.Input.value = eval(Calc.Input.value)">
								<INPUT TYPE="button" NAME="div"   VALUE="  /  " OnClick="Calc.Input.value += ' / '">
								<br>
								<INPUT TYPE="button" NAME="Masukkan Perhitungan"   VALUE="Masukkan Perhitungan" OnClick="insert_total()">
								</TD>
								</TR>
								</TABLE>
							</form>							
								<br>
							<div class="table-responsive">
								<table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="dataTables-example" width="100%">
								  <thead>
									<tr>
									  <th>Tanggal</th>
									  <th>Tindakan</th>
									  <th>Pelaksana</th>
									  <th>Biaya Tindakan</th>
									  <th>Biaya Alkes</th>
									  <th>Qtyind</th>
									  <th>Total</th>
									  <th>Aksi</th>
									</tr>
								  </thead>
								  <tbody>
									<?php
										foreach($list_tindakan_pasien as $r){
									?>
										<tr>
											<td><?php echo $r['tgl_layanan'] ; ?></td>
											<td><?php echo $r['nmtindakan'] ; ?></td>
											<td><?php echo $r['nmdokter'] ; ?></td>
											<td>Rp. <?php echo number_format($r['tumuminap'] - $r['harga_satuan_jatah_kelas'],0) ; ?></td>
											<td>Rp. <?php echo number_format($r['tarifalkes'],0) ; ?></td>
											<td><?php echo $r['qtyyanri'] ; ?></td>
											<td>Rp. <?php echo number_format($r['vtot'] - $r['vtot_jatah_kelas'] + $r['tarifalkes'],0) ; ?></td>
											<td>
												<a href="<?php echo base_url(); ?>iri/rictindakan/hapus_tindakan_temp/<?php echo $r['id_jns_layanan'] ;?>/<?php echo $data_pasien[0]['no_ipd'];?>" class="btn btn-primary btn-xs">Hapus</a>
											</td>
										</tr>
									<?php
										}
									?>
								  </tbody>
								</table>
							</div><!-- table-responsive -->
							<form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/tambah_tindakan_real'); ?>" method="post">
								<br>
								<div class="form-inline" align="right" style="padding-right:20px;">
									<input type="hidden"  name="no_ipd_h" id="no_ipd_h" value="<?php echo $data_pasien[0]['no_ipd'];?>" />
									<div class="form-group">
										<button type="submit" class="btn btn-primary">Simpan</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
	

	<div id="gizi_pasien" class="tab-pane" role="tabpanel">
								
    <!-- Main content -->
    <div class="row">
    <div class="col-lg-12 col-md-12">
    	<br>
    
                <br>
            
                     
              <div class="col-sm-12">
            <form class="form-horizontal" method="POST" id="form_permintaan_diet">
	            <div class="form-group row">
	              <label for="standar_diet" class="col-3 col-form-label">Standar Diet</label>
	              <div class="col-9">
	                <select id="standar_diet" name="standar_diet" class="form-control select2" multiple="multiple" style="width:100%;" data-placeholder="">                    
	                    <?php 
	                      foreach($standar_diet as $row) { ?>
	                        <option value="<?php echo $row->standar; ?>"><?php echo $row->standar; ?></option>
	                    <?php } ?>
	                </select> 
	              </div>
	            </div>
	            <div class="form-group row">
	              <label for="bentuk_makanan" class="col-3 col-form-label">Bentuk Makanan</label>
	              <div class="col-9">
	                <select id="bentuk_makanan" name="bentuk_makanan" class="form-control select2"  style="width:100%;" required>
	                    <option value="">-- Pilih Bentuk Makanan --</option>
	                    <?php 
	                      foreach($bentuk_makanan as $row) { ?>
	                        <option value="<?php echo $row->kode; ?>"><?php echo $row->kode.' ('.$row->nm_bentuk.')'; ?></option>
	                    <?php } ?>
	                </select> 
	              </div>
	            </div>
	            <div class="form-group row">
	              <label for="catatan" class="col-3 col-form-label">Catatan</label>
	              <div class="col-9">
	                <textarea class="form-control" id="catatan" name="catatan" rows="6"></textarea>    
	              </div>
	            </div> 
	            <div class="form-group row">          
	              <div class="col-9 push-md-3">
	                <button type="submit" class="btn waves-effect waves-light btn-primary" id="btn-submit"><i class="fa fa-floppy-o"></i> Simpan</button>  
	              </div>
	            </div>            
	        </form>   
              <hr>
            <div class="table-responsive m-t-0">   
            <table id="table-history" class="display nowrap table table-hover table-bordered" cellspacing="0" width="100%">
              <thead>
              <tr>
                <th class="text-center">No.</th>
                <th>Standar Diet</th>
                <th class="text-center">Bentuk Makanan</th>
                <th>Catatan</th>  
                <th class="text-center">Waktu</th>  
                <th class="text-center">User</th>            
              </tr>
              </thead>
              <tbody>                
              </tbody>
            </table>   
            <!-- <table id="table-pasien" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Diet</th>
                  <th>Ruang</th>
                  <th>Tanggal</th>
                  <th>Waktu</th>
                  <th>Catatan</th>
                  <th class="text-center">Aksi</th>
                </tr>
                </thead>
                <tbody>                
                </tbody>
            </table> -->
            </div>
            
          </div>
          

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->     
    
  				</div>
					

    <!-- Main content -->
						    	<?php
									//include('form_diagnosa.php');
								?>				 
					</div>
				</div><!-- p-20 -->
			</div>  <!-- tab pane -->
		</div>
	</div>
</div> <!-- row -->

<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
	});
</script>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 
