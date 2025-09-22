<?php
// var_dump($user_dokter);
$data_konsultasi = '';
?>
<?php $this->load->view("layout/header_left"); ?>
<br>
<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/survey/survey.jquery.min.js') ?>"></script>

 

<script type='text/javascript'>
  $('#tombolkembali').on('click', function() {
		$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
	});

  $('#tombolkembalidokter').on('click', function() {
		$('.content').html('<div class="text-center"><span class="fa fa-refresh fa-spin"></span><h1>Please Wait ...</h1></div>');
	});
  
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

	  
   	// $('#tgl_tindakan').datepicker({
	// 	format: "yyyy-mm-dd",
	// 	autoclose: true,
	// 	todayHighlight: true,
	// 	endDate: '0',	
	// });
	$('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });

		// $('#tanggal').datepicker({
		// format: "yyyy-mm-dd",
		// autoclose: true,
		// todayHighlight: true,
		// });

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
  temp[1] = (temp[1] == ""?0:temp[1]);
  temp[3] = (temp[3] == ""?0:temp[3]);
	$('#biaya_tindakan').val(temp[1]);
	$('#biaya_tindakan_hide').val(temp[1]);
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
	var harga_satuan_jatah_kelas = $('#harga_satuan_jatah_kelas').val();
	var total = (parseInt(val) * (parseInt(biaya_tindakan)));
	var total_jatah_kelas = val * harga_satuan_jatah_kelas;
	$('#vtot').val(total);
	$('#vtot_kelas').val(total_jatah_kelas);
}

function insert_total(){
	var jumlah = $('#jumlah').val();

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
<section class="content">
  <div class="row">
    <div class="col-sm-6">
      <?php $this->load->view("iri/data_pasien");?>
    </div>
    <div class="col-sm-6">
        <div class="card card-outline-info ">
        <div class="card-header text-white" align="center" >Pelayanan Pasien</div>
        <div class="card-body p-5">
          <table class=" datatable table  table-striped">
            <thead>
                <tr>
                  <th>No.</th>
                  <th>Nama Form</th>
                  <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php $index=1; foreach($role_form as $val): ?>
                <tr>
                  <td><?= $index ?></td>
                  <td><?= $val->nama ?></td>
                  <td>
                    <div class="form-group row">
                    <?php if($val->views != NULL) { ?>
                      <a href="<?= base_url('iri/rictindakan/form'.'/'.$val->kode.'/'.$no_ipd); ?>" class="btn btn-primary btn-sm" target="_blank">Input</a>
                    <?php
                    }
                    ?>
                      <?php if($val->url_output != NULL) { ?>
                        <?php if($val->kode != 'cppt' && $val->kode != 'lab' && $val->kode != 'tindakan') { ?>
                          <a href="<?= base_url($val->url_output.'/'.$no_ipd.'/'.$data_pasien[0]['no_medrec'].'/'.$data_pasien[0]['no_cm']); ?>" class="btn btn-primary btn-sm" style="margin-left: 5px;" target="_blank">view</a>
                          <?php } else if($val->kode == 'lab') { ?>
                            <a href="<?= base_url($val->url_output.'/'.$data_pasien[0]['no_medrec']); ?>" class="btn btn-primary btn-sm" style="margin-left: 5px;" target="_blank">view</a>      
                          <?php } else if ($val->kode == 'cppt') { ?>
                            <a href="<?= base_url($val->url_output.'/'.$no_ipd.'/'.$data_pasien[0]['no_cm'].'/'.$data_pasien[0]['no_medrec']); ?>" class="btn btn-primary btn-sm" style="margin-left: 5px;" target="_blank">view</a>
                        <?php } else if($val->kode == 'tindakan') { ?>
                          <a href="<?= base_url($val->url_output.'/'.$no_ipd); ?>" class="btn btn-primary btn-sm" style="margin-left: 5px;" target="_blank">view</a>
                       
                         
                       <?php  }?>
                         
                     <?php
                      }
                      ?>
                    </div>
                  </td>
                </tr>
                <?php $index++; endforeach; ?>
              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>


<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<script src="<?= base_url('assets/survey/') ?>survey.jquery.min.js"></script>

<script>
	$(document).ready(function() {
		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
	});
</script>
<?php $this->load->view("layout/footer_left");?> 