<?php 
$this->load->view('layout/header_form');
?>



<div class="card m-5">
    <div class="body">
    <div id="surveyRencanaPemulangan"></div>
    <button id="submitRencanaPemulangan" style="margin-left:5em;margin-top:2em;" class="btn btn-primary">Simpan</button>
    </div>
</div>



<script>
	
Survey.StylesManager.applyTheme("modern");
	
	var surveyJsonRencanaPemulangan =  <?php echo file_get_contents("rencana_pemulangan_pasien.json",FILE_USE_INCLUDE_PATH); ?>;

	var surveyRencanaPemulangan = new Survey.Model(surveyJsonRencanaPemulangan);
	surveyRencanaPemulangan.showNavigationButtons = false;
	surveyRencanaPemulangan.isSinglePage = true;
	
function sendDataToRencanaPemulangan(survey) {
	


			$.ajax({
            url: "<?php echo base_url('iri/rictindakan/insert_rencana_pemulangan/')?>",
            type : 'POST',
            data : {
                no_ipd:'<?php echo $no_ipd ;?>',
                formjson: JSON.stringify(survey.data),
            },
            datatype:'json',
        
            beforeSend:function()
            {
            },      
            complete:function()
            {
            //stopPreloader();
            },
            success:function(data)
            {
                // new swal('Berhasil!','Data Berhasil Disimpan','success');
                location.reload();
            },
                error: function(e){
                    new swal('Gagal!','Gagal Disimpan Karena ' + e,'error');
                    
                }
        });
   
}

	<?php
	if($rencana_pemulangan->num_rows()){
	?>
	surveyRencanaPemulangan.data = <?php echo $rencana_pemulangan->row()->formjson ?>;
	<?php } ?>
	
	$("#surveyRencanaPemulangan").Survey({
		model: surveyRencanaPemulangan,
		onComplete: sendDataToRencanaPemulangan
	});
	
	$('#submitRencanaPemulangan').click(function(){
        surveyRencanaPemulangan.completeLastPage();

	});
</script>