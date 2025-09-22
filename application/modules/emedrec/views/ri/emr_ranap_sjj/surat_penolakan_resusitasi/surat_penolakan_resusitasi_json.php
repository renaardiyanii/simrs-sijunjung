<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SuratPenolakanResusitasi"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("surat_penolakan_resusitasi.json",FILE_USE_INCLUDE_PATH);?>;





var surat_penolakan_resusitasi = new Survey.Model(surveyJSON);



<?php 
if($penolakan_resusitasi){ 
      ?>
    surat_penolakan_resusitasi.data = <?php echo isset($penolakan_resusitasi->formjson)?$penolakan_resusitasi->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SuratPenolakanResusitasi").Survey({
    model: surat_penolakan_resusitasi,
    // onComplete: sendDataToServer
});
</script>