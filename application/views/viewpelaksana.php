<?php $this->load->view("layout/header.php"); ?>
<br>

<script type='text/javascript'>
$(document).ready(function(){
	$('.js-example-basic-single').select2();
	var site="<?php echo base_url();?>";
	var v00 = $("#formcaripasien").validate({
      rules: {
        noregister: {
          required: true
        },
        jenisrawat:{
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
        //e.preventDefault();
        //var formData = $("#formcaripasien").serialize()
        
        var formData = new FormData( $("#formcaripasien")[0] );
        //alert($("#formcaripasien").serialize());
            $.ajax({
                url : site+'Jasa/cari_recordpelaksana',  // Controller URL
                type : 'POST',
                data : formData,
                async : false,
                cache : false,
                contentType : false,
                processData : false,
                beforeSend:function()
                {                    
                },
                success : function(data) {                    
                    document.getElementById('content').innerHTML=data;
                },
                error: function(){
                        alert("error");
                }
            });
        }
    });
});
</script>

<section class="content">
	<?php echo $this->session->flashdata('pesan');?>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-default">
					<div class="panel-heading" align="center">
						<h5>Laporan Pelaksana Pasien</h5>
					</div>
					<div class="panel-body">
						<form role="form" name="formcaripasien" id="formcaripasien" method="post" accept-charset="utf-8" enctype="multipart/form-data" >
                                <hr>
                                <div class="form-group">
                                  <label class="control-label col-sm-2" for="lbl_noregister">No Register<span class="required"> * </span>
                    </label>
                                  <div class="col-sm-4">
                                    <input type="text" placeholder="RJ/RI" id="noregister" name="noregister" class="form-control" autocomplete="off">
                                  </div>
                                </div>

                                <div class="form-group">
                                  <label class="control-label col-sm-2" for="lbl_jenisrawat">Jenis Rawat<span class="required"> * </span>
                    </label>
                                  <div class="col-sm-3">
                                    <select class="form-control" name="jenisrawat" id="jenisrawat" >
                                    <option value="">- Pilih Jenis Rawat -</option>
                                    <option value="irj" disabled="">Rawat Jalan/Darurat</option>
                                    <option value="iri">Rawat Inap</option>
                            </select>
                                    
                                  </div>                                  
           				<div class="clearfix" style="height: 10px;clear: both;"></div>
                       <div class="form-group"> 
                            <div class="col-sm-1">                        
                            <button type="submit" class="btn btn-primary btn-info-full" id="save" >Cari</button> 
                            </div>
                            <div class="col-sm-2"> 
                            <button type="reset" class="btn btn-warning btn-info-full"  >reset</button>
                            </div>
                        </div></div>
                        </form>
					</div>
					<div id="content" style="overflow:auto;margin:auto;width:98%;">
					</div>
				</div>
			</div>
			
		<!-- /Main content -->

	</div>

		
</section>
<?php $this->load->view("layout/footer.php"); ?>