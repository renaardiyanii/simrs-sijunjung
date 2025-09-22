<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SuratRujukan"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("surat_rujukan.json",FILE_USE_INCLUDE_PATH);?>;





var surat_rujukan = new Survey.Model(surveyJSON);



<?php 
if($sur_rujukan){ 
      ?>
    surat_rujukan.data = <?php echo isset($sur_rujukan->formjson)?$sur_rujukan->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SuratRujukan").Survey({
    model: surat_rujukan,
    // onComplete: sendDataToServer
});
</script>