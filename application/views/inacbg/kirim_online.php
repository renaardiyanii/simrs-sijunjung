<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<style type="text/css">
  	th { font-size: 14px; }  	
    .page-titles {
      display: none;
    }
</style>
<script type="text/javascript">
  var table_sep;  
  $(document).ready(function() {   
    $('#klaim-online-result').hide();
    $("#form_kirim").submit(function(event) {
        $("#btn-submit").html('<i class="fa fa-spinner fa-spin"></i> Processing...');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'inacbg/klaim/send_claim'; ?>",
            dataType: "JSON",
            data: $('#form_kirim').serialize(),
            success: function(result) {  
              $("#btn-submit").html('<i class="fa fa-paper-plane-o"></i> Kirim Klaim (Online)');
              if (result.metadata.code) {
                if (result.metadata.code == '200') {
                  $('#klaim-online-result').show();
                  var claim_count = result.response.data.length;
                  var sent = result.response.data.filter(x => x.kemkes_dc_status === "sent").length;
                  var unsent = result.response.data.filter(x => x.kemkes_dc_status === "unsent").length;  
                  $('#sent').html(sent);
                  $('#unsent').html(unsent);
                  $('#claim_count').html(claim_count);
                  if ($('#date_type').val() === '1') {
                    $('#posting_dt').html('posting_dt');
                    $('#admission_type').show();
                  } 
                  if ($('#date_type').val() === '2') {
                    $('#posting_dt').html('grouping_dt');
                    $('#admission_type').hide();
                  }
                  if ($('#jenis_rawat').val() === '2') {
                    $('#jns_rawat').html('Rawat Jalan');
                  } else if ($('#jenis_rawat').val() === '1') {
                    $('#jns_rawat').html('Rawat Inap');
                  } else {
                    $('#jns_rawat').html('Rawat Inap & Jalan');
                  }
                  $("#jenis_rawat").val("").change();
                  $("#date_type").val("").change();                
                  $('#form_kirim')[0].reset();                
                  swal("Sukses", "Kirim Klaim Online Berhasil.", "success");
                } else swal("Gagal Kirim Klaim Online.", result.metadata.message, "error");
              } else {
                swal("Error", "Gagal Kirim Klaim Online. Silahkan coba lagi.", "error"); 
              }
            },
            error:function(event, textStatus, errorThrown) { 
              $("#btn-submit").html('<i class="fa fa-paper-plane-o"></i> Kirim Klaim (Online)');
              swal("Gagal Kirim Klaim Online.", formatErrorMessage(event, errorThrown), "error");      
              console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
            }
        });
      event.preventDefault();
    });
    // $('#divider_klaim').hide();
    $('#tanggal_cari').daterangepicker({      
      locale: {
          format: 'YYYY/MM/DD'
      },
      buttonClasses: ['btn', 'btn-sm'],
      applyClass: 'btn-danger',
      cancelClass: 'btn-inverse'
    });
  });



</script>
<br>
<?php echo $this->session->flashdata('notification');?>
<div class="row">
  <div class="col-lg-12 col-md-12">    
    <div class="card card-outline-info">
      <div class="card-header">             
        <h4 class="m-b-0 text-white text-center">Kirim Klaim Online</h4> 
      </div>
      <div class="card-block">  
        <?php $attributes = array('id' => 'form_kirim');
        echo form_open('ina_cbg/klaim/send_claim',$attributes);?>
          <div class="form-group row m-b-0">
            <label for="example-text-input" class="col-2 col-form-label" style="font-size: 16px;max-width: 120px;">Pilih Data : </label>
            <div class="col-2">
              <select class="form-control" name="date_type" id="date_type">
                <option value="1" selected>Tanggal Pulang</option>
                <option value="2">Tanggal Grouping</option>
              </select>
            </div>
            <div class="col-2">
              <select class="form-control" name="jenis_rawat" id="jenis_rawat">
                <option value="2" selected>Rawat Jalan</option>
                <option value="1">Rawat Inap</option>
                <option value="3">Rawat Inap &amp; Jalan</option>
              </select>
            </div>
            <div class="col-3">
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control" name="tanggal_cari" id="tanggal_cari" value="<?php echo date('Y/m/d'); ?> - <?php echo date('Y/m/d'); ?>">
              </div>
            </div>
            <div class="col-3">
              <button type="submit" class="btn btn-danger" id="btn-submit"><i class="fa fa-paper-plane-o"></i> Kirim Klaim (Online)</button> 
            </div>
          </div>    
        <?php echo form_close();?> 
      </div>
    </div>        
  </div>
</div>

<div class="row" id="klaim-online-result">
  <hr id="divider_klaim">
  <div class="col-md-12">
    <div class="card">
      <div class="card-block">                             
        <div class="col-md-12">
          <h3 class="text-center"><b>Kirim Klaim (Online)</b></h3>          
          <div class="table-responsive m-t-30" style="clear: both;">
              <table class="table table-hover m-b-0">                 
                  <tbody>
                    <tr>
                        <td class="text-right" style="border-right: 1px solid #ededed;" width="40%"><span id="posting_dt"></span></td>
                        <td width="60%"><?php echo date('Y-m-d'); ?></td>
                    </tr>
                    <tr id="admission_type">
                        <td class="text-right" style="border-right: 1px solid #ededed;" width="40%">admission_type</td>
                        <td width="60%">outpatient</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="border-right: 1px solid #ededed;" width="40%">Jenis Rawat</td>
                        <td width="60%" id="jns_rawat"></td>
                    </tr>
                    <tr>
                        <td class="text-right" style="border-right: 1px solid #ededed;" width="40%">kemenkes_dc_status_cd</td>
                        <td width="60%">sent (<span id="sent"></span>)   unsent (<span id="unsent"></span>)</td>
                    </tr>
                    <tr>
                        <td class="text-right" style="border-right: 1px solid #ededed;" width="40%">claim_count</td>
                        <td width="60%"><span id="claim_count"></span></td>
                    </tr>
                    <tr>
                        <td class="text-right" style="border-right: 1px solid #ededed;" width="40%">kemenkes_dc_sent_dttm</td>
                        <td width="60%"><?php echo date('Y-m-d H:i:s'); ?></td>
                    </tr>                  
                    <tr>                        
                      <td></td>
                      <td></td>
                    </tr> 
                  </tbody>
              </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->


	<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="title_modal" aria-hidden="true" id="modal_update">
	    <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h4 class="modal-title" id="title_modal">Update SEP</h4>
	                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	            </div>
	            <div class="modal-body">
                   	<ul class="nav nav-tabs customtab" role="tablist">
                       	<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#data" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Catatan</span></a> </li>
                       	<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tglpulang" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Tanggal Pulang</span></a> </li>
                   	</ul>
                    <div class="tab-content">
                        <div class="tab-pane active p-20" id="data" role="tabpanel">
                        	<form class="form-horizontal" id="form_catatan">
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-2 col-form-label">Catatan</label>
								  <div class="col-sm-9">
								    <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-2 col-sm-9">	
								    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                        <div class="tab-pane  p-20" id="tglpulang" role="tabpanel">
                        	<form class="form-horizontal" id="form_tglpulang">
                        		<div class="form-group row">
								  <label for="example-number-input" class="col-sm-3 col-form-label">Tanggal Pulang</label>
								  <div class="col-sm-6">
								   	<input type="text" class="form-control" name="tgl_pulang" id="tgl_pulang">
								  </div>
								</div>
								<div class="form-group row">
								  <div class="offset-sm-3 col-sm-9">	
								    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil-square-o"></i> Update</button>
								  </div>
								</div>
                        	</form>
                        </div>
                    </div>                                 
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
	            </div>
	        </div>
	        <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	</div>
	<!-- /.modal Update SEP -->

<?php
  $this->load->view("layout/footer_horizontal");
?>