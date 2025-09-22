<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<div class="container">
    <div class="col-md-12">
		<?php echo $this->session->flashdata('success_msg'); ?>
	</div>
</div>
<div class="container">
    <div class="col-md-12">
		<?php echo $this->session->flashdata('success_msg_jenistindakan'); ?>
	</div>
</div>
<!-- <?php echo form_open('iri/upload_tarif_tindakan_excel_file');?> -->
<form action="upload_tarif_tindakan_excel_file" method="POST" enctype="multipart/form-data">
    <div class="container">
        
        <div class="row align-items-center">
            <div class="col-md-3"> 
                <div class="center">Format Excel Tindakan</div>
                <div class="form-group">              
                    <input type="file" name="tarifTindakanFile" class="form-control" id="tarifTindakanFile" accept=".xls,.xlsx,.csv">
                </div>
            </div>

            <!-- <div class="col-md-3"> 
            <div class="center">File Jenis Tindakan</div>
                <div class="form-group">              
                    <input type="file" name="jenisTindakanFile" class="form-control" id="jenisTindakanFile" accept=".xls,.xlsx,.csv">
                </div>
            </div> -->
            
            <div class="col-md-2"> 
                <div class="form-group">
                    <button class="btn btn-primary" onCLick = "">Upload</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="container">
        <div class="center">Jenis Tindakan File</div>
        <div class="row align-items-center">
            <div class="col-md-3"> 
                <div class="form-group">              
                    <input type="file" name="jenisTindakanFile" class="form-control" id="jenisTindakanFile" accept=".xls,.xlsx,.csv">
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="form-group">
                    <button class="btn btn-primary" onCLick = "uploadJenisTindakan()">Upload</button>
                </div>
            </div>
        </div>
    </div> -->
</form>
<!-- <?php echo form_close();?>     -->

<script>
    $(function() {
        
    });


    function uploadTarifTindakan(){
        var fileTarifTindakakn; 
        fileTarifTindakan  = document.getElementById("tarifTindakanFile").value;
        $.ajax({
		      url:"<?php echo base_url(); ?>tarif/cuploadtindakan/upload_tarif_tindakan_excel_file/",
		      method:"POST",
		      data: {
                "tarifTindakanFile" : fileTarifTindakan,
              },
		      processData:false,
		      contentType:false,
		      cache:false,
		      success:function(data){
		      	console.log(data);
		        // loadData();
		      }
		})
    }
</script>


<?php
   if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>