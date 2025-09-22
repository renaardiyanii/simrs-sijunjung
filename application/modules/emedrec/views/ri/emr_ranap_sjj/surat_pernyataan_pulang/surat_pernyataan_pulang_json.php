<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="SuratPernyataanPulang"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("surat_pernyataan_pulang.json",FILE_USE_INCLUDE_PATH);?>;





var surat_pernyataan_pulang = new Survey.Model(surveyJSON);



<?php 
if($aps){ 
      ?>
    surat_pernyataan_pulang.data = <?php echo isset($aps->formjson)?$aps->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#SuratPernyataanPulang").Survey({
    model: surat_pernyataan_pulang,
    // onComplete: sendDataToServer
});
</script>