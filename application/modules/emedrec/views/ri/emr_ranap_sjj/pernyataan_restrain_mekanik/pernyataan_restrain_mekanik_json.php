<?php 
$this->load->view('ri/layout/header_form');
?>
<style>

</style>


<div class="card m-5">
    <div class="body">
    <div id="PernyataanRestrainMekanik"></div>

    </div>
</div>

<script>


Survey.StylesManager.applyTheme("modern");

surveyJSON = <?php echo file_get_contents("pernyataan_restrain_mekanik.json",FILE_USE_INCLUDE_PATH);?>;





var pernyataan_restrain_mekanik = new Survey.Model(surveyJSON);



<?php 
if($per_restrain_mekanik){ 
      ?>
    pernyataan_restrain_mekanik.data = <?php echo isset($per_restrain_mekanik->formjson)?$per_restrain_mekanik->formjson:''; ?>
	<?php }else{ ?>
       
    <?php } ?>
    

   


$("#PernyataanRestrainMekanik").Survey({
    model: pernyataan_restrain_mekanik,
    // onComplete: sendDataToServer
});
</script>